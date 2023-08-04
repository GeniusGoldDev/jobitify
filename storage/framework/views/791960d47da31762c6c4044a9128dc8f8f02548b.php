<main class="tb-main">    
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('gig.all_orders') .' ('. $gig_orders->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">         
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_gig" class="form-control tk-selectprice">
                                            <option value =""> <?php echo e(__('gig.all_orders')); ?> </option>
                                            <option value ="hired"> <?php echo e(__('general.hired')); ?> </option>
                                            <option value ="completed"> <?php echo e(__('general.completed')); ?> </option>
                                            <option value ="disputed"> <?php echo e(__('general.disputed')); ?> </option>
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
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_gig"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-allgig-order">
                <?php if( !$gig_orders->isEmpty() ): ?>
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#' )); ?></th>
                                <th><?php echo e(__('gig.title' )); ?></th>
                                <th><?php echo e(__('gig.gig_order_author' )); ?></th>
                                <th><?php echo e(__('gig.plan_type' )); ?></th>
                                <th><?php echo e(__('gig.order_amount' )); ?></th>
                                <th><?php echo e(__('gig.delivery_days' )); ?></th>
                                <th><?php echo e(__('gig.order_start_time' )); ?></th>
                                <th><?php echo e(__('gig.deadline' )); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $gig_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $tag = getTag( $single->status );
                                ?>
                                <tr> 
                                    <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($single->id); ?></span></td>
                                    <td data-label="<?php echo e(__('gig.title' )); ?>">
                                        <div class="tk-proposal-title">
                                            <a href="<?php echo e(route('gig-detail', ['slug'=> $single->gig->slug] )); ?>" target="_blank"><?php echo $single->gig->title; ?></a> 
                                            <span><?php echo e($single->gig->gigAuthor->full_name); ?></span>
                                        </div>
                                    </td>
                                    <td data-label="<?php echo e(__('gig.gig_order_author' )); ?>"><span><?php echo e($single->orderAuthor->full_name); ?></span></td>
                                    <td data-label="<?php echo e(__('gig.plan_type' )); ?>"><span><?php echo e($single->plan_type); ?></span></td>
                                    <td data-label="<?php echo e(__('gig.order_amount' )); ?>"><span><?php echo e(getPriceFormat($currency_symbol,$single->plan_amount)); ?></span></td>
                                    <td data-label="<?php echo e(__('gig.delivery_days' )); ?>"><span><?php echo e($single->gig_delivery_days); ?></span></td>
                                    <td data-label="<?php echo e(__('gig.order_start_time' )); ?>"><span><?php echo e(date('M d, Y',  strtotime($single->gig_start_time))); ?></span></td>
                                    <td data-label="<?php echo e(__('gig.deadline' )); ?>"><span><?php echo e(date('M d, Y', strtotime('+'.$single->gig_delivery_days.'days', strtotime($single->gig_start_time)))); ?></span></td>
                                    <td data-label="<?php echo e(__('general.status')); ?>">
                                        <em class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></em>
                                    </td>
                                    <td data-label="<?php echo e(__('general.action')); ?>">
                                        <ul class="tb-action-status">
                                            <li> <a href="javascript:void(0);" onClick="deleteOrder(<?php echo e($single->id); ?>)" class="tb-delete" ><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
                    </table>
                        <?php echo e($gig_orders->links('pagination.custom')); ?>  
                    <?php else: ?>
                        <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>  
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

            $('#filter_gig').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_gig').on('change', function (e) {
                let filter_gig = $('#filter_gig').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_gig', filter_gig);
            });

            iniliazeSelect2Scrollbar();
        }, 50);
    });

    function deleteOrder( id ){
        
        let title           = '<?php echo e(__("general.confirm")); ?>';
        let content         = '<?php echo e(__("general.confirm_content")); ?>';
        let action          = 'deleteGigOrder';
        let type_color      = 'red';
        let btn_class      = 'danger';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }

</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/gigs/gig-orders.blade.php ENDPATH**/ ?>