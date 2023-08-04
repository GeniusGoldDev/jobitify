<div class="col-lg-8 col-xl-9" wire:key="account-settings">
    <?php if(session()->has('message')): ?>
		<div class="alert alert-<?php echo e(session('type')); ?>"> <?php echo e(session('message')); ?> </div>
	<?php endif; ?>
    <div class="tb-dhb-account-settings">
        <div class="tb-dhb-mainheading">
            <h2><?php echo e(__('account_settings.heading')); ?></h2>
        </div>
        <div class="tb-profile-settings-box tb-changepassword">
            <div class="tb-tabtasktitle">
                <h5><?php echo e(__('account_settings.change_password')); ?></h5>
            </div>
            <div class="tb-dhb-box-wrapper">
                <div class="tk-deactive-holder tk-changepassword">
                        <div class="form-group form-group_vertical">
                            <label class="tk-label tk-required"><?php echo e(__('account_settings.current_password')); ?></label>
                            <input type="password" class="form-control <?php $__errorArgs = ['account_settings.current_pass'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="account_settings.current_pass" name="current_password" placeholder="<?php echo e(__('account_settings.current_pass_placeholder')); ?>" />
                            <?php $__errorArgs = ['account_settings.current_pass'];
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
                        <div class="form-group form-group_vertical">
                            <label class="tk-label tk-required"><?php echo e(__('account_settings.new_password')); ?></label>
                            <input type="password" class="form-control <?php $__errorArgs = ['account_settings.new_pass'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="account_settings.new_pass" name="new_password" placeholder="<?php echo e(__('account_settings.new_password_placeholder')); ?>" />
                            <?php $__errorArgs = ['account_settings.new_pass'];
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
                        <div class="form-group form-group_vertical">
                            <label class="tk-label tk-required"><?php echo e(__('account_settings.retype_password')); ?></label>
                            <input type="password" class="form-control <?php $__errorArgs = ['account_settings.retype_pass'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  wire:model.defer="account_settings.retype_pass" name="retype_pass_placeholder" placeholder="<?php echo e(__('account_settings.retype_pass_placeholder')); ?>" />
                            <?php $__errorArgs = ['account_settings.retype_pass'];
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
                </div>
                <div class="tb-profileform__holder">
                    <div class="tb-dhbbtnarea tb-dhbbtnareav2">
                        <em><?php echo e(__('account_settings.button_desc')); ?></em> 
                        <a href="javascript:void(0);" wire:click.prevent="updatePassword"  class="tb-btn"> <?php echo e(__('account_settings.update_button')); ?> </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="tb-profile-settings-box tb-privacy-wrapper">
            <div class="tb-tabtasktitle">
                <h5><?php echo __('account_settings.privacy_notification'); ?> </h5>
            </div>
            <div class="tb-dhb-box-wrapper">
                <div class="tb-profileform__holder">
                    <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                        <div class="form-group form-group_vertical">
                            <label class="tk-label tk-required"><?php echo e(__('account_settings.add_hourly_rate')); ?></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['account_settings.hourly_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="account_settings.hourly_rate" placeholder="<?php echo e(__('account_settings.hourly_rate_placeholder')); ?>" />
                            <?php $__errorArgs = ['account_settings.hourly_rate'];
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
                    <?php endif; ?>
                    <div class="form-group form-group_vertical">
                        
                        <div class="tb-profileform__content tb-formcheckbox">
                            <label class="tb-titleinput"><?php echo e(__('account_settings.visible_photo_desc')); ?></label>
                            <div class="tb-onoff">
                                <input type="checkbox" value="1" wire:model.defer="account_settings.show_image" id="deactivate_profile" name="deactivate_profile" />
                                <label for="deactivate_profile"
                                    ><em><i></i></em><span class="tb-enable"><?php echo e(__('general.enable')); ?></span><span class="tb-disable"><?php echo e(__('general.disable')); ?></span></label
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tb-profileform__holder">
                    <div class="tb-dhbbtnarea tb-dhbbtnareav2">
                        <em><?php echo e(__('account_settings.button_desc')); ?></em> 
                        <a href="javascript:void(0);" wire:click.prevent="updatePrivacyInfo" id="tb_update_profile" class="tb-btn"> <?php echo e(__('account_settings.update_button')); ?> </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Deactive account code commited -->
    </div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/profile-settings/account-settings.blade.php ENDPATH**/ ?>