<?php

namespace App\Http\Livewire\Project;

use App\Models\Role;
use App\Models\User;

use App\Models\Country;
use App\Models\Profile;
use App\Models\Project;
use Livewire\Component;
use App\Rules\OverflowRule;
use Livewire\WithPagination;
use App\Models\EmailTemplate;
use App\Models\FavouriteItem;
use Livewire\WithFileUploads;
use App\Models\Taxonomies\Skill;
use App\Models\Taxonomies\Language;
use App\Models\Taxonomies\ExpertLevel;
use App\Models\Taxonomies\PaymentMode;
use App\Notifications\EmailNotification;
use App\Models\Package\PackageSubscriber;
use Illuminate\Support\Facades\Validator;
use App\Models\Seller\SellerProjectInvite;
use App\Models\Taxonomies\ProjectDuration;
use App\Models\Taxonomies\ProjectLocation;

class ProjectCreation extends Component
{
    use WithPagination, WithFileUploads;

    
    public $typeUpdate = false;
    public $step  = 1;
    public $per_page = '';
    public $address_format = '';
    public $per_page_opt  = [];
    public $searchProject   = '';
    public $profile_id = 0;
    public $edit_id = 0;
    public $title = '';
    public $type = 'fixed';
    public $projet_min_amount = '';
    public $min_price = '';
    public $max_price = '';
    public $project_duration = NULL;
    public $project_skills = [];
    public $project_languages = [];
    public $project_category = NULL;
    public $project_location = NULL;
    public $project_country = NULL;
    public $payment_mode = NULL;
    public $zipcode = '';
    public $description = '';
    public $max_hours = NULL;
    public $video_url = '';
    public $project_payout_type = 'fixed';
    public $no_of_freelancer = NULL;
    public $expertise_level = NULL;
    public $files           = [];
    public $existingFiles   = [];
    public $useTemplate     = false;
    public $parentId;
    public $req_category, $req_duration, $req_description, $req_project_desc, $req_expertlevel, 
           $req_skills, $req_languages, $project_def_status, $enable_zipcode, $def_min_project_amount, $maximum_freelancer;
    
    protected $queryString = [
        'edit_id'       => ['except' => 0, 'as'=> 'id'],
        'step'          => ['except' => 1]
    ];
    public $allowFileSize = '';
    public $allowFileExt  = '';

    protected $listeners = [ 'SelectCategoryId' ];

    public function mount(){
        
        $address_format             = setting('_general.address_format');
        $file_ext                   = setting('_general.file_ext');
        $file_size                  = setting('_general.file_size');
        $per_page_record            = setting('_general.per_page_record');
        $enable_zipcode             = setting('_api.enable_zipcode');
        $step2_validation           = setting('_project.step2_validation');
        $step3_validation           = setting('_project.step3_validation');
        $project_default_status     = setting('_project.project_default_status');
        $maximum_freelancer         = setting('_project.maximum_freelancer');
        $projet_min_amount          = setting('_project.projet_min_amount');
        
        $this->per_page_opt             = perPageOpt();
        $this->maximum_freelancer       = !empty( $maximum_freelancer )         ? $maximum_freelancer : 10;
        $this->address_format           = !empty( $address_format )             ? $address_format : 'state_country';
        $this->per_page                 = !empty( $per_page_record )            ? $per_page_record : 10;
        $step2_validation               = !empty( $step2_validation )           ? $step2_validation : array(); 
        $step3_validation               = !empty( $step3_validation )           ? $step3_validation : array();
        $this->project_def_status       = !empty( $project_default_status )     ? $project_default_status : 'pending'; 
        $this->enable_zipcode           = !empty( $enable_zipcode )             ? $enable_zipcode : ''; 
        $this->def_min_project_amount   = !empty( $projet_min_amount )          ? $projet_min_amount : 0; 
        $this->allowFileSize            = !empty( $file_size )                  ? $file_size : '3';
        $this->allowFileExt             = !empty( $file_ext )                   ?  explode(',', $file_ext)  : [];

        $this->req_expertlevel          = in_array('expertlevel',       $step3_validation );
        $this->req_skills               = in_array('skills',            $step3_validation );
        $this->req_languages            = in_array('languages',         $step3_validation );
        $this->req_duration             = in_array('duration',          $step2_validation );
        $this->req_category             = in_array('category',          $step2_validation );
        $this->req_project_desc         = in_array('project_detail',    $step2_validation );
        $user = getUserRole();
        $this->profile_id            = $user['profileId']; 
       
        if($this->step > 4){
            $this->redirect('create-project');
        }
        if( $this->edit_id > 0 ){
            $this->edit( $this->edit_id );
        }
    }

    public function SelectCategoryId($id){
        $this->project_category = $id;
    }

    public function render(){
        
        $data = array();
        switch($this->step){
            case(1):
                
                if( $this->useTemplate ){

                    $projects = new Project;
                    if( !empty($this->searchProject) ){
                        $projects = $projects->where(function($query){
                            $query->whereFullText('project_title', $this->searchProject);   
                            $query->orWhereFullText('project_description', $this->searchProject);    
                        });
                    }
                    $data['projects'] = $projects->orderBy('id', 'desc')->with(array('projectLocation:id,name', 'expertiseLevel:id,name'))->where('author_id', $this->profile_id)->paginate($this->per_page);
                   
                    $this->dispatchBrowserEvent('initTemplate');
                }

            break;
            case(2):
                $data['payout_type_options']  = [ 
                    'fixed'     => __('project.fixed_payout_opt'), 
                    'milestone' => __('project.milestone_payout_opt'),
                    'both'      => __('project.both_payout_opt') 
                ];
                $data['durations']            = ProjectDuration::select('id','name')->where('status', 'active')->orderBy('id', 'DESC')->get();
                $data['locations']            = ProjectLocation::select('id','name')->where('status', 'active')->orderBy('id', 'DESC')->get();
                $data['countries']            = Country::select('id','name', 'short_code')->where('status', 'active')->orderBy('name', 'ASC')->get();
                $data['payment_modes']        = ['daily' => __('general.daily'), 'weekly' => __('general.weekly'), 'monthly' => __('general.monthly')]; 
               
                $this->dispatchBrowserEvent('initStep2-js');

            break;
            case(3):
                $data['skills']               = Skill::select('id','name')->where('status', 'active')->orderBy('id', 'DESC')->get();
                $data['languages']            = Language::select('id','name')->where('status', 'active')->orderBy('name', 'ASC')->get();
                $data['expertise_levels']     = ExpertLevel::select('id','name')->where('status', 'active')->orderBy('id', 'DESC')->get();
                
                $this->dispatchBrowserEvent('initStep3-js');
                
            break;
            case(4):

                $id = $this->edit_id > 0 ? $this->edit_id : 0;
                $project_skills = $project_languages = array();
                
                $project_data = Project::select('id')->with(['skills:id','languages:id'])->where('author_id', $this->profile_id)->findOrFail($id);
                
                if(!$project_data->skills->isEmpty()){
                   $project_skills =  $project_data->skills->pluck('id')->toArray();
                }
                
                if(!$project_data->languages->isEmpty()){
                   $project_languages =  $project_data->languages->pluck('id')->toArray();
                }

                $recommended_freelancers_option = array('skills', 'languages');
                
                $project_recomended_freelancer_opt     = setting('_project.project_recomended_freelancer_opt');
                
                if( !empty($project_recomended_freelancer_opt) ){
                    $recommended_freelancers_option = $project_recomended_freelancer_opt;
                }

                $profile = new Profile;
                $profile = $profile->select('id', 'first_name','slug', 'last_name', 'image', 'tagline', 'description');
                
                $profile = $profile->with('user:id')->whereHas(
                    'user', function($query){
                        $query->select('id');
                        $query->whereNotNull( 'email_verified_at'); 
                        $query->with('userAccountSetting:id,user_id')->whereHas(
                            'userAccountSetting', function($query){
                                $query->select('id','user_id');
                                $query->where( 'verification', 'approved'); 
                            }
                        );
                    }
                );

                if(!empty($recommended_freelancers_option)){
                    $profile = $profile->where( function($query) use( $project_skills, $recommended_freelancers_option, $project_languages) {

                        if( in_array('skills', $recommended_freelancers_option) ){
                            $query = $query->whereHas(
                                'skills', function($subquery) use ($project_skills){
                                    if(!empty($project_skills)){
                                        $subquery->whereIn('skill_id', $project_skills);
                                    }
                                }
                            );
                        }

                        if( in_array('languages', $recommended_freelancers_option) ){
                            $query = $query->orWhereHas(
                                'languages', function($subquery2) use ($project_languages){
                                    if(!empty($project_languages)){
                                        $subquery2->whereIn('language_id', $project_languages);
                                    }
                                }
                            );
                        }
                    });
                }

               $profile = $profile->withCount('profile_visits')->withAvg('ratings','rating')->withCount('ratings');
               
                $data['freelancers']        =  $profile->where('role_id', Role::select('id')->where('name','seller')->first()->id)->where('id', '!=', $this->profile_id)->paginate($this->per_page);
                $data['favourite_sellers']  = FavouriteItem::select('corresponding_id')->where(['user_id' => $this->profile_id, 'type' => 'profile'])->pluck('corresponding_id')->toArray();
                $data['invited_sellers']    = SellerProjectInvite::select('seller_id')->where('project_id', $id)->pluck('seller_id')->toArray();
            break;    
        }

        if(!empty($this->existingFiles)){
            foreach($this->existingFiles as $key=> $single){
                $this->existingFiles[$key] = (object) $single;
            }
        }
        return view('livewire.project.project-creation', $data)->extends('layouts.app');
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
        $this->project_country = NULL;
        $this->payment_mode = NULL;
        $this->zipcode = '';
        $this->description = '';
        $this->max_hours = NULL;
        $this->video_url = '';
        $this->project_payout_type = 'fixed';
        $this->no_of_freelancer = NULL;
        $this->expertise_level = NULL;
        $this->files           = [];
        $this->existingFiles   = [];
    }

    public function cloneProject($id){
        
        if( !isVerifiedAcc() ){
            $this->dispatchBrowserEvent('showAlertMessage', ['title'=> __('general.error_title'),  'type'=> 'error', 'message'=> __('general.acc_not_verified') ]);
            return false;
        }
        $package_detail = packageVerify(['id' => $this->profile_id, 'posted_project' => true]);
        
        if( $package_detail['type'] == 'error' ){

            $package_detail['autoClose'] = 3000;
            $this->dispatchBrowserEvent('showAlertMessage', $package_detail);
            return false;
        }
        $this->resetInputfields();
        $this->edit($id, false);
        $project_id = $this->update('draft', true);
        $this->edit_id = $project_id;
        $this->step = 2;
        $this->useTemplate = false;
    }

    public function edit($id, $is_edit = true ){
        
        $project    = Project::where('author_id', $this->profile_id)->find($id);

        if(!empty($project)){
             
            $this->title                = empty($this->title)                       ? $project->project_title                   : $this->title;
            $this->type                 = !$this->typeUpdate                        ? $project->project_type                    : $this->type;
            $this->description          = empty($this->description)                 ? json_decode($project->project_description) : $this->description;
            $this->payment_mode         = empty($this->payment_mode)                ? $project->project_payment_mode            : $this->payment_mode;
            $this->max_hours            = empty($this->max_hours)                   ? $project->project_max_hours               : $this->max_hours;
            $this->min_price            = empty($this->min_price)                   ? $project->project_min_price               : $this->min_price;
            $this->max_price            = empty($this->max_price)                   ? $project->project_max_price               : $this->max_price;
            $this->project_duration     = empty($this->project_duration)            ? $project->project_duration                : $this->project_duration;
            $this->no_of_freelancer     = empty($this->no_of_freelancer)            ? $project->project_hiring_seller        : $this->no_of_freelancer;
            $this->expertise_level      = empty($this->expertise_level)             ? $project->project_expert_level            : $this->expertise_level;
            $this->project_location     = empty($this->project_location)            ? $project->project_location                : $this->project_location;
            $this->project_category     = empty($this->project_category)            ? $project->project_category                : $this->project_category;
            $this->project_country      = empty($this->project_country)             ? $project->project_country                 : $this->project_country;
            $this->zipcode              = empty($this->zipcode)                     ? $project->country_zipcode                 : $this->zipcode;
            $this->emit('updateCategroyId', $this->project_category);
            if($is_edit){
               $this->edit_id  = $id;
            }
           
           
            if(!$project->skills->isEmpty() && empty($this->project_skills)){
                $skills =  $project->skills->makeHidden('pivot')->pluck('id')->toArray();
                foreach($skills as $id){
                    if(!in_array($id, $this->project_skills)){
                        $this->project_skills[] = $id;
                    }
                }
            }

            if(!$project->languages->isEmpty() && empty($this->project_languages)){
                $languages =  $project->languages->makeHidden('pivot')->pluck('id')->toArray();
                foreach($languages as $id){
                    if(!in_array($id, $this->project_languages)){
                        $this->project_languages[] = $id;
                    }
                }
            }
            
            if(empty($this->existingFiles)){
                if(!empty($project->attachments)){
                    $attachments = unserialize($project->attachments);
                    if(isset($attachments['video_url'])){
                    $this->video_url = empty($this->video_url) ?  $attachments['video_url'] : $this->video_url;
                    }
                    if(isset($attachments['files'])){
                        foreach($attachments['files'] as $key => $single){
                            if(!in_array($key,$this->existingFiles)){
                                $this->existingFiles[$key] = (object) $single;
                            }
                        }
                    }
                }
            }else{
                foreach($this->existingFiles as $key=> $single){
                    $this->existingFiles[$key] = (object) $single;
                }
            }
            
        }else{
            $this->edit_id = 0;
        }
    }

    public function updatedFiles(){
       
        $this->validate(
            [
                'files.*' => 'mimes:'.join(',', $this->allowFileExt).'|max:'.$this->allowFileSize*1024,
            ],[
                'max'   => __('general.max_file_size_err',  ['file_size'    => $this->allowFileSize.'MB']),
                'mimes' => __('general.invalid_file_type',  ['file_types'   => join(',', $this->allowFileExt)]),
            ]
        );
        
        foreach($this->files as $single){
            $filename = pathinfo($single->hashName(), PATHINFO_FILENAME);
            $this->existingFiles[$filename] = (object) $single;
        }
        
    }

    public function updatedType(){
        $this->typeUpdate = true;
    }

    public function removeFile( $key ){

        if(!empty($this->existingFiles[$key])){
            unset($this->existingFiles[$key]);
        }
        if(!empty($this->existingFiles)){
            foreach($this->existingFiles as $key=> $single){
                $this->existingFiles[$key] = (object) $single;
            }
        }
    }

    public function updateStep( $stepno ){

        if($stepno > 1 &&  $stepno <= 4 && $stepno > $this->step  ){
            $this->validateProjectData();
        }
        $this->step = $stepno;
    }

    public function updatingSearchProject(){
        $this->resetPage(); 
    }

    public function updatingPerPage(){
        $this->resetPage(); 
    }

    public function validateProjectData(){

        $allSteps = $validated  = array();
        $this->title        = sanitizeTextField(trim($this->title));
        $this->description  = sanitizeTextField($this->description, true);
        $this->zipcode      = sanitizeTextField(trim($this->zipcode));
        
        // step2 inputs && rules
        $allSteps[2]['input']['title']                = $this->title;
        $allSteps[2]['input']['project_location']     = $this->project_location;
        $allSteps[2]['input']['video_url']            = $this->video_url;
        $allSteps[2]['input']['type']                 = $this->type;
        
        $allSteps[2]['rule']['title']                 = 'required|min:5';
        
        if( $this->req_project_desc ){
            $allSteps[2]['input']['description']      = $this->description;
            $allSteps[2]['rule']['description']       = 'required';
        }
        
        if(  $this->req_category ){
            $allSteps[2]['input']['project_category']     = $this->project_category;
            $allSteps[2]['rule']['project_category']      = 'required|integer'; 
        }
        
        $allSteps[2]['rule']['project_location']      = 'required|integer';
        
        if(  $this->req_duration ){
            $allSteps[2]['input']['project_duration']     = $this->project_duration;
            $allSteps[2]['rule']['project_duration']      = 'required|integer'; 
        }

        if( $this->type == 'fixed' ){
            $allSteps[2]['input']['project_payout_type']     = $this->project_payout_type;
            $allSteps[2]['rule']['project_payout_type']      = 'required'; 
        }

        $allSteps[2]['rule']['video_url']             = 'nullable|active_url'; 
        $allSteps[2]['rule']['type']                  = 'required';

        $allSteps[2]['input']['min_price']        = $this->min_price;
        $allSteps[2]['input']['max_price']        = $this->max_price;

        if( $this->type == 'fixed' ){
                $allSteps[2]['rule']['min_price']     = ['required','numeric','gt:0','min:'.$this->def_min_project_amount, new OverflowRule(0,99999999)];
        } else {
            $allSteps[2]['rule']['min_price']         = ['required','numeric','gt:0', new OverflowRule(0,99999999)];
        }

        $allSteps[2]['rule']['max_price']         = ['required','numeric','min:1','gte:min_price',new OverflowRule(0,99999999)];
        
        if( $this->type == 'hourly' ){

            $allSteps[2]['input']['payment_mode']         = $this->payment_mode;
            $allSteps[2]['input']['max_hours']            = $this->max_hours;
            $allSteps[2]['rule']['payment_mode']          = 'required';
            $allSteps[2]['rule']['max_hours']             = 'required|min:1|gt:0|integer';
        }

        if( $this->project_location == '3' ){
            $allSteps[2]['input']['project_country']  = $this->project_country;
            $allSteps[2]['rule']['project_country']   = 'required';

            if( $this->enable_zipcode == '1' ) {
                $allSteps[2]['input']['zipcode']          = $this->zipcode;
                $allSteps[2]['rule']['zipcode']           = 'required';
            }

        }
        
        // step3 inputs & rules
        $allSteps[3]['input']['no_of_freelancer']       = $this->no_of_freelancer;
        
        $allSteps[3]['rule']['no_of_freelancer']        = 'required|integer'; 
        if($this->req_expertlevel){
            $allSteps[3]['input']['expertise_level']        = $this->expertise_level;
            $allSteps[3]['rule']['expertise_level']         = 'required|integer'; 
        }
        
        if( $this->req_skills ){
            $allSteps[3]['input']['project_skills']         = $this->project_skills;
            $allSteps[3]['rule']['project_skills']          = 'required';
        }
        
        if( $this->req_languages ){
            $allSteps[3]['input']['project_languages']      = $this->project_languages;
            $allSteps[3]['rule']['project_languages']       = 'required';
        }

        for($i=2;  $i<= $this->step; $i++  ){

            $inputs      = $allSteps[$i]['input'];  
            $rules       = $allSteps[$i]['rule'];  
            $validator   = Validator::make($inputs, $rules);
            
            if($validator->fails()){
                $failedRules    = $validator->failed();
                $category_req   = isset($failedRules['project_category']);
                $this->emit('validateError', $category_req);

                $this->step = $i;
                $validator->validate();
                break; 
            }
            $validated = array_merge($validated, $validator->validated());
        }
        return $validated;
    }

    public function startProject( $value ='' ){
        
        $this->resetPage(); 
        if($value == ''){
            $this->step = 1;
            $this->useTemplate = false;
        }elseif( $value == 'new' ){
            $this->step = 2;
        }elseif($value == 'template' ){
            $this->step = 1;
            $this->useTemplate = true;
        }
    }

    public function update( $status = '', $clone = false){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $this->validateProjectData();

        if( !isVerifiedAcc() ){
            $this->dispatchBrowserEvent('showAlertMessage', ['title'=> __('general.error_title'),  'type'=> 'error', 'message'=> __('general.acc_not_verified') ]);
            return false;
        }
        
        $package_detail = packageVerify(['id' => $this->profile_id, 'posted_project' => true]);
        
        if( $package_detail['type'] == 'error' ){
            
            $package_detail['autoClose'] = 3000;
            $this->dispatchBrowserEvent('showAlertMessage', $package_detail);
            return false;
        }

        if( $status == ''){
            $status = $this->project_def_status;
        }else{
            $status = 'draft';
        }
       
        $project_title          = sanitizeTextField(trim($this->title));
        $project_description    = !empty($this->description) ? json_encode( sanitizeTextField($this->description, true) ) : '';

        $project_data = array(
            'author_id'                 =>  $this->profile_id,
            'project_category'          =>  $this->project_category,
            'project_title'             =>  $project_title,
            'project_type'              =>  $this->type,
            'attachments'               =>  NULL,
            'project_payout_type'       =>  $this->type == 'fixed' ? $this->project_payout_type : 'hourly' , 
            'project_description'       =>  $project_description,
            'project_payment_mode'      =>  sanitizeTextField( $this->payment_mode ),
            'project_max_hours'         =>  sanitizeTextField( $this->max_hours ),
            'project_min_price'         =>  sanitizeTextField( $this->min_price ),
            'project_max_price'         =>  sanitizeTextField( $this->max_price ),
            'project_hiring_seller'     =>  sanitizeTextField( $this->no_of_freelancer ),
            'project_expert_level'      =>  sanitizeTextField( $this->expertise_level ),
            'project_location'          =>  sanitizeTextField( $this->project_location ),
            'project_duration'          =>  sanitizeTextField( $this->project_duration ),
            'status'                    => $status,
        );

        if($this->edit_id > 0){
           $project_old = Project::select('project_title')->where('author_id' , $this->profile_id)->find( $this->edit_id);
           if($project_old->project_title != $project_title){
                $project_data['slug'] = $project_title;
           }
        }else{
            $project_data['slug'] = $project_title;
        }

        $project_data['project_country']  = $this->project_country;
        if( $this->project_location == '3' && !empty($this->project_country) &&  !empty($this->zipcode) ){
            $countryCode    = Country::where('name', $this->project_country )->select('short_code')->first();
            $countryCode    = $countryCode ? $countryCode->short_code : '';
            $response       =  getGeoCodeInfo($this->zipcode, $countryCode);
            
           if( $response['type'] == 'success' ){

                $project_data['project_country']        = $response['geo_data']['country']['long_name'];
                $project_data['country_zipcode']        = sanitizeTextField( $this->zipcode );
                $project_data['address']                = serialize($response['geo_data']);

            }else{
                $this->step = 2;
                $this->dispatchBrowserEvent('showAlertMessage', $response);
                return false;
            }
        }

        $attachments = array();

        if( !empty($this->video_url) ){
            $attachments['video_url'] =  $this->video_url; 
        } 

        $project = Project::select('id','slug')->updateOrCreate( ['id'=> $this->edit_id, 'author_id' => $this->profile_id], $project_data );

        
        if( !empty($this->existingFiles) ){
            foreach($this->existingFiles as $key => $single){

                $file = (object) $single;

                if(method_exists($file,'getClientOriginalName')){
                    $file_path      = $file->store('public/projects/'.$project->id);
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

                $attachments['files'][$file_key]  = (object) array(
                    'file_name'  => $file_name,
                    'file_path'  => $file_path,
                    'mime_type'  => $mime_type,
                );
                
            }
        }

        // update attachments
        if( !empty($attachments) ){
            $attachments =  serialize($attachments); 
            $project->attachments = $attachments;
            $project->update();
        }

        // deduct project post limit from buyer package
        if( $status!='draft' && !empty($package_detail['id']) ){
            $package =  PackageSubscriber::where( ['id'=> $package_detail['id']] );
            $package_options = $package_detail['package_options'];
            $package_options['rem_quota']['posted_projects'] = $package_options['rem_quota']['posted_projects'] - 1;
            $package->update(['package_options' => serialize($package_options)]);
        }

        if( !empty($this->project_skills) ){
            $project->skills()->select('id')->sync($this->project_skills);
        }

        if( !empty($this->project_languages) ){
            $project->languages()->select('id')->sync($this->project_languages);
        }

        if(!$clone){
            $this->step = 4;
            $this->edit_id = $project->id;
        }else{
            return $project->id;
        }

        // triggered email when project posted in pending status
        if( $status == 'pending' ){
            $this->notifyEmailProjectCreated( $project->slug );
        }

        if( $status == 'draft' ){
            return redirect()->route('project-listing');
        }
    }  

    public function favouriteSeller( $id ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        favouriteItem($this->profile_id, $id,'profile');
    }

    public function  inviteSeller( $id ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        
        SellerProjectInvite::select('id')->updateOrCreate([
            'project_id'    => $this->edit_id,
            'seller_id'     => $id,
        ],[
            'project_id'    => $this->edit_id,
            'seller_id'     => $id,
        ]);
        // send email to seller
        $userProfile    = Profile::whereId($id)->select('id','first_name','last_name','role_id','user_id')->with('user')->first();
        $email_template = EmailTemplate::select('content')->where(['type' => 'project_invite_request' , 'status' => 'active', 'role' => 'seller'])->latest()->first();
        $projectInfo    = Project::whereId($this->edit_id)->select('project_title')->first();

        if(!empty($email_template)){
            $template_data              =  unserialize($email_template->content);
            $params                     = array();
            $params['template_type']    = 'project_invite_request';
            $params['email_params']     = array(
                'user_name'             => $userProfile->full_name,
                'project_title'         => $projectInfo->project_title,
                'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
            );
            try {
                $userProfile->user->notify(new EmailNotification($params));
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => $e->getMessage(),
                    'autoClose' => 10000,
                ]);
            }
        }
    }

    public function notifyEmailProjectCreated($project_slug = ''){

        $profileInfo = Profile::select('id','first_name','last_name','user_id')->whereId($this->profile_id)->with('user')->first();

        $email_templates = EmailTemplate::select('content','role')
        ->where(['type' => 'project_posted' , 'status' => 'active'])
        ->whereIn('role' ,['buyer','admin'])
        ->get();
        
        if( !$email_templates->isEmpty() ){
            foreach( $email_templates as $template ){
                
                $template_data              =  unserialize($template->content);
                $params                     = array();
                $params['template_type']    = 'project_posted';
                $params['email_params']     = array(
                    'user_name'             => $profileInfo->full_name,
                    'project_link'          => route('project-detail',['slug' => $project_slug]),
                    'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                    'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                    'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
                );
                $notifyUser = '';
                if( $template->role == 'admin' ){

                    $notifyUser = User::whereHas(
                        'roles', function($q){
                            $q->where('name', 'admin');
                        }
                    )->latest()->first();
                }else {
                    $notifyUser = $profileInfo->user;
                }

                try {
                    $notifyUser->notify(new EmailNotification($params));
                } catch (\Exception $e) {
                    $this->dispatchBrowserEvent('showAlertMessage', [
                        'type'      => 'error',
                        'title'     => __('general.error_title'),
                        'message'   => $e->getMessage(),
                        'autoClose' => 10000,
                    ]);
                }
            }
        }
    }
}
