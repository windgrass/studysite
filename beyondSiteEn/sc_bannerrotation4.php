<?php

$_language->read_module('sc_bannerrotation');

//get banner
	
$allbanner = safe_query("SELECT * FROM ".PREFIX."bannerrotation4 WHERE displayed='1' ORDER BY date LIMIT 0,3");
if(mysql_num_rows($allbanner)) {
	$i=1;	
	while($banner=mysql_fetch_array($allbanner)) {	
	
	if($i=='1') { $colora = 'blue'; $colorab = 'bluedark'; }
	elseif($i=='2') { $colora = 'green'; $colorab = 'greendark'; }
	else { $colora = 'red'; $colorab = 'reddark'; }
	
	echo '<div class="grid grid_4">   
            <!--archive1-->
            <div class="ns_archive1 ns_bg_'.$colora.'">
				<a href="'.$banner['bannerurl'].'"><img alt="" src="./images/bannerrotation4/'.$banner['banner'].'"></a>
            </div>
            <!--archive1-->
        </div>';
	
	$i++;
}
}
unset($banner);
?>
