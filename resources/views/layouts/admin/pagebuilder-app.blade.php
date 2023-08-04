<!doctype html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="zxx">
<!--<![endif]-->

    <head>
        @php  
            $sitInfo = getSiteInfo();
            $siteTitle = $sitInfo['site_name'];
            $siteFavicon = $sitInfo['site_favicon'];
        @endphp
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> {{$siteTitle}} | {{ __('general.adminpanel_title') }}</title>
        @if( !empty($siteFavicon) )
            <link rel="icon" href="{{ asset('storage/'.$siteFavicon) }}"  type="image/x-icon">
        @endif
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('common/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/fontawesome/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('common/css/jquery.mCustomScrollbar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('common/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('common/css/jquery-confirm.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/feather-icons.css') }}">
        @stack('styles')
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('pagebuilder/css/main.css') }}">
        @livewireStyles
    </head>
    <body class="tb-bodycolor">
        @yield('content') 
        <script src="{{ asset('common/js/jquery.min.js') }}"></script>
        <script defer src="{{ asset('common/js/bootstrap.min.js') }}"></script>
        <script defer src="{{ asset('pagebuilder/js/splide.min.js') }}"></script>
        <script defer src="{{ asset('common/js/select2.min.js') }} "></script>
        <script defer src="{{ asset('common/js/jquery.mCustomScrollbar.min.js') }}"></script>
        <script defer src="{{ asset('admin/js/main.js') }}"></script>
        <script defer src="{{ asset('js/main.js') }}"></script>
        <script defer src="{{ asset('common/js/livewire-sortable.js') }}"></script>
        <script defer src="{{ asset('common/js/jquery-confirm.min.js') }}"></script>
        @stack('scripts')
        @livewireScripts
    </body>
</html>



