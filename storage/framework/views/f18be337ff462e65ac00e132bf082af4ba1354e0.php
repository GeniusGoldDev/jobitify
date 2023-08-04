

<?php $__env->startSection(config('optionbuilder.section')); ?>
    <div class="lb-preloader-outer">
        <img src="<?php echo e(asset('vendor/optionbuilder/images/lb-loader.png')); ?>" >
        <div class="lb-loader">
        </div>
    </div>
    <div class="builder-container">
        <div class="op-fields-wrapper">
            <div class="op-fields-title">
                <div class="op-fields-info">
                    <h6><?php echo e(__('optionbuilder::option_builder.global_settings')); ?></h6> 
                    <?php if( config('optionbuilder.developer_mode') === 'yes' ): ?>   
                        <p><?php echo e(__('optionbuilder::option_builder.option_builder_tab_desc')); ?><span class="op-alert">setting(‘tab_key’)</span></p>
                        <p><?php echo e(__('optionbuilder::option_builder.option_builder_desc')); ?><span class="op-alert">setting(‘tab.field_key’)</span></p>
                    <?php endif; ?>
                    <span><?php echo e(env('APP_NAME')); ?></span>
                </div>
            </div>
            <div class="op-fields-holder">
                <?php if( !empty($sections) ): ?>
                    <aside class="op-fields-aside">
                        <ul class="op-feildlisting nav nav-tabs" role="tablist" role="presentation">
                            <?php 
                                $index = 1;
                                $active_tab =  !empty($_COOKIE['op_active_tab']) ? $_COOKIE['op_active_tab'] : '' ;
                                
                             ?>
                            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
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
                                    
                                ?>
                                <li>
                                    <a class="<?php echo e($active_class); ?>" href="#" id="<?php echo e($single['id']); ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo e($single['id']); ?>" type="button" role="tab" aria-controls="<?php echo e($single['id']); ?>" aria-selected="<?php echo e($index++ == 1 ? 'true' : 'false'); ?>"><?php echo e(ucFirst($single['label'])); ?>

                                       
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </aside>
                    <div class="op-fields-content">
                        <?php $index = 1; ?>
                        <div class="op-fields-content tab-content" >
                            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
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
                                ?>
                                <div class="tab-pane fade <?php echo e(!empty($active_class)  ? 'show active' : ''); ?>" id="<?php echo e($single['id']); ?>" role="tabpanel" aria-labelledby="<?php echo e($single['id']); ?>-tab">
                                   <div class="op-tabswrapp">
                                       <div class="op-content-title">
                                           <h2> <?php echo e(ucFirst($single['label'])); ?> </h2>
                                           <div class="op-btnholder">
                                               <a href="javascript:void(0)" class="reset-section-settings" data-reset_all="1" data-form="<?php echo e($single['id']); ?>-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                    <?php echo e(__('optionbuilder::option_builder.reset_all')); ?>

                                                </a>
                                               <button class="op-btn-two reset-section-settings" data-form="<?php echo e($single['id']); ?>-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                    <?php echo e(__('optionbuilder::option_builder.reset_section')); ?>

                                                </button>
                                               <button class="op-btn update-section-settings" data-form="<?php echo e($single['id']); ?>-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                    <?php echo e(__('optionbuilder::option_builder.save_changes')); ?>

                                                </button>
                                           </div>
                                       </div>
                                       <form id="<?php echo e($single['id']); ?>-form" class="op-themeform op-fieldform" method="post">
                                           <?php echo csrf_field(); ?>
                                           <?php echo method_field('post'); ?>
                                           <fieldset>
                                               <?php echo getSectionSetting(['tab_key' => $single['id']], $single['fields']); ?>

                                           </fieldset>
                                       </form>
                                   </div>
                                    <div class="op-content-title op-content-titlevtwo">
                                        <div class="op-btnholder">
                                            <a href="javascript:void(0)" class="reset-section-settings" data-reset_all="1" data-form="<?php echo e($single['id']); ?>-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                <?php echo e(__('optionbuilder::option_builder.reset_all')); ?>

                                            </a>
                                            <button class="op-btn-two reset-section-settings" data-form="<?php echo e($single['id']); ?>-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                <?php echo e(__('optionbuilder::option_builder.reset_section')); ?>

                                            </button>
                                            <button class="op-btn update-section-settings" data-form="<?php echo e($single['id']); ?>-form">
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                <?php echo e(__('optionbuilder::option_builder.save_changes')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>   
<?php $__env->stopSection(); ?>

<?php $__env->startPush(config('optionbuilder.style_var')); ?>
    <?php if( config('optionbuilder.add_bootstrap') === 'yes' ): ?>
        <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/bootstrap.min.css')); ?>">
    <?php endif; ?>
    <?php if( config('optionbuilder.add_select2') === 'yes' ): ?>  
        <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/select2.min.css')); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/jquery.mCustomScrollbar.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/feather-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/jquery-confirm.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/flatpickr.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/jquery.colorpicker.bygiro.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/summernote-lite.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/nouislider.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/main.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush(config('optionbuilder.script_var')); ?>
    
    <?php if( config('optionbuilder.add_jquery') === 'yes' ): ?>
        <script src="<?php echo e(asset('vendor/optionbuilder/js/jquery.min.js')); ?>"></script>
    <?php endif; ?>

    <?php if( config('optionbuilder.add_bootstrap') === 'yes' ): ?>
        <script defer src="<?php echo e(asset('vendor/optionbuilder/js/bootstrap.min.js')); ?>"></script>
    <?php endif; ?>

    <?php if( config('optionbuilder.add_select2') === 'yes' ): ?>
        <script defer src="<?php echo e(asset('vendor/optionbuilder/js/select2.min.js')); ?>"></script>
    <?php endif; ?>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/jquery-confirm.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/popper-core.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/tippy.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/flatpickr.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/jquery.colorpicker.bygiro.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/summernote-lite.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/nouislider.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/optionbuilder.js')); ?>"></script>

    <script>
        let url_prefix = "<?php echo e(config('optionbuilder.url_prefix')); ?>";
        if( url_prefix != '' ){
            url_prefix = url_prefix+'/';
        }
        $('.update-section-settings').on('click', function(e){
            let _this = $(this);
            let form_id = _this.data('form');
            if( form_id !='' ){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    }
                });
                _this.find('.spinner-border').removeClass('d-none');
                let section_key = form_id.replace('-form', '');
                $.ajax({
                    url: `<?php echo e(url('${url_prefix}option-builder/update-section-settings')); ?>`,
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
                title: "<?php echo e(__('optionbuilder::option_builder.confirm_txt')); ?>",
                content: "<?php echo e(__('optionbuilder::option_builder.confirm_desc')); ?>",
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
                                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                                        }
                                    });
                                    _this.find('.spinner-border').removeClass('d-none');
                                    let section_key = form_id.replace('-form', '');
                                    $.ajax({
                                        url: `<?php echo e(url('${url_prefix}option-builder/reset-section-settings')); ?>`,
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
                            message     : '<?php echo e(__("optionbuilder::option_builder.max_file_size")); ?>',
                            type        : 'error',
                            title       : '<?php echo e(__("optionbuilder::option_builder.error_title")); ?>' ,
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
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            });
            event.target.value = '';
            $.ajax({
                url: `<?php echo e(url('${url_prefix}option-builder/upload-files')); ?>`,
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make(config('optionbuilder.layout'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/958257.cloudwaysapps.com/cepdppxzre/public_html/vendor/larabuild/optionbuilder/resources/views/index.blade.php ENDPATH**/ ?>