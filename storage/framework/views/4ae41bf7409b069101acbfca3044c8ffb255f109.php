<main class="tb-main tb-mainbg tk-paymentsection">
    <div class="row">
        <div class="col-lg-4 col-md-12 tb-md-40">
            <div class="tb-dbholder tb-package-settings">
                <div class="tb-payment-methods_title">
                    <h6><?php echo e(__('settings.checkout_method')); ?></h6>
                </div>
                <form class="tb-todobox">
                    <fieldset>
                        <div class="form-group-wrap">
                            <div class="form-group">
                                <label class="tk-label"><?php echo e(__('settings.method_placeholder')); ?></label>
                                <div class="tk-settingarea <?php $__errorArgs = ['method_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <div wire:ignore class="tb-select">
                                        <select id="tk_checkout_method" data-hide_search_opt="true" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.method_placeholder')); ?>" class="form-control tk-select2">
                                            <option></option>
                                            <option value="escrow" <?php echo e($method_type == 'escrow' ? 'selected' : ''); ?> ><?php echo e(__('settings.method_escrow')); ?></option>
                                            <option value="others" <?php echo e($method_type == 'others' ? 'selected' : ''); ?> ><?php echo e(__('settings.others')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['method_type'];
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
                            <div class="form-group tb-updatesave-btn">
                                <a href="javascript:void(0);" wire:click.prevent="saveMethod" class="tb-btn ">
                                    <?php echo e(__('settings.save_method')); ?>

                                </a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <?php if(!empty($available_methods)): ?>
                <div class="tb-dbholder tb-package-settings">
                    <div class="tb-payment-methods_title">
                        <h6><?php echo e(__('settings.payment_methods')); ?></h6>
                    </div>
                    <ul class="tb-payment-methods_list">
                        <?php $__currentLoopData = $available_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method_key => $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <div class="tb-payment-items">
                                    <div class="tb-paymethod-items">
                                        <img src="<?php echo e($method['image']); ?>" alt="<?php echo e($method['name']); ?>">
                                        <h6><?php echo e($method['name']); ?></h6>
                                    </div>
                                    <div class="tb-paymethod-items">
                                        <?php if($method_key != 'escrow'): ?>
                                            <div class="checkbox">
                                                <input type="checkbox" id="<?php echo e($method_key.'_method'); ?>" wire:model="available_methods.<?php echo e($method_key); ?>.status">
                                                <label for="<?php echo e($method_key.'_method'); ?>" class="text"></label>
                                            </div>
                                        <?php endif; ?>
                                        <div class="tb-paymethodedit">
                                            <a href="javascript:void(0);" wire:click.prevent="editMethod('<?php echo e($method_key); ?>')" ><?php echo e(__('settings.edit')); ?> <i class="icon-edit-3"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-8 col-md-12 tb-md-60" wire:loading.class="tk-section-preloader" wire:target="editMethod">
            <div class="preloader-outer" wire:loading wire:target="editMethod">
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
            <?php if($edit_method == 'escrow'): ?>
                <div class="tb-payment-methods">
                    <div class="tb-payment-methods_title">
                        <h6><?php echo e(__('settings.escrow_payment_title')); ?></h6>
                    </div>
                    <form class="tb-themeform tb-payment-settings">
                        <fieldset>
                            <div class="form-group-wrap">
                                <div class="form-group form-group-half">
                                    <label class="tk-label"><?php echo e(__('settings.escrow_email')); ?></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['escrow.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="escrow.email" placeholder="<?php echo e(__('settings.escrow_email_placeholer')); ?>">
                                    <?php $__errorArgs = ['escrow.email'];
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
                                    <span class="tb-form-span"> <?php echo __('settings.escrow_email_desc', ['escrow_site_link' => '<a target="_blank" href="https://www.escrow.com/login-page">'. __("settings.escrow_site").' </a>']); ?></span>
                                </div>
                                <div class="form-group form-group-half">
                                    <label class="tk-label"><?php echo e(__('settings.escrow_api_key')); ?></label>
                                    <input type="text" wire:model.defer="escrow.api_key" class="form-control <?php $__errorArgs = ['escrow.api_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('settings.escrow_api_key_placeholer')); ?>">
                                    <?php $__errorArgs = ['escrow.api_key'];
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
                                    <span class="tb-form-span"><?php echo __('settings.api_key_desc',['get_api_key'=> '<a target="_blank" href="https://www.escrow.com/">'. __("checkout.escrow_site_title").' </a>' ]); ?></span>
                                </div>
                                <div class="form-group ">
                                    <label class="tk-label"><?php echo e(__('settings.escrow_url')); ?></label>
                                    <input type="text" wire:model.defer="escrow.api_url" class="form-control" placeholder="<?php echo e(__('settings.escrow_url_placeholer')); ?>">
                                    <?php $__errorArgs = ['escrow.api_url'];
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
                                    <span class="tb-form-span">
                                        <?php echo __('settings.escrow_url_desc',
                                            [
                                                'production_url'   => '<a target="_blank" href="https://api.escrow.com/">'. __("settings.escrow_production_url").' </a>',
                                                'testing_url'      => '<a target="_blank" href=" https://api.escrow-sandbox.com/">'. __("settings.escrow_testing_url").' </a>'
                                            ]); ?>

                                    </span>
                                </div>
                                <div class="form-group form-group-3half">
                                    <label class="tk-label"><?php echo e(__('settings.currency')); ?></label>
                                    <div wire:ignore class="tb-select border-0">
                                        <select id="tk_currency" data-hide_search_opt="true" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.currency')); ?>" class="form-control tk-select2">
                                            <option></option>
                                            <?php $__currentLoopData = $currency_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" <?php echo e($escrow['currency'] == $key ? 'selected' : ''); ?> ><?php echo e($currency); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <?php $__errorArgs = ['escrow.currency'];
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
                                    <label class="tk-label"><?php echo e(__('settings.inspection_period')); ?></label>
                                    <div wire:ignore class="tb-select">
                                        <select id="tk_insp_period" data-hide_search_opt="true" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.insp_period_placeholder')); ?>" class="form-control tk-select2">
                                            <option></option>
                                            <?php $__currentLoopData = $inspection_day_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" <?php echo e($escrow['inspection_period'] == $key ? 'selected' : ''); ?> ><?php echo e($day); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <?php $__errorArgs = ['escrow.inspection_period'];
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
                                    <label class="tk-label"><?php echo e(__('settings.fee_paid_by')); ?></label>
                                    <div wire:ignore class="tb-select border-0">
                                        <select id="tk_fees_payer" data-hide_search_opt="true" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.fee_paid_by_placeholder')); ?>" class="form-control tk-select2">
                                            <option></option>
                                            <?php $__currentLoopData = $fee_paid_by_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" <?php echo e($escrow['fees_payer'] == $key ? 'selected' : ''); ?> ><?php echo e($day); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <?php $__errorArgs = ['escrow.fees_payer'];
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
                                <div class="tb-updatesave-btn">
                                    <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                        <?php echo e(__('settings.save_setting')); ?>

                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    
                </div>
            <?php elseif($edit_method == 'stripe'): ?>
                <div class="tb-payment-methods">
                    <div class="tb-payment-methods_title">
                        <h6><?php echo e(__('settings.stipe_payment_title')); ?></h6>
                    </div>
                    <form class="tb-themeform tb-payment-settings">
                        <fieldset>
                            <div class="form-group-wrap">
                                <div class="form-group form-group-half">
                                    <label class="tk-label"><?php echo e(__('settings.stripe_id')); ?></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['stripe.stripe_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="stripe.stripe_key" placeholder="<?php echo e(__('settings.stipe_id_placeholer')); ?>">
                                    <?php $__errorArgs = ['stripe.stripe_key'];
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
                                <div class="form-group form-group-half">
                                    <label class="tk-label"><?php echo e(__('settings.stripe_key')); ?></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['stripe.stripe_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="stripe.stripe_secret" placeholder="<?php echo e(__('settings.stipe_key_placeholer')); ?>">
                                    <?php $__errorArgs = ['stripe.stripe_secret'];
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
                                <div class="form-group form-group-half">
                                    <label class="tk-label"><?php echo e(__('settings.stripe_webook')); ?></label>
                                    <input type="text" class="form-control" wire:model.defer="stripe.stripe_webhook_secret" placeholder="<?php echo e(__('settings.stripe_webook_placeholer')); ?>">
                                </div>
                                <div class="form-group form-group-half">
                                    <label class="tk-label"><?php echo e(__('settings.stripe_currency')); ?></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['stripe.cashier_currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="stripe.cashier_currency" placeholder="<?php echo e(__('settings.currency_placeholder')); ?>">
                                    <span class="tb-form-span"><?php echo e(__('settings.srtipe_currency_desc')); ?> </span>
                                </div>
                                <div class="tb-updatesave-btn">
                                    <a href="javascript:void(0);" wire:click.prevent="updateStripeSetting" class="tb-btn ">
                                        <?php echo e(__('settings.save_setting')); ?>

                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            <?php else: ?>
                <div class="tb-payment-methods tb-emptypaysetting"> 
                    <img class="tb-empty-img" src="<?php echo e(asset('images/empty.png')); ?>" alt="images">
                    <h2 class="tb-empty"><?php echo __('settings.empty_setting_desc', ['edit_btn_txt' => '<a href="javascript:;">'. __("settings.edit_txt").' <i class="icon-edit-3"></i></a>']); ?></h2>
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>
<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('livewire:load', function () {
        iniliazeSelect2Scrollbar();
        jQuery('#tk_checkout_method').on('change', function (e) {
            let method = jQuery('#tk_checkout_method').select2("val");
            window.livewire.find('<?php echo e($_instance->id); ?>').set('method_type', method);
        });
        window.addEventListener('editMethod', function (event){
            iniliazeSelect2Scrollbar();

            

            jQuery('#tk_currency').on('change', function (e) {
                let currency = jQuery('#tk_currency').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('escrow.currency', currency, true);
            });

            jQuery('#tk_insp_period').on('change', function (e) {
                let value = jQuery('#tk_insp_period').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('escrow.inspection_period', value, true);
            });

            jQuery('#tk_fees_payer').on('change', function (e) {
                let value = jQuery('#tk_fees_payer').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('escrow.fees_payer', value, true);
            });
        });

    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/payment/payment-methods.blade.php ENDPATH**/ ?>