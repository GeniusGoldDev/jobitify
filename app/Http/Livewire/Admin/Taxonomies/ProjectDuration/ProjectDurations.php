<?php

namespace App\Http\Livewire\Admin\Taxonomies\ProjectDuration;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Taxonomies\ProjectDuration;

class ProjectDurations extends Component
{
    use WithPagination;

    public $name, $edit_id, $status;
    public $editMode            = false;
    public $search              = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $selectedDurations   = [];
    public $selectAll           = false;
    protected $paginationTheme  = 'bootstrap';

    protected $listeners = ['deleteConfirmRecord' => 'deleteProjectDuration'];

    public function mount(){

        $this->per_page_opt = perPageOpt();
        $per_page_record    = setting('_general.per_page_record');
        $this->per_page     = !empty( $per_page_record ) ? $per_page_record : 10;
    }

    public function render(){
        
        $ProjectDurations = $this->ProjectDurations;
        return view('livewire.admin.taxonomies.project-duration.project-durations', compact('ProjectDurations'))->extends('layouts.admin.app');
    }

    public function getProjectDurationsProperty(){

        $project_durations = new ProjectDuration;
        if( !empty($this->search) ){
            $project_durations = $project_durations->whereFullText('name', $this->search); 
        }
        return $project_durations->orderBy('id', $this->sortby)->paginate($this->per_page);
    }

    public function updatedSearch(){

        $this->resetPage();
    }
    public function updatedSelectAll($value){
        if($value){
            $this->selectedDurations = $this->ProjectDurations->pluck('id')->toArray();
        }else{
            $this->selectedDurations = [];
        }
    }

    public function updatedselectedDurations(){
        $this->selectAll = false;
    }

    private function resetInputfields()
    {
        $this->edit_id                  = null;
        $this->name                     = null;
        $this->status                   = null;
        $this->selectedDurations        = [];
        $this->selectAll                = false;
    }
    
    public function edit($id){

        $record = ProjectDuration::findOrFail($id);
        $this->edit_id          = $id;
        $this->name   = $record->name;
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
            'name'    => 'required|min:3',
        ]);

        
        $validated_data['name']       = sanitizeTextField( $this->name );

        if( !is_null($this->status) && in_array( $this->status, ['active', 'deactive'])){
            $validated_data['status'] = $this->status; 
        }

        $insertRecord = ProjectDuration::updateOrCreate(['id'=>$this->edit_id],$validated_data);

        $eventData              = array(); 
        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $eventData['message']   = $this->edit_id ? __('project_duration.updated_msg') : __('project_duration.added_msg');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);

        $this->editMode = false;
        $this->resetInputfields();
        
    }

    public function deleteProjectDuration($params){
        
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
            $record         = ProjectDuration::where('id', $params['id']);
            $isDeleteRec    = $record->delete();
        } elseif(!empty($this->selectedDurations)){
            $record         = ProjectDuration::whereIn('id', $this->selectedDurations);
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
