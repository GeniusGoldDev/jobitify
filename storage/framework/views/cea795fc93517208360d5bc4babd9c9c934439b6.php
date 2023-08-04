<div>
    <?php if( !$gig_activities->isEmpty() ): ?>
        <div class="tk-project-box">
            <div class="tk-project-holder">
                <div class="tk-conversation-holder">
                    <div class="tk-custom-scrollbar" id="<?php echo e($listIds[0]); ?>">
                        <div class="tk-conversation-wrapper">
                            <?php $__currentLoopData = $gig_activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    
                                    $total_attachments = 0;
                                    if(!empty($single->attachments)){
                                        $total_attachments = count(unserialize($single->attachments));
                                    }
                                    if(!empty($single->sender->image)){
                                        $image_url    = getProfileImageURL($single->sender->image, '38x38');
                                        $author_image   = !empty($image_url) ? 'storage/'.$image_url : 'images/default-user-38x38.png';
                                    }else{
                                        $author_image   = 'images/default-user-38x38.png';
                                    }
                                    $message_class = $profile_id == $single->sender_id ? 'tk-messages-sender' : 'tk-messages-reciver';
                                ?>
                                <div class="tk-message-wrapper">
                                    <div class="<?php echo e($message_class); ?>">
                                        <div class="tk-message">
                                            <img src="<?php echo e(asset( $author_image)); ?>" alt="<?php echo e($single->sender->full_name); ?>">
                                            <div class="tk-message-content">
                                                <?php if( $single->type == 'final' ): ?>
                                                    <div class="tb-statustag">
                                                        <span>
                                                            <i class="far fa-bell"></i><?php echo e(__('gig.final_package')); ?>

                                                        </span>
                                                    </div>
                                                <?php endif; ?>
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
    <?php endif; ?>
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
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-activity-conversation.blade.php ENDPATH**/ ?>