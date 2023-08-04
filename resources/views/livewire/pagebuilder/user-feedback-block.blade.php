
<section class=" tk-testimonial {{ $block_key }} {{$custom_class}}" @if(!empty($feedback_bg)) style="background-image: url({{asset($feedback_bg)}})" @endif @if(!$site_view)  wire:click="$emit('getBlockSetting', '{{$block_key}}')" @endif>
	@if( !empty($style_css) )
        <style>{{ '.'.$block_key.$style_css }}</style>
    @endif	
	<div class="tk-sectionclr-holder tk-working-sectionbg"  wire:loading.class="tk-section-preloader">
		@if(!$site_view)
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                </div>
            </div>
        @endif
		<div class="container">
			<div class="row justify-content-center">
				@if(!empty($sub_title) || !empty($title) || !empty($description) )
					<div class="col-xl-8">
						<div class="tk-main-title-holder text-center">
							@if(!empty($sub_title) || !empty($title) )
								<div class="tk-maintitle">
									@if(!empty($sub_title))<h3 class="tk-colorwhite">{!! $sub_title !!}</h3>@endif
									@if(!empty($title))<h2>{!! $title !!}</h2> @endif
								</div>
							@endif

							@if(!empty($description))
								<div class="tk-main-description">
									<p>{{$description}}</p>
								</div>
							@endif
						</div>
					</div>
				@endif
				@if(!empty($feedback_users))
					<div class="col-sm-12">
						<div class="swiper tk-feedback tk-feedback-two tk-swiperdots">
							<div class="swiper-wrapper">
								@foreach($feedback_users as $index => $user)
									<div class="swiper-slide" >
										<div class="tk-slider-content">
											<div class="tk-slider-user">
												@if(!empty($user['image']))<img src="{{asset($user['image'])}}" alt="image"> @endif
												<div class="tk-slideruser-info">
													@if(!empty($user['name'])) <h5>{!! $user['name'] !!} </h5> @endif
													@if(!empty($user['address']))<a href="javascript:void(0)">{!! $user['address'] !!}</a> @endif
												</div>
											</div>
											@if(!empty($user['description']))<p>{!! $user['description'] !!}</p> @endif
											<div class="tk-ratting">
												@if(isset($user['rating']))<strong> Excellent {{$user['rating']}} <span>out of 5</span> </strong> @endif
												@if(!empty($user['rating']) && $user['rating'] > 0 )
													<ul class="tk-ratingstars">
														@for( $i = 1; $i <= $user['rating']; $i++)
															<li class="tk-starfill">
																<i class="fa fa-star"></i>
															</li>
														@endfor
													</ul>
												@endif
											</div>
										</div>
									</div>
								@endforeach
							</div>
							<div class="swiper-pagination"></div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
</section>

@push('styles')
	@vite([
        'public/pagebuilder/css/swiper-bundle.min.css', 
    ])
@endpush
@push('scripts')
	<script defer src="{{ asset('pagebuilder/js/swiper-bundle.min.js') }}"></script>
	<script>
		document.addEventListener('livewire:load', function () {
			initSipwer();
		});
		
		function initSipwer(){
		  	var tk_swiper = document.querySelector('.tk-feedback')
				if(tk_swiper !== null){
					var swiper = new Swiper(".tk-feedback", {
						slidesPerView: 1,
						spaceBetween: 24,
						freeMode: true,
						pagination: {
							el: ".swiper-pagination",
							clickable: true,
						},
						breakpoints: {
							480: {
							slidesPerView: 1,
							spaceBetween: 24
							},
							767: {
							slidesPerView: 1,
							spaceBetween: 24
							},
							991: {
							slidesPerView: 2,
							spaceBetween: 24
							},
							1199: {
							slidesPerView: 3,
							spaceBetween: 24
							},
						}
					});
				}
		}
		
	</script>
@endpush

