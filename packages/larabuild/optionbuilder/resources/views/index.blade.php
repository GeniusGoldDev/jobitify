@extends(config('optionbuilder.layout'))

@section(config('optionbuilder.section'))
    <div class="lb-preloader-outer">
        <img src="{{ asset('vendor/optionbuilder/images/lb-loader.png') }}" >
        <div class="lb-loader">
        </div>
    </div>
    <div class="builder-container">
        <div class="op-fields-wrapper">
            <div class="op-fields-title">
                <div class="op-fields-info">
                    <h6>{{ __('optionbuilder::option_builder.global_settings') }}</h6> 
                    @if( config('optionbuilder.developer_mode') === 'yes' )   
                        <p>{{ __('optionbuilder::option_builder.option_builder_tab_desc') }}<span class="op-alert">setting(‘tab_key’)</span></p>
                        <p>{{ __('optionbuilder::option_builder.option_builder_desc') }}<span class="op-alert">setting(‘tab.field_key’)</span></p>
                    @endif
                    <span>{{ env('APP_NAME') }}</span>
                </div>
            </div>
            <div class="op-fields-holder">
                @if( !empty($sections) )
                    <aside class="op-fields-aside">
                        <ul class="op-feildlisting nav nav-tabs" role="tablist" role="presentation">
                            @php 
                                $index = 1;
                                $active_tab =  !empty($_COOKIE['op_active_tab']) ? $_COOKIE['op_active_tab'] : '' ;
                                
                             @endphp
                            @foreach($sections as $single)
                                @php
                                    $id          = $single['id'].'-tab';
                                    $active_class = '';
                                    if( !empty($active_tab) ){
                                        if( $active_tab == $id ){
                                            $active_class = 'active'; 
                                        }
                                    }else{
                                        if( $index == 1 ){
                                            $active_class = 'active'; 
                                        }   
                                    }
                                    
                                @endphp
                                <li>
                                    <a class="{{ $active_class }}" href="#" id="{{ $single['id'] }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $single['id'] }}" type="button" role="tab" aria-controls="{{ $single['id'] }}" aria-selected="{{ $index++ == 1 ? 'true' : 'false'}}">{{ ucFirst($single['label']) }}
                                       
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </aside>
                    <div class="op-fields-content">
                        @php $index = 1; @endphp
                        <div class="op-fields-content tab-content" >
                            @foreach($sections as $single)
                                @php
                                    $id   = $single['id'].'-tab';
                                    $active_class = '';
                                    if( !empty($active_tab) ){
                                        if( $active_tab == $id ){
                                            $active_class = 'active'; 
                                        }
                                    }else{
                                        if( $index == 1 ){
                                            $active_class = 'active'; 
                                        }   
                                    }
                                    $index++;
                                @endphp
                                <div class="tab-pane fade {{ !empty($active_class)  ? 'show active' : ''}}" id="{{ $single['id'] }}" role="tabpanel" aria-labelledby="{{ $single['id'] }}-tab">
                                   <div class="op-tabswrapp">
                                       <div class="op-content-title">
                                           <h2> {{ ucFirst($single['label']) }} </h2>
                                           <div class="op-btnholder">
                                               <a href="javascript:void(0)" class="reset-section-settings" data-reset_all="1" data-form="{{ $single['id']}}-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                    {{ __('optionbuilder::option_builder.reset_all') }}
                                                </a>
                                               <button class="op-btn-two reset-section-settings" data-form="{{ $single['id']}}-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                    {{ __('optionbuilder::option_builder.reset_section') }}
                                                </button>
                                               <button class="op-btn update-section-settings" data-form="{{ $single['id']}}-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                    {{ __('optionbuilder::option_builder.save_changes') }}
                                                </button>
                                           </div>
                                       </div>
                                       <form id="{{ $single['id']}}-form" class="op-themeform op-fieldform" method="post">
                                           @csrf
                                           @method('post')
                                           <fieldset>
                                               {!! getSectionSetting(['tab_key' => $single['id']], $single['fields']) !!}
                                           </fieldset>
                                       </form>
                                   </div>
                                    <div class="op-content-title op-content-titlevtwo">
                                        <div class="op-btnholder">
                                            <a href="javascript:void(0)" class="reset-section-settings" data-reset_all="1" data-form="{{ $single['id']}}-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                {{ __('optionbuilder::option_builder.reset_all') }}
                                            </a>
                                            <button class="op-btn-two reset-section-settings" data-form="{{ $single['id']}}-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                {{ __('optionbuilder::option_builder.reset_section') }}
                                            </button>
                                            <button class="op-btn update-section-settings" data-form="{{ $single['id']}}-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                {{ __('optionbuilder::option_builder.save_changes') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>   
@endsection

@push(config('optionbuilder.style_var'))
    @if( config('optionbuilder.add_bootstrap') === 'yes' )
        <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/bootstrap.min.css') }}">
    @endif
    @if( config('optionbuilder.add_select2') === 'yes' )  
        <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/select2.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/feather-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/jquery-confirm.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/flatpickr.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/jquery.colorpicker.bygiro.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/summernote-lite.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/nouislider.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/main.css') }}">
@endpush
@push(config('optionbuilder.script_var'))
    
    @if( config('optionbuilder.add_jquery') === 'yes' )
        <script src="{{ asset('vendor/optionbuilder/js/jquery.min.js') }}"></script>
    @endif

    @if( config('optionbuilder.add_bootstrap') === 'yes' )
        <script defer src="{{ asset('vendor/optionbuilder/js/bootstrap.min.js') }}"></script>
    @endif

    @if( config('optionbuilder.add_select2') === 'yes' )
        <script defer src="{{ asset('vendor/optionbuilder/js/select2.min.js') }}"></script>
    @endif
    <script defer src="{{ asset('vendor/optionbuilder/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/jquery-confirm.min.js')}}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/popper-core.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/tippy.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/flatpickr.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/jquery.colorpicker.bygiro.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/summernote-lite.min.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/nouislider.min.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/optionbuilder.js') }}"></script>

    <script>
        let url_prefix = "{{config('optionbuilder.url_prefix')}}";
        if( url_prefix != '' ){
            url_prefix = url_prefix+'/';
        }
        $('.update-section-settings').on('click', function(e){
            let _this = $(this);
            let form_id = _this.data('form');
            if( form_id !='' ){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                _this.find('.spinner-border').removeClass('d-none');
                let section_key = form_id.replace('-form', '');
                $.ajax({
                    url: `{{ url('${url_prefix}option-builder/update-section-settings') }}`,
                    method: 'post',
                    data: { section_key:section_key, data: $(`#${form_id}`).serialize() },
                    success: function(data){
                        _this.find('.spinner-border').addClass('d-none');
                        if( data.success ){
                            showAlert({
                                message     : data.success.message,
                                type        : data.success.type,
                                title       : data.success.title        ? data.success.title : '' ,
                                autoclose   : data.success.autoClose    ? data.success.autoClose : 2000,
                            });
                        }
                    }
                });
            }    
        });

        $('.reset-section-settings').on('click', function(e){
            let _this = $(this);
            let reset_all   = _this.data('reset_all');
            let form_id     = _this.data('form');

            $.confirm({
                title: "{{ __('optionbuilder::option_builder.confirm_txt')}}",
                content: "{{ __('optionbuilder::option_builder.confirm_desc')}}",
                type: 'red',
                icon: 'icon-alert-circle',
                closeIcon: true,
                typeAnimated: false,
                buttons: {
                    yes: {
                        btnClass: 'btn-danger',
                        action: function () {
                                if( form_id !='' ){
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    });
                                    _this.find('.spinner-border').removeClass('d-none');
                                    let section_key = form_id.replace('-form', '');
                                    $.ajax({
                                        url: `{{ url('${url_prefix}option-builder/reset-section-settings') }}`,
                                        method: 'post',
                                        data: { section_key:section_key, reset_all: reset_all },
                                        success: function(data){
                                            _this.find('.spinner-border').addClass('d-none');
                                            if( data.success ){
                                                showAlert({
                                                    message     : data.success.message,
                                                    type        : data.success.type,
                                                    title       : data.success.title        ? data.success.title : '' ,
                                                    autoclose   : data.success.autoClose    ? data.success.autoClose : 2000,
                                                    redirectUrl   : location.href,
                                                });
                                                $(`#${form_id}`)[0].reset();
                                            }
                                        }
                                    });
                                } 
                        },
                    },
                    no: function () {
                    },
                }
            });   
        });

        $(document).on('change', '.op-uploads-img-data input[type=file]', function(event){
        
            let _this = $(this);
            let timestamp       = Date.now();
            let multi_items 	= _this.data('multi_items');
            let fieldId 	    = _this.data('id');
            let extensions      = _this.data('ext');
            let repeater_id 	= _this.data('repeater_id');
            let parent_rep 		= _this.data('parent_rep');
            let max_size        =  0;
            if(_this.data('max_size') !=''){
                max_size = Number(_this.data('max_size')) * 1024;
            }
            let skeleton = `<li class="op-upload-img-info ob-file-skel">
                <div class="op-uploads-img-data">
                    <label class="lb-spinner">
                        <div class="spinner-grow"></div>
                    </label>
                </div>
            </li>`;
            let clonedItem 	    = '';
            const files         = event.target.files; 
            let formData        = new FormData;
            for(let i = 0; i < files.length; i++){
                const fsize = Math.round((files[i].size/1024));
                if( fsize > max_size ){
                    showAlert({
                            message     : '{{__("optionbuilder::option_builder.max_file_size")}}',
                            type        : 'error',
                            title       : '{{__("optionbuilder::option_builder.error_title")}}' ,
                            autoclose   :  3000,
                        });
                    return false;
                }
                formData.append(`files[${files[i].name}]`, files[i]);
                _this.parents('.op-upload-img-info').after(skeleton);
                // $(skeleton).insertAfter();
            }
            formData.append('extensions', extensions);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            event.target.value = '';
            $.ajax({
                url: `{{ url('${url_prefix}option-builder/upload-files') }}`,
                method: 'post',
                contentType: false,
                processData: false,
                data:  formData,
                success: function(data){
                    _this.parents('.op-upload-img').find('.ob-file-skel').remove();
                    if( data.type == 'success'){
                        if( data.files ){
                            data.files.forEach(function( file, index ) {
                                let _thumbnail = _this.parents('.op-upload-img-info').next('li .op-img-thumbnail');
                                
                                if(  multi_items === false ){
                                    _this.parents('.op-upload-img').find('.op-img-thumbnail').not(':first').remove();
                                    let item = _thumbnail.first();
                                    clonedItem 	= item;
                                }else if( multi_items === true ){
                                    let item = _thumbnail.first();
                                    clonedItem 	= item.clone();
                                }

                                if( typeof repeater_id != 'undefined' && repeater_id != null  ){
                                    if( typeof parent_rep != 'undefined' && parent_rep != null  ){
                                        _this.parents('.op-upload-img').find('.op-img-thumbnail input[type=hidden]').each((index,i) => {
                                            if(i.value !=''){
                                                $(i).attr('name',`${parent_rep}[${repeater_id}][${timestamp}][${fieldId}][]`)
                                                .attr('value',i.value);
                                            }
                                        });
                                        clonedItem.find("input[type='hidden']").attr('name',`${parent_rep}[${repeater_id}][${timestamp}][${fieldId}][]`);
                                    }else{
                                        clonedItem.find("input[type='hidden']").attr('name',`${repeater_id}[${fieldId}][]`);
                                    }
                                }else{
                                    clonedItem.find("input[type='hidden']").attr('name',`${fieldId}[]`);
                                }
                                clonedItem.find('img').attr('src', file.thumbnail);    
                                clonedItem.find("input[type='hidden']").val(JSON.stringify(file));
                                _this.parents('.op-upload-img-info').last('li .op-img-thumbnail').after(clonedItem);
                                clonedItem.removeClass('d-none');
                            });
                        }
                    }else{
                    showAlert({
                            message     : data.message,
                            type        : 'error',
                            title       : data.title        ? data.title : '' ,
                            autoclose   : data.autoClose    ? data.autoClose : 3000,
                        }); 
                    }
                }
            });
        });
    </script>    
@endpush