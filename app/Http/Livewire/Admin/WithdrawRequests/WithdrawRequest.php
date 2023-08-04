<?php

namespace App\Http\Livewire\Admin\WithdrawRequests;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Seller\SellerWithdrawal;

class WithdrawRequest extends Component
{
    use WithPagination;

    public $filter_request      = '';
    public $search_request      = '';
    public $date_format         = '';
    public $currency_symbol     = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $account_info        = []; 
    public $request_id          = null; 
    public $payment_method      = null; 

    protected $paginationTheme  = 'bootstrap';
    protected $listeners = ['approveRequestConfirm' => 'approveRequest',];

    public function mount(){
        
        $this->per_page_opt     = perPageOpt();
        $per_page_record        = setting('_general.per_page_record');
        $date_format            = setting('_general.date_format');
        $currency               = setting('_general.currency');
        $this->per_page         = !empty( $per_page_record ) ? $per_page_record : 10;
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        $currency_detail        = !empty( $currency)  ? currencyList($currency) : array();
        
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }
    }

    public function render(){
        
        $requests = SellerWithdrawal::select( 'id', 'seller_id', 'amount', 'payment_method', 'detail', 'status','created_at' )
        ->with('User:id,image,first_name,last_name');

        if(!empty($this->search_request)){
            $requests = $requests->whereHas('User', function($query){
                $query->where(function($sub_query){
                    $sub_query->whereFullText('first_name', $this->search_request);
                    $sub_query->orWhereFullText('last_name', $this->search_request);
                });
            });
        }

        if( $this->filter_request ){
            $requests = $requests->where('status', $this->filter_request);
        }

        $requests = $requests->orderBy('id', $this->sortby);
        $requests = $requests->paginate($this->per_page);

        return view('livewire.admin.withdraw-requests.withdraw-request',compact( 'requests'))->extends('layouts.admin.app');
    }

    public function updatedSearchRequest(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedFilterRequest(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedPerPage(){
        $this->resetPage(); // default function of pagination
    }

    public function accountInfo( $id ){

        $account_info   = SellerWithdrawal::select('id','payment_method', 'detail')->find($id);
        if(!empty($account_info)){
            $this->payment_method   = $account_info->payment_method;
            $this->account_info     = unserialize($account_info->detail);
            $this->dispatchBrowserEvent('account-info-modal', array('modal' => 'show'));
        }
    }

    public function approveRequest( $params ){
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $project_detail = SellerWithdrawal::where('status', 'pending')->find( $params['id'] );
        $project_detail->update(['status' => 'completed']);
    }
}
