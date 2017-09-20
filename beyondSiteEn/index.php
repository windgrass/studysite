<?php

include("_mysql.php"); 
include("_settings.php");
include("_functions.php");

$_language->read_module('index');
$index_language = $_language->module;
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">  
    <title><?php echo PAGETITLE; ?></title>
	<base href="http://<?php echo $hp_url; ?>/" />
<!--	<base href="http://localhost:8082/" />-->
    <meta name="description" content="">
    <meta name="author" content="www.nuno-silva.pt">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--START CSS--> 
    <link rel="stylesheet" href="css/ns_style.css">
    <link rel="stylesheet" href="css/ns_responsive.css">
    <link rel="stylesheet" href="css/revslider/settings.css">
<!--    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>-->
<!--    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>-->
<!--    <link href='http://fonts.googleapis.com/css?family=Montez' rel='stylesheet' type='text/css'>-->
	<script src="assets/js/bbcode.js" language="jscript" type="text/javascript"></script>
	<!--END CSS-->
    <!--[if lt IE 9]>  
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>  
    <![endif]-->  
    <!--FAVICONS-->
    <link rel="shortcut icon" href="img/pipi.ico">
    <link rel="apple-touch-icon" href="">
    <link rel="apple-touch-icon" sizes="72x72" href="">
    <link rel="apple-touch-icon" sizes="114x114" href="">
	<?php include('sc_featuredcont.php'); ?>
    <!--END FAVICONS-->
	
	<!-- Facebook Pixel Code -->
<script>
//!function(f,b,e,v,n,t,s)
//{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
//n.callMethod.apply(n,arguments):n.queue.push(arguments)};
//if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
//n.queue=[];t=b.createElement(e);t.async=!0;
//t.src=v;s=b.getElementsByTagName(e)[0];
//s.parentNode.insertBefore(t,s)}(window,document,'script',
//'https://connect.facebook.net/en_US/fbevents.js');
//fbq('init', '1262451913852044');
//fbq('track', 'PageView');
</script>
<noscript>
<img height="1" width="1" 
src="https://www.facebook.com/tr?id=1262451913852044&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

</head>  
<body id="start_ns_framework">
<div class="ns_site">
<div class="ns_site_fullwidth ns_clearfix"><div class="ns_overlay"></div>
<div class="ns_section ns_navigation fade-down">
    <div class="ns_menu_fullwidth">
		<div class="ns_section ns_shadow ns_bg_grey">
			<div class="ns_container ns_clearfix">
				<div style="float: right; padding: 5px 0px; font-family: 'Montserrat', sans-serif;"><a class="grey" href="index.php?site=contacts">Contacts</a></div>
			</div>
		</div>
        <div class="ns_space3 ns_bg_gradient" style="height: 5px; z-index: 9999; position: relative;"></div>
        <div class="ns_section ns_shadow ns_bg_white" style="z-index: 9999;position: relative;">
            <div class="ns_container ns_clearfix">
                <div class="grid grid_12 percentage">
                        <div class="ns_space15"></div>
                        <div class="ns_logo ns_marginleft10">
                            <a href="index.php"><img alt="" src="img/logo.png"></a>
                        </div>
                        <nav>
                            <ul class="ns_menu ns_margin010 ns_padding50">

                                <li class="red ns_shadow ns_bg_red" style="padding: 10px 10px; border-radius: 10px">
                                    <a href="index.php?site=tablet" style="color: #FFF">定制</a>
                                </li>
                                <li class="orange ns_shadow ns_bg_orange" style="padding: 10px 10px; background: #ec774b;; border-radius: 10px">
                                    <a href="index.php?site=games" style="color: #FFF">产品</a>
                                </li>
                                <li class="yellow ns_shadow ns_bg_yellow" style="padding: 10px 10px; background: #edbf47; border-radius: 10px">
                                    <a href="index.php?site=intelligences" style="color: #FFF">个性案例</a>
                                </li>
                                <li class="green ns_shadow ns_bg_green" style="padding: 10px 10px; background: #6ab54a; border-radius: 10px">
                                    <a href="index.php?site=press" style="color: #FFF">设计团队</a>
                                </li>
                                <li class="blue ns_shadow ns_bg_blue" style="padding: 10px 10px; background: #20a3dd; border-radius: 10px">
                                    <a href="index.php?site=about" style="color: #FFF">关于我们</a>
                                </li>
								 <li class="violet ns_shadow ns_bg_violet" style="padding: 10px 10px; background: #c389ce; border-radius: 10px">
                                    <a href="index.php?site=app" style="color: #FFF">APP</a>
                                </li>
<!--								<li style="padding: 10px 10px; border-radius: 10px;">-->
<!--                                    <a href="http://www.baile666.com/" style="color: grey">官网</a>-->
<!--                                </li>-->
                            </ul>
                        </nav>
                        <div class="ns_space20"></div>
                </div>
            </div>
            <!--end container-->
        </div>
        <!--end header-->
    </div>
</div>

<?php if($site=="") { ?>	
<!--start section-->
<section class="ns_section">
	<div class="tp-banner-container boxedcontainer" style="margin-top: 10px">
		<div class="ns_slide1">
			<ul>
				<?php include('features.php'); ?>
			</ul>
		</div>
	</div>
</section>
<!--end section-->

<!--start section-->
<section id="ns_parallax_countdown" class="ns_section ns_imgparallax ns_parallaxx_img-teachers-1" style="margin-top: 30px">
    <div class="ns_filter greydark">
        <!--start ns_container-->
        <div class="ns_container ns_clearfix">
            <div class="ns_space40"></div>
            <div class="grid grid_12">
				<div class="ns_divider center big"><span class="ns_bg_white ns_radius"></span></div>
				<div class="ns_space15"></div>				
                <h1 class="white center subtitle"><b>现在预约 免费量尺 免费设计 免费安装</b></h1>
                <div class="ns_space15"></div>
				<center><?php include("sc_newsletter.php"); ?></center>
				<div class="ns_space20"></div>
				<div class="ns_divider center big"><span class="ns_bg_white ns_radius"></span></div> 
				<div class="ns_space10"></div>
            </div>
            <div class="ns_space40"></div>
        </div>
        <!--end ns_container-->
    </div>      
</section>
<!--end section-->

<!--start section-->
<section class="ns_section" style="margin-top: 30px">
    <!--start ns_container-->
    <div class="ns_container ns_clearfix">
		<?php include('sc_bannerrotation4.php'); ?>
        <div class="ns_space40"></div>
	</div>
   <!--end ns_container-->       
</section>
<!--end section-->

<!--start section-->
<section id="ns_parallax_countdown" class="ns_section ns_imgparallax ns_parallaxx_img-teachers-1">
    <div class="ns_filter greydark">
        <!--start ns_container-->
        <div class="ns_container ns_clearfix">
		    <div class="ns_space40"></div>
			<div class="grid grid_12">
				<h1 class="subtitle white"><b>产品系列</b></h1>
				<div class="ns_space20"></div>
				<div class="ns_divider left big"><span class="ns_bg_white ns_radius"></span></div>
				<div class="ns_space10"></div>
			</div>
            <?php include('sc_sponsors_main.php'); ?>
		    <div class="ns_space40"></div>
        </div>
        <!--end ns_container-->
    </div>      
</section>
<!--end section-->

<!--start section-->
<section class="ns_section" style="margin: 20px 0px">
    <!--start ns_container-->
    <div class="ns_container ns_clearfix">
		<div class="grid grid_12 percentage" style="min-height: 300px;">
            <!--archive1-->
            <!--<div class="ns_archive1" style="margin-left: 0px">
				<div class="ns_space30"></div>
				<h1 class="subtitle blue"><b>BEYOND TABLET</b></h1>
				<div class="ns_space20"></div>
				<div style="width: 100%; float: left;">
					<h2>Screen-less Family Fun <br \>& No screen no screen addiction</h2>
					<div class="ns_space30"></div>
					<div style="width: 100%; float: right"><img src="img/to.png" style="width: 100%" /></div>
					<div class="ns_space20"></div>
				</div>
			</div>-->
			
			<div class="grid grid_4">   
            <!--archive1-->
            <div class="ns_archive1 ns_radius" style="margin: 3% 3%; float: right; width: 90%;">
                <div class="ns_margin20">
					<h3 class="subtitle blue">Our Story:</h3>
					<div class="ns_space10"></div>
					<p style="text-align: justify">Beyond Tablet has been in development for the past three years. During this time, we have learned that the challenge of developing completely new technologies greatly differs from simply improving already existing ones. But despite the hard work, the payoff has been worth it. Creating Beyond Tablet has been a true labor of love.</p><br \>
                </div>
            </div>
            <!--archive1-->
			</div>

			<div class="grid grid_4">   
            <!--archive1-->
            <div class="ns_archive1 ns_radius" style="margin: 3% 3%; float: right; width: 90%;">
                <div class="ns_margin20">
					<h3 class="subtitle blue">Our Tech:</h3>
					<div class="ns_space10"></div>
					<p style="text-align: justify">The end result of our hard work is Beyond Tablet. By combining state-of-the-art technology with traditional toys, we have created a truly unique educational toy. Beyond Tablet integrates physical objects with capacitive touch surfaces, and together with sounds and visual feedbacks, it creates a tangible game experience.</p><br \>
                </div>
            </div>
            <!--archive1-->
			</div>
			<div class="grid grid_4">   
            <!--archive1-->
            <div class="ns_archive1 ns_radius" style="margin: 3% 3%; float: left; width: 90%;">
    
                <div class="ns_margin20">
					<h3 class="subtitle blue">What makes us unique:</h3>
					<div class="ns_space10"></div>
					<p style="text-align: justify">Creating an intelligent product for children without a screen, or requiring an existing smart device, is what sets Beyond Tablet apart from other products. The large size of the tablet makes it easy for up to four people to play together, like a traditional board game for the entire family. The embedded technology also ensures that the tablet is future-proof. No need for frequent hardware upgrades.</p>
                </div>
            </div>
            <!--archive1-->
			</div>
			<!--<div class="ns_space5"></div>
			<center><a href="index.php?site=tablet"><div style="display: block; clear:both; width: 200px; margin-right: 20px; padding: 20px; text-align: center; text-transform: uppercase;" class="red ns_bg_red ns_radius"><h5 class="white">What is Beyond Tablet?</h5></div></a></center>
				</div>
				<div class="ns_space30"></div>
            </div>-->
            <!--archive1-->
        </div>
   </div>
   <!--end ns_container-->       
</section>
<!--end section-->

<!--start section-->
<!--<section id="ns_parallax_countdown" class="ns_section">-->
<!--    <div class="ns_filter blue">-->
<!--        <!--start ns_container-->-->
<!--        <div class="ns_container ns_clearfix">-->
<!--		    <div class="ns_space40"></div>-->
<!--			<div class="grid grid_12">-->
<!--				<h1 class="subtitle white"><b>VIDEOS</b></h1>-->
<!--				<div class="ns_space10"></div>-->
<!--				<h5><a href="index.php?site=videos" class="white">> VIEW ALL VIDEOS</a></h5>-->
<!--				<div class="ns_space20"></div>-->
<!--				<div class="ns_divider left big"><span class="ns_bg_white ns_radius"></span></div>-->
<!--				<div class="ns_space10"></div>-->
<!--			</div>-->
<!--			--><?php //include('sc_videos.php'); ?>
<!--		    <div class="ns_space40"></div>-->
<!--        </div>-->
<!--        <!--end ns_container-->-->
<!--    </div>      -->
<!--</section>-->
<!--end section-->

<?php } elseif($site=="login" OR $site=="lostpassword" OR $site=="loginoverview") { ?>

	<section id="ns_parallax_title" class="ns_section ns_imgparallax ns_parallaxx_img-tablet" style="margin-top: -100px">
	<div class="ns_filter greydark">
    <div class="ns_container ns_clearfix">
        <div class="ns_space30"></div>
			<div class="ns_space100"></div>
            <div class="ns_space100"></div>
			<h1 class="white subtitle"><b>Logged in</b></h1>
			<div class="ns_space20"></div>
			<div class="ns_divider left big"><span class="ns_bg_white ns_radius"></span></div>
            <div class="ns_space20"></div>
		</div>
	</div>
	</section>
	<section class="ns_section">
    <div class="ns_container ns_clearfix">
        <div class="ns_space30"></div>
		<div class="grid grid_12">
			<?php if(!isset($site)) $site=""; $invalide = array('\\','/','/\/',':','.'); $site = str_replace($invalide,' ',$site); if(!file_exists($site.".php")) $site = ""; include($site.".php"); ?>                                
		</div>
	</div>
	</section>
<?php } else { ?>

<!--start section-->
<section id="ns_parallax_title" class="ns_section ns_imgparallax ns_parallaxx_img-tablet" style="margin-top: -100px">

    <div class="ns_filter <?php if($site=="tablet") echo "greydark"; elseif($site=="games") echo "greydark"; elseif($site=="intelligences") echo "greydark"; elseif($site=="press") echo"greydark"; elseif($site=="award") echo"greydark"; else echo"greydark"; ?>">

        <!--start ns_container-->
        <div class="ns_container ns_clearfix">

            <div class="grid grid_12">
                <div class="ns_space100"></div>
                <div class="ns_space100"></div>
                <h1 class="white subtitle"><b><?php if($site=="tablet") echo "TABLET"; elseif($site=="games") echo "GAMES"; elseif($site=="game") echo "GAMES"; elseif($site=="intelligences") echo "INTELLIGENCES"; elseif($site=="press") echo"PRESS & AWARDS"; elseif($site=="about") echo"ABOUT US"; elseif($site=="app") echo"APP"; elseif($site=="award") echo"AWARD"; elseif($site=="article") echo"ARTICLE";  elseif($site=="videos") echo"VIDEOS"; else echo"CONTACTS"; ?></b></h1>
                <div class="ns_space20"></div>
				<div class="ns_divider left big"><span class="ns_bg_white ns_radius"></span></div>
                <div class="ns_space20"></div>
				<?php if($site=="tablet") { ?>
				<h4 class="subtitle white">
					<!--<li class="ns_marginleft20"><a class="white" href="tablet#solving">Solving 3 Main Pain Points for Parents</a></li><br \>
					<li class="ns_marginleft20"><a class="white" href="tablet#best">Best of Virtual and Best of Physical Worlds Combined</a></li><br \>
					<li class="ns_marginleft20"><a class="white" href="tablet#what">What Is Beyond Tablet</a></li><br \>
					<li class="ns_marginleft20"><a class="white" href="tablet#tech">Technology Embedded in Beyond Tablet</a></li><br \>
					<li class="ns_marginleft20"><a class="white" href="tablet#original">An Original Invention</a></li><br \>-->
					<li class="ns_marginleft20">Solving three Main-Pain-Points for parents</li><br \>
					<li class="ns_marginleft20">Best of Virtual and Best of Physical Worlds Combined</li><br \>
					<li class="ns_marginleft20">What Is Beyond Tablet</li><br \>
					<li class="ns_marginleft20">Technology Embedded in Beyond Tablet</li><br \>
					<li class="ns_marginleft20">An Original Invention</li><br \>
				</h4>
				<?php } elseif($site=="games") { ?>
				<h4 class="subtitle white">
					<!--<li class="ns_marginleft20"><a class="white" href="games#beyond">Beyond Tablet Basic Package</a></li><br \>
					<li class="ns_marginleft20"><a class="white" href="games#games">Beyond Tablet Games</a></li><br \>-->
					<li class="ns_marginleft20">Beyond Tablet Basic Package</li><br \>
					<li class="ns_marginleft20">Beyond Tablet Games</li><br \>
				</h4>
				<?php } elseif($site=="intelligences") { ?>
				<h4 class="subtitle white">
					<!--<li class="ns_marginleft20"><a class="white" href="intelligences#simplified">Simplified and Empowered Parenting</a></li><br \>
					<li class="ns_marginleft20"><a class="white" href="intelligences#what">What is "Intelligence"</a></li><br \>
					<li class="ns_marginleft20"><a class="white" href="intelligences#develop">Develop "Ten Intelligences" with Beyond Tablet</a></li><br \>
					<li class="ns_marginleft20"><a class="white" href="intelligences#games">Games and Intelligences</a></li><br \>
					<li class="ns_marginleft20"><a class="white" href="intelligences#cloud">Cloud Connection</a></li><br \>
					<li class="ns_marginleft20"><a class="white" href="intelligences#growth">Growth Indicators</a></li><br \>-->
					
					<li class="ns_marginleft20">Simplified and Empowered Parenting</li><br \>
					<li class="ns_marginleft20">What is "Intelligence"?</li><br \>
					<li class="ns_marginleft20">Develop "Ten Intelligences" with Beyond Tablet</li><br \>
					<li class="ns_marginleft20">Games and Intelligences</li><br \>
					<li class="ns_marginleft20">Cloud Connection</li><br \>
				</h4>
				<?php } elseif($site=="videos") { ?>
				<h4 class="subtitle white">
					<?php include('sc_videos_cat.php'); ?>
				</h4>
				<?php } elseif($site=="game") { ?>

				<?php } ?>
            </div>

        </div>
        <!--end ns_container-->

    </div>
     
</section>
<!--end section-->

	<?php if($site=="tablet") { ?>
		<?php include("tablet.php"); ?>
	<?php } elseif($site=="games") { ?>
		<?php include("games.php"); ?>
	<?php } elseif($site=="intelligences") { ?>
		<?php include("intelligences.php"); ?>
	<?php } elseif($site=="article") { ?>
		<?php include("article.php"); ?>
	<?php } elseif($site=="press") { ?>
		<?php include("press.php"); ?>
	<?php } elseif($site=="award") { ?>
		<?php include("award.php"); ?>
	<?php } elseif($site=="videos") { ?>
	<section class="ns_section">
    <div class="ns_container ns_clearfix">
        <div class="ns_space30"></div>
		<div class="grid grid_12">
			<?php include("videos.php"); ?>
		</div>
		<div class="grid grid_4 hide">

            <div class="ns_archive1 ns_bg_grey ns_radius ns_shadow">
                <div class="ns_textevidence ns_bg_green ns_radius_top">
                    <h4 class="white ns_margin20">POPULAR VIDEOS</h4>
                </div>
                <ul class="ns_list border">
                    <?php include('sc_videos_popular.php'); ?>
				</ul>
            </div>
            <div class="ns_space20"></div>
		</div>
	</div>
	</section>
	<?php } else { ?>
		<div class="ns_container ns_clearfix">
			<?php 
			if(!isset($site)) $site=""; 
			$invalide = array('\\','/','/\/',':','.'); 
			$site = str_replace($invalide,' ',$site); 
			if(!file_exists($site.".php")) $site = ""; 
			include($site.".php");
			?>	
		</div>
	<?php } ?>

<?php } ?>  

<div class="ns_space3 ns_bg_gradient"></div>

<!--start section-->
<section class="ns_section ns_bg_greydark">
    <!--start ns_container-->
    <div class="ns_container ns_clearfix">
        <div class="ns_space30"></div>
		<div style="float: left; width: 100%; color: #FFF">
			<img src="img/footer.jpg" style="float: right; width: auto; max-width: 100%; margin-bottom: 20px;" />
			<p>Copyright @ 2015-2017 Beyond Screen Inc. All Rights Reserved <br \>
			ICP 12017056-3<br \>
			<!--Website by <a href="http://www.nuno-silva.pt" target="_blank">nuno-silva.pt</a></p>-->
		</div>
		<div class="ns_space30"></div>
    </div>
    <!--end ns_container-->     
</section>
<!--end section-->
        </div>
    </div>
	
    <!--js-->
	<script src="js/main/jquery.min.js"></script> 
    <script src="js/main/jquery-ui.js"></script>
    <script src="js/main/excanvas.js"></script>
    <script src="js/plugins/revslider/jquery.themepunch.tools.min.js"></script>
    <script src="js/plugins/revslider/jquery.themepunch.revolution.min.js"></script>
    <script src="js/plugins/menu/superfish.min.js"></script>
    <script src="js/plugins/menu/tinynav.min.js"></script>
    <script src="js/plugins/isotope/isotope.pkgd.min.js"></script>
    <script src="js/plugins/mpopup/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins/scroolto/scroolto.js"></script>
    <script src="js/plugins/nicescrool/jquery.nicescroll.min.js"></script>
    <script src="js/plugins/inview/jquery.inview.min.js"></script>
    <script src="js/plugins/parallax/jquery.parallax-1.1.3.js"></script>
    <script src="js/plugins/countto/jquery.countTo.js"></script>
    <script src="js/plugins/countdown/jquery.countdown.js"></script>
    <script src="js/settings.js"></script>
	<!--custom js-->
	<script type="text/javascript">
	jQuery(document).ready(function() {

		//START SLIDE
		jQuery('.ns_slide1').show().revolution(
		{
			dottedOverlay:"none",
			delay:16000,
			startwidth:1170,
			startheight:460,
			hideThumbs:200,
			thumbWidth:100,
			thumbHeight:50,
			thumbAmount:5,
			navigationType:"none",
			navigationArrows:"solo",
			navigationStyle:"preview2",
			touchenabled:"on",
			onHoverStop:"on",
			swipe_velocity: 0.7,
			swipe_min_touches: 1,
			swipe_max_touches: 1,
			drag_block_vertical: false,					
			parallax:"mouse",
			parallaxBgFreeze:"on",
			parallaxLevels:[7,4,3,2,5,4,3,2,1,0],					
			keyboardNavigation:"off",
			navigationHAlign:"center",
			navigationVAlign:"bottom",
			navigationHOffset:0,
			navigationVOffset:20,
			soloArrowLeftHalign:"left",
			soloArrowLeftValign:"center",
			soloArrowLeftHOffset:20,
			soloArrowLeftVOffset:0,
			soloArrowRightHalign:"right",
			soloArrowRightValign:"center",
			soloArrowRightHOffset:20,
			soloArrowRightVOffset:0,
			shadow:0,
			fullWidth:"off",
			fullScreen:"off",
			spinner:"spinner4",
			stopLoop:"off",
			stopAfterLoops:-1,
			stopAtSlide:-1,
			shuffle:"off",
			autoHeight:"off",						
			forceFullWidth:"off",												
			hideTimerBar: "on",									
			hideThumbsOnMobile:"off",
			hideNavDelayOnMobile:1500,						
			hideBulletsOnMobile:"off",
			hideArrowsOnMobile:"off",
			hideThumbsUnderResolution:0,
			hideSliderAtLimit:0,
			hideCaptionAtLimit:0,
			hideAllCaptionAtLilmit:0,
			startWithSlide:0,
			videoJsPath:"rs-plugin/videojs/",
			fullScreenOffsetContainer: ""	
		});
		//END SLIDE

		//START PARALLAX SECTIONS
		$('#ns_parallax_big_image').parallax("50%", 0.3);
		$('#ns_parallax_2_btns').parallax("50%", 0.3);
		$('#ns_parallax_countdown').parallax("50%", 0.3);
		$('#ns_parallax_counter').parallax("50%", 0.3);
		//END PARALLAX SECTIONS

	});
</script>
<!--custom js-->
<script>
//	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
//			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
//		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
//	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
//
//	ga('create', 'UA-97414089-1', 'auto');
//	ga('send', 'pageview');

</script>
</body>  
</html>