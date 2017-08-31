<?php

function getanzcomments($id, $type) {
	$anz=mysql_num_rows(safe_query("SELECT commentID FROM `".PREFIX."comments` WHERE parentID='$id' AND type='$type'"));
	return $anz;
}

function getrecanzcomments($id, $type) {
	$anz=mysql_num_rows(safe_query("SELECT t.comment_id, u.commentID, u.parentID
							FROM ".PREFIX."zntdev_recomment t 
							LEFT JOIN ".PREFIX."comments u ON u.commentID = t.comment_id
								WHERE u.commentID = t.comment_id AND u.parentID='$id'"));
	return $anz;
}

function getlastcommentposter($id, $type) {
	$ds=mysql_fetch_array(safe_query("SELECT userID, nickname FROM `".PREFIX."comments` WHERE parentID='$id' AND type='$type' ORDER BY date DESC LIMIT 0,1"));
	if($ds['userID']) return getnickname($ds['userID']);
	else return htmlspecialchars($ds['nickname']);
}

function getlastcommentdate($id, $type) {
	$ds=mysql_fetch_array(safe_query("SELECT date FROM `".PREFIX."comments` WHERE parentID='$id' AND type='$type' ORDER BY date DESC LIMIT 0,1"));
	return $ds['date'];
}

function getusernewsposts($userID) {
	$anz=mysql_num_rows(safe_query("SELECT newsID FROM `".PREFIX."news` WHERE poster='$userID' "));
	return $anz;
}

function getusernewscomments($userID) {
	$anz=mysql_num_rows(safe_query("SELECT commentID FROM `".PREFIX."comments` WHERE userID='$userID' AND type='ne'"));
	return $anz;
}

function getusernewsrecomments($userID) {
	$anz=mysql_num_rows(safe_query("SELECT recoID FROM `".PREFIX."zntdev_recomment` WHERE user_id='$userID'"));
	return $anz;
}

function getrubricname($rubricID) {
	$ds=mysql_fetch_array(safe_query("SELECT rubric FROM `".PREFIX."news_rubrics` WHERE rubricID='$rubricID'"));
	return $ds['rubric'];
}

function getrubricnamee($rubricID) {
	$ds=mysql_fetch_array(safe_query("SELECT rubric FROM `".PREFIX."fun_rubrics` WHERE rubricID='$rubricID'"));
	return $ds['rubric'];
}

function getpartnercatname($partnercatID) {
	$ds=mysql_fetch_array(safe_query("SELECT category FROM `".PREFIX."partners_cat` WHERE partnercatID='$partnercatID'"));
	return $ds['category'];
}

function getproductscatname($productscatID) {
	$ds=mysql_fetch_array(safe_query("SELECT category FROM `".PREFIX."products_cat` WHERE productscatID='$productscatID'"));
	return $ds['category'];
}

function getproductscatsmall($productscatID) {
	$ds=mysql_fetch_array(safe_query("SELECT cat_small FROM `".PREFIX."products_cat` WHERE productscatID='$productscatID'"));
	return $ds['cat_small'];
}

function getarticlename($id) {
	$ds=mysql_fetch_array(safe_query("SELECT headline FROM `".PREFIX."news_contents` WHERE newsID='$id'"));
	return $ds['headline'];
}


function getcolor($rubricID) {
	$ds=mysql_fetch_array(safe_query("SELECT color FROM `".PREFIX."news_rubrics` WHERE rubricID='$rubricID'"));
	return $ds['color'];
}

function getrubricpic($rubricID) {
	$ds=mysql_fetch_array(safe_query("SELECT pic FROM `".PREFIX."news_rubrics` WHERE rubricID='$rubricID'"));
	return $ds['pic'];
}

function getlanguage($lang) {
	$ds=mysql_fetch_array(safe_query("SELECT language FROM `".PREFIX."news_languages` WHERE lang='$lang'"));
	return $ds['language'];
}

function select_language($message_array) {
	$i=0;
	foreach($message_array as $val) {
		if($val['lang'] == $_SESSION['language']) $userlang=$i;
		$i++;
	}
	if(isset($userlang)) return $userlang;
	else return 0;
}

function getlanguageid($lang, $message_array) {
	$i=0;
	foreach($message_array as $val) {
		if($val['lang'] == $lang) {
			$return = $i;
			break;
		}
		$i++;
	}
	if(isset($return)) return $return;
}

?>