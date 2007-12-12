<?php
//@type: F
//@desc: Burdel

$title = "Dom publiczny";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

if( $player->id != 267 )
	error( "Burdel zamkniety - chcesz zeby otwarli - pisz do architekta ");

if ($player -> stan != 'Wolny') {
error ("Nieladnie zdradzac malzonka!!");
}

$cost = ($player -> level * 5100);
$smarty -> assign ("Cost", $cost);


if( isset($_GET['step']) && $_GET['step'] == 'wybierz') {
	switch( $_GET['dziwka'] ) {
		case 'eilena' :
			break;
	}
}

if (isset ($_GET['dziwka']) && $_GET['dziwka'] == 'eilena')
{
	if (isset ($_GET['step']) && $_GET['step'] == 'wybierz')
	{
	if ($player -> credits < $cost)
	{
		error ("Nie masz tyle pieniedzy!");
	}
	$db -> Execute("UPDATE players SET burdel=burdel-1, energy=energy+3, credits=credits-".$cost." WHERE id=".$player -> id);
	$smarty -> assign ("dziwka", "Eilene");
	}
}

$cost2 = ($player -> level * 7300);
$smarty -> assign ("Cost2", $cost2);


if (isset ($_GET['dziwka']) && $_GET['dziwka'] == 'kasandra')
{
	if (isset ($_GET['step']) && $_GET['step'] == 'wybierz')
	{
	if ($player -> credits < $cost2)
	{
		error ("Nie masz tyle pieniedzy!");
	}
	$db -> Execute("UPDATE players SET burdel=burdel-1, energy=energy+5, credits=credits-".$cost2." WHERE id=".$player -> id);
	$smarty -> assign ("dziwka", "Kasandre");
	}
}
$cost3 = ($player -> level * 5100);
$smarty -> assign ("Cost3", $cost3);


if (isset ($_GET['dziwka']) && $_GET['dziwka'] == 'length')
{
	if (isset ($_GET['step']) && $_GET['step'] == 'wybierz')
	{
	if ($player -> credits < $cost3)
	{
		error ("Nie masz tyle pieniedzy!");
	}
	$db -> Execute("UPDATE players SET burdel=burdel-1, energy=energy+3, credits=credits-".$cost3." WHERE id=".$player -> id);
	$smarty -> assign ("dziwka", "Lentgha");
	}
}


$cost4 = ($player -> level * 7300);
$smarty -> assign ("Cost4", $cost4);

if (isset ($_GET['dziwka']) && $_GET['dziwka'] == 'anarion')
{
	if (isset ($_GET['step']) && $_GET['step'] == 'wybierz')
	{
	if ($player -> credits < $cost4)
	{
		error ("Nie masz tyle pieniedzy!");
	}
	$db -> Execute("UPDATE players SET burdel=burdel-1, energy=energy+5, credits=credits-".$cost4." WHERE id=".$player -> id);
	$smarty -> assign ("dziwka", "Anariona");
	}
}

//inicjalizacja zmiennych
if (!isset($_GET['dziwka']))
{
	$_GET['dziwka'] = '';
}
if (!isset($_GET['step']))
{
	$_GET['step'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Dziwka" => $_GET['dziwka'], "Step" => $_GET['step']));
$smarty -> display ('burdel.tpl');

require_once("includes/foot.php");
?>
