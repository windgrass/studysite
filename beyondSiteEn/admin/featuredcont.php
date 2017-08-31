<?php

if(file_exists("featuredcont_set.php")) include("featuredcont_set.php"); else $fc_set_req_small = TRUE;
include("../src/fc_slider.class.php");

$_language->read_module("featuredcont");

$positionn='';
$ergebnis = safe_query("SELECT position FROM `".PREFIX."featuredcont` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$positionn .= ' <option value="top center" selected="true">Top Center</option>
                    <option value="center center">Center Center</option>';
}

$attc='';
$ergebnis = safe_query("SELECT att FROM `".PREFIX."featuredcont` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$attc .= ' <option value="fixed" selected="true">Fixed</option>
                    <option value="scroll">Scroll</option>';
}

$repeats='';
$ergebnis = safe_query("SELECT repeating FROM `".PREFIX."featuredcont` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$repeats .= ' <option value="no-repeat" selected="true">No Repeat</option>
                    <option value="repeat">Repeat</option>';
}


if(!ispageadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

$action = isset($_GET["action"]) ? $action = $_GET["action"] : $action = "";

if($action == "new") {
	$fcname = isset($_POST["name"]) ? $_POST["name"] : "";
	$positionn = isset($_POST["position"]) ? $_POST["position"] : "";
	$attc = isset($_POST["att"]) ? $_POST["att"] : "";
	$repeats = isset($_POST["repeating"]) ? $_POST["repeating"] : "";
	$fcfullimg = isset($_FILES["fullimg"]) ? $_FILES["fullimg"] : "";
	$new_window = isset($_POST['new_window']) ? 1 : 0;

	$error = array();
	if(isset($_POST['safe'])) {
		if(empty($fcname)) $error[] = $_language->module['fc_add_e_name'];
		if(empty($fcurl)) $error[] = $_language->module['fc_add_e_url'];
		if(!is_uploaded_file($fcfullimg['tmp_name'])) $error[] = $_language->module['fc_add_e_fullimg'];
	
		if(!count($error)) {
		
			$fullimg_name = fc_slider::move_image_home($fcfullimg,"full_");
			if($fullimg_name != false){
				$sortid = mysql_num_rows(safe_query("SELECT id from ".PREFIX."featuredcont"))+1;
				$query = safe_query("INSERT INTO `".PREFIX."featuredcont` (`name`, `position`, `att`, `addednow`, `repeating`, `fullimg`, `sortid`, `activated`, `new_window`) VALUES ('$fcname', '$positionn', '$attc', NOW(), '$repeats', '$fctext', '$fullimg_name', '$sortid', 1, $new_window)");
				if($query) {
					redirect('admincenter.php?site=featuredcont',$_language->module['fc_added'],2);
				}
				else {
					echo $_language->module['fc_added_error'];
				}
			}
		}
	}
	if(count($error)) {
		echo '<div style="text-align: center; font-weight: bold;">'.implode("<br />",$error).'</div>';
	}

	echo '
	<form enctype="multipart/form-data" action="admincenter.php?site=featuredcont&action=new" method="post">		
	<table cellpadding="2" cellspacing="0" border="0" class="table table-hover">
	<tr><td>'.$_language->module['fc_add_name'].'*:</td><td><input type="text" name="name" value="'.$fcname.'" /></td></tr>
	<tr><td>Repeat:</td><td><select name="repeating">'.$repeats.'</select></td></tr>
	<tr><td>Position:</td><td><select name="position">'.$positionn.'</select></td></tr>
	<tr><td>Attachment:</td><td><select name="att">'.$attc.'</select></td></tr>
	<tr><td>'.$_language->module['fc_add_fullimg'].'*:</td><td><input name="fullimg" type="file" /></td></tr>
	<tr><td colspan="2">* '.$_language->module['fc_add_required'].'!</td></tr>
	</table>
	<input type="hidden" name="safe" value="1" />
	<input type="submit" value="'.$_language->module['fc_add_doadd'].'" />&nbsp;<input type="button" OnClick="window.location.href=\'admincenter.php?site=featuredcont\'" value="'.$_language->module['fc_edit_back'].'" />
	</form>
	';
}
elseif($action == "del") {
	$delid = (int) $_GET["id"];
	if($delquery = mysql_fetch_array(safe_query("SELECT name, fullimg FROM ".PREFIX."featuredcont WHERE id = ".$delid))) {
		$delfull = (@unlink("../images/featuredcont/".$delquery["fullimg"])) ? '<img src="images/tick.gif" alt="Done" /> Deleted image '.$delquery["fullimg"].' successfully!' : '<img src="images/del.gif"> Error while trying to delete '.$delquery["fullimg"];
		$deldb = safe_query("DELETE FROM ".PREFIX."featuredcont WHERE id =".$delid) ? '<img src="images/tick.gif" alt="Done" /> Deleted database entry successfully!' : '<img src="images/del.gif"> Error while trying to delete database entry!';
		echo $delsmall.'<br />'.$delfull.'<br />'.$deldb.'<br /><a href="admincenter.php?site=featuredcont">'.$_language->module['fc_edit_back'].'</a>';
	}
	else {
		echo $_language->module['fc_general_error'];
	}

}
elseif($action == "sort") {
	$sortlen = count($_POST["sort"]);
	$sortlen2 = count(array_unique($_POST["sort"]));
	if(isset($_POST["sort"])) {
		if($sortlen == $sortlen2){
			foreach($_POST["sort"] as $id => $newsort) {
				safe_query("UPDATE ".PREFIX."featuredcont SET sortid=".$newsort." WHERE id=".$id);
				redirect("admincenter.php?site=featuredcont","",0);
			}
		}
		else {
			echo $_language->module['fc_sort_error'];
		}
	}
	else {
		echo $_language->module['fc_general_error'];
	}
}
elseif($action == "act") {
	if(isset($_GET["id"]) && isset($_GET["do"])){
		$id = (int) $_GET["id"];
		if($_GET["do"] == "a"){
			safe_query("UPDATE ".PREFIX."featuredcont SET activated=1 WHERE id=".$id);
			redirect("admincenter.php?site=featuredcont","",0);
		}
		elseif($_GET["do"] == "d") {
			safe_query("UPDATE ".PREFIX."featuredcont SET activated=0 WHERE id=".$id);
			redirect("admincenter.php?site=featuredcont","",0);
		}
		else {
			redirect("admincenter.php?site=featuredcont","",0);
		}
	}
	else {
		redirect("admincenter.php?site=featuredcont","",0);
	}
}
elseif($action == "edit") {
	$id = (int) $_GET["id"];
	if(isset($_POST["edit"])){
		$name = $_POST["name"];
		$positionn = $_POST["position"];
		$repeats = $_POST["repeating"];
		$attc = $_POST["att"];
		$fcfullimg = $_FILES["fullimg"];
		$new_window = isset($_POST['new_window']) ? 1 : 0;
		$query = "UPDATE ".PREFIX."featuredcont SET name = '".$name."', position = '".$positionn."', att = '".$attc."', repeating = '".$repeats."', new_window = $new_window";
		$delquery = mysql_fetch_array(safe_query("SELECT fullimg FROM ".PREFIX."featuredcont WHERE id = ".$id));

		if(!empty($name)) {
				
			if(($fullimg_name = fc_slider::move_image_home($fcfullimg, "full_")) != false) {
				$query .= ", fullimg = '".$fullimg_name."'";
				$delfull = @unlink("../images/featuredcont/".$delquery["fullimg"]);
			}
				
			$query = safe_query($query." WHERE id = ".$id);
				
			if($query) {
				redirect("admincenter.php?site=featuredcont",$_language->module['fc_edited'],2);
			}
			else {
				echo $_language->module['fc_general_error'];
			}
		}
		else echo $_language->module['fc_general_error'];
	}

	$query = safe_query("SELECT * FROM ".PREFIX."featuredcont WHERE id = $id LIMIT 0,1");
	if(mysql_num_rows($query) > 0) {
		$res = mysql_fetch_array($query);
		
		$positionn=str_replace('value="at" selected="selected"', 'value="at"', $positionn);
		$positionn=str_replace('value="'.$res['position'].'"', 'value="'.$res['position'].'" selected="selected"', $positionn);
		
		$repeats=str_replace('value="at" selected="selected"', 'value="at"', $repeats);
		$repeats=str_replace('value="'.$res['repeating'].'"', 'value="'.$res['repeating'].'" selected="selected"', $repeats);
		
		$attc=str_replace('value="at" selected="selected"', 'value="at"', $attc);
		$attc=str_replace('value="'.$res['att'].'"', 'value="'.$res['att'].'" selected="selected"', $attc);

		
		echo '
			<form enctype="multipart/form-data" action="admincenter.php?site=featuredcont&action=edit&id='.$id.'" method="post">		
			<table cellpadding="2" cellspacing="0" border="0" class="table table-hover">
			<tr><td>'.$_language->module['fc_add_name'].'*:</td><td><input type="text" name="name" value="'.$res['name'].'" /></td></tr>
			<tr><td>Repeat:</td><td><select name="repeating">'.$repeats.'</select></td></tr>
			<tr><td>Position:</td><td><select name="position">'.$positionn.'</select></td></tr>
			<tr><td>Attachment:</td><td><select name="att">'.$attc.'</select></td></tr>
			<tr><td>'.$_language->module['fc_add_fullimg'].'*:</td><td><input name="fullimg" type="file"></td></tr>
			<tr><td valign="top"></td><td><img src="../images/featuredcont/'.$res['fullimg'].'" alt="Fullsize" width="30%" /></td></tr>
			<tr><td colspan="2">* '.$_language->module['fc_add_required'].'!</td></tr>
			</table>
			<input type="hidden" name="edit" value="1" />
			<input type="submit" value="'.$_language->module['fc_edit_doedit'].'!" />&nbsp;<input type="button" OnClick="window.location.href=\'admincenter.php?site=featuredcont\'" value="'.$_language->module['fc_edit_back'].'!" />
			</form>
			';
	}
	else {
		echo $_language->module['fc_general_error'];
	}

}
else {

	// ENTRYS
	echo '<strong>'.$_language->module['fc_entrys'].':</strong>';
	echo '<form name="fc_form" style="display: inline" action="admincenter.php?site=featuredcont&action=sort" method="post">';
	echo '<table cellpadding="3" cellspacing="1" border="0" width="90%" class="table table-hover">';
	echo '<tr style="background-color: #4f5259; color: #FFFFFF">';
	echo '  <td>#</td><td>'.$_language->module['fc_name'].'</td>
			<td>Image</td>
			<td>'.$_language->module['fc_sort'].'</td>
			<td>'.$_language->module['fc_activate'].'</td>
			<td>'.$_language->module['fc_edit'].'</td>
			<td width="30" style="text-align: center;">'.$_language->module['fc_delete'].'</td>';

	$num_result = mysql_num_rows($query = safe_query("SELECT id,name,activated,fullimg FROM ".PREFIX."featuredcont ORDER BY sortid ASC"));
	if ($num_result > 0){
		$blankID = 1;
		while($res = mysql_fetch_array($query)) {
			echo '<tr class="rowhover">';
			echo '<td>#'.$blankID.'</td>';
			echo '<td>'.$res['name'].'</td>';
			echo '<td><img src="../images/featuredcont/'.$res['fullimg'].'" alt="Fullsize" width="30%" /></td>';
			echo '<td><select name="sort['.$res['id'].']">';
			for($i=1;$i<=$num_result;$i++) {
				if($i==$blankID) {
					echo '<option selected="selected">'.$i.'</option>';
				}
				else {
					echo '<option>'.$i.'</option>';
				}
			}
			echo '</select></td>';
			if($res['activated'] == 1) {
				echo '<td><input type="checkbox" checked="checked" OnClick="window.location.href=\'admincenter.php?site=featuredcont&action=act&id='.$res["id"].'&do=d\'" /></td>';
			}
			else {
				echo '<td><input type="checkbox" OnClick="window.location.href=\'admincenter.php?site=featuredcont&action=act&id='.$res["id"].'&do=a\'" /></td>';
			}
			echo '<td><a href="admincenter.php?site=featuredcont&action=edit&id='.$res['id'].'">'.$_language->module['fc_edit'].'</a></td>';
			echo '<td style="text-align: center;"><a href="#" OnClick="if(confirm(\'Delete?\')) window.location.href=\'admincenter.php?site=featuredcont&action=del&id='.$res['id'].'\';"><img src="images/del.gif" alt="Delete" /></a></td>';
			echo '</tr>';
			$blankID++;
		}
		echo '</tr>';
	}
	else {
		echo '<tr><td colspan="8">'.$_language->module['fc_empty'].'</td></tr>';
	}
	echo '</table>';
	echo '<input type="submit" value="'.$_language->module['fc_dosort'].'" />&nbsp;<input type="button" OnClick="window.location.href=\'admincenter.php?site=featuredcont&action=new\'" value="'.$_language->module['fc_new'].'" /></form>';
}
?>