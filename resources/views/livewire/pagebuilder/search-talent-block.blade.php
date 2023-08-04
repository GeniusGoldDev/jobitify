
<section class="tk-main-sectionv2 tk-ouraim-section {{ $block_key }} {{$custom_class}}" @if(!$site_view) wire:click="$emit('getBlockSetting', '{{ $block_key }}')" @endif >
    <div class="container" wire:loading.class="tk-section-preloader">
        @if(!$site_view)
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                </div>
            </div>
        @endif
        <div class="row align-items-center">
            @if(!empty($title) || !empty($sub_title) || !empty($description) || !empty($search_btn_txt))
                <div class="col-xl-5">
                    <div class="tk-main-title-holder">
                        @if(!empty($title) || !empty($sub_title) )
                            <div class="tk-maintitle">
                                @if(!empty($sub_title))<h5>{!! $sub_title !!}</h5>@endif
                                @if(!empty($title))<h2>{!! $title !!}</h2>@endif
                            </div>
                        @endif
                        @if(!empty($description))
                            <div class="tk-main-description">
                                <p>{!! $description !!}</p>
                            </div>
                        @endif
                        @if(!empty($search_btn_txt))
                            <div class="tk-btn-holder">
                                <a href="{{route('search-sellers')}}" class="tk-btn-yellow-lg">{!! $search_btn_txt !!} <i class="icon-user-check"></i> </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if(!empty($main_image) || !empty($card_image) )
                <div class="col-md-12 col-xl-7">
                    <div class="tk-about-image">
                        <figure>
                            @if(!empty($main_image))
                                <img src="{{asset($main_image)}}" alt="image">
                            @endif
                            @if(!empty($card_image))
                                <figcaption>
                                    <img src="{{asset($card_image)}}" alt="image">
                                </figcaption>
                            @endif
                        </figure>
                    </div>    
                </div>
            @endif

        </div>
    </div>
</section>

