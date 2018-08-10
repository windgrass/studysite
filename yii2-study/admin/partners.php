<?php

$_language->read_module('partners');
	include("_mysql.php");
	include("_settings.php");
	include("_functions.php");
	
if(!ispageadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);
		

if(isset($_GET['delete'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_GET['captcha_hash'])) {
		$partnerID = $_GET['partnerID'];
		safe_query(" DELETE FROM ".PREFIX."partners WHERE partnerID='$partnerID' ");
		$filepath = "../images/partners/";
		if(file_exists($filepath.$partnerID.'.gif')) unlink($filepath.$partnerID.'.gif');
		if(file_exists($filepath.$partnerID.'.jpg')) unlink($filepath.$partnerID.'.jpg');
		if(file_exists($filepath.$partnerID.'.png')) unlink($filepath.$partnerID.'.png');
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_POST['sortieren'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		$sort = $_POST['sort'];
		foreach($sort as $sortstring) {
			$sorter=explode("-", $sortstring);
			safe_query("UPDATE ".PREFIX."partners SET sort='$sorter[1]' WHERE partnerID='$sorter[0]' ");
		}
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_POST['save'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		$name = $_POST['name'];
		$url = $_POST['url'];
		$pos_x = $_POST['pos_x'];
		$pos_y = $_POST['pos_y'];
		$descr = $_POST['descr'];
		
		$partnercatID = $_POST['partnercatID'];
		
		$partners_cat='';
		$cat=safe_query("SELECT partnercatID, category FROM ".PREFIX."partners_cat ORDER BY category");
		while($dr=mysql_fetch_array($cat)) {
			$partners_cat.='<option value="'.$dr['partnercatID'].'">'.$dr['category'].'</option>';
		}
		
		$banner = $_FILES['banner'];
		if(isset($_POST["displayed"])) $displayed = $_POST['displayed'];
		else $displayed="";
		if(!$displayed) $displayed=0;
			
		safe_query("INSERT INTO ".PREFIX."partners ( name, partnercatID, pos_x, pos_y, descr, url, displayed, date, sort )
		             values( '$name', '$partnercatID', '$pos_x', '$pos_y', '$descr', '$url', '".$displayed."', '".time()."', '1' )");
		$id=mysql_insert_id();
	
		$filepath = "../images/partners/";
		
		if($banner['name'] != "") {
			move_uploaded_file($banner['tmp_name'], $filepath.$banner['name'].".tmp");
			@chmod($filepath.$banner['name'].".tmp", 0755);
			$getimg = getimagesize($filepath.$banner['name'].".tmp");
			if($getimg[0] < 1000 && $getimg[1] < 1000) {
				$pic = '';
				if($getimg[2] == 1) $pic=$id.'.gif';
				elseif($getimg[2] == 2) $pic=$id.'.jpg';
				elseif($getimg[2] == 3) $pic=$id.'.png';
				if($pic != "") {
					if(file_exists($filepath.$id.'.gif')) unlink($filepath.$id.'.gif');
					if(file_exists($filepath.$id.'.jpg')) unlink($filepath.$id.'.jpg');
					if(file_exists($filepath.$id.'.png')) unlink($filepath.$id.'.png');
					rename($filepath.$banner['name'].".tmp", $filepath.$pic);
					safe_query("UPDATE ".PREFIX."partners SET banner='".$pic."' WHERE partnerID='".$id."'");
				}  else {
					if(unlink($filepath.$banner['name'].".tmp")) {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=partners&amp;action=edit&amp;partnerID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					} else {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=partners&amp;action=edit&amp;partnerID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					}
				}
			} else {
				@unlink($filepath.$banner['name'].".tmp");
				$error = $_language->module['banner_to_big'];
				die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=partners&amp;action=edit&amp;partnerID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
			}
		}
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_POST['saveedit'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		$name = $_POST['name'];
		$pos_x = $_POST['pos_x'];
		$pos_y = $_POST['pos_y'];
		$descr = $_POST['descr'];
		
		$partnercatID = $_POST['partnercatID'];
		
		$partners_cat='';
		$cat=safe_query("SELECT partnercatID, category FROM ".PREFIX."partners_cat ORDER BY category");
		while($dr=mysql_fetch_array($cat)) {
			if($ds['category']==$dr['partnercatID']) $partners_cat.='<option value="'.$dr['partnercatID'].'" selected="selected">'.getinput($dr['category']).'</option>';
			else $partners_cat.='<option value="'.$dr['partnercatID'].'">'.getinput($dr['category']).'</option>';
		}
		
		$url = $_POST['url'];
		$banner = $_FILES['banner'];
		if(isset($_POST["displayed"])) $displayed = $_POST['displayed'];
		else $displayed="";
		if(!$displayed) $displayed=0;
		$partnerID = $_POST['partnerID'];
		$id=$partnerID;
		
		
		
		$filepath = "../images/partners/";
		
		if($banner['name'] != "") {
			move_uploaded_file($banner['tmp_name'], $filepath.$banner['name'].".tmp");
			@chmod($filepath.$banner['name'].".tmp", 0755);
			$getimg = getimagesize($filepath.$banner['name'].".tmp");
			if($getimg[0] < 1000 && $getimg[1] < 1000) {
				$pic = '';
				if($getimg[2] == 1) $pic=$id.'.gif';
				elseif($getimg[2] == 2) $pic=$id.'.jpg';
				elseif($getimg[2] == 3) $pic=$id.'.png';
				if($pic != "") {
					if(file_exists($filepath.$id.'.gif')) unlink($filepath.$id.'.gif');
					if(file_exists($filepath.$id.'.jpg')) unlink($filepath.$id.'.jpg');
					if(file_exists($filepath.$id.'.png')) unlink($filepath.$id.'.png');
					rename($filepath.$banner['name'].".tmp", $filepath.$pic);
					safe_query("UPDATE ".PREFIX."partners SET banner='".$pic."' WHERE partnerID='".$id."'");
				}  else {
					if(unlink($filepath.$banner['name'].".tmp")) {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=partners&amp;action=edit&amp;partnerID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					} else {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=partners&amp;action=edit&amp;partnerID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					}
				}
			} else {
				@unlink($filepath.$banner['name'].".tmp");
				$error = $_language->module['banner_to_big'];
				die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=partners&amp;action=edit&amp;partnerID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
			}
		}
		safe_query("UPDATE ".PREFIX."partners SET name='$name', url='$url', displayed='".$displayed."' WHERE partnerID='$partnerID' ");
	} else echo $_language->module['transaction_invalid'];
}

if(isset($_GET['action'])) $action = $_GET['action'];
else $action = '';

if($action=="add") {
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	
	echo'<h1>&curren; <a href="admincenter.php?site=partners" class="white">'.$_language->module['partners'].'</a> &raquo; '.$_language->module['add_partner'].'</h1>';

	echo'<form method="post" action="admincenter.php?site=partners" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-hover">
    <tr>
      <td width="15%"><b>'.$_language->module['partner_name'].'</b></td>
      <td width="85%"><input type="text" name="name" size="60" /></td>
    </tr>
	<tr>
      <td width="15%"><b>Category</b></td>
      <td width="85%"><select name="partnercatID">'.$partners_cat.'</select></td>
    </tr>
	<tr>
      <td width="15%"><b>Position (X & Y)</b> <small><a href="coordinates.html" target="_blank">Check Coordinates</a></small></td>
      <td width="85%">Pos X <br \> <input type="text" name="pos_x" size="60" /> <br \><br \> Pos Y <br \><input type="text" name="pos_y" size="60" /> </td>
    </tr>
	<tr>
      <td width="15%"><b>Partner Description</b></td>
      <td width="85%"><textarea type="text" name="descr" rows="10" cols="100"></textarea></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['banner'].'</b></td>
      <td><input name="banner" type="file" size="40" /> <small>'.$_language->module['max_88x31'].'</small></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['homepage_url'].'</b></td>
      <td><input type="text" name="url" size="60" value="http://" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['is_displayed'].'</b></td>
      <td><input type="checkbox" name="displayed" value="1" checked="checked" /></td>
    </tr>
    <tr>
      <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /></td>
      <td><input type="submit" name="save" value="'.$_language->module['add_partner'].'" /></td>
    </tr>
  </table>
  </form>';
}

elseif($action=="edit") {
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	
		$partners_cat='';
		$cat=safe_query("SELECT partnercatID, category FROM ".PREFIX."partners_cat ORDER BY category");
		while($dr=mysql_fetch_array($cat)) {
			if($ds['category']==$dr['partnercatID']) $partners_cat.='<option value="'.$dr['partnercatID'].'" selected="selected">'.getinput($dr['category']).'</option>';
			else $partners_cat.='<option value="'.$dr['partnercatID'].'">'.getinput($dr['category']).'</option>';
		}
  
  echo'<h1>&curren; <a href="admincenter.php?site=partners" class="white">'.$_language->module['partners'].'</a> &raquo; '.$_language->module['edit_partner'].'</h1>';
  
  $partnerID = $_GET['partnerID'];
  $ergebnis=safe_query("SELECT * FROM ".PREFIX."partners WHERE partnerID='$partnerID'");
  $ds=mysql_fetch_array($ergebnis);
  
  if($ds['displayed']=='1') $displayed='<input type="checkbox" name="displayed" value="1" checked="checked" />';
  else $displayed='<input type="checkbox" name="displayed" value="1" />';
  
	echo'<form method="post" action="admincenter.php?site=partners" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td width="15%"><b>'.$_language->module['current_banner'].'</b></td>
      <td width="85%"><img src="../images/partners/'.$ds['banner'].'" alt="" /></td>
    </tr>
    <tr>
      <td width="15%"><b>'.$_language->module['partner_name'].'</b></td>
      <td width="85%"><input type="text" name="name" size="60" value="'.getinput($ds['name']).'" /></td>
    </tr>
	<tr>
      <td width="15%"><b>Category</b></td>
      <td width="85%"><select name="partnercatID">'.$partners_cat.'</select></td>
    </tr>
	<tr>
      <td width="15%"><b>Position (X & Y)</b> <small><a href="coordinates.html" target="_blank">Check Coordinates</a></small></td>
      <td width="85%">Pos X <br \> <input type="text" name="pos_x" value="'.getinput($ds['pos_x']).'" size="60" /> <br \><br \> Pos Y <br \><input type="text" name="pos_y" value="'.getinput($ds['pos_y']).'" size="60" /> </td>
    </tr>
	<tr>
      <td width="15%"><b>Partner Description</b></td>
      <td width="85%"><textarea type="text" name="descr" rows="10" cols="100">'.getinput($ds['descr']).'</textarea></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['banner'].'</b></td>
      <td><input name="banner" type="file" size="40" /> <small>'.$_language->module['max_88x31'].'</small></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['homepage_url'].'</b></td>
      <td><input type="text" name="url" size="60" value="'.getinput($ds['url']).'" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['is_displayed'].'</b></td>
      <td>'.$displayed.'</td>
    </tr>
    <tr>
      <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="hidden" name="partnerID" value="'.$partnerID.'" /></td>
      <td><input type="submit" name="saveedit" value="'.$_language->module['edit_partner'].'" /></td>
    </tr>
  </table>
  </form>';
}

else {
	
  echo'<h1>&curren; '.$_language->module['partners'].'</h1>';
  
  echo'<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=partners&amp;action=add\');return document.MM_returnValue" value="'.$_language->module['new_partner'].'" /><br /><br />';

	echo'<form method="post" action="admincenter.php?site=partners">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DDDDDD">
    <tr>
      <td width="42%" class="title"><b>'.$_language->module['partners'].'</b></td>
	  <td width="8%" class="title"><b>Coordinates</b></td>
	  <td width="8%" class="title"><b>Category</b></td>
      <td width="15%" class="title"><b>'.$_language->module['clicks'].'</b></td>
      <td width="15%" class="title"><b>'.$_language->module['is_displayed'].'</b></td>
      <td width="20%" class="title"><b>'.$_language->module['actions'].'</b></td>
    </tr>';

	$partners=safe_query("SELECT * FROM ".PREFIX."partners ORDER BY sort");
	$anzpartners=safe_query("SELECT count(partnerID) FROM ".PREFIX."partners");
	$anzpartners=mysql_result($anzpartners, 0);
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	
	$CAPCLASS->create_transaction();
	$hash_2 = $CAPCLASS->get_hash();
	
	$i=1;
	while($db=mysql_fetch_array($partners)) {
    if($i%2) { $td='td1'; }
    else { $td='td2'; }
    
    $db['displayed']==1 ? $displayed='<font color="green"><b>'.$_language->module['yes'].'</b></font>' : $displayed='<font color="red"><b>'.$_language->module['no'].'</b></font>';
    
    $days=round((time()-$db['date'])/(60*60*24));
    if($days) $perday=round($db['hits']/$days,2);
    else $perday=$db['hits'];
    
	$pos_x = $db['pos_x'];
	$pos_y = $db['pos_y'];
	$partnercatID = $db['partnercatID'];
	$partnercata=getpartnercatname($db['partnercatID']);
			
	echo'<tr>
      <td class="'.$td.'"><a href="'.getinput($db['url']).'" target="_blank">'.getinput($db['name']).'</a></td>
	  <td ><b>X:'.$pos_x.' Y:'.$pos_y.'</b></td>
	  <td ><b>'.$partnercata.'</b></td>
      <td class="'.$td.'">'.$db['hits'].' ('.$perday.')</td>
      <td class="'.$td.'" align="center">'.$displayed.'</td>
      <td class="'.$td.'" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=partners&amp;action=edit&amp;partnerID='.$db['partnerID'].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" />
      <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'admincenter.php?site=partners&amp;delete=true&amp;partnerID='.$db['partnerID'].'&amp;captcha_hash='.$hash.'\')" value="'.$_language->module['delete'].'" /></td>
    </tr>';
    $i++;
         
	}
	echo'<tr class="td_head">
      <td colspan="5" align="right"><input type="hidden" name="captcha_hash" value="'.$hash_2.'" /><input type="submit" name="sortieren" value="'.$_language->module['to_sort'].'" /></td>
    </tr>
  </table>
  </form>';
}
?>