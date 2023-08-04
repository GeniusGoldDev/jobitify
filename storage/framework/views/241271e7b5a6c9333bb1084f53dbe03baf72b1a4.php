<?php if(Popper::hasThemes() or config('popper.fix-bs3')): ?>
    <script type="text/javascript">function injectCSS(e){if("undefined"!=typeof window&&"undefined"!=typeof document){var t=document.createElement("style");t.type="text/css",t.textContent=e,t.setAttribute("data-tippy-stylesheet","");var n=document.head,d=n.querySelector("style,link");d?n.insertBefore(t,d):n.appendChild(t)}}</script>
    <?php if(config('popper.fix-bs3')): ?>
        <script type="text/javascript">injectCSS('.tippy-tooltip{font-size:.9rem;padding:.3rem .6rem}')</script>
    <?php endif; ?>
    <?php echo e(Popper::injectThemes()); ?>

<?php endif; ?>
<?php if(! Config::has('popper')): ?>
    <script src="https://unpkg.com/popper.js@1"></script>
    <script src="https://unpkg.com/tippy.js@4"></script>
<?php else: ?>
    
    <?php if(config('popper.popper.active')): ?>
        <script <?php if(config('popper.popper.mode') == 'cdn'): ?> src="<?php echo e(config('popper.popper.cdn')); ?>" <?php else: ?> src="<?php echo e(asset(config('popper.popper.asset'))); ?>" <?php endif; ?>></script>
    <?php endif; ?>
    
    <?php if(config('popper.tippy.active')): ?>
        <script <?php if(config('popper.tippy.mode') == 'cdn'): ?> src="<?php echo e(config('popper.tippy.cdn')); ?>" <?php else: ?> src="<?php echo e(asset(config('popper.tippy.asset'))); ?>" <?php endif; ?>></script>
    <?php endif; ?>
<?php endif; ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/vendor/andcarpi/laravel-popper/resources/views/assets.blade.php ENDPATH**/ ?>