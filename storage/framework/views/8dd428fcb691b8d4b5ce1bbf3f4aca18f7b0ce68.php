<div class="col-lg-4 col-md-12 tb-md-40">
    <div class="tb-dbholder tb-packege-setting">
        <div class="tb-dbbox tb-dbboxtitle">
            <h5>
                 <?php echo e($edit_id ? __('general.update_page') : __('general.add_page')); ?>

            </h5>
        </div>
        <div class="tb-dbbox">
            <form class="tb-themeform">
                <fieldset>
                    <div class="tb-themeform__wrap">
                        <div class="form-group">
                            <label class="tb-label"><?php echo e(__('general.page_name')); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  wire:model.defer="name" required placeholder="<?php echo e(__('general.page_name')); ?>">
                            <?php $__errorArgs = ['name'];
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
                            <label class="tb-label"><?php echo e(__('general.page_title')); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  wire:model.defer="title" required placeholder="<?php echo e(__('general.page_title')); ?>">
                            <?php $__errorArgs = ['title'];
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
                            <label class="tb-label"><?php echo e(__('general.page_description')); ?></label>
                            <textarea class="form-control"  wire:model.defer="description" required placeholder="<?php echo e(__('general.page_description')); ?>"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="tb-label"><?php echo e(__('general.page_slug')); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  wire:model.defer="slug" required placeholder="<?php echo e(__('general.page_slug')); ?>">
                            <?php $__errorArgs = ['slug'];
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
                        <?php if($edit_id): ?>
                            <div class="form-group">
                                <label class="tb-label"><?php echo e(__('general.status')); ?>:</label>
                                <div class="tb-email-status">
                                    <span> <?php echo e(__('pages.page_status')); ?> </span>
                                    <div class="tb-switchbtn">
                                        <label for="tb-pagestatus" class="tb-textdes"><span id="tb-textdes"><?php echo e($status == 'publish' ? __('general.active') : __('general.deactive')); ?></span></label>
                                        <input <?php echo e($status == 'publish' ? 'checked' : ''); ?> class="tb-checkaction" type="checkbox" id="tb-pagestatus">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn">
                                <?php echo e($edit_id ? __('general.update_page') : __('general.add_page')); ?>

                            </a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:load', function () {
            $(document).on('click', '.tb-checkaction', function(event){
                let _this = $(this);
                let status = '';
                if(_this.is(':checked')){
                    _this.parent().find('#tb-textdes').html("<?php echo e(__('general.active')); ?>");
                    status = 'publish';
                } else {
                    _this.parent().find('#tb-textdes').html( "<?php echo e(__('general.deactive')); ?>");
                    status = 'draft';
                }
                window.livewire.find('<?php echo e($_instance->id); ?>').set('status', status, true);
            });

        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/sitepages/update.blade.php ENDPATH**/ ?>