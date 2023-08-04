<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $sitInfo        = getSiteInfo();
        $sitelogo       = $sitInfo['site_dark_logo'];
        $auth_bg        = setting('_site.auth_bg');
        if( !empty($auth_bg) ){
            $auth_bg  = $auth_bg[0]['path'];
        }
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::USER_LOGIN)
                    : view('front-end.auth.verify-email',compact('sitelogo' ,'auth_bg'));
    }
}
