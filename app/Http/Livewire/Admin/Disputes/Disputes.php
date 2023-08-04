<?php

namespace App\Http\Livewire\Admin\Disputes;

use App\Models\Dispute;
use Livewire\Component;
use Livewire\WithPagination;

class Disputes extends Component
{
    use WithPagination;

    public $search              = '';
    public $sortby              = 'desc';
    public $date_format        = 'F j, Y';
    public $filter_status       = '';
    public $dispute_id          = null;
    public $currency_symbol     = '';
    public $allowFileSize     = '';
    public $allowFileExt     = '';
    
    protected $queryString = [
        'dispute_id'  => ['except' => 0, 'as'=> 'id'],
    ];


    public function render()
    {
        $statuses = [];
        if( empty($this->filter_status) ){
            $statuses = ['disputed','resolved','refunded'];
        } else {
            $statuses = [$this->filter_status];
        }

        $disputes = Dispute::select('id','created_by','created_to','status','created_at')->with([
            'disputeCreator:id,first_name,last_name,role_id',
            'disputeReceiver:id,first_name,last_name,role_id'
        ]);

        if( !empty($this->search) ){
            $disputes = $disputes->where(function($query){
                $query->whereHas('disputeCreator', function($subQuery){
                    $subQuery->whereFullText('first_name', $this->search);   
                    $subQuery->orWhereFullText('last_name', $this->search); 
                    $subQuery->orWhereFullText('tagline', $this->search); 
                    $subQuery->orWhereFullText('description', $this->search); 
                })->orWhereHas('disputeReceiver', function($subQuery){
                    $subQuery->whereFullText('first_name', $this->search);   
                    $subQuery->orWhereFullText('last_name', $this->search); 
                    $subQuery->orWhereFullText('tagline', $this->search); 
                    $subQuery->orWhereFullText('description', $this->search);
                });
            });
        }

        $disputes =  $disputes->where('resolved_by', 'admin')->whereIn('status', $statuses)->orderBy('id', $this->sortby)->get();

        return view('livewire.admin.disputes.disputes', compact('disputes'))->extends('layouts.admin.app');
    }


    public function getDisputeInfo($id){
        if(!empty($id) && ($this->dispute_id != $id) ){
            $this->dispute_id = $id;
            $this->emit('updateDispute', $this->dispute_id);
        }
    }
}
