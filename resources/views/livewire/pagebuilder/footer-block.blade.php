<div class="{{ $block_key }} tk-footerwrap {{$custom_class}}" @if(!$site_view) wire:click="$emit('getBlockSetting', '{{ $block_key }}')" @endif>
	@if( !empty($style_css) )
		<style>{{ '.'.$block_key.$style_css }}</style>
	@endif
    <!-- FOOTER START -->
	<footer class="tk-footer-two tk-footerv2" wire:loading.class="tk-section-preloader">
		@if(!$site_view)
			<div class="preloader-outer" wire:loading>
				<div class="tk-preloader">
					<img class="fa-spin" src="{{ asset('images/loader.png') }}">
				</div>
			</div>
		@endif
		<div class="container">
			<div class="row tk-footer-two_head">
				<div class="col-12 col-xl-4">
					<div class="tk-footer-two_info">
						@if( !empty($logo_image) )
                            <strong class="tk-footerlogo"><a href="{{ url('/')}}"><img src="{{asset($logo_image)}}" alt="{{ __('general.logo') }}" /></a></strong>
                        @else
                            <strong ><a href="{{ url('/')}}"><img src="{{asset('demo-content/logo.png')}}" alt="{{ __('general.logo') }}" /></a></strong>
                        @endif
						@if(!empty($description))
							<div class="tk-description">
								<p>{!! nl2br($description) !!}</p>
							</div>
						@endif
						@if(!empty($app_store_img) || !empty($play_store_img))
							<div class="tk-footer-mobile-app">
								@if(!empty($mobile_app_heading))
									<div class="tk-title">
										<h3>{!! $mobile_app_heading !!}</h3>
									</div>
								@endif
								<ul class="tk-socailapp">
									@if(!empty($app_store_img))
										<li>
											<a href="{{$app_store_url}}">
												<img src="{{asset($app_store_img)}}" alt="{{__('pages.app_store_alt')}}">
											</a>
										</li>
									@endif
									@if(!empty($play_store_img))
										<li>
											<a href="{{$play_store_url}}">
												<img src="{{asset($play_store_img)}}" alt="{{__('pages.play_store_alt')}}">
											</a>
										</li>
									@endif
								</ul>
							</div>
						@endif
					</div>
				</div>
				@if(!empty($categories))
					<div class="col-12 col-xl-4">
						<div class="tk-fwidget">
							@if(!empty($category_heading))
								<div class="tk-fwidget_title">
									<h5>{!! $category_heading !!}</h5>
								</div>
							@endif
							<ul class="tk-fwidget_list">
								@foreach($categories as $index => $category)
									@if($index > 8)
										<li class="tk-showall"><a href="{{ route('search-projects')}}" target="_blank">{{__('pages.show_all')}}</a></li>
									@endif
									@php if($index > 8){
											break;
										}
									@endphp
									<li><a href="{{ route('search-projects', ['category' => $category->slug])}}" target="_blank">{{$category->name}}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif
				<div class="col-12 col-xl-4">
					<div class="tk-footernewsletter tk-footernewsletterv2">
						@if(!empty($newsletter_heading))
							<div class="tk-fwidget_title">
								<h5>{!! $newsletter_heading !!}</h5>
							</div>
						@endif
						@if(!empty($phone) || !empty($email) || !empty($fax) || !empty($whatsapp) )
							<ul class="tk-fwidget_contact_list">
								@if(!empty($phone))
									<li>
										<i class="icon icon-phone-call"></i>
										<a href="tel:{{$phone}}">{{$phone}}</a>
										@if(!empty($phone_call_availablity))
											<span>{!! $phone_call_availablity !!}</span>
										@endif
									</li>
								@endif
								@if(!empty($email))
									<li>
										<i class="icon icon-mail"></i>
										<a href="mailto:{{$email}}">{!! $email !!}</a>
									</li>
								@endif
								@if(!empty($fax))
									<li>
										<i class="icon icon-printer"></i>
										<a href="fax:{{$fax}}">{!! $fax !!}</a>
									</li>
								@endif
								@if(!empty($whatsapp))
									<li>
										<i class="fab fa-whatsapp"></i>
										<a href="whatsapp://tel:{{$whatsapp}}">{!! $whatsapp !!}</a>
										@if(!empty($whatsapp_call_availablity))
											<span>{!! $whatsapp_call_availablity !!}</span>
										@endif
									</li>
								@endif
							</ul>
						@endif

						@if(!empty($facebook_link) || !empty($twitter_link) || !empty($linkedin_link) || !empty($dribbble_link))
							<ul class="tk-socialicons">
								@if(!empty($facebook_link))
									<li>
										<a href="{{$facebook_link}}" class="wk-facebook"><i class="fab fa-facebook-f"></i></a>
									</li>
								@endif
								@if(!empty($twitter_link))
									<li>
										<a href="{{$twitter_link}}" class="wk-twitter"><i class="fab fa-twitter"></i></a>
									</li>
								@endif
								@if(!empty($linkedin_link))
									<li>
										<a href="{{$linkedin_link}}" class="wk-linkedin"><i class="fab fa-linkedin-in"></i></a>
									</li>
								@endif
								@if(!empty($dribbble_link))
									<li>
										<a href="{{$dribbble_link}}" class="wk-dribbble"><i class="fab fa-dribbble"></i></a>
									</li>
								@endif
							</ul>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="tk-footer-two_copyright">
			<div class="container">
				<div class="wk-fcopyright">
					<span class="wk-fcopyright_info">{{ __('general.copy_right_text').' '. date('Y')}}</span>
					@if( !empty($footer_menu) && $footer_menu->count() > 0 )  
						<nav class="wk-fcopyright_list">
							<ul class="wk-copyrights-list">
								@foreach( $footer_menu as $menu)
									<li>
										<a href="{{ !empty($menu->route) ? url($menu->route ) : 'javascript:;' }}">{!! ucfirst($menu->label) !!}</a>
									</li>
								@endforeach	
							</ul>
						</nav>
					@endif
				</div>
			</div>
		</div>
	</footer>
	<!-- FOOTER END -->
</div>
