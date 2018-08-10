<?php

$_language->read_module('index');

if(isset($sponsorID)) unset($sponsorID);
if(isset($_GET['s'])) $sponsorID = $_GET['s'];

	$result=safe_query("SELECT * FROM ".PREFIX."sponsors WHERE s='".$sponsorID."'");
	$i=1;
	if(mysql_num_rows($result)) {
	while($db=mysql_fetch_array($result)) {
		$sponsorID = $db['s'];
		$banner = $db['banner'];
		$alt = htmlspecialchars($db['name']);
		$title = htmlspecialchars($db['name']);
		if(!$db['banner']) { $img =''; $img_a = ''; }
		else { $img = 'images/sponsors/'.$db['banner']; $img_a = '<img src="'.$img.'" style="width: 100%" />'; }
		
		$imga = 'images/sponsors/'.$db['banner_small'];
		$filepath_m='downloads/manuals/';
		
		$manual = $db['manual'];
		if(!$db['manual']) $manuals = 'No file yet';
		else $manuals = '<a href="'.$filepath_m.$manual.'" target="_blank"><img src="img/pdf.png" style="float: left; margin: 5px 5px 0px 0px" /> '.$title.'</a>';
		
		$name = $db['name'];
		if(!$db['info']) $descr = 'No info yet';
		else $descr = htmloutput($db['info']);
		$url = $db['url'];
		$videocode = $db['video'];
		$videourl = getytvcode($videocode);
		if($db['video'] == '0') $video = '<div>No Video yet</div>';
		else $video = '<center><div style="clear: both"><div class="fluid-width-video-wrapper" style="padding-top: 56.25%"><iframe src="https://www.youtube.com/embed/'.$videourl.'" frameborder="0" allowfullscreen></iframe></div></div></center>';
		
		$img_str = '<img src="images/sponsors/'.$db['banner'].'" style="margin:2px 0;" border="0" alt="'.$alt.'" title="'.$title.'" />';
		
		$star = '<span class="subtitle yellow">★</span>';
		$twostars = '<span class="subtitle yellow">★★</span>';
		$stars = '<span class="subtitle yellow">★★★</span>';
		
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
		
		$intelligences = '
			'.$musicalint.'
			'.$inhcontrol.'
			'.$cogflex.'
			'.$visual.'
			'.$musical.'
			'.$math.'
			'.$working.'
			'.$reflexive.'
			'.$interpersonal.'
			'.$creative.'
		';
		
		if(is_file($img) && file_exists($img)){
			$text = $img_str;
		}
		else $text = $name;
		
	echo'
	
	<!--start section-->
<section class="ns_section">

    <!--start ns_container-->
    <div class="ns_container ns_clearfix">

        <div class="ns_space20"></div>
		
		<div class="grid grid_12">
			<h1 class="subtitle orange">'.$title.'</h1>
			<div class="ns_space20"></div>
			<div class="ns_divider left big"><span class="ns_bg_orange ns_radius"></span></div>
		</div>
		
		<!--sidebar-->
		<div class="grid grid_4">

            <div class="ns_archive1">
			    <img src="'.$imga.'" style="width: 100%" />
				<div class="ns_space20"></div>
				<h3 class="subtitle orange"><b>INTELLIGENCES:</b></h3>
				<div class="ns_space10"></div>
				<h4 class="subtitle orange">
					<ul>'.$intelligences.'</ul>
				</h4>
				<div class="ns_space20"></div>
				<a href="'.$url.'"><center><div style="clear: both; width: 80%; padding: 20px; text-align: center; text-transform: uppercase;" class="orange ns_bg_orange ns_radius"><h5 class="white">BUY NOW</h5></div></center></a>
            </div>
            <div class="ns_space20"></div>
		</div>
		<!--sidebar-->
		
		<div class="grid grid_8">
			'.$img_a.'
			<div class="ns_space30"></div>
			<h3 class="subtitle orange"><b>GAME DESCRIPTION:</b></h3>
			<div class="ns_space20"></div>
			<div style="text-align: justify">'.$descr.'</div>
			<div class="ns_space40"></div>
			<div style="clear:both"></div>
			<h3 class="subtitle orange"><b>DOWNLOAD GAME INSTRUCTIONS</b></h3>
			<div class="ns_space20"></div>
			<div style="text-align: justify">'.$manuals.'</div>
			<div class="ns_space40"></div>
			<div style="clear:both"></div>
			<h3 class="subtitle orange"><b>VIDEO</b></h3>
			<div class="ns_space20"></div>
			'.$video.'
			<div class="ns_space40"></div>
<h3 class="subtitle orange"><b>SHARE</b></h3>
<div class="ns_space20"></div>
<div class="grid grid_3 percentage">
	<a href="http://'.$hp_url.'%2Findex.php?site=game%26s='.$sponsorID.'" target="popup" onclick="window.open(\'https://www.facebook.com/sharer/sharer.php?u=http://'.$hp_url.'%2Findex.php?site=game%26s='.$sponsorID.'\',\'popup\',\'width=600,height=600\'); return false;" class="facebook"><div class="ns_bg_bluedark">
		<p class="white" style="text-align: center; padding: 10px 0px">Facebook</p>
	</div></a>
</div>
<div class="grid grid_3 percentage">
	<a href="http://'.$hp_url.'%2Findex.php?site=game%26s='.$sponsorID.'" target="popup" onclick="window.open(\'https://twitter.com/intent/tweet?original_referer=http://'.$hp_url.'%2Findex.php?site=game%26s='.$sponsorID.'&amp;ref_src=twsrc%5Etfw&amp;text=Check out this product from Beyond Tablet: '.$db['name'].'&nbsp;@&amp;tw_p=tweetbutton&amp;url=http://'.$hp_url.'%2Findex.php?site=game%26s='.$sponsorID.'\',\'popup\',\'width=600,height=600\'); return false;" class="twitter"><div class="ns_bg_blue">
		<p class="white" style="text-align: center; padding: 10px 0px">Twitter</p>
	</div></a>
</div>
<div class="grid grid_3 percentage">
	<a href="http://'.$hp_url.'%2Findex.php?site=game%26s='.$sponsorID.'" target="popup" onclick="window.open(\'https://plus.google.com/share?url=http://'.$hp_url.'%2Findex.php?site=game%26s='.$sponsorID.'\',\'popup\',\'width=600,height=600\'); return false;" class="google"><div class="ns_bg_orange">
		<p class="white" style="text-align: center; padding: 10px 0px">Google+</p>
	</div></a>
</div>
<div class="grid grid_3 percentage">
	<a href="mailto:?subject=I wanted you to see this product&amp;body=Check out this product from Beyond Tablet: '.$db['name'].' @ http://'.$hp_url.'%2Findex.php?site=game%26s='.$sponsorID.'" title="Share by Email" class="email"><div class="ns_bg_greydark">
		<p class="white" style="text-align: center; padding: 10px 0px">Email</p>
	</div></a>
</div>
<div class="ns_space40"></div>
	
		</div>

		<div class="ns_space50"></div>

    </div>
    <!--end ns_container-->
            
</section>
<!--end section-->
	
	';	
			
	}
}
		
?>
                            