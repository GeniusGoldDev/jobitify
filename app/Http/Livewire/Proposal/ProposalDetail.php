<?php

namespace App\Http\Livewire\Proposal;

use App\Models\User;
use App\Models\Project;
use Livewire\Component;
use App\Events\NotifyUser;
use App\Models\EmailTemplate;
use App\Models\Proposal\Proposal;
use App\Notifications\EmailNotification;
use App\Models\Proposal\ProposalMilestone;
use Illuminate\Support\Facades\Notification;

class ProposalDetail extends Component
{
    public $date_format         = '';
    public $address_format      = '';
    public $currency_symbol     = '';
    public $project             = null;
    public $proposal            = null;
    public $propsal_id          = ''; 
    public $seller_name         ='';
    public $decline_reason      ='';
    public $userRole            = '';

    public function mount($slug, $id){

        $this->propsal_id   = $id;
        $user               = getUserRole();
        $profile_id         = $user['profileId']; 
        $whereClause        = array('slug' => $slug);
        $this->userRole     = $user['roleName'];

        if( $user['roleName'] == 'buyer' ){
            $whereClause['author_id'] = $profile_id;
        }

        $this->project = Project::select(
            'id',
            'project_title',
            'slug',
            'project_type',
            'project_expert_level',
            'project_hiring_seller',
            'updated_at',
            'project_min_price',
            'project_max_price',
            'project_location',
            'project_country',
            'is_featured',
            'status')
        ->with([
            'projectLocation:id,name',
            'expertiseLevel:id,name',
            ])
        ->where($whereClause)->firstOrFail();
        $proposalWhereClause = array('project_id' => $this->project->id);

        if( $user['roleName'] == 'seller' ){
            $proposalWhereClause['author_id'] = $profile_id;
        }

        $this->proposal = Proposal::with([
            'milestones:id,proposal_id,title,price,description,status',
            'proposalAuthor' => function($query){
            $query->select('id','user_id','image','first_name','last_name', 'slug')
            ->withAvg('ratings','rating')->withCount('ratings');
        }])->where($proposalWhereClause)->findOrFail($id);

        $this->processed_milestones = ProposalMilestone::where('proposal_id' , $this->proposal->id)
        ->where('status', '!=', 'pending')->count('id');
        $this->seller_name           = $this->proposal->proposalAuthor->full_name;
        
        $date_format                    = setting('_general.date_format');
        $address_format                 = setting('_general.address_format');
        $currency                       = setting('_general.currency');
        
        $currency_detail             = !empty($currency)     ? currencyList($currency) : array();
        $this->date_format           = !empty($date_format)  ? $date_format : 'm d, Y';
        $this->address_format        = !empty($address_format)  ? $address_format : 'state_country';
        if(!empty($currency_detail)){
            $this->currency_symbol   = $currency_detail['symbol']; 
        }
    }

    public function hydrate() 
    {
       $this->proposal->proposalAuthor->loadCount('ratings');
       $this->proposal->proposalAuthor->loadAvg('ratings','rating');
    }

    public function render()
    {
        return view('livewire.proposal.proposal-detail')->extends('layouts.app');
    }

    public function confirmDeclineProposal(){
        $this->decline_reason = '';
        $this->dispatchBrowserEvent('show-decline-reason-modal',array('modal'=>'show'));
    }

    public function escrowMilestone( $milestone_id = '' ){
       
        if(!empty($this->proposal->milestones[$milestone_id]) ){

            $milestone = $this->proposal->milestones[$milestone_id];
            $data = array(
                'milestone_id'      => $milestone->id,
                'milestone_title'   => $milestone->title,
                'milestone_price'   => $milestone->price,
            );
            $this->hireSeller($data);
        }
    }

    public function hireSeller( $milestone_data = array() ){
        
        if( $this->proposal->payout_type == 'hourly' ){

            Proposal::where('id', $this->proposal->id)->update(['status' => 'hired']);

            $hired_proposals = Proposal::where(['project_id' => $this->project->id], function($query){
                $query->where('status',     'hired');
                $query->orWhere('status',   'completed');
                $query->orWhere('status',   'refunded');
            })->count('id');

            if( $this->project->status == 'publish' && $hired_proposals == $this->project->project_hiring_seller ){
                Project::where('id', $this->project->id)->update(['status'=> 'hired']);
            }

            $eventData = array();
            $eventData['project_title']             = $this->project->project_title;
            $eventData['user_name']                 = $this->proposal->proposalAuthor->full_name;
            $eventData['user_id']                   = $this->proposal->proposalAuthor->user_id;
            $eventData['project_activity_link']     = route('project-activity', ['slug' => $this->project->slug, 'id'=> $this->proposal->id]);
            $eventData['email_type']                = 'proposal_request_accepted';
            // send mail in hourly project using event
            event(new NotifyUser($eventData));
            return redirect()->route('project-activity', ['slug' => $this->project->slug, 'id' => $this->proposal->id]);
        }else{

            $project_data = [
                'project_id'        => $this->project->id,
                'proposal_id'       => $this->proposal->id,
                'project_title'     => $this->project->project_title,
                'project_slug'      => $this->project->slug,
                'project_type'      => $this->project->project_type,
                'project_min_price' => $this->project->project_min_price,
                'project_max_price' => $this->project->project_max_price,
                'proposal_amount'   => $this->proposal->proposal_amount,
                'payout_type'       => 'fixed',
            ];
    
            if( !empty($milestone_data) ){
                
                $project_data['payout_type'] = 'milestone';
                $project_data = array_merge($project_data, $milestone_data );
            }
            session()->forget('package_data');
            session()->forget('gig_data');
            session()->put(['project_data' => $project_data ]);
    
            return redirect()->route('checkout');
        }
        
    }

    public function declinedProposal(){

        $this->validate([
            'decline_reason' => 'required'
        ]);
        $reason = sanitizeTextField($this->decline_reason, true);
        $record = array(
            'status'            => 'declined',
            'decline_reason'    => $reason,
        );

        $updateStatus = Proposal::where('id', $this->propsal_id)->update($record);
  
        // send email to admin
        if( ! empty( $updateStatus ) ){
            $this->proposal->status = 'declined';
            $email_template = EmailTemplate::select('content')
            ->where(['type' => 'proposal_request_declined' , 'status' => 'active', 'role' => 'seller'])
            ->latest()->first();

            if(!empty($email_template)){
                $projectTitle   = !empty( $this->project->project_title ) ? $this->project->project_title : '';
               
                //Notify user info
                $userId = !empty($this->proposal->proposalAuthor->user_id) ? $this->proposal->proposalAuthor->user_id : '';
                $NotifyUser = User::whereId($userId)->latest()->first();

                $userName = !empty($this->proposal->proposalAuthor) ? $this->proposal->proposalAuthor->full_name : '';
                $template_data              =  unserialize($email_template->content);
                $params                     = array();
                $params['template_type']    = 'proposal_request_declined';
                $params['email_params']     = array(
                    'user_name'             => $userName,
                    'decline_reason'        => $reason,
                    'project_title'         => $projectTitle,
                    'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                    'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                    'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
                );
                if(!empty($NotifyUser)){
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
            }
            //end sent email

            $eventData['title']     = __('proposal.proposal_decline_title');
            $eventData['message']   = __('proposal.proposal_cancelled');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';           
        }

        $this->dispatchBrowserEvent('show-decline-reason-modal',array('modal'=>'hide'));

        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }

    public function ShowDeclineProposalReason(){

        $info = getUserInfo('50x50');
        $declinedProposal = Proposal::select('decline_reason')->find($this->propsal_id);

        if( !empty($declinedProposal) ){

            $reasonData = array(
                'buyerName'         => $info['user_name'],
                'buyerImage'        => asset($info['user_image']), 
                'sellerName'        => __('general.hi_user',['user_name' => $this->seller_name]), 
                'declineReason'     => $declinedProposal->decline_reason,
            );

            $this->dispatchBrowserEvent('ShowdeclinedProposalReason', $reasonData);
        }
    }
    
}
