<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccountSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $guarded = [];

    

    /**
        * Get the account setting that owns the user.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
