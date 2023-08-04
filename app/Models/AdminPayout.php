<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPayout extends Model
{
    protected $guarded = [];
    use HasFactory;

     /**
        * Get the transaction from the detail table.
    */
    public function Transaction(){
        
        return $this->belongsTo(Transaction::class);
    }
}
