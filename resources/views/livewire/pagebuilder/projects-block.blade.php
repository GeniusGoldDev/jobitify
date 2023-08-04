
<section class="tk-main-section-two tk-main-sectionv2 tk-projectsection {{ $block_key }} {{$custom_class}}" @if(!$site_view) wire:click="$emit('getBlockSetting', '{{ $block_key }}')" @endif>
	@if( !empty($style_css) )
		<style>{{ '.'.$block_key.$style_css }}</style>
	@endif
	<div class="container" wire:loading.class="tk-section-preloader">
		@if(!$site_view)
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                </div>
            </div>
        @endif
		<div class="row justify-content-center">
			@if(!empty($sub_title) || !empty($title) || !empty($explore_btn_txt))
				<div class="col-sm-12">
					<div class="tk-main-title-holder">
						@if(!empty($sub_title) || !empty($title))
							<div class="tk-maintitle">
								@if(!empty($sub_title))<h3>{!! $sub_title !!}</h3> @endif
								@if(!empty($title))<h2>{!! $title !!}</h2>@endif
							</div>
						@endif
						@if(!empty($explore_btn_txt))
							<div class="tk-btn2-wrapper">
								<a href="{{route('search-projects')}}" class="tk-sectionbtn">{!! $explore_btn_txt !!}<i class="icon icon-grid"></i></a>
							</div>
						@endif
					</div>
				</div>
			@endif

			@if(!empty($projects))
				<div class="col-xl-12">
					@if(!$projects->isEmpty())
						@foreach($projects as $single)
							<div class="tk-project-wrapper-two">
								@if($single->is_featured)
									<span data-tippy-content="{{__('settings.featured_project')}}" class="tk-featureditem tippy">
										<i class="icon icon-zap"></i>
									</span>
								@endif
								<div class="tk-projectlisting">
									<div class="tk-price-holder">
										<div class="tk-project-img">
											@if(!empty($single->projectAuthor->image)) 
												@php  
													$image_path     = getProfileImageURL( $single->projectAuthor->image, '130x130' );
													$author_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-130x130.png';
												@endphp 
												<img data-src="{{ asset($author_image) }}" alt="">
											@else 
												<img data-src="{{ asset('images/default-user-130x130.png')  }}" alt="">
											@endif
										</div>
										<div class="tk-verified-info">
											<a href="javascript:void(0)">
												{{ $single->projectAuthor->full_name}}
												<i class="icon-check-circle tk-theme-tooltip tippy" data-tippy-content="{{__('general.verified_user')}}"></i>
											</a>
											

											<h5>{{ $single->project_title }}</h5>
											<ul class="tk-template-view">
												<li>
													<i class="icon-calendar"></i>
													<span> {{ __('project.project_posted_date',['diff_time'=> getTimeDiff( $single->updated_at )]) }} </span>
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
										<div class="tk-price">
											<span> {{ $single->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_price') }}</span>
											<h4>{{ getProjectPriceFormat($single->project_type, $currency_symbol, $single->project_min_price, $single->project_max_price) }}</h4>
											<div class="tk-project-option">
												<a href="{{ route('project-detail', ['slug'=> $single->slug] ) }}" target="_blank" class="tk-invite-bidbtn">{{ __('project.view_detail') }}</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			@endif
				
		</div>
	</div>
</section>

@push('scripts')
	<script defer src="{{ asset('common/js/popper-core.js') }}"></script>
	<script defer src="{{ asset('common/js/tippy.js') }}"></script>
	<script>
        window.onload = (event) => {
        	jQuery(document).ready(function() {
				let tb_tippy = document.querySelector(".tippy");
                if (tb_tippy !== null) {
                    tippy(".tippy", {
                        animation: "scale",
                    });
                }
			});
		}
	</script>
@endpush
   