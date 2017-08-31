<?php

$_language->read_module('index');

if(isset($_GET['cat'])) $cat = $_GET['cat'];
else $cat = '';

	if(isset($_GET['show'])) {
		$result=safe_query("SELECT rubricID FROM ".PREFIX."news_rubrics WHERE rubric='".$_GET['show']."' LIMIT 0,1");
		$dv=mysql_fetch_array($result);
		$showonly = "AND rubric='".$dv['rubricID']."'";
	}
	else $showonly = '';

	/*news pages switch*/
	if(isset($_GET['page'])) $page=(int)$_GET['page'];
	else $page = 1;
	$all=safe_query("SELECT newsID FROM ".PREFIX."news WHERE published='1' AND blog='0' ".$showonly." AND intern<=".isclanmember($userID));
	$gesamt=mysql_num_rows($all);
	$pages=1;

	$max = empty($maxshownnews) ? 20 : $maxshownnews;
	$pages = ceil($gesamt/$max);
	/*news pages switch ende */
	
	$resultaa=safe_query("SELECT * FROM ".PREFIX."news WHERE published='1' AND blog='0' ".$showonly."");
	while($dsa=mysql_fetch_array($resultaa)) {
		$rubriknamee = getrubricname($dsa['rubric']);
	}
	
	if(isset($_GET['show'])) {
		if($pages > 0) { $title = $rubriknamee.' NEWS'; $pagination = '<a class="view_all">PAGE '.$page.' / '.$pages.'</a>'; }
		else { $title = $_GET['show'].' NEWS'; $pagination = ''; }
	}
	else { 
		if($pages > 0) { $title = 'NEWS'; $pagination = '<a class="view_all">PAGE '.$page.' / '.$pages.'</a>'; }
		else { $title = 'NEWS'; $pagination = ''; }
	}
	
	eval ("\$title_news = \"".gettemplate("title_news")."\";");
	echo $title_news;
	
	echo'<div class="article_list small">';
  
	$post='';
	$publish='';
	if(isnewswriter($userID)) {
		$post='<input type="button" onclick="MM_openBrWindow(\'news.php?action=new\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');" value="'.$_language->module['post_news'].'" />';
	}
	if(isnewsadmin($userID)) {
		$unpublished=safe_query("SELECT newsID FROM ".PREFIX."news WHERE published='0' AND blog='0' AND saved='1'");
		$unpublished=mysql_num_rows($unpublished);
		if($unpublished) $publish='<div><input type="button" onclick="MM_goToURL(\'parent\',\'index.php?site=news&amp;action=unpublished\');return document.MM_returnValue;" value="'.$unpublished.' '.$_language->module['unpublished_news'].'" /></div>';
	}
	echo $publish;

		/*news pages switch*/
	if($pages>1) $page_link = makepagelink("index.php?site=news&show=".$_GET['show'], $page, $pages);
	else $page_link='';

	if($page == "1") {
	/*news pages switch ende*/
	$result=safe_query("SELECT * FROM ".PREFIX."news WHERE published='1' AND blog='0' AND intern<=".isclanmember($userID)." ".$showonly." ORDER BY date DESC LIMIT 0,".$maxshownnews);
	$n=$gesamt;
	}
	else {
		$start=$page*$max-$max;
		$result = safe_query("SELECT * FROM ".PREFIX."news WHERE published='1' AND blog='0' AND intern<=".isclanmember($userID)." ".$showonly." ORDER BY date DESC LIMIT ".$start.",".$maxshownnews);
		$n = ($gesamt)-$page*$max+$max;
	}
	$i=1;
	while($ds=mysql_fetch_array($result)) {
		if($i%2) $bg1=BG_1;
		else $bg1=BG_2;

		$date = date("d.m.Y", $ds['date']);
		$time = date("H:i", $ds['date']);
		$rubrikname = getrubricname($ds['rubric']);
		$rubrikname_link = getinput($rubrikname);
		$rubricpic_path = "images/news-rubrics/".getrubricpic($ds['rubric']);
		$rubricpic='<img src="'.$rubricpic_path.'" border="0" alt="" />';
		if(!is_file($rubricpic_path)) $rubricpic='';
		$banner =$ds['banner'];
		$banner2 =$ds['banner2'];
				
		$pic='images/news_pics/'.$ds['banner'].'';
		$pic2='images/news_pics/klein/'.$ds['banner2'].'';
		
		$message_array = array();
		$query=safe_query("SELECT * FROM ".PREFIX."news_contents WHERE newsID='".$ds['newsID']."'");
		while($qs = mysql_fetch_array($query)) {
			$message_array[] = array('lang' => $qs['language'], 'intro' => $qs['intro'], 'headline' => $qs['headline'], 'message' => $qs['content']);
		}

		$showlang = select_language($message_array);

		$langs='';
		$x=0;
		foreach($message_array as $val) {
			if($showlang!=$x) $langs.='<span style="padding-left:2px"><a href="index.php?site=articles&newsID='.$ds['newsID'].'&amp;lang='.$val['lang'].'">[flag]'.$val['lang'].'[/flag]</a></span>';
			$x++;
		}
		$langs = flags($langs);
	
		$intro=$message_array[$showlang]['intro'];
		$headline=$message_array[$showlang]['headline'];
		$content=$message_array[$showlang]['message'];
		
		$newsID=$ds['newsID'];
		if($ds['intern'] == 1) $isintern = '('.$_language->module['intern'].')';
		else $isintern = '';
		
		$intro = htmloutput($intro);
		$intro = toggle($intro, $ds['newsID']);
		
		if(mb_strlen($intro)>200) {
			$intro=mb_substr($intro, 0, 200);
			$intro.='...';
		}
		
		$content = htmloutput($content);
		$content = toggle($content, $ds['newsID']);

		if(mb_strlen($content)>200) {
			$content=mb_substr($content, 0, 200);
			$content.='...';
		}

		$headline = clearfromtags($headline);
		$poster='<a href="index.php?site=profile&amp;id='.$ds['poster'].'"><b>'.getnickname($ds['poster']).'</b></a>';
		$related="";
    	if($ds['link1'] && $ds['url1']!="http://" && $ds['window1']) $related.='&#8226; <a href="'.$ds['url1'].'" target="_blank">'.$ds['link1'].'</a> ';
		if($ds['link1'] && $ds['url1']!="http://" && !$ds['window1']) $related.='&#8226; <a href="'.$ds['url1'].'">'.$ds['link1'].'</a> ';

		if($ds['link2'] && $ds['url2']!="http://" && $ds['window2']) $related.='&#8226; <a href="'.$ds['url2'].'" target="_blank">'.$ds['link2'].'</a> ';
		if($ds['link2'] && $ds['url2']!="http://" && !$ds['window2']) $related.='&#8226; <a href="'.$ds['url2'].'">'.$ds['link2'].'</a> ';

		if($ds['link3'] && $ds['url3']!="http://" && $ds['window3']) $related.='&#8226; <a href="'.$ds['url3'].'" target="_blank">'.$ds['link3'].'</a> ';
		if($ds['link3'] && $ds['url3']!="http://" && !$ds['window3']) $related.='&#8226; <a href="'.$ds['url3'].'">'.$ds['link3'].'</a> ';

		if($ds['link4'] && $ds['url4']!="http://" && $ds['window4']) $related.='&#8226; <a href="'.$ds['url4'].'" target="_blank">'.$ds['link4'].'</a> ';
		if($ds['link4'] && $ds['url4']!="http://" && !$ds['window4']) $related.='&#8226; <a href="'.$ds['url4'].'">'.$ds['link4'].'</a> ';

		if(empty($related)) $related="n/a";

		if($ds['comments']) {
			if($ds['cwID']) {  // CLANWAR-NEWS
				$anzcomments = getanzcomments($ds['cwID'], 'cw');
				$replace = Array('$anzcomments', '$url', '$lastposter', '$lastdate');
				$vars = Array($anzcomments, 'index.php?site=clanwars_details&amp;cwID='.$ds['cwID'], clearfromtags(getlastcommentposter($ds['cwID'], 'cw')), date('d.m.Y - H:i', getlastcommentdate($ds['cwID'], 'cw')));

				switch($anzcomments) {
					case 0: $comments = str_replace($replace, $vars, $_language->module['no_comment']); break;
					case 1: $comments = str_replace($replace, $vars, $_language->module['comment']); break;
					default: $comments = str_replace($replace, $vars, $_language->module['comments']); break;
				}
			}
			else {
				$anzcomments = getanzcomments($ds['newsID'], 'ne');
				$replace = Array('$anzcomments', '$url', '$lastposter', '$lastdate');
				$vars = Array($anzcomments, 'index.php?site=articles&newsID='.$ds['newsID'], clearfromtags(html_entity_decode(getlastcommentposter($ds['newsID'], 'ne'))), date('d.m.Y - H:i', getlastcommentdate($ds['newsID'], 'ne')));

				switch($anzcomments) {
					case 0: $comments = str_replace($replace, $vars, $_language->module['no_comment']); break;
					case 1: $comments = str_replace($replace, $vars, $_language->module['comment']); break;
					default: $comments = str_replace($replace, $vars, $_language->module['comments']); break;
				}
			}
		}
		else $comments='';
		
					//rateform
	
		if($ds[rating]) $ratingpic='<img src="images/rating'.$ds[rating].'.png" width="80" height="16" alt="" />';
			else $ratingpic='<img src="images/rating0.png" width="80" height="16" alt="" />';

		$adminaction = '';
		if(isnewsadmin($userID)) {
			$adminaction .= '<input type="button" onclick="MM_goToURL(\'parent\',\'news.php?quickactiontype=unpublish&newsID='.$ds['newsID'].'\');return document.MM_returnValue;" value="'.$_language->module['unpublish'].'" /> ';
		}
		if((isnewswriter($userID) and $ds['poster'] == $userID) or isnewsadmin($userID)) {
			$adminaction .= '<input type="button" onclick="MM_openBrWindow(\'news.php?action=edit&newsID='.$ds['newsID'].'\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');" value="'.$_language->module['edit'].'" />
		  <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'news.php?action=delete&amp;id='.$ds['newsID'].'\')" value="'.$_language->module['delete'].'" />';
		}

		eval ("\$news = \"".gettemplate("news")."\";");
		echo $news;

		$i++;

		unset($related);
		unset($comments);
		unset($lang);
		unset($ds);
	}
	
echo '</div>';

$paginas = '<center>'.$page_link.'</center>';
	if($pages>1) echo $paginas;

?>
                            