<form class="at-themeform" id="at-form-setting_<?php echo e($block_key); ?>">
    <fieldset>
        <div class="at-themeform__wrap">

            <div wire:ignore class="form-group">
                <label class="at-label"><?php echo e(__('pages.sub_title')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['sub_title']) ? $settings['sub_title'] : ''); ?>" name="sub_title" placeholder="<?php echo e(__('pages.sub_title')); ?>">
            </div>
            <div wire:ignore class="form-group">
                <label class="at-label"><?php echo e(__('pages.title')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['title']) ? $settings['title'] : ''); ?>" name="title" placeholder="<?php echo e(__('pages.title')); ?>">
            </div>
            <div wire:ignore class="form-group">
                <label class="at-label"><?php echo e(__('pages.description')); ?></label>
                <textarea type="text" class="form-control" name="description" placeholder="<?php echo e(__('pages.description')); ?>" ><?php echo e(!empty($settings['description']) ? $settings['description'] : ''); ?></textarea>
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
                        <?php elseif(!empty($settings['feedback_bg'])): ?>
                            <img src="<?php echo e(asset($settings['feedback_bg'])); ?>" alt="">
                        <?php else: ?> 
                            <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                        <?php endif; ?>
                    </figure>
                    <div class="at-del-img">
                        <label for="at-upload-file-input01">
                            <span>
                                <input id="at-upload-file-input01" type="file" wire:model="upload_files.file_01" accept="image/png, image/gif, image/jpeg" class="at_upload_file" data-key_name="feedback_bg" data-var_name="upload_files.file_01"/>
                                <input type="hidden" wire:ignore value="<?php echo e(!empty($settings['feedback_bg']) ? $settings['feedback_bg'] : ''); ?>" name="feedback_bg" id="file_01"/>
                                <?php echo e(__('pages.upload_photo')); ?>

                            </span>
                        </label>
                        <?php if(( !empty($upload_files['file_01']) && method_exists($upload_files['file_01'],'temporaryUrl') ) || !empty($settings['feedback_bg']) ): ?>
                            <span class="at_remove_file" data-file_name="file_01" data-key_name="feedback_bg" data-block_key="<?php echo e($block_key); ?>"><a href="javascript:void(0)"><i class="icon-trash-2 at-trash"></i></a></span>
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
                <?php $__currentLoopData = $settings['feedback_users']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header at-accordion-header">
                            <button class="accordion-button collapsed" type="button">
                                <?php echo e(__('pages.item_txt',['counter' => $key])); ?>

                            </button>
                            <span  wire:click.prevent="removeItem('feedback_users',<?php echo e($key); ?>)"><i class="icon-x"></i></span>
                        </h2>
                        <div wire:ignore.self class="accordion-collapse collapse at-accordion-collapse">
                            <div class="accordion-body">
                                <div class="at-themeform__wrap">
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.name')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($user['name'] ?? ''); ?>" onChange="submitForm('<?php echo e($block_key); ?>')" name="feedback_users[<?php echo e($key); ?>][name]" placeholder="<?php echo e(__('pages.name')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.address')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($user['address'] ?? ''); ?>" onChange="submitForm('<?php echo e($block_key); ?>')" name="feedback_users[<?php echo e($key); ?>][address]" placeholder="<?php echo e(__('pages.address')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.description')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($user['description'] ?? ''); ?>" onChange="submitForm('<?php echo e($block_key); ?>')" name="feedback_users[<?php echo e($key); ?>][description]" placeholder="<?php echo e(__('pages.description')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="tk-label"><?php echo e(__('pages.feedback_rating')); ?></label>
                                        <div class="tk-my-ratingholder" wire:ignore>
                                            <ul id="tk_seller_ratings" class='tk-rating-stars tk_stars'>
                                                <?php if(!empty($user['rating']) ): ?>
                                                    <?php for($i=1; $i < 6; $i++ ): ?>
                                                    <li class="tk-star <?php echo e($i <= $user['rating'] ? 'active':''); ?>" data-value="<?php echo e($i); ?>">
                                                        <i class="fas fa-star"></i>
                                                    </li>
                                                    <?php endfor; ?>
                                                <?php endif; ?>
                                            </ul>
                                            <input type="hidden" name="feedback_users[<?php echo e($key); ?>][rating]" data-block_key="<?php echo e($block_key); ?>" class="at-feedback-rating" value="<?php echo e(!empty($user['rating']) ? $user['rating'] : 0); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.upload_img')); ?></label>
                                        <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="settings.feedback_users.<?php echo e($key); ?>.image">
                                            <div class="preloader-outer" wire:loading wire:target="settings.feedback_users.<?php echo e($key); ?>.image">
                                                <div class="tk-preloader">
                                                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                                                </div>
                                            </div>
                                            <figure>
                                                <?php if(!empty($settings['feedback_users'][$key]['image']) && method_exists($settings['feedback_users'][$key]['image'],'temporaryUrl')): ?>
                                                    <img src="<?php echo e(substr($settings['feedback_users'][$key]['image']->getMimeType(), 0, 5) == 'image' ? $settings['feedback_users'][$key]['image']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($settings['feedback_users'][$key]['image']->getClientOriginalName()); ?>">
                                                <?php elseif(!empty($user['image'])): ?>
                                                    <img src="<?php echo e(asset($user['image'])); ?>" alt="">
                                                <?php else: ?> 
                                                    <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                                                <?php endif; ?>
                                            </figure>
                                            <div class="at-del-img">
                                                <label for="at-feedback_users<?php echo e($key); ?>-image">
                                                    <span>
                                                        <input id="at-feedback_users<?php echo e($key); ?>-image" type="file" wire:model="settings.feedback_users.<?php echo e($key); ?>.image" accept="image/png, image/gif, image/jpeg" class="at_upload_file" />
                                                        <input type="hidden" wire:ignore value="<?php echo e(!empty($user['image']) ? $user['image'] : ''); ?>" name="feedback_users[<?php echo e($key); ?>][image]" id="feedback_users<?php echo e($key); ?>image"/>
                                                        <?php echo e(__('pages.upload_photo')); ?>

                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <a class="at-plus-icon at-btn" id="add_more_block" wire:click.prevent="addMoreItem('feedback_users')" href="#"><i class="icon-plus"></i><?php echo e(__('pages.add_item')); ?></a>

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
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/user-feedback-block.blade.php ENDPATH**/ ?>