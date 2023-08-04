@php
    $info = getUserInfo();
@endphp
<div class="tb-headerwrap__right">
    <div class="tb-userlogin sub-menu-holder">
        <a href="javascript:void(0);" id="profile-avatar-menue-icon" class="tb-hasbalance">
            @role('buyer|seller')
                <div class="tk-wallet">
                    <span><strong>{{ getUserWalletAmount() }}</strong>{{__('general.wallet_balance')}}</span>
                </div>
              @endrole
            <img src="{{asset($info['user_image'])}}" alt="{{ $info['user_image'] }}" />
        </a>
        <ul class="sub-menu">
            @role('buyer|seller')
                <li class="tb-switch-profile">
                    <div class="tb-expert-content @role('buyer') tk-bgswtich @endrole">
                        @role('buyer')
                            <h2> {{ ucfirst( strtolower( __('general.switch_profile', ['user_role' => __('general.seller')])  ))}}</h2>
                            <p>{{ ucfirst( strtolower( __('general.switch_profile_desc', ['user_role' => __('general.buyer')]) ))}}</p>
                        @else
                            <h2>{{ ucfirst( strtolower( __('general.switch_profile', ['user_role' => __('general.buyer')]) ))}}</h2>
                            <p>{{ ucfirst( strtolower( __('general.switch_profile_desc', ['user_role' => __('general.seller')]) ))}}</p>
                        @endrole
                        <form method="POST" action="{{ route('switch-role') }}">
                            @csrf
                            <a class="tb-expert-anchor" href="{{ route('switch-role') }}" onclick="event.preventDefault(); this.closest('form').submit();"> 
                                {{ __('general.switch_role' )}}<i class="icon icon-chevron-right"></i>
                            </a>
                        </form>
                    </div>
                </li>
                @role('seller')
                    <li class="tb-account-settings">
                        <a href="{{route('seller-profile',['slug' => $info['slug']])}}" target="_blank"> <i class="icon-user"></i>{{ __('navigation.profile') }} </a>
                    </li>
                @endrole
                <li class="tb-account-settings">
                    <a href="{{route('settings')}}"> <i class="icon-settings"></i>{{ __('navigation.settings') }} </a>
                </li>
                <li class="tb-account-settings">
                    <a href="{{route('packages')}}"> <i class="icon-package"></i>{{ __('navigation.packages') }} </a>
                </li>
            @endrole
            @role('admin')
                <li class="tb-saveditems">
                    <a href="{{route('profile')}}"> <i class="icon-user"></i>{{ __('sidebar.profile') }} </a>
                </li>
                <li class="tb-saveditems">
                    <a href="{{route('optionbuilder')}}"> <i class="icon-settings"></i>{{ __('navigation.settings') }} </a>
                </li>
            @endrole
            <li class="tb-logout">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="icon-power"></i>{{ __('auth.logout') }} </a>
                </form>
            </li>
        </ul>
    </div>
</div>