<?php

namespace App\Http\Livewire\Earnings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Seller\SellerWithdrawal;

class PayoutsHistory extends Component
{
    use WithPagination;

    public $per_page        = '';
    public $filter_status   = '';
    public $profile_id      = '';
    public $date_format     = '';
    public $currency_symbol = '';

    protected $listeners = ['updatePayoutsHistory'];
    public function render()
    {
        $payouts_history = SellerWithdrawal::where('seller_id', $this->profile_id)->orderBy('id', 'desc');
        if( !empty($this->filter_status) ){
            $payouts_history = $payouts_history->where('status', $this->filter_status);
        }

        $payouts_history    = $payouts_history->paginate($this->per_page);

        return view('livewire.earnings.payouts-history', compact('payouts_history'));
    }

    public function updatePayoutsHistory(){
        $this->resetPage();
    }

    public function mount($profile_id, $currency){
        $per_page_record    = setting('_general.per_page_record');
        $date_format        = setting('_general.date_format');
        $this->date_format  = !empty($date_format)          ? $date_format : 'm d, Y';
        $this->per_page     = !empty( $per_page_record )    ? $per_page_record : 10;
        $this->profile_id   = $profile_id;
        $this->currency_symbol     = $currency;
    }
}
