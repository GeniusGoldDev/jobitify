<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['description', 'sitelogo', 'auth_bg']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['description', 'sitelogo', 'auth_bg']); ?>
<?php foreach (array_filter((['description', 'sitelogo', 'auth_bg']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="tk-loginconatiner tk-loginconatiner-two" <?php if( !empty($auth_bg) ): ?> style="background-image: url('<?php echo e(asset('storage/'.$auth_bg)); ?>')" <?php endif; ?>>
    <div class="tk-popupcontainer w-100">
        <div class="tk-login-content">
            <div class="tk-login-info">
                <?php if( !empty($sitelogo) ): ?>
                    <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('storage/'.$sitelogo)); ?>" alt="<?php echo e(__('general.logo')); ?>" /></a>
                <?php else: ?>
                    <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('demo-content/logo.png')); ?>" alt="<?php echo e(__('general.logo')); ?>" /></a>
                <?php endif; ?>
                <?php if( !empty($description) ): ?><h5><?php echo e($description); ?></h5><?php endif; ?>
            </div>
            <?php echo e($slot); ?>

        </div>
    </div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/auth-card.blade.php ENDPATH**/ ?>