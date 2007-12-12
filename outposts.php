<?php
//@type: F
//@desc: Stra¿nica
/**
*   Funkcje pliku:
*   straznice graczy i wszystko co z nimi zwiazane oprocz zoldu
*
*   @name                 : outposts.php
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : thindil <thindil@users.sourceforge.net>
*   @version              : 0.7 beta
*   @since                : 27.01.2005
*
*/

//
//
//       This program is free software; you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation; either version 2 of the License, or
//   (at your option) any later version.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of the GNU General Public License
//   along with this program; if not, write to the Free Software
//   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
// 

// tytul strony
$title = "Straznica";

// dolaczenie gornej oraz lewej czesci strony
require_once("includes/head.php");

// sprawdzenie czy gracz znajduje sie w miescie, jezeli nie to zablokowanie dostepu
checklocation($_SERVER['SCRIPT_NAME']);;


// inicjalizacja zmiennych
$smarty -> assign(array("Message" => '', "Result" => ''));

//funkcja odpowiedzialna za wyswietlanie ekwipunku jaki moze zostac przypisany do weteranow - opancerzenie
function equip($type) {
	global $player;
	global $db;
	global $arrid;
	global $arrname;
	global $arrpower;
	$armor = $db -> Execute("SELECT id, name, power FROM equipment WHERE owner=".$player -> id." AND type='".$type."' AND status='U'");
	$arrid = array(0);
	$arrname = array('brak');
	$arrpower = array(0);
	$i = 1;
	while (!$armor -> EOF) {
		$arrid[$i] = $armor -> fields['id'];
		$arrname[$i] = $armor -> fields['name'];
		$arrpower[$i] = ceil($armor -> fields['power'] / 10);
		$armor -> MoveNext();
		$i = $i + 1;
	}
	$armor -> Close();
}

//funkcja odpowiedzialna za ekwipowanie weteranow
function wear($eid,$vid,$type,$powertype) {
	global $player;
	global $db;
	//$item1 = $db -> Execute("SELECT name, power, amount FROM equipment WHERE id=".$eid." AND owner=".$player -> id);
	$item1 = $player -> EquipSearch( array( 'id' => $eid ) );
	$key = key( $item1 );
	$item1 = array_shift( $item1 );
	$item = array($item1['name'], $item1['power']);
	$info = $item[0]." (sila: ".$item[1].") ";
	//$item1 -> Close();
	if ($item1['amount']  <= 1) {
		$player -> EquipDelete( $eid );
		//$db -> Execute("DELETE FROM equipment WHERE id=".$eid." AND owner=".$player -> id);
	} else {
		$player -> SetEquip( 'backpack', $key, array( 'amount' => ( $item['amount'] - 1 ) ) );
		//$db -> Execute("UPDATE equipment SET amount=amount-1 WHERE id=".$eid." AND owner=".$player -> id);
	}
	$db -> Execute("UPDATE outpost_veterans SET ".$type."='".$item[0]."' WHERE id=".$vid);
	$db -> Execute("UPDATE outpost_veterans SET ".$powertype."=".$item[1]." WHERE id=".$vid);
	return $info;
}

/**
* Funkcja odpowiedzialna za wyswietlanie liczby bestii, weteranow oraz budynkow specjalnych.
* Dodatkowo obliczanie kosztow utrzymania jednostek specjalnych
*/
function showspecials($table, $field) {
	global $out;
	global $db;
	global $smarty;
	global $maxarmy;
	global $cost1;
	global $numarmy;
	$query = $db -> Execute("SELECT id FROM outpost_".$table." WHERE outpost=".$out -> fields['id']);
	$numarmy = $query -> RecordCount();
	$query -> Close();
	$maxarmy = $out -> fields[$field] - $numarmy;
	$cost1 = $numarmy * 70;
	if ($numarmy) {
		$army = $db -> Execute("SELECT * FROM outpost_".$table." WHERE outpost=".$out -> fields['id']);
		$arrname = array();
		$arrpower = array();
		$arrdefense = array();
		if ($table == 'veterans') {
			$arrid = array();
		}
		$i = 0;
		while (!$army -> EOF) {
			$arrname[$i] = $army -> fields['name'];
			if ($table == 'monsters') {
				$arrpower[$i] = $army -> fields['power'];
				$arrdefense[$i] = $army -> fields['defense'];
			} else {
				$arrid[$i] = $army -> fields['id'];
				$arrpower[$i] = $army -> fields['wpower'] + 1;
				$arrdefense[$i] = $army -> fields['apower'] + $army -> fields['hpower'] + $army -> fields['lpower'] + 1;
			}
			$army -> MoveNext();
			$i = $i + 1;
		}
		$army -> Close();
		if ($table == 'monsters') {
			$smarty -> assign(array("Mname" => $arrname, "Mpower" => $arrpower, "Mdefense" => $arrdefense, "Mid" => 1));
		} else {
			$smarty -> assign(array("Vname" => $arrname, "Vpower" => $arrpower, "Vdefense" => $arrdefense, "Vid" => $arrid));
		}
	} else {
		if ($table == 'monsters') {
			$smarty -> assign("Mid", 0);
		} else {
			$smarty -> assign("Vid", 0);
		}
	}
}

// funkcja obliczajaca straty w bestiach i weteranach podczas walki
function lostspecials($table, $user, $arrid, $arrname) {
	global $db;
	$i = 0;
	$info = '';
	if ($table == 'monsters') {
		$type = 'bestie';
	} else {
		$type = 'weterana';
	}
	if (!$user) {
		$lost = 'sz';
	} else {
		$lost = '';
	}
	foreach ($arrname as $name) {
		$roll = rand(1,100);
		if ($roll < 6) {
			$db -> Execute("DELETE FROM outpost_".$table." WHERE id=".$arrid[$i]);
			$info = $info."Dodatkowo ".$user." traci".$lost." ".$type." ".$name."<br />";
		}
		$i = $i + 1;
	}
	return $info;
}

/**
* Funkcja obliczajaca atak oraz obrone straznicy
*/
function outpoststats($outpost,$veteran,$monster) {
	global $attack;
	global $defense;
	global $arrvname;
	global $arrvid;
	global $arrmname;
	global $arrmid;
	global $db;
	$attack1 = ($outpost -> fields['warriors'] * 3) + $outpost -> fields['archers'] + ($outpost -> fields['catapults'] * 3);
	$defense1 = $outpost -> fields['warriors'] + ($outpost -> fields['archers'] * 3) + ($outpost -> fields['barricades'] * 3);
	$arrmid = array();
	$arrmname = array();
	$arrvid = array();
	$arrvname = array();
	$i = 0;
	while (!$monster -> EOF) {
		$attack1 = $attack1 + $monster -> fields['power'];
		$defense1 = $defense1 + $monster -> fields['defense'];
		$arrmid[$i] = $monster -> fields['id'];
		$arrmname[$i] = $monster -> fields['name'];
		$monster -> MoveNext();
		$i = $i + 1;
	}
	$monster -> Close();
	$i = 0;
	while (!$veteran -> EOF) {
		$attack1 = $attack1 + $veteran -> fields['wpower'] + 1;
		$defense1 = $defense1 + $veteran -> fields['apower']  + $veteran -> fields['hpower']  + $veteran -> fields['lpower'] + 1;
		$arrvid[$i] = $veteran -> fields['id'];
		$arrvname[$i] = $veteran -> fields['name'];
		$veteran -> MoveNext();
		$i = $i + 1;
	}
	$veteran -> Close();
	$bonus = (rand(-5,5) / 100);
	$fltAttack1 = 0;
	$fltDefense1 = 0;
	if ($outpost -> fields['morale'] >= 50)
	{
		if ($outpost -> fields['morale'] == 50)
		{
			$intBonus = 0.05;
		}
			else
		{
			$intBonus = floor(($outpost -> fields['morale'] - 50) / 75);
			$intBonus = $intBonus * 5;
			if ($intBonus > 80)
			{
				$intBonus = 80;
			}
		}
	}
	if ($outpost -> fields['morale'] <= -50)
	{
		if ($outpost -> fields['morale'] == -50)
		{
			$intBonus = -0.05;
		}
			else
		{
			$intBonus = floor(($outpost -> fields['morale'] + 50) / 75);
			$intBonus = $intBonus * 5;
			if ($intBonus < -75)
			{
				$intBonus = -75;
			}
		}
	}
	if (isset($intBonus))
	{
		$fltAttack1 = ($attack1 + ($attack1 * ($intBonus / 100)));
		$fltDefense1 = ($defense1 + ($defense1 * ($intBonus / 100)));
	}
		else
	{
		$fltAttack1 = $attack1;
		$fltDefense1 = $defense1;
	}
	$attackbonus = ($fltAttack1 * ($outpost -> fields['battack'] / 100));
	$defensebonus = ($fltDefense1 * ($outpost -> fields['bdefense'] / 100));
	$attack = $fltAttack1 + ($fltAttack1 * $bonus) + $attackbonus;
	$defense = $fltDefense1 + ($fltDefense1 * $bonus) + $defensebonus;
}

/**
* Funkcja obliczajaca straty w zolnierzach oraz w machinach atakujacego gracza. Dodatkowo 
* obliczanie zmeczenia zolniezy atakujacych.
*/
function lostattacker($min,$max,$defense,$intDefenderlvl) {
	global $db;
	global $myout;
	global $arrarmy;
	global $j;
	global $arrlost;
	global $eattack;
	global $mydefense;
	for ($i = 0; $i < 3; $i ++) {
		$field = $arrarmy[$i];
		if ($myout -> fields[$field]) {
			$roll = ceil($myout -> fields[$field] * (rand($min,$max) / 100));
			$arrlost[$j] = $myout -> fields[$field] - $roll;
			if ($eattack > $mydefense) {
				$roll1 = ceil($myout -> fields[$field] * 0.03);
				$arrlost[$j] = $arrlost[$j] - $roll1;
			} else {
				$roll1 = 0;
			}
			$bonus = ceil(($roll + $roll1) * ($myout -> fields['blost'] / 100));
			if ($bonus > ($roll + $roll1) || !$defense) {
				$bonus = $roll + $roll1;
			}
			$arrlost[$j] = $arrlost[$j] + $bonus;
			if ($arrlost[$j] < 0) {
				$arrlost[$j] = 0;
			}
			$db -> Execute("UPDATE outposts SET ".$arrarmy[$i]."=".$arrlost[$j]." WHERE id=".$myout -> fields['id']);
		} else {
			$arrlost[$j] = 0;
		}
		$j = $j + 1;
	}
	if ($myout -> fields['size'] < $intDefenderlvl && $myout -> fields['fatigue'] > 40)
	{
		$intFatigue = $myout -> fields['fatigue'] - 20;
	}
	if ($myout -> fields['fatigue'] <= 40 && $myout -> fields['fatigue'] > 30)
	{
		$intFatigue = 30;
	}
	if ($myout -> fields['fatigue']  <= 30)
	{
		$intFatigue = 25;
	}
	if ($myout -> fields['size'] >= $intDefenderlvl && $myout -> fields['fatigue'] > 40)
	{
		$intFatigue = $myout -> fields['fatigue'] - 15;
	}
	$db -> Execute("UPDATE outposts SET fatigue=".$intFatigue." WHERE id=".$myout -> fields['id']);
}

// funkcja obliczajaca straty w zolniezach broniacego sie gracza
function lostdefender($min,$max,$defender=0) {
	global $db;
	global $enemy;
	global $arrarmy;
	global $j;
	global $arrlost;
	global $myout;
	if ($defender) {
		$maxlost = 0;
		for ($i = 0; $i < 3; $i ++) {
			$field = $arrarmy[$i];
			$maxlost = $maxlost + ($myout -> fields[$field] - $arrlost[$i]);
		}
		$deflost = 0;
	}
	for ($i = 0; $i < 4; $i ++) {
		$field = $arrarmy[$i];
		if ($enemy -> fields[$field]) {
			$roll = ceil($enemy -> fields[$field] * (rand($min,$max) / 100));
			$arrlost[$j] = $enemy -> fields[$field] - $roll;
			$bonus = ceil($roll * ($enemy -> fields['blost'] / 100));
			if ($bonus > $roll) {
				$bonus = $roll;
			}
			$arrlost[$j] = $arrlost[$j] + $bonus;
			if ($defender) {
				$deflost = $deflost + ($enemy -> fields[$field] - $arrlost[$j]);
			} else {
				$db -> Execute("UPDATE outposts SET ".$arrarmy[$i]."=".$arrlost[$j]." WHERE id=".$enemy -> fields['id']);
			}
		} else {
			$arrlost[$j] = 0;
		}
		$j = $j + 1;
	}
	if ($defender) {
		$j = $j - 4;
		if ($deflost > $maxlost) {
			$deflost = $deflost - $maxlost;
		}
		for ($i = 0; $i < 4; $i ++) {
			$field = $arrarmy[$i];
			if ($enemy -> fields[$field]) {
				$lost = $enemy -> fields[$field] - $arrlost[$j];
				if ($lost > $maxlost) {
					$lost = $maxlost;
					$arrlost[$j] = $enemy -> fields[$field] - $lost;
				}
				$maxlost = $maxlost - $lost;
				$db -> Execute("UPDATE outposts SET ".$arrarmy[$i]."=".$arrlost[$j]." WHERE id=".$enemy -> fields['id']);
			} else {
				$arrlost[$j] = 0;
			}
			$j = $j + 1;
		}
	}
}

// funkcja obliczajaca zysk w umiejetnosci dowodzenie wygrywajacego gracza
function gainexpwin($leadership,$playerid) {
	global $db;
	global $myout;
	global $enemy;
	global $arrlost;
	$gainexp = (($myout -> fields['warriors'] - $arrlost[0]) + ($myout -> fields['archers'] - $arrlost[1]) + ($enemy -> fields['warriors'] - $arrlost[3]) + ($enemy -> fields['archers'] - $arrlost[4]) + $enemy -> fields['size']);
	if ($gainexp > 0)
	{
		$gainexp = ($gainexp / 200) / ceil($leadership);
		$gainexp = round($gainexp,"2");
	}
		else
	{
		$gainexp = 0;
	}
	if ($gainexp < 0.01) {
		$gainexp = 0.01;
	}
	$db -> Execute("UPDATE players SET leadership=leadership+".$gainexp." WHERE id=".$playerid);
	PutSignal( $playerid, 'skills' );
	return $gainexp;
}

//funkcja obliczajaca zysk w umiejetnosci dowodzenie przegrywajacego gracza
function gainexplost($leadership,$playerid) {
	global $db;
	global $myout;
	global $enemy;
	global $arrlost;
	$gainexp = ($myout -> fields['warriors'] - $arrlost[0]) + ($myout -> fields['archers'] - $arrlost[1]) + ($enemy -> fields['warriors'] - $arrlost[3]) + ($enemy -> fields['archers'] - $arrlost[4]);
	if ($gainexp > 0) {
		$gainexp = ($gainexp / 200) / ceil($leadership);
	} else {
		$gainexp = 0;
	}
	$gainexp = round($gainexp,"2");
	if ($gainexp < 0.01) {
		$gainexp = 0.01;
	}
	$db -> Execute("UPDATE players SET leadership=leadership+".$gainexp." WHERE id=".$playerid);
	PutSignal( $playerid, 'skills' );
	return $gainexp;
}

// pobranie z bazy danych informacji o straznicy
$out = $db -> Execute("SELECT * FROM outposts WHERE owner=".$player -> id);

// jezeli gracz nie posiada straznicy ma mozliwosc zakupu ziemi pod nia
if (!$out -> fields['id']) {
	if (isset ($_GET['action']) && $_GET['action'] == 'buy') {
		$out = $db -> Execute("SELECT id FROM outposts WHERE owner=".$player -> id);
		if ($out -> fields['id']) {
			error ("Kupiles nieco ziemii! Kliknij <a href=\"outposts.php\">tutaj</a> aby wrocic.");
	} else {
		if ($player -> credits < 500) {
		error ("Nie masz wystarczajaco duzo pieniedzy aby zakupic ziemie pod straznice.");
		} else {
			//$db -> Execute("UPDATE players SET credits=credits-500 WHERE id=".$player -> id);
			$player -> gold -= 500;
				$db -> Execute("INSERT INTO outposts (owner) VALUES(".$player -> id.")");
				error ("Mozesz juz udac sie to swojej straznicy! Kliknij <a href=\"outposts.php\">tutaj</a> aby wrocic.");
			}
	}
	}
}

// skarbiec - dotowanie straznicy oraz zabieranie pieniedzy ze straznicy
if (isset ($_GET['view']) && $_GET['view'] == 'gold') {
	$smarty -> assign("Gold", $out -> fields['gold']);
	// Zabieranie zlota ze straznicy
	if (isset ($_GET['step']) && $_GET['step'] == 'player') {
		error( "Wyciaganie zlota ze straznicy wylaczone !" );
	//	if (!isset($_POST['zeton']))
	//	{
	//		error("Podaj ile sztuk zlota chcesz zamienic!");
	//	}
	//	if (!ereg("^[1-9][0-9]*$", $_POST['zeton'])) {
	//		error ("Zapomnij o tym");
	//	}
	//	if ($_POST['zeton'] > $out -> fields['gold']) {
	//		error ("Nie masz tyle sztuk zlota w straznicy!");
	//	}
	//	$zmiana = floor($_POST['zeton'] / 2);
	//	$db -> Execute("UPDATE players SET credits=credits+".$zmiana." WHERE id=".$player -> id);
	//	$db -> Execute("UPDATE outposts SET gold=gold-".$_POST['zeton']." WHERE owner=".$player -> id);
	//	$smarty -> assign ("Message", "Zamieniles <b>".$_POST['zeton']."</b> sztuk zlota ze straznicy na <b>".$zmiana."</b> sztuk zlota do reki.");
	}
	// Dotowanie straznicy
	if (isset ($_GET['step']) && $_GET['step'] == 'outpost') {
		if (!isset($_POST['sztuki'])) {
			error("Podaj ile sztuk zlota chcesz dodac do straznicy!");
		}
	if (!ereg("^[1-9][0-9]*$", $_POST['sztuki'])) {
		error ("Zapomnij o tym");
	}
	if ($_POST['sztuki'] > $player -> credits) {
		error ("Nie masz tyle sztuk zlota");
	}
	//$db -> Execute("UPDATE players SET credits=credits-".$_POST['sztuki']." WHERE id=".$player -> id);
	$player -> gold -= $_POST['sztuki'];
	$db -> Execute("UPDATE outposts SET gold=gold+".$_POST['sztuki']." WHERE owner=".$player -> id);
	$smarty -> assign ("Message", "Dodales <b>".$_POST['sztuki']."</b> sztuk zlota do straznicy.");
	}
}

//edycja weteranow (dodawanie ekwipunku) oraz informacje o nich
if (isset($_GET['view']) && $_GET['view'] == 'veterans') {
	$query = $db -> Execute("SELECT id FROM outpost_veterans WHERE outpost=".$out -> fields['id']);
	$numveterans = $query -> RecordCount();
	$query -> Close();
	if (!$numveterans) {
		error("Nie masz weteranow w straznicy!");
	}
	if (!isset($_GET['id'])) {
		error("Nie wybrales weterana!");
	}
	if (isset($_GET['id']) && !ereg("^[1-9][0-9]*$", $_GET['id'])) {
		error("Zapomnij o tym!");
	}
	$veteran = $db -> Execute("SELECT * FROM outpost_veterans WHERE id=".$_GET['id']);
	if ($veteran -> fields['outpost'] != $out -> fields['id']) {
		error("To nie jest twoj weteran!");
	}
	$power = $veteran -> fields['wpower'] + 1;
	$defense = $veteran -> fields['apower'] + $veteran -> fields['hpower'] + $veteran -> fields['lpower'] + 1;
	if ($veteran -> fields['armor']) {
		$armor = $veteran -> fields['armor'];
		$arraid[1] = 0;
		$arraname[1] = 0;
		$arrapower[1] = 0;
	} else {
		equip('A');
		$arraid = $arrid;
		$arraname = $arrname;
		$arrapower = $arrpower;
		if (!isset($arrid[1])) {
			$arraid[1] = 0;
			$arraname[1] = 0;
			$arrapower[1] = 0;
		}
		$armor = 'brak';
	}
	if ($veteran -> fields['helm']) {
		$helm = $veteran -> fields['helm'];
		$arrhid[1] = 0;
		$arrhname[1] = 0;
		$arrhpower[1] = 0;
	} else {
		equip('H');
		$arrhid = $arrid;
		$arrhname = $arrname;
		$arrhpower = $arrpower;
		if (!isset($arrid[1])) {
			$arrhid[1] = 0;
			$arrhname[1] = 0;
			$arrhpower[1] = 0;
		}
		$helm = 'brak';
	}
	if ($veteran -> fields['legs']) {
		$legs = $veteran -> fields['legs'];
		$arrlid[1] = 0;
		$arrlname[1] = 0;
		$arrlpower[1] = 0;
	} else {
		equip('N');
		$arrlid = $arrid;
		$arrlname = $arrname;
		$arrlpower = $arrpower;
		if (!isset($arrid[1])) {
			$arrlid[1] = 0;
			$arrlname[1] = 0;
			$arrlpower[1] = 0;
		}
		$legs = 'brak';
	}
	$smarty -> assign(array("Vname" => $veteran -> fields['name'],
		"Wname" => $veteran -> fields['weapon'],
		"Wpower" => $veteran -> fields['wpower'],
		"Aname" => $armor,
		"Apower" => $veteran -> fields['apower'],
		"Hname" => $helm,
		"Hpower" => $veteran -> fields['hpower'],
		"Lname" => $legs,
		"Lpower" => $veteran -> fields['lpower'],
		"Power" => $power,
		"Defense" => $defense,
		"Aid" => $arraid,
		"Aname1" => $arraname,
		"Apower1" => $arrapower,
		"Hid" => $arrhid,
		"Hname1" => $arrhname,
		"Hpower1" => $arrhpower,
		"Lid" => $arrlid,
		"Lname1" => $arrlname,
		"Lpower1" => $arrlpower,
		"Vid" => $_GET['id']));
	// modyfikacja ekwipunku
	if (isset($_GET['step']) && $_GET['step'] == 'modify') {
		$text = "Dodales weteranowi ekwipunek: ";
		if (isset($_POST['armor']) && ereg("^[1-9][0-9]*$", $_POST['armor'])) {
			$text1 = wear($_POST['armor'], $_GET['id'],'armor','apower');
			$text = $text.$text1;
		}
		if (isset($_POST['helm']) && ereg("^[1-9][0-9]*$", $_POST['helm'])) {
			$text1 = wear($_POST['helm'], $_GET['id'],'helm','hpower');
			$text = $text.$text1;
		}
		if (isset($_POST['legs']) && ereg("^[1-9][0-9]*$", $_POST['legs'])) {
			$text1 = wear($_POST['legs'], $_GET['id'],'legs','lpower');
			$text = $text.$text1;
		}
		if (isset($text1)) {
			$smarty -> assign("Message", $text);
		}
	}
}

/**
* Menu informacyjne straznicy oraz rozwijanie umiejetnosci dowodzenie
*/
if (isset ($_GET['view']) && $_GET['view'] == 'myoutpost') {
	$maxtroops = ($out -> fields['size'] * 20) - $out -> fields['warriors'] - $out -> fields['archers'];
	$maxequips = ($out -> fields['size'] * 10) - $out -> fields['catapults'] - $out -> fields['barricades'];
	$cost = (($out -> fields['warriors'] * 7) + ($out -> fields['archers'] * 7)) + ($out -> fields['catapults'] * 14);
	$testability = $out -> fields['battack'] + $out -> fields['bdefense'] + $out -> fields['btax'] + $out -> fields['blost'] + $out -> fields['bcost'];
	$ability = floor($player -> leadership);
	if ($testability < $ability) {
		$link = 'Y';
	} else {
		$link = '';
	}
	showspecials('monsters','fence');
	$maxmonsters = $maxarmy;
	$nummonsters = $numarmy;
	$maxfence = (floor($out -> fields['size'] / 4) - $out -> fields['barracks']);
	$maxbarracks = (floor($out -> fields['size'] / 4) - $out -> fields['fence']);
	$cost = $cost + $cost1;
	showspecials('veterans','barracks');
	$maxveterans = $maxarmy;
	$numveterans = $numarmy;
	$cost = $cost + $cost1;
	$bonus = ($cost * ($out -> fields['bcost'] / 100));
	$bonus = round($bonus, "0");
	$cost = $cost - $bonus;
	$fatigue = 100 - $out -> fields['fatigue'];
	if ($out -> fields['morale'] > -49 && $out -> fields['morale'] < 49)
	{
		$strMorale = 'Neutralne';
	}
	if ($out -> fields['morale'] < -49)
	{
		$strMorale = 'Bunt';
	}
	if ($out -> fields['morale'] > 49)
	{
		$strMorale = 'Bojowe';
	}
	$smarty -> assign ( array("User" => $player -> user,
		"Size" => $out -> fields['size'],
		"Turns" => $out -> fields['turns'],
		"Gold" => $out -> fields['gold'],
		"Warriors" => $out -> fields['warriors'],
		"Barricades" => $out -> fields['barricades'],
		"Archers" => $out -> fields['archers'],
		"Catapults" => $out -> fields['catapults'],
		"Maxtroops" => $maxtroops,
		"Maxequip" => $maxequips,
		"Cost" => $cost,
		"Attack" => $out -> fields['battack'],
		"Defense" => $out -> fields['bdefense'],
		"Tax" => $out -> fields['btax'],
		"Lost" => $out -> fields['blost'],
		"Bcost" => $out -> fields['bcost'],
		"Link" => $link,
		"Fence" => $out -> fields['fence'],
		"Maxfence" => $maxfence,
		"Monster" => $nummonsters,
		"Maxmonster" => $maxmonsters,
		"Barracks" => $out -> fields['barracks'],
		"Maxbarracks" => $maxbarracks,
		"Veterans" => $numveterans,
		"Maxveterans" => $maxveterans,
		"Fatigue" => $fatigue,
		"Morale" => $out -> fields['morale'],
		"Moralename" => $strMorale));
	/**
	* Rozwoj umiejetnosci dowodzenie
	*/
	if (isset($_GET['step']) && $_GET['step'] == 'add') {
		if ($_GET['ability'] != 'battack' && $_GET['ability'] != 'bdefense' && $_GET['ability'] != 'btax' && $_GET['ability'] != 'blost' && $_GET['ability'] != 'bcost') {
			error("Zapomnij o tym!");
		}
		$testability = $out -> fields['battack'] + $out -> fields['bdefense'] + $out -> fields['btax'] + $out -> fields['blost'] + $out -> fields['bcost'];
		$ability = floor($player -> leadership);
		if ($testability >= $ability) {
			error("Nie mozesz podniesc jakiejkolwiek premii");
		}
		$field = $_GET['ability'];
		if ($out -> fields[$field] > 14) {
			error("Osiagnales juz maksymalny poziom tej premii");
		}
		$db -> Execute("UPDATE outposts SET ".$_GET['ability']."=".$_GET['ability']."+1 WHERE id=".$out -> fields['id']);
		$smarty -> assign("Message", "Premia dodana. <a href=\"outposts.php?view=myoutpost\">Odswiez</a>");
	}
}

/**
* Zbieranie danin z wiosek
*/
if (isset ($_GET['view']) && $_GET['view'] == 'taxes') {
	if ($out -> fields['turns'] < 1) {
		error("Nie masz tylu punktow akcji aby zbierac podatki");
	}
	$intArmy = $out -> fields['warriors'] + ceil($out->fields['archers']/3);
	if (!$intArmy) {
		error("Nie masz zolnierzy aby zbierali podatki!");
	}
	if (isset($_GET['step']) && $_GET['step'] == 'gain') {
		if (!isset($_POST['amount'])) {
			error("Podaj ile razy chcesz wyslac zolnierzy!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
		error ("Zapomnij o tym");
	}
		if ($_POST['amount'] > $out -> fields['turns']) {
			error ("Nie masz tyle Punktow Ataku!");
		}
		$intGaingold = 0;
		for ($i = 0; $i < $_POST['amount']; $i++) {
			$intGain = rand(1,5);
			$intGaingold = $intGaingold + ($intArmy * $intGain);
		}
		$fltBonus = ($intGaingold * ($out -> fields['btax'] / 100));
		$intBonus = round($fltBonus, "0");
		$intGaingold = $intGaingold + $intBonus;
		$intFatigue = $out -> fields['fatigue'] + (10 * $_POST['amount']);
		if ($intFatigue > 100)
		{
			$intFatigue = 100;
		}
		$db -> Execute("UPDATE outposts SET fatigue=".$intFatigue." WHERE id=".$out -> fields['id']);
		$db -> Execute("UPDATE outposts SET gold=gold+".$intGaingold." WHERE id=".$out -> fields['id']);
		$db -> Execute("UPDATE outposts SET turns=turns-".$_POST['amount']." WHERE id=".$out -> fields['id']);
		$smarty -> assign ("Message", "Twoi zolnierze wyruszyli ".$_POST['amount']." razy na zbieranie danin z wiosek i zebrali w ten sposob ".$intGaingold." sztuk zlota.");
	}
}

/**
* Rozbudowa straznicy oraz zaciag wojska
*/
if (isset ($_GET['view']) && $_GET['view'] == 'shop') {
	$needed = ($out -> fields['size'] * 375);
	$numfence = (floor($out -> fields['size'] / 4) - $out -> fields['barracks']);
	if ($numfence > $out -> fields['fence']) {
		$needed1 = 100 + ($out -> fields['fence'] * 50);
	} else {
		$needed1 = 0;
	}
	$numbarracks = (floor($out -> fields['size'] / 4) - $out -> fields['fence']);
	if ($numbarracks > $out -> fields['barracks']) {
		$needed2 = 100 + ($out -> fields['barracks'] * 50);
	} else {
		$needed2 = 0;
	}
	$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id);
	$numcore = $query -> RecordCount();
	$query -> Close();
	$query = $db -> Execute("SELECT id FROM outpost_monsters WHERE outpost=".$out -> fields['id']);
	$nummonsters = $query -> RecordCount();
	$query -> Close();
	if ($numcore && $nummonsters < $out -> fields['fence']) {
		$freefence = 'Y';
		$core = $db -> Execute("SELECT id, name, power, defense FROM core WHERE owner=".$player -> id);
		$arrname = array();
		$arrpower = array();
		$arrdefense = array();
		$arrid = array();
		$i = 0;
		while (!$core -> EOF) {
			$arrid[$i] = $core -> fields['id'];
			$arrname[$i] = $core -> fields['name'];
			$arrpower[$i] = ceil($core -> fields['power'] / 10);
			$arrdefense[$i] = ceil($core -> fields['defense'] / 10);
			$core -> MoveNext();
			$i = $i + 1;
		}
		$core -> Close();
		$smarty -> assign(array("Mid" => $arrid, "Mname" => $arrname, "Power" => $arrpower, "Defense" => $arrdefense));
	} else {
		$freefence = '';
	}
	$query = $db -> Execute("SELECT id FROM equipment WHERE owner=".$player -> id." AND type='W' AND status='U'");
	$numwep1 = $query -> RecordCount();
	$query -> Close();
	$query = $db -> Execute("SELECT id FROM equipment WHERE owner=".$player -> id." AND type='B' AND status='U'");
	$numwep2 = $query -> RecordCount();
	$query -> Close();
	$query = $db -> Execute("SELECT id FROM outpost_veterans WHERE outpost=".$out -> fields['id']);
	$numveterans = $query -> RecordCount();
	$query -> Close();
	if ($numveterans < $out -> fields['barracks'] && ($numwep1 || $numwep2)) {
		$freebarracks = 'Y';
		$weapon = $db -> Execute("SELECT id, name, power FROM equipment WHERE owner=".$player -> id." AND type='W' AND status='U'");
		$arrwname = array();
		$arrwpower = array();
		$arrwid = array();
		$i = 0;
		while (!$weapon -> EOF) {
			$arrwid[$i] = $weapon -> fields['id'];
			$arrwname[$i] = $weapon -> fields['name'];
			$arrwpower[$i] = ceil($weapon -> fields['power'] / 10);
			$weapon -> MoveNext();
			$i = $i + 1;
		}
		$weapon = $db -> Execute("SELECT id, name, power FROM equipment WHERE owner=".$player -> id." AND type='B' AND status='U'");
		while (!$weapon -> EOF) {
			$arrwid[$i] = $weapon -> fields['id'];
			$arrwname[$i] = $weapon -> fields['name'];
			$arrwpower[$i] = ceil($weapon -> fields['power'] / 10);
			$weapon -> MoveNext();
			$i = $i + 1;
		}
		$weapon -> Close();
		equip('A');
		$arraid = $arrid;
		$arraname = $arrname;
		$arrapower = $arrpower;
		if (!isset($arrid[1])) {
			$arraid[1] = 0;
			$arraname[1] = 0;
			$arrapower[1] = 0;
		}
		equip('H');
		$arrhid = $arrid;
		$arrhname = $arrname;
		$arrhpower = $arrpower;
		if (!isset($arrid[1])) {
			$arrhid[1] = 0;
			$arrhname[1] = 0;
			$arrhpower[1] = 0;
		}
		equip('N');
		$arrlid = $arrid;
		$arrlname = $arrname;
		$arrlpower = $arrpower;
		if (!isset($arrid[1])) {
			$arrlid[1] = 0;
			$arrlname[1] = 0;
			$arrlpower[1] = 0;
		}
		$smarty -> assign(array("Wid" => $arrwid,
			"Wname" => $arrwname,
			"Wpower" => $arrwpower,
			"Aid" => $arraid,
			"Aname" => $arraname,
			"Apower" => $arrapower,
			"Hid" => $arrhid,
			"Hname" => $arrhname,
			"Hpower" => $arrhpower,
			"Lid" => $arrlid,
			"Lname" => $arrlname,
			"Lpower" => $arrlpower));
	} else {
		$freebarracks = '';
	}
	$objWarriors = $db -> Execute("SELECT value FROM settings WHERE setting='warriors'");
	$objArchers = $db -> Execute("SELECT value FROM settings WHERE setting='archers'");
	$objCatapults = $db -> Execute("SELECT value FROM settings WHERE setting='catapults'");
	$objBarricades = $db -> Execute("SELECT value FROM settings WHERE setting='barricades'");
	$maxtroops = ($out -> fields['size'] * 20) - $out -> fields['warriors'] - $out -> fields['archers'];
	$maxequips = ($out -> fields['size'] * 10) - $out -> fields['catapults'] - $out -> fields['barricades'];
	$smarty -> assign (array("Need" => $needed,
		"Need1" => $needed1,
		"Fence" => $freefence,
		"Need2" => $needed2,
		"Barracks" => $freebarracks,
		"Maxtroops" => $maxtroops,
		"Maxequips" => $maxequips,
		"Awarriors" => $objWarriors -> fields['value'],
		"Aarchers" => $objArchers -> fields['value'],
		"Acatapults" => $objCatapults -> fields['value'],
		"Abarricades" => $objBarricades -> fields['value']));
	$objWarriors -> Close();
	$objArchers -> Close();
	$objCatapults -> Close();
	$objBarricades -> Close();
	// sprawdzenie czy wprowadzono liczbe
	if (isset($_GET['buy']) && ($_GET['buy'] != 's' && $_GET['buy'] != 'f' && $_GET['buy'] != 'r' && $_GET['buy'] != 'v')) {
		if (!isset($_POST['army'])) {
			error("Podaj ile wojska chcesz kupic!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['army'])) {
			error ("Zapomnij o tym");
		}
	}
	// dodawanie weteranow do straznicy
	if (isset($_GET['buy']) && $_GET['buy'] == 'v') {
		if ($out -> fields['gold'] < 2000) {
			error("Nie stac sie na to!");
		}
		$query = $db -> Execute("SELECT id FROM outpost_veterans WHERE outpost=".$out -> fields['id']);
		$numveterans = $query -> RecordCount();
		$query -> Close();
		if ($numveterans >= $out -> fields['barracks']) {
			error("Nie masz kwater na kolejnych weteranow!");
		}
		$name = strip_tags($_POST['vname']);
		if (empty($_POST['vname'])) {
			error("Podaj imie weterana");
		}
		$db -> Execute("INSERT INTO outpost_veterans (outpost, name) VALUES(".$out -> fields['id'].", '".$name."')") or error("Nie moge dodac weterana!");
		$vetid = $db -> Execute("SELECT id FROM outpost_veterans WHERE outpost=".$out -> fields['id']." AND name='".$name."'");
		$text = '';
		if (ereg("^[1-9][0-9]*$", $_POST['weapon'])) {
			$text1 = wear($_POST['weapon'], $vetid -> fields['id'],'weapon','wpower');
			$text = $text.$text1;
		}
		if (isset($_POST['armor']) && ereg("^[1-9][0-9]*$", $_POST['armor'])) {
			$text1 = wear($_POST['armor'], $vetid -> fields['id'],'armor','apower');
			$text = $text.$text1;
		}
		if (isset($_POST['helm']) && ereg("^[1-9][0-9]*$", $_POST['helm'])) {
			$text1 = wear($_POST['helm'], $vetid -> fields['id'],'helm','hpower');
			$text = $text.$text1;
		}
		if (isset($_POST['legs']) && ereg("^[1-9][0-9]*$", $_POST['legs'])) {
			$text1 = wear($_POST['legs'], $vetid -> fields['id'],'legs','lpower');
			$text = $text.$text1;
		}
		$vetid -> Close();
		$db -> Execute("UPDATE outposts SET gold=gold-2000 WHERE id=".$out -> fields['id']);
		$smarty -> assign("Message", "Dodales weterana: <b>".$name."</b> wydajac 2000 sztuk zlota. Posiada: ".$text);
	}
	// dokupienie kwater weteranow
	if (isset($_GET['buy']) && $_GET['buy'] == 'r') {
		$numfence = (floor($out -> fields['size'] / 4) - $out -> fields['fence']);
		if ($numfence <= $out -> fields['barracks']) {
			error("Nie mozesz dokupic nowej kwatery poniewaz masz juz maksymalna ilosc!");
		}
		$needed = 100 + ($out -> fields['barracks'] * 50);
		if ($needed > $out -> fields['gold']) {
			error("Nie masz wystarczajacej ilosci sztuk zlota w straznicy.");
		}
		$db -> Execute("UPDATE outposts SET gold=gold-".$needed." WHERE id=".$out -> fields['id']);
	$db -> Execute("UPDATE outposts SET barracks=barracks+1 WHERE id=".$out -> fields['id']);
	$smarty -> assign ("Message", "Dodales jedna Kwatere Weterana do swojej Straznicy za <b>".$needed."</b> sztuk zlota.");
	}
	// dodawanie chowancow do straznicy
	if (isset($_GET['buy']) && $_GET['buy'] == 'm') {
		if ($out -> fields['gold'] < 2000) {
			error("Nie stac sie na to!");
		}
		$query = $db -> Execute("SELECT id FROM outpost_monsters WHERE outpost=".$out -> fields['id']);
		$nummonsters = $query -> RecordCount();
		$query -> Close();
		if ($nummonsters >= $out -> fields['fence']) {
			error("Nie masz legowisk na kolejne bestie!");
		}
		$core = $db -> Execute("SELECT name, power, defense, owner FROM core WHERE id=".$_POST['army']);
		if ($core -> fields['owner'] != $player -> id) {
			error("To nie twoj chowaniec!");
		}
		$power = ceil($core -> fields['power'] / 10);
		$defense = ceil($core -> fields['defense'] / 10);
		$db -> Execute("INSERT INTO outpost_monsters (outpost, name, power, defense) VALUES(".$out -> fields['id'].",'".$core -> fields['name']."',".$power.",".$defense.")") or error("Nie moge dodac bestii!");
		$db -> Execute("DELETE FROM core WHERE id=".$_POST['army']);
		$db -> Execute("UPDATE outposts SET gold=gold-2000 WHERE id=".$out -> fields['id']);
		$smarty -> assign("Message", "Dodales bestie: <b>".$core -> fields['name']."</b> o sile ".$power." i obronie ".$defense.". Wydales na to 2000 sztuk zlota.");
		$core -> Close();
	}
	// dokupienie legowiska bestii
	if (isset($_GET['buy']) && $_GET['buy'] == 'f') {
		$numfence = (floor($out -> fields['size'] / 4) - $out -> fields['barracks']);
		if ($numfence <= $out -> fields['fence']) {
			error("Nie mozesz dokupic nowego legowiska poniewaz masz juz maksymalna ilosc!");
		}
		$needed = 100 + ($out -> fields['fence'] * 50);
		if ($needed > $out -> fields['gold']) {
			error("Nie masz wystarczajacej ilosci sztuk zlota w straznicy.");
		}
		$db -> Execute("UPDATE outposts SET gold=gold-".$needed." WHERE id=".$out -> fields['id']);
	$db -> Execute("UPDATE outposts SET fence=fence+1 WHERE id=".$out -> fields['id']);
	$smarty -> assign ("Message", "Dodales jedno Legowisko Bestii do swojej Straznicy za <b>".$needed."</b> sztuk zlota.");
	}
	// powiekszanie straznicy
	if (isset ($_GET['buy']) && $_GET['buy'] == 's') {
	$needed = ($out -> fields['size'] * 375);
	if ($needed > $out -> fields['gold']) {
		error ("Nie masz wystarczajacej ilosci sztuk zlota w straznicy.");
	}
	$db -> Execute("UPDATE outposts SET gold=gold-".$needed." WHERE id=".$out -> fields['id']);
	$db -> Execute("UPDATE outposts SET size=size+1 WHERE id=".$out -> fields['id']);
	$smarty -> assign ("Message", "Powiekszyles rozmiar swojej Straznicy o <b>1</b> za <b>".$needed."</b> sztuk zlota.");
	}
	/**
	* Kupowanie piechoty oraz lucznikow
	*/
	if (isset ($_GET['buy']) && ($_GET['buy'] == 'w' || $_GET['buy'] == 'a')) {
		$cost = ($_POST['army']* 25);
		if ($cost > (int)$out -> fields['gold']) {
			error ("Nie masz wystarczajacej ilosci sztuk zlota.");
		}
		$max = ($out -> fields['size'] * 20) - $out -> fields['warriors'] - $out -> fields['archers'];
		if ($_GET['buy'] == 'w')
		{
			$objWarriors = $db -> Execute("SELECT value FROM settings WHERE setting='warriors'");
			if ($objWarriors -> fields['value'] < $_POST['army'])
			{
				error("Nie ma tylu piechurow do kupienia!");
			}
			$objWarriors -> Close();
			$armytype = 'warriors';
			$text = 'piechurow';
		}
			else
		{
			$objArchers = $db -> Execute("SELECT value FROM settings WHERE setting='archers'");
			if ($objArchers -> fields['value'] < $_POST['army'])
			{
				error("Nie ma tylu lucznikow do kupienia!");
			}
			$objArchers -> Close();
			$armytype = 'archers';
			$text = 'lucznikow';
		}
	}
	/**
	* Kupowanie fortyfikacji oraz machin oblezniczych
	*/
	if (isset ($_GET['buy']) && ($_GET['buy'] == 'b' || $_GET['buy'] == 'c')) {
		$cost = ($_POST['army']* 35);
		if ($cost > $out -> fields['gold']) {
			error ("Nie masz wystarczajacej ilosci sztuk zlota.");
		}
		$max = ($out -> fields['size'] * 10) - $out -> fields['barricades'] - $out -> fields['catapults'];
		if ($_GET['buy'] == 'b')
		{
			$objBarricades = $db -> Execute("SELECT value FROM settings WHERE setting='barricades'");
			if ($objBarricades -> fields['value'] < $_POST['army'])
			{
				error("Nie ma tyle fortyfikacji do kupienia!");
			}
			$objBarricades -> Close();
			$armytype = 'barricades';
			$text = 'fortyfikacji';
		}
			else
		{
			$objCatapults = $db -> Execute("SELECT value FROM settings WHERE setting='catapults'");
			if ($objCatapults -> fields['value'] < $_POST['army'])
			{
				error("Nie ma tyle machin oblezniczych do kupienia!");
			}
			$objCatapults -> Close();
			$armytype = 'catapults';
			$text = 'machin oblezniczych';
		}
	}
	/**
	* Wykonanie odpowiednich operacji w bazie dancyh (dla zwyklych jednostek)
	*/
	if (isset($_GET['buy']) && ($_GET['buy'] != 's' && $_GET['buy'] != 'f' && $_GET['buy'] != "m" && $_GET['buy'] != 'r' && $_GET['buy'] != 'v')) {
		if ($_POST['army'] > $max) {
			error ("Nie mozesz kupic tak wielu ".$text." do Straznicy. Zwieksz jej rozmiar, zanim zakupisz wiecej ".$text.".");
		}
		$db -> Execute("UPDATE outposts SET gold=gold-".$cost." WHERE id=".$out -> fields['id']);
		$db -> Execute("UPDATE outposts SET ".$armytype."=".$armytype."+".$_POST['army']." WHERE id=".$out -> fields['id']);
		$objArmy = $db -> Execute("SELECT value FROM settings WHERE setting='".$armytype."'");
		$intArmy = $objArmy -> fields['value'] - $_POST['army'];
		$db -> Execute("UPDATE settings SET value='".$intArmy."' WHERE setting='".$armytype."'");
		$smarty -> assign ("Message", "Dodales <b>".$_POST['army']."</b> ".$text." do Straznicy za <b>".$cost."</b> sztuk zlota.");
	}
}

// lista straznic od slevel poziomu do elevel poziomu
if (isset ($_GET['view']) && $_GET['view'] == 'listing') {
	if (isset ($_GET['step']) && $_GET['step'] == 'list') {
		if (!isset($_POST['slevel']))
		{
			error("Podaj poczatkowy poziom!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['slevel']) || !ereg("^[1-9][0-9]*$", $_POST['elevel']) || ($_POST['slevel'] > $_POST['elevel'])) {
			error ("Zapomnij o tym!");
		}
		$op = $db -> Execute("SELECT id, size, owner FROM outposts WHERE size>=".$_POST['slevel']." AND size<=".$_POST['elevel']." AND id!=".$out -> fields['id']." ORDER BY size DESC");
		$arrid = array();
		$arrsize = array();
		$arrowner = array();
		$i = 0;
		while (!$op -> EOF) {
			$arrid[$i] = $op -> fields['id'];
			$arrsize[$i] = $op -> fields['size'];
			$arrowner[$i] = $op -> fields['owner'];
		$op -> MoveNext();
			$i = $i + 1;
		}
	$op -> Close();
		$smarty -> assign ( array("Oid" => $arrid, "Size" => $arrsize, "Owner" => $arrowner));
	}
}

// walka straznic
if (isset ($_GET['view']) && $_GET['view'] == 'battle') {
	// przypisanie id straznicy do zaatakowania
	if (isset($_GET['oid'])) {
		$smarty -> assign("Id", $_GET['oid']);
	} else {
		$smarty -> assign("Id", 0);
	}
	// atak na straznice
	if (isset ($_GET['action']) && $_GET['action'] == 'battle') {
		if (!isset($_POST['amount']))
		{
			$_POST['amount'] = 1;
		}
		if ($out -> fields['fatigue'] == 25)
		{
			error("Twoja armia jest zbyt zmeczona by atakowac!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
		error ("Zapomnij o tym!");
		}
		if ($out -> fields['turns'] < $_POST['amount']) {
			error ("Nie masz wystarczajacej ilosci punktow ataku.");
		}
	if ($out -> fields['warriors'] < 0 || $out -> fields['archers'] < 0) {
			error ("Zapomnij o tym");
		}
		if (!$out -> fields['warriors'] && !$out -> fields['archers']) {
			error ("Nie masz wojsk aby atakowac innego gracza!");
		}
		if (isset($_GET['oid'])) {
			$_POST['oid'] = $_GET['oid'];
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['oid'])) {
		error ("Zapomnij o tym!");
		}
		if (empty($_POST['oid'])) {
		error ("Podaj id straznicy do ataku");
		}
		$enemy = $db -> Execute("SELECT * FROM outposts WHERE id=".$_POST['oid']);
		$myout = $db -> Execute("SELECT * FROM outposts WHERE id=".$out -> fields['id']);
		$mymonsters = $db -> Execute("SELECT id, name, power, defense FROM outpost_monsters WHERE outpost=".$out -> fields['id']);
		$emonsters = $db -> Execute("SELECT id, name, power, defense FROM outpost_monsters WHERE outpost=".$_POST['oid']);
		$myveterans = $db -> Execute("SELECT * FROM outpost_veterans WHERE outpost=".$out -> fields['id']);
		$eveterans = $db -> Execute("SELECT * FROM outpost_veterans WHERE outpost=".$_POST['oid']);
		$defenduser = $db -> Execute("SELECT user, leadership FROM players WHERE id=".$enemy -> fields['owner']);
		if (!$enemy -> fields['id']) {
		error ("Nie ta Straznica.");
		}
		if ($_POST['oid'] == $out -> fields['id']) {
			error ("Nie mozesz zaatakowac wlasnej Straznicy.");
		}
		// wykonanie kilku atakow pod rzad
		for ($k = 0; $k < $_POST['amount']; $k++) {
			// obliczenie wartosc ataku i obrony atakujacej straznicy
			outpoststats($myout,$myveterans,$mymonsters);
			$myattack = $attack;
			$mydefense = $defense;
			$arrmymid = $arrmid;
			$arrmymname = $arrmname;
			$arrmyvid = $arrvid;
			$arrmyvname = $arrvname;
			// obliczenie wartosci ataku i obrony broniacej sie straznicy
			outpoststats($enemy,$eveterans,$emonsters);
			$eattack = $attack;
			$edefense = $defense;
			$arremid = $arrmid;
			$arremname = $arrmname;
			$arrevid = $arrvid;
			$arrevname = $arrvname;
			// jezeli wygrywa atakujacy
			if ($myattack > $edefense) {
				$arrlost = array();
				$arrarmy = array('warriors', 'archers', 'catapults', 'barricades');
				$j = 0;
				// obliczanie strat wojska atakujacego
				lostattacker(0, 8, $edefense, $enemy -> fields['size']);
				// obliczanie strat wojska broniacego sie
				lostdefender(25,35);
				// straty zlota gracza broniacego sie
				if ($enemy -> fields['gold']) {
					$lostgold = ceil($enemy -> fields['gold'] / 10);
					$db -> Execute("UPDATE outposts SET gold=gold-".$lostgold." WHERE id=".$enemy -> fields['id']);
				} else {
					$lostgold = 0;
				}
				// obliczanie zyskow gracza atakujacego
				$gaingold = $lostgold + ((($myout -> fields['warriors'] - $arrlost[0]) + ($myout -> fields['archers'] - $arrlost[1]) + ($enemy -> fields['warriors'] - $arrlost[3]) + ($enemy -> fields['archers'] - $arrlost[4])) * 10) + ((($enemy -> fields['warriors'] - $arrlost[3]) + ($enemy -> fields['archers'] - $arrlost[4])) * 6);
				$roll = rand(1,100);
				if ($roll < 6) {
					$gaingold = $gaingold + ($gaingold * ($roll / 100));
				}
				$db -> Execute("UPDATE outposts SET gold=gold+".$gaingold." WHERE id=".$out -> fields['id']);
				// obliczanie zdobytego doswiadczenia zwyciezajacego gracza
				$gainexp1 = gainexpwin($player -> leadership, $player -> id);
				// obliczanie zdobytego doswiadczenia pokonanego gracza
				$gainexp = gainexplost($defenduser -> fields['leadership'], $enemy -> fields['owner']);
				// tworzenie informacji do wyswietlenia o walce
				$arrname = array('piechurow', 'lucznikow', 'katapult', 'fortyfikacji');
				$arrmessage[$k] = "<br />Atakujesz straznice gracza ".$defenduser -> fields['user']." i wygrywasz!<br />(Sila ataku: ".$myattack." Sila obrony: ".$edefense.")<br />Zdobywasz ".$gaingold." sztuk zlota oraz ".$gainexp1." poziomu w umiejetnosci Dowodzenie. Tracisz:<br />";
				for ($i = 0; $i < 3; $i ++) {
					$field = $arrarmy[$i];
					$lost = $myout -> fields[$field] - $arrlost[$i];
					$arrmessage[$k] = $arrmessage[$k]."- ".$lost." ".$arrname[$i]."<br />";
				}
				$arrmessage[$k] = $arrmessage[$k]."Przeciwnik traci:<br />";
				$arrlog = array();
				for ($i = 3; $i < 7; $i ++) {
					$num = $i - 3;
					$field = $arrarmy[$num];
					$arrlog[$num] = $enemy -> fields[$field] - $arrlost[$i];
					$arrmessage[$k] = $arrmessage[$k]."- ".$arrlog[$num]." ".$arrname[$num]."<br />";
				}
				/**
				* Modyfikacja morale atakujacego i broniacego sie
				*/
				$db -> Execute("UPDATE outposts SET morale=morale+7.5 WHERE id=".$myout -> fields['id']);
				$db -> Execute("UPDATE outposts SET morale=morale-10 WHERE id=".$enemy -> fields['id']);
				// dodanie wpisu do dziennika dla broniacego sie gracza
				$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$enemy -> fields['owner'].",'Gracz <b><a href=\"view.php?view=".$player -> id."\">".$player -> user."</a></b> zaatakowal twoja straznice i wygral.Tracisz ".$lostgold." sztuk zlota, ".$arrlog[0]." piechurow, ".$arrlog[1]." lucznikow, ".$arrlog[2]." machin oraz ".$arrlog[3]." fortyfikacji.','".$newdate."')");
			} else {
				// jezeli wygrywa broniacy sie
				$arrlost = array();
				$arrarmy = array('warriors', 'archers', 'catapults', 'barricades');
				$j = 0;
				// obliczanie strat wojska atakujacego
				lostattacker(25, 35, $edefense, $enemy -> fields['size']);
				// obliczanie strat wojska broniacego sie
				lostdefender(0,8,1);
				// obliczanie zdobytego doswiadczenia zwyciezajacego gracza
				$gainexp1 = gainexpwin($defenduser -> fields['leadership'], $enemy -> fields['owner']);
				// obliczanie zdobytego doswiadczenia pokonanego gracza
				$gainexp = gainexplost($player -> leadership, $player -> id);
				// tworzenie informacji do wyswietlenia o walce
				$arrname = array('piechurow', 'lucznikow', 'katapult', 'fortyfikacji');
				$arrmessage[$k] = "<br />Atakujesz straznice gracza ".$defenduser -> fields['user']." lecz niestety przegrywasz!<br />(Sila ataku: ".$myattack." Sila obrony: ".$edefense.")<br /> Zdobywasz ".$gainexp." poziomu w umiejetnosci Dowodzenie.<br />Tracisz:<br />";
				for ($i = 0; $i < 3; $i ++) {
					$field = $arrarmy[$i];
					$lost = $myout -> fields[$field] - $arrlost[$i];
					$arrmessage[$k] = $arrmessage[$k]."- ".$lost." ".$arrname[$i]."<br />";
				}
				$arrmessage[$k] = $arrmessage[$k]."Przeciwnik traci:<br />";
				$arrlog = array();
				for ($i = 3; $i < 7; $i ++) {
					$num = $i - 3;
					$field = $arrarmy[$num];
					$arrlog[$num] = $enemy -> fields[$field] - $arrlost[$i];
					$arrmessage[$k] = $arrmessage[$k]."- ".$arrlog[$num]." ".$arrname[$num]."<br />";
				}
				/**
				* Modyfikacja morale atakujacego i broniacego sie
				*/
				$db -> Execute("UPDATE outposts SET morale=morale-10 WHERE id=".$myout -> fields['id']);
				$db -> Execute("UPDATE outposts SET morale=morale+7.5 WHERE id=".$enemy -> fields['id']);
				// dodanie wpisu do dziennika dla broniacego sie gracza
				$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$enemy -> fields['owner'].",'Gracz <b><a href=\"view.php?view=".$player -> id."\">".$player -> user."</a></b> zaatakowal twoja straznice i przegral.Tracisz ".$arrlog[0]." piechurow, ".$arrlog[1]." lucznikow, ".$arrlog[2]." machin oraz ".$arrlog[3]." fortyfikacji.','".$newdate."')");
			}
			//obliczanie strat w potworach dla atakujacego
			$arrmessage[$k] = $arrmessage[$k].lostspecials('monsters', '', $arrmymid, $arrmymname);
			// obliczanie strat w potworach dla broniacego sie
			$arrmessage[$k] = $arrmessage[$k].lostspecials('monsters', $defenduser -> fields['user'], $arremid, $arremname);
			//obliczanie strat w weteranach dla atakujacego
			$$arrmessage[$k] = $arrmessage[$k].lostspecials('veterans', '', $arrmyvid, $arrmyvname);
			// obliczanie strat w weteranach dla broniacego sie
			$$arrmessage[$k] = $arrmessage[$k].lostspecials('veterans', $defenduser -> fields['user'], $arrevid, $arrevname);
			// ponowne sprawdzenie liczebnosci obu armii
			$enemy = $db -> Execute("SELECT * FROM outposts WHERE id=".$_POST['oid']);
			$myout = $db -> Execute("SELECT * FROM outposts WHERE id=".$out -> fields['id']);
			$mymonsters = $db -> Execute("SELECT id, name, power, defense FROM outpost_monsters WHERE outpost=".$out -> fields['id']);
			$emonsters = $db -> Execute("SELECT id, name, power, defense FROM outpost_monsters WHERE outpost=".$_POST['oid']);
			$myveterans = $db -> Execute("SELECT * FROM outpost_veterans WHERE outpost=".$out -> fields['id']);
			$eveterans = $db -> Execute("SELECT * FROM outpost_veterans WHERE outpost=".$_POST['oid']);
			$db -> Execute("UPDATE outposts SET turns=turns-1 WHERE owner=".$player -> id);
			/**
			* Sprawdzenie zmeczenia zolnierzy - jezeli wieksze niz 75% wojsko nie moze atakowac
			*/
			if ($myout -> fields['fatigue'] == 25)
			{
				$arrmessage[$k] = $arrmessage[$k]."<br />Twoja armia jest zbyt zmeczona aby atakowac dalej!<br />";
				break;
			}
		}
		$smarty -> assign("Result", $arrmessage);
		$myout -> Close();
		$enemy -> Close();
		$defenduser -> Close();
	}
}

// inicjalizacja zmiennych
if (!isset($_GET['view'])) {
	$_GET['view'] = '';
}
if (!isset($_GET['step'])) {
	$_GET['step'] = '';
}

// przypisanie zmiennych do templatu oraz wyswietlenie zawartosci strony
$smarty -> assign(array("Outpost" => $out -> fields['id'], "View" => $_GET['view'], "Step" => $_GET['step']));
$smarty -> display('outposts.tpl');

// dolaczenie listy graczy (prawa strona) oraz stopki (dol)
require_once("includes/foot.php");
?>

