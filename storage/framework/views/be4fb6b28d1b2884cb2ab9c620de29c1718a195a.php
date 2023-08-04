
<section class="tk-hiring-section <?php echo e($block_key); ?> <?php echo e($custom_class); ?>" <?php if(!empty($hiring_process_bg)): ?> style="background-image: url(<?php echo e(asset($hiring_process_bg)); ?>)" <?php endif; ?> <?php if(!$site_view): ?> wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?>>
	<div class="tk-sectionclr-holder tk-hiring-process" <?php if(!$site_view): ?> wire:loading.class="tk-section-preloader" <?php endif; ?>>
		<?php if( !empty($style_css) ): ?>
			<style><?php echo e('.'.$block_key.$style_css); ?></style>
		<?php endif; ?>
		<?php if(!$site_view): ?>
			<div class="preloader-outer" wire:loading>
				<div class="tk-preloader">
					<img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
				</div>
			</div>
		<?php endif; ?>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-8">
					<div class="tk-main-title-holder text-center">
						<div class="tk-maintitle">
							<?php if(!empty($video_link)): ?>
								<a class="tk-hiring-vidobtn venoboxvid tk-themegallery vbox-item" data-vbtype="video" data-ratio="4x3" data-gall="gall-video" href="<?php echo e($video_link); ?>" data-autoplay="true">
									<i class="fas fa-play"></i>
								</a>
							<?php endif; ?>
							<?php echo $heading; ?>

						</div>
						<div class="tk-main-description">
							<p><?php echo $description; ?></p>
						</div>
					</div>
					<ul class="tk-mainbtnlist tk-mainlist-two pt-0">
						<li><a href="<?php echo e(route('search-sellers')); ?>" class="tk-btn-solid-lg tk-btn-yellow"><?php echo $talent_btn_txt; ?></a></li>
						<li><a href="<?php echo e(route('search-projects')); ?>" class="tk-btn-line-lg tk-btn-plain"><?php echo $work_btn_txt; ?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $__env->startPush('styles'); ?>
	<?php echo app('Illuminate\Foundation\Vite')([
        'public/pagebuilder/css/venobox.min.css', 
    ]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
	<script defer src="<?php echo e(asset('pagebuilder/js/venobox.min.js')); ?>"></script>
	<script>
		document.addEventListener('livewire:load', function () {
			initVenoBox();
		});
		
		function initVenoBox(){
			let venobox = document.querySelector(".tk-themegallery");
			if (venobox !== null) {
				jQuery(".tk-themegallery").venobox({
					spinner : 'cube-grid',
				});
			}
		}
		
	</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/hiring-process-block.blade.php ENDPATH**/ ?>