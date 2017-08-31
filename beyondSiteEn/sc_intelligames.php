<?php

$_language->read_module('sponsors');
	
$sponsors=safe_query("SELECT * FROM ".PREFIX."sponsors WHERE (displayed = '1') ORDER BY sort");
	$i=1;	
	while($db=mysql_fetch_array($sponsors)) {
				
		if($i=='1' or $i=='7' or $i=='13') { $colora = 'blue'; $colorab = 'bluedark'; }
		elseif($i=='2' or $i=='8' or $i=='14') { $colora = 'green'; $colorab = 'greendark'; }
		elseif($i=='3' or $i=='9' or $i=='15') { $colora = 'yellow'; $colorab = 'yellowdark'; }
		elseif($i=='4' or $i=='10' or $i=='16') { $colora = 'orange'; $colorab = 'orangedark'; }
		elseif($i=='5' or $i=='11' or $i=='17') { $colora = 'violet'; $colorab = 'violetdark'; }
		else { $colora = 'red'; $colorab = 'reddark'; }
	
		$sponsorID = $db['s'];
		$sponsor=$db['name'];
		
		$productscatsponsorID = $db['productscatsponsorID'];
		$productscata=getproductscatname($db['productscatsponsorID']);
		$productscatsmall=getproductscatsmall($db['productscatsponsorID']);
		
		$img = 'images/sponsors/'.$db['banner_small'].'';
		
		$star = '<span class="subtitle yellow">★</span>';
		$twostars = '<span class="subtitle yellow">★★</span>';
		$stars = '<span class="subtitle yellow">★★★</span>';
		
		$musicalint = '';
		$inhcontrol = '';
		$cogflex = '';
		$visual = '';
		$musical = '';
		$math = '';
		$working = '';
		$reflexive = '';
		$interpersonal = '';
		$creative = '';
		
		if($db['musicalint'] != '0') {
			if($db['musicalint'] == '1') {
				$musicalint = '<li><p>Musical Intelligence '.$star.'</p></li>';
			}
			elseif($db['musicalint'] == '2') {
				$musicalint = '<li><p>Musical Intelligence '.$twostars.'</p></li>';
			}
			elseif($db['musicalint'] == '3') {
				$musicalint = '<li><p>Musical Intelligence '.$stars.'</p></li>';
			}
			else $musicalint = '';
		}
		if($db['inhcontrol'] != '0') {
			if($db['inhcontrol'] == '1') {
				$inhcontrol = '<li><p>Inhibitory Control '.$star.'</p></li>';
			}
			elseif($db['inhcontrol'] == '2') {
				$inhcontrol = '<li><p>Inhibitory Control '.$twostars.'</p></li>';
			}
			elseif($db['inhcontrol'] == '3') {
				$inhcontrol = '<li><p>Inhibitory Control '.$stars.'</p></li>';
			}
			else $inhcontrol = '';
		}
		if($db['cogflex'] != '0') {
			if($db['cogflex'] == '1') {
				$cogflex = '<li><p>Cognitive Flexibility '.$star.'</p></li>';
			}
			elseif($db['cogflex'] == '2') {
				$cogflex = '<li><p>Cognitive Flexibility '.$twostars.'</p></li>';
			}
			elseif($db['cogflex'] == '3') {
				$cogflex = '<li><p>Cognitive Flexibility '.$stars.'</p></li>';
			}
			else $cogflex = '';
		}
		if($db['visual'] != '0') {
			if($db['visual'] == '1') {
				$visual = '<li><p>Visual-Spatial '.$star.'</p></li>';
			}
			elseif($db['visual'] == '2') {
				$visual = '<li><p>Visual-Spatial '.$twostars.'</p></li>';
			}
			elseif($db['visual'] == '3') {
				$visual = '<li><p>Visual-Spatial '.$stars.'</p></li>';
			}
			else $visual = '';
		}
		if($db['musical'] != '0') {
			if($db['musical'] == '1') {
				$musical = '<li><p>Musical '.$star.'</p></li>';
			}
			elseif($db['musical'] == '2') {
				$musical = '<li><p>Musical '.$twostars.'</p></li>';
			}
			elseif($db['musical'] == '3') {
				$musical = '<li><p>Musical '.$stars.'</p></li>';
			}
			else $musical = '';
		}	
		if($db['math'] != '0') {
			if($db['math'] == '1') {
				$math = '<li><p>Mathematical-Logical '.$star.'</p></li>';
			}
			elseif($db['math'] == '2') {
				$math = '<li><p>Mathematical-Logical '.$twostars.'</p></li>';
			}
			elseif($db['math'] == '3') {
				$math = '<li><p>Mathematical-Logical '.$stars.'</p></li>';
			}
			else $math = '';
		}	
		if($db['working'] != '0') {
			if($db['working'] == '1') {
				$working = '<li><p>Working Memory '.$star.'</p></li>';
			}
			elseif($db['working'] == '2') {
				$working = '<li><p>Working Memory '.$twostars.'</p></li>';
			}
			elseif($db['working'] == '3') {
				$working = '<li><p>Working Memory '.$stars.'</p></li>';
			}
			else $working = '';
		}	
		if($db['reflexive'] != '0') {
			if($db['reflexive'] == '1') {
				$reflexive = '<li><p>Reflective '.$star.'</p></li>';
			}
			elseif($db['reflexive'] == '2') {
				$reflexive = '<li><p>Reflective '.$twostars.'</p></li>';
			}
			elseif($db['reflexive'] == '3') {
				$reflexive = '<li><p>Reflective '.$stars.'</p></li>';
			}
			else $reflexive = '';
		}	
		if($db['interpersonal'] != '0') {
			if($db['interpersonal'] == '1') {
				$interpersonal = '<li><p>Interpersonal '.$star.'</p></li>';
			}
			elseif($db['interpersonal'] == '2') {
				$interpersonal = '<li><p>Interpersonal '.$twostars.'</p></li>';
			}
			elseif($db['interpersonal'] == '3') {
				$interpersonal = '<li><p>Interpersonal '.$stars.'</p></li>';
			}
			else $interpersonal = '';
		}	
		if($db['creative'] != '0') {
			if($db['creative'] == '1') {
				$creative = '<li><p>Creative '.$star.'</p></li>';
			}
			elseif($db['creative'] == '2') {
				$creative = '<li><p>Creative '.$twostars.'</p></li>';
			}
			elseif($db['creative'] == '3') {
				$creative = '<li><p>Creative '.$stars.'</p></li>';
			}
			else $creative = '';
		}
		
		$intelligences = $musicalint.$inhcontrol.$cogflex.$visual.$musical.$math.$working.$reflexive.$interpersonal.$creative;
				
		echo '<div class="grid grid_3 percentage">   
            <!--archive1-->
            <div class="ns_archive1" style="margin: 5% 5%; float: right; width: 90%; min-height: 410px;">
                <div class="ns_margin20" style="width: 90%">
					<center><img src="'.$img.'" style="width: auto; max-width: 80%" /></center>
					<div class="ns_space10"></div>
					<div style="padding: 0px 0px; height: 35px; display: table; width:100%;"><h3 class="subtitle yellow" style="display: table-cell; vertical-align: middle; text-transform: uppercase; text-align: center;">'.$sponsor.'</h3></div>
					<div class="ns_space10"></div>
					<h4 class="subtitle yellow">
					<ul style="float: left; margin: 0px 0px 0px -20px;">
						'.$intelligences.'
					</ul>
					</h4>
                </div>
            </div>
            <!--archive1-->
        </div>';
			
		$i++;
		
		unset($intelligences);
		unset($musicalint);
		unset($inhcontrol);
		unset($cogflex);
		unset($visual);
		unset($musical);
		unset($math);
		unset($working);
		unset($reflexive);
		unset($interpersonal);
		unset($creative);
	}

?>