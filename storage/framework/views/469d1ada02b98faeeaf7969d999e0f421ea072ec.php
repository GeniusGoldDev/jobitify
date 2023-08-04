<div  class="col-lg-3">
    <aside class="tk-status-holder">
        <ul class="tk-status-tabs">
            <li class="<?php echo e($step ==1 ? 'tk-current-status' : 'tk-complete-status'); ?>">
                <div class="tk-status-tabs_content">
                    <h6 class="tk-tabs-star"> <?php echo e(__('gig.about_gig')); ?> </h6>
                    <?php if( $step == 1 ): ?>
                        <p><?php echo e(__('gig.description_info')); ?></p>
                    <?php elseif($step >= 2): ?>
                        <a href="javascript:;" wire:click.prevent="updateStep(1)"><?php echo e(__('gig.edit_detail')); ?></a>
                    <?php endif; ?>
                </div>
            </li>
            <li class="<?php echo e($step > 2 ? 'tk-complete-status' : ( $step == 2 ? 'tk-current-status' : '' )); ?>">
                <div class="tk-status-tabs_content">
                    <h6 class="tk-tabs-star"> <?php echo e(__('gig.pricing')); ?> </h6>
                    <?php if( $step == 2 ): ?>
                        <p> <?php echo e(__('gig.pricing_desc')); ?> </p>
                    <?php elseif($step >= 2): ?>
                        <a href="javascript:;" wire:click.prevent="updateStep(2)"><?php echo e(__('gig.edit_detail')); ?></a>
                    <?php endif; ?>
                </div>
            </li>
            <li class="<?php echo e($step > 3 ? 'tk-complete-status' : ( $step == 3 ? 'tk-current-status' : '' )); ?>">
                <div class="tk-status-tabs_content">
                    <h6 class="tk-tabs-star"> <?php echo e(__('gig.media_attachment')); ?> </h6>
                    <?php if( $step == 3 ): ?>
                        <p> <?php echo e(__('gig.media_attachment_desc')); ?> </p>
                    <?php elseif($step >= 3): ?>
                        <a href="javascript:;" wire:click.prevent="updateStep(3)"><?php echo e(__('gig.edit_detail')); ?></a>
                    <?php endif; ?>
                </div>
            </li>
            <li class="<?php echo e($step > 4 ? 'tk-complete-status' : ( $step == 4 ? 'tk-current-status' : '' )); ?>">
                <div class="tk-status-tabs_content">
                    <h6><?php echo e(__('gig.faq')); ?></h6>
                    <?php if( $step == 4 ): ?><p><?php echo e(__('gig.faq_desc')); ?></p><?php endif; ?>
                </div>
            </li>
        </ul>
    </aside>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-creation-sidebar.blade.php ENDPATH**/ ?>