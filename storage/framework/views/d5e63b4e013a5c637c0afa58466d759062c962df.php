<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['sitelogo', 'header_menu']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['sitelogo', 'header_menu']); ?>
<?php foreach (array_filter((['sitelogo', 'header_menu']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
    $class = 'tk-headervtwo';
    $currentURL = url()->current();
    if( url('/') == $currentURL ){
        $class = '';
    } 
    $logo = url('/') == $currentURL ? 'demo-content/logo.png' : 'demo-content/taskup-logo.png';
    $userInfo   = getUserInfo();
    $userRole   = !empty( $userInfo['user_role'] ) ? $userInfo['user_role'] : '';
    $top_menue  = [];
    
    if( in_array($userRole, ['admin','seller']) ){
        $top_menue['search-projects']   = __('navigation.explore_all_projects');
        if($userRole == 'seller'){
            $top_menue['dashboard']     = __('navigation.dashboard');
        }
        if($userRole == 'admin'){
            $top_menue['search-sellers'] = __('navigation.search_seller');
            $top_menue['search-gigs']    = __('navigation.search_gigs');
        }
    }
?>
<!-- HEADER START -->
<header class="tb-header <?php echo e($class); ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="tb-headerwrap <?php echo e($userRole == 'seller' ? 'tk-sellermenu' : ''); ?>">
                    <strong class="tk-logo">
                        <?php if( !empty($sitelogo) ): ?>
                            <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('storage/'.$sitelogo)); ?>" alt="<?php echo e(__('general.logo')); ?>" /></a>
                        <?php else: ?>
                            <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset($logo)); ?>" alt="<?php echo e(__('general.logo')); ?>" /></a>
                        <?php endif; ?>
                    </strong>
                    <nav class="tb-navbar navbar-expand-xl">
                        <?php if( Auth::guest() || ( Auth::user() && !empty($top_menue) )): ?>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#tenavbar" aria-expanded="false" >
                                <i class="icon-menu"></i>
                            </button>
                        <?php endif; ?>
                        <?php if( Auth::user() && !empty($top_menue)): ?>
                            <div id="tenavbar" class="collapse navbar-collapse">
                                <ul class="navbar-nav tb-navbarnav">
                                    <?php $__currentLoopData = $top_menue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route => $menu_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="tb-find-projects">
                                            <a href="<?php echo e(route($route)); ?>"> <?php echo e($menu_item); ?> </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php elseif(Auth::guest()): ?>
                            <div id="tenavbar" class="collapse navbar-collapse">
                                <ul class="navbar-nav tb-navbarnav">
                                    <?php if( !empty($header_menu) && $header_menu->count() > 0 ): ?> 
                                        <?php $__currentLoopData = $header_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu-item','data' => ['menu' => $menu]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menu' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menu)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <li class="tk-themenav_signbtn">
                                        <a class="tk-btn-solid-sm tk-registerbtn" href="<?php echo e(route('register')); ?>"><i class="icon icon-user-plus"></i><?php echo e(__( 'general.register' )); ?> </a>
                                        <a class="tk-btn-solid-sm tk-btn-yellow" href="<?php echo e(route('login')); ?>"><i class="icon icon-arrow-right"></i> <?php echo e(__( 'general.login' )); ?> </a>
                                    </li>
                                </ul>
                            </div> 
                        <?php endif; ?>
                    </nav>
                    <?php if( Auth::user() ): ?>
                       <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('user-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>   
                </div>
            </div>
        </div>
    </div>
</header>
<?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer|seller')): ?>
    <div class="tk-headerbottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tk-seller-tabs">
                        <nav class="tb-navbar tb-navbarbtm navbar-expand-xl">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavvtwo" aria-expanded="false" >
                                <i class="icon-menu"></i>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavvtwo">
                                <ul class="nav nav-tabs tk-seller-list navbar-nav" id="myTab" role="tablist">
                                    <li class="tk-seller-item">
                                        <a <?php if( request()->routeIs('dashboard') ): ?> class="active" <?php endif; ?> href="<?php echo e(route('dashboard')); ?>">
                                            <i class="icon-bar-chart-2"></i><?php echo e(__('navigation.dashboard')); ?>

                                        </a>
                                    </li>
                                    <li class="tk-seller-item">
                                        <a <?php if( request()->routeIs('project-listing') ): ?> class="active" <?php endif; ?> href="<?php echo e(route('project-listing')); ?>">
                                            <i class="icon-layers"></i><?php echo e(__('navigation.my_projects')); ?>

                                        </a>
                                    </li>
                                    <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                        <li class="tk-seller-item">
                                            <a <?php if( request()->routeIs('gig-list') ): ?> class="active" <?php endif; ?> href="<?php echo e(route('gig-list')); ?>">
                                                <i class="icon-file-text"></i><?php echo e(__('navigation.my_gigs')); ?>

                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="tk-seller-item">
                                        <a <?php if( request()->routeIs('gig-orders') ): ?> class="active" <?php endif; ?> href="<?php echo e(route('gig-orders')); ?>">
                                            <i class="icon-check-square"></i>
                                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                                <?php echo e(__('navigation.my_orders')); ?>

                                            <?php else: ?>
                                                <?php echo e(__('navigation.gig_orders')); ?>

                                            <?php endif; ?>
                                        </a>
                                    </li>
                                    <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                        <li class="tk-seller-item">
                                            <a <?php if( request()->routeIs('search-gigs') ): ?> class="active" <?php endif; ?> href="<?php echo e(route('search-gigs')); ?>">
                                                <i class="icon-file-text"></i><?php echo e(__('navigation.search_gigs')); ?>

                                            </a>
                                        </li>
                                        <li class="tk-seller-item">
                                            <a <?php if( request()->routeIs('search-sellers') ): ?> class="active" <?php endif; ?> href="<?php echo e(route('search-sellers')); ?>">
                                                <i class="icon-star"></i><?php echo e(__('navigation.search_seller')); ?>

                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="tk-seller-item">
                                        <a <?php if( request()->routeIs('dispute-list') ): ?> class="active" <?php endif; ?> href="<?php echo e(route('dispute-list')); ?>">
                                            <i class="icon-alert-triangle"></i><?php echo e(__('navigation.disputes')); ?>

                                        </a>
                                    </li>
                                    <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                        <li class="tk-seller-item">
                                            <a <?php if( request()->routeIs('invoices') ): ?> class="active" <?php endif; ?> href="<?php echo e(route('invoices')); ?>">
                                                <i class="icon-shopping-bag"></i><?php echo e(__('navigation.invoices')); ?>

                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="tk-seller-item">
                                        <a <?php if( request()->routeIs('favourite-items') ): ?> class="active" <?php endif; ?> href="<?php echo e(route('favourite-items')); ?>">
                                            <i class="icon-heart"></i><?php echo e(__('navigation.saved_items')); ?>

                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                        <div class="tk-bootstraps-tabs-button">
                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
                                <a href="<?php echo e(route('create-gig')); ?>" class="tk-tabs-button"><?php echo e(__('navigation.create_gig')); ?>

                                    <i class="icon-plus"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('create-project')); ?>" class="tk-tabs-button"><?php echo e(__('navigation.post_project')); ?>

                                    <i class="icon-plus"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
    
<!-- HEADER END --><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/header.blade.php ENDPATH**/ ?>