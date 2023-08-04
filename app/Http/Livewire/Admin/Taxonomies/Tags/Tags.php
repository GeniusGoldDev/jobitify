<?php

namespace App\Http\Livewire\Admin\Taxonomies\Tags;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Taxonomies\Tag;

class Tags extends Component
{
    use WithPagination;
    public $name, $edit_id, $status;
    public $editMode            = false;
    public $search              = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $selectedTags    = [];
    public $selectAll           = false;
    protected $paginationTheme  = 'bootstrap';
    protected $listeners = ['deleteConfirmRecord' => 'deleteTags'];

    public function mount(){

        $this->per_page_opt = perPageOpt();
        $per_page_record    = setting('_general.per_page_record');
        $this->per_page     = !empty( $per_page_record ) ? $per_page_record : 10;
    }

    public function render(){ 

        $tags = new Tag;
        if( !empty($this->search) ){
            $tags = $tags->whereFullText('name', $this->search);
        }

        $tags = $tags->orderBy('id', $this->sortby)->paginate($this->per_page);
        return view('livewire.admin.taxonomies.tags.tags', compact('tags'))->extends('layouts.admin.app');
    }

    private function resetInputfields(){

        $this->name                 = null;
        $this->status               = null;
        $this->edit_id              = false;
        $this->selectedTags         = [];

    }
    
    public function edit($id){

        $record = Tag::findOrFail($id);
        $this->edit_id          = $id;
        $this->name             = $record->name;
        $this->status           = $record->status;
        $this->editMode         = true;
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

        $validated_data = $this->validate([
            'name'      => 'required|min:3',
        ]);

        $validated_data['name']         = sanitizeTextField( $this->name );
        $validated_data['slug']         = sanitizeTextField( $this->name );
        if( !is_null($this->status) && in_array( $this->status, ['active', 'deactive']) ){
            $validated_data['status']       = $this->status; 
        }

        Tag::updateOrCreate(['id'=>$this->edit_id], $validated_data);
        $eventData              = array(); 
        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $eventData['message']   = $this->edit_id ? __('general.updated_msg') : __('general.added_msg');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        $this->editMode = false;
        $this->resetInputfields();

    }

    public function deleteTags($params){
        
        $response = isDemoSite();
        
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $isDeleteRec = false;
        if( !empty($params['id']) ){
            $record         = Tag::where('id', $params['id']);
            $isDeleteRec    = $record->delete();
        } elseif(!empty($this->selectedTags)){
            $record         = Tag::whereIn('id', $this->selectedTags);
            $isDeleteRec    = $record->delete();
        }

        if($isDeleteRec){
            $eventData['title']     = __('general.success_title');
            $eventData['type']      = 'success';
            $eventData['message']   = __('general.delete_record');
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }

        $this->resetInputfields();
    }
}
