<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
        <div class="tk-postproject-title">
            <h3><?php echo e(__('project.choose_template')); ?></h3>
            <p><?php echo e(__('project.choose_template_desc')); ?></p>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="tk-template-serach">
            <a href="javascript:;" wire:click.prevent="startProject"  class="tk-btnline"><i class=" icon-chevron-left"></i><?php echo e(__('project.go_back')); ?></a>
            
            <div class="tk-select">
                <select wire:model="per_page" id="tk-select-perpage" class="form-control">
                    <?php $__currentLoopData = $per_page_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($opt); ?>" <?php if($per_page == $opt): ?> selected <?php endif; ?> ><?php echo e($opt); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="tk-inputicon">
                <input type="text" class="form-control" wire:model.debounce.500ms="searchProject" placeholder="<?php echo e(__('general.search_with_keyword')); ?>">
                <i class="icon-search"></i>
            </div>
        </div>
       <?php if(!$projects->isEmpty()): ?>
            <ul class="tk-template-list">
                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <div class="tk-template-list_content">
                            <span class="tk-project-tag-two <?php echo e($single->project_type == 'fixed' ?  'tk-ongoing-updated' : 'tk-success-tag-updated'); ?>"> <?php echo e($single->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')); ?> </span>
                            <div class="tk-template-info">
                                <h5><?php echo e($single->project_title); ?></h5>
                                <ul class="tk-template-view">
                                    <li>
                                        <i class="icon-calendar"></i>
                                        <span> <?php echo e(__('project.project_posted_date',['diff_time'=> getTimeDiff( $single->updated_at)])); ?> </span>
                                    </li>
                                    <li>
                                        <i class="icon-map-pin"></i>
                                        <span><?php echo e($single->projectLocation->id == 3 ? (!empty($single->address) ? getUserAddress($single->address, $address_format) : $single->project_country ) : $single->projectLocation->name); ?> </span>
                                    </li>
                                    <li>
                                        <i class="icon-briefcase"></i>
                                        <span> <?php echo e(!empty($single->expertiseLevel) ? $single->expertiseLevel->name : ''); ?> </span>
                                    </li>
                                    <li>
                                        <i class="<?php echo e($single->project_hiring_seller > 1 ? 'icon-users' : 'icon-user'); ?>"></i>
                                        <span><?php echo e($single->project_hiring_seller .' '. ($single->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer'))); ?></span>
                                    </li>
                                </ul>
                            </div>
                            <a href="javascript:;" wire:click.prevent="cloneProject( <?php echo e($single->id); ?> )" class="tk-btn-solid-lg-lefticon"> <?php echo e(__('project.use_project_template')); ?> </a>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php echo e($projects->links('pagination.custom')); ?>

        <?php else: ?>
            <div class="tk-submitreview">
                <figure>
                    <img src="<?php echo e(asset('images/empty.png')); ?>" alt="<?php echo e(__('general.no_record')); ?>">
                </figure>
                <h4><?php echo e(__('general.no_record')); ?></h4>
                <a href="<?php echo e(route('create-project')); ?>" class="tk-btn-solid-lefticon"> <?php echo e(__('project.add_new_project')); ?> </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/project-templates.blade.php ENDPATH**/ ?>