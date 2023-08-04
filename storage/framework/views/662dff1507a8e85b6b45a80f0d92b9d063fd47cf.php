<form class="at-themeform" id="at-form-setting_<?php echo e($block_key); ?>">
    <fieldset>
        <div class="at-themeform__wrap">
            <div wire:ignore class="form-group">
                <label class="at-label"><?php echo e(__('pages.heading_txt')); ?></label>
                <textarea id="tk_editor_<?php echo e(time()); ?>" class="form-control" name="heading" placeholder="<?php echo e(__('pages.heading_txt')); ?>"></textarea>
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.description')); ?></label>
                <textarea type="text" class="form-control" name="description" placeholder="<?php echo e(__('pages.description')); ?>" ><?php echo e(!empty($settings['description']) ? $settings['description'] : ''); ?></textarea>
            </div>

            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.add_video_link')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['video_link']) ? $settings['video_link'] : ''); ?>" name="video_link" placeholder="<?php echo e(__('pages.add_video_link')); ?>">
            </div>

            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.talent_btn_txt')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['talent_btn_txt']) ? $settings['talent_btn_txt'] : ''); ?>" name="talent_btn_txt" placeholder="<?php echo e(__('pages.talent_btn_txt')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.work_btn_txt')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['work_btn_txt']) ? $settings['work_btn_txt'] : ''); ?>" name="work_btn_txt" placeholder="<?php echo e(__('pages.work_btn_txt')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.upload_bg_img')); ?></label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_01">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_01">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                        </div>
                    </div>
                    <figure>
                        <?php if(!empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl')): ?>
                            <img src="<?php echo e(substr($upload_files['file_01']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_01']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($upload_files['file_01']->getClientOriginalName()); ?>">
                        <?php elseif(!empty($settings['hiring_process_bg'])): ?>
                            <img src="<?php echo e(asset($settings['hiring_process_bg'])); ?>" alt="">
                        <?php else: ?> 
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input01">
                            <span>
                                <input id="at-upload-file-input01" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="hiring_process_bg" data-var_name="upload_files.file_01"/>
                                <input type="hidden" wire:ignore value="<?php echo e(!empty($settings['hiring_process_bg']) ? $settings['hiring_process_bg'] : ''); ?>" name="hiring_process_bg" id="file_01"/>
                                <?php echo e(__('pages.upload_photo')); ?>

                            </span>
                        </label>
                       
                        <?php if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['hiring_process_bg']) ): ?>
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="hiring_process_bg" data-block_key="<?php echo e($block_key); ?>"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
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
        </div>
    </fieldset>
</form><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/hiring-process-block.blade.php ENDPATH**/ ?>