<?php

namespace App\Http\Livewire\Admin\SitePages;

use DB;
use Carbon\Carbon;
use App\Models\SitePage;
use Livewire\WithPagination;
use Livewire\Component;

class SitePages extends Component
{
    use WithPagination;

    public $name, $title, $description, $edit_id, $slug;
    public $search              = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $status              = 'draft';
    public $per_page_opt        = [];

    protected $paginationTheme  = 'bootstrap';

    protected $listeners = ['deleteConfirmRecord' => 'deletepage'];

    public function mount(){

        $this->per_page_opt = perPageOpt();
        $per_page_record    = setting('_general.per_page_record');
        $this->per_page     = !empty( $per_page_record ) ? $per_page_record : 10;
    }

    public function render(){

        $pages = SitePage::select('id', 'name', 'title','description', 'route', 'status');
        if( !empty($this->search) ){
            $pages = $pages->whereFullText('name', $this->search);   
        } 
        $pages = $pages->orderBy('id', $this->sortby)->paginate($this->per_page);
        return view('livewire.admin.sitepages.sitepages', compact('pages'))->extends('layouts.admin.app');
    }
    
    public function updatedSearch(){ // update variable value
        $this->resetPage(); // default function of pagination
    }

    private function resetInputfields(){

        $this->name               = null;
        $this->title              = null;
        $this->description        = null;
        $this->delete_id          = null;
        $this->slug               = null;
        $this->edit_id            = null;
        $this->status             = 'draft';
    }

    public function edit( $id ){
        
        $record = SitePage::select('id', 'name', 'title','description', 'route', 'status')->findOrFail($id);
        
        $this->edit_id          = $id;
        $this->name             = $record->name;
        $this->title            = $record->title;
        $this->description      = $record->description;
        $this->slug             = $record->route;
        $this->status           = $record->status;
    }

    public function deletepage( $params ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( !empty($params['id']) ){
            $record = SitePage::where('id', $params['id']);
            $record->delete();

            $this->resetInputfields();
        }
    }

    public function update(){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        
        $validated_data  = $this->validate([
            'name'              => 'required',
            'title'             => 'required',
        ]);

        $page_data['name']          = sanitizeTextField($this->name);
        $page_data['title']         = sanitizeTextField($this->title);
        $page_data['description']   = sanitizeTextField($this->description, true);
        $route                      = empty($this->slug) ? null : sanitizeTextField($this->slug);
        $page_data['status']        = in_array( $this->status, ['publish', 'draft'] ) ? $this->status : 'draft';

        if( $this->edit_id > 0 && !empty($route) ){

            $route_old = SitePage::select('route')->find( $this->edit_id);
            if( $route_old->route != $route ){
                $page_data['route'] = $route;
            }
        }else{
            $page_data['route'] = $route;
        }
        $record = SitePage::updateOrCreate(['id' => $this->edit_id ], $page_data );
        

        $eventData['title']     = __('general.success_title');
        $eventData['type']      = 'success';
        $eventData['message']   = $this->edit_id ? __('general.updated_msg') : __('general.added_msg');
        
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        
        $this->resetInputfields();
    }
}
