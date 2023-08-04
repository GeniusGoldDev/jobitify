<?php
    $all_categories = getAllCategories();
    $selected_categories = !empty($settings['category_ids']) ? $settings['category_ids'] : [];
?>
<form class="at-themeform" id="at-form-setting_<?php echo e($block_key); ?>">
    <fieldset>
        <div class="at-themeform__wrap">
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.description')); ?></label>
                <textarea class="form-control" name="description" placeholder="<?php echo e(__('pages.description')); ?>" ><?php echo e(!empty($settings['description']) ? $settings['description'] : ''); ?></textarea>
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.mobile_app_heading')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['mobile_app_heading']) ? $settings['mobile_app_heading'] : ''); ?>" name="mobile_app_heading" placeholder="<?php echo e(__('pages.mobile_app_heading')); ?>" />
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
                            <img src="<?php echo e(asset($settings['app_store_img'])); ?>" alt="img">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input">
                            <span>
                                <input id="at-upload-file-input" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="app_store_img" data-var_name="upload_files.file_01">
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
                        <label for="at-upload-playstore-img">
                            <span>
                                <input id="at-upload-playstore-img" type="file" wire:model="upload_files.file_02" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="play_store_img" data-var_name="upload_files.file_02"/>
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
                <label class="at-label"><?php echo e(__('pages.upload_site_logo')); ?></label>
               
                <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="upload_files.file_03">
                    <div class="preloader-outer" wire:loading wire:target="upload_files.file_03">
                        <div class="tk-preloader">
                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                        </div>
                    </div>
                    <figure>
                        <?php if(!empty($upload_files['file_03']) && method_exists($upload_files['file_03'],'temporaryUrl')): ?>
                            <img src="<?php echo e(substr($upload_files['file_03']->getMimeType(), 0, 5) == 'image' ? $upload_files['file_03']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($upload_files['file_03']->getClientOriginalName()); ?>">
                        <?php elseif(!empty($settings['logo_image'])): ?>
                            <img src="<?php echo e(asset($settings['logo_image'])); ?>" alt="">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-logo-img">
                            <span>
                                <input id="at-upload-logo-img" type="file" wire:model="upload_files.file_03" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="logo_image" data-var_name="upload_files.file_03"/>
                                <input type="hidden" wire:ignore value="<?php echo e(!empty($settings['logo_image']) ? $settings['logo_image'] : ''); ?>" name="logo_image" id="file_03"/>
                                <?php echo e(__('pages.upload_photo')); ?>

                            </span>
                        </label>
                        <?php if(( !empty($upload_files['file_03']) && method_exists($upload_files['file_03'],'temporaryUrl') ) || !empty($settings['logo_image']) ): ?>
                            <span class="at_remove_file" data-file_name="file_03" data-key_name="logo_image" data-block_key="<?php echo e($block_key); ?>"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
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
                <label class="at-label"><?php echo e(__('pages.add_play_store_url')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['play_store_url']) ? $settings['play_store_url'] : ''); ?>" name="play_store_url" placeholder="<?php echo e(__('pages.add_play_store_url')); ?>">
            </div>

            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.category_heading')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['category_heading']) ? $settings['category_heading'] : ''); ?>" name="category_heading" placeholder="<?php echo e(__('pages.category_heading')); ?>">
            </div>
            <?php if( !empty($all_categories) ): ?>
                <div class="form-group">
                    <label class="at-label"><?php echo e(__('pages.selected_categories')); ?></label>
                    <input type="hidden" wire:ignore name="category_ids" id="category_ids_<?php echo e($block_key); ?>" value="<?php echo e(implode(',', $selected_categories)); ?>" />
                    <div wire:ignore class="at-select" >
                        <select id="selected_categories_<?php echo e($block_key); ?>"  multiple data-placeholder= "<?php echo e(__('general.select')); ?>">
                            <option value=""><?php echo e(__('general.select')); ?></option>
                            <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e(in_array($cat->id, $selected_categories) ? 'selected' : ''); ?> ><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.newsletter_heading')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['newsletter_heading']) ? $settings['newsletter_heading'] : ''); ?>" name="newsletter_heading" placeholder="<?php echo e(__('pages.newsletter_heading')); ?>">
            </div>

            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.add_phone_number')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['phone']) ? $settings['phone'] : ''); ?>" name="phone" placeholder="<?php echo e(__('pages.add_phone_number')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.phone_call_availablity')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['phone_call_availablity']) ? $settings['phone_call_availablity'] : ''); ?>" name="phone_call_availablity" placeholder="<?php echo e(__('pages.phone_call_availablity')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.add_email')); ?></label>
                <input type="email" class="form-control" value="<?php echo e(!empty($settings['email']) ? $settings['email'] : ''); ?>" name="email" placeholder="<?php echo e(__('pages.add_email')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.add_fax')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['fax']) ? $settings['fax'] : ''); ?>" name="fax" placeholder="<?php echo e(__('pages.add_fax')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.add_whatsapp')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['whatsapp']) ? $settings['whatsapp'] : ''); ?>" name="whatsapp" placeholder="<?php echo e(__('pages.add_whatsapp')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.whatsapp_availablity_time')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['whatsapp_call_availablity']) ? $settings['whatsapp_call_availablity'] : ''); ?>" name="whatsapp_call_availablity" placeholder="<?php echo e(__('pages.whatsapp_availablity_time')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.facebook_link')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['facebook_link']) ? $settings['facebook_link'] : ''); ?>" name="facebook_link" placeholder="<?php echo e(__('pages.facebook_link')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.twitter_link')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['twitter_link']) ? $settings['twitter_link'] : ''); ?>" name="twitter_link" placeholder="<?php echo e(__('pages.twitter_link')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.linkedin_link')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['linkedin_link']) ? $settings['linkedin_link'] : ''); ?>" name="linkedin_link" placeholder="<?php echo e(__('pages.linkedin_link')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.dribbble_link')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['dribbble_link']) ? $settings['dribbble_link'] : ''); ?>" name="dribbble_link" placeholder="<?php echo e(__('pages.dribbble_link')); ?>">
            </div>
        </div>
    </fieldset>
</form><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/footer-block.blade.php ENDPATH**/ ?>