<?php

namespace App\Http\Livewire\PageBuilder;

use Livewire\Component;
use App\Models\Taxonomies\ProjectCategory;
use App\Models\SitePage;
use App\Models\Setting\SiteSetting;


class CategoriesBlock extends Component
{
    
    
    public $title, $sub_title, $description, $explore_btn_txt;
    
    public $style_css   = '';
    public $site_view   = false;
    public $page_id     = null;
    public $block_key   = null;
    public $custom_class  = '';
    public $category_ids  = [];

    public function render(){
        
        $categories = [];
        if( !empty($this->category_ids) ){

            $categories = ProjectCategory::select('id','name','slug', 'image')->with('children',function($query){
                $query->select('id','parent_id', 'name','slug');
                $query->withCount('children');
                
            })->whereIn('id', $this->category_ids)->get();
           
        }
        return view('livewire.pagebuilder.categories-block', compact('categories') );
    }

    protected function getListeners(){

        return [
            'update-'.$this->block_key                  => "updateBlockSetting",
            'update-custom-class-'.$this->block_key     => "updateCustomClass",
        ];
    }

    public function mount( $page_id, $block_key, $settings, $style_css, $site_view){

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

            $this->title            = ! empty( $settings['title'] ) ? $settings['title'] : '';
            $this->sub_title        = ! empty( $settings['sub_title'] ) ? $settings['sub_title'] : '';
            $this->description      = ! empty( $settings['description'] ) ? $settings['description'] : '';
            $this->explore_btn_txt  = ! empty( $settings['explore_btn_txt'] ) ? $settings['explore_btn_txt'] : '';
            $this->category_ids     = ! empty( $settings['category_ids'] ) ? $settings['category_ids'] : [];
        }else{

            $getDefaultValues = SiteSetting::where('setting_type', 'categories-block')->get();
            if(!$getDefaultValues->isEmpty()){
                foreach($getDefaultValues as $value){
                    $this->{$value->meta_key} = !empty($value->meta_value) ? $value->meta_value : '';
                }
            }
            $category_ids = ProjectCategory::select('id')->latest()->where('status', 'active')->whereNull('parent_id')->whereNull('deleted_at')->take(3)->pluck('id')->toArray();
            $this->category_ids         = !empty($category_ids) ? $category_ids : [];
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
