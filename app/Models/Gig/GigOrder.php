<?php

namespace App\Models\Gig;

use App\Models\Gig\Gig;
use App\Models\Profile;
use App\Models\Seller\SellerRating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GigOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
        * Get the rating of the gig.
    */
    public function ratings()
    {
        return $this->hasOne(SellerRating::class, 'corresponding_id', 'id')->where('type', 'gig_order');
    }

    /**
    * Get the author of the order
    */
    public function orderAuthor(){
        return $this->belongsTo(Profile::class, 'author_id', 'id');
    }

    public function gig(){
        return $this->belongsTo(Gig::class);
    }
    
}
