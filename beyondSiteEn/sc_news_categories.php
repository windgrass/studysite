<?php

$ergebnis=safe_query("SELECT * FROM ".PREFIX."news_rubrics");
if(mysql_num_rows($ergebnis)) {
	$n=1;
	while($db=mysql_fetch_array($ergebnis)) {
		$n++;
		$rubric=$db['rubric'];
		eval ("\$sc_news = \"".gettemplate("sc_news")."\";");
		echo $sc_news;
	}
}
?>