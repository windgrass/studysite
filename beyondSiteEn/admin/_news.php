<?php

if(isset($_GET['action'])) $action = $_GET['action'];
else $action='';
if(isset($_REQUEST['quickactiontype'])) $quickactiontype = $_REQUEST['quickactiontype'];
else $quickactiontype='';

if($action=="new") {
	include("_mysql.php");
	include("_settings.php");
	include("_functions.php");
	$_language->read_module('news');
	$_language->read_module('bbcode', true);
	if(!isclanmember($userID)) die($_language->module['no_access']);

	safe_query("INSERT INTO ".PREFIX."news (date, poster, saved) VALUES ('".time()."', '".$userID."', '0')");
	$newsID=mysql_insert_id();

$gamesa=safe_query("SELECT * FROM ".PREFIX."games ORDER BY name");
		while($ds=mysql_fetch_array($gamesa)) {
			$games.='<option value="'.$ds['tag'].'">'.$ds['name'].'</option>';
		}

	$rubrics='';
	$newsrubrics=safe_query("SELECT rubricID, rubric FROM ".PREFIX."news_rubrics ORDER BY rubric");
	while($dr=mysql_fetch_array($newsrubrics)) {
		$rubrics.='<option value="'.$dr['rubricID'].'">'.$dr['rubric'].'</option>';
	}

	$count_langs = 0;
	$lang=safe_query("SELECT lang, language FROM ".PREFIX."news_languages ORDER BY language");
	$langs='';
	while($dl=mysql_fetch_array($lang)) {
		$langs.="news_languages[".$count_langs."] = new Array();\nnews_languages[".$count_langs."][0] = '".$dl['lang']."';\nnews_languages[".$count_langs."][1] = '".$dl['language']."';\n";
		$count_langs++;
	}

	$intro_vars='';
	$message_vars='';
	$headline_vars='';
	$langs_vars='';
	$langcount=1;

	$url1="http://";
	$url2="http://";
	$url3="http://";
	$url4="http://";
	$link1='';
	$link2='';
	$link3='';
	$link4='';
	$window1_new = 'checked="checked"';
	$window1_self = '';
	$window2_new = 'checked="checked"';
	$window2_self = '';
	$window3_new = 'checked="checked"';
	$window3_self = '';
	$window4_new = 'checked="checked"';
	$window4_self = '';
	$intern = '<option value="0" selected="selected">'.$_language->module['no'].'</option><option value="1">'.$_language->module['yes'].'</option>';
	$topnews = '<option value="0" selected="selected">'.$_language->module['no'].'</option><option value="1">'.$_language->module['yes'].'</option>';
	$sc_banner = '<option value="0" selected="selected">'.$_language->module['no'].'</option><option value="1">'.$_language->module['yes'].'</option>';

	$bg1=BG_1;

	$selects='';
	for($i = 1; $i <= $count_langs; $i++) {
		$selects .= '<option value="'.$i.'">'.$i.'</option>';
	}

	$postform = '';
	$comments='<option value="0">'.$_language->module['no_comments'].'</option><option value="1" selected="selected">'.$_language->module['user_comments'].'</option>';
	
	eval ("\$addbbcode = \"".gettemplate("addbbcode")."\";");
	eval ("\$addflags = \"".gettemplate("flags")."\";");

if(isnewsadmin($userID)) {
	eval ("\$news_post = \"".gettemplate("news_post")."\";");
	echo $news_post;
	}
else {
	eval ("\$blog_post = \"".gettemplate("blog_post")."\";");
	echo $blog_post;
}
}
elseif($action=="save") {
	include("_mysql.php");
	include("_settings.php");
	include("_functions.php");
	$_language->read_module('news');
	$newsID = $_POST['newsID'];
	
	//newsbanner///
	$banner = $_FILES['banner'];
	$banner2 = $_FILES['banner2'];
	$id=$newsID;

		$filepath = "images/news_pics/";
	if ($banner['name'] != "") {
        move_uploaded_file($banner['tmp_name'], $filepath.$banner['name']);
		@chmod($filepath.$banner['name'], 0755);
		$file_ext=strtolower(substr($banner['name'], strrpos($banner['name'], ".")));
		$file=$id.$file_ext;
		if(file_exists($filepath.$file)) @unlink($filepath.$file);
		rename($filepath.$banner['name'], $filepath.$file);
		safe_query("UPDATE ".PREFIX."news SET banner='$file' WHERE newsID = '".$newsID."'");

	}
	
		$filepath = "images/news_pics/klein/";
	if ($banner2['name'] != "") {
        move_uploaded_file($banner2['tmp_name'], $filepath.$banner2['name']);
		@chmod($filepath.$banner2['name'], 0755);
		$file_ext=strtolower(substr($banner2['name'], strrpos($banner2['name'], ".")));
		$file=$id.$file_ext;
		if(file_exists($filepath.$file)) @unlink($filepath.$file);
		rename($filepath.$banner2['name'], $filepath.$file);
		safe_query("UPDATE ".PREFIX."news SET banner2='$file' WHERE newsID = '".$newsID."'");
		}
	//newsbannerende///

	$ds=mysql_fetch_array(safe_query("SELECT poster FROM ".PREFIX."news WHERE newsID = '".$newsID."'"));
	if(($ds['poster'] != $userID or !isnewswriter($userID)) AND !isclanmember($userID) and !isnewsadmin($userID)) {
		die($_language->module['no_access']);
	}

	$save = isset($_POST['save']);
	$preview = isset($_POST['preview']);

	if(isset($_POST['rubric'])) $rubric = $_POST['rubric'];
	else $rubric = 0;

        if(isset($_POST['game'])) $game = $_POST['game'];
	else $game = '';

        if(isset($_POST['league'])) $league = $_POST['league'];
	else $league = '';

        $intro = $_POST['intro'];
	$intro = str_replace('\r\n', "\n", $intro);
	$lang = $_POST['lang'];
	$headline = $_POST['headline'];

	$message = $_POST['message'];
	$message = str_replace('\r\n', "\n", $message);

	$link1 = strip_tags($_POST['link1']);
	$url1 = strip_tags($_POST['url1']);
	$window1 = $_POST['window1'];

	$link2 = strip_tags($_POST['link2']);
	$url2 = strip_tags($_POST['url2']);
	$window2 = $_POST['window2'];

	$link3 = strip_tags($_POST['link3']);
	$url3 = strip_tags($_POST['url3']);
	$window3 = $_POST['window3'];

	$link4 = strip_tags($_POST['link4']);
	$url4 = strip_tags($_POST['url4']);
	$window4 = $_POST['window4'];

	$intern = $_POST['intern'];
	$topnews = $_POST['topnews'];
	$sc_banner = $_POST['sc_banner'];
	$comments = $_POST['comments'];

	safe_query("UPDATE ".PREFIX."news SET rubric='".$rubric."',
					  game='".$game."',
					  league='".$league."',
                      link1='".$link1."',
                      url1='".$url1."',
                      window1='".$window1."',
                      link2='".$link2."',
                      url2='".$url2."',
                      window2='".$window2."',
                      link3='".$link3."',
                      url3='".$url3."',
                      window3='".$window3."',
                      link4='".$link4."',
                      url4='".$url4."',
                      window4='".$window4."',
                      saved='1',
                      intern='".$intern."',
					  topnews='".$topnews."',
					  sc_banner='".$sc_banner."',
                      comments='".$comments."' WHERE newsID='".$newsID."'");

	$update_langs = array();
	$query = safe_query("SELECT language FROM ".PREFIX."news_contents WHERE newsID = '".$newsID."'");
	while($qs = mysql_fetch_array($query)) {
		$update_langs[] = $qs['language'];
		if(in_array($qs['language'], $lang)) {
			$update_langs[] = $qs['language'];
		}
		else {
			safe_query("DELETE FROM ".PREFIX."news_contents WHERE newsID = '".$newsID."' and language = '".$qs['language']."'");
		}
	}

	for($i = 0; $i < count($message); $i++) {
		if(in_array($lang[$i], $update_langs)) {
			safe_query("UPDATE ".PREFIX."news_contents SET headline = '".$headline[$i]."', intro = '".$intro[$i]."', content = '".$message[$i]."' WHERE newsID = '".$newsID."' and language = '".$lang[$i]."'");
			unset($update_langs[$lang[$i]]);
		}
		else {
			safe_query("INSERT INTO ".PREFIX."news_contents (newsID, language, headline, intro, content) VALUES ('".$newsID."', '".$lang[$i]."', '".$headline[$i]."', '".$intro[$i]."', '".$message[$i]."')");
		}
	}

	// delete the entries that are older than 2 hour and contain no text
	safe_query("DELETE FROM `".PREFIX."news` WHERE `saved` = '0' and ".time()." - `date` > ".(2 * 60 * 60));

  generate_rss2();
	if($save) echo'<body onload="window.close()"></body>';
	if($preview) header("Location: _news.php?action=preview&newsID=".$newsID);
	if($languagecount) header("Location: _news.php?action=edit&newsID=".$newsID);

}
elseif($action=="preview") {
	include("_mysql.php");
	include("_settings.php");
	include("_functions.php");
	$_language->read_module('news');

	$newsID = $_GET['newsID'];

	$result=safe_query("SELECT * FROM ".PREFIX."news WHERE newsID='$newsID'");
	$ds=mysql_fetch_array($result);

	if(($ds['poster'] != $userID or !isnewswriter($userID)) and !isnewsadmin($userID)) {
		die($_language->module['no_access']);
	}

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- Head & Title include -->
	<title>'.PAGETITLE.'; ?></title>
	<link href="_stylesheet.css" rel="stylesheet" type="text/css" />
	<script src="js/bbcode.js" language="jscript" type="text/javascript"></script>
<!-- end Head & Title include -->
</head>
<body>';

	$bg1=BG_1;

	eval ("\$title_news = \"".gettemplate("title_news")."\";");
	echo $title_news;

	$bgcolor=BG_1;
	$date = date("d.m.Y", $ds['date']);
	$time = date("H:i", $ds['date']);
	$rubrikname=getrubricname($ds['rubric']);
	$rubrikname_link = getinput(getrubricname($ds['rubric']));
	$rubricpic='<img src="images/news-rubrics/'.getrubricpic($ds['rubric']).'" alt="" />';
	if(!file_exists($rubricpic)) $rubricpic = '';

	$adminaction='';

	$message_array = array();
	$query=safe_query("SELECT * FROM ".PREFIX."news_contents WHERE newsID='".$newsID."'");
	while($qs = mysql_fetch_array($query)) {
		$message_array[] = array('lang' => $qs['language'], 'headline' => $qs['headline'], 'message' => $qs['content']);
	}
	$showlang = select_language($message_array);

	$langs='';
	$i=0;
	foreach($message_array as $val) {
		if($showlang!=$i)	$langs.='<a href="index.php?site=article&amp;newsID='.$ds['newsID'].'&amp;lang='.$val['lang'].'">[flag]'.$val['lang'].'[/flag]</a>';
		$i++;
	}
	$langs = flags($langs);

	$headline=$message_array[$showlang]['headline'];
	$content=$message_array[$showlang]['message'];
	
	if($ds['intern'] == 1) $isintern = '('.$_language->module['intern'].')';
    else $isintern = '';
	
	if($ds['topnews'] == 1) $istopnews = '('.$_language->module['topnews'].')';
    else $istopnews = '';
	
	if($ds['sc_banner'] == 1) $issc_banner = '(Add Partner Banner?)';
    else $issc_banner = '';
    
	$content = htmloutput($content);
	$content = toggle($content, $ds['newsID']);
	$poster='<a href="index.php?site=profile&amp;id='.$ds['poster'].'"><b>'.getnickname($ds['poster']).'</b></a>';
	$related='';
	$comments="";
	if($ds['link1'] && $ds['url1']!="http://" && $ds['window1']) $related.='&#8226; <a href="'.$ds['url1'].'" target="_blank">'.$ds['link1'].'</a> ';
	if($ds['link1'] && $ds['url1']!="http://" && !$ds['window1']) $related.='&#8226; <a href="'.$ds['url1'].'">'.$ds['link1'].'</a> ';

	if($ds['link2'] && $ds['url2']!="http://" && $ds['window2']) $related.='&#8226; <a href="'.$ds['url2'].'" target="_blank">'.$ds['link2'].'</a> ';
	if($ds['link2'] && $ds['url2']!="http://" && !$ds['window2']) $related.='&#8226; <a href="'.$ds['url2'].'">'.$ds['link2'].'</a> ';

	if($ds['link3'] && $ds['url3']!="http://" && $ds['window3']) $related.='&#8226; <a href="'.$ds['url3'].'" target="_blank">'.$ds['link3'].'</a> ';
	if($ds['link3'] && $ds['url3']!="http://" && !$ds['window3']) $related.='&#8226; <a href="'.$ds['url3'].'">'.$ds['link3'].'</a> ';

	if($ds['link4'] && $ds['url4']!="http://" && $ds['window4']) $related.='&#8226; <a href="'.$ds['url4'].'" target="_blank">'.$ds['link4'].'</a> ';
	if($ds['link4'] && $ds['url4']!="http://" && !$ds['window4']) $related.='&#8226; <a href="'.$ds['url4'].'">'.$ds['link4'].'</a> ';

	eval ("\$news = \"".gettemplate("news")."\";");
	echo $news;

	echo'<hr />
  <input type="button" onclick="MM_goToURL(\'parent\',\'_news.php?action=edit&amp;newsID='.$newsID.'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" />
  <input type="button" onclick="javascript:self.close()" value="'.$_language->module['save_news'].'" />
  <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'_news.php?action=delete&amp;id='.$newsID.'&amp;close=true\')" value="'.$_language->module['delete'].'" /></body></html>';
}
elseif($quickactiontype=="publish") {
	include("_mysql.php");
	include("_settings.php");
	include("_functions.php");
	$_language->read_module('news');
	if(!isnewsadmin($userID)) die($_language->module['no_access']);

	if(isset($_POST['newsID'])){
		$newsID = $_POST['newsID'];
		if(is_array($newsID)) {
			foreach($newsID as $id) {
				safe_query("UPDATE ".PREFIX."news SET published='1' WHERE newsID='".(int)$id."'");
			}
		} else safe_query("UPDATE ".PREFIX."news SET published='1' WHERE newsID='".(int)$newsID."'");
		generate_rss2();
		header("Location: admin/admincenter.php?site=news");
	}
	else{
		header("Location: admin/admincenter.php?site=news&action=unpublished");
	}
}
elseif($quickactiontype=="unpublish") {
	include("_mysql.php");
	include("_settings.php");
	include("_functions.php");
	$_language->read_module('news');
	if(!isnewsadmin($userID)) die($_language->module['no_access']);
	
	if(isset($_REQUEST['newsID'])){
		$newsID = $_REQUEST['newsID'];
		if(is_array($newsID)) {
			foreach($newsID as $id) {
				safe_query("UPDATE ".PREFIX."news SET published='0' WHERE newsID='".(int)$id."'");
			}
		}	
		else safe_query("UPDATE ".PREFIX."news SET published='0' WHERE newsID='".(int)$newsID."'");	
		generate_rss2();
	}
	header("Location: admin/admincenter.php?site=news");
}
elseif($quickactiontype=="delete") {
	include("_mysql.php");
	include("_settings.php");
	include("_functions.php");
	$_language->read_module('news');
  if(isset($_POST['newsID'])){
  	$newsID = $_POST['newsID'];
	
	$filepath = "images/news_pics/";
	if(file_exists($filepath.$$newsID.'.jpg')) @unlink($filepath.$templateID.'.jpg');
	if(file_exists($filepath.$$newsID.'.gif')) @unlink($filepath.$templateID.'.gif');
	if(file_exists($filepath.$$newsID.'.png')) @unlink($filepath.$templateID.'.png');
	
	$filepath = "images/news_pics-klein/";
	if(file_exists($filepath.$$newsID.'.jpg')) @unlink($filepath.$templateID.'.jpg');
	if(file_exists($filepath.$$newsID.'.gif')) @unlink($filepath.$templateID.'.gif');
	if(file_exists($filepath.$$newsID.'.png')) @unlink($filepath.$templateID.'.png');
	
		foreach($newsID as $id) {
			$ds=mysql_fetch_array(safe_query("SELECT screens, poster FROM ".PREFIX."news WHERE newsID='".$id."'"));
			if(($ds['poster'] != $userID or !isnewswriter($userID)) and !isnewsadmin($userID)) {
				die($_language->module['no_access']);
			}
			if($ds['screens']) {
				$screens=explode("|", $ds['screens']);
				if(is_array($screens)) {
					$filepath = "./images/news-pics/";
					foreach($screens as $screen) {
						if(file_exists($filepath.$screen)) @unlink($filepath.$screen);
					}
				}
			}
			safe_query("DELETE FROM ".PREFIX."news WHERE newsID='".$id."'");
			safe_query("DELETE FROM ".PREFIX."news_contents WHERE newsID='".$id."'");
			safe_query("DELETE FROM ".PREFIX."comments WHERE parentID='".$id."' AND type='ne'");
		}
		generate_rss2();
		header("Location: admin/admincenter.php?site=news");
  }
  else{
  	generate_rss2();
  	header("Location: admin/admincenter.php?site=news");
  }
}
elseif($action=="delete") {
	include("_mysql.php");
	include("_settings.php");
	include("_functions.php");
	$_language->read_module('news');

	$id = $_GET['id'];
	
	$filepath = "images/news_pics/";
	if(file_exists($filepath.$$newsID.'.jpg')) @unlink($filepath.$templateID.'.jpg');
	if(file_exists($filepath.$$newsID.'.gif')) @unlink($filepath.$templateID.'.gif');
	if(file_exists($filepath.$$newsID.'.png')) @unlink($filepath.$templateID.'.png');
	
	$filepath = "images/news_pics/klein/";
	if(file_exists($filepath.$$newsID.'.jpg')) @unlink($filepath.$templateID.'.jpg');
	if(file_exists($filepath.$$newsID.'.gif')) @unlink($filepath.$templateID.'.gif');
	if(file_exists($filepath.$$newsID.'.png')) @unlink($filepath.$templateID.'.png');

	$ds=mysql_fetch_array(safe_query("SELECT screens, poster FROM ".PREFIX."news WHERE newsID='".$id."'"));
	if(($ds['poster'] != $userID or !isnewswriter($userID)) and !isnewsadmin($userID)) {
		die($_language->module['no_access']);
	}
	if($ds['screens']) {
		$screens=explode("|", $ds['screens']);
		if(is_array($screens)) {
			$filepath = "./images/news-pics/";
			foreach($screens as $screen) {
				if(file_exists($filepath.$screen)) @unlink($filepath.$screen);
			}
		}
	}

	safe_query("DELETE FROM ".PREFIX."news WHERE newsID='".$id."'");
	safe_query("DELETE FROM ".PREFIX."news_contents WHERE newsID='".$id."'");
	safe_query("DELETE FROM ".PREFIX."comments WHERE parentID='".$id."' AND type='ne'");
  
	generate_rss2();
	if(isset($_GET['close'])) echo'<body onload="window.close()"></body>';
	else header("Location: admin/admincenter.php?site=news");
}
elseif($action=="edit") {
	include("_mysql.php");
	include("_settings.php");
	include("_functions.php");
	$_language->read_module('news');

	$newsID = $_GET['newsID'];

	$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."news WHERE newsID='".$newsID."'"));
	if(($ds['poster'] != $userID or !isnewswriter($userID)) and !isnewsadmin($userID)) {
		die($_language->module['no_access']);
	}

	$_language->read_module('bbcode', true);


	$message_array = array();
	$query=safe_query("SELECT * FROM ".PREFIX."news_contents WHERE newsID='".$newsID."'");
	while($qs = mysql_fetch_array($query)) {
		$message_array[] = array('lang' => $qs['language'], 'headline' => $qs['headline'], 'intro' => $qs['intro'], 'message' => $qs['content']);
	}

	$count_langs = 0;
	$lang=safe_query("SELECT lang, language FROM ".PREFIX."news_languages ORDER BY language");
	$langs='';
	while($dl=mysql_fetch_array($lang)) {
		$langs.="news_languages[".$count_langs."] = new Array();\nnews_languages[".$count_langs."][0] = '".$dl['lang']."';\nnews_languages[".$count_langs."][1] = '".$dl['language']."';\n";
		$count_langs++;
	}

	$intro_vars='';
	$message_vars='';
	$headline_vars='';
	$langs_vars='';
	$i=0;
	foreach($message_array as $val) {
		$intro_vars .= "intro[".$i."] = '".js_replace($val['intro'])."';\n";
		$message_vars .= "message[".$i."] = '".js_replace($val['message'])."';\n";
		$headline_vars .= "headline[".$i."] = '".js_replace(htmlspecialchars($val['headline']))."';\n";
		$langs_vars .= "langs[".$i."] = '".$val['lang']."';\n";
		$i++;
	}
	$langcount = $i;

$gamesa=safe_query("SELECT * FROM ".PREFIX."games ORDER BY name");
		while($dr=mysql_fetch_array($gamesa)) {
			if($ds['game']==$dr['tag']) $games.='<option value="'.$dr['tag'].'" selected="selected">'.$dr['name'].'</option>';
			else $games.='<option value="'.$dr['tag'].'">'.$dr['name'].'</option>';
		}

	$newsrubrics=safe_query("SELECT * FROM ".PREFIX."news_rubrics ORDER BY rubric");
	$rubrics='';
	while($dr=mysql_fetch_array($newsrubrics)) {
		if($ds['rubric']==$dr['rubricID']) $rubrics.='<option value="'.$dr['rubricID'].'" selected="selected">'.getinput($dr['rubric']).'</option>';
		else $rubrics.='<option value="'.$dr['rubricID'].'">'.getinput($dr['rubric']).'</option>';
	}

	if($ds['intern']) $intern = '<option value="0">'.$_language->module['no'].'</option><option value="1" selected="selected">'.$_language->module['yes'].'</option>';
	else $intern = '<option value="0" selected="selected">'.$_language->module['no'].'</option><option value="1">'.$_language->module['yes'].'</option>';
	if($ds['topnews']) $topnews = '<option value="0">'.$_language->module['no'].'</option><option value="1" selected="selected">'.$_language->module['yes'].'</option>';
	else $topnews = '<option value="0" selected="selected">'.$_language->module['no'].'</option><option value="1">'.$_language->module['yes'].'</option>';
	if($ds['sc_banner']) $sc_banner = '<option value="0">'.$_language->module['no'].'</option><option value="1" selected="selected">'.$_language->module['yes'].'</option>';
	else $sc_banner = '<option value="0" selected="selected">'.$_language->module['no'].'</option><option value="1">'.$_language->module['yes'].'</option>';

	$selects='';
	for($i = 1; $i <= $count_langs; $i++) {
		if($i == $langcount) $selects .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
		else $selects .= '<option value="'.$i.'">'.$i.'</option>';
	}

	$link1=getinput($ds['link1']);
	$link2=getinput($ds['link2']);
	$link3=getinput($ds['link3']);
	$link4=getinput($ds['link4']);

	$url1="http://";
	$url2="http://";
	$url3="http://";
	$url4="http://";

	if($ds['url1']!="http://") $url1=$ds['url1'];
	if($ds['url2']!="http://") $url2=$ds['url2'];
	if($ds['url3']!="http://") $url3=$ds['url3'];
	if($ds['url4']!="http://") $url4=$ds['url4'];

	if($ds['window1']){
		$window1_new = 'checked="checked"';
		$window1_self = '';
	}
	else{
		$window1_new = '';
		$window1_self = 'checked="checked"';
	}
	if($ds['window2']){
		$window2_new = 'checked="checked"';
		$window2_self = '';
	}
	else{
		$window2_new = '';
		$window2_self = 'checked="checked"';
	}
	if($ds['window3']){
		$window3_new = 'checked="checked"';
		$window3_self = '';
	}
	else{
		$window3_new = '';
		$window3_self = 'checked="checked"';
	}
	if($ds['window4']){
		$window4_new = 'checked="checked"';
		$window4_self = '';
	}
	else{
		$window4_new = '';
		$window4_self = 'checked="checked"';
	}

	$comments='<option value="0">'.$_language->module['no_comments'].'</option><option value="1">'.$_language->module['user_comments'].'</option>';
	$comments=str_replace('value="'.$ds['comments'].'"', 'value="'.$ds['comments'].'" selected="selected"', $comments);

        $leagues=str_replace('value="at" selected="selected"', 'value="at"', $leagues);
        $leagues=str_replace('value="'.$ds['league'].'"', 'value="'.$ds['league'].'" selected="selected"', $leagues);

	$bg1=BG_1;

	eval ("\$addbbcode = \"".gettemplate("addbbcode")."\";");
	eval ("\$addflags = \"".gettemplate("flags")."\";");

	eval ("\$news_post = \"".gettemplate("news_post")."\";");
	echo $news_post;
}
elseif(basename($_SERVER['PHP_SELF'])=="_news.php"){
	generate_rss2();
	header("Location: admin/admincenter.php?site=news");
}
elseif($action=="unpublished") {
	$_language->read_module('news');
	
  eval ("\$title_news = \"".gettemplate("title_news")."\";");
	echo $title_news;

	if(isnewsadmin($userID)) $post='<input type="button" onclick="MM_openBrWindow(\'_news.php?action=new\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');" value="'.$_language->module['post_news'].'" />';

	echo $post.' <input type="button" onclick="MM_goToURL(\'parent\',\'index.php?site=_news\');return document.MM_returnValue;" value="'.$_language->module['show_news'].'" /><hr />';

	$page='';

	// Not published News
	if(isnewsadmin($userID)) {
		$ergebnis=safe_query("SELECT * FROM ".PREFIX."news WHERE published='0' AND saved='1' ORDER BY date ASC");
		if(mysql_num_rows($ergebnis)) {
			echo $_language->module['title_unpublished_news'];

			echo '<form method="post" name="form" action="_news.php">';
			eval ("\$news_unpublished_head = \"".gettemplate("news_unpublished_head")."\";");
			echo $news_unpublished_head;

			$i=1;
			while($ds=mysql_fetch_array($ergebnis)) {
				if($i%2) {
					$bg1=BG_1;
					$bg2=BG_2;
				}
				else {
					$bg1=BG_3;
					$bg2=BG_4;
				}

				$date=date("d.m.Y", $ds['date']);
				$rubric=getrubricname($ds['rubric']);
				if(!isset($rubric)) $rubric='';
				$comms = getanzcomments($ds['newsID'], 'ne');
				$message_array = array();
				$query=safe_query("SELECT * FROM ".PREFIX."news_contents WHERE newsID='".$ds['newsID']."'");
				while($qs = mysql_fetch_array($query)) {
					$message_array[] = array('lang' => $qs['language'], 'headline' => $qs['headline'], 'message' => $qs['content']);
				}

				$headlines='';
				
				foreach($message_array as $val) {
					$headlines.='<a href="index.php?site=article&amp;newsID='.$ds['newsID'].'&amp;lang='.$val['lang'].'">'.flags('[flag]'.$val['lang'].'[/flag]').' '.clearfromtags($val['headline']).'</a><br />';
				}

				$poster='<a href="index.php?site=profile&amp;id='.$ds['poster'].'">'.getnickname($ds['poster']).'</a>';

				$multiple='';
				$admdel='';
				if(isnewsadmin($userID)) {
					$multiple='<input class="input" type="checkbox" name="newsID[]" value="'.$ds['newsID'].'" />';
					$admdel='<table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td><input class="input" type="checkbox" name="ALL" value="ALL" onclick="SelectAll(this.form);" /> '.$_language->module['select_all'].'</td>
              <td align="right"><select name="quickactiontype">
                <option value="publish">'.$_language->module['publish_selected'].'</option>
                <option value="delete">'.$_language->module['delete_selected'].'</option>
              </select>
              <input type="submit" name="quickaction" value="'.$_language->module['go'].'" /></td>
            </tr>
          </table>
          </form>';

				}
				eval ("\$news_archive_content = \"".gettemplate("news_archive_content")."\";");
				echo $news_archive_content;
				$i++;
			}
			eval ("\$news_archive_foot = \"".gettemplate("news_archive_foot")."\";");
			echo $news_archive_foot;

			unset($ds);
		}
	}
}
elseif($action=="archive") {

	$_language->read_module('news');
  
	eval ("\$title_news = \"".gettemplate("title_news")."\";");
	echo $title_news;

	if(isset($_GET['page'])) $page=(int)$_GET['page'];
	else $page = 1;
	$sort="date";
	if(isset($_GET['sort'])){
	  if(($_GET['sort']=='date') || ($_GET['sort']=='poster') || ($_GET['sort']=='rubric')) $sort=$_GET['sort'];
	}
	
	$type="DESC";
	if(isset($_GET['type'])){
	  if(($_GET['type']=='ASC') || ($_GET['type']=='DESC')) $type=$_GET['type'];
	}
	
	$post='';
	$publish='';
	if(isclanmember($userID)) { $post='<input type="button" onclick="MM_openBrWindow(\'_news.php?action=new\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\')" value="'.$_language->module['post_news'].'" />'; }
        if(isnewsadmin($userID)) {
		$unpublished=safe_query("SELECT newsID FROM ".PREFIX."news WHERE published='0' AND saved='1'");
		$unpublished=mysql_num_rows($unpublished);
		if($unpublished) $publish='<input type="button" onclick="MM_goToURL(\'parent\',\'index.php?site=_news&amp;action=unpublished\');return document.MM_returnValue" value="'.$unpublished.' '.$_language->module['unpublished_news'].'" /> ';
	}
	echo $post.' '.$publish.' <input type="button" onclick="MM_goToURL(\'parent\',\'index.php?site=_news\');return document.MM_returnValue" value="'.$_language->module['show_news'].'" /><hr />';

	$all=safe_query("SELECT newsID FROM ".PREFIX."news WHERE published='1' AND intern<=".isclanmember($userID));
	$gesamt=mysql_num_rows($all);
	$pages=1;

	$max = empty($maxnewsarchiv) ? 20 : $maxnewsarchiv;
	$pages = ceil($gesamt/$max);

	if($pages>1) $page_link = makepagelink("index.php?site=_news&amp;action=archive&amp;sort=".$sort."&amp;type=".$type, $page, $pages);
	else $page_link='';

	if($page == "1") {
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."news WHERE published='1' AND intern<=".isclanmember($userID)." ORDER BY ".$sort." ".$type." LIMIT 0,".$max);
		if($type=="DESC") $n=$gesamt;
		else $n=1;
	}
	else {
		$start=$page*$max-$max;
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."news WHERE published='1' AND intern<=".isclanmember($userID)." ORDER BY ".$sort." ".$type." LIMIT ".$start.",".$max);
		if($type=="DESC") $n = ($gesamt)-$page*$max+$max;
		else $n = ($gesamt+1)-$page*$max+$max;
	}
	if($all) {
		if($type=="ASC")
		echo'<a href="index.php?site=_news&amp;action=archive&amp;page='.$page.'&amp;sort='.$sort.'&amp;type=DESC">'.$_language->module['sort'].'</a> <img src="images/icons/asc.gif" width="9" height="7" border="0" alt="" />&nbsp;&nbsp;&nbsp;';
		else
		echo'<a href="index.php?site=_news&amp;action=archive&amp;page='.$page.'&amp;sort='.$sort.'&amp;type=ASC">'.$_language->module['sort'].'</a> <img src="images/icons/desc.gif" width="9" height="7" border="0" alt="" />&nbsp;&nbsp;&nbsp;';


		if($pages>1) echo $page_link;
		if(isnewsadmin($userID)) echo'<form method="post" name="form" action="_news.php">';
		
    eval ("\$news_archive_head = \"".gettemplate("news_archive_head")."\";");
		echo $news_archive_head;
    
		$i=1;
		while($ds=mysql_fetch_array($ergebnis)) {
			if($i%2) {
				$bg1=BG_1;
				$bg2=BG_2;
			}
			else {
				$bg1=BG_3;
				$bg2=BG_4;
			}

			$date=date("d.m.Y", $ds['date']);
			if(file_exists('images/games/'.$ds['game'].'.gif')) $pic = '<img src="images/games/'.$ds['game'].'.gif" alt="'.$ds['game'].'" />';
			$game=$ds['game'];
			$rubric=getrubricname($ds['rubric']);
			$comms = getanzcomments($ds['newsID'], 'ne');
		    if($ds['intern'] == 1) $isintern = '<small>('.$_language->module['intern'].')</small>';
		    else $isintern = '';
			
			if($ds['topnews'] == 1) $istopnews = '<small>('.$_language->module['topnews'].')</small>';
		    else $istopnews = '';
						
			if($ds['sc_banner'] == 1) $issc_banner = '<small>(Add Partner Banner?)</small>';
		    else $issc_banner = '';
      
      $message_array = array();
			$query=safe_query("SELECT * FROM ".PREFIX."news_contents WHERE newsID='".$ds['newsID']."'");
			while($qs = mysql_fetch_array($query)) {
				$message_array[] = array('lang' => $qs['language'], 'headline' => $qs['headline'], 'message' => $qs['content']);
			}

			$headlines='';

			foreach($message_array as $val) {
				$headlines.='<a href="index.php?site=article&amp;newsID='.$ds['newsID'].'&amp;lang='.$val['lang'].'">'.flags('[flag]'.$val['lang'].'[/flag]').' '.clearfromtags($val['headline']).'</a> '.$isintern.'<br />';
			}

			$poster='<a href="index.php?site=profile&amp;id='.$ds['poster'].'">'.getnickname($ds['poster']).'</a>';

			$multiple='';
			$admdel='';
			if(isnewsadmin($userID)) $multiple='<input class="input" type="checkbox" name="newsID[]" value="'.$ds['newsID'].'" />';

			eval ("\$news_archive_content = \"".gettemplate("news_archive_content")."\";");
			echo $news_archive_content;
			$i++;
		}
		
    if(isnewsadmin($userID)) $admdel='<table width="100%" border="0" cellspacing="0" cellpadding="2">
		  <tr>
        <td><input class="input" type="checkbox" name="ALL" value="ALL" onclick="SelectAll(this.form);" /> '.$_language->module['select_all'].'</td>
        <td align="right"><select name="quickactiontype">
          <option value="delete">'.$_language->module['delete_selected'].'</option>
          <option value="unpublish">'.$_language->module['unpublish_selected'].'</option>
        </select>
        <input type="submit" name="quickaction" value="'.$_language->module['go'].'" /></td>
      </tr>
    </table>
    </form>';
		else $admdel='';

		eval ("\$news_archive_foot = \"".gettemplate("news_archive_foot")."\";");
		echo $news_archive_foot;
		unset($ds);

	}
	else echo'no entries';
}
else {}
?>