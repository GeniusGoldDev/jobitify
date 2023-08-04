<?php

namespace App\Http\Livewire\PageBuilder;

use App\Models\Menu;
use Livewire\Component;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Cache;

class TopMenuBlock extends Component
{
    public $header_menu, $site_dark_logo;

    public function render()
    {
        return view('livewire.pagebuilder.top-menu-block');
    }

    public function mount(){

        $menu = Cache::rememberForever('header-menu', function() {
            return Menu::select('id')->where('location', 'header')->latest()->first();
        });
       
        if( !empty($menu) ){
            
            $header_menu = Cache::rememberForever('header-menu-'.$menu->id, function() use($menu){
                return MenuItem::where('menu_id', $menu->id)->orderBy('sort','asc')->tree()->get()->toTree(); 
            });

            $this->header_menu      = $header_menu;
            $sitInfo                = getSiteInfo();
            $currentURL = url()->current();

            if( url('/') == $currentURL ){
                $this->site_dark_logo   = $sitInfo['site_dark_logo'];
            } else {
                $this->site_dark_logo   = $sitInfo['site_lite_logo'];
            }
        }
    }
}
