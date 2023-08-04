<!doctype html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="zxx">
<!--<![endif]-->

    <head>
        <?php  
            $sitInfo = getSiteInfo();
            $siteTitle = $sitInfo['site_name'];
            $siteFavicon = $sitInfo['site_favicon'];
        ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title> <?php echo e($siteTitle); ?> | <?php echo e(__('general.adminpanel_title')); ?></title>
        <?php if( !empty($siteFavicon) ): ?>
            <link rel="icon" href="<?php echo e(asset('storage/'.$siteFavicon)); ?>"  type="image/x-icon">
        <?php endif; ?>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo e(asset('common/css/bootstrap.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('admin/css/fontawesome/all.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('common/css/jquery.mCustomScrollbar.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('common/css/select2.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('common/css/jquery-confirm.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/feather-icons.css')); ?>">
        <?php echo $__env->yieldPushContent('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('pagebuilder/css/main.css')); ?>">
        <?php echo \Livewire\Livewire::styles(); ?>

    </head>
    <body class="tb-bodycolor">
        <?php echo $__env->yieldContent('content'); ?> 
        <script src="<?php echo e(asset('common/js/jquery.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('common/js/bootstrap.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('pagebuilder/js/splide.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?> "></script>
        <script defer src="<?php echo e(asset('common/js/jquery.mCustomScrollbar.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('admin/js/main.js')); ?>"></script>
        <script defer src="<?php echo e(asset('js/main.js')); ?>"></script>
        <script defer src="<?php echo e(asset('common/js/livewire-sortable.js')); ?>"></script>
        <script defer src="<?php echo e(asset('common/js/jquery-confirm.min.js')); ?>"></script>
        <?php echo $__env->yieldPushContent('scripts'); ?>
        <?php echo \Livewire\Livewire::scripts(); ?>

    </body>
</html>



<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/layouts/admin/pagebuilder-app.blade.php ENDPATH**/ ?>