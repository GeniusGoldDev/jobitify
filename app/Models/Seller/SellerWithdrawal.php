<?php

namespace App\Models\Seller;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellerWithdrawal extends Model
{
    use HasFactory;
    protected $guarded = [];


    /**
    * Get the user information.
    */
    public function User()
    {
        return $this->belongsTo(Profile::class, 'seller_id', 'id');
    }
}
