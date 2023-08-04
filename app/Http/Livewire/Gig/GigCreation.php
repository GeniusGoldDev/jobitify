<?php

namespace App\Http\Livewire\Gig;


use App\Models\Country;
use App\Models\Gig\Gig;
use App\Models\Gig\GigPlan;
use Livewire\Component;
use App\Models\Gig\Addon;
use App\Models\Gig\GigFaq;
use App\Rules\OverflowRule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Models\Gig\GigDeliveryTime;
use Illuminate\Validation\Validator;
use App\Models\Taxonomies\GigCategory;

class GigCreation extends Component
{
    use WithFileUploads;

    public $step  = 1;
    public $title               = '';
    public $category            = '';
    public $sub_category        = '';
    public $selected_gig_types  = [];
    public $gig_plans           = [];
    public $gig_faqs            = [];
    public $gig_addons          = [];
    public $selected_addons     = [];
    public $country             = '';
    public $delivery_time       = '';
    public $zipcode             = '';
    public $description         = '';
    public $video_url           = '';
    public $downloadable        = '';
    public $profile_id          = 0;
    public $edit_id             = 0;
    public $allowFileSize       = '';
    public $enable_zipcode      = '';
    public $allowFileExt        = '';
    public $currency_symbol         = '';
    public $galleryFiles            = [];
    public $galleryExistingFiles    = [];
    public $downloadFiles           = [];
    public $downloadExistingFiles   = [];
    public $allowImgFileExt         = [];
    public $allowImgFileSize        = '';
   
    protected $queryString = [
        'edit_id'       => ['except' => 0, 'as'=> 'id'],
        'step'          => ['except' => 1]
    ];

  
    public function mount(){

        if( $this->step > 4 ){
            $this->redirect('create-gig');
        }

        $file_ext               = setting('_general.file_ext');
        $file_size              = setting('_general.file_size');
        $currency               = setting('_general.currency');
        $image_file_size        = setting('_general.image_file_size');
        $image_file_ext         = setting('_general.image_file_ext');
        $enable_zipcode         = setting('_api.enable_zipcode');

        $this->allowFileSize        = !empty( $file_size ) ? $file_size : '3';
        $this->allowFileExt         = !empty( $file_ext ) ?  $file_ext  : [];
        $this->enable_zipcode       = !empty( $enable_zipcode ) ? $enable_zipcode : '';
        $this->allowImgFileExt      = !empty( $image_file_ext ) ?  explode(',', $image_file_ext) : [];
        $this->allowImgFileSize     = !empty( $image_file_size ) ? $image_file_size : '3';

        $currency_detail            = !empty($currency)  ? currencyList($currency) : array();
        if(!empty($currency_detail)){
            $this->currency_symbol        = $currency_detail['symbol']; 
        }
       
        $user                   = getUserRole();
        $this->profile_id       = $user['profileId']; 
        $this->delivery_time    = GigDeliveryTime::select('id','name', 'days')->where('status', 'active')->orderBy('id', 'DESC')->get();
        $seller_addons          = Addon::select('id', 'title', 'price', 'description')->where('author_id', $this->profile_id)->get()->toArray();
        if( !empty($seller_addons) ){

            foreach($seller_addons as $single){

                $this->gig_addons[] = [
                    'id'            => $single['id'],
                    'title'         => $single['title'],
                    'price'         => $single['price'],
                    'description'   => $single['description'],
                ]; 
            }
        }

        if( $this->edit_id > 0 ){
            $this->edit( $this->edit_id, $seller_addons);
        }

        if( empty($this->gig_plans) ){

            for( $i= 1; $i<=3; $i++ ){

                $this->gig_plans[] = [
                    'plan_title'                => '',
                    'plan_price'                => '',
                    'plan_delivery_time'        => '',
                    'plan_description'          => '',
                    'is_featured'               => '',
                    'features'                  => [],
                ];
            }
        }
    }
   
    public function render(){
        
        $data = array();
        switch( $this->step ){

            case(1):
               
                $data['countries']              = Country::select('id','name', 'short_code')->where('status', 'active')->orderBy('name', 'ASC')->get();
                $data['categories']             = GigCategory::select('id','name')->whereNull('parent_id')->where('status', 'active')->orderBy('id', 'DESC')->get();
                if( !empty($this->category) ){
                    $data['sub_categories']   = GigCategory::select('id','name')->where(['parent_id' => $this->category, 'status'=> 'active'])->orderBy('id', 'DESC')->get(); 
                    if($data['sub_categories']->IsEmpty()){
                        $this->sub_category = '';
                        $this->selected_gig_types = [];
                    }
                }
                if( !empty($this->sub_category) ){
                    $data['gig_types']   = GigCategory::select('id','name')->where(['parent_id' => $this->sub_category, 'status'=> 'active'])->orderBy('id', 'DESC')->get(); 
                
                }
                $this->dispatchBrowserEvent('initStep1-js');
            break;
            case(2):
                $this->dispatchBrowserEvent('initStep2-js');
            break;    
            case(3):    
                if(!empty($this->galleryExistingFiles)){
                    foreach($this->galleryExistingFiles as $key=> $single){
                        $this->galleryExistingFiles[$key] = (object) $single;
                    }
                }
                if(!empty($this->downloadExistingFiles)){
                    foreach($this->downloadExistingFiles as $key=> $single){
                        $this->downloadExistingFiles[$key] = (object) $single;
                    }
                }
            break;    
        }

        return view('livewire.gig.gig-creation', $data)->extends('layouts.app');
    }

    public function addnewFaq(){

        $this->gig_faqs[] = array(
            'question'  => '',
            'answer'    => '',
        );
    }

    public function removeFaq( $key ){

        if(isset($this->gig_faqs[$key])){ 
            unset($this->gig_faqs[$key]);
        }
    }

    public function addNewAddon(){

        $this->gig_addons[] = [
            'id'            => '',
            'title'         => '',
            'price'         => '',
            'description'   => '',
        ]; 
    }

    public function removeAddon( $key ){

        if(isset($this->gig_addons[$key])){ 
            unset($this->gig_addons[$key]);
        }
    }

    private function resetInputfields(){
        
        $this->typeUpdate = false;
        $this->title = '';
        $this->type = 'fixed';
        $this->min_price = '';
        $this->max_price = '';
        $this->project_duration = NULL;
        $this->project_skills = [];
        $this->project_languages = [];
        $this->project_category = NULL;
        $this->project_location = NULL;
       
        $this->payment_mode = NULL;
        $this->zipcode = '';
        $this->description = '';
        $this->max_hours = NULL;
        $this->video_url = '';
        $this->project_payout_type = 'fixed';
        $this->no_of_freelancer = NULL;
        $this->expertise_level = NULL;
        $this->galleryFiles           = [];
        $this->galleryExistingFiles   = [];
        $this->downloadfiles           = [];
        $this->downloadExistingFiles   = [];
    }

    public function edit($id, $seller_addons){
        
        $gig    = Gig::where('author_id', $this->profile_id)->findorFail($id);

        $this->title                = $gig->title;
        $this->country              = $gig->country;
        $this->zipcode              = $gig->zipcode;
        $this->description          = json_decode($gig->description);

        if( !$gig->categories->isEmpty() ){

            foreach($gig->categories as $single){
                if( $single['category_level'] == 0 ){
                    $this->category = $single->category_id;
                }elseif( $single['category_level'] == 1 ){
                    $this->sub_category = $single->category_id;
                }elseif( $single['category_level'] == 2 ){
                    $this->selected_gig_types[] = $single->category_id;
                }
            }
        }

        if( !$gig->addons->isEmpty() && !empty($seller_addons) ){

            $selected_addons =  $gig->addons->pluck('id')->toArray();
            if( !empty($seller_addons) ){

                foreach($seller_addons as $key => $single){
                    if(in_array($single['id'], $selected_addons)){
                        $this->selected_addons[] = $key;
                    }
                }
            }
        }
        
        if( !$gig->faqs->isEmpty() ){

            foreach($gig->faqs as $single){
                $this->gig_faqs[] = [
                    'question'  => $single['question'],
                    'answer'    => json_decode($single['answer']),
                ];
            }
        }

        if( !$gig->gig_plans->isEmpty() ){

            foreach($gig->gig_plans as $single){
                $this->gig_plans[] = [
                    'plan_title'                => $single['title'],
                    'plan_price'                => $single['price'],
                    'plan_delivery_time'        => $single['delivery_time'],
                    'plan_description'          => $single['description'],
                    'is_featured'               => !empty($single['is_featured']) ? true : false,
                    'features'                  => [],
                ];
            }
        }

        if( !empty($gig->attachments) ){

            $attachments = unserialize($gig->attachments);
            if(isset($attachments['video_url'])){
                $this->video_url = $attachments['video_url'];
            }
            if(isset($attachments['files'])){
                foreach($attachments['files'] as $key => $single){
                    $this->galleryExistingFiles[$key] = (object) $single;
                }
            }
        }

        if( !empty($gig->downloadable) ){
            $this->downloadable = 1;
            $attachments = unserialize($gig->downloadable);
            if(isset($attachments['files'])){
                foreach($attachments['files'] as $key => $single){
                    $this->downloadExistingFiles[$key] = (object) $single;
                }
            }
        } 
    }

    
    public function updatedgalleryFiles(){
        
        $this->validate([
                'galleryFiles.*' => 'image|mimes:'.join(',', $this->allowImgFileExt).'|max:'.$this->allowImgFileSize*1024
            ],[
                'max'   => __('general.max_file_size_err',  ['file_size'    => $this->allowImgFileSize.'MB']),
                'mimes' => __('general.invalid_file_type',  ['file_types'   => join(',', $this->allowImgFileExt)]),
            ]
        );

        foreach($this->galleryFiles as $single){
            $filename = pathinfo($single->hashName(), PATHINFO_FILENAME);
            $this->galleryExistingFiles[$filename] = (object) $single;
        }
    }

    public function removeGalleryFile( $key ){
        
        if(!empty($this->galleryExistingFiles[$key])){
            unset($this->galleryExistingFiles[$key]);
        }
        if(!empty($this->galleryExistingFiles)){
            foreach($this->galleryExistingFiles as $key=> $single){
                $this->galleryExistingFiles[$key] = (object) $single;
            }
        }
    }

    public function updateddownloadFiles(){
        
        $this->validate([
                'downloadFiles.*' => 'mimes:'.$this->allowFileExt.'|max:'.$this->allowFileSize*1024,
            ],[
                'max'   => __('general.max_file_size_err',  ['file_size'    => $this->allowFileSize.'MB']),
                'mimes' => __('general.invalid_file_type',  ['file_types'   => $this->allowFileExt]),
            ]
        );
        foreach($this->downloadFiles as $single){
            $filename = pathinfo($single->hashName(), PATHINFO_FILENAME);
            $this->downloadExistingFiles[$filename] = (object) $single;
        }
    }


    public function removedownloadFiles( $key ){
        
        if(!empty($this->downloadExistingFiles[$key])){
            unset($this->downloadExistingFiles[$key]);
        }
        if(!empty($this->downloadExistingFiles)){
            foreach($this->downloadExistingFiles as $key=> $single){
                $this->downloadExistingFiles[$key] = (object) $single;
            }
        }
    }

    public function updateStep( $stepno ){
        if( $stepno >= 1 &&  $stepno <= 4 && $stepno > $this->step  ){
            $this->validateGigData();
        }
        $this->step = $stepno;
    }


    public function validateGigData(){

        $validation = $messages = [];

        $this->title        = sanitizeTextField($this->title);
        $this->description  = sanitizeTextField($this->description, true);
        $this->zipcode      = sanitizeTextField($this->zipcode);

        $validation[1] = [
            'title'         => 'required|min:10',
            'category'      => 'required|integer',
            'country'       => 'required',
            'zipcode'       => 'required',
            'description'   => 'required',
        ];
        $messages[1] = [];

        $validation[2] = [
            'gig_plans.*.plan_title'             => 'required|min:3',  
            'gig_plans.*.plan_price'             => ['required','numeric','gt:0', new OverflowRule(0,99999999)],  
            'gig_plans.*.plan_delivery_time'     => 'required|integer',  
            'gig_plans.*.plan_description'       => 'required',  
        ];
        $messages[2] = [
            'required'      => __('gig.fill_field'),
            'min'           => __('gig.fill_field'),
        ];

        if( !empty($this->gig_addons) ){
            $gig_addons = [
                'gig_addons.*.title'  => 'required|min:3',  
                'gig_addons.*.price'  => ['required','numeric','gt:0', new OverflowRule(0,99999999)], 
            ];
            $validation[2] = array_merge($validation[2], $gig_addons);
        }

        $validation[3] = [
            'video_url' => 'nullable|active_url'
        ];
        $messages[3] = [
            'video_url' => __('general.invalid_url')
        ];

        if( !empty($this->gig_faqs) ){

            $validation[4] = [
                'gig_faqs.*.question'  => 'required',  
                'gig_faqs.*.answer'   => 'required',  
            ];
            $messages[4] = [
                'gig_faqs.*.question.required'   => __('gig.faq_question'),
                'gig_faqs.*.answer.required'     => __('gig.faq_answer_placeholder')
            ];
        }

        for( $i=1;  $i<= $this->step; $i++  ){

            if( !empty($validation[$i]) ){
                $this->withValidator(function (Validator $validator) use($i) {
                    if( $validator->fails() ){
                        $this->step = $i;
                    }
                })->validate($validation[$i],$messages[$i]);
            }
        }
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
        
        $this->validateGigData();
        if( !isVerifiedAcc() ){
            $this->dispatchBrowserEvent('showAlertMessage', ['title'=> __('general.error_title'),  'type'=> 'error', 'message'=> __('general.acc_not_verified') ]);
            return false;
        }

        $gig_data = array();
        $gig_data['author_id']          = $this->profile_id;
        $gig_data['title']              = sanitizeTextField(trim($this->title));
        $gig_data['description']        = json_encode( sanitizeTextField($this->description, true) );
        $gig_data['zipcode']            = sanitizeTextField(trim($this->zipcode));
        $gig_data['attachments']        = NULL;
        $gig_data['downloadable']       = NULL;

        if( $this->edit_id > 0 ){
            $gig_old = Gig::select('title')->where('author_id' , $this->profile_id)->find( $this->edit_id);
            if( $gig_old->title != $gig_data['title'] ){
                $gig_data['slug'] = $gig_data['title'];
            }
        }else{
            $gig_data['slug'] = $gig_data['title'];
        }

        $gig_data['country'] = $this->country;
        $gig_data['address'] = null;
        if( $this->enable_zipcode == '1' ){

            $countryCode    = Country::where('name', $this->country )->select('short_code')->first();
            $countryCode    = !empty($countryCode) ? $countryCode->short_code : '';
            $response       =  getGeoCodeInfo($this->zipcode, $countryCode);
            
            if($response['type'] == 'success'){
    
                $gig_data['country']        = $response['geo_data']['country']['long_name'];
                $gig_data['address']        = serialize($response['geo_data']);
    
            }else{
                $this->step = 1;
                $this->dispatchBrowserEvent('showAlertMessage', $response);
                return false;
            }
        }

        $gig = Gig::select('id','slug')->updateOrCreate( ['id'=> $this->edit_id, 'author_id' => $this->profile_id], $gig_data );

        if( !empty($gig) ){

            $galleryAttachments = $downloadAbleAttachments = array();

            if( !empty($this->video_url) ){
                $galleryAttachments['video_url'] = sanitizeTextField($this->video_url); 
            }

            if( !empty($this->galleryExistingFiles) ){
                $image_dimensions = getImageDimensions('gigs');

                foreach($this->galleryExistingFiles as $key => $single){

                    $file = (object) $single;

                    if(method_exists($file,'getClientOriginalName')){
                        $file_path      = $file->store('public/gigs/'.$gig->id);
                        $file_path      = str_replace('public/', '', $file_path);
                        $file_name      = $file->getClientOriginalName();
                        $file_key       = pathinfo($file->hashName(), PATHINFO_FILENAME);
                        $mime_type      = $file->getMimeType();
                        $sizes          = generateThumbnails('gigs/'.$gig->id, $file, $image_dimensions);
                    }else{
                        $file_key   = $key;
                        $file_name  = $file->file_name;
                        $file_path  = $file->file_path;
                        $mime_type  = $file->mime_type;
                        $sizes      = !empty($file->sizes) ? $file->sizes : array();
                    }

                    $galleryAttachments['files'][$file_key]  = (object) array(
                        'file_name' => $file_name,
                        'file_path' => $file_path,
                        'mime_type' => $mime_type,
                        'sizes'     => $sizes,
                    );
                }

                // update attachments
                if( !empty($galleryAttachments) ){
                    $galleryAttachments =  serialize($galleryAttachments); 
                    $gig->attachments = $galleryAttachments;
                }
            }

           
            if(!empty($this->downloadable) && !empty($this->downloadExistingFiles)){
                foreach($this->downloadExistingFiles as $key => $single){

                    $file = (object) $single;

                    if(method_exists($file,'getClientOriginalName')){
                        $file_path      = $file->store('public/gigs-downloadable/'.$gig->id);
                        $file_path      = str_replace('public/', '', $file_path);
                        $file_name      = $file->getClientOriginalName();
                        $file_key       = pathinfo($file->hashName(), PATHINFO_FILENAME);
                        $mime_type      = $file->getMimeType();
                    }else{
                        $file_key   = $key;
                        $file_name  = $file->file_name;
                        $file_path  = $file->file_path;
                        $mime_type  = $file->mime_type;
                    }

                    $downloadAbleAttachments['files'][$file_key]  = (object) array(
                        'file_name'  => $file_name,
                        'file_path'  => $file_path,
                        'mime_type'  => $mime_type,
                    );
                   
                }
                // update attachments
                if( !empty($downloadAbleAttachments) ){
                    $downloadAbleAttachments =  serialize($downloadAbleAttachments); 
                    $gig->downloadable = $downloadAbleAttachments;
                }
            }

            $gig->update();

            $gig_categories = array();
            if( !empty($this->category) ){

                $gig_categories[] = [
                    'gig_id'            => $gig->id,
                    'category_id'       => $this->category,
                    'category_level'    => 0,
                ];
            }
            if( !empty($this->sub_category) ){

               $gig_categories[] = [
                    'gig_id'            => $gig->id,
                    'category_id'       => $this->sub_category,
                    'category_level'    => 1,
                ];
            }
           
            if( !empty($this->selected_gig_types) ){

                foreach($this->selected_gig_types as $id){
                    $gig_categories[] = [
                        'gig_id'            => $gig->id,
                        'category_id'       => $id,
                        'category_level'    => 2,
                    ];
                }
            }
            DB::table('gig_category_link')->where('gig_id', $gig->id)->delete();
            if( !empty($gig_categories) ){
                DB::table('gig_category_link')->insert($gig_categories);
            }

            Addon::select('id')->where('author_id', $this->profile_id)->delete();

            if( !empty($this->gig_addons) ){

                $gig_addons = array();
                foreach( $this->gig_addons as $key=> $single ){
                    $addon = Addon::create([
                        'author_id'     => $this->profile_id,
                        'title'         => sanitizeTextField( $single['title'] ),
                        'price'         => sanitizeTextField( $single['price'] ),
                        'description'   => sanitizeTextField( $single['description'], true ),
                    ]);

                    if( in_array($key, $this->selected_addons) ){
                        $gig_addons[] = $addon->id;
                    }
                }

                if( !empty($gig_addons) ){
                    $gig->addons()->select('id')->sync($gig_addons);
                } 
            }

            if( !empty($this->gig_plans) ){

                GigPlan::select('id')->where('gig_id', $gig->id)->delete();

                foreach( $this->gig_plans as $key=> $single ){
                    GigPlan::create([
                        'gig_id'            => $gig->id,
                        'title'             => sanitizeTextField( $single['plan_title'] ),
                        'description'       => sanitizeTextField( $single['plan_description'] ),
                        'price'             => sanitizeTextField( $single['plan_price'] ),
                        'delivery_time'     => sanitizeTextField( $single['plan_delivery_time'] ),
                        'is_featured'       => !empty($single['is_featured']) ? 1 : 0,
                        'options'           => null,
                    ]);
                }
            }

            if( !empty($this->gig_faqs) ){

                GigFaq::select('id')->where('gig_id', $gig->id)->delete();

                foreach( $this->gig_faqs as $key=> $single ){
                    GigFaq::create([
                        'gig_id'       => $gig->id,
                        'question'     => sanitizeTextField( $single['question'] ),
                        'answer'       => json_encode( sanitizeTextField( $single['answer'], true ) ),
                    ]);
                }
            }
            
        }
        $eventData['title']         =  __('general.success_title');
        $eventData['type']          = 'success';
        $eventData['message']       = __('general.success_message');
        $eventData['redirectUrl']   = route('gig-list');
        $eventData['autoClose']     = 3000;
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        
    } 
}
