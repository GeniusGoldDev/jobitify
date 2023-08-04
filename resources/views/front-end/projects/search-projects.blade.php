@extends('layouts.app',['include_menu' => true])
@section('content')
<main class="tk-main-bg">
    <section class="tk-main-section tk-main-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tk-sort tk-searchproject">
                        <div class="tk-sortby">
                            <div class="tk-actionselect">
                                <span>{{ __('general.sort_by') }}: </span>
                                <div class="tk-select">
                                    <select id="order_by" data-hide_search_opt="true" class="form-control tk-selectprice tk-select2">
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
                                                <input type="text" value="{{$keyword}}" placeholder="{{ __('general.search_with_keyword') }}" id="search_by_keyword" class="form-control tk-themeinput">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tk-aside-holder">
                                <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#project_type-tab" role="button" aria-expanded="false">
                                    <h5>{{__('project.project_type')}}</h5>
                                </div>
                                <div id="project_type-tab" class="collapse">
                                    <div class="tk-aside-content">
                                        <div class="tk-actionselect">
                                            <div class="tk-select">
                                                <select id="project_type" data-placeholder="{{__('project.project_type')}}" data-hide_search_opt="true" class="form-control tk-select2">
                                                    <option label="{{__('project.project_type')}}"></option>
                                                    <option value="all"> {{ __('project.all_projects') }} </option>
                                                    <option value="fixed"> {{ __('project.fixed_type') }} </option>
                                                    <option value="hourly"> {{ __('project.hourly_type') }} </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tk-aside-holder">
                                <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#category-tab" role="button" aria-expanded="{{ !empty($category_id) ? 'true' : 'false' }}">
                                    <h5>{{__('category.text')}}</h5>
                                </div>
                                <div id="category-tab" class="collapse {{!empty($category_id) ? 'show' : '' }}">
                                    <div class="tk-aside-content">
                                        <div class="tk-filterselect">
                                            <input type="text" id="category_tree" autocomplete="off" placeholder="{{__('general.select')}}"/>
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
                                                                <input class="form-check-input tk-selectedskill tk-form-check-input-sm" type="checkbox" value="{{ $single->id }}" id="skill-{{ $single->id }}" />
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
                            @if(!$expertise_levels->isEmpty())
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#expertise_level-tab" role="button" aria-expanded="false">
                                        <h5>{{__('expert_levels.text')}}</h5>
                                    </div>
                                    <div id="expertise_level-tab" class="collapse">
                                        <div class="tk-aside-content">
                                            <div class="tk-filterselect mCustomScrollbar">
                                                <ul class="tk-categoriesfilter">
                                                    @foreach($expertise_levels as $single)
                                                        <li>
                                                            <div class="tk-form-checkbox">
                                                                <input class="form-check-input tk-expertlevel tk-form-check-input-sm" type="checkbox" value="{{ $single->id }}" id="expertise_level-{{ $single->id }}" />
                                                                <label class="form-check-label" for="expertise_level-{{ $single->id }}">
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
                                                                <input class="form-check-input tk-selectlang tk-form-check-input-sm" type="checkbox" value="{{ $single->id }}" id="languages-{{ $single->id }}" />
                                                                <label class="form-check-label" for="languages-{{ $single->id }}">
                                                                    <span> {{ $single->name }}</span>
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
                                <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#price_range-tab" role="button" aria-expanded="{{ !empty($search_by_price) ? 'true' : 'false' }}">
                                    <h5>{{ __('general.price_range') }}</h5>
                                </div>
                                <div id="price_range-tab" class="collapse {{ !empty($search_by_price) ? 'show' : ''}}">
                                    <div class="tk-aside-content">
                                        <div class="tk-rangevalue" data-bs-target="#rangecollapse" role="list" aria-expanded="{{!empty($search_by_price) ? 'true' : 'false'}}">
                                            <div class="tk-areasizebox">
                                                <input type="number" class="form-control"  min="{{ $project_min_price }}"  max="{{ $project_max_price }}" step="1" placeholder="{{ __('project.min_price') }}" id="project_min_price" />
                                                <input type="number" class="form-control" step="1"  placeholder="{{ __('project.max_price') }}" id="project_max_price" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tk-distanceholder">
                                        <div id="rangecollapse" class="collapse {{!empty($search_by_price) ? 'show' : ''}}">
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
                                                <select id="project_location" data-placeholderinput="{{ __('general.search') }}" data-placeholder="{{__('general.location_placeholder')}}" class="form-control tk-select2">
                                                    <option label="{{ __('general.location_placeholder') }}"></option>
                                                    @if(!$locations->isEmpty())
                                                        @foreach($locations as $single)
                                                            <option value="{{ $single->id }}">{{ $single->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="clearFilters" class="tk-filterbtns {{$filter_class}}">
                            <a href="javascript:;"  class="tk-btn-solid tk-advancebtn">{{ __('general.clear_all_filter') }} </a>
                        </div>
                        
                    </aside>
                </div>
                @php 
                $price_range = [ 
                    'min'   => $min_price,
                    'max'   => $max_price,
                ];
                @endphp
                <livewire:project.search-projects :price_range="$price_range" :keyword="$keyword" :category_id="$category_id" :project_min_price="$project_min_price" :project_max_price="$project_max_price" />
            </div>
        </div>
    </section>
</main>
@endsection('content')

@push('styles')
    @vite([
        'public/css/nouislider.min.css',
        'public/css/rangeslider.css', 
        'public/common/css/combotree.css', 
    ])
@endpush

@push('scripts')
    <script defer src="{{ asset('js/vendor/nouislider.min.js')}}"></script>
    <script defer src="{{ asset('common/js/select2.min.js')}}"></script>
    <script defer src="{{ asset('common/js/combotree.js')}}"></script>
    <script defer src="{{ asset('js/app.js') }}"></script>
    <script>
        window.onload = (event) => {
            var pageloaded          = false;
            var filter_record       = {}
            var categoryInstance    = null;
            var applyFilter         = true;
            
            jQuery(document).ready(function() {
                setTimeout(function() {
                    pageloaded = true;
                },1000);

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

                initDropDown();

                function initDropDown(){
                    if(categoryInstance != null){
                        categoryInstance.clearSelection();
                        categoryInstance.destroy();
                    }
                    
                    let settings = {
                        source : window.categories,
                        isMultiple: false
                    }
                    let category_id = window.category_id;
                    if(category_id){
                        settings['selected'] = [category_id.toString()]
                    }
                    categoryInstance = $('input[id="category_tree"]').comboTree(settings);
                }

                $(document).on('input', '#search_by_keyword', function(event){
                    filter_record['keyword'] =  event.target.value;
                    if(event.target.value.length){
                        $('#clearFilters').removeClass('d-none');
                    }else{
                        $('.tk-sort').find('h3').remove();
                    }
                    let timer;
                    clearTimeout(timer);
                    timer = setTimeout(()=>{
                        if(applyFilter){
                            applySearchFilter();
                        }
                    }, 800);
                });

                $(document).on('change', '#project_type', function (e) {
                    let project_type                = $('#project_type').select2("val");
                    filter_record['project_type']   =  project_type;
                    $('#clearFilters').removeClass('d-none');
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', '#order_by', function (e) {
                    let order_by                = $('#order_by').select2("val");
                    filter_record['order_by']   =  order_by;
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', '#project_location', function (e) {
                    let project_location                = $('#project_location').select2("val");
                    filter_record['project_location']   =  project_location;
                    $('#clearFilters').removeClass('d-none');
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', 'input[id^="category_tree"]', function(event){
                    if(categoryInstance){
                        let id = categoryInstance.getSelectedIds();
                        if(id && id.length){
                            filter_record['category'] = id[0];
                            $('#clearFilters').removeClass('d-none');
                        }
                        if(applyFilter){
                            applySearchFilter();
                        }
                    }
                });

                $(document).on('change', '.tk-selectedskill', function(event){
                    let skills = [];
                    $('input.tk-selectedskill:checkbox:checked').each(function(){
                        skills.push($(this).val());
                    });

                    filter_record['skills'] = skills;

                    if(skills.length){
                        $('#clearFilters').removeClass('d-none');
                    } else if( !Object.keys(filter_record).length ) {
                        $('#clearFilters').addClass('d-none');
                    }
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', '.tk-expertlevel', function(event){
                    let expertlevels = [];
                    $('input.tk-expertlevel:checkbox:checked').each(function(){
                        expertlevels.push($(this).val());
                    });

                    filter_record['expertlevels'] = expertlevels;

                    if(expertlevels.length){
                        $('#clearFilters').removeClass('d-none');
                    } else if( !Object.keys(filter_record).length ) {
                        $('#clearFilters').addClass('d-none');
                    }
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', '.tk-selectlang', function(event){
                    let languages = [];
                    $('input.tk-selectlang:checkbox:checked').each(function(){
                        languages.push($(this).val());
                    });

                    filter_record['languages'] = languages;

                    if(languages.length){
                        $('#clearFilters').removeClass('d-none');
                    } else if( !Object.keys(filter_record).length ) {
                        $('#clearFilters').addClass('d-none');
                    }
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', '#project_min_price, #project_max_price', function(event){
                    let minValue = Number( $('#project_min_price').val() );
                    let maxValue = Number( $('#project_max_price').val() );                   

                    if(pageloaded){
                        filter_record['pricerange'] = [
                            !isNaN(minValue) ? minValue : 1 ,
                            !isNaN(maxValue) ? maxValue : Number("{{$max_price}}") 
                        ];
                        $('#clearFilters').removeClass('d-none');
                        if(applyFilter){
                            applySearchFilter();
                        }
                    }
                });

                $(document).on('click', '#clearFilters', function(event) {
                    applyFilter = false;
                    $('.tk-sort').find('h3').remove();
                    let tabs = [
                        'location', 'price_range-tab', 
                        'skill-tab', 'project_type-tab', 
                        'languages-tab' 
                    ];
                    
                    tabs.map(tab =>{
                        $(`#${tab}`).removeClass('show');
                        $(`div[data-bs-target="#${tab}"]`).attr('aria-expanded', false)
                    });
                
                    $('#search_by_keyword').val("");
                    $('#project_type').val('').trigger('change');
                    $('#project_location').val('').trigger('change');
                    

                    $('input.tk-selectlang:checkbox').prop('checked', false);
                    $('input.tk-selectedskill:checkbox').prop('checked', false);
                    
                    let id = categoryInstance.getSelectedIds();
                    
                    if(id && id.length){
                        categoryInstance.clearSelection();
                    }

                    $('input.tk-expertlevel:checkbox').prop('checked', false);


                    let stepsSlider = document.getElementById('tk-rangeslider');
                    $('#project_min_price').val(function(i, val){
                        stepsSlider.noUiSlider.set([ Number("{{$min_price}}"), null]);
                        return 1;
                    }).trigger('input');

                    $('#project_max_price').val(function(i, val){
                        stepsSlider.noUiSlider.set([null, Number("{{$max_price}}")]);
                        return 100000;
                    }).trigger('input');

                    filter_record = {};
                    applySearchFilter();
                    applyFilter = true
                    $('#clearFilters').addClass('d-none');
                });
                
                let params = {
                    range       : [ Number("{{$min_price}}"), Number("{{$max_price}}") ],
                    min_price   : Number('{{$project_min_price}}'),
                    max_price   : Number('{{$project_max_price}}'),
                    id1         : 'project_min_price',
                    id2         : 'project_max_price',
                }

                inializePriceRange( params );
                iniliazeSelect2Scrollbar();

                function applySearchFilter(){
                    window.livewire.emit('ApplySearchFilter', filter_record);
                }
            });
        }

        
    </script>
@endpush
