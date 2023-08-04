"use strict";
jQuery(document).ready(function() {
  
    collapseMenu();

    /* PRELOADER*/
    jQuery(window).on('load', function() {
        jQuery(".preloader").delay(1500).fadeOut();
        jQuery(".preloader__bar").delay(1000).fadeOut("slow");
    });

    //Tippy Notify
    let tb_tippy = document.querySelector(".tippy");
    if (tb_tippy !== null) {
        tippy(".tippy", {
            content: "Ad to compare",
            animation: "scale",
        });
    }
    
      
    // Left Sidebar Animation
    if($(window).width() >= 320){
        jQuery('.tb-btnmenutoggle a').on('click', function() {
            var _this = jQuery(this);
            setTimeout(function(){ 
                _this.parents('body').toggleClass("et-offsidebar");						
            },270)         
        });
    }
    /* MOBILE MENU*/
	function headerCollapseMenu(){
		jQuery('.tb-navbar ul li.menu-item-has-children').prepend('<span class="tk-dropdowarrow"><i class="icon-chevron-right"></i></span>');
		jQuery('.tb-navbar ul li.menu-item-has-children span').on('click', function() {
			jQuery(this).parent('li').toggleClass('tk-open');
			jQuery(this).next().next().slideToggle(300);
		});
	}
	headerCollapseMenu();


    //collapse Menu
    function collapseMenu() {
        jQuery('.menu-item-has-children.active').children('.sidebar-sub-menu').css('display', 'block')
        jQuery('.tb-navdashboard ul li.menu-item-has-children').prepend('<span class="tb-dropdowarrow"><i class="ti-angle-down"></i></span>');
        jQuery('.tb-navdashboard .menu-item-has-children').on('click', function(e) {
            jQuery(this).toggleClass('tb-open');
            jQuery(this).children('.sidebar-sub-menu').slideDown(300);
            e.stopPropagation();
        });
    }

    jQuery(document).on("click",".menu-has-children",function(e){

        let _this = jQuery(this)
        if(!_this.hasClass('tb-openmenu')){

            jQuery('.menu-has-children').removeClass('tb-openmenu');
            jQuery('.sidebar-sub-menu').slideUp();
            _this.toggleClass('tb-openmenu')
            _this.children("ul").slideToggle(300)
        }
    }).on('click', '.menu-has-children li', function(e) {
        e.stopPropagation();
    });

    jQuery(window).on('load',function(){
        $('.sidebar-sub-menu li.active').parents(".sidebar-sub-menu").css('display','block')  
        $('.sidebar-sub-menu li.active').parents(".menu-has-children").addClass('tb-openmenu')  
    })
    // Select mCustomscrollbar
    $('select').on('select2:open', function(e) {
        $('.select2-results__options').mCustomScrollbar('destroy');
        setTimeout(function() {
            $('.select2-results__options').mCustomScrollbar();
        }, 0);
    });

       

    jQuery(document).on("click",".tb-logowrapper > a",function(){
        jQuery("body").toggleClass("et-offsidebar")
        if($("body").hasClass("et-offsidebar")){
            tippy(".tb-menuitm", {
                delay: 200,
                placement: 'right',
            });
        } else {
            document.querySelectorAll('.tb-menuitm').forEach(node => {
                if (node._tippy) {
                  node._tippy.destroy();
                }
            });
        }
    })

    
    
});

$(document).on("click", function(event){
    var $trigger = $(".tb-categorytree-dropdown");
    
    if($trigger !== event.target && !$trigger.has(event.target).length){
        $(".tb-categorytree-dropdown").hide();
    }
});
