
<section class="tk-hiring-section {{ $block_key }} {{$custom_class}}" @if(!empty($hiring_process_bg)) style="background-image: url({{asset($hiring_process_bg)}})" @endif @if(!$site_view) wire:click="$emit('getBlockSetting', '{{ $block_key }}')" @endif>
	<div class="tk-sectionclr-holder tk-hiring-process" @if(!$site_view) wire:loading.class="tk-section-preloader" @endif>
		@if( !empty($style_css) )
			<style>{{ '.'.$block_key.$style_css }}</style>
		@endif
		@if(!$site_view)
			<div class="preloader-outer" wire:loading>
				<div class="tk-preloader">
					<img class="fa-spin" src="{{ asset('images/loader.png') }}">
				</div>
			</div>
		@endif
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-8">
					<div class="tk-main-title-holder text-center">
						<div class="tk-maintitle">
							@if(!empty($video_link))
								<a class="tk-hiring-vidobtn venoboxvid tk-themegallery vbox-item" data-vbtype="video" data-ratio="4x3" data-gall="gall-video" href="{{$video_link}}" data-autoplay="true">
									<i class="fas fa-play"></i>
								</a>
							@endif
							{!! $heading !!}
						</div>
						<div class="tk-main-description">
							<p>{!! $description !!}</p>
						</div>
					</div>
					<ul class="tk-mainbtnlist tk-mainlist-two pt-0">
						<li><a href="{{ route('search-sellers') }}" class="tk-btn-solid-lg tk-btn-yellow">{!! $talent_btn_txt !!}</a></li>
						<li><a href="{{ route('search-projects') }}" class="tk-btn-line-lg tk-btn-plain">{!! $work_btn_txt !!}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

@push('styles')
	@vite([
        'public/pagebuilder/css/venobox.min.css', 
    ])
@endpush
@push('scripts')
	<script defer src="{{ asset('pagebuilder/js/venobox.min.js') }}"></script>
	<script>
		document.addEventListener('livewire:load', function () {
			initVenoBox();
		});
		
		function initVenoBox(){
			let venobox = document.querySelector(".tk-themegallery");
			if (venobox !== null) {
				jQuery(".tk-themegallery").venobox({
					spinner : 'cube-grid',
				});
			}
		}
		
	</script>
@endpush
