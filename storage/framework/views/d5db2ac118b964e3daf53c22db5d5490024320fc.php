<main class="tb-main tb-mainbg">
    <div class="row">
        <div class="col-xl-4">
            <div class="tb-dbholder tb-package-settings">
                <div class="tb-dbbox tb-dbboxtitle">
                    <h5> <?php echo e(__('settings.packege_option_settings')); ?></h5>
                </div>
                <div class="tb-dbbox tb-todobox">
                    <form class="tb-themeform tb-loginform">
                        <fieldset>
                            <div class="form-group-wrap">
                                <div class="form-group">
                                    <label class="tb-label"><?php echo e(__('settings.packege_option')); ?></label>
                                    <div class="tk-settingarea">
                                        <div wire:ignore class="tb-select">
                                            <select id="package_option" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.select_packege_option')); ?>" class="form-control tk-select2">
                                                <option label="<?php echo e(__('settings.select_packege_option')); ?>"></option>
                                                <?php $__currentLoopData = $package_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php echo e($settings['package_option'] == $key ? 'selected' : ''); ?> ><?php echo e($option); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="tb-label"><?php echo e(__('settings.single_project_credits')); ?></label>
                                    <div class="tb-increasevalue">
                                        <input type="number" class="form-control" wire:model.defer="settings.single_project_credits" required="" placeholder="<?php echo e(__('settings.sngl_proj_cred_placeholder')); ?>">
                                    </div>
                                </div>
                                <div class="form-group tb-dbtnarea">
                                    <a href="javascript:void(0);" wire:click.prevent="updateSetting" class="tb-btn">
                                        <?php echo e(__('settings.save_setting')); ?>

                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-dbholder tb-package-settings">
                <div class="tb-dbbox tb-dbboxtitle">
                    <h5><?php echo e($editMode ? __('settings.update_package') : __('settings.add_package')); ?></h5>
                </div>
                <div class="tb-dbbox tb-todobox">
                    <form class="tb-themeform tb-loginform">
                        <fieldset>
                            <div class="form-group-wrap">
                                <!-- for both -->
                                <div class="form-group tb-packagesfor">
                                    <h6><?php echo e(__('settings.package_for')); ?></h6>
                                    <ul class="tb-payoutmethod tb-packagestype">
                                        <li class="tb-radiobox">
                                            <input wire:model.lazy="package_for" type="radio" id="radio-buyer" <?php echo e($package_for == 'buyer' ? 'checked' : ''); ?> value="buyer">
                                            <div class="tb-radio">
                                                <label for="radio-buyer" class="tb-radiolist">
                                                    <span class="tb-wininginfo">
                                                       <i><?php echo e(__('settings.buyer')); ?></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </li>
                                        <li class="tb-radiobox">
                                            <input wire:model.lazy="package_for"  type="radio" id="radio-seller" <?php echo e($package_for == 'seller' ? 'checked' : ''); ?> value="seller">
                                            <div class="tb-radio">
                                                <label for="radio-seller" class="tb-radiolist">
                                                    <span class="tb-wininginfo">
                                                        <i><?php echo e(__('settings.seller')); ?></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                    <?php $__errorArgs = ['package_for'];
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
                                </div>
                                <div class="form-group">
                                    <label class="tb-label"><?php echo e(__('settings.package_name')); ?></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['package.title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="package.title" placeholder="<?php echo e(__('settings.package_name_placeholder')); ?>">
                                    <?php $__errorArgs = ['package.title'];
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
                                </div>
                                <!-- for both -->
                                <div class="form-group">
                                    <label class="tb-label"><?php echo e(__('settings.package_type')); ?></label>
                                    <div class="tk-settingarea <?php $__errorArgs = ['package.type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <div wire:ignore class="tb-select border-0">
                                            <?php echo e($package['type']); ?>

                                            <select id="package_type" data-hide_search_opt="true" data-placeholderinput="<?php echo e(__('settings.search')); ?>" data-placeholder="<?php echo e(__('settings.select_packege_option')); ?>" class="form-control tk-select2">
                                                <option label="<?php echo e(__('settings.select_packege_option')); ?>"></option>
                                                <?php $__currentLoopData = $package_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php echo e($package['type'] == $key ? 'selected' : ''); ?> ><?php echo e($type); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <?php $__errorArgs = ['package.type'];
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
                                    </div>
                                </div>
                                <!-- for both -->
                                <div class="form-group">
                                    <label class="tb-label tk-required"><?php echo e(__('settings.package_duration')); ?></label>
                                    <div class="tb-tippy-input">
                                        <input type="number" class="form-control <?php $__errorArgs = ['package.duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="package.duration" placeholder="<?php echo e(__('settings.package_duration_placeholder')); ?>">
                                        <em data-tippy-content="<?php echo e(__('settings.duration_info')); ?>" class="tippy"><i class="icon-alert-circle"></i></em>
                                        <?php $__errorArgs = ['package.duration'];
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
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="tb-label tk-required"><?php echo e(__('settings.package_price')); ?></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['package.price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="package.price" placeholder="<?php echo e(__('settings.price_placeholder')); ?>">
                                    <?php $__errorArgs = ['package.price'];
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
                                </div>
                                <!-- for buyer -->
                                <?php if( $package_for == 'buyer' ): ?>
                                    <div class="form-group">
                                        <label class="tb-label tk-required"><?php echo e(__('settings.posted_projects')); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['package.posted_projects'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="package.posted_projects" placeholder="<?php echo e(__('settings.posted_projects')); ?>">
                                        <?php $__errorArgs = ['package.posted_projects'];
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
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label tk-required"><?php echo e(__('settings.feature_project')); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['package.featured_projects'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="package.featured_projects" placeholder="<?php echo e(__('settings.feature_project')); ?>">
                                        <?php $__errorArgs = ['package.featured_projects'];
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
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label tk-required"><?php echo e(__('settings.feature_project_duration')); ?></label>
                                        <div class="tb-tippy-input">
                                            <input type="number" class="form-control <?php $__errorArgs = ['package.project_featured_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="package.project_featured_days" placeholder="<?php echo e(__('settings.feature_project_duration')); ?>">
                                            <em data-tippy-content="Duration should be in numbers of days" class="tippy"><i class="icon-alert-circle"></i></em>
                                            <?php $__errorArgs = ['package.project_featured_days'];
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
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if( $package_for == 'seller' ): ?>
                                    <div class="form-group">
                                        <label class="tb-label tk-required"><?php echo e(__('settings.credits')); ?></label>
                                        <input type="number" class="form-control <?php $__errorArgs = ['package.credits'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="package.credits" placeholder="<?php echo e(__('settings.credits_placeholder')); ?>">
                                        <?php $__errorArgs = ['package.credits'];
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
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label tk-required"><?php echo e(__('settings.profile_featured_days')); ?></label>
                                        <input type="number" class="form-control <?php $__errorArgs = ['package.profile_featured_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="package.profile_featured_days" placeholder="<?php echo e(__('settings.ftr_duration_placeholder')); ?>">
                                        <?php $__errorArgs = ['package.profile_featured_days'];
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
                                    </div>
                                <?php endif; ?>
                                <?php if($editMode): ?>
                                    <div class="form-group">
                                        <label class="tb-label"><?php echo e(__('general.status')); ?>:</label>
                                        <div class="tb-email-status">
                                            <span><?php echo e(__('settings.set_package_status')); ?></span>
                                            <div class="tb-switchbtn">
                                                <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes"><?php echo e($package['status'] == 'active' ? __('general.active') : __('general.deactive')); ?> </span></label>
                                                <input <?php echo e($package['status'] == 'active' ? 'checked' : ''); ?> class="tb-checkaction" type="checkbox" id="tb-emailstatus">
                                            </div>
                                        </div>
                                        <?php $__errorArgs = ['status'];
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
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label class="tb-label"><?php echo e(__('settings.upload_image')); ?></label>
                                    <div class="tb-uploadarea tb-uploadbartwo">
                                        <ul class="tb-uploadbar">
                                            <li wire:loading wire:target="package.image" style="display: none" class="tb-uploading">
                                                <span><?php echo e(__('settings.uploading')); ?></span>
                                            </li>
                                            <?php if(!empty($package['image']) && method_exists($package['image'],'temporaryUrl')): ?>
                                                <div wire:loading.remove class="tb-uploadel tb-upload-two">
                                                    <img src="<?php echo e(substr($package['image']->getMimeType(), 0, 5) == 'image' ? $package['image']->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($package['image']->getClientOriginalName()); ?>">
                                                    <span><?php echo e($package['image']->getClientOriginalName()); ?> <a href="javascript:void(0);" wire:click.prevent="removeImage"> <i class="ti-trash"></i></a> </span>
                                                </div>
                                            <?php elseif(!empty($old_image)): ?>
                                                <?php 
                                                    $image_path = $old_image['file_path'];
                                                    $image_name = $old_image['file_name'];
                                                ?>
                                                <div wire:loading.remove class="tb-uploadel tb-upload-two">
                                                    <img src="<?php echo e(asset('storage/'.$image_path)); ?>" alt="<?php echo e($image_name); ?>">
                                                    <span><?php echo e($image_name); ?><a href="javascript:void(0);" wire:click.prevent="removeImage"> <i class="ti-trash"></i></a></span>
                                                </div>
                                            <?php endif; ?>
                                        </ul>
                                        <span class="tb-upload-limit"><?php echo e(__('settings.image_option',['extension'=> join(',', $allow_image_ext), 'size'=> $allow_image_size.'MB'])); ?></span>
                                        <em>
                                            <label for="file2">
                                                <span>
                                                    <input id="file2" type="file" accept="<?php echo e(!empty($allow_image_ext) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allow_image_ext)) : '*'); ?>"  wire:model.lazy="package.image">
                                                    <?php echo e(__('settings.click_here_to_upload')); ?>

                                                </span>
                                            </label>
                                        </em>
                                        <?php $__errorArgs = ['package.image'];
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
                                    </div>
                                </div>
                                <div class="form-group tb-dbtnarea">
                                    <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn" ><?php echo e(__('settings.update_save_btn')); ?><span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="tb-dhb-mainheading">
                <h4><?php echo e(__('settings.package_heading')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="sortby" class="form-control">
                                            <option value="asc"> <?php echo e(__('general.asc')); ?></option>
                                            <option value="desc"><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="per_page" id="tb-selection1" class="form-control">
                                            <?php $__currentLoopData = $per_page_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>{
                                                <option value="<?php echo e($opt); ?>"><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="<?php echo e(__('settings.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-dbholder border-0 tb-todolist">
                <?php if(!empty($packages) && $packages->count() > 0): ?>
                <table class="table tb-table tb-dbholder tb-packages-table">
                    <thead>
                        <tr>
                            <th> <?php echo e(__('settings.name')); ?></th>
                            <th><?php echo e(__('settings.package_for')); ?></th>
                            <th><?php echo e(__('settings.price')); ?></th>
                            <th><?php echo e(__('general.status')); ?></th>
                            <th><?php echo e(__('general.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php   
                                $statusTag = getTag($single->status);
                            ?>
                            <tr>
                                <td data-label="<?php echo e(__('settings.name')); ?>">
                                    <span>
                                        <?php if(!empty($single->image)): ?>
                                            <?php  
                                                $image      = unserialize($single->image);
                                                $image_path = $image['file_path'];
                                                $image_name = $image['file_name'];
                                            ?>
                                            <img src="<?php echo e(asset('storage/'.$image_path)); ?>" alt="<?php echo e($image_name); ?>">
                                        <?php endif; ?>
                                        <?php echo e(ucfirst($single->title)); ?>

                                    </span>
                                </td>
                                <td data-label="<?php echo e(__('settings.package_for')); ?>"><span class="tb-table-data"><?php echo e(ucfirst(getRoleById($single->role_id))); ?></span></td>
                                <td data-label="<?php echo e(__('settings.price')); ?>"><span class="tb-table-data"><?php echo e(getPriceFormat($currency, $single->price)); ?></span></td>
                                <td data-label="<?php echo e(__('settings.status')); ?>">
                                    <em class="<?php echo e($statusTag['class']); ?>"><?php echo e($statusTag['text']); ?></em>
                                </td>
                                <td data-label="<?php echo e(__('settings.actions')); ?>">
                                    <ul class="tb-action-icon">
                                    <li> 
                                        <a href="javascript:void(0);" wire:click.prevent="edit(<?php echo e($single->id); ?>)">
                                            <i class="icon-edit-3"></i>
                                        </a> 
                                    </li>
                                    <li> <a href="javascript:void(0);">
                                        <span wire:click.prevent="previewPackage(<?php echo e($single->id); ?>)" data-bs-target="#viewpackages">
                                            <i class="icon-eye tb-blue"></i>
                                        </span>
                                    </a> 
                                </li>
                                </ul>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    </tbody>
                </table>
                <?php echo e($packages->links('pagination.custom')); ?>

                <?php else: ?>
                    <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>                                            
    <?php if(!empty($viewPackage)): ?>
        <div class="modal fade tb-taskdetailtitle" tabindex="-1" role="dialog" id="viewpackages-modal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="tb-modalcontent modal-content viewpackages">
                    <div class="tb-popuptitle">
                        <h4><?php echo e(__('settings.package_detail')); ?></h4>
                        <a href="javascript:void(0);" class="close"><i class="ti-close" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <div class="tb-viewpackages-content">
                            <div class="tb-view-imgarea">
                                <?php if(!empty($viewPackage['image'])): ?>
                                    <?php  
                                        $image      = unserialize($viewPackage['image']);
                                        $image_path = $image['file_path'];
                                        $image_name = $image['file_name'];
                                    ?>
                                    <img src="<?php echo e(asset('storage/'.$image_path)); ?>" alt="<?php echo e($image_name); ?>">
                                <?php endif; ?>
                                <div class="tb-img-description">
                                    <a href="javascript:void(0);" class="tk-project-tag tk-active"><?php echo e($viewPackage['status']); ?></a>
                                    <span><?php echo e($viewPackage['title']); ?></span>
                                </div>
                            </div>
                            <h4><?php echo e(getPriceFormat($currency, $viewPackage['price'])); ?></h4>
                        </div>
                        <ul class="tb-packege-list">
                            <li>
                                <div class="tb-view-pac-item">
                                    <span><?php echo e(__('settings.package_type')); ?></span>
                                    <h6><?php echo e($viewPackage['type'] == 'day' ? __('settings.package_type_daily') : ( $viewPackage['type'] == 'month' ? __('settings.package_type_monthly') : __('settings.package_type_yearly') )); ?></h6>
                                </div>
                            </li>
                            <li>
                                <div class="tb-view-pac-item">
                                    <span><?php echo e(__('settings.package_duration')); ?></span>
                                    <h6><?php echo e($viewPackage['duration']); ?></h6>
                                </div>
                            </li>
                            <?php if( $viewPackage['package_for'] == 'buyer'): ?>
                                <li>
                                    <div class="tb-view-pac-item">
                                        <span><?php echo e(__('settings.featured_project_durtation')); ?></span>
                                        <h6><?php echo e($viewPackage['project_featured_days'] > 1 ? __('settings.feature_days_lable',['days' => $viewPackage['project_featured_days']]): __('settings.feature_day_lable')); ?></h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="tb-view-pac-item">
                                        <span><?php echo e(__('settings.posted_projects')); ?></span>
                                        <h6><?php echo e($viewPackage['posted_projects']); ?></h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="tb-view-pac-item">
                                        <span><?php echo e(__('settings.feature_project')); ?></span>
                                        <h6><?php echo e($viewPackage['featured_projects']); ?></h6>
                                    </div>
                                </li>
                            <?php elseif($viewPackage['package_for'] == 'seller'): ?>
                                <li>
                                    <div class="tb-view-pac-item">
                                        <span><?php echo e(__('settings.credits')); ?></span>
                                        <h6><?php echo e($viewPackage['credits']); ?></h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="tb-view-pac-item">
                                        <span><?php echo e(__('settings.profile_featured_days')); ?></span>
                                        <h6><?php echo e($viewPackage['profile_featured_days']); ?></h6>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('livewire:load', function () {
        iniliazeSelect2Scrollbar();
        window.addEventListener('editPackage', event => {
            let package_type = event.detail.package_type;
            $('#package_type').select2().val(package_type).trigger("change");
        });
        
        $('#package_type').on('change', function (e) {
            let type = $('#package_type').select2("val");
            window.livewire.find('<?php echo e($_instance->id); ?>').set('package.type', type, true);
        });

        $('#package_option').on('change', function (e) {
            let option = $('#package_option').select2("val");
            window.livewire.find('<?php echo e($_instance->id); ?>').set('settings.package_option', option, true);
        });

        $(document).on('click', '.tb-checkaction', function(event){
            let _this   = $(this);
            let status  = '';
            if(_this.is(':checked')){
                _this.parent().find('#tb-textdes').html("<?php echo e(__('general.active')); ?>");
                status = 'active';
            } else {
                _this.parent().find('#tb-textdes').html( "<?php echo e(__('general.deactive')); ?>");
                status = 'deactive';
            }
            window.livewire.find('<?php echo e($_instance->id); ?>').set('package.status', status, true);
        });

        window.addEventListener('previewPackage', event => {
            var $target = $('#viewpackages-modal').modal(event.detail.modal);
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/packages/packages.blade.php ENDPATH**/ ?>