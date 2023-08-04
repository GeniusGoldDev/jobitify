<?php 
    $userInfo   = getUserInfo();
    $user_name  = !empty($userInfo['user_name']) ? $userInfo['user_name'] : '';
    $activeMethod = [];
?>
<div class="tk-paymentways tk-project-box">
    <div class="<?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?> tk-ecrow-setup <?php endif; ?> tk-projectboxinner">
        <div class="tk-seller-details">
            <div class="tk-seller-heading">
                <div class="tk-seller-name">
                    <?php if($default_selected == 'escrow'): ?>
                        <h6><?php echo e(__('transaction.escrow')); ?></h6>
                    <?php elseif($default_selected == 'paypal'): ?>
                        <h6><?php echo e(__('transaction.paypal')); ?></h6>
                    <?php elseif($default_selected == 'payoneer'): ?>
                        <h6><?php echo e(__('transaction.payoneer')); ?></h6>
                    <?php elseif($default_selected == 'bank'): ?>
                        <h6><?php echo e(__('transaction.bank')); ?></h6>
                    <?php endif; ?>
                </div>
                <?php if( !empty($default_selected) ): ?>
                    <div class="tk-seller-logo">
                        <img src="<?php echo e(asset('images/payment_methods/'.$default_selected.'.png')); ?>">
                    </div>
                <?php endif; ?>
            </div>
            <?php if( $default_selected == 'escrow' && !empty( $payoutSettings['escrow']['escrow_email'] ) ): ?>
                <h3><?php echo e(stringInputMask( $payoutSettings['escrow']['escrow_email'] )); ?></h3>
            <?php elseif( $default_selected == 'paypal' && !empty($payoutSettings['paypal']['paypal_email']) ): ?>
                <h3><?php echo e(stringInputMask( $payoutSettings['paypal']['paypal_email'] )); ?></h3>
            <?php elseif( $default_selected == 'payoneer' && !empty($payoutSettings['payoneer']['payoneer_email']) ): ?>
                <h3><?php echo e(stringInputMask( $payoutSettings['payoneer']['payoneer_email'] )); ?></h3>
            <?php elseif( $default_selected == 'bank' && !empty($payoutSettings['bank']) ): ?>
                <h5>
                    <?php echo e(__('billing_info.bank_name') . ' : '. stringInputMask($payoutSettings['bank']['bank_name'])); ?>

                    <br>
                    <?php echo e(__('billing_info.account_number'). ' : '. stringInputMask( $payoutSettings['bank']['account_number'] )); ?>

                </h5>
            <?php endif; ?>
        </div>
        <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
            <div class="tk-withdrawamount">
                <div class="tk-themeform tk-payment-submenu">
                    <fieldset>
                        <div class="tk-themeform__wrap">
                            <div class="form-group tk-formlimit">
                                <label for="paypal_email" class="tk-label tk-required"><?php echo e(__('transaction.withdraw_amount')); ?></label>
                                <div class="tk-inputicon">
                                    <input type="number" wire:model.defer="amount" class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('transaction.withdraw_amount')); ?>" autocomplete="off">
                                    <em class="tk-maxlimitt"><?php echo e(__('transaction.max_limit')); ?>: <?php echo e($currency_symbol .number_format($available_balance, 2)); ?></em>
                                </div>
                                <?php $__errorArgs = ['amount'];
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
                </div>
            </div>
        <?php endif; ?>
        <h5><?php echo e(__('billing_info.setup_payout_methods')); ?></h5>
        <ul class="tk-payoutmethod tk-payoutmethodvtwo">
            <?php if( $method_type == 'escrow' ): ?>
                <li class="tk-radiobox">
                    <input type="radio" value="escrow" <?php if($default_selected == 'escrow' ): ?> checked <?php endif; ?> class="form-check-input tk-form-check-input-sm payout-method" name="payout-option">
                    <label class="form-check-label" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#tk-escrow" aria-expanded="false">
                        <div class="tk-payment-method">
                            <img src="<?php echo e(asset('images/payment_methods/escrow.png')); ?>">
                            <span><?php echo e(__('billing_info.escrow_heading')); ?></span>
                        </div>
                        <a class="tk-escrow-content" href="javascript:void(0)"><i class="icon-chevron-right"></i></a>
                    </label>
                </li>
                <div id="tk-escrow" wire:ignore.self class="collapse tb-stepescrow">
                    <form class="tk-themeform tk-payment-submenu">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group">
                                    <label for="escrow_email" class="tk-label tk-required"><?php echo e(__('billing_info.escrow_email_label')); ?></label>
                                    <input type="text" wire:model.defer="escrow_email" id="escrow_email" class="form-control <?php $__errorArgs = ['escrow_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('billing_info.escrow_email_placeholder')); ?>">
                                    <?php $__errorArgs = ['escrow_email'];
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
                                    <label for="escrow_email" class="tk-label tk-required"><?php echo e(__('billing_info.escrow_apikey_label')); ?></label>
                                    <input type="text" wire:model.defer="escrow_api_key" class="form-control <?php $__errorArgs = ['escrow_api_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('billing_info.escrow_apikey_placeholder')); ?>">
                                    <?php $__errorArgs = ['escrow_api_key'];
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
                                    <div class="tb-paymetdesc pt-0">
                                        <p>
                                            <em><?php echo e(__('billing_info.escrow_desc')); ?><span><?php echo e(__('billing_info.more_about')); ?> <a target="blank" href="https://www.escrow.com/"><?php echo e(__('billing_info.escrow_site')); ?></a> <span>|</span> <a target="_blank" href="https://www.escrow.com/signup-page"><?php echo e(__('billing_info.create_account')); ?></a></span></em>
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group pt-0 tk-profileform__holder w-100 text-right">
                                    <a href="javascript:void(0);" wire:click.prevent="updatePayoutMethod('escrow')" class="tk-btn-solid"><?php echo __('general.save'); ?></a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            <?php elseif($method_type == 'others'): ?>
                <li class="tk-radiobox">
                    <input type="radio" value="paypal" <?php if( $default_selected == 'paypal' ): ?> checked <?php endif; ?> class="form-check-input tk-form-check-input-sm payout-method" name="payout-option">
                    <label class="form-check-label" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#tk-paypal" aria-expanded="false">
                        <div class="tk-payment-method">
                            <img src="<?php echo e(asset('images/payment_methods/paypal.png')); ?>">
                            <span><?php echo e(__('billing_info.paypal_heading')); ?></span>
                        </div>
                        <a class="tk-escrow-content" href="javascript:void(0)"><i class="icon-chevron-right"></i></a>
                    </label>
                </li>
                <div id="tk-paypal" wire:ignore.self class="collapse tb-stepescrow">
                    <form class="tk-themeform tk-payment-submenu">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group">
                                    <label for="paypal_email" class="tk-label tk-required"><?php echo e(__('billing_info.paypal_email_label')); ?></label>
                                    <input type="text" wire:model.defer="paypal_email" id="paypal_email" class="form-control <?php $__errorArgs = ['paypal_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('billing_info.paypal_email_label')); ?>">
                                    <?php $__errorArgs = ['paypal_email'];
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
                                    <div class="tb-paymetdesc pt-0">
                                        <p>
                                            <em><?php echo __('billing_info.paypal_desc',['paypal_link' => '<a target="_blank" href="https://www.paypal.com/"> '.__('billing_info.paypal').' </a>', 'create_account' => '<a target="_blank" href="https://www.paypal.com/signup/">'.__('billing_info.create_account').'</a>'] ); ?></em>
                                        </p>
                                    </div>
                                    <div class="tk-profileform__holder w-100 text-right">
                                        <a href="javascript:void(0);" wire:click.prevent="updatePayoutMethod('paypal')" class="tk-btn-solid"><?php echo __('general.save'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <li class="tk-radiobox">
                    <input type="radio" value="payoneer" <?php if( $default_selected == 'payoneer' ): ?> checked <?php endif; ?> class="form-check-input tk-form-check-input-sm payout-method" name="payout-option">
                    <label class="form-check-label" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#tk-payoneer" aria-expanded="false">
                        <div class="tk-payment-method">
                            <img src="<?php echo e(asset('images/payment_methods/payoneer.png')); ?>">
                            <span><?php echo e(__('billing_info.payoneer_heading')); ?></span>
                        </div>
                        <a class="tk-escrow-content" href="javascript:void(0)"><i class="icon-chevron-right"></i></a>
                    </label>
                </li>
                <div id="tk-payoneer" wire:ignore.self class="collapse tb-stepescrow">
                    <form class="tk-themeform tk-payment-submenu">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group">
                                    <label for="payoneer_email" class="tk-label tk-required"><?php echo e(__('billing_info.payoneer_email_label')); ?></label>
                                    <input type="email" wire:model.defer="payoneer_email" id="payoneer_email" class="form-control <?php $__errorArgs = ['payoneer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('billing_info.payoneer_email_label')); ?>">
                                    <?php $__errorArgs = ['payoneer_email'];
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
                                    <div class="tb-paymetdesc pt-0">
                                        <p>
                                            <em><?php echo __('billing_info.payoneer_desc',['payoneer_link' => '<a target="_blank" href="https://www.payoneer.com/"> '.__('billing_info.payoneer_heading').' </a>', 'create_account' => '<a target="_blank" href="https://www.payoneer.com/accounts/">'.__('billing_info.create_account').'</a>'] ); ?></em>
                                        </p>
                                    </div>
                                    <div class="tk-profileform__holder w-100 text-right">
                                        <a href="javascript:void(0);" wire:click.prevent="updatePayoutMethod('payoneer')" class="tk-btn-solid"><?php echo __('general.save'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <li class="tk-radiobox">
                    <input type="radio" value="bank" <?php if($default_selected == 'bank' ): ?> checked <?php endif; ?> class="form-check-input tk-form-check-input-sm payout-method" name="payout-option">
                    <label class="form-check-label" wire:ignore.self data-bs-toggle="collapse" data-bs-target="#tk-bank" aria-expanded="false">
                        <div class="tk-payment-method">
                            <img src="<?php echo e(asset('images/payment_methods/bank.png')); ?>">
                            <span><?php echo e(__('billing_info.bank_heading')); ?></span>
                        </div>
                        <a class="tk-escrow-content" href="javascript:void(0)"><i class="icon-chevron-right"></i></a>
                    </label>
                </li>
                <div id="tk-bank" wire:ignore.self class="collapse tb-stepescrow">
                    <form class="tk-themeform tk-payment-submenu">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="form-group">
                                    <label for="bank_title" class="tk-label tk-required"><?php echo e(__('billing_info.account_title')); ?></label>
                                    <input type="text" wire:model.defer="bankAccountInfo.title" id="bank_title" class="form-control <?php $__errorArgs = ['bankAccountInfo.title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('billing_info.account_title')); ?>">
                                    <?php $__errorArgs = ['bankAccountInfo.title'];
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
                                    <label for="bank_account_number" class="tk-label tk-required"><?php echo e(__('billing_info.account_number')); ?></label>
                                    <input type="text" wire:model.defer="bankAccountInfo.account_number" id="bank_account_number" class="form-control <?php $__errorArgs = ['bankAccountInfo.account_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('billing_info.account_number')); ?>">
                                    <?php $__errorArgs = ['bankAccountInfo.account_number'];
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
                                    <label for="bank_name" class="tk-label tk-required"><?php echo e(__('billing_info.bank_name')); ?></label>
                                    <input type="text" wire:model.defer="bankAccountInfo.bank_name" id="bank_name" class="form-control <?php $__errorArgs = ['bankAccountInfo.bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('billing_info.bank_name')); ?>">
                                    <?php $__errorArgs = ['bankAccountInfo.bank_name'];
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
                                    <label for="routing_number" class="tk-label tk-required"><?php echo e(__('billing_info.routing_number')); ?></label>
                                    <input type="text" wire:model.defer="bankAccountInfo.routing_number" id="routing_number" class="form-control <?php $__errorArgs = ['bankAccountInfo.routing_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('billing_info.routing_number')); ?>">
                                    <?php $__errorArgs = ['bankAccountInfo.routing_number'];
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
                                    <label for="bank_iban" class="tk-label tk-required"><?php echo e(__('billing_info.bank_iban')); ?></label>
                                    <input type="text" wire:model.defer="bankAccountInfo.bank_iban" id="bank_iban" class="form-control <?php $__errorArgs = ['bankAccountInfo.bank_iban'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('billing_info.bank_iban')); ?>">
                                    <?php $__errorArgs = ['bankAccountInfo.bank_iban'];
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
                                    <label for="bank_bic_swift" class="tk-label tk-required"><?php echo e(__('billing_info.bank_bic_swift')); ?></label>
                                    <input type="text" wire:model.defer="bankAccountInfo.bank_bic_swift" id="bank_bic_swift" class="form-control <?php $__errorArgs = ['bankAccountInfo.bank_bic_swift'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('billing_info.bank_bic_swift')); ?>">
                                    <?php $__errorArgs = ['bankAccountInfo.bank_bic_swift'];
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
                                    <div class="tk-profileform__holder w-100 text-right">
                                        <a href="javascript:void(0);" wire:click.prevent="updatePayoutMethod('bank')" class="tk-btn-solid"><?php echo __('general.save'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            <?php endif; ?>
            <?php $__errorArgs = ['payout_type'];
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
        </ul>
    </div>
    <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'seller')): ?>
        <a href="javascript:void(0)" wire:click.prevent="withdraw" wire:loading.class="tk-pointer-events-none" class="tk-withdraw-button tk-withdrawamt">
            <b wire:loading wire:target="withdraw"> <?php echo e(__('general.waiting')); ?> </b>
            <b wire:loading.remove wire:target="withdraw"><?php echo e(__('transaction.withdraw_now')); ?> </b>
        </a>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:load', function () {
            $('.payout-method').on('click', function (e) {
                window.livewire.find('<?php echo e($_instance->id); ?>').set('payout_type', $(this).val(), true);
            });

            $(document).on('click', '.tk-payoutmethod .form-check-label', function(){
                let _this = $(this);
                if( _this.attr('aria-expanded') == 'true') {
                    _this.closest('.tk-radiobox').addClass('tk-expanded');
                } else {
                    _this.closest('.tk-radiobox').removeClass('tk-expanded');
                }
            })
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/components/seller-payout-methods.blade.php ENDPATH**/ ?>