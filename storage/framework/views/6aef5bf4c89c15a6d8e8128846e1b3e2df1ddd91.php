<main class="tb-main">
    <div class ="row">
            <?php echo $__env->make('livewire.admin.sitepages.update', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('general.pages')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                <?php if( !$pages->isEmpty() ): ?>
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?php echo e(__('general.name')); ?></th>
                                <th><?php echo e(__('general.url')); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sr = 1;
                            ?>                    
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td data-label=""><span><?php echo e($sr++); ?></span></td>
                                    <td data-label="<?php echo e(__('general.name')); ?>"><span><?php echo $single->name; ?></span></td>
                                    <td data-label="<?php echo e(__('general.url')); ?>"><span><?php echo e(url( !empty($single->route) ? $single->route : '/' )); ?></span></td>
                                    <td data-label="<?php echo e(__('general.status')); ?>"><em class="<?php echo e($single->status == 'publish' ? 'tk-project-tag tk-success-tag' : 'tk-project-tag'); ?>"><?php echo e($single->status == 'draft' ? __('general.draft') : __('general.active')); ?></em></td>
                                    <td data-label="<?php echo e(__('general.actions')); ?>">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit(<?php echo e($single->id); ?>)"><i class="icon-edit-3"></i></a> </li> 
                                            <li> <a href="<?php echo e(route('pagebuilder.build', ['id' => $single->id])); ?>" ><i class="icon-settings"></i></a> </li> 
                                            <li> <a href="<?php echo e(url( !empty($single->route) ? $single->route : '/' )); ?>" target="_blank" ><i class="icon-eye"></i></a> </li> 
                                            <li> <a href="javascript:void(0);" onClick="confirmation(<?php echo e($single->id); ?>)" class="tb-delete"><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            </tbody>
                        </table>
                        <?php echo e($pages->links('pagination.custom')); ?>  
                    <?php else: ?>
                        <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>  
                </div>
            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
    <script>
        function confirmation( id ){
        
            let title           = '<?php echo e(__("general.confirm")); ?>';
            let content         = '<?php echo e(__("general.confirm_content")); ?>';
            let action          = 'deleteConfirmRecord';
            let type_color      = 'red';
            let btn_class      = 'danger';
            ConfirmationBox({title, content, action, id,  type_color, btn_class}) 
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/sitepages/sitepages.blade.php ENDPATH**/ ?>