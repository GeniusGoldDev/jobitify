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

            <div class="accordion at-accordion" id="tb_counter_section" data-block_key="<?php echo e($block_key); ?>">
                <?php $__currentLoopData = $settings['team_members']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header at-accordion-header">
                            <button class="accordion-button collapsed" type="button">
                                <?php echo e(__('pages.item_txt',['counter' => $key])); ?>

                            </button>
                            <span  wire:click.prevent="removeItem('team_members',<?php echo e($key); ?>)"><i class="icon-x"></i></span>
                        </h2>
                        <div wire:ignore.self class="accordion-collapse collapse at-accordion-collapse">
                            <div class="accordion-body">
                                <div class="at-themeform__wrap">
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.name')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($member['name']); ?>" onChange="submitForm('<?php echo e($block_key); ?>')" name="team_members[<?php echo e($key); ?>][name]" placeholder="<?php echo e(__('pages.name')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.designation')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($member['designation']); ?>" onChange="submitForm('<?php echo e($block_key); ?>')" name="team_members[<?php echo e($key); ?>][designation]" placeholder="<?php echo e(__('pages.designation')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.facebook_link')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($member['facebook_link']); ?>" onChange="submitForm('<?php echo e($block_key); ?>')" name="team_members[<?php echo e($key); ?>][facebook_link]" placeholder="<?php echo e(__('pages.facebook_link')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.twitter_link')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($member['twitter_link']); ?>" onChange="submitForm('<?php echo e($block_key); ?>')" name="team_members[<?php echo e($key); ?>][twitter_link]" placeholder="<?php echo e(__('pages.twitter_link')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.linkedin_link')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($member['linkedin_link']); ?>" onChange="submitForm('<?php echo e($block_key); ?>')" name="team_members[<?php echo e($key); ?>][linkedin_link]" placeholder="<?php echo e(__('pages.linkedin_link')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.twitch_link')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($member['twitch_link']); ?>" onChange="submitForm('<?php echo e($block_key); ?>')" name="team_members[<?php echo e($key); ?>][twitch_link]" placeholder="<?php echo e(__('pages.twitch_link')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.dribbble_link')); ?></label>
                                        <input type="text" class="form-control" value="<?php echo e($member['dribbble_link']); ?>" onChange="submitForm('<?php echo e($block_key); ?>')" name="team_members[<?php echo e($key); ?>][dribbble_link]" placeholder="<?php echo e(__('pages.dribbble_link')); ?>">
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.upload_img')); ?></label>
                                        <div class="at-admin-imgarea" wire:loading.class="tk-section-preloader" wire:target="settings.team_members.<?php echo e($key); ?>.image">
                                            <div class="preloader-outer" wire:loading wire:target="settings.team_members.<?php echo e($key); ?>.image">
                                                <div class="tk-preloader">
                                                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                                                </div>
                                            </div>
                                            <figure>
                                                <?php if(!empty($settings['team_members'][$key]['image']) && method_exists($settings['team_members'][$key]['image'],'temporaryUrl')): ?>
                                                    <img src="<?php echo e(substr($settings['team_members'][$key]['image']->getMimeType(), 0, 5) == 'image' ? $settings['team_members'][$key]['image']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($settings['team_members'][$key]['image']->getClientOriginalName()); ?>">
                                                <?php elseif(!empty($member['image'])): ?>
                                                    <img src="<?php echo e(asset($member['image'])); ?>" alt="">
                                                <?php else: ?> 
                                                    <img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="img">
                                                <?php endif; ?>
                                            </figure>
                                            <div class="at-del-img">
                                                <label for="at_team_members<?php echo e($key); ?>_image">
                                                    <span>
                                                        <input id="at_team_members<?php echo e($key); ?>_image" type="file" wire:model="settings.team_members.<?php echo e($key); ?>.image" accept="image/png, image/gif, image/jpeg" class="at_upload_file" />
                                                        <input type="hidden" wire:ignore value="<?php echo e(!empty($member['image']) ? $member['image'] : ''); ?>" name="team_members[<?php echo e($key); ?>][image]" id="team_members<?php echo e($key); ?>image"/>
                                                        <?php echo e(__('pages.upload_photo')); ?>

                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <?php $__errorArgs = ['settings.team_members.'.$key.'.image'];
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
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <a class="at-plus-icon at-btn" id="add_more_block" wire:click.prevent="addMoreItem('team_members')" href="#"><i class="icon-plus"></i><?php echo e(__('pages.add_item')); ?></a>

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
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/professional-block.blade.php ENDPATH**/ ?>