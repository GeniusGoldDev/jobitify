@extends('layouts.app',['include_menu' => true])
@section('content')
    <main class="tk-main-bg"> 
        <section class="tk-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tk-sort">
                            <div class="tk-sortby tk-sorttalent">
                                <div class="tk-actionselect">
                                    <span>{{ __('general.sort_by') }}: </span>
                                    <div class="tk-select">
                                        <select id="order_by" data-hide_search_opt="true" class="form-control tk-select2 tk-selectprice">
                                            <option value ="date_desc"> {{ __('general.date_desc') }} </option>
                                            <option value ="price_asc"> {{ __('general.price_asc') }} </option>
                                            <option value ="price_desc"> {{ __('general.price_desc') }} </option>
                                            <option value ="visits_desc"> {{ __('general.visits_desc') }} </option>
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
                                                    <input type="text" placeholder="{{ __('general.search_with_keyword') }}" id="search_by_keyword" value="{{clean( $keyword )}}" class="form-control tk-themeinput">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!$skills->isEmpty())
                                    <div class="tk-aside-holder">
                                        <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#skill-tab" role="button" aria-expanded="false">
                                            <h5>{{__('skill.text')}}</h5>
                                        </div>
                                        <div id="skill-tab" class="collapse">
                                            <div class="tk-aside-content">
                                                <div class="tk-filterselect mCustomScrollbar">
                                                    <ul class="tk-categoriesfilter">
                                                        @foreach($skills as $single)
                                                            <li>
                                                                <div class="tk-form-checkbox">
                                                                    <input class="form-check-input tk-form-check-input-sm tk-select-skill" type="checkbox" value="{{ $single->id }}" id="skill-{{ $single->id }}" />
                                                                    <label class="form-check-label" for="skill-{{ $single->id }}">
                                                                        <span> {!! $single->name !!}</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($seller_types))
                                    <div class="tk-aside-holder">
                                        <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#seller_types-tab" role="button" aria-expanded="false">
                                            <h5>{{__('general.seller_type')}}</h5>
                                        </div>
                                        <div id="seller_types-tab" class="collapse">
                                            <div class="tk-aside-content">
                                                <div class="tk-filterselect mCustomScrollbar">
                                                    <ul class="tk-categoriesfilter">
                                                        @foreach($seller_types as $type_key => $sellerType)
                                                            <li>
                                                                <div class="tk-form-checkbox">
                                                                    <input class="form-check-input tk-form-check-input-sm tk-seller-type" type="checkbox" value="{{ $sellerType }}" id="seller_types-{{ $type_key }}" />
                                                                    <label class="form-check-label" for="seller_types-{{ $type_key }}">
                                                                        <span> {!! $sellerType !!}</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#english_level-tab" role="button" aria-expanded="false">
                                        <h5>{{__('general.english_level')}}</h5>
                                    </div>
                                    <div id="english_level-tab" class="collapse">
                                        <div class="tk-aside-content">
                                            <div class="tk-filterselect mCustomScrollbar">
                                                <ul class="tk-categoriesfilter">
                                                    @foreach($english_levels as $key => $eng_level)
                                                        <li>
                                                            <div class="tk-form-checkbox">
                                                                <input class="form-check-input tk-form-check-input-sm tk-english-level" type="checkbox" value="basic" id="english_level-{{$key}}" />
                                                                <label class="form-check-label" for="english_level-{{$key}}">
                                                                    <span> {{ $eng_level }} </span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if(!$languages->isEmpty())
                                    <div class="tk-aside-holder">
                                        <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#languages-tab" role="button" aria-expanded="false">
                                            <h5>{{__('languages.text')}}</h5>
                                        </div>
                                        <div id="languages-tab" class="collapse">
                                            <div class="tk-aside-content">
                                                <div class="tk-filterselect mCustomScrollbar">
                                                    <ul class="tk-categoriesfilter">
                                                        @foreach($languages as $single)
                                                            <li>
                                                                <div class="tk-form-checkbox">
                                                                    <input class="form-check-input tk-form-check-input-sm tk-language-select" type="checkbox" value="{{ $single->id }}" id="languages-{{ $single->id }}" />
                                                                    <label class="form-check-label" for="languages-{{ $single->id }}">
                                                                        <span> {!! $single->name !!}</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#price_range-tab" role="button" aria-expanded="{{!empty($search_by_hr_rate) ? 'true' : 'false'}}">
                                        <h5>{{ __('general.price_range') }}</h5>
                                    </div>
                                    <div id="price_range-tab" class="collapse {{ !empty($search_by_hr_rate) ? 'show' : ''}}">
                                        <div class="tk-aside-content">
                                            <div class="tk-rangevalue" data-bs-target="#rangecollapse" role="list" aria-expanded="{{!empty($search_by_hr_rate) ? 'true' : 'false'}}">
                                                <div class="tk-areasizebox">
                                                    <input type="number" class="form-control"  min="{{ $seller_min_hr_rate }}" max="{{ $seller_max_hr_rate }}" step="1" placeholder="{{ __('general.seller_min_hr_rate') }}" id="seller_min_hr_rate" />
                                                    <input type="number" class="form-control" step="1"  placeholder="{{ __('general.seller_max_hr_rate') }}" id="seller_max_hr_rate" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tk-distanceholder">
                                            <div id="rangecollapse" class="collapse">
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
                                                    <select id="seller_location" data-placeholderinput="{{ __('general.search') }}" data-placeholder="{{__('general.location_placeholder')}}" class="form-control tk-select2">
                                                        <option label="{{ __('general.location_placeholder') }}"></option>
                                                        @if(!$locations->isEmpty())
                                                            @foreach($locations as $single)
                                                                <option value="{{ $single->id }}" >{{ $single->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="clearFilters" class="tk-filterbtns d-none">
                                <a href="javascript:;"  class="tk-btn-solid tk-advancebtn">{{ __('general.clear_all_filter') }} </a>
                            </div>
                        </aside>
                    </div>
                    <livewire:components.search-sellers 
                        :per_page="$per_page" 
                        :currency_symbol="$currency_symbol" 
                        :date_format="$date_format" 
                        :seller_min_hr_rate="$seller_min_hr_rate" 
                        :seller_max_hr_rate="$seller_max_hr_rate" 
                        :keyword="$keyword"
                        :address_format="$address_format"
                        />
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
            var pageloaded = false;
            jQuery(document).ready(function() {
                window.addEventListener('totalFoundResult', event => {
                    let total   = event.detail.total_count;
                    let keyword = event.detail.keyword;

                    if(!keyword.length){
                        $('.tk-sort').find('h3').remove();
                    } else if($('.tk-sort').find('h3').length){
                        $('.tk-sort').find('h3').html(`${total} {{ __('general.search_result')}} “${keyword}”`);
                    }else {
                        $('.tk-sort').prepend(`<h3>${total} {{ __('general.search_result')}} “${keyword}”</h3>`);
                    }
                });
                setTimeout(function() {

                    setTimeout(function() {
                        pageloaded = true;
                    },1000);
                    
                    $(document).on('input', '#search_by_keyword', function(event){
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

                    $(document).on('change', '.tk-select-skill', function(event){
                        let values = [];
                        $('input.tk-select-skill:checkbox:checked').each(function(){
                            values.push($(this).val());
                        });

                        let data = {
                            'type' : 'skills',
                            'skills' : values
                        };

                        if(values.length){
                            $('#clearFilters').removeClass('d-none');
                        } else {
                            $('#clearFilters').addClass('d-none');
                        }
                        applySearchFilter(data);
                    });

                    $(document).on('change', '.tk-seller-type', function(event){
                        let values = [];
                        $('input.tk-seller-type:checkbox:checked').each(function(){
                            values.push($(this).val());
                        });

                        let data = {
                            'type' : 'seller_type',
                            'seller_types' : values
                        };

                        if(values.length){
                            $('#clearFilters').removeClass('d-none');
                        } else {
                            $('#clearFilters').addClass('d-none');
                        }
                        applySearchFilter(data);
                    });

                    $(document).on('change', '.tk-english-level', function(event){
                        let values = [];
                        $('input.tk-english-level:checkbox:checked').each(function(){
                            values.push($(this).val());
                        });

                        let data = {
                            'type' : 'english_level',
                            'english_levels' : values
                        };

                        if(values.length){
                            $('#clearFilters').removeClass('d-none');
                        } else {
                            $('#clearFilters').addClass('d-none');
                        }
                        applySearchFilter(data);
                    });

                    $(document).on('change', '.tk-language-select', function(event){
                        let languages = [];
                        $('input.tk-language-select:checkbox:checked').each(function(){
                            languages.push($(this).val());
                        });

                        let data = {
                            'type' : 'languages',
                            'languages' : languages
                        };

                        if(languages.length){
                            $('#clearFilters').removeClass('d-none');
                        } else {
                            $('#clearFilters').addClass('d-none');
                        }
                        applySearchFilter(data);
                    });

                    $(document).on('change', '#seller_min_hr_rate, #seller_max_hr_rate', function(event){

                        let minValue = $('#seller_min_hr_rate').val();
                        let maxValue = $('#seller_max_hr_rate').val();
                        let data = {
                            'type'      : 'pricerange',
                            'min_price' : minValue,
                            'max_price' : maxValue,
                        };
                        
                        if(pageloaded){
                            $('#clearFilters').removeClass('d-none');
                            applySearchFilter(data);
                        }
                    });

                    $('#order_by').on('change', function (e) {
                        let order_by = $('#order_by').select2("val");

                        let data = {
                            'type'      : 'orderby',
                            'orderby'  : order_by,
                        };
                        applySearchFilter(data);
                        
                    });

                    $('#seller_location').on('change', function (e) {
                        let selected_location = $('#seller_location').select2("val");
                        let data = {
                            'type'      : 'location',
                            'location'  : selected_location,
                        };
                        applySearchFilter(data);
                        if(selected_location){
                            $('#clearFilters').removeClass('d-none');
                        }
                    });

                    $(document).on('click', '#clearFilters', function(event) {
                        let tabs = [
                            'location', 'price_range-tab', 
                            'skill-tab', 'seller_types-tab', 
                            'english_level-tab', 'languages-tab' 
                        ];
                        
                        tabs.map(tab =>{
                            $(`#${tab}`).removeClass('show');
                            $(`div[data-bs-target="#${tab}"]`).attr('aria-expanded', false)
                        });
                    
                        $('#search_by_keyword').val("");
                        $('input.tk-language-select:checkbox').prop('checked', false);
                        $('input.tk-select-skill:checkbox').prop('checked', false);
                        $('input.tk-seller-type:checkbox').prop('checked', false);
                        $('input.tk-english-level:checkbox').prop('checked', false);
                        $('input.tk-language-select:checkbox').prop('checked', false);
                        $('#seller_min_hr_rate').val("{{$seller_min_hr_rate}}").trigger('change');
                        $('#seller_max_hr_rate').val("{{$seller_max_hr_rate}}").trigger('change');
                        $('#seller_location').val('').trigger('change');

                        let data = { 'type' : 'clear_filter'};
                        applySearchFilter(data);
                        $('#clearFilters').addClass('d-none');
                    });

                    let min_hr_rate = Number('{{$seller_min_hr_rate}}');
                    let max_hr_rate = Number('{{$seller_max_hr_rate}}');

                    let params = {
                        range       :  [min_hr_rate, max_hr_rate],
                        min_price   : '{{$seller_min_hr_rate}}',
                        max_price   : '{{$seller_max_hr_rate}}',
                        id1         : 'seller_min_hr_rate',
                        id2         : 'seller_max_hr_rate',
                    }
                   
                    inializePriceRange( params );

                    iniliazeSelect2Scrollbar();
                }, 100);
            });
        }
        
        function applySearchFilter(data){
            window.livewire.emit('ApplySearchFilter', data);
        }

    </script>
@endpush
