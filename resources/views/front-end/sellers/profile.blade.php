@extends('layouts.app',['include_menu' => true])
@section('content')
	@php  
		$image = '';
		if(!empty($profile->banner_image)){
			$banner = @unserialize($profile->banner_image);

			if( !empty($banner['sizes']['1730×400']) ){
				$image = $banner['sizes']['1730×400'];
			} elseif( !empty($banner['file_path']) ) {
				$image = $banner['file_path'];
			} elseif( !empty($def_banner_img)){
				$image = $def_banner_img[0]['path'];
			}
		} elseif(!empty($def_banner_img)) {
			$image 		= $def_banner_img[0]['path'];
		}

		$banner_class = empty($image) ? 'tk-nobanner' : '';
	@endphp
	@if(!empty($image))
		<div class="tk-banner">
			<figure>
				<img src="{{asset('storage/'.$image)}}" alt="image">
			</figure>
		</div>
	@endif
    <main class="tk-bgwhite {{$banner_class}}">
        <section class="tk-profilemain">
			<div class="tk-bgback"></div>
			<div class="tk-newprofilewrap">
				<div class="container">
					<div class="row g-0">
						<div class="col-lg-4 col-xl-3 tk-hasborder">
							<aside class="tk-asiderightbar">
								<div class="tk-sideprofile">
									<figure>
										@php
											if( !empty($profile->image) ){
												$image_path     = getProfileImageURL( $profile->image, '130x130' );
               									$seller_image   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-130x30.png';
											}else{
												$seller_image = '/images/default-user-130x130.png';
											}
										@endphp
										<img src="{{ asset($seller_image) }}" alt="{{$profile->full_name }}">
									</figure>
									<div class="tk-infoprofile">
										<h4>
											{{ $profile->full_name }}
											@if($profile->user->userAccountSetting->verification == 'approved')
                                            	<i class="icon-check-circle tk-greenclr tippy" data-tippy-content="{{__('general.verified_user')}}"></i>
                                            @endif
										</h4>
										@if(!empty($profile->tagline))
											<span>{!! $profile->tagline !!}</span>
										@endif
									</div>
									<ul class="tk-blogviewdates tk-blogviewdatesmd">
										<li>
											<i class="fas fa-star tk-yellow"></i>
											<em>{{ratingFormat( $profile->ratings_avg_rating ?? '' )}}</em>
											<em>/5.0</em>
										</li>
										<li>
											<span><i class="icon-eye"></i> <em>{{ $profile->profile_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format($profile->profile_visits_count) ] ) }}</em> </span>
										</li>
									</ul>
									@if( $user_role == 'buyer' || Auth::guest())
										<div class="tk-shareprolink">
											<a class="tk-heart tk-btn-solid-sm {{ $is_favourite ? 'tk-heartsave' : '' }}">
												<i class="icon-heart"></i>
												<em>{{ $is_favourite ? __('general.saved') : __('general.save')}}</em>
											</a>
										</div>
									@endif
								</div>
								<ul class="tk-project-detail-list tk-sidedetailist">
									<li>
										<div class="tk-project-detail-item">
											<div class="tk-project-image">
												<i class="icon-dollar-sign"></i>
											</div>
											<div class="tk-project-imgdetail">
												<span>{{ __('general.starting_from') }}:</span>
												<h6>{{ __('general.per_hour_rate', ['rate' => number_format($profile->user->userAccountSetting->hourly_rate, 2), 'currency_symbol' => $currency_symbol]) }}</h6>
											</div>
										</div>
									</li>
									@if( !empty($profile->address) )
										<li>
											<div class="tk-project-detail-item">
												<div class="tk-project-image">
													<i class="icon-map-pin"></i>
												</div>
												<div class="tk-project-imgdetail">
													<span>{{ __('general.location') }}:</span>
													<h6>{{ getUserAddress($profile->address, $address_format) }}</h6>
												</div>
											</div>
										</li>
									@endif
									@if( !empty($profile->seller_type) )
										<li>
											<div class="tk-project-detail-item">
												<div class="tk-project-image">
													<i class="icon-book-open"></i>
												</div>
												<div class="tk-project-imgdetail">
													<span>{{ __('general.seller_type') }}:</span>
													<h6>{{ $profile->seller_type }} </h6>
												</div>
											</div>
										</li>
									@endif
									@if( !$profile->languages->isEmpty() )
										<li>
											<div class="tk-project-detail-item">
												<div class="tk-project-image">
													<i class="icon-calendar"></i>
												</div>
												<div class="tk-project-imgdetail">
													<span>{{ __('languages.text') }}:</span>
													@php
														$count			= 2;
														$hide_lang 		= [];
														$languages 		= [];
														$counter_langs  = 0;

														foreach($profile->languages as $single){
															$counter_langs++;
															if($counter_langs <= $count){
																$languages[] = $single->name;
															} else {
																$hide_lang[] = $single->name;
															}
														}
													@endphp
													<div class="tk-languagelist">
														<ul class="tk-languages">
															@foreach($languages as $language)
																<li>{{$language}}</li>
															@endforeach

															@if(count($hide_lang) > 5)
																<li>
																	<a class="tk-showmore tk-tooltip-tags" href="javascript:void(0);"  data-tippy-trigger="click" data-template="tk-industrypro" data-tippy-interactive="true" data-tippy-placement="top-start">
																		{{ __('general.more_text', ['counter' => sprintf('%02d', intval($counter_langs) - $count) ] ) }}
																	</a>
																	<div id="tk-industrypro" class="tk-tippytooltip d-none">
																		<div class="tk-selecttagtippy tk-tooltip ">
																			<ul class="tk-posttag tk-posttagv2">
																				@foreach($hide_lang as $item)
																					<li>
																						<a href="javascript:void(0);">{{$item}}</a>
																					</li>
																				@endforeach
																			</ul>
																		</div>
																	</div>
																</li>
															@endif
														</ul>
													</div>
												</div>
											</div>
										</li>
									@endif
									@if( !empty($profile->english_level) )
										<li>
											<div class="tk-project-detail-item">
												<div class="tk-project-image tk-bg-lightblue">
													<i class="icon-archive"></i>
												</div>
												<div class="tk-project-imgdetail">
													<span>{{ __('general.english_level') }}:</span>
													<h6>{{ ucfirst($profile->english_level) }} </h6>
												</div>
											</div>
										</li>
									@endif
								</ul>
								@if( $allow_social_links == '1' && !$profile->socialLinks->isEmpty())
									<div class="tk-followsocial">
										<h6>{{__('general.follow_more')}}</h6>
										<ul class="tk-socailmedia">
											@foreach($profile->socialLinks as $social_link)
												@php 
													$name = strtolower($social_link->name);
													$data = availableSocialLinks($name);
													
												@endphp
												<li>
													<a class="tk-{{$name}}" href="{{$social_link->url}}" target="_blank">
														<i class="{{$data['icon_class']}}"></i>
													</a>
												</li>
											@endforeach
										</ul>
									</div>
								@endif
								@if(!empty($adsense_code))
									<div class="tk-asideadvertisment">
										{!! $adsense_code !!}
									</div>
								@endif
							</aside>
						</div>
						<div class="col-lg-8 col-xl-9">
							<div class="tk-pofilelinks">
								<ul  id="list-example" class="tk-linklist">
									<li>
										<a href="#about">{{__('general.about')}}</a>
									</li>
									<li>
										<a href="#skills">{{ __('skill.text') }}</a>
									</li>
									<li>
										<a href="#gigs">{{ __('general.all_gigs') }}</a>
									</li>
									<li>
										<a href="#portfolio">{{__('general.all_portfolio')}}</a>
									</li>
									<li>
										<a href="#qualification">{{__('general.qualification')}}</a>
									</li>
									<li>
										<a href="#reviews">{{__('general.reviews')}}</a>
									</li>
								</ul>
									<div id="about" class="tk-profilebox">
										<div class="tk-project-holder">
											<div class="tk-project-title">
												<h4>{{ __('general.about') }}</h4>
											</div>
											@if( !empty($profile->description) )
												<div class="tk-jobdescription">
													<p>{!! nl2br($profile->description) !!}</p>
												</div>
											@else
											<div class="tk-noskills">
												<span>{{__('general.no_content_added')}}</span>
											</div>
										@endif			
										</div>
									</div>
									<div id="skills" class="tk-profilebox">
										<div class="tk-content-box">
											<h4>{{ __('skill.text') }}</h4>
											@if( !$profile->skills->isEmpty() )
												<ul class="tk-skills-tags tk-skills-tagsvtwo"> 
													@foreach($profile->skills as $single)
														<li><a href="javascript:;">{!! $single->name !!}</a></li>
													@endforeach
												</ul>
											@else
												<div class="tk-noskills">
													<span>{{__('general.no_content_added')}}</span>
												</div>
											@endif
										</div>
									</div>
									<livewire:seller.seller-gigs :user_profile_id='$profile->id' :seller_name='$profile->full_name' :verify_status='$profile->user->userAccountSetting->verification' :currency_symbol='$currency_symbol' :address_format='$address_format' :user_role="$user_role"/>
									<livewire:seller.seller-portfolios :user_profile_id='$profile->id' />
									<livewire:seller.seller-education :user_profile_id='$profile->id' />
									<livewire:seller.seller-reviews :user_profile_id='$profile->id' :date_format="$date_format" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
    </main>
@endsection('content')

@push('scripts')
	<script defer src="{{ asset('common/js/popper-core.js') }}"></script> 
    <script defer src="{{ asset('common/js/tippy.js') }}"></script>
    <script>
		function tooltipInit( selecter) {
			if (typeof tippy === 'function') {
				let tipp = tippy( selecter, {
					allowHTML: true,
					animation: 'scale',
					content(reference) {
						const id = reference.getAttribute('data-template');
						const template = document.getElementById(id);
						return template.innerHTML;
					}
				});
			}
		}

        window.onload = (event) => {
            var pageloaded = false;
				tooltipInit('.tk-showmore');
			  // Trigger Jquery Scrollspy
			  var screensize= jQuery( window ).width();
			  if(screensize >= 767){
				  jQuery(".tk-linklist li a").on("click",function(){
					  jQuery('html, body').animate({
						  scrollTop: jQuery(jQuery(this).attr('href'))
						  .offset().top
					  }, 300);
						  return false;
				  });
				  jQuery(window).scroll(function() {
					  
					  var x = jQuery(".tk-linklist").offset().top + 300;
					  jQuery(".tk-pofilelinks .tk-profilebox").each(function(index) {
						  let id = jQuery(this).attr('id');
						  if (x > jQuery(this).offset().top + 150 && x <= jQuery(this).offset().top + jQuery(this).height() + 170) {
							  jQuery(`.tk-linklist li a[href="#${id}"]`).addClass('active')
						  } else {
							  jQuery(`.tk-linklist li a[href="#${id}"]`).removeClass('active')
						  }
					  })
				  });
			  }

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				$(document).on('click','.tk-heart', function(event){
                let _this = $(this);
                let type = _this.data('type');
                $.ajax({
                    type:'POST',
                    url:"{{route('favourite-item')}}",
                    data:{ 
                        'seller_id'     : "{{$profile->id}}",
                        'profile_slug'  : "{{$profile->slug}}",
                        'type'          : 'profile'
                    },
                    success:function(response){
                        if(response.type == 'success'){
                            let isUpdate = response.data.isUpdate;
                            if(isUpdate){
								$('.tk-heart').toggleClass('tk-heartsave');
								let unsave = "{{__('general.save')}}";
								let saved = "{{__('general.saved')}}";
								
								if($('.tk-heart').hasClass('tk-heartsave')){
									$('.tk-heart em').text(saved)
								} else {
									$('.tk-heart em').text(unsave)
								}
                            }
                        }else if(response.type == 'login_error'){
                            showAlert({
                                message     : response.data.message,
                                type        : 'error',
                                title       : response.data.title ,
                                autoclose   : 2000,
                                redirectUrl : ''
                            });
                        }
                    }
                });
            });
        }

    </script>
@endpush
