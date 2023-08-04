<?php

namespace App\Http\Livewire\PageBuilder;

use Livewire\Component;
use App\Models\Taxonomies\ProjectCategory;
use App\Models\SitePage;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Setting\SiteSetting;
use Illuminate\Support\Facades\Cache;

class FooterBlock extends Component
{

    public $description         = null;
    public $mobile_app_heading  = null;
    public $app_store_img       = null;
    public $app_store_url       = null;
    public $play_store_img      = null;
    public $play_store_url      = null;
    public $category_heading    = null;
    public $no_of_category      = null;
    public $newsletter_heading  = null;
    public $phone               = null;
    public $email               = null;
    public $fax                 = null;
    public $whatsapp            = null;
    public $facebook_link       = null;
    public $twitter_link        = null;
    public $linkedin_link       = null;
    public $dribbble_link       = null;
    public $footer_menu         = null;
    public $logo_image           = null;
    public $category_ids        = [];
    public $custom_class        = '';
    public $style_css           = '';
    public $site_view           = false;
    public $page_id             = null;
    public $block_key           = null;
    public $phone_call_availablity      = null;
    public $whatsapp_call_availablity   = null;


    public function render()
    {

        $categories = [];
        if( !empty($this->category_ids) ){
            $categories = ProjectCategory::select('id','name', 'slug')->whereIn('id', $this->category_ids)->get();
        }

        return view('livewire.pagebuilder.footer-block', compact('categories'));
    }
    protected function getListeners()
    {
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
        if( !empty( $settings) ){

            $this->description          = !empty($settings['description']) ? $settings['description'] : '';
            $this->mobile_app_heading   = !empty($settings['mobile_app_heading']) ? $settings['mobile_app_heading'] : '';
            $this->logo_image           = !empty($settings['logo_image']) ? $settings['logo_image'] : '';
            $this->app_store_img        = !empty($settings['app_store_img']) ? $settings['app_store_img'] : '';
            $this->app_store_url        = !empty($settings['app_store_url']) ? $settings['app_store_url'] : '';
            $this->play_store_img       = !empty($settings['play_store_img']) ? $settings['play_store_img'] : '';
            $this->play_store_url       = !empty($settings['play_store_url']) ? $settings['play_store_url'] : '';
            $this->category_heading     = !empty($settings['category_heading']) ? $settings['category_heading'] : '';
            $this->no_of_category       = !empty($settings['no_of_category']) ? $settings['no_of_category'] : '';
            $this->newsletter_heading   = !empty($settings['newsletter_heading']) ? $settings['newsletter_heading'] : '';
            $this->phone                = !empty($settings['phone']) ? $settings['phone'] : '';
            $this->email                = !empty($settings['email']) ? $settings['email'] : '';
            $this->fax                  = !empty($settings['fax']) ? $settings['fax'] : '';
            $this->whatsapp             = !empty($settings['whatsapp']) ? $settings['whatsapp'] : '';
            $this->facebook_link        = !empty($settings['facebook_link']) ? $settings['facebook_link'] : '';
            $this->twitter_link         = !empty($settings['twitter_link']) ? $settings['twitter_link'] : '';
            $this->linkedin_link        = !empty($settings['linkedin_link']) ? $settings['linkedin_link'] : '';
            $this->dribbble_link        = !empty($settings['dribbble_link']) ? $settings['dribbble_link'] : '';
            $this->category_ids         = !empty($settings['category_ids']) ? $settings['category_ids'] : [];
            $this->phone_call_availablity       = !empty($settings['phone_call_availablity']) ? $settings['phone_call_availablity'] : '';
            $this->whatsapp_call_availablity    = !empty($settings['whatsapp_call_availablity']) ? $settings['whatsapp_call_availablity'] : '';
        }else{
            $getDefaultValues = SiteSetting::where('setting_type', 'footer-block')->get();
            if(!$getDefaultValues->isEmpty()){
                foreach($getDefaultValues as $value){
                    $this->{$value->meta_key} = !empty($value->meta_value) ? $value->meta_value : '';
                }
            }

            
            $category_ids = ProjectCategory::select('id')->latest()->where('status', 'active')->whereNull('parent_id')->whereNull('deleted_at')->take(9)->pluck('id')->toArray();
            $this->category_ids         = !empty($category_ids) ? $category_ids : [];
        }

       
        $menu = Cache::rememberForever('footer-menu', function() {
            return Menu::select('id')->where('location', 'footer')->latest()->first();
        });

        if( !empty($menu) ){
            $footer_menu = Cache::rememberForever('footer-menu-'.$menu->id, function() use($menu){
                return MenuItem::where('menu_id', $menu->id)->whereNull('parent_id')->orderBy('sort','asc')->get(); 
            });
            $this->footer_menu      = $footer_menu;
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
                    if($propertyKey == 'category_ids'){
                        $this->{$propertyKey}       = !empty($data) ? explode(',',$data) : [];
                        $newSetting[$propertyKey]   = !empty($data) ? explode(',',$data) : [];
                    } else {
                        if( is_array($data) ){
                            $result = SanitizeArray($data);
                            $newSetting[$propertyKey] = $result;
                        }else{
                           $newSetting[$propertyKey]   = sanitizeTextField($data, true);
                        }
                        $this->{$propertyKey}       = $newSetting[$propertyKey];
                    }
                }
            }

            $page_settings[$key]['settings']    = $newSetting;
            $settings                           = json_encode($page_settings);
            $page->update(['settings' => $settings ]);
        }
    }

}
