<!DOCTYPE html>
<html lang="en">
    <head>
        <?php  
            $sitInfo        = getSiteInfo();
            $siteFavicon    = $sitInfo['site_favicon'];
            $siteDarkLogo   = $sitInfo['site_dark_logo'];
            $siteLiteLogo   = $sitInfo['site_lite_logo'];
            $currentURL     = url()->current();
            $siteLogo       = url('/') == $currentURL ? $siteDarkLogo : $siteLiteLogo;

            $header_menu    = getHeaderMenu();
        ?>
        <meta charset="utf-8">
        <?php if( !empty($siteFavicon) ): ?>
            <link rel="icon" href="<?php echo e(asset('storage/'.$siteFavicon)); ?>" type="image/x-icon">
        <?php endif; ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $__env->yieldContent('title'); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/feather-icons.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('common/css/bootstrap.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
    </head>
    <body>
    <!-- HEADER START -->
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header','data' => ['sitelogo' => $siteLogo,'headerMenu' => $header_menu]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['sitelogo' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($siteLogo),'header_menu' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($header_menu)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
	<!-- HEADER END -->
    <main class="tk-main-bg">
        <section class="tk-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-8 m-auto">
                        <div class="tk-errorpage">
                            <figure>
                                <img src="<?php echo $__env->yieldContent('img'); ?>" />
                            </figure>
                            <div class="tk-notfound-title">
                                <h2><?php echo $__env->yieldContent('message'); ?></h2>
                                <?php if (! empty(trim($__env->yieldContent('message_desc')))): ?>
                                    <p><?php echo $__env->yieldContent('message_desc'); ?><p>
                                <?php endif; ?>
                                <em><?php echo e(__('general.error_text_desc')); ?> <a href="<?php echo e(url('/')); ?>"><?php echo e(__('general.go_to_home_link')); ?></a></em>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FOOTER START -->
            <?php
                $footer_settings = getFooterSettings('footer_page');
            ?>
            <?php if(! empty($footer_settings) ): ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('page-builder.footer-block', ['pageId' => $footer_settings['page_id'],'blockKey' => $footer_settings['block_key'],'styleCss' => $footer_settings['style_css'],'siteView' => true,'page_id' => $footer_settings['page_id'],'block_key' => $footer_settings['block_key'],'settings' => $footer_settings['settings'],'style_css' => $footer_settings['style_css'],'site_view' => true])->html();
} elseif ($_instance->childHasBeenRendered('CFGsQ5f')) {
    $componentId = $_instance->getRenderedChildComponentId('CFGsQ5f');
    $componentTag = $_instance->getRenderedChildComponentTagName('CFGsQ5f');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('CFGsQ5f');
} else {
    $response = \Livewire\Livewire::mount('page-builder.footer-block', ['pageId' => $footer_settings['page_id'],'blockKey' => $footer_settings['block_key'],'styleCss' => $footer_settings['style_css'],'siteView' => true,'page_id' => $footer_settings['page_id'],'block_key' => $footer_settings['block_key'],'settings' => $footer_settings['settings'],'style_css' => $footer_settings['style_css'],'site_view' => true]);
    $html = $response->html();
    $_instance->logRenderedChild('CFGsQ5f', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>
	    <!-- FOOTER END -->
    </main>

        <script src="<?php echo e(asset('common/js/jquery.min.js')); ?>"></script>
		<script defer src="<?php echo e(asset('common/js/bootstrap.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('common/js/jquery.mCustomScrollbar.min.js')); ?>"></script>
		<script defer src="<?php echo e(asset('js/main.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/errors/minimal.blade.php ENDPATH**/ ?>