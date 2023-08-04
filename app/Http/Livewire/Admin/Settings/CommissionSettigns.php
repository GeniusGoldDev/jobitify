<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting\SiteSetting;

class CommissionSettigns extends Component
{
    public $commission_types    = ['free', 'fixed', 'percentage', 'commission_tier'];
    public $commission_type     = 'free';
    public $fix_fixed_price     = '';
    public $fix_hourly_price    = '';
    public $per_fixed_price     = '';
    public $per_hourly_price    = '';
    public $currency_symbol     = '';
    public $commission_tiers    = [
        'fixed'     => [],
        'hourly'    => []
    ];

    public function mount()
    {
        $this->getSettings();
    }

    public function getSettings(){

        $getSetting             = getTPSetting(['payment'], ['commission_setting']);
        $currency               = setting('_general.currency');
        $currency               = !empty( $currency ) ? $currency : 'USD';
        $selected               = currencyList($currency);
        $this->currency_symbol  = $selected['symbol'];
        
        if( !empty($getSetting['commission_setting']) ){
            $data = unserialize($getSetting['commission_setting']);
            $this->commission_type = ! empty( $data) ? array_key_first($data) : '';
            if( ! empty( $data[$this->commission_type] ) ){
                $result = $data[$this->commission_type];
               
                if($this->commission_type == 'fixed' ){
                    $this->fix_fixed_price = $result['fixed'];
                    $this->fix_hourly_price = $result['hourly'];
                } elseif($this->commission_type == 'percentage' ){
                    $this->per_fixed_price = $result['fixed'];
                    $this->per_hourly_price = $result['hourly'];
                }elseif( $this->commission_type == 'commission_tier' ){
                    $this->commission_tiers = !empty( $result ) ? $result : null;
                }
            }

            $data = !empty( $data[$this->commission_type] ) ? $data[$this->commission_type] : '';
            $this->fixed_price  = 
            $this->hourly_price = !empty( $data[$this->commission_type] ) ? $data[$this->commission_type] : '';

        }
    }

    public function render()
    {
        $data = array();
        $data['hr_comm_range'] = commissionRange('hourly', $this->currency_symbol);
        $data['fix_comm_range'] = commissionRange('fixed', $this->currency_symbol);
      
        $data['comm_type_opt'] = array(
            'fixed'         => __('settings.comm_type_opt_fixed'),
            'percentage'    => __('settings.comm_type_opt_percentage'), 
        );

        return view('livewire.admin.settings.commission-settigns', $data )->extends('layouts.admin.app');
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
        
        $this->validate([
            'commission_type'                      => 'required',
            'fix_fixed_price'                      => 'sometimes|nullable|required_if:commission_type,fixed',
            'fix_hourly_price'                     => 'sometimes|nullable|required_if:commission_type,fixed',
            'per_fixed_price'                      => 'sometimes|nullable|required_if:commission_type,percentage',
            'per_hourly_price'                     => 'sometimes|nullable|required_if:commission_type,percentage',
            'commission_tiers.*.*.price_range'     => 'nullable|sometimes|required_if:commission_type,commission_tier',
            'commission_tiers.*.*.type'            => 'nullable|sometimes|required_if:commission_type,commission_tier',
            'commission_tiers.*.*.value'           => 'nullable|sometimes|required_if:commission_type,commission_tier',
        ],[
            'required'      => __('general.required_field'),
            'required_if'   => __('general.required_field'),
        ]);

       
        
        $data = array();
       
        if( $this->commission_type == 'fixed' ){
            $data['fixed'] = array(
                                    'fixed'     => sanitizeTextField( $this->fix_fixed_price ), // Number
                                    'hourly'    => sanitizeTextField( $this->fix_hourly_price ),
                                    );
        }elseif( $this->commission_type == 'percentage' ) {
            $data['percentage'] = array(
                                    'fixed'     => sanitizeTextField( $this->per_fixed_price ), // %
                                    'hourly'    => sanitizeTextField( $this->per_hourly_price ),
                                    );
        } elseif ( $this->commission_type == 'commission_tier' ){
            $data['commission_tier'] = $this->commission_tiers;
        } else {
            $data['free'] = 'free';
        }

        $serialized = serialize($data);
       
        $record = SiteSetting::select('id')->updateOrCreate(
            [
                'setting_type'  => 'payment', 
                'meta_key'      => 'commission_setting' 
            ],
            [ 
                'setting_type'  => 'payment',
                'meta_key'      => 'commission_setting', 
                'meta_value'    => $serialized,
            ]
        );
       
        if( ! empty( $record ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('settings.updated_record');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';
        }

        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        $this->resetInputfields($this->commission_type);
    }
    public function resetInputfields( $type ){

        if( $type == 'fixed'){
            $this->per_fixed_price = '';
            $this->per_hourly_price = '';
            $this->commission_tiers = [
                'fixed'     => [],
                'hourly'    => []
            ];
        } elseif( $type == 'percentage'){
            $this->fix_fixed_price = '';
            $this->fix_hourly_price = '';
            $this->commission_tiers = [
                'fixed'     => [],
                'hourly'    => []
            ];
        } elseif( $type == 'commission_tier') {
            $this->per_fixed_price = '';
            $this->per_hourly_price = '';
            $this->fix_fixed_price = '';
            $this->fix_hourly_price = '';
        }
    }

    public function removeCommission ( $type, $record_no ) {
        unset($this->commission_tiers[$type][$record_no]); 
    }

    public function addMoreCommission ( $type ) {
        
        $this->commission_tiers[$type][] = array(
            'price_range'   => '',
            'type'          => '',
            'value'         => '',
        );

        $this->dispatchBrowserEvent('addTier', array('record_no' => array_key_last($this->commission_tiers[$type]), 'type'=> $type ));
    }
}
