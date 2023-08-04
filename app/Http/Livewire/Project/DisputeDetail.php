<?php

namespace App\Http\Livewire\Project;

use File;
use ZipArchive;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Dispute;
use App\Models\Profile;
use App\Models\Project;
use Livewire\Component;
use App\Models\UserWallet;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use App\Models\Gig\GigOrder;
use App\Models\EmailTemplate;
use App\Services\EscrowPayment;
use App\Models\UserWalletDetail;
use App\Models\Proposal\Proposal;
use App\Models\TransactionDetail;
use App\Models\DisputeConversation;
use App\Notifications\EmailNotification;
use App\Models\Proposal\ProposalMilestone;
use Illuminate\Support\Facades\Notification;


class DisputeDetail extends Component
{
    public $dispute_id, $proposal_id, $gig_order_id, $profile_id, $userRole, $currency_symbol, $date_formate;
    public $reply_btn_text, $reply_btn_class;
    public $show_reply_box  = false;
    public $refund_action   = 'reply';
    private $actionsList    = array('reply','refund','decline');
    public $reply_message   = '';
    public $status          = '';
    public $dispute_title   = '';
    

    public $dispute_author_role     = '';
    public $dispute_author_name     = '';
    public $dispute_author_image    = '';
  
    public $disp_receiver_role  = '';
    public $disp_receiver_name  = '';
    public $disp_receiver_image = '';
   

    public $proposal_amount     = 0;
    public $gig_order_amount    = 0;
    public $payout_type         = '';
    public $milestones          = array();
    public $timecards           = array();
    public $refund_amount       = 0;
    public $initiateChatuser    = '';
    public $dispute_issue       = '';
    public $dispute_detail      = '';
    public $resolved_by         = '';
    public $created_to          = '';
    public $created_by          = '';
    public $showTimeLimitMsg    = false;
    public $showAcknowledgeBtn  = false;
    public $disputeAfterDays    = '3';
    public $dispute_log         = [];
    private $gig_addons         = [];
    public $dispute_created_at  = '';
    protected $queryString      = [
        'dispute_id'  => ['except' => 0, 'as'=> 'id'],
    ];
    
    public function mount(){

        $date_format                = setting('_general.date_format');
        $currency                   = setting('_general.currency');
        $buyer_dispute_after_days   = setting('_dispute.buyer_dispute_after_days');

        $currency_detail            = !empty( $currency)  ? currencyList($currency) : array();
        $this->date_format          = !empty($date_format)  ? $date_format : 'm d, Y';
        $this->disputeAfterDays     = !empty($buyer_dispute_after_days) && is_numeric($buyer_dispute_after_days) ? $buyer_dispute_after_days : 3;

        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }

        $this->reply_btn_text   = __('proposal.post_reply');
        $this->reply_btn_class  = 'tb-btn tb-replytabbtn';

        $user = getUserRole();
        $this->profile_id       = $user['profileId']; 
        $this->userRole         = $user['roleName'];
        
        $disputeData = Dispute::where(function ($query) {
            $query->where('created_by',$this->profile_id);
            $query->orWhere('created_to', $this->profile_id);
        } )->select(
            'id','created_by','created_to','price',
            'dispute_issue','dispute_detail','dispute_log',
            'status','proposal_id','gig_order_id','resolved_by','created_at')
        ->with([
            'disputeCreator:id,first_name,last_name,role_id,image',
            'disputeReceiver:id,first_name,last_name,role_id,image',
            'proposal:id,project_id,proposal_amount,payout_type,status',
            'proposal.project:id,project_title'
        ])->has('disputeCreator')->has('disputeReceiver')->findOrFail($this->dispute_id);
            
        if( !empty($disputeData->proposal_id) ){

            if( $disputeData->proposal->payout_type == 'milestone' ){
            
                $disputeData->load(['proposal.milestones'=> function ($query) {
                    $query->whereIn('status',['processed','cancelled','queued', 'refunded']);
                    $query->select('status','id','proposal_id','price','title');
                }]);
            }elseif( $disputeData->proposal->payout_type == 'hourly' ){
    
                $disputeData->load(['proposal.timecards' => function ($query) {
                    $query->whereIn('status',['processed','cancelled','queued']);
                    $query->select('status','id','proposal_id','price','title');
                }]);
            }
            
            if( !empty($disputeData->proposal) ) {

                $this->proposal_amount  = $disputeData->proposal->proposal_amount;
                $this->proposal_id      = $disputeData->proposal->id;
                $this->payout_type      = $disputeData->proposal->payout_type;
    
                    if( $this->payout_type == 'milestone' ){
    
                        if(!$disputeData->proposal->milestones->isEmpty())
                        $this->milestones       = $disputeData->proposal->milestones;
                        $this->refund_amount   = $disputeData->proposal->milestones->sum('price');
                    }elseif( $this->payout_type == 'hourly' ){
    
                        $this->timecards        = $disputeData->proposal->timecards;
                        $this->refund_amount   = $disputeData->proposal->timecards->sum('price');
                    }else {
                        $this->refund_amount = $disputeData->proposal->proposal_amount;
                    }
    
                if( !empty($disputeData->proposal->project) ){
                    $this->dispute_title  = $disputeData->proposal->project->project_title;
                }
            }
        }else{

            $disputeData->load([
                'gigOrder:id,gig_id,plan_amount,gig_addons,status',
                'gigOrder.gig:id,title'
            ]);

            $this->gig_addons           = $disputeData->gigOrder->gig_addons;
            $this->refund_amount        = $disputeData->gigOrder->plan_amount;
            $this->gig_order_id         = $disputeData->gigOrder->id;
            $this->gig_date             = $disputeData->gigOrder->gig->updated_at;
            $this->dispute_title        = $disputeData->gigOrder->gig->title;
            $this->payout_type          = 'gig_order';
        } 

        if( $disputeData->status == 'publish' ){
            $this->show_reply_box = true;
        }
        $this->dispute_created_at   = $disputeData->created_at;
        $this->dispute_issue        = $disputeData->dispute_issue;
        $this->dispute_detail       = $disputeData->dispute_detail;
        $this->status               = $disputeData->status;
        $this->resolved_by          = $disputeData->resolved_by;
        $this->created_to           = $disputeData->created_to;
        $this->created_by           = $disputeData->created_by;

        $this->dispute_log                = !empty($disputeData->dispute_log) ? unserialize($disputeData->dispute_log) : array();
       
        if( !empty($disputeData->disputeCreator) ){

            $this->dispute_author_role    = getRoleById($disputeData->disputeCreator->role_id);
            $this->dispute_author_name    = $disputeData->disputeCreator->full_name;
            $this->dispute_author_image   = $disputeData->disputeCreator->image;

            $image_path                     = getProfileImageURL($disputeData->disputeCreator->image, '50x50');
            $this->dispute_author_image     = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-50x50.png';
        }

        if( !empty($disputeData->disputeReceiver) ){
            $this->disp_receiver_role    = getRoleById($disputeData->disputeReceiver->role_id);
            $this->disp_receiver_name    = $disputeData->disputeReceiver->full_name;
            $this->disp_receiver_image   = $disputeData->disputeReceiver->image;

            $rec_image_path             = getProfileImageURL($disputeData->disputeReceiver->image, '50x50');
            $this->disp_receiver_image  = !empty($rec_image_path) ? 'storage/' . $rec_image_path : 'images/default-user-50x50.png';
            
        }
        if( $disputeData->status == 'publish' && getRoleById($disputeData->resolved_by) == 'seller' && $this->userRole == 'seller'){
            $this->showTimeLimitMsg = true;
        }
        $disputedTime   = Carbon::parse($disputeData->created_at)->diffInDays();
        
        if( ( $disputedTime > $this->disputeAfterDays ) && ( $this->userRole == 'buyer' ) && ( $this->dispute_author_role == 'buyer' ) ){
            $this->showAcknowledgeBtn = true;
        }
    }
    
    public function render(){

        $chat = DisputeConversation::where('dispute_id', $this->dispute_id)->whereNull('message_id')
        ->with(['userInfo:id,role_id,first_name,last_name,image','replyMessages.userInfo:id,role_id,first_name,last_name,image'])
        ->orderBy('id','asc')->get();

        $chatId = 'tk_chat_'.time();
        $this->dispatchBrowserEvent('initializeScrollbar', array('chatId' => $chatId) );
        $gig_addons = !empty($this->gig_addons) ? unserialize($this->gig_addons) : [];
     
        if( !empty($this->dispute_log) ){
            $userIds  = !empty($this->dispute_log) ? Arr::pluck($this->dispute_log, 'action_by') : [];
            if( !empty($userIds) ){
                
                $users = Profile::whereIn('id', $userIds)->select('id', 'role_id', 'first_name', 'last_name' )->get();
                foreach($this->dispute_log as $key => $dispute){
                   foreach($users as $user){
                        if($dispute['action_by'] ==  $user->id){
                            $this->dispute_log[$key]['username']    = $user->first_name_last_letter;
                            $this->dispute_log[$key]['role_id']     = $user->role_id;
                        }
                   }
                }
            }
        }

        return view('livewire.project.dispute-detail', compact('chat', 'chatId', 'gig_addons'))->extends('layouts.app');
        
    }

    public function downloadAttachments( $id ){
        
        $dispute_attachments = DisputeConversation::select('attachments');
        $dispute_attachments = $dispute_attachments->where('id', $id)->first();

        if(!empty($dispute_attachments) && !empty($dispute_attachments->attachments)){
            
            $attachments = unserialize($dispute_attachments->attachments);
            $path = storage_path('app/download/disputes/'.$id);

            if (!file_exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $project_files  = $attachments;
            $zip            = new ZipArchive;
            $fileName       = '/attachments.zip';
            $path           = $path .$fileName;
            
            $zip->open($path, ZipArchive::CREATE);

            foreach ($project_files as $single) {
                $name = basename($single['file_name']);
                if(file_get_contents(public_path('storage/'.$single['file_path']))){
                    $zip->addFromString( $name, file_get_contents(public_path('storage/'.$single['file_path'])));
                }
            }

            $zip->close();
            return response()->download(storage_path('app/download/disputes/' . $id . $fileName));
            
        }
    }

    public function refundAction($action){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
       
        if( in_array($action, $this->actionsList) ){
        
            $this->validate([
                'reply_message' => 'required',
            ]);

            $disputeLog = Dispute::select('dispute_log','id','proposal_id','gig_order_id')->find($this->dispute_id);
            $isSendMessage = $isnotifyUser = false;
            $dispute_log = '';
            if( $action == 'refund' || $action == 'decline') {
               
                $dispute_log = !empty( $disputeLog->dispute_log ) ? unserialize ($disputeLog->dispute_log)  : array();
                $disputeLogStatus = $action == 'refund' ? '3' : '1';

                $dispute_log[$disputeLogStatus] = array(
                    'action_by' => $this->profile_id,
                    'action_date' => date('Y-m-d H:i:s')
                );

                if($action == 'refund'){
                    $dispute_log['4'] = array(
                        'action_by' => $this->created_by,
                        'action_date' => date('Y-m-d H:i:s')
                    );
                }
            }

            if( $action == 'refund' ){

                $transaction = '';

                if( $this->payout_type == 'milestone' ){
                    
                    $milestone_ids = [];
                    $proposal_milestone = ProposalMilestone::select('id')
                    ->where('proposal_id' , $this->proposal_id)
                    ->whereIn('status', array('processed', 'queued', 'cancelled'))->get();
                    
                    if( !$proposal_milestone->isEmpty() ){
                        foreach($proposal_milestone as $single){
                            $milestone_ids[] = $single->id;
                        }
                    } 
                
                    if( !empty($milestone_ids) ){
                        $transaction = TransactionDetail::select('id', 'amount', 'used_wallet_amt', 'transaction_id', 'type_ref_id')->where('transaction_type', 1)
                        ->whereIn('type_ref_id', $milestone_ids);    
                    }
                }elseif( $this->payout_type == 'fixed' ){

                    $transaction = TransactionDetail::select('id', 'amount', 'used_wallet_amt', 'transaction_id', 'type_ref_id')->where([
                        'transaction_type'  => 2,
                        'type_ref_id'       => $this->proposal_id
                    ]);
                }elseif( $this->payout_type == 'gig_order' ){

                    $transaction = TransactionDetail::select('id', 'amount', 'used_wallet_amt', 'transaction_id', 'type_ref_id')->where([
                        'transaction_type'  => 4,
                        'type_ref_id'       => $this->gig_order_id
                    ]); 
                }
                
                if( !empty($transaction) ){

                    $transaction_detail = $transaction->with('Transaction', function($query){
                        $query->select('id', 'trans_ref_no', 'creator_id', 'invoice_ref_no', 'payment_method', 'status');
                    })->whereHas('Transaction', function($query){
                        $query->whereIn('status', array('processed', 'cancelled'));
                    })->get();

                    if( !$transaction_detail->isEmpty() ){

                        foreach($transaction_detail as $single){

                            $payment_method = $single->transaction->payment_method;

                            switch( $payment_method ){
                                
                                case 'escrow':
                                    $escrow   = new EscrowPayment();
                                    $params = array(
                                        "cancel_information" => array(
                                            "cancellation_reason" => sanitizeTextField($this->reply_message, true)
                                        )
                                    );
                                    $response = $escrow->updateTransaction( $single->transaction->trans_ref_no, 'cancel', $params);
                                    if( $response['type'] == 'error' ){
                                        $this->dispatchBrowserEvent('showAlertMessage', $response);
                                        return;
                                    }
                                break;

                                case 'stripe':

                                    $user_wallet        = UserWallet::where('profile_id' , $single->transaction->creator_id)->first();
                                    $wallet_profile_id  = !empty($user_wallet) ? $user_wallet->profile_id : 0;
                                    $wallet_amount      = !empty($user_wallet) ? $user_wallet->amount : 0;
                                    $wallet_amount      += ($single->amount + $single->used_wallet_amt);
    
                                    $wallet = UserWallet::updateOrCreate(['profile_id' => $wallet_profile_id], [
                                        'profile_id'  => $single->transaction->creator_id, 
                                        'amount'      => $wallet_amount, 
                                    ]);
                                    UserWalletDetail::create([
                                        'transaction_id'    => $single->transaction->id, 
                                        'wallet_id'         => $wallet->id, 
                                        'amount'            => ($single->amount + $single->used_wallet_amt), 
                                    ]);
                                break;        
                            }

                            if( $this->payout_type == 'milestone' ){
                                ProposalMilestone::where('id', $single->type_ref_id)->update(['status' => 'refunded']);
                            }
                            Transaction::where('id', $single->transaction->id)->update(['status' => 'refunded']);
                        }

                        $this->dispute_log = $dispute_log;
                        $updateDispute = Dispute::where('id', $this->dispute_id)->update(['status' => 'refunded', 'favour_to' => 'buyer', 'dispute_log' => serialize($dispute_log) ]);
                        if( $this->payout_type == 'gig_order' ){
                            GigOrder::where('id', $this->gig_order_id)->update(['status' => 'refunded']);
                        }else{

                            Proposal::where('id', $this->proposal_id)->update(['status' => 'refunded']);
                            
                            $proposal = Proposal::select('project_id')->find($this->proposal_id);
                            $refunded_proposals   = Proposal::where('project_id', $proposal->project_id)->where('status', 'refunded')->count('id');
                            $project = Project::select('id', 'project_hiring_seller', 'status')->find($proposal->project_id);
                            if($project->status == 'hired' && $project->project_hiring_seller == $refunded_proposals ){
                                $project->update(['status' => 'cancelled']);
                            }
                        }
                        $this->show_reply_box = false;
                        $this->status = 'refunded';
                        if($updateDispute){
                            $isSendMessage = true;
                        }
                        $isnotifyUser = true;
                    }         
                }
            }elseif( $action == 'decline' ){

                $this->dispute_log = $dispute_log;
                $updateDispute = Dispute::where('id', $this->dispute_id)->update(['status' => 'declined', 'dispute_log' => serialize($dispute_log) ]);
                $this->dispute_log = $dispute_log;
                $this->show_reply_box   = false;
                $this->status           = 'declined';
                if($updateDispute){
                    $isnotifyUser = true;
                    $isSendMessage = true;
                }
            }
            
            if( $isnotifyUser || $action == 'reply' ){
                
                // send email to buyer/seller
                if( $action == 'reply'){
                    $email_template_type = $this->payout_type == 'gig_order' ? 'order_refund_reply' : 'comment_on_dispute';
                }elseif( $action == 'refund' ){
                    $email_template_type = $this->payout_type == 'gig_order' ? 'seller_appr_order_dispute_req' : 'seller_approved_dispute_req';
                }elseif( $action == 'decline' ){
                    $email_template_type = $this->payout_type == 'gig_order' ? 'seller_decline_dispute_order' : 'seller_decline_dispute';
                }

                $role = $this->userRole == 'buyer' ? 'seller' : 'buyer';
                $email_template = EmailTemplate::select('content')
                ->where(['type' => $email_template_type , 'status' => 'active', 'role' => $role])
                ->latest()->first();
                    
                if( !empty($email_template) ){

                    $template_data              =  unserialize($email_template->content);
                    $params                     = array();
                    $params['template_type']    = $email_template_type;
                    
                    $userName = $userId = '';
                    if( $this->userRole == 'buyer' ){

                        if($this->payout_type == 'gig_order'){

                            $disputeLog->load(['gigOrder'=>function($query){
                                $query->select('id','author_id','gig_id');
                                $query->with(['gig:id,author_id', 'gig.gigAuthor:id,user_id,first_name,last_name']);
                            }]);
                        
                            $userId     = $disputeLog->gigOrder->gig->gigAuthor->user_id;
                            $userName   = $disputeLog->gigOrder->gig->gigAuthor->full_name;
                        }else{

                            $disputeLog->load(['proposal'=>function($query){
                                $query->select('id','author_id');
                                $query->with('proposalAuthor:id,user_id,first_name,last_name');
                            }]);
    
                            $userId = !empty($disputeLog->proposal->proposalAuthor->user_id) ? $disputeLog->proposal->proposalAuthor->user_id : '';
                            $userName = !empty($disputeLog->proposal->proposalAuthor->full_name) ? $disputeLog->proposal->proposalAuthor->full_name : '';
                        }
                       
                    }elseif( $this->userRole == 'seller' ){

                        if( $this->payout_type == 'gig_order' ){

                            $disputeLog->load(['gigOrder'=>function($query){
                                $query->select('id','author_id');
                                $query->with('orderAuthor:id,user_id,first_name,last_name');
                            }]);
                            
                            $userId     = $disputeLog->gigOrder->orderAuthor->user_id;
                            $userName   = $disputeLog->gigOrder->orderAuthor->full_name;
                        } else {
                            $disputeLog->load(['proposal'=>function($query){
                                $query->select('id','project_id');
                                $query->with(['project:id,author_id','project.projectAuthor:id,user_id,first_name,last_name']);
                            }]);
                            $userId = !empty($disputeLog->proposal->project->projectAuthor->user_id) ? $disputeLog->proposal->project->projectAuthor->user_id : '';
                            $userName = !empty($disputeLog->proposal->project->projectAuthor->full_name) ? $disputeLog->proposal->project->projectAuthor->full_name : '';
                        }
                    }

                    $getUserInfo  = getUserInfo();
                
                    $params['email_params'] = array(
                        'user_name'             => $userName,
                        'sender_name'           => $getUserInfo['user_name'],
                        'project_title'         => $this->dispute_title,
                        'order_id'              => $disputeLog->gig_order_id,
                        'gig_title'             => $this->dispute_title,
                        'sender_comments'       => sanitizeTextField( $this->reply_message, true ),
                        'email_subject'         => !empty($template_data['subject'])  ?   $template_data['subject'] : '',     
                        'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                        'email_content'         => !empty($template_data['content'])  ?   $template_data['content'] : '',     
                    );
                
                    $notifyUser = User::find($userId);
                
                    if(!empty($notifyUser)){
                        try {
                            Notification::send($notifyUser, new EmailNotification($params));
                        } catch (\Exception $e) {
                            $this->dispatchBrowserEvent('showAlertMessage', [
                                'type'      => 'error',
                                'title'     => __('general.error_title'),
                                'message'   => $e->getMessage(),
                                'autoClose' => 10000,
                            ]);
                        }
                    }
                }
                //end sent email
            }

            // send reply message.
            if( $isSendMessage || $action == 'reply' ){

                $insert = DisputeConversation::create([
                    'sender_id'     => $this->profile_id,
                    'dispute_id'    => $this->dispute_id,
                    'message'       => sanitizeTextField( $this->reply_message, true ),
                ]);

                $this->reply_message = '';
            }
        }
    } 
}
