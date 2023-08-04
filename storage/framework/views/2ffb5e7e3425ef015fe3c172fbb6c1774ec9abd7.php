<div class="row">
    <?php echo $__env->make('livewire.gig.gig-creation-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-lg-9">
        <div class="tk-project-wrapper tk-gigstep_4">
            <div class="tk-project-box">
            <div class="tk-sectiontitle">
                    <h4><?php echo e(__('gig.faq')); ?></h4>
                </div>
                <a class="tk-add-more" href="javascript:;" wire:click.prevent="addnewFaq">
                    <h6><?php echo e(__('gig.add_faq')); ?> </h6>
                    <i class="icon-plus"></i>
                </a>
                <?php if( !empty($gig_faqs) ): ?>
                    <?php $__currentLoopData = $gig_faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tk-attachments-hodler">
                            <div class="tk-attechment-wrapper">
                                <div class="tk-attechment-tittle">
                                    <h6 data-bs-toggle="collapse" data-bs-target="#faq-<?php echo e($key); ?>" aria-expanded="<?php echo e(($errors->has('gig_faqs.'.$key.'.question') || $errors->has('gig_faqs.'.$key.'.answer') ? 'true' : 'false')); ?>"><?php echo e($single['question']); ?></h6>
                                    <i class="icon-plus" role="button" data-bs-toggle="collapse" data-bs-target="#faq-<?php echo e($key); ?>" aria-expanded="<?php echo e(($errors->has('gig_faqs.'.$key.'.question') || $errors->has('gig_faqs.'.$key.'.answer') ? 'true' : 'false')); ?>"></i>
                                </div>
                                <div id="faq-<?php echo e($key); ?>" class="tk-collapse-sort-conetnt collapse <?php echo e(($errors->has('gig_faqs.'.$key.'.question') || $errors->has('gig_faqs.'.$key.'.answer') ? 'show' : '')); ?>">
                                    <form class="tk-themeform <?php if($errors->any()): ?> tk-form-error <?php endif; ?>">
                                        <fieldset>
                                            <div class="tk-themeform__wrap">
                                                <div class="form-group">
                                                    <label class="tk-label tk-required"><?php echo e(__('gig.faq_question')); ?></label>
                                                    <div class="tk-placeholderholder">
                                                        <input type="text" wire:model.defer="gig_faqs.<?php echo e($key); ?>.question"  class="form-control tk-themeinput <?php echo e(($errors->has('gig_faqs.'.$key.'.question') ? ' is-invalid' : '')); ?>" required>
                                                    </div>
                                                    <?php if($errors->has('gig_faqs.'.$key.'.question')): ?>
                                                        <div class="tk-errormsg">
                                                            <span> <?php echo e($errors->first('gig_faqs.'.$key.'.question')); ?></span>
                                                        </div> 
                                                    <?php endif; ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="tk-label tk-required"> <?php echo e(__('gig.faq_answer')); ?>  </label>
                                                    <div class="tk-placeholderholder">
                                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tinymce-input','data' => ['wire:model.defer' => 'gig_faqs.'.e($key).'.answer','placeholder' => ''.e(__('gig.faq_answer_placeholder')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tinymce-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'gig_faqs.'.e($key).'.answer','placeholder' => ''.e(__('gig.faq_answer_placeholder')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                    </div>
                                                    <?php if($errors->has('gig_faqs.'.$key.'.answer')): ?>
                                                        <div class="tk-errormsg">
                                                            <span> <?php echo e($errors->first('gig_faqs.'.$key.'.answer')); ?></span>
                                                        </div> 
                                                    <?php endif; ?>
                                                </div>
                                                <div class="form-group">
                                                    <a class="tk-Remove-adon" href="javascript:;" wire:click.prevent="removeFaq(<?php echo e($key); ?>)"><i class="icon-trash-2"></i><span><?php echo e(__('gig.remove_faq')); ?></span></a>
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
                <a href="javascript:;" wire:click.prevent="updateStep(3)" class="tk-btnline"><i class=" icon-chevron-left"></i><?php echo e(__('gig.go_back')); ?></a>
                    <a href="javascript:;" wire:click.prevent="update" class="tk-btn-solid-lg-lefticon">
                        <?php if(!empty($edit_id)): ?>
                            <?php echo e(__('gig.update_gig')); ?>

                        <?php else: ?>
                            <?php echo e(__('gig.create_gig')); ?>

                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-step4.blade.php ENDPATH**/ ?>