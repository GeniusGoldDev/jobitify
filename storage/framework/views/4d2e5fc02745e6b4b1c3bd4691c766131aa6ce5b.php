<main class="tb-main">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('general.all_users') .' ('. $users->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:void(0)" id="add_user_click" class="tb-btn add-new" data-bs-toggle="modal" data-bs-target="#tb-add-user"><?php echo e(__('general.add_new_user')); ?> <i class="icon-plus"></i></a>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_user" class="form-control tk-selectprice">
                                            <option value =""> <?php echo e(__('general.all_users')); ?> </option>
                                            <option value ="verified"> <?php echo e(__('general.verified')); ?> </option>
                                            <option value ="non-verified"> <?php echo e(__('general.non-verified')); ?> </option>
                                        </select>
                                    </div>
                                </div>  
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="sortby" class="form-control">
                                            <option value="asc"><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc"><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="per_page" class="form-control">
                                            <?php $__currentLoopData = $per_page_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>{
                                                <option value="<?php echo e($opt); ?>"><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_user"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                <?php if( !$users->isEmpty() ): ?>
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#' )); ?></th>
                                <th><?php echo e(__('general.email' )); ?></th>
                                <th><?php echo e(__('general.created_date' )); ?></th>
                                <th><?php echo e(__('general.hourly_rate' )); ?></th>
                                <th><?php echo e(__('general.verification' )); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php

                                $tag = getTag( $single->status );
                                ?>
                                <tr> 
                                    <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($single->id); ?></span></td>
                                    <td data-label="<?php echo e(__('general.email' )); ?>"><span><?php echo e($single->email); ?></span></td>
                                    <td data-label="<?php echo e(__('general.created_date' )); ?>"><span><?php echo e(date($date_format, strtotime( $single->created_at ))); ?></span></td>
                                    <td data-label="<?php echo e(__('general.hourly_rate' )); ?>"><span><?php echo e(getPriceFormat($currency_symbol, (empty($single->userAccountSetting->hourly_rate) ? 0 : $single->userAccountSetting->hourly_rate)) .'/hr'); ?></span></td>
                                    <td data-label="<?php echo e(__('general.verification' )); ?>">
                                        <a href="javascript:;" class="tb-email-verifiedbtn"  <?php echo e(empty($single->email_verified_at) ? "onClick=confirmation('".$single->id."','approve') disabled=true" : "onClick=confirmation('".$single->id."','reject')"); ?>><i class="icon-mail"></i><?php echo e(strtoupper(__('general.verified'))); ?></a>
                                        <?php if(!empty($single->userIdentity)): ?><a href="javascript:void(0)" wire:click.prevent="identityInfo(<?php echo e($single->id); ?>)" class="tb-verifiedbtn" <?php echo e($single->userAccountSetting->verification != 'approved'  ? 'disabled=true' : ''); ?>><i class="icon-award"></i><?php echo e(strtoupper( __('general.verified'))); ?></a><?php endif; ?>
                                    </td>
                                    <td data-label="<?php echo e(__('general.status')); ?>">

                                        <em class="tk-project-tag tk-<?php echo e($single->status == 'activated' ? 'active' : 'disabled'); ?>"><?php echo e($single->status); ?></em>
                                    </td>
                                    <td data-label="<?php echo e(__('general.actions')); ?>" class="tb-action-profile">
                                        
                                        <ul class="tb-action-status">
                                            <li> 
                                                <a href="javascript:void(0);" onClick="deleteUser(<?php echo e($single->id); ?>)" class="tb-delete" ><i class="icon-trash-2"></i></a>
                                            </li> 
                                            <?php if( $single->profile->count() > 1 ): ?>
                                                <?php $__currentLoopData = $single->profile; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($profile->role->name == 'seller'): ?>
                                                    <li><a href="<?php echo e(route('seller-profile', ['slug' => $profile->slug])); ?>" target="_blank"><?php echo e(ucfirst(__('general.view_profile', ['role' => $profile->role->name]))); ?><i class="icon-external-link"></i></a></li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <?php if($single->profile[0]->role->name == 'seller'): ?>
                                                    <li><a href="<?php echo e(route('seller-profile', ['slug' => $single->profile[0]->slug])); ?>" target="_blank"><?php echo e(ucfirst(__('general.view_profile', ['role' => $single->profile[0]->role->name]))); ?><i class="icon-external-link"></i></a></li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
                    </table>
                        <?php echo e($users->links('pagination.custom')); ?>  
                    <?php else: ?>
                        <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>  
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade tb-addonpopup" id="identity-info-modal"  tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h4> <?php echo e(__('general.user_identity_info')); ?> </h4>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <?php if( !empty($user_identity_info) ): ?>
                            <?php if(!$reject_user_identity): ?>
                                <ul class="tb-userinfo">
                                    <li>
                                        <span><?php echo e(__('general.name')); ?>:</span>
                                        <h6><?php echo e($user_identity_info['name']); ?></h6>
                                    </li>
                                    <li>
                                        <span><?php echo e(__('general.contact_no')); ?>:</span>
                                        <h6><?php echo e($user_identity_info['contact_no']); ?></h6>
                                    </li>
                                    <li>
                                        <span><?php echo e(__('general.identity_no')); ?>:</span>
                                        <h6><?php echo e($user_identity_info['identity_no']); ?></h6>
                                    </li>
                                    <li>
                                        <span><?php echo e(__('general.address')); ?>:</span>
                                        <h6><?php echo $user_identity_info['address']; ?></h6>
                                    </li>
                                    <?php if( !empty($user_identity_info['attachments']) ): ?>
                                        <li>
                                            <span><?php echo e(__('general.identity_attachments')); ?>:</span>
                                            <h6><a href="javascript:;" wire:click.prevent="downloadAttachments(<?php echo e($user_identity_info['id']); ?>)"><?php echo e(__('general.download')); ?></a></h6>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                        
                                <div class="tb-userverfication-btns">
                                    <?php if($user_identity_info['verification'] != 'approved'): ?>
                                        <a href="javascript:;" wire:loading.class="tk-pointer-events-none" wire:click.prevent="verifyUserIdentity(<?php echo e($user_identity_info['id']); ?>, 'approve')" class="tb-btn">
                                            <span wire:loading wire:target="verifyUserIdentity"> <?php echo e(__('general.waiting')); ?> </span>
                                            <span wire:loading.remove wire:target="verifyUserIdentity"><?php echo e(__('general.approve')); ?> </span>
                                        </a>
                                    <?php endif; ?>
                                    <a href="javascript:;" wire:click.prevent="verifyUserIdentity(<?php echo e($user_identity_info['id']); ?>, 'reject')" class="tb-rejectbtn"><?php echo e(__('general.reject')); ?></a>
                                </div>                     
                            <?php else: ?>
                                <textarea wire:model.defer="identity_reject_reason" placeholder="<?php echo e(__('general.decline_reason')); ?>" class="form-control  <?php $__errorArgs = ['identity_reject_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
                                <?php $__errorArgs = ['identity_reject_reason'];
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
                                <div class="tb-userverfication-btns">
                                    <a href="javascript:;" wire:loading.class="tk-pointer-events-none" wire:click.prevent="verifyUserIdentity(<?php echo e($user_identity_info['id']); ?>, 'reject')" class="tb-btn">
                                        <span wire:loading wire:target="verifyUserIdentity"> <?php echo e(__('general.waiting')); ?> </span>
                                        <span wire:loading.remove wire:target="verifyUserIdentity"><?php echo e(__('general.reject')); ?> </span>
                                    </a>
                                    <a href="javascript:;" wire:loading.class="tk-pointer-events-none" wire:click.prevent="updateUserIdentity" class="tb-rejectbtn">
                                        <span wire:loading wire:target="updateUserIdentity"> <?php echo e(__('general.waiting')); ?> </span>
                                        <span wire:loading.remove wire:target="updateUserIdentity"><?php echo e(__('general.cancel')); ?> </span>
                                    </a>
                                </div> 
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade tb-addonpopup" id="tb-add-user" aria-labelledby="tb_user_info_label" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg tb-modaldialog" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h5 id="tb_user_info_label"><?php echo e(__('general.user_information')); ?></h5>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <form class="tb-themeform" id="add_user_form">
                            <fieldset>
                                <div class="form-group-wrap">
                                    <div class="form-group">
                                        <label class="tb-label"><?php echo e(__('general.first_name')); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="first_name" placeholder="<?php echo e(__('general.name_placeholder')); ?>">
                                        <?php $__errorArgs = ['first_name'];
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
                                        <label class="tb-label"><?php echo e(__('general.last_name')); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="last_name" placeholder="<?php echo e(__('general.lastname_placeholder')); ?>">
                                        <?php $__errorArgs = ['last_name'];
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
                                        <label class="tb-label"><?php echo e(__('general.email')); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="email" placeholder="<?php echo e(__('general.email_placeholder')); ?>">
                                        <?php $__errorArgs = ['email'];
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
                                        <label class="tb-label"><?php echo e(__('general.user_role')); ?></label>
                                        <div class="tk-error <?php $__errorArgs = ['user_role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <div class="tb-select" wire:ignore>
                                                <select id="select_role" class="form-control" data-placeholder="<?php echo e(__('general.user_role')); ?>" data-placeholderinput="<?php echo e(__('general.search')); ?>">
                                                <option label="<?php echo e(__('general.user_role')); ?>"></option>
                                                    <option value="buyer"><?php echo e(__('general.buyer_option')); ?></option>
                                                    <option value="seller"><?php echo e(__('general.seller_option')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php $__errorArgs = ['user_role'];
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
                                        <label class="tb-label"><?php echo e(__('general.password')); ?></label>
                                        <input type="password" wire:model.defer="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="<?php echo e(__('general.password_placeholder')); ?>">
                                        <?php $__errorArgs = ['password'];
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
                                        <label class="tb-label"><?php echo e(__('general.confirm_password')); ?></label>
                                        <input type="password" wire:model.defer="confirm_password" class="form-control <?php $__errorArgs = ['confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('general.password_placeholder')); ?>">
                                        <?php $__errorArgs = ['confirm_password'];
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
                                    <div class="form-group tb-formbtn">
                                        <a href="javascript:void(0)" wire:click.prevent="saveUser" class="tb-btn"><?php echo e(__('general.save_user')); ?></a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
<script>
    document.addEventListener('livewire:load', function () {
        setTimeout(function() {
            $('#filter_user').select2({ 
                allowClear: true, 
                minimumResultsForSearch: Infinity
            });

            $('#select_role').select2({
                dropdownParent: $("#tb-add-user"),
                allowClear: true, 
                minimumResultsForSearch: Infinity,
            });

            $('#select_role').on('change', function (e) {
                let user_role = $('#select_role').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('user_role', user_role, true);
            });

            $('#filter_user').on('change', function (e) {
                let filter_user = $('#filter_user').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_user', filter_user);
            });
        }, 50);

        $(document).on('click','#add_user_click', function (e) {
            document.getElementById("add_user_form").reset();
        });

        window.addEventListener('add-new-user-modal', event => {
            if(event.detail.modal == 'show'){
                $('#tb-add-user').modal().show()
            } else {
                $('#tb-add-user').modal('hide')
            }
        });

        window.addEventListener('indentity-info-modal', event => {
            $('#identity-info-modal').modal(event.detail.modal);
        });

    });

    function confirmation(id, status ){
        if(status == 'approve'){
            let title           = '<?php echo e(__("general.approve_email_acc")); ?>';
            let content         = '<?php echo e(__("general.approve_email_acc_desc")); ?>';
            let action          = 'emailVerifyConfirm';
            let status          = 'approve';
            let type_color      = 'green';
            let btn_class      = 'success';
            ConfirmationBox({title, content, action, id, status, type_color, btn_class})
        }else if(status == 'reject'){
            let title           = '<?php echo e(__("general.reject_email_acc")); ?>';
            let content         = '<?php echo e(__("general.reject_email_acc_desc")); ?>';
            let action          = 'emailVerifyConfirm';
            let status          = 'reject';
            let type_color      = 'red';
            let btn_class      = 'red';
            ConfirmationBox({title, content, action, id, status, type_color, btn_class})
        }
    }

    function deleteUser( id ){
        
        let title           = '<?php echo e(__("general.confirm")); ?>';
        let content         = '<?php echo e(__("general.delete_user")); ?>';
        let action          = 'deleteUser';
        let type_color      = 'red';
        let btn_class      = 'danger';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }

</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/users/users.blade.php ENDPATH**/ ?>