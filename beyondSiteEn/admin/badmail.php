<?php

$_language->read_module('badmail');

if(!isanyadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

if(isset($_GET['action'])) $action = $_GET['action'];
else $action = '';

if($action=="add") {
	
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	echo'<h1>&curren; <a href="admincenter.php?site=badmail" class="white">'.$_language->module['badmail'].'</a> &raquo; '.$_language->module['badmailadd'].'</h1>';
	
	echo'<form method="post" action="admincenter.php?site=badmail&amp;actions=save" enctype="multipart/form-data">
                        <table cellpadding="3" cellspacing="1" class="table table-hover">
                                <tr>
                                        <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['badmailadd'].'</td>
                                </tr>

		   		<tr>
		   	 		<td>'.$_language->module['badmail'].':</td>
					<td><input type="text" name="badmail" size="60" maxlength="255" /></td>
		 		</tr>
		 		<tr>
		   	  		<td><input type="hidden" name="captcha_hash" value="'.$hash.'" /></td>
		   	  		<td><input type="submit" name="save" value="'.$_language->module['addbadmail'].'"></td>
		 		</tr>
			</table>
		</form>';
}

elseif($action=="edit") {
	
  	$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."badmail WHERE badmailID='".$_GET["badmailID"]."'"));
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
		
	echo'<form method="post" action="admincenter.php?site=badmail&amp;action=saveedit" enctype="multipart/form-data">
			<input type="hidden" name="badmailID" value="'.$ds['badmailID'].'">
                        <table cellpadding="3" cellspacing="1" class="table table-hover">
                                <tr>
                                        <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['badmailadd'].'</td>
                                </tr>
		 		<tr>
		   			<td>'.$_language->module['badmail'].':</td>
					<td><input type="text" name="badmail" size="32" maxlength="255" value="'.getinput($ds['badmail']).'" />
		 		</tr>
		 		<tr>
					<td><input type="hidden" name="captcha_hash" value="'.$hash.'" /></td>
		   			<td><input type="submit" name="saveedit" value="'.$_language->module['editbadmail'].'"></td>
		 		</tr>
		 	</table>
		</form>';
}

elseif(isset($_POST['save'])) {
	$badmail=$_POST["badmail"];
	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		safe_query("INSERT INTO ".PREFIX."badmail (badmailID, badmail) values('', '".$badmail."')");
		redirect("admincenter.php?site=badmail","",0);
	} else echo $_language->module['transaction_invalid'];	
}

elseif(isset($_POST["saveedit"])) {
	$badmail=$_POST["badmail"];
	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		safe_query("UPDATE ".PREFIX."badmail SET badmail='".$badmail."' WHERE badmailID='".$_POST["badmailID"]."'");
	    redirect("admincenter.php?site=badmail","",0);
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_GET["delete"])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_GET['captcha_hash'])) {
		safe_query("DELETE FROM ".PREFIX."badmail WHERE badmailID='".$_GET["badmailID"]."'");
		redirect("admincenter.php?site=badmail","",0);
	} else echo $_language->module['transaction_invalid'];
}

else {
	
	echo'<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=badmail&amp;action=add\');return document.MM_returnValue" value="'.$_language->module['addbadmail'].'"><br><br>';
	
	  echo'<form method="post" action="admincenter.php?site=badmail">
    <table cellpadding="3" cellspacing="1" class="table table-hover">
    <tr>
      <td width="60%" class="title"><b>'.$_language->module['badmails'].'</b></td>
      <td width="40%" class="title" align="center"><b>'.$_language->module['actions'].'</b></td>
    </tr>';
  
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."badmail ORDER BY badmail");
	$anz=mysql_num_rows($ergebnis);
	if($anz) {
		
    $i=1;
    $CAPCLASS = new Captcha;
    $CAPCLASS->create_transaction();
    $hash = $CAPCLASS->get_hash();
    
    while($ds = mysql_fetch_array($ergebnis)) {
      if($i%2) { $td='td1'; }
      else { $td='td2'; }
      			
      echo'<tr>
        <td class="'.$td.'">'.getinput($ds['badmail']).'</td>
        <td class="'.$td.'" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=badmail&amp;action=edit&amp;badmailID='.$ds['badmailID'].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" />
        <input type="button" onclick="MM_confirm(\''.$_language->module['deletebadmail'].'\', \'admincenter.php?site=badmail&amp;delete=true&amp;badmailID='.$ds['badmailID'].'&amp;captcha_hash='.$hash.'\')" value="'.$_language->module['delete'].'" /></td>
      </tr>';
      
      $i++;
		}
	}
  else echo'<tr><td class="td1" colspan="5">'.$_language->module['no_entries'].'</td></tr>';
	
  echo '</table>
  </form>';
}	
?>