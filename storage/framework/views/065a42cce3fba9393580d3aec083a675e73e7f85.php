<section class="tk-main-bg tk-main-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="tk-dhb-mainheading">
                    <h3><?php echo e(__('gig.manage_gigs')); ?></h3>
                    <div class="tk-sortby">
                        <div class="tk-actionselect tk-actionselect2">
                            <span><?php echo e(__('gig.filter_by')); ?></span>
                            <div class="tk-select" wire:ignore>
                                <select id="tk_gig_type" data-hide_search_opt="true" class="form-control tk-select2">
                                    <option value="" selected> <?php echo e(__('gig.all_gigs')); ?> </option>
                                    <option value="publish"> <?php echo e(__('gig.publis_status')); ?> </option>
                                    <option value="draft"> <?php echo e(__('gig.draft_status')); ?> </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if( !empty($gigs) && $gigs->count() > 0 ): ?>
                    <ul class="tk-savelisting">
                        <?php $__currentLoopData = $gigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li id="gig_<?php echo e($gig->id); ?>" class="tk-tabbitem">
                                <div class="tk-tabbitem__list tk-tabbitem__listtwo">
                                    <div class="tk-deatlswithimg">
                                        <figure>
                                            <?php 
                                                $gig_image      = 'images/default-img-150x150.png';
                                                if(!empty($gig->attachments) ){
                                                    $files  = unserialize($gig->attachments);
                                                    $images = $files['files'];
                                                    $latest = current($images);
                                                    if( !empty($latest) && substr($latest->mime_type, 0, 5) == 'image'){
                                                        if(!empty($latest->sizes['150x150'])){
                                                            $gig_image = 'storage/'.$latest->sizes['150x150'];
                                                        } elseif(!empty($latest->file_path)){
                                                            $gig_image = 'storage/'.$latest->file_path;
                                                        }
                                                    }
                                                }
                                            ?>
                                            <img src="<?php echo e(asset($gig_image)); ?>" alt="<?php echo e(__('gig.alt_image')); ?>" >
                                        </figure>
                                        <div class="tk-icondetails">
                                            <?php if( !$gig->categories->isEmpty() ): ?>
                                                <ul class="tk-desclinks">
                                                    <?php $__currentLoopData = $gig->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <h5><a href="<?php echo e(route('search-gigs',[ 'category_id' => $category->id ])); ?>" rel="tag"><?php echo e($category->name); ?></a></h5>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php endif; ?>
                                            <?php   
                                                $in_queue = $completed = $cancelled = 0;
                                                $in_queue_ratio = $completed_ratio = $cancelled_ratio = 0;
                                                
                                                $total = count($gig->gig_orders);
                                                foreach($gig->gig_orders as $order){
                                                    if($order->status == 'hired'){
                                                        ++$in_queue;
                                                    } elseif ( in_array($order->status, ['disputed', 'refunded', 'rejected'])){
                                                        ++$cancelled;
                                                    } elseif($order->status == 'completed'){
                                                        ++$completed;
                                                    }
                                                }

                                                if($total > 0){
                                                    $in_queue_ratio = ($in_queue/$total)*100;
                                                    $completed_ratio = ($completed/$total)*100;
                                                    $cancelled_ratio = ($cancelled/$total)*100;
                                                }

                                            ?>
                                            <h6><a href="<?php echo e(route('gig-detail',['slug' => $gig->slug])); ?>"><?php echo $gig->title; ?></a></h6>
                                            <ul class="tk-rateviews tk-rateviews2">
                                                <li>
                                                    <i class="fa fa-star tk-yellow"></i> 
                                                    <em> <?php echo e(ratingFormat($gig->ratings_avg_rating)); ?> </em> 
                                                    <span>( <?php echo e($gig->ratings_count == 1 ? __('general.user_review') : __('general.user_reviews', ['count' => number_format($gig->ratings_count) ])); ?> )</span>
                                                </li>
                                                <li>
                                                    <i class="icon-eye"></i> 
                                                    <span> 
                                                        <?php echo e($gig->gig_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format($gig->gig_visits_count) ] )); ?>

                                                    </span>
                                                </li>
                                                <li>
                                                    <i class="icon-shopping-bag text-grey"></i>
                                                    <span><?php echo e($completed == 1 ? __('gig.gig_sale', ['count' => $completed]) :  __('gig.gig_sales', ['count' => $completed] )); ?></span>
                                                </li>
                                                <li class="tb_publish"><i class="icon-clock"></i><span><?php echo e($gig->status == 'publish' ? __('gig.publish_status') : __('general.draft')); ?></span></li>
                                            </ul>
                                            <ul class="tk-profilestatus">
                                                <li> 
                                                    <div class="tk-profiletime">
                                                        <span><?php echo e(__('gig.in_queue',['count' => $in_queue])); ?></span>
                                                        <div class="progress tk-profileprogress">
                                                            <div class="progress-bar" role="progressbar" style="width: <?php echo e($in_queue_ratio); ?>%;"
                                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tk-profiletime">
                                                        <span><?php echo e(__('gig.completed_gigs', ['count' => $completed])); ?></span>
                                                        <div class="progress tk-profileprogress">
                                                            <div class="progress-bar" role="progressbar" style="width: <?php echo e($completed_ratio); ?>%;"
                                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="tk-profiletime">
                                                        <span><?php echo e(__('gig.cancelled_gigs', ['count' => $cancelled])); ?></span>
                                                        <div class="progress tk-profileprogress">
                                                            <div class="progress-bar" role="progressbar" style="width: <?php echo e($cancelled_ratio); ?>%;"
                                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tk-itemlinks tk-itemlinksvtwo">
                                        <div class="tk-startingprice">
                                            <i><?php echo e(__('gig.starting_from')); ?></i>
                                            <span><?php echo e(getPriceFormat($currency_symbol, $gig->gig_plans->min('price'))); ?></span>
                                        </div>
                                       
                                        <div class="tk-switchservice">
                                            <span><?php echo e(__('gig.gig_status')); ?></span>
                                            <div class="tk-onoff">
                                                <input type="checkbox" id="tk-task-<?php echo e($gig->id); ?>" <?php echo e($gig->status == 'publish' ? 'checked' : ''); ?> name="service-enable-disable" wire:change.prevent="updateStatus($event.target.checked, <?php echo e($gig->id); ?>)" />
                                                <label for="tk-task-<?php echo e($gig->id); ?>">
                                                    <em><i></i></em>
                                                <span class="tk-enable"></span><span class="tk-disable"></span></label>
                                            </div>
                                        </div>
                                       
                                        <ul class="tk-tabicon">
                                            <?php if($profile_id == $gig->author_id): ?>
                                                <li>
                                                    <a href="<?php echo e(route('create-gig',['id' => $gig->id])); ?>"> <span class="icon-edit-2"></span> </a> 
                                                </li>
                                                <li class="tk-delete"> 
                                                    <a href="javascript:void(0);" onClick="confirmation(<?php echo e($gig->id); ?>)" class="taskbot-service-delete">
                                                        <span class="icon-trash-2 bg-redheart"></span>
                                                    </a> 
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <a href="<?php echo e(route('gig-detail',['slug' => $gig->slug])); ?>">
                                                    <span class="icon-external-link bg-gray"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php echo e($gigs->links('pagination.custom')); ?>

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
</section>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?> "></script>  
    <script>
        function confirmation(id){
            let title           = '<?php echo e(__("general.confirm")); ?>';
            let content         = '<?php echo e(__("general.confirm_content")); ?>';
            let action          = 'deleteGig';
            let type_color      = 'red';
            let btn_class       = 'red';
            ConfirmationBox({title, content, action, id, type_color, btn_class})
        }

        document.addEventListener('livewire:load', function () {
            iniliazeSelect2Scrollbar();
            $('#tk_gig_type').on('change', function (e) {
                let gig_type = $('#tk_gig_type').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_by', gig_type);
            });
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/gig/gig-list.blade.php ENDPATH**/ ?>