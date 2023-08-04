<div class="col-lg-4 col-md-12 tb-md-40">
    <div class="tb-dbholder tb-packege-setting">
        <div class="tb-dbbox tb-dbboxtitle">
            <h5>
                 <?php echo e($editMode ? __('category.update_category') : __('category.add_category')); ?>

            </h5>
        </div>
        <div class="tb-dbbox">
            <form class="tk-themeform">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <div class="form-group">
                            <label class="tb-label"><?php echo e(__('category.title')); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"   wire:model.defer="name" required placeholder="<?php echo e(__('category.title')); ?>">
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
                        <?php if(!empty($categories_tree)): ?>
                            <div class="form-group">
                                <label class="tb-titleinput"><?php echo e(__('category.parent_category')); ?></label>
                                <input class="from-control" type="text" id="category_dropdown-<?php echo e(time()); ?>" placeholder="<?php echo e(__('taxonomy.parent_cat_placeholder')); ?>" autocomplete="off"/>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="tb-label"><?php echo e(__('category.description')); ?></label>
                            <textarea class="form-control" placeholder="<?php echo e(__('category.description')); ?>" wire:model.defer="description" id=""></textarea>
                        </div>
                        <?php if($editMode): ?>
                            <div class="form-group">
                                <label class="tb-label"><?php echo e(__('general.status')); ?>:</label>
                                <div class="tb-email-status">
                                    <span> <?php echo e(__('category.category_status')); ?> </span>
                                    <div class="tb-switchbtn">
                                        <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes"><?php echo e($status == 'active' ? __('general.active') : __('general.deactive')); ?></span></label>
                                        <input <?php echo e($status == 'active' ? 'checked' : ''); ?> class="tb-checkaction" type="checkbox" id="tb-emailstatus">
                                    </div>
                                </div>
                                <?php $__errorArgs = ['status'];
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
                        <div class="form-group">
                            <label class="tb-label"><?php echo e(__('category.upload_photo')); ?> (<?php echo e(__('category.optional')); ?>):</label>
                            <div class="tb-uploadarea tb-uploadbartwo">
                                <ul class="tb-uploadbar">
                                    <li wire:loading wire:target="image" style="display: none" class="tb-uploading">
                                        <span><?php echo e(__('settings.uploading')); ?></span>
                                    </li>
                                    <?php if(!empty($image) && method_exists($image,'temporaryUrl')): ?>
                                        <div  wire:loading.remove class="tb-uploadel tb-upload-two">
                                            <img src="<?php echo e(substr($image->getMimeType(), 0, 5) == 'image' ? $image->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($image->getClientOriginalName()); ?>">
                                            <span><p><?php echo e($image->getClientOriginalName()); ?></p> <a href="javascript:void(0);" wire:click.prevent="removeImage"> <i class="ti-trash"></i></a> </span>
                                        </div>
                                    <?php elseif(!empty($old_image)): ?>
                                       <?php 
                                            $image_path = $old_image['file_path'];
                                            $image_name = $old_image['file_name'];
                                       ?>
                                        <div wire:loading.remove class="tb-uploadel tb-upload-two">
                                            <img src="<?php echo e(asset('storage/'.$image_path)); ?>" alt="<?php echo e($image_name); ?>">
                                            <span><p><?php echo e($image_name); ?></p><a href="javascript:void(0);" wire:click.prevent="removeImage"> <i class="icon-trash-2"></i></a></span>
                                        </div>
                                    <?php endif; ?>
                                </ul>
                                <em> <?php echo e(__('category.image_option',['extension'=> join(',', $allow_image_ext), 'size'=> $allow_image_size.'MB'])); ?>

                                    <label for="file2">
                                        <span>
                                            <input id="file2" type="file" accept="<?php echo e(!empty($allow_image_ext) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allow_image_ext)) : '*'); ?>"  wire:model="image">
        
                                            <?php echo e(__('category.click_here_to_upload')); ?>

                                        </span>
                                    </label>
                                    <?php $__errorArgs = ['image'];
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
                                </em>
                            </div>
                        </div>
                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                <?php echo e($editMode ? __('category.update_category') : __('category.add_category')); ?>

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
            $(document).on('click', '.tb-themeselect .tb-select', function(event) {
                event.stopPropagation();
                $(document).find('.tb-categorytree-dropdown').addClass('tk-custom-scrollbar');
                $(this).next(".tb-themeselect_options").slideToggle();                
            });

            $(document).on('click', '.tb-themeselect_options li label', function(event) {
                let listText = jQuery(this).text();
                $('.tb-themeselect_value').text(listText);
                $(this).parents(".tb-themeselect_options").slideUp();
                $('.tb-categorytree-dropdown').mCustomScrollbar('destroy');
            });

            $(document).on('click', '.tb-checkaction', function(event){
                let _this = $(this);
                let status = '';
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
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/taxonomies/project-categories/update.blade.php ENDPATH**/ ?>