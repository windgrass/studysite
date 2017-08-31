<?php 

    $ergebnis = safe_query("SELECT * FROM ".PREFIX."movies WHERE activated='2' ORDER BY hits DESC LIMIT 0,5");
				
	$i=1;
	while($ar=mysql_fetch_array($ergebnis)) {
			
			$hits=$ar[hits];
			$type=getmovcat($ar[movcatID]);
			$movheadline=$ar[movheadline];
			$movID=$ar[movID];
			$uploader=getnickname($ar[uploader]);
			
			if($ar[rating])	$ratingpic='<img src="images/rating'.$ar[rating].'.png" width="103" height="31" title="'.$ar[rating].' of 10; '.$ar[votes].' votes" />';
			else $ratingpic='<img src="images/rating0.png" width="103" height="31" title="no votes yet" />';
			
			if($ar[movscreenshot]) { 
				$pic='images/movies/'.$ar[movscreenshot].'';
			}
			else { 
				$pic=''.$ar[movfile].'';
			}
			
	eval ("\$movies_content = \"".gettemplate("movies_content")."\";");
	echo $movies_content;
	
$i++;

}

?>