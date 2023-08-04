<main class="tk-main-bg">
    <section class="tk-main-section" wire:loading.class="tk-section-preloader">
        <div class="preloader-outer" wire:loading>
            <div class="tk-preloader">
                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php if(!$gigs_orders->isEmpty() && $search_gig !=''): ?><h3><?php echo e($gigs_orders->count() .' '.  __('general.search_result')); ?> “<?php echo e($search_gig); ?>”</h3><?php endif; ?>
                </div>
                <div class="col-xl-12">
                    <div class="tk-project-wrapper tk-template-project">
                        <div class="tk-template-serach ">
                            <h5> <?php echo e($filter_gig != '' ? __('general.'.$filter_gig)  :  __('gig.all_orders')); ?> </h5>
                            <div class="tk-search-wrapper">
                                <div class="tk-inputicon">
                                    <input type="text" wire:model.debounce.500ms="search_gig" class="form-control" placeholder="<?php echo e(__('general.search_with_keyword')); ?>">
                                    <i class="icon-search"></i>
                                </div>
                                <div class="tk-sort">
                                    <div class="tk-sortby" wire:ignore>
                                        <?php  
                                            $gig_statuses = [
                                                'all'       => __('gig.all_orders'),
                                                'hired'     => __('general.hired'),
                                                'completed' => __('general.completed'),
                                                'disputed'  => __('general.disputed'),
                                                'refunded'  => __('general.refunded'),
                                            ];
                                        ?>
                                        <div class="tk-actionselect">
                                            <div class="tk-select">
                                                <select id="filter_gig" class="form-control tk-selectprice">
                                                    <?php $__currentLoopData = $gig_statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value ="<?php echo e($key != 'all' ? $key : ''); ?>" <?php echo e($filter_gig == $key ? 'selected' : ''); ?> > <?php echo e($status); ?> </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if( !$gigs_orders->isEmpty() ): ?>
                        <?php $__currentLoopData = $gigs_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $tag = getTag( $single->status );
                            ?>
                            <div class="tk-project-wrapper-two tk-gigorder">
                                <div class="tk-project-box">
                                    <div class=" tk-price-holder">
                                        <div class="tk-verified-info">
                                            <div class="tk-verified-info-tags">
                                                <span class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></span>
                                            </div>
                                            <?php if($single->gig->is_featured): ?>
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.featured-tippy','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('featured-tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            <?php endif; ?>
                                            <div class="tk-checkoutdetail">
                                                <h6>
                                                    <?php $__currentLoopData = $single->gig->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <a href="<?php echo e(route('search-gigs', ['category_id' => $cat->category_id])); ?>">
                                                            <?php echo e($cat->name); ?>

                                                        </a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </h6>
                                            </div>
                                            <h5><a href="<?php echo e(route('gig-activity', ['slug' => $single->gig->slug, 'order_id' => $single->id])); ?>" target="_blank"><?php echo e($single->gig->title); ?></a></h5>
                                        </div>
                                        <div class="tk-price">
                                            <span> <?php echo e(__('gig.order_budget')); ?></span>
                                            <h4><?php echo e(getPriceFormat($currency_symbol, $single->plan_amount)); ?></h4>
                                        </div>
                                    </div>
                                    
                                   
                                    <?php if( !empty($single->ratings) ): ?>
                                         <?php
                                            if( !empty($single->orderAuthor->image) ){
                                                $image_path     = getProfileImageURL( $single->orderAuthor->image, '50x50' );
                                                $buyer_image   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-50x50.png';
                                            }else{
                                                $buyer_image = '/images/default-user-50x50.png';
                                            }
                                            $rating_percentage = ($single->ratings->rating/5)*100;
                                        ?>            
                                        <div class="tb-userfeedback">
                                            <img src="<?php echo e($buyer_image); ?>" alt="<?php echo e($single->orderAuthor->full_name); ?>">
                                            <div class="tb-userfeedback__title">
                                                <div class="tb-featureRating tb-featureRatingv2">
                                                    <span class="tb-featureRating__stars "><span style="width:<?php echo e($rating_percentage); ?>%;"></span></span>
                                                    <h6><?php echo e(number_format( $single->ratings->rating, 1 )); ?></h6>
                                                    <a href="javascript:void(0);" wire:click.prevent="readReview(<?php echo e($single->id); ?>)" >(<?php echo e(__('gig.view_feedback')); ?>)</a>
                                                </div>
                                                <h6><?php echo e($single->orderAuthor->full_name); ?></h6>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="tb-extras tb-extrascompleted">
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                                    <?php
                                                        if( !empty($single->gig->gigAuthor->image) ){
                                                            $image_path     = getProfileImageURL( $single->gig->gigAuthor->image, '50x50' );
                                                            $seller_image   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-50x50.png';
                                                        }else{
                                                            $seller_image = '/images/default-user-50x50.png';
                                                        }
                                                    ?>
                                                    <figure>
                                                        <img src="<?php echo e(asset($seller_image)); ?>" alt="<?php echo e($single->gig->gigAuthor->full_name); ?>" >
                                                    </figure>
                                                    <div class="tb-taskinfo">
                                                        <span><?php echo e(__('gig.gig_by')); ?></span>
                                                        <h6><?php echo e($single->gig->gigAuthor->full_name); ?></h6>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                                    <?php
                                                        if( !empty($single->orderAuthor->image) ){
                                                            $image_path     = getProfileImageURL( $single->orderAuthor->image, '50x50' );
                                                            $buyer_image   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-50x50.png';
                                                        }else{
                                                            $buyer_image = '/images/default-user-50x50.png';
                                                        }
                                                    ?>  
                                                    <figure>
                                                        <img src="<?php echo e(asset($buyer_image)); ?>" alt="<?php echo e($single->orderAuthor->full_name); ?>" >
                                                    </figure>
                                                    <div class="tb-taskinfo">
                                                        <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                                            <span><?php echo e(__('gig.order_by')); ?></span>
                                                            <h6><?php echo e($single->orderAuthor->full_name); ?></h6>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span><?php echo e(__('gig.start_date')); ?></span>
                                                    <h6><?php echo e(date('M d, Y',  strtotime($single->gig_start_time))); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span><?php echo e(__('gig.deadline')); ?></span>
                                                    <h6><?php echo e(date('M d, Y', strtotime('+'.$single->gig_delivery_days.'days', strtotime($single->gig_start_time)))); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span><?php echo e(__('gig.additional_addons')); ?></span>
                                                    <?php
                                                        $gig_addons = 0;
                                                        if( !empty($single->gig_addons) ){
                                                            $gig_addons = count(unserialize($single->gig_addons));
                                                        }
                                                    ?>
                                                    <h6><?php echo e($gig_addons); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tb-tabitemextras">
                                            <div class="tb-tabitemextrasinfo">
                                                <div class="tb-taskinfo">
                                                    <span><?php echo e(__('gig.plan_type')); ?></span>
                                                    <h6><?php echo e($single->plan_type); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if( !empty($single->downloadable) && in_array( $single->status, array('completed', 'hired'))): ?>
                                            <div class="tb-tabitemextras">
                                                <div class="tb-tabitemextrasinfo">
                                                    <div class="tb-taskinfo">
                                                        <span><?php echo e(__('gig.downloadable')); ?></span>
                                                        <a href="javascript:;" wire:click.prevent="downloadAttachments(<?php echo e($single->id); ?>)">
                                                            <span class="icon-download"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="tk-submitreview">
                            <figure>
                                <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                            </figure>
                            <h4><?php echo e(__('general.no_record')); ?></h4>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if(!$gigs_orders->isEmpty()): ?>
                    <div class="col-sm-12">
                        <?php echo e($gigs_orders->links('pagination.custom')); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <div class="modal fade tb-excfreelancerpopup" id="tk_read_review" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content" id="tb_tk_viewrating">
                <div class="tb-popuptitle">
                    <h4><?php echo e($review_detail['gig_title']); ?></h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <div class="tb-excfreelancerpopup__content">
                        <figure class="tb-ratinguserimg">
                            <img src="<?php echo e($review_detail['image']); ?>" alt="<?php echo e($review_detail['user_name']); ?>">
                        </figure>
                        <div class="tb-featureRating tb-featureRatingv2">
                            <span class="tb-featureRating__stars"><span style="width:<?php echo e($review_detail['avg_rating'].'%'); ?>" ></span></span>
                            <h6> <?php echo e(number_format((float)$review_detail['rating'], 1, '.', '')); ?></h6>
                        </div>
                        <h2><?php echo e($review_detail['rating_title']); ?></h2>
                        <?php if( $review_detail['rating_desc'] ): ?>
                            <p><?php echo e($review_detail['rating_desc']); ?> </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
<script defer src="<?php echo e(asset('js/app.js')); ?>"></script>
<script>
    document.addEventListener('livewire:load', function () {

        window.addEventListener('ReadReviewPopup', event => { 
            jQuery('#tk_read_review').modal(event.detail);
        });

        setTimeout(function() {
            $('#filter_gig').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_gig').on('change', function (e) {
                let filter_gig = $('#filter_gig').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_gig', filter_gig);
            });

            iniliazeSelect2Scrollbar();
        }, 50);
    });

</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-orders.blade.php ENDPATH**/ ?>