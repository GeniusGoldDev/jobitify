<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    /**
     * Setting scope of the variables
     *
     * @access public
     
     * @var string $site_name
     * @var string $template_type
     * @var string $email_logo
     * @var string $sender_name
     * @var string $sender_email
     * @var string $copyright_text
     * @var string $sender_signature
     * @var array $email_content
     * @var array $email_params
     *
     */
    
    public $site_name;
    public $email_logo;
    public $sender_name;
    public $sender_email;
    public $copyright_text;
    public $sender_signature;
    public $template_type;
    public $email_params;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $params ){

        $this->template_type    = $params['template_type'];
        $this->email_params     = $params['email_params'];

        $email_logo                 = setting('_email.email_logo');
        $sender_name                = setting('_email.sender_name');
        $sender_email               = setting('_email.sender_email');
        $sender_signature           = setting('_email.sender_signature');
        $footer_text                = setting('_email.footer_text');
        $site_name                  = setting('_site.site_name');

        $email_logo                 = !empty( $email_logo[0]['path'] ) ? $email_logo[0]['path'] : '';
        $this->site_name            = !empty( $site_name )        ? $site_name : '';
        $this->email_logo           = !empty( $email_logo )       ? asset('storage/' .$email_logo) : '';
        $this->sender_name          = !empty( $sender_name )      ? $sender_name : '';
        $this->sender_email         = !empty( $sender_email )     ? $sender_email  : '';
        $this->sender_signature     = !empty( $sender_signature ) ? $sender_signature  : '';
        $this->copyright_text       = !empty( $footer_text )      ? $footer_text  : '';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable){

        $mail = (new MailMessage);
        $show_button    = false;
        $buttonURL      = '';
        $buttonText     = '';

        if( !empty($this->sender_email) && !empty($this->sender_name) ){
            $mail->from($this->sender_email, $this->sender_name);
        }

        if( !empty($this->email_params['email_subject']) ){
            $subject = $this->email_params['email_subject'];
            $subject = str_replace("{{site_name}}", $this->site_name, $subject);
            if($this->template_type == 'package_purchase'){
                $subject = str_replace("{{purchaser_name}}", $this->email_params['purchaser_name'], $subject);
            }

            $mail->subject($subject);
        }

        $greeting = '';
        if( !empty($this->email_params['email_greeting']) ){

            $greeting = str_replace("{{user_name}}", $this->email_params['user_name'], $this->email_params['email_greeting']);
            $mail->greeting($greeting);
        }

        switch( $this->template_type ){

            case 'user_created':
                $content     = $this->getUserCreatedContent($notifiable);
            break;
            case 'registration':
                $getContent     = $this->getRegistrationContent($notifiable);
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'reset_password':
                $getContent     = $this->getResetPasswordContent($notifiable);
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'accout_identity_verification':
                $content = $this->getIdentityVericationContent();
            break;
            case 'comment_on_dispute':
                $getContent     = $this->getDisputeCommentContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'order_refund_reply':
                $getContent     = $this->getDisputeCommentContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'seller_decline_dispute':
                $getContent     = $this->getDisputeCommentContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'seller_decline_dispute_order':
                $getContent     = $this->getDisputeCommentContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'seller_appr_order_dispute_req':
                $getContent     = $this->getDisputeCommentContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'seller_approved_dispute_req':
                $getContent     = $this->getDisputeCommentContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'seller_dispute_received':
                $getContent     = $this->getDisputeReceivedContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'admin_dispute_not_in_favour':
                $getContent     = $this->getDisputeNotInFavourContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'admin_order_dispute_not_in_favour':
                $getContent     = $this->getDisputeNotInFavourContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'proposal_approve_request':
                $getContent     = $this->getSubmitProposalContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'project_conversation':
                $getContent     = $this->projectConversationCont();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'proposal_request_declined':
                $content = $this->getDeclinedProposalContent();
            break;
            case 'package_purchase':
                $content = $this->getPackagePurchaseContent();
            break;
            case 'project_invite_request':
                $content = $this->getProjectInviteContent();
            break;
            case 'proposal_request_accepted':
                $getContent     = $this->getAcceptProposalContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'milestone_approve_request':
                $getContent     = $this->getMilestoneApproveContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'project_posted':
                $getContent     = $this->getPostedProjectContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'milestone_declined':
                $getContent     = $this->getMilestoneConter();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'milestone_accepted': 
                $getContent     = $this->getMilestoneConter();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'milestone_project_complete': 
                $getContent     = $this->getMilestoneConter();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'escrow_milestone':
                $getContent     = $this->getMilestoneConter();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'project_approved': 
                $getContent     = $this->getProjectApprovedContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'timecard_approval_request': 
                $getContent     = $this->getTimeCardContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'timecard_declined': 
                $getContent     = $this->getTimeCardContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            case 'timecard_accepted': 
                $getContent     = $this->getTimeCardContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;

            case 'project_complete_request': 
                $getContent     = $this->getProjectCompleteContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;

            case 'project_complete_req_declined': 
                $getContent     = $this->getProjectContractDeclined();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;

            case 'project_complete_request_accepted': 
                $getContent     = $this->getProjectContractAccepted();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;

            case 'admin_refund_dispute_to_winner':
                $content = $this->email_params['email_content'];
            break;

            case 'admin_refund_hourly_dispute_to_winner':
                $content = $this->email_params['email_content'];
            break;

            case 'admin_refund_order_dispute_to_winner':
                $content = $this->email_params['email_content'];
            break;

            case 'admin_received_dispute':
                $getContent     = $this->getDisputeAdminReceivedContent();
                $content        = $getContent['content'];
            break;

            case 'send_qeustion':
                $getContent     = $this->getSendQuestionContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;
            
            case 'post_gig_order':
                $content = $this->getGigOrderPostedContent();
            break;

            case 'seller_order_complete':
                $getContent     = $this->getGigOrderCompleteContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;

            case 'order_completed':
                $content = $this->getGigOrderCompletedContent();
            break;

            case 'order_activity':
                $getContent     = $this->getGigOrderActivityContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;

            case 'order_refund_request':
                $getContent     = $this->getGigOrderRefundContent();
                $content        = $getContent['content'];
                $show_button    = $getContent['showButton'];
                $buttonURL      = $getContent['buttonURL'];
                $buttonText     = $getContent['buttonText'];
            break;

            default:
                $content = $this->email_params['email_content'];
            break;    
        }
        
        return  $mail->view('emails.template', [
            'type'          => $this->template_type,
            'header'        => $this->getEmailHeader(),
            'greeting'      => $greeting,
            'content'       => $content,
            'show_button'   => $show_button,
            'button_url'    => $buttonURL,
            'button_text'   => $buttonText,
            'signature'     => $this->sender_signature,
            'footer'        => $this->getEmailFooter(),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function getEmailHeader(){

        return view('emails.email-header', [
           'site_name'      => $this->site_name, 
           'email_logo'     => $this->email_logo, 
        ])->render();
    }

    public function getEmailFooter(){

        return view('emails.email-footer', [
           'copyright_text'      => $this->copyright_text, 
        ])->render();
    }

    public function getRegistrationContent($notifiable){
       
        $content            = $this->email_params['email_content'];
        $showLoginButton    = false;
        $verifyUrl          = '';
        if( !empty($this->email_params['email_content']) ){
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

            $content    = str_replace("{{site_name}}",      $this->site_name, $this->email_params['email_content']);
            $content    = str_replace("{{user_name}}",      $this->email_params['user_name'], $content);
            $content    = str_replace("{{user_email}}",     $this->email_params['user_email'], $content);
            $content    = str_replace("{{verification_link}}", "<a href='".$verifyUrl."' target='_blank' >".__('email_template.verfiy_email')."</a>", $content);

            if(str_contains($content, '{{verification_link}}')){
                $content    = str_replace("{{verification_link}}", '' , $content);
                $showLoginButton = true;
            }
        }

        return array (
            'content'       => $content,
            'buttonURL'     => $verifyUrl,
            'showButton'    => $showLoginButton,
            'buttonText'    => __('general.verfiy_email'),
        );
    }

    public function getIdentityVericationContent(){

        $content = $this->email_params['email_content'];
        if( !empty($this->email_params['email_content']) ){
            $loginUrl   = route('login');
            $content    = str_replace("{{user_name}}", '<b>'.$this->email_params['user_name'].'</b>', $content);
            $content    = str_replace("{{login_url}}", "<a href='".$loginUrl."' target='_blank' >".__('email_template.login_url')."</a>", $content);
        }
        return $content;
    }

    public function getDeclinedProposalContent(){

        $content = $this->email_params['email_content'];
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{decline_reason}}",  $this->email_params['decline_reason'], $content);
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
        }
        return $content;
    }

    public function getPackagePurchaseContent(){

        $content = $this->email_params['email_content'];
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{package_name}}", '<b>'.$this->email_params['package_name'].'</b>', $content);
            $content    = str_replace("{{purchaser_name}}",  $this->email_params['purchaser_name'], $content);
            $content    = str_replace("{{current_date}}",  $this->email_params['current_date'], $content);
        }
        return $content;
    }

    public function getProjectInviteContent(){

        $content = $this->email_params['email_content'];
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
        }
        return $content;
    }

    public function getSubmitProposalContent(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{seller_name}}", '<b>'.$this->email_params['seller_name'].'</b>', $content);
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
          
            if(str_contains($content, '{{proposal_link}}')){
                $content    = str_replace("{{proposal_link}}", '' , $content);
                $showLoginButton = true;
            }
        }
        
        return array (
            'content'       => $content,
            'buttonURL'     => $this->email_params['proposal_link'],
            'showButton'    => $showLoginButton,
            'buttonText'    => __('general.view_detail'),
        );
    }

    public function projectConversationCont(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
            $content    = str_replace("{{sender_name}}", '<b>'.$this->email_params['sender_name'].'</b>', $content);
            
            if(str_contains($content, '{{login_url}}')){
                $content    = str_replace("{{login_url}}", '' , $content);
                $showLoginButton = true;
            }
        }
        
        return array (
            'content'       => $content,
            'buttonURL'     => route('login'),
            'showButton'    => $showLoginButton,
            'buttonText'    =>  __('email_template.ridirect_login'),
        );
    }

    public function getProjectCompleteContent(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{seller_name}}", '<b>'.$this->email_params['seller_name'].'</b>', $content);
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
          
            if(str_contains($content, '{{project_activity_link}}')){
                $content    = str_replace("{{project_activity_link}}", '' , $content);
                $showLoginButton = true;
            }
        }
        
        return array (
            'content'       => $content,
            'buttonURL'     => $this->email_params['project_activity_link'],
            'showButton'    => $showLoginButton,
            'buttonText'    => __('general.view_detail'),
        );
    }

    public function getProjectContractAccepted(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
          
            if(str_contains($content, '{{project_activity_link}}')){
                $content    = str_replace("{{project_activity_link}}", '' , $content);
                $showLoginButton = true;
            }
        }
        
        return array (
            'content'       => $content,
            'buttonURL'     => $this->email_params['project_activity_link'],
            'showButton'    => $showLoginButton,
            'buttonText'    => __('general.view_detail'),
        );
    }

    public function getProjectContractDeclined(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
            $content    = str_replace("{{declined_reason}}", $this->email_params['declined_reason'], $content);
          
            if(str_contains($content, '{{project_activity_link}}')){
                $content    = str_replace("{{project_activity_link}}", '' , $content);
                $showLoginButton = true;
            }
        }
        
        return array (
            'content'       => $content,
            'buttonURL'     => $this->email_params['project_activity_link'],
            'showButton'    => $showLoginButton,
            'buttonText'    => __('general.view_detail'),
        );
    }

    public function getUserCreatedContent(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{site_name}}", "<a href='".route('login')."' target='_blank' ><b>".$this->email_params['site_name']."</b></a>", $content);
            $content    = str_replace("{{user_name}}", '<b>'.$this->email_params['user_name'].'</b>', $content);
            $content    = str_replace("{{user_email}}", '<b>'.$this->email_params['user_email'].'</b>', $content);
            $content    = str_replace("{{password}}",  $this->email_params['password'], $content);
            $content    = str_replace("{{admin_name}}", '<b>'.$this->email_params['admin_name'].'</b>', $content);
        }
        return $content;
        
    }

    public function getDisputeNotInFavourContent(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){

            if(str_contains($content, '{{dispute_link}}')){
                $content    = str_replace("{{dispute_link}}", '' , $content);
                $showLoginButton = true;
            }
        }
        
        return array (
            'content' => $content,
            'buttonURL' => $this->email_params['dispute_link'],
            'showButton' => $showLoginButton,
            'buttonText' => __('general.view_detail'),
        );
    }

    public function getDisputeReceivedContent(){
        
        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{buyer_name}}", '<b>'.$this->email_params['buyer_name'].'</b>', $content);
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
            $content    = str_replace("{{buyer_comments}}",  $this->email_params['buyer_comments'], $content);
            
            if(str_contains($content, '{{login_url}}')){
                $content    = str_replace("{{login_url}}", '' , $content);
                $showLoginButton = true;
            }
        }
        
        return array (
            'content' => $content,
            'buttonURL' => route('login'),
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getMilestoneConter(){
       
        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
            $content    = str_replace("{{milestone_title}}", '<b>'.$this->email_params['milestone_title'].'</b>', $content);
            
            if(str_contains($content, '{{project_activity_link}}')){
                $content    = str_replace("{{project_activity_link}}", '' , $content);
                $showLoginButton = true;
            }
        }

        return array (
            'content' => $content,
            'buttonURL' => $this->email_params['project_activity_link'],
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getTimeCardContent(){
       
        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
            $content    = str_replace("{{timecard_title}}", '<b>'.$this->email_params['timecard_title'].'</b>', $content);

            if(!empty($this->email_params['seller_name'])){
                $content    = str_replace("{{seller_name}}", '<b>'.$this->email_params['seller_name'].'</b>', $content);
            }

            if(!empty($this->email_params['decline_reason'])){
                $content    = str_replace("{{decline_reason}}", $this->email_params['decline_reason'], $content);
            }
            
            if(str_contains($content, '{{project_activity_link}}')){
                $content    = str_replace("{{project_activity_link}}", '' , $content);
                $showLoginButton = true;
            }
        }

        return array (
            'content' => $content,
            'buttonURL' => $this->email_params['project_activity_link'],
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getProjectApprovedContent(){
       
        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
            
            if(str_contains($content, '{{project_link}}')){
                $content    = str_replace("{{project_link}}", '' , $content);
                $showLoginButton = true;
            }
        }

        return array (
            'content' => $content,
            'buttonURL' => $this->email_params['project_link'],
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getMilestoneApproveContent(){
       
        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
            $content    = str_replace("{{milestone_title}}", '<b>'.$this->email_params['milestone_title'].'</b>', $content);
            $content    = str_replace("{{seller_name}}", '<b>'.$this->email_params['seller_name'].'</b>', $content);
            
            if(str_contains($content, '{{project_activity_link}}')){
                $content    = str_replace("{{project_activity_link}}", '' , $content);
                $showLoginButton = true;
            }
        }

        return array (
            'content' => $content,
            'buttonURL' => $this->email_params['project_activity_link'],
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getPostedProjectContent(){
       
        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{user_name}}",  $this->email_params['user_name'], $content);
            
            if(str_contains($content, '{{project_link}}')){
                $content    = str_replace("{{project_link}}", '' , $content);
                $showLoginButton = true;
            }
        }

        return array (
            'content' => $content,
            'buttonURL' => $this->email_params['project_link'],
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getAcceptProposalContent(){
       
        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
            
            if(str_contains($content, '{{project_activity_link}}')){
                $content    = str_replace("{{project_activity_link}}", '' , $content);
                $showLoginButton = true;
            }
        }

        return array (
            'content' => $content,
            'buttonURL' => $this->email_params['project_activity_link'],
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getDisputeAdminReceivedContent(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
            $content    = str_replace("{{type}}", $this->email_params['type'], $content);
            
            if(str_contains($content, '{{login_url}}')){
                $content    = str_replace("{{login_url}}", '' , $content);
                $showLoginButton = true;
            }
        }
        

        return array (
            'content' => $content,
            'buttonURL' => route('login'),
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getSendQuestionContent(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            
            $content    = str_replace("{{user_name}}", '<b>'.$this->email_params['user_name'].'</b>', $content);
            $content    = str_replace("{{user_email}}", '<b>'.$this->email_params['user_email'].'</b>', $content);
            $content    = str_replace("{{question_title}}", $this->email_params['question_title'], $content);
            $content    = str_replace("{{description}}", $this->email_params['description'], $content);
            
            if(str_contains($content, '{{login_url}}')){
                $content    = str_replace("{{login_url}}", '' , $content);
                $showLoginButton = true;
            }
        }
        

        return array (
            'content' => $content,
            'buttonURL' => route('login'),
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getGigOrderCompleteContent(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            
            $content    = str_replace("{{seller_name}}", '<b>'.$this->email_params['seller_name'].'</b>', $content);
            $content    = str_replace("{{order_id}}", '<b>'.number_format($this->email_params['order_id']).'</b>', $content);
            $content    = str_replace("{{activity_link}}", "<a href='".$this->email_params['activity_link']."' target='_blank' >".$this->email_params['activity_link']."</a>", $content);

            
            if(str_contains($content, '{{login_url}}')){
                $content    = str_replace("{{login_url}}", '' , $content);
                $showLoginButton = true;
            }
        }
        

        return array (
            'content' => $content,
            'buttonURL' => route('login'),
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getGigOrderActivityContent(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            
            $content    = str_replace("{{sender_name}}", '<b>'.$this->email_params['sender_name'].'</b>', $content);
            $content    = str_replace("{{gig_title}}", '<b>'.$this->email_params['gig_title'].'</b>', $content);
            $content    = str_replace("{{order_id}}", '<b>'.(number_format($this->email_params['order_id'])).'</b>', $content);
            $content    = str_replace("{{sender_comments}}", $this->email_params['sender_comments'], $content);
           
            if(str_contains($content, '{{login_url}}')){
                $content    = str_replace("{{login_url}}", '' , $content);
                $showLoginButton = true;
            }
        }
        
        return array (
            'content' => $content,
            'buttonURL' => route('login'),
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getGigOrderRefundContent(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            
            $content    = str_replace("{{buyer_name}}", '<b>'.$this->email_params['buyer_name'].'</b>', $content);
            $content    = str_replace("{{order_id}}", '<b>'.number_format($this->email_params['order_id']).'</b>', $content);
            $content    = str_replace("{{buyer_comments}}", $this->email_params['buyer_comments'], $content);
           
            if(str_contains($content, '{{login_url}}')){
                $content    = str_replace("{{login_url}}", '' , $content);
                $showLoginButton = true;
            }
        }
        
        return array (
            'content' => $content,
            'buttonURL' => route('login'),
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getDisputeCommentContent(){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($content) ){

            $content    = str_replace("{{sender_name}}", '<b>'.$this->email_params['sender_name'].'</b>', $content);

            if(!empty($this->email_params['project_title'])){
                $content    = str_replace("{{project_title}}", '<b>'.$this->email_params['project_title'].'</b>', $content);
            }
            if(!empty($this->email_params['gig_title'])){
                $content    = str_replace("{{gig_title}}", '<b>'.$this->email_params['gig_title'].'</b>', $content);
            }

            if(!empty($this->email_params['order_id'])){
                $content    = str_replace("{{order_id}}",  number_format( $this->email_params['order_id'] ), $content);
            }

            if(!empty($this->email_params['sender_comments'])){
                $content    = str_replace("{{sender_comments}}",  $this->email_params['sender_comments'], $content);
            }
            
            if(str_contains($content, '{{login_url}}')){
                $content    = str_replace("{{login_url}}", '' , $content);
                $showLoginButton = true;
            }
        }
        
        return array (
            'content' => $content,
            'buttonURL' => route('login'),
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.ridirect_login'),
        );
    }

    public function getResetPasswordContent($notifiable){

        $content = $this->email_params['email_content'];
        $showLoginButton = false;
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{account_email}}",  $this->email_params['account_email'], $content);
            
            if(str_contains($content, '{{reset_link}}')){
                $content    = str_replace("{{reset_link}}", '' , $content);
                $showLoginButton = true;
            }
        }

        $resetUrl = url(route('password.reset', [
            'token' => $this->email_params['token'],
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return array (
            'content' => $content,
            'buttonURL' => $resetUrl,
            'showButton' => $showLoginButton,
            'buttonText' => __('email_template.reset_password_txt'),
        );
    }

    public function getGigOrderCompletedContent(){
        
        $content = $this->email_params['email_content'];
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{buyer_name}}", "<b>".$this->email_params['buyer_name']."</b>", $content);
            $content    = str_replace("{{order_id}}", "<b>".number_format($this->email_params['order_id'])."</b>", $content);
            $content    = str_replace("{{buyer_comments}}", $this->email_params['buyer_comments'], $content);
            $content    = str_replace("{{buyer_rating}}", $this->email_params['buyer_rating'].'/5', $content);
        }
        return $content;
    }

    public function getGigOrderPostedContent(){
        $content = $this->email_params['email_content'];
        if( !empty($this->email_params['email_content']) ){
            $content    = str_replace("{{gig_title}}", "<b>".$this->email_params['gig_title']."</b>", $content);
        }
        return $content;
    }
}
