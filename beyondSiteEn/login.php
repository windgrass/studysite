<?php

$_language->read_module('login');

if($loggedin) {
	$username= strip_tags(getnickname($userID)); 
	$firstname = strip_tags(getfirstname($userID));
	$lastname = strip_tags(getlastname($userID));
	if(isanyadmin($userID)) $admin='<div style="float: right; height: 40px;"><a href="admin/admincenter.php" target="_blank" alt="Admincenter" title="Admincenter"><div style="float: left; height: 60px; width: 40px; margin-right: 3px; background: url(assets/admin.png) no-repeat center center"></div></a></div>';
	else $admin='';
	if(isclanmember($userID) or iscashadmin($userID)) $cashbox='<div style="float: left; margin: 5px 10px 0px 0px"><a href="index.php?site=a_cash_box">a<img src="assets/cash.png" /></a></div>';
	else $cashbox='';
	$anz=getnewmessages($userID);
	if($anz) {
		$newmessages=' (<b>'.$anz.'</b>)';
	}
	else $newmessages='';
	if($getavatar = getavatar($userID)) $l_avatar='<img src="images/avatars/'.$getavatar.'" alt="Avatar" height="30px" width="30px" style="border-radius: 3px;" />';
	else $l_avatar=$_language->module['n_a'];
	
	$teams = '<li><span class="menu3"><a style="color: #FFF; font-weight: 400" href="index.php?site=myteams" alt="My Teams" title="'.$_language->module['myteams'].'">'.$_language->module['myteams'].'</a></span></li>';			
	
	echo'<meta http-equiv="refresh" content="0;URL=index.php?site=loginoverview">';
		
}
else {
	
	$steamlogin = '<a href="?login"><img src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_noborder.png" style="float: left; margin-top: 12px;" height="36px"></a>';
	
	//set sessiontest variable (checks if session works correctly)
	$_SESSION['ws_sessiontest'] = true;
	eval ("\$loginform = \"".gettemplate("login")."\";");
	echo $loginform;
	
echo '</div>';
}

?>