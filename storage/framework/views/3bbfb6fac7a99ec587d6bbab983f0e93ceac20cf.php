<main>
    <section class="tk-main-section tk-main-bg">
        <div class="preloader-outer" wire:loading wire:target="updateStep,inviteSeller,update">
            <div class="tk-preloader">
                <img class="fa-spin" src="<?php echo e(asset('images/loader.png')); ?>">
            </div>
        </div>
        <div class="container">
            <?php if($useTemplate): ?>
                <?php echo $__env->make('livewire.project.project-templates', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('livewire.project.project-step'.$step, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/pagebuilder/css/tinymce/tinymce.css', 
    ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

<script defer src="<?php echo e(asset('pagebuilder/js/tinymce/tinymce.min.js')); ?>"></script>
<script defer src="<?php echo e(asset('js/app.js')); ?>"></script>
<script defer src="<?php echo e(asset('common/js/select2.min.js')); ?>"></script>

<script>

    document.addEventListener('livewire:load', function () {
       
        window.livewire.on('file-dropped', (event) => {
            if (event.dataTransfer.files.length > 0) {
                const files = event.dataTransfer.files;
                window.livewire.find('<?php echo e($_instance->id); ?>').uploadMultiple('files', files,
                    (uploadedFilename) => {
                    }, (error) => {
                        console.log(error)
                    }, (event) => {
                    }
                )
            }

        });

        $(document).on('click', '.tk-payout-opt', function(event){
            let _this = jQuery(this);
            jQuery('.tk-payout-opt').each((index, item)=>{
                let _item = jQuery(item);
                _item.prop('checked', false);
            })
            _this.prop('checked', true);
        });
        
        $(document).on('click', '.tb-themeselect .tb-select', function(event) {

            setTimeout(function() {
                $('.tb-categorytree-dropdown').mCustomScrollbar();
            }, 0);
            $(this).next(".tb-themeselect_options").slideToggle(300);
            event.stopPropagation();
        });

        $(document).on('click', '.tb-themeselect_options li label', function(event) {
            let listText = jQuery(this).text();
            $('.tb-themeselect_value').text(listText);
            $(this).parents(".tb-themeselect_options").slideUp();
            $('.tb-categorytree-dropdown').mCustomScrollbar('destroy');
        });
        
        // OUTSIDE CLICK CLOSE
        jQuery(document).on('click','body',function(e) {
            jQuery('.tb-themeselect .tb-select').children('.tb-themeselect_options').slideUp(300);
        });

        setTimeout(function() {

            function initStep2JS(){
                $('#project_location, #project_country, #project_category, #project_duration, #payment_mode').select2(
                    { allowClear: true }
                );

                $('#project_location').on('change', function (e) {
                    let project_location = $('#project_location').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('project_location', project_location);
                });

                $('#project_country').on('change', function (e) {
                    let project_country = $('#project_country').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('project_country', project_country, true);
                });

                $('#project_category').on('change', function (e) {
                    let project_category = $('#project_category').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('project_category', project_category, true);
                });

                $('#project_duration').on('change', function (e) {
                    let project_duration = $('#project_duration').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('project_duration', project_duration, true);
                });

                $('#payment_mode').on('change', function (e) {
                    let payment_mode = $('#payment_mode').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('payment_mode', payment_mode, true);
                });

                $('.tb-categorytree-dropdown').mCustomScrollbar('destroy');
            }

            function initStep3JS(){
                $('#project_skills, #project_languages').select2(
                    { allowClear: true, closeOnSelect: false }
                );
                $('#expertise_level, #no_of_freelancer').select2(
                    { allowClear: true }
                );

                $('#expertise_level').on('change', function (e) {
                    let expertise_level = $('#expertise_level').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('expertise_level', expertise_level, true);
                });

                $('#project_skills').on('change', function (e) {
                    let project_skills = $('#project_skills').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('project_skills', project_skills, true);
                });

                $('#project_languages').on('change', function (e) {
                    let project_languages = $('#project_languages').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('project_languages', project_languages, true);
                });

                $('#no_of_freelancer').on('change', function (e) {
                    let no_of_freelancer = $('#no_of_freelancer').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('no_of_freelancer', no_of_freelancer, true);
                });
            }

            if( '<?php echo e($step); ?>' == 2 ){
                initStep2JS();
               
            }else if('<?php echo e($step); ?>' == 3){
                initStep3JS();
            }
            
            iniliazeSelect2Scrollbar();
            window.addEventListener('initTemplate', event => {
                jQuery('#tk-select-perpage').select2( {
                    allowClear: true,
                    minimumResultsForSearch: -1
                });
                $('#tk-select-perpage').on('change', function (e) {
                    let per_page = $('#tk-select-perpage').select2("val");
                    window.livewire.find('<?php echo e($_instance->id); ?>').set('per_page', per_page);
                });

                iniliazeSelect2Scrollbar();
            })
            window.addEventListener('initStep2-js', event=>{
                initStep2JS();
                iniliazeSelect2Scrollbar();
            });

            window.addEventListener('initStep3-js', event=>{
                initStep3JS();
                iniliazeSelect2Scrollbar();
            });

            if (window.history && window.history.pushState) {
                $(window).on('popstate', function() {
                    initStep2JS();
                    initStep3JS();
                    iniliazeSelect2Scrollbar();
                });
            }

        }, 150);

    });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/resources/views/livewire/project/project-creation.blade.php ENDPATH**/ ?>