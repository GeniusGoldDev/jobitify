<div id="reviews" wire:init="loadReviews" class="tk-profilebox">
    <?php if( $page_loaded ): ?>
        
            <div class="tk-content-box tk-review-box">
                <h4>
                    <?php echo e(__('general.reviews')); ?>

                    <i class="fas fa-star tk-yellow"></i> 
                    <em>
                        <?php echo e(ratingFormat($reviews->avg('rating') )); ?>

                        (<?php echo e(__('general.user_reviews', ['count' => number_format( count($reviews))])); ?>)
                    </em>
                </h4>
                <?php if(!$reviews->isEmpty()): ?>
                    <?php  
                        $overallRatingPer = 0;
                        if(!empty($reviews->avg('rating'))){
                            $overallRatingPer = ($reviews->avg('rating')/5)*100;
                        }  
                        $counter = 0;
                    ?>
                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $counter++;
                            $hide = $counter > 5 ? true : false;
                        ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.review-item','data' => ['single' => $single,'hide' => $hide,'dateFormat' => $date_format]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('review-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['single' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single),'hide' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hide),'date_format' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($date_format)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($counter > 5): ?>
                        <div class="tk-readmore">
                            <a href="javascript:void(0)"><?php echo e(__('general.load_more')); ?></a>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="tk-noskills">
                        <span><?php echo e(__('general.no_review_found')); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
    <?php else: ?>
        <ul class="tk-frame">
            <?php for($i =1; $i<=3; $i++): ?>
                <li>
                    <div class="tk-frame-items">
                        <div class="tk-imgarea">
                            <figure class="tk-skele"></figure>
                            <div class="tk-img-deatil">
                                <div class="tk-title">
                                    <span class="tk-review tk-skele"></span>
                                    <span class="tk-review tk-skele"></span>
                                </div>
                                <span class="tk-review tk-skele"></span>
                            </div>
                        </div>
                        <span class="tk-skele"></span>
                        <span class="tk-frame-para tk-skele"></span>
                    </div>
                </li>
            <?php endfor; ?>
        </ul>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:load', function () {
            
            $(document).on('click','.tk-readmore', function(e){
                let _this = $(this);
                _this.remove()
                $('.tk-review-sec.d-none').removeClass('d-none');
            })
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/seller/seller-reviews.blade.php ENDPATH**/ ?>