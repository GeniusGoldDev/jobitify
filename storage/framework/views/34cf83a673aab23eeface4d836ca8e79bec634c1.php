<main class="tb-main">
    <div class="row">
        <div class="col-md-6 tb-md-50">
            <div class="tb-dhb-mainheading">
                <h4><?php echo e(__('disputes.disputes_listing')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <div wire:ignore class="tb-select">
                                        <select class="form-control" id="filter_status">
                                            <option value =""><?php echo e(__('disputes.all_dispute_opt')); ?> </option>
                                            <option value="refunded"><?php echo e(__('disputes.resolved_dispute_opt')); ?></option>
                                            <option value="disputed"><?php echo e(__('disputes.new_dispute_opt')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search" autocomplete="off" placeholder="<?php echo e(__('disputes.search_placeholder')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <?php if(!empty($disputes) && $disputes->count() > 0): ?>
                <div class="tb-disputetable tb-disputetablev2">
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th><?php echo e(__('disputes.ref_label')); ?></th>
                                <th><?php echo e(__('disputes.buyer_name_label')); ?></th>
                                <th><?php echo e(__('disputes.saller_name_label')); ?></th>
                                <th><?php echo e(__('disputes.date_lable')); ?></th>
                                <th><?php echo e(__('disputes.satatus_label')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $disputes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $seller = $buyer = '';
                                    $creator_role_id        = $single->disputeCreator->role_id;
                                    $disputeCreatorRole     = getRoleById($creator_role_id);
                                    $receiver_role_id       = $single->disputeReceiver->role_id;
                                    $disputeReceiverRole    = getRoleById($receiver_role_id);

                                    if( $disputeCreatorRole == 'seller' && $disputeReceiverRole == 'buyer'){
                                        $seller = $single->disputeCreator;
                                        $buyer  = $single->disputeReceiver;
                                    } else {
                                        $seller = $single->disputeReceiver;
                                        $buyer  = $single->disputeCreator;
                                    }
                                    $disputeStatus = getDisputeStatusTag($single->status);
                                ?>
                                <tr class="tk-dispute-item" wire:click="getDisputeInfo(<?php echo e($single->id); ?>)" data-id="<?php echo e($single->id); ?>">
                                    <td data-label="<?php echo e(__('disputes.ref_label')); ?>">
                                        <span> <?php echo e($single->id); ?> </span>
                                    </td>
                                    <td data-label="<?php echo e(__('disputes.buyer_name_label')); ?>"> 
                                        <?php if(!empty($buyer)): ?>
                                            <span><a href="javascript:void(0)"><?php echo e($buyer->full_name); ?></a> </span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="<?php echo e(__('disputes.saller_name_label')); ?>"> 
                                        <?php if(!empty($seller)): ?>
                                            <span><a href="javascript:void(0)"><?php echo e($seller->full_name); ?></a> </span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="<?php echo e(__('disputes.date_lable')); ?>">
                                        <span><?php echo e(date($date_format, strtotime($single->created_at))); ?> </span>
                                    </td>
                                    <td data-label="<?php echo e(__('disputes.satatus_label')); ?>">
                                        <em class="<?php echo e($disputeStatus['class']); ?>"><?php echo e($disputeStatus['text']); ?></em>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>   
                <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>
       
        <div class="col-md-6 tb-md-50">
            <?php if(!empty($dispute_id)): ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.disputes.dispute-detail',array(
                    'dispute_id'       => $dispute_id,
                    'date_format'      => $date_format,
                    'allowFileSize'    => $allowFileSize, 
                    'allowFileExt'     => $allowFileExt,
                    'currency_symbol'  => $currency_symbol,
                ))->html();
} elseif ($_instance->childHasBeenRendered('0rVi0Au')) {
    $componentId = $_instance->getRenderedChildComponentId('0rVi0Au');
    $componentTag = $_instance->getRenderedChildComponentTagName('0rVi0Au');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('0rVi0Au');
} else {
    $response = \Livewire\Livewire::mount('admin.disputes.dispute-detail',array(
                    'dispute_id'       => $dispute_id,
                    'date_format'      => $date_format,
                    'allowFileSize'    => $allowFileSize, 
                    'allowFileExt'     => $allowFileExt,
                    'currency_symbol'  => $currency_symbol,
                ));
    $html = $response->html();
    $_instance->logRenderedChild('0rVi0Au', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php else: ?>
                <div class="tb-nocommision d-flex">
                    <img src="<?php echo e(asset('images/empty.png')); ?>" alt="">
                    <span><?php echo e(__('disputes.select_dispute')); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>

<script>
    document.addEventListener('livewire:load', function () {

        $(document).on('click', '.tk-dispute-item', function() {
            let _this   = jQuery(this);
            let id      = _this.data('id');
            $('.tk-dispute-item.active').removeClass('active');
            $(this).addClass('active');
            updateUrlParam('id', id);
        });

        setTimeout(function() {

            $('#filter_status').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_status').on('change', function (e) {
                let filter_status = $('#filter_status').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_status', filter_status);
            });

            iniliazeSelect2Scrollbar();
        }, 50);

        function updateUrlParam(key, value) {
            if (history.pushState) {
                let searchParams = new URLSearchParams(window.location.search);
                searchParams.set(key, value);
                let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + searchParams.toString();
                window.history.pushState({path: newurl}, '', newurl);
            }
        }
    });

</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/disputes/disputes.blade.php ENDPATH**/ ?>