<main class="tk-main-two tk-main-bg">
    <section class="tk-main-section">
        <div class="preloader-outer" wire:loading>
            <div class="tk-preloader">
                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
            </div>
        </div>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-7">
                    <div class="tk-project-wrapper">
                        <div class="tk-project-box">
                            <div class="tk-checkout-title">
                                <h4><?php echo e(__('checkout.checkout_heading')); ?></h4>
                            </div>
                            <form class="tk-themeform">
                                <fieldset>
                                    <div class="tk-themeform__wrap">
                                        <div class="form-group form-group-half">
                                            <label class="tk-label tk-required"><?php echo e(__('checkout.frist_name')); ?></label>
                                            <div class="tk-placeholderholder">
                                                <input type="text" wire:model.defer="first_name" placeholder="<?php echo e(__('checkout.first_name_palceholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            </div>
                                            <?php $__errorArgs = ['first_name'];
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
                                            <label class="tk-label tk-required"><?php echo e(__('checkout.last_name')); ?></label>
                                            <div class="tk-placeholderholder">
                                                <input type="text" wire:model.defer="last_name" class="form-control tk-themeinput <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('checkout.last_name_palceholder')); ?>">
                                            </div>
                                            <?php $__errorArgs = ['last_name'];
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
                                            <label class="tk-label"><?php echo e(__('checkout.company_label')); ?></label>
                                            <div class="tk-placeholderholder">
                                                <input type="text"wire:model.defer="company" placeholder="<?php echo e(__('checkout.company_placeholder')); ?>" class="form-control tk-themeinput">
                                            </div>
                                        </div>
                                        <div class="form-group-half form-group_vertical">
                                            <label class="tk-label tk-required"><?php echo e(__('checkout.country_lablel')); ?></label>
                                            <div class="<?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <div class="tk-select" wire:ignore >
                                                    <select name="pro-country" class="tk-select2" id="tk-country" data-placeholder="<?php echo e(__('profile_settings.country_palceholder')); ?>" data-placeholderinput="<?php echo e(__('general.search')); ?>">
                                                        <option label="<?php echo e(__('profile_settings.country_palceholder')); ?>"></option>
                                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php echo e($country['id'] == $country_id ? 'selected' : ''); ?> value="<?php echo e($country['id']); ?>" ><?php echo e($country['name']); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                    </select>
                                                </div>
                                            </div>
                                            <?php $__errorArgs = ['country_id'];
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

                                        <div class="form-group-half form-group_vertical">
                                            <label class="tk-label tk-required"><?php echo e(__('checkout.state_lablel')); ?></label>
                                            <div class="<?php $__errorArgs = ['state_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <div class="tk-select">
                                                    <select name="pro-country" class="tk-select2" id="tk-states" data-placeholder="<?php echo e(__('checkout.state_placeholder')); ?>" data-placeholderinput="<?php echo e(__('general.search')); ?>">
                                                        <?php if( $has_states ): ?>
                                                            <option label="<?php echo e(__('checkout.state_placeholder')); ?>"></option>
                                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option <?php echo e($state['id'] == $state_id ? 'selected' : ''); ?> value="<?php echo e($state['id']); ?>" ><?php echo e($state['name']); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php $__errorArgs = ['state_id'];
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
                                            <label class="tk-label tk-required"><?php echo e(__('checkout.zipcode_label')); ?></label>
                                            <div class="tk-placeholderholder">
                                                <input type="text" wire:model.defer="postal_code" class="form-control tk-themeinput <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('checkout.zipcode_placeholder')); ?>">
                                            </div>
                                            <?php $__errorArgs = ['postal_code'];
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
                                            <label class="tk-label tk-required"><?php echo e(__('checkout.address_label')); ?></label>
                                            <div class="tk-placeholderholder">
                                                <input type="text"wire:model.defer="address" placeholder="<?php echo e(__('checkout.address_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            </div>
                                            <?php $__errorArgs = ['address'];
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
                                            <label class="tk-label tk-required"><?php echo e(__('checkout.city_label')); ?></label>
                                            <div class="tk-placeholderholder">
                                                <input type="text" wire:model.defer="city" placeholder="<?php echo e(__('checkout.city_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" >
                                            </div>
                                            <?php $__errorArgs = ['city'];
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
                                            <label class="tk-label tk-required"><?php echo e(__('checkout.phone_label')); ?></label>
                                            <div class="tk-placeholderholder">
                                                <input type="tel" wire:model.defer="phone" placeholder="<?php echo e(__('checkout.phone_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            </div>
                                            <?php $__errorArgs = ['phone'];
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
                                            <label class="tk-label tk-required"><?php echo e(__('checkout.email_label')); ?></label>
                                            <div class="tk-placeholderholder">
                                                <input type="email" wire:model.defer="email" placeholder="<?php echo e(__('checkout.email_placeholder')); ?>" class="form-control tk-themeinput <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            </div>
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
                                </fieldset>
                            </form>
                        </div>
                        <div class="tk-project-box">
                            <div class="tk-projectbtns">
                                <span><?php echo __('checkout.submit_form_desc',['privacy_policy_url'=> '<a href="javascript:void(0)">'. __("checkout.privacy_policy").' </a>' ]); ?></span>
                                <a href="javascript:;"  class="checkout tk-btn-solid-lg-lefticon"><?php echo e(__('checkout.continue_btn')); ?><i class="icon-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <aside class="tk-status-holder">
                        <div class="tk-ordersumery-title">
                            <h4><?php echo e(__('checkout.order_summary')); ?></h4>
                        </div>
                        <div class="tk-ordersumery-content">
                            <?php if( !empty($project_data['project_title']) ): ?>
                                <span><?php echo e(__('checkout.project_title')); ?></span>
                                <strong><?php echo e($project_data['project_title']); ?></strong>
                            <?php elseif(!empty($package_data['package_title'])): ?>  
                                <span><?php echo e(__('checkout.package_name')); ?></span>
                                <strong><?php echo e($package_data['package_title']); ?></strong> 
                            <?php elseif(!empty($gig_data['gig_title'])): ?>  
                                <span><?php echo e(__('checkout.gig_name')); ?></span>
                                <strong><?php echo e($gig_data['gig_title']); ?></strong>  
                            <?php endif; ?>
                        </div>
                        <div class="tk-ordersumery-content">
                            <span><?php echo e(__('checkout.order_detail')); ?></span>
                            <ul class="tk-order-detail">
                                <?php if( !empty($project_data) ): ?>
                                    <?php if( $project_data['payout_type'] == 'milestone' ): ?>
                                        <li>
                                            <h6><?php echo e($project_data['milestone_title']); ?></h6>
                                            <span><?php echo e(getPriceFormat($currency_symbol, $project_data['milestone_price'])); ?></span>
                                        </li>
                                    <?php elseif( $project_data['payout_type'] == 'hourly' ): ?>
                                        <li>
                                            <h6><?php echo e($project_data['timecard_title'] .' '. __('general.hourly_timecard')); ?></h6>
                                            <span><?php echo e(getPriceFormat($currency_symbol, $project_data['timecard_price'])); ?></span>
                                        </li>   
                                    <?php else: ?>
                                        <li>
                                            <h6><?php echo e(__('checkout.proposal_amount')); ?></h6>
                                            <span><?php echo e(getPriceFormat($currency_symbol, $project_data['proposal_amount'])); ?></span>
                                        </li>
                                    <?php endif; ?>

                                    <li class="tk-total-amount">
                                        <h5><?php echo e(__('checkout.total')); ?></h5>
                                        <?php if( $project_data['payout_type'] == 'milestone' ): ?>
                                            <?php
                                                $total = $project_data['milestone_price'];
                                            ?>
                                            <span><?php echo e(getPriceFormat($currency_symbol, $project_data['milestone_price'])); ?></span>
                                        <?php elseif($project_data['payout_type'] == 'hourly'): ?>
                                            <?php
                                                $total = $project_data['timecard_price'];
                                            ?>
                                            <span><?php echo e(getPriceFormat($currency_symbol, $project_data['timecard_price'])); ?></span>
                                        <?php elseif( !empty($project_data['proposal_amount']) ): ?>
                                            <?php
                                                $total = $project_data['proposal_amount'];
                                            ?>
                                            <span><?php echo e(getPriceFormat($currency_symbol, $project_data['proposal_amount'])); ?></span>
                                        <?php endif; ?>
                                    </li>
                                <?php elseif( !empty($package_data) ): ?>
                                    <?php
                                        $total = $package_data['package_price'];
                                    ?> 
                                    <li>
                                        <h6><?php echo e(__('checkout.package_price')); ?></h6>
                                        <span><?php echo e(getPriceFormat($currency_symbol, $package_data['package_price'])); ?></span>
                                    </li>
                                <?php elseif( !empty($gig_data) ): ?> 
                                    <li>
                                        <h6><?php echo e(__('checkout.gig_plan_type')); ?></h6>
                                        <span><?php echo e($gig_data['plan_type']); ?></span>
                                    </li>
                                    <li>
                                        <h6><?php echo e(__('checkout.gig_plan_price')); ?></h6>
                                        <span><?php echo e(getPriceFormat($currency_symbol, $gig_data['plan_price'])); ?></span>
                                    </li>
                                    <?php
                                        $total = $gig_data['plan_price'];
                                    ?>
                                    <?php if(!empty($gig_data['gig_addons'])): ?>
                                        <hr>
                                        <li>
                                            <h6><?php echo e(__('checkout.gig_addons')); ?></h6>
                                        </li>
                                        <hr>
                                        <?php $__currentLoopData = $gig_data['gig_addons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $total +=$single['price']; 
                                            ?>
                                            <li>
                                                <h6><?php echo e($single['title']); ?></h6>
                                                <span><?php echo e(getPriceFormat($currency_symbol, $single['price'])); ?></span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                    <?php endif; ?>      
                                    <li class="tk-total-amount">
                                        <h5><?php echo e(__('checkout.total')); ?></h5>
                                        <span><?php echo e(getPriceFormat($currency_symbol, $total)); ?></span>
                                    </li>  
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php if( !empty($available_payment_methods) ): ?>
                            <div class="tk-payment-methods tk-checkoutsummary">
                                <ul class="tk-priorityradio">
                                    <?php $__currentLoopData = $available_payment_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="tk-paymentoption">
                                            <div class="tk-form-checkbox">
                                                <input class="form-check-input tk-form-check-input-sm selected_payment_method" wire:model="payment_method"  type="radio" id="radio-<?php echo e($key); ?>" <?php echo e($payment_method == 'key' ? 'checked' : ''); ?>    value="<?php echo e($key); ?>"   />
                                                <label class="form-check-label" for="radio-<?php echo e($key); ?>" class="tb-radiolist">
                                                    <img src="<?php echo e(asset('images/payment_methods/'.$key.'.png')); ?>" >
                                                    <span class="tb-prioritymain"><?php echo e(ucfirst($key)); ?> </span>
                                                </label>
                                            </div>
                                            <?php if( $payment_method == 'stripe' ): ?>
                                                <div class="tb-cardinfo">
                                                    <input class="StripeElement form-control card_holder_name"  placeholder="<?php echo e(__('checkout.card_holder_name')); ?>" required>                             
                                                    <div id="card-element"></div>
                                                    <div class="tk-errormsg card-errors d-none">
                                                        <span></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if( $wallet_balance ): ?>
                                        <li class="tk-wallet-option">
                                            <div class="tk-switchservice">
                                                <span><?php echo e(__('checkout.use_wallet_amt')); ?> (<?php echo e(getPriceFormat($currency_symbol, $wallet_balance)); ?>)</span>
                                                <div class="tk-onoff">
                                                    <input type="checkbox" id="use-wallet-bal" />
                                                    <label for="use-wallet-bal">
                                                        <em><i></i></em>
                                                        <span class="tk-enable"></span><span class="tk-disable"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <?php $__errorArgs = ['payment_method'];
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
                        <?php endif; ?>
                    </aside>
                </div>
            </div>
        </div>   
    </section>
    <!-- checkout info -->
</main>
<?php $__env->startPush('styles'); ?>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a !important;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
<?php $__env->stopPush(); ?> 
<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
<script defer src="https://js.stripe.com/v3/"></script>
<script>
     document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.processed', (message, component) => {
            $('#tk-states').select2( { allowClear: true, });
            iniliazeSelect2Scrollbar();
            $('#tk-states').on('change', function (e) {
                let country = $('#tk-states').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('state_id', country, true);
            });
        })
    });
    
    document.addEventListener('livewire:load', function () {

        let stripe = '';
        let StripePaymentMethod = null;
        let card = '';
        let stripe_client_secret = '';
        let use_wallet = false;

        setTimeout(() => {
            jQuery('.tk-select2').each(function(index, item) {
                let _this = jQuery(this);
                _this.select2( { allowClear: true, });
            });
            iniliazeSelect2Scrollbar(); 
        }, 500);

        $(document).on('change','#tk-country',function (e) {
            let country = $('#tk-country').select2("val");
            window.livewire.find('<?php echo e($_instance->id); ?>').set('country_id', country);
        });

        $(document).on('change','#tk-states', function (e) {
            let state = $('#tk-states').select2("val");
            window.livewire.find('<?php echo e($_instance->id); ?>').set('state_id', state, true);
        });

        $(document).on('change','#use-wallet-bal', function (e) {
            if ( $(this).prop('checked') ){
                window.livewire.find('<?php echo e($_instance->id); ?>').set('use_wallet_bal', true, true);
                use_wallet = true;
            }else{
                window.livewire.find('<?php echo e($_instance->id); ?>').set('use_wallet_bal', false, true);
                use_wallet = false;
            }
        });

        window.addEventListener('initStateDropdown', event => { 
            $('#tk-states').select2( { allowClear: true, });
        });

        function initializeStripe(id){
            stripe_client_secret = id;
            stripe = Stripe("<?php echo e(config('app.stripe_key')); ?>")
            let elements = stripe.elements();
            let style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
            card = elements.create('card', {style: style})
            card.mount('#card-element');
        }
        
        window.addEventListener('initializeStripe', event => { 
            initializeStripe(event.detail.client_secret);
        });
        

        $(document).on('click', '.checkout', function(event) {

            event.stopPropagation();
            let _this = $(this);
            method =  $("input:radio.selected_payment_method:checked").val();

            let wallet_balance  = Number('<?php echo e($wallet_balance); ?>');
            let total           = Number('<?php echo e($total); ?>');
            if(use_wallet && wallet_balance >= total ){
                method = 'wallet';
            }
            if( method == 'stripe' ){

                $('.preloader-outer').css('display','block');
                _this.attr('disabled', true);

                stripe.confirmCardSetup(
                    stripe_client_secret,
                    {
                        payment_method: {
                            card: card,
                            billing_details: {name: $('.card_holder_name').val()}
                        }
                    }
                ).then(function (result) {
                    if (result.error) {
                        $('.card-errors span').text(result.error.message)
                        $('.card-errors').removeClass('d-none');
                        _this.removeAttr('disabled')
                        $('.preloader-outer').css('display','none');
                    }else{
                        $('.card-errors').addClass('d-none');
                        StripePaymentMethod = result.setupIntent.payment_method
                        window.livewire.find('<?php echo e($_instance->id); ?>').set('stripe_payment_method', StripePaymentMethod, true);
                        window.livewire.find('<?php echo e($_instance->id); ?>').call('checkout');
                    }
                });
            }else{
                window.livewire.find('<?php echo e($_instance->id); ?>').call('checkout');
            }
        });
       
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/components/checkout.blade.php ENDPATH**/ ?>