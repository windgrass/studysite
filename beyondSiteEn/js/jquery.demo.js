(function ($) {
    "use strict";

    jQuery(document).ready(function () {

        /* ======== SHOW/HIDE DEMO ======== */
        jQuery(".demo_settings_init").click(function(){
            jQuery(".demo_settings").toggleClass("show");
        });
        
        /* ======== STYLE HEADER CHANGE ======== */
        jQuery("ul.styleheaderchange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.styleheaderchange li.style_1").click(function(){
            jQuery("#header").removeClass("style_2");
            jQuery("#header").addClass("style_1");
        });
        jQuery("ul.styleheaderchange li.style_2").click(function(){
            jQuery("#header").removeClass("style_1");
            jQuery("#header").addClass("style_2");
        });
        
        /* ======== TOP HEADER CHANGE ======== */
        jQuery("ul.topheaderchange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.topheaderchange li.dark").click(function(){
            jQuery(".header_meta").removeClass("light");
            jQuery(".header_meta").addClass("dark");
        });
        jQuery("ul.topheaderchange li.light").click(function(){
            jQuery(".header_meta").removeClass("dark");
            jQuery(".header_meta").addClass("light");
        });
        
        /* ======== MAIN HEADER CHANGE ======== */
        jQuery("ul.mainheaderchange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.mainheaderchange li.light").click(function(){  
            jQuery(".header_body").removeClass("dark");
            jQuery(".header_body").addClass("light");
        });
        jQuery("ul.mainheaderchange li.dark").click(function(){  
            jQuery(".header_body").removeClass("light");
            jQuery(".header_body").addClass("dark");
        });
        
        /* ======== MENU HEADER CHANGE ======== */
        jQuery("ul.menuheaderchange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.menuheaderchange li.light").click(function(){
            jQuery(".header_menu").removeClass("dark");
            jQuery(".header_menu").addClass("light");
        });
        jQuery("ul.menuheaderchange li.dark").click(function(){
            jQuery(".header_menu").removeClass("light");
            jQuery(".header_menu").addClass("dark");
        });
        
        /* ======== FEATURED CAROUSEL CHANGE ======== */
        jQuery("ul.featuredcarouselchange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.featuredcarouselchange li.light").click(function(){
            jQuery(".featured_carousel").removeClass("dark");
            jQuery(".featured_carousel").addClass("light");
        });
        jQuery("ul.featuredcarouselchange li.dark").click(function(){
            jQuery(".featured_carousel").removeClass("light");
            jQuery(".featured_carousel").addClass("dark");
        });
        
        /* ======== GRID BLOCK CHANGE ======== */
        jQuery("ul.gridblockchange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.gridblockchange li.light").click(function(){
            jQuery(".grid_block").removeClass("dark");
            jQuery(".grid_block").addClass("light");
        });
        jQuery("ul.gridblockchange li.dark").click(function(){
            jQuery(".grid_block").removeClass("light");
            jQuery(".grid_block").addClass("dark");
        });
        
        /* ======== BREAKING NEWS CHANGE ======== */
        jQuery("ul.breakingnewschange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.breakingnewschange li.light").click(function(){
            jQuery(".breaking_news").removeClass("dark");
            jQuery(".breaking_news").addClass("light");
        });
        jQuery("ul.breakingnewschange li.dark").click(function(){
            jQuery(".breaking_news").removeClass("light");
            jQuery(".breaking_news").addClass("dark");
        });
        
        /* ======== FIXED MENU CHANGE ======== */
        jQuery("ul.fixedmenuchange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.fixedmenuchange li.sticky_menu").click(function(){
            jQuery(".header_menu").removeClass("none_sticky_menu");
            jQuery(".header_menu").addClass("sticky_menu");
        });
        jQuery("ul.fixedmenuchange li.none_sticky_menu").click(function(){
            jQuery(".header_menu").removeClass("sticky_menu");
            jQuery(".header_menu").addClass("none_sticky_menu");
        });
        
        /* ======== LAYOUT STYLE CHANGE ======== */
        jQuery("ul.layoutstylechange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.layoutstylechange li.wide").click(function(){
            jQuery("#wrapper").removeClass("boxed");
            jQuery("#wrapper").addClass("wide");
        });
        jQuery("ul.layoutstylechange li.boxed").click(function(){
            jQuery("#wrapper").removeClass("wide");
            jQuery("#wrapper").addClass("boxed");
        });
        
        /* ======== PATTERN IMAGE CHANGE ======== */
        jQuery("ul.patternimagechange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.patternimagechange li.patt1").click(function(){
            jQuery("body").removeClass();
        });
        jQuery("ul.patternimagechange li.patt2").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("patt2");
        });
        jQuery("ul.patternimagechange li.patt3").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("patt3");
        });
        jQuery("ul.patternimagechange li.patt4").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("patt4");
        });
        jQuery("ul.patternimagechange li.patt5").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("patt5");
        });
        jQuery("ul.patternimagechange li.patt6").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("patt6");
        });
        jQuery("ul.patternimagechange li.patt7").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("patt7");
        });
        jQuery("ul.patternimagechange li.patt8").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("patt8");
        });
        jQuery("ul.patternimagechange li.patt9").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("patt9");
        });
        jQuery("ul.patternimagechange li.patt10").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("patt10");
        });
        
        /* ======== BODY IMAGE CHANGE ======== */
        jQuery("ul.bodyimagechange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.bodyimagechange li.matt1").click(function(){
            jQuery("body").removeClass();
        });
        jQuery("ul.bodyimagechange li.matt2").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("matt2");
        });
        jQuery("ul.bodyimagechange li.matt3").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("matt3");
        });
        jQuery("ul.bodyimagechange li.matt4").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("matt4");
        });
        jQuery("ul.bodyimagechange li.matt5").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("matt5");
        });
        jQuery("ul.bodyimagechange li.matt6").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("matt6");
        });
        jQuery("ul.bodyimagechange li.matt7").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("matt7");
        });
        jQuery("ul.bodyimagechange li.matt8").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("matt8");
        });
        jQuery("ul.bodyimagechange li.matt9").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("matt9");
        });
        jQuery("ul.bodyimagechange li.matt10").click(function(){
            jQuery("body").removeClass();
            jQuery("body").addClass("matt10");
        });
        
        /* ======== MAIN COLOR CHANGE ======== */
        jQuery("ul.maincolorchange li").click(function(){
            jQuery(this).siblings("li").removeClass("active");
            jQuery(this).addClass("active");
        });
        jQuery("ul.maincolorchange li").click(function(){
            var id = $(this).attr("id");
            $("#switch_style").attr("href", "demo/main-color/" + id + ".css");
        });

    });
    
})(jQuery);

jQuery("body").append("<div class='demo_settings'></div>");
jQuery(".demo_settings").append(
        "<div class='demo_settings_init'><i class='fa fa-sliders'></i></div>" +
        "<div class='demo_settings_inner'>" +
        
        "<section class='title'>" +
            "<h2>GoodStart</h2>" +
            "<h4>Style Preview</h4>" +
        "</section>" +
        
        "<div id='accordion'>" +
            "<h5 class='subtitle'>Header style</h5>" +
            "<div>" +
                "<div class='group'>" +
                    "<label>Header default/center</label>" +
                    "<ul class='styleheaderchange'>" +
                        "<li class='active style_1'><span></span></li>" +
                        "<li class='style_2'><span></span></li>" +
                    "</ul>" +
                "</div>" +
            "</div>" +
            
            "<h5 class='subtitle'>Header options</h5>" +
            "<div>" +
                "<div class='group'>" +
                    "<label>Top header dark/light</label>" +
                    "<ul class='topheaderchange'>" +
                        "<li class='active dark'><span></span></li>" +
                        "<li class='light'><span></span></li>" +
                    "</ul>" +
                "</div>" +
                "<div class='group'>" +
                    "<label>Main header dark/light</label>" +
                    "<ul class='mainheaderchange'>" +
                        "<li class='dark'><span></span></li>" +
                        "<li class='active light'><span></span></li>" +
                    "</ul>" +
                "</div>" +
                "<div class='group'>" +
                    "<label>Menu header dark/light</label>" +
                    "<ul class='menuheaderchange'>" +
                        "<li class='active dark'><span></span></li>" +
                        "<li class='light'><span></span></li>" +
                    "</ul>" +
                "</div>" +
                "<div class='group'>" +
                    "<label>Carousel dark/light</label>" +
                    "<ul class='featuredcarouselchange'>" +
                        "<li class='dark'><span></span></li>" +
                        "<li class='active light'><span></span></li>" +
                    "</ul>" +
                "</div>" +
                "<div class='group'>" +
                    "<label>Grid block dark/light</label>" +
                    "<ul class='gridblockchange'>" +
                        "<li class='dark'><span></span></li>" +
                        "<li class='active light'><span></span></li>" +
                    "</ul>" +
                "</div>" +
                "<div class='group'>" +
                    "<label>Breaking news dark/light</label>" +
                    "<ul class='breakingnewschange'>" +
                        "<li class='active dark'><span></span></li>" +
                        "<li class='light'><span></span></li>" +
                    "</ul>" +
                "</div>" +
                "<div class='group'>" +
                    "<label>Menu fixed on/off</label>" +
                    "<ul class='fixedmenuchange'>" +
                        "<li class='active sticky_menu'><span></span></li>" +
                        "<li class='none_sticky_menu'><span></span></li>" +
                    "</ul>" +
                "</div>" +
            "</div>" +
            
            "<h5 class='subtitle'>Layout style</h5>" +
            "<div>" +
                "<div class='group'>" +
                    "<label>Layout wide/boxed</label>" +
                    "<ul class='layoutstylechange'>" +
                        "<li class='active wide'><span></span></li>" +
                        "<li class='boxed'><span></span></li>" +
                    "</ul>" +
                "</div>" +
            "</div>" +
            
            "<h5 class='subtitle'>Background image</h5>" +
            "<div>" +
                "<div class='group'>" +
                    "<label>Pattern</label>" +
                    "<ul class='patternimagechange'>" +
                        "<li class='active patt1'></li>" +
                        "<li class='patt2' style='background-image: url(demo/style-preview/patterns/patt2.jpg)'></li>" +
                        "<li class='patt3' style='background-image: url(demo/style-preview/patterns/patt3.jpg)'></li>" +
                        "<li class='patt4' style='background-image: url(demo/style-preview/patterns/patt4.jpg)'></li>" +
                        "<li class='patt5' style='background-image: url(demo/style-preview/patterns/patt5.jpg)'></li>" +
                        "<li class='patt6' style='background-image: url(demo/style-preview/patterns/patt6.jpg)'></li>" +
                        "<li class='patt7' style='background-image: url(demo/style-preview/patterns/patt7.jpg)'></li>" +
                        "<li class='patt8' style='background-image: url(demo/style-preview/patterns/patt8.jpg)'></li>" +
                        "<li class='patt9' style='background-image: url(demo/style-preview/patterns/patt9.jpg)'></li>" +
                        "<li class='patt10' style='background-image: url(demo/style-preview/patterns/patt10.jpg)'></li>" +
                    "</ul>" +
                "</div>" +
                "<div class='group'>" +
                    "<label>Image</label>" +
                    "<ul class='bodyimagechange'>" +
                        "<li class='active matt1'></li>" +
                        "<li class='matt2' style='background-image: url(demo/style-preview/backgrounds/matt2.jpg)'></li>" +
                        "<li class='matt3' style='background-image: url(demo/style-preview/backgrounds/matt3.jpg)'></li>" +
                        "<li class='matt4' style='background-image: url(demo/style-preview/backgrounds/matt4.jpg)'></li>" +
                        "<li class='matt5' style='background-image: url(demo/style-preview/backgrounds/matt5.jpg)'></li>" +
                        "<li class='matt6' style='background-image: url(demo/style-preview/backgrounds/matt6.jpg)'></li>" +
                        "<li class='matt7' style='background-image: url(demo/style-preview/backgrounds/matt7.jpg)'></li>" +
                        "<li class='matt8' style='background-image: url(demo/style-preview/backgrounds/matt8.jpg)'></li>" +
                        "<li class='matt9' style='background-image: url(demo/style-preview/backgrounds/matt9.jpg)'></li>" +
                        "<li class='matt10' style='background-image: url(demo/style-preview/backgrounds/matt10.jpg)'></li>" +
                    "</ul>" +
                "</div>" +
            "</div>" +
            
            "<h5 class='subtitle'>Main color</h5>" +
            "<div>" +
                "<div class='group'>" +
                    "<label>Choose color palletes</label>" +
                    "<ul class='maincolorchange'>" +
                        "<li id='blue' class='active blue' style='background-color:#22A7F0'></li>" +
                        "<li id='red' class='red' style='background-color:#F64747'></li>" +
                        "<li id='orange' class='orange' style='background-color:#eb8000'></li>" +
                        "<li id='green' class='green' style='background-color:#87D37C'></li>" +
                        "<li id='yellow' class='yellow' style='background-color:#F7CA18'></li>" +
                        "<li id='gray' class='gray' style='background-color:#6C7A89'></li>" +
                        "<li id='lblue' class='lblue' style='background-color:#AEA8D3'></li>" +
                        "<li id='lgreen' class='lgreen' style='background-color:#4ECDC4'></li>" +
                        "<li id='dblue' class='dblue' style='background-color:#446CB3'></li>" +
                        "<li id='lorange' class='lorange' style='background-color:#F5D76E'></li>" +
                    "</ul>" +
                    "<p style='font-style:italic; font-size:12px; line-height:16px'>These are only for demo purpose!<br>\n\
                        With download files you can pick define any color for your template!</p>" +
                "</div>" +
            "</div>" +
            
            "<h5 class='subtitle'>Useful links</h5>" +
            "<div>" +
                "<div class='group'>" +
                    "<p><i class='fa fa-external-link' style='font-size:10px;'></i> <a href='http://themeforest.net/user/different-themes/portfolio?ref=CodeoStudio' target='_blank'>Buy template</a><br>" +
                    "<i class='fa fa-external-link' style='font-size:10px;'></i> <a href='http://codeostudio.hr/premium/help/' target='_blank'>Online documentation</a><br>" +
                    "<i class='fa fa-external-link' style='font-size:10px;'></i> <a href='http://themeforest.net/user/different-themes/portfolio?ref=CodeoStudio' target='_blank'>See more themes</a></p>" +
                "</div>" +
            "</div>" +
            
        "</div>" +
        
        "<p style='margin-top:40px; color:#999'><i class='fa fa-copyright' style='font-size:10px;color: #349dc9;'></i> 2015 Codeo Studio.</p>" +

        
        "</div>"
);