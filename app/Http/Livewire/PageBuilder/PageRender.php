<?php

namespace App\Http\Livewire\PageBuilder;

use App\Models\SitePage;
use Livewire\Component;

class PageRender extends Component
{
    
   
    public $page_id             = '';
    public $dropped_block_id    = '';
    public $page_blocks         = [];
    public $page_settings       = [];
    
    public function render(){

        $page                   = SitePage::select('id','settings')->find( $this->page_id );
        $this->page_settings    = !empty( $page->settings ) ? json_decode($page->settings, true) : [];
        if( $this->dropped_block_id != '' && !empty($this->page_blocks[$this->dropped_block_id]) ){
            $response = isDemoSite();
            if( $response ){
                $this->dispatchBrowserEvent('showAlertMessage', [
                    'type'      => 'error',
                    'title'     => __('general.demosite_res_title'),
                    'message'   => __('general.demosite_res_txt')
                ]);
               
            }else{
                if( !empty($page) ){

                    $this->page_settings[] = [
                        'block_id'       => $this->dropped_block_id,
                        'css'           => [],   
                        'settings'      => []
                    ];

                    $settings = json_encode($this->page_settings);
                    $page->update(['settings' => $settings]);
                }
            }    
            $this->dropped_block_id = ''; 
        }
        
        return view('livewire.pagebuilder.page-render');
    }

    public function mount( $page_id, $page_blocks){

       $this->page_id       = $page_id; 
       $this->page_blocks   = $page_blocks; 
       
    }

    public function cloneBlock( $key ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $page = SitePage::select('id', 'settings')->find( $this->page_id );
        $this->page_settings    = !empty( $page->settings ) ? json_decode($page->settings, true) : [];
        if( isset($this->page_settings[$key]) ){

            $tempArray = [];
            $cloneData = array($this->page_settings[$key]);
            array_splice( $this->page_settings, $key+1, 0, $cloneData );
            $settings = json_encode($this->page_settings);
            $page->update(['settings' => $settings]);
        }
    }

    public function deleteBlock( $key ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        if( isset($this->page_settings[$key]) ){

            unset($this->page_settings[$key]);
            $settings = null;
            if(!empty($this->page_settings)){
                $settings = json_encode($this->page_settings);
            }
            SitePage::select('id')->where('id', $this->page_id)->update(['settings' => $settings]);
            $this->emit('resetSetting');
        }
    }

    public function updateBlockOrder( $blocks_list ){
        
        $response = isDemoSite();
        if( $response ){
            $this->dispatchBrowserEvent('showAlertMessage', [
                'type'      => 'error',
                'title'     => __('general.demosite_res_title'),
                'message'   => __('general.demosite_res_txt')
            ]);
            return;
        }

        $this->emit('resetSetting');
        $tempArray = [];
        $page = SitePage::select('id', 'settings')->find( $this->page_id );
        $this->page_settings    = !empty( $page->settings ) ? json_decode($page->settings, true) : [];
        
        if( !empty($blocks_list) ){

            foreach ($blocks_list as $single) {
                
                $value  = explode('__', $single['value']);
                $index    = isset($value[1]) ? $value[1] : '';
                $key    = $single['order'] - 1;

                if(!empty($this->page_settings[$index])){
                
                    $tempArray[$key] = $this->page_settings[$index];
                }
            }
        }

        if( !empty($tempArray) ){
            $this->page_settings = $tempArray;
            $settings = json_encode($this->page_settings);
            $page->update(['settings' => $settings]);
        }
    }
}
