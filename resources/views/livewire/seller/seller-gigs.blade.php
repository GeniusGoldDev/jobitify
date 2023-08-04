<div id="gigs" wire:init="loadGigs"  class="tk-profilebox">
    <div class="tk-content-box">
        <h4>{{ __('gig.gig_offered_title', ['user_name' => $seller_name]) }}</h4>
    
        @if( $page_loaded )
            @if( !$gigs->IsEmpty() )
                <div class="swiper tk-servicesslider tk-swiperdotsvtwo">
                    <div class="swiper-wrapper">
                        @foreach($gigs as $gig)
                            <div class="swiper-slide">
                                <div class="tk-topservicetask">
                                        <figure class="tk-card__img">
                                            @php 
                                                $gig_image      = 'images/default-img-286x186.png';

                                                if(!empty($gig->attachments) ){
                                                    $files  = unserialize($gig->attachments);
                                                    $images = $files['files'];
                                                    $latest = current($images);
                                                    if( !empty($latest) && substr($latest->mime_type, 0, 5) == 'image'){
                                                        if(!empty($latest->sizes['286x186'])){
                                                            $gig_image = 'storage/'.$latest->sizes['286x186'];
                                                        } elseif(!empty($latest->file_path)){
                                                            $gig_image = 'storage/'.$latest->file_path;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <a href="javascript:;">
                                                <img src="{{ asset($gig_image) }}"  alt="{{ $gig->title }}">
                                            </a>
                                        </figure>
                                        @if($gig->is_featured)
                                            <span class="tk-featuretag">{{ __('general.featured') }}</span>
                                        @endif
                                    <div class="tk-sevicesinfo">
                                        <div class="tk-topservicetask__content">
                                            <div class="tk-title-wrapper">
                                                <div class="tk-card-title">
                                                    <a href="javasacript:;">
                                                        {{ $seller_name }}
                                                    </a>
                                                    @if( $verify_status == 'approved')
                                                        <x-verified-tippy />
                                                    @endif
                                                    @if($user_role == 'buyer' || Auth::guest())
                                                        <div class="tk-like {{in_array($gig->id, $fav_gigs) ? 'tk-heartsave' : '' }}">
                                                            <a href="javascript:void(0);" wire:click.prevent="favouriteGig({{$gig->id}})" class="tb_saved_items bg-heart"><i class="icon-heart"></i></a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <h5><a href="{{route('gig-detail',['slug' => $gig->slug])}}">{!! $gig->title !!}</a></h5>
                                            </div>
                                            <div class="tk-featureRating">
                                                <div class="tk-featureRating tk-featureRatingv2">
                                                    <i class="fas fa-star tk-yellow"></i>
                                                    <h6>{{ ratingFormat($gig->ratings_avg_rating) }} <em>/5.0</em></h6>
                                                    <em> {{  __('general.reviews') }}</em>
                                                </div>
                                                @if( !empty($gig->address) )
                                                    <address>
                                                        <i class="icon-map-pin"></i>{{ getUserAddress($gig->address, $address_format) }}
                                                    </address>
                                                @endif
                                            </div>
                                            <div class="tk-startingprice">
                                                <i>{{__('gig.starting_from')}}</i>
                                                <span> {{getPriceFormat($currency_symbol, $gig->gig_plans->min('price'))}} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tk-swipernav">
                        <div class="sliderarrow__prev"><i class="icon-chevron-left"></i></div>
                        <div class="swiper-pagination"></div>
                        <div class="sliderarrow__next"><i class="icon-chevron-right"></i></div>
                    </div>
                </div>
            @else
                <div class="tk-noskills">
                    <span>{{__('general.no_content_added')}}</span>
                </div>
            @endif
        @else
            <div class="tk-skeleton">
                <ul class="tk-services-skeleton">
                    @for($i =1; $i<=3; $i++)
                        <li>
                            <div class="tk-skeletonarea">
                                <figure class="tk-skele"></figure>
                                <div class="tk-content-area">
                                    <span class="tk-skeleton-title tk-skele"></span>
                                    <span class="tk-skeleton-description tk-skele"></span>
                                    <span class="tk-skeleton-para tk-skele"></span>
                                    <div class="tk-skeleton-user">
                                        <span class="tk-user-icon tk-skele"></span>
                                        <span class="tk-user tk-skele"></span>
                                    </div>
                                    <div class="tk-skeleton-user">
                                        <span class="tk-user-icon tk-skele"></span>
                                        <span class="tk-user tk-skele"></span>
                                    </div>
                                    <span class="tk-skeleton-details tk-skele"></span>
                                    <span class="tk-skeleton-details tk-skele"></span>
                                </div>
                            </div>
                        </li>
                    @endfor
                </ul>
            </div>
        @endif
    </div>
</div>
@push('styles')
    @vite([
        'public/pagebuilder/css/swiper-bundle.min.css', 
    ])
@endpush
@push('scripts')
<script defer src="{{ asset('pagebuilder/js/swiper-bundle.min.js') }}"></script>
<script defer src="{{ asset('js/app.js') }}"></script>
    <script>
       window.addEventListener('initializeSlider', event=>{
            let data = [];
            data['selector']        = 'tk-servicesslider'; 
            data['preview_count']   = 3;
            initSwiperSlider(data);
        });
    </script>
@endpush