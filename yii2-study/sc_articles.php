<?php

$ergebnis = safe_query("SELECT date, title, articlesID FROM ".PREFIX."articles WHERE saved='1' ORDER BY date DESC LIMIT 0, ".$latestarticles);
if(mysql_num_rows($ergebnis)){
	echo'<table width="100%" cellspacing="0" cellpadding="2">';
  $n=1;
	while($ds = mysql_fetch_array($ergebnis)) {
		$date = date("d.m.Y", $ds['date']);
		$time = date("H:i", $ds['date']);
		$title = $ds['title'];
		$articlesID = $ds['articlesID'];
    
    if($n%2) {
			$bg1=BG_1;
			$bg2=BG_2;
		}
		else {
			$bg1=BG_3;
			$bg2=BG_4;
		}
    
    if(mb_strlen($title) > $articleschars) {
			$title = mb_substr($title, 0, $articleschars);
			$title .= '..';
		}
	
		eval("\$sc_articles = \"".gettemplate("sc_articles")."\";");
		echo $sc_articles;
    $n++;
	}
	echo'</table>';
}	
?>
