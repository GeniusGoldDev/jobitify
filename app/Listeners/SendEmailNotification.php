<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NotifyUser;
use App\Models\EmailTemplate;
use App\Models\Proposal\Proposal;
use App\Notifications\EmailNotification;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Package\PackageSubscriber;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendEmailNotification
{
    
    
    /**
     * Handle the event.
     *
     * @param  \App\Events\NotifyUser  $event
     * @return void
     */
    public function handle(NotifyUser $event)
    {
        
        $data = $event->data;

        if( $data['email_type'] == 'proposal_request_accepted'){
            $this->proposalRequestAccepted($data);
        }elseif($data['email_type'] == 'package_purchase'){
            $this->packagePurchased($data);
        }elseif($data['email_type'] == 'post_gig_order'){
            $this->gigOrderPosted($data);
        }elseif($data['email_type'] == 'escrow_milestone'){
            $this->escrowMilesteone($data);
        }elseif($data['email_type'] == 'timecard_accepted'){
            $this->acceptTimeCard($data);
        }
    }

    public function gigOrderPosted($data ){

        $email_templates = EmailTemplate::select('content','role')
        ->where(['type' => 'post_gig_order' , 'status' => 'active'])
        ->whereIn('role', ['seller','buyer'])
        ->get();
        if(!$email_templates->isEmpty()){
            foreach($email_templates as $template){
                $template_data              = unserialize($template->content);
                $params                     = array();
                $params['template_type']    = 'post_gig_order';
                $params['email_params']     = array(
                    'user_name'             => $template->role == 'buyer' ? $data['order_author'] : $data['gig_author'],
                    'gig_title'             => $data['gig_title'],
                    'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                    'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                    'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
                );
                $notifyUserId = $template->role == 'buyer' ? $data['buyer_id'] : $data['seller_id'];
                
                try {
                    User::find($notifyUserId)->notify(new EmailNotification($params));
                } catch (\Exception $e) {
                    $error_msg = $e->getMessage();
                }
            }
        }
    }

    public function proposalRequestAccepted($data ){

        $email_template = EmailTemplate::select('content')
        ->where(['type' => 'proposal_request_accepted' , 'status' => 'active', 'role' => 'seller'])
        ->latest()->first();
        
        if(!empty($email_template)){
            $template_data              =  unserialize($email_template->content);
            $params                     = array();
            $params['template_type']    = 'proposal_request_accepted';
            $params['email_params']     = array(
                'user_name'             => $data['user_name'],
                'project_title'         => $data['project_title'],
                'project_activity_link' => $data['project_activity_link'],
                'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
            );

            try {
                User::find($data['user_id'])->notify(new EmailNotification($params));
            } catch (\Exception $e) {
                $error_msg = $e->getMessage();
            }
            
        }
    }

    public function packagePurchased($data){

        $packageInfo = PackageSubscriber::whereId($data['pckg_subscriber_id'])
                ->with([
                    'packageSubscriberInfo:id,user_id,role_id,first_name,last_name',
                    'package:id,title'
                ])->first();

        if( !empty($packageInfo) ){
            
            $role_id    = $packageInfo->packageSubscriberInfo->role_id;
            $user_role  = getRoleById($role_id);
            $user_id    = $packageInfo->packageSubscriberInfo->user_id;

            $email_template = EmailTemplate::select('content', 'role')
            ->where(['type' => 'package_purchase' , 'status' => 'active'])
            ->whereIn('role', [$user_role,'admin'])
            ->get();
            if(!$email_template->isEmpty()){
                foreach($email_template as $template){
                    $userName       = $packageInfo->packageSubscriberInfo->full_name;
                    $package_title  = $packageInfo->package->title;
                    if(!empty($template)){
                        $template_data              =  unserialize($template->content);
                        $params                     = array();
                        $params['template_type']    = 'package_purchase';
                        $params['email_params']     = array(
                            'current_date'          => date('F j, Y'),
                            'user_name'             => $userName,
                            'purchaser_name'        => $userName,
                            'package_name'          => $package_title,
                            'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                            'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                            'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
                        );
                        $notifyUser = new User;
                        if($template->role == 'admin'){
                            $notifyUser = $notifyUser->whereHas(
                                'roles', function($q){
                                    $q->where('name', 'admin');
                                }
                            )->latest()->first();
                        }else {
                            $notifyUser = $notifyUser->find($user_id);
                        }

                        try {
                            $notifyUser->notify(new EmailNotification($params));
                        } catch (\Exception $e) {
                            $error_msg = $e->getMessage();
                        }
                    }
                }
            }
        }
    }

    public function escrowMilesteone($data){

        $email_template = EmailTemplate::select('content')
        ->where(['type' => 'escrow_milestone' , 'status' => 'active', 'role' => 'seller'])
        ->latest()->first();
        $sellerInfo = Proposal::with([
            'proposalAuthor:id,user_id,first_name,last_name', 
            'proposalAuthor.user',
            'project:id,project_title,slug'])->select('id','author_id','project_id')->find($data['proposal_id']);

        if(!empty($email_template)){
            $template_data              =  unserialize($email_template->content);
            $params                     = array();
            $params['template_type']    = 'escrow_milestone';
            $params['email_params']     = array(
                'user_name'             => $sellerInfo->proposalAuthor->full_name,
                'milestone_title'       => $data['milestone_title'],
                'project_title'         => $sellerInfo->project->project_title,
                'project_activity_link' => route('project-activity',[ 'slug' => $sellerInfo->project->slug, 'id' => $data['proposal_id']]),
                'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',
                'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',
                'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',
            );
            
            try {
                $sellerInfo->proposalAuthor->user->notify(new EmailNotification($params));
            } catch (\Exception $e) {
                $error_msg = $e->getMessage();
            }
        }
    }

    public function acceptTimeCard($data){
        
        $proposal = Proposal::with([
            'proposalAuthor:id,user_id,first_name,last_name', 
            'proposalAuthor.user',
            'project:id,project_title,slug'])->select('id','author_id','project_id')->find($data['proposal_id']);
        if(!empty($proposal)){
            $projectSlug    = $proposal->project->slug;
            $activitLink    = route('project-activity',['slug' => $projectSlug, 'id' => $data['proposal_id'] ]);
            
            $email_template = EmailTemplate::select('content')->where(['type' => 'timecard_accepted' , 'status' => 'active', 'role' => 'seller'])->latest()->first();
                
            if(!empty($email_template)){
                $template_data              = unserialize($email_template->content);
                $params                     = array();
                $params['template_type']    = 'timecard_accepted';
                $params['email_params']     = array(
                    'user_name'             => $proposal->proposalAuthor->full_name,
                    'timecard_title'        => $data['timecard_title'],
                    'project_title'         => $proposal->project->project_title,
                    'project_activity_link' => $activitLink,
                    'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                    'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                    'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
                );

                try {
                    $proposal->proposalAuthor->user->notify(new EmailNotification($params));
                } catch (\Exception $e) {
                    $error_msg = $e->getMessage();
                }

            }
        }
    }
}
