<?php

$title = "G�osowanie"; 
require_once("includes/head.php");

if(!isset($_POST['vote']))
	error("Spieprzaj dziadu :P - jak chcesz glosowac to wybierz opcje",'error','stats.php');
if($player->vote=='Y')
	error("Nie za duo razy by si� chcia�o g�osowa� ?",'error','stats.php');
$poolno=$db->Execute("SELECT value FROM settings WHERE setting='poll_id'");
$poll = $db->Execute("SELECT id,votes FROM poll WHERE id=".$poolno->fields['value']."");
$poolno->Close();
$votes = explode(",",$poll->fields['votes']);
$votes[$_POST['vote']]++;
$votes = implode(",",$votes);
$db->Execute("UPDATE poll SET votes='".$votes."' WHERE id=".$poll->fields['id'].";");
//$db->Execute("UPDATE players SET vote='Y' WHERE id=".$player->id.";");
$player -> vote = 'Y';
error("Dzi�kujemy za g�os !",'done','stats.php');

require_once("includes/foot.php");
?>