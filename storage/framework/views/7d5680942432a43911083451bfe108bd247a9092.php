<?php
    $name = '';
    if( !empty($repeater_id) ){
        if( !empty($parent_rep) ){
            $name = "$parent_rep".'['.$repeater_id.']['.$index.']['.$id.']';
        }else{
            $name = "$repeater_id".'['.$index.']['.$id.']';
        }
    }else{
        $name = !empty($id) ? $id : '';
    }
?>
<?php if( !empty($repeater_type) && $repeater_type == 'single' ): ?>
    <textarea data-id="<?php echo e($id ?? ''); ?>" <?php if(!empty($parent_rep)): ?> data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> class="op-input-field form-control <?php echo e($class ?? ''); ?>" name="<?php echo e($name); ?>"  placeholder="<?php echo e($placeholder ?? ''); ?>"><?php echo e($value ?? ''); ?></textarea>
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
        <div class="form-group-half">
            <div class="op-textcontent">
                <textarea data-id="<?php echo e($id ?? ''); ?>" <?php if(!empty($parent_rep)): ?>data-parent_rep="<?php echo e($parent_rep); ?>" <?php endif; ?> class="op-input-field form-control <?php echo e($class ?? ''); ?>" name="<?php echo e($name); ?>"  placeholder="<?php echo e($placeholder ?? ''); ?>"><?php echo e($value ?? ''); ?></textarea>
                <?php if( !empty($field_desc) ): ?><span><?php echo $field_desc; ?></span> <?php endif; ?>           
            </div>
        </div>
    </li>
<?php endif; ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/vendor/larabuild/optionbuilder/resources/views/components/textarea.blade.php ENDPATH**/ ?>