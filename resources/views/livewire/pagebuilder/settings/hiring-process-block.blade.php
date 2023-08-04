<form class="at-themeform" id="at-form-setting_{{$block_key}}">
    <fieldset>
        <div class="at-themeform__wrap">
            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.heading_txt') }}</label>
                <textarea id="tk_editor_{{time()}}" class="form-control" name="heading" placeholder="{{ __('pages.heading_txt') }}"></textarea>
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.description') }}</label>
                <textarea type="text" class="form-control" name="description" placeholder="{{ __('pages.description') }}" >{{ !empty($settings['description']) ? $settings['description'] : '' }}</textarea>
            </div>

            <div class="form-group">
                <label class="at-label">{{ __('pages.add_video_link') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['video_link']) ? $settings['video_link'] : '' }}" name="video_link" placeholder="{{ __('pages.add_video_link') }}">
            </div>

            <div class="form-group">
                <label class="at-label">{{ __('pages.talent_btn_txt') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['talent_btn_txt']) ? $settings['talent_btn_txt'] : '' }}" name="talent_btn_txt" placeholder="{{ __('pages.talent_btn_txt') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.work_btn_txt') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['work_btn_txt']) ? $settings['work_btn_txt'] : '' }}" name="work_btn_txt" placeholder="{{ __('pages.work_btn_txt') }}">
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
                        @elseif(!empty($settings['hiring_process_bg']))
                            <img src="{{ asset($settings['hiring_process_bg']) }}" alt="">
                        @else 
                            <img src="{{asset('images/default-img.jpg')}}" alt="img">
                        @endif
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input01">
                            <span>
                                <input id="at-upload-file-input01" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="hiring_process_bg" data-var_name="upload_files.file_01"/>
                                <input type="hidden" wire:ignore value="{{ !empty($settings['hiring_process_bg']) ? $settings['hiring_process_bg'] : '' }}" name="hiring_process_bg" id="file_01"/>
                                {{__('pages.upload_photo')}}
                            </span>
                        </label>
                       
                        @if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['hiring_process_bg']) )
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="hiring_process_bg" data-block_key="{{$block_key}}"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
                        @endif
                    </div>
                    @error('upload_files.file_01')
                        <div class="tk-errormsg">
                            <span>{{$message}}</span>
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </fieldset>
</form>