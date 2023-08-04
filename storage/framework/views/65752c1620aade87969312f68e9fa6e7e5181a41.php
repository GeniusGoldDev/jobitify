<div class="col-lg-8 col-xl-9" wire:init="loadSellers" >
    <div class="tk-section-holder" wire:loading.class="tk-section-preloader" wire:target="selected_skills,keyword,selected_languages,selected_english_level,selected_seller_types,selected_location,order_by">
        <div class="preloader-outer" wire:loading  wire:target="selected_skills,keyword,selected_languages,selected_english_level,selected_seller_types,selected_location,order_by">
            <div class="tk-preloader">
                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>" >
            </div>
        </div>
        <?php if( !empty($isloadedPage) ): ?>
            <?php if( !$sellers->isEmpty() ): ?>
                <?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seller-item','data' => ['profile' => $single,'userRole' => $roleName,'favouriteSellers' => $favourite_sellers,'currencySymbol' => $currency_symbol,'isSaveItem' => false,'addressFormat' => $address_format]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('seller-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['profile' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single),'user_role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($roleName),'favourite_sellers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($favourite_sellers),'currency_symbol' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currency_symbol),'is_save_item' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'address_format' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($address_format)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="tk-submitreview">
                    <figure>
                        <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                    </figure>
                    <h4><?php echo e(__('general.no_record')); ?></h4>
                </div>
            <?php endif; ?> 
            <?php if(!$sellers->isEmpty()): ?>
                <div class="col-sm-12">
                    <?php echo e($sellers->links('pagination.custom')); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-skeleton','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search-skeleton'); ?>
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
    </div>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/components/search-sellers.blade.php ENDPATH**/ ?>