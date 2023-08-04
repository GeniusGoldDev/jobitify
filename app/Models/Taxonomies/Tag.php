<?php

namespace App\Models\Taxonomies;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    
    protected $guarded = [];

    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

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
            if (!Tag::all()->where('slug', $temp_slug)->isEmpty()) {
                $i = 1;
                $new_slug = $temp_slug . '-' . $i;
                while (!Tag::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp_slug . '-' . $i;
                }
                $temp_slug = $new_slug;
            }
            $this->attributes['slug'] = $temp_slug;
        }
    }

}
