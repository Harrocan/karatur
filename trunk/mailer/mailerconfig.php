<?php
require_once('class.phpmailer.php');
$mail = new PHPMailer();
$mail -> PluginDir = "./mailer/";
$mail -> SetLanguage("pl", "./mailer/language/");
$mail -> CharSet = "iso-8859-2";
$mail -> IsMail();
//$mail -> From = $gamemail;
$mail -> From = "admin@karatur.unicity.pl";
$mail -> FromName = $gamename;
$mail -> AddAddress($adress);
$mail -> WordWrap = 50;
$mail -> Subject = $subject;
$mail -> Body = $message;

?>
