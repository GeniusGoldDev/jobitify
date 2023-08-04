@php
    $info       = getUserInfo();
    $siteInfo   = getSiteInfo();
    $site_dark_logo  = !empty($siteInfo['site_dark_logo']) ? 'storage/'.$siteInfo['site_dark_logo'] : 'images/logo.svg';
 
@endphp


<header class="tb-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="tb-header-wraper">
                    <div class="tb-logowrapper">
                    <strong class="tk-logo">
                            <a href="{{url('/')}}">
                                <img src="{{asset($site_dark_logo)}}" />
                            </a>
                        </strong>
                        <a href="javascript:void(0)"><i class="icon-menu"></i></a>

                    </div>
                    <div class="tb-headercontent">
                        <div class="tb-frontendsite">
                            <a href="{{ url('clear-cache') }}">
                                <div class="tb-frontendsite__title">
                                    <h5>{{ __('general.clear_cache') }}</h5>
                                </div>
                                <i class="ti-reload"></i>
                            </a>
                        </div>
                        <div class="tb-frontendsite">
                            <a href="{{ url('/') }}" target="_blank">
                                <div class="tb-frontendsite__title">
                                    <h5>{{ __('general.view_site') }}</h5>
                                </div>
                                <i class="ti-new-window"></i>
                            </a>
                        </div>
                        @if(!empty($info) )
                            <div class="tb-adminhead">
                                <strong class="tb-adminhead__img">
                                    <img src="{{ asset($info['user_image']) }}" alt="{{ $info['user_name'] }}">
                                </strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
