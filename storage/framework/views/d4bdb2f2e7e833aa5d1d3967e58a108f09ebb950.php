<main class="tk-main-bg">
    <section class="tk-main-section" wire:loading.class="tk-section-preloader">
        <div class="preloader-outer" wire:loading>
            <div class="tk-preloader">
                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    <?php if(!$projects->isEmpty() && $search_project !=''): ?><h3><?php echo e($projects->count() .' '.  __('general.search_result')); ?> “<?php echo e($search_project); ?>”</h3><?php endif; ?>
                </div>
                <div class="col-xl-12">
                    <div class="tk-project-wrapper tk-template-project">
                        <div class="tk-template-serach ">
                            <h5> <?php echo e($filter_project != '' ? __('general.'.$filter_project)  :  __('project.all_projects')); ?> </h5>
                            <div class="tk-search-wrapper">
                                <div class="tk-generalsearch">
                                    <label> <?php echo e(__('general.search')); ?></label>
                                    <div class="tk-inputicon">
                                        <input type="text" wire:model.debounce.500ms="search_project" class="form-control" placeholder="<?php echo e(__('general.search_with_keyword')); ?>">
                                        <i class="icon-search"></i>
                                    </div>
                                </div>
                                <div class="tk-sort">
                                    <div class="tk-sortby" wire:ignore>
                                        <label> <?php echo e(__('project.project_type')); ?></label>
                                        <div class="tk-actionselect">
                                            <div class="tk-select">
                                                <select id="project_type"  class="form-control tk-selectprice">
                                                    <option value =""> <?php echo e(__('project.all_projects')); ?> </option>
                                                    <option value ="fixed"> <?php echo e(__('project.fixed_type')); ?> </option>
                                                    <option value ="hourly"> <?php echo e(__('project.hourly_type')); ?> </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-sort">
                                    <div class="tk-sortby" wire:ignore>
                                        <label> <?php echo e(__('project.project_status')); ?></label>
                                        <div class="tk-actionselect">
                                            <div class="tk-select">
                                                <select id="filter_project" class="form-control tk-selectprice">
                                                    <option value =""> <?php echo e(__('project.all_projects')); ?> </option>
                                                    <option value ="draft" <?php if($filter_project == 'draft'): ?> selected <?php endif; ?>> <?php echo e(__('general.draft')); ?> </option>
                                                    <option value ="pending" <?php if($filter_project == 'pending'): ?> selected <?php endif; ?>> <?php echo e(__('general.pending')); ?> </option>
                                                    <option value ="publish" <?php if($filter_project == 'publish'): ?> selected <?php endif; ?>> <?php echo e(__('general.publish')); ?> </option>
                                                    <option value ="hired" <?php if($filter_project == 'hired'): ?> selected <?php endif; ?>> <?php echo e(__('general.hired')); ?> </option>
                                                    <option value ="completed" <?php if($filter_project == 'completed'): ?> selected <?php endif; ?>> <?php echo e(__('general.completed')); ?> </option>
                                                    <option value ="rejected" <?php if($filter_project == 'rejected'): ?> selected <?php endif; ?>> <?php echo e(__('general.rejected')); ?> </option>
                                                    <option value ="cancelled" <?php if($filter_project == 'cancelled'): ?> selected <?php endif; ?>> <?php echo e(__('general.cancelled')); ?> </option>
                                                    <option value ="refunded" <?php if($filter_project == 'refunded'): ?> selected <?php endif; ?>> <?php echo e(__('general.refunded')); ?> </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(!$projects->isEmpty()): ?>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                               $tag = getTag( $single->status );
                            ?>
                            <div class="tk-project-wrapper-two">
                                <?php if($single->is_featured): ?>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.featured-tippy','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('featured-tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php endif; ?>
                                <div class="tk-buyerprojects">
                                    <div class="tk-project-box">
                                        <div class=" tk-price-holder">
                                            <div class="tk-verified-info">
                                                <div class="tk-verified-info-tags">
                                                    <span class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></span>
                                                </div>
                                                <h5><?php echo e($single->project_title); ?></h5>
                                                <ul class="tk-template-view">
                                                    <li>
                                                        <i class="icon-calendar"></i>
                                                        <span> <?php echo e(__('project.project_posted_date',['diff_time'=> getTimeDiff($single->updated_at)])); ?> </span>
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
                                            <div class="tk-price tk-tagholder">
                                            <em class="tk-project-tag-two <?php echo e($single->project_type == 'fixed' ? 'tk-ongoing-updated' : 'tk-success-tag-updated'); ?>"><?php echo e($single->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')); ?></em>
                                                <span> <?php echo e(__('project.project_budget')); ?></span>
                                                <h4><?php echo e(getProjectPriceFormat($single->project_type, $currency_symbol, $single->project_min_price, $single->project_max_price)); ?></h4>
                                            </div>
                                            <?php
                                                $open_menu = false;
                                                if(($rm_feature_project > 0 && $single->is_featured == 0) && ($single->status == 'publish' || $single->status == 'pending' )){
                                                    $open_menu = true;
                                                }elseif($single->status == 'pending' || $single->status == 'draft'){
                                                    $open_menu = true;
                                                }
                                            ?>
                                            <?php if( $open_menu ): ?>
                                                <div class="tk-projectsstatus_option">
                                                    <a href="javascript:void(0);"><i class="icon-more-horizontal"></i></a>
                                                    <ul class="tk-contract-list" style="display: none;">
                                                        <?php if(in_array($single->status,  array('publish','pending'))
                                                            && $rm_feature_project > 0
                                                            && $single->is_featured == 0): ?>
                                                            <li>
                                                                <a href="javascript:;" wire:click.prevent="makeFeature(<?php echo e($single->id); ?>)"><?php echo e(__('project.mark_feature')); ?></a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if($single->status == 'draft' || $single->status == 'pending'): ?>
                                                            <li>
                                                                <a href="javascript:;" wire:click.prevent="destroy(<?php echo e($single->id); ?>)" ><?php echo e(__('project.delete_project')); ?> </a>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if(!$single->proposals->isEmpty()): ?>
                                            <?php
                                                $hired_sellers = false;
                                                foreach($single->proposals as $proposal){
                                                    if( $proposal->status == 'hired' 
                                                        || $proposal->status == 'completed' 
                                                        || $proposal->status == 'refunded' ){
                                                        $hired_sellers = true;
                                                        break;
                                                    }
                                                }
                                            ?>
                                            <?php if( $hired_sellers ): ?>
                                                <div class="tk-freelancer-holder">
                                                    <div class="tk-tagtittle">
                                                        <span><?php echo e(__('project.hired_freelancers')); ?></span>
                                                    </div>
                                                    <ul class="tk-hire-freelancer">
                                                        <?php $__currentLoopData = $single->proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php  
                                                                $user_image = '/images/default-user-50x50.png';
                                                                if( !empty( $proposal->proposalAuthor->image) ){
                                                                    $image_path     = getProfileImageURL($proposal->proposalAuthor->image, '50x50');
                                                                    $user_image     = !empty($image_path) ? '/storage/'.$image_path : '/images/default-user-50x50.png';
                                                                }
                                                                
                                                                $status = getTag($proposal->status);
                                                            ?>
                                                            
                                                            <?php if( !in_array($proposal->status, ['publish','pending', 'declined','draft']) ): ?>
                                                                <li>
                                                                    <div class="tk-hire-freelancer_content">
                                                                        <img src="<?php echo e($user_image); ?>" alt="<?php echo e($proposal->proposalAuthor->first_name_last_letter); ?>">
                                                                        <div class="tk-hire-freelancer-info">
                                                                            <h6>
                                                                                <?php echo e($proposal->proposalAuthor->first_name_last_letter); ?>

                                                                                <?php if(!empty($proposal->sellerProjectReting->rating)): ?>
                                                                                    <span class="tk-blogviewdates">
                                                                                        <i class="fas fa-star tk-yellow"></i>
                                                                                        <em> <?php echo e(number_format($proposal->sellerProjectReting->rating,1)); ?> </em>
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                            </h6>
                                                                            <div class="tk-activity-tags-wrapper">
                                                                                <a href="<?php echo e(route('project-activity',['slug' => $single->slug,'id' => $proposal->id ])); ?>" ><?php echo e(__('project.view_activity')); ?></a>
                                                                                <?php if( $proposal->status == "completed" ): ?>
                                                                                    <?php if($proposal->sellerProjectReting): ?>
                                                                                        <a href="jvascript:void(0)" wire:click.prevent="readReview(<?php echo e($proposal->id); ?>,<?php echo e($proposal->proposalAuthor->id); ?>)"><?php echo e(__('project.read_review')); ?></a>
                                                                                    <?php else: ?>
                                                                                        <a href="jvascript:void(0)" wire:click.prevent="addReviewPopup(<?php echo e($proposal->proposalAuthor->id); ?>, <?php echo e($single->id); ?>)"><?php echo e(__('project.add_review')); ?></a>
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
    
                                                                        <?php if($proposal->status == "completed" ): ?>
                                                                            <span class="tk-checked">
                                                                                <i class="fas fa-check"></i>
                                                                            </span>
                                                                        <?php else: ?>
                                                                            <span class="<?php echo e($status['class']); ?>"><?php echo e($status['text']); ?></span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="tk-project-box tk-project-box-two tk-proposalbtns">
                                        <ul class="tk-proposal-list">
                                            <?php if(!$single->proposals->isEmpty()): ?>
                                                <?php $__currentLoopData = $single->proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($key <= 4): ?>
                                                        <?php
                                                            if(!empty($proposal->proposalAuthor->image)){
                                                                $image_path     = getProfileImageURL($proposal->proposalAuthor->image, '38x38');
                                                                $author_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-38x38.png';
                                                            }else{
                                                                $author_image = 'images/default-user-38x38.png';
                                                            }
                                                        ?>
                                                        <li>
                                                            <img src="<?php echo e(asset( $author_image)); ?>" alt="<?php echo e($proposal->proposalAuthor->full_name); ?>">
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <a href="<?php echo e(route('project-proposals', ['slug' => $single->slug])); ?>" class="tk-view-proposal"><?php echo e(__('project.view_proposals')); ?> <i class="icon-chevron-right"></i></a>
                                                </li>
                                            <?php else: ?> 
                                                <li>
                                                    <span><?php echo e(__('proposal.proposal_not_received')); ?></span>
                                                </li>
                                            <?php endif; ?>
                                        </ul> 
                                        <div class="tk-project-detail">
                                            <?php if( $single->status == 'draft' || $single->status == 'pending' ): ?>
                                                <a href="<?php echo e(route('create-project', [ 'step'=> 2, 'id'=> $single->id ] )); ?>" class="tk-edit-project"><i class="icon-edit-3"></i> <?php echo e(__('project.edit_project')); ?></a>
                                            <?php endif; ?>
                                            <a href="<?php echo e(route('project-detail', ['slug'=> $single->slug] )); ?>" class="tk-invite-bidbtn"><?php echo e(__('project.view_project')); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="tk-submitreview">
                                <figure>
                                    <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                                </figure>
                                <h4><?php echo e(__('general.no_record')); ?></h4>
                                <a href="<?php echo e(route('create-project')); ?>" class="tk-btn-solid-lefticon"> <?php echo e(__('project.add_new_project')); ?> </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if(!$projects->isEmpty()): ?>
                    <div class="col-sm-12">
                        <?php echo e($projects->links('pagination.custom')); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div wire:ignore.self class="modal fade tk-addonpopup" id="tk_add_review" tabindex="-1" role="dialog" aria-hidden="true">
        <div wire:key="<?php echo e(now()->timestamp); ?>" class="modal-dialog tk-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="tk-popuptitle">
                    <h4> <?php echo e(__('project.add_review_heading')); ?> </h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <form class="tk-themeform" id="tb_update_review">
                        <fieldset>
                            <div class="form-group">
                                <label class="tk-label tk-required"><?php echo e(__('project.rating_title')); ?></label>
                                <input type="text" wire:model.defer="rating_title" class="form-control <?php $__errorArgs = ['rating_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('project.rating_title')); ?>" autocomplete="off">
                                <?php $__errorArgs = ['rating_title'];
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
                                <label class="tk-label tk-required"><?php echo e(__('project.seller_rating')); ?></label>
                                <div class="tk-my-ratingholder">
                                    <ul id="tk_seller_ratings" class='tk-rating-stars tk_stars'>
                                        <li class='tk-star' data-value='1'>
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='2' >
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='3' >
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='4' >
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li class='tk-star' data-value='5' >
                                            <i class="fas fa-star"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php $__errorArgs = ['rating'];
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
                            <div class="form-group">
                                <label class="tk-label"><?php echo e(__('project.add_feedback')); ?></label>
                                <textarea class="form-control" wire:model.defer="rating_desc" placeholder="<?php echo e(__('project.add_feedback')); ?>"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="tk-savebtn">
                                    <a href="javascript:void(0);" id="add_review" wire:click.prevent="addReview" class="tb-btn"><?php echo e(__('project.save')); ?></a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade tb-excfreelancerpopup" id="tk_read_review" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content" id="tb_tk_viewrating">
                <div class="tb-popuptitle">
                    <h4><?php echo e($review_detail['user_name']); ?></h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <div class="tb-excfreelancerpopup__content">
                        <figure class="tb-ratinguserimg">
                            <img src="<?php echo e($review_detail['image']); ?>" alt="<?php echo e($review_detail['user_name']); ?>">
                        </figure>
                        <div class="tb-featureRating tb-featureRatingv2">
                            <span class="tb-featureRating__stars"><span style="width:<?php echo e($review_detail['avg_rating'].'%'); ?>" ></span></span>
                            <h6> <?php echo e(number_format((float)$review_detail['rating'], 1, '.', '')); ?></h6>
                        </div>
                        <h2><?php echo e($review_detail['rating_title']); ?></h2>
                        <?php if( $review_detail['rating_desc'] ): ?>
                            <p><?php echo e($review_detail['rating_desc']); ?> </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script>
        document.addEventListener('livewire:load', function () {

            window.addEventListener('add-review-popup', event => { 
                jQuery('#tk_add_review').modal(event.detail);
            });

            window.addEventListener('ReadReviewPopup', event => { 
                jQuery('#tk_read_review').modal(event.detail);
            });

            setTimeout(function() {
                $('#filter_project, #project_type').select2(
                    { allowClear: true, minimumResultsForSearch: Infinity  }
                );

                $('#filter_project').on('change', function (e) {
                    let filter_project = $('#filter_project').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_project', filter_project);
                });

                $('#project_type').on('change', function (e) {
                    let project_type = $('#project_type').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('project_type', project_type);
                });

                iniliazeSelect2Scrollbar();
            }, 50);

            $(document).on('click', '.tk_stars li', function(){
                var _this       = jQuery(this);
                var onStar      = parseInt(_this.data('value'), 10) > 0 ? parseInt(_this.data('value'), 10) : 5;
                var stars       = _this.parent().children('li.tk-star');

                for (var i = 0; i < stars.length; i++) {
                    jQuery(stars[i]).removeClass('active');
                }

                for (var i = 0; i < onStar; i++) {
                    jQuery(stars[i]).addClass('active');
                }
                var ratingValue = parseInt(jQuery('#tk_seller_ratings li.active').length, 10);
                window.livewire.find('<?php echo e($_instance->id); ?>').set('rating', ratingValue, true)
            });

            $(document).on('click', '.tk-projectsstatus_option > a', function(event) {
                // Close all open windows
                jQuery(".tk-contract-list").stop().slideUp(300);
                // Toggle this window open/close
                jQuery(this).next(".tk-contract-list").stop().slideToggle(300);
            });
        });

    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/buyer-projects.blade.php ENDPATH**/ ?>