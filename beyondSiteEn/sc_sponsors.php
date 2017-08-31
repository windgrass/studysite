<?php

$_language->read_module('sponsors');
	
$sponsors=safe_query("SELECT * FROM ".PREFIX."sponsors WHERE (displayed = '1') ORDER BY sort");
if(mysql_num_rows($sponsors)) {
	$i=1;	
	while($db=mysql_fetch_array($sponsors)) {
				
		if($i=='1' or $i=='7' or $i=='13') { $colora = 'blue'; $colorab = 'bluedark'; }
		elseif($i=='2' or $i=='8' or $i=='14') { $colora = 'green'; $colorab = 'greendark'; }
		elseif($i=='3' or $i=='9' or $i=='15') { $colora = 'yellow'; $colorab = 'yellowdark'; }
		elseif($i=='4' or $i=='10' or $i=='16') { $colora = 'orange'; $colorab = 'orangedark'; }
		elseif($i=='5' or $i=='11' or $i=='17') { $colora = 'violet'; $colorab = 'violetdark'; }
		else { $colora = 'red'; $colorab = 'reddark'; }
	
		$spID = $db['s'];
		$sponsor=$db['name'];
		
		$productscatsponsorID = $db['productscatID'];
		$productscata=getproductscatname($db['productscatID']);
		$productscatsmall=getproductscatsmall($db['productscatID']);
		
		$img = 'images/sponsors/'.$db['banner_small'].'';
		
		$info=htmloutput($db['info']);
		if(mb_strlen($info)>200) {
			$info=mb_substr($info, 0, 200);
			$info.='...';
		}
		
		echo '<div class="grid grid_4 ns_masonry_item '.$productscatsmall.'">
                <div class="ns_archive1 ns_bg_'.$colora.' ns_radius ns_shadow">
					<a href="index.php?site=game&s='.$db['s'].'" class="ns_zoom ns_btn_icon ns_bg_'.$colora.' ns_border_'.$colorab.' white medium ns_radius_circle ns_absolute_left"><i class="icon-link-outline"></i></a>
                    <a href="index.php?site=game&s='.$db['s'].'"><img alt=""  src="'.$img.'"></a>
                    <div class="ns_margin20">
                        <h4 class="white">'.$sponsor.'</h4>                      
                    </div>
                </div>
            </div>';
			
		$i++;
	}
}

?>