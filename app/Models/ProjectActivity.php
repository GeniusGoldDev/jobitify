<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectActivity extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
        * Get the details of the sender.
    */
    public function sender(){
        
        return $this->belongsTo(Profile::class, 'sender_id', 'id');
    }
}
