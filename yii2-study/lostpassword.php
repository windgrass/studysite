<?php

$_language->read_module('lostpassword');

if(isset($_POST['submita'])) {
	$email = trim($_POST['email']);
	if($email!=''){
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."user WHERE email = '".$email."'");
		$anz = mysql_num_rows($ergebnis);
	
		if($anz) {
	
			$newpwd=RandPass(6);
			$newmd5pwd=md5($newpwd);
	
			$ds = mysql_fetch_array($ergebnis);
			safe_query("UPDATE ".PREFIX."user SET password='".$newmd5pwd."' WHERE userID='".$ds['userID']."'");
	
			$ToEmail = $ds['email'];
			$ToName = $ds['username'];
			$vars = Array('%pagetitle%', '%email%', '%new_password%', '%homepage_url%');
			$repl = Array($hp_title, $ds['email'], $newpwd, $hp_url);
			$header = str_replace($vars, $repl, $_language->module['email_subject']);
			$Message = str_replace($vars, $repl, $_language->module['email_text']);
	
			if(mail($ToEmail,$header, $Message, "From:".$admin_email."\nContent-type: text/plain; charset=utf-8\n"))
			echo str_replace($vars, $repl, $_language->module['successful']);
			else echo $_language->module['email_failed'];
	
	
		}
		else {
			echo $_language->module['no_user_found'];
		}
	}
	else{
		echo $_language->module['no_mail_given'];
	}
}
else {
	echo'				<h3 style="margin-top: 0px">Forgotten password</h3>
                        <p>If you have forgotten your password use this form to reset your password. New password will be send to your email.</p>
                        <form method="post" action="index.php?site=lostpassword">
                        	<div class="form-group">
                                <label for="forg_email">'.$_language->module['your_email'].'</label>
                                <input type="email" name="email" class="form-control" id="forg_email" placeholder="Enter email">
                            </div>
                            <button type="submit" name="submita" class="btn btn-primary">Reset password</button>
                        </form>';
}

?>