<div class="col-lg-8 col-xl-9" wire:init="loadGigs" wire:target="keyword" wire:loading.class="tk-section-preloader" >
    <div class="preloader-outer" wire:loading wire:target="keyword">
        <div class="tk-preloader">
            <img class="fa-spin" src="{{ asset('images/loader.png') }}" >
        </div>
    </div>
    @if( !empty($page_loaded) )
        @if(!empty($gigs) && $keyword !='')
            <h3>{{ $gigs->count() .' '.  __('general.search_result') }} “{{ clean($keyword) }}”</h3>
        @endif
        
        @if(!empty($gigs) && $gigs->count() > 0)
            <ul class="tk-savelisting tk-searchgig_listing">
                @foreach($gigs as $gig)
                    <x-gig-item :gig="$gig" :address_format="$address_format" :fav_gigs="$fav_gigs" :user_role="$roleName" :currency_symbol="$currency_symbol" :is_save_item="false"/>
                @endforeach
            </ul>
            {{ $gigs->links('pagination.custom') }}
        @else
            <div class="tk-submitreview">
                <figure>
                    <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                </figure>
                <h4>{{ __('general.no_record') }}</h4>
            </div> 
        @endif
    @else
        <div class="tk-section-skeleton">
            @for($i=0; $i < 3; $i++ )
                <div class="tk-box">
                    <div class="tk-skeleton-left">
                        <figure class="tk-line tk-img-area">
                        </figure>
                        <div class="align-items-center align-self-center tk-right-sk">
                            <div class="tk-right-sk-right">
                                <ul>
                                    <li class="tk-line tk-skeletontwo"></li>
                                    <li class="tk-line tk-skeletonfull"></li>
                                </ul>
                                <div class="tk-righ-sk-last">
                                    <div class="tk-line tk-skeletonfour"></div>
                                    <div class="tk-line tk-skeletonfive"></div>
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonfour"></div>
                                </div>
                            </div>
                            <div class="tk-skeltonprice">
                                <div class="tk-right-sk-end">
                                    <div class="tk-line tk-skeletoneight"></div>
                                    <div class="tk-line tk-skeletonseven"></div>
                                </div>
                                <hr class="tk-skeleton-divider">
                                <div class="tk-right-sk-end">
                                    <div class="tk-line tk-skeletonten"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    @endif
</div>

@push('scripts')
    <script defer src="{{ asset('js/app.js') }}"></script>
@endpush
