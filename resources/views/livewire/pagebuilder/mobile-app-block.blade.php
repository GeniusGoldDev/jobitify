
<section class="tk-experince-section {{ $block_key }} {{$custom_class}}" @if(!$site_view) wire:click="$emit('getBlockSetting', '{{ $block_key }}')" @endif @if( !empty($mobile_app_bg) ) style="background-image: url({{asset($mobile_app_bg)}})" @endif>
    @if( !empty($style_css) )
        <style>{{ '.'.$block_key.$style_css }}</style>
    @endif
    <div class="tk-ourexperience" wire:loading.class="tk-section-preloader">
        @if(!$site_view)
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                </div>
            </div>
        @endif
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-xl-6">
                    <div class="tk-main-title-holder tk-sectionapptitle">
                        @if(!empty($heading))
                            {!! $heading !!} 
                        @endif

                        @if(!empty($description))
                            <div class="tk-main-description">
                                <p>{!! $description !!}</p>
                            </div>
                        @endif

                        <div class="tk-store-content">
                            @if(!empty($app_store_img))
                                <a href="{{$app_store_url}}">
                                    <img src="{{asset($app_store_img)}}" alt="{{__('pages.app_store_alt')}}">
                                </a>
                            @endif
                            @if(!empty($play_store_img))
                                <a href="{{$play_store_url}}">
                                    <img src="{{asset($play_store_img)}}" alt="{{__('pages.play_store_alt')}}">
                                </a>
                            @endif
                        </div>
                        @if(!empty($short_desc))
                            <div class="tk-appcompat">
                                <h6><i class="icon-bell"></i>{{$short_desc}}</h6>
                            </div>
                        @endif
                    </div>
                </div>
                @if(!empty($mobile_app_image))
                    <div class="col-md-6 d-xl-block d-none align-self-end">
                        <figure class="tk-appiamge">
                            <img data-src="{{asset($mobile_app_image)}}" alt="{{__('pages.mobile_app_alt')}}">
                        </figure>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>


