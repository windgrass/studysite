<?php

$_language->read_module('static');

if(!ispageadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

if(isset($_POST['save'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		if(isset($_POST['staticID']) and $_POST['staticID']) {
			safe_query("UPDATE `".PREFIX."static` SET name='".$_POST['name']."', accesslevel='".$_POST['accesslevel']."', content='".$_POST['message']."' WHERE staticID='".$_POST['staticID']."'");
			$id = $_POST['staticID'];
		}
		else {
			safe_query("INSERT INTO `".PREFIX."static` ( `name`, `accesslevel`,`content` ) values( '".$_POST['name']."', '".$_POST['accesslevel']."','".$_POST['message']."' ) ");
			$id = mysql_insert_id();
		}
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_GET['delete'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_GET['captcha_hash'])) {
		safe_query("DELETE FROM `".PREFIX."static` WHERE staticID='".$_GET['staticID']."'");
	} else echo $_language->module['transaction_invalid'];
}

if(isset($_GET['action']) and $_GET['action'] == "add") {
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
  $_language->read_module('bbcode', true);
	
  echo '<script language="JavaScript" type="text/javascript">
					<!--
						function chkFormular() {
							if(!validbbcode(document.getElementById(\'message\').value, \'admin\')){
								return false;
							}
						}
					-->
				</script>';
  
  echo'<form method="post" id="post" name="post" action="admincenter.php?site=static" enctype="post" onsubmit="return chkFormular();">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['add_static_page'].'</td>
    </tr>
    <tr>
      <td width="15%"><b>'.$_language->module['title'].'</b></td>
      <td width="85%"><input type="text" name="name" size="60" value="new" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['accesslevel'].'</b></td>
      <td><input name="accesslevel" type="radio" value="0" checked="checked" /> '.$_language->module['public'].'<br />
      <input name="accesslevel" type="radio" value="1" /> '.$_language->module['registered_only'].'<br />
		<input name="accesslevel" type="radio" value="2" /> Members Only</td>
    </tr>
  </table>
  <br /><b>'.$_language->module['content'].'</b><br /><small>'.$_language->module['you_can_use_html'].'</small><br /><br />';
  
  eval ("\$addbbcode = \"".gettemplate("addbbcode", "html", "admin")."\";");
  eval ("\$addflags = \"".gettemplate("flags_admin", "html", "admin")."\";");
  
  echo'<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
		      <tr>
		        <td valign="top">'.$addbbcode.'</td>
		        <td valign="top">'.$addflags.'</td>
		      </tr>
		    </table>';
    
  echo '<br /><textarea id="message" name="message" rows="20" cols="" style="width: 100%;"></textarea>
  <input type="hidden" name="captcha_hash" value="'.$hash.'" />
  <br /><br /><input type="submit" name="save" value="'.$_language->module['add_static_page'].'" />
  </form>';
  
}

elseif(isset($_GET['action']) and $_GET['action'] == "edit") {
	
	$_language->read_module('bbcode', true);
	
  $staticID = $_GET['staticID'];
	$ergebnis=safe_query("SELECT * FROM `".PREFIX."static` WHERE staticID='".$staticID."'");
	$ds=mysql_fetch_array($ergebnis);
	$content = getinput($ds['content']);
	
	$clanmember = "";
	$user = "";
	$public = "";
	if($ds['accesslevel'] == 2) $clanmember = "checked=\"checked\"";
	elseif($ds['accesslevel'] == 1) $user = "checked=\"checked\"";
	else $public = "checked=\"checked\"";

	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	
	echo '<script language="JavaScript" type="text/javascript">
					<!--
						function chkFormular() {
							if(!validbbcode(document.getElementById(\'message\').value, \'admin\')){
								return false;
							}
						}
					-->
				</script>';

	echo '<form method="post" id="post" name="post" action="admincenter.php?site=static" enctype="post" onsubmit="return chkFormular();">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['add_static_page'].'</td>
    </tr>
    <tr>
      <td width="15%"><b>'.$_language->module['title'].'</b></td>
      <td width="85%"><input type="text" name="name" size="60" value="'.getinput($ds['name']).'" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['accesslevel'].'</b></td>
      <td><input name="accesslevel" type="radio" value="0" '.$public.' /> '.$_language->module['public'].'<br />
      <input name="accesslevel" type="radio" value="1" '.$user.' /> '.$_language->module['registered_only'].'<br />
      <input name="accesslevel" type="radio" value="2" '.$clanmember.' /> '.$_language->module['clanmember_only'].'</td>
    </tr>
  </table>
  <br /><b>'.$_language->module['content'].'</b><br /><small>'.$_language->module['you_can_use_html'].'</small><br /><br />';
  
	eval ("\$addbbcode = \"".gettemplate("addbbcode", "html", "admin")."\";");
  eval ("\$addflags = \"".gettemplate("flags_admin", "html", "admin")."\";");
  
  echo'<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
		      <tr>
		        <td valign="top">'.$addbbcode.'</td>
		        <td valign="top">'.$addflags.'</td>
		      </tr>
		</table>
	<textarea id="message" name="message" rows="20" cols="" style="width: 100%;">'.$content.'</textarea>
	<br /><br /><input type="hidden" name="captcha_hash" value="'.$hash.'" />
	<input type="hidden" name="staticID" value="'.$staticID.'" />
	<input type="submit" name="save" value="'.$_language->module['edit_static_page'].'" />
	</form>';
}

else {
	 
  echo'<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=static&amp;action=add\');return document.MM_returnValue" value="'.$_language->module['new_static_page'].'" /><br /><br />';

	$ergebnis=safe_query("SELECT * FROM ".PREFIX."static ORDER BY staticID");
	
  echo'<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td width="8%" class="title"><b>'.$_language->module['id'].'</b></td>
      <td width="47%" class="title"><b>'.$_language->module['title'].'</b></td>
      <td width="25%" class="title"><b>'.$_language->module['accesslevel'].'</b></td>
      <td width="20%" class="title"><b>'.$_language->module['actions'].'</b></td>
    </tr>';

	$i=1;
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
  
  while($ds=mysql_fetch_array($ergebnis)) {
    if($i%2) { $td='td1'; }
    else { $td='td2'; }
  
    if($ds['accesslevel'] == 2) $accesslevel = $_language->module['clanmember_only'];
	  elseif($ds['accesslevel'] == 1) $accesslevel = $_language->module['registered_only'];
	  elseif($ds['accesslevel'] == 0) $accesslevel = $_language->module['public'];
  
		echo'<tr>
      <td class="'.$td.'" align="center">'.$ds['staticID'].'</td>
      <td class="'.$td.'"><a href="../index.php?site=static&amp;staticID='.$ds['staticID'].'" target="_blank">'.getinput($ds['name']).'</a></td>
      <td class="'.$td.'">'.$accesslevel.'</td>
      <td class="'.$td.'" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=static&amp;action=edit&amp;staticID='.$ds['staticID'].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" />
      <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'admincenter.php?site=static&amp;delete=true&amp;staticID='.$ds['staticID'].'&amp;captcha_hash='.$hash.'\')" value="'.$_language->module['delete'].'" /></td>
    </tr>';
    
    $i++;
	}
	echo'</table>';
}
?>