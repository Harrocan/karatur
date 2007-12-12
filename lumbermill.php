<?php
//@type: F
//@desc: Tartak
/**
*   Funkcje pliku:
*   Tartak - wykonywanie lukow oraz strzal
*
*   @name                 : lumbermill.php                            
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

$title="Tartak";
require_once("includes/head.php");
require_once('includes/checkexp.php');

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Beregost' && $player -> location != 'Eshpurta' && $player -> location != 'Proskur' && $player -> location != 'Iriaebor') {
	error ("Zapomnij o tym");
}*/

if ($player -> przemiana > 0) {
	error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!");
}

// inicjalizacja zmiennej
$smarty -> assign("Maked", '');

//$mineraly = $db -> Execute("SELECT lumber FROM kopalnie WHERE gracz=".$player-> id);

if (isset ($_GET['mill']) && $_GET['mill'] == 'plany') {
//"SELECT * FROM kowal WHERE status='S' AND gracz=0 AND type='".$_GET['dalej']."' ORDER BY cena ASC");
	$plany = SqlExec("SELECT * FROM mill WHERE status='S' AND owner=0 ORDER BY level ASC");
	$arrname = array();
	$arrcost = array();
	$arrlevel = array();
	$arrid = array();
	$i = 0;
	while (!$plany -> EOF) {
		$arrname[$i] = $plany -> fields['name'];
		$arrcost[$i] = $plany -> fields['cost'];
		$arrlevel[$i] = $plany -> fields['level'];
		$arrid[$i] = $plany -> fields['id'];
	$plany -> MoveNext();
		$i = $i + 1;
	}
	$plany -> Close();
	$smarty -> assign ( array("Name" => $arrname, "Cost" => $arrcost, "Level" => $arrlevel, "Planid" => $arrid));
	
	if (isset($_GET['buy'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
			error ("Zapomnij o tym.");
		}
		$plany = SqlExec("SELECT * FROM mill WHERE id=".$_GET['buy']);
		$test = SqlExec("SELECT id FROM mill_plany WHERE pid={$player->id} AND plan={$_GET['buy']}");
		if ($test -> fields['id']) {
			error ("Masz juz taki plan!");
		}
		$test -> Close();
		if (!$plany -> fields['id']) {
			error ("Nie ma takiego planu. Wroc do <a href=lumbermill.php?mill=plany>sklepu</a>.");
		}
		//if ($plany -> fields['status'] != 'S') {
		//	error ("Tutaj tego nie sprzedasz.");
		//}
		if ($plany -> fields['cost'] > $player -> gold) {
			error ("Nie stac cie!");
		}
		SqlExec( "INSERT INTO mill_plany(pid,plan) VALUES({$player->id},{$plany->fields['id']})" );
		//$db -> Execute("INSERT INTO mill (owner, name, cost, lumber, status, level, type, abronze, airon, asteel, amith, aadam, ameteo, acryst) VALUES(".$player -> id.",'".$plany -> fields['name']."',".$plany -> fields['cost'].",".$plany -> fields['lumber'].",'N',".$plany -> fields['level'].",'".$plany -> fields['type']."',".$plany -> fields['abronze'].",".$plany -> fields['airon'].",".$plany -> fields['asteel'].",".$plany -> fields['amith'].",".$plany -> fields['aadam'].",".$plany -> fields['ameteo'].",".$plany -> fields['acryst'].")") or error("Nie moge dodac planu.");
		//$db -> Execute("UPDATE players SET credits=credits-".$plany -> fields['cost']." WHERE id=".$player -> id);
		$player -> gold -= $plany->fields['cost'];
		$smarty -> assign ( array("Cost1" => $plany -> fields['cost'], "Name1" => $plany -> fields['name']));
		$plany -> Close();
	}
}
if (isset ($_GET['mill']) && $_GET['mill'] == 'mill') {
	if (!isset($_GET['rob']) && !isset($_GET['konty'])) {
		//$robione = $db -> Execute("SELECT * FROM mill_work WHERE gracz=".$player -> id);
		//if (!$robione -> fields['id']) {
			$kuznia = SqlExec("SELECT m.* FROM mill m JOIN mill_plany p ON p.plan=m.id WHERE p.pid={$player->id} ORDER BY m.level ASC");
			$arrid = array();
			$arrname = array();
			$arrlevel = array();
			$arrlumber = array();
			$i = 0;
			while (!$kuznia -> EOF) {
				$arrid[$i] = $kuznia -> fields['id'];
				$arrname[$i] = $kuznia -> fields['name'];
				$arrlevel[$i] = $kuznia -> fields['level'];
				$arrlumber[$i] = $kuznia -> fields['lumber'];
			$kuznia -> MoveNext();
				$i = $i + 1;
			}
			$kuznia -> Close();
			$smarty -> assign ( array("Name" => $arrname, "Planid" => $arrid, "Level" => $arrlevel, "Lumber" => $arrlumber));
		//} else {
		//	$procent = (($robione -> fields['u_energia'] / $robione -> fields['c_energia']) * 100);
		//	$procent = round($procent,"0");
		//	$need = ($robione -> fields['c_energia'] - $robione -> fields['u_energia']);
		//	$smarty -> assign ( array("Maked" => 1, "Planid" => $robione -> fields['id'], "Name" => $robione -> fields['nazwa'], "Percent" => $procent, "Need" => $need));
		//}
		//$robione -> Close();
	}
	if (isset($_GET['ko'])) {
// 		if ($player -> hp == 0) {
// 			error ("Nie mozesz kuc poniewaz jestes martwy!");
// 		}
// 		if (!ereg("^[1-9][0-9]*$", $_GET['ko'])) {
// 			error ("Zapomnij o tym.");
// 		}
// 		$robione = $db -> Execute("SELECT nazwa FROM mill_work WHERE id=".$_GET['ko']);
// 		$smarty -> assign ( array("Id" => $_GET['ko'], "Name" => $robione -> fields['nazwa']));
// 		$robione -> Close();
	}
	if (isset($_GET['dalej'])) {
		if ($player -> hp == 0) {
			error ("Nie mozesz kuc poniewaz jestes martwy!");
		}
		if (!ereg("^[1-9][0-9]*$", $_GET['dalej'])) {
			error ("Zapomnij o tym.");
		}
		$kuznia = SqlExec("SELECT m.* FROM mill m JOIN mill_plany p ON p.plan=m.id WHERE m.id={$_GET['dalej']} AND p.pid={$player->id}");
		if( empty( $kuznia -> fields['id'] ) ) {
			error( "Nie masz takiego planu !" );
		}
		$smarty -> assign ( array("Id" => $_GET['dalej'], "Name" => $kuznia -> fields['name'], "Type" => $kuznia -> fields['type']));
		
		if ($kuznia -> fields['type'] == 'R') {
			$arrarrows = array('abronze','airon','asteel','amith','aadam','ameteo','acryst');
			$arrname = array('%miedzi','%zelaza','%stali','%mithrilu','%adamantium','%meteoru','%krysztalu');
			for ($i=0;$i<7;$i++) {
					$gro = $arrarrows[$i];
					if ($kuznia -> fields[$gro] > 0) {
						$name = $arrname[$i];
						$item = $db -> Execute("SELECT id, name, power, wt,amount FROM equipment WHERE name like '".$name."' AND owner=".$player -> id." AND type='G'");
					}
				}
				$arrid = array();
				$arrname = array();
				$arrpower = array();
				$arrdur = array();
				$i = 0;
				while (!$item -> EOF) {
					$arrid[$i] = $item -> fields['id'];
					$arrname[$i] = $item -> fields['name'];
					$arrpower[$i] = $item -> fields['power'];
					$arrdur[$i] = $item -> fields['amount'];
					$item -> MoveNext();
					$i = $i + 1;
				}
			$item -> Close();
			$kuznia -> Close();
			$smarty -> assign ( array("Itemid" => $arrid, "Name1" => $arrname, "Power" => $arrpower, "Amount" => $arrdur));
		}
	}
// 	if (isset($_GET['konty'])) {
// 	if (!ereg("^[1-9][0-9]*$", $_GET['konty'])) {
// 		error ("Zapomnij o tym.");
// 	}
// 	$kont = $db -> Execute("SELECT * FROM mill_work WHERE id=".$_GET['konty']);
// 	$type = $db -> Execute("SELECT type, level FROM mill WHERE name='".$kont -> fields['nazwa']."' AND owner=0");
// 	if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
// 		error ("Zapomnij o tym");
// 	}
// 	if ($player -> energy < $_POST['razy']) {
// 		error ("Nie masz tyle energii.");
// 	}
// 	$need = ($kont -> fields['c_energia'] - $kont -> fields['u_energia']);
// 	if ($_POST['razy'] > $need) {
// 		error ("Nie mozesz przeznaczyc na przedmiot wiecej energii niz trzeba!");
// 	}
// 	if ($kont -> fields['gracz'] != $player -> id) {
// 		error ("Nie wykonujesz takiego przedmiotu!");
// 	}
// 	if ($player -> clas == 'Rzemieslnik') {
// 		$szansa = (($player -> fletcher * 100) + ($player -> level / 10));
// 	} else {
// 		$szansa = $player -> fletcher * 100;
// 	}
// 		$przedmiot = $db -> Execute("SELECT * FROM bows WHERE name='".$kont -> fields['nazwa']."'") or error("Nie moge odczytac z bazy danych");
// 		if ($_POST['razy'] == $need) {
// 		$rzut = (rand(1,100) * $type -> fields['level']);
// 		if ($szansa >= $rzut) {
// 		$rzut2 = rand(1,100);
// 		if ($player -> clas == 'Rzemieslnik') {
// 			$bonus = ($player -> level / 10);
// 			if ($bonus > 50) {
// 				$bonus = 50;
// 			}
// 			$rzut2 = ($rzut2 + $bonus);
// 		}
// 		$sila = $przedmiot -> fields['power'];
// 		$szyb = $przedmiot -> fields['szyb'];
// 		$wt = $przedmiot -> fields['maxwt'];
// 		$nazwa = $przedmiot -> fields['name'];
// 		if ($rzut2 >= 90 && $rzut2 < 95) {
// 			$bonus = ceil($player -> fletcher);
// 			$maxbonus = ($sila * 10);
// 			if ($bonus > $maxbonus) {
// 				$bonus = $maxbonus;
// 			}
// 			$sila = ($sila + $bonus);
// 			$rpd = ($przedmiot -> fields['minlev'] *100);
// 			if ($przedmiot -> fields['type'] == 'B') {
// 			$nazwa = "Smoczy ".$przedmiot -> fields['name'];
// 			}
// 					if ($type -> fields['type'] == 'R') {
// 				$nazwa = "Smocze ".$przedmiot -> fields['name'];
// 			}
// 		}
// 		if ($rzut2 > 98 && $player -> clas == 'Rzemieslnik' && $type -> fields['type'] != 'R') {
// 			$bonus = ceil($player -> fletcher / 2);
// 			if ($przedmiot -> fields['type'] == 'B') {
// 				$maxbonus = ($szyb * 10);
// 			if ($maxbonus == 0) {
// 				$maxbonus = 10;
// 			}
// 			if ($bonus > $maxbonus) {
// 					$bonus = $maxbonus;
// 				}
// 			$szyb = $szyb + $bonus;
// 			$nazwa = "Elfi ".$przedmiot -> fields['name'];
// 			}
// 			$rpd = ($rpd + ($przedmiot -> fields['minlev'] * 200));
// 		}
// 		if ($rzut2 > 94 && $rzut2 < 99 && $player -> clas == 'Rzemieslnik' && $type -> fields['type'] != 'R') {
// 			$bonus = ceil($player -> fletcher);
// 			$maxbonus = ($wt * 10);
// 			if ($maxbonus == 0) {
// 			$maxbonus = 10;
// 			}
// 			if ($bonus > $maxbonus) {
// 				$bonus = $maxbonus;
// 			}
// 			$wt = ($wt + $bonus);
// 			$rpd = ($przedmiot -> fields['minlev'] * 150);
// 			if ($przedmiot -> fields['type'] == 'B') {
// 			$nazwa = "Krasnoludzki ".$przedmiot -> fields['name'];
// 			}
// 		}
// 		if ($rzut2 < 90) {
// 			$rpd = $przedmiot -> fields['minlev'];
// 		}
// 		if ($type -> fields['type'] == 'R' && $konty -> fields['power'] > $przedmiot -> fields['power']) {
// 			$sila = $sila + $konty -> fields['power'];
// 			$nazwa = "Smocze ".$przedmiot -> fields['name'];
// 		}
// 		$rum = ($przedmiot -> fields['minlev'] / 100);
// 		$cena = ($przedmiot -> fields['cost'] / 20);
// 		if ($type -> fields['type'] != 'R') {
// 					$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$nazwa."' AND wt=".$wt." AND type='".$przedmiot -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$sila." AND zr=".$przedmiot -> fields['zr']." AND szyb=".$szyb." AND maxwt=".$wt." AND poison=0 AND cost=".$cena);
// 					if (!$test -> fields['id']) {
// 						$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$nazwa."',".$sila.",'".$przedmiot -> fields['type']."',".$cena.",".$przedmiot -> fields['zr'].",".$wt.",".$przedmiot -> fields['minlev'].",".$wt.",1,'N',0,".$szyb.",'Y')") or error("nie moge dodac!");
// 					} else {
// 						$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
// 					}
// 			$test -> Close();
// 				} else {
// 			$test = $db -> Execute("SELECT id FROM equipment WHERE owner=".$player -> id." AND name='".$nazwa."' AND power=".$sila." AND status='U'");
// 			if (!$test -> fields['id']) {
// 				$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, status, minlev, wt) VALUES(".$player -> id.",'".$nazwa."',".$sila.",'".$przedmiot -> fields['type']."',".$przedmiot -> fields['cost'].",'U',".$przedmiot -> fields['minlev'].",".$wt.")") or die("Nie moge dodac grotow.");
// 			} else {
// 			$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
// 			//$db -> Execute("UPDATE equipment SET cost=cost+".$przedmiot -> fields['cost']." WHERE id=".$test -> fields['id']);
// 			}
// 			$test -> Close();
// 		}
// 		if ($player -> clas == 'Rzemieslnik') {
// 				$rpd = $rpd * 2;
// 				$rum = $rum * 2;
// 			}
// 			$smarty -> assign ("Message", "Wykonales <b>".$kont -> fields['nazwa']."</b>. Zdobywasz <b>".$rpd."</b> PD oraz <b>".$rum."</b> poziomu w umiejetnosci Stolarstwo.<br>");
// 		} else {
// 		$rum = 0.01;
// 		$rpd = 0;
// 		$smarty -> assign ("Message", "Probowales wykonac <b>".$kont -> fields['nazwa']."</b>, niestety nie udalo sie. Zdobywasz <b>".$rum."</b> poziomu w umiejetnosci Stolarstwo.<br>");
// 		}
// 		$db -> Execute("DELETE FROM mill_work WHERE gracz=".$player -> id);
// 			checkexp($player -> exp,$rpd,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'fletcher',$rum);
// 	} else {
// 		$uenergia = ($_POST['razy'] + $kont -> fields['u_energia']);
// 		$procent = (($uenergia / $kont -> fields['c_energia']) * 100);
// 		$procent = round($procent,"0");
// 		$need = $kont -> fields['c_energia'] - $uenergia;
// 		$smarty -> assign ("Message", "Poswieciles na wykonanie ".$kont -> fields['nazwa']." kolejne ".$_POST['razy']." energii. Teraz jest on wykonany w ".$procent." procentach. Aby go ukonczyc potrzebujesz ".$need." energii.");
// 		$db -> Execute("UPDATE kowal_praca SET u_energia=u_energia+".$_POST['razy']." WHERE gracz=".$player -> id);
// 	}
// 	$db -> Execute("UPDATE players SET energy=energy-".$_POST['razy']." WHERE id=".$player -> id);
// 	}
	if (isset($_GET['rob'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['rob'])) {
			error ("Zapomnij o tym.");
		}
		if (!isset($_POST['razy'])) {
			error("Podaj ile przedmiotow chcesz wykonac!");
		}
		if (isset ($_POST['groty']) && !ereg("^[1-9][0-9]*$", $_POST['groty'])) {
			error ("Zapomnij o tym.");
		}
		$kuznia = SqlExec("SELECT m.* FROM mill m JOIN mill_plany p ON p.plan=m.id WHERE m.id={$_GET['rob']} AND p.pid={$player -> id}");
		if( empty( $kuznia -> fields['id'] ) ) {
			error( "Nie masz takiego planu !" );
		}
		$lostenergy = $_POST['razy'] * $kuznia -> fields['level'];
		$ilosc = intval( $_POST['razy'] );
		//if ($ilosc >= 1) {
		$rlumber = ($ilosc * $kuznia -> fields['lumber']);
		//} else {
		//	$rlumber = ($kuznia -> fields['lumber']);
		//}
		//error("Przerwanie testowe ! wartosc rlumber=".$rlumber);
		$rgroty = 0;
		$items = array('wt' => 0);
		if ($kuznia -> fields['type'] == 'R') {
			$rgroty = $ilosc;
			/*if ($rgroty < 10) {
				$rgroty = 10;
			}*/
			$items = $player -> EquipSearch( array( 'id' => $_POST['groty'] ) );
			$itemkey = key( $items );
			$items = array_shift( $items );
			//print_r( $items );
			//$items = $db -> Execute("SELECT wt, power, id, amount FROM equipment WHERE id=".$_POST['groty']);
			if( empty( $items ) ) {
				error( "Nie masz takich grotow !" );
			}
			if( $items['amount'] < $rgroty ) {
				error( "Masz za malo grotow !" );
			}
			
			//error( "" );
		}
		if ( $player -> wood < $rlumber /*|| $items -> fields['amount'] < $rgroty*/) {
			error ("Nie masz tylu materialow!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			error ("Zapomnij o tym");
		}
		if ($player -> energy < $lostenergy ) {
			error ("Nie masz tyle energii.");
		}
		//if ($kuznia -> fields['owner'] != $player -> id) {
		//	error ("Nie masz takiego planu");
		//}
		if ($player -> clas == 'Rzemieslnik') {
			$szansa = (($player -> fletcher * 100) + ($player -> level / 10));
		} else {
			$szansa = $player -> fletcher * 100;
		}
		$rprzedmiot = 0;
		$rpd = 0;
		$rum = 0;
		//$przedmiot = $db -> Execute("SELECT * FROM bows WHERE name='".$kuznia -> fields['name']."'") or error("Nie moge odczytac z bazy danych");
		$przedmiot1 = SqlExec( "SELECT * FROM items WHERE name='{$kuznia->fields['name']}'" );
		$przedmiot1 = array_shift( $przedmiot1 -> GetArray() );
		//
		if ($ilosc > 0) {
			for ($i=1;$i<=$ilosc;$i++) {
				$przedmiot = $przedmiot1;
				$rzut = (rand(1,100) * $kuznia -> fields['level']);
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
					$szyb = $przedmiot['szyb'];
					$wt = $przedmiot['maxwt'];
					$nazwa = $przedmiot['name'];
					$prefix = '';
					if ($rzut2 >= 90 && $rzut2 < 95) {
						$bonus = ceil($player -> fletcher);
						$maxbonus = ($sila * 10);
						if ($bonus > $maxbonus) {
							$bonus = $maxbonus;
						}
						$sila = ($sila + $bonus);
						$rpd = ($rpd + ($przedmiot['minlev'] * 100));
						if ($przedmiot['type'] == 'B') {
							$prefix = "Smoczy";
						}
						if ($kuznia -> fields['type'] == 'R') {
							$prefix = "Smocze";
						}
					}
					if ($rzut2 > 98 && $player -> clas == 'Rzemieslnik' && $kuznia -> fields['type'] != 'R') {
						$bonus = ceil($player -> fletcher / 2);
						if ($przedmiot['type'] == 'B') {
								$maxbonus = ($szyb * 10);
							if ($maxbonus == 0) {
								$maxbonus = 10;
							}
							if ($bonus > $maxbonus) {
								$bonus = $maxbonus;
							}
							$szyb = $szyb + $bonus;
							$prefix = "Elfi";
						}
						$rpd = ($rpd + ($przedmiot['minlev'] * 200));
					}
					if ($rzut2 > 94 && $rzut2 < 99 && $player -> clas == 'Rzemieslnik' && $kuznia->fields['type'] != 'R') {
						$bonus = ceil($player -> fletcher);
						$maxbonus = ($wt * 10);
						if ($maxbonus == 0) {
							$maxbonus = 10;
						}
						if ($bonus > $maxbonus) {
							$bonus = $maxbonus;
						}
						$wt = ($wt + $bonus);
						$rpd = ($rpd + ($przedmiot['minlev'] *150));
						if ($przedmiot['type'] == 'B') {
							$prefix = "Krasnoludzki";
						}
					}
					if ($rzut2 < 90) {
						$rpd = ($rpd + ($przedmiot['minlev']));
					}
					if ($kuznia -> fields['type'] == 'R' && $items['power'] > $przedmiot['power']) {
						$sila = $sila + $items['power'];
						$prefix = "Smocze";
					}
					
					$rprzedmiot = ($rprzedmiot + 1);
					$rum = ($rum + ($kuznia -> fields['level'] / 100));
					$cena = round($przedmiot['cost'] / 20);
					
					$przedmiot['power']=$sila;
					$przedmiot['szyb']=$szyb;
					$przedmiot['wt']=$wt;
					$przedmiot['maxwt']=$wt;
					$przedmiot['prefix']=$prefix;
					$przedmiot['cost']=$cena;
					
					//print_r( $przedmiot );
					//error( "" );
					
					if( $player -> EquipAdd( $przedmiot ) === FALSE ) {
						error( "Blad podczas dodawania przedmiotu !" );
					}
					unset( $przedmiot );
					
					//if ($kuznia -> fields['type'] != 'R') {
						//$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$nazwa."' AND wt=".$wt." AND type='".$przedmiot -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$sila." AND zr=".$przedmiot -> fields['zr']." AND szyb=".$szyb." AND maxwt=".$wt." AND poison=0 AND cost=".$cena);
							//if (!$test -> fields['id']) {
								//$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$nazwa."',".$sila.",'".$przedmiot -> fields['type']."',".$cena.",".$przedmiot -> fields['zr'].",".$wt.",".$przedmiot -> fields['minlev'].",".$wt.",1,'N',0,".$szyb.",'Y')") or error("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$nazwa."',".$sila.",'".$przedmiot -> fields['type']."',".$cena.",".$przedmiot -> fields['zr'].",".$wt.",".$przedmiot -> fields['minlev'].",".$wt.",1,'N',0,".$szyb.",'Y')");
								//} else {
								//	$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
								//}
						//$test -> Close();
					//} else {
					//	$test = $db -> Execute("SELECT id FROM equipment WHERE owner=".$player -> id." AND name='".$nazwa."' AND power=".$sila." AND status='U'");
						//error (print_r($test->GetArray()));
					//	if (!$test -> fields['id']) {
					//	$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, status, minlev, wt) VALUES(".$player -> id.",'".$nazwa."',".$sila.",'".$przedmiot -> fields['type']."',".$przedmiot -> fields['cost'].",'U',".$przedmiot -> fields['minlev'].",10)") or error("Nie moge dodac grotow.");
					//	} else {
					//	$db -> Execute("UPDATE equipment SET wt=wt+10 WHERE id={$test->fields['id']}");
					//	$db -> Execute("UPDATE equipment SET cost=cost+{$przedmiot->fields['cost']} WHERE id=".$test -> fields['id']);
					//	}
					//$test -> Close();
					//}
				} else {
					$rum = ($rum + 0.01);
				}
			}
			if ($player -> clas == 'Rzemieslnik') {
				$rpd = $rpd * 2;
				$rum = $rum * 2;
			}
			$smarty -> assign ("Message", "Wykonales <b>".$kuznia -> fields['name']."</b> <b>".$rprzedmiot."</b> razy. Zdobywasz <b>".$rpd."</b> PD oraz <b>".$rum."</b> poziomu w umiejetnosci Stolarstwo.<br>");
			$player -> AwardExp( $rpd );
			$player -> fletcher += $rum;
			//checkexp($player -> exp,$rpd,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'fletcher',$rum);
		} else {
			error( "Jak tu trafiles ?!? Napisz o tym do architekta koniecznie !" );
		//	$procent = (($_POST['razy'] / $kuznia -> fields['level']) * 100);
		//	$procent = round($procent,"0");
		//	$need = ($kuznia -> fields['level'] - $_POST['razy']);
		//	$smarty -> assign ("Message", "Pracowales nad ".$kuznia -> fields['name'].", zuzywajac ".$_POST['razy']." energii i wykonales go w ".$procent." procentach. Aby ukonczyc przedmiot potrzebujesz jeszcze ".$need." energii.");
		//	if ($kuznia -> fields['type'] == 'R') {
		//		$db -> Execute("INSERT INTO mill_work (gracz, nazwa, u_energia, c_energia, power) VALUES(".$player -> id.",'".$kuznia -> fields['name']."',".$_POST['razy'].",".$kuznia -> fields['level'].",".$items -> fields['power'].")") or error("nie moge dodac przedmiotu");
		//	} else {
		//		$db -> Execute("INSERT INTO mill_work (gracz, nazwa, u_energia, c_energia) VALUES(".$player -> id.",'".$kuznia -> fields['name']."',".$_POST['razy'].",".$kuznia -> fields['level'].")") or error("nie moge dodac przedmiotu");
		//	}
		}
		//$db -> Execute("UPDATE kopalnie SET lumber=lumber-".$rlumber." WHERE gracz=".$player -> id);
		$player -> wood -= $rlumber;
		if ($kuznia -> fields['type'] == 'R') {
			$arrow = $items['amount'] - $rgroty;
			if ($arrow <= 0) {
				//$db -> Execute("DELETE FROM equipment WHERE id=".$items -> fields['id']);
				$player -> EquipDelete( $items['id'] );
			} else {
				//$db -> Execute("UPDATE equipment SET amount=".$arrow." WHERE id=".$items -> fields['id']);
				$player -> SetEquip( 'backpack', $itemkey, array( 'amount'=> $arrow ) );
			}
		}
		//$db -> Execute("UPDATE players SET energy=energy-".$_POST['razy']." WHERE id=".$player -> id);
		$player -> energy -= $lostenergy;
		}
}

// inicjalizacja zmiennych
if (!isset($_GET['mill'])) {
	$_GET['mill'] = '';
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
if (!isset($_GET['ko'])) {
	$_GET['ko'] = '';
}
if (!isset($_GET['dalej'])) {
	$_GET['dalej'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Mill" => $_GET['mill'], "Buy" => $_GET['buy'], "Make" => $_GET['rob'], "Continue" => $_GET['konty'], "Cont" => $_GET['ko'], "Next" => $_GET['dalej']));
$smarty -> display ('lumbermill.tpl');

require_once("includes/foot.php");
?>
