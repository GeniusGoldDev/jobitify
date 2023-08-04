<?php

namespace App\Models;

use App\Models\Seller\SellerPayout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];


    /**
        * Get the transaction details of the transaction.
    */
    public function TransactionDetail(){
        
        return $this->hasOne(TransactionDetail::class);
    }

    /**
        * Get the payout details of the transaction.
    */
    public function sellerPayout(){
        
        return $this->hasOne(SellerPayout::class);
    }

    /**
        * Get the creator details of the transaction.
    */
    public function creator(){
        
        return $this->belongsTo(Profile::class, 'creator_id', 'id')->select('id','first_name', 'last_name', 'image');
    }

}
