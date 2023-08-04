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
    $selected_value = '';
    if(isset($value) ){
        if( is_array($value) && !empty($value) ){
            $selected_value = $value;
        }else{
           $selected_value = $value; 
        }        
    }
    $tab_key_id = $id;
    $label_id       = time().'_'.rand(1,99999);
    $name = '';
    if( !empty($repeater_id) ){
        if( !empty($parent_rep) ){
            $name = "$parent_rep".'['.$repeater_id.']['.$index.']['.$id.']'.(!empty($options) && is_array($options) ? '[]' :'');
        }else{
            $name = "$repeater_id".'['.$index.']['.$id.']'.(!empty($options) && is_array($options) ? '[]' :'');
        }
    }else{
        if( !empty($options) && is_array($options) ){
            $id = !empty($id) ? $id.'[]' : '';
        }
        $name = $id;
    }  
?>
<?php if( !empty($repeater_type) && $repeater_type == 'single' ): ?>
    <?php if( !empty($options) && is_array($options) ): ?>
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $checked = false;
                if( !empty($selected_value) ){
                    if(in_array($key, $selected_value )){
                        $checked = true; 
                    }
                }elseif( !empty($default) && is_array($default) && in_array($key, $default ) ){
                    $checked = true;   
                }
                $label_id       = time().'_'.rand(1,99999);
            ?>
            <div class="op-switchbtn">
                <input type="checkbox" id="<?php echo e($label_id); ?>" data-multi_items="true" data-id="<?php echo e($id ?? ''); ?>" name="<?php echo e($name); ?>" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> <?php if( $checked ): ?> checked <?php endif; ?>  value="<?php echo e($key); ?>" class="op-input-field  <?php echo e($class ?? ''); ?>" >
                <label for="<?php echo e($label_id); ?>" class="op-textdes">
                    <span><?php echo e($single); ?></span>
                </label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="op-switchbtn">
            <input type="checkbox" id="<?php echo e($label_id); ?>" data-multi_items="false" data-id="<?php echo e($id ?? ''); ?>" name="<?php echo e($name); ?>" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?>   value="<?php echo e($value ?? ''); ?>" <?php if( $selected_value == $db_value ): ?> checked <?php endif; ?> class="op-input-field  <?php echo e($class ?? ''); ?>" >
            <label for="<?php echo e($label_id); ?>" class="op-textdes">
                <span ><?php echo e($field_title ?? ''); ?></span>
            </label>
        </div>
    <?php endif; ?>
<?php else: ?>
    <li class="form-group-wrap">
        <?php if( !empty($label_title) ): ?>
            <div class="form-group-half">
                <div class="op-textcontent">
                    <h6>
                        <?php echo $label_title; ?>

                        <?php if( empty($repeater_id) && config('optionbuilder.developer_mode') == 'yes' ): ?>
                            <span class="op-alert">setting(‘<?php echo e($tab_key); ?>.<?php echo e($tab_key_id); ?>’)</span>
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
                <?php if( !empty($options) && is_array($options) ): ?>
                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $checked = false;
                            if( !empty($selected_value) ){
                                if(in_array($key, $selected_value )){
                                    $checked = true; 
                                }
                            }elseif( !empty($default) && is_array($default) && in_array($key, $default ) ){
                                $checked = true;   
                            }
                            $label_id       = time().'_'.rand(1,99999);
                        ?>
                        <div class="op-switchbtn">
                            <input type="checkbox" id="<?php echo e($label_id); ?>" data-multi_items="true" data-id="<?php echo e($id ?? ''); ?>" name="<?php echo e($name); ?>" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> <?php if( $checked ): ?> checked <?php endif; ?>  value="<?php echo e($key); ?>" class="op-input-field  <?php echo e($class ?? ''); ?>" >
                            <label for="<?php echo e($label_id); ?>" class="op-textdes">
                                <span><?php echo e($single); ?></span>
                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="op-switchbtn">
                        <input type="checkbox" id="<?php echo e($label_id); ?>" data-multi_items="false" data-id="<?php echo e($id ?? ''); ?>" name="<?php echo e($name); ?>" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?>   value="<?php echo e($value ?? ''); ?>" <?php if( $selected_value == $db_value ): ?> checked <?php endif; ?> class="op-input-field  <?php echo e($class ?? ''); ?>" >
                        <label for="<?php echo e($label_id); ?>" class="op-textdes">
                            <span ><?php echo e($field_title ?? ''); ?></span>
                        </label>
                    </div>
                <?php endif; ?>
                <?php if( !empty($field_desc) ): ?><span><?php echo $field_desc; ?></span> <?php endif; ?>           
            </div>
        </div>
    </li>
<?php endif; ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/vendor/larabuild/optionbuilder/resources/views/components/switch.blade.php ENDPATH**/ ?>