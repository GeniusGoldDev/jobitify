<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use App\Models\Seller\SellerRating;

class SellerReviews extends Component
{

    public $page_loaded = false; 
    public $user_profile_id  = '';
    public $date_format = '';

    public function render()
    {
        $reviews = [];
        if( $this->page_loaded ){
            $reviews = SellerRating::where('seller_id', $this->user_profile_id)
            ->with('buyerInfo:id,first_name,last_name,image')->has('buyerInfo')
            ->get([ 'id', 'buyer_id', 'rating', 'rating_title', 'rating_description','created_at']);
        }
        
        return view('livewire.seller.seller-reviews',compact('reviews'));
    }

    public function mount($user_profile_id, $date_format) {
        $this->user_profile_id = $user_profile_id;
        $this->date_format = $date_format;
    }

    public function loadReviews(){
        $this->page_loaded = true;
    }
}
