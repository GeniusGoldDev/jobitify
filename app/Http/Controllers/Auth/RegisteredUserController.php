<?php

namespace App\Http\Controllers\Auth;
use Session;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\UserAccountSetting;
use App\Models\EmailTemplate;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\App;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $sitInfo        = getSiteInfo();
        $sitelogo       = $sitInfo['site_dark_logo'];
        $auth_bg        = setting('_site.auth_bg');
        if( !empty($auth_bg) ){
            $auth_bg  = $auth_bg[0]['path'];
        }
        return view('front-end.auth.register', compact('sitelogo', 'auth_bg'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
      
        $request->validate([
            'first_name'                => ['required', 'string', 'max:255'],
            'last_name'                 => ['required', 'string', 'max:255'],
            'user_type'                 => ['required'],
            'user_terms_agree'          => ['required'],
            'email'                     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'                  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        
        // get requested role return role_id
        $role_id =  getRoleByName($request->user_type);
        
     
        if(!empty($role_id)){
            
            // create a new user
            $user_email     = sanitizeTextField( filter_var($request->email, FILTER_VALIDATE_EMAIL) );
            $user_password  = $request->password;
            
            $user = User::create([
                'email'     => $user_email,
                'password'  => Hash::make($user_password),
            ]);

            // create new profile with role
            $profile = new Profile();
            $profile->user()->associate($user->id);
            $first_name             = sanitizeTextField($request->first_name);
            $last_name              = sanitizeTextField($request->last_name);
            $profile->first_name    = $first_name;
            $profile->last_name     = $last_name;
            $profile->slug          = $first_name.' '.$last_name;
            $profile->role_id       = $role_id;
            $user->assignRole( $role_id );
            $profile->save();

            // create user account settings
            $UserAccountSetting = new UserAccountSetting();
            $UserAccountSetting->user()->associate($user->id);
            $UserAccountSetting->save();
            
        }else{
            session()->flash('message', __('auth.role_not_exist'));
            session()->flash('type',    'error');
            return redirect()->back(); 
        }

        session()->put(['user_id' => $user->id]);
        session()->put(['email' => $user_email]);

        // send email to user
        $email_template = EmailTemplate::select('content','role')
        ->where(['type' => 'registration' , 'status' => 'active'])->whereIn('role', [$request->user_type, 'admin'])
        ->latest()->get();

        if(!$email_template->isEmpty()){
            foreach($email_template as $template){
                   
                    $template_data =  unserialize($template->content);
                    $params = array();
                    $params['template_type']    = 'registration';
                    $params['email_params'] = array(
                        'user_name'             => $first_name.' '.$last_name,
                        'user_email'            => $user_email,
                        'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                        'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                        'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
                    );
                    
                    if($template->role == 'admin'){
                        $adminUser = User::whereHas(
                            'roles', function($q){
                                $q->where('name', 'admin');
                            }
                        )->latest()->first();
                        try {
                            Notification::send($adminUser, new EmailNotification($params));
                        } catch (\Exception $e) {
                            $error_msg = $e->getMessage();
                        }
                    } else {
                        try {
                            Notification::send($user, new EmailNotification($params));
                        } catch (\Exception $e) {
                            $error_msg = $e->getMessage();
                        }
                    }
            } 
        }

        Auth::login($user);

        $url = getLoginRedirect($user->id);

        return redirect()->intended($url);
    }
}
