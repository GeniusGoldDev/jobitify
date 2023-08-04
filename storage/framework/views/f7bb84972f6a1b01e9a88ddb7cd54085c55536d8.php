<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,500;0,600;1,400&family=Playfair+Display:ital,wght@1,700&family=Urbanist:ital,wght@0,400;0,500;0,600;0,700;1,500&display=swap');
    , ::after, *::before {
        margin: 0px;
        padding: 0px;
        box-sizing: border-box;
    }
    .tb-printable {
        background: #fff;
    }
    body {
        color: #0A0F26;
        font-size: 16px;
        line-height: 26px;
    }
    .tb-invoicebill {
        width: 100%;
    }
    .tb-invoicebill figure{
        width: 50%;
        margin: 0;
        display: inline-block;
        height: auto;
        vertical-align: middle;
    }
    .tb-billno{
        margin-left: -5px;
        width: 50%;
        text-align: right;
        display: inline-block;
    }
    .tb-billno h3 {
        margin: 0;
        color: #FCCF14;
        font-size: 36px;
        line-height: 37px;
    }
    .tb-billno span {
        font-size: 18px;
        font-weight: 700;
        line-height: 22px;
    }
    .tb-tasksinfos {
        width: 100%;
        margin: 29px 0 0;
    }
    
    .tb-invoicetasks{
        vertical-align: middle;
        display: inline-block;
    }
    .tb-invoicetasks h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 400;
        line-height: 26px;
    }
    .tb-invoicetasks h3 {
        font-size: 20px;
        font-weight: 700;
        line-height: 28px;
        margin: 0;
    }
    .tb-invoicefromto {
        padding: 30px 0;
        margin-top: 30px;
        border-top: 1px solid #eee;
    }
    .tb-fromreceiver {
        width: 100%;
        display: inline-block;
        vertical-align: middle;
    }
    .tb-fromreceiver + .tb-fromreceiver{
        margin-top: 30px;
    }
    .tb-fromreceiver h5 {
        margin: 0 0 10px;
        font-size: 18px;
        line-height: 26px;
    }
    .tb-fromreceiver span {
        font-size: 14px;
        display: block;
        color: #676767;
        line-height: 24px;
    }
    .tb-tasksdates{
        float: right;
        text-align: right;
        display: inline-block;
        vertical-align: middle;
    }
    .tb-tasksdates span{
        font-size: 14px;
        line-height: 22px;
    }
    .tb-tasksdates span em {
        font-style: normal;
    }
    .tb-invoice-table.tb-table {
        margin: 0;
        border: 0;
        width: 100%;
        max-width: 100%;
        border-collapse: collapse;
        background-color: #fff;
    }
    .tb-invoice-table.tb-table > thead {
        border-top: 1px solid #eee;
    }
    tbody, td, tfoot, th, thead, tr {
        border-color: inherit;
        border-style: solid;
        border-width: 0;
    }
    .tb-invoice-table.tb-table > thead > tr {
        border: 0;
        border-bottom: 1px solid #eee;
    }
    .tb-invoice-table.tb-table > thead > tr > th{
        border: 0;
        color: #0A0F26;
        text-align: left;
        background: #fff;
        font-size: 14px;
        font-weight: 700;
        line-height: 35px;
        padding: 17px 0;
    }
    .tb-invoice-table.tb-table > tbody > tr {
        border: 0;
    }
    .tb-invoice-table.tb-table > tbody > tr td {
        line-height: 21px;
        text-align: left;
        background: #fff;
        color: #676767;
        font-size: 14px;
        vertical-align: bottom;
        padding: 24px 28px 23px 0;
    }
    .tb-tablelistv2{
        top: 20px;
        margin-top: 6px;
        position: relative;
    }
    .tb-invoice-table.tb-table > tbody > tr:first-child td {
        vertical-align: top;
        padding-bottom: 10px;
    }
    .tb-tablelist {
        padding: 0;
        margin: 3px 0 0;
        list-style: none;
    }
    .tb-tablelist li {
        font-size: 14px;
        line-height: 22px;
        position: relative;
        list-style-type: none;
        padding: 0;
        color: #353648;
        margin-top: 3px;
        padding: 0 0 0 10px;
    }
    .tb-tablelist li::after {
        left: 0;
        top: -5px;
        content: ".";
        color: #676767;
        font-size: 19px;
        position: absolute;
    }
    .tb-invoice-table.tb-table > tbody > tr td h6 {
        margin: 0;
        color: #0A0F26;
        position: relative;
        letter-spacing: 0.5px;
        font-weight: 700;
        font-size: 16px;
        line-height: 26px;
    }
    .tb-subtotal {
        width: 100%;
        text-align: right;
        margin: 22px 0 44px;
        border-top: 1px solid #eee;
        padding: 25px 0 0;
    }
    .tb-subtotalbill {
        width: 100%;
        margin: 0;
        display: inline-block;
        list-style: none;
        max-width: 350px;
        padding: 0 20px 0 30px;
    }
    .tb-subtotalbill li {
        width: 100%;
        color: #0A0F26;
        display: block;
        padding: 0 0 10px;
        list-style-type: none;
        font-size: 14px;
        text-align: left;
        line-height: 22px;
    }
    .tb-subtotalbill li h6 {
        margin: 0;
        float: right;
        color: #0A0F26;
        letter-spacing: 0.5px;
        display: inline-block;
        font-size: 16px;
        line-height: 26px;
        font-weight: 700;
    }
    .tb-sumtotal {
        text-align: left;
        min-width: 350px;
        padding: 14px 20px 14px 30px;
        background: #FCCF14;
        border-radius: 4px;
        margin-top: 14px;
        list-style-type: none;
        display: inline-block;
        color: #1C1C1C;
        font-size: 14px;
        line-height: 22px;
        font-weight: 700;
    }
    .tb-sumtotal h6 {
        margin: 0;
        float: right;
        color: #1C1C1C;
        font-size: 18px;
        font-size: 18px;
        line-height: 22px;
    }
    .tb-description{
        font-size: 16px;
        line-height: 26px;   
    }
    .tb-invoice-table.tb-table > tbody > tr + tr td:first-child{
        padding-top: 28px;
        vertical-align: top;
        padding-bottom: 28px;
    }
    .tb-tags span, .tb-tags a {
        color: #fff;
        padding: 0 10px;
        font-size: 12px;
        line-height: 26px;
        border-radius: 3px;
        background: #FF9E2B;
        letter-spacing: 0.5px;
        display: inline-block;
        vertical-align: middle;
    }
    .bg-complete {
        background: #63d594 !important;
    }
.tw-termstitle h4 {
        font-size: 1.25rem;
        line-height: 1.4em;
        margin: 0 0 13px;
        font-family: "Urbanist", sans-serif;
    }

    .tb-anoverview .tb-description p {
        margin: 0;
        font-size: 1rem;
        line-height: 1.625em;
        padding-bottom: 18px;
        color: #676767;
        font-family:"Source Sans Pro", sans-serif;
}
.tb-anoverview .tb-description p + p:last-child {
        padding: 0;
        margin-bottom: 0;
}
.tb-termconditionlist {
        padding: 0;
        margin: 19px 0 0;
}
.tb-termconditionlist li::before {
        content: "";
        left: 0;
        top: 10px;
        width: 3px;
        height: 3px;
        border-radius: 50%;
        position: absolute;
        background: #676767;
}
.tb-termconditionlist li {
        list-style-type: none;
        font: 400 1rem/1.5625em "Source Sans Pro", sans-serif;
        position: relative;
        color: #676767;
}

.tb-invoice-table.tb-table > tbody > tr td h6 {
    margin: 0;
    position: relative;
    top: 22px;
    left: 12px;
    color: #353648;
    font: 700 0.875rem/1.5714285714em "Urbanist", sans-serif;
}
</style>
</head>

    <?php
            
        $trans_detail           = !empty( $invoice->TransactionDetail ) ? $invoice->TransactionDetail : null;
        $seller_payout          = !empty( $invoice->sellerPayout ) ? $invoice->sellerPayout : null;
        $billingDetail          = !empty( $invoice->sellerPayout->billingDetail ) ? $invoice->sellerPayout->billingDetail : null;
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
        $transaction_type   = !empty( $trans_detail->transaction_type ) ? $trans_detail->transaction_type : '';
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
    <body>
        <div class="tb-printable">
            <div class="tb-invoicebill">
                <div class="tb-billno">
                    <h3><?php echo e(__('general.invoice')); ?></h3>
                    <span># <?php echo e($invoice->id); ?></span>
                </div>
            </div>
            <div class="tb-tasksinfos">
                <div class="tb-invoicetasks">
                    <h5><?php echo e(__('project.inv_project_title')); ?></h5>
                    <?php if( $transaction_type == 0 || $transaction_type == 4 ): ?>
                        <h3><?php echo e($invoice_title); ?></h3>
                    <?php else: ?>
                        <h3><?php echo e($invoice->sellerPayout->project->project_title); ?></h3>
                    <?php endif; ?> 
                </div>
                <div class="tb-tasksdates">
                    <span> <em><?php echo e(__('project.inv_issue_date')); ?></em> <?php echo e(date( $date_format, strtotime($invoice->created_at) )); ?></span>
                </div>
            </div>
            <div class="tb-invoicefromto">
                <div class="tb-fromreceiver">
                    <span><?php echo e(__('project.inv_from')); ?></span>
                    <h5><?php echo e($trans_detail->full_name); ?></h5>
                    <span>
                        <?php echo e($trans_detail->payer_company); ?><br>
                        <?php echo e($trans_detail->payer_email); ?><br>
                        <?php echo e($trans_detail->payer_address); ?><br>
                        <?php echo e($trans_detail->payer_state); ?>

                    </span>
                </div>
                <?php if( $transaction_type != 0 ): ?>
                    <div class="tb-fromreceiver">
                        <span><?php echo e(__('project.inv_to')); ?></span>
                        <h5><?php echo e($sellerInfo['full_name']); ?></h5>
                        <span>
                            <?php echo e($sellerInfo['billing_company']); ?><br>
                            <?php echo e($sellerInfo['billing_email']); ?><br>
                            <?php echo e($sellerInfo['billing_address']); ?><br>
                            <?php echo e($sellerInfo['state_name']); ?>

                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <table class="tb-table tb-invoice-table">
                <thead>
                    <tr>
                        <th> #</th>
                        <th><?php echo e(__('project.inv_title')); ?></th>
                        <?php if( $transaction_type == 3 ): ?> )
                            <th><?php echo e(__('project.inv_rate_per_hr')); ?></th>
                            <th><?php echo e(__('project.inv_total_hr')); ?></th>
                        <?php endif; ?>
                        <th><?php echo e(__('project.inv_amount')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="#"><?php echo e($sr++); ?></td>
                        <td data-label="<?php echo e(__('project.inv_title')); ?>"><?php echo e($invoice_title); ?></td>
                        <?php if($transaction_type == 3): ?>
                            <td data-label="<?php echo e(__('project.inv_rate_per_hr')); ?>"><?php echo e(!empty( $rete_per_hour ) ? number_format($rete_per_hour) : ''); ?></td>
                            <td data-label="<?php echo e(__('project.inv_total_hr')); ?>"><?php echo e($total_hours); ?></td>
                        <?php endif; ?>
                        <td data-label="<?php echo e(__('project.inv_amount')); ?>"><?php echo e(getPriceFormat($currency_symbol,$trans_detail->amount + $trans_detail->used_wallet_amt)); ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="tb-subtotal">
                <ul class="tb-subtotalbill">
                    <li><?php echo e(__('project.inv_subtotal')); ?><h6><?php echo e(getPriceFormat($currency_symbol,$trans_detail->amount + $trans_detail->used_wallet_amt)); ?></h6></li>
                    <?php if( !empty($seller_payout) && $userRole == 'seller' && $seller_payout->admin_commission > 0 ): ?>
                        <li><?php echo e(__('transaction.admin_fees')); ?>:<h6> - <?php echo e(getPriceFormat($currency_symbol, $seller_payout->admin_commission)); ?></h6></li>
                    <?php endif; ?>
                </ul>
                <div class="tb-sumtotal"><?php echo e(__('project.inv_tatal')); ?><h6><?php echo e(getPriceFormat($currency_symbol, ($trans_detail->amount+ $trans_detail->used_wallet_amt +$trans_detail->sales_tax) )); ?></h6></div>
            </div>
        </div>
    </body>
</html><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/earnings/export-invoice.blade.php ENDPATH**/ ?>