<div class="tk-asideholder">
    <?php if( !empty($gig_addons) ): ?>
        <div class="tk-asideboxv2">
            <div class="tk-sidetitle">
                <h5><?php echo e(__('gig.selected_additional_features')); ?></h5>
            </div>
            <ul class="tk-exploremore">
                <?php
                    $total = 0;
                ?>
                <?php $__currentLoopData = $gig_addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $total +=$single['price']; 
                    ?>
                    <li>
                        <span><?php echo e($single['title']); ?></span>
                        <em><?php echo e(getPriceFormat($currency_symbol, $single['price'])); ?></em>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
            <?php
                $total +=!empty($gig_plan) ? $gig_plan[0]['price'] : 0; 
            ?>
        <ul class="tk-featuredlisted tk-exploremore">
            <li>
                <span><?php echo e(__('general.total')); ?></span>
                <em><?php echo e(getPriceFormat($currency_symbol, $total)); ?></em>
            </li>
        </ul>
    <?php endif; ?>
    <div class="tk-btnwallet">
        <a href="javascript:;" wire:click.prevent="checkout" class="tk-btn-solid-lg-lefticon"><i class="icon-lock"></i><?php echo e(__('gig.proceed_to_checkout')); ?> </a>
    </div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-cart-addons.blade.php ENDPATH**/ ?>