<?php

namespace App\Http\Livewire\Packages;

use Livewire\Component;
use App\Models\Package\Package;
use App\Models\Package\PackageSubscriber;

class Packages extends Component
{
    
    public $profile_id, $userRole;
    public $role_id             = 0;
    public $date_format         = '';
    public $currency_symbol     = '';


    public function mount(){

        $currency               = setting('_general.currency');
        $date_format            = setting('_general.date_format');
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        $currency_detail        = !empty( $currency)    ? currencyList($currency) : array();
        
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }

        $user = getUserRole();
        $this->profile_id   = $user['profileId']; 
        $this->userRole     = $user['roleName'];
        $this->role_id     = $user['roleId'];
    }

    public function render(){
        $purchased_packages     = PackageSubscriber::where(['subscriber_id' => $this->profile_id ])->select('package_id','package_options','package_expiry','status')->get();
        $subscribe_packages     = [];
        if(!empty($purchased_packages)){
            foreach($purchased_packages as $package){
                $subscribe_packages[$package->package_id] = $package;
            }
        }

        $packages               = Package::with('package_role:id,name')->where(['status' => 'active', 'role_id' => $this->role_id])->get();
        
        return view('livewire.packages.packages', compact('packages','subscribe_packages'))->extends('layouts.app');
    }

    public function buyPackage( $id ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        
        $package_detail = Package::where(['status' => 'active', 'role_id' => $this->role_id])->find( $id );
        
        if( !empty($package_detail) ){

            $package_data = [
                'package_id'        => $id,
                'package_title'     => $package_detail->title,
                'package_price'     => $package_detail->price,
            ];

            session()->forget('project_data');
            session()->forget('gig_data');
            session()->put(['package_data' => $package_data ]);
            return redirect()->route('checkout');
        }
    }
}
