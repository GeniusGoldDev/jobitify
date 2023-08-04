<div class="col-lg-4 col-md-12 tb-md-40">
    <div class="tb-dbholder tb-packege-setting">
        <div class="tb-dbbox tb-dbboxtitle">
            @if($editMode)
                <h5> {{ __('languages.update_language') }}</h5>
            @else 
                <h5> {{ __('languages.add_language') }}</h5>
            @endif
        </div>
        <div class="tb-dbbox">
            <form class="tk-themeform">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <div class="form-group">
                            <label class="tb-label">{{ __('languages.name') }}</label>
                            <input type="text" class="form-control @error('name') tk-invalid @enderror "  wire:model.defer="name" required placeholder="{{ __('languages.name') }}">
                            @error('name')
                                <div class="tk-errormsg">  
                                    <span>{{ $message }}</span> 
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="tb-label">{{ __('general.description') }}</label>
                            <textarea class="form-control" placeholder="{{ __('general.description') }}" wire:model.defer="description" id=""></textarea>
                        </div>
                        @if($editMode)
                            <div class="form-group">
                                <label class="tb-label">{{ __('general.status') }}:</label>
                                <div class="tb-email-status">
                                    <span>{{__('languages.language_status')}}</span>
                                    <div class="tb-switchbtn">
                                        <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes">{{ $status == 'active' ? __('general.active') : __('general.deactive') }}</span></label>
                                        <input class="tb-checkaction" {{ $status == 'active' ? 'checked' : '' }} type="checkbox" id="tb-emailstatus">
                                    </div>
                                </div>
                                @error('status') 
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span> 
                                    </div>
                                @enderror
                            </div>
                        @endif
                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn "> 
                                @if($editMode) 
                                    {{ __('languages.update_language') }}
                                @else
                                    {{ __('general.add_now') }}
                                @endif
                            </a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>