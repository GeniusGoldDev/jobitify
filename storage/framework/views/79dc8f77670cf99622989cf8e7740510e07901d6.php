<div class="tb-themeselect-wrapper">
    <?php if(!empty($categories_tree) && $categories_tree->count() > 0): ?>
        <div class="tb-themeselect">
            <label class="tb-titleinput <?php echo e($is_required ? 'tk-required':''); ?>"><?php echo e($label_text); ?></label>
            <div class="tb-select border-0 tk-selectv-two <?php $__errorArgs = ['project_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <span class="form-control tb-themeselect_value <?php if($has_error): ?> tk-invalid <?php endif; ?> <?php echo e($categoryId ? 'tk-selected' : ''); ?>"><?php echo e($category_name); ?></span>
            </div>
            <ul class="tb-categorytree-dropdown tb-themeselect_options">
                <?php $__currentLoopData = $categories_tree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginalda518bb76a290dfd69baf5d67883a049c0e103eb = $component; } ?>
<?php $component = App\View\Components\CategoryItem::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('category-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\CategoryItem::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['category' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($category)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalda518bb76a290dfd69baf5d67883a049c0e103eb)): ?>
<?php $component = $__componentOriginalda518bb76a290dfd69baf5d67883a049c0e103eb; ?>
<?php unset($__componentOriginalda518bb76a290dfd69baf5d67883a049c0e103eb); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/components/category-dropdown.blade.php ENDPATH**/ ?>