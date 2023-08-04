<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $sitInfo        = getSiteInfo();
        $siteFavicon    = $sitInfo['site_favicon'];
        $siteTitle      = $sitInfo['site_name'];
        $siteLogo       = $sitInfo['site_dark_logo'];
        return view('layouts.guest', compact('siteFavicon', 'siteTitle', 'siteLogo'));
    }
}
