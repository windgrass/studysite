<?php

$_language->read_module('products');

if(!isnewsadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

if(isset($_POST['save'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		$pic = $_FILES['pic'];
		if(checkforempty(Array('name'))) {
			safe_query("INSERT INTO ".PREFIX."products_cat ( category, cat_small ) values( '".$_POST['name']."', '".$_POST['cat_small']."' ) ");
			$id=mysql_insert_id();
		
			$filepath = "../images/products_cat/";
			
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
					safe_query("UPDATE ".PREFIX."products_cat SET pic='".$catpic."' WHERE productscatID='".$id."'");
				}  else {
					@unlink($filepath.$pic['name'].".tmp");
					$error = $_language->module['format_incorrect'];
					die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products_cat&amp;action=edit&amp;productscatID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
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
			safe_query("UPDATE ".PREFIX."products_cat SET category='".$_POST['name']."', cat_small='".$_POST['cat_small']."' WHERE productscatID='".$_POST['productscatID']."'");
		
			$id=$_POST['productscatID'];
			$filepath = "../images/products_cat/";
			
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
					safe_query("UPDATE ".PREFIX."products_cat SET pic='".$catpic."' WHERE productscatID='".$id."'");
				}  else {
					@unlink($filepath.$pic['name'].".tmp");
					$error = $_language->module['format_incorrect'];
					die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products_cat&amp;action=edit&amp;productscatID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
				}
			}
		} else echo $_language->module['information_incomplete'];
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_GET['delete'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_GET['captcha_hash'])) {
		$productscatID = $_GET['productscatID'];
		$filepath = "../images/products_cat/";
		safe_query("DELETE FROM ".PREFIX."products_cat WHERE productscatID='$productscatID'");
		if(file_exists($filepath.$productscatID.'.gif')) @unlink($filepath.$productscatID.'.gif');
		if(file_exists($filepath.$productscatID.'.jpg')) @unlink($filepath.$productscatID.'.jpg');
		if(file_exists($filepath.$productscatID.'.png')) @unlink($filepath.$productscatID.'.png');
	} else echo $_language->module['transaction_invalid'];
}

if(isset($_GET['action'])) $action = $_GET['action'];
else $action = '';

if($action=="add") {
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();

	echo'<script type="text/javascript" src="../assets/js/jscolor/jscolor.js"></script>
	<form method="post" action="admincenter.php?site=products_cat" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">New Category</td>
    </tr>
    <tr>
      <td width="15%"><b>Product Category</b></td>
      <td width="85%"><input type="text" name="name" size="60" /></td>
    </tr>
	<tr>
      <td width="15%"><b>Product Category small name</b></td>
      <td width="85%"><input type="text" name="cat_small" maxlength="5" size="5" /></td>
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

	$productscatID = $_GET['productscatID'];
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."products_cat WHERE productscatID='$productscatID'");
	$ds=mysql_fetch_array($ergebnis);

	echo'<script type="text/javascript" src="../assets/js/jscolor/jscolor.js"></script>
	<form method="post" action="admincenter.php?site=products_cat" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Edit Category</td>
    </tr>
    <tr>
      <td width="15%"><b>Product Category</b></td>
      <td width="85%"><input type="text" name="name" size="60" value="'.getinput($ds['category']).'" /></td>
    </tr>
	<tr>
      <td width="15%"><b>Product Category small name</b></td>
      <td width="85%"><input type="text" name="cat_small" value="'.getinput($ds['cat_small']).'" maxlength="5" size="5" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['picture'].'</b></td>
      <td><img src="../images/products_cat/'.$ds['pic'].'" alt="" /></td>
    </tr>
    <tr>
		   <td><b>'.$_language->module['picture_upload'].'</b></td>
       <td><input name="pic" type="file" size="40" /></td>
     </tr>
     <tr>
      <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="productscatID" value="'.$ds['productscatID'].'" /></td>
      <td><input type="submit" name="saveedit" value="Edit" /></td>
    </tr>
  </table>
  </form>';
}

else {

	echo'<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=products_cat&amp;action=add\');return document.MM_returnValue" value="New Category" /><br /><br />';

	$ergebnis=safe_query("SELECT * FROM ".PREFIX."products_cat ORDER BY category");
	
  echo'<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td width="25%" class="title"><b>Name</b></td>
	  <td width="25%" class="title"><b>Small name</b></td>
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
	  <td class="'.$td.'">'.getinput($ds['cat_small']).'</td>
      <td class="'.$td.'" align="center"><img src="../images/products_cat/'.$ds['pic'].'" alt="" /></td>
      <td class="'.$td.'" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=products_cat&amp;action=edit&amp;productscatID='.$ds['productscatID'].'\');return document.MM_returnValue" value="Edit" />
      <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'admincenter.php?site=products_cat&amp;delete=true&amp;productscatID='.$ds['productscatID'].'&amp;captcha_hash='.$hash.'\')" value="Delete" /></td>
    </tr>';
      
      $i++;
	}
	echo'</table>';
}
?>