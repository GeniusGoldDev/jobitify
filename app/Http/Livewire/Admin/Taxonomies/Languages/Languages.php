<?php

namespace App\Http\Livewire\Admin\Taxonomies\Languages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Taxonomies\Language;

class Languages extends Component
{

    use WithPagination;

    public $name, $edit_id, $description, $status;
    public $editMode            = false;
    public $search              = '';
    public $sortby              = 'asc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $selectedLanguages   = [];
    public $selectAll           = false;
    protected $paginationTheme  = 'bootstrap';

    protected $listeners = ['deleteConfirmRecord' => 'deleteLanguage'];

    public function mount(){

        $this->per_page_opt = perPageOpt();
        $per_page_record    = setting('_general.per_page_record');
        $this->per_page     = !empty( $per_page_record ) ? $per_page_record : 10;
    }

    public function render(){
        
        $languages = $this->Languages; 
        return view('livewire.admin.taxonomies.languages.languages', compact('languages'))->extends('layouts.admin.app');
    }

    public function getLanguagesProperty(){
        
        $languages = new Language;
        if( !empty($this->search) ){
            $languages = $languages->where(function($query){
                $query->whereFullText('name', $this->search);
                $query->orWhereFullText('description', $this->search);
            }); 
        }
        
        return $languages->orderBy('name', $this->sortby)->paginate($this->per_page);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value){
        if($value){
            $this->selectedLanguages = $this->Languages->pluck('id')->toArray();
        }else{
            $this->selectedLanguages = [];
        }
    }

    public function updatedselectedLanguages()
    {
        $this->selectAll = false;
    }

    private function resetInputfields()
    {
        $this->name                 = null;
        $this->status               = null;
        $this->description          = null;
        $this->selectedLanguages    = [];
        $this->selectAll            = false;
        $this->edit_id              = false;
    }

    public function edit($id)
    {
        $record = Language::findOrFail($id);
        $this->edit_id          = $id;
        $this->name             = $record->name;
        $this->description      = $record->description;
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

        $validated_data['name']         = sanitizeTextField($this->name);
        $validated_data['description']  = sanitizeTextField($this->description, true);

        if( !is_null($this->status) && in_array( $this->status, ['active', 'deactive'])){
            $validated_data['status']       = $this->status; 
        }

        $insertRecord = Language::updateOrCreate(['id'=> $this->edit_id],$validated_data);
        
        $eventData              = array();
        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $eventData['message']   = $this->edit_id ? __('languages.updated_msg') : __('languages.added_msg');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        $this->editMode = false;
        $this->resetInputfields();

    }

    public function deleteLanguage($params){
        
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
        if(!empty($params['id'])){
            $record         = Language::where('id', $params['id'] );
            $isDeleteRec    = $record->delete();
            
        } elseif(!empty($this->selectedLanguages)){
            $record         = Language::whereIn('id', $this->selectedLanguages);
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
