<?php

namespace App\Models;

use App\Models\Search;
use App\Models\Profile;
use App\Models\Gig\GigOrder;
use App\Models\Proposal\Proposal;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proposal\ProposalMilestone;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dispute extends Model
{
    use Search, HasFactory;
    protected $guarded = [];
    

    /**
        * Get all project of the proposal
    */
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }


    /**
        * Get all milestones of the proposal
    */
    public function milestones()
    {
        return $this->hasMany(ProposalMilestone::class,'proposal_id','proposal_id');
    }

    /**
        * Get user info about dispute creator
    */
    public function disputeCreator(){
        return $this->belongsTo(Profile::class,'created_by','id');
    }

     /**
        * Get user info about against dispute
    */
    public function disputeReceiver(){
        return $this->belongsTo(Profile::class,'created_to','id');
    }


    /**
        * Get gig order dispute detail
    */
    public function gigOrder(){
        return $this->belongsTo(GigOrder::class,'gig_order_id','id');
    }

}
