<main class="tb-main">
    <div class ="row">
        <?php echo $__env->make('livewire.admin.email-templates.update', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="col-lg-8 col-md-12 tb-md-60">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('email_template.all_templates')); ?></h4>
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
                <?php if( !$listed_templated->isEmpty() ): ?>
                    <table class="table tb-table tb-dbholder">
                        <thead>
                            <tr>
                                <th><?php echo e(__('email_template.email_title')); ?> </th>
                                <th><?php echo e(__('email_template.role_type')); ?></th>
                                <th><?php echo e(__('general.status')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $listed_templated; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>  
                                    <td data-label="<?php echo e(__('email_template.email_title')); ?>"><span><?php echo $single->title; ?></span></td>
                                    <td data-label="<?php echo e(__('email_template.role_type')); ?>"><span><?php echo e(ucfirst($single->role)); ?></span></td>
                                    <td data-label="<?php echo e(__('general.status')); ?>">
                                        <em class="tk-project-tag tk-<?php echo e($single->status == 'active' ? 'active' : 'disabled'); ?>"><?php echo e($single->status == 'active' ? __('general.active') : __('general.deactive')); ?></em>
                                    </td>
                                    <td data-label="<?php echo e(__('general.actions')); ?>">
                                        <ul class="tb-action-icon">
                                            <li> <a href="javascript:void(0);" wire:click.prevent="edit(<?php echo e($single->id); ?>)"><i class="icon-edit-3"></i></a> </li> 
                                            <li> <a href="javascript:;" onClick="confirmation(<?php echo e($single->id); ?>)" class="tb-delete"><i class="ti-trash"></i></a> </li> 
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </tbody>
                    </table>
                    <?php echo e($listed_templated->links('pagination.custom')); ?>  
                <?php else: ?>
                    <?php echo $__env->make('admin.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>  
            </div>
        </div>
    </div>
</main>

<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
<script>
    document.addEventListener('livewire:load', function () {
        initSelect2();

        window.addEventListener('initSelect2', event => {
            initSelect2();
        });

        function initSelect2(){
            $('#template_key').select2(
                { allowClear: true}
            );

            $(document).on('change', '#template_key', function (e) {
                let template_key = $('#template_key').select2("val");
                window.livewire.find('<?php echo e($_instance->id); ?>').set('template_key', template_key);
            });

            iniliazeSelect2Scrollbar();
        }
    });


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
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/admin/email-templates/email-templates.blade.php ENDPATH**/ ?>