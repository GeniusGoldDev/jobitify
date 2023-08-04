<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Dispute;
use App\Models\Project;
use Livewire\Component;
use App\Models\UserWallet;
use App\Models\AdminPayout;
use App\Models\Transaction;
use App\Models\EmailTemplate;
use App\Models\ProjectActivity;
use App\Services\EscrowPayment;
use App\Models\UserWalletDetail;
use App\Models\Proposal\Proposal;
use App\Models\TransactionDetail;
use App\Models\UserBillingDetail;
use Illuminate\Support\Facades\DB;
use App\Models\Seller\SellerPayout;
use App\Models\Seller\SellerRating;
use App\Models\EscrowDisburseMethod;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EmailNotification;
use App\Models\Proposal\ProposalTimecard;
use App\Models\Proposal\ProposalMilestone;
use Illuminate\Support\Facades\Notification;
use App\Models\Proposal\ProposalTimecardDetail;

class ProposalActivityDetail extends Component
{
    public $userRole;
    public $proposal_payout;
    public $hourly_working_time_format;
    public $hourly_working_time;
    public $hourly_working_desc;
    public $profile_id;
    public $project_id;
    public $proposal_id;
    public $date_format;
    public $currency_symbol;
    public $contractRating = '';
    public $escrow_disburse_id = '';
    public $contractRatingTitle = '';
    public $contractRatingDesc = '';
    public $decline_timecard_id = '';
    public $decline_milestone_id = 0;
    public $date_intervals = [];
    public $hourly_time_slots = [];
    public $hourly_selected_time = '';
    public $hourly_proposed_hours = '';
    public $decline_reason = '';
    public $disputeIssues           = array();
    public $dispute_issue           = null;
    public $dispute_detail          = null;
    public $agree_term_condtion     = false;
    public $payout_type             = false;

    // variables for dispute status
    public $proposal_disputed   = false;
    public $dispute_status_txt  = '';
    public $dispute_desc_txt    = '';
    public $disputeAfterDays    = 3;
    public $status_icon         = '';
    public $dispute_class       = '';
    public $dispute_status      = '';


    public $listeners = [ 
        'updateSellerProposal'          => 'updateSellerProposal',
        'updateEscrowDisburseMethod'    => 'updateEscrowDisburseMethod',
        'timeCardConfirm'               =>  'submitHourlyTimecard'
    ];

    public function mount($project_id, $proposal_id, $currency_symbol, $profile_id, $userRole, $date_format, $project_max_hours){
        
        $this->project_id               = $project_id;
        $this->proposal_id              = $proposal_id;
        $this->profile_id               = $profile_id;
        $this->userRole                 = $userRole;
        $this->currency_symbol          = $currency_symbol;
        $this->date_format              = $date_format;
        $this->hourly_proposed_hours    = $project_max_hours;
        $buyer_dispute_after_days       = setting('_dispute.buyer_dispute_after_days');
        $this->disputeAfterDays         = !empty($buyer_dispute_after_days) && is_numeric($buyer_dispute_after_days) ? $buyer_dispute_after_days : 3;
    }

    public function render(){

        $proposal_detail = Proposal::select(
            'id',
            'project_id',
            'payout_type',
            'proposal_amount',
            'payment_mode',
            'decline_reason',
            'author_id',
            'status',
            'updated_at',
        )->with([
            'proposalAuthor' => function($query){
                $query->select('id','image','first_name','last_name');
            } 
        ]);

        $proposal_detail = $proposal_detail->where('project_id', $this->project_id);
        $proposal_detail = $proposal_detail->find($this->proposal_id);

        if(empty($proposal_detail)){
            abort('404');
        }
        $view = 'fixed-proposal-activity';

        $this->checkDisputeStatus($proposal_detail->status);
        $this->payout_type = $proposal_detail->payout_type;

        if ( $proposal_detail->payout_type == 'milestone' ) {

            $proposal_detail->load(['milestones' => function ( $query ) {
                $query->select('id', 'proposal_id', 'title', 'price', 'description', 'decline_reason', 'status');
            }]);
            
        }elseif( $proposal_detail->payout_type == 'hourly' ){

            $view = 'hourly-proposal-activity';
            if( $this->userRole == 'seller' ){

                $this->date_intervals = getHourlyTimeInterval($proposal_detail->updated_at,  $proposal_detail->payment_mode );
                
                if( empty($this->hourly_selected_time) ){

                    $selected_time = array_filter($this->date_intervals, function($single){
                        return $single['selected'];
                    });

                    if(!empty($selected_time)){
                        $this->hourly_selected_time = key($selected_time);
                    }
                }

                $selected_time  = $this->hourly_selected_time;
                $payment_mode   = $proposal_detail->payment_mode;  

                $proposal_detail->load(['filteredTimecard' => function ( $query ) use( $selected_time, $payment_mode ) {
                                
                    $selected_time  = explode('_', $selected_time);

                    if( $payment_mode == 'daily' ){ 
                        $query->whereDate('start_date', '=', $selected_time[0]);
                    }else{
                        $query->whereDate('start_date', '>=', $selected_time[0]);
                        $query->whereDate('end_date',   '<=', $selected_time[1]);
                    }
                    
                    $query->select('id', 'proposal_id', 'total_time', 'status');
                    $query->with('timecardDetail:id,timecard_id,working_date,working_time');
                }]);
                
                $this->hourly_time_slots =  getHourlyTimeSlots(
                    $proposal_detail->status,
                    $proposal_detail->updated_at,
                    $proposal_detail->filteredTimecard,
                    $this->hourly_selected_time,
                    $proposal_detail->payment_mode
                );
            }

            $proposal_detail->load(['timecards' => function ( $query ) {
                
                $query->select('id', 'title', 'proposal_id', 'price', 'total_time', 'decline_reason', 'status');
                $query->orderBy('id', 'desc');
                $query->with('timecardDetail:id,timecard_id,description,working_date,working_time');
            }]);
        }
        
        $listId = 'activity-'.time();
        $this->dispatchBrowserEvent('initializeScrollbar', $listId);
        $this->dispatchBrowserEvent('apply-loader', 'hide');

        return view('livewire.components.'.$view, compact('proposal_detail','listId'));
    }

    public function updateSellerProposal( $id ){

        $this->dispatchBrowserEvent('apply-loader', 'show');
        $this->proposal_id              = $id;
        $this->hourly_selected_time     = '';
        $this->decline_milestone_id     = '';
        $this->escrow_disburse_id       = '';
    }

    public function updateEscrowDisburseMethod($milestone_id, $escrow_disburse_id, $use_same_method){

        $this->completeMilestone($milestone_id, [
            'escrow_disburse_id'    => $escrow_disburse_id,
            'use_same_method'       => $use_same_method,
        ]);
    }
    
    public function escrowMilestone( $id ){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $proposal_milestone = ProposalMilestone::select('title', 'price', 'proposal_id')->with(
            'proposal', function($query){
                $query->select('id', 'project_id', 'payout_type');
                $query->where('status', 'hired');
                $query->with('project:id,author_id,project_title,slug')->whereHas('project', function($query){
                    $query->where('author_id', $this->profile_id);
                    $query->where('id', $this->project_id);
                });
            }
        )->where(['status' => 'pending', 'proposal_id' => $this->proposal_id])->find( $id );
       
        if( !empty($proposal_milestone) ){

            $project_data = [
                'project_title'         => $proposal_milestone->proposal->project->project_title,
                'project_slug'          => $proposal_milestone->proposal->project->slug,
                'project_id'            => $this->project_id,
                'proposal_id'           => $this->proposal_id,
                'payout_type'           => $proposal_milestone->proposal->payout_type,
                'milestone_id'          => $id,
                'milestone_title'       => $proposal_milestone->title,
                'milestone_price'       => $proposal_milestone->price,
            ];
            session()->forget('package_data');
            session()->forget('gig_data');
            session()->put(['project_data' => $project_data ]);
            return redirect()->route('checkout'); 
        }
    }
    
    public function updateTimecard(){
        
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
            'hourly_working_time' => 'required',
            'hourly_working_desc' => 'required',
        ]);

        $proposal = Proposal::select('author_id','proposal_amount', 'updated_at', 'payment_mode')->where('status', 'hired')->find($this->proposal_id);
        if( !empty($proposal) &&  $this->profile_id == $proposal->author_id ){
            
            $working_date   = date('Y-m-d', strtotime($this->hourly_working_time_format));
            $hiring_date    = date('Y-m-d', strtotime($proposal->updated_at));
            
            if( $working_date != '1970-01-01' 
                && strtotime($working_date) <= strtotime(date('Y-m-d'))
                && strtotime($working_date) >=  strtotime($hiring_date)){

                $hourly_selected_time = explode('_', $this->hourly_selected_time);  
                $proposal_timecard = ProposalTimecard::select('id', 'total_time');
                $proposal_timecard = $proposal_timecard->where('proposal_id', $this->proposal_id);
                $timecard_title = date('M d, Y', strtotime($hourly_selected_time[0]));
                if( $proposal->payment_mode == 'daily' ){
                    $proposal_timecard->whereDate('start_date', '=', $hourly_selected_time[0]);
                }else{
                    $proposal_timecard->whereDate('start_date', '>=', $hourly_selected_time[0]);
                    $proposal_timecard->whereDate('end_date',   '<=', $hourly_selected_time[1]);
                    $timecard_title = $timecard_title .' - '.date('M d, Y', strtotime($hourly_selected_time[1]));
                }

                $proposal_timecard = $proposal_timecard->latest()->first();

                $working_time = str_replace(' ', '', sanitizeTextField( $this->hourly_working_time ) );
                

                $project                = Project::select('project_max_hours')->find($this->project_id);
                $allow_project_minutes  = $project->project_max_hours*60;
                $pre_time_minutes = 0;
                
                if(!empty($proposal_timecard)){
                    
                    $timecard_id     = $proposal_timecard->id;
                    $timecard_time   = explode( ':', $proposal_timecard->total_time);
                    $pre_timecard    = ($timecard_time[0]*60) + $timecard_time[1];
                    $rem_time_minutes = $allow_project_minutes - $pre_timecard;

                    $timecard_detail        = ProposalTimecardDetail::select('working_time')
                    ->whereDate('working_date', $working_date)->where('timecard_id', $timecard_id)
                    ->latest()->first();

                    if( !empty($timecard_detail) ){

                        $detail             = explode(':', $timecard_detail->working_time);
                        $pre_time_minutes   = ($detail[0]*60) + (!empty($detail[1]) ? $detail[1] : 0);
                    }

                    $submitted_time         = explode(':', $working_time); 
                    $submitted_time_minutes = ($submitted_time[0]*60) + (!empty($submitted_time[1]) ? $submitted_time[1] : 0);
                    $time_minutes_diff      = $submitted_time_minutes - $pre_time_minutes;
                   
                    if( $time_minutes_diff > $rem_time_minutes ){

                        $this->dispatchBrowserEvent('showAlertMessage', [
                            'title'     => __('general.error_title'),
                            'type'      => 'error',
                            'message'   => __('proposal.hourly_timecard_exceeded')
                        ]);
                        
                        return;
                    }
                    
                }else{

                    $submitted_time         = explode(':', $working_time); 
                    $submitted_time_minutes = ($submitted_time[0]*60) + (!empty($submitted_time[1]) ? $submitted_time[1] : 0);

                    if( $submitted_time_minutes > $allow_project_minutes ){

                        $this->dispatchBrowserEvent('showAlertMessage', [
                            'title'     => __('general.error_title'),
                            'type'      => 'error',
                            'message'   => __('proposal.hourly_timecard_exceeded')
                        ]);
                        
                        return;
                    }

                    $timecard = ProposalTimecard::create([
                        'proposal_id'   => $this->proposal_id,
                        'title'         => $timecard_title,
                        'start_date'    => $hourly_selected_time[0],
                        'end_date'      => !empty($hourly_selected_time[1]) ? $hourly_selected_time[1] : $hourly_selected_time[0],
                        'total_time'    => '',
                    ]);

                    $timecard_id = $timecard->id;
                }

                $timecard_detail = ProposalTimecardDetail::select('id')
                ->whereDate('working_date', $working_date)->where('timecard_id', $timecard_id)
                ->latest()->first();

                if(!empty($timecard_detail)){
                    $timecard_detail->update(['working_time' => $working_time, 'description' => sanitizeTextField($this->hourly_working_desc, true) ]);
                }else{
                    $timecard_detail = ProposalTimecardDetail::create([
                        'timecard_id'   => $timecard_id,
                        'working_date'  => $working_date,
                        'working_time'  => $working_time,
                        'description'   => sanitizeTextField($this->hourly_working_desc, true),
                    ]);
                }

                $timecard_details = ProposalTimecardDetail::select('working_time')->where('timecard_id', $timecard_id)->get()->toArray();
                if( !empty($timecard_details) ){
                    $hours = $minutes = 0;
                    foreach($timecard_details as $single){
                        $time = explode(':', $single['working_time']);
                        $hours      += $time[0];
                        $minutes    += !empty($time[1]) ? $time[1]: 0;
                    }

                    $hours      += intdiv($minutes, 60);
                    $minutes    = ($minutes % 60);
                    $hours      = $hours < 10 ? '0'.$hours : $hours;
                    $minutes    = $minutes < 10 ? '0'.$minutes : $minutes;
                    $total_time = $hours.':'.$minutes;
                    $total_price = $hours * $proposal->proposal_amount;
                    if($minutes > 0){
                        $total_price =  round($total_price + ($proposal->proposal_amount/60 * $minutes), 2); 
                    }
                    ProposalTimecard::where('id', $timecard_id)->update(['price' => $total_price, 'total_time' => $total_time]);
                }
                $this->hourly_working_time = '';
                $this->hourly_working_desc = '';
                $this->dispatchBrowserEvent('hide-timecardpopup');
            }
        }
    }

    public function submitHourlyTimecard( $params){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $proposal = Proposal::select('author_id','project_id')->with([
            'proposalAuthor:id,first_name,last_name',
            'project:id,author_id,project_title,slug',
            'project.projectAuthor:id,user_id,first_name,last_name',
            'project.projectAuthor.user',
            ])->where('status', 'hired')->find($this->proposal_id);

        if( $this->userRole == 'seller' 
            && !empty($proposal) 
            &&  $this->profile_id == $proposal->author_id ){

            $timecard = ProposalTimecard::find($params['id']);
            $timeCardTitle = $timecard->title;
            $updateCard = $timecard->update(['status' => 'queued']);

            if( $updateCard ){

                // NOTIFY EMPLOYER THROUGH SEND EMAIL
                $email_template = EmailTemplate::select('content')
                ->where(['type' => 'timecard_approval_request' , 'status' => 'active', 'role' => 'buyer'])
                ->latest()->first();

                $userName       = $proposal->project->projectAuthor->full_name;
                $projectTitle   = $proposal->project->project_title;
                $projectSlug    = $proposal->project->slug;
                $sellerName     = $proposal->proposalAuthor->full_name;
                $activitLink    = route('project-activity',['slug' => $projectSlug, 'id' => $this->proposal_id]);

                if( !empty($email_template) ){

                    $template_data              =  unserialize($email_template->content);
                    $params                     = array();
                    $params['template_type']    = 'timecard_approval_request';
                    $params['email_params']     = array(
                        'user_name'             => $userName,
                        'timecard_title'        => $timeCardTitle,
                        'project_title'         => $projectTitle,
                        'seller_name'           => $sellerName,
                        'project_activity_link' => $activitLink,
                        'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                        'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                        'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
                    );
                    try {
                        $proposal->project->projectAuthor->user->notify(new EmailNotification($params));
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
        }
    }

    public function approveHourlyTimecard( $id ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $project = Project::select('author_id')->find($this->project_id);
        if( $this->userRole == 'buyer' 
            && !empty($project) 
            &&  $this->profile_id == $project->author_id ){

            $proposal_timecard = ProposalTimecard::select('title', 'price', 'proposal_id')->with(
                'proposal', function($query){
                    $query->select('id', 'project_id', 'payout_type');
                    $query->where('status', 'hired');
                    $query->with('project:id,author_id,project_title,slug')->whereHas('project', function($query){
                        $query->where('author_id', $this->profile_id);
                        $query->where('id', $this->project_id);
                    });
                }
            )->where(['status' => 'queued', 'proposal_id' => $this->proposal_id])->find( $id );

            if( !empty($proposal_timecard) ){

                $project_data = [
                    'project_title'         => $proposal_timecard->proposal->project->project_title,
                    'project_slug'          => $proposal_timecard->proposal->project->slug,
                    'project_id'            => $this->project_id,
                    'proposal_id'           => $this->proposal_id,
                    'payout_type'           => $proposal_timecard->proposal->payout_type,
                    'timecard_id'           => $id,
                    'timecard_title'       => $proposal_timecard->title,
                    'timecard_price'       => $proposal_timecard->price,
                ];
                session()->forget('package_data');
                session()->forget('gig_data');
                session()->put(['project_data' => $project_data ]);
                return redirect()->route('checkout'); 
            }
        }    
    }

    public function declineTimecard(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( $this->userRole == 'buyer' ){

            $proposal = Proposal::select('project_id', 'author_id')
            ->with([
                'project:id,author_id,project_title,slug',
                'proposalAuthor:id,user_id,first_name,last_name',
                'proposalAuthor.user',
            ])->where('id', $this->proposal_id)->first();

            if( !empty($proposal) && $proposal->project->author_id == $this->profile_id ){

                $this->validate([
                    'decline_reason' => 'required',
                ]);
            
                $updateTimecard = ProposalTimecard::where(
                    [  'id'            => $this->decline_timecard_id],
                    [  'proposal_id'   => $this->proposal_id],
                    [  'status'        => 'queued' ])->first();
                $timeCardTitle = $updateTimecard->title;
                $isUpdateTimeCard = $updateTimecard->update(
                        [
                            'decline_reason'    => sanitizeTextField($this->decline_reason, true),
                            'status'            => 'cancelled'
                        ]
                    );

                if( !empty( $isUpdateTimeCard ) ){

                    ProjectActivity::create([
                        'sender_id'         =>  $proposal->project->author_id,
                        'receiver_id'       =>  $proposal->author_id,
                        'project_id'        =>  $this->project_id,
                        'attachments'       =>  null,
                        'description'       => sanitizeTextField($this->decline_reason, true)
                    ]);

                    $eventData['type']      = 'success';
                    $eventData['title']     = __('proposal.timecard_decline_title');
                    $eventData['message']   = __('proposal.timecard_cancelled');


                    //notify seller to declined time card from employer
                    $email_template = EmailTemplate::select('content')
                    ->where(['type' => 'timecard_declined' , 'status' => 'active', 'role' => 'seller'])
                    ->latest()->first();

                    $userName       = $proposal->proposalAuthor->full_name;
                    $projectTitle   = $proposal->project->project_title;
                    $projectSlug    = $proposal->project->slug;
                    $activitLink    = route('project-activity',['slug' => $projectSlug, 'id' => $this->proposal_id]);
    
                    if(!empty($email_template)){
                        $template_data              = unserialize($email_template->content);
                        $params                     = array();
                        $params['template_type']    = 'timecard_declined';
                        $params['email_params']     = array(
                            'user_name'             => $userName,
                            'timecard_title'        => $timeCardTitle,
                            'project_title'         => $projectTitle,
                            'project_activity_link' => $activitLink,
                            'decline_reason'        => $this->decline_reason,
                            'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                            'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                            'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
                        );
                        try {
                            $proposal->proposalAuthor->user->notify(new EmailNotification($params));
                        } catch (\Exception $e) {
                            $this->dispatchBrowserEvent('showAlertMessage', [
                                'type'      => 'error',
                                'title'     => __('general.error_title'),
                                'message'   => $e->getMessage(),
                                'autoClose' => 10000,
                            ]);
                        }
                    }

                    $this->decline_reason          = '';
                    $this->decline_timecard_id     = '';
                    $this->dispatchBrowserEvent('show-decline-reason-modal', array('modal' => 'hide'));
                }else{

                    $eventData['type']      = 'error';           
                    $eventData['title']     = __('general.error_title');
                    $eventData['message']   = __('settings.wrong_msg');
                }

                $this->dispatchBrowserEvent('showAlertMessage', $eventData);
            } 
        } 
    }
    
    public function completeMilestone( $milestone_id = false,  $params = false ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( $this->userRole == 'seller' ){
                
            $proposal_milestone = ProposalMilestone::select('id','title', 'proposal_id', 'status')->with( 
                'proposal', function($query){
                    $query->select('id','author_id','project_id');
                    $query->where('author_id', $this->profile_id);
                    $query->where('status', 'hired');
                    $query->with([
                        'proposalAuthor:id,user_id,first_name,last_name',
                        'project:id,project_title,slug,author_id',
                        'project.projectAuthor:id,user_id,first_name,last_name'
                    ]);
                }
            )->where(['proposal_id' => $this->proposal_id])->find( $milestone_id );

            if( !empty($proposal_milestone) 
                && ( $proposal_milestone->status == 'processed' || $proposal_milestone->status == 'cancelled' ) ){
                
                $transaction_detail = TransactionDetail::select('id', 'transaction_id')->where([
                    'transaction_type'  => 1,
                    'type_ref_id'       => $milestone_id
                ])
                ->with('Transaction', function($query){
                    $query->select('id', 'trans_ref_no', 'creator_id', 'invoice_ref_no', 'payment_method', 'status');
                })->whereHas('Transaction', function($query){
                    $query->where('status', 'processed');
                    $query->orWhere('status', 'cancelled');
                })->latest()->first();

                if( !empty($transaction_detail) ){

                    $payment_method = $transaction_detail->transaction->payment_method;
                   
                    switch( $payment_method ){

                        case 'escrow':

                            $billing_info   =   UserBillingDetail::select('payout_settings')
                            ->where('profile_id', $this->profile_id)
                            ->first();
        
                            if( empty($billing_info) || empty($billing_info->payout_settings ) ){
        
                                $this->dispatchBrowserEvent('showAlertMessage', [
                                    'title'     => __('general.error_title'),
                                    'type'      => 'error',
                                    'message'   => __('transaction.payout_setting_error')
                                ]);
                                return; 
                            }
        
                            $payouts_settings = unserialize( $billing_info->payout_settings );

                            if( empty($payouts_settings['escrow']) ){

                                $this->dispatchBrowserEvent('showAlertMessage', [
                                    'title'     => __('general.error_title'),
                                    'type'      => 'error',
                                    'message'   => __('transaction.payout_setting_error')
                                ]);
                                return; 
                            }

                            $escrow_email       = $payouts_settings['escrow']['escrow_email'];
                            $escrow_api         = $payouts_settings['escrow']['escrow_api'];
                            $escrow             =   new EscrowPayment( $escrow_email, $escrow_api );

                            if( !empty($params['escrow_disburse_id']) ){
                                
                                $response = $escrow->setSellerTransactionDisburseMethod([
                                    'seller_id'             => $this->profile_id,
                                    'project_id'            => $this->project_id,
                                    'transaction_ref'       => $transaction_detail->transaction->trans_ref_no,
                                    'escrow_disburse_id'    => $params['escrow_disburse_id'],
                                    'use_same_method'       => $params['use_same_method'],
                                ]); 

                                if( $response['type'] == 'error' ){
                                    $this->dispatchBrowserEvent('showAlertMessage', $response);
                                    return;   
                                }
                            }

                            if( $transaction_detail->transaction->status == 'processed' ){

                                $response = $escrow->getSellerDisburseMethod( $transaction_detail->transaction->trans_ref_no );
                                if( $response['type'] == 'error' ){
                                    $this->dispatchBrowserEvent('showAlertMessage', $response);
                                    return;   
                                }elseif( !$response['selected_disbursement_method'] ){
                                    
                                    $seller_disburse_method = EscrowDisburseMethod::select('disburse_methods_id')
                                    ->where(['seller_id' => $this->profile_id, 'project_id'=> $this->project_id])->first();

                                    if( empty($seller_disburse_method) ){

                                        if( !empty($response['saved_disbursement_methods']) ){
        
                                            $this->dispatchBrowserEvent('escrowDisburseMethods', [
                                                'disburse_methods'  => $response['saved_disbursement_methods'],
                                                'milestone_id'      => $milestone_id,
                                            ]);
                                            return;
                                        }else{
        
                                            $this->dispatchBrowserEvent('showAlertMessage', [
                                                'title'     => __('general.error_title'),
                                                'type'      => 'error',
                                                'message'   => __('transaction.escrow_disburse_methods')
                                            ]);
                                            return;
                                        }
                                    }else{

                                        $response = $escrow->setSellerTransactionDisburseMethod([
                                            'transaction_ref'       => $transaction_detail->transaction->trans_ref_no,
                                            'escrow_disburse_id'    => $seller_disburse_method->disburse_methods_id,
                                            'use_same_method'       => false,
                                        ]);

                                        if( $response['type'] == 'error' ){
                                            $this->dispatchBrowserEvent('showAlertMessage', $response);
                                            return;   
                                        } 
                                    }
                                }
                                $response = $escrow->updateTransaction( $transaction_detail->transaction->trans_ref_no, 'ship' );
                                if( $response['type'] == 'error' ){
                                    $this->dispatchBrowserEvent('showAlertMessage', $response);
                                    return;
                                }
                            }
                        break;    
                    }

                    $this->sendCompleteMilestoneNotifyMail($proposal_milestone);
                    $proposal_milestone->update( ['status'=> 'queued'] );  
                }
            } 
        }
    }

    public function sendCompleteMilestoneNotifyMail( $milestoneInfo ){

        $email_template = EmailTemplate::select('content')
        ->where(['type' => 'milestone_approve_request' , 'status' => 'active', 'role' => 'buyer'])
        ->latest()->first();
        $milestone_title    = $milestoneInfo->title; 
        $project_title      = $milestoneInfo->proposal->project->project_title;
        $project_slug       = $milestoneInfo->proposal->project->slug;
        $user_name          = $milestoneInfo->proposal->project->projectAuthor->full_name;
        $seller_name        = $milestoneInfo->proposal->proposalAuthor->full_name;
        $activity_link      = route('project-activity', ['slug' => $project_slug, 'id'=> $milestoneInfo->proposal->id]);

        if(!empty($email_template)){
            $template_data              =  unserialize($email_template->content);
            $params                     = array();
            $params['template_type']    = 'milestone_approve_request';

            $params['email_params']     = array(
                'user_name'             => $user_name,
                'project_title'         => $project_title,
                'milestone_title'       => $milestone_title,
                'seller_name'           => $seller_name,
                'project_activity_link' => $activity_link,
                'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
            );
            $userId = $milestoneInfo->proposal->project->projectAuthor->user_id;
            try{
                User::find($userId)->notify(new EmailNotification($params));
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

    public function approveMilestone( $id ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( $this->userRole == 'buyer' ){

            $proposal_milestone = ProposalMilestone::select('id')
            ->where(['status' => 'queued', 'proposal_id' => $this->proposal_id])
            ->find( $id );
           
            if( !empty($proposal_milestone) ){

                $transaction_detail = TransactionDetail::select('id', 'transaction_id')
                ->where(['transaction_type' => 1, 'type_ref_id' => $id])
                ->with('Transaction', function($query){
                    $query->select('id', 'trans_ref_no', 'creator_id' , 'invoice_ref_no', 'payment_method', 'status');
                })->whereHas('Transaction', function($query){
                    $query->where('status', 'processed');
                    $query->orWhere('status', 'cancelled');
                })->latest()->first();
                
                if( !empty($transaction_detail) && $this->profile_id == $transaction_detail->transaction->creator_id ){

                    $payment_method = $transaction_detail->transaction->payment_method;
                   
                    switch( $payment_method ){

                        case 'escrow':

                            $billing_info   =   UserBillingDetail::select('payout_settings')
                            ->where('profile_id', $this->profile_id)->first();
                            if( empty($billing_info) || empty($billing_info->payout_settings ) ){
                                
                                $this->dispatchBrowserEvent('showAlertMessage', [
                                    'title'     => __('general.error_title'),
                                    'type'      => 'error',
                                    'message'   => __('transaction.payout_setting_error')
                                ]);
                                return; 
                            }
                            $payouts_settings = unserialize( $billing_info->payout_settings );

                            if( empty($payouts_settings['escrow']) ){

                                $this->dispatchBrowserEvent('showAlertMessage', [
                                    'title'     => __('general.error_title'),
                                    'type'      => 'error',
                                    'message'   => __('transaction.payout_setting_error')
                                ]);
                                return; 
                            }

                            $escrow_email   = $payouts_settings['escrow']['escrow_email'];
                            $escrow_api     = $payouts_settings['escrow']['escrow_api'];
                            $escrow         =   new EscrowPayment($escrow_email, $escrow_api);
                            $response       = $escrow->updateTransaction( $transaction_detail->transaction->trans_ref_no, 'receive' );
                            if( $response['type'] == 'success' ){

                                $response = $escrow->updateTransaction( $transaction_detail->transaction->trans_ref_no, 'accept' );
                                if( $response['type'] == 'error' ){

                                    $this->dispatchBrowserEvent('showAlertMessage', $response);
                                    return; 
                                }
                            }else{
                                $this->dispatchBrowserEvent('showAlertMessage', $response);
                                return;  
                            }

                        break;

                        case 'stripe':

                            $seller_payout = SellerPayout::where('transaction_id', $transaction_detail->transaction->id)->first();
                            if( !empty($seller_payout) ){

                                if( $seller_payout->admin_commission > 0 ){
                                    AdminPayout::updateOrCreate(['transaction_id' => $transaction_detail->transaction->id], [
                                        'transaction_id'    => $transaction_detail->transaction->id,
                                        'amount'            => $seller_payout->admin_commission,
                                    ]);
                                }

                                $user_wallet        = UserWallet::where('profile_id' , $seller_payout->seller_id)->first();
                                $wallet_profile_id  = !empty($user_wallet) ? $user_wallet->profile_id : 0;
                                $wallet_amount      = !empty($user_wallet) ? $user_wallet->amount : 0;
                                $wallet_amount      += $seller_payout->seller_amount;

                                $wallet = UserWallet::updateOrCreate(['profile_id' => $wallet_profile_id], [
                                    'profile_id'  => $seller_payout->seller_id, 
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

                    $transaction = Transaction::select('id')->find($transaction_detail->transaction->id);
                    $transaction->update(['status'  => 'completed']);
                    $proposal_milestone->update(['status'   => 'completed']);

                    $proposal = Proposal::select('author_id')->find($this->proposal_id);

                    // notify seller to send mail while accept milestone
                    $this->notifySeller($id, 'milestone_accepted');
                    $total_milestones      = ProposalMilestone::where(['proposal_id' => $this->proposal_id])->count('id');
                    $completed_milestones  = ProposalMilestone::where(['status' => 'completed', 'proposal_id' => $this->proposal_id])
                    ->count('id');

                    if( $total_milestones == $completed_milestones ){
                        // notify seller when last milestone approve send contract completion email
                        $this->notifySeller($id, 'milestone_project_complete');
                        Proposal::where('id', $this->proposal_id)->update(['status'=> 'completed']); 
                    }

                    $completed_proposals = Proposal::where('project_id', $this->project_id)
                    ->whereIn('status', array('completed', 'refunded'))->count('id');

                    $project_proposals = Project::select('id','project_hiring_seller')->find($this->project_id);
                    if($completed_proposals == $project_proposals->project_hiring_seller ){
                        $project_proposals->update(['status'=> 'completed']);
                    }
                } 
            }
        }
    }

    public function confirmDeclineMilestone($id){

        $this->decline_milestone_id = $id;
        $this->dispatchBrowserEvent('show-decline-reason-modal',array('modal'=>'show'));
    }
    
    public function confirmDeclineContract(){

        $this->decline_milestone_id = 0;
        $this->dispatchBrowserEvent('show-decline-reason-modal',array('modal'=>'show'));
    }

    public function UpdatedeclineReason(){

        if( $this->decline_milestone_id > 0 ){
            $this->declineMilestone();
        }else{
            $this->declineContract();
        }
    }

    //when accept, declined or complete milestone project contract
    public function notifySeller($milestone_id, $email_type){ 

        $milestoneInfo = ProposalMilestone::whereId($milestone_id)
        ->select('id','title','proposal_id')
        ->with( 'proposal', function($query){
            $query->select('id','author_id','project_id');
            $query->with([
                'proposalAuthor:id,user_id,first_name,last_name',
                'project:id,project_title,slug,author_id'
            ]);
        })->first();

        $email_template = EmailTemplate::select('content')
        ->where(['type' => $email_type, 'status' => 'active', 'role' => 'seller'])
        ->latest()->first();
        $milestone_title    = $milestoneInfo->title; 
        $project_title      = $milestoneInfo->proposal->project->project_title;
        $project_slug       = $milestoneInfo->proposal->project->slug;
      
        $user_name        = $milestoneInfo->proposal->proposalAuthor->full_name;
        $activity_link      = route('project-activity', ['slug' => $project_slug, 'id'=> $milestoneInfo->proposal->id]);

        if(!empty($email_template)){
            $template_data              =  unserialize($email_template->content);
            $params                     = array();
            $params['template_type']    = $email_type;

            $params['email_params']     = array(
                'user_name'             => $user_name,
                'project_title'         => $project_title,
                'milestone_title'       => $milestone_title,
                'project_activity_link' => $activity_link,
                'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
            );
            $userId = $milestoneInfo->proposal->proposalAuthor->user_id;
            try {
                User::find($userId)->notify(new EmailNotification($params));
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

    public function declineMilestone(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( $this->userRole == 'buyer' ){

            $proposal = Proposal::select('project_id', 'author_id')->with('project', function($query){
                $query->select('id','author_id');
            })->where('id', $this->proposal_id)->first();
            
            if( !empty($proposal) && $proposal->project->author_id == $this->profile_id ){

                $this->validate([
                    'decline_reason' => 'required',
                ]);
            
                $updateMilestone = ProposalMilestone::where(
                    [  'id'            => $this->decline_milestone_id],
                    [  'proposal_id'   => $this->proposal_id],
                    [  'status'        => 'queued' ])->update(
                    [
                        'decline_reason'    => sanitizeTextField($this->decline_reason, true),
                        'status'            => 'cancelled'
                    ]
                );

                if( !empty( $updateMilestone ) ){
                    // notify seller to declined milestone
                    $this->notifySeller($this->decline_milestone_id, 'milestone_declined');

                    $transaction_detail = TransactionDetail::select('transaction_id')->where([
                        'transaction_type'  => 1,
                        'type_ref_id'       => $this->decline_milestone_id
                    ])->latest()->first();

                    if( !empty($transaction_detail) ){

                        $transaction = Transaction::select('id', 'status')
                        ->where('id', $transaction_detail->transaction_id)->latest()->first();
                            
                        if( $transaction->status == 'processed' ){
                            $transaction->update(['status'=> 'cancelled']);
                        }
                    }

                    ProjectActivity::create([
                        'sender_id'         =>  $proposal->project->author_id,
                        'receiver_id'       =>  $proposal->author_id,
                        'project_id'        =>  $this->project_id,
                        'attachments'       =>  null,
                        'description'       => sanitizeTextField($this->decline_reason, true)
                    ]);

                    $eventData['type']      = 'success';
                    $eventData['title']     = __('proposal.milestone_decline_title');
                    $eventData['message']   = __('proposal.milestone_cancelled');

                    $this->decline_reason           = '';
                    $this->decline_milestone_id     = '';
                }else{

                    $eventData['type']      = 'error';           
                    $eventData['title']     = __('general.error_title');
                    $eventData['message']   = __('settings.wrong_msg');
                }
                $this->dispatchBrowserEvent('showAlertMessage', $eventData);
            } 
        }
        $this->dispatchBrowserEvent('show-decline-reason-modal', array('modal' => 'hide')); 
    }

    public function declineContract(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( $this->userRole == 'buyer' ){

            $proposal = Proposal::select('id', 'project_id', 'author_id', 'payout_type')
            ->with([
                'project:id,author_id,project_title,slug', 
                'proposalAuthor:id,user_id,first_name,last_name',
                'proposalAuthor.user' 
            ])->where('id', $this->proposal_id)->first();
            
            if( !empty($proposal) 
                && $proposal->project->author_id == $this->profile_id
                && $proposal->payout_type == 'fixed' ){

                $this->validate([
                    'decline_reason' => 'required',
                ]);

                $proposal->update([
                    'status'            => 'rejected',
                    'decline_reason'    => sanitizeTextField($this->decline_reason, true),
                ]);

                $email_template = EmailTemplate::select('content')
                ->where(['type' => 'project_complete_req_declined' , 'status' => 'active', 'role' => 'seller'])
                ->latest()->first();
                
                if( !empty($email_template) ) {

                    $template_data              =  unserialize($email_template->content);
                    $params                     = array();
                    $params['template_type']    = 'project_complete_req_declined';
                    $params['email_params']     = array(
                        'user_name'             => $proposal->proposalAuthor->full_name,
                        'project_title'         => $proposal->project->project_title,
                        'declined_reason'       => sanitizeTextField($this->decline_reason, true),
                        'project_activity_link' => route('project-activity', [ 'slug' => $proposal->project->slug , 'id' => $this->proposal_id ] ),
                        'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                        'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                        'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
                    );
                    $notify_user = $proposal->proposalAuthor->user;
                    
                    try {
                        $notify_user->notify( new EmailNotification( $params ) );
                    } catch (\Exception $e) {
                        $this->dispatchBrowserEvent('showAlertMessage', [
                            'type'      => 'error',
                            'title'     => __('general.error_title'),
                            'message'   => $e->getMessage(),
                            'autoClose' => 10000,
                        ]);
                        return;
                    }
                }

                $eventData['type']      = 'success';
                $eventData['title']     = __('proposal.decline_contract_title');
                $eventData['message']   = __('proposal.contract_cancelled');
                $this->dispatchBrowserEvent('showAlertMessage', $eventData);
                $this->decline_reason = '';
            }
        } 
        $this->dispatchBrowserEvent('show-decline-reason-modal', array('modal' => 'hide'));       
    }

    public function completeContract( $review = 0 ){
       
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $proposal = Proposal::select('id', 'author_id', 'payout_type', 'status')
        ->with(['proposalAuthor:id,user_id,first_name,last_name','proposalAuthor.user'])
        ->whereIn('status', array('hired', 'queued', 'rejected'))->find($this->proposal_id);
        $project = Project::select('id', 'author_id', 'project_title', 'slug', 'project_hiring_seller')->find($this->project_id);
        $error = false;
        if( !empty($proposal) ){

            if( $this->userRole == 'buyer' ){

                if( $this->profile_id == $project->author_id ){

                    if( $proposal->payout_type == 'hourly' ){

                        $proposal_timecard = ProposalTimecard::select('id')
                        ->where('proposal_id', $this->proposal_id)->whereIn('status',  array('pending', 'queued', 'cancelled'))->get();
                        if( !$proposal_timecard->isEmpty() ){
                            $error = true;  
                        }
                    }elseif( $proposal->payout_type == 'milestone' ){

                        $total_milestone = ProposalMilestone::where(['proposal_id' => $this->proposal_id])->count('id');

                        $completed_milestone = ProposalMilestone::where([   
                            'proposal_id'   => $this->proposal_id,
                            'status'        => 'completed'
                        ])->count('id');

                        if( $total_milestone != $completed_milestone ){
                            $error = true;   
                        }
                    }

                    if( $error ){

                        $response = array();
                        $response['type']       = 'error';
                        $response['title']      = __('proposal.hourly_contract_completition_title');
                        $response['message']    = __('proposal.hourly_contract_completition_err');

                        $this->dispatchBrowserEvent('showAlertMessage', $response);
                        return; 
                    }

                    if( $review ){

                        $this->validate([
                            'contractRatingTitle'  => 'required',
                            'contractRating'       => 'required|numeric',
                            'contractRatingDesc'   => 'nullable',
                        ]);

                        SellerRating::select('id')->updateOrCreate([
                            'seller_id'         => $proposal->author_id,
                            'corresponding_id'  => $proposal->id,
                            'type'              => 'proposal',
                            'buyer_id'          => $this->profile_id,
                        ],[
                            'seller_id'             => $proposal->author_id,
                            'corresponding_id'      => $proposal->id,
                            'buyer_id'              => $this->profile_id,
                            'type'                  => 'proposal',
                            'rating'                => $this->contractRating > 5 ? 5 : $this->contractRating,
                            'rating_title'          => sanitizeTextField($this->contractRatingTitle),
                            'rating_description'    => sanitizeTextField($this->contractRatingDesc, true) ,
                        ]);
                    }
                }
            }    

            if( $proposal->payout_type == 'fixed' ){

                $transaction_detail = TransactionDetail::select('id', 'transaction_id')->where([
                    'transaction_type'  => 2,
                    'type_ref_id'       => $this->proposal_id
                ])
                ->with('Transaction', function($query){
                    $query->select('id', 'trans_ref_no', 'creator_id', 'invoice_ref_no', 'payment_method', 'status');
                })->whereHas('Transaction', function($query){
                    $query->where('status', 'processed');
                })->latest()->first();
               
                if( !empty($transaction_detail) ){
                   
                    $payment_method = $transaction_detail->transaction->payment_method;
                    switch( $payment_method ){
                        
                        case 'escrow':

                            $billing_info   =   UserBillingDetail::select('payout_settings')
                            ->where('profile_id', $this->profile_id)
                            ->first();

                            if( empty($billing_info) || empty($billing_info->payout_settings ) ){

                                $this->dispatchBrowserEvent('showAlertMessage', [
                                    'title'     => __('general.error_title'),
                                    'type'      => 'error',
                                    'message'   => __('transaction.payout_setting_error')
                                ]);
                                return; 
                            }

                            $payouts_settings = unserialize( $billing_info->payout_settings );

                            if( empty($payouts_settings['escrow']) ){

                                $this->dispatchBrowserEvent('showAlertMessage', [
                                    'title'     => __('general.error_title'),
                                    'type'      => 'error',
                                    'message'   => __('transaction.payout_setting_error')
                                ]);
                                return; 
                            }

                            $escrow_email       = $payouts_settings['escrow']['escrow_email'];
                            $escrow_api         = $payouts_settings['escrow']['escrow_api'];
                            $escrow             =   new EscrowPayment( $escrow_email, $escrow_api );
                            
                            if( $this->userRole == 'buyer' ){

                                $response    = $escrow->updateTransaction( $transaction_detail->transaction->trans_ref_no, 'receive' );
                                if( $response['type'] == 'success' ){

                                    $response = $escrow->updateTransaction( $transaction_detail->transaction->trans_ref_no, 'accept' );
                                    if( $response['type'] == 'error' ){
                                        $this->dispatchBrowserEvent('showAlertMessage', $response);
                                        return; 
                                    }    
                                }else{
                                    $this->dispatchBrowserEvent('showAlertMessage', $response);
                                    return;  
                                }
                            }elseif( $this->userRole == 'seller' && $proposal->status == 'hired' ){

                                $response = $escrow->getSellerDisburseMethod( $transaction_detail->transaction->trans_ref_no );
                                if( $response['type'] == 'error' ){
                                    $this->dispatchBrowserEvent('showAlertMessage', $response);
                                    return;   
                                }elseif( !$response['selected_disbursement_method'] ){
                                    
                                    if( !empty($this->escrow_disburse_id) ){

                                        $response = $escrow->setSellerTransactionDisburseMethod([
                                            'transaction_ref'       => $transaction_detail->transaction->trans_ref_no,
                                            'escrow_disburse_id'    => $this->escrow_disburse_id,
                                            'use_same_method'       => false,
                                        ]);
    
                                        if( $response['type'] == 'error' ){
                                            $this->dispatchBrowserEvent('showAlertMessage', $response);
                                            return;   
                                        } 
                                    }elseif( !empty($response['saved_disbursement_methods']) ){
        
                                        $this->dispatchBrowserEvent('escrowDisburseMethods', [
                                            'disburse_methods'  => $response['saved_disbursement_methods']
                                        ]);
                                        return;
                                    }else{
                                        $this->dispatchBrowserEvent('showAlertMessage', [
                                            'title'     => __('general.error_title'),
                                            'type'      => 'error',
                                            'message'   => __('transaction.escrow_disburse_methods')
                                        ]);
                                        return;
                                    } 
                                }

                                $response  = $escrow->updateTransaction( $transaction_detail->transaction->trans_ref_no, 'ship' );
                                if(  $response['type'] == 'error' ){
                                    $this->dispatchBrowserEvent('showAlertMessage', $response);
                                    return;
                                }    
                            }
                        break;

                        case 'stripe':

                            if( $this->userRole == 'buyer' ){
                                
                                $seller_payout = SellerPayout::where('transaction_id', $transaction_detail->transaction->id)->first();
                                if( !empty($seller_payout)  ){

                                    if( $seller_payout->admin_commission > 0 ){
                                        AdminPayout::updateOrCreate(['transaction_id' => $transaction_detail->transaction->id], [
                                            'transaction_id'    => $transaction_detail->transaction->id,
                                            'amount'            => $seller_payout->admin_commission,
                                        ]);
                                    }

                                    $user_wallet        = UserWallet::where('profile_id', $proposal->author_id)->first();
                                    $wallet_profile_id  = !empty($user_wallet) ? $user_wallet->profile_id : 0;
                                    $wallet_amount      = !empty($user_wallet) ? $user_wallet->amount : 0;
                                    $wallet_amount      += $seller_payout->seller_amount;

                                    $wallet = UserWallet::updateOrCreate(['profile_id' => $wallet_profile_id], [
                                        'profile_id'  => $proposal->author_id, 
                                        'amount'      => $wallet_amount, 
                                    ]);

                                    UserWalletDetail::create([
                                        'transaction_id'    => $transaction_detail->transaction->id, 
                                        'wallet_id'         => $wallet->id, 
                                        'amount'            => $seller_payout->seller_amount, 
                                    ]);
                                }
                            }
                        break;    
                    }

                    if( $this->userRole == 'seller' ){

                        // notify to buyer to accept project completion request.
                        $proposal->load([ 'proposalAuthor' => function ($query){
                            $query->select('id','user_id','first_name','last_name');
                        }]);

                        $project->load([ 'projectAuthor' => function ($query){
                            $query->select('id','user_id','first_name','last_name');
                            $query->with('user');
                        }]);

                        $proposal_id    = $proposal->id;
                        $seller_name    = $proposal->proposalAuthor->full_name;
                        $user_name      = $project->projectAuthor->full_name;
                        $notify_user    = $project->projectAuthor->user;

                        $proposal->update(['status' => 'queued']);

                        $email_template = EmailTemplate::select('content')
                        ->where(['type' => 'project_complete_request' , 'status' => 'active', 'role' => 'buyer'])
                        ->latest()->first();
                        
                        if( !empty($email_template) ) {

                            $template_data              =  unserialize($email_template->content);
                            $params                     = array();
                            $params['template_type']    = 'project_complete_request';
                            $params['email_params']     = array(
                                'user_name'             => $user_name,
                                'seller_name'           => $seller_name,
                                'project_title'         => $project->project_title,
                                'project_activity_link' => route('project-activity', [ 'slug' => $project->slug , 'id' => $proposal_id ] ),
                                'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                                'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                                'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
                            );

                            try {
                                $notify_user->notify( new EmailNotification( $params ) );
                            } catch (\Exception $e) {
                                $this->dispatchBrowserEvent('showAlertMessage', [
                                    'type'      => 'error',
                                    'title'     => __('general.error_title'),
                                    'message'   => $e->getMessage(),
                                    'autoClose' => 10000,
                                ]);
                                return;
                            }
                        }
                        $eventData = array();
                        $eventData['type']      = 'success';
                        $eventData['title']     = __('general.success_title');
                        $eventData['message']   = __('proposal.buyer_approval_request');
                        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
                        return;
                    }elseif( $this->userRole == 'buyer' ){
                        $transaction = Transaction::select('id')->find($transaction_detail->transaction->id);
                        $transaction->update(['status'  => 'completed']);
                    }         
                }      
            }

            if( $this->userRole == 'buyer' ){

                $isUpdate = $proposal->update(['status' => 'completed']); 
                
                if( $isUpdate ){

                    // notify to seller about contract completion.
                    $email_template = EmailTemplate::select('content')
                    ->where(['type' => 'project_complete_request_accepted' , 'status' => 'active', 'role' => 'seller'])
                    ->latest()->first();

                     if( !empty($email_template) ) {

                        $template_data              =  unserialize($email_template->content);
                        $params                     = array();
                        $params['template_type']    = 'project_complete_request_accepted';
                        $params['email_params']     = array(
                            'user_name'             => $proposal->proposalAuthor->full_name,
                            'project_title'         => $project->project_title,
                            'project_activity_link' => route('project-activity', [ 'slug' => $project->slug , 'id' => $this->proposal_id ] ),
                            'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                            'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                            'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
                        );
                        $notify_user = $proposal->proposalAuthor->user;

                        try {
                            $notify_user->notify( new EmailNotification( $params ) );
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
                $completed_proposals = Proposal::where('project_id', $this->project_id)
                ->whereIn('status', array('completed', 'refunded'))->count('id');

                if( $completed_proposals == $project->project_hiring_seller ){
                    $project->update(['status'=> 'completed']);
                }
            }

            $this->dispatchBrowserEvent('contract-rating-modal',array('modal'=>'hide'));
        }
    }

    public function createDisputeRequest(){
        
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
            'dispute_issue'         => 'required',
            'dispute_detail'        => 'required',
            'agree_term_condtion'   => 'boolean|required|accepted',
        ]);

        if( $this->userRole == 'buyer' || $this->userRole == 'seller' ){
            
                $refund_price   = '';
                $eventData      = [];
                $proposal       = Proposal::select('id','project_id','proposal_amount','payout_type','author_id', 'status')
                ->with('project:id,author_id')
                ->where('status', 'hired')
                ->find($this->proposal_id);

                if(!$proposal ){

                    $this->dispatchBrowserEvent('showAlertMessage', [
                        'type'      => 'error',
                        'title'     => __('general.error_title'),
                        'message'   => __('proposal.dispute_creation_err')
                    ]);
                    return; 
                }
                if( $proposal->payout_type == 'milestone' ){
                    $proposal->load([ 'milestones' => function ($query){
                        $query->whereIn('status',['processed','cancelled','queued','processing']);
                        $query->select('proposal_id','price','status');
                    }]);

                    if(!$proposal->milestones->isEmpty() ){
                        $inProcessing = [];
                        $isProcessed  = [];
                        
                        foreach($proposal->milestones as $milestone){
                            if($milestone->status == 'processing'){
                                $inProcessing[] = $milestone->id;
                            } else {
                                $isProcessed[] = $milestone->id;
                            } 
                        }
        
                        if( !empty($inProcessing) ){
                            $eventData['type']      = 'alert';
                            $eventData['title']     = __('general.error_title');
                            $eventData['message']   = __('disputes.payment_processing_alert');
                            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
                            return;
                        } elseif ( empty($isProcessed) ){
                            $eventData['type']      = 'alert';
                            $eventData['title']     = __('general.error_title');
                            $eventData['message']   = __('disputes.no_milestone_processed_alert');
                            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
                            return;
                        }
                    } else {
        
                        $eventData['type']      = 'alert';
                        $eventData['title']     = __('general.error_title');
                        $eventData['message']   = __('disputes.no_milestone_processed_alert');
                        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
                        return;
                    }
                    
                }elseif( $proposal->payout_type == 'hourly' ) {
                    $proposal->load(['timecards' => function ($query){
                        $query->whereIn('status',['processed', 'queued', 'cancelled']);
                        $query->select('proposal_id','price');
                    }]);
                }
               
                if( $proposal->payout_type == 'milestone' ){
                    $refund_price = $proposal->milestones->sum('price');
                } elseif( $proposal->payout_type == 'fixed' ){
                    $refund_price = $proposal->proposal_amount;
                } elseif( $proposal->payout_type == 'hourly' ){
                    $refund_price = $proposal->timecards->sum('price');
                }

                $dispute_log = array(
                    '0' =>  array(
                        'action_by' => $this->profile_id,
                        'action_date' => date('Y-m-d H:i:s')
                    )
                );
                $data = array();
                $data['created_by']     = $this->profile_id;
                $data['created_to']     = $this->userRole == 'buyer' ? $proposal->author_id : $proposal->project->author_id;
                $data['price']          = $refund_price;
                $data['proposal_id']    = $this->proposal_id;
                $data['dispute_issue']  = sanitizeTextField($this->dispute_issue);
                $data['dispute_detail'] = sanitizeTextField($this->dispute_detail, true);
                $data['status']         = $this->userRole == 'buyer' ? 'publish' : 'disputed';
                $data['resolved_by']    = $this->userRole == 'buyer' ? 'seller' : 'admin';
                $data['dispute_log']    = serialize($dispute_log);
                DB::beginTransaction();
                try {
                    $disputed       = Dispute::create($data);
                    $updateStatus   = Proposal::where('id',$this->proposal_id)->update(['status'=>'disputed']);
                    DB::commit();
                    $eventData['type']      = 'success';
                    $eventData['title']     = __('general.success_title');
                    $eventData['message']   = __('proposal.proposal_disputed_alert');
                    $this->dispatchBrowserEvent('dispute-popup', array('modal' => 'hide'));
                    $this->emit('updateSellerProposal', $this->proposal_id);

                    // send email to admin
                    $content_type   = $this->userRole == 'buyer' ? 'seller_dispute_received' : 'admin_received_dispute';
                    $content_role   = $this->userRole == 'buyer' ? 'seller' : 'admin';
                    $email_template = EmailTemplate::select('content')
                    ->where(['type' => $content_type , 'status' => 'active', 'role' => $content_role])
                    ->latest()->first();
                    
                    if( !empty($email_template) ){

                        $emailReceiver  = '';
                        $userName       = '';
                        $buyerName      = '';
                        $buyerComments  = '';
                        $proposal->load([ 'project' => function ($query){
                            $query->select('id','author_id', 'project_title');
                        }]);

                        $projectTitle = !empty( $proposal->project->project_title ) ? $proposal->project->project_title : '';
                        if($this->userRole == 'buyer'){
                            if($this->userRole == 'buyer'){
                                $proposal->load([ 'proposalAuthor' => function ($query){
                                    $query->select('id','user_id','first_name','last_name');
                                    $query->with('user');
                                }]);
                            }

                           $userName        = $proposal->proposalAuthor->full_name;
                           $emailReceiver   = $proposal->proposalAuthor->user;
                           $userInfo        = getUserInfo();
                           $buyerName       = $userInfo['user_name'];
                           $buyerComments   = sanitizeTextField($this->dispute_detail);
                        }else{
                            //admin info
                            $emailReceiver = User::whereHas(
                                'roles', function($q){
                                    $q->where('name', 'admin');
                                }
                            )->latest()->first();
                        }
                        
                        $template_data              =  unserialize($email_template->content);
                        $params                     = array();
                        $params['template_type']    = $content_type;
                        $params['email_params']     = array(
                            'user_name'             => $userName,
                            'buyer_name'            => $buyerName,
                            'project_title'         => $projectTitle,
                            'buyer_comments'        => $buyerComments, 
                            'type'                  => 'project', 
                            'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                            'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                            'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
                        );

                       try {
                            Notification::send($emailReceiver, new EmailNotification($params));
                        } catch (\Exception $e) {
                            $this->dispatchBrowserEvent('showAlertMessage', [
                                'title'     => __('general.error_title'),
                                'type'      => 'error',
                                'message'   => $e->getMessage(),
                            ]);
                            return;
                        }
                        
                    }
                    //end sent email
                }catch (\Exception $e) {
                    DB::rollback();
                    
                    $eventData['type']      = 'error';
                    $eventData['title']     = __('general.error_title');
                    $eventData['message']   = $e->getMessage();
                }

            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }
    }

    public function resetDisputRec(){

        $this->dispute_issue    = '';
        $this->dispute_detail   = '';
        $this->agree_term_condtion   = '';
    }

    public function showDisputePopup(){
        
        if($this->payout_type == 'milestone'){

            $milestones = ProposalMilestone::where('proposal_id', $this->proposal_id)
            ->whereIn('status', ['processed', 'queued', 'cancelled', 'processing' ])->get(['id','status']);
            
            if(!$milestones->isEmpty()){
                $inProcessing = [];
                $isProcessed  = [];
                
                foreach($milestones as $milestone){
                    if($milestone->status == 'processing'){
                        $inProcessing[] = $milestone->id;
                    } else {
                        $isProcessed[] = $milestone->id;
                    } 
                }

                if( !empty($inProcessing) ){
                    $eventData['type']      = 'alert';
                    $eventData['title']     = __('general.error_title');
                    $eventData['message']   = __('disputes.payment_processing_alert');
                    $this->dispatchBrowserEvent('showAlertMessage', $eventData);
                    return;
                } elseif ( empty($isProcessed) ){
                    $eventData['type']      = 'alert';
                    $eventData['title']     = __('general.error_title');
                    $eventData['message']   = __('disputes.no_milestone_processed_alert');
                    $this->dispatchBrowserEvent('showAlertMessage', $eventData);
                    return;
                }
            } else {

                $eventData['type']      = 'alert';
                $eventData['title']     = __('general.error_title');
                $eventData['message']   = __('disputes.no_milestone_processed_alert');
                $this->dispatchBrowserEvent('showAlertMessage', $eventData);
                return;
            }
        }


        $disputeType    = $this->userRole == 'buyer' ? 'buyer_dispute_issues' : 'seller_dispute_issues';
        $disputeColumn  = $this->userRole == 'buyer' ? 'buyer_issues' : 'seller_issues';

        $disputeType            =  setting('_dispute.'.$disputeType);
        $this->disputeIssues    = !empty( $disputeType ) ? array_column($disputeType, $disputeColumn) : array();

        $this->dispute_issue        = '';
        $this->dispute_detail       = '';
        $this->agree_term_condtion  = false;

        $this->dispatchBrowserEvent('dispute-popup', array('modal' => 'show'));
    }

    public function RaiseDisputeToAdmin(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $disputeLog = Dispute::select('dispute_log')->find($this->dispute_id);
        $dispute_log = !empty( $disputeLog->dispute_log ) ? unserialize($disputeLog->dispute_log)  : array();
        $dispute_log['2'] = array(
            'action_by' => $this->profile_id,
            'action_date' => date('Y-m-d H:i:s')
        );

        $updateStatus = Dispute::where('id', $this->dispute_id)->update([ 
            'status'        => 'disputed', 
            'resolved_by'   => 'admin',
            'dispute_log'   => serialize($dispute_log),
        ]);

        // send email to admin
            $email_template = EmailTemplate::select('content')
            ->where(['type' => 'admin_received_dispute' , 'status' => 'active', 'role' => 'admin'])
            ->latest()->first();
            
            if(!empty($email_template)){
                $project = Project::whereId($this->project_id)->select('project_title')->first();
               
                $projectTitle = !empty( $project->project_title ) ? $project->project_title : '';
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
                    'type'                  => 'project',
                    'project_title'         => $projectTitle,
                    'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                    'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                    'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
                );
                try {
                    Notification::send($NotifyUser, new EmailNotification($params));
                } catch (\Exception $e) {
                    $this->dispatchBrowserEvent('showAlertMessage', [
                        'title'     => __('general.error_title'),
                        'type'      => 'error',
                        'message'   => $e->getMessage(),
                    ]);
                    return;
                }
            }
        //end sent email

        if( ! empty( $updateStatus ) ){
            $this->checkDisputeStatus($this->proposal_id);
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('proposal.dispute_created_alert');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';
        }

        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }

    public function checkDisputeStatus( $proposal_status ){

        if( $proposal_status == 'disputed' || $proposal_status == 'refunded'){
            
            $dispute = Dispute::where('proposal_id', $this->proposal_id)
            ->where( function($query){
                $query->where('created_by', $this->profile_id)->orWhere('created_to', $this->profile_id);
            })->select('id', 'created_by', 'created_to', 'resolved_by', 'favour_to', 'status','created_at')->with(['disputeCreator'])->first();
            
            if(!empty($dispute)){

                $this->dispute_id           = $dispute->id;
                $this->dispute_status       = $dispute->status; 
                $this->proposal_disputed    = true;
                $createdBy                  = $dispute->created_by;
                $role_id                    = $dispute->disputeCreator->role_id;
                $creatorRole                = getRoleById($role_id);
                $disputedTime               = Carbon::parse($dispute->created_at)->diffInDays();

                if( $dispute->status == 'publish' ){

                    $this->dispute_class         = 'tk-notify-alert';
                    if( ( $disputedTime > $this->disputeAfterDays ) && ( $this->userRole == 'buyer' ) && ( $creatorRole == 'buyer' ) ){

                        $this->dispute_status_txt   = __('disputes.dispute_no_resp_status');
                        $this->dispute_desc_txt     = __('disputes.dispute_no_resp_desc');
                        $this->dispute_status       = 'declined';
                        $this->status_icon          = asset('images/icons/duration.png'); 
                    } else {

                        $this->dispute_status_txt  =  __('disputes.dispute_create_status');
                        $this->dispute_desc_txt    =  __('disputes.dispute_create_desc');
                        $this->status_icon         = asset('images/icons/alert.png'); 
                    }
                }elseif( $dispute->status == 'declined' ){

                    $this->dispute_status_txt   = __('disputes.dispute_reject_status');
                    $this->dispute_desc_txt     = $this->userRole == 'buyer' ? __('disputes.dispute_reject_desc') : __('disputes.dispute_reject_seller_desc');
                    $this->status_icon          = $this->userRole == 'buyer' ? asset('images/icons/duration.png') : asset('images/icons/alert.png'); 
                    $this->dispute_class        = 'tk-notify-alert';

                }elseif( $dispute->status == 'disputed' && $creatorRole == 'buyer' ){

                    $this->dispute_status_txt   = __('disputes.dispute_wait_status');
                    $this->dispute_desc_txt     = __('disputes.dispute_wait_desc');
                    $this->status_icon          = asset('images/icons/waiting.png'); 
                    $this->dispute_class        = 'tk-notify-dispute';
                }elseif( $dispute->status == 'disputed' && $creatorRole == 'seller' ){

                    $this->dispute_status_txt   = __('disputes.dispute_create_status');
                    $this->dispute_desc_txt     = __('disputes.dispute_create_desc');
                    $this->status_icon          = asset('images/icons/alert.png'); 
                    $this->dispute_class        = 'tk-notify-alert';
                }elseif( $dispute->status == 'refunded') {
                    
                    $this->dispute_status_txt   = $dispute->favour_to == $this->userRole ? __('disputes.dispute_refunde_favor_status') : __('disputes.dispute_refund_reject_status');
                    $this->dispute_desc_txt     = $dispute->favour_to == $this->userRole ?  __('disputes.dispute_refunde_favor_desc') : __('disputes.dispute_refund_reject_desc');
                    $this->status_icon          = $dispute->favour_to == $this->userRole ? asset('images/icons/success.png') : asset('images/icons/cross.png'); 
                    $this->dispute_class        = $dispute->favour_to == $this->userRole ?  'tk-notify-success' : 'tk-notify-alert';
                }
            } else {
                $this->proposal_disputed = false;
            }
        }else{
            $this->proposal_disputed = false;
        }
    }
}
