@extends('layouts.app', ['include_menu' => true])
@section('content')
    <main class="tk-main-bg">
        <section class="tk-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tk-sort">
                            <div class="tk-sortby">
                                <div class="tk-actionselect">
                                    <span>{{ __('general.sort_by') }}: </span>
                                    <div class="tk-select">
                                        <select id="sort_by" data-hide_search_opt="true" class="form-control tk-select2">
                                            <option value="date_desc"> {{ __('general.date_desc') }} </option>
                                            <option value="price_asc"> {{ __('general.price_asc') }} </option>
                                            <option value="price_desc"> {{ __('general.price_desc') }} </option>
                                            <option value="visits_desc"> {{ __('general.visits_desc') }} </option>
                                            <option value="order_desc"> {{ __('general.order_desc') }} </option>
                                        </select>
                                    </div>
                                    <a href="javascript:void(0);" class="tk-filtermenu"><i class="icon-sliders"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <aside class="tk-searchfilter">
                            <a href="javascript:void(0);" class="tk-closefilter"><i class="icon-x"></i></a>
                            <div class="tk-searchfilter-wrap">
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#search-tab" role="button" aria-expanded="true">
                                        <h5>{{__('general.search')}}</h5>
                                    </div>
                                    <div id="search-tab" class="collapse show">
                                        <div class="tk-aside-content">
                                            <div class="tk-inputiconbtn">
                                                <div class="tk-placeholderholder">
                                                    <input type="text" id="search_by_title" value="{{request()->get('keyword') }}" placeholder="{{ __('general.search_with_keyword') }}" class="form-control tk-themeinput">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#category-tab" role="button" aria-expanded="{{!empty($selected_category) ? 'true' : 'false'}}">
                                        <h5>{{__('category.text')}}</h5>
                                    </div>
                                    <div id="category-tab" class="collapse {{!empty($selected_category) ? 'show' : ''}}">
                                        <div class="tk-aside-content">
                                            <div class="tk-filterselect">
                                                <div class="tk-select">
                                                    <select id="gig_category" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('pages.select_category')}}" class="form-control tk-select2">
                                                        <option label="{{__('pages.select_category')}}"></option>
                                                        @foreach($categories as $key => $category)
                                                            <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#price_range-tab" role="button" aria-expanded="{{!empty($min_price) && !empty($max_price) ? 'true' : 'false'}}">
                                        <h5>{{ __('general.price_range') }}</h5>
                                    </div>
                                    <div id="price_range-tab" class="collapse {{ !empty($min_price) && !empty($max_price) ? 'show' : ''}}">
                                        <div class="tk-aside-content">
                                            <div class="tk-rangevalue" data-bs-target="#rangecollapse" role="list" aria-expanded="false">
                                                <div class="tk-areasizebox">
                                                    <input type="number" class="form-control" min="1"   max="600" step="1" placeholder="{{ __('general.seller_min_hr_rate') }}" id="gig_min_price_search" />
                                                    <input type="number" class="form-control" step="1"  placeholder="{{ __('general.seller_max_hr_rate') }}" id="gig_max_price_search" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tk-distanceholder">
                                            <div id="rangecollapse" class="collapse show">
                                                <div class="tk-distance">
                                                    <div id="tk-rangeslider" class="tk-tooltiparrow tk-rangeslider"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-aside-holder location-tab">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse"  data-bs-target="#location" role="button" aria-expanded="false">
                                        <h5>{{ __('general.location') }}</h5>
                                    </div>
                                    <div id="location" class="collapse">
                                        <div class="tk-aside-content">
                                            <div class="tk-filterselect">
                                                <div class="tk-select">
                                                    <select id="gig_location" data-placeholderinput="{{ __('general.search') }}" data-placeholder="{{__('general.location_placeholder')}}" class="form-control tk-select2">
                                                        <option label="{{ __('general.location_placeholder') }}"></option>
                                                        @if(!$locations->isEmpty())
                                                            @foreach($locations as $single)
                                                                <option value="{{ $single->name }}" >{{ $single->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="clearFilters" class="tk-filterbtns {{ empty($selected_category) ? 'd-none' : ''}}">
                                <a href="javascript:;" class="tk-btn-solid tk-advancebtn">{{ __('general.clear_all_filter') }} </a>
                            </div>
                        </aside>
                    </div>
                    <livewire:gig.search-gigs :view_type="$view" :selected_category="$selected_category" /> 
                </div>
            </div>
        </section>
    </main>
@endsection('content')

@push('styles')
    @vite([
        'public/css/nouislider.min.css',
        'public/css/rangeslider.css', 
    ])
@endpush

@push('scripts')
    <script defer src="{{ asset('js/vendor/nouislider.min.js')}}"></script>
    <script defer src="{{ asset('common/js/select2.min.js')}}"></script>
    <script defer src="{{ asset('js/app.js') }}"></script>
    <script>
        window.onload = (event) => {
            var loadedpage = false;
            let query_string = window.location.search;
            let urlParams = new URLSearchParams(query_string);
            let min_price = urlParams.get('min_price');
            let max_price = urlParams.get('max_price');
            jQuery(document).ready(function() {
                setTimeout(function() {
                    iniliazeSelect2Scrollbar();
                    let category_id = '{{$selected_category}}';
                    if(category_id.length){
                        $('#gig_category').val('{{$selected_category}}').trigger('change');
                    }
                    let params = {
                        range       :  [1, 100000],
                        min_price   : min_price > 0 ? min_price : 1,
                        max_price   : max_price > 0 ? max_price : 100000,
                        id1         : 'gig_min_price_search',
                        id2         : 'gig_max_price_search',
                    }
                    inializePriceRange( params );
                }, 100);

                $(document).on('input', '#search_by_title', function(event){
                    let data = {
                        'type' : 'keyword',
                        'keyword' : event.target.value
                    };
                    if(event.target.value.length){
                        $('#clearFilters').removeClass('d-none');
                    }
                    let timer;
                    clearTimeout(timer);
                    timer = setTimeout(()=>{
                        applySearchFilter(data);
                    }, 800);
                });

            
                $('#sort_by').on('change', function (e) {
                    let sortBy = $('#sort_by').select2("val");
                    let data = {
                        'type'     : 'sortby',
                        'sort_by'  : sortBy,
                    };
                    applySearchFilter(data);
                });

                $(document).on('click','#clearFilters', function (e) {

                    let data = {
                        'type'      : 'clearfilter',
                    };

                    $('#search_by_title').val('');
                    $("#gig_category").val("").trigger('change');
                    $("#gig_location").val("").trigger('change');

                    let stepsSlider = document.getElementById('tk-rangeslider');
                    $('#gig_min_price_search').val(function(i, val){
                        stepsSlider.noUiSlider.set([1, null]);
                        return 1;
                    }).trigger('input');
                    $('#gig_max_price_search').val(function(i, val){
                        stepsSlider.noUiSlider.set([null, 100000]);
                        return 100000;
                    }).trigger('input');

                    $('#clearFilters').addClass('d-none');
                    applySearchFilter(data);
                });

                $('#gig_category').on('change', function (e) {
                    let category_id = $('#gig_category').select2("val");
                    let data = {
                        'type'      : 'category',
                        'category'  : category_id,
                    };
                    if(category_id){
                        $('#clearFilters').removeClass('d-none');
                    }
                    applySearchFilter(data);
                });

                $('#gig_location').on('change', function (e) {
                    let country_name = $('#gig_location').select2("val");
                    let data = {
                        'type'      : 'location',
                        'location'  : country_name,
                    };
                    applySearchFilter(data);
                    if(country_name){
                        $('#clearFilters').removeClass('d-none');
                    }
                });

                $(document).on('change', '#gig_min_price_search, #gig_max_price_search', function(event){
                    let minValue = $('#gig_min_price_search').val();
                    let maxValue = $('#gig_max_price_search').val();
                    let data = {
                        'type'      : 'pricerange',
                        'min_price' : minValue,
                        'max_price' : maxValue,
                    };
                    
                    if(loadedpage){
                        $('#clearFilters').removeClass('d-none');
                        applySearchFilter(data);
                    }
                });
                setTimeout(function() {
                    loadedpage = true;
                },2000);
            });
        };
    
        function applySearchFilter(data){
            window.livewire.emit('ApplySearchFilter', data);
        }

    </script>
@endpush