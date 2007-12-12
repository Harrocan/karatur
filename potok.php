<?php
//@type: F
//@desc: Z³oty potok
$title = "Z³oty Potok";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

if ($player -> hp == 0) {
	error ("Nie mozesz pracowac, poniewaz jestes martwy!");
}

// praca woda
if (isset ($_GET['view']) && $_GET['view'] == 'woda') {
    $g_min = ($player -> level * 0);
    $g_max = ($player -> level * 22);
    $smarty -> assign ( array("G_min" => $g_min, "G_max" => $g_max,));
if (isset ($_GET['action']) && $_GET['action'] == 'woda') {
if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
        error ("Zapomnij o tym!");
    }
    if ($player -> energy < $_POST['amount']) {
	error ("Jestes zbyt zmêczony by szukac z³ota.");
    }
    $roll = rand (0, 22);
    $gain = (($player -> level * $roll) * $_POST['amount']);
    //$db -> Execute("UPDATE players SET energy=energy-".$_POST['amount']." WHERE id=".$player -> id);
    //$db -> Execute("UPDATE players SET credits=credits+".$gain." WHERE id=".$player -> id);
	$player -> energy -= $_POST['amount'];
	$player -> gold += $gain;
    $smarty -> assign ( array("Gain" => $gain, "Amount" => $_POST['amount']));
   }
}
$smarty -> assign (array ("View" => $_GET['view'], "Action" => $_GET['action']));
$smarty -> display ('potok.tpl');

require_once("includes/foot.php");
?>
