<?php

namespace App\Models;

use App\Models\Profile;
use App\Models\EmailTemplate;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserAccountSetting;
use App\Models\UserIdentification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\EmailNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, SoftDeletes, HasFactory, Billable, Notifiable, HasRoles;

    public static function boot() {
        parent::boot();

        static::deleting(function($user) {
            $user->profile()->delete();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
        * Get the user that owns the profile.
    */
    public function profile( ){  
        
        return $this->hasMany(Profile::class);
    }

    /**
        * Get the user that owns the user account settings.
    */
    public function userAccountSetting(){
        return $this->hasOne(UserAccountSetting::class);
    }

    /**
        * Get the user that owns the User Identification.
    */
    public function userIdentity(){
        return $this->hasOne(UserIdentification::class);
    }
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {

       $userRoles = $this->getRoleNames()->toArray();
    
        

        $email_template = EmailTemplate::select('content','role')
        ->where(['type' => 'reset_password' , 'status' => 'active', 'role' => $userRoles[0]])->latest()->first();
    
        if(!empty($email_template)){
            $template_data =  unserialize($email_template->content);
            $params = array();
            $params['template_type']    = 'reset_password';
            $params['email_params'] = array(
                'user_name'             => '',
                'account_email'         => $this->email,
                'token'                 => $token,
                'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
            );

            try {
                $this->notify(new EmailNotification($params));
            } catch (\Exception $e) {
                $e->getMessage();
            }
        }
    }
}
