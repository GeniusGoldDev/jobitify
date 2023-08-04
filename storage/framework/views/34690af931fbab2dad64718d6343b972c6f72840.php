
<section class="tk-experince-section <?php echo e($block_key); ?> <?php echo e($custom_class); ?>" <?php if(!$site_view): ?> wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?> <?php if( !empty($mobile_app_bg) ): ?> style="background-image: url(<?php echo e(asset($mobile_app_bg)); ?>)" <?php endif; ?>>
    <?php if( !empty($style_css) ): ?>
        <style><?php echo e('.'.$block_key.$style_css); ?></style>
    <?php endif; ?>
    <div class="tk-ourexperience" wire:loading.class="tk-section-preloader">
        <?php if(!$site_view): ?>
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
        <?php endif; ?>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-xl-6">
                    <div class="tk-main-title-holder tk-sectionapptitle">
                        <?php if(!empty($heading)): ?>
                            <?php echo $heading; ?> 
                        <?php endif; ?>

                        <?php if(!empty($description)): ?>
                            <div class="tk-main-description">
                                <p><?php echo $description; ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="tk-store-content">
                            <?php if(!empty($app_store_img)): ?>
                                <a href="<?php echo e($app_store_url); ?>">
                                    <img src="<?php echo e(asset($app_store_img)); ?>" alt="<?php echo e(__('pages.app_store_alt')); ?>">
                                </a>
                            <?php endif; ?>
                            <?php if(!empty($play_store_img)): ?>
                                <a href="<?php echo e($play_store_url); ?>">
                                    <img src="<?php echo e(asset($play_store_img)); ?>" alt="<?php echo e(__('pages.play_store_alt')); ?>">
                                </a>
                            <?php endif; ?>
                        </div>
                        <?php if(!empty($short_desc)): ?>
                            <div class="tk-appcompat">
                                <h6><i class="icon-bell"></i><?php echo e($short_desc); ?></h6>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if(!empty($mobile_app_image)): ?>
                    <div class="col-md-6 d-xl-block d-none align-self-end">
                        <figure class="tk-appiamge">
                            <img data-src="<?php echo e(asset($mobile_app_image)); ?>" alt="<?php echo e(__('pages.mobile_app_alt')); ?>">
                        </figure>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/mobile-app-block.blade.php ENDPATH**/ ?>