<?php

namespace App\Http\Livewire\Admin\Gigs;

use App\Models\Gig\GigOrder;
use Livewire\Component;
use Livewire\WithPagination;

class GigOrders extends Component
{
    use WithPagination;

    public $filter_gig      = '';
    public $search_gig      = '';
    public $date_format         = '';
    public $currency_symbol      = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];

    protected $paginationTheme  = 'bootstrap';
    protected $listeners = [ 'deleteGigOrder'];

    public function render(){

        $search_gig = $this->search_gig;

        $gig_orders = GigOrder::select(
            'id',
            'gig_id',
            'author_id',
            'plan_type',
            'plan_amount',
            'gig_addons',
            'gig_delivery_days',
            'gig_start_time',
            'status'
        ); 

        $gig_orders  =  $gig_orders->with(['gig' => function($query){
            $query->select('id', 'author_id','slug', 'title');
            $query->with([
                'categories' => function($query){
                    $query->select('name', 'category_id');
                    $query->orderBy('category_level', 'asc');
                },
                'gigAuthor' => function($query){
                $query->select('id', 'first_name', 'last_name');
            }]);
        },
        'orderAuthor:id,first_name,last_name' 
        ])->whereHas('gig', function($query) use($search_gig){
            
            if( !empty($search_gig) ){
                $query->whereFullText('title', $search_gig);
            }
        });

        if( !empty($this->filter_gig) ){
            $gig_orders  =  $gig_orders->where('status', $this->filter_gig);
        }else{
            $gig_orders  =  $gig_orders->whereIn('status' , array('hired','completed', 'disputed', 'refunded'));  
        }

        $gig_orders  =  $gig_orders->orderBy('id', $this->sortby)->paginate($this->per_page);

        return view('livewire.admin.gigs.gig-orders', compact( 'gig_orders'))->extends('layouts.admin.app');
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

    public function deleteGigOrder( $params ){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $gig_order = GigOrder::whereIn('status', array('pending', 'publish'))->find( $params['id'] );
        
        if( !empty($gig_order) ){

            $gig_order->delete();
            $this->resetPage();
        }else{

            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.error_title'),
                'message'   => __('gig.gig_order_delete_error')
            ]);
            return;
        }
    }

}
