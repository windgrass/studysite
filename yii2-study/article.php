<!--start section-->
<section class="ns_section">

    <!--start ns_container-->
    <div class="ns_container ns_clearfix">

        <div class="ns_space20"></div>

		<div class="grid grid_8">
<?php

$_language->read_module('news');

if(isset($newsID)) unset($newsID);
if(isset($_GET['newsID'])) $newsID = $_GET['newsID'];
if(isset($lang)) unset($lang);
if(isset($_GET['lang'])) $lang = $_GET['lang'];
$post = "";
if(isnewswriter($userID)) $post='<input type="button" onclick="MM_openBrWindow(\'_news.php?action=new\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\')" value="'.$_language->module['post_news'].'" />';
// echo $post;

if($newsID) {
	
	if($_POST['like']) {
			$id = $_POST['id'];
			if(isset($_COOKIE['ratenew'."_".$id])) {
				echo "You Already Voted";
			}
			else{
				$sql = "UPDATE ".PREFIX."news SET `votes`=`votes`+1 where `newsID` = '".$id."'";
				$query=mysql_query($sql);
				$expire=time()+60*60*24*30;
				setcookie("ratenew"."_".$id, "ratenew"."_".$id, $expire);		
			}
	}
	
	$result=safe_query("SELECT * FROM ".PREFIX."news WHERE newsID='".$newsID."'");
	$ds=mysql_fetch_array($result);

	if($ds['intern'] <= isclanmember($userID) && ($ds['published'] || (isnewsadmin($userID) || (isnewswriter($userID) and $ds['poster'] == $userID)))) {
		
		safe_query("UPDATE ".PREFIX."news SET hits=hits+1 WHERE newsID='".$newsID."'");
		$anznewscomments = getanzcomments($ds['newsID'], 'ne');
		$anznewshits = $ds['hits'];
		
		$votes = $ds['votes'];
		
		$date = date("d.m.Y", $ds['date']);
		$day = date("d",$ds['date']);
		$month = date("M",$ds['date']);
		$year = date("Y",$ds['date']);
		
		$time = date("H:i", $ds['date']);
		$rubrikname=getrubricname($ds['rubric']);
		$rubricID = $ds['rubric'];
		$rubrikname_link = getinput($rubrikname);
		$rubricpic_name = getrubricpic($ds['rubric']);
		$rubricpic='images/news-rubrics/'.$rubricpic_name;
		if(!file_exists($rubricpic) OR $rubricpic_name=='') $rubricpic = ''; 
		else $rubricpic = '<img src="'.$rubricpic.'" border="0" alt="" />';
		
		$banner =$ds['banner'];
		$banner2 =$ds['banner2'];
		$pic='<img src="images/news_pics/'.$ds['banner'].'" width="229" height="147" alt="" style="float:left; margin-right:7px; margin-bottom:7px;" />';
		if(!$ds['banner2']) $pic2='';
		else $pic2='<center><img src="images/news_pics/klein/'.$ds['banner2'].'" style="float: left; margin: 0px 20px 10px 0px" width="40%" /></center>';
		
		
		$message_array = array();
		$query=safe_query("SELECT n.*, c.short AS `countryCode`, c.country FROM ".PREFIX."news_contents n LEFT JOIN ".PREFIX."countries c ON c.short = n.language WHERE n.newsID='".$newsID."'");
		while($qs = mysql_fetch_array($query)) {
			$message_array[] = array('lang' => $qs['language'], 'headline' => $qs['headline'], 'message' => $qs['content'], 'country'=> $qs['country'], 'countryShort' => $qs['countryCode']);
		}
		if(isset($_GET['lang'])) $showlang = getlanguageid($_GET['lang'], $message_array);
		else $showlang = select_language($message_array);

		$langs='';
		$i=0;
		foreach($message_array as $val) {
			if($showlang!=$i)	$langs.='<span style="padding-left:2px"><a href="index.php?site=article&amp;newsID='.$ds['newsID'].'&amp;lang='.$val['lang'].'"><img src="images/flags/'.$val['countryShort'].'.gif" width="18" height="12" border="0" alt="'.$val['country'].'" /></a></span>';
			$i++;
		}
		
		$headline=$message_array[$showlang]['headline'];
		$content=$message_array[$showlang]['message'];
		
		if($ds['intern'] == 1) $isintern = '('.$_language->module['intern'].')';
		else $isintern = '';
		
	if(mb_strlen($headline)>45) {
		$headlinee=mb_substr($headline, 0, 60);
		$headlinee='<font style="font-size: 16px">'.$headline.'</font>';
	} else $headlinee= $headline;

		$content = htmloutput($content);
		$content = toggle($content, $ds['newsID']);
		$comments = '';
		
		$hits =$ds['hits'];
		
		$first = getfirstname($ds['poster']);
		$last = getlastname($ds['poster']);
		$ppic = getuserpic($ds['poster']);
		$poster='<b>'.getnickname($ds['poster']).'</b>';
		$postera='<a href="index.php?site=user&amp;id='.$ds['poster'].'"><b>'.getnickname($ds['poster']).'</b></a>';
        if($ppic) $posterpic = 'images/userpics/'.getuserpic($ds['poster']).'';
		else $posterpic = 'images/userpics/nouserpic.gif';
        $posterdesc= getsignatur($ds['poster']);

		$related='';

		if(empty($related)) $related="n/a";
    
    if(isnewsadmin($userID) or (isnewswriter($userID) and $ds['poster'] == $userID)) {
			if(!$ds['published']) { $adminaction='<input type="button" onclick="MM_openBrWindow(\'_news.php?action=edit&amp;newsID='.$ds['newsID'].'\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\')" value="'.$_language->module['edit'].'" /><input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'_news.php?action=delete&amp;id='.$ds['newsID'].'\')" value="'.$_language->module['delete'].'" />';

 $adminaction='<div style="float: right;"><form method="post" action="_news.php?quickactiontype=publish"><input type="hidden" name="newsID[]" value="'.$ds['newsID'].'" /><input type="submit" name="submit" value="'.$_language->module['publish_now'].'" /></form></div> <div style="float: right; margin-right: 5px"><input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'_news.php?action=delete&amp;id='.$ds['newsID'].'\')" value="'.$_language->module['delete'].'" /></div> <div style="float: right; margin-right: 5px"><input type="button" onclick="MM_openBrWindow(\'_news.php?action=edit&amp;newsID='.$ds['newsID'].'\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\')" value="'.$_language->module['edit'].'" /></div>'; }

else { $adminaction = '<div style="float: right;"><form method="post" action="_news.php?quickactiontype=unpublish"><input type="hidden" name="newsID[]" value="'.$ds['newsID'].'" /><input type="submit" name="submit" value="'.$_language->module['unpublish'].'" /></form></div> <div style="float: right; margin-right: 5px"><input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'_news.php?action=delete&amp;id='.$ds['newsID'].'\')" value="'.$_language->module['delete'].'" /></div> <div style="float: right; margin-right: 5px"><input type="button" onclick="MM_openBrWindow(\'_news.php?action=edit&amp;newsID='.$ds['newsID'].'\',\'News\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\')" value="'.$_language->module['edit'].'" /></div>'; }

		}
		else $adminaction='';
		
		
	//rateform
	
		if($ds[rating]) $ratingpic='<img src="images/liked.png" width="80" height="16" alt="" /> '.$ds[rating].' likes';
			else $ratingpic='<img src="images/like.png" width="80" height="16" alt="" />';
		
		if($loggedin) {
			$getnews=safe_query("SELECT news FROM ".PREFIX."user WHERE userID='$userID'");
			$found=false;
			if(mysql_num_rows($getnews)) {
				$ga=mysql_fetch_array($getnews);
				if($ga['news']!="") {
					$string=$ga['news'];
					$array=explode(":", $string);
					$anzarray=count($array);
					for($i=0; $i<$anzarray; $i++) {
						if($array[$i]==$newsID) $found=true;
					}
				}
			}
			if($found) $rateform=$_language->module['already_rated'];
			else $rateform='<form method="post" action="rating.php">
      <div style="float: left;"><table cellspacing="0" cellpadding="2" align="right">
        <tr>
          <td>
          <div style="display: none"><select name="rating">
            <option>1</option>
          </select></div>
          <input type="hidden" name="userID" value="'.$userID.'" />
          <input type="hidden" name="type" value="ne" />
          <input type="hidden" name="id" value="'.$ds['newsID'].'" />
          <input type="submit" name="Submit" value="Like" /></td>
        </tr>
      </table></div>
      </form>';
		}
		else $rateform=$_language->module['login_for_rate'];
		             
        echo '<div>';

				$anzcomments = getanzcomments($ds['newsID'], 'ne');
				$replace = Array('$anzcomments', '$url', '$lastposter', '$lastdate');
				$vars = Array($anzcomments, 'index.php?site=article&amp;newsID='.$ds['newsID'], clearfromtags(html_entity_decode(getlastcommentposter($ds['newsID'], 'ne'))), date('d.m.Y - H:i', getlastcommentdate($ds['newsID'], 'ne')));

				switch($anzcomments) {
					case 0: $comments = str_replace($replace, $vars, $_language->module['no_comment']); break;
					case 1: $comments = str_replace($replace, $vars, $_language->module['comment']); break;
					default: $comments = str_replace($replace, $vars, $_language->module['comments']); break;
				}
				
		$anzcomments = '<a style="color: #4c3b33" href="article/'.$res['lastID'].'/#disqus_thread">0</a>'; // disqus comments option
		
		$news_next = $newsID+1;
		$news_prev = $newsID-1;
				
		//NEXT
		$querya=safe_query("SELECT * FROM ".PREFIX."news_contents WHERE newsID='".$news_next."'");
		while($qsa = mysql_fetch_array($querya)) {
			$headlinea = $qsa['headline'];
			$news_next_name = $headlinea;
		}
		
		//PREV
		$queryb=safe_query("SELECT * FROM ".PREFIX."news_contents WHERE newsID='".$news_prev."'");
		while($qsb = mysql_fetch_array($queryb)) {
			$headlineb = $qsb['headline'];
			$news_prev_name = $headlineb;
		}
		
		eval ("\$news_comment = \"".gettemplate("news_comment")."\";");
		echo $news_comment;
									
		$comments_allowed = $ds['comments'];
		$parentID = $newsID;
		$type = "ne";
		$referer = "index.php?site=article&newsID=$newsID";
		$comms = getanzcomments($ds['newsID'], 'ne');
		              
                echo '</div>';
	}
	else echo $_language->module['no_access'];
}

?>
		</div>
		
		<!--sidebar-->
		<div class="grid grid_4">

            <div class="ns_archive1 ns_bg_grey ns_radius ns_shadow">
                <div class="ns_textevidence ns_bg_green ns_radius_top">
                    <h4 class="white ns_margin20">LATEST POSTS</h4>
                </div>
                <ul class="ns_list border">
                    <?php include('sc_headlines.php'); ?>
                </ul>
            </div>

            <div class="ns_space20"></div>

			<div class="ns_archive1 ns_bg_grey ns_radius ns_shadow">
                <div class="ns_textevidence ns_bg_blue ns_radius_top">
                    <h4 class="white ns_margin20">TWITTER</h4>
                </div>
                <ul class="ns_list border">
                    <?php include('sc_twitter.php'); ?>
                </ul>
            </div>
			
			<div class="ns_space20"></div>
			
			<div class="ns_archive1 ns_bg_grey ns_radius ns_shadow">
                <div class="ns_textevidence ns_bg_bluedark ns_radius_top">
                    <h4 class="white ns_margin20">FACEBOOK</h4>
                </div>
                <ul class="ns_list border">
                    <?php include('sc_facebook.php'); ?>
                </ul>
            </div>

		</div>
		<!--sidebar-->

		<div class="ns_space50"></div>

    </div>
    <!--end ns_container-->
            
</section>
<!--end section-->