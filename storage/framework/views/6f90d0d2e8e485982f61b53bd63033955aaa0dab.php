<main class="tk-main-bg">
    <section class="tk-main-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tb-dhb-mainheading tb-disputes-title">
                        <h4><?php echo e(__('disputes.disputes_listing')); ?></h4>
                        <div class="tb-sortby">
                            <form class="tb-themeform tb-displistform">
                                <fieldset>
                                    <div class="tb-themeform__wrap">
                                        <div class="form-group wo-inputicon wo-inputheight">
                                            <i class="icon-search"></i>
                                            <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="<?php echo e(__('disputes.search_placeholder')); ?>">
                                        </div>
                                        <div class="wo-inputicon">
                                            <div class="tb-actionselect tb-actionselect2">
                                                <span><?php echo e(__('general.sort_by')); ?>:</span>
                                                <div wire:ignore class="tb-select tk-select">
                                                    <select id="dispute_filter" data-hide_search_opt="true" class="form-control tk-select2">
                                                        <option value=""><?php echo e(__('disputes.all_dispute_opt')); ?> </option>
                                                        <option value="disputed"><?php echo e(__('disputes.new_dispute_opt')); ?></option>
                                                        <option value="refunded"><?php echo e(__('disputes.refund_dispute_opt')); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                  
                    <?php if(!empty($disputes) && $disputes->count() > 0): ?>
                        <table class="table tb-table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('general.ref_no')); ?></th>
                                    <th><?php echo e($userRole == 'buyer' ? __('disputes.saller_name_label') : __('disputes.buyer_name_label')); ?> </th>
                                    <th><?php echo e(__('disputes.date_lable')); ?></th>
                                    <th><?php echo e(__('disputes.amount_lable')); ?></th>
                                    <th><?php echo e(__('disputes.satatus_label')); ?></th>
                                    <th><?php echo e(__('disputes.action_label')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $disputes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dispute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $creatorRoleId          = $dispute->disputeCreator->role_id;
                                        $disputeCreatorRole     = getRoleById($creatorRoleId);
                                        $receiverRoleId         = $dispute->disputeReceiver->role_id;
                                        $disputeReceiverRole    = getRoleById($receiverRoleId);
                                        $userName               = '';
                                        if( $disputeCreatorRole == $userRole ){
                                            $userName = $dispute->disputeReceiver->full_name;
                                        } else {
                                            $userName = $dispute->disputeCreator->full_name;
                                        }
                                        
                                        $disputeStatus = getDisputeStatusTag($dispute->status);
                                    ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('general.ref_no')); ?>"><?php echo e($dispute->id); ?></td>
                                        <td data-label="<?php echo e($userRole == 'buyer' ? __('disputes.saller_name_label') : __('disputes.buyer_name_label')); ?>"><a href="javascript:void(0);"><?php echo e($userName); ?></a> </td>
                                        <td data-label="<?php echo e(__('disputes.date_lable')); ?>"><?php echo e(date($date_format, strtotime($dispute->created_at))); ?></td>
                                        <td data-label="<?php echo e(__('disputes.amount_lable')); ?>"><span><?php echo e(getPriceFormat($currency_symbol,$dispute->price)); ?></span></td>
                                        <td data-label="<?php echo e(__('disputes.satatus_label')); ?>">
                                            <div class="tb-dispueitems tb-dispueitemsv2">
                                                <span class="<?php echo e($disputeStatus['class']); ?>"><?php echo e($disputeStatus['text']); ?></span>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('disputes.action_label')); ?>">
                                            <a href="<?php echo e(route('dispute-detail',['id' => $dispute->id])); ?>" class="tb-vieweye">
                                                <span class="ti-eye"></span> <?php echo e(__('disputes.view_label')); ?>

                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <?php echo e($disputes->links('pagination.custom')); ?>

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
    </section>
</main>

<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
<script>
    document.addEventListener('livewire:load', function () {
        iniliazeSelect2Scrollbar();
        $(document).on('change', '#dispute_filter', function (e) {
            let value     = $('#dispute_filter').select2("val");
            window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_status',value);
        });

    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/dispute-list.blade.php ENDPATH**/ ?>