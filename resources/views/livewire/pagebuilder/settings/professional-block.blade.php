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

            <div class="accordion at-accordion" id="tb_counter_section" data-block_key="{{$block_key}}">
                @foreach($settings['team_members'] as $key => $member)
                    <div class="accordion-item">
                        <h2 class="accordion-header at-accordion-header">
                            <button class="accordion-button collapsed" type="button">
                                {{__('pages.item_txt',['counter' => $key])}}
                            </button>
                            <span  wire:click.prevent="removeItem('team_members',{{$key}})"><i class="icon-x"></i></span>
                        </h2>
                        <div wire:ignore.self class="accordion-collapse collapse at-accordion-collapse">
                            <div class="accordion-body">
                                <div class="at-themeform__wrap">
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.name') }}</label>
                                        <input type="text" class="form-control" value="{{$member['name']}}" onChange="submitForm('{{$block_key}}')" name="team_members[{{$key}}][name]" placeholder="{{__('pages.name')}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.designation') }}</label>
                                        <input type="text" class="form-control" value="{{$member['designation']}}" onChange="submitForm('{{$block_key}}')" name="team_members[{{$key}}][designation]" placeholder="{{__('pages.designation')}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.facebook_link') }}</label>
                                        <input type="text" class="form-control" value="{{$member['facebook_link']}}" onChange="submitForm('{{$block_key}}')" name="team_members[{{$key}}][facebook_link]" placeholder="{{__('pages.facebook_link')}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.twitter_link') }}</label>
                                        <input type="text" class="form-control" value="{{$member['twitter_link']}}" onChange="submitForm('{{$block_key}}')" name="team_members[{{$key}}][twitter_link]" placeholder="{{__('pages.twitter_link')}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.linkedin_link') }}</label>
                                        <input type="text" class="form-control" value="{{$member['linkedin_link']}}" onChange="submitForm('{{$block_key}}')" name="team_members[{{$key}}][linkedin_link]" placeholder="{{__('pages.linkedin_link')}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.twitch_link') }}</label>
                                        <input type="text" class="form-control" value="{{$member['twitch_link']}}" onChange="submitForm('{{$block_key}}')" name="team_members[{{$key}}][twitch_link]" placeholder="{{__('pages.twitch_link')}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.dribbble_link') }}</label>
                                        <input type="text" class="form-control" value="{{$member['dribbble_link']}}" onChange="submitForm('{{$block_key}}')" name="team_members[{{$key}}][dribbble_link]" placeholder="{{__('pages.dribbble_link')}}">
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="at-label">{{ __('pages.upload_img') }}</label>
                                        <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="settings.team_members.{{$key}}.image">
                                            <div class="preloader-outer" wire:loading wire:target="settings.team_members.{{$key}}.image">
                                                <div class="tk-preloader">
                                                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                                                </div>
                                            </div>
                                            <figure>
                                                @if (!empty($settings['team_members'][$key]['image']) && method_exists($settings['team_members'][$key]['image'],'temporaryUrl'))
                                                    <img src="{{ substr($settings['team_members'][$key]['image']->getMimeType(), 0, 5) == 'image' ? $settings['team_members'][$key]['image']->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $settings['team_members'][$key]['image']->getClientOriginalName() }}">
                                                @elseif(!empty($member['image']))
                                                    <img src="{{ asset($member['image'])}}" alt="">
                                                @else 
                                                    <img src="{{asset('images/default-img.jpg')}}" alt="img">
                                                @endif
                                            </figure>
                                            <div class="at-del-img">
                                                <label for="at_team_members{{$key}}_image">
                                                    <span>
                                                        <input id="at_team_members{{$key}}_image" type="file" wire:model="settings.team_members.{{$key}}.image" accept="image/png, image/gif, image/jpeg" class="at_upload_file" />
                                                        <input type="hidden" wire:ignore value="{{ !empty($member['image']) ? $member['image'] : '' }}" name="team_members[{{$key}}][image]" id="team_members{{$key}}image"/>
                                                        {{__('pages.upload_photo')}}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        @error('settings.team_members.'.$key.'.image')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="at-plus-icon at-btn" id="add_more_block" wire:click.prevent="addMoreItem('team_members')" href="#"><i class="icon-plus"></i>{{__('pages.add_item')}}</a>

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