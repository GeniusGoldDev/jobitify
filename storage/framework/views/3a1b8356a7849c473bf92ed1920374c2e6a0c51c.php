<div class="row">
    <?php echo $__env->make('livewire.project.project-creation-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-lg-9">
        <div class="tk-project-wrapper">
            <div class="tk-project-box">
                <div class="tk-maintitle">
                    <h4> <?php echo e(__('project.about_project_info')); ?> </h4>
                </div>
                <form class="tk-themeform">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                            <div class="form-group">
                                <label class="tk-label tk-required"><?php echo e(__('project.add_project_title')); ?></label>
                                <div class="tk-placeholderholder">
                                    <input type="text" wire:model.defer="title" placeholder="<?php echo e(__('project.project_title_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['title'];
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
                            <div class="form-group">
                                <label class="tk-label tk-required"><?php echo e(__('project.select_project_project')); ?></label>
                                <ul class="nav nav-tabs tk-radio-tabs">
                                    <li class=" <?php echo e($type == 'fixed' ? 'tk-active-option' : ''); ?>  tk-li-fixed">
                                        <input <?php echo e($type == 'fixed' ? 'checked' : ''); ?> type="radio" id="fixed" wire:model="type" value="fixed">
                                        <label class="tk-project-type" for="fixed"> <i class="icon-bookmark tk-red-icon"></i>
                                            <div>
                                                <h6><?php echo e(__('project.fixed_type')); ?></h6>
                                                <p> <?php echo e(__('project.fixed_type_desc')); ?></p>
                                            </div>
                                        </label>
                                    </li>
                                    <li class="<?php echo e($type == 'hourly' ? 'tk-active-option' : ''); ?> tk-li-hourly">
                                        <input <?php echo e($type == 'hourly' ? 'checked' : ''); ?> type="radio" id="hourly" wire:model="type" value="hourly">
                                        <label class="tk-project-type" for="hourly"> <i class="icon-clock tk-purple-icon"></i>
                                            <div>
                                                <h6><?php echo e(__('project.hourly_type')); ?> </h6>
                                                <p> <?php echo e(__('project.hourly_type_desc')); ?></p>
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                           <!-- hourly type -->
                            <div class="form-group form-group-half <?php echo e($type == 'fixed' ? 'd-none' : ''); ?>">
                                <label class="tk-label"> <?php echo e(__('project.payment_mode')); ?></label>
                                <div class="<?php $__errorArgs = ['payment_mode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <div class="tk-select" wire:ignore>
                                        <select id="payment_mode" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('project.payment_mode_placeholder')); ?>" class="form-control <?php $__errorArgs = ['payment_mode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option label="<?php echo e(__('project.payment_mode_placeholder')); ?>"></option>
                                            <?php if(!empty($payment_modes)): ?>
                                                <?php $__currentLoopData = $payment_modes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php echo e($key == $payment_mode ? 'selected' : ''); ?> ><?php echo $name; ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['payment_mode'];
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
                            <div class="form-group form-group-half <?php echo e($type == 'fixed' ? 'd-none' : ''); ?>">
                                <label class="tk-label tk-required"><?php echo e(__('project.add_mx_hours')); ?></label>
                                <div class="tk-placeholderholder">
                                    <input type="number" placeholder="<?php echo e(__('project.add_mx_placeholder')); ?>" wire:model.defer="max_hours"  class="form-control tk-themeinput <?php $__errorArgs = ['max_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required">
                                </div>
                                <?php $__errorArgs = ['max_hours'];
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
                            <div class="form-group form-group-half <?php echo e($type == 'fixed' ? 'd-none' : ''); ?>">
                                <label class="tk-label tk-required"> <?php echo e(__('project.add_min_hourly_rate')); ?> </label>
                                <div class="tk-placeholderholder">
                                    <input type="number" wire:model.defer="min_price" placeholder="<?php echo e(__('project.min_hourly_rate_placeholer')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['min_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required">
                                </div>
                                <?php $__errorArgs = ['min_price'];
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
                            <div class="form-group form-group-half <?php echo e($type == 'fixed' ? 'd-none' : ''); ?>">
                                <label class="tk-label tk-required"><?php echo e(__('project.add_max_hourly_rate')); ?> </label>
                                <div class="tk-placeholderholder">
                                    <input type="number" placeholder="<?php echo e(__('project.max_hourly_rate_placeholer')); ?>" wire:model.defer="max_price"  class="form-control tk-themeinput <?php $__errorArgs = ['max_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required">
                                </div>
                                <?php $__errorArgs = ['max_price'];
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
                                <!-- fixed type -->
                            <div class=" form-group tb-fixed-type <?php echo e($type == 'hourly' ? 'd-none' : ''); ?>">
                                <div class="tk-betaversion-wrap tk-milestone-wrapper">
                                    <figure>
                                        <img src="<?php echo e(asset('images/proposal/milestone.png')); ?>" alt="<?php echo e(__('project.milestone')); ?>">
                                    </figure>
                                    <div class="tk-betaversion-info">
                                        <h5> <?php echo e(__('project.milesote_heading_txt')); ?></h5>
                                        <p> <?php echo __('project.milesote_heading_desc',['safety_policy_url' => 'javascript:void(0)' ]); ?></p>
                                    </div>
                                    <div class="tk-payment-methods">
                                        <ul class="tk-priorityradiov2">
                                            <?php $__currentLoopData = $payout_type_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="tk-form-checkbox">
                                                    <input class="form-check-input tk-form-check-input-sm tk-payout-opt" wire:model.defer="project_payout_type" type="radio" id="radio-<?php echo e($key); ?>" <?php echo e($project_payout_type == 'key' ? 'checked' : ''); ?> value="<?php echo e($key); ?>" />
                                                    <label class="form-check-label" for="radio-<?php echo e($key); ?>" class="tb-radiolist">
                                                        <span><?php echo e($record); ?> </span>
                                                    </label>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <?php $__errorArgs = ['project_payout_type'];
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
                            </div>
                            <div class="form-group form-group-half <?php echo e($type == 'hourly' ? 'd-none' : ''); ?>">
                                <label class="tk-label tk-required"> <?php echo e(__('project.add_min_fixed_budget')); ?>  </label>
                                <div class="tk-placeholderholder">
                                    <input type="number" wire:model.defer="min_price" placeholder="<?php echo e(__('project.min_fixed_budget_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['min_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" >
                                </div>
                                <?php $__errorArgs = ['min_price'];
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
                            <div class="form-group form-group-half <?php echo e($type == 'hourly' ? 'd-none' : ''); ?>">
                                <label class="tk-label tk-required"><?php echo e(__('project.add_max_fixed_budget')); ?> </label>
                                <div class="tk-placeholderholder">
                                    <input type="number" wire:model.defer="max_price"  class="form-control tk-themeinput <?php $__errorArgs = ['max_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required" placeholder="<?php echo e(__('project.max_fixed_budget_placeholder')); ?>" >
                                </div>
                                <?php $__errorArgs = ['max_price'];
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
                                <label class="tk-label <?php if($req_duration): ?> tk-required <?php endif; ?>"><?php echo e(__('project.project_duration')); ?> </label>
                                <div class="<?php $__errorArgs = ['project_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <div class="tk-select" wire:ignore>
                                        <select id="project_duration" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('project.project_duration_placeholder')); ?>"  class="form-control <?php $__errorArgs = ['project_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option label="<?php echo e(__('project.project_duration_placeholder')); ?>"></option>
                                            <?php if(!$durations->isEmpty()): ?>
                                                <?php $__currentLoopData = $durations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($single->id); ?>" <?php echo e($single->id == $project_duration ? 'selected' : ''); ?> ><?php echo $single->name; ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['project_duration'];
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
                                <div>
                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.category-dropdown',
                                    [ 
                                        'categroy_id'=> $project_category, 
                                        'label_text' => __('project.project_category'), 
                                        'is_required' => $req_category,
                                    ])->html();
} elseif ($_instance->childHasBeenRendered('aZKpQ7D')) {
    $componentId = $_instance->getRenderedChildComponentId('aZKpQ7D');
    $componentTag = $_instance->getRenderedChildComponentTagName('aZKpQ7D');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('aZKpQ7D');
} else {
    $response = \Livewire\Livewire::mount('components.category-dropdown',
                                    [ 
                                        'categroy_id'=> $project_category, 
                                        'label_text' => __('project.project_category'), 
                                        'is_required' => $req_category,
                                    ]);
    $html = $response->html();
    $_instance->logRenderedChild('aZKpQ7D', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                </div>
                                <?php $__errorArgs = ['project_category'];
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
                                <label class="tk-label tk-required"><?php echo e(__('general.add_location')); ?></label>
                                <div class="<?php $__errorArgs = ['project_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <div class="tk-select" wire:ignore>
                                        <select id="project_location" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('general.location_placeholder')); ?>" class="form-control">
                                            <option label="<?php echo e(__('general.location_placeholder')); ?>"></option>
                                            <?php if(!$locations->isEmpty()): ?>
                                                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($single->id); ?>" <?php echo e($single->id == $project_location ? 'selected' : ''); ?> ><?php echo $single->name; ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['project_location'];
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
                            <div class="form-group form-group-half <?php echo e($project_location != 3 ? 'd-none' : ''); ?>">
                                <label class="tk-label"><?php echo e(__('project.country')); ?> </label>
                                <div class="<?php $__errorArgs = ['project_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <div class="tk-select" wire:ignore>
                                        <select id="project_country" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('project.country_placeholder')); ?>"  class="form-control <?php $__errorArgs = ['project_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option label="<?php echo e(__('project.country_placeholder')); ?>"></option>
                                            <?php if(!$countries->isEmpty()): ?>
                                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($single->name); ?>" <?php echo e($single->name == $project_country ? 'selected' : ''); ?> ><?php echo e($single->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['project_country'];
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
                            <?php if( $enable_zipcode == '1' ): ?>
                                <div class="form-group form-group-half <?php echo e($project_location != 3 ? 'd-none' : ''); ?>">
                                    <label class="tk-label tk-required"><?php echo e(__('project.zipcode')); ?> </label>
                                    <div class="tk-placeholderholder">
                                        <input type="text" wire:model.defer="zipcode" placeholder="<?php echo e(__('project.zipcode_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['zipcode'];
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
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="tk-label <?php if($req_project_desc): ?> tk-required <?php endif; ?>"> <?php echo e(__('project.pro_desc')); ?>  </label>
                                <div class="tk-placeholderholder">
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tinymce-input','data' => ['wire:model.defer' => 'description','placeholder' => ''.e(__('project.pro_desc_placeholder')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tinymce-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'description','placeholder' => ''.e(__('project.pro_desc_placeholder')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
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
                <div class="tk-attachments-hodler" id="attechmentacordian">
                    <div class="tk-attechment-wrapper">
                        <div class="tk-attechment-tittle">
                            <h6 wire:ignore.self data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="<?php echo e(!empty($video_url) || !empty($existingFiles) ? 'true' : 'false'); ?>" <?php echo e(empty($video_url) && empty($existingFiles) ? 'class=collapsed' : ''); ?> aria-controls="flush-collapseTwo"><?php echo e(__('project.media_attachment_title')); ?></h6>
                            <i class="icon-plus <?php echo e(empty($video_url) && empty($existingFiles) ? 'collapsed' : ''); ?>" role="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="<?php echo e(!empty($video_url) || !empty($existingFiles) ? 'true' : 'false'); ?>" aria-controls="flush-collapseTwo"></i>
                        </div>
                        <div wire:ignore.self id="flush-collapseTwo" class="collapse <?php echo e(empty($video_url) && empty($existingFiles) ? '' : 'show'); ?>" data-bs-parent="#attechmentacordian">
                            <div class="tk-attechment-content">
                                <div class="form-group">
                                    <label class="tk-label"> <?php echo e(__('project.add_video_link')); ?></label>
                                    <div class="tk-placeholderholder">
                                        <input type="url" wire:model.defer="video_url" placeholder="<?php echo e(__('project.video_link_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    </div>
                                    <?php $__errorArgs = ['video_url'];
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
                              
                                <div x-data="{ dropFile: false }" class="tk-draganddropwrap tk-freelanerinfo form-group">
                                    <div class="tk-draganddrop"
                                    x-bind:class="dropFile ? 'tk-opacity' : ''"
                                    x-on:drop="dropFile = false"
                                    wire:drop.prevent="$emit('file-dropped', $event)"
                                    x-on:dragover.prevent="dropFile = true"
                                    x-on:dragleave.prevent="dropFile = false">
                                        
                                        <svg><rect width="100%" height="100%"></rect></svg>
                                        <input class="tk-drag-imagearea" type="file" id="at_upload_files" accept="<?php echo e(!empty($allowFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowFileExt))  : '*'); ?>" multiple wire:change="$emit('file-dropped', {'dataTransfer' : { files :  $event.target.files}})" />
                                        <div class="tk-dragfile">
                                            <div class="tk-fileareaitem">
                                                <img src="<?php echo e(asset('images/image-uploader.jpg')); ?>" alt="">
                                            </div>
                                            <div class="tk-filearea">
                                                <div class="text-center" wire:loading wire:target="files" ><span class="fw-normal"><?php echo e(__('general.uploading')); ?></span></div>
                                                <div class="tk-text-flex" wire:loading.remove  wire:target="files" ><span><?php echo e(__('general.uploading_desc')); ?></span>
                                                <label class="tk-drag-label" for="at_upload_files"> <em><?php echo e(__('general.click_here')); ?></em></label>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['files.*'];
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
                                <?php if($existingFiles): ?>
                                    <ul class="tk-uploadlist">
                                        <?php $__currentLoopData = $existingFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <div class="tk-uploaditem">
                                                        <div class="tk-uploaddetail">
                                                            <?php if(method_exists($single,'getMimeType')): ?>
                                                                <img src="<?php echo e(substr($single->getMimeType(), 0, 5) == 'image' ? $single->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($single->getClientOriginalName()); ?>">
                                                            <?php else: ?>
                                                                <img src="<?php echo e(substr($single->mime_type, 0, 5) == 'image' ? asset('storage/'.$single->file_path) : asset('images/file-preview.png')); ?>" alt="<?php echo e($single->file_name); ?>">
                                                            <?php endif; ?>
                                                            <span><?php echo e(method_exists($single,'getClientOriginalName') ? $single->getClientOriginalName() : $single->file_name); ?></span>
                                                        </div>
                                                        <a href="javascript:;" wire:click.prevent="removeFile('<?php echo e($key); ?>')"><i class="icon-trash-2"></i></a>
                                                    </div>
                                                </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:;" wire:click.prevent="updateStep( <?php echo e($step + 1); ?> )" id="continue_btn" class="tk-btn-solid-lg-lefticon">
                         <?php echo e(__('project.continue')); ?>

                        <i class="icon-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/project-step2.blade.php ENDPATH**/ ?>