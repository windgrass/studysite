<?php

$_language->read_module("featuredcont");

// -- COUNTRY LIST -- //

$countries='';
$ergebnis = safe_query("SELECT * FROM `".PREFIX."countries` ORDER BY country");
while($ds = mysql_fetch_array($ergebnis)) {
	$countries .= '<option value="'.$ds['short'].'">'.$ds['country'].'</option>';
}

$images='';
$ergebnis = safe_query("SELECT image FROM `".PREFIX."songs` LIMIT 0,1");
while($ds = mysql_fetch_array($ergebnis)) {
	$images .= ' <option value="images/songs_up.png" selected="true">Up</option>
                       <option value="images/songs_equal.png">Equal</option>
                       <option value="images/songs_down.png">Down</option>';
}

$groups ='';
$ergebnis = safe_query("SELECT DISTINCT g.* FROM `".PREFIX."groups` as g, ".PREFIX."groups_teams as gt WHERE g.league = gt.league ORDER BY g.gid");
while($ds = mysql_fetch_array($ergebnis)) {
	$groups .= '<option value="'.$ds['gid'].'" selected="true">'.$ds['gname'].'</option>';
}

$groupsa ='';
$ergebnis = safe_query("SELECT DISTINCT g.* FROM `".PREFIX."groups` as g, ".PREFIX."groups_teams as gt WHERE g.league = gt.league ORDER BY g.gid");
while($ds = mysql_fetch_array($ergebnis)) {
	$groupsa .= '<option value="'.$ds['gid'].'">'.getleaguename($ds['league']).' (Group '.$ds['gname'].')</option>';
}

$groupsaa ='';
$ergebnis = safe_query("SELECT * FROM `".PREFIX."groups` ORDER BY gid");
while($ds = mysql_fetch_array($ergebnis)) {
	$groupsaa .= '<option value="'.$ds['gid'].'">'.getleaguename($ds['league']).' (Group '.$ds['gname'].')</option>';
}


// -- GAMES LIST -- //

$gamesa = safe_query("SELECT * FROM ".PREFIX."games ORDER BY name");
while($ds = mysql_fetch_array($gamesa)) {
	$games .= '<option value="'.$ds['tag'].'">'.$ds['name'].'</option>';
}

if(!ispageadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

$action = isset($_GET["action"]) ? $action = $_GET["action"] : $action = "";

if($action == "newgroup") {

	$gname = isset($_POST["gname"]) ? $_POST["gname"] : "";
	$gleague = isset($_POST["league"]) ? $_POST["league"] : "";
	
	$new_window = isset($_POST['new_window']) ? 1 : 0;

	$error = array();
	if(isset($_POST['safe'])) {
		
				safe_query("INSERT INTO `".PREFIX."groups` (`gname`, `league`, `addedon`, `activated`, `new_window`) VALUES ('$gname', '$gleague', NOW(), 1, $new_window )");
					redirect('admincenter.php?site=leagues',$_language->module['fc_added'],2);
			
		
	}

	echo '
	<form enctype="multipart/form-data" action="admincenter.php?site=groups&action=newgroup" method="post" onsubmit="alert(this.image.value)">		
	<table cellpadding="3" cellspacing="1" class="table table-hover">
        <tr><td colspan="2" style="font-weight: 700; background: #2b2b2b; color: #FFF">New Group</td></tr>
	<tr>
            <td style="font-weight: 700">Group Name:</td>
            <td><input type="text" name="gname" value="'.$gname.'" /></td>
        </tr>
        <tr><td style="font-weight: 700">League:</td><td><select name="league">'.$leagues.'</select></td></tr>
	</table>
	<input type="hidden" name="safe" value="1" />
	<input type="submit" value="'.$_language->module['fc_add_doadd'].'" />&nbsp;<input type="button" OnClick="window.location.href=\'admincenter.php?site=leagues\'" value="'.$_language->module['fc_edit_back'].'" />
	</form>
	';
}
elseif($action == "delgroup") {
	$delgid = (int) $_GET["gid"];
	$leagid = $_GET["id"];
	if($delquery = mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."groups WHERE gid = ".$delgid))) {
		$delgdb = safe_query("DELETE FROM ".PREFIX."groups WHERE gid =".$delgid) ? '<img src="images/tick.gif" alt="Done" /> Group Deleted successfully!' : '<img src="images/del.gif"> Error while trying to delete database entry!';
		echo $delgdb.'<br /><a href="admincenter.php?site=leagues&action=edit&id='.$leagid.'">'.$_language->module['fc_edit_back'].'</a>';
	}
	else {
		echo $_language->module['fc_general_error'];
	}

}

elseif($action == "editgroup") {
	$id = (int) $_GET["gid"];
	if(isset($_POST["edit"])){
		$name = $_POST["gname"];
		$league = $_POST["league"];
		$new_window = isset($_POST['new_window']) ? 1 : 0;

		$query = "UPDATE ".PREFIX."groups SET gname = '".$name."', league = '".$league."', new_window = $new_window";
                safe_query($query." WHERE gid = ".$id);
		redirect("admincenter.php?site=leagues&action=edit&id=$league",$_language->module['fc_edited'],2);
			
	}

	$query = safe_query("SELECT * FROM ".PREFIX."groups WHERE gid = $id LIMIT 0,1");
	if(mysql_num_rows($query) > 0) {
		$res = mysql_fetch_array($query);

                $leagues=str_replace('value="at" selected="selected"', 'value="at"', $leagues);
		$leagues=str_replace('value="'.$res['league'].'"', 'value="'.$res['league'].'" selected="selected"', $leagues);

		echo '
			<form enctype="multipart/form-data" action="admincenter.php?site=groups&action=editgroup&gid='.$id.'" method="post">		
			<table cellpadding="3" cellspacing="1" class="table table-hover">
                        <tr><td colspan="2" style="font-weight: 700; background: #2b2b2b; color: #FFF">Edit Group '.$res['gname'].' from League '.getleaguename($res['league']).'</td></tr>
			<tr><td>Group Name*:</td><td><input type="text" name="gname" value="'.$res['gname'].'" /></td></tr>
			<tr><td>League:</td><td><select name="league">'.$leagues.'</select></td></tr>
			</table>
			<input type="hidden" name="edit" value="1" />
			<input type="submit" value="'.$_language->module['fc_edit_doedit'].'!" />&nbsp;<input type="button" OnClick="window.location.href=\'admincenter.php?site=leagues\'" value="'.$_language->module['fc_edit_back'].'!" /><br \><br \><a href="#" OnClick="if(confirm(\'Delete?\')) window.location.href=\'admincenter.php?site=groups&action=delgroup&gid='.$id.'\';">DELETE GROUP? <img src="images/del.gif" alt="Delete" /></a>
			</form>
			';
	}
	else {
		echo $_language->module['fc_general_error'];
	}

}

elseif($action == "newteamgroup") {

	$gleague = isset($_POST["league"]) ? $_POST["league"] : "";
	$ggroupid = isset($_POST["groupid"]) ? $_POST["groupid"] : "";
	$gwin = isset($_POST["win"]) ? $_POST["win"] : "";
	$glost = isset($_POST["lost"]) ? $_POST["lost"] : "";
	$gdraw = isset($_POST["draw"]) ? $_POST["draw"] : "";
	$gpoints = isset($_POST["points"]) ? $_POST["points"] : "";
	$gteam = isset($_POST["team"]) ? $_POST["team"] : "";

	$new_window = isset($_POST['new_window']) ? 1 : 0;

	$error = array();
	if(isset($_POST['safe'])) {
	
		if(!count($error)) {
		
				$sortid = mysql_num_rows(safe_query("SELECT id FROM ".PREFIX."groups_teams"))+1;
				$query = safe_query("INSERT INTO `".PREFIX."groups_teams` (`league`, `groupid`, `win`, `lost`, `draw`, `points`, `team`, `addedon`, `sortid`, `activated`, `new_window`) VALUES ('$gleague', '$ggroupid', '$gwin', '$glost', '$gdraw', '$gpoints', '$gteam', NOW(), '$sortid', 1, $new_window )");
				if($query) {
					redirect('admincenter.php?site=rankings',$_language->module['fc_added'],2);
				}
				else {
					echo $_language->module['fc_added_error'];
				}
			
		}
	}
	if(count($error)) {
		echo '<div style="text-align: center; font-weight: bold;">'.implode("<br />",$error).'</div>';
	}

	echo '
	<form enctype="multipart/form-data" action="admincenter.php?site=groups&action=newteamgroup" method="post" onsubmit="alert(this.image.value)">		
	<table cellpadding="3" cellspacing="1" class="table table-hover">
        <tr><td colspan="2" style="font-weight: 700; background: #2b2b2b; color: #FFF">Add Team to Group</td></tr>
        <tr><td style="font-weight: 700">League:</td><td><select name="league">'.$leagues.'</select></td></tr>
        <tr><td style="font-weight: 700">Group:</td><td><select name="groupid">'.$groupsaa.'</select></td></tr>
        <tr><td style="font-weight: 700">Team:</td><td><select name="team">'.$teams.'</select></td></tr>
	<tr>
            <td style="font-weight: 700">Win:</td>
            <td><input type="text" name="win" value="'.$gwin.'" /> <small>(blank field = 0)</small></td>
        </tr>
	<tr>
            <td style="font-weight: 700">Draw:</td>
            <td><input type="text" name="draw" value="'.$gdraw.'" /> <small>(blank field = 0)</small></td>
        </tr>
	<tr>
            <td style="font-weight: 700">Lost:</td>
            <td><input type="text" name="lost" value="'.$glost.'" /> <small>(blank field = 0)</small></td>
        </tr>
	<tr>
            <td style="font-weight: 700">Points:</td>
            <td><input type="text" name="points" value="'.$gpoints.'" /> <small>(blank field = 0)</small></td>
        </tr>
	</table>
	<input type="hidden" name="safe" value="1" />
	<input type="submit" value="'.$_language->module['fc_add_doadd'].'" />&nbsp;<input type="button" OnClick="window.location.href=\'admincenter.php?site=rankings\'" value="'.$_language->module['fc_edit_back'].'" />
	</form>
	';
}

elseif($action == "editteamgroup") {
	$id = (int) $_GET["id"];
	if(isset($_POST["edit"])){
        $gleague = $_POST["league"];
	$ggroupid = $_POST["groupid"];
	$gwin = $_POST["win"];
	$glost = $_POST["lost"];
	$gdraw = $_POST["draw"];
	$gpoints = $_POST["points"];
	$gteam = $_POST["team"];

		$new_window = isset($_POST['new_window']) ? 1 : 0;
		$query = "UPDATE ".PREFIX."groups_teams SET league = '".$gleague."', groupid = '".$ggroupid."', win = '".$gwin."', lost = '".$glost."', draw = '".$gdraw."', points = '".$gpoints."', team = '".$gteam."', new_window = $new_window";
                safe_query($query." WHERE id = ".$id);
                redirect("admincenter.php?site=leagues&action=edit&id=$gleague",$_language->module['fc_edited'],2);

        }

	$query = safe_query("SELECT * FROM ".PREFIX."groups_teams WHERE id = $id LIMIT 0,1");
	if(mysql_num_rows($query) > 0) {
		$res = mysql_fetch_array($query);

                $leagues=str_replace('value="at" selected="selected"', 'value="at"', $leagues);
		$leagues=str_replace('value="'.$res['league'].'"', 'value="'.$res['league'].'" selected="selected"', $leagues);

                $groupsa=str_replace('value="at" selected="selected"', 'value="at"', $groupsa);
		$groupsa=str_replace('value="'.$res['groupid'].'"', 'value="'.$res['groupid'].'" selected="selected"', $groupsa);

                $teams=str_replace('value="at" selected="selected"', 'value="at"', $teams);
		$teams=str_replace('value="'.$res['team'].'"', 'value="'.$res['team'].'" selected="selected"', $teams);

	echo '
	<form enctype="multipart/form-data" action="admincenter.php?site=groups&action=editteamgroup&id='.$id.'"" method="post" onsubmit="alert(this.image.value)">	
	<table cellpadding="3" cellspacing="1" class="table table-hover">
        <tr><td colspan="2" style="font-weight: 700; background: #2b2b2b; color: #FFF">Edit Team '.getteamname($res['team']).' data from League '.getleaguename($res['league']).': Group '.getgroupname($res['groupid']).'</td></tr>
        <tr><td style="font-weight: 700">League:</td><td><select name="league">'.$leagues.'</select></td></tr>
        <tr><td style="font-weight: 700">Group:</td><td><select name="groupid">'.$groupsa.'</select></td></tr>
        <tr><td style="font-weight: 700">Team:</td><td><select name="team">'.$teams.'</select></td></tr>
	<tr>
            <td style="font-weight: 700">Win:</td>
            <td><input type="text" name="win" value="'.$res['win'].'" /> <small>(blank field = 0; Only change if something is not right, because is all automatic)</small></td>
        </tr>
	<tr>
            <td style="font-weight: 700">Draw:</td>
            <td><input type="text" name="draw" value="'.$res['draw'].'" /> <small>(blank field = 0; Only change if something is not right, because is all automatic)</small></td>
        </tr>
	<tr>
            <td style="font-weight: 700">Lost:</td>
            <td><input type="text" name="lost" value="'.$res['lost'].'" /> <small>(blank field = 0; Only change if something is not right, because is all automatic)</small></td>
        </tr>
	<tr>
            <td style="font-weight: 700">Points:</td>
            <td><input type="text" name="points" value="'.$res['points'].'" /> <small>(blank field = 0; Only change if something is not right, because is all automatic)</small></td>
        </tr>
	</table>
	<input type="hidden" name="edit" value="1" />
	<input type="submit" value="Edit" />&nbsp;<input type="button" OnClick="window.location.href=\'admincenter.php?site=leagues\'" value="'.$_language->module['fc_edit_back'].'" />
	</form>
	';
	}

}

else echo '';

?>