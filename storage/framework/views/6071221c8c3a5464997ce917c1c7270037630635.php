<?php 
    use Carbon\Carbon;
?>
<main class="tk-main-bg">
    <section class="tk-main-section">
        <div class="container">
            <?php if( !empty($packages) || !$packages->isEmpty() ): ?>
                <div class="tk-pricingholder">
                    <div class="row justify-content-center">
                        <div class="col-lg-9 col-xl-8">
                            <div class="tk-sectioninfo tk-sectioninfov2 tk-sectioncenter">
                                <div class="tk-sectiontitle text-center">
                                    <h3><?php echo e(__('general.packages_offer')); ?></h3>
                                    <h2 class="tk-sectiontitle__bold"><?php echo e(__('general.packages_info_title')); ?></h2>
                                    <div class="tk-main-description">
                                        <p><?php echo nl2br(__('general.packages_info_desc')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tk-pricing">
                        <div class="row">
                            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $subsc_packages     = array_key_exists($single->id, $subscribe_packages) ? $subscribe_packages[$single->id] : [];
                                    $rem_quota          = [];
                                    $pkg_status         = '';
                                    $remaining_duration = '';
                                    $pkg_type           = '';

                                    if( !empty($subsc_packages) && $subsc_packages->status == 'active'){
                                        $subsc_options      = @unserialize($subsc_packages->package_options);
                                        $rem_quota          = !empty($subsc_options['rem_quota']) ? $subsc_options['rem_quota'] : [];
                                        $pkg_status         = $subsc_packages->status;
                                        $expiry_date        = Carbon::parse($subsc_packages->package_expiry);
                                        $pkg_type           = $subsc_options['type'];
                                        if( $expiry_date->gte(Carbon::now()) ){
                                            if( $pkg_type == 'day'){
                                                $remaining_duration = Carbon::now()->floatDiffInDays($expiry_date);
                                                $remaining_duration = intval( $remaining_duration );
                                            } elseif( $pkg_type == 'month'){
                                                $remaining_duration = Carbon::now()->floatDiffInMonths($expiry_date);
                                                $remaining_duration = intval( $remaining_duration );
                                            } elseif( $pkg_type == 'year'){
                                                $remaining_duration = Carbon::now()->floatDiffInYears($expiry_date);
                                                $remaining_duration = intval( $remaining_duration );
                                            }
                                        }
                                    } elseif( !empty($subsc_packages) && $subsc_packages->status == 'expired'){
                                        $pkg_status = $subsc_packages->status;
                                    }
                                    $options    = unserialize($single->options);
                                    $duration   = $options['duration'] > 1 ? $options['duration'] .' '. $options['type'].'s' : $options['duration'] .' '. $options['type'];
                                ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="tk-pricing__content <?php echo e($pkg_status == 'active' ? 'tk-activepakage' : ''); ?>">
                                        <?php
                                            $image = '';
                                        if( $single->image != ''){
                                            $image = unserialize($single->image);
                                            $image = asset('storage/' .$image['file_path']);
                                        }
                                        ?>
                                        <?php if( $pkg_status == 'active' ): ?>
                                            <span><?php echo e(__('general.current_package')); ?></span>
                                        <?php elseif( $pkg_status == 'expired'): ?>
                                            <span class="tk-pakagexpired"><?php echo e(__('general.expired_package')); ?></span>
                                        <?php endif; ?>
                                        <?php if( $image != ''): ?>
                                            <img src="<?php echo e($image); ?>" >
                                        <?php endif; ?>
                                        <h4><?php echo e($single->title); ?></h4>
                                        <h2><sup><?php echo e($currency_symbol); ?></sup><?php echo e(number_format( $single->price, 2)); ?></h2>
                                        <h4><?php echo e(__('general.'.$options['type'])); ?></h4>
                                        <em><?php echo e(__('general.include_all_tax')); ?></em>
                                        <ul class="tk-pricinglist">
                                            <li>
                                                <div class="tk-pricinglist__content">
                                                    <span><?php echo e(__('general.package_duration')); ?></span>
                                                    <span>
                                                        <?php if( $remaining_duration > 0 ): ?>
                                                            <em><?php echo e(number_format( $remaining_duration)); ?> / </em>
                                                        <?php elseif( $remaining_duration == 0 && !empty($pkg_type)): ?>
                                                            <em> <?php echo e(__('general.last_'.$pkg_type)); ?> / </em>
                                                        <?php endif; ?>
                                                        <?php echo e($duration); ?>

                                                    </span>
                                                </div>
                                            </li>
                                            <?php if( $single->package_role->name == 'buyer'): ?>
                                                <li>
                                                    <div class="tk-pricinglist__content">
                                                        <span><?php echo e(__('general.no_of_projects')); ?></span>
                                                        <span>
                                                            <?php if( !empty($rem_quota) && isset($rem_quota['posted_projects']) ): ?>
                                                                <em><?php echo e($rem_quota['posted_projects']); ?> / </em>
                                                            <?php endif; ?>
                                                            <?php echo e($options['posted_projects']); ?> <?php echo e(__('general.projects')); ?>

                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tk-pricinglist__content">
                                                        <span><?php echo e(__('general.feature_projects')); ?></span>
                                                        <span>
                                                            <?php if( !empty($rem_quota) && isset($rem_quota['featured_projects']) ): ?>
                                                                <em><?php echo e($rem_quota['featured_projects']); ?> / </em>
                                                            <?php endif; ?>
                                                            <?php echo e($options['featured_projects']); ?> <?php echo e(__('general.allowed')); ?>

                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tk-pricinglist__content">
                                                        <span><?php echo e(__('general.feature_project_duration')); ?></span>
                                                        <span><?php echo e($options['project_featured_days']); ?> <?php echo e(__('general.day')); ?></span>
                                                    </div>
                                                </li>
                                            <?php else: ?>
                                                <li>
                                                    <div class="tk-pricinglist__content">
                                                        <span><?php echo e(__('general.credit_for_project')); ?></span>
                                                        <span>
                                                            <?php if( !empty($rem_quota) && isset($rem_quota['credits']) ): ?>
                                                                <em><?php echo e($rem_quota['credits']); ?> / </em>
                                                            <?php endif; ?>
                                                            <?php echo e($options['credits']); ?> <?php echo e(__('general.credits')); ?>

                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tk-pricinglist__content">
                                                        <span><?php echo e(__('general.profile_feature_duration')); ?></span>
                                                        <span><?php echo e($options['profile_featured_days']); ?> <?php echo e(__('general.day')); ?></span>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                        <a href="javascript:;" wire:click.prevent="buyPackage(<?php echo e($single->id); ?>)"  class="tk-btn-solid-lg">
                                            <?php if(in_array($pkg_status, ['active','expired'])): ?>
                                                <?php echo e(__('general.renew_package')); ?>

                                            <?php else: ?>
                                                <?php echo e(__('general.buy_now')); ?>

                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/packages/packages.blade.php ENDPATH**/ ?>