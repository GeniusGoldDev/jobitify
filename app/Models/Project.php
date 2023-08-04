<?php

namespace App\Models;

use App\Models\Search;
use Illuminate\Support\Str;
use App\Models\Taxonomies\Skill;
use App\Models\Proposal\Proposal;
use App\Models\Taxonomies\Language;
use App\Models\Taxonomies\ExpertLevel;
use App\Models\Taxonomies\PaymentMode;
use Illuminate\Database\Eloquent\Model;
use App\Models\Taxonomies\ProjectCategory;
use App\Models\Taxonomies\ProjectDuration;
use App\Models\Taxonomies\ProjectLocation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use Search, SoftDeletes, HasFactory;

    protected $hidden = ['pivot'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profile_id',
        'author_id',
        'project_category',
        'project_title',
        'slug',
        'project_type',
        'project_payout_type',
        'project_country',
        'country_zipcode',
        'address',
        'attachments',
        'project_description',
        'project_payment_mode',
        'project_max_hours',
        'project_min_price',
        'project_max_price',
        'project_duration',
        'project_hiring_seller',
        'project_expert_level',
        'project_location',
        'status',
    ];

    protected $searchable = [
        'project_title',
        'project_description',
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
            if (!Project::all()->where('slug', $temp_slug)->isEmpty()) {
                $i = 1;
                $new_slug = $temp_slug . '-' . $i;
                while (!Project::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp_slug . '-' . $i;
                }
                $temp_slug = $new_slug;
            }
            $this->attributes['slug'] = $temp_slug;
        }
    }


    /**
    * Get the category of the project.
    */
    public function category()
    {
        return $this->hasOne(ProjectCategory::class, 'id', 'project_category');
    }

    /**
    * Get the skills of the project.
    */
    public function skills()
    {
        return $this->morphToMany(Skill::class, 'skillable');
    }

    /**
        * Get the languages of the project.
    */
    public function languages()
    {
        return $this->morphToMany(Language::class, 'languageable');
    }

    /**
        * Get the experience level of the project.
    */
    public function expertiseLevel()
    {
        return $this->hasOne(ExpertLevel::class, 'id', 'project_expert_level');
    }

    /**
        * Get the  location of the project.
    */
    public function projectLocation()
    {
        return $this->hasOne(ProjectLocation::class,  'id', 'project_location');
    }

    /**
        * Get the  duration of the project.
    */
    public function projectDuration()
    {
        return $this->hasOne(ProjectDuration::class, 'id', 'project_duration');
    }

    /**
        * Get the  payment mode of the project.
    */
    public function projectPaymentMode()
    {
        return $this->hasOne(PaymentMode::class, 'id', 'project_payment_mode');
    }

    /**
        * Get the  author of the project.
    */
    public function projectAuthor()
    {
        return $this->belongsTo(Profile::class, 'author_id', 'id');
    }

    /**
        * Get the  visits of the project.
    */
    public function projectVisits()
    {
        return $this->hasMany(UserVisitCount::class, 'corresponding_id', 'id')->where('visit_type','project');
    }

    /**
        * Get all proposals of the project
    */
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
}
