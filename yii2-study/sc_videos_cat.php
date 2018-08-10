<?php 

$ergebnis=safe_query("SELECT * FROM ".PREFIX."movie_categories ORDER BY movcatname");
	
	$i=1;
	while($ds=mysql_fetch_array($ergebnis)) {
		
		$movcatID=$ds[movcatID];
		$movcatheadline=$ds[movcatname];
		$movcatimg=$ds[movcatimg];
		
		$videocount = mysql_num_rows(safe_query("SELECT movID FROM ".PREFIX."movies WHERE movcatID='".$movcatID."'"));
		
		if($videocount!=0) {
		
//echo '<li class="ns_marginleft20"><a class="white" href="index.php?site=videos&action=category&movcatID='.$movcatID.'">'.$movcatheadline.'</a></li><br \>';				  
echo '<li class="ns_marginleft20"><a class="white" href="index.php?site=videos&action=category&movcatID='.$movcatID.'">'.$movcatheadline.'</a></li><br \>';				  
				 $i++;
			}
		else {
			echo '';
		}
			  
	}
	
?>