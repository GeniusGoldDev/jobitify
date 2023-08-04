
<section class="tk-main-section tk-faq-question-section {{ $block_key }} {{$custom_class}}" @if(!$site_view) wire:click="$emit('getBlockSetting', '{{ $block_key }}')" @endif>
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
            <div class="col-xl-10">
                <!-- acordian section start -->
                @if(!empty($sub_title) || !empty($title) || !empty($description))
                    <div class="tk-faq-search text-center">
                        <div class="tk-maintitle tk-maintitlevtwo text-center">
                            @if( !empty($sub_title) )<h5>{!! $sub_title !!}</h5>@endif
                            @if( !empty($title) )<h2>{!! $title !!}</h2>@endif
                            @if( !empty($description) )<p>{!! nl2br($description) !!}</p>@endif
                        </div>
                    </div>
                @endif
                <div class="tk-faq-acordian">
                    <div class="tk-acoridan_title">
                        <h3>{!! $list_title !!}</h3>
                    </div>
                    @if(!empty($question_list))
                        <div class="tk-acordian">
                            <ul id="tk-accordion" class="tk-accordion">
                                @foreach($question_list as $key => $question)
                                    <li>
                                        <div class="tk-accordion_title collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#collapse_{{$key}}" aria-expanded="false">
                                            <h5>{!! $question['question'] !!}</h5>
                                        </div>
                                        <div class="collapse" id="collapse_{{$key}}" data-bs-parent="#tk-accordion">
                                            <div class="tk-accordion_info tk-accordion_info">
                                                <p>{!! $question['answer'] !!}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <!-- acordian section end -->
            </div>
        </div>
    </div>
</section>

