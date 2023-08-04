
<section class="tk-main-section tk-faq-question-section <?php echo e($block_key); ?> <?php echo e($custom_class); ?>" <?php if(!$site_view): ?> wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?>>
    <?php if( !empty($style_css) ): ?>
		<style><?php echo e('.'.$block_key.$style_css); ?></style>
	<?php endif; ?>
    <div class="container" wire:loading.class="tk-section-preloader">
        <?php if(!$site_view): ?>
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <!-- acordian section start -->
                <?php if(!empty($sub_title) || !empty($title) || !empty($description)): ?>
                    <div class="tk-faq-search text-center">
                        <div class="tk-maintitle tk-maintitlevtwo text-center">
                            <?php if( !empty($sub_title) ): ?><h5><?php echo $sub_title; ?></h5><?php endif; ?>
                            <?php if( !empty($title) ): ?><h2><?php echo $title; ?></h2><?php endif; ?>
                            <?php if( !empty($description) ): ?><p><?php echo nl2br($description); ?></p><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="tk-faq-acordian">
                    <div class="tk-acoridan_title">
                        <h3><?php echo $list_title; ?></h3>
                    </div>
                    <?php if(!empty($question_list)): ?>
                        <div class="tk-acordian">
                            <ul id="tk-accordion" class="tk-accordion">
                                <?php $__currentLoopData = $question_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <div class="tk-accordion_title collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#collapse_<?php echo e($key); ?>" aria-expanded="false">
                                            <h5><?php echo $question['question']; ?></h5>
                                        </div>
                                        <div class="collapse" id="collapse_<?php echo e($key); ?>" data-bs-parent="#tk-accordion">
                                            <div class="tk-accordion_info tk-accordion_info">
                                                <p><?php echo $question['answer']; ?></p>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- acordian section end -->
            </div>
        </div>
    </div>
</section>

<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/question-search-block.blade.php ENDPATH**/ ?>