
<section class="tk-main-sectionv2 tk-ouraim-section <?php echo e($block_key); ?> <?php echo e($custom_class); ?>" <?php if(!$site_view): ?> wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?> >
    <div class="container" wire:loading.class="tk-section-preloader">
        <?php if(!$site_view): ?>
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
        <?php endif; ?>
        <div class="row align-items-center">
            <?php if(!empty($title) || !empty($sub_title) || !empty($description) || !empty($search_btn_txt)): ?>
                <div class="col-xl-5">
                    <div class="tk-main-title-holder">
                        <?php if(!empty($title) || !empty($sub_title) ): ?>
                            <div class="tk-maintitle">
                                <?php if(!empty($sub_title)): ?><h5><?php echo $sub_title; ?></h5><?php endif; ?>
                                <?php if(!empty($title)): ?><h2><?php echo $title; ?></h2><?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($description)): ?>
                            <div class="tk-main-description">
                                <p><?php echo $description; ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($search_btn_txt)): ?>
                            <div class="tk-btn-holder">
                                <a href="<?php echo e(route('search-sellers')); ?>" class="tk-btn-yellow-lg"><?php echo $search_btn_txt; ?> <i class="icon-user-check"></i> </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(!empty($main_image) || !empty($card_image) ): ?>
                <div class="col-md-12 col-xl-7">
                    <div class="tk-about-image">
                        <figure>
                            <?php if(!empty($main_image)): ?>
                                <img src="<?php echo e(asset($main_image)); ?>" alt="image">
                            <?php endif; ?>
                            <?php if(!empty($card_image)): ?>
                                <figcaption>
                                    <img src="<?php echo e(asset($card_image)); ?>" alt="image">
                                </figcaption>
                            <?php endif; ?>
                        </figure>
                    </div>    
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/search-talent-block.blade.php ENDPATH**/ ?>