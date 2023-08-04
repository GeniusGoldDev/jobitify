<div class="tk-dbprojectwrap">
    <div class="preloader-outer" wire:loading wire:target="updateSellerProposal">
        <div class="tk-preloader">
            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
        </div>
    </div>
    <?php if(!empty($proposal_detail)): ?>
        <?php
            if(!empty($proposal_detail->proposalAuthor->image)){
                $image_path     = getProfileImageURL($proposal_detail->proposalAuthor->image, '50x50');
                $author_image   = !empty($image_path) ? 'storage/' . $image_path : '/images/default-user-50x50.png';
            }else{
                $author_image = 'images/default-user-50x50.png';
            }
            $status =  getTag( $proposal_detail->status);
        ?>
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
                    <span><?php echo e(getPriceFormat($currency_symbol, $proposal_detail->proposal_amount). ($proposal_detail->payout_type == 'hourly' ? '/hr' : '')); ?></span>
                    <?php if( $proposal_detail->payout_type != 'hourly' ): ?>
                        <?php echo e(__('project.total_project_budget')); ?>

                    <?php else: ?>
                        <?php echo e(__('proposal.hourly_proposed_hours', [ 'payment_mode' => $proposal_detail->payment_mode,'hours' => $hourly_proposed_hours ] )); ?>   
                    <?php endif; ?>
                </strong>
                <?php if( $proposal_detail->status == 'hired' ): ?>
                    <div class="tk-projectsstatus_option">
                        <a href="javascript:;"><i class="icon-more-horizontal"></i></a>
                        <ul class="tk-contract-list"> 
                            <?php if( $userRole == 'buyer' ): ?>
                                <li>
                                    <a href="javascript:;" class="complete-contract" ><?php echo e(__('proposal.complete_contract')); ?></a>
                                </li>             
                            <?php elseif( $userRole == 'seller' ): ?>
                                <li>
                                    <a href="javascript:;" wire:click.prevent="showDisputePopup" ><?php echo e(__('proposal.raise_dispute')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
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
                    <a id="tk_diputes_detail" class="tk-redbtn" href="<?php echo e(route('dispute-detail',['id' => $dispute_id])); ?>"><?php echo e(__('proposal.view_detail')); ?></a>
                </div>
            </div>
        <?php endif; ?>

        <?php
            $total_earned_amt  = $total_rem_amount = 0;
            if( !$proposal_detail->timecards->isEmpty() ){
                foreach( $proposal_detail->timecards as $single ){
                    if( $single->status == 'completed' ){
                        $total_earned_amt += $single->price;
                    }elseif( $single->status == 'queued' || $single->status == 'processing' ){
                        $total_rem_amount += $single->price;
                    }
                }
            }
        ?>
        <div class="tk-project-wrapper tk-timecardwraper">
            <div class="tk-counterinfo <?php echo e($userRole == 'seller' ? 'mt-4' : ''); ?>">
                <ul class="tk-counterinfo_list">
                    <li>
                        <div class="tk-counterinfo-title">
                            <strong class="tk-counterinfo_earned"><i class="icon-briefcase"></i></strong>
                            <?php if($userRole == 'buyer'): ?>
                                <span><?php echo e(__('proposal.total_paid_amount')); ?></span>
                            <?php else: ?>
                                <span><?php echo e(__('proposal.total_earned_amount')); ?></span>    
                            <?php endif; ?>
                        </div>
                        <h5> <?php echo e(getPriceFormat($currency_symbol, $total_earned_amt)); ?> </h5>
                    </li>
                    <li>
                        <div class="tk-counterinfo-title">
                            <strong class="tk-counterinfo_remaining"><i class="icon-dollar-sign"></i></strong>
                            <span><?php echo e(__('proposal.rm_hourly_amount')); ?></span>
                        </div>
                        <h5> <?php echo e(getPriceFormat($currency_symbol, $total_rem_amount)); ?> </h5>
                    </li>
                </ul>
            </div>
            <?php if( $userRole == 'seller' && $proposal_detail->status == 'hired' ): ?>
                <div class="tk-timecards">
                    <div class="tk-timecards_head">
                        <h5><?php echo e(__('proposal.add_timecard' )); ?></h5>
                        <div class="tk-timecards_total">
                            <h6><?php echo e(__('proposal.hours_served')); ?> :</h6>
                            <span><?php echo e(!empty($proposal_detail->filteredTimecard->total_time) ? $proposal_detail->filteredTimecard->total_time :'00:00'); ?></span>
                            <div class="tk-calendar tk-select" wire:ignore>
                                <?php if( !empty($date_intervals) ): ?>
                                    <select class="form-control tk-selectprice tk-hourly-interval">
                                        <?php $__currentLoopData = $date_intervals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>" selected="<?php echo e($single['selected']); ?>"><?php echo e($single['value']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                <?php endif; ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tk-timeslot">
                        <?php if( $proposal_detail->payment_mode == 'daily' ): ?>  
                            <ul class="tk-today-timeslot"> 
                                <li>
                                    <span><?php echo e($hourly_time_slots[0]['format']); ?></span>
                                    <div class="tk-today-timepopup">
                                        <input type="text" class="form-control <?php echo e((empty($proposal_detail->filteredTimecard) || $proposal_detail->filteredTimecard->status == 'pending' || $proposal_detail->filteredTimecard->status == 'cancelled')  ? 'add-hourly-timecard' : 'tk_disbale_date'); ?>"  placeholder="<?php echo e(__('proposal.add_time')); ?>" data-working_time="<?php echo e($hourly_time_slots[0]['time']); ?>" data-time_format="<?php echo e($hourly_time_slots[0]['format']); ?>" value="<?php echo e($hourly_time_slots[0]['time']); ?>" readonly>
                                    </div>
                                </li>
                            </ul>
                        <?php elseif( $proposal_detail->payment_mode == 'weekly' ): ?>
                            <ul class="tk-timeslot_list">
                                <?php $__currentLoopData = $hourly_time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <span><?php echo e($single['day']); ?></span>
                                        <input type="text" readonly class="form-control <?php echo e((empty($proposal_detail->filteredTimecard) || $proposal_detail->filteredTimecard->status == 'pending' || $proposal_detail->filteredTimecard->status == 'cancelled') && !$single['disabled']  ? 'add-hourly-timecard' : 'tk_disbale_date'); ?>" data-working_time="<?php echo e($single['time']); ?>" data-time_format="<?php echo e($single['format']); ?>" <?php echo e($single['disabled'] ? 'disabled' : ''); ?> value="<?php echo e($single['time']); ?>"  placeholder="<?php echo e(__('proposal.add_time')); ?>">
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <ul class="tk-addtime-slot">
                                <?php $__currentLoopData = $hourly_time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="<?php echo e((!empty($single['time']) ? 'tk-added-time' : ( !$single['disabled']  ? 'tk-edit-time' : 'tk-disable-slot' ) )); ?>">
                                        <span><?php echo e($single['day']); ?></span>
                                        <em><?php echo e($single['format']); ?></em>
                                        <?php if( (empty($proposal_detail->filteredTimecard) || $proposal_detail->filteredTimecard->status == 'pending' || $proposal_detail->filteredTimecard->status == 'cancelled') && !$single['disabled'] ): ?> 
                                            <a href="javascript:;" class="add-hourly-timecard" data-working_time="<?php echo e($single['time']); ?>" data-time_format="<?php echo e($single['format']); ?>">
                                                <?php echo e(!empty($single['time']) ? $single['time'].' '. __('general.hours') : __('proposal.add_time')); ?>

                                                <i class="<?php echo e(!empty($single['time']) ? 'icon-edit-3' : 'icon-plus'); ?>"></i>
                                            </a>
                                        <?php elseif(!empty($single['time'])): ?>
                                            <a href="javascript:;"><?php echo e($single['time'].' '. __('general.hours')); ?></a>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                            </ul>       
                        <?php endif; ?>
                        <?php if( !empty($proposal_detail->filteredTimecard) && ( $proposal_detail->filteredTimecard->status == 'pending' || $proposal_detail->filteredTimecard->status == 'cancelled') ): ?>
                            <div class="tk-timeslot_save">
                                <div class="tk-timeslot-btn">
                                    <span><?php echo e(__('proposal.submit_activity_desc', [ 'payment_mode' => $proposal_detail->payment_mode ])); ?> </span>
                                    <a href="javascript:;" onClick="timeCardConfirm(<?php echo e($proposal_detail->filteredTimecard->id); ?>)" class="tk-btn-solid"><?php echo e(__('proposal.submit_activity_btn', [ 'payment_mode' => $proposal_detail->payment_mode ])); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="tk-timecards">
                <div class="tk-timecards_head">
                    <h5><?php echo e(__('proposal.timecard_activities')); ?></h5>   
                    <div class="tk-timecards_total">
                        <h6><?php echo e(__('proposal.hours_served')); ?>:</h6>
                        <?php
                            $total_time = $hours = $minutes = 0;
                            if( !$proposal_detail->timecards->isEmpty() ){
                                foreach($proposal_detail->timecards as $timecard){
                                    $time = explode(':', $timecard->total_time);
                                    $hours      += $time[0];
                                    $minutes    += !empty($time[1]) ? $time[1]: 0;
                                }
                                $hours      += intdiv($minutes, 60);
                                $minutes    = ($minutes % 60);
                                $hours      = $hours < 10 ? '0'.$hours : $hours;
                                $minutes    = $minutes < 10 ? '0'.$minutes : $minutes;
                                $total_time = $hours.':'.$minutes;
                            }
                        ?>
                        <span><?php echo e($total_time); ?></span>
                    </div>
                </div>
                <?php if( !$proposal_detail->timecards->isEmpty() ): ?>
                    <ul class="tk-timecard" id="timecard-accordion">
                        <li class="tk-timecard_head">
                            <h6><?php echo e(__('general.date')); ?></h6>
                            <h6><?php echo e(__('general.description')); ?></h6>
                            <h6><?php echo e(__('general.hours')); ?></h6>
                        </li>
                        <?php $__currentLoopData = $proposal_detail->timecards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timecard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
                            <?php
                                $status = getTag( $timecard->status );
                            ?> 
                            <li>
                                <div class="tk-timecard_toggle tk-timecard_togglevtwo">
                                    <div class="d-block w-100" data-bs-toggle="collapse" data-bs-target="#timecard-<?php echo e($timecard->id); ?>" aria-expanded="false">
                                        <span class="<?php echo e($status['class']); ?>"><?php echo e($status['text']); ?></span> 
                                        <div class="tk-timecard_info tk-timecard_infovtwo">
                                            <p><?php echo e($timecard->title); ?></p> 
                                            <h6>
                                                <em>Hours : <p><?php echo e($timecard->total_time); ?></p>  </em>
                                            </h6>  
                                            <div class="tk-statusvtwo">
                                                <a href="javascript:void(0);"><i class="icon-chevron-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-timecard_title" data-bs-toggle="collapse" data-bs-target="#timecard-<?php echo e($timecard->id); ?>" aria-expanded="false">
                                    <p><?php echo e($timecard->title); ?></p>
                                    <div class="tk-timecard_info">
                                        <span class="<?php echo e($status['class']); ?>"><?php echo e($status['text']); ?></span>
                                        <p><?php echo e($timecard->total_time); ?></p>
                                        <a href="javascript:void(0);"><i class="icon-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="collapse tk-timecard-content" id="timecard-<?php echo e($timecard->id); ?>" data-bs-parent="#timecard-accordion">
                                    <ul class="tk-timecard_list <?php echo e($timecard->status == 'completed' ? 'tk-timecard-aprroved' : ''); ?>">
                                        <?php $__currentLoopData = $timecard->timecardDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <span data-label="<?php echo e(__('general.date')); ?>"><?php echo e(date($date_format, strtotime($detail->working_date))); ?></span>
                                                <span data-label="<?php echo e(__('general.description')); ?>"><?php echo nl2br($detail->description); ?></span>
                                                <span data-label="<?php echo e(__('general.hours')); ?>"><?php echo e($detail->working_time); ?></span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                        <?php if( $userRole == 'buyer' && $timecard->status == 'queued' && $proposal_detail->status == 'hired' ): ?>
                                            <li class="tk-timecard_btns">
                                                <a href="javascript:;"   wire:click.prevent="approveHourlyTimecard(<?php echo e($timecard->id); ?>)" class="tk-approvebtn" ><?php echo e(__('general.approve')); ?></a>
                                                <a href="javascript:;"   onClick="confirmDeclineTimecard(<?php echo e($timecard->id); ?>)" class="tk-declinebtn"><?php echo e(__('general.decline')); ?> </a>
                                                <span><?php echo e(__('proposal.approve_timecard_desc')); ?></span>
                                            </li>
                                        <?php elseif( $timecard->status == 'cancelled' ): ?>
                                            <li class="tk-statusview_alert">
                                            <?php if( $userRole == 'seller'): ?><span><i class="icon-info"></i><?php echo e(__('proposal.timecard_decline_desc')); ?></span><?php endif; ?>
                                                <p><?php echo nl2br($timecard->decline_reason); ?> </p>
                                            </li>    
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                    </ul>
                <?php endif; ?>    
            </div>
        </div>
    <?php endif; ?>

    <div wire:ignore.self class="modal fade tb-addonpopup tk-declinepopup" id="tk_decline_reason" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <h4> <?php echo e(__('proposal.decline_timecard_heading')); ?> </h4>
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
                        <div class="tb-savebtn tb-dhbbtnarea ">
                            <a href="javascript:;" wire:click.prevent="declineTimecard" class="tb-btn"><?php echo e(__('proposal.decline_timecard_req')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade tk-addonpopup" id="complete-contract-popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div  class="modal-dialog tk-modaldialog" role="document">
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
                            </div>
                            <div class="form-group">
                                <label class="tk-label"><?php echo e(__('project.add_feedback')); ?></label>
                                <textarea class="form-control" wire:model.defer="contractRatingDesc" placeholder="<?php echo e(__('project.add_feedback')); ?>"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="tk-savebtn tk-btnwrapper">
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

    <div wire:ignore.self class="modal fade tk-workinghours-popup" id="hourly-timecard-popup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
           <div class="tk-popup_title">
               <h5><?php echo e(__('proposal.submit_working_hours')); ?> </h5>
               <a href="javascrcript:void(0)" data-bs-dismiss="modal">
                   <i class="icon-x"></i>
               </a>
           </div>
            <div class="modal-body tk-popup-content">
                <form class="tk-themeform">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                        	<div class="form-group at-slots-timedate hourly-timecard-dateformat">
                        		<h4><?php echo e($hourly_working_time_format); ?></h4>
                        	</div>
                        	<div class="form-group">
                                <label class="tk-label"><?php echo e(__('proposal.enter_time')); ?></label>
                                <div class="tk-placeholderholder">
                                    <input type="text" class="form-control tk-themeinput <?php $__errorArgs = ['hourly_working_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="00H : 00M"  id="timecard-working-time" >
                                </div> 
                                <?php $__errorArgs = ['hourly_working_time'];
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
                                <div class="tk-placeholderholder">
                                    <textarea name="Description" id="hourly_working_desc" placeholder="<?php echo e(__('proposal.add_description')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['hourly_working_desc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required"></textarea>
                                </div>
                                <?php $__errorArgs = ['hourly_working_desc'];
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
                            <div class="form-group tk-btnarea">
                                <button type="button" class="updateTimecard tk-btn-solid-lg"><?php echo e(__('proposal.save_activity')); ?></button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
          </div>
        </div>
    </div>

    <?php if( $userRole == 'seller' ): ?>
        <div wire:ignore.self class="modal fade" id="dispute_popup" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
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
    <?php endif; ?>
    
    <?php $__env->startPush('scripts'); ?>
        <script defer src="<?php echo e(asset('js/vendor/jquery.inputmask.bundle.js')); ?>"></script>
        <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
        <script>
            document.addEventListener('livewire:load', function () {

                $('#timecard-working-time').inputmask(
                    'datetime',{
                    mask: 'hH : sM',
                    placeholder: '00H : 00M',
                    greedy: false,
                    insertMode: false,
                    showMaskOnHover: false,
                });

                setTimeout(() => {

                    $('.tk-hourly-interval').select2({ 
                        allowClear: true,
                        minimumResultsForSearch: -1
                    });

                    $(document).on('change', '.tk-hourly-interval', function(event) {
                        let _this            = $(this);
                        let hourly_selected_time = _this.find(':selected').val();
                        window.livewire.find('<?php echo e($_instance->id); ?>').set('hourly_selected_time', hourly_selected_time);
                    });

                    iniliazeSelect2Scrollbar();

                }, 50);

                
                $(document).on('click', '.add-hourly-timecard', function(event) {
                    event.preventDefault();
                    let _this            = $(this);
                    let format              = _this.attr('data-time_format');
                    let working_time        = _this.attr('data-working_time');
                    $('#hourly_working_desc').val('');
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('hourly_working_time_format', format, true);
                    if(working_time != ''){
                        $('#timecard-working-time').val(working_time); 
                    }else{
                        $('#timecard-working-time').val('');
                    }
                    $('.hourly-timecard-dateformat h4').text(format);
                    $('#hourly-timecard-popup').modal('show');
                });

                $(document).on('click', '.complete-contract', function(event) {
                    event.preventDefault();
                    $(".tk-contract-list").slideUp();
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

                $(document).on('click', '.updateTimecard', function(event) {
                    let hourly_working_time = $('#timecard-working-time').val();
                    let hourly_working_desc = $('#hourly_working_desc').val();
                    hourly_working_time = hourly_working_time.replace('H', '');
                    hourly_working_time = hourly_working_time.replace('M', '');
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('hourly_working_time', hourly_working_time, true);
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('hourly_working_desc', hourly_working_desc, true);
                    window.livewire.find('<?php echo e($_instance->id); ?>').call('updateTimecard');
                   
                });

                window.addEventListener('show-decline-reason-modal', event => {
                    $('#tk_decline_reason').modal(event.detail.modal);
                });

                window.addEventListener('hide-timecardpopup', event => {
                    $('#hourly_working_desc').val('');
                    $('#hourly-timecard-popup').modal('hide');
                });

                window.addEventListener('contract-rating-modal', event => {
                    $('#complete-contract-popup').modal(event.detail.modal);
                });

                
                window.addEventListener('dispute-popup', event=>{
                    $(".tk-contract-list").stop().slideUp(0);
                    jQuery('#dispute_popup .text-danger').remove();
                    jQuery('#dispute_popup .tk-invalid').removeClass('tk-invalid');
                    $('#dispute_popup').modal(event.detail.modal);
                });
            });

            function timeCardConfirm( id ){
        
                let title           = '<?php echo e(__("general.confirm")); ?>';
                let content         = '<?php echo e(__("general.confirm_content")); ?>';
                let action          = 'timeCardConfirm';
                let type_color      = 'green';
                let btn_class      = 'success';
                ConfirmationBox({title, content, action, id,  type_color, btn_class})
            }

            function confirmDeclineTimecard(id ){
                window.livewire.find('<?php echo e($_instance->id); ?>').set('decline_timecard_id', id, true);
                $('#tk_decline_reason').modal('show');
            }

        </script>
    <?php $__env->stopPush(); ?>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/components/hourly-proposal-activity.blade.php ENDPATH**/ ?>