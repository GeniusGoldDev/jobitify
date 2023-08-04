
<?php $__env->startSection('content'); ?>
    <main class="tk-main-bg"> 
        <section class="tk-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tk-sort">
                            <div class="tk-sortby tk-sorttalent">
                                <div class="tk-actionselect">
                                    <span><?php echo e(__('general.sort_by')); ?>: </span>
                                    <div class="tk-select">
                                        <select id="order_by" data-hide_search_opt="true" class="form-control tk-select2 tk-selectprice">
                                            <option value ="date_desc"> <?php echo e(__('general.date_desc')); ?> </option>
                                            <option value ="price_asc"> <?php echo e(__('general.price_asc')); ?> </option>
                                            <option value ="price_desc"> <?php echo e(__('general.price_desc')); ?> </option>
                                            <option value ="visits_desc"> <?php echo e(__('general.visits_desc')); ?> </option>
                                        </select>
                                    </div>
                                    <a href="javascript:void(0);" class="tk-filtermenu"><i class="icon-sliders"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <aside class="tk-searchfilter">
                            <a href="javascript:void(0);" class="tk-closefilter"><i class="icon-x"></i></a>
                            <div class="tk-searchfilter-wrap">
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#search-tab" role="button" aria-expanded="true">
                                        <h5><?php echo e(__('general.search')); ?></h5>
                                    </div>
                                    <div id="search-tab" class="collapse show">
                                        <div class="tk-aside-content">
                                            <div class="tk-inputiconbtn">
                                                <div class="tk-placeholderholder">
                                                    <input type="text" placeholder="<?php echo e(__('general.search_with_keyword')); ?>" id="search_by_keyword" value="<?php echo e(clean( $keyword )); ?>" class="form-control tk-themeinput">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if(!$skills->isEmpty()): ?>
                                    <div class="tk-aside-holder">
                                        <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#skill-tab" role="button" aria-expanded="false">
                                            <h5><?php echo e(__('skill.text')); ?></h5>
                                        </div>
                                        <div id="skill-tab" class="collapse">
                                            <div class="tk-aside-content">
                                                <div class="tk-filterselect mCustomScrollbar">
                                                    <ul class="tk-categoriesfilter">
                                                        <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li>
                                                                <div class="tk-form-checkbox">
                                                                    <input class="form-check-input tk-form-check-input-sm tk-select-skill" type="checkbox" value="<?php echo e($single->id); ?>" id="skill-<?php echo e($single->id); ?>" />
                                                                    <label class="form-check-label" for="skill-<?php echo e($single->id); ?>">
                                                                        <span> <?php echo $single->name; ?></span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($seller_types)): ?>
                                    <div class="tk-aside-holder">
                                        <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#seller_types-tab" role="button" aria-expanded="false">
                                            <h5><?php echo e(__('general.seller_type')); ?></h5>
                                        </div>
                                        <div id="seller_types-tab" class="collapse">
                                            <div class="tk-aside-content">
                                                <div class="tk-filterselect mCustomScrollbar">
                                                    <ul class="tk-categoriesfilter">
                                                        <?php $__currentLoopData = $seller_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type_key => $sellerType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li>
                                                                <div class="tk-form-checkbox">
                                                                    <input class="form-check-input tk-form-check-input-sm tk-seller-type" type="checkbox" value="<?php echo e($sellerType); ?>" id="seller_types-<?php echo e($type_key); ?>" />
                                                                    <label class="form-check-label" for="seller_types-<?php echo e($type_key); ?>">
                                                                        <span> <?php echo $sellerType; ?></span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#english_level-tab" role="button" aria-expanded="false">
                                        <h5><?php echo e(__('general.english_level')); ?></h5>
                                    </div>
                                    <div id="english_level-tab" class="collapse">
                                        <div class="tk-aside-content">
                                            <div class="tk-filterselect mCustomScrollbar">
                                                <ul class="tk-categoriesfilter">
                                                    <?php $__currentLoopData = $english_levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $eng_level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <div class="tk-form-checkbox">
                                                                <input class="form-check-input tk-form-check-input-sm tk-english-level" type="checkbox" value="basic" id="english_level-<?php echo e($key); ?>" />
                                                                <label class="form-check-label" for="english_level-<?php echo e($key); ?>">
                                                                    <span> <?php echo e($eng_level); ?> </span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if(!$languages->isEmpty()): ?>
                                    <div class="tk-aside-holder">
                                        <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#languages-tab" role="button" aria-expanded="false">
                                            <h5><?php echo e(__('languages.text')); ?></h5>
                                        </div>
                                        <div id="languages-tab" class="collapse">
                                            <div class="tk-aside-content">
                                                <div class="tk-filterselect mCustomScrollbar">
                                                    <ul class="tk-categoriesfilter">
                                                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li>
                                                                <div class="tk-form-checkbox">
                                                                    <input class="form-check-input tk-form-check-input-sm tk-language-select" type="checkbox" value="<?php echo e($single->id); ?>" id="languages-<?php echo e($single->id); ?>" />
                                                                    <label class="form-check-label" for="languages-<?php echo e($single->id); ?>">
                                                                        <span> <?php echo $single->name; ?></span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#price_range-tab" role="button" aria-expanded="<?php echo e(!empty($search_by_hr_rate) ? 'true' : 'false'); ?>">
                                        <h5><?php echo e(__('general.price_range')); ?></h5>
                                    </div>
                                    <div id="price_range-tab" class="collapse <?php echo e(!empty($search_by_hr_rate) ? 'show' : ''); ?>">
                                        <div class="tk-aside-content">
                                            <div class="tk-rangevalue" data-bs-target="#rangecollapse" role="list" aria-expanded="<?php echo e(!empty($search_by_hr_rate) ? 'true' : 'false'); ?>">
                                                <div class="tk-areasizebox">
                                                    <input type="number" class="form-control"  min="<?php echo e($seller_min_hr_rate); ?>" max="<?php echo e($seller_max_hr_rate); ?>" step="1" placeholder="<?php echo e(__('general.seller_min_hr_rate')); ?>" id="seller_min_hr_rate" />
                                                    <input type="number" class="form-control" step="1"  placeholder="<?php echo e(__('general.seller_max_hr_rate')); ?>" id="seller_max_hr_rate" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tk-distanceholder">
                                            <div id="rangecollapse" class="collapse">
                                                <div class="tk-distance">
                                                    <div id="tk-rangeslider" class="tk-tooltiparrow tk-rangeslider"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tk-aside-holder location-tab">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse"  data-bs-target="#location" role="button" aria-expanded="false">
                                        <h5><?php echo e(__('general.location')); ?></h5>
                                    </div>
                                    <div id="location" class="collapse">
                                        <div class="tk-aside-content">
                                            <div class="tk-filterselect">
                                                <div class="tk-select">
                                                    <select id="seller_location" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('general.location_placeholder')); ?>" class="form-control tk-select2">
                                                        <option label="<?php echo e(__('general.location_placeholder')); ?>"></option>
                                                        <?php if(!$locations->isEmpty()): ?>
                                                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($single->id); ?>" ><?php echo e($single->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="clearFilters" class="tk-filterbtns d-none">
                                <a href="javascript:;"  class="tk-btn-solid tk-advancebtn"><?php echo e(__('general.clear_all_filter')); ?> </a>
                            </div>
                        </aside>
                    </div>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.search-sellers', ['perPage' => $per_page,'currencySymbol' => $currency_symbol,'dateFormat' => $date_format,'sellerMinHrRate' => $seller_min_hr_rate,'sellerMaxHrRate' => $seller_max_hr_rate,'addressFormat' => $address_format,'per_page' => $per_page,'currency_symbol' => $currency_symbol,'date_format' => $date_format,'seller_min_hr_rate' => $seller_min_hr_rate,'seller_max_hr_rate' => $seller_max_hr_rate,'keyword' => $keyword,'address_format' => $address_format])->html();
} elseif ($_instance->childHasBeenRendered('hAUlfdR')) {
    $componentId = $_instance->getRenderedChildComponentId('hAUlfdR');
    $componentTag = $_instance->getRenderedChildComponentTagName('hAUlfdR');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('hAUlfdR');
} else {
    $response = \Livewire\Livewire::mount('components.search-sellers', ['perPage' => $per_page,'currencySymbol' => $currency_symbol,'dateFormat' => $date_format,'sellerMinHrRate' => $seller_min_hr_rate,'sellerMaxHrRate' => $seller_max_hr_rate,'addressFormat' => $address_format,'per_page' => $per_page,'currency_symbol' => $currency_symbol,'date_format' => $date_format,'seller_min_hr_rate' => $seller_min_hr_rate,'seller_max_hr_rate' => $seller_max_hr_rate,'keyword' => $keyword,'address_format' => $address_format]);
    $html = $response->html();
    $_instance->logRenderedChild('hAUlfdR', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/css/nouislider.min.css',
        'public/css/rangeslider.css', 
    ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

    <script defer src="<?php echo e(asset('js/vendor/nouislider.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
    
    <script defer src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script>
        window.onload = (event) => {
            var pageloaded = false;
            jQuery(document).ready(function() {
                window.addEventListener('totalFoundResult', event => {
                    let total   = event.detail.total_count;
                    let keyword = event.detail.keyword;

                    if(!keyword.length){
                        $('.tk-sort').find('h3').remove();
                    } else if($('.tk-sort').find('h3').length){
                        $('.tk-sort').find('h3').html(`${total} <?php echo e(__('general.search_result')); ?> “${keyword}”`);
                    }else {
                        $('.tk-sort').prepend(`<h3>${total} <?php echo e(__('general.search_result')); ?> “${keyword}”</h3>`);
                    }
                });
                setTimeout(function() {

                    setTimeout(function() {
                        pageloaded = true;
                    },1000);
                    
                    $(document).on('input', '#search_by_keyword', function(event){
                        let data = {
                            'type' : 'keyword',
                            'keyword' : event.target.value
                        };
                        if(event.target.value.length){
                            $('#clearFilters').removeClass('d-none');
                        }
                        let timer;
                        clearTimeout(timer);
                        timer = setTimeout(()=>{
                            applySearchFilter(data);
                        }, 800);
                    });

                    $(document).on('change', '.tk-select-skill', function(event){
                        let values = [];
                        $('input.tk-select-skill:checkbox:checked').each(function(){
                            values.push($(this).val());
                        });

                        let data = {
                            'type' : 'skills',
                            'skills' : values
                        };

                        if(values.length){
                            $('#clearFilters').removeClass('d-none');
                        } else {
                            $('#clearFilters').addClass('d-none');
                        }
                        applySearchFilter(data);
                    });

                    $(document).on('change', '.tk-seller-type', function(event){
                        let values = [];
                        $('input.tk-seller-type:checkbox:checked').each(function(){
                            values.push($(this).val());
                        });

                        let data = {
                            'type' : 'seller_type',
                            'seller_types' : values
                        };

                        if(values.length){
                            $('#clearFilters').removeClass('d-none');
                        } else {
                            $('#clearFilters').addClass('d-none');
                        }
                        applySearchFilter(data);
                    });

                    $(document).on('change', '.tk-english-level', function(event){
                        let values = [];
                        $('input.tk-english-level:checkbox:checked').each(function(){
                            values.push($(this).val());
                        });

                        let data = {
                            'type' : 'english_level',
                            'english_levels' : values
                        };

                        if(values.length){
                            $('#clearFilters').removeClass('d-none');
                        } else {
                            $('#clearFilters').addClass('d-none');
                        }
                        applySearchFilter(data);
                    });

                    $(document).on('change', '.tk-language-select', function(event){
                        let languages = [];
                        $('input.tk-language-select:checkbox:checked').each(function(){
                            languages.push($(this).val());
                        });

                        let data = {
                            'type' : 'languages',
                            'languages' : languages
                        };

                        if(languages.length){
                            $('#clearFilters').removeClass('d-none');
                        } else {
                            $('#clearFilters').addClass('d-none');
                        }
                        applySearchFilter(data);
                    });

                    $(document).on('change', '#seller_min_hr_rate, #seller_max_hr_rate', function(event){

                        let minValue = $('#seller_min_hr_rate').val();
                        let maxValue = $('#seller_max_hr_rate').val();
                        let data = {
                            'type'      : 'pricerange',
                            'min_price' : minValue,
                            'max_price' : maxValue,
                        };
                        
                        if(pageloaded){
                            $('#clearFilters').removeClass('d-none');
                            applySearchFilter(data);
                        }
                    });

                    $('#order_by').on('change', function (e) {
                        let order_by = $('#order_by').select2("val");

                        let data = {
                            'type'      : 'orderby',
                            'orderby'  : order_by,
                        };
                        applySearchFilter(data);
                        
                    });

                    $('#seller_location').on('change', function (e) {
                        let selected_location = $('#seller_location').select2("val");
                        let data = {
                            'type'      : 'location',
                            'location'  : selected_location,
                        };
                        applySearchFilter(data);
                        if(selected_location){
                            $('#clearFilters').removeClass('d-none');
                        }
                    });

                    $(document).on('click', '#clearFilters', function(event) {
                        let tabs = [
                            'location', 'price_range-tab', 
                            'skill-tab', 'seller_types-tab', 
                            'english_level-tab', 'languages-tab' 
                        ];
                        
                        tabs.map(tab =>{
                            $(`#${tab}`).removeClass('show');
                            $(`div[data-bs-target="#${tab}"]`).attr('aria-expanded', false)
                        });
                    
                        $('#search_by_keyword').val("");
                        $('input.tk-language-select:checkbox').prop('checked', false);
                        $('input.tk-select-skill:checkbox').prop('checked', false);
                        $('input.tk-seller-type:checkbox').prop('checked', false);
                        $('input.tk-english-level:checkbox').prop('checked', false);
                        $('input.tk-language-select:checkbox').prop('checked', false);
                        $('#seller_min_hr_rate').val("<?php echo e($seller_min_hr_rate); ?>").trigger('change');
                        $('#seller_max_hr_rate').val("<?php echo e($seller_max_hr_rate); ?>").trigger('change');
                        $('#seller_location').val('').trigger('change');

                        let data = { 'type' : 'clear_filter'};
                        applySearchFilter(data);
                        $('#clearFilters').addClass('d-none');
                    });

                    let min_hr_rate = Number('<?php echo e($seller_min_hr_rate); ?>');
                    let max_hr_rate = Number('<?php echo e($seller_max_hr_rate); ?>');

                    let params = {
                        range       :  [min_hr_rate, max_hr_rate],
                        min_price   : '<?php echo e($seller_min_hr_rate); ?>',
                        max_price   : '<?php echo e($seller_max_hr_rate); ?>',
                        id1         : 'seller_min_hr_rate',
                        id2         : 'seller_max_hr_rate',
                    }
                   
                    inializePriceRange( params );

                    iniliazeSelect2Scrollbar();
                }, 100);
            });
        }
        
        function applySearchFilter(data){
            window.livewire.emit('ApplySearchFilter', data);
        }

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app',['include_menu' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/front-end/sellers/search-sellers.blade.php ENDPATH**/ ?>