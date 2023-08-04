<?php

namespace App\Models;

use App\Models\Transaction;
use App\Models\Gig\GigOrder;
use App\Models\Package\Package;
use App\Models\Proposal\Proposal;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proposal\ProposalTimecard;
use App\Models\Proposal\ProposalMilestone;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
   

    /**
        * Get the transaction from the detail table.
    */
    public function Transaction(){
        
        return $this->belongsTo(Transaction::class);
    }

    public function InvoiceType(){
        
        if( $this->transaction_type == '0' ){

            return $this->belongsTo(Package::class,'type_ref_id', 'id')->select('title as invoice_title');

        }elseif( $this->transaction_type == '1' ){

            return $this->belongsTo(ProposalMilestone::class,'type_ref_id', 'id')->select('title as invoice_title');

        }elseif( $this->transaction_type == '2' ){

            return $this->belongsTo(Proposal::class, 'type_ref_id', 'id')->select('id', 'project_id')->with('project', function($query){
                $query->select('id','project_title as invoice_title' );
            });

        }elseif( $this->transaction_type == '3' ){
            
            return $this->belongsTo(ProposalTimecard::class, 'type_ref_id', 'id')->select('title as invoice_title','proposal_id','total_time')->with('proposal', function($query){
                $query->select('id','proposal_amount' );
            });
        }elseif( $this->transaction_type == '4' ){

            return $this->belongsTo(GigOrder::class,'type_ref_id', 'id')->select('gig_id', 'plan_amount', 'gig_addons')->with('gig', function($query){
                $query->select('id','title as invoice_title' );
            });
        }
    }

         /**
     * get full name using
     *
     *
     * @access public
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $firstName  = ucfirst($this->payer_first_name); 
        $lastName   = ucfirst($this->payer_last_name); 
        return "{$firstName} {$lastName}";
    }

}
