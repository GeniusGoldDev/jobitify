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
                    
                    @if(!$projects->isEmpty() && $search_project !='')<h3>{{ $projects->count() .' '.  __('general.search_result') }} “{{ $search_project }}”</h3>@endif
                </div>
                <div class="col-xl-12">
                    <div class="tk-project-wrapper tk-template-project">
                        <div class="tk-template-serach ">
                            <h5> {{ $filter_project != '' ? __('general.'.$filter_project)  :  __('project.all_projects') }} </h5>
                            <div class="tk-search-wrapper">
                                <div class="tk-generalsearch">
                                    <label> {{ __('general.search') }}</label>
                                    <div class="tk-inputicon">
                                        <input type="text" wire:model.debounce.500ms="search_project" class="form-control" placeholder="{{ __('general.search_with_keyword') }}">
                                        <i class="icon-search"></i>
                                    </div>
                                </div>
                                <div class="tk-sort">
                                    <div class="tk-sortby" wire:ignore>
                                        <label> {{ __('project.project_type') }}</label>
                                        <div class="tk-actionselect">
                                            <div class="tk-select">
                                                <select id="project_type"  class="form-control tk-selectprice">
                                                    <option value =""> {{ __('project.all_projects') }} </option>
                                                    <option value ="fixed"> {{ __('project.fixed_type') }} </option>
                                                    <option value ="hourly"> {{ __('project.hourly_type') }} </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-sort">
                                    <div class="tk-sortby" wire:ignore>
                                        <label> {{ __('project.project_status') }}</label>
                                        <div class="tk-actionselect">
                                            <div class="tk-select">
                                                <select id="filter_project" class="form-control tk-selectprice">
                                                    <option value =""> {{ __('project.all_projects') }} </option>
                                                    <option value ="draft" @if($filter_project == 'draft') selected @endif> {{ __('general.draft') }} </option>
                                                    <option value ="pending" @if($filter_project == 'pending') selected @endif> {{ __('general.pending') }} </option>
                                                    <option value ="publish" @if($filter_project == 'publish') selected @endif> {{ __('general.publish') }} </option>
                                                    <option value ="hired" @if($filter_project == 'hired') selected @endif> {{ __('general.hired') }} </option>
                                                    <option value ="completed" @if($filter_project == 'completed') selected @endif> {{ __('general.completed') }} </option>
                                                    <option value ="rejected" @if($filter_project == 'rejected') selected @endif> {{ __('general.rejected') }} </option>
                                                    <option value ="cancelled" @if($filter_project == 'cancelled') selected @endif> {{ __('general.cancelled') }} </option>
                                                    <option value ="refunded" @if($filter_project == 'refunded') selected @endif> {{ __('general.refunded') }} </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!$projects->isEmpty())
                        @foreach($projects as $single)
                            @php
                               $tag = getTag( $single->status );
                            @endphp
                            <div class="tk-project-wrapper-two">
                                @if($single->is_featured)
                                    <x-featured-tippy />
                                @endif
                                <div class="tk-buyerprojects">
                                    <div class="tk-project-box">
                                        <div class=" tk-price-holder">
                                            <div class="tk-verified-info">
                                                <div class="tk-verified-info-tags">
                                                    <span class="{{ $tag['class'] }}">{{ $tag['text'] }}</span>
                                                </div>
                                                <h5>{{ $single->project_title }}</h5>
                                                <ul class="tk-template-view">
                                                    <li>
                                                        <i class="icon-calendar"></i>
                                                        <span> {{ __('project.project_posted_date',['diff_time'=> getTimeDiff($single->updated_at)]) }} </span>
                                                    </li>
                                                    <li>
                                                        <i class="icon-map-pin"></i>
                                                        <span> {{ $single->projectLocation->id == 3 ? (!empty($single->address) ? getUserAddress($single->address, $address_format) : $single->project_country ) : $single->projectLocation->name }} </span>
                                                    </li>
                                                    <li>
                                                        <i class="icon-briefcase"></i>
                                                        <span> {{ !empty($single->expertiseLevel) ? $single->expertiseLevel->name : '' }} </span>
                                                    </li>
                                                    <li>
                                                        <i class="{{ $single->project_hiring_seller > 1 ? 'icon-users' : 'icon-user' }}"></i>
                                                        <span>{{ $single->project_hiring_seller .' '. ($single->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer')) }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tk-price tk-tagholder">
                                            <em class="tk-project-tag-two {{ $single->project_type == 'fixed' ? 'tk-ongoing-updated' : 'tk-success-tag-updated' }}">{{ $single->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project') }}</em>
                                                <span> {{ __('project.project_budget') }}</span>
                                                <h4>{{ getProjectPriceFormat($single->project_type, $currency_symbol, $single->project_min_price, $single->project_max_price) }}</h4>
                                            </div>
                                            @php
                                                $open_menu = false;
                                                if(($rm_feature_project > 0 && $single->is_featured == 0) && ($single->status == 'publish' || $single->status == 'pending' )){
                                                    $open_menu = true;
                                                }elseif($single->status == 'pending' || $single->status == 'draft'){
                                                    $open_menu = true;
                                                }
                                            @endphp
                                            @if( $open_menu )
                                                <div class="tk-projectsstatus_option">
                                                    <a href="javascript:void(0);"><i class="icon-more-horizontal"></i></a>
                                                    <ul class="tk-contract-list" style="display: none;">
                                                        @if(in_array($single->status,  array('publish','pending'))
                                                            && $rm_feature_project > 0
                                                            && $single->is_featured == 0)
                                                            <li>
                                                                <a href="javascript:;" wire:click.prevent="makeFeature({{ $single->id }})">{{ __('project.mark_feature') }}</a>
                                                            </li>
                                                        @endif
                                                        @if($single->status == 'draft' || $single->status == 'pending')
                                                            <li>
                                                                <a href="javascript:;" wire:click.prevent="destroy({{ $single->id }})" >{{ __('project.delete_project') }} </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if(!$single->proposals->isEmpty())
                                            @php
                                                $hired_sellers = false;
                                                foreach($single->proposals as $proposal){
                                                    if( $proposal->status == 'hired' 
                                                        || $proposal->status == 'completed' 
                                                        || $proposal->status == 'refunded' ){
                                                        $hired_sellers = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            @if( $hired_sellers )
                                                <div class="tk-freelancer-holder">
                                                    <div class="tk-tagtittle">
                                                        <span>{{__('project.hired_freelancers')}}</span>
                                                    </div>
                                                    <ul class="tk-hire-freelancer">
                                                        @foreach($single->proposals as $proposal)
                                                            @php  
                                                                $user_image = '/images/default-user-50x50.png';
                                                                if( !empty( $proposal->proposalAuthor->image) ){
                                                                    $image_path     = getProfileImageURL($proposal->proposalAuthor->image, '50x50');
                                                                    $user_image     = !empty($image_path) ? '/storage/'.$image_path : '/images/default-user-50x50.png';
                                                                }
                                                                
                                                                $status = getTag($proposal->status);
                                                            @endphp
                                                            
                                                            @if( !in_array($proposal->status, ['publish','pending', 'declined','draft']) )
                                                                <li>
                                                                    <div class="tk-hire-freelancer_content">
                                                                        <img src="{{$user_image}}" alt="{{$proposal->proposalAuthor->first_name_last_letter}}">
                                                                        <div class="tk-hire-freelancer-info">
                                                                            <h6>
                                                                                {{$proposal->proposalAuthor->first_name_last_letter}}
                                                                                @if(!empty($proposal->sellerProjectReting->rating))
                                                                                    <span class="tk-blogviewdates">
                                                                                        <i class="fas fa-star tk-yellow"></i>
                                                                                        <em> {{number_format($proposal->sellerProjectReting->rating,1) }} </em>
                                                                                    </span>
                                                                                @endif
                                                                            </h6>
                                                                            <div class="tk-activity-tags-wrapper">
                                                                                <a href="{{route('project-activity',['slug' => $single->slug,'id' => $proposal->id ])}}" >{{__('project.view_activity')}}</a>
                                                                                @if( $proposal->status == "completed" )
                                                                                    @if($proposal->sellerProjectReting)
                                                                                        <a href="jvascript:void(0)" wire:click.prevent="readReview({{$proposal->id}},{{$proposal->proposalAuthor->id}})">{{__('project.read_review')}}</a>
                                                                                    @else
                                                                                        <a href="jvascript:void(0)" wire:click.prevent="addReviewPopup({{$proposal->proposalAuthor->id}}, {{$single->id}})">{{__('project.add_review')}}</a>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>
    
                                                                        @if($proposal->status == "completed" )
                                                                            <span class="tk-checked">
                                                                                <i class="fas fa-check"></i>
                                                                            </span>
                                                                        @else
                                                                            <span class="{{$status['class']}}">{{$status['text']}}</span>
                                                                        @endif
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="tk-project-box tk-project-box-two tk-proposalbtns">
                                        <ul class="tk-proposal-list">
                                            @if(!$single->proposals->isEmpty())
                                                @foreach($single->proposals as $key=> $proposal)
                                                    @if($key <= 4)
                                                        @php
                                                            if(!empty($proposal->proposalAuthor->image)){
                                                                $image_path     = getProfileImageURL($proposal->proposalAuthor->image, '38x38');
                                                                $author_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-38x38.png';
                                                            }else{
                                                                $author_image = 'images/default-user-38x38.png';
                                                            }
                                                        @endphp
                                                        <li>
                                                            <img src="{{ asset( $author_image) }}" alt="{{ $proposal->proposalAuthor->full_name }}">
                                                        </li>
                                                    @endif
                                                @endforeach
                                                <li>
                                                    <a href="{{ route('project-proposals', ['slug' => $single->slug]) }}" class="tk-view-proposal">{{ __('project.view_proposals') }} <i class="icon-chevron-right"></i></a>
                                                </li>
                                            @else 
                                                <li>
                                                    <span>{{ __('proposal.proposal_not_received') }}</span>
                                                </li>
                                            @endif
                                        </ul> 
                                        <div class="tk-project-detail">
                                            @if( $single->status == 'draft' || $single->status == 'pending' )
                                                <a href="{{ route('create-project', [ 'step'=> 2, 'id'=> $single->id ] ) }}" class="tk-edit-project"><i class="icon-edit-3"></i> {{ __('project.edit_project') }}</a>
                                            @endif
                                            <a href="{{ route('project-detail', ['slug'=> $single->slug] ) }}" class="tk-invite-bidbtn">{{ __('project.view_project') }}</a>
                                        </div>
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
                                <a href="{{ route('create-project') }}" class="tk-btn-solid-lefticon"> {{ __('project.add_new_project') }} </a>
                            </div>
                        @endif
                    </div>
                </div>
                @if(!$projects->isEmpty())
                    <div class="col-sm-12">
                        {{ $projects->links('pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <div wire:ignore.self class="modal fade tk-addonpopup" id="tk_add_review" tabindex="-1" role="dialog" aria-hidden="true">
        <div wire:key="{{now()->timestamp}}" class="modal-dialog tk-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="tk-popuptitle">
                    <h4> {{ __('project.add_review_heading') }} </h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <form class="tk-themeform" id="tb_update_review">
                        <fieldset>
                            <div class="form-group">
                                <label class="tk-label tk-required">{{ __('project.rating_title') }}</label>
                                <input type="text" wire:model.defer="rating_title" class="form-control @error('rating_title') tk-invalid @enderror" placeholder="{{__('project.rating_title')}}" autocomplete="off">
                                @error('rating_title') 
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span> 
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="tk-label tk-required">{{__('project.seller_rating')}}</label>
                                <div class="tk-my-ratingholder">
                                    <ul id="tk_seller_ratings" class='tk-rating-stars tk_stars'>
                                        <li class='tk-star' data-value='1'>
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='2' >
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='3' >
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='4' >
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='5' >
                                            <i class="fas fa-star"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @error('rating')
                                <div class="tk-errormsg">
                                    <span>{{$message}}</span> 
                                </div>
                            @enderror
                            <div class="form-group">
                                <label class="tk-label">{{ __('project.add_feedback') }}</label>
                                <textarea class="form-control" wire:model.defer="rating_desc" placeholder="{{ __('project.add_feedback') }}"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="tk-savebtn">
                                    <a href="javascript:void(0);" id="add_review" wire:click.prevent="addReview" class="tb-btn">{{__('project.save')}}</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade tb-excfreelancerpopup" id="tk_read_review" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content" id="tb_tk_viewrating">
                <div class="tb-popuptitle">
                    <h4>{{$review_detail['user_name']}}</h4>
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

            window.addEventListener('add-review-popup', event => { 
                jQuery('#tk_add_review').modal(event.detail);
            });

            window.addEventListener('ReadReviewPopup', event => { 
                jQuery('#tk_read_review').modal(event.detail);
            });

            setTimeout(function() {
                $('#filter_project, #project_type').select2(
                    { allowClear: true, minimumResultsForSearch: Infinity  }
                );

                $('#filter_project').on('change', function (e) {
                    let filter_project = $('#filter_project').select2("val");
                    @this.set('filter_project', filter_project);
                });

                $('#project_type').on('change', function (e) {
                    let project_type = $('#project_type').select2("val");
                    @this.set('project_type', project_type);
                });

                iniliazeSelect2Scrollbar();
            }, 50);

            $(document).on('click', '.tk_stars li', function(){
                var _this       = jQuery(this);
                var onStar      = parseInt(_this.data('value'), 10) > 0 ? parseInt(_this.data('value'), 10) : 5;
                var stars       = _this.parent().children('li.tk-star');

                for (var i = 0; i < stars.length; i++) {
                    jQuery(stars[i]).removeClass('active');
                }

                for (var i = 0; i < onStar; i++) {
                    jQuery(stars[i]).addClass('active');
                }
                var ratingValue = parseInt(jQuery('#tk_seller_ratings li.active').length, 10);
                @this.set('rating', ratingValue, true)
            });

            $(document).on('click', '.tk-projectsstatus_option > a', function(event) {
                // Close all open windows
                jQuery(".tk-contract-list").stop().slideUp(300);
                // Toggle this window open/close
                jQuery(this).next(".tk-contract-list").stop().slideToggle(300);
            });
        });

    </script>
@endpush