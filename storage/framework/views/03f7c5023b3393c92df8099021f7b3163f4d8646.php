<div id="gigs" wire:init="loadGigs"  class="tk-profilebox">
    <div class="tk-content-box">
        <h4><?php echo e(__('gig.gig_offered_title', ['user_name' => $seller_name])); ?></h4>
    
        <?php if( $page_loaded ): ?>
            <?php if( !$gigs->IsEmpty() ): ?>
                <div class="swiper tk-servicesslider tk-swiperdotsvtwo">
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $gigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide">
                                <div class="tk-topservicetask">
                                        <figure class="tk-card__img">
                                            <?php 
                                                $gig_image      = 'images/default-img-286x186.png';

                                                if(!empty($gig->attachments) ){
                                                    $files  = unserialize($gig->attachments);
                                                    $images = $files['files'];
                                                    $latest = current($images);
                                                    if( !empty($latest) && substr($latest->mime_type, 0, 5) == 'image'){
                                                        if(!empty($latest->sizes['286x186'])){
                                                            $gig_image = 'storage/'.$latest->sizes['286x186'];
                                                        } elseif(!empty($latest->file_path)){
                                                            $gig_image = 'storage/'.$latest->file_path;
                                                        }
                                                    }
                                                }
                                            ?>
                                            <a href="javascript:;">
                                                <img src="<?php echo e(asset($gig_image)); ?>"  alt="<?php echo e($gig->title); ?>">
                                            </a>
                                        </figure>
                                        <?php if($gig->is_featured): ?>
                                            <span class="tk-featuretag"><?php echo e(__('general.featured')); ?></span>
                                        <?php endif; ?>
                                    <div class="tk-sevicesinfo">
                                        <div class="tk-topservicetask__content">
                                            <div class="tk-title-wrapper">
                                                <div class="tk-card-title">
                                                    <a href="javasacript:;">
                                                        <?php echo e($seller_name); ?>

                                                    </a>
                                                    <?php if( $verify_status == 'approved'): ?>
                                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.verified-tippy','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('verified-tippy'); ?>
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
                                                    <?php if($user_role == 'buyer' || Auth::guest()): ?>
                                                        <div class="tk-like <?php echo e(in_array($gig->id, $fav_gigs) ? 'tk-heartsave' : ''); ?>">
                                                            <a href="javascript:void(0);" wire:click.prevent="favouriteGig(<?php echo e($gig->id); ?>)" class="tb_saved_items bg-heart"><i class="icon-heart"></i></a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <h5><a href="<?php echo e(route('gig-detail',['slug' => $gig->slug])); ?>"><?php echo $gig->title; ?></a></h5>
                                            </div>
                                            <div class="tk-featureRating">
                                                <div class="tk-featureRating tk-featureRatingv2">
                                                    <i class="fas fa-star tk-yellow"></i>
                                                    <h6><?php echo e(ratingFormat($gig->ratings_avg_rating)); ?> <em>/5.0</em></h6>
                                                    <em> <?php echo e(__('general.reviews')); ?></em>
                                                </div>
                                                <?php if( !empty($gig->address) ): ?>
                                                    <address>
                                                        <i class="icon-map-pin"></i><?php echo e(getUserAddress($gig->address, $address_format)); ?>

                                                    </address>
                                                <?php endif; ?>
                                            </div>
                                            <div class="tk-startingprice">
                                                <i><?php echo e(__('gig.starting_from')); ?></i>
                                                <span> <?php echo e(getPriceFormat($currency_symbol, $gig->gig_plans->min('price'))); ?> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
</div>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/pagebuilder/css/swiper-bundle.min.css', 
    ]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('pagebuilder/js/swiper-bundle.min.js')); ?>"></script>
<script defer src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script>
       window.addEventListener('initializeSlider', event=>{
            let data = [];
            data['selector']        = 'tk-servicesslider'; 
            data['preview_count']   = 3;
            initSwiperSlider(data);
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/seller/seller-gigs.blade.php ENDPATH**/ ?>