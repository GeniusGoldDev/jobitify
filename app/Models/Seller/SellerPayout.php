<?php

namespace App\Models\Seller;

use App\Models\Gig\Gig;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\UserBillingDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellerPayout extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
        * Get the transaction that owns the seller.
    */
    public function Transaction(){
        return $this->belongsTo(Transaction::class);
    }

    /**
    * Get the transaction that owns the seller.
    */
    public function SellerInfo(){
        return $this->belongsTo(Profile::class,'seller_id', 'id')->select('first_name', 'last_name', 'image');
    }

    /**
    * Get the project info.
    */
    public function Project(){
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    /**
    * Get the gig info.
    */
    public function gig(){
        return $this->belongsTo(Gig::class);
    }

    /**
    * Get the billing details of the profile.
    */
    public function billingDetail(){
        
        return $this->belongsTo(UserBillingDetail::class,'seller_id', 'profile_id');
    }
}
