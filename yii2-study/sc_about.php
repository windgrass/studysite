<?php

$_language->read_module('about');

$ergebnis=safe_query("SELECT * FROM ".PREFIX."about");
if(mysql_num_rows($ergebnis)) {
	$ds=mysql_fetch_array($ergebnis);

	$about=htmloutput($ds['about']);
	
	if(mb_strlen($about)>200) {
		$about=mb_substr($about, 0, 200);
		$about.='...';
	}
	
	echo '<p>'.$about.'</p>';
		
		
}
else echo $_language->module['no_about'];

?>
