<?php

namespace App\Http\Livewire\PageBuilder;

use App\Models\User;
use Livewire\Component;
use App\Models\SitePage;
use App\Models\EmailTemplate;
use App\Models\Setting\SiteSetting;
use App\Notifications\EmailNotification;

class SendQuestionBlock extends Component
{
    public $sub_title, $title, $description, $submit_btn_txt;
    public $full_name, $email, $question, $question_desc, $accept_terms_cond;

    public $page_id         = null;
    public $block_key       = null;
    public $site_view       = false;
    public $style_css       = '';
    public $custom_class    = '';

    public function render()
    {
        return view('livewire.pagebuilder.send-question-block');
    }

    protected function getListeners()
    {
        return [
            'update-'.$this->block_key                  => "updateBlockSetting",
            'update-custom-class-'.$this->block_key     => "updateCustomClass",
        ];
    }

    public function mount($page_id, $block_key, $settings, $style_css, $site_view)
    {
        $this->page_id = $page_id;
        $this->block_key = $block_key;

        if( !empty($style_css) ){
            $this->style_css    = !empty($style_css['style']) ? $style_css['style'] : '';
            $this->custom_class = !empty($style_css['custom_class']) ? $style_css['custom_class'] : '';
        }

        if( !empty($site_view) ){
            $this->site_view = true;
        }

        if( !empty( $settings) ){
          
            $this->sub_title            = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
            $this->title                = !empty($settings['title']) ? $settings['title'] : '';
            $this->description          = !empty($settings['description']) ? $settings['description'] : '';
            $this->submit_btn_txt       = !empty($settings['submit_btn_txt']) ? $settings['submit_btn_txt'] : '';
        }else{
            $getDefaultValues = SiteSetting::where('setting_type', 'send-question-block')->get();
           
            if(!$getDefaultValues->isEmpty()){
                foreach($getDefaultValues as $value){
                   $this->{$value->meta_key} = !empty($value->meta_value) ? $value->meta_value : '';
                }
            }
        }
    }

    public function updateCustomClass($data){
        $this->custom_class = !empty($data['custom_class']) ? $data['custom_class'] : '';
    }
    
    public function updateBlockSetting( $data ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $page               = SitePage::select('id','settings')->find( $this->page_id );
        $page_settings      = !empty( $page->settings ) ? json_decode($page->settings, true) : [];
        $block_key          = explode('__', $this->block_key);
        $id                 = $block_key[0] ;
        $key                = isset($block_key[1]) ? $block_key[1] : '';
        
        if( !empty($page_settings[$key]) && $page_settings[$key]['block_id'] == $id ){
            $newSetting = $page_settings[$key]['settings'];
            parse_str($data, $formData);
          
            foreach($formData as $propertyKey => $data){
                if(isset($this->{$propertyKey})){
                    if( is_array($data) ){
                        $result = SanitizeArray($data);
                        $newSetting[$propertyKey] = $result;
                    }else{
                       $newSetting[$propertyKey]  = sanitizeTextField($data, true);
                    }
                    $this->{$propertyKey}       = $newSetting[$propertyKey];
                } 
            }

            $page_settings[$key]['settings']    = $newSetting;
            $settings = json_encode($page_settings);
            $page->update(['settings' => $settings ]);
        }
    }

    public function sendQuestiontest(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $this->full_name        = sanitizeTextField( $this->full_name );
        $this->email            = sanitizeTextField( $this->email );
        $this->question         = sanitizeTextField( $this->question );
        $this->question_desc    = sanitizeTextField( $this->question_desc);

        $this->validate([
            'full_name'         => 'required', 
            'email'             => 'required|email', 
            'question'          => 'required', 
            'question_desc'     => 'required', 
            'accept_terms_cond' => 'required',
        ],[
            'required'  => __('general.required_field'),
            'email'  => __('general.invalid_email'),
        ]);

        $email_template = EmailTemplate::select('content')
        ->where(['type' => 'send_qeustion' , 'status' => 'active', 'role' => 'admin'])
        ->latest()->first();

        if(!empty($email_template)){
            $template_data              =  unserialize($email_template->content);
            $params                     = array();
            $params['template_type']    = 'send_qeustion';
            $params['email_params']     = array(
                'user_name'             => sanitizeTextField( $this->full_name ),
                'user_email'            => sanitizeTextField( $this->email ),
                'question_title'        => sanitizeTextField( $this->question ),
                'description'           => sanitizeTextField( $this->question_desc, true ),
                'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
            );
 
            //admin info
            $emailReceiver = User::whereHas(
                'roles', function($q){
                    $q->where('name', 'admin');
                }
            )->latest()->first();
            
            try {
                $emailReceiver->notify(new EmailNotification($params));
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => $e->getMessage(),
                    'autoClose' => 10000,
                ]);
                return;
            }

            $this->dispatchBrowserEvent('submitquestion-modal', ['modal' => 'hide']);

            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.success_message');
            $eventData['type']      = 'success';
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }
    }
}
