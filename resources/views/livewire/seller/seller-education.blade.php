<div id="qualification" wire:init="loadEducations"  class="tk-profilebox">
    <div class="tk-content-box">
        <h4>{{ __('general.qualification') }}</h4>
    </div>
    @if( $page_loaded )
        @if( !$educations->IsEmpty() )
            <div class="tk-acordian-wrapper">
                <ul id="tk-accordion" class="tk-qualification tk-qualificationvtwo">
                    @foreach($educations as $key => $education)
                        <x-education-item :education="$education" :index="$key" />
                    @endforeach
                </ul>
            </div>
        @else
            <div class="tk-noskills">
                <span>{{__('general.no_content_added')}}</span>
            </div>
        @endif
    @else
        <div class="tk-skeleton">
            <ul class="tk-frame">
                @for($i =1; $i<=3; $i++)
                    <li>
                        <div class="tk-frame-items">
                            <span class="tk-skeleton-title tk-skele"></span>
                            <div class="tk-frame-list">
                                <div class="tk-skeleton-user">
                                    <span class="tk-user-icon tk-skele"></span>
                                    <span class="tk-reviews tk-skele"></span>
                                </div>
                                <div class="tk-skeleton-user">
                                    <span class="tk-user-icon tk-skele"></span>
                                    <span class="tk-reviews tk-skele"></span>
                                </div>
                                <div class="tk-skeleton-user">
                                    <span class="tk-user-icon tk-skele"></span>
                                    <span class="tk-reviews tk-skele"></span>
                                </div>
                            </div>
                            <span class="tk-skele"></span>
                            <span class="tk-frame-para tk-skele"></span>
                        </div>
                    </li>
                @endfor
            </ul>
        </div>
    @endif
</div>
