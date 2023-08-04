<div class="{{ $block_key }} {{$custom_class}}" @if(!$site_view)  wire:click="$emit('getBlockSetting', '{{$block_key}}')" @endif>
    @if( !empty($style_css) )
        <style>{{ '.'.$block_key.$style_css }}</style>
    @endif
    @if(!empty($page_content))
        <section class="tk-main-section" wire:loading.class="tk-section-preloader">
            @if(!$site_view)
                <div class="preloader-outer" wire:loading>
                    <div class="tk-preloader">
                        <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                    </div>
                </div>
            @endif
            {!! $page_content !!}
        </section>
    @endif
</div>
