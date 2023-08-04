<?php

namespace App\Http\Livewire\Gig;


use File;
use ZipArchive;
use Livewire\Component;
use App\Models\Gig\GigOrderActivity;

class GigActivityConversation extends Component
{
   
    public $profile_id;
    public $gig_id;
    public $buyer_id;
    public $seller_id;
    public $order_id;
    public $activity_description = '';
    public $activity_files = [];
    public $existingFiles = [];
    public $allowFileSize = '';
    public $allowFileExt = '';
    protected $listeners = ['updateConversation' => '$refresh'];

    public function render(){

        $gig_activities         = GigOrderActivity::select('*');
        $gig_activities         = $gig_activities->with('sender:id,first_name,last_name,image');
        $gig_activities         = $gig_activities->where(['gig_id'=> $this->gig_id,'order_id' => $this->order_id])->where( function($query){
            $query->where(['sender_id'  => $this->seller_id,    'receiver_id' => $this->buyer_id])->orWhere(function($query){
                $query->where(['sender_id'  => $this->buyer_id, 'receiver_id' => $this->seller_id]);
            });
        });
        $gig_activities   = $gig_activities->orderBy('id','asc')->get();
        $listIds = ['pro-activitiesy-'.time(),'pro-invoices-'.time()];
        $this->dispatchBrowserEvent('initializeScrollbar', $listIds);
        return view('livewire.gig.gig-activity-conversation', compact('gig_activities',  'listIds'));
    }

    public function mount($gig_id, $order_id, $gig_author_id, $order_author_id  ){

        $user = getUserRole();
        $this->profile_id       = $user['profileId'];
        $this->buyer_id     = $order_author_id;
        $this->seller_id    = $gig_author_id;
        $this->order_id     = $order_id;
        $this->gig_id       = $gig_id;
    }

    public function downloadAttachments( $id ){
        
        $gig_activities = GigOrderActivity::select('attachments');
        $gig_activities = $gig_activities->where('id', $id)->where( function($query){

            $query->Where(['sender_id'  => $this->seller_id,    'receiver_id' => $this->buyer_id])->orWhere(function($query){
                $query->where(['sender_id'  => $this->buyer_id, 'receiver_id' => $this->seller_id]);
            });
            
        });

        $gig_activities = $gig_activities->first();
       
        if(!empty($gig_activities) && !empty($gig_activities->attachments)){
            
            $attachments = unserialize($gig_activities->attachments);
            $path = storage_path('app/download/gig-activities/'.$id);
            if (!file_exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $gig_files = $attachments;
            $zip      = new ZipArchive;
            $fileName = '/attachments.zip';
            $path = $path .$fileName;
            
            $zip->open($path, ZipArchive::CREATE);
            foreach ($gig_files as $single) {
                $name = basename($single['file_name']);
                if(file_get_contents(public_path('storage/'.$single['file_path']))){
                    $zip->addFromString( $name, file_get_contents(public_path('storage/'.$single['file_path'])));
                }
            }
            $zip->close();
            return response()->download(storage_path('app/download/gig-activities/' . $id . $fileName));
        }
    }

}
