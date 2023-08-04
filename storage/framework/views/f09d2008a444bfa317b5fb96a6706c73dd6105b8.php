<div class="col-lg-4 col-md-12 tb-md-40">
    <div class="tb-dbholder tb-packege-setting">
        <div class="tb-dbbox tb-dbboxtitle">
            <h5><?php echo e($edit_id ? __('email_template.update_email_template') : __('email_template.add_email_template')); ?></h5>
        </div>
        <div class="tb-dbbox">
            <form class="tk-themeform">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <div class="form-group">
                            <?php if( !$edit_id ): ?>
                                <div class="tb-actionselect">
                                    <span><?php echo e(__('email_template.select_template')); ?>: </span>
                                </div>
                                <div class="tb-select border-0">
                                    <select id="template_key" class="form-control">
                                        <option value=""><?php echo e(__('email_template.select_template')); ?></option>
                                        <?php if( !empty($emailTemplates) ): ?>
                                            <?php $__currentLoopData = $emailTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $template['roles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $key = $type .'-'.$role;
                                                    ?>
                                                    <?php if( !in_array($key, $exclude_templates) ): ?>
                                                        <option value="<?php echo e($key); ?>"><?php echo e($template['title']); ?> ( <?php echo e($role); ?> )</option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if( !empty($selected_template) ): ?>
                           <?php $__currentLoopData = $selected_template; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if( $key == 'subject' || $key == 'greeting' ): ?>

                                    <div class="form-group">
                                        <label class="tb-label"><?php echo e($single['title']); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['validated_fields.'.$single['id']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="<?php echo e($single['title']); ?>"  wire:model.defer="validated_fields.<?php echo e($single['id']); ?>" required>
                                        <?php $__errorArgs = ['validated_fields.'.$single['id']];
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
                                <?php elseif( $key == 'info' ): ?> 

                                    <div class="form-group">
                                        <label class="tb-label"><?php echo e($single['title']); ?>

                                            <i class="<?php echo e($single['icon']); ?>"></i>
                                        </label>
                                        <span class="tb-emailsubject-list">
                                            <?php echo $single['desc']; ?>

                                        </span>
                                    </div>
                                <?php elseif( $key == 'content' ): ?>  
                                  
                                    <div class="form-group">
                                        <label class="tb-label"><?php echo e($single['title']); ?></label>
                                        <textarea class="form-control <?php $__errorArgs = ['validated_fields.'.$single['id']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e($single['title']); ?>"  wire:model.defer="validated_fields.<?php echo e($single['id']); ?>" required></textarea>
                                        <?php $__errorArgs = ['validated_fields.'.$single['id']];
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
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <div class="form-group">
                            <label class="tb-label"><?php echo e(__('general.status')); ?>:</label>
                            <div class="tb-email-status">
                                <span><?php echo e(__('email_template.set_email_status')); ?></span>
                                <div class="tb-switchbtn">
                                    <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes"><?php echo e($status == 'active' ? __('general.active') : __('general.deactive')); ?></span></label>
                                    <input class="tb-checkaction" <?php echo e($status == 'active' ? 'checked' : ''); ?> type="checkbox" id="tb-emailstatus">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="saveEmailTemplate" class="tb-btn">
                                <?php echo e($edit_id ?  __('email_template.update_email_template') : __('email_template.add_email_template')); ?>

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
                let _this   = $(this);
                let status  = '';
                if(_this.is(':checked')){
                    _this.parent().find('#tb-textdes').html("<?php echo e(__('general.active')); ?>");
                    status = 'active';
                } else {
                    _this.parent().find('#tb-textdes').html( "<?php echo e(__('general.deactive')); ?>");
                    status = 'deactive';
                }
                window.livewire.find('<?php echo e($_instance->id); ?>').set('status', status, true);
            });
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/email-templates/update.blade.php ENDPATH**/ ?>