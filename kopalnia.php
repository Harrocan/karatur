<?php
//@type: F
//@desc: Kopalnia mithrilu
/***************************************************************************
 *                               kopalnia.php
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

$title = "Kopalnia";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Nashkel') {
	error ("Zapomnij o tym");
}*/

//$kop = $db -> Execute("SELECT id, adam, krysztal FROM kopalnie WHERE gracz=".$player -> id);

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'kop') {
    if ($player -> energy < 0.5) {
	error ("Nie mozesz poszukiwac mineralow poniewaz nie masz energii!");
    }
    if ($player -> hp <= 0) {
	error ("Nie mozesz pracowac w kopalni, poniewaz jestes martwy!");
    }
    //$db -> Execute("UPDATE players SET energy=energy-0.5 WHERE id=".$player -> id);
	$player -> energy -= 0.5;
    $pr = ceil($player -> str / 10);
    if ($player -> clas == 'Rzemieslnik') {
	$premia1 = ceil($player -> level / 10);
	$premia = ($premia1 + $pr);
    } else {
	$premia = $pr;
    }
    $rzut = mt_rand(2,10);
	
	//echo "$rzut<br/><br/>";
    if ($rzut == 5) {
	$ilosc = (mt_rand(1,10) + $premia);
	$smarty -> assign ("Amount", $ilosc);
	//if (!$kop -> fields['id']) {
	//    $db -> Execute("INSERT INTO kopalnie (gracz, krysztal) VALUES(".$player -> id.",".$ilosc.")");
	//} else {
	//    $db -> Execute("UPDATE kopalnie SET krysztal=krysztal+".$ilosc." WHERE gracz=".$player -> id);
	//}
	$player -> crystal += $ilosc;
    }
    if ($rzut == 6) {
	$ilosc = (mt_rand(1,10) + $premia);
	$smarty -> assign ("Amount", $ilosc);
// 	if (!$kop -> fields['id']) {
// 	    $db -> Execute("INSERT INTO kopalnie (gracz, adam) VALUES(".$player -> id.",".$ilosc.")");
// 	} else {
// 	    $db -> Execute("UPDATE kopalnie SET adam=adam+".$ilosc." WHERE gracz=".$player -> id);
// 	}
	$player -> adamantium += $ilosc;
    }
    if ($rzut == 7) {
	$ilosc = (mt_rand(1,50) + $premia);
	$smarty -> assign ("Amount", $ilosc);
	$player -> adamantium += $ilosc;
// 	if (!$kop -> fields['id']) {
// 	    $db -> Execute("INSERT INTO kopalnie (gracz, adam) VALUES(".$player -> id.",".$ilosc.")");
// 	} else {
// 	    $db -> Execute("UPDATE kopalnie SET adam=adam+".$ilosc." WHERE gracz=".$player -> id);
// 	}
    }
    if ($rzut == 8) {
	$ilosc = (mt_rand(1,30) + $premia);
	$smarty -> assign ("Amount", $ilosc);
	//$db -> Execute("UPDATE players SET platinum=platinum+".$ilosc." WHERE id=".$player -> id);
	$player -> mithril += $ilosc;
    }
    if ($rzut == 9) {
	$ilosc = (mt_rand(1,1000) + 2 * $premia);
	$smarty -> assign ("Amount", $ilosc);
	//$db -> Execute("UPDATE players SET credits=credits+".$ilosc." WHERE id=".$player -> id);
	$player -> gold += $ilosc;
    }
    if ($rzut == 10) {
	$rzut2 = mt_rand(1,150);
	if ($rzut2 <= 50) {
	    $smarty -> assign ("Health", 0);
	    $player -> hp = 0;
	    //$db -> Execute("UPDATE players SET hp=0 WHERE id=".$player -> id);
	} else {
	}
    }
}
//$kop -> Close();

// inicjalizacja zmiennych
if (!isset($_GET['akcja'])) {
    $_GET['akcja'] = '';
}
if (!isset($rzut)) {
    $rzut = 0;
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Action" => $_GET['akcja'], "Roll" => $rzut,"File"=>$_SESSION['file'],"Location"=>$player->location));
$smarty -> display ('kopalnia.tpl');

require_once("includes/foot.php"); 
?>

