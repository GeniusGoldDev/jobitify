<main class="tk-main-bg">
    <section class="tk-main-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="tk-project-wrapper">
                        <div class="tk-project-box tk-employerproject">
                            <div class="tk-employerproject-title">
                                <?php if($project->is_featured): ?>
                                    <span wire:ignore data-tippy-content="<?php echo e(__('settings.featured_project')); ?>" class="tk-featureditem tippy">
                                        <i class="icon icon-zap"></i>
                                    </span>
                                <?php endif; ?>
                                <span class="tk-project-tag-two <?php echo e($project->project_type == 'fixed' ? 'tk-ongoing-updated' :  'tk-success-tag-updated'); ?>"><?php echo e($project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')); ?></span>
                                <h3><?php echo e($project->project_title); ?></h3>
                                <ul class="tk-blogviewdates">
                                    <li><span><i class="icon-calendar"></i> <?php echo e(__('project.project_posted_date',['diff_time'=> getTimeDiff( $project->updated_at )])); ?></span></li>
                                    <li><span><i class="icon-map-pin"></i><?php echo e($project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country ) : $project->projectLocation->name); ?></span></li>
                                    <li><span><i class="icon-briefcase"></i><?php echo e(!empty($project->expertiseLevel) ? $project->expertiseLevel->name : ''); ?></span></li>
                                    <li><span><i class="<?php echo e($project->project_hiring_seller > 1 ? 'icon-users' : 'icon-user'); ?>"></i><?php echo e($project->project_hiring_seller .' '. ($project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer'))); ?></span></li>
                                </ul>
                            </div>
                            <div class="tk-price">
                                <span><?php echo e(__('project.project_budget')); ?></span>
                                <h4><?php echo e(getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price)); ?></h4>
                                <div class="tk-project-detail">
                                    
                                    <?php if($project->status == 'draft' || $project->status == 'pending'): ?><a href="<?php echo e(route('create-project', [ 'step'=> 2, 'id'=> $project->id ] )); ?>" class="tk-edit-project"><i class="icon-edit-3"></i> <?php echo e(__('project.edit_project')); ?></a><?php endif; ?>
                                    <a href="<?php echo e(route('project-detail', ['slug'=> $project->slug] )); ?>" class="tk-btn-solid-lg"><?php echo e(__('project.view_project')); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="tk-project-box tk-project-box-two tk-allproposallist">
                            <div class=" tk-proposal">
                                <div class="tk-propposal_title">
                                    <h5><?php echo e(__('proposal.all_proposals')); ?> <span>(<?php echo e(!$project->proposals->isEmpty() ? number_format($project->proposals->count()) : 0); ?>)</span></h5>
                                </div>
                            </div>
                            <div class="tk-template-serach-wrapper">
                                <div class="tk-select" wire:ignore>
                                    <select id="filter_proposal" class="form-control tk-selectprice">
                                        <option value =""><?php echo e(__('proposal.all_proposals')); ?></option>
                                        <option value ="publish"> <?php echo e(__('general.publish')); ?> </option>
                                        <option value ="hired"> <?php echo e(__('general.hired')); ?> </option>
                                        <option value ="completed"> <?php echo e(__('general.completed')); ?> </option>
                                        <option value ="rejected"> <?php echo e(__('general.rejected')); ?> </option>
                                        <option value ="declined"> <?php echo e(__('general.cancelled')); ?> </option>
                                        <option value ="refunded"> <?php echo e(__('general.refunded')); ?> </option>
                                    </select>
                                </div>
                                <div class="tk-template-serach">
                                    <div class="tk-inputicon">
                                        <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="<?php echo e(__('general.search_with_keyword')); ?>">
                                        <i class="icon-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tk-project-box tk-table-wrapper">
                            <div wire:loading.class="tk-section-preloader">
                                <div class="preloader-outer" wire:loading>
                                    <div class="tk-preloader">
                                        <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                                    </div>
                                </div>
                                <?php if(!$project->proposals->isEmpty()): ?>    
                                    <table class="table tk-proinvoices_table">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('proposal.title')); ?></th>
                                                <th><?php echo e(__('proposal.bid_price')); ?></th>
                                                <th><?php echo e(__('proposal.dated')); ?></th>
                                                <th><?php echo e(__('general.status')); ?></th>
                                                <th><?php echo e(__('general.actions')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $project->proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    if(!empty($single->proposalAuthor->image)){
                                                        $image_path     = getProfileImageURL($single->proposalAuthor->image, '60x60');
                                                        $author_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-60x60.png';
                                                    }else{
                                                        $author_image = 'images/default-user-60x60.png';
                                                    }
                                                    $tag = getTag( $single->status );
                                                ?>
                                                <tr>
                                                    <td data-label="<?php echo e(__('proposal.title')); ?>">
                                                        <div class="tk-project-table-content">
                                                            <img src="<?php echo e(asset($author_image)); ?>" alt="<?php echo e($single->proposalAuthor->full_name); ?>">
                                                            <div class="tk-project-table-info">
                                                                <span> <?php echo e($single->proposalAuthor->full_name); ?></span>
                                                                <ul class="tk-blogviewdates">
                                                                    <li>
                                                                        <i class="fas fa-star tk-yellow"></i>
                                                                        <em> <?php echo e(ratingFormat( $single->proposalAuthor->ratings_avg_rating )); ?> </em>
                                                                        <span>( <?php echo e($single->proposalAuthor->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($single->proposalAuthor->ratings_count) ])); ?> )</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td data-label="<?php echo e(__('proposal.bid_price')); ?>"><?php echo e(getPriceFormat( $currency_symbol,$single->proposal_amount ).( $project->project_type == 'hourly' ? '/hr' : '')); ?> </td>
                                                    <td data-label="<?php echo e(__('proposal.dated')); ?>"><?php echo e(date($date_format, strtotime($single->updated_at))); ?></td>
                                                    <td data-label="<?php echo e(__('general.status')); ?>"><span class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></span></td>
                                                    <?php if( in_array($single->status, array('hired', 'completed', 'refunded', 'queued', 'rejected', 'disputed'))): ?>
                                                        <td data-label="<?php echo e(__('general.actions')); ?>"><a href="<?php echo e(route('project-activity', [ 'slug'=> $project->slug, 'id'=> $single->id ])); ?>"><?php echo e(__('project.project_activity')); ?></a></td>
                                                    <?php else: ?>
                                                        <td data-label="<?php echo e(__('general.actions')); ?>"><a href="<?php echo e(route('proposal-detail', [ 'slug'=> $project->slug, 'id'=> $single->id ])); ?>"><?php echo e(__('proposal.proposal_detail')); ?></a></td>    
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <div class="tk-submitreview">
                                        <figure>
                                            <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                                        </figure>
                                        <h4><?php echo e(__('proposal.proposal_not_received')); ?></h4>
                                    </div>    
                                <?php endif; ?>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/popper-core.js')); ?>"></script> 
    <script defer src="<?php echo e(asset('common/js/tippy.js')); ?>"></script>
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            let tb_tippy = document.querySelector(".tippy");
            if (tb_tippy !== null) {
                tippy(".tippy", {
                    animation: "scale",
                });
            }
            setTimeout(function() {
                
                $('#filter_proposal').select2(
                    { allowClear: true, minimumResultsForSearch: Infinity  }
                );

                $('#filter_proposal').on('change', function (e) {
                    let filter_proposal = $('#filter_proposal').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_proposal', filter_proposal);
                });

                iniliazeSelect2Scrollbar();
            }, 50);
        });

    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/project-proposals.blade.php ENDPATH**/ ?>