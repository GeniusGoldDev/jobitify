<?php

namespace App\Models\Seller;

use App\Models\Profile;
use App\Models\Gig\GigOrder;
use App\Models\Proposal\Proposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellerRating extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
        * Get the buyer user detail.
    */
    public function user()
    {
        return $this->belongsTo(Profile::class,'seller_id','id');
    }

    /**
        * Get the proposal info.
    */
    public function proposal(){
        return $this->belongsTo(Proposal::class, 'corresponding_id', 'id');
    }

     /**
        * Get the gig order detail.
    */
    public function gig_orders(){
        return $this->belongsTo(GigOrder::class, 'corresponding_id', 'id');
    }

    /**
        * Get the buyer detail.
    */
    public function buyerInfo(){
        return $this->belongsTo(Profile::class, 'buyer_id', 'id');
    }
}
