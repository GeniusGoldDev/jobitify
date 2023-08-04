<?php

namespace App\Http\Livewire\Earnings;

use PDF;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Str;


class InvoiceDetail extends Component
{

    public $profile_id, $userRole;
    public $transaction_id      = '';
    public $date_format         = '';
    public $site_dark_logo           = '';
    public $currency_symbol     = '';

    protected $queryString = [
        'transaction_id'  => ['except' => 0, 'as'=> 'id'],
    ];

    public function mount(){
        
        $date_format            = setting('_general.date_format');
        $currency               = setting('_general.currency');
        $site_dark_logo         = setting('_site.site_dark_logo');
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        $currency_detail        = !empty( $currency)  ? currencyList($currency) : array();

        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }

        if( !empty($site_dark_logo) ){
            $this->site_dark_logo  = $site_dark_logo[0]['path'];
        }

        $user = getUserRole();
        $this->profile_id       = $user['profileId']; 
        $this->userRole         = $user['roleName'];
    }
    
    public function render(){

        $invoice = $this->invoiceInfo();
        return view('livewire.earnings.invoice_detail', compact('invoice'))->extends('layouts.app');
    }

    public function invoiceInfo(){

        $invoice = Transaction::select('id','creator_id','status','created_at','payment_type')
        ->with([
            'TransactionDetail:id,transaction_id,amount,used_wallet_amt,payer_first_name,payer_last_name,payer_company,payer_address,payer_state,payer_email,transaction_type,type_ref_id,sales_tax',
        ])->when( $this->userRole == 'buyer', function ($query) {
            return $query->where('creator_id', $this->profile_id);
        })->when( $this->userRole == 'seller', function ($subQuery) { 
            return $subQuery->where( function ($query) {
                $query->whereHas('sellerPayout', function ($chil_query) {
                    $chil_query->where('seller_id', $this->profile_id);
                })->orWhere('creator_id', $this->profile_id);
            });
        });

        $invoice = $invoice->findorFail($this->transaction_id);

        if( in_array($invoice->payment_type, ['project','gig'] ) ){
            $invoice->load([
                'sellerPayout:id,transaction_id,project_id,gig_id,seller_id,admin_commission',
                'sellerPayout.billingDetail:id,billing_first_name,billing_last_name,profile_id,billing_company,billing_address,billing_email,state_id',
                'sellerPayout.billingDetail.state:id,name'
            ]);
        }

        if( $invoice->payment_type == 'project' ){
            $invoice->load([
            'sellerPayout.project:id,project_title'
            ]);
        }
        
        return $invoice;
    }

    public function exportPDFInvoice(){

        $invoice            = $this->invoiceInfo();
        $invoice_title      = __('generel.invoice');
        $trans_detail       = !empty( $invoice->TransactionDetail ) ? $invoice->TransactionDetail : null;
        $invoice_type       = !empty( $trans_detail->InvoiceType )  ? $trans_detail->InvoiceType : null;

        if( !empty($trans_detail) && ( $trans_detail->transaction_type == 0 || $trans_detail->transaction_type == 1 || $trans_detail->transaction_type == 3) ){
            $invoice_title  = !empty( $invoice_type->invoice_title ) ? $invoice_type->invoice_title : __('generel.invoice');
        }elseif( !empty($trans_detail) && $trans_detail->transaction_type == 2 ){
            $invoice_title  = !empty( $invoice_type->project->invoice_title ) ? $invoice_type->project->invoice_title : __('generel.invoice');
        }elseif( !empty($trans_detail) && $trans_detail->transaction_type == 4 ){
            $invoice_title  = !empty( $invoice_type->gig->invoice_title ) ? $invoice_type->gig->invoice_title : __('generel.invoice');
        }
        $site_dark_logo = asset('storage/'.$this->site_dark_logo);
        $invoice_title  = Str::slug($invoice_title , "-");
        $pdfContent     = PDF::loadView('livewire.earnings.export-invoice', ['invoice' => $invoice, 'site_dark_logo' => $site_dark_logo,  'date_format' => $this->date_format, 'currency_symbol' => $this->currency_symbol, 'userRole' => $this->userRole])->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            $invoice_title.".pdf"
       );    
    }
}
