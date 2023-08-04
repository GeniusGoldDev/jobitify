<div class="row" wire:init="loadGigs" wire:target="keyword" wire:loading.class="tk-section-preloader">
    <div class="col-lg-12">
        <div class="tk-sort">
            <?php if(!empty($gigs) && !EMPTY($keyword) ): ?>
                <h3 class="tk-search"><?php echo e($gigs->count() .' '.  __('general.search_result')); ?> “<?php echo e(clean($keyword)); ?>”</h3>
            <?php endif; ?>
            
        </div>
    </div>
    <?php if(!empty($page_loaded)): ?>
        <?php if( !empty($gigs) && $gigs->count() > 0 ): ?>
            <?php $__currentLoopData = $gigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div id="gig_<?php echo e($gig->id); ?>" class="col-sm-12 col-md-6 col-lg-3">
                    <div class="tk-topservicetask">
                        <figure class="tk-card__img">
                            <?php 
                                $percentage = 0;
                                $gig_image = 'images/default-img-286x186.png';
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
                                if(!empty($gig->ratings_avg_rating)){
                                    $percentage = ($gig->ratings_avg_rating/5)*100;
                                }
                            ?>

                            <a href="<?php echo e(route('gig-detail',['slug' => $gig->slug])); ?>">
                                <img src="<?php echo e(asset($gig_image)); ?>" alt="<?php echo e(__('gig.alt_image')); ?>">
                            </a>
                        </figure>

                        <?php if($gig->is_featured): ?>
                            <span class="tk-featuretag"><?php echo e(__('general.featured')); ?></span>
                        <?php endif; ?>

                        <div class="tk-sevicesinfo">
                            <div class="tk-topservicetask__content">
                                <div class="tk-title-wrapper">
                                    <div class="tk-card-title">
                                        <a href="<?php echo e(route('seller-profile', ['slug' => $gig->gigAuthor->slug ])); ?>">
                                            <?php echo e($gig->gigAuthor->full_name); ?>

                                        </a>
                                        <?php if($gig->gigAuthor->user->userAccountSetting->verification == 'approved'): ?>
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
                                        <?php if($roleName == 'buyer' || Auth::guest()): ?>
                                            <div class="tk-like <?php echo e(in_array($gig->id, $fav_gigs) ? 'tk-heartsave' : ''); ?>">
                                                <a href="javascript:void(0);" class="tb_saved_items <?php echo e(in_array($gig->id, $fav_gigs) ? 'tk-heartsave' : ''); ?>" wire:click.prevent="saveItem(<?php echo e($gig->id); ?>)">
                                                    <i class="icon-heart"></i></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <h5><a href="<?php echo e(route('gig-detail',['slug' => $gig->slug])); ?>"><?php echo e($gig->title); ?></a></h5>
                                </div>
                                <div class="tk-featureRating">
                                    <div class="tk-featureRating tk-featureRatingv2">
                                        <span class="tk-featureRating__stars"><span style="width:<?php echo e($percentage); ?>%;"></span></span>
                                        <h6><?php echo e(ratingFormat($gig->ratings_avg_rating)); ?> <em>/5.0</em></h6>
                                        <em>( <?php echo e($gig->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($gig->ratings_count)])); ?> )</em>
                                    </div>
                                    <?php if(!empty($gig->address)): ?>
                                        <address>
                                            <i class="icon-map-pin"></i><?php echo e(getUserAddress($gig->address, $address_format)); ?>

                                        </address>
                                    <?php endif; ?>
                                </div>
                                <div class="tk-startingprice">
                                    <i><?php echo e(__('gig.starting_from')); ?></i>
                                    <span> <?php echo e(getPriceFormat($currency_symbol, $gig->minimum_price)); ?> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="col-sm-12">
                <?php echo e($gigs->links('pagination.custom')); ?>

            </div>
        <?php else: ?>
            <div class="col-sm-12">
                <div class="tk-submitreview">
                    <figure>
                        <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                    </figure>
                    <h4><?php echo e(__('general.no_record')); ?></h4>
                </div> 
            </div>
        <?php endif; ?>
    <?php else: ?> 
        <div class="tk-skelton-wrapper">
            <ul class="tk-services-skeleton tk-services-skeletonvtwo">
                <?php for($i=0; $i < 4; $i++ ): ?>
                    <li>
                        <div class="tk-skeletonarea">
                            <figure class="tk-skele"></figure>
                            <div class="tk-content-area">
                                <span class="tk-skeleton-title tk-skele"></span>
                                <span class="tk-skeleton-description tk-skele"></span>
                                <span class="tk-skeleton-paravtwo tk-skele"></span>
                                <span class="tk-skeleton-description tk-skele"></span>
                                <span class="tk-skeleton-description tk-skele"></span>
                            </div>
                        </div>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            setTimeout(() => {
                iniliazeSelect2Scrollbar();
            }, 100);

            $(document).on('change','#tk_gig_type', function (e) {
                let sortBy = $('#tk_gig_type').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('sort_by', sortBy)
            });
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-gridview.blade.php ENDPATH**/ ?>