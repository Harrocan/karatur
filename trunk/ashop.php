<?php
//@type: F
//@desc: Sklep z grzybkami
$title = "Sklep z Grzybami";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

$price= rand(75,150);
if (!isset ($_GET['action'])) {
	$smarty -> assign ("Price", $price);
	$smarty -> display ('ashop.tpl');
}
else {
	$cost = ($_POST['grzy'] * $price);
	if ($cost > $player -> gold || $_POST['grzy'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['grzy'])) {
		error ("Nie stac cie! (<a href=ashop.php>wroc</a>)");
	} 
	else {
		//$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET grzyby=grzyby+".$_POST['grzy']." WHERE id=".$player -> id);
		$player -> gold -= $cost;
		$player -> grzyby += $_POST['grzy'];
		error ("Kupiles <b>".$_POST['grzy']."</b> sztuk grzybow za <b>".$cost."</b> sztuk zlota.",'done');
	}
}

require_once("includes/foot.php");
?>

