<div class="tk-hastippy" x-data="{ open: false}">
    <span class="tk-featureditem" x-on:mouseover="open = true" x-on:mouseleave="open = false">
        <i class="icon icon-zap"></i>
    </span>
    <span class="tk-tippycontent" x-show="open" style="display: none;">
        <?php echo e(__('settings.featured_project')); ?>

    </span>
</div>

<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/featured-tippy.blade.php ENDPATH**/ ?>