<?php

namespace App\Http\Livewire\Gig;

use App\Models\Gig\GigPlan;
use Livewire\Component;
use App\Models\Gig\Addon;

class GigCartAddons extends Component
{
    
    public $profile_id;
    public $plan_id;
    public $gig_title;
    public $downloadable;
    public $gig_author;
    public $addon_list = [];
    public $gig_addons = [];
    public $gig_plan = [];
    public $currency_symbol = '';
    protected $listeners = ['gigCartAddonsIds', 'updatedPlanId'];

    public function mount( $plan_id, $gig_title, $downloadable, $gig_author ){
        
        $user = getUserRole();
        $this->profile_id       = $user['profileId'];
        $currency               = setting('_general.currency');
        $currency_detail        = !empty( $currency)    ? currencyList($currency) : array();
        $this->plan_id          = $plan_id;
        $this->gig_title        = $gig_title;
        $this->downloadable     = $downloadable;
        $this->gig_author       = $gig_author;
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol'];
        }
    }

    public function render(){

        $this->gig_addons   = Addon::select('id', 'title', 'price', 'description')->where('author_id', $this->gig_author)->whereIn('id', $this->addon_list)->get()->toArray();
        $this->gig_plan     = GigPlan::select('gig_id','title', 'delivery_time', 'price')->where('id', $this->plan_id)->get()->toArray();
        return view('livewire.gig.gig-cart-addons');
    }
    
    public function updatedPlanId($id){
        $this->plan_id = $id;
    }

    public function gigCartAddonsIds($ids){
        $this->addon_list = $ids;
    }

    public function checkout(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( empty($this->gig_plan) ){

            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('gig.select_plan_err');
            $eventData['type']      = 'error';
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
            return false;
        }

        session()->forget('package_data');
        session()->forget('project_data');
        
        session()->put(['gig_data' => [
            'gig_addons'            => $this->gig_addons,
            'gig_id'                => $this->gig_plan[0]['gig_id'],
            'plan_id'               => $this->plan_id,
            'gig_author'            => $this->gig_author,
            'gig_title'             => $this->gig_title,
            'downloadable'          => $this->downloadable,
            'plan_type'             => $this->gig_plan[0]['title'],
            'plan_price'            => $this->gig_plan[0]['price'],
            'delivery_time'         => $this->gig_plan[0]['delivery_time'],
        ]]);
        return redirect()->route('checkout');
    }
}
