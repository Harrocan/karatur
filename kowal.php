<?php
//@type: F
//@desc: Kowal
/**
*   Funkcje pliku:
*   Kuznia - wykonywanie przedmiotow - bron, zbroje, tarcze, helmy, nagolenniki, groty strzal
*
*   @name                 : kowal.php
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

$title="Kuznia";
require_once("includes/head.php");
require_once("includes/checkexp.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta' && $player -> location != 'Imnescar' && $player -> location != 'Iriaebor' && $player -> location != 'Asbravn') {
	error ("Zapomnij o tym");
}*/

if ($player -> przemiana > 0) {
	error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 
}

//$mineraly = $db -> Execute("SELECT copper, zelazo, wegiel, adam, meteo, krysztal FROM kopalnie WHERE gracz=".$player -> id);

if (isset ($_GET['kowal']) && $_GET['kowal'] == 'plany') {
	if (isset($_GET['dalej'])) {
	if ( !in_array( $_GET['dalej'], array( 'W','A','H','N','R','D' ) ) ) {
		//$_GET['dalej'] != 'W' && $_GET['dalej'] != 'A' && $_GET['dalej'] != 'H' && $_GET['dalej'] != 'N' && $_GET['dalej'] != 'R' && $_GET['dalej'] != 'R' && $_GET['dalej'] != 'D') {
		error ("Zapomnij o tym!");
	}
	$plany = $db -> Execute("SELECT * FROM kowal WHERE status='S' AND gracz=0 AND type='".$_GET['dalej']."' ORDER BY cena ASC");
	$arrname = array();
	$arrcost = array();
	$arrlevel = array();
	$arrid = array();
	$i = 0;
	while (!$plany -> EOF) {
		$arrname[$i] = $plany -> fields['nazwa'];
		$arrcost[$i] = $plany -> fields['cena'];
		$arrlevel[$i] = $plany -> fields['poziom'];
		$arrid[$i] = $plany -> fields['id'];
		$plany -> MoveNext();
		$i = $i + 1;
	}
	$plany -> Close();
	$smarty -> assign ( array("Name" => $arrname, "Cost" => $arrcost, "Level" => $arrlevel, "Id" => $arrid));
}
if (isset($_GET['buy'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
		error ("Zapomnij o tym.");
	}
	$plany = $db -> Execute("SELECT * FROM kowal WHERE id=".$_GET['buy']);
	if (!$plany -> fields['id']) {
		error ("Nie ma takiego planu. Wroc do <a href=kowal.php?kowal=plany>sklepu</a>.");
	}
	$test = SqlExec("SELECT id FROM kowal_plany WHERE pid={$player->id} AND plan={$plany->fields['id']}");
	if ($test -> fields['id']) {
		error ("Masz juz taki plan!");
	}
	$test -> Close();
	
	//if ($plany -> fields['status'] != 'S') {
	//	error ("Tutaj tego nie sprzedasz.");
	//}
	if ($plany -> fields['cena'] > $player -> gold) {
		error ("Nie stac cie!");
	}
	//$db -> Execute("INSERT INTO kowal (gracz, nazwa, cena, zelazo, wegiel, copper, status, poziom, mithril, adamant, meteor, krysztal, type) VALUES(".$player -> id.",'".$plany -> fields['nazwa']."',".$plany -> fields['cena'].",".$plany -> fields['zelazo'].",".$plany -> fields['wegiel'].",".$plany -> fields['copper'].",'N',".$plany -> fields['poziom'].",".$plany -> fields['mithril'].",".$plany -> fields['adamant'].",".$plany -> fields['meteor'].",".$plany -> fields['krysztal'].",'".$plany -> fields['type']."')") or error("Nie moge dodac planu.");
	//$db -> Execute("UPDATE players SET credits=credits-".$plany -> fields['cena']." WHERE id=".$player -> id);
	SqlExec( "INSERT INTO kowal_plany(pid,plan) VALUES({$player->id},{$plany->fields['id']})" );
	$player -> gold -= $plany -> fields['cena'];
	$smarty -> assign ( array("Cost" => $plany -> fields['cena'], "Plan" => $plany -> fields['nazwa']));
	$plany -> Close();
	}
}

if (isset ($_GET['kowal']) && $_GET['kowal'] == 'kuznia') {
	if (!isset($_GET['rob']) && !isset($_GET['konty'])) {
	//$robione = $db -> Execute("SELECT * FROM kowal_praca WHERE gracz=".$player -> id);
	//$smarty -> assign ("Maked", $robione -> fields['id']);
	//if (!$robione -> fields['id']) {
		if (isset($_GET['type'])) {
			if ( !in_array( $_GET['type'], array( 'W','A','H','N','R','D' ) ) ) {
				error ("Zapomnij o tym!");
			}
			$kuznia = SqlExec("SELECT k.* FROM kowal k JOIN kowal_plany p ON p.plan=k.id WHERE p.pid=".$player-> id." AND k.type='".$_GET['type']."' ORDER BY k.poziom ASC");
			$arrname = array();
			$arrid = array();
			$arrlevel = array();
			$arrcopper = array();
			$arriron = array();
			$arrcoal = array();
			$arrmith = array();
			$arradam = array();
			$arrmeteo = array();
			$arrcryst = array();
			$i = 0;
			while (!$kuznia -> EOF) {
				$arrname[$i] = $kuznia -> fields['nazwa'];
				$arrid[$i] = $kuznia -> fields['id'];
				$arrlevel[$i] = $kuznia -> fields['poziom'];
				$arrcopper[$i] = $kuznia -> fields['copper'];
				$arriron[$i] = $kuznia -> fields['zelazo'];
				$arrcoal[$i] = $kuznia -> fields['wegiel'];
				$arrmith[$i] = $kuznia -> fields['mithril'];
				$arradam[$i] = $kuznia -> fields['adamant'];
				$arrmeteo[$i] = $kuznia -> fields['meteor'];
				$arrcryst[$i] = $kuznia -> fields['krysztal'];
				$kuznia -> MoveNext();
				$i = $i + 1;
			}
			$kuznia -> Close();
			$smarty -> assign ( array("Name" => $arrname, "Id" => $arrid, "Level" => $arrlevel, "Copper" => $arrcopper, "Iron" => $arriron, "Coal" => $arrcoal, "Mithril" => $arrmith, "Adamantium" => $arradam, "Meteor" => $arrmeteo, "Crystal" => $arrcryst));
		}
	//} else {
	//	$procent = (($robione -> fields['u_energia'] / $robione -> fields['c_energia']) * 100);
	//	$procent = round($procent,"0");
	//	$need = ($robione -> fields['c_energia'] - $robione -> fields['u_energia']);
	//	$smarty -> assign ( array("Id" => $robione -> fields['id'], "Name" => $robione -> fields['nazwa'], "Percent" => $procent, "Need" => $need));
	//}
	//$robione -> Close();
}

//if (isset($_GET['ko'])) {
//	if ($player -> hp == 0) {
//		error ("Nie mozesz kuc poniewaz jestes martwy!");
//	}
//	if (!ereg("^[1-9][0-9]*$", $_GET['ko'])) {
//		error ("Zapomnij o tym.");
//	}
//	$robione = $db -> Execute("SELECT nazwa FROM kowal_praca WHERE id=".$_GET['ko']);
//	$smarty -> assign ( array("Link" => "kowal.php?kowal=kuznia&konty=".$_GET['ko'], "Name" => $robione -> fields['nazwa']));
//	$robione -> Close();
//}

if (isset($_GET['dalej'])) {
	if ($player -> hp == 0) {
		error ("Nie mozesz kuc poniewaz jestes martwy!");
	}
	if (!ereg("^[1-9][0-9]*$", $_GET['dalej'])) {
		error ("Zapomnij o tym.");
	}
	$kuznia = SqlExec("SELECT k.nazwa FROM kowal k JOIN kowal_plany p ON p.plan=k.id WHERE k.id={$_GET['dalej']} AND p.pid={$player->id}");
	if( empty( $kuznia -> fields['nazwa'] ) ) {
		error( "Nie posiadasz takiego planu !" );
	}
	$smarty -> assign ( array("Link" => "kowal.php?kowal=kuznia&rob=".$_GET['dalej'], "Name" => $kuznia -> fields['nazwa']));
	$kuznia -> Close();
}
/*
if (isset($_GET['konty'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['konty'])) {
		error ("Zapomnij o tym.");
	}
	$kont = $db -> Execute("SELECT * FROM kowal_praca WHERE id=".$_GET['konty']);
	$type = $db -> Execute("SELECT type, poziom, cena FROM kowal WHERE nazwa='".$kont -> fields['nazwa']."' AND gracz=0");
	if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
		error ("Zapomnij o tym");
	}
	if ($player -> energy < $_POST['razy']) {
		error ("Nie masz tyle energii.");
	}
	$need = ($kont -> fields['c_energia'] - $kont -> fields['u_energia']);
	if ($_POST['razy'] > $need) {
		error ("Nie mozesz przeznaczyc na przedmiot wiecej energii niz trzeba!");
	}
	if ($kont -> fields['gracz'] != $player -> id) {
		error ("Nie wykonujesz takiego przedmiotu!");
	}
	if ($player -> clas == 'Rzemieslnik') {
		$szansa = (($player -> smith * 100) + ($player -> level / 10));
	} else {
		$szansa = $player -> smith * 100;
	}
	if ($type -> fields['type'] != 'R') {
		$przedmiot1 = $db -> Execute("SELECT * FROM equipment WHERE name='".$kont -> fields['nazwa']."' AND owner=0") or error("Nie moge odczytac z bazy danych");
		$tmpname=$przedmiot1 -> fields['name'];
		$przedmiot = array('power' => $przedmiot1 -> fields['power'],'wt' => $przedmiot1 -> fields['wt'],'name' => $tmpname,'type' => $przedmiot1 -> fields['type'],'minlev' => $przedmiot1 -> fields['minlev'],'szyb' => $przedmiot1 -> fields['szyb'],'zr' => $przedmiot1 -> fields['zr'],'cost' => $przedmiot1 -> fields['cost'], 'twohand' => $przedmiot1 -> fields['twohand']);
		
		$przedmiot1 -> Close();
	} else {
		$power = ceil($type -> fields['poziom'] / 2);
		$cost = ceil($type -> fields['cena'] / 40);
		$przedmiot = array('power' => $power,'wt' => 10,'name' => $kont -> fields['nazwa'],'type' => 'G','minlev' => $type -> fields['poziom'],'szyb' => 0,'zr' => 0,'cost' => $cost);
	}
		$rpd = 0;
		if ($_POST['razy'] == $need) {
		$rzut = (rand(1,100) * $type -> fields['poziom']);
		if ($szansa >= $rzut) {
		$rzut2 = rand(1,100);
		if ($player -> clas == 'Rzemieslnik') {
			$bonus = ($player -> level / 10);
			if ($bonus > 50) {
				$bonus = 50;
			}
			$rzut2 = ($rzut2 + $bonus);
		}
		$sila = $przedmiot['power'];
		$zr = $przedmiot['zr'];
		$szyb = $przedmiot['szyb'];
		$wt = $przedmiot['wt'];
		if($przedmiot['name']='')
			$przedmiot['name']=$kont -> fields['nazwa'];
		$nazwa = $przedmiot['name'];
		if ($rzut2 >= 90 && $rzut2 < 95) {
				$bonus = ceil($player -> smith);
				$maxbonus = ($sila * 10);
			if ($bonus > $maxbonus) {
				$bonus = $maxbonus;
			}
			$sila =($przedmiot['power'] + $bonus);
			$rpd = ($przedmiot['minlev'] *100);
			if ($przedmiot['type'] == 'W') {
			$nazwa = "Smoczy ".$przedmiot['name'];
			}
			if ($przedmiot['type'] == 'A') {
			$nazwa = "Smocza ".$przedmiot['name'];
			}
			if ($przedmiot['type'] == 'H') {
			$nazwa = "Smoczy ".$przedmiot['name'];
			}
			if ($przedmiot['type'] == 'N') {
			$nazwa = "Smocze ".$przedmiot['name'];
			}
					if ($type -> fields['type'] == 'R') {
				$nazwa = "Smocze ".$przedmiot['name'];
			}
					if ($przedmiot['type'] == 'D') {
				$nazwa = "Smocza ".$przedmiot['name'];
			}
		}
		if ($rzut2 > 98) {
			if ($player -> clas == 'Rzemieslnik' && $type -> fields['type'] != 'R' && $przedmiot['type'] != 'D' && $przedmiot['type'] != 'H') {
				$bonus = ceil($player -> smith / 2);
					if ($przedmiot['type'] == 'W') {
					$maxbonus = ($szyb * 10);
				if ($maxbonus == 0) {
					$maxbonus = 10;
				}
					if ($bonus > $maxbonus) {
						$bonus = $maxbonus;
					}
				$szyb = $szyb + $bonus;
				$nazwa = "Elfi ".$przedmiot['name'];
				}
				if ($przedmiot['type'] == 'A') {
					$maxbonus = ($zr * 10);
				if ($maxbonus == 0) {
					$maxbonus = 10;
				}
					if ($bonus > $maxbonus) {
						$bonus = $maxbonus;
					}
				$zr = $zr - $bonus;
				$nazwa = "Elfia ".$przedmiot['name'];
				}
				if ($przedmiot['type'] == 'N') {
					$maxbonus = ($zr * 10);
				if ($maxbonus == 0) {
					$maxbonus = 10;
				}
					if ($bonus > $maxbonus) {
						$bonus = $maxbonus;
					}
				$zr = $zr - $bonus;
				$nazwa = "Elfie ".$przedmiot['name'];
				}
				$rpd = ($rpd + ($przedmiot['minlev'] * 200));
			} else {
				$rpd = ($rpd + $przedmiot['minlev']);
			}
		}
		if ($rzut2 > 94 && $rzut2 < 99) {
			if ($player -> clas == 'Rzemieslnik' && $type -> fields['type'] != 'R') {
					$bonus = ceil($player -> smith);
					$maxbonus = ($wt * 10);
				if ($maxbonus == 0) {
				$maxbonus = 10;
				}
				if ($bonus > $maxbonus) {
					$bonus = $maxbonus;
				}
				$wt = ($wt + $bonus);
				$rpd = ($przedmiot['minlev'] * 150);
				if ($przedmiot['type'] == 'W') {
				$nazwa = "Krasnoludzki ".$przedmiot['name'];
				}
				if ($przedmiot['type'] == 'A') {
				$nazwa = "Krasnoludzka ".$przedmiot['name'];
				}
				if ($przedmiot['type'] == 'H') {
				$nazwa = "Krasnoludzki ".$przedmiot['name'];
				}
				if ($przedmiot['type'] == 'N') {
				$nazwa = "Krasnoludzkie ".$przedmiot['name'];
				}
						if ($przedmiot['type'] == 'D') {
					$nazwa = "Krasnoludzka ".$przedmiot['name'];
				}
			} else {
				$rpd = ($rpd + $przedmiot['minlev']);
			}
		}
		if ($rzut2 < 90) {
			$rpd = $przedmiot['minlev'];
		}
		$rum = ($przedmiot['minlev'] / 100);
		$cena = ($przedmiot['cost'] / 20);
		if ($player -> clas == 'Rzemieslnik') {
			$rpd = $rpd * 2;
			$rum = $rum * 2;
		}
		if ($type -> fields['type'] != 'R') {
			$blee="SELECT id FROM equipment WHERE name='".$nazwa."' AND wt=".$wt." AND type='".$przedmiot['type']."' AND status='U' AND owner=".$player -> id." AND power=".$sila." AND zr=".$zr." AND szyb=".$szyb." AND maxwt=".$wt." AND poison=0";
			$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$kont -> fields['nazwa']."' AND wt=".$wt." AND type='".$przedmiot['type']."' AND status='U' AND owner=".$player -> id." AND power=".$sila." AND zr=".$zr." AND szyb=".$szyb." AND maxwt=".$wt." AND poison=0");
			if (!$test -> fields['id']) {
				$blee="INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$kont -> fields['nazwa']."',".$sila.",'".$przedmiot['type']."',".$cena.",".$zr.",".$wt.",".$przedmiot['minlev'].",".$wt.",1,'N',0,".$szyb.",'".$przedmiot['twohand']."')";
				$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$kont -> fields['nazwa']."',".$sila.",'".$przedmiot['type']."',".$cena.",".$zr.",".$wt.",".$przedmiot['minlev'].",".$wt.",1,'N',0,".$szyb.",'".$przedmiot['twohand']."')") or error("nie moge dodac bleee ! ".$blee." : ".$kont -> fields['nazwa']);
			} else {
				$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
			}
			$test -> Close();
		} else {
			$test = $db -> Execute("SELECT id FROM equipment WHERE owner=".$player -> id." AND name='".$nazwa."' AND power=".$sila." AND status='U'");
			if (!$test -> fields['id']) {
				$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, status, minlev, wt) VALUES(".$player -> id.",'".$nazwa."',".$sila.",'".$przedmiot['type']."',".$przedmiot['cost'].",'U',".$przedmiot['minlev'].",".$wt.")") or die("Nie moge dodac grotow.");
			} else {
			$db -> Execute("UPDATE equipment SET wt=wt+".$przedmiot['wt']." WHERE id=".$test -> fields['id']);
			$db -> Execute("UPDATE equipment SET cost=cost+".$przedmiot['cost']." WHERE id=".$test -> fields['id']);
			}
		}
		$smarty -> assign ("Message", "Wykonales <b>".$kont -> fields['nazwa']."</b>. Zdobywasz <b>".$rpd."</b> PD oraz <b>".$rum."</b> poziomu w umiejetnosci Kowalstwo.<br>");
		} else {
		$rum = 0.01;
		$rpd = 0;
		$smarty -> assign ("Message", "Probowales wykonac <b>".$kont -> fields['nazwa']."</b>, niestety nie udalo sie. Zdobywasz <b>".$rum."</b> poziomu w umiejetnosci Kowalstwo.<br>");
		}
		$db -> Execute("DELETE FROM kowal_praca WHERE gracz=".$player -> id);
			checkexp($player -> exp,$rpd,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'ability',$rum);
	} else {
		$uenergia = ($_POST['razy'] + $kont -> fields['u_energia']);
		$procent = (($uenergia / $kont -> fields['c_energia']) * 100);
		$procent = round($procent,"0");
		$need = $kont -> fields['c_energia'] - $uenergia;
		$db -> Execute("UPDATE kowal_praca SET u_energia=u_energia+".$_POST['razy']." WHERE gracz=".$player -> id);
		$smarty -> assign ("Message", "Poswieciles na wykonanie ".$kont -> fields['nazwa']." kolejne ".$_POST['razy']." energii. Teraz jest on wykonany w ".$procent." procentach. Aby go ukonczyc potrzebujesz ".$need." energii.");
	}
	$db -> Execute("UPDATE players SET energy=energy-".$_POST['razy']." WHERE id=".$player -> id);
}
*/
	
if (isset($_GET['rob'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['rob'])) {
		error ("Zapomnij o tym.");
	}
	if ( !isset( $_POST['razy'] ) ) {
		error("Podaj ile przedmiotow chcesz wykonac!");
	}
	if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
		error ("Zapomnij o tym");
	}
	$kuznia = SqlExec( "SELECT k.* FROM kowal k JOIN kowal_plany p ON p.plan=k.id WHERE k.id={$_GET['rob']} AND p.pid={$player->id}" );
	//print_r( $kuznia );
	$lostenergy = $_POST['razy'] * $kuznia -> fields['poziom'];
	if( $player -> energy < $lostenergy ) {
		error( "Masz za malo energii ! Potrzeba $lostenergy !" );
	}
	$ilosc = intval( $_POST['razy'] );
	if ($ilosc >= 1) {
		$rcopper = ($ilosc * $kuznia -> fields['copper']);
		$rzelazo = ($ilosc * $kuznia -> fields['zelazo']);
		$rwegiel = ($ilosc * $kuznia -> fields['wegiel']);
		$rmithril = ($ilosc * $kuznia -> fields['mithril']);
		$radam = ($ilosc * $kuznia -> fields['adamant']);
		$rmeteo = ($ilosc * $kuznia -> fields['meteor']);
		$rkrysztal = ($ilosc * $kuznia -> fields['krysztal']);
	} else {
		error( "Podaj ile razy chcesz wykonac przedmiot !" );
	}
	if ( $player -> copper < $rcopper ||
		$player -> iron < $rzelazo ||
		$player -> coal < $rwegiel ||
		$player -> mithril < $rmithril ||
		$player -> adamantium < $radam ||
		$player -> meteor < $rmeteo ||
		$player -> crystal < $rkrysztal )
	{
		error ("Nie masz tylu materialow!");
	}
	if ($player -> energy < $_POST['razy']) {
		error ("Nie masz tyle energii.");
	}
	if ( empty( $kuznia -> fields['id'] ) ) {
		error ("Nie twoj plan!");
	}
	if ($player -> clas == 'Rzemieslnik') {
		$szansa = ( ( $player -> smith * 100 ) + ( $player -> level / 10 ) );
	} else {
		$szansa = $player -> smith * 100;
	}
	$rprzedmiot = 0;
	$rpd = 0;
	$rum = 0;
	//if ($kuznia -> fields['type'] != 'R') {
		$przedmiot1 = SqlExec("SELECT * FROM items WHERE name='".$kuznia -> fields['nazwa']."'");
		$przedmiot1 = $przedmiot1 -> GetArray();
		//echo "SELECT * FROM items WHERE name='".$kuznia -> fields['nazwa']."'";
		//var_dump( $przedmiot1 );
		$przedmiot1 = array_shift( $przedmiot1 );
		if( empty( $przedmiot1 ) ) {
			error( "W bazie przedmiotow nie ma <b>{$kuznia -> fields['nazwa']}</b> !!" );
		}
		//$przedmiot = array('power' => $przedmiot1 -> fields['power'],'wt' => $przedmiot1 -> fields['wt'],'name' => $przedmiot1 -> fields['name'],'type' => $przedmiot1 -> fields['type'],'minlev' => $przedmiot1 -> fields['minlev'],'szyb' => $przedmiot1 -> fields['szyb'],'zr' => $przedmiot1 -> fields['zr'],'cost' => $przedmiot1 -> fields['cost'], 'twohand' => $przedmiot1 -> fields['twohand']);
		//$przedmiot1 -> Close();
	//} else {
	//	$power = ceil($kuznia -> fields['poziom'] / 2);
	//	$cost = ceil($kuznia -> fields['cena'] / 20);
	//	$przedmiot1['name'] = $kuznia -> fields['nazwa'];
	//	$przedmiot1['status'] = 'U';
	//	$przedmiot1['power'] = $power;
	//	$przedmiot1['wt'] = 10;
	//	$przedmiot1['maxwt'] = 10;
	//	$przedmiot1['magic'] = 'N';
	//	$przedmiot1['poison'] = 0;
	//	$przedmiot1['twohand'] = 'N';
	//	$przedmiot1['imagenum'] = 0;
	//	$przedmiot1['prefix'] = '';
	//	$przedmiot1['type'] = 'G';
	//	$przedmiot1['minlev'] = $kuznia -> fields['poziom'];
	//	$przedmiot1['szyb'] = 0;
	//	$przedmiot1['zr'] = 0;
	//	$przedmiot1['cost'] = $cost;
	//	$przedmiot1['amount'] = 1;
		//$przedmiot = array('power' => $power,'wt' => 10,'name' => $kuznia -> fields['nazwa'],'type' => 'G','minlev' => $kuznia -> fields['poziom'],'szyb' => 0,'zr' => 0,'cost' => $cost);
	//}
	//echo $lostenergy;
	//print_r( $przedmiot1 );
	//print_r( $kuznia -> GetArray() );
	//error( "" );
	if ($ilosc > 0) {
		for ($i=1;$i<=$ilosc;$i++) {
			$przedmiot = $przedmiot1;
			//print_r( $przedmiot1 );
			$sila = $przedmiot['power'];
			$zr = $przedmiot['zr'];
			$szyb = $przedmiot['szyb'];
			$wt = $przedmiot['wt'];
			$rzut = (rand(1,100) * $kuznia -> fields['poziom']);
			if ($szansa >= $rzut) {
				
				$rzut2 = rand(1,100);
				if ($player -> clas == 'Rzemieslnik') {
					$bonus = ($player -> level / 10);
					if ($bonus > 50) {
						$bonus = 50;
					}
					$rzut2 = ($rzut2 + $bonus);
				}
				$sila = $przedmiot['power'];
				$zr = $przedmiot['zr'];
				$szyb = $przedmiot['szyb'];
				$wt = $przedmiot['wt'];
				//if($przedmiot['name']='') {
				//	$przedmiot['name']=$kuznia -> fields['nazwa'];
				//}
				$nazwa = $przedmiot['name'];
				$prefix = "";
				if ($rzut2 >= 90 && $rzut2 < 95) {
					$bonus = ceil($player -> smith);
					$maxbonus = ($sila * 10);
					if ($bonus > $maxbonus) {
						$bonus = $maxbonus;
					}
					$sila =($przedmiot['power'] + $bonus);
					$rpd = ($rpd + ($przedmiot['minlev'] * 100));
					if ($przedmiot['type'] == 'W') {
						$prefix = "Smoczy ";
					}
					if ($przedmiot['type'] == 'A') {
						$prefix = "Smocza ";
					}
					if ($przedmiot['type'] == 'H') {
						$prefix = "Smoczy ";
					}
					if ($przedmiot['type'] == 'N') {
						$prefix = "Smocze ";
					}
					if ($kuznia -> fields['type'] == 'G') {
						$prefix = "Smocze ";
					}
					if ($przedmiot['type'] == 'D') {
						$prefix = "Smocza ";
					}
				}
				if ($rzut2 > 98) {
					if ($player -> clas == 'Rzemieslnik' && $kuznia -> fields['type'] != 'G' && $kuznia -> fields['type'] != 'D' && $kuznia -> fields['type'] != 'H') {
						$bonus = ceil($player -> smith / 2);
						if ($przedmiot['type'] == 'W') {
							$maxbonus = ($szyb * 10);
							if ($maxbonus == 0) {
								$maxbonus = 10;
							}
							if ($bonus > $maxbonus) {
								$bonus = $maxbonus;
							}
							$szyb = $szyb + $bonus;
							$prefix = "Elfi ";
						}
						if ($przedmiot['type'] == 'A') {
							$maxbonus = ($zr * 10);
							if ($maxbonus == 0) {
								$maxbonus = 10;
							}
							if ($bonus > $maxbonus) {
								$bonus = $maxbonus;
							}
							$zr = $zr - $bonus;
							$prefix = "Elfia ";
						}
						if ($przedmiot['type'] == 'N') {
							$maxbonus = ($zr * 10);
							if ($maxbonus == 0) {
								$maxbonus = 10;
							}
							if ($bonus > $maxbonus) {
								$bonus = $maxbonus;
							}
							$zr = $zr - $bonus;
							
							$prefix = "Elfie ";
						}
						if( $zr < 0 ) {
							$zr = 0;
						}
						$rpd = ($rpd + ($przedmiot['minlev'] * 200));
					} else {
						$rpd = ($rpd + $przedmiot['minlev']);
					}
				}
				if ($rzut2 > 94 && $rzut2 < 99) {
					if ($player -> clas == 'Rzemieslnik' && $kuznia -> fields['type'] != 'G') {
						$bonus = $player -> smith;
						$maxbonus = ($wt * 10);
						if ($maxbonus == 0) {
							$maxbonus = 10;
						}
						if ($bonus > $maxbonus) {
							$bonus = $maxbonus;
						}
						$wt = ($wt + $bonus);
						$rpd = ($rpd + ($przedmiot['minlev'] *150));
						if ($przedmiot['type'] == 'W') {
							$prefix = "Krasnoludzki ";
						}
						if ($przedmiot['type'] == 'A') {
							$prefix = "Krasnoludzka ";
						}
						if ($przedmiot['type'] == 'H') {
							$prefix = "Krasnoludzki ";
						}
						if ($przedmiot ['type'] == 'N') {
							$prefix = "Krasnoludzkie ";
						}
						if ($przedmiot['type'] == 'D') {
							$prefix = "Krasnoludzka ";
						}
					} else {
						$rpd = ($rpd + $przedmiot['minlev']);
					}
				}
				if($nazwa='')
					$nazwa='noname';
				if ($rzut2 < 90) {
					$rpd = ($rpd + ($przedmiot['minlev']));
				}
				
				if ($zr>0)
				{
					$zr=0;
				}
				
				$przedmiot = $przedmiot1;
				$rprzedmiot = ($rprzedmiot + 1);
				$rum = ($rum + ($kuznia -> fields['poziom'] / 100));
				$cena = ($przedmiot['cost'] / 20);
				$przedmiot['wt'] = round($wt);
				$przedmiot['status'] = 'U';
				$przedmiot['power'] = $sila;
				$przedmiot['zr'] = $zr;
				$przedmiot['szyb'] = $szyb;
				$przedmiot['maxwt'] = round( $wt );
				$przedmiot['prefix'] = $prefix;
				if( $kuznia -> fields['type'] != 'G' ) {
					$przedmiot['cost'] = round( $cena );
				}
				//print_r( $przedmiot ) ;
				//error( "pokaz mi tekst powyzej rakmi na karczmie !");
				if( $player -> EquipAdd( $przedmiot ) === FALSE ) {
					error( "Blad podczas dodawania przedmiotu !" );
				}
				unset( $przedmiot );
				//echo "<pre>";
				//print_r( $przedmiot );
				//print_r( $kuznia -> GetArray() );
				//print_r( $GLOBALS );
				//echo "</pre>";
				//error( "" );
				//if ($kuznia -> fields['type'] != 'R') {
				//	$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$kuznia -> fields['nazwa']."' AND wt=".$wt." AND type='".$przedmiot['type']."' AND status='U' AND owner=".$player -> id." AND power=".$sila." AND zr=".$zr." AND szyb=".$szyb." AND maxwt=".$wt." AND poison=0 AND cost=".$cena);
				//	if (!$test -> fields['id']) {
				//		$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$kuznia -> fields['nazwa']."',".$sila.",'".$przedmiot['type']."',".$cena.",".$zr.",".$wt.",".$przedmiot['minlev'].",".$wt.",1,'N',0,".$szyb.",'".$przedmiot['twohand']."')") or error("nie moge dodac!".$blee." : ".$przedmiot['name']);
				//	} else {
				//		$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
				//	}
				//	$test -> Close();
				//} else {
				//	$test = $db -> Execute("SELECT id FROM equipment WHERE owner=".$player -> id." AND name='".$nazwa."' AND power=".$sila." AND status='U'");
				//	if (!$test -> fields['id']) {
				//		$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, status, minlev, wt) VALUES(".$player -> id.",'".$kuznia -> fields['nazwa']."',".$sila.",'".$przedmiot['type']."',".$przedmiot['cost'].",'U',".$przedmiot['minlev'].",".$wt.")") or error("Nie moge dodac grotow.");
				//	} else {
				//		$db -> Execute("UPDATE equipment SET wt=wt+".$przedmiot['wt']." WHERE id=".$test -> fields['id']);
				//		$db -> Execute("UPDATE equipment SET cost=cost+".$przedmiot['cost']." WHERE id=".$test -> fields['id']);
				//	}
				//}
			} else {
				$rum = ($rum + 0.01);
			}
		}
		if ($player -> clas == 'Rzemieslnik') {
			$rpd = $rpd * 2;
			$rum = $rum * 2;
		}
		$smarty -> assign ("Message", "Wykonales <b>".$kuznia -> fields['nazwa']."</b> <b>".$rprzedmiot."</b> razy. Zdobywasz <b>".$rpd."</b> PD oraz <b>".$rum."</b> poziomu w umiejetnosci Kowalstwo.<br>");
		$player -> AwardExp( $rpd );
		$player -> smith += $rum;
		//checkexp($player -> exp,$rpd,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'ability',$rum);
	} else {
		error( "Cos dziwnego zaszlo ! Poinformuj Architekta ze tu trafiles !" );
	//	$procent = (($_POST['razy'] / $kuznia -> fields['poziom']) * 100);
	//	$procent = round($procent,"0");
	//	$need = ($kuznia -> fields['poziom'] - $_POST['razy']);
	//	$db -> Execute("INSERT INTO kowal_praca (gracz, nazwa, u_energia, c_energia) VALUES(".$player -> id.",'".$kuznia -> fields['nazwa']."',".$_POST['razy'].",".$kuznia -> fields['poziom'].")") or error("nie moge dodac przedmiotu");
	//	$smarty -> assign ("Message", "Pracowales nad ".$kuznia -> fields['nazwa'].", zuzywajac ".$_POST['razy']." energii i wykonales go w ".$procent." procentach. Aby ukonczyc przedmiot potrzebujesz jeszcze ".$need." energii.");
	}
	if( $rcopper > 0 )
		$player -> copper -= $rcopper;
	if( $rzelazo > 0 )
		$player -> iron -= $rzelazo;
	if( $rwegiel > 0 )
		$player -> coal -= $rwegiel;
	if( $rmithril > 0 )
		$player -> mithril -= $rmithril;
	if( $radam > 0 )
		$player -> adamantium -= $radam;
	if( $rmeteo > 0 )
		$player -> meteor -= $rmeteo;
	if( $rkrysztal > 0 )
		$player -> crystal -= $rkrysztal;
	$player -> energy -= $lostenergy;
	//$db -> Execute("UPDATE kopalnie SET copper=copper-".$rcopper." WHERE gracz=".$player -> id);
	//$db -> Execute("UPDATE kopalnie SET zelazo=zelazo-".$rzelazo." WHERE gracz=".$player -> id);
	//$db -> Execute("UPDATE kopalnie SET wegiel=wegiel-".$rwegiel." WHERE gracz=".$player -> id);
	//$db -> Execute("UPDATE players SET platinum=platinum-".$rmithril." WHERE id=".$player -> id);
	//$db -> Execute("UPDATE kopalnie SET adam=adam-".$radam." WHERE gracz=".$player -> id);
	//$db -> Execute("UPDATE kopalnie SET meteo=meteo-".$rmeteo." WHERE gracz=".$player -> id);
	//$db -> Execute("UPDATE kopalnie SET krysztal=krysztal-".$rkrysztal." WHERE gracz=".$player -> id);
	//$db -> Execute("UPDATE players SET energy=energy-".$_POST['razy']." WHERE id=".$player -> id);
	}
}

//inicjalizacja zmiennnych
if (!isset($_GET['kowal'])) {
	$_GET['kowal'] = '';
}
if (!isset($_GET['dalej'])) {
	$_GET['dalej'] = '';
}
if (!isset($_GET['buy'])) {
	$_GET['buy'] = '';
}
if (!isset($_GET['rob'])) {
	$_GET['rob'] = '';
}
if (!isset($_GET['konty'])) {
	$_GET['konty'] = '';
}
if (!isset($_GET['type'])) {
	$_GET['type'] = '';
}
if (!isset($_GET['ko'])) {
	$_GET['ko'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array( "Smith" => $_GET['kowal'],
							"Next" => $_GET['dalej'],
							"Buy" => $_GET['buy'],
							"Make" => $_GET['rob'],
							"Continue" => $_GET['konty'],
							"Type" => $_GET['type'],
							"Cont" => $_GET['ko'] ) );

$smarty -> display ('kowal.tpl');

require_once("includes/foot.php");
?>
