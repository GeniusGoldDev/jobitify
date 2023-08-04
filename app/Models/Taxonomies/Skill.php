<?php

namespace App\Models\Taxonomies;

use App\Models\Search;
use Illuminate\Support\Str;
use App\Models\Taxonomies\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Skill extends Model
{
    
    use Search, HasFactory, SoftDeletes, HasRecursiveRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'status',
    ];


    protected $searchable = [
        'name',
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
            if (!Skill::all()->where('slug', $temp_slug)->isEmpty()) {
                $i = 1;
                $new_slug = $temp_slug . '-' . $i;
                while (!Skill::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp_slug . '-' . $i;
                }
                $temp_slug = $new_slug;
            }
            $this->attributes['slug'] = $temp_slug;
        }
    }
    
}
