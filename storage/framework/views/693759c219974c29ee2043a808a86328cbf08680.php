<div class="row" wire:key="<?php echo e(time()); ?>">
    <?php echo $__env->make('livewire.gig.gig-creation-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-lg-9">
        <div class="tk-project-wrapper tk-gigstep_1">
            <div class="tk-project-box">
                <div class="tk-maintitle">
                    <h4> <?php echo e(__('gig.about_gig_info')); ?> </h4>
                </div>
                <form class="tk-themeform <?php if($errors->any()): ?> tk-form-error <?php endif; ?>">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                            <div class="form-group">
                                <label class="tk-label tk-required"><?php echo e(__('gig.add_gig_title')); ?></label>
                                <div class="tk-placeholderholder">
                                    <input type="text" wire:model.defer="title" placeholder="<?php echo e(__('gig.gig_title_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required">
                                </div>
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="tk-errormsg">
                                        <span><?php echo e($message); ?></span> 
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <?php
                                $style_class = '';
                                if(!empty($gig_types) && $gig_types->count() > 0){
                                    $style_class = 'form-group-3half'; 
                                }elseif(!empty($sub_categories) && $sub_categories->count() > 0){
                                    $style_class = 'form-group-half';
                                }
                            ?>
                            <div class="from-group-wrapper">
                                <div class="form-group <?php echo e($style_class); ?>">
                                    <label class="tk-label tk-required"><?php echo e(__('gig.category')); ?> </label>
                                    <div class="<?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <div class="tk-select" wire:ignore>
                                            <select id="category" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('gig.category_placeholder')); ?>"  class="form-control <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <option label="<?php echo e(__('gig.category_placeholder')); ?>"></option>
                                                <?php if(!$categories->isEmpty() ): ?>
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($single->id); ?>" <?php echo e($single->id == $category ? 'selected' : ''); ?> ><?php echo $single->name; ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="tk-errormsg">
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <?php if(!empty($sub_categories) && $sub_categories->count() > 0): ?>
                                    <div class="form-group <?php echo e($style_class); ?>">
                                        <label class="tk-label tk-required"><?php echo e(__('gig.sub_category')); ?> </label>
                                        <div class="<?php $__errorArgs = ['sub_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <div class="tk-select" wire:ignore>
                                                <select id="sub_category" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('gig.sub_category_placeholder')); ?>"  class="form-control <?php $__errorArgs = ['sub_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option label="<?php echo e(__('gig.sub_category_placeholder')); ?>"></option>
                                                    <?php if(!$sub_categories->isEmpty()): ?>
                                                        <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($single->id); ?>" <?php echo e($single->id == $sub_category ? 'selected' : ''); ?> ><?php echo $single->name; ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php $__errorArgs = ['sub_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="tk-errormsg">
                                                <span><?php echo e($message); ?></span>
                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($gig_types) && $gig_types->count() > 0): ?>
                                    <div class="form-group form-group-3half">
                                        <label class="tk-label tk-required"><?php echo e(__('gig.gig_type')); ?> </label>
                                        <div class="tk-select" wire:ignore>
                                            <select id="selected_gig_types" multiple data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('gig.gig_type_placeholder')); ?>"  class="form-control">
                                                <option label="<?php echo e(__('gig.gig_type_placeholder')); ?>"></option>
                                                <?php if( !$gig_types->isEmpty() ): ?>
                                                    <?php $__currentLoopData = $gig_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($single->id); ?>" <?php echo e(in_array($single->id, $selected_gig_types) ? 'selected' : ''); ?> ><?php echo $single->name; ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group form-group-half">
                                <label class="tk-label tk-required"><?php echo e(__('gig.country')); ?> </label>
                                <div class="<?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <div class="tk-select" wire:ignore>
                                        <select id="country" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('gig.country_placeholder')); ?>"  class="form-control <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option label="<?php echo e(__('gig.country_placeholder')); ?>"></option>
                                            <?php if(!$countries->isEmpty()): ?>
                                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($single->name); ?>" <?php echo e($single->name == $country ? 'selected' : ''); ?> ><?php echo e($single->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="tk-errormsg">
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group form-group-half">
                                <label class="tk-label tk-required"><?php echo e(__('gig.zipcode')); ?> </label>
                                <div class="tk-placeholderholder">
                                    <input type="text" wire:model.defer="zipcode" placeholder="<?php echo e(__('gig.zipcode_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['zipcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required">
                                </div>
                                <?php $__errorArgs = ['zipcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="tk-errormsg">
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div wire:ignore class="form-group">
                                <label class="tk-label tk-required" for="gig_description"> <?php echo e(__('gig.gig_intro')); ?>  </label>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tinymce-input','data' => ['wire:model.defer' => 'description']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tinymce-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="tk-errormsg">
                                        <span><?php echo e($message); ?></span> 
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:;" wire:click.prevent="updateStep( <?php echo e($step + 1); ?> )" id="continue_btn" class="tk-btn-solid-lg-lefticon">
                         <?php echo e(__('gig.continue')); ?>

                        <i class="icon-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-step1.blade.php ENDPATH**/ ?>