<form class="tk-themeform tk-uploadfile-doc">
    <fieldset>
        @role('seller')
            <div class="form-group tb-gigradiobox">
                <div class="tb-radio">
                    <input id="revision" type="radio" wire:model.defer="type" name="record_type" value="revision" >
                    <label for="revision">{{ __('gig.revision') }}</label>
                </div>
                <div class="tb-radio">
                    <input type="radio" id="finalgig" wire:model.defer="type" name="record_type" value="final" >
                    <label for="finalgig">{{ __('gig.final') }}</label>
                </div>
            </div>
        @endrole
        <div class="tk-freelanerinfo form-group">
            <h6>{{ __('gig.upload_gig_docs') }}</h6>
            <div class="tk-upload-resume">
                @if(!empty($existingFiles))
                    <ul class="tk-upload-list">
                        @foreach($existingFiles as $key => $file)
                            <li>
                                <div class="tk-uploaded-img">
                                    <img src="{{ substr($file->getMimeType(), 0, 5) == 'image' ? $file->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $file->getClientOriginalName() }}">
                                    <p>{{$file->getClientOriginalName()}}</p>
                                </div>
                                <a class="tk-remove" href="javascript:;" wire:click.prevent="removeFile('{{ $key }}')"><i class="icon-trash-2"></i></a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <div wire:loading wire:target="activity_files" class="text-center">
                    <span>{{__('settings.uploading')}} </span>
                </div>
                <div class="tk-uploadphoto" wire:loading.remove wire:target="activity_files">
                    <p>{{ __('gig.gig_docs_description') }}</p>
                    <input type="file" wire:model.defer="activity_files" multiple id="activity_files" ><label for="activity_files">{{ __('project.click_here_to_upload') }}</label>
                </div>
            </div>
            @error('activity_files.*')
                <div class="tk-errormsg">
                    <span>{{ $message }}</span> 
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label class="tk-label">{{ __('project.add_comments') }}</label>
            <textarea wire:loading.attr="disabled" wire:target="updateActivity" wire:model.defer="activity_description" class="form-control tk-themeinput @error('activity_description') tk-invalid @enderror"  placeholder="{{ __('project.enter_comments_here') }}"></textarea>
            @error('activity_description')
                <div class="tk-errormsg">
                    <span>{{ $message }}</span> 
                </div>
            @enderror
        </div>
        <div class="form-group tk-form-btn">
            <span>{{ __('general.click') }} <strong>“{{ __('general.send_now')}}”</strong> {{ __('project.button_to_upload_files') }}</span>
            <a href="javascript:void(0);" wire:loading.class="tk-pointer-events-none" wire:click.prevent="updateActivity" class="tk-btn-solid">
                <b wire:loading wire:target="updateActivity"> {{__('general.sending')}} </b>
                <b wire:loading.remove wire:target="updateActivity">{{ __('general.send_now')}} </b>
            </a>
        </div>
    </fieldset>
</form>