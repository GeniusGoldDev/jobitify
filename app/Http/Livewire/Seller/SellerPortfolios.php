<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use App\Models\Seller\SellerPortfolio;

class SellerPortfolios extends Component
{
    public $page_loaded = false; 
    public $user_profile_id  = '';

    public function render()
    {
        $portfolios = [];
        if( $this->page_loaded ){
            $portfolios         = SellerPortfolio::where('profile_id', $this->user_profile_id)->get();
            $this->dispatchBrowserEvent('initializePortfolioSlider',['portfolio_count' => $portfolios->count()]);
        }
        
        return view('livewire.seller.seller-portfolios',compact('portfolios'));
    }

    public function mount($user_profile_id) {
        $this->user_profile_id = $user_profile_id;
    }

    public function loadPortfolios(){
        $this->page_loaded = true;
    }
}
