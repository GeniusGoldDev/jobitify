<section class="tk-main-section tk-opportunities-sec {{ $block_key }} {{$custom_class}}"  @if(!$site_view) wire:click="$emit('getBlockSetting', '{{ $block_key }}')" @endif>
	
	<div class="container" wire:loading.class="tk-section-preloader">
		@if(!$site_view)
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                </div>
            </div>
        @endif
		<div class="row align-items-center gy-4">
			@if(!empty($display_image))
				<div class="col-12 col-xl-6">
					<figure class="tk-motivation_img">
						<img data-src="{{asset($display_image)}}">
					</figure>
				</div>
			@endif
			<div class="col-12 col-xl-6">
				<div class="tk-main-title-holder pb-0">
					@if(!empty($tagline_title) || !empty($title) )
						<div class="tk-maintitle">
							@if(!empty($tagline_title))<h5>{!! $tagline_title !!}</h5>@endif
							@if(!empty($title))<h2>{!! $title !!}</h2>@endif
						</div>
					@endif

					@if(!empty($description))
						<div class="tk-main-description">
							<p>{!! $description !!}</p>
						</div>
					@endif
					@if(!empty($points))
						<ul class="tk-motivation_list">
							@foreach($points as $point)
								<li><span><i class="fa fa-check"></i>{!! $point !!}</span></li>
							@endforeach
						</ul>
					@endif
					@if(!empty($join_us_btn_txt) && ( !Auth::check() || $userRole == 'admin') )
						<div class="tk-btn-holder">
							<a href="{{route('register')}}" class="tk-btn-yellow-lg">{!! $join_us_btn_txt !!} <i class="icon-user-check"></i> </a>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</section>
