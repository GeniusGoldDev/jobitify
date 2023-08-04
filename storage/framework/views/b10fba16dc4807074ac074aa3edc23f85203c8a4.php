<div class="row">
    <?php echo $__env->make('livewire.project.project-creation-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-lg-9">
        <div class="tk-project-wrapper">
            <div class="tk-project-box">
                <div class="tk-maintitle">
                    <h4> <?php echo e(__('project.freelancer_skills_title')); ?> </h4>
                </div>
                <div class="tk-themeform__wrap">
                    <div class="form-group form-group-half">
                        <label class="tk-label tk-required"><?php echo e(__('project.no_of_freelancer')); ?></label>
                        <div class="<?php $__errorArgs = ['no_of_freelancer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <div class="tk-select" wire:ignore>
                                <select id="no_of_freelancer" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('project.no_of_freelancer_placeholder')); ?>" class="form-control">
                                    <option label="<?php echo e(__('project.no_of_freelancer_placeholder')); ?>"></option>
                                        <?php for($i= 1; $i <= $maximum_freelancer; $i++): ?>
                                            <option value="<?php echo e($i); ?>" <?php echo e($i == $no_of_freelancer ? 'selected' : ''); ?> ><?php echo e($i); ?></option>
                                        <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <?php $__errorArgs = ['no_of_freelancer'];
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
                        <label class="tk-label <?php if($req_expertlevel): ?> tk-required <?php endif; ?>"><?php echo e(__('project.expert_level')); ?></label>
                        <div class="<?php $__errorArgs = ['expertise_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <div class="tk-select" wire:ignore>
                                <select id="expertise_level" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('project.expert_level_placeholder')); ?>" class="form-control">
                                    <option label="<?php echo e(__('project.expert_level_placeholder')); ?>"></option>
                                    <?php if(!$expertise_levels->isEmpty()): ?>
                                        <?php $__currentLoopData = $expertise_levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($single->id); ?>" <?php echo e($single->id == $expertise_level ? 'selected' : ''); ?> ><?php echo e($single->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <?php $__errorArgs = ['expertise_level'];
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
                        <label class="tk-label <?php if($req_skills): ?> tk-required <?php endif; ?>"><?php echo e(__('project.skill_required')); ?></label>
                        <div class="<?php $__errorArgs = ['project_skills'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <div class="tk-select" wire:ignore>
                                <select id="project_skills" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('project.skill_required_placeholder')); ?>" class="form-control" multiple>
                                    <option label="<?php echo e(__('project.skill_required_placeholder')); ?>"></option>
                                    <?php if(!$skills->isEmpty()): ?>
                                        <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($single->id); ?>" <?php echo e(in_array($single->id, $project_skills) ? 'selected' : ''); ?> ><?php echo e($single->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <?php $__errorArgs = ['project_skills'];
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
                        <label class="tk-label <?php if($req_languages): ?> tk-required <?php endif; ?>"><?php echo e(__('project.select_languages')); ?></label>
                        <div class="<?php $__errorArgs = ['project_languages'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <div class="tk-select" wire:ignore>
                                <select id="project_languages"  data-placeholder="<?php echo e(__('project.select_languages_placeholder')); ?>" class="form-control" multiple>
                                    <option label="<?php echo e(__('project.select_languages_placeholder')); ?>"></option>
                                    <?php if(!$languages->isEmpty()): ?>
                                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($single->id); ?>" <?php echo e(in_array($single->id, $project_languages) ? 'selected' : ''); ?> ><?php echo e($single->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <?php $__errorArgs = ['project_languages'];
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
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:;" wire:click.prevent="updateStep(2)" class="tk-btnline"><i class=" icon-chevron-left"></i><?php echo e(__('project.go_back')); ?></a>
                    <div class="tk-projectbtns-holder">
                        <a href="javascript:;" wire:click.prevent="update('draft')" class="tk-edit-project">
                            <?php echo e(__('project.save_draft')); ?>

                        </a>
                        <a href="javascript:;" wire:click.prevent="update" class="tk-btn-solid-lg-lefticon">
                        <?php echo e(__('project.save_continue')); ?>

                            <i class="icon-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/project-step3.blade.php ENDPATH**/ ?>