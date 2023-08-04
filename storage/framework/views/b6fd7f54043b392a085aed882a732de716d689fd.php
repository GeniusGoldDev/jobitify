<main class="tb-main tb-mainbg">
    <div class="row">
        <div class="col-xl-12">
            <div class="tb-payment-methods">
                <div class="tb-adminp-title">
                    <h6><?php echo e(__('general.profile_title')); ?></h6>
                </div>
                <div class="tb-admin-profile">
                    <div class="tb-admin-imgarea">
                        <?php if(!empty($cropImageUrl)): ?>
							<img src="<?php echo e($cropImageUrl); ?>"> 
						<?php elseif(!empty($old_image)): ?>
                            <?php 
								$file_url = getProfileImageURL($old_image, '172x172');
							?>
							<img src="<?php echo e(asset('storage/'.$file_url)); ?>" alt="">
						<?php else: ?> 
							<img src="<?php echo e(asset('images/default-user.jpg')); ?>" alt="">
						<?php endif; ?>
                        
                        <div wire:ignore class="tb-delete-img">
                            <input id="upload_image" type="file" accept="<?php echo e(!empty($allowImageExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImageExt)) : '*'); ?>" >
                            <label for="upload_image"><?php echo e(__('general.upload_photo')); ?></label>
                            <a href="javascript:void(0)" wire:click.prevent="removePhoto" ><i class="icon-trash-2 tb-trash"></i></a>
                        </div>
                    </div>
                    <div class="tb-admin-infomation">
                        <form class="tb-themeform">
                            <div class="form-group-wrap">
                                <div class="form-group form-group-3half">
                                    <label class="tb-titleinput"><?php echo e(__('general.first_name')); ?></label>
                                    <input type="text" wire:model.defer="first_name" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('general.name_placeholder')); ?>">
                                    <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="tk-errormsg">
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group form-group-3half">
                                    <label class="tb-titleinput"><?php echo e(__('general.last_name')); ?></label>
                                    <input type="text" wire:model.defer="last_name" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('general.lastname_placeholder')); ?>">
                                    <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="tk-errormsg">
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="tb-titleinput"><?php echo e(__('general.email')); ?></label>
                                    <input type="email" wire:model.defer="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('general.email_placeholder')); ?>">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="tk-errormsg">
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="tb-titleinput"><?php echo e(__('general.current_password')); ?></label>
                                    <input type="password" wire:model.defer="current_password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('general.current_password_placeholder')); ?>">
                                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="tk-errormsg">
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="tb-titleinput"><?php echo e(__('general.password')); ?></label>
                                    <input type="password" wire:model.defer="new_password" class="form-control <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('general.password_placeholder')); ?>">
                                    <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="tk-errormsg">
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group form-group-3half ">
                                    <label class="tb-titleinput"><?php echo e(__('general.confirm_password')); ?></label>
                                    <input type="password" wire:model.defer="confirm_password" class="form-control <?php $__errorArgs = ['confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('general.confirm_password')); ?>">
                                    <?php $__errorArgs = ['confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="tk-errormsg">
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn"><?php echo e(__('general.setting_save')); ?></a>
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
                    <h4> <?php echo e(__('profile_settings.crop_profile_photo')); ?> </h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body" id="tk_add_education_frm">
                    <div id="crop_img_area">
                        <div class="preloader-outer" wire:loading="">
                            <div class="tk-preloader">
                                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="tb-form-btn">
                        <div class="tb-savebtn tb-dhbbtnarea ">
                            <a href="javascript:void(0);" id="croppedImage" class="tb-btn"><?php echo e(__('general.save_update')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/croppie.min.js')); ?>"></script>
    <script>
        var image_crop = '';
        document.addEventListener('livewire:load', function () {

            $(document).on("change", "#upload_image", function(e){
                var files = e.target.files;
             
                let fileExt         =  files[0].name.split('.').pop();
                    fileExt         = fileExt ? fileExt.toLowerCase() : '';
                let fileSize        = files[0].size/1024;
                let allowFileSize   = Number("<?php echo e($allowImageSize); ?>")*1024;
                let allowFileExt    = `${<?php echo !empty($allowImageExt) ? json_encode($allowImageExt) : ''; ?>}`;
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
                        error_message = "<?php echo e(__('general.invalid_file_type', ['file_types' => join(', ', array_map(function($ext){return('.'.$ext);},$allowImageExt)) ])); ?>";
                    }
                    else if(fileSize >= allowFileSize){
                        error_message = "<?php echo e(__('general.max_file_size_err', [ 'file_size' => $allowImageSize.'MB' ])); ?>";
                    }
                    showAlert({
                        message     : error_message,
                        type        : 'error',
                        title       : "<?php echo e(__('general.error_title')); ?>" ,
                        autoclose   : 1000,
                        redirectUrl : ''
                    });
                } 
                e.target.value = '';
            });
            $(document).on("click", "#croppedImage", function(e){
                image_crop.croppie('result', {type: 'base64', format: 'jpg'}).then(function(base64) {
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('cropImageUrl', base64);
                });
               
                jQuery('#tk_phrofile_photo').modal('hide');
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/common/css/croppie.css', 
    ]); ?>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/profile/profile.blade.php ENDPATH**/ ?>