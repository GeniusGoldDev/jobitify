<?php
    $activeRoute        = request()->route()->getName();
    $activeTaxonomyTab  = in_array($activeRoute, [
    'project-categories',
    'gig-categories',
    'gig-delivery-time',
    'tags',
    'skills',
    'languages',
    'project-duration',
    'project-location',
    'expert-levels'
    ]);

    $activePaymentTab           = in_array($activeRoute, ['commission-settings', 'payment-methods']);
    $activeSiteManagementTab    = in_array($activeRoute, ['SitePages', 'manage-menu', 'optionbuilder', 'EmailTemplates']);
    $activeTransactionTab       = in_array($activeRoute, [
    'withdraw-requests',
    'admin-earnings',
    'commission-settings',
    'payment-methods',
    'packages-setting',
    'disputes'
    ]);
    $activeProjectManagementTab     = in_array($activeRoute, ['projects', 'proposals']);
    $activeGigManagementTab         = in_array($activeRoute, ['gigs', 'admin-gig-orders']);
    
?>
<div class="tb-sidebarwrapperholder">
    <aside id="tb-sidebarwrapper" class="tb-sidebarwrapper">
        <div id="tb-btnmenutoggle" class="tb-btnmenutoggle">
            <a href="javascript:void(0);"><i class="ti-pin2"></i></a>
        </div>
        <nav id="tb-navdashboard" class="tb-navdashboard mCustomScrollbar">
            <ul class="tb-siderbar-nav">
                <li class ="<?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">
                    <a class="tb-menuitm" href="<?php echo e(route('profile')); ?>" data-tippy-content="<?php echo e(__('sidebar.profile')); ?>">
                        <i class="icon-user"></i><span class="tb-navdashboard__title"><?php echo e(__('sidebar.profile')); ?></span>
                    </a>
                </li>
                <li class="menu-has-children <?php echo e($activeTaxonomyTab ? 'active tb-openmenu': ''); ?>">
                    <a class="tb-menuitm" href="javascript:void(0);" data-tippy-content="<?php echo e(__('sidebar.taxonomies')); ?>">
                        <i class="icon-layers"></i><span class="tb-navdashboard__title"><?php echo e(__('sidebar.taxonomies')); ?></span>
                    </a>
                    <ul class="sidebar-sub-menu" style="display:<?php echo e($activeTaxonomyTab ? 'block': ''); ?>">
                        <li class ="<?php echo e(request()->routeIs('project-categories') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('project-categories')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.project-categories')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('gig-categories') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('gig-categories')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.gig-categories')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('tags') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('tags')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.tags')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('gig-delivery-time') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('gig-delivery-time')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.gig_delivery_time')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('skills') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('skills')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.skills')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('languages') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('languages')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.languages')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('project-duration') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('project-duration')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.project_duration')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('project-location') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('project-location')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.project_locations')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('expert-levels') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('expert-levels')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.expert_levels')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-has-children <?php echo e($activeSiteManagementTab ? 'active tb-openmenu': ''); ?>">
                    <a href="javascript:void(0);" class="tb-menuitm" data-tippy-content="<?php echo e(__('sidebar.site_management')); ?>">
                        <i class="icon-layout"></i><span class="tb-navdashboard__title"><?php echo e(__('sidebar.site_management')); ?></span>
                    </a>
                    <ul class="sidebar-sub-menu" style="display:<?php echo e($activeSiteManagementTab ? 'block': ''); ?>">
                        <li class="<?php echo e(request()->routeIs('SitePages') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('SitePages')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.sitepages')); ?></span>
                            </a>
                        </li> 
                        <li class="<?php echo e(request()->routeIs('manage-menu') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('manage-menu')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.menu')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('optionbuilder') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('optionbuilder')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.settings')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(request()->routeIs('EmailTemplates') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('EmailTemplates')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.email_templates')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-has-children <?php echo e($activeTransactionTab ? 'active tb-openmenu': ''); ?>">
                    <a href="javascript:void(0);" class="tb-menuitm" data-tippy-content="<?php echo e(__('sidebar.transaction_payment')); ?>">
                        <i class="icon-credit-card"></i><span class="tb-navdashboard__title"><?php echo e(__('sidebar.transaction_payment')); ?></span>
                    </a>
                    <ul class="sidebar-sub-menu" style="display:<?php echo e($activeTransactionTab ? 'block': ''); ?>">
                        <li class="<?php echo e(request()->routeIs('withdraw-requests') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('withdraw-requests')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.withdraw_requests')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(request()->routeIs('admin-earnings') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin-earnings')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.earnings')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('commission-settings') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('commission-settings')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.commission_settings')); ?></span>
                            </a>
                        </li>
                        <li class ="<?php echo e(request()->routeIs('payment-methods') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('payment-methods')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.payment_methods')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(request()->routeIs('packages-setting') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('packages-setting')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.packages')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(request()->routeIs('disputes') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('disputes')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.disputes')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-has-children <?php echo e($activeProjectManagementTab ? 'active tb-openmenu': ''); ?>">
                    <a href="javascript:void(0);" class="tb-menuitm" data-tippy-content="<?php echo e(__('sidebar.project_management')); ?>">
                        <i class="icon-file-text"></i><span class="tb-navdashboard__title"><?php echo e(__('sidebar.project_management')); ?></span>
                    </a>
                    <ul class="sidebar-sub-menu" style="display:<?php echo e($activeProjectManagementTab ? 'block': ''); ?>">
                        <li class="<?php echo e(request()->routeIs('projects') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('projects')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.projects')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(request()->routeIs('proposals') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('proposals')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.proposals')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li id='gig-management' class="menu-has-children <?php echo e($activeGigManagementTab ? 'active tb-openmenu': ''); ?>">
                    <a href="javascript:void(0);" class="tb-menuitm" data-tippy-content="<?php echo e(__('sidebar.gig_management')); ?>">
                        <i class="icon-database"></i><span class="tb-navdashboard__title"><?php echo e(__('sidebar.gig_management')); ?></span>
                    </a>
                    <ul class="sidebar-sub-menu" style="display:<?php echo e($activeGigManagementTab ? 'block': ''); ?>">
                        <li class="<?php echo e(request()->routeIs('gigs') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('gigs')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.gigs')); ?></span>
                            </a>
                        </li>
                        <li class="<?php echo e(request()->routeIs('admin-gig-orders') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('admin-gig-orders')); ?>">
                                <i class="icon-corner-down-right"></i>
                                <span class="tb-navdashboard__title"><?php echo e(__('sidebar.gig_orders')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo e(request()->routeIs('users') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('users')); ?>" class="tb-menuitm" data-tippy-content ="<?php echo e(__('sidebar.users')); ?>">
                        <i class="icon-users"></i><span class="tb-navdashboard__title"><?php echo e(__('sidebar.users')); ?></span>
                    </a>
                </li>
                <li>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">  
                        <?php echo csrf_field(); ?>  
                        <a href="<?php echo e(route('logout')); ?>" class="tb-menuitm" data-tippy-content="<?php echo e(__('sidebar.logout')); ?>"   onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="ti-power-off"></i><span class="tb-navdashboard__title"> <?php echo e(__('sidebar.logout')); ?></span>
                        </a>
                    </form>    
                </li>
            </ul>
        </nav>
    </aside>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/layouts/admin/sidebar.blade.php ENDPATH**/ ?>