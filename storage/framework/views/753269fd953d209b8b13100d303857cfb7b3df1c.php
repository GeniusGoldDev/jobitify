<div class="container <?php echo e($block_key); ?> <?php echo e($custom_class); ?>" <?php if(!$site_view): ?> wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?>>
    <?php if( !empty($style_css) ): ?>
        <style><?php echo e('.'.$block_key.$style_css); ?></style>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-xl-10">
        <div class="tk-question-section">
            <?php if(!empty($sub_title) || !empty($title) || !empty($description)): ?>
                <div class="tk-faq-search_title">
                    <?php if( !empty($sub_title) ): ?><h5><?php echo $sub_title; ?></h5><?php endif; ?>
                    <?php if( !empty($title) ): ?><h2><?php echo $title; ?></h2><?php endif; ?>
                    <?php if( !empty($description) ): ?>
                        <div class="tk-question_desc">
                            <p><?php echo $description; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#submitquestion" class="tk-btn-solid-lg tk-btn-yellow"><?php echo $submit_btn_txt; ?> <i class="icon-edit-3"></i> </a>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade tk-submitquestion " id="submitquestion" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="tk-popup_title">
            <h5><?php echo e(__('pages.submit_question_title')); ?></h5>
            <a href="javascrcript:void(0)" data-bs-dismiss="modal">
                <i class="icon-x"></i>
            </a>
        </div>

            <div class="modal-body tk-popup-content">
                <form class="tk-themeform">
                    <fieldset>
                        <div class="tk-themeform__wrap tk-themeform__wrapv2">
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <label class="tk-required"><?php echo e(__('pages.full_name_label')); ?></label>
                                    <input type="text" wire:model.defer="full_name" placeholder="<?php echo e(__('pages.full_name_plc_hldr')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['full_name'];
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
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <label class="tk-required"><?php echo e(__('pages.email_label')); ?></label>
                                    <input type="email" wire:model.defer="email" placeholder="<?php echo e(__('pages.email_plc_hldr')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['email'];
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
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <label class="tk-required"><?php echo e(__('pages.question_subject_label')); ?></label>
                                    <input type="text" wire:model.defer="question" placeholder="<?php echo e(__('pages.question_subj_plc_hldr')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['question'];
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
                            
                            <div class="form-group">
                                <div class="tk-placeholderholder">
                                    <label class="tk-required"><?php echo e(__('pages.desc_label')); ?></label>
                                    <textarea wire:model.defer="question_desc" placeholder="<?php echo e(__('pages.desc_plc_hldr')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['question_desc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
                                    <?php $__errorArgs = ['question_desc'];
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
                            <div class="tk-popup-terms form-group">
                                <div class="tk-form-checkbox">
                                    <input wire:model.defer="accept_terms_cond" class="form-check-input form-check-input-lg" type="checkbox" value="" id="tk-check">
                                    <label class="form-check-label tk-required" for="tk-check">
                                    <span> <?php echo e(__('pages.agreement_desc')); ?> <a href="#"><?php echo __('pages.terms_condition'); ?></a></span>
                                    </label>
                                </div>
                                <?php $__errorArgs = ['accept_terms_cond'];
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
                                <a href="javascript:;" wire:loading.class="tk-pointer-events-none" wire:click.prevent="sendQuestiontest" class="tk-btn-solid-lg">
                                    <span class="tk-waiting" wire:loading wire:target="sendQuestiontest"> <?php echo e(__('general.waiting')); ?> </span>
                                    <span wire:loading.remove wire:target="sendQuestiontest"><?php echo e(__('pages.submit_question')); ?> <i class="icon-arrow-right"></i> </span>
                                </a>
                            </div>
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
            window.addEventListener('submitquestion-modal', event => {
                $('#submitquestion').modal(event.detail.modal);
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/send-question-block.blade.php ENDPATH**/ ?>