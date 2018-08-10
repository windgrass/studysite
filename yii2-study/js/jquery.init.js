(function ($) {
    "use strict";
    
    // Sticky menu
    jQuery(window).scroll(function () {
        var mainmenu = jQuery("#header .sticky_menu");
        if (parseInt(mainmenu.attr("rel"),10) < Math.abs(parseInt(jQuery(window).scrollTop()),10)) {
            mainmenu.addClass("fixed");
        } else {
            mainmenu.removeClass("fixed");
        }
    });
	
    jQuery(document).ready(function () {
        
        /* ======== STICKY MENU ======== */
        if(jQuery("#header .sticky_menu").length) {
            jQuery("#header .sticky_menu").wrap("<div class='header_main-parent'></div>").attr("rel", jQuery("#header .sticky_menu").offset().top).parent().height(jQuery("#header .sticky_menu").height());
        }
        
        /* ======== RESPONSIVE NAVIGATION ======== */
        function setupMenu( $menu ) {
            $menu.each(function() {
                var mobileMenu = $(this).clone();
                var mobileMenuWrap = $("<div></div>").append(mobileMenu);
                mobileMenuWrap.attr("class", "mobile_site_navigation");
                $(this).parent().append(mobileMenuWrap);
                mobileMenu.attr("class", "menu_mobile");
            });
        }
        function setupMobileMenu() {
            $(".container").each(function() {
                var clickTopOpenMenu = $(this).find(".open_menu_mobile");
                clickTopOpenMenu.click(function() {
                    $(this).parent().find(".mobile_site_navigation").toggle();
                });
            });
        }
        setupMenu($("nav.site_navigation ul.menu"));
        setupMenu($("nav.top_navigation ul.menu"));
        setupMobileMenu();
        
        
        /* ======== FEATURED CAROUSEL ======== */
        jQuery(".featured_carousel").owlCarousel({
            items: 3,
            navigation: true,
            navigationText: ["&#xf104;","&#xf105;"],
            pagination: false
        });
        
        /* ======== MAIN CONTENT SLIDER ======== */
        jQuery(".main_content_slider").owlCarousel({
            items: 1,
            navigation: true,
            navigationText: ["&#xf104;","&#xf105;"],
            pagination: false
        });
        
        /* ======== ITEM SLIDER ======== */
        jQuery(".item_slider").owlCarousel({
            singleItem: true,
            navigation: true,
            navigationText: ["&#xf104;","&#xf105;"],
            pagination: false
        });
        
        /* ======== BREAKING NEWS ======== */
        jQuery(".breaking_block").owlCarousel({
            singleItem: true,
            navigation: true,
            navigationText: ["&#xf104;","&#xf105;"],
            pagination: false,
            autoPlay: false
        });
        
        /* ======== TESTIMONIALS SLIDER ======== */
        jQuery(".testimonial_slider").owlCarousel({
            items: 1,
            autoHeight: true,
            pagination: true,
            navigation: false
        });
        
        /* ======== MAGNIFIC POPUP (IMAGE) ======== */
        jQuery(".magnificPopupImage").magnificPopup({
            type: "image"
        });

        /* ======== MAGNIFIC POPUP (GALLERY) ======== */
        $(".magnificPopupGallery").each(function() {
            $(this).magnificPopup({
                delegate: "a",
                type: "image",
                gallery: {
                    enabled: true
                }
            });
        });
        
        /* ======== MAGNIFIC POPUP (IFRAME) ======== */
        jQuery(".magnificPopupIframe").magnificPopup({
            type: "iframe"
        });   
        
        /* ======== PARALLAX CONTAINER ======== */
        jQuery(".parallax_element").scrolly({bgParallax: true});
        
        /* ======== TITLE TABS ======== */
        jQuery(".block_with_tabs").tabs();
        
        /* ======== ACCORDIONS ======== */
        jQuery(".accordion_group").accordion({
            heightStyle: "content",
            collapsible: true,
            icons: false
        });
        
        /* ======== TABS ======== */
        jQuery(".tab_group").tabs();
        
        /* ======== FITVIDS ======== */
        jQuery("body").fitVids();
        
        /* ======== PRICE FILTER ======== */
        jQuery(".price_slider_wrapper").slider({
            range: true,
            min: 0,
            max: 300,
            values: [0, 300],
            slide: function(event, ui) {
                $(".price_label").text("$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ]);
            }
        });
        jQuery('span.from').text("$" + $(".price_slider_wrapper").slider("values", 0));
        jQuery('span.to').text("$" + $(".price_slider_wrapper").slider("values", 1));
        
        /* ======== DEMO ======== */        
        /* ======== STYLE PREVIEW ACCORDION ======== */
        jQuery("#accordion").accordion({
            collapsible: true,
            heightStyle: "content",
            active: 0,
            icons: false
        });
    
    });

})(jQuery);