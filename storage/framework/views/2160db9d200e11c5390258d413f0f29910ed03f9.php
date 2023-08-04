<div class="row" wire:key="<?php echo e(time()); ?>">
    <?php echo $__env->make('livewire.gig.gig-creation-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-lg-9">
        <div class="tk-project-wrapper tk-gigstep_3">
            <div class="tk-project-box">
                <div class="tk-sectiontitle">
                    <h4><?php echo e(__('gig.media_attachment')); ?></h4>
                </div>
                <form class="tk-themeform">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                            <div x-data="{ dropFile: false }" class="tk-draganddropwrap tk-freelanerinfo form-group">
                                <div class="tk-draganddrop"
                                x-bind:class="dropFile ? 'tk-opacity' : ''"
                                x-on:drop="dropFile = false"
                                wire:drop.prevent="$emit('file-dropped', $event)"
                                x-on:dragover.prevent="dropFile = true"
                                x-on:dragleave.prevent="dropFile = false">
                                <input class="tk-drag-imagearea" name="file" type="file" id="at_upload_files" accept="<?php echo e(!empty($allowImgFileExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImgFileExt)) : '*'); ?>" multiple wire:change="$emit('file-dropped', {'dataTransfer' : { files :  $event.target.files}})" />
            
                                    <svg class="tk-drag-gallery"><rect width="100%" height="100%"></rect></svg>
                                    <div class="tk-dragfile">
                                        <div class="tk-fileareaitem">
                                            <img src="<?php echo e(asset('images/image-uploader.jpg')); ?>" alt="">
                                        </div>
                                        <div class="tk-filearea">
                                            <div wire:loading wire:target="galleryFiles" class="text-center">
                                                <span  ><?php echo e(__('settings.uploading')); ?> </span>
                                            </div>
                                            <div wire:loading.remove wire:target="galleryFiles" class="text-center tk-text-flex">
                                                <span><?php echo e(__('gig.uploading_desc')); ?></span>
                                                <label class="tk-drag-label" for="at_upload_files"><em><?php echo e(__('general.click_here')); ?></em></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php $__errorArgs = ['galleryFiles.*'];
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
                            <?php if($galleryExistingFiles): ?>
                                <ul class="tk-uploadlist">
                                    <?php $__currentLoopData = $galleryExistingFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <div class="tk-uploaditem">
                                                <div class="tk-uploaddetail">
                                                    <?php if(method_exists($single,'getMimeType')): ?>
                                                        <img src="<?php echo e(substr($single->getMimeType(), 0, 5) == 'image' ? $single->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($single->getClientOriginalName()); ?>">
                                                    <?php else: ?>
                                                        <img src="<?php echo e(substr($single->mime_type, 0, 5) == 'image' ? asset('storage/'.$single->file_path) : asset('images/file-preview.png')); ?>" alt="<?php echo e($single->file_name); ?>">
                                                    <?php endif; ?>
                                                    <span><?php echo e(method_exists($single,'getClientOriginalName') ? $single->getClientOriginalName() : $single->file_name); ?></span>
                                                </div>
                                                <a href="javascript:;" wire:click.prevent="removeGalleryFile('<?php echo e($key); ?>')"><i class="icon-trash-2"></i></a>
                                            </div>
                                        </li>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="tk-label"> <?php echo e(__('gig.add_video_link')); ?></label>
                                <div class="tk-placeholderholder">
                                    <input type="url" wire:model.defer="video_url" placeholder="<?php echo e(__('gig.video_link_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                </div>
                                <?php $__errorArgs = ['video_url'];
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
                                <div class="tk-form-checkbox">
                                    <input id="downloadable" type="checkbox" class="form-check-input form-check-input-lg" <?php echo e($downloadable ? 'checked' : ''); ?> value="1" wire:model.defer="downloadable">
                                    <label for="downloadable" class="form-check-label">
                                        <span> <?php echo e(__('gig.downloadable')); ?>  </span>
                                    </label>
                                </div>
                            </div>
                            <div class="downloadable-files <?php echo e(!$downloadable ? 'd-none' : ''); ?>">
                                <div x-data="{ dropFile: false }" class="tk-draganddropwrap tk-freelanerinfo form-group">
                                    <div class="tk-draganddrop"  
                                    x-bind:class="dropFile ? 'tk-opacity' : ''"
                                    x-on:drop="dropFile = false"
                                    wire:drop.prevent="$emit('download-file-dropped', $event)"
                                    x-on:dragover.prevent="dropFile = true"
                                    x-on:dragleave.prevent="dropFile = false">
                                        <svg><rect width="100%" height="100%"></rect></svg>
                                        <input class="tk-drag-imagearea" name="file" type="file" id="at_upload_downloadable" multiple wire:change="$emit('download-file-dropped', {'dataTransfer' : { files :  $event.target.files}})" />
                                        <div class="tk-dragfile">
                                            <div class="tk-fileareaitem">
                                                <img src="<?php echo e(asset('images/image-uploader.jpg')); ?>" alt="">
                                            </div>
                                            <div class="tk-filearea">
                                                <div wire:loading wire:target="downloadFiles" class="text-center">
                                                    <span  ><?php echo e(__('settings.uploading')); ?> </span>
                                                </div>
                                                <div wire:loading.remove wire:target="downloadFiles" class="text-center tk-text-flex">
                                                    <span><?php echo e(__('gig.uploading_desc')); ?> </span>
                                                    <label class="tk-drag-label" for="at_upload_downloadable"><em><?php echo e(__('general.click_here')); ?></em></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?php $__errorArgs = ['downloadFiles.*'];
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
                                <?php if($downloadExistingFiles): ?>
                                    <ul class="tk-uploadlist">
                                        <?php $__currentLoopData = $downloadExistingFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <div class="tk-uploaditem">
                                                    <div class="tk-uploaddetail">
                                                        <?php if(method_exists($single,'getMimeType')): ?>
                                                            <img src="<?php echo e(substr($single->getMimeType(), 0, 5) == 'image' ? $single->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($single->getClientOriginalName()); ?>">
                                                        <?php else: ?>
                                                            <img src="<?php echo e(substr($single->mime_type, 0, 5) == 'image' ? asset('storage/'.$single->file_path) : asset('images/file-preview.png')); ?>" alt="<?php echo e($single->file_name); ?>">
                                                        <?php endif; ?>
                                                        <span><?php echo e(method_exists($single,'getClientOriginalName') ? $single->getClientOriginalName() : $single->file_name); ?></span>
                                                    </div>
                                                    <a href="javascript:;" wire:click.prevent="removedownloadFiles('<?php echo e($key); ?>')"><i class="icon-trash-2"></i></a>
                                                </div>
                                            </li>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>        
                    </fieldset>        
                </form>        
            </div>
            <div class="tk-project-box">
                <div class="tk-projectbtns">
                    <a href="javascript:;" wire:click.prevent="updateStep(2)" class="tk-btnline"><i class=" icon-chevron-left"></i><?php echo e(__('gig.go_back')); ?></a>
                    <a href="javascript:;" wire:click.prevent="updateStep( <?php echo e($step + 1); ?> )"  class="tk-btn-solid-lg-lefticon">
                        <?php echo e(__('gig.continue')); ?>

                        <i class="icon-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-step3.blade.php ENDPATH**/ ?>