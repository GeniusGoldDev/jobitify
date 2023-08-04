<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Carbon\Carbon;

class ProjectActivity extends Component
{
    
    public $profile_id              = 0;
    public $address_format          = '';
    public $currency_symbol         = ''; 
    public $isAuthor                = false; 
    public $isProposalAuthor        = false; 
    public $userRole                = ''; 
    public $selected_proposal       = 0; 
    public $project                 = '';
    public $project_slug            = '';
    public $isRTL                   = '';
    protected $queryString = [
        'selected_proposal'  => ['except' => 0, 'as'=> 'id'],
    ];

    public function mount( $slug ){

        $user = getUserRole();
        $this->profile_id       = $user['profileId']; 
        $this->userRole         = $user['roleName'];
        $date_format            = setting('_general.date_format');
        $address_format         = setting('_general.address_format');
        $currency               = setting('_general.currency');
        $this->isRTL            = setting('_site.rtl');
        $this->address_format   = !empty( $address_format )  ? $address_format : 'state_country';
        $currency_detail        = !empty( $currency)  ? currencyList($currency) : array();
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        
        if( !empty($currency_detail) ){
            $this->currency_symbol  = $currency_detail['symbol']; 
        }
       
        $this->project = Project::select( 
            'id',
            'project_title',
            'author_id',
            'slug',
            'updated_at',
            'project_type',
            'project_min_price',
            'project_max_hours',
            'project_location',
            'project_country',
            'project_expert_level',
            'project_duration',
            'project_max_price',
            'address',
            'project_hiring_seller',
            'is_featured',
        )->has('proposals')->with(
            array(
                'projectLocation:id,name',
                'expertiseLevel:id,name',
                'proposals' => function($query) {

                    if($this->userRole == 'seller'){
                        $query->where(['author_id' => $this->profile_id, 'id' => $this->selected_proposal ]);
                    }

                    $query->select('id', 'project_id', 'author_id','status');
                    $query->whereIn('status', array('disputed', 'hired', 'queued', 'rejected', 'completed', 'refunded'));
                    $query->orderBy('id','desc');
                    $query->has('proposalAuthor')->with('proposalAuthor:id,first_name,last_name,image');
                },
                 
            )
        );

       
        $this->project  = $this->project->where('slug', $slug)->firstOrFail();
        
        $this->project_slug = $slug;
        if( $this->profile_id == $this->project->author_id ){
            $this->isAuthor = true;
        }

        if( $this->userRole == 'seller' && !$this->project->proposals->isEmpty()){
            foreach( $this->project->proposals as $proposal ){
                if($proposal->id == $this->selected_proposal && $this->profile_id == $proposal->author_id){
                    $this->isProposalAuthor = true;
                }
            }
        }


        if( $this->userRole == 'seller' && !$this->isProposalAuthor ){
            abort('404');
        }

        if( $this->userRole == 'buyer' && !$this->isAuthor ){
            abort('404');
        }
       
        if( $this->selected_proposal == 0 && !$this->project->proposals->isEmpty() ){
            $this->selected_proposal = $this->project->proposals[0]->id;
        }
        
    }
   
    public function render(){
        
        return view('livewire.project.project-activity')->extends('layouts.app');
    }
}
