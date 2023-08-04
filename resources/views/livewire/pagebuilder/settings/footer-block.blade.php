@php
    $all_categories = getAllCategories();
    $selected_categories = !empty($settings['category_ids']) ? $settings['category_ids'] : [];
@endphp
<form class="at-themeform" id="at-form-setting_{{$block_key}}">
    <fieldset>
        <div class="at-themeform__wrap">
            <div class="form-group">
                <label class="at-label">{{ __('pages.description') }}</label>
                <textarea class="form-control" name="description" placeholder="{{ __('pages.description') }}" >{{ !empty($settings['description']) ? $settings['description'] : '' }}</textarea>
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.mobile_app_heading') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['mobile_app_heading']) ? $settings['mobile_app_heading'] : '' }}" name="mobile_app_heading" placeholder="{{ __('pages.mobile_app_heading') }}" />
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.upload_app_store_img') }}</label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_01">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_01">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                        </div>
                    </div>
                    <figure>
                        @if (!empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl'))
                            <img src="{{ substr($upload_files['file_01']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_01']->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $upload_files['file_01']->getClientOriginalName() }}">
                        @elseif(!empty($settings['app_store_img']))
                            <img src="{{ asset($settings['app_store_img']) }}" alt="img">
                        @else
                            <img src="{{asset('images/default-img.jpg')}}" alt="img">
                        @endif
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input">
                            <span>
                                <input id="at-upload-file-input" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="app_store_img" data-var_name="upload_files.file_01">
                                <input type="hidden" wire:ignore value="{{ !empty($settings['app_store_img']) ? $settings['app_store_img'] : '' }}" name="app_store_img" id="file_01"/>
                                {{__('pages.upload_photo')}}
                            </span>
                        </label>
                        @if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['app_store_img']) )
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="app_store_img" data-block_key="{{$block_key}}"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
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
                <label class="at-label">{{ __('pages.add_app_store_url') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['app_store_url']) ? $settings['app_store_url'] : '' }}" name="app_store_url" placeholder="{{ __('pages.add_app_store_url') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.upload_play_store_img') }}</label>
               
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_02">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_02">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                        </div>
                    </div>
                    <figure>
                        @if (!empty($upload_files['file_02']) && method_exists($upload_files['file_02'],'temporaryUrl'))
                            <img src="{{ substr($upload_files['file_02']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_02']->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $upload_files['file_02']->getClientOriginalName() }}">
                        @elseif(!empty($settings['play_store_img']))
                            <img src="{{ asset($settings['play_store_img']) }}" alt="">
                        @else
                            <img src="{{asset('images/default-img.jpg')}}" alt="img">
                        @endif
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-playstore-img">
                            <span>
                                <input id="at-upload-playstore-img" type="file" wire:model="upload_files.file_02" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="play_store_img" data-var_name="upload_files.file_02"/>
                                <input type="hidden" wire:ignore value="{{ !empty($settings['play_store_img']) ? $settings['play_store_img'] : '' }}" name="play_store_img" id="file_02"/>
                                {{__('pages.upload_photo')}}
                            </span>
                        </label>
                        @if(( !empty($upload_files['file_02']) && method_exists($upload_files['file_02'],'temporaryUrl') ) || !empty($settings['play_store_img']) )
                            <span class="at_remove_file" data-file_name="file_02" data-key_name="play_store_img" data-block_key="{{$block_key}}"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
                        @endif
                    </div>
                    @error('upload_files.file_02')
                        <div class="tk-errormsg">
                            <span>{{$message}}</span>
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.upload_site_logo') }}</label>
               
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_03">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_03">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                        </div>
                    </div>
                    <figure>
                        @if (!empty($upload_files['file_03']) && method_exists($upload_files['file_03'],'temporaryUrl'))
                            <img src="{{ substr($upload_files['file_03']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_03']->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $upload_files['file_03']->getClientOriginalName() }}">
                        @elseif(!empty($settings['logo_image']))
                            <img src="{{ asset($settings['logo_image']) }}" alt="">
                        @else
                            <img src="{{asset('images/default-img.jpg')}}" alt="img">
                        @endif
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-logo-img">
                            <span>
                                <input id="at-upload-logo-img" type="file" wire:model="upload_files.file_03" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="logo_image" data-var_name="upload_files.file_03"/>
                                <input type="hidden" wire:ignore value="{{ !empty($settings['logo_image']) ? $settings['logo_image'] : '' }}" name="logo_image" id="file_03"/>
                                {{__('pages.upload_photo')}}
                            </span>
                        </label>
                        @if(( !empty($upload_files['file_03']) && method_exists($upload_files['file_03'],'temporaryUrl') ) || !empty($settings['logo_image']) )
                            <span class="at_remove_file" data-file_name="file_03" data-key_name="logo_image" data-block_key="{{$block_key}}"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
                        @endif
                    </div>
                    @error('upload_files.file_03')
                        <div class="tk-errormsg">
                            <span>{{$message}}</span>
                        </div>
                    @enderror
                </div>

            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.add_play_store_url') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['play_store_url']) ? $settings['play_store_url'] : '' }}" name="play_store_url" placeholder="{{ __('pages.add_play_store_url') }}">
            </div>

            <div class="form-group">
                <label class="at-label">{{ __('pages.category_heading') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['category_heading']) ? $settings['category_heading'] : '' }}" name="category_heading" placeholder="{{ __('pages.category_heading') }}">
            </div>
            @if( !empty($all_categories) )
                <div class="form-group">
                    <label class="at-label">{{ __('pages.selected_categories') }}</label>
                    <input type="hidden" wire:ignore name="category_ids" id="category_ids_{{ $block_key }}" value="{{implode(',', $selected_categories)}}" />
                    <div wire:ignore class="at-select" >
                        <select id="selected_categories_{{ $block_key }}"  multiple data-placeholder= "{{ __('general.select') }}">
                            <option value="">{{ __('general.select') }}</option>
                            @foreach( $all_categories as $cat )
                                <option value="{{ $cat->id }}" {{ in_array($cat->id, $selected_categories) ? 'selected' : ''}} >{{ $cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label class="at-label">{{ __('pages.newsletter_heading') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['newsletter_heading']) ? $settings['newsletter_heading'] : '' }}" name="newsletter_heading" placeholder="{{ __('pages.newsletter_heading') }}">
            </div>

            <div class="form-group">
                <label class="at-label">{{ __('pages.add_phone_number') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['phone']) ? $settings['phone'] : '' }}" name="phone" placeholder="{{ __('pages.add_phone_number') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.phone_call_availablity') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['phone_call_availablity']) ? $settings['phone_call_availablity'] : '' }}" name="phone_call_availablity" placeholder="{{ __('pages.phone_call_availablity') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.add_email') }}</label>
                <input type="email" class="form-control" value="{{ !empty($settings['email']) ? $settings['email'] : '' }}" name="email" placeholder="{{ __('pages.add_email') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.add_fax') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['fax']) ? $settings['fax'] : '' }}" name="fax" placeholder="{{ __('pages.add_fax') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.add_whatsapp') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['whatsapp']) ? $settings['whatsapp'] : '' }}" name="whatsapp" placeholder="{{ __('pages.add_whatsapp') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.whatsapp_availablity_time') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['whatsapp_call_availablity']) ? $settings['whatsapp_call_availablity'] : '' }}" name="whatsapp_call_availablity" placeholder="{{ __('pages.whatsapp_availablity_time') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.facebook_link') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['facebook_link']) ? $settings['facebook_link'] : '' }}" name="facebook_link" placeholder="{{ __('pages.facebook_link') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.twitter_link') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['twitter_link']) ? $settings['twitter_link'] : '' }}" name="twitter_link" placeholder="{{ __('pages.twitter_link') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.linkedin_link') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['linkedin_link']) ? $settings['linkedin_link'] : '' }}" name="linkedin_link" placeholder="{{ __('pages.linkedin_link') }}">
            </div>
            <div class="form-group">
                <label class="at-label">{{ __('pages.dribbble_link') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['dribbble_link']) ? $settings['dribbble_link'] : '' }}" name="dribbble_link" placeholder="{{ __('pages.dribbble_link') }}">
            </div>
        </div>
    </fieldset>
</form>