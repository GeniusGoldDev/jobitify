<?php

namespace App\Models\Proposal;

use App\Models\Proposal\Proposal;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proposal\ProposalTimecardDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalTimecard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded =[]; 


     /**
        * Get all timecardDetail of the timecard
    */
    public function timecardDetail()
    {
        return $this->hasMany(ProposalTimecardDetail::class, 'timecard_id', 'id');
    }

    /**
        * Get the proposal of the milestone
    */
    public function proposal(){
        
        return $this->belongsTo(Proposal::class);
    }
}

