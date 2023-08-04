<main class="tb-main">
    <div class ="row">
        <?php echo $__env->make('livewire.admin.taxonomies.languages.update', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('languages.text')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred <?php echo e($selectedLanguages ? '' : 'd-none'); ?>" onClick="confirmation()"><?php echo e(__('general.delete_selected')); ?></a>
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
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="<?php echo e(__('languages.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                <?php if(!empty($languages) && $languages->count() > 0): ?>
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>
                                    <div class="tb-checkbox">
                                        <input id="checkAll" wire:model.lazy="selectAll"  type="checkbox">
                                        <label for="checkAll"><?php echo e(__('languages.name')); ?></label>
                                    </div>
                                </th>
                                <th><?php echo e(__('general.description')); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td data-label="<?php echo e(__('languages.name')); ?>">
                                        <div class="tb-checkboxwithimg">
                                            <div class="tb-checkbox">
                                                <input id="language_id<?php echo e($single->id); ?>" wire:model.lazy="selectedLanguages" value="<?php echo e($single->id); ?>" type="checkbox">
                                                <label for="language_id<?php echo e($single->id); ?>">
                                                    <span> 
                                                        <?php echo $single->name; ?>

                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="<?php echo e(__('general.description')); ?>"><span><?php echo $single->description; ?></span></td>
                                    <td data-label="<?php echo e(__('general.status')); ?>">
                                        <em class="tk-project-tag tk-<?php echo e($single->status == 'active' ? 'active' : 'disabled'); ?>"><?php echo e($single->status); ?></em>
                                    </td>
                                    <td data-label="<?php echo e(__('general.actions')); ?>">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit(<?php echo e($single->id); ?>)"><i class="icon-edit-3"></i></a> </li> 
                                            <li> <a href="javascript:void(0);" onClick="confirmation(<?php echo e($single->id); ?>)" class="tb-delete"><i class="icon-trash-2"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            </tbody>
                        </table>
                        <?php echo e($languages->links('pagination.custom')); ?>  
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
        function confirmation( id = '' ){
            let title           = '<?php echo e(__("general.confirm")); ?>';
            let content         = '<?php echo e(__("general.confirm_content")); ?>';
            let action          = 'deleteConfirmRecord';
            let type_color      = 'red';
            let btn_class       = 'success';
            ConfirmationBox({title, content, action, id, type_color, btn_class})
        }
        document.addEventListener('livewire:load', function () {
            $(document).on('click', '.tb-checkaction', function(event){
                let _this = $(this);
                let status = '';
                if(_this.is(':checked')){
                    _this.parent().find('#tb-textdes').html("<?php echo e(__('general.active')); ?>");
                    status = 'active';
                } else {
                    _this.parent().find('#tb-textdes').html( "<?php echo e(__('general.deactive')); ?>");
                    status = 'deactive';
                }
                window.livewire.find('<?php echo e($_instance->id); ?>').set('status', status, true);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/taxonomies/languages/languages.blade.php ENDPATH**/ ?>