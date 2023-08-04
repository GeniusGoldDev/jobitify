
    <?php $__env->startSection('content'); ?>
    <main class="tk-main-bg">
        <section class="tk-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="tk-servicedetail">
                            <div class="tk-checkoutinfo">
                                <figure>
                                    <?php 
                                        $gig_image = 'images/default-img-100x100.png';
                                        if(!empty($gig->attachments) ){
                                            $files  = unserialize($gig->attachments);
                                            $images = $files['files'];
                                            $latest = current($images);
                                            if( !empty($latest) && substr($latest->mime_type, 0, 5) == 'image'){
                                                if(!empty($latest->sizes['100x100'])){
                                                    $gig_image = 'storage/'.$latest->sizes['100x100'];
                                                } elseif(!empty($latest->file_path)){
                                                    $gig_image = 'storage/'.$latest->file_path;
                                                }
                                            }
                                        }
                                    ?>
                                    <img width="300" height="300" src="<?php echo e(asset($gig_image)); ?>" class="" alt="<?php echo e(__('gig.alt_image')); ?>">
                                </figure>
                                <div class="tk-checkoutdetail">
                                    <h6>
                                        <?php $__currentLoopData = $gig->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(route('search-gigs', ['category_id' => $single->category_id])); ?>">
                                                <?php echo e($single->name); ?>

                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </h6>
                                    <h5><?php echo e($gig->title); ?></h5>
                                    <ul class="tk-blogviewdates tk-blogviewdatessm">
                                        <li>
                                            <i class="fas fa-star tk-yellow"></i>
                                            <em> <?php echo e(ratingFormat($gig->ratings_avg_rating)); ?> </em>
                                            <span>(<?php echo e($gig->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($gig->ratings_count)])); ?> ) </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php if( !$gig->addons->isEmpty() ): ?>
                                <div class="tk-gigfeatures">
                                    <div class="tk-boxtittle">
                                        <h4><?php echo e(__('gig.additional_features')); ?></h4>
                                    </div>
                                    <ul class="tk-additionalservices tk-additionalservicesvtwo">
                                        <?php $__currentLoopData = $gig->addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <div class="tk-form-checkbox gig-addons">
                                                    <input class="form-check-input tk-form-check-input-sm" type="checkbox" value="<?php echo e($single->id); ?>" id="addon-<?php echo e($single->id); ?>">
                                                    <label class="tk-additionolinfo" for="addon-<?php echo e($single->id); ?>">
                                                        <span><?php echo e($single->title); ?></span>
                                                        <em><?php echo nl2br($single->description); ?> </em>
                                                    </label>
                                                    <div class="tk-addcartinfoprice">
                                                        <h6><?php echo e(getPriceFormat($currency_symbol, $single->price)); ?></h6>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <aside>
                            <div class="tk-asideholder">
                                <div class='tk-asideboxsm'>
                                    <h5><?php echo e(__('gig.price_plan')); ?></h5>
                                </div>
                                <div class="tk-collapsepanel">
                                    <ul class="tk-pakagelist">
                                        <?php
                                            $plan_images = [
                                                0 => 'basic',
                                                1 => 'popular',
                                                2 => 'premium',
                                            ];    
                                        ?>
                                        <?php $__currentLoopData = $gig->gig_plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="tk-pakagelist-item <?php echo e($gig_plan_id == $single['id'] ? 'tk-active' : ''); ?>" data-plan_id="<?php echo e($single['id']); ?>">
                                            <a href="javascript:;">
                                                <img src="<?php echo e(asset('images/plan-icon-'.$plan_images[$key].'.jpg')); ?>">
                                                <span><?php echo e($single->title); ?></span>
                                                <em><?php echo e(getPriceFormat($currency_symbol, $single->price)); ?> <i  class="fas fa-check <?php echo e($gig_plan_id == $single['id'] ? '' : 'd-none'); ?>"></i></em>
                                            </a>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('gig.gig-cart-addons', ['planId' => $gig_plan_id,'gigAuthor' => $gig->author_id,'gigTitle' => $gig->title,'plan_id' => $gig_plan_id,'gig_author' => $gig->author_id,'downloadable' => $gig->downloadable,'gig_title' => $gig->title])->html();
} elseif ($_instance->childHasBeenRendered('lTvSgk2')) {
    $componentId = $_instance->getRenderedChildComponentId('lTvSgk2');
    $componentTag = $_instance->getRenderedChildComponentTagName('lTvSgk2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('lTvSgk2');
} else {
    $response = \Livewire\Livewire::mount('gig.gig-cart-addons', ['planId' => $gig_plan_id,'gigAuthor' => $gig->author_id,'gigTitle' => $gig->title,'plan_id' => $gig_plan_id,'gig_author' => $gig->author_id,'downloadable' => $gig->downloadable,'gig_title' => $gig->title]);
    $html = $response->html();
    $_instance->logRenderedChild('lTvSgk2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                        </aside>
                    </div>
                </div>
            </div>
        </section>
    </main>  
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?> 
    <script>
        setTimeout(function() {
            $(document).on("click",".tk-pakagelist-item",function(e){
                let _this = $(this);
                $('.tk-pakagelist-item').removeClass('tk-active');
                $('.fas fa-check').addClass('d-none');
                _this.addClass('tk-active');
                _this.find('i').removeClass('d-none');
                let plan_id = _this.data('plan_id');
                Livewire.emit('updatedPlanId', plan_id);
            });

            $('.tk-additionalservicesvtwo .tk-form-checkbox .form-check-input').change(function() {
                if ($(this).prop("checked")) {
                    $(this).parents("li").addClass("tk-active");
                }else{
                    $(this).parents("li").removeClass("tk-active");
                }
                let addon_ids = [];
                $(".tk-additionalservicesvtwo .tk-form-checkbox input[type='checkbox']:checked").each(function(){
                    addon_ids.push(this.value); 
                });

                Livewire.emit('gigCartAddonsIds', addon_ids);
            });
        }, 1000);
    </script>
<?php $__env->stopPush(); ?>  





<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/front-end/gig/gig-cart.blade.php ENDPATH**/ ?>