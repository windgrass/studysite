<?php

$_language->read_module('features');
if(!ispageadmin($userID) OR substr(basename($_SERVER[REQUEST_URI]),0,15) != "admincenter.php") die($_language->module['access_denied']);

if($_GET['delete']) {
  $featureID = $_GET['featureID'];
	
  safe_query(" DELETE FROM ".PREFIX."featured_story WHERE featureID='$featureID' ");
	$filepath = "../images/featured_story/";
	if(file_exists($filepath.$featureID.'.jpg')) @unlink($filepath.$featureID.'.jpg');
	if(file_exists($filepath.$featureID.'.gif')) @unlink($filepath.$featureID.'.gif');
}
elseif($_POST['sortieren']) {
  $sort = $_POST['sort'];
	foreach($sort as $sortstring) {
	    $sorter=explode("-", $sortstring);
		safe_query("UPDATE ".PREFIX."featured_story SET sort='$sorter[1]' WHERE featureID='$sorter[0]' ");
	}
}
elseif($_POST['save']) {
  $url = $_POST['url'];
  $featurestext = $_POST['featurestext'];
  $featurestitle = $_POST['featurestitle'];
  $banner = $_FILES[banner];
  
    safe_query("INSERT INTO ".PREFIX."featured_story ( url, sort )
	             values( '$url', '1' )");

	$id=mysql_insert_id();

	safe_query("UPDATE ".PREFIX."featured_story SET featurestext='$featurestext' WHERE featureID='$id' ");	
	safe_query("UPDATE ".PREFIX."featured_story SET featurestitle='$featurestitle' WHERE featureID='$id' ");		 
				 
	$filepath = "../images/featured_story/";
	if ($banner[name] != "") {
        move_uploaded_file($banner[tmp_name], $filepath.$banner[name]);
		@chmod($filepath.$banner[name], 0755);
		$file_ext=strtolower(substr($banner[name], strrpos($banner[name], ".")));
		$file=$id.$file_ext;
		if(file_exists($filepath.$file)) @unlink($filepath.$file);
		rename($filepath.$banner[name], $filepath.$file);
		safe_query("UPDATE ".PREFIX."featured_story SET banner='$file' WHERE featureID='$id' ");
	}
}
elseif($_POST['saveedit']) {
  $url = $_POST['url'];
  $featurestext = $_POST['featurestext'];
  $featurestitle = $_POST['featurestitle'];
  $banner = $_FILES[banner];

	$featureID = $_POST['featureID'];
	$id=$featureID;
	$filepath = "../images/featured_story/";
	if ($banner[name] != "") {
        move_uploaded_file($banner[tmp_name], $filepath.$banner[name]);
		@chmod($filepath.$banner[name], 0755);
		$file_ext=strtolower(substr($banner[name], strrpos($banner[name], ".")));
		$file=$id.$file_ext;
    if(file_exists($filepath.$file)) @unlink($filepath.$file);
		rename($filepath.$banner[name], $filepath.$file);
		safe_query("UPDATE ".PREFIX."featured_story SET banner='$file' WHERE featureID='$id' ");
	}
	safe_query("UPDATE ".PREFIX."featured_story SET url='$url' WHERE featureID='$featureID' ");
	safe_query("UPDATE ".PREFIX."featured_story SET featurestext='$featurestext' WHERE featureID='$featureID' ");
	safe_query("UPDATE ".PREFIX."featured_story SET featurestitle='$featurestitle' WHERE featureID='$featureID' ");
}

if($_GET['action']=="add") {
	echo'<form method="post" action="admincenter.php?site=featured_story" enctype="multipart/form-data">
	     <table cellpadding="3" cellspacing="1" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">New Featured Story</td>
    </tr>
		 <tr>
		   <td>'.$_language->module['banner'].':</td>
		   <td><input name="banner" type="file" /> <small>(Image size: 970px x 150px)</small></td>
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
		   <td>Poster:</td>
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
  $ergebnis=safe_query("SELECT * FROM ".PREFIX."featured_story WHERE featureID='$featureID'");
	$ds=mysql_fetch_array($ergebnis);
	
    echo'<form method="post" action="admincenter.php?site=featured_story" enctype="multipart/form-data">
	     <table cellpadding="3" cellspacing="1" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Edit Featured Story</td>
    </tr>
		 <tr>
		   <td>Current '.$_language->module['banner'].':</td>
		   <td><img src="../images/featured_story/'.$ds[banner].'" width="50%" alt="'.$ds[banner].'" /></td>
		 </tr>
		 <tr>
		   <td>'.$_language->module['banner'].':</td>
		   <td><input name="banner" type="file" /> <small>(Image size: 970px x 150px)</small></td>
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
		   <td>Poster:</td>
		   <td><textarea name="featurestext" rows="10" cols="50" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" >'.$ds[featurestext].'</textarea></td>
		 </tr>
		 <tr>
		   <td><input type="hidden" name="featureID" value="'.$featureID.'" /></td>
		   <td><input type="submit" name="saveedit" value="'.$_language->module['update'].'" /></td>
		 </tr>
		 </table>
		 </form>';
}
else {
	echo'<input type="button" class="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=featured_story&amp;action=add\');return document.MM_returnValue" value="'.$_language->module['new'].'" /><br /><br />';	
	echo'<form method="post" action="admincenter.php?site=featured_story">
		     <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table table-hover">
		     <tr>
			   <td class="title" width="52%">'.$_language->module['banner'].':</td>
			   <td width="20%" class="title">Title:</td>
			   <td width="20%" class="title">Poster:</td>
			   <td width="20%" class="title">'.$_language->module['link'].':</td>
			   <td width="20%" class="title" colspan="2">'.$_language->module['actions'].':</td>
			   <td width="8%" class="title">'.$_language->module['sort'].':</td>
			 </tr>';
			 
	$features=safe_query("SELECT * FROM ".PREFIX."featured_story ORDER BY sort");
	$anzfeatures=safe_query("SELECT count(featureID) FROM ".PREFIX."featured_story");
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
		       <td class="'.$td.'"><img src="../images/featured_story/'.$db[banner].'" width="100%" alt="'.$db[banner].'" /></td>
			   <td class="'.$td.'">'.$db[featurestitle].'</td>
			   <td class="'.$td.'">'.$db[featurestext].'</td>
			   <td class="'.$td.'">'.$db[url].'</td>
			   <td class="'.$td.'"><input type="button" class="button" onclick="MM_goToURL(\'parent\',\'admincenter.php?site=featured_story&amp;action=edit&amp;featureID='.$db[featureID].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" /></td>
			   <td class="'.$td.'"><input type="button" class="button" onclick="MM_confirm(\''.$_language->module['really_delete'].'\', \'admincenter.php?site=featured_story&amp;delete=true&amp;featureID='.$db[featureID].'\')" value="'.$_language->module['delete'].'" /></td>
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
