<?php
//@type: F
//@desc: Kawiarnia
$title = "Kawiarnia";
require_once("includes/head.php");


// nie ta lokacja
//checklocation($_SERVER['SCRIPT_NAME']);

if (!isset($_GET['step'])) {
	$_GET['step'] = '';
}

// KAWY;
$cost['kawa']['jedn'] = 'filizanke';
$cost['kawa']['mk']['energy'] = 0.001;
$cost['kawa']['mk']['cost'] = 100;
$cost['kawa']['mk']['what'] = 'malej kawy';
$cost['kawa']['sk']['energy'] = 0.002;
$cost['kawa']['sk']['cost'] = 200;
$cost['kawa']['sk']['what'] = 'sredniej kawy';
$cost['kawa']['dk']['energy'] = 0.005;
$cost['kawa']['dk']['cost'] = 500;
$cost['kawa']['dk']['what'] = 'duzej kawy';
// CIASTA;
$cost['ciasto']['jedn'] = 'kawalek';
$cost['ciasto']['ser']['energy'] = 0.01;
$cost['ciasto']['ser']['cost'] = 1000;
$cost['ciasto']['ser']['what'] = 'sernika';
$cost['ciasto']['pw']['energy'] = 0.02;
$cost['ciasto']['pw']['cost'] = 2000;
$cost['ciasto']['pw']['what'] = 'pijanej wisni';
// HERBATY;
$cost['herbata']['jedn'] = 'imbryk';
$cost['herbata']['zh']['energy'] = 0.03;
$cost['herbata']['zh']['cost'] = 3000;
$cost['herbata']['zh']['what'] = 'zielonej herbaty';
$cost['herbata']['ck']['energy'] = 0.05;
$cost['herbata']['ck']['cost'] = 5000;
$cost['herbata']['ch']['what'] = 'czerwonej herbaty';
$cost['herbata']['hzw']['energy'] = 0.08;
$cost['herbata']['hzw']['cost'] = 8000;
$cost['herbata']['hzw']['what'] = 'herbaty z wodka';
//ALKOHOLE;
$cost['alkohol']['jedn'] = 'kieliszek';
$cost['alkohol']['sz']['energy'] = 0.13;
$cost['alkohol']['sz']['cost'] = 13000;
$cost['alkohol']['sz']['what'] = 'szampana';;
$cost['alkohol']['wi']['energy'] = 0.15;
$cost['alkohol']['wi']['cost'] = 15000;
$cost['alkohol']['wi']['what'] = 'wina';
$cost['alkohol']['pi']['energy'] = 0.1;
$cost['alkohol']['pi']['cost'] = 10000;
$cost['alkohol']['pi']['what'] = 'piwa';
$cost['alkohol']['wo']['energy'] = 0.25;
$cost['alkohol']['wo']['cost'] = 25000;
$cost['alkohol']['wo']['what'] = 'wodki';

// wstaw swoj¹ cene jak chcesz zamiast "10";
$smarty->assign( "Cost", $cost );
//$cost = (100);
//$smarty -> assign ("Cost", $cost);

if( $_GET['step'] == 'wybierz' ) {
	if( !isset( $cost[$_GET['type']][$_GET['what']] ) ) {
		error( "Nieprawidlowy wybor !" );
	}
	$item = $cost[$_GET['type']][$_GET['what']];
	$smarty->assign( "Jedn", $cost[$_GET['type']]['jedn'] );
	$smarty->assign( array( "Type" => $_GET['type'], "What" => $_GET['what'] ) );
	$smarty->assign( "Item", $item );
}

if( $_GET['step'] == 'kup' ) {
	if( !isset( $cost[$_GET['type']][$_GET['what']] ) ) {
		error( "Nieprawidlowy wybor !" );
	}
	$item = $cost[$_GET['type']][$_GET['what']];
	if( $player->gold < $item['cost'] ) {
		error( "Nie masz tyle pieniedzy przy sobie !" );
	}
	$player->gold -= $item['cost'];
	$player->energy += $item['energy'];
	error( "Po spozyciu zamowienia i porozmawianiu z roznymi ludzmi poczulej sie rozluzniony i twa energia wzrosla", 'done' );
}


// przypisanie zmiennych oraz wyswietlenie strony
//$smarty -> assign ( array("Kawka" => $_GET['kawka'], "Step" => $_GET['step'], "Ciasto" => $_GET['ciasto'], "Alk" => $_GET['alk'], "Herbatka" => $_GET['herbatka'],"opis" => $player -> kawka, "opis1" => $player -> ciasto, "opis2" => $player -> herbatka, "opis3" => $player -> alk));
$smarty -> assign ( array( "Step" => $_GET['step'] ) );
$smarty -> display ('kawiarnia.tpl');

require_once("includes/foot.php"); 
?>
