<div class="<?php echo e($block_key); ?> <?php echo e($custom_class); ?>" <?php if(!$site_view): ?>  wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?>>
    <?php if( !empty($style_css) ): ?>
        <style><?php echo e('.'.$block_key.$style_css); ?></style>
    <?php endif; ?>
    <?php if(!empty($page_content)): ?>
        <section class="tk-main-section" wire:loading.class="tk-section-preloader">
            <?php if(!$site_view): ?>
                <div class="preloader-outer" wire:loading>
                    <div class="tk-preloader">
                        <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <?php echo $page_content; ?>

        </section>
    <?php endif; ?>
</div>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/terms-condition-block.blade.php ENDPATH**/ ?>