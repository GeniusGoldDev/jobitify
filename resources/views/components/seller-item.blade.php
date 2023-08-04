@props(['profile', 'favourite_sellers', 'currency_symbol', 'is_save_item', 'user_role', 'address_format' => 'state_country'])
<div class="tk-project-wrapper-two tk-find-talent">
    <div class="tk-project-box tk-employerproject">
        <div class="tk-employerproject-title">
            <div class="tk-price-holder">
                <div class="tk-freelancer-search">
                    <figure>
                        @php
                            if(!empty($profile->image)){
                                $image_url      = getProfileImageURL($profile->image, '100x100');
                                $seller_image   = !empty($image_url) ? 'storage/'.$image_url : '/images/default-user-100x100.png';
                            }else{
                                $seller_image   = 'images/default-user-100x100.png';
                            }
                        @endphp
                        <img src="{{ asset($seller_image) }}" alt="{{$profile->full_name }}">
                    </figure>
                    <div class="tk-freelancer-content-two">
                        <a href="{{ route('seller-profile', ['slug' => $profile->slug]) }}">
                            {{$profile->full_name }}
                            <x-verified-tippy /> 
                        </a>
                        <h5>{{ add3DotsInText($profile->tagline, ' ...', 70); }}</h5>
                        <ul class="tk-blogviewdatessm">
                            <li>
                                <i class="fas fa-star tk-yellow"></i>
                                <em> {{ ratingFormat( $profile->ratings_avg_rating ) }} </em>
                                <span>( {{ $profile->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($profile->ratings_count) ]) }} )</span>
                            </li>
                            @if(!empty($profile->address))
                                <li>
                                    <span>
                                        <i class="icon-map-pin"></i>
                                        {{ getUserAddress($profile->address, $address_format) }}
                                    </span>
                                </li>
                            @endif
                            <li>
                                <span>
                                    <i class="icon-eye"></i>
                                    {{ $profile->profile_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format($profile->profile_visits_count) ] ) }}
                                </span>
                            </li>
                            @if($user_role == 'buyer' || Auth::guest())
                                <li class="tk-saved {{ in_array($profile->id, $favourite_sellers) || $is_save_item ? 'tk-liked' : '' }} mt-0" wire:click.prevent="saveItem({{ $profile->id }})">
                                    <a href="javascript:void(0)"><i class="icon-heart"></i>{{ __('general.saved') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="tk-price-two">
                    <span>{{ __('general.starting_from') }}</span>
                    <h4>{{ __('general.per_hour_rate', ['rate' => number_format($profile->user->userAccountSetting->hourly_rate, 2), 'currency_symbol' => $currency_symbol]) }}</h4>
                    <div class="tk-project-option">
                        <a href="{{ route('seller-profile', ['slug' => $profile->slug]) }}" target="_blank" class="tk-invite-bidbtn">{{ __('proposal.view_profile') }}</a>
                    </div>
                </div>
            </div>
            <div class="tk-tags-holder">
                @if(!empty($profile->description))
                    @php 
                        $desc = $profile->description;
                        $short_desc = add3DotsInText($desc, ' ...', 170);
                    @endphp
                    <div class="tk-descriptions">
                        <p>
                            {!! nl2br($short_desc) !!}
                        </p>
                    </div>
                @endif
                @if( !$profile->skills->isEmpty() )
                <div class="tk-freelancer-holder">
                    <ul class="tk-tags_links">
                    @foreach($profile->skills as $skill)
                        <li><span class="tk-blog-tags">{{$skill->name}}</span></li>
                    @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>