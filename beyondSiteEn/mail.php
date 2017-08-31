<?php

// site info

$settings=safe_query("SELECT * FROM ".PREFIX."settings");
$do=mysql_fetch_array($settings);

$styles=safe_query("SELECT * FROM ".PREFIX."styles");
$dt=mysql_fetch_array($styles);

// sender
$sender_from = $do['adminemail'];

// recipient
$to  = stripslashes($_POST['email']);

// subject
$subject = stripslashes($_POST['subject']);

// message

$message = '
<html>
<head>
  <title>Invitation</title>
</head>
<body>
  <p>An invitation has been sent from '.$dt['title'].' <'.$sender_from.'></p>
  <table>
    <tr>
      <th>'.stripslashes($_POST['msg']).'</th>
    </tr>
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$to . "\r\n";
$headers .= 'From: '.$dt['title'].' <'.$sender_from.'>' . "\r\n";
$headers .= 'Cc: '.$sender_from . "\r\n";

/* PHP form validation: the script checks that the Email field contains a valid email address and the Subject field isn't empty. preg_match performs a regular expression match. It's a very powerful PHP function to validate form fields and other strings - see PHP manual for details. */
if (!preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $to)) {
  echo "<div class='errorbox'>Invalid email address";
  echo "<br><a href='javascript:history.back(1);'><- Go Back</a></div>";
} elseif ($subject == "") {
echo "<div class='errorbox'>No subject</h4></div>";
} elseif ($message == "") {
echo "<div class='errorbox'>No message</h4></div>";
}
// Mail it
elseif (mail($to, $subject, $message, $headers)) {
  echo "<div style='margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;'><b>Your invitation to ".stripslashes($_POST['email'])." has been successfully sent!</b> <img src='images/cup/success.png' width='16' height='16'><br><a href='index.php'><b>Return to Homepage</b></a> | <a href='index.php?site=myteams'><b>My Teams</b></a> | <a href='javascript: history.go(-1)'><b>Invite Another</b></a></div>";
} else {
  echo "<div class='errorbox'>Can't send email to $email</div>";
}
?>