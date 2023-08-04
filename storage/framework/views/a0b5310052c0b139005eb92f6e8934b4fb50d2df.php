
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['data','enableEdit' => false]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['data','enableEdit' => false]); ?>
<?php foreach (array_filter((['data','enableEdit' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php 
    
    $portfolio_image      = 'images/default-img-285x216.png';
    if(!empty($data['attachments']) ){
        $files  = @unserialize($data['attachments']);
        if( $files == 'b:0;' || $files !== false ){
            $images = $files['files'];
            $latest = current($images);
            if( !empty($latest) && substr($latest->mime_type, 0, 5) == 'image'){
                if(!empty($latest->sizes['285x216'])){
                    $portfolio_image = 'storage/'.$latest->sizes['285x216'];
                } elseif(!empty($latest->file_path)){
                    $portfolio_image = 'storage/'.$latest->file_path;
                }
            }
        }
    }
?>
<div class="tk-potfolioitem">
    <figure>
        <img src="<?php echo e(asset($portfolio_image)); ?>"  alt="<?php echo e($data['title']); ?>">
    </figure>
    <div class="tk-portinfo">
        <a target="_blank" href="<?php echo e(url($data['url'])); ?>"><?php echo e($data['url']); ?></a>
        <h6><?php echo e($data['title']); ?></h6>
        <?php if(!empty($data['description'])): ?>
            <p><?php echo nl2br($data['description']); ?></p>
        <?php endif; ?>
    </div>
    <?php if($enableEdit): ?>
        <div class="tk-detail__icon">
            <a href="javascript:void(0);" class="tk-edit" wire:click.stop="showPortfolioPopup(<?php echo e($data['id']); ?>)"><i class="icon-edit-2"></i></a>
            <a href="javascript:void(0);" class="tk-delete tk-delete-portfolio" data-id="<?php echo e($data['id']); ?>"><i class="icon-trash-2"></i></a>
        </div>
    <?php endif; ?>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/portfolio-item.blade.php ENDPATH**/ ?>