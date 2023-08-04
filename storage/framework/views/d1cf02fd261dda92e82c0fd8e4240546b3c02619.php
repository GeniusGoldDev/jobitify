<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['menu']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['menu']); ?>
<?php foreach (array_filter((['menu']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<li class="dd-item" data-id="<?php echo e($menu->id); ?>">
    <div class="tb-menuaccordion_wrap">
        <div class="tb-menuaccordion_header" id="menu-accordion-<?php echo e($menu->id); ?>">
            <a href="javascript:void(0);" class="tb-slotchange dd-handle"><img src="<?php echo e(asset('images/sort-icon.svg')); ?>" ></a>
            <div class="tb-checkbox">
                <input id="item-<?php echo e($menu->id); ?>" value="<?php echo e($menu->id); ?>" type="checkbox">
                <label for="item-<?php echo e($menu->id); ?>"><?php echo e($menu->label); ?></label>
            </div>
            <span class="tb-accordionmenu" data-bs-toggle="collapse" data-bs-target="#accordionmenu-<?php echo e($menu->id); ?>" aria-expanded="false"><?php echo e($menu->type == 'page' ? __('pages.pages') : __('pages.custom')); ?> <i class="icon-chevron-right"></i> </span>
        </div>
        <div id="accordionmenu-<?php echo e($menu->id); ?>" class="collapse" aria-labelledby="menu-accordion-<?php echo e($menu->id); ?>" data-parent="#menu-items">
            <div class="tb-menuaccordion_content">
                <div class="form-group">
                    <label class="tb-titleinput"> <?php echo e(__('pages.add_label')); ?>  </label>
                    <input type="text" name="item-name[<?php echo e($menu->id); ?>]" value="<?php echo e($menu->label); ?>" class="form-control" placeholder="<?php echo e(__('pages.add_label')); ?>">
                </div>
                <div class=" form-group">
                    <label class="tb-titleinput"><?php echo e(__('pages.enter_url')); ?></label>
                    <input type="text" name="item-route[<?php echo e($menu->id); ?>]" value="<?php echo e($menu->route); ?>" class="form-control" placeholder="<?php echo e(__('pages.enter_url')); ?>">
                </div>
                <input type="hidden" name="item-type[<?php echo e($menu->id); ?>]" value="<?php echo e($menu->type); ?>" >
                <div class="form-group">
                    <a href="javascript:void(0);" class="tb-removemenu remove-item"><?php echo e(__('pages.delete_menu')); ?> <i class="icon-trash-2"></i></a>
                </div>
            </div>
        </div>
    </div>
    <?php if( !$menu->children->isEmpty() ): ?> 
        <ol class="tb-menuaccordion_child dd-list">
            <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.menu-item','data' => ['menu' => $child]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menu' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($child)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    <?php endif; ?>
</li>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/admin/menu-item.blade.php ENDPATH**/ ?>