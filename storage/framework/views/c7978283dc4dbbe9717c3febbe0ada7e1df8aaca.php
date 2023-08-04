<form class="at-themeform" id="at-form-setting_<?php echo e($block_key); ?>">
    <fieldset>
        <div class="at-themeform__wrap">
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.sub_title')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['sub_title']) ? $settings['sub_title'] : ''); ?>" name="sub_title" placeholder="<?php echo e(__('pages.sub_title')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.title')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['title']) ? $settings['title'] : ''); ?>" name="title" placeholder="<?php echo e(__('pages.title')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.btn_txt')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['search_btn_txt']) ? $settings['search_btn_txt'] : ''); ?>" name="search_btn_txt" placeholder="<?php echo e(__('pages.btn_txt')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.description')); ?></label>
                <textarea type="text" class="form-control" name="description" placeholder="<?php echo e(__('pages.description')); ?>" ><?php echo e(!empty($settings['description']) ? $settings['description'] : ''); ?></textarea>
            </div>


            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.upload_main_img')); ?></label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_01">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_01">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                        </div>
                    </div>
                    <figure>
                        <?php if(!empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl')): ?>
                        <img src="<?php echo e(substr($upload_files['file_01']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_01']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($upload_files['file_01']->getClientOriginalName()); ?>">
                        <?php elseif(!empty($settings['main_image'])): ?>
                            <img src="<?php echo e(asset($settings['main_image'])); ?>" alt="">
                        <?php else: ?> 
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-main-img">
                            <span>
                            <input id="at-upload-main-img" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="main_image" data-var_name="upload_files.file_01"/>
                            <input type="hidden" wire:ignore value="<?php echo e(!empty($settings['main_image']) ? $settings['main_image'] : ''); ?>" name="main_image" id="file_01"/>
                                <?php echo e(__('pages.upload_photo')); ?>

                            </span>
                        </label>
                        <?php if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['main_image']) ): ?>
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="main_image" data-block_key="<?php echo e($block_key); ?>"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
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

            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.upload_card_img')); ?></label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_02">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_02">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                        </div>
                    </div>
                    <figure>
                        <?php if(!empty($upload_files['file_02']) && method_exists($upload_files['file_02'],'temporaryUrl')): ?>
                        <img src="<?php echo e(substr($upload_files['file_02']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_02']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($upload_files['file_02']->getClientOriginalName()); ?>">
                        <?php elseif(!empty($settings['card_image'])): ?>
                            <img src="<?php echo e(asset($settings['card_image'])); ?>" alt="">
                        <?php else: ?> 
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-cardimg">
                            <span>
                                <input id="at-upload-file-cardimg" type="file" wire:model="upload_files.file_02" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="card_image" data-var_name="upload_files.file_02"/>
                                <input type="hidden" wire:ignore value="<?php echo e(!empty($settings['card_image']) ? $settings['card_image'] : ''); ?>" name="card_image" id="file_02"/>
                                <?php echo e(__('pages.upload_photo')); ?>

                            </span>
                        </label>
                        <?php if(( !empty($upload_files['file_02']) && method_exists($upload_files['file_02'],'temporaryUrl') ) || !empty($settings['card_image']) ): ?>
                            <span class="at_remove_file" data-file_name="file_02" data-key_name="card_image" data-block_key="<?php echo e($block_key); ?>"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
                        <?php endif; ?>
                    </div>
                    <?php $__errorArgs = ['upload_files.file_02'];
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
</form><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/search-talent-block.blade.php ENDPATH**/ ?>