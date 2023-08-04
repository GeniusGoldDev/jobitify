<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['gig','fav_gigs', 'currency_symbol','is_save_item', 'user_role', 'address_format' => 'city_state_country']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['gig','fav_gigs', 'currency_symbol','is_save_item', 'user_role', 'address_format' => 'city_state_country']); ?>
<?php foreach (array_filter((['gig','fav_gigs', 'currency_symbol','is_save_item', 'user_role', 'address_format' => 'city_state_country']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<li id="gig_<?php echo e($gig->id); ?>" class="tk-tabbitem">
    <div class="tk-tabbitem__list tk-tabbitem__listtwo">
        <div class="tk-deatlswithimg">
            <figure>
                <?php 
                    $gig_image  = 'images/default-img-82x82.png';

                    if(!empty($gig->attachments) ){
                        $files  = unserialize($gig->attachments);
                        $images = $files['files'];
                        $latest = current($images);
                        if( !empty($latest) && substr($latest->mime_type, 0, 5) == 'image'){
                            if(!empty($latest->sizes['82x82'])){
                                $gig_image = 'storage/'.$latest->sizes['82x82'];
                            } elseif(!empty($latest->file_path)){
                                $gig_image = 'storage/'.$latest->file_path;
                            }
                        }
                    }

                    $status = getTag($gig->status);
                    
                ?>
                <img src="<?php echo e(asset($gig_image)); ?>" alt="<?php echo e(__('gig.alt_image')); ?>" >
            </figure>
            <div class="tk-icondetails">
                <div class="tk-verified-info">
                    <strong>
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
                    </strong>
                </div>

                <h6>
                    <a href="<?php echo e(route('gig-detail',['slug' => $gig->slug])); ?>"><?php echo e($gig->title); ?></a>
                </h6>
                <ul class="tk-rateviews tk-rateviews2">
                    <li>
                        <i class="fa fa-star tk-yellow"></i> 
                        <em> <?php echo e(ratingFormat($gig->ratings_avg_rating)); ?> </em> 
                        <span>(<?php echo e($gig->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($gig->ratings_count)])); ?> ) </span>
                    </li>
                    <li>
                        <i class="icon-eye"></i> 
                        <span> 
                            <?php echo e($gig->gig_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format( $gig->gig_visits_count) ] )); ?>

                        </span>
                    </li> 
                    <?php if($user_role == 'buyer' || Auth::guest()): ?>
                        <li>
                            <span class="tk-save-btn tk-fav-item <?php echo e(in_array($gig->id, $fav_gigs) || $is_save_item ? 'tk-favourite' : ''); ?>" wire:click.prevent="saveItem(<?php echo e($gig->id); ?>)">
                                <i class="icon-heart"></i> 
                                <em><?php echo e(in_array($gig->id, $fav_gigs) || $is_save_item ? __('general.saved') : __('general.save')); ?></em>
                            </span>
                        </li>
                    <?php endif; ?>
                    <?php if(!empty($gig->address)): ?>
                        <li>
                            <i class="icon-map-pin"></i>
                            <span><?php echo e(getUserAddress($gig->address, $address_format)); ?></address>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="tk-itemlinks tk-itemlinksvtwo">
            <div class="tk-startingprice">
                <i><?php echo e(__('gig.starting_from')); ?></i>
                <span><?php echo e(getPriceFormat($currency_symbol, $gig->minimum_price)); ?></span>
            </div>
            <ul class="tk-tabicon">
                <li>
                    <a href="<?php echo e(route('gig-detail',['slug' => $gig->slug])); ?>">
                        <span class="icon-external-link bg-gray"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</li><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/gig-item.blade.php ENDPATH**/ ?>