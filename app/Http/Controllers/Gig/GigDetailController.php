<?php

namespace App\Http\Controllers\Gig;

use App\Models\Gig\Gig;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\FavouriteItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GigDetailController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){

        $gig = Gig::select('id','title','slug','author_id','description','attachments','status', 'is_featured')
        ->with(['gigAuthor' => function($query){
                $query->select('id','user_id','slug','first_name','last_name','tagline','image');
                $query->withAvg('ratings','rating')->withCount('ratings');
                $query->withCount('profile_visits');
                $query->with(['user:id', 'user.userAccountSetting:id,user_id,hourly_rate,verification']);
            },
            'ratings','ratings.gig_orders:id,author_id,gig_id',
            'ratings.gig_orders.orderAuthor:id,image',
            'faqs:id,gig_id,question,answer', 'addons:id,title,price,description',
            'gig_plans:id,gig_id,title,description,price,delivery_time','gig_plans.deliveryTime:id,name',
        ])->has('gigAuthor')->withCount(['gig_visits','gig_orders' => function($query){
            $query->where('status', 'completed');
        }])->withAvg('ratings','rating')
        ->where('slug', $slug)->firstOrFail();

        $seller_id      = $gig->gigAuthor->id;
        $user           = getUserRole();
        $profile_id     = !empty($user['profileId']) ? $user['profileId'] : ''; 
        $user_role      = !empty($user['roleName']) ? $user['roleName'] : ''; 
        AddVisitCount( $gig->id, 'gig');
        $is_favourite       = FavouriteItem::where(['user_id'=> $profile_id, 'corresponding_id' => $seller_id, 'type' =>'profile'])->count('id');
        $is_favourite_gig   = FavouriteItem::where(['user_id'=> $profile_id, 'corresponding_id' => $gig->id, 'type' => 'gig'])->count('id');
        $currency           = setting('_general.currency');
        $gig_adsense        = setting('_adsense.add_gig_adsense');
        $rtl                = setting('_site.rtl');
        $rtl                = !empty($rtl) ? $rtl : 0;
        $adsense_code       = !empty($gig_adsense)  ? $gig_adsense : '';

        $currency_detail        = !empty( $currency) ? currencyList($currency) : array();
        $currency_symbol        = '';
        if( !empty($currency_detail['symbol']) ){
            $currency_symbol = $currency_detail['symbol'];
        }
        return view('front-end.gig.gig-detail', compact('gig','user_role', 'currency_symbol', 'is_favourite','slug', 'is_favourite_gig', 'adsense_code','rtl'));
    }

    public function favouriteItem(Request $request){
        
        $response = isDemoSite();
        if( $response ){

            return response()->json([ 
                'title'     => __('general.demosite_res_title'),
                'type'      => 'error',
                'message'   => __('general.demosite_res_txt')
            ]); 
        }

        $user = getUserRole();
        $profile_id         = !empty($user['profileId']) ? $user['profileId'] : '';
        $slug               = !empty($request->profile_slug)    ? $request->profile_slug : ''; 
        $gig_slug           = !empty($request->gig_slug)        ? $request->gig_slug : ''; 
        $seller_id          = !empty($request->seller_id) ? $request->seller_id : '';
        $type               = !empty($request->type) ? $request->type : '';

        $corresponding_id   = '';

        if( $type == 'profile'){
            $seller_info        = Profile::where(['id'=> $seller_id, 'slug' => $slug])->select('id')->first();
            $corresponding_id   = !empty($seller_info->id) ? $seller_info->id : '';
        } elseif( $type == 'gig'){
            $gig                = Gig::where(['slug' => $gig_slug, 'author_id' => $seller_id])->select('id')->first();
            $corresponding_id   = !empty($gig->id) ? $gig->id : '';
        }
       
        $isUpdate           = false;

        if(!empty($profile_id) && !empty($seller_id)){
            $isUpdate = favouriteItem($profile_id, $corresponding_id, $type);
        }
        if(Auth::guest()){
            return response()->json(['type' => 'login_error', 'data' => [
                'message'   => __('general.login_error'),
                'title'     => __('general.error_title'),
                ] ]);
        }
        
        return response()->json(['type' => 'success', 'data' => ['isUpdate' => !empty($isUpdate) ? true : false]]);
    }
}
