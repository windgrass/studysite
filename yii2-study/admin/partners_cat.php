<?php

$_language->read_module('partners');

if(!isnewsadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

if(isset($_POST['save'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		$pic = $_FILES['pic'];
		if(checkforempty(Array('name'))) {
			safe_query("INSERT INTO ".PREFIX."partners_cat ( category ) values( '".$_POST['name']."' ) ");
			$id=mysql_insert_id();
		
			$filepath = "../images/partners_cat/";
			
			if($pic['name'] != "") {
				move_uploaded_file($pic['tmp_name'], $filepath.$pic['name'].".tmp");
				@chmod($filepath.$pic['name'].".tmp", 0755);
				$getimg = getimagesize($filepath.$pic['name'].".tmp");
				$catpic = '';
				if($getimg[2] == 1) $catpic=$id.'.gif';
				elseif($getimg[2] == 2) $catpic=$id.'.jpg';
				elseif($getimg[2] == 3) $catpic=$id.'.png';
				if($catpic != "") {
					if(file_exists($filepath.$id.'.gif')) unlink($filepath.$id.'.gif');
					if(file_exists($filepath.$id.'.jpg')) unlink($filepath.$id.'.jpg');
					if(file_exists($filepath.$id.'.png')) unlink($filepath.$id.'.png');
					rename($filepath.$pic['name'].".tmp", $filepath.$catpic);
					safe_query("UPDATE ".PREFIX."partners_cat SET pic='".$catpic."' WHERE partnercatID='".$id."'");
				}  else {
					@unlink($filepath.$pic['name'].".tmp");
					$error = $_language->module['format_incorrect'];
					die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=partners_cat&amp;action=edit&amp;partnercatID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
				}
			}
		} else echo $_language->module['information_incomplete'];
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_POST['saveedit'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		$pic = $_FILES['pic'];
		if(checkforempty(Array('name'))) {
			safe_query("UPDATE ".PREFIX."partners_cat SET category='".$_POST['name']."' WHERE partnercatID='".$_POST['partnercatID']."'");
		
			$id=$_POST['partnercatID'];
			$filepath = "../images/partners_cat/";
			
			if($pic['name'] != "") {
				move_uploaded_file($pic['tmp_name'], $filepath.$pic['name'].".tmp");
				@chmod($filepath.$pic['name'].".tmp", 0755);
				$getimg = getimagesize($filepath.$pic['name'].".tmp");
				$catpic = '';
				if($getimg[2] == 1) $catpic=$id.'.gif';
				elseif($getimg[2] == 2) $catpic=$id.'.jpg';
				elseif($getimg[2] == 3) $catpic=$id.'.png';
				if($catpic != "") {
					if(file_exists($filepath.$id.'.gif')) unlink($filepath.$id.'.gif');
					elseif(file_exists($filepath.$id.'.jpg')) unlink($filepath.$id.'.jpg');
					elseif(file_exists($filepath.$id.'.png')) unlink($filepath.$id.'.png');
					rename($filepath.$pic['name'].".tmp", $filepath.$catpic);
					safe_query("UPDATE ".PREFIX."partners_cat SET pic='".$catpic."' WHERE partnercatID='".$id."'");
				}  else {
					@unlink($filepath.$pic['name'].".tmp");
					$error = $_language->module['format_incorrect'];
					die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=partners_cat&amp;action=edit&amp;partnercatID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
				}
			}
		} else echo $_language->module['information_incomplete'];
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_GET['delete'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_GET['captcha_hash'])) {
		$partnercatID = $_GET['partnercatID'];
		$filepath = "../images/partners_cat/";
		safe_query("DELETE FROM ".PREFIX."partners_cat WHERE partnercatID='$partnercatID'");
		if(file_exists($filepath.$partnercatID.'.gif')) @unlink($filepath.$partnercatID.'.gif');
		if(file_exists($filepath.$partnercatID.'.jpg')) @unlink($filepath.$partnercatID.'.jpg');
		if(file_exists($filepath.$partnercatID.'.png')) @unlink($filepath.$partnercatID.'.png');
	} else echo $_language->module['transaction_invalid'];
}

if(isset($_GET['action'])) $action = $_GET['action'];
else $action = '';

if($action=="add") {
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();

	echo'<script type="text/javascript" src="../assets/js/jscolor/jscolor.js"></script>
	<form method="post" action="admincenter.php?site=partners_cat" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">New Category</td>
    </tr>
    <tr>
      <td width="15%"><b>Partner Category</b></td>
      <td width="85%"><input type="text" name="name" size="60" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['picture_upload'].'</b></td>
      <td><input name="pic" type="file" size="40" /></td>
    </tr>
    <tr>
      <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /></td>
      <td><input type="submit" name="save" value="Add Category" /></td>
    </tr>
  </table>
  </form>';
}

elseif($action=="edit") {
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();

	$partnercatID = $_GET['partnercatID'];
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."partners_cat WHERE partnercatID='$partnercatID'");
	$ds=mysql_fetch_array($ergebnis);

	echo'<script type="text/javascript" src="../assets/js/jscolor/jscolor.js"></script>
	<form method="post" action="admincenter.php?site=partners_cat" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Edit Category</td>
    </tr>
    <tr>
      <td width="15%"><b>Partner Category</b></td>
      <td width="85%"><input type="text" name="name" size="60" value="'.getinput($ds['category']).'" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['picture'].'</b></td>
      <td><img src="../images/partners_cat/'.$ds['pic'].'" alt="" /></td>
    </tr>
    <tr>
		   <td><b>'.$_language->module['picture_upload'].'</b></td>
       <td><input name="pic" type="file" size="40" /></td>
     </tr>
     <tr>
      <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="partnercatID" value="'.$ds['partnercatID'].'" /></td>
      <td><input type="submit" name="saveedit" value="Edit" /></td>
    </tr>
  </table>
  </form>';
}

else {

	echo'<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=partners_cat&amp;action=add\');return document.MM_returnValue" value="New Category" /><br /><br />';

	$ergebnis=safe_query("SELECT * FROM ".PREFIX."partners_cat ORDER BY category");
	
  echo'<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td width="25%" class="title"><b>Name</b></td>
      <td width="55%" class="title"><b>'.$_language->module['picture'].'</b></td>
      <td width="20%" class="title"><b>'.$_language->module['actions'].'</b></td>
   		</tr>';
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	$i=1;
  while($ds=mysql_fetch_array($ergebnis)) {
    if($i%2) { $td='td1'; }
    else { $td='td2'; }
    
		echo'<tr>
      <td class="'.$td.'">'.getinput($ds['category']).'</td>
      <td class="'.$td.'" align="center"><img src="../images/partners_cat/'.$ds['pic'].'" alt="" /></td>
      <td class="'.$td.'" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=partners_cat&amp;action=edit&amp;partnercatID='.$ds['partnercatID'].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" />
      <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'admincenter.php?site=partners_cat&amp;delete=true&amp;partnercatID='.$ds['partnercatID'].'&amp;captcha_hash='.$hash.'\')" value="'.$_language->module['delete'].'" /></td>
    </tr>';
      
      $i++;
	}
	echo'</table>';
}
?>