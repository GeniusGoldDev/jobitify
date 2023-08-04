<?php

namespace App\Http\Livewire\Project;

use File;
use ZipArchive;
use App\Models\Project;
use Livewire\Component;
use App\Models\FavouriteItem;
use App\Models\Proposal\Proposal;

class ProjectDetail extends Component
{
    
    public $profile_id              = 0;
    public $currency_symbol         = '';
    public $address_format          = '';
    public $project                 = '';
    public $posted_projects         = 0;
    public $adsense_code            = '';
    public $date_format            = '';
    public $hired_projects          = 0;
    public $save_project            = '';
    public $related_projects        = [];
    public $favourite_projects      = [];
    public $author                  = false;
    public $edit_proposal           = false;
    public $proposal_submitted      = false;
    public $userRole                = '';

    public function mount( $slug ){

        $user = getUserRole();
        $this->userRole       = !empty($user['roleName']) ? $user['roleName'] : 0; 
        $this->profile_id       = !empty($user['profileId']) ? $user['profileId'] : 0; 
        $address_format         = setting('_general.address_format');
        $currency               = setting('_general.currency');
        $date_format            = setting('_general.date_format');
        $project_adsense        = setting('_adsense.project_adsense_code');
        $this->adsense_code     = !empty($project_adsense)  ? $project_adsense : '';
        $currency_detail        = !empty($currency)  ? currencyList($currency) : array();
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        $this->address_format   = !empty($address_format)  ? $address_format : 'state_country';
        
        if( !empty($currency_detail) ){
            $this->currency_symbol    = $currency_detail['symbol']; 
        }

        $this->project = Project::with([
            'projectDuration:id,name',
            'projectLocation:id,name',
            'expertiseLevel:id,name',
            'category:id,name',
            'skills:id,name',
            'languages:id,name',
            'projectAuthor:id,user_id,first_name,last_name,image,description,created_at',
            'projectAuthor.user:id',
            'projectAuthor.user.userAccountSetting:id,user_id,verification'
        ])->where('slug', $slug)->firstOrFail();

        if( $this->project->author_id == $this->profile_id ){
            $this->author = true;
        }else{
            $proposal_submitted = Proposal::select('id','status', 'resubmit')->where(['project_id'=> $this->project->id, 'author_id' => $this->profile_id])->first();
            if( !empty($proposal_submitted) ){
                $this->proposal_submitted = true;
                if( $proposal_submitted->status == 'draft' || $proposal_submitted->resubmit == 1 ){
                    $this->edit_proposal = true;
                }
            } 
        }

        $this->posted_projects  = Project::whereIn('status', array('publish','hired','completed'))->where('author_id', $this->project->author_id)->count('id');
        $this->hired_projects   = Project::where('status', 'hired')->where('author_id', $this->project->author_id)->count('id');
        
        // get related project details 
        $project_skills = array();
        if( !$this->project->skills->isEmpty() ){
            foreach($this->project->skills as $single){
                $project_skills[] = $single->id;
            }
        }
        
        $related_projects = Project::select(
            'id',
            'author_id',
            'project_title',
            'slug',
            'updated_at',
            'project_type',
            'project_min_price',
            'project_location',
            'project_country',
            'project_expert_level',
            'project_duration',
            'project_max_price',
            'address',
            'project_hiring_seller',
            'is_featured')->where('status', 'publish')->where('id', '!=', $this->project->id)->with([
                'expertiseLevel:id,name',
                'projectLocation:id,name', 
                'projectAuthor:id,user_id,first_name,last_name',
                'projectAuthor.user:id',
                'projectAuthor.user.userAccountSetting:id,user_id,verification'
            ]);
            
        $related_projects = $related_projects->where('project_type', $this->project->project_type);

        $this->related_projects =  $related_projects->with('skills:id')->whereHas(
            'skills', function($query) use ($project_skills){
                if(!empty($project_skills)){
                    $query->whereIn('skill_id', $project_skills);
                }
            }
        )->limit(3)->get();

        if( $this->project->author_id != $this->profile_id ){
            AddVisitCount( $this->project->id, 'project');
        }
    }
   
    public function render()
    {
        $this->save_project = $this->savedProject;
        return view('livewire.project.project-detail')->extends('layouts.app', ['title' =>$this->project->project_title, 'include_menu' => true]);
    }

    public function getsavedProjectProperty(){
        return FavouriteItem::where(['user_id'=> $this->profile_id, 'corresponding_id' => $this->project->id, 'type' => 'project'])->count('id');
    }

    public function saveProject($project_id){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        
        favouriteItem( $this->profile_id, $project_id, 'project' );
    }

    public function downloadAttachments($id){

        $project = Project::select('attachments')->find($id);
        if(!empty($project) && !empty($project->attachments)){
            $attachments = unserialize($project->attachments);
            if(!empty($attachments['files'])){
                $path = storage_path('app/download/project/'.$id);
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $project_files = $attachments['files'];
                $zip      = new ZipArchive;
                $fileName = '/attachments.zip';
                $path = $path .$fileName;
                
                $zip->open($path, ZipArchive::CREATE);
                foreach ($project_files as $single) {
                    $name = basename($single->file_name);
                    if(file_get_contents(public_path('storage/'.$single->file_path))){
                        $zip->addFromString( $name, file_get_contents(public_path('storage/'.$single->file_path)));
                    }
                }
                $zip->close();
                return response()->download(storage_path('app/download/project/' . $id . $fileName));
            }
        }
    }
}
