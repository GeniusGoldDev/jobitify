<?php

namespace App\Http\Livewire\Gig;

use App\Models\Gig\Gig;
use App\Models\Gig\GigPlan;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FavouriteItem;

class SearchGigs extends Component
{
    use WithPagination;
    public $selected_category = [];
    public $keyword              = '';
    public $min_price           = '';
    public $max_price           = '';
    public $selected_location   = '';
    public $currency_symbol     = '';
    public $per_page            = '';
    public $profile_id          = '';
    public $sort_by             = '';
    protected $listeners        = ['ApplySearchFilter' => 'SearchFilter']; 
    public $page_loaded         = false; 
    public $roleName            = '';
    public $address_format      = ''; 
    public $view_type           = 'grid';
    protected $queryString = [
        'keyword'       => ['except' => ''],
        'min_price'     => ['except' => ''],
        'max_price'     => ['except' => ''],
    ];

    public function mount( $view_type, $selected_category = '' ){
        $this->view_type = $view_type;

        if( !empty($selected_category) ){
            $this->selected_category = $selected_category;
        }
        $user = getUserRole();
        $this->profile_id       = !empty($user['profileId']) ? $user['profileId'] : '';
        $this->roleName         = !empty($user['roleName']) ? $user['roleName'] : '';

        $currency               = setting('_general.currency');
        $per_page_record        = setting('_general.per_page_record');
        $address_format        = setting('_general.address_format');

        $this->per_page         = !empty( $per_page_record ) ? $per_page_record : 10;
        $this->address_format   = !empty( $address_format ) ? $address_format : 'state_country';
        $currency_detail        = !empty( $currency)    ? currencyList($currency) : array();
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol'];
        }
    }

    public function render(){

        $gigs       = [];
        $fav_gigs   = [];

        if(!empty($this->page_loaded)){

            $this->sort_by = !empty($this->sort_by) ? $this->sort_by : 'date_desc';
           
            $gigs = Gig::select('id','author_id', 'title', 'slug','country','address','attachments','is_featured', 'status')
                ->with([
                'gigAuthor:id,user_id,first_name,last_name,slug',
                'gigAuthor.user.userAccountSetting:id,user_id,verification',
                ])->whereHas('gigAuthor.user')->withAvg('ratings','rating')
                ->withCount(['ratings','gig_visits'])->where('status', 'publish');
                
            $minumumValue =   GigPlan::select('price')
                    ->whereColumn('gig_plans.gig_id', 'gigs.id')
                    ->orderBy('price', 'asc')
                    ->limit(1);
                
            $gigs = $gigs->addSelect(['minimum_price' => $minumumValue]);

            if( !empty($this->min_price) && !empty($this->max_price)){
                $gigs = $gigs->whereHas('gig_plans', function($query){
                    $query->orderBy('price', 'asc');
                    $query->whereBetween('price', [$this->min_price, $this->max_price]);
                });
            }

            if(!empty($this->keyword)){
                $gigs = $gigs->whereFullText('title', $this->keyword);
            }

            if(!empty($this->selected_location)){
                $gigs = $gigs->whereFullText('country', $this->selected_location);
            }

            
            if( !empty($this->selected_category) ){
                $gigs = $gigs->whereHas('categories', function($query){
                    $query->where('category_id', $this->selected_category);
                });
            }
            
            if( $this->sort_by == 'date_desc' ){
                $gigs = $gigs->orderBy('created_at', 'desc');
            } elseif($this->sort_by == 'visits_desc'){
                $gigs = $gigs->orderByDesc("gig_visits_count");
            } elseif($this->sort_by == 'order_desc'){
                $gigs = $gigs->withCount(['gig_orders' => function($query){
                    $query->where('status', 'completed');
                }])->orderByDesc("gig_orders_count");
            }

            if( in_array($this->sort_by, ['price_desc', 'price_asc']) ){
                $sorting = $this->sort_by == 'price_desc' ? 'desc' : 'asc';
                $gigs = $gigs->orderBy('minimum_price', $sorting);
            }

            $gigs = $gigs->paginate(12);
            $fav_gigs = [];

            if( !empty($this->profile_id) ){
                $fav_gigs = FavouriteItem::where(['type' => 'gig', 'user_id' => $this->profile_id])->select('corresponding_id as gig_id')->get()->pluck('gig_id')->toArray();
            }
        }

        return view('livewire.gig.'.$this->view_type, compact('gigs', 'fav_gigs'));
    }

    
    public function loadGigs(){
        $this->page_loaded = true;
    }

    public function SearchFilter($data){
        $type = !empty($data['type']) ? $data['type'] : '';
        
        if(in_array($type, ['keyword', 'category', 'location', 'pricerange', 'clearfilter'])){
            $this->resetPage();
        }
        switch($type){
            case 'keyword':
                $this->keyword = !empty($data['keyword']) ? $data['keyword'] : '';
            break;
            case 'category':
                $this->selected_category = !empty($data['category']) ? $data['category'] : '';
            break;
            case 'location':
                $this->selected_location = !empty($data['location']) ? $data['location'] : '';
            break;
            case 'pricerange':
                $this->min_price = !empty($data['min_price']) ? $data['min_price'] : '';
                $this->max_price = !empty($data['max_price']) ? $data['max_price'] : '';
            break;
            case 'sortby':
                $this->sort_by = !empty($data['sort_by']) ? $data['sort_by'] : '';
            case 'clearfilter':
                $this->keyword   = '';
                $this->selected_category  = '';
                $this->selected_location    = '';
                $this->min_price            = '';
                $this->max_price            = '';
            break;

            default:

            break;
        }
    }

    public function saveItem($gig_id){
        if($this->roleName == 'buyer'){
            $savItem = favouriteItem($this->profile_id, $gig_id, 'gig');
        } else {
            $eventData              = [];
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('general.login_error');
            $eventData['type']      = 'error';
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        }
    }
}
