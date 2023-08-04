<?php

namespace App\Http\Livewire\Project;

use Carbon\Carbon;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Proposal\Proposal;
use App\Models\Seller\SellerRating;
use App\Models\Package\PackageSubscriber;

class ProjectListing extends Component
{
    use WithPagination;

    public $per_page                = '';
    public $address_format          = '';
    public $search_project          = '';
    public $filter_project          = '';
    public $project_type            = '';
    public $profile_id              = 0;
    public $rm_feature_project      = 0;
    public $package_detail          = [];
    public $package_id              = 0;
    public $currency_symbol         = ''; 
    public $userRole                = ''; 
    public $sellerId                = '';
    public $project_id              = '';
    public $rating_title            = '';
    public $rating_desc             = '';
    public $rating                  = '';

    protected $queryString = [
        'filter_project'  => [ 'except' => '', 'as'=> 'status'],
    ];

    public $review_detail = [
        'user_name'     => '',
        'image'         => '',
        'rating'        => '',
        'avg_rating'    => '',
        'rating_title'  => '',
        'rating_desc'   => '',
    ];

    public function mount(){

        $user = getUserRole();
        $this->profile_id   = $user['profileId']; 
        $this->userRole     = $user['roleName'];
        if( $this->userRole == 'buyer' ){
            
            $package = packageVerify(['id' => $this->profile_id, 'is_featured' => true]);
            if($package['type'] == 'success' && !empty($package['package_options']) ){
                $this->rm_feature_project   = $package['package_options']['rem_quota']['featured_projects'];
                $this->package_detail       = $package['package_options'];
                $this->package_id           = $package['id'];
            }
        }
        
        $address_format         = setting('_general.address_format');
        $currency               = setting('_general.currency');
        $per_page_record        = setting('_general.per_page_record');
        $this->per_page         = !empty( $per_page_record )        ? $per_page_record : 10;
        $this->address_format   = !empty( $address_format )         ? $address_format : 'state_country';
        $currency_detail        = !empty( $currency)                ? currencyList($currency) : array();
        if(!empty($currency_detail)){
            $this->currency_symbol        = $currency_detail['symbol']; 
        }

    }
   
    public function render(){
        
        if($this->userRole == 'buyer'){

            $projects = Project::select( 
                'id',
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
                'status'
            );

            if( !empty($this->filter_project) ){
                $projects = $projects->where('status', $this->filter_project); 
            }

            if( !empty($this->project_type) ){
                $projects = $projects->where('project_type', $this->project_type); 
            }
    
            if( !empty($this->search_project) ){
                $projects = $projects->where(function($query){
                    $query->whereFullText('project_title', $this->search_project);
                });
            }

            $projects = $projects->orderBy('id', 'desc');
            $projects = $projects->with(
                array(
                    'projectLocation:id,name',
                    'expertiseLevel:id,name',
                    'proposals' => function($query) {
                        $query->has('proposalAuthor');
                        $query->select('id', 'project_id', 'author_id','status');
                        $query->whereNotIn('status', array('draft', 'pending'));
                        $query->with(['proposalAuthor:id,image,first_name,last_name','sellerProjectReting:id,corresponding_id,rating']);
                    },
                )
            );
           
            $projects = $projects->where('author_id', $this->profile_id)->paginate($this->per_page);

            $key = 'projects';
        }else{
            
            $proposals = Proposal::select('id','project_id','status', 'resubmit');
            $proposals = $proposals->with('project', function($query){
                $query->select( 
                    'id',
                    'project_title',
                    'slug',
                    'author_id',
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
                    'status'
                )->has('projectAuthor')->with(
                    array(
                        'projectLocation:id,name',
                        'expertiseLevel:id,name',
                        'projectAuthor:id,first_name,last_name'
                    )
                );
            })->whereHas('project', function($query){
                $query->has('projectAuthor');
                if( !empty($this->search_project) ){
                    $query->where(function($sub_query){
                        $sub_query->whereFullText('project_title', $this->search_project);   
                    });
                }
            });

            if( !empty($this->project_type) ){
                $proposals = $proposals->whereHas('project', function($query){
                    $query->where(function($sub_query){
                        $sub_query->where('project_type', $this->project_type);   
                    });
                });
            }
            
            if( !empty($this->filter_project) ){
                if( $this->filter_project == 'cancelled'){
                    $proposals = $proposals->whereIn('status', ['refunded','disputed']); 
                } else {
                    $proposals = $proposals->where('status', $this->filter_project); 
                }

                
            }

            $proposals = $proposals->where('author_id', $this->profile_id)->orderBy('id', 'desc')->paginate($this->per_page);

           $key = 'proposals';
        }
        return view('livewire.project.'.$this->userRole.'-projects', compact($key))->extends('layouts.app');
    }

    public function addReviewPopup( $author_id ='', $project_id =''){
        
        if(!empty($author_id) && !empty($project_id) ) {
            $this->sellerId     = $author_id;
            $this->project_id   = $project_id;
            $this->dispatchBrowserEvent('add-review-popup', 'show');
        }
    }

    public function addReview(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
       
        $projectId      = $this->project_id;
        $sellerId       = $this->sellerId;

        $proposal = Proposal::where(['project_id' => $this->project_id, 'author_id' => $this->sellerId])->whereHas('project', function($query){
            $query->where('author_id', $this->profile_id);
        })->select('id', 'project_id', 'author_id')->first();

        if( !empty($proposal) ){ 
            
            $this->validate([
                'rating_title'  => 'required',
                'rating'        => 'required|numeric|min:1|max:5',
                'rating_desc'   => 'nullable',
            ]);
    
            $add_reating = SellerRating::select('id')->updateOrCreate([
                'seller_id'         => $proposal->author_id,
                'corresponding_id'  => $proposal->id,
                'type'              => 'proposal',
                'buyer_id'          => $this->profile_id,
            ],[
                'seller_id'             => $proposal->author_id,
                'buyer_id'              => $this->profile_id,
                'corresponding_id'      => $proposal->id,
                'type'                  => 'proposal',
                'rating'                => $this->rating,
                'rating_title'          => sanitizeTextField($this->rating_title),
                'rating_description'    => sanitizeTextField($this->rating_desc, true) ,
            ]);
    
            if(!empty($add_reating)){

                $this->dispatchBrowserEvent('add-review-popup', 'hide');
    
                $eventData['title']     = __('general.success_title');
                $eventData['message']   = __('general.success_message');
                $eventData['type']      = 'success';
            }else{
                $eventData['title']     = __('general.error_title');
                $eventData['message']   = __('general.error_msg');
                $eventData['type']      = 'error';
            }
        }else{
            $this->project_id = $this->sellerId = '';
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('general.error_msg');
            $eventData['type']      = 'error';
        }
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }

    public function readReview($proposal_id, $seller_id) {

        $getReview = SellerRating::where(['corresponding_id' => $proposal_id, 'seller_id'=>$seller_id, 'type' => 'proposal' ])->with('user:id,first_name,last_name,image')->first();
        if(! empty($getReview) ){
            $this->review_detail['user_name']       = $getReview->user->full_name;
            $image_path = '';
            if(!empty($getReview->user->image)){
                $image_path = getProfileImageURL($getReview->user->image, '172x172');
            }

            $this->review_detail['image']           = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-172x172.png';
            $this->review_detail['rating']          = !empty($getReview->rating) ? $getReview->rating : 0;
            $this->review_detail['avg_rating']      = !empty($getReview->rating) ? ($getReview->rating/5)*100 : 0;;
            $this->review_detail['rating_title']    = $getReview->rating_title;
            $this->review_detail['rating_desc']     = $getReview->rating_description;
            $this->dispatchBrowserEvent('ReadReviewPopup', 'show');
        } else {
            $this->review_detail = [
                'user_name'     => '',
                'image'         => '',
                'rating'        => '',
                'avg_rating'    => '',
                'rating_title'  => '',
                'rating_desc'   => '',
            ];
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('general.error_msg');
            $eventData['type']      = 'error';
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }
      
    }

    public function updatingSearchProject(){
        $this->resetPage(); 
    }

    public function updatingPerPage(){
        $this->resetPage(); 
    }

    public function updatingfilterProject(){
        $this->resetPage(); 
    }

    public function updatingProjectType(){
        $this->resetPage(); 
    }

    public function makeFeature($id){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $project = Project::where(['author_id'=> $this->profile_id])->find($id);
        
        if(!empty($project) 
        && in_array($project->status, array('publish', 'pending'))
        && $this->rm_feature_project > 0){
            
           
            if( !empty($this->package_detail) ){
               
                $project_featured_days = $this->package_detail['allow_quota']['project_featured_days'];
                $featured_expiry  = Carbon::now()->addDays($project_featured_days)->format('Y-m-d H:i:s');
               
                $project = Project::where(['id'=> $id]);
                $project->update(['is_featured'=> 1, 'featured_expiry' => $featured_expiry]);

                
                $package =  PackageSubscriber::where( ['id'=> $this->package_id] );
                $rm_featured = $this->rm_feature_project -1;
                $package_options = $this->package_detail;
                $package_options['rem_quota']['featured_projects'] = $rm_featured;
                $package->update(['package_options' => serialize($package_options)]);

                $this->rm_feature_project = $rm_featured;
               
            }
        }
    }

    public function destroy($id){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $project = Project::where(['author_id'=> $this->profile_id])->find($id);
        if(!empty($project) && $project->status == 'draft' ||  $project->status == 'pending'){
            $project->delete();
        }
    } 

    public function deleteProposal($id){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $deleteProposal = Proposal::where(['author_id'=> $this->profile_id])->find($id);
        if(!empty($deleteProposal) && $deleteProposal->status == 'draft' ||  $deleteProposal->status == 'pending'){
            $deleteProposal->delete();
        }
    }

    public function DeclineProposal($id){

        $declinedProposal = Proposal::select('id','project_id', 'author_id', 'decline_reason')->with(
            [
                'project'=> function($query){
                    $query->select('id','author_id');
                    $query->with('projectAuthor:id,first_name,last_name,image');
                },
                'proposalAuthor:id,first_name,last_name',
            ]
        )->where(['author_id'=> $this->profile_id, 'status'=> 'declined'])->find($id);
       
        if(!empty($declinedProposal)){
            if(!empty($declinedProposal->project->projectAuthor->image)){
                $image_path = getProfileImageURL($declinedProposal->project->projectAuthor->image, '50x50');
                $author_image = asset('storage/' . $image_path);
            }else{
                $author_image = asset('images/default-user-50x50.png');
            }
            $declinedProposal = array(
                'buyerName'         => $declinedProposal->project->projectAuthor->full_name,
                'buyerImage'        => $author_image, 
                'sellerName'        => __('general.hi_user',['user_name' => $declinedProposal->proposalAuthor->full_name]), 
                'declineReason'     => $declinedProposal->decline_reason,
            );

            $this->dispatchBrowserEvent('declinedProposal', $declinedProposal);
        }
    } 
}
