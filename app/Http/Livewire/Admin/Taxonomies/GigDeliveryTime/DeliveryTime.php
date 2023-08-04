<?php

namespace App\Http\Livewire\Admin\Taxonomies\GigDeliveryTime;

use Livewire\Component;
use App\Models\Gig\GigDeliveryTime;

class DeliveryTime extends Component
{
    public $name, $days, $edit_id, $status;
    public $editMode            = false;
    public $search              = '';
    public $sortby              = 'desc';
    private $per_page           = '';
    public  $per_page_opt       = [];
    public $selectedTimes       = [];
    public $selectAll           = false;
    protected $paginationTheme  = 'bootstrap';
    protected $listeners        = ['deleteConfirmRecord' => 'deleteTimes'];

    public function mount(){
        
        $this->per_page_opt = perPageOpt();
        $per_page_record    = setting('_general.per_page_record');
        $this->per_page     = !empty( $per_page_record ) ? $per_page_record : 10;
    }

    public function render(){

        $delivery_times = new GigDeliveryTime;
        if(!empty($this->search)){
            $delivery_times = $delivery_times->whereFullText('name', $this->search);
        }
        $delivery_times = $delivery_times->orderBy('id', $this->sortby)->paginate($this->per_page);
        return view('livewire.admin.taxonomies.gig-delivery-time.gig-delivery-time', compact('delivery_times'))->extends('layouts.admin.app');
    }

    private function resetInputfields()
    {
        $this->edit_id  = false;
        $this->name     = $this->days = $this->status= null;
        $this->selectedTimes = [];
    }

    public function updatedSelectAll($value){
        if($value){
            $this->selectedTimes = $this->Languages->pluck('id')->toArray();
        }else{
            $this->selectedTimes = [];
        }
    }


    public function edit($id){
        $record = GigDeliveryTime::findOrFail($id);
        $this->edit_id          = $id;
        $this->name             = $record->name;
        $this->days             = $record->days;
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
            'days'      => 'required|min:1|numeric',
        ]);

        $validated_data['name'] = sanitizeTextField( $this->name );
        $validated_data['days'] = sanitizeTextField( $this->days );

        if( !is_null($this->status) && in_array( $this->status, ['active', 'deactive'])){
            $validated_data['status']   = $this->status; 
        }

        GigDeliveryTime::updateOrCreate(['id'=>$this->edit_id], $validated_data);
        $eventData              = array(); 
        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $eventData['message']   = $this->edit_id ? __('project_location.updated_msg') : __('project_location.added_msg');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        $this->editMode = false;
        $this->resetInputfields();

    }

    public function deleteTimes($params){

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
            $record         = GigDeliveryTime::where('id', $params['id']);
            $isDeleteRec    = $record->delete();
        } elseif(!empty($this->selectedTimes)){
            $record         = GigDeliveryTime::whereIn('id', $this->selectedTimes);
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
