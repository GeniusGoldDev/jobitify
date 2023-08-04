<?php

namespace App\Http\Livewire\Admin\Taxonomies\ProjectLocations;

use Livewire\Component;
use App\Models\Taxonomies\ProjectLocation;

class ProjectLocations extends Component
{
    
    public $name, $edit_id, $status;
    public $editMode            = false;
    public $search              = '';
    public $sortby              = 'desc';
    
    public function render()
    {
        $locations = new ProjectLocation;
        if( !empty($this->search) ){
            $locations = $locations->whereFullText('name', $this->search); 
        }
        $locations = $locations->orderBy('id', $this->sortby)->get(); 
        return view('livewire.admin.taxonomies.project-location.project-location', compact('locations'))->extends('layouts.admin.app');
    }

    private function resetInputfields()
    {
        $this->name                 = null;
        $this->status               = null;
        $this->edit_id              = false;
    }

    public function edit($id){

        $record = ProjectLocation::findOrFail($id);
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
        if( !is_null($this->status) && in_array( $this->status, ['active', 'deactive'])){
            $validated_data['status']   = $this->status; 
        }

        ProjectLocation::updateOrCreate(['id'=>$this->edit_id], $validated_data);
        $eventData              = array(); 
        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $eventData['message']   = $this->edit_id ? __('project_location.updated_msg') : __('project_location.added_msg');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        $this->editMode = false;
        $this->resetInputfields();

    }

}
