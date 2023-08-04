<!doctype html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="zxx">
<!--<![endif]-->
<?php  
    $sitInfo        = getSiteInfo();
    $siteTitle      = $sitInfo['site_name'];
    $siteFavicon    = $sitInfo['site_favicon'];
    $rtl            = setting('_site.rtl');
    $rtl_class      = !empty($rtl) && $rtl == 1 ? 'tk-rtl' : ''; 
?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> <?php echo e(__('general.adminpanel_title')); ?> | <?php echo e($siteTitle); ?></title>
        <link rel="icon" href="<?php echo e(asset('storage/'.$siteFavicon)); ?>" type="image/x-icon">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo app('Illuminate\Foundation\Vite')([
            'public/common/css/bootstrap.min.css',
            'public/admin/css/themify-icons.css',
            'public/css/feather-icons.css',
            'public/css/fontawesome/all.min.css',
            'public/common/css/select2.min.css',
            'public/common/css/jquery.mCustomScrollbar.min.css',
            'public/common/css/jquery-confirm.min.css',
        ]); ?>
        <?php echo $__env->yieldPushContent('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('admin/css/main.css')); ?>">
        <?php if( !empty($rtl_class) ): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo e(asset('admin/css/rtl.css')); ?>">
        <?php endif; ?>
        <?php echo \Livewire\Livewire::styles(); ?>

    </head>
    <body class="tb-bodycolor">
        <?php echo $__env->make('layouts.admin.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="tb-mainwrapper">
            <?php echo $__env->make('layouts.admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="tb-subwrapper">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                    <?php echo $__env->make('layouts.admin.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
       
        <?php echo $__env->make('layouts.admin.footer_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <script>
            $(document).on("click", '.update-section-settings, .reset-section-settings', function(event){
                setTimeout(function() {
                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "<?php echo e(url('admin/update-sass-style')); ?>",
                        method: 'post',
                        success: function(data){
                        }
                    });
                }, 300);         
            });
        </script>
        <?php echo $__env->yieldPushContent('scripts'); ?>
        <?php echo \Livewire\Livewire::scripts(); ?>

    </body>
</html>



<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/layouts/admin/app.blade.php ENDPATH**/ ?>