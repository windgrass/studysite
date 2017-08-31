<?php

$ergebnis=safe_query("SELECT * FROM ".PREFIX."products_cat ORDER BY productscatID");
if(mysql_num_rows($ergebnis)) {
	$n=1;
	while($db=mysql_fetch_array($ergebnis)) {
		$n++;
		$productscatID=$db['productscatID'];
		$cat=$db['category'];
		$cat_small=$db['cat_small'];
		
		echo '<div class="ns_margin10">
                <a data-filter=".'.$cat_small.'" class="ns_bg_grey2_hover ns_transition ns_btn ns_bg_grey small ns_shadow ns_radius grey">'.$cat.'</a>
            </div>';
		
	}
}
?>