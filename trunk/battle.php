<?php
//@type: F
//@desc: Arena walk
/**
*   Funkcje pliku:
*   Arena walk - walki pomiedzy graczami oraz z potworami
*
*   @name                 : battle.php                            
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : thindil <thindil@users.sourceforge.net>
*   @version              : 0.7 beta
*   @since                : 25.01.2005
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

$title = "Arena Walk";
require_once("includes/head.php");
//require_once("includes/funkcje.php");


if($player->jail=='Y')
	error("Siedzisz w wiêzieniu !");

global $runda;
global $number;
global $newdate;
global $smarty;
global $db;

// funkcja odpowiedzialna za walke pomiedzy graczami
/*
function attack1($attacker,$defender,$attack_wep,$attack_arm,$attack_legs,$attack_helm,$def_wep,$def_arm,$def_legs,$def_helm,$attack_bow,$attack_arrows,$def_bow,$def_arrows,$attack_bspell,$def_bspell,$attack_dspell,$def_dspell,$attack_stam,$def_stam,$attack_staff,$attack_cape,$defender_staff,$defender_cape,$attack_miss,$def_miss,$attack_attack,$def_attack,$attack_magic,$def_magic,$attack_durwep,$def_durwep,$attack_durarm,$def_durarm,$starter,$attack_shield,$def_shield) {
	global $runda;
	global $number;
	global $newdate;
	global $smarty;
	global $db;
	global $player;
	global $compress;
	global $start_time;

	$krytyk = 0;
	$repeat = ($attacker['speed'] / $defender['speed']);
	$attackstr = ceil($repeat);
	$runda = ($runda + 0.5);
	$earmor = checkarmor($def_arm -> fields['id'],$def_helm -> fields['id'],$def_legs -> fields['id'],$def_shield -> fields['id']);
	if ($attackstr <= 0) {
		$attackstr = 1;
	}
	$mypower = 0;
	$epower = 0;
	$krytyk = 0;
	$unik = ($defender['agility'] - $attacker['agility'] + ($defender['miss']));
	if ($attack_bow -> fields['id'] && $attack_durwep <= $attack_bow -> fields['wt'] && $attack_durwep <= $attack_arrows -> fields['wt']) {
		$unik = (($defender['agility'] - $attacker['agility']) + ($defender['miss'] - $attacker['shoot']));
		$bonus = (($attacker['strength'] / 2) + ($attacker['agility'] / 2));
		if ($attacker['clas'] == 'Wojownik' || $attacker['clas'] == 'Barbarzynca' || $attacker['clas'] == 'Lowca') {
			$mypower = (($attack_bow -> fields['power'] + $bonus) + $attacker['level'] + $attack_arrows -> fields['power']);
			$unik = ($unik - $attacker['level']);
		} else {
			$mypower = ($attack_bow -> fields['power'] + $bonus + $attack_arrows -> fields['power']);
		}
		if ($attacker['shoot'] < 1) {
			$krytyk = 1;
		}
		if ($attacker['shoot'] > 5) {
			$kr = ceil($attacker['shoot'] / 100);
			$krytyk = (5 + $kr);
		} else {
			$krytyk = $attacker['shoot'];
		}
	}
	if ($attack_wep -> fields['id'] && $attack_durwep <= $attack_wep -> fields['wt']) {
		$unik = (($defender['agility'] - $attacker['agility']) + ($defender['miss'] - $attacker['attack']));
		if ($attacker['clas'] == 'Wojownik' || $attacker['clas'] == 'Barbarzynca' || $attacker['clas'] == 'Lowca') {
			$mypower = (($attack_wep -> fields['power'] + $attacker['strength']) + $attacker['level']);
			$unik = ($unik - $attacker['level']);
		} else {
			$mypower = ($attack_wep -> fields['power'] + $attacker['strength']);
		}
		if ($attacker['attack'] < 1) {
			$krytyk = 1;
		}
		if ($attacker['attack'] > 5) {
			$kr = ceil($attacker['attack'] / 100);
			$krytyk = (5 + $kr);
		} else {
			$krytyk = $attacker['attack'];
		}
	}
	if ($attack_bspell -> fields['id']) {
		$unik = (($defender['agility'] - $attacker['agility']) + ($defender['miss'] - $attacker['magic']));
		$mypower = ($attack_bspell -> fields['obr'] * $attacker['inteli']) - (($attack_bspell -> fields['obr'] * $attacker['inteli']) * ($attack_arm -> fields['minlev'] / 100));
		if ($attack_helm -> fields['id']) {
			$mypower = ($mypower - (($attack_bspell -> fields['obr'] * $attacker['inteli']) * ($attack_helm -> fields['minlev'] / 100)));
			if ($mypower < 0) {
				$mypower = 0;
			}
		}
		if ($attack_legs -> fields['id']) {
			$mypower = ($mypower - (($attack_bspell -> fields['obr'] * $attacker['inteli']) * ($attack_legs -> fields['minlev'] / 100)));
			if ($mypower < 0) {
				$mypower = 0;
			}
		}
		if ($attack_shield -> fields['id']) {
			$mypower = ($mypower - (($attack_bspell -> fields['obr'] * $attacker['inteli']) * ($attack_shield -> fields['minlev'] / 100)));
			if ($mypower < 0) {
				$mypower = 0;
			}
		}
		if ($attack_staff -> fields['id']) {
				$premia = (($attack_staff -> fields['power'] / 100) * $mypower);
				$mypower = $mypower + $premia;
		}
		$pech = floor($attacker['magic'] - $attack_bspell -> fields['poziom']);
		if ($pech > 0) {
			$pech = 0;
		}
		$pech = ($pech + rand(1,100));
		if ($attacker['magic'] < 1) {
			$krytyk = 1;
		}
		if ($attacker['magic'] > 5) {
			$kr = ceil($attacker['magic']/100);
			$krytyk = (5 + $kr);
		} else {
			$krytyk = $attacker['magic'];
		}
		if ($attacker['mana'] <= 0) {
			$mypower = 0;
		}
	}

	if ($defender['clas'] == 'Wojownik' || $defender['clas'] == 'Barbarzynca' || $defender['clas'] == 'Lowca') {
		$epower = ($def_arm -> fields['power'] + $defender['level'] + $defender['cond'] + $def_helm -> fields['power'] + $def_legs -> fields['power'] + $def_shield -> fields['power']);
		$unik = ($unik + $defender['level']);
		if ($attack_bow -> fields['id']) {
			$unik = $unik * 2;
		}
	}
	if ($defender['clas'] == 'Rzemieslnik' || $defender['clas'] == 'Zlodziej') {
		$epower = ($def_arm  -> fields['power'] + $defender['cond'] + $def_helm -> fields['power'] + $def_legs -> fields['power'] + $def_shield -> fields['power']);
		if ($attack_bow -> fields['id']) {
			$unik = $unik * 2;
		}
	}
	if ($defender['clas'] == 'Mag' || $defender['clas'] == 'Kaplan' || $defender['clas'] == 'Druid') {
		if ($defender['mana'] <= 0) {
			$epower = ($def_arm -> fields['power'] + $defender['cond'] + $def_helm -> fields['power'] + $def_legs -> fields['power'] + $def_shield -> fields['power']);
		} else {
			$eczarobr = ($defender['wisdom'] * $def_dspell -> fields['obr']) - (($def_dspell -> fields['obr'] * $defender['wisdom']) * ($def_arm -> fields['minlev'] / 100));
			if ($def_helm -> fields['id']) {
				$eczarobr = ($eczarobr - (($def_dspell -> fields['obr'] * $defender['wisdom']) * ($def_helm -> fields['minlev'] / 100)));
				if ($eczarobr < 0) {
					$eczarobr = 0;
				}
			}
			if ($def_legs -> fields['id']) {
				$eczarobr = ($eczarobr - (($def_dspell -> fields['obr'] * $defender['wisdom']) * ($def_legs -> fields['minlev'] / 100)));
				if ($eczarobr < 0) {
					$eczarobr = 0;
				}
			}
			if ($def_shield -> fields['id']) {
				$eczarobr = ($eczarobr - (($def_dspell -> fields['obr'] * $defender['wisdom']) * ($def_shield -> fields['minlev'] / 100)));
				if ($eczarobr < 0) {
					$eczarobr = 0;
				}
			}
			if ($defender_staff -> fields['id']) {
				$eczarobr = ($eczarobr + (($defender_staff -> fields['power'] / 100) * $eczarobr));
			}
			$epower = ($def_arm -> fields['power'] + $eczarobr + $defender['cond'] + $def_helm -> fields['power'] + $def_legs    -> fields['power'] + $def_shield -> fields['power']);
		}
		if ($attack_bow -> fields['id']) {
			$unik = $unik * 2;
		}
	}
	if ($unik < 1) {
		$unik = 1;
	}
	$round = 1;
	if (!$attack_bow -> fields['id'] && !$attack_wep -> fields['id'] && !$attack_bspell -> fields['id']) {
		$attackstr = 0;
	}
	if ($attackstr > 5) {
		$attackstr = 5;
	}
	while ($round <= $attackstr && $defender['hp'] >= 0) {
		$rzut1 = (rand(1,$attacker['level']) * 10);
		$mypower = ($mypower + $rzut1);
		$rzut2 = (rand(1,$defender['level']) * 10);
		$epower = ($epower + $rzut2);
		if ($attack_stam > $attacker['cond']) {
			$mypower = 0;
			$unik = 0;
		}
		if ($def_stam > $defender['cond']) {
			$epower = 0;
			$unik = 0;
		}
		$attackdmg = ($mypower - $epower);
		if ($attackdmg <= 0) {
			$attackdmg = 0;
		}
		$szansa = rand(1,100);
		if ($attack_wep -> fields['id']) {
			$attack_stam = ($attack_stam + $attack_wep -> fields['minlev']);
		} elseif ($attack_bow -> fields['id']) {
			$attack_stam = ($attack_stam + $attack_bow -> fields['minlev']);
		}
		if ($unik >= $szansa && $szansa < 95 && $def_stam <= $defender['cond']) {
					$smarty -> assign ("Message", "<b>".$defender['user']."</b> uniknal ataku <b>".$attacker['user']."</b><br>");
					$smarty -> display ('error1.tpl');
					if ($attack_bow -> fields['id']) {
						$attack_durwep = ($attack_durwep + 1);
					}
			$def_miss = ($def_miss + 1);
			$def_stam = ($def_stam + $def_arm -> fields['minlev']);
		} elseif ($attack_stam <= $attacker['cond']) {
			$rzut = rand(1,100);
			if ($krytyk >= $rzut) {
				if ($def_arm -> fields['id'] || $def_helm -> fields['id'] || $def_legs -> fields['id'] || $def_shield -> fields['id']) {
					$efekt = rand(0,$number);
					if ($earmor[$efekt] == 'torso') {
						$def_durarm[0] = ($def_durarm[0] + 1);
					}
					if ($earmor[$efekt] == 'head') {
						$def_durarm[1] = ($def_durarm[1] + 1);
					}
					if ($earmor[$efekt] == 'legs') {
						$def_durarm[2] = ($def_durarm[2] + 1);
					}
					if ($earmor[$efekt] == 'shield') {
						$def_durarm[3] = ($def_durarm[3] + 1);
					}
				}
				if ($def_dspell -> fields['id']) {
						$premia = 0;
						if ($defender_cape -> fields['id']) {
							$premia = ceil($defender_cape -> fields['minlev'] / 2);
						}
						if ($defender_staff -> fields['id']) {
							$premia = ($premia + (ceil($defender_staff -> fields['minlev'] / 2)));
						}
						$lost_mana = ($premia + $def_dspell -> fields['poziom']);
					$defender['mana'] = ($defender['mana'] - $lost_mana);
				}
				if ($attack_wep  -> fields['wt'] > $attack_durwep || ($attack_bow -> fields['wt'] > $attack_durwep && $attack_arrows -> fields['wt'] > $attack_durwep)) {
					$attack_durwep = ($attack_durwep + 1);
					$attack_attack = ($attack_attack + 1);
					$defender['hp'] = 0;
									$smarty -> assign ("Message", "<b>".$attacker['user']."</b> atakuje <b>".$defender['user']."</b> jednym poteznym ciosem i zabija go! (".$defender['hp']." zostalo)<br>");
									$smarty -> display ('error1.tpl');
				}
				if ($attack_bspell -> fields['id'] && $attacker['mana'] > $attack_bspell -> fields['poziom']) {
					if ($pech > 5) {
						$attack_magic = ($attack_magic + 1);
						$defender['hp'] = 0;
											$smarty -> assign ("Message", "<b>".$attacker['user']."</b> atakuje <b>".$defender['user']."</b> jednym poteznym zakleciem i zabija go! (".$defender['hp']." zostalo)<br>");
											$smarty -> display ('error1.tpl');
					} else {
						$pechowy = rand(1,100);
						if ($pechowy <= 70) {
													$smarty -> assign ("Message", "<b>".$attacker['user']."</b> probowal rzucic czar, ale niestety nie udalo mu sie opanowac mocy. Traci przez to <b>".$attack_bspell -> fields['poziom']."</b> punktow magii.<br>");
													$smarty -> display ('error1.tpl');
							$attacker['mana'] = ($attacker['mana'] - $attack_bspell -> fields['poziom']);
						}
						if ($pechowy > 70 && $pechowy <= 90) {
													$smarty -> assign ("Message", "<b>".$attacker['user']."</b> probowal rzucic czar, ale stracil panowanie nad swoja koncentracja. Traci przez to wszystkie punkty magii.<br>");
													$smarty -> display ('error1.tpl');
							$attacker['mana'] = 0;
						}
						if ($pechowy > 90) {
													$smarty -> assign ("Message", "<b>".$attacker['user']."</b> stracil calkowicie panowanie nad czarem! Czar wybuchl mu prosto w twarz! Traci przez to ".$mypower." punktow zycia!<br>");
													$smarty -> display ('error1.tpl');
							$attacker['hp'] = ($attacker['hp'] - $mypower);
						}
						break;
					}
				}
				break;
			} else {
				if ($def_dspell -> fields['id']) {
						$premia = 0;
						if ($defender_cape -> fields['id']) {
							$premia = ceil($defender_cape -> fields['minlev'] / 2);
						}
						if ($defender_staff -> fields['id']) {
							$premia = ($premia + (ceil($defender_staff -> fields['minlev'] / 2)));
						}
						$lost_mana = ($premia + $def_dspell -> fields['poziom']);
					$defender['mana'] = ($defender['mana'] - $lost_mana);
					}
				if ($attack_wep -> fields['wt'] > $attack_durwep || ($attack_bow -> fields['wt'] > $attack_durwep && $attack_arrows -> fields['wt'] > $attack_durwep)) {
					$attack_durwep = ($attack_durwep + 1);
					$defender['hp'] = ($defender['hp'] - $attackdmg);
									$smarty -> assign ("Message", "<b>".$attacker['user']."</b> atakuje <b>".$defender['user']."</b> i zadaje <b>".$attackdmg."</b> obrazen! (".$defender['hp']." zostalo)<br>");
									$smarty -> display ('error1.tpl');
					if ($attackdmg > 0) {
						$attack_attack = ($attack_attack + 1);
					}
					if ($defender['hp'] <= 0) {
						break;
					}
					if ($def_arm -> fields['id'] || $def_helm -> fields['id'] || $def_legs -> fields['id'] || $def_shield -> fields['id']) {
						$efekt = rand(0,$number);
						if ($earmor[$efekt] == 'torso') {
							$def_durarm[0] = ($def_durarm[0] + 1);
						}
						if ($earmor[$efekt] == 'head') {
							$def_durarm[1] = ($def_durarm[1] + 1);
						}
						if ($earmor[$efekt] == 'legs') {
							$def_durarm[2] = ($def_durarm[2] + 1);
						}
						if ($earmor[$efekt] == 'shield') {
							$def_durarm[3] = ($def_durarm[3] + 1);
						}
					}
				}
				if ($attack_bspell -> fields['id'] && $attacker['mana'] > $attack_bspell -> fields['poziom']) {
					if ($pech > 5) {
							$premia = 0;
							if ($attack_staff -> fields['id']) {
								$premia = ceil($attack_staff -> fields['minlev'] / 2);
							}
							if ($attack_cape -> fields['id']) {
								$premia = ($premia + (ceil($attack_staff -> fields['minlev'] / 2)));
							}
							$lost_mana = ($premia + $attack_bspell -> fields['poziom']);
						$attacker['mana'] = ($attacker['mana'] - $lost_mana);
						if ($defender['clas'] == 'Barbarzynca') {
							$roll = rand(1,100);
							$chance = ceil($defender['level'] / 10);
							if ($chance > 20) {
								$chance = 20;
							}
							if ($roll < $chance) {
													$smarty -> assign ("Message", "<b>".$attacker['user']."</b> atakuje <b>".$defender['user']."</b> lecz ten odpiera atak! (".$defender['hp']." zostalo)<br>");
													$smarty -> display ('error1.tpl');
													break;
												}
											}
						$defender['hp'] = ($defender['hp'] - $attackdmg);
						$smarty -> assign ("Message", "<b>".$attacker['user']."</b> atakuje <b>".$defender['user']."</b> i zadaje <b>".$attackdmg."</b> obrazen! (".$defender['hp']." zostalo)<br>");
						$smarty -> display ('error1.tpl');
						if ($attackdmg > 0) {
							$attack_magic = ($attack_magic + 1);
						}
						if ($defender['hp'] <= 0) {
							break;
						}
						if ($def_arm -> fields['id'] || $def_helm -> fields['id'] || $def_legs -> fields['id'] || $def_shield -> fields['id']) {
							$efekt = rand(0,$number);
							if ($earmor[$efekt] == 'torso') {
								$def_durarm[0] = ($def_durarm[0] + 1);
							}
							if ($earmor[$efekt] == 'head') {
								$def_durarm[1] = ($def_durarm[1] + 1);
							}
							if ($earmor[$efekt] == 'legs') {
								$def_durarm[2] = ($def_durarm[2] + 1);
							}
							if ($earmor[$efekt] == 'shield') {
								$def_durarm[3] = ($def_durarm[3] + 1);
							}
						}
					} else {
						$pechowy = rand(1,100);
						if ($pechowy <= 70) {
													$smarty -> assign ("Message", "<b>".$attacker['user']."</b> probowal rzucic czar, ale niestety nie udalo mu sie opanowac mocy. Traci przez to <b>".$attack_bspell -> fields['poziom']."</b> punktow magii.<br>");
													$smarty -> display ('error1.tpl');
							$attacker['mana'] = ($attacker['mana'] - $attack_bspell -> fields['poziom']);
						}
						if ($pechowy > 70 && $pechowy <= 90) {
													$smarty -> assign ("Message", "<b>".$attacker['user']."</b> probowal rzucic czar, ale stracil panowanie nad swoja koncentracja. Traci przez to wszystkie punkty magii.<br>");
													$smarty -> display ('error1.tpl');
							$attacker['mana'] = 0;
						}
						if ($pechowy > 90) {
													$smarty -> assign ("Message", "<b>".$attacker['user']."</b> stracil calkowicie panowanie nad czarem! Czar wybuchl mu prosto w twarz! Traci przez to ".$mypower." punktow zycia!<br>");
													$smarty -> display ('error1.tpl');
							$attacker['hp'] = ($attacker['hp'] - $mypower);
						}
						break;
					}
				}
			}
			}
		$round = ($round + 1);
	}
	if ((($attack_stam > $attacker['cond'] && $def_stam > $defender['cond']) || ($runda >= 25)) && ($attacker['hp'] > 0 && $defender['hp'] > 0)) {
			$smarty -> assign ("Message", "<br>Walka nie rozstrzygnieta!<br>");
			$smarty -> display ('error1.tpl');
			gainability($attacker['id'],$attacker['user'],$attack_miss,0,$attack_magic,$attacker['mana'],$starter,'');
		gainability($defender['id'],$defender['user'],$def_miss,0,$def_magic,$defender['mana'],$starter,'');
		if ($attack_wep -> fields['id']) {
				gainability($attacker['id'],$attacker['user'],0,$attack_attack,0,$attacker['mana'],$starter,'weapon');
			lostitem($attack_durwep,$attack_wep -> fields['wt'],'Twoja bron',$attacker['id'],$attack_wep -> fields['id'],$starter,'ulega');
			if ($attack_wep -> fields['poison'] > 0 && $attack_attack > 0) {
				$db -> Execute("UPDATE equipment SET poison=0 WHERE id=".$attack_wep -> fields['id']);
				$attack_wep -> fields['name'] = str_replace("Zatruty ","",$attack_wep -> fields['name']);
				$db -> Execute("UPDATE equipment SET name='".$attack_wep -> fields['name']."' WHERE id=".$attack_wep -> fields['id']);
			}
		}
		if ($attack_bow -> fields['id']) {
				gainability($attacker['id'],$attacker['user'],0,$attack_attack,0,$attacker['mana'],$starter,'bow');
				lostitem($attack_durwep,$attack_bow -> fields['wt'],'Twoja bron',$attacker['id'],$attack_bow -> fields['id'],$starter,'ulega');
				lostitem($attack_durwep,$attack_arrows -> fields['wt'],'Twoj kolczan',$attacker['id'],$attack_arrows -> fields['id'],$starter,'ulega');
		}
		if ($def_wep -> fields['id']) {
				gainability($defender['id'],$defender['user'],0,$def_attack,0,$defender['mana'],$starter,'weapon');
			lostitem($def_durwep,$def_wep -> fields['wt'],'Twoja bron',$defender['id'],$def_wep -> fields['id'],$starter,'ulega');
			if ($def_wep -> fields['poison'] > 0 && $def_attack > 0) {
				$db -> Execute("UPDATE equipment SET poison=0 WHERE id=".$def_wep -> fields['id']);
				$def_wep -> fields['name'] = str_replace("Zatruty ","",$def_wep -> fields['name']);
				$db -> Execute("UPDATE equipment SET name='".$def_wep -> fields['name']."' WHERE id=".$def_wep -> fields['id']);
			}
		}
		if ($def_bow -> fields['id']) {
				gainability($defender['id'],$defender['user'],0,$def_attack,0,$defender['mana'],$starter,'bow');
			lostitem($def_durwep,$def_bow -> fields['wt'],'Twoja bron',$defender['id'],$def_bow -> fields['id'],$starter,'ulega');
				lostitem($def_durwep,$def_arrows -> fields['wt'],'Twoj kolczan',$defender['id'],$def_arrows -> fields['id'],$starter,'ulega');
		}
		if ($def_arm -> fields['id']) {
			lostitem($def_durarm[0],$def_arm -> fields['wt'],'Twoja zbroja',$defender['id'],$def_arm -> fields['id'],$starter,'ulega');
		}
		if ($def_helm -> fields['id']) {
			lostitem($def_durarm[1],$def_helm -> fields['wt'],'Twoj helm',$defender['id'],$def_helm -> fields['id'],$starter,'ulega');
		}
		if ($def_legs -> fields['id']) {
			lostitem($def_durarm[2],$def_legs -> fields['wt'],'Twoje nagolenniki',$defender['id'],$def_legs -> fields['id'],$starter,'ulegaja');
		}
		if ($def_shield -> fields['id']) {
			lostitem($def_durarm[3],$def_shield -> fields['wt'],'Twoja tarcza',$defender['id'],$def_shield -> fields['id'],$starter,'ulega');
		}
		if ($attack_arm -> fields['id']) {
			lostitem($attack_durarm[0],$attack_arm -> fields['wt'],'Twoja zbroja',$attacker['id'],$attack_arm -> fields['id'],$starter,'ulega');
		}
		if ($attack_helm -> fields['id']) {
			lostitem($attack_durarm[1],$attack_helm -> fields['wt'],'Twoj helm',$attacker['id'],$attack_helm -> fields['id'],$starter,'ulega');
		}
		if ($attack_legs -> fields['id']) {
			lostitem($attack_durarm[2],$attack_legs -> fields['wt'],'Twoje nagolenniki',$attacker['id'],$attack_legs -> fields['id'],$starter,'ulegaja');
		}
		if ($attack_shield -> fields['id']) {
			lostitem($attack_durarm[3],$attack_shield -> fields['wt'],'Twoja tarcza',$attacker['id'],$attack_shield -> fields['id'],$starter,'ulega');
		}
		$db -> Execute("UPDATE players SET hp=".$attacker['hp']." WHERE id=".$attacker['id']);
		$db -> Execute("UPDATE players SET hp=".$defender['hp']." WHERE id=".$defender['id']);
		if ($attacker['id'] == $starter) {
			$attacktext = 'Zaatakowales ale';
			$defendtext = 'Zostales zaatakowany ale';
			$startuser = $attacker['user'];
			$secuser = $defender['user'];
		} else {
			$defendtext = 'Zaatakowales ale';
			$attacktext = 'Zostales zaatakowany ale';
			$startuser = $defender['user'];
			$secuser = $attacker['user'];
				}
				$db -> Execute("INSERT INTO events (text) VALUES('Gracz ".$startuser." zaatakowal ".$secuser." ale walka zostala nieroztrzygnieta')");
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$attacker['id'].",'".$attacktext." walka zostala nierozstrzygnieta z  <b><a href=view.php?view=".$defender['id'].">".$defender['user']."</a> ID:".$defender['id']."</b>.','".$newdate."')");
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$defender['id'].",'".$defendtext." walka zostala nierozstrzygnieta z <b><a href=view.php?view=".$attacker['id'].">".$attacker['user']."</a> ID:".$attacker['id']."</b>.','".$newdate."')");
		require_once("includes/foot.php");
		exit;
	}
	if ($defender['hp'] <= 0) {
		$defender['hp'] = 0;
			$smarty -> assign ("Message", "<br><b>".$attacker['user']."</b> zwycieza!<br>");
			$smarty -> display ('error1.tpl');
			$roll = rand (1,20);
			if ($roll == 20 && $defender['maps'] > 0) {
				$db -> Execute("UPDATE players SET maps=maps+1 WHERE id=".$attacker['id']);
				$db -> Execute("UPDATE players SET maps=maps-1 WHERE id=".$defender['id']);
				$text = 'oraz 1 kawalek mapy!';
			} else {
				$text = '';
			}
		$expgain = (rand(5,10) * $defender['level']);
		$creditgain = ($defender['credits'] / 10);
			$smarty -> assign ("Message", "<b>".$attacker['user']."</b> otrzymuje <b>".$expgain."</b> PD i <b>".$creditgain."</b> sztuk zlota ".$text."<br>");
			$smarty -> display ('error1.tpl');
			gainability($attacker['id'],$attacker['user'],$attack_miss,0,$attack_magic,$attacker['mana'],$starter,'');
		gainability($defender['id'],$defender['user'],$def_miss,0,$def_magic,$defender['mana'],$starter,'');
		if ($attack_wep -> fields['id']) {
				gainability($attacker['id'],$attacker['user'],0,$attack_attack,0,$attacker['mana'],$starter,'weapon');
			lostitem($attack_durwep,$attack_wep -> fields['wt'],'Twoja bron',$attacker['id'],$attack_wep -> fields['id'],$starter,'ulega');
			if ($attack_wep -> fields['poison'] > 0 && $attack_attack > 0) {
				$db -> Execute("UPDATE equipment SET poison=0 WHERE id=".$attack_wep -> fields['id']);
				$attack_wep -> fields['name'] = str_replace("Zatruty ","",$attack_wep -> fields['name']);
				$db -> Execute("UPDATE equipment SET name='".$attack_wep -> fields['name']."' WHERE id=".$attack_wep -> fields['id']);
			}
		}
		if ($attack_bow -> fields['id']) {
				gainability($attacker['id'],$attacker['user'],0,$attack_attack,0,$attacker['mana'],$starter,'bow');
				lostitem($attack_durwep,$attack_bow -> fields['wt'],'Twoja bron',$attacker['id'],$attack_bow -> fields['id'],$starter,'ulega');
				lostitem($attack_durwep,$attack_arrows -> fields['wt'],'Twoj kolczan',$attacker['id'],$attack_arrows -> fields['id'],$starter,'ulega');
		}
		if ($def_wep -> fields['id']) {
				gainability($defender['id'],$defender['user'],0,$def_attack,0,$defender['mana'],$starter,'weapon');
			lostitem($def_durwep,$def_wep -> fields['wt'],'Twoja bron',$defender['id'],$def_wep -> fields['id'],$starter,'ulega');
			if ($def_wep -> fields['poison'] > 0 && $def_attack > 0) {
				$db -> Execute("UPDATE equipment SET poison=0 WHERE id=".$def_wep -> fields['id']);
				$def_wep -> fields['name'] = str_replace("Zatruty ","",$def_wep -> fields['name']);
				$db -> Execute("UPDATE equipment SET name='".$def_wep -> fields['name']."' WHERE id=".$def_wep -> fields['id']);
			}
		}
		if ($def_bow -> fields['id']) {
				gainability($defender['id'],$defender['user'],0,$def_attack,0,$defender['mana'],$starter,'bow');
			lostitem($def_durwep,$def_bow -> fields['wt'],'Twoja bron',$defender['id'],$def_bow -> fields['id'],$starter,'ulega');
				lostitem($def_durwep,$def_arrows -> fields['wt'],'Twoj kolczan',$defender['id'],$def_arrows -> fields['id'],$starter,'ulega');
		}
		if ($def_arm -> fields['id']) {
			lostitem($def_durarm[0],$def_arm -> fields['wt'],'Twoja zbroja',$defender['id'],$def_arm -> fields['id'],$starter,'ulega');
		}
		if ($def_helm -> fields['id']) {
			lostitem($def_durarm[1],$def_helm -> fields['wt'],'Twoj helm',$defender['id'],$def_helm -> fields['id'],$starter,'ulega');
		}
		if ($def_legs -> fields['id']) {
			lostitem($def_durarm[2],$def_legs -> fields['wt'],'Twoje nagolenniki',$defender['id'],$def_legs -> fields['id'],$starter,'ulegaja');
		}
		if ($def_shield -> fields['id']) {
			lostitem($def_durarm[3],$def_shield -> fields['wt'],'Twoja tarcza',$defender['id'],$def_shield -> fields['id'],$starter,'ulega');
		}
		if ($attack_arm -> fields['id']) {
			lostitem($attack_durarm[0],$attack_arm -> fields['wt'],'Twoja zbroja',$attacker['id'],$attack_arm -> fields['id'],$starter,'ulega');
		}
		if ($attack_helm -> fields['id']) {
			lostitem($attack_durarm[1],$attack_helm -> fields['wt'],'Twoj helm',$attacker['id'],$attack_helm -> fields['id'],$starter,'ulega');
		}
		if ($attack_legs -> fields['id']) {
			lostitem($attack_durarm[2],$attack_legs -> fields['wt'],'Twoje nagolenniki',$attacker['id'],$attack_legs -> fields['id'],$starter,'ulegaja');
		}
		if ($attack_shield -> fields['id']) {
			lostitem($attack_durarm[3],$attack_shield -> fields['wt'],'Twoja tarcza',$attacker['id'],$attack_shield -> fields['id'],$starter,'ulega');
		}
		$db -> Execute("UPDATE players SET hp=".$attacker['hp']." WHERE id=".$attacker['id']);
		$db -> Execute("UPDATE players SET hp=0 WHERE id=".$defender['id']);
		$db -> Execute("UPDATE players SET credits=credits+$creditgain WHERE id=".$attacker['id']);
		$db -> Execute("UPDATE players SET credits=credits-$creditgain WHERE id=".$defender['id']);
		$db -> Execute("UPDATE players SET wins=wins+1 WHERE id=".$attacker['id']);
		$db -> Execute("UPDATE players SET losses=losses+1 WHERE id=".$defender['id']);
		$db -> Execute("UPDATE players SET lastkilled='".$defender['user']."' WHERE id=".$attacker['id']);
		$db -> Execute("UPDATE players SET lastkilledby='".$attacker['user']."' WHERE id=".$defender['id']);
		loststat($defender['id'],$defender['strength'],$defender['agility'],$defender['inteli'],$defender['cond'],$defender['speed'],$defender['wisdom'],$attacker['id'],$attacker['user'],$starter);
		checkexp($attacker['exp'],$expgain,$attacker['level'],$attacker['race'],$attacker['user'],$attacker['id'],$defender['id'],$defender['user'],$attacker['id'],'',0);
		if ($attacker['id'] == $starter) {
			$attacktext = 'Zaatakowales i';
			$startuser = $attacker['user'];
			$secuser = $defender['user'];
		} else {
			$attacktext = 'Zostales zaatakowany i';
			$startuser = $defender['user'];
			$secuser = $attacker['user'];
				}
				$db -> Execute("INSERT INTO events (text) VALUES('Gracz ".$startuser." zaatakowal ".$secuser.". Walke wygral ".$attacker['user']."')");
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$attacker['id'].",'".$attacktext." pokonales <b><a href=view.php?view=".$defender['id'].">".$defender['user']."</a> ID:".$defender['id']."</b>. Zdobyles <b>$expgain</b> PD oraz <b>$creditgain</b> sztuk zlota.','$newdate')") or die ("Nie moge dodac wpisu!");
		require_once("includes/foot.php");
		exit;
	}
	attack1($defender,$attacker,$def_wep,$def_arm,$def_legs,$def_helm,$attack_wep,$attack_arm,$attack_legs,$attack_helm,$def_bow,$def_arrows,$attack_bow,$attack_arrows,$def_bspell,$attack_bspell,$def_dspell,$attack_dspell,$def_stam,$attack_stam,$defender_staff,$defender_cape,$attack_staff,$attack_cape,$def_miss,$attack_miss,$def_attack,$attack_attack,$def_magic,$attack_magic,$def_durwep,$attack_durwep,$def_durarm,$attack_durarm,$starter,$def_shield,$attack_shield);
}
*/

if (isset ($_GET['action']) && $_GET['action'] == 'showalive') {
	$elist = $db -> SelectLimit("SELECT id, user, rank, tribe FROM players WHERE level=".$player -> level." AND hp>0 AND miejsce='".$player -> location."' AND id!=".$player -> id." AND immu='N' AND rasa!='' AND klasa!='' AND rest='N'", 50);
	$arrid = array();
	$arrname = array();
	$arrrank = array();
	$arrtribe = array();
	$i = 0;
	while (!$elist -> EOF) {
		if ($elist -> fields['rank'] == 'Admin') {
		$arrrank[$i] = 'Wladca Vallheru';
		} elseif ($elist -> fields['rank'] == 'Staff') {
		$arrrank[$i] = 'Ksiaze Vallheru';
		} elseif ($elist -> fields['rank'] == 'Member') {
		$arrrank[$i] = 'Mieszkaniec Vallheru';
		} else {
		$arrrank[$i] = $elist -> fields['rank'];
		}
		$arrid[$i] = $elist -> fields['id'];
		$arrname[$i] = $elist -> fields['user'];
		$arrtribe[$i] = $elist -> fields['tribe'];
	$elist -> MoveNext();
		$i = $i + 1;
	}
	$elist -> Close();
	$smarty -> assign ( array("Level" => $player -> level, "Enemyid" => $arrid, "Enemyname" => $arrname, "Enemytribe" => $arrtribe, "Enemyrank" => $arrrank));
}

if (isset ($_GET['action']) && $_GET['action'] == 'levellist') {
	if (isset($_GET['step']) && $_GET['step'] == 'go') {
		if (!isset($_POST['slevel'])) {
			error("Podaj poczatkowy poziom!");
		}
		if (!isset($_POST['elevel'])) {
			error("Podaj koncowy poziom!");
		}
	if (!ereg("^[1-9][0-9]*$", $_POST['slevel']) || !ereg("^[1-9][0-9]*$", $_POST['elevel'])) {
		error ("Zapomnij o tym");
	}
	$sql="SELECT players.id, players.user, players.rank, players.tribe, ranks.name AS rname FROM players JOIN ranks ON ranks.id=players.rid  WHERE players.level>={$_POST['slevel']} AND players.level<={$_POST['elevel']} AND players.hp>0 AND players.miejsce='{$player->location}' AND players.id!={$player->id} AND players.immu='N' AND players.rasa!='' AND players.klasa!='' AND players.rest='N' LIMIT 50";
	$elist = SqlExec( $sql );
	$elist=$elist->GetArray();
	//print_r($elist);
	$smarty->assign("Elist",$elist);
	/*		$arrid = array();
			$arrname = array();
			$arrrank = array();
			$arrtribe = array();
			$i = 0;
			while (!$elist -> EOF) {
				if ($elist -> fields['rank'] == 'Admin') {
				$arrrank[$i] = 'Wladca Vallheru';
				} elseif ($elist -> fields['rank'] == 'Staff') {
				$arrrank[$i] = 'Ksiaze Vallheru';
				} elseif ($elist -> fields['rank'] == 'Member') {
				$arrrank[$i] = 'Mieszkaniec Vallheru';
				} else {
				$arrrank[$i] = $elist -> fields['rank'];
				}
				$arrid[$i] = $elist -> fields['id'];
				$arrname[$i] = $elist -> fields['user'];
				$arrtribe[$i] = $elist -> fields['tribe'];
			$elist -> MoveNext();
				$i = $i + 1;
			}
	$elist -> Close();
			$smarty -> assign ( array("Enemyid" => $arrid, "Enemyname" => $arrname, "Enemytribe" => $arrtribe, "Enemyrank" => $arrrank));*/
		}
}

if (isset($_GET['battle'])) {
	//global $runda;
	//global $number;
	//global $newdate;
	//global $smarty;
	//global $db;

// 	$arrmenu = array('age','inteli','clas','immunited','strength','agility','attack','miss','magic','speed','cond','race','wisdom','shoot','id','user','level','exp','hp','credits','mana','maps','jail');
// 	$arrattacker = $player -> stats($arrmenu);
// 	$enemy = new Player($_GET['battle']);
// 	$arrplayer = array('id','user','level','tribe','credits','location','hp','mana','exp','age','inteli','clas','immunited','strength','agility','attack','miss','magic','speed','cond','race','wisdom','shoot','maps','rest','fight','jail');
// 	$arrdefender = $enemy -> stats($arrplayer);
// 	$mywep = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='W' AND status='E'");
// 	$myarm = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='A' AND status='E'");
// 	$myhelm = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='H' AND status='E'");
// 	$mylegs = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='N' AND status='E'");
// 	$ewep = $db -> Execute("SELECT * FROM equipment WHERE owner=".$arrdefender['id']." AND type='W' AND status='E'");
// 	$earm = $db -> Execute("SELECT * FROM equipment WHERE owner=".$arrdefender['id']." AND type='A' AND status='E'");
// 	$ehelm = $db -> Execute("SELECT * FROM equipment WHERE owner=".$arrdefender['id']." AND type='H' AND status='E'");
// 	$elegs = $db -> Execute("SELECT * FROM equipment WHERE owner=".$arrdefender['id']." AND type='H' AND status='E'");
// 	$myczar = $db -> Execute("SELECT * FROM czary WHERE gracz=".$player -> id." AND status='E' AND typ='B'");
// 	$eczar = $db -> Execute("SELECT * FROM czary WHERE gracz=".$arrdefender['id']." AND status='E' AND typ='B'");
// 	$myczaro = $db -> Execute("SELECT * FROM czary WHERE gracz=".$player -> id." AND status='E' AND typ='O'");
// 	$eczaro = $db -> Execute("SELECT * FROM czary WHERE gracz=".$arrdefender['id']." AND status='E' AND typ='O'");
// 	$mybow = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='B' AND status='E'");
// 	$ebow = $db -> Execute("SELECT * FROM equipment WHERE owner=".$arrdefender['id']." AND type='B' AND status='E'");
// 	$myarrows = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='R' AND status='E'");
// 	$earrows = $db -> Execute("SELECT * FROM equipment WHERE owner=".$arrdefender['id']." AND type='R' AND status='E'");
// 	$mystaff = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='S' AND status='E'");
// 	$estaff =  $db -> Execute("SELECT * FROM equipment WHERE owner=".$arrdefender['id']." AND type='S' AND status='E'");
// 	$mycape = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='Z' AND status='E'");
// 	$ecape = $db -> Execute("SELECT * FROM equipment WHERE owner=".$arrdefender['id']." AND type='Z' AND status='E'");
// 	$myshield = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='D' AND status='E'");
// 	$eshield = $db -> Execute("SELECT * FROM equipment WHERE owner=".$arrdefender['id']." AND type='D' AND status='E'");
// 	//$gmywt = array(0,0,0,0);
	//$gewt = array(0,0,0,0);
	//$runda = 0;
	//$arratacker['agility'] = checkagility($arrattacker['agility'],$myarm -> fields['zr'],$mylegs -> fields['zr'],$myshield -> fields['zr']);
	//$arrdefender['agility'] = checkagility($arrdefender['agility'],$earm -> fields['zr'],$elegs -> fields['zr'],$eshield -> fields['zr']);
	//$arratacker['speed'] = checkspeed($arrattacker['speed'],$myarm -> fields['zr'],$mylegs -> fields['zr'],$mywep -> fields['szyb'],$mybow -> fields['szyb']);
	//$arrdefender['speed'] = checkspeed($arrdefender['speed'],$earm -> fields['zr'],$elegs -> fields['zr'],$ewep -> fields['szyb'],$ebow -> fields['szyb']);
	//if ($mywep -> fields['poison'] > 0) {
	//	$mywep -> fields['power'] = $mywep -> fields['power'] + $mywep -> fields['poison'];
	//}
	//if ($ewep -> fields['poison'] > 0) {
	//	$ewep -> fields['power'] = $ewep -> fields['power'] + $ewep -> fields['poison'];
	//}
	$def = new Player( $_GET['battle'] );
	if ( $def -> created == false ) {
		error ("Nie ten gracz.");
	}
	if ($def->id == $player -> id) {
		error ("Nie mozesz zaatakowac siebie.");
	}
	if ($def -> hp <= 0) {
		error ($def->user." jest obecnie martwy.");
	}
	if ($player -> energy < 1) {
		error ("Nie masz wystarczajaco duzo energii.");
	}
	if ($player -> hp <= 0) {
		error ("Jestes martwy.");
	}
	if ($def->tribe_id == $player -> tribe_id && $def->tribe_id > 0) {
		error ("Nie atakuj czlonkow swojego klanu!");
	}
	if ($player -> age < 3) {
		error ("Nie mozesz atakowac innych, tak samo jak inni nie moga atakowac ciebie, poniewaz jestes mlodym graczem");
	}
	if ($def -> age < 3) {
		error ("Nie mozesz atakowac mlodych graczy!");
	}
	if ($player -> jail == 'Y') {
		error("Nie mozesz atakowac poniewaz siedzisz w wiezieniu");
	}
	if ($def -> jail =='Y') {
		error("Gracz którego próbujesz zaatakowac siedzi w wiezieniu");
	}
	if ($player -> clas == '') {
		error ("Nie mozesz atakowac innych graczy, dopoki nie wybierzesz profesji!");
	}
	if ($def -> clas == '') {
		error ("Nie mozesz atakowac gracza, ktory nie wybral jeszcze profesji!");
	}
	//if (($mywep -> fields['id'] && $myczar -> fields['id']) || ($mybow -> fields['id'] && $myczar -> fields['id']) || ($mywep -> fields['id'] && $mybow -> fields['id'])) {
	//	error ("Nie mozesz jednoczesnie walczyc bronia i czarem. Wybierz jeden rodzaj walki!");
	//}
	//if (!$mywep -> fields['id'] && !$myczar -> fields['id'] && !$mybow -> fields['id']) {
	//	error ("Wybierz jakis rodzaj walki(magia lub bron)!");
	//}
	//if ($mybow -> fields['id'] && !$myarrows -> fields['id']) {
	//		error ("Nie mozesz walczyc lukiem poniewaz nie masz strzal w kolczanie!");
	//}
	/*if ($arrattacker['clas'] == 'Wojownik' && $myczar -> fields['id']) {
		error ("Tylko mag moze walczyc uzywajac czarow!");
	}
	if ($arrattacker['clas'] == 'Rzemieslnik' && $myczar -> fields['id']) {
		error ("Tylko mag moze walczyc uzywajac czarow!");
	}*/
	//if($myczar->fields['id'] && ($arrattacker['clas'] == 'Wojownik' || $arrattacker['clas'] == 'Rzemieslnik' || $arrattacker['clas'] == 'Zlodziej' || $arrattacker['clas'] == 'Lowca')) {
	//	error("Tylko mag, kap³an i druid mo¿e uzywaæ czarów");
	//}
	$span =  ($player -> level - $def -> level);
	//echo "{$player -> level} > {$arrdefender['level']}";
	if ($player -> level > $def -> level) {
		error ("Nie mozesz zaatakowac gracza na nizszym poziomie.");
	}
	if ($player -> immu == 'Y') {
		error ("Nie mozesz walczyc, poniewaz masz immunitet!");
	}
	if ($def -> immu == 'Y') {
		error ("Nie mozesz zaatakowac gracza z immunitetem!");
	}
	//if ($arrattacker['clas'] == 'Mag' && $player -> mana == 0 && $myczar -> fields['id']) {
	//	error ("Nie mozesz atakowac przy pomocy czaru, poniewaz nie masz punktow magii!");
	//}
	//if ($arrattacker['clas'] == 'Kaplan' && $player -> mana == 0 && $myczar -> fields['id']) {
	//	error ("Nie mozesz atakowac przy pomocy czaru, poniewaz nie masz punktow magii!");
	//}
	//if ($arrattacker['clas'] == 'Druid' && $player -> mana == 0 && $myczar -> fields['id']) {
	//	error ("Nie mozesz atakowac przy pomocy czaru, poniewaz nie masz punktow magii!");
	//}
	if ($player -> gold < 0) {
		error ("Nie mozesz zaatakowac gracza, poniewaz masz ujemna ilosc zlota!");
	}
	if ($def -> gold < 0) {
		error ("Nie mozesz zaatakowac gracza, poniewaz posiada on ujemna ilosc sztuk zlota!");
	}
	if ($player -> location != $def -> location) {
		error ("Nie mozesz zaatakowac gracza, poniewaz nie przebywa on w tej samej lokacji co ty!");
	}
	if ($def -> rest == 'Y') {
		error ("Nie mozesz atakowac gracza, poniewaz obecnie odpoczywa!");
	}
	if ($def -> fight != 0) {
		error ("Nie mozesz zaatakowac tego gracza, poniewaz obecnie walczy z potworem");
	}
		$smarty -> assign ("Enemyname", $def ->user);
	//$db -> Execute("UPDATE players SET energy=energy-1 WHERE id=".$player -> id);
	$player -> energy --;
	
	require_once('class/fighter.class.php');
	$fighter = new Fighter_player( $player -> id );
	$enemy =  new Fighter_player( $def -> id );
		
	require_once('class/battle.class.php');
	$battle = new Battle( 'pvp' );
	$battle -> FigureAdd( $fighter, 'gracz' );
	$battle -> FigureAdd( $enemy, 'przecienik' );
	$battle -> Battle( );
	
	$stats = array( 'str', 'dex', 'spd', 'con', 'wis', 'int' );
	$statsname = array( 'sily', 'zrecznosci', 'szybkosci', 'wytrzymalosci', 'madrosci', 'inteligencji' );
	$lostatr = array_rand( $stats );
	$atr = $stats[$lostatr];
	$atrname = $statsname[$lostatr];
	
	if( $enemy -> hp <= 0 ) {
		$amount = ( $enemy -> pl -> $atr ) / 200;
		$enemy -> pl -> $atr = $enemy -> pl -> GetAtr( $atr, TRUE ) - $amount;
		PutSignal( $enemy -> id, 'atr' );
		$enemy -> pl -> lastkilledby = $player -> user;
		$enemy -> pl -> losses ++;
		PutSignal( $enemy -> id, 'misc' );
		SqlExec("INSERT INTO log (owner, log, czas) VALUES({$enemy->pl->id},'Zostales zaatakowany i pokonany przez <b><a href=view.php?view={$player->id}>{$player->user}</a> ID:{$player->id}</b>. Straciles $amount $atrname','".$newdate."')");
	}
	else {
		$enemy -> pl -> lastkilled = $player -> user;
		$enemy -> pl -> wins ++;
		PutSignal( $enemy -> id, 'misc' );
		SqlExec("INSERT INTO log (owner, log, czas) VALUES({$enemy->pl->id},'Zostales zaatakowany lecz pokonales <b><a href=view.php?view={$player->id}>{$player->user}</a> ID:{$player->id}</b>.','".$newdate."')");
	}
	if( $fighter -> hp <= 0 ) {
		$amount = ( $player -> $atr ) / 200;
		$player -> $atr = $player -> GetAtr( $atr, TRUE ) - $amount;
		$player -> lastkilledby = $enemy -> pl -> user;
		$player -> losses ++;
		SqlExec("INSERT INTO log (owner, log, czas) VALUES({$fighter->pl->id},'Zaatakowales i zostales pokonany pokonany przez <b><a href=view.php?view={$enemy->id}>{$enemy->pl->user}</a> ID:{$enemy->id}</b>. Straciles $amount $atrname','".$newdate."')");
	}
	else {
		$player -> lastkilled = $enemy -> pl -> user;
		$player -> wins ++;
		SqlExec("INSERT INTO log (owner, log, czas) VALUES({$fighter->pl->id},'Zaatakowales i pokonales <b><a href=view.php?view={$enemy->id}>{$enemy->pl->user}</a> ID:{$enemy->id}</b>.','".$newdate."')");
	}
	
	//if ($arrattacker['speed'] >= $arrdefender['speed']) {
	//	attack1($arrattacker,$arrdefender,$mywep,$myarm,$mylegs,$myhelm,$ewep,$earm,$elegs,$ehelm,$mybow,$myarrows,$ebow,$earrows,$myczar,$eczar,$myczaro,$eczaro,0,0,$mystaff,$mycape,$estaff,$ecape,0,0,0,0,0,0,0,0,$gmywt,$gewt,$arrattacker['id'],$myshield,$eshield);
	//} else {
	//	attack1($arrdefender,$arrattacker,$ewep,$earm,$elegs,$ehelm,$mywep,$myarm,$mylegs,$myhelm,$ebow,$earrows,$mybow,$myarrows,$eczar,$myczar,$eczaro,$myczaro,0,0,$estaff,$ecape,$mystaff,$mycape,0,0,0,0,0,0,0,0,$gmywt,$gewt,$arrattacker['id'],$eshield,$myshield);
	//}
}
if (isset ($_GET['action']) && $_GET['action'] == 'monster') {
	if (!isset($_GET['fight']) && !isset($_GET['fight1'])) {
	$monster = $db -> Execute("SELECT * FROM monsters ORDER BY level ASC");
		$arrid = array();
		$arrname = array();
		$arrlevel = array();
		$arrhp = array();
		$i = 0;
		while (!$monster -> EOF) {
			$arrid[$i] = $monster -> fields['id'];
			$arrname[$i] = $monster -> fields['name'];
			$arrlevel[$i] = $monster -> fields['level'];
			$arrhp[$i] = $monster -> fields['hp'];
		$monster -> MoveNext();
			$i = $i + 1;
		}
	$monster -> Close();
		$smarty -> assign ( array("Enemyid" => $arrid, "Enemyname" => $arrname, "Enemylevel" => $arrlevel, "Enemyhp" => $arrhp));
	}
	if (isset($_GET['dalej'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['dalej'])) {
		error ("Zapomnij o tym");
	}
		$en = $db -> Execute("SELECT id, name FROM monsters WHERE id=".$_GET['dalej']);
		$smarty -> assign ( array("Id" => $en -> fields['id'], "Name" => $en -> fields['name']));
	$en -> Close();
	}
	if (isset ($_GET['next'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['next'])) {
		error ("Zapomnij o tym");
	}
		$en = $db -> Execute("SELECT id, name FROM monsters WHERE id=".$_GET['next']);
		$smarty -> assign ( array("Id" => $en -> fields['id'], "Name" => $en -> fields['name']));
	}
	/*
	if (isset($_GET['fight1'])) {
		//global $arrehp;
		global $newdate;
		if (!isset($_POST['razy'])) {
			error("Zapomnij o tym!");
		}
		if (!ereg("^[1-9][0-9]*$", $_GET['fight1']) || !ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			error ("Podaj numer");
		}
		if ($player -> hp <= 0) {
			error ("Nie masz wystarczajaco duzo zycia aby walczyc.");
		}
		if ($player -> energy < $_POST['razy'] && !isset($_POST['action'])) {
			error ("Nie masz wystarczajaco duzo energii aby walczyc.");
		}
			require_once("includes/turnfight.php");
			$enemy1 = $db -> Execute("SELECT * FROM monsters WHERE id=".$_GET['fight1']);
			if (!$enemy1 -> fields['id']) {
			error ("Tu nie ma potwora.");
		}
		if ($player -> clas == '') {
			error ("Nie mozesz atakowac potwora, dopoki nie wybierzesz profesji!");
		}
			$span = ($enemy1 -> fields['level'] / $player -> level);
			if ($span > 2) {
				$span = 2;
			}
			if (isset ($_POST['write']) && $_POST['write'] == 'Y') {
				//$db -> Execute("UPDATE players SET fight=".$enemy1 -> fields['id']." WHERE id=".$player -> id);
				$player -> fight = $enemy1 -> fields['id'];
				$_POST['write'] = 'N';
			}
		$expgain = ceil((rand($enemy1 -> fields['exp1'],$enemy1 -> fields['exp2']) * $_POST['razy']) * $span);
		$goldgain = ceil((rand($enemy1 -> fields['credits1'],$enemy1 -> fields['credits2']) * $_POST['razy']) * $span);
		$enemy = array("strength" => $enemy1 -> fields['strength'], "agility" => $enemy1 -> fields['agility'], "speed" => $enemy1 -> fields['speed'], "endurance" => $enemy1 -> fields['endurance'], "hp" => $enemy1 -> fields['hp'], "name" => $enemy1 -> fields['name'], "exp1" => $enemy1 -> fields['exp1'], "exp2" => $enemy1 -> fields['exp2'], "level" => $enemy1 -> fields['level']);
		$arrehp = array ();
			if (!isset ($_POST['action'])) {
				$player -> energy = $player -> energy - $_POST['razy'];
				if ($player -> energy < 0) {
					$player -> energy = 0;
				}
				//$db -> Execute("UPDATE players SET energy=".$player -> energy." WHERE id=".$player -> id);
				turnfight ($expgain,$goldgain,'',"battle.php?action=monster&fight1=".$enemy1 -> fields['id']);
			} else {
				turnfight ($expgain,$goldgain,$_POST['action'],"battle.php?action=monster&fight1=".$enemy1 -> fields['id']);
			}
		$enemy1 -> Close();
	}
	*/
	
	if (isset($_GET['fight'])) {
		global $newdate;
		if (!ereg("^[1-9][0-9]*$", $_GET['fight'])) {
			error ("Zapomnij o tym");
		}
		if (!isset($_POST['razy'])) {
				$_POST['razy'] = 1;
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			error ("Zapomnij o tym");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['times'])) {
			error ("Zapomnij o tym");
		}
		if ($player -> hp <= 0) {
			error ("Nie masz wystarczajaco duzo zycia aby walczyc.");
		}
		if ($player -> clas == '') {
			error ("Nie mozesz atakowac potwora, dopoki nie wybierzesz profesji!");
		}
		$lostenergy = $_POST['razy'] * $_POST['times'];
		if ($player -> energy < $lostenergy) {
			error ("Nie masz wystarczajaco duzo energii aby walczyc.");
		}
		
		//print_r( $_POST );
		
		if( !empty( $_POST['razy'] ) )
			$amount = $_POST['razy'];
		else
			$amount = 1;
		
		//error ( "" );
		
		//$player -> energy -= $_POST['razy'];
		
		
		
		require_once('class/fighter.class.php');
		$fighter = new Fighter_player( $player -> id );

		$mon = SqlExec( "SELECT name FROM monsters WHERE id = {$_GET['fight']}" );
		if( empty( $mon -> fields['name'] ) ) {
			error( "Nie ma takiego przeciwnika !" );
		}
		require_once('class/battle.class.php');
		$battle = new Battle( 'pvm' );
		$battle -> FigureAdd( $fighter, 'gracz' );
		
		$monster = array();
		for( $i = 1; $i <= $amount; $i++ ) {
			//$monster[] = new Fighter_monster( $_GET['fight'], "{$mon -> fields['name']} $i" );
			$tmp = new Fighter_monster( $_GET['fight'], "{$mon -> fields['name']} $i" );
			$battle -> FigureAdd( $tmp, 'przeciwnicy' );
		}
		
		//print_r( $monster );
		//die();
		
		
		$battle -> FigureAdd( $monster, 'przeciwnicy' );
		//print_r( $battle );
		//die();
		$battle -> Battle( $_POST['times'] );
		
		$ene = $amount * $battle->totalbattles;
		
		$player -> energy -= $lostenergy;
		
		//$myhp = $player -> hp;
		//for ($j=1;$j<=$_POST['times'];$j++) {
		//	$enemy1 = $db -> Execute("SELECT * FROM monsters WHERE id=".$_GET['fight']);
			//$myexp = $db  -> Execute("SELECT exp, level FROM players WHERE id=".$player -> id);
		//	$enemy1 -> fields['hp'] = ($enemy1 -> fields['hp'] * $_POST['razy']);
			//$player -> hp = $myhp;
			//$player -> exp = $myexp -> fields['exp'];
			//$player -> level = $myexp -> fields['level'];
		//	if (!$enemy1 -> fields['id']) {
		//	error ("Tu nie ma potwora.");
		//	}
			
		//	}
		//		$span = ($enemy1 -> fields['level'] / $player -> level);
		//		if ($span > 2) {
		//			$span = 2;
		//		}
		//	$expgain = ceil((rand($enemy1 -> fields['exp1'],$enemy1 -> fields['exp2']) * $_POST['razy']) * $span);
		//	$goldgain = ceil((rand($enemy1 -> fields['credits1'],$enemy1 -> fields['credits2']) * $_POST['razy']) * $span);
		//	$enemy = array("strength" => $enemy1 -> fields['strength'], "agility" => $enemy1 -> fields['agility'], "speed" => $enemy1 -> fields['speed'], "endurance" => $enemy1 -> fields['endurance'], "hp" => $enemy1 -> fields['hp'], "name" => $enemy1 -> fields['name'], "exp1" => $enemy1 -> fields['exp1'], "exp2" => $enemy1 -> fields['exp2'], "level" => $enemy1 -> fields['level']);
		//	$enemy1 -> Close();
		//	fightmonster ($enemy,$expgain,$goldgain,$_POST['times']);
			//$db -> Execute("UPDATE players SET energy=energy-".$_POST['razy']." WHERE id=".$player -> id);
			
		//	if ($player -> hp <= 0) {
		//		break;
		//	}
		//}
	}
}
//inicjalizacja zmiennych
if (!isset($_GET['battle'])) {
	$_GET['battle'] = '';
}
if (!isset($_GET['step'])) {
	$_GET['step'] = '';
}
if (!isset($_GET['fight'])) {
	$_GET['fight'] = '';
}
if (!isset($_GET['fight1'])) {
	$_GET['fight1'] = '';
}
if (!isset($_GET['dalej'])) {
	$_GET['dalej'] = '';
}
if (!isset($_GET['next'])) {
	$_GET['next'] = '';
}
if (!isset($_GET['action'])) {
	$_GET['action'] = '';
}

//przypisanie zmiennych oraz wyswietlenie zawartosci strony
$smarty -> assign ( array("Action" => $_GET['action'], "Battle" => $_GET['battle'], "Step" => $_GET['step'], "Fight" => $_GET['fight'], "Fight1" => $_GET['fight1'], "Dalej" => $_GET['dalej'], "Next" => $_GET['next']));

$smarty -> display ('battle.tpl');

require_once("includes/foot.php");
?>
