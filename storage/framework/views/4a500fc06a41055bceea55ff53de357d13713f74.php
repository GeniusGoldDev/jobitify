<div class="col-lg-4 col-md-12 tb-md-40">
    <div class="tb-dbholder tb-packege-setting">
        <div class="tb-dbbox tb-dbboxtitle">
            <h5> <?php echo e($editMode ? __('skill.update_skill') : __('skill.add_skill')); ?></h5>
        </div>
        <div class="tb-dbbox">
            <form class="tk-themeform">
                <fieldset>
                    <div class="tk-themeform__wrap">
                        <div class="form-group">
                            <label class="tb-label"><?php echo e(__('skill.title')); ?></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  wire:model.defer="name" required placeholder="<?php echo e(__('skill.title')); ?>">
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
                        <?php if(!empty($skills_tree) && $skills_tree->count() > 0): ?>
                        <div class="form-group">
                            <div class="tb-themeselect-wrapper">
                                <div class="tb-themeselect">
                                    <label class="tb-label"><?php echo e(__('skill.parent_skill')); ?></label>
                                    <div class="tb-select border-0">
                                        <span class="form-control tb-themeselect_value <?php echo e(!empty($isSelectedSkill) ? 'tk-selected' : ''); ?>"><?php echo e(!empty( $parent_skill_name ) ? $parent_skill_name : __('general.select')); ?></span>
                                    </div>
                                    <ul class="tb-categorytree-dropdown tb-themeselect_options tk-custom-scrollbar ">
                                        <?php $__currentLoopData = $skills_tree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.skill-item','data' => ['skill' => $skill]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.skill-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['skill' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($skill)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="tb-label"><?php echo e(__('general.description')); ?></label>
                            <textarea class="form-control" placeholder="<?php echo e(__('general.description')); ?>" wire:model.defer="description" id=""></textarea>
                        </div>
                        <?php if($editMode): ?>
                            <div class="form-group">
                                <label class="tb-label"><?php echo e(__('general.status')); ?>:</label>
                                <div class="tb-email-status">
                                    <span><?php echo e(__('skill.skill_status')); ?></span>
                                    <div class="tb-switchbtn">
                                        <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes"><?php echo e($status == 'active' ? __('general.active') : __('general.deactive')); ?></span></label>
                                        <input class="tb-checkaction" <?php echo e($status == 'active' ? 'checked' : ''); ?> type="checkbox" id="tb-emailstatus">
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
                            <label class="tb-label"><?php echo e(__('skill.upload_photo')); ?> (<?php echo e(__('skill.optional')); ?>):</label>
                            <div class="tb-uploadarea tb-uploadbartwo">
                                <ul class="tb-uploadbar">
                                    <li wire:loading wire:target="image" style="display: none" class="tb-uploading">
                                        <span><?php echo e(__('settings.uploading')); ?></span>
                                    </li>
                                    <?php if(!empty($image) && method_exists($image,'temporaryUrl')): ?>
                                        <div wire:loading.remove class="tb-uploadel tb-upload-two">
                                            <img src="<?php echo e(substr($image->getMimeType(), 0, 5) == 'image' ? $image->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($image->getClientOriginalName()); ?>">
                                            <span><p><?php echo e($image->getClientOriginalName()); ?> </p><a href="javascript:void(0);" wire:click.prevent="removeImage"> <i class="ti-trash"></i></a> </span>
                                        </div>
                                    <?php elseif(!empty($old_image)): ?>
                                        <?php 
                                            $image_path = $old_image['file_path'];
                                            $image_name = $old_image['file_name'];
                                       ?>
                                        <div wire:loading.remove class="tb-uploadel tb-upload-two">
                                            <img src="<?php echo e(asset('storage/'.$image_path)); ?>" alt="<?php echo e($image_name); ?>">
                                            <span><p><?php echo e($image_name); ?></p><a href="javascript:void(0);" wire:click.prevent="removeImage"> <i class="ti-trash"></i></a></span>
                                        </div>
                                    <?php endif; ?>
                                  
                                </ul>
                                <em> <?php echo e(__('skill.image_option',['extension'=> join(',', $allow_image_ext), 'size'=> $allow_image_size.'MB'])); ?>

                                    <label for="file2">
                                        <span>
                                            <input id="file2" type="file" accept="<?php echo e(!empty($allow_image_ext) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allow_image_ext)) : '*'); ?>"  wire:model="image">
                                            <?php echo e(__('skill.click_here_to_upload')); ?>

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
                                <?php echo e($editMode ? __('skill.update_skill') : __('skill.add_skill')); ?>

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
                $(this).next(".tb-themeselect_options").slideToggle();
                event.stopPropagation();
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
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/taxonomies/skills/update.blade.php ENDPATH**/ ?>