<div class="col-lg-8 col-xl-9" wire:key="seller-portfolio-setting">
	<div class="tb-dhb-profile-settings">
		<div class="tb-dhb-mainheading">
			<h2><?php echo e(__('profile_settings.portfolio_settings')); ?></h2>
		</div>
		<?php if( $allowSocialLinks == 'enable' && !empty(availableSocialLinks()) ): ?>
			<div class="tk-project-wrapper">
				<div class="tb-tabtasktitle">
					<h5><?php echo e(__('profile_settings.social_links_heading')); ?></h5>
				</div>
				<div class="tk-profile-form">
					<form class="tk-themeform">
						<fieldset>
							<div class="tk-themeform__wrap">
								<?php $__currentLoopData = availableSocialLinks(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $links): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="form-group-half form-group_vertical">
										<label class="tk-label"><?php echo e($links['name']); ?></label>
										<input type="text" class="form-control <?php $__errorArgs = ['socialLinks.'.$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> " wire:model.defer="socialLinks.<?php echo e($key); ?>" placeholder="<?php echo e($links['placeholder']); ?>" />
										<?php $__errorArgs = ['socialLinks.'.$key];
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
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="tk-profileform__holder">
					<div class="tk-dhbbtnarea">
						<em><?php echo __('profile_settings.button_desc'); ?></em>
						<a href="javascript:void(0);" wire:click.prevent="updateSocialLinks" class="tk-btn-solid-lg"><?php echo __('profile_settings.save_button'); ?></a>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
		<div class="tk-project-wrapper">
			<div class="tb-tabtasktitle tb-tabtasktitletwo">
				<h5><?php echo e(__('profile_settings.portfolio_settings')); ?>

					<a href="javascript:void(0);" data-type="add" class="tk_show_education" wire:click.prevent="showPortfolioPopup"> <?php echo e(__('profile_settings.add_education')); ?> </a>
				</h5>
			</div>
			<?php if(! $portfolios->isEmpty() ): ?>
				<div class="tk-project-box">
						<div class="tk-portfolios-list">
							<?php $__currentLoopData = $portfolios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $portfolio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.portfolio-item','data' => ['data' => $portfolio,'enableEdit' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('portfolio-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($portfolio),'enableEdit' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
		</div>

		<div wire:ignore.self class="modal fade tb-addonpopup" id="tk_portfolio_detail" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="tb-popuptitle">
						<h4> <?php echo e($isEdit ? __('profile_settings.edit_protfolio_title') : __('profile_settings.add_protfolio_title')); ?> </h4>
						<a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
					</div>

					<div class="modal-body" id="tk_add_education_frm">
						<form class="tk-themeform" id="tb_update_education">
							<fieldset>
								<div class="form-group">
									<label class="tk-label tk-required"><?php echo e(__('profile_settings.portfolio_title_label')); ?></label>
									<input type="text" wire:model.defer="portfolio.title" class="form-control <?php $__errorArgs = ['portfolio.title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('profile_settings.portfolio_title_placeholder')); ?>" autocomplete="off">
									<?php $__errorArgs = ['portfolio.title'];
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
									<label class="tk-label tk-required"><?php echo e(__('profile_settings.portfolio_url_label')); ?></label>
									<input type="text" wire:model.defer="portfolio.url" class="form-control <?php $__errorArgs = ['portfolio.url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('profile_settings.portfolio_url_placeholder')); ?>" autocomplete="off">
									<?php $__errorArgs = ['portfolio.url'];
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
									<label class="tk-label"><?php echo e(__('profile_settings.portfolio_desc_label')); ?></label>
									<textarea class="form-control" wire:model.defer="portfolio.description" placeholder="<?php echo e(__('profile_settings.portfolio_desc_placeholder')); ?>"></textarea>
								</div>

								<div class="form-group">
									<div x-data="{ dropFile: false }" class="tk-draganddropwrap tk-freelanerinfo form-group">
										<div class="tk-draganddrop"
										x-bind:class="dropFile ? 'tk-opacity' : ''"
											x-on:drop="dropFile = false"
											wire:drop.prevent="$emit('portfolio-dropped-file', $event)"
											x-on:dragover.prevent="dropFile = true"
											x-on:dragleave.prevent="dropFile = false">
											<svg><rect width="100%" height="100%"></rect></svg>
											<input class="tk-drag-imagearea" type="file" id="at_prtf_upload_files" accept="<?php echo e(!empty($allowImageExt) ?  join(',', array_map(function($ex){return('.'.$ex);}, $allowImageExt)) : '*'); ?>" wire:change="$emit('portfolio-dropped-file', {'dataTransfer' : { files :  $event.target.files}})" />
											<div class="tk-dragfile">
												<div class="tk-fileareaitem">
													<img src="<?php echo e(asset('images/image-uploader.jpg')); ?>" alt="">
												</div>
												<div class="tk-filearea">
													<div class="text-center" wire:loading wire:target="portfolioFiles" ><span class="fw-normal"><?php echo e(__('general.uploading')); ?></span></div>
													<div class="tk-text-flex" wire:loading.remove  wire:target="portfolioFiles" ><span><?php echo e(__('general.upload_portfolio_photo')); ?></span>
													<label class="tk-drag-label" for="at_prtf_upload_files"> <em><?php echo e(__('general.click_here')); ?></em></label>
												</div>
											</div>
										</div>
									</div>

									<?php $__errorArgs = ['portfolioFiles.*'];
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
									<?php if($prtExistingFiles): ?>
										<ul class="tk-uploadlist">
											<?php $__currentLoopData = $prtExistingFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
															<a href="javascript:;" wire:click.prevent="removePortfolioFile('<?php echo e($key); ?>')"><i class="icon-trash-2"></i></a>
														</div>
													</li>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</ul>
									<?php endif; ?>
								</div>
								<div class="form-group">
									<div class="tk-savebtn">
										<a href="javascript:void(0);" id="edit_education" wire:click.prevent="updatePortFolio" class="tb-btn"><?php echo e(__('profile_settings.save_degree_btn')); ?></a>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/profile-settings/portfolio-settings.blade.php ENDPATH**/ ?>