@props(['gig','fav_gigs', 'currency_symbol','is_save_item', 'user_role', 'address_format' => 'city_state_country'])

<li id="gig_{{$gig->id}}" class="tk-tabbitem">
    <div class="tk-tabbitem__list tk-tabbitem__listtwo">
        <div class="tk-deatlswithimg">
            <figure>
                @php 
                    $gig_image  = 'images/default-img-82x82.png';

                    if(!empty($gig->attachments) ){
                        $files  = unserialize($gig->attachments);
                        $images = $files['files'];
                        $latest = current($images);
                        if( !empty($latest) && substr($latest->mime_type, 0, 5) == 'image'){
                            if(!empty($latest->sizes['82x82'])){
                                $gig_image = 'storage/'.$latest->sizes['82x82'];
                            } elseif(!empty($latest->file_path)){
                                $gig_image = 'storage/'.$latest->file_path;
                            }
                        }
                    }

                    $status = getTag($gig->status);
                    
                @endphp
                <img src="{{ asset($gig_image) }}" alt="{{ __('gig.alt_image') }}" >
            </figure>
            <div class="tk-icondetails">
                <div class="tk-verified-info">
                    <strong>
                    <a href="{{route('seller-profile', ['slug' => $gig->gigAuthor->slug ])}}">
                        {{$gig->gigAuthor->full_name}}
                    </a>
                    @if($gig->gigAuthor->user->userAccountSetting->verification == 'approved')
                        <x-verified-tippy /> 
                    @endif
                    </strong>
                </div>

                <h6>
                    <a href="{{route('gig-detail',['slug' => $gig->slug])}}">{{$gig->title}}</a>
                </h6>
                <ul class="tk-rateviews tk-rateviews2">
                    <li>
                        <i class="fa fa-star tk-yellow"></i> 
                        <em> {{ratingFormat($gig->ratings_avg_rating)}} </em> 
                        <span>({{ $gig->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($gig->ratings_count)]) }} ) </span>
                    </li>
                    <li>
                        <i class="icon-eye"></i> 
                        <span> 
                            {{ $gig->gig_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format( $gig->gig_visits_count) ] ) }}
                        </span>
                    </li> 
                    @if($user_role == 'buyer' || Auth::guest())
                        <li>
                            <span class="tk-save-btn tk-fav-item {{in_array($gig->id, $fav_gigs) || $is_save_item ? 'tk-favourite' : '' }}" wire:click.prevent="saveItem({{$gig->id}})">
                                <i class="icon-heart"></i> 
                                <em>{{in_array($gig->id, $fav_gigs) || $is_save_item ? __('general.saved') : __('general.save')}}</em>
                            </span>
                        </li>
                    @endif
                    @if(!empty($gig->address))
                        <li>
                            <i class="icon-map-pin"></i>
                            <span>{{ getUserAddress($gig->address, $address_format) }}</address>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="tk-itemlinks tk-itemlinksvtwo">
            <div class="tk-startingprice">
                <i>{{__('gig.starting_from')}}</i>
                <span>{{getPriceFormat($currency_symbol, $gig->minimum_price)}}</span>
            </div>
            <ul class="tk-tabicon">
                <li>
                    <a href="{{route('gig-detail',['slug' => $gig->slug])}}">
                        <span class="icon-external-link bg-gray"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</li>