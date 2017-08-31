<?php

$_language->read_module('login');

if($loggedin) {
	$username= strip_tags(getnickname($userID)); 
	$firstname = strip_tags(getfirstname($userID));
	$lastname = strip_tags(getlastname($userID));
	if(isanyadmin($userID)) $admin='<div><a href="admin/admincenter.php" target="_blank" alt="Admincenter" title="Admincenter"><i class="fa fa-cog"></i> Admin Panel</a><div>';
	else $admin='';
	if(isclanmember($userID) or iscashadmin($userID)) $cashbox='<div style="float: left; margin: 5px 10px 0px 0px"><a href="index.php?site=a_cash_box">a<img src="assets/cash.png" /></a></div>';
	else $cashbox='';
	$anz=getnewmessages($userID);
	if($anz) {
		$newmessages=' (<b>'.$anz.'</b>)';
	}
	else $newmessages='';
	if($getavatar = getavatar($userID)) $l_avatar='<img src="images/avatars/'.$getavatar.'" alt="Avatar" height="30px" width="40px" style="border-radius: 3px;" />';
	else $l_avatar=$_language->module['n_a'];
	
	$teams = '<li><a href="index.php?site=myteams" alt="My Teams" title="'.$_language->module['myteams'].'"><i class="fa fa-caret-right"></i>'.$_language->module['myteams'].'</a></li>';

}
else {
	
	$steamlogin = '<a href="?login"><img src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_noborder.png" style="float: left; margin-top: 12px;" height="36px"></a>';
	
	//set sessiontest variable (checks if session works correctly)
	$_SESSION['ws_sessiontest'] = true;
	
	$login = '<a href="index.php?site=register" class="btn btn-primary">Register</a><a href="index.php?site=login" class="btn btn-inverse">Login</a>';
	echo $login;
	
}

?>