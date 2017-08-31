<?php

if(!isfileadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die("access denied");

$_language->read_module('movies');
$filepath = "../images/movies/cat/";

if($_GET["action"]=="add") {
	
		  echo'<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movcat\');return document.MM_returnValue" value="'.$_language->module['exist_cats'].'"><br /><br />
		  <form method="post" action="admincenter.php?site=movcat" enctype="multipart/form-data">
		  <table cellpadding="3" cellspacing="1" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Add Movie Category</td>
    </tr>
			<tr>
				<td>'.$_language->module['category'].' '.$_language->module['name'].':</td>
				<td><input type="text" name="movcatname" size="60" maxlength="255" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
			</tr>
                        <tr>
				<td>'.$_language->module['screen'].':</td>
				<td><input name="movcatimg" type="file"> (recommended width: 307px)</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="save" value="'.$_language->module['add_category'].'"></td>
			</tr>
		  </table>
		  </form>';
}
elseif($_GET["action"]=="edit") {

	$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."movie_categories WHERE movcatID='".$_GET["movcatID"]."'"));

	if(file_exists($filepath.$ds['movcatID'].'.gif'))	$pic='<img src="../images/movies/cat/'.$ds['movcatID'].'.gif" width="200" height="115" border="0" alt="'.$ds['movcatname'].'">';
	elseif(file_exists($filepath.$ds['movcatID'].'.jpg'))	$pic='<img src="../images/movies/cat/'.$ds['movcatID'].'.jpg" width="200" height="115" border="0" alt="'.$ds['movcatname'].'">';
	elseif(file_exists($filepath.$ds['movcatID'].'.png'))	$pic='<img src="../images/movies/cat/'.$ds['movcatID'].'.png" width="200" height="115" border="0" alt="'.$ds['movcatname'].'">';
	else $pic='no image uploaded';
	
	echo '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movcat\');return document.MM_returnValue" value="'.$_language->module['exist_cats'].'"><br /><br />
		  <form method="post" action="admincenter.php?site=movcat" enctype="multipart/form-data">
		<input type="hidden" name="movcatID" value="'.$ds['movcatID'].'"><br \>
		  <table cellpadding="3" cellspacing="1" class="table table-hover">
    <tr>
      <td colspan="2" style="background-color: #4f5259; color: #FFFFFF">Edit Movie Category</td>
    </tr>
			<tr>
				<td>'.$_language->module['category'].' '.$_language->module['name'].':</td>
				<td><input type="text" name="movcatname" size="60" maxlength="255" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" value="'.$ds[movcatname].'"></td>
			</tr>
                        <tr>
				<td>Current '.$_language->module['screen'].':</td>
				<td><img src="'.$filepath.''.$ds['movcatimg'].'" width="307px"></td>
			</tr>
                        <tr>
				<td>'.$_language->module['screen'].':</td>
				<td><input name="movcatimg" type="file"> (recommended width: 307px)</td>
			</tr>
			<tr>
				<td><input type="hidden" name="movcatID" value="'.$ds[movcatID].'"></td>
				<td><input type="submit" name="saveedit" value="'.$_language->module['edit'].' '.$_language->module['category'].'"></td>
			</tr>
		  </table>
		  </form>';

}
elseif($_POST["saveedit"]) {
	
	$movcatname=$_POST["movcatname"];
	$movcatimg=$_FILES["movcatimg"];
	
			$file_ext=strtolower(substr($movcatimg[name], strrpos($movcatimg[name], ".")));
			if($file_ext==".gif" OR $file_ext==".jpg" OR $file_ext==".png") {
				move_uploaded_file($movcatimg[tmp_name], $filepath.$movcatimg[name]);
				@chmod($filepath.$movcatimg[name], 0755);
				$file=$_POST['movcatID'].$file_ext;
				rename($filepath.$movcatimg[name], $filepath.$file);

				if(safe_query("UPDATE ".PREFIX."movie_categories SET movcatimg='".$file."', movcatname='".$movcatname."' WHERE movcatID='".$_POST["movcatID"]."'")) {
					header("Location: admincenter.php?site=movcat");
				}
			} else echo'<b>'.$_language->module['screen_error1'].'.</b><br><br><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
	
}
elseif($_POST["save"]) {
	
	$movcatname=$_POST["movcatname"];
	$movcatimg=$_FILES["movcatimg"];

	safe_query("INSERT INTO ".PREFIX."movie_categories (movcatID, movcatname) values('', '".$movcatname."')");
	$id=mysql_insert_id();

        $file_ext=strtolower(substr($movcatimg[name], strrpos($movcatimg[name], ".")));
		if($file_ext==".gif" OR $file_ext==".jpg" OR $file_ext==".png") {
			if($movcatimg[name] != "") {
				move_uploaded_file($movcatimg[tmp_name], $filepath.$movcatimg[name]);
				@chmod($filepath.$movcatimg[name], 0755);
				$file=$id.$file_ext;
				rename($filepath.$movcatimg[name], $filepath.$file);
				if(safe_query("UPDATE ".PREFIX."movie_categories SET movcatimg='".$file."' WHERE movcatID='".$id."'")) {
					redirect("admincenter.php?site=movcat", "".$_language->module['screen_created'].".", "3");
				} else {
					redirect("admincenter.php?site=movcat", "".$_language->module['screen_error']."!", "3");
				}
			}
		} else echo'<b>'.$_language->module['screen_error1'].'.</b><br><br><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
	redirect("admincenter.php?site=movcat", "".$_language->module['cat_created'].".", "3");

}
elseif($_GET["delete"]) {
	if(safe_query("DELETE FROM ".PREFIX."movie_categories WHERE movcatID='".$_GET["movcatID"]."'")) {
                if(file_exists($filepath.$_GET["movcatID"].'.jpg')) unlink($filepath.$_GET["movcatID"].'.jpg');
		if(file_exists($filepath.$_GET["movcatID"].'.gif')) unlink($filepath.$_GET["movcatID"].'.gif');
		if(file_exists($filepath.$_GET["movcatID"].'.png')) unlink($filepath.$_GET["movcatID"].'.png');
		redirect("admincenter.php?site=movcat", "".$_language->module['cat_deleted'].".", "3");
	} else {
		redirect("admincenter.php?site=movcat", "".$_language->module['cat_deleted_error']."", "3");
	}
}
else {
	echo '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movcat&action=add\');return document.MM_returnValue" value="'.$_language->module['new'].' '.$_language->module['category'].'"><br /><br />
			<table width="100%" cellpadding="3" cellspacing="1" class="table table-hover">
				<tr>
					<td class="title">movcatID:</td>
					<td class="title">Movie Category Image:</td>
					<td class="title">'.$_language->module['category'].' '.$_language->module['name'].':</td>
					<td class="title">'.$_language->module['actions'].':</td>
				</tr>';
				
	
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."movie_categories ORDER BY movcatname");
	while($ds = mysql_fetch_array($ergebnis)) {
		
		echo '<tr>
			  		<td>'.$ds[movcatID].'</td>
					<td><img src="'.$filepath.''.$ds[movcatimg].'" width="307px" /></td>
					<td>'.$ds[movcatname].'</td>
					<td><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movcat&action=edit&movcatID='.$ds[movcatID].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'">
				   <input type="button" class="button" onClick="MM_confirm(\'really delete this category?\', \'admincenter.php?site=movcat&delete=true&movcatID='.$ds[movcatID].'\')" value="'.$_language->module['del'].'"></td>
			  </tr>';
	}
	
	echo '</tr></table>';
	
	
}

?>