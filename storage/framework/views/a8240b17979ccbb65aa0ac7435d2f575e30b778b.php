<div wire:key="<?php echo e(now()); ?>">
    <?php if(!empty($proposal_detail)): ?>
        <?php
            if(!empty($proposal_detail->proposalAuthor->image)){
                $image_path     = getProfileImageURL($proposal_detail->proposalAuthor->image, '50x50');
                $author_image   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-50x50.png';
            }else{
                $author_image = '/images/default-user-50x50.png';
            }
            $status =  getTag( $proposal_detail->status);
        ?>
        <div class="preloader-outer" wire:loading>
            <div class="tk-preloader">
                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
            </div>
        </div>
        <div class="tk-projectsstatus_head">
            <div class="tk-projectsstatus_info">
                <figure class="tk-projectsstatus_img">
                <img src="<?php echo e(asset( $author_image)); ?>" alt="<?php echo e($proposal_detail->proposalAuthor->full_name); ?>">
                </figure>
                <div class="tk-projectsstatus_name">
                    <span class="<?php echo e($status['class']); ?>"><?php echo e($status['text']); ?></span>
                    <h5><?php echo e($proposal_detail->proposalAuthor->full_name); ?></h5>
                </div>
            </div>
            <div class="tk-projectsstatus_budget">
                <strong>
                    <span><?php echo e(getPriceFormat($currency_symbol, $proposal_detail->proposal_amount)); ?></span>
                    <?php echo e(__('project.total_project_budget')); ?>

                </strong>
                <?php if( $proposal_detail->status == 'hired' || $proposal_detail->status == 'rejected' ): ?>
                    <div class="tk-projectsstatus_option">
                        <a href="javascript:;"><i class="icon-more-horizontal"></i></a>
                        <ul class="tk-contract-list"> 
                            <li>
                                <a href="javascript:;" wire:click.prevent="showDisputePopup">
                                    <?php echo e($userRole == 'seller' ? __('proposal.raise_dispute') : __('proposal.create_refund_req')); ?>

                                </a>
                            </li>
                            <?php if( $userRole == 'seller' ): ?>
                                <?php if( $proposal_detail->payout_type == 'fixed' ): ?>
                                    <li>
                                        <a href="javascript:;" wire:click.prevent="completeContract"><?php echo e(__('proposal.complete_contract')); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if( $userRole == 'buyer' && $proposal_detail->status == 'queued' ): ?>
            <div class="tk-notify tk-notify-dispute">
                <div class="tk-notify_title">
                    <figure>
                        <img src="<?php echo e(asset('images/icons/notification.png')); ?>"/>
                    </figure>
                    <div class="tk-notify-content">
                        <h5><?php echo e(__('project.project_accept_heading', [ 'user_name' => $proposal_detail->proposalAuthor->first_name_last_letter] )); ?></h5>
                        <p><?php echo e(__('project.project_accept_desc')); ?></p>
                    </div>
                </div>
                <div class="tk-btnholder">
                    <a href="javascript:;" class="tk-btn_approve complete-contract" id="tk-toaster-notification" ><?php echo e(__('general.approve')); ?></a>
                    <a href="javascript:;" wire:click.prevent="confirmDeclineContract" class="tk-btn_decline"><?php echo e(__('general.decline')); ?> </a>
                </div>
            </div>
        <?php endif; ?>

        <?php if( $proposal_detail->status == 'rejected' ): ?>
            <div class="tk-statusview_alert">
                <?php if( $userRole == 'seller' ): ?><span><i class="icon-info"></i><?php echo e(__('proposal.contract_decline_desc')); ?> </span><?php endif; ?>
                <p><?php echo nl2br($proposal_detail->decline_reason); ?> </p>
            </div>
        <?php endif; ?>
        <div class="preloader-outer" wire:loading wire:target="RaiseDisputeToAdmin">
            <div class="tk-preloader">
                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
            </div>
        </div>
        <?php if( !empty($proposal_disputed) ): ?>
            <div class="tk-notify <?php echo e($dispute_class); ?> <?php echo e($userRole == 'seller' ? 'mt-4' : ''); ?>">
                <div class="tk-notify_title">
                    <figure>
                        <img src="<?php echo e($status_icon); ?>" alt=""/>
                    </figure>
                    <div class="tk-notify-content">
                        <h5><?php echo e($dispute_status_txt); ?></h5>
                        <p><?php echo e($dispute_desc_txt); ?></p>
                    </div>
                </div>
                <div class="tk-btnholder">
                    <?php if($dispute_status == 'declined' && $userRole == 'buyer'): ?>
                        <a id="tk_dipute_action" class="tk-redbtn" wire:click.prevent="RaiseDisputeToAdmin" href="javascript:void(0)"><?php echo e(__('disputes.acknowledge_admin')); ?></a>
                    <?php else: ?>
                        <a id="tk_diputes_detail" class="tk-redbtn" href="<?php echo e(route('dispute-detail',['id' => $dispute_id])); ?>"><?php echo e(__('proposal.view_detail')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if( $proposal_detail->payout_type == 'milestone' ): ?>
            <?php
                $completed = $pending = false;
                $total_earned_amt = $total_escrow_amt = $rm_project_amt = 0;
                foreach( $proposal_detail->milestones as $single ){
                    
                    if( $single->status == 'pending'
                        || $single->status == 'processing' ){

                        $rm_project_amt += $single->price;

                    }elseif( $single->status == 'processed' || $single->status == 'cancelled' || $single->status == 'queued' ){

                        $total_escrow_amt += $single->price;

                    }elseif( $single->status == 'completed' ){

                        $total_earned_amt += $single->price;
                    }

                    if( $single->status == 'completed' ){
                        $completed = true;
                    }else{
                        $pending = true;
                    } 
                }
            ?>
            <div class="tk-counterinfo <?php echo e($userRole == 'seller' ? 'mt-4' : ''); ?>">
                <ul class="tk-counterinfo_list">
                    <li>
                        <div class="tk-counterinfo-title">
                            <strong class="tk-counterinfo_escrow"><i class="icon-clock"></i></strong>
                            <span> <?php echo e(__('proposal.total_escrow_amount')); ?></span>
                        </div>
                        <h5> <?php echo e(getPriceFormat($currency_symbol, $total_escrow_amt)); ?> </h5>
                    </li>
                    <li>
                        <div class="tk-counterinfo-title">
                            <strong class="tk-counterinfo_earned"><i class="icon-briefcase"></i></strong>
                            <span><?php echo e(__('proposal.total_earned_amount')); ?></span>
                        </div>
                        <h5> <?php echo e(getPriceFormat($currency_symbol, $total_earned_amt)); ?> </h5>
                    </li>
                    <li>
                        <div class="tk-counterinfo-title">
                            <strong class="tk-counterinfo_remaining"><i class="icon-dollar-sign"></i></strong>
                            <span><?php echo e(__('proposal.rm_project_amount')); ?></span>
                        </div>
                        <h5> <?php echo e(getPriceFormat($currency_symbol, $rm_project_amt)); ?> </h5>
                    </li>
                </ul>
            </div>
            <?php if( $pending ): ?>
                <div class="tk-projectsinfo">
                    <div class="tk-projectsinfo_title">
                        <h4><?php echo e(__('proposal.project_roadmap')); ?></h4>
                    </div>
                    <ul class="tk-projectsinfo_list">
                        <?php $__currentLoopData = $proposal_detail->milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $status = getTag( $single->status);
                            ?>
                            <?php if( $single->status != 'completed' ): ?>
                                <li>
                                    <div class="tk-statusview">
                                        <div class="tk-statusview_head">
                                            <div class="tk-statusview_title">
                                                <span><?php echo e(getPriceFormat($currency_symbol, $single->price)); ?></span>
                                                <h5><?php echo e($single->title); ?></h5>
                                                <?php if($single->description): ?><p> <?php echo nl2br($single->description); ?></p><?php endif; ?>
                                            </div>
                                            <div class="tk-statusview_tag">
                                                <span class="<?php echo e($status['class']); ?>"><?php echo e($status['text']); ?></span>
                                            </div>
                                        </div>
                                        <?php if($single->status == 'processed' ): ?>
                                            <?php if( $userRole == 'seller' && $proposal_detail->status == 'hired'): ?>
                                                <div class="tk-statusviews mt-4">
                                                    <a href="javascript:;" wire:click.prevent="completeMilestone(<?php echo e($single->id); ?>)" class="tk-btn-solid"><?php echo e(__('proposal.complete_now')); ?></a>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif( $single->status == 'cancelled' ): ?>
                                            <div class="tk-statusview_alert">
                                                <?php if($userRole == 'seller'): ?><span><i class="icon-info"></i><?php echo e(__('proposal.milestone_rejected_desc')); ?> </span><?php endif; ?>
                                                <p><?php echo nl2br($single->decline_reason); ?> </p>
                                            </div>
                                            <?php if( $userRole == 'seller' && $proposal_detail->status == 'hired'): ?>
                                                <div class="tk-statusviews mt-4">
                                                    <a href="javascript:;" wire:click.prevent="completeMilestone(<?php echo e($single->id); ?>)" class="tk-btn-solid"><?php echo e(__('proposal.complete_now')); ?></a>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif( $userRole == 'buyer' && $proposal_detail->status == 'hired'): ?>
                                            <div class="tk-statusview_btns">
                                                <?php if( $single->status == 'queued' ): ?>
                                                    <a href="javascript:;"   wire:click.prevent="approveMilestone(<?php echo e($single->id); ?>)" class="tk-btn_approve" id="tk-toaster-notification" ><?php echo e(__('general.approve')); ?></a>
                                                    <a href="javascript:;"   wire:click.prevent="confirmDeclineMilestone(<?php echo e($single->id); ?>)" class="tk-btn_decline"><?php echo e(__('general.decline')); ?> </a>
                                                <?php elseif( $single->status == 'pending' ): ?>
                                                    <a href="javascript:;" wire:click.prevent="escrowMilestone(<?php echo e($single->id); ?>)"  class="tk-btn_decline"><?php echo e(__('general.escrow')); ?> </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>    
                                    </div>
                                </li>
                            <?php endif; ?>    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if($completed): ?>
                <div class="tk-projectsinfo">
                    <div class="tk-projectsinfo_title">
                        <h4><?php echo e(__('proposal.completed_milestones')); ?></h4>
                    </div>
                    <ul class="tk-projectsinfo_list">
                        <?php $__currentLoopData = $proposal_detail->milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $status =  getTag( $single->status);
                            ?>
                            <?php if( $single->status == 'completed' ): ?>
                                <li>
                                    <div class="tk-statusview">
                                        <div class="tk-statusview_head">
                                            <div class="tk-statusview_title">
                                                <span><?php echo e(getPriceFormat($currency_symbol, $single->price)); ?></span>
                                                <h5><?php echo e($single->title); ?></h5>
                                                <?php if($single->description): ?><p> <?php echo nl2br($single->description); ?></p><?php endif; ?>
                                            </div>
                                            <div class="tk-statusview_tag">
                                                <span class="<?php echo e($status['class']); ?>"><?php echo e($status['text']); ?></span>
                                            </div>
                                        </div>    
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <div wire:ignore.self class="modal fade tb-addonpopup" id="tk_decline_reason" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered tb-modaldialog" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <h4> <?php echo e(__('proposal.decline_heading')); ?> </h4>
                    <a href="javascript:;" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <textarea wire:model.defer="decline_reason" class="form-control  <?php $__errorArgs = ['decline_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
                    <?php $__errorArgs = ['decline_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="tk-errormsg">
                            <span><?php echo e($message); ?></span> 
                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="tb-form-btn">
                        <div class="tb-savebtn tb-dhbbtnarea">
                            <a href="javascript:;" wire:click.prevent="UpdatedeclineReason" class="tb-btn"><?php echo e(__('proposal.decline_req')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade tk-addonpopup" id="complete-contract-popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div  class="modal-dialog modal-dialog-centered tk-modaldialog" role="document">
            <div class="modal-content">
                <div class="tk-popuptitle">
                    <h4> <?php echo e(__('project.complete_contract')); ?> </h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>

                <div class="modal-body">
                    <form class="tk-themeform">
                        <fieldset>
                            <div class="form-group">
                                <label class="tk-label tk-required"><?php echo e(__('project.rating_title')); ?></label>
                                <input type="text" wire:model.defer="contractRatingTitle" class="form-control <?php $__errorArgs = ['contractRatingTitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('project.rating_title')); ?>" autocomplete="off">
                                <?php $__errorArgs = ['contractRatingTitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="tk-errormsg">
                                        <span><?php echo e($message); ?></span> 
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label class="tk-label"><?php echo e(__('project.seller_rating')); ?></label>
                                <div class="tk-my-ratingholder" wire:ignore>
                                    <ul id="tk_seller_ratings" class='tk-rating-stars tk_stars'>
                                        <li class='tk-star' data-value='1'>
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='2'>
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='3'>
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='4' >
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='5'>
                                            <i class="fas fa-star"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php $__errorArgs = ['contractRating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="tk-errormsg">
                                    <span><?php echo e($message); ?></span> 
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-group">
                                <label class="tk-label"><?php echo e(__('project.add_feedback')); ?></label>
                                <textarea class="form-control" wire:model.defer="contractRatingDesc" placeholder="<?php echo e(__('project.add_feedback')); ?>"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="tk-savebtn tk-savebtnfeed">
                                    <a href="javascript:void(0);" wire:click.prevent="completeContract" class="tb-btn"><?php echo e(__('project.complete_without_review')); ?></a>
                                    <a href="javascript:void(0);"  wire:click.prevent="completeContract(1)" class="tb-btn"><?php echo e(__('project.complete_contract')); ?></a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div wire:ignore.self class="modal fade tb-addonpopup" id="escrowDisburseMethods" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <h4> <?php echo e(__('transaction.save_escrow_disburse_methods')); ?> </h4>
                    <a href="javascript:;" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <div>    
                        <ul class="escrow-disburse-methods"></ul>
                    </div>
                    <div class="tb-form-btn">
                        <div class="tb-savebtn tb-dhbbtnarea ">
                            <a href="javascript:;" class="save-disburse-method tb-btn"><?php echo e(__('general.continue')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div wire:ignore.self class="modal fade" id="dispute_popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="tk-popup_title">
                    <h4><?php echo e(__('disputes.create_refund_req')); ?></h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body tk-popup-content">
                    <form class="tk-themeform">
                        <fieldset>
                            <div class="form-group">
                                <h5><?php echo e(__('disputes.choose_issue')); ?></h5>
                                <div class="tk-disputelist">
                                    <?php if(!empty($disputeIssues)): ?>
                                        <ul class="tk-categoriesfilter">
                                            <?php $__currentLoopData = $disputeIssues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <div class="tk-form-checkbox">
                                                        <input class="form-check-input tk-form-check-input-sm" name="distpute-issue" wire:model.defer="dispute_issue" <?php echo e($dispute_issue == $issue ? 'checked':''); ?> type="radio" id="distpute-issue-<?php echo e($key); ?>" value="<?php echo e($issue); ?>" >
                                                        <label class="form-check-label" for="distpute-issue-<?php echo e($key); ?>"><span><?php echo e($issue); ?></span></label>
                                                    </div>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <?php $__errorArgs = ['dispute_issue'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="tk-errormsg">
                                                <span><?php echo e($message); ?></span>
                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php endif; ?>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label class="tk-label"><?php echo e(__('disputes.add_dispute_detail')); ?></label>
                                <textarea wire:model.defer="dispute_detail" class="form-control <?php $__errorArgs = ['dispute_detail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('disputes.dispute_placeholder')); ?>"></textarea>
                                <?php $__errorArgs = ['dispute_detail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="tk-errormsg">
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <div class="tk-termscondition">
                                    <div class="tk-checkterm">
                                        <div class="tk-form-checkbox">
                                            <input class="form-check-input tk-form-check-input-sm" wire:model.defer="agree_term_condtion" id="check-term-condition" type="checkbox">
                                            <label for="check-term-condition"><span><?php echo e(__('disputes.accept_agreement')); ?></span></label>
                                        </div>
                                        <a href="javascript:void(0);"><?php echo __('disputes.terms_condition'); ?> </a>
                                    </div>
                                    <a href="javascript:void(0);" class="tb-btn" wire:click.prevent="createDisputeRequest" ><?php echo e(__('general.submit')); ?> <span class="rippleholder tb-jsripple"><em class="ripplecircle"></em></span></a>
                                </div>
                                <?php $__errorArgs = ['agree_term_condtion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="tk-errormsg">
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('livewire:load', function () {

                window.addEventListener('show-decline-reason-modal', event => {
                    $('#tk_decline_reason').modal(event.detail.modal);
                });

                $(document).on('click', '.complete-contract', function(event) {
                    event.preventDefault();
                    $('#complete-contract-popup').modal('show');
                });

                $(document).on('click', '.tk_stars li', function(){
                    let _this       = $(this);
                    let onStar      = parseInt(_this.data('value'), 10);
                    let stars       = _this.parent().children('li.tk-star');

                    for (let i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('active');
                    }

                    for (let i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('active');
                    }

                    window.livewire.find('<?php echo e($_instance->id); ?>').set('contractRating', onStar, true);
                });

                window.addEventListener('contract-rating-modal', event => {
                    $('#complete-contract-popup').modal(event.detail.modal);
                });
                
                let milestone_id = 0;
                window.addEventListener('escrowDisburseMethods', event => {
                    let str = '';
                    milestone_id = event.detail.milestone_id !='' ? event.detail.milestone_id : 0;
                    event.detail.disburse_methods.forEach((item, index) => {
                        let method_name =  item.type;
                        let bank_name = '';
                        if( item.type == 'wire_transfer' ){
                            bank_name = ' ( '+ item.bank_name+ ' )';
                        }
                        method_name = method_name.replace("_", " ");
                        method_name = method_name.charAt(0).toUpperCase() + method_name.slice(1);
                        str +='<li><label class="form-check-label" for=method-'+index+'><input class="form-check-input tk-form-check-input-sm" type="radio" id=method-'+index+' name="selected_disburse_method" value='+item.id+' / >'+' '+method_name + bank_name +'</label></li>';
                    });
                    if(milestone_id > 0){
                        str +='<li><label class="form-check-label" for="same-method"><input class="form-check-input tk-form-check-input-sm" id="same-method" type="checkbox" name="use_same_method"   / > <?php echo e(__("transaction.always_use_method")); ?></label></li>'
                    }
                    $('.escrow-disburse-methods').html(str);
                    $('#escrowDisburseMethods').modal('show');
                });

                $(document).on('click', '.save-disburse-method', function(e) {
                
                    let  selected_method = $("input[name='selected_disburse_method']:checked").val();
                    let use_same_method = false;
                    if($("input[name='use_same_method']").is(":checked")){
                        use_same_method = true;
                    }
                    if( typeof selected_method == "undefined" ){
                        showAlert({
                            title       : '<?php echo e(__("general.error_title")); ?>' ,
                            message     : '<?php echo e(__("transaction.select_disburse_method")); ?>',
                            type        : 'error',
                            autoclose   : 1000
                        });
                    }else{
                        $('#escrowDisburseMethods').modal('hide');
                        if( milestone_id > 0){
                            window.livewire.find('<?php echo e($_instance->id); ?>').emit('updateEscrowDisburseMethod', milestone_id, selected_method, use_same_method);
                        }else{
                            window.livewire.find('<?php echo e($_instance->id); ?>').set('escrow_disburse_id', selected_method, true);
                            window.livewire.find('<?php echo e($_instance->id); ?>').call('completeContract');
                        }
                    }
                });

                window.addEventListener('dispute-popup', event=>{

                    jQuery(".tk-contract-list").stop().slideUp(0);
                    jQuery('#dispute_popup .text-danger').remove();
                    jQuery('#dispute_popup .tk-invalid').removeClass('tk-invalid');

                    $('#dispute_popup').modal(event.detail.modal);
                });
            });
            
        </script>
    <?php $__env->stopPush(); ?>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/components/fixed-proposal-activity.blade.php ENDPATH**/ ?>