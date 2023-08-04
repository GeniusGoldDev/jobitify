<?php
    $info       = getUserInfo();
    $siteInfo   = getSiteInfo();
    $site_dark_logo  = !empty($siteInfo['site_dark_logo']) ? 'storage/'.$siteInfo['site_dark_logo'] : 'images/logo.svg';
 
?>


<header class="tb-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="tb-header-wraper">
                    <div class="tb-logowrapper">
                    <strong class="tk-logo">
                            <a href="<?php echo e(url('/')); ?>">
                                <img src="<?php echo e(asset($site_dark_logo)); ?>" />
                            </a>
                        </strong>
                        <a href="javascript:void(0)"><i class="icon-menu"></i></a>

                    </div>
                    <div class="tb-headercontent">
                        <div class="tb-frontendsite">
                            <a href="<?php echo e(url('clear-cache')); ?>">
                                <div class="tb-frontendsite__title">
                                    <h5><?php echo e(__('general.clear_cache')); ?></h5>
                                </div>
                                <i class="ti-reload"></i>
                            </a>
                        </div>
                        <div class="tb-frontendsite">
                            <a href="<?php echo e(url('/')); ?>" target="_blank">
                                <div class="tb-frontendsite__title">
                                    <h5><?php echo e(__('general.view_site')); ?></h5>
                                </div>
                                <i class="ti-new-window"></i>
                            </a>
                        </div>
                        <?php if(!empty($info) ): ?>
                            <div class="tb-adminhead">
                                <strong class="tb-adminhead__img">
                                    <img src="<?php echo e(asset($info['user_image'])); ?>" alt="<?php echo e($info['user_name']); ?>">
                                </strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/layouts/admin/header.blade.php ENDPATH**/ ?>