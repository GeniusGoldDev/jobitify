<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::USER_LOGIN);
        }
        // send email to user
        $user           = Auth::user();
        $getUserInfo    = getUserInfo();
        $userRole       = $getUserInfo['user_role'];
        $userName       = $getUserInfo['user_name'];


        $template_data = EmailTemplate::select('content','role')
        ->where(['type' => 'registration' , 'status' => 'active'])->where('role', $userRole)
        ->latest()->first();

        if(!empty($template_data)){
            $template_data              = unserialize($template_data->content);
            $params                     = array();
            $params['template_type']    = 'registration';
            $params['email_params']     = array(
                'user_name'             => $userName,
                'user_email'            => $user->email,
                'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
            );

            try {
                Notification::send($user, new EmailNotification($params));
            } catch (\Exception $e) {
                $error_msg = $e->getMessage();
            }
        }

        return back()->with('status', 'verification-link-sent');
    }
}
