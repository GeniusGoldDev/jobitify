<section class="tk-main-section tk-opportunities-sec <?php echo e($block_key); ?> <?php echo e($custom_class); ?>"  <?php if(!$site_view): ?> wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?>>
	
	<div class="container" wire:loading.class="tk-section-preloader">
		<?php if(!$site_view): ?>
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
        <?php endif; ?>
		<div class="row align-items-center gy-4">
			<?php if(!empty($display_image)): ?>
				<div class="col-12 col-xl-6">
					<figure class="tk-motivation_img">
						<img data-src="<?php echo e(asset($display_image)); ?>">
					</figure>
				</div>
			<?php endif; ?>
			<div class="col-12 col-xl-6">
				<div class="tk-main-title-holder pb-0">
					<?php if(!empty($tagline_title) || !empty($title) ): ?>
						<div class="tk-maintitle">
							<?php if(!empty($tagline_title)): ?><h5><?php echo $tagline_title; ?></h5><?php endif; ?>
							<?php if(!empty($title)): ?><h2><?php echo $title; ?></h2><?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if(!empty($description)): ?>
						<div class="tk-main-description">
							<p><?php echo $description; ?></p>
						</div>
					<?php endif; ?>
					<?php if(!empty($points)): ?>
						<ul class="tk-motivation_list">
							<?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li><span><i class="fa fa-check"></i><?php echo $point; ?></span></li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					<?php endif; ?>
					<?php if(!empty($join_us_btn_txt) && ( !Auth::check() || $userRole == 'admin') ): ?>
						<div class="tk-btn-holder">
							<a href="<?php echo e(route('register')); ?>" class="tk-btn-yellow-lg"><?php echo $join_us_btn_txt; ?> <i class="icon-user-check"></i> </a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/opportunities-block.blade.php ENDPATH**/ ?>