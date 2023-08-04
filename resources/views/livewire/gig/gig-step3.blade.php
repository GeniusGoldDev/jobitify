<div class="row" wire:key="{{time()}}">
    @include('livewire.gig.gig-creation-sidebar')
    <div class="col-lg-9">
        <div class="tk-project-wrapper tk-gigstep_3">
            <div class="tk-project-box">
                <div class="tk-sectiontitle">
                    <h4>{{__('gig.media_attachment')}}</h4>
                </div>
                <form class="tk-themeform">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                            <div x-data="{ dropFile: false }" class="tk-draganddropwrap tk-freelanerinfo form-group">
                                <div class="tk-draganddrop"
                                x-bind:class="dropFile ? 'tk-opacity' : ''"
                                x-on:drop="dropFile = false"
                                wire:drop.prevent="$emit('file-dropped', $event)"
                                x-on:dragover.prevent="dropFile = true"
                                x-on:dragleave.prevent="dropFile = false">
                                <input class="tk-drag-imagearea" name="file" type="file" id="at_upload_files" accept="{{ !empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*' }}" multiple wire:change="$emit('file-dropped', {'dataTransfer' : { files :  $event.target.files}})" />
            
                                    <svg class="tk-drag-gallery"><rect width="100%" height="100%"></rect></svg>
                                    <div class="tk-dragfile">
                                        <div class="tk-fileareaitem">
                                            <img src="{{ asset('images/image-uploader.jpg') }}" alt="">
                                        </div>
                                        <div class="tk-filearea">
                                            <div wire:loading wire:target="galleryFiles" class="text-center">
                                                <span  >{{__('settings.uploading')}} </span>
                                            </div>
                                            <div wire:loading.remove wire:target="galleryFiles" class="text-center tk-text-flex">
                                                <span>{{__('gig.uploading_desc')}}</span>
                                                <label class="tk-drag-label" for="at_upload_files"><em>{{__('general.click_here')}}</em></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                @error('galleryFiles.*')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            @if($galleryExistingFiles)
                                <ul class="tk-uploadlist">
                                    @foreach($galleryExistingFiles as $key => $single)
                                        <li>
                                            <div class="tk-uploaditem">
                                                <div class="tk-uploaddetail">
                                                    @if(method_exists($single,'getMimeType'))
                                                        <img src="{{ substr($single->getMimeType(), 0, 5) == 'image' ? $single->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $single->getClientOriginalName() }}">
                                                    @else
                                                        <img src="{{ substr($single->mime_type, 0, 5) == 'image' ? asset('storage/'.$single->file_path) : asset('images/file-preview.png') }}" alt="{{ $single->file_name }}">
                                                    @endif
                                                    <span>{{ method_exists($single,'getClientOriginalName') ? $single->getClientOriginalName() : $single->file_name }}</span>
                                                </div>
                                                <a href="javascript:;" wire:click.prevent="removeGalleryFile('{{ $key }}')"><i class="icon-trash-2"></i></a>
                                            </div>
                                        </li>

                                    @endforeach
                                </ul>
                            @endif
                            <div class="form-group">
                                <label class="tk-label"> {{__('gig.add_video_link')}}</label>
                                <div class="tk-placeholderholder">
                                    <input type="url" wire:model.defer="video_url" placeholder="{{__('gig.video_link_placeholder')}}" class="form-control tk-themeinput @error('video_url') tk-invalid @enderror">
                                </div>
                                @error('video_url')
                                    <div class="tk-errormsg">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="tk-form-checkbox">
                                    <input id="downloadable" type="checkbox" class="form-check-input form-check-input-lg" {{ $downloadable ? 'checked' : ''}} value="1" wire:model.defer="downloadable">
                                    <label for="downloadable" class="form-check-label">
                                        <span> {{ __('gig.downloadable') }}  </span>
                                    </label>
                                </div>
                            </div>
                            <div class="downloadable-files {{ !$downloadable ? 'd-none' : '' }}">
                                <div x-data="{ dropFile: false }" class="tk-draganddropwrap tk-freelanerinfo form-group">
                                    <div class="tk-draganddrop"  
                                    x-bind:class="dropFile ? 'tk-opacity' : ''"
                                    x-on:drop="dropFile = false"
                                    wire:drop.prevent="$emit('download-file-dropped', $event)"
                                    x-on:dragover.prevent="dropFile = true"
                                    x-on:dragleave.prevent="dropFile = false">
                                        <svg><rect width="100%" height="100%"></rect></svg>
                                        <input class="tk-drag-imagearea" name="file" type="file" id="at_upload_downloadable" multiple wire:change="$emit('download-file-dropped', {'dataTransfer' : { files :  $event.target.files}})" />
                                        <div class="tk-dragfile">
                                            <div class="tk-fileareaitem">
                                                <img src="{{ asset('images/image-uploader.jpg') }}" alt="">
                                            </div>
                                            <div class="tk-filearea">
                                                <div wire:loading wire:target="downloadFiles" class="text-center">
                                                    <span  >{{__('settings.uploading')}} </span>
                                                </div>
                                                <div wire:loading.remove wire:target="downloadFiles" class="text-center tk-text-flex">
                                                    <span>{{__('gig.uploading_desc')}} </span>
                                                    <label class="tk-drag-label" for="at_upload_downloadable"><em>{{__('general.click_here')}}</em></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    @error('downloadFiles.*')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                @if($downloadExistingFiles)
                                    <ul class="tk-uploadlist">
                                        @foreach($downloadExistingFiles as $key => $single)
                                            <li>
                                                <div class="tk-uploaditem">
                                                    <div class="tk-uploaddetail">
                                                        @if(method_exists($single,'getMimeType'))
                                                            <img src="{{ substr($single->getMimeType(), 0, 5) == 'image' ? $single->temporaryUrl() : asset('images/file-preview.png') }}" alt="{{ $single->getClientOriginalName() }}">
                                                        @else
                                                            <img src="{{ substr($single->mime_type, 0, 5) == 'image' ? asset('storage/'.$single->file_path) : asset('images/file-preview.png') }}" alt="{{ $single->file_name }}">
                                                        @endif
                                                        <span>{{ method_exists($single,'getClientOriginalName') ? $single->getClientOriginalName() : $single->file_name }}</span>
                                                    </div>
                                                    <a href="javascript:;" wire:click.prevent="removedownloadFiles('{{ $key }}')"><i class="icon-trash-2"></i></a>
                                                </div>
                                            </li>

                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>        
                    </fieldset>        
                </form>        
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:;" wire:click.prevent="updateStep(2)" class="tk-btnline"><i class=" icon-chevron-left"></i>{{ __('gig.go_back') }}</a>
                    <a href="javascript:;" wire:click.prevent="updateStep( {{ $step + 1 }} )"  class="tk-btn-solid-lg-lefticon">
                        {{__('gig.continue')}}
                        <i class="icon-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
