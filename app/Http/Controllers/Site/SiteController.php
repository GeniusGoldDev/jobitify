<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;
use App\Models\SitePage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        
        
        if( Auth::user() && !Auth::user()->hasRole('admin') ){
            
            return redirect()->back();
        }
        $page   = SitePage::select('id', 'title', 'description','settings')->where( ['status' => 'publish', 'route' => $request['uri'] ] )->latest()->first();
        if( empty($page) ){
            abort('404');
        }

        $page_id        =  $page->id;
        $title          =  $page->title;
        $pg_description =  $page->description;
        $page_settings = !empty( $page->settings ) ? json_decode($page->settings, true) : [];
        return view('front-end.page', compact('page_id', 'title', 'pg_description', 'page_settings'));
    }

    /**
     * Switch the user role.
     *
     * @return \Illuminate\Http\Response
     */
    public function switchRole( ){
        
       
        $user_info = getUserInfo();
        if( !empty($user_info) ){

            $user_id        = Auth::user()->id;
            $old_user_id    = $user_info['role_id'];
            $new_role_id    = '';
            if( $user_info['user_role'] == 'buyer' ){

                $new_role_id = getRoleByName('seller');

            }elseif( $user_info['user_role'] == 'seller' ){

                $new_role_id = getRoleByName('buyer');

            }
            if( !empty($new_role_id) ){
    
                $profile_detail    = Profile::where([ 'user_id' => $user_id, 'role_id' => $new_role_id ])->select('id')->first();
                if( empty($profile_detail) ){

                    $existing_profile  = Profile::where([ 'user_id' => $user_id, 'role_id' => $old_user_id ])->first();
                    if( !empty($existing_profile) ){
                        
                        Profile::create([
                            'user_id'       => $user_id,
                            'role_id'       => $new_role_id,
                            'first_name'    => $existing_profile->first_name,
                            'last_name'     => $existing_profile->last_name,
                            'slug'          => $existing_profile->first_name.' '.$existing_profile->last_name,
                            'image'         => $existing_profile->image,
                            'tagline'       => $existing_profile->tagline,
                            'country'       => $existing_profile->country,
                            'address'       => $existing_profile->address,
                            'zipcode'       => $existing_profile->zipcode,
                        ]);
                    }
                }

                $new_role = DB::table('model_has_roles')->where(['role_id' => $new_role_id, 'model_id' => $user_id])->first();
                if (empty($new_role) ){
                   $d= DB::table('model_has_roles')->insert([
                        'role_id'       => $new_role_id,
                        'model_type'    => 'App\Models\User',
                        'model_id'       => $user_id,
                    ]);
                }
                DB::table('model_has_roles')->where(['role_id' => $old_user_id, 'model_id' => $user_id])->delete();
                session()->forget('roleId');
                session()->forget('profileId');
                session()->forget('roleName');
            }
        }
        return redirect()->route('dashboard'); 
    }
    
}
