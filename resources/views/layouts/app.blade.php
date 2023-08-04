<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php  
            $sitInfo        = getSiteInfo();
            $siteFavicon    = $sitInfo['site_favicon'];
            $siteTitle      = $sitInfo['site_name'];
            $siteDarkLogo   = $sitInfo['site_dark_logo'];
            $siteLiteLogo   = $sitInfo['site_lite_logo'];

            $adsense_client_id  = setting('_adsense.adsense_client_id');
            $rtl                = setting('_site.rtl');
            $rtl_class          = !empty($rtl) && $rtl == 1 ? 'tk-rtl' : ''; 
            $currentURL         = url()->current();
            $siteLogo           = url('/') == $currentURL ? $siteDarkLogo : $siteLiteLogo;
        @endphp
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if( !empty($title) )
            <title>{{ $title }} | {{ $siteTitle }} </title>
        @else
            <title> {{ __('general.dashbaord') }} | {{ $siteTitle }}</title>
        @endif

        @if( !empty($page_description) )
            <meta name="description" content="{!! $page_description !!}">
        @endif
        @if( !empty($siteFavicon) )
            <link rel="icon" href="{{ asset('storage/'.$siteFavicon) }}" type="image/x-icon">
        @endif
        @vite([
            'public/common/css/bootstrap.min.css',
            'public/css/feather-icons.css',
            'public/css/fontawesome/nunito-font.css',
            'public/css/fontawesome/all.min.css',
            'public/common/css/select2.min.css',
            'public/common/css/jquery.mCustomScrollbar.min.css',
            'public/common/css/jquery-confirm.min.css',
        ])
        @stack('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
        @if( !empty($rtl_class) )
            <link rel="stylesheet" type="text/css" href="{{ asset('css/rtl.css') }}">
        @endif
        @livewireStyles

        @if( ( !empty($include_menu) || !empty($site_view) ) && !empty($adsense_client_id) )
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{$adsense_client_id}}" crossorigin="anonymous"></script>
            <script>
                (adsbygoogle=window.adsbygoogle||[]).pauseAdRequests=1;
                (adsbygoogle=window.adsbygoogle||[]).push({google_ad_client: "{{$adsense_client_id}}", enable_page_level_ads: true});
            </script>
        @endif
    </head>
    <body class="font-sans antialiased {{ $rtl_class }}">

        <div class="min-h-screen bg-gray-100">
            @if( (empty($site_view) || !$site_view))
                @php
                    $header_menu = [];
                    if( !empty($include_menu)){
                        $header_menu    = getHeaderMenu();
                    }
                @endphp
                <x-header :sitelogo="$siteLogo" :header_menu="$header_menu" />
            @endif

            @yield('content')

            @if( (empty($site_view) || !$site_view))
            
                @php
                    $footer_settings = getFooterSettings('footer_page');
                @endphp
                @if( !empty($footer_settings) )
                    <livewire:page-builder.footer-block 
                        :page_id="$footer_settings['page_id']" 
                        :block_key="$footer_settings['block_key']" 
                        :settings="$footer_settings['settings']" 
                        :style_css="$footer_settings['style_css']" 
                        :site_view="true"
                    />
                @endif
            @endif
        </div>

        @vite([
            'public/common/js/jquery-confirm.min.js',
        ])
        
        <script src="{{ asset('common/js/jquery.min.js') }}"></script>
        @stack('scripts')
        @include('layouts.footer_scripts')
        @livewireScripts
    </body>
</html>
