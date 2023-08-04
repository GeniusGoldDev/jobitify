<?php

namespace App\Http\Livewire\Admin\Gigs;

use App\Models\Gig\Gig;
use Livewire\Component;
use Livewire\WithPagination;

class Gigs extends Component
{
    use WithPagination;

    public $filter_gig          = '';
    public $search_gig          = '';
    public $date_format         = '';
    public $currency_symbol     = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];

    protected $paginationTheme  = 'bootstrap';

    protected $listeners = ['deleteGig'];
    

    public function render(){
       
        $gigs = Gig::select( 
            'id',
            'title',
            'author_id',
            'slug',
            'created_at',
            'status'
        );

        if( $this->filter_gig ){
            $gigs = $gigs->where('status', $this->filter_gig);
        }
        $gigs = $gigs->with([
            'categories' => function($query){
                $query->select('name', 'category_id');
                $query->orderBy('category_level', 'asc');
            },
            'gigAuthor' => function($query){
            $query->select('id', 'first_name', 'last_name');
        }]);
        
        if( !empty($this->search_gig) ){
            $gigs = $gigs->whereFullText('title', $this->search_gig);
        }
        $gigs = $gigs->orderBy('id', $this->sortby);
        $gigs = $gigs->paginate($this->per_page);

        return view('livewire.admin.gigs.gigs', compact( 'gigs'))->extends('layouts.admin.app');
    }

    
    public function mount(){
        
        $this->per_page_opt     = perPageOpt();
        $date_format            = setting('_general.date_format');
        $per_page_record        = setting('_general.per_page_record');
        $currency               = setting('_general.currency');
        $this->per_page         = !empty( $per_page_record )   ? $per_page_record : 10;
        $this->date_format      = !empty($date_format)    ? $date_format : 'm d, Y';
        $currency_detail        = !empty( $currency)  ? currencyList($currency) : array();
        
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }
    }

    public function updatedSearchGig(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedFilterGig(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedPerPage(){
        $this->resetPage(); // default function of pagination
    }

    public function deleteGig( $params ){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $gig = Gig::select('id', 'status')->with('gig_orders')->find( $params['id'] );

        if( !empty($gig) ){

            if( $gig->status == 'pending' ){
                $gig->delete();
                $this->resetPage();
            }elseif( $gig->status == 'publish' ){

                if( $gig->gig_orders->isEmpty() ){
                    $gig->delete();
                    $this->resetPage();
                }else{
                    $delete_flag = true;
                    foreach($gig->gig_orders as $single){
                        if( in_array($single->status , array('publish', 'hired', 'declined', 'queued', 'completed', 'refunded', 'disputed', 'rejected' )) ){
                            $delete_flag = false;
                            break;
                        }
                    }
                    if( $delete_flag ){
                        $gig->delete();
                        $this->resetPage();
                    }else{
                        $this->dispatchBrowserEvent('showAlertMessage', [
                            'type'      => 'error',
                            'title'     => __('general.error_title'),
                            'message'   => __('gig.gig_delete_error')
                        ]);
                        return;  
                    }
                }
            }else{
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => __('gig.gig_delete_error')
                ]);
                return;
            }
        }
    }

}
