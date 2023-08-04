
<section class="tk-main-section-two tk-main-sectionv2 tk-projectsection <?php echo e($block_key); ?> <?php echo e($custom_class); ?>" <?php if(!$site_view): ?> wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?>>
	<?php if( !empty($style_css) ): ?>
		<style><?php echo e('.'.$block_key.$style_css); ?></style>
	<?php endif; ?>
	<div class="container" wire:loading.class="tk-section-preloader">
		<?php if(!$site_view): ?>
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
        <?php endif; ?>
		<div class="row justify-content-center">
			<?php if(!empty($sub_title) || !empty($title) || !empty($explore_btn_txt)): ?>
				<div class="col-sm-12">
					<div class="tk-main-title-holder">
						<?php if(!empty($sub_title) || !empty($title)): ?>
							<div class="tk-maintitle">
								<?php if(!empty($sub_title)): ?><h3><?php echo $sub_title; ?></h3> <?php endif; ?>
								<?php if(!empty($title)): ?><h2><?php echo $title; ?></h2><?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if(!empty($explore_btn_txt)): ?>
							<div class="tk-btn2-wrapper">
								<a href="<?php echo e(route('search-projects')); ?>" class="tk-sectionbtn"><?php echo $explore_btn_txt; ?><i class="icon icon-grid"></i></a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if(!empty($projects)): ?>
				<div class="col-xl-12">
					<?php if(!$projects->isEmpty()): ?>
						<?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="tk-project-wrapper-two">
								<?php if($single->is_featured): ?>
									<span data-tippy-content="<?php echo e(__('settings.featured_project')); ?>" class="tk-featureditem tippy">
										<i class="icon icon-zap"></i>
									</span>
								<?php endif; ?>
								<div class="tk-projectlisting">
									<div class="tk-price-holder">
										<div class="tk-project-img">
											<?php if(!empty($single->projectAuthor->image)): ?> 
												<?php  
													$image_path     = getProfileImageURL( $single->projectAuthor->image, '130x130' );
													$author_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-130x130.png';
												?> 
												<img data-src="<?php echo e(asset($author_image)); ?>" alt="">
											<?php else: ?> 
												<img data-src="<?php echo e(asset('images/default-user-130x130.png')); ?>" alt="">
											<?php endif; ?>
										</div>
										<div class="tk-verified-info">
											<a href="javascript:void(0)">
												<?php echo e($single->projectAuthor->full_name); ?>

												<i class="icon-check-circle tk-theme-tooltip tippy" data-tippy-content="<?php echo e(__('general.verified_user')); ?>"></i>
											</a>
											

											<h5><?php echo e($single->project_title); ?></h5>
											<ul class="tk-template-view">
												<li>
													<i class="icon-calendar"></i>
													<span> <?php echo e(__('project.project_posted_date',['diff_time'=> getTimeDiff( $single->updated_at )])); ?> </span>
												</li>
												<li>
													<i class="icon-map-pin"></i>
													<span> <?php echo e($single->projectLocation->id == 3 ? (!empty($single->address) ? getUserAddress($single->address, $address_format) : $single->project_country ) : $single->projectLocation->name); ?> </span>
												</li>
												<li>
													<i class="icon-briefcase"></i>
													<span> <?php echo e(!empty($single->expertiseLevel) ? $single->expertiseLevel->name : ''); ?> </span>
												</li>
												<li>
													<i class="<?php echo e($single->project_hiring_seller > 1 ? 'icon-users' : 'icon-user'); ?>"></i>
													<span><?php echo e($single->project_hiring_seller .' '. ($single->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer'))); ?></span>
												</li>
												
											</ul>
										</div>
										<div class="tk-price">
											<span> <?php echo e($single->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_price')); ?></span>
											<h4><?php echo e(getProjectPriceFormat($single->project_type, $currency_symbol, $single->project_min_price, $single->project_max_price)); ?></h4>
											<div class="tk-project-option">
												<a href="<?php echo e(route('project-detail', ['slug'=> $single->slug] )); ?>" target="_blank" class="tk-invite-bidbtn"><?php echo e(__('project.view_detail')); ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
				
		</div>
	</div>
</section>

<?php $__env->startPush('scripts'); ?>
	<script defer src="<?php echo e(asset('common/js/popper-core.js')); ?>"></script>
	<script defer src="<?php echo e(asset('common/js/tippy.js')); ?>"></script>
	<script>
        window.onload = (event) => {
        	jQuery(document).ready(function() {
				let tb_tippy = document.querySelector(".tippy");
                if (tb_tippy !== null) {
                    tippy(".tippy", {
                        animation: "scale",
                    });
                }
			});
		}
	</script>
<?php $__env->stopPush(); ?>
   <?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/projects-block.blade.php ENDPATH**/ ?>