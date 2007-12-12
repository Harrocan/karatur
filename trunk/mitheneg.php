<?php
//@type: F
//@desc: Mithrilowe ¼ród³o
$title = "Mithrilowe zrodlo";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

if (!isset ($_GET['action'])) {
$smarty -> assign ("Iloscmithrilu", $iloscmithrilu -> fields['platinum']);
$smarty -> display ('mitheneg.tpl');
} 
else {
$mithril = ($_POST['mithril'] / 1000);
if ($_POST['mithril'] > $player -> mithril || $_POST['mithril'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['mithril'])) {
error ("Nie masz tyle mithrilu! (<a href=\"mitheneg.php\">wroc</a>)");
}
if ($player -> mithril < $_POST['mithril'] ) {
{
	error ("Masz ju¿ wystarczaj±co!!");
}
} 
else {
//$db -> Execute("UPDATE players SET mit=mit+1 WHERE id=".$player -> id);
//$db -> Execute("UPDATE players SET energy=energy+".$mithril." WHERE id=".$player -> id);
$player -> energy += $mithril;
//$db -> Execute("UPDATE players SET platinum=platinum-".$_POST['mithril']." WHERE id=".$player -> id);
$player -> mithril -= $_POST['mithril'];
error ("Wymieniles <b>".$_POST['mithril']."</b> sztuk mithrilu na <b>".$mithril."</b> energii.",'done');
}
}

require_once("includes/foot.php");
?>
