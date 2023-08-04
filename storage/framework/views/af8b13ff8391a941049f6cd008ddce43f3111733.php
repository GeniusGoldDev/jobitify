<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="tb-payouthistory tk-payouthistoryvtwo">
                <div class="tk-submitreview tk-submitreviewvtwo tk-seller-graph">
                    <div class="tb-dhb-mainheading tk-emptyheading">
                        <div class="tb-tabfiltertitle">
                            <h5><?php echo e(__('transaction.withdrawal_history')); ?></h5>
                        </div>
                        <div class="tb-sortby">
                            <form class="tb-themeform tb-displistform">
                                <fieldset>
                                    <div class="tb-themeform__wrap">
                                        <div class="wo-inputicon">
                                            <div class="tb-actionselect tb-actionselect2">
                                                <div class="tb-select" wire:ignore>
                                                    <select id="filter_status" data-hide_search_opt="true" class="form-control tk-select2">
                                                        <option value=""><?php echo e(__('general.all')); ?></option>
                                                        <option value="pending"><?php echo e(__('general.pending')); ?></option>
                                                        <option  value="completed"><?php echo e(__('general.approved')); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>  
                        </div>
                    </div>
                    <?php if( !$payouts_history->isEmpty() ): ?>
                        <table class="table tb-table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('transaction.ref_no')); ?></th>
                                    <th><?php echo e(__('transaction.date')); ?></th>
                                    <th><?php echo e(__('transaction.payout_type')); ?></th>
                                    <th><?php echo e(__('transaction.amount')); ?></th>
                                    <th><?php echo e(__('transaction.status')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $payouts_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if( $single->status == 'processed' ){ 
                                        $single->status = 'completed';
                                    }
                                    $tag = getTag( $single->status );
                                    ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('transaction.ref_no')); ?>"><label><span><?php echo e($single->id); ?></span></label></td>
                                        <td data-label="<?php echo e(__('transaction.date')); ?>"><?php echo e(date($date_format, strtotime( $single->created_at ))); ?></td>
                                        <td data-label="<?php echo e(__('transaction.payout_type')); ?>"> <a href="javascript:void(0)"> <?php echo e(ucfirst( $single->payment_method )); ?></a> </td>
                                        <td data-label="<?php echo e(__('transaction.amount')); ?>"><span><?php echo e(getPriceFormat($currency_symbol, $single->amount)); ?> </span></td>
                                        <td data-label="<?php echo e(__('transaction.status')); ?>"><em class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></em></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            </tbody>
                        </table>
                        <?php echo e($payouts_history->links('pagination.custom')); ?> 
                    <?php else: ?>
                        <div class="tk-emptypayout">
                            <figure>
                                <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                            </figure>
                            <h4><?php echo e(__('general.no_record')); ?></h4>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            iniliazeSelect2Scrollbar();
            $('#filter_status').on('change', function (e) {
                let filter_status = $('#filter_status').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_status', filter_status);
            });
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/earnings/payouts-history.blade.php ENDPATH**/ ?>