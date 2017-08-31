<?php

function getanzcwcomments($cwID) {
	$anz=mysql_num_rows(safe_query("SELECT commentID FROM `".PREFIX."comments` WHERE parentID='$cwID' AND type='cw'"));
	return $anz;
}

function getsquads() {
	$squads="";
  $ergebnis=safe_query("SELECT * FROM ".PREFIX."squads");
	while($ds=mysql_fetch_array($ergebnis)) {
		$squads.='<option value="'.$ds['squadID'].'">'.$ds['name'].'</option>';
	}
	return $squads;
}

function getleagues() {
	$getleagues ="";
        $ergebnis=safe_query("SELECT * FROM ".PREFIX."leagues");
	while($ds=mysql_fetch_array($ergebnis)) {
		$getleagues .='<option value="coverage/-/event/'.$ds['id'].'">'.$ds['name'].'</option>';
	}
	return $getleagues;
}

function getgamesquads() {
	$squads = '';
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."squads WHERE gamesquad='1'");
	while($ds=mysql_fetch_array($ergebnis)) {
		$squads.='<option value="'.$ds['squadID'].'">'.$ds['name'].'</option>';
	}
	return $squads;
}

function getgamelist() {
                $gamelist ='';
                $games = safe_query("SELECT * FROM ".PREFIX."games ORDER BY name ASC");
		while($game = mysql_fetch_array($games)) {
			$checked = $game['gameID'] == $ds['gameID'] ? 'selected="selected"' : '';
			$gamelist.='<option '.$checked.' value="'.$game['gameID'].'">'.$game['name'].'</option>';
		}
	return $gamelist;
}

function getsquadshort($squadID) {
	$ds=mysql_fetch_array(safe_query("SELECT short FROM ".PREFIX."squads WHERE squadID='$squadID'"));
	return $ds['short'];
}

function getsquadlogo($squadID) {
	$ds=mysql_fetch_array(safe_query("SELECT icon_small FROM ".PREFIX."squads WHERE squadID='$squadID'"));
	return $ds['icon_small'];
}

function getsquadname($squadID) {
	$ds=mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."squads WHERE squadID='$squadID'"));
	return $ds['name'];
}

function issquadmember($userID, $squadID) {
	$anz=mysql_num_rows(safe_query("SELECT sqmID FROM ".PREFIX."squads_members WHERE userID='$userID' AND squadID='$squadID'"));
	return $anz;
}

function isgamesquad($squadID) {
	$anz=mysql_num_rows(safe_query("SELECT squadID FROM ".PREFIX."squads WHERE squadID='".$squadID."' AND gamesquad='1'"));
	return $anz;
}

function getgamename($tag) {
	$ds=mysql_fetch_array(safe_query("SELECT name FROM `".PREFIX."games` WHERE tag='$tag'"));
	return $ds['name'];
}

function getteamgame($id) {
	$ds=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX."songs WHERE id='$id'"));
	return $ds['game'];
}

function getgamename2($gameID) {
	$ds=mysql_fetch_array(safe_query("SELECT name FROM `".PREFIX."games` WHERE gameID='$gameID'"));
	return $ds['name'];
}

function is_gametag($tag){
	$anz = mysql_num_rows(safe_query("SELECT name FROM `".PREFIX."games` WHERE tag='$tag'"));
	return $anz;
}

function getteamname($id) {
	$ds=mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."songs WHERE id='$id'"));
	return $ds['name'];
}

function getteamshortname($id) {
	$ds=mysql_fetch_array(safe_query("SELECT shortname FROM ".PREFIX."songs WHERE id='$id'"));
	return $ds['shortname'];
}

function getteamcountry($id) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."songs WHERE id='$id'"));
        if(!$ds['country']) $cont = '';
	return getinput($ds['country']);
}

function getteamcountryb($id) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."songs WHERE id='$id'"));
        if(!$ds['country']) $cont = '';
        else $cont = '<img src="images/flags/'.$ds['country'].'.gif" />';
	return $cont;
}

function getteamlogo($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimg FROM ".PREFIX."songs WHERE id='$id'"));
	return getinput($ds['fullimg']);
}

function getteamlogobracket($id) {
	$ds=mysql_fetch_array(safe_query("SELECT id, fullimg, fullimgout FROM ".PREFIX."songs WHERE id='$id'"));	
	if($ds['id'] == '') { return '<img src="images/teams/nopic.png" height="20px" width="20px" />';}
	else {
		if($ds['fullimg'] == '') return '<img src="'.getinput($ds['fullimgout']).'" height="20px" width="20px" />';
		else return '<img src="images/teams/'.getinput($ds['fullimg']).'" height="20px" width="20px" />';
	}
}

function getteamlogoout($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimgout FROM ".PREFIX."songs WHERE id='$id'"));
	return getinput($ds['fullimgout']);
}

function getpoints($id) {
	$ds=mysql_fetch_array(safe_query("SELECT tease FROM ".PREFIX."songs WHERE id='$id'"));
	return getinput($ds['tease']);
}

function getleaguename($id) {
	$ds=mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."leagues WHERE id='$id'"));
	return getinput($ds['name']);
}

function getleaguenamepro($id) {
	$ds=mysql_fetch_array(safe_query("SELECT league FROM ".PREFIX."upcoming WHERE upID='$id'"));
	return getinput($ds['league']);
}

function getleagueid($id) {
	$ds=mysql_fetch_array(safe_query("SELECT id FROM ".PREFIX."leagues WHERE name='$id'"));
	return getinput($ds['id']);
}

function getteamid($id) {
	$ds=mysql_fetch_array(safe_query("SELECT id FROM ".PREFIX."songs WHERE name='$id'"));
	return getinput($ds['id']);
}

function getrelatedleagues($id) {
	$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."leagues WHERE main='$id'"));
	return '<a href="coverage/-/event/'.$ds['id'].'">'.getinput($ds['name']).'</a>';
}

function getleadesc($id) {
	$ds=mysql_fetch_array(safe_query("SELECT text FROM ".PREFIX."leagues WHERE id='$id'"));
	return getinput($ds['text']);
}

function getleaguecov($id) {
	$ds=mysql_fetch_array(safe_query("SELECT id FROM ".PREFIX."leagues WHERE id='$id' AND coverage='1'"));
	return getinput($ds['id']);
}


function getllogourl($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimg FROM ".PREFIX."leagues WHERE id='$id'"));
        if($ds['fullimg'] == '') return '';
	else return 'images/leagues/'.getinput($ds['fullimg']).'';
}

function getllogo($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimg FROM ".PREFIX."leagues WHERE id='$id'"));
        if($ds['fullimg'] == '') return '';
	else return '<div style="clear: both; width: 100%;"><img src="images/leagues/'.getinput($ds['fullimg']).'" class="img-responsive" alt="" /></div>';
}

function getllogoout($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimgout FROM ".PREFIX."leagues WHERE id='$id'"));
        if($ds['fullimgout'] == '') return '';
	else return '<div style="clear: both; width: 100%;"><img src="'.getinput($ds['fullimgout']).'" class="img-responsive" alt=""></div>';
}

//COVERAGE THUMBNAILS START //
function agetllogo($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimg FROM ".PREFIX."leagues WHERE id='$id'"));
    return 'images/leagues/'.getinput($ds['fullimg']).'';
}

function agetllogoout($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimgout FROM ".PREFIX."leagues WHERE id='$id'"));
    return ''.getinput($ds['fullimgout']).'';
}
//COVERAGE THUMBNAILS END

function getallogo($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimg FROM ".PREFIX."leagues WHERE id='$id'"));
        if($ds['fullimg'] == '') return '';
	else return '<img src="../images/leagues/'.getinput($ds['fullimg']).'" width="100px" height="100px" />';
}

function getasmallllogo($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimg FROM ".PREFIX."leagues WHERE id='$id'"));
        if($ds['fullimg'] == '') return '';
	else return '<img src="../images/leagues/'.getinput($ds['fullimg']).'" width="20px" height="16px" />';
}

function getleaguecountry($id) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."leagues WHERE id='$id'"));
	return '<img src="images/flags/'.getinput($ds['country']).'.gif" />';
}

function getleaguegame($id) {
	$ds=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX."leagues WHERE id='$id'"));
	return '<img src="images/games/'.getinput($ds['game']).'.png" />';
}

function getleaguepic($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimg FROM ".PREFIX."leagues WHERE id='$id'"));
	return '<img src="images/leagues/'.getinput($ds['fullimg']).'" width="200px" height="auto" />';
}

function getleaguepicurl($id) {
	$ds=mysql_fetch_array(safe_query("SELECT fullimg FROM ".PREFIX."leagues WHERE id='$id'"));
	return 'images/leagues/'.getinput($ds['fullimg']).'';
}

function getaleaguegame($id) {
	$ds=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX."leagues WHERE id='$id'"));
	return '<img src="../images/games/'.getinput($ds['game']).'.png" />';
}

function getaleaguecountry($id) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."leagues WHERE id='$id'"));
	return '<img src="../images/flags/'.getinput($ds['country']).'.gif" />';
}

function getaleaguecountryname($id) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."countries WHERE countryID='$id'"));
	return getinput($ds['country']);
}

function getgroupname($id) {
	$ds=mysql_fetch_array(safe_query("SELECT gname FROM ".PREFIX."groups WHERE gid='$id'"));
	return getinput($ds['gname']);
}

function getgroupslist($id) {
                $grouplist='Edit Groups: ';
$ergebnis = safe_query("SELECT gid, gname FROM ".PREFIX."groups WHERE league='$id'");
		while($ds= mysql_fetch_array($ergebnis)) {
			$grouplist .='&nbsp;<a href="admincenter.php?site=groups&action=editgroup&gid='.$ds['gid'].'">'.$ds['gname'].'</a>&nbsp;';
		}
	return $grouplist;
}

function getbracketsmode($id) {
	$ds=mysql_fetch_array(safe_query("SELECT bracketsmode FROM ".PREFIX."leagues WHERE id='$id'"));
	return getinput($ds['bracketsmode']);
}

function getnbrackets($id) {
	$ds=mysql_fetch_array(safe_query("SELECT nbrackets FROM ".PREFIX."leagues WHERE id='$id'"));
	return getinput($ds['nbrackets']);
}

function getbteams($id) {
$eng = safe_query("SELECT * FROM `".PREFIX."songs` WHERE game='$id' ORDER BY name");
	while($ds= mysql_fetch_array($eng)) {
            $teamss .= '<option value="'.$ds['id'].'">'.$ds['name'].' ('.getgamename($ds['game']).')</option>';
        }
        return $teamss;
}

function getmapname($mapID) {
	$ds=mysql_fetch_array(safe_query("SELECT map FROM ".PREFIX."maps WHERE mapID='$mapID'"));
	return htmlspecialchars($ds['map']);
}

function getteamplayers($id) {
  $ergebnis=safe_query("SELECT * FROM ".PREFIX."teams_lineups WHERE teamID='".$id."' AND matchID='".$_GET['upID']."'");
	while($ds=mysql_fetch_array($ergebnis)) {
            $country = '[flag]'.getcountry($ds['userID']).'[/flag]';
			$avatar = '<img src="images/avatars/'.getavatar($ds['userID']).'" width="100px" style="margin-right: 5px" />';
			$eavatar = 'images/avatars/'.getavatar($ds['userID']).'';
			$country=flags($country);
			$country=str_replace("images/", "images/", $country);
			$nickname='<a style="color: #FFF; font-weight: 400" href="index.php?site=user&amp;id='.$ds['userID'].'">'.strip_tags(stripslashes(getnickname($ds['userID']))).'</a>';
			$lastname=strip_tags(stripslashes(getlastname($ds['userID'])));
			$lastname=strip_tags(stripslashes(getfirstname($ds['userID'])));
			if($ds['activity']) $activity='<font color="green">'.$_language->module['active'].'</font>';
			else $activity='<font color="red">'.$_language->module['inactive'].'</font>';
			$logo = '<div style="float: left"><img src="images/teams/'.getteamlogo($id).'" width="100px" style="margin-right: 0px" /></div>';
	}
	return $logo;

}

function getteamplayers_slim($id) {
  $ergebnis=safe_query("SELECT * FROM ".PREFIX."teams_lineups WHERE teamID='".$id."' AND matchID='".$_GET['upID']."'");
	while($ds=mysql_fetch_array($ergebnis)) {
            $country = '[flag]'.getcountry($ds['userID']).'[/flag]';
			$avatar = '<img src="images/avatars/'.getavatar($ds['userID']).'" width="100px" style="margin-right: 5px" />';
			$eavatar = 'images/avatars/'.getavatar($ds['userID']).'';
			$country=flags($country);
			$country=str_replace("images/", "images/", $country);
			$nickname='<a style="color: #FFF; font-weight: 400" href="index.php?site=user&amp;id='.$ds['userID'].'">'.strip_tags(stripslashes(getnickname($ds['userID']))).'</a>';
			$lastname=strip_tags(stripslashes(getlastname($ds['userID'])));
			$lastname=strip_tags(stripslashes(getfirstname($ds['userID'])));
			if($ds['activity']) $activity='<font color="green">'.$_language->module['active'].'</font>';
			else $activity='<font color="red">'.$_language->module['inactive'].'</font>';
			$logo = '<div style="float: left"><img src="images/teams/'.getteamlogo($id).'" width="100px" style="margin-right: 0px" /></div>';
			$lineups .= ''.$nickname.'<br \>';
	}
	return $lineups;

}

?>