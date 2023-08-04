<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting\SiteSetting;
use App\Services\EscrowPayment;

class PaymentMethods extends Component
{
    public $escrow = [
        'status'                => 'off',
        'email'                 => '',
        'api_key'               => '',
        'api_url'               => 'https://api.escrow.com',
        'currency'              => '',
        'inspection_period'     => '',
        'fees_payer'            => '',
    ];

    public $stripe = [
        'status'                =>'off',
        'stripe_key'            => '',
        'stripe_secret'         => '',
        'stripe_webhook_secret' => '',
        'cashier_currency'      => 'USD',
    ];

    public $method_type         = '';
    public $available_methods   = array();
    public $payment_methods     = array();
    public $settings            = array();
    public $edit_method         = '';
    public $old_api_key         = '';
    public $old_url             = '';

    private $payment_method_settings = array();

    public function getSettings(){

        $settings = SiteSetting::select('meta_key','meta_value')->where(['setting_type'=> 'payment', 'meta_key' => 'payment_methods'])->first();
       
        if( !empty($settings) && !empty($settings->meta_value) ){

            $payment_methods = unserialize($settings->meta_value);
            $this->payment_method_settings  = $payment_methods;
            $this->method_type              = !empty($payment_methods['method_type']) ? $payment_methods['method_type'] : '';
            if(!empty($payment_methods)){
                foreach($payment_methods as $method => $record){

                    switch($method){
                        case 'escrow':
                            $escrow_settings = !empty( $record ) ? $record : array();
                            $this->setEscrowSetting($escrow_settings);
                            break;

                        case 'others':
                            foreach($record as $other_method => $method_record){
                                switch($other_method){
                                    case 'stripe':
                                        $stripe_settings = !empty( $method_record ) ? $method_record : array();
                                        $this->setStripeSetting($stripe_settings);
                                        break;

                                    default:
                                        break;
                                }
                            }

                            break;

                        default:
                        break;
                    }
                }
            }
        }

        if( $this->method_type == 'escrow' ) {
            $this->available_methods['escrow'] = array(
                'image'     => asset('images/payment_methods/escrow.png'),
                'name'      => __('settings.escrow_title'),
                'status'    => $this->escrow['status'] == 'on' ? true : false, 
            );
        } elseif($this->method_type == 'others') {
            $this->available_methods['stripe'] = array(
                'image'     => asset('images/payment_methods/stripe.png'),
                'name'      => __('settings.stripe_title'),
                'status'    => $this->stripe['status'] == 'on' ? true : false, 
            );
        }
    }

    public function setEscrowSetting($escrow_settings){
        $this->escrow['status']             = !empty($escrow_settings['status']) && $escrow_settings['status'] == 'on' ? true : false;
        $this->escrow['email']              = !empty($escrow_settings['email'])     ? $escrow_settings['email']     : '';
        $this->escrow['api_key'] = $this->old_api_key   = !empty($escrow_settings['api_key'])   ? $escrow_settings['api_key']   : '';
        $this->escrow['api_url'] = $this->old_url       = !empty($escrow_settings['api_url'])   ? $escrow_settings['api_url']   : 'https://api.escrow.com/';
        $this->escrow['currency']           = !empty($escrow_settings['currency'])  ? $escrow_settings['currency']  : 'USD';
        $this->escrow['inspection_period']  = !empty($escrow_settings['inspection_period'])     ? $escrow_settings['inspection_period']     : '1';
        $this->escrow['fees_payer']         = !empty($escrow_settings['fees_payer'])           ? $escrow_settings['fees_payer']           : 'seller';
    }


    public function setStripeSetting($stripe_settings){
        $this->stripe['status']                 = !empty($stripe_settings['status']) && $stripe_settings['status'] == 'on' ? true : false;
        $this->stripe['stripe_secret']          = !empty($stripe_settings['stripe_secret']) ? $stripe_settings['stripe_secret'] : '';
        $this->stripe['stripe_key']             = !empty($stripe_settings['stripe_key']) ? $stripe_settings['stripe_key'] : '';
        $this->stripe['stripe_webhook_secret']  = !empty($stripe_settings['stripe_webhook_secret']) ? $stripe_settings['stripe_webhook_secret'] : '';
        $this->stripe['cashier_currency']       = !empty($stripe_settings['cashier_currency']) ? $stripe_settings['cashier_currency'] : '';
    }

    public function editMethod($key){
        $this->edit_method = $key;

        $this->dispatchBrowserEvent('editMethod', );
    }

    public function resetField(){

    }
    
    public function mount(){
        $this->getSettings();
    }

    public function updatedAvailableMethods($value, $key){
        
        $method_type = explode(".", $key);
        if($method_type[0] == 'stripe') {
            $this->stripe['status'] = $value ? 'on' : 'off';
            $this->updateStripeSetting(true);
        }
    }


    public function saveMethod() {
        $this->validate([
            'method_type'             => 'required',
        ]);

        $this->available_methods    = [];
        if( $this->method_type == 'escrow' ) {
            $this->available_methods['escrow'] = array(
                'image'     => asset('images/payment_methods/escrow.png'),
                'name'      => __('settings.escrow_title'),
                'status'    => $this->escrow['status'] == 'on' ? true : false, 
            );
        } elseif($this->method_type == 'others') {
            $this->available_methods['stripe'] = array(
                'image'     => asset('images/payment_methods/stripe.png'),
                'name'      => __('settings.stripe_title'),
                'status'    => $this->stripe['status'] == 'on' ? true : false, 
            );
        }

        $payment_methods    = [];
        $settings           = SiteSetting::select('meta_key','meta_value')->where(['setting_type'=> 'payment', 'meta_key' => 'payment_methods'])->first();

        if( !empty($settings) && !empty($settings->meta_value) ){
            $payment_methods = unserialize($settings->meta_value);
        }
        $payment_methods['method_type']         = $this->method_type;

        $update = SiteSetting::select('id')->updateOrCreate(
            ['setting_type'=> 'payment','meta_key' => 'payment_methods'],
            ['setting_type'=> 'payment','meta_key' => 'payment_methods','meta_value' => serialize($payment_methods)]
        );

    }


    public function render()
    {
        $currency_opt               = currencyOptionForPayment();
        $inspection_day_opt         = inspectionPeriodOptions();

        $fee_paid_by_opt = [
           'seller' => __('settings.fee_paid_by_seller_opt'),
           'buyer'  => __('settings.fee_paid_by_buyer_opt'),
           'both'   => __('settings.fee_paid_by_both_opt'),
        ];

        return view('livewire.admin.payment.payment-methods', compact('currency_opt','inspection_day_opt','fee_paid_by_opt',))->extends('layouts.admin.app');
    }

    public function updatedEscrowSetting(){

        $data = array();
        $data['status']             = 'on';
        $data['email']              = sanitizeTextField( $this->escrow['email']);
        $data['api_key']            = sanitizeTextField( $this->escrow['api_key'] );
        $data['api_url']            = sanitizeTextField( $this->escrow['api_url'] );
        $data['currency']           = sanitizeTextField( $this->escrow['currency'] );
        $data['inspection_period']  = sanitizeTextField( $this->escrow['inspection_period'] );
        $data['fees_payer']         = sanitizeTextField( $this->escrow['fees_payer'] );

        $payment_methods    = [];
        $settings           = SiteSetting::select('meta_key','meta_value')->where(['setting_type'=> 'payment', 'meta_key' => 'payment_methods'])->first();

        if( !empty($settings) && !empty($settings->meta_value) ){
            $payment_methods = unserialize($settings->meta_value);
        }

        $payment_methods['escrow']      = $data;
        $payment_methods['method_type'] = $this->method_type;

        $update = SiteSetting::select('id')->updateOrCreate(
            ['setting_type'=> 'payment','meta_key' => 'payment_methods'],
            ['setting_type'=> 'payment','meta_key' => 'payment_methods','meta_value' => serialize($payment_methods)]
        );
        
        if( ! empty( $update ) ){
            if( $this->old_api_key != $data['api_key'] || $this->old_url != $data['api_url'] ){

                $escrow_obj = new EscrowPayment();
                $output     = $escrow_obj->manageWebhook();
                if( $output == 201 ){
                    $this->old_api_key   = $data['api_key'];
                    $this->old_url       = $data['api_url'];

                    $eventData['title']     = __('general.success_title');
                    $eventData['message']   = __('settings.created_webhook');
                    $eventData['type']      = 'success';
                    $this->edit_method = '';
                }else{
                    $eventData['title']     = __('general.success_title');
                    $eventData['message']   = __('settings.failed_webhook');
                    $eventData['type']      = 'error';
                }
            }else{
                $eventData['title']     = __('general.success_title');
                $eventData['message']   = __('general.success_message');
                $eventData['type']      = 'success';
            }
            clearCache();
        }else{
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';
        }
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }

    public function updateStripeSetting($isUpdateStatus = false){

        if(!$isUpdateStatus){
            $this->validate([
                'stripe.stripe_secret'          => 'required',
                'stripe.stripe_key'             => 'required',
            ],[
                'required'  => __('general.required_field'),
            ]);
            $status = !empty( $this->stripe['status'] ) ? 'on' : 'off';
        } else {
            $status = $this->stripe['status'];
        }
        

        $record = [
            'status'                => sanitizeTextField( $status ),
            'stripe_secret'         => sanitizeTextField( $this->stripe['stripe_secret'] ),
            'stripe_key'            => sanitizeTextField( $this->stripe['stripe_key'] ),
            'stripe_webhook_secret' => !empty($this->stripe['stripe_webhook_secret']) ? sanitizeTextField( $this->stripe['stripe_webhook_secret'] ) : null,
            'cashier_currency'      => sanitizeTextField( $this->stripe['cashier_currency'] ),
        ];
        
        $payment_methods    = [];
        $settings           = SiteSetting::select('meta_key','meta_value')->where(['setting_type'=> 'payment', 'meta_key' => 'payment_methods'])->first();

        if( !empty($settings) && !empty($settings->meta_value) ){
            $payment_methods = unserialize($settings->meta_value);
        }


        $payment_methods['others']['stripe']    = $record;
        $payment_methods['method_type']         = $this->method_type;

        $update = SiteSetting::select('id')->updateOrCreate(
            ['setting_type'=> 'payment','meta_key' => 'payment_methods'],
            ['setting_type'=> 'payment','meta_key' => 'payment_methods','meta_value' => serialize($payment_methods)]
        );

        if(!$isUpdateStatus){
            setEnvironmentValue([
                'STRIPE_KEY'            => sanitizeTextField( $this->stripe['stripe_key'] ),
                'STRIPE_SECRET'         => sanitizeTextField( $this->stripe['stripe_secret'] ),
                'STRIPE_WEBHOOK_SECRET' => sanitizeTextField( $this->stripe['stripe_webhook_secret'] ),
                'CASHIER_CURRENCY'      => sanitizeTextField( $this->stripe['cashier_currency'] ),
            ]);
        }

        if($update){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.success_message');
            $eventData['type']      = 'success';
            $this->edit_method      = '';
        }else{
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';
        }
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        return redirect('clear-cache');
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
            'escrow.status'             => 'required',
            'escrow.email'              => 'required|email',
            'escrow.api_key'            => 'required',
            'escrow.api_url'            => 'required',
            'escrow.currency'           => 'required',
            'escrow.inspection_period'  => 'required',
            'escrow.fees_payer'         => 'required',
        ],[
            'required'  => __('general.required_field'),
            'email'     => __('general.invalid_email'),
        ]);
        $this->updatedEscrowSetting();
    }
}
