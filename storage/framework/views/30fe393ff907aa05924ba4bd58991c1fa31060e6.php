<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'disabled' => false,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'disabled' => false,
]); ?>
<?php foreach (array_filter(([
    'disabled' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<li class="form-group-wrap op-textcontent">
    <?php if( !empty($label_title) ): ?>
        <div class="form-group-half">
            <div class="op-textcontent">
                <h6>
                    <?php echo $label_title; ?>

                    <?php if( config('optionbuilder.developer_mode') == 'yes' ): ?>
                        <span class="op-alert">setting(‘<?php echo e($tab_key); ?>.<?php echo e($id); ?>’)</span>
                    <?php endif; ?>
                </h6>
                <?php if( !empty( $label_desc) ): ?>
                    <em><?php echo $label_desc; ?></em>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group-half">
        <div class="op-textcontent">
            <div class="accordion op-accordion" id="<?php echo e($id ?? ''); ?>">
                <?php if( !empty($value) && is_array($value) ): ?>
                    <?php
                        $title_index = 1;
                    ?>
                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $mapping_fields = !empty($fields) && is_array($fields) ? $fields : [];
                        ?>
                        <div class="op-accordion-item">
                            <div class="op-item">
                                <h2 data-bs-toggle="collapse" class="op-collase-sec" data-title="<?php echo e($repeater_title ?? ''); ?>" data-bs-target="#op-rep-accord-<?php echo e($index); ?>" aria-expanded="false"><?php echo e($repeater_title ?? ''); ?> <?php echo e($title_index++); ?></h2>
                                <div class="op-icons">
                                    <a href="javascript:void(0)" data-repeater_id="<?php echo e($id ?? ''); ?>" class="op-trashclr op-trash-mul-rep"> <i class="icon-trash-2"></i></a>
                                    <span class="op-accordion-angle op-collase-sec" data-bs-toggle="collapse" data-bs-target="#op-rep-accord-<?php echo e($index); ?>" aria-expanded="false"><i class="icon-chevron-right"></i></span>
                                </div>
                            </div>
                            <div id="op-rep-accord-<?php echo e($index); ?>" class="accordion-collapse collapse" data-bs-parent="#<?php echo e($id ?? ''); ?>">
                                <div class="accordion-body">
                                    <?php if( !empty($mapping_fields) && is_array($mapping_fields) ): ?>
                                        <?php
                                            foreach($single as $key=> $item){
                                                $field_index = array_search($key, array_column($mapping_fields, 'id'));
                                                if( $field_index !== false ){
                                                    $mapping_fields[$field_index]['value'] = $item;
                                                }
                                            }
                                        ?>
                                        <?php echo getSectionSetting(['tab_key' => $tab_key, 'index' => $index, 'repeater_id' => ($id ??  '') ], $mapping_fields); ?>

                                    <?php endif; ?>    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="op-accordion-item">
                        <div class="op-item">
                            <h2 data-bs-toggle="collapse" class="op-collase-sec" data-title="<?php echo e($repeater_title ?? ''); ?>" data-bs-target="#op-rep-accord-0" aria-expanded="false"><?php echo e($repeater_title ?? ''); ?></h2>
                            <div class="op-icons">
                                <a href="javascript:void(0)" data-repeater_id="<?php echo e($id ?? ''); ?>" class="op-trashclr op-trash-mul-rep"> <i class="icon-trash-2"></i></a>
                                <span class="op-accordion-angle op-collase-sec" data-bs-toggle="collapse" data-bs-target="#op-rep-accord-0" aria-expanded="false"><i class="icon-chevron-right"></i></span>
                            </div>
                        </div>
                        <div id="op-rep-accord-0" class="accordion-collapse collapse" data-bs-parent="#<?php echo e($id ?? ''); ?>">
                            <div class="accordion-body">
                                <?php if( !empty($fields) && is_array($fields) ): ?>
                                    <?php echo getSectionSetting(['tab_key' => $tab_key, 'index' => rand(1,999).time(), 'repeater_id' => ($id ??  '') ], $fields); ?>

                                <?php endif; ?>    
                            </div>
                        </div>
                    </div>     
                <?php endif; ?>        
            </div> 
        </div>
        <div class="op-add-dwonload">
            <a class="op-btn-two more-mul-rep" data-repeater="<?php echo e($id ?? ''); ?>" href="javascript:;"><i class="icon-plus"></i><?php echo e(__('optionbuilder::option_builder.add_more')); ?></a>
        </div>
    </div>
</li>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/vendor/larabuild/optionbuilder/resources/views/components/multiple-repeater.blade.php ENDPATH**/ ?>