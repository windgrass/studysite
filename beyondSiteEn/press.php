<!--start section-->
<section class="ns_section">

    <!--start ns_container-->
    <div class="ns_container ns_clearfix">

        <div class="ns_space20"></div>

		<div class="grid grid_8">
			<div class="grid grid_12">
				<h1 class="subtitle green">Latest News</h1>
				<div class="ns_space20"></div>
				<div class="ns_divider left big"><span class="ns_bg_green ns_radius"></span></div>
				<div class="ns_space10"></div>
			</div>
			<?php include('sc_news.php'); ?>
		</div>
				
		<!--sidebar-->
		<div class="grid grid_4">

            <div class="ns_archive1 ns_bg_grey ns_radius ns_shadow">
                <div class="ns_textevidence ns_bg_green ns_radius_top">
                    <h4 class="white ns_margin20">LATEST POSTS</h4>
                </div>
                <ul class="ns_list border">
                    <?php include('sc_headlines.php'); ?>
                </ul>
            </div>

            <div class="ns_space20"></div>

			<div class="ns_archive1 ns_bg_grey ns_radius ns_shadow">
                <div class="ns_textevidence ns_bg_blue ns_radius_top">
                    <h4 class="white ns_margin20">TWITTER</h4>
                </div>
                <ul class="ns_list border">
                    <?php include('sc_twitter.php'); ?>
                </ul>
            </div>
			
			<div class="ns_space20"></div>
			
			<div class="ns_archive1 ns_bg_grey ns_radius ns_shadow">
                <div class="ns_textevidence ns_bg_bluedark ns_radius_top">
                    <h4 class="white ns_margin20">FACEBOOK</h4>
                </div>
                <ul class="ns_list border">
                    <?php include('sc_facebook.php'); ?>
                </ul>
            </div>

		</div>
		<!--sidebar-->

		<div class="ns_space20"></div>

    </div>
    <!--end ns_container-->
            
</section>
<!--end section-->

<?php include('award.php'); ?>