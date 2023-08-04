<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Models\UserWallet;
use App\Models\UserWalletDetail;
use App\Models\UserBillingDetail;
use App\Models\Seller\SellerPayout;
use App\Models\Seller\SellerWithdrawal;

class SellerPayoutMethods extends Component
{
    public $profile_id       = '';
    public $payoneer_email  = '';
    public $paypal_email    = '';
    public $escrow_email    = '';
    public $escrow_api_key  = '';
    public $method_type     = '';
    public $bankAccountInfo = [
        'title'             => '',
        'account_number'    => '',
        'bank_name'         => '',
        'routing_number'    => '',
        'bank_iban'         => '',
        'bank_bic_swift'    => '',
    ];
    public $default_selected    = '';
    public $currency_symbol     = '';
    public $withdraw_limit      = '';
    public $payout_type         = '';
    public $amount              = '';
    public $available_balance   = 0;
    public $payoutSettings      = [];


    public function render()
    {
        return view('livewire.components.seller-payout-methods');
    }

    public function mount($profile_id, $currency){
        $this->profile_id       = $profile_id;
        $this->currency_symbol  = $currency;
        $getSetting             = getTPSetting(['payment'], ['payment_methods']);
        $payment_methods        = !empty($getSetting['payment_methods']) ? unserialize($getSetting['payment_methods']) : [];
        $this->method_type      = !empty( $payment_methods['method_type'] ) ? $payment_methods['method_type'] : '';
        $billingRec             = UserBillingDetail::where('profile_id', $profile_id )->with('states')->first();
        $min_withdrawal_amt     = setting('_seller.min_withdrawal_amt');
        $this->withdraw_limit   = !empty($min_withdrawal_amt)   ? $min_withdrawal_amt : 0;
        $wallet                 = UserWallet::select('id', 'amount')->where('profile_id', $this->profile_id)->first();

        if( !empty($wallet) ){
            $total_earning              = UserWalletDetail::where('wallet_id', $wallet->id)->sum('amount');
            $this->available_balance    = $wallet->amount; 
        }
        
        if( !empty($billingRec->payout_settings) ){
            $payoutSettings = @unserialize($billingRec->payout_settings);
            
            if(!empty($payoutSettings)){
                $this->payoutSettings = $payoutSettings;
                
                foreach($payoutSettings as $settingType => $setting){
                    if( $settingType == 'escrow' ){
                        $this->escrow_email     = !empty( $setting['escrow_email'] )    ? $setting['escrow_email'] : '';
                        $this->escrow_api_key   = !empty( $setting['escrow_api'] )      ? $setting['escrow_api'] : '';
                    } elseif( $settingType == 'paypal' ){
                        $this->paypal_email = !empty( $setting['paypal_email'] ) ? $setting['paypal_email'] : '';
                    } elseif( $settingType == 'payoneer' ){
                        $this->payoneer_email = !empty( $setting['payoneer_email'] ) ? $setting['payoneer_email'] : '';
                    } elseif( $settingType == 'bank' ) {
                        $this->bankAccountInfo = [
                            'title'             => !empty( $setting['title'] ) ? $setting['title'] : '',
                            'account_number'    => !empty( $setting['account_number'] ) ? $setting['account_number'] : '',
                            'bank_name'         => !empty( $setting['bank_name'] ) ? $setting['bank_name'] : '',
                            'routing_number'    => !empty( $setting['routing_number'] ) ? $setting['routing_number'] : '',
                            'bank_iban'         => !empty( $setting['bank_iban'] ) ? $setting['bank_iban'] : '',
                            'bank_bic_swift'    => !empty( $setting['bank_bic_swift'] ) ? $setting['bank_bic_swift'] : '',
                        ];
                    } elseif( $settingType == 'default_selected' ){
                        if($this->method_type == 'escrow'){
                            $this->default_selected = 'escrow';
                        } else {
                            $this->default_selected = !empty($setting) ? $setting : '';
                        }
                    }
                }
            }

        }

        if( empty( $this->default_selected ) ) {
            if( $this->method_type == 'escrow' ){
                $this->default_selected = 'escrow';
            } elseif( !empty( !empty($billingRec->payout_settings) ) ) {
                $this->default_selected = 'paypal';
            }
        }

        $this->payout_type = $this->default_selected;
    }

    public function updatePayoutMethod($method_type){
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        $validate_values = [];
        if( $method_type == 'escrow'){
            $validate_values['escrow_email']    = 'required|email';
            $validate_values['escrow_api_key']  = 'required';
        } elseif( $method_type == 'paypal' ){
            $validate_values['paypal_email']    = 'required|email';
        } elseif( $method_type == 'payoneer'){
            $validate_values['payoneer_email']  = 'required|email';
        } elseif( $method_type == 'bank'){
            $validate_values['bankAccountInfo.title']           = 'required';
            $validate_values['bankAccountInfo.account_number']  = 'required';
            $validate_values['bankAccountInfo.bank_name']       = 'required';
            $validate_values['bankAccountInfo.routing_number']  = 'required';
            $validate_values['bankAccountInfo.bank_iban']       = 'required';
            $validate_values['bankAccountInfo.bank_bic_swift']  = 'required';
        }

        $this->validate($validate_values,[
            'required'  => __('general.required_field'),
        ]);

        if( !empty( $this->method_type) ){
            $billingRec         = UserBillingDetail::where('profile_id', $this->profile_id )->select('payout_settings')->first();
            $method_settings    = [];
            $record             = [];

            if(!empty($billingRec)){
                $payout_settings = @unserialize($billingRec->payout_settings);
                $record          = !empty($payout_settings) ? $payout_settings : [];
            }

            $record['default_selected']  = $method_type;

            if( $this->method_type == 'escrow' ){
                if( !empty($this->escrow_email) && !empty($this->escrow_api_key) ){
                    $record['escrow'] = [
                        'escrow_email'    => sanitizeTextField($this->escrow_email),
                        'escrow_api'      => sanitizeTextField($this->escrow_api_key),
                    ];
                }
            } else {
               
                if( !empty($this->paypal_email) ) {
                    $record['paypal']     = [
                        'paypal_email'    => sanitizeTextField($this->paypal_email),
                    ];
                }
    
                if( !empty($this->payoneer_email) ) {
                    $record['payoneer'] = [
                        'payoneer_email' => sanitizeTextField($this->payoneer_email),
                    ];
                }
    
                if(
                    !empty($this->bankAccountInfo['title']) && 
                    !empty($this->bankAccountInfo['account_number']) &&
                    !empty($this->bankAccountInfo['bank_name']) &&
                    !empty($this->bankAccountInfo['routing_number']) &&
                    !empty($this->bankAccountInfo['bank_iban']) &&
                    !empty($this->bankAccountInfo['bank_bic_swift'])
                    ){
                    $record['bank'] = [
                        'title'             => sanitizeTextField( $this->bankAccountInfo['title'] ),
                        'account_number'    => sanitizeTextField( $this->bankAccountInfo['account_number'] ),
                        'bank_name'         => sanitizeTextField( $this->bankAccountInfo['bank_name'] ),
                        'routing_number'    => sanitizeTextField( $this->bankAccountInfo['routing_number'] ),
                        'bank_iban'         => sanitizeTextField( $this->bankAccountInfo['bank_iban'] ),
                        'bank_bic_swift'    => sanitizeTextField( $this->bankAccountInfo['bank_bic_swift'] ),
                    ];
                }
            }


            $serializeData = serialize($record);
            $data['payout_settings'] = $serializeData;
           
            $updateRecord = UserBillingDetail::select('id')->updateOrCreate(
                [
                    'profile_id'  => $this->profile_id
                ],
                $data
            );
         
            $eventData = [];
            if( ! empty( $updateRecord ) ){
                $eventData['title']     = __('general.success_title');
                $eventData['message']   = __('general.success_message');
                $eventData['type']      = 'success';
            } else {
                $eventData['title']     = __('general.error_title');
                $eventData['message']   = __('settings.wrong_msg');
                $eventData['type']      = 'error';           
            }
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
            $this->default_selected = $method_type;
            $this->payout_type      = $method_type;
            $this->payoutSettings   = $record;
        }
    }

    public function withdraw(){
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $wallet = UserWallet::select('id', 'profile_id', 'amount')->where('profile_id', $this->profile_id)->first();
        
        if( !empty($wallet) && $wallet->amount > 0 ){

            $this->amount       = sanitizeTextField($this->amount);
            $this->payout_type  = sanitizeTextField($this->payout_type);
            
            $this->validate([
                'amount'        => 'required|numeric|gte:'.$this->withdraw_limit.'|max:'.$wallet->amount,
                'payout_type'   => 'required',
            ]);

            $billing_info   =   UserBillingDetail::select('payout_settings')->where('profile_id', $this->profile_id)->first();
            if( empty($billing_info) || empty($billing_info->payout_settings ) ){
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'title'     => __('general.error_title'),
                    'type'      => 'error',
                    'message'   => __('transaction.payout_setting_error')
                ]);
                return; 
            }

            $payouts_settings = unserialize( $billing_info->payout_settings );
            if( empty($payouts_settings[$this->payout_type]) ){

                $this->dispatchBrowserEvent('showAlertMessage', [
                    'title'     => __('general.error_title'),
                    'type'      => 'error',
                    'message'   => __('transaction.payout_setting_error')
                ]);
                return; 
            }

            SellerWithdrawal::create([
                'seller_id'        => $this->profile_id,
                'amount'            => $this->amount,
                'payment_method'    => $this->payout_type,
                'detail'            => serialize($payouts_settings[$this->payout_type]),
            ]);

            if( !empty($billing_info) ){
                $payout_settings                = @unserialize($billing_info->payout_settings);
                $record                         = !empty($payout_settings) ? $payout_settings : [];
                $record['default_selected']     = $this->payout_type;
                $data['payout_settings']        = serialize($record);
                $updateRecord                   = UserBillingDetail::select('id')->updateOrCreate(
                    [ 'profile_id'  => $this->profile_id ], $data
                );
            }

            $wallet_amount = $wallet->amount - $this->amount;
            
            $wallet->update(['amount' => $wallet_amount]);
        
            $this->default_selected = $this->payout_type;
            $this->amount       = '';
            $this->payout_type  = '';
            $this->emit('updatePayoutsHistory');
            $this->updateEarningValues();

            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.funds_withdraw_request');
            $eventData['type']      = 'success';

            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('general.funds_withdraw_request');
            $eventData['type']      = 'error';

            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }
    }

    public function updateEarningValues() {
        $total_earning = $available_balance = $withdraw_amount = $pending_income = 0;
        $wallet = UserWallet::select('id', 'amount')->where('profile_id', $this->profile_id)->first();

        if( !empty($wallet) ){
            $total_earning      = UserWalletDetail::where('wallet_id', $wallet->id)->sum('amount');
            $this->available_balance  = $wallet->amount; 
        }

        $withdraw_amount    = SellerWithdrawal::where('seller_id', $this->profile_id)->sum('amount');

        $pending_income     = SellerPayout::whereHas( 'Transaction', function($query){
            $query->select('id')->whereIn('status', array('processed', 'cancelled'));
        })->where('seller_id', $this->profile_id)->sum('seller_amount');

        $accountBalance = array(
            'total_earning'     => $this->currency_symbol.''.number_format( $total_earning, 2),
            'available_balance' => $this->currency_symbol.''.number_format( $this->available_balance, 2),
            'withdraw_amount'   => $this->currency_symbol.''.number_format( $withdraw_amount, 2),
            'pending_income'    => $this->currency_symbol.''.number_format( $pending_income, 2)
        );

        $this->dispatchBrowserEvent('accountBalance', $accountBalance);
    }
}
