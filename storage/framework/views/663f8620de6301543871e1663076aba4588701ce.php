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
                <label class="at-label"><?php echo e(__('pages.upload_app_store_img')); ?></label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_01">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_01">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                        </div>
                    </div>
                    <figure>
                        <?php if(!empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl')): ?>
                            <img src="<?php echo e(substr($upload_files['file_01']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_01']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($upload_files['file_01']->getClientOriginalName()); ?>">
                        <?php elseif(!empty($settings['app_store_img'])): ?>
                            <img src="<?php echo e(asset($settings['app_store_img'])); ?>" alt="">
                        <?php else: ?> 
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at_upload_file_01">
                            <span>
                                <input id="at_upload_file_01" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="app_store_img" data-var_name="upload_files.file_01">
                                <input type="hidden" wire:ignore value="<?php echo e(!empty($settings['app_store_img']) ? $settings['app_store_img'] : ''); ?>" name="app_store_img" id="file_01"/>
                                <?php echo e(__('pages.upload_photo')); ?>

                            </span>
                        </label>
                        <?php if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['app_store_img']) ): ?>
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="app_store_img" data-block_key="<?php echo e($block_key); ?>"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
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
                <label class="at-label"><?php echo e(__('pages.add_app_store_url')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['app_store_url']) ? $settings['app_store_url'] : ''); ?>" name="app_store_url" placeholder="<?php echo e(__('pages.add_app_store_url')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.upload_play_store_img')); ?></label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_02">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_02">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                        </div>
                    </div>
                    <figure>
                        <?php if(!empty($upload_files['file_02']) && method_exists($upload_files['file_02'],'temporaryUrl')): ?>
                            <img src="<?php echo e(substr($upload_files['file_02']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_02']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($upload_files['file_02']->getClientOriginalName()); ?>">
                        <?php elseif(!empty($settings['play_store_img'])): ?>
                            <img src="<?php echo e(asset($settings['play_store_img'])); ?>" alt="">
                        <?php else: ?> 
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input02">
                            <span>
                                <input type="file" id="at-upload-file-input02" wire:model="upload_files.file_02" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="play_store_img" data-var_name="upload_files.file_02"/>
                                <input type="hidden" wire:ignore value="<?php echo e(!empty($settings['play_store_img']) ? $settings['play_store_img'] : ''); ?>" name="play_store_img" id="file_02"/>
                                <?php echo e(__('pages.upload_photo')); ?>

                            </span>
                        </label>
                        <?php if(( !empty($upload_files['file_02']) && method_exists($upload_files['file_02'],'temporaryUrl') ) || !empty($settings['play_store_img']) ): ?>
                            <span class="at_remove_file" data-file_name="file_02" data-key_name="play_store_img" data-block_key="<?php echo e($block_key); ?>"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
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

            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.add_play_store_url')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['play_store_url']) ? $settings['play_store_url'] : ''); ?>" name="play_store_url" placeholder="<?php echo e(__('pages.add_play_store_url')); ?>">
            </div>

            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.add_short_desc')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['short_desc']) ? $settings['short_desc'] : ''); ?>" name="short_desc" placeholder="<?php echo e(__('pages.add_short_desc')); ?>">
            </div>
            
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.add_mobile_app_image')); ?></label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_03">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_03">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                        </div>
                    </div>
                    <figure>
                        <?php if(!empty($upload_files['file_03']) && method_exists($upload_files['file_03'],'temporaryUrl')): ?>
                            <img src="<?php echo e(substr($upload_files['file_03']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_03']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($upload_files['file_03']->getClientOriginalName()); ?>">
                        <?php elseif(!empty($settings['mobile_app_image'])): ?>
                            <img src="<?php echo e(asset($settings['mobile_app_image'])); ?>" alt="">
                        <?php else: ?> 
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input03">
                            <span>
                                <input id="at-upload-file-input03" type="file" wire:model="upload_files.file_03" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="mobile_app_image" data-var_name="upload_files.file_03"/>
                                <input type="hidden" wire:ignore value="<?php echo e(!empty($settings['mobile_app_image']) ? $settings['mobile_app_image'] : ''); ?>" name="mobile_app_image" id="file_03"/>
                                <?php echo e(__('pages.upload_photo')); ?>

                            </span>
                        </label>
                        <?php if(( !empty($upload_files['file_03']) && method_exists($upload_files['file_03'],'temporaryUrl') ) || !empty($settings['mobile_app_image']) ): ?>
                            <span class="at_remove_file" data-file_name="file_03" data-key_name="mobile_app_image" data-block_key="<?php echo e($block_key); ?>"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
                        <?php endif; ?>
                    </div>
                    <?php $__errorArgs = ['upload_files.file_03'];
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
                <label class="at-label"><?php echo e(__('pages.add_mobile_app_bg')); ?></label>
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_04">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_04">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                        </div>
                    </div>
                    <figure>
                        <?php if(!empty($upload_files['file_04']) && method_exists($upload_files['file_04'],'temporaryUrl')): ?>
                            <img src="<?php echo e(substr($upload_files['file_04']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_04']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($upload_files['file_04']->getClientOriginalName()); ?>">
                        <?php elseif(!empty($settings['mobile_app_bg'])): ?>
                            <img src="<?php echo e(asset($settings['mobile_app_bg'])); ?>" alt="">
                        <?php else: ?> 
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input04">
                            <span>
                                <input id="at-upload-file-input04" type="file" wire:model="upload_files.file_04" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="mobile_app_bg" data-var_name="upload_files.file_04"/>
                                <input type="hidden" wire:ignore value="<?php echo e(!empty($settings['mobile_app_bg']) ? $settings['mobile_app_bg'] : ''); ?>" name="mobile_app_bg" id="file_04"/>
                                <?php echo e(__('pages.upload_photo')); ?>

                            </span>
                        </label>
                        <?php if(( !empty($upload_files['file_04']) && method_exists($upload_files['file_04'],'temporaryUrl') ) || !empty($settings['mobile_app_bg']) ): ?>
                            <span class="at_remove_file" data-file_name="file_04" data-key_name="mobile_app_bg" data-block_key="<?php echo e($block_key); ?>"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
                        <?php endif; ?>
                    </div>
                    <?php $__errorArgs = ['upload_files.file_04'];
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
</form><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/mobile-app-block.blade.php ENDPATH**/ ?>