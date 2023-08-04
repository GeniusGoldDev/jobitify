<div class="row justify-content-center">
    <div class="col-xl-8 text-center">
        <div class="tk-postproject-title">
            <h3> <?php echo e(__('project.start_project_txt')); ?> </h3>
            <p> <?php echo e(__('project.start_project_descp')); ?> </p>
        </div>
        <ul class="tk-newproject-list">
            <li wire:click="startProject('new')">
                <a href="javascript:;" class="tk-postproject-new">
                    <i class="icon-file-text tk-purple-icon"></i>
                    <span><?php echo e(__('project.start_new_project')); ?> </span>
                    <p><?php echo e(__('project.start_project_scratch')); ?> </p>
                </a>
            </li>
            <li wire:click="startProject('template')">
                <a href="javascript:;" class="tk-postproject-new">
                    <i class="icon-copy tk-red-icon"></i>
                    <span><?php echo e(__('project.start_template_project')); ?> </span>
                    <p><?php echo e(__('project.start_previous_project')); ?></p>
                </a>
            </li>
        </ul>
    </div>
</div>


      
    <?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/project-step1.blade.php ENDPATH**/ ?>