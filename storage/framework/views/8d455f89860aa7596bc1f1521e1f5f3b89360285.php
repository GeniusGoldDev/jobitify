<div class="<?php echo e($block_key); ?> tk-footerwrap <?php echo e($custom_class); ?>" <?php if(!$site_view): ?> wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?>>
	<?php if( !empty($style_css) ): ?>
		<style><?php echo e('.'.$block_key.$style_css); ?></style>
	<?php endif; ?>
    <!-- FOOTER START -->
	<footer class="tk-footer-two tk-footerv2" wire:loading.class="tk-section-preloader">
		<?php if(!$site_view): ?>
			<div class="preloader-outer" wire:loading>
				<div class="tk-preloader">
					<img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
				</div>
			</div>
		<?php endif; ?>
		<div class="container">
			<div class="row tk-footer-two_head">
				<div class="col-12 col-xl-4">
					<div class="tk-footer-two_info">
						<?php if( !empty($logo_image) ): ?>
                            <strong class="tk-footerlogo"><a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset($logo_image)); ?>" alt="<?php echo e(__('general.logo')); ?>" /></a></strong>
                        <?php else: ?>
                            <strong ><a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('demo-content/logo.png')); ?>" alt="<?php echo e(__('general.logo')); ?>" /></a></strong>
                        <?php endif; ?>
						<?php if(!empty($description)): ?>
							<div class="tk-description">
								<p><?php echo nl2br($description); ?></p>
							</div>
						<?php endif; ?>
						<?php if(!empty($app_store_img) || !empty($play_store_img)): ?>
							<div class="tk-footer-mobile-app">
								<?php if(!empty($mobile_app_heading)): ?>
									<div class="tk-title">
										<h3><?php echo $mobile_app_heading; ?></h3>
									</div>
								<?php endif; ?>
								<ul class="tk-socailapp">
									<?php if(!empty($app_store_img)): ?>
										<li>
											<a href="<?php echo e($app_store_url); ?>">
												<img src="<?php echo e(asset($app_store_img)); ?>" alt="<?php echo e(__('pages.app_store_alt')); ?>">
											</a>
										</li>
									<?php endif; ?>
									<?php if(!empty($play_store_img)): ?>
										<li>
											<a href="<?php echo e($play_store_url); ?>">
												<img src="<?php echo e(asset($play_store_img)); ?>" alt="<?php echo e(__('pages.play_store_alt')); ?>">
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php if(!empty($categories)): ?>
					<div class="col-12 col-xl-4">
						<div class="tk-fwidget">
							<?php if(!empty($category_heading)): ?>
								<div class="tk-fwidget_title">
									<h5><?php echo $category_heading; ?></h5>
								</div>
							<?php endif; ?>
							<ul class="tk-fwidget_list">
								<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($index > 8): ?>
										<li class="tk-showall"><a href="<?php echo e(route('search-projects')); ?>" target="_blank"><?php echo e(__('pages.show_all')); ?></a></li>
									<?php endif; ?>
									<?php if($index > 8){
											break;
										}
									?>
									<li><a href="<?php echo e(route('search-projects', ['category' => $category->slug])); ?>" target="_blank"><?php echo e($category->name); ?></a></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>
				<div class="col-12 col-xl-4">
					<div class="tk-footernewsletter tk-footernewsletterv2">
						<?php if(!empty($newsletter_heading)): ?>
							<div class="tk-fwidget_title">
								<h5><?php echo $newsletter_heading; ?></h5>
							</div>
						<?php endif; ?>
						<?php if(!empty($phone) || !empty($email) || !empty($fax) || !empty($whatsapp) ): ?>
							<ul class="tk-fwidget_contact_list">
								<?php if(!empty($phone)): ?>
									<li>
										<i class="icon icon-phone-call"></i>
										<a href="tel:<?php echo e($phone); ?>"><?php echo e($phone); ?></a>
										<?php if(!empty($phone_call_availablity)): ?>
											<span><?php echo $phone_call_availablity; ?></span>
										<?php endif; ?>
									</li>
								<?php endif; ?>
								<?php if(!empty($email)): ?>
									<li>
										<i class="icon icon-mail"></i>
										<a href="mailto:<?php echo e($email); ?>"><?php echo $email; ?></a>
									</li>
								<?php endif; ?>
								<?php if(!empty($fax)): ?>
									<li>
										<i class="icon icon-printer"></i>
										<a href="fax:<?php echo e($fax); ?>"><?php echo $fax; ?></a>
									</li>
								<?php endif; ?>
								<?php if(!empty($whatsapp)): ?>
									<li>
										<i class="fab fa-whatsapp"></i>
										<a href="whatsapp://tel:<?php echo e($whatsapp); ?>"><?php echo $whatsapp; ?></a>
										<?php if(!empty($whatsapp_call_availablity)): ?>
											<span><?php echo $whatsapp_call_availablity; ?></span>
										<?php endif; ?>
									</li>
								<?php endif; ?>
							</ul>
						<?php endif; ?>

						<?php if(!empty($facebook_link) || !empty($twitter_link) || !empty($linkedin_link) || !empty($dribbble_link)): ?>
							<ul class="tk-socialicons">
								<?php if(!empty($facebook_link)): ?>
									<li>
										<a href="<?php echo e($facebook_link); ?>" class="wk-facebook"><i class="fab fa-facebook-f"></i></a>
									</li>
								<?php endif; ?>
								<?php if(!empty($twitter_link)): ?>
									<li>
										<a href="<?php echo e($twitter_link); ?>" class="wk-twitter"><i class="fab fa-twitter"></i></a>
									</li>
								<?php endif; ?>
								<?php if(!empty($linkedin_link)): ?>
									<li>
										<a href="<?php echo e($linkedin_link); ?>" class="wk-linkedin"><i class="fab fa-linkedin-in"></i></a>
									</li>
								<?php endif; ?>
								<?php if(!empty($dribbble_link)): ?>
									<li>
										<a href="<?php echo e($dribbble_link); ?>" class="wk-dribbble"><i class="fab fa-dribbble"></i></a>
									</li>
								<?php endif; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="tk-footer-two_copyright">
			<div class="container">
				<div class="wk-fcopyright">
					<span class="wk-fcopyright_info"><?php echo e(__('general.copy_right_text').' '. date('Y')); ?></span>
					<?php if( !empty($footer_menu) && $footer_menu->count() > 0 ): ?>  
						<nav class="wk-fcopyright_list">
							<ul class="wk-copyrights-list">
								<?php $__currentLoopData = $footer_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li>
										<a href="<?php echo e(!empty($menu->route) ? url($menu->route ) : 'javascript:;'); ?>"><?php echo ucfirst($menu->label); ?></a>
									</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							</ul>
						</nav>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</footer>
	<!-- FOOTER END -->
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/footer-block.blade.php ENDPATH**/ ?>