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
                <label class="at-label"><?php echo e(__('pages.submit_btn_txt')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['submit_btn_txt']) ? $settings['submit_btn_txt'] : ''); ?>" name="submit_btn_txt" placeholder="<?php echo e(__('pages.submit_btn_txt')); ?>">
            </div>
           
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.description')); ?></label>
                <textarea type="text" class="form-control" name="description" placeholder="<?php echo e(__('pages.description')); ?>" ><?php echo e(!empty($settings['description']) ? $settings['description'] : ''); ?></textarea>
            </div>
        </div>
    </fieldset>
</form><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/send-question-block.blade.php ENDPATH**/ ?>