<?php

namespace App\Http\Livewire\Admin\Earnings;

use App\Models\Profile;
use App\Models\Project;
use Livewire\Component;
use App\Models\AdminPayout;
use Livewire\WithPagination;
use App\Models\Package\Package;
use App\Models\Proposal\Proposal;
use App\Models\Seller\SellerPayout;
use App\Models\Proposal\ProposalTimecard;
use App\Models\Proposal\ProposalMilestone;

class Earnings extends Component
{
    use WithPagination;

    public $filter_earning      = '';
    public $search_earning      = '';
    public $date_format         = '';
    public $currency_symbol     = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $transaction_detail  = [];
    public $modal_id    = '';
    protected $paginationTheme  = 'bootstrap';

    public function render(){

        $earnings = AdminPayout::select( 
            'id',
            'transaction_id',
            'amount',
            
        );

        $filter_earnings = $this->filter_earning;

        $earnings = $earnings->with('transaction', function($query){

            $query->select('id','trans_ref_no','invoice_ref_no','payment_type','payment_method','status', 'updated_at');
           
            $query->with('TransactionDetail', function($query){
                $query->select('id','transaction_id', 'amount', 'used_wallet_amt', 'currency');
            })->whereHas('TransactionDetail');

        })->whereHas('transaction', function($query) use($filter_earnings){
            if( $filter_earnings ){
                $query->where('status', $filter_earnings);
            }
        });

        $earnings = $earnings->orderBy('id', $this->sortby);
        $earnings = $earnings->paginate($this->per_page);

        return view('livewire.admin.earnings.earnings', compact( 'earnings'))->extends('layouts.admin.app');
    }

    public function mount(){
        
        $this->per_page_opt     = perPageOpt();
        $date_format            = setting('_general.date_format');
        $per_page_record        = setting('_general.per_page_record');
        $this->per_page         = !empty( $per_page_record )   ? $per_page_record : 10;
        $this->date_format      = !empty($date_format)    ? $date_format : 'm d, Y';
        
    }

    public function updatedFilterProject(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedPerPage(){
        $this->resetPage(); // default function of pagination
    }    

    public function earningDetail( $id ){
        
        $earnings = AdminPayout::select( 
            'id',
            'transaction_id',
        );
        $earnings = $earnings->with('transaction', function($query){

            $query->select(
                'id',
                'creator_id',
                'payment_method',
                'updated_at'
            );

            $query->with('TransactionDetail', function($query){
                $query->select('id','transaction_id', 'amount', 'used_wallet_amt', 'currency', 'transaction_type', 'type_ref_id');
            })->whereHas('TransactionDetail');

            $query->with('creator');
        })->whereHas('transaction', function($query) use($id){
            $query->where('id', $id);
        });

        $earnings = $earnings->first();

        if( !empty($earnings) ){
            
            $currency_symbol = '';
            $transaction_detail = [];

            $currency_detail = currencyList($earnings->transaction->TransactionDetail->currency);
            if( !empty($currency_detail) ){
                $currency_symbol = $currency_detail['symbol']; 
            }

            $transaction_detail['transaction_title']    = '';
            $transaction_detail['type']             = 'project';
            $transaction_detail['id']               = $earnings->transaction->id;
            $transaction_detail['date']             = $earnings->transaction->updated_at;
            $transaction_detail['buyer']            = $earnings->transaction->creator->full_name;
            $transaction_detail['total_amount']     = $earnings->transaction->TransactionDetail->amount + $earnings->transaction->TransactionDetail->used_wallet_amt;
            $transaction_detail['admin_amount']     = $earnings->transaction->TransactionDetail->amount;
            $transaction_detail['payment_method']   = $earnings->transaction->payment_method;
            $transaction_detail['currency']         = $currency_symbol;

            if( $earnings->transaction->TransactionDetail->transaction_type == '0' ){

                $transaction_detail['type'] = 'package';
                $package =  Package::select('title')->find($earnings->transaction->TransactionDetail->type_ref_id);
                if( !empty($package) ){
                    $transaction_detail['transaction_title'] = $package->title;
                }
            }elseif( $earnings->transaction->TransactionDetail->transaction_type == '1' ){

                $milestone =  ProposalMilestone::select('title', 'proposal_id')->find($earnings->transaction->TransactionDetail->type_ref_id);
                if( !empty($milestone) ){
                    
                    $proposal = Proposal::select('project_id')->find($milestone->proposal_id);
                    $project = Project::select('project_title')->find($proposal->project_id);
                    $transaction_detail['transaction_title'] = $milestone->title;
                    $transaction_detail['project_title']    = $project->project_title;
                }
            }elseif( $earnings->transaction->TransactionDetail->transaction_type == '2' ){

                $proposal = Proposal::select('project_id')->find( $earnings->transaction->TransactionDetail->type_ref_id );
                $project = Project::select('project_title')->find($proposal->project_id);
                $transaction_detail['transaction_title'] = $project->project_title;
            }elseif( $earnings->transaction->TransactionDetail->transaction_type == '3' ){
                
                $timecard =  ProposalTimecard::select('title', 'proposal_id')->find($earnings->transaction->TransactionDetail->type_ref_id);
                if( !empty($timecard) ){
                    
                    $proposal = Proposal::select('project_id')->find($timecard->proposal_id);
                    $project = Project::select('project_title')->find($proposal->project_id);
                    $transaction_detail['transaction_title'] = $timecard->title. ' '. __('general.hourly_timecard');
                    $transaction_detail['project_title']    = $project->project_title;
                }
            }

            if( $earnings->transaction->TransactionDetail->transaction_type != '0' ){
                $seller_payout = SellerPayout::where('transaction_id', $earnings->transaction->id)->first();
                if( !empty($seller_payout) ){
                    $transaction_detail['seller_amount']   = $seller_payout->seller_amount;
                    $transaction_detail['admin_amount']    = $seller_payout->admin_commission;
                    $seller_info = Profile::select('first_name', 'last_name')->find($seller_payout->seller_id);
                    $transaction_detail['seller']            =  $seller_info->full_name;
                }
            }
            $this->transaction_detail = $transaction_detail;
            $this->modal_id = time().'-popup';
            $this->dispatchBrowserEvent('transaction-detail-modal', ['modal_id' => $this->modal_id]);
        }
    }
}
