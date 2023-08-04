<?php

namespace App\Models\Proposal;

use App\Models\Proposal\Proposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalMilestone extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'proposal_id',
        'title',
        'price',
        'description',
        'status',
    ];

    /**
        * Get the proposal of the milestone
    */
    public function proposal(){
        
        return $this->belongsTo(Proposal::class);
    }
}
