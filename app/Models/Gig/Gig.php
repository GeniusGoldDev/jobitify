<?php

namespace App\Models\Gig;


use App\Models\Profile;
use App\Models\Gig\Addon;
use App\Models\Gig\GigFaq;
use App\Models\Gig\GigPlan;
use Illuminate\Support\Str;
use App\Models\Gig\GigOrder;
use App\Models\UserVisitCount;
use App\Models\Seller\SellerRating;
use App\Models\Taxonomies\GigCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gig extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded  = [];
    protected $hidden   = ['pivot'];

    /**
     * Set slug before saving in DB
     *
     * @param string $value value
     *
     * @access public
     *
     */
    public function setSlugAttribute($value){

        if (!empty($value)) {
            $temp_slug = Str::slug($value, '-');
            if (!Gig::all()->where('slug', $temp_slug)->isEmpty()) {
                $i = 1;
                $new_slug = $temp_slug . '-' . $i;
                while (!Gig::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp_slug . '-' . $i;
                }
                $temp_slug = $new_slug;
            }
            $this->attributes['slug'] = $temp_slug;
        }
    }

    /**
    * Get related gig categories
    */
    public function categories()
    {
        return $this->belongsToMany(GigCategory::class, 'gig_category_link','gig_id', 'category_id')->select('category_id', 'category_level');
    }

    /**
    * Get user gig user visit
    */
    public function gig_visits()
    {
        return $this->hasMany(UserVisitCount::class, 'corresponding_id', 'id')->where('visit_type','gig');
    }

    /**
        * Get related addons
    */
    public function addons(){
        return $this->belongsToMany(Addon::class, 'gig_addons', 'gig_id', 'addon_id');
    }

    /**
        * Get related faqs
    */
    public function faqs(){
        return $this->hasMany(GigFaq::class)->select('question', 'answer');
    }

    /**
        * Get related price plans
    */
    public function gig_plans(){
        return $this->hasMany(GigPlan::class);
    }


    /**
        * Get the  author of the gig.
    */
    public function gigAuthor()
    {
        return $this->belongsTo(Profile::class, 'author_id', 'id');
    }

    /**
        * Get related gig orders
    */
    public function gig_orders(){
        return $this->hasMany(GigOrder::class);
    }

    /**
        * Get rating about related gig orders
    */
    public function ratings(){
        return $this->hasManyThrough(SellerRating::class, GigOrder::class, 'gig_id', 'corresponding_id')->where('type', 'gig_order');
    }
}
