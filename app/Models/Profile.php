<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;

use App\Models\Search;
use App\Models\Education;
use Illuminate\Support\Str;
use App\Models\UserVisitCount;
use App\Models\Taxonomies\Skill;
use App\Models\UserBillingDetail;
use App\Models\Seller\SellerRating;
use App\Models\Taxonomies\Language;
use App\Models\Seller\SellerSocialLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory, Search, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [];
    
    protected $searchable = [
        'first_name',
        'last_name',
        'tagline',
        'description',
    ];

    /**
     * Set slug before saving in DB
     *
     * @param string $value value
     *
     * @access public
     *
     * @return string
     */
    public function setSlugAttribute($value)
    {
        if (!empty($value)) {
            $temp_slug = Str::slug($value, '-');
            if (!Profile::all()->where('slug', $temp_slug)->isEmpty()) {
                $i = 1;
                $new_slug = $temp_slug . '-' . $i;
                while (!Profile::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp_slug . '-' . $i;
                }
                $temp_slug = $new_slug;
            }
            $this->attributes['slug'] = $temp_slug;
        }
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
        $firstName  = ucfirst($this->first_name); 
        $lastName   = ucfirst($this->last_name); 
        return "{$firstName} {$lastName}";
    }

     /**
     * get first name and first letter of last name
     * 
     * @access public
     *
     * @return string
     */
    public function getFirstNameLastLetterAttribute()
    {
        $firstName  = ucfirst($this->first_name); 
        $lastName   = ucfirst( substr($this->last_name, 0, 1) );

        return "{$firstName} {$lastName}";
    }

     /**
     * Get the skills related of the user profile.
     */
    public function skills()
    {
        return $this->morphToMany(Skill::class, 'skillable');
    }

    /**
        * Get the languages related of the user profile.
    */
    public function languages()
    {
        return $this->morphToMany(new Language, 'languageable');
    }

    /**
        * Get the profile that owns the user.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
        * Get the role of the profifle.
    */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
        * Get the rating of the profile.
    */
    public function ratings()
    {
        return $this->hasMany(SellerRating::class, 'seller_id', 'id');
    }

    /**
        * Get the profile visit count that owns the user.
    */
    public function profile_visits()
    {
        return $this->hasMany(UserVisitCount::class, 'corresponding_id', 'id')->where('visit_type','profile');
    }

    /**
        * Get the education of the profile.
    */
    public function education()
    {
        return $this->hasMany(Education::class);
    }


    /**
        * Get the billing details of the related user profile.
    */
    public function billingDetail(){ 
        return $this->hasOne(UserBillingDetail::class);
    }
    
    /**
    * Get the user's social links.
    */
    public function socialLinks(){ 
        return $this->hasMany(SellerSocialLink::class);
    }
}
