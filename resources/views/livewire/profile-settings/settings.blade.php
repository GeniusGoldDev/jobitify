
<main class="tb-main-bg">
    <section class="tk-main-section tk-main-bg">
        <div class="preloader-outer" wire:loading wire:target="update,updateIdentification,updateBillingInfo,updatePassword,updatePrivacyInfo,deactiveAccount">
            <div class="tk-preloader">
                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
            </div>
        </div>
        <div class="container">
            <div class="gy-lg-0 gy-4 row">
                <div class="col-lg-4 col-xl-3">
                    <aside>
                        <div class="tb-asideholder">
                            <div class="tb-asidebox tb-settingtabholder">
                                <ul class="tb-settingtab">
                                    <li class="{{ $tab == 'profile-settings' ? 'active' : '' }}">
                                        <a href="javascript:voide(0)" wire:click.prevent="updateTab('profile-settings')"><i class="icon-user"></i>{{__('profile_settings.profile_settings')}}</a>
                                    </li>
                                    <li class="{{ $tab == 'identity-verification' ? 'active' : '' }}">
                                        <a href="javascript:voide(0)" wire:click.prevent="updateTab('identity-verification')" ><i class="icon-check-square"></i>{{__('profile_settings.identity_verification')}}</a>
                                    </li>
                                    <li class="{{ $tab == 'billing-information' ? 'active' : '' }}">
                                        <a href="javascript:voide(0)" wire:click.prevent="updateTab('billing-information')" ><i class="icon-credit-card"></i>{{__('profile_settings.billing_information')}}</a>
                                    </li>
                                    <li class="{{ $tab == 'account-settings' ? 'active' : '' }}">
                                        <a href="javascript:voide(0)" wire:click.prevent="updateTab('account-settings')" ><i class="icon-settings"></i>{{__('profile_settings.account_setting')}}</a>
                                    </li>
                                    @if($userRole == 'seller')
                                        <li class="{{ $tab == 'portfolio-settings' ? 'active' : '' }}">
                                            <a href="javascript:voide(0)" wire:click.prevent="updateTab('portfolio-settings')" ><i class="icon-sliders"></i>{{__('profile_settings.portfolio_settings')}}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
                @include('livewire.profile-settings.'.$tab)
            </div>
        </div>
    </section>
</main>

@push('scripts')
<script defer src="{{ asset('common/js/select2.min.js')}}"></script>
<script defer src="{{ asset('js/vendor/litepicker.js')}}"></script>
<script defer src="{{ asset('common/js/croppie.min.js')}}"></script>
<script defer src="{{ asset('pagebuilder/js/tinymce/tinymce.min.js') }}"></script>
<script defer src="{{ asset('js/app.js') }}"></script>
    <script>
        var image_crop = '';

        function deletePortfolio( id ){
            let title           = '{{ __("general.confirm") }}';
            let content         = '{{ __("general.confirm_content") }}';
            let action          = 'deletePortfolio';
            let type_color      = 'red';
            let btn_class      = 'danger';
            ConfirmationBox({title, content, action, id,  type_color, btn_class})
        }

        function ConfirmDeactiveAccount( id = '' ){
            let title           = '{{ __("general.confirm") }}';
            let content         = '{{ __("general.confirm_content") }}';
            let action          = 'deactiveAccount';
            let type_color      = 'red';
            let btn_class       = 'success';
            ConfirmationBox({title, content, action, id, type_color, btn_class})
        }

        document.addEventListener('livewire:load', function () {
            
            $(document).on("click", "#tk-accordioneditedu .tk-accordion_title", function(e){
                let _this = $(this);
                jQuery('#tk-accordioneditedu .tk-accordion_title').each(function(index, item) {
                    let __this = $(this);
                    __this.removeClass('tk-education-veiw')
                });
                let innerSection = _this.find('div[aria-expanded="true"]');
                if(innerSection.length){
                    _this.addClass('tk-education-veiw');
                }
            });

            $(document).on("click", '#tb_deactive_profile', function(e){
                ConfirmDeactiveAccount();
            });
            // for portfolio
            window.addEventListener('portfolio-popup', event => {
                jQuery('#tk_portfolio_detail').modal(event.detail);
            });

            $(document).on("click", ".tk-delete-portfolio", function(e){
                let _this   = $(this);
                let id      = _this.data('id');
                if(Number(id)){
                    deletePortfolio(id);
                }
            });

            window.livewire.on('portfolio-dropped-file', (event) => {
                if (event.dataTransfer.files.length > 0) {
                    const files = event.dataTransfer.files;
                    @this.upload('portfolioFiles', files[0],
                        (uploadedFilename) => {
                            @this.emit('Updating', false);
                        }, (error) => {
                            console.log(error)
                            @this.emit('Updating', false);
                        }, (event) => {
                        }
                    )
                    $('#at_prtf_upload_files').val("");
                }
            });
            
            // end for portfolio
            Livewire.hook('message.processed', (message, component) => {
                $('#billing-state').select2( { allowClear: true, });
                iniliazeSelect2Scrollbar();
                $('#billing-state').on('change', function (e) {
                    let state_id = $('#billing-state').select2("val");
                    @this.set('billing_info.state_id', state_id,true);
                });
            });

            window.livewire.on('file-dropped', (event) => {
                if (event.dataTransfer.files.length > 0) {
                    const files = event.dataTransfer.files;
                    @this.set('isUploading', true);
                    @this.uploadMultiple('files', files,
                        (uploadedFilename) => {
                            @this.set('isUploading', false);
                        }, (error) => {
                            console.log(error)
                            @this.set('isUploading', false);
                        }, (event) => {
                        }
                    )
                }
            });


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
                        error_message = "{{ __('general.invalid_file_type', ['file_types' => join(',', array_map(function($ext){return('.'.$ext);},$allowImageExt)) ])}}";
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

            function initSelect2(){
                jQuery('.tk-select2').each(function(index, item) {
                    let _this = jQuery(this);
                    _this.select2( {
                        allowClear: true,
                        closeOnSelect: false,
                    });
                });

                $('#tk-country').on('change', function (e) {
                    let country = $('#tk-country').select2("val");
                    @this.set('profile_settings.country', country, true);
                });

                $('#billing-country').on('change', function (e) {
                    let country_id = $('#billing-country').select2("val");
                    @this.set('billing_info.country_id', country_id);
                });

                $('#billing-state').on('change', function (e) {
                    let state_id = $('#billing-state').select2("val");
                    @this.set('billing_info.state_id', state_id, true);
                });
                
                $('#tk_reason').on('change', function (e) {
                    let reason = $('#tk_reason').select2("val");
                    @this.set('account_settings.reason', reason,true);
                });

                $('#pro_sellertype ').on('change', function (e) {
                    let seller_type = $('#pro_sellertype ').select2("val");
                    @this.set('profile_settings.seller_type', seller_type, true);
                });

                $('#pro_english_level ').on('change', function (e) {
                    let egnlish_level = $('#pro_english_level ').select2("val");
                    @this.set('profile_settings.english_level', egnlish_level ,true);
                });

                $('#pro_skill ').on('change', function (e) {
                    let skill_ids = $('#pro_skill ').select2("val");
                    @this.set('profile_settings.skill_ids', skill_ids, true);
                });

                $('#pro_languages ').on('change', function (e) {
                    let pro_languages = $('#pro_languages ').select2("val");
                    @this.set('profile_settings.language_ids', pro_languages, true);
                });
            }

            function initializeRecord(){
                setTimeout(() => {
                    initSelect2();
                    setSeacrhPlaceholder();
                    iniliazeSelect2Scrollbar(); 
                }, 500);
            }

            initializeRecord();
            
            window.addEventListener('reset-education-form', event => { 
                $('.text-danger').remove();
                $('.tk-invalid').removeClass('tk-invalid');
            });
            window.addEventListener('initTab1-js', event => { 
                initSelect2();
                setSeacrhPlaceholder();
            });
            window.addEventListener('initTab3-js', event => { 
                initializeRecord();
            });

            window.addEventListener('initTab4-js', event => { 
                initializeRecord();
            });

            window.addEventListener('croppedImage', event => { 
                image_crop.croppie('result', {type: 'base64', format: 'jpg'}).then(function(base64) {
                    @this.set('cropImageUrl', base64);
                    jQuery('#tk_phrofile_photo').modal('hide');
                });
            });

            window.addEventListener('education-popup', event => { 
                setTimeout(() => {
                    jQuery('.tk-datepicker').each( (index, item ) => {
                    let _this = jQuery(this);
                    let modelName = ['education_detail.deg_start_date','education_detail.deg_end_date'];
                    new Litepicker({
                        element: document.getElementById(item.id),
                        format:'DD-MM-YYYY',
                        autoRefresh : true,
                        maxDate: new Date(),
                        tooltipText: {
                            one: "night",
                            other: "nights",
                        },
                        setup: (picker) => {
                            picker.on('selected', (date) => {
                                let slectedDate = new Date(date.dateInstance)
                                let d = slectedDate.getDate();
                                let m = slectedDate.getMonth() + 1;
                                let y = slectedDate.getFullYear();
                                let dateString = (d <= 9 ? '0' + d : d) + '-' + (m <= 9 ? '0' + m : m) + '-' + y;
                                @this.set(modelName[index].toString(), dateString, true)
                            });
                        },
                    });
                });
                }, 500);
                            
                jQuery('#tb_educationaldetail').modal(event.detail);
            });

            let title           = '{{ __("general.confirm") }}';
            let listenerName    = 'delete-education-confirm';
            let content         = '{{ __("general.confirm_content") }}';
            let action          = 'deleteEducationRecord'; 
            confirmAlert({title,listenerName, content, action});

        });
    </script> 
@endpush

@push('styles')
    @vite([
        'public/common/css/croppie.css', 
        'public/pagebuilder/css/tinymce/tinymce.css', 
    ])
@endpush