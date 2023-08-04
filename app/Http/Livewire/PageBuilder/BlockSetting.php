<?php

namespace App\Http\Livewire\PageBuilder;

use App\Models\Project;
use Livewire\Component;
use App\Models\Taxonomies\ProjectCategory;
use App\Models\SitePage;
use Livewire\WithFileUploads;
use App\Models\Setting\SiteSetting;
use Illuminate\Support\Facades\Validator;

class BlockSetting extends Component
{
    use WithFileUploads;

    protected $listeners = [ 'getBlockSetting', 'publish-page' => 'publishPage', 'resetSetting' ];
    
    public $upload_files = [
        'file_01'  => '',
        'file_02'  => '',
        'file_03'  => '',
        'file_04'  => '',
    ];

    public $block_id        = '';
    public $block_key       = '';
    public $settings        = [];
    public $page_blocks     = [];
    public $allowImageSize  = '';
    public $allowImageExt   = [];

    public $feedback_users  = [
        'name'          => '',
        'address'       => '',
        'description'   => '',
        'rating'        => '0',
        'image'         => '',
    ];

    public $team_members  = [
        'name'           => '', 
        'designation'    => '',
        'image'          => '', 
        'facebook_link'  => '',
        'twitter_link'   => '',
        'linkedin_link'  => '',
        'twitch_link'    => '',
        'dribbble_link'  => '',
    ];

    public function mount( $page_id, $page_blocks ){

        $this->page_id      = $page_id;
        $this->page_blocks  = $page_blocks;
        
        $image_file_ext         = setting('_general.image_file_ext');
        $image_file_size        = setting('_general.image_file_size');
        $this->allowImageSize   = !empty( $image_file_size ) ? $image_file_size : '3';
        $this->allowImageExt    = !empty( $image_file_ext ) ?  explode(',', $image_file_ext)  : ['jpg','png'];

    } 

    public function render(){
        return view('livewire.pagebuilder.block-setting');
    }

    public function resetSetting(){

        $this->upload_files = [
            'file_01'  => '',
            'file_02'  => '',
            'file_03'  => '',
            'file_04'  => '',
        ];
        $this->settings = [];
        $this->block_id = '';
        $this->block_key = '';
    }

    public function getBlockSetting( $block_key ){

        $dispatch_key = $block_key;
        $this->block_key    = $block_key;
        $block_key          = explode('__', $block_key);
        $id                 = $block_key[0];
        $key                = isset($block_key[1]) ? $block_key[1] : '';
        
        if( !empty($this->page_blocks[$id]) ){
            
            $page = Sitepage::select('settings')->find( $this->page_id );

            if( !empty($page) ){

                $block = !empty($page->settings) ? json_decode($page->settings, true) : [];
                
                if( !empty($block[$key]) && $block[$key]['block_id'] == $id ){
                    $this->upload_files = [
                        'file_01'  => '',
                        'file_02'  => '',
                        'file_03'  => '',
                        'file_04'  => '',
                    ];
                    $this->settings = [];
                    if(!empty($block[$key]['settings'])){
                        $this->settings = $block[$key]['settings'];
                    }else{
                        $this->settings = $this->getDefaultSetting($id);
                    }

                    $this->block_id = $id;
                    $this->dispatchBrowserEvent('active-block-settings', array('block_key' => $this->block_key));
                    $this->emit('getBlockStyleSetting', ['id' => $this->block_id, 'block_key' => $this->block_key,  'settings' => $block[$key]['css']]);
                }
            }

            $this->dispatchBrowserEvent('initForm', ['block_key' => $dispatch_key]);
            $this->upload_file = null;

            if( in_array( $id, ['header-block','hiring-process-block','mobile-app-block','terms-condition-block'] ) ){
                $dispatch_data = array( 
                    'block_key' => $dispatch_key, 
                    'heading' => !empty($this->settings['heading']) ? $this->settings['heading'] : '',
                );

                if( $id == 'terms-condition-block'){
                    $dispatch_data['heading'] = !empty($this->settings['page_content']) ? $this->settings['page_content'] : '';
                }
                $this->dispatchBrowserEvent('initTinyMce', $dispatch_data);
            }
        }
    }

    public function publishPage(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        
        SitePage::select('id')->where('id', $this->page_id )->update(['status' => 'publish']); 
        $this->dispatchBrowserEvent('showAlertMessage', [
            'title'     => __('general.success_title'),
            'type'      => 'success',
            'message'   => __('pages.page_published')
        ]);
    }

    public function updatedSettings($value, $key){

        $block_key          = explode('__', $this->block_key);
        $id                 = $block_key[0];
      
        if( in_array($id, ['user-feedback-block', 'professional-block']) ) {

            $keys = explode(".", $key);
            if(!empty($keys[2]) && $keys[2] == 'image' ){
                if(!empty($this->settings[$keys[0]][$keys[1]][$keys[2]])){

                    $validator = Validator::make([ 'file' => $this->settings[$keys[0]][$keys[1]][$keys[2]] ],
                        [ 'file' => 'image|mimes:'.join(',', $this->allowImageExt).'|max:'.$this->allowImageSize*1024]
                    );
                    
                    if(!$validator->fails()){
                        $image_path = $this->settings[$keys[0]][$keys[1]][$keys[2]]->store('public/pages');
                        $image_path = str_replace('public/', '', $image_path);
                        $imageUrl   = 'storage/'.$image_path;
                        $this->settings[$keys[0]][$keys[1]][$keys[2]] = $imageUrl;
                        $this->dispatchBrowserEvent('updateDynamicFileUrl', array('property_key' => implode('', $keys), 'block_key' => $this->block_key, 'file_url' => $imageUrl));
                    } else {
                        $this->settings[$keys[0]][$keys[1]][$keys[2]] = '';
                        $this->dispatchBrowserEvent('showAlertMessage', [
                            'type'      => 'error',
                            'title'     => __('general.error_title'),
                            'message'   => __('general.invalid_file_type' , ['file_types' => join(',', $this->allowImageExt) ])
                        ]);
                    }
                    return;
                }
            }
        }
    }

    public function updatedUploadFiles($value, $key){

        $block_key  = explode('__', $this->block_key);
        $id         = $block_key[0];

        if(!empty($this->upload_files[$key])){
            $validator = Validator::make([ 'file' => $this->upload_files[$key] ],
                [ 'file' => 'image|mimes:'.join(',', $this->allowImageExt).'|max:'.$this->allowImageSize*1024]
            );
            
            if(!$validator->fails()){
                $image_path = $this->upload_files[$key]->store('public/pages');
                $image_path = str_replace('public/', '', $image_path);
                $imageUrl   = 'storage/'.$image_path;
                $this->dispatchBrowserEvent('updateDynamicFileUrl', array('property_key' => $key, 'block_key' => $this->block_key, 'file_url' => $imageUrl));
            } else {
                $this->upload_files[$key] = '';
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => __('general.invalid_file_type' , ['file_types' => join(',', $this->allowImageExt) ])
                ]);
            }
        }
    }

    public function addMoreItem( $property_key ){

        if(isset($this->{$property_key})){
            $this->settings[$property_key][] = $this->{$property_key};
        }
    }

    public function removeItem( $property_key, $index ){

        unset($this->settings[$property_key][$index]);
        $this->dispatchBrowserEvent('removeItem', array( 'block_key' => $this->block_key));
    }
    
    public function getDefaultSetting($id){

        $setting = array();
        switch($id){
            case 'categories-block':
                $setting = $this->getCategoryBlockSetting($id);
            break;
            case 'header-block':
                $setting = $this->getHeaderBlockSetting($id);
            break;
            case 'search-talent-block':
                $setting = $this->getHeaderv2Setting($id);
            break;
            case 'hiring-process-block':
                $setting = $this->getHiringProcessSetting($id);
            break;
            case 'mobile-app-block':
                $setting = $this->getMobileAppSetting($id);
            break;
            case 'footer-block':
                $setting = $this->getFooterBlockSetting($id);
                break;
            case 'projects-block':
                $setting = $this->getProjectBlockSetting($id);
            break;
            case 'opportunities-block':
                $setting = $this->getOpportunitySetting($id);
            break;
            case 'user-feedback-block':
                $setting = $this->getUserFeedbackSetting($id);
            break;
            case 'professional-block':
                $setting = $this->getProfessionalBlockSetting($id);
            break;
            case 'question-search-block':
                $setting = $this->getQuestionBlockSetting($id);
            break;
            case 'send-question-block':
                $setting = $this->getSendQuestionBlockSetting($id);
            break;
            case 'terms-condition-block':
                $setting = $this->getTermsConditionSetting($id);
            break;
        }
        return $setting;
    }

    public function getOpportunitySetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                if($value->meta_key == 'points'){
                    $setting[$value->meta_key] = !empty($value->meta_value) ? unserialize($value->meta_value) : [];
                } else{
                    $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
                }
            }
        }
        return $setting;
    }

    public function getTermsConditionSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                if($value->meta_key == 'page_content'){
                    $setting[$value->meta_key] = !empty($value->meta_value) ? json_decode($value->meta_value) : [];
                }
            }
        }

        return $setting;
    }

    public function getHeaderv2Setting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
            }
        }
        return $setting;
    }

    public function getUserFeedbackSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                if($value->meta_key == 'feedback_users'){
                    $setting[$value->meta_key]          = !empty($value->meta_value) ? unserialize($value->meta_value) : [];
                } else{
                    $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
                }
            }
        }
        return $setting;
    }

    public function getProfessionalBlockSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                if($value->meta_key == 'team_members'){
                    $setting[$value->meta_key] = !empty($value->meta_value) ? unserialize($value->meta_value) : [];
                } else{
                    $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
                }
            }
        }
        return $setting;
    }

    public function getQuestionBlockSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){

            foreach($getDefaultValues as $value){

                if($value->meta_key == 'question_list') {
                    $setting[$value->meta_key] = !empty($value->meta_value) ? unserialize($value->meta_value) : [];
                } else {
                    $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
                }

            }
        }
        return $setting;
    }

    public function getSendQuestionBlockSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
            }
        }
        return $setting;
    }

    public function getHiringProcessSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                if($value->meta_key == 'heading'){
                    $setting[$value->meta_key]          = !empty($value->meta_value) ? json_decode($value->meta_value) : '';
                } elseif(in_array($value->meta_key, ['description','video_link','talent_btn_txt','work_btn_txt','hiring_process_bg'])){
                    $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
                }
            }
        }
        return $setting;
    }

    public function getMobileAppSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                if($value->meta_key == 'heading'){
                    $setting[$value->meta_key]          = !empty($value->meta_value) ? json_decode($value->meta_value) : '';
                } else {
                    $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
                }
            }
        }
        return $setting;
    }

    public function getFooterBlockSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                    $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
            }
        }
        $category_ids = ProjectCategory::select('id')->latest()->where('status', 'active')->whereNull('parent_id')->whereNull('deleted_at')->take(9)->pluck('id')->toArray();
        $setting['category_ids'] = !empty($category_ids) ? $category_ids : [];
        
        return $setting;
    }

    public function getCategoryBlockSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                    $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
            }
        }
        $category_ids = ProjectCategory::select('id')->latest()->where('status', 'active')->whereNull('parent_id')->whereNull('deleted_at')->take(3)->pluck('id')->toArray();
        $setting['category_ids'] = !empty($category_ids) ? $category_ids : [];
        
        return $setting;
    }

    public function getProjectBlockSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();

        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                    $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
            }
        }
        $project_ids = Project::select('id')->latest()->where('status', 'publish')->take(5)->pluck('id')->toArray();
        $setting['project_ids']         = !empty($project_ids) ? $project_ids : [];

        return $setting;
    }

    public function getHeaderBlockSetting($settingType){

        $setting            = array();
        $getDefaultValues   = SiteSetting::where('setting_type', $settingType)->get();
        if(!$getDefaultValues->isEmpty()){
            foreach($getDefaultValues as $value){
                if($value->meta_key == 'heading'){
                    $setting[$value->meta_key]          = !empty($value->meta_value) ? json_decode($value->meta_value) : '';
                } elseif($value->meta_key == 'counter_option'){
                        $setting[$value->meta_key]          = !empty($value->meta_value) ? unserialize($value->meta_value) : [];
                } else {
                    $setting[$value->meta_key] = !empty($value->meta_value) ? $value->meta_value : '';
                }
            }
        }
        return $setting;
    }

}
