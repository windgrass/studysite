<?php

$_language->read_module('badword');

if(!isanyadmin($userID) OR substr(basename($_SERVER[REQUEST_URI]),0,15) != "admincenter.php") die(''.$_language->module['access_denied'].'');

if($_GET['actions']=='save') {
	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		$badword = safe_query("SELECT * FROM ".PREFIX."badword WHERE badword='".$_POST['badword']."'");
		if (!mysql_num_rows($badword)) {
			safe_query("INSERT INTO ".PREFIX."badword (badword) values( '".$_POST['badword']."') ");
		}
		else {
			echo 'Badword bereits vorhanden';
		}
	} else echo $_language->module['transaction_invalid'];

}
elseif($_GET['action']=='saveedit') {
	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		safe_query("UPDATE ".PREFIX."badword SET badword='".$_POST['badword']."' WHERE badwordID='".$_POST['badwordID']."'");
	} else echo $_language->module['transaction_invalid'];

}
elseif($_GET['delete']) {
  $badwordID = $_GET['badwordID'];
	safe_query("DELETE FROM ".PREFIX."badword WHERE badwordID='$badwordID'");
}


if($_GET['action']=="add") {

	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	
    echo'<form method="post" action="admincenter.php?site=badword&actions=save" enctype="multipart/form-data">
	     <table cellpadding="3" cellspacing="1" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Add Badword</td>
    </tr>
		 <tr>
		   <td>'.$_language->module['badword'].':</td>
		   <td><input type="text" name="badword" size="27" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
		 </tr>
		 <tr>
		   <td>&nbsp;</td>
		   <input type="hidden" name="captcha_hash" value="'.$hash.'" />
		   <td><input type="submit" name="save" value="'.$_language->module['addbadword'].'"></td>
		 </tr>
		 </table>
		 </form>';
}
elseif($_GET['action']=="edit") {

	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	
  $badwordID = $_GET['badwordID'];
  $ergebnis=safe_query("SELECT * FROM ".PREFIX."badword WHERE badwordID='$badwordID'");
	$ds=mysql_fetch_array($ergebnis);
	
	echo'<form method="post" action="admincenter.php?site=badword&action=saveedit" enctype="multipart/form-data">
	     <table cellpadding="3" cellspacing="1" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Edit Badword</td>
    </tr>
		 <tr>
		   <td>'.$_language->module['badword'].':</td>
		   <td><input type="text" name="badword" size="32" value="'.$ds['badword'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
		 </tr>
		 <tr>
		   <td>
		   <input type="hidden" name="captcha_hash" value="'.$hash.'" />
		   <input type="hidden" name="badwordID" value="'.$ds['badwordID'].'"></td>
		   <td><input type="submit" name="saveedit" value="'.$_language->module['editbadword'].'"></td>
		 </tr>
		 </table>
		 </form>';
}

elseif($_GET['action']=='import_xml') {
chdir('badwords');
if (file_exists("badwords.xml")) {
	unlink('badwords.xml');
		if (file_exists("badwords.xml")) {
			echo $_language->module['manual_delete'];
		}
}
else {

	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();

	if ($_POST['upload']) {
		chdir('..');	
			$file = $_FILES['file'];
			$path = 'badwords/';
			$des = $path.$file['name'];
			if(!file_exists($des)) {
				if(move_uploaded_file($file['tmp_name'], $des)) {
					$file_name = $file['name'];
					$filesize = $file['size'];
					@chmod($des, 777);
				}
			}

		chdir('badwords');
		$filename = $file['name'];
		if(file_exists($filename)) {
			$xml = simplexml_load_file($filename);
		
			if($xml) {
				foreach($xml->badword AS $bad) {
					$abfrage = mysql_query("INSERT IGNORE INTO ".PREFIX."badword (badword)
                                VALUES ('".$bad."')");
		
				}
				echo mysql_affected_rows().' '.$_language->module['badwords_added'];
				redirect("admincenter.php?site=badword","",2);
			}
		}
	}
	else {
		echo '<form method="post" action="admincenter.php?site=badword&action=import_xml" enctype="multipart/form-data">
				<input type="file" name="file" /><br /><br />
				<input type="hidden" name="captcha_hash" value="'.$hash.'" />
				<input type="submit" name="upload" value="'.$_language->module['xml_up'].'" />
			</form>';
	}
}
}
else {


	
	$type="ASC";
	if(isset($_GET['type'])){
	  if(($_GET['type']=='ASC') || ($_GET['type']=='DESC')) { $type=$_GET['type']; }
	}

	echo'<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=badword&action=add\');return document.MM_returnValue" value="'.$_language->module['addbadword'].'"><br /><br />';

	if($_GET['sort']=='badword') {
			$ergebnis=safe_query("SELECT * FROM ".PREFIX."badword ORDER BY badword $type");
	}
	elseif($_GET['sort']=='anz') {
			$ergebnis=safe_query("SELECT * FROM ".PREFIX."badword ORDER BY anz $type");
	}
	else {
		$ergebnis=safe_query("SELECT * FROM ".PREFIX."badword ORDER BY badword");
	}

	
			if(!isset($_GET['sort'])) $_GET['sort'] = '';
		if($type=="ASC")
		$sorter='<a href="admincenter.php?site=badword&amp;sort='.$sort.'&amp;type=DESC">'.$_language->module['to_sort'].':</a> <img src="../images/icons/asc.gif" width="9" height="7" border="0" alt="" />&nbsp;&nbsp;&nbsp;';
		else
		$sorter='<a href="admincenter.php?site=badword&amp;sort='.$sort.'&amp;type=ASC">'.$_language->module['to_sort'].':</a> <img src="../images/icons/desc.gif" width="9" height="7" border="0" alt="" />&nbsp;&nbsp;&nbsp;';
		
	echo $sorter.'<br /><table width="100%" cellpadding="3" cellspacing="1" class="table table-hover">
   		<tr>
   		<td width="40%" class="title"><a href="admincenter.php?site=badword&amp;type='.$type.'&amp;sort=badword">'.$_language->module['badwords'].'</td>
   		<td width="20%" class="title"><a href="admincenter.php?site=badword&amp;type='.$type.'&amp;sort=anz">'.$_language->module['anz'].'</td>
   		<td width="20%" class="title" align="center">'.$_language->module['actions'].'</td>
   		</tr>';
		
	while($ds=mysql_fetch_array($ergebnis)) {
    	echo'<tr bgcolor="#FFFFFF" valign="top">
	       		<td>'.$ds['badword'].'</td>
	       		<td>'.$ds['anz'].'</td>
		   	<td align="center"><img src="images/icons/adminicons/edit.gif" alt="'.$_language->module['edit'].'" width="16" height="16" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=badword&action=edit&badwordID='.$ds['badwordID'].'\');return document.MM_returnValue"> <img src="images/icons/adminicons/delete.gif" alt="'.$_language->module['delete'].'" width="16" height="16" onClick="MM_confirm(\''.$_language->module['deletebadword'].'\', \'admincenter.php?site=badword&delete=true&badwordID='.$ds['badwordID'].'\')"></td>
		 	</tr>';
	}
	echo'</table>';
		echo'<br><table border="0" cellpadding="0" cellspacing="0">
<tr height="17">
 <td width="20px" align="center"><img src="images/icons/adminicons/edit.gif" border="0" alt="'.$_language->module['edit'].'"></td>
 <td>'.$_language->module['edit'].'</td>
 <td width="25">
 <td width="20px" align="center"><img src="images/icons/adminicons/delete.gif" border="0" alt="'.$_language->module['delete'].'"></td>
 <td>'.$_language->module['delete'].'</td>
</tr>
</table>';
}	
?>