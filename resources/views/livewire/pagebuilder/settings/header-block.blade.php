<form class="at-themeform" id="at-form-setting_{{$block_key}}">
    <fieldset>
        <div class="at-themeform__wrap">
            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.heading_txt') }}</label>
                <textarea id="tk_editor_{{time()}}" class="form-control" name="heading" placeholder="{{ __('pages.heading_txt') }}"></textarea>
            </div>
            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.talent_btn_txt') }}</label>
                <input type="text" id="0001" class="form-control" value="{{ !empty($settings['talent_btn_txt']) ? $settings['talent_btn_txt'] : '' }}" name="talent_btn_txt" placeholder="{{ __('pages.talent_btn_txt') }}">
            </div>
            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.work_btn_txt') }}</label>
                <input type="text" id="0002" class="form-control" value="{{ !empty($settings['work_btn_txt']) ? $settings['work_btn_txt'] : '' }}" name="work_btn_txt" placeholder="{{ __('pages.work_btn_txt') }}">
            </div>
            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.after_btn_text') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['after_btn_text']) ? $settings['after_btn_text'] : '' }}" name="after_btn_text" placeholder="{{ __('pages.after_btn_text') }}">
            </div>
            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.form_title_txt') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['form_title']) ? $settings['form_title'] : '' }}" name="form_title" placeholder="{{ __('pages.form_title_txt') }}">
            </div>
            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.form_content_txt') }}</label>
                <textarea type="text" class="form-control" name="form_content" placeholder="{{ __('pages.form_content_txt') }}" >{{ !empty($settings['form_content']) ? $settings['form_content'] : '' }}</textarea>
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.upload_bg_img') }}</label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_01">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_01">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                        </div>
                    </div>
                    <figure>
                        @if (!empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl'))
                            <img src="{{ substr($upload_files['file_01']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_01']->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $upload_files['file_01']->getClientOriginalName() }}">
                        @elseif(!empty($settings['header_background']))
                            <img src="{{ asset($settings['header_background']) }}" alt="">
                        @else 
                            <img src="{{asset('images/default-img.jpg')}}" alt="img">
                        @endif
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-bg">
                            <span>
                                <input id="at-upload-file-bg" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="header_background" data-var_name="upload_files.file_01"/>
                                <input type="hidden" wire:ignore value="{{ !empty($settings['header_background']) ? $settings['header_background'] : '' }}" name="header_background" id="file_01"/>
                                {{__('pages.upload_photo')}}
                            </span>
                        </label>
                        @if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['header_background']) )
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="header_background" data-block_key="{{$block_key}}"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
                        @endif
                    </div>
                    @error('upload_files.file_01')
                        <div class="tk-errormsg">
                            <span>{{$message}}</span>
                        </div>
                    @enderror
                </div>


            </div>

            <div class="accordion at-accordion" id="tb_counter_section" data-block_key="{{$block_key}}">
                @foreach($settings['counter_option'] as $key => $option)
                    <div class="accordion-item">
                        <h2 class="accordion-header at-accordion-header">
                            <button class="accordion-button collapsed" type="button">
                                {{__('pages.item_txt',['counter' => $key])}}
                            </button>
                            <span class="at-cross-icon"  data-block_key="{{$block_key}}"><i class="icon-x"></i></span>
                        </h2>
                        <div class="accordion-collapse collapse at-accordion-collapse">
                            <div class="accordion-body">
                                <div class="at-themeform__wrap">
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.heading_label') }}</label>
                                        <input type="text" class="form-control" onChange="submitForm('{{$block_key}}')" value="{{$option['heading']}}" data-type="heading" name="counter_option[{{$key}}][heading]" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.content_label') }}</label>
                                        <input type="text" class="form-control" onChange="submitForm('{{$block_key}}')" value="{{$option['content']}}" data-type="content" name="counter_option[{{$key}}][content]" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="at-plus-icon" id="add_more_item" data-block_key="{{$block_key}}" href="#"><i class="icon-plus"></i>{{__('pages.add_item')}}</a>
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
                    <label class="at-label">{{ __('pages.heading_label') }}</label>
                    <input type="text" class="form-control" onChange="submitForm('{{$block_key}}')" name="counter_option-heading" data-type="heading" placeholder="{{ __('pages.heading_label') }}">
                </div>
                <div class="form-group">
                    <label class="at-label">{{ __('pages.content_label') }}</label>
                    <input type="text" class="form-control" onChange="submitForm('{{$block_key}}')" name="counter_option-content" data-type="content" placeholder="{{ __('pages.heading_label') }}">
                </div>
            </div>
        </div>
    </div>
</div>