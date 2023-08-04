<?php

namespace App\Http\Livewire\Admin\Taxonomies\Skills;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Taxonomies\Skill;
 
class Skills extends Component
{
    use WithPagination, WithFileUploads;

    public $editMode = false;
    public $name, $description, $edit_id, $image, $slug, $status, $parent_skill_name;

    public $old_image          = array();
    public $search              = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $parentId            = null; 
    public $delete_id           = null; 
    public $selectedSkills      = [];
    public $selectAll           = false;
    public $allowImageSize      = false;
    public $allowImageExt       = false;
    protected $paginationTheme  = 'bootstrap';
    public $isSelectedSkill      = true;
    protected $listeners = ['deleteConfirmRecord' => 'deleteSkill'];
    
    public function mount(){
        
        $this->per_page_opt     = perPageOpt();
        $per_page_record        = setting('_general.per_page_record');
        $image_file_ext         = setting('_general.image_file_ext');
        $image_file_size        = setting('_general.image_file_size');
        $this->per_page         = !empty( $per_page_record ) ? $per_page_record : 10;
        $this->allowImageSize   = !empty( $image_file_size ) ? $image_file_size : '3';
        $this->allowImageExt    = !empty( $image_file_ext ) ?  explode(',', $image_file_ext)  : ['jpg','png'];
    }

    public function render()
    {
        $this->isSelectedSkill   = true;
        if( empty($this->parent_skill_name)){
            $this->isSelectedSkill   = false;
        }
        
        $skills         = $this->Skills;
        $skills_tree    = Skill::tree()->get()->toTree();
        $allow_image_ext        = $this->allowImageExt;
        $allow_image_size       = $this->allowImageSize;

        return view('livewire.admin.taxonomies.skills.skills', compact('skills', 'skills_tree', 'allow_image_ext', 'allow_image_size'))->extends('layouts.admin.app');
    }

    public function getSkillsProperty(){

        $skills = new Skill;
        if( !empty($this->search) ){
            $skills = $skills->where(function($query){
                $query->whereFullText('name', $this->search);   
                $query->orWhereFullText('description', $this->search);
            });   
              
        }
        return $skills->orderBy('id', $this->sortby)->paginate($this->per_page);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedSelectAll($value){
        if($value){
            $this->selectedSkills = $this->Skills->pluck('id')->toArray();
        }else{
            $this->selectedSkills = [];
        }
    }

    public function updatedparentId($id){
       
       $skill_name =  Skill::where('id', $id)->pluck('name')->first();
        if($skill_name){
            $this->parent_skill_name = $skill_name;
        }
    }

    public function updatedselectedSkills(){
        $this->selectAll = false;
    }

    private function resetInputfields(){

        $this->name                     = null;
        $this->description              = null;
        $this->image                    = null;
        $this->old_image                = array();
        $this->parentId                 = null;
        $this->delete_id                = null;
        $this->slug                     = null;
        $this->status                   = null;
        $this->edit_id                  = null;
        $this->selectedSkills           = [];
        $this->selectAll                = false;
        $this->parent_skill_name        = null;
    }

    public function deleteRecord($id)
    {
        $this->delete_id = $id;
        $this->dispatchBrowserEvent('delete-skill-confirm');
    }

    public function deleteAllRecord()
    {
        $this->dispatchBrowserEvent('delete-skill-confirm');
    }

    public function removeImage()
    {
       $this->image = null;
       $this->old_image = array();
    }

    public function edit($id){

        $record = Skill::findOrFail($id);
        $this->edit_id      = $id;
        $this->name         = $record->name;
        $this->description  = $record->description;
        $this->old_image    = !empty($record->image) ? unserialize($record->image) : array();
        $this->parentId     = $record->parent_id;
        $this->status       = $record->status;
        $this->editMode     = true;
        $this->parent_skill_name = null;
        if($this->parentId ){
            $skill_name =  Skill::where('id', $this->parentId )->pluck('name')->first();
            if($skill_name){
                $this->parent_skill_name = $skill_name;
            }
        }
    }

    public function update(){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $validated_data  = $this->validate([
            'name'              => 'required|min:3',
            'image'             => 'nullable|image|mimes:'.join(',', $this->allowImageExt).'|max:'.$this->allowImageSize*1024,
        ],[
            'max'           => __('general.max_file_size_err',  ['file_size'=> $this->allowImageSize.'MB']),
            'mimes'         => __('general.invalid_file_type',['file_types'=> join(',', $this->allowImageExt)]),
        ]);

        
        $validated_data['name']         = sanitizeTextField($this->name);
        $validated_data['description']  = sanitizeTextField($this->description, true);
        $validated_data['slug']         = sanitizeTextField($this->name);
        $validated_data['parent_id']    = $this->parentId;  

        if( !is_null($this->status) && in_array( $this->status, ['active', 'deactive'])){
            $validated_data['status']   = $this->status; 
        }

        if( $this->image ){
            $image_path = $this->image->store('public/skills');
            $image_path = str_replace('public/', '', $image_path);
            $image_name = $this->image->getClientOriginalName();
            $mime_type  = $this->image->getMimeType();
            $imageObject = array(
                'file_name'  => $image_name,
                'file_path'  => $image_path,
                'mime_type'  => $mime_type,
            );

            $validated_data['image']  = serialize($imageObject);
        }else{
            $validated_data['image'] = !empty($this->old_image) ? serialize($this->old_image) : null;
        }

        $record = Skill::updateOrCreate(['id' => $this->edit_id ], $validated_data );
           
        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $eventData['message']   = $this->edit_id ? __('skill.updated_msg') : __('skill.added_msg');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);

        $this->resetInputfields();
        $this->editMode = false;
    }

    public function deleteSkill(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $record = '';
        if($this->selectedSkills){
            $record = Skill::whereIn('id', $this->selectedSkills);
        }elseif($this->delete_id){
            $record = Skill::where('id', $this->delete_id);
        }

        $record->delete();

        if( $record ){
            $eventData['title']     = __('general.success_title');
            $eventData['type']      = 'success';
            $eventData['message']   = __('skill.deleted_msg');
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }

        $this->resetInputfields();
    }
}
