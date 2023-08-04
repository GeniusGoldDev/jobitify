<div id="portfolio" wire:init="loadPortfolios"  class="tk-profilebox">
    <div class="tk-content-box">
        <h4><?php echo e(__('general.all_portfolio')); ?></h4>
    </div>
    <?php if( $page_loaded ): ?>
        <?php if( !$portfolios->IsEmpty() ): ?>
            <div class="swiper tk-portfolio-slider tk-swiperdotsvtwo">
                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $portfolios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $portfolio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.portfolio-item','data' => ['data' => $portfolio]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('portfolio-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($portfolio)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="tk-swipernav">
                    <div class="sliderarrow__prev"><i class="icon-chevron-left"></i></div>
                    <div class="swiper-pagination"></div>
                    <div class="sliderarrow__next"><i class="icon-chevron-right"></i></div>
                </div>
            </div>
        <?php else: ?>
            <div class="tk-noskills">
                <span><?php echo e(__('general.no_content_added')); ?></span>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="tk-skeleton">
            <ul class="tk-services-skeleton">
                <?php for($i =1; $i<=3; $i++): ?>
                    <li>
                        <div class="tk-skeletonarea">
                            <figure class="tk-skele"></figure>
                            <div class="tk-content-area">
                                <span class="tk-skeleton-title tk-skele"></span>
                                <span class="tk-skeleton-description tk-skele"></span>
                                <span class="tk-skeleton-para tk-skele"></span>
                                <div class="tk-skeleton-user">
                                    <span class="tk-user-icon tk-skele"></span>
                                    <span class="tk-user tk-skele"></span>
                                </div>
                                <div class="tk-skeleton-user">
                                    <span class="tk-user-icon tk-skele"></span>
                                    <span class="tk-user tk-skele"></span>
                                </div>
                                <span class="tk-skeleton-details tk-skele"></span>
                                <span class="tk-skeleton-details tk-skele"></span>
                            </div>
                        </div>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/pagebuilder/css/swiper-bundle.min.css', 
    ]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>

    <script>
       window.addEventListener('initializePortfolioSlider', event=>{
            let data                = [];
            data['selector']        = 'tk-portfolio-slider'; 
            data['preview_count']   = 3;
            initPortfolioSlider(data);

            if($('.tk-profilemain').find('.swiper-button-lock').hasClass('swiper-button-disabled')){
                $('.tk-profilemain').find('.swiper-button-lock').parent().addClass('d-none');
            }
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/seller/seller-portfolios.blade.php ENDPATH**/ ?>