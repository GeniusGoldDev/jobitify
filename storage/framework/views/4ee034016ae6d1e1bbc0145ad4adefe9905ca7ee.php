
<?php   
    $seller = $buyer = '';
    $creator_role_id        = $dispute_data->disputeCreator->role_id;
    $disputeCreatorRole     = getRoleById($creator_role_id);
    $receiver_role_id       = $dispute_data->disputeReceiver->role_id;
    $disputeReceiverRole    = getRoleById($receiver_role_id);

    if( $disputeCreatorRole == 'seller' && $disputeReceiverRole == 'buyer'){
        $seller = $dispute_data->disputeCreator;
        $buyer  = $dispute_data->disputeReceiver;
    } else {
        $seller = $dispute_data->disputeReceiver;
        $buyer  = $dispute_data->disputeCreator;
    }
    $disputeStatus = getDisputeStatusTag($dispute_data->status);
    $initiateChatuser = $proposal_amount = $payout_type = $project_date = $project_title = '';
    $refund_amount = 0;
    $milestones = $timecards = array();
    
    if( !empty($dispute_data->proposal) ) {
        $proposal_amount = $dispute_data->proposal->proposal_amount;
        $payout_type = $dispute_data->proposal->payout_type;
            if($payout_type == 'milestone'){
                if(!$dispute_data->proposal->milestones->isEmpty())
                $milestones     = $dispute_data->proposal->milestones;
                $refund_amount = $dispute_data->proposal->milestones->sum('price');
            }elseif($payout_type == 'hourly'){
                if(!$dispute_data->proposal->timecards->isEmpty()){
                    $timecards      = $dispute_data->proposal->timecards;
                    $refund_amount = $dispute_data->proposal->timecards->sum('price');
                }
            } else {
                $refund_amount = $dispute_data->proposal->proposal_amount;
            }

        if( !empty($dispute_data->proposal->project) ){
            $project_date   = $dispute_data->proposal->project->updated_at;
            $project_title  = $dispute_data->proposal->project->project_title;
        }
    }else{
        $proposal_amount = $dispute_data->gigOrder->plan_amount; 
        $refund_amount  = $dispute_data->gigOrder->plan_amount; 
        $project_date   = $dispute_data->gigOrder->gig->updated_at;
        $project_title   = $dispute_data->gigOrder->gig->title;
    }
?>
<div class="tb-dbholder">
    <div class="tb-dbbox">
        <span class="<?php echo e($disputeStatus['class']); ?>"><?php echo e($disputeStatus['text']); ?></span>
        <h5><?php echo e($project_title); ?></h5>
        <ul class="tb-infolist">
            <li>
                <span><i class="ti-calendar"></i><?php echo e(__('disputes.dispute_created_date', ['date' => date($date_format, strtotime($project_date))])); ?></span>
            </li>
            <li>
                <span><i class="ti-tag"></i><?php echo e(__('disputes.reference_no', ['number' => $dispute_id])); ?></span>
            </li>
        </ul>
    </div>
    <div class="tb-colapseable">
        <div class="tb-colapseableiten">
            <h5 type="button" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#demo"><?php echo e(__('disputes.dispute_detail_heading')); ?> <i class="icon-chevron-right"></i> </h5>
            <div id="demo" class="collapse" wire:ignore.self>
                <div class="tb-dbbox">
                    <div class="tb-collapsetile">
                        <strong><?php echo e($dispute_data->dispute_issue); ?></strong>
                        <p><?php echo nl2br($dispute_data->dispute_detail); ?></p>
                    </div>
                    <div class="tb-disputesum">
                        <h6><?php echo e(__('disputes.dispute_summary')); ?></h6>
                        <ul class="tl-summerylist">
                            <li><?php echo e(__('disputes.project_budget_lable')); ?><span><?php echo e(getPriceFormat($currency_symbol,$proposal_amount).($payout_type == 'hourly' ? '/hr' : '')); ?></span></li>

                            <?php if($payout_type == 'milestone' && !empty($milestones)): ?>
                                <?php $__currentLoopData = $milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <h6><?php echo e($milestone->title); ?></h6>
                                        <span><?php echo e(getPriceFormat($currency_symbol, $milestone->price)); ?></span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php elseif($payout_type == 'hourly' && !empty($timecards)): ?>
                                <?php $__currentLoopData = $timecards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timecard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <h6><?php echo e($timecard->title); ?></h6>
                                        <span><?php echo e(getPriceFormat($currency_symbol, $timecard->price)); ?></span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            
                            <li class="tb-sublisttotal"><?php echo e(__('proposal.refund_amount_label')); ?> <span><?php echo e(getPriceFormat($currency_symbol, $refund_amount)); ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="tb-colapseableiten">
            <h5 type="button" id="chat_collapse" data-chat_id="<?php echo e($chatId); ?>" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#convo"><?php echo e(__('disputes.dispute_conversation')); ?> <i class="icon-chevron-right"></i> </h5>
            <div id="convo" class="collapse" wire:ignore.self>
                <div class="tb-dbbox">
                    <?php if(! $chat->isEmpty() ): ?>
                        <div id="<?php echo e($chatId); ?>" class="tk-conversation-holder">
                            <?php $__currentLoopData = $chat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $total_attachments = 0;

                                    if(!empty($message->attachments)){
                                        $attachments        = @unserialize($message->attachments);
                                        $total_attachments  = !empty($attachments) ? count($attachments) : 0;
                                    }

                                    $chatInit = '';
                                    if($key == 0){
                                        $chatInit = $message->sender_id;
                                    }
                                    $name = $role = '';
                                    $user_img   = 'images/default-user-38x38.png';
                                    if( !$message->userInfo->isEmpty ){
                                        $name = $message->userInfo->full_name;
                                        $role = $message->userInfo->role_id;

                                        if(!empty($message->userInfo->image)){
                                            $image_path     = getProfileImageURL($message->userInfo->image, '38x38');
                                            $user_img   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-38x38.png';
                                        }

                                    }
                                    $messageClass = $message->sender_id == $profile_id ? 'tk-messages-sender' : 'tk-messages-reciver';

                                ?>
                                <div class="tk-message-wrapper">
                                    <div class="<?php echo e($messageClass); ?>">
                                        <div class="tk-message">
                                            <img src="<?php echo e(asset($user_img)); ?>" alt="<?php echo e($name); ?>">
                                            <div class="tk-message-content">
                                                <div class="tk-message-holder">
                                                    <p><?php echo nl2br($message->message); ?></p>
                                                    <?php if( $total_attachments > 0 ): ?>
                                                    <div class="tk-message-attechemets">
                                                        <span><img src="<?php echo e(asset('images/file-preview.png')); ?>" alt="" /><?php echo e(__('project.attachments_to_download', ['total_count' => $total_attachments])); ?></span>
                                                        <a href="javascript:;" wire:click.prevent="downloadAttachments(<?php echo e($message->id); ?>)"><?php echo e(__('project.download_files')); ?> </a>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                <strong>
                                                    <?php echo e(date($date_format, strtotime( $message->created_at ))); ?>

                                                    <?php if($dispute_data->status == 'disputed'): ?>
                                                        <a href="javascript:void(0);" data-id="<?php echo e($message->id); ?>" class="reply-message"><?php echo e(__('disputes.relpy_heading')); ?></a>
                                                    <?php endif; ?>
                                                </strong>
                                            </div>
                                        </div>
                                        <?php if(!empty($message->replyMessages)): ?>
                                            <?php $__currentLoopData = $message->replyMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php   
                                                $reply_total_attachments = 0;
                                                $user_img = 'images/default-user-38x38.png';
                                                if(!empty($reply->attachments)){
                                                    $reply_attachments          = @unserialize($reply->attachments);
                                                    $reply_total_attachments    = !empty($reply_attachments) ? count($reply_attachments) : 0;
                                                }

                                                if(!empty($reply->userInfo->image)){
                                                    $image_path     = getProfileImageURL($reply->userInfo->image, '38x38');
                                                    $user_img       = !empty($image_path) ? '/storage/' . $image_path : 'images/default-user-38x38.png';
                                                }
                                            ?>
                                                <div class="tk-message tk-message-adminreply">
                                                    <img src="<?php echo e(asset($user_img)); ?>" alt="<?php echo e($reply->userInfo->full_name); ?>">
                                                    <div class="tk-message-content">
                                                        <div class="tk-message-holder">
                                                            <p><?php echo nl2br($reply->message); ?></p>
                                                            <?php if( $reply_total_attachments > 0 ): ?>
                                                                <div class="tk-message-attechemets">
                                                                    <span><img src="<?php echo e(asset('images/file-preview.png')); ?>" alt="" /><?php echo e(__('project.attachments_to_download', ['total_count' => $reply_total_attachments])); ?></span>
                                                                    <a href="javascript:;" wire:click.prevent="downloadAttachments(<?php echo e($reply->id); ?>)"><?php echo e(__('project.download_files')); ?> </a>
                                                                </div>
                                                            <?php endif; ?>
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
                    <?php endif; ?>
                    <?php if($dispute_data->status == 'disputed'): ?>
                    <div class="tk-conversation-reply">
                        <h6><?php echo e(__('disputes.dispute_reply_text')); ?></h6>
                        <div class="tk-placeholderholder">
                            <textarea wire:model.defer="message_text" id="reply-message-sec" class="form-control tk-themeinput <?php $__errorArgs = ['message_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('disputes.dispute_reply_placeholder')); ?>"></textarea>
                            <?php $__errorArgs = ['message_text'];
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
                        <div class="tk-replybtns">
                            <a href="javascript:void(0);" wire:loading.class="tk-pointer-events-none" wire:click.prevent="sendMessage" class="tb-btn">
                                <b wire:loading wire:target="sendMessage"> <?php echo e(__('general.sending')); ?> </b>
                                <b wire:loading.remove wire:target="sendMessage"><?php echo e(__('disputes.post_reply')); ?> </b>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="tb-colapseableiten">
            <h5 type="button" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#convoq" aria-expanded="true"><?php echo e(__('disputes.dispute_resolution_label')); ?><i class="icon-chevron-right"></i> </h5>
            <div id="convoq" wire:ignore.self class="collapse show">
                    <div class="tb-dbbox">
                        <form class="tb-themeform tb-loginform">
                            <fieldset>
                                <div class="form-group-wrap">
                                    <div class="form-group">
                                        <ul class="tb-payoutmethod tb-disputetest">
                                            <li class="tb-radiobox <?php echo e($dispute_data->status == 'refunded' ? 'tk-refunded-dispute':''); ?> ">
                                                <input wire:model="favour_to" type="radio" id="<?php echo e(getRoleById($buyer->role_id)); ?>" <?php echo e($favour_to == 'buyer' ? 'checked' : ''); ?> value="buyer">
                                                <div class="tb-radiodispute">
                                                    <div class="tb-radio">
                                                        <label for="<?php echo e(getRoleById($buyer->role_id)); ?>" class="tb-radiolist payoutlists">
                                                            <span class="tb-wininginfomain">
                                                                <?php
                                                                    $buyer_img   = 'images/default-user-50x50.png';
                                                                    if(!empty($buyer->image)){
                                                                        $image_path     = getProfileImageURL($buyer->image, '50x50');
                                                                        $buyer_img   = !empty($image_path) ? '/storage/' . $image_path : '/images/default-user-50x50.png';
                                                                    }
                                                                ?>
                                                                <img src="<?php echo e(asset($buyer_img)); ?>" alt="<?php echo e($buyer->full_name); ?>">
                                                                <span class="tb-wininginfo">
                                                                    <i><?php echo e($buyer->full_name); ?></i>
                                                                    <em><?php echo e(getRoleById($buyer->role_id)); ?></em>
                                                                </span>
                                                                <?php if($dispute_data->favour_to == 'buyer'): ?>
                                                                    <figure>
                                                                        <img src="<?php echo e(asset('admin/images/disputes/img-1.png')); ?>" alt="" >
                                                                    </figure>
                                                                <?php endif; ?>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="tb-radiobox <?php echo e($dispute_data->status == 'refunded' ? 'tk-refunded-dispute':''); ?>">
                                                <input type="radio" wire:model="favour_to" id="<?php echo e(getRoleById($seller->role_id)); ?>" <?php echo e($favour_to == 'seller' ? 'checked' : ''); ?> value="seller">
                                                <div class="tb-radiodispute">
                                                    <div class="tb-radio">
                                                        <label for="<?php echo e(getRoleById($seller->role_id)); ?>" class="tb-radiolist payoutlists">
                                                            <span class="tb-wininginfomain">
                                                                <?php
                                                                    $seller_image   = 'images/default-user-50x50.png';
                                                                    if(!empty($seller->image)){
                                                                        $image_path     = getProfileImageURL($seller->image, '50x50');
                                                                        $seller_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-50x50.png';
                                                                    }
                                                                ?>
                                                                <img src="<?php echo e(asset($seller_image)); ?>" alt="<?php echo e($seller->full_name); ?>">
                                                                <span class="tb-wininginfo">
                                                                    <i><?php echo e($seller->full_name); ?></i>
                                                                    <em><?php echo e(getRoleById($seller->role_id)); ?></em>
                                                                </span>
                                                                <?php if($dispute_data->favour_to == 'seller'): ?>
                                                                    <figure>
                                                                        <img src="<?php echo e(asset('admin/images/disputes/img-1.png')); ?>" alt="" >
                                                                    </figure>
                                                                <?php endif; ?>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <?php $__errorArgs = ['favour_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="tk-errormsg">
                                                <span><?php echo e($message); ?><span>
                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <?php if($dispute_data->status == 'refunded'): ?>
                                        <div class="tb-resolved tb-disputed">
                                            <div class="tb-radiodispute">
                                                <div class="tb-radiolist payoutlists">
                                                    <span class="tb-wininginfomain">
                                                        <span class="tb-wininginfo tb-greencheck">
                                                            <span class="fas fa-check"></span>
                                                            <i><?php echo e(__('disputes.resolved_dispute_labled')); ?></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($dispute_data->status == 'disputed'): ?>
                                        <div class="form-group">
                                            <label class="tb-label"><?php echo e(__('disputes.dispute_reply')); ?></label>
                                            <textarea class="form-control <?php $__errorArgs = ['feedback'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="feedback" placeholder="<?php echo e(__('disputes.relpy_placeholder')); ?>"></textarea>
                                            <?php $__errorArgs = ['feedback'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="tk-errormsg">
                                                    <span><?php echo e($message); ?><span>
                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group tb-email-wrapper">
                                            <label class="tb-label"><?php echo e(__('disputes.upload_photo')); ?></label>
                                            <div class="tb-uploadarea tb-uploadbartwo">
                                                
                                                <em><?php echo e(__('category.image_option',['extension'=> $allowFileExt, 'size'=> $allowFileSize.'MB'])); ?>

                                                    <label for="attachment_files">
                                                        <span>
                                                            <input id="attachment_files" wire:model.defer="attachment_files" multiple  type="file">
                                                            <?php echo e(__('category.click_here_to_upload')); ?>

                                                        </span>
                                                    </label>
                                                </em>
                                                <li wire:loading wire:target="attachment_files" style="display: none" class="tb-uploading">
                                                    <span><?php echo e(__('settings.uploading')); ?></span>
                                                </li>
                                                <?php if(!empty($existingFiles)): ?>
                                                    <?php $__currentLoopData = $existingFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="tb-uploadel tb-upload-two">
                                                            <img src="<?php echo e(substr($file->getMimeType(), 0, 5) == 'image' ? $file->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($file->getClientOriginalName()); ?>">
                                                            <span><?php echo e($file->getClientOriginalName()); ?> <a href="javascript:void(0);" wire:click.prevent="removeFile('<?php echo e($key); ?>')"> <i class="ti-trash"></i></a> </span>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </div>
                                            <?php $__errorArgs = ['attachment_files.*'];
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
                                        <div class="form-group tb-disputebtn">
                                            <a href="javascript:void(0);" wire:loading.class="tk-pointer-events-none" wire:click.prevent="resolveDispute" class="tb-btn">
                                                <b wire:loading wire:target="resolveDispute"> <?php echo e(__('general.sending')); ?> </b>
                                                <b wire:loading.remove wire:target="resolveDispute"><?php echo e(__('general.send_now')); ?> </b>
                                            </a>
                                            <em><?php echo e(__('disputes.feedback_btn_desc')); ?></em>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:load', function () {
            $(document).on('click', '.reply-message', function(event) {
                let _this   = jQuery(this);
                let id      = _this.data('id');
                if(id){
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('reply_message_id', id, true);
                    let target = $('#reply-message-sec');
                    target.focus();
                    target.addClass('tk-invalid').delay(1000).queue(function(next){
                        $(this).removeClass('tk-invalid');
                        next();
                    });
                }
            });
            
            jQuery(document).on('click', '#chat_collapse', function(e){
                let _this   = jQuery(this);
                let chatId  = _this.data('chat_id');
                if(chatId.length){
                    initScroll(chatId)
                }
            });

            function initScroll(sectionId = ''){
                let targetSection = sectionId ? '#'+sectionId : ".tk-conversation-holder";
                $(targetSection).mCustomScrollbar({}).mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
            }

            window.addEventListener('initializeScrollbar', event=>{
                initScroll(event.detail.chatId)
            });
        })
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/disputes/dispute-detail.blade.php ENDPATH**/ ?>