<?php

$_language->read_module('newsletter');

if($loggedin){
	$usermail = getemail($userID);
}
else{
	$usermail = "";
}

eval ("\$sc_newsletter = \"".gettemplate("sc_newsletter")."\";");
echo $sc_newsletter;

?>