<?php

if(isset($_GET['action'])) $action = $_GET['action'];
else $action='';

function stripBBCode($text_to_search) {
 $pattern = '|[[\\/\\!]*?[^\\[\\]]*?]|si';
 $replace = '';
 return preg_replace($pattern, $replace, $text_to_search);
}

if($action == "quicksearch" OR ((isset($_GET['news']) OR isset($_GET['videos'])) AND $action=="")) {

	$getstring='';
	foreach($_GET as $key=>$val) $getstring .= '&'.$key.'='.stripslashes($val);
	header("Location: index.php?site=search&action=search".$getstring);

}
elseif($action=="search") {

	
	$_language->read_module('search');

		$text = str_replace(array('%', '*'), array('\%', '%'), $_GET['text']);
		if(!isset($_GET['r']) or $_GET['r'] < 1 or $_GET['r'] > 100) {
			$results = 50;
		}
		else {
			$results = (int)$_GET['r'];
		}
		isset($_GET['page']) ? $page = (int)$_GET['page'] : $page = 1;
		isset($_GET['am']) ? $am = (int)$_GET['am'] : $am = 0;
		isset($_GET['ad']) ? $ad = (int)$_GET['ad'] : $ad = 0;
		isset($_GET['ay']) ? $ay = (int)$_GET['ay'] : $ay = 0;
		isset($_GET['bm']) ? $bm = (int)$_GET['bm'] : $bm = 0;
		isset($_GET['bd']) ? $bd = (int)$_GET['bd'] : $bd = 0;
		isset($_GET['by']) ? $by = (int)$_GET['by'] : $by = 0;
		
		if(mb_strlen(str_replace('%', '', $text))>=$search_min_len){

			if(!($am and $ad and $ay)) {
				$after = 0;
			}
			else {
				if(!$ad) $ad = 1;
				if(!$am) $am = 1;
				if(!$ay) $by = date("Y");
				$after = mktime(0, 0, 0, $am, $ad, $ay);
			}
			if(!($bm and $bd and $by)) {
				$before = time();
			}
			else {
				if(!$bd) $bd = 1;
				if(!$bm) $bm = 1;
				if(!$by) $by = date("Y");
				$before = mktime(0, 0, 0, $bm, $bd, $by);
			}
		
			$i=0;
			$res_message=array();
			$res_title=array();
			$res_link=array();
			$res_type=array();
			$res_date=array();
			$res_occurr=array();
		
               if(isset($_GET['videos'])) {
                    $ergebnis_videos = safe_query("SELECT * FROM ".PREFIX."movies WHERE (date between ".$after." AND ".$before.") AND (movheadline LIKE '%".$text."%' or movdescription LIKE '%".$text."%')");
                    while($ds = mysql_fetch_array($ergebnis_videos)) {
                         

                              $movID = $ds['movID'];
                              $movcatID = $ds['movcatID'];
          
                              $res_title[$i]          =     $ds['movheadline'];
                              $res_message[$i]     =     $ds['movdescription'];
                              $res_link[$i]          =     'videos/show/'.$movID.'';
                              $res_occurr[$i]          =     substr_count(strtolower($ds['movdescription']), strtolower(stripslashes($text)));
                              $res_date[$i]          =     $ds['date'];
                              $res_type[$i]          =     'Videos';
          
                              $i++;
                    }
          
               }
			
			if(isset($_GET['news'])) {
				$ergebnis_news=safe_query("SELECT 
												date,
												poster,
												newsID
										   FROM
										   		".PREFIX."news
										   WHERE
													published = '1'
												AND
													intern <= '".isclanmember($userID)."'
												AND
												(
													date between ".$after." AND ".$before."
												)");
		
				while($ds = mysql_fetch_array($ergebnis_news)) {
					$ergebnis_news_contents = safe_query("SELECT language, headline, content FROM ".PREFIX."news_contents WHERE newsID = '".$ds['newsID']."' and (content LIKE '%".$text."%' or headline LIKE '%".$text."%')");
					if(mysql_num_rows($ergebnis_news_contents)) {
						$message_array = array();
						while($qs = mysql_fetch_array($ergebnis_news_contents)) {
							$message_array[] = array('lang' => $qs['language'], 'headline' => $qs['headline'], 'message' => $qs['content']);
						}
						$showlang = select_language($message_array);
		
						$newsID = $ds['newsID'];
		
						$res_title[$i]		=	$message_array[$showlang]['headline'];
						$res_message[$i]	=	$message_array[$showlang]['message'];
						$res_link[$i]		=	'article/'.$newsID.'';
						$res_occurr[$i]		=	substri_count_array($message_array, stripslashes($text));
						$res_date[$i]		=	$ds['date'];
						$res_type[$i]		=	$_language->module['news'];
		
						$i++;
					}
				}
		
			}
			$count_results = $i;
		
			
			eval("\$title_search = \"".gettemplate("title_search")."\";");
			echo $title_search;
		
			$pages = ceil($count_results / $results);
			if($pages > 1) echo makepagelink("index.php?site=search&amp;action=search&amp;videos=".$_GET['videos']."&amp;news=".$_GET['news']."&amp;r=".$_GET['r']."&amp;text=".$_GET['text']."&amp;am=".$_GET['am']."&amp;ad=".$_GET['ad']."&amp;ay=".$_GET['ay']."&amp;bm=".$_GET['bm']."&amp;bd=".$_GET['bd']."&amp;by=".$_GET['by']."&amp;order=".$_GET['order'], $page, $pages);

			// sort results
			if($_GET['order']=='2') asort($res_occurr);
			else arsort($res_occurr);
		
			$i=0;
			foreach($res_occurr as $key => $val) {
				if($page > 1 and $i < ($results * ($page - 1))) {
					$i++;
					continue;
				}
				if($i >= ($results * $page)) {
					break;
				}
					
				$date=date("d.m.Y", $res_date[$key]);
				$type=$res_type[$key];
				if(mb_strlen($res_message[$key]) > 200) {
					for($z = 0; $z < mb_strlen($res_message[$key]); $z++) {
						$tmp = mb_substr($res_message[$key], $z, 1);
						if($z >= 200 && $tmp == " ") {
							$res_message[$key] = mb_substr($res_message[$key], 0, $z)."...";
							break;
						}
					}
				}
				$auszug=str_ireplace(stripslashes($text), '<b>'.stripslashes($text).'</b>', $res_message[$key]);
				$aaa = stripBBCode($auszug);
				
				if(mb_strlen($res_title[$key])>250) {
					$title=mb_substr($res_title[$key], 0, 250);
					$title.='..';
				}
				else $title=$res_title[$key];
				$link=$res_link[$key];
				$frequency = $res_occurr[$key];
		

        $hr = '<div style="width: 100%; margin: 25px 0px; border-bottom: 1px solid #ddd"></div>';


				eval ("\$search_result = \"".gettemplate("search_result")."\";");
				echo $search_result;
		
				$i++;
		
			} 
		}
		else echo str_replace("%min_chars%", $search_min_len,$_language->module['too_short']);

}
else {
	if(!isset($_GET['site'])){
		header("Location: index.php?site=search");
	}
	$_language->read_module('search');
	
	if(isset($_REQUEST['text'])) $text = getinput($_REQUEST['text']);
	else $text='';
	
	if($userID) {
		eval ("\$search_form = \"".gettemplate("search_form_loggedin")."\";");
		echo $search_form;
	} else {
		$CAPCLASS = new Captcha;
		$captcha = $CAPCLASS->create_captcha();
		$hash = $CAPCLASS->get_hash();
		$CAPCLASS->clear_oldcaptcha();
		eval ("\$search_form = \"".gettemplate("search_form_notloggedin")."\";");
		echo $search_form;
	}
}
echo '</div>';
?>