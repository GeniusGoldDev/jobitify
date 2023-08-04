<div class="col-lg-8 col-xl-9" wire:key="billing-information">
	<div class="tb-dhb-profile-settings">
		<div class="tb-dhb-mainheading">
			<h2><?php echo e(__('billing_info.heading')); ?></h2>
		</div>
		<div class="tk-project-wrapper">
			<div class="tk-profile-form">
				<form class="tk-themeform" id="tb_billing_info">
					<fieldset>
						<div class="tk-themeform__wrap">
							<div class="form-group form-group-half">
								<label class="tk-label tk-required"><?php echo e(__('billing_info.first_name')); ?></label>
								<input type="text" class="form-control  <?php $__errorArgs = ['billing_info.first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="billing_info.first_name" name="first_name" placeholder="<?php echo e(__('billing_info.first_name_placeholder')); ?>" />
								<?php $__errorArgs = ['billing_info.first_name'];
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
								<label class="tk-label tk-required"><?php echo e(__('billing_info.last_name')); ?></label>
								<input type="text" class="form-control <?php $__errorArgs = ['billing_info.last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="billing_info.last_name" name="last_name" placeholder="<?php echo e(__('billing_info.last_name_placeholder')); ?>" />
								<?php $__errorArgs = ['billing_info.last_name'];
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
								<label class="tk-label"><?php echo e(__('billing_info.company_title')); ?></label>
								<input type="text" class="form-control" wire:model.defer="billing_info.company" name="company" placeholder="<?php echo e(__('billing_info.company_placeholder')); ?>" />
							</div>
							<div class="form-group form-group-half">
								<label class="tk-label tk-required"><?php echo e(__('billing_info.country')); ?></label>
								<div class="<?php $__errorArgs = ['billing_info.country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
									<div class="tk-select" wire:ignore wire:key="<?php echo e(now()->timestamp.'_billing-country'); ?>">
										<select class="tk-select2" id="billing-country" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('billing_info.country_placeholder')); ?>" >
											<option label="<?php echo e(__('billing_info.country_placeholder')); ?>"></option>
											<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option <?php echo e($country['id'] == $billing_info['country_id'] ? 'selected' : ''); ?> value="<?php echo e($country['id']); ?>" ><?php echo e($country['name']); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
										</select>
									</div>
								</div>
								<?php $__errorArgs = ['billing_info.country_id'];
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
								<label class="tk-label tk-required"><?php echo e(__('billing_info.state')); ?></label>
								<div class="<?php $__errorArgs = ['billing_info.state_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
									<div class="tk-select">
										<select class="tk-select2" id="billing-state" data-placeholder="<?php echo e(__('billing_info.states_placeholder')); ?>" data-placeholderinput="<?php echo e(__('general.search')); ?>" >
											<?php if($has_states): ?>
												<option label="<?php echo e(__('billing_info.states_placeholder')); ?>"></option>
												<?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option <?php echo e($state['id'] == $billing_info['state_id'] ? 'selected' : ''); ?> value="<?php echo e($state['id']); ?>" ><?php echo e($state['name']); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
											<?php endif; ?>
										</select>
									</div>
								</div>
								<?php $__errorArgs = ['billing_info.state_id'];
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
								<label class="tk-label tk-required"><?php echo e(__('billing_info.address')); ?></label>
								<input type="text" class="form-control  <?php $__errorArgs = ['billing_info.address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="billing_info.address" name="address" placeholder="<?php echo e(__('billing_info.address_placeholder')); ?>" />
								<?php $__errorArgs = ['billing_info.address'];
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
								<label class="tk-label tk-required"><?php echo e(__('billing_info.city')); ?></label>
								<input type="text" class="form-control  <?php $__errorArgs = ['billing_info.city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="billing_info.city" name="city" placeholder="<?php echo e(__('billing_info.city_placeholder')); ?>" />
								<?php $__errorArgs = ['billing_info.city'];
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
								<label class="tk-label tk-required"><?php echo e(__('billing_info.postal_code')); ?></label>
								<input type="text" class="form-control  <?php $__errorArgs = ['billing_info.postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="billing_info.postal_code" name="postal_code" placeholder="<?php echo e(__('billing_info.postal_code_placeholder')); ?>" />
								<?php $__errorArgs = ['billing_info.postal_code'];
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
								<label class="tk-label tk-required"><?php echo e(__('billing_info.phone')); ?></label>
								<input type="text" class="form-control  <?php $__errorArgs = ['billing_info.phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="billing_info.phone" name="phone" placeholder="<?php echo e(__('billing_info.phone_placeholder')); ?>" />
								<?php $__errorArgs = ['billing_info.phone'];
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
								<label class="tk-label tk-required"><?php echo e(__('billing_info.email')); ?></label>
								<input type="text" class="form-control  <?php $__errorArgs = ['billing_info.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="billing_info.email" name="email" placeholder="<?php echo e(__('billing_info.email_placeholder')); ?>" />
								<?php $__errorArgs = ['billing_info.email'];
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
			<div class="tk-profileform__holder">
				<div class="tk-dhbbtnarea">
					<em><?php echo __('billing_info.button_desc'); ?></em>
					<a href="javascript:void(0);" wire:click.prevent="updateBillingInfo()" class="tk-btn-solid-lg"><?php echo __('billing_info.save_button'); ?></a>
				</div>
			</div>
		</div>
	</div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/profile-settings/billing-information.blade.php ENDPATH**/ ?>