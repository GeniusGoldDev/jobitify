<form class="at-themeform" id="at-form-setting_{{$block_key}}">
    <fieldset>
        <div class="at-themeform__wrap">

            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.sub_title') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['sub_title']) ? $settings['sub_title'] : '' }}" name="sub_title" placeholder="{{ __('pages.sub_title') }}">
            </div>
            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.title') }}</label>
                <input type="text" class="form-control" value="{{ !empty($settings['title']) ? $settings['title'] : '' }}" name="title" placeholder="{{ __('pages.title') }}">
            </div>
            <div wire:ignore class="form-group">
                <label class="at-label">{{ __('pages.description') }}</label>
                <textarea type="text" class="form-control" name="description" placeholder="{{ __('pages.description') }}" >{{ !empty($settings['description']) ? $settings['description'] : '' }}</textarea>
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
                        @elseif(!empty($settings['feedback_bg']))
                            <img src="{{ asset($settings['feedback_bg']) }}" alt="">
                        @else 
                            <img src="{{asset('images/default-img.jpg')}}" alt="img">
                        @endif
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input01">
                            <span>
                                <input id="at-upload-file-input01" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="feedback_bg" data-var_name="upload_files.file_01"/>
                                <input type="hidden" wire:ignore value="{{ !empty($settings['feedback_bg']) ? $settings['feedback_bg'] : '' }}" name="feedback_bg" id="file_01"/>
                                {{__('pages.upload_photo')}}
                            </span>
                        </label>
                        @if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['feedback_bg']) )
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="feedback_bg" data-block_key="{{$block_key}}"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
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
                @foreach($settings['feedback_users'] as $key => $user)
                    <div class="accordion-item">
                        <h2 class="accordion-header at-accordion-header">
                            <button class="accordion-button collapsed" type="button">
                                {{__('pages.item_txt',['counter' => $key])}}
                            </button>
                            <span  wire:click.prevent="removeItem('feedback_users',{{$key}})"><i class="icon-x"></i></span>
                        </h2>
                        <div wire:ignore.self class="accordion-collapse collapse at-accordion-collapse">
                            <div class="accordion-body">
                                <div class="at-themeform__wrap">
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.name') }}</label>
                                        <input type="text" class="form-control" value="{{$user['name'] ?? ''}}" onChange="submitForm('{{$block_key}}')" name="feedback_users[{{$key}}][name]" placeholder="{{__('pages.name')}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.address') }}</label>
                                        <input type="text" class="form-control" value="{{$user['address'] ?? ''}}" onChange="submitForm('{{$block_key}}')" name="feedback_users[{{$key}}][address]" placeholder="{{__('pages.address')}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.description') }}</label>
                                        <input type="text" class="form-control" value="{{$user['description'] ?? ''}}" onChange="submitForm('{{$block_key}}')" name="feedback_users[{{$key}}][description]" placeholder="{{__('pages.description')}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="tk-label">{{__('pages.feedback_rating')}}</label>
                                        <div class="tk-my-ratingholder" wire:ignore>
                                            <ul id="tk_seller_ratings" class='tk-rating-stars tk_stars'>
                                                @if(!empty($user['rating']) )
                                                    @for($i=1; $i < 6; $i++ )
                                                    <li class="tk-star {{ $i <= $user['rating'] ? 'active':'' }}" data-value="{{$i}}">
                                                        <i class="fas fa-star"></i>
                                                    </li>
                                                    @endfor
                                                @endif
                                            </ul>
                                            <input type="hidden" name="feedback_users[{{$key}}][rating]" data-block_key="{{$block_key}}" class="at-feedback-rating" value="{{ !empty($user['rating']) ? $user['rating'] : 0 }}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.upload_img') }}</label>
                                        <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="settings.feedback_users.{{$key}}.image">
                                            <div class="preloader-outer" wire:loading wire:target="settings.feedback_users.{{$key}}.image">
                                                <div class="tk-preloader">
                                                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                                                </div>
                                            </div>
                                            <figure>
                                                @if (!empty($settings['feedback_users'][$key]['image']) && method_exists($settings['feedback_users'][$key]['image'],'temporaryUrl'))
                                                    <img src="{{ substr($settings['feedback_users'][$key]['image']->getMimeType(), 0, 5) == 'image' ? $settings['feedback_users'][$key]['image']->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $settings['feedback_users'][$key]['image']->getClientOriginalName() }}">
                                                @elseif(!empty($user['image']))
                                                    <img src="{{ asset($user['image'])}}" alt="">
                                                @else 
                                                    <img src="{{asset('images/default-img.jpg')}}" alt="img">
                                                @endif
                                            </figure>
                                            <div class="at-del-img">
                                                <label for="at-feedback_users{{$key}}-image">
                                                    <span>
                                                        <input id="at-feedback_users{{$key}}-image" type="file" wire:model="settings.feedback_users.{{$key}}.image" accept="image/png, image/gif, image/jpeg" class="at_upload_file" />
                                                        <input type="hidden" wire:ignore value="{{ !empty($user['image']) ? $user['image'] : '' }}" name="feedback_users[{{$key}}][image]" id="feedback_users{{$key}}image"/>
                                                        {{__('pages.upload_photo')}}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="at-plus-icon at-btn" id="add_more_block" wire:click.prevent="addMoreItem('feedback_users')" href="#"><i class="icon-plus"></i>{{__('pages.add_item')}}</a>

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