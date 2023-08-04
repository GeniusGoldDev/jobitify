<div class="col-lg-8 col-xl-9" wire:key="identity-verification">
	<div class="tb-dhb-profile-settings">
        <?php if( $isVerifiedAcc == 'pending' && !empty($verify_reject_reason) ): ?>
            <div class="tk-notify tk-notify-alert">
                <div class="tk-notify_title">
                    <figure>
                        <img src="<?php echo e(asset('images/icons/cross.png')); ?>" alt="<?php echo e(__('general.image')); ?>">
                    </figure>
                    <div class="tk-notify-content">
                        <h5><?php echo e(__('identity_verification.verification_rejection')); ?></h5>
                        <p><?php echo nl2br($verify_reject_reason); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>   
        <?php if( $isVerifiedAcc == 'processed' ): ?>
            <div class="tb-refunddetailswrap tb-alert-information">
                <div class="tb-orderrequest">
                    <div class="tb-ordertitle">
                        <h5><?php echo e(__('identity_verification.woohoo')); ?></h5>
                        <p> <?php echo e(__('identity_verification.sent_verification_request')); ?> </p>
                    </div>
                    <div class="tb-orderbtn">
                        <a class="tb-btn btn-orange tb-cancel-identity" wire:click.prevent="reuploadIdentification" href="javascript:;"><?php echo e(__('identity_verification.cancel_reupload')); ?></a>
                    </div>
                </div>
            </div>
	    <?php elseif( $isVerifiedAcc == 'approved' ): ?>
            <div class="tk-notify tk-notify-success">
                <div class="tk-notify_title">
                    <figure>
                        <img src="<?php echo e(asset('images/icons/success.png')); ?>" alt="<?php echo e(__('general.image')); ?>">
                    </figure>
                    <div class="tk-notify-content">
                        <h5><?php echo e(__('identity_verification.hurray')); ?></h5>
                        <p><?php echo e(__('identity_verification.complete_verification')); ?></p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="tb-dhb-mainheading <?php echo e(!empty($verify_reject_reason) ? 'mt-4' : ''); ?> ">
                <h2><?php echo e(__('identity_verification.heading')); ?></h2>
            </div>
            <div class="tk-project-wrapper">
                <div class="tk-profile-form">
                    <form class="tk-themeform" id="tb_identity_save">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group form-group-half">
                                    <label class="tk-label tk-required"><?php echo e(__('identity_verification.name')); ?></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['identity_verification.name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="identity_verification.name" name="name" placeholder="<?php echo e(__('identity_verification.name')); ?>" />
                                    <?php $__errorArgs = ['identity_verification.name'];
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
                                <div class="form-group form-group-half">
                                    <label class="tk-label tk-required"><?php echo e(__('identity_verification.contact_number')); ?></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['identity_verification.contact_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="identity_verification.contact_no" name="contact_no" placeholder="<?php echo e(__('identity_verification.contact_number')); ?>" />
                                    <?php $__errorArgs = ['identity_verification.contact_no'];
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
                                    <label class="tk-label tk-required"><?php echo e(__('identity_verification.identity_number')); ?></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['identity_verification.identity_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="identity_verification.identity_no" name="identity_no" placeholder="<?php echo e(__('identity_verification.identity_number')); ?>" />
                                    <?php $__errorArgs = ['identity_verification.identity_no'];
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
                                    <label class="tk-label tk-required"><?php echo e(__('identity_verification.address')); ?></label>
                                    <textarea class="form-control <?php $__errorArgs = ['identity_verification.address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="identity_verification.address" name="address" placeholder="<?php echo e(__('identity_verification.address')); ?>"></textarea>
                                    <?php $__errorArgs = ['identity_verification.address'];
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
                            </div>
                        </fieldset>
                    </form>
                    <div class="tk-customupload">
                        <div class="tk-attechment-content">
                            <div x-data="{ dropFile: false }" class="tk-draganddropwrap form-group">
                                <div class="tk-draganddrop <?php $__errorArgs = ['identity_verification.attachments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                x-bind:class="dropFile ? 'tk-opacity' : ''"
                                x-on:drop="dropFile = false"
                                wire:drop.prevent="$emit('file-dropped', $event)"
                                x-on:dragover.prevent="dropFile = true"
                                x-on:dragleave.prevent="dropFile = false">
                                    <svg><rect width="100%" height="100%"></rect></svg>
                                    <input class="tk-drag-imagearea"  type="file" id="at_upload_files" accept="<?php echo e(!empty($allowFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowFileExt))  : '*'); ?>" multiple wire:change="$emit('file-dropped', {'dataTransfer' : { files :  $event.target.files}})" />
                                    <div class="tk-dragfile">
                                        <div class="tk-fileareaitem">
                                            <img src="<?php echo e(asset('images/image-uploader.jpg')); ?>" alt="">
                                        </div>
                                        <div class="tk-filearea">
                                        

                                            <div class="text-center <?php echo e(!$isUploading ? 'd-none' : ''); ?>" ><span class="fw-normal"><?php echo e(__('general.uploading')); ?></span></div>
                                            <div class="text-center tk-text-flex <?php echo e($isUploading ? 'd-none' : ''); ?>"  wire:target="files" >
                                                <span><?php echo e(__('general.uploading_desc')); ?></span>
                                                <label class="tk-drag-label" for="at_upload_files"> <em><?php echo e(__('general.click_here')); ?></em></label>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $__errorArgs = ['files.*'];
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
                            <?php if($existingFiles): ?>
                                <ul class="tk-uploadlist">
                                    <?php $__currentLoopData = $existingFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if( getType($single) == 'string' ): ?>
                                    <?php  
                                        $fileName = basename($single);
                                        $fileExt = pathinfo($single, PATHINFO_EXTENSION);
                                        $imageFileExtension = ['jpg','jpeg','gif','png'];
                                        $filePath = 'images/file-preview.png';

                                        if( in_array( $fileExt, $imageFileExtension ) && file_exists('storage/'.$single) ){
                                            $filePath = 'storage/'.$single;
                                        }

                                    ?>
                                        <li>
                                            <div class="tk-uploaditem">
                                                <div class="tk-uploaddetail">
                                                    <img src="<?php echo e(asset($filePath)); ?>" alt="">
                                                    <span><?php echo e($fileName); ?></span>
                                                </div>
                                                <a href="javascript:;" wire:click.prevent="removeFile(<?php echo e($key); ?>)"><i class="icon-trash-2"></i></a>
                                            </div>
                                        </li>
                                    <?php else: ?> 
                                            <li>
                                                <div class="tk-uploaditem">
                                                    <div class="tk-uploaddetail">
                                                        <img src="<?php echo e(substr($single->getMimeType(), 0, 5) == 'image' ? $single->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="">
                                                        <span><?php echo e($single->getClientOriginalName()); ?></span>
                                                    </div>
                                                    <a href="javascript:;" wire:click.prevent="removeFile(<?php echo e($key); ?>)"><i class="icon-trash-2"></i></a>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <?php $__errorArgs = ['identity_verification.attachments'];
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
                </div>
                <div class="tk-profileform__holder">
                    <div class="tk-dhbbtnarea">
                        <em><?php echo __('identity_verification.button_desc'); ?></em>
                        <a href="javascript:void(0);" wire:click.prevent="updateIdentification" class="tb-btn tb_identity_verification"><?php echo __('general.send_now'); ?></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
	</div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/profile-settings/identity-verification.blade.php ENDPATH**/ ?>