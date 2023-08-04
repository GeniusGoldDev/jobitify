<!doctype html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="zxx">
<!--<![endif]-->
@php  
    $sitInfo        = getSiteInfo();
    $siteTitle      = $sitInfo['site_name'];
    $siteFavicon    = $sitInfo['site_favicon'];
    $rtl            = setting('_site.rtl');
    $rtl_class      = !empty($rtl) && $rtl == 1 ? 'tk-rtl' : ''; 
@endphp
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> {{ __('general.adminpanel_title') }} | {{$siteTitle}}</title>
        <link rel="icon" href="{{ asset('storage/'.$siteFavicon) }}" type="image/x-icon">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite([
            'public/common/css/bootstrap.min.css',
            'public/admin/css/themify-icons.css',
            'public/css/feather-icons.css',
            'public/css/fontawesome/all.min.css',
            'public/common/css/select2.min.css',
            'public/common/css/jquery.mCustomScrollbar.min.css',
            'public/common/css/jquery-confirm.min.css',
        ])
        @stack('styles')
        <link rel="stylesheet" href="{{ asset('admin/css/main.css') }}">
        @if( !empty($rtl_class) )
            <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/rtl.css') }}">
        @endif
        @livewireStyles
    </head>
    <body class="tb-bodycolor">
        @include('layouts.admin.header')
        <div class="tb-mainwrapper">
            @include('layouts.admin.sidebar')
            <div class="tb-subwrapper">
                <div class="container-fluid">
                    @yield('content')
                    @include('layouts.admin.footer')
                </div>
            </div>
        </div>
       
        @include('layouts.admin.footer_scripts')
        <script>
            $(document).on("click", '.update-section-settings, .reset-section-settings', function(event){
                setTimeout(function() {
                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ url('admin/update-sass-style') }}",
                        method: 'post',
                        success: function(data){
                        }
                    });
                }, 300);         
            });
        </script>
        @stack('scripts')
        @livewireScripts
    </body>
</html>



