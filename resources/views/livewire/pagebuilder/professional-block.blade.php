<section class="tk-testimonial tk-main-section-two {{ $block_key }} {{$custom_class}}" @if(!$site_view)  wire:click="$emit('getBlockSetting', '{{$block_key}}')" @endif>
    @if( !empty($style_css) )
        <style>{{ '.'.$block_key.$style_css }}</style>
    @endif
    <div class="container" wire:loading.class="tk-section-preloader">
        @if(!$site_view)
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            @if(!empty($sub_title) || !empty($title) || !empty($description) )
                <div class="col-lg-8 col-sm-12">
                    <div class="tk-main-title-holder text-center">
                        @if(!empty($sub_title) || !empty($title) )
                            <div class="tk-maintitle">
                                @if(!empty($sub_title))<h3 class="tk-colorgray">{!! $sub_title !!}</h3>@endif
                                @if(!empty($title))<h2>{!! $title !!}</h2>@endif
                            </div>
                        @endif
                        @if(!empty($description))
                            <div class="tk-main-description">
                                <p>{{$description}}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            @if(!empty($team_members))
                <div class="col-12">
                    <div id="tk-professionolslider" class="tk-professionolslider tk-popularcategories tk-sliderarrow">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach($team_members as $member)
                                    <li class="splide__slide">
                                        <div class="tk-profeesonitem">
                                            @if(!empty($member['image']))
                                                <figure>
                                                    <img data-src="{{asset($member['image'])}}" alt="image">
                                                </figure>
                                            @endif

                                            <div class="tk-profeesonolinfo text-center">
                                                <h6>{!! $member['designation'] !!}</h6>
                                                <h4>{!! $member['name'] !!}</h4>
                                            </div>
                                            <ul class="tk-socailmedia tk-socialicons-two">
                                                <li><a class="tk-facebook" href="{{!empty($member['facebook_link']) ? $member['facebook_link'] : 'javascript:void();'}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a class="tk-twitter" href="{{!empty($member['twitter_link']) ? $member['twitter_link'] : 'javascript:void();'}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                                <li><a class="tk-linkedin" href="{{!empty($member['linkedin_link']) ? $member['linkedin_link'] : 'javascript:void();'}}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                                <li><a class="tk-twitch" href="{{!empty($member['twitter_link']) ? $member['twitter_link'] : 'javascript:void();'}}" target="_blank"><i class="fab fa-twitch"></i></a></li>
                                                <li><a class="tk-dribbble" href="{{!empty($member['dribbble_link']) ? $member['dribbble_link'] : 'javascript:void();'}}" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@push('styles')
    @vite([
        'public/pagebuilder/css/splide.min.css', 
    ])
@endpush
@php 
    $rtl = setting('_site.rtl');
@endphp
@push('scripts')
    <script defer src="{{ asset('pagebuilder/js/splide.min.js') }}"></script>

    <script>
		document.addEventListener('livewire:load', function () {
            let tk_professionolslider = document.querySelector(".tk-professionolslider");
            if (tk_professionolslider !== null) {
                let settings = {
                    type: 'loop',
                    perPage: 4,
                    perMove: 1,
                    arrows: true,
                    pagination: false,
                    gap: 24,
                    breakpoints: {
                        1400: {
                            perPage: 3,
                        },
                        991: {
                            perPage: 2,
                            focus: 'center',
                        },
                        575: {
                            perPage: 2,
                            gap: 20,
                            arrows: false,
                            pagination: true,
                            focus: 'center',
                        },
                        480: {
                            perPage: 1,
                            arrows: false,
                            pagination: true,
                            focus: 'center',
                        },
                    }
                }
                
                let isRTL = '{{$rtl}}';
                if(isRTL == '1'){
                    settings['direction'] = 'rtl';
                }
                var splide = new Splide(".tk-professionolslider", settings);
                splide.mount();
            }
        });
    </script>
@endpush

