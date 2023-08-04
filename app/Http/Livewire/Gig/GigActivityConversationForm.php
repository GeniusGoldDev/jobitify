<?php

namespace App\Http\Livewire\Gig;


use App\Models\User;
use Livewire\Component;
use App\Models\EmailTemplate;
use Livewire\WithFileUploads;
use App\Models\Gig\GigOrderActivity;
use App\Notifications\EmailNotification;

class GigActivityConversationForm extends Component
{
    use   WithFileUploads; 
    public $profile_id;
    public $gig_id;
    public $buyer_id;
    public $seller_id;
    public $order_id;
    public $type = 'revision';
    public $activity_description= '';
    public $activity_files      = [];
    public $existingFiles       = [];
    public $allowFileSize       = '';
    public $allowFileExt        = '';
    public $user_role           = '';
    public $author_info         = [];

    public function mount( $gig_id, $order_id, $gig_author_id, $order_author_id, $author_info ){
        
        $this->author_info      = $author_info;
        $user                   = getUserRole();
        $this->profile_id       = $user['profileId'];
        $this->user_role        = $user['roleName'];

        if( $order_author_id == $this->profile_id){
            $this->receiver_id      = $gig_author_id;
        }else{
            $this->receiver_id  = $order_author_id;
        }

        $this->order_id         = $order_id;
        $this->gig_id           = $gig_id;
        $file_ext               = setting('_general.file_ext');
        $file_size              = setting('_general.file_size');
        $this->allowFileSize    = !empty( $file_size ) ? $file_size : '3';
        $this->allowFileExt     = !empty( $file_ext ) ?  $file_ext  : [];
        
    }

    public function render(){
        
        return view('livewire.gig.gig-activity-conversation-form');
    }
    
    public function updatedActivityFiles(){

        $this->validate(
            [
                'activity_files.*' => 'mimes:'.$this->allowFileExt.'|max:'.$this->allowFileSize*1024,
            ],[
                'max'   => __('general.max_file_size_err',  ['file_size'    => $this->allowFileSize.'MB']),
                'mimes' => __('general.invalid_file_type',  ['file_types'   =>  $this->allowFileExt]),
            ]
        );
        
        foreach($this->activity_files as $single){
            $filename = pathinfo($single->hashName(), PATHINFO_FILENAME);
            $this->existingFiles[$filename] = $single;
        }
    }
    public function removeFile( $key ){

        if(!empty($this->existingFiles[$key])){
            unset($this->existingFiles[$key]);
        }
    }

    public function updateActivity(){
        
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
            'activity_description'  => 'required',
            
        ]);
        $attachments = array();
        if( !empty($this->existingFiles) ){
            foreach($this->existingFiles as $key => $single){

                $file = $single;
                $file_path      = $file->store('public/gig-activity/'.$this->gig_id.'/'.$this->order_id);
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

        GigOrderActivity::create([
            'sender_id'         =>  $this->profile_id,
            'receiver_id'       =>  $this->receiver_id,
            'gig_id'            =>  $this->gig_id,
            'order_id'          =>  $this->order_id,
            'type'              =>  $this->type,
            'attachments'       => !empty($attachments) ? serialize($attachments) : null,
            'description'       => sanitizeTextField($this->activity_description, true)
        ]);

        $this->emit('updateConversation');
       

        $order_author_name    = !empty($this->author_info['order_author']) ? $this->author_info['order_author'] : '';
        $gig_author_name      = !empty($this->author_info['gig_author'] ) ? $this->author_info['gig_author'] : '';
        $gig_slug             = !empty($this->author_info['gig_slug'] ) ? $this->author_info['gig_slug'] : '';
        $order_user_id        = !empty($this->author_info['order_user_id'] ) ? $this->author_info['order_user_id'] : '';
        $gig_title            = !empty($this->author_info['gig_title'] ) ? $this->author_info['gig_title'] : '';
        $gig_user_id          = !empty($this->author_info['gig_user_id'] ) ? $this->author_info['gig_user_id'] : '';
        $email_params         = [];

        $email_type     = $this->type == 'final' ? 'seller_order_complete' : 'order_activity';
        $email_role     = 'buyer';
        $notifyUserId   = $order_user_id;

        if( $this->type == 'revision' ){
            $email_role     = $this->user_role == 'buyer' ? 'seller' : 'buyer';
            $notifyUserId   = $this->user_role == 'buyer' ? $gig_user_id : $order_user_id;
        }

        $email_template = EmailTemplate::select('content')
            ->where(['type' => $email_type , 'status' => 'active', 'role' => $email_role])
            ->latest()->first();

        if( !empty($email_template) ){
            $template_data              =  unserialize($email_template->content);
            $params                     = array();
            $params['template_type']    = $email_type;
            
            if( $this->type == 'final' ){
                $email_params = [ 
                    'user_name'             => $order_author_name,
                    'seller_name'           => $gig_author_name,
                    'order_id'              => $this->order_id,
                    'activity_link'         => route('gig-activity',['slug' => $gig_slug, 'order_id' => $this->order_id]),
                ];
            }else{
                $email_params = [
                    'user_name'             => $this->user_role == 'buyer' ? $gig_author_name : $order_author_name,
                    'sender_name'           => $this->user_role == 'buyer' ? $order_author_name : $gig_author_name,
                    'gig_title'             => $gig_title,
                    'order_id'              => $this->order_id,
                    'sender_comments'       => sanitizeTextField($this->activity_description, true),
                ];
            }
            

            $params['email_params']     = array_merge($email_params, array(
                'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
            ));

            try {
                User::find($notifyUserId)->notify(new EmailNotification($params));
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => $e->getMessage(),
                    'autoClose' => 10000,
                ]);
            }
            
        }

        $this->existingFiles = [];
        $this->activity_description = '';
        $this->type = 'revision';
    }
}
