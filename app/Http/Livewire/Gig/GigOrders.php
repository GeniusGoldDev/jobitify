<?php

namespace App\Http\Livewire\Gig;

use File;
use ZipArchive;
use Carbon\Carbon;
use App\Models\Gig\Gig;
use Livewire\Component;
use App\Models\Gig\GigOrder;
use Livewire\WithPagination;
use App\Models\Seller\SellerRating;

class GigOrders extends Component
{
    use WithPagination;

    public $per_page                = '';
    public $search_gig              = '';
    public $filter_gig              = '';
    public $profile_id              = 0;
    public $currency_symbol         = ''; 
    public $userRole                = ''; 
    public $seller_id               = '';
    public $gig_id                  = '';
    public $rating_title            = '';
    public $rating_desc             = '';
    public $rating                  = '';
    protected $queryString = [
        'filter_gig'  => [ 'except' => '', 'as'=> 'status'],
    ];
    public $review_detail = [
        'gig_title'     => '',
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
        
        $currency               = setting('_general.currency');
        $per_page_record        = setting('_general.per_page_record');
        $this->per_page         = !empty( $per_page_record ) ? $per_page_record : 10;
        $currency_detail        = !empty( $currency)    ? currencyList($currency) : array();
      
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol'];
        }
    }
   
    public function render(){

        $profile_id = $this->profile_id;
        $search_gig = $this->search_gig;
        $userRole   = $this->userRole;

        $gigs_orders = GigOrder::select(
            'id',
            'gig_id',
            'author_id',
            'plan_type',
            'plan_amount',
            'gig_addons',
            'gig_delivery_days',
            'gig_start_time',
            'downloadable',
            'status'
        ); 

        $gigs_orders  =  $gigs_orders->with(['gig' => function($query){
            $query->select('id', 'author_id','slug', 'title','attachments', 'is_featured');
            $query->has('gigAuthor')->with([
                'categories' => function($query){
                    $query->select('name', 'category_id');
                    $query->orderBy('category_level', 'asc');
                },
                'gigAuthor' => function($query){
                $query->select('id', 'first_name', 'last_name', 'image');
            }]);
        },
        'orderAuthor:id,first_name,last_name,image', 
        'ratings:id,corresponding_id,rating',
        ])->has('orderAuthor')->whereHas('gig', function($query) use($search_gig, $userRole, $profile_id){
            if( $userRole == 'seller' ){
                $query->where('author_id', $profile_id);
            }
            $query->has('gigAuthor');
            if( !empty($search_gig) ){
                $query->whereFullText('title', $search_gig);
            }
        });

        if( !empty($this->filter_gig) ){
            $gigs_orders  =  $gigs_orders->where('status', $this->filter_gig);
        }else{
            $gigs_orders  =  $gigs_orders->whereIn('status' , array('hired','completed', 'disputed', 'refunded'));  
        }

        if($userRole == 'buyer'){
            $gigs_orders = $gigs_orders->where('author_id', $profile_id);
        }

        $gigs_orders  =  $gigs_orders->orderBy('id', 'desc')->paginate($this->per_page);
        return view('livewire.gig.gig-orders', compact('gigs_orders'))->extends('layouts.app');
    }


    public function readReview($order_id) {
        
        $getReview = SellerRating::where(['corresponding_id' => $order_id, 'type' => 'gig_order' ])
        ->with([
            'gig_orders' => function($query){
                $query->select('id','gig_id','author_id');
                $query->with('orderAuthor:id,first_name,last_name,image');
                if( $this->userRole == 'buyer' ){
                    $query->where('author_id', $this->profile_id);
                }
            },
            'gig_orders.gig' => function($query){
                $query->select('id','title');
                if( $this->userRole == 'seller' ){
                    $query->where('author_id', $this->profile_id);
                }
            }
        ])->first();
       
        if(! empty($getReview) ){
            
            $this->review_detail['gig_title']       = $getReview->gig_orders->gig->title;
            $this->review_detail['user_name']       = $getReview->gig_orders->orderAuthor->full_name;
            
            $author_image = '';
            if(!empty($getReview->gig_orders->orderAuthor->image)){
                $image_path = getProfileImageURL($getReview->gig_orders->orderAuthor->image, '50x50');
                $author_image = !empty($image_path) ? asset('storage/' . $image_path) :  asset('images/default-user-50x50.png');
            }else{
                $author_image = asset('images/default-user-50x50.png');
            }

            $this->review_detail['image']           = $author_image; 
            $this->review_detail['rating']          = !empty($getReview->rating) ? $getReview->rating : 0;
            $this->review_detail['avg_rating']      = !empty($getReview->rating) ? ($getReview->rating/5)*100 : 0;
            $this->review_detail['rating_title']    = $getReview->rating_title;
            $this->review_detail['rating_desc']     = $getReview->rating_description;
            $this->dispatchBrowserEvent('ReadReviewPopup', 'show');
        }else{
            $this->review_detail = [
                'gig_title'     => '',
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

    public function downloadAttachments( $id ){
        
        $gig_order = GigOrder::select('downloadable');
        $gig_order = $gig_order->where('id', $id);
        $gig_order = $gig_order->whereIn('status', array('hired', 'completed'));
        $gig_order = $gig_order->first();
       
        if(!empty($gig_order) && !empty($gig_order->downloadable)){
            
            $downloadable = unserialize($gig_order->downloadable);
            $path = storage_path('app/download/gig-downloadable/'.$id);
            if (!file_exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $order_files = $downloadable['files'];
            $zip      = new ZipArchive;
            $fileName = '/downloadable.zip';
            $path = $path .$fileName;
            $zip->open($path, ZipArchive::CREATE);
           
            foreach ($order_files as $single) {
                $name = basename($single->file_name);
                if(file_get_contents(public_path('storage/'.$single->file_path))){
                    $zip->addFromString( $name, file_get_contents(public_path('storage/'.$single->file_path)));
                }
            }
            $zip->close();
            return response()->download(storage_path('app/download/gig-downloadable/' . $id . $fileName));
        }
    }

    public function updatingSearchGig(){
        $this->resetPage(); 
    }

    public function updatingfilterGig(){
        $this->resetPage(); 
    }

}
