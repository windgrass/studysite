

(function($) {
	"use strict";



	//isotope
	$( window ).load(function() {
		
		$('.ns_masonry_btns div a').click( function() {
			var filterValue = $( this ).attr('data-filter');
			$container.isotope({ filter: filterValue });
		});
		  
		var $container = $('.ns_masonry_container').isotope({
			itemSelector: '.ns_masonry_item'
		});

		$( '.ns_simulate_click' ).trigger( "click" );
	
	});
	///////////




	//inview
	var windowWidth = $(window).width(); 

	if (windowWidth < 400){
		
		$('.fade-left, .fade-up, .fade-down, .fade-right, .bounce-in, .rotate-In-Down-Left, .rotate-In-Down-Right').css('opacity','1');
			
	}else{
		
		$('.fade-up').bind('inview', function(event, visible) { if (visible == true) { $(this).addClass('animated fadeInUp'); } });
		$('.fade-down').bind('inview', function(event, visible) { if (visible == true) { $(this).addClass('animated fadeInDown'); } });
		$('.fade-left').bind('inview', function(event, visible) { if (visible == true) { $(this).addClass('animated fadeInLeft'); } });
		$('.fade-right').bind('inview', function(event, visible) { if (visible == true) { $(this).addClass('animated fadeInRight'); } });
		$('.bounce-in').bind('inview', function(event, visible) { if (visible == true) { $(this).addClass('animated bounceIn'); } });
		$('.rotate-In-Down-Left').bind('inview', function(event, visible) { if (visible == true) { $(this).addClass('animated rotateInDownLeft'); } });
		$('.rotate-In-Down-Right').bind('inview', function(event, visible) { if (visible == true) { $(this).addClass('animated rotateInDownRight'); } });	

	}
	///////////
		

	//menu	
	$('.ns_menu').superfish({});	
	//megamenu
	$('.ns_megamenu ul a').removeClass('sf-with-ul');
	$($('.ns_megamenu ul li').find('ul').get().reverse()).each(function(){
	  $(this).replaceWith($('<ol>'+$(this).html()+'</ol>'))
	})
	//responsive
	$('.ns_menu').tinyNav({
		active: 'selected',
		header: 'MENU'
	});
	///////////


	//fixed menu
	jQuery(window).scroll(function(){
		add_class_scroll();
	});
	add_class_scroll();
	function add_class_scroll() {
		if(jQuery(window).scrollTop() > 100) {
			jQuery('.ns_navigation').addClass('slowup');
			jQuery('.ns_navigation').removeClass('slowdown');
		} else {
			jQuery('.ns_navigation').addClass('slowdown');
			jQuery('.ns_navigation').removeClass('slowup');
		}
	}
	///////////
	

	
	//tooltip
    $( '.ns_tooltip' ).tooltip({ 
    	position: {
    		my: "center top",
    		at: "center+0 top-50"
  		}
    });
    //calendar
	$( '.ns_calendar' ).datepicker({ });
	//tab
	$('.ns_tab').tabs({show: 'fade', hide: 'fade'});
	//toogle
	$( '.ns_toogle' ).accordion({
		heightStyle: "content",
		collapsible: true,
		active: false
	}); 
	//accordion
	$( '.ns_accordion' ).accordion({
		heightStyle: "content"
	});
	//slider-range
	$( ".ns_slider_range" ).slider({
		range: true,
		min: 0,
		max: 1000,
		values: [ 200, 700 ],
		slide: function( event, ui ) {
			$( ".ns_slider_amount" ).val( "$ " + ui.values[ 0 ] + " - $ " + ui.values[ 1 ] );
		}
	});
	$( ".ns_slider_amount" ).val( "$ " + $( ".ns_slider_range" ).slider( "values", 0 ) + " - $ " + $( ".ns_slider_range" ).slider( "values", 1 ) );
	//alerts
	$('.ns_alerts').click(function(event){
		$(this).css({
			'display': 'none',
		});
	});
	//progressbar
	$('.animate_progressbar').bind('inview', function(event, visible) { if (visible == true) { $(this).removeClass('animate_progressbar'); } });
	///////////



	//internal-link
	$('.ns_internal_link').click(function(event){

		event.preventDefault();
		var full_url = this.href;
		var parts = full_url.split("#");
		var trgt = parts[1];
		var target_offset = $("#"+trgt).offset();
		var target_top = target_offset.top;
	
		$('html,body').animate({scrollTop:target_top -13}, 900);
	
	});
	///////////



	//counter
	$('.ns_counter').data('countToOptions', {
		formatter: function (value, options) {
			return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
		}
	});
	// start all the timers
	$('.ns_counter').bind('inview', function(event, visible) {
		if (visible == true) {
			$('.ns_counter').each(count);
		} 
	});
	function count(options) {
		var $this = $(this);
		options = $.extend({}, options || {}, $this.data('countToOptions') || {});
		$this.countTo(options);
	}
	///////////


	//nicescrool
	$(".ns_nicescrool").niceScroll({
		touchbehavior:true,
		cursoropacitymax:1,
		cursorwidth:0,
		autohidemode:false,
		cursorborder:0
	});
	///////////

		

	//left sidebar OPEN		
	$('.ns_left_sidebar_btn_open').click(function(event){
		$('.ns_left_sidebar').css({
			'left': '0px',
		});
		$('.ns_site, .ns_navigation').css({
			'margin-left': '300px',
		});
		$('.ns_overlay').addClass('ns_overlay_on');
	});
	//left sidebar CLOSE	
	$('.ns_left_sidebar_btn_close, .ns_overlay').click(function(event){
		$('.ns_left_sidebar').css({
			'left': '-300px'
		});
		$('.ns_site, .ns_navigation').css({
			'margin-left': '0px'
		});
		$('.ns_overlay').removeClass('ns_overlay_on');
	});
	//right sidebar OPEN		
	$('.ns_right_sidebar_btn_open').click(function(event){
		$('.ns_right_sidebar').css({
			'right': '0px',
		});
		$('.ns_site, .ns_navigation').css({
			'margin-left': '-300px',
		});
		$('.ns_overlay').addClass('ns_overlay_on');
	});
	//right sidebar CLOSE	
	$('.ns_right_sidebar_btn_close, .ns_overlay').click(function(event){
		$('.ns_right_sidebar').css({
			'right': '-300px'
		});
		$('.ns_site, .ns_navigation').css({
			'margin-left': '0px'
		});
		$('.ns_overlay').removeClass('ns_overlay_on');
	});
	///////////
	


	//ns_mpopup_gallery
	$('.ns_mpopup_gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-fade',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
			}
		}
	});
	//ns_mpopup_iframe
	$('.ns_mpopup_iframe').magnificPopup({
		disableOn: 200,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,

		fixedContentPos: false
	});
	//ns_mpopup_window
	$('.ns_mpopup_window').magnificPopup({
		type: 'inline',

		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
	//ns_mpopup_ajax
	$('.ns_mpopup_ajax').magnificPopup({
		type: 'ajax',
		alignTop: false,
		overflowY: 'scroll'
	});
	//////////


})(jQuery);