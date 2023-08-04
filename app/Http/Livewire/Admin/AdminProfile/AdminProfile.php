<?php

namespace App\Http\Livewire\Admin\AdminProfile;

use App\Models\Profile;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AdminProfile extends Component
{
    public $name, $old_image, $image, $first_name, $last_name,$email,$current_password, $new_password, $confirm_password;
    public $cropImageUrl    = '';
    public $allowImageSize  = '';
    public $allowImageExt   = '';

    public function render()
    {
       
        return view('livewire.admin.profile.profile')->extends('layouts.admin.app');
    }

    public function mount(){

        $user   = Auth::user();
        $this->email = $user->email;
        $userProfile = Profile::where('user_id', $user->id)->select('first_name','last_name','image')->first();
        if( !empty($userProfile) ){
            $this->first_name   = $userProfile->first_name;
            $this->last_name    = $userProfile->last_name;
            $this->old_image    = $userProfile->image;
        }
        
        $image_file_size               = setting('_general.image_file_size');
        $image_file_ext                = setting('_general.image_file_ext');
        $this->allowImageSize   = !empty( $image_file_size ) ? $image_file_size : '3';
        $this->allowImageExt    = !empty( $image_file_ext ) ?  explode(',', $image_file_ext)  : ['jpg','png'];

    }

    public function update(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        $this->validate([
            'first_name'            => 'required|string',
            'last_name'             => 'nullable|string',
            'email'                 => 'required|email|unique:users,email,'.Auth::user()->id,
            'new_password'          => 'sometimes|nullable|min:5|required_with:current_password',
            'confirm_password'      => 'sometimes|nullable|min:5|same:new_password|required_with:current_password',
        ],[
            'min'       => __( 'general.minimum_lenght', ['length' => 5 ] ) ,
            'required'  => __('general.required_field'),
            'same'      => __('account_settings.same_error_msg'),
        ]);

        $user   = Auth::user();

        if(!empty($this->current_password) && !empty($this->new_password)){
            $isSave = false;
            if (Hash::check($this->current_password, $user->password )) {
                $user->password = Hash::make($this->new_password);
            } else {
                $this->addError('current_password', __('account_settings.wrong_error_msg'));
                return;
            }
        }

        $user->email    = sanitizeTextField($this->email);
        $isSave         = $user->save();
        $data = array(
            'first_name'    => sanitizeTextField($this->first_name),
            'last_name'     => sanitizeTextField($this->last_name),
            'image'         => null,
        );
        $image_dimensions   = getImageDimensions('user_profile');

        if(!empty($this->cropImageUrl)) {

            $bse64 = explode(',', $this->cropImageUrl); 
            $bse64 = trim($bse64[1]);
            if( ! base64_encode( base64_decode( $bse64, true ) ) === $bse64 ) {
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => __('general.invalid_file_type' , ['file_types' => join(',', $this->allowImageExt) ])
                ]);
                return;
            }

            $imageData      = uploadImage('profiles', $this->cropImageUrl, $image_dimensions);
            $data['image']  = !empty($imageData) ? serialize($imageData) : null;

        } elseif( !empty($this->old_image) ){
            if(is_array($this->old_image)){
                $data['image'] = serialize($this->old_image);
            } else { // for manage plain image path

                $image_record  = @unserialize($this->old_image);
                if( $image_record == 'b:0;' || $image_record !== false ){
                    $data['image'] = $this->old_image;
                } else {
                    $imageData['url'] = $this->old_image;
                    foreach($image_dimensions as $size => $dimension){
                        $imageData[$size] = $this->old_image;
                    }
                    $data['image'] = serialize($imageData);
                }
            }
        }

        $updated                    = Profile::where('user_id', $user->id)->update($data);
        $eventData['title']         = $updated ? __('general.success_title') : __('general.error_title');
        $eventData['type']          = $updated ? 'success' : 'error';
        $eventData['message']       = $updated ? __('general.success_message') : __('general.error_msg');
        $eventData['redirectUrl']   = route('profile');
        $eventData['autoClose']     = 3000;

        $this->current_password =$this->new_password = $this->confirm_password = '';
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }

    public function removePhoto(){
        $this->cropImageUrl = $this->old_image = null;
    }
}
