<main class="tk-main-bg">
    <section class="tk-main-section" wire:loading.class="tk-section-preloader">
        <div class="preloader-outer" wire:loading>
            <div class="tk-preloader">
                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(!$gigs_orders->isEmpty() && $search_gig !='')<h3>{{ $gigs_orders->count() .' '.  __('general.search_result') }} “{{ $search_gig }}”</h3>@endif
                </div>
                <div class="col-xl-12">
                    <div class="tk-project-wrapper tk-template-project">
                        <div class="tk-template-serach ">
                            <h5> {{ $filter_gig != '' ? __('general.'.$filter_gig)  :  __('gig.all_orders') }} </h5>
                            <div class="tk-search-wrapper">
                                <div class="tk-inputicon">
                                    <input type="text" wire:model.debounce.500ms="search_gig" class="form-control" placeholder="{{ __('general.search_with_keyword') }}">
                                    <i class="icon-search"></i>
                                </div>
                                <div class="tk-sort">
                                    <div class="tk-sortby" wire:ignore>
                                        @php  
                                            $gig_statuses = [
                                                'all'       => __('gig.all_orders'),
                                                'hired'     => __('general.hired'),
                                                'completed' => __('general.completed'),
                                                'disputed'  => __('general.disputed'),
                                                'refunded'  => __('general.refunded'),
                                            ];
                                        @endphp
                                        <div class="tk-actionselect">
                                            <div class="tk-select">
                                                <select id="filter_gig" class="form-control tk-selectprice">
                                                    @foreach($gig_statuses as $key => $status)
                                                        <option value ="{{$key != 'all' ? $key : '' }}" {{ $filter_gig == $key ? 'selected' : '' }} > {{ $status }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if( !$gigs_orders->isEmpty() )
                        @foreach( $gigs_orders as $single )
                            @php
                                $tag = getTag( $single->status );
                            @endphp
                            <div class="tk-project-wrapper-two tk-gigorder">
                                <div class="tk-project-box">
                                    <div class=" tk-price-holder">
                                        <div class="tk-verified-info">
                                            <div class="tk-verified-info-tags">
                                                <span class="{{ $tag['class'] }}">{{ $tag['text'] }}</span>
                                            </div>
                                            @if($single->gig->is_featured)
                                                <x-featured-tippy />
                                            @endif
                                            <div class="tk-checkoutdetail">
                                                <h6>
                                                    @foreach($single->gig->categories as $cat )
                                                        <a href="{{ route('search-gigs', ['category_id' => $cat->category_id])}}">
                                                            {{ $cat->name}}
                                                        </a>
                                                    @endforeach
                                                </h6>
                                            </div>
                                            <h5><a href="{{ route('gig-activity', ['slug' => $single->gig->slug, 'order_id' => $single->id])}}" target="_blank">{{ $single->gig->title }}</a></h5>
                                        </div>
                                        <div class="tk-price">
                                            <span> {{ __('gig.order_budget') }}</span>
                                            <h4>{{ getPriceFormat($currency_symbol, $single->plan_amount) }}</h4>
                                        </div>
                                    </div>
                                    
                                   
                                    @if( !empty($single->ratings) )
                                         @php
                                            if( !empty($single->orderAuthor->image) ){
                                                $image_path     = getProfileImageURL( $single->orderAuthor->image, '50x50' );
                                                $buyer_image   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-50x50.png';
                                            }else{
                                                $buyer_image = '/images/default-user-50x50.png';
                                            }
                                            $rating_percentage = ($single->ratings->rating/5)*100;
                                        @endphp            
                                        <div class="tb-userfeedback">
                                            <img src="{{$buyer_image}}" alt="{{ $single->orderAuthor->full_name }}">
                                            <div class="tb-userfeedback__title">
                                                <div class="tb-featureRating tb-featureRatingv2">
                                                    <span class="tb-featureRating__stars "><span style="width:{{$rating_percentage}}%;"></span></span>
                                                    <h6>{{ number_format( $single->ratings->rating, 1 )}}</h6>
                                                    <a href="javascript:void(0);" wire:click.prevent="readReview({{$single->id}})" >({{ __('gig.view_feedback') }})</a>
                                                </div>
                                                <h6>{{ $single->orderAuthor->full_name }}</h6>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="tb-extras tb-extrascompleted">
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                @role('buyer')
                                                    @php
                                                        if( !empty($single->gig->gigAuthor->image) ){
                                                            $image_path     = getProfileImageURL( $single->gig->gigAuthor->image, '50x50' );
                                                            $seller_image   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-50x50.png';
                                                        }else{
                                                            $seller_image = '/images/default-user-50x50.png';
                                                        }
                                                    @endphp
                                                    <figure>
                                                        <img src="{{ asset($seller_image) }}" alt="{{$single->gig->gigAuthor->full_name }}" >
                                                    </figure>
                                                    <div class="tb-taskinfo">
                                                        <span>{{ __('gig.gig_by') }}</span>
                                                        <h6>{{ $single->gig->gigAuthor->full_name }}</h6>
                                                    </div>
                                                @endrole
                                                @role('seller')
                                                    @php
                                                        if( !empty($single->orderAuthor->image) ){
                                                            $image_path     = getProfileImageURL( $single->orderAuthor->image, '50x50' );
                                                            $buyer_image   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-50x50.png';
                                                        }else{
                                                            $buyer_image = '/images/default-user-50x50.png';
                                                        }
                                                    @endphp  
                                                    <figure>
                                                        <img src="{{ asset($buyer_image) }}" alt="{{$single->orderAuthor->full_name }}" >
                                                    </figure>
                                                    <div class="tb-taskinfo">
                                                        @role('seller')
                                                            <span>{{ __('gig.order_by') }}</span>
                                                            <h6>{{ $single->orderAuthor->full_name }}</h6>
                                                        @endrole
                                                    </div>
                                                @endrole
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span>{{ __('gig.start_date') }}</span>
                                                    <h6>{{ date('M d, Y',  strtotime($single->gig_start_time))}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span>{{ __('gig.deadline') }}</span>
                                                    <h6>{{ date('M d, Y', strtotime('+'.$single->gig_delivery_days.'days', strtotime($single->gig_start_time))) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span>{{ __('gig.additional_addons') }}</span>
                                                    @php
                                                        $gig_addons = 0;
                                                        if( !empty($single->gig_addons) ){
                                                            $gig_addons = count(unserialize($single->gig_addons));
                                                        }
                                                    @endphp
                                                    <h6>{{ $gig_addons }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span>{{ __('gig.plan_type') }}</span>
                                                    <h6>{{ $single->plan_type }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        @if( !empty($single->downloadable) && in_array( $single->status, array('completed', 'hired')))
                                            <div class="tb-tabitemextras">
                                                <div class="tb-tabitemextrasinfo">
                                                    <div class="tb-taskinfo">
                                                        <span>{{ __('gig.downloadable') }}</span>
                                                        <a href="javascript:;" wire:click.prevent="downloadAttachments({{ $single->id }})">
                                                            <span class="icon-download"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                    @else
                        <div class="tk-submitreview">
                            <figure>
                                <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                            </figure>
                            <h4>{{ __('general.no_record') }}</h4>
                        </div>
                    @endif
                </div>
                @if(!$gigs_orders->isEmpty())
                    <div class="col-sm-12">
                        {{ $gigs_orders->links('pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </section>
    <div class="modal fade tb-excfreelancerpopup" id="tk_read_review" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content" id="tb_tk_viewrating">
                <div class="tb-popuptitle">
                    <h4>{{$review_detail['gig_title']}}</h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <div class="tb-excfreelancerpopup__content">
                        <figure class="tb-ratinguserimg">
                            <img src="{{$review_detail['image']}}" alt="{{$review_detail['user_name']}}">
                        </figure>
                        <div class="tb-featureRating tb-featureRatingv2">
                            <span class="tb-featureRating__stars"><span style="width:{{$review_detail['avg_rating'].'%'}}" ></span></span>
                            <h6> {{number_format((float)$review_detail['rating'], 1, '.', '')}}</h6>
                        </div>
                        <h2>{{$review_detail['rating_title']}}</h2>
                        @if( $review_detail['rating_desc'] )
                            <p>{{ $review_detail['rating_desc']}} </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script defer src="{{ asset('common/js/select2.min.js')}}"></script>
<script defer src="{{ asset('js/app.js') }}"></script>
<script>
    document.addEventListener('livewire:load', function () {

        window.addEventListener('ReadReviewPopup', event => { 
            jQuery('#tk_read_review').modal(event.detail);
        });

        setTimeout(function() {
            $('#filter_gig').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_gig').on('change', function (e) {
                let filter_gig = $('#filter_gig').select2("val");
                @this.set('filter_gig', filter_gig);
            });

            iniliazeSelect2Scrollbar();
        }, 50);
    });

</script>
@endpush