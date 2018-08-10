<?php

$_language->read_module('bannerrotation');

if(!ispageadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

$filepath = "../images/bannerrotation/";

if(isset($_GET['action'])) $action = $_GET['action'];
else $action = '';

if($action=="add") {

	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	
  echo'<form method="post" action="admincenter.php?site=bannerrotation" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['add_banner'].'</td>
    </tr>
    <tr>
      <td width="15%"><b>'.$_language->module['banner_upload'].'</b></td>
      <td width="85%"><input name="banner" type="file" size="40" /> <small>(Image max-width size: 970px)</small></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['banner_name'].'</b></td>
      <td><input type="text" name="bannername" size="60" maxlength="255" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['banner_url'].'</b></td>
      <td><input type="text" name="bannerurl" size="60" maxlength="255" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['is_displayed'].'</b></td>
      <td><input type="checkbox" name="displayed" value="1" checked="checked" /></td>
    </tr>
    <tr>
      <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /></td>
      <td><input type="submit" name="save" value="'.$_language->module['add_banner'].'" /></td>
    </tr>
  </table>
  </form>';
}

elseif($action=="edit") {

	$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."bannerrotation WHERE bannerID='".$_GET["bannerID"]."'"));
	if(file_exists($filepath.$ds['bannerID'].'.gif'))	$pic='<img src="../images/bannerrotation/'.$ds['bannerID'].'.gif" border="0" alt="'.$ds['banner'].'" />';
	elseif(file_exists($filepath.$ds['bannerID'].'.jpg'))	$pic='<img src="../images/bannerrotation/'.$ds['bannerID'].'.jpg" border="0" alt="'.$ds['banner'].'" />';
	elseif(file_exists($filepath.$ds['bannerID'].'.png'))	$pic='<img src="../images/bannerrotation/'.$ds['bannerID'].'.png" border="0" alt="'.$ds['banner'].'" />';
  
	else $pic=$_language->module['no_upload'];

	if($ds['displayed']=='1') $displayed='<input type="checkbox" name="displayed" value="1" checked="checked" />';
	else $displayed='<input type="checkbox" name="displayed" value="1" />';
	
  $CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
  echo'<form method="post" action="admincenter.php?site=bannerrotation" enctype="multipart/form-data">
  <input type="hidden" name="bannerID" value="'.$ds['bannerID'].'" />
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">'.$_language->module['edit_banner'].'</td>
    </tr>
    <tr>
      <td width="15%"><b>'.$_language->module['present_banner'].'</b></td>
      <td width="85%">'.$pic.'</td>
    </tr>
    <tr>
      <td><b>'.$_language->module['banner_upload'].'</b></td>
      <td><input name="banner" type="file" size="40" /> <small>(Image max-width size: 970px)</small></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['banner_name'].'</b></td>
      <td><input type="text" name="bannername" size="60" maxlength="255" value="'.getinput($ds['bannername']).'" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['banner_url'].'</b></td>
      <td><input type="text" name="bannerurl" size="60" value="'.getinput($ds['bannerurl']).'" /></td>
    </tr>
    <tr>
      <td><b>'.$_language->module['is_displayed'].'</b></td>
      <td>'.$displayed.'</td>
    </tr>
    <tr>
      <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /></td>
      <td><input type="submit" name="saveedit" value="'.$_language->module['edit_banner'].'" /></td>
    </tr>
  </table>
  </form>';
}

elseif(isset($_POST["save"])) {
	$banner=$_FILES["banner"];
	$bannername=$_POST["bannername"];
	$bannerurl=$_POST["bannerurl"];
	if(isset($_POST["displayed"])) $displayed = $_POST['displayed'];
  	else $displayed="";
  	if(!$displayed) $displayed=0;
  	
  	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		if($bannername AND $bannerurl AND $banner) {
			if(stristr($bannerurl,'http://')) $bannerurl=$bannerurl;
			else $bannerurl='http://'.$bannerurl;
	
			$file_ext=strtolower(mb_substr($banner['name'], strrpos($banner['name'], ".")));
			if($file_ext==".gif" OR $file_ext==".jpg" OR $file_ext==".png") {
				safe_query("INSERT INTO ".PREFIX."bannerrotation (bannerID, bannername, bannerurl, displayed, date) values('', '".$bannername."', '".$bannerurl."', '".$displayed."', '".time()."')");
				$id=mysql_insert_id();
				if($banner['name'] != "") {
					move_uploaded_file($banner['tmp_name'], $filepath.$banner['name']);
					@chmod($filepath.$banner['name'], 0755);
					$file=$id.$file_ext;
					rename($filepath.$banner['name'], $filepath.$file);
					if(safe_query("UPDATE ".PREFIX."bannerrotation SET banner='".$file."' WHERE bannerID='".$id."'")) {
						redirect("admincenter.php?site=bannerrotation","",0);
					} else {
						redirect("admincenter.php?site=bannerrotation","",0);
					}
				}
			} else echo'<b>'.$_language->module['format_incorrect'].'</b><br /><br /><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
		} else echo'<b>'.$_language->module['fill_correctly'].'</b><br /><br /><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_POST["saveedit"])) {
	$banner=$_FILES["banner"];
	$bannername=$_POST["bannername"];
	$bannerurl=$_POST["bannerurl"];
	if(isset($_POST["displayed"])) $displayed = $_POST['displayed'];
	else $displayed="";
	if(!$displayed) $displayed=0;
	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {	
		if($banner AND $bannername AND $bannerurl) {
			if(stristr($bannerurl,'http://')) $bannerurl=$bannerurl;
			else $bannerurl='http://'.$bannerurl;
	
			if($banner['name']=="") {
				if(safe_query("UPDATE ".PREFIX."bannerrotation SET bannername='".$bannername."', bannerurl='".$bannerurl."', displayed='".$displayed."' WHERE bannerID='".$_POST["bannerID"]."'"))
					redirect("admincenter.php?site=bannerrotation","",0);			
	    	} else {
				$file_ext=strtolower(mb_substr($banner['name'], strrpos($banner['name'], ".")));
				if($file_ext==".gif" OR $file_ext==".jpg" OR $file_ext==".png") {
					move_uploaded_file($banner['tmp_name'], $filepath.$banner['name']);
					@chmod($filepath.$banner['name'], 0755);
					$file=$_POST['bannerID'].$file_ext;
					unlink($filepath.$file);
					rename($filepath.$banner['name'], $filepath.$file);
	
					if(safe_query("UPDATE ".PREFIX."bannerrotation SET banner='".$file."', bannername='".$bannername."', bannerurl='".$bannerurl."', displayed='".$displayed."' WHERE bannerID='".$_POST["bannerID"]."'")) {
						redirect("admincenter.php?site=bannerrotation","",0);
					}
				} else echo'<b>'.$_language->module['format_incorrect'].'</b><br /><br /><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
			}
		} else echo'<b>'.$_language->module['fill_correctly'].'</b><br /><br /><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_GET["delete"])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_GET['captcha_hash'])) {
		if(safe_query("DELETE FROM ".PREFIX."bannerrotation WHERE bannerID='".$_GET["bannerID"]."'")) {
			if(file_exists($filepath.$_GET["bannerID"].'.jpg')) unlink($filepath.$_GET["bannerID"].'.jpg');
			if(file_exists($filepath.$_GET["bannerID"].'.gif')) unlink($filepath.$_GET["bannerID"].'.gif');
			if(file_exists($filepath.$_GET["bannerID"].'.png')) unlink($filepath.$_GET["bannerID"].'.png');
			redirect("admincenter.php?site=bannerrotation","",0);
		} else {
			redirect("admincenter.php?site=bannerrotation","",0);
		}
	} else echo $_language->module['transaction_invalid'];
}

else {
  
  echo'<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=bannerrotation&amp;action=add\');return document.MM_returnValue" value="'.$_language->module['new_banner'].'" /><br /><br />';
  
  echo'<form method="post" action="admincenter.php?site=bannerrotation">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td width="20%" class="title"><b>'.$_language->module['banner'].'</b></td>
      <td width="30%" class="title"><b>'.$_language->module['banner_url'].'</b></td>
      <td width="15%" class="title"><b>'.$_language->module['clicks'].'</b></td>
      <td width="15%" class="title"><b>'.$_language->module['is_displayed'].'</b></td>
      <td width="20%" class="title"><b>'.$_language->module['actions'].'</b></td>
    </tr>';
  
  $CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
    
	$qry=safe_query("SELECT * FROM ".PREFIX."bannerrotation ORDER BY bannerID");
	$anz=mysql_num_rows($qry);
	if($anz) {
		$i=1;
    while($ds = mysql_fetch_array($qry)) {
      if($i%2) { $td='td1'; }
			else { $td='td2'; }
      
			$ds['displayed']==1 ? $displayed='<font color="green"><b>'.$_language->module['yes'].'</b></font>' : $displayed='<font color="red"><b>'.$_language->module['no'].'</b></font>';

			if(stristr($ds['bannerurl'],'http://')) $bannerurl='<a href="'.getinput($ds['bannerurl']).'" target="_blank">'.getinput($ds['bannerurl']).'</a>';
			else $bannerurl='<a href="http://'.getinput($ds['bannerurl']).'" target="_blank">'.getinput($ds['bannerurl']).'</a>';

			$days=round((time()-$ds['date'])/(60*60*24));
			if($days) $perday=round($ds['hits']/$days,2);
			else $perday=$ds['hits'];
      
			echo'<tr>
        <td class="'.$td.'">'.getinput($ds['bannername']).'</td>
        <td class="'.$td.'">'.$bannerurl.'</td>
        <td class="'.$td.'">'.$ds['hits'].' ('.$perday.')</td>
        <td class="'.$td.'" align="center">'.$displayed.'</td>
        <td class="'.$td.'" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=bannerrotation&amp;action=edit&amp;bannerID='.$ds['bannerID'].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" />
        <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'admincenter.php?site=bannerrotation&amp;delete=true&amp;bannerID='.$ds['bannerID'].'&amp;captcha_hash='.$hash.'\')" value="'.$_language->module['delete'].'" /></td>
      </tr>';
      
      $i++;
		}
	}
  else echo'<tr><td class="td1" colspan="5">'.$_language->module['no_entries'].'</td></tr>';
	
  echo '</table></form>';
}
?>