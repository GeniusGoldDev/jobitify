<main class="tk-main-bg">
    <?php
        
        $trans_detail           = !empty( $invoice->TransactionDetail ) ? $invoice->TransactionDetail : null;
        $seller_payout = $billingDetail = null;

        if( in_array($invoice->payment_type, ['gig','project'])) {
            $seller_payout          = !empty( $invoice->sellerPayout ) ? $invoice->sellerPayout : null;
            $billingDetail          = !empty( $invoice->sellerPayout->billingDetail ) ? $invoice->sellerPayout->billingDetail : null;
        }
        
        $sellerInfo             = array(
            'full_name'         => '',
            'billing_company'   => '',
            'billing_email'     => '',
            'billing_address'   => '',
            'state_name'        => '',
        );

        if( !empty($billingDetail) ){

            $sellerInfo = array(
                'full_name'         => $billingDetail->full_name,
                'billing_company'   => $billingDetail->billing_company,
                'billing_email'     => $billingDetail->billing_email,
                'billing_address'   => $billingDetail->billing_address,
                'state_name'        => !empty($billingDetail->state) ? $billingDetail->state->name : '',
            );
        }

        $invoice_type       = !empty( $trans_detail->InvoiceType ) ? $trans_detail->InvoiceType : null;
        $transaction_type   = $trans_detail->transaction_type;
        $status             = getTag($invoice->status);
        $invoice_title      = $rete_per_hour = $total_hours = '';
        
        if( $transaction_type == 0 ||  $transaction_type == 1 ){
            $invoice_title  = $invoice_type->invoice_title;
        }elseif($transaction_type == 2){
            $invoice_title  = $invoice_type->project->invoice_title;
        }elseif( $transaction_type == 3 ){
            $invoice_title  = $invoice_type->invoice_title;
            $rete_per_hour  = $invoice_type->proposal->proposal_amount;
            $total_hours    = $invoice_type->total_time;
        }elseif( $transaction_type == 4 ){
            $invoice_title  = $invoice_type->gig->invoice_title;
        }

        $sr = 1;
        
    ?>
    <section class="tk-main-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tk-invoicehead">
                        <a href="javascript:void(0);" class="tk-download-pdf tk-btn-solid-lg" wire:click.prevent="exportPDFInvoice" ><?php echo e(__('project.download_pdf')); ?> <i class="icon-download"></i></a>
                    </div>
                    <div class="tk-invoicedetal">
                        <div class="tk-printable">
                            <div class="tk-invoicebill">
                                <figure>
                                <?php if( !empty($site_dark_logo) ): ?>
                                    <img src="<?php echo e(asset('storage/'.$site_dark_logo)); ?>" alt="<?php echo e(__('general.logo')); ?>" />
                                <?php else: ?>
                                    <img src="<?php echo e(asset('demo-content/logo.png')); ?>" alt="<?php echo e(__('general.logo')); ?>" />
                                <?php endif; ?>
                                </figure>
                                <div class="tk-billno">
                                    <h3><?php echo e(__('general.invoice')); ?></h3>
                                    <span># <?php echo e($invoice->id); ?></span>
                                </div>
                            </div>
                            <div class="tk-tasksinfos">
                                <div class="tk-invoicetasks">
                                    <h5><?php echo e(__('project.inv_project_title')); ?></h5>
                                    <?php if( $transaction_type == 0 || $transaction_type == 4 ): ?>
                                        <h3><?php echo e($invoice_title); ?></h3>
                                    <?php else: ?>
                                        <h3><?php echo e($invoice->sellerPayout->project->project_title); ?></h3>
                                    <?php endif; ?> 
                                </div>
                                <div class="tk-tasksdates">
                                    <div class="tk-tags"><span class="tk-tag-ongoing <?php echo e($status['class']); ?>"><?php echo e($status['text']); ?></span></div>
                                    <span> <em><?php echo e(__('project.inv_issue_date')); ?></em> <?php echo e(date( $date_format, strtotime($invoice->created_at) )); ?></span>
                                </div>
                            </div>
                            <div class="tk-invoicefromto">
                                <div class="tk-fromreceiver">
                                    <h5><?php echo e(__('project.inv_from')); ?></h5>
                                    <span>
                                        <?php echo e($trans_detail->full_name); ?><br>
                                        <?php echo e($trans_detail->payer_company); ?><br>
                                        <?php echo e($trans_detail->payer_email); ?><br>
                                        <?php echo e($trans_detail->payer_address); ?><br>
                                        <?php echo e($trans_detail->payer_state); ?>

                                    </span>
                                </div>
                                <?php if( $transaction_type != 0 ): ?>
                                    <div class="tk-fromreceiver">
                                        <h5><?php echo e(__('project.inv_to')); ?></h5>
                                        <span>
                                            <?php echo e($sellerInfo['full_name']); ?><br>
                                            <?php echo e($sellerInfo['billing_company']); ?><br>
                                            <?php echo e($sellerInfo['billing_email']); ?><br>
                                            <?php echo e($sellerInfo['billing_address']); ?><br>
                                            <?php echo e($sellerInfo['state_name']); ?>

                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <table class="tk-table tk-invoice-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-right"> <?php echo e(__('project.inv_title')); ?> </th>
                                        <?php if( $transaction_type == 3  ): ?>
                                            <th><?php echo e(__('project.inv_rate_per_hr')); ?></th>
                                            <th><?php echo e(__('project.inv_hr')); ?></th>
                                        <?php endif; ?>
                                        <th class="text-right"><?php echo e(__('project.inv_amount')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="#"> <?php echo e($sr++); ?></td>
                                        <td class="text-right" data-label="<?php echo e(__('project.inv_title')); ?>"><?php echo e($invoice_title); ?> </td>
                                        <?php if($transaction_type == 3 ): ?>
                                            <td class="text-right" data-label="<?php echo e(__('project.inv_rate_per_hr')); ?>"><?php echo e(!empty( $rete_per_hour )  ?getPriceFormat($currency_symbol, $rete_per_hour) : ''); ?></td>
                                            <td class="text-right" data-label="<?php echo e(__('project.inv_hr')); ?>"><?php echo e($total_hours); ?></td>
                                        <?php endif; ?>
                                        <td class="text-right" data-label="<?php echo e(__('project.inv_amount')); ?>"><?php echo e(getPriceFormat($currency_symbol,$trans_detail->amount + $trans_detail->used_wallet_amt)); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="tk-subtotal">
                                <ul class="tk-subtotalbill">
                                    <li><?php echo e(__('project.inv_subtotal')); ?><h6><?php echo e(getPriceFormat($currency_symbol, $trans_detail->amount + $trans_detail->used_wallet_amt)); ?></h6></li>
                                    <?php if( !empty($seller_payout) && $userRole == 'seller' && $seller_payout->admin_commission > 0 ): ?>
                                        <li><?php echo e(__('transaction.admin_fees')); ?>:<h6> - <?php echo e(getPriceFormat($currency_symbol, $seller_payout->admin_commission)); ?></h6></li>
                                    <?php endif; ?>
                                </ul>
                                <div class="tk-sumtotal"><?php echo e(__('project.inv_tatal')); ?><h6><?php echo e(getPriceFormat($currency_symbol, (($trans_detail->amount+ $trans_detail->used_wallet_amt) - (!empty($seller_payout) && $userRole == 'seller' ? $seller_payout->admin_commission : 0)) )); ?></h6></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/earnings/invoice_detail.blade.php ENDPATH**/ ?>