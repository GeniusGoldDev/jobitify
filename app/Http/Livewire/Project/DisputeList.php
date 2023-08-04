<?php

namespace App\Http\Livewire\Project;

use App\Models\Dispute;
use Livewire\Component;
use Livewire\WithPagination;

class DisputeList extends Component
{
    use WithPagination;

    public  $per_page, 
    $date_format, 
    $profile_id, 
    $userRole, 
    $currency_symbol,
    $search,
    $filter_status;

    public function mount() {

        $user = getUserRole();
        $this->profile_id       = $user['profileId']; 
        $this->userRole         = $user['roleName'];
        
        $date_format            = setting('_general.date_format');
        $per_page_record        = setting('_general.per_page_record');
        $currency               = setting('_general.currency');
        $this->per_page         = !empty( $per_page_record ) ? $per_page_record : 10;
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        $currency_detail        = !empty( $currency)  ? currencyList($currency) : array();
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }
    }

    public function render(){
        
        $statuses = [];
        if( empty($this->filter_status) ){
            $statuses = ['publish','declined','disputed','resolved','refunded'];
        } else {
            $statuses = [$this->filter_status];
        }
       
        $disputes = Dispute::where( function($query){
            $query->where('created_by', $this->profile_id)->orWhere('created_to', $this->profile_id);
        })->has('disputeCreator')->has('disputeReceiver')->with(['disputeCreator:id,first_name,last_name,role_id','disputeReceiver:id,first_name,last_name,role_id']);
        
        if(!empty($this->search)){
            $disputes = $disputes->where(function($query){
                $query->whereHas('disputeCreator', function($subQuery){
                    $subQuery->where('created_to', $this->profile_id);
                    $subQuery->where(function($child_query){
                        $child_query->whereFullText('first_name', $this->search);   
                        $child_query->orWhereFullText('last_name', $this->search); 
                        $child_query->orWhereFullText('tagline', $this->search); 
                        $child_query->orWhereFullText('description', $this->search);
                    });
                })->orWhereHas('disputeReceiver', function($subQuery){
                    $subQuery->where('created_by', $this->profile_id);

                    $subQuery->where(function($child_query){
                        $child_query->whereFullText('first_name', $this->search);   
                        $child_query->orWhereFullText('last_name', $this->search); 
                        $child_query->orWhereFullText('tagline', $this->search); 
                        $child_query->orWhereFullText('description', $this->search);
                    });
                });
            });
        }

        $disputes = $disputes->whereIn('status',$statuses)->orderBy('id', 'desc')->paginate($this->per_page);

        return view('livewire.project.dispute-list', compact('disputes'))->extends('layouts.app');
    }
}
