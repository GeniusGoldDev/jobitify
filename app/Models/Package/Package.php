<?php

namespace App\Models\Package;

use App\Models\Role;
use App\Models\Search;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use Search, HasFactory, SoftDeletes;

    protected $table ='packages';
    protected $guarded = [];

    protected $searchable = [
        'title',
    ];

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
            if (!Package::all()->where('slug', $temp_slug)->isEmpty()) {
                $i = 1;
                $new_slug = $temp_slug . '-' . $i;
                while (!Package::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp_slug . '-' . $i;
                }
                $temp_slug = $new_slug;
            }
            $this->attributes['slug'] = $temp_slug;
        }
    }

    /**
        * Get the type of the package.
    */
    public function package_role(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
