<?php
//@type: F
//@desc: Klany
/**
*   Funkcje pliku:
*   Klany - zarzadzane nimi, zielnik, skarbiec oraz walki klanow
*
*   @name                 : tribes.php
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : thindil <thindil@users.sourceforge.net>
*   @version              : 0.7 beta
*   @since                : 03.01.2005
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

$title = "Klany";
require_once("includes/head.php");
require_once( "includes/bbcode_profile.php" );

//if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Imnescar' && $player -> location != 'Eshpurta' && $player -> location != 'Proskur' && $player -> location != 'Iriaebor') {
//	error ("Zapomnij o tym");
//}
checklocation($_SERVER['SCRIPT_NAME']);

$mytribe = SqlExec("SELECT * FROM tribes WHERE id=".$player -> tribe_id);

$smarty -> assign(array("Logo" => '',
	"WWW" => '',
	"Message" => '',
	"Message2" => '',
	"Pubmessage" => '',
	"Privmessage" => '',
	"Hospass1" => '',
	"Message1" => '',
	"Step4" => '',
	"New" => '',
	"Perm" => '',
	"Victory" => '',
	"Link" => '',
	"Menu" => '',
	"Empty" => '',
	"Change" => '',
	"Itemid" => '',
	"Perm1" => 0,
	"Perm2" => 0,
	"Perm3" => 0,
	"Perm4" => 0,
	"Perm5" => 0,
	"Perm6" => 0,
	"Perm7" => 0,
	"Perm8" => 0,
	"Perm9" => 0,
	"Perm10" => 0,
	"Perm11" => 0,
	"Rank1" => 0,
	"Rank2" => 0,
	"Rank3" => 0,
	"Rank4" => 0,
	"Rank5" => 0,
	"Rank6" => 0,
	"Rank7" => 0,
	"Rank8" => 0,
	"Rank9" => 0,
	"Rank10" => 0));

// menu glowne
if (!isset ($_GET['view']) && !isset($_GET['join'])) {
	if ($player -> tribe_id) {
	$mytribe = SqlExec("SELECT * FROM tribes WHERE id=".$player -> tribe_id);
	$smarty -> assign ("Mytribe", "<li><a href=tribes.php?view=my>Moj klan</a> (".$mytribe -> fields['name'].")");
	} else {
		$smarty -> assign ("Mytribe", "<li>Moj klan");
	}
	if (!$player -> tribe_id && $player -> credits >= 2500000) {
		$smarty -> assign ("Make", "<li><a href=tribes.php?view=make>Stworz nowy klan</a> (2,500,000 sztuk zlota)");
	} else {
		$smarty -> assign ("Make", "<li>Stworz nowy klan (2,500,000 sztuk zlota)");
	}
}

// lista klanow
if (isset ($_GET['view']) && $_GET['view'] == 'all') {
	$query = SqlExec("SELECT id FROM tribes");
	$numt = $query -> RecordCount();
	$query -> Close();
	if ($numt <= 0) {
		$smarty -> assign ("Text", "<br>Na razie nie ma jakiegokolwiek klanu.");
	} else {
		$smarty -> assign ("Text", "<ul>");
		$tribe = SqlExec("SELECT tribes.id, tribes.name, tribes.owner, players.user FROM tribes JOIN players ON players.id=tribes.owner");
		$arrid = array();
		$arrname = array();
		$arrowner = array();
		$i = 0;
		while (!$tribe -> EOF) {
			$arrid[$i] = $tribe -> fields['id'];
			$arrname[$i] = $tribe -> fields['name'];
			$arrowner[$i] = $tribe -> fields['owner'];
			$arruser[$i] = $tribe -> fields['user'];
			$tribe -> MoveNext();
			$i = $i + 1;
		}
		$tribe -> Close();
		$smarty -> assign ( array("Tribeid" => $arrid, "Name" => $arrname, "Owner" => $arrowner, "User" => $arruser));
	}
}

// informacje o klanie
if (isset ($_GET['view']) && $_GET['view'] == 'view') {
	if (!isset ($_GET['step'])) {
		$tribe = SqlExec("SELECT * FROM tribes WHERE id=".$_GET['id']);
		if (!$tribe -> fields['id']) {
			error ("Nie ten klan.");
		}
		$plik = 'images/tribes/'.$tribe -> fields['logo'];
		$query = SqlExec("SELECT id FROM players WHERE tribe=".$tribe -> fields['id']);
		$memnum = $query -> RecordCount();
		$query -> Close();
		if (is_file($plik)) {
			$smarty -> assign ("Logo", "<center><img src=".$plik."></center><br>");
		}
		$smarty -> assign ( array("Name" => $tribe -> fields['name'], "Owner" => $tribe -> fields['owner'], "Members" => $memnum, "Tribeid" => $tribe -> fields['id'], "Wins"=> $tribe -> fields['wygr'], "Lost" => $tribe -> fields['przeg'], "Pubmessage" => bbcode_profile( $tribe -> fields['public_msg'] ),"Immu"=>$tribe->fields['immu']));
		if ($tribe -> fields['www']) {
			$smarty -> assign ("WWW", "Strona klanu: <a href=http://".$tribe -> fields['www']." target=_blank>".$tribe -> fields['www']."</a><br>");
		}
	$tribe -> Close();
	}
	if (isset ($_GET['step']) && $_GET['step'] == 'members') {
		if (!ereg("^[1-9][0-9]*$", $_GET['tid'])) {
			error ("Zapomnij o tym!");
		}
		$tribename = SqlExec("SELECT name, owner FROM tribes WHERE id=".$_GET['tid']);
		$mem = SqlExec("SELECT id, user, tribe_rank FROM players WHERE tribe=".$_GET['tid']);
		$arrlink = array();
		$i = 0;
		while (!$mem -> EOF) {
			if ($mem -> fields['id'] == $tribename -> fields['owner']) {
				$arrlink[$i] = "- <a href=view.php?view=".$mem -> fields['id'].">".$mem -> fields['user']."</a> (".$mem -> fields['id'].") (".$mem -> fields['tribe_rank'].") (Przywodca)<br>";
			} else {
				$arrlink[$i] = "- <a href=view.php?view=".$mem -> fields['id'].">".$mem -> fields['user']."</a> (".$mem -> fields['id'].") (".$mem -> fields['tribe_rank'].")<br>";
			}
		$mem -> MoveNext();
			$i = $i + 1;
		}
		$mem -> Close();
		$smarty -> assign( array("Name" => $tribename -> fields['name'], "Link" => $arrlink));
		$tribename -> Close();
	}
}

// dolaczanie do klanu
if (isset($_GET['join'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['join'])) {
		error ("Zapomnij o tym!");
	}
	$tribe = SqlExec("SELECT * FROM tribes WHERE id=".$_GET['join']);
	$test = SqlExec("SELECT gracz FROM tribe_oczek WHERE gracz=".$player -> id);
	if (!isset ($_GET['change'])) {
	if ($player -> tribe_id) {
		error ("Jestes w klanie!");
	}
	if ($test -> fields['gracz']) {
			$smarty -> assign ( array("Tribeid" => $_GET['join'], "Playerid" => $test -> fields['gracz'], "Check" => 1));
	} else {
		SqlExec("INSERT INTO tribe_oczek (gracz, klan) VALUES(".$player -> id.",".$tribe -> fields['id'].")") or error("nie moge dodac");
			SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$tribe -> fields['owner'].",'Gracz <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID ".$player -> id." prosi o przyjecie do klanu.','".$newdate."')");
			error ("Wyslales swoje zgloszenie do klanu ".$tribe -> fields['name'].".");
		}
	} else {
	if ($player -> tribe_id) {
		error ("Jestes w klanie!");
	}
		SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$tribe -> fields['owner'].",'Gracz <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID ".$player -> id." prosi o przyjecie do klanu.','".$newdate."')");
	SqlExec("UPDATE tribe_oczek SET klan=".$tribe -> fields['id']." WHERE gracz=".$player -> id);
		error ("Wyslales swoje zgloszenie do klanu ".$tribe -> fields['name'].".");
	}
}

// tworzenie klanu
if (isset ($_GET['view']) && $_GET['view'] == 'make') {
	if ($player -> credits < 2500000) {
		error ("Nie masz tylu sztuk zlota.");
	}
	if ($player -> tribe_id) {
		error ("Jestes juz w klanie.");
	}
	if (isset($_GET['step']) && $_GET['step'] == 'make') {
	if (!$_POST['name']) {
		error ("Podaj nazwe klanu.");
	}
	SqlExec("INSERT INTO tribes (name,owner,started) VALUES('".strip_tags($_POST['name'])."',".$player -> id.",".time().")")or error("shit ! Nie mogê utworzyc klanu");
	//SqlExec("UPDATE players SET credits=credits-2500000 WHERE id=".$player -> id);
	$player -> gold -= 2500000;
	$newt = SqlExec("SELECT id FROM tribes WHERE owner=".$player -> id);
	SqlExec("UPDATE players SET tribe=".$newt -> fields['id']." WHERE id=".$player -> id);
	$newt -> Close();
		error ("Stworzyles nowy klan, <i>".strip_tags($_POST['name'])."</i>.<br>");
	}
}

// menu klanu gracza
if (isset ($_GET['view']) && $_GET['view'] == 'my') {
	if (!$player -> tribe_id) {
		error ("Nie jestes w klanie!");
	}
	
	$perm = SqlExec("SELECT * FROM tribe_perm WHERE tribe=".$mytribe -> fields['id']);
	$smarty -> assign ("Name", $mytribe -> fields['name']);
	if (!isset ($_GET['step'])) {
		$plik = 'images/tribes/'.$mytribe -> fields['logo'];
		if (is_file($plik)) {
			$smarty -> assign ("Logo", "<center><img src=".$plik."></center><br>");
		}
		$query = SqlExec("SELECT id FROM players WHERE tribe=".$mytribe -> fields['id']);
		$memnum = $query -> RecordCount();
		$query -> Close();
		$owner = SqlExec("SELECT id, user FROM players WHERE id=".$mytribe -> fields['owner']);
		$smarty -> assign ( array("Members" => $memnum, "Owner" => $owner -> fields['user'], "Ownerid" => $owner -> fields['id'], "Gold" => $mytribe -> fields['credits'], "Mithril" => $mytribe -> fields['platinum'], "Wins" => $mytribe -> fields['wygr'], "Lost" => $mytribe -> fields['przeg'], "Soldiers" => $mytribe -> fields['zolnierze'], "Forts" => $mytribe -> fields['forty'], "Privmessage" => $mytribe -> fields['private_msg'],"Immu"=>$mytribe->fields['immu']));
		if ($mytribe -> fields['www']) {
			$smarty -> assign ("WWW", "<li>Strona klanu: <a href=http://".$mytribe -> fields['www']." target=_blank>".$mytribe -> fields['www']."</a></li>");
		}
	}

// dotowanie klanu
	if (isset ($_GET['step']) && $_GET['step'] == 'donate') {
		if (isset ($_GET['step2']) && $_GET['step2'] == 'donate') {
			if ($_POST['type'] == 'credits') {
				$dot = 'sztuk zlota';
			}
			if ($_POST['type'] == 'platinum') {
			$dot = 'sztuk mithrilu';
			}
			$types = array( 'credits' => 'gold', 'platinum' => 'mithril' );
				$sur = $types[ $_POST['type'] ];
			if ($_POST['type'] != 'credits' && $_POST['type'] != 'platinum') {
			error ("Zapomnij o tym");
			}
			if ($_POST['amount'] > $player -> $sur || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
				//$smarty -> assign ("Message", "Nie masz wystarczajaco duzo ".$dot.".");
				error( "Nie masz wystarczajaco duzo ".$dot."." );
			} else {
				//SqlExec("UPDATE players SET ".$_POST['type']."=".$_POST['type']."-".$_POST['amount']." WHERE id=".$player -> id);
				
				$player -> $sur -= $_POST['amount'];
				SqlExec("UPDATE tribes set ".$_POST['type']."=".$_POST['type']."+".$_POST['amount']." WHERE id=".$mytribe -> fields['id']);
				$smarty -> assign ("Message", "Dales swojemu klanowi <b>".$_POST['amount']." ".$dot."</b>.");
				SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$mytribe -> fields['owner'].", 'Gracz <a href=view.php?view=".$player -> id.">".$player -> user."</a> ID: ".$player -> id." dodal do skarbca klanu ".$_POST['amount']." ".$dot."','".$newdate."')");
			}
		}
	}
	
// zielnik klanu
	if (isset ($_GET['step']) && $_GET['step'] == 'zielnik') {
	//print_r( $_GET );
		if (!isset ($_GET['step2']) && !isset ($_GET['step3']) && !isset ($_GET['daj']) && !isset ($_GET['step4'])) {
			if ($player -> id == $mytribe -> fields['owner'] || $player -> id == $perm -> fields['herbs']) {
				$smarty -> assign ("Menu", "<tr><td width=100><a href=tribes.php?view=my&step=zielnik&daj=illani><b><u>Illani</u></b></a></td><td width=100><a href=tribes.php?view=my&step=zielnik&daj=illanias><b><u>Illanias</u></b></a></td><td width=100><a href=tribes.php?view=my&step=zielnik&daj=nutari><b><u>Nutari</u></b></a></td><td width=100><a href=tribes.php?view=my&step=zielnik&daj=dynallca><b><u>Dynallca</u></b></a></td></tr>");
			} else {
				$smarty -> assign ("Menu", "<tr><td width=100><b><u>Illani</u></b></td><td width=100><b><u>Illanias</u></b></td><td width=100><b><u>Nutari</u></b</td><td width=100><b><u>Dynallca</u></b</td></tr>");
			}
			$smarty -> assign ( array("Illani" =>  $mytribe -> fields['illani'], "Illanias" => $mytribe -> fields['illanias'], "Nutari" => $mytribe -> fields['nutari'], "Dynallca" => $mytribe -> fields['dynallca']));
		}
		if (isset ($_GET['daj']) && $_GET['daj']) {
			if (!isset ($_GET['step4'])) {
				if ($_GET['daj'] == 'illani') {
					$min1 = "Illani";
				} elseif ($_GET['daj'] == 'illanias') {
					$min1 = "Illanias";
				} elseif ($_GET['daj'] == 'nutari') {
					$min1 = "Nutari";
				} elseif ($_GET['daj'] == 'dynallca') {
					$min1 = "Dynallca";
				} else {
					error ("Zapomnij o tym");
				}
				$smarty -> assign ( array("Name" => $min1, "Itemid" => $_GET['daj']));
			}
			if (isset ($_GET['step4']) && $_GET['step4'] == 'add') {
				if (!ereg("^[1-9][0-9]*$", $_POST['ilosc'])) {
					error ("Zapomnij o tym<br>");
				}
				if (!ereg("^[1-9][0-9]*$", $_POST['did'])) {
					error ("Zapomnij o tym<br>");
				}
				$dtrib = SqlExec("SELECT tribe FROM players WHERE id=".$_POST['did']);
				if ($dtrib -> fields['tribe'] != $mytribe -> fields['id']) {
					error ("Ten gracz nie jest w twoim klanie!");
				}
				$give = $_GET['daj'];
				if ($mytribe -> fields[$give] < $_POST['ilosc']) {
					error ("Klan nie ma takiej ilosci ".$_POST['min']."!");
				}
				//$kop = SqlExec("SELECT * FROM herbs WHERE gracz=".$_POST['did']);
				// (!$kop -> fields['id']) {
				//    SqlExec("INSERT INTO herbs ( gracz, ".$_GET['daj'].") VALUES(".$_POST['did'].",".$_POST['ilosc'].")") or error ("Nie moge dodac");
				//} else {
				SqlExec("UPDATE resources SET ".$_GET['daj']."=".$_GET['daj']."+".$_POST['ilosc']." WHERE id=".$_POST['did']);
				PutSignal( $_POST['did'], 'res' );
				//}
				//$player -> $_GET['daj'] += $_POST['ilosc'];
				SqlExec("UPDATE tribes SET ".$_GET['daj']."=".$_GET['daj']."-".$_POST['ilosc']." WHERE id=".$mytribe -> fields['id']);
				$smarty -> assign ("Message", "Przekazales graczowi ID ".$_POST['did']." ".$_POST['ilosc']." ".$_POST['min']);
				SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$_POST['did'].", 'Dostales od klanu ".$_POST['ilosc']." ".$_POST['min']."','".$newdate."')");
			}
		}
		if (isset ($_GET['step2']) && $_GET['step2'] == 'daj') {
			if (isset ($_GET['step3']) && $_GET['step3'] == 'add') {
				//$gr = SqlExec("SELECT * FROM herbs WHERE gracz=".$player -> id);
				if( $player -> $_POST['mineral'] < $_POST['ilosc'] ) {
					error ("Nie masz tylu ziol !");
				}
				if ($_POST['mineral'] == 'illani') {
					$min = 'illani';
					$nazwa = 'Illani';
						//if ($_POST['ilosc'] > $gr -> fields['illani']) {
						//	error ("Nie masz takiej ilosci ".$nazwa.".");
						//}
				}
				if ($_POST['mineral'] == 'illanias') {
					$min = 'illanias';
					$nazwa = 'Illanias';
						//if ($_POST['ilosc'] > $gr -> fields['illanias']) {
						//	error ("Nie masz takiej ilosci ".$nazwa.".");
						//}
				}
				if ($_POST['mineral'] == 'nutari') {
					$min = 'nutari';
					$nazwa = 'Nutari';
						//if ($_POST['ilosc'] > $gr -> fields['nutari']) {
						//	error ("Nie masz takiej ilosci ".$nazwa.".");
						//}
				}
				if ($_POST['mineral'] == 'dynallca') {
					$min = 'dynallca';
					$nazwa = 'Dynallca';
						//if ($_POST['ilosc'] > $gr -> fields['dynallca']) {
						//	error ("Nie masz takiej ilosci ".$nazwa.".");
						//}
				}
				if ($_POST['ilosc'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['ilosc'])) {
					error ("Zapomnij o tym.");
				}
				SqlExec("UPDATE tribes SET ".$min."=".$min."+".$_POST['ilosc']." WHERE id=".$mytribe -> fields['id']) or error ("Nie moge dodac ".$min."!");
				$player -> $_POST['mineral'] -= $_POST['ilosc'];
				$smarty -> assign ("Message", "Dodales <b>".$_POST['ilosc']." ".$nazwa."</b> do zielnika klanu.");
				SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$mytribe -> fields['owner'].", 'Gracz <a href=view.php?view=".$player -> id.">".$player -> user."</a> ID: ".$player -> id." dodal do zielnika klanu ".$_POST['ilosc']." ".$nazwa."','".$newdate."')");
				error( "Przekazalez do klanu {$_POST['ilosc']} sztuk $nazwa", 'done', '?view=my&step=zielnik' );
			}
		}
	}

// skarbiec klanu
	if (isset ($_GET['step']) && $_GET['step'] == 'skarbiec') {
	//var_dump( $mytribe );
	//print_r ($_GET );
		if (!isset ($_GET['step2']) && !isset ($_GET['step3']) && !isset ($_GET['daj']) && !isset ($_GET['step4'])) {
			if ($player -> id == $mytribe -> fields['owner'] || $player -> id == $perm -> fields['bank']) {
				$smarty -> assign ("Menu", "<tr><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=copper><b><u>Miedz</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=zelazo><b><u>Zelazo</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=wegiel><b><u>Wegiel</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=adam><b><u>Adamantyt</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=meteo><b><u>Meteor</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=krysztal><b><u>Krysztal</u></b></a></td><td width=100><a href=tribes.php?view=my&step=skarbiec&daj=lumber><b><u>Drewno</u></b></a></td></tr>");
			} else {
				$smarty -> assign ("Menu", "<tr><td width=100><b><u>Miedz</u></b></td><td width=100><b><u>Zelazo</u></b></td><td width=100><b><u>Wegiel</u></b</td><td width=100><b><u>Adamantyt</u></b></td><td width=100><b><u>Meteor</u></b></td><td width=100><b><u>Krysztal</u></b></td><td width=100><b><u>Drewno</u></b></td></tr>");
			}
			//echo "<br><br>yooo<br><br>";
			
			$smarty -> assign ( array("Copper" => $mytribe -> fields['copper'], "Iron" => $mytribe -> fields['zelazo'], "Coal" => $mytribe -> fields['wegiel'], "Adamantium" => $mytribe -> fields['adam'], "Meteor" => $mytribe -> fields['meteo'], "Crystal" => $mytribe -> fields['krysztal'], "Lumber" => $mytribe -> fields['lumber']));
		}
		if (isset ($_GET['daj']) && $_GET['daj']) {
			if (!isset ($_GET['step4'])) {
				$mins = array( 'copper' => 'copper', 'zelazo' => 'iron', 'wegiel' => 'coal', 'adam' => 'adamantium', 'meteo' => 'meteor', 'krysztal' => 'crystal', 'lumber' => 'wood' );
				if ($_GET['daj'] == 'copper') {
					$min1 = "miedzi";
				} elseif ($_GET['daj'] == 'zelazo') {
					$min1 = "zelaza";
				} elseif ($_GET['daj'] == 'wegiel') {
					$min1 = "wegla";
				} elseif ($_GET['daj'] == 'adam') {
					$min1 = "adamantium";
				} elseif ($_GET['daj'] == 'meteo') {
					$min1 = "meteorow";
				} elseif ($_GET['daj'] == 'krysztal') {
					$min1 = "krysztalow";
				} elseif ($_GET['daj'] == 'lumber') {
					$min1 = "drewna";
				} else {
					error ("Zapomnij o tym!");
				}
				if( !isset( $mins[$_GET['daj']] ) ) {
					error( "Zapomnij o tym !" );
				}
				$min = $mins[$_GET['daj']];
				$smarty -> assign ( array("Itemid" => $_GET['daj'], "Name" => $min1));
			}
			if (isset ($_GET['step4']) && $_GET['step4'] == 'add') {
				$mins = array( 'copper' => 'copper', 'zelazo' => 'iron', 'wegiel' => 'coal', 'adam' => 'adamantium', 'meteo' => 'meteor', 'krysztal' => 'crystal', 'lumber' => 'wood' );
				if (!ereg("^[1-9][0-9]*$", $_POST['ilosc'])) {
					error ("Zapomnij o tym<br>");
				}
				if ($_GET['daj'] != 'copper' && $_GET['daj'] != 'zelazo' && $_GET['daj'] != 'wegiel' && $_GET['daj'] != 'adam' && $_GET['daj'] != 'meteo' && $_GET['daj'] != 'lumber' && $_GET['daj'] != 'krysztal') {
					error ("Zapomnij o tym<br>");
				}
				$daj = $_GET['daj'];
				if (!ereg("^[1-9][0-9]*$", $_POST['did'])) {
					error ("Zapomnij o tym<br>");
				}
				$dtrib = SqlExec("SELECT tribe FROM players WHERE id=".$_POST['did']);
				if ($dtrib -> fields['tribe'] != $mytribe -> fields['id']) {
					error ("Ten gracz nie jest w twoim klanie!");
				}
				$dtrib -> Close();
				$give = $_GET['daj'];
				if ($mytribe -> fields[$give] < $_POST['ilosc']) {
					error ("Klan nie ma takiej ilosci ".$_POST['min']."!");
				}
				if( !isset( $mins[ $_GET['daj'] ] ) ) {
					error( "Zapomnij o tym !" );
				}
				$min = $mins[ $_GET['daj'] ];
				//$kop = SqlExec("SELECT id FROM kopalnie WHERE gracz=".$_POST['did']);
				//if (!$kop -> fields['id']) {
				//	SqlExec("INSERT INTO kopalnie ( gracz, ".$daj.") values(".$_POST['did'].",".$_POST['ilosc'].")") or error("Nie moge dodac");
				//} else {
				SqlExec("UPDATE resources SET ".$min."=".$min."+".$_POST['ilosc']." WHERE id=".$_POST['did']);
				PutSignal( $_POST['did'], 'res' );
				//}
				//$player -> $min += $_POST['ilosc'];
				//$kop -> Close();
				SqlExec("UPDATE tribes SET ".$daj."=".$daj."-".$_POST['ilosc']." WHERE id=".$mytribe -> fields['id']);
				$smarty -> assign ("Message", "Przekazales graczowi ID ".$_POST['did']." ".$_POST['ilosc']." ".$_POST['min']);
				SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$_POST['did'].", 'Dostales od klanu ".$_POST['ilosc']." ".$_POST['min']."','".$newdate."')");
			}
		}
		if (isset ($_GET['step2']) && $_GET['step2'] == 'daj') {
			if (isset ($_GET['step3']) && $_GET['step3'] == 'add') {
				//$gr = SqlExec("SELECT * FROM kopalnie WHERE gracz=".$player -> id);
				
				if ($_POST['mineral'] == 'miedz') {
					$min = 'copper';
					$nazwa = 'miedzi';
//					if ($_POST['ilosc'] > $gr -> fields['copper']) {
//						error ("Nie masz takiej ilosci ".$nazwa.".");
//					}
				}
				if ($_POST['mineral'] == 'zelazo') {
					$min = 'zelazo';
					$nazwa = 'zelaza';
//					if ($_POST['ilosc'] > $gr -> fields['zelazo']) {
//						error ("Nie masz takiej ilosci ".$nazwa.".");
//					}
				}
				if ($_POST['mineral'] == 'wegiel') {
					$min = 'wegiel';
					$nazwa = 'wegla';
//					if ($_POST['ilosc'] > $gr -> fields['wegiel']) {
//						error ("Nie masz takiej ilosci ".$nazwa.".");
//					}
				}
				if ($_POST['mineral'] == 'adamantyt') {
					$min = 'adam';
					$nazwa = 'adamantium';
//					if ($_POST['ilosc'] > $gr -> fields['adam']) {
//						error ("Nie masz takiej ilosci ".$nazwa.".");
//					}
				}
				if ($_POST['mineral'] == 'meteoryt') {
					$min = 'meteo';
					$nazwa = 'meteorytu';
//					if ($_POST['ilosc'] > $gr -> fields['meteo']) {
//						error ("Nie masz takiej ilosci ".$nazwa.".");
//					}
				}
				if ($_POST['mineral'] == 'krysztal') {
					$min = 'krysztal';
					$nazwa = 'krysztalow';
//					if ($_POST['ilosc'] > $gr -> fields['krysztal']) {
//						error ("Nie masz takiej ilosci ".$nazwa.".");
//					}
				}
				if ($_POST['mineral'] == 'drewno') {
					$min = 'lumber';
					$nazwa = 'drewna';
//					if ($_POST['ilosc'] > $gr -> fields['lumber']) {
//						error ("Nie masz takiej ilosci ".$nazwa.".");
//					}
				}
				$mins = array( 'copper' => 'copper', 'zelazo' => 'iron', 'wegiel' => 'coal', 'adam' => 'adamantium', 'meteo' => 'meteor', 'krysztal' => 'crystal', 'lumber' => 'wood' );
				if( !isset( $mins[$min] ) ) {
					error( "Zapomnij o tym ");
				}
				$tmin = $min;
				$min = $mins[$min];
				if ($_POST['ilosc'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['ilosc'])) {
					error ("Zapomnij o tym.");
				}
				SqlExec("UPDATE tribes SET ".$tmin."=".$tmin."+".$_POST['ilosc']." WHERE id=".$mytribe -> fields['id']);
				//SqlExec("UPDATE kopalnie SET ".$min."=".$min."-".$_POST['ilosc']." WHERE gracz=".$player -> id);
				$player -> $min -= $_POST['ilosc'];
				$smarty -> assign ("Message", "Dodales <b>".$_POST['ilosc']." ".$nazwa."</b> do skarbca klanu.");
				SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$mytribe -> fields['owner'].", 'Gracz <a href=view.php?view=".$player -> id.">".$player -> user."</a> ID: ".$player -> id." dodal do skarbca klanu ".$_POST['ilosc']." ".$nazwa."','".$newdate."')");
			}
		}
	}

// lista czlonkow w klanie
	if (isset ($_GET['step']) && $_GET['step'] == 'members') {
		$mem = SqlExec("SELECT id, user, tribe_rank FROM players WHERE tribe=".$mytribe -> fields['id']);
		//print_r( $mem );
		$arrlink = array();
		$i = 0;
		while (!$mem -> EOF) {
			if ($mem -> fields['id'] == $mytribe -> fields['owner']) {
				$arrlink[$i] = "- <a href=view.php?view=".$mem -> fields['id'].">".$mem -> fields['user']."</a> (".$mem -> fields['id'].") (".$mem -> fields['tribe_rank'].") (Przywodca)<br>";
			} else {
				$arrlink[$i] = "- <a href=view.php?view=".$mem -> fields['id'].">".$mem -> fields['user']."</a> (".$mem -> fields['id'].") (".$mem -> fields['tribe_rank'].")<br>";
			}
		$mem -> MoveNext();
			$i = $i + 1;
		}
		$mem -> Close();
		$smarty -> assign("Link", $arrlink);
	}

// Opuszczanie klanu przez gracza
	if (isset ($_GET['step']) && $_GET['step'] == 'quit') {
		if ($mytribe -> fields['owner'] == $player -> id) {
			$smarty -> assign ("Owner", 1);
			if (isset ($_GET['dalej'])) {
				//SqlExec("UPDATE players SET tribe=0 WHERE tribe=".$mytribe -> fields['id']);
				SqlExec("DELETE FROM tribes WHERE id=".$mytribe -> fields['id']);
				SqlExec("DELETE FROM tribe_zbroj WHERE klan=".$mytribe -> fields['id']);
				SqlExec("DELETE FROM tribe_mag WHERE klan=".$mytribe -> fields['id']);
				SqlExec("DELETE FROM tribe_oczek WHERE klan=".$mytribe -> fields['id']);
				SqlExec("DELETE FROM tribe_perm WHERE tribe=".$mytribe -> fields['id']);
				//SqlExec("UPDATE players SET tribe_rank='' WHERE id=".$player -> id);
				$player -> tribe_id = 0;
				error ("Opuszczasz klan. Poniewaz jestes przywodca, klan zostal usuniety.");
			}
		}  else {
			$smarty -> assign("Owner", 0);
			if (isset ($_GET['dalej'])) {
				//SqlExec("UPDATE players SET tribe=0 WHERE id=".$player -> id);
				//SqlExec("UPDATE players SET tribe_rank='' WHERE id=".$player -> id);
				$player -> tribe_id = 0;
				$player -> tribe_rank = '';
				error ("Opuszczasz klan.");
			}
		}
	}

// menu kontroli klanu
	if (isset ($_GET['step']) && $_GET['step'] == 'owner') {
		$test = array($perm -> fields['messages'],$perm -> fields['wait'],$perm -> fields['kick'],$perm -> fields['army'],$perm -> fields['attack'],$perm -> fields['loan'],$perm -> fields['armory'],$perm -> fields['warehouse'],$perm -> fields['bank'],$perm -> fields['herbs']);
		if ($player -> id == $mytribe -> fields['owner'] || $player -> id == $test[0] || $player -> id == $test[1] || $player -> id == $test[2] || $player -> id == $test[3] || $player -> id == $test[4] || $player -> id == $test[5] || $player -> id == $test[6] || $player -> id == $test[7] || $player -> id == $test[8] || $player -> id == $test[9]) {

// Ustawiania rang oraz nadawanie ich czlonkom klanu - dostep jedynie przywodca klanu
			if (isset ($_GET['step2']) && $_GET['step2'] == 'rank') {
				if($player -> id != $mytribe -> fields['owner']) {
				error ("Tylko przywodca moze nadawac rangi!");
				}
				if (!isset ($_GET['step3'])) {
					$test = SqlExec("SELECT id FROM tribe_rank WHERE tribe_id=".$mytribe -> fields['id']);
					if ($test -> fields['id']) {
						$smarty -> assign ("Menu", "<li><a href=tribes.php?view=my&step=owner&step2=rank&step3=get>Daj czlonkowi klanu range</a></li>");
					} else {
						$smarty -> assign("Menu", '');
					}
			$test -> Close();
				}
				if (isset ($_GET['step3']) && $_GET['step3'] == 'set') {
					$ranks = SqlExec("select id, rank1, rank2, rank3, rank4, rank5, rank6, rank7, rank8, rank9, rank10 from tribe_rank where tribe_id=".$mytribe -> fields['id']);
					if (!$ranks -> fields['id']) {
						$smarty -> assign("Empty", 1);
					} else {
						$smarty -> assign ( array("Rank1" => $ranks -> fields['rank1'], "Rank2" => $ranks -> fields['rank2'], "Rank3" => $ranks -> fields['rank3'], "Rank4" => $ranks -> fields['rank4'], "Rank5" => $ranks -> fields['rank5'], "Rank6" => $ranks -> fields['rank6'], "Rank7" => $ranks -> fields['rank7'], "Rank8" => $ranks -> fields['rank8'], "Rank9" => $ranks -> fields['rank9'], "Rank10" => $ranks -> fields['rank10'], "Empty" => 0));
					}
					if (isset ($_GET['step4']) && $_GET['step4'] == 'add') {
						for ($i=1;$i<11;$i++) {
							$number = "rank".$i;
							$_POST[$number] = strip_tags($_POST[$number]);
						}
						SqlExec("INSERT INTO tribe_rank (tribe_id, rank1, rank2, rank3, rank4, rank5, rank6, rank7, rank8, rank9, rank10) VALUES(".$mytribe -> fields['id'].",'".$_POST['rank1']."','".$_POST['rank2']."','".$_POST['rank3']."','".$_POST['rank4']."','".$_POST['rank5']."','".$_POST['rank6']."','".$_POST['rank7']."','".$_POST['rank8']."','".$_POST['rank9']."','".$_POST['rank10']."')") or error ("Nie moge stworzyc rang!");
						$smarty -> assign ("Message", "Rangi utworzone. <a href=tribes.php?view=my&step=owner&step2=rank>Wroc do menu rang</a><br>");
					}
					if (isset ($_GET['step4']) && $_GET['step4'] == 'edit') {
						for ($i=1;$i<11;$i++) {
							$number = "rank".$i;
							$_POST[$number] = strip_tags($_POST[$number]);
						}
						SqlExec("UPDATE tribe_rank SET rank1='".$_POST['rank1']."' WHERE tribe_id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribe_rank SET rank2='".$_POST['rank2']."' WHERE tribe_id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribe_rank SET rank3='".$_POST['rank3']."' WHERE tribe_id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribe_rank SET rank4='".$_POST['rank4']."' WHERE tribe_id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribe_rank SET rank5='".$_POST['rank5']."' WHERE tribe_id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribe_rank SET rank6='".$_POST['rank6']."' WHERE tribe_id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribe_rank SET rank7='".$_POST['rank7']."' WHERE tribe_id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribe_rank SET rank8='".$_POST['rank8']."' WHERE tribe_id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribe_rank SET rank9='".$_POST['rank9']."' WHERE tribe_id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribe_rank SET rank10='".$_POST['rank10']."' WHERE tribe_id=".$mytribe -> fields['id']);
						$smarty -> assign ("Message", "Rangi zmienione. <a href=tribes.php?view=my&step=owner&step2=rank>Wroc do menu rang</a><br>");
					}
				}
				if (isset ($_GET['step3']) && $_GET['step3'] == 'get') {
					$test = SqlExec("SELECT id FROM tribe_rank WHERE tribe_id=".$mytribe -> fields['id']);
					if (!$test -> fields['id']) {
						error ("Nie ma okreslonych rang!<br>");
					}
			$test -> Close();
					$rank = SqlExec("select rank1, rank2, rank3, rank4, rank5, rank6, rank7, rank8, rank9, rank10 from tribe_rank where tribe_id=".$mytribe -> fields['id']);
					$name = array('rank1','rank2','rank3','rank4','rank5','rank6','rank7','rank8','rank9','rank10');
					$arrname = array();
					$j = 0;
					for ($i=0;$i<10;$i++) {
						$number = $name[$i];
						if ($rank -> fields[$number]) {
							$arrname[$j] = $rank -> fields[$number];
							$j = $j + 1;
						}
					}
			$rank -> Close();
					$smarty -> assign ("Rank", $arrname);
					if (isset ($_GET['step4']) && $_GET['step4'] == 'add') {
						$_POST['rank'] = strip_tags($_POST['rank']);
						if (!ereg("^[1-9][0-9]*$", $_POST['rid'])) {
							error ("Zapomnij o tym!");
						}
						$test = SqlExec("SELECT tribe FROM players WHERE id=".$_POST['rid']);
						if ($test -> fields['tribe'] != $mytribe -> fields['id']) {
							error ("Ten gracz nie jest w twoim klanie!<br>");
						}
			$test -> Close();
						SqlExec("UPDATE players SET tribe_rank='".$_POST['rank']."' WHERE id=".$_POST['rid']);
						$smarty -> assign ("Message", "Dales graczowi ID ".$_POST['rid']." range: ".$_POST['rank']."<br>");
					}
				}
			}
// Ustawianie uprawnien dla czlonkow klanu - dostep jedynie przywodca klanu
			if (isset ($_GET['step2']) && $_GET['step2'] == 'permissions') {
				if ($player -> id != $mytribe -> fields['owner']) {
					error ("Tylko przywodca moze ustawiac zezwolenia!");
				}
				if (!isset ($_GET['step3'])) {
					if (!$perm -> fields['tribe']) {
						$smarty -> assign("Perm", 1);
					} else {
						$smarty -> assign ( array("Perm1" => $perm -> fields['messages'], "Perm2" => $perm -> fields['wait'], "Perm3" => $perm -> fields['kick'], "Perm4" => $perm -> fields['army'], "Perm5" => $perm -> fields['attack'], "Perm6" => $perm -> fields['loan'], "Perm7" => $perm -> fields['armory'], "Perm8" => $perm -> fields['warehouse'], "Perm9" => $perm -> fields['bank'], "Perm10" => $perm -> fields['herbs'], "Perm11" => $perm -> fields['forum'], "Perm" => ''));
					}
				}
				if (isset ($_GET['step3'])) {
					$test = array($_POST['messages'],$_POST['wait'],$_POST['kick'],$_POST['army'],$_POST['attack'],$_POST['loan'],$_POST['armory'],$_POST['warehouse'],$_POST['bank'],$_POST['herbs'],$_POST['forum']);
					for ($i=0;$i<11;$i++) {
						if (!ereg("^[0-9]*$", $test[$i])) {
							error ("Zapomnij o tym!");
						}
						$ttribe = SqlExec("SELECT tribe FROM players WHERE id=".$test[$i]);
						if ($ttribe -> fields['tribe'] != $mytribe -> fields['id'] && $test[$i] != 0) {
							error ("Gracz o id ".$test[$i]." nie jest w twoim klanie! <a href=tribes.php?view=my&step=owner> Wroc do menu przywodcy</a>");
						}
					}
				}
				if (isset ($_GET['step3']) && $_GET['step3'] == 'add') {
					SqlExec("INSERT INTO tribe_perm (tribe, messages, wait, kick, army, attack, loan, armory, warehouse, bank, herbs, forum) VALUES(".$mytribe -> fields['id'].",".$_POST['messages'].",".$_POST['wait'].",".$_POST['kick'].",".$_POST['army'].",".$_POST['attack'].",".$_POST['loan'].",".$_POST['armory'].",".$_POST['warehouse'].",".$_POST['bank'].",".$_POST['herbs'].",".$_POST['forum'].")") or die ("nie moge dodac!");
					$smarty -> assign ("Message", "Ustawiles uprawnienia czlonkom klanu. <a href=tribes.php?view=my&step=owner>wroc do menu</a>");
				}
				if (isset ($_GET['step3']) && $_GET['step3'] == 'change') {
					SqlExec("UPDATE tribe_perm SET messages=".$_POST['messages']." WHERE tribe=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribe_perm SET wait=".$_POST['wait']." WHERE tribe=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribe_perm SET kick=".$_POST['kick']." WHERE tribe=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribe_perm SET army=".$_POST['army']." WHERE tribe=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribe_perm SET attack=".$_POST['attack']." WHERE tribe=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribe_perm SET loan=".$_POST['loan']." WHERE tribe=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribe_perm SET armory=".$_POST['armory']." WHERE tribe=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribe_perm SET warehouse=".$_POST['warehouse']." WHERE tribe=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribe_perm SET bank=".$_POST['bank']." WHERE tribe=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribe_perm SET herbs=".$_POST['herbs']." WHERE tribe=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribe_perm SET forum=".$_POST['forum']." WHERE tribe=".$mytribe -> fields['id']);
					$smarty -> assign ("Message", "Ustawiles uprawnienia czlonkom klanu. <a href=tribes.php?view=my&step=owner>wroc do menu</a>");
				}
			}

// kupowanie wojska oraz barykad do klanu
			if (isset ($_GET['step2']) && $_GET['step2'] == 'wojsko') {
				if($mytribe -> fields['immu']=='Y')
					error("Nie mo¿esz przeprowadzaæ operacji militarnych bo zadeklarowa³e¶ neutralno¶æ");
				if ($player -> id != $mytribe -> fields['owner'] && $player -> id != $perm -> fields['army']) {
					error ("Tylko przywodca lub osoba upowazniona moze kupowac zolnierzy i fortyfikacje do klanu!");
				}
				if (isset ($_GET['action']) && $_GET['action'] == 'kup') {
					if (!ereg("^[0-9]*$",$_POST['zolnierze'])) {
						error ("Zapomnij o tym");
					}
					if (!ereg("^[0-9]*$",$_POST['forty'])) {
						error ("Zapomnij o tym");
					}
					if ($_POST["zolnierze"] == 0 && $_POST["forty"] == 0) {
						error ("Wypelnij chociaz jedno pole!");
					}
					$cenaz = ($_POST["zolnierze"] * 1000);
					$cenaf = ($_POST["forty"] * 1000);
					$suma = $cenaz + $cenaf;
					if ($suma > $mytribe -> fields['credits']) {
						error ("Klan nie ma tyle sztuk zlota");
					}
				$message = '';
					if ($_POST["zolnierze"] > 0) {
						SqlExec("UPDATE tribes SET zolnierze=zolnierze+".$_POST['zolnierze']." WHERE id=".$mytribe -> fields['id']);
					$message =  $message."Kupiles dla swojego klanu ".$_POST['zolnierze']." zolnierzy za ".$cenaz." sztuk zlota<br>";
					}
					if ($_POST["forty"] > 0) {
						SqlExec("UPDATE tribes SET forty=forty+".$_POST['forty']." WHERE id=".$mytribe -> fields['id']);
					$message = $message."Kupiles dla swojego klanu ".$_POST['forty']." fortyfikacji za ".$cenaf." sztuk zlota<br>";
					}
					SqlExec("UPDATE tribes SET credits=credits-".$suma." WHERE id=".$mytribe -> fields['id']);
				$message = $message."W sumie wydales na wszystko ".$suma." sztuk zlota.<br>";
				$smarty -> assign("Message", $message);
				}
			}

//Lista oczekujacych na przyjecie do klanu
			if (isset ($_GET['step2']) && $_GET['step2'] == 'nowy') {
				if ($player -> id != $mytribe -> fields['owner'] && $player -> id != $perm -> fields['wait']) {
					error ("Tylko przywodca lub osoba upowazniona moze przebywac tutaj!");
				}
				$smarty -> assign("New", 0);
				if (!isset($_GET['odrzuc']) && !isset($_GET['dodaj'])) {
					$smarty -> assign ("New", 1);
					$czeka = SqlExec("SELECT * FROM tribe_oczek WHERE klan=".$mytribe -> fields['id']);
					$arrlink = array();
					$i = 0;
					while (!$czeka -> EOF) {
						$arrlink[$i] = "<tr><td><a href=view.php?view=".$czeka -> fields['gracz'].">".$czeka -> fields['gracz']."</a></td><td><a href=tribes.php?view=my&step=owner&step2=nowy&dodaj=".$czeka -> fields['id'].">Tak</a></td><td><a href=tribes.php?view=my&step=owner&step2=nowy&odrzuc=".$czeka -> fields['id'].">Tak</a></td></tr>";
						$czeka -> MoveNext();
						$i = $i + 1;
					}
					$czeka -> Close();
					$smarty -> assign ("Link", $arrlink);
				}
				if (isset($_GET['odrzuc'])) {
					$del = SqlExec("SELECT * FROM tribe_oczek WHERE id=".$_GET['odrzuc']);
					$smarty -> assign ("Message", "Odrzuciles kandydata o id ".$del -> fields['gracz'].".");
					SqlExec("INSERT INTO log (owner, log, czas) VALUES(".$del -> fields['gracz'].",'Klan <b>".$mytribe -> fields['name']."</b> odrzucil twoja kandydature ','".$newdate."')") or error("INSERT INTO log (owner, log, czas) VALUES(".$del -> fields['gracz'].",'Klan <b>".$mytribe -> fields['name']."</b> odrzucil twoja kandydature ','".$newdate."')");
					SqlExec("DELETE FROM tribe_oczek WHERE id=".$del -> fields['id']);
				$del -> Close();
				}
				if (isset($_GET['dodaj'])) {
					$dod = SqlExec("SELECT * FROM tribe_oczek WHERE id=".$_GET['dodaj']);
					$smarty -> assign ("Message", "Zaakceptowales kandydata o id ".$dod -> fields['gracz'].".");
					SqlExec("INSERT INTO log (owner, log, czas) VALUES(".$dod -> fields['gracz'].",'Klan <b>".$mytribe -> fields['name']."</b> przyjal twoja kandydature. Jestes juz czlonkiem klanu','".$newdate."')") or error("INSERT INTO log (owner, log, czas) VALUES(".$dod -> fields['gracz'].",'Klan <b>".$mytribe -> fields['name']."</b> przyjal twoja kandydature. Jestes juz czlonkiem klanu','".$newdate."')");
					SqlExec("UPDATE players SET tribe=".$dod -> fields['klan']." WHERE id=".$dod -> fields['gracz']);
					PutSignal( $dod -> fields['gracz'], 'misc' );
					SqlExec("DELETE FROM tribe_oczek WHERE id=".$dod -> fields['id']);
				$dod -> Close();
				}
			}

// walka klanow
			if (isset ($_GET['step2']) && $_GET['step2'] == 'walka') {
				if ($player -> id != $mytribe -> fields['owner'] && $player -> id != $perm -> fields['attack']) {
					error ("Tylko przywodca lub osoba upowazniona moze przebywac tutaj!");
				}
				if ($mytribe -> fields['immu'] == 'Y')
					error("Nie mo¿esz atakowaæ poniewa¿ wypowiedzia³e¶ neutralno¶æ !");
				if ($mytribe -> fields['atak'] == 'Y') {
					error ("Klan moze atakowac inne klany tylko raz na reset!");
				}
				$klan1 =SqlExec("SELECT id, name, immu FROM tribes WHERE id!=".$mytribe -> fields['id']." AND immu!='Y'");
				if ($klan1 -> fields['immu'] == 'Y')
					error("Nie mo¿esz atakowaæ poniewa¿ wypowiedzia³ on neutralno¶æ !");
				$arrlink = array();
				$i = 0;
				while (!$klan1 -> EOF) {
					$arrlink[$i] = "<a href=tribes.php?view=my&step=owner&step2=walka&atak=".$klan1 -> fields['id'].">Atakuj klan ".$klan1 -> fields['name']."<br></a>";
				$klan1 -> MoveNext();
					$i = $i + 1;
				}
			$klan1 -> Close();
				$smarty -> assign("Link", $arrlink);
				if (isset($_GET['atak'])) {
					if (!ereg("^[1-9][0-9]*$", $_GET['atak'])) {
						error ("Zapomnij o tym!");
					}
					$matak = 0;
					$mobrona = 0;
					$eatak = 0;
					$eobrona = 0;
					SqlExec("UPDATE tribes SET atak='Y' WHERE id=".$mytribe -> fields['id']);
					$mcechy = SqlExec("SELECT klasa, strength, inteli, agility FROM players WHERE tribe=".$mytribe -> fields['id']);
					while (!$mcechy -> EOF) {
						if ($mcechy -> fields['klasa'] == 'Wojownik' || $mcechy -> fields['klasa'] == 'Rzemieslnik' || $mcechy -> fields['klasa'] == 'Zlodziej' || $mcechy -> fields['klasa'] == 'Barbarzynca') {
							$matak = ($matak + $mcechy -> fields['strength']);
						}
						if ($mcechy -> fields['klasa'] == 'Mag') {
							$matak = ($matak + $mcechy -> fields['inteli']);
						}
						$mobrona = ($mobrona + $mcechy -> fields['agility']);
				$mcechy -> MoveNext();
					}
				$mcechy -> Close();
					$matak = $matak + $mytribe -> fields['zolnierze'];
					$mobrona = $mobrona + $mytribe -> fields['forty'];
					$ecechy = SqlExec("SELECT klasa, strength, inteli, agility FROM players WHERE tribe=".$_GET['atak']);
					while (!$ecechy -> EOF) {
						if ($ecechy -> fields['klasa'] == 'Wojownik' || $ecechy -> fields['klasa'] == 'Rzemieslnik' || $ecechy -> fields['klasa'] == 'Zlodziej' || $ecechy -> fields['klasa'] == 'Barbarzynca') {
							$eatak = ($eatak + $ecechy -> fields['strength']);
						}
						if ($ecechy -> fields['klasa'] == 'Mag') {
							$eatak = ($eatak + $ecechy -> fields['inteli']);
						}
						$eobrona = ($eobrona + $ecechy -> fields['agility']);
				$ecechy -> MoveNext();
					}
				$ecechy -> Close();
					$klan = SqlExec("SELECT * FROM tribes WHERE id=".$_GET['atak']);
					$eatak = $eatak + $klan -> fields['zolnierze'];
					$eobrona = $eobrona + $klan -> fields['forty'];
					$rzut = rand(1,1000);
					$matak = ($matak + $rzut);
					$mobrona = ($mobrona + $rzut);
					$eatak = ($eatak + $rzut);
					$eobrona = ($eobrona + $rzut);
					$matak = ($matak - $eobrona);
					$eatak = ($eatak - $mobrona);
					$smarty -> assign("Victory", '');
					if ($matak >= $eatak) {
						if ($klan -> fields['credits'] > 0) {
							$gzloto = ceil($klan -> fields['credits'] / 10);
						} else {
							$gzloto = 0;
						}
						if ($klan -> fields['platinum'] > 0) {
							$gmith = ceil($klan -> fields['platinum'] / 10);
						} else {
							$gmith = 0;
						}
						$smarty -> assign ( array("Myname" => $mytribe -> fields['name'], "Ename" => $klan -> fields['name'], "Gold" => $gzloto, "Mithril" => $gmith, "Victory" => "My"));
						SqlExec("UPDATE tribes SET credits=credits+".$gzloto." WHERE id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribes SET platinum=platinum+".$gmith." WHERE id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribes SET wygr=wygr+1 WHERE id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribes SET credits=credits-".$gzloto." WHERE id=".$klan -> fields['id']);
						SqlExec("UPDATE tribes SET platinum=platinum-".$gmith." WHERE id=".$klan -> fields['id']);
						SqlExec("UPDATE tribes SET przeg=przeg+1 WHERE id=".$klan -> fields['id']);
						SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$klan -> fields['owner'].", 'Klan ".$mytribe -> fields['name']." zaatakowal i pokonal twoj klan. Staciliscie ".$gzloto." sztuk zlota oraz ".$gmith." sztuk mithrilu!','".$newdate."')");
					}
					if ($eatak > $matak) {
						if ($mytribe -> fields['credits'] > 0) {
							$gzloto = ceil($mytribe -> fields['credits'] / 10);
						} else {
							$gzloto = 0;
						}
						if ($mytribe -> fields['platinum'] > 0) {
							$gmith = ceil($mytribe -> fields['platinum'] / 10);
						} else {
							$gmith = 0;
						}
						$smarty -> assign ( array("Ename" => $klan -> fields['name'], "Gold" => $gzloto, "Mithril" => $gmith, "Victory" => "Enemy"));
						SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$klan -> fields['owner'].", 'Klan ".$mytribe -> fields['name']." zaatakowal i zostal pokonany przez twoj klan. Zdobyliscie ".$gzloto." sztuk zlota oraz ".$gmith." sztuk mithrilu!','".$newdate."')");
						SqlExec("UPDATE tribes SET credits=credits-".$gzloto." WHERE id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribes SET platinum=platinum-".$gmith." WHERE id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribes SET przeg=przeg+1 WHERE id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribes SET credits=credits+".$gzloto." WHERE id=".$klan -> fields['id']);
						SqlExec("UPDATE tribes SET platinum=platinum+".$gmith." WHERE id=".$klan -> fields['id']);
						SqlExec("UPDATE tribes SET wygr=wygr+1 WHERE id=".$klan -> fields['id']);
					}
				}
			}

// wiadomosci o klanie oraz jego herb i strona www
			if (isset ($_GET['step2']) && $_GET['step2'] == 'messages') {
				if ($player -> id != $mytribe -> fields['owner'] && $player -> id != $perm -> fields['messages']) {
					error ("Tylko przywodca lub osoba upowazniona moze przebywac tutaj!");
				}
					$smarty -> assign ( array("Pubmessage" => $mytribe -> fields['public_msg'], "Privmessage" => $mytribe -> fields['private_msg'], "WWW" => $mytribe -> fields['www']));
				$avatar = SqlExec("SELECT logo FROM tribes WHERE id=".$mytribe -> fields['id']);
				$plik = 'images/tribes/'.$avatar -> fields['logo'];
				if (is_file($plik)) {
					$smarty -> assign ("Logo1", "<center><img src=".$plik." heigth=100 width=100></center>");
				}
				if (is_file($plik)) {
						$smarty -> assign ( array("Logo" => $avatar -> fields['logo'], "Change" => "Y"));
				} else {
					$smarty -> assign("Change", '');
				}
				if (isset ($_GET['action']) && $_GET['action'] == 'www') {
					$_POST['www'] = str_replace("'","",strip_tags($_POST['www']));
					SqlExec("UPDATE tribes SET www='".$_POST['www']."' WHERE id=".$mytribe -> fields['id']);
					$smarty -> assign ("Message", "Adres strony ustawiony na <a href=http://".$_POST['www']." target=_blank>".$_POST['www']."</a>. <a href=tribes.php?view=my&step=owner&step2=messages>Odswiez</a><br>");
				}
				if (isset ($_GET['step4']) && $_GET['step4'] == 'usun') {
					$plik = 'images/tribes/'.$_POST['av'];
					if (is_file($plik)) {
						unlink($plik);
						SqlExec("UPDATE tribes SET logo='' where id=".$mytribe -> fields['id']) or error ("nie moge skasowac");
						$smarty -> assign ("Message", "Herb usuniety. <a href=tribes.php?view=my&step=owner&step2=messages>Odswiez</a><br>");
					} else {
						error ("Nie ma takiego pliku!<br>");
					}
				}
				if (isset ($_GET['step4']) && $_GET['step4'] == 'dodaj') {
					$plik = $_FILES['plik']['tmp_name'];
					$nazwa = $_FILES['plik']['name'];
					$typ = $_FILES['plik']['type'];
					if ($typ != 'image/pjpeg' && $typ != 'image/jpeg' && $typ != 'image/gif') {
						error ("Zly typ pliku!");
					}
					if ($typ == 'image/pjpeg' || $typ == 'image/jpeg') {
						$liczba = rand(1,1000000);
						$newname = md5($liczba).'.jpg';
						$miejsce = 'images/tribes/'.$newname;
					}
					if ($typ == 'image/gif') {
						$liczba = rand(1,1000000);
						$newname = md5($liczba).'.gif';
						$miejsce = 'images/tribes/'.$newname;
					}
					if (is_uploaded_file($plik)) {
						if (!move_uploaded_file($plik,$miejsce)) {
							error ("Nie skopiowano pliku!");
						}
					} else {
						error ("Zapomij o tym");
					}
					SqlExec("UPDATE tribes SET logo='".$newname."' where id=".$mytribe -> fields['id']);
					$smarty -> assign ("Message",  "Herb zaladowany! <a href=tribes.php?view=my&step=owner&step2=messages>Odswiez</a><br>");
				}
				if (isset ($_GET['action']) && $_GET['action'] == 'edit') {
					$_POST['private_msg'] = strip_tags($_POST['private_msg'],"<hr><br><b></b><u></u><s><i></i><center></center>");
					$_POST['public_msg'] = strip_tags($_POST['public_msg'],"<hr><br><b></b><u></u><s><i></i><center></center>");
					SqlExec("UPDATE tribes SET private_msg='".$_POST['private_msg']."' WHERE id=".$mytribe -> fields['id']);
					SqlExec("UPDATE tribes SET public_msg='".$_POST['public_msg']."' WHERE id=".$mytribe -> fields['id']);
					$smarty -> assign ("Message", "Wiadomosc zmieniona.");
				}
			}

// wyrzucanie czlonkow klanu
			if (isset ($_GET['step2']) && $_GET['step2'] == 'kick') {
				if ($player -> id != $mytribe -> fields['owner'] && $player -> id != $perm -> fields['kick']) {
					error ("Tylko przywodca lub osoba upowazniona moze przebywac tutaj!");
				}
				if (isset ($_GET['action']) && $_GET['action'] == 'kick') {
							if (!isset($_POST['id']))
							{
								error("Podaj id gracza!");
							}
					if (!ereg("^[1-9][0-9]*$", $_POST['id'])) {
						error ("Zapomnij o tym");
					}
					if ($_POST['id'] != $mytribe -> fields['owner']) {
						SqlExec("UPDATE players SET tribe=0 WHERE id=".$_POST['id']." AND tribe=".$mytribe -> fields['id']);
						SqlExec("UPDATE players SET tribe_rank='' WHERE id=".$_POST['id']);
						PutSignal( $_POST['id'], 'misc' );
						SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$_POST['id'].",'Zostales wyrzucony z ".$mytribe -> fields['name'].".','".$newdate."')");
						$smarty -> assign ("Message", "ID ".$_POST['id']." nie jest juz czlonkiem klanu.");
					} else {
						$smarty -> assign ("Message", "Nie mozesz wyrzucic Przywodcy.");
					}
				}
			}

// pozyczki z klanu
			if (isset ($_GET['step2']) && $_GET['step2'] == 'loan') {
				if ($player -> id != $mytribe -> fields['owner'] && $player -> id != $perm -> fields['loan']) {
					error ("Tylko przywodca lub osoba upowazniona moze przebywac tutaj!");
				}
				if (isset($_GET['action']) && $_GET['action'] == 'loan') {
					if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
						error ("Zapomnij o tym");
					}
					if ($_POST['currency'] != 'credits' && $_POST['currency'] != 'platinum') {
						error ("Zapomnij o tym");
					}
					if ($_POST['currency'] == 'credits') {
						$field = 'gold';
						$poz = 'sztuk zlota';
					}
					if ($_POST['currency'] == 'platinum') {
						$field = 'mithril';
						$poz = 'sztuk mithrilu';
					}
					$rec = SqlExec("SELECT tribe FROM players WHERE id=".$_POST['id']);
					if ($rec -> fields['tribe'] != $mytribe -> fields['id']) {
						$smarty -> assign ("Message", "Ta osoba nie jest w klanie.");
					} else {
						if (!$_POST['amount'] || !$_POST['id']) {
							$smarty -> assign ("Message", "Wypelnij wszystkie pola.");
						} else {
							if ($_POST['amount'] > $mytribe -> fields[$_POST['currency']] || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
								$smarty -> assign ("Message", "Klan nie ma tyle ".$poz.".");
							} else {
								SqlExec("UPDATE resources SET ".$field."=".$field."+".$_POST['amount']." WHERE id=".$_POST['id']);
								PutSignal( $_POST['id'], 'res' );
								SqlExec("UPDATE tribes SET ".$_POST['currency']."=".$_POST['currency']."-".$_POST['amount']." WHERE id=".$mytribe -> fields['id']);
								SqlExec("INSERT INTO log (owner,log, czas) VALUES(".$_POST['id'].",'Klan pozyczyl ci ".$_POST['amount']." ".$poz.".','".$newdate."')");
								$smarty -> assign ("Message", "Pozyczyles ID ".$_POST['id']." ".$_POST['amount']." ".$poz.".");
							}
						}
					}
				}
			}

// specjalne opcje klanu
			if (isset ($_GET['step2']) && $_GET['step2'] == 'te') {
				if (isset($_GET['step3']) && $_GET['step3'] == 'hospass') {
					if ($mytribe -> fields['platinum'] < 100) {
						error ("Klan nie ma tyle sztuk mithrilu<br><a href=tribes.php?view=my&step=owner>..wroc</a>");
					} else {
							SqlExec("UPDATE tribes SET platinum=platinum-100 WHERE id=".$mytribe -> fields['id']);
						SqlExec("UPDATE tribes SET hospass='Y' WHERE id=".$mytribe -> fields['id']);
						$smarty -> assign ("Hospass1", 1);
					}
				}
				if ($mytribe -> fields['hospass'] == "Y") {
					error ("Klan posiada darmowe leczenie w szpitalu<br><a href=\"tribes.php?view=my&step=owner\">..wroc</a>");
				}
			}
		} else {
			$smarty -> assign ("Message2", "Nie masz prawa tutaj przebywac.");
		}
	}
}

// inicjalizacja zmiennych
if (!isset($_GET['join'])) {
	$_GET['join'] = '';
}
if (!isset($_GET['step'])) {
	$_GET['step'] = '';
}
if (!isset($_GET['step2'])) {
	$_GET['step2'] = '';
}
if (!isset($_GET['step3'])) {
	$_GET['step3'] = '';
}
if (!isset($_GET['daj'])) {
	$_GET['daj'] = '';
}
if (!isset($_GET['action'])) {
	$_GET['action'] = '';
}
if (!isset($_GET['view'])) {
	$_GET['view'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign( array("View" => $_GET['view'], "Join" => $_GET['join'], "Step" => $_GET['step'], "Step2" => $_GET['step2'], "Step3" => $_GET['step3'], "Give" => $_GET['daj'], "Action" => $_GET['action']));
$smarty -> display('tribes.tpl');

require_once("includes/foot.php");
?>
