<?php
print "asdzxc";
die();
include("_mysql.php");
include("_settings.php");

// copy pagelock information for session test + deactivated pagelock for checklogin
$closed_tmp = $closed;
$closed = 0;

include("_functions.php");

//settings

$sleep = 1; //idle status for script if password is wrong?

//settings end
$_language->read_module('checklogin');

$get = safe_query("SELECT * FROM ".PREFIX."banned_ips WHERE ip='".$GLOBALS['ip']."'");
if(mysql_num_rows($get) == 0){
	$ws_pwd = md5(stripslashes($_POST['pwd']));
	$ws_user = $_POST['ws_user'];
	
        $check = safe_query("SELECT * FROM ".PREFIX."user WHERE email='".$ws_user."'");
	$anz = mysql_num_rows($check);
	$login = 0;
	
	if(!$closed_tmp AND !isset($_SESSION['ws_sessiontest'])) {
		$error = $_language->module['session_error'];
	}
	else {
		if($anz) {
		
                        $check = safe_query("SELECT * FROM ".PREFIX."user WHERE email='".$ws_user."' AND activated='1'");
			if(mysql_num_rows($check)) {
		
				$ds=mysql_fetch_array($check);
		
				// check password
				$login = 0;
				if($ws_pwd == $ds['password']) {
		
					//session
					$_SESSION['ws_auth'] = $ds['userID'].":".$ws_pwd;
					$_SESSION['ws_lastlogin'] = $ds['lastlogin'];
					$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
					//remove sessiontest variable
					if(isset($_SESSION['ws_sessiontest'])) unset($_SESSION['ws_sessiontest']);
					//cookie
					setcookie("ws_auth", $ds['userID'].":".$ws_pwd, time()+($sessionduration*60*60));					
					//Delete visitor with same IP from whoisonline
					safe_query("DELETE FROM ".PREFIX."whoisonline WHERE ip='".$GLOBALS['ip']."'");
					//Delete IP from failed logins
					safe_query("DELETE FROM ".PREFIX."failed_login_attempts WHERE ip = '".$GLOBALS['ip']."'");
					$login = 1;
					$error = $_language->module['login_successful'];
				}
				elseif(!($ws_pwd == $ds['password'])) {
					if($sleep) sleep(5);
					$get = safe_query("SELECT wrong FROM ".PREFIX."failed_login_attempts WHERE ip = '".$GLOBALS['ip']."'");
					if(mysql_num_rows($get)){
						safe_query("UPDATE ".PREFIX."failed_login_attempts SET wrong = wrong+1 WHERE ip = '".$GLOBALS['ip']."'");
					}
					else{
						safe_query("INSERT INTO ".PREFIX."failed_login_attempts (ip,wrong) VALUES ('".$GLOBALS['ip']."',1)");
					}
					$get = safe_query("SELECT wrong FROM ".PREFIX."failed_login_attempts WHERE ip = '".$GLOBALS['ip']."'");
					if(mysql_num_rows($get)){
						$ban = mysql_fetch_assoc($get);
						if($ban['wrong'] == $max_wrong_pw){
							$bantime = time() + (60*60*3); // 3 hours
							safe_query("INSERT INTO ".PREFIX."banned_ips (ip,deltime,reason) VALUES ('".$GLOBALS['ip']."',".$bantime.",'Possible brute force attack')");
							safe_query("DELETE FROM ".PREFIX."failed_login_attempts WHERE ip = '".$GLOBALS['ip']."'");
						}
					}
					$error= $_language->module['invalid_password'];
				}
			}
			else $error= $_language->module['not_activated'];
		
		}
		else $error=str_replace('%username%', htmlspecialchars($ws_user), $_language->module['no_user']);
	}
}
else{
	$login = 0;
	$data = mysql_fetch_assoc($get);
	$error = str_replace('%reason%', $data['reason'], $_language->module['ip_banned']);
}
?>

<?php
 $referer = $_SERVER["HTTP_REFERER"];
 if($login) {
  if(isset($referer)) echo '<meta http-equiv="refresh" content="0;URL='.$referer.'">';
  else echo '<meta http-equiv="refresh" content="0;URL=index.php?site=profile">';
 }
?>