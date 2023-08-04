<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['education', 'index']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['education', 'index']); ?>
<?php foreach (array_filter((['education', 'index']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php 

    $collapse_class     = 'collapsed';
    $area_expended      = 'false';
    $show_desc_class    = '';
    if($index == 0 && !empty($education->deg_description)){
        $show_desc_class    = 'show';
        $collapse_class     = '';
        $area_expended      = 'true';
    }
?>
<li>
    <div class="tk-accordion_title <?php echo e($collapse_class); ?>" data-bs-toggle="collapse" role="button" data-bs-target="#education-<?php echo e($education->id); ?>" aria-expanded="<?php echo e($area_expended); ?>">
        <div class="tk-qualification-title">
            <h5><?php echo $education->deg_title; ?></h5>
            <ul class="tk-qualifinfo">
                <li><span><i class="icon-home"></i> <?php echo $education->deg_institue_name; ?></span></li>
                <?php if(!empty($education->address)): ?>
                    <li><span><i class="icon-map-pin"></i><?php echo $education->address; ?></span></li>
                <?php endif; ?>
                <li>
                    <span>
                        <i class="icon-calendar"></i> 
                        <?php if($education->is_ongoing): ?>
                            <?php echo e(date('F d, Y', strtotime($education->deg_start_date))); ?> - <?php echo e(_('general.present')); ?>

                        <?php else: ?>
                            <?php echo e(date('F d, Y', strtotime($education->deg_start_date))); ?>&nbsp;&nbsp;- &nbsp;&nbsp;<?php echo e(date('F d, Y', strtotime($education->deg_end_date))); ?>

                        <?php endif; ?>
                    </span>
                </li>
            </ul>
        </div>
        <?php if(!empty($education->deg_description)): ?>
             <i class="icon-plus"></i>
        <?php endif; ?>
    </div>
    <?php if(!empty($education->deg_description)): ?>
        <div class="collapse <?php echo e($show_desc_class); ?>" id="education-<?php echo e($education->id); ?>" data-bs-parent="#tk-accordion">
            <div class="tk-accordion_info">
                <p><?php echo e($education->deg_description); ?></p>
            </div>
        </div>
    <?php endif; ?>
</li><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/education-item.blade.php ENDPATH**/ ?>