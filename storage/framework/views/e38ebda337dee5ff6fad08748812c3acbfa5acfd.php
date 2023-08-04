<main class="tk-main-bg">
    <section class="tk-main-section">
        <div class="preloader-outer" wire:loading wire:target="submitProposal">
            <div class="tk-preloader">
                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-xl-8">
                    <div class="tk-project-wrapper">
                        <div wire:ignore class="tk-project-box">
                            <div class="tk-servicedetailtitle">
                                <?php if($project->is_featured): ?>
                                    <span wire:ignore class="tk-featureditem tippy" data-tippy-content="<?php echo e(__('settings.featured_project')); ?>"><i class="icon icon-zap"></i></span>
                                <?php endif; ?>
                                <h3><?php echo e($project->project_title); ?></h3>
                                <ul class="tk-blogviewdates">
                                    <li><span><i class="icon-calendar"></i> <?php echo e(__('project.project_posted_date',['diff_time'=> getTimeDiff( $project->updated_at)])); ?></span></li>
                                    <li><span><i class="icon-map-pin"></i> <?php echo e($project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country ) : $project->projectLocation->name); ?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-project-box">
                            <form class="tk-themeform">
                                <fieldset>
                                    <div class="tk-themeform__wrap">
                                        <div class="form-group">
                                            <label class="tk-label"><?php echo e(__('proposal.budget_rate')); ?></label>
                                            <div class="tk-placeholderholder">
                                                <input type="number" wire:model.debounce.300ms="proposal_amount"  class="form-control tk-themeinput <?php $__errorArgs = ['proposal_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="<?php echo e(__('proposal.budget_rate_placeholder')); ?>" required="required">
                                            </div>
                                            <?php $__errorArgs = ['proposal_amount'];
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
                                        
                                        <?php if($proposal_amount > 0): ?>
                                            <div class="form-group">
                                                <ul class="tk-budgetlist">
                                                    <li>
                                                        <span><?php echo e(__('proposal.total_budget')); ?></span>
                                                        <h6><?php echo e(getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price)); ?></h6>
                                                    </li>
                                                
                                                    <li>
                                                        <span><?php echo e(__('proposal.budget_rate')); ?></span>
                                                        <h6><?php echo e(getPriceFormat($currency_symbol,$working_budget).( $project->project_type == 'hourly' ? '/hr' : '')); ?></h6>
                                                    </li>
                                                    
                                                    <li>
                                                        <span>
                                                            <?php echo e(__('proposal.service_fee_tax')); ?> <?php if($commission_type == 'percentage' || $commission_type == 'commission_tier_per'): ?> <strong>(<?php echo e($commission_value); ?>%)</strong><?php endif; ?>  
                                                        </span>
                                                        <h6>-<?php echo e(getPriceFormat($currency_symbol,$admin_share).( $project->project_type == 'hourly' ? '/hr' : '')); ?></h6>
                                                    </li>
                                                
                                                </ul>
                                            </div>
                                            <div class="form-group">
                                                <div class="tk-totalamout">
                                                    <span><?php echo e(__('proposal.total_amount')); ?></span>
                                                    <h5><?php echo e(getPriceFormat($currency_symbol,$seller_share).( $project->project_type == 'hourly' ? '/hr' : '')); ?></h5>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                       
                                        <?php if($project->project_type == 'fixed'): ?>
                                            <div class="form-group tk-paid-version">
                                                <div class="tk-betaversion-wrap">
                                                    <?php if( $proposal_milestone_payout == 'yes' ): ?>
                                                        <div class="tk-betaversion-info-two">
                                                            <h5><?php echo e(__('proposal.how_to_paid_text')); ?></h5>
                                                            <p><?php echo e(__('proposal.how_to_paid_desc')); ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                    <ul class="tk-paid-option <?php echo e(($proposal_fixed_payout == 'yes' && $proposal_milestone_payout == 'no') || ($proposal_fixed_payout == 'no' && $proposal_milestone_payout == 'yes') ? 'tk-single-option' : ''); ?>">
                                                        <?php if( $proposal_milestone_payout == 'yes' ): ?>
                                                            <li>
                                                                <div class="tk-projectpaid-list <?php echo e($is_milestone == 'yes' ?  'active' : ''); ?>" wire:click.prevent="updateType('milestone')">
                                                                    <lable class="tk-projectprice-option <?php echo e($proposal_fixed_payout == 'no' ? 'tk-projectpaid-single' : ''); ?>" for="project-milestone">
                                                                        <img src="<?php echo e(asset('images/proposal/milestone.png')); ?>">
                                                                        <div class="tk-paifinfo">
                                                                            <h6><?php echo e(__('proposal.work_with_milestones')); ?></h6>
                                                                            <span><?php echo e(__('proposal.work_with_milestones_desc')); ?></span>
                                                                        </div>
                                                                    </lable>
                                                                </div>
                                                            </li>
                                                        <?php endif; ?>  

                                                        <?php if( $proposal_fixed_payout == 'yes' ): ?>
                                                            <li>
                                                                <div class="tk-projectpaid-list <?php echo e($is_milestone == 'no' ?  'active' : ''); ?>" wire:click.prevent="updateType('fixed')">
                                                                    <lable class="tk-projectprice-option <?php echo e($proposal_milestone_payout == 'no' ? 'tk-projectpaid-single' : ''); ?>" for="project-fixed">
                                                                        <img src="<?php echo e(asset('images/proposal/fixed.png')); ?>">
                                                                        <div class="tk-paifinfo">
                                                                            <h6><?php echo e(__('proposal.fixed_price_project')); ?></h6>
                                                                            <span><?php echo e(__('proposal.fixed_price_project_desc')); ?></span>
                                                                        </div>
                                                                    </lable>
                                                                </div>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                    <?php if( $is_milestone == 'yes' ): ?>
                                                        <div class="tk-add-price-slots">
                                                            <label class="tk-label"><?php echo e(__('proposal.add_milestone_desc')); ?>

                                                                <a href="javascript:;" wire:click.prevent="addNewMilestone" class="tk-addicon"><?php echo e(__('proposal.add_milestone_btn_text')); ?> <i class="icon-plus"></i></a>
                                                            </label>
                                                            <?php if(!empty($available_milestones)): ?>
                                                                <div wire:sortable="updateMilestoneOrder" wire:sortable.options="{ animation: 250 }">
                                                                    <?php $__currentLoopData = $available_milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    
                                                                        <div wire:sortable.item="<?php echo e($key); ?>" wire:key="milestone-<?php echo e($key); ?>" class="tk-milestones-prices">
                                                                            <div wire:sortable.handle class="tk-draghandler"></div>
                                                                            <div class="tk-grapinput">
                                                                                <div class="tk-milestones-input">
                                                                                    <div class="tk-placeholderholder tk-addslots">
                                                                                        <input type="number" wire:model.defer="available_milestones.<?php echo e($key); ?>.price"  placeholder="<?php echo e(__('proposal.add_price_placeholder')); ?>" class="form-control tk-themeinput <?php echo e(($errors->has('available_milestones.'.$key.'.price') ? ' tk-invalid' : '')); ?>" required="required">     
                                                                                        <?php if($errors->has('available_milestones.'.$key.'.price')): ?>
                                                                                            <div class="tk-errormsg">
                                                                                                <span> <?php echo e($errors->first('available_milestones.'.$key.'.price')); ?></span>
                                                                                            </div> 
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                    <div class="tk-placeholderholder">
                                                                                        <input type="text" wire:model.defer="available_milestones.<?php echo e($key); ?>.title" placeholder="<?php echo e(__('proposal.enter_title')); ?>" class="form-control tk-themeinput <?php echo e(($errors->has('available_milestones.'.$key.'.title') ? ' tk-invalid' : '')); ?>" required="required">    
                                                                                        <?php if($errors->has('available_milestones.'.$key.'.title')): ?>
                                                                                            <div class="tk-errormsg">
                                                                                                <span> <?php echo e($errors->first('available_milestones.'.$key.'.title')); ?></span>
                                                                                            </div> 
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                    <a href="javascript:void(0)" wire:click.prevent="updateMilestone(<?php echo e($key); ?>)" class="tk-removeicon"><i class="icon-trash-2"></i></a>
                                                                                </div>
                                                                                <div class="tk-placeholderholder">
                                                                                    <textarea  wire:model.defer="available_milestones.<?php echo e($key); ?>.description" class="form-control tk-themeinput" placeholder="<?php echo e(__('proposal.add_desc')); ?>"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="tk-comment-section">
                                            <div class="form-group">
                                                <label class="tk-label"><?php echo e(__('proposal.add_comment')); ?> </label>
                                                <div class="tk-placeholderholder">
                                                    <textarea wire:model.defer="special_comments" class="form-control tk-themeinput <?php $__errorArgs = ['special_comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
                                                </div>
                                                <?php $__errorArgs = ['special_comments'];
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
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>  

                    <?php if(!$author && $submit_proposal): ?> 
                        <div class="tk-proposal-btn">
                            <a href="javascript:;" wire:click.prevent="submitProposal" class="tk-btn-solid-lg-lefticon"><?php echo e(__('proposal.submit_btn_txt')); ?></a>
                            <a href="javascript:;" wire:click.prevent="submitProposal('draft')" class="tk-btnline"><?php echo e(__('proposal.save_as_draft')); ?></a>
                        </div>
                    <?php endif; ?>

                </div>
                <div wire:ignore class="col-lg-5 col-xl-4">
                    <aside>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box tk-projectprice">
                                <div class="tk-sidebar-title">
                                    <span class="tk-project-tag <?php echo e($project->project_type == 'fixed' ? 'tk-ongoing-updated' :  'tk-success-tag-updated'); ?>"><?php echo e($project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')); ?></span>
                                    <h3><?php echo e(getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price)); ?></h3>
                                    <?php if($project->project_type == 'hourly'): ?><em><?php echo e(__('project.estimated_hours', ['max_hours' => $project->project_max_hours, 'type' => $project->project_payment_mode])); ?></em><?php endif; ?>
                                </div>
                            </div>
                            <div class="tk-project-box">
                                <div class="tk-sidebar-title">
                                    <h5><?php echo e(__('project.project_requirements')); ?> </h5>
                                </div>
                                <ul class="tk-project-requirement">
                                    <li>
                                        <i class="icon-calendar"></i>
                                        <div class="tk-project-requirement_content">
                                            <em><?php echo e(__('project.project_category')); ?></em>
                                            <div class="tk-requirement-tags">
                                                <span><?php echo e(!empty($project->category) ? $project->category->name : ''); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="icon-users"></i>
                                        <div class="tk-project-requirement_content">
                                            <em> <?php echo e(__('project.hiring_capacity')); ?> </em>
                                            <div class="tk-requirement-tags">
                                                <span><?php echo e($project->project_hiring_seller .' '. ($project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer'))); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php if( $project->project_type == 'hourly' ): ?>
                                        <li>
                                            <i class="icon-dollar-sign"></i>
                                            <div class="tk-project-requirement_content">
                                                <em> <?php echo e(__('project.payment_mode')); ?> </em>
                                                <div class="tk-requirement-tags">
                                                    <span><?php echo e(ucfirst($project->project_payment_mode)); ?></span>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(!empty($project->expertiseLevel)): ?>
                                        <li>
                                            <i class="icon-briefcase"></i>
                                            <div class="tk-project-requirement_content">
                                                <em><?php echo e(__('project.expert_level')); ?></em>
                                                <div class="tk-requirement-tags">
                                                    <span><?php echo e($project->expertiseLevel->name); ?></span>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(!$project->languages->isEmpty()): ?>
                                        <li>
                                            <i class="icon-book-open"></i>
                                            <div class="tk-project-requirement_content">
                                                <em><?php echo e(__('project.languages')); ?> </em>
                                                <div class="tk-requirement-tags">
                                                    <?php $__currentLoopData = $project->languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span> <?php echo $single->name; ?> </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <i class="icon-calendar"></i>
                                        <div class="tk-project-requirement_content">
                                            <em><?php echo e(__('project.project_duration')); ?></em>
                                            <div class="tk-requirement-tags">
                                                <span><?php echo e(!empty($project->projectDuration) ? $project->projectDuration->name : ''); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php if($project->type == 'hourly' && !project->projectPaymentMode->isEmpty()): ?>
                                        <li>
                                            <i class="icon-clock"></i>
                                            <div class="tk-project-requirement_content">
                                                <em><?php echo e(__('project.payment_mode')); ?></em>
                                                <div class="tk-requirement-tags">
                                                    <span><?php echo e($project->projectPaymentMode->name); ?></span>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="tk-project-wrapper">
                            <div class="tk-project-box">
                                <div class="tk-verified-title">
                                    <div class="tk-projectinfo_title">
                                        <?php
                                        if(!empty($project->projectAuthor->image)){
                                            $image_path     = getProfileImageURL($project->projectAuthor->image, '50x50');
                                            $author_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-50x50.png';
                                        }else{
                                            $author_image   = 'images/default-user-50x50.png';
                                        }
                                        ?>
                                        <img src="<?php echo e(asset($author_image)); ?>" alt="<?php echo e($project->projectAuthor->full_name); ?>">
                                        <div wire:ignore class="tk-verified-info">
                                            <h5> <?php echo e($project->projectAuthor->full_name); ?> 
                                                <i class="icon-check-circle tk-theme-tooltip tippy" data-tippy-content="<?php echo e(__('general.verified_user')); ?>" ></i>
                                            </h5>
                                            <em> <?php echo e(__('project.member_since',['date' => date( $date_format, strtotime($project->projectAuthor->created_at))])); ?></em>
                                        </div>
                                    </div>
                                    <div class="tk-projectinfo_description">
                                        <?php if(!empty($project->projectAuthor->description)): ?><p><?php echo $project->projectAuthor->description; ?></p><?php endif; ?>
                                    </div>
                                </div>
                                <ul class="tk-checkout-info">
                                    <?php if(!empty($project->projectAuthor->address)): ?>    
                                        <li>
                                            <div class="tk-total-title">
                                                <i class="icon-map-pin"></i>
                                                <em><?php echo e(__('project.located_in')); ?> </em>
                                            </div>
                                            <span><?php echo e(getUserAddress($project->projectAuthor->address, $address_format)); ?></span>
                                        </li>
                                    <?php endif; ?>    
                                    <li>
                                        <div class="tk-total-title">
                                            <i class="icon-bookmark"></i>
                                            <em><?php echo e(__('project.total_posted_projects')); ?></em>
                                        </div>
                                        <span><?php echo e($posted_projects); ?></span>
                                    </li>
                                    <li>
                                        <div class="tk-total-title">
                                            <i class="icon-clock"></i>
                                            <em><?php echo e(__('project.hired_projects')); ?></em>
                                        </div>
                                        <span><?php echo e($hired_projects); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
</main>
<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/livewire-sortable.js')); ?>"></script> 
    <script defer src="<?php echo e(asset('common/js/popper-core.js')); ?>"></script> 
    <script defer src="<?php echo e(asset('common/js/tippy.js')); ?>"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            let tb_tippy = document.querySelector(".tippy");
                if (tb_tippy !== null) {
                    tippy(".tippy", {
                        animation: "scale",
                    });
                }
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/proposal/submit-proposal.blade.php ENDPATH**/ ?>