<?php

//**************************************
//* Movie-Addon v2.0 by FIRSTBORN e.V. *
//**************************************

if(!isfileadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die("access denied");

$_language->read_module('movies');

if(isfileadmin($userID)) {

if($_GET['action']=="activate") { 
	if(safe_query("UPDATE ".PREFIX."movies SET activated='2' WHERE movID='".$_GET["movID"]."'"))	redirect("admincenter.php?site=movactivation", "".$_language->module['mov_act'].".", "3");
	else redirect("admincenter.php?site=movactivation", "".$_language->module['no_mov_act']."!", "3");
	

	
}
else {
	
	echo'<h2>movies</h2>
       <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movies\');return document.MM_returnValue" value="'.$_language->module['show_act_movs'].'">
		<h2>'.$_language->module['exist_movs'].'</h2>
		<form method="post" action="admincenter.php?site=features">
		<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#999999">
			<tr bgcolor="#CCCCCC">
				<td class="title">'.$_language->module['headline'].':</td>
				<td class="title">'.$_language->module['category'].':</td>
				<td class="title">'.$_language->module['uploader'].':</td>
				<td class="title">'.$_language->module['screen'].':</td>
				<td class="title">'.$_language->module['description'].':</td>
				<td class="title">'.$_language->module['actions'].':</td>
			</tr>
			<tr bgcolor="#EEEEEE">
				<td colspan="5"></td>
			</tr>';
	$qry=safe_query("SELECT * FROM ".PREFIX."movies WHERE activated='1' ORDER BY movheadline");
	$anz=mysql_num_rows($qry);
	if($anz) {
		while($ds = mysql_fetch_array($qry)) {
		
			

			echo'
				<tr bgcolor="#FFFFFF">
					<td><a href="../index.php?site=movies&action=show&id='.$ds[movID].'" target="_blank">'.$ds[movheadline].'</a></td>
					<td>'.getmovcat($ds[movcatID]).'</td>
					<td>'.getnickname($ds[uploader]).'</td>
					<td><a href="../index.php?site=movies&action=show&id='.$ds[movID].'" target="_blank"><img src="../images/movies/'.$ds[movscreenshot].'" width="200" height="115" border="0" alt="'.$ds['movheadline'].'"></a></td>
					<td>'.$ds[movdescription].'</td>
					<td>
				   <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movactivation&action=activate&movID='.$ds[movID].'\');return document.MM_returnValue" value="'.$_language->module['activate'].'"> <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movies&action=edit&movID='.$ds[movID].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'"> <input type="button" class="button" onClick="MM_confirm(\'really delete this movie?\', \'admincenter.php?site=movies&delete=true&movID='.$ds[movID].'\')" value="'.$_language->module['del'].'"></td>
					</td>
				</tr>
			';
		}
	} else echo'<tr><td colspan="4">'.$_language->module['no_entries'].'</td></tr>';
	echo '</table>';
}

}
else {
 echo ''.$_language->module['no_perm'].'';
}

?>