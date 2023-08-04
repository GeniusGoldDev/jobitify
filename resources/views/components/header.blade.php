@props(['sitelogo', 'header_menu'])
@php
    $class = 'tk-headervtwo';
    $currentURL = url()->current();
    if( url('/') == $currentURL ){
        $class = '';
    } 
    $logo = url('/') == $currentURL ? 'demo-content/logo.png' : 'demo-content/taskup-logo.png';
    $userInfo   = getUserInfo();
    $userRole   = !empty( $userInfo['user_role'] ) ? $userInfo['user_role'] : '';
    $top_menue  = [];
    
    if( in_array($userRole, ['admin','seller']) ){
        $top_menue['search-projects']   = __('navigation.explore_all_projects');
        if($userRole == 'seller'){
            $top_menue['dashboard']     = __('navigation.dashboard');
        }
        if($userRole == 'admin'){
            $top_menue['search-sellers'] = __('navigation.search_seller');
            $top_menue['search-gigs']    = __('navigation.search_gigs');
        }
    }
@endphp
<!-- HEADER START -->
<header class="tb-header {{ $class }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="tb-headerwrap {{$userRole == 'seller' ? 'tk-sellermenu' : ''}}">
                    <strong class="tk-logo">
                        @if( !empty($sitelogo) )
                            <a href="{{ url('/')}}"><img src="{{asset('storage/'.$sitelogo)}}" alt="{{ __('general.logo') }}" /></a>
                        @else
                            <a href="{{ url('/')}}"><img src="{{asset($logo)}}" alt="{{ __('general.logo') }}" /></a>
                        @endif
                    </strong>
                    <nav class="tb-navbar navbar-expand-xl">
                        @if( Auth::guest() || ( Auth::user() && !empty($top_menue) ))
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#tenavbar" aria-expanded="false" >
                                <i class="icon-menu"></i>
                            </button>
                        @endif
                        @if( Auth::user() && !empty($top_menue))
                            <div id="tenavbar" class="collapse navbar-collapse">
                                <ul class="navbar-nav tb-navbarnav">
                                    @foreach($top_menue as $route => $menu_item)
                                        <li class="tb-find-projects">
                                            <a href="{{route($route)}}"> {{ $menu_item }} </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif(Auth::guest())
                            <div id="tenavbar" class="collapse navbar-collapse">
                                <ul class="navbar-nav tb-navbarnav">
                                    @if( !empty($header_menu) && $header_menu->count() > 0 ) 
                                        @foreach( $header_menu as $menu)
                                            <x-menu-item :menu="$menu" />
                                        @endforeach
                                    @endif
                                    <li class="tk-themenav_signbtn">
                                        <a class="tk-btn-solid-sm tk-registerbtn" href="{{ route('register') }}"><i class="icon icon-user-plus"></i>{{ __( 'general.register' ) }} </a>
                                        <a class="tk-btn-solid-sm tk-btn-yellow" href="{{ route('login') }}"><i class="icon icon-arrow-right"></i> {{ __( 'general.login' ) }} </a>
                                    </li>
                                </ul>
                            </div> 
                        @endif
                    </nav>
                    @if( Auth::user() )
                       <x-user-menu />
                    @endif   
                </div>
            </div>
        </div>
    </div>
</header>
@role('buyer|seller')
    <div class="tk-headerbottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tk-seller-tabs">
                        <nav class="tb-navbar tb-navbarbtm navbar-expand-xl">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavvtwo" aria-expanded="false" >
                                <i class="icon-menu"></i>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavvtwo">
                                <ul class="nav nav-tabs tk-seller-list navbar-nav" id="myTab" role="tablist">
                                    <li class="tk-seller-item">
                                        <a @if( request()->routeIs('dashboard') ) class="active" @endif href="{{route('dashboard')}}">
                                            <i class="icon-bar-chart-2"></i>{{__('navigation.dashboard')}}
                                        </a>
                                    </li>
                                    <li class="tk-seller-item">
                                        <a @if( request()->routeIs('project-listing') ) class="active" @endif href="{{route('project-listing')}}">
                                            <i class="icon-layers"></i>{{__('navigation.my_projects')}}
                                        </a>
                                    </li>
                                    @role('seller')
                                        <li class="tk-seller-item">
                                            <a @if( request()->routeIs('gig-list') ) class="active" @endif href="{{route('gig-list')}}">
                                                <i class="icon-file-text"></i>{{__('navigation.my_gigs')}}
                                            </a>
                                        </li>
                                    @endrole
                                    <li class="tk-seller-item">
                                        <a @if( request()->routeIs('gig-orders') ) class="active" @endif href="{{route('gig-orders')}}">
                                            <i class="icon-check-square"></i>
                                            @role('seller')
                                                {{__('navigation.my_orders')}}
                                            @else
                                                {{__('navigation.gig_orders')}}
                                            @endrole
                                        </a>
                                    </li>
                                    @role('buyer')
                                        <li class="tk-seller-item">
                                            <a @if( request()->routeIs('search-gigs') ) class="active" @endif href="{{route('search-gigs')}}">
                                                <i class="icon-file-text"></i>{{__('navigation.search_gigs')}}
                                            </a>
                                        </li>
                                        <li class="tk-seller-item">
                                            <a @if( request()->routeIs('search-sellers') ) class="active" @endif href="{{route('search-sellers')}}">
                                                <i class="icon-star"></i>{{__('navigation.search_seller')}}
                                            </a>
                                        </li>
                                    @endrole
                                    <li class="tk-seller-item">
                                        <a @if( request()->routeIs('dispute-list') ) class="active" @endif href="{{route('dispute-list')}}">
                                            <i class="icon-alert-triangle"></i>{{__('navigation.disputes')}}
                                        </a>
                                    </li>
                                    @role('seller')
                                        <li class="tk-seller-item">
                                            <a @if( request()->routeIs('invoices') ) class="active" @endif href="{{route('invoices')}}">
                                                <i class="icon-shopping-bag"></i>{{__('navigation.invoices')}}
                                            </a>
                                        </li>
                                    @endrole
                                    <li class="tk-seller-item">
                                        <a @if( request()->routeIs('favourite-items') ) class="active" @endif href="{{route('favourite-items')}}">
                                            <i class="icon-heart"></i>{{__('navigation.saved_items')}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                        <div class="tk-bootstraps-tabs-button">
                            @role('seller')
                                <a href="{{route('create-gig')}}" class="tk-tabs-button">{{__('navigation.create_gig')}}
                                    <i class="icon-plus"></i>
                                </a>
                            @else
                                <a href="{{route('create-project')}}" class="tk-tabs-button">{{__('navigation.post_project')}}
                                    <i class="icon-plus"></i>
                                </a>
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endrole
    
<!-- HEADER END -->