<?php

namespace App\Http\Livewire\Earnings;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\SellerPayout;
use Livewire\WithPagination;
class Invoices extends Component
{
    
    use WithPagination;

    public $per_page  = '';
    public $profile_id, $userRole;
    public $date_format         = '';
    public $currency_symbol     = '';
    public $className           = '';

    public function mount( $className='' ){
        $this->className = $className;
        $date_format            = setting('_general.date_format');
        $currency               = setting('_general.currency');
        $per_page_record        = setting('_general.per_page_record');
        $this->date_format      = !empty($date_format)          ? $date_format : 'm d, Y';
        $this->per_page         = !empty( $per_page_record )    ? $per_page_record : 10;
        $currency_detail        = !empty( $currency)        ? currencyList($currency) : array();
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }

        $user = getUserRole();
        $this->profile_id       = $user['profileId']; 
        $this->userRole         = $user['roleName'];
    }

    public function render(){

        $invoices = Transaction::select('id', 'creator_id', 'payment_type', 'created_at')
        ->with([
            'TransactionDetail:id,transaction_id,amount,used_wallet_amt',
        ])->when( $this->userRole == 'buyer', function ($query) {
            return $query->where('creator_id', $this->profile_id);
        })->when( $this->userRole == 'seller', function ($subQuery) {
            return $subQuery->with('sellerPayout:id,transaction_id')->where( function ($query) {
                $query->whereHas('sellerPayout', function ($chil_query) {
                    $chil_query->where('seller_id', $this->profile_id);
                })->orWhere('creator_id', $this->profile_id);
            });
        });

        $invoices = $invoices->orderBy('id', 'desc'); 
        $invoices = $invoices->paginate($this->per_page); 
        return view('livewire.earnings.invoices', compact('invoices'))->extends('layouts.app');
    }
}
