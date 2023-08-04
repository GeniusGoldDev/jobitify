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
<?php 
    
    $selected_value = (isset($value) && !is_null($value) ? $value :(isset($default) && !is_null($default) ? $default :  '')); 
    $name = '';
    if( !empty($repeater_id) ){
        if( !empty($parent_rep) ){
            $name = "$parent_rep".'['.$repeater_id.']['.$index.']['.$id.']';
        }else{
            $name = "$repeater_id".'['.$index.']['.$id.']';
        }
    }else{
        $name = $id;
    } 
?> 
<?php if( !empty($repeater_type) && $repeater_type == 'single' ): ?>
    <?php if( !empty($options) && is_array($options) ): ?>
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $label_id       = time().'_'.rand(1,99999);
            ?>
            <div class="op-radiobtn">
                <input type="radio" id="<?php echo e($label_id); ?>"  <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> data-id="<?php echo e($id); ?>" name="<?php echo e($name); ?>" <?php if( $selected_value == $key ): ?> checked <?php endif; ?>  value="<?php echo e($key); ?>" class="op-input-field <?php echo e($class ?? ''); ?>" >
                <label for="<?php echo e($label_id); ?>"><?php echo e($single); ?></label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php else: ?>
    <li class="form-group-wrap">
        <?php if( !empty($label_title) ): ?>
            <div class="form-group-half">
                <div class="op-textcontent">
                    <h6>
                        <?php echo $label_title; ?>

                        <?php if( empty($repeater_id) && config('optionbuilder.developer_mode') == 'yes' ): ?>
                            <span class="op-alert">setting(‘<?php echo e($tab_key); ?>.<?php echo e($id); ?>’)</span>
                        <?php endif; ?>
                    </h6>
                    <?php if( !empty( $label_desc) ): ?>
                        <em><?php echo $label_desc; ?></em>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if( !empty($options) && is_array($options) ): ?>
            <div class="form-group-half">
                <div class="op-textcontent">
                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $label_id       = time().'_'.rand(1,99999);
                        ?>
                        <div class="op-radiobtn">
                            <input type="radio" id="<?php echo e($label_id); ?>" data-id="<?php echo e($id); ?>" name="<?php echo e($name); ?>" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> <?php if( $selected_value == $key ): ?> checked <?php endif; ?>  value="<?php echo e($key); ?>" class="op-input-field <?php echo e($class ?? ''); ?>" >
                            <label for="<?php echo e($label_id); ?>"><?php echo e($single); ?></label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if( !empty($field_desc) ): ?><span><?php echo $field_desc; ?></span> <?php endif; ?>           
                </div>
            </div>
        <?php endif; ?>
    </li>
<?php endif; ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/vendor/larabuild/optionbuilder/resources/views/components/radio.blade.php ENDPATH**/ ?>