<form class="at-themeform" id="at-form-setting_<?php echo e($block_key); ?>">
    <fieldset>
        <div class="at-themeform__wrap">
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.add_tagline_title')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['tagline_title']) ? $settings['tagline_title'] : ''); ?>" name="tagline_title" placeholder="<?php echo e(__('pages.add_tagline_title')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.title')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['title']) ? $settings['title'] : ''); ?>" name="title" placeholder="<?php echo e(__('pages.title')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.join_us_btn_txt')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['join_us_btn_txt']) ? $settings['join_us_btn_txt'] : ''); ?>" name="join_us_btn_txt" placeholder="<?php echo e(__('pages.join_us_btn_txt')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.description')); ?></label>
                <textarea type="text" class="form-control" name="description" placeholder="<?php echo e(__('pages.description')); ?>" ><?php echo e(!empty($settings['description']) ? $settings['description'] : ''); ?></textarea>
            </div>


            <div class="form-group">
               
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_01">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_01">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                        </div>
                    </div>
                    <figure>
                        <?php if(!empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl')): ?>
                            <img src="<?php echo e(substr($upload_files['file_01']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_01']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($upload_files['file_01']->getClientOriginalName()); ?>">
                        <?php elseif(!empty($settings['display_image'])): ?>
                            <img src="<?php echo e(asset($settings['display_image'])); ?>" alt="">
                        <?php else: ?> 
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input01">
                            <span>
                                <input id="at-upload-file-input01" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="display_image" data-var_name="upload_files.file_01"/>
                                <input type="hidden" wire:ignore value="<?php echo e(!empty($settings['display_image']) ? $settings['display_image'] : ''); ?>" name="display_image" id="file_01"/>
                                <?php echo e(__('pages.upload_photo')); ?>

                            </span>
                        </label>
                        <?php if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['display_image']) ): ?>
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="display_image" data-block_key="<?php echo e($block_key); ?>"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
                        <?php endif; ?>
                    </div>
                    <?php $__errorArgs = ['upload_files.file_01'];
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

            <div class="accordion at-accordion" id="tb_counter_section" data-block_key="<?php echo e($block_key); ?>">
                <?php $__currentLoopData = $settings['points']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header at-accordion-header">
                            <button class="accordion-button collapsed" type="button">
                                <?php echo e(__('pages.item_txt',['counter' => $key])); ?>

                            </button>
                            <span class="at-cross-icon"><i class="icon-x"></i></span>
                        </h2>
                        <div class="accordion-collapse collapse at-accordion-collapse">
                            <div class="accordion-body">
                                <div class="at-themeform__wrap">
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.point_label')); ?></label>
                                        <input type="text" class="form-control" onChange="submitForm('<?php echo e($block_key); ?>')" value="<?php echo e($point); ?>" data-type="heading" name="points[]" placeholder="<?php echo e(__('pages.point_label')); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <a class="at-plus-icon at-btn" id="add_more_item" data-block_key="<?php echo e($block_key); ?>" href="javascript:void(0)"><i class="icon-plus"></i><?php echo e(__('pages.add_item')); ?></a>

        </div>
    </fieldset>
</form>

<div class="accordion-item d-none" id="clone_item">
    <h2 class="accordion-header at-accordion-header">
        <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="flush-collapseOne">
            <?php echo e(__('pages.item_txt')); ?>

        </button>
        <span class="at-cross-icon" data-block_key="<?php echo e($block_key); ?>"><i class="icon-x"></i></span>
    </h2>
    <div class="accordion-collapse collapse at-accordion-collapse">
        <div class="accordion-body">
            <div class="at-themeform__wrap">
                <div class="form-group">
                    <label class="at-label"><?php echo e(__('pages.point_label')); ?></label>
                    <input type="text" class="form-control" onChange="submitForm('<?php echo e($block_key); ?>')" name="points[]">
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/opportunities-block.blade.php ENDPATH**/ ?>