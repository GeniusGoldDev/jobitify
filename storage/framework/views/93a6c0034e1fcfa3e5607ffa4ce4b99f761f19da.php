<main class="tk-main-bg">
    <section class="tk-main-section" wire:loading.class="tk-section-preloader" >
        <div class="preloader-outer" wire:loading>
            <div class="tk-preloader">
                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    <?php if(!$proposals->isEmpty() && $search_project !=''): ?><h3><?php echo e($proposals->count() .' '.  __('general.search_result')); ?> “<?php echo e($search_project); ?>”</h3><?php endif; ?>
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
                                                <?php  
                                                    $statuses = [
                                                        'all'       => __('project.all_projects'),
                                                        'draft'     => __('general.draft'),
                                                        'pending'   => __('general.pending'),
                                                        'publish'   => __('general.publish'),
                                                        'hired'     => __('general.hired'),
                                                        'completed' => __('general.completed'),
                                                        'rejected'  => __('general.rejected'),
                                                        'declined'  => __('general.declined'),
                                                        'refunded'  => __('general.refunded'),
                                                        'refunded'  => __('general.refunded'),
                                                        'cancelled' => __('general.cancelled'),
                                                    ]; 
                                                ?>
                                                <select id="filter_project" class="form-control tk-selectprice">
                                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value ="<?php echo e($key != 'all' ? $key : ''); ?>" <?php echo e($filter_project == $key ? 'selected' : ''); ?> > <?php echo e($status); ?> </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(!$proposals->isEmpty()): ?>
                        <?php $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                               $tag = getTag( $single->status );
                            ?>
                            <div class="tk-project-wrapper-two">
                                <?php if($single->project->is_featured): ?>
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
                                <div class="tk-project-box">
                                    <div class=" tk-price-holder">
                                        <div class="tk-verified-info">
                                            <div class="tk-verified-info-tags">
                                                <span class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></span>
                                            </div>
                                            <strong wire:ignore>
                                                <?php echo e($single->project->projectAuthor->full_name); ?>  
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.verified-tippy','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('verified-tippy'); ?>
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
                                            </strong>
                                            <h5><?php echo e($single->project->project_title); ?></h5>
                                            <ul class="tk-template-view">
                                                <li>
                                                    <i class="icon-calendar"></i>
                                                    <span> <?php echo e(__('project.project_posted_date',['diff_time'=> getTimeDiff( $single->project->updated_at )])); ?> </span>
                                                </li>
                                                <li>
                                                    <i class="icon-map-pin"></i>
                                                    <span> <?php echo e($single->project->projectLocation->id == 3 ? (!empty($single->project->address) ? getUserAddress($single->project->address, $address_format) : $single->project->project_country ) : $single->project->projectLocation->name); ?> </span>
                                                </li>
                                                <li>
                                                    <i class="icon-briefcase"></i>
                                                    <span> <?php echo e(!empty($single->project->expertiseLevel) ? $single->project->expertiseLevel->name : ''); ?> </span>
                                                </li>
                                                <li>
                                                    <i class="<?php echo e($single->project_hiring_seller > 1 ? 'icon-users' : 'icon-user'); ?>"></i>
                                                    <span><?php echo e($single->project->project_hiring_seller .' '. ($single->project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer'))); ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tk-price tk-tagholder">
                                            <em class="tk-project-tag-two <?php echo e($single->project->project_type == 'fixed' ? 'tk-ongoing-updated' : 'tk-success-tag-updated'); ?>"><?php echo e($single->project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')); ?></em>
                                            <span> <?php echo e(__('project.project_budget')); ?></span>
                                            <h4><?php echo e(getProjectPriceFormat($single->project->project_type, $currency_symbol, $single->project->project_min_price, $single->project->project_max_price)); ?></h4>
                                            <?php if( $single->status == "hired" || $single->status == "completed" || $single->status == "refunded" || $single->status == "disputed"): ?>
                                            <a href="<?php echo e(route('project-activity',['slug' => $single->project->slug,'id' => $single->id ])); ?>" class="tk-invite-bidbtn"><?php echo e(__('project.project_activity')); ?></a>
                                            <?php endif; ?>
                                        </div>

                                        <div class="tk-projectsstatus_option">
                                            <a href="javascript:void(0);"><i class="icon-more-horizontal"></i></a>
                                            <ul class="tk-contract-list" style="display: none;">
                                                <?php if( $single->status == 'pending' || $single->status == 'draft' ): ?>
                                                    <li>
                                                        <a href="<?php echo e(route('submit-proposal', ['slug' => $single->project->slug] )); ?>" ><?php echo e(__('proposal.edit_proposal')); ?> </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" wire:click.prevent="deleteProposal(<?php echo e($single->id); ?>)" ><?php echo e(__('proposal.delete_proposal')); ?> </a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($single->status == 'publish'): ?>
                                                    <li>
                                                        <a href="<?php echo e(route('proposal-detail', ['slug'=> $single->project->slug, 'id' => $single->id] )); ?>" ><?php echo e(__('proposal.view_proposal')); ?> </a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <a href="<?php echo e(route('project-detail', ['slug'=> $single->project->slug] )); ?>" ><?php echo e(__('project.view_project')); ?> </a>
                                                </li>
                                            </ul>
                                        </div>
                                       
                                    </div>
                                    <?php if($single->status == 'declined'): ?>
                                        <div class="tk-statusview_alert tk-employerproject">
                                            <span><i class="icon-info"></i><?php echo e(__('proposal.decline_reason_descrip')); ?></span>
                                            <a class="tk-alert-readbtn" wire:click.prevent="DeclineProposal(<?php echo e($single->id); ?>)"  ><?php echo e(__('proposal.read_comment')); ?> <i class="icon-chevron-right"></i></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="tk-submitreview">
                            <figure>
                                <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                            </figure>
                            <h4><?php echo e(__('general.no_record')); ?></h4>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if(!$proposals->isEmpty()): ?>
                    <div class="col-sm-12">
                        <?php echo e($proposals->links('pagination.custom')); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
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
</main>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script>
        document.addEventListener('livewire:load', function () {
    
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

            window.addEventListener('declinedProposal', event => {
                $('.tk-user-info .buyer-name').text(event.detail.buyerName);
                $('.tk-user-content .buyer-image').attr('src', event.detail.buyerImage);
                $('.tk-popup-info .seller-name').text(event.detail.sellerName);
                $('.tk-popup-info .decline-reason').text(event.detail.declineReason);
                jQuery('#declined_proposal').modal('show');
            });

            $(document).on('click', '.tk-projectsstatus_option > a', function(event) {
                // Close all open windows
                jQuery(".tk-contract-list").stop().slideUp(300);
                // Toggle this window open/close
                jQuery(this).next(".tk-contract-list").stop().slideToggle(300);
            });
        });

    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/seller-projects.blade.php ENDPATH**/ ?>