<?php
    $info = getUserInfo();
?>
<div class="tb-headerwrap__right">
    <div class="tb-userlogin sub-menu-holder">
        <a href="javascript:void(0);" id="profile-avatar-menue-icon" class="tb-hasbalance">
            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer|seller')): ?>
                <div class="tk-wallet">
                    <span><strong><?php echo e(getUserWalletAmount()); ?></strong><?php echo e(__('general.wallet_balance')); ?></span>
                </div>
              <?php endif; ?>
            <img src="<?php echo e(asset($info['user_image'])); ?>" alt="<?php echo e($info['user_image']); ?>" />
        </a>
        <ul class="sub-menu">
            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer|seller')): ?>
                <li class="tb-switch-profile">
                    <div class="tb-expert-content <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?> tk-bgswtich <?php endif; ?>">
                        <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                            <h2> <?php echo e(ucfirst( strtolower( __('general.switch_profile', ['user_role' => __('general.seller')])  ))); ?></h2>
                            <p><?php echo e(ucfirst( strtolower( __('general.switch_profile_desc', ['user_role' => __('general.buyer')]) ))); ?></p>
                        <?php else: ?>
                            <h2><?php echo e(ucfirst( strtolower( __('general.switch_profile', ['user_role' => __('general.buyer')]) ))); ?></h2>
                            <p><?php echo e(ucfirst( strtolower( __('general.switch_profile_desc', ['user_role' => __('general.seller')]) ))); ?></p>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo e(route('switch-role')); ?>">
                            <?php echo csrf_field(); ?>
                            <a class="tb-expert-anchor" href="<?php echo e(route('switch-role')); ?>" onclick="event.preventDefault(); this.closest('form').submit();"> 
                                <?php echo e(__('general.switch_role' )); ?><i class="icon icon-chevron-right"></i>
                            </a>
                        </form>
                    </div>
                </li>
                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                    <li class="tb-account-settings">
                        <a href="<?php echo e(route('seller-profile',['slug' => $info['slug']])); ?>" target="_blank"> <i class="icon-user"></i><?php echo e(__('navigation.profile')); ?> </a>
                    </li>
                <?php endif; ?>
                <li class="tb-account-settings">
                    <a href="<?php echo e(route('settings')); ?>"> <i class="icon-settings"></i><?php echo e(__('navigation.settings')); ?> </a>
                </li>
                <li class="tb-account-settings">
                    <a href="<?php echo e(route('packages')); ?>"> <i class="icon-package"></i><?php echo e(__('navigation.packages')); ?> </a>
                </li>
            <?php endif; ?>
            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'admin')): ?>
                <li class="tb-saveditems">
                    <a href="<?php echo e(route('profile')); ?>"> <i class="icon-user"></i><?php echo e(__('sidebar.profile')); ?> </a>
                </li>
                <li class="tb-saveditems">
                    <a href="<?php echo e(route('optionbuilder')); ?>"> <i class="icon-settings"></i><?php echo e(__('navigation.settings')); ?> </a>
                </li>
            <?php endif; ?>
            <li class="tb-logout">
                <!-- Authentication -->
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();"><i class="icon-power"></i><?php echo e(__('auth.logout')); ?> </a>
                </form>
            </li>
        </ul>
    </div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/user-menu.blade.php ENDPATH**/ ?>