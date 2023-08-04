<main>
    <section class="tk-main-section tk-main-bg">
        <div class="preloader-outer" wire:loading wire:target="updateStep,update">
            <div class="tk-preloader">
                <img class="fa-spin" src="{{ asset('images/loader.png') }}">
            </div>
        </div>
        <div class="container">
            @include('livewire.gig.gig-step'.$step)
        </div>
    </section>
</main>

@push('styles')
    @vite([
        'public/pagebuilder/css/tinymce/tinymce.css', 
    ])
@endpush
@push('scripts')
    <script defer src="{{ asset('common/js/select2.min.js')}}"></script>
    <script defer src="{{ asset('pagebuilder/js/tinymce/tinymce.min.js') }}"></script>
    <script defer src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            window.livewire.on('file-dropped', (event) => {
                if (event.dataTransfer.files.length > 0) {
                    const files = event.dataTransfer.files;
                    @this.uploadMultiple('galleryFiles', files,
                        (uploadedFilename) => {
                        }, (error) => {
                            console.log(error)
                        }, (event) => {
                        }
                    )
                }
            });

            window.livewire.on('download-file-dropped', (event) => {
                if (event.dataTransfer.files.length > 0) {
                    const files = event.dataTransfer.files;
                    @this.uploadMultiple('downloadFiles', files,
                        (uploadedFilename) => {
                        }, (error) => {
                            console.log(error)
                        }, (event) => {
                        }
                    )
                }
            });

            setTimeout(function() {

                function initStep1JS(){
                    
                    $('#category, #sub_category, #country').select2(
                        { allowClear: true }
                    );
                    $('#selected_gig_types').select2(
                        { allowClear: true, closeOnSelect: false }
                    );

                    $('#category').on('change', function (e) {
                        let category = $('#category').select2("val");
                        @this.set('category', category);
                    });

                    $(document).on("change", '#sub_category', function(e){
                        let sub_category = $('#sub_category').select2("val");
                        @this.set('sub_category', sub_category);
                    });

                    $(document).on("change", '#selected_gig_types', function(e){
                        let selected_gig_types = $('#selected_gig_types').select2("val");
                        @this.set('selected_gig_types', selected_gig_types, true);
                    });

                    $('#country').on('change', function (e) {
                        let country = $('#country').select2("val");
                        @this.set('country', country, true);
                    });
                }

                function initStep2JS(){

                    $('.delivery-time').select2(
                        { allowClear: true }
                    );
                    $('.delivery-time').on('change', function (e) {
                        let _this = $(this);
                        @this.set(e.target.id, _this.select2('val'), true);
                    });
                }

                if( '{{ $step }}' == 1 ){
                    initStep1JS();
                    iniliazeSelect2Scrollbar();
                }else if('{{ $step }}' == 2){
                    initStep2JS();
                    iniliazeSelect2Scrollbar();
                }

                $(document).on("click", '#downloadable', function(e){
                    if(this.checked){
                        $('.downloadable-files').removeClass('d-none');
                    }else{
                        $('.downloadable-files').addClass('d-none');
                    }
                });

                window.addEventListener('initStep1-js', event=>{
                    initStep1JS();
                    iniliazeSelect2Scrollbar();
                });

                window.addEventListener('initStep2-js', event=>{
                    initStep2JS();
                    iniliazeSelect2Scrollbar();
                });

                if (window.history && window.history.pushState) {
                    $(window).on('popstate', function() {
                        initStep1JS();
                        initStep2JS();
                        iniliazeSelect2Scrollbar();
                    });
                }
            }, 250);

        });
    </script>

@endpush
