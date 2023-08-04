<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php 
            $rtl                = setting('_site.rtl');
            $rtl_class          = !empty($rtl) && $rtl == 1 ? 'tk-rtl' : '';
        @endphp
        @props(['title'])
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> {{ $title }} | {{$siteTitle}} </title>
        @if( !empty($siteFavicon) )
            <link rel="icon" href="{{ asset('storage/'.$siteFavicon) }}" type="image/x-icon">
        @endif
        @vite([
            'public/common/css/bootstrap.min.css',
            'public/css/fontawesome/all.min.css',
        ])
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        @if( !empty($rtl_class) )
            <link rel="stylesheet" type="text/css" href="{{ asset('css/rtl.css') }}">
        @endif
       
    </head>
    <body class="{{ $rtl_class }}">
        {{ $slot }}
        <script src="{{ asset('common/js/jquery.min.js') }}"></script>
		<script defer src="{{ asset('common/js/bootstrap.min.js') }}"></script>
    </body>
</html>
