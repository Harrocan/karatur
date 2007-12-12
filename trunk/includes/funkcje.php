<?php
/**
 *   Funkcje pliku:
 *   Funkcje do walki pomiedzy graczami oraz szybka walka gracz vs potwory
 *
 *   @name                 : funkcje.php                            
 *   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 10.01.2005
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

require_once ('includes/checkexp.php');

// Funkcja obliczajaca straty cech podczas walki
function loststat($lostid,$strength,$agility,$inteli,$wytrz,$szyb,$wisdom,$winid,$winuser,$starter) {
	global $db;
	global $newdate;

	$number = rand(0,5);
	$values = array($strength,$agility,$inteli,$wytrz,$szyb,$wisdom);
	$stats = array('strength','agility','inteli','wytrz','szyb','wisdom');
	$name = array('sily','zrecznosci','inteligencji','wytrzymalosci','szybkosci','sily woli');
	$lost = ($values[$number] / 200);
	//$db -> Execute("UPDATE players SET ".$stats[$number]."=".$stats[$number]."-".$lost." WHERE id=".$lostid);
	$player -> $stats[$number] -= $lost;
    $stat = $name[$number];
	if ($lostid == $starter) {
	    $attacktext = 'Zaatakowales i';
	} else {
	    $attacktext = 'Zaatakowano ciebie i';
        }
	if ($winid) {
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$lostid.",'".$attacktext." zostales pokonany przez <b><a href=view.php?view=".$winid.">".$winuser."</a> ID:".$winid."</b>. Straciles ".$lost." ".$stat."','".$newdate."')") or die("nie moge dodac do dziennika!");
	} else {
            if (!isset($_POST['razy'])) {
                $_POST['razy'] = 1;
            }
	    print "<br><b>Wynik:</b> Zostales pokonany przez <b>".$_POST['razy']." ".$winuser."</b>. Straciles ".$lost." ".$stat;
	}
}

// Funkcja obliczajaca podniesienie umiejetnosci podczas walki
function gainability ($gid,$user,$gunik,$gatak,$gmagia,$pm,$player2,$stats) {
	global $db;

	if (($gunik || $gatak || $gmagia) && ($player2 == $gid)) {
		print "<br>".$user." zdobywa:<br>";
	}
	if ($gunik > 0) {
		$dunik = ($gunik / 100);
		if ($player2 == $gid) {
			print "<b>".$dunik."</b> w umiejetnosci uniki<br>";
		}
		//$db -> Execute("UPDATE players SET unik=unik+".$dunik." WHERE id=".$gid);
		$player -> miss += $dunik;
	}
	if ($gatak > 0 && $stats == 'weapon') {
		$datak = ($gatak / 100);
		if ($player2 == $gid) {
			print "<b>".$datak."</b> w umiejetnosci walka bronia<br>";
		}
		//$db -> Execute("UPDATE players SET atak=atak+".$datak." WHERE id=".$gid);
		$player -> melee += $datak;
	}
	if ($gatak > 0 && $stats == 'bow') {
		$datak = ($gatak / 100);
		if ($player2 == $gid) {
			print "<b>".$datak."</b> w umiejetnosci strzelanie<br>";
		}
		//$db -> Execute("UPDATE players SET shoot=shoot+".$datak." WHERE id=".$gid);
		$player -> ranged += $datak;
	}
	if ($gmagia > 0) {
		$dmagia = ($gmagia / 100);
		if ($player2 == $gid) {
			print "<b>".$dmagia."</b> w umiejetnosci rzucanie czarow<br>";
		}
		//$db -> Execute("UPDATE players SET magia=magia+".$dmagia." WHERE id=".$gid);
		$player ->  cast += $dmagia;
	}
	if ($pm <= 0) {
		$pm = 0;
	}

	//$db -> Execute("UPDATE players SET pm=".$pm." WHERE id=".$gid);
	$player -> pm = $pm;
}

// Funkcja obliczajaca uszkodzenia broni oraz zbroi podczas walki
function lostitem($lostdur,$itemdur,$type,$player,$itemid,$player2,$lost) {
	global $db;

	$itemdur = ($itemdur - $lostdur);
	if ($itemdur < 1) {
		if ($player == $player2) {
			if ($type == 'Twoj kolczan') {
				print "<br>".$type." jest pusty!<br>";
			} else {
				print "<br>".$type." ".$lost." zniszczeniu!<br>";
			}
		}
		//$db -> Execute("DELETE FROM equipment WHERE id=".$itemid);
	} else {
		if ($player == $player2) {
			if ($type == 'Twoj kolczan') {
				print "<br>Tracisz ".$lostdur." strzal z kolczanu<br>";
			} else {
				print "<br>".$type." traci ".$lostdur." wytrzymalosci.<br>";
			}
		}
		$item = $player -> EquipSearch( array( 'id' => $itemid ), 'equip' );
		$player -> SetEquip( 'equip', key( $item ), array( 'wt' => $itemdur ) );
		//$db -> Execute("UPDATE equipment SET wt=".$itemdur." WHERE id=".$itemid);
	}
}

//Funkcja sprawdzajaca jakie opancerzenie posiada na sobie gracz
function checkarmor($torso,$head,$legs,$shield) {
    global $armor;
    global $number;

	$test = array($torso,$head,$legs,$shield);
	$number = -1;
	$j = 0;
	$armor = array();
	for ($i=0;$i<4;$i++) {
		if ($test[$i] != 0) {
			$number = ($number + 1);
			if ($i == 0) {
				$armor[$j] = 'torso';
			}
			if ($i == 1) {
				$armor[$j] = 'head';
			}
			if ($i == 2) {
				$armor[$j] = 'legs';
			}
			if ($i == 3) {
				$armor[$j] = 'shield';
			}
			$j = ($j + 1);
		}
	}
	return $armor;
}

//Funkcja obliczajaca zrecznosc gracza
function checkagility($agility,$armor,$legs,$shield) {
	$agi1 = ($agility * ($armor / 100));
	$agi2 = ($agility * ($legs / 100));
	$agi3 = ($agility * ($shield / 100));
	//$newagi = ($agi1 - $agi2);
	//$newagility = ($newagi - $agi3);
	//return $newagility;
	return ($agility - $agi1 - $agi2 - $agi3);
}

//Funkcja obliczajaca szybkosc gracza
function checkspeed($speed,$armor,$legs,$weapon,$bow) {
	$speed1 = ($speed * ($armor / 100));
	$speed3 = ($speed * ($legs / 100));
	$speed2 = ($speed * ($weapon / 100));
	$speed4 = ($speed * ($bow / 100));
	//$newspeed = ($speed4 - $speed3);
	//return $newspeed;
	return ($speed - $speed1 - $speed3 + $speed2 + $speed4);
}

// funkcja odpowiedzialna za walke gracza z potworami
function fightmonster($enemy,$expgain,$goldgain,$times) {
	global $player;
	global $smarty;
	global $title;
	global $newdate;
	global $db;
	global $number;

	$myequip = $player -> GetEquipped();
	//$myweapon = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='W' AND owner=".$player -> id);
	//$myarmor = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='A' AND owner=".$player -> id);
	//$myhelm = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='H' AND owner=".$player -> id);
	//$mylegs = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='N' AND owner=".$player -> id);
	//$myshield = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='D' AND owner=".$player -> id);
	//$mczar = $db -> Execute("SELECT * FROM czary WHERE status='E' AND gracz=".$player -> id." AND typ='B'");
	//$mczaro = $db -> Execute("SELECT * FROM czary WHERE status='E' AND gracz=".$player -> id." AND typ='O'");
	//$mybow = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='B' AND owner=".$player -> id);
	//$myarrows = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='R' AND owner=".$player -> id);
	//$mystaff = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='S' AND status='E'");
	//$mycape = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='Z' AND status='E'");
	$premia = 0;
	if (isset ($_POST['razy']) && $_POST['razy'] > 1) {
		$enemyhp = $enemy['hp'] / $_POST['razy'];
	} else {
		$enemyhp = $enemy['hp'];
		$_POST['razy'] = 1;
	}
	if (empty ($enemy)) {
		if ($player -> location == 'Gory') {
			$arrmonsters = array(2,3,6,7,16,17,22,23);
			$rzut2 = rand(0,7);
			$enemy = $db -> Execute("SELECT * FROM monsters WHERE id=".$arrmonsters[$rzut2]);
		}
		if ($player -> location == 'Las') {
			$arrmonsters = array(1,4,11,13,14,19,22,28);
			$rzut2 = rand(0,7);
			$enemy = $db -> Execute("SELECT * FROM monsters WHERE id=".$arrmonsters[$rzut2]);
		}
	}
	if ($title == 'Arena Walk') {
		if ( empty( $myequip['weapon'] ) && empty( $myequip['spellatk'] ) ) {
			error ("Wybierz jakis rodzaj walki (luk, bron biala, czar)!");
		}
		if ( $myequip['weapon']['id'] && $myequip['weapon']['type']!='S' && !empty($myequip['spellatk']) ) {
			error ("Nie mozesz walczyc jednoczesnie bronia i czarem. Wybierz jeden rodzaj walki!");
		}
		if ($myequip['weapon']['type'] == 'B' && empty($myequip['arrows'])) {
			error ("Nie masz strzal w kolczanie!");
		}
		if ($player -> clas == 'Wojownik' && $myequip['spellatk']['id'] ) {
			error ("Tylko mag moze walczyc uzywajac czarow!");
		}
		if ($player -> clas == 'Rzemieslnik' && $myequip['spellatk']['id'] ) {
			error ("Tylko mag moze walczyc uzywajac czarow!");
		}
		if (($player -> clas == 'Mag' || $player->clas=='Kaplan') && !empty( $myequip['spellatk'] )  && $player -> mana == 0) {
			error ("Nie mozesz atakowac poniewaz nie masz punktow magii!");
		}
	}
	//$myagility = checkagility($player -> agility,$myarmor -> fields['zr'],$mylegs -> fields['zr'],$myshield -> fields['zr']);
	//$myspeed = checkspeed($player -> speed,$myarmor -> fields['zr'],$mylegs -> fields['zr'],$myweapon -> fields['szyb'],$mybow -> fields['szyb']);
	
	//if ($myhelm -> fields['id']) {
	//	$premia += $myhelm -> fields['power'];
	//}
	//if ($mylegs -> fields['id']) {
	//	$premia += $mylegs -> fields['power'];
	//}
	//if ($myshield -> fields['id']) {
	//	$premia += $myshield -> fields['power'];
	//}
	
	//print_r($enemy);
	//if ($myweapon -> fields['id']) {
	//	if ($myweapon -> fields['poison'] > 0) {
	//		$myweapon -> fields['power'] = $myweapon -> fields['power'] + $myweapon -> fields['poison'];
	//	}
	//	if ($player -> clas == 'Wojownik' || $player -> clas == 'Barbarzynca') {
	//		$stat['damage'] = (($player -> strength + $myweapon -> fields['power']) + $player -> level);
	//		$enemy['damage'] = ($enemy['strength'] - ($myarmor -> fields['power'] + $player -> level + $player -> con + $premia));
	//	} else {
	//		$stat['damage'] = ($player -> strength + $myweapon -> fields['power']);
	//		$enemy['damage'] = ($enemy['strength'] - ($myarmor -> fields['power'] + $player -> con + $premia));
	//	}
	//	if ($player -> attack < 1) {
	//		$krytyk = 1;
	//	}
	//	if ($player -> attack > 5) {
	//		$kr = ceil($player -> attack / 100);
	//		$krytyk = (5 + $kr);
	//	} else {
	//		$krytyk = $player -> attack;
	//	}
// 	}
// 	if ($mybow -> fields['id']) {
// 		$bonus = $mybow -> fields['power'] + $myarrows -> fields['power'];
// 		$bonus2 = (($player  -> strength / 2) + ($myagility / 2));
// 		if ($player -> clas == 'Wojownik' || $player -> clas == 'Barbarzynca') {
// 			$stat['damage'] = (($bonus2 + $bonus) + $player -> level);
// 			$enemy['damage'] = ($enemy['strength'] - ($player -> level + $player -> con + $premia));
// 		} else {
// 			$stat['damage'] = ($bonus2 + $bonus);
// 			$enemy['damage'] = ($enemy['strength'] - ($player -> con + $premia));
// 		}
// 		if ($player -> shoot < 1) {
// 			$krytyk = 1;
// 		}
// 		if ($player -> shoot > 5) {
// 			$kr = ceil($player -> shoot / 100);
// 			$krytyk = (5 + $kr);
// 		} else {
// 			$krytyk = $player -> shoot;
// 		}
// 		if (!$myarrows -> fields['id']) {
// 			$stat['damage'] = 0;
// 		}
// 	}
// 	if ($mczar -> fields['id']) {
// 		$stat['damage'] = ($mczar -> fields['obr'] * $player -> inteli) - (($mczar -> fields['obr'] * $player -> inteli) * ($myarmor -> fields['minlev'] / 100));
// 		if ($myhelm -> fields['id']) {
// 			$stat['damage'] -= ($stat['damage'] * ($myhelm -> fields['minlev'] / 100));
// 		}
// 		if ($mylegs -> fields['id']) {
// 			$stat['damage'] -= ($stat['damage'] * ($mylegs -> fields['minlev'] / 100));
// 		}
// 		if ($myshield -> fields['id']) {
// 			$stat['damage'] -= ($stat['damage'] * ($myshield -> fields['minlev'] / 100));
// 		}
// 		if ($mystaff -> fields['id']) {
// 			$stat['damage'] += ($stat['damage'] * ($mystaff -> fields['power'] / 100));
// 		}
// 		if ($stat['damage'] < 0) {
// 			$stat['damage'] = 0;
// 		}
// 		if ($player -> magic < 1) {
// 			$krytyk = 1;
// 		}
// 		if ($player -> magic > 5) {
// 			$kr = ceil($player -> magic / 100);
// 			$krytyk = (5 + $kr);
// 		} else {
// 			$krytyk = $player -> magic;
// 		}
// 	}
// 	if ($mczaro -> fields['id']) {
// 		$myczarobr = ($player -> wisdom * $mczaro -> fields['obr']) - (($mczaro -> fields['obr'] * $player -> wisdom) * ($myarmor -> fields['minlev'] / 100));
// 		if ($myhelm -> fields['id']) {
// 			$myczarobr -= (($mczaro -> fields['obr'] * $player -> wisdom) * ($myhelm -> fields['minlev'] / 100));
// 		}
// 		if ($mylegs -> fields['id']) {
// 			$myczarobr -= (($mczaro -> fields['obr'] * $player -> wisdom) * ($mylegs -> fields['minlev'] / 100));
// 		}
// 		if ($myshield -> fields['id']) {
// 			$myczarobr -= (($mczaro -> fields['obr'] * $player -> wisdom) * ($myshield -> fields['minlev'] / 100));
// 		}
// 		if ($mystaff -> fields['id']) {
// 			$myczarobr += ($myczarobr * ($mystaff -> fields['power'] / 100));
// 		}
// 		if ($myczarobr < 0) {
// 			$myczarobr = 0;
// 		}
// 		$myobrona = ($myarmor -> fields['power'] + $myczarobr + $player -> con + $premia);
// 		$enemy['damage'] = ($enemy['strength'] - $myobrona);
// 	}
	
// 	if ($player -> clas == 'Wojownik'  || $player -> clas == 'Barbarzynca' || $player -> clas == 'Lowca') {
// 		$myunik = (($myagility - $enemy['agility']) + $player -> level + $player -> miss);
// 		$eunik = (($enemy['agility'] - $myagility) - ($player -> attack + $player -> level));
// 	}
// 	if ($player -> clas == 'Rzemieslnik' || $player -> clas == 'Zlodziej') {
// 		$myunik = ($myagility - $enemy['agility'] + $player -> miss);
// 		$eunik = (($enemy['agility'] - $myagility) - $player -> attack);
// 	}
// 	if ($player -> clas == 'Mag' || $player -> clas == 'Kaplan' || $player -> clas == 'Druid') {
// 		$myunik = ($myagility - $enemy['agility'] + $player -> miss);
// 		$eunik = (($enemy['agility'] - $myagility) - ($player -> magic + $player -> level));
// 	}
	
	
	$gunik = 0;
	$gatak = 0;
	$gmagia = 0;
	$gwtbr = 0;
	$gwt = array(0,0,0,0);
	//$armor = checkarmor($myarmor -> fields['id'],$myhelm -> fields['id'],$mylegs -> fields['id'],$myshield -> fields['id']);
	$zmeczenie = 0;
	$runda = 1;
	//-----------------------------
	$myagility = $player -> dex;
	$myspeed = $player -> spd;
	
	$enemy['damage'] = $enemy['strength'] - $player -> CombatGetVal( 'armor' );
	$krytyk = $player -> CombatGetVal( 'critical' );
	$myunik = $player -> CombatGetVal( 'miss' ) - $enemy['agility'];
	$eunik = $enemy['agility'] - $player -> CombatGetVal( 'attack' );
	if ($myunik < 1) {
		$myunik = 1;
	}
	if ($eunik < 1) {
		$eunik = 1;
	}
	if ( !empty( $myequip['weapon']) && $myequip['weapon']['type'] == 'B') {
		$eunik *= 2;
	}
	//------------------------------
	if (!isset($stat['damage'])) {
		$stat['damage'] = 0;
	}
	
	//$rzut2 = (rand(1,($player -> level * 10)));
	//$stat['damage'] += $rzut2;
// 	//if ($stat['damage'] < 1) {
// 	//	$stat['damage'] = 0 ;
	//}
	
	
	$stat['attackstr'] = ceil($player -> spd / $enemy['speed']);
	if ($stat['attackstr'] > 5) {
		$stat['attackstr'] = 5;
	}
	$enemy['attackstr'] = ceil($enemy['speed'] / $player ->spd);
	if ($enemy['attackstr'] > 5) {
		$enemy['attackstr'] = 5;
	}
	$smarty -> assign ("Message", "<ul><li><b>".$player -> user."</b> przeciwko <b>".$enemy['name']."</b><br>");
	$smarty -> display ('error1.tpl');

	while ($player -> hp > 0 && $enemy['hp'] > 0 && $runda < 25) {
		$myequip = $player -> GetEquipped();
		//---------------------------------------------------------------
		$stat['damage'] = $player -> CombatGetVal( 'damage' );
		$stat['damage'] -= $enemy['endurance'];
		if ($stat['damage'] < 1) {
			$stat['damage'] = 0 ;
		}
		if ($stat['damage'] > $enemyhp) {
			$stat['damage'] = $enemyhp;
		}
		if ($zmeczenie > $player -> con) {
			$enemy['damage'] = $enemy['strength'];
		}
		$rzut1 = (rand(1,($enemy['level'] * 10)));
		if (!isset($enemy['damage'])) {
			$enemy['damage'] = ($enemy['strength'] - $player -> con);
		}
		$enemy['damage'] += $rzut1;
		if ($enemy['damage'] < 1) {
			$enemy['damage'] = 1;
		}
		//---------------------------------------------------------------
		//if ($player -> mana < $mczar -> fields['poziom']) {
		//	$stat['damage'] = 0;
		//}
		//if ($player -> mana < $mczaro -> fields['poziom']) {
		//	$enemy['damage'] = $enemy['strength'];
		//}
		//if ($myweapon -> fields['id'] && $gwtbr > $myweapon -> fields['wt']) {
		//	$stat['damage'] = 0;
		//	$krytyk = 1;
		//}
		//if ($mybow -> fields['id'] && ($gwtbr > $mybow -> fields['wt'] || $gwtbr > $myarrows -> fields['wt'])) {
		//	$stat['damage'] = 0;
		//	$krytyk = 1;
		//}
		//if ($mybow -> fields['id'] && !$myarrows -> fields['id']) {
		//	$stat['damage'] = 0;
		//	$krytyk = 1;
		//}
		if (isset ($_POST['razy']) && $_POST['razy'] > 1) {
			$amount1 = $enemy['hp'] / $enemyhp;
			$amount = ($amount1 * $enemy['attackstr']);
		} else {
			$amount = $enemy['attackstr'];
		}
		echo "ATTACKSTR : ".$stat['attackstr']." ENEMYATKSTR : ".$enemy['attackstr']." DAMAGE : ".$stat['damage']."<BR>";
		if ($stat['attackstr'] > $enemy['attackstr']) {
			for ($i = 1;$i <= $stat['attackstr']; $i++) {
				//-------------------------------------------------------
				$stat['damage'] = $player -> CombatGetVal( 'damage' ) - $enemy['endurance'];
				if ($stat['damage'] < 1) {
					$stat['damage'] = 0 ;
				}
				if ($stat['damage'] > $enemyhp) {
					$stat['damage'] = $enemyhp;
				}
				//-------------------------------------------------------
				if ($enemy['hp'] > 0 && $player -> hp > 0) {
					$szansa = rand(1,100);
					if ($eunik >= $szansa && $szansa < 95) {
						if( $stat['damage'] > 0 ) {
							//if ($times == 1) {
								$smarty -> assign ("Message", "<b>".$enemy['name']."</b> uniknal twojego ciosu!<br>");
								$smarty -> display ('error1.tpl');
								if ( $myequip['spellatk']['id'] ) {
									$player ->mana -=  $myequip['spellatk']['power'];
								}
								elseif ($myequip['weapon']['type'] == 'B') {
									$player -> CombatEquipWt( 'weapon', 1 );
								}
							//}
						}
					} elseif ($zmeczenie <= $player -> con) {
						if( $stat['damage'] > 0 ) {
							if ( !empty( $myequip['spellatk'] ) ) {
								$pech = floor( $player -> cast - $myequip['spellatk']['power'] * 5 );
								$mod = rand(1,100);
								$pech = ($pech + $mod);
								$lostmana =  $myequip['spellatk']['power'];
								if ($pech <=5 ) {
									$pechowy = rand(1,100);
									if ($pechowy <= 70) {
										//if ($times == 1) {
											$smarty -> assign ("Message", "<b>".$player -> user."</b> probowal rzucic czar, ale niestety nie udalo mu sie opanowac mocy. Traci przez to <b>".$lostmana."</b> punktow magii.<br>");
											$smarty -> display ('error1.tpl');
										//}
										$player -> mana -= $lostmana;
									}
									if ($pechowy > 70 and $pechowy <= 90) {
										//if ($times == 1) {
											$smarty -> assign ("Message", "<b>".$player -> user." probowal rzucic czar, ale stracil panowanie nad swoja koncentracja. Traci przez to wszystkie punkty magii.<br>");
											$smarty -> display ('error1.tpl');
										//}
										$player -> mana = 0;
									}
									if ($pechowy > 90) {
										//if ($times == 1) {
											$smarty -> assign ("Message", "<b>".$player -> user." stracil calkowicie panowanie nad czarem! Czar wybuchl mu prosto w twarz! Traci przez to ".$stat['damage']." punktow zycia!<br>");
											$smarty -> display ('error1.tpl');
										//}
										$player -> hp -= $stat['damage'];
									}
									break;
								}
							}
							$enemy['hp'] = ($enemy['hp'] - $stat['damage']);
							//if ($times == 1) {
								$smarty -> assign ("Message", "Atakujesz <b>".$enemy['name']."</b> i zadajesz <b>".$stat['damage']."</b> obrazen! (".$enemy['hp']." zostalo)</font><br>");
								$smarty -> display ('error1.tpl');
							//}
							if ( !empty( $myequip['spellatk'] ) ) {
								$player ->mana -=  $myequip['spellatk']['power'];
								if( !empty( $myequip['weapon'] ) && $myequip['weapon']['type'] == 'S' ) {
									$lostmana += $myequip['weapon']['power'];
								}
								$gmagia = ($gmagia + 1);
							}
							else {
								$player -> CombatEquipWt( 'weapon', 1 );
								$zmeczenie = ($zmeczenie + $myequip['weapon']['minlev']);
								$gatak = ($gatak + 1);
							}
							//}
						}
							
					}
				}
			}
			if (isset ($_POST['razy']) && $_POST['razy'] > 1) {
				$amount1 = $enemy['hp'] / $enemyhp;
				$amount = ($amount1 * $enemy['attackstr']);
			} else {
				$amount = $enemy['attackstr'];
			}
			for ($i = 1;$i <= $amount; $i++) {
				//-------------------------------------------------------
				$rzut1 = (rand(1,($enemy['level'] * 10)));
				$enemy['damage'] = $enemy['strength'] - $player -> CombatGetVal( 'armor' );
				if (!isset($enemy['damage'])) {
					$enemy['damage'] = ($enemy['strength'] - $player -> con);
				}
				$enemy['damage'] += $rzut1;
				if ($enemy['damage'] < 1) {
					$enemy['damage'] = 1;
				}
				if ($zmeczenie > $player -> con) {
					$enemy['damage'] = $enemy['strength'];
				}
				//---------------------------------------------------------
				if ($player -> hp > 0 && $enemy['hp'] > 0) {
					$szansa = rand(1,100);
					if ($myunik >= $szansa && $zmeczenie <= $player -> con && $szansa < 95) {
						if ($times == 1) {
							$smarty -> assign ("Message", "Uniknales ciosu <b>".$enemy['name']."</b>!<br>");
							$smarty -> display ('error1.tpl');
						}
						$gunik = ($gunik + 1);
						$zmeczenie = ($zmeczenie + $myequip['armor']['minlev']);
					} else {
						$player -> hp = ($player -> hp - $enemy['damage']);
						if ($times == 1) {
							$smarty -> assign ("Message", "<b>".$enemy['name']."</b> atakuje(a) ciebie i zadaje(a) <b>".$enemy['damage']."</b> obrazen! (".$player -> hp." zostalo)<br>");
							$smarty -> display ('error1.tpl');
						}
						$what = array( 'armor', 'helm', 'shield', 'knee' );
						$what = $what[rand(0,4)];
						if ( !empty( $myequip[$what] ) ) {
							$player -> CombatEquipWt( $what, 1 );
						}
						}
						if ( !empty( $myequip['spelldef'] ) ) {
							$lostmana = $myequip['spelldef']['minlev'];
							if( !empty( $myequip['weapon'] ) && $myequip['weapon']['type'] == 'S' ) {
								$lostmana += $myequip['weapon']['power'];
							}
							$player -> mana = ($player -> mana - $lostmana);
						}
					}
				}
			
		} else {
			if (isset ($_POST['razy']) && $_POST['razy'] > 1) {
				$amount1 = $enemy['hp'] / $enemyhp;
				$amount = ($amount1 * $enemy['attackstr']);
			} else {
				$amount = $enemy['attackstr'];
			}
			for ($i = 1;$i <= $amount; $i++) {
				//-------------------------------------------------------
				$rzut1 = (rand(1,($enemy['level'] * 10)));
				$enemy['damage'] = $enemy['strength'] - $player -> CombatGetVal( 'armor' );
				if (!isset($enemy['damage'])) {
					$enemy['damage'] = ($enemy['strength'] - $player -> con);
				}
				$enemy['damage'] += $rzut1;
				if ($enemy['damage'] < 1) {
					$enemy['damage'] = 1;
				}
				if ($zmeczenie > $player -> con) {
					$enemy['damage'] = $enemy['strength'];
				}
				//---------------------------------------------------------
				if ($player -> hp > 0 && $enemy['hp'] > 0) {
					$szansa = rand(1,100);
					if ($myunik >= $szansa && $zmeczenie <= $player -> con && $szansa < 95) {
						if ($times == 1) {
							$smarty -> assign ("Message", "Uniknales ciosu <b>".$enemy['name']."</b>!<br>");
							$smarty -> display ('error1.tpl');
						}
						$gunik = ($gunik + 1);
						$zmeczenie = ($zmeczenie + $myequip['armor']['minlev']);
					} else {
						$player -> hp = ($player -> hp - $enemy['damage']);
						if ($times == 1) {
							$smarty -> assign ("Message", "<b>".$enemy['name']."</b> atakuje(a) ciebie i zadaje(a) <b>".$enemy['damage']."</b> obrazen! (".$player -> hp." zostalo)<br>");
							$smarty -> display ('error1.tpl');
						}
						$what = array( 'armor', 'helm', 'shield', 'knee' );
						$what = $what[rand(0,4)];
						if ( !empty( $myequip[$what] ) ) {
							$player -> CombatEquipWt( $what, 1 );
						}
						}
						if ( !empty( $myequip['spelldef'] ) ) {
							$lostmana = $myequip['spelldef']['minlev'];
							$player -> mana = ($player -> mana - $lostmana);
						}
					}
				}
			for ($i = 1;$i <= $stat['attackstr']; $i++) {
				//-------------------------------------------------------
				$stat['damage'] = $player -> CombatGetVal( 'damage' ) - $enemy['endurance'];
				if ($stat['damage'] < 1) {
					$stat['damage'] = 0 ;
				}
				if ($stat['damage'] > $enemyhp) {
					$stat['damage'] = $enemyhp;
				}
				//-------------------------------------------------------
				if ($enemy['hp'] > 0 && $player -> hp > 0) {
					$szansa = rand(1,100);
					if ($eunik >= $szansa && $szansa < 95) {
						if( $stat['damage'] > 0 ) {
							//if ($times == 1) {
								$smarty -> assign ("Message", "<b>".$enemy['name']."</b> uniknal twojego ciosu!<br>");
								$smarty -> display ('error1.tpl');
								if ( $myequip['spellatk']['id'] ) {
									$player ->mana -=  $myequip['spellatk']['power'];
								}
								elseif ($myequip['weapon']['type'] == 'B') {
									$player -> CombatEquipWt( 'weapon', 1 );
								}
							//}
						}
					} elseif ($zmeczenie <= $player -> con) {
						if( $stat['damage'] > 0 ) {
							if ( $myequip['spellatk']['id'] ) {
								$pech = floor( $player -> cast - $myequip['spellatk']['power'] * 5 );
								$mod = rand(1,100);
								$pech = ($pech + $mod);
								$lostmana =  $myequip['spellatk']['power'];
								if ($pech <=5 ) {
									$pechowy = rand(1,100);
									if ($pechowy <= 70) {
										//if ($times == 1) {
											$smarty -> assign ("Message", "<b>".$player -> user."</b> probowal rzucic czar, ale niestety nie udalo mu sie opanowac mocy. Traci przez to <b>".$lostmana."</b> punktow magii.<br>");
											$smarty -> display ('error1.tpl');
										//}
										$player -> mana -= $lostmana;
									}
									if ($pechowy > 70 and $pechowy <= 90) {
										//if ($times == 1) {
											$smarty -> assign ("Message", "<b>".$player -> user." probowal rzucic czar, ale stracil panowanie nad swoja koncentracja. Traci przez to wszystkie punkty magii.<br>");
											$smarty -> display ('error1.tpl');
										//}
										$player -> mana = 0;
									}
									if ($pechowy > 90) {
										//if ($times == 1) {
											$smarty -> assign ("Message", "<b>".$player -> user." stracil calkowicie panowanie nad czarem! Czar wybuchl mu prosto w twarz! Traci przez to ".$stat['damage']." punktow zycia!<br>");
											$smarty -> display ('error1.tpl');
										//}
										$player -> hp -= $stat['damage'];
									}
									break;
								}
							}
							$enemy['hp'] = ($enemy['hp'] - $stat['damage']);
							//if ($times == 1) {
								$smarty -> assign ("Message", "Atakujesz <b>".$enemy['name']."</b> i zadajesz <b>".$stat['damage']."</b> obrazen! (".$enemy['hp']." zostalo)</font><br>");
								$smarty -> display ('error1.tpl');
							//}
							if ( $myequip['spellatk']['id'] ) {
								$player ->mana -=  $myequip['spellatk']['power'];
								$gmagia = ($gmagia + 1);
							}
							else {
								$player -> CombatEquipWt( 'weapon', 1 );
								$zmeczenie = ($zmeczenie + $myequip['weapon']['minlev']);
								$gatak = ($gatak + 1);
							}
							//}
						}
							
					}
				}
			}
		}
		$runda = ($runda + 1);
	}

	if ($player -> hp <= 0) {
		if ($title != 'Arena Walk') {
			loststat($player -> id,$player -> strength,$player -> agility,$player -> inteli,$player -> con,$player -> speed,$player -> wisdom,0,$enemy['name'],0);
		} else {
			$smarty -> assign ("Message", "</ul>Oslepiajaca gwiadza bolu eksploduje w twojej glowie. Powoli padasz na kolana przed przeciwnikiem. Ostatkiem sil widzisz w zwolnionym tempie jak jego cios spada na twe cialo. Potem nastepuje juz tylko ciemnosc...<br>");
			$smarty -> display ('error1.tpl');
		}
		$db -> Execute("INSERT INTO events (text) VALUES('Gracz ".$player -> user." zostal pokonany przez ".$_POST['razy']." ".$enemy['name']."')");
	} elseif ($runda > 24 && ($player -> hp > 0 && $enemy['hp'] > 0)) {
		$db -> Execute("INSERT INTO events (text) VALUES('Gracz ".$player -> user." zaatakowal ".$_POST['razy']." ".$enemy['name']." lecz walka nie zostala rozstrzygnieta')");
		$smarty -> assign ("Message", "<br><li><b>Wynik:</b> Walka nie rozstrzygnieta!</b>.<li>Zdobywasz: ");
		$smarty -> display ('error1.tpl');
	} else {
		//$db -> Execute("UPDATE players SET credits=credits+".$goldgain." WHERE id=".$player -> id);
		$player -> gold += $goldgain;
		$db -> Execute("INSERT INTO events (text) VALUES('Gracz ".$player -> user." pokonal ".$_POST['razy']." ".$enemy['name']."')");
		$smarty -> assign ("Message", "<br><li><b>Wynik:</b> Pokonales <b>".$_POST['razy']." ".$enemy['name']."</b>.");
		$smarty -> display ('error1.tpl');
		print "<li><b>Nagroda</b><br> Zdobyles <b>".$expgain."</b> PD oraz <b>".$goldgain."</b> sztuk zlota oraz ";
		checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
	}
	if( $gmagia > 0 )
		$player -> cast += $gmagia/100;
	if( $gunik > 0 )
		$player -> miss += $gunik/100;
	if( $gatak > 0 ) {
		if( $myequip['weapon']['type'] == 'W' )
			$player -> melee += $gatak/100;
		elseif( $myequip['weapon']['type'] == 'B' )
			$player -> ranged += $gatak/100;
	}
	
	//gainability($player -> id,$player -> user,$gunik,0,$gmagia,$player -> mana,$player -> id,'');
	//if ($myweapon -> fields['id']) {
		//gainability($player -> id,$player -> user,0,$gatak,0,$player -> mana,$player -> id,'weapon');
		//lostitem($gwtbr,$myweapon -> fields['wt'],'Twoja bron',$player -> id,$myweapon -> fields['id'],$player -> id,'ulega');
	//	if ($myweapon -> fields['poison'] > 0 && $gatak > 0) {
	//		$db -> Execute("UPDATE equipment SET poison=0 WHERE id=".$myweapon -> fields['id']);
	//		$myweapon -> fields['name'] = str_replace("Zatruty ","",$myweapon -> fields['name']);
	//		$db -> Execute("UPDATE equipment SET name='".$myweapon -> fields['name']."' where id=".$myweapon -> fields['id']);
	//	}
	//}
	//if ($mybow -> fields['id']) {
		//gainability($player -> id,$player -> user,0,$gatak,0,$player -> mana,$player -> id,'bow');
		//lostitem($gwtbr,$mybow -> fields['wt'],'Twoja bron',$player -> id,$mybow -> fields['id'],$player -> id,'ulega');
		//lostitem($gwtbr,$myarrows -> fields['wt'],'Twoj kolczan',$player -> id,$myarrows -> fields['id'],$player -> id,'ulega');
	//}
	//if ($myarmor -> fields['id']) {
		//lostitem($gwt[0],$myarmor -> fields['wt'],'Twoja zbroja',$player -> id,$myarmor -> fields['id'],$player -> id,'ulega');
	//}
	//if ($myhelm -> fields['id']) {
		//lostitem($gwt[1],$myhelm -> fields['wt'],'Twoj helm',$player -> id,$myhelm -> fields['id'],$player -> id,'ulega');
	//}
	//if ($mylegs -> fields['id']) {
		//lostitem($gwt[2],$mylegs -> fields['wt'],'Twoje nagolenniki',$player -> id,$mylegs -> fields['id'],$player -> id,'ulegaja');
	//}
	//if ($myshield -> fields['id']) {
		//lostitem($gwt[3],$myshield -> fields['wt'],'Twoja tarcza',$player -> id,$myshield -> fields['id'],$player -> id,'ulega');
	//}
	if ($player -> hp < 0) {
		$player -> hp = 0;
	}
	//$myweapon -> Close();
	//$myarmor -> Close();
	//$myhelm -> Close();
	//$mylegs -> Close();
	//$myshield -> Close();
	//$mczar -> Close();
	//$mczaro -> Close();
	//$mybow -> Close();
	//$myarrows -> Close();
	//$mystaff -> Close();
	//$mycape -> Close();
	$smarty -> assign ("Message", "</ul>");
	$smarty -> display ('error1.tpl');
	if ($title == 'Arena Walk') {
		$smarty -> assign ("Message", "<ul><li><b>Opcje</b><br><a href=battle.php?action=monster>Odejdz</a><br></li></ul>");
		$smarty -> display ('error1.tpl');
	}
	if ($player -> location == 'Portal') {
		$db -> Execute("UPDATE market SET monsterhp=".$enemy['hp']);
	}
	//$db -> Execute("UPDATE players SET hp=".$player -> hp." WHERE id=".$player -> id);
	//$db -> Execute("UPDATE players SET fight=0 WHERE id=".$player -> id);
	$player -> fight =0;
}
?>

