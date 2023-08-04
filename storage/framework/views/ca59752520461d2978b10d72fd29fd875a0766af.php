<?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
    <main class="tb-main overflow-hidden tk-main-bg"> 
  <?php endif; ?>  
    <section class="tb-main-section <?php if(!empty($className) ): ?> tk-sectioninvoice <?php endif; ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tb-invoiceslist <?php echo e($className); ?>">
                        <div class="tb-dhb-mainheading">
                            <h2><?php echo e(__('transaction.invoices_bills')); ?></h2>
                        </div>
                        <?php if(!$invoices->isEmpty()): ?>
                            <table class="table tb-table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('transaction.invoice_no')); ?></th>
                                        <th> <?php echo e(__('transaction.payment_type')); ?></th>
                                        <th><?php echo e(__('transaction.invoice_date')); ?></th>
                                        <th><?php echo e(__('transaction.invoice_amount')); ?></th>
                                        <th><?php echo e(__('general.action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td data-label="<?php echo e(__('transaction.invoice_no')); ?>"><?php echo e($single->id); ?></td>
                                            <td data-label="<?php echo e(__('transaction.payment_type')); ?>"><?php echo e(ucfirst($single->payment_type)); ?></td>
                                            <td data-label="<?php echo e(__('transaction.invoice_date')); ?>"><?php echo e(date( $date_format, strtotime( $single->created_at ))); ?></td>
                                            <td data-label="<?php echo e(__('transaction.invoice_amount')); ?>"><span><?php echo e(getPriceFormat($currency_symbol, ($single->TransactionDetail->amount+ $single->TransactionDetail->used_wallet_amt))); ?>  </span></td>
                                            <td data-label="<?php echo e(__('general.action')); ?>"><a href="<?php echo e(route('invoice-detail', ['id' => $single->id])); ?>" class="tb-viewdetails"><span class="icon-eye"></span> <?php echo e(__('general.view')); ?></a></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php echo e($invoices->links('pagination.custom')); ?>

                        <?php else: ?>
                            <div class="tk-submitreview">
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
    </section>  
<?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
    </main>
<?php endif; ?> 
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/earnings/invoices.blade.php ENDPATH**/ ?>