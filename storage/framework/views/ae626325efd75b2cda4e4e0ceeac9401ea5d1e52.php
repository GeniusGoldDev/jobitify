<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['single','date_format', 'hide']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['single','date_format', 'hide']); ?>
<?php foreach (array_filter((['single','date_format', 'hide']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php  
    $ratingPer = 0;
    if(!empty($single->rating)){
        $ratingPer = ($single->rating/5)*100;
    }

    if(!empty($single->buyerInfo->image)){
        $image_url      = getProfileImageURL($single->buyerInfo->image, '50x50');
        $buyer_image   = !empty($image_url) ? 'storage/'.$image_url : 'images/default-user-50x50.png';
    }else{
        $buyer_image   = 'images/default-user-50x50.png';
    }

?>

<div class="tk-reviewnew tk-review-sec <?php echo e($hide ? 'd-none' : ''); ?>">
    <div class="tk-reviewinfo">
        <figure>
            <img src="<?php echo e(asset($buyer_image)); ?>" alt="Image Description">
        </figure>
        <div class="tk-reviwername">
            <h5><?php echo e($single->buyerInfo->fullName); ?></h5>
            <div class="tk-featureratings">
                <span class="tk-featureRating__stars"><span style="width:<?php echo e($ratingPer); ?>%;"></span></span>
                <h6><?php echo e(number_format($single->rating,1)); ?></h6>
            </div>
            <div class="tk-reviews-details">
                <ul class="tk-qualifinfo">
                    <li><span><i class="icon-calendar"></i> <?php echo e(date($date_format, strtotime( $single->created_at ))); ?></span></li>
                </ul>
            </div>
        </div>
    </div>
    <?php if(!empty($single->rating_description)): ?>
        <div class="tk-descriptions">
            <p><?php echo e($single->rating_description); ?></p>
        </div>
    <?php endif; ?>
</div><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/components/review-item.blade.php ENDPATH**/ ?>