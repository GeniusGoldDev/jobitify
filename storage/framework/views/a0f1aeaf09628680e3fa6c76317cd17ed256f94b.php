
<?php $__env->startSection('content'); ?>
<main class="tk-main-bg">
    <section class="tk-main-section tk-main-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tk-sort tk-searchproject">
                        <div class="tk-sortby">
                            <div class="tk-actionselect">
                                <span><?php echo e(__('general.sort_by')); ?>: </span>
                                <div class="tk-select">
                                    <select id="order_by" data-hide_search_opt="true" class="form-control tk-selectprice tk-select2">
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
                                                <input type="text" value="<?php echo e($keyword); ?>" placeholder="<?php echo e(__('general.search_with_keyword')); ?>" id="search_by_keyword" class="form-control tk-themeinput">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tk-aside-holder">
                                <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#project_type-tab" role="button" aria-expanded="false">
                                    <h5><?php echo e(__('project.project_type')); ?></h5>
                                </div>
                                <div id="project_type-tab" class="collapse">
                                    <div class="tk-aside-content">
                                        <div class="tk-actionselect">
                                            <div class="tk-select">
                                                <select id="project_type" data-placeholder="<?php echo e(__('project.project_type')); ?>" data-hide_search_opt="true" class="form-control tk-select2">
                                                    <option label="<?php echo e(__('project.project_type')); ?>"></option>
                                                    <option value="all"> <?php echo e(__('project.all_projects')); ?> </option>
                                                    <option value="fixed"> <?php echo e(__('project.fixed_type')); ?> </option>
                                                    <option value="hourly"> <?php echo e(__('project.hourly_type')); ?> </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tk-aside-holder">
                                <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#category-tab" role="button" aria-expanded="<?php echo e(!empty($category_id) ? 'true' : 'false'); ?>">
                                    <h5><?php echo e(__('category.text')); ?></h5>
                                </div>
                                <div id="category-tab" class="collapse <?php echo e(!empty($category_id) ? 'show' : ''); ?>">
                                    <div class="tk-aside-content">
                                        <div class="tk-filterselect">
                                            <input type="text" id="category_tree" autocomplete="off" placeholder="<?php echo e(__('general.select')); ?>"/>
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
                                                                <input class="form-check-input tk-selectedskill tk-form-check-input-sm" type="checkbox" value="<?php echo e($single->id); ?>" id="skill-<?php echo e($single->id); ?>" />
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
                            <?php if(!$expertise_levels->isEmpty()): ?>
                                <div class="tk-aside-holder">
                                    <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#expertise_level-tab" role="button" aria-expanded="false">
                                        <h5><?php echo e(__('expert_levels.text')); ?></h5>
                                    </div>
                                    <div id="expertise_level-tab" class="collapse">
                                        <div class="tk-aside-content">
                                            <div class="tk-filterselect mCustomScrollbar">
                                                <ul class="tk-categoriesfilter">
                                                    <?php $__currentLoopData = $expertise_levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <div class="tk-form-checkbox">
                                                                <input class="form-check-input tk-expertlevel tk-form-check-input-sm" type="checkbox" value="<?php echo e($single->id); ?>" id="expertise_level-<?php echo e($single->id); ?>" />
                                                                <label class="form-check-label" for="expertise_level-<?php echo e($single->id); ?>">
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
                                                                <input class="form-check-input tk-selectlang tk-form-check-input-sm" type="checkbox" value="<?php echo e($single->id); ?>" id="languages-<?php echo e($single->id); ?>" />
                                                                <label class="form-check-label" for="languages-<?php echo e($single->id); ?>">
                                                                    <span> <?php echo e($single->name); ?></span>
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
                                <div class="tk-asidetitle" data-bs-toggle="collapse" data-bs-target="#price_range-tab" role="button" aria-expanded="<?php echo e(!empty($search_by_price) ? 'true' : 'false'); ?>">
                                    <h5><?php echo e(__('general.price_range')); ?></h5>
                                </div>
                                <div id="price_range-tab" class="collapse <?php echo e(!empty($search_by_price) ? 'show' : ''); ?>">
                                    <div class="tk-aside-content">
                                        <div class="tk-rangevalue" data-bs-target="#rangecollapse" role="list" aria-expanded="<?php echo e(!empty($search_by_price) ? 'true' : 'false'); ?>">
                                            <div class="tk-areasizebox">
                                                <input type="number" class="form-control"  min="<?php echo e($project_min_price); ?>"  max="<?php echo e($project_max_price); ?>" step="1" placeholder="<?php echo e(__('project.min_price')); ?>" id="project_min_price" />
                                                <input type="number" class="form-control" step="1"  placeholder="<?php echo e(__('project.max_price')); ?>" id="project_max_price" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tk-distanceholder">
                                        <div id="rangecollapse" class="collapse <?php echo e(!empty($search_by_price) ? 'show' : ''); ?>">
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
                                                <select id="project_location" data-placeholderinput="<?php echo e(__('general.search')); ?>" data-placeholder="<?php echo e(__('general.location_placeholder')); ?>" class="form-control tk-select2">
                                                    <option label="<?php echo e(__('general.location_placeholder')); ?>"></option>
                                                    <?php if(!$locations->isEmpty()): ?>
                                                        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($single->id); ?>"><?php echo e($single->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="clearFilters" class="tk-filterbtns <?php echo e($filter_class); ?>">
                            <a href="javascript:;"  class="tk-btn-solid tk-advancebtn"><?php echo e(__('general.clear_all_filter')); ?> </a>
                        </div>
                        
                    </aside>
                </div>
                <?php 
                $price_range = [ 
                    'min'   => $min_price,
                    'max'   => $max_price,
                ];
                ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('project.search-projects', ['priceRange' => $price_range,'categoryId' => $category_id,'projectMinPrice' => $project_min_price,'projectMaxPrice' => $project_max_price,'price_range' => $price_range,'keyword' => $keyword,'category_id' => $category_id,'project_min_price' => $project_min_price,'project_max_price' => $project_max_price])->html();
} elseif ($_instance->childHasBeenRendered('9EPQXmo')) {
    $componentId = $_instance->getRenderedChildComponentId('9EPQXmo');
    $componentTag = $_instance->getRenderedChildComponentTagName('9EPQXmo');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('9EPQXmo');
} else {
    $response = \Livewire\Livewire::mount('project.search-projects', ['priceRange' => $price_range,'categoryId' => $category_id,'projectMinPrice' => $project_min_price,'projectMaxPrice' => $project_max_price,'price_range' => $price_range,'keyword' => $keyword,'category_id' => $category_id,'project_min_price' => $project_min_price,'project_max_price' => $project_max_price]);
    $html = $response->html();
    $_instance->logRenderedChild('9EPQXmo', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
        'public/common/css/combotree.css', 
    ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('js/vendor/nouislider.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('common/js/combotree.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script>
        window.onload = (event) => {
            var pageloaded          = false;
            var filter_record       = {}
            var categoryInstance    = null;
            var applyFilter         = true;
            
            jQuery(document).ready(function() {
                setTimeout(function() {
                    pageloaded = true;
                },1000);

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

                initDropDown();

                function initDropDown(){
                    if(categoryInstance != null){
                        categoryInstance.clearSelection();
                        categoryInstance.destroy();
                    }
                    
                    let settings = {
                        source : window.categories,
                        isMultiple: false
                    }
                    let category_id = window.category_id;
                    if(category_id){
                        settings['selected'] = [category_id.toString()]
                    }
                    categoryInstance = $('input[id="category_tree"]').comboTree(settings);
                }

                $(document).on('input', '#search_by_keyword', function(event){
                    filter_record['keyword'] =  event.target.value;
                    if(event.target.value.length){
                        $('#clearFilters').removeClass('d-none');
                    }else{
                        $('.tk-sort').find('h3').remove();
                    }
                    let timer;
                    clearTimeout(timer);
                    timer = setTimeout(()=>{
                        if(applyFilter){
                            applySearchFilter();
                        }
                    }, 800);
                });

                $(document).on('change', '#project_type', function (e) {
                    let project_type                = $('#project_type').select2("val");
                    filter_record['project_type']   =  project_type;
                    $('#clearFilters').removeClass('d-none');
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', '#order_by', function (e) {
                    let order_by                = $('#order_by').select2("val");
                    filter_record['order_by']   =  order_by;
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', '#project_location', function (e) {
                    let project_location                = $('#project_location').select2("val");
                    filter_record['project_location']   =  project_location;
                    $('#clearFilters').removeClass('d-none');
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', 'input[id^="category_tree"]', function(event){
                    if(categoryInstance){
                        let id = categoryInstance.getSelectedIds();
                        if(id && id.length){
                            filter_record['category'] = id[0];
                            $('#clearFilters').removeClass('d-none');
                        }
                        if(applyFilter){
                            applySearchFilter();
                        }
                    }
                });

                $(document).on('change', '.tk-selectedskill', function(event){
                    let skills = [];
                    $('input.tk-selectedskill:checkbox:checked').each(function(){
                        skills.push($(this).val());
                    });

                    filter_record['skills'] = skills;

                    if(skills.length){
                        $('#clearFilters').removeClass('d-none');
                    } else if( !Object.keys(filter_record).length ) {
                        $('#clearFilters').addClass('d-none');
                    }
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', '.tk-expertlevel', function(event){
                    let expertlevels = [];
                    $('input.tk-expertlevel:checkbox:checked').each(function(){
                        expertlevels.push($(this).val());
                    });

                    filter_record['expertlevels'] = expertlevels;

                    if(expertlevels.length){
                        $('#clearFilters').removeClass('d-none');
                    } else if( !Object.keys(filter_record).length ) {
                        $('#clearFilters').addClass('d-none');
                    }
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', '.tk-selectlang', function(event){
                    let languages = [];
                    $('input.tk-selectlang:checkbox:checked').each(function(){
                        languages.push($(this).val());
                    });

                    filter_record['languages'] = languages;

                    if(languages.length){
                        $('#clearFilters').removeClass('d-none');
                    } else if( !Object.keys(filter_record).length ) {
                        $('#clearFilters').addClass('d-none');
                    }
                    if(applyFilter){
                        applySearchFilter();
                    }
                });

                $(document).on('change', '#project_min_price, #project_max_price', function(event){
                    let minValue = Number( $('#project_min_price').val() );
                    let maxValue = Number( $('#project_max_price').val() );                   

                    if(pageloaded){
                        filter_record['pricerange'] = [
                            !isNaN(minValue) ? minValue : 1 ,
                            !isNaN(maxValue) ? maxValue : Number("<?php echo e($max_price); ?>") 
                        ];
                        $('#clearFilters').removeClass('d-none');
                        if(applyFilter){
                            applySearchFilter();
                        }
                    }
                });

                $(document).on('click', '#clearFilters', function(event) {
                    applyFilter = false;
                    $('.tk-sort').find('h3').remove();
                    let tabs = [
                        'location', 'price_range-tab', 
                        'skill-tab', 'project_type-tab', 
                        'languages-tab' 
                    ];
                    
                    tabs.map(tab =>{
                        $(`#${tab}`).removeClass('show');
                        $(`div[data-bs-target="#${tab}"]`).attr('aria-expanded', false)
                    });
                
                    $('#search_by_keyword').val("");
                    $('#project_type').val('').trigger('change');
                    $('#project_location').val('').trigger('change');
                    

                    $('input.tk-selectlang:checkbox').prop('checked', false);
                    $('input.tk-selectedskill:checkbox').prop('checked', false);
                    
                    let id = categoryInstance.getSelectedIds();
                    
                    if(id && id.length){
                        categoryInstance.clearSelection();
                    }

                    $('input.tk-expertlevel:checkbox').prop('checked', false);


                    let stepsSlider = document.getElementById('tk-rangeslider');
                    $('#project_min_price').val(function(i, val){
                        stepsSlider.noUiSlider.set([ Number("<?php echo e($min_price); ?>"), null]);
                        return 1;
                    }).trigger('input');

                    $('#project_max_price').val(function(i, val){
                        stepsSlider.noUiSlider.set([null, Number("<?php echo e($max_price); ?>")]);
                        return 100000;
                    }).trigger('input');

                    filter_record = {};
                    applySearchFilter();
                    applyFilter = true
                    $('#clearFilters').addClass('d-none');
                });
                
                let params = {
                    range       : [ Number("<?php echo e($min_price); ?>"), Number("<?php echo e($max_price); ?>") ],
                    min_price   : Number('<?php echo e($project_min_price); ?>'),
                    max_price   : Number('<?php echo e($project_max_price); ?>'),
                    id1         : 'project_min_price',
                    id2         : 'project_max_price',
                }

                inializePriceRange( params );
                iniliazeSelect2Scrollbar();

                function applySearchFilter(){
                    window.livewire.emit('ApplySearchFilter', filter_record);
                }
            });
        }

        
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app',['include_menu' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/front-end/projects/search-projects.blade.php ENDPATH**/ ?>