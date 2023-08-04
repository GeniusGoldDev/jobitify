<div class="col-lg-8 col-xl-9" wire:init="loadProjects">
    <?php if( !empty($isloadedPage) ): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="tk-section-holder" wire:loading.class="tk-section-preloader">
                    <div class="preloader-outer" wire:loading >
                        <div class="tk-preloader">
                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                        </div>
                    </div>
                        <?php if(!$projects->isEmpty()): ?>
                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.project-item','data' => ['favouriteProjects' => $favourite_projects,'project' => $single,'userRole' => $user_role,'currencySymbol' => $currency_symbol,'listType' => 'search_project','addressFormat' => $address_format]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('project-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['favourite_projects' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($favourite_projects),'project' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($single),'user_role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user_role),'currency_symbol' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currency_symbol),'list_type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('search_project'),'address_format' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($address_format)]); ?>
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
                                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                    <a href="<?php echo e(route('create-project')); ?>" class="tk-btn-solid-lefticon"> <?php echo e(__('project.add_new_project')); ?> </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    
                </div>
            </div>
            <?php if( !$projects->isEmpty() ): ?>
                <div class="col-sm-12">
                    <?php echo e($projects->links('pagination.custom')); ?>

                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="tk-section-skeleton">
            <?php for($i=0; $i < 3; $i++ ): ?>
                <div class="tk-box">
                    <ul class="fixposition">
                        <li class="tk-line tk-skeletontwo"></li>
                    </ul>
                    <div class="tk-skeleton-left">
                        <div class="tk-right-sk">
                            <div class="tk-right-sk-right">
                                <div class="tk-skeltontop">
                                    <div>
                                        <ul>
                                            <li class="tk-line tk-skeletontwo"></li>
                                            <li class="tk-line tk-skeletonthree"></li>
                                        </ul>
                                        <div class="tk-righ-sk-last">
                                            <div class="tk-line tk-skeletonfour"></div>
                                            <div class="tk-line tk-skeletonfive"></div>
                                            <div class="tk-line tk-skeletonsix"></div>
                                            <div class="tk-line tk-skeletonsix"></div>
                                            <div class="tk-line tk-skeletonsix"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="tk-skeltonprice">
                                            <div class="tk-right-sk-end">
                                                <div class="tk-line tk-skeletonseven"></div>
                                                <div class="tk-line tk-skeletoneight"></div>
                                                <div class="tk-right-sk-end skeltonbtn">
                                                    <div class="tk-line tk-skeletonten"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-paraskelton">
                                    <div class="tk-line tk-skeletonfour tk-wskeletonfull"></div>
                                    <div class="tk-line tk-skeletonfour tk-wskeletonfull"></div>
                                </div>
                                <div class="tk-righ-sk-tags">
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonfour"></div>
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonfour"></div>
                                    <div class="tk-line tk-skeletonsix"></div>
                                    <div class="tk-line tk-skeletonfour"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/search-projects.blade.php ENDPATH**/ ?>