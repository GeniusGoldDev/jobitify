<?php

namespace App\Http\Livewire\PageBuilder;

use Livewire\Component;
use App\Models\SitePage;
use Livewire\WithFileUploads;
use App\Models\Setting\SiteSetting;

class HeaderBlock extends Component
{
    use WithFileUploads;

    public $heading         = null;
    public $form_title      = null;
    public $form_content    = null;
    public $talent_btn_txt  = null;
    public $work_btn_txt    = null;
    public $counter_option  = [];
    public $after_btn_text  = null;
    public $style_css       = '';
    public $site_view       = false;
    public $custom_class    = '';
    public $header_background   = '';
    public $site_dark_logo      = '';

    public $page_id = null;
    public $block_key = null;

    public function render(){
        
        addJsVars([ 
            'isRTL' => setting('_site.rtl')
        ]);
        return view('livewire.pagebuilder.header-block');
    }

    protected function getListeners(){
        return [
            'update-'.$this->block_key                  => "updateBlockSetting",
            'update-custom-class-'.$this->block_key     => "updateCustomClass",
        ];
    }

    public function mount($page_id, $block_key, $settings, $style_css, $site_view){
        
        $this->page_id      = $page_id;
        $this->block_key    = $block_key;

        if( !empty($style_css) ){
            $this->style_css    = !empty($style_css['style']) ? $style_css['style'] : '';
            $this->custom_class = !empty($style_css['custom_class']) ? $style_css['custom_class'] : '';
        }

        if( !empty($site_view) ){
            $this->site_view = true;
        }

        if( !empty( $settings) ){
          
            $this->heading          = !empty($settings['heading']) ? $settings['heading'] : '';
            $this->form_title       = !empty($settings['form_title']) ? $settings['form_title'] : '';
            $this->form_content     = !empty($settings['form_content']) ? $settings['form_content'] : '';
            $this->talent_btn_txt   = !empty($settings['talent_btn_txt']) ? $settings['talent_btn_txt'] : '';
            $this->work_btn_txt     = !empty($settings['work_btn_txt']) ? $settings['work_btn_txt'] : '';
            $this->counter_option   = !empty($settings['counter_option']) ? $settings['counter_option'] : array();
            $this->after_btn_text   = !empty($settings['after_btn_text']) ? $settings['after_btn_text'] : '';
            $this->header_background = !empty($settings['header_background']) ? $settings['header_background'] : '';
        }else{
            
            $getDefaultValues = SiteSetting::where('setting_type', 'header-block')->get();
           
            if(!$getDefaultValues->isEmpty()){
                foreach($getDefaultValues as $value){

                    if($value->meta_key == 'heading'){
                        $this->heading          = !empty($value->meta_value) ? json_decode($value->meta_value) : '';
                    } elseif(in_array($value->meta_key, ['work_btn_txt','form_title','form_content','talent_btn_txt','work_btn_txt','after_btn_text','header_background'])){
                        $this->{$value->meta_key} = !empty($value->meta_value) ? $value->meta_value : '';
                        
                    } elseif($value->meta_key == 'counter_option'){
                        $this->counter_option     = !empty($value->meta_value) ? unserialize($value->meta_value) : [];
                    }
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
                       $newSetting[$propertyKey]   = sanitizeTextField($data, true);
                    }
                    $this->{$propertyKey}       = $newSetting[$propertyKey];
                }
            }

            $page_settings[$key]['settings']    = $newSetting;
            $settings = json_encode($page_settings);
            $page->update(['settings' => $settings ]);
        }
    }
}
