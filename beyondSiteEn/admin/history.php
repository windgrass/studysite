<?php

$_language->read_module('history');

if(!ispageadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

if(isset($_POST['submit'])) {
	$history = $_POST['message'];
	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		if(mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."history")))
			safe_query("UPDATE ".PREFIX."history SET history='".$history."'");
		else safe_query("INSERT INTO ".PREFIX."history (history) values( '".$history."') ");
	} else echo $_language->module['transaction_invalid'];
}
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."history");
	$ds=mysql_fetch_array($ergebnis);
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	
	$_language->read_module('bbcode', true);
	
	eval ("\$addbbcode = \"".gettemplate("addbbcode", "html", "admin")."\";");
  eval ("\$addflags = \"".gettemplate("flags_admin", "html", "admin")."\";");
	
  echo '<script language="JavaScript" type="text/javascript">
					<!--
						function chkFormular() {
							if(!validbbcode(document.getElementById(\'message\').value, \'admin\')){
								return false;
							}
						}
					-->
				</script>';
  
	echo'<form method="post" id="post" name="post" action="admincenter.php?site=history" onsubmit="return chkFormular();">
        <b>'.$_language->module['history'].'</b><br /><small>'.$_language->module['you_can_use_html'].'</small><br /><br />';
  
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover">
		      <tr>
		        <td valign="top">'.$addbbcode.'</td>
		        <td valign="top">'.$addflags.'</td>
		      </tr>
		    </table>';
	
	echo '<br /><textarea id="message" rows="30" cols="" name="message" style="width: 100%;">'.getinput($ds['history']).'</textarea>
  <br /><br /><input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="submit" name="submit" value="'.$_language->module['update'].'" />
  </form>';
?>