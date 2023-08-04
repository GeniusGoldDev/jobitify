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
    $selected_value = !empty($value) ? $value : []; 
    $name = '';
    $tab_key_id = $id;
    if( !empty($repeater_id) ){
        if( !empty($parent_rep) ){
            $name = "$parent_rep".'['.$repeater_id.']['.$index.']['.$id.']'.(!empty($options) && !empty($multi) && $multi ? '[]' :'');
        }else{
            $name = "$repeater_id".'['.$index.']['.$id.']'.(!empty($options) && !empty($multi) && $multi ? '[]' :'');
        }
    }else{
        if( !empty($options) && is_array($options) && !empty($multi) && $multi ){
            
            $id = !empty($id) ? $id.'[]' : '';
        }
        $name = $id;
    }  
?>

<?php if( !empty($repeater_type) && $repeater_type == 'single' ): ?>
    <?php if( !empty($options) && is_array($options) ): ?>         
        <div class="op-select"> 
            <select <?php if(!empty($multi) && $multi): ?> multiple data-multi_items="true" <?php endif; ?> class="op-input-field form-control op-selectoption <?php echo e($class ?? ''); ?>" data-id="<?php echo e($id ?? ''); ?>" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> name="<?php echo e($name); ?>" data-placeholder="<?php echo e($placeholder ?? ''); ?>">
                
                <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $selected = false;
                        if( !empty($selected_value) ){
                            if( is_array($selected_value) && in_array($key, $selected_value ) ){
                                $selected = true;    
                            }elseif( $selected_value == $key ){
                                $selected = true;     
                            }
                        }elseif( !empty($default) ){
                            if( is_array($default) && in_array($key, $default ) ){
                                $selected = true;    
                            }elseif( $default == $key ){
                                $selected = true;     
                            }
                        }
                    ?>
                    <option value="<?php echo e($key); ?>" <?php echo e($selected ? 'selected' : ''); ?>><?php echo e($single); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
            </select>
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
                    <div class="op-select"> 
                        <select <?php if(!empty($multi) && $multi): ?> multiple data-multi_items="true" <?php endif; ?> class="op-input-field form-control op-selectoption <?php echo e($class ?? ''); ?>" data-id="<?php echo e($id ?? ''); ?>" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> name="<?php echo e($name); ?>"   data-placeholder="<?php echo e($placeholder ?? ''); ?>">
                            
                            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $selected = false;
                                    if( !empty($selected_value) ){
                                        if( is_array($selected_value) && in_array($key, $selected_value ) ){
                                            $selected = true;    
                                        }elseif( $selected_value == $key ){
                                            $selected = true;     
                                        }
                                    }elseif( !empty($default) ){
                                        if( is_array($default) && in_array($key, $default ) ){
                                            $selected = true;    
                                        }elseif( $default == $key ){
                                            $selected = true;     
                                        }
                                    }
                                ?>
                                <option value="<?php echo e($key); ?>" <?php echo e($selected ? 'selected' : ''); ?>  ><?php echo e($single); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                        </select>
                    </div>
                <?php endif; ?>    
                <?php if( !empty($field_desc) ): ?><span><?php echo $field_desc; ?></span> <?php endif; ?>           
            </div>
        </div>
    </li>
<?php endif; ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/vendor/larabuild/optionbuilder/resources/views/components/select.blade.php ENDPATH**/ ?>