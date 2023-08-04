<div class="row">
    <?php echo $__env->make('livewire.project.project-creation-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-lg-9">
        <div class="tk-sort">
            <h3><?php echo e(__('project.recommended_freelancer')); ?> </h3>
        </div>
        <?php if(!$freelancers->isEmpty()): ?>
            <ul class="tk-freelancers-list">
                <?php $__currentLoopData = $freelancers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $fav_class = '';
                        $_text = __('project.save');
                      
                        if(in_array($single->id, $favourite_sellers)){
                             $fav_class =  'bg-redheart tk-liked';
                             $_text =  __('project.saved');
                        }
                        if(!empty($single->image)){
                            $image_path     = getProfileImageURL($single->image, '100x100');
                            $seller_image   = !empty($image_path) ? 'storage/'.$image_path : 'images/default-user-100x100.png';
                        }else{
                            $seller_image   = 'images/default-user-100x100.png';
                        }
                    ?>
                    <li>
                        <div class="tk-freelancers-info">
                            <figure>
                                <img src="<?php echo e(asset($seller_image)); ?>" alt="<?php echo e($single->full_name); ?>">
                            </figure>
                            <div class="tk-freelancer-user">
                                <a target="_blank" href="<?php echo e(route('seller-profile', ['slug' => $single->slug] )); ?>"><?php echo e($single->full_name); ?></a>
                                <h5> <?php echo $single->tagline; ?> </h5>
                                <ul class="tk-blogviewdatessm">
                                    <li>
                                        <i class="fas fa-star tk-yellow"></i>
                                        <em> <?php echo e(ratingFormat( $single->ratings_avg_rating )); ?>  </em>
                                        <span>( <?php echo e($single->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($single->ratings_count) ])); ?> )</span>

                                    </li>
                                    <li>
                                        <span>
                                            <i class="icon-eye"></i> 
                                            <em>
                                                <?php echo e($single->profile_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format($single->profile_visits_count) ] )); ?>

                                            </em> 
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            <a href="javascript:void(0)" class="<?php echo e($fav_class); ?>" wire:click="favouriteSeller(<?php echo e($single->id); ?>)"><i class="icon-heart"></i> <?php echo e($_text); ?> </a>    
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-bidbtn">
                            <a target="_blank" href="<?php echo e(route('seller-profile', ['slug' => $single->slug] )); ?>"><?php echo e(__('project.view_profile')); ?></a>
                            <?php if( in_array($single->id, $invited_sellers) ): ?>
                                <a href="javascript:void(0)" disabled class="tk-invite-bidbtn"><?php echo e(__('project.invited')); ?></a>
                            <?php else: ?> 
                                <a href="javascript:void(0)" wire:click="inviteSeller(<?php echo e($single->id); ?>)" class="tk-invite-bidbtn"><?php echo e(__('project.invite_bid')); ?></a>   
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php echo e($freelancers->links('pagination.custom')); ?>

        <?php else: ?>
            <div class="tk-submitreview">
                <figure>
                    <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                </figure>
                <h4><?php echo e(__('general.no_record')); ?></h4>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/project-step4.blade.php ENDPATH**/ ?>