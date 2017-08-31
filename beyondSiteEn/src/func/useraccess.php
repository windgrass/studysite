<?php

function isshopadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (shop='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function isleader($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."teams_members` WHERE position='Leader' AND userID='".$userID."'"));
	return $anz;
}

function iscaptain($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."teams_members` WHERE position='Captain' AND userID='".$userID."'"));
	return $anz;
}

function isanyadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE userID='".$userID."' AND (news='1' OR news_writer='1' OR user='1' OR newsletter='1' OR videos='1' OR streams='1' OR gallery='1' OR matches='1' OR leagues='1' OR coverage='1' OR teams='1' OR super='1' OR shop='1') "));
	return $anz;
}

function isnewsletteradmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (newsletter='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function isvideosadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (videos='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function isstreamsadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (streams='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function ismatchesadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (matches='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function isleaguesadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (leagues='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function iscoverageadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (coverage='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function isteamsadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (teams='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function issuperadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE super='1' AND userID='".$userID."'"));
	return $anz;
}

function isforumadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE (forum='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function isfileadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE (super='1') AND userID='".$userID."'"));
	return $anz;
}

function ispageadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE (page='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function isfeedbackadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE (super='1') AND userID='".$userID."'"));
	return $anz;
}

function isnewsadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE (news='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function isnewswriter($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE (news='1' OR super='1' OR news_writer='1') AND userID='".$userID."'"));
	return $anz;
}

function ispollsadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE (polls='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function isclanwaradmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE (clanwars='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function ismoderator($userID, $boardID) {
	if(!$userID OR !$boardID) return false;
	else {
		if(!isanymoderator($userID)) return false;
		$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."forum_moderators WHERE userID='".$userID."' AND boardID='".$boardID."'"));
		return $anz;
	}
}

function isanymoderator($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_groups WHERE userID='".$userID."' AND moderator='1'"));
	return $anz;
}

function isuseradmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (user='1' OR super='1') AND userID='".$userID."'"));
	if(!$anz) $anz=issuperadmin($userID);
	return $anz;
}

function iscashadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (cash='1' OR super='1') AND userID='".$userID."'"));
	if(!$anz) $anz=issuperadmin($userID);
	return $anz;
}

function isgalleryadmin($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user_groups` WHERE (gallery='1' OR super='1') AND userID='".$userID."'"));
	return $anz;
}

function isclanmember($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."squads_members` WHERE userID='".$userID."'"));
	if(!$anz) $anz=issuperadmin($userID);
	return $anz;
}

function isjoinusmember($userID) {
	$anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."squads_members` WHERE userID='".$userID."'"));
	if(!$anz) $anz=issuperadmin($userID);
	return $anz;
}

function isbanned($userID) {
  $anz=mysql_num_rows(safe_query("SELECT userID FROM `".PREFIX."user` WHERE userID='$userID' AND (banned='perm' OR banned IS NOT NULL)"));
	return $anz;
}

function getusercomments($userID, $type) {
	$anz=mysql_num_rows(safe_query("SELECT commentID FROM `".PREFIX."comments` WHERE userID='".$userID."' AND type='".$type."'"));
	return $anz;
}

function iscommentposter($userID,$commID) {
	if(!$userID OR !$commID) return false;
	else {
		$anz = mysql_num_rows(safe_query("SELECT commentID FROM ".PREFIX."comments WHERE commentID='".$commID."' AND userID='".$userID."'"));
		return $anz;
	}
}

function isforumposter($userID, $postID) {
	$anz = mysql_num_rows(safe_query("SELECT postID FROM ".PREFIX."forum_posts WHERE postID='".$postID."' AND poster='".$userID."'"));
	return $anz;
}

function istopicpost($topicID, $postID) {
	$ds=mysql_fetch_array(safe_query("SELECT postID FROM ".PREFIX."forum_posts WHERE topicID='".$topicID."' ORDER BY date ASC LIMIT 0,1"));
	if($ds['postID']==$postID) return true;
	else return false;
}

function isinusergrp($usergrp, $userID, $sp=1) {
	if($usergrp == 'user' and $userID != 0) return 1;
	if(!usergrpexists($usergrp)) return 0;
	$anz=mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."user_forum_groups WHERE (`".$usergrp."`=1) AND userID='".$userID."'"));
	if($sp) if(!$anz) $anz=isforumadmin($userID);
	return $anz;
}

?>