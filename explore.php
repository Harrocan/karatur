<?php
//@type: F
//@desc: Góry & las
/**
*   Funkcje pliku:
*   zwiedzanie gor oraz lasu
*
*   @name                 : explore.php                            
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

$title = "Poszukiwania";
require_once("includes/head.php");
require_once("includes/funkcje.php");
require_once("includes/turnfight.php");

checklocation($_SERVER['SCRIPT_NAME']);

//$smarty->debugging = true;

/*if ($player -> location == 'Athkatla') {
	error ("Zapomnij o tym");
}*/

// przypisanie zmiennych
		$smarty -> assign(array("Link" => '', "Menu" => ''));


//$kop = $db -> Execute("SELECT gracz FROM kopalnie WHERE gracz=".$player -> id);
//$herb = $db -> Execute("SELECT gracz FROM herbs WHERE gracz=".$player -> id);

function battle() {
	global $player;
	global $smarty;
	require_once('class/fighter.class.php');
	$fighter = new Fighter_player( $player -> id );

	$mon = SqlExec( "SELECT name FROM monsters WHERE id = {$player -> fight}" );
	$monster =  new Fighter_monster( $player -> fight );
		
	require_once('class/battle.class.php');
	$battle = new Battle( 'pvm' );
	$battle -> FigureAdd( $fighter, 'gracz' );
	$battle -> FigureAdd( $monster, 'przeciwnik' );
	$battle -> Battle( );
	
	$player -> fight = 0;
	$player -> energy -= 1;
	
	if ($player -> location == 'Nashkel') {
		$smarty -> assign ("Link", "<br><br><a href=\"explore.php?akcja=gory\">Odswiez</a><br>");
	}
	if ($player -> location == 'Las Ostrych Klow') {
		$smarty -> assign ("Link", "<br><br><a href=\"explore.php?akcja=las\">Odswiez</a><br>");
	}
	if ($player -> location == 'Beregost') {
		$smarty -> assign ("Link", "<br><br><a href=\"explore.php?akcja=dolina\">Odswiez</a><br>");
	}
}

// jezeli gracz nie chce uciekac to nastepuje walka
		if (isset($_GET['step']) && $_GET['step'] == 'battle') {
	battle();
		}

// jezeli gracz ucieka to
		if (isset($_GET['step']) && $_GET['step'] == 'run') {
	$enemy = $db -> Execute("SELECT speed, name, exp1, exp2, id FROM monsters WHERE id=".$player -> fight);
	$chance = (rand(1, $player -> level * 100) + $player -> speed - $enemy -> fields['speed']);
	$smarty -> assign ("Chance", $chance);
	if ($chance > 0) {
		$expgain = rand($enemy -> fields['exp1'],$enemy -> fields['exp2']);
		$expgain = ceil($expgain / 100);
		$smarty -> assign ( array("Ename" => $enemy -> fields['name'], "Expgain" => $expgain));
		//checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
		$player -> AwardExp( $expgain );
		$player -> fight = 0;
	} else {
		$smarty -> assign ("Ename", $enemy -> fields['name']);
		battle();
	}
	$hp = $player -> hp;
	$smarty -> assign ("Health", $hp);
	if ($player -> location == 'Nashkel' && $hp > 0) {
		$smarty -> assign ( array("Yes" => "explore.php?akcja=gory", "No" => "nashkel.php"));
	}
	if ($player -> location == 'Las Ostrych Klow' && $hp > 0) {
		$smarty -> assign ( array("Yes" => "explore.php?akcja=las", "No" => "lasostrychklow.php"));
	}
	if ($player -> location == 'Beregost' && $hp > 0) {
		$smarty -> assign ( array("Yes" => "explore.php?akcja=dolina", "No" => "beregost.php"));
	}
	//$hp -> Close();
		}

		if ($player -> hp > 0 && !isset ($_GET['akcja']) && $player -> location == 'Nashkel' && !isset($_GET['step']) ) {
			if ($player -> fight) {
				$enemy = $db -> Execute("SELECT name FROM monsters WHERE id=".$player -> fight);
				error ("Nie mozesz wedrowac po gorach, poniewaz jestes w trakcie walki!<br>
						Napotkales ".$enemy -> fields['name'].". Czy chcesz sprobowac walki?<br>
						<a href=explore.php?step=battle>Tak</a><br>
						<a href=explore.php?step=run>Nie</a><br>");
				$enemy -> Close();
			}
		}

		if (isset ($_GET['akcja']) && $_GET['akcja'] == 'gory' && $player -> location == 'Nashkel') {
			if ($player -> energy < 0.5) {
				error ("Jestes zbyt zmeczony aby podrozowac po gorach");
			}
			if ($player -> hp <= 0) {
				error ("Nie mozesz zwiedzac gor poniewaz jestes martwy");
			}
	//var_dump( $player -> fight );
	if ( $player -> fight > 0 ) {
		$enemy = $db -> Execute("SELECT name FROM monsters WHERE id=".$player -> fight);
		error ("Nie mozesz wedrowac po gorach, poniewaz jestes w trakcie walki!<br>
				Napotkales ".$enemy -> fields['name'].". Czy chcesz sprobowac walki?<br>
				<a href=explore.php?step=battle>Tak</a><br>
				<a href=explore.php?step=run>Nie</a><br>");
		$enemy -> Close();
	}
	$rzut = rand(1,19);
	if (isset($_GET['step'])) {
		$rzut = 17;
	} else {
		//$db -> Execute("UPDATE players SET energy=energy-0.5 WHERE id=".$player -> id);
		$player -> energy -= 0.5;
	}
	//echo "$rzut<br/><br/>";
	if ($rzut == 9) {
		$ilosc = rand(1,1000);
		$smarty -> assign ("Amount", $ilosc);
		//$db -> Execute("UPDATE players SET credits=credits+".$ilosc." WHERE id=".$player -> id);
		$player -> gold += $ilosc;
	}
	if ($rzut == 10) {
		$ilosc = rand (1,10);
		$smarty -> assign ("Amount", $ilosc);
// 		if (!$kop -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO kopalnie (gracz, meteo) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE kopalnie SET meteo=meteo+".$ilosc." WHERE gracz=".$player -> id);
// 		}
		$player -> meteor += $ilosc;
	}
	if ($rzut >= 11 && $rzut <= 13) {
		$ilosc = rand(1,10);
		$smarty -> assign ("Amount", $ilosc);
//		if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, illani) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET illani=illani+".$ilosc." WHERE gracz=".$player -> id);
// 		}
		$player -> illani += $ilosc;
	}
	if ($rzut >= 14 && $rzut <= 15) {
		$ilosc = rand(1,10);
		$smarty -> assign ("Amount", $ilosc);
		$player -> illanias += $ilosc;
// 		if (!$herb ->fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, illanias) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET illanias=illanias+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut == 16) {
		$ilosc = rand(1,10);
		$smarty -> assign ("Amount", $ilosc);
		$player -> nutari += $ilosc;
// 		if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, nutari) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET nutari=nutari+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut == 18) {
		$ilosc = rand(1,10);
		$smarty -> assign ("Amount" , $ilosc);
		$player -> dynallca += $ilosc;
// 		if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, dynallca) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET dynallca=dynallca+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut >5 && $rzut < 9) {
		$arrmonsters = array(2,3,6,7,15,21,23,35,40,43,47,48,49);
		$rzut2 = rand(0,12);
		$enemy = $db -> Execute("SELECT name, id FROM monsters WHERE id=".$arrmonsters[$rzut2]);
		//$db -> Execute("UPDATE players SET fight=".$enemy -> fields['id']." WHERE id=".$player -> id);
		$player -> fight = $enemy -> fields['id'];
		$smarty -> assign ("Name", $enemy -> fields['name']);
	}
	if (isset($_GET['step']) && $_GET['step'] == 'first') {
		if (!isset($_POST['check'])) {
			error("Zapomnij o tym!");
		}
	}
	if (isset ($_GET['step']) && $_GET['step'] == 'second') {
		$answer = strip_tags($_POST['fanswer']);
		if ($answer == $player -> id) {
			$smarty -> assign ("Answer", "true");
		} else {
				//$db -> Execute("UPDATE players SET hp=0 WHERE id=".$player -> id);
				$player -> hp = 0;
				$smarty -> assign ("Answer", "false");
		}
	}
	if (isset ($_GET['step']) && $_GET['step'] == 'third') {
		if (!isset($_POST['sanswer'])) {
			$_POST['sanswer'] = '';
		}
		$answer = strip_tags($_POST['sanswer']);
		if ($answer == 'Vallheru') {
			$query = $db -> Execute("SELECT id FROM bridge");
			$amount = $query -> RecordCount();
			$query -> Close();
			$number = rand(1,$amount);
			$test = $db -> Execute("SELECT temp FROM players WHERE id=".$player -> id);
			if ($test -> fields['temp'] != 0) {
				$number = $test -> fields['temp'];
			}
			$test -> Close();
			$question = $db -> Execute("SELECT question FROM bridge WHERE id=".$number);
				//$db -> Execute("UPDATE players SET temp=".$number." WHERE id=".$player -> id);
				$player -> temp = $number;
				$smarty -> assign ( array("Question" => $question -> fields['question'], "Number" => $number, "Answer" => "true"));
				$question -> Close();
		} else {
				//$db -> Execute("UPDATE players SET hp=0 WHERE id=".$player -> id);
				$player -> hp =0;
				$smarty -> assign ("Answer", "false");
		}
	}
	if (isset ($_GET['step']) && $_GET['step'] == 'forth') {
		if (!isset($_POST['tanswer'])) {
			$_POST['tanswer'] = '';
		}
		if (!isset($_POST['number'])) {
			$_POST['number'] = 1;
		}
		$answer = $db -> Execute("SELECT answer FROM bridge WHERE id=".$_POST['number']);
		$test = $player -> bridge;
		if ($test == 'Y') {
			error("Mozesz odpowiedziec na pytania tylko raz na reset!");
		}
		$test -> Close();
			//$db -> Execute("UPDATE players SET temp=0 WHERE id=".$player -> id);
			$player -> temp = 0;
			$panswer = strip_tags($_POST['tanswer']);
			if ($panswer == $answer -> fields['answer']) {
				$query = $db -> Execute("SELECT id FROM equipment WHERE owner=0");
				$amount = $query -> RecordCount();
				$query -> Close();
				$roll = rand (0, ($amount-1));
				$arritem = $db -> SelectLimit("SELECT * FROM equipment WHERE owner=0",1,$roll);
				$player -> EquipAdd( $arritem -> fields['id'], 'backpack', 'equipment', 'id' );
				//$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$arritem -> fields['name']."' AND wt=".$arritem -> fields['maxwt']." AND type='".$arritem -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$arritem -> fields['power']." AND zr=".$arritem -> fields['zr']." AND szyb=".$arritem -> fields['szyb']." AND maxwt=".$arritem -> fields['maxwt']." AND cost=1");
				//if (!$test -> fields['id']) {
				//	$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, szyb, twohand) VALUES(".$player -> id.",'".$arritem -> fields['name']."',".$arritem -> fields['power'].",'".$arritem -> fields['type']."',1,".$arritem -> fields['zr'].",".$arritem -> fields['maxwt'].",".$arritem -> fields['minlev'].",".$arritem -> fields['maxwt'].",1,".$arritem -> fields['szyb'].",'".$arritem -> fields['twohand']."')") or error("nie moge dodac!");
				//} else {
				//	$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
				//}
				//$test -> Close();
				//$db -> Execute("UPDATE players SET bridge='Y' WHERE id=".$player -> id);
				$player -> bridge = 'Y';
				$smarty -> assign ( array("Answer" => "true", "Item" => $arritem -> fields['name']));
			} else {
				//$db -> Execute("UPDATE players SET hp=0 WHERE id=".$player -> id);
				$player -> hp = 0;
				$smarty -> assign ("Answer", "false");
			}
	}
	if ($rzut == 19) {
		$objMaps = $db -> Execute("SELECT value FROM settings WHERE setting='maps'");
		$roll = rand (1,50);
		if ($roll == 50 && $objMaps -> fields['value'] > 0 && $player -> maps < 20 && $player -> rank != 'Bohater') {
			if ($player -> clas == 'Wojownik' || $player -> clas == 'Barbarzynca') {
				$open = "rozwalasz ja przy pomocy wlasnej broni.";
			}
			if ($player -> clas == 'Mag') {
				$open = "rozwalasz ja przy uzyciu zaklecia.";
			}
			if ($player -> clas == 'Obywatel' || $player -> clas == 'Zlodziej' || $player -> clas == '') {
				$open = "przygladajac sie jej uwaznie, dostrzegasz na boku niewielki przycisk. Kiedy go naciskasz, wieko skrzyni unosi sie.";
			}
			$smarty -> assign ( array("Maps" => "Y", "Open" => $open));
			//$db -> Execute("UPDATE players SET maps=maps+1 WHERE id=".$player -> id);
			$player -> maps += 1;
			$intMaps = $objMaps -> fields['value'] - 1;
			$db -> Execute("UPDATE setting SET value='".$intMaps."' WHERE setting='maps'");
		} else {
			$smarty -> assign ("Maps", "N");
		}
		$objMaps -> Close();
	}
		//$hp = $db -> Execute("SELECT hp FROM players WHERE id=".$player -> id);
		$hp = $player -> hp;
		if ($hp> 0 && ($rzut < 6 || $rzut > 8) && empty($_GET['step']) && $rzut != 17) {
			$smarty -> assign ( array ("Yes" => "explore.php?akcja=gory", "No" => "nashkel.php", "Menu" => "Y"));
		}
	
		}

		if ($player -> hp > 0 && !isset ($_GET['akcja']) && $player -> location == 'Las Ostrych Klow' && !isset($_GET['step'])) {
			if ($player -> fight) {
				$enemy = $db -> Execute("SELECT name FROM monsters WHERE id=".$player -> fight);
				error ("Nie mozesz wedrowac po lesie, poniewaz jestes w trakcie walki!<br>
						Napotkales ".$enemy -> fields['name'].". Czy chcesz sprobowac walki?<br>
						<a href=explore.php?step=battle>Tak</a><br>
						<a href=explore.php?step=run>Nie</a><br>");
			}
		}

		if (isset ($_GET['akcja']) && $_GET['akcja'] == 'las' && $player -> location == 'Las Ostrych Klow') {
			if ($player -> energy < 0.5) {
				error ("Jestes zbyt zmeczony aby podrozowac po lesie");
			}
			if ($player -> hp <= 0) {
				error ("Nie mozesz wedrowac po lesie poniewaz jestes martwy");
			}
			if ($player -> fight) {
				$enemy = $db -> Execute("SELECT name FROM monsters WHERE id=".$player -> fight);
				error ("Nie mozesz wedrowac po lesie, poniewaz jestes w trakcie walki!<br>
						Napotkales ".$enemy -> fields['name'].". Czy chcesz sprobowac walki?<br>
						<a href=explore.php?step=battle>Tak</a><br>
						<a href=explore.php?step=run>Nie</a><br>");
			}
			$rzut = rand(1,18);
	//$db -> Execute("UPDATE players SET energy=energy-0.5 WHERE id=".$player -> id);
	$player -> energy -= 0.5;
	$pr = ceil($player -> int / 10);
	if ($player -> clas == 'Mag' || $player -> clas == 'Druid') {
		$premia1 = ceil($player -> level / 10);
		$premia = ($premia1 + $pr);
	} else {
		$premia = $pr;
	}
	if ($rzut == 9) {
		$ilosc = rand(1,1000);
		$smarty -> assign ("Amount", $ilosc);
		$player -> gold += $ilosc;
		//$db -> Execute("UPDATE players SET credits=credits+".$ilosc." WHERE id=".$player -> id);
	}
	if ($rzut == 10) {
		$ilosc = rand(1,10);
		$smarty -> assign ("Amount", $ilosc);
		$player -> energy += $ilosc;
		//$db -> Execute("UPDATE players SET energy=energy+".$ilosc." WHERE id=".$player -> id);
	}
	if ($rzut >= 11 && $rzut <= 13) {
		$ilosc = rand(1,10) + $premia;
		$smarty -> assign ("Amount", $ilosc);
		$player -> illani += $ilosc;
// 		if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, illani) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET illani=illani+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut >= 14 && $rzut <= 15) {
		$ilosc = rand(1,10) + $premia;
		$smarty -> assign ("Amount", $ilosc);
		$player -> illanias += $ilosc;
// 			if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, illanias) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET illanias=illanias+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut == 16) {
		$ilosc = rand(1,10) + $premia;
		$smarty -> assign ("Amount", $ilosc);
		$player -> nutari += $ilosc;
// 			if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, nutari) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET nutari=nutari+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut == 17) {
		$ilosc = rand(1,10) + $premia;
		$smarty -> assign ("Amount", $ilosc);
		$player -> dynallca += $ilosc;
// 			if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, dynallca) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET dynallca=dynallca+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut >5 && $rzut < 9) {
		$arrmonsters = array(1,3,4,8,10,14,16,19,24,33,36,39,42,46,50);
		$rzut2 = rand(0,14);
		$enemyy = $db -> Execute("SELECT name, id FROM monsters WHERE id=".$arrmonsters[$rzut2])or error("Nie moge wykonac zapytania");
		//$db -> Execute("UPDATE players SET fight=".$enemyy -> fields['id']." WHERE id=".$player -> id);
		$player -> fight = $enemyy -> fields['id'];
		$smarty -> assign ("Name", $enemyy -> fields['name']);
		$enemyy -> Close();
	}
	if ($rzut == 18) {
		$objMaps = $db -> Execute("SELECT value FROM settings WHERE setting='maps'");
		$roll = rand(1,500);
		if ($roll > 50 && $objMaps -> fields['value'] > 0 && $player -> maps < 20 && $player -> rank != 'Bohater') {
			if ($player -> clas == 'Wojownik' || $player -> clas == 'Barbarzynca') {
				$open = "rozwalasz ja przy pomocy wlasnej broni.";
			}
			if ($player -> clas == 'Mag') {
				$open = "rozwalasz ja przy uzyciu zaklecia.";
			}
			if ($player -> clas == 'Obywatel' || $player -> clas == 'Zlodziej' || $player -> clas == '') {
				$open = "przygladajac sie jej uwaznie, dostrzegasz na boku niewielki przycisk. Kiedy go naciskasz, wieko skrzyni unosi sie.";
			}
			$smarty -> assign ( array("Maps" => "Y", "Open" => $open));
			//$db -> Execute("UPDATE players SET maps=maps+1 WHERE id=".$player -> id);
			$player -> maps += 1;
			$intMaps = $objMaps -> fields['value'] - 1;
			$db -> Execute("UPDATE settings SET value='".$intMaps."' WHERE setting='maps'");
		} else {
			$smarty -> assign ("Maps", "N");
		}
		$objMaps -> Close();
	}
		//$hp = $db -> Execute("SELECT hp FROM players WHERE id=".$player -> id);
		$hp = $player -> hp;
		if ($hp > 0 && ($rzut < 6 || $rzut > 8)) {
			$smarty -> assign ( array ("Yes" => "explore.php?akcja=las", "No" => "lasostrychklow.php", "Menu" => "Y"));
		}
	//$hp -> Close();
		}

		if ($player -> hp > 0 && !isset ($_GET['akcja']) && $player -> location == 'Beregost' && !isset($_GET['step'])) {
			if ($player -> fight) {
				$enemy = $db -> Execute("SELECT name FROM monsters WHERE id=".$player -> fight);
				error ("Nie mozesz wedrowac po Berego¶cie, poniewaz jestes w trakcie walki!<br>
						Napotkales ".$enemy -> fields['name'].". Czy chcesz sprobowac walki?<br>
						<a href=explore.php?step=battle>Tak</a><br>
						<a href=explore.php?step=run>Nie</a><br>");
			}
		}

		if (isset ($_GET['akcja']) && $_GET['akcja'] == 'dolina' && $player -> location == 'Beregost') {
			if ($player -> energy < 0.5) {
				error ("Jestes zbyt zmeczony aby podrozowac po dolinie");
			}
			if ($player -> hp <= 0) {
				error ("Nie mozesz wedrowac po lesie poniewaz jestes martwy");
			}
			if ($player -> fight) {
				$enemy = $db -> Execute("SELECT name FROM monsters WHERE id=".$player -> fight);
				error ("Nie mozesz wedrowac po Dolinie, poniewaz jestes w trakcie walki!<br>
						Napotkales ".$enemy -> fields['name'].". Czy chcesz sprobowac walki?<br>
						<a href=explore.php?step=battle>Tak</a><br>
						<a href=explore.php?step=run>Nie</a><br>");
			}
			$rzut = rand(1,18);
	//$db -> Execute("UPDATE players SET energy=energy-0.5 WHERE id=".$player -> id);
	$player -> energy -= 0.5;
	if ($rzut == 9) {
		$ilosc = rand(1,1000);
		$smarty -> assign ("Amount", $ilosc);
		$player -> gold += $ilosc;
		//$db -> Execute("UPDATE players SET credits=credits+".$ilosc." WHERE id=".$player -> id);
	}
	if ($rzut == 10) {
		$ilosc = rand(1,10);
		$smarty -> assign ("Amount", $ilosc);
		$player -> energy += $ilosc;
		//$db -> Execute("UPDATE players SET energy=energy+".$ilosc." WHERE id=".$player -> id);
	}
	if ($rzut >= 11 && $rzut <= 13) {
		$ilosc = rand(1,10);
		$smarty -> assign ("Amount", $ilosc);
		$player -> illani += $ilosc;
// 		if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, illani) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET illani=illani+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut >= 14 && $rzut <= 15) {
		$ilosc = rand(1,10);
		$smarty -> assign ("Amount", $ilosc);
		$player -> illanias += $ilosc;
// 			if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, illanias) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET illanias=illanias+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut == 16) {
		$ilosc = rand(1,10);
		$smarty -> assign ("Amount", $ilosc);
		$player -> nutari += $ilosc;
// 			if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, nutari) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET nutari=nutari+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut == 17) {
		$ilosc = rand(1,10);
		$smarty -> assign ("Amount", $ilosc);
		$player -> dynallca += $ilosc;
// 			if (!$herb -> fields['gracz']) {
// 		$db -> Execute("INSERT INTO herbs (gracz, dynallca) VALUES(".$player -> id.",".$ilosc.")");
// 		} else {
// 		$db -> Execute("UPDATE herbs SET dynallca=dynallca+".$ilosc." WHERE gracz=".$player -> id);
// 		}
	}
	if ($rzut >5 && $rzut < 9) {
		$arrmonsters = array(1,3,4,8,10,14,16,19,24,33,36,39,42,46,50);
		$rzut2 = rand(0,14);
		$enemy = $db -> Execute("SELECT name, id FROM monsters WHERE id=".$arrmonsters[$rzut2]);
		//$db -> Execute("UPDATE players SET fight=".$enemy -> fields['id']." WHERE id=".$player -> id);
		$player -> fight = $enemy -> fields['id'];
		$smarty -> assign ("Name", $enemy -> fields['name']);
		$enemy -> Close();
	}
	if ($rzut == 18) {
		$objMaps = $db -> Execute("SELECT value FROM settings WHERE setting='maps'");
		$roll = rand(1,500);
		if ($roll > 50 && $objMaps -> fields['value'] > 0 && $player -> maps < 20 && $player -> rank != 'Bohater') {
			if ($player -> clas == 'Wojownik' || $player -> clas == 'Barbarzynca') {
				$open = "rozwalasz ja przy pomocy wlasnej broni.";
			}
			if ($player -> clas == 'Mag') {
				$open = "rozwalasz ja przy uzyciu zaklecia.";
			}
			if ($player -> clas == 'Obywatel' || $player -> clas == 'Zlodziej' || $player -> clas == '') {
				$open = "przygladajac sie jej uwaznie, dostrzegasz na boku niewielki przycisk. Kiedy go naciskasz, wieko skrzyni unosi sie.";
			}
			$smarty -> assign ( array("Maps" => "Y", "Open" => $open));
			//$db -> Execute("UPDATE players SET maps=maps+1 WHERE id=".$player -> id);
			$player -> maps += 1;
			$intMaps = $objMaps -> fields['value'] - 1;
			$db -> Execute("UPDATE settings SET value='".$intMaps."' WHERE setting='maps'");
		} else {
			$smarty -> assign ("Maps", "N");
		}
		$objMaps -> Close();
	}
		//$hp = $db -> Execute("SELECT hp FROM players WHERE id=".$player -> id);
		$hp = $player -> hp;
		if ($hp > 0 && ($rzut < 6 || $rzut > 8)) {
			$smarty -> assign ( array ("Yes" => "explore.php?akcja=dolina", "No" => "beregost.php", "Menu" => "Y"));
		}
	//$hp -> Close();
		}

// inicjalizacja zmiennych
		if (!isset($_GET['step'])) {
	$_GET['step'] = '';
		}
		if (!isset($_GET['akcja'])) {
			$_GET['akcja'] = '';
		}
		if (!isset($rzut)) {
			$rzut = '';
		}

		$smarty -> assign ( array("Step" => $_GET['step'], "Fight" => $player -> fight, "Action" => $_GET['akcja'],
							"Location" => $player -> location, "Roll" => $rzut));
		$smarty -> display('explore.tpl');

		require_once("includes/foot.php");
		?>
