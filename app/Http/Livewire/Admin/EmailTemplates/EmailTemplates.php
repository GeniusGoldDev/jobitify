<?php

namespace App\Http\Livewire\Admin\EmailTemplates;


use App\Models\EmailTemplate;
use Livewire\WithPagination;
use Livewire\Component;


class EmailTemplates extends Component
{
    use WithPagination;

    public $email_type                      = '';
    public $delete_id                       = '';
    public $sortby                          = 'desc';
    public $edit_id                         = 0;
    public $search                          = '';
    public $date_format                     = '';
    public $per_page                        = '10';
    public $status                          = 'active';
    public $per_page_opt                    = [];
    public $user_id                         = null; 
    public $selected_template               = []; 
    public $template_key                    = ''; 
    public $validated_fields                = []; 
    protected $paginationTheme              = 'bootstrap';

    protected $listeners = ['deleteConfirmRecord' => 'deleteTemplate'];
    
    public function render(){
       
        $exclude_templates          = array();
        $this->emailTemplates       = getEmailTemplates();
        $listed_templated           = new EmailTemplate;
        if( !empty($this->search) ){
            $listed_templated = $listed_templated->whereFullText('title', $this->search);   
        }
        $listed_templated           = $listed_templated->orderBy('id', $this->sortby)->paginate( $this->per_page );
        $templates                  = EmailTemplate::select('type', 'role')->get();
        if( !empty($templates) ){
            foreach( $templates as $single ){
                $exclude_templates[] =  $single['type'].'-'.$single['role'];
            }
        }

        $this->dispatchBrowserEvent('initSelect2');

        return view('livewire.admin.email-templates.email-templates', compact('listed_templated', 'exclude_templates'))->extends('layouts.admin.app');
    }

    
    public function mount(){
        
        $this->per_page_opt     = perPageOpt();
        $date_format            = setting('_general.date_format');
        $per_page_record        = setting('_general.per_page_record');
        $this->per_page         = !empty( $per_page_record )   ? $per_page_record : 10;
        $this->date_format      = !empty($date_format)    ? $date_format : 'm d, Y';
        
    }

    public function updatedSearch(){ // update variable value
        $this->resetPage(); // default function of pagination
    }

    public function updatedtemplateKey( $value ){
        
        if( !empty($value) ){

            $_key = explode('-', $value);
            $this->selected_template = [];
            $type = !empty($_key[1]) ? $_key[1] : ''; 
            if( $this->emailTemplates[$_key[0]]['roles'][$type] ){

                $this->selected_template = $this->emailTemplates[$_key[0]]['roles'][$type]['fields'];
            
                foreach( $this->selected_template  as $key => $single ){
                
                    if( !empty($single['id']) ){
                        $this->validated_fields[$single['id']] =  str_ireplace('<br>', "\r\n", $single['default']);
                    }
                }
            }
        }
    }

    public function deleteTemplate( $params ){
        
        if( !empty($params['id']) ){
            $record = EmailTemplate::where('id', $params['id']);
            $record->delete();
            $this->edit_id = 0;
            $this->status = 'active';
            $this->selected_template    = [];
            $this->validated_fields     = [];
        }
    }

    public function edit( $id ){

        $record = EmailTemplate::findOrFail($id);
        $this->edit_id = $id;
        $this->email_type = $record->type;
        $this->selected_template = $this->emailTemplates[$record->type]['roles'][$record->role]['fields'];
        $fields = unserialize($record->content);
        foreach($this->selected_template as $key => &$single){
            
            if( !empty($single['id'])){

                if(isset($fields[$single['id']]) ){
                    $single['default'] = $fields[$single['id']];
                }
                $this->validated_fields[$single['id']] =  $single['default'];
            }
        }
        $this->status = $record->status;
    }

    public function saveEmailTemplate(){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        
        if( !empty($this->validated_fields) ){

            foreach( $this->validated_fields as $key => $single ){
                $fields['validated_fields.'.$key] = 'required';
            }

            $this->validate($fields, [ 'required' => __('general.required_field')]);
            
            if( $this->edit_id ){
                
                $template   = $this->emailTemplates[$this->email_type];
                $title      =    $template['title'];
                $data       = [
                    'title'         => $template['title'],
                    'content'       => serialize( SanitizeArray( $this->validated_fields ) ),
                    'status'        => $this->status,
                ];
            }else{
                $_key       = explode('-', $this->template_key);
                $template   = $this->emailTemplates[$_key[0]];
                $type       = !empty($_key[1]) ? $_key[1] : ''; 
                $data       = [
                    'title'         => $template['title'],
                    'type'          => $_key[0],
                    'role'          => $type,
                    'status'        => $this->status,
                    'content'       => serialize( SanitizeArray( $this->validated_fields ) ),
                ];
            }
            
            EmailTemplate::updateOrCreate(['id' => $this->edit_id ], $data); 
            $this->edit_id = 0;
            $this->status = 'active';
            $this->selected_template    = [];
            $this->validated_fields     = [];
        }
    }
}
