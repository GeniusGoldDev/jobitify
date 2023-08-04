<main>
    <div class="preloader-outer" wire:loading wire:target="refundAction">
        <div class="tk-preloader">
            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
        </div>
    </div>
    <?php
        $disputeStatus = getDisputeStatusTag($status);
    ?>
    <section class="tk-main-section tk-main-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-8">
                    <div class="tk-project-wrapper">
                        <div class="tk-project-box tk-dispute-buyer">
                            <div class="tk-servicedetailtitle">
                                <ul class="tk-dispute-tags">
                                    <li>
                                        <span class="<?php echo e($disputeStatus['class']); ?>"><?php echo e($disputeStatus['text']); ?></span>
                                    </li>
                                </ul>
                                <h5><?php echo e($dispute_title); ?></h5>
                                <ul class="tk-blogviewdates tk-blogviewdatessm">
                                    <li><span><i class="icon-calendar"></i><?php echo e(__('disputes.dispute_created_date', ['date' => date( $date_format, strtotime( $dispute_created_at ))])); ?></span></li>
                                    <li><span><i class="icon-tag"></i> <?php echo e(__('disputes.reference_no', ['number' =>$dispute_id])); ?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-project-box">
                            <div class="tk-dispute">
                                <div class="tk-dispute_holder">
                                    <figure>
                                        <img src="<?php echo e(asset($dispute_author_image)); ?>" alt="<?php echo e($dispute_author_name); ?>">
                                    </figure>
                                    <div class="tk-dispute_title">
                                        <h5><?php echo e($dispute_author_name); ?></h5>
                                        <span><?php echo e($dispute_author_role); ?> <em>(<?php echo e(__('disputes.dispute_author')); ?>)</em></span>
                                    </div>
                                </div>
                                <div class="tk-dispute_progress">
                                    <span><i class="icon-chevron-right"></i> </span>
                                </div>
                                <div class="tk-dispute_holder">
                                    <div class="tk-dispute_title">
                                        <h5><?php echo e($disp_receiver_name); ?></h5>
                                        <span class="text-right"><?php echo e($disp_receiver_role); ?></span>
                                    </div>
                                    <figure>
                                        <img src="<?php echo e(asset($disp_receiver_image)); ?>" alt="<?php echo e($disp_receiver_name); ?>">
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="tk-project-box">
                            <div class="tk-project-holder">
                                <div class="tk-project-title">
                                    <h4><?php echo e($dispute_issue); ?></h4>
                                </div>
                                <div class="tk-jobdescription">
                                    <p><?php echo nl2br($dispute_detail); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                            $show_chat = false;
                            if( !$chat->isEmpty() ||   $show_reply_box ){
                                $show_chat = true;
                            }
                        ?>
                            <?php if( $show_chat ): ?>
                                <div class="tk-project-box">
                                    <div class="tk-project-holder">
                                            <?php if(! $chat->isEmpty()): ?>
                                                <div class="tk-project-title">
                                                    <h4><?php echo e(__('disputes.dispute_conversation')); ?></h4>
                                                </div>
                                                <div class="tk-conversation-holder">
                                                    <div id="<?php echo e($chatId); ?>" class="tk-custom-scrollbar">
                                                        <div class="tk-conversation-wrapper">
                                                            <?php $__currentLoopData = $chat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $image = $name = $role = '';
                                                                    if( !$message->userInfo->isEmpty ){
                                                                        $name = $message->userInfo->full_name;
                                                                        $role = $message->userInfo->role_id;

                                                                        if(!empty( $message->userInfo->image ) ){
                                                                            $image_path     = getProfileImageURL( $message->userInfo->image, '38x38');
                                                                            $image          = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-38x38.png';
                                                                        } else {
                                                                            $image          = '/images/default-user-38x38.png';
                                                                        }
                                                                    }
                    
                                                                    $messageClass = $message->sender_id == $profile_id ? 'tk-messages-sender' : 'tk-messages-reciver';
                    
                                                                    $total_attachments = 0;
                    
                                                                    if( !empty($message->attachments) ){
                                                                        $attachement_data   = @unserialize($message->attachments);
                                                                        $total_attachments  = !empty($attachement_data) ? count($attachement_data) : 0;
                                                                    }
                                                                ?>
                                                                <div class="tk-message-wrapper">
                                                                    <div class="<?php echo e($messageClass); ?>">
                                                                        <div class="tk-message">
                                                                            <img src="<?php echo e(asset($image)); ?>" alt="<?php echo e($name); ?>">
                                                                            <div class="tk-message-content">
                                                                                <div class="tk-message-holder">
                                                                                    <p><?php echo nl2br($message->message); ?></p>
                                                                                    <?php if( $total_attachments > 0 ): ?>
                                                                                    <div class="tk-message-attechemets">
                                                                                        <span><img src="<?php echo e(asset('images/file-preview.png')); ?>" alt="" /><?php echo e(__('project.attachments_to_download', ['total_count' => $total_attachments])); ?></span>
                                                                                        <a href="javascript:;" wire:click.prevent="downloadAttachments(<?php echo e($message->id); ?>)" ><?php echo e(__('project.download_files')); ?> </a>
                                                                                    </div>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                                <strong><?php echo e(date($date_format, strtotime( $message->created_at ))); ?></strong>
                                                                            </div>
                                                                        </div>
                                                                        <?php if( !empty($message->replyMessages) ): ?>
                                                                            <?php $__currentLoopData = $message->replyMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <div class="tk-message tk-message-adminreply">
                                                                                    <?php   
                                                                                        $user_image = '/images/default-user-38x38.png';
                                                                                        if(!empty( $reply->userInfo->image ) ) {
                                                                                            $image_path = getProfileImageURL( $reply->userInfo->image, '38x38','terer');
                                                                                            $user_image = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-38x38.png';
                                                                                        }
                                                                                    ?>
                                                                                    <img src="<?php echo e(asset($user_image)); ?>" alt="<?php echo e($reply->userInfo->full_name); ?>">
                                                                                    <div class="tk-message-content">
                                                                                        <div class="tk-message-holder">
                                                                                            <p><?php echo nl2br($reply->message); ?></p>
                                                                                        </div>
                                                                                        <strong><?php echo e(date($date_format, strtotime( $reply->created_at ))); ?></strong>
                                                                                    </div>
                                                                                </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php if($show_reply_box): ?>
                                            <div class="tk-conversation-reply">
                                                <h6><?php echo e(__('disputes.relpy_heading')); ?></h6>
                                                <div class="tk-placeholderholder">
                                                    <textarea  wire:model.defer="reply_message" class="form-control tk-themeinput <?php $__errorArgs = ['reply_message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('disputes.relpy_placeholder')); ?>" id="dispute_comment"></textarea>
                                                </div>
                                                <?php $__errorArgs = ['reply_message'];
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
                                                <div class="tk-replybtns">
                                                    <a href="javascript:void(0)" wire:click.prevent="refundAction('reply')" class="tk-btn-yellow-lg"><?php echo e(__('disputes.post_reply')); ?> <i class="icon-chevron-right"></i></a>
                                                    <?php if($status == 'publish' && $resolved_by == 'seller' && $created_to == $profile_id): ?>
                                                        <div class="tk-decline-btns">
                                                            <a href="javascript:void(0)" wire:click.prevent="refundAction('decline')" class="tk-btn tk-decline-btn"><?php echo e(__('disputes.delined_refund')); ?></a>
                                                            <a href="javascript:void(0)" wire:click.prevent="refundAction('refund')" class="tk-btn tk-allow-btn"><?php echo e(__('disputes.allow_refund')); ?></a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>                                                        
                    </div>
                </div>
                <div class="col-lg-5 col-xl-4">
                    <aside>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box">
                                <div class="tk-ordersumery-content mt-0">
                                    <span><?php echo e(__('disputes.dispute_summary')); ?></span>
                                    <ul class="tk-order-detail">
                                        <?php if( !empty($proposal_amount) ): ?>
                                            <li>
                                                <h6><?php echo e(__('proposal.total_project_budget')); ?></h6>
                                                <span><?php echo e(getPriceFormat($currency_symbol,$proposal_amount).($payout_type == 'hourly' ? '/hr':'')); ?></span>
                                            </li>
                                        <?php endif; ?>
                                        <?php if( !empty($gig_addons) ): ?>
                                            <?php $__currentLoopData = $gig_addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <h6><?php echo e($single['title']); ?></h6>
                                                    <span><?php echo e(getPriceFormat($currency_symbol, $single['price'])); ?></span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                        <?php endif; ?> 
                                        <?php if( $payout_type == 'milestone' && !empty($milestones) ): ?>
                                            <?php $__currentLoopData = $milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <h6><?php echo e($milestone->title); ?></h6>
                                                    <span><?php echo e(getPriceFormat($currency_symbol, $milestone->price)); ?></span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php elseif( $payout_type == 'hourly' && !empty($timecards) ): ?>
                                            <?php $__currentLoopData = $timecards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timecard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <h6><?php echo e($timecard->title); ?></h6>
                                                    <span><?php echo e(getPriceFormat($currency_symbol, $timecard->price)); ?></span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <li class="tk-total-amount">
                                            <h5><?php echo e(__('proposal.refund_amount_label')); ?></h5>
                                            <span><?php echo e(getPriceFormat($currency_symbol, $refund_amount)); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box">
                                <div class="tk-ordersumery-title">
                                    <h4><?php echo e(__('disputes.disputes_activities')); ?></h4>
                                </div>
                                <?php if($showTimeLimitMsg): ?>
                                    <div class="tk-ordersumery-content">
                                        <div class="tk-escrow">
                                            <i class="icon-alert-circle"></i>
                                            <span><?php echo __('disputes.time_duration_limit_msg',['day_number' => $disputeAfterDays]); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="tk-ordersumery-content">
                                    <?php if( !empty($dispute_log) ): ?>
                                    <ul class="tk-status-tabs">
                                        <?php
                                            krsort($dispute_log);
                                        ?>
                                        <?php $__currentLoopData = $dispute_log; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actionType => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php   
                                                $log_desc = '';
                                                if($actionType == 0 ){
                                                    $log_desc = __('disputes.dispute_created_by');
                                                } elseif($actionType == 1){
                                                    $log_desc = __('disputes.dispute_declined_by');
                                                    
                                                } elseif($actionType == 2){
                                                    $log_desc = __('disputes.dispute_req_sent_to');
                                                    
                                                } elseif( $actionType == 3){
                                                    $log_desc = __('disputes.refund_approved_by');
                                                } elseif( $actionType == 4 ){
                                                    $log_desc = __('disputes.disp_resolved_in_favor');
                                                }
                                            ?>
                                            <li>
                                                <div class="tk-status-tabs_content">
                                                    <h6><?php echo e($log_desc); ?>&nbsp;<a href="javascript:void(0)"> “<?php echo e($log['username'].' ('.ucfirst( getRoleById( $log['role_id'] ) ).')'); ?>”</a></h6>
                                                    <span><?php echo e(date( $date_format, strtotime( $log['action_date'] ))); ?></span>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <?php endif; ?>
                                </div>
                                <?php if($showAcknowledgeBtn): ?>                    
                                    <div class="tk-ordersumery-content">
                                        <div class="tk-acknowledge-admin">
                                            <button class="tk-btn-solid tk-decline-btn"><?php echo e(__('disputes.acknowledge_to_admin')); ?></button>
                                            <p><?php echo e(__('disputes.acknowledge_to_admin_desc')); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
</main>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:load', function () {
            $(document).on('click', '.proposal-dispute-action', function(event) {
                let _this = $(this);
                let submit_title = _this.data('submit_title');
                if(submit_title){
                    $('#proposal-dispute-reply-btn').text(submit_title);
                }
                $('#reply-box .tb-refundform').css('display','block')
            });
            
            function initScroll(sectionId = ''){
                let targetSection = sectionId ? '#'+sectionId : ".tk-custom-scrollbar";
                let objDiv = document.querySelector(targetSection);
                if(objDiv){
                    objDiv.scrollTop = objDiv.scrollHeight;
                }
            }
            
            initScroll();
            window.addEventListener('initializeScrollbar', event=>{
                initScroll(event.detail.chatId)
            });

        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/dispute-detail.blade.php ENDPATH**/ ?>