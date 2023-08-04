<div class="col-lg-8 col-xl-9" wire:key="account-settings">
    @if(session()->has('message'))
		<div class="alert alert-{{ session('type') }}"> {{ session('message') }} </div>
	@endif
    <div class="tb-dhb-account-settings">
        <div class="tb-dhb-mainheading">
            <h2>{{__('account_settings.heading')}}</h2>
        </div>
        <div class="tb-profile-settings-box tb-changepassword">
            <div class="tb-tabtasktitle">
                <h5>{{__('account_settings.change_password')}}</h5>
            </div>
            <div class="tb-dhb-box-wrapper">
                <div class="tk-deactive-holder tk-changepassword">
                        <div class="form-group form-group_vertical">
                            <label class="tk-label tk-required">{{__('account_settings.current_password')}}</label>
                            <input type="password" class="form-control @error('account_settings.current_pass') tk-invalid @enderror" wire:model.defer="account_settings.current_pass" name="current_password" placeholder="{{__('account_settings.current_pass_placeholder')}}" />
                            @error('account_settings.current_pass')
                                <div class="tk-errormsg">
                                    <span>{{$message}}</span> 
                                </div>
                            @enderror
                        </div>
                        <div class="form-group form-group_vertical">
                            <label class="tk-label tk-required">{{__('account_settings.new_password')}}</label>
                            <input type="password" class="form-control @error('account_settings.new_pass') tk-invalid @enderror" wire:model.defer="account_settings.new_pass" name="new_password" placeholder="{{__('account_settings.new_password_placeholder')}}" />
                            @error('account_settings.new_pass')
                                <div class="tk-errormsg">
                                    <span>{{$message}}</span> 
                                </div>
                            @enderror
                        </div>
                        <div class="form-group form-group_vertical">
                            <label class="tk-label tk-required">{{__('account_settings.retype_password')}}</label>
                            <input type="password" class="form-control @error('account_settings.retype_pass') tk-invalid @enderror"  wire:model.defer="account_settings.retype_pass" name="retype_pass_placeholder" placeholder="{{__('account_settings.retype_pass_placeholder')}}" />
                            @error('account_settings.retype_pass')
                                <div class="tk-errormsg">
                                    <span>{{$message}}</span> 
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="tb-profileform__holder">
                    <div class="tb-dhbbtnarea tb-dhbbtnareav2">
                        <em>{{ __('account_settings.button_desc') }}</em> 
                        <a href="javascript:void(0);" wire:click.prevent="updatePassword"  class="tb-btn"> {{ __('account_settings.update_button') }} </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="tb-profile-settings-box tb-privacy-wrapper">
            <div class="tb-tabtasktitle">
                <h5>{!! __('account_settings.privacy_notification') !!} </h5>
            </div>
            <div class="tb-dhb-box-wrapper">
                <div class="tb-profileform__holder">
                    @role('seller')
                        <div class="form-group form-group_vertical">
                            <label class="tk-label tk-required">{{__('account_settings.add_hourly_rate')}}</label>
                            <input type="number" class="form-control @error('account_settings.hourly_rate') tk-invalid @enderror" wire:model.defer="account_settings.hourly_rate" placeholder="{{__('account_settings.hourly_rate_placeholder')}}" />
                            @error('account_settings.hourly_rate')
                                <div class="tk-errormsg">
                                    <span>{{$message}}</span> 
                                </div>
                            @enderror
                        </div>
                    @endrole
                    <div class="form-group form-group_vertical">
                        
                        <div class="tb-profileform__content tb-formcheckbox">
                            <label class="tb-titleinput">{{ __('account_settings.visible_photo_desc') }}</label>
                            <div class="tb-onoff">
                                <input type="checkbox" value="1" wire:model.defer="account_settings.show_image" id="deactivate_profile" name="deactivate_profile" />
                                <label for="deactivate_profile"
                                    ><em><i></i></em><span class="tb-enable">{{ __('general.enable') }}</span><span class="tb-disable">{{ __('general.disable') }}</span></label
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tb-profileform__holder">
                    <div class="tb-dhbbtnarea tb-dhbbtnareav2">
                        <em>{{ __('account_settings.button_desc') }}</em> 
                        <a href="javascript:void(0);" wire:click.prevent="updatePrivacyInfo" id="tb_update_profile" class="tb-btn"> {{ __('account_settings.update_button') }} </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Deactive account code commited -->
    </div>
</div>