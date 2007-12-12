<?php
//@type: F
//@desc: Wyr±b drewna
/***************************************************************************
*                               lumberjack.php
*                            -------------------
*   copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
*   email                : webmaster@uc.h4c.pl
*
***************************************************************************/

/***************************************************************************
*
*       This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with this program; if not, write to the Free Software
*   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
***************************************************************************/ 

$title = "Wyrab";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Las Ostrych Klow' && $player -> location != 'Beregost') {
	error ("Zapomnij o tym");
}
*/

//$kop = $db -> Execute("SELECT id FROM kopalnie WHERE gracz=".$player -> id);

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'chop') {
	if ($player-> energy < 0.5) {
		error ("Nie mozesz wyrabywac drewna poniewaz nie masz energii!");
	}
	if ($player -> hp <= 0) {
		error ("Nie mozesz wyrabywac drewna, poniewaz jestes martwy!");
	}
	//$db -> Execute("UPDATE players SET energy=energy-0.5 WHERE id=".$player -> id);
	$player -> energy -= 0.5;
	$pr = ceil($player -> strength / 10);
	if ($player -> clas == 'Rzemieslnik') {
		$premia1 = ceil($player -> level / 10);
		$premia = ($premia1 + $pr);
	}
	else {
		$premia = $pr;
	}
	$rzut = rand(1,8);
	if ($rzut == 5) {
	$ilosc = (rand(1,10) + $premia);
	$smarty -> assign ("Amount", $ilosc);
	//if (!$kop -> fields['id']) {
	//	$db -> Execute("INSERT INTO kopalnie (gracz, lumber) VALUES(".$player -> id.",".$ilosc.")");
	//} else {
	//	$db -> Execute("UPDATE kopalnie SET lumber=lumber+".$ilosc." WHERE gracz=".$player -> id);
	//}
	$player -> wood += $ilosc;
	}
	if ($rzut == 6) {
	$ilosc = (rand(1,50) + $premia);
	$smarty -> assign ("Amount", $ilosc);
	//if (!$kop -> fields['id']) {
	//	$db -> Execute("INSERT INTO kopalnie (gracz, lumber) VALUES(".$player -> id.",".$ilosc.")");
	//} else {
	//	$db -> Execute("UPDATE kopalnie SET lumber=lumber+".$ilosc." WHERE gracz=".$player -> id);
	//}
	$player -> wood += $ilosc;
	}
	if ($rzut == 7) {
	$ilosc = rand(1,100);
	$smarty -> assign ("Amount", $ilosc);
	//$db -> Execute("UPDATE players SET credits=credits+".$ilosc." WHERE id=".$player -> id);
	$player -> gold += $ilosc;
	}
	if ($rzut == 8) {
	$rzut2 = rand(1,100);
	if ($rzut2 <= 50) {
			$losthp = rand(1,100);
		if ($losthp > $player -> hp) {
			$losthp = $player -> hp;
		}
		//$db -> Execute("UPDATE players SET hp=hp-".$losthp." WHERE id=".$player -> id);
		$player -> hp -= $losthp;
		//$player -> hp = $player -> hp - $losthp;
		$smarty -> assign ( array("Amount" => $losthp, "Lost" => 1, "Health" => $player -> hp));
	} else {
			$smarty -> assign("Lost", 0);
		}
	}
	$smarty -> assign("Roll", $rzut);
}
//$kop -> Close();

// inicjalizacja zmiennej
if (!isset($_GET['akcja'])) {
	$_GET['akcja'] = '';
}

// przypisanie zmiennej oraz wyswietlenie strony
$smarty -> assign ("Action", $_GET['akcja']);
$smarty -> display ('lumberjack.tpl');

require_once("includes/foot.php"); 
?>
