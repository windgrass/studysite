<?php

$GLOBALS['ip'] = $_SERVER['REMOTE_ADDR'];
if(!$GLOBALS['ip']) $GLOBALS['ip']=getenv('REMOTE_ADDR');
?>