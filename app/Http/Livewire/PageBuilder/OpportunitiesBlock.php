<?php

namespace App\Http\Livewire\PageBuilder;

use Livewire\Component;
use App\Models\SitePage;
use App\Models\Setting\SiteSetting;

class OpportunitiesBlock extends Component
{
    public $display_image   = null;
    public $title           = null;
    public $tagline_title   = null;
    public $description     = null;
    public $join_us_btn_txt = null;
    public $points          = [];
    public $custom_class    = '';
    

    public $userRole        = null;

    public $page_id         = null;
    public $block_key       = null;
    public $site_view       = false;
    public $style_css       = '';

    public function render()
    {
        return view('livewire.pagebuilder.opportunities-block');
    }

    protected function getListeners(){

        return [
            'update-'.$this->block_key                  => "updateBlockSetting",
            'update-custom-class-'.$this->block_key     => "updateCustomClass",
        ];
    }

    public function mount($page_id, $block_key, $settings, $style_css, $site_view){

        $this->page_id = $page_id;
        $this->block_key = $block_key;

        if( !empty($style_css) ){
            $this->style_css    = !empty($style_css['style']) ? $style_css['style'] : '';
            $this->custom_class = !empty($style_css['custom_class']) ? $style_css['custom_class'] : '';
        }

        if( !empty($site_view) ){
            $this->site_view = true;
        }
        $user = getUserRole();
        $this->userRole     = !empty($user['roleName']) ? $user['roleName'] : '';


        if( !empty( $settings) ){
          
            $this->display_image    = !empty($settings['display_image']) ? $settings['display_image'] : '';
            $this->title            = !empty($settings['title']) ? $settings['title'] : '';
            $this->tagline_title    = !empty($settings['tagline_title']) ? $settings['tagline_title'] : '';
            $this->description      = !empty($settings['description']) ? $settings['description'] : '';
            $this->join_us_btn_txt  = !empty($settings['join_us_btn_txt']) ? $settings['join_us_btn_txt'] : '';
            $this->points           = !empty($settings['points']) ? $settings['points'] : array();

        }else{
            $getDefaultValues = SiteSetting::where('setting_type', 'opportunities-block')->get();
           
            if(!$getDefaultValues->isEmpty()){
                foreach($getDefaultValues as $value){
                    if($value->meta_key == 'points'){
                        $this->{$value->meta_key} = !empty($value->meta_value) ? unserialize($value->meta_value) : array();
                    } else{
                        $this->{$value->meta_key} = !empty($value->meta_value) ? $value->meta_value : '';
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
