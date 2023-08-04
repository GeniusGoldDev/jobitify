<main class="tb-main">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('proposal.all_proposals') .' ('. $proposals->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">        
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_proposal" class="form-control tk-selectprice">
                                            <option value =""> <?php echo e(__('proposal.all_proposals')); ?> </option>
                                            <option value ="pending"> <?php echo e(__('general.pending')); ?> </option>
                                            <option value ="publish"> <?php echo e(__('general.publish')); ?> </option>
                                            <option value ="hired"> <?php echo e(__('general.hired')); ?> </option>
                                            <option value ="completed"> <?php echo e(__('general.completed')); ?> </option>
                                            <option value ="declined"> <?php echo e(__('general.cancelled')); ?> </option>
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_project"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-proposalslist">
                <?php if( !$proposals->isEmpty() ): ?>
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#' )); ?></th>
                                <th><?php echo e(__('project.project_title' )); ?></th>
                                <th><?php echo e(__('proposal.created_date' )); ?></th>
                                <th><?php echo e(__('project.project_budget' )); ?></th>
                                <th><?php echo e(__('proposal.proposal_budget' )); ?></th>
                                <th><?php echo e(__('proposal.payout_type' )); ?></th>
                                <th><?php echo e(__('general.status')); ?><i class="fas fa-sort"></i></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $tag = getTag( $single->status );
                                ?>
                                <tr> 
                                    <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($single->id); ?></span></td>
                                    <td data-label="<?php echo e(__('project.project_title' )); ?>">
                                        <div class="tk-proposal-title">
                                            <a href="<?php echo e(route('project-detail', ['slug'=> $single->project->slug] )); ?>" target="_blank"><?php echo $single->project->project_title; ?></a> 
                                            <span><?php echo e($single->proposalAuthor->full_name); ?></span>
                                        </div>
                                    </td>
                                    <td data-label="<?php echo e(__('proposal.created_date' )); ?>"><span><?php echo e(date($date_format, strtotime( $single->created_at ))); ?></span></td>
                                    <td data-label="<?php echo e(__('project.project_budget' )); ?>"><span><?php echo e(getProjectPriceFormat($single->project->project_type, $currency_symbol, $single->project->project_min_price, $single->project->project_max_price)); ?></span></td>
                                    <td data-label="<?php echo e(__('proposal.proposal_budget' )); ?>"><span><?php echo e(getPriceFormat($currency_symbol,$single->proposal_amount).($single->project->project_type == 'hourly' ? '/hr' : '')); ?></span></td>
                                    <td data-label="<?php echo e(__('proposal.payout_type' )); ?>"><span><?php echo e($single->payout_type); ?></span></td>
                                    <td data-label="<?php echo e(__('general.status')); ?>"><em class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></span></td>
                                    <td data-label="<?php echo e(__('general.actions')); ?>">
                                        <ul class="tb-action-status">
                                            <li>
                                                <?php if( $single->status == 'pending' ): ?>
                                                <span>
                                                    <a href="javascript:;" onClick="confirmation(<?php echo e($single->id); ?>)"  ><i class="fas fa-check"></i><?php echo e(__('proposal.approve')); ?></a>
                                                </span>
                                                <?php else: ?>
                                                    <span class="tb-approved"><i class="fas fa-check"></i><?php echo e(__('proposal.approved')); ?></span>     
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <span>
                                                    <a href="javascript:;" wire:click.prevent="showComment(<?php echo e($single->id); ?>)"><i class="icon-message-square"></i></a>
                                                </span>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('proposal-detail',['slug' => $single->project->slug , 'id' => $single->id])); ?>" target="_blank" ><i class="icon-eye"></i></a>
                                            </li>
                                           
                                            <li> <a href="javascript:void(0);" onClick="deleteProposal(<?php echo e($single->id); ?>)" class="tb-delete" ><i class="icon-trash-2"></i></a> </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
                    </table>
                        <?php echo e($proposals->links('pagination.custom')); ?>  
                    <?php else: ?>
                        <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>  
                </div>
            </div>
        </div>
    </div>
    <div wire:igonre.self class="modal fade tb-addonpopup" id="special_comment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered tb-modaldalog">
            <div class="modal-content">
            <div class="tb-popuptitle">
                <h5><?php echo e(__('proposal.special_comments_to_emp')); ?></h5>
                <a href="javascrcript:void(0)" data-bs-dismiss="modal" class="close">
                    <i class="icon-x"></i>
                </a>
            </div>
            <div class="modal-body tb-popup-content">
                <div class="tb-popup-info">
                    <p class="tb-special-comment"></p>
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

            $('#filter_proposal').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_proposal').on('change', function (e) {
                let filter_proposal = $('#filter_proposal').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_proposal', filter_proposal);
            });

            iniliazeSelect2Scrollbar();
        }, 50);

        document.addEventListener('show-comment', function (event) {
            let comment = event.detail.comment;
            jQuery('.tb-special-comment').text(comment);
            jQuery('#special_comment').modal('show');
        });
        
    });

    function confirmation( id ){
        
        let title           = '<?php echo e(__("general.confirm")); ?>';
        let content         = '<?php echo e(__("general.confirm_content")); ?>';
        let action          = 'approveProposalConfirm';
        let type_color      = 'green';
        let btn_class      = 'success';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
        
    }

    function deleteProposal( id ){
        
        let title           = '<?php echo e(__("general.confirm")); ?>';
        let content         = '<?php echo e(__("general.confirm_content")); ?>';
        let action          = 'deleteProposal';
        let type_color      = 'red';
        let btn_class      = 'danger';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/proposals/proposals.blade.php ENDPATH**/ ?>