<div>
    <main class="tk-main-bg">
        <section class="tk-main-section">
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="tk-project-wrapper">
                            <?php if(!$project->isEmpty): ?>
                                <div class="tk-project-box tk-employerproject">
                                    <div class="tk-employerproject-title">
                                        <?php if($project->is_featured): ?>
                                            <span wire:ignore data-tippy-content="<?php echo e(__('settings.featured_project')); ?>" class="tk-featureditem tippy">
                                                <i class="icon icon-zap"></i>
                                            </span>
                                        <?php endif; ?>

                                        <span class="tk-project-tag-two <?php echo e($project->project_type == 'hourly' ? 'tk-success-tag-updated' : 'tk-ongoing-updated'); ?>">
                                            <?php echo e($project->project_type == 'hourly' ? __('project.project_houly_type') : __('project.project_fixed_type')); ?>

                                        </span>
                                        <h3><?php echo e($project->project_title); ?></h3>
                                        <ul class="tk-blogviewdates">
                                            <li><span><i class="icon-calendar"></i> 
                                            <?php echo e(__('project.project_posted_date',['diff_time'=> getTimeDiff( $project->updated_at )])); ?>

                                        </span></li>
                                            <?php if(!empty($project->address)): ?>
                                            <li><span><i class="icon-map-pin"></i><?php echo e($project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country ) : $project->projectLocation->name); ?></span></li>
                                            <?php endif; ?>
                                            <?php if(!empty($project->expertiseLevel)): ?>
                                                <li><span><i class="icon-briefcase"></i><?php echo e($project->expertiseLevel->name); ?></span></li>
                                            <?php endif; ?>
                                            <li>
                                                <span><i class="icon-users"></i>
                                                <?php echo e($project->project_hiring_seller .' '. ($project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer'))); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tk-price">
                                        <h4><?php echo e(getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price)); ?></h4>
                                        <?php if(($proposal->status == "completed" || $proposal->status == "hired") && $userRole != 'admin'): ?>
                                            <div class="tk-project-detail">
                                                <a href="<?php echo e(route('project-activity',['slug' => $project->slug,'id' => $proposal->id ])); ?>" class="tk-btn-solid"><?php echo e(__('proposal.project_activity')); ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if( !empty($proposal->proposalAuthor) ): ?>
                            <?php
                                $author         = $proposal->proposalAuthor;
                                $image_path     = getProfileImageURL($author->image, '60x60');
                                $image          = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-60x60.png';
                            ?>
                            <div class="tk-project-box tk-profile-view">
                                <div class="tk-project-table-content">
                                    <img src="<?php echo e(asset($image)); ?>" alt="images">
                                    <div class="tk-project-table-info">
                                        <h4><?php echo e($author->full_name); ?></h4>
                                        <ul class="tk-blogviewdates">
                                            <li>
                                                <i class="fas fa-star tk-yellow"></i>
                                                <em> <?php echo e(ratingFormat( $author->ratings_avg_rating )); ?> </em>
                                                <span>(<?php echo e($author->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($author->ratings_count)])); ?> ) </span>

                                            </li>
                                        </ul>
                                    </div>
                                    <a href="<?php echo e(route('seller-profile',[ 'slug'=> $author->slug ])); ?>" class="tk-btn-solid tk-success-tag"><?php echo e(__('proposal.view_profile')); ?></a>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if( !empty($proposal) ): ?>
                                <div class="tk-project-box tk-working-rate shadow-none">
                                    <div class="tk-project-price">
                                        <?php if($project->project_type == 'hourly'): ?>
                                            <h5><?php echo e(__('proposal.author_hourly_rate_heading',['author_name' => $proposal->proposalAuthor->first_name])); ?></h5>
                                        <?php else: ?>
                                            <h5><?php echo e(__('proposal.author_fixed_rate_heading',['author_name' => $proposal->proposalAuthor->first_name])); ?></h5>
                                        <?php endif; ?>
                                        <span><?php echo e(getPriceFormat($currency_symbol,$proposal->proposal_amount).($project->project_type == 'hourly' ? '/hr' : '')); ?></span>
                                    </div>
                                </div>

                                <?php if(!$proposal->milestones->isEmpty()): ?>
                                <div class="tk-projectsinfo tk-project-box">
                                    <div class="tk-offer-milestone">
                                        <div class="tk-projectsinfo_title">
                                            <h4><?php echo e(__('proposal.offered_milestones')); ?></h4>
                                            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'buyer')): ?>
                                                <p><?php echo __('proposal.offered_milestones_desc'); ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <ul class="tk-projectsinfo_list">
                                            <?php $__currentLoopData = $proposal->milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <div class="tk-statusview">
                                                        <div class="tk-statusview_head">
                                                            <div class="tk-statusview_title">
                                                                <h5><?php echo e($milestone->title); ?></h5>
                                                                <span><?php echo e(getPriceFormat($currency_symbol,$milestone->price)); ?></span>
                                                            </div>
                                                        </div>
                                                        <p><?php echo nl2br($milestone->description); ?></p>

                                                        <?php 
                                                        $escrow_milestone = true;
                                                        if( $proposal->status == "declined" || $proposal->status == "completed" ){
                                                            $escrow_milestone = false;
                                                        } 
                                                        ?>
                                                        <?php if( $userRole == 'buyer' && $escrow_milestone && !$processed_milestones ): ?>
                                                            <button wire:click.prevent="escrowMilestone(<?php echo e($key); ?>)" class="tk-btnline" id="single-select"><?php echo e(__('proposal.hire_milestone_btn_txt')); ?></button>
                                                        <?php endif; ?>
                                                    </div>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="tk-projectsinfo tk-project-box">
                                    <div class="tk-offer-milestone">
                                        <div class="tk-milestones-content">
                                            <h6><?php echo e(__('proposal.special_comments_to_emp')); ?></h6>
                                            <p><?php echo nl2br($proposal->special_comments); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <?php if( $proposal->status == 'publish' || $proposal->status == 'declined'): ?>
                                        <?php if( $proposal->status == 'declined' ): ?>
                                        <div class="tk-project-box">
                                            <div class="tk-statusview_alert tk-employerproject">
                                                <span><i class="icon-info"></i><?php echo e(__('proposal.decline_reason_descrip')); ?></span>
                                                <a class="tk-alert-readbtn" wire:click.prevent="ShowDeclineProposalReason"  ><?php echo e(__('proposal.read_comment')); ?> <i class="icon-chevron-right"></i></a>
                                            </div>
                                        </div>
                                        <?php elseif( $proposal->status == 'publish' && $userRole == 'buyer'): ?>
                                            <div class="tk-project-box">
                                                <div class="tk-bidbtn tk-proposals-btn">
                                                    <button class="tk-decline" wire:click.prevent="confirmDeclineProposal" > <?php echo e(__('proposal.decline_proposal')); ?> </button>
                                                    <?php if( $project->project_type == 'hourly' || ( $project->project_type == 'fixed' && $proposal->milestones->isEmpty()) ): ?>
                                                        <button class="tk-btn-solid-lg" wire:click.prevent="hireSeller"><?php echo e(__('proposal.hire_seller_name',['author_name' => $proposal->proposalAuthor->full_name])); ?></button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div wire:ignore.self class="modal fade tb-addonpopup" id="tk_decline_reason" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <h4> <?php echo e(__('proposal.add_decline_reason')); ?> </h4>
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <textarea wire:model.defer="decline_reason" class="form-control  <?php $__errorArgs = ['decline_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> tk-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
                    <?php $__errorArgs = ['decline_reason'];
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
                    <div class="tb-form-btn">
                        <div class="tb-savebtn tb-dhbbtnarea ">
                            <a href="javascript:void(0);" wire:click.prevent="declinedProposal" class="tb-btn"><?php echo e(__('general.save_update')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:igonre.self class="modal fade" id="declined_proposal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog tk-modal-dialog-default modal-dialog-centered">
            <div class="modal-content">
            <div class="tk-popuptitle">
                <h5><?php echo e(__('proposal.employer_comments')); ?></h5>
                <a href="javascrcript:void(0)" data-bs-dismiss="modal" class="close">
                    <i class="icon-x"></i>
                </a>
            </div>
            <div class="modal-body tk-popup-content">
                <div class="tk-statusview_alert">
                    <span><i class="icon-info"></i><?php echo e(__('proposal.decline_text')); ?></span>
                </div>
                <div class="tk-popup-info">
                    <div class="tk-user-content">
                        <img class="buyer-image">
                        <div class="tk-user-info">
                            <h6 class="buyer-name"></h6>
                        </div>
                    </div>
                </div>
                <div class="tk-popup-info">
                    <h6 class="seller-name"></h6>
                    <p class="decline-reason"></p>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
            window.addEventListener('show-decline-reason-modal', event => {
                jQuery('#tk_decline_reason').modal(event.detail.modal);
            });

            window.addEventListener('ShowdeclinedProposalReason', event => {
                $('.tk-user-info .buyer-name').text(event.detail.buyerName);
                $('.tk-user-content .buyer-image').attr('src', event.detail.buyerImage);
                $('.tk-popup-info .seller-name').text(event.detail.sellerName);
                $('.tk-popup-info .decline-reason').text(event.detail.declineReason);
                jQuery('#declined_proposal').modal('show');
            });

        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/proposal/proposal-detail.blade.php ENDPATH**/ ?>