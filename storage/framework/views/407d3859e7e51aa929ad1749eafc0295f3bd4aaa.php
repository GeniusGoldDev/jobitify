<section class="tk-testimonial tk-main-section-two <?php echo e($block_key); ?> <?php echo e($custom_class); ?>" <?php if(!$site_view): ?>  wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?>>
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
            <?php if(!empty($sub_title) || !empty($title) || !empty($description) ): ?>
                <div class="col-lg-8 col-sm-12">
                    <div class="tk-main-title-holder text-center">
                        <?php if(!empty($sub_title) || !empty($title) ): ?>
                            <div class="tk-maintitle">
                                <?php if(!empty($sub_title)): ?><h3 class="tk-colorgray"><?php echo $sub_title; ?></h3><?php endif; ?>
                                <?php if(!empty($title)): ?><h2><?php echo $title; ?></h2><?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($description)): ?>
                            <div class="tk-main-description">
                                <p><?php echo e($description); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(!empty($team_members)): ?>
                <div class="col-12">
                    <div id="tk-professionolslider" class="tk-professionolslider tk-popularcategories tk-sliderarrow">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <?php $__currentLoopData = $team_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="splide__slide">
                                        <div class="tk-profeesonitem">
                                            <?php if(!empty($member['image'])): ?>
                                                <figure>
                                                    <img data-src="<?php echo e(asset($member['image'])); ?>" alt="image">
                                                </figure>
                                            <?php endif; ?>

                                            <div class="tk-profeesonolinfo text-center">
                                                <h6><?php echo $member['designation']; ?></h6>
                                                <h4><?php echo $member['name']; ?></h4>
                                            </div>
                                            <ul class="tk-socailmedia tk-socialicons-two">
                                                <li><a class="tk-facebook" href="<?php echo e(!empty($member['facebook_link']) ? $member['facebook_link'] : 'javascript:void();'); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a class="tk-twitter" href="<?php echo e(!empty($member['twitter_link']) ? $member['twitter_link'] : 'javascript:void();'); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                                <li><a class="tk-linkedin" href="<?php echo e(!empty($member['linkedin_link']) ? $member['linkedin_link'] : 'javascript:void();'); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                                <li><a class="tk-twitch" href="<?php echo e(!empty($member['twitter_link']) ? $member['twitter_link'] : 'javascript:void();'); ?>" target="_blank"><i class="fab fa-twitch"></i></a></li>
                                                <li><a class="tk-dribbble" href="<?php echo e(!empty($member['dribbble_link']) ? $member['dribbble_link'] : 'javascript:void();'); ?>" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/pagebuilder/css/splide.min.css', 
    ]); ?>
<?php $__env->stopPush(); ?>
<?php 
    $rtl = setting('_site.rtl');
?>
<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('pagebuilder/js/splide.min.js')); ?>"></script>

    <script>
		document.addEventListener('livewire:load', function () {
            let tk_professionolslider = document.querySelector(".tk-professionolslider");
            if (tk_professionolslider !== null) {
                let settings = {
                    type: 'loop',
                    perPage: 4,
                    perMove: 1,
                    arrows: true,
                    pagination: false,
                    gap: 24,
                    breakpoints: {
                        1400: {
                            perPage: 3,
                        },
                        991: {
                            perPage: 2,
                            focus: 'center',
                        },
                        575: {
                            perPage: 2,
                            gap: 20,
                            arrows: false,
                            pagination: true,
                            focus: 'center',
                        },
                        480: {
                            perPage: 1,
                            arrows: false,
                            pagination: true,
                            focus: 'center',
                        },
                    }
                }
                
                let isRTL = '<?php echo e($rtl); ?>';
                if(isRTL == '1'){
                    settings['direction'] = 'rtl';
                }
                var splide = new Splide(".tk-professionolslider", settings);
                splide.mount();
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/professional-block.blade.php ENDPATH**/ ?>