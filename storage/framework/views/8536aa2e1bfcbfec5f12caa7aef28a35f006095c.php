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
                <label class="at-label"><?php echo e(__('pages.list_title')); ?></label>
                <input type="text" class="form-control" value="<?php echo e(!empty($settings['list_title']) ? $settings['list_title'] : ''); ?>" name="list_title" placeholder="<?php echo e(__('pages.list_title')); ?>">
            </div>
            <div class="form-group">
                <label class="at-label"><?php echo e(__('pages.description')); ?></label>
                <textarea type="text" class="form-control" name="description" placeholder="<?php echo e(__('pages.description')); ?>" ><?php echo e(!empty($settings['description']) ? $settings['description'] : ''); ?></textarea>
            </div>

            <div class="accordion at-accordion" id="tb_counter_section" data-block_key="<?php echo e($block_key); ?>">
                <?php $__currentLoopData = $settings['question_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div wire:ignore class="accordion-item">
                        <h2 class="accordion-header at-accordion-header">
                            <button class="accordion-button collapsed" type="button">
                                <?php echo e(__('pages.item_txt',['counter' => $key])); ?>

                            </button>
                            <span class="at-cross-icon" data-block_key="<?php echo e($block_key); ?>"><i class="icon-x"></i></span>
                        </h2>
                        <div class="accordion-collapse collapse at-accordion-collapse">
                            <div class="accordion-body">
                                <div class="at-themeform__wrap">
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.question_label')); ?></label>
                                        <input type="text" class="form-control at-collapse-field" onChange="submitForm('<?php echo e($block_key); ?>')" value="<?php echo e($question['question']); ?>" data-type="question" name="question_list[<?php echo e($key); ?>][question]" placeholder="<?php echo e(__('pages.question_label')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="at-label"><?php echo e(__('pages.answer_label')); ?></label>
                                        <textarea type="text" class="form-control at-collapse-field" name="question_list[<?php echo e($key); ?>][answer]" data-type="answer" placeholder="<?php echo e(__('pages.answer_label')); ?>" ><?php echo e(!empty($question['answer']) ? $question['answer'] : ''); ?></textarea>
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
                    <label class="at-label"><?php echo e(__('pages.question_label')); ?></label>
                    <input type="text" class="form-control at-collapse-field" onChange="submitForm('<?php echo e($block_key); ?>')" value="" data-type="question" name="question_list[<?php echo e($key); ?>][question]" placeholder="<?php echo e(__('pages.question_label')); ?>">
                </div>
                <div class="form-group">
                    <label class="at-label"><?php echo e(__('pages.answer_label')); ?></label>
                    <textarea type="text" class="form-control at-collapse-field" onChange="submitForm('<?php echo e($block_key); ?>')" name="question_list[<?php echo e($key); ?>][answer]" data-type="answer" placeholder="<?php echo e(__('pages.answer_label')); ?>" ></textarea>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/settings/question-search-block.blade.php ENDPATH**/ ?>