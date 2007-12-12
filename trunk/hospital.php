<?php
//@type: F
//@desc: Szpital
/***************************************************************************
 *                               hospital.php
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

$title = "Szpital";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta') {
	error ("Zapomnij o tym");
}*/

$mytribe = $db -> Execute("SELECT hospass FROM tribes WHERE id=".$player -> tribe);
if (!isset ($_GET['action'])) {
    if ($player -> hp == $player -> max_hp) {
	error ("Nie marnuj mojego czasu!",'error','stats.php');
    }
    if ($player -> tribe_id > 0) {
	if ($mytribe -> fields['hospass'] == "Y" && $player -> hp > 0) {
	    error ("Czy mozesz mnie <a href=hospital.php?action=heal>uzdrowic</a>?<br>Jasne, twoj klan obsluguje za darmo");
	}
    }
    if ($player -> hp > 0) {
	$crneed = ($player -> hp_max - $player -> hp);
	if ($crneed > $player -> gold) {
	    error ("Nie mozesz byc wyleczony. Potrzebujesz <b>".$crneed."</b> sztuk zlota.");
	}
        $smarty -> assign ("Need",$crneed);
    }
    if ($player -> hp <= 0) {
	$crneed = ($player -> hp_max * $player -> level);
	if ($crneed > $player -> gold) {
	    error ("Nie mozesz zostac wskrzeszony. Potrzebujesz <b>".$crneed."</b> sztuk zlota.");
	}
        $smarty -> assign ("Need",$crneed);
    }
}

if (isset ($_GET['action']) && $_GET['action'] == 'heal') {
    if ($player -> hp <= 0) {
	error ("Musisz byc wskrzeszony nie uleczony");
    }
    if ($mytribe -> fields['hospass'] == "Y") {
	//$db -> Execute("UPDATE players SET hp=max_hp WHERE id=".$player -> id);
		$player -> hp = $player -> hp_max;
		error ("<br>Jestes kompletnie wyleczony.",'done');
    	}
    $crneed = ($player -> hp_max - $player -> hp);
    if ($crneed > $player -> gold) {
	error ("Nie mozesz byc wyleczony. Potrzebujesz ".$crneed." sztuk zlota");
    }
    //$db -> Execute("UPDATE players SET hp=max_hp WHERE id=".$player -> id);
    //$db -> Execute("UPDATE players SET credits=credits-".$crneed." WHERE id=".$player -> id);
    $player -> hp = $player -> hp_max;
    $player -> gold -= $crneed;
    error ("<br>Jestes kompletnie wyleczony.",'done');
}
$mytribe -> Close();
if (isset ($_GET['action']) && $_GET['action'] == 'ressurect') {
    $pdpr1 = ceil($player -> exp / 100);
    $pdpr = ($pdpr1 * 2);
    $pd = ($player -> exp - $pdpr);
    $crneed = ($player -> hp_max * $player -> level);
    if ($crneed > $player -> gold) {
	error ("Nie mozesz byc wskrzeszony.");
    }
    //$db -> Execute("UPDATE players SET exp=".$pd." WHERE id=".$player -> id);
    //$db -> Execute("UPDATE players SET hp=max_hp WHERE id=".$player -> id);
    //$db -> Execute("UPDATE players SET credits=credits-".$crneed." WHERE id=".$player -> id);
    $player -> exp = $pd;
    $player -> hp = $player -> hp_max;
    $player -> gold -= $crneed;
    error ("<br>Zostales wskrzeszony ale staciles ".$pdpr." Punktow Doswiadczenia.",'done','stats.php');
}

// inicjalizacja zmiennych
if (!isset($_GET['action'])) {
    $_GET['action'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ("Action", $_GET['action']);
$smarty -> display ('hospital.tpl');

require_once("includes/foot.php");
?>

