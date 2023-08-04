<?php

namespace App\Http\Livewire\Admin\Taxonomies\ExpertLevels;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Taxonomies\ExpertLevel;

class ExpertLevels extends Component
{
    use WithPagination;

    public $name, $status;
    public $search              = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $edit_id             = '';
    public $per_page_opt        = [];
    public $selectedExpertLevels= [];
    public $selectAll           = false;
    protected $paginationTheme  = 'bootstrap';

    protected $listeners = ['deleteConfirmRecord' => 'deleteExpertLevel'];

    public function mount()
    {
        $this->per_page_opt = perPageOpt();
        $per_page_record    = setting('_general.per_page_record');
        $this->per_page     = !empty( $per_page_record ) ? $per_page_record : 10;
    }

    public function render()
    {
        $expertLevels = $this->ExpertLevels; 
        return view('livewire.admin.taxonomies.expert-levels.expert-levels', compact('expertLevels'))->extends('layouts.admin.app');
    }
    
    public function edit($id){

        $record = ExpertLevel::findOrFail($id);
        $this->edit_id      = $id;
        $this->name         = $record->name;
        $this->status       = $record->status;
    }

    public function getExpertLevelsProperty(){

        $expert_levels = new ExpertLevel;
        if( !empty($this->search) ){
            $expert_levels = $expert_levels->whereFullText('name', $this->search); 
        }
        return $expert_levels->orderBy('id', $this->sortby)->paginate($this->per_page);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value){
        if($value){
            $this->selectedExpertLevels = $this->ExpertLevels->pluck('id')->toArray();
        }else{
            $this->selectedExpertLevels = [];
        }
    }

    public function updatedselectedExpertLevels()
    {
        $this->selectAll = false;
    }

    private function resetInputfields()
    {
        $this->edit_id              = null;
        $this->name                 = null;
        $this->status               = null;
        $this->selectedExpertLevels = [];
        $this->selectAll            = false;
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
        
        $validated_data['name']   = sanitizeTextField($this->name);
        
        if( !is_null($this->status) && in_array($this->status, ['active', 'deactive'])){
            $validated_data['status']       = $this->status; 
        }

        ExpertLevel::updateOrCreate(['id'=> $this->edit_id],$validated_data);
       
        $eventData              = array();
        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $eventData['message']   = __('expert_levels.added_msg');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        $this->resetInputfields();

    }

    public function deleteExpertLevel($params){
        
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
        if( ! empty( $this->selectedExpertLevels ) ){
            $record     = ExpertLevel::whereIn('id', $this->selectedExpertLevels);
            $isDeleteRec = $record->delete();
        }elseif(!empty($params['id'])){
            $record     = ExpertLevel::where('id', $params['id']);
            $isDeleteRec = $record->delete();
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
