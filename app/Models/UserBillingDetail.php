<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBillingDetail extends Model
{
    use HasFactory;
    protected $table = 'user_billing_detail';
    protected $guarded = [];
    

    /*
    ** Get related states of country
    */

    public function states(){
        return $this->hasMany(CountryState::class, 'country_id', 'country_id');
    }

     /**
     * get full name using
     *
     *
     * @access public
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $firstName  = ucfirst($this->billing_first_name); 
        $lastName   = ucfirst($this->billing_last_name); 
        return "{$firstName} {$lastName}";
    }


    /*
    ** Get select state 
    */
    public function state(){
        return $this->belongsTo(CountryState::class, 'state_id');
    }
}
