<?php

$_language->read_module('sponsors');
$mainsponsors=safe_query("SELECT * FROM ".PREFIX."sponsors WHERE (displayed = '1' AND mainsponsor = '1') ORDER BY RAND() LIMIT 0,4");

	if(mysql_num_rows($mainsponsors) == 1) $main_title = $_language->module['mainsponsor'];
	else $main_title = $_language->module['mainsponsors'];
	
	$i=1;
	while($da=mysql_fetch_array($mainsponsors)) {
		if(!empty($da['banner_small'])) $sponsor='<img src="images/sponsors/'.$da['banner_small'].'" border="0" alt="'.htmlspecialchars($da['name']).'" title="'.htmlspecialchars($da['name']).'" />';
		else $sponsor=$da['name'];
		$sponsorID = $da['s'];
				
		if($i=='1') { $colora = 'blue'; }
		elseif($i=='2') { $colora = 'green'; }
		elseif($i=='3') { $colora = 'yellow'; }
		else { $colora = 'red'; }
		
		echo '
		<div class="grid grid_3">   
            <!--archive1-->
              <div class="ns_archive1 ns_radius" style="color: #20a3dd; background: #FFF;">
				<div class="ns_margin20">
					<img alt="" src="images/sponsors/'.$da['banner_small'].'">   
                    <div style="padding: 20px 0px; height: 35px; display: table; width:100%;"><h4 class="'.$colora.'" style="display: table-cell; vertical-align: middle; text-transform: uppercase; text-align: center;">'.$da['name'].'</h4></div>
					<a href="index.php?site=game&s='.$sponsorID.'"><div style="padding: 20px; text-align: center; text-transform: uppercase;" class="'.$colora.' ns_bg_'.$colora.' ns_radius"><h5 class="white">More</h5></div></a>
				</div>
            </div>
		</div>
		';
		
	$i++;	
	}
	
	
?>