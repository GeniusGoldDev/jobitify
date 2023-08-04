<?php

namespace App\Http\Livewire\Admin\Taxonomies\GigCategories;

use App\Models\Taxonomies\GigCategory;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Str;

class GigCategories extends Component
{
    use WithPagination, WithFileUploads;

    public $editMode = false;
    public $name, $description, $edit_id, $image, $old_image, $slug, $status, $parent_cate_name;
    public $search              = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $delete_id           = null; 
    public $selectedCategories  = [];
    public $selectAll           = false;
    public $allowImageSize      = false;
    public $allowImageExt       = false;
    public $parentId            = null; 

    protected $paginationTheme  = 'bootstrap';

    protected $listeners = ['deleteConfirmRecord' => 'deleteCategory'];
    
    public function mount(){

        $this->per_page_opt     = perPageOpt();
        $per_page_record        = setting('_general.per_page_record');
        $image_file_ext         = setting('_general.image_file_ext');
        $image_file_size        = setting('_general.image_file_size');
        $this->per_page         = !empty( $per_page_record ) ? $per_page_record : 10;
        $this->allowImageSize   = !empty( $image_file_size ) ? $image_file_size : '3';
        $this->allowImageExt    = !empty( $image_file_ext ) ?  explode(',', $image_file_ext)  : ['jpg','png'];
    }
    
    public function render(){
       
        if( empty($this->parent_cate_name) ){
            $this->parent_cate_name = __('general.select');
        }

        $categories_tree = GigCategory::tree()->get()->toTree()->toArray();
        $categories_tree = hierarchyTree($categories_tree);
        addJsVars(['categories_tree' => $categories_tree]);
        $this->dispatchBrowserEvent('initDropDown', ['categories_tree' => $categories_tree, 'parentId' => $this->parentId   ]);

        $categories             = $this->Categories; // get mounted property
        $allow_image_ext        = $this->allowImageExt;
        $allow_image_size       = $this->allowImageSize;
        return view('livewire.admin.taxonomies.gig-categories.categories', compact( 'categories', 'categories_tree', 'allow_image_ext', 'allow_image_size' ))->extends('layouts.admin.app');
    }

    public function getCategoriesProperty(){ // mounted property
        
        $gig_categories = new GigCategory;
        if( !empty($this->search) ){
            $gig_categories = $gig_categories->where(function($query){
                $query->whereFullText('name', $this->search);   
                $query->orWhereFullText('description', $this->search);
            }); 
              
        }
        return $gig_categories->orderBy('id', $this->sortby)->paginate($this->per_page);
    }

    public function updatedSearch(){ // update variable value
        $this->resetPage(); // default function of pagination
    }

    public function updatedSelectAll($value){ // watch property

        if($value){
            $this->selectedCategories = $this->Categories->pluck('id')->toArray();
        }else{
            $this->selectedCategories = [];
        }
    }

    public function updatedselectedCategories(){
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
        $this->selectedCategories       = [];
        $this->selectAll                = false;
        $this->parent_cate_name         = null;
        $this->edit_id                  = null;
    }

    public function deleteRecord($id){

        $this->delete_id = $id;
        $this->dispatchBrowserEvent('delete-category-confirm');
    }

    public function deleteAllRecord(){
        $this->dispatchBrowserEvent('delete-category-confirm');
    }

    public function removeImage(){

       $this->image     = null;
       $this->old_image = array();
    }

    public function edit($id){
        
        $record = GigCategory::findOrFail($id);
        $this->edit_id      = $id;
        $this->name         = $record->name;
        $this->description  = $record->description;
        $this->old_image    = !empty($record->image) ? unserialize($record->image) : array();
        $this->parentId     = $record->parent_id;
        $this->status       = $record->status;
        $this->editMode     = true;
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
            'name'              => 'required|min:5',
            'image'             => 'nullable|image|mimes:'.join(',', $this->allowImageExt).'|max:'.$this->allowImageSize*1024,
        ],[
            'max'           => __('general.max_file_size_err',  ['file_size'=> $this->allowImageSize.'MB']),
            'mimes'         => __('general.invalid_file_type',['file_types'=> join(',', $this->allowImageExt)]),
        ]);

        $validated_data['name']         = sanitizeTextField($this->name);
        $validated_data['description']  = sanitizeTextField($this->description, true);
        $validated_data['slug']         = $validated_data['name'];
        $validated_data['parent_id']    = $this->parentId;

        if( !is_null($this->status) && in_array( $this->status, ['active', 'deactive']) ){
            $validated_data['status']   = $this->status; 
        }

        
        if( $this->image ){
            $image_path = $this->image->store('public/gig-categories');
            $image_path = str_replace('public/', '', $image_path);
            $image_name = $this->image->getClientOriginalName();
            $mime_type  = $this->image->getMimeType();
            
            
            $imageObject = array(
                'file_name'  => $image_name,
                'file_path'  => $image_path,
                'mime_type'  => $mime_type,
            );

            $validated_data['image']  = serialize($imageObject);

        }elseif(!empty($this->old_image)){
            $validated_data['image'] =!empty($this->old_image) ? serialize($this->old_image) : null;
        }

        $record = GigCategory::updateOrCreate(['id' => $this->edit_id ], $validated_data );

        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $eventData['message']   = $this->edit_id ? __('category.updated_msg') : __('category.added_msg');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        $this->emit('updatecategoryList');
        $this->resetInputfields();
        $this->editMode = false;
    }

    public function deleteCategory(){
        
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
        if($this->selectedCategories){
            $record = GigCategory::whereIn('id', $this->selectedCategories);
        }elseif($this->delete_id){
            $record = GigCategory::where('id', $this->delete_id);
        }

        $record->delete();

        if( $record ){
            $eventData['title']     = __('general.success_title');
            $eventData['type']      = 'success';
            $eventData['message']   = __('category.deleted_msg');
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }
        $this->resetInputfields();
    }
}
