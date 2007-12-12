<?php
//@type: F
//@desc: Alchemik - pracownia
$title = "Pracownia alchemiczna";
require_once("includes/head.php");
require_once("includes/checkexp.php");

checklocation($_SERVER['SCRIPT_NAME']);
/*if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurtha' && $player -> location != 'Imnescar' && $player -> location != 'Iriaebor') {
	error ("Zapomnij o tym");
}*/
//error("Pracownia zamkniêta - modernizacja wyposa¿enia");
if ($player -> przemiana > 0) {

error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 

}

// pobranie ilosci ziol danego gracza z bazy danych
//$herb = $db -> Execute("SELECT illani, illanias, nutari, dynallca FROM herbs WHERE gracz=".$player -> id);

// zakupy przepisow
if (isset ($_GET['alchemik']) && $_GET['alchemik'] == 'przepisy') {
	$plany = $db -> Execute("SELECT * FROM alchemik WHERE status='S' AND gracz=0 ORDER BY cena ASC");
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
		$i = $i + 1;
		$plany -> MoveNext();
	}
	$plany -> Close();
	$smarty -> assign (array("Name" => $arrname, "Cost" => $arrcost, "Level" => $arrlevel, "Id" => $arrid));
	if (isset($_GET['buy'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
			error ("Zapomnij o tym!");
		}
		$plany = SqlExec("SELECT * FROM alchemik WHERE gracz=0 AND id=".$_GET['buy']);
		$test = SqlExec("SELECT id FROM alchemik_plany WHERE pid={$player -> id} AND plan={$plany -> fields['id']}");
		if ($test -> fields['id'] != 0) {
			error ("Masz juz taki przepis!");
		}
		$test -> Close();
		if ($plany -> fields['id'] == 0) {
			error ("Nie ma takiego przepisu. Wroc do <a href=alchemik.php?alchemik=przepisy>sklepu</a>.");
		}
		if ($plany -> fields['status'] != 'S') {
			error ("Tutaj tego nie sprzedasz.");
		}
		if ($plany -> fields['cena'] > $player -> gold) {
			error ("Nie stac cie!");
		}
		$player -> gold -= $plany -> fields['cena'];
		SqlExec( "INSERT INTO alchemik_plany(pid,plan) values({$player->id},{$plany->fields['id']})" );
		//$db -> Execute("INSERT INTO alchemik (gracz, nazwa, cena, status, poziom, illani, illanias, nutari, dynallca) VALUES(".$player -> id.",'".$plany -> fields['nazwa']."',".$plany -> fields['cena'].",'N',".$plany -> fields['poziom'].",".$plany -> fields['illani'].",".$plany -> fields['illanias'].",".$plany -> fields['nutari'].",".$plany -> fields['dynallca'].")") or error("Nie moge dodac przepisu.");
		//$db -> Execute("UPDATE players SET credits=credits-".$plany -> fields['cena']." WHERE id=".$player -> id);
		$smarty -> assign (array ("Cost1" => $plany -> fields['cena'], "Name1" => $plany -> fields['nazwa']));
		$plany -> Close();
	}
}

// wykonywanie mikstur
if (isset ($_GET['alchemik']) && $_GET['alchemik'] == 'pracownia') {
	if (!isset($_GET['rob'])) {
		$arrname = array();
		$arrlevel = array();
		$arrid = array();
		$arrillani = array();
		$arrillanias = array();
		$arrnutari = array();
		$arrdynallca = array();
		$i = 0;
		$kuznia = SqlExec("SELECT a.* FROM alchemik a JOIN alchemik_plany p ON p.plan=a.id WHERE p.pid=".$player -> id." ORDER BY a.poziom ASC");
		while (!$kuznia -> EOF) {
			$arrname[$i] = $kuznia -> fields['nazwa'];
			$arrlevel[$i] = $kuznia -> fields['poziom'];
			$arrid[$i] = $kuznia -> fields['id'];
			$arrillani[$i] = $kuznia -> fields['illani'];
			$arrillanias[$i] = $kuznia -> fields['illanias'];
			$arrnutari[$i] = $kuznia -> fields['nutari'];
			$arrdynallca[$i] = $kuznia -> fields['dynallca'];
			$i = $i + 1;
			$kuznia -> MoveNext();
		}
		$kuznia -> Close();
		$smarty -> assign (array("Name" => $arrname, "Level" => $arrlevel, "Id" => $arrid, "Illani" => $arrillani, "Illanias" => $arrillanias, "Nutari" => $arrnutari, "Dynallca" => $arrdynallca));
	}
	if (isset($_GET['dalej'])) {
		if ($player -> hp == 0) {
			error ("Nie mozesz wykonywac mikstur poniewaz jestes martwy!");
		}
		if (!ereg("^[1-9][0-9]*$", $_GET['dalej'])) {
			error ("Zapomnij o tym");
		}
		$kuznia = $db -> Execute("SELECT a.nazwa FROM alchemik a JOIN alchemik_plany p ON p.plan=a.id WHERE a.id=".$_GET['dalej']);
		if( empty( $kuznia -> fields['nazwa'] ) ) {
			error( "Nie masz takiego planu !" );
		}
		$smarty -> assign (array ("Name1" => $kuznia -> fields['nazwa'], "Id1" => $_GET['dalej']));
		$kuznia -> Close();
	}
	if (isset($_GET['rob'])) {
		if (!ereg("^[1-9][0-9]*$", $_GET['rob'])) {
			error ("Zapomnij o tym");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			error ("Zapomnij o tym");
		}
		$kuznia = SqlExec("SELECT a.* FROM alchemik a JOIN alchemik_plany p ON p.plan=a.id WHERE a.id=".$_GET['rob']);
		if( empty( $kuznia -> fields['id'] ) ) {
			error( "Nie masz takiego planu !" );
		}
		$rillani = ($_POST['razy'] * $kuznia -> fields['illani']);
		$rillanias = ($_POST['razy'] * $kuznia -> fields['illanias']);
		$rnutari = ($_POST['razy'] * $kuznia -> fields['nutari']);
		$rdynallca = ($_POST['razy'] * $kuznia -> fields['dynallca']);
		if ($player -> illani < $rillani ||
			$player -> illanias < $rillanias ||
			$player -> nutari < $rnutari ||
			$player -> dynallca < $rdynallca ) {
			error ("Nie masz tylu ziol!");
		}
		$lostene = $_POST['razy'] * $kuznia -> fields['poziom'];
		if ($player -> energy < $lostene ) {
			error ("Nie masz tyle energii.");
		}
		//if ($kuznia -> fields['gracz'] != $player -> id) {
		//	error ("Nie masz takiego przepisu");
		//}
		if( $player -> level < $kuznia -> fields['poziom'] ) {
			error( "Nie mozesz jeszcze wykonywac takich mikstur" );
		}
		if ($player -> clas == 'Druid') {
			$szansa = (($player -> alchemy * 100) + ($player -> level / 10));
		} else {
			$szansa = $player -> alchemy * 100;
		}
		$rprzedmiot = 0;
		$rpd = 0;
		$rum = 0;
		$przedmiot1 = SqlExec( "SELECT * FROM potions WHERE name='{$kuznia->fields['nazwa']}'" );
		$przedmiot1 = array_shift( $przedmiot1 -> GetArray() );
		if( empty( $przedmiot1 ) ) {
			error( "Nie ma takiego przedmiotu w bazie" );
		}
		//if ($rdynallca == 0) {
		//	$przedmiot1 = $db -> Execute("SELECT * FROM mikstury WHERE nazwa='".$kuznia -> fields['nazwa']."' AND gracz=0") or error("Nie moge odczytac z bazy danych");
		//	$przedmiot = array('nazwa' => $kuznia -> fields['nazwa'],'efekt' => $przedmiot1 -> fields['efekt'],'moc' => $przedmiot1 -> fields['moc'],'typ' => $przedmiot1 -> fields['typ'], 'poziom' => $kuznia->fields['poziom']);
		//} else {
		//	$przedmiot = array ('nazwa' => $kuznia -> fields['nazwa'],'efekt' => "Wzmacnia sile broni",'moc' => 0,'typ' => 'P');
		//}
		for ($i=1;$i<=$_POST['razy'];$i++) {
			//if ($rdynallca == 0) {
				//$przedmiot1 = $db -> Execute("SELECT * FROM mikstury WHERE nazwa='".$kuznia -> fields['nazwa']."' AND gracz=0") or error("Nie moge odczytac z bazy danych");
			//	$przedmiot = array('nazwa' => $kuznia -> fields['nazwa'],'efekt' => $przedmiot1 -> fields['efekt'],'moc' => $przedmiot1 -> fields['moc'],'typ' => $przedmiot1 -> fields['typ'], 'poziom' => $kuznia->fields['poziom']);
			//} else {
			//	$przedmiot = array ('nazwa' => $kuznia -> fields['nazwa'],'efekt' => "Wzmacnia sile broni",'moc' => 0,'typ' => 'P');
			//}
			$przedmiot = $przedmiot1;
			$sila = 1;
			$prefix = '';
			$rzut = (rand(1,100) * $kuznia -> fields['poziom']);
			if ($szansa >= $rzut) {
				$rzut2 = rand(1,100);
				if ($player -> clas == 'Druid') {
					$bonus = ($player -> level / 8);
					if ($bonus > 50) {
						$bonus = 50;
					}
					$rzut2 = ($rzut2 + $bonus);
				}
				if ($player -> clas == 'Mag') {
					$bonus = ($player -> level / 12);
					if ($bonus > 50) {
						$bonus = 50;
					}
					$rzut2 = ($rzut2 + $bonus);
				}
				$prefix = '';
				$sila = $kuznia->fields['poziom']*10;
				if ($rzut2 >= 90 && $rzut2 < 95) {
					$bonus = ceil($player -> alchemy);
					$maxbonus = ($sila * 10);
					if ($bonus > $maxbonus) {
						$bonus = $maxbonus;
					}
					
					$rpd += ($kuznia->fields['poziom'] *60);
					if($przedmiot['type']!='W') {
						$sila = ($przedmiot['power'] + $bonus);
						$prefix = "Dobrej jakosci ";
					}
				}elseif($rzut2 >= 95 && $rzut2 < 98 && ( $player->clas == 'Druid' || $player->clas == 'Mag' ) ) {
					$bonus = ceil($player -> alchemy);
					$maxbonus = ($sila * 10);
					if ($bonus > $maxbonus) {
						$bonus = $maxbonus;
					}
					
					$rpd += ($kuznia->fields['poziom'] *110);
					if($przedmiot['type']!='W') {
						$sila = ($przedmiot['power'] + $bonus*1.5);
						$prefix = "Wyjatkowej jakosci ";
					}
				}elseif($rzut2 >= 98 && ( $player->clas == 'Druid' || $player->clas == 'Mag' ) ) {
					$bonus = ceil($player -> alchemy);
					$maxbonus = ($sila * 10);
					if ($bonus > $maxbonus) {
						$bonus = $maxbonus;
					}
					
					$rpd += ($kuznia->fields['poziom'] *160);
					if($przedmiot['type']!='W') {
						$sila = ($przedmiot['power'] + $bonus*2);
						$prefix = "Niesamowita ";
					}
				}else {
					$rpd +=  $kuznia->fields['poziom'];
					$sila = $przedmiot['power'];
				}
				$rprzedmiot = ($rprzedmiot + 1);
				$rum = ($rum + ($kuznia -> fields['poziom'] / 100));
				if ($przedmiot['type'] == 'P') {
					//$arrpow = array(25=>
					//$arrlevel = array(25,30,35,40,45);
					//$arrmaxpower = array(25,50,75,100,200);
					//for ($j=0;$j<5;$j++) {
					//	if ($arrlevel[$j] == $kuznia -> fields['poziom']) {
					//		$maxpower = $arrmaxpower[$j];
					//	}
					//}
					$maxpower = $przedmiot['power'];
					$sila = $player -> alchemy;
					if ($sila > $maxpower) {
						$sila = $maxpower;
					}
				}
				$toadd['nazwa'] = $przedmiot['name'];
				$toadd['typ'] = $przedmiot['type'];
				$toadd['efekt'] = $przedmiot['efekt'];
				$toadd['moc'] = $sila;
				$toadd['prefix'] = $prefix;
				$toadd['amount'] = 1;
				$toadd['cena'] = 0;
				$toadd['imagenum'] = $przedmiot['imagenum'];
				//print_r( $toadd );
				//print_r( $przedmiot );
				//error( "" );
				//print_r( $toadd );
				$player -> EquipAdd( $player -> TranslateFields( $toadd, 'potions' ) , 'potions' );
				unset( $przedmiot );
				//$test = $player -> EquipSearch( array( 'nazwa' => $przedmiot['nazwa'], 'moc' => $sila ) );
				//$test = $db -> Execute("SELECT id FROM mikstury WHERE nazwa='".$przedmiot['nazwa']."' AND gracz=".$player -> id." AND status='K' AND moc=$sila");
				//if ( !empty( $test ) ) {
					//$needed = array( 'nazwa', 'typ', 'efekt', 'moc', 'amount' );
					
					//$db -> Execute("INSERT INTO mikstury (gracz, nazwa, efekt, moc, amount, status, typ) VALUES(".$player -> id.",'".$przedmiot['nazwa']."','".$przedmiot['efekt']."',".$sila.",1,'K','".$przedmiot['typ']."')") or error("nie moge dodac mikstury!".$przedmiot['nazwa'].$przedmiot['efekt'].$przedmiot['moc'].$rprzedmiot.$przedmiot['typ']);
				//} else {
				//	$db -> Execute("UPDATE mikstury SET amount=amount+1 WHERE id=".$test -> fields['id']);
				//}
				//$test -> Close();
			} else {
				$rum = ($rum + 0.01);
			}
		}
		if ($player -> clas == 'Druid' || $player -> clas == 'Mag') {
			$rpd = $rpd * 2;
			$rum = $rum * 2;
		}
		$smarty -> assign(array ("Name" => $kuznia -> fields['nazwa'], "Amount" => $rprzedmiot, "Exp" => $rpd, "Ability" => $rum));
		$kuznia -> Close();
// 		if ($rprzedmiot > 0) {
// 			$test = $db -> Execute("SELECT id FROM mikstury WHERE nazwa='".$przedmiot['nazwa']."' AND gracz=".$player -> id." AND status='K'");
// 			if ($test -> fields['id'] == 0) {
// 				$db -> Execute("INSERT INTO mikstury (gracz, nazwa, efekt, moc, amount, status, typ) VALUES(".$player -> id.",'".$przedmiot['nazwa']."','".$przedmiot['efekt']."',".$przedmiot['moc'].",".$rprzedmiot.",'K','".$przedmiot['typ']."')") or error("nie moge dodac mikstury!".$przedmiot['nazwa'].$przedmiot['efekt'].$przedmiot['moc'].$rprzedmiot.$przedmiot['typ']);
// 			} else {
// 				$db -> Execute("UPDATE mikstury SET amount=amount+".$rprzedmiot." WHERE id=".$test -> fields['id']);
// 			}
// 		$test -> Close();
// 		}
		$player -> AwardExp( $rpd );
		$gain['alchemy'] = $player -> alchemy + $rum;
		$gain['illani'] = $player -> illani - $rillani;
		$gain['illanias'] = $player -> illanias - $rillanias;
		$gain['nutari'] = $player -> nutari - $rnutari;
		$gain['dynallca'] = $player -> dynallca - $rdynallca;
		$gain['energy'] = $player -> energy - $lostene;
		$player -> SetArray( $gain );
		//checkexp($player -> exp,$rpd,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'alchemia',$rum);
		//$db -> Execute("UPDATE herbs SET illani=illani-".$rillani." WHERE gracz=".$player -> id);
		//$db -> Execute("UPDATE herbs SET illanias=illanias-".$rillanias." WHERE gracz=".$player -> id);
		//$db -> Execute("UPDATE herbs SET nutari=nutari-".$rnutari." WHERE gracz=".$player -> id);
		//$db -> Execute("UPDATE herbs SET dynallca=dynallca-".$rdynallca." WHERE gracz=".$player -> id);
		//$db -> Execute("UPDATE players SET energy=energy-".$_POST['razy']." WHERE id=".$player -> id);
	}
}

//$herb -> Close();

// inicjalizacja zmiennych
if (!isset($_GET['alchemik'])) {
	$_GET['alchemik'] = '';
}
if (!isset($_GET['buy'])) {
	$_GET['buy'] = '';
}
if (!isset($_GET['rob'])) {
	$_GET['rob'] = '';
}
if (!isset($_GET['dalej'])) {
	$_GET['dalej'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign (array ("Alchemist" => $_GET['alchemik'], "Buy" => $_GET['buy'], "Make" => $_GET['rob'], "Next" => $_GET['dalej']));
$smarty -> display ('alchemist.tpl');

require_once("includes/foot.php");
?>
