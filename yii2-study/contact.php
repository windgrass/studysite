<?php

require_once('recaptchalib.php');
include("_recaptcha.php");

if(isset($site)) $_language->read_module('contact');

		eval ("\$title_contact = \"".gettemplate("title_contact")."\";");
		echo $title_contact;

if(isset($_POST["action"])) $action=$_POST["action"];
else $action='';

if($action == "send") {
	$getemail = $_POST['getemail'];
	$subject = $_POST['subject'];
	$text = $_POST['text'];
	$text=str_replace('\r\n', "\n", $text);
	$name = $_POST['name'];
	$from = $_POST['from'];
	$run=0;
  
	
  
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."contact WHERE email='".$getemail."'");
	if(mysql_num_rows($ergebnis) == 0){
		$fehler[] = $_language->module['unknown_receiver'];
	}
	
  if($userID) {
		$run=1;
	}
	else {
		//Start recaptcha Mod
		$resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
		if($resp->is_valid) $run=1;
		//End recaptcha Mod
	}
	
	$fehler = array();
	if(!(mb_strlen(trim($name)))) $fehler[] = $_language->module['enter_name'];
	if(!validate_email($from)) $fehler[] = $_language->module['enter_mail'];
	if(!(mb_strlen(trim($subject)))) $fehler[] = $_language->module['enter_subject'];
	if(!(mb_strlen(trim($text)))) $fehler[] = $_language->module['enter_message'];
	if(!$resp->is_valid and !$run) $fehler[]=$_language->module['wrong_securitycode'];
	
  if(!count($fehler) and $run) {
		$header="From:$from\n";
		$header .= "Reply-To: $from\n";
		$header.="Content-Type: text/html; charset=utf-8\n";
		mail($getemail, stripslashes($subject), stripslashes('This mail was send over your Website (IP '.$GLOBALS['ip'].'): '.$hp_url.'<br /><br /><b>'.getinput($name).' writes:</b><br />'.clearfromtags($text)), $header);
		redirect('index.php?site=contact',$_language->module['send_successfull'],3);
		unset($_POST['name']);
		unset($_POST['from']);
		unset($_POST['text']);
		unset($_POST['subject']);
	}
	else {
		$errors=implode('<br />&#8226; ',$fehler);
		
    $showerror = '<div class="errorbox">
      <b>'.$_language->module['errors_there'].':</b><br /><br />
      &#8226; '.$errors.'
    </div>';
	}
}

	$getemail = '';
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."contact ORDER BY sort");
	while($ds=mysql_fetch_array($ergebnis)) {
		if($getemail==$ds['email']) $getemail.='<option value="'.$ds['email'].'" selected="selected">'.$ds['name'].'</option>';
		else $getemail.='<option value="'.$ds['email'].'">'.$ds['name'].'</option>';
	}
	
	$bg1 = BG_1;
	if($loggedin) {
		if(!isset($showerror)) $showerror='';
	    $name=getinput(stripslashes(getnickname($userID)));
	    $from=getinput(getemail($userID));
		if(isset($_POST['subject'])) $subject = getforminput($_POST['subject']);
	    else $subject='';
	    if(isset($_POST['text'])) $text =  getforminput($_POST['text']);
	    else $text='';
		
	    eval ("\$contact_loggedin = \"".gettemplate("contact_loggedin")."\";");
		echo $contact_loggedin;
	} else {
		if(!isset($showerror)) $showerror='';
	   	if(isset($_POST['name'])) $name = getforminput($_POST['name']);
	    else $name='';
	    if(isset($_POST['from'])) $from = getforminput($_POST['from']);
	    else $from='';
	    if(isset($_POST['subject'])) $subject = getforminput($_POST['subject']);
	    else $subject='';
	    if(isset($_POST['text'])) $text = getforminput($_POST['text']);
	    else $text='';

		//Start recaptcha Mod
		$recaptcha = recaptcha_get_html($publickey, $error);
		//End recaptcha Mod
		eval ("\$contact_notloggedin = \"".gettemplate("contact_notloggedin")."\";");
		echo $contact_notloggedin;

}
?>