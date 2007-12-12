<?php
//@type: F
//@desc: Praca
$title = "Posredniak";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

if ($player -> hp == 0) {
	error ("Nie mozesz pracowac, poniewaz jestes martwy!");
}

if ($player -> przemiana > 0) {

error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 

}

if( !isset( $_GET['view'] ) )
	$_GET['view'] = '';
if( !isset( $_GET['action'] ) )
	$_GET['action'] = '';

// praca oczyszczanie
if (isset ($_GET['view']) && $_GET['view'] == 'oczyszczanie') {
	$g_min = ($player -> level * 25);
	$smarty -> assign ( array("G_min" => $g_min, "G_max" => $g_max,));
	if (isset ($_GET['action']) && $_GET['action'] == 'oczyszczanie') {
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym!");
		}
		if ($player -> energy < $_POST['amount']) {
		error ("Nie masz tyle energii aby pracowac.");
		}
		$gain = (($player -> level * 25) * $_POST['amount']);
		$player -> energy -= $_POST['amount'];
		$player -> gold += $gain;
		//$db -> Execute("UPDATE players SET energy=energy-".$_POST['amount']." WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET credits=credits+".$gain." WHERE id=".$player -> id);
		$smarty -> assign ( array("Gain" => $gain, "Amount" => $_POST['amount']));
	}
}
// praca dom publiczny
if (isset ($_GET['view']) && $_GET['view'] == 'dom') {
	$g_min = ($player -> level * 20);
	$g_max = ($player -> level * 35);
	$smarty -> assign ( array("G_min" => $g_min, "G_max" => $g_max,));
	if (isset ($_GET['action']) && $_GET['action'] == 'dom') {
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym!");
		}
		if ($player -> energy < $_POST['amount']) {
		error ("Nie masz tyle energii aby pracowac.");
		}
		$roll = rand (20, 35);
		$gain = (($player -> level * $roll) * $_POST['amount']);
		$player -> energy -= $_POST['amount'];
		$player -> gold += $gain;
		//$db -> Execute("UPDATE players SET energy=energy-".$_POST['amount']." WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET credits=credits+".$gain." WHERE id=".$player -> id);
		$smarty -> assign ( array("Gain" => $gain, "Amount" => $_POST['amount']));
	}
}
// praca lesniczy
if (isset ($_GET['view']) && $_GET['view'] == 'lesniczy') {
	$g_min = ($player -> level * 23);
	$g_max = ($player -> level * 31);
	$smarty -> assign ( array("G_min" => $g_min, "G_max" => $g_max,));
	if (isset ($_GET['action']) && $_GET['action'] == 'lesniczy') {
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym!");
		}
		if ($player -> energy < $_POST['amount']) {
		error ("Nie masz tyle energii aby pracowac.");
		}
		$roll = rand (23, 31);
		$gain = (($player -> level * $roll) * $_POST['amount']);
		$player -> energy -= $_POST['amount'];
		$player -> gold += $gain;
		//$db -> Execute("UPDATE players SET energy=energy-".$_POST['amount']." WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET credits=credits+".$gain." WHERE id=".$player -> id);
		$smarty -> assign ( array("Gain" => $gain, "Amount" => $_POST['amount']));
	}
}
// praca mysliwy
if (isset ($_GET['view']) && $_GET['view'] == 'mysliwy') {
	$g_min = ($player -> level * 24);
	$g_max = ($player -> level * 27);
	$smarty -> assign ( array("G_min" => $g_min, "G_max" => $g_max,));
	if (isset ($_GET['action']) && $_GET['action'] == 'mysliwy') {
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym!");
		}
		if ($player -> energy < $_POST['amount']) {
		error ("Nie masz tyle energii aby pracowac.");
		}
		$roll = rand (24, 27);
		$gain = (($player -> level * $roll) * $_POST['amount']);
		$player -> energy -= $_POST['amount'];
		$player -> gold += $gain;
		//$db -> Execute("UPDATE players SET energy=energy-".$_POST['amount']." WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET credits=credits+".$gain." WHERE id=".$player -> id);
		$smarty -> assign ( array("Gain" => $gain, "Amount" => $_POST['amount']));
	}
}
// praca targ
if (isset ($_GET['view']) && $_GET['view'] == 'targ') {
	$g_min = ($player -> level * 19);
	$g_max = ($player -> level * 36);
	$smarty -> assign ( array("G_min" => $g_min, "G_max" => $g_max,));
	if (isset ($_GET['action']) && $_GET['action'] == 'targ') {
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym!");
		}
		if ($player -> energy < $_POST['amount']) {
		error ("Nie masz tyle energii aby pracowac.");
		}
		$roll = rand (19, 36);
		$gain = (($player -> level * $roll) * $_POST['amount']);
		$player -> energy -= $_POST['amount'];
		$player -> gold += $gain;
		//$db -> Execute("UPDATE players SET energy=energy-".$_POST['amount']." WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET credits=credits+".$gain." WHERE id=".$player -> id);
		$smarty -> assign ( array("Gain" => $gain, "Amount" => $_POST['amount']));
	}
}
// praca studnia
if (isset ($_GET['view']) && $_GET['view'] == 'studnia') {
	$g_min = ($player -> level * 23);
	$g_max = ($player -> level * 29);
	$smarty -> assign ( array("G_min" => $g_min, "G_max" => $g_max,));
	if (isset ($_GET['action']) && $_GET['action'] == 'studnia') {
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym!");
		}
		if ($player -> energy < $_POST['amount']) {
		error ("Nie masz tyle energii aby pracowac.");
		}
		$roll = rand (23, 29);
		$gain = (($player -> level * $roll) * $_POST['amount']);
		$player -> energy -= $_POST['amount'];
		$player -> gold += $gain;
		//$db -> Execute("UPDATE players SET energy=energy-".$_POST['amount']." WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET credits=credits+".$gain." WHERE id=".$player -> id);
		$smarty -> assign ( array("Gain" => $gain, "Amount" => $_POST['amount']));
	}
}
// praca woda
if (isset ($_GET['view']) && $_GET['view'] == 'woda') {
	$g_min = ($player -> level * 24);
	$g_max = ($player -> level * 26);
	$smarty -> assign ( array("G_min" => $g_min, "G_max" => $g_max,));
	if (isset ($_GET['action']) && $_GET['action'] == 'woda') {
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym!");
		}
		if ($player -> energy < $_POST['amount']) {
		error ("Nie masz tyle energii aby pracowac.");
		}
		$roll = rand (24, 26);
		$gain = (($player -> level * $roll) * $_POST['amount']);
		$player -> energy -= $_POST['amount'];
		$player -> gold += $gain;
		//$db -> Execute("UPDATE players SET energy=energy-".$_POST['amount']." WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET credits=credits+".$gain." WHERE id=".$player -> id);
		$smarty -> assign ( array("Gain" => $gain, "Amount" => $_POST['amount']));
	}
}
$smarty -> assign (array ("View" => $_GET['view'], "Action" => $_GET['action']));
$smarty -> display ('praca.tpl');

require_once("includes/foot.php");
?>
