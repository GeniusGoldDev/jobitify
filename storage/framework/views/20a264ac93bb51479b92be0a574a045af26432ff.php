<div class="col-lg-8 col-xl-9" wire:key="profile-settings">
	<div class="tk-dhb-mainheading">
		<h2><?php echo e(__('profile_settings.profile_settings')); ?></h2>
	</div>
	<div class="tk-project-wrapper">
		<div class="tk-project-box">
			<div class="tk-employerproject-title">
				<div class="tk-uploadprofilepic">
					<figure>
						<div wire:loading wire:target="profile_settings.image"><?php echo e(__('general.uploading')); ?> </div>
						<?php if(!empty($cropImageUrl)): ?>
							<img src="<?php echo e($cropImageUrl); ?>" alit="" > 
						<?php elseif(!empty($old_image)): ?>
							<?php 
								$file_url = getProfileImageURL($old_image, '120x120');
							?>
							<img src="<?php echo e(asset('storage/'.$file_url)); ?>" alt="">
						<?php else: ?> 
							<img src="<?php echo e(asset('images/default-user-120x120.png')); ?>" alt="">
						<?php endif; ?>
					</figure>
					<div wire:ignore class="tk-freelancer-content-two">
						<h4><?php echo e(__('profile_settings.upload_photo')); ?></h4>
						<p><?php echo __('profile_settings.upload_photo_desc', ['image_ext'=> join(', ', $allowImageExt), 'image_size'=> $allowImageSize.'MB']); ?></p>
						<div class="tk-uploadbtnpic">
							<div class="tk-uploadbtn">
								<label for="upload_image" class="tk-btn tk-btn-small">
										<input id="upload_image" type="file" accept="<?php echo e(!empty($allowImageExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImageExt)) : '*'); ?>" >
										<?php echo __('profile_settings.upload_photo_btn'); ?>

								</label>
							</div>
							<a href="javascript:void(0);" wire:click.prevent="removePhoto" class="tk-btn tk-btn-small tk-btnlight"><?php echo e(__('settings.remove')); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if( $userRole == 'seller' ): ?>
			<div class="tk-project-box">
				<div class="tk-employerproject-title">
					<div class="tk-uploadprofilepic">
						<figure>
							<div class="tk-hasloader d-none"  wire:loading.class.remove="d-none" wire:loading.flex wire:target="banner">
								<div class="spinner-border" role="status">
									<span class="visually-hidden"><?php echo e(__('general.uploading')); ?></span>
								</div>
							</div>
							<?php if(!empty($banner) && method_exists($banner,'temporaryUrl')): ?>
								<img src="<?php echo e(substr($banner->getMimeType(), 0, 5) == 'image' ? $banner->temporaryUrl() : asset('images/file-preview.png')); ?>" alt="<?php echo e($banner->getClientOriginalName()); ?>">
							<?php elseif(!empty($old_banner)): ?>
								<?php 
										$banner_path = $old_banner['file_path'] ?? '';
										$banner_name = $old_banner['file_name'] ?? '';
								?>
								<img src="<?php echo e(asset('storage/'.$banner_path)); ?>" alt="<?php echo e($banner_name); ?>">
							<?php else: ?> 
								<img src="<?php echo e(asset('images/default-img.jpg')); ?>" alt="">
							<?php endif; ?>
						</figure>
						<div class="tk-freelancer-content-two">
							<h4><?php echo e(__('profile_settings.profile_banner')); ?></h4>
							<p><?php echo __('profile_settings.profile_banner_desc', ['image_ext'=> join(', ', $allowImageExt), 'image_size'=> $allowImageSize.'MB']); ?></p>
							<div class="tk-uploadbtnpic">
								<div class="tk-uploadbtn">
									<label for="upload_banner" class="tk-btn tk-btn-small">
											<input id="upload_banner" wire:model="banner" type="file" accept="<?php echo e(!empty($allowImageExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImageExt)) : '*'); ?>" >
											<?php echo __('profile_settings.upload_photo_btn'); ?>

									</label>
								</div>

								<?php if( ( !empty($banner) && method_exists($banner,'temporaryUrl') ) || !empty($old_banner) ): ?>
									<a href="javascript:void(0);" wire:click.prevent="removeBanner" class="tk-btn tk-btn-small tk-btnlight"><?php echo e(__('settings.remove')); ?></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="tk-profile-form">
			<form class="tk-themeform" id="tb_save_settings">
				<fieldset>
					<div class="tk-themeform__wrap">
						<div class="form-group-half form-group_vertical">
							<label class="tk-label tk-required"><?php echo e(__('profile_settings.first_name')); ?></label>
							<input type="text" class="form-control <?php $__errorArgs = ['profile_settings.first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> " wire:model.defer="profile_settings.first_name" name="first_name" placeholder="<?php echo e(__('profile_settings.first_name_palceholder')); ?>" />
							<?php $__errorArgs = ['profile_settings.first_name'];
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
							<label class="tk-label tk-required"><?php echo e(__('profile_settings.last_name')); ?></label>
							<input type="text" class="form-control <?php $__errorArgs = ['profile_settings.last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="profile_settings.last_name" name="last_name" placeholder="<?php echo e(__('profile_settings.last_name_palceholder')); ?>" />
							<?php $__errorArgs = ['profile_settings.last_name'];
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
						<div class="form-group form-group_vertical">
							<label class="tk-label"><?php echo e(__('profile_settings.tagline')); ?></label>
							<input type="text" class="form-control" wire:model.defer="profile_settings.tagline" name="tagline" />
						</div>						
						<div class="form-group-half form-group_vertical">
							<label class="tk-label tk-required"><?php echo e(__('profile_settings.country')); ?></label>
							<div class="<?php $__errorArgs = ['profile_settings.country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
								<div class="tk-select" wire:ignore wire:key="<?php echo e(now()->timestamp.'_profile_country'); ?>">
									<select name="pro-country" class="tk-select2" id="tk-country" data-placeholder="<?php echo e(__('profile_settings.country_palceholder')); ?>" data-placeholderinput="<?php echo e(__('general.search')); ?>">
										<option label="<?php echo e(__('profile_settings.country_palceholder')); ?>"></option>
										<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option <?php echo e($country['name'] == $profile_settings['country'] ? 'selected' : ''); ?> value="<?php echo e($country['name']); ?>" ><?php echo e($country['name']); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
									</select>
								</div>
							</div>
							<?php $__errorArgs = ['profile_settings.country'];
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
							<label class="tk-label tk-required"><?php echo e(__('profile_settings.zipcode')); ?></label>
							<input type="text" class="form-control <?php $__errorArgs = ['profile_settings.zipcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.defer="profile_settings.zipcode" name="zipcode" placeholder="<?php echo e(__('profile_settings.zipcode_palceholder')); ?>" />
							<?php $__errorArgs = ['profile_settings.zipcode'];
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
						<?php if( $userRole == 'seller' ): ?>
							<div class="form-group-half form-group_vertical">
								<label class="tk-label tk-required"><?php echo e(__('general.seller_type')); ?></label>
								<div class="<?php $__errorArgs = ['profile_settings.seller_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
									<div class="tk-select" wire:ignore wire:key="pro-sellertype_id">
										<select name="seller_type" data-placeholder="<?php echo e(__('profile_settings.seller_type_placeholder')); ?>" data-placeholderinput="<?php echo e(__('general.search')); ?>" class="tk-select2" id="pro_sellertype">
											<option label="<?php echo e(__('profile_settings.seller_type_placeholder')); ?>"></option>
											<?php $__currentLoopData = $seller_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type_key => $seller_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option <?php echo e($seller_type == $profile_settings['seller_type'] ? 'selected' : ''); ?> value="<?php echo e($seller_type); ?>" ><?php echo e($seller_type); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
										</select>
									</div>
								</div>
								<?php $__errorArgs = ['profile_settings.seller_type'];
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
								<label class="tk-label tk-required"><?php echo e(__('general.english_level')); ?></label>
								<div class="<?php $__errorArgs = ['profile_settings.english_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
									<div class="tk-select" wire:ignore wire:key="profile_english_level">
										<select name="pro-english_level" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('profile_settings.english_level_placeholder')); ?>" class="tk-select2" id="pro_english_level">
											<option label="<?php echo e(__('profile_settings.english_level_placeholder')); ?>"></option>
											<?php $__currentLoopData = $english_levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option <?php if($profile_settings['english_level'] == $key ): ?> selected <?php endif; ?> value="<?php echo e($key); ?>" > <?php echo e($level); ?> </option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
									</div>
								</div>
								<?php $__errorArgs = ['profile_settings.english_level'];
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
	
						<?php if($userRole == 'seller' ): ?>
							<div class="form-group form-group_vertical">
								<label class="tk-label"><?php echo e(__('profile_settings.skills')); ?></label>
								<div class="tk-select" wire:ignore wire:key="profile_skill" >
									<select data-placeholder="<?php echo e(__('profile_settings.skills_placeholder')); ?>" data-placeholderinput="<?php echo e(__('general.search')); ?>" name="skills" class="tk-select2 " id="pro_skill" data-autoclose="false" multiple>
										<option label="<?php echo e(__('profile_settings.skills_placeholder')); ?>"></option>
										<?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option <?php echo e(in_array( $skill['id'], $profile_settings['skill_ids'] )  ? 'selected' : ''); ?> value="<?php echo e($skill['id']); ?>" ><?php echo e($skill['name']); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
									</select>
								</div>
							</div>
							<div class="form-group form-group_vertical">
								<label class="tk-label"><?php echo e(__('profile_settings.languages')); ?></label>
								<div class="tk-select" wire:ignore wire:key="profile_language">
									<select name="languages" data-placeholder="<?php echo e(__('profile_settings.languages_placeholder')); ?>" class="tk-select2" id="pro_languages" data-autoclose="false" multiple>
										<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option <?php echo e(in_array($language['id'], $profile_settings['language_ids']) ? 'selected' : ''); ?> value="<?php echo e($language['id']); ?>" ><?php echo e($language['name']); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
									</select>
								</div>
							</div>
						<?php endif; ?>
						<div class="form-group form-group_vertical">
							<label class="tk-label"><?php echo e(__('profile_settings.description')); ?></label>
							<div class="tk-placeholderholder">
								<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tinymce-input','data' => ['wire:model.defer' => 'profile_settings.description','placeholder' => ''.e(__('profile_settings.desc_palceholder')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('tinymce-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.defer' => 'profile_settings.description','placeholder' => ''.e(__('profile_settings.desc_palceholder')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
							</div>
							<?php $__errorArgs = ['profile_settings.description'];
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
				<em><?php echo __('profile_settings.button_desc'); ?></em>
				<a href="javascript:void(0);" wire:click.prevent="update" class="tk-btn-solid-lg"><?php echo __('profile_settings.save_button'); ?></a>
			</div>
		</div>
	</div>
	<?php if($userRole == 'seller' ): ?>
		<!-- education list -->
		<div class="tk-project-wrapper">
			<div class="tk-project-box">
				<h5><?php echo e(__('profile_settings.education_detail')); ?>

					<a href="javascript:void(0);" data-type="add" class="tk_show_education" wire:click.prevent="addEducation"> <?php echo e(__('profile_settings.add_education')); ?> </a>
				</h5>
				<?php if(! empty($educationList) ): ?>
					<div class="tk-acordian-wrapper">
						<ul id="tk-accordioneditedu" class="tk-qualification tk-qualificationvtwo">
							<?php $__currentLoopData = $educationList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $education): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php  
									$disable_toggle = empty($education['deg_description']) ? true : false;
								?>
								<li>
									<div class="tk-accordion_title">
										<div class="tk-qualification-title  <?php if($disable_toggle): ?> tk-education-title <?php endif; ?> collapsed"  <?php if(!$disable_toggle): ?>  data-bs-toggle="collapse"  data-bs-target="#collapse-<?php echo e($education['id']); ?>" role="button" aria-expanded="false" <?php endif; ?>>
											<span><?php echo $education['deg_institue_name']; ?></span>
											<h5><?php echo $education['deg_title']; ?></h5>
											<div class="tk-ongoing-date">
												<span><?php echo date('F d, Y', strtotime($education['deg_start_date'])); ?></span>
												<i>-</i>
												<?php if( empty($education['is_ongoing']) ): ?>
													<span class="pl-1"> <?php echo date('F d, Y', strtotime($education['deg_end_date'])); ?></span>
												<?php else: ?> 
												<span><?php echo e(__('general.continue')); ?></span>
												<?php endif; ?>
											</div>
										</div>
										<a href="javascript:void(0);" class="collapsed" <?php if(!$disable_toggle): ?>  data-bs-toggle="collapse"  data-bs-target="#collapse-<?php echo e($education['id']); ?>" role="button" aria-expanded="false" <?php endif; ?>><i class="icon-plus"></i></a>
										<div class="tk-detail__icon">
											<a href="javascript:void(0);" class="tk-edit tb_show_education" wire:click.stop="editEducation(<?php echo e($education['id']); ?>)"><i class="icon-edit-2"></i></a>
											<a href="javascript:void(0);" class="tk-delete tb_remove_edu" wire:click.prevent="deleteEducationConfirm(<?php echo e($education['id']); ?>)" ><i class="icon-trash-2"></i></a>
										</div>
									</div>
									<div class="collapse" id="collapse-<?php echo e($education['id']); ?>" data-bs-parent="#tk-accordioneditedu">
										<div class="tk-accordion_info">
											<p><?php echo e($education['deg_description']); ?></p>
										</div>
									</div>
								</li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div wire:ignore.self class="modal fade tk-addonpopup" id="tb_educationaldetail" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog tk-modaldialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="tk-popuptitle">
						<h4> <?php echo e(__('profile_settings.update_education_detail')); ?> </h4>
						<a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
					</div>

					<div class="modal-body" id="tk_add_education_frm">
					<form class="tk-themeform" id="tb_update_education">
						<fieldset>
							<div class="form-group">
								<label class="tk-label tk-required"><?php echo e(__('profile_settings.add_degree_title')); ?></label>
								<input type="text" name="education-title" wire:model.defer="education_detail.deg_title" class="form-control <?php $__errorArgs = ['education_detail.deg_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('profile_settings.deg_title_placeholder')); ?>" autocomplete="off">
								<?php $__errorArgs = ['education_detail.deg_title'];
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
								<label class="tk-label"><?php echo e(__('profile_settings.add_institue_name')); ?></label>
								<input type="text" name="education-institure" wire:model.defer="education_detail.deg_institue_name" class="form-control" placeholder="<?php echo e(__('profile_settings.institue_placeholder')); ?>" autocomplete="off">
							</div>
							<div class="form-group">
								<label class="tk-label tk-required"><?php echo e(__('profile_settings.address')); ?></label>
								<input type="text" name="education-institure" wire:model.defer="education_detail.address" class="form-control" placeholder="<?php echo e(__('profile_settings.address_placeholder')); ?>" autocomplete="off">
								<?php $__errorArgs = ['education_detail.address'];
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
							<div class="form-group-wrap">
								<div class="form-group pb-0">
									<label class="tk-label mb-0"><?php echo e(__('profile_settings.choose_date')); ?></label>
								</div>
								<div class="form-group form-group-half">
									<div class="tk-calendar">
										<input id="edu_start_date_<?php echo e($dynamic_id); ?>" value="<?php echo e($education_detail['deg_start_date']); ?>" name="education_start_date" type="text" class="form-control <?php $__errorArgs = ['education_detail.deg_start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> tk-datepicker" placeholder="<?php echo e(__('profile_settings.date_from')); ?>">
									</div>
									<?php $__errorArgs = ['education_detail.deg_start_date'];
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
									<div class="tk-calendar">
										<input id="edu_end_date_<?php echo e($dynamic_id); ?>" value="<?php echo e($education_detail['deg_end_date']); ?>" name="education_end_date" type="text" class="form-control <?php $__errorArgs = ['education_detail.deg_end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> tk-datepicker" placeholder="<?php echo e(__('profile_settings.date_to')); ?>">
									</div>
									<?php $__errorArgs = ['education_detail.deg_end_date'];
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
										<input id="education_is_going" wire:model.defer="education_detail.is_ongoing" name="education_is_going" type="checkbox" class="form-check-input" placeholder="<?php echo e(__('profile_settings.isgoing')); ?>">
										<label for="education_is_going" class="form-check-label"><span><?php echo e(__('profile_settings.ongoing_txt')); ?></span></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="tk-label"><?php echo e(__('profile_settings.degree_desc')); ?></label>
								<textarea class="form-control" wire:model.defer="education_detail.deg_description" name="education_description" placeholder="<?php echo e(__('profile_settings.degree_desc_placeholder')); ?>"></textarea>
							</div>
							<div class="form-group">
								<div class="tk-savebtn">
									<a href="javascript:void(0);" id="edit_education" wire:click.prevent="updateEducation" class="tk-btn"><?php echo e(__('profile_settings.save_degree_btn')); ?></a>
								</div>
							</div>
						</fieldset>
					</form>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div wire:ignore class="modal fade tk-addonpopup" id="tk_phrofile_photo" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog tk-modaldialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="tk-popuptitle">
					<h4> <?php echo e(__('profile_settings.crop_profile_photo')); ?> </h4>
					<a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
				</div>
				<div class="modal-body" id="tk_add_education_frm">
					<div id="crop_img_area">
						<div class="preloader-outer" wire:loading="">
							<div class="tk-preloader">
								<img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
							</div>
						</div>
					</div>
					<div class="tk-form-btn">
						<div class="tk-savebtn tk-dhbbtnarea ">
							<a href="javascript:void(0);" id="croppedImage" class="tk-btn"><?php echo e(__('general.save_update')); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/profile-settings/profile-settings.blade.php ENDPATH**/ ?>