
<div class="tk-bannerv5 <?php echo e($block_key); ?> <?php echo e($custom_class); ?>" <?php if(!$site_view): ?> wire:click="$emit('getBlockSetting', '<?php echo e($block_key); ?>')" <?php endif; ?> <?php if( !empty($header_background) ): ?> style="background-image: url(<?php echo e(asset($header_background)); ?>)" <?php endif; ?>>
    
    <?php if( !empty($style_css) ): ?>
        <style><?php echo e('.'.$block_key.$style_css); ?></style>
    <?php endif; ?>
    <div class="container" wire:loading.class="tk-section-preloader">
        <?php if(!$site_view): ?>
            <div class="preloader-outer" wire:loading>
                <div class="tk-preloader">
                    <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
                </div>
            </div>
        <?php endif; ?>
        <div class="row align-content-center">
            <div class="col-xl-7">
                <div class="tk-banner-content">
                    <div class="tk-bannerv3_title">
                        <?php echo $heading; ?>

                    </div>
                    <ul class="tk-themebanner_list">
                        <li><a href="<?php echo e(route('search-projects')); ?>" class="tk-btn-solid-lg tk-btn-yellow"><?php echo e($work_btn_txt); ?><i class="icon-briefcase"></i></a></li>
                        <li><a href="<?php echo e(route('search-sellers')); ?>" class="tk-btn-solid-white"><?php echo e($talent_btn_txt); ?> <i class="icon-user-check"></i></a></li>
                        <li class="tk-linestyle"><img src="<?php echo e(asset('images/line.png')); ?>" alt="image"><span><?php echo e($after_btn_text); ?></span></li>
                    </ul>
                    <?php if(!empty($counter_option)): ?>
                        <ul id="tk-counter" class="tk-counter">
                            <?php $__currentLoopData = $counter_option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <h4><?php echo e($option['heading']); ?></h4>
                                    <h6><?php echo e($option['content']); ?></h6>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="tk-talents-search">
                    <?php if(!empty($form_title) || !empty($form_content)): ?>
                        <div class="tk-talents-search_title">
                            <?php if(!empty($form_title)): ?><h4><?php echo e($form_title); ?></h4><?php endif; ?>
                            <?php if(!empty($form_content)): ?><p><?php echo e($form_content); ?></p><?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="tk-talents-search_content">
                        <form class="tk-themeform">
                            <fieldset>
                                <div class="tk-themeform__wrap">
                                    <div class="form-group">
                                        <label class="tk-label"><?php echo e(__('pages.looking_for_txt')); ?></label>
                                        <div class="tk-inputicon">
                                            <i class="icon-search"></i>
                                            <input type="text" id="search_keyword" class="form-control" name="search" placeholder="Search with keyword" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="tk-label"><?php echo e(__('pages.about_category_txt')); ?></label>
                                        <div class="tk-select tk-selecthas-icon">
                                            <i class="icon-layers"></i>
                                            <select id="tk_category_opt" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('pages.select_list_type')); ?>" class="form-control">
                                                <option label="<?php echo e(__('pages.select_list_type')); ?>"></option>
                                                <option value="sellers"><?php echo e(__('pages.seller_opt')); ?></option>
                                                <option value="projects"><?php echo e(__('pages.project_opt')); ?></option>
                                                <option value="gigs"><?php echo e(__('pages.gigs_opt')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="tk-label"><?php echo e(__('pages.budget_range')); ?></label>
                                        <div class="tk-rangeslider-wrapper">
                                            <div class="tk-distance">
                                                <div id="tk-rangeslider" class="tk-rangeslider-two"></div>
                                            </div>
                                            <div class="tk-rangevalue">
                                                <div class="tk-areasizebox">
                                                    <input id="tk_min_price_search" type="number" class="form-control" min="0" max="40" step="1" placeholder="<?php echo e(__('pages.min_price')); ?>" id="tk-min-value" />
                                                    <input id="tk_max_price_search" type="number" class="form-control" step="1" placeholder="<?php echo e(__('pages.max_price')); ?>" id="tk-max-value" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="tk-searchbtn">
                                            <a href="javascript:void(0)" onClick="searchCategory()" class="tk-btn-solid-lg tk-btn-yellow"><?php echo e(__('pages.search_txt')); ?> <i class="icon-search"></i> </a>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/css/nouislider.min.css',
        'public/css/rangeslider.css', 
    ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

    <script defer src="<?php echo e(asset('js/vendor/nouislider.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
    <script>
        
        document.addEventListener('livewire:load', function () {

            setTimeout(() => {
                $('#tk_category_opt').select2(
                    { allowClear: true, minimumResultsForSearch: -1 }
                );

                let params = {
                        range       :  [1, 100000],
                        min_price   : 1,
                        max_price   : 100000,
                        id1         : 'tk_min_price_search',
                        id2         : 'tk_max_price_search',
                    }
                inializePriceRange( params );
            }, 1000);
        });

        function searchCategory() {

            if ( history.pushState ) {

                let searchParams = new URLSearchParams(window.location.search);
                let categoryType        = $('#tk_category_opt').select2("val");
                let keyword             = jQuery('#search_keyword').val();
                let min_price           = jQuery('#tk_min_price_search').val();
                let max_price           = jQuery('#tk_max_price_search').val();
                let route               = '';
                let min_price_txt       = '';
                let max_price_txt       = '';
                if( categoryType == 'sellers' ){

                    route = "<?php echo e(route('search-sellers')); ?>";
                    min_price_txt = 'seller_min_hr_rate';
                    max_price_txt = 'seller_max_hr_rate';
                }else if(categoryType == 'gigs'){

                    route = "<?php echo e(route('search-gigs')); ?>";
                    min_price_txt = 'min_price';
                    max_price_txt = 'max_price';
                }else{
                    route = "<?php echo e(route('search-projects')); ?>";
                    min_price_txt = 'project_min_price';
                    max_price_txt = 'project_max_price';
                }

                if( route != ''){
                    let URL = `${route}?${min_price_txt}=${min_price}&${max_price_txt}=${max_price}&keyword=${keyword}`;
                    location.href = URL;
                }
            }
        }
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/pagebuilder/header-block.blade.php ENDPATH**/ ?>