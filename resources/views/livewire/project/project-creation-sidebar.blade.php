<div  class="col-lg-3">
    <aside class="tk-status-holder">
        <ul class="tk-status-tabs">
            <li class="{{ $step <= 2 ? 'tk-current-status' : 'tk-complete-status' }}">
                <div class="tk-status-tabs_content">
                    <h6 class="tk-tabs-star"> {{ __('project.about_project') }} </h6>
                    @if( $step == 2 )
                        <p>{{ __('project.description_info') }}</p>
                    @elseif($step > 2)
                        <a href="javascript:;" wire:click.prevent="updateStep(2)">{{ __('project.edit_detail') }}</a>
                    @endif
                </div>
            </li>
            <li class="{{ $step > 3 ? 'tk-complete-status' : ( $step == 3 ? 'tk-current-status' : '' )  }}">
                <div class="tk-status-tabs_content">
                    <h6 class="tk-tabs-star"> {{ __('project.freelancer_prefrences') }} </h6>
                    @if( $step == 3 )
                        <p> {{ __('project.skills_you_want') }} </p>
                    @elseif($step > 3)
                        <a href="javascript:;" wire:click.prevent="updateStep(3)">{{ __('project.edit_detail') }}</a>
                    @endif
                </div>
            </li>
            <li class="{{ $step > 4 ? 'tk-complete-status' : ( $step == 4 ? 'tk-current-status' : '' )  }}">
                <div class="tk-status-tabs_content">
                    <h6>{{ __('project.recomended_freelancers') }}</h6>
                    @if( $step == 4 )<p>{{ __('project.hire_best_match') }}</p>@endif
                </div>
            </li>
        </ul>
        @if( $step == 4 )<a href="{{ route('project-listing') }}" class="tk-btn-solid-lg-lefticon">{{ __('project.go_to_project') }} <i class="icon-chevron-right"></i></a>@endif
    </aside>
</div>
