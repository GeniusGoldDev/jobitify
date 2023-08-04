<main class= "tk-main-bg">
    <section class="tk-main-section">   
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tk-project-wrapper shadow-none border-0">
                        <div class="tk-project-box tk-employerproject">
                            <div class="tk-employerproject-title">
                                <?php if($project->is_featured): ?>
                                    <span wire:ignore data-tippy-content="<?php echo e(__('settings.featured_project')); ?>" class="tk-featureditem tippy">
                                        <i class="icon icon-zap"></i>
                                    </span>
                                <?php endif; ?>
                                <span class="tk-project-tag-two <?php echo e($project->project_type == 'fixed' ? 'tk-ongoing-updated'  : 'tk-success-tag-updated'); ?>"><?php echo e($project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')); ?></span>
                                <h3><?php echo e($project->project_title); ?></h3>
                                <ul class="tk-blogviewdates">
                                    <li><span><i class="icon-calendar"></i> <?php echo e(__('project.project_posted_date',['diff_time'=> getTimeDiff($project->updated_at)])); ?></span></li>
                                    <li><span><i class="icon-map-pin"></i><?php echo e($project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country )  : $project->projectLocation->name); ?></span></li>
                                    <li><span><i class="icon-briefcase"></i><?php echo e(!empty($project->expertiseLevel) ? $project->expertiseLevel->name : ''); ?></span></li>
                                    <li><span><i class="<?php echo e($project->project_hiring_seller > 1 ? 'icon-users' : 'icon-user'); ?>"></i><?php echo e($project->project_hiring_seller .' '. ($project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer'))); ?></span></li>
                                </ul>
                            </div>
                            <div class="tk-employerproject-edit">
                                <h4><?php echo e(getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price)); ?></h4>
                                <a href="<?php echo e(route('project-detail', ['slug'=> $project->slug] )); ?>" class="tk-btn-solid-lg"><?php echo e(__('project.view_project')); ?></a>
                            </div>
                        </div>
                        <div class="tk-projectstatus">
                            <?php if(!$project->proposals->isEmpty()): ?>
                                <?php
                                    $total_sellers = $project->proposals->count();
                                ?>
                                <?php if($userRole == 'buyer' && $total_sellers > 1): ?>
                                    <div class="tk-projectstatus_users">
                                        <div id="tk-prouserslist" class="tk-proposal-warapper splide">
                                            <div class="splide__track">
                                                <ul class="tk-prouserslist splide__list">
                                                    <?php $__currentLoopData = $project->proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                                                        <?php
                                                            if(!empty($single->proposalAuthor->image)){
                                                                $image_path     = getProfileImageURL($single->proposalAuthor->image, '50x50');
                                                                $author_image   = !empty($image_path) ? 'storage/' . $image_path : 'images/default-user-50x50.png';

                                                            }else{
                                                                $author_image = 'images/default-user-50x50.png';
                                                            }
                                                            $status = getPointerTag($single->status);
                                                        ?>  
                                                        <li class="splide__slide tk-status-point <?php echo e($status['class']); ?>">
                                                            <a data-id="<?php echo e($single->id); ?>" href="javascript:;" class="<?php echo e($single->id == $selected_proposal ? 'active' : ''); ?>"  wire:click="$emit('updateSellerProposal', <?php echo e($single->id); ?> )">
                                                                <img src="<?php echo e(asset( $author_image)); ?>" alt="<?php echo e($single->proposalAuthor->full_name); ?>">
                                                                <h6><?php echo e($single->proposalAuthor->full_name); ?></h6>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="tk-projectsstatus">
                                    <div class="preloader-outer d-none">
                                        <div class="tk-preloader">
                                            <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                                        </div>
                                    </div>

                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.proposal-activity-detail', [
                                        'project_id'        => $project->id,
                                        'proposal_id'       => $selected_proposal,
                                        'currency_symbol'   => $currency_symbol,
                                        'profile_id'        => $profile_id,
                                        'userRole'          => $userRole,
                                        'date_format'       => $date_format,
                                        'project_max_hours' => $project->project_max_hours
                                    ])->html();
} elseif ($_instance->childHasBeenRendered('0nr1WHp')) {
    $componentId = $_instance->getRenderedChildComponentId('0nr1WHp');
    $componentTag = $_instance->getRenderedChildComponentTagName('0nr1WHp');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('0nr1WHp');
} else {
    $response = \Livewire\Livewire::mount('components.proposal-activity-detail', [
                                        'project_id'        => $project->id,
                                        'proposal_id'       => $selected_proposal,
                                        'currency_symbol'   => $currency_symbol,
                                        'profile_id'        => $profile_id,
                                        'userRole'          => $userRole,
                                        'date_format'       => $date_format,
                                        'project_max_hours' => $project->project_max_hours
                                    ]);
    $html = $response->html();
    $_instance->logRenderedChild('0nr1WHp', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.project-activities-invoices',[
                                        'proposal_id'       => $selected_proposal,
                                        'profile_id'        => $profile_id,
                                        'userRole'          => $userRole,
                                        'project_id'        => $project->id,
                                        'project_title'     => $project->project_title,
                                        'project_author_id' => $project->author_id
                                    ])->html();
} elseif ($_instance->childHasBeenRendered('0aXhBBM')) {
    $componentId = $_instance->getRenderedChildComponentId('0aXhBBM');
    $componentTag = $_instance->getRenderedChildComponentTagName('0aXhBBM');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('0aXhBBM');
} else {
    $response = \Livewire\Livewire::mount('components.project-activities-invoices',[
                                        'proposal_id'       => $selected_proposal,
                                        'profile_id'        => $profile_id,
                                        'userRole'          => $userRole,
                                        'project_id'        => $project->id,
                                        'project_title'     => $project->project_title,
                                        'project_author_id' => $project->author_id
                                    ]);
    $html = $response->html();
    $_instance->logRenderedChild('0aXhBBM', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                </div>
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
                </div>
            </div>
        </div>
    </section>
</main>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/pagebuilder/css/splide.min.css', 
    ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('pagebuilder/js/splide.min.js')); ?>"></script>
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
        let tk_prouserslist = document.querySelector("#tk-prouserslist");
        if (tk_prouserslist !== null) {
            let settings = {
                perPage: 7,
                perMove: 1,
                arrows: false,
                pagination: false,
                fixedWidth: "170px",
                gap: 10,
                breakpoints: {
                    991: {
                        perPage: 6,
                    },
                    575: {
                        perPage: 5,
                    },
                    480: {
                        perPage: 1,
                        focus: 'center',
                        rewind: true,
                        fixedWidth: "130px",
                    },
                }

            }
            let isRTL = "<?php echo e($isRTL); ?>";
            if(isRTL == '1'){
                settings['direction'] = 'rtl';
            }
            
            var splide = new Splide("#tk-prouserslist", settings);
            splide.mount();
        }

        $('.tk-prouserslist').on('click', 'li a', function() {
            let _this   = jQuery(this);
            let id      = _this.data('id');
            $('.tk-prouserslist li a.active').removeClass('active');
            $(this).addClass('active');
            updateUrlParam('id', id);
        });

        function updateUrlParam(key, value) {
            if (history.pushState) {
                let searchParams = new URLSearchParams(window.location.search);
                searchParams.set(key, value);
                let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + searchParams.toString();
                window.history.pushState({path: newurl}, '', newurl);
            }
        }


        $(document).on('click', '.tk-projectsstatus_option > a', function(event) {
            // Close all open windows
            jQuery(".tk-contract-list").stop().slideUp(300);
            // Toggle this window open/close
            jQuery(this).next(".tk-contract-list").stop().slideToggle(300);
        });

        setTimeout(function() {
            
            $('#filter_project').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_project').on('change', function (e) {
                let filter_project = $('#filter_project').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_project', filter_project);
            });

            iniliazeSelect2Scrollbar();
        }, 50);
    });
   

</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/project-activity.blade.php ENDPATH**/ ?>