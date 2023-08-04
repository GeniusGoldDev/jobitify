<main>
    <section class="tk-main-section tk-main-bg">
        <div class="preloader-outer" wire:loading wire:target="updateStep,inviteSeller,update">
            <div class="tk-preloader">
                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
            </div>
        </div>
        <div class="container">
            @if($useTemplate)
                @include('livewire.project.project-templates')
            @else
                @include('livewire.project.project-step'.$step)
            @endif
        </div>
    </section>
</main>

@push('styles')
    @vite([
        'public/pagebuilder/css/tinymce/tinymce.css', 
    ])
@endpush

@push('scripts')

<script defer src="{{ asset('pagebuilder/js/tinymce/tinymce.min.js') }}"></script>
<script defer src="{{ asset('js/app.js') }}"></script>
<script defer src="{{ asset('common/js/select2.min.js')}}"></script>

<script>

    document.addEventListener('livewire:load', function () {
       
        window.livewire.on('file-dropped', (event) => {
            if (event.dataTransfer.files.length > 0) {
                const files = event.dataTransfer.files;
                @this.uploadMultiple('files', files,
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
                    @this.set('project_location', project_location);
                });

                $('#project_country').on('change', function (e) {
                    let project_country = $('#project_country').select2("val");
                    @this.set('project_country', project_country, true);
                });

                $('#project_category').on('change', function (e) {
                    let project_category = $('#project_category').select2("val");
                    @this.set('project_category', project_category, true);
                });

                $('#project_duration').on('change', function (e) {
                    let project_duration = $('#project_duration').select2("val");
                    @this.set('project_duration', project_duration, true);
                });

                $('#payment_mode').on('change', function (e) {
                    let payment_mode = $('#payment_mode').select2("val");
                    @this.set('payment_mode', payment_mode, true);
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
                    @this.set('expertise_level', expertise_level, true);
                });

                $('#project_skills').on('change', function (e) {
                    let project_skills = $('#project_skills').select2("val");
                    @this.set('project_skills', project_skills, true);
                });

                $('#project_languages').on('change', function (e) {
                    let project_languages = $('#project_languages').select2("val");
                    @this.set('project_languages', project_languages, true);
                });

                $('#no_of_freelancer').on('change', function (e) {
                    let no_of_freelancer = $('#no_of_freelancer').select2("val");
                    @this.set('no_of_freelancer', no_of_freelancer, true);
                });
            }

            if( '{{ $step }}' == 2 ){
                initStep2JS();
               
            }else if('{{ $step }}' == 3){
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
                    @this.set('per_page', per_page);
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
@endpush
