
<section <?php if(!$site_view): ?>  wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?> class="tk-main-section-two tk-main-sectionv2 tk-categoriessection <?php echo e($block_key); ?> <?php echo e($custom_class); ?>">
    <?php if( !empty($style_css) ): ?>
        <style><?php echo e('.'.$block_key.$style_css); ?></style>
    <?php endif; ?>
    <div  class="container" wire:loading.class="tk-section-preloader">
        <?php if(!$site_view): ?>
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <?php if(!empty($title) || !empty($sub_title) || !empty($description)): ?>
                <div class="col-lg-10 col-xl-8">
                    <div class="tk-title-centerv2">
                        <?php if(!empty($title) || !empty($sub_title)): ?>
                            <div class="tk-maintitlev2">
                                <?php if(!empty($title)): ?><span><?php echo $title; ?></span> <?php endif; ?>
                                <?php if(!empty($sub_title)): ?><h2><?php echo $sub_title; ?></h2> <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($description)): ?>
                            <div class="tk-main-description">
                                <p><?php echo $description; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if( !empty($categories) && !$categories->isEmpty() ): ?>
                <div class="col-lg-12">
                    <div class="tk-category_list">
                        <ul>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="tk-category_item">
                                    <?php  
                                        $image_url  = 'images/default-img-306x200.png'; 
                                        if ( !empty($single->image) ){
                                            $image = @unserialize($single->image);
                                            if( $image == 'b:0;' || $image !== false ){
                                                $file_path      = $image['file_path'];
                                                $image_sizes    = !empty($image['sizes']) ? $image['sizes'] : null;
                                                $image_url      = !empty($image_sizes['306x200']) ? 'storage/'.$image_sizes['306x200'] : 'storage/'.$file_path;
                                            }
                                        }
                                    ?>
                                 

                                    <figure class="tk-category_img">
                                        <img data-src="<?php echo e(asset($image_url)); ?>" alt="<?php echo e($single->name); ?>" <?php if(!$site_view): ?> src="<?php echo e(asset($image_url)); ?>" <?php endif; ?> >
                                    </figure>
                                    <div class="tk-category_info">
                                        <h5><a href="javascript:;"><?php echo $single->name; ?></a></h5>
                                    </div>
                                    <?php if( !$single->children->isEmpty() ): ?>
                                        <ul class="tk-category_childlist">
                                            <?php $__currentLoopData = $single->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <a href="<?php echo e(route('search-projects', ['category' => $child->slug])); ?>" target="_blank">
                                                        <span><?php echo $child->name; ?></span>
                                                        <em>(<?php echo e($child->children_count); ?>)</em>
                                                        <i class="icon-chevron-right"></i>
                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <li class="tk-explore-features">
                                                <strong>
                                                    <a href="<?php echo e(route('search-projects', ['category' => $single->slug])); ?>" target="_blank"><?php echo e(__('pages.explore_all')); ?></a>
                                                </strong>
                                            </li>
                                        </ul>
                                    <?php endif; ?> 
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php if(!empty($explore_btn_txt)): ?>
                            <div class="tk-btn2-wrapper">
                                <a href="<?php echo e(route('search-projects')); ?>" target="_blank" class="tk-btn-solid-lg tk-btn-yellow"><?php echo e($explore_btn_txt); ?> <i class="icon icon-grid"></i></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
   <?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/categories-block.blade.php ENDPATH**/ ?>