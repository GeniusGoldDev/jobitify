<?php

namespace App\Models\Gig;


use App\Models\Gig\GigDeliveryTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GigPlan extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
        * Get the details of delivery time.
    */
    public function deliveryTime(){
        return $this->belongsTo(GigDeliveryTime::class, 'delivery_time', 'id');
    }
}
