<?php

namespace App\Http\Livewire\Admin\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmailTemplate;
use App\Notifications\EmailNotification;

class Projects extends Component
{
    use WithPagination;

    public $filter_project      = '';
    public $search_project      = '';
    public $date_format         = '';
    public $currency_symbol     = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $project_id          = null; 

    protected $paginationTheme  = 'bootstrap';
    protected $listeners = ['approveProjectConfirm' => 'approveProject', 'deleteProject'];

    public function render(){
       
        $projects = Project::select( 
            'id',
            'project_title',
            'author_id',
            'slug',
            'created_at',
            'project_type',
            'project_min_price',
            'project_max_price',
            'status'
        );

        if( $this->filter_project ){
            $projects = $projects->where('status', $this->filter_project);
        }
        $projects = $projects->with('projectAuthor:id,image,first_name,last_name');
        if( !empty($this->search_project) ){
            $projects = $projects->where(function($query){
                $query = $query->whereFullText('project_title', $this->search_project);
                $query = $query->orWhereFullText('project_description', $this->search_project);
            });

        }
        $projects = $projects->where('status', '!=', 'draft');
        $projects = $projects->orderBy('id', $this->sortby);
        $projects = $projects->paginate($this->per_page);

        return view('livewire.admin.projects.projects', compact( 'projects'))->extends('layouts.admin.app');
    }

    
    public function mount(){
        
        $this->per_page_opt     = perPageOpt();
        $date_format            = setting('_general.date_format');
        $per_page_record        = setting('_general.per_page_record');
        $currency               = setting('_general.currency');
        $this->per_page         = !empty( $per_page_record ) ? $per_page_record : 10;
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        $currency_detail        = !empty( $currency)  ? currencyList($currency) : array();
        
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }
    }

    public function updatedSearchProject(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedFilterProject(){
        $this->resetPage(); // default function of pagination
    }

    public function updatedPerPage(){
        $this->resetPage(); // default function of pagination
    }

    public function confirmApprove( $id ){  
        $this->project_id = $id;
        $this->dispatchBrowserEvent('approve-project-confirm');
    }    

    public function approveProject( $params ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $project_detail = Project::where('status', 'pending')->find( $params['id'] );
        $project_detail = $project_detail->load(['projectAuthor'=> function($query){
            $query->select('id','user_id','first_name','last_name');
            $query->with('user');
        }]);
       
  
        if( !empty($project_detail) ){
            $project_title  = $project_detail->project_title;
            $project_slug   = $project_detail->slug;
            $user_name      = $project_detail->projectAuthor->full_name;
            $notifyUser      = $project_detail->projectAuthor->user;
            $params = array(
                'project_title' => $project_title, 
                'project_slug'  => $project_slug, 
                'user_name'     => $user_name, 
                'email_type'    => 'project_approved', 
                'notifyUser'    => $notifyUser, 
            );

            $this->notifyProjectApprove($params);
            $project_detail->update(['status' => 'publish']);
        }
    }

    public function notifyProjectApprove($data){
     
        $email_template = EmailTemplate::select('content')
        ->where(['type' => $data['email_type'] , 'status' => 'active', 'role' => 'buyer'])
        ->latest()->first();
       
        if(!empty($email_template)){
            $template_data              =  unserialize($email_template->content);
            $params                     = array();
            $params['template_type']    = $data['email_type'];
            $params['email_params']     = array(
                'user_name'             => $data['user_name'],
                'project_title'         => $data['project_title'],
                'project_link'          => route('project-detail',[ 'slug' => $data['project_slug']]),
                'email_subject'         => !empty($template_data['subject'])    ? $template_data['subject'] : '',     
                'email_greeting'        => !empty($template_data['greeting'])   ? $template_data['greeting'] : '',     
                'email_content'         => !empty($template_data['content'])    ? $template_data['content'] : '',     
            );
            try {
                $data['notifyUser']->notify(new EmailNotification($params));
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

    public function deleteProject( $params ){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $project = Project::select('id', 'status')->with('proposals')->find( $params['id'] );

        if( !empty($project) ){

            if( $project->status == 'pending' ){
                $project->delete();
                $this->resetPage();
            }elseif( $project->status == 'publish' ){

                if( $project->proposals->isEmpty() ){
                    $project->delete();
                    $this->resetPage();
                }else{
                    $delete_flag = true;
                    foreach($project->proposals as $single){
                        if( in_array($single->status , array('publish', 'hired', 'declined', 'queued', 'completed', 'refunded', 'disputed', 'rejected' )) ){
                            $delete_flag = false;
                            break;
                        }
                    }
                    if( $delete_flag ){
                        $project->delete();
                        $this->resetPage();
                    }else{
                        $this->dispatchBrowserEvent('showAlertMessage', [
                            'type'      => 'error',
                            'title'     => __('general.error_title'),
                            'message'   => __('project.project_delete_error')
                        ]);
                        return;  
                    }
                }
            }else{
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('general.error_title'),
                    'message'   => __('project.project_delete_error')
                ]);
                return;
            }
        }
    }
}
