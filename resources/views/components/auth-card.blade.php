@props(['description', 'sitelogo', 'auth_bg'])

<div class="tk-loginconatiner tk-loginconatiner-two" @if( !empty($auth_bg) ) style="background-image: url('{{asset('storage/'.$auth_bg)}}')" @endif>
    <div class="tk-popupcontainer w-100">
        <div class="tk-login-content">
            <div class="tk-login-info">
                @if( !empty($sitelogo) )
                    <a href="{{ url('/')}}"><img src="{{asset('storage/'.$sitelogo)}}" alt="{{ __('general.logo') }}" /></a>
                @else
                    <a href="{{ url('/')}}"><img src="{{asset('demo-content/logo.png')}}" alt="{{ __('general.logo') }}" /></a>
                @endif
                @if( !empty($description) )<h5>{{$description}}</h5>@endif
            </div>
            {{ $slot }}
        </div>
    </div>
</div>