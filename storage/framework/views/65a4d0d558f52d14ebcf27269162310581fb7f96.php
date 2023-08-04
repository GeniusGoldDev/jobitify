<main class="tk-main-bg">
    <section class="tk-main-section" wire:target="keyword" wire:loading.class="tk-section-preloader" >
        <div class="preloader-outer" wire:loading wire:target="keyword">
            <div class="tk-preloader">
                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12" data-select2-id="9">
                    <div class="tb-dhb-mainheading" data-select2-id="8">
                        <h2><?php echo e(__('general.fav_items_label')); ?></h2>
                    </div>
                </div>
                <div class="col-xl-12">
                   
                    <div class="tk-project-wrapper tk-template-project tk-template-projectvtwo">
                        <div class="tk-template-serach">
                            <?php if( $filter_by == 'project' ): ?>
                                <h5><?php echo e(__('project.all_projects')); ?></h5>
                            <?php elseif( $filter_by == 'gig' ): ?>
                                <h5><?php echo e(__('general.all_gigs')); ?></h5>
                            <?php elseif($filter_by == 'profile'): ?>
                                <h5><?php echo e(__('general.all_sellers')); ?></h5>
                            <?php endif; ?>
                            <div class="tk-inputicon">
                                <input type="text" class="form-control" wire:model.debounce.500ms="search" placeholder="<?php echo e(__('general.search')); ?>">
                                <i class="icon-search"></i>
                            </div>

                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                <div class="tk-sortby">
                                    <div class="tk-actionselect tk-actionselect2">
                                        <span><?php echo e(__('gig.filter_by')); ?></span>
                                        <div class="tk-select" wire:ignore>
                                            <select id="tk_item_type" data-hide_search_opt="true" class="form-control tk-select2">
                                                <option value="gig"> <?php echo e(__('general.all_gigs')); ?> </option>
                                                <option value="profile" selected> <?php echo e(__('general.all_sellers')); ?> </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php if( !$items->isEmpty() ): ?>
                        <?php if($filter_by == 'gig'): ?>
                            <ul class="tk-savelisting tk-searchgig_listing">
                        <?php endif; ?>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $item = null;
                                if($filter_by == 'project'){
                                    $item = $single->projects;
                                } elseif( $filter_by == 'gig' ){
                                    $item = $single->gigs;
                                } elseif( $filter_by == 'profile' ){
                                    $item = $single->sellers;
                                }
                            ?>

                            <?php if( $filter_by == 'project' ): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.project-item','data' => ['project' => $item,'userRole' => 'seller','currencySymbol' => $currency_symbol,'listType' => 'fav_project','addressFormat' => $address_format]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('project-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['project' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item),'user_role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('seller'),'currency_symbol' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currency_symbol),'list_type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('fav_project'),'address_format' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($address_format)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php elseif( $filter_by == 'gig' ): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.gig-item','data' => ['gig' => $item,'userRole' => 'buyer','addressFormat' => $address_format,'currencySymbol' => $currency_symbol,'favGigs' => [],'isSaveItem' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('gig-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['gig' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item),'user_role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('buyer'),'address_format' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($address_format),'currency_symbol' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currency_symbol),'fav_gigs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'is_save_item' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php elseif( $filter_by == 'profile' ): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seller-item','data' => ['userRole' => 'buyer','profile' => $item,'favouriteSellers' => [],'currencySymbol' => $currency_symbol,'isSaveItem' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('seller-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user_role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('buyer'),'profile' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item),'favourite_sellers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'currency_symbol' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currency_symbol),'is_save_item' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                          
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if($filter_by == 'gig'): ?>
                            </ul>
                        <?php endif; ?>
                        
                        <?php if(!$items->isEmpty()): ?>
                            <div class="col-sm-12">
                                <?php echo e($items->links('pagination.custom')); ?>

                            </div>
                        <?php endif; ?>
                    <?php else: ?> 
                        <div class="tk-submitreview">
                            <figure>
                                <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                            </figure>
                            <h4><?php echo e(__('general.no_record')); ?></h4>
                        </div>
                    <?php endif; ?>
                </div>
                    
            </div>
        </div>
    </section>
    <div wire:igonre.self class="modal fade" id="declined_proposal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog tk-modal-dialog-default modal-dialog-centered">
            <div class="modal-content">
            <div class="tk-popuptitle">
                <h5><?php echo e(__('proposal.employer_comments')); ?></h5>
                <a href="javascrcript:void(0)" data-bs-dismiss="modal" class="close">
                    <i class="icon-x"></i>
                </a>
            </div>
            <div class="modal-body tk-popup-content">
                <div class="tk-statusview_alert">
                    <span><i class="icon-info"></i><?php echo e(__('proposal.decline_text')); ?></span>
                </div>
                <div class="tk-popup-info">
                    <div class="tk-user-content">
                        <img class="buyer-image">
                        <div class="tk-user-info">
                            <h6 class="buyer-name"></h6>
                        </div>
                    </div>
                </div>
                <div class="tk-popup-info">
                    <h6 class="seller-name"></h6>
                    <p class="decline-reason"></p>
                </div>
            </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?> "></script>
    <script defer src="<?php echo e(asset('js/app.js')); ?>"></script>

    <script>
        document.addEventListener('livewire:load', function () {
            setTimeout(() => {
                iniliazeSelect2Scrollbar();
            }, 1000);
            $('#tk_item_type').on('change', function (e) {
                let item_type = $('#tk_item_type').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_by', item_type);
            });

            window.addEventListener('declinedProposal', event => {
                $('.tk-user-info .buyer-name').text(event.detail.buyerName);
                $('.tk-user-content .buyer-image').attr('src', event.detail.buyerImage);
                $('.tk-popup-info .seller-name').text(event.detail.sellerName);
                $('.tk-popup-info .decline-reason').text(event.detail.declineReason);
                jQuery('#declined_proposal').modal('show');
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/favourite-items/favourite-items.blade.php ENDPATH**/ ?>