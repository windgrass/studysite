$(document).ready(function(){

    $('.modalLink').modal({
        trigger: '.modalLink',          // id or class of link or button to trigger modal
        olay:'div.overlayy',             // id or class of overlay
        modals:'div.modall',             // id or class of modal
        animationEffect: 'fadeIn',   // overlay effect | slideDown or fadeIn | default=fadeIn
        animationSpeed: 400,            // speed of overlay in milliseconds | default=400
        moveModalSpeed: 'slow',         // speed of modal movement when window is resized | slow or fast | default=false
        background: '000000',           // hexidecimal color code - DONT USE #
        opacity: 0.8,                   // opacity of modal |  0 - 1 | default = 0.8
        openOnLoad: false,              // open modal on page load | true or false | default=false
        docClose: true,                 // click document to close | true or false | default=true    
        closeByEscape: true,            // close modal by escape key | true or false | default=true
        moveOnScroll: true,             // move modal when window is scrolled | true or false | default=false
        resizeWindow: true,             // move modal when window is resized | true or false | default=false
        video: 'http://player.vimeo.com/video/2355334?color=eb5a3d',    // enter the url of the video
        videoClass:'video',             // class of video element(s)
        close:'.closeBtn'               // id or class of close button
    });
});

	$(document).ready(function() {
		$('.box_skitter_large').skitter({
			theme: 'default',
			animation: 'fade',
			numbers_align: 'center',
			numbers: false,
			numbers_align: "left",
			labelAnimation: 'slideUp',
			velocity: 0.5,
			hideTools: false,
			interval: 5000, 
		});
	});

  $(document).ready(function(){
    
$('.bxslider').bxSlider({
  minSlides: 3,
  maxSlides: 3,
  slideWidth: 130,
  slideMargin: 22,
  moveSlides: 1,
  controls: true,
  auto: true
});

  });
    $(document).ready(function() {
     
      $(".owl-carousel").owlCarousel({
		    margin:0,
			loop:true,
			autoWidth:true,
			items:4,
			nav:true,
			dots:false
	  });
     
    });
	
	
$( document ).ready(function() {
  $('#s').keyup(function(){
   var valThis = $(this).val().toLowerCase();
    $('#countryList>li').each(function(){
     var text = $(this).text().toLowerCase();
        (text.indexOf(valThis) == 0) ? $(this).show() : $(this).hide();            
   });
  });
});