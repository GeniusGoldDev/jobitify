
    <?php $__env->startSection('content'); ?>
        <?php if( !empty($page_settings) ): ?>
            <?php $__currentLoopData = $page_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('page-builder.'.$single['block_id'], [ 
                'page_id'       => $page_id,
                'block_key'     => ($single['block_id'].'__'.$key),
                'settings'      => $single['settings'],
                'style_css'     => $single['css'],
                'site_view'     => true])->html();
} elseif ($_instance->childHasBeenRendered(time().'__'.$key)) {
    $componentId = $_instance->getRenderedChildComponentId(time().'__'.$key);
    $componentTag = $_instance->getRenderedChildComponentTagName(time().'__'.$key);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild(time().'__'.$key);
} else {
    $response = \Livewire\Livewire::mount('page-builder.'.$single['block_id'], [ 
                'page_id'       => $page_id,
                'block_key'     => ($single['block_id'].'__'.$key),
                'settings'      => $single['settings'],
                'style_css'     => $single['css'],
                'site_view'     => true]);
    $html = $response->html();
    $_instance->logRenderedChild(time().'__'.$key, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>       
    <?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.app',['title' => $title, 'page_description' => $pg_description, 'site_view' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/front-end/page.blade.php ENDPATH**/ ?>