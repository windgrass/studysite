<?php

eval ("\$features_head = \"".gettemplate("features_head")."\";");
echo $features_head;

$ergebnis=safe_query("SELECT * FROM ".PREFIX."features ORDER BY sort LIMIT 0,3");
/* if(mysql_num_rows($ergebnis) == 3) { */
$i=1;
    while($db=mysql_fetch_array($ergebnis)) {
$pic = 'images/features/'.$db['banner'].'';
$cat = $db['featurestext'];
$title = $db['featurestitle'];
$url = $db['url'];

eval ("\$features_content = \"".gettemplate("features_content")."\";");

				echo '
				<li data-transition="fade" data-slotamount="7" data-link="'.$db['url'].'" data-masterspeed="1000" data-saveperformance="on"  data-title="">
					<img src="'.$pic.'"  alt="" data-lazyload="'.$pic.'" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat">
				</li>
				';

$i++;

	}
?>
