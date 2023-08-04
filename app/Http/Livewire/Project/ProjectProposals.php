<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Carbon\Carbon;

class ProjectProposals extends Component
{
    
    public $slug                    = '';
    public $search                  = '';
    public $address_format          = '';
    public $filter_proposal         = '';
    public $profile_id              = 0;
    public $currency_symbol         = ''; 
    public $date_format             = ''; 

    public function mount($slug){

        $this->slug = $slug;
        $user = getUserRole();
        $this->profile_id            = $user['profileId']; 

        $date_format            = setting('_general.date_format');
        $address_format         = setting('_general.address_format');
        $currency               = setting('_general.currency');
        $currency_detail        = !empty( $currency)  ? currencyList($currency) : array();
        
        if( !empty($currency_detail['symbol']) ){
            $this->currency_symbol = $currency_detail['symbol']; 
        }
        
        $this->date_format           = !empty($date_format)  ? $date_format : 'm d, Y';
        $this->address_format        = !empty($address_format)  ? $address_format : 'state_country';
        
    }
   
    public function render(){
       
        $params = array();
        
        if(!empty($this->filter_proposal)){
            $params['status'] = $this->filter_proposal;
        }

       

        if(!empty($this->search)){
            $params['search'] = $this->search;
        }
        
        $project =  Project::select(
                'id',
                'project_title',
                'slug',
                'project_type',
                'is_featured',
                'project_min_price',
                'project_max_price',
                'project_location',
                'project_country',
                'project_expert_level',
                'project_hiring_seller',
                'status',
                'updated_at',
            )->where('author_id', $this->profile_id)->with(
            array(
                'projectLocation:id,name',
                'expertiseLevel:id,name',
                'proposals' => function($query) use($params) {
                    
                    $query->select('id', 'author_id','project_id', 'proposal_amount', 'status', 'updated_at');
                    
                    if(!empty($params['status'])){
                        $query->where('status', $params['status']); 
                    }

                    $query->with('proposalAuthor',function ($profile){

                        $profile->select('id','first_name','last_name','image');
                        $profile->withAvg('ratings','rating')->withCount('ratings');

                    })->whereHas(

                        'proposalAuthor', function ($profile) use ($params){
                            if( !empty($params['search']) ){
                                $profile->where( function($query) use ($params) {
                                    $query->whereFullText('first_name', $params['search']);   
                                    $query->orWhereFullText('last_name', $params['search']); 
                                    $query->orWhereFullText('tagline', $params['search']);
                                });
                            }
                        }
                    );

                    $query->whereNotIn('status', array('draft', 'pending'));
                    $query->orderBy('id', 'desc');
                }
            )
        );

        $project = $project->whereNotIn('status', array('draft', 'pending'));
        $project = $project->where('slug', $this->slug)->firstOrFail();

        return view('livewire.project.project-proposals', compact('project'))->extends('layouts.app');
    }
}
