<?php

namespace App\Http\Controllers\Dashboard;


use App\Models\Gig\Gig;
use App\Models\Project;
use App\Models\UserWallet;
use App\Models\Transaction;
use App\Models\Gig\GigOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\UserWalletDetail;
use App\Models\Proposal\Proposal;
use Illuminate\Support\Facades\DB;
use App\Models\Seller\SellerPayout;
use App\Http\Controllers\Controller;
use App\Models\Seller\SellerWithdrawal;

class DashboardController extends Controller
{
    /**
     * Display the seller/buyer dashboard page.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(){
        $user                   = getUserRole();
        $userRole               = $user['roleName'];
        $profile_id             = $user['profileId'];
        $currency               = setting('_general.currency');
        $dashboard_adsense_code = setting('_adsense.seller_dashboard_adsense');
        $method_type            = '';

        if( $userRole == 'buyer' ){
            $getSetting             = getTPSetting(['payment'], ['payment_methods']);
            $payment_methods        = !empty( $getSetting['payment_methods'] ) ? unserialize($getSetting['payment_methods']) : [];
            $method_type      = !empty( $payment_methods['method_type'] ) ? $payment_methods['method_type'] : '';
        }

        $adsense_code           = !empty($dashboard_adsense_code)  ? $dashboard_adsense_code : '';
        $currency_detail        = !empty($currency) ? currencyList($currency) : array();
        $currency_symbol        = !empty($currency_detail) ?  $currency_detail['symbol'] : '';
        $ongoing_projects       = $completed_projects = $cancelled_projects = 0;
        $sold_gigs              = $ongoing_gigs = $cancelled_gigs = 0;
        $date_intervals         = range(1, date('d'));
        $price_intervals        = $amounts  = $transaction_values = [];
        $compact_values         = [
            'profile_id'        => $profile_id, 
            'currency_symbol'   => $currency_symbol, 
            'adsense_code'      => $adsense_code,
            'method_type'       => $method_type,
            'user_role'         => $userRole,
        ];

        $wallet         = UserWallet::select('id', 'amount')->where('profile_id', $profile_id)->first();

        if( $userRole == 'seller' ) {
            $proposals              = Proposal::where('author_id', $profile_id)->select('status')->get();
            $gigs                   = Gig::where('author_id', $profile_id)->has('gig_orders')->select('id')->with('gig_orders:id,gig_id,status')->get();

            if(!$proposals->isEmpty()){
                $ongoing_projects = $proposals->filter( function($request){
                    return $request->status == 'hired';
                })->count();

                $completed_projects = $proposals->filter( function($request){ 
                    return $request->status == 'completed';
                })->count();

                $cancelled_projects = $proposals->filter( function($request){ 
                    return in_array($request->status , ['disputed', 'refunded']);
                })->count();
            }

            if(!$gigs->isEmpty()){

                foreach($gigs as $gig){
                    $ongoing_gigs += $gig->gig_orders->filter( function($request){ 
                            return  $request->status == 'hired';
                    })->count();
    
                    $sold_gigs += $gig->gig_orders->filter( function($request){ 
                        return  $request->status == 'completed';
                    })->count();
    
                    $cancelled_gigs += $gig->gig_orders->filter( function($request){ 
                        return  in_array($request->status , ['disputed', 'refunded']);
                    })->count();
                }
            }

            // seller account detail
            $total_earning  = $available_balance = $withdraw_amount = $pending_income = 0;
            

            if( !empty($wallet) ){
                $total_earning      = UserWalletDetail::where('wallet_id', $wallet->id)->sum('amount');
                $available_balance  = $wallet->amount; 
            }

            $withdraw_amount    = SellerWithdrawal::where('seller_id', $profile_id)->sum('amount');
            $pending_income     = SellerPayout::whereHas( 'Transaction', function($query){
                $query->select('id')->whereIn('status', array('processed', 'cancelled'));
            })->where('seller_id', $profile_id)->sum('seller_amount');

            if(!empty($wallet)){
                $amounts     = UserWalletDetail::where('wallet_id', $wallet->id)
                ->whereMonth('created_at', Carbon::now()->month)->groupBy('month')
                ->select(DB::raw("DATE_FORMAT(created_at,'%d') as month"), DB::raw('sum(amount) as sum'))
                ->pluck('sum','month')->toArray();
            }

            foreach($date_intervals as $day ){
                $value = !empty($amounts[sprintf("%02d", $day)]) ? $amounts[sprintf("%02d", $day)] : 0;
                array_push($price_intervals, $value);
            }

            $compact_values['ongoing_projects']     = $ongoing_projects;
            $compact_values['completed_projects']   = $completed_projects;
            $compact_values['cancelled_projects']   = $cancelled_projects;
            $compact_values['ongoing_gigs']         = $ongoing_gigs;
            $compact_values['sold_gigs']            = $sold_gigs;
            $compact_values['cancelled_gigs']       = $cancelled_gigs;
            $compact_values['total_earning']        = $total_earning;
            $compact_values['available_balance']    = $available_balance;
            $compact_values['withdraw_amount']      = $withdraw_amount;
            $compact_values['pending_income']       = $pending_income;
            $compact_values['price_intervals']      = $price_intervals;
            $compact_values['date_intervals']       = $date_intervals;

        } elseif( $userRole == 'buyer' ) {
            $projects   = Project::where('author_id', $profile_id)->select('status')->get();
            $gig_orders = GigOrder::where('author_id', $profile_id)->select('status','plan_amount')->get();
            $ongoing_order_amount = 0;

            if(!$projects->isEmpty()){
                $ongoing_projects = $projects->filter( function($request){
                    return $request->status == 'hired';
                })->count();

                $completed_projects = $projects->filter( function($request){ 
                    return $request->status == 'completed';
                })->count();

                $cancelled_projects = $projects->filter( function($request){ 
                    return in_array($request->status , ['cancelled', 'refunded']);
                })->count();
            } 

            if(!$gig_orders->isEmpty()){
                $ongoing_gigs = $gig_orders->filter( function($request){ 
                    return  $request->status == 'hired';
                })->count();
            }

            $project_spend_amount   = $ongoing_amount = $gig_spend_amount  = $available_balance = $withdraw_amount = $pending_income = 0;

            if( !empty($wallet) ){
                $available_balance  = $wallet->amount; 
            }

            $transactions = Transaction::where('creator_id', $profile_id)->whereIn('status' , ['processed','completed','refunded'])->whereIn('payment_type', ['gig','project'])->select('id','payment_type','status', 'created_at')->with('TransactionDetail:id,transaction_id,amount,used_wallet_amt')->get();

            if(! $transactions->isEmpty() ){
                $project_spend_amount = $transactions->filter( function($request){ 
                    return  $request->payment_type == 'project' && $request->status == 'completed';
                })->sum(function ($row) {
                    return $row->TransactionDetail->amount + $row->TransactionDetail->used_wallet_amt;
                });

                $gig_spend_amount = $transactions->filter( function($request){
                    return $request->payment_type == 'gig' && $request->status == 'completed';
                })->sum(function ($row) {
                    return $row->TransactionDetail->amount + $row->TransactionDetail->used_wallet_amt;
                });

                $ongoing_amount = $transactions->filter( function($request){
                    return $request->status == 'processed';
                })->sum(function ($row) {
                    return $row->TransactionDetail->amount + $row->TransactionDetail->used_wallet_amt;
                });

                $transactions_amt = $transactions->filter( function($request){ 
                    return  in_array($request->status, ['completed', 'refunded']);
                });

                foreach( $transactions_amt as $key => $tran ) {
                    $day    = Carbon::parse($tran->created_at)->format('d');
                    $day    = intval($day);
                    if(!isset($transaction_values[$day]['amount'])){
                        $transaction_values[$day]['amount'] = 0;
                    }
                    
                    if(!isset( $transaction_values[$day][$tran->payment_type] ) ){
                        $transaction_values[$day][$tran->payment_type] = 0;
                    }

                    $transaction_values[$day][$tran->payment_type]  += $tran->TransactionDetail->amount + $tran->TransactionDetail->used_wallet_amt;
                    $transaction_values[$day]['amount']             += $tran->TransactionDetail->amount + $tran->TransactionDetail->used_wallet_amt;
                }
            }

            foreach( $date_intervals as $day ){
                $value = !empty($transaction_values[$day]['amount']) ? $transaction_values[$day]['amount'] : 0;
                array_push($price_intervals, $value);
            }
            
            $compact_values['posted_project']       = $projects->count();
            $compact_values['ongoing_projects']     = $ongoing_projects;
            $compact_values['completed_projects']   = $completed_projects;
            $compact_values['cancelled_projects']   = $cancelled_projects;
            $compact_values['ongoing_gigs']         = $ongoing_gigs;
            $compact_values['buyed_gigs']           = $gig_orders->count();
            $compact_values['available_balance']    = $available_balance;
            $compact_values['project_spend_amount'] = $project_spend_amount;
            $compact_values['gig_spend_amount']     = $gig_spend_amount;
            $compact_values['ongoing_amount']       = $ongoing_amount;
            $compact_values['date_intervals']       = $date_intervals;
            $compact_values['price_intervals']      = $price_intervals;
            $compact_values['ongoing_order_amount'] = $ongoing_order_amount;
        }
        
        addJsVars([
            'transaction_values'    => $transaction_values,
            'user_role'             => $userRole,
        ]);

        return view('front-end.dashboard.dashboard', $compact_values );
    }
}
