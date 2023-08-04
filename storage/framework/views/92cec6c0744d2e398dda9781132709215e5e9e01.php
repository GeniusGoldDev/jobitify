<form class="tk-themeform tk-uploadfile-doc">
    <fieldset>
        <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
            <div class="form-group tb-gigradiobox">
                <div class="tb-radio">
                    <input id="revision" type="radio" wire:model.defer="type" name="record_type" value="revision" >
                    <label for="revision"><?php echo e(__('gig.revision')); ?></label>
                </div>
                <div class="tb-radio">
                    <input type="radio" id="finalgig" wire:model.defer="type" name="record_type" value="final" >
                    <label for="finalgig"><?php echo e(__('gig.final')); ?></label>
                </div>
            </div>
        <?php endif; ?>
        <div class="tk-freelanerinfo form-group">
            <h6><?php echo e(__('gig.upload_gig_docs')); ?></h6>
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
                    <span><?php echo e(__('settings.uploading')); ?> </span>
                </div>
                <div class="tk-uploadphoto" wire:loading.remove wire:target="activity_files">
                    <p><?php echo e(__('gig.gig_docs_description')); ?></p>
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
                <b wire:loading wire:target="updateActivity"> <?php echo e(__('general.sending')); ?> </b>
                <b wire:loading.remove wire:target="updateActivity"><?php echo e(__('general.send_now')); ?> </b>
            </a>
        </div>
    </fieldset>
</form><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-activity-conversation-form.blade.php ENDPATH**/ ?>