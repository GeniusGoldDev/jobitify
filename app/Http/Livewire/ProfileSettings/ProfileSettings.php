<?php

namespace App\Http\Livewire\ProfileSettings;
use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Country;
use App\Models\Profile;
use Livewire\Component;
use App\Models\Education;
use App\Models\CountryState;
use App\Models\EmailTemplate;
use Livewire\WithFileUploads;
use App\Models\Taxonomies\Skill;
use App\Models\UserBillingDetail;
use App\Models\UserAccountSetting;
use App\Models\UserIdentification;
use App\Models\Seller\SellerPortfolio;
use App\Models\Seller\SellerSocialLink;
use App\Models\Taxonomies\Language;
use Illuminate\Support\Facades\{
    Auth,Hash,Notification 
};
use App\Notifications\EmailNotification;


class ProfileSettings extends Component
{
    use WithFileUploads;

    public $profile_settings = [
        'first_name'        => '',
        'last_name'         => '',
        'tagline'           => '',
        'description'       => '',
        'country'           => '',
        'zipcode'           => '',
        'seller_type'       => '',
        'english_level'     => '',
        'image'     => '',
        'skill_ids'         => array(),
        'language_ids'      => array(),
    ];
    public $banner, $old_banner;
    public $identity_verification = [
        'profile_id'                => '',
        'name'                      => '',
        'contact_no'                => '',
        'identity_no'               => '',
        'address'                   => '',
        'identity_attachments'      => '',
    ];

    public $billing_info = [
        'profile_id'	=> '', 
        'country_id'    => null,
        'first_name'    => null,
        'last_name'     => null,
        'company'       => null,
        'phone'         => null,
        'email'         => null,
        'city'          => null,
        'postal_code'   => null,
        'state_id'      => null,
        'address'       => null,
    ];

    public $account_settings = [
        'hourly_rate'   => '',
        'show_image'    => '',
        'current_pass'  => '',
        'new_pass'      => '',
        'retype_pass'   => '',
        'reason'        => '',
        'reason_desc'   => '',
    ];
    
    public $education_detail = [
        'profile_id'        => null,
        'deg_title'         => null,
        'deg_institue_name' => null,
        'address'           => null,
        'deg_description'   => null,
        'deg_start_date'    => null,
        'deg_end_date'      => null,
        'is_ongoing'        => null,
    ];

    public $dynamic_id      = '';
    public $english_levels  = [];
    public $reasons         = [];
    public $skills          = [];
    public $languages       = [];
    public $seller_types    = [];
    public $isUploading     = false;
    public $tab             = 'profile-settings';
    public $countries       = array();
    public $userId          = null;
    public $roleId          = null;
    public $files           = [];
    public $existingFiles   = [];
    public $profileId       = null;
    public $old_zipcode     = '';
    public $userRole        = null;
    public $isVerifiedAcc   = 'pending';
    public $education_list  = null;
    public $education_id    = null;
    public $educationList   = [];
    public $allowFileSize   = '';
    public $allowFileExt    = [];
    public $allowImageSize  = '';
    public $allowImageExt   = [];
    public $old_image       = '';
    public $image           = '';
    public $cropImageUrl    = '';
    public $has_states      = false;
    public $states          = [];
    public $method_type     = '';
    public $verify_reject_reason    = '';
    protected $listeners            = ['deleteEducationRecord' => 'deleteEducation', 'deletePortfolio', 'deactiveAccount'];

    // portfolio start
    public $allowSocialLinks    = 'disbale';
    public $socialLinks         = [];
    public $profile_id          = '';
    public $isEdit              = false;
    public $portfolio           = [
        'image'         => '',
        'title'         => '',
        'url'           => '',
        'description'   => '',
    ];
    public $portfolio_id        = null;
    public $prtExistingFiles    = [];
    public $portfolioFiles      = '';
    public $portfolios          = [];
    // portfolio end

    public function mount(){

        $Auth                   = Auth::user();
        $this->userId           = $Auth->id;
        $userAccountSetting     = $Auth->userAccountSetting;
        $user = getUserRole();
        $this->roleId                   = $user['roleId'];
        $this->userRole                 = $user['roleName'];
        $verification                   = $userAccountSetting->verification;
        $this->verify_reject_reason     = $userAccountSetting->verification_reject_reason;
        
        $this->account_settings['show_image']   = $userAccountSetting->show_image;
        $this->account_settings['hourly_rate']  = $userAccountSetting->hourly_rate;

        $getSetting             = getTPSetting(['payment'], ['payment_methods']);
        $file_ext               = setting('_general.file_ext');
        $file_size              = setting('_general.file_size');
        $image_file_ext         = setting('_general.image_file_ext');
        $image_file_size        = setting('_general.image_file_size');
        $social_links           = setting('_seller.social_links');
        $this->allowSocialLinks = !empty( $social_links ) ? 'enable' : 'disable';
        $payment_methods        = !empty($getSetting['payment_methods']) ? unserialize($getSetting['payment_methods']) : [];
        $this->method_type      = !empty( $payment_methods['method_type'] ) ? $payment_methods['method_type'] : '';
        $this->allowFileSize    = !empty( $file_size ) ? $file_size : '3';
        $this->allowFileExt     = !empty( $file_ext ) ?  explode(',', $file_ext)  : [];
        $this->allowImageSize   = !empty( $image_file_size ) ? $image_file_size : '3';
        $this->allowImageExt    = !empty( $image_file_ext ) ?  explode(',', $image_file_ext)  : ['jpg','png'];
        
        $profileInfo            = Profile::where(['user_id' => $this->userId, 'role_id' => $this->roleId])->first();
        $this->countries        = Country::select('id','name','short_code')->get()->toArray();
        $reasons                = setting('_general.deactive_account_reasons');

        $this->reasons          = !empty($reasons) ? array_column($reasons, 'deactive_reason') : [];

        $selectedSkills = $selectedLanguages = [];

        if( $this->userRole == 'seller' ) {
            $selectedSkills     = !empty( $profileInfo ) ? $profileInfo->skills()->select('skill_id')->pluck('skill_id')->toArray() : array();
            $selectedLanguages  = !empty( $profileInfo ) ? $profileInfo->languages()->select('language_id')->pluck('language_id')->toArray() : array();
            $this->skills       = Skill::select('id','name')->where('status', 'active')->orderBy('id', 'DESC')->get()->toArray();
            $this->languages    = Language::select('id','name')->where('status', 'active')->orderBy('name', 'ASC')->get()->toArray();
            $seller_types       = setting('_seller.seller_business_types');
            $this->seller_types = !empty($seller_types) ? array_column($seller_types, 'business_types') : [];
        }

        $this->isVerifiedAcc = !empty($verification) ? $verification : 'pending';

        $this->english_levels = [
            'basic'             => __('profile_settings.basic_level'),
            'conversational'    => __('profile_settings.conversational_level'),
            'fluent'            => __('profile_settings.fluent_level'),
            'native'            => __('profile_settings.native_level'),
            'professional'      => __('profile_settings.professional_level'),
        ];

        if(!empty( $profileInfo ) ){
            $this->profileId = $profileInfo->id;
            $this->profile_settings = [
                'first_name'        => $profileInfo->first_name,
                'last_name'         => $profileInfo->last_name,
                'tagline'           => stripcslashes($profileInfo->tagline),
                'description'       => $profileInfo->description,
                'country'           => $profileInfo->country,
                'zipcode'           => $profileInfo->zipcode,
                'seller_type'       => $profileInfo->seller_type,
                'english_level'     => $profileInfo->english_level,
                'skill_ids'         => $selectedSkills,
                'language_ids'      => $selectedLanguages,
                'image'             => $profileInfo->image,
            ];
            $this->image        = ''; 
            $this->old_image    = $profileInfo->image;
            $this->old_zipcode  = $profileInfo->zipcode;
            $this->banner       = '';
            $this->old_banner   = !empty($profileInfo->banner_image) ? unserialize($profileInfo->banner_image) : array();

            // get user billing record
            $billingRec = UserBillingDetail::where('profile_id', $this->profileId )->with('states')->first();
            
            if(!empty( $billingRec ) ){
                $this->billing_info = [
                    'profile_id'	=> $billingRec->profile_id, 
                    'country_id'    => $billingRec->country_id,
                    'state_id'      => $billingRec->state_id,
                    'first_name'    => $billingRec->billing_first_name,
                    'last_name'     => $billingRec->billing_last_name,
                    'company'       => $billingRec->billing_company,
                    'address'       => $billingRec->billing_address, 
                    'phone'         => $billingRec->billing_phone,
                    'email'         => $billingRec->billing_email,
                    'city'          => $billingRec->billing_city,
                    'postal_code'   => $billingRec->billing_postal_code,
                ];
                if( ! $billingRec->states->isEmpty() ){
                    $this->has_states = true;
                    $this->states = $billingRec->states;
                }

            }
            $this->getEducationList();
        }
        
    }

    public function render(){
       
        $record = array();
        
        switch($this->tab) {
            case 'profile-settings':
                $this->dispatchBrowserEvent('initTab1-js');
                break;
                case 'identity-verification':
                $this->dispatchBrowserEvent('initTab2-js');
                break;
            case 'billing-information':
                $this->dispatchBrowserEvent('initTab3-js');
                break;
            case 'account-settings':
                $this->dispatchBrowserEvent('initTab4-js');
                break;
            case 'portfolio-settings':
                $this->portfolios = SellerPortfolio::where('profile_id', $this->profileId)->orderBy('id','DESC')->get();
                
                if(!empty($this->prtExistingFiles)){
                    foreach($this->prtExistingFiles as $key=> $single){
                        $this->prtExistingFiles[$key] = (object) $single;
                    }
                }

                if( $this->allowSocialLinks == 'enable' ){
                    $availableLinks  = availableSocialLinks();
                    if( !empty($availableLinks) && is_array($availableLinks) ){
                        $social_links_values = SellerSocialLink::where('profile_id', $this->profileId)->get()->pluck('url', 'name')->toArray();
                        
                        foreach($availableLinks as $key => $link){
                            $this->socialLinks[$key] = !empty($social_links_values[$key]) ? $social_links_values[$key] : '';
                        }
                    }
                }

        }

        return view('livewire.profile-settings.settings', $record)->extends('layouts.app');
    }

    public function removeBanner(){

        $this->banner     = null;
        $this->old_banner = array();
    }

    public function updateSocialLinks(){

        $validations        = [];
        $availableLinks     = availableSocialLinks();
        if( !empty($availableLinks) && is_array($availableLinks) ){
            foreach($availableLinks as $key => $link){
                $validations['socialLinks.'.$key] = 'url';
            }
        }

        $this->validate($validations,[
            'url' => __('general.invalid_url')
        ]);

        $social_links = SanitizeArray($this->socialLinks);

        $social_links = array_filter($social_links, fn($value) => !is_null($value) && $value !== '');

        $updated = SellerSocialLink::where('profile_id', $this->profileId)->delete();

        if(!empty($social_links)){
            $values = [];
            foreach($social_links as $key => $url){
                $values[] = [
                    'profile_id'    => $this->profileId,
                    'name'          => $key,
                    'url'           => $url,
                    'created_at'    => new DateTime(),
                    'updated_at'    => new DateTime(),
                ];
            }
            $updated = SellerSocialLink::insert($values);
        }

        if( ! empty( $updated ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.success_message');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';           
        }

        $this->dispatchBrowserEvent('showAlertMessage', $eventData);

    }

    public function showPortfolioPopup($id = ''){
        if(!empty($id)){
            $portfolio = SellerPortfolio::find($id);
            if(!empty($portfolio)){
                $this->portfolio = [
                    'image'         => $portfolio->image,
                    'title'         => $portfolio->title,
                    'url'           => $portfolio->url,
                    'description'   => $portfolio->description,
                ];
                $this->isEdit = true;
                $this->portfolio_id = $id;

                if(empty($this->prtExistingFiles)){
                    if(!empty($portfolio->attachments)){
                        $attachments = unserialize($portfolio->attachments);
                        if(isset($attachments['files'])){
                            foreach($attachments['files'] as $key => $single){
                                if(!in_array($key,$this->prtExistingFiles)){
                                    $this->prtExistingFiles[$key] = (object) $single;
                                }
                            }
                        }
                    }
                }else{
                    foreach($this->prtExistingFiles as $key=> $single){
                        $this->prtExistingFiles[$key] = (object) $single;
                    }
                }
            }
        } else {
            $this->resetField();
        }
        $this->dispatchBrowserEvent('portfolio-popup', 'show');
    }

    public function deletePortfolio($params){
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $isRemove =  SellerPortfolio::where(['id' => $params['id'], 'profile_id' => $this->profileId])->delete();

        if( ! empty( $isRemove ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.delete_record');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';           
        }

        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }

    public function resetField(){
        $this->portfolio           = [
            'image'         => '',
            'title'         => '',
            'url'           => '',
            'description'   => '',
        ];

        $this->isEdit               = false;
        $this->portfolio_id         = null;
        $this->prtExistingFiles     = [];
    }

    public function updatedPortfolioFiles(){
       
        $this->validate(
            [
                'portfolioFiles.*' => 'mimes:'.join(',', $this->allowImageExt).'|max:'.$this->allowImageSize*1024,
            ],[
                'max'   => __('general.max_file_size_err',  ['file_size'    => $this->allowImageSize.'MB']),
                'mimes' => __('general.invalid_file_type',  ['file_types'   => join(',', $this->allowImageExt)]),
            ]
        );
       
        $this->prtExistingFiles = [];
        $filename = pathinfo($this->portfolioFiles->hashName(), PATHINFO_FILENAME);

        $this->prtExistingFiles[$filename] = (object) $this->portfolioFiles;
        
        
    }

    public function removePortfolioFile( $key ){

        if(!empty($this->prtExistingFiles[$key])){
            unset($this->prtExistingFiles[$key]);
        }
        if(!empty($this->prtExistingFiles)){
            foreach($this->prtExistingFiles as $key=> $single){
                $this->prtExistingFiles[$key] = (object) $single;
            }
        }
    }

    public function updatePortFolio(){
        
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
            'portfolio.title'   => 'required',
            'portfolio.url'     => 'required|url',
        ], [
            'required'      => __('general.required_field'),
            'url'           => __('general.invalid_url'),
        ]);

        $data['profile_id']     = $this->profileId;
        $data['title']          = sanitizeTextField($this->portfolio['title']);
        $data['url']            = sanitizeTextField($this->portfolio['url']);
        $data['description']    = sanitizeTextField($this->portfolio['description'], true);
        $attachments            = [];

        if( !empty($this->prtExistingFiles) ){
            $image_dimensions = getImageDimensions('portfolios');
            foreach($this->prtExistingFiles as $key => $single){

                $file = (object) $single;

                if(method_exists($file,'getClientOriginalName')){
                    $file_path      = $file->store('public/portfolios');
                    $file_path      = str_replace('public/', '', $file_path);
                    $file_name      = $file->getClientOriginalName();
                    $file_key       = pathinfo($file->hashName(), PATHINFO_FILENAME);
                    $mime_type      = $file->getMimeType();
                    $sizes          = generateThumbnails('portfolios', $file, $image_dimensions);
                }else{
                    $file_key   = $key;
                    $file_name  = $file->file_name;
                    $file_path  = $file->file_path;
                    $mime_type  = $file->mime_type;
                    $sizes      = !empty($file->sizes) ? $file->sizes : array();
                }

                $attachments['files'][$file_key]  = (object) array(
                    'file_name'  => $file_name,
                    'file_path'  => $file_path,
                    'mime_type'  => $mime_type,
                    'sizes'      => $sizes,
                );
            }
        }

        $data['attachments'] = !empty($attachments) ? serialize($attachments) : null;
        
        $isUpdate = null ;
        if($this->portfolio_id){
            $isUpdate = SellerPortfolio::where('id' , $this->portfolio_id)->update($data);
        } else {
            $isUpdate = SellerPortfolio::create($data);
        } 

        if( ! empty( $isUpdate ) ){
            $this->isEdit       = false;
            $this->portfolio_id = null;
            $this->resetField();
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.success_message');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';           
        }

        $this->dispatchBrowserEvent('portfolio-popup', 'hide');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);

    }

    public function updatedBillingInfo($value, $key ){

        if($key == 'country_id'){
            $states = CountryState::where('country_id', $value)->select('id','name')->get();
            if(!$states->isEmpty()){
                $this->states                   = $states;
                $this->has_states               = true;
                $this->billing_info['state_id'] = null;
            }else {
                $this->has_states = false;
                $this->billing_info['state_id'] = null;
                $this->states = [];
            }
        }

    }

    public function updatedImage(){

        $tmporaryURL = method_exists($this->image,'temporaryUrl') ? $this->image->temporaryUrl() : '';
        $data = [
            'showModel' => 'show',
            'imageUrl'  => $tmporaryURL,
        ];
        $this->dispatchBrowserEvent('cropimage-popup', $data);
    }

    public function cropImage(){
        $this->dispatchBrowserEvent('croppedImage');
    }

    public function getEducationList(){
        $this->educationList   = Education::select('id','deg_title', 'deg_institue_name','address', 'deg_description','deg_start_date','deg_end_date','is_ongoing')->where('profile_id', $this->profileId)->orderBy('id', 'DESC')->get()->toArray();
    }

    public function deleteEducationConfirm($id)
    {
        $this->education_id = $id;
        $this->dispatchBrowserEvent('delete-education-confirm');
    }

    public function deleteEducation(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        
        if($this->education_id){
            $isDelete = Education::where('id', $this->education_id)->delete();

            if( ! empty( $isDelete ) ){
                $this->getEducationList();
                $eventData['title']     = __('general.success_title');
                $eventData['message']   = __('general.delete_record');
                $eventData['type']      = 'success';
            } else {
                $eventData['title']     = __('general.error_title');
                $eventData['message']   = __('settings.wrong_msg');
                $eventData['type']      = 'error';           
            }

            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }
    }

    public function editEducation($id){

        $education   = Education::where('id', $id)->first();
        if( ! empty($education) ) {
            $this->dynamic_id = time();
            $this->education_detail = [
                'profile_id'        => $education->profile_id,
                'deg_title'         => $education->deg_title,
                'deg_institue_name' => $education->deg_institue_name,
                'address'           => $education->address,
                'deg_description'   => $education->deg_description,
                'deg_start_date'    => Carbon::parse($education->deg_start_date)->format('d-m-Y'),
                'deg_end_date'      => !empty($education->deg_end_date) ? Carbon::parse($education->deg_end_date)->format('d-m-Y') : null,
                'is_ongoing'        => $education->is_ongoing,
            ];
            
            $this->education_id = $id;
            $this->dispatchBrowserEvent('reset-education-form');
            $this->dispatchBrowserEvent('education-popup', 'show');
        }
        
    }

    public function addEducation(){

        $this->resetRecord('education_detail');
        $this->dispatchBrowserEvent('education-popup', 'show');
    }

    public function resetRecord( $recordType ){

        switch($recordType){
            case 'education_detail':
                $this->education_detail = [
                    'profile_id'        => null,
                    'deg_title'         => null,
                    'deg_institue_name' => null,
                    'address'           => null,
                    'deg_description'   => null,
                    'deg_start_date'    => null,
                    'deg_end_date'      => null,
                    'is_ongoing'        => 0,
                ];
                $this->education_id = null;
                $this->dispatchBrowserEvent('reset-education-form');
        }
    }

    public function updateEducation(){
        
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
            'education_detail.deg_title'        => 'required',
            'education_detail.deg_start_date'   => 'required',
            'education_detail.address'          => 'required',
            'education_detail.deg_end_date'     => 'sometimes|nullable|required_if:education_detail.is_ongoing,0,false,null|date|after:education_detail.deg_start_date'
        ], [
            'required'      => __('general.required_field'),
            'required_if'   => __('general.required_field'),
            'after'         => __('profile_settings.date_diff_validation')
        ]);
        
        if( empty( $this->education_detail['is_ongoing'] ) && empty( $this->education_detail['deg_end_date'] )){
            $this->addError('education_detail.deg_end_date', __('general.required_field'));
            return false;
        }
        
      
        $data['profile_id']             = $this->profileId;
        $data['deg_title']              = sanitizeTextField($this->education_detail['deg_title']);
        $data['deg_institue_name']      = sanitizeTextField($this->education_detail['deg_institue_name']);
        $data['address']                = sanitizeTextField($this->education_detail['address']);
        $data['deg_description']        = sanitizeTextField($this->education_detail['deg_description'], true);
        $data['deg_start_date']         = Carbon::parse($this->education_detail['deg_start_date']);

        if( !empty( $this->education_detail['is_ongoing'] ) ){
            $data['deg_end_date']       = NULL;
        } else {
            $data['deg_end_date']       = Carbon::parse($this->education_detail['deg_end_date']);
        }

        $data['is_ongoing']             = $this->education_detail['is_ongoing'];
        $education = null ;
        if($this->education_id){
            $education = Education::where('id' , $this->education_id)->update($data);
        } else {
            $education = Education::create($data);
        } 

        if( ! empty( $education ) ){
            $this->getEducationList();
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.success_message');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';           
        }

        $this->dispatchBrowserEvent('education-popup', 'hide');
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);

    }

    public function updatePassword(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $validated_data = $this->validate([
            'account_settings.current_pass'      => 'required',
            'account_settings.new_pass'          => 'required|min:5',
            'account_settings.retype_pass'       => 'required|min:5|same:account_settings.new_pass',
        ],[
            'min'       => __( 'general.minimum_lenght', ['length' => 5 ] ) ,
            'required'  => __('general.required_field'),
            'same'      => __('account_settings.same_error_msg'),
        ]);

        $user   = Auth::user();
        $isSave = false;
        if (Hash::check($this->account_settings['current_pass'], $user->password )) {
            $user->password = Hash::make($this->account_settings['new_pass']);
            $isSave = $user->save();
        } else {
            $this->addError('account_settings.current_pass', __('account_settings.wrong_error_msg'));
        }

        $this->account_settings['current_pass'] = '';
        $this->account_settings['new_pass']     = '';
        $this->account_settings['retype_pass']  = '';
        
        $eventData = [];
        if( ! empty( $isSave ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('settings.password_change');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';           
        }

        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        
    }

    public function updatePrivacyInfo(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $validations = array(
            'account_settings.show_image' => 'required',
        );

        if($this->userRole == 'seller'){
            $validations['account_settings.hourly_rate'] = 'required|numeric';
        }

        $this->validate($validations,[
            'required' => __('general.required_field'),
            'numeric'  => __('general.numeric_field')
        ]);
        $data = array(
         'show_image'   => $this->account_settings['show_image']
        );

        if( $this->userRole == 'seller' ){
            $data['hourly_rate'] = sanitizeTextField( $this->account_settings['hourly_rate'] );
        }

        $setting = UserAccountSetting::select('id')->updateOrCreate(
            [ 'user_id'      => $this->userId, ],
           $data
        );

        if( ! empty( $setting ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.success_message');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';           
        }
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);

        
    }

    public function deactiveAccount(){

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
            'account_settings.reason'       => 'required', 
            'account_settings.reason_desc'  => 'required',
        ],[
            'account_settings.reason.required'      => __('general.deactive_reason'),
            'account_settings.reason_desc.required' => __('general.deactive_detail'),
        ]);

        $setting = UserAccountSetting::select('id')->updateOrCreate(
            [ 'user_id' => $this->userId ],
            [ 
                'deactivation_reason'       => sanitizeTextField( $this->account_settings['reason'] ),
                'deactivation_description'  => sanitizeTextField( $this->account_settings['reason_desc'], true ),
            ]);

        $user = User::find($this->userId);
        $user->status = 'deactivated';
        $user->save();


        $this->account_settings['reason']       = '';
        $this->account_settings['reason_desc']  = '';

        if( ! empty( $setting ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.success_message');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';           
        }

        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        Auth::logout();
        return redirect('/');
    }

    public function reuploadIdentification(){

        $this->isVerifiedAcc = 'pending';
        $this->identity_verification = [
            'profile_id'                => '',
            'name'                      => '',
            'contact_no'                => '',
            'identity_no'               => '',
            'address'                   => '',
            'identity_attachments'      => '',
        ];
        $this->existingFiles        = [];
    }

    public function updateIdentification(){
        
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
            'identity_verification.name'            => 'required', 
            'identity_verification.contact_no'      => 'required',
            'identity_verification.identity_no'     => 'required',
            'identity_verification.address'         => 'required',
        ],
        [ 'required' => __('general.required_field') ]
        );
      
        $data['user_id']  = $this->userId;
        $data['name']        = sanitizeTextField($this->identity_verification['name']);
        $data['contact_no']  = sanitizeTextField($this->identity_verification['contact_no']);
        $data['identity_no'] = sanitizeTextField($this->identity_verification['identity_no']);
        $data['address']     = sanitizeTextField($this->identity_verification['address'], true);
        
      
        $attachments = array();
        foreach( $this->existingFiles as $file ){
            if( $file && gettype($file) == 'object' ){
                $file_path     = $file->store('public/user_identification');
                $attachments[] = str_replace('public/', '', $file_path);
            } else {
                $image_path = public_path().'/storage/'.$file;
                if( file_exists($image_path) ) {
                $attachments[] = $file;
                }
            }
        }
      

        if( empty( $attachments ) ) {
            $this->addError('identity_verification.attachments', __('identity_verification.attachments'));
            return ;
        }

        $data['identity_attachments'] = !empty( $attachments ) ? serialize( $attachments ) : null;

        $record = UserIdentification::select('id')->updateOrCreate( [ 'user_id'  => $this->userId ], $data );
       
        if(!empty($record)){
            $userAccountSetting                = Auth::user()->userAccountSetting;
           
            if( !empty($userAccountSetting) ) {
                $userAccountSetting->verification   = 'processed';
                $this->isVerifiedAcc = 'processed';
                $userAccountSetting->save();

                // send email to admin
                $email_template = EmailTemplate::select('content')
                ->where(['type' => 'accout_identity_verification' , 'status' => 'active', 'role' => 'admin'])
                ->latest()->first();
                
                if(!empty($email_template)){

                    $template_data              = unserialize($email_template->content);

                    $params                     = array();
                    $params['template_type']    = 'accout_identity_verification';
                    $getUserInfo                = getUserInfo();
                  
                   
                    $params['email_params'] = array(
                        'user_name'             => !empty($getUserInfo['user_name']) ? $getUserInfo['user_name'] : '',
                        'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                        'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                        'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
                    );
                    
                    $adminUser = User::whereHas(
                        'roles', function($q){
                            $q->where('name', 'admin');
                        }
                    )->latest()->first();
                    
                    try {
                        Notification::send($adminUser, new EmailNotification($params));
                    } catch (\Exception $e) {
                        $this->dispatchBrowserEvent('showAlertMessage', [
                            'title'     => __('general.error_title'),
                            'type'      => 'error',
                            'message'   => $e->getMessage(),
                        ]);
                        return;
                    }
                }
                //end sent email
            }
        }

        if( ! empty( $record ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.success_message');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('general.error_msg');
            $eventData['type']      = 'error';           
        }
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);

    }

    public function updateBillingInfo(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $validations = [
            'billing_info.first_name'   => 'required', 
            'billing_info.last_name'    => 'required',
            'billing_info.address'      => 'required',
            'billing_info.country_id'   => 'required',
            'billing_info.city'         => 'required',
            'billing_info.postal_code'  => 'required',
            'billing_info.phone'        => 'required',
            'billing_info.email'        => 'required|email',
        ];

        if( ! empty($this->states) ){
            $validations['billing_info.state_id'] = 'required';
        }
        
        $this->validate($validations,[ 
            'required_if'   => __('general.required_field'),
            'required'      => __('general.required_field'),
            'email'         => __('general.invalid_email')
        ]);


        $data['profile_id']             = $this->profileId;
        $data['billing_first_name']     = sanitizeTextField($this->billing_info['first_name']);
        $data['billing_last_name']      = sanitizeTextField($this->billing_info['last_name']);
        $data['billing_company']        = sanitizeTextField($this->billing_info['company']);
        $data['billing_phone']          = sanitizeTextField($this->billing_info['phone']);
        $data['billing_email']          = sanitizeTextField($this->billing_info['email']);
        $data['country_id']             = $this->billing_info['country_id'];

       
        if(!empty($this->billing_info['state_id'])){
            $data['state_id']            = $this->billing_info['state_id'];
        }

        $data['billing_city']           = sanitizeTextField($this->billing_info['city']);
        $data['billing_postal_code']    = sanitizeTextField($this->billing_info['postal_code']);
        $data['billing_address']        = sanitizeTextField($this->billing_info['address'], true);


        $record = UserBillingDetail::select('id')->updateOrCreate(
            [
                'profile_id'  => $this->profileId
            ],
            $data
        );
     

        $eventData = [];
        if( ! empty( $record ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.success_message');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';           
        }
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }

    public function update(){
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        $this->profile_settings['first_name'] = sanitizeTextField( $this->profile_settings['first_name'] );
        $this->profile_settings['last_name']  = sanitizeTextField( $this->profile_settings['last_name'] );
        $this->profile_settings['tagline']    = sanitizeTextField( $this->profile_settings['tagline'] );
        $validations = [
            'profile_settings.first_name'    => 'required|alpha_num', 
            'profile_settings.last_name'     => 'nullable|alpha_num',
            'profile_settings.country'       => 'required',
            'profile_settings.zipcode'       => 'required',
        ];

        if($this->userRole == 'seller'){

            $validations['banner']                          = 'nullable|image|mimes:'.join(',', $this->allowImageExt).'|max:'.$this->allowImageSize*1024;
            $validations['profile_settings.seller_type']    = 'required';
            $validations['profile_settings.english_level']  = 'required';
        }

        $this->validate($validations,
            [
                'required'  => __('general.required_field'),
                'max'       => __('general.max_file_size_err',  ['file_size'=> $this->allowImageSize.'MB']),
                'mimes'     => __('general.invalid_file_type',['file_types'=> join(',', $this->allowImageExt)]),
            ]
        );

        $data['user_id']        = $this->userId;
        $data['role_id']        = $this->roleId;
        $data['first_name']     = sanitizeTextField( $this->profile_settings['first_name'] );
        $data['last_name']      = sanitizeTextField( $this->profile_settings['last_name'] );
        $data['description']    = sanitizeTextField( $this->profile_settings['description'], true );
        $data['tagline']        = sanitizeTextField( $this->profile_settings['tagline'] );
        $data['zipcode']        = sanitizeTextField( $this->profile_settings['zipcode'] );
        $data['country']        = $this->profile_settings['country'];

        $profileInfo            = Profile::select('first_name', 'last_name')->where(['user_id' => $this->userId, 'role_id'=> $this->roleId ])->first();
        $newUserName            = ucfirst($data['first_name']) .' '. ucfirst($data['last_name']);

        if($profileInfo->full_name != $newUserName){
            $data['slug']  = $data['first_name'].' '.$data['last_name'];
        }

        if( $this->userRole == 'seller' ){
            $data['seller_type']        = sanitizeTextField( $this->profile_settings['seller_type'] );
            $data['english_level']      = sanitizeTextField( $this->profile_settings['english_level'] );
        }

        $enable_zipcode    = setting('_api.enable_zipcode');
        $enable_zipcode   = !empty( $enable_zipcode ) && $enable_zipcode == '1' ? true : false;

        if ( empty( $enable_zipcode ) ){
            $data['address'] = '';
        } else if(( empty($this->old_zipcode) || (!empty($this->old_zipcode) && $this->old_zipcode != $data['zipcode'] )) ){
            $countryCode = Country::where('name', $data['country'] )->select('short_code')->first();
            $countryCode = $countryCode ? $countryCode->short_code : '';
            $response    = getGeoCodeInfo( $data['zipcode'] , $countryCode);
            
            if ( !empty($response) && $response['type'] == 'success') {
                $data['address'] = !empty( $response ) ? serialize($response['geo_data']) : null;
            } else {
                $response['message']    = __('general.zipcode_error');
                $this->dispatchBrowserEvent('showAlertMessage', $response);
                return false;
            }
        }

        if( $this->banner ){
            $banner_dimensions  = getImageDimensions('profile_banner');
            $banner_path    = $this->banner->store('public/profiles');
            $banner_path    = str_replace('public/', '', $banner_path);
            $banner_name    = $this->banner->getClientOriginalName();
            $mime_type      = $this->banner->getMimeType();
            // $sizes          = generateThumbnails('profiles', $this->banner, $banner_dimensions);
            
            $bannerObject = array(
                'file_name'     => $banner_name,
                'file_path'     => $banner_path,
                'mime_type'     => $mime_type,
                'sizes'         => '',
            );

            $data['banner_image']  = serialize($bannerObject);

        }else{
            $data['banner_image'] =!empty($this->old_banner) ? serialize($this->old_banner) : null;
        }
        $image_dimensions   = getImageDimensions('user_profile');

        if(!empty($this->cropImageUrl)) {
            $bse64 = explode(',', $this->cropImageUrl); 
            $bse64 = trim($bse64[1]);

            if( ! base64_encode( base64_decode( $bse64, true ) ) === $bse64 ) {
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => __('general.invalid_file_type' , ['file_types' => join(',', $this->allowImageExt) ])
                ]);
                return;
            }
            $imageData          = uploadImage('profiles', $this->cropImageUrl, $image_dimensions);
            $data['image']      = !empty($imageData) ? serialize($imageData) : null;

        } elseif( !empty($this->old_image) ){
            if(is_array($this->old_image)){
                $data['image'] = serialize($this->old_image);
            } else { // for manage plain image path
                $image_record  = @unserialize($this->old_image);
                if( $image_record == 'b:0;' || $image_record !== false ){
                    $data['image'] = $this->old_image;
                } else {
                    $imageData['url'] = $this->old_image;
                    foreach($image_dimensions as $size => $dimension){
                        $imageData[$size] = $this->old_image;
                    }
                    $data['image'] = serialize($imageData);
                }
            }
        } elseif( !empty( $this->profile_settings['image'] ) ) {
            $path = public_path().'/storage/'.$this->profile_settings['image'];
            if( file_exists($path) ){
                unlink($path);
            }
            $data['image'] = null;
        }

        $record = Profile::select('id')->updateOrCreate([
            'user_id'  => $this->userId,
            'role_id'  => $this->roleId
        ],$data);

        $this->old_image = $this->profile_settings['image'] = !empty( $data['image'] ) ? $data['image'] : null;

        if( $this->userRole == 'seller' ){
            $record->skills()->select('id')->sync($this->profile_settings['skill_ids']);
            $record->languages()->select('id')->sync($this->profile_settings['language_ids']);
        }

        $eventData = [];
        if( ! empty( $record ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('general.success_message');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';           
        }

        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        $this->cropImageUrl = '';
    }

    public function removePhoto(){
        $this->cropImageUrl = $this->old_image = NULL;
    }

    public function updatedFiles(){
        
        $this->validate([
            'files.*' => 'mimes:'.join(',', $this->allowFileExt).'|max:'.$this->allowFileSize*1024,
        ],[
            'max'   => __('general.max_file_size_err',  ['file_size'=> $this->allowFileSize.'MB']),
            'mimes' => __('general.invalid_file_type',['file_types'=> join(',', $this->allowFileExt)]),
        ]);

        $this->existingFiles = array_merge($this->existingFiles, $this->files);
    }

    public function removeFile( $key ){

        $image_path = public_path().'/storage/'.$this->existingFiles[$key];
        if( file_exists($image_path) ) {
            unlink($image_path);
        }

        if(!empty($this->existingFiles[$key])){
            unset($this->existingFiles[$key]);
        }
    }

    public function updateTab( $tab ){
        
        $tabs = array( 'profile-settings', 'identity-verification', 'billing-information', 'account-settings' );
        if( $this->userRole == 'seller' ){
            array_push($tabs, 'portfolio-settings');
        }

        if(in_array($tab, $tabs)){
            $this->tab = $tab; 
        } else {
            $this->tab = 'profile-settings';
        }
    }
}
