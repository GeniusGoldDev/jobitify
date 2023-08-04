
<div wire:sortable="updateBlockOrder"  wire:sortable.options="{ animation: 250 }">
    <?php if( !empty($page_settings) ): ?>
        <?php $__currentLoopData = $page_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div wire:sortable.item="<?php echo e($single['block_id'].'__'.$key); ?>" wire:key="<?php echo e(time().'__'.$key); ?>" class="at-drophere-selected">
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('page-builder.'.$single['block_id'], [ 
                'page_id'       => $page_id,
                'block_key'     => ($single['block_id'].'__'.$key),
                'settings'      => $single['settings'],
                'style_css'     => $single['css'],
                'site_view'     => false])->html();
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
                'site_view'     => false]);
    $html = $response->html();
    $_instance->logRenderedChild(time().'__'.$key, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <ul class="at-dargsection-toltip">
                    <li wire:sortable.handle>
                        <a href="javascript:;"><img src="<?php echo e(asset('pagebuilder/images/grip-two.png')); ?>" alt=""></a>
                    </li>
                    <li wire:click.prevent="cloneBlock(<?php echo e($key); ?>)">
                        <a href="javascript:;"><i class="icon-copy"></i></a>
                    </li>
                    <li wire:click.prevent="deleteBlock(<?php echo e($key); ?>)">
                        <a href="javascript:;"><i class="icon-trash-2"></i></a>
                    </li>
                </ul>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <section wire:key="<?php echo e(now()); ?>"  class="at-drophere-section">
        <div ondrop="dropOver(event)" ondragover="drapOver(event)" ondragleave="dragOut(event)" class="at-drophere-preview">
            <figure>
                <img src="<?php echo e(asset('images/empty-block.png')); ?>" >
                <figcaption><?php echo e(__('pages.drop_section_txt')); ?></figcaption>
            </figure>
        </div>
    </section>
</div>   

<?php $__env->startPush('scripts'); ?>

    <script>

        function drapOver(event){

            event.preventDefault();
            $(event.target).addClass("at-dropover");
        }

        function dragStart(event) {
            event.dataTransfer.setData("id", event.target.id);
        }

        function dragOut(event){

            event.preventDefault();
            $(event.target).removeClass("at-dropover");
        }

        function dropOver(event) {

            event.preventDefault();
            let id = event.dataTransfer.getData("id");
            $(event.target).removeClass("at-dropover");
            if( id != "" ){
                window.livewire.find('<?php echo e($_instance->id); ?>').set('dropped_block_id', id);
            }
        }

        document.addEventListener('livewire:load', function () {

            $(document).on('click', '.at-drophere-selected', function(e) {
                $('.at-drophere-selected').removeClass('active');
                let _this = $(this);
                _this.addClass('active');
                let widow_width = $( window ).width();
                if( widow_width <= 1680 ){
                    $('.at-pagebuilder-holder').removeClass('at-openmenu');
                }
            });

            $(document).on('click', '.publish-page', function(e) {
                Livewire.emit('publish-page');
            });
            
        });
    
    </script>
<?php $__env->stopPush(); ?>
   <?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/page-render.blade.php ENDPATH**/ ?>