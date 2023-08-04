<?php

namespace App\Http\Livewire\Admin\Users;

use File;
use ZipArchive;
use App\Models\User;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmailTemplate;
use App\Models\UserAccountSetting;

use App\Models\UserIdentification;
use Illuminate\Support\Facades\Hash;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;

class Users extends Component
{
    use WithPagination;

    public $user_identity_info              = [];
    public $filter_user                     = '';
    public $search_user                     = '';
    public $date_format                     = '';
    public $currency_symbol                 = '';
    public $sortby                          = 'desc';
    public $per_page                        = '';
    public $per_page_opt                    = [];
    public $user_id                         = null; 
    public $identity_reject_reason          = ''; 
    public $reject_user_identity            = false;

    public $first_name, $last_name, $email, $user_role, $password, $confirm_password;
     
    protected $paginationTheme  = 'bootstrap';
    protected $listeners = ['emailVerifyConfirm' => 'verifyUserEmail', 'deleteUser'];
   

    public function mount(){
        
        $this->per_page_opt     = perPageOpt();
        $per_page_record        = setting('_general.per_page_record');
        $date_format            = setting('_general.date_format');
        $currency               = setting('_general.currency');
        $this->per_page         = !empty( $per_page_record ) ? $per_page_record : 10;
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        $currency_detail        = !empty( $currency)  ? currencyList($currency) : array();
        
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }
    }

    public function render(){
        
        $users = User::select( 
            'id',
            'email',
            'created_at',
            'status',
            'email_verified_at',
            
        );
        $search_user = $this->search_user;
        $filter_user = $this->filter_user;
        
        $users = $users->with([
            'userIdentity:id,user_id',
            'userAccountSetting:id,user_id,hourly_rate,verification',
            'profile' => function( $query ){
                $query->select('id','user_id','role_id','first_name','last_name','slug');
                $query->with('role:id,name');
            }
        ])->whereHas('profile', function( $query ) use($search_user){
            $query->select('id','user_id','role_id','first_name','last_name','slug');
            if( !empty( $search_user ) ){
                $query->where(function($sub_query) use($search_user){
                    $sub_query->whereFullText('first_name', $search_user);   
                    $sub_query->orWhereFullText('last_name', $search_user); 
                    $sub_query->orWhereFullText('tagline', $search_user); 
                    $sub_query->orWhereFullText('description', $search_user);
                }); 
            }
        })->whereHas(
            'userAccountSetting', function( $query ) use($filter_user){
                $query->select('id','user_id','hourly_rate','verification');
            if( !empty($this->filter_user) ){
                if( $this->filter_user == 'verified' ){
                    $query->where( 'verification', 'approved');
                }elseif( $this->filter_user == 'non-verified'){
                    $query->where( 'verification', '!=', 'approved');
                }
            }
        });
        $users = $users->orderBy('id', $this->sortby);
        $users = $users->paginate($this->per_page);
        
        return view('livewire.admin.users.users', compact( 'users'))->extends('layouts.admin.app');
    }

    public function updateUserIdentity(){
        $this->reject_user_identity = false; 
    }
    public function updatedSearchUser(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedFilterUser(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedPerPage(){
        $this->resetPage(); // default function of pagination
    }

    public function deleteUser( $params ){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $profile_roles = Profile::select('role_id')->where('user_id',  $params['id'])->get()->pluck('role_id')->toArray();
        $role_id = getRoleByName('admin');
        if( in_array($role_id, $profile_roles) ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.error_title'),
                'message'   => __('general.not_allowed')
            ]);
            return;
        }else{
            User::destroy($params['id']);
        }
    }

    public function identityInfo( $id ){

        $user_identity   = UserIdentification::where('user_id', $id)->first();
        $user_account   = UserAccountSetting::select('verification')->where('user_id', $id)->first();
        $this->user_identity_info = [];
        if( !empty($user_identity) ){

            $this->user_identity_info = [
                'id'              => $id,
                'name'            => $user_identity->name,
                'contact_no'      => $user_identity->contact_no,
                'identity_no'     => $user_identity->identity_no,
                'address'         => $user_identity->address,
                'attachments'     => !empty($user_identity->identity_attachments) ? $user_identity->identity_attachments : false,
                'verification'    => $user_account->verification,  
            ];
            $this->dispatchBrowserEvent('indentity-info-modal', array('modal' => 'show'));
        }
    }

    public function saveUser(){
        
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
            'first_name'        =>  'required',
            'last_name'         =>  'required',
            'email'             =>  'required|email|unique:users',
            'user_role'         =>  'required|in:seller,buyer',
            'password'          =>  'required|min:8',
            'confirm_password'  =>  'required|same:password',
        ]);

        $role_id =  getRoleByName($this->user_role);
        if( !empty($role_id) ){

            $user = User::create([
                'email'             => sanitizeTextField($this->email),
                'password'          => Hash::make($this->password),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'status'            => 'activated',
            ]);
        

            // create new profile with role
            $profile = new Profile();
            $profile->user()->associate($user->id);
            $first_name             = sanitizeTextField($this->first_name);
            $last_name              = sanitizeTextField($this->last_name);
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

            $email_template = EmailTemplate::select('content','role')
            ->where(['type' => 'user_created' , 'status' => 'active'])->where('role', $this->user_role)
            ->latest()->first();
            $getUserInfo = getUserInfo();
            
            if( !empty($email_template) ){
                $siteInfo = getSiteInfo();
                $template_data =  unserialize($email_template->content);
                $params = array();
                $params['template_type']    = 'user_created';
                $params['email_params'] = array(
                    'user_name'             => $first_name.' '.$last_name,
                    'user_email'            => sanitizeTextField($this->email),
                    'password'              => $this->password,
                    'site_name'              => $siteInfo['site_name'],
                    'admin_name'            => $getUserInfo['user_name'],
                    'login_url'             => route('login'),
                    'email_subject'         => !empty($template_data['subject']) ?   $template_data['subject'] : '',     
                    'email_greeting'        => !empty($template_data['greeting']) ?  $template_data['greeting'] : '',     
                    'email_content'         => !empty($template_data['content']) ?   $template_data['content'] : '',     
                );

                try {
                    Notification::send($user, new EmailNotification($params));
                } catch (\Exception $e) {
                    $this->dispatchBrowserEvent('showAlertMessage', [
                        'title'     => __('general.error_title'),
                        'type'      => 'error',
                        'message'   => $e->getMessage(),
                    ]);
                    return;
                }
            }
            $this->dispatchBrowserEvent('add-new-user-modal', array('modal' => 'hide'));
            $eventData              = array();
            $eventData['title']     = __('general.success_title');
            $eventData['type']      = 'success';
            $eventData['message']   = __('general.user_created');
            $this->dispatchBrowserEvent('showAlertMessage', $eventData);

        }
    }

    public function downloadAttachments(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( !empty($this->user_identity_info['attachments']) ){

            $attachments    = unserialize($this->user_identity_info['attachments']);
            $path           = storage_path('app/download/user_identity_doc/'.$this->user_identity_info['id']);
            if (!file_exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $zip      = new ZipArchive;
            $fileName = '/attachments.zip';
            $path = $path .$fileName;

            $zip->open($path, ZipArchive::CREATE);
            foreach ($attachments as $single) {
                $name = basename($single);
                if(file_get_contents(public_path('storage/'.$single))){
                    $zip->addFromString( $name, file_get_contents(public_path('storage/'.$single)));
                }
            }
            $zip->close();
            return response()->download(storage_path('app/download/user_identity_doc/' . $this->user_identity_info['id'] . $fileName));
        }
    }

    public function verifyUserEmail( $params){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $user_account   = User::select('id')->where('id', $params['id'])->first();
        if( !empty($user_account) ){
            
            if( $params['status'] == 'reject' ){
              $user_account->update(['email_verified_at' => Null]);  
            }elseif( $params['status'] == 'approve' ){
                
                $user_account->update(['email_verified_at' => date("Y-m-d H:i:s")]);
            }
        }
    }

    public function verifyUserIdentity( $id, $status ){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $user_identity  = UserIdentification::where('user_id', $id)->first();
        $user_account   = UserAccountSetting::where('user_id', $id)->first();
        $user           = User::find($id);

        $active_role    = $user->roles->map->only('name','id')->first();
        $role_id        = !empty($active_role['id']) ? $active_role['id'] : '';
        $role_name      = !empty($active_role['name']) ? $active_role['name'] : '';
        $reject_reason  = '';

        if( !empty($user_identity) && !empty($user_account) ){
            if( $status == 'reject' ){

                if( !$this->reject_user_identity ){
                  $this->reject_user_identity = true;
                  return;
                }else{
                    $validated_data   = $this->validate([
                        'identity_reject_reason'    => 'required',
                    ]);
                }
                $reject_reason = sanitizeTextField($this->identity_reject_reason, true);
                $user_account->update(['verification' => 'pending','verification_reject_reason' => $reject_reason]);
            }elseif( $status == 'approve' ){
               
                $user_account->update(['verification' => 'approved', 'verification_reject_reason' => Null]);
            }

            $type           = '';
            // send email to admin
            $user = User::whereId($id)->with('profile', function($query) use ($role_id){
                $query->select('id','user_id','role_id', 'first_name','last_name');
                $query->where('role_id', $role_id);
            })->first();
        
            if($status == 'reject'){
                $type = 'accout_identity_rejection'; 
            } elseif($status == 'approve') {
                $type = 'account_identity_approved'; 
            }

            $email_template = EmailTemplate::select('content')
            ->where(['type' => $type , 'status' => 'active', 'role' => $role_name])
            ->latest()->first();

            if(!empty($email_template)){

                $template_data              =  unserialize($email_template->content);
                $params                     = array();
                $params['template_type']    = $type;
                $user_name                  = !empty($user->profile[0]->full_name) ? $user->profile[0]->full_name : '';
            
            if( $type == 'accout_identity_rejection' ){
                    $template_data['content'] = str_replace("{{admin_message}}",  $reject_reason, $template_data['content']);
                }

                $params['email_params'] = array(
                    'user_name'             => !empty($user_name)                   ? $user_name : '',
                    'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                    'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                    'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',
                    'admin_reason'          => !empty($reject_reason) ? $reject_reason : '',
                );

                try {
                    Notification::send($user, new EmailNotification($params));
                } catch (\Exception $e) {
                    $this->dispatchBrowserEvent('showAlertMessage', [
                        'title'     => __('general.error_title'),
                        'type'      => 'error',
                        'message'   => $e->getMessage(),
                    ]);
                    return;
                }
            }
            // end send email
        }

        $this->dispatchBrowserEvent('indentity-info-modal', array('modal' => 'hide'));
        $this->reject_user_identity = false;
    }
}
