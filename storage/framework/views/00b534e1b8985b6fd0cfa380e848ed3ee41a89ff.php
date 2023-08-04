<div class="row" wire:key="<?php echo e(time()); ?>">
    <?php echo $__env->make('livewire.gig.gig-creation-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-lg-9">
        <div class="tk-project-wrapper tk-gigstep_2">
            <div class="tk-project-box tk-project-boxvtwo">
                <div class="tk-maintitle pb-0">
                    <h4><?php echo e(__('gig.pricing_desc')); ?></h4>
                </div>
                <div class="tk-attachments-hodler" id="gig-plans">
                    <?php $__currentLoopData = $gig_plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tk-attechment-wrapper">
                            <div class="tk-attechment-tittle">
                                <h6 data-bs-toggle="collapse" data-bs-target="#price-plan-<?php echo e($key); ?>" aria-expanded="<?php echo e(($errors->has('gig_plans.'.$key.'.plan_title') || $errors->has('gig_plans.'.$key.'.plan_price') || $errors->has('gig_plans.'.$key.'.plan_delivery_time') || $errors->has('gig_plans.'.$key.'.plan_description')  ? 'true' : 'false')); ?>"><?php echo e(empty($single['plan_title']) ? __('gig.plan_title') : $single['plan_title']); ?></h6>
                                <div class="tk-accord-rightside">
                                    <div class="tk-switchbtn">
                                        <label for="is-featured-<?php echo e($key); ?>" class="tk-textdes"><span id="tk-textdes"><?php echo e(__('gig.featured')); ?></span></label>
                                        <input class="tk-checkaction" wire:model.defer="gig_plans.<?php echo e($key); ?>.is_featured" type="checkbox" id="is-featured-<?php echo e($key); ?>" <?php echo e($single['is_featured'] ? 'checked' : ''); ?>>
                                    </div>
                                    <i class="icon-chevron-right" role="button" data-bs-toggle="collapse" data-bs-target="#price-plan-<?php echo e($key); ?>" aria-expanded="<?php echo e(($errors->has('gig_plans.'.$key.'.plan_title') || $errors->has('gig_plans.'.$key.'.plan_price') || $errors->has('gig_plans.'.$key.'.plan_delivery_time') || $errors->has('gig_plans.'.$key.'.plan_description')  ? 'true' : 'false')); ?>"></i>
                                </div>
                            </div>
                            <div id="price-plan-<?php echo e($key); ?>" class="tk-collapse-sort-conetnt collapse <?php echo e(($errors->has('gig_plans.'.$key.'.plan_title') || $errors->has('gig_plans.'.$key.'.plan_price') || $errors->has('gig_plans.'.$key.'.plan_delivery_time') || $errors->has('gig_plans.'.$key.'.plan_description')  ? 'show' : '')); ?>" data-bs-parent="#gig-plans">
                                <form class="tk-themeform">
                                    <fieldset>
                                        <div class="tk-themeform__wrap">
                                            <div class="form-group form-group-3half">
                                                <label class="tk-label tk-required"><?php echo e(__('gig.package_title')); ?></label>
                                                <div class="tk-placeholderholder">
                                                    <input type="text" wire:model.defer="gig_plans.<?php echo e($key); ?>.plan_title" placeholder="<?php echo e(__('gig.plan_title')); ?>"  class="form-control tk-themeinput <?php echo e(($errors->has('gig_plans.'.$key.'.plan_title') ? ' is-invalid' : '')); ?>" required>
                                                </div>
                                                <?php if($errors->has('gig_plans.'.$key.'.plan_title')): ?>
                                                    <div class="tk-errormsg">
                                                        <span> <?php echo e($errors->first('gig_plans.'.$key.'.plan_title')); ?></span>
                                                    </div> 
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group form-group-3half">
                                                <label class="tk-label tk-required"><?php echo e(__('gig.plan_price')); ?></label>
                                                <div class="tk-placeholderholder">
                                                    <input type="number" wire:model.defer="gig_plans.<?php echo e($key); ?>.plan_price" placeholder="<?php echo e(__('gig.plan_price')); ?>" required class="form-control tk-themeinput <?php echo e(($errors->has('gig_plans.'.$key.'.plan_price') ? ' is-invalid' : '')); ?>">
                                                </div>
                                                <?php if($errors->has('gig_plans.'.$key.'.plan_price')): ?>
                                                    <div class="tk-errormsg">
                                                        <span> <?php echo e($errors->first('gig_plans.'.$key.'.plan_price')); ?></span>
                                                    </div> 
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group form-group-3half">
                                                <label class="tk-label tk-required"><?php echo e(__('gig.delivery_time')); ?></label>
                                                <div class="<?php echo e($errors->has('gig_plans.'.$key.'.plan_delivery_time') ? 'tk-invalid' : ''); ?>">
                                                    <div class="tk-select tk-project-select" wire:ignore> 
                                                        <select id="gig_plans.<?php echo e($key); ?>.plan_delivery_time" data-placeholderinput="<?php echo e(__('gig.delivery_time_placeholder')); ?>" data-placeholder="<?php echo e(__('gig.delivery_time_placeholder')); ?>" class="form-control delivery-time" required>
                                                            <option label="<?php echo e(__('general.search')); ?>"></option>
                                                            <?php if(!$delivery_time->isEmpty()): ?>
                                                                <?php $__currentLoopData = $delivery_time; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($time->days); ?>" <?php echo e($time->days == $single['plan_delivery_time'] ? 'selected' : ''); ?>  ><?php echo $time->name; ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php if($errors->has('gig_plans.'.$key.'.plan_delivery_time')): ?>
                                                    <div class="tk-errormsg">
                                                        <span> <?php echo e($errors->first('gig_plans.'.$key.'.plan_delivery_time')); ?></span>
                                                    </div> 
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="tk-label tk-required"><?php echo e(__('gig.plan_description')); ?></label>
                                                <div class="tk-placeholderholder">
                                                    <textarea class="form-control tk-themeinput <?php echo e($errors->has('gig_plans.'.$key.'.plan_description') ? ' is-invalid' : ''); ?>" require wire:model.defer="gig_plans.<?php echo e($key); ?>.plan_description" placeholder="<?php echo e(__('gig.add_details')); ?>"></textarea>
                                                </div>
                                                <?php if($errors->has('gig_plans.'.$key.'.plan_description')): ?>
                                                    <div class="tk-errormsg">
                                                        <span> <?php echo e($errors->first('gig_plans.'.$key.'.plan_description')); ?></span>
                                                    </div> 
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="tk-project-box tk-project-boxvtwo">
                <div class="tk-maintitle pb-0">
                    <h4> <?php echo e(__('gig.add_gig_addon')); ?></h4>
                </div>
                <a class="tk-add-more" href="javascript:;" wire:click.prevent="addNewAddon">
                    <h6><?php echo e(__('gig.add_new')); ?> </h6>
                    <i class="icon-plus"></i>
                </a>
                <?php if( !empty($gig_addons) ): ?>
                    <?php $__currentLoopData = $gig_addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tk-attachments-hodler" id="gigs-addon">
                            <div class="tk-attechment-wrapper">
                                <div class="tk-attechment-tittle">
                                    <div class="tk-form-checkbox">
                                        <input class="form-check-input tk-form-check-input-sm" <?php echo e(in_array( $key, $selected_addons ) ? 'checked' : ''); ?> type="checkbox" value="<?php echo e($key); ?>"  wire:model.defer="selected_addons"  >
                                        <h6 data-bs-toggle="collapse" data-bs-target="#gig-addon-<?php echo e($key); ?>" aria-expanded="<?php echo e(($errors->has('gig_addons.'.$key.'.title') || $errors->has('gig_addons.'.$key.'.price')  ? 'true' : 'false')); ?>"><?php echo e($single['title']); ?></h6>
                                    </div>
                                    <div class="tk-accord-rightside">
                                        <div class="tk-switchbtn">
                                            <span><?php echo e(!empty($single['price']) ? getPriceFormat($currency_symbol, $single['price'] ) : ''); ?></span>
                                        </div>
                                        <i class="icon-chevron-right" role="button" data-bs-toggle="collapse" data-bs-target="#gig-addon-<?php echo e($key); ?>" aria-expanded="<?php echo e(($errors->has('gig_addons.'.$key.'.title') || $errors->has('gig_addons.'.$key.'.price')  ? 'true' : 'false')); ?>"></i>
                                    </div>
                                </div>
                                <div id="gig-addon-<?php echo e($key); ?>" class="tk-collapse-sort-conetnt collapse <?php echo e(($errors->has('gig_addons.'.$key.'.title') || $errors->has('gig_addons.'.$key.'.price')  ? 'show' : '')); ?>" data-bs-parent="#gigs-addon">
                                    <form class="tk-themeform">
                                        <fieldset>
                                            <div class="tk-themeform__wrap">
                                                <div class="form-group form-group-half">
                                                    <label class="tk-label tk-required"><?php echo e(__('gig.addon_title')); ?></label>
                                                    <div class="tk-placeholderholder">
                                                        <input type="text" wire:model.defer="gig_addons.<?php echo e($key); ?>.title" placeholder="<?php echo e(__('gig.addon_title')); ?>"  class="form-control tk-themeinput <?php echo e($errors->has('gig_addons.'.$key.'.title') ? ' is-invalid' : ''); ?>" required>
                                                    </div>
                                                    <?php if($errors->has('gig_addons.'.$key.'.title')): ?>
                                                        <div class="tk-errormsg">
                                                            <span> <?php echo e($errors->first('gig_addons.'.$key.'.title')); ?></span>
                                                        </div> 
                                                    <?php endif; ?>
                                                </div>
                                                <div class="form-group form-group-half">
                                                    <label class="tk-label tk-required"><?php echo e(__('gig.addon_price')); ?></label>
                                                    <div class="tk-placeholderholder">
                                                        <input type="number" wire:model.defer="gig_addons.<?php echo e($key); ?>.price" placeholder="<?php echo e(__('gig.addon_price')); ?>"  class="form-control tk-themeinput <?php echo e($errors->has('gig_addons.'.$key.'.price') ? ' is-invalid' : ''); ?>" required>
                                                    </div>
                                                    <?php if($errors->has('gig_addons.'.$key.'.price')): ?>
                                                        <div class="tk-errormsg">
                                                            <span> <?php echo e($errors->first('gig_addons.'.$key.'.price')); ?></span>
                                                        </div> 
                                                    <?php endif; ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="tk-label"><?php echo e(__('gig.addon_desc')); ?></label>
                                                    <div class="tk-placeholderholder">
                                                        <textarea wire:model.defer="gig_addons.<?php echo e($key); ?>.description" placeholder="<?php echo e(__('gig.addon_desc')); ?>" class="form-control tk-themeinput"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <a class="tk-Remove-adon" href="javascript:;" wire:click.prevent="removeAddon(<?php echo e($key); ?>)"><i class="icon-trash-2"></i><span><?php echo e(__('gig.remove_addon')); ?></span></a>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:;" wire:click.prevent="updateStep(1)" class="tk-btnline"><i class=" icon-chevron-left"></i><?php echo e(__('gig.go_back')); ?></a>
                    <a href="javascript:;" wire:click.prevent="updateStep( <?php echo e($step + 1); ?> )"  class="tk-btn-solid-lg-lefticon">
                         <?php echo e(__('gig.continue')); ?>

                        <i class="icon-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-step2.blade.php ENDPATH**/ ?>