
<section class=" tk-testimonial <?php echo e($block_key); ?> <?php echo e($custom_class); ?>" <?php if(!empty($feedback_bg)): ?> style="background-image: url(<?php echo e(asset($feedback_bg)); ?>)" <?php endif; ?> <?php if(!$site_view): ?>  wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?>>
	<?php if( !empty($style_css) ): ?>
        <style><?php echo e('.'.$block_key.$style_css); ?></style>
    <?php endif; ?>	
	<div class="tk-sectionclr-holder tk-working-sectionbg"  wire:loading.class="tk-section-preloader">
		<?php if(!$site_view): ?>
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
        <?php endif; ?>
		<div class="container">
			<div class="row justify-content-center">
				<?php if(!empty($sub_title) || !empty($title) || !empty($description) ): ?>
					<div class="col-xl-8">
						<div class="tk-main-title-holder text-center">
							<?php if(!empty($sub_title) || !empty($title) ): ?>
								<div class="tk-maintitle">
									<?php if(!empty($sub_title)): ?><h3 class="tk-colorwhite"><?php echo $sub_title; ?></h3><?php endif; ?>
									<?php if(!empty($title)): ?><h2><?php echo $title; ?></h2> <?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if(!empty($description)): ?>
								<div class="tk-main-description">
									<p><?php echo e($description); ?></p>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if(!empty($feedback_users)): ?>
					<div class="col-sm-12">
						<div class="swiper tk-feedback tk-feedback-two tk-swiperdots">
							<div class="swiper-wrapper">
								<?php $__currentLoopData = $feedback_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="swiper-slide" >
										<div class="tk-slider-content">
											<div class="tk-slider-user">
												<?php if(!empty($user['image'])): ?><img src="<?php echo e(asset($user['image'])); ?>" alt="image"> <?php endif; ?>
												<div class="tk-slideruser-info">
													<?php if(!empty($user['name'])): ?> <h5><?php echo $user['name']; ?> </h5> <?php endif; ?>
													<?php if(!empty($user['address'])): ?><a href="javascript:void(0)"><?php echo $user['address']; ?></a> <?php endif; ?>
												</div>
											</div>
											<?php if(!empty($user['description'])): ?><p><?php echo $user['description']; ?></p> <?php endif; ?>
											<div class="tk-ratting">
												<?php if(isset($user['rating'])): ?><strong> Excellent <?php echo e($user['rating']); ?> <span>out of 5</span> </strong> <?php endif; ?>
												<?php if(!empty($user['rating']) && $user['rating'] > 0 ): ?>
													<ul class="tk-ratingstars">
														<?php for( $i = 1; $i <= $user['rating']; $i++): ?>
															<li class="tk-starfill">
																<i class="fa fa-star"></i>
															</li>
														<?php endfor; ?>
													</ul>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
							<div class="swiper-pagination"></div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php $__env->startPush('styles'); ?>
	<?php echo app('Illuminate\Foundation\Vite')([
        'public/pagebuilder/css/swiper-bundle.min.css', 
    ]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
	<script defer src="<?php echo e(asset('pagebuilder/js/swiper-bundle.min.js')); ?>"></script>
	<script>
		document.addEventListener('livewire:load', function () {
			initSipwer();
		});
		
		function initSipwer(){
		  	var tk_swiper = document.querySelector('.tk-feedback')
				if(tk_swiper !== null){
					var swiper = new Swiper(".tk-feedback", {
						slidesPerView: 1,
						spaceBetween: 24,
						freeMode: true,
						pagination: {
							el: ".swiper-pagination",
							clickable: true,
						},
						breakpoints: {
							480: {
							slidesPerView: 1,
							spaceBetween: 24
							},
							767: {
							slidesPerView: 1,
							spaceBetween: 24
							},
							991: {
							slidesPerView: 2,
							spaceBetween: 24
							},
							1199: {
							slidesPerView: 3,
							spaceBetween: 24
							},
						}
					});
				}
		}
		
	</script>
<?php $__env->stopPush(); ?>

<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/user-feedback-block.blade.php ENDPATH**/ ?>