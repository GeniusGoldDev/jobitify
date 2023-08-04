<?php

namespace App\Http\Livewire\Gig;

use App\Models\Gig\Gig;
use Livewire\Component;
use Livewire\WithPagination;

class GigList extends Component
{
    use WithPagination;
    
    public $profile_id;
    public $filter_by = '';
    public $currency_symbol = '';
    protected $listeners = ['deleteGig'];

    public function mount(){

        $user = getUserRole();
        $this->profile_id       = $user['profileId'];
        $currency               = setting('_general.currency');
        $per_page_record        = setting('_general.per_page_record');
        $this->per_page         = !empty( $per_page_record ) ? $per_page_record : 10;
        $currency_detail        = !empty( $currency)    ? currencyList($currency) : array();
      
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol'];
        }
    }

    public function render(){

        
        $gigs = Gig::select('id','author_id','title','slug','attachments','status')
                ->where('author_id', $this->profile_id)->with(['categories' => function($query){
            $query->select('gig_categories.id','name', 'category_level');
            $query->orderBy('category_level', 'asc');
        },'gig_plans:id,gig_plans.gig_id,price',
        'gig_orders:id,gig_id,status'
        ])->withCount('gig_visits')->withAvg('ratings','rating')->withCount('ratings')->orderBy('id', 'desc');

        if( in_array($this->filter_by, ['publish', 'draft']) ){
            $gigs  = $gigs->where('status', $this->filter_by);
        }
        
        $gigs = $gigs->paginate($this->per_page);
        
        return view('livewire.gig.gig-list', compact('gigs'))->extends('layouts.app');
    }

    public function updateStatus($status, $id){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $status = $status == 1 ? 'publish' : 'draft';
        $is_updated = Gig::where(['id' => $id, 'author_id' => $this->profile_id])->update(['status'=> $status]);
        $eventData              = array(); 
        $eventData['title']     = !empty($is_updated) ? __('general.success_title') : __('general.error_title');
        $eventData['type']      = !empty($is_updated) ? 'success' : 'error';
        $eventData['message']   = !empty($is_updated) ? __('gig.update_gig_status_msg') : __('general.error_msg');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }

    public function deleteGig($params){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        
        $gig_id                = !empty($params['id']) ? $params['id'] : '';
        $gig_info              = Gig::where(['id' => $gig_id,'author_id' => $this->profile_id])->with('gig_orders', function($query){
                                    $query->whereIn('status', ['hired','disputed','refunded','completed']);
                                })->select('id')->latest()->first();

        $continue_orders        = $gig_info->gig_orders->count();

        if(!empty($continue_orders) && $continue_orders > 0 ){
            $eventData              = array(); 
            $eventData['title']     = __('general.error_title');
            $eventData['type']      = 'error';
            $eventData['message']   = __('general.not_allowed_delete_gig');
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
            return;
        }
        $is_deleted = false;

        if( !empty($gig_info) && empty($continue_orders) ){
            $is_deleted = $gig_info->delete();
        }

        $eventData              = array(); 
        $eventData['title']     = !empty($is_deleted) ? __('general.success_title') : __('general.error_title');
        $eventData['type']      = !empty($is_deleted) ? 'success' : 'error';
        $eventData['message']   = !empty($is_deleted) ? __('gig.delete_gig') : __('general.error_msg');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }
}
