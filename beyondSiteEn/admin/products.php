<?php

$_language->read_module('sponsors');

if(!ispageadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

$filepath = "../images/sponsors/";
$filepath_m = "../downloads/manuals/";

if(isset($_GET['action'])) $action = $_GET['action'];
else $action = '';

$musicalint='';
$ergebnis = safe_query("SELECT musicalint FROM `".PREFIX."sponsors` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$musicalint.= ' <option value="0" selected="true">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
					<option value="3">3</option>
					</select>';
}

$inhcontrol='';
$ergebnis = safe_query("SELECT inhcontrol FROM `".PREFIX."sponsors` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$inhcontrol.= ' <option value="0" selected="true">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
					<option value="3">3</option>
					</select>';
}

$cogflex='';
$ergebnis = safe_query("SELECT cogflex FROM `".PREFIX."sponsors` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$cogflex.= ' <option value="0" selected="true">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
					<option value="3">3</option>
					</select>';
}

$visual='';
$ergebnis = safe_query("SELECT visual FROM `".PREFIX."sponsors` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$visual.= ' <option value="0" selected="true">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
					<option value="3">3</option>
					</select>';
}

$musical='';
$ergebnis = safe_query("SELECT musical FROM `".PREFIX."sponsors` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$musical.= ' <option value="0" selected="true">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
					<option value="3">3</option>
					</select>';
}

$math='';
$ergebnis = safe_query("SELECT math FROM `".PREFIX."sponsors` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$math.= ' <option value="0" selected="true">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
					<option value="3">3</option>
					</select>';
}

$working='';
$ergebnis = safe_query("SELECT working FROM `".PREFIX."sponsors` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$working.= ' <option value="0" selected="true">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
					<option value="3">3</option>
					</select>';
}

$reflexive='';
$ergebnis = safe_query("SELECT reflexive FROM `".PREFIX."sponsors` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$reflexive.= ' <option value="0" selected="true">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
					<option value="3">3</option>
					</select>';
}

$interpersonal='';
$ergebnis = safe_query("SELECT interpersonal FROM `".PREFIX."sponsors` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$interpersonal.= ' <option value="0" selected="true">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
					<option value="3">3</option>
					</select>';
}

$creative='';
$ergebnis = safe_query("SELECT creative FROM `".PREFIX."sponsors` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$creative.= ' <option value="0" selected="true">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
					<option value="3">3</option>
					</select>';
}

if($action=="add") {

	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	
	$_language->read_module('bbcode', true);
	
	$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."sponsors WHERE s='".$_GET["s"]."'"));
	
	$products_cat='';
	$cat=safe_query("SELECT productscatID, category FROM ".PREFIX."products_cat ORDER BY category");
	while($dr=mysql_fetch_array($cat)) {
		$products_cat.='<option value="'.$dr['productscatID'].'">'.$dr['category'].'</option>';
	}
	
	$getvideos='';
	$catv=safe_query("SELECT movID, movheadline FROM ".PREFIX."movies ORDER BY movcatID");
	while($da=mysql_fetch_array($catv)) {
		$getvideos.='<option value="'.$da['movID'].'">'.getinput($da['movheadline']).'</option>';
	}
	
	eval ("\$addbbcode = \"".gettemplate("addbbcode", "html", "admin")."\";");
	eval ("\$addflags = \"".gettemplate("flags_admin", "html", "admin")."\";");
	
	echo '<script language="JavaScript" type="text/javascript">
		<!--
			function chkFormular() {
				if(!validbbcode(document.getElementById(\'message\').value, \'admin\')) {
					return false;
				}
			}
		-->
	</script>';
  
  echo'<form method="post" id="post" name="post" action="admincenter.php?site=products" enctype="multipart/form-data" onsubmit="return chkFormular();">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Add Products</td>
    </tr>
    <tr>
      <td width="15%"><b>'.$_language->module['banner_upload'].'</b></td>
      <td width="85%"><input name="banner" type="file" size="40" /></td>
    </tr>
	 <tr>
      <td width="15%"><b>'.$_language->module['banner_upload_small'].'</b></td>
      <td width="85%"><input name="banner_small" type="file" size="40" /></td>
    </tr>
	<tr>
      <td width="15%"><b>Upload Manual (.PDF)</b></td>
      <td width="85%"><input name="manual" type="file" size="40" /></td>
    </tr>
    <tr>
      <td><b>Name:</b></td>
      <td><input type="text" name="name" size="60" maxlength="255" /></td>
    </tr>
	<tr>
      <td width="15%"><b>Category</b></td>
      <td width="85%"><select name="productscatID">'.$products_cat.'</select></td>
    </tr>
    <tr>
      <td><b>Amazon Link:</b></td>
      <td><input type="text" name="url" size="60" maxlength="255" /></td>
    </tr>
	<tr>
      <td><b>Video:</b></td>
      <td><select name="video"><option value="">No Video</option>'.$getvideos.'</select></td>
    </tr>
	<tr>
      <td><b>Intelligences:</b></td>
      <td>
		Musical Intelligence: <select name="musicalint"><option value="0" selected="true">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <br \><br \>
		Inhibitory Control: <select name="inhcontrol"><option value="0" selected="true">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <br \><br \>
		Cognitive Flexibility: <select name="cogflex"><option value="0" selected="true">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <br \><br \>
		Visual-Spatial: <select name="visual"><option value="0" selected="true">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <br \><br \>
		Musical: <select name="musical"><option value="0" selected="true">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <br \><br \>
		Mathematical-Logical: <select name="math"><option value="0" selected="true">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <br \><br \>
		Working Memory: <select name="working"><option value="0" selected="true">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <br \><br \>
		Reflective: <select name="reflexive"><option value="0" selected="true">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <br \><br \>
		Interpersonal: <select name="interpersonal"><option value="0" selected="true">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <br \><br \>
		Creative: <select name="creative"><option value="0" selected="true">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <br \><br \>
	  </td>
    </tr>
    <tr>
      <td colspan="2">
        <b>'.$_language->module['description'].'</b>
        <table width="99%" border="0" cellspacing="0" cellpadding="0">
		      <tr>
		        <td valign="top">'.$addbbcode.'</td>
		        <td valign="top">'.$addflags.'</td>
		      </tr>
		    </table>
        <br /><textarea id="message" rows="5" cols="" name="message" style="width: 100%;"></textarea>
      </td>
    </tr>
    <tr>
      <td><b>'.$_language->module['is_displayed'].'</b></td>
      <td><input type="checkbox" name="displayed" value="1" checked="checked" /></td>
    </tr>
	 <tr>
      <td><b>Main Product:</b></td>
      <td><input type="checkbox" name="mainsponsor" value="1" /></td>
    </tr>
    <tr>
      <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /></td>
      <td><input type="submit" name="save" value="'.$_language->module['add_sponsor'].'" /></td>
    </tr>
  </table>
  </form>';
}

elseif($action=="edit") {

	$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."sponsors WHERE s='".$_GET["s"]."'"));
	if(!empty($ds['banner'])) $pic='<img src="'.$filepath.$ds['banner'].'" width="150px" border="0" alt="" />';
	else $pic=$_language->module['no_upload'];
	
	if(!empty($ds['banner_small'])) $pic_small='<img src="'.$filepath.$ds['banner_small'].'" width="150px" border="0" alt="" />';
	else $pic_small=$_language->module['no_upload'];
	
	if(!empty($ds['manual'])) $manual='<a target="_blank" href="'.$filepath_m.$ds['manual'].'">'.$ds['manual'].'</a>';
	else $manual='No manual uploaded';

	if($ds['displayed']=='1') $displayed='<input type="checkbox" name="displayed" value="1" checked="checked" />';
	else $displayed='<input type="checkbox" name="displayed" value="1" />';
	
	if($ds['mainsponsor']=='1') $mainsponsor='<input type="checkbox" name="mainsponsor" value="1" checked="checked" />';
	else $mainsponsor='<input type="checkbox" name="mainsponsor" value="1" />';
	
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
	
	$products_cat='';
		$cat=safe_query("SELECT productscatID, category FROM ".PREFIX."products_cat ORDER BY category");
		while($dr=mysql_fetch_array($cat)) {
			if($ds['category']==$dr['productscatID']) $products_cat.='<option value="'.$dr['productscatID'].'" selected="selected">'.getinput($dr['category']).'</option>';
			else $products_cat.='<option value="'.$dr['productscatID'].'">'.getinput($dr['category']).'</option>';
		}
	
	$getvideos='';
		$catv=safe_query("SELECT movID, movheadline FROM ".PREFIX."movies ORDER BY movcatID");
		while($da=mysql_fetch_array($catv)) {
			if($ds['video']==$da['movID']) $getvideos.='<option value="'.$da['movID'].'" selected="selected">'.getinput($da['movheadline']).'</option>';
			else $getvideos.='<option value="'.$da['movID'].'">['.getmovcat($da['movID']).'] '.getinput($da['movheadline']).'</option>';
		}
	
	$musicalint=str_replace('value="at" selected="selected"', 'value="at"', $musicalint);
	$musicalint=str_replace('value="'.$ds['musicalint'].'"', 'value="'.$ds['musicalint'].'" selected="selected"', $musicalint);
	
	$inhcontrol=str_replace('value="at" selected="selected"', 'value="at"', $inhcontrol);
	$inhcontrol=str_replace('value="'.$ds['inhcontrol'].'"', 'value="'.$ds['inhcontrol'].'" selected="selected"', $inhcontrol);

	$cogflex=str_replace('value="at" selected="selected"', 'value="at"', $cogflex);
	$cogflex=str_replace('value="'.$ds['cogflex'].'"', 'value="'.$ds['cogflex'].'" selected="selected"', $cogflex);
	
	$visual=str_replace('value="at" selected="selected"', 'value="at"', $visual);
	$visual=str_replace('value="'.$ds['visual'].'"', 'value="'.$ds['visual'].'" selected="selected"', $visual);
	
	$musical=str_replace('value="at" selected="selected"', 'value="at"', $musical);
	$musical=str_replace('value="'.$ds['musical'].'"', 'value="'.$ds['musical'].'" selected="selected"', $musical);
	
	$math=str_replace('value="at" selected="selected"', 'value="at"', $math);
	$math=str_replace('value="'.$ds['math'].'"', 'value="'.$ds['math'].'" selected="selected"', $math);
	
	$working=str_replace('value="at" selected="selected"', 'value="at"', $working);
	$working=str_replace('value="'.$ds['working'].'"', 'value="'.$ds['working'].'" selected="selected"', $working);
	
	$reflexive=str_replace('value="at" selected="selected"', 'value="at"', $reflexive);
	$reflexive=str_replace('value="'.$ds['reflexive'].'"', 'value="'.$ds['reflexive'].'" selected="selected"', $reflexive);
	
	$interpersonal=str_replace('value="at" selected="selected"', 'value="at"', $interpersonal);
	$interpersonal=str_replace('value="'.$ds['interpersonal'].'"', 'value="'.$ds['interpersonal'].'" selected="selected"', $interpersonal);
	
	$creative=str_replace('value="at" selected="selected"', 'value="at"', $creative);
	$creative=str_replace('value="'.$ds['creative'].'"', 'value="'.$ds['creative'].'" selected="selected"', $creative);
	
	$_language->read_module('bbcode', true);
	
	eval ("\$addbbcode = \"".gettemplate("addbbcode", "html", "admin")."\";");
	eval ("\$addflags = \"".gettemplate("flags_admin", "html", "admin")."\";");
	
	echo '<script language="JavaScript" type="text/javascript">
		<!--
			function chkFormular() {
				if(!validbbcode(document.getElementById(\'message\').value, \'admin\')) {
					return false;
				}
			}
		-->
	</script>';
  
  echo'<form method="post" id="post" name="post" action="admincenter.php?site=products" enctype="multipart/form-data" onsubmit="return chkFormular();"> 
  <input type="hidden" name="s" value="'.$ds['s'].'" />
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Edit Product</td>
    </tr>
    <tr>
      <td width="15%" valign="top"><b>'.$_language->module['current_banner'].'</b></td>
      <td width="85%">'.$pic.'</td>
    </tr>
	 <tr>
      <td valign="top"><b>'.$_language->module['current_banner_small'].'</b></td>
      <td>'.$pic_small.'</td>
    </tr>
	<tr>
      <td><b>Uploaded Manual</b></td>
      <td>'.$manual.'</td>
    </tr>
    <tr>
      <td><b>'.$_language->module['banner_upload'].'</b></td>
      <td><input name="banner" type="file" size="40" /></td>
    </tr>
	 <tr>
      <td><b>'.$_language->module['banner_upload_small'].'</b></td>
      <td><input name="banner_small" type="file" size="40" /></td>
    </tr>
	<tr>
      <td><b>Upload Manual (.PDF)</b></td>
      <td><input name="manual" type="file" size="40" /></td>
    </tr>
    <tr>
      <td><b>Name:</b></td>
      <td><input type="text" name="name" size="60" maxlength="255" value="'.getinput($ds['name']).'" /></td>
    </tr>
	<tr>
      <td width="15%"><b>Category</b></td>
      <td width="85%"><select name="productscatID">'.$products_cat.'</select></td>
    </tr>
    <tr>
      <td><b>Amazon Link:</b></td>
      <td><input type="text" name="url" size="60" value="'.getinput($ds['url']).'" /></td>
    </tr>
	<tr>
      <td><b>Video:</b></td>
      <td><select name="video"><option value="">No Video</option>'.$getvideos.'</select></td>
    </tr>
	<tr>
      <td><b>Intelligences:</b></td>
      <td>
		Musical Intelligence: <select name="musicalint">'.$musicalint.'</select> <br \><br \>
		Inhibitory Control: <select name="inhcontrol">'.$inhcontrol.'</select> <br \><br \>
		Cognitive Flexibility: <select name="cogflex">'.$cogflex.'</select> <br \><br \>
		Visual-Spatial: <select name="visual">'.$visual.'</select> <br \><br \>
		Musical: <select name="musical">'.$musical.'</select> <br \><br \>
		Mathematical-Logical: <select name="math">'.$math.'</select> <br \><br \>
		Working Memory: <select name="working">'.$working.'</select> <br \><br \>
		Reflective: <select name="reflexive">'.$reflexive.'</select> <br \><br \>
		Interpersonal: <select name="interpersonal">'.$interpersonal.'</select> <br \><br \>
		Creative: <select name="creative">'.$creative.'</select> <br \><br \>
	  </td>
    </tr>
    <tr>
      <td colspan="2">
        <b>'.$_language->module['description'].'</b>
        <table width="99%" border="0" cellspacing="0" cellpadding="0">
		      <tr>
		        <td valign="top">'.$addbbcode.'</td>
		        <td valign="top">'.$addflags.'</td>
		      </tr>
		    </table>
        <br /><textarea id="message" rows="5" cols="" name="message" style="width: 100%;">'.getinput($ds['info']).'</textarea>
      </td>
    </tr>
    <tr>
      <td><b>'.$_language->module['is_displayed'].'</b></td>
      <td>'.$displayed.'</td>
    </tr>
	 <tr>
      <td><b>Main Product:</b></td>
      <td>'.$mainsponsor.'</td>
    </tr>
    <tr>
      <td><input type="hidden" name="captcha_hash" value="'.$hash.'" /></td>
      <td><input type="submit" name="saveedit" value="'.$_language->module['edit_sponsor'].'" /></td>
    </tr>
  </table>
  </form>';
}

elseif(isset($_POST['sortieren'])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		$sort = $_POST['sort'];
		if(is_array($sort)) {
			foreach($sort as $sortstring) {
				$sorter=explode("-", $sortstring);
				safe_query("UPDATE ".PREFIX."sponsors SET sort='$sorter[1]' WHERE s='$sorter[0]' ");
				redirect("admincenter.php?site=products","",0);
			}
		}
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_POST["save"])) {
	$banner=$_FILES["banner"];
	$banner_small=$_FILES["banner_small"];
	$manual=$_FILES["manual"];
	$name=$_POST["name"];
	$url=$_POST["url"];
	$info=$_POST["message"];
	if(isset($_POST["displayed"])) $displayed = $_POST['displayed'];
	else $displayed="";
	if(!$displayed) $displayed=0;
	if(isset($_POST["mainsponsor"])) $mainsponsor = $_POST['mainsponsor'];
	else $mainsponsor="";
	if(!$mainsponsor) $mainsponsor=0;
	
	$productscatID = $_POST['productscatID'];
	$video = $_POST['video'];
	
	$musicalint = $_POST['musicalint'];
	$inhcontrol = $_POST['inhcontrol'];
	$cogflex = $_POST['cogflex'];
	$visual = $_POST['visual'];
	$musical = $_POST['musical'];
	$math = $_POST['math'];
	$working = $_POST['working'];
	$reflexive = $_POST['reflexive'];
	$interpersonal = $_POST['interpersonal'];
	$creative = $_POST['creative'];
			
	$products_cat='';
	$cat=safe_query("SELECT productscatID, category FROM ".PREFIX."products_cat ORDER BY category");
	while($dr=mysql_fetch_array($cat)) {
		$products_cat.='<option value="'.$dr['productscatID'].'">'.$dr['category'].'</option>';
	}
	
	$getvideos='';
	$catv=safe_query("SELECT movID, movheadline FROM ".PREFIX."movies ORDER BY movcatID");
	while($da=mysql_fetch_array($catv)) {
		$getvideos.='<option value="'.$da['movID'].'">'.getinput($da['movheadline']).'</option>';
	}
  	
  	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
		safe_query("INSERT INTO ".PREFIX."sponsors (sponsorID, productscatID, video, name, url, info, displayed, mainsponsor, date, sort, musicalint, inhcontrol, cogflex, visual, musical, math, working, reflexive, interpersonal, creative) values('', '".$name."', '".$productscatID."', '".$video."', '".$url."', '".$info."', '".$displayed."', '".$mainsponsor."', '".time()."', '1', '".$musicalint."', '".$inhcontrol."', '".$cogflex."', '".$visual."', '".$musical."', '".$math."', '".$working."', '".$reflexive."', '".$interpersonal."', '".$creative."')");
		
		$id=mysql_insert_id();
		
		if($banner['name'] != "") {
			move_uploaded_file($banner['tmp_name'], $filepath.$banner['name'].".tmp");
			@chmod($filepath.$banner['name'].".tmp", 0755);
			$getimg = getimagesize($filepath.$banner['name'].".tmp");
			if($getimg[0] < 2000 && $getimg[1] < 2000) {
				$pic = '';
				if($getimg[2] == 1) $pic=$id.'.gif';
				elseif($getimg[2] == 2) $pic=$id.'.jpg';
				elseif($getimg[2] == 3) $pic=$id.'.png';
				if($pic != "") {
					if(file_exists($filepath.$id.'.gif')) unlink($filepath.$id.'.gif');
					if(file_exists($filepath.$id.'.jpg')) unlink($filepath.$id.'.jpg');
					if(file_exists($filepath.$id.'.png')) unlink($filepath.$id.'.png');
					rename($filepath.$banner['name'].".tmp", $filepath.$pic);
					safe_query("UPDATE ".PREFIX."sponsors SET banner='".$pic."' WHERE s='".$id."'");
				}  else {
					if(unlink($filepath.$banner['name'].".tmp")) {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;s='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					} else {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;s='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					}
				}
			} else {
				@unlink($filepath.$banner['name'].".tmp");
				$error = $_language->module['icon_to_big'];
				die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;s='.$id.'">&laquo; '.$_language->module['back'].'</a>');
			}
		}
		
		if($banner_small['name'] != "") {
			move_uploaded_file($banner_small['tmp_name'], $filepath.$banner_small['name'].".tmp");
			@chmod($filepath.$banner_small['name'].".tmp", 0755);
			$getimg = getimagesize($filepath.$banner_small['name'].".tmp");
			if($getimg[0] < 2000 && $getimg[1] < 2000) {
				$pic = '';
				if($getimg[2] == 1) $pic=$id.'_small.gif';
				elseif($getimg[2] == 2) $pic=$id.'_small.jpg';
				elseif($getimg[2] == 3) $pic=$id.'_small.png';
				if($pic != "") {
					if(file_exists($filepath.$id.'_small.gif')) unlink($filepath.$id.'_small.gif');
					if(file_exists($filepath.$id.'_small.jpg')) unlink($filepath.$id.'_small.jpg');
					if(file_exists($filepath.$id.'_small.png')) unlink($filepath.$id.'_small.png');
					rename($filepath.$banner_small['name'].".tmp", $filepath.$pic);
					safe_query("UPDATE ".PREFIX."sponsors SET banner_small='".$pic."' WHERE s='".$id."'");
				}  else {
					if(unlink($filepath.$banner_small['name'].".tmp")) {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;s='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					} else {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;s='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					}
				}
			} else {
				@unlink($filepath.$banner_small['name'].".tmp");
				$error = $_language->module['banner_to_big'];
				die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;s='.$id.'">&laquo; '.$_language->module['back'].'</a>');
			}
		}
		
		//MANUAL
		if($manual['name'] != "") {
			$des_file = $filepath_m.$manual['name'];
			if(file_exists($des_file)) {
				unlink($des_file);
			}
			if(move_uploaded_file($manual['tmp_name'], $des_file)) {
				$file=$manual['name'];
				chmod($des_file, $new_chmod);
				safe_query("UPDATE ".PREFIX."sponsors SET manual='".$file."' WHERE s='".$id."'");
			}
		}
		
		redirect("admincenter.php?site=products","",0);
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_POST["saveedit"])) {
	$banner=$_FILES["banner"];
	$banner_small = $_FILES['banner_small'];
	$manual = $_FILES['manual'];
	$name=$_POST["name"];
	$url=$_POST["url"];
	$info=$_POST["message"];
	if(isset($_POST["displayed"])) $displayed = $_POST['displayed'];
	else $displayed="";
	if(!$displayed) $displayed=0;
	if(isset($_POST["mainsponsor"])) $mainsponsor = $_POST['mainsponsor'];
	else $mainsponsor="";
	if(!$mainsponsor) $mainsponsor=0;
	
	$productscatID = $_POST['productscatID'];
	$video = $_POST['video'];
	
	$musicalint = $_POST['musicalint'];
	$inhcontrol = $_POST['inhcontrol'];
	$cogflex = $_POST['cogflex'];
	$visual = $_POST['visual'];
	$musical = $_POST['musical'];
	$math = $_POST['math'];
	$working = $_POST['working'];
	$reflexive = $_POST['reflexive'];
	$interpersonal = $_POST['interpersonal'];
	$creative = $_POST['creative'];
					
	$products_cat='';
	$cat=safe_query("SELECT productscatID, category FROM ".PREFIX."products_cat ORDER BY category");
	while($dr=mysql_fetch_array($cat)) {
		if($ds['category']==$dr['productscatID']) $products_cat.='<option value="'.$dr['productscatID'].'" selected="selected">'.getinput($dr['category']).'</option>';
		else $products_cat.='<option value="'.$dr['productscatID'].'">'.getinput($dr['category']).'</option>';
	}
	
	$getvideos='';
	$catv=safe_query("SELECT movID, movheadline FROM ".PREFIX."movies ORDER BY movcatID");
	while($da=mysql_fetch_array($catv)) {
		if($ds['video']==$da['movID']) $getvideos.='<option value="'.$da['movID'].'" selected="selected">'.getinput($da['movheadline']).'</option>';
		else $getvideos.='<option value="'.$da['movID'].'">'.getinput($da['movheadline']).'</option>';
	}
	
	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_POST['captcha_hash'])) {
	
		if(stristr($url, 'http://')) $url=$url;
		else $url='http://'.$url;
		
		safe_query("UPDATE ".PREFIX."sponsors SET name='".$name."', productscatID='".$productscatID."', video='".$video."', url='".$url."', info='".$info."', displayed='".$displayed."', mainsponsor='".$mainsponsor."', musicalint='".$musicalint."', inhcontrol='".$inhcontrol."', cogflex='".$cogflex."', visual='".$visual."', musical='".$musical."', math='".$math."', working='".$working."', reflexive='".$reflexive."', interpersonal='".$interpersonal."', creative='".$creative."' WHERE s='".$_POST["s"]."'");
		
		$id=$_POST['s'];
		
		if($banner['name'] != "") {
			move_uploaded_file($banner['tmp_name'], $filepath.$banner['name'].".tmp");
			@chmod($filepath.$banner['name'].".tmp", 0755);
			$getimg = getimagesize($filepath.$banner['name'].".tmp");
			if($getimg[0] < 2000 && $getimg[1] < 2000) {
				$pic = '';
				if($getimg[2] == 1) $pic=$id.'.gif';
				elseif($getimg[2] == 2) $pic=$id.'.jpg';
				elseif($getimg[2] == 3) $pic=$id.'.png';
				if($pic != "") {
					if(file_exists($filepath.$id.'.gif')) unlink($filepath.$id.'.gif');
					if(file_exists($filepath.$id.'.jpg')) unlink($filepath.$id.'.jpg');
					if(file_exists($filepath.$id.'.png')) unlink($filepath.$id.'.png');
					rename($filepath.$banner['name'].".tmp", $filepath.$pic);
					safe_query("UPDATE ".PREFIX."sponsors SET banner='".$pic."' WHERE s='".$id."'");
				}  else {
					if(unlink($filepath.$banner['name'].".tmp")) {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;s='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					} else {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;s='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					}
				}
			} else {
				@unlink($filepath.$banner['name'].".tmp");
				$error = $_language->module['icon_to_big'];
				die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;s='.$id.'">&laquo; '.$_language->module['back'].'</a>');
			}
		}
		
		if($banner_small['name'] != "") {
			move_uploaded_file($banner_small['tmp_name'], $filepath.$banner_small['name'].".tmp");
			@chmod($filepath.$banner_small['name'].".tmp", 0755);
			$getimg = getimagesize($filepath.$banner_small['name'].".tmp");
			if($getimg[0] < 2000 && $getimg[1] < 2000) {
				$pic = '';
				if($getimg[2] == 1) $pic=$id.'_small.gif';
				elseif($getimg[2] == 2) $pic=$id.'_small.jpg';
				elseif($getimg[2] == 3) $pic=$id.'_small.png';
				if($pic != "") {
					if(file_exists($filepath.$id.'_small.gif')) unlink($filepath.$id.'_small.gif');
					if(file_exists($filepath.$id.'_small.jpg')) unlink($filepath.$id.'_small.jpg');
					if(file_exists($filepath.$id.'_small.png')) unlink($filepath.$id.'_small.png');
					rename($filepath.$banner_small['name'].".tmp", $filepath.$pic);
					safe_query("UPDATE ".PREFIX."sponsors SET banner_small='".$pic."' WHERE s='".$id."'");
				}  else {
					if(unlink($filepath.$banner_small['name'].".tmp")) {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;squadID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					} else {
						$error = $_language->module['format_incorrect'];
						die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;squadID='.$id.'">&laquo; '.$_language->module['back'].'</a>');
					}
				}
			} else {
				@unlink($filepath.$banner_small['name'].".tmp");
				$error = $_language->module['banner_to_big'];
				die('<b>'.$error.'</b><br /><br /><a href="admincenter.php?site=products&amp;action=edit&amp;s='.$id.'">&laquo; '.$_language->module['back'].'</a>');
			}
		}
		
		//MANUAL
		if($manual['name'] != "") {
			$des_file = $filepath_m.$manual['name'];
			if(file_exists($des_file)) {
				unlink($des_file);
			}
			if(move_uploaded_file($manual['tmp_name'], $des_file)) {
				$file=$manual['name'];
				chmod($des_file, $new_chmod);
				safe_query("UPDATE ".PREFIX."sponsors SET manual='".$file."' WHERE s='".$id."'");
			}
		}
		
		redirect("admincenter.php?site=products","",0);
	} else echo $_language->module['transaction_invalid'];
}

elseif(isset($_GET["delete"])) {
 	$CAPCLASS = new Captcha;
	if($CAPCLASS->check_captcha(0, $_GET['captcha_hash'])) {
		if(safe_query("DELETE FROM ".PREFIX."sponsors WHERE s='".$_GET["s"]."'")) {
			if(file_exists($filepath_m.$_GET["s"].'.pdf')) unlink($filepath_m.$_GET["s"].'.pdf');
			if(file_exists($filepath.$_GET["s"].'.gif')) unlink($filepath.$_GET["s"].'.gif');
			if(file_exists($filepath.$_GET["s"].'.jpg')) unlink($filepath.$_GET["s"].'.jpg');
			if(file_exists($filepath.$_GET["s"].'.png')) unlink($filepath.$_GET["s"].'.png');
			if(file_exists($filepath.$_GET["s"].'_small.gif')) unlink($filepath.$_GET["s"].'_small.gif');
			if(file_exists($filepath.$_GET["s"].'_small.jpg')) unlink($filepath.$_GET["s"].'_small.jpg');
			if(file_exists($filepath.$_GET["s"].'_small.png')) unlink($filepath.$_GET["s"].'_small.png');
			redirect("admincenter.php?site=products","",0);
		} else {
			redirect("admincenter.php?site=products","",0);
		}
	} else echo $_language->module['transaction_invalid'];
}

else {
  
  echo'<input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=products&amp;action=add\');return document.MM_returnValue" value="'.$_language->module['new_sponsor'].'" /><br /><br />';
  
  echo'<form method="post" action="admincenter.php?site=products">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" TABELAS: class="table table-hover">
    <tr>
      <td width="15%" class="title"><b>'.$_language->module['sponsor'].'</b></td>
      <td width="15%" class="title"><b>Small Banner:</b></td>
	  <td width="15%" class="title"><b>Manual:</b></td>
	  <td width="15%" class="title"><b>Category:</b></td>
      <td width="15%" class="title"><b>'.$_language->module['is_displayed'].'</b></td>
		<td width="13%" class="title"><b>'.$_language->module['mainsponsor'].'</b></td>
      <td width="20%" class="title"><b>'.$_language->module['actions'].'</b></td>
      <td width="8%" class="title"><b>'.$_language->module['sort'].'</b></td>
    </tr>';
	 
	$CAPCLASS = new Captcha;
	$CAPCLASS->create_transaction();
	$hash = $CAPCLASS->get_hash();
    
	$qry=safe_query("SELECT * FROM ".PREFIX."sponsors ORDER BY sort");
	$anz=mysql_num_rows($qry);
	if($anz) {
		$i=1;
    while($ds = mysql_fetch_array($qry)) {
      if($i%2) { $td='td1'; }
			else { $td='td2'; }
      
			if(!empty($ds['banner'])) $pic='<img src="'.$filepath.$ds['banner'].'" border="0" alt="" />';
			else $pic=$_language->module['no_upload'];
			
			if(!empty($ds['banner_small'])) $pic_smally='<img src="'.$filepath.$ds['banner_small'].'" border="0" width="150px" alt="" />';
			else $pic_smally=$_language->module['no_upload'];

			if(!empty($ds['manual'])) $pdf='<a target="_blank" href="'.$filepath_m.$ds['manual'].'">Manual (.pdf)</a>';
			else $pdf='No manual uploaded';
			
			$ds['displayed']==1 ? $displayed='<font color="green"><b>'.$_language->module['yes'].'</b></font>' : $displayed='<font color="red"><b>'.$_language->module['no'].'</b></font>';
			$ds['mainsponsor']==1 ? $mainsponsor='<font color="green"><b>'.$_language->module['yes'].'</b></font>' : $mainsponsor='<font color="red"><b>'.$_language->module['no'].'</b></font>';

			if(stristr($ds['url'],'http://')) $name='<a href="'.getinput($ds['url']).'" target="_blank">'.getinput($ds['name']).'</a>';
			else $name='<a href="http://'.getinput($ds['url']).'" target="_blank">'.getinput($ds['name']).'</a>';

			$days=round((time()-$ds['date'])/(60*60*24));
			if($days) $perday=round($ds['hits']/$days,2);
			else $perday=$ds['hits'];
			
			$productscatID = $ds['productscatID'];
			$productscata=getproductscatname($ds['productscatID']);
      
			echo'<tr>
        <td class="'.$td.'">'.$name.'</td>
        <td class="'.$td.'">'.$pic_smally.'</td>
		<td class="'.$td.'">'.$pdf.'</td>
		<td class="'.$td.'">'.$productscata.'</td>
        <td class="'.$td.'" align="center">'.$displayed.'</td>
		  <td class="'.$td.'" align="center">'.$mainsponsor.'</td>
        <td class="'.$td.'" align="center"><input type="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=products&amp;action=edit&amp;s='.$ds['s'].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" />
        <input type="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'admincenter.php?site=products&amp;delete=true&amp;s='.$ds['s'].'&amp;captcha_hash='.$hash.'\')" value="'.$_language->module['delete'].'" /></td>
        <td class="'.$td.'" align="center"><select name="sort[]">';
        
			for($j=1; $j<=$anz; $j++) {
				if($ds['sort'] == $j) echo'<option value="'.$ds['s'].'-'.$j.'" selected="selected">'.$j.'</option>';
				
        else echo'<option value="'.$ds['s'].'-'.$j.'">'.$j.'</option>';
			}
			echo'</select>
        </td>
      </tr>';
      
      $i++;
		}
	}
  else echo'<tr><td class="td1" colspan="6">'.$_language->module['no_entries'].'</td></tr>';
	
  echo'<tr>
      <td class="td_head" colspan="6" align="right"><input type="hidden" name="captcha_hash" value="'.$hash.'" /><input type="submit" name="sortieren" value="'.$_language->module['to_sort'].'" /></td>
    </tr>
  </table>
  </form>';
}
?>