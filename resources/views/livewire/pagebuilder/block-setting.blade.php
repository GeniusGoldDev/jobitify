<div class="tab-pane fade" id="block-settings" wire:ignore.self>
    @if (file_exists(resource_path('views/livewire/pagebuilder/settings/'.$block_id.'.blade.php')))
        <div class="at-components-content">
            @include('livewire/pagebuilder/settings/'.$block_id)
        </div>
        @else
           <div class="at-empty-block-settings">
                <span>{{ __('pages.no_block_settings')}}</span>
           </div>
        @endif
</div>   


@push('styles')
@vite([
        'public/pagebuilder/css/tinymce/tinymce.css', 
    ])
@endpush
@push('scripts')
    <script defer src="{{ asset('pagebuilder/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            window.addEventListener('active-block-settings', event=>{
                $('.at-pagebuilder-tab li button').removeClass('active');
                $('.tab-content .tab-pane').removeClass('show active');
                $('#block-settings-tab').addClass('active');
                $('#block-settings').addClass('active show');
                
                $('#selected_categories_'+event.detail.block_key+', #selected_projects_'+event.detail.block_key).select2(
                    { dropdownParent: $("#at-sidebar-contents"), allowClear: true, closeOnSelect: false }
                );
                
                jQuery('.at-select select').on('select2:open', function(e) {
                    jQuery('.select2-results__options').mCustomScrollbar('destroy');
                    setTimeout(function() {
                        jQuery('.select2-results__options').mCustomScrollbar();
                    }, 0);
                });

                $(document).on('keydown', '.select2-search__field', function(event) {
                    jQuery('.select2-results__options').mCustomScrollbar('destroy');
                    setTimeout(function() {
                        jQuery('.select2-results__options').mCustomScrollbar();
                    }, 0);
                });

                
                $(document).on('change', '#selected_categories_'+event.detail.block_key, function(e) {
                    let selected_categories = $('#selected_categories_'+event.detail.block_key).select2("val");
                    let ids                 = selected_categories.join(',');
                    let inputField          = $(`#category_ids_${event.detail.block_key}`);
                    if(inputField){
                        inputField.val(ids)
                        inputField.change();
                    };
                });

                $(document).on('change', '#selected_projects_'+event.detail.block_key, function(e) {
                    let selected_categories = $('#selected_projects_'+event.detail.block_key).select2("val");
                    let ids = selected_categories.join(',');
                    let inputField = $(`#project_ids_${event.detail.block_key}`);
                    if(inputField){
                        inputField.val(ids)
                        inputField.change();
                    };
                });

                $('.tk-select select').on('select2:open', function(e) {
                    $('.select2-results__options').mCustomScrollbar('destroy');
                    setTimeout(function() {
                        $('.select2-results__options').mCustomScrollbar();
                    }, 0);
                });

                $(document).on('keydown', '.select2-search__field', function(e) {
                    $('.select2-results__options').mCustomScrollbar('destroy');
                    setTimeout(function() {
                        $('.select2-results__options').mCustomScrollbar();
                    }, 0);
                });
                
                $('.tk-select2').each(function(index, item) {
                    let _this = $(this);
                    _this.select2( { 
                        placeholder: _this.data('placeholder'),
                        allowClear: true 
                    });
                });
                setTimeout(() => {
                    $(document).find('form#at-style-form input:not(.at_text_align)').each(function() {
                        $(this).on('change', function(e){
                            submitStyleForm(event.detail.block_key);
                        });
                    });
                }, 1000);

            });

            document.addEventListener('initTinyMce', event => {
                let selectorArea = $(document).find("textarea[id^='tk_editor_']")
                let selectorId = selectorArea.attr('id')
                setTimeout(() => {
                    tinymce.init({
                        selector: 'textarea#'+selectorId,
                        height: 280,
                        menubar: false,
                        statusbar: false,
                        plugins: [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table paste code wordcount",
                        ],
                        menubar: 'insert',
                        setup : function(editor) {
                            editor.on('init', function(e) {
                                    let initValue = event.detail.heading;
                                    editor.setContent(initValue)
                                    tinymce.triggerSave(true, true);
                            }),
                            editor.on('blur', function(e) {
                                editor.setContent(editor.getContent({format : 'html'}));

                                tinymce.triggerSave();
                                submitForm(event.detail.block_key);
                            })
                        },
                        content_style: "body {padding: 20px}",
                        toolbar:
                        "undo redo | formatselect | " +
                        "bold italic backcolor | alignleft aligncenter " +
                        "alignright alignjustify | bullist numlist outdent indent | " +
                        "removeformat | code ",
                        content_css: ["{{asset('pagebuilder/css/tinymce/tinymce.css')}}"],
                        images_upload_handler: function (blobInfo, success, failure) {
                            $.ajax({
                                type:'POST',
                                url:"{{route('upload-image')}}",
                                data:{
                                    'image'     : 'data:image/png;base64,'+blobInfo.base64(),
                                    'directory' : 'pages'
                                },
                                success:function(data){
                                    if(data.type == 'success'){
                                        setTimeout(function () {
                                            success(data.url);
                                        }, 2000);
                                    }
                                }
                            });
                        },
                    });
                }, 0);
            });

            document.addEventListener('initForm', event => {
                $(document).find(`#block-settings form#at-form-setting_${event.detail.block_key} input:not(.at_upload_file), #block-settings form textarea`).each(function() { 
                    $(this).on('change', function(e){
                        submitForm(event.detail.block_key);
                    });
                });
            });

            $(document).on('click','.at_remove_file', function(e){
                let _this       = $(this);
                let key         = _this.data('key_name');
                let block_key   = _this.data('block_key');
                let file_name   = _this.data('file_name');
                let input       = $(document).find(`#${file_name}`);
                if(input){
                    input.val('');
                    @this.set('upload_files.'+file_name.toString(), '');
                    @this.set('settings.'+key.toString(),'')
                    input.change();
                }
            });

            $(document).on('click','.accordion-button', function(e){
                let _this = $(this);
                $('.at-accordion-collapse').slideUp();
                if (!_this.parent().next('.at-accordion-collapse').is(':visible')){
                    let sibling = _this.parent().next('.at-accordion-collapse').slideDown();
                }
            });

            $(document).on('click','.at-cross-icon', function(e){
                let _this = $(this);
                let block_kay = _this.data('block_key');
                _this.parents('.accordion-item').remove();
                submitForm(block_kay);
               
            });

            $(document).on('click','#add_more_item', function(e){
                let _this       = $(this);
                let clone_item  = $('#clone_item');
                let item        = clone_item.clone(true, true);
                let count       = $('.accordion-item').length;
                let block_key   = _this.data('block_key');
                if(block_key){
                    block_key = block_key.split('__')[0]
                }
                
                item.removeClass('d-none');
                item.removeAttr('id');

                $('#tb_counter_section').append(item);
                if( block_key == 'header-block' || block_key == 'question-search-block'){
                    $('#tb_counter_section .accordion-item').each(function(topIndex, item) {
                        let parent_this = $(this);
                        if(block_key == 'question-search-block'){
                            parent_this.find('.at-collapse-field').each(function(index, innerItem) {
                                let _this = $(this);
                                let type = _this.data('type');
                                _this.attr('name', `question_list[${topIndex}][${type}]`);
                            });
                        } else {
                            parent_this.find('input').each(function(index, innerItem) {
                                let _this = $(this);
                                let type = _this.data('type');
                                _this.attr('name', `counter_option[${topIndex}][${type}]`);
                            });
                        }
                        
                    });
                }
            });

            document.addEventListener('updateDynamicFileUrl', event => {
                let block_key = event.detail.block_key;
                let key_name  = event.detail.property_key;
                $(document).find(`#at-form-setting_${block_key} #${key_name}`).val(event.detail.file_url);
                submitForm(event.detail.block_key);
            });

            document.addEventListener('removeItem', event => {
                submitForm(event.detail.block_key);
            });

            $(document).on('click', '.tk_stars li', function(){
                var _this       = jQuery(this);
                var onStar      = parseInt(_this.data('value'), 10) > 0 ? parseInt(_this.data('value'), 10) : 5;
                var stars       = _this.parent().children('li.tk-star');

                for (var i = 0; i < stars.length; i++) {
                    jQuery(stars[i]).removeClass('active');
                }

                for (var i = 0; i < onStar; i++) {
                    jQuery(stars[i]).addClass('active');
                }
                
                var ratingValue = parseInt(_this.parent().children('li.active').length, 10);
                _this.parent().next('.at-feedback-rating').val(ratingValue);
                let key_name = _this.parent().next('.at-feedback-rating').attr('data-block_key');
                _this.parent().next('.at-feedback-rating').change();
                submitForm(key_name);
                
            });

        }); 

       

        function submitForm(blockKey){
            let formData = $('#block-settings form#at-form-setting_'+blockKey).serialize();
            tinymce.triggerSave(true, true);
            window.livewire.emit(`update-${blockKey}`, formData);
        }

        function submitStyleForm(blockKey){
            let formData = $('form#at-style-form').serialize();
            window.livewire.emit(`updateBlockStyle`, formData);
        }

    </script>
@endpush
   