<div class="tb-main">
    <div class ="row">
        <?php echo $__env->make('livewire.admin.taxonomies.tags.update', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('taxonomy.tags')); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" id="delete-record" class="tb-btn btnred d-none" onClick="confirmation()"><?php echo e(__('general.delete_selected')); ?></a>
                                </div>
                                <div class="tb-actionselect">
                                    <div class="tb-select">
                                        <select wire:model="sortby" class="form-control">
                                            <option value="asc"><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc"><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"  autocomplete="off" placeholder="<?php echo e(__('taxonomy.search_tag')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="tb-disputetable">
                <?php if(!empty($tags) && $tags->count() > 0): ?>
                    <table id="tag_table" class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th>
                                <div class="tb-checkbox">
                                    <input id="checkAll" class="tb-tag" type="checkbox">
                                    <label for="checkAll"><span> <?php echo e(__('general.name')); ?> </span></label>
                                </div>
                                </th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td data-label="<?php echo e(__('general.name')); ?>">
                                        <div class="tb-checkbox">
                                            <input id="tag_<?php echo e($single->id); ?>" class="tb-tag" value="<?php echo e($single->id); ?>" type="checkbox">
                                            <label for="tag_<?php echo e($single->id); ?>">
                                                <span> 
                                                    <?php echo $single->name; ?>

                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td data-label="<?php echo e(__('general.status')); ?>">
                                        <div class="tb-bordertags">
                                            <em class="tk-project-tag tk-<?php echo e($single->status == 'active' ? 'active' : 'disabled'); ?>"><?php echo e($single->status); ?></em>
                                        </div>
                                    </td>
                                    <td data-label="<?php echo e(__('general.actions')); ?>">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit(<?php echo e($single->id); ?>)"><i class="icon-edit-3"></i></a> </li> 
                                            <li> <a href="javascript:void(0);" onClick="confirmation(<?php echo e($single->id); ?>)" class="tb-delete"><span class="icon-trash-2"></span></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
                    </table>
                    <?php echo e($tags->links('pagination.custom')); ?>  
                <?php else: ?>
                    <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>  
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
         function confirmation( id = '' ){
            let title           = '<?php echo e(__("general.confirm")); ?>';
            let content         = '<?php echo e(__("general.confirm_content")); ?>';
            let action          = 'deleteConfirmRecord';
            let type_color      = 'green';
            let btn_class       = 'success';
            ConfirmationBox({title, content, action, id, type_color, btn_class})
        }
        document.addEventListener('livewire:load', function () {
           
            $(document).on('click', '.tb-checkaction', function(event){
                let _this   = $(this);
                let status  = '';
                if(_this.is(':checked')){
                    _this.parent().find('#tb-textdes').html("<?php echo e(__('general.active')); ?>");
                    status = 'active';
                } else {
                    _this.parent().find('#tb-textdes').html( "<?php echo e(__('general.deactive')); ?>");
                    status = 'deactive';
                }
                window.livewire.find('<?php echo e($_instance->id); ?>').set('status', status, true);
            });

            $(document).on('change', '#tag_table input:checkbox', function(event){
                let isSelected = false;
                let ids = [];
                $('.tb-tag').each(function(e){
                    let _this = $(this);
                    if(_this.is(':checked')){
                        if(Number(_this.val())){
                            ids.push(Number(_this.val()));
                        }
                        isSelected = true;
                    }
                });
                window.livewire.find('<?php echo e($_instance->id); ?>').set('selectedTags', ids, true)
                if(isSelected){
                    $('#delete-record').removeClass('d-none');
                } else {
                    $('#delete-record').addClass('d-none');
                }
            });

            $(document).on('click', '#checkAll', function(event){
                let __this = $(this);
                if(__this.is(':checked')){
                    $('.tb-tag').prop('checked', true);
                    $('.tb-tag').each(function(e){
                        let _this = $(this);
                    });
                } else {
                    $('.tb-tag').prop('checked', false);
                }

            });
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/taxonomies/tags/tags.blade.php ENDPATH**/ ?>