<?php
header("Content-Type: text/plain");
if(isset($_GET['to']))
{	
	unset($_GET['link']);
	unset($_GET['url']);
	$mail_text ="<b> Hola ".$_GET['username']."!</b>";
	$mail_text.="Su inscripcipn en <a href='".$_GET['url']."'>".$_GET['title']."</a> se ha realizado correctamente. Su cuenta de inicio de sesión:";
	$mail_text.="Email: ".$_GET['to'];
	$mail_text.="Para finalizar el registro tiene que activar su cuenta haciendo clic en el siguiente enlace:";
	$mail_text.=$_GET['link'];
	$mail_text.="Bienvenido a la Comunidad";
	$mail_text.=$_GET['link']."-".$_GET['title'];
	$to=$_GET['to'];
	$sub="Su cuenta de Enlace Gamer";
	var_dump(mail($to,$sub,str_replace("http://","",$mail_text)));
}
?>