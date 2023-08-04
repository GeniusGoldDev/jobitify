
@php
    $all_categories = getAllCategories();
    $selected_categories = !empty($settings['category_ids']) ? $settings['category_ids'] : [];
@endphp
<form class="at-themeform" id="at-form-setting_{{$block_key}}">
    <fieldset>
        <div class="at-themeform__wrap">
            <div class="form-group">
                <label class="at-label">{{ __('pages.title') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['title']) ? $settings['title'] : '' }}" name="title" placeholder="{{ __('pages.title') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.sub_title') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['sub_title']) ? $settings['sub_title'] : '' }}" name="sub_title" placeholder="{{ __('pages.sub_title') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.explore_all_btn_txt') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['explore_btn_txt']) ? $settings['explore_btn_txt'] : '' }}" name="explore_btn_txt" placeholder="{{ __('pages.explore_all_btn_txt') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.description') }}</label>
                <textarea type="text" class="form-control"  name="description" placeholder="{{ __('pages.description') }}" >{{ !empty($settings['description']) ? $settings['description'] : '' }}</textarea>
            </div>
            @if( !empty($all_categories) )
                <div class="form-group">
                    <label class="at-label">{{ __('pages.selected_categories') }}</label>
                    <input type="hidden" name="category_ids" id="category_ids_{{ $block_key }}" value="{{implode(',', $selected_categories)}}" />
                    <div class="at-select" >
                        <select id="selected_categories_{{ $block_key }}" multiple data-placeholder= "{{ __('general.select') }}">
                            <option value="">{{ __('general.select') }}</option>
                            @foreach( $all_categories as $cat )
                                <option value="{{ $cat->id }}" {{ in_array($cat->id, $selected_categories) ? 'selected' : ''}} >{{ $cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        </div>
    </fieldset>
</form>

   