<?php
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\User;
use App\Models\Profile;
use App\Models\MenuItem;
use App\Models\SitePage;
use Carbon\CarbonPeriod;
use App\Models\UserWallet;
use Illuminate\Support\Str;
use App\Models\FavouriteItem;
use Illuminate\Support\Facades\DB;
use App\Models\Setting\SiteSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Artisan;
use App\Models\Package\PackageSubscriber;



/**
 * remove cache
 * @return void();
 */
if (! function_exists('clearCache')) {
    function clearCache() {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        Artisan::call('config:cache');
        Artisan::call('view:cache');
        Artisan::call('route:cache');
        Cache::flush();  // clear everything from cache
    }
}
/**
 * return avaialbel social links
 * @return array();
 */
if (! function_exists('availableSocialLinks')) {

    function availableSocialLinks( $name = '') {

        $links = [
            'facebook' => [
                'name'          => __('general.facebook_link_title'),
                'placeholder'   => __('general.facebook_link_placeholder'),
                'icon_class'    => 'fab fa-facebook-f',
            ],
            'linkedin' => [
                'name'          => __('general.linkedin_link_title'),
                'placeholder'   => __('general.linkedin_link_placeholder'),
                'icon_class'    => 'fab fa-linkedin-in',
            ],
            'twitter' => [
                'name'          => __('general.twitter_link_title'),
                'placeholder'   => __('general.twitter_link_placeholder'),
                'icon_class'    => 'fab fa-twitter',
            ],
            'dribbble' => [
                'name'          => __('general.dribbble_link_title'),
                'placeholder'   => __('general.dribbble_link_placeholder'),
                'icon_class'    => 'fab fa-dribbble',
            ],
            'google' => [
                'name'          => __('general.google_link_title'),
                'placeholder'   => __('general.google_link_placeholder'),
                'icon_class'    => 'fab fa-google',
            ],
            'twitch' => [
                'name'          => __('general.twitch_link_title'),
                'placeholder'   => __('general.twitch_link_placeholder'),
                'icon_class'    => 'fab fa-twitch',
            ],
            'instagram' => [
                'name'          => __('general.instagram_link_title'),
                'placeholder'   => __('general.instagram_link_placeholder'),
                'icon_class'    => 'fab fa-instagram',
            ],
        ];

        return !empty($name) ? $links[$name] : $links;
    }
}

/**
 * add input mask in the string
 *
 * @param string    $string         String.
 * @param string    $mask           string mask like *.
 * @return string   text            text.
 */
function stringInputMask($string, $mask = '*') {
    $str_length     = strlen($string);
    $start_point    = 0;
    $print_mask     = $str_length - 2;

    if( $str_length > 6 ){
        $start_point = - ( $str_length - 3);
        $print_mask = $str_length - 5;
    }
    
    return Str::mask( $string, $mask, $start_point, $print_mask);
}

/**
 * add 3 dots after specific text lenght
 *
 * @param string    $string         String.
 * @param string    $repl           add dots.
 * @return int      $limit          text limit.
 */
if (! function_exists('add3DotsInText')) {
function add3DotsInText($string, $repl, $limit) {
    if(strlen($string) > $limit) 
    {
        return substr($string, 0, $limit) . $repl; 
    }
    else 
    {
        return $string;
    }
    }
}

if (! function_exists('hierarchyTree')) {
    function hierarchyTree( &$arr ){
            
        foreach( $arr as $key=> &$el ){

            $data = [
                'id'    => $el['id'],
                'title' => $el['name'],
            ];

            if( !empty($el['children']) && is_array( $el['children'] ) ){
                $children = hierarchyTree( $el['children'] );
                $data['subs'] = $children;
            }
            $el = $data;
        }

        return  $arr; 
    }
}


/**
 *
 * @param array of variables
 * @return void()
 */
if (! function_exists('addJsVars')) {

    function addJsVars(array $vars) {
        if(!empty($vars)){
            JavaScript::put($vars);
        }
    }
}

/**
 *
 * @param array of variables
 * @return void()
 */
if (! function_exists('getDBData')) {

    function getDBData( $params ) {

        $query = DB::table( $params['table'] );

        if( !empty($params['select']) ){
            $query = $query->select( $params['select'] ); 
        }

        if( !empty($params['where']) ){
            $query = $query->where( $params['where']['col'], $params['where']['match'], $params['where']['value'] ); 
        }

        $query = $query->get();

        if( !empty($params['return_type']) &&  $params['return_type'] == 'array'){
            $query = $query->toArray(); 
        }
        return $query;
    }
}

/**
 *return pagination select options
 *
 * @return response()
 */
if (! function_exists('perPageOpt')) {

    function perPageOpt() {

        return [10, 20, 30, 50, 100, 200 ];
    }
}

/**
 *get roles
 *
 * @return response()
 */
if (! function_exists('getAllRoles')) {

    function getAllRoles() {

        return $roles = DB::table('roles')->select('id','name')->where('name', '<>', 'admin')->get();
    }
}

/**
 *get categories
 *
 * @return response()
 */
if (! function_exists('getAllCategories')) {

    function getAllCategories() {

        return  DB::table('project_categories')->select('id','name')->where('status', 'active')->whereNull('parent_id')->whereNull('deleted_at')->get()->toArray();
    }
}

/**
 *get projects
 *
 * @return response()
 */
if (! function_exists('getAllProjects')) {

    function getAllProjects() {

        return  DB::table('projects')->select('id','project_title')->where('status', 'publish')->get()->toArray();
    }
}


/**
 *get site info
 *
 * @return response()
 */
if (! function_exists('getSiteInfo')) {

    function getSiteInfo() {

        $site_name      = setting('_site.site_name');
        $site_favicon   = setting('_site.site_favicon');
        $site_dark_logo = setting('_site.site_dark_logo');
        $site_lite_logo = setting('_site.site_lite_logo');

        if( !empty($site_favicon) ){
            $site_favicon   = $site_favicon[0]['path'];
        }

        if( !empty($site_dark_logo) ){
            $site_dark_logo  = $site_dark_logo[0]['path'];
        }

        if( !empty($site_lite_logo) ){
            $site_lite_logo  = $site_lite_logo[0]['path'];
        }

        $data = [
            'site_name'         => !empty( $site_name )   ? $site_name : '',
            'site_favicon'      => $site_favicon,
            'site_dark_logo'    => $site_dark_logo,
            'site_lite_logo'    => $site_lite_logo,
        ];

        return $data;
    }
}

/**
 *get user role
 *
 * @return response()
 */
if (! function_exists('getUserRole')) {

    function getUserRole() {

        $userId         = session()->get('userId');
        $profileId      = session()->get('profileId');
        $roleId         = session()->get('roleId');
        $roleName       = session()->get('roleName');

        if(!empty($userId) 
            && !empty($profileId) 
            && !empty($roleId) 
            && !empty($roleName)){

            return [
                'userId'        => $userId,
                'profileId'     => $profileId,
                'roleId'        => $roleId,
                'roleName'      => $roleName
            ];

        }elseif(Auth::user()){

            $Auth       = Auth::user();
            $role       = $Auth->roles()->first();
            $profile    = $Auth->profile()->select('id')->where('role_id',  $role->id)->first();

            $data = [
                'userId'        => $Auth->id,
                'profileId'     => $profile->id,
                'roleId'        => $role->id,
                'roleName'      => $role->name
            ];

            session()->put($data);
            return $data;
        }
    }
}

/**
 *favouriteItem
 *
 * @return response()
 */
if (! function_exists('favouriteItem')) {

    function favouriteItem( $profile_id, $corresponding_id, $type ){
        $isUpdate = false;
        $record = FavouriteItem::where([ 'user_id'  => $profile_id,'corresponding_id' => $corresponding_id, 'type' => $type])->count('id');
        if( $record ) {
            $isUpdate = FavouriteItem::where([ 'user_id'  => $profile_id,'corresponding_id' => $corresponding_id, 'type' => $type])->delete();
        }else{
            $save = FavouriteItem::create([
                'user_id'           => $profile_id,
                'corresponding_id'  => $corresponding_id,
                'type'              => $type
            ]);
            $isUpdate = !empty( $save ) ? true : false;
        }
        return $isUpdate;
    }
}


/**
 *AddVisitCount
 *
 * @return response()
 */
if (! function_exists('AddVisitCount')) {

    function AddVisitCount( $id, $type ){
       
        $IP_address = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $user_agent = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $browser_info = array();
        $browser_info['ip_address'] = $IP_address;
        $browser_info['user_agent'] = $user_agent;
        $location_request           = Http::get('http://ip-api.com/php/'.$IP_address);

       if($location_request->status() == 200){
            $location = !empty($location_request->body()) ? unserialize($location_request->body()) : [] ;
            if(!empty($location['status']) && $location['status'] == 'success'){
                $browser_info['country']        = !empty($location['country']) ? $location['country'] : '';
                $browser_info['region_name']    = !empty($location['regionName']) ? $location['regionName'] : '';
                $browser_info['city']           = !empty($location['city']) ? $location['city'] : '';
                $browser_info['zipcode']        = !empty($location['zip']) ? $location['zip'] : '';
            }
       }

        $is_counted     = false;
        $value          = $id.'__'.$type;
        $coockie_record = [];
        $get_cookie     = Cookie::get('user_visit_counts');
        
        if(!empty( $get_cookie) ){
            $coockie_record = unserialize($get_cookie);
            if(in_array($value, $coockie_record)){
                $is_counted = true;
            }
        }
        
        if(empty($is_counted)){
            $coockie_record[] = $value;
            $browser    = '';
            $version    = '';
            Cookie::queue('user_visit_counts', serialize($coockie_record));
            $save = DB::table('user_visit_counts')->insertGetId([
                'corresponding_id'  => $id,
                'visit_type'        => $type,
                'browser_info'      => serialize($browser_info),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
        }
    }
}

/**
 *get role by name
 *
 * @return response()
 */
if (! function_exists('getRoleByName')) {

    function getRoleByName($name) {

        $role = Cache::rememberForever('getRoleByName-'.$name.'-cache', function() use($name) {
           return DB::table('roles')->select('id')->where('name', $name)->get()->first();
        });
        if( $role ){
            return $role->id;
        }
    }
}

/**
 *get role by id
 *
 * @return response()
 */
if (! function_exists('getRoleById')) {

    function getRoleById($id) {
        
        $role = Cache::rememberForever('getRoleById-'.$id.'-cache', function() use($id) {
           return DB::table('roles')->select('name')->where('id', $id)->get()->first();
        });

        if( $role ){
            return $role->name;
        }else{
            return '';
        }
    }
}


/**
 *get logined users redirect url
 *
 * @return response()
 */
if (! function_exists('getLoginRedirect')) {

    function getLoginRedirect($id = 0) {

        if($id){
            $user_id    = $id;
        }else{
            $user_id  = Auth::user()->id;
        }

        $role    = User::find($user_id)->roles()->first()->name;

        $url = '/';
        if(!empty($role)){
            if ( $role == 'admin' ) {
                $url = RouteServiceProvider::ADMIN_LOGIN;
            } else {
                $url = RouteServiceProvider::USER_LOGIN;
            }
        }else{
            Session::flash('error', __('register.login_error'));
            Auth::logout();
        }

        return $url;
    }
}
/**
 *get setting
 *
 * @return response()
 */
if (! function_exists('getTPSetting')) {

    function getTPSetting( $setting_type = array() , $meta_keys = array() ){

        $getSetting = SiteSetting::select('meta_key','meta_value');
        

        if( !empty( $setting_type )) {
            $getSetting = $getSetting->whereIn('setting_type', $setting_type);
        }
        
        if( !empty( $meta_keys )) {
            $getSetting = $getSetting->whereIn('meta_key', $meta_keys);
        }
        
        $getSetting = $getSetting->get()->toArray();

        $getTPSetting =  array();

        if( !empty($getSetting) ){
            foreach($getSetting as $setting){
                $getTPSetting[$setting['meta_key']] = $setting['meta_value'];
            }
        }
       return $getTPSetting;
       
    }
}

/**
 *get file_path
 *
 * @return response()
 */
if (! function_exists('getProfileImageURL')) {
    function getProfileImageURL( $file, $image_dimension ) {
        $file_url 	= null;
        $imageData  = !is_array($file) ? @unserialize($file) : $file;
       
        if( $imageData == 'b:0;' || $imageData !== false ){
            $file_url           = !empty($imageData[$image_dimension]) ? $imageData[$image_dimension] : null;
        } else {
            $file_url = $file; 
        }

        return $file_url;
    }
}


/**
 *get adminInfo
 *
 * @return response()
 */
if (! function_exists('getUserInfo')) {

    function getUserInfo( $image_dimension = '60x60') {

        $info = [];
        if( Auth::user() ){

            $data = getUserRole();
            $user_detail    = Profile::where([ 'user_id' => $data['userId'], 'role_id' => $data['roleId'] ])->select('image','first_name','last_name', 'slug')->first();
    
            if(!empty($user_detail->image)){
                $file_url   =  getProfileImageURL($user_detail->image, $image_dimension);
                $user_image = !empty($file_url) ? 'storage/' . $file_url : 'images/default-user-'.$image_dimension.'.png';
            }else{
                $user_image = 'images/default-user-'.$image_dimension.'.png';
            }
            
            $info = array(
                'role_id'       => $data['roleId'],
                'user_role'     => $data['roleName'],
                'user_name'     => !empty($user_detail) ? $user_detail->full_name : '',
                'user_image'    => $user_image,
                'slug'          => $user_detail->slug,
            );
        }
        return $info;
    }
}

 

/**
 *check account verification
 *
 * @return response()
 */

if (! function_exists('isVerifiedAcc')) {

    function isVerifiedAcc() {

        $verification    = Auth::user()->userAccountSetting->verification;
        $email_verified = Auth::user()->email_verified_at;
        if( $verification == 'approved' && !empty($email_verified) ){
            return true;
        }else{
            return false;
        }
    }
}

/**
 * user package verification
 *
 * @return response()
 */

if (! function_exists('packageVerify')) {

    function packageVerify($params = array()) {

        $response = array();
        $package_setting = getTPSetting(['package'], ['package_option']);
        $buyer = $seller = $option_type = 'free';
        
        if(!empty($package_setting)){
            $option_type = $package_setting['package_option'];
        }
        if($option_type == 'free'){
            $response['type'] = 'success';
            return  $response;
        }elseif( $option_type == 'paid' ){
            $buyer = $seller = 'paid';
        }elseif($option_type == 'seller_paid'){
            $seller = 'paid';
        }elseif($option_type == 'buyer_paid'){
            $buyer = 'paid';
        }

        $user = getUserRole();
        $user_role  = $user['roleName'];
       
        if( $user_role == 'buyer' ){

            if( $buyer == 'free' ){
                $response['type'] = 'success';
                return  $response;
            }else{
                $buyer_package =  PackageSubscriber::where( array( 'subscriber_id' => $params['id'], 'status' => 'active' ) )->latest()->first();
                if(empty($buyer_package)){
                    $response['type']       = 'error';
                    $response['title']      = __('general.error_title');
                    $response['message']    = __('general.package_buy_project');
                    return  $response;
                }else{
                    $package_options    = unserialize($buyer_package->package_options);
                    $allow_quota    = $package_options['allow_quota'];
                    $rem_quota      = $package_options['rem_quota'];

                    $posted_projects    = $rem_quota['posted_projects'];
                    $featured_projects  = $rem_quota['featured_projects'];
                    $expiry_date        = Carbon::parse($buyer_package->package_expiry);
                    $current_date       = Carbon::now();
                    if( $current_date->gt($expiry_date) ){
                        $response['type']       = 'error';
                        $response['title']      = __('general.error_title');
                        $response['message']    = __('general.package_expired');
                        return  $response;
                    }elseif( !empty($params['is_featured']) && $allow_quota['featured_projects'] > 0 && $featured_projects <= 0 ){
                        $response['type']       = 'error';
                        $response['title']      = __('general.error_title');
                        $response['message']    = __('general.package_featue_project_exceed');
                        return  $response;
                    }elseif( !empty($params['posted_project']) && $allow_quota['posted_projects'] > 0 && $posted_projects <= 0){
                        $response['type']       = 'error';
                        $response['title']      = __('general.error_title');
                        $response['message']    = __('general.package_project_exceed');
                        return  $response;
                    }else{
                        $response['type']               = 'success'; 
                        $response['id']                 = $buyer_package->id; 
                        $response['package_options']    = $package_options; 
                        return  $response;
                    }
                }
            }
        }else{
            if( $seller == 'free' ){
                $response['type'] = 'success';
                return  $response;
            }else{
                $seller_package =  PackageSubscriber::where( array( 'subscriber_id' => $params['id'], 'status' => 'active' ) )->latest()->first();
                if( empty($seller_package) ){
                    $response['type']       = 'error';
                    $response['title']      = __('general.error_title');
                    $response['message']    = __('general.package_buy_proposal');
                    return  $response;
                }else{

                    $setting            = getTPSetting(false, ['single_project_credits']);
                    $required_credits   = !empty($setting['single_project_credits'])  ? $setting['single_project_credits'] : 0;
                    
                    $package_options    = unserialize($seller_package->package_options);
                    $allow_quota    = $package_options['allow_quota'];
                    $rem_quota      = $package_options['rem_quota'];

                    $credits        = $rem_quota['credits'];
                    $expiry_date    = Carbon::parse($seller_package->package_expiry);
                    $current_date   = Carbon::now();
                    if( $current_date->gt($expiry_date) ){
                        $response['type']       = 'error';
                        $response['title']      = __('general.error_title');
                        $response['message']    = __('general.package_expired');
                        return  $response;
                    }elseif(!empty($params['apply_proposal']) && $allow_quota['credits'] > 0   && ($credits <= 0  || $credits < $required_credits ) ){
                        $response['type']       = 'error';
                        $response['title']      = __('general.error_title');
                        $response['message']    = __('general.package_credits_exceed');
                        return  $response;
                    }else{
                        $response['type']               = 'success'; 
                        $response['id']                 = $seller_package->id; 
                        $response['package_options']    = $package_options; 
                        return  $response;
                    }
                }
            }
        }
    }
}

/**
 * get user package details
 *
 * @return response()
 */
if (! function_exists('getPackageDetail')) {

    function getPackageDetail($params = array()) {

        $response = array();
        $package_detail =  PackageSubscriber::where( array( 'profile_id' => $params['id'], 'status' => 'active' ) )->latest()->first();
        if(empty($package_detail)){
            $response['type'] = 'error';
            return  $response;
        }else{
            $options  = unserialize($package_detail->options);
            if( $options['type'] == 'year' ){
                $expiry_date =  Carbon::parse($package_detail->updated_at)->addYear($options['duration'])->format('Y-m-d H:i:s');
            }elseif( $options['type'] == 'month' ){
                $expiry_date =  Carbon::parse($package_detail->updated_at)->addMonth($options['duration'])->format('Y-m-d H:i:s');
            }else{
                $expiry_date =  Carbon::parse($package_detail->updated_at)->addDays($options['duration'])->format('Y-m-d H:i:s');
            }
            $current_date   = Carbon::now()->format('Y-m-d H:i:s');
            if($current_date->gt($expiry_date)){
                $response['type']       = 'error';
                $response['title']      = __('general.error_title');
                $response['message']    = __('general.package_expired');
                return  $response;
            }else{
                $response['type']       = 'success';
                $response['detail']     = array(
                    'options' => $options,
                );
                return  $response;
            }
        }
    }
}    


/**
 *get status tag
 *
 * @return response()
 */
if (! function_exists('getPointerTag')) {

    function getPointerTag($status) {
        
        $lable = $status_class  = "";
        switch( $status ){
            case 'activated': 
                $status_class   = 'tk-success-pointer';
            break;
            case 'queued': 
                $status_class   = 'tk-awaiting-pointer';
            break;
            case 'disputed': 
                $status_class   = 'tk-dispute-pointer';
            break;          
            case 'refunded': 
                $status_class   = 'tk-success-pointer';
            break;
            case 'completed': 
                $status_class   = 'tk-success-pointer';
            break;
            case 'hired': 
                $status_class   = 'tk-ongoing-pointer';
            break;
            default:
                $status_class   = '';
            break;
        }

        return array(
            'class' => $status_class,
           );

    }
}

/**
 *get status tag
 *
 * @return response()
 */
if (! function_exists('getTag')) {

    function getTag($status) {
        
        $lable = $status_class  = "";
        switch( $status ){

            case 'pending':
                $label          = __('general.pending'); 
                $status_class   = 'tk-project-tag tk-awaiting';
            break;
            case 'activated':
                $label          = __('general.activated'); 
                $status_class   = 'tk-project-tag tk-success-tag';
            break;
            case 'deactivated':
                $label          = __('general.deactivated'); 
                $status_class   = 'tk-project-tag tk-canceled';
            break;
            case 'processing':
                $label          = __('general.processing'); 
                $status_class   = 'tk-project-tag tk-awaiting';
            break;
            case 'processed':
                $label          = __('general.processed'); 
                $status_class   = 'tk-project-tag tk-ongoing';
            break;
            case 'queued':
                $label          = __('general.queued'); 
                $status_class   = 'tk-project-tag';
            break;
            case 'disputed':
                $label          =  __('general.disputed'); 
                $status_class   = 'tk-project-tag tk-awaiting';
            break;
            case 'draft':
                $label          = __('general.draft'); 
                $status_class   = 'tk-project-tag';
            break;
            case 'publish':
                $label          = __('general.publish'); 
                $status_class   = 'tk-project-tag tk-awaiting';
            break;
            case 'refunded':
                $label          = __('general.refunded'); 
                $status_class   = 'tk-project-tag tk-canceled';
            break;
            case 'completed':
                $label          = __('general.completed'); 
                $status_class   = 'tk-project-tag tk-success-tag';
            break;
            case 'rejected':
                $label          = __('general.rejected'); 
                $status_class   = 'tk-project-tag tk-canceled';
            break;
            case 'cancelled':
                $label          = __('general.declined'); 
                $status_class   = 'tk-project-tag tk-canceled';
            case 'declined':
                $label          = __('general.declined'); 
                $status_class   = 'tk-project-tag tk-canceled';
            break;
            case 'hired':
                $label          = __('general.hired'); 
                $status_class   = 'tk-project-tag tk-ongoing';
            break;

            case 'active':
                $label          = __('general.active'); 
                $status_class   = 'tk-project-tag tk-active';
            break;

            case 'deactive':
                $label          = __('general.deactive'); 
                $status_class   = 'tk-project-tag tk-disabled';
            break;

            default:
                $label          = __('general.new');
                $status_class   = 'tk-project-tag';
            break;

        }

       return array(
        'text'  => $label,
        'class' => $status_class,
       );
    }
}

/**
 *get dispute status tag
 *
 * @return response()
 */
if (! function_exists('getDisputeStatusTag')) {

    function getDisputeStatusTag($status) {
        
        $lable = $status_class  = "";
        switch( $status ){
            case 'publish':
                $label          = __('proposal.publish'); 
                $status_class   = 'tk-project-tag tk-ongoing';
                break;
            case 'declined':
                $label          = __('proposal.declined'); 
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            case 'refunded':
                $label          = __('proposal.refunded'); 
                $status_class   = 'tk-project-tag tk-success-tag';
                break;
            case 'disputed':
                $label          = __('proposal.disputed'); 
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'processing':
                $label          =  __('proposal.processing'); 
                $status_class   = 'tk-project-tag tk-awaiting';
                break;
            case 'cancelled':
                $label          = __('proposal.cancelled'); 
                $status_class   = 'tk-project-tag tk-canceled';
                break;
            default:
                $label          = __('proposal.new');
                $status_class   = 'tk-project-tag';
            break;

        }

       return array(
        'text'  => $label,
        'class' => $status_class,
       );
    }
}

/**
 *get project price format
 *
 * @return response()
 */
if (! function_exists('getProjectPriceFormat')) {

    function getProjectPriceFormat( $status,  $symbol,  $min_price, $max_price) {
        
        $price = "";
        switch( $status ){
            case 'fixed':
               $price =  $symbol.number_format($min_price, 2).' - '.$symbol.number_format($max_price, 2 );
            break;
            case 'hourly':
                $price =  $symbol.number_format($min_price, 2).' - '.$symbol.number_format($max_price, 2).'/hr';
            break;
        }

       return $price; 
    }   
}

/**
 *get price format
 *
 * @return response()
 */
if (! function_exists('getPriceFormat') ) {

    function getPriceFormat( $symbol, $price) {
        $price = $symbol.number_format($price, 2);
       return $price; 
    }
}

if( ! function_exists('getHourlyTimeInterval') ){

    function getHourlyTimeInterval( $hiring_date, $type) {
       
        $dates = [];
        $current_date = Carbon::parse(Carbon::now()->format('Y-m-d'));

        if( $type == 'daily' ){
            
            $hiring_date = Carbon::parse($hiring_date)->format('Y-m-d');
            $period = CarbonPeriod::create($hiring_date, $current_date);
            
            foreach($period->toArray() as $single ){
                $selected = false;
                $date           = Carbon::parse($single);
                $key            = $date->format('Y-m-d');
                if( $key == $current_date->format('Y-m-d') ){
                    $selected = true;
                }
                $dates[$key]    = array(
                    'selected'  => $selected,
                    'value'     =>  $date->format('M d, Y')
                );
            }
        }elseif( $type == 'weekly' ){
            
            $hiring_date = Carbon::parse(Carbon::parse($hiring_date)->format('Y-m-d'));
            for($i = 1; $hiring_date->lte($current_date); $i++){

                $selected = false;
                $start  = Carbon::parse($hiring_date->copy()->startOfWeek(Carbon::MONDAY));
                $end    = Carbon::parse( $hiring_date->copy()->endOfWeek(Carbon::SUNDAY));
                $key    = $start->format('Y-m-d').'_'.$end->format('Y-m-d');
               
                if( $current_date->gte($start) &&  $current_date->lte($end) ){
                    $selected = true;
                }
                
                $dates[$key]    = array(
                    'selected'  => $selected,
                    'value'     =>  $start->format('M d, y') .' - '. $end->format('M d, y')
                );
                
                $hiring_date->addDays(1);
                
            }
        }else{

            $period = CarbonPeriod::create(clone Carbon::parse($hiring_date)->startOfMonth(), '1 month', $current_date);
            
            foreach($period->toArray() as $single ){

                $selected       = false;
                $date           = Carbon::parse($single);
                $key            = $date->firstOfMonth()->format('Y-m-d').'_'.$date->endOfMonth()->format('Y-m-d');

                if( $current_date->gte($date->firstOfMonth()) &&  $current_date->lte($date->endOfMonth()) ){
                    $selected = true;
                }
                $dates[$key]    = array(
                    'selected'  => $selected,
                    'value'     =>  $date->format('F, Y')
                );
                
            }
        }
        
       return $dates;
    } 
}

if( ! function_exists('getHourlyTimeSlots') ){

    function getHourlyTimeSlots($proposal_status, $hiring_date, $timecards, $selected_time, $type) {

        $selected_time = explode('_', $selected_time);
        $slots = $timecardDetail = [];
        if( !empty($timecards)){
            $timecardDetail = $timecards->timecardDetail->toArray();
        }

        $hiring_date  = Carbon::parse($hiring_date)->format('Y-m-d');
        $current_date = Carbon::now();
        
        if( $type == 'daily' ){

            $slots[] = array(
                'format'   => Carbon::parse($selected_time[0])->format('D, M d, Y'),
                'time'    => !empty($timecardDetail) ? $timecardDetail[0]['working_time'] : '',
            );

        }else{

           $start_date  =  $selected_time[0];
           $end_date    =  $selected_time[1];
           $period      = CarbonPeriod::create($start_date, $end_date);
           
            foreach($period->toArray() as $single ){
                
                $date_match = Carbon::parse($single)->format('Y-m-d');
                $disable = false;
                $card_detail = array_filter($timecardDetail, function($card) use($date_match){
                    return strtotime(date('Y-m-d', strtotime($card['working_date']))) == strtotime($date_match);
                });

                if( $proposal_status == 'completed' ){
                    $disable = true;
                }elseif( !empty($timecards) &&  ($timecards->status == 'queued' || $timecards->status == 'completed')){
                    $disable = true;
                }elseif( $current_date->lt($single) ){
                    $disable = true;
                }elseif( strtotime($hiring_date) > strtotime($single->format('Y-m-d')) ){
                    $disable = true;
                }
                if( $type == 'weekly' ){

                    $slots[] = array(
                        'day'       => Carbon::parse($single)->format('l'),
                        'format'    => Carbon::parse($single)->format('D,M d, Y'),
                        'time'      => !empty($card_detail) ? $card_detail[key($card_detail)]['working_time'] : '',
                        'disabled'  => $disable,
                    );
                }else{

                    $slots[] = array(
                        'day'       => Carbon::parse($single)->format('l'), 
                        'format'    => Carbon::parse($single)->format('F d, Y'),
                        'time'      => !empty($card_detail) ? $card_detail[key($card_detail)]['working_time'] : '',
                        'disabled'  => $disable,
                    );
                }
            }

        } 
        return $slots;   
    }
}

if( ! function_exists('setEnvironmentValue') ){
    function setEnvironmentValue(array $values) {

        $envFile = app()->environmentFilePath();
        $path = base_path('.env');
        $str = file_get_contents($path);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {

                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }

            }
        }
        
        $str = substr($str, 0, -1);
        if (!file_put_contents($path, $str)) return false;
        return true;

    }
}

/**
 *get proposal amount with admin commission
 *
 * @return response()
 */
if (! function_exists('getAmountWithcommission')) {

    function getAmountWithcommission( $params ){

        $setting            = getTPSetting(false, ['commission_setting']);
        $commission_setting  = !empty($setting['commission_setting'])  ? unserialize($setting['commission_setting']) : array();
        $commission_value    = $admin_share = 0;
        $commission_type     = 'free';
        $working_budget     = $seller_share = $params['proposal_amount'];
        
        if( !empty($commission_setting) ){

            $seller_share   = number_format($working_budget, 2, '.', '');
            $working_budget = number_format($working_budget, 2, '.', '');

            if( !empty($commission_setting['free']) ){
                $commission_type = 'free';
            }elseif( !empty($commission_setting['fixed']) ){

                if(!empty($commission_setting['fixed'][$params['project_type']])){

                    $admin_share        = $commission_setting['fixed'][$params['project_type']];
                    $commission_value   = $admin_share; 
                    $commission_type    = 'fixed';
                    $seller_share       = $working_budget - $admin_share;

                    $seller_share       = number_format($seller_share, 2,  '.',  '');
                    $admin_share        = number_format($admin_share, 2,  '.',  '');

                }

            }elseif( !empty($commission_setting['percentage']) ){

                if( !empty($commission_setting['percentage'][$params['project_type']]) ){
                    $commission_value   = $commission_setting['percentage'][$params['project_type']];
                    $commission_type    = 'percentage';
                    $admin_share 	    = $working_budget/100 * $commission_value;
		            $seller_share 	    = $working_budget - $admin_share;
                    $seller_share       = number_format($seller_share, 2,  '.',  '');
                    $admin_share        = number_format($admin_share, 2,  '.',  '');

                }

            }elseif( !empty($commission_setting['commission_tier']) ){
              
                if( !empty($commission_setting['commission_tier'][$params['project_type']]) ){

                    $commission_tiers = $commission_setting['commission_tier'][$params['project_type']];
                    $tier_value = array_filter($commission_tiers, function($single) use($working_budget) {
                        
                        $price_range = explode('-', $single['price_range']);
                        $min_price  = $price_range[0];
                        $max_price  = $price_range[1];
                        if( !empty($max_price) ){
                            return ( $working_budget > $min_price && $working_budget <= $max_price);  
                        }else{
                            return  $working_budget >= $min_price; 
                        }
                    });
                    if( !empty($tier_value) ){

                        $commission = $tier_value[key($tier_value)];

                        if( $commission['type'] == 'fixed' ){

                            $commission_type        = 'commission_tier_fixed';
                            $admin_share            = $commission['value'];
                            $commission_value       = $admin_share; 
                            $seller_share           = $working_budget - $admin_share;
                            $seller_share           = number_format($seller_share, 2,  '.',  '');
                            $admin_share            = number_format($admin_share, 2,  '.',  '');

                        }elseif( $commission['type'] == 'percentage' ){

                            $commission_type    = 'commission_tier_per';
                            $commission_value   = $commission['value'];
                            $admin_share 	    = $working_budget/100 * $commission_value;
                            $seller_share 	    = $working_budget - $admin_share;
                            $seller_share       = number_format($seller_share, 2,  '.',  '');
                            $admin_share        = number_format($admin_share, 2,  '.',  '');

                        }

                    }
                }
            }
        }

        return array(

            'commission_type'    => $commission_type,
            'commission_value'   => $commission_value,
            'working_budget'    => $working_budget,
            'admin_share'       => $admin_share,
            'seller_share'      => $seller_share,

        );
    }
}


/**
 *get user geocode details
 *
 * @return response()
 */

if(!function_exists('getGeoCodeInfo')) {

    function getGeoCodeInfo($postal_code='', $region_name='', $type='') {
        $geo_data = $geo_code_data  = $response	= array();
        $google_map_key             = setting('_api.google_map_key');
        $google_map_key             = !empty( $google_map_key ) ? $google_map_key : '';
      
		if(empty($google_map_key) ) {
			$response['type'] 			= 'error';
            $response['title'] 	        = __('general.error_title');
			$response['message'] 	    = __('general.api_key_not_found');
        }else{
            $geo_zip_code   = sanitizeTextField($postal_code);
			$region_name    = sanitizeTextField($region_name);
          
            
			$geo_request 	= 'https://maps.googleapis.com/maps/api/geocode/json?address='.$geo_zip_code.'&region='.$region_name.'&key='.$google_map_key;
			$geo_request    = Http::get($geo_request);
        
			if( $geo_request->failed() ){
                $response['type'] 			= 'error';
				$response['title'] 	        = __('general.error_title');
				$response['message'] 	    = __('general.went_wrong');
			}elseif($geo_request->status() == 200){
                
                $body = json_decode( $geo_request->body(), true );
               
              
                if ($body['status'] == 'OK') {

                    $geo_data = $body['results'][0];

                    for($i = 0; $i < count($geo_data['address_components']); $i++) {
                        $addressType = $geo_data['address_components'][$i]['types'][0];
        
                        if ($addressType == "locality") {
                            $geo_code_data['locality']['long_name'] 	= $geo_data['address_components'][$i]['long_name'];
                            $geo_code_data['locality']['short_name'] 	= $geo_data['address_components'][$i]['short_name'];
                        }
        
                        if ($addressType == "country") {
                            $geo_code_data['country']['long_name'] 	= $geo_data['address_components'][$i]['long_name'];
                            $geo_code_data['country']['short_name'] 	= $geo_data['address_components'][$i]['short_name'];
                        }
        
                        if($addressType == "administrative_area_level_1") {
                            $geo_code_data['administrative_area_level_1']['long_name'] 		= $geo_data['address_components'][$i]['long_name'];
                            $geo_code_data['administrative_area_level_1']['short_name'] 	= $geo_data['address_components'][$i]['short_name'];
                        }
        
                        if ($addressType == "administrative_area_level_2") {
                            $geo_code_data['administrative_area_level_1']['long_name'] 		= $geo_data['address_components'][$i]['long_name'];
                            $geo_code_data['administrative_area_level_1']['short_name'] 	= $geo_data['address_components'][$i]['short_name'];
                        }
        
                        $geo_code_data['address'] 	= $geo_data['formatted_address'];
                        $geo_code_data['lng'] 		= $geo_data['geometry']['location']['lng'];
                        $geo_code_data['lat'] 		= $geo_data['geometry']['location']['lat'];
        
                    }
                    $found_region	= !empty($geo_code_data['country']['short_name']) ? $geo_code_data['country']['short_name'] : '';
                    if(!empty($found_region) && $found_region != $region_name ){
                        $response['type'] 			= 'error';
                        $response['title'] 	        = __('general.error_title');
                        $response['message'] 	    = __('general.zipcode_error');
                    }else{
                        $response['type']           = 'success';
                        $response['geo_data']   = $geo_code_data;
                    }
                }else{
                    $response['type'] 			= 'error';
                    $response['title'] 	        = __('general.error_title');
                    $response['message'] 	    = __('general.zipcode_error');
                }
			}
		}
        return $response;
    }
}


/**
 *get user wallet available balance
 *
 * @return response()
 */
if(!function_exists('getUserWalletAmount')){
    function getUserWalletAmount(){
        
        $userInfo           = getUserRole();
        $profileId          = $userInfo['profileId'];
        $currency           = setting('_general.currency');
        $currency_detail    = !empty( $currency) ? currencyList($currency) : array();
        $symbol             = '';
        $walletAmount       = 0;

        if( !empty($currency_detail['symbol']) ){
            $symbol = $currency_detail['symbol'];
        }

        $walletAmount = UserWallet::where( 'profile_id', $profileId )->latest()->first(['amount']);
        if(!empty($walletAmount)){
            $walletAmount = $walletAmount->amount;
        }

        return $symbol.number_format($walletAmount, 2);
        
    }
}

/**
 * check is decimal value or not
 *
 * @return response()
 */

if (!function_exists('is_decimal')) {
    function is_decimal($n) {
        // Note that floor returns a float 
        return is_numeric($n) && floor($n) != $n;
    }
}

/**
 *show the formated rating
 *
 * @return response()
 */

if (!function_exists('ratingFormat')) {

    function ratingFormat($rating){
        if(empty($rating)){
            return 0;
        }else {
            if( is_decimal($rating) ){
                return number_format($rating, 2); 
            } else {
                return number_format($rating);
            }
        }
    }
}


/**
 *get user address details
 *
 * @return response()
 */

if (!function_exists('getUserAddress')) {

    function getUserAddress($location, $address_format){
        
        $address        = '';
        $location       = unserialize($location);
        $address        = !empty($location['country']['long_name']) ? $location['country']['long_name'] : '';
        if (!empty($address_format) && $address_format == 'state_country'){
            $state  = !empty($location['administrative_area_level_1']['long_name']) ? $location['administrative_area_level_1']['long_name'] : '';

            if (!empty($state)) {
                $address    = $state . ', ' . $address;
            }

        }elseif (!empty($address_format) && $address_format == 'city_country'){
            $city  = !empty($location['locality']['long_name']) ? $location['locality']['long_name'] : '';

            if (!empty($city)) {
                $address    = $city . ', ' . $address;
            }

        }elseif (!empty($address_format) && $address_format == 'city_state_country'){
            $state  = !empty($location['administrative_area_level_1']['long_name']) ? $location['administrative_area_level_1']['long_name'] : '';
            $city   = !empty($location['locality']['long_name']) ? $location['locality']['long_name'] : '';

            if (!empty($state)) {
                $address    = $state . ', ' . $address;
            }

            if (!empty($city)) {
                $address    = $city . ', ' . $address;
            }
        }

        return $address;
    }
}

/**
 *get time difference
 *
 * @return response()
 */

if (!function_exists('getTimeDiff')) {

    function getTimeDiff($datetime){
        $difference = Carbon::parse($datetime)->diffForHumans();
        return $difference;
    }
}



 /**
 * Currency options for payment
 *
 * @param string $code code
 * @return array
 */
if ( !function_exists('inspectionPeriodOptions') ) {

    function inspectionPeriodOptions() {

        $max_inspection_day_opt = 20;
        $inspection_day_opt = [];
        for( $i=1; $i <= $max_inspection_day_opt; $i++){
            $inspection_day_opt[$i] = $i == 1 ? __('settings.insp_period_opt_day1') : __('settings.insp_period_opt_day',['day_count' => $i]);
        }
        return $inspection_day_opt;
    }
}

 /**
 * Currency options for payment
 *
 * @param string $code code
 * @return array
 */
if ( !function_exists('currencyOptionForPayment') ) {

    function currencyOptionForPayment() {

        $currency_opt = [
            'USD' => __('settings.escrow_currency_opt_usd'),
            'EUR' => __('settings.escrow_currency_opt_eur'),
            'AUD' => __('settings.escrow_currency_opt_aud'),
            'GBP' => __('settings.escrow_currency_opt_gbp'),
            'CAD' => __('settings.escrow_currency_opt_cad'),
        ];
        return $currency_opt;
    }
}
 /**
 * commission range list
 *
 * @param string $code code
 * @return array
 */
if ( !function_exists('commissionRange') ) {

    function commissionRange( $type = 'fixed', $symbol = ''){
      
        $hourly_price_rnage = $fixed_price_range = [];

        $range = [500,1000,2000,3000,4000,5000,10000,20000,30000,40000,50000,60000,70000,80000,90000,100000, 100001];

        for( $j=0; $j < count($range); $j++){

            $min = $range[$j] == 500 ? 1 : $range[$j-1];
            $max = $range[$j];
            $key = $min.'-'.$max;

            if( $max == 100001 ){
                $fixed_price_range[$min.'-'] = __( 'settings.maximum_range',['value' => $symbol.number_format(100000) ]); 
            }else {
                $fixed_price_range[$key] = $symbol.number_format( $min).' - '.$symbol.number_format($max);
            }
        }

        for( $i=0; $i <= 150; $i +=10 ){
            $min = $i == 0 ? 1 : $i;
            $max = $i+10;
            $key = $min.'-'.$max; 
            if( $min == 150 ){
                $hourly_price_rnage[$min.'-'] = __( 'settings.maximum_range',['value' => $symbol.number_format(150) ]); 
            }else {
                $hourly_price_rnage[$key] = $symbol.number_format( $min).' - '.$symbol.number_format($max);
            }
        }

        return $type == 'fixed' ? $fixed_price_range : $hourly_price_rnage;
    }
}

 /**
 * Currency list
 *
 * @param string $code code
 * @return array
 */
if ( !function_exists('currencyList') ) {

    function currencyList( $code = "" ){

        $currency_array = array (
            'USD' => array (
                'numeric_code'  => 840 ,
                'code'          => 'USD' ,
                'name'          => 'United States dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent[D]' ,
                'decimals'      => 2 ) ,
            'AED' => array (
                'numeric_code'  => 784 ,
                'code'          => 'AED' ,
                'name'          => 'United Arab Emirates dirham' ,
                'symbol'        => 'د.إ' ,
                'fraction_name' => 'Fils' ,
                'decimals'      => 2 ) ,
            'AFN' => array (
                'numeric_code'  => 971 ,
                'code'          => 'AFN' ,
                'name'          => 'Afghan afghani' ,
                'symbol'        => '؋' ,
                'fraction_name' => 'Pul' ,
                'decimals'      => 2 ) ,
            'ALL' => array (
                'numeric_code'  => 8 ,
                'code'          => 'ALL' ,
                'name'          => 'Albanian lek' ,
                'symbol'        => 'L' ,
                'fraction_name' => 'Qintar' ,
                'decimals'      => 2 ) ,
            'AMD' => array (
                'numeric_code'  => 51 ,
                'code'          => 'AMD' ,
                'name'          => 'Armenian dram' ,
                'symbol'        => 'դր.' ,
                'fraction_name' => 'Luma' ,
                'decimals'      => 2 ) ,
            'AMD' => array (
                'numeric_code'  => 51 ,
                'code'          => 'AMD' ,
                'name'          => 'Armenian dram' ,
                'symbol'        => 'դր.' ,
                'fraction_name' => 'Luma' ,
                'decimals'      => 2 ) ,
            'ANG' => array (
                'numeric_code'  => 532 ,
                'code'          => 'ANG' ,
                'name'          => 'Netherlands Antillean guilder' ,
                'symbol'        => 'ƒ' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'AOA' => array (
                'numeric_code'  => 973 ,
                'code'          => 'AOA' ,
                'name'          => 'Angolan kwanza' ,
                'symbol'        => 'Kz' ,
                'fraction_name' => 'Cêntimo' ,
                'decimals'      => 2 ) ,
            'ARS' => array (
                'numeric_code'  => 32 ,
                'code'          => 'ARS' ,
                'name'          => 'Argentine peso' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'AUD' => array (
                'numeric_code'  => 36 ,
                'code'          => 'AUD' ,
                'name'          => 'Australian dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'AWG' => array (
                'numeric_code'  => 533 ,
                'code'          => 'AWG' ,
                'name'          => 'Aruban florin' ,
                'symbol'        => 'ƒ' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'AZN' => array (
                'numeric_code'  => 944 ,
                'code'          => 'AZN' ,
                'name'          => 'Azerbaijani manat' ,
                'symbol'        => 'AZN' ,
                'fraction_name' => 'Qəpik' ,
                'decimals'      => 2 ) ,
            'BAM' => array (
                'numeric_code'  => 977 ,
                'code'          => 'BAM' ,
                'name'          => 'Bosnia and Herzegovina convertible mark' ,
                'symbol'        => 'КМ' ,
                'fraction_name' => 'Fening' ,
                'decimals'      => 2 ) ,
            'BBD' => array (
                'numeric_code'  => 52 ,
                'code'          => 'BBD' ,
                'name'          => 'Barbadian dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'BDT' => array (
                'numeric_code'  => 50 ,
                'code'          => 'BDT' ,
                'name'          => 'Bangladeshi taka' ,
                'symbol'        => '৳' ,
                'fraction_name' => 'Paisa' ,
                'decimals'      => 2 ) ,
            'BGN' => array (
                'numeric_code'  => 975 ,
                'code'          => 'BGN' ,
                'name'          => 'Bulgarian lev' ,
                'symbol'        => 'лв' ,
                'fraction_name' => 'Stotinka' ,
                'decimals'      => 2 ) ,
            'BHD' => array (
                'numeric_code'  => 48 ,
                'code'          => 'BHD' ,
                'name'          => 'Bahraini dinar' ,
                'symbol'        => 'ب.د' ,
                'fraction_name' => 'Fils' ,
                'decimals'      => 3 ) ,
            'BIF' => array (
                'numeric_code'  => 108 ,
                'code'          => 'BIF' ,
                'name'          => 'Burundian franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'BMD' => array (
                'numeric_code'  => 60 ,
                'code'          => 'BMD' ,
                'name'          => 'Bermudian dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'BND' => array (
                'numeric_code'  => 96 ,
                'code'          => 'BND' ,
                'name'          => 'Brunei dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Sen' ,
                'decimals'      => 2 ) ,
            'BND' => array (
                'numeric_code'  => 96 ,
                'code'          => 'BND' ,
                'name'          => 'Brunei dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Sen' ,
                'decimals'      => 2 ) ,
            'BOB' => array (
                'numeric_code'  => 68 ,
                'code'          => 'BOB' ,
                'name'          => 'Bolivian boliviano' ,
                'symbol'        => 'Bs.' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'BRL' => array (
                'numeric_code'  => 986 ,
                'code'          => 'BRL' ,
                'name'          => 'Brazilian real' ,
                'symbol'        => 'R$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'BSD' => array (
                'numeric_code'  => 44 ,
                'code'          => 'BSD' ,
                'name'          => 'Bahamian dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'BTN' => array (
                'numeric_code'  => 64 ,
                'code'          => 'BTN' ,
                'name'          => 'Bhutanese ngultrum' ,
                'symbol'        => 'BTN' ,
                'fraction_name' => 'Chertrum' ,
                'decimals'      => 2 ) ,
            'BWP' => array (
                'numeric_code'  => 72 ,
                'code'          => 'BWP' ,
                'name'          => 'Botswana pula' ,
                'symbol'        => 'P' ,
                'fraction_name' => 'Thebe' ,
                'decimals'      => 2 ) ,
            'BWP' => array (
                'numeric_code'  => 72 ,
                'code'          => 'BWP' ,
                'name'          => 'Botswana pula' ,
                'symbol'        => 'P' ,
                'fraction_name' => 'Thebe' ,
                'decimals'      => 2 ) ,
            'BYR' => array (
                'numeric_code'  => 974 ,
                'code'          => 'BYR' ,
                'name'          => 'Belarusian ruble' ,
                'symbol'        => 'Br' ,
                'fraction_name' => 'Kapyeyka' ,
                'decimals'      => 2 ) ,
            'BZD' => array (
                'numeric_code'  => 84 ,
                'code'          => 'BZD' ,
                'name'          => 'Belize dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'CAD' => array (
                'numeric_code'  => 124 ,
                'code'          => 'CAD' ,
                'name'          => 'Canadian dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'CDF' => array (
                'numeric_code'  => 976 ,
                'code'          => 'CDF' ,
                'name'          => 'Congolese franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'CHF' => array (
                'numeric_code'  => 756 ,
                'code'          => 'CHF' ,
                'name'          => 'Swiss franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Rappen[I]' ,
                'decimals'      => 2 ) ,
            'CLP' => array (
                'numeric_code'  => 152 ,
                'code'          => 'CLP' ,
                'name'          => 'Chilean peso' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'CNY' => array (
                'numeric_code'  => 156 ,
                'code'          => 'CNY' ,
                'name'          => 'Chinese yuan' ,
                'symbol'        => '元' ,
                'fraction_name' => 'Fen[E]' ,
                'decimals'      => 2 ) ,
            'COP' => array (
                'numeric_code'  => 170 ,
                'code'          => 'COP' ,
                'name'          => 'Colombian peso' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'CRC' => array (
                'numeric_code'  => 188 ,
                'code'          => 'CRC' ,
                'name'          => 'Costa Rican colón' ,
                'symbol'        => '₡' ,
                'fraction_name' => 'Céntimo' ,
                'decimals'      => 2 ) ,
            'CUC' => array (
                'numeric_code'  => 931 ,
                'code'          => 'CUC' ,
                'name'          => 'Cuban convertible peso' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'CUP' => array (
                'numeric_code'  => 192 ,
                'code'          => 'CUP' ,
                'name'          => 'Cuban peso' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'CVE' => array (
                'numeric_code'  => 132 ,
                'code'          => 'CVE' ,
                'name'          => 'Cape Verdean escudo' ,
                'symbol'        => 'Esc' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'CZK' => array (
                'numeric_code'  => 203 ,
                'code'          => 'CZK' ,
                'name'          => 'Czech koruna' ,
                'symbol'        => 'Kc' ,
                'fraction_name' => 'Haléř' ,
                'decimals'      => 2 ) ,
            'DJF' => array (
                'numeric_code'  => 262 ,
                'code'          => 'DJF' ,
                'name'          => 'Djiboutian franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'DKK' => array (
                'numeric_code'  => 208 ,
                'code'          => 'DKK' ,
                'name'          => 'Danish krone' ,
                'symbol'        => 'kr' ,
                'fraction_name' => 'Øre' ,
                'decimals'      => 2 ) ,
            'DKK' => array (
                'numeric_code'  => 208 ,
                'code'          => 'DKK' ,
                'name'          => 'Danish krone' ,
                'symbol'        => 'kr' ,
                'fraction_name' => 'Øre' ,
                'decimals'      => 2 ) ,
            'DOP' => array (
                'numeric_code'  => 214 ,
                'code'          => 'DOP' ,
                'name'          => 'Dominican peso' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'DZD' => array (
                'numeric_code'  => 12 ,
                'code'          => 'DZD' ,
                'name'          => 'Algerian dinar' ,
                'symbol'        => 'د.ج' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'EEK' => array (
                'numeric_code'  => 233 ,
                'code'          => 'EEK' ,
                'name'          => 'Estonian kroon' ,
                'symbol'        => 'KR' ,
                'fraction_name' => 'Sent' ,
                'decimals'      => 2 ) ,
            'EGP' => array (
                'numeric_code'  => 818 ,
                'code'          => 'EGP' ,
                'name'          => 'Egyptian pound' ,
                'symbol'        => '£' ,
                'fraction_name' => 'Piastre[F]' ,
                'decimals'      => 2 ) ,
            'ERN' => array (
                'numeric_code'  => 232 ,
                'code'          => 'ERN' ,
                'name'          => 'Eritrean nakfa' ,
                'symbol'        => 'Nfk' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'ETB' => array (
                'numeric_code'  => 230 ,
                'code'          => 'ETB' ,
                'name'          => 'Ethiopian birr' ,
                'symbol'        => 'ETB' ,
                'fraction_name' => 'Santim' ,
                'decimals'      => 2 ) ,
            'EUR' => array (
                'numeric_code'  => 978 ,
                'code'          => 'EUR' ,
                'name'          => 'Euro' ,
                'symbol'        => '€' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'FJD' => array (
                'numeric_code'  => 242 ,
                'code'          => 'FJD' ,
                'name'          => 'Fijian dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'FKP' => array (
                'numeric_code'  => 238 ,
                'code'          => 'FKP' ,
                'name'          => 'Falkland Islands pound' ,
                'symbol'        => '£' ,
                'fraction_name' => 'Penny' ,
                'decimals'      => 2 ) ,
            'GBP' => array (
                'numeric_code'  => 826 ,
                'code'          => 'GBP' ,
                'name'          => 'British pound[C]' ,
                'symbol'        => '£' ,
                'fraction_name' => 'Penny' ,
                'decimals'      => 2 ) ,
            'GEL' => array (
                'numeric_code'  => 981 ,
                'code'          => 'GEL' ,
                'name'          => 'Georgian lari' ,
                'symbol'        => 'ლ' ,
                'fraction_name' => 'Tetri' ,
                'decimals'      => 2 ) ,
            'GHS' => array (
                'numeric_code'  => 936 ,
                'code'          => 'GHS' ,
                'name'          => 'Ghanaian cedi' ,
                'symbol'        => '₵' ,
                'fraction_name' => 'Pesewa' ,
                'decimals'      => 2 ) ,
            'GIP' => array (
                'numeric_code'  => 292 ,
                'code'          => 'GIP' ,
                'name'          => 'Gibraltar pound' ,
                'symbol'        => '£' ,
                'fraction_name' => 'Penny' ,
                'decimals'      => 2 ) ,
            'GMD' => array (
                'numeric_code'  => 270 ,
                'code'          => 'GMD' ,
                'name'          => 'Gambian dalasi' ,
                'symbol'        => 'D' ,
                'fraction_name' => 'Butut' ,
                'decimals'      => 2 ) ,
            'GNF' => array (
                'numeric_code'  => 324 ,
                'code'          => 'GNF' ,
                'name'          => 'Guinean franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'GTQ' => array (
                'numeric_code'  => 320 ,
                'code'          => 'GTQ' ,
                'name'          => 'Guatemalan quetzal' ,
                'symbol'        => 'Q' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'GYD' => array (
                'numeric_code'  => 328 ,
                'code'          => 'GYD' ,
                'name'          => 'Guyanese dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'HKD' => array (
                'numeric_code'  => 344 ,
                'code'          => 'HKD' ,
                'name'          => 'Hong Kong dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'HNL' => array (
                'numeric_code'  => 340 ,
                'code'          => 'HNL' ,
                'name'          => 'Honduran lempira' ,
                'symbol'        => 'L' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'HRK' => array (
                'numeric_code'  => 191 ,
                'code'          => 'HRK' ,
                'name'          => 'Croatian kuna' ,
                'symbol'        => 'kn' ,
                'fraction_name' => 'Lipa' ,
                'decimals'      => 2 ) ,
            'HTG' => array (
                'numeric_code'  => 332 ,
                'code'          => 'HTG' ,
                'name'          => 'Haitian gourde' ,
                'symbol'        => 'G' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'HUF' => array (
                'numeric_code'  => 348 ,
                'code'          => 'HUF' ,
                'name'          => 'Hungarian forint' ,
                'symbol'        => 'Ft' ,
                'fraction_name' => 'Fillér' ,
                'decimals'      => 2 ) ,
            'IDR' => array (
                'numeric_code'  => 360 ,
                'code'          => 'IDR' ,
                'name'          => 'Indonesian rupiah' ,
                'symbol'        => 'Rp' ,
                'fraction_name' => 'Sen' ,
                'decimals'      => 2 ) ,
            'ILS' => array (
                'numeric_code'  => 376 ,
                'code'          => 'ILS' ,
                'name'          => 'Israeli new sheqel' ,
                'symbol'        => '₪' ,
                'fraction_name' => 'Agora' ,
                'decimals'      => 2 ) ,
            'INR' => array (
                'numeric_code'  => 356 ,
                'code'          => 'INR' ,
                'name'          => 'Indian rupee' ,
                'symbol'        => '₹' ,
                'fraction_name' => 'Paisa' ,
                'decimals'      => 2 ) ,
            'IQD' => array (
                'numeric_code'  => 368 ,
                'code'          => 'IQD' ,
                'name'          => 'Iraqi dinar' ,
                'symbol'        => 'ع.د' ,
                'fraction_name' => 'Fils' ,
                'decimals'      => 3 ) ,
            'IRR' => array (
                'numeric_code'  => 364 ,
                'code'          => 'IRR' ,
                'name'          => 'Iranian rial' ,
                'symbol'        => '' ,
                'fraction_name' => 'Dinar' ,
                'decimals'      => 2 ) ,
            'ISK' => array (
                'numeric_code'  => 352 ,
                'code'          => 'ISK' ,
                'name'          => 'Icelandic króna' ,
                'symbol'        => 'kr' ,
                'fraction_name' => 'Eyrir' ,
                'decimals'      => 2 ) ,
            'JMD' => array (
                'numeric_code'  => 388 ,
                'code'          => 'JMD' ,
                'name'          => 'Jamaican dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'JOD' => array (
                'numeric_code'  => 400 ,
                'code'          => 'JOD' ,
                'name'          => 'Jordanian dinar' ,
                'symbol'        => 'د.ا' ,
                'fraction_name' => 'Piastre[H]' ,
                'decimals'      => 2 ) ,
            'JPY' => array (
                'numeric_code'  => 392 ,
                'code'          => 'JPY' ,
                'name'          => 'Japanese yen' ,
                'symbol'        => '¥' ,
                'fraction_name' => 'Sen[G]' ,
                'decimals'      => 2 ) ,
            'KES' => array (
                'numeric_code'  => 404 ,
                'code'          => 'KES' ,
                'name'          => 'Kenyan shilling' ,
                'symbol'        => 'Sh' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'KGS' => array (
                'numeric_code'  => 417 ,
                'code'          => 'KGS' ,
                'name'          => 'Kyrgyzstani som' ,
                'symbol'        => 'KGS' ,
                'fraction_name' => 'Tyiyn' ,
                'decimals'      => 2 ) ,
            'KHR' => array (
                'numeric_code'  => 116 ,
                'code'          => 'KHR' ,
                'name'          => 'Cambodian riel' ,
                'symbol'        => '៛' ,
                'fraction_name' => 'Sen' ,
                'decimals'      => 2 ) ,
            'KMF' => array (
                'numeric_code'  => 174 ,
                'code'          => 'KMF' ,
                'name'          => 'Comorian franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'KPW' => array (
                'numeric_code'  => 408 ,
                'code'          => 'KPW' ,
                'name'          => 'North Korean won' ,
                'symbol'        => '' ,
                'fraction_name' => 'Chŏn' ,
                'decimals'      => 2 ) ,
            'KRW' => array (
                'numeric_code'  => 410 ,
                'code'          => 'KRW' ,
                'name'          => 'South Korean won' ,
                'symbol'        => '' ,
                'fraction_name' => 'Jeon' ,
                'decimals'      => 2 ) ,
            'KWD' => array (
                'numeric_code'  => 414 ,
                'code'          => 'KWD' ,
                'name'          => 'Kuwaiti dinar' ,
                'symbol'        => 'د.ك' ,
                'fraction_name' => 'Fils' ,
                'decimals'      => 3 ) ,
            'KYD' => array (
                'numeric_code'  => 136 ,
                'code'          => 'KYD' ,
                'name'          => 'Cayman Islands dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'KZT' => array (
                'numeric_code'  => 398 ,
                'code'          => 'KZT' ,
                'name'          => 'Kazakhstani tenge' ,
                'symbol'        => '〒' ,
                'fraction_name' => 'Tiyn' ,
                'decimals'      => 2 ) ,
            'LAK' => array (
                'numeric_code'  => 418 ,
                'code'          => 'LAK' ,
                'name'          => 'Lao kip' ,
                'symbol'        => '' ,
                'fraction_name' => 'Att' ,
                'decimals'      => 2 ) ,
            'LBP' => array (
                'numeric_code'  => 422 ,
                'code'          => 'LBP' ,
                'name'          => 'Lebanese pound' ,
                'symbol'        => 'ل.ل' ,
                'fraction_name' => 'Piastre' ,
                'decimals'      => 2 ) ,
            'LKR' => array (
                'numeric_code'  => 144 ,
                'code'          => 'LKR' ,
                'name'          => 'Sri Lankan rupee' ,
                'symbol'        => 'Rs' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'LRD' => array (
                'numeric_code'  => 430 ,
                'code'          => 'LRD' ,
                'name'          => 'Liberian dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'LSL' => array (
                'numeric_code'  => 426 ,
                'code'          => 'LSL' ,
                'name'          => 'Lesotho loti' ,
                'symbol'        => 'L' ,
                'fraction_name' => 'Sente' ,
                'decimals'      => 2 ) ,
            'LTL' => array (
                'numeric_code'  => 440 ,
                'code'          => 'LTL' ,
                'name'          => 'Lithuanian litas' ,
                'symbol'        => 'Lt' ,
                'fraction_name' => 'Centas' ,
                'decimals'      => 2 ) ,
            'LVL' => array (
                'numeric_code'  => 428 ,
                'code'          => 'LVL' ,
                'name'          => 'Latvian lats' ,
                'symbol'        => 'Ls' ,
                'fraction_name' => 'Santims' ,
                'decimals'      => 2 ) ,
            'LYD' => array (
                'numeric_code'  => 434 ,
                'code'          => 'LYD' ,
                'name'          => 'Libyan dinar' ,
                'symbol'        => 'ل.د' ,
                'fraction_name' => 'Dirham' ,
                'decimals'      => 3 ) ,
            'MAD' => array (
                'numeric_code'  => 504 ,
                'code'          => 'MAD' ,
                'name'          => 'Moroccan dirham' ,
                'symbol'        => 'Dh' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'MDL' => array (
                'numeric_code'  => 498 ,
                'code'          => 'MDL' ,
                'name'          => 'Moldovan leu' ,
                'symbol'        => 'L' ,
                'fraction_name' => 'Ban' ,
                'decimals'      => 2 ) ,
            'MGA' => array (
                'numeric_code'  => 969 ,
                'code'          => 'MGA' ,
                'name'          => 'Malagasy ariary' ,
                'symbol'        => 'MGA' ,
                'fraction_name' => 'Iraimbilanja' ,
                'decimals'      => 5 ) ,
            'MKD' => array (
                'numeric_code'  => 807 ,
                'code'          => 'MKD' ,
                'name'          => 'Macedonian denar' ,
                'symbol'        => 'ден' ,
                'fraction_name' => 'Deni' ,
                'decimals'      => 2 ) ,
            'MMK' => array (
                'numeric_code'  => 104 ,
                'code'          => 'MMK' ,
                'name'          => 'Myanma kyat' ,
                'symbol'        => 'K' ,
                'fraction_name' => 'Pya' ,
                'decimals'      => 2 ) ,
            'MNT' => array (
                'numeric_code'  => 496 ,
                'code'          => 'MNT' ,
                'name'          => 'Mongolian tögrög' ,
                'symbol'        => '' ,
                'fraction_name' => 'Möngö' ,
                'decimals'      => 2 ) ,
            'MOP' => array (
                'numeric_code'  => 446 ,
                'code'          => 'MOP' ,
                'name'          => 'Macanese pataca' ,
                'symbol'        => 'P' ,
                'fraction_name' => 'Avo' ,
                'decimals'      => 2 ) ,
            'MRO' => array (
                'numeric_code'  => 478 ,
                'code'          => 'MRO' ,
                'name'          => 'Mauritanian ouguiya' ,
                'symbol'        => 'UM' ,
                'fraction_name' => 'Khoums' ,
                'decimals'      => 5 ) ,
            'MUR' => array (
                'numeric_code'  => 480 ,
                'code'          => 'MUR' ,
                'name'          => 'Mauritian rupee' ,
                'symbol'        => '' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'MVR' => array (
                'numeric_code'  => 462 ,
                'code'          => 'MVR' ,
                'name'          => 'Maldivian rufiyaa' ,
                'symbol'        => 'ރ.' ,
                'fraction_name' => 'Laari' ,
                'decimals'      => 2 ) ,
            'MWK' => array (
                'numeric_code'  => 454 ,
                'code'          => 'MWK' ,
                'name'          => 'Malawian kwacha' ,
                'symbol'        => 'MK' ,
                'fraction_name' => 'Tambala' ,
                'decimals'      => 2 ) ,
            'MXN' => array (
                'numeric_code'  => 484 ,
                'code'          => 'MXN' ,
                'name'          => 'Mexican peso' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'MYR' => array (
                'numeric_code'  => 458 ,
                'code'          => 'MYR' ,
                'name'          => 'Malaysian ringgit' ,
                'symbol'        => 'RM' ,
                'fraction_name' => 'Sen' ,
                'decimals'      => 2 ) ,
            'MZN' => array (
                'numeric_code'  => 943 ,
                'code'          => 'MZN' ,
                'name'          => 'Mozambican metical' ,
                'symbol'        => 'MTn' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'NAD' => array (
                'numeric_code'  => 516 ,
                'code'          => 'NAD' ,
                'name'          => 'Namibian dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'NGN' => array (
                'numeric_code'  => 566 ,
                'code'          => 'NGN' ,
                'name'          => 'Nigerian naira' ,
                'symbol'        => '₦' ,
                'fraction_name' => 'Kobo' ,
                'decimals'      => 2 ) ,
            'NIO' => array (
                'numeric_code'  => 558 ,
                'code'          => 'NIO' ,
                'name'          => 'Nicaraguan córdoba' ,
                'symbol'        => 'C$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'NOK' => array (
                'numeric_code'  => 578 ,
                'code'          => 'NOK' ,
                'name'          => 'Norwegian krone' ,
                'symbol'        => 'kr' ,
                'fraction_name' => 'Øre' ,
                'decimals'      => 2 ) ,
            'NPR' => array (
                'numeric_code'  => 524 ,
                'code'          => 'NPR' ,
                'name'          => 'Nepalese rupee' ,
                'symbol'        => '' ,
                'fraction_name' => 'Paisa' ,
                'decimals'      => 2 ) ,
            'NZD' => array (
                'numeric_code'  => 554 ,
                'code'          => 'NZD' ,
                'name'          => 'New Zealand dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'OMR' => array (
                'numeric_code'  => 512 ,
                'code'          => 'OMR' ,
                'name'          => 'Omani rial' ,
                'symbol'        => 'ر.ع.' ,
                'fraction_name' => 'Baisa' ,
                'decimals'      => 3 ) ,
            'PAB' => array (
                'numeric_code'  => 590 ,
                'code'          => 'PAB' ,
                'name'          => 'Panamanian balboa' ,
                'symbol'        => 'B/.' ,
                'fraction_name' => 'Centésimo' ,
                'decimals'      => 2 ) ,
            'PEN' => array (
                'numeric_code'  => 604 ,
                'code'          => 'PEN' ,
                'name'          => 'Peruvian nuevo sol' ,
                'symbol'        => 'S/.' ,
                'fraction_name' => 'Céntimo' ,
                'decimals'      => 2 ) ,
            'PGK' => array (
                'numeric_code'  => 598 ,
                'code'          => 'PGK' ,
                'name'          => 'Papua New Guinean kina' ,
                'symbol'        => 'K' ,
                'fraction_name' => 'Toea' ,
                'decimals'      => 2 ) ,
            'PHP' => array (
                'numeric_code'  => 608 ,
                'code'          => 'PHP' ,
                'name'          => 'Philippine peso' ,
                'symbol'        => '₱' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'PKR' => array (
                'numeric_code'  => 586 ,
                'code'          => 'PKR' ,
                'name'          => 'Pakistani rupee' ,
                'symbol'        => 'PKR' ,
                'fraction_name' => 'Paisa' ,
                'decimals'      => 2 ) ,
            'PLN' => array (
                'numeric_code'  => 985 ,
                'code'          => 'PLN' ,
                'name'          => 'Polish złoty' ,
                'symbol'        => 'zł' ,
                'fraction_name' => 'Grosz' ,
                'decimals'      => 2 ) ,
            'PYG' => array (
                'numeric_code'  => 600 ,
                'code'          => 'PYG' ,
                'name'          => 'Paraguayan guaraní' ,
                'symbol'        => '' ,
                'fraction_name' => 'Céntimo' ,
                'decimals'      => 2 ) ,
            'QAR' => array (
                'numeric_code'  => 634 ,
                'code'          => 'QAR' ,
                'name'          => 'Qatari riyal' ,
                'symbol'        => 'ر.ق' ,
                'fraction_name' => 'Dirham' ,
                'decimals'      => 2 ) ,
            'RON' => array (
                'numeric_code'  => 946 ,
                'code'          => 'RON' ,
                'name'          => 'Romanian leu' ,
                'symbol'        => 'L' ,
                'fraction_name' => 'Ban' ,
                'decimals'      => 2 ) ,
            'RSD' => array (
                'numeric_code'  => 941 ,
                'code'          => 'RSD' ,
                'name'          => 'Serbian dinar' ,
                'symbol'        => 'дин.' ,
                'fraction_name' => 'Para' ,
                'decimals'      => 2 ) ,
            'RUB' => array (
                'numeric_code'  => 643 ,
                'code'          => 'RUB' ,
                'name'          => 'Russian ruble' ,
                'symbol'        => 'руб.' ,
                'fraction_name' => 'Kopek' ,
                'decimals'      => 2 ) ,
            'RWF' => array (
                'numeric_code'  => 646 ,
                'code'          => 'RWF' ,
                'name'          => 'Rwandan franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'SAR' => array (
                'numeric_code'  => 682 ,
                'code'          => 'SAR' ,
                'name'          => 'Saudi riyal' ,
                'symbol'        => 'ر.س' ,
                'fraction_name' => 'Hallallah' ,
                'decimals'      => 2 ) ,
            'SBD' => array (
                'numeric_code'  => 90 ,
                'code'          => 'SBD' ,
                'name'          => 'Solomon Islands dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'SCR' => array (
                'numeric_code'  => 690 ,
                'code'          => 'SCR' ,
                'name'          => 'Seychellois rupee' ,
                'symbol'        => '' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'SDG' => array (
                'numeric_code'  => 938 ,
                'code'          => 'SDG' ,
                'name'          => 'Sudanese pound' ,
                'symbol'        => 'ج.س' ,
                'fraction_name' => 'Piastre' ,
                'decimals'      => 2 ) ,
            'SEK' => array (
                'numeric_code'  => 752 ,
                'code'          => 'SEK' ,
                'name'          => 'Swedish krona' ,
                'symbol'        => 'kr' ,
                'fraction_name' => 'Öre' ,
                'decimals'      => 2 ) ,
            'SGD' => array (
                'numeric_code'  => 702 ,
                'code'          => 'SGD' ,
                'name'          => 'Singapore dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'SHP' => array (
                'numeric_code'  => 654 ,
                'code'          => 'SHP' ,
                'name'          => 'Saint Helena pound' ,
                'symbol'        => '£' ,
                'fraction_name' => 'Penny' ,
                'decimals'      => 2 ) ,
            'SLL' => array (
                'numeric_code'  => 694 ,
                'code'          => 'SLL' ,
                'name'          => 'Sierra Leonean leone' ,
                'symbol'        => 'Le' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'SOS' => array (
                'numeric_code'  => 706 ,
                'code'          => 'SOS' ,
                'name'          => 'Somali shilling' ,
                'symbol'        => 'Sh' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'SRD' => array (
                'numeric_code'  => 968 ,
                'code'          => 'SRD' ,
                'name'          => 'Surinamese dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'STD' => array (
                'numeric_code'  => 678 ,
                'code'          => 'STD' ,
                'name'          => 'São Tomé and Príncipe dobra' ,
                'symbol'        => 'Db' ,
                'fraction_name' => 'Cêntimo' ,
                'decimals'      => 2 ) ,
            'SVC' => array (
                'numeric_code'  => 222 ,
                'code'          => 'SVC' ,
                'name'          => 'Salvadoran colón' ,
                'symbol'        => '' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'SYP' => array (
                'numeric_code'  => 760 ,
                'code'          => 'SYP' ,
                'name'          => 'Syrian pound' ,
                'symbol'        => '£' ,
                'fraction_name' => 'Piastre' ,
                'decimals'      => 2 ) ,
            'SZL' => array (
                'numeric_code'  => 748 ,
                'code'          => 'SZL' ,
                'name'          => 'Swazi lilangeni' ,
                'symbol'        => 'L' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'THB' => array (
                'numeric_code'  => 764 ,
                'code'          => 'THB' ,
                'name'          => 'Thai baht' ,
                'symbol'        => '฿' ,
                'fraction_name' => 'Satang' ,
                'decimals'      => 2 ) ,
            'TJS' => array (
                'numeric_code'  => 972 ,
                'code'          => 'TJS' ,
                'name'          => 'Tajikistani somoni' ,
                'symbol'        => 'ЅМ' ,
                'fraction_name' => 'Diram' ,
                'decimals'      => 2 ) ,
            'TMM' => array (
                'numeric_code'  => 0 ,
                'code'          => 'TMM' ,
                'name'          => 'Turkmenistani manat' ,
                'symbol'        => 'm' ,
                'fraction_name' => 'Tennesi' ,
                'decimals'      => 2 ) ,
            'TND' => array (
                'numeric_code'  => 788 ,
                'code'          => 'TND' ,
                'name'          => 'Tunisian dinar' ,
                'symbol'        => 'د.ت' ,
                'fraction_name' => 'Millime' ,
                'decimals'      => 3 ) ,
            'TOP' => array (
                'numeric_code'  => 776 ,
                'code'          => 'TOP' ,
                'name'          => 'Tongan paʻanga' ,
                'symbol'        => 'T$' ,
                'fraction_name' => 'Seniti[J]' ,
                'decimals'      => 2 ) ,
            'TRY' => array (
                'numeric_code'  => 949 ,
                'code'          => 'TRY' ,
                'name'          => 'Turkish lira' ,
                'symbol'        => 'TL' ,
                'fraction_name' => 'Kuruş' ,
                'decimals'      => 2 ) ,
            'TTD' => array (
                'numeric_code'  => 780 ,
                'code'          => 'TTD' ,
                'name'          => 'Trinidad and Tobago dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'TWD' => array (
                'numeric_code'  => 901 ,
                'code'          => 'TWD' ,
                'name'          => 'New Taiwan dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'TZS' => array (
                'numeric_code'  => 834 ,
                'code'          => 'TZS' ,
                'name'          => 'Tanzanian shilling' ,
                'symbol'        => 'Sh' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'UAH' => array (
                'numeric_code'  => 980 ,
                'code'          => 'UAH' ,
                'name'          => 'Ukrainian hryvnia' ,
                'symbol'        => '' ,
                'fraction_name' => 'Kopiyka' ,
                'decimals'      => 2 ) ,
            'UGX' => array (
                'numeric_code'  => 800 ,
                'code'          => 'UGX' ,
                'name'          => 'Ugandan shilling' ,
                'symbol'        => 'Sh' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'UYU' => array (
                'numeric_code'  => 858 ,
                'code'          => 'UYU' ,
                'name'          => 'Uruguayan peso' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Centésimo' ,
                'decimals'      => 2 ) ,
            'UZS' => array (
                'numeric_code'  => 860 ,
                'code'          => 'UZS' ,
                'name'          => 'Uzbekistani som' ,
                'symbol'        => 'UZS' ,
                'fraction_name' => 'Tiyin' ,
                'decimals'      => 2 ) ,
            'VEF' => array (
                'numeric_code'  => 937 ,
                'code'          => 'VEF' ,
                'name'          => 'Venezuelan bolívar' ,
                'symbol'        => 'Bs F' ,
                'fraction_name' => 'Céntimo' ,
                'decimals'      => 2 ) ,
            'VND' => array (
                'numeric_code'  => 704 ,
                'code'          => 'VND' ,
                'name'          => 'Vietnamese dong' ,
                'symbol'        => '₫' ,
                'fraction_name' => 'Hào[K]' ,
                'decimals'      => 10 ) ,
            'VUV' => array (
                'numeric_code'  => 548 ,
                'code'          => 'VUV' ,
                'name'          => 'Vanuatu vatu' ,
                'symbol'        => 'Vt' ,
                'fraction_name' => 'None' ,
                'decimals'      => NULL ) ,
            'WST' => array (
                'numeric_code'  => 882 ,
                'code'          => 'WST' ,
                'name'          => 'Samoan tala' ,
                'symbol'        => 'T' ,
                'fraction_name' => 'Sene' ,
                'decimals'      => 2 ) ,
            'XAF' => array (
                'numeric_code'  => 950 ,
                'code'          => 'XAF' ,
                'name'          => 'Central African CFA franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'XCD' => array (
                'numeric_code'  => 951 ,
                'code'          => 'XCD' ,
                'name'          => 'East Caribbean dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'XOF' => array (
                'numeric_code'  => 952 ,
                'code'          => 'XOF' ,
                'name'          => 'West African CFA franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'XPF' => array (
                'numeric_code'  => 953 ,
                'code'          => 'XPF' ,
                'name'          => 'CFP franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Centime' ,
                'decimals'      => 2 ) ,
            'YER' => array (
                'numeric_code'  => 886 ,
                'code'          => 'YER' ,
                'name'          => 'Yemeni rial' ,
                'symbol'        => '' ,
                'fraction_name' => 'Fils' ,
                'decimals'      => 2 ) ,
            'ZAR' => array (
                'numeric_code'  => 710 ,
                'code'          => 'ZAR' ,
                'name'          => 'South African rand' ,
                'symbol'        => 'R' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'ZMK' => array (
                'numeric_code'  => 894 ,
                'code'          => 'ZMK' ,
                'name'          => 'Zambian kwacha' ,
                'symbol'        => 'ZK' ,
                'fraction_name' => 'Ngwee' ,
                'decimals'      => 2 ) ,
            'ZWR' => array (
                'numeric_code'  => 0 ,
                'code'          => 'ZWR' ,
                'name'          => 'Zimbabwean dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
        );

        if (!empty($code) && array_key_exists($code, $currency_array)) {
            return $currency_array[$code];
        } else {
            return $currency_array;
        }
    }
}


/**
 * Helper function to sanitize a string value from user input
 *
 * @param string    $string          String to sanitize.
 * @param bool      $keep_linebreak  Not compulsory Whether to keep newlines or not. Default: false.
 * @return string   Sanitized string.
 */

if( !function_exists('sanitizeTextField') ) {

    function sanitizeTextField( $string, $keep_linebreak = false ) {

       
        if ( is_object( $string ) || is_array( $string ) ) {
            return '';
        }
    
        $string     = (string) $string;
        $filtered   = checkValidUTF8( $string );
    
        if ( strpos( $filtered, '<' ) !== false ) {
          
            // This will strip extra whitespace.
            $filtered = stripAllTags( $filtered, false );

            // Use HTML entities in a special case to make sure no later
            // newline stripping stage could lead to a functional tag.
            $filtered = str_replace( "<\n", "&lt;\n", $filtered );
        }
    
        if ( ! $keep_linebreak ) {
            $filtered = preg_replace( '/[\r\n\t ]+/', ' ', $filtered );
        }
        $filtered = trim( $filtered );
    
        $found = false;
        while ( preg_match( '/%[a-f0-9]{2}/i', $filtered, $match ) ) {
            $filtered = str_replace( $match[0], '', $filtered );
            $found    = true;
        }
    
        if ( $found ) {
            // Strip out the whitespace that may now exist after removing the octets.
            $filtered = trim( preg_replace( '/ +/', ' ', $filtered ) );
        }

        $filtered = clean($filtered, ['Attr.EnableID' => true ]);

        return $filtered;
    }

}

if( !function_exists('SanitizeArray') ) {

    function SanitizeArray( &$arr ){
        
        foreach( $arr as $key=> &$el ){
            
            if( is_array( $el ) ){
                SanitizeArray( $el );
            }else{
                $el = sanitizeTextField( $el, true );
            }
        }
        return  $arr; 
    }
}


/**
 * Checks for valid UTF8 or not in a string.
 *
 * @param string $string The text which is to be checked.
 * @return string Checked the text.
 */
if( !function_exists('checkValidUTF8') ) {

    function checkValidUTF8( $string_text ) {

        $string_text = (string) $string_text;

        if ( 0 === strlen( $string_text ) ) {
            return '';
        }

        // Store the site charset as a static to avoid multiple calls to get_option().
        static $isUtf8 = null;
        if ( ! isset( $isUtf8 ) ) {
            $isUtf8 = in_array( 'UTF-8', array( 'utf8', 'utf-8', 'UTF8', 'UTF-8' ), true );
        }

        if ( ! $isUtf8 ) {
            return $string_text;
        }

        // Check for support for utf8 in the installed PCRE library once and store the result in a static.
        static $utf8Pcre = null;
        if ( ! isset( $utf8Pcre ) ) {
            $utf8Pcre = @preg_match( '/^./u', 'a' );
        }
        
        // We can't demand utf8 in the PCRE installation, so just return the string in those cases.
        if ( ! $utf8Pcre ) {
            return $string_text;
        }

        //  -- preg_match fails when it encounters invalid UTF8 in $string.
        if ( 1 === @preg_match( '/^./us', $string_text ) ) {
            return $string_text;
        }

        return '';
    }
}

/**
 * Properly strip all HTML tags including script and style
 *
 * This differs from strip_tags() because it removes the contents of
 * the `<script>` and `<style>` tags. E.g. `strip_tags( '<script>something</script>' )`
 * will return 'something'. stripAllTags will return ''
 *
 * @param string $string        String containing HTML tags
 * @param bool   $remove_breaks Optional. Whether to remove left over line breaks and white space chars
 * @return string The processed string.
 */
if( !function_exists('stripAllTags') ) {

    function stripAllTags( $string, $remove_breaks_tag = false ) {

        $string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
        $string = strip_tags( $string, '<h1><h2><h3><h4><h5><6><div><b><strong><i><em><a><ul><ol><li><p><br><span><figure><sup><sub><table><tr><th><td><tbody><iframe><form><capture><label><fieldset><section>' );

        if ( $remove_breaks_tag ) {
            $string = preg_replace( '/[\r\n\t ]+/', ' ', $string );
        }
        return trim( $string );
    }
}

/**
 * get all email templates
 * @return array The process of array record
 */

if( !function_exists('getEmailTemplates') ) {
    
    function getEmailTemplates( ) {

        $templates = array(
            
            'user_created' => array(
                'title' => __('email_template.user_created_title'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.user_created_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.user_created_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.user_created_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.user_created_content'),
                            ),
                        ),  
                    ), 
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.user_created_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'desc'    	    => __('email_template.add_email_subject'),
                                'default' 	    => __('email_template.user_created_subject'),
                            ),
                            'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.user_created_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.user_created_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'registration' => array(
                'title' => __('email_template.registration_title'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_registration_email_variable'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_registration_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_registration_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_registration_content'),
                            ),
                        ),  
                    ), 
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_registration_email_variable'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'desc'    	    => __('email_template.add_email_subject'),
                                'default' 	    => __('email_template.seller_registration_subject'),
                            ),
                            'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_registration_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_registration_content'),
                            ),
                        ),  
                    ),
                    'admin' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.user_registerd_to_admin_variable'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'desc'    	    => __('email_template.add_email_subject'),
                                'default' 	    => __('email_template.user_registerd_to_admin_subject'),
                            ),
                            'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.user_registerd_to_admin_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.user_registerd_to_admin_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'reset_password' => array(
                'title' => __('email_template.reset_password'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_reset_password_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_reset_password_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_reset_password_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_reset_password_content'),
                            ),
                        ),  
                    ),
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_reset_password_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_reset_password_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_reset_password_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_reset_password_content'),
                            ),
                        ),  
                    ),
                    
                    
                ),
            ),
            'account_approval' => array(
                'title' => __('email_template.account_approval_title'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_account_approval_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_account_approval_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_account_approval_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_account_approval_content'),
                            ),
                        ),  
                    ), 
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_account_approval_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_account_approval_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_account_approval_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_account_approval_content'),
                            ),
                        ),  
                    ),
                    'admin' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.admin_account_approval_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.admin_account_approval_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.admin_account_approval_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.admin_account_approval_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'account_approved' => array(
                'title' => __('email_template.account_approved_title'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_account_approved_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_account_approved_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_account_approved_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_account_approved_content'),
                            ),
                        ),  
                    ), 
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_account_approved_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_account_approved_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_account_approved_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_account_approved_content'),
                            ),
                        ),
                    ),
                ),
            ),
            'accout_identity_verification' => array(
                'title' => __('email_template.accout_identity_verification'),
                'roles' => array(
                    'admin' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.identity_verification_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.identity_verification_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.identity_verification_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.identity_verification_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'accout_identity_rejection' => array(
                'title' => __('email_template.accout_identity_rejection'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_identity_rejection_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_identity_rejection_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_identity_rejection_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_identity_rejection_content'),
                            ),
                        ),  
                    ),
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_identity_rejection_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_identity_rejection_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_identity_rejection_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_identity_rejection_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'account_identity_approved' => array(
                'title' => __('email_template.account_identity_approved'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_identity_approved_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_identity_approved_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_identity_approved_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_identity_approved_content'),
                            ),
                        ),  
                    ),
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_identity_approved_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_identity_approved_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_identity_approved_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_identity_approved_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'seller_dispute_received' => array(
                'title' => __('email_template.seller_dispute_received'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_dispute_received_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_dispute_received_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_dispute_received_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_dispute_received_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'seller_approved_dispute_req' => array(
                'title' => __('email_template.seller_approved_dispute_req'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_approved_dispute_req_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_approved_dispute_req_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_approved_dispute_req_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_approved_dispute_req_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'seller_decline_dispute' => array(
                'title' => __('email_template.seller_decline_dispute'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_decline_dispute_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_decline_dispute_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_decline_dispute_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_decline_dispute_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'comment_on_dispute' => array(
                'title' => __('email_template.comment_on_dispute'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_dispute_comment_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_dispute_comment_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_dispute_comment_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_dispute_comment_content'),
                            ),
                        ),  
                    ),
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_dispute_comment_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_dispute_comment_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_dispute_comment_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_dispute_comment_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'admin_received_dispute' => array(
                'title' => __('email_template.admin_received_dispute'),
                'roles' => array(
                    'admin' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.admin_received_dispute_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.admin_received_dispute_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.admin_received_dispute_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.admin_received_dispute_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'admin_refund_hourly_dispute_to_winner' => array(
                'title' => __('email_template.admin_refund_hourly_dispute_to_winner'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.hourly_dispute_favour_in_seller_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.hourly_dispute_favour_in_seller_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.hourly_dispute_favour_in_seller_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.hourly_dispute_favour_in_seller_content'),
                            ),
                        ),  
                    ),
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.hourly_dispute_favour_in_buyer_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.hourly_dispute_favour_in_buyer_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.hourly_dispute_favour_in_buyer_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.hourly_dispute_favour_in_buyer_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'admin_refund_dispute_to_winner' => array(
                'title' => __('email_template.admin_refund_dispute_to_winner'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.dispute_favour_in_seller_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.dispute_favour_in_seller_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.dispute_favour_in_seller_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.dispute_favour_in_seller_content'),
                            ),
                        ),  
                    ),
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.dispute_favour_in_buyer_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.dispute_favour_in_buyer_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.dispute_favour_in_buyer_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.dispute_favour_in_buyer_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'admin_dispute_not_in_favour' => array(
                'title' => __('email_template.admin_dispute_not_in_favour'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.dispute_not_in_favour_seller_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.dispute_not_in_favour_seller_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.dispute_not_in_favour_seller_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.dispute_not_in_favour_seller_content'),
                            ),
                        ),  
                    ),
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.dispute_not_in_favour_buyer_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.dispute_not_in_favour_buyer_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.dispute_not_in_favour_buyer_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.dispute_not_in_favour_buyer_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'package_purchase' => array(
                'title' => __('email_template.package_purchase'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.package_purchase_by_seller_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.package_purchase_by_seller_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.package_purchase_by_seller_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.package_purchase_by_seller_content'),
                            ),
                        ),  
                    ),
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.package_purchase_by_buyer_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.package_purchase_by_buyer_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.package_purchase_by_buyer_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.package_purchase_by_buyer_content'),
                            ),
                        ),  
                    ),
                    'admin' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.package_purchase_to_admin_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.package_purchase_to_admin_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.package_purchase_to_admin_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.package_purchase_to_admin_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'project_posted' => array( 
                'title' => __('email_template.project_posted'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.project_posted_by_buyer_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.project_posted_by_buyer_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.project_posted_by_buyer_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.project_posted_by_buyer_content'),
                            ),
                        ),  
                    ),
                    'admin' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.project_posted_to_admin_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.project_posted_to_admin_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.project_posted_to_admin_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.project_posted_to_admin_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'project_conversation' => array(
                'title' => __('email_template.project_conversation'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_project_conv_var'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_project_conv_subj'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_project_conv_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_project_conv_cont'),
                            ),
                        ),  
                    ),
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_project_conv_var'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_project_conv_subj'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_project_conv_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_project_conv_cont'),
                            ),
                        ),  
                    ),
                ),
            ),
            'project_approved' => array(
                'title' => __('email_template.project_approved'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.project_approved_to_buyer_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.project_approved_to_buyer_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.project_approved_to_buyer_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.project_approved_to_buyer_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'proposal_approve_request' => array(
                'title' => __('email_template.proposal_approve_request'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.proposal_approve_request_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.proposal_approve_request_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.proposal_approve_request_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.proposal_approve_request_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'project_complete_req_declined' => array( 
                'title' => __('email_template.project_complete_req_declined'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.proj_complete_req_declined_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.proj_complete_req_declined_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.proj_complete_req_declined_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.proj_complete_req_declined_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'milestone_project_complete' => array(
                'title' => __('email_template.milestone_project_complete'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.milestone_project_comp_var'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.milestone_project_comp_subj'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.milestone_project_comp_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.milestone_project_comp_cont'),
                            ),
                        ),  
                    ),
                ),
            ),
            'project_complete_request_accepted' => array(
                'title' => __('email_template.project_complete_request_accepted'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.proj_comp_req_accept_var'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.proj_comp_req_accept_sub'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.proj_comp_req_accept_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.proj_comp_req_accept_cont'),
                            ),
                        ),  
                    ),
                ),
            ),
            'project_complete_request' => array(
                'title' => __('email_template.project_complete_request'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.project_complete_request_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.project_complete_request_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.project_complete_request_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.project_complete_request_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'proposal_request_declined' => array(
                'title' => __('email_template.proposal_request_declined'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.proposal_request_declined_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.proposal_request_declined_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.proposal_request_declined_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.proposal_request_declined_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'proposal_request_accepted' => array(
                'title' => __('email_template.proposal_request_accepted'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.proposal_request_accepted_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.proposal_request_accepted_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.proposal_request_accepted_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.proposal_request_accepted_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'milestone_approve_request' => array(
                'title' => __('email_template.milestone_approve_request'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.milestone_approve_request_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.milestone_approve_request_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.milestone_approve_request_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.milestone_approve_request_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'milestone_declined' => array(
                'title' => __('email_template.milestone_declined'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.milestone_declined_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.milestone_declined_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.milestone_declined_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.milestone_declined_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'milestone_accepted' => array(
                'title' => __('email_template.milestone_accepted'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.milestone_accepted_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.milestone_accepted_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.milestone_accepted_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.milestone_accepted_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'escrow_milestone' => array(
                'title' => __('email_template.escrow_milestone'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.escrow_milestone_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.escrow_milestone_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.escrow_milestone_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.escrow_milestone_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'project_invite_request' => array(
                'title' => __('email_template.project_invite_request'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.project_invite_request_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.project_invite_request_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.project_invite_request_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.project_invite_request_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'timecard_approval_request' => array( 
                'title' => __('email_template.timecard_approval_request'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.timecard_approval_request_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.timecard_approval_request_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.timecard_approval_request_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.timecard_approval_request_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'timecard_declined' => array(
                'title' => __('email_template.timecard_declined'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.timecard_declined_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.timecard_declined_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.timecard_declined_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.timecard_declined_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'timecard_accepted' => array(
                'title' => __('email_template.timecard_accepted'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.timecard_accepted_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.timecard_accepted_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.timecard_accepted_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.timecard_accepted_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'send_qeustion' => array(
                'title' => __('email_template.send_qeustion'),
                'roles' => array(
                    'admin' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.send_qeustion_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.send_qeustion_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.send_qeustion_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.send_qeustion_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'post_gig_order' => array( 
                'title' => __('email_template.post_gig_order'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.post_gig_order_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.post_gig_order_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.post_gig_order_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.post_gig_order_content'),
                            ),
                        ),  
                    ),
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_publish_order_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_publish_order_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_publish_order_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_publish_order_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'seller_order_complete' => array(
                'title' => __('email_template.seller_order_complete'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_order_complete_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_order_complete_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_order_complete_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_order_complete_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'order_declined' => array(
                'title' => __('email_template.order_declined'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.order_declined_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.order_declined_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.order_declined_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.order_declined_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'order_completed' => array(
                'title' => __('email_template.order_completed'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.order_completed_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.order_completed_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.order_completed_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.order_completed_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'order_activity' => array(
                'title' => __('email_template.order_activity'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_order_activity_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_order_activity_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_order_activity_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_order_activity_content'),
                            ),
                        ),  
                    ),
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_order_activity_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_order_activity_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_order_activity_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_order_activity_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'order_refund_request' => array(
                'title' => __('email_template.order_refund_request'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_received_order_dispute_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_received_order_dispute_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_received_order_dispute_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_received_order_dispute_content'),
                            ),
                        ),  
                    ),
                    'admin' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.admin_received_order_dispute_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.admin_received_order_dispute_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.admin_received_order_dispute_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.admin_received_order_dispute_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'order_refund_reply' => array(
                'title' => __('email_template.order_refund_reply'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.buyer_order_refund_reply_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.buyer_order_refund_reply_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.buyer_order_refund_reply_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.buyer_order_refund_reply_content'),
                            ),
                        ),  
                    ),
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_order_refund_reply_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_order_refund_reply_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_order_refund_reply_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_order_refund_reply_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'seller_appr_order_dispute_req' => array(
                'title' => __('email_template.seller_appr_order_dispute_req'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_appr_order_dispute_req_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_appr_order_dispute_req_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_appr_order_dispute_req_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_appr_order_dispute_req_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            'seller_decline_dispute_order' => array(
                'title' => __('email_template.seller_decline_dispute_order'),
                'roles' => array(
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.seller_decline_dispute_order_variables'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.seller_decline_dispute_order_subject'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.seller_decline_dispute_order_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.seller_decline_dispute_order_content'),
                            ),
                        ),  
                    ),
                ),
            ),
            
            'admin_refund_order_dispute_to_winner' => array(
                'title' => __('email_template.admin_refund_order_dispute_to_winner'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.disp_order_fvr_in_seller_var'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.disp_order_fvr_in_seller_sub'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.disp_order_fvr_in_seller_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.disp_order_fvr_in_seller_cont'),
                            ),
                        ),  
                    ),
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.disp_order_fvr_in_buyer_var'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.disp_order_fvr_in_buyer_sub'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.disp_order_fvr_in_buyer_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.disp_order_fvr_in_buyer_cont'),
                            ),
                        ),  
                    ),
                ),
            ),
            'admin_order_dispute_not_in_favour' => array(
                'title' => __('email_template.admin_order_dispute_not_in_favour'),
                'roles' => array(
                    'seller' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.disp_order_not_in_fvr_seller_var'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.disp_order_not_in_fvr_seller_sub'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.disp_order_not_in_fvr_seller_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.disp_order_not_in_fvr_seller_cont'),
                            ),
                        ),  
                    ),
                    'buyer' =>  array(
                        'fields'   => array(
                            'info'  => array(
                                'title'   	    => __('email_template.email_setting_variable'),
					            'icon'          => 'icon-info',
                                'desc'          => __('email_template.disp_order_not_in_fvr_buyer_var'),
                            ),
                            'subject'  => array(
                                'id'      	    => 'subject',
                                'title'   	    => __('email_template.subject'),
                                'default' 	    => __('email_template.disp_order_not_in_fvr_buyer_sub'),
                            ),
                           'greeting'  => array(
                                'id'      	    => 'greeting',
                                'title'   	    => __('email_template.greeting'),
                                'default' 	    => __('email_template.disp_order_not_in_fvr_buyer_greeting'),
                            ),
                            'content'  => array(
                                'id'      	    => 'content',
                                'title'   	    => __('email_template.email_content'),
                                'default' 	    => __('email_template.disp_order_not_in_fvr_buyer_cont'),
                            ),
                        ),  
                    ),
                ),
            ),
        );
        return $templates;
    }
}

/**
 * get footer block settings.


 * @return array The process of array record
 */
if( ! function_exists ('getFooterSettings') ){

    function getFooterSettings( $type) {

        $page_id = setting('_general.'.$type);
        $footer_settings = [];
        if( !empty($page_id) ){
            $page   = SitePage::select('settings')->find( $page_id );
            if( !empty($page->settings) ){
                $page_settings = json_decode($page->settings, true);
                foreach($page_settings as $key => $single){
                    if( $single['block_id'] == 'footer-block' ){
                        $footer_settings = [
                            'page_id'       => $page_id,
                            'block_key'     => ($single['block_id'].'__'.$key),
                            'settings'      => $single['settings'],
                            'style_css'     => $single['css'],
                        ]; 
                        break;
                    }
                }
            }
        }
        return $footer_settings;
    }
}

/**
 * get footer menu.


 * @return array The process of array record
 */ 
if( ! function_exists ('getHeaderMenu') ){

    function getHeaderMenu() {

        $header_menu = [];
        $menu = Cache::rememberForever('header-menu', function() {
            return Menu::select('id')->where('location', 'header')->latest()->first();
        });
        
        if( !empty($menu) ){
            $header_menu = Cache::rememberForever('header-menu-'.$menu->id, function() use($menu){
                return MenuItem::where('menu_id', $menu->id)->orderBy('sort','asc')->tree()->get()->toTree(); 
            });
        }
        return $header_menu;
    }
}


/**
 * get the images dimensions.
 * @return array The process of array record
 */
if( ! function_exists ('getImageDimensions') ){

    function getImageDimensions( $name = '' ) {

        $dimensions = [
            'user_profile' => [ 
                '38x38' => [
                    'width'     => 38,
                    'height'    => 38,
                ],
                '50x50' => [
                    'width'     => 50,
                    'height'    => 50,
                ],
                '60x60' => [
                    'width'     => 60,
                    'height'    => 60,
                ],
                '80x80' => [
                    'width'     => 80,
                    'height'    => 80,
                ],
                '100x100' => [
                    'width'     => 100,
                    'height'    => 100,
                ],
                '120x120' => [
                    'width'     => 120,
                    'height'    => 120,
                ],
                '130x130' => [
                    'width'     => 130,
                    'height'    => 130,
                ],
                '172x172' => [
                    'width'     => 172,
                    'height'    => 172,
                ],
            ],
            'profile_banner' => [
                '1730×400' => [
                    'width'     => 1730,
                    'height'    => 400,
                ]
            ],
            'gigs'         => [
                '82x82' => [
                    'width'     => 82,
                    'height'    => 82,
                ],
                '100x100' => [
                    'width'     => 100,
                    'height'    => 100,
                ],
                '150x150' => [
                    'width'     => 150,
                    'height'    => 150,
                ],
                '286x186' => [
                    'width'     => 286,
                    'height'    => 134,
                ],
                '814x400' => [
                    'width'     => 814,
                    'height'    => 400,
                ],
            ],
            'portfolios' => [
                '285x216' => [
                    'width'     => 285,
                    'height'    => 216,
                ],
            ], 
            'projects' => [

            ],
            'project_categories' => [
                '40x40' => [
                    'width'     => 40,
                    'height'    => 40,
                ],
                '306x200' => [
                    'width'     => 306,
                    'height'    => 200,
                ],
            ],
            'gig_categories' => [
                '40x40' => [
                    'width'     => 40,
                    'height'    => 40,
                ]
            ],
        ];

        return !empty($dimensions[$name]) ? $dimensions[$name] : $dimensions;
    }
}

/**
 * generate thumbnais of image with specific dimensions.
 *
 * @param string $dirName   Required. Directory name 
 * @param string $file      file to be uploaded
 * @param array $dimensions image dimensions
 * @return array The process of array record
 */
if( ! function_exists ('generateThumbnails') ){

    function generateThumbnails( $dirName, $file, $dimensions = [] ) {
        $file_ext       = $file->getClientOriginalExtension();
        $directoryUrl   = storage_path('app/public/'.$dirName);
        $file_key       = pathinfo($file->hashName(), PATHINFO_FILENAME);
        $data           = [];

        if(!empty($dimensions)){
            foreach($dimensions as $key => $dimension){
                $uploaded_image = Image::make($file)->fit($dimension['width'], $dimension['height'])->resizeCanvas($dimension['width'], $dimension['height'])->save($directoryUrl.'/'.$file_key.'-'.$key.'.'.$file_ext);
                if(!empty($uploaded_image)){
                    $data[$key]     = $dirName."/".$file_key.'-'.$key.'.'.$file_ext;
                }
            }
        }
        return $data;
    }
}

/**
 * Upload base64 image into custom storage folder.
 *
 * @param string $dirName   Required. Directory name 
 * @param string $imageUrl  Required. Base64 image string
 * @return array The process of array record
 */
if( ! function_exists ('uploadImage') ){

    function uploadImage( $dirName, $imageUrl, $dimensions = [] ) {

        $random_key     = Str::random(5).time();
        $file_ext       = ".png";
        $directoryUrl   = storage_path('app/public/'.$dirName);

        $i = 0;
        while (file_exists($directoryUrl.'/'.$random_key.$file_ext)) {
            $i++;
            $random_key = $random_key ."(" . $i . ")";
        }

        $data               = [];
        $fileName           = $random_key.$file_ext;
        $path               = $directoryUrl.'/'. $fileName;
        $image_parts        = explode(";base64,", $imageUrl);
        $image_type_aux     = explode("image/", $image_parts[0]);
        $image_type         = $image_type_aux[1];
        $data['file_ext']   = $image_type;

        if ( !is_dir( $directoryUrl ) ) {
            mkdir($directoryUrl);
        }

        $storeFile = file_put_contents( $path, file_get_contents( $imageUrl ) );

        if($storeFile){
            $data['url'] = $dirName.'/'.$fileName;
        }

        if(!empty($dimensions)){
            foreach($dimensions as $key => $dimension){
                $thubnail_file_name      = $random_key."-".$key;
                $i = 0;
                while (file_exists($directoryUrl.'/'.$thubnail_file_name.$file_ext)) {
                    $i++;
                    $thubnail_file_name = $thubnail_file_name ."(" . $i . ")";
                }
                $uploaded_image = Image::make($imageUrl)->resize($dimension['width'], $dimension['height'])->save($directoryUrl.'/'.$thubnail_file_name.$file_ext);
                
                if(!empty($uploaded_image)){
                    $data[$key]     = $dirName."/".$thubnail_file_name.$file_ext;
                }
            }
        }

        return $data;
    }
}

/**
 * Upload demo content image into custom storage folder.
 *
 * @param string $dirName   Required. Directory name 
 * @param string $imageUrl  Required. Base64 image string
 * @return array The process of array record
 */
if( ! function_exists ('uploadDemoImage') ){
    function uploadDemoImage($folder_name, $storage_path, $file, $uploadfor = ''){

        $existFile      = public_path().'/demo-content/'.$folder_name.'/'.$file;

        
        $directoryUrl   = storage_path('/app/public/'.$storage_path);

        if ( !is_dir( $directoryUrl ) ) {
            File::makeDirectory($directoryUrl, 0777, true);
        }

        $newFileName = $file;
        $newFilePath = storage_path('/app/public/'.$storage_path.'/');
        $fileInfo    = pathinfo($newFilePath.$newFileName);

        $i = 0;
        while (file_exists($newFilePath.$newFileName)) {
            $i++;
            $newFileName = $fileInfo["filename"] . "-" . $i . "." . $fileInfo["extension"];
        }

        File::copy($existFile, $newFilePath.$newFileName);
        $uploadedFilePath = $storage_path.'/'.$newFileName;
        $arr = [];
        if( $uploadfor == 'optionbuilder' ){
            $fileInfo = pathinfo($existFile);
            $ext        = !empty( $fileInfo['extension']  ) ? $fileInfo['extension'] : '';
            $type       = 'file';
            $thumbnail  = 'vendor/optionbuilder/images/file-preview.png';
            $orgName    = !empty( $fileInfo['basename']  ) ? $fileInfo['basename'] : '';
            $size       = filesize($existFile);
            $fileName   = rand(1, 9999) . date('m-d-Y_hia') . $orgName;
            $mimeType   = File::mimeType($existFile);
            
            if (substr($mimeType, 0, 5) == 'image') {
                $type       = 'image';
                $thumbnail  = 'storage/' . $uploadedFilePath;
            }

            $arr = [
                'type'      => $type,
                'name'      => $orgName,
                'path'      => $uploadedFilePath,
                'mime'      => $ext,
                'size'      => $size,
                'thumbnail' => asset($thumbnail),
            ];
        } else {
            $arr = [
                'file_name' => $newFileName,
                'file_path' => $uploadedFilePath,
                'mime_type' => 'image/jpg',
            ];
        }

        return $arr;
    }
}

if( ! function_exists ('isDemoSite') ){

    function isDemoSite( ){

        if(isset($_SERVER["SERVER_NAME"]) && in_array($_SERVER["SERVER_NAME"], array('taskup.wp-guppy.com'))) {
           return true;
        }else{
            return false;
        }
    }
}

?>