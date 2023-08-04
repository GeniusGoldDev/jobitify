<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['profile', 'favourite_sellers', 'currency_symbol', 'is_save_item', 'user_role', 'address_format' => 'state_country']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['profile', 'favourite_sellers', 'currency_symbol', 'is_save_item', 'user_role', 'address_format' => 'state_country']); ?>
<?php foreach (array_filter((['profile', 'favourite_sellers', 'currency_symbol', 'is_save_item', 'user_role', 'address_format' => 'state_country']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="tk-project-wrapper-two tk-find-talent">
    <div class="tk-project-box tk-employerproject">
        <div class="tk-employerproject-title">
            <div class="tk-price-holder">
                <div class="tk-freelancer-search">
                    <figure>
                        <?php
                            if(!empty($profile->image)){
                                $image_url      = getProfileImageURL($profile->image, '100x100');
                                $seller_image   = !empty($image_url) ? 'storage/'.$image_url : '/images/default-user-100x100.png';
                            }else{
                                $seller_image   = 'images/default-user-100x100.png';
                            }
                        ?>
                        <img src="<?php echo e(asset($seller_image)); ?>" alt="<?php echo e($profile->full_name); ?>">
                    </figure>
                    <div class="tk-freelancer-content-two">
                        <a href="<?php echo e(route('seller-profile', ['slug' => $profile->slug])); ?>">
                            <?php echo e($profile->full_name); ?>

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
                        </a>
                        <h5><?php echo e(add3DotsInText($profile->tagline, ' ...', 70)); ?></h5>
                        <ul class="tk-blogviewdatessm">
                            <li>
                                <i class="fas fa-star tk-yellow"></i>
                                <em> <?php echo e(ratingFormat( $profile->ratings_avg_rating )); ?> </em>
                                <span>( <?php echo e($profile->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($profile->ratings_count) ])); ?> )</span>
                            </li>
                            <?php if(!empty($profile->address)): ?>
                                <li>
                                    <span>
                                        <i class="icon-map-pin"></i>
                                        <?php echo e(getUserAddress($profile->address, $address_format)); ?>

                                    </span>
                                </li>
                            <?php endif; ?>
                            <li>
                                <span>
                                    <i class="icon-eye"></i>
                                    <?php echo e($profile->profile_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format($profile->profile_visits_count) ] )); ?>

                                </span>
                            </li>
                            <?php if($user_role == 'buyer' || Auth::guest()): ?>
                                <li class="tk-saved <?php echo e(in_array($profile->id, $favourite_sellers) || $is_save_item ? 'tk-liked' : ''); ?> mt-0" wire:click.prevent="saveItem(<?php echo e($profile->id); ?>)">
                                    <a href="javascript:void(0)"><i class="icon-heart"></i><?php echo e(__('general.saved')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="tk-price-two">
                    <span><?php echo e(__('general.starting_from')); ?></span>
                    <h4><?php echo e(__('general.per_hour_rate', ['rate' => number_format($profile->user->userAccountSetting->hourly_rate, 2), 'currency_symbol' => $currency_symbol])); ?></h4>
                    <div class="tk-project-option">
                        <a href="<?php echo e(route('seller-profile', ['slug' => $profile->slug])); ?>" target="_blank" class="tk-invite-bidbtn"><?php echo e(__('proposal.view_profile')); ?></a>
                    </div>
                </div>
            </div>
            <div class="tk-tags-holder">
                <?php if(!empty($profile->description)): ?>
                    <?php 
                        $desc = $profile->description;
                        $short_desc = add3DotsInText($desc, ' ...', 170);
                    ?>
                    <div class="tk-descriptions">
                        <p>
                            <?php echo nl2br($short_desc); ?>

                        </p>
                    </div>
                <?php endif; ?>
                <?php if( !$profile->skills->isEmpty() ): ?>
                <div class="tk-freelancer-holder">
                    <ul class="tk-tags_links">
                    <?php $__currentLoopData = $profile->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><span class="tk-blog-tags"><?php echo e($skill->name); ?></span></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/seller-item.blade.php ENDPATH**/ ?>