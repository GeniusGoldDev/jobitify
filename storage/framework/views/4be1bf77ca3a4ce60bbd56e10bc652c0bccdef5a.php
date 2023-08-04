<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <?php 
            $rtl                = setting('_site.rtl');
            $rtl_class          = !empty($rtl) && $rtl == 1 ? 'tk-rtl' : '';
        ?>
        <?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['title']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['title']); ?>
<?php foreach (array_filter((['title']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title> <?php echo e($title); ?> | <?php echo e($siteTitle); ?> </title>
        <?php if( !empty($siteFavicon) ): ?>
            <link rel="icon" href="<?php echo e(asset('storage/'.$siteFavicon)); ?>" type="image/x-icon">
        <?php endif; ?>
        <?php echo app('Illuminate\Foundation\Vite')([
            'public/common/css/bootstrap.min.css',
            'public/css/fontawesome/all.min.css',
        ]); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
        <?php if( !empty($rtl_class) ): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/rtl.css')); ?>">
        <?php endif; ?>
       
    </head>
    <body class="<?php echo e($rtl_class); ?>">
        <?php echo e($slot); ?>

        <script src="<?php echo e(asset('common/js/jquery.min.js')); ?>"></script>
		<script defer src="<?php echo e(asset('common/js/bootstrap.min.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/layouts/guest.blade.php ENDPATH**/ ?>