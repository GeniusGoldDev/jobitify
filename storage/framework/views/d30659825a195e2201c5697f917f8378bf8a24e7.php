<div class="col-lg-8 col-xl-9" wire:init="loadGigs" wire:target="keyword" wire:loading.class="tk-section-preloader" >
    <div class="preloader-outer" wire:loading wire:target="keyword">
        <div class="tk-preloader">
            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>" >
        </div>
    </div>
    <?php if( !empty($page_loaded) ): ?>
        <?php if(!empty($gigs) && $keyword !=''): ?>
            <h3><?php echo e($gigs->count() .' '.  __('general.search_result')); ?> “<?php echo e(clean($keyword)); ?>”</h3>
        <?php endif; ?>
        
        <?php if(!empty($gigs) && $gigs->count() > 0): ?>
            <ul class="tk-savelisting tk-searchgig_listing">
                <?php $__currentLoopData = $gigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.gig-item','data' => ['gig' => $gig,'addressFormat' => $address_format,'favGigs' => $fav_gigs,'userRole' => $roleName,'currencySymbol' => $currency_symbol,'isSaveItem' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('gig-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['gig' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($gig),'address_format' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($address_format),'fav_gigs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($fav_gigs),'user_role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($roleName),'currency_symbol' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currency_symbol),'is_save_item' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php echo e($gigs->links('pagination.custom')); ?>

        <?php else: ?>
            <div class="tk-submitreview">
                <figure>
                    <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                </figure>
                <h4><?php echo e(__('general.no_record')); ?></h4>
            </div> 
        <?php endif; ?>
    <?php else: ?>
        <div class="tk-section-skeleton">
            <?php for($i=0; $i < 3; $i++ ): ?>
                <div class="tk-box">
                    <div class="tk-skeleton-left">
                        <figure class="tk-line tk-img-area">
                        </figure>
                        <div class="align-items-center align-self-center tk-right-sk">
                            <div class="tk-right-sk-right">
                                <ul>
                                    <li class="tk-line tk-skeletontwo"></li>
                                    <li class="tk-line tk-skeletonfull"></li>
                                </ul>
                                <div class="tk-righ-sk-last">
                                    <div class="tk-line tk-skeletonfour"></div>
                                    <div class="tk-line tk-skeletonfive"></div>
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonfour"></div>
                                </div>
                            </div>
                            <div class="tk-skeltonprice">
                                <div class="tk-right-sk-end">
                                    <div class="tk-line tk-skeletoneight"></div>
                                    <div class="tk-line tk-skeletonseven"></div>
                                </div>
                                <hr class="tk-skeleton-divider">
                                <div class="tk-right-sk-end">
                                    <div class="tk-line tk-skeletonten"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-listview.blade.php ENDPATH**/ ?>