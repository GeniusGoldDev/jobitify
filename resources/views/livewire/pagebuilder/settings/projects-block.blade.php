@php
    $all_projects = getAllProjects();
    $selected_projects = !empty($settings['project_ids']) ? $settings['project_ids'] : [];
@endphp
<form class="at-themeform" id="at-form-setting_{{$block_key}}">
    <fieldset>
        <div class="at-themeform__wrap">
            <div class="form-group">
                <label class="at-label">{{ __('pages.sub_title') }}</label>
                <input type="text" class="form-control" name="sub_title" value="{{ !empty($settings['sub_title']) ? $settings['sub_title'] : '' }}" placeholder="{{ __('pages.sub_title') }}" />
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.title') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['title']) ? $settings['title'] : '' }}" name="title" placeholder="{{ __('pages.title') }}" />
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.explore_btn_txt') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['explore_btn_txt']) ? $settings['explore_btn_txt'] : '' }}" name="explore_btn_txt" placeholder="{{ __('pages.explore_btn_txt') }}" />
            </div>

            @if( !empty($all_projects) )
                <div class="form-group">
                    <label class="at-label">{{ __('pages.selected_projects') }}</label>
                    <input type="hidden" name="project_ids" id="project_ids_{{ $block_key }}" value="{{implode(',', $selected_projects)}}" />
                    <div class="at-select" >
                        <select id="selected_projects_{{ $block_key }}"  multiple data-placeholder= "{{ __('general.select') }}">
                            <option value="">{{ __('general.select') }}</option>
                            @foreach( $all_projects as $project )
                                <option value="{{ $project->id }}" {{ in_array($project->id, $selected_projects) ? 'selected' : ''}} >{{ $project->project_title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        </div>
    </fieldset>
</form>