<div class="col-lg-8 col-xl-9" wire:key="identity-verification">
	<div class="tb-dhb-profile-settings">
        @if( $isVerifiedAcc == 'pending' && !empty($verify_reject_reason) )
            <div class="tk-notify tk-notify-alert">
                <div class="tk-notify_title">
                    <figure>
                        <img src="{{ asset('images/icons/cross.png') }}" alt="{{__('general.image')}}">
                    </figure>
                    <div class="tk-notify-content">
                        <h5>{{__('identity_verification.verification_rejection')}}</h5>
                        <p>{!! nl2br($verify_reject_reason) !!}</p>
                    </div>
                </div>
            </div>
        @endif   
        @if( $isVerifiedAcc == 'processed' )
            <div class="tb-refunddetailswrap tb-alert-information">
                <div class="tb-orderrequest">
                    <div class="tb-ordertitle">
                        <h5>{{__('identity_verification.woohoo')}}</h5>
                        <p> {{__('identity_verification.sent_verification_request')}} </p>
                    </div>
                    <div class="tb-orderbtn">
                        <a class="tb-btn btn-orange tb-cancel-identity" wire:click.prevent="reuploadIdentification" href="javascript:;">{{__('identity_verification.cancel_reupload')}}</a>
                    </div>
                </div>
            </div>
	    @elseif( $isVerifiedAcc == 'approved' )
            <div class="tk-notify tk-notify-success">
                <div class="tk-notify_title">
                    <figure>
                        <img src="{{ asset('images/icons/success.png') }}" alt="{{__('general.image')}}">
                    </figure>
                    <div class="tk-notify-content">
                        <h5>{{__('identity_verification.hurray')}}</h5>
                        <p>{{__('identity_verification.complete_verification')}}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="tb-dhb-mainheading {{ !empty($verify_reject_reason) ? 'mt-4' : '' }} ">
                <h2>{{ __('identity_verification.heading') }}</h2>
            </div>
            <div class="tk-project-wrapper">
                <div class="tk-profile-form">
                    <form class="tk-themeform" id="tb_identity_save">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group form-group-half">
                                    <label class="tk-label tk-required">{{__('identity_verification.name')}}</label>
                                    <input type="text" class="form-control @error('identity_verification.name') tk-invalid @enderror" wire:model.defer="identity_verification.name" name="name" placeholder="{{__('identity_verification.name')}}" />
                                    @error('identity_verification.name')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-half">
                                    <label class="tk-label tk-required">{{__('identity_verification.contact_number')}}</label>
                                    <input type="text" class="form-control @error('identity_verification.contact_no') tk-invalid @enderror" wire:model.defer="identity_verification.contact_no" name="contact_no" placeholder="{{__('identity_verification.contact_number')}}" />
                                    @error('identity_verification.contact_no')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="tk-label tk-required">{{__('identity_verification.identity_number')}}</label>
                                    <input type="text" class="form-control @error('identity_verification.identity_no') tk-invalid @enderror" wire:model.defer="identity_verification.identity_no" name="identity_no" placeholder="{{__('identity_verification.identity_number')}}" />
                                    @error('identity_verification.identity_no')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="tk-label tk-required">{{__('identity_verification.address')}}</label>
                                    <textarea class="form-control @error('identity_verification.address') tk-invalid @enderror" wire:model.defer="identity_verification.address" name="address" placeholder="{{__('identity_verification.address')}}"></textarea>
                                    @error('identity_verification.address')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span> 
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    <div class="tk-customupload">
                        <div class="tk-attechment-content">
                            <div x-data="{ dropFile: false }" class="tk-draganddropwrap form-group">
                                <div class="tk-draganddrop @error('identity_verification.attachments') tk-invalid @enderror"
                                x-bind:class="dropFile ? 'tk-opacity' : ''"
                                x-on:drop="dropFile = false"
                                wire:drop.prevent="$emit('file-dropped', $event)"
                                x-on:dragover.prevent="dropFile = true"
                                x-on:dragleave.prevent="dropFile = false">
                                    <svg><rect width="100%" height="100%"></rect></svg>
                                    <input class="tk-drag-imagearea"  type="file" id="at_upload_files" accept="{{ !empty($allowFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowFileExt))  : '*' }}" multiple wire:change="$emit('file-dropped', {'dataTransfer' : { files :  $event.target.files}})" />
                                    <div class="tk-dragfile">
                                        <div class="tk-fileareaitem">
                                            <img src="{{ asset('images/image-uploader.jpg') }}" alt="">
                                        </div>
                                        <div class="tk-filearea">
                                        

                                            <div class="text-center {{ !$isUploading ? 'd-none' : '' }}" ><span class="fw-normal">{{__('general.uploading')}}</span></div>
                                            <div class="text-center tk-text-flex {{ $isUploading ? 'd-none' : '' }}"  wire:target="files" >
                                                <span>{{__('general.uploading_desc')}}</span>
                                                <label class="tk-drag-label" for="at_upload_files"> <em>{{__('general.click_here')}}</em></label>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('files.*')
                                <div class="tk-errormsg">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                            @if($existingFiles)
                                <ul class="tk-uploadlist">
                                    @foreach($existingFiles as $key => $single)
                                    @if( getType($single) == 'string' )
                                    @php  
                                        $fileName = basename($single);
                                        $fileExt = pathinfo($single, PATHINFO_EXTENSION);
                                        $imageFileExtension = ['jpg','jpeg','gif','png'];
                                        $filePath = 'images/file-preview.png';

                                        if( in_array( $fileExt, $imageFileExtension ) && file_exists('storage/'.$single) ){
                                            $filePath = 'storage/'.$single;
                                        }

                                    @endphp
                                        <li>
                                            <div class="tk-uploaditem">
                                                <div class="tk-uploaddetail">
                                                    <img src="{{ asset($filePath) }}" alt="">
                                                    <span>{{ $fileName }}</span>
                                                </div>
                                                <a href="javascript:;" wire:click.prevent="removeFile({{ $key }})"><i class="icon-trash-2"></i></a>
                                            </div>
                                        </li>
                                    @else 
                                            <li>
                                                <div class="tk-uploaditem">
                                                    <div class="tk-uploaddetail">
                                                        <img src="{{ substr($single->getMimeType(), 0, 5) == 'image' ? $single->temporaryUrl() : asset('images/file-preview.png') }}" alt="">
                                                        <span>{{ $single->getClientOriginalName() }}</span>
                                                    </div>
                                                    <a href="javascript:;" wire:click.prevent="removeFile({{ $key }})"><i class="icon-trash-2"></i></a>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @error('identity_verification.attachments')
                            <div class="tk-errormsg">
                                <span>{{$message}}</span> 
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="tk-profileform__holder">
                    <div class="tk-dhbbtnarea">
                        <em>{!! __('identity_verification.button_desc') !!}</em>
                        <a href="javascript:void(0);" wire:click.prevent="updateIdentification" class="tb-btn tb_identity_verification">{!! __('general.send_now') !!}</a>
                    </div>
                </div>
            </div>
        @endif
	</div>
</div>