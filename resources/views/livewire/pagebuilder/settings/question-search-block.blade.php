<form class="at-themeform" id="at-form-setting_{{$block_key}}">
    <fieldset>
        <div class="at-themeform__wrap">
            <div class="form-group">
                <label class="at-label">{{ __('pages.sub_title') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['sub_title']) ? $settings['sub_title'] : '' }}" name="sub_title" placeholder="{{ __('pages.sub_title') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.title') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['title']) ? $settings['title'] : '' }}" name="title" placeholder="{{ __('pages.title') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.list_title') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['list_title']) ? $settings['list_title'] : '' }}" name="list_title" placeholder="{{ __('pages.list_title') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.description') }}</label>
                <textarea type="text" class="form-control" name="description" placeholder="{{ __('pages.description') }}" >{{ !empty($settings['description']) ? $settings['description'] : '' }}</textarea>
            </div>

            <div class="accordion at-accordion" id="tb_counter_section" data-block_key="{{$block_key}}">
                @foreach($settings['question_list'] as $key => $question)
                    <div wire:ignore class="accordion-item">
                        <h2 class="accordion-header at-accordion-header">
                            <button class="accordion-button collapsed" type="button">
                                {{__('pages.item_txt',['counter' => $key])}}
                            </button>
                            <span class="at-cross-icon" data-block_key="{{$block_key}}"><i class="icon-x"></i></span>
                        </h2>
                        <div class="accordion-collapse collapse at-accordion-collapse">
                            <div class="accordion-body">
                                <div class="at-themeform__wrap">
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.question_label') }}</label>
                                        <input type="text" class="form-control at-collapse-field" onChange="submitForm('{{$block_key}}')" value="{{$question['question']}}" data-type="question" name="question_list[{{$key}}][question]" placeholder="{{ __('pages.question_label') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.answer_label') }}</label>
                                        <textarea type="text" class="form-control at-collapse-field" name="question_list[{{$key}}][answer]" data-type="answer" placeholder="{{ __('pages.answer_label') }}" >{{ !empty($question['answer']) ? $question['answer'] : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="at-plus-icon at-btn" id="add_more_item" data-block_key="{{$block_key}}" href="javascript:void(0)"><i class="icon-plus"></i>{{__('pages.add_item')}}</a>

        </div>
    </fieldset>
</form>

<div class="accordion-item d-none" id="clone_item">
    <h2 class="accordion-header at-accordion-header">
        <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="flush-collapseOne">
            {{__('pages.item_txt')}}
        </button>
        <span class="at-cross-icon" data-block_key="{{$block_key}}"><i class="icon-x"></i></span>
    </h2>
    <div class="accordion-collapse collapse at-accordion-collapse">
        <div class="accordion-body">
            <div class="at-themeform__wrap">
                <div class="form-group">
                    <label class="at-label">{{ __('pages.question_label') }}</label>
                    <input type="text" class="form-control at-collapse-field" onChange="submitForm('{{$block_key}}')" value="" data-type="question" name="question_list[{{$key}}][question]" placeholder="{{ __('pages.question_label') }}">
                </div>
                <div class="form-group">
                    <label class="at-label">{{ __('pages.answer_label') }}</label>
                    <textarea type="text" class="form-control at-collapse-field" onChange="submitForm('{{$block_key}}')" name="question_list[{{$key}}][answer]" data-type="answer" placeholder="{{ __('pages.answer_label') }}" ></textarea>
                </div>
            </div>
        </div>
    </div>
</div>