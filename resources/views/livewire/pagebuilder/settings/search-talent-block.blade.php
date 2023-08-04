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
                <label class="at-label">{{ __('pages.btn_txt') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['search_btn_txt']) ? $settings['search_btn_txt'] : '' }}" name="search_btn_txt" placeholder="{{ __('pages.btn_txt') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.description') }}</label>
                <textarea type="text" class="form-control" name="description" placeholder="{{ __('pages.description') }}" >{{ !empty($settings['description']) ? $settings['description'] : '' }}</textarea>
            </div>


            <div class="form-group">
                <label class="at-label">{{ __('pages.upload_main_img') }}</label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_01">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_01">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                        </div>
                    </div>
                    <figure>
                        @if (!empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl'))
                        <img src="{{ substr($upload_files['file_01']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_01']->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $upload_files['file_01']->getClientOriginalName() }}">
                        @elseif(!empty($settings['main_image']))
                            <img src="{{ asset($settings['main_image']) }}" alt="">
                        @else 
                            <img src="{{asset('images/default-img.jpg')}}" alt="img">
                        @endif
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-main-img">
                            <span>
                            <input id="at-upload-main-img" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="main_image" data-var_name="upload_files.file_01"/>
                            <input type="hidden" wire:ignore value="{{ !empty($settings['main_image']) ? $settings['main_image'] : '' }}" name="main_image" id="file_01"/>
                                {{__('pages.upload_photo')}}
                            </span>
                        </label>
                        @if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['main_image']) )
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="main_image" data-block_key="{{$block_key}}"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
                        @endif
                    </div>
                    @error('upload_files.file_01')
                        <div class="tk-errormsg">
                            <span>{{$message}}</span>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="at-label">{{ __('pages.upload_card_img') }}</label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_02">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_02">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                        </div>
                    </div>
                    <figure>
                        @if (!empty($upload_files['file_02']) && method_exists($upload_files['file_02'],'temporaryUrl'))
                        <img src="{{ substr($upload_files['file_02']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_02']->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $upload_files['file_02']->getClientOriginalName() }}">
                        @elseif(!empty($settings['card_image']))
                            <img src="{{ asset($settings['card_image']) }}" alt="">
                        @else 
                            <img src="{{asset('images/default-img.jpg')}}" alt="img">
                        @endif
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-cardimg">
                            <span>
                                <input id="at-upload-file-cardimg" type="file" wire:model="upload_files.file_02" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="card_image" data-var_name="upload_files.file_02"/>
                                <input type="hidden" wire:ignore value="{{ !empty($settings['card_image']) ? $settings['card_image'] : '' }}" name="card_image" id="file_02"/>
                                {{__('pages.upload_photo')}}
                            </span>
                        </label>
                        @if(( !empty($upload_files['file_02']) && method_exists($upload_files['file_02'],'temporaryUrl') ) || !empty($settings['card_image']) )
                            <span class="at_remove_file" data-file_name="file_02" data-key_name="card_image" data-block_key="{{$block_key}}"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
                        @endif
                    </div>
                    @error('upload_files.file_02')
                        <div class="tk-errormsg">
                            <span>{{$message}}</span>
                        </div>
                    @enderror
                </div>

            </div>
        </div>
    </fieldset>
</form>