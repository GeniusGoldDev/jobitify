<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['project','currency_symbol', 'address_format', 'list_type' => 'search_project' , 'favourite_projects' => [], 'user_role' ]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['project','currency_symbol', 'address_format', 'list_type' => 'search_project' , 'favourite_projects' => [], 'user_role' ]); ?>
<?php foreach (array_filter((['project','currency_symbol', 'address_format', 'list_type' => 'search_project' , 'favourite_projects' => [], 'user_role' ]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php 
    $tag        = '';
    if($list_type == 'fav_project'){
        $proposal = $project->proposals->first();
        if(!empty( $proposal ) ){
            $tag = getTag( $proposal->status );
        }
    }
 
    $fav_class  = '';
    $_text      = __('general.save');
    if(in_array($project->id, $favourite_projects) || $list_type == 'fav_project'){
        $fav_class =  'tk-saved tk-liked';
        $_text =  __('general.saved');
    }

?>
<div class="tk-project-wrapper-two">
    <?php if($project->is_featured): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.featured-tippy','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('featured-tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php endif; ?>
    <span class="tk-project-tag-two <?php echo e($project->project_type == 'fixed' ? 'tk-ongoing-updated' : 'tk-success-tag-updated'); ?>">
        <?php echo e($project->project_type == 'fixed' ?  __('project.fixed_project') : __('project.hourly_project')); ?>

    </span>

    <div class="tk-project-box">
        <div class="tk-price-holder">
            <div class="tk-verified-info">

                <?php if(!empty($tag) ): ?>
                    <span class="<?php echo e($tag['class']); ?>"><?php echo e($tag['text']); ?></span>
                <?php endif; ?>

                <a href="javascript:void(0)">
                    <?php echo e($project->projectAuthor->full_name); ?>

                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.verified-tippy','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('verified-tippy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </a>
                <h5><?php echo e($project->project_title); ?></h5>
                <ul class="tk-template-view">
                    <li>
                        <i class="icon-calendar"></i>
                        <span> <?php echo e(__('project.project_posted_date',['diff_time'=> getTimeDiff( $project->updated_at )])); ?> </span>
                    </li>
                    <li>
                        <i class="icon-map-pin"></i>
                        <span> <?php echo e($project->projectLocation->id == 3 ? (!empty($project->address) ? getUserAddress($project->address, $address_format) : $project->project_country ) : $project->projectLocation->name); ?> </span>
                    </li>
                    <li>
                        <i class="icon-check-circle"></i>
                        <span> <?php echo e(!empty($project->expertiseLevel) ? $project->expertiseLevel->name : ''); ?> </span>
                    </li>
                    <li>
                        <i class="<?php echo e($project->project_hiring_seller > 1 ? 'icon-users' : 'icon-user'); ?>"></i>
                        <span><?php echo e($project->project_hiring_seller .' '. ($project->project_hiring_seller > 1 ? __('project.freelancers') : __('project.freelancer'))); ?></span>
                    </li>
                    <?php if(!is_null($project->project_visits_count)): ?>
                        <li>
                            <span>
                                <i class="icon-eye"></i>
                                <?php echo e($project->project_visits_count == 1 ? __('general.single_view') : __('general.user_views', ['count' => number_format($project->project_visits_count) ] )); ?>

                            </span>
                        </li>
                    <?php endif; ?>
                    <?php if($user_role == 'seller' || Auth::guest()): ?>
                        <li class="<?php echo e($fav_class); ?> mt-0" wire:click.prevent="saveItem(<?php echo e($project->id); ?>)">
                            <i class="icon-heart"></i>
                            <a href="javascript:void(0)"><?php echo e($_text); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="tk-price">
                <span> <?php echo e(__('project.project_budget')); ?></span>
                <h4><?php echo e(getProjectPriceFormat($project->project_type, $currency_symbol, $project->project_min_price, $project->project_max_price)); ?></h4>
                <div class="tk-project-option">
                    <a href="<?php echo e(route('project-detail', ['slug'=> $project->slug] )); ?>" target="_blank" class="tk-invite-bidbtn"><?php echo e(__('project.view_detail')); ?></a>
                </div>
            </div>
        </div>
        <?php if(!empty($project->project_description)): ?>
            <?php 
                $description    = @json_decode($project->project_description);
                $desc           = '';
                if(!empty($description)){
                    $string         = preg_replace("/<br>|\n|\r|<br( ?)\/>/", " ", $description );
                    $desc           = strip_tags(trim($string));
                }
            ?>
            <?php if(!empty($desc)): ?>
                <div class="tk-descriptions">
                    <p><?php echo nl2br(add3DotsInText( $desc, '...', 230)); ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if(!$project->skills->isEmpty()): ?>
            <div class="tk-freelancer-holder">
                <ul class="tk-tags_links">
                    <?php $__currentLoopData = $project->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <span class="tk-blog-tags"><?php echo e($skill->name); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/project-item.blade.php ENDPATH**/ ?>