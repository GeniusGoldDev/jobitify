@extends('layouts.app', ['include_menu' => true])
@section('content')
<main class="tk-bg">
	<section class="tk-main-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<form class="tk-formsearch tk-formsearchvtwo">
						<fieldset>
							<div class="tk-taskform">
								<div class="tk-inputicon">
									<i class="icon-search"></i>
                                    <div class="tk-aside-content">
                                        <div class="tk-inputiconbtn">
                                            <div class="tk-placeholderholder">
                                                <input type="text" class="form-control" id="search_by_keyword" value="{{request()->get('keyword') }}" placeholder="{{ __('general.search_with_keyword') }}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
								</div>
								<div class="tk-select tk-inputicon">
									<i class="icon-layers"></i>
									<select id="gig_category" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('pages.select_category')}}" class="form-control tk-select2">
										<option label="{{__('pages.select_category')}}"></option>
										@foreach($categories as $key => $category)
											<option value="{{ $category->id }}" >{{ $category->name }}</option>
										@endforeach
									</select>
								</div>
                                <div wire:ignore class="tk-select tk-inputicon">
                                    <i class="icon-filter"></i>
                                    <select id="tk_gig_type" data-hide_search_opt="true" class="form-control tk-selectprice tk-select2">
                                        <option value="date_desc"> {{ __('general.date_desc') }} </option>
                                        <option value="price_asc"> {{ __('general.price_asc') }} </option>
                                        <option value="price_desc"> {{ __('general.price_desc') }} </option>
                                        <option value="visits_desc"> {{ __('general.visits_desc') }} </option>
                                        <option value="order_desc"> {{ __('general.order_desc') }} </option>
                                    </select>
                                </div>
								<div class="tk-inputappend_right">
									<a class="tk-advancebtn tk-btn-solid-lg">
										<span class="icon-sliders"></span>
									</a>
								</div>
							</div>
						</fieldset>
						<div class="tk-advancesearch">
							<div class="tk-searchbar">
								<div class="form-group-wrap">
									<div class="tk-pricerange">
										<h6>{{__('general.price_range')}}</h6>
                                        <div class="tk-rangevalue">
                                            <div class="tk-areasizebox">
                                                <div class="form-group form-group-half">
                                                    <input type="number" class="form-control" placeholder="{{__('general.min_price')}}" id="gig_min_price_search">
                                                </div>
                                                <div class="form-group form-group-half">
                                                    <input type="number" class="form-control" placeholder="{{__('general.max_price')}}" id="gig_max_price_search">
                                                </div>
                                            </div>
                                            <div class="tk-distanceholder">
                                                <div id="rangecollapse" class="collapse">
                                                    <div id="tk-rangeslider" class="tk-tooltiparrow tk-rangeslider"></div>
                                                </div>
                                            </div>
                                        </div>
									</div>
									<div class="form-group">
										<h6>{{ __('general.location') }}</h6>
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
							<div class="tk-searchbar {{ empty($selected_category) ? 'd-none' : ''}}" id="clearFilters">
                                <div class="tk-btnarea">
                                    <a href="javascript:void(0);" class="tk-advancebtn tk-btn-solid-lg tk-clear_filter">{{ __('general.clear_all_filter') }}</a>
                                </div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<livewire:gig.search-gigs :view_type="$view" :selected_category="$selected_category"/> 
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
            
                $('#sort_by').on('change', function (e) {
                    let sortBy = $('#sort_by').select2("val");
                    let data = {
                        'type'     : 'sortby',
                        'sort_by'  : sortBy,
                    };
                    applySearchFilter(data);
                });

                $(document).on('click','#clearFilters .tk-clear_filter', function (e) {

                    let data = {
                        'type'      : 'clearfilter',
                    };

                    $('#search_by_keyword').val('');
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
        jQuery(window).on("load",function(){
            jQuery(document).on("click",".tk-advancebtn",function(){
                jQuery('.tk-advancesearch').slideToggle(300);
            })
        })
    </script>
@endpush