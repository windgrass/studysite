<?php 

    $ergebnis = safe_query("SELECT * FROM ".PREFIX."movies WHERE activated='2' ORDER BY date DESC LIMIT 0,12");
	
	$i=1;
	while($ar=mysql_fetch_array($ergebnis)) {
			
			$hits=$ar[hits];
			$type=getmovcat($ar[movcatID]);
			$movheadline=$ar[movheadline];
			
			if(mb_strlen($movheadline)>30) {
				$movheadline=mb_substr($movheadline, 0, 30);
				$movheadline.='...';
			}
			
			$movID=$ar[movID];
			$uploader=getnickname($ar[uploader]);
			
			$ratingpic=''.$ar['rating'].' Like(s)';
			
			if($ar[movscreenshot]) { 
				$pic='images/movies/'.$ar[movscreenshot].'';
			}
			else { 
				$pic=''.$ar[movfile].'';
			}
			
	echo'<div class="grid grid_4 percentage">
			<div class="ns_archive1" style="margin: 5% 5%; float: left; width: 90%;">
				<h5 class="orange" style="text-align: center; height: 30px"><a href="index.php?site=videos&action=show&id='.$movID.'">'.$movheadline.'</a></h5>
				<div style="float: left; width: 100%; max-height: 400px; text-align: center"><center><a href="index.php?site=videos&action=show&id='.$movID.'"><img src="'.$pic.'" style="width: auto; max-width: 100%;" /></a></center></div>
			</div>
	</div>';
		
$i++;

}

?>