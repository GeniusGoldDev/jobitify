<?php

namespace App\Http\Livewire\Admin\Menu;

use App\Models\SitePage;
use App\Models\Menu;
use App\Models\MenuItem;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class ManageMenu extends Component
{
    public $menu_title, $site_pages,$menu_id, $custom_page_title, $custom_page_route, $menu_location;
    public $menu_item_ids   = [];
    public $add_menu        = true;
    public $page_ids        = [];
    protected $listeners = ['confirmDeleteMenu' => 'deleteMenu', 'confirmDeleteMenuItems' => 'deleteMenuItems'];
    
    public function render(){

        $menu_items = []; 
      
        if( !empty($this->menu_id) ){
            $menu_items = MenuItem::where('menu_id', $this->menu_id)->orderBy('sort','asc')->tree()->get()->toTree();
        
        }
        $menu_list = Menu::select('id', 'name')->orderBy('id','desc')->get();
        return view('livewire.admin.menu.manage-menu', compact('menu_list', 'menu_items'))->extends('layouts.admin.app');
    }

    public function mount(){

        $this->site_pages = SitePage::select('id','name', 'title', 'route')->where('status', 'publish')->get();
    }

    public function createMenu(){
        
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
            'menu_title'     => 'required', 
            'menu_location'  => 'required', 
        ]);

        $menu = Menu::create([
            'name'      => sanitizeTextField($this->menu_title),
            'location'  => sanitizeTextField($this->menu_location),
        ]);

        $eventData['title']         = $menu ? __('general.success_title') : __('general.error_title');
        $eventData['type']          = $menu ? 'success' : 'error';
        $eventData['message']       = $menu ? __('general.success_message') : __('general.error_msg');
        $eventData['autoClose']     = 3000;
        
        $this->menu_id = $menu->id;
        $this->add_menu = false;
        $this->dispatchBrowserEvent('showAlertMessage', $eventData);
    }

    public function addPages(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $menu_items = [];
        if( !empty($this->page_ids) && !empty($this->menu_id) ){

            $site_pages = SitePage::select('id', 'title', 'route')->whereIn('id', $this->page_ids)->get()->toArray();
            if( !empty($site_pages) ){
                foreach($site_pages as $single){
                    $menu_items[] = [
                        'menu_id'   => $this->menu_id,
                        'label'     => $single['title'],
                        'route'     => $single['route'],
                        'type'      => 'page',
                    ] ;
                }
            }
            if( !empty($menu_items) ){
                MenuItem::insert($menu_items);
            }
            $this->dispatchBrowserEvent('initializeSortable');
        }else{
            $eventData['title']         =  __('general.error_title');
            $eventData['type']          =  'error';
            $eventData['message']       =  __('pages.select_menu_err');
            $eventData['autoClose']     = 3000;
            $this->dispatchBrowserEvent('showAlertMessage', $eventData); 
        }
    }

    
    public function addCustomPage(){
        
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
            'custom_page_title'     => 'required', 
        ]);

        if( !empty($this->menu_id) ){

            $menu_item = [
                'menu_id'   => $this->menu_id,
                'label'     => sanitizeTextField($this->custom_page_title),
                'route'     => !empty($this->custom_page_route) ? sanitizeTextField( $this->custom_page_route ) : null,
                'type'      => 'custom',
            ];

            MenuItem::create($menu_item);
            $this->custom_page_title = $this->custom_page_route = '';
            $this->dispatchBrowserEvent('initializeSortable');
        }else{
            $eventData['title']         =  __('general.error_title');
            $eventData['type']          =  'error';
            $eventData['message']       =  __('pages.select_menu_err');
            $eventData['autoClose']     = 3000;
            $this->dispatchBrowserEvent('showAlertMessage', $eventData); 
        }    
    }

    public function updateMenuItems( $form_data ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( $this->menu_id ){

            Cache::forget('header-menu' );
            Cache::forget('header-menu-'.$this->menu_id );
            Cache::forget('footer-menu' );
            Cache::forget('footer-menu-'.$this->menu_id );

            $this->validate([
                'menu_title'     => 'required', 
                'menu_location'  => 'required', 
            ]);
            Menu::where('id', $this->menu_id)->update([
                'name'      => sanitizeTextField($this->menu_title),
                'location'  => sanitizeTextField($this->menu_location),
            ]);
            parse_str( $form_data, $data );
            $updated_items  = !empty($data['updateItems']) ? json_decode($data['updateItems'], true) : [];
            $removal_items  = !empty($data['removalIds']) ? json_decode($data['removalIds'], true) : [];
          
            if(!empty($removal_items)){
                MenuItem::where('menu_id', $this->menu_id)->whereIn('id', $removal_items)->delete();
            }

            if( !empty($updated_items) ){

                $item_names     = !empty($data['item-name'])    ? $data['item-name'] : [];
                $item_route     = !empty($data['item-route'])   ? $data['item-route'] : [];
                $item_type      = !empty($data['item-type'])    ? $data['item-type'] : [];
                $params = [
                  'item_names'  => $item_names,  
                  'item_route'  => $item_route,  
                  'item_type'   => $item_type,  
                ];
                $menu_items = [];
                foreach( $updated_items as $key => $single ){
                    $params['index']        = $key;
                    $params['parent_id']    = null;
                    $this->setMenuItems( $params, $single );
                }
                $eventData['title']         = __('general.success_title');
                $eventData['type']          =  'success';
                $eventData['message']       = __('general.success_message');
                $eventData['autoClose']     = 3000;
                $this->dispatchBrowserEvent('showAlertMessage', $eventData); 
                $this->dispatchBrowserEvent('initializeSortable');
            }else{
                MenuItem::where('menu_id', $this->menu_id)->delete();
            }
        }
    }

    private function setMenuItems( $params, $item){
       
        MenuItem::updateOrCreate(['id' => $item['id'], 'menu_id' => $this->menu_id ],[
            'menu_id'        => $this->menu_id, 
            'parent_id'      => $params['parent_id'], 
            'label'          => !empty($params['item_names'][$item['id']]) ? sanitizeTextField($params['item_names'][$item['id']]) : '', 
            'route'          => !empty($params['item_route'][$item['id']]) ? sanitizeTextField($params['item_route'][$item['id']]) : '', 
            'type'           => !empty($params['item_type'][$item['id']])  ? sanitizeTextField($params['item_type'][$item['id']]) : '', 
            'sort'           => $params['index'],  
        ]);

        if( !empty($item['children']) ){

            foreach( $item['children'] as $key => $child){
                
                $params['index']        = $key;
                $params['parent_id']    = $item['id'];
               
                $this->setMenuItems($params, $child);
            }
        }
    }

    public function updatedMenuId( $id ){
        
        $this->menu_id      = '';
        $this->menu_title   = '';
        $this->add_menu     = false;
        if($id){
            $menu = Menu::select('id', 'name', 'location')->find($id);
            if( $menu ){
                $this->menu_id = $id;
                $this->menu_title       = $menu->name;
                $this->menu_location    = $menu->location;
            }
            $this->dispatchBrowserEvent('initializeSortable');
        }
    }

    public function addMenu( ){
        
        $this->add_menu = true;
        $this->menu_id = '';
        $this->menu_title = '';
        $this->menu_location = '';
    }

    public function deleteMenu($menu_id){

        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        Cache::forget('header-menu' );
        Cache::forget('footer-menu' );
        
        if( !empty($menu_id) ){

            Menu::destroy($menu_id);
            $this->menu_id      = '';
            $this->menu_title   = '';
            $this->add_menu     = true;
            $this->menu_location = '';
            MenuItem::where('menu_id', $this->menu_id)->delete();
        }
    }

    public function deleteMenuItems(){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }
        
        if( !empty($menu_item_ids) ){

            MenuItem::whereIn('id', $menu_item_ids)->delete();
            $this->menu_item_ids = [];
        }
    }
}
