
<div class="tk-bannerv5 {{ $block_key }} {{$custom_class}}" @if(!$site_view) wire:click="$emit('getBlockSetting', '{{ $block_key }}')" @endif @if( !empty($header_background) ) style="background-image: url({{asset($header_background)}})" @endif>
    
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
        <div class="row align-content-center">
            <div class="col-xl-7">
                <div class="tk-banner-content">
                    <div class="tk-bannerv3_title">
                        {!! $heading !!}
                    </div>
                    <ul class="tk-themebanner_list">
                        <li><a href="{{route('search-projects')}}" class="tk-btn-solid-lg tk-btn-yellow">{{$work_btn_txt}}<i class="icon-briefcase"></i></a></li>
                        <li><a href="{{route('search-sellers')}}" class="tk-btn-solid-white">{{$talent_btn_txt}} <i class="icon-user-check"></i></a></li>
                        <li class="tk-linestyle"><img src="{{asset('images/line.png')}}" alt="image"><span>{{$after_btn_text}}</span></li>
                    </ul>
                    @if(!empty($counter_option))
                        <ul id="tk-counter" class="tk-counter">
                            @foreach($counter_option as $option)
                                <li>
                                    <h4>{{$option['heading']}}</h4>
                                    <h6>{{$option['content']}}</h6>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="col-xl-5">
                <div class="tk-talents-search">
                    @if(!empty($form_title) || !empty($form_content))
                        <div class="tk-talents-search_title">
                            @if(!empty($form_title))<h4>{{$form_title}}</h4>@endif
                            @if(!empty($form_content))<p>{{$form_content}}</p>@endif
                        </div>
                    @endif
                    <div class="tk-talents-search_content">
                        <form class="tk-themeform">
                            <fieldset>
                                <div class="tk-themeform__wrap">
                                    <div class="form-group">
                                        <label class="tk-label">{{__('pages.looking_for_txt')}}</label>
                                        <div class="tk-inputicon">
                                            <i class="icon-search"></i>
                                            <input type="text" id="search_keyword" class="form-control" name="search" placeholder="Search with keyword" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="tk-label">{{__('pages.about_category_txt')}}</label>
                                        <div class="tk-select tk-selecthas-icon">
                                            <i class="icon-layers"></i>
                                            <select id="tk_category_opt" data-placeholderinput="{{__('general.search')}}" data-placeholder="{{__('pages.select_list_type')}}" class="form-control">
                                                <option label="{{__('pages.select_list_type')}}"></option>
                                                <option value="sellers">{{__('pages.seller_opt')}}</option>
                                                <option value="projects">{{__('pages.project_opt')}}</option>
                                                <option value="gigs">{{__('pages.gigs_opt')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="tk-label">{{__('pages.budget_range')}}</label>
                                        <div class="tk-rangeslider-wrapper">
                                            <div class="tk-distance">
                                                <div id="tk-rangeslider" class="tk-rangeslider-two"></div>
                                            </div>
                                            <div class="tk-rangevalue">
                                                <div class="tk-areasizebox">
                                                    <input id="tk_min_price_search" type="number" class="form-control" min="0" max="40" step="1" placeholder="{{__('pages.min_price')}}" id="tk-min-value" />
                                                    <input id="tk_max_price_search" type="number" class="form-control" step="1" placeholder="{{__('pages.max_price')}}" id="tk-max-value" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="tk-searchbtn">
                                            <a href="javascript:void(0)" onClick="searchCategory()" class="tk-btn-solid-lg tk-btn-yellow">{{__('pages.search_txt')}} <i class="icon-search"></i> </a>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@push('styles')
    @vite([
        'public/css/nouislider.min.css',
        'public/css/rangeslider.css', 
    ])
@endpush

@push('scripts')

    <script defer src="{{ asset('js/vendor/nouislider.min.js')}}"></script>
    <script defer src="{{ asset('common/js/select2.min.js')}}"></script>
    <script>
        
        document.addEventListener('livewire:load', function () {

            setTimeout(() => {
                $('#tk_category_opt').select2(
                    { allowClear: true, minimumResultsForSearch: -1 }
                );

                let params = {
                        range       :  [1, 100000],
                        min_price   : 1,
                        max_price   : 100000,
                        id1         : 'tk_min_price_search',
                        id2         : 'tk_max_price_search',
                    }
                inializePriceRange( params );
            }, 1000);
        });

        function searchCategory() {

            if ( history.pushState ) {

                let searchParams = new URLSearchParams(window.location.search);
                let categoryType        = $('#tk_category_opt').select2("val");
                let keyword             = jQuery('#search_keyword').val();
                let min_price           = jQuery('#tk_min_price_search').val();
                let max_price           = jQuery('#tk_max_price_search').val();
                let route               = '';
                let min_price_txt       = '';
                let max_price_txt       = '';
                if( categoryType == 'sellers' ){

                    route = "{{route('search-sellers')}}";
                    min_price_txt = 'seller_min_hr_rate';
                    max_price_txt = 'seller_max_hr_rate';
                }else if(categoryType == 'gigs'){

                    route = "{{route('search-gigs')}}";
                    min_price_txt = 'min_price';
                    max_price_txt = 'max_price';
                }else{
                    route = "{{route('search-projects')}}";
                    min_price_txt = 'project_min_price';
                    max_price_txt = 'project_max_price';
                }

                if( route != ''){
                    let URL = `${route}?${min_price_txt}=${min_price}&${max_price_txt}=${max_price}&keyword=${keyword}`;
                    location.href = URL;
                }
            }
        }
    </script>
@endpush