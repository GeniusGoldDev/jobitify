<main class="tb-main">
    <div class ="row">
            <?php echo $__env->make('livewire.admin.taxonomies.gig-categories.update', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('category.text')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred <?php echo e($selectedCategories ? '' : 'd-none'); ?>" wire:click.prevent="deleteAllRecord"><?php echo e(__('general.delete_selected')); ?></a>
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="<?php echo e(__('category.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable tb-db-categoriestable">
                <?php if(!empty($categories) && $categories->count() > 0): ?>
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>
                                    <div class="tb-checkbox">
                                        <input id="checkAll" wire:model="selectAll"  type="checkbox">
                                        <label for="checkAll"><?php echo e(__('category.title')); ?></label>
                                    </div>
                                </th>
                                <th><?php echo e(__('category.description')); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td data-label="<?php echo e(__('category.title')); ?>">
                                        <div class="tb-namewrapper">
                                            <div class="tb-checkbox">
                                                <input id="category_id<?php echo e($single->id); ?>" wire:model="selectedCategories" value="<?php echo e($single->id); ?>" type="checkbox">
                                                <label for="category_id<?php echo e($single->id); ?>">
                                                    <span> 
                                                        <?php if(!empty($single->image)): ?>
                                                            <?php  
                                                                $image      = unserialize($single->image);
                                                                $image_path = $image['file_path'];
                                                                $image_name = $image['file_name'];
                                                            ?>
                                                                <img src="<?php echo e(asset('storage/'.$image_path)); ?>" alt="<?php echo e($image_name); ?>">
                                                        <?php endif; ?>

                                                        <?php echo $single->name; ?>

                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="<?php echo e(__('category.description')); ?>"><span><?php echo $single->description; ?></span></td>
                                    <td data-label="<?php echo e(__('general.status')); ?>">
                                        <em class="tk-project-tag tk-<?php echo e($single->status == 'active' ? 'active' : 'disabled'); ?>"><?php echo e($single->status); ?></em>
                                    </td>
                                    <td data-label="<?php echo e(__('general.actions')); ?>">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit(<?php echo e($single->id); ?>)"><i class="icon-edit-3"></i></a> </li> 
                                            <li> <a href="javascript:void(0);" wire:click.prevent="deleteRecord(<?php echo e($single->id); ?>)" class="tb-delete"><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            </tbody>
                        </table>
                        <?php echo e($categories->links('pagination.custom')); ?>  
                    <?php else: ?>
                        <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>  
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/common/css/combotree.css', 
    ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('common/js/combotree.js')); ?>"></script>
    <script>
        var categoryInstance = null;
        document.addEventListener('livewire:load', function () {
            let title           = '<?php echo e(__("general.confirm")); ?>';
            let listenerName    = 'delete-category-confirm';
            let content         = '<?php echo e(__("general.confirm_content")); ?>';
            let action          = 'deleteConfirmRecord'; 
            confirmAlert({title,listenerName, content, action});

            window.addEventListener('initDropDown', function(event){
                let parentId = event.detail.parentId;
                if( event.detail.categories_tree.length ){
                    initDropDown(event.detail.categories_tree, parentId);
                }
            });

            if( window.categories_tree.length ){
                initDropDown(window.categories_tree);
            }

            function initDropDown(categories, parentId = null){

                $('input[id^="category_dropdown-"]').parent('.form-group').removeClass('d-none');
                if(categoryInstance != null){
                    categoryInstance.clearSelection();
                    categoryInstance.destroy();
                }

                let settings = {
                    source : categories,
                    isMultiple: false
                }

                if(parentId){
                    settings['selected'] = [parentId.toString()]
                }
                categoryInstance = $('input[id^="category_dropdown-"]').comboTree(settings);
            }

            $(document).on('change', 'input[id^="category_dropdown-"]', function(event){
                if(categoryInstance){
                    let id = categoryInstance.getSelectedIds();
                    if(id){
                        window.livewire.find('<?php echo e($_instance->id); ?>').set('parentId', id[0], true);
                    }
                }
            });

        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/taxonomies/gig-categories/categories.blade.php ENDPATH**/ ?>