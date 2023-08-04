<?php

namespace App\Http\Controllers\Gig;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Dispute;
use App\Models\Gig\Gig;
use App\Models\UserWallet;
use App\Models\Transaction;
use App\Models\Gig\GigOrder;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Services\EscrowPayment;
use App\Models\UserWalletDetail;
use App\Models\TransactionDetail;
use App\Models\UserBillingDetail;
use Illuminate\Support\Facades\DB;
use App\Models\Seller\SellerPayout;
use App\Models\Seller\SellerRating;
use App\Http\Controllers\Controller;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class GigActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $slug, Request $request){

        $user = getUserRole();
        $profile_id       = $user['profileId']; 
        $userRole         = $user['roleName'];
        $gig_order_id     = !empty($request->get('order_id')) ?  $request->get('order_id') : 0;
        
        $gig = Gig::select('id', 'author_id', 'title', 'attachments')->with([
        'categories' => function($query){
            $query->select('name','category_id', 'category_level');
            $query->orderBy('category_level', 'asc');
        },
        'gigAuthor' => function($query){
            $query->select('id','user_id', 'first_name', 'last_name', 'image');
        },
        'gig_orders' => function($query) use($userRole, $profile_id, $gig_order_id){
            $query->select(
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
            $query->with('orderAuthor:id,user_id,first_name,last_name,image');
            $query->whereIn('status' , array('hired','completed', 'disputed', 'refunded'));
            if( $userRole == 'buyer' ){
                $query->where(['author_id' => $profile_id]);
            }
            $query->where('id', $gig_order_id);
        }])->has('gigAuthor')->has('gig_orders')->where(['slug' => $slug, 'status' => 'publish'])->firstOrFail();
        
        if($gig->gig_orders->IsEmpty()  || ($userRole == 'seller' && $gig->author_id != $profile_id) ){
            abort('404');
        }

        $disputeType   = $userRole == 'buyer' ? 'buyer_dispute_issues'  : 'seller_dispute_issues';
        $disputeColumn = $userRole == 'buyer' ? 'buyer_issues'    : 'seller_issues';

        $currency               = setting('_general.currency');
        $disputeAfterDays       = setting('_dispute.buyer_dispute_after_days');
        $disputeType            = setting('_dispute.'.$disputeType);
        $disputeIssues          = !empty( $disputeType ) ? array_column($disputeType, $disputeColumn) : array();
        $disputeAfterDays       = !empty($disputeAfterDays) && is_numeric($disputeAfterDays) ? $disputeAfterDays : 3;
        
        $currency_detail        = !empty( $currency) ? currencyList($currency) : array();
        $currency_symbol        = '';
        if( !empty($currency_detail['symbol']) ){
            $currency_symbol = $currency_detail['symbol'];
        }

        $params = [
           'order_status'       => $gig->gig_orders[0]->status,
           'gig_order_id'       => $gig_order_id,
           'profile_id'         => $profile_id,
           'disputeAfterDays'   => $disputeAfterDays,
           'userRole'           => $userRole,
        ];
        $dispute_detail = $this->checkDisputeStatus($params);
        return view('front-end.gig.gig-activity', compact('gig', 'currency_symbol', 'dispute_detail', 'disputeIssues','slug'));
    }

    
    public function GigOrderCompletion(Request $request){

        $response = isDemoSite();
        if( $response ){

            return response()->json(['error' => [ 
                'title'     => __('general.demosite_res_title'),
                'type'      => 'error',
                'message'   => __('general.demosite_res_txt')
            ]]); 
        }

        $validator = Validator::make($request->all(), [
            'title'        => 'required',
            'rating'       => 'required|gt:0|max:5',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['validation_errors'=> $validator->errors()->all()]);
        }

        $user           = getUserRole();
        $profile_id     = $user['profileId']; 
        $userRole       = $user['roleName'];
        
        if( $userRole != 'buyer' ){

            return response()->json(['error' => [ 
                'type'      => 'error',
                'title'     => __('general.error_title'),
                'message'   => __('general.not_allowed'),
            ]]);
        }
       
        $gig_order = GigOrder::select('id', 'gig_id','author_id')->with('orderAuthor:id,first_name,last_name')->where(['author_id' => $profile_id, 'status' => 'hired'])->find( $request['order_id'] );
        
        if( empty($gig_order) ){

            return response()->json(['error' => [ 
                'type'      => 'error',
                'title'     => __('general.error_title'),
                'message'   => __('general.not_allowed'),
            ]]);
        }

        $gig = Gig::select('slug', 'author_id')->with('gigAuthor:id,user_id,first_name,last_name')->find($gig_order->gig_id);

        $transaction_detail = TransactionDetail::select('id', 'transaction_id')->where([
            'transaction_type'  => 4,
            'type_ref_id'       => $request['order_id']
        ])
        ->with('Transaction', function($query){
            $query->select('id', 'trans_ref_no', 'creator_id', 'invoice_ref_no', 'payment_method', 'status');
        })->whereHas('Transaction',function($query){
            $query->where('status', 'processed');
        })->latest()->first();

        if( empty($transaction_detail) ){

            return response()->json(['error' => [ 
                'title'     => __('general.error_title'),
                'type'      => 'error',
                'message'   => __('general.not_allowed')
            ]]);
        }

        $payment_method = $transaction_detail->transaction->payment_method;

        switch( $payment_method ){
            case 'escrow':

                $seller_billing_info    = UserBillingDetail::select('payout_settings')->where('profile_id', $gig->author_id)->first();
                $buyer_billing_info     = UserBillingDetail::select('payout_settings')->where('profile_id', $profile_id)->first();
                
                if( (empty($seller_billing_info)    || empty($seller_billing_info->payout_settings )) ){

                    return response()->json(['error' => [ 
                        'title'     => __('general.error_title'),
                        'type'      => 'error',
                        'message'   => __('transaction.seller_payout_setting_error')
                    ]]);  
                }elseif( (empty($buyer_billing_info)  || empty($buyer_billing_info->payout_settings )) ){

                    return response()->json(['error' => [ 
                        'title'     => __('general.error_title'),
                        'type'      => 'error',
                        'message'   => __('transaction.escrow_setting_error')
                    ]]); 
                }

                $seller_payouts_settings    = unserialize( $seller_billing_info->payout_settings );
                $buyer_payouts_settings     = unserialize( $buyer_billing_info->payout_settings );

                if( empty($seller_payouts_settings['escrow']) || empty($buyer_payouts_settings['escrow']) ){

                    return response()->json(['error' => [ 
                        'title'     => __('general.error_title'),
                        'type'      => 'error',
                        'message'   => __('transaction.seller_payout_setting_error')
                    ]]); 
                }
                
                $seller_escrow_email       = $seller_payouts_settings['escrow']['escrow_email'];
                $seller_escrow_api         = $seller_payouts_settings['escrow']['escrow_api'];
                $seller_escrow             = new EscrowPayment( $seller_escrow_email, $seller_escrow_api );

                $buyer_escrow_email       = $buyer_payouts_settings['escrow']['escrow_email'];
                $buyer_escrow_api         = $buyer_payouts_settings['escrow']['escrow_api'];
                $buyer_escrow             = new EscrowPayment( $buyer_escrow_email, $buyer_escrow_api );

                $response    = $seller_escrow->getTransaction(['transaction_id' => $transaction_detail->transaction->trans_ref_no]);
                
                if( $response['type'] == 'error' ){
                    return response()->json(['error' => $response]);
                }elseif( !$response['status']['shipped'] ){

                    $status = $seller_escrow->updateTransaction( $transaction_detail->transaction->trans_ref_no, 'ship' );
                    if( $status['type'] == 'error' ){
                        return response()->json(['error' => $status]);
                    }
                }
                if( !$response['status']['received'] ){

                    $status =  $buyer_escrow->updateTransaction( $transaction_detail->transaction->trans_ref_no, 'receive' );
                    if( $status['type'] == 'error' ){
                        return response()->json(['error' => $status]);
                    }
                }
                if( !$response['status']['accepted'] ){

                    $status = $buyer_escrow->updateTransaction( $transaction_detail->transaction->trans_ref_no, 'accept' );
                    if( $status['type'] == 'error' ){
                        return response()->json(['error' => $status]);
                    }
                }
            break;

            case 'stripe': 
                $seller_payout = SellerPayout::where('transaction_id', $transaction_detail->transaction->id)->first();
                if( !empty($seller_payout)  ){

                    if( $seller_payout->admin_commission > 0 ){

                        AdminPayout::updateOrCreate(['transaction_id' => $transaction_detail->transaction->id], [
                            'transaction_id'    => $transaction->id,
                            'amount'            => $seller_payout->admin_commission,
                        ]);
                    }

                    $user_wallet        = UserWallet::where('profile_id' , $gig->author_id)->first();
                    $wallet_profile_id  = !empty($user_wallet) ? $user_wallet->profile_id : 0;
                    $wallet_amount      = !empty($user_wallet) ? $user_wallet->amount : 0;
                    $wallet_amount      += $seller_payout->seller_amount;

                    $wallet = UserWallet::updateOrCreate(['profile_id' => $wallet_profile_id], [
                        'profile_id'  => $gig->author_id, 
                        'amount'      => $wallet_amount, 
                    ]);

                    UserWalletDetail::create([
                        'transaction_id'    => $transaction_detail->transaction->id, 
                        'wallet_id'         => $wallet->id, 
                        'amount'            => $seller_payout->seller_amount, 
                    ]);
                }
            break;   
        }

        Transaction::where('id',  $transaction_detail->transaction->id)->update(['status' => 'completed']);
        $gig_order->update(['status' => 'completed']);
        $title          = !empty($request['title']) ? $request['title'] : '';
        $rating         = !empty($request['rating']) ? $request['rating'] : 0;
        $description    = !empty($request['description']) ? $request['description'] : '';

        SellerRating::select('id')->updateOrCreate([
            'seller_id'         => $gig->author_id,
            'corresponding_id'  => $gig_order->id,
            'type'              => 'gig_order',
            'buyer_id'          => $profile_id,
        ],[
            'seller_id'             => $gig->author_id,
            'buyer_id'              => $profile_id,
            'corresponding_id'      => $gig_order->id,
            'type'                  => 'gig_order',
            'rating'                => sanitizeTextField($rating),
            'rating_title'          => sanitizeTextField($title),
            'rating_description'    => sanitizeTextField($description, true) ,
        ]);

        // send email to seller for order completion
        $email_template = EmailTemplate::select('content')
        ->where(['type' => 'order_completed' , 'status' => 'active', 'role' => 'seller'])
        ->latest()->first();
    
        if( !empty($email_template) ){
            $template_data              =  unserialize($email_template->content);
            $params                     = array();
            $params['template_type']    = 'order_completed';
        
            $params['email_params']     = array(
                'user_name'             => $gig->gigAuthor->full_name,
                'buyer_name'            => $gig_order->orderAuthor->full_name,
                'order_id'              => $request['order_id'],
                'buyer_comments'        => sanitizeTextField($description, true),
                'buyer_rating'          => sanitizeTextField($rating),
                'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
            );
            try {
                User::find($gig->gigAuthor->user_id)->notify(new EmailNotification($params));
            } catch (\Exception $e) {
                return response()->json(['error' => [ 
                    'title'     => __('general.error_title'),
                    'type'      => 'error',
                    'message'   => $e->getMessage(),
                    'autoClose' => 10000,
                ]]); 
            }
        }

        return response()->json(['success' => [ 
            'title'         => __('general.success_title'),
            'type'          => 'success',
            'message'       => __('general.success_message'),
            'redirectUrl'   => route('gig-activity',[ 'slug' => $gig->slug, 'order_id' => $request['order_id']]),
            'autoClose'     => 3000,
        ]]); 
    }

    public function checkDisputeStatus( $params ){

        $dispute_detail = [];

        if( $params['order_status'] == 'disputed' || $params['order_status'] == 'refunded'){
            
            $dispute = Dispute::where('gig_order_id', $params['gig_order_id'])
            ->where( function($query) use($params){
                $query->where('created_by', $params['profile_id'])->orWhere('created_to', $params['profile_id']);
            })->select('id', 'created_by', 'created_to', 'resolved_by', 'favour_to', 'status','created_at')->with(['disputeCreator'])->first();
            
            if( !empty($dispute) ){

                $dispute_detail['disputed']         = true;
                $dispute_detail['dispute_id']        = $dispute->id;
                $dispute_detail['dispute_status']   = $dispute->status; 
                $createdBy                          = $dispute->created_by;
                $role_id                            = $dispute->disputeCreator->role_id;
                $creatorRole                        = getRoleById($role_id);
                $disputedTime                       = Carbon::parse($dispute->created_at)->diffInDays();

                if( $dispute->status == 'publish' ){

                    $dispute_detail['dispute_class']         = 'tk-notify-alert';
                    if( ( $disputedTime > $params['disputeAfterDays'] ) && ( $params['userRole'] == 'buyer' ) && ( $creatorRole == 'buyer' ) ){

                        $dispute_detail['dispute_status_txt']   = __('disputes.dispute_no_resp_status');
                        $dispute_detail['dispute_desc_txt']     = __('disputes.dispute_no_resp_desc');
                        $dispute_detail['dispute_status']       = 'declined';
                        $dispute_detail['status_icon']          = asset('images/icons/duration.png'); 
                    }else{

                        $dispute_detail['dispute_status_txt']  =  __('disputes.gig_dispute_create_status');
                        $dispute_detail['dispute_desc_txt']    =  __('disputes.dispute_create_desc');
                        $dispute_detail['status_icon']         = asset('images/icons/alert.png'); 
                    }
                }elseif( $dispute->status == 'declined' ){

                    $dispute_detail['dispute_status_txt']   = __('disputes.dispute_reject_status');
                    $dispute_detail['dispute_desc_txt']     = $params['userRole'] == 'buyer' ? __('disputes.dispute_reject_desc') : __('disputes.dispute_reject_seller_desc');
                    $dispute_detail['status_icon']          = $params['userRole'] == 'buyer' ? asset('images/icons/duration.png') : asset('images/icons/alert.png'); 
                    $dispute_detail['dispute_class']        = 'tk-notify-alert';

                }elseif( $dispute->status == 'disputed' && $creatorRole == 'buyer' ){

                    $dispute_detail['dispute_status_txt']   = __('disputes.dispute_wait_status');
                    $dispute_detail['dispute_desc_txt']     = __('disputes.dispute_wait_desc');
                    $dispute_detail['status_icon']          = asset('images/icons/waiting.png'); 
                    $dispute_detail['dispute_class']        = 'tk-notify-dispute';
                }elseif( $dispute->status == 'disputed' && $creatorRole == 'seller' ){

                    $dispute_detail['dispute_status_txt']   = __('disputes.gig_dispute_create_status');
                    $dispute_detail['dispute_desc_txt']     = __('disputes.dispute_create_desc');
                    $dispute_detail['status_icon']          = asset('images/icons/alert.png'); 
                    $dispute_detail['dispute_class']        = 'tk-notify-alert';
                }elseif( $dispute->status == 'refunded') {
                    
                    $dispute_detail['dispute_status_txt']   = $dispute->favour_to == $params['userRole'] ? __('disputes.dispute_refunde_favor_status') : __('disputes.dispute_refund_reject_status');
                    $dispute_detail['dispute_desc_txt']     = $dispute->favour_to == $params['userRole'] ?  __('disputes.gig_dispute_refunde_favor_desc') : __('disputes.dispute_refund_reject_desc');
                    $dispute_detail['status_icon']          = $dispute->favour_to == $params['userRole'] ? asset('images/icons/success.png') : asset('images/icons/cross.png'); 
                    $dispute_detail['dispute_class']        = $dispute->favour_to == $params['userRole'] ?  'tk-notify-success' : 'tk-notify-alert';
                }
            }else {
                $dispute_detail['disputed'] = false;
            }
        }else{
            $dispute_detail['disputed'] = false;
        }

        return $dispute_detail;
    }

    public function RaiseDisputeToAdmin($id){

        $response = isDemoSite();
        if( $response ){
            return redirect()->back(); 
        }

        $user       = getUserRole();
        $profile_id = $user['profileId']; 
        $dispute    = Dispute::select('id','created_by', 'created_to', 'dispute_log','gig_order_id')->where('status', 'declined')->find($id);
        if( !empty($dispute) && ($dispute->created_by == $profile_id || $dispute->created_to == $profile_id) ){

            $dispute_log = !empty( $dispute->dispute_log ) ? unserialize($dispute->dispute_log)  : array();
            $dispute_log['2'] = array(
                'action_by'     => $profile_id,
                'action_date'   => date('Y-m-d H:i:s')
            );

            $updateStatus = $dispute->update([ 
                'status'        => 'disputed', 
                'resolved_by'   => 'admin',
                'dispute_log'   => serialize($dispute_log),
            ]);
            // send email to admin 
            $dispute->load(['gigOrder' => function ( $query ) {
                $query->select('id','gig_id');
                $query->with('gig:id,title');
            }]);

            

            $email_template = EmailTemplate::select('content')
            ->where(['type' => 'admin_received_dispute' , 'status' => 'active', 'role' => 'admin'])
            ->latest()->first();
            
            if(!empty($email_template)){
                
               
                $gigTitle = !empty( $dispute->gigOrder->gig->title ) ? $dispute->gigOrder->gig->title : '';
                    //admin info
                $NotifyUser = User::whereHas(
                    'roles', function($q){
                        $q->where('name', 'admin');
                    }
                )->latest()->first();

                
                $template_data              =  unserialize($email_template->content);
                $params                     = array();
                $params['template_type']    = 'admin_received_dispute';
                $params['email_params']     = array(
                    'user_name'             => '',
                    'project_title'         => $gigTitle,
                    'type'                  => 'gig',
                    'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                    'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                    'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
                );
                
                try {
                    Notification::send($NotifyUser, new EmailNotification($params));
                } catch (\Exception $e) {
                    $error_msg = $e->getMessage();
                }
            }
        //end sent email
        }
        return redirect()->back();
    }

    public function GigOrderDispute(Request $request){
        
        $response = isDemoSite();
        if( $response ){

            return response()->json(['error' => [ 
                'title'     => __('general.demosite_res_title'),
                'type'      => 'error',
                'message'   => __('general.demosite_res_txt')
            ]]); 
        }

        $validator = Validator::make($request->all(), [
            'dispute_issue'          => 'required',
            'term_conditions'        => 'required',
            'dispute_detail'         => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['validation_errors'=> $validator->errors()->all()]);
        }
        $user           = getUserRole();
        $profile_id     = $user['profileId']; 
        $userRole       = $user['roleName'];

        if( $userRole == 'buyer' || $userRole == 'seller' ){
            
            $refund_price   = '';
            $gig_order = GigOrder::select('id', 'gig_id', 'plan_amount', 'author_id');
            if($userRole == 'buyer'){
                $gig_order = $gig_order->with('orderAuthor:id,first_name,last_name');
            }
            $gig_order = $gig_order->where(['status' => 'hired'])->find($request['order_id']);
       
            if( empty($gig_order) ){
    
                return response()->json(['error' => [ 
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => __('general.not_allowed'),
                ]]);
            }

            $gig = Gig::select('slug', 'author_id');
            if( $userRole == 'buyer'){
                $gig = $gig->with('gigAuthor:id,user_id,first_name,last_name');
            }

            $gig = $gig->find($gig_order->gig_id);

            $refund_price       = $gig_order->plan_amount;
            $dispute_issue      = !empty($request['dispute_issue']) ? $request['dispute_issue'] : '';
            $dispute_detail     = !empty($request['dispute_detail']) ? $request['dispute_detail'] : '';
           
            $dispute_log = array(
                '0' =>  array(
                    'action_by'     => $profile_id,
                    'action_date'   => date('Y-m-d H:i:s')
                )
            );
            $data = array();
            $data['created_by']     = $profile_id;
            $data['created_to']     = $userRole == 'buyer' ? $gig->author_id : $gig_order->author_id;
            $data['price']          = $refund_price;
            $data['proposal_id']    = null;
            $data['gig_order_id']   = $gig_order->id;
            $data['dispute_issue']  = sanitizeTextField($dispute_issue);
            $data['dispute_detail'] = sanitizeTextField($dispute_detail, true);
            $data['status']         = $userRole == 'buyer' ? 'publish' : 'disputed';
            $data['resolved_by']    = $userRole == 'buyer' ? 'seller' : 'admin';
            $data['dispute_log']    = serialize($dispute_log);
            
            DB::beginTransaction();
            try{

                Dispute::create($data);
                $gig_order->update(['status' => 'disputed']);
                DB::commit();

                // send email to admin
               
                $content_role   = $userRole == 'buyer' ? 'seller' : 'admin';
                $email_template = EmailTemplate::select('content')
                ->where(['type' => 'order_refund_request' , 'status' => 'active', 'role' => $content_role])
                ->latest()->first();

                if(!empty($email_template)){

                    $emailReceiver  = '';
                    $userName       = '';
                    $buyerName      = '';
                    $buyerComments  = '';
                   
                    if($userRole == 'buyer'){
                       $userName        = $gig->gigAuthor->full_name;
                       $emailReceiver   = User::whereId($gig->gigAuthor->user_id)->first();
                       $buyerName       = $gig_order->orderAuthor->full_name;
                       $buyerComments   = sanitizeTextField($dispute_detail, true);
                    } else {
                        //admin info
                        $emailReceiver = User::whereHas(
                            'roles', function($q){
                                $q->where('name', 'admin');
                            }
                        )->latest()->first();
                    }
                    
                    $template_data              =  unserialize($email_template->content);
                    $params                     = array();
                    $params['template_type']    = 'order_refund_request';
                    $params['email_params']     = array(
                        'user_name'             => $userName,
                        'buyer_name'            => $buyerName,
                        'order_id'              => $gig_order->gig_id,
                        'buyer_comments'        => $buyerComments,
                        'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                        'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                        'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
                    );
                    try {
                        $emailReceiver->notify(new EmailNotification($params));
                    } catch (\Exception $e) {
                        return response()->json(['error' => [ 
                            'title'     => __('general.error_title'),
                            'type'      => 'error',
                            'message'   => $e->getMessage(),
                            'autoClose' => 10000,
                        ]]); 
                    }
                    
                }
                //end sent email
                return response()->json(['success' => [ 
                    'type'          => 'success',
                    'title'         => __('general.success_title'),
                    'message'       => __('gig.gig_disputed_alert'),
                    'redirectUrl'   => route('gig-activity',[ 'slug' => $gig->slug, 'order_id' => $gig_order->id]),
                    'autoClose'     => 2000,
                ]]);
            }catch(\Exception $e) {
                DB::rollback();

                return response()->json(['error' => [ 
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => $e->getMessage(),
                ]]);
            }
        }
    }
}
