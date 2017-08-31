<?php 

    $ergebnis = safe_query("SELECT * FROM ".PREFIX."movies WHERE activated='2' ORDER BY date DESC LIMIT 0,2");
				
	$i=1;
	while($ar=mysql_fetch_array($ergebnis)) {
			
			$hits=$ar['hits'];
			$ytvcode=$ar['ytvcode'];
			$type=getmovcat($ar['movcatID']);
			$movheadline=$ar['movheadline'];
			$movID=$ar['movID'];
			$uploader=getnickname($ar['uploader']);
			
			if($ar['rating'])	$ratingpic='<img src="images/rating'.$ar['rating'].'.png" width="103" height="31" title="'.$ar['rating'].' of 10; '.$ar['votes'].' votes" />';
			else $ratingpic='<img src="images/rating0.png" width="103" height="31" title="no votes yet" />';
			
			$pic='images/movies/'.$ar['movscreenshot'].'';
			
	echo'
		<div class="grid grid_6">   
            <div class="ns_archive1" style="color: #20a3dd; background: #FFF;">
				<div class="ns_margin20" style="width:92%; height:100%; margin-left: 4%">
					<h4 class="white"><a href="index.php?site=videos&action=show&id='.$movID.'">'.$ar['movheadline'].'</a></h4>
					<div class="ns_space20"></div>
					<div class="video-container"><iframe src="https://www.youtube.com/embed/'.$ytvcode.'" frameborder="0" allowfullscreen></iframe></div>
				</div>
            </div>
		</div>
	';
	
$i++;

}

?>