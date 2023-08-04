<?php

namespace App\Http\Controllers\Webhook;
use Carbon\Carbon;
use App\Models\Profile;
use App\Models\Project;
use App\Events\NotifyUser;
use App\Models\AdminPayout;
use App\Models\Transaction;
use App\Models\Gig\GigOrder;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\Package\Package;
use App\Services\EscrowPayment;
use App\Models\Proposal\Proposal;
use App\Models\TransactionDetail;
use App\Models\UserBillingDetail;
use App\Models\Seller\SellerPayout;
use App\Http\Controllers\Controller;
use App\Notifications\EmailNotification;
use App\Models\Package\PackageSubscriber;
use App\Models\Proposal\ProposalTimecard;
use App\Models\Proposal\ProposalMilestone;

class WebhookController extends Controller
{
    public function EscrowTransactionUpdates(Request $request){
        
        
        if( $request['event_type'] == 'transaction' && $request['event'] == 'payment_approved' ){

            $trans_ref_no = !empty($request['transaction_id']) ? $request['transaction_id'] : 0;
            $escrow     =   new EscrowPayment();
            $response   = $escrow->getTransaction(['transaction_id' => $trans_ref_no]);
            if( !empty($response) && $response['type'] == 'success' ){

                $transaction = Transaction::select('id','status', 'payment_type', 'creator_id')
                ->with('TransactionDetail:id,transaction_id,transaction_type,type_ref_id')
                ->where('trans_ref_no', $trans_ref_no)->latest()->first();
                
                if( !empty($transaction) && $transaction->status == 'pending' ){

                    $transaction_type   = $transaction->TransactionDetail->transaction_type;
                    $type_ref_id        = $transaction->TransactionDetail->type_ref_id;
        
                    if( $transaction_type == 0 ){       // package transaction

                        $package_detail = Package::with('package_role:id,name')->find( $type_ref_id );

                        if( !empty($package_detail) ){

                            $escrow             = new EscrowPayment();
                            $response           = $escrow->updateTransaction( $trans_ref_no, 'ship' );
                            if( $response['type'] == 'success' ){

                                $billing_info   = UserBillingDetail::select('payout_settings')
                                ->where('profile_id', $transaction->creator_id)->first();

                                if( !empty($billing_info->payout_settings ) ){

                                    $payouts_settings = unserialize( $billing_info->payout_settings ); 
                                    
                                    if( !empty($payouts_settings['escrow']) ){

                                        $escrow_email       = $payouts_settings['escrow']['escrow_email'];
                                        $escrow_api         = $payouts_settings['escrow']['escrow_api'];
                                        $escrow             =   new EscrowPayment( $escrow_email, $escrow_api );
                                        $response           = $escrow->updateTransaction( $trans_ref_no, 'receive' );
                                        
                                        if( $response['type'] == 'success' ){

                                            $response = $escrow->updateTransaction( $trans_ref_no, 'accept' );
                                            
                                            if( $response['type'] == 'success' ){

                                                $transaction->update(['status' => 'completed']);

                                                $options = unserialize( $package_detail->options );
                                                if( $options['type'] == 'year' ){
                                                    $expiry_date =  Carbon::now()->addYear($options['duration'])->format('Y-m-d H:i:s');
                                                }elseif( $options['type'] == 'month' ){
                                                    $expiry_date =  Carbon::now()->addMonth($options['duration'])->format('Y-m-d H:i:s');
                                                }else{
                                                    $expiry_date =  Carbon::now()->addDays($options['duration'])->format('Y-m-d H:i:s'); 
                                                }

                                                if( $package_detail->package_role->name == 'buyer' ){

                                                    $package_options = array(
                                                        'type'          => $options['type'],
                                                        'duration'      => $options['duration'],
                                                        'allow_quota'   => array(
                                                            'posted_projects'           => $options['posted_projects'],
                                                            'featured_projects'         => $options['featured_projects'],
                                                            'project_featured_days'     => $options['project_featured_days'],
                                                        ),
                                                        'rem_quota'     => array(
                                                            'posted_projects'           => $options['posted_projects'],
                                                            'featured_projects'         => $options['featured_projects'], 
                                                        )
                                                    );
                                                }else{

                                                    $package_options = array(
                                                        'type'          => $options['type'],
                                                        'duration'      => $options['duration'],
                                                        'allow_quota'   => array(
                                                            'credits'               => $options['credits'],
                                                            'profile_featured_days' => $options['profile_featured_days'],
                                                        ),
                                                        'rem_quota' => array(
                                                            'credits'    => $options['credits'],
                                                        )
                                                    );

                                                    $featured_expiry = null;
                                                    if( !empty($options['profile_featured_days']) ){

                                                        $profile_featured_days = $options['profile_featured_days'];
                                                        $featured_expiry  = Carbon::now()->addDays($profile_featured_days)->format('Y-m-d H:i:s');
                                                    }
                                                    $profile = Profile::where(['id'=> $transaction->creator_id]);
                                                    $profile->update(['is_featured'=> 1, 'featured_expiry' => $featured_expiry]);
                                                }

                                                PackageSubscriber::where('subscriber_id', $transaction->creator_id)->update(['status' => 'expired']);
                                                
                                                $package_subscriber = PackageSubscriber::create([
                                                    'subscriber_id'     => $transaction->creator_id,
                                                    'package_id'        => $type_ref_id,
                                                    'package_price'     => $package_detail->price,
                                                    'package_options'   => serialize($package_options),
                                                    'package_expiry'    => $expiry_date,
                                                ]);

                                                AdminPayout::create([
                                                    'transaction_id'    => $transaction->id,
                                                    'amount'            => $transaction->TransactionDetail->amount,
                                                ]);

                                                // notify email to admin and purchaser(seller and buyer)
                                                $eventData                           = array();
                                                $eventData['pckg_subscriber_id']     = $package_subscriber->id;
                                                $eventData['email_type']             = 'package_purchase';
                                                event(new NotifyUser($eventData));
                                            }
                                        }         
                                    }         
                                }         
                            }
                        }
                    }elseif( $transaction_type == 1 ){   //  milestone proposal

                        $proposal_milestone = ProposalMilestone::select('id','title', 'proposal_id')->find( $type_ref_id );
                        $proposal_milestone->update(['status' => 'processed']);
                        $proposal_id = $proposal_milestone->proposal_id;
                        $transaction->update(['status' => 'processed']);

                        // send email to seller when escrow milestone
                        $eventData = array();
                        $eventData['milestone_title'] = $proposal_milestone->title;
                        $eventData['email_type']      = 'escrow_milestone';
                        $eventData['proposal_id']     = $proposal_id;
                        
                        event(new NotifyUser($eventData));

                    }elseif( $transaction_type == 2 ){  // fixed proposal

                        $proposal_id = $type_ref_id;
                        $transaction->update(['status' => 'processed']);
                    }elseif( $transaction_type == 3 ){  // hourly proposal

                        $proposal_timecard  = ProposalTimecard::select('id', 'proposal_id','title')->find( $type_ref_id );
                        $proposal_id        = $proposal_timecard->proposal_id;
                        $proposal           = Proposal::select('author_id', 'project_id')->find( $proposal_id );
                        $project            = Project::select('author_id')->find( $proposal->project_id );
                        $billing_info       = UserBillingDetail::select('payout_settings')
                        ->where('profile_id', $proposal->author_id)
                        ->first();

                        if( !empty($billing_info->payout_settings) ){

                            $payouts_settings = unserialize( $billing_info->payout_settings );

                            if( !empty($payouts_settings['escrow']) ){

                                $escrow_email       = $payouts_settings['escrow']['escrow_email'];
                                $escrow_api         = $payouts_settings['escrow']['escrow_api'];
                                $escrow             = new EscrowPayment( $escrow_email, $escrow_api );
                                $response           = $escrow->updateTransaction( $trans_ref_no, 'ship' );

                                if( $response['type'] == 'success' ){

                                    $billing_info   = UserBillingDetail::select('payout_settings')
                                    ->where('profile_id', $project->author_id)->first();

                                    if( !empty($billing_info->payout_settings ) ){

                                        $payouts_settings = unserialize( $billing_info->payout_settings ); 
                                        
                                        if( !empty($payouts_settings['escrow']) ){

                                            $escrow_email       = $payouts_settings['escrow']['escrow_email'];
                                            $escrow_api         = $payouts_settings['escrow']['escrow_api'];
                                            $escrow             =   new EscrowPayment( $escrow_email, $escrow_api );
                                            $response           = $escrow->updateTransaction( $trans_ref_no, 'receive' );
                                            
                                            if( $response['type'] == 'success' ){

                                                $response = $escrow->updateTransaction( $trans_ref_no, 'accept' );
                                                
                                                if( $response['type'] == 'success' ){
                                                    // add  admin commision amount 
                                                    $seller_payout = SellerPayout::where('transaction_id', $transaction->id)->latest()->first();
                                                    if( !empty($seller_payout) && $seller_payout->admin_commission > 0 ){

                                                        AdminPayout::updateOrCreate(['transaction_id' => $transaction->id], [
                                                            'transaction_id'    => $transaction->id,
                                                            'amount'            => $seller_payout->admin_commission,
                                                        ]);
                                                    }

                                                    $proposal_timecard->update(['status' => 'completed']);
                                                    $transaction->update(['status' => 'completed']);

                                                    $eventData = array();
                                                    $eventData['timecard_title']  = $proposal_timecard->title;
                                                    $eventData['email_type']      = 'timecard_accepted';
                                                    $eventData['proposal_id']     = $proposal_id;
                                                    event(new NotifyUser($eventData));
                                                }
                                            }        
                                        }  
                                    }
                                } 
                            }
                        }
                    }elseif($transaction_type == 4 ){ // gig order

                        $transaction->update(['status' => 'processed']);        // send email && notification 
                        $gig_order = GigOrder::select('id','author_id','gig_id','status','gig_start_time')->with([
                            'orderAuthor:id,user_id,first_name,last_name',
                            'gig:id,title,author_id',
                            'gig.gigAuthor:id,user_id,first_name,last_name'
                            ])->find($type_ref_id);
                           
                        $gig_title      = $gig_order->gig->title;
                        $seller_id      = $gig_order->gig->gigAuthor->user_id;
                        $gig_author     = $gig_order->gig->gigAuthor->full_name;
                        $order_author   = $gig_order->orderAuthor->full_name;
                        $buyer_id       = $gig_order->orderAuthor->user_id;
                
                        $gig_order->update(['gig_start_time' => date('Y-m-d H:i:s'), 'status' => 'hired']);
                        
                        $eventData                  = array();
                        $eventData['gig_title']     = $gig_title;
                        $eventData['buyer_id']      = $buyer_id;
                        $eventData['seller_id']     = $seller_id;
                        $eventData['gig_author']    = $gig_author;
                        $eventData['order_author']  = $order_author;
                        $eventData['email_type']    = 'post_gig_order';
                        
                        event(new NotifyUser($eventData));

                    }
                    if( $transaction->payment_type == 'project' ){

                        $proposal   = Proposal::select('id', 'project_id', 'author_id', 'status')->with('proposalAuthor:id,first_name,last_name,user_id')->find($proposal_id);
                        $project_id = $proposal->project_id;
                        $project    = Project::select('id', 'status', 'project_hiring_seller','project_title','slug')->find($project_id);

                        if( $proposal->status == 'publish' ){ // send email && notification 
                            $proposal->update(['status'=> 'hired']);
                            //fixed and milestone case

                            $eventData                              = array();
                            $eventData['project_title']             = $project->project_title;
                            $eventData['user_name']                 = $proposal->proposalAuthor->full_name;
                            $eventData['user_id']                   = $proposal->proposalAuthor->user_id;
                            $eventData['email_type']                = 'proposal_request_accepted';

                            $eventData['project_activity_link']     = route('project-activity', ['slug' => $project->slug, 'id'=> $proposal->id]);
                            
                            // send mail in hourly project using event
                            event(new NotifyUser($eventData));
                        }

                        $total_hired_proposal   = Proposal::where('project_id', $project_id)
                        ->whereIn('status', array('hired', 'completed', 'refunded'))->count('id');

                        if( $project->status == 'publish' && $project->project_hiring_seller == $total_hired_proposal ){
                            $project->update(['status' => 'hired']);
                        }
                    } 
                }
            }
        }
    }
}
