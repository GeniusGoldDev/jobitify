<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWalletDetail extends Model
{
    use HasFactory;
    protected $table = 'user_wallet_detail';
    protected $guarded = [];


     /**
        * Get the transaction that owns the user.
    */
    public function Transaction(){
        
        return $this->belongsTo(Transaction::class);
    }

     /**
        * Get the wallet that owns the user.
    */
    public function wallet(){

        return $this->belongsTo(UserWallet::class, 'id', 'profile_id');
    }
}

