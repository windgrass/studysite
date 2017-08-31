<?php

require_once('recaptchalib.php');
include("_recaptcha.php");

$_language->read_module('register');

		eval("\$title_register = \"".gettemplate("title_register")."\";");
		echo $title_register;

$show = true;
if(isset($_POST['save'])) {

	//register_globals = off
	if(!$loggedin){
	// $nickname = htmlspecialchars(mb_substr(trim($_POST['nickname']), 0, 30));
	$pwd1 = $_POST['pwd1'];
	$pwd2 = $_POST['pwd2'];
	$mail = $_POST['mail'];
	$sex = $_POST['sex'];
	$username = htmlspecialchars(mb_substr(trim($_POST['nickname']), 0, 30));
	$country = $_POST['country'];
	$homepage = $_POST['homepage'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$birthday = $b_year.'-'.$b_month.'-'.$b_day;
	$b_month=$_POST['b_month'];
	$b_day=$_POST['b_day'];
	$b_year=$_POST['b_year'];
	$flag = preg_replace("/[^a-zA-Z0-9\s]/", "", $_POST['flag']);
		$resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
		if($resp->is_valid) $run=1;
	
	$error = array();
  	
  // check nickname
	if(!(mb_strlen(trim($username)))) $error[]=$_language->module['enter_nickname'];
	
	// check name
	if(!(mb_strlen(trim($firstname)))) $error[]=$_language->module['enter_name'];
  
  // check nickname in use
	$ergebnis = safe_query("SELECT * FROM ".PREFIX."user WHERE username = '$nickname' ");
	$num = mysql_num_rows($ergebnis);
	if($num) $error[]=$_language->module['nickname_inuse'];
  
  // check password
	if($pwd1 == $pwd2) {
		if(!(mb_strlen(trim($pwd1)))) $error[]=$_language->module['enter_password'];
	}
	else $error[]=$_language->module['repeat_invalid'];
  
  // check e-mail
	$sem = '^[a-z0-9_\.-]+@[a-z0-9_-]+\.[a-z0-9_\.-]+$';
	if(!(eregi($sem, $mail))) $error[]=$_language->module['invalid_mail'];
  
  // check e-mail in use
	$ergebnis = safe_query("SELECT userID FROM ".PREFIX."user WHERE email = '$mail' ");
	$num = mysql_num_rows($ergebnis);
	if($num) $error[]=$_language->module['mail_inuse'];
  
 // check captcha 
	    if (empty($_POST["recaptcha_response_field"]) or (!$run)) $error[]=$_language->module['wrong_securitycode'];
  
  	if(count($error)) {
    	$list = implode('<br />&#8226; ', $error);
    	$showerror = '<div class="alert alert-danger">
      	<b>'.$_language->module['errors_there'].'</b><br />
      	&#8226; '.$list.'
    	</div>';
	}
	else {
			// insert in db
			$md5pwd = md5(stripslashes($pwd1));
			$registerdate=time();
			$activationkey = createkey(20);
			$activationlink="http://".$hp_url."/index.php?site=register&key=".$activationkey;
	
			safe_query("INSERT INTO `".PREFIX."user` (`registerdate`, `lastlogin`, `password`, `username`, `nickname`, `email`, `sex`, `country`, `homepage`, `firstname`, `lastname`, `birthday`, `language`, `newsletter`, `activated`) VALUES ('$registerdate', '$registerdate', '$md5pwd', '$username', '$username', '$mail', '$sex', '$country', '$homepage', '$firstname', '$lastname', '$birthday', '$language', '1', '".$activationkey."')");

			$insertid = mysql_insert_id();
	
			// insert in user_groups
			safe_query("INSERT INTO ".PREFIX."user_groups ( userID ) values('$insertid' )");
	
			///// mail to user

		$regmail = $mail;
		require_once("src/PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug = 1;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl'; // ssl
		$mail->CharSet = "UTF-8";
		/* $mail->Host= "localhost"; // smtp.gmail.com
		$mail->Port = 25; // 465 . 587 . 25 */
		
		$mail->Host= "s1-saopaulo.accountservergroup.com"; // smtp.gmail.com
		$mail->Port = 465; // 465 . 587 . 25
		
		$mail->IsHTML(true);
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->Username = "noreply@enlacegamer.com"; // caosk.esports@gmail.com
		$mail->Password = "EzEnTah5mny7"; // caosk1337
		$mail->AddReplyTo($admin_email, 'No Reply EnlaceGamer'); // Svara till adminmail
		$mail->SetFrom($admin_email, 'No Reply EnlaceGamer'); // SKICKAT FRƎ adminmail
		$mailsubject = str_replace(Array('%username%', '%mail%', '%password%', '%activationlink%', '%pagetitle%', '%homepage_url%'), Array(stripslashes($username), stripslashes($regmail), stripslashes($pwd1), stripslashes($activationlink), $hp_title, $hp_url), $_language->module['mail_subject']);
		$mail->Subject = $mailsubject;
		$bodycontent = str_replace(Array('%username%', '%mail%', '%password%', '%activationlink%', '%pagetitle%', '%homepage_url%'), Array(stripslashes($username), stripslashes($regmail), stripslashes($pwd1), stripslashes($activationlink), $hp_title, $hp_url), $_language->module['mail_text']);
		$mail->Body = $bodycontent;
		$mail->AddAddress($regmail, $username); // to
		
		$mail->Send();
		
		if(!$mail->Send()) {
			redirect("index.php",$_language->module['mail_failed'],3);
			$show = false;
		}
		else {
			redirect("index.php",$_language->module['register_successful'],45);
			$show = false;
		}
		}
	}
	else{
		redirect("index.php?site=register",str_replace('%pagename%',$GLOBALS['hp_title'],$_language->module['no_register_when_loggedin']),3);
	}
}
if(isset($_GET['key'])) {

	safe_query("UPDATE `".PREFIX."user` SET activated='1' WHERE activated='".$_GET['key']."'");
	if(mysql_affected_rows()) redirect('index.php',$_language->module['activation_successful'],3);
	else redirect('index.php',$_language->module['wrong_activationkey'],3);

}
elseif(isset($_GET['mailkey'])) {

	safe_query("UPDATE `".PREFIX."user` SET email_activate='1', email=email_change, email_change='' WHERE email_activate='".$_GET['mailkey']."'");
	if(mysql_affected_rows()) redirect('index.php',$_language->module['mail_activation_successful'],3);
	else redirect('index.php',$_language->module['wrong_activationkey'],3);

}
else {
	if($show == true){
	    if(!$loggedin){
		$CAPCLASS = new Captcha;
		$captcha = $CAPCLASS->create_captcha();
		$hash = $CAPCLASS->get_hash();
		$CAPCLASS->clear_oldcaptcha();
		
	
		if(!isset($showerror)) $showerror='';
		if(isset($_POST['nickname'])) $nickname=getforminput($_POST['nickname']);
		else $nickname='';
		if(isset($_POST['pwd1'])) $pwd1=getforminput($_POST['pwd1']);
		else $pwd1='';
		if(isset($_POST['pwd2'])) $pwd2=getforminput($_POST['pwd2']);
		else $pwd2='';
		if(isset($_POST['mail'])) $mail=getforminput($_POST['mail']);
		else $mail='';
		
			$recaptcha = recaptcha_get_html($publickey, $error);
	
		eval("\$register = \"".gettemplate("register")."\";");
		echo $register;
           }
           else{
		redirect("index.php",str_replace('%pagename%',$GLOBALS['hp_title'],$_language->module['no_register_when_loggedin']),3);
	   }
	}
}
?>