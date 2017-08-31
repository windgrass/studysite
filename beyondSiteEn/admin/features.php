<?php

$_language->read_module('features');
if(!ispageadmin($userID) OR substr(basename($_SERVER[REQUEST_URI]),0,15) != "admincenter.php") die($_language->module['access_denied']);

if($_GET['delete']) {
  $featureID = $_GET['featureID'];
	
  safe_query(" DELETE FROM ".PREFIX."features WHERE featureID='$featureID' ");
	$filepath = "../images/features/";
	if(file_exists($filepath.$featureID.'.jpg')) @unlink($filepath.$featureID.'.jpg');
	if(file_exists($filepath.$featureID.'.gif')) @unlink($filepath.$featureID.'.gif');
}
elseif($_POST['sortieren']) {
  $sort = $_POST['sort'];
	foreach($sort as $sortstring) {
	    $sorter=explode("-", $sortstring);
		safe_query("UPDATE ".PREFIX."features SET sort='$sorter[1]' WHERE featureID='$sorter[0]' ");
	}
}
elseif($_POST['save']) {
  $url = $_POST['url'];
  $featurestext = $_POST['featurestext'];
  $featurestitle = $_POST['featurestitle'];
  $banner = $_FILES[banner];
  
    safe_query("INSERT INTO ".PREFIX."features ( url, sort )
	             values( '$url', '1' )");

	$id=mysql_insert_id();

	safe_query("UPDATE ".PREFIX."features SET featurestext='$featurestext' WHERE featureID='$id' ");	
	safe_query("UPDATE ".PREFIX."features SET featurestitle='$featurestitle' WHERE featureID='$id' ");		 
				 
	$filepath = "../images/features/";
	if ($banner[name] != "") {
        move_uploaded_file($banner[tmp_name], $filepath.$banner[name]);
		@chmod($filepath.$banner[name], 0755);
		$file_ext=strtolower(substr($banner[name], strrpos($banner[name], ".")));
		$file=$id.$file_ext;
		if(file_exists($filepath.$file)) @unlink($filepath.$file);
		rename($filepath.$banner[name], $filepath.$file);
		safe_query("UPDATE ".PREFIX."features SET banner='$file' WHERE featureID='$id' ");
	}
}
elseif($_POST['saveedit']) {
  $url = $_POST['url'];
  $featurestext = $_POST['featurestext'];
  $featurestitle = $_POST['featurestitle'];
  $banner = $_FILES[banner];

	$featureID = $_POST['featureID'];
	$id=$featureID;
	$filepath = "../images/features/";
	if ($banner[name] != "") {
        move_uploaded_file($banner[tmp_name], $filepath.$banner[name]);
		@chmod($filepath.$banner[name], 0755);
		$file_ext=strtolower(substr($banner[name], strrpos($banner[name], ".")));
		$file=$id.$file_ext;
    if(file_exists($filepath.$file)) @unlink($filepath.$file);
		rename($filepath.$banner[name], $filepath.$file);
		safe_query("UPDATE ".PREFIX."features SET banner='$file' WHERE featureID='$id' ");
	}
	safe_query("UPDATE ".PREFIX."features SET url='$url' WHERE featureID='$featureID' ");
	safe_query("UPDATE ".PREFIX."features SET featurestext='$featurestext' WHERE featureID='$featureID' ");
	safe_query("UPDATE ".PREFIX."features SET featurestitle='$featurestitle' WHERE featureID='$featureID' ");
}


if($_GET['action']=="add") {
	echo'<form method="post" action="admincenter.php?site=features" enctype="multipart/form-data">
	     <table cellpadding="4" cellspacing="0" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">New Feature</td>
    </tr>
		 <tr>
		   <td>'.$_language->module['banner'].':</td>
		   <td><input name="banner" type="file" /> <small>(Image size: 1000px x 350px)</small></td>
		 </tr>
		 <tr>
		   <td>'.$_language->module['link'].':</td>
		   <td><input type="text" name="url" size="30" value="index.php?site=" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" /></td>
		 </tr>
		 <tr>
		   <td>Title:</td>
		   <td><input type="text" name="featurestitle" size="30" value="" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" /></td>
		 </tr>
		 <tr>
		   <td>Category:</td>
		   <td><input type="text" name="featurestext" size="30" value="" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" /></td>
		 </tr>
		 <tr>
		   <td>&nbsp;</td>
		   <td><input type="submit" name="save" value="'.$_language->module['add'].'" /></td>
		 </tr>
		 </table>
		 </form>';
}
elseif($_GET['action']=="edit") {

  $featureID = $_GET['featureID'];
  $ergebnis=safe_query("SELECT * FROM ".PREFIX."features WHERE featureID='$featureID'");
	$ds=mysql_fetch_array($ergebnis);
	
    echo'<form method="post" action="admincenter.php?site=features" enctype="multipart/form-data">
	    	     <table cellpadding="4" cellspacing="0" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Edit Feature</td>
    </tr>
		 <tr>
		   <td>Current '.$_language->module['banner'].':</td>
		   <td><img src="../images/features/'.$ds[banner].'" width="50%" alt="'.$ds[banner].'" /></td>
		 </tr>
		 <tr>
		   <td>'.$_language->module['banner'].':</td>
		   <td><input name="banner" type="file" /> <small>(Image size: 1000px x 350px)</small></td>
		 </tr>
		 <tr>
		   <td>'.$_language->module['link'].':</td>
		   <td><input type="text" name="url" size="30" value="'.$ds[url].'" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" /></td>
		 </tr>
		 <tr>
		   <td>Title:</td>
		   <td><input type="text" name="featurestitle" size="30" value="'.$ds[featurestitle].'" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" /></td>
		 </tr>
                 <tr>
		   <td>Category:</td>
		   <td><input type="text" name="featurestext" size="30" value="'.$ds[featurestext].'" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" /></td>
		 </tr>
		 <tr>
		   <td><input type="hidden" name="featureID" value="'.$featureID.'" /></td>
		   <td><input type="submit" name="saveedit" value="'.$_language->module['update'].'" /></td>
		 </tr>
		 </table>
		 </form>';
}
else {
	echo'<input type="button" class="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=features&amp;action=add\');return document.MM_returnValue" value="'.$_language->module['new'].'" /><br /><br />';	
	echo'<form method="post" action="admincenter.php?site=features">
		     <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
		     <tr>
			   <td class="title" width="52%"><b>'.$_language->module['banner'].':</b></td>
			   <td width="20%" class="title"><b>Title:</b></td>
			   <td width="20%" class="title"><b>Category:</b></td>
			   <td width="20%" class="title"><b>'.$_language->module['link'].':</b></td>
			   <td width="20%" class="title" colspan="2"><b>'.$_language->module['actions'].':</b></td>
			   <td width="8%" class="title"><b>'.$_language->module['sort'].':</b></td>
			 </tr>';
			 
	$features=safe_query("SELECT * FROM ".PREFIX."features ORDER BY sort");
	$anzfeatures=safe_query("SELECT count(featureID) FROM ".PREFIX."features");
	$anzfeatures=mysql_result($anzfeatures, 0);
	$n = 0;
	while($db=mysql_fetch_array($features)) {
    $n++;
	if($n%2) {
				$td = 'td1';
			} else {
				$td = 'td2';
			}
		echo'<tr>
		       <td class="'.$td.'"><img src="../images/features/'.$db[banner].'" width="80%" alt="'.$db[banner].'" /></td>
			   <td class="'.$td.'">'.$db[featurestitle].'</td>
			   <td class="'.$td.'">'.$db[featurestext].'</td>
			   <td class="'.$td.'">'.$db[url].'</td>
			   <td class="'.$td.'"><input type="button" class="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=features&amp;action=edit&amp;featureID='.$db[featureID].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" /></td>
			   <td class="'.$td.'"><input type="button" class="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'admincenter.php?site=features&amp;delete=true&amp;featureID='.$db[featureID].'\')" value="'.$_language->module['delete'].'" /></td>
			   <td class="'.$td.'">
			   <select name="sort[]">';
		for($j=1; $j<=$anzfeatures; $j++) {
		    if($db[sort] == $j) echo'<option value="'.$db[featureID].'-'.$j.'">'.$j.'</option>';
			else echo'<option value="'.$db[featureID].'-'.$j.'">'.$j.'</option>';
        }		
	    echo'  </select>
		       </td>
		     </tr>';
	}
	echo'<tr>
         <td class="td_head" colspan="5" align="right"><input type="submit" name="sortieren" value="'.$_language->module['sort'].'" /></td>
		 </tr>
		 </table></form>';
}
?>	
