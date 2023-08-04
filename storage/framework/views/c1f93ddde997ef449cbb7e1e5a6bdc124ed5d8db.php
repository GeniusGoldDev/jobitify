<main class="tb-main" wire:key="<?php echo e(time()); ?>">    
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('general.all_requests') .' ('. $requests->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_request" class="form-control tk-selectprice">
                                            <option value =""> <?php echo e(__('general.all')); ?> </option>
                                            <option value ="pending"> <?php echo e(__('general.pending')); ?> </option>
                                            <option value ="processed"> <?php echo e(__('general.processed_payment')); ?> </option>
                                            <option value ="complete"> <?php echo e(__('general.completed')); ?> </option>
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_request"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                <?php if( !$requests->isEmpty() ): ?>
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#' )); ?></th>
                                <th><?php echo e(__( 'general.name' )); ?></th>
                                <th><?php echo e(__('general.date' )); ?></th>
                                <th><?php echo e(__('general.withdraw_amount' )); ?></th>
                                <th><?php echo e(__('general.payout_type' )); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.account_detail' )); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $tag = getTag( $single->status );
                                ?>
                                <tr> 
                                    <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($single->id); ?></span></td>
                                    <td data-label="<?php echo e(__( 'general.name' )); ?>"><span><?php echo $single->User->full_name; ?></span></td>
                                    <td data-label="<?php echo e(__('general.date' )); ?>"><span><?php echo e(date($date_format, strtotime( $single->created_at ))); ?></span></td>
                                    <td data-label="<?php echo e(__('general.withdraw_amount' )); ?>"><span><?php echo e(getPriceFormat($currency_symbol, $single->amount)); ?></span></td>
                                    <td data-label="<?php echo e(__('general.payout_type' )); ?>">
                                        <?php if($single->payment_method == 'escrow'): ?>
                                            <span><?php echo e(__('billing_info.escrow')); ?></span>
                                        <?php elseif($single->payment_method == 'paypal'): ?>
                                            <span><?php echo e(__('billing_info.paypal')); ?></span>
                                        <?php elseif($single->payment_method == 'payoneer'): ?>
                                            <span><?php echo e(__('billing_info.payoneer_heading')); ?></span>
                                        <?php elseif($single->payment_method == 'bank'): ?>
                                            <span><?php echo e(__('billing_info.bank')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="<?php echo e(__('general.status')); ?>">
                                        <em class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></em>
                                    </td>
                                    <td data-label="<?php echo e(__('general.account_detail' )); ?>">
                                        <ul class="tb-action-status">
                                            <li>
                                                <?php if( $single->status == 'pending' ): ?>
                                                <span>
                                                    <a href="javascript:;" onClick="confirmation(<?php echo e($single->id); ?>)"  ><i class="fas fa-check"></i><?php echo e(__('project.approve')); ?></a>
                                                </span>
                                                <?php else: ?>
                                                    <span class="tb-approved"><i class="fas fa-check"></i><?php echo e(__('project.approved')); ?></span>     
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <a href="javascript:;" wire:click.prevent="accountInfo(<?php echo e($single->id); ?>)" target="_blank" ><i class="icon-eye"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
                    </table>
                    <?php echo e($requests->links('pagination.custom')); ?>

                <?php else: ?>
                    <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>  
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade tb-addonpopup" id="account-info-modal"  tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <?php if( $payment_method == 'escrow' ): ?>
                        <h4> <?php echo e(__('billing_info.escrow_acc_info')); ?> </h4>
                    <?php elseif( $payment_method == 'paypal' ): ?> 
                        <h4> <?php echo e(__('billing_info.paypal_info')); ?> </h4>
                    <?php elseif( $payment_method == 'payoneer' ): ?> 
                        <h4> <?php echo e(__('billing_info.payoneer_acc_info')); ?> </h4>
                    <?php elseif( $payment_method == 'bank'  ): ?> 
                        <h4> <?php echo e(__('billing_info.bank_acc_info')); ?> </h4>
                    <?php endif; ?>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <ul class="tb-userinfo">
                    
                        <?php if( $payment_method == 'escrow' ): ?>
                            <li>
                                <span><?php echo e(__('general.email')); ?>:</span>
                                <h6><?php echo e($account_info['escrow_email']); ?></h6>
                            </li>
                        <?php elseif( $payment_method == 'paypal' ): ?> 
                            <li>
                                <span><?php echo e(__('general.email')); ?>:</span>
                                <h6><?php echo e($account_info['paypal_email']); ?></h6>
                            </li>
                        <?php elseif( $payment_method == 'payoneer'  ): ?> 
                            <li>
                                <span><?php echo e(__('general.email')); ?>:</span>
                                <h6><?php echo e($account_info['payoneer_email']); ?></h6>
                            </li>
                        <?php elseif( $payment_method == 'bank' ): ?> 
                            <li>
                                <span><?php echo e(__('billing_info.account_title')); ?>:</span>
                                <h6><?php echo e($account_info['title']); ?></h6>
                            </li>
                            <li>
                                <span><?php echo e(__('billing_info.account_number')); ?>:</span>
                                <h6><?php echo e($account_info['account_number']); ?></h6>
                            </li>
                            <li>
                                <span><?php echo e(__('billing_info.bank_name')); ?>:</span>
                                <h6><?php echo e($account_info['bank_name']); ?></h6>
                            </li>
                            <li>
                                <span><?php echo e(__('billing_info.routing_number')); ?>:</span>
                                <h6><?php echo e($account_info['routing_number']); ?></h6>
                            </li>
                            <li>
                                <span><?php echo e(__('billing_info.bank_iban')); ?>:</span>
                                <h6><?php echo e($account_info['bank_iban']); ?></h6>
                            </li>
                            <li>
                                <span><?php echo e(__('billing_info.bank_bic_swift')); ?>:</span>
                                <h6><?php echo e($account_info['bank_bic_swift']); ?></h6>
                            </li>
                        <?php endif; ?>
                    </ul>
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

            $('#filter_request').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_request').on('change', function (e) {
                let filter_request = $('#filter_request').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_request', filter_request);
            });

            iniliazeSelect2Scrollbar();
        }, 50);

        window.addEventListener('account-info-modal', event => {
            $('#account-info-modal').modal(event.detail.modal);
        });
    });
  
    function confirmation( id ){
        
        let title           = '<?php echo e(__("general.confirm")); ?>';
        let content         = '<?php echo e(__("general.confirm_content")); ?>';
        let action          = 'approveRequestConfirm';
        let type_color      = 'green';
        let btn_class      = 'success';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/withdraw-requests/withdraw-request.blade.php ENDPATH**/ ?>