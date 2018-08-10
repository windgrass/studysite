<?php

$_language->read_module('profile');

if(isset($_GET['id'])) $id = (int)$_GET['id'];
else $id=$userID;
if(isset($_GET['action'])) $action = $_GET['action'];
else $action = '';

if($_GET['edit']=="account" && $_GET['gameaccID'] && $_GET['type']) { 
    
    $getvalue = safe_query("SELECT value FROM ".PREFIX."user_gameacc WHERE userID='$id' && gameaccID='".$_GET['gameaccID']."'");
    $dr = mysql_fetch_array($getvalue);
    
      $game.='<option selected value="'.$_GET['gameaccID'].'">'.$_GET['type'].'</option>';
    
	   $editgacc = '
			<form method="post" action="index.php?site=user">
				<table width="100%" border="0" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
				    <tr>
						<td class="title" colspan="5" align="center" bgcolor="'.$bghead.'">Edit Gameaccount</td>
				    </tr>
					<tr> 
						<td colspan="5" bgcolor="'.$pagebg.'"></td>
					</tr>
					<a name="editgacc"></a>
				    <tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right"> </td>
						<td bgcolor="'.BG_1.'"><select name="type">'.$game.'</select></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right">Value:</td>
						<td bgcolor="'.BG_1.'"><input name="value" type="text" size="30"  value="'.getinput($dr['value']).'"></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'"><input type="hidden" name="id" value="'.$id.'"></td>
						<td bgcolor="'.BG_1.'"><input type="submit" name="edit" value="Update"></td>
				    </tr>
				</table>
			</form>'; }	
			
    if($_POST['edit']) {
      
	  $type = $_POST['type'];
	  $value = $_POST['value'];
	  $id = $_POST['id'];

	  $ergebnis=safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id'");
		$ds=mysql_fetch_array($ergebnis);
		
	  $inlog=safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id' AND gameaccID='$type'");
		$dd=mysql_fetch_array($inlog);
		
	$ergebnis2 = safe_query("SELECT value FROM ".PREFIX."user_gameacc WHERE value = '$value' && type = '".$dd['type']."' && log='0'");
		$num_gameacc = mysql_num_rows($ergebnis2);
		
		//echo "SELECT value FROM ".PREFIX."user_gameacc WHERE value = '$value' && type = '".$dd['type']."'";
		
		if($num_gameacc)  {
		    $error="Already in-use!";
			die('<b>ERROR: '.$error.'</b><br><br><input type="button" class="button" onClick="javascript:history.back()" value="Back">');
		}
		if(!(strlen(trim($value)))) {
		    $error="You have to enter a Value!";
			die('<b>ERROR: '.$error.'</b><br><br><input type="button" class="button" onClick="javascript:history.back()" value="Back">');
		}
			
		
        safe_query("INSERT INTO ".PREFIX."user_gameacc (userID, type, value, log) VALUES ('".$id."', '".$dd['type']."', '".$dd['value']."', '1')");
		safe_query("UPDATE ".PREFIX."user_gameacc SET value='$value' WHERE userID='$id' AND gameaccID='$type'");

		echo'Your Gameaccount has been saved with your previous one in your log. Just wait a few seconds to be redirected!
	    	          <meta http-equiv="refresh" content="3; URL=index.php?site=user&id='.$id.'&gameacc=changelog#seegameaccounts">';
    }

if(isset($id) and getnickname($id) != '') {
	
	if(isbanned($id)) $banned = '<br /><div class="class="alert alert-danger""><center>'.$_language->module['is_banned'].'</center></div>';
	else $banned = '';

	//profil: stream
	if($action == "stream") {

	$ergebnis = safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$id."'"); 
	        $anz = mysql_num_rows($ergebnis);
		$ds = mysql_fetch_array($ergebnis);
                $nickname = $ds['nickname'];
		$clanhistory = clearfromtags($ds['clanhistory']);
		if($clanhistory == '') $clanhistory = $_language->module['n_a'];
		$clanname = clearfromtags($ds['clanname']);
		if($clanname == '') $clanname = $_language->module['n_a'];
		$clanirc = clearfromtags($ds['clanirc']);
		if($clanirc == '') $clanirc = $_language->module['n_a'];
		if($ds['clanhp'] == '') $clanhp = $_language->module['n_a'];
		else {
			if(stristr($ds['clanhp'],"http://")) $clanhp = '<a href="'.htmlspecialchars($ds['clanhp']).'" target="_blank" rel="nofollow">'.htmlspecialchars($ds['clanhp']).'</a>';
			else $clanhp = '<a href="http://'.htmlspecialchars($ds['clanhp']).'" target="_blank" rel="nofollow">'.htmlspecialchars($ds['clanhp']).'</a>';
		}
		$clantag = clearfromtags($ds['clantag']);
		if($clantag == '') $clantag = '';
		else $clantag = '('.$clantag.') ';

		eval("\$title_profile = \"".gettemplate("title_profile")."\";");
		echo $title_profile;

    $buddylist="";
    $mystream = safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$id."'");
		if(mysql_num_rows($mystream)) {
			while($db = mysql_fetch_array($mystream)) {
				$mystreamlink = $db['clanname'];
        
        if($db['clanname']) { $buddylist .= '<tr>
            <td>
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td><center><object type="application/x-shockwave-flash" height="300" width="390" id="live_embed_player_flash" data="http://en.twitch.tv/widgets/live_embed_player.swf?channel='.$mystreamlink.'" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://en.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=en.twitch.tv&channel='.$mystreamlink.'&auto_play=true&start_volume=25" /></object></center></td>
              </tr>
            </table>
            </td>
          </tr>'; }
            
			else $buddylist = '<tr>
        <td colspan="2" valign="top" style="padding: 5px"><center>No Stream Available</center></td>
      </tr>';
		} }
		

		eval("\$profile = \"".gettemplate("profile_buddys")."\";");
		echo $profile;

echo '</div>';

	}
	
	elseif($action == "content") {

		//profil: comments

		$ergebnis = safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$id."'"); 
	        $anz = mysql_num_rows($ergebnis);
		$ds = mysql_fetch_array($ergebnis);
                $nickname = $ds['nickname'];
		$clanhistory = clearfromtags($ds['clanhistory']);
		if($clanhistory == '') $clanhistory = $_language->module['n_a'];
		$clanname = clearfromtags($ds['clanname']);
		if($clanname == '') $clanname = $_language->module['n_a'];
		$clanirc = clearfromtags($ds['clanirc']);
		if($clanirc == '') $clanirc = $_language->module['n_a'];
		if($ds['clanhp'] == '') $clanhp = $_language->module['n_a'];
		else {
			if(stristr($ds['clanhp'],"http://")) $clanhp = '<a href="'.htmlspecialchars($ds['clanhp']).'" target="_blank" rel="nofollow">'.htmlspecialchars($ds['clanhp']).'</a>';
			else $clanhp = '<a href="http://'.htmlspecialchars($ds['clanhp']).'" target="_blank" rel="nofollow">'.htmlspecialchars($ds['clanhp']).'</a>';
		}
		$clantag = clearfromtags($ds['clantag']);
		if($clantag == '') $clantag = '';
		else $clantag = '('.$clantag.') ';

		eval("\$title_profile = \"".gettemplate("title_profile")."\";");
		echo $title_profile;

         $postlist="";
		$rcontent2=safe_query("SELECT * FROM ".PREFIX."comments WHERE userID='".$id."' AND type='mo' ORDER BY date DESC");
		if(mysql_num_rows($rcontent2)) {
			$n = 1;
			while($db = mysql_fetch_array($rcontent2)) {
				$posttime2 = date("d.m.y H:i", $db['date']);

            $postlist .= '<tr>
            <td width="50%" valign="top">
            <table width="100%" cellpadding="2" cellspacing="0">
              <tr>
                <td colspan="3" style="padding: 5px"><div style="overflow:hidden;">'.$posttime2.'<br /><a href="index.php?site=movies&action=show&id='.$db['parentID'].'"><b>'.clearfromtags($db['comment']).'</b></a><br /></div></td>
              </tr>
            </table>
            </td>
          </tr>'; 
			

				if($profilelast == $n) break;
				$n++;
			}
		}
		else $postlist= '<li>No Comments</li>
      </tr>';

		eval("\$profile = \"".gettemplate("profile_lastposts")."\";");
		echo $profile;

echo '</div>';

	}
	elseif($action == "guestbook") {

		//user guestbook

		if(isset($_POST['save'])) {

			$date = time();
			$ip = $GLOBALS['ip'];
			$run = 0;

			if($userID) {
				$name = getnickname($userID);
				if(getemailhide($userID)) $email='';
        else $email = getemail($userID);
				$url = gethomepage($userID);
				$icq = geticq($userID);
				$run = 1;
			}
			else {
				$name = $_POST['gbname'];
				$email = $_POST['gbemail'];
				$url = $_POST['gburl'];
				$icq = $_POST['icq'];
				$CAPCLASS = new Captcha;
				if($CAPCLASS->check_captcha($_POST['captcha'], $_POST['captcha_hash'])) $run = 1;
			}

			if($run) {

				safe_query("INSERT INTO ".PREFIX."user_gbook (userID, date, name, email, hp, icq, ip, comment)
								values('".$id."', '".$date."', '".$_POST['gbname']."', '".$_POST['gbemail']."', '".$_POST['gburl']."', '".$_POST['icq']."', '".$ip."', '".$_POST['message']."')");

				if($id != $userID) sendmessage($id, $_language->module['new_guestbook_entry'], str_replace('%guestbook_id%', $id, $_language->module['new_guestbook_entry_msg']));
			}
			redirect('index.php?site=user&amp;id='.$id.'&amp;action=guestbook','',0);
		}
		elseif(isset($_GET['delete'])) {
			if(!isanyadmin($userID) and $id != $userID) die($_language->module['no_access']);

			foreach($_POST['gbID'] as $gbook_id) {
				safe_query("DELETE FROM ".PREFIX."user_gbook WHERE gbID='$gbook_id'");
			}
			redirect('index.php?site=user&amp;id='.$id.'&amp;action=guestbook','',0);
		}
		else {
			eval("\$title_profile = \"".gettemplate("title_profile")."\";");
			echo $title_profile;

			$bg1 = BG_1;
			$bg2 = BG_2;

			$gesamt = mysql_num_rows(safe_query("SELECT gbID FROM ".PREFIX."user_gbook WHERE userID='".$id."'"));

			if(isset($_GET['page'])) $page = (int)$_GET['page'];
			$type="DESC";
			if(isset($_GET['type'])){
			  if(($_GET['type']=='ASC') || ($_GET['type']=='DESC')) $type=$_GET['type'];
			}

			$pages = 1;
			if(!isset($page)) $page = 1;
			if(!isset($type)) $type = "DESC";

			$max = $maxguestbook;
			$pages = ceil($gesamt/$max);

			if($pages > 1) $page_link = makepagelink("index.php?site=user&amp;id=".$id."&amp;action=guestbook&amp;type=".$type, $page, $pages);
			else $page_link='';

			if($page == "1") {
				$ergebnis = safe_query("SELECT * FROM ".PREFIX."user_gbook WHERE userID='".$id."' ORDER BY date ".$type." LIMIT 0, ".$max);
				if($type == "DESC") $n = $gesamt;
				else $n = 1;
			}
			else {
				$start = $page * $max - $max;
				$ergebnis = safe_query("SELECT * FROM ".PREFIX."user_gbook WHERE userID='".$id."' ORDER BY date ".$type." LIMIT ".$start.", ".$max);
				if($type == "DESC") $n = $gesamt - ($page - 1) * $max;
				else $n = ($page - 1) * $max + 1;
			}

			if($type=="ASC")
			$sorter='<a href="index.php?site=user&amp;id='.$id.'&amp;action=guestbook&amp;page='.$page.'&amp;type=DESC">'.$_language->module['sort'].':</a> <img src="images/icons/asc.gif" width="9" height="7" border="0" alt="" />&nbsp;&nbsp;&nbsp;';
			else
			$sorter='<a href="index.php?site=user&amp;id='.$id.'&amp;action=guestbook&amp;page='.$page.'&amp;type=ASC">'.$_language->module['sort'].':</a> <img src="images/icons/desc.gif" width="9" height="7" border="0" alt="" />&nbsp;&nbsp;&nbsp;';

			echo'<br /><table width="100%" cellspacing="0" cellpadding="2">
			  <tr>
			    <td>'.$sorter.' '.$page_link.'</td>
			    <td align="right"><input type="button" onclick="MM_goToURL(\'parent\',\'#addcomment\');return document.MM_returnValue" value="'.$_language->module['new_entry'].'" /></td>
			  </tr>
			</table>';

			echo '<form method="post" name="form" action="index.php?site=user&amp;id='.$id.'&amp;action=guestbook&amp;delete=true">';
			while ($ds = mysql_fetch_array($ergebnis)) {
				$n % 2 ? $bg1 = BG_1 : $bg1 = BG_2;
				$date = date("d.m.Y - H:i", $ds['date']);

				if(validate_email($ds['email'])) $email = '<a href="mailto:'.mail_protect($ds['email']).'"><img src="images/icons/email.gif" border="0" alt="'.$_language->module['email'].'" /></a>';
				else $email = '';

				if(validate_url($ds['hp'])) $hp = '<a href="'.$ds['hp'].'" target="_blank"><img src="images/icons/hp.gif" border="0" alt="'.$_language->module['homepage'].'" /></a>';
				else $hp = '';

				$sem = '/[0-9]{6,11}/si';
				$icq_number = str_replace('-', '', $ds['icq']);
				if(preg_match($sem, $icq_number)) $icq = '<a href="http://www.icq.com/people/about_me.php?uin='.$icq_number.'" target="_blank"><img src="http://online.mirabilis.com/scripts/online.dll?icq='.$icq_number.'&amp;img=5" border="0" alt="icq" /></a>';
				else $icq = "";

				$name = strip_tags($ds['name']);
				$message = cleartext($ds['comment']);
				$quotemessage = strip_tags($ds['comment']);
				$quotemessage = str_replace("'", "`", $quotemessage);

				$actions = '';
				$ip = $_language->module['logged'];
				$quote = '<a href="javascript:AddCode(\'[quote='.$name.']'.$quotemessage.'[/quote]\')"><img src="images/icons/quote.gif" border="0" alt="'.$_language->module['quote'].'" /></a>';
				if(isfeedbackadmin($userID) OR $id == $userID) {
					$actions = '<input class="input" type="checkbox" name="gbID[]" value="'.$ds['gbID'].'" />';
					if(isfeedbackadmin($userID)) $ip = $ds['ip'];
				}

				eval("\$profile_guestbook = \"".gettemplate("profile_guestbook")."\";");
				echo $profile_guestbook;

				if($type == "DESC") $n--;
				else $n++;
			}

			if(isfeedbackadmin($userID) || $userID == $id) $submit='<input class="input" type="checkbox" name="ALL" value="ALL" onclick="SelectAll(this.form);" /> '.$_language->module['select_all'].'
											  <input type="submit" value="'.$_language->module['delete_selected'].'" />';
											  else $submit='';
			echo'<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
	  		<td>'.$page_link.'</td>
	   		<td align="right">'.$submit.'</td>
			</tr>
			</table></form>';

			echo'<a name="addcomment"></a>';
			if($loggedin) {
				$name = getnickname($userID);
				if(getemailhide($userID)) $email='';
        else $email = getemail($userID);
				$url = gethomepage($userID);
				$icq = geticq($userID);
				$_language->read_module('bbcode', true);

				eval ("\$addbbcode = \"".gettemplate("addbbcode")."\";");
				eval("\$profile_guestbook_loggedin = \"".gettemplate("profile_guestbook_loggedin")."\";");
				echo $profile_guestbook_loggedin;
			}
			else {
				$CAPCLASS = new Captcha;
				$captcha = $CAPCLASS->create_captcha();
				$hash = $CAPCLASS->get_hash();
				$CAPCLASS->clear_oldcaptcha();
				$_language->read_module('bbcode', true);

				eval ("\$addbbcode = \"".gettemplate("addbbcode")."\";");
				eval("\$profile_guestbook_notloggedin = \"".gettemplate("profile_guestbook_notloggedin")."\";");
				echo $profile_guestbook_notloggedin;
			}
		}

	}
	else {

		//profil: home

		$date = time();
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$id."'");
		$anz = mysql_num_rows($ergebnis);
		$ds = mysql_fetch_array($ergebnis);

		if($userID != $id && $userID != 0) {
			safe_query("UPDATE ".PREFIX."user SET visits=visits+1 WHERE userID='".$id."'");
			if(mysql_num_rows(safe_query("SELECT visitID FROM ".PREFIX."user_visitors WHERE userID='".$id."' AND visitor='".$userID."'")))
			safe_query("UPDATE ".PREFIX."user_visitors SET date='".$date."' WHERE userID='".$id."' AND visitor='".$userID."'");
			else safe_query("INSERT INTO ".PREFIX."user_visitors (userID, visitor, date) values ('".$id."', '".$userID."', '".$date."')");
		}
		$anzvisits = $ds['visits'];
		if($ds['userpic']) $userpic = '<img src="images/userpics/'.$ds['userpic'].'" class="img-responsive center-block" alt="" width="150px" height="150px" />';
		else $userpic = '<img src="images/userpics/nouserpic.gif" class="img-responsive center-block" alt="" width="150px" height="150px" />';
		$nickname = $ds['nickname'];
		if(isclanmember($id)) $member = ' <img src="images/icons/member.gif" alt="'.$_language->module['clanmember'].'" />';
		else $member = '';
		$registered = date("d.m.Y - H:i", $ds['registerdate']);
				
		$time = time();
		$logintime = $ds['lastlogin'];

		$sec = $time - $logintime;
		$days = $sec / 86400;								// sekunden / (60*60*24)
		$days = mb_substr($days, 0, mb_strpos($days, "."));		// kommastelle

		$sec = $sec - $days * 86400;
		$hours = $sec / 3600;
		$hours = mb_substr($hours, 0, mb_strpos($hours, "."));

		$sec = $sec - $hours * 3600;
		$minutes = $sec / 60;
		$minutes = mb_substr($minutes, 0, mb_strpos($minutes, "."));
		if($time - $logintime < 60) {
			$now = "Online";
			$days = "";
			$hours = "";
			$minutes = "";
		}
		else {
			$now = '';
			if($days!=0){
			$days = 'Hace '.$days.' días';
			$hours = "";
			$minutes = "";
		}elseif($hours!=0){
			$days = "";
			$hours = 'Hace '.$hours.' horas';
			$minutes = "";
		}elseif($minutes!=0){
			$days = "";
			$hours = "";
			$minutes = 'Hace '.$minutes.' Minutos';
		}
		}
		
		$lastlogin = $now.$days.$hours.$minutes;
		
		
		if($ds['avatar']) $avatar = '<img src="images/avatars/'.$ds['avatar'].'" alt="" />';
		else $avatar = '<img src="images/avatars/noavatar.gif" border="0" alt="" />';
		$status = isonline($ds['userID']);
		if($loggedin) { $email = '<a href="mailto:'.$ds['email'].'"><img src="images/icons/email.gif" border="0" alt="'.$_language->module['email'].'" /></a>'; }
		else $email = '';
		$sem = '/[0-9]{4,11}/si';
		if(preg_match($sem, $ds['icq'])) $icq = '<a href="http://www.icq.com/people/about_me.php?uin='.sprintf('%d', $ds['icq']).'" target="_blank"><img src="http://online.mirabilis.com/scripts/online.dll?icq='.sprintf('%d', $ds['icq']).'&amp;img=5" border="0" alt="icq" /></a>';
		else $icq='';
		if($loggedin && $ds['userID'] != $userID) {
			$pm = '<a href="index.php?site=messenger&amp;action=touser&amp;touser='.$ds['userID'].'"><img src="images/icons/pm.gif" border="0" width="12" height="13" alt="messenger" /></a>';
			if(isignored($userID, $ds['userID'])) $buddy = '<a href="buddys.php?action=readd&amp;id='.$ds['userID'].'&amp;userID='.$userID.'"><img src="images/icons/buddy_readd.gif" border="0" alt="'.$_language->module['back_buddylist'].'" /></a>';
			elseif(isbuddy($userID, $ds['userID'])) $buddy = '<a href="buddys.php?action=ignore&amp;id='.$ds['userID'].'&amp;userID='.$userID.'"><img src="images/icons/buddy_ignore.gif" border="0" alt="'.$_language->module['ignore_user'].'" /></a>';
			elseif($userID == $ds['userID']) $buddy = '';
			else $buddy = '<a href="buddys.php?action=add&amp;id='.$ds['userID'].'&amp;userID='.$userID.'"><img src="images/icons/buddy_add.gif" border="0" alt="'.$_language->module['add_buddylist'].'" /></a>';
		}
		else $pm = '' & $buddy = '';

		if($ds['homepage']!='') {
			if(stristr($ds['homepage'],"http://")) $homepage = '<a href="'.htmlspecialchars($ds['homepage']).'" target="_blank" rel="nofollow">'.htmlspecialchars($ds['homepage']).'</a>';
			else $homepage = '<a href="http://'.htmlspecialchars($ds['homepage']).'" target="_blank" rel="nofollow">http://'.htmlspecialchars($ds['homepage']).'</a>';
		}
		else $homepage = $_language->module['n_a'];

		$clanhistory = clearfromtags($ds['clanhistory']);
		if($clanhistory == '') $clanhistory = $_language->module['n_a'];
		
		$steamid = clearfromtags($ds['steamid']);
		if($steamid == '') $steamid = $_language->module['n_a'];
		
		$clanname = clearfromtags($ds['clanname']);
		if($clanname == '') $clanname = $_language->module['n_a'];
		$clanirc = clearfromtags($ds['clanirc']);
		if($clanirc == '') $clanirc = $_language->module['n_a'];
		if($ds['clanhp'] == '') $clanhp = $_language->module['n_a'];
		else {
			if(stristr($ds['clanhp'],"http://")) $clanhp = '<a href="'.htmlspecialchars($ds['clanhp']).'" target="_blank" rel="nofollow">'.htmlspecialchars($ds['clanhp']).'</a>';
			else $clanhp = '<a href="http://'.htmlspecialchars($ds['clanhp']).'" target="_blank" rel="nofollow">'.htmlspecialchars($ds['clanhp']).'</a>';
		}
		$clantag = clearfromtags($ds['clantag']);
		if($clantag == '') $clantag = '';
		else $clantag = '('.$clantag.') ';

		$firstname = clearfromtags($ds['firstname']);
		$lastname = clearfromtags($ds['lastname']);

		$birthday = mb_substr($ds['birthday'], 0, 10);
		$birthday = date("d.m.Y",strtotime($birthday));
		
		$res = safe_query("SELECT birthday, DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW()) - TO_DAYS(birthday)), '%Y') 'age' FROM ".PREFIX."user WHERE userID = '".$id."'");
		$cur = mysql_fetch_array($res);
		$birthday = ''.(int)$cur['age'].' '.$_language->module['years'].'';
		$bbday = '('.$birthday.')';

		if($ds['sex'] == "f") $sex = $_language->module['female'];
		elseif($ds['sex'] == "m") $sex = $_language->module['male'];
		else $sex = $_language->module['unknown'];
		$flag = '[flag]'.$ds['country'].'[/flag]';
		$profilecountry = flags($flag);
		$town = clearfromtags($ds['town']);
		if($town == '') $town = $_language->module['n_a'];
		$cpu = clearfromtags($ds['cpu']);
		if($cpu == '') $cpu = $_language->module['n_a'];
		$mainboard = clearfromtags($ds['mainboard']);
		if($mainboard == '') $mainboard = $_language->module['n_a'];
		$ram = clearfromtags($ds['ram']);
		if($ram == '') $ram = $_language->module['n_a'];
		$monitor = clearfromtags($ds['monitor']);
		if($monitor == '') $monitor = $_language->module['n_a'];
		$graphiccard = clearfromtags($ds['graphiccard']);
		if($graphiccard == '') $graphiccard = $_language->module['n_a'];
		$soundcard = clearfromtags($ds['soundcard']);
		if($soundcard == '') $soundcard = $_language->module['n_a'];
		$connection = clearfromtags($ds['verbindung']);
		if($connection == '') $connection = $_language->module['n_a'];
		$keyboard = clearfromtags($ds['keyboard']);
		if($keyboard == '') $keyboard = $_language->module['n_a'];
		$mouse = clearfromtags($ds['mouse']);
		if($mouse == '') $mouse = $_language->module['n_a'];
		$mousepad = clearfromtags($ds['mousepad']);
		if($mousepad == '') $mousepad = $_language->module['n_a'];

		$anznewsposts = getusernewsposts($ds['userID']);
		$anzforumtopics = getuserforumtopics($ds['userID']);
		$anzforumposts = getuserforumposts($ds['userID']);

		$erg = safe_query("SELECT * FROM ".PREFIX."teams_members WHERE userID='".$id."'");
		$n=1;
		if(mysql_num_rows($erg)) { 
			while($info_teams=mysql_fetch_array($erg)) {
			
				$team = getteamname($info_teams['teamID']);
				$team_logo = getteamlogo($info_teams['teamID']);
				$team_country = '[flag]'.getteamcountry($info_teams['teamID']).'[/flag]';
				$tcountry = flags($team_country);
		
				$position = $info_teams['position'];
				$win = $info_teams['win'];
				$lost = $info_teams['lost'];
				$draw = $info_teams['draw'];
				
				$query_teams .= '<div style="float: left"><img src="images/teams/'.$team_logo.'" width="50px" /></div><div style="float: left; margin: 5px 0px 0px 10px;"><a href="team/'.$info_teams['teamID'].'">'.$tcountry.' '.$team.'</a><br \> <b>Rank:</b> '.$position.'</div><div id="clear" style="height: 5px"></div>';
		         
			$n++;
			}
		}
		else $query_teams = '<div style="float: left">No equipos</div>'; 	
		
		$commentslist="";
		$rcontent=safe_query("SELECT * FROM ".PREFIX."comments WHERE userID='".$id."' AND (type='ne' or type='ma') ORDER BY date DESC LIMIT 0,5");
		if(mysql_num_rows($rcontent)) {
			$n = 1;
			while($db = mysql_fetch_array($rcontent)) {
					$posttime = date("d.m.y H:i", $db['date']);
					$commentt=clearfromtags($db['comment']);
					if(mb_strlen($commentt)>35) {
						$commentt=mb_substr($commentt, 0, 35);
						$commentt.='...';
					}
					$type=$db['type'];
					$league = getleaguenamepro($db['parentID']);
					
					if($type =='ne') { 
						$articlee = 'News > '.getarticlename($db['parentID']);
						$url = 'index.php?site=article&newsID='.$db['parentID'].'';
					}
					else { 
						$articlee = 'Match > '.getleaguename($league);
						$url = 'match/'.$db['parentID'].'';						
					}
					
					if(mb_strlen($articlee)>48) {
						$articlee=mb_substr($articlee, 0, 48);
						$articlee.='...';
					}
			
                    $commentslist .= '<div style="margin-top: 5px; border-bottom: 1px solid #ddd; padding-bottom: 5px;"><a href="'.$url.'"><b>'.$commentt.'</b></a> ('.$posttime.')<br \> <small>'.$articlee.'</small></div>'; 

}}
		else $commentslist = '<div>
        No Comments
      </div>';
	  
	  $topiclist="";
		$rcontent=safe_query("SELECT * FROM ".PREFIX."forum_posts WHERE poster='".$id."' ORDER BY date DESC LIMIT 0,5");
		if(mysql_num_rows($rcontent)) {
			$n = 1;
			while($db = mysql_fetch_array($rcontent)) {
					$posttime = date("d.m.y H:i", $db['date']);
					$commentt=clearfromtags($db['message']);
					if(mb_strlen($commentt)>35) {
						$commentt=mb_substr($commentt, 0, 35);
						$commentt.='...';
					}
					
					$artt = ''.getboardname($db['boardID']).'';
					$articlee = ''.$artt.' > '.gettopicname($db['topicID']).'';
					$url = 'index.php?site=forum_topic&id='.$db['topicID'].'';						
					
					if(mb_strlen($articlee)>50) {
						$articlee=mb_substr($articlee, 0, 50);
						$articlee.='...';
					}
			
                    $topiclist .= '<div style="margin-top: 5px; border-bottom: 1px solid #ddd; padding-bottom: 5px;"><a href="'.$url.'"><b>'.$commentt.'</b></a> ('.$posttime.')<br \> <small> '.$articlee.'</small></div>'; 

}}
		else $topiclist = '<div>
        No Comments
      </div>';
		
		$comments = array();
		$comments[] = getusercomments($ds['userID'], 'ne');
		$comments[] = getusercomments($ds['userID'], 'cw');
		$comments[] = getusercomments($ds['userID'], 'ar');
		$comments[] = getusercomments($ds['userID'], 'de');
		$comments[] = getusercomments($ds['userID'], 'ma');
		$comments[] = getusernewsrecomments($ds['userID']);
		
		$cc = ($comments[0]+$comments[5]);
		
		$pmgot = 0;
		$pmgot = $ds['pmgot'];

		$pmsent = 0;
		$pmsent = $ds['pmsent'];

		if($ds['about']) $about = cleartext($ds['about']);
		else $about = $_language->module['n_a'];

		##### GAMEACCOUNT #####
		
		if($_GET['gameacc'] == 'changelog'){
			
		   $gameacc_tit = "Gameaccounts History<br \>";

		   $gamelog = '

			 <tr>
			  <td align="center" width="50%" bgcolor="'.$bg2.'" colspan="2"><strong>Type</strong></td>
		          <td align="center" width="50%" bgcolor="'.$bg2.'" colspan="9"><strong>Old Value</strong></td>
		         </tr>'; 
		    
		}else{

		   $gameacc_tit = "Gameaccounts";
		
		}
		
		$gameacclog = safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id' && log='1' ORDER BY type");
		while($dl=mysql_fetch_array($gameacclog)) {
		
		if(mysql_num_rows($gameacclog) && $_GET['gameacc']!='changelog') {
		
		    if($userID==$id) { 
		          $userhas = 'You have'; 
		          $noaccounts = '(<a href="index.php?site=myprofile&action=gameaccounts">Add Gameaccount?</a>)';
		    }
		    else{ 		
		          $userhas = 'This user has'; 
			  $noaccounts = '';
		    }	

	          $ingamelog = ''.$userhas.' previous entered gameaccounts of the same type. Click <a href="index.php?site=user&id='.$id.'&gameacc=changelog#seegameaccounts">here</a> to view.'; 	
		}
		
		$getvalue=safe_query("SELECT type FROM ".PREFIX."gameacc WHERE gameaccID='".$dl[type]."'");
	        $dp = mysql_fetch_array($getvalue);
		
		if(isset($_GET['gameacc']) && $_GET['gameacc']=='changelog'){
		
		   $gamelog.='<tr>
                                <td align="center" bgcolor="'.BG_1.'" colspan="2">'.$dp['type'].'</td>
                                <td align="center" bgcolor="'.BG_1.'" colspan="9">'.$dl['value'].'</td>
                              </tr>';                     
		  }
		}
		
		if($_GET['gameacc']=='changelog') { 
		        $gamelog.='<tr><td class="title" colspan="12">Current Gameaccounts</td></tr>';
	        }

		$game1=safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id' && log='0' ORDER BY type");
		$cs = ($userID==$id ? 2 : 5);
						
if(mysql_num_rows($game1)) {

      $game4 = '<tr>
		  <td class="title" colspan="12">'.$gameacc_tit.' '.$addgacc.'</td>
		</tr>
		<tr>
		  <td bgcolor="'.$pagebg.'" colspan="12"><a name="seegameaccounts"></a>'.$ingamelog.' </td>
		</tr>
		'.$gamelog.'
		 <tr>
		  <td align="center" width="50%" bgcolor="'.$bg2.'" colspan="2"><strong>Type</strong></td>
		  <td align="center" width="50%" bgcolor="'.$bg2.'" colspan="'.$cs.'"><strong>Current Value</strong></td>
		  '.$usergameacchead.'
		  '.$deletegacchead.'
		</tr> 
		  <tr>
		    <td colspan="12" bgcolor="'.$pagebg.'"></td>
		</tr>';

    $n=1;
	while($db=mysql_fetch_array($game1)) {
	
		$game3=safe_query("SELECT type FROM ".PREFIX."gameacc WHERE gameaccID='".$db[type]."'");
	    $dp = mysql_fetch_array($game3);
	 
		$n%2 ? $bgcolor=BG_1 : $bgcolor=BG_2;
			 
		$game4.='<tr>
		           <td align="center" bgcolor="'.BG_1.'" colspan="2">'.$dp[type].'</td>
		           <td align="center" bgcolor="'.BG_1.'" colspan="'.$cs.'">'.$db[value].'</td>
		           '.$usergameacccont.'
		           '.$deletegacchead.'
		         </tr>';
		$n++;
	}$game4.='';
} 
else $game4.='No Game Account yet.';
		
		
		$lastvisits="";
		$visitors = safe_query("SELECT v.*, u.nickname, u.country FROM ".PREFIX."user_visitors v JOIN ".PREFIX."user u ON u.userID = v.visitor WHERE v.userID='".$id."' ORDER BY v.date DESC LIMIT 0,5");
		if(mysql_num_rows($visitors)) {
			$n = 1;
			while($dv = mysql_fetch_array($visitors)) {
				$n % 2 ? $bgcolor = BG_1 : $bgcolor = BG_2;
				$flag = '[flag]'.$dv['country'].'[/flag]';
				$country = flags($flag);
				$nicknamevisitor = $dv['nickname'];
				if(isonline($dv['visitor']) == "offline") $statuspic = '<img src="images/icons/offline.gif" alt="'.$_language->module['offline'].'" />';
				else $statuspic = '<img src="images/icons/online.gif" alt="'.$_language->module['online'].'" />';
				$time = time();
				$visittime = $dv['date'];

				$sec = $time - $visittime;
				$days = $sec / 86400;								// sekunden / (60*60*24)
				$days = mb_substr($days, 0, mb_strpos($days, "."));		// kommastelle

				$sec = $sec - $days * 86400;
				$hours = $sec / 3600;
				$hours = mb_substr($hours, 0, mb_strpos($hours, "."));

				$sec = $sec - $hours * 3600;
				$minutes = $sec / 60;
				$minutes = mb_substr($minutes, 0, mb_strpos($minutes, "."));

				if($time - $visittime < 60) {
					$now = $_language->module['now'];
					$days = "";
					$hours = "";
					$minutes = "";
				}
				else {
					$now = '';
					$days == 0 ? $days = "" : $days = $days.'d';
					$hours == 0 ? $hours = "" : $hours = $hours.'h';
					$minutes == 0 ? $minutes = "" : $minutes = $minutes.'m';
				}

				$lastvisits .= '<li><a href="index.php?site=user&amp;id='.$dv['visitor'].'">'.$country.' <b>'.$nicknamevisitor.'</b> <span>'.$now.$days.$hours.$minutes.'</span></a></li>';
				$n++;
			}
		}
		else $lastvisits = '<li>'.$_language->module['no_visits'].'</li>';

		eval ("\$title_profile = \"".gettemplate("title_profile")."\";");
		echo $title_profile;

		eval("\$profile = \"".gettemplate("profile")."\";");
		echo $profile;

	}


}
else redirect('index.php', $_language->module['user_doesnt_exist'],3);
?>