<?php
//@type: F
//@desc: Chowañce
/**
*   Funkcje pliku:
*   Polana chowancow
*
*   @name                 : core.php                            
*   @copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : thindil <thindil@users.sourceforge.net>
*   @version              : 0.7 beta
*   @since                : 29.12.2004
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

$title = "Polana Chowancow";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta' && $player -> location != 'Imnescar' && $player -> location != 'Iriaebor') {
	error ("Zapomnij o tym");
}*/

		if ($player -> przemiana > 0) {

	error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 

		}

//przypisanie zmiennych
		$smarty -> assign(array("Gains" => '', "Info" => '', "Link" => ''));

if ($player -> corepass != 'Y') {
	if ($player -> gold < 500) {
		error ("<br>Licencja kosztuje 500 sztuk zlota - ktorych akurat nie masz przy sobie. Prosze, wroc kiedy bedziesz mial odpowiednia sume.");
	} else {
		if (isset ($_GET['answer']) && $_GET['answer'] == 'yes') {
			if ($player -> gold < 500) {
				error ("Nie masz tyle sztuk zlota.");
			} else {
				$player -> gold -= 500;
				$player -> corepass = 'Y';
		//$db -> Execute("UPDATE players SET credits=credits-500 WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET corepass='Y' WHERE id=".$player -> id);
		error ("Swietnie - masz juz Licencje na Chowanca. Kliknij <a href=\"core.php\">tutaj</a> aby kontynuowac.",'done');
			}
		}
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'mycores') {
	if (!isset($_GET['id'])) {
		$core = $db -> Execute("SELECT id, name, active FROM core WHERE owner=".$player -> id);
		$arrid = array();
		$arrname = array();
		$arractiv = array();
		$i = 0;
		while (!$core -> EOF) {
			$arrid[$i] = $core -> fields['id'];
			$arrname[$i] = $core -> fields['name'];
			if ($core -> fields['active'] == 'T') {
				$arractiv[$i] = '(Aktywny)';
			} else {
				$arractiv[$i] = '';
			}
			$i = $i + 1;
			$core -> MoveNext();
		}
		$core -> Close();
		$smarty -> assign ( array("Name" => $arrname, "Coreid1" => $arrid, "Activ" => $arractiv));
	} else {
		$coreinfo = $db -> Execute("SELECT * FROM core WHERE id=".$_GET['id']);
		if ($coreinfo -> fields['type'] == 'Plant') {
			$typ = 'Lesny';
		}
		if ($coreinfo -> fields['type'] == 'Aqua') {
			$typ = 'Wodny';
		}
		if ($coreinfo -> fields['type'] == 'Material') {
			$typ = 'Gorski';
		}
		if ($coreinfo -> fields['type'] == 'Element') {
			$typ = 'Polny';
		}
		if ($coreinfo -> fields['type'] == 'Alien') {
			$typ = 'Pustynny';
		}
		if ($coreinfo -> fields['type'] == 'Ancient') {
			$typ = 'Magiczny';
		}
		if ($coreinfo -> fields['status'] == 'Alive') {
			$status = 'Zywy';
		}
		if ($coreinfo -> fields['status'] == 'Dead') {
			$status = 'Martwy';
		}
		if (!$coreinfo -> fields['id']) {
			error ("Nie ma chowanca.");
		} else {
			if ($coreinfo -> fields['owner'] != $player -> id) {
				error ("To nie twoj chowaniec!");
			} else {
				$smarty -> assign ( array("Id" => $coreinfo -> fields['id'], "Name" => $coreinfo -> fields['name'], "Type" => $typ, "Stat" => $status, "Power" => $coreinfo -> fields['power'], "Defense" => $coreinfo -> fields['defense'], "Library" => $coreinfo -> fields['ref_id']));
				if ($coreinfo -> fields['active'] == 'N') {
					$smarty -> assign ("Link", "(<a href=core.php?view=mycores&activate=".$coreinfo -> fields['id'].">Aktywuj</a>)");
				}
				if ($coreinfo -> fields['active'] == 'T') {
					$smarty -> assign ("Link", "(<a href=core.php?view=mycores&dezaktywuj=".$coreinfo -> fields['id'].">Dezaktywuj</a>)");
				}
			}
		}
		$coreinfo -> Close();
	}
	if (isset($_GET['activate'])) {
		$active = $db -> Execute("SELECT id, owner, name FROM core WHERE id=".$_GET['activate']);
		if ($active -> fields['owner'] != $player -> id) {
			error ("Nie posiadasz tego chowanca.");
		} else {
			$db -> Execute("UPDATE core SET active='N' WHERE owner=".$player -> id);
			$db -> Execute("UPDATE core SET active='T' WHERE id=".$_GET['activate']);
			error ("Aktywowales swojego <b>".$active -> fields['name']." Chowanca</b> (<a href=core.php?view=mycores>odswiez</a>).");
		}
	}
	if (isset($_GET['dezaktywuj'])) {
		$dez = $db -> Execute("SELECT id, owner, name FROM core WHERE id=".$_GET['dezaktywuj']);
		if ($dez -> fields['owner'] != $player -> id) {
			error ("Nie posiadasz tego chowanca.");
		} else {
			$db -> Execute("UPDATE core SET active='N' WHERE id=".$dez -> fields['id']);
			error ("Dezaktywowales swojego <b>".$dez -> fields['name']." Chowanca</b> (<a href=core.php?view=mycores>odswiez</a>).");
		}
	}
	if (isset($_GET['release'])) {
		$rel = $db -> Execute("SELECT id, owner, name FROM core WHERE id=".$_GET['release']);
		if ($rel -> fields['owner'] != $player -> id) {
			error ("Nie posiadasz tego chowanca.");
		} else {
			$db -> Execute("DELETE FROM core WHERE id=".$rel -> fields['id']);
			error ("Uwolniles swojego <b>".$rel -> fields['name']." Chowanca</b> (<a href=core.php?view=mycores>odswiez</a>).");
		}
	}
	// przekazywanie chowanca innemu graczowi
			if (isset($_GET['give'])) {
		$rel = $db -> Execute("SELECT id, owner, name FROM core WHERE id=".$_GET['give']);
		if ($rel -> fields['owner'] != $player -> id) {
			error ("Nie posiadasz tego chowanca.");
		} else {
			$smarty -> assign ( array("Id" => $_GET['give'], "Name" => $rel -> fields['name']));
			if (!isset($_GET['step'])) {
				$_GET['step'] = '';
			}
			if ($_GET['step'] == 'give') {
				if (!ereg("^[1-9][0-9]*$", $_POST['gid'])) {
					error ("Zapomnij o tym!");
				}
				if ($_POST['gid'] == $player -> id) {
					error ("Nie mozesz przekazac chowanca samemu sobie!");
				}
				$dotowany = $db -> Execute("SELECT id FROM players WHERE id=".$_POST['gid']);
				if (!$dotowany -> fields['id']) {
					error ("Nie ma takiego gracza!");
				}
				$dotowany -> Close();
				$db -> Execute("UPDATE core SET owner=".$_POST['gid']." WHERE id=".$rel -> fields['id']) or error ("blad przy zapisie!");
				$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$_POST['gid'].",'Gracz <b><a href=view.php?view=".$player -> id.">".$player -> user."</a> ID:".$player -> id."</b>, przekazal ci Chowanca ".$rel -> fields['name'].".','".$newdate."')");
				error ("Przekazales swojego <b>".$rel -> fields['name']." Chowanca</b> graczowi o ID: ".$_POST['gid']." (<a href=core.php?view=mycores>odswiez</a>).");
			}
		}
			}
}

if (isset ($_GET['view']) && $_GET['view'] == 'library') {
	if (!isset($_GET['id'])) {
		$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id." AND type='Secret'");
		$numys = $query -> RecordCount();
		$query -> Close();
		$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id." AND type='Hybrid'");
		$numyh = $query -> RecordCount();
		$query -> Close();
		$query = $db -> Execute("SELECT id FROM cores WHERE type!='Secret' AND type!='Hybrid'");
		$numcores = $query -> RecordCount();
		$query -> Close();
		$tnumc = ($numcores + $numys + $numyh);
		$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id);
		$yourc = $query -> RecordCount();
		$query -> Close();
		$cr = $db -> Execute("SELECT * FROM cores WHERE type!='Hybrid' AND type!='Secret'");
		$arrlink = array();
		$i = 0;
		while (!$cr -> EOF) {
			$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id." AND name='".$cr -> fields['name']."'");
			$yh = $query -> RecordCount();
			$query -> Close();
			if ($cr -> fields['type'] == 'Plant') {
				$typ = 'Lesny';
			}
			if ($cr -> fields['type'] == 'Aqua') {
				$typ = 'Wodny';
			}
			if ($cr -> fields['type'] == 'Material') {
				$typ = 'Gorski';
			}
			if ($cr -> fields['type'] == 'Element') {
				$typ = 'Polny';
			}
			if ($cr -> fields['type'] == 'Alien') {
				$typ = 'Pustynny';
			}
			if ($cr -> fields['type'] == 'Ancient') {
				$typ = 'Magiczny';
			}
			if ($yh > 0) {
				$arrlink[$i] = "<li><a href=core.php?view=library&id=".$cr -> fields['id'].">".$cr -> fields['name']."</a> (".$typ.") (posiadane: ".$yh.")";
			} else {
				$arrlink[$i] = "<li>? (?)";
			}
			$i = $i + 1;
			$cr -> MoveNext();
		}
		$cr -> Close();
		$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id." AND type='Hybrid'");
		$yhc = $query -> RecordCount();
		$query -> Close();
		if ($yhc > 0) {
			$arrlink1 = array();
			$i = 0;
			$cr = $db -> Execute("SELECT * FROM cores WHERE type='Hybrid'");
			while (!$cr -> EOF) {
				$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id." AND name='".$cr -> fields['name']."'");
				$yh = $query -> RecordCount();
				$query -> Close();
				if ($yh > 0) {
					$arrlink1[$i] = "<li><a href=core.php?view=library&id=".$cr -> fields['id'].">".$cr -> fields['name']."</a> (".$cr -> fields['type'].") (posiadane: ".$yh.")";
				} else {
					$arrlink1[$i] = "<li>? (?)";
				}
				$i = $i + 1;
				$cr -> MoveNext();
			}
			$cr -> Close();
		}
		$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id." AND type='Secret'");
		$ysc = $query -> RecordCount();
		$query -> Close();
		if ($ysc > 0) {
			$arrlink2 = array();
			$i = 0;
			$cr = $db -> Execute("SELECT * FROM cores WHERE type='Secret'");
			while (!$cr -> EOF) {
				$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id." AND name='".$cr -> fields['name']."'");
				$yh = $query -> RecordCount();
				$query -> Close();
				if ($yh > 0) {
					$arrlink2[$i] = "<li><a href=core.php?view=library&id=".$cr -> fields['id'].">".$cr -> fields['name']."</a> (".$cr -> fields['type'].") (posiadane: ".$yh.")";
				} else {
					$arrlink2[$i] = "<li>? (?)";
				}
				$i = $i + 1;
				$cr -> MoveNext();
			}
			$cr -> Close();
		}
		if (isset($arrlink1)) {
			$smarty -> assign ("Hybridcore1", $arrlink1);
		}
		if (isset($arrlink2)) {
			$smarty -> assign ("Specialcore1", $arrlink2);
		}
		$smarty -> assign ( array("Name" => $player -> user, "Plcores" => $yourc, "Allcores" => $tnumc, "Normalcore" => $arrlink));
	} else {
		if (!ereg("^[1-9][0-9]*$", $_GET['id'])) {
			error ("Zapomnij o tym!");
		}
		$coreinfo = $db -> Execute("SELECT * FROM cores WHERE id=".$_GET['id']);
		if ($coreinfo -> fields['type'] == 'Plant') {
			$typ = 'Lesny';
		}
		if ($coreinfo -> fields['type'] == 'Aqua') {
			$typ = 'Wodny';
		}
		if ($coreinfo -> fields['type'] == 'Material') {
			$typ = 'Gorski';
		}
		if ($coreinfo -> fields['type'] == 'Element') {
			$typ = 'Polny';
		}
		if ($coreinfo -> fields['type'] == 'Alien') {
			$typ = 'Pustynny';
		}
		if ($coreinfo -> fields['type'] == 'Ancient') {
			$typ = 'Magiczny';
		}
		$query = $db -> Execute("SELECT id FROM core WHERE name='".$coreinfo -> fields['name']."' AND owner=".$player -> id);
		$ycore = $query -> RecordCount();
		$query -> Close();
		if ($ycore > 0) {
			$query = $db -> Execute("SELECT id FROM core WHERE name='".$coreinfo -> fields['name']."'");
			$caught = $query -> RecordCount();
			$query -> Close();
			$smarty -> assign ( array ("Id" => $coreinfo -> fields['id'], "Name" => $coreinfo -> fields['name'], "Type" => $typ, "Rarity" => $coreinfo -> fields['rarity'], "Caught" => $caught));
			if (!empty ($coreinfo -> fields['desc'])) {
				$smarty -> assign ("Description", "+ <b>Opis</b><br><br><ul><li>".$coreinfo -> fields['desc']."</li></ul>");
			} else {
				$smarty -> assign("Description", '');
			}
		} else {
			error ("Nie zdobyles tego chowanca.");
		}
		$coreinfo -> Close();
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'arena') {
	if (!isset ($_GET['step']) && !isset($_GET['attack'])) {
		$chowaniec = $db -> Execute("SELECT type FROM core WHERE status='Alive' AND active='T' AND owner=".$player -> id);
		$smarty -> assign ( array ("Forest" => "<li>Arena lesna", "Sea" => "<li>Arena morska", "Mountains" => "<li>Arena gorska", "Plant" => "<li>Arena polna", "Desert" => "<li>Arena pustynna", "Magic" => "<li>Arena magiczna<br><br>"));
		if ($chowaniec -> fields['type'] == 'Plant') {
			$smarty -> assign ("Forest", "<li><a href=core.php?view=arena&step=battles&typ=1>Arena lesna</a>.");
		}
		if ($chowaniec -> fields['type'] == 'Aqua') {
			$smarty -> assign ("Sea", "<li><a href=core.php?view=arena&step=battles&typ=2>Arena morska</a>");
		}
		if ($chowaniec -> fields['type'] == 'Material') {
			$smarty -> assign ("Mountains", "<li><a href=core.php?view=arena&step=battles&typ=3>Arena gorska</a>");
		}
		if ($chowaniec -> fields['type'] == 'Element') {
			$smarty -> assign ("Plant", "<li><a href=core.php?view=arena&step=battles&typ=4>Arena polna</a>");
		}
		if ($chowaniec -> fields['type'] == 'Alien') {
			$smarty -> assign ("Desert", "<li><a href=core.php?view=arena&step=battles&typ=5>Arena pustynna</a>");
		}
		if ($chowaniec -> fields['type'] == 'Ancient') {
			$smarty -> assign ("Magic", "<li><a href=core.php?view=arena&step=battles&typ=6>Arena magiczna</a><br><br>");
		}
		$chowaniec -> Close();
	}
	if (isset ($_GET['step']) && $_GET['step'] == 'battles') {
		$chowaniec = $db -> Execute("SELECT type, name FROM core WHERE status='Alive' AND active='T' AND owner=".$player -> id);
		if ($_GET['typ'] == '1') {
			$test = 'Plant';
		}
		if ($_GET['typ'] == '2') {
			$test = 'Aqua';
		}
		if ($_GET['typ'] == '3') {
			$test = 'Material';
		}
		if ($_GET['typ'] == '4') {
			$test = 'Element';
		}
		if ($_GET['typ'] == '5') {
			$test = 'Alien';
		}
		if ($_GET['typ'] == '6') {
			$test = 'Ancient';
		}
		if ($chowaniec -> fields['type'] != $test) {
			error ("Zapomnij o tym!");
		}
		$arrlibrary = array();
		$arrname = array();
		$arrowner = array();
		$arrcoreid = array();
		$i = 0;
		$clist = $db -> Execute("SELECT * FROM core WHERE status='Alive' AND active='T' AND owner!=".$player -> id." AND type='".$test."'");
		while (!$clist -> EOF) {
			$arrlibrary[$i] = $clist -> fields['ref_id'];
			$arrname[$i] = $clist -> fields['name'];
			$arrowner[$i] = $clist -> fields['owner'];
			$arrcoreid[$i] = $clist -> fields['id'];
			$clist -> MoveNext();
			$i = $i + 1;
		}
		$clist -> Close();
		$smarty -> assign ( array("Library" => $arrlibrary, "Corename" => $arrname, "Owner" => $arrowner, "Attackid" => $arrcoreid));
	}
	if (isset($_GET['attack'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['attack'])) {
			error ("Zapomnij o tym!");
		}
		if ($player -> energy < 0.2) {
			error ("Nie masz tyle energii!");
		} else {
			$mycore = $db -> Execute("SELECT * FROM core WHERE active='T' AND owner=".$player -> id);
			if (!$mycore -> fields['id']) {
				error ("Nie masz aktywnych chowancow!");
			} else {
				if ($mycore -> fields['status'] == 'Dead') {
					error ("Twoj aktywny chowaniec jest martwy!");
				} else {
					$enemy = $db -> Execute("SELECT * FROM core WHERE id=".$_GET['attack']);
					if (!$enemy -> fields['id']) {
						error ("Nie ma takiego chowanca!");
					}
					$query = $db -> Execute("SELECT * FROM core WHERE owner=".$player -> id." AND id=".$enemy -> fields['id']);
					$numy = $query -> RecordCount();
					$query -> Close();
					if ($numy > 0) {
						error ("Nie mozesz walczyc z wlasnym Chowancem!");
					} else {
						if ($enemy -> fields['status'] == 'Dead') {
							error ("Ten chowaniec jest martwy.");
						} else {
							if  ($mycore -> fields['type'] != $enemy -> fields['type']) {
								error ("Nie mozesz walczyc chowancem ".$mycore -> fields['name']." z chowancem ".$enemy -> fields['name']." poniewaz sa roznych typow");
							}
							if ($enemy -> fields['active'] != 'T') {
								error ("Nie mozesz walczyc z chowancem ".$enemy -> fields['name']." poniewaz nie jest on aktywny!");
							}
							$yattack = ($mycore -> fields['power'] - $enemy -> fields['defense']);
							if ($yattack <= 0) {
								$yattack = 0;
							}
							$eattack = ($enemy -> fields['power'] - $mycore -> fields['defense']);
							if ($eattack <= 0) {
								$eattack = 0;
							}
							$smarty -> assign ( array("Ycorename" => $mycore -> fields['name'], "Ecoreowner" => $enemy -> fields['owner'], "Ecorename" => $enemy -> fields['name'], "Ecoreattack" => $eattack, "Ycoreattack" => $yattack));
							if ($eattack == $yattack) {
								$smarty -> assign ("Result", "Bitwa nie <b>rozstrzygnieta</b>.");
							} else {
								if ($eattack > $yattack) {
									$victor = $db -> Execute("SELECT user, id FROM players WHERE id=".$enemy -> fields['owner']);
									$loser = $db -> Execute("SELECT user, id FROM players WHERE id=".$player -> id);
								} else {
									$victor = $db -> Execute("SELECT user, id FROM players WHERE id=".$player -> id);
									$loser = $db -> Execute("SELECT user, id FROM players WHERE id=".$enemy -> fields['owner']);
								}
								$smarty -> assign ("Result", $victor -> fields['user']." Chowaniec pokonal ".$loser -> fields['user']." Chowanca.<br>");
								if ($victor -> fields['user'] == $player -> user) {
									$smarty -> assign ("Info", "Twoj <b>Chowaniec ".$mycore -> fields['name']."</b> pokonal  ".$loser -> fields['user']." <b>".$enemy -> fields['name']." Chowanca</b>!<br><br>");
									$db -> Execute("UPDATE core SET status='Dead' WHERE id=".$enemy -> fields['id']);
									$gain = ceil(($enemy -> fields['power'] + $enemy -> fields['defense']) * 10);
								} else {
									$smarty -> assign ("Info", "Twoj <b>Chowaniec ".$mycore -> fields['name']."</b> zostal pokonany przez ".$victor -> fields['user']." <b>".$enemy -> fields['name']." Chowanca</b>!<br><br>");
									$db -> Execute("UPDATE core SET status='Dead' WHERE id=".$mycore -> fields['id']);
									$gain = ceil(($mycore -> fields['power'] + $mycore -> fields['defense']) * 10);
								}
								$crgain = rand(0,$gain);
								$mith = ceil($gain / 200);
								$plgain = rand(0,$mith);
								$smarty -> assign ("Gains", $victor -> fields['user']." zdobywa <b>".$crgain."</b> sztuk zlota za bitwe oraz <b>".$plgain."</b> mithrilu!");
				$db -> Execute("UPDATE players SET platinum=platinum+".$plgain.",credits=credits+".$crgain." WHERE id=".$victor -> fields['id']);
				//$player -> mithril += $plgain;
				//$player -> gold += $crgain;
				$player -> energy -= 0.2;
				//$db -> Execute("UPDATE players SET credits=credits+".$crgain." WHERE id=".$victor -> fields['id']);
				//$db -> Execute("UPDATE players SET energy=energy-0.2 WHERE id=".$player -> id);
				$victor -> Close();
				$loser -> Close();
							}
						}
					}
					$enemy -> Close();
				}
			}
			$mycore -> Close();
		}
	}
	if (isset ($_GET['step']) && $_GET['step'] == 'heal') {
		$deadcore = $db -> Execute("SELECT power, defense FROM core WHERE owner=".$player -> id." AND status='Dead'");
		$numdead = $deadcore -> RecordCount();
		$cost = 0;
		while (!$deadcore -> EOF) {
			$cost = $cost + (($deadcore -> fields['power'] + $deadcore -> fields['defense']) * 5);
			$deadcore -> MoveNext();
		}
		$deadcore -> Close();
		$smarty -> assign ( array("Cost" => $cost, "Number" => $numdead));
		if (isset ($_GET['answer']) && $_GET['answer'] == 'yes') {
			if ($player -> credits < $cost) {
				error ("Nie masz tyle sztuk zlota.");
			} else {
				$db -> Execute("UPDATE core SET status='Alive' WHERE owner=".$player -> id." AND status='Dead'");
			//$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
			$player -> gold -= $cost;
			error ("Wszystkie twoje chowance zostaly wyleczone.");
			}
		}
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'train') {
	$smarty -> assign ("Trains", $player -> trains);
	$arrname = array();
	$arrcoreid = array();
	$i = 0;
	$myc = $db -> Execute("SELECT id, name FROM core WHERE owner=".$player -> id);
	while (!$myc -> EOF) {
		$arrname[$i] = $myc -> fields['name'];
		$arrcoreid[$i] = $myc -> fields['id'];
		$myc -> MoveNext();
		$i = $i + 1;
	}
	$myc -> Close();
	$smarty -> assign ( array("Corename" => $arrname, "Coreid1" => $arrcoreid));
	if (isset ($_GET['step']) && $_GET['step'] == 'train') {
		if (!ereg("^[1-9][0-9]*$", $_POST['train_core']) || !isset($_POST['train_core'])) {
			error ("Zapomnij o tym!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST["reps"])) {
			error ("Zapomnij o tym");
		}
		if ($_POST['reps'] <= 0) {
			error ("Nie podales ile razy.");
		} else {
			if ($_POST['technique'] != 'power' && $_POST['technique'] != 'defense') {
				error ("Zapomnij o tym.");
			}
			if ($player -> hp == 0) {
				error ("Nie mozesz trenowac chowanca, poniewaz jestes martwy!");
			}
			if ($_POST['reps'] > $player -> trains) {
				error ("Nie masz wystarczajaco duzo punktow treningowych.");
			} else {
				$gain = ($_POST['reps'] * .125);
				SqlExec("UPDATE core SET ".$_POST['technique']."=".$_POST['technique']."+".$gain." WHERE id=".$_POST['train_core']);
			//$db -> Execute("UPDATE players SET trains=trains-".$_POST['reps']." WHERE id=".$player -> id) or error ("stage 2 failed<br>");
			$player -> trains -= $_POST['reps'];
			if ($_POST['technique'] == 'power') {
				$cecha = 'Sily';
			}
			if ($_POST['technique'] == 'defense') {
				$cecha = 'Obrony';
			}
			error ("Trenowales swojego Chowanca <b>".$_POST['reps']."</b> razy, zuzywajac <b>".$_POST['reps']."</b> punktow treningowych. Dostaje za to <b>".$gain." ".$cecha."</b>.");
			}
		}
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'market') {
	if (isset ($_GET['step']) && $_GET['step'] == 'market') {
		$market = $db -> Execute("SELECT * FROM core_market ORDER BY id DESC");
		$arrlink = array ();
		$i = 0;
		while (!$market -> EOF) {
			if ($market -> fields['seller'] == $player -> id) {
				$arrlink[$i] = "<tr><td>".$market -> fields['name']."</td><td>Moj</td><td>".$market -> fields['cost']." sz</td><td><a href=core.php?view=market&step=market&remove=".$market -> fields['id'].">Usun</a></td></tr>";
			} else {
				$arrlink[$i] = "<tr><td>".$market -> fields['name']."</td><td><a href=view.php?view=".$market -> fields['seller'].">".$market -> fields['seller']."</a></td><td>".$market -> fields['cost']." sz</td><td><a href=core.php?view=market&step=market&buy=".$market -> fields['id'].">Kup</a></td></tr>";
			}
			$market -> MoveNext();
			$i = $i + 1;
		}
		$market -> Close();
		$smarty -> assign ("Link", $arrlink);
		if (isset($_GET['remove'])) {
			$rem = $db -> Execute("SELECT * FROM core_market WHERE id=".$_GET['remove']);
			if ($rem -> fields['seller'] != $player -> id) {
				error ("To nie twoja oferta.");
			} else {
				$db -> Execute("INSERT core (owner,name,type,power,defense) VALUES(".$player -> id.",'".$rem -> fields['name']."','".$rem -> fields['type']."',".$rem -> fields['power'].",".$rem -> fields['defense'].")") or error("Could not get back.");
				$db -> Execute("DELETE FROM core_market WHERE id=".$rem -> fields['id']);
				error ("Usunales oferte. Twoj Chowaniec <b>".$rem -> fields['name']."</b> wrocil do ciebie.");
			}
		}
		if (isset($_GET['buy'])) {
			if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
				error ("Zapomnij o tym!");
			}
			$buy = $db -> Execute("SELECT * FROM core_market WHERE id=".$_GET['buy']);
			if ($buy -> fields['seller'] == $player -> id) {
				error ("Nie mozesz kupic swojego Chowanca.");
			} else {
				if ($player -> credits < $buy -> fields['cost']) {
					error ("Nie stac cie.");
				} else {
					$db -> Execute("INSERT INTO core (owner,name,type,power,defense) VALUES(".$player -> id.",'".$buy -> fields['name']."','".$buy -> fields['type']."',".$buy -> fields['power'].",".$buy -> fields['defense'].")") or error("Could not get back.");
			//$db -> Execute("UPDATE players SET credits=credits-".$buy -> fields['cost']." WHERE id=".$player -> id);
			$player -> gold -= $buy -> fields['cost'];
			$db -> Execute("UPDATE resources SET bank=bank+".$buy -> fields['cost']." WHERE id=".$buy -> fields['seller']);
			PutSignal( $buy -> fields['seller'], 'res' );
			//
					//
					//
					//
			//                                                       ^
			//          UWAGA !!!!!! NIESPOJNOSC SUROWCOW NASTAPI !! |
					//
					//
					//
					//
					$db -> Execute("DELETE FROM core_market WHERE id=".$buy -> fields['id']);
			$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$buy -> fields['seller'].",'<a href=view.php?view=".$player -> id.">".$player -> user."</a> kupil twojego ".$buy -> fields['name']." Chowanca za ".$buy -> fields['cost']." sztuk zlota.','".$newdate."')");
			error ("Kupiles <b>Chowanca ".$buy -> fields['name']."</b> za <b>".$buy -> fields['cost']."</b> sztuk zlota.");
				}
			}
		}
	}
	if (isset ($_GET['step']) && $_GET['step'] == 'add') {
		$arrcoreid = array();
		$arrname = array();
		$i = 0;
		$mc = $db -> Execute("SELECT * FROM core WHERE owner=".$player -> id);
		while (!$mc -> EOF) {
			$arrcoreid[$i] = $mc -> fields['id'];
			$arrname[$i] = $mc -> fields['name'];
			$mc -> MoveNext();
			$i = $i + 1;
		}
		$mc -> Close();
		$smarty -> assign ( array("Coreid1" => $arrcoreid, "Corename" => $arrname));
		if (isset ($_GET['action']) && $_GET['action'] == 'add') {
			if (!ereg("^[1-9][0-9]*$", $_POST['cost'])) {
				error ("Zapomnij o tym!");
			}
			if ($_POST['cost'] <= 0) {
				error ("Nie ma za darmo.");
			} else {
				$query = $db -> Execute("SELECT id FROM core_market WHERE seller=".$player -> id);
				$numon = $query -> RecordCount();
				$query -> Close();
				if ($numon >= 5) {
					error ("Mozesz maksymalnie wystawic 5 ofert na raz!");
				} else {
					$sc = $db -> Execute("SELECT * FROM core WHERE id=".$_POST['add_core']);
					if ($sc -> fields['owner'] != $player -> id) {
						error ("Nie mozesz sprzedac cudzego chowanca!");
					}
					$db -> Execute("INSERT INTO core_market (seller, cost, name, type, power, defense) VALUES(".$player -> id.",".$_POST['cost'].",'".$sc -> fields['name']."','".$sc -> fields['type']."',".$sc -> fields['power'].",".$sc -> fields['defense'].")");
					$db -> Execute("DELETE FROM core WHERE id=".$_POST['add_core']);
					error ("Dodales swojego <b>".$sc -> fields['name']." Chowanca</b> do sklepu za <b>".$_POST['cost']."</b> sztuk zlota.");
				}
			}
		}
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'explore') {
	if (isset ($_GET['next']) && $_GET['next'] == 'yes') {
		if (!ereg("^[1-9][0-9]*$", $_POST['repeat'])) {
			error ("Zapomnij o tym");
		}
		$rep = ($_POST['repeat'] * 0.1);
		if ($player -> energy < $rep) {
			error ("Nie masz wystarczajaco duzo energii aby szukac. <a href=core.php?view=explore>Wroc</a>");
		}
		if ($player -> hp == 0) {
			error ("Nie mozesz wyruszyc na poszukiwanie poniewaz jestes martwy! <a href=core.php?view=explore>Wroc</a>");
		}
		if ($_POST['explore'] == 'Forest') {
			$req = 0;
		} elseif ($_POST['explore'] == 'Ocean') {
			$req = 50;
		} elseif ($_POST['explore'] == 'Mountains') {
			$req = 100;
		} elseif ($_POST['explore'] == 'Plains') {
			$req = 150;
		} elseif ($_POST['explore'] == 'Desert') {
			$req = 200;
		} elseif ($_POST['explore'] == 'Magic') {
			$req = 250;
		} else {
			error ("Nie ma takiego regionu!");
		}
		if ($player -> mithril < $req) {
			error ("Nie masz tyle mithrilu. <a href=core.php?view=explore>Wroc</a>");
		}
		if ($_POST['explore'] == 'Forest') {
			$type = 'Plant';
			$common[1] = 1;
			$common[2] = 2;
			$common[3] = 3;
			$uncommon = 4;
			$rare1 = 5;
			$obszar = 'Las';
		}
		if ($_POST['explore'] == 'Ocean') {
			$type = 'Aqua';
			$common[1] = 6;
			$common[2] = 7;
			$common[3] = 8;
			$uncommon = 9;
			$rare1 = 10;
			$obszar = 'Ocean';
		}
		if ($_POST['explore'] == 'Mountains') {
			$type = 'Material';
			$common[1] = 11;
			$common[2] = 12;
			$common[3] = 13;
			$uncommon = 14;
			$rare1 = 15;
			$obszar = 'Gory';
		}
		if ($_POST['explore'] == 'Plains') {
			$type = 'Element';
			$common[1] = 16;
			$common[2] =17;
			$common[3] = 18;
			$uncommon =19;
			$rare1 = 20;
			$obszar = 'Laki';
		}
		if ($_POST['explore'] == 'Desert') {
			$type = 'Alien';
			$common[1] = 21;
			$common[2] = 22;
			$common[3] = 23;
			$uncommon = 24;
			$rare1 = 25;
			$obszar = 'Pustynia';
		}
		if ($_POST['explore'] == 'Magic') {
			$type = 'Ancient';
			$common[1] = 26;
			$common[2] = 27;
			$common[3] = 28;
			$uncommon = 29;
			$rare1 = 30;
			$obszar = 'Inny wymiar';
		}
		$arrfind1 = array();
		$arrfind2 = array();
		$arrfind3 = array();
		$j = 0;
		for ($i=0;$i<=$_POST['repeat'];$i++) {
			$rare = rand(1,3);
			if ($rare == 1) {
				$odds = rand(1,50);
				$chance = rand(1,50);
				if ($chance == $odds) {
					$core = rand(1,3);
					$core = $common[$core];
					$coreinfo = $db -> Execute("SELECT * FROM cores WHERE id=".$core);
					if ($coreinfo -> fields['type'] == 'Plant') {
						$typ = 'Lesny';
						$mith = 0;
					}
					if ($coreinfo -> fields['type'] == 'Aqua') {
						$typ = 'Wodny';
						$mith = 50;
					}
					if ($coreinfo -> fields['type'] == 'Material') {
						$typ = 'Gorski';
						$mith = 100;
					}
					if ($coreinfo -> fields['type'] == 'Element') {
						$typ = 'Polny';
						$mith = 150;
					}
					if ($coreinfo -> fields['type'] == 'Alien') {
						$typ = 'Pustynny';
						$mith = 200;
					}
					if ($coreinfo -> fields['type'] == 'Ancient') {
						$typ = 'Magiczny';
						$mith = 250;
					}
					$player -> mithril = ($player -> mithril - $mith);
					$arrfind1[$j] = "Znalazles <b>".$coreinfo -> fields['name']." Chowanca</b>! Jest on rodzaju <b>".$typ."</b>.";
					if ($coreinfo -> fields['rarity'] == 1) {
						$arrfind2[$j] = "<br>Ten Chowaniec jest <b>czesto spotykany</b>.";
					}
					if ($coreinfo -> fields['rarity'] == 2) {
						$arrfind2[$j] = "<br>Ten Chowaniec jest <b>rzadki</b>.";
					}
					if ($coreinfo -> fields['rarity'] == 3) {
						$arrfind2[$j] = "<br>Ten Chowaniec jest <b>bardzo rzadki</b>.";
					}
					$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id." AND name='".$coreinfo -> fields['name']."'");
					$corenum = $query -> RecordCount();
					$query -> Close();
					if ($corenum <= 0) {
						$arrfind3[$j] = "<br>To jest twoj pierwszy Chowaniec tego typu!<br>";
					} else {
						$arrfind3[$j] = "<br>Masz juz takiego Chowanca.<br>";
					}
					$j = $j + 1;
			//$db -> Execute("UPDATE players SET platinum=platinum-".$mith." WHERE id=".$player -> id);
			$player -> mithril -= $mith;
			$db -> Execute("INSERT INTO core (owner, name, type, ref_id, power, defense) VALUES(".$player -> id.",'".$coreinfo -> fields['name']."','".$coreinfo -> fields['type']."',".$core.",".$coreinfo -> fields['power'].",".$coreinfo -> fields['defense'].")") or error("Could not add Core.");
			$coreinfo -> Close();
				}
			}
			if ($rare == 2) {
				$odds = rand(1,250);
				$chance = rand(1,250);
				if ($chance == $odds) {
					$core = $uncommon;
					$coreinfo = $db -> Execute("SELECT * FROM cores WHERE id=".$core);
					if ($coreinfo -> fields['type'] == 'Plant') {
						$typ = 'Lesny';
						$mith = 0;
					}
					if ($coreinfo -> fields['type'] == 'Aqua') {
						$typ = 'Wodny';
						$mith = 50;
					}
					if ($coreinfo -> fields['type'] == 'Material') {
						$typ = 'Gorski';
						$mith = 100;
					}
					if ($coreinfo -> fields['type'] == 'Element') {
						$typ = 'Polny';
						$mith = 150;
					}
					if ($coreinfo -> fields['type'] == 'Alien') {
						$typ = 'Pustynny';
						$mith = 200;
					}
					if ($coreinfo -> fields['type'] == 'Ancient') {
						$typ = 'Magiczny';
						$mith = 250;
					}
					$player -> mithril = ($player -> mithril - $mith);
					$arrfind1[$j] = "Znalazles <b>".$coreinfo -> fields['name']." Chowanca</b>! Jest on rodzaju <b>".$typ."</b>.";
					if ($coreinfo -> fields['rarity'] == 1) {
						$arrfind2[$j] = "<br>Ten Chowaniec jest <b>czesto spotykany</b>.";
					}
					if ($coreinfo -> fields['rarity'] == 2) {
						$arrfind2[$j] = "<br>Ten Chowaniec jest <b>rzadki</b>.";
					}
					if ($coreinfo -> fields['rarity'] == 3) {
						$arrfind2[$j] = "<br>Ten Chowaniec jest <b>bardzo rzadki</b>.";
					}
					$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id." AND name='".$coreinfo -> fields['name']."'");
					$corenum = $query -> RecordCount();
					$query -> Close();
					if ($corenum <= 0) {
						$arrfind3[$j] = "<br>To jest twoj pierwszy Chowaniec tego typu!<br>";
					} else {
						$arrfind3[$j] = "<br>Masz juz takiego Chowanca.<br>";
					}
					$j = $j + 1;
			//$db -> Execute("UPDATE players SET platinum=platinum-".$mith." WHERE id=".$player -> id);
			$player -> mithril -= $mith;
			$db -> Execute("INSERT INTO core (owner, name, type, ref_id, power, defense) VALUES(".$player -> id.",'".$coreinfo -> fields['name']."','".$coreinfo -> fields['type']."',".$core.",".$coreinfo -> fields['power'].",".$coreinfo -> fields['defense'].")") or error("Could not add Core.");
			$coreinfo -> Close();
				}
			}
			if ($rare == 3) {
				$odds = rand(1,500);
				$chance = rand(1,500);
				if ($chance == $odds) {
					$core = $rare1;
					$coreinfo = $db -> Execute("SELECT * FROM cores WHERE id=".$core);
					if ($coreinfo -> fields['type'] == 'Plant') {
						$typ = 'Lesny';
						$mith = 0;
					}
					if ($coreinfo -> fields['type'] == 'Aqua') {
						$typ = 'Wodny';
						$mith = 50;
					}
					if ($coreinfo -> fields['type'] == 'Material') {
						$typ = 'Gorski';
						$mith = 100;
					}
					if ($coreinfo -> fields['type'] == 'Element') {
						$typ = 'Polny';
						$mith = 150;
					}
					if ($coreinfo -> fields['type'] == 'Alien') {
						$typ = 'Pustynny';
						$mith = 200;
					}
					if ($coreinfo -> fields['type'] == 'Ancient') {
						$typ = 'Magiczny';
						$mith = 250;
					}
					$player -> mithril = ($player -> mithril - $mith);
					$arrfind1[$j] = "Znalazles <b>".$coreinfo -> fields['name']." Chowanca</b>! Jest on rodzaju <b>".$typ."</b>.";
					if ($coreinfo -> fields['rarity'] == 1) {
						$arrfind2[$j] = "<br>Ten Chowaniec jest <b>czesto spotykany</b>.";
					}
					if ($coreinfo -> fields['rarity'] == 2) {
						$arrfind2[$j] = "<br>Ten Chowaniec jest <b>rzadki</b>.";
					}
					if ($coreinfo -> fields['rarity'] == 3) {
						$arrfind2[$j] = "<br>Ten Chowaniec jest <b>bardzo rzadki</b>.";
					}
					$query = $db -> Execute("SELECT id FROM core WHERE owner=".$player -> id." AND name='".$coreinfo -> fields['name']."'");
					$corenum = $query -> RecordCount();
					$query -> Close();
					if ($corenum <= 0) {
						$arrfind3[$j] = "<br>To jest twoj pierwszy Chowaniec tego typu!<br>";
					} else {
						$arrfind3[$j] = "<br>Masz juz takiego Chowanca.<br>";
					}
					$j = $j + 1;
			//$db -> Execute("UPDATE players SET platinum=platinum-".$mith." WHERE id=".$player -> id);
			$player -> mithril -= $mith;
			$db -> Execute("INSERT INTO core (owner, name, type, ref_id, power, defense) VALUES(".$player -> id.",'".$coreinfo -> fields['name']."','".$coreinfo -> fields['type']."',".$core.",".$coreinfo -> fields['power'].",".$coreinfo -> fields['defense'].")") or error("Could not add Core.");
			$coreinfo -> Close();
				}
			}
			if ($player -> mithril < $req) {
				$smarty -> assign ("Message", "Nie masz tyle mithrilu!");
				$smarty -> display ('error1.tpl');
				break;
			}
		}
		$repeat = ($i - 1);
		$lostenergy = ($repeat * 0.1);
			//$db -> Execute("UPDATE players SET energy=energy-".$lostenergy." WHERE id=".$player -> id);
			$player -> energy -= $lostenergy;
			$smarty -> assign ( array("Area" => $obszar, "Find1" => $arrfind1, "Find2" => $arrfind2, "Find3" => $arrfind3, "Repeat" => $repeat));
	}
}

//inicjalizacja zmiennych
		if (!isset($_GET['view'])) {
	$_GET['view'] = '';
		}
		if (!isset($_GET['id'])) {
			$_GET['id'] = '';
		}
		if (!isset($yhc)) {
			$yhc = '';
		}
		if (!isset($ysc)) {
			$ysc = '';
		}
		if (!isset($ycore)) {
			$ycore = '';
		}
		if (!isset($_GET['step'])) {
			$_GET['step'] = '';
		}
		if (!isset($_GET['attack'])) {
			$_GET['attack'] = '';
		}
		if (!isset($_GET['give'])) {
			$_GET['give'] = '';
		}
		if (!isset($_GET['next'])) {
			$_GET['next'] = '';
		}

// przypisanie zmiennych oraz wyswietlenie strony
		$smarty -> assign ( array("Corepass" => $player -> corepass, "View" => $_GET['view'], "Coreid" => $_GET['id'], "Hybridcore" => $yhc,
							"Specialcore" => $ysc, "Yourcore" => $ycore, "Step" => $_GET['step'], "Attack" => $_GET['attack'], "Give" => $_GET['give'],
							"Next" => $_GET['next']));
$smarty -> display ('core.tpl');

require_once("includes/foot.php");
?>
