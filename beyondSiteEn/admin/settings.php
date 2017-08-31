<?php

$_language->read_module('settings');

if(!ispageadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

if(isset($_POST['submit'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		safe_query("UPDATE ".PREFIX."settings SET hpurl='".$_POST['url']."',
									 facebook='".$_POST['facebook']."',
									 twitter='".$_POST['twitter']."',
									 youtube='".$_POST['youtube']."',
									 twitch='".$_POST['twitch']."',
									 clanname='".$_POST['clanname']."',
									 clantag='".$_POST['clantag']."',
									 adminname='".$_POST['admname']."',
									 adminemail='".$_POST['admmail']."',
									 news='".$_POST['news']."',
									 newsarchiv='".$_POST['newsarchiv']."',
									 headlines='".$_POST['headlines']."',
									 headlineschars='".$_POST['headlineschars']."',
									 topnewschars='".$_POST['topnewschars']."',
									 articles='".$_POST['articles']."',
									 latestarticles='".$_POST['latestart']."',
									 articleschars='".$_POST['articlesch']."',
									 clanwars='".$_POST['clanwars']."',
									 results='".$_POST['results']."',
									 upcoming='".$_POST['upcoming']."',
									 shoutbox='".$_POST['shoutbox']."',
									 sball='".$_POST['sball']."',
									 sbrefresh='".$_POST['refresh']."',
									 topics='".$_POST['topics']."',
									 posts='".$_POST['posts']."',
									 latesttopics='".$_POST['latesttopics']."',
									 latesttopicchars='".$_POST['latesttopicchars']."',
									 awards='".$_POST['awards']."',
									 demos='".$_POST['demos']."',
									 guestbook='".$_POST['guestbook']."',
									 feedback='".$_POST['feedback']."',
									 messages='".$_POST['messages']."',
									 users='".$_POST['users']."',
									 sessionduration='".$_POST['sessionduration']."',
									 gb_info='".isset($_POST['gb_info'])."',
									 picsize_l='".$_POST['picsize_l']."',
									 picsize_h='".$_POST['picsize_h']."',
									 pictures='".$_POST['pictures']."',
									 publicadmin='".isset($_POST['publicadmin'])."',
									 thumbwidth='".$_POST['thumbwidth']."',
									 usergalleries='".isset($_POST['usergalleries'])."',
									 maxusergalleries='".($_POST['maxusergalleries']*1024*1024)."',
									 profilelast='".$_POST['lastposts']."',
									 default_language='".$_POST['language']."',
									 insertlinks='".isset($_POST['insertlinks'])."',
									 search_min_len='".$_POST['searchminlen']."',
									 max_wrong_pw='".intval($_POST['max_wrong_pw'])."',
									 captcha_type='".intval($_POST['captcha_type'])."',
									 captcha_bgcol='".$_POST['captcha_bgcol']."',
									 captcha_fontcol='".$_POST['captcha_fontcol']."',
									 captcha_math='".$_POST['captcha_math']."',
									 captcha_noise='".$_POST['captcha_noise']."',
									 captcha_linenoise='".$_POST['captcha_linenoise']."',
									 autoresize='".$_POST['autoresize']."'");
		safe_query("UPDATE ".PREFIX."styles SET title='".$_POST['title']."' ");	
	  	redirect("admincenter.php?site=settings","",0);
	} else redirect("admincenter.php?site=settings",$_language->module['transaction_invalid'],3);
}

else {

	$settings=safe_query("SELECT * FROM ".PREFIX."settings");
	$ds=mysql_fetch_array($settings);

	$styles=safe_query("SELECT * FROM ".PREFIX."styles");
	$dt=mysql_fetch_array($styles);

	if($ds['gb_info']) $gb_info='<input type="checkbox" name="gb_info" value="1" checked="checked" onmouseover="showWMTT(\'id36\')" onmouseout="hideWMTT()" />';
	else $gb_info='<input type="checkbox" name="gb_info" value="1" onmouseover="showWMTT(\'id36\')" onmouseout="hideWMTT()" />';

	if($ds['publicadmin']) $publicadmin = " checked=\"checked\"";
	else $publicadmin = "";
	if($ds['usergalleries']) $usergalleries = " checked=\"checked\"";
	else $usergalleries = "";

	$langdirs = '';
	$filepath = "../languages/";
	if ($dh = opendir($filepath)) {
		while($file = mb_substr(readdir($dh), 0,2)) {
			if($file!="." AND $file!=".." AND is_dir($filepath.$file)) $langdirs .= '<option value="'.$file.'">'.$file.'</option>';
		}
		closedir($dh);
	}
	$lang = $ds['default_language'];
	$langdirs = str_replace('"'.$lang.'"', '"'.$lang.'" selected="selected"', $langdirs);
  
  	if($ds['insertlinks']) $insertlinks='<input type="checkbox" name="insertlinks" value="1" checked="checked" onmouseover="showWMTT(\'id41\')" onmouseout="hideWMTT()" />';
	else $insertlinks='<input type="checkbox" name="insertlinks" value="1" onmouseover="showWMTT(\'id41\')" onmouseout="hideWMTT()" />';
  	
	$captcha_style = "<option value='0'>".$_language->module['captcha_only_text']."</option><option value='2'>".$_language->module['captcha_both']."</option><option value='1'>".$_language->module['captcha_only_math']."</option>";
	$captcha_style = str_replace("value='".$ds['captcha_math']."'","value='".$ds['captcha_math']."' selected='selected'",$captcha_style);
	
	$captcha_type = "<option value='0'>".$_language->module['captcha_text']."</option><option value='2'>".$_language->module['captcha_autodetect']."</option><option value='1'>".$_language->module['captcha_image']."</option>";
	$captcha_type = str_replace("value='".$ds['captcha_type']."'","value='".$ds['captcha_type']."' selected='selected'",$captcha_type);
	
	$autoresize = "<option value='0'>".$_language->module['autoresize_off']."</option><option value='2'>".$_language->module['autoresize_js']."</option><option value='1'>".$_language->module['autoresize_php']."</option>";
	$autoresize = str_replace("value='".$ds['autoresize']."'","value='".$ds['autoresize']."' selected='selected'",$autoresize);
	
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
?>

<form method="post" action="admincenter.php?site=settings">
<div class="tooltip" id="id1"><?php echo $_language->module['tooltip_1']; ?> '<?php echo $_SERVER['HTTP_HOST']; ?>'</div>
<div class="tooltip" id="id2"><?php echo $_language->module['tooltip_2']; ?></div>
<div class="tooltip" id="id3"><?php echo $_language->module['tooltip_3']; ?></div>
<div class="tooltip" id="id4"><?php echo $_language->module['tooltip_4']; ?></div>
<div class="tooltip" id="id5"><?php echo $_language->module['tooltip_5']; ?></div>
<div class="tooltip" id="id6"><?php echo $_language->module['tooltip_6']; ?></div>
<div class="tooltip" id="id7"><?php echo $_language->module['tooltip_7']; ?></div>
<div class="tooltip" id="id8"><?php echo $_language->module['tooltip_8']; ?></div>
<div class="tooltip" id="id9"><?php echo $_language->module['tooltip_9']; ?></div>
<div class="tooltip" id="id10"><?php echo $_language->module['tooltip_10']; ?></div>
<div class="tooltip" id="id11"><?php echo $_language->module['tooltip_11']; ?></div>
<div class="tooltip" id="id12"><?php echo $_language->module['tooltip_12']; ?></div>
<div class="tooltip" id="id13"><?php echo $_language->module['tooltip_13']; ?></div>
<div class="tooltip" id="id14"><?php echo $_language->module['tooltip_14']; ?></div>
<div class="tooltip" id="id15"><?php echo $_language->module['tooltip_15']; ?></div>
<div class="tooltip" id="id16"><?php echo $_language->module['tooltip_16']; ?></div>
<div class="tooltip" id="id17"><?php echo $_language->module['tooltip_17']; ?></div>
<div class="tooltip" id="id18"><?php echo $_language->module['tooltip_18']; ?></div>
<div class="tooltip" id="id19"><?php echo $_language->module['tooltip_19']; ?></div>
<div class="tooltip" id="id20"><?php echo $_language->module['tooltip_20']; ?></div>
<div class="tooltip" id="id21"><?php echo $_language->module['tooltip_21']; ?></div>
<div class="tooltip" id="id22"><?php echo $_language->module['tooltip_22']; ?></div>
<div class="tooltip" id="id23"><?php echo $_language->module['tooltip_23']; ?></div>
<div class="tooltip" id="id24"><?php echo $_language->module['tooltip_24']; ?></div>
<div class="tooltip" id="id25"><?php echo $_language->module['tooltip_25']; ?></div>
<div class="tooltip" id="id26"><?php echo $_language->module['tooltip_26']; ?></div>
<div class="tooltip" id="id27"><?php echo $_language->module['tooltip_27']; ?></div>
<div class="tooltip" id="id28"><?php echo $_language->module['tooltip_28']; ?></div>
<div class="tooltip" id="id29"><?php echo $_language->module['tooltip_29']; ?></div>
<div class="tooltip" id="id30"><?php echo $_language->module['tooltip_30']; ?></div>
<div class="tooltip" id="id31"><?php echo $_language->module['tooltip_31']; ?></div>
<div class="tooltip" id="id32"><?php echo $_language->module['tooltip_32']; ?></div>
<div class="tooltip" id="id33"><?php echo $_language->module['tooltip_33']; ?></div>
<div class="tooltip" id="id34"><?php echo $_language->module['tooltip_34']; ?></div>
<div class="tooltip" id="id35"><?php echo $_language->module['tooltip_35']; ?></div>
<div class="tooltip" id="id36"><?php echo $_language->module['tooltip_36']; ?></div>
<div class="tooltip" id="id37"><?php echo $_language->module['tooltip_37']; ?></div>
<div class="tooltip" id="id38"><?php echo $_language->module['tooltip_38']; ?></div>
<div class="tooltip" id="id39"><?php echo $_language->module['tooltip_39']; ?></div>
<div class="tooltip" id="id40"><?php echo $_language->module['tooltip_40']; ?></div>
<div class="tooltip" id="id41"><?php echo $_language->module['tooltip_41']; ?></div>
<div class="tooltip" id="id42"><?php echo $_language->module['tooltip_42']; ?></div>
<div class="tooltip" id="id43"><?php echo $_language->module['tooltip_43']; ?></div>
<div class="tooltip" id="id44"><?php echo $_language->module['tooltip_44']; ?></div>
<div class="tooltip" id="id45"><?php echo $_language->module['tooltip_45']; ?></div>
<div class="tooltip" id="id46"><?php echo $_language->module['tooltip_46']; ?></div>
<div class="tooltip" id="id47"><?php echo $_language->module['tooltip_47']; ?></div>
<div class="tooltip" id="id48"><?php echo $_language->module['tooltip_48']; ?></div>
<div class="tooltip" id="id49"><?php echo $_language->module['tooltip_49']; ?></div>
<div class="tooltip" id="id50"><?php echo $_language->module['tooltip_50']; ?></div>
<div class="tooltip" id="id51"><?php echo $_language->module['tooltip_51']; ?></div>
<div class="tooltip" id="id52">Enter your Facebook url. ie: http://www.facebook.com/myfacebookpage. Use always http:// at the beginning of the url </div>
<div class="tooltip" id="id53">Enter your Twitter url. ie: http://www.twitter.com/mytwitteraccount. Use always http:// at the beginning of the url.</div>
<div class="tooltip" id="id54">Enter your Youtube url. ie: http://www.youtube.com/myyoutubechannel. Use always http:// at the beginning of the url.</div>
<div class="tooltip" id="id55">Enter your Twitch url. ie: http://www.twitch.com/mytwitchchannel. Use always http:// at the beginning of the url.</div>

<div style="width: 100%;float: left;">
	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
	  <tr>
	    <td colspan="2" style="background-color: #4f5259; color: #FFFFFF"><b>Frontpage Options:</b></td>
	  </tr>
    <tr>
	    <td width="130px"><b><?php echo $_language->module['page_title']; ?></b></td>
    <td><input name="title" type="text" value="<?php echo getinput($dt['title']); ?>" size="35" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_2']; ?></span></td>
	  </tr>
	  <tr>
	    <td ><b><?php echo $_language->module['page_url']; ?></b></td>
    <td><input type="text" name="url" value="<?php echo getinput($ds['hpurl']); ?>" size="35" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_1']; ?></span></td>
	  </tr>
    <tr>
    	<td><b>Company Name</b></td>
    <td><input type="text" name="clanname" value="<?php echo getinput($ds['clanname']); ?>" size="35" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_3']; ?></span></td>
	  </tr>
  	  <tr>
	    <td><b><?php echo $_language->module['admin_name']; ?></b></td>
    <td><input type="text" name="admname" value="<?php echo getinput($ds['adminname']); ?>" size="35" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_5']; ?></span></td>
	  </tr>
  	  <tr>
    <td><b><?php echo $_language->module['admin_email']; ?></b></td>
    <td><input type="text" name="admmail" value="<?php echo getinput($ds['adminemail']); ?>" size="35" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_6']; ?></span></td>
	  </tr>
	</table>
</div>

<div style="width: 100%;float: left;">
	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
	  <tr>
	    <td colspan="2" style="background-color: #4f5259; color: #FFFFFF"><b>Social Networks:</b></td>
	  </tr>
    <tr>
	    <td width="130px"><b>Facebook Url</b></td>
    <td><input type="text" name="facebook" value="<?php echo getinput($ds['facebook']); ?>" size="35" onmouseover="showWMTT('id52')" onmouseout="hideWMTT()" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px">Enter your Facebook url. e.g.: http://www.facebook.com/myfacebookpage. Use always http:// at the beginning of the url</span></td>
	  </tr>
	  <tr>
	    <td><b>Twitter Url</b></td>
    <td><input type="text" name="twitter" value="<?php echo getinput($ds['twitter']); ?>" size="35" onmouseover="showWMTT('id53')" onmouseout="hideWMTT()" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px">Enter your Twitter url. e.g.: http://www.twitter.com/mytwitteraccount. Use always http:// at the beginning of the url.</span></td>
	  </tr>
    <tr>
	    <td><b>Youtube Url</b></td>
    <td><input type="text" name="youtube" value="<?php echo getinput($ds['youtube']); ?>" size="35" onmouseover="showWMTT('id54')" onmouseout="hideWMTT()" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px">Enter your Youtube url. e.g.: http://www.youtube.com/myyoutubechannel. Use always http:// at the beginning of the url.</span></td>
	  </tr>
    <tr>
	    <td><b>Twitch Url</b></td>
    <td><input type="text" name="twitch" value="<?php echo getinput($ds['twitch']); ?>" size="35" onmouseover="showWMTT('id55')" onmouseout="hideWMTT()" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px">Enter your Twitch url. e.g.: http://www.twitch.com/mytwitchchannel. Use always http:// at the beginning of the url.</span></td>
	  </tr>
	</table>
</div>

<div style="width: 100%;float: left;">
	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
	  <tr>
	    <td colspan="2" style="background-color: #4f5259; color: #FFFFFF"><b><?php echo $_language->module['news']; ?>:</b></td>
	  </tr>
    <tr>
	    <td width="130px" style="font-weight: bold"><?php echo $_language->module['news']; ?></td>
	    <td><input name="news" type="text" value="<?php echo $ds['news']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_7']; ?></span></td>
	  </tr>
	  <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['archive']; ?></td>
	    <td><input name="newsarchiv" type="text" value="<?php echo $ds['newsarchiv']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_10']; ?></span></td>
	  </tr>
    <tr>
	<td style="font-weight: bold"><?php echo $_language->module['headlines']; ?></td>
      	<td ><input type="text" name="headlines" value="<?php echo $ds['headlines']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_13']; ?></span></td>
	  </tr>
    <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['max_length_headlines']; ?></td>
	    <td ><input type="text" name="headlineschars" value="<?php echo $ds['headlineschars']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_6']; ?></span></td>
	  </tr>
  	  <!--<tr>
	    <td style="font-weight: bold"><?php echo $_language->module['max_length_topnews']; ?></td>
	    <td ><input type="text" name="topnewschars" value="<?php echo $ds['topnewschars']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_51']; ?></span></td>
	  </tr>-->
	</table>
</div>
<!--
<div style="width: 100%;float: left;">
	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
	  <tr>
	    <td colspan="2" style="background-color: #4f5259; color: #FFFFFF"><b><?php echo $_language->module['captcha']; ?>:</b></td>
	  </tr>
    <tr>
	    <td width="130px" style="font-weight: bold"><?php echo $_language->module['captcha_type']; ?></td>
	    <td ><select name="captcha_type"><?php echo $captcha_type;?></select>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_44']; ?></span></td>
	  </tr>
	  <tr>
	  	<td style="font-weight: bold"><?php echo $_language->module['captcha_bgcol']; ?></td>
	    <td ><input type="text" name="captcha_bgcol" size="7" value="<?php echo $ds['captcha_bgcol']; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_45']; ?></span></td>
	  </tr>
    <tr>
	  	<td style="font-weight: bold"><?php echo $_language->module['captcha_fontcol']; ?></td>
	    <td ><input type="text" name="captcha_fontcol" size="7" value="<?php echo $ds['captcha_fontcol']; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_46']; ?></span></td>
	  </tr>
    <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['captcha_style']; ?></td>
	    <td><select name="captcha_math"><?php echo $captcha_style;?></select>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_47']; ?></span></td>
	  </tr>
    <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['captcha_noise']; ?></td>
	    <td><input type="text" name="captcha_noise" size="3" value="<?php echo $ds['captcha_noise']; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_48']; ?></span></td>
	  </tr>
    <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['captcha_linenoise']; ?></td>
	    <td><input type="text" name="captcha_linenoise" size="3" value="<?php echo $ds['captcha_linenoise']; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_49']; ?></span></td>
	  </tr>
	</table>
</div>

<div style="width: 100%;float: left;">
	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
	  <tr>
	    <td colspan="2" style="background-color: #4f5259; color: #FFFFFF"><b><?php echo $_language->module['forum']; ?>:</b></td>
	  </tr>
    <tr>
	    <td width="130px" style="font-weight: bold"><?php echo $_language->module['forum_topics']; ?></td>
	    <td><input type="text" name="topics" value="<?php echo $ds['topics']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_8']; ?></span></td>
	  </tr>
	  <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['forum_posts']; ?></td>
	    <td><input type="text" name="posts" value="<?php echo $ds['posts']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_11']; ?></span></td>
	  </tr>
    <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['latest_topics']; ?></td>
	    <td><input type="text" name="latesttopics" value="<?php echo $ds['latesttopics']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_14']; ?></span></td>
	  </tr>
  	  <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['max_length_latest_topics']; ?></td>
	    <td><input type="text" name="latesttopicchars" value="<?php echo $ds['latesttopicchars']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_42']; ?></span></td>
	  </tr>
	</table>
</div>
-->

<div style="width: 100%;float: left;">
	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
	  <tr>
	    <td colspan="2" style="background-color: #4f5259; color: #FFFFFF"><b><?php echo $_language->module['other']; ?>:</b></td>
	  </tr>
    <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['login_duration']; ?></td>
	    <td ><input type="text" name="sessionduration" value="<?php echo $ds['sessionduration']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_33']; ?></span></td>
	  </tr>
    <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['insert_links']; ?></td>
	    <td ><?php echo $insertlinks; ?>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_41']; ?></span></td>
	  </tr>
    <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['search_min_length']; ?></td>
	    <td ><input type="text" name="searchminlen" value="<?php echo $ds['search_min_len']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_17']; ?></span></td>
	  </tr>
    <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['max_wrong_pw']; ?></td>
	    <td ><input type="text" name="max_wrong_pw" value="<?php echo $ds['max_wrong_pw']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_43']; ?></span></td>
	  </tr>
	  <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['content_size']; ?></td>
	    <td ><input type="text" name="picsize_l" value="<?php echo $ds['picsize_l']; ?>" size="3" /> x <input type="text" name="picsize_h" value="<?php echo $ds['picsize_h']; ?>" size="3" />&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_34']; ?> x <?php echo $_language->module['tooltip_35']; ?></span></td>
	  </tr>
    <tr>
	    <td style="font-weight: bold"><?php echo $_language->module['autoresize']; ?></td>
	    <td ><select name="autoresize"><?php echo $autoresize;?></select>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-info"></i>&nbsp;&nbsp;<span style="font-size: 12px"><?php echo $_language->module['tooltip_50']; ?></span></td>
	  </tr>
	  <!--<tr>
		<td style="font-weight: bold"><?php echo $_language->module['default_language']; ?></td>
		<td align="left"><select name="language" onmouseover="showWMTT('id40')" onmouseout="hideWMTT()"><?php echo $langdirs; ?></select></td>
	  </tr>-->
	</table>
</div>

<div style="clear: both; text-align: right; padding-top: 20px;">
  <input type="hidden" name="captcha_hash" value="<?php echo $hash; ?>" />
  <input type="submit" name="submit" value="<?php echo $_language->module['update']; ?>" />
</div>
</form>
<?php
}
?>