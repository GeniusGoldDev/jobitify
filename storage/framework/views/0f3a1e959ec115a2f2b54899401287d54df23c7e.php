<main class="tb-main">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('transaction.all_transactions')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                            
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_earning" class="form-control tk-selectprice">
                                            <option value =""> <?php echo e(__('transaction.all_transactions')); ?> </option>
                                            <option value ="pending"> <?php echo e(__('general.pending')); ?> </option>
                                            <option value ="processed"> <?php echo e(__('general.hired')); ?> </option>
                                            <option value ="completed"> <?php echo e(__('general.completed')); ?> </option>
                                            <option value ="refunded"> <?php echo e(__('general.refunded')); ?> </option>
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
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                <?php if( !$earnings->isEmpty() ): ?>
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#' )); ?></th>
                                <th><?php echo e(__('transaction.ref_no' )); ?></th>
                                <th><?php echo e(__('transaction.created_date' )); ?></th>
                                <th><?php echo e(__('transaction.total_amount' )); ?></th>
                                <th><?php echo e(__('transaction.admin_fees' )); ?></th>
                                <th><?php echo e(__('transaction.payment_type' )); ?></th>
                                <th><?php echo e(__('transaction.payment_method' )); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $earnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $tag = getTag( $single->transaction->status );
                                $currency_symbol = '';
                                $currency_detail = currencyList($single->transaction->TransactionDetail->currency);
                                    if( !empty($currency_detail) ){
                                        $currency_symbol = $currency_detail['symbol']; 
                                    }
                                ?>
                                <tr> 
                                    <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($single->id); ?></span></td>
                                    <td data-label="<?php echo e(__('transaction.ref_no' )); ?>"><span><?php echo e(!empty($single->transaction->trans_ref_no) ? $single->transaction->trans_ref_no : $single->transaction->invoice_ref_no); ?></span></td>
                                    <td data-label="<?php echo e(__('transaction.created_date' )); ?>"><span><?php echo e(date($date_format, strtotime( $single->transaction->updated_at ))); ?></span></td>
                                    <td data-label="<?php echo e(__('transaction.total_amount' )); ?>"><span><?php echo e(getPriceFormat($currency_symbol, $single->transaction->TransactionDetail->amount + $single->transaction->TransactionDetail->used_wallet_amt)); ?></span></td>
                                    <td data-label="<?php echo e(__('transaction.admin_fees' )); ?>"><span><?php echo e(getPriceFormat($currency_symbol, $single->amount)); ?></span></td>
                                    <td data-label="<?php echo e(__('transaction.payment_type' )); ?>"><span><?php echo e(ucfirst($single->transaction->payment_type)); ?></span></td>
                                    <td data-label="<?php echo e(__('transaction.payment_method' )); ?>"><span><?php echo e(ucfirst($single->transaction->payment_method)); ?></span></td>
                                    <td data-label="<?php echo e(__('general.status')); ?>">
                                        <em class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></em>
                                    </td>
                                    <td data-label="<?php echo e(__('general.actions')); ?>">
                                        <ul class="tb-action-status"> 
                                            <li>
                                                <a href="javascript:;" wire:click.prevent="earningDetail(<?php echo e($single->transaction->id); ?>)"><i class="icon-eye"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
                    </table>
                        <?php echo e($earnings->links('pagination.custom')); ?>  
                    <?php else: ?>
                        <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>  
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade tb-addonpopup" id="transaction_detail_popup"  tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content tb-transaction-detail">
                    <div class="tb-popuptitle">
                        <h4> <?php echo e(__('transaction.transaction_detail')); ?> </h4>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <?php if(!empty($transaction_detail) ): ?>
                            <ul class="tb-userinfo-list" id="<?php echo e($modal_id); ?>">
                                <li>
                                    <span><?php echo e(__('transaction.invoice_no')); ?>:</span>
                                    <h6><?php echo e($transaction_detail['id']); ?></h6>
                                </li>
                                <li>
                                    <span><?php echo e(__('transaction.created_date')); ?>:</span>
                                    <h6><?php echo e(date($date_format, strtotime( $transaction_detail['date'] ))); ?></h6>
                                </li>
                                <?php if( $transaction_detail['type'] == 'project' && !empty($transaction_detail['project_title']) ): ?>
                                    <li>
                                        <span><?php echo e(__('transaction.project_title')); ?>:</span>
                                        <h6><?php echo $transaction_detail['project_title']; ?></h6>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <span><?php echo e(__('transaction.transaction_title')); ?>:</span>
                                    <h6><?php echo $transaction_detail['transaction_title']; ?></h6>
                                </li>
                                <li>
                                    <span><?php echo e(__('transaction.transaction_type')); ?>:</span>
                                    <h6><?php echo e(ucfirst($transaction_detail['type'])); ?></h6>
                                </li>
                                <li>
                                    <span><?php echo e(__('transaction.payment_method')); ?>:</span>
                                    <h6><?php echo e(ucfirst($transaction_detail['payment_method'])); ?></h6>
                                </li>
                                <li>
                                    <span><?php echo e(__('transaction.transaction_amount')); ?>:</span>
                                    <h6><?php echo e(getPriceFormat($transaction_detail['currency'], $transaction_detail['total_amount'])); ?></h6>
                                </li>
                                <?php if( $transaction_detail['type'] == 'project' && !empty($transaction_detail['seller_amount']) ): ?>
                                    <li>
                                        <span><?php echo e(__('transaction.seller_amount')); ?>:</span>
                                        <h6><?php echo e(getPriceFormat($transaction_detail['currency'], $transaction_detail['seller_amount'])); ?></h6>
                                    </li>
                                    <li>
                                        <span><?php echo e(__('transaction.admin_amount')); ?>:</span>
                                        <h6><?php echo e(getPriceFormat($transaction_detail['currency'], $transaction_detail['admin_amount'])); ?></h6>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <span><?php echo e(__('transaction.buyer')); ?>:</span>
                                    <h6><?php echo e($transaction_detail['buyer']); ?></h6>
                                </li>
                                <?php if( $transaction_detail['type'] == 'project' && !empty($transaction_detail['seller']) ): ?>
                                    <li>
                                        <span><?php echo e(__('transaction.seller')); ?>:</span>
                                        <h6><?php echo e($transaction_detail['seller']); ?></h6>
                                    </li>
                                <?php endif; ?>
                            </ul> 
                        <?php endif; ?>                      
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

            $('#filter_earning').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_earning').on('change', function (e) {
                let filter_earning = $('#filter_earning').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_earning', filter_earning);
            });

            iniliazeSelect2Scrollbar();
        }, 50);

        window.addEventListener('transaction-detail-modal', event => {
            $(document).find('#'+event.detail.modal_id).mCustomScrollbar();
            $('#transaction_detail_popup').modal('show');
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/earnings/earnings.blade.php ENDPATH**/ ?>