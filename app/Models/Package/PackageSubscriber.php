<?php

namespace App\Models\Package;

use App\Models\Profile;
use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageSubscriber extends Model
{
    protected $guarded = [];
    use HasFactory;

    /**
    * Get the package subscriber info.
    */
    public function packageSubscriberInfo()
    {
        return $this->belongsTo(Profile::class, 'subscriber_id', 'id');
    }
    /**
    * Get the package info.
    */
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }


}
