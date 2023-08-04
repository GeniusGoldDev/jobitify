<?php

namespace App\Http\Livewire\Components;

use App\Models\Role;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FavouriteItem;

class SearchSellers extends Component
{
    use WithPagination;
    protected $listeners = ['ApplySearchFilter' => 'searchFilter'];


    public $selected_skills    = [];
    public $keyword            = '';
    public $selected_languages = '';

    public $seller_min_hr_rate = '';
    public $seller_max_hr_rate = '';
    public $order_by           = 'date_desc';
    public $profile_id         = '';
    public $per_page           = '';

    public $currency_symbol     = '';
    public $date_format         = '';
    public $def_min_hr_rate     = '';
    public $def_max_hr_rate     = '';
    public $isloadedPage        = false;
    public $roleName            = '';
    public $address_format      = '';

    public function mount( $per_page, $currency_symbol, $date_format, $seller_min_hr_rate, $seller_max_hr_rate, $keyword, $address_format ){
        $this->address_format   = $address_format;
        $this->per_page         = $per_page;
        $this->currency_symbol  = $currency_symbol;
        $this->date_format      = $date_format;
        $this->keyword          = $keyword;
        $this->seller_min_hr_rate = $this->def_min_hr_rate = $seller_min_hr_rate;
        $this->seller_max_hr_rate = $this->def_max_hr_rate = $seller_max_hr_rate;
        $user = getUserRole();
        $this->profile_id         = !empty($user['profileId']) ? $user['profileId'] : 0;
        $this->roleName         = !empty($user['roleName']) ? $user['roleName'] : 0;

    }

    public function loadSellers(){
        $this->isloadedPage = true;
    }

    public function render(){

        $sellers            = [];
        $favourite_sellers  = [];
        if( $this->isloadedPage ){

            $profile = new Profile;
            $profile = $profile->select('id','user_id', 'slug', 'first_name', 'last_name', 'image', 'tagline','address','description');
        
            if( !empty($this->selected_skills) ){
                $selected_skills = $this->selected_skills;
                $profile = $profile->whereHas(
                    'skills', function($query) use ( $selected_skills ){
                        if( !empty($selected_skills) ){
                            $query->whereIn( 'skill_id', $selected_skills );
                        }
                    }
                );
            }

            if( !empty($this->keyword) ){
                $profile->where(function($query){
                    $query->whereFullText('first_name',   $this->keyword);
                    $query->orWhereFullText('last_name',  $this->keyword);
                    $query->orWhereFullText('tagline',    $this->keyword);
                    $query->orWhereFullText('description', $this->keyword);
                });
            }
            
            if( !empty($this->selected_languages) ){

                $selected_languages = $this->selected_languages;
                $profile = $profile->with('languages:id')->whereHas(
                    'languages', function($query) use ( $selected_languages ){
                        $query->whereIn( 'language_id', $selected_languages );
                    }
                );
            }

            $profile = $profile->with([
                'skills:id,name',
                'user' => function($query){
                    $query->select('id');
                },
                'user.userAccountSetting' => function($query){
                    $query->select('id','user_id','verification','hourly_rate','show_image');
                    if( $this->order_by == 'price_desc' ){
                        $query->orderBy('hourly_rate', 'desc');
                    }elseif( $this->order_by == 'price_asc' ){
                        $query->orderBy('hourly_rate', 'asc');
                    }
                }])
            ->whereHas('user', function($query){
                $query->whereNotNull( 'email_verified_at');
            })
            ->whereHas('user.userAccountSetting', function($query) {
                    $query->where( 'verification', 'approved'); 
                    $query->whereBetween('hourly_rate', [ $this->seller_min_hr_rate, $this->seller_max_hr_rate ] );
            });
        
            if( !empty($this->selected_english_level) ){
                $profile = $profile->whereIn('english_level', $this->selected_english_level); 
            }

            if( !empty($this->selected_seller_types) ){
                $profile = $profile->whereIn('seller_type', $this->selected_seller_types); 
            }

            if( !empty($this->selected_location) ){
                $profile = $profile->where('country', $this->selected_location); 
            }

        
            if( $this->order_by == 'date_desc' ){
                $profile = $profile->orderBy('created_at', 'desc');
            }

            if( $this->order_by == 'visits_desc' ){
                $profile = $profile->withCount('profile_visits')->orderByDesc("profile_visits_count");
            }else{
                $profile = $profile->withCount('profile_visits');
            }
            
            $profile = $profile->withAvg('ratings','rating')->withCount('ratings');

            $profile = $profile->where('role_id', Role::select('id')->where('name','seller')->first()->id);
            if( $this->profile_id ){
                $profile =  $profile->where('id', '!=', $this->profile_id);
            }

            $profile->orderBy('is_featured', 'desc');

            $sellers = $profile->paginate($this->per_page);

            if( $this->profile_id ){
                $favourite_sellers  = FavouriteItem::select('corresponding_id')->where('user_id', $this->profile_id)->pluck('corresponding_id')->toArray();
            }

            $this->dispatchBrowserEvent('totalFoundResult', ['total_count' => $sellers->count(), 'keyword' => clean( $this->keyword ) ] );

        }
        
        return view('livewire.components.search-sellers', compact('sellers','favourite_sellers'));
    }

    public function searchFilter($data){

        $type = !empty($data['type']) ? $data['type'] : '';
        if(in_array($type, ['keyword', 'skills', 'seller_type', 'english_level', 'languages', 'pricerange', 'location'])){
            $this->resetPage();
        }

        switch($type){
            case 'keyword':
                $this->keyword                  = !empty($data['keyword']) ? $data['keyword'] : '';
            break;
            case 'skills':
                $this->selected_skills          = !empty($data['skills']) ? $data['skills']: [];
            break;
            case 'seller_type':
                $this->selected_seller_types    = !empty($data['seller_types']) ? $data['seller_types']:[];
            break;
            case 'english_level':
                $this->selected_english_level   = !empty($data['english_levels']) ? $data['english_levels']:[];
            break;
            case 'languages':
                $this->selected_languages       = !empty($data['languages']) ? $data['languages'] : [];
            break;
            case 'pricerange':
                $this->seller_min_hr_rate       = !empty($data['min_price']) ? $data['min_price'] : '';
                $this->seller_max_hr_rate       = !empty($data['max_price']) ? $data['max_price'] : '';
            break;
            case 'location':
                $this->selected_location        = !empty($data['location']) ? $data['location'] : '';
            break;
            case 'orderby':
                $this->order_by                 = !empty($data['orderby']) ? $data['orderby'] : '';
            break;
            case 'clear_filter':
                $this->clearFilter();
            break;
            default:
            break;
        }
    }

    public function saveItem($id){
        if($this->roleName == 'buyer'){
            favouriteItem( $this->profile_id, $id, 'profile');
        } else {
            $eventData              = [];
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('general.login_error');
            $eventData['type']      = 'error';
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }
    }

    public function clearFilter(){
        $this->keyword                  = '';
        $this->selected_skills          = [];
        $this->selected_seller_types    = [];
        $this->selected_english_level   = [];
        $this->selected_languages       = [];
        $this->seller_min_hr_rate       = $this->def_min_hr_rate;
        $this->seller_max_hr_rate       = $this->def_max_hr_rate;
        $this->selected_location        = '';
    }
}
