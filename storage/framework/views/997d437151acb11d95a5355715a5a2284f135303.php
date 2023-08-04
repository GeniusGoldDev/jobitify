<div wire:ignore.self class="tab-pane fade" id="style-setting">
    <?php if( empty($block_id) ): ?>
        <div class="at-empty-block-settings">
        <span><?php echo e(__('pages.no_block_style_settings')); ?></span>
        </div>
    <?php else: ?>
        <div class="at-pagebuilder-navs">
            <form id="at-style-form">
                <div class="at-template-sections">
                    <div  wire:ignore.self class="at-components-holder" data-bs-toggle="collapse" data-bs-target="#postion-setting" aria-expanded="true">
                        <strong><?php echo e(__('pages.position_settings')); ?></strong> 
                    </div>
                    <div wire:ignore.self id="postion-setting" class="collapse show">
                        <div class="at-components-content">
                            <ul class="at-style-component">
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.width')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($position['width']); ?>" class="form-control" name="position[width]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.height')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($position['height']); ?>" class="form-control" name="position[height]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.min_width')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($position['min_width']); ?>" class="form-control" name="position[min_width]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.min_height')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($position['min_height']); ?>" class="form-control" name="position[min_height]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.max_width')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($position['max_width']); ?>" class="form-control" name="position[max_width]" placeholder="<?php echo e(__('pages.enter_value')); ?>">
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.max_height')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($position['max_height']); ?>" class="form-control" name="position[max_height]" placeholder="<?php echo e(__('pages.enter_value')); ?>">
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="at-template-sections">
                    <div  wire:ignore.self class="at-components-holder" data-bs-toggle="collapse" data-bs-target="#padding-setting" aria-expanded="true">
                        <strong><?php echo e(__('pages.padding_settings')); ?></strong> 
                    </div>
                    <div wire:ignore.self id="padding-setting" class="collapse show">
                        <div class="at-components-content">
                            <ul class="at-style-component">
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.padding_top')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($padding['top']); ?>" class="form-control" name="padding[top]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.padding_right')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($padding['right']); ?>" class="form-control" name="padding[right]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.padding_bottom')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($padding['bottom']); ?>" class="form-control" name="padding[bottom]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.padding_left')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($padding['left']); ?>" class="form-control" name="padding[left]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="at-template-sections">
                    <div  wire:ignore.self class="at-components-holder" data-bs-toggle="collapse" data-bs-target="#margin-setting" aria-expanded="false">
                        <strong><?php echo e(__('pages.margin_settings')); ?></strong> 
                    </div>
                    <div wire:ignore id="margin-setting" class="collapse">
                        <div class="at-components-content">
                            <ul class="at-style-component">
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.margin_top')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($margin['top']); ?>" class="form-control" name="margin[top]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.margin_right')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($margin['right']); ?>" class="form-control" name="margin[right]" placeholder="<?php echo e(__('pages.enter_value')); ?>"  >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.margin_bottom')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($margin['bottom']); ?>" class="form-control" name="margin[bottom]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                                <li>
                                    <label class="at-label"><?php echo e(__('pages.margin_left')); ?></label>
                                    <div class="at-inputicon">
                                        <input type="number" value="<?php echo e($margin['left']); ?>" class="form-control" name="margin[left]" placeholder="<?php echo e(__('pages.enter_value')); ?>" >
                                        <i><span class="at-pixel"><?php echo e(__('pages.px')); ?></span></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="at-template-sections">
                    <div wire:ignore.self class="at-components-holder" data-bs-toggle="collapse" data-bs-target="#text-align" aria-expanded="false">
                        <strong><?php echo e(__('pages.advance_settings')); ?></strong> 
                    </div>
                    <div wire:ignore.self id="text-align" class="collapse">
                        <div class="at-components-content">
                            <label class="at-label"><?php echo e(__('pages.text_alignment')); ?></label>
                            <input type="hidden" id="at_text_align_input" data-block_key="<?php echo e($block_key); ?>" name="text_align" value="" />
                            <ul class="at-aligntext-style">
                                <li class="<?php echo e($text_align == 'left' ? 'active' : ''); ?>" data-value="left">
                                    <label for="at-aligin-left"><i class="icon-align-left"></i></label>
                                </li>
                                <li class="<?php echo e($text_align == 'right' ? 'active' : ''); ?>" data-value="right">
                                    <label for="at-aligin-right"><i class="icon-align-right"></i></label>
                                </li>
                                <li class="<?php echo e($text_align == 'center' ? 'active' : ''); ?>" data-value="center">
                                    <label for="at-aligin-center"><i class="icon-align-center"></i></label>
                                </li>
                                <li class="<?php echo e($text_align == 'justify' ? 'active' : ''); ?>" data-value="justify">
                                    <label for="at-justify-center"><i class="icon-align-justify"></i></label>
                                </li>
                            </ul>
                        </div>
                        <div class="at-components-content">
                            <label class="at-label"><?php echo e(__('pages.custom_class')); ?></label>
                            <input class="w-100" type="text" id="at_custom_class" data-block_key="<?php echo e($block_key); ?>" name="custom_class" value="<?php echo e($custom_class); ?>" />
                            <p><?php echo e(__('pages.custom_class_desc')); ?></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:load', function () {
            document.addEventListener('updateStyleClass', event => {
                let _class = event.detail.class;
                let _style = event.detail.style;
                if($(document).find('.'+ _class + ' style').length){
                    $(document).find('.'+ _class + ' style').html(_style);
                } else {
                    $(document).find('.'+ _class).append(`<style>${_style}</style>`);
                }
            });

            $(document).on('click', 'ul.at-aligntext-style li', function(e){
                let _this = $(this);
                let value       = _this.data('value');
                let isActive    = _this.hasClass('active');
                let input       = $('#at_text_align_input');
                $('ul.at-aligntext-style li').removeClass('active');

                if(isActive){
                    input.val('')
                    _this.removeClass('active');
                } else {
                    _this.addClass('active');
                    input.val(value) 
                }
                input.change();
            });
        });
    </script>
<?php $__env->stopPush(); ?>
   <?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/block-style-setting.blade.php ENDPATH**/ ?>