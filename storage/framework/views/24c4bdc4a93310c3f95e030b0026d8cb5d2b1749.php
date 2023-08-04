<?php
    $all_projects = getAllProjects();
    $selected_projects = !empty($settings['project_ids']) ? $settings['project_ids'] : [];
?>
<form class="at-themeform" id="at-form-setting_<?php echo e($block_key); ?>">
    <fieldset>
        <div class="at-themeform__wrap">
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.sub_title')); ?></label>
                <input type="text" class="form-control" name="sub_title" value="<?php echo e(!empty($settings['sub_title']) ? $settings['sub_title'] : ''); ?>" placeholder="<?php echo e(__('pages.sub_title')); ?>" />
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.title')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['title']) ? $settings['title'] : ''); ?>" name="title" placeholder="<?php echo e(__('pages.title')); ?>" />
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.explore_btn_txt')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['explore_btn_txt']) ? $settings['explore_btn_txt'] : ''); ?>" name="explore_btn_txt" placeholder="<?php echo e(__('pages.explore_btn_txt')); ?>" />
            </div>

            <?php if( !empty($all_projects) ): ?>
                <div class="form-group">
                    <label class="at-label"><?php echo e(__('pages.selected_projects')); ?></label>
                    <input type="hidden" name="project_ids" id="project_ids_<?php echo e($block_key); ?>" value="<?php echo e(implode(',', $selected_projects)); ?>" />
                    <div class="at-select" >
                        <select id="selected_projects_<?php echo e($block_key); ?>"  multiple data-placeholder= "<?php echo e(__('general.select')); ?>">
                            <option value=""><?php echo e(__('general.select')); ?></option>
                            <?php $__currentLoopData = $all_projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($project->id); ?>" <?php echo e(in_array($project->id, $selected_projects) ? 'selected' : ''); ?> ><?php echo e($project->project_title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </fieldset>
</form><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/projects-block.blade.php ENDPATH**/ ?>