<?php
namespace App\Http\Livewire\Project;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FavouriteItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Taxonomies\ProjectCategory;

class SearchProjects extends Component
{
    use WithPagination;

    public $per_page                    = '';
    public $address_format               = '';
    public $order_by                    = 'date_desc';
    public $keyword                     = '';
    public $date_format                 = '';
    public $project_min_price           = 0;
    public $project_max_price           = 0;
    public $profile_id                  = 0;
    public $currency_symbol             = ''; 
    public $selected_languages          = [];
    public $selected_category           = '';
    public $category_name               = '';
    public $selected_location           = '';
    public $user_role                   = '';
    public $project_type                = 'all';
    public $selected_skills             = [];
    public $selected_expertise_levels   = [];
    public $price_range                 = [];
    public $isloadedPage                = false;
    protected $listeners                = ['ApplySearchFilter' => 'searchFilter'];

    public function mount($keyword, $category_id, $project_min_price, $project_max_price, $price_range){
        $this->keyword = $keyword;
        $this->selected_category    = $category_id;
        $this->project_min_price    = $project_min_price;
        $this->project_max_price    = $project_max_price;
        $this->price_range          = $price_range;

        $user = getUserRole();
        $this->profile_id           = !empty($user['profileId']) ? $user['profileId'] : 0;
        $this->user_role            = !empty($user['roleName']) ? $user['roleName'] : '';

        $date_format                 = setting('_general.date_format');
        $address_format              = setting('_general.address_format');
        $currency                    = setting('_general.currency');
        $per_page_record             = setting('_general.per_page_record');
        $currency_detail             = !empty( $currency)  ? currencyList($currency) : array();
        $this->date_format           = !empty($date_format) ? $date_format : 'm d, Y';
        $this->address_format        = !empty($address_format) ? $address_format : 'state_country';
        $this->per_page              = !empty($per_page_record) ? $per_page_record : 10;
        
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }
    }
   
    public function render(){
        
        $favourite_projects = [];
        $projects           = collect([]);

        if( $this->isloadedPage ){
            $projects = Project::select( 
                'id',
                'author_id',
                'project_title',
                'slug',
                'updated_at',
                'project_type',
                'project_description',
                'project_min_price',
                'project_location',
                'project_country',
                'project_expert_level',
                'project_duration',
                'project_max_price',
                'address',
                'project_hiring_seller',
                'is_featured',
                'status')->with([
                    'expertiseLevel:id,name',
                    'projectLocation:id,name', 
                    'projectAuthor:id,first_name,last_name',
                    'skills:id,name'
                ])->has('projectAuthor');

            $selected_skills = $this->selected_skills;
            
            if(!empty($selected_skills)){
                $projects = $projects->whereHas(
                    'skills', function($query) use ( $selected_skills ){
                        $query->whereIn( 'skill_id', $selected_skills );
                    }
                );
            }

            if( !empty($this->keyword) ){
                $projects = $projects->where(function($query){
                    $query->whereFullText('project_title', $this->keyword);
                }); 
            }

            if( !empty($this->selected_languages) ){
                $selected_languages = $this->selected_languages;
                $projects = $projects->with('languages:id')->whereHas(
                    'languages', function($query) use ( $selected_languages ){
                        $query->whereIn( 'language_id', $selected_languages );
                    }
                );
            }

            if( $this->project_type != 'all' ){
                $projects = $projects->where('project_type', $this->project_type); 
            }
            
            if( !empty($this->selected_category) ){
                $projects = $projects->where('project_category', $this->selected_category); 
            }elseif( !empty($this->category_name)){

                $category = ProjectCategory::select('id')->where('slug','like','%'. $this->category_name.'%')->first();
                if( !empty($category) ){
                    $projects = $projects->where('project_category', $category->id);
                    $this->selected_category = $category->id;
                }
            }
            
            if( !empty($this->selected_expertise_levels) ){
                $projects = $projects->whereIn('project_expert_level', $this->selected_expertise_levels); 
            }

            if( !empty($project_min_price) || !empty($this->project_max_price)){
                $projects   =  $projects->where('project_min_price', '>=', $this->project_min_price);
                $projects   =  $projects->where('project_max_price', '<=', $this->project_max_price);
            }

            if( !empty($this->selected_location) ){
                $projects = $projects->where('project_country', $this->selected_location); 
            }

            $projects = $projects->withCount('projectVisits')->orderBy('is_featured', 'desc');
            
            if( $this->order_by == 'date_desc' ){
                $projects = $projects->orderBy('updated_at', 'desc');
            }elseif( $this->order_by == 'price_desc' ){
                $projects = $projects->orderBy('project_min_price', 'desc');
            }elseif( $this->order_by == 'price_asc' ){
                $projects = $projects->orderBy('project_min_price', 'asc');
            }elseif( $this->order_by == 'visits_desc' ){
                $projects = $projects->orderByDesc("project_visits_count");
            }
            
            $projects = $projects->where('status', 'publish')->paginate($this->per_page);
            
            if(!empty($this->selected_category)){
                $this->emit('updateCategroyId', $this->selected_category);
            }
            if(!empty($this->keyword)){
                $this->dispatchBrowserEvent('totalFoundResult', ['total_count' => $projects->count(), 'keyword' => clean( $this->keyword ) ] );
            }

            if( $this->profile_id ){
                $favourite_projects  = FavouriteItem::select('corresponding_id')->where(['user_id' => $this->profile_id, 'type' => 'project'])->pluck('corresponding_id')->toArray();
            }
        }
        return view('livewire.project.search-projects', compact('projects','favourite_projects'));
    }

    public function searchFilter($data){

        $this->resetPage();
        $this->keyword              = !empty($data['keyword']) ? $data['keyword'] : '';
        $this->project_type         = !empty($data['project_type']) ? $data['project_type'] : 'all';
        $this->selected_location    = !empty($data['project_location']) ? $data['project_location'] : '';
        $this->selected_category    = !empty($data['category']) ? $data['category'] : '';

        $this->selected_skills              = !empty($data['skills']) ? $data['skills']: [];
        $this->selected_expertise_levels    = !empty($data['expertlevels']) ? $data['expertlevels']: [];
        $this->selected_languages           = !empty($data['languages']) ? $data['languages'] : [];

        $this->project_min_price    = !empty($data['pricerange'][0]) ? $data['pricerange'][0] : $this->price_range['min'];
        $this->project_max_price    = !empty($data['pricerange'][1]) ? $data['pricerange'][1] : $this->price_range['max'];
        $this->order_by             = !empty($data['order_by']) ? $data['order_by'] : '';

       
    }

    public function loadProjects(){
        $this->isloadedPage = true;
    }

    public function saveItem($project_id){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        if( Auth::guest() ){
            $eventData              = [];
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('general.login_error');
            $eventData['type']      = 'error';
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        } else {
            favouriteItem( $this->profile_id, $project_id, 'project');
        }
    }

    public function updatingKeyword(){
        $this->resetPage(); 
    }

    public function updatingPerPage() 
    {
        $this->resetPage(); 
    }

    public function updatingOrderBy() 
    {
        $this->resetPage(); 
    }

    public function clearFilters() 
    {
        $this->selected_languages          = [];
        $this->selected_category           = '';
        $this->selected_location           = '';
        $this->category_name               = '';
        $this->project_type                = 'all';
        $this->selected_skills             = [];
        $this->selected_expertise_levels   = [];
        $this->resetPage(); 
    }
}
