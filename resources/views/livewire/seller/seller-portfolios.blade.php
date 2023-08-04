<div id="portfolio" wire:init="loadPortfolios"  class="tk-profilebox">
    <div class="tk-content-box">
        <h4>{{ __('general.all_portfolio') }}</h4>
    </div>
    @if( $page_loaded )
        @if( !$portfolios->IsEmpty() )
            <div class="swiper tk-portfolio-slider tk-swiperdotsvtwo">
                <div class="swiper-wrapper">
                    @foreach($portfolios as $portfolio)
                        <div class="swiper-slide">
                            <x-portfolio-item :data="$portfolio" />
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
@push('styles')
    @vite([
        'public/pagebuilder/css/swiper-bundle.min.css', 
    ])
@endpush
@push('scripts')

    <script>
       window.addEventListener('initializePortfolioSlider', event=>{
            let data                = [];
            data['selector']        = 'tk-portfolio-slider'; 
            data['preview_count']   = 3;
            initPortfolioSlider(data);

            if($('.tk-profilemain').find('.swiper-button-lock').hasClass('swiper-button-disabled')){
                $('.tk-profilemain').find('.swiper-button-lock').parent().addClass('d-none');
            }
        });
    </script>
@endpush