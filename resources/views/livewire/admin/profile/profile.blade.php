<main class="tb-main tb-mainbg">
    <div class="row">
        <div class="col-xl-12">
            <div class="tb-payment-methods">
                <div class="tb-adminp-title">
                    <h6>{{ __('general.profile_title') }}</h6>
                </div>
                <div class="tb-admin-profile">
                    <div class="tb-admin-imgarea">
                        @if (!empty($cropImageUrl))
							<img src="{{ $cropImageUrl }}"> 
						@elseif(!empty($old_image))
                            @php 
								$file_url = getProfileImageURL($old_image, '172x172');
							@endphp
							<img src="{{ asset('storage/'.$file_url) }}" alt="">
						@else 
							<img src="{{ asset('images/default-user.jpg')  }}" alt="">
						@endif
                        
                        <div wire:ignore class="tb-delete-img">
                            <input id="upload_image" type="file" accept="{{ !empty($allowImageExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImageExt)) : '*' }}" >
                            <label for="upload_image">{{ __('general.upload_photo') }}</label>
                            <a href="javascript:void(0)" wire:click.prevent="removePhoto" ><i class="icon-trash-2 tb-trash"></i></a>
                        </div>
                    </div>
                    <div class="tb-admin-infomation">
                        <form class="tb-themeform">
                            <div class="form-group-wrap">
                                <div class="form-group form-group-3half">
                                    <label class="tb-titleinput">{{ __('general.first_name') }}</label>
                                    <input type="text" wire:model.defer="first_name" class="form-control @error('first_name') tk-invalid @enderror" placeholder="{{ __('general.name_placeholder') }}">
                                    @error('first_name')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half">
                                    <label class="tb-titleinput">{{ __('general.last_name') }}</label>
                                    <input type="text" wire:model.defer="last_name" class="form-control @error('last_name') tk-invalid @enderror" placeholder="{{ __('general.lastname_placeholder') }}">
                                    @error('last_name')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="tb-titleinput">{{ __('general.email') }}</label>
                                    <input type="email" wire:model.defer="email" class="form-control @error('email') tk-invalid @enderror" placeholder="{{ __('general.email_placeholder') }}">
                                    @error('email')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="tb-titleinput">{{ __('general.current_password') }}</label>
                                    <input type="password" wire:model.defer="current_password" class="form-control @error('current_password') tk-invalid @enderror" placeholder="{{ __('general.current_password_placeholder') }}">
                                    @error('current_password')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="tb-titleinput">{{ __('general.password') }}</label>
                                    <input type="password" wire:model.defer="new_password" class="form-control @error('new_password') tk-invalid @enderror" placeholder="{{ __('general.password_placeholder') }}">
                                    @error('new_password')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="tb-titleinput">{{ __('general.confirm_password') }}</label>
                                    <input type="password" wire:model.defer="confirm_password" class="form-control @error('confirm_password') tk-invalid @enderror" placeholder="{{ __('general.confirm_password') }}">
                                    @error('confirm_password')
                                        <div class="tk-errormsg">
                                            <span>{{$message}}</span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn">{{ __('general.setting_save') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore class="modal fade tb-addonpopup" id="tk_phrofile_photo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered tb-modaldialog" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <h4> {{ __('profile_settings.crop_profile_photo') }} </h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body" id="tk_add_education_frm">
                    <div id="crop_img_area">
                        <div class="preloader-outer" wire:loading="">
                            <div class="tk-preloader">
                                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                            </div>
                        </div>
                    </div>
                    <div class="tb-form-btn">
                        <div class="tb-savebtn tb-dhbbtnarea ">
                            <a href="javascript:void(0);" id="croppedImage" class="tb-btn">{{__('general.save_update')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
    <script defer src="{{ asset('common/js/croppie.min.js')}}"></script>
    <script>
        var image_crop = '';
        document.addEventListener('livewire:load', function () {

            $(document).on("change", "#upload_image", function(e){
                var files = e.target.files;
             
                let fileExt         =  files[0].name.split('.').pop();
                    fileExt         = fileExt ? fileExt.toLowerCase() : '';
                let fileSize        = files[0].size/1024;
                let allowFileSize   = Number("{{$allowImageSize}}")*1024;
                let allowFileExt    = `${{!! !empty($allowImageExt) ? json_encode($allowImageExt) : '' !!}}`;
                    allowFileExt    = allowFileExt.split(',');

                if( allowFileExt.includes(fileExt) && fileSize <= allowFileSize){

                    jQuery('#tk_phrofile_photo').modal('show');
                    jQuery('#tk_phrofile_photo .modal-body .preloader-outer').css({ 
                        display: 'block', 
                        position: 'absolute', 
                        background: 'rgb(255 255 255 / 98%)'
                    });

                    var reader,file,url;

                    if(!image_crop){
                        image_crop = jQuery('#crop_img_area').croppie({
                            viewport: {
                                width: 300,
                                height: 300,
                                type:'square'
                            },
                            boundary:{
                                width: 500,
                                height: 300
                            }
                        });
                    }

                    if (files && files.length > 0) {
                        file = files[0];
                        var reader = new FileReader();
                        
                        reader.onload = e => {
                            setTimeout(() => {
                                image_crop.croppie('bind', { 
                                    url: e.target.result
                                });
                                setTimeout(() => {
                                    jQuery('#tk_phrofile_photo .modal-body .preloader-outer').css({ display: 'none'});
                                }, 100);
                                
                            }, 500);
                            
                        }
                        reader.readAsDataURL(file);
                    }
                } else {
                    let error_message = '';
                     if(!allowFileExt.includes(fileExt)){
                        error_message = "{{ __('general.invalid_file_type', ['file_types' => join(', ', array_map(function($ext){return('.'.$ext);},$allowImageExt)) ])}}";
                    }
                    else if(fileSize >= allowFileSize){
                        error_message = "{{ __('general.max_file_size_err', [ 'file_size' => $allowImageSize.'MB' ])}}";
                    }
                    showAlert({
                        message     : error_message,
                        type        : 'error',
                        title       : "{{__('general.error_title')}}" ,
                        autoclose   : 1000,
                        redirectUrl : ''
                    });
                } 
                e.target.value = '';
            });
            $(document).on("click", "#croppedImage", function(e){
                image_crop.croppie('result', {type: 'base64', format: 'jpg'}).then(function(base64) {
                    @this.set('cropImageUrl', base64);
                });
               
                jQuery('#tk_phrofile_photo').modal('hide');
            });
        });
    </script>
@endpush
@push('styles')
    @vite([
        'public/common/css/croppie.css', 
    ])
@endpush
