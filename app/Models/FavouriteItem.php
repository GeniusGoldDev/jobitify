<?php

namespace App\Models;

use App\Models\Gig\Gig;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class FavouriteItem extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function projects(){
        return $this->belongsTo(Project::class, 'corresponding_id', 'id' );
    }
    public function gigs(){
        return $this->belongsTo(Gig::class, 'corresponding_id', 'id' );
    }

    public function sellers(){
        return $this->belongsTo(Profile::class, 'corresponding_id', 'id' );
    }
}
