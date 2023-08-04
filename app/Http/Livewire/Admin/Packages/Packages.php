<?php

namespace App\Http\Livewire\Admin\Packages;

use Livewire\Component;
use App\Rules\OverflowRule;
use Livewire\WithFileUploads;
use App\Models\Package\Package;
use App\Models\Setting\SiteSetting;

class Packages extends Component
{

    use WithFileUploads;
    public $settings      = [
        'package_option' => null,
        'single_project_credits' => null,
    ];
    public $package_for         = 'buyer';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $search              = '';
    public $selectedPackages    = [];
    public $selectAll           = false;
    public $editMode            = false;
    public $allowImageExt       = [];
    public $allowImageSize      = '';
    public $old_image           = array();
    public $package = [
        'package_id'                => null,
        'options'                   => null,
        'image'                     => null,
        'status'                    => 'active',
        // for both
        'title'                     => null,
        'price'                     => null,
        'role_id'                   => null,
        'type'                      => null,
        'duration'                  => null,

        // for buyer
        'posted_projects'           => null,
        'featured_projects'         => null,
        'project_featured_days'     => null,
        // for seller
        'credits'                    => null,
        'profile_featured_days'     => null,
    ];
    public $currency = '';
    public $viewPackage = array();
    
    protected $listeners = ['deleteConfirmRecord' => 'deletePackage'];
    public function render()
    {
        $package_opt = [
            'free'          => __('settings.package_opt_free'),
            'paid'          => __('settings.package_opt_paid'),
            'seller_paid'   => __('settings.package_opt_seller_paid'),
            'buyer_paid'    => __('settings.package_opt_buyer_paid'),
        ];

        $package_type = [
            'day'       => __('settings.day_option'),
            'month'     => __('settings.month_option'),
            'year'      => __('settings.year_option'),
        ];

        $packages               = $this->Packages;
        $currency               = setting('_general.currency');
        $image_file_ext         = setting('_general.image_file_ext');
        $image_file_size        = setting('_general.image_file_size');
        $selectedCurrency       = !empty( $currency ) ? $currency : 'USD';
        $this->allowImageSize   = !empty( $image_file_size ) ? $image_file_size : '3';
        $this->allowImageExt    = !empty( $image_file_ext ) ?  explode(',', $image_file_ext)  : ['jpg','png'];
        $currency_detail        = currencyList( $selectedCurrency );

        if( !empty($currency_detail) ){
            $this->currency = $currency_detail['symbol']; 
        }

        $data = [
            'package_opt'       => $package_opt, 
            'packages'          => $packages, 
            'package_type'      => $package_type, 
            'currency'          => $this->currency,
            'allow_image_ext'   => $this->allowImageExt,
            'allow_image_size'   => $this->allowImageSize
        ];
     
        return view('livewire.admin.packages.packages', $data)->extends('layouts.admin.app');
    }

    public function getPackagesProperty(){ // mounted property

        $packages = new Package;
        if( !empty($this->search) ){
            $packages = $packages->whereFullText('title', $this->search);   
        }
        return $packages->orderBy('id', $this->sortby)->paginate($this->per_page);
    }

    public function getSettings(){

        $settings = SiteSetting::select('meta_key','meta_value')->where('setting_type', 'package')->get()->toArray();
        if( ! empty($settings) ){
            foreach($settings as $setting){
                $this->settings[$setting['meta_key']] = $setting['meta_value'];
            }
        }
    }

    public function mount()
    {
        $this->per_page_opt = perPageOpt();
        $per_page_record    = setting('_general.per_page_record');
        $this->per_page     = !empty( $per_page_record ) ? $per_page_record : 10;
        $this->getSettings();
    }

    public function updateSetting()
    {

        $record = '';
        foreach($this->settings as $key => $value){
            $record = SiteSetting::select('id')->updateOrCreate(
                [
                    'setting_type'  => 'package',
                    'meta_key'      => $key
                ],
                [ 
                    'meta_key'      => $key, 
                    'meta_value'    => sanitizeTextField( $value),
                    'setting_type'  => 'package',
                ]
            );
        }


            if( ! empty( $record ) ){
                $eventData['title']     = __('general.success_title');
                $eventData['message']   = __('settings.updated_msg');
                $eventData['type']      = 'success';
            } else {
                $eventData['title']     = __('general.error_title');
                $eventData['message']   = __('settings.wrong_msg');
                $eventData['type']      = 'error';
            }

            $this->dispatchBrowserEvent('showAlertMessage', $eventData);

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
       
        $validation =  array(
            'package.title'                 => 'required',
            'package.price'                 => ['required','numeric',new OverflowRule(0,99999999)],
            'package.type'                  => 'required',
            'package.duration'              => 'required|numeric',
            //for buyer
            'package.posted_projects'       => 'sometimes|nullable|required_if:package_for,buyer|numeric',
            'package.featured_projects'     => 'sometimes|nullable|required_if:package_for,buyer|numeric',
            'package.project_featured_days' => 'sometimes|nullable|required_if:package_for,buyer|numeric',
            //seller
            'package.credits'                => 'sometimes|nullable|required_if:package_for,seller|numeric',
            'package.profile_featured_days' => 'sometimes|nullable|required_if:package_for,seller|numeric',
            'package.image'                 => 'nullable|image|mimes:'.join(',', $this->allowImageExt).'|max:'.$this->allowImageSize*1024,
        );
        $messages = array(
            'required'      => __('general.required_field'),
            'required_if'   => __('general.required_field'),
            'numeric'       => __('general.numeric_field'),
            'max'           => __('general.max_file_size_err',  ['file_size'=> $this->allowImageSize.'MB']),
            'mimes'         => __('general.invalid_file_type',['file_types'=> join(',', $this->allowImageExt)]),
        );
        $validated_data  = $this->validate($validation, $messages);
       
        
       


        // logo
        $data = $serializeData = [];
        $data['title']      = $data['slug'] = sanitizeTextField( $this->package['title'] );
        $data['price']      = sanitizeTextField( $this->package['price'] );
        $data['type']       = $serializeData['type']        = sanitizeTextField( $this->package['type'] );
        $data['duration']   = $serializeData['duration']    = sanitizeTextField( $this->package['duration'] );
        $data['status']     = $this->package['status'];
        

    
        if( $this->package_for == 'buyer' ){
            $data['posted_projects']                = $serializeData['posted_projects']         = sanitizeTextField( $this->package['posted_projects'] );
            $data['featured_projects']              = $serializeData['featured_projects']       = sanitizeTextField( $this->package['featured_projects'] );
            $data['project_featured_days']          = $serializeData['project_featured_days']   = sanitizeTextField( $this->package['project_featured_days'] );
        }
        if( $this->package_for == 'seller' ) {
            $data['credits']                 = $serializeData['credits']                = sanitizeTextField( $this->package['credits'] );
            $data['profile_featured_days']  = $serializeData['profile_featured_days'] = $this->package['profile_featured_days'];
        }
    

        if( $this->package['image'] ){
            $image_path = $this->package['image']->store('public/package');
            $image_path = str_replace('public/', '', $image_path);
            $image_name = $this->package['image']->getClientOriginalName();
            $mime_type  = $this->package['image']->getMimeType();
            $imageObject = array(
                'file_name'  => $image_name,
                'file_path'  => $image_path,
                'mime_type'  => $mime_type,
            );
            $data['image']  = serialize($imageObject);
        }else{
            $data['image'] =!empty($this->old_image) ? serialize($this->old_image) : null;
        }

        $options = serialize($serializeData);
        $role_id = getRoleByName($this->package_for);
        $data['role_id'] = $role_id;
     
        $record = Package::select('id')->updateOrCreate(
            [
                'id'  => $this->package['package_id'], 
            ],
            [ 
                'title'     => $data['title'],
                'slug'      => $data['slug'],
                'price'     => $data['price'],
                'options'   => $options, 
                'role_id'   => $role_id, 
                'image'     => $data['image'],
                'status'    => $data['status'],
            ]
        );
        

        if( ! empty( $record ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('settings.updated_msg');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';
        }

        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
        $this->editMode = false;
        $this->resetInputfields();

    }

    public function edit($id){
       
        $package = Package::whereId($id)->first();
        if(! empty( $package )) {
            $this->editMode = true;
            $this->resetInputfields();
            $this->package['package_id']    = $package->id;
            $this->package['image']         = null;
            $this->old_image                = !empty($package->image) ? unserialize($package->image) : array();
            $this->package['status']        = $package->status;
            $this->package['title']         = $package->title;
            $this->package['price']         = $package->price;
            $this->package['role_id']       = $package->role_id;
            
            $roleName = getRoleById($package->role_id);
           
            $this->package_for = $roleName;
            $options = unserialize($package->options);
            
            if( !empty( $options ) ) {
                $this->package['duration']      =! empty( $options['duration'] )        ? $options['duration'] : null;
                $this->package['type']      =! empty( $options['type'] )        ? $options['type'] : null;
                if( $roleName == 'buyer' ){
                    $this->package['posted_projects']       = ! empty( $options['posted_projects'] )        ? $options['posted_projects'] : null;
                    $this->package['featured_projects']     = ! empty( $options['featured_projects'] )      ? $options['featured_projects'] : null;
                    $this->package['project_featured_days'] = ! empty( $options['project_featured_days'] )  ? $options['project_featured_days'] : null;
                } elseif( $roleName == 'seller' ){
                    $this->package['credits']                = ! empty( $options['credits'] )                 ? $options['credits'] : null;
                    $this->package['profile_featured_days'] = ! empty( $options['profile_featured_days'] )  ? $options['profile_featured_days'] : null;
                }
            }

            $this->dispatchBrowserEvent('editPackage', ['package_type'=> $this->package['type']]);
        }
    }

    public function resetInputfields() {

        $this->package = [
            'package_id'    => null,
            'options'       => null,
            'image'         => null,
            'status'        => 'active',
            'title'                     => null,
            'price'                     => null,
            'role_id'                   => null,
            'type'                      => null, 
            'duration'                  => null, 
            'posted_projects'           => null, 
            'featured_projects'         => null, 
            'project_featured_days'     => null, 
            'credits'                   => null, 
            'profile_featured_days'     => null,
        ];
        $this->selectedPackages = [];
        $this->selectAll = false;
        $this->old_image = array();
    }

    public function removeImage()
    {
        $this->package['image'] = null;
        $this->old_image        = array();
    }

    public function previewPackage($id){
        
        $package = Package::whereId($id)->first();

        if(!empty($package)){
            $this->viewPackage = array();
            $roleName = getRoleById($package->role_id);
           
            $data = array(
            'status'                    => $package->status,
            'title'                     => $package->title,
            'price'                     => $package->price,
            'role_id'                   => $package->role_id,
            'image'                     => $package->image,
            'package_for'               => $roleName,
            );

            $options = unserialize($package->options);
            if( !empty( $options ) ) {
                $data['duration']      =! empty( $options['duration'] )        ? $options['duration'] : null;
                $data['type']      =! empty( $options['type'] )        ? $options['type'] : null;
                if( $roleName == 'buyer' ){
                    $data['posted_projects']       = ! empty( $options['posted_projects'] )        ? $options['posted_projects'] : null;
                    $data['featured_projects']     = ! empty( $options['featured_projects'] )      ? $options['featured_projects'] : null;
                    $data['project_featured_days'] = ! empty( $options['project_featured_days'] )  ? $options['project_featured_days'] : null;
                } elseif( $roleName == 'seller' ){
                    $data['credits']                = ! empty( $options['credits'] )                ? $options['credits'] : null;
                    $data['profile_featured_days']  = ! empty( $options['profile_featured_days'] )  ? $options['profile_featured_days'] : null;
                }
            }

            $this->viewPackage = $data;
     
            $this->dispatchBrowserEvent('previewPackage', array('modal' => 'show'));
        }
    }
}
