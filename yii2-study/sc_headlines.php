<?php

if(isset($rubricID) and $rubricID) $only = "AND rubric='".$rubricID."'";
else $only='';

$ergebnis=safe_query("SELECT * FROM ".PREFIX."news WHERE published='1' ".$only." AND intern<=".isclanmember($userID)." ORDER BY date DESC LIMIT 0,".$maxheadlines);
if(mysql_num_rows($ergebnis)){
	$n=1;
	while($ds=mysql_fetch_array($ergebnis)) {
		$date=date("d.m.Y", $ds['date']);
		$time=date("H:i", $ds['date']);
		$newsID=$ds['newsID'];
		$pic='images/news_pics/'.$ds['banner'].'';
		$type = getrubricname($ds['rubric']);
		
		$message_array = array();
		$query=safe_query("SELECT n.*, c.short AS `countryCode`, c.country FROM ".PREFIX."news_contents n LEFT JOIN ".PREFIX."countries c ON c.short = n.language WHERE n.newsID='".$ds['newsID']."'");
		while($qs = mysql_fetch_array($query)) {
			$message_array[] = array('lang' => $qs['language'], 'headline' => $qs['headline'], 'intro' => $qs['intro'], 'message' => $qs['content'], 'country'=> $qs['country'], 'countryShort' => $qs['countryCode']);
		}
		$showlang = select_language($message_array);
	  
		$languages='';
		$i=0;
		foreach($message_array as $val) {
			if($showlang!=$i)	$languages.='<span style="padding-left:2px"><a href="index.php?site=news_comments&amp;newsID='.$ds['newsID'].'&amp;lang='.$val['lang'].'"><img src="images/flags/'.$val['countryShort'].'.gif" width="18" height="12" border="0" alt="'.$val['country'].'" /></a></span>';
			$i++;
		}
	  
		$lang=$message_array[$showlang]['lang'];
		$lang='<img src="images/flags/'.$lang.'.gif" />';
	
		$headlines=$message_array[$showlang]['headline'];
	
		if(mb_strlen($headlines)>68) {
			$headlines=mb_substr($headlines, 0, 68);
			$headlines.='...';
		}
		
	    $intro=$message_array[$showlang]['intro'];
		
		if(mb_strlen($intro)>200) {
			$intro=mb_substr($intro, 0, 200);
			$intro.='...';
		}
				
		if($ds['blog'] == '1') {
			$url1="http://";
			if($ds['url1']!="http://") $url1=$ds['url1'];
		} 
		else {
			$url1='index.php?site=article&newsID='.$ds['newsID'].'';
		}
		
		$headlines=clearfromtags($headlines);
		$intro=clearfromtags($intro);
		
		if($ds['game'] == '') { $game = ''; } 
        else { $game = '<img src="images/games/'.$ds['game'].'.png" width="16px" height="16px" />'; }
		
		eval ("\$sc_headlines = \"".gettemplate("sc_headlines")."\";");
		echo $sc_headlines;
		
		$n++;
	}
	unset($rubricID);
}
?>
