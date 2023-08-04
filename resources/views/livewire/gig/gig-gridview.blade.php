<div class="row" wire:init="loadGigs" wire:target="keyword" wire:loading.class="tk-section-preloader">
    <div class="col-lg-12">
        <div class="tk-sort">
            @if(!empty($gigs) && !EMPTY($keyword) )
                <h3 class="tk-search">{{ $gigs->count() .' '.  __('general.search_result') }} “{{ clean($keyword) }}”</h3>
            @endif
            
        </div>
    </div>
    @if(!empty($page_loaded))
        @if( !empty($gigs) && $gigs->count() > 0 )
            @foreach($gigs as $gig)
                <div id="gig_{{$gig->id}}" class="col-sm-12 col-md-6 col-lg-3">
                    <div class="tk-topservicetask">
                        <figure class="tk-card__img">
                            @php 
                                $percentage = 0;
                                $gig_image = 'images/default-img-286x186.png';
                                if(!empty($gig->attachments) ){
                                    $files  = unserialize($gig->attachments);
                                    $images = $files['files'];
                                    $latest = current($images);
                                    if( !empty($latest) && substr($latest->mime_type, 0, 5) == 'image'){
                                        if(!empty($latest->sizes['286x186'])){
                                            $gig_image = 'storage/'.$latest->sizes['286x186'];
                                        } elseif(!empty($latest->file_path)){
                                            $gig_image = 'storage/'.$latest->file_path;
                                        }
                                    }
                                }
                                if(!empty($gig->ratings_avg_rating)){
                                    $percentage = ($gig->ratings_avg_rating/5)*100;
                                }
                            @endphp

                            <a href="{{route('gig-detail',['slug' => $gig->slug])}}">
                                <img src="{{ asset($gig_image) }}" alt="{{ __('gig.alt_image') }}">
                            </a>
                        </figure>

                        @if($gig->is_featured)
                            <span class="tk-featuretag">{{__('general.featured')}}</span>
                        @endif

                        <div class="tk-sevicesinfo">
                            <div class="tk-topservicetask__content">
                                <div class="tk-title-wrapper">
                                    <div class="tk-card-title">
                                        <a href="{{route('seller-profile', ['slug' => $gig->gigAuthor->slug ])}}">
                                            {{$gig->gigAuthor->full_name}}
                                        </a>
                                        @if($gig->gigAuthor->user->userAccountSetting->verification == 'approved')
                                            <x-verified-tippy /> 
                                        @endif
                                        @if($roleName == 'buyer' || Auth::guest())
                                            <div class="tk-like {{in_array($gig->id, $fav_gigs) ? 'tk-heartsave' : '' }}">
                                                <a href="javascript:void(0);" class="tb_saved_items {{in_array($gig->id, $fav_gigs) ? 'tk-heartsave' : '' }}" wire:click.prevent="saveItem({{$gig->id}})">
                                                    <i class="icon-heart"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                    <h5><a href="{{route('gig-detail',['slug' => $gig->slug])}}">{{$gig->title}}</a></h5>
                                </div>
                                <div class="tk-featureRating">
                                    <div class="tk-featureRating tk-featureRatingv2">
                                        <span class="tk-featureRating__stars"><span style="width:{{$percentage}}%;"></span></span>
                                        <h6>{{ratingFormat($gig->ratings_avg_rating)}} <em>/5.0</em></h6>
                                        <em>( {{ $gig->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($gig->ratings_count)]) }} )</em>
                                    </div>
                                    @if(!empty($gig->address))
                                        <address>
                                            <i class="icon-map-pin"></i>{{ getUserAddress($gig->address, $address_format) }}
                                        </address>
                                    @endif
                                </div>
                                <div class="tk-startingprice">
                                    <i>{{__('gig.starting_from')}}</i>
                                    <span> {{getPriceFormat($currency_symbol, $gig->minimum_price)}} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-sm-12">
                {{ $gigs->links('pagination.custom') }}
            </div>
        @else
            <div class="col-sm-12">
                <div class="tk-submitreview">
                    <figure>
                        <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                    </figure>
                    <h4>{{ __('general.no_record') }}</h4>
                </div> 
            </div>
        @endif
    @else 
        <div class="tk-skelton-wrapper">
            <ul class="tk-services-skeleton tk-services-skeletonvtwo">
                @for($i=0; $i < 4; $i++ )
                    <li>
                        <div class="tk-skeletonarea">
                            <figure class="tk-skele"></figure>
                            <div class="tk-content-area">
                                <span class="tk-skeleton-title tk-skele"></span>
                                <span class="tk-skeleton-description tk-skele"></span>
                                <span class="tk-skeleton-paravtwo tk-skele"></span>
                                <span class="tk-skeleton-description tk-skele"></span>
                                <span class="tk-skeleton-description tk-skele"></span>
                            </div>
                        </div>
                    </li>
                @endfor
            </ul>
        </div>
    @endif
</div>
@push('scripts')
    <script defer src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            setTimeout(() => {
                iniliazeSelect2Scrollbar();
            }, 100);

            $(document).on('change','#tk_gig_type', function (e) {
                let sortBy = $('#tk_gig_type').select2("val");
                @this.set('sort_by', sortBy)
            });
        });
    </script>
@endpush