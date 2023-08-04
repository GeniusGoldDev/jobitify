<main class="tb-main">    
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('gig.all_gigs') .' ('. $gigs->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">         
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_gig" class="form-control tk-selectprice">
                                            <option value =""> <?php echo e(__('gig.all_gigs')); ?> </option>
                                            <option value ="draft"> <?php echo e(__('general.draft')); ?> </option>
                                            <option value ="publish"> <?php echo e(__('general.publish')); ?> </option>
                                        </select>
                                    </div>
                                </div>  
                                
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="sortby" class="form-control">
                                            <option value="asc"><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc"><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="per_page" class="form-control">
                                            <?php $__currentLoopData = $per_page_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>{
                                                <option value="<?php echo e($opt); ?>"><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_gig"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-dballgigs">
                <?php if( !$gigs->isEmpty() ): ?>
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#' )); ?></th>
                                <th><?php echo e(__('gig.title' )); ?></th>
                                <th><?php echo e(__('gig.categories' )); ?></th>
                                <th><?php echo e(__('gig.gig_author' )); ?></th>
                                <th><?php echo e(__('gig.created_date' )); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $gigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $tag = getTag( $single->status );
                                ?>
                                <tr> 
                                    <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($single->id); ?></span></td>
                                    <td data-label="<?php echo e(__('gig.title' )); ?>"><span><?php echo $single->title; ?></span></td>
                                    <td data-label="<?php echo e(__('gig.categories' )); ?>">
                                        <h6>
                                            <?php $__currentLoopData = $single->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a target="_blank" href="<?php echo e(route('search-gigs', ['category_id' => $cat->category_id])); ?>">
                                                    <span><?php echo e($cat->name); ?></span>
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </h6>
                                    </td>
                                    <td data-label="<?php echo e(__('gig.gig_author' )); ?>"><span><?php echo e($single->gigAuthor->full_name); ?></span></td>
                                    <td data-label="<?php echo e(__('gig.created_date' )); ?>"><span><?php echo e(date($date_format, strtotime( $single->created_at ))); ?></span></td>
                                    <td data-label="<?php echo e(__('general.status')); ?>">
                                        <em class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></em>
                                    </td>
                                    <td data-label="<?php echo e(__('general.actions')); ?>">
                                        <ul class="tb-action-status">
                                            <li>
                                                <a href="<?php echo e(route('gig-detail', ['slug'=> $single->slug] )); ?>" target="_blank" ><i class="icon-eye"></i></a>
                                            </li>
                                            <li> <a href="javascript:void(0);" onClick="deleteGig(<?php echo e($single->id); ?>)" class="tb-delete" ><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
                    </table>
                        <?php echo e($gigs->links('pagination.custom')); ?>  
                    <?php else: ?>
                        <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>  
                </div>
            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
<script>
    document.addEventListener('livewire:load', function () {
        
        setTimeout(function() {

            $('#filter_gig').select2(
                { allowClear: true, minimumResultsForSearch: Infinity  }
            );

            $('#filter_gig').on('change', function (e) {
                let filter_gig = $('#filter_gig').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('filter_gig', filter_gig);
            });

            iniliazeSelect2Scrollbar();
            
        }, 200);
    });
    
    function deleteGig( id ){

        let title           = '<?php echo e(__("general.confirm")); ?>';
        let content         = '<?php echo e(__("general.confirm_content")); ?>';
        let action          = 'deleteGig';
        let type_color      = 'red';
        let btn_class      = 'danger';
        ConfirmationBox({title, content, action, id,  type_color, btn_class})
    }
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/gigs/gigs.blade.php ENDPATH**/ ?>