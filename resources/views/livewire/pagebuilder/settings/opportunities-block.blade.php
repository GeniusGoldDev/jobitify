<form class="at-themeform" id="at-form-setting_{{$block_key}}">
    <fieldset>
        <div class="at-themeform__wrap">
            <div class="form-group">
                <label class="at-label">{{ __('pages.add_tagline_title') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['tagline_title']) ? $settings['tagline_title'] : '' }}" name="tagline_title" placeholder="{{ __('pages.add_tagline_title') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.title') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['title']) ? $settings['title'] : '' }}" name="title" placeholder="{{ __('pages.title') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.join_us_btn_txt') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['join_us_btn_txt']) ? $settings['join_us_btn_txt'] : '' }}" name="join_us_btn_txt" placeholder="{{ __('pages.join_us_btn_txt') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.description') }}</label>
                <textarea type="text" class="form-control" name="description" placeholder="{{ __('pages.description') }}" >{{ !empty($settings['description']) ? $settings['description'] : '' }}</textarea>
            </div>


            <div class="form-group">
               
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_01">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_01">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                        </div>
                    </div>
                    <figure>
                        @if (!empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl'))
                            <img src="{{ substr($upload_files['file_01']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_01']->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $upload_files['file_01']->getClientOriginalName() }}">
                        @elseif(!empty($settings['display_image']))
                            <img src="{{ asset($settings['display_image']) }}" alt="">
                        @else 
                            <img src="{{asset('images/default-img.jpg')}}" alt="img">
                        @endif
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input01">
                            <span>
                                <input id="at-upload-file-input01" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="display_image" data-var_name="upload_files.file_01"/>
                                <input type="hidden" wire:ignore value="{{ !empty($settings['display_image']) ? $settings['display_image'] : '' }}" name="display_image" id="file_01"/>
                                {{__('pages.upload_photo')}}
                            </span>
                        </label>
                        @if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['display_image']) )
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="display_image" data-block_key="{{$block_key}}"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
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
                @foreach($settings['points'] as $key => $point)
                    <div class="accordion-item">
                        <h2 class="accordion-header at-accordion-header">
                            <button class="accordion-button collapsed" type="button">
                                {{__('pages.item_txt',['counter' => $key])}}
                            </button>
                            <span class="at-cross-icon"><i class="icon-x"></i></span>
                        </h2>
                        <div class="accordion-collapse collapse at-accordion-collapse">
                            <div class="accordion-body">
                                <div class="at-themeform__wrap">
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.point_label') }}</label>
                                        <input type="text" class="form-control" onChange="submitForm('{{$block_key}}')" value="{{$point}}" data-type="heading" name="points[]" placeholder="{{ __('pages.point_label') }}">
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
                    <label class="at-label">{{ __('pages.point_label') }}</label>
                    <input type="text" class="form-control" onChange="submitForm('{{$block_key}}')" name="points[]">
                </div>
            </div>
        </div>
    </div>
</div>