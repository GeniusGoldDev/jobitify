<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Profile;
use App\Models\Project;
use App\Events\NotifyUser;
use App\Models\UserWallet;
use App\Models\AdminPayout;
use App\Models\Transaction;
use App\Models\CountryState;
use App\Models\Gig\GigOrder;
use App\Models\EmailTemplate;
use App\Models\Package\Package;
use App\Models\UserWalletDetail;
use App\Models\Proposal\Proposal;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Models\Seller\SellerPayout;
use Illuminate\Session\SessionManager;
use App\Models\Package\PackageSubscriber;
use App\Models\Proposal\ProposalTimecard;
use App\Models\Proposal\ProposalMilestone;
use Illuminate\Http\Client\RequestException;

class StripePayment 
{
    protected $currency;
    protected $zero_decimal = false;
    
    public function __construct(){

        $setting   = getTPSetting(['payment'], ['payment_methods']);
        
        if( !empty($setting['payment_methods']) ){

            $payment_methods = unserialize($setting['payment_methods']);
            $payment_methods = $payment_methods['others'];
            if( !empty($payment_methods['stripe']) ){
                $this->currency   = $payment_methods['stripe']['cashier_currency'];
                if( in_array(strtoupper($this->currency), [
                    'BIF',
                    'CLP',
                    'DJF',
                    'GNF',
                    'JPY',
                    'KMF',
                    'KRW',
                    'MGA',
                    'PYG',
                    'RWF',
                    'UGX',
                    'VND',
                    'VUV',
                    'XAF',
                    'XOF',
                    'XPF',
                ])){
                    $this->zero_decimal = true;
                }
            }
        }
    }

    public function createProjectTransaction( $params ){
        
        $response = array();
        $country_detail          = Country::select('name')->where('id', $params['country_id'])->first();
        $buyer_country_full      = $country_detail->name;

        $buyer_state_full = '';

        if( !empty($params['state_id']) ){

            $state_detail            = CountryState::select('name')->where('id', $params['state_id'])->first();
            if( !empty($state_detail) ){
                $buyer_state_full   = $state_detail->name;
            }
        }

        $proposal_detail  = Proposal::with('proposalAuthor:id,first_name,last_name,user_id')->find($params['proposal_id']);
        $project          = Project::select('id', 'status', 'project_hiring_seller','slug', 'project_title', 'project_type')->find($params['project_id']);

        $price                  = $proposal_detail->proposal_amount;
        $commission_amount      = !empty($proposal_detail->commission_amount) ? $proposal_detail->commission_amount : 0 ;
        
        if( $proposal_detail->payout_type == 'fixed' ){

            $transaction_type = '2';
            $type_ref_id = $params['proposal_id'];
            $commission_amount =  round($commission_amount, 2);
        }elseif( $proposal_detail->payout_type == 'milestone' ){

            $milestone_detail   = ProposalMilestone::select('title', 'price')->find($params['milestone_id']);
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

        $seller_amount = round( $price - $commission_amount, 2);
       
        try{
            $used_wallet_amt = 0;
            $stripe_price = $price;
            $charge_from_stripe = true;
            if( $params['use_wallet_bal'] ){

                if( $params['wallet_balance'] >= $price ){
                    $remaining_wallet_bal   = $params['wallet_balance'] - $price;
                    $used_wallet_amt        = $price;
                    $charge_from_stripe     = false;
                }else{
                    $used_wallet_amt        = $params['wallet_balance'];
                    $stripe_price           = $price - $params['wallet_balance'];
                    $remaining_wallet_bal   = 0;
                }
            }

            if( $charge_from_stripe ){

                $stripe_price = $this->zero_decimal ?  $stripe_price : $stripe_price * 100;
                $params['user']->createOrGetStripeCustomer();
                $params['user']->updateDefaultPaymentMethod($params['stripe_payment_method']);
                $stripe_res = $params['user']->charge($stripe_price, $params['stripe_payment_method'],[
                    'description'   =>  __('transaction.transaction_desc')
                ]);
            }

            if( !$charge_from_stripe  || ( !empty($stripe_res) &&  $stripe_res->status == 'succeeded' ) ){

                $transaction = Transaction::create([
                    'creator_id'       => $params['creator_id'],
                    'trans_ref_no'     => $charge_from_stripe ? $stripe_res->id : null,
                    'payment_type'     => 'project',
                    'payment_method'   => 'stripe',
                    'status'           => 'processed',
                ]);
    
                TransactionDetail::create([
                    'transaction_id'            => $transaction->id,
                    'amount'                    => ($price - $used_wallet_amt),
                    'used_wallet_amt'           => $used_wallet_amt,
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

                if( $params['use_wallet_bal'] ){
                    
                    UserWallet::updateOrCreate(['profile_id' => $params['creator_id']], [
                        'profile_id'  => $params['creator_id'], 
                        'amount'      => $remaining_wallet_bal, 
                    ]);
                }

                $proposal_id = $type_ref_id;

                if( $transaction_type == 1 ){

                    $proposal_milestone = ProposalMilestone::select('id', 'proposal_id','title')->find($type_ref_id);
                    $proposal_milestone->update(['status' => 'processed']);
                    $proposal_id = $proposal_milestone->proposal_id;

                    // send email to seller when escrow milestone
                    $eventData = array();
                    $eventData['milestone_title'] = $proposal_milestone->title;
                    $eventData['email_type']      = 'escrow_milestone';
                    $eventData['proposal_id']     = $proposal_id;
                    event(new NotifyUser($eventData));

                }elseif( $transaction_type == 3  ){

                    $proposal_timecard = ProposalTimecard::select('id', 'proposal_id','title')->find($type_ref_id);
                    $proposal_timecard->update(['status' => 'completed']);
                    $proposal_id        = $proposal_timecard->proposal_id;
                    $transaction->update(['status' => 'completed']);

                    if( $commission_amount > 0 ){

                        AdminPayout::updateOrCreate(['transaction_id' => $transaction->id], [
                            'transaction_id'    => $transaction->id,
                            'amount'            => $commission_amount,
                        ]);
                    }

                    $user_wallet        = UserWallet::where('profile_id' , $proposal_detail->proposalAuthor->id)->first();
                    $wallet_profile_id  = !empty($user_wallet) ? $user_wallet->profile_id : 0;
                    $wallet_amount      = !empty($user_wallet) ? $user_wallet->amount : 0;
                    $wallet_amount      += $seller_amount;

                    $wallet = UserWallet::updateOrCreate(['profile_id' => $wallet_profile_id], [
                        'profile_id'  => $proposal_detail->proposalAuthor->id, 
                        'amount'      => $wallet_amount, 
                    ]);

                    UserWalletDetail::create([
                        'transaction_id'    => $transaction->id, 
                        'wallet_id'         => $wallet->id, 
                        'amount'            => $seller_amount, 
                    ]);

                    // send email to seller timecard completed
                    $eventData = array();
                    $eventData['timecard_title']  = $proposal_timecard->title;
                    $eventData['email_type']      = 'timecard_accepted';
                    $eventData['proposal_id']     = $proposal_id;
                    event(new NotifyUser($eventData));
                }
               
                if( $proposal_detail->status == 'publish' ){ // send email && notification 

                    $proposal_detail->update(['status'=> 'hired']);

                    $eventData                              = array();
                    $eventData['project_title']             = $project->project_title;
                    $eventData['user_name']                 = $proposal_detail->proposalAuthor->full_name;
                    $eventData['user_id']                   = $proposal_detail->proposalAuthor->user_id;
                    $eventData['email_type']                = 'proposal_request_accepted';
                    $eventData['project_activity_link']     = route('project-activity', ['slug' => $project->slug, 'id'=> $proposal_detail->id]);
                    event(new NotifyUser($eventData));
                }

                $total_hired_proposal   = Proposal::where('project_id', $project->id)->whereIn('status', array('hired', 'completed', 'refunded'))->count('id');

                if( $project->status == 'publish' && $project->project_hiring_seller == $total_hired_proposal ){
                    $project->update(['status' => 'hired']);
                }

                $response['type']  = 'success';
            }

        }catch (\Exception $exception) {
            $response['type']  = 'error';
            $response['message']  = $exception->getMessage();
        }
        return $response;
    }

    public function createPackageTransaction( $params ){
        
        $response = array();
        $country_detail       = Country::select('name')->where('id', $params['country_id'])->first();
        $buyer_country_full   = $country_detail->name;
        $buyer_state_full = '';
        
        if( !empty($params['state_id']) ){
            $state_detail            = CountryState::select('name')->where('id', $params['state_id'])->first();
            if( !empty($state_detail) ){
                $buyer_state_full        = $state_detail->name;
            }
        }

        $amount  = $params['package_price'];
        try{

            $used_wallet_amt = 0;
            $stripe_price = $amount;
            $charge_from_stripe = true;
            if( $params['use_wallet_bal'] ){

                if( $params['wallet_balance'] >= $amount ){
                    $remaining_wallet_bal   = $params['wallet_balance'] - $amount;
                    $used_wallet_amt        = $amount;
                    $charge_from_stripe     = false;
                }else{
                    $used_wallet_amt        = $params['wallet_balance'];
                    $stripe_price           = $amount - $params['wallet_balance'];
                    $remaining_wallet_bal   = 0;
                }
            }

            if( $charge_from_stripe ){

                $stripe_price = $this->zero_decimal ?  $stripe_price : $stripe_price * 100;
                $params['user']->createOrGetStripeCustomer();
                $params['user']->updateDefaultPaymentMethod($params['stripe_payment_method']);
                $stripe_res = $params['user']->charge($stripe_price, $params['stripe_payment_method'],[
                    'description'   => !empty($params['package_title']) ? $params['package_title'] : __('transaction.transaction_desc')
                ]);
            }

            if( !$charge_from_stripe  || ( !empty($stripe_res) &&  $stripe_res->status == 'succeeded' ) ){
              
                $transaction = Transaction::create([
                    'creator_id'       => $params['creator_id'],
                    'trans_ref_no'     => $charge_from_stripe ? $stripe_res->id : null,
                    'payment_type'     => 'package',
                    'payment_method'   => 'stripe',
                    'status'           => 'completed',
                ]);
    
                TransactionDetail::create([
                    'transaction_id'            => $transaction->id,
                    'amount'                    => ($amount - $used_wallet_amt),
                    'used_wallet_amt'           => $used_wallet_amt,
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

                if( $params['use_wallet_bal'] ){
                    
                    UserWallet::updateOrCreate(['profile_id' => $params['creator_id']], [
                        'profile_id'  => $params['creator_id'], 
                        'amount'      => $remaining_wallet_bal, 
                    ]);
                }

                $package_detail = Package::with('package_role:id,name')->find( $params['package_id'] );

                if( !empty($package_detail) ){

                    $options = unserialize( $package_detail->options );
                    if( $options['type'] == 'year' ){
                        $expiry_date =  Carbon::now()->addYear($options['duration'])->format('Y-m-d H:i:s');
                    }elseif( $options['type'] == 'month' ){
                        $expiry_date =  Carbon::now()->addMonth($options['duration'])->format('Y-m-d H:i:s');
                    }else{
                        $expiry_date =  Carbon::now()->addDays($options['duration'])->format('Y-m-d H:i:s'); 
                    }

                    if( $package_detail->package_role->name == 'buyer' ){

                        $package_options = array(
                            'type'          => $options['type'],
                            'duration'      => $options['duration'],
                            'allow_quota'   => array(
                                'posted_projects'           => $options['posted_projects'],
                                'featured_projects'         => $options['featured_projects'],
                                'project_featured_days'     => $options['project_featured_days'],
                            ),
                            'rem_quota'  => array(
                                'posted_projects'           => $options['posted_projects'],
                                'featured_projects'         => $options['featured_projects'], 
                            )
                        );
                    }else{

                        $package_options = array(
                            'type'          => $options['type'],
                            'duration'      => $options['duration'],
                            'allow_quota'   => array(
                                'credits'               => $options['credits'],
                                'profile_featured_days' => $options['profile_featured_days'],
                            ),
                            'rem_quota' => array(
                                'credits'    => $options['credits'],
                            )
                        );

                        $featured_expiry = null;
                        if( !empty($options['profile_featured_days']) ){

                            $profile_featured_days = $options['profile_featured_days'];
                            $featured_expiry  = Carbon::now()->addDays($profile_featured_days)->format('Y-m-d H:i:s');
                        }
                        $profile = Profile::where(['id'=> $transaction->creator_id]);
                        $profile->update(['is_featured'=> 1, 'featured_expiry' => $featured_expiry]);
                    }

                    PackageSubscriber::where('subscriber_id', $transaction->creator_id)->update(['status' => 'expired']);
                    
                    $package_subscriber = PackageSubscriber::create([
                        'subscriber_id'     => $params['creator_id'],
                        'package_id'        => $params['package_id'],
                        'package_price'     => $package_detail->price,
                        'package_options'   => serialize( $package_options),
                        'package_expiry'    => $expiry_date,
                    ]);

                    AdminPayout::updateOrCreate(['transaction_id' => $transaction->id], [
                        'transaction_id'    => $transaction->id,
                        'amount'            => $amount,
                    ]);

                    // notify email to admin and purchaser(seller and buyer)
                    $eventData                           = array();
                    $eventData['pckg_subscriber_id']     = $package_subscriber->id;
                    $eventData['email_type']             = 'package_purchase';
                    event(new NotifyUser($eventData));
                }

                $response['type'] = 'success';
            }

        }catch (\Exception $exception) {
            $response['type']  = 'error';
            $response['message']  = $exception->getMessage();
            
        }
        return $response;
    }

    public function createGigOrderTransaction( $params ){
        
        $response = array();

        $amount  = $params['plan_price'];
        if( !empty($params['gig_addons']) ){
            foreach($params['gig_addons'] as $single){
                $amount +=   $single['price']; 
            }
        }

        $country_detail          = Country::select('name')->where('id', $params['country_id'])->first();
        $buyer_country_full      = $country_detail->name;
        $buyer_state_full = '';
        
        if( !empty($params['state_id']) ){
            $state_detail            = CountryState::select('name')->where('id', $params['state_id'])->first();
            if( !empty($state_detail) ){
                $buyer_state_full        = $state_detail->name;
            }
        }
        try{

            $used_wallet_amt = 0;
            $charge_from_stripe = true;
            $stripe_price = $amount;
            if( $params['use_wallet_bal'] ){

                if( $params['wallet_balance'] >= $amount ){
                    $remaining_wallet_bal   = $params['wallet_balance'] - $amount;
                    $used_wallet_amt        = $amount;
                    $charge_from_stripe     = false;
                }else{
                    $used_wallet_amt        = $params['wallet_balance'];
                    $stripe_price           = $amount - $params['wallet_balance'];
                    $remaining_wallet_bal   = 0;
                }
            }

            if( $charge_from_stripe ){

                $stripe_price = $this->zero_decimal ?  $stripe_price : $stripe_price * 100;
                $params['user']->createOrGetStripeCustomer();
                $params['user']->updateDefaultPaymentMethod($params['stripe_payment_method']);
                $stripe_res = $params['user']->charge($stripe_price, $params['stripe_payment_method'],[
                    'description'   =>  __('transaction.transaction_desc')
                ]);
            }

            if( !$charge_from_stripe  || ( !empty($stripe_res) &&  $stripe_res->status == 'succeeded' ) ){
                
                $gig_order = GigOrder::create([
                    'author_id'             => $params['creator_id'],
                    'gig_id'                => $params['gig_id'],
                    'plan_type'             => $params['plan_type'],
                    'plan_amount'           => $amount,
                    'gig_features'          => null,
                    'gig_addons'            => !empty($params['gig_addons']) ? serialize($params['gig_addons']) : null,
                    'downloadable'          => !empty($params['downloadable']) ? $params['downloadable'] : null,
                    'gig_delivery_days'     => $params['delivery_time'],
                    'status'                => 'hired',
                    'gig_start_time'        => date('Y-m-d H:i:s')
                ]);

                $transaction = Transaction::create([
                    'creator_id'       => $params['creator_id'],
                    'trans_ref_no'     => $charge_from_stripe ? $stripe_res->id : null,
                    'payment_type'     => 'gig',
                    'payment_method'   => 'stripe',
                    'status'           => 'processed',
                ]);
    
                TransactionDetail::create([
                    'transaction_id'            => $transaction->id,
                    'amount'                    => ($amount - $used_wallet_amt),
                    'used_wallet_amt'           => $used_wallet_amt,
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

                $gig_order = GigOrder::select('id','author_id','gig_id','status','gig_start_time')->with([
                    'orderAuthor:id,user_id,first_name,last_name',
                    'gig:id,title,slug,author_id',
                    'gig.gigAuthor:id,user_id,first_name,last_name'
                ])->find($gig_order->id);

                if( $params['use_wallet_bal'] ){
                    
                    UserWallet::updateOrCreate(['profile_id' => $params['creator_id']], [
                        'profile_id'  => $params['creator_id'], 
                        'amount'      => $remaining_wallet_bal, 
                    ]);
                }
                   
                $gig_title      = $gig_order->gig->title;
                $gig_slug      = $gig_order->gig->slug;
                $seller_id      = $gig_order->gig->gigAuthor->user_id;
                $gig_author     = $gig_order->gig->gigAuthor->full_name;
                $order_author   = $gig_order->orderAuthor->full_name;
                $buyer_id       = $gig_order->orderAuthor->user_id;

                
                $eventData                  = array();
                $eventData['gig_title']     = $gig_title;
                $eventData['buyer_id']      = $buyer_id;
                $eventData['seller_id']     = $seller_id;
                $eventData['gig_author']    = $gig_author;
                $eventData['order_author']  = $order_author;
                $eventData['email_type']    = 'post_gig_order';
                
                event(new NotifyUser($eventData));

                $response['type']  = 'success';
                $response['return_url'] = route('gig-activity', ['slug' => $gig_slug, 'order_id' => $gig_order->id]);
            }

        }catch (\Exception $exception) {
            $response['type']  = 'error';
            $response['message']  = $exception->getMessage();
            
        }
        return $response;
    }
}
