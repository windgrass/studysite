<?php

define('MODRWRT_SEP','/');
define('MODRWRT_ADDITIONAL','/');
define('MODRWRT_POWER',1);

require_once("src/modrwrt.class.php");
	
if(MODRWRT_POWER === 1) {
	$modrewrite = new ModRewrite();
	ob_start(array($modrewrite,'outBuffer'));
	$site = $modrewrite->parseCurrentUrl();
	$server_uri = $modrewrite->uri;
}
else {
	$server_uri = $_SERVER['QUERY_STRING'];
}

?>