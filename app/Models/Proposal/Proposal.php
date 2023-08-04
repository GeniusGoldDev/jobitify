<?php

namespace App\Models\Proposal;

use App\Models\Search;
use App\Models\Dispute;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Seller\SellerRating;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proposal\ProposalTimecard;
use App\Models\Proposal\ProposalMilestone;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model
{
    use HasFactory, Search;
    protected $primaryKey="id";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded =[]; 

    /**
        * Get all project of the proposal
    */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
        * Get the  author of the proposal.
    */
    public function proposalAuthor()
    {
        return $this->belongsTo(Profile::class, 'author_id', 'id');
    }

    /**
        * Get all milestones of the proposal
    */
    public function milestones()
    {
        return $this->hasMany(ProposalMilestone::class);
    }

    /**
        * Get all filtered timecards of the proposal
    */
    public function filteredTimecard()
    {
        return $this->hasOne(ProposalTimecard::class);
    }

    /**
        * Get all timecards of the proposal
    */
    public function timecards()
    {
        return $this->hasMany(ProposalTimecard::class);
    }
    
    /**
    * Get seller rating against seller proposal
    */
    public function sellerProjectReting(){
        return $this->hasOne(SellerRating::class, 'corresponding_id', 'id')->where('type', 'proposal');
    }
}
