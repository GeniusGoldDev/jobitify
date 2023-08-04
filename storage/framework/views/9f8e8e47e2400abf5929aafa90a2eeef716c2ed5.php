<div id="qualification" wire:init="loadEducations"  class="tk-profilebox">
    <div class="tk-content-box">
        <h4><?php echo e(__('general.qualification')); ?></h4>
    </div>
    <?php if( $page_loaded ): ?>
        <?php if( !$educations->IsEmpty() ): ?>
            <div class="tk-acordian-wrapper">
                <ul id="tk-accordion" class="tk-qualification tk-qualificationvtwo">
                    <?php $__currentLoopData = $educations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $education): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.education-item','data' => ['education' => $education,'index' => $key]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('education-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['education' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($education),'index' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($key)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="tk-noskills">
                <span><?php echo e(__('general.no_content_added')); ?></span>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="tk-skeleton">
            <ul class="tk-frame">
                <?php for($i =1; $i<=3; $i++): ?>
                    <li>
                        <div class="tk-frame-items">
                            <span class="tk-skeleton-title tk-skele"></span>
                            <div class="tk-frame-list">
                                <div class="tk-skeleton-user">
                                    <span class="tk-user-icon tk-skele"></span>
                                    <span class="tk-reviews tk-skele"></span>
                                </div>
                                <div class="tk-skeleton-user">
                                    <span class="tk-user-icon tk-skele"></span>
                                    <span class="tk-reviews tk-skele"></span>
                                </div>
                                <div class="tk-skeleton-user">
                                    <span class="tk-user-icon tk-skele"></span>
                                    <span class="tk-reviews tk-skele"></span>
                                </div>
                            </div>
                            <span class="tk-skele"></span>
                            <span class="tk-frame-para tk-skele"></span>
                        </div>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/seller/seller-education.blade.php ENDPATH**/ ?>