<?php

namespace App\Http\Livewire\PageBuilder;

use App\Models\Project;
use Livewire\Component;
use App\Models\SitePage;
use App\Models\Setting\SiteSetting;

class ProjectsBlock extends Component
{

    public $sub_title           = null;
    public $title               = null;
    public $explore_btn_txt     = null;
    public $project_ids         = [];
    public $address_format      = '';
    public $currency_symbol     = ''; 
    public $style_css           = '';
    public $site_view           = false;
    public $page_id             = null;
    public $block_key           = null;
    public $custom_class        = '';

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

        $currency                       = setting('_general.currency');
        $address_format                 = setting('_general.address_format');
        $currency_detail                = !empty($currency)  ? currencyList($currency) : array();
        $this->address_format           = !empty($address_format)  ? $address_format : 'state_country';
        if(!empty($currency_detail)){
            $this->currency_symbol        = $currency_detail['symbol']; 
        }

        if( !empty( $settings) ){

            $this->sub_title        = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
            $this->title            = !empty($settings['title']) ? $settings['title'] : '';
            $this->explore_btn_txt  = !empty($settings['explore_btn_txt']) ? $settings['explore_btn_txt'] : '';
            $this->project_ids      = !empty($settings['project_ids']) ? $settings['project_ids'] : [];
        }else{

            $getDefaultValues = SiteSetting::where('setting_type', 'projects-block')->get();
            if( !$getDefaultValues->isEmpty() ){
                foreach($getDefaultValues as $value){
                    $this->{$value->meta_key} = !empty($value->meta_value) ? $value->meta_value : '';
                }
            }

            $project_ids        = Project::select('id')->latest()->where('status', 'publish')->take(5)->pluck('id')->toArray();
            $this->project_ids  = !empty($project_ids) ? $project_ids : [];
        }
    }

    public function render(){

        $projects = [];
        if( !empty($this->project_ids) ){
            $projects = Project::select( 
            'id',
            'author_id',
            'project_title',
            'slug',
            'updated_at',
            'project_type',
            'project_min_price',
            'project_location',
            'project_country',
            'project_expert_level',
            'project_duration',
            'project_max_price',
            'address',
            'project_hiring_seller',
            'is_featured',
             'status')->with(
                array(
                    'expertiseLevel:id,name',
                    'projectLocation:id,name', 
                    'projectAuthor:id,first_name,last_name,image',
                )
            )->whereIn('id', $this->project_ids)->get();
           
        }

        return view('livewire.pagebuilder.projects-block', compact('projects'));
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

                if( isset($this->{$propertyKey}) ){

                    if($propertyKey == 'project_ids'){
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
