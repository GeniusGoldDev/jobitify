<main class="tb-main">
    <div class="row">
        <div class="col-md-12">
            <div class="tb-dbholder tb-dbholdervtwoa">
                <div class="tb-sectiontitle">
                    <h5> <?php echo e(__('settings.commission_settings')); ?></h5>
                </div>
        
                <div class="tb-dbsettingbox">
                    <form class="tb-comiisionform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-commisionarea">
                                    <span class="tb-titleinput"><?php echo e(__('settings.project_commission_free')); ?></span>
                                    <div class="tb-radiotabwrap">
                                        <div class="tb-radiowrap">
                                            <label for="free">
                                                <input type="radio" wire:model.lazy="commission_type" id="free" value="free" <?php echo e($commission_type == 'free' ? 'checked' : ''); ?>/>
                                                <span><?php echo e(__('settings.no_commission')); ?></span>
                                            </label>
                                        </div>
                                        <div class="tb-radiowrap">
                                            <label for="fixed">
                                                <input type="radio" wire:model.lazy="commission_type" id="fixed" value="fixed" <?php echo e($commission_type == 'fixed' ? 'checked' : ''); ?> />
                                                <span><?php echo e(__('settings.fixed_commission')); ?></span>
                                            </label>
                                        </div>
                                        <div class="tb-radiowrap">
                                            <label for="percentage">
                                                <input type="radio" wire:model.lazy="commission_type" id="percentage" value="percentage" <?php echo e($commission_type == 'percentage' ? 'checked' : ''); ?> />
                                                <span><?php echo e(__('settings.percentage_commission')); ?></span>
                                            </label>
                                        </div>
                                        <div class="tb-radiowrap">
                                            <label for="commission_tier">
                                                <input type="radio" wire:model.lazy="commission_type" id="commission_tier" value="commission_tier" <?php echo e($commission_type == 'commission_tier' ? 'checked' : ''); ?>/>
                                                <span><?php echo e(__('settings.commission_tiers')); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                    <div class="tb-nocommision <?php if( $commission_type == 'free' ): ?> d-flex <?php else: ?> d-none <?php endif; ?>">
                                        <img src="<?php echo e(asset('images/empty.png')); ?>" alt="">
                                        <span><?php echo e(__('settings.no_commission_desc')); ?></span>
                                    </div>
                               
                                    <div class="tb-commision <?php if( in_array( $commission_type, ['fixed', 'percentage']) ): ?> d-block <?php else: ?> d-none <?php endif; ?>">
                                        <div class="tb-formcomision">
                                            <div class="form-group form-vertical">
                                                <label class="tb-titleinput tk-required"><?php echo e(__('settings.fixed_commission_price')); ?></label>
                                                <?php if( $commission_type == 'fixed' ): ?>
                                                    <input type="number" wire:model.defer="fix_fixed_price" class="form-control <?php $__errorArgs = ['fix_fixed_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('settings.fixed_price_placeholder')); ?>">
                                                    <?php $__errorArgs = ['fix_fixed_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                                        <div class="tk-errormsg">
                                                            <span><?php echo e($message); ?></span> 
                                                        </div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                <?php else: ?> 
                                                    <div class="form-group form-vertical tb-inputiconleft">
                                                        <input type="number" wire:model.defer="per_fixed_price" class="form-control <?php $__errorArgs = ['per_fixed_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('settings.percentage_amount_placeholder')); ?>">
                                                        <i class="icon-percent"></i>
                                                    </div>
                                                    <?php $__errorArgs = ['per_fixed_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                                        <div class="tk-errormsg">
                                                            <span><?php echo e($message); ?></span> 
                                                        </div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                <?php endif; ?>
                                                <span><?php echo e(__('settings.fixed_price_desc')); ?></span> 
                                            </div>
                                            <div class="form-group form-vertical">
                                                <label class="tb-titleinput tk-required"><?php echo e(__('settings.hourly_commission_price')); ?></label>
                                                    <?php if( $commission_type == 'fixed' ): ?>
                                                        <input type="number" wire:model.defer="fix_hourly_price" class="form-control <?php $__errorArgs = ['fix_hourly_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('settings.hourly_price_placeholder')); ?>">
                                                        <?php $__errorArgs = ['fix_hourly_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                                            <div class="tk-errormsg">
                                                                <span><?php echo e($message); ?></span> 
                                                            </div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    <?php else: ?> 
                                                        <div class="form-group form-vertical tb-inputiconleft">
                                                            <input type="number" wire:model.defer="per_hourly_price" class="form-control <?php $__errorArgs = ['per_hourly_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('settings.percentage_amount_placeholder')); ?>">
                                                            <i class="icon-percent"></i>
                                                        </div>
                                                        <?php $__errorArgs = ['per_hourly_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                                            <div class="tk-errormsg">
                                                                <span><?php echo e($message); ?></span> 
                                                            </div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    <?php endif; ?>
                                                    <span><?php echo e(__('settings.hourly_price_desc')); ?></span> 
                                            </div>
                                        </div>
                                    </div>
                                
                               
                                    <div class="tb-addmore <?php if( $commission_type == 'commission_tier' ): ?> d-flex <?php else: ?> d-none <?php endif; ?>">
                                        <div class="tb-dbholder tb-dbholderbg">
                                            <div class="tb-sectiontitle">
                                                <h6> <?php echo e(__('settings.fixed_commission_price')); ?></h6>
                                            </div>
                                            <div class="tb-dbsetcommision">
                                                <?php if( !empty($commission_tiers['fixed']) ): ?>
                                                    <?php $__currentLoopData = $commission_tiers['fixed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier_key => $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div id="<?php echo e('fix_tier_'.$tier_key); ?>" class="tb-selectrange">
                                                            <div class="tb-selecttype">
                                                                <h6><?php echo e(__('settings.project_price_range')); ?></h6>
                                                                <div class="<?php $__errorArgs = ['commission_tiers.fixed.'.$tier_key.'.price_range'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                    <div class="tb-select" wire:ignore>
                                                                        <select id="<?php echo e('fix_price_range_'.$tier_key); ?>" data-type="fixed" data-record_no="<?php echo e($tier_key); ?>" data-key="price_range" class="<?php echo e('tk-select2-'.$tier_key); ?> form-control" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.price_range_placeholder')); ?>" >
                                                                            <option label="<?php echo e(__('settings.price_range_placeholder')); ?>"></option>
                                                                            <?php $__currentLoopData = $fix_comm_range; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($key); ?>" <?php if($key == $commission_tiers['fixed'][$tier_key]['price_range']): ?> selected <?php endif; ?> ><?php echo e($value); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tb-selecttype">
                                                                <h6><?php echo e(__('settings.commission_type')); ?></h6>
                                                                <div class="<?php $__errorArgs = ['commission_tiers.fixed.'.$tier_key.'.type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                    <div wire:ignore class="tb-select">
                                                                        <select id="<?php echo e('fix_commission_type_'.$tier_key); ?>" data-type="fixed" data-record_no="<?php echo e($tier_key); ?>" data-key="type" class="<?php echo e('tk-select2-'.$tier_key); ?> form-control" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.price_range_placeholder')); ?>" >
                                                                            <option label="<?php echo e(__('settings.comm_type_placeholder')); ?>"></option>
                                                                            <?php $__currentLoopData = $comm_type_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type_key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($type_key); ?>" <?php if( $type_key == $commission_tiers['fixed'][$tier_key]['type']): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tb-selecttype">
                                                                <h6><?php echo e(__('settings.project_commission')); ?></h6>
                                                                <div class="form-group">
                                                                    <input type="number" wire:model.defer="commission_tiers.fixed.<?php echo e($tier_key); ?>.value" class="form-control <?php $__errorArgs = ['commission_tiers.fixed.'.$tier_key.'.value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('settings.comm_placeholder')); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="tb-removeiron">
                                                                <a href="javascript:void(0);" wire:click.prevent="removeCommission('fixed',<?php echo e($tier_key); ?>)"><i class="icon-trash-2"></i></a>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="tb-addmorecom">
                                                        <img src="<?php echo e(asset('images/empty.png')); ?>" alt="">
                                                        <span><?php echo __('settings.add_more_desc'); ?></span> 
                                                    </div>
                                                <?php endif; ?>
                                                <div class="tb-addmoreclick">
                                                    <a href="javascript:void(0);" wire:click.prevent="addMoreCommission('fixed')"><?php echo e(__('settings.add_more')); ?> <span class="icon-plus"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tb-dbholder tb-dbholderbg">
                                            <div class="tb-sectiontitle">
                                                <h6> <?php echo e(__('settings.hourly_commission_price')); ?> </h6>
                                            </div>
                                            <div class="tb-dbsetcommision">
                                                <?php if( !empty($commission_tiers['hourly']) ): ?>
                                                    <?php $__currentLoopData = $commission_tiers['hourly']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hr_tier_key => $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div id="<?php echo e('hr_tier_'.$hr_tier_key); ?>" class="tb-selectrange">
                                                            <div class="tb-selecttype">
                                                                <h6><?php echo e(__('settings.project_price_range')); ?></h6>
                                                                <div class="<?php $__errorArgs = ['commission_tiers.hourly.'.$hr_tier_key.'.price_range'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                    <div class="tb-select" wire:ignore >
                                                                        <select id="<?php echo e('hr_price_range_'.$hr_tier_key); ?>" data-type="hourly" data-record_no="<?php echo e($hr_tier_key); ?>" data-key="price_range" class="<?php echo e('tk-select2-'.$hr_tier_key); ?> form-control <?php $__errorArgs = ['package.type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.price_range_placeholder')); ?>" >
                                                                            <option label="<?php echo e(__('settings.price_range_placeholder')); ?>"></option>
                                                                            <?php $__currentLoopData = $hr_comm_range; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range_key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($range_key); ?>" <?php if($range_key == $commission_tiers['hourly'][$hr_tier_key]['price_range']): ?> selected <?php endif; ?> ><?php echo e($value); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tb-selecttype">
                                                                <h6><?php echo e(__('settings.commission_type')); ?></h6>
                                                                <div class="<?php $__errorArgs = ['commission_tiers.hourly.'.$hr_tier_key.'.type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                    <div wire:ignore class="tb-select" >
                                                                        <select id="<?php echo e('hr_commission_type_'.$hr_tier_key); ?>" data-type="hourly" data-record_no="<?php echo e($hr_tier_key); ?>" data-key="type" class="<?php echo e('tk-select2-'.$hr_tier_key); ?> form-control" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.price_range_placeholder')); ?>" >
                                                                            <option label="<?php echo e(__('settings.comm_type_placeholder')); ?>"></option>
                                                                            <?php $__currentLoopData = $comm_type_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type_key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($type_key); ?>" <?php if( $type_key == $commission_tiers['hourly'][$hr_tier_key]['type']): ?> selected <?php endif; ?>><?php echo e($option); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tb-selecttype">
                                                                <h6><?php echo e(__('settings.project_commission')); ?></h6>
                                                                <div class="form-group">
                                                                    <input type="number" wire:model.defer="commission_tiers.hourly.<?php echo e($hr_tier_key); ?>.value" class="form-control <?php $__errorArgs = ['commission_tiers.hourly.'.$hr_tier_key.'.value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('settings.comm_placeholder')); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="tb-removeiron">
                                                                <a href="javascript:void(0);" wire:click.prevent="removeCommission('hourly',<?php echo e($hr_tier_key); ?>)"><i class="icon-trash-2"></i></a>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="tb-addmorecom">
                                                        <img src="<?php echo e(asset('images/empty.png')); ?>" alt="">
                                                        <span><?php echo __('settings.add_more_desc'); ?></span> 
                                                    </div>
                                                <?php endif; ?>
                                                <div class="tb-addmoreclick">
                                                    <a href="javascript:void(0);" wire:click.prevent="addMoreCommission('hourly')"> <?php echo e(__('settings.add_more')); ?> <span class="icon-plus"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               
        
                                <div class="form-group tb-dbtnarea">
                                    <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                        <?php echo e(__('settings.save_setting')); ?>

                                    </a>
                                </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:load', function () {
            setTimeout(() => {
                jQuery("select[class^='tk-select2-']").each(function(index, item) {
                    let _this       = jQuery(this);
                    let type        = _this.data('type');
                    let selectId    = _this.attr('id');
                    let recordNo    = _this.data('record_no');
                    let key         = _this.data('key');

                    _this.select2( { 
                        minimumResultsForSearch: -1,
                        allowClear: true 
                    });
                    setValue( selectId, type, recordNo, key)
                });
                iniliazeSelect2Scrollbar();
            },500);

            window.addEventListener('addTier', event => {
                setTimeout(() => {
                    let recNo = Number(event.detail.record_no);
                    let price_range     = event.detail.type == 'fixed' ? 'fix_price_range_'+recNo : 'hr_price_range_'+recNo;  
                    let commission_type = event.detail.type == 'fixed' ? 'fix_commission_type_'+recNo : 'hr_commission_type_'+recNo;  
                    let recType         = event.detail.type;
                    
                    jQuery('.tk-select2-'+recNo).select2({ 
                        allowClear: true,
                        minimumResultsForSearch: -1
                    });
                    
                    setValue( price_range, recType, recNo, 'price_range')
                    setValue( commission_type, recType, recNo, 'type');

                    iniliazeSelect2Scrollbar();
                },500);
            });

            function setValue( selectId, type, recordNo, key){
                $('#'+selectId).on('change', function (e) {
                    let value = $('#'+selectId).select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('commission_tiers.'+type.toString() +'.'+ recordNo.toString() +'.'+key.toString(), value, true);
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/settings/commission-settigns.blade.php ENDPATH**/ ?>