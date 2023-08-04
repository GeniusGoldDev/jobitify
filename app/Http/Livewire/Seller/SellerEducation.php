<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use App\Models\Education;

class SellerEducation extends Component
{

    public $page_loaded = false; 
    public $user_profile_id  = '';

    public function render()
    {
        $educations = [];
        if( $this->page_loaded ){
            $educations = Education::where('profile_id', $this->user_profile_id)
            ->get([ 'id', 'profile_id', 'deg_title',
            'deg_institue_name', 'address', 'deg_description',
            'deg_start_date', 'deg_end_date', 'is_ongoing'
         ]);
        }
        
        return view('livewire.seller.seller-education',compact('educations'));
    }

    public function mount($user_profile_id) {
        $this->user_profile_id = $user_profile_id;
    }

    public function loadEducations(){
        $this->page_loaded = true;
    }
}
