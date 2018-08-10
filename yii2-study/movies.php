<?php

function getmovcat($movcatID) {
		$ds=mysql_fetch_array(safe_query("SELECT movcatname FROM ".PREFIX."movie_categories WHERE movcatID='".$movcatID."'"));
		return htmlspecialchars($ds['movcatname']);
	}
	
function getytvcode($movID) {
		$ds=mysql_fetch_array(safe_query("SELECT ytvcode FROM ".PREFIX."movies WHERE movID='".$movID."'"));
		return $ds['ytvcode'];
	}
	
function getvideos() {
	$getvideos ="";
        $ergebnis=safe_query("SELECT * FROM ".PREFIX."movies");
	while($ds=mysql_fetch_array($ergebnis)) {
		$getvideos .='<option value="'.$ds['movID'].'">'.$ds['movheadline'].'</option>';
	}
	return $getvideos;
}

?>