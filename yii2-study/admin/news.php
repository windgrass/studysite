<?php

if(isset($_GET['action'])) $action = $_GET['action'];
else $action='';
if(isset($_REQUEST['quickactiontype'])) $quickactiontype = $_REQUEST['quickactiontype'];
else $quickactiontype='';

/*if($action=="new" OR $action == "edit") {
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
}*/

if($action=="new") {
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
	$_language->read_module('news');
	$_language->read_module('bbcode', true);
	if(!isnewswriter($userID)) die($_language->module['no_access']);

	safe_query("INSERT INTO ".PREFIX."news (date, poster, saved) VALUES ('".time()."', '".$userID."', '0')");
	$newsID=mysql_insert_id();

	$rubrics='';
	$newsrubrics=safe_query("SELECT rubricID, rubric FROM ".PREFIX."news_rubrics ORDER BY rubric");
	while($dr=mysql_fetch_array($newsrubrics)) {
		$rubrics.='<option value="'.$dr['rubricID'].'">'.$dr['rubric'].'</option>';
	}

	if(isset($_POST['topnews'])) safe_query("UPDATE ".PREFIX."settings SET topnewsID='$newsID'");

	$count_langs = 0;
	$lang=safe_query("SELECT lang, language FROM ".PREFIX."news_languages ORDER BY language");
	$langs='';
	while($dl=mysql_fetch_array($lang)) {
		$langs.="news_languages[".$count_langs."] = new Array();\nnews_languages[".$count_langs."][0] = '".$dl['lang']."';\nnews_languages[".$count_langs."][1] = '".$dl['language']."';\n";
		$count_langs++;
	}

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

	$bg1=BG_1;

	$selects='';
	for($i = 1; $i <= $count_langs; $i++) {
		$selects .= '<option value="'.$i.'">'.$i.'</option>';
	}

	$postform = '';
	$comments='<option value="0">'.$_language->module['no_comments'].'</option><option value="1">'.$_language->module['user_comments'].'</option><option value="2" selected="selected">'.$_language->module['visitor_comments'].'</option>';
	
	eval ("\$addbbcode = \"".gettemplate("addbbcode", "html", "admin")."\";");
  	eval ("\$addflags = \"".gettemplate("flags_admin", "html", "admin")."\";");

	eval ("\$news_post = \"".gettemplate("news_post")."\";");
	echo $news_post;
}
elseif($action=="save") {
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
	$_language->read_module('news');
	$newsID = $_POST['newsID'];

	$ds=mysql_fetch_array(safe_query("SELECT poster FROM ".PREFIX."news WHERE newsID = '".$newsID."'"));
	if(($ds['poster'] != $userID or !isnewswriter($userID)) and !isnewsadmin($userID)) {
		die($_language->module['no_access']);
	}

	$save = isset($_POST['save']);
	$preview = isset($_POST['preview']);

	if(isset($_POST['rubric'])) $rubric = $_POST['rubric'];
	else $rubric = 0;

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
	$comments = $_POST['comments'];

	safe_query("UPDATE ".PREFIX."news SET rubric='".$rubric."',
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
			safe_query("UPDATE ".PREFIX."news_contents SET headline = '".$headline[$i]."', content = '".$message[$i]."' WHERE newsID = '".$newsID."' and language = '".$lang[$i]."'");
			unset($update_langs[$lang[$i]]);
		}
		else {
			safe_query("INSERT INTO ".PREFIX."news_contents (newsID, language, headline, content) VALUES ('".$newsID."', '".$lang[$i]."', '".$headline[$i]."', '".$message[$i]."')");
		}
	}

	// delete the entries that are older than 2 hour and contain no text
	safe_query("DELETE FROM `".PREFIX."news` WHERE `saved` = '0' and ".time()." - `date` > ".(2 * 60 * 60));

	if(isset($_POST['topnews'])) {
		if($_POST['topnews']) {
			safe_query("UPDATE ".PREFIX."settings SET topnewsID='".$newsID."'");
		}
		elseif(!$_POST['topnews'] and $newsID == $topnewsID) {
			safe_query("UPDATE ".PREFIX."settings SET topnewsID='0'");
		}
	}
	if($save) echo'<body onload="window.close()"></body>';
	if($preview) header("Location: ../_news.php?action=preview&newsID=".$newsID);
	if($languagecount) header("Location: ../_news.php?action=edit&newsID=".$newsID);

}
elseif($action=="preview") {
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
	$_language->read_module('news');

	$newsID = $_GET['newsID'];

	$result=safe_query("SELECT * FROM ".PREFIX."news WHERE newsID='$newsID'");
	$ds=mysql_fetch_array($result);

	if(($ds['poster'] != $userID or !isnewswriter($userID)) and !isnewsadmin($userID)) {
		die($_language->module['no_access']);
	}

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
	
	<meta name="description" content="Clanpage using webSPELL 4 CMS" />
	<meta name="author" content="webspell.org" />
	<meta name="keywords" content="webspell, webspell4, clan, cms" />
	<meta name="copyright" content="Copyright &copy; 2005 - 2009 by webspell.org" />
	<meta name="generator" content="webSPELL" />

<!-- Head & Title include -->
	<title>'.PAGETITLE.'; ?></title>
	<link href="_stylesheet.css" rel="stylesheet" type="text/css" />
	<script src="../js/bbcode.js" language="jscript" type="text/javascript"></script>
<!-- end Head & Title include -->
</head>
<body>';

	$bg1=BG_1;

	$bgcolor=BG_1;
	$date = date("d.m.Y", $ds['date']);
	$time = date("H:i", $ds['date']);
	$rubrikname=getrubricname($ds['rubric']);
	$rubrikname_link = getinput(getrubricname($ds['rubric']));
	$rubricpic='<img src="../images/news-rubrics/'.getrubricpic($ds['rubric']).'" alt="" />';
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
		if($showlang!=$i)	$langs.='<a target="_blank" href="../index.php?site=article&amp;newsID='.$ds['newsID'].'">[flag]'.$val['lang'].'[/flag]</a>';
		$i++;
	}
	$langs = flags($langs);

	$headline=$message_array[$showlang]['headline'];
	$content=$message_array[$showlang]['message'];
	
	if($ds['intern'] == 1) $isintern = '('.$_language->module['intern'].')';
    else $isintern = '';
    
	$content = htmloutput($content);
	$content = toggle($content, $ds['newsID']);
	$poster='<a target="_blank" href="../index.php?site=user&amp;id='.$ds['poster'].'"><b>'.getnickname($ds['poster']).'</b></a>';
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
  <input type="button" onclick="MM_goToURL(\'parent\',\'../_news.php?action=edit&amp;newsID='.$newsID.'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" />
  <input type="button" onclick="javascript:self.close()" value="'.$_language->module['save_news'].'" />
  <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'../_news.php?action=delete&amp;id='.$newsID.'&amp;close=true\')" value="'.$_language->module['delete'].'" /></body></html>';
}
elseif($quickactiontype=="unpublish") {
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
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
	}
	header("Location: admincenter.php?site=news");
}
elseif($quickactiontype=="delete") {
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
	$_language->read_module('news');
  if(isset($_POST['newsID'])){
  	$newsID = $_POST['newsID'];
	
		foreach($newsID as $id) {
			$ds=mysql_fetch_array(safe_query("SELECT screens, poster FROM ".PREFIX."news WHERE newsID='".$id."'"));
			if(($ds['poster'] != $userID or !isnewswriter($userID)) and !isnewsadmin($userID)) {
				die($_language->module['no_access']);
			}
			if($ds['screens']) {
				$screens=explode("|", $ds['screens']);
				if(is_array($screens)) {
					$filepath = "../images/news-pics/";
					foreach($screens as $screen) {
						if(file_exists($filepath.$screen)) @unlink($filepath.$screen);
					}
				}
			}
			safe_query("DELETE FROM ".PREFIX."news WHERE newsID='".$id."'");
			safe_query("DELETE FROM ".PREFIX."news_contents WHERE newsID='".$id."'");
			safe_query("DELETE FROM ".PREFIX."comments WHERE parentID='".$id."' AND type='ne'");
		}
		header("Location: admincenter.php?site=news");
  }
  else{
  	header("Location: admincenter.php?site=news");
  }
}
elseif($action=="delete") {
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
	$_language->read_module('news');

	$id = $_GET['id'];

	$ds=mysql_fetch_array(safe_query("SELECT screens, poster FROM ".PREFIX."news WHERE newsID='".$id."'"));
	if(($ds['poster'] != $userID or !isnewswriter($userID)) and !isnewsadmin($userID)) {
		die($_language->module['no_access']);
	}
	if($ds['screens']) {
		$screens=explode("|", $ds['screens']);
		if(is_array($screens)) {
			$filepath = "../images/news-pics/";
			foreach($screens as $screen) {
				if(file_exists($filepath.$screen)) @unlink($filepath.$screen);
			}
		}
	}

	safe_query("DELETE FROM ".PREFIX."news WHERE newsID='".$id."'");
	safe_query("DELETE FROM ".PREFIX."news_contents WHERE newsID='".$id."'");
	safe_query("DELETE FROM ".PREFIX."comments WHERE parentID='".$id."' AND type='ne'");
  
	if(isset($_GET['close'])) echo'<body onload="window.close()"></body>';
	else header("Location: admincenter.php?site=news");
}
elseif($action=="edit") {
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
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
		$message_array[] = array('lang' => $qs['language'], 'headline' => $qs['headline'], 'message' => $qs['content']);
	}

	$count_langs = 0;
	$lang=safe_query("SELECT lang, language FROM ".PREFIX."news_languages ORDER BY language");
	$langs='';
	while($dl=mysql_fetch_array($lang)) {
		$langs.="news_languages[".$count_langs."] = new Array();\nnews_languages[".$count_langs."][0] = '".$dl['lang']."';\nnews_languages[".$count_langs."][1] = '".$dl['language']."';\n";
		$count_langs++;
	}

	$message_vars='';
	$headline_vars='';
	$langs_vars='';
	$i=0;
	foreach($message_array as $val) {
		$message_vars .= "message[".$i."] = '".js_replace($val['message'])."';\n";
		$headline_vars .= "headline[".$i."] = '".js_replace(htmlspecialchars($val['headline']))."';\n";
		$langs_vars .= "langs[".$i."] = '".$val['lang']."';\n";
		$i++;
	}
	$langcount = $i;

	$newsrubrics=safe_query("SELECT * FROM ".PREFIX."news_rubrics ORDER BY rubric");
	$rubrics='';
	while($dr=mysql_fetch_array($newsrubrics)) {
		if($ds['rubric']==$dr['rubricID']) $rubrics.='<option value="'.$dr['rubricID'].'" selected="selected">'.getinput($dr['rubric']).'</option>';
		else $rubrics.='<option value="'.$dr['rubricID'].'">'.getinput($dr['rubric']).'</option>';
	}

	if($ds['intern']) $intern = '<option value="0">'.$_language->module['no'].'</option><option value="1" selected="selected">'.$_language->module['yes'].'</option>';
	else $intern = '<option value="0" selected="selected">'.$_language->module['no'].'</option><option value="1">'.$_language->module['yes'].'</option>';
	if($topnewsID == $newsID) $topnews = '<option value="0">'.$_language->module['no'].'</option><option value="1" selected="selected">'.$_language->module['yes'].'</option>';
	else $topnews = '<option value="0" selected="selected">'.$_language->module['no'].'</option><option value="1">'.$_language->module['yes'].'</option>';

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

	$comments='<option value="0">'.$_language->module['no_comments'].'</option><option value="1">'.$_language->module['user_comments'].'</option><option value="2">'.$_language->module['visitor_comments'].'</option>';
	$comments=str_replace('value="'.$ds['comments'].'"', 'value="'.$ds['comments'].'" selected="selected"', $comments);

	$bg1=BG_1;

	eval ("\$addbbcode = \"".gettemplate("addbbcode", "html", "admin")."\";");
  	eval ("\$addflags = \"".gettemplate("flags_admin", "html", "admin")."\";");

	eval ("\$news_post = \"".gettemplate("news_post")."\";");
	echo $news_post;
}

elseif($action=="unpublished") {
	
	if(!isnewsadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);
	$_language->read_module('news');
	
	$post='<input type="button" onclick="MM_openBrWindow(\'../_news.php?action=new\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');" value="'.$_language->module['post_news'].'" />';

	echo $post.' <input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=news\');return document.MM_returnValue;" value="'.$_language->module['show_news'].'" /><hr />';

	$page='';

	// Not published News
	
		$ergebnis=safe_query("SELECT * FROM ".PREFIX."news WHERE published='0' AND saved='1' ORDER BY date ASC");
		if(mysql_num_rows($ergebnis)) {

			echo '<form method="post" name="form" action="../_news.php">';
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
					$headlines.=htmloutput('<a target="_blank" href="../index.php?site=article&amp;newsID='.$ds['newsID'].'">[flag]'.$val['lang'].'[/flag] '.$val['headline'].'</a><br />');
				}

				$poster='<a target="_blank" href="../index.php?site=user&amp;id='.$ds['poster'].'">'.getnickname($ds['poster']).'</a>';

				$multiple='';
				$admdel='';
				$editusw='<input type="button" onclick="MM_openBrWindow(\'../_news.php?action=edit&amp;newsID='.$ds['newsID'].'\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');" value="'.$_language->module['edit'].'" />
		  <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'../_news.php?action=delete&amp;id='.$ds['newsID'].'\')" value="'.$_language->module['delete'].'" />';
				
					$multiple='<input class="input" type="checkbox" name="newsID[]" value="'.$ds['newsID'].'" />';
					$admdel='<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-hover">
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

				
				eval ("\$news_archive_content = \"".gettemplate("news_archive_content")."\";");
				echo $news_archive_content;
				$i++;
			}
			eval ("\$news_archive_foot = \"".gettemplate("news_archive_foot")."\";");
			echo $news_archive_foot;

			unset($ds);
		
	}
}
else {
	
	if(!isnewsadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

	$_language->read_module('news');
  
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
		$post='<input type="button" onclick="MM_openBrWindow(\'../_news.php?action=new\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\')" value="'.$_language->module['post_news'].'" />';
		$unpublished=safe_query("SELECT newsID FROM ".PREFIX."news WHERE published='0' AND saved='1'");
		$unpublished=mysql_num_rows($unpublished);
		if($unpublished) $publish='<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=news&amp;action=unpublished\');return document.MM_returnValue" value="'.$unpublished.' '.$_language->module['unpublished_news'].'" /> ';
		
	echo $post.' '.$publish.' <input type="button" onclick="MM_goToURL(\'parent\',\'?site=news\');return document.MM_returnValue" value="'.$_language->module['show_news'].'" /><hr />';

	$all=safe_query("SELECT newsID FROM ".PREFIX."news WHERE published='1' AND intern<=".isclanmember($userID));
	$gesamt=mysql_num_rows($all);
	$pages=1;

	$max = empty($maxnewsarchiv) ? 20 : $maxnewsarchiv;
	$pages = ceil($gesamt/$max);

	if($pages>1) $page_link = makepagelink("?site=news&amp;action=archive&amp;sort=".$sort."&amp;type=".$type, $page, $pages);
	else $page_link='';

	if($page == "1") {
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."news WHERE published='1' AND intern<=".isclanmember($userID)." ORDER BY topnews DESC, ".$sort." ".$type." LIMIT 0,".$max);
		if($type=="DESC") $n=$gesamt;
		else $n=1;
	}
	else {
		$start=$page*$max-$max;
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."news WHERE published='1' AND intern<=".isclanmember($userID)." ORDER BY topnews DESC, ".$sort." ".$type." LIMIT ".$start.",".$max);
		if($type=="DESC") $n = ($gesamt)-$page*$max+$max;
		else $n = ($gesamt+1)-$page*$max+$max;
	}
	if($all) {
		if($type=="ASC")
		echo'<a href="?site=news&amp;action=archive&amp;page='.$page.'&amp;sort='.$sort.'&amp;type=DESC">'.$_language->module['sort'].'</a> <img src="../images/icons/asc.gif" width="9" height="7" border="0" alt="" />&nbsp;&nbsp;&nbsp;';
		else
		echo'<a href="?site=news&amp;action=archive&amp;page='.$page.'&amp;sort='.$sort.'&amp;type=ASC">'.$_language->module['sort'].'</a> <img src="../images/icons/desc.gif" width="9" height="7" border="0" alt="" />&nbsp;&nbsp;&nbsp;';


		if($pages>1) echo $page_link;
		if(isnewsadmin($userID)) echo'<form method="post" name="form" action="../_news.php">';
		
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
			$rubric=getrubricname($ds['rubric']);

			if($ds['blog'] == '1') { $blog = '<font style="color: red">Link</font>'; }
			else { $blog = 'News'; }
			
			$comms = getanzcomments($ds['newsID'], 'ne');
		    if($ds['intern'] == 1) $isintern = '<small>('.$_language->module['intern'].')</small>';
		    else $isintern = '';
			
     		$message_array = array();
			$query=safe_query("SELECT * FROM ".PREFIX."news_contents WHERE newsID='".$ds['newsID']."'");
			while($qs = mysql_fetch_array($query)) {
				$message_array[] = array('lang' => $qs['language'], 'headline' => $qs['headline'], 'message' => $qs['content']);
			}

			$url1="http://";
			if($ds['url1']!="http://") $url1=$ds['url1'];
			
			$headlines='';

			foreach($message_array as $val) {
				$headlines.='<a target="_blank"  href="'.$url1.'">'.$val['headline'].'</a><br />';
			}
			$headlines = htmloutput($headlines);
			
			$poster='<a target="_blank" href="../index.php?site=user&amp;id='.$ds['poster'].'">'.getnickname($ds['poster']).'</a>';
			if($ds['topnews'] == 1) $top ='<div style="float: left; width:auto; padding: 0px 5px; margin-right: 5px; background: red; color: #FFF">TOP</div>'; else $top = '';

			$multiple='';
			$admdel='';
			$editusw='<input type="button" onclick="MM_openBrWindow(\'../_news.php?action=edit&amp;newsID='.$ds['newsID'].'\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');" value="'.$_language->module['edit'].'" />
		  <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'../_news.php?action=delete&amp;id='.$ds['newsID'].'\')" value="'.$_language->module['delete'].'" />';
			$multiple='<input class="input" type="checkbox" name="newsID[]" value="'.$ds['newsID'].'" />';

			eval ("\$news_archive_content = \"".gettemplate("news_archive_content")."\";");
			echo $news_archive_content;
			$i++;
		}
		
    $admdel='<table width="100%" border="0" cellspacing="0" cellpadding="2" class="table table-hover">
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

		eval ("\$news_archive_foot = \"".gettemplate("news_archive_foot")."\";");
		echo $news_archive_foot;
		unset($ds);

	}
	else echo'no entries';
}
?>