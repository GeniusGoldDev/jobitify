"use strict";
jQuery(window).on("load", function () {
	

	$(".op-themeform.op-fieldform").each(function(index , item){
		if($(item).find('.op-themeform__wrap > li').length <=3 ){
			$(item).find('.op-themeform__wrap > li:lt(3)').addClass("op-lessthen3items");
		}		 
	});


	
	$(document).on('click', '.more-single-rep', function(e){
		let _this = $(this);
		let timestamp = Date.now();
		let repeater 	= _this.data('repeater');
		if( repeater != '' ){
			_this.parent('.op-add-slot').find('.op-selectoption').select2('destroy');
			_this.parent('.op-add-slot').find('.op-editor').summernote('destroy');
			let item 		= _this.parent('.op-add-slot').find('.op-single-repetitor:first');
			let clonedItem 	= item.clone().find('input:not([type=checkbox],[type=radio]),textarea,select').val('').end();
			clonedItem 		= clonedItem.find('input').prop('checked', false).end();
			clonedItem 		= clonedItem.find('.op-selectoption').prop('selected', false).end();
			clonedItem.find('.op-img-thumbnail').not(':first').remove();
			clonedItem.find('.op-img-thumbnail img').attr('src', '');
			clonedItem.find('.op-img-thumbnail').addClass('d-none');
			clonedItem.find('.op-img-thumbnail input[type=hidden]').removeAttr('name');

			let parent_repet =  clonedItem.find('.op-uploads-img-data input[type=file]').attr('data-parent_rep');
			if( typeof parent_repet == 'undefined' && parent_repet == null  ){
				clonedItem.find('.op-uploads-img-data input[type=file]').attr('data-repeater_id', `${repeater}[${timestamp}]`);
			}
			let inputFields = clonedItem.find('.op-input-field');
			inputFields.each((i,item) => {
				let _this = $(item);
				let fieldId = _this.data('id');
				if( _this.attr('id') ){
					_this.attr('id', timestamp+i);
					_this.next('label').attr('for',timestamp+i);
				}
				let parent_rep 		= _this.data('parent_rep');
				let multi_items 	= _this.data('multi_items');
				if( typeof parent_rep != 'undefined' && parent_rep != null  ){
					$(item).attr('name',`${parent_rep}[${repeater}][${timestamp}][${fieldId}]`);
					
					if(multi_items === true){
						$(item).attr('name',`${parent_rep}[${repeater}][${timestamp}][${fieldId}][]`);
					}
				}else{
					$(item).attr('name',`${repeater}[${timestamp}][${fieldId}]`);
					
					if(multi_items === true){
						$(item).attr('name',`${repeater}[${timestamp}][${fieldId}][]`);
					}
				}
			});

			_this.parent('.op-add-slot').find('.op-single-repetitor:last').after(clonedItem);
			initializeScripts();
		}
	});

	$(document).on('click', '.more-mul-rep', function(e){
		let timestamp = Date.now();
		let _this = $(this);
		let repeater 	= _this.data('repeater');
		if( repeater != '' ){
			let total_item 	= $(`#${repeater} .op-accordion-item`).length;
			let	index 		= Number(total_item) +1;
			$(`#${repeater} .op-accordion-item:first`).find('.op-selectoption').select2('destroy');
			$(`#${repeater} .op-accordion-item:first`).find('.op-editor').summernote('destroy');
			let item 		= $(`#${repeater} .op-accordion-item:first`);
			let clonedItem 	= item.clone().find('input:not([type=checkbox],[type=radio]),textarea,select').val('').end();
			clonedItem 		= clonedItem.find('input').prop('checked', false).end();
			clonedItem 		= clonedItem.find('select').prop('selected', false).end();
			clonedItem.find('.op-img-thumbnail').not(':first').remove();
			clonedItem.find('.op-img-thumbnail img').attr('src', '');
			clonedItem.find('.op-img-thumbnail').addClass('d-none');
			clonedItem.find('.op-img-thumbnail input[type=hidden]').removeAttr('name');

			let parent_repet =  clonedItem.find('.op-uploads-img-data input[type=file]').attr('data-parent_rep');
			if( typeof parent_repet != 'undefined' && parent_repet != null  ){
				clonedItem.find('.op-uploads-img-data input[type=file]').attr('data-parent_rep', `${repeater}[${timestamp+index}]`);
			}else{
				clonedItem.find('.op-uploads-img-data input[type=file]').attr('data-repeater_id', `${repeater}[${timestamp+index}]`);
			}
			clonedItem.find('.op-add-slot .op-single-repetitor').not(':first').remove();
			clonedItem.find('.op-collase-sec').attr('data-bs-target', `#op-rep-accord-${index}`);
			clonedItem.find('.accordion-collapse').attr('id', `op-rep-accord-${index}`);
			let inputFields = clonedItem.find('.op-input-field');
			inputFields.each((i,item) => {
				let _this = $(item);
				let fieldId = _this.data('id');
				if( _this.attr('id') ){
					_this.attr('id', timestamp+i);
					_this.next('label').attr('for',timestamp+i);
				}
				let parent_rep 		= _this.data('parent_rep');
				let multi_items 	= _this.data('multi_items');
				if( typeof parent_rep != 'undefined' && parent_rep != null  ){
					let child_rep =  _this.parents('.op-add-slot').data('id');
					_this.attr('data-parent_rep', `${repeater}[${timestamp+index}]`);
					$(item).attr('name',`${repeater}[${timestamp+index}][${child_rep}][${timestamp}][${fieldId}]`);
					if(multi_items === true){
						$(item).attr('name',`${repeater}[${timestamp+index}][${child_rep}][${timestamp}][${fieldId}][]`);
					}
				}else{
					$(item).attr('name',`${repeater}[${timestamp+index}][${fieldId}]`);
					if(multi_items === true){
						$(item).attr('name',`${repeater}[${timestamp+index}][${fieldId}][]`);
					}
				}
			});
			
			clonedItem.appendTo(`#${repeater}`);
			let counter = 1;
			$(`#${repeater} .op-accordion-item .op-item h2`).each(function (index, item ) {
				let _this = $(this);
				let title = _this.data('title');
				_this.text(title+' '+counter++);
			});

			initializeScripts();
		}
	});

	jQuery(document).on("click", ".op-trash-single-rep", function (e) {
		e.preventDefault();
		let _this = $(this);
		_this.parents('.op-single-repetitor').remove();
	});

	jQuery(document).on("click", ".op-remove-file", function (e) {
		e.preventDefault();
		let _this = $(this);
		if(_this.parents('.op-upload-img').find('.op-img-thumbnail').length == 1 ){
			_this.parent('.op-upload-data').parent('li')
			.addClass('d-none')
			.find("img").attr('src','');
			_this.parent('.op-upload-data').parent('li').find("input[type='hidden']").removeAttr('name').val('')
			
		}else{
			_this.parent('.op-upload-data').parent('li').remove();
		}
	});

	jQuery(document).on("click", ".op-trash-mul-rep", function (e) {
		e.preventDefault();
		let _this = $(this);
		let repeater = _this.data('repeater_id');
		_this.parents('.op-accordion-item').remove();
		let counter = 1;
		$(`#${repeater} .op-accordion-item .op-item h2`).each(function (index, item ) {
			let _this = $(this);
			let title = _this.data('title');
			_this.text(title+' '+counter++);
		});
	});

	jQuery(document).on('click', 'body', function(e){
		jQuery('.cp-cont').find('.cpBG').removeClass('in').css('display','none');
	});

	jQuery(document).on('click', '.cp-cont', function(e){
		e.stopPropagation();
	});

	jQuery(document).on('click', '.colorPicker input, .colorPicker--preview', function(evt){
		let _this = $(this);
		jQuery('.cp-cont').find('.cpBG').not(_this.parents('.cp-cont').find('.cpBG')).removeClass('in').css('display','none');
	});

	jQuery(document).on('contextmenu', '.colorPicker input', function(evt){
		let _this = $(this);
		jQuery('.cp-cont').find('.cpBG').not(_this.parents('.cp-cont').find('.cpBG')).removeClass('in').css('display','none');
	});

	jQuery('.getcolor').on('change',function() {
        let getcolor =  jQuery(this).val();
		let setcolor = jQuery('.colorPicker--preview')
		jQuery(setcolor).css("background-color", getcolor);
        
    });

	jQuery('.op-feildlisting li').on('click',function() {
		let _this = $(this);
		let id = _this.find('a').attr('id');
		let date = new Date();
		date.setTime(date.getTime()+(60*60*1000));
		let expires = "; expires="+date.toGMTString();
		document.cookie = "op_active_tab="+id+expires+"; path=/";
    }); 

	jQuery(".lb-preloader-outer").delay(200).fadeOut();
});


// initialize js scripts
function initializeScripts(){

	initializeTextEditor();
	initializeTippy();
	initializeSelect2();
	initializeTimePicker();
	initializeDatePicker();
	initializeColorPicker();
	initializeSelect2Scrollbar();
	initializeRangeSlider();
}

// initialize text editor 
function initializeTextEditor(){

	let config = {
		toolbar: [
			
			['style', ['bold', 'italic', 'underline', 'clear']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['fontname', ['fontname']],
			['table', ['table']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['view', ['codeview', 'help']]
		],
		height: 250,
	};

	jQuery('.op-editor').each(function(index,item) {
		let _this = $(this);
		let value = _this.val();
		jQuery(item).summernote( config );
		if( typeof value != 'undefined' && value != null ){
			jQuery(item).summernote( 'code', value );
		}
	});

	$('.op-editor').on('summernote.change', function(we, contents, $editable) {
		let _this = $(this);
		_this.val(contents);
	});
}

// initialize select2 
function initializeSelect2(){
	jQuery('.op-selectoption').each(function(index,item) {
		jQuery(item).select2({
		});
	});
}
$('.select2').on('click',function(){
	var matchBlock = $(this).prev();
	if(matchBlock.hasClass('select-control-left')){
	  $('.select2-dropdown').addClass('blue-select');
	}
	else{
	   $('.select2-dropdown').addClass('orange-select');
	}
  });
// initialize tippy
function initializeTippy(){

	tippy('.op-infotips', {
		allowHTML: true,
		animation: "fade",
		maxWidth: 272,
	});
}

// initialize time picker
function initializeTimePicker(){

	jQuery('.time').each(function(index,item) {
		let _this = $(this);
		let time_24hr 	= _this.data('time_24hr');
		let config = { dateFormat: 'H:i', noCalendar: true, enableTime:true };

		if( time_24hr !="" ){
			config.time_24hr = time_24hr
		}
		$(item).flatpickr(config);
	});
}

// initialize date picker 
function initializeDatePicker(){

	jQuery('.date').each(function(index,item) {
		let _this = $(this);
		let dateFormat 		= _this.data('format');
		let enableTime 	= _this.data('enable_time');
		let time_24hr 	= _this.data('time_24hr');
		let mode 		= _this.data('date_mode');
		
		let config = { dateFormat: dateFormat };

		if( enableTime !="" ){
			config.enableTime = enableTime ?? false
		}
		if( mode !="" ){
			if( mode == 'range' ){
				config.mode = 'range'
			}else if( mode == 'multiple' ){
				config.mode = 'multiple'
			}
		}
		if( time_24hr !="" ){
			config.time_24hr = time_24hr
		}
		$(item).flatpickr(config);
	});
}

// initialize color picker 
function initializeColorPicker(){

	jQuery('.colorPicker').each(function(index,item) {
		
		let value = $(item).find('.op-input-field').val();
		let config = { 
			preview: '.colorPicker--preview',
			showPicker:true,
			format: 'rgb' ,
			text: {
				close:'Confirm',
				none:'None'
			}
			};

		if( value !="" ){
			config.defaultColor = value
		}
		$(item).colorPickerByGiro(config);
	});
}

// initialize select2 scrollbar
function initializeSelect2Scrollbar() {
	
	jQuery('.op-select select').on('select2:open select2:select', function(e) {
		jQuery('.select2-results__options').mCustomScrollbar('destroy');
		setTimeout(function() {
			jQuery('.select2-results__options').mCustomScrollbar();
		}, 0);
	});

	jQuery('.op-select select').on('select2:select', function(e) {
		let _this = $(this)
		_this.select2('destroy');
		_this.select2();
		jQuery('.select2-results__options').mCustomScrollbar('destroy');
		setTimeout(function() {
			jQuery('.select2-results__options').mCustomScrollbar();
		}, 0);
		
	});

	$(".select2-search__field").keydown(function(){
		jQuery('.select2-results__options').mCustomScrollbar('destroy');
		setTimeout(function() {
			jQuery('.select2-results__options').mCustomScrollbar();
		}, 0);
	});
	setSeacrhPlaceholder();
}

// initialize select2 placeholder
function setSeacrhPlaceholder() {

	jQuery('[data-placeholderinput]').each(function(item) {
		var data_placeholder = jQuery('[data-placeholderinput]')[item]
		var tk_id = jQuery(data_placeholder).attr('id')
		var tk_placeholder = jQuery(data_placeholder).attr('data-placeholderinput')
		jQuery('#' + tk_id).on('select2:open', function(e) {
			jQuery('input.select2-search__field').prop('placeholder', tk_placeholder);
		});
	});    
}

// initialize range slider scrollbar
function initializeRangeSlider(){
	
	jQuery('.range-slider').each(function(index, item) {

		let _this = $(this);
		if(typeof item.noUiSlider != 'undefined'){
			item.noUiSlider.destroy();
		}
		let option_min 	= _this.data('option_min');
		let option_max 	= _this.data('option_max');
		let min_value 	= _this.data('min_value');
		let max_value 	= _this.data('max_value');
		let format 		= _this.data('format');

		if( min_value == '' || min_value == null ){
			min_value = option_min;
		}

		if( max_value == '' || max_value == null ){
			max_value = option_max;
		}
		
		if( option_min != null &&  option_max != null ){
			let config = {
				start: [min_value, max_value],
				connect: true,
				range: {
					'min': [option_min],
					'max': [option_max]
				}	
			};

			if( format  == 'number' ){
				config.format = {
					to: (v) => parseFloat(v).toFixed(0),
					from: (v) => parseFloat(v).toFixed(0),
				}
			}
			noUiSlider.create(item, config);
			
			let inputs = [];
			let snapValues  = [];

			_this.parent('.op-textcontent').find('.op-rangeval span').each(function(i, single){
				snapValues.push(single)
			});

			_this.parents('.op-rangecollpase').find('.op-inputrangewrap input[type=number]').each(function(i, single){
				inputs.push(single)
			});

			item.noUiSlider.on('update', function (values, handle) {
				snapValues[handle].innerHTML = values[handle];
				if( inputs.length != 0 ){
					inputs[handle].value = values[handle];

				}
			});

			// Listen to keydown events on the input field.
			if( inputs.length != 0 ){
				inputs.forEach(function (input, handle) {
					input.addEventListener('change', function () {
						item.noUiSlider.setHandle(handle, this.value);
					});
					
				});	
			}
		}	
	});
}

function showAlert( data ){

    let { title, message, type, autoclose, redirectUrl } = data;

    let alertIcon	= 'ti-face-sad';
    let alertType	= 'dark';

    if(type === 'success'){
        alertIcon	= 'icon-check';
        alertType	= 'green';
    }else if(type === 'error'){
        alertIcon	= 'icon-x';
        alertType	= 'red';
    }

    $.confirm({
        icon		: alertIcon,
        closeIcon	: function(){
            if(redirectUrl){
                return 'close';
            }else{
                return true;
            }
        },
        theme		: 'modern',
        animation	: 'scale',
        type		: alertType, //red, green, dark, orange
        title,
        content		: message,
        autoClose	: 'close|'+ autoclose,
        buttons: {
            close: { 
                btnClass: 'tb-sticky-alert',
                action: function () {
                    if(redirectUrl){
                        location.href = redirectUrl;
                    }
                },
            }
        }
    });
}

function ConfirmationBox(params){
    let { title, content, action, btn_class, type_color} = params;
    $.confirm({
        title: title,
        content: content,
        type: type_color,
        icon: 'icon-alert-circle',
        closeIcon: true,
        typeAnimated: false,
        buttons: {
            yes: {
                btnClass: 'btn-'+btn_class,
                action: function () {
                    $(action).submit();
                },
            },
            no: function () {
            },
        }
    });
}
initializeScripts();

  
  