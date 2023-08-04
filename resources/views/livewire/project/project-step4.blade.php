<div class="row">
    @include('livewire.project.project-creation-sidebar')
    <div class="col-lg-9">
        <div class="tk-sort">
            <h3>{{ __('project.recommended_freelancer') }} </h3>
        </div>
        @if(!$freelancers->isEmpty())
            <ul class="tk-freelancers-list">
                @foreach($freelancers as $single)
                    @php
                        $fav_class = '';
                        $_text = __('project.save');
                      
                        if(in_array($single->id, $favourite_sellers)){
                             $fav_class =  'bg-redheart tk-liked';
                             $_text =  __('project.saved');
                        }
                        if(!empty($single->image)){
                            $image_path     = getProfileImageURL($single->image, '100x100');
                            $seller_image   = !empty($image_path) ? 'storage/'.$image_path : 'images/default-user-100x100.png';
                        }else{
                            $seller_image   = 'images/default-user-100x100.png';
                        }
                    @endphp
                    <li>
                        <div class="tk-freelancers-info">
                            <figure>
                                <img src="{{ asset($seller_image) }}" alt="{{ $single->full_name }}">
                            </figure>
                            <div class="tk-freelancer-user">
                                <a target="_blank" href="{{ route('seller-profile', ['slug' => $single->slug] ) }}">{{$single->full_name }}</a>
                                <h5> {!! $single->tagline  !!} </h5>
                                <ul class="tk-blogviewdatessm">
                                    <li>
                                        <i class="fas fa-star tk-yellow"></i>
                                        <em> {{ ratingFormat( $single->ratings_avg_rating ) }}  </em>
                                        <span>( {{ $single->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($single->ratings_count) ]) }} )</span>

                                    </li>
                                    <li>
                                        <span>
                                            <i class="icon-eye"></i> 
                                            <em>
                                                {{ $single->profile_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format($single->profile_visits_count) ] ) }}
                                            </em> 
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            <a href="javascript:void(0)" class="{{ $fav_class }}" wire:click="favouriteSeller({{$single->id}})"><i class="icon-heart"></i> {{ $_text}} </a>    
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-bidbtn">
                            <a target="_blank" href="{{ route('seller-profile', ['slug' => $single->slug] ) }}">{{__('project.view_profile')}}</a>
                            @if( in_array($single->id, $invited_sellers) )
                                <a href="javascript:void(0)" disabled class="tk-invite-bidbtn">{{__('project.invited')}}</a>
                            @else 
                                <a href="javascript:void(0)" wire:click="inviteSeller({{$single->id}})" class="tk-invite-bidbtn">{{__('project.invite_bid')}}</a>   
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
            {{ $freelancers->links('pagination.custom') }}
        @else
            <div class="tk-submitreview">
                <figure>
                    <img src="{{ asset('images/empty.png') }}" alt="{{ __('general.no_record') }}">
                </figure>
                <h4>{{ __('general.no_record') }}</h4>
            </div>
        @endif
    </div>
</div>
