@php 
    use Carbon\Carbon;
@endphp
<main class="tk-main-bg">
    <section class="tk-main-section">
        <div class="container">
            @if( !empty($packages) || !$packages->isEmpty() )
                <div class="tk-pricingholder">
                    <div class="row justify-content-center">
                        <div class="col-lg-9 col-xl-8">
                            <div class="tk-sectioninfo tk-sectioninfov2 tk-sectioncenter">
                                <div class="tk-sectiontitle text-center">
                                    <h3>{{ __('general.packages_offer') }}</h3>
                                    <h2 class="tk-sectiontitle__bold">{{ __('general.packages_info_title') }}</h2>
                                    <div class="tk-main-description">
                                        <p>{!! nl2br(__('general.packages_info_desc')) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tk-pricing">
                        <div class="row">
                            @foreach( $packages as $single )
                                @php
                                    $subsc_packages     = array_key_exists($single->id, $subscribe_packages) ? $subscribe_packages[$single->id] : [];
                                    $rem_quota          = [];
                                    $pkg_status         = '';
                                    $remaining_duration = '';
                                    $pkg_type           = '';

                                    if( !empty($subsc_packages) && $subsc_packages->status == 'active'){
                                        $subsc_options      = @unserialize($subsc_packages->package_options);
                                        $rem_quota          = !empty($subsc_options['rem_quota']) ? $subsc_options['rem_quota'] : [];
                                        $pkg_status         = $subsc_packages->status;
                                        $expiry_date        = Carbon::parse($subsc_packages->package_expiry);
                                        $pkg_type           = $subsc_options['type'];
                                        if( $expiry_date->gte(Carbon::now()) ){
                                            if( $pkg_type == 'day'){
                                                $remaining_duration = Carbon::now()->floatDiffInDays($expiry_date);
                                                $remaining_duration = intval( $remaining_duration );
                                            } elseif( $pkg_type == 'month'){
                                                $remaining_duration = Carbon::now()->floatDiffInMonths($expiry_date);
                                                $remaining_duration = intval( $remaining_duration );
                                            } elseif( $pkg_type == 'year'){
                                                $remaining_duration = Carbon::now()->floatDiffInYears($expiry_date);
                                                $remaining_duration = intval( $remaining_duration );
                                            }
                                        }
                                    } elseif( !empty($subsc_packages) && $subsc_packages->status == 'expired'){
                                        $pkg_status = $subsc_packages->status;
                                    }
                                    $options    = unserialize($single->options);
                                    $duration   = $options['duration'] > 1 ? $options['duration'] .' '. $options['type'].'s' : $options['duration'] .' '. $options['type'];
                                @endphp
                                <div class="col-md-6 col-lg-4">
                                    <div class="tk-pricing__content {{$pkg_status == 'active' ? 'tk-activepakage' : ''}}">
                                        @php
                                            $image = '';
                                        if( $single->image != ''){
                                            $image = unserialize($single->image);
                                            $image = asset('storage/' .$image['file_path']);
                                        }
                                        @endphp
                                        @if( $pkg_status == 'active' )
                                            <span>{{__('general.current_package')}}</span>
                                        @elseif( $pkg_status == 'expired')
                                            <span class="tk-pakagexpired">{{__('general.expired_package')}}</span>
                                        @endif
                                        @if( $image != '')
                                            <img src="{{ $image }}" >
                                        @endif
                                        <h4>{{ $single->title }}</h4>
                                        <h2><sup>{{ $currency_symbol }}</sup>{{ number_format( $single->price, 2) }}</h2>
                                        <h4>{{ __('general.'.$options['type']) }}</h4>
                                        <em>{{ __('general.include_all_tax') }}</em>
                                        <ul class="tk-pricinglist">
                                            <li>
                                                <div class="tk-pricinglist__content">
                                                    <span>{{ __('general.package_duration') }}</span>
                                                    <span>
                                                        @if( $remaining_duration > 0 )
                                                            <em>{{ number_format( $remaining_duration) }} / </em>
                                                        @elseif( $remaining_duration == 0 && !empty($pkg_type))
                                                            <em> {{ __('general.last_'.$pkg_type) }} / </em>
                                                        @endif
                                                        {{ $duration }}
                                                    </span>
                                                </div>
                                            </li>
                                            @if( $single->package_role->name == 'buyer')
                                                <li>
                                                    <div class="tk-pricinglist__content">
                                                        <span>{{ __('general.no_of_projects') }}</span>
                                                        <span>
                                                            @if( !empty($rem_quota) && isset($rem_quota['posted_projects']) )
                                                                <em>{{ $rem_quota['posted_projects'] }} / </em>
                                                            @endif
                                                            {{ $options['posted_projects'] }} {{ __('general.projects') }}
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tk-pricinglist__content">
                                                        <span>{{ __('general.feature_projects') }}</span>
                                                        <span>
                                                            @if( !empty($rem_quota) && isset($rem_quota['featured_projects']) )
                                                                <em>{{ $rem_quota['featured_projects'] }} / </em>
                                                            @endif
                                                            {{ $options['featured_projects'] }} {{ __('general.allowed') }}
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tk-pricinglist__content">
                                                        <span>{{ __('general.feature_project_duration') }}</span>
                                                        <span>{{ $options['project_featured_days'] }} {{ __('general.day') }}</span>
                                                    </div>
                                                </li>
                                            @else
                                                <li>
                                                    <div class="tk-pricinglist__content">
                                                        <span>{{ __('general.credit_for_project') }}</span>
                                                        <span>
                                                            @if( !empty($rem_quota) && isset($rem_quota['credits']) )
                                                                <em>{{ $rem_quota['credits'] }} / </em>
                                                            @endif
                                                            {{ $options['credits'] }} {{ __('general.credits') }}
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tk-pricinglist__content">
                                                        <span>{{ __('general.profile_feature_duration') }}</span>
                                                        <span>{{ $options['profile_featured_days'] }} {{ __('general.day') }}</span>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                        <a href="javascript:;" wire:click.prevent="buyPackage({{ $single->id }})"  class="tk-btn-solid-lg">
                                            @if(in_array($pkg_status, ['active','expired']))
                                                {{ __('general.renew_package') }}
                                            @else
                                                {{ __('general.buy_now') }}
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>