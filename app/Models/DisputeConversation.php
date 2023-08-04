<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisputeConversation extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
        * Get user info
    */
    public function userInfo(){
        return $this->belongsTo(Profile::class, 'sender_id', 'id');
    }


    /**
        * Get reply messages
    */
    public function replyMessages()
    {
        return $this->hasMany($this, 'message_id');
    }
}
