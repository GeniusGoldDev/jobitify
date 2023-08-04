<?php

namespace App\Http\Livewire\Admin\Disputes;

use File;
use ZipArchive;
use App\Models\User;
use App\Models\Dispute;
use App\Models\Gig\Gig;
use App\Models\Project;
use Livewire\Component;
use App\Models\UserWallet;
use App\Models\AdminPayout;
use App\Models\Transaction;
use App\Models\Gig\GigOrder;
use App\Models\EmailTemplate;
use Livewire\WithFileUploads;
use App\Services\EscrowPayment;
use App\Models\UserWalletDetail;
use App\Models\Proposal\Proposal;
use App\Models\TransactionDetail;
use App\Models\UserBillingDetail;
use Illuminate\Support\Facades\DB;
use App\Models\DisputeConversation;
use App\Models\Seller\SellerPayout;
use App\Notifications\EmailNotification;
use App\Models\Proposal\ProposalTimecard;
use App\Models\Proposal\ProposalMilestone;
use Illuminate\Support\Facades\Notification;

class DisputeDetail extends Component
{
    use WithFileUploads;
    public $image, $old_image, $payout_type; 
    
    public $seller_id           = '';
    public $buyer_id            = '';
    public $profile_id          = '';
    public $currency_symbol     = '';
    public $dispute_data        = [];
    
    public $date_formate        = '';
    public $reply_message_id    = '';
    public $message_text        = '';
    public $proposal_id         = '';
    public $feedback            = '';
    public $favour_to           = '';
// for uload doc
    public $attachment_files    = [];
    public $existingFiles       = [];
    public $allowFileSize       = '';
    public $allowFileExt        = '';

    public $dispute_id          = '';

    public $listeners = array('updateDispute');

    public function render(){

        $chat = DisputeConversation::where('dispute_id', $this->dispute_id)
        ->whereNull('message_id')
        ->with([
            'userInfo:id,role_id,first_name,last_name,image',
            'replyMessages.userInfo:id,role_id,first_name,last_name,image'
        ])->orderBy('id','asc')->get();

        $chatId = 'tk_chat_'.time();

        $this->dispatchBrowserEvent('initializeScrollbar', array('chatId' => $chatId ) );

        return view('livewire.admin.disputes.dispute-detail',compact('chat', 'chatId'))->extends('layouts.admin.app');
    }

    

    public function mount( $dispute_id ){
        
        $date_format                = setting('_general.date_format');
        $currency                   = setting('_general.currency');
        $file_ext                   = setting('_general.file_ext');
        $file_size                  = setting('_general.file_size');
        $this->date_format          = !empty($date_format)  ? $date_format : 'm d, Y';
        $this->allowFileSize        = !empty( $file_size ) ? $file_size : '3';
        $this->allowFileExt         = !empty( $file_ext ) ?   $file_ext  : [];
        $currency_detail            = !empty( $currency)  ? currencyList($currency) : array();
        
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }

        $this->dispute_id       = $dispute_id;
        $user = getUserRole();
        $this->profile_id       = $user['profileId'];

        if($dispute_id){
            $this->getDisputeInfo();
        }
    }

    public function updateDispute($dispute_id){
        $this->dispute_id = $dispute_id;
        $this->getDisputeInfo();
    }

    public function updatedAttachmentFiles(){
        
        $this->validate(
            [
                'attachment_files.*' => 'mimes:'. $this->allowFileExt.'|max:'.$this->allowFileSize*1024,
            ],[
                'max'   => __('general.max_file_size_err',  ['file_size'    => $this->allowFileSize.'MB']),
                'mimes' => __('general.invalid_file_type',  ['file_types'   => $this->allowFileExt]),
            ]
        );
        
        foreach($this->attachment_files as $single){
            $filename = pathinfo($single->hashName(), PATHINFO_FILENAME);
            $this->existingFiles[$filename] = $single;
        }
    }
    public function removeFile( $key ){

        if(!empty($this->existingFiles[$key])){
            unset($this->existingFiles[$key]);
        }
    }


    public function getDisputeInfo(){
       
        $this->dispute_data = Dispute::select('id','created_by','created_to','proposal_id','gig_order_id', 'price','dispute_issue','dispute_detail','favour_to','status')->with([
            'disputeCreator:id,first_name,last_name,role_id,image,user_id',
            'disputeReceiver:id,first_name,last_name,role_id,image,user_id',
        ])->whereIn('status', ['disputed','refunded'])->find($this->dispute_id);
        if(empty($this->dispute_data)){
            abort('404');
        }

        if( !empty($this->dispute_data->proposal_id) ){
            
            $this->dispute_data->load([
                'proposal:id,author_id,project_id,proposal_amount,payout_type,status',
                'proposal.project:id,project_title,author_id,updated_at'
            ]);

            if( $this->dispute_data->proposal->payout_type == 'milestone' ){
            
                $this->dispute_data->load(['proposal.milestones'=> function ($query) {
                    $query->whereIn('status',['processed','cancelled','queued']);
                    $query->select('status','id','proposal_id','price','title');
                }]);
            }elseif( $this->dispute_data->proposal->payout_type == 'hourly' ){
    
                $this->dispute_data->load(['proposal.timecards' => function ($query) {
                    $query->whereIn('status',['processed','cancelled','queued']);
                    $query->select('status','id','proposal_id','price','title');
                }]);
            }

            $this->proposal_id  = $this->dispute_data->proposal->id;
            $this->payout_type  = $this->dispute_data->proposal->payout_type;
            $this->seller_id    = $this->dispute_data->proposal->author_id;
            $this->buyer_id     = $this->dispute_data->proposal->project->author_id;
        }else{

            $this->dispute_data->load([
                'gigOrder:id,gig_id,author_id,plan_amount,gig_addons,status',
                'gigOrder.gig:id,author_id,title,updated_at'
            ]);

            $this->proposal_id  = $this->dispute_data->gigOrder->id;
            $this->payout_type  = 'gig_order';
            $this->seller_id    = $this->dispute_data->gigorder->gig->author_id;
            $this->buyer_id     = $this->dispute_data->gigorder->author_id;
        }

    }

    public function removeImage(){
       $this->image = $this->old_image = null;
    }


    public function resolveDispute(){

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
            'feedback'      => 'required',
            'favour_to'      => 'required',
            'image'         => 'nullable|image|mimes:'.$this->allowFileExt.'|max:'.$this->allowFileSize*1024,
        ],[
            'max'           => __('general.max_file_size_err',  ['file_size'=> $this->allowFileSize.'MB']),
            'mimes'         => __('general.invalid_file_type',['file_types'=>  $this->allowFileExt]),
            'favour_to.required' => __('disputes.select_wining_party')

        ]);

        if( !in_array($this->favour_to, array('buyer', 'seller') ) ){

            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.error_title'),
                'message'   => __('general.not_allowed')
            ]);
            return;
        }

        $data = array();

        $attachments = array();
        if( !empty($this->existingFiles) ){
            foreach($this->existingFiles as $key => $single){

                $file = $single;
                $file_path      = $file->store('public/disputes/'.$this->dispute_id);
                $file_path      = str_replace('public/', '', $file_path);
                $file_name      = $file->getClientOriginalName();
                $mime_type      = $file->getMimeType();

                $attachments[]  = array(
                    'file_name'  => $file_name,
                    'file_path'  => $file_path,
                    'mime_type'  => $mime_type,
                );
                
            }
        }

        $data['attachments'] = !empty($attachments) ? serialize($attachments) : null;
        $data['sender_id']  = $this->profile_id;
        $data['dispute_id'] = $this->dispute_id; 
        $data['message']    = sanitizeTextField($this->feedback, true );
        $eventData          = array();
        $isNotifyUser       = false;
        DB::beginTransaction();
        try{

            $transaction = '';
            $disputeLog = Dispute::select('dispute_log')->find($this->dispute_id);
            $dispute_log = !empty( $disputeLog->dispute_log ) ? unserialize($disputeLog->dispute_log)  : array();
            
    
            $dispute_log['3'] = array(
                'action_by' => $this->profile_id,
                'action_date' => date('Y-m-d H:i:s')
            );

            $creator_role_id        = $this->dispute_data->disputeCreator->role_id;
            $disputeCreatorRole     = getRoleById($creator_role_id);
            $receiver_role_id       = $this->dispute_data->disputeReceiver->role_id;
            $disputeReceiverRole    = getRoleById($receiver_role_id);
            
            $seller = $buyer = '';
            if( $disputeCreatorRole == $this->favour_to ){
                $winner = $this->dispute_data->disputeCreator;
                $loser  = $this->dispute_data->disputeReceiver;
            } else {
                $winner = $this->dispute_data->disputeReceiver;
                $loser  = $this->dispute_data->disputeCreator;
            }

            $dispute_log['4'] = array(
                'action_by' => $winner->id,
                'action_date' => date('Y-m-d H:i:s')
            );

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
            }elseif( $this->payout_type == 'hourly' ){

                $proposal_timecard = ProposalTimecard::select('id')
                ->where('proposal_id' , $this->proposal_id)
                ->whereIn('status', array('queued', 'cancelled'))->get();
                
                if( !$proposal_timecard->isEmpty() ){
                    
                    foreach($proposal_timecard as $single){
                        ProposalTimecard::where('id' , $single->id)->update(['status' => 'refunded']);  
                    }
                } 

                $resolveDispute     = Dispute::where('id', $this->dispute_id)
                ->update([
                    'favour_to'     => $this->favour_to,
                    'status'        => 'refunded',
                    'dispute_log'   => serialize($dispute_log)
                ]);
                $isNotifyUser = true; 
                $this->dispute_data->status     = 'refunded';
                $this->dispute_data->favour_to  = $this->favour_to;
                
            }elseif( $this->payout_type == 'gig_order' ){

                $transaction = TransactionDetail::select('id', 'amount', 'used_wallet_amt', 'transaction_id', 'type_ref_id')->where([
                    'transaction_type'  => 4,
                    'type_ref_id'       => $this->proposal_id
                ]); 
            }

            if( !empty($transaction) ){

                $transaction_detail = $transaction->with('Transaction', function($query){
                    $query->select('id', 'trans_ref_no', 'creator_id', 'invoice_ref_no', 'payment_method', 'status');
                })->whereHas('Transaction', function($query){
                    $query->whereIn('status', array('processed', 'cancelled'));
                })->get();

                if( !$transaction_detail->isEmpty() ){
                    
                    if( $transaction_detail[0]->transaction->payment_method == 'escrow' ){

                        $seller_billing_info   =   UserBillingDetail::select('payout_settings')
                        ->where('profile_id', $this->seller_id)
                        ->first();
        
                        $buyer_billing_info   =   UserBillingDetail::select('payout_settings')
                        ->where('profile_id', $this->buyer_id)
                        ->first();
                    
                        if( (empty($seller_billing_info)    || empty($seller_billing_info->payout_settings )) 
                            || (empty($buyer_billing_info)  || empty($buyer_billing_info->payout_settings )) ){
        
                            $this->dispatchBrowserEvent('showAlertMessage', [
                                'title'     => __('general.error_title'),
                                'type'      => 'error',
                                'message'   => __('transaction.payout_setting_error')
                            ]);
                            return; 
                        }
        
                        $buyer_payouts_settings     = unserialize( $buyer_billing_info->payout_settings );
                        $seller_payouts_settings    = unserialize( $seller_billing_info->payout_settings );
                    }

                    foreach($transaction_detail as $single){

                        $payment_method = $single->transaction->payment_method;

                        switch( $payment_method ){
                            
                            case 'escrow':

                                if( $this->favour_to == 'buyer' ){

                                    $escrow   = new EscrowPayment();
                                    $params = array(
                                        "cancel_information" => array(
                                            "cancellation_reason" => $this->feedback
                                        )
                                    );
                                    $response = $escrow->updateTransaction( $single->transaction->trans_ref_no, 'cancel', $params);
                                    if( $response['type'] == 'error' ){
                                        $this->dispatchBrowserEvent('showAlertMessage', $response);
                                        return;
                                    }
                                }elseif( $this->favour_to == 'seller' ){

                                    if( empty($seller_payouts_settings['escrow']) || empty($buyer_payouts_settings['escrow']) ){

                                        $this->dispatchBrowserEvent('showAlertMessage', [
                                            'title'     => __('general.error_title'),
                                            'type'      => 'error',
                                            'message'   => __('transaction.payout_setting_error')
                                        ]);
                                        return; 
                                    }
        
                                    $seller_escrow_email       = $seller_payouts_settings['escrow']['escrow_email'];
                                    $seller_escrow_api         = $seller_payouts_settings['escrow']['escrow_api'];
                                    $seller_escrow             = new EscrowPayment( $seller_escrow_email, $seller_escrow_api );

                                    $buyer_escrow_email       = $buyer_payouts_settings['escrow']['escrow_email'];
                                    $buyer_escrow_api         = $buyer_payouts_settings['escrow']['escrow_api'];
                                    $buyer_escrow             = new EscrowPayment( $buyer_escrow_email, $buyer_escrow_api );

                                    $response   = $seller_escrow->getTransaction(['transaction_id' => $single->transaction->trans_ref_no]);
                                    if( $response['type'] == 'error' ){

                                        $this->dispatchBrowserEvent('showAlertMessage', $response);
                                        return;
                                    }elseif( !$response['status']['shipped'] ){

                                        $status   = $seller_escrow->updateTransaction( $single->transaction->trans_ref_no, 'ship' );
                                        if( $status['type'] == 'error' ){
                                            $this->dispatchBrowserEvent('showAlertMessage', $status);
                                            return;
                                        }
                                    }
                                    if( !$response['status']['received'] ){

                                        $status   = $buyer_escrow->updateTransaction( $single->transaction->trans_ref_no, 'receive' );
                                        if( $status['type'] == 'error' ){
                                            $this->dispatchBrowserEvent('showAlertMessage', $status);
                                            return;
                                        }
                                    }
                                    if( !$response['status']['accepted'] ){

                                        $status   = $buyer_escrow->updateTransaction( $single->transaction->trans_ref_no, 'accept' );
                                        if( $status['type'] == 'error' ){
                                            $this->dispatchBrowserEvent('showAlertMessage', $status);
                                            return;
                                        }

                                        $seller_payout = SellerPayout::where('transaction_id', $single->transaction->id)->first();
                                       
                                        if( !empty($seller_payout) && $seller_payout->admin_commission > 0 ){

                                            AdminPayout::updateOrCreate(['transaction_id' => $single->transaction->id], [
                                                'transaction_id'    => $single->transaction->id,
                                                'amount'            => $seller_payout->admin_commission,
                                            ]);
                                        }
                                    }
                                }
                            break;
                            
                            case 'stripe':

                                

                                if( $this->favour_to == 'buyer' ){
                                    $profile_id = $this->buyer_id;
                                    $refundable_amount = $single->amount + $single->used_wallet_amt;
                                }else{

                                    $profile_id = $this->seller_id;
                                    $seller_payout = SellerPayout::where('transaction_id', $single->transaction->id)->first();
                                    $refundable_amount = $seller_payout->seller_amount;  
                                    if( $seller_payout->admin_commission > 0 ){

                                        AdminPayout::updateOrCreate(['transaction_id' => $single->transaction->id], [
                                            'transaction_id'    => $single->transaction->id,
                                            'amount'            => $seller_payout->admin_commission,
                                        ]);
                                    }
                                }
                                $user_wallet        = UserWallet::where('profile_id' , $profile_id)->first();
                                $wallet_profile_id  = !empty($user_wallet) ? $user_wallet->profile_id : 0;
                                $wallet_amount      = !empty($user_wallet) ? $user_wallet->amount : 0;
                                $wallet_amount      += $refundable_amount;

                                $wallet = UserWallet::updateOrCreate(['profile_id' => $wallet_profile_id], [
                                    'profile_id'  => $profile_id, 
                                    'amount'      => $wallet_amount, 
                                ]);
                                UserWalletDetail::create([
                                    'transaction_id'    => $single->transaction->id, 
                                    'wallet_id'         => $wallet->id, 
                                    'amount'            => $refundable_amount, 
                                ]);

                            break;    
                        }

                        if( $this->payout_type == 'milestone' ){
                            ProposalMilestone::where('id', $single->type_ref_id)->update(['status' => 'refunded']);
                        }
                        Transaction::where('id', $single->transaction_id)->update(['status' => 'refunded']);
                    }

                    $resolveDispute     = Dispute::where('id', $this->dispute_id)
                    ->update([
                        'favour_to'     => $this->favour_to,
                        'status'        => 'refunded',
                        'dispute_log'   => serialize($dispute_log)
                    ]);
                    $this->dispute_data->status     = 'refunded';
                    $this->dispute_data->favour_to  = $this->favour_to;
                    $isNotifyUser = true;
                }         
            }

            if( $this->payout_type == 'gig_order' ){
                GigOrder::where('id', $this->proposal_id)->update(['status' => 'refunded']);
            }else{
                
                Proposal::where('id', $this->proposal_id)->update(['status' => 'refunded']); 
                $proposal = Proposal::select('project_id')->find($this->proposal_id);
                $refunded_proposals   = Proposal::where('project_id', $proposal->project_id)->where('status', 'refunded')->count('id');
                $project = Project::select('id', 'project_hiring_seller', 'status')->find($proposal->project_id);
                if($project->status == 'hired' && $project->project_hiring_seller == $refunded_proposals ){
                    $project->update(['status' => 'cancelled']);
                } 
            }

            $insertMessage  = DisputeConversation::create($data);

            // send email to admin
            if( !empty($isNotifyUser) ){

                $favoutTo = $this->favour_to;
                $email_templates = EmailTemplate::select('content', 'role', 'type')
                ->where(function($query) use ($favoutTo){
                    $temp_type = '';
                    if( $this->payout_type == 'gig_order' ){
                        $temp_type = 'admin_refund_order_dispute_to_winner';
                    } else {
                        $temp_type = $this->payout_type == 'hourly' ? 'admin_refund_hourly_dispute_to_winner' : 'admin_refund_dispute_to_winner';
                    }
                    
                    $query->where([ 'role' => $favoutTo, 'type' => $temp_type]);
                })->orWhere(function($query) use ($favoutTo){
                    $roleType = $favoutTo == 'seller' ? 'buyer':'seller';
                    $temp_type = $this->payout_type == 'gig_order' ? 'admin_order_dispute_not_in_favour' : 'admin_dispute_not_in_favour';
                    $query->where([ 'role' => $roleType, 'type' => $temp_type ]);
                })->where('status','active')->get();


                if( !$email_templates->isEmpty() ) {
                    $template_content = array();

                    foreach($email_templates as $template){
                        $template_content[$template->type] = $template->content; 
                    }

                    $creator_role_id        = $this->dispute_data->disputeCreator->role_id;
                    $disputeCreatorRole     = getRoleById($creator_role_id);
                    $receiver_role_id       = $this->dispute_data->disputeReceiver->role_id;
                    $disputeReceiverRole    = getRoleById($receiver_role_id);
                    
                    $seller = $buyer = '';
                    if( $disputeCreatorRole == $favoutTo ){
                        $winner = $this->dispute_data->disputeCreator;
                        $loser  = $this->dispute_data->disputeReceiver;
                    } else {
                        $winner = $this->dispute_data->disputeReceiver;
                        $loser  = $this->dispute_data->disputeCreator;
                    }

                    //users info
                    $notifyUsers = User::whereIn('id', [$winner->user_id, $loser->user_id])->get();

                    if( !$notifyUsers->isEmpty() ) {
                        foreach($notifyUsers as $user){
                            $params         = array();
                            $template_data  = '';
                            $user_name      = '';
                            $temp_type      = '';
                            if( $user->id == $winner->user_id ) {
                                
                                if( $this->payout_type == 'gig_order' ){
                                    $temp_type = 'admin_refund_order_dispute_to_winner';
                                }else {
                                    $temp_type = $this->payout_type == 'hourly' ? 'admin_refund_hourly_dispute_to_winner' : 'admin_refund_dispute_to_winner';
                                }

                                $user_name                  = $winner->full_name;
                                $params['template_type']    = $temp_type;
                                $template_data              = !empty($template_content[$temp_type]) ? $template_content[$temp_type] : '';
                            } else {
                                $temp_type = $this->payout_type == 'gig_order' ? 'admin_order_dispute_not_in_favour' : 'admin_dispute_not_in_favour';
                                $user_name                  = $loser->full_name;
                                $params['template_type']    = $temp_type;
                                $template_data              = !empty($template_content[$temp_type]) ? $template_content[$temp_type] : '';
                            }
                            
                            $content = !empty($template_data) ? unserialize($template_data) : array();
                            if(!empty($content)){
                                $params['email_params']     = array(
                                    'user_name'             => $user_name,
                                    'dispute_link'          => route('dispute-detail',['id' => $this->dispute_id]),
                                    'email_subject'         => !empty($content['subject']) ?   $content['subject'] : '',
                                    'email_greeting'        => !empty($content['greeting']) ?  $content['greeting'] : '',
                                    'email_content'         => !empty($content['content']) ?   $content['content'] : '',
                                );
                                
                                try {
                                    Notification::send($user, new EmailNotification($params));
                                } catch (\Exception $e) {
                                    $this->dispatchBrowserEvent('showAlertMessage', [
                                        'title'     => __('general.error_title'),
                                        'type'      => 'error',
                                        'message'   => $e->getMessage(),
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            
            DB::commit();
            $eventData['type']      = 'success';
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('disputes.refunded_dispute_alert');
            $this->existingFiles    = [];
        } catch (\Exception $e) {
            DB::rollback();
            $eventData['type']      = 'error';
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = $e->getMessage();
        }

        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
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

    public function sendMessage(){
        
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
            'message_text' => 'required'
        ]);

        $data               = array();
        $data['sender_id']  = $this->profile_id;
        $data['dispute_id'] = $this->dispute_id; 
        $data['message']    = sanitizeTextField($this->message_text, true );
        
        if( !empty($this->reply_message_id) ){
            $data['message_id'] = $this->reply_message_id;
        }

        $insert = DisputeConversation::create($data);

        if( !empty($insert) ){

            $this->reply_message_id = '';
            $this->message_text     = '';
        }else{

            $eventData              = array();
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }
    }
}
