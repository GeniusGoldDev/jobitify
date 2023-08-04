<?php

namespace App\Http\Livewire\Admin\Proposals;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Proposal\Proposal;

class Proposals extends Component
{
    use WithPagination;

    public $filter_proposal     = '';
    public $search_project      = '';
    public $date_format         = '';
    public $currency_symbol     = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $proposal_id         = null; 

    protected $paginationTheme  = 'bootstrap';
    protected $listeners = ['approveProposalConfirm' => 'approveProposal', 'deleteProposal'];

    public function render(){
       
        $proposals = Proposal::select( 
            'id',
            'proposal_amount',
            'author_id',
            'project_id',
            'payout_type',
            'special_comments',
            'created_at',
            'status'
        );

        $search_project = $this->search_project;

        $proposals = $proposals->with('project', function($query){
            $query->select( 
                'id',
                'project_title',
                'slug',
                'project_type',
                'project_min_price',
                'project_max_price',
            );
            $query->with('projectAuthor:id,first_name,last_name');
        })->whereHas('project', function($query) use($search_project){
            
            if( !empty($search_project) ){
                $query = $query->where(function($sub_query) use($search_project){
                    $sub_query->whereFullText('project_title', $search_project);   
                    $sub_query->orWhereFullText('project_description', $search_project);
                }); 
            }
            
        });

        $proposals = $proposals->with('proposalAuthor:id,first_name,last_name');

        if( $this->filter_proposal ){
            $proposals = $proposals->where('status', $this->filter_proposal);
        }
        
        $proposals = $proposals->where('status', '!=', 'draft');
        $proposals = $proposals->orderBy('id', $this->sortby);
        $proposals = $proposals->paginate($this->per_page);

        return view('livewire.admin.proposals.proposals', compact( 'proposals'))->extends('layouts.admin.app');
    }

    
    public function mount(){
        
        $this->per_page_opt     = perPageOpt();
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

    public function showComment($id){

        $specialComment = Proposal::select('special_comments')->find($id);
        if(!empty($specialComment)){
            $this->dispatchBrowserEvent('show-comment',['comment' => $specialComment->special_comments]);
        }
    }

    public function updatedSearchProject(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedFilterProposal(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedPerPage(){
        $this->resetPage(); // default function of pagination
    }

    public function confirmApprove( $id ){  
        $this->proposal_id = $id;
        $this->dispatchBrowserEvent('approve-proposal-confirm');
    }    

    public function approveProposal( $params ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $proposal_detail = Proposal::where('status', 'pending')->find( $params['id'] );
        if( !empty($proposal_detail) ){
            $proposal_detail->update(['status' => 'publish']);
        }
    }

    public function deleteProposal( $params ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $proposal = Proposal::whereIn('status', array('pending', 'publish'))->find( $params['id'] );
        if( !empty($proposal) ){
            $proposal->delete();
            $this->resetPage();
        }else{
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.error_title'),
                'message'   => __('proposal.proposal_delete_error')
            ]);
            return;
        }
    }
}
