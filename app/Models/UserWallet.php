<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    use HasFactory;
    protected $table = 'user_wallet';
    protected $guarded = [];


     /**
        * Get the wallet detail that owns the user.
    */
    public function walletDetail(){

        return $this->hasMany(UserWalletDetail::class, 'wallet_id', 'id');
    }
}
