<?php

namespace App\Http\Livewire\FavouriteItems;


use Livewire\Component;
use App\Models\Gig\GigPlan;
use Livewire\WithPagination;
use App\Models\FavouriteItem;
use App\Models\Proposal\Proposal;

class FavouriteItems extends Component
{
    use WithPagination;
    public $filter_by       = '';
    public $profile_id      = '';
    public $per_page        = '';
    public $currency_symbol = '';
    public $address_format  = '';
    public $roleName        = '';
    public $search          = '';

    public function mount(){

        $user = getUserRole();
        $this->profile_id       = !empty( $user['profileId'] ) ? $user['profileId'] : '';
        $this->role_name        = !empty( $user['roleName'] ) ? $user['roleName'] : '';
        $currency               = setting('_general.currency');
        $per_page_record        = setting('_general.per_page_record');
        $address_format         = setting('_general.address_format');
        $this->address_format   = !empty( $address_format )  ? $address_format : 'state_country';

        $this->per_page         = !empty( $per_page_record ) ? $per_page_record : 10;
        $currency_detail        = !empty( $currency)    ? currencyList($currency) : array();
        $this->filter_by        = $this->role_name == 'seller' ? 'project' : 'profile';
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol'];
        }
    }

    public function render(){

        $items = FavouriteItem::where(['user_id' => $this->profile_id, 'type' => $this->filter_by]);

        if( $this->filter_by == 'project' ){
            $items = $items->with('projects', function($query){
                $query->select(
                    'id','author_id','project_title', 'slug', 'updated_at', 'project_type', 'project_country',
                    'project_min_price', 'project_location', 'project_expert_level', 'project_duration',
                    'project_max_price', 'address', 'project_hiring_seller', 'is_featured', 'status',
                )->with([
                    'projectAuthor:id,first_name,last_name,image',
                    'projectLocation:id,name', 'expertiseLevel:id,name',
                    'proposals' => function ($query) {
                        $query->where('author_id', $this->profile_id);
                        $query->select('id','author_id','project_id','status','decline_reason');
                    }
                ]);
            });
            if(!empty($this->search)){
                $items = $items->whereHas('projects', function($query){
                    $query->whereFullText('project_title', $this->search);
                });
            }
        } elseif( $this->filter_by == 'gig' ){
            $items = $items->with('gigs', function($query){
                $query->select('id','author_id', 'title', 'slug','address','attachments', 'status');
                $query->with([
                    'gigAuthor:id,user_id,first_name,last_name,slug',
                    'gigAuthor.user.userAccountSetting:id,user_id,verification',
                ]);
                $query->withCount('gig_visits')->withAvg('ratings','rating')->withCount('ratings');
                $minumumValue = GigPlan::select('price')
                ->whereColumn('gig_plans.gig_id', 'gigs.id')
                ->orderBy('price', 'asc')
                ->limit(1);
                $query->addSelect(['minimum_price' => $minumumValue]);
            })->whereHas('gigs', function($query){
                $query->where('status', 'publish');
                if(!empty($this->search)){
                    $query->whereFullText('title', $this->search);
                }
            });

        } elseif( $this->filter_by == 'profile'){
            $items = $items->with('sellers', function($query){
                $query->select('id','user_id','first_name', 'last_name','slug', 'image', 'tagline', 'description', 'address');
                $query->with(['user:id','user.userAccountSetting:id,user_id,hourly_rate']);
                $query->withCount('profile_visits');
                $query->withAvg('ratings','rating')->withCount('ratings');
            })->has('sellers');
            if(!empty($this->search)){
                $items = $items->whereHas('sellers', function($query){
                    $query->whereFullText('first_name', $this->search)->orWhereFullText('last_name', $this->search);
                });
            }
        }

        $items = $items->orderBy('id', 'desc')->paginate($this->per_page);

        return view('livewire.favourite-items.favourite-items', compact('items'))->extends('layouts.app');
    }

    public function updatedFilterBy(){
        $this->resetPage();
        $this->search = '';
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function saveItem($corresponding_id){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        favouriteItem($this->profile_id, $corresponding_id, $this->filter_by);
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
