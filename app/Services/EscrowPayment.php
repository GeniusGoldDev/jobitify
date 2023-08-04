<?php

namespace App\Services;
use App\Models\Country;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\CountryState;
use App\Models\Gig\GigOrder;
use App\Models\EmailTemplate;
use App\Models\Proposal\Proposal;
use App\Models\TransactionDetail;
use App\Models\UserBillingDetail;
use Illuminate\Support\Facades\DB;
use App\Models\Seller\SellerPayout;
use App\Models\EscrowDisburseMethod;
use Illuminate\Support\Facades\Http;
use Illuminate\Session\SessionManager;
use App\Notifications\EmailNotification;
use App\Models\Proposal\ProposalTimecard;
use App\Models\Proposal\ProposalMilestone;
use Illuminate\Http\Client\RequestException;

class EscrowPayment 
{
    protected $session;
    protected $currency;
    protected $escrow_email;
    protected $escrow_api_key;
    protected $escrow_api_url;
    protected $status   = false;
    protected $escrow_request  = '';

    
    public function __construct( $escrow_email = '', $escrow_api = '' ){
        
        $setting   = getTPSetting(['payment'], ['payment_methods']);
        
        if( !empty($setting['payment_methods']) ){

            $payment_methods = unserialize($setting['payment_methods']);
            if( !empty($payment_methods['escrow']) 
                && $payment_methods['escrow']['status'] == 'on'
                && !empty($payment_methods['escrow']['email']) 
                && !empty($payment_methods['escrow']['api_key']) 
                ){
                    
                $this->status                       = true;
                $this->currency                     = $payment_methods['escrow']['currency'];
                $this->escrow_email                 = !empty($escrow_email) ? $escrow_email :   $payment_methods['escrow']['email'];
                $this->escrow_api_key               = !empty($escrow_api) ? $escrow_api     :   $payment_methods['escrow']['api_key'];
                $this->escrow_api_url               = $payment_methods['escrow']['api_url'];
                $this->escrow_fees_payer            = $payment_methods['escrow']['fees_payer'];
                $this->escrow_inspection_period     = $payment_methods['escrow']['inspection_period'];
                $this->escrow_request               = Http::withBasicAuth( $this->escrow_email, $this->escrow_api_key );

            }
        }
        
    }

    public function manageWebhook(){
        
        $response = '';
        if( $this->status ){

            $end_point      = $this->escrow_api_url. '/2017-09-01/customer/me/webhook';
            $webhook_url    = url('/escrow-transaction-updates');
            $output         = $this->escrow_request->get($end_point);

            if( $output->successful() ){

                $body = json_decode( $output->body(), true );
                 $webhook_exist = array_filter($body['webhooks'], function($single) use($webhook_url){
                    return $single['url'] == $webhook_url;
                });
                if( empty($webhook_exist) ){
                    $output= $this->escrow_request->post($end_point, array(
                        'url' => $webhook_url,
                    ));
                    return $output->status();
                }else{
                   return 201; 
                }
            }
        }
    }

    public function createProjectTransaction( $params ){
        
        $response = array();

        if( !$this->status ){

            $response['type']       = 'error';
            $response['message']    = __('transaction.payment_setting_error');
            return $response;
        }

        $country_detail          = Country::select('name','short_code')->where('id', $params['country_id'])->first();
        $buyer_country_short     = $country_detail->short_code;
        $buyer_country_full      = $country_detail->name;
        
        $buyer_state_short       = $buyer_state_full = '';

        if( !empty($params['state_id']) ){
            $state_detail            = CountryState::select('name','short_code')->where('id', $params['state_id'])->first();
            if( !empty($state_detail) ){
                $buyer_state_short       = $state_detail->short_code;
                $buyer_state_full        = $state_detail->name;
            }
        }
        

        $proposal_detail        = Proposal::select('author_id','proposal_amount','payout_type', 'commission_amount')->find($params['proposal_id']);
        $project_detail         = Project::select('project_title', 'project_type')->find($params['project_id']);
        $seller_detail          = UserBillingDetail::select('billing_email')->where('profile_id', $proposal_detail->author_id)->first();
        $seller_profile         = Profile::select('first_name','last_name')->where('id', $proposal_detail->author_id)->first();
        
        if( empty($seller_detail) ){
            $response['type']       = 'error';
            $response['message']    = __('transaction.seller_billing_info');
            return $response;
        }

        $price                  = $proposal_detail->proposal_amount;
        $commission_amount      = !empty($proposal_detail->commission_amount) ? $proposal_detail->commission_amount : 0 ;
        $title                  = $project_detail->project_title.' - ( '.$seller_profile->full_name.' )';
        $description            = $project_detail->project_title .' - '. $project_detail->project_type. ' - ' . __('general.payment'); 

        if( $proposal_detail->payout_type == 'fixed' ){

            $transaction_type = '2';
            $type_ref_id = $params['proposal_id'];
            $commission_amount =  round($commission_amount, 2);
        }elseif( $proposal_detail->payout_type == 'milestone' ){

            $milestone_detail   = ProposalMilestone::select('title', 'price')->find($params['milestone_id']);
            $description        = $milestone_detail->title;
            $price              = $milestone_detail->price;

            if( $commission_amount > 0 ){
                $milestone_percentage   = ($milestone_detail->price / $proposal_detail->proposal_amount) * 100;
                $commission_amount      = $commission_amount * ($milestone_percentage / 100);
                $commission_amount      =  round($commission_amount, 2);
            }

            $transaction_type = '1';
            $type_ref_id = $params['milestone_id'];
        }else{

            $timecard_detail   = ProposalTimecard::select('title', 'price', 'total_time')->find($params['timecard_id']);
            $description        = $timecard_detail->title. ' '. __('general.hourly_timecard');
            $price              = $timecard_detail->price;

            if( $commission_amount > 0 ){

                $time = explode(':', $timecard_detail->total_time);
                $hours = $time[0];
                $mins_cost = 0;
                if( isset($time[1]) && $time[1] > 0 ){
                    $per_min_amount = $commission_amount/60;
                    $mins_cost =  $per_min_amount *  $time[1]; 
                }
                $commission_amount =  ($commission_amount * $hours) + $mins_cost;
                $commission_amount =  round($commission_amount, 2);
            }
            
            $transaction_type   = '3';
            $type_ref_id        = $params['timecard_id'];
        }

        $seller_amount = round( $price - $commission_amount, 2 );

        // Configure buyer
        $buyer = array(
            'agreed'            => true,
            'customer'          => $params['email'],
            'initiator'         => false,
            'role'              => 'buyer',
            'first_name'        => $params['first_name'],
            'last_name'         => $params['last_name'],
            'phone_number'      => $params['phone'],
            'lock_email'        => 'true',
        );

        $buyer['address'] = array(

            'line1'         => $params['address'],
            'company'       => $params['company'],
            'city'          => $params['city'],
            'country'       => $buyer_country_short,
            'post_code'     => $params['postal_code']
            
        );

        if( !empty($buyer_state_short) ){
            $buyer['address']['state'] =  $buyer_state_short; 
        }

         // Configure seller.
         $seller = array(
            'agreed'            => true,
            'customer'          => $seller_detail->billing_email,
            'initiator'         => false,
            'role'              => 'seller',
        );

        $parties = [];
        if( $commission_amount > 0 ){

            array_push($parties,
                $buyer,
                $seller,
                array(
                    'agreed' => true,
                    'customer' => 'me',
                    'role' => 'broker'
                )
            );
        }else{

            $buyer['initiator'] = true;
            array_push($parties,
                $buyer,
                $seller,
                array(
                    'agreed' => true,
                    'customer' => 'me',
                    'role' => 'partner',
                )
            );
        }

        $item_array = $fees_array = $item_detail = array();

        if( $this->escrow_fees_payer ==  'seller' ){

            array_push($fees_array, array(
                'payer_customer'    => $seller_detail->billing_email,
                    "split"         => "1",
                    'type'          => 'escrow'
                )
            );

        }elseif( $this->escrow_fees_payer ==  'buyer' ){

            array_push($fees_array, array(
                'payer_customer'    => $params['email'],
                    "split"         => 1,
                    'type'           => 'escrow'
                )
            );

        }else{

            array_push($fees_array, array(
                'payer_customer'    => $seller_detail->billing_email,
                    "split"         => 0.5,
                    'type'          => 'escrow'
                )
            );
            array_push($fees_array, array(
                'payer_customer'    => $params['email'],
                    "split"         => 0.5,
                    'type'          => 'escrow'
                )
            );
        }

        $item_detail['description']         = $description;
        $item_detail['quantity']            = 1;
        $item_detail['title']               = $title;
        $item_detail['type']                = 'general_merchandise';
        $item_detail['category']            = 'services';
        $item_detail['shipping_type']       = 'no_shipping';
        $item_detail['inspection_period']   = $this->escrow_inspection_period * 86400;
        $item_detail['fees']                = $fees_array;
        

        $item_detail['schedule']  = array(
            array(
                "payer_customer"            =>  $params['email'],
                "amount"                    =>  $price,
                "beneficiary_customer"      => $seller_detail->billing_email,
            )
        );

        if( $commission_amount > 0 ){

            array_push($item_array, array(
                    'type' => 'broker_fee',
                    'schedule' => array(
                        array(
                            'payer_customer'        => $seller_detail->billing_email,
                            'amount'                => $commission_amount,
                            'beneficiary_customer'  => 'me'
                        )
                    )
                )
            );
        }

        array_push($item_array, $item_detail); 

        $payload['description']             = $title;
        $payload['currency']                = strtolower($this->currency);
        $payload['return_url']              = $params['return_url'];
        $payload['redirect_type']           = 'automatic';
        $payload['items']                   = $item_array;
        $payload['parties']                 = $parties;
        
        $end_point  = $this->escrow_api_url. '/integration/pay/2018-03-31';
        $output     = $this->escrow_request->post($end_point, $payload);
        
        if( $output->successful() ){

            $body = json_decode( $output->body(), true );
            $response['type']            = 'success';
            $response['landing_page']    = $body['landing_page'];
            $response['transaction_id']  = $body['transaction_id'];

            DB::beginTransaction();
            try {

                $transaction = Transaction::create([
                    'creator_id'       => $params['creator_id'],
                    'trans_ref_no'     => $body['transaction_id'],
                    'payment_type'     => 'project',
                    'payment_method'   => 'escrow',
                ]);
    
                TransactionDetail::create([
                    'transaction_id'            => $transaction->id,
                    'amount'                    => $price,
                    'currency'                  => $this->currency,
                    'payer_first_name'          => $params['first_name'],
                    'payer_last_name'           => $params['last_name'],
                    'payer_company'             => $params['company'],
                    'payer_country'             => $buyer_country_full,
                    'payer_state'               => $buyer_state_full,
                    'payer_postal_code'         => $params['postal_code'],
                    'payer_address'             => $params['address'],
                    'payer_city'                => $params['city'],
                    'payer_phone'               => $params['phone'],
                    'payer_email'               => $params['email'],
                    'transaction_type'          => $transaction_type,
                    'type_ref_id'               => $type_ref_id,
                ]);
    
                SellerPayout::create([
                    'transaction_id'       => $transaction->id,
                    'project_id'           => $params['project_id'],
                    'seller_id'            => $proposal_detail->author_id,
                    'seller_amount'        => $seller_amount,
                    'admin_commission'     => $commission_amount,
                ]);
                
                if( $transaction_type == 1 ){

                    $proposal_milestone = ProposalMilestone::select('id')->find($type_ref_id);
                    $proposal_milestone->update(['status' => 'processing']);
                }elseif( $transaction_type == 3  ){
                    $proposal_timecard = ProposalTimecard::select('id')->find($type_ref_id);
                    $proposal_timecard->update(['status' => 'processing']);
                }

                DB::commit();
            }catch (\Exception $e) {

                DB::rollback();
                $response['type'] = 'error';
                return $response;
            }

        }elseif($output->failed()){

            $body = json_decode( $output->body(), true );
            $response['type'] = 'error';
            $response['errors'] = !empty($body['errors']) ? $body['errors'] : '';

        }

        return $response;
    }

    public function createPackageTransaction( $params ){
        
        $response = array();

        $setting   = getTPSetting(false, ['payment_methods']);
        $seller_email = '';
        if( !empty($setting['payment_methods']) ){
            $payment_methods = unserialize($setting['payment_methods']);
            if( !empty($payment_methods['escrow']) && !empty($payment_methods['escrow']['email']) ){
                $seller_email  = $payment_methods['escrow']['email'];
            }
        }
        
        if( !$this->status || $seller_email == '' ){

            $response['type']       = 'error';
            $response['message']    = __('transaction.payment_setting_error');
            return $response;
        }

        $country_detail          = Country::select('name','short_code')->where('id', $params['country_id'])->first();
        $buyer_country_short     = $country_detail->short_code;
        $buyer_country_full      = $country_detail->name;
        $buyer_state_short       = $buyer_state_full = '';
        
        if( !empty($params['state_id']) ){
            $state_detail            = CountryState::select('name','short_code')->where('id', $params['state_id'])->first();
            if( !empty($state_detail) ){
                $buyer_state_short       = $state_detail->short_code;
                $buyer_state_full        = $state_detail->name;
            }
        }

        $title  = $params['package_title'].' - ( '.$params['first_name'].' '.$params['last_name'].' )';

        // Configure buyer
        $buyer = array(
            'agreed'            => true,
            'customer'          => $params['email'],
            'initiator'         => true,
            'role'              => 'buyer',
            'first_name'        => $params['first_name'],
            'last_name'         => $params['last_name'],
            'phone_number'      => $params['phone'],
            'lock_email'        => 'true',
        );

        $buyer['address'] = array(

            'line1'         => $params['address'],
            'company'       => $params['company'],
            'city'          => $params['city'],
            'country'       => $buyer_country_short,
            'post_code'     => $params['postal_code']
            
        );

        if( !empty($buyer_state_short) ){
            $buyer['address']['state'] =  $buyer_state_short; 
        }

         // Configure seller.
         $seller = array(
            'agreed'            => true,
            'customer'          => $seller_email,
            'initiator'         => false,
            'role'              => 'seller',
        );

        $parties = [];
        array_push($parties,
            $buyer,
            $seller
        );

        $item_array = $fees_array = $item_detail = array();

        if( $this->escrow_fees_payer ==  'seller' ){

            array_push($fees_array, array(
                'payer_customer'    => $seller_email,
                    "split"         => "1",
                    'type'          => 'escrow'
                )
            );

        }elseif( $this->escrow_fees_payer ==  'buyer' ){

            array_push($fees_array, array(
                'payer_customer'    => $params['email'],
                    "split"         => 1,
                    'type'           => 'escrow'
                )
            );

        }else{

            array_push($fees_array, array(
                'payer_customer'    => $seller_email,
                    "split"         => 0.5,
                    'type'          => 'escrow'
                )
            );
            array_push($fees_array, array(
                'payer_customer'    => $params['email'],
                    "split"         => 0.5,
                    'type'          => 'escrow'
                )
            );
        }

        $item_detail['description']         = $title;
        $item_detail['quantity']            = 1;
        $item_detail['title']               = $title;
        $item_detail['type']                = 'general_merchandise';
        $item_detail['category']            = 'services';
        $item_detail['shipping_type']       = 'no_shipping';
        $item_detail['inspection_period']   = $this->escrow_inspection_period * 86400;
        $item_detail['fees']                = $fees_array;
       
        $item_detail['schedule']  = array(
            array(
                "payer_customer"            =>  $params['email'],
                "amount"                    =>  $params['package_price'],
                "beneficiary_customer"      =>  $seller_email,
            )
        );

        array_push($item_array, $item_detail); 

        $payload['description']             = $title;
        $payload['currency']                = strtolower($this->currency);
        $payload['return_url']              = $params['return_url'];
        $payload['redirect_type']           = 'automatic';
        $payload['items']                   = $item_array;
        $payload['parties']                 = $parties;
        
        $end_point  = $this->escrow_api_url. '/integration/pay/2018-03-31';
        $output     = $this->escrow_request->post($end_point, $payload);
        
        if( $output->successful() ){

            $body = json_decode( $output->body(), true );
            $response['type']            = 'success';
            $response['landing_page']    = $body['landing_page'];
            $response['transaction_id']  = $body['transaction_id'];

            DB::beginTransaction();
            try {

                $transaction = Transaction::create([
                    'creator_id'       => $params['creator_id'],
                    'trans_ref_no'     => $body['transaction_id'],
                    'payment_type'     => 'package',
                    'payment_method'   => 'escrow',
                ]);
    
                TransactionDetail::create([
                    'transaction_id'            => $transaction->id,
                    'amount'                    => $params['package_price'],
                    'currency'                  => $this->currency,
                    'payer_first_name'          => $params['first_name'],
                    'payer_last_name'           => $params['last_name'],
                    'payer_company'             => $params['company'],
                    'payer_country'             => $buyer_country_full,
                    'payer_state'               => $buyer_state_full,
                    'payer_postal_code'         => $params['postal_code'],
                    'payer_address'             => $params['address'],
                    'payer_city'                => $params['city'],
                    'payer_phone'               => $params['phone'],
                    'payer_email'               => $params['email'],
                    'transaction_type'          => '0',
                    'type_ref_id'               => $params['package_id'],
                ]);

                DB::commit();
            }catch (\Exception $e) {

                DB::rollback();
                $response['type'] = 'error';
                return $response;
            }

        }elseif($output->failed()){

            $body = json_decode( $output->body(), true );
            $response['type'] = 'error';
            $response['errors'] = !empty($body['errors']) ? $body['errors'] : '';

        }

        return $response;
    }

    public function createGigOrderTransaction( $params ){
        
        $response = array();

        if( !$this->status ){

            $response['type']       = 'error';
            $response['message']    = __('transaction.payment_setting_error');
            return $response;
        }


        $seller_detail          = UserBillingDetail::select('billing_email')->where('profile_id', $params['gig_author'])->first();
        $seller_profile         = Profile::select('first_name','last_name')->where('id', $params['gig_author'])->first();
        $amount                 = $params['plan_price'];
        if( !empty($params['gig_addons']) ){
            foreach($params['gig_addons'] as $single){
                $amount +=   $single['price']; 
            }
        }
        if( empty($seller_detail) ){
            $response['type']       = 'error';
            $response['message']    = __('transaction.seller_billing_info');
            return $response;
        }

        $country_detail          = Country::select('name','short_code')->where('id', $params['country_id'])->first();
        $buyer_country_short     = $country_detail->short_code;
        $buyer_country_full      = $country_detail->name;
        $buyer_state_short       = $buyer_state_full = '';
        if( !empty($params['state_id']) ){
            $state_detail            = CountryState::select('name','short_code')->where('id', $params['state_id'])->first();
            if( !empty($state_detail) ){
                $buyer_state_short       = $state_detail->short_code;
                $buyer_state_full        = $state_detail->name;
            }
        }

        $title  = $params['gig_title'].' - ( '.$params['first_name'].' '.$params['last_name'].' )';

        // Configure buyer
        $buyer = array(
            'agreed'            => true,
            'customer'          => $params['email'],
            'initiator'         => true,
            'role'              => 'buyer',
            'first_name'        => $params['first_name'],
            'last_name'         => $params['last_name'],
            'phone_number'      => $params['phone'],
            'lock_email'        => 'true',
        );

        $buyer['address'] = array(

            'line1'         => $params['address'],
            'company'       => $params['company'],
            'city'          => $params['city'],
            'country'       => $buyer_country_short,
            'post_code'     => $params['postal_code']
            
        );

        if( !empty($buyer_state_short) ){
            $buyer['address']['state'] =  $buyer_state_short; 
        }

         // Configure seller.
         $seller = array(
            'agreed'            => true,
            'customer'          => $seller_detail->billing_email,
            'initiator'         => false,
            'role'              => 'seller',
        );

        $parties = [];
        array_push($parties,
            $buyer,
            $seller,
            array(
                'agreed'    => true,
                'customer' => 'me',
                'role'  => 'partner'
            )
        );

        $item_array = $fees_array = $item_detail = array();

        if( $this->escrow_fees_payer ==  'seller' ){

            array_push($fees_array, array(
                'payer_customer'    => $seller_detail->billing_email,
                    "split"         => "1",
                    'type'          => 'escrow'
                )
            );

        }elseif( $this->escrow_fees_payer ==  'buyer' ){

            array_push($fees_array, array(
                'payer_customer'    => $params['email'],
                    "split"         => 1,
                    'type'           => 'escrow'
                )
            );

        }else{

            array_push($fees_array, array(
                'payer_customer'    => $seller_detail->billing_email,
                    "split"         => 0.5,
                    'type'          => 'escrow'
                )
            );
            array_push($fees_array, array(
                'payer_customer'    => $params['email'],
                    "split"         => 0.5,
                    'type'          => 'escrow'
                )
            );
        }

        $item_detail['description']         = $title;
        $item_detail['quantity']            = 1;
        $item_detail['title']               = $title;
        $item_detail['type']                = 'general_merchandise';
        $item_detail['category']            = 'services';
        $item_detail['shipping_type']       = 'no_shipping';
        $item_detail['inspection_period']   = $this->escrow_inspection_period * 86400;
        $item_detail['fees']                = $fees_array;
       
        $item_detail['schedule']  = array(
            array(
                "payer_customer"            =>  $params['email'],
                "amount"                    =>  $amount,
                "beneficiary_customer"      =>  $seller_detail->billing_email,
            )
        );

        array_push($item_array, $item_detail); 

        $payload['description']             = $title;
        $payload['currency']                = strtolower($this->currency);
        $payload['return_url']              = $params['return_url'];
        $payload['redirect_type']           = 'automatic';
        $payload['items']                   = $item_array;
        $payload['parties']                 = $parties;
        
        $end_point  = $this->escrow_api_url. '/integration/pay/2018-03-31';
        
        $output     = $this->escrow_request->post($end_point, $payload);
        
        if( $output->successful() ){
              
            $body = json_decode( $output->body(), true );
            $response['type']            = 'success';
            $response['landing_page']    = $body['landing_page'];
            $response['transaction_id']  = $body['transaction_id'];
            
            DB::beginTransaction();
            try {

                $gig_order = GigOrder::create([
                    'author_id'             => $params['creator_id'],
                    'gig_id'                => $params['gig_id'],
                    'plan_type'             => $params['plan_type'],
                    'plan_amount'           => $amount,
                    'gig_features'          => null,
                    'gig_addons'            => !empty($params['gig_addons']) ? serialize($params['gig_addons']) : null,
                    'downloadable'          => !empty($params['downloadable']) ? $params['downloadable'] : null,
                    'gig_delivery_days'     => $params['delivery_time'],
                ]);
               
                $transaction = Transaction::create([
                    'creator_id'       => $params['creator_id'],
                    'trans_ref_no'     => $body['transaction_id'],
                    'payment_type'     => 'gig',
                    'payment_method'   => 'escrow',
                ]);
    
                TransactionDetail::create([
                    'transaction_id'            => $transaction->id,
                    'amount'                    => $amount,
                    'currency'                  => $this->currency,
                    'payer_first_name'          => $params['first_name'],
                    'payer_last_name'           => $params['last_name'],
                    'payer_company'             => $params['company'],
                    'payer_country'             => $buyer_country_full,
                    'payer_state'               => $buyer_state_full,
                    'payer_postal_code'         => $params['postal_code'],
                    'payer_address'             => $params['address'],
                    'payer_city'                => $params['city'],
                    'payer_phone'               => $params['phone'],
                    'payer_email'               => $params['email'],
                    'transaction_type'          => '4',
                    'type_ref_id'               => $gig_order->id,
                ]);

                SellerPayout::create([
                    'transaction_id'       => $transaction->id,
                    'project_id'           => null,
                    'gig_id'               => $params['gig_id'],
                    'seller_id'            => $params['gig_author'],
                    'seller_amount'        => $amount,
                    'admin_commission'     => 0,
                ]);

                DB::commit();
            }catch (\Exception $e) {
                DB::rollback();
                $response['type'] = 'error';
                return $response;
            }

        }elseif($output->failed()){
            $body = json_decode( $output->body(), true );
            $response['type'] = 'error';
            $response['errors'] = !empty($body['errors']) ? $body['errors'] : '';

        }

        return $response;
    }

    public function addpayment($id, $amount){ // testing for sandbox will remove in production environment
        
        $url = 'https://integrationhelper.escrow-sandbox.com/v1/transaction/'.$id.'/payments_in';
       
        $output = $this->escrow_request->timeout(3000)->post($url,
            array(
                'method' => 'wire_transfer',
                'amount' => $amount,
            )
        );
        if( $output->failed() ){
            $body = json_decode( $output->body(), true );
            dd($body);
        }
        $body = json_decode( $output->body(), true );
        dd($output);
    }

    public function getTransaction( $params = array() ){

        $response = array();
        $endpoint = $this->escrow_api_url.'/2017-09-01/transaction/'.$params['transaction_id'];
        $output = $this->escrow_request->get($endpoint);
        
        if( $output->successful() ){

            $response['type']      = 'success';
            $body = json_decode( $output->body(), true );
            if( !empty($params['verify_payment']) ){
                
                if(($body['items'][0]['status']['received'])){
                    $response['verify_payment'] = true;
                }else{
                    $response['verify_payment'] = false;
                }
            }else{
                $response['status'] = $body['items'][0]['status'];
            }

        }else{

            $body = json_decode( $output->body(), true );
            $response['type'] = 'error';
            $response['errors'] = !empty($body['errors']) ? $body['errors'] : '';
        }

        return $response;    
    }

    public function getSellerDisburseMethod( $id ){
        
        $response = array();
        $end_point  = $this->escrow_api_url. '/2017-09-01/transaction/'.$id.'/disbursement_methods';
        $output     = $this->escrow_request->get($end_point);

        if( $output->successful() ){
            $response['type']   = 'success';
            $body               = json_decode( $output->body(), true );
            if( empty($body['selected_disbursement_method']) ){

                $response['selected_disbursement_method']   = false;
                $response['saved_disbursement_methods']     = !empty($body['saved_disbursement_methods']) ? $body['saved_disbursement_methods'] : false;

            }else{
                $response['selected_disbursement_method'] = true;
            }
        }else{

            $response['type']   = 'error';
            $response['title']  = __('general.error_title');
            $body = json_decode( $output->body(), true );
            $response['message'] = !empty($body['errors']) ? $body['errors'] : '';
        }

        return $response;
    }

    public function setSellerTransactionDisburseMethod( $params ){

        $end_point  = $this->escrow_api_url. '/2017-09-01/transaction/'.$params['transaction_ref'].'/disbursement_methods';
        
        $payload = array(
            'id' => $params['escrow_disburse_id'],
        );

        $output  = $this->escrow_request->post( $end_point, $payload );
        
        if( $output->successful() ){
            $response['type']  = 'success';
            if( $params['use_same_method'] ){
                EscrowDisburseMethod::create([
                    'seller_id'              => $params['seller_id'],
                    'project_id'             => $params['project_id'],
                    'disburse_methods_id'    => $params['escrow_disburse_id'],
                ]);
            }
        }else{

            $response['type']   = 'error';
            $response['title']  = __('general.error_title');
            $body = json_decode( $output->body(), true );
            $response['message'] = !empty($body['errors']) ? $body['errors'] : '';
        }
        return $response;
    }

    public function updateTransaction( $id= '', $status = '', $extra_params = array() ){

        
        $response = array();
        $end_point  = $this->escrow_api_url. '/2017-09-01/transaction/'.$id;
        $payload = array(
            'action' => $status,
        );

        if( !empty($extra_params) ){
            $payload = array_merge( $payload, $extra_params );
        }
        
        $output  = $this->escrow_request->patch($end_point, $payload);
        $body = json_decode( $output->body(), true );
        
        if( $output->successful() ){
            $response['type']  = 'success';
        }else{

            $response['type']   = 'error';
            $response['title']  = __('general.error_title');
            $body = json_decode( $output->body(), true );
            $response['message'] = !empty($body['error']) ? $body['error'] : '';
        }
        return $response;
    }
}
