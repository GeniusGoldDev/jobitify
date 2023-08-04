<div  class="col-lg-3">
    <aside class="tk-status-holder">
        <ul class="tk-status-tabs">
            <li class="<?php echo e($step <= 2 ? 'tk-current-status' : 'tk-complete-status'); ?>">
                <div class="tk-status-tabs_content">
                    <h6 class="tk-tabs-star"> <?php echo e(__('project.about_project')); ?> </h6>
                    <?php if( $step == 2 ): ?>
                        <p><?php echo e(__('project.description_info')); ?></p>
                    <?php elseif($step > 2): ?>
                        <a href="javascript:;" wire:click.prevent="updateStep(2)"><?php echo e(__('project.edit_detail')); ?></a>
                    <?php endif; ?>
                </div>
            </li>
            <li class="<?php echo e($step > 3 ? 'tk-complete-status' : ( $step == 3 ? 'tk-current-status' : '' )); ?>">
                <div class="tk-status-tabs_content">
                    <h6 class="tk-tabs-star"> <?php echo e(__('project.freelancer_prefrences')); ?> </h6>
                    <?php if( $step == 3 ): ?>
                        <p> <?php echo e(__('project.skills_you_want')); ?> </p>
                    <?php elseif($step > 3): ?>
                        <a href="javascript:;" wire:click.prevent="updateStep(3)"><?php echo e(__('project.edit_detail')); ?></a>
                    <?php endif; ?>
                </div>
            </li>
            <li class="<?php echo e($step > 4 ? 'tk-complete-status' : ( $step == 4 ? 'tk-current-status' : '' )); ?>">
                <div class="tk-status-tabs_content">
                    <h6><?php echo e(__('project.recomended_freelancers')); ?></h6>
                    <?php if( $step == 4 ): ?><p><?php echo e(__('project.hire_best_match')); ?></p><?php endif; ?>
                </div>
            </li>
        </ul>
        <?php if( $step == 4 ): ?><a href="<?php echo e(route('project-listing')); ?>" class="tk-btn-solid-lg-lefticon"><?php echo e(__('project.go_to_project')); ?> <i class="icon-chevron-right"></i></a><?php endif; ?>
    </aside>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/project-creation-sidebar.blade.php ENDPATH**/ ?>