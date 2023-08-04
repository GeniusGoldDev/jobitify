
<?php
    $all_categories = getAllCategories();
    $selected_categories = !empty($settings['category_ids']) ? $settings['category_ids'] : [];
?>
<form class="at-themeform" id="at-form-setting_<?php echo e($block_key); ?>">
    <fieldset>
        <div class="at-themeform__wrap">
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.title')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['title']) ? $settings['title'] : ''); ?>" name="title" placeholder="<?php echo e(__('pages.title')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.sub_title')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['sub_title']) ? $settings['sub_title'] : ''); ?>" name="sub_title" placeholder="<?php echo e(__('pages.sub_title')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.explore_all_btn_txt')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['explore_btn_txt']) ? $settings['explore_btn_txt'] : ''); ?>" name="explore_btn_txt" placeholder="<?php echo e(__('pages.explore_all_btn_txt')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.description')); ?></label>
                <textarea type="text" class="form-control"  name="description" placeholder="<?php echo e(__('pages.description')); ?>" ><?php echo e(!empty($settings['description']) ? $settings['description'] : ''); ?></textarea>
            </div>
            <?php if( !empty($all_categories) ): ?>
                <div class="form-group">
                    <label class="at-label"><?php echo e(__('pages.selected_categories')); ?></label>
                    <input type="hidden" name="category_ids" id="category_ids_<?php echo e($block_key); ?>" value="<?php echo e(implode(',', $selected_categories)); ?>" />
                    <div class="at-select" >
                        <select id="selected_categories_<?php echo e($block_key); ?>" multiple data-placeholder= "<?php echo e(__('general.select')); ?>">
                            <option value=""><?php echo e(__('general.select')); ?></option>
                            <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e(in_array($cat->id, $selected_categories) ? 'selected' : ''); ?> ><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </fieldset>
</form>

   <?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/categories-block.blade.php ENDPATH**/ ?>