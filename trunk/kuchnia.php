<?php
//@type: F
//@desc: Kuchnia
$title="Kuchnia";
require_once("includes/head.php");
require_once ("includes/funkcje.php");

checklocation($_SERVER['SCRIPT_NAME']);

if ($player -> przemiana > 0) {
	error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!");
}

//! inicjalizacja zmiennych
if (!isset($_GET['akcja'])) 
	$_GET['akcja'] = '';


//! Wyrob grzybkow
if (isset ($_GET['akcja']) && $_GET['akcja'] == 'grzyby') {
	if ($player -> grzyby < 20) {
		error ("Nie masz tyle grzybow zeby gotowac zupe.");
	}
	if ($player -> kuchnia > 4) {
		error ("Co ty gotowac chcesz 5 razy na dzien ? Za goraco tutaj.");
	}
	$player -> grzyby -= 20;
	qDebug( "Current Cook value : {$player->getSkill('cook')}" );
	$var = '122.34343The';
	$float_value_of_var = floatval($var);
	qDebug( $float_value_of_var );
	qDebug( "Math : " . ( 0.04 ). " + " . ( 0.02 ) . " = " . ( 0.04 + 0.02 ) );
	$player -> cook = $player->getSkill( 'cook' ) + 0.01;
	$player -> kuchnia += 1;
	$roll = rand (1,100);
	if ($roll < 25) {
		$player -> energy += 6;
		error ("Zapazyles sobie calkiem niezla zupke. Czujesz przyplyw sil.", 'done');
	} else {
		error ("Mocne to to nie bylo. Nastepnym razem sypnij troche wiecej grzybkow.");
	}
}

//! Smazenie ryb
if (isset ($_GET['akcja']) && $_GET['akcja'] == 'ryby') {
	if ($player -> fish < 10) {
		error ("Nie masz tyle ryb zeby smazyc rybe.");
	}
	if ($player -> kuchnia > 4) {
		error ("Co ty smazyc chcesz 5 razy na dzien ? Za goraco tutaj.");
	}
	$player -> fish -= 10;
	$player -> cook += 0.01;
	$player -> kuchnia += 1;
	$roll = rand (1,100);
	if ($roll < 25) {
		$player -> energy += 6;
		error ("Usmarzyles calkiem niezla rybe. Czujesz przyplyw sil.");
	} else {
		error ("Mocne to to nie bylo. Nastepnym razem daj wiecej ryb.");
	}
}

//! Pedzenie wodki
if (isset ($_GET['akcja']) && $_GET['akcja'] == 'wodka') {
	if ($player -> potato < 20) {
		error ("Nie masz tyle ziemniaków ¿eby zrobiæ bimber.");
	}
	if ($player -> kuchnia > 4) {
		error ("Co ty chcesz robic wodke 5 razy na dzien ? Za goraco tutaj.");
	}
	$player -> potato -= 20;
	$player -> cook += 0.01;
	$player -> kuchnia += 1;
	$roll = rand (1,100);
	if ($roll < 25) {
		$player -> energy += 5;
		error ("Wyrobi³e¶ niez³± wódkê. Czujesz przyp³yw sil.");
	} else {
		error ("Mocne to to nie bylo.");
	}
}

$smarty -> display('kuchnia.tpl');
require_once("includes/foot.php");
?>
