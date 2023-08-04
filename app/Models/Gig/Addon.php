<?php

namespace App\Models\Gig;

use App\Models\Gig\Gig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Addon extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden=['pivot'];

    /**
        * Get related gigs
    */
    public function gigs()
    {
        return $this->belongsToMany(Gig::class);
    }

}
