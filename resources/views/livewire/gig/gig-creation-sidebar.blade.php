<div  class="col-lg-3">
    <aside class="tk-status-holder">
        <ul class="tk-status-tabs">
            <li class="{{ $step ==1 ? 'tk-current-status' : 'tk-complete-status' }}">
                <div class="tk-status-tabs_content">
                    <h6 class="tk-tabs-star"> {{ __('gig.about_gig') }} </h6>
                    @if( $step == 1 )
                        <p>{{ __('gig.description_info') }}</p>
                    @elseif($step >= 2)
                        <a href="javascript:;" wire:click.prevent="updateStep(1)">{{ __('gig.edit_detail') }}</a>
                    @endif
                </div>
            </li>
            <li class="{{ $step > 2 ? 'tk-complete-status' : ( $step == 2 ? 'tk-current-status' : '' )  }}">
                <div class="tk-status-tabs_content">
                    <h6 class="tk-tabs-star"> {{ __('gig.pricing') }} </h6>
                    @if( $step == 2 )
                        <p> {{ __('gig.pricing_desc') }} </p>
                    @elseif($step >= 2)
                        <a href="javascript:;" wire:click.prevent="updateStep(2)">{{ __('gig.edit_detail') }}</a>
                    @endif
                </div>
            </li>
            <li class="{{ $step > 3 ? 'tk-complete-status' : ( $step == 3 ? 'tk-current-status' : '' )  }}">
                <div class="tk-status-tabs_content">
                    <h6 class="tk-tabs-star"> {{ __('gig.media_attachment') }} </h6>
                    @if( $step == 3 )
                        <p> {{ __('gig.media_attachment_desc') }} </p>
                    @elseif($step >= 3)
                        <a href="javascript:;" wire:click.prevent="updateStep(3)">{{ __('gig.edit_detail') }}</a>
                    @endif
                </div>
            </li>
            <li class="{{ $step > 4 ? 'tk-complete-status' : ( $step == 4 ? 'tk-current-status' : '' )  }}">
                <div class="tk-status-tabs_content">
                    <h6>{{ __('gig.faq') }}</h6>
                    @if( $step == 4 )<p>{{ __('gig.faq_desc') }}</p>@endif
                </div>
            </li>
        </ul>
    </aside>
</div>
