<?php
//@type: F
//@desc: ¦cieki
/**
*   Funkcje pliku:
*   Labirynt - zwiedzanie oraz przygody
*
*   @name                 : grid.php                            
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : thindil <thindil@users.sourceforge.net>
*   @version              : 0.7 beta
*   @since                : 26.01.2005
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

$title = "Scieki";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

$smarty -> assign(array("Chance" => '', "Maps" => '', "Max" => ''));

if (isset ($_GET['action']) && $_GET['action'] == 'explore') {
	if ($player -> energy < .3) {
		error ("Nie masz wystarczajaco energii aby przemiezac scieki.");
	}
	if ($player -> hp == 0) {
		error ("Nie mozesz przemiezac sciekow poniewaz jestes martwy!");
	}
	$chance = rand(1,10);
	//$db -> Execute("UPDATE players SET energy=energy-.3 WHERE id=".$player -> id);
	$player -> energy -= 0.3;
	if ($chance == 3) {
		$crgain = rand(1,100);
		$smarty -> assign ("Goldgain", $crgain);
		//$db -> Execute("UPDATE players SET credits=credits+".$crgain." WHERE id=".$player -> id);
		$player -> gold += $crgain;
	}
	if ($chance == 6) {
		$plgain = rand(1,3);
		$smarty -> assign ("Mithgain", $plgain);
		//$db -> Execute("UPDATE players SET platinum=platinum+".$plgain." WHERE id=".$player -> id);
		$player -> mithril += $plgain;
	}
	if ($chance == 7) {
		$roll = rand(1,20);
		if ($roll == 15 && $player -> max_energy < 100) {
			$smarty -> assign ("Max", "Y");
			//$db -> Execute("UPDATE players SET max_energy=max_energy+.1 WHERE id=".$player -> id);
			$player -> energy_max += 0.1;
		} else {
			//$db -> Execute("UPDATE players SET energy=energy+1 WHERE id=".$player -> id);
			$player -> energy += 1;
		}
	}
	if ($chance == 9) {
		$objMaps = $db -> Execute("SELECT value FROM settings WHERE setting='maps'");
		$roll = rand(1,50);
		if ($roll == 50 && $objMaps -> fields['maps'] > 0 && $player -> maps < 20 && $player -> rank != 'Bohater') {
			$text = "Wedrujac korytarzami w pewnym momencie w oddali dostrzegasz niewielka, okuta zelazem skrzynie. Podchodzisz do niej i";
			if ($player -> clas == 'Wojownik') {
				$text= $text." rozwalasz ja przy pomocy wlasnej broni.";
			}
			if ($player -> clas == 'Mag') {
				$text = $text." rozwalasz ja przy uzyciu zaklecia.";
			}
			if ($player -> clas == 'Obywatel') {
				$text = $text." przygladajac sie jej uwaznie, dostrzegasz na boku niewielki przycisk. Kiedy go naciskasz, wieko skrzyni unosi sie.";
			}
			$text = $text."Wewnatrz dostrzegasz zwoj starego pergaminu. Ostroznie wyciagasz go i uwaznie przygladasz sie. To kawalek mapy skarbow. Delikatnie chowasz ja w plecaku.";
			$smarty -> assign ( array("Maps" => "Y", "Text" => $text));
			//$db -> Execute("UPDATE players SET maps=maps+1 WHERE id=".$player -> id);
			$player -> maps += 1;
			$intMaps = $objMaps -> fields['value'] - 1;
			$db -> Execute("UPDATE settings SET value='".$intMaps."' WHERE setting='maps'");
		}
	$objMaps -> Close();
	}
	if ($chance == 100) {
		$aviable = $db -> Execute("SELECT qid FROM quests WHERE location='grid.php' AND name='start'");
		$number = $aviable -> RecordCount();
		if ($number > 0) {
			$arramount = array();
			$i = 0;
			while (!$aviable -> EOF) {
				$query = $db -> Execute("SELECT id FROM questaction WHERE quest=".$aviable -> fields['qid']." AND player=".$player -> id);
				if (empty($query -> fields['id'])) {
					$arramount[$i] = $aviable -> fields['qid'];
					$i = $i + 1;
				}
				$query -> Close();
				$aviable -> MoveNext();
			}
			$i = $i - 1;
			if ($i >= 0) {
				$roll = rand(0,$i);
				$name = "quest".$arramount[$roll].".php";
				//$db -> Execute("UPDATE players SET temp=".$arramount[$roll]." WHERE id=".$player -> id);
				$players -> temp = $arramount[$roll];
				require_once("quests/".$name);
			} else {
				$chance = 9;
			}
		}
		$aviable -> Close();
	}
	$energyleft = ($player -> energy - .3);
	$smarty -> assign ( array("Chance" => $chance, "Energyleft" => $energyleft));
}

if (isset($_GET['step']) && $_GET['step'] == 'quest') {
	//$temp = $db -> Execute("SELECT temp FROM players WHERE id=".$player -> id);	
	$temp = $player -> temp;
	$query = $db -> Execute("SELECT quest FROM questaction WHERE player=".$player -> id." AND action!='end'");
	$temp -> Close();
	$name = "quest".$query -> fields['quest'].".php";
	if (!empty($query -> fields['quest'])) {	
		require_once("quests/".$name);
	}
	$query -> Close();    
}

// inicjalizacja zmiennych
if (!isset($_GET['action'])) {
	$_GET['action'] = '';
}
if (!isset($_GET['step'])) {
	$_GET['step'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Action" => $_GET['action'], "Step" => $_GET['step']));
$smarty -> display ('scieki.tpl');

require_once("includes/foot.php");
?>
