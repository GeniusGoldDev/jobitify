<?php if( $proposal_detail ): ?>
    <div class="tk-projectsactivity">
        <ul class="nav nav-tabs tk-nav-tabs <?php echo e($userRole == 'buyer' ? 'm-0' : ''); ?>" id="myTab" role="tablist">
            <li>
                <button class="active" id="project-activity" data-bs-toggle="tab" data-bs-target="#activities" aria-controls="activities" aria-selected="true">
                    <i class="icon-folder"></i> <?php echo e(__('project.project_activity')); ?>

                </button>
            </li>
            <li>
                <button class="" id="project-invoice" data-bs-toggle="tab" data-bs-target="#invoices" aria-controls="invoices" aria-selected="false">
                    <i class="icon-file-text"></i>
                    <?php echo e(__('project.invoices')); ?>

                </button>
            </li>
        </ul>
        <div class="tab-content tk-project-type-content" id="myTabContent">
            <div class=" tab-pane fade show active" id="activities" role="tabpanel" aria-labelledby="project-activity">
                <?php if(!$project_activities->isEmpty()): ?>
                    <div class="tk-project-box">
                        <div class="tk-project-holder">
                            <div class="tk-conversation-holder">
                                <div class="tk-custom-scrollbar" id="<?php echo e($listIds[0]); ?>">
                                    <div class="tk-conversation-wrapper">
                                        <?php $__currentLoopData = $project_activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                               
                                                $total_attachments = 0;
                                                if( !empty($single->attachments) ){
                                                    $total_attachments = count(unserialize($single->attachments));
                                                }
                                                if(!empty($single->sender->image)){
                                                    $image_path     = getProfileImageURL($single->sender->image, '38x38');
                                                    $author_image   = !empty($image_path) ? 'storage/' . $image_path : '/images/default-user-38x38.png';

                                                }else{
                                                    $author_image = 'images/default-user-38x38.png';
                                                }
                                                $message_class = $profile_id == $single->sender_id ? 'tk-messages-sender' : 'tk-messages-reciver';
                                            ?>
                                            <div class="tk-message-wrapper">
                                                <div class="<?php echo e($message_class); ?>">
                                                    <div class="tk-message">
                                                        <img src="<?php echo e(asset( $author_image)); ?>" alt="<?php echo e($single->sender->full_name); ?>">
                                                        <div class="tk-message-content">
                                                            <div class="tk-message-holder">
                                                                <p><?php echo nl2br($single->description); ?></p>
                                                                <?php if( $total_attachments > 0 ): ?>
                                                                    <div class="tk-proactivity_file">
                                                                        <img src="<?php echo e(asset('images/file-preview.png')); ?>" alt="">
                                                                        <span><?php echo e(__('project.attachments_to_download', ['total_count' => $total_attachments])); ?></span>
                                                                        <a href="javascript:;" wire:click.prevent="downloadAttachments(<?php echo e($single->id); ?>)"><?php echo e(__('project.download_files')); ?> </a>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <strong><?php echo e(date('F j, Y, h:i a', strtotime($single->created_at) )); ?></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>     
                    <div class="tk-submitreview">
                        <figure>
                            <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                        </figure>
                        <h4><?php echo e(__('general.no_record')); ?></h4>
                    </div>
                <?php endif; ?>
                <?php if( $proposal_detail->status == 'hired' || $proposal_detail->status == 'rejected' ): ?>
                    <form class="tk-themeform tk-uploadfile-doc">
                        <fieldset>
                            <div class="tk-freelanerinfo form-group">
                                <h6><?php echo e(__('project.upload_project_docs')); ?></h6>
                                <div class="tk-upload-resume">
                                    <?php if(!empty($existingFiles)): ?>
                                        <ul class="tk-upload-list">
                                            <?php $__currentLoopData = $existingFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                
                                                <li>
                                                    <div class="tk-uploaded-img">
                                                        <img src="<?php echo e(substr($file->getMimeType(), 0, 5) == 'image' ? $file->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($file->getClientOriginalName()); ?>">
                                                        <p><?php echo e($file->getClientOriginalName()); ?></p>
                                                    </div>
                                                    <a class="tk-remove" href="javascript:;" wire:click.prevent="removeFile('<?php echo e($key); ?>')"><i class="icon-trash-2"></i></a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                    <div wire:loading wire:target="activity_files" class="text-center">
                                        <span ><?php echo e(__('settings.uploading')); ?> </span>
                                    </div>
                                    <div class="tk-uploadphoto" wire:loading.remove wire:target="activity_files">
                                        <p><?php echo e(__('project.project_docs_description')); ?></p>
                                        <input type="file" wire:model.defer="activity_files" multiple id="activity_files" ><label for="activity_files"><?php echo e(__('project.click_here_to_upload')); ?></label>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['activity_files.*'];
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
                                <label class="tk-label"><?php echo e(__('project.add_comments')); ?></label>
                                <textarea wire:loading.attr="disabled" wire:target="updateActivity" wire:model.defer="activity_description" class="form-control tk-themeinput <?php $__errorArgs = ['activity_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  placeholder="<?php echo e(__('project.enter_comments_here')); ?>"></textarea>
                                <?php $__errorArgs = ['activity_description'];
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
                            <div class="form-group tk-form-btn">
                                <span><?php echo e(__('general.click')); ?> <strong>“<?php echo e(__('general.send_now')); ?>”</strong> <?php echo e(__('project.button_to_upload_files')); ?></span>
                                <a href="javascript:void(0);" wire:loading.class="tk-pointer-events-none" wire:click.prevent="updateActivity" class="tk-btn-solid">
                                    <span wire:loading wire:target="updateActivity"> <?php echo e(__('general.sending')); ?> </span>
                                    <span wire:loading.remove wire:target="updateActivity"><?php echo e(__('general.send_now')); ?> </span>
                                </a>
                            </div>
                        </fieldset>
                    </form>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="project-invoice">
                <?php if(!$invoices->isEmpty()): ?>
                    <div class="tk-proinvoices">
                        <?php
                    
                            $invoice_columns = array(
                                __('general.date'),
                                __('general.title'),
                                __('general.amount'),
                            );

                            if(!$invoices->isEmpty() && $invoices[0]->TransactionDetail->transaction_type == 3){
                                $invoice_columns[] = __('general.hours');
                            } 

                            $invoice_columns[] = __('general.status'); 

                    ?>
                    <table class="table tk-proinvoices_table">
                        <thead>
                            <tr>
                                <?php $__currentLoopData = $invoice_columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e($col); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="<?php echo e($listIds[1]); ?>">
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                        
                                $hours = 0;
                                if( $single->TransactionDetail->transaction_type == 1 ){

                                    $invoice_title = $single->TransactionDetail->InvoiceType->invoice_title;

                                }elseif( $single->TransactionDetail->transaction_type == 2 ){
                                    
                                    $invoice_title = $single->TransactionDetail->InvoiceType->project->invoice_title;

                                }elseif( $single->TransactionDetail->transaction_type == 3 ){
                                    $hours    = $single->TransactionDetail->InvoiceType->total_time;
                                    $invoice_title = $single->TransactionDetail->InvoiceType->invoice_title.' '.__('general.hourly_timecard') ;
                                } 
                                $status =  getTag( $single->status);
                                $amount = getPriceFormat($currency_symbol, $single->TransactionDetail->amount + $single->TransactionDetail->used_wallet_amt);
                            
                            ?>
                                <tr>
                                    <td data-label="<?php echo e(__('general.date')); ?>" ><?php echo e(date( $date_format, strtotime( $single->created_at ))); ?></td>
                                    <td data-label="<?php echo e(__('general.title')); ?>" ><p><?php echo e($invoice_title); ?></p></td>
                                    <td data-label="<?php echo e(__('general.amount')); ?>"><?php echo e($amount); ?></td>
                                    <?php if( $single->TransactionDetail->transaction_type == 3 ): ?>
                                        <td data-label="<?php echo e(__('general.hours')); ?>"><?php echo e($hours); ?></td>
                                    <?php endif; ?>
                                    <td data-label="<?php echo e(__('general.status')); ?>"><span class="<?php echo e($status['class']); ?>"><?php echo e($status['text']); ?></span></td>
                                    <td data-label="<?php echo e(__('general.actions')); ?>">
                                        <a href="<?php echo e(route('invoice-detail', ['id' => $single->id])); ?>" target="_blank"><?php echo e(__('project.view_invoices')); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
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
    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('livewire:load', function () {
                window.addEventListener('initializeScrollbar', event=>{
                    initActivityScroll(event.detail[0])
                    $(document).find('#'+event.detail[1]).mCustomScrollbar();
                });

                initActivityScroll();
                function initActivityScroll(sectionId = ''){
                    let targetSection = sectionId ? "#"+sectionId : '.tk-custom-scrollbar';
                    let objDiv = document.querySelector(targetSection);
                    if(objDiv){
                        objDiv.scrollTop = objDiv.scrollHeight;
                    }  
                }
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php else: ?>
    <div></div>    
<?php endif; ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/components/project-activities-invoices.blade.php ENDPATH**/ ?>