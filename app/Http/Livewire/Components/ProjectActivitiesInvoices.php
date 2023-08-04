<?php

namespace App\Http\Livewire\Components;

use File;
use ZipArchive;
use App\Models\Profile;
use App\Models\Project;
use Livewire\Component;
use App\Models\Transaction;
use App\Models\EmailTemplate;
use Livewire\WithFileUploads;
use App\Models\ProjectActivity;
use App\Models\Proposal\Proposal;
use App\Models\TransactionDetail;
use App\Notifications\EmailNotification;

class ProjectActivitiesInvoices extends Component
{
    use WithFileUploads;

    public $userRole;
    public $profile_id;
    public $buyer_id;
    public $seller_id;
    public $project_id;
    public $project_title;
    public $proposal_id;
    public $date_format;
    public $currency_symbol;
    public $activity_description = '';
    public $activity_files = [];
    public $existingFiles = [];
    public $allowFileSize = '';
    public $allowFileExt = '';

    public $listeners = [ 'updateSellerProposal' => 'updateSellerProposal'];
   
    public function mount( $project_id, $project_title, $project_author_id, $proposal_id, $profile_id, $userRole ){

        $this->project_id       = $project_id;
        $this->project_title    = $project_title;
        $this->buyer_id         = $project_author_id;
        $this->proposal_id      = $proposal_id;
        $this->profile_id       = $profile_id;
        $this->userRole         = $userRole;
        
        $currency               = setting('_general.currency');
        $date_format            = setting('_general.date_format');
        $file_ext               = setting('_general.file_ext');
        $file_size              = setting('_general.file_size');
        $currency_detail        = !empty( $currency)  ? currencyList($currency) : array();
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        $this->allowFileSize    = !empty( $file_size ) ? $file_size : '3';
        $this->allowFileExt     = !empty( $file_ext ) ?  $file_ext  : [];
        if( !empty($currency_detail) ){
            $this->currency_symbol        = $currency_detail['symbol']; 
        }
    }

    public function render(){
        
        $proposal_detail    = Proposal::select('project_id', 'author_id','status')
        ->where('project_id', $this->project_id)
        ->whereIn('status', array('disputed', 'hired','queued', 'rejected', 'completed', 'refunded'))->find($this->proposal_id);
        $project_activities = $invoices = array();
        if( !empty($proposal_detail) ){

            $this->project_id           = $proposal_detail->project_id;
            $this->seller_id            = $proposal_detail->author_id;
            $project_activities         = ProjectActivity::select('*');
            $project_activities         = $project_activities->with('sender:id,first_name,last_name,image');
            $project_activities         = $project_activities->where('project_id', $this->project_id)->where( function($query){
                $query->where(['sender_id'  => $this->seller_id,    'receiver_id' => $this->buyer_id])->orWhere(function($query){
                    $query->where(['sender_id'  => $this->buyer_id, 'receiver_id' => $this->seller_id]);
                });
            });

            $project_activities   = $project_activities->orderBy('id','asc')->get();
            $invoices = Transaction::select('id', 'created_at', 'status')->where('creator_id', $this->buyer_id);
            $invoices = $invoices->with('TransactionDetail:id,transaction_id,amount,used_wallet_amt,transaction_type,type_ref_id')->whereHas('TransactionDetail');            
            $invoices = $invoices->with('sellerPayout:id')->whereHas(
                'sellerPayout', function( $query ){
                    $query->where('seller_id', $this->seller_id);
                    $query->where('project_id', $this->project_id);
                }
            );
            $invoices = $invoices->get();
       
        } else {
            abort('404');
        }
        
        $listIds = ['pro-activitiesy-'.time(),'pro-invoices-'.time()];
        $this->dispatchBrowserEvent('initializeScrollbar', $listIds);
        $this->dispatchBrowserEvent('apply-loader', 'hide');
        return view('livewire.components.project-activities-invoices', compact('proposal_detail', 'project_activities', 'invoices', 'listIds'));
    }

    public function updatedActivityFiles(){

        $this->validate(
            [
                'activity_files.*' => 'mimes:'.$this->allowFileExt.'|max:'.$this->allowFileSize*1024,
            ],[
                'max'   => __('general.max_file_size_err',  ['file_size'    => $this->allowFileSize.'MB']),
                'mimes' => __('general.invalid_file_type',  ['file_types'   => $this->allowFileExt]),
            ]
        );
        
        foreach($this->activity_files as $single){
            $filename = pathinfo($single->hashName(), PATHINFO_FILENAME);
            $this->existingFiles[$filename] = $single;
        }
    }

    public function removeFile( $key ){

        if(!empty($this->existingFiles[$key])){
            unset($this->existingFiles[$key]);
        }
    }

    public function updateActivity(){
        
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
            'activity_description'  => 'required',
            
        ]);

        $attachments = array();
        if( !empty($this->existingFiles) ){
            foreach($this->existingFiles as $key => $single){

                $file = $single;
                $file_path      = $file->store('public/project-activity/'.$this->project_id.'/'.$this->proposal_id);
                $file_path      = str_replace('public/', '', $file_path);
                $file_name      = $file->getClientOriginalName();
                $mime_type      = $file->getMimeType();

                $attachments[]  = array(
                    'file_name'  => $file_name,
                    'file_path'  => $file_path,
                    'mime_type'  => $mime_type,
                );
                
            }
        }

        ProjectActivity::create([
            'sender_id'         =>  $this->profile_id,
            'receiver_id'       =>  $this->profile_id == $this->buyer_id ? $this->seller_id : $this->buyer_id,
            'project_id'        =>  $this->project_id,
            'attachments'       => !empty($attachments) ? serialize($attachments) : null,
            'description'       => sanitizeTextField($this->activity_description, true)
        ]);

        $this->existingFiles = [];
        $this->activity_description = '';
        
        // send email to receiver
        $email_template = EmailTemplate::select('content')->where(['type' => 'project_conversation' , 'status' => 'active', 'role' => $this->userRole == 'buyer' ? 'seller' : 'buyer'])->latest()->first();
        $receiver_id    = $this->profile_id == $this->buyer_id ? $this->seller_id : $this->buyer_id;
        $user_profile   = Profile::where('id',$receiver_id)->select('id','user_id','first_name','last_name')->with('user')->latest()->first();
        
        $userIfno       = getUserInfo();
        $sender_name    = !empty($userIfno['user_name']) ? $userIfno['user_name'] : '';
        if(!empty($email_template)){
            $template_data              =  unserialize($email_template->content);
            $params                     = array();
            $params['template_type']    = 'project_conversation';
            $params['email_params']     = array(
                'user_name'             => $user_profile->full_name,
                'sender_name'           => $sender_name,
                'project_title'         => $this->project_title,
                'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
            );
            try {
                $user_profile->user->notify(new EmailNotification($params));
            } catch (\Exception $e) {
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => $e->getMessage(),
                    'autoClose' => 10000,
                ]);
            }
        }
    }

    public function downloadAttachments( $id ){
        
        $project_activities = ProjectActivity::select('attachments');
        $project_activities = $project_activities->where('id', $id)->where( function($query){

            $query->Where(['sender_id'  => $this->seller_id,    'receiver_id' => $this->buyer_id])->orWhere(function($query){
                $query->where(['sender_id'  => $this->buyer_id, 'receiver_id' => $this->seller_id]);
            });
            
        });

        $project_activities = $project_activities->first();
       
        if(!empty($project_activities) && !empty($project_activities->attachments)){
            
            $attachments = unserialize($project_activities->attachments);
            $path = storage_path('app/download/project-activities/'.$id);
            if (!file_exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $project_files = $attachments;
            $zip      = new ZipArchive;
            $fileName = '/attachments.zip';
            $path = $path .$fileName;
            
            $zip->open($path, ZipArchive::CREATE);
            foreach ($project_files as $single) {
                $name = basename($single['file_name']);
                if(file_get_contents(public_path('storage/'.$single['file_path']))){
                    $zip->addFromString( $name, file_get_contents(public_path('storage/'.$single['file_path'])));
                }
            }
            $zip->close();
            return response()->download(storage_path('app/download/project-activities/' . $id . $fileName));
            
        }
    }

    public function updateSellerProposal($id){
        $this->dispatchBrowserEvent('apply-loader', 'show');
        $this->proposal_id = $id;
    }

}
