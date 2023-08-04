<?php

namespace App\Http\Livewire\Proposal;

use App\Models\User;
use App\Models\Project;
use Livewire\Component;
use App\Rules\OverflowRule;
use App\Models\EmailTemplate;
use App\Models\Proposal\Proposal;
use App\Notifications\EmailNotification;
use App\Models\Package\PackageSubscriber;
use Illuminate\Support\Facades\Validator;
use App\Models\Proposal\ProposalMilestone;
use Illuminate\Support\Facades\Notification;


class ProposalSubmission extends Component
{
    
    public $profile_id                      = 0;
    public $edit_id                         = 0;
    public $currency_symbol                 = '';
    public $address_format                  = '';
    public $project                         = '';
    public $posted_projects                 = 0;
    public $hired_projects                  = 0;
    public $commission_type                 = 'free';
    public $commission_value                = 0;
    public $admin_share                     = 0;
    public $working_budget                  = 0;
    public $seller_share                    = 0;
    public $proposal_amount                 = '';
    public $special_comments                = '';
    public $proposal_milestone_payout       = 'no';
    public $proposal_fixed_payout           = 'no';
    public $is_milestone                   = 'no';
    public $available_milestones            = [];
    public $author                          = false;
    public $submit_proposal                 = true;
    public $resubmit_proposal               = false;
    public $proposal_def_status             = 'pending';
    protected $admin_commission             = [];

    protected $queryString = [
        'edit_id'       => ['except' => 0, 'as'=> 'id'],
    ];

    public function mount( $slug ){

        $user = getUserRole();
        $this->profile_id           = $user['profileId']; 
        $date_format                = setting('_general.date_format');
        $address_format             = setting('_general.address_format');
        $currency                   = setting('_general.currency');
        $default_status             = setting('_proposal.proposal_default_status');
        $this->proposal_def_status  = !empty($default_status)  ? $default_status : 'pending';
        $currency_detail            = !empty($currency)  ? currencyList($currency) : array();
        $this->date_format          = !empty($date_format)  ? $date_format : 'm d, Y';
        $this->address_format       = !empty($address_format)  ? $address_format : 'state_country';
        
        if(!empty($currency_detail)){
            $this->currency_symbol        = $currency_detail['symbol']; 
        }

        $this->project = Project::select(
            'id',
            'project_title',
            'project_category',
            'author_id',
            'project_payout_type',
            'project_type',
            'project_payment_mode',
            'project_max_hours',
            'project_min_price',
            'project_max_price',
            'project_duration',
            'project_location',
            'project_country',
            'project_hiring_seller',
            'is_featured',
            'project_expert_level',
            'updated_at',
        );
        $this->project = $this->project->with(
            array(
                'projectDuration:id,name',
                'expertiseLevel:id,name',
                'projectLocation:id,name',
                'category:id,name',
                'languages:id,name',
                'projectAuthor:id,user_id,first_name,last_name,image,description,created_at',
            )
        )->where('slug', $slug)->firstOrFail();

        
        if( $this->project->project_payout_type == 'both' ){

            $this->proposal_milestone_payout    = 'yes'; 
            $this->proposal_fixed_payout        = 'yes'; 
        }elseif( $this->project->project_payout_type == 'fixed' ){
            $this->proposal_fixed_payout = 'yes'; 
        }elseif( $this->project->project_payout_type == 'milestone' ){
            
            $this->proposal_milestone_payout = 'yes'; 
            $this->is_milestone = 'yes';

        }

        if( $this->project->author_id == $this->profile_id ){
            $this->author = true;
        }else{

           $proposal_verify = Proposal::select('id','status', 'resubmit')->where(['project_id'=> $this->project->id, 'author_id' => $this->profile_id])->first();
            
            if( !empty($proposal_verify) ){

                if( $proposal_verify->status == 'draft' || $proposal_verify->status == 'pending' ){
                    $this->edit_id = $proposal_verify->id;
                }elseif( !in_array($proposal_verify->status, array('draft', 'pending')) && $proposal_verify->resubmit != 1 ){
                    $this->submit_proposal = false;
                }elseif( $proposal_verify->resubmit == 1 ){
                    $this->resubmit_proposal = true;
                    $this->edit_id = $proposal_verify->id;
                }
            } 
        }

        $this->posted_projects  = Project::whereIn('status', array('publish','hired','completed'))->where('author_id', $this->project->author_id)->count('id');
        $this->hired_projects   = Project::where('status', 'hired')->where('author_id', $this->project->author_id)->count('id');

        if( $this->edit_id > 0 ){
            $this->edit($this->edit_id);
        }
    }
   
    public function render(){

        return view('livewire.proposal.submit-proposal')->extends('layouts.app');
    }

    public function edit( $id ){
        
        $proposal    = Proposal::with('milestones:id,proposal_id,title,price,description')->where('author_id', $this->profile_id)->find($id);
       
        if( !empty($proposal) && ($proposal->status == 'draft' || $proposal->status == 'pending' || $proposal->resubmit == '1') ){
            
            $this->proposal_amount  = $proposal->proposal_amount;
            $this->special_comments = $proposal->special_comments;
            
            if( $this->project->project_payout_type == 'both' ){

                $this->proposal_milestone_payout    = 'yes'; 
                $this->proposal_fixed_payout        = 'yes'; 
    
            }elseif( $this->project->project_payout_type == 'fixed' ){
    
                $this->proposal_fixed_payout = 'yes'; 
    
            }elseif( $this->project->project_payout_type == 'milestone' ){

                $this->proposal_milestone_payout = 'yes';   
                $this->is_milestone = 'yes';
            }
            
            if(!$proposal->milestones->isEmpty() && ($this->project->project_payout_type == 'milestone' || $this->project->project_payout_type == 'both')){
               
                $this->is_milestone = 'yes';
                foreach($proposal->milestones as $single){
                    $this->available_milestones[] = array(
                        'price'         => $single['price'],
                        'title'         => $single['title'],
                        'description'   => $single['description'],
                    );
                }

            }
             
            $params = array(
                'proposal_amount'       => $proposal->proposal_amount,
                'project_type'          => $this->project->project_type,
                'project_min_price'     => $this->project->project_min_price,
                'project_max_price'     => $this->project->project_max_price,
            );

            $response = getAmountWithcommission($params); 

            $this->commission_type  = $response['commission_type'];
            $this->commission_value = $response['commission_value'];
            $this->working_budget   = $response['working_budget'];
            $this->admin_share      = $response['admin_share'];
            $this->seller_share     = $response['seller_share'];
        }
    }

    public function updateType( $type ){
        
        if($type == 'fixed'){
            $this->is_milestone = 'no';
        }else{
            $this->is_milestone = 'yes';
        }
    }

    public function addNewMilestone(){
        
        $this->available_milestones[] = array(
            'price'         => '',
            'title'         => '',
            'description'   => '',
        );
    }

    public function updateMilestone( $key ){

        if(isset($this->available_milestones[$key])){ 
            unset($this->available_milestones[$key]);
        }
    }

    public function updatedproposalAmount( $value ){

        if(!is_numeric($value)){
            $this->proposal_amount = '';
            $this->seller_share = 0;
            $this->admin_share = 0;
            return;
        }

        $params = array(
            'proposal_amount'       => $value,
            'project_type'          => $this->project->project_type,
            'project_min_price'     => $this->project->project_min_price,
            'project_max_price'     => $this->project->project_max_price,
        );

        $response = getAmountWithcommission($params); 

        $this->commission_type  = $response['commission_type'];
        $this->commission_value = $response['commission_value'];
        $this->working_budget   = $response['working_budget'];
        $this->admin_share      = $response['admin_share'];
        $this->seller_share     = $response['seller_share'];

    }

    public function updateMilestoneOrder( $milestones_list ){
       
        foreach ($milestones_list as $single) {
            
            $value  = $single['value'];
            $key    = $single['order'] - 1;

            if(!empty($this->available_milestones[$value])){
               
                $tempArray[$key] = $this->available_milestones[$value];
            }
        }

        $this->available_milestones = $tempArray;
    }

    public function submitProposal( $status = '' ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( $status == ''){
            $status = $this->proposal_def_status;
        }else{
            $status = 'draft';
        }

        if(!isVerifiedAcc()){
            $this->dispatchBrowserEvent('showAlertMessage', ['title'=> __('general.error_title'),  'type'=> 'error', 'message'=> __('general.acc_not_verified') ]);
            return false;
        }

        $package_detail = packageVerify(['id' => $this->profile_id, 'apply_proposal' => true]);
        if($package_detail['type'] == 'error'){
            
            $package_detail['autoClose'] = 3000;
            $this->dispatchBrowserEvent('showAlertMessage', $package_detail);
            return false;
        }

        $this->validate([
            'proposal_amount'       => ['required','numeric','gt:1', new OverflowRule(0,99999999)], 
            'special_comments'      => 'required', 
        ]);
        
        $proposal_milestones = array();
        
        if( $this->project->project_type == 'fixed' ){
            if( $this->is_milestone == 'yes' ){
                if( empty($this->available_milestones) ){
                    $this->dispatchBrowserEvent('showAlertMessage', ['title'=> __('general.error_title'),  'type'=> 'error', 'message'=> __('proposal.add_milestone') ]);
                    return;
                }else{

                    $this->validate([
                        'available_milestones.*.price'  => ['required','numeric','gt:0', new OverflowRule(0,99999999)],  
                        'available_milestones.*.title'  => 'required',  
                    ],[
                        'available_milestones.*.price.required'     => __('proposal.add_milestone_price'),
                        'available_milestones.*.title.required'     => __('proposal.add_milestone_title')
                    ]);

                    $milestone_total_price = 0;
                    foreach($this->available_milestones as $single){
                        $milestone_total_price = $milestone_total_price + $single['price'];
                        $proposal_milestones[] = array(
                            'proposal_id'   => $this->edit_id,
                            'title'         => sanitizeTextField( $single['title'] ),
                            'price'         => sanitizeTextField( $single['price'] ),
                            'description'   => sanitizeTextField( $single['description'], true),
                        );
                    }

                    if($milestone_total_price != $this->proposal_amount){
                        $this->dispatchBrowserEvent('showAlertMessage', ['title'=> __('general.error_title'),  'type'=> 'error', 'message'=> __('proposal.milestone_price_error') ]);
                        return; 
                    }
                }
            }
        }
        
        $commision_types = array(
            'free'                      => '0',
            'fixed'                     => '1',
            'percentage'                => '2',
            'commission_tier_fixed'     => '3',
            'commission_tier_per'       => '4',
        );
        $payout_type = '';

        if($this->project->project_payout_type == 'milestone' ){
            $payout_type = 'milestone';
        }elseif($this->project->project_payout_type == 'fixed' ){
            $payout_type = 'fixed';
        }elseif( $this->project->project_payout_type == 'hourly' ){
            $payout_type = 'hourly';
        } elseif($this->project->project_payout_type == 'both') {
            if($this->is_milestone == 'yes')
                $payout_type = 'milestone';
            else{
                $payout_type = 'fixed';
            }
        }

        $proposal_data = array(
            'author_id'             => $this->profile_id,
            'project_id'            => $this->project->id,
            'proposal_amount'       => sanitizeTextField($this->proposal_amount),
            'special_comments'      => sanitizeTextField($this->special_comments, true),
            'payout_type'           => $payout_type,
            'payment_mode'          => $this->project->project_payment_mode,
            'commission_type'       => $commision_types[$this->commission_type],
            'commission_amount'     => $this->admin_share,
            'resubmit'              => 0,
            'status'                => $status,
        );

        $proposal = Proposal::select('id')->updateOrCreate( ['id'=> $this->edit_id, 'author_id' => $this->profile_id], $proposal_data );
        
        
        if(isset($proposal->id)){

            ProposalMilestone::where('proposal_id', $proposal->id)->delete();

            if( $this->proposal_milestone_payout == 'yes' && !empty($proposal_milestones) ){
                
                foreach($proposal_milestones as $key => $milestone){
                    
                    $milestone['proposal_id'] = $proposal->id;
                   
                    ProposalMilestone::create($milestone);
                }
            }
        }
        
        // deduct credits from seller package
        if( $status !='draft' && !$this->resubmit_proposal && !empty($package_detail['id']) ){

            $setting            = getTPSetting(false, ['single_project_credits']);
            $required_credits   = !empty($setting['single_project_credits'])  ? $setting['single_project_credits'] : 0;
            $package            =  PackageSubscriber::where( ['id'=> $package_detail['id']] );
            $package_options = $package_detail['package_options'];
            $package_options['rem_quota']['credits'] = $package_options['rem_quota']['credits'] - $required_credits;
            $package->update(['package_options' => serialize($package_options)]);

        }

        // send email to admin
        if( $status == 'publish' ){
            $email_template = EmailTemplate::select('content')
            ->where(['type' => 'proposal_approve_request' , 'status' => 'active', 'role' => 'buyer'])
            ->latest()->first();
            
            if(!empty($email_template)){
                $projectTitle   = !empty( $this->project->project_title ) ? $this->project->project_title : '';
                $projectSlug    = !empty( $this->project->slug ) ? $this->project->slug : '';
                $proposalLink   = route('proposal-detail',['slug' => $projectSlug, 'id' => $proposal->id]);
                
                //Notify user info
                $userId = !empty($this->project->projectAuthor->user_id) ? $this->project->projectAuthor->user_id : '';
                $NotifyUser = User::whereId($userId)->latest()->first();

                $userName = !empty($this->project->projectAuthor) ? $this->project->projectAuthor->full_name : '';
                $userInfo = getUserInfo();
                $template_data              =  unserialize($email_template->content);
                $params                     = array();
                $params['template_type']    = 'proposal_approve_request';
                $params['email_params']     = array(
                    'user_name'             => $userName,
                    'seller_name'           => $userInfo['user_name'],
                    'project_title'         => $projectTitle,
                    'proposal_link'         => $proposalLink,
                    'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                    'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                    'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
                );
                if(!empty($NotifyUser)){
                    try {
                        Notification::send($NotifyUser, new EmailNotification($params));
                    } catch (\Exception $e) {
                        $this->dispatchBrowserEvent('showAlertMessage', [
                            'title'         => __('general.error_title'),
                            'type'          => 'error',
                            'message'       => $e->getMessage(),
                            'autoClose'     => 4000,
                            'redirectUrl'   => route('project-listing'),
                        ]);
                        return;
                    }
                }
            }
        }
        //end sent email
        
        $eventData = array();
        $eventData['title']         = __('general.success_title');
        $eventData['message']       =  $status == 'draft' ? __('proposal.proposal_draft_msg') : __('proposal.proposal_submit_msg');;
        $eventData['type']          = 'success';
        $eventData['redirectUrl']   = route('project-listing');
        $eventData['autoClose']     = 3000;
        
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }  
}
