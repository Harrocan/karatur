<?php
/**
*   Funkcje pliku:
*   Ksiega czarow gracza - uaktywnianie i deaktywacja czarow oraz umagicznianie przedmiotow
*
*   @name                 : czary.php
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

$title = "Ksiega czarow";
require_once("includes/head.php");
require_once("includes/checkexp.php");

/**
* Przypisanie zmiennej
*/
$smarty -> assign("Message", '');

if (isset($_GET['deakt'])) {
	$player -> SpellDeactivate( $_GET['deakt'] );
	//if (!ereg("^[1-9][0-9]*$", $_GET['deakt'])) {
	//    error ("Zapomnij o tym!");
	//}
	//$czary1 = $db -> Execute("SELECT * FROM czary WHERE id=".$_GET['deakt']);
	//if (!$czary1 -> fields['id']) {
	//    error ("Nie ten czar.");
	//}
	//
	//if ($player -> id != $czary1 -> fields['gracz']) {
	//    error ("Nie posiadasz tego czaru.");
	//}
	//$db -> Execute("UPDATE czary SET status='U' WHERE id=".$czary1 -> fields['id']);
	//$czary1 -> Close();
}
// Uzywanie czarow bojowych oraz obronnych
if (isset($_GET['use'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['use'])) {
		error ("Zapomnij o tym!");
	}
	//$czary = $db -> Execute("SELECT * FROM czary WHERE id=".$_GET['naucz']);
	//if (!$czary -> fields['id']) {
	//	error ("Nie ten czar.");
	//}
	//if ($player -> id != $czary -> fields['gracz']) {
	//	error ("Nie posiadasz tego czaru.");
	//}
	//if ($player -> level < $czary -> fields['poziom']) {
	//	error ("Nie masz odpowiednio wysokiego poziomu!");
	//}
	//    if ($player -> clas != 'Mag' && $player -> clas != 'Kaplan' && $player -> clas != 'Druid') {
	//        error ("Tylko mag, kap³an i druid moze uzywac czarow!");
	//    }
	//$db -> Execute("UPDATE czary SET status='U' WHERE gracz=".$player -> id." AND typ='".$czary -> fields['typ']."' AND status='E'");
	//$db -> Execute("UPDATE czary SET status='E' WHERE id=".$czary -> fields['id']." AND gracz=".$player -> id);
	$czar = ( $player -> EquipSearch( array( 'id' => $_GET['use'] ), 'spells' ) );
	//print_r( $czar );
	$czar = current( $czar );
	$player -> SpellActivate( $_GET['use'] );
	$smarty -> assign ("Name", $czar['name']);
	//$czary -> Close();
}

$czarb = $player -> GetEquipped( 'spellatk' );
$czarb = array_shift( $czarb );
$czaro = $player -> GetEquipped( 'spelldef' );
$czaro = array_shift( $czaro );
//print_r( $czarb );
$smarty -> assign( array( "Atak"=>$czarb, "Def"=>$czaro ) );
//$czarb = $db -> Execute("SELECT * FROM czary WHERE gracz=".$player -> id." AND status='E' AND typ='B'");
//if ($czarb -> fields['id']) {
//	$smarty -> assign ("Battle", "Czar bojowy: ".$czarb -> fields['nazwa']." (+".$czarb -> fields['obr']." x Inteligencja obrazen) | <a href=czary.php?deakt=".$czarb -> fields['id'].">Deaktywuj czar</a><br>");
//} else {
//	$smarty -> assign ("Battle", "Czar bojowy: brak<br>");
//}
//$czarb -> Close();

//$czaro = $db -> Execute("SELECT * FROM czary WHERE gracz=".$player -> id." AND status='E' AND typ='O'");
//if ($czaro -> fields['id']) {
//	$smarty -> assign ("Defence", "Czar obronny: ".$czaro -> fields['nazwa']." (+".$czaro -> fields['obr']." x Sila Woli obrony) | <a href=czary.php?deakt=".$czaro -> fields['id'].">Deaktywuj czar</a><br>");
//} else {
//	$smarty -> assign ("Defence", "Czar obronny: brak<br>");
//}
//$czaro -> Close();



$spells[] = array( 'name' => 'Czary ofensywne',
					'suff' => 'x Int obrazen',
					'action' => 'uzywaj',
					'link' => 'use',
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'B' ), 'spells' ) ) );
$spells[] = array( 'name' => 'Czary defensywne',
					'suff' => 'x Sily woli obrony',
					'action' => 'uzywaj',
					'link' => 'use',
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'O' ), 'spells' ) ) );
$spells[] = array( 'name' => 'Czary ulepszajace',
					'suff' => '',
					'action' => 'rzuc',
					'link' => 'cast',
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'U' ), 'spells' ) ) );

//print_r($spells);
$smarty -> assign( "Spells", $spells );
/*
$arrname1 = array();
$arrpower1 = array();
$arrid1 = array();
$i = 0;
$czary = $db -> Execute("SELECT * FROM czary WHERE gracz=".$player -> id." AND status='U' AND typ='B'");
while (!$czary -> EOF) {
	$arrname1[$i] = $czary -> fields['nazwa'];
	$arrpower1[$i] = $czary -> fields['obr'];
	$arrid1[$i] = $czary -> fields['id'];
	$czary -> MoveNext();
	$i = $i + 1;
}
$czary -> Close();

$arrname2 = array();
$arrpower2 = array();
$arrid2 = array();
$i = 0;
$czaryo = $db -> Execute("SELECT * FROM czary WHERE gracz=".$player -> id." AND status='U' AND typ='O'");
while (!$czaryo -> EOF) {
	$arrname2[$i] = $czaryo -> fields['nazwa'];
	$arrpower2[$i] = $czaryo -> fields['obr'];
	$arrid2[$i] = $czaryo -> fields['id'];
	$czaryo -> MoveNext();
	$i = $i + 1;
}
$czaryo -> Close();


$arrname3 = array();
$arrefect = array();
$arrid3 = array();
$i = 0;
$czaryu = $db -> Execute("SELECT * FROM czary WHERE gracz=".$player -> id." AND typ='U'");
while (!$czaryu -> EOF) {
	if ($czaryu -> fields['nazwa'] == 'Ulepszenie przedmiotu') {
		$arrefect[$i] = 'Zwieksza sile przedmiotu';
	}
	if ($czaryu -> fields['nazwa'] == 'Utwardzenie przedmiotu') {
		$arrefect[$i] = 'Zwieksza wytrzymalosc przedmiotu';
	}
	if ($czaryu -> fields['nazwa'] == 'Umagicznienie przedmiotu') {
		$arrefect[$i] = 'Zwieksza premie szybkosci lub zrecznosci przedmiotu';
	}
	$arrname3[$i] = $czaryu -> fields['nazwa'];
	$arrid3[$i] = $czaryu -> fields['id'];
	$czaryu -> MoveNext();
	$i = $i + 1;
}
$czaryu -> Close();
*/
// Umagicznianie przedmiotow
if (isset($_GET['cast'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['cast'])) {
	error ("Zapomnij o tym!");
	}
	$czary = $player ->EquipSearch( array( 'id' => $_GET['cast'] ), 'spells' );
	if ( empty( $czary ) ) {
	error ("Nie ten czar.");
	}
	
	$czar = current( $czary );
	//print_r( $czar );
	if ($player -> level < $czar['minlev']) {
		error ("Nie masz odpowiednio wysokiego poziomu!");
	}
	if ($player -> mana < $czar['minlev']) {
		error ("Nie masz tyle punktow magii!");
	}
	if ($player -> clas == 'Barbarzynca') {
		error ("Nie mozesz uzywac czarow poniewaz jestes Barbarzynca!");
	}

	$items = $player -> EquipSearch();
	if( empty( $items ) ) {
		error( "Nie masz przedmiotow do umagicznienia" );
	}
	foreach( $items as $key => $item ) {
		if( $item['magic'] == 'Y' ) {
			unset( $items[$key] );
		}
	}
	//$arriname = array();
	//$arriamount = array();
	//$arriid = array();
	//$i = 0;
	//$arritem = $db -> Execute("SELECT name, id, amount FROM equipment WHERE owner=".$player -> id." AND status='U'");
	//while (!$arritem -> EOF) {
	//	$arriname[$i] = $arritem -> fields['name'];
	//	$arriamount[$i] = $arritem -> fields['amount'];
	//	$arriid[$i] = $arritem -> fields['id'];
	//	$arritem -> MoveNext();
	//	$i = $i + 1;
	//}
	//$arritem -> Close();
	$smarty -> assign ( array("Spellid" => $czar['id'], "Spellname" => $czar['name'], "Items" => array_values( $items ) ) );
	
	if (isset($_GET['step']) && $_GET['step'] == 'items') {
		if (!ereg("^[1-9][0-9]*$", $_POST['item'])) {
		error ("Zapomnij o tym!");
		}
		//$arritem = $db -> Execute("SELECT * FROM equipment WHERE id=".$_POST['item']);
		$item = $player -> EquipSearch( array( 'id' => $_POST['item'] ) );
		if ( empty( $item ) ) {
			error ("Nie ma takiego przedmiotu!");
		}
		$key = key( $item );
		$item = current( $item );
		if ($item['magic'] == 'Y') {
			error ("Ten przedmiot jest juz umagiczniony!");
		}
		$spell = $player -> EquipSearch( array( 'name' => $_POST['spell'] ), 'spells' );
		//$arrspell = $db -> Execute("SELECT nazwa, poziom FROM czary WHERE nazwa='".$_POST['spell']."' AND gracz=".$player -> id);
		if( empty( $spell ) ) {
			error( "Nie ma takiego czaru $_POST[spell]");
		}
		$spell = current( $spell );
		if ($player -> energy < $spell['power']) {
			error ("Nie masz tyle energii!");
		}
		$chance = ( $player -> magic - $item['minlev'] - $spell['power'] + rand( 1, 100 ) );
		$bonus = ceil( $player -> cast / $spell['minlev']);
		if ($item['type'] == 'W') {
			$prefix = "Magiczny ";
		} elseif ($item['type'] == 'A') {
			$prefix = "Magiczna ";
		} elseif ($item['type'] == 'H') {
			$prefix = "Magiczny ";
		} elseif ($item['type'] == 'N') {
			$prefix = "Magiczne ";
		} elseif ($item['type'] == 'R') {
			$prefix = "Magiczne ";
		} elseif ($item['type'] == 'B') {
			$prefix = "Magiczny ";
		} elseif ($item['type'] == 'G') {
			$prefix = "Magiczne ";
		} elseif ($item['type'] == 'D') {
			$prefix = "Magiczna ";
		} else {
			error ("Nie mozesz umagiczniac tego przedmiotu!");
		}
		//print_r( $spell );
		$item['magic'] = 'Y';
		$magic = ($spell['minlev'] / 100);
		//$db -> Execute("UPDATE players SET pm=pm-".$arrspell -> fields['poziom']." WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET energy=energy-".$arrspell -> fields['poziom']." WHERE id=".$player -> id);
		$player -> mana = $player -> GetMisc( 'mana', TRUE ) - $spell['minlev'];
		$player -> energy -= $spell['minlev'];
		if ($spell['name'] == 'Ulepszenie przedmiotu') {
			if ($chance > 100) {
				$maxbonus = ($item['power'] * 5);
				if ($bonus > $maxbonus) {
					$bonus = $maxbonus;
				}
				//var_dump( $item );
				$smarty -> assign ("Message", "Zwiekszyles sile ".$item['name']." o ".$bonus."! Jest to teraz przedmiot magiczny! Zdobyles ".$bonus." Punktow Doswiadczenia oraz ".$magic." punktow w umiejetnosci rzucanie czarow<br>");
				$olditem = $item;
				$power = $item['power'] + $bonus;
				$item['prefix'] .= $prefix;
				$item['power'] = $power;
				$item['amount'] = 1;
				$player -> EquipAdd( $item );
				if($olditem['amount'] <=1 ) {
					$ret =  $player -> EquipDelete( $olditem['id'] );
					//var_dump( $ret );
				}
				else {
					$player -> SetEquip( 'backpack', $key, array( 'amount' => ( $olditem['amount'] -1 ) ) );
				}
				//$sql="SELECT id FROM equipment WHERE name='".$name."' AND wt=".$arritem -> fields['wt']." AND type='".$arritem -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$power." AND zr=".$arritem -> fields['zr']." AND szyb=".$arritem -> fields['szyb']." AND maxwt=".$arritem -> fields['maxwt']." AND poison=".$arritem -> fields['poison']." AND magic='Y'";
			// echo "1) ".$sql."<br>";
				//echo $sql;
				//$test = $db -> Execute($sql);
				//if (!$test -> fields['id']) {
				//	$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb) VALUES(".$player -> id.",'".$name."',".$power.",'".$arritem -> fields['type']."',".$arritem -> fields['cost'].",".$arritem -> fields['zr'].",".$arritem -> fields['wt'].",".$arritem -> fields['minlev'].",".$arritem -> fields['maxwt'].",1,'Y',".$arritem -> fields['poison'].",".$arritem -> fields['szyb'].")") or error("nie moge dodac!");
				//} else {
				//	$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
				//}
				//$test -> Close();
				//checkexp($player -> exp,$bonus,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'magia',$magic);
				$player -> AwardExp( $bonus );
				$player -> cast = $player -> GetSkill( 'cast', TRUE ) + $magic;
			} else {
				//$db -> Execute("UPDATE players SET magia=magia+0.01 WHERE id=".$player -> id);
				$player -> cast += 0.01;
				$smarty -> assign ("Message", "Probowales umagicznic ".$item['name']." ale niestety nie udalo sie. Na skutek nieudanego zaklecia przedmiot niszczy sie! Dostajesz 0.01 do umiejetnosci rzucania czarow.");
				if( $item['amount'] <=1 ) {
					$player -> EquipDelete( $item['id'] );
				}
				else {
					$player -> SetEquip( 'backpack', $key, array( 'amount' => ( $item['amount'] -1 ) ) );
				}
			}
		}
		if ($spell['name'] == 'Utwardzenie przedmiotu') {
			if ($item['type'] == 'G') {
				error ("Nie mozna zwiekszyc wytrzymalosci grotow!");
			}
			if ($item['type'] == 'R') {
				error ("Nie mozna zwiekszyc wytrzymalosci strzal!");
			}
			if ($chance > 100) {
				$maxbonus = ($item['maxwt'] * 5);
				if ($bonus > $maxbonus) {
					$bonus = $maxbonus;
				}
				$smarty -> assign ("Message", "Zwiekszyles wytrzymalosc ".$arritem -> fields['name']." o ".$bonus."! Jest to teraz przedmiot magiczny! Zdobyles ".$bonus." Punktow Doswiadczenia oraz ".$magic." punktow w umiejetnosci rzucanie czarow<br>");
				$olditem = $item;
				$item['prefix'] .= $prefix;
				$item['maxwt'] += $bonus;
				$item['wt'] += $bonus;
				$item['amount'] = 1;
				$player -> EquipAdd( $item );
				if($olditem['amount'] <=1 ) {
					$ret =  $player -> EquipDelete( $olditem['id'] );
					//var_dump( $ret );
				}
				else {
					$player -> SetEquip( 'backpack', $key, array( 'amount' => ( $olditem['amount'] -1 ) ) );
				}
				//$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$name."' AND wt=".$dur." AND type='".$arritem -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$arritem -> fields['power']." AND zr=".$arritem -> fields['zr']." AND szyb=".$arritem -> fields['szyb']." AND maxwt=".$maxdur." AND poison=".$arritem -> fields['poison']." AND magic='Y'");
				//if (!$test -> fields['id']) {
				//	$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb) VALUES(".$player -> id.",'".$name."',".$arritem -> fields['power'].",'".$arritem -> fields['type']."',".$arritem -> fields['cost'].",".$arritem -> fields['zr'].",".$dur.",".$arritem -> fields['minlev'].",".$maxdur.",1,'Y',".$arritem -> fields['poison'].",".$arritem -> fields['szyb'].")") or error("nie moge dodac!");
				//} else {
				//	$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
				//}
				//$test -> Close();
				//checkexp($player -> exp,$bonus,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'magia',$magic);
				$player -> AwardExp( $bonus );
				$player -> cast = $player -> GetSkill( 'cast', TRUE ) + $magic;
			} else {
				//$db -> Execute("UPDATE players SET magia=magia+0.01 WHERE id=".$player -> id);
				$player -> cast += 0.01;
				$smarty -> assign ("Message", "Probowales umagicznic ".$arritem -> fields['name']." ale niestety nie udalo sie. Na skutek nieudanego zaklecia przedmiot niszczy sie! Dostajesz 0.01 do umiejetnosci rzucania czarow.");
				if( $item['amount'] <=1 ) {
					$player -> EquipDelete( $item['id'] );
				}
				else {
					$player -> SetEquip( 'backpack', $key, array( 'amount' => ( $item['amount'] -1 ) ) );
				}
			}
		}
		if ($spell['name'] == 'Umagicznienie przedmiotu') {
			if ($chance > 100) {
				$olditem = $item;
				if ($item['type'] == 'W' || $item['type'] == 'B') {
					$maxbonus = ($arritem -> fields['szyb'] * 5);
					if ($bonus > $maxbonus) {
						$bonus = $maxbonus;
					}
					$item['szyb'] += $bonus;
					//$agi = $item['zr'];
					$text = 'Zwiekszyles premie z szybkosci';
				} elseif ($item['type'] == 'A' || $item['type'] == 'N') {
					$maxbonus = ($arritem -> fields['zr'] * 5);
					if ($bonus > $maxbonus) {
						$bonus = $maxbonus;
					}				
					$item['zr'] -= $bonus;
					//$speed = $arritem -> fields['szyb'];
					$text = 'Zmniejszyles ograniczenie zreczosci';
				} else {
					error ("Nie mozesz umagicznic tego przedmiotu!");
				}
				$smarty -> assign ("Message", $text." ".$arritem -> fields['name']." o ".$bonus."! Jest to teraz przedmiot magiczny! Zdobyles ".$bonus." Punktow Doswiadczenia oraz ".$magic." punktow w umiejetnosci rzucanie czarow<br>");
				$olditem = $item;
				$item['prefix'] .= $prefix;
				$item['amount'] = 1;
				$player -> EquipAdd( $item );
				if($olditem['amount'] <=1 ) {
					$ret =  $player -> EquipDelete( $olditem['id'] );
					//var_dump( $ret );
				}
				else {
					$player -> SetEquip( 'backpack', $key, array( 'amount' => ( $olditem['amount'] -1 ) ) );
				}
				//$sql="SELECT id FROM equipment WHERE name='".$name."' AND wt=".$arritem -> fields['wt']." AND type='".$arritem -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$arritem -> fields['power']." AND zr=".$agi." AND szyb=".$speed." AND maxwt=".$arritem -> fields['maxwt']." AND poison=".$arritem -> fields['poison']." and magic='Y'";
				//echo "2) ".$sql."<br>";
				//$test = $db -> Execute($sql);
				//if (!$test -> fields['id']) {
				//	$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb) VALUES(".$player -> id.",'".$name."',".$arritem -> fields['power'].",'".$arritem -> fields['type']."',".$arritem -> fields['cost'].",".$agi.",".$arritem -> fields['wt'].",".$arritem -> fields['minlev'].",".$arritem -> fields['maxwt'].",1,'Y',".$arritem -> fields['poison'].",".$speed.")") or error("nie moge dodac!");
				//} else {
				//	$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
				//}
				//checkexp($player -> exp,$bonus,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'magia',$magic);
				$player -> AwardExp( $bonus );
				$player -> cast = $player -> GetSkill( 'cast', TRUE ) + $magic;
			} else {
				//$db -> Execute("UPDATE players SET magia=magia+0.01 WHERE id=".$player -> id);
				$player -> cast += 0.01;
				$smarty -> assign ("Message", "Probowales umagicznic ".$arritem -> fields['name']." ale niestety nie udalo sie. Na skutek nieudanego zaklecia przedmiot niszczy sie! Dostajesz 0.01 do umiejetnosci rzucania czarow.");
				if( $item['amount'] <=1 ) {
					$player -> EquipDelete( $item['id'] );
				}
				else {
					$player -> SetEquip( 'backpack', $key, array( 'amount' => ( $item['amount'] -1 ) ) );
				}
			}
		}
	//$arrspell -> Close();
	//$amount = $arritem -> fields['amount'] - 1;
	//if ($amount > 0) {
	//	$db -> Execute("UPDATE equipment SET amount=amount-1 WHERE id=".$arritem -> fields['id']);
	//} else {
	//	$db -> Execute("DELETE FROM equipment WHERE id=".$arritem -> fields['id']);
	//	}
	//$arritem -> Close();
	}
	
	//$czary -> Close();
}



// inicjalizacja zmiennych
if (!isset($_GET['deakt'])) {
	$_GET['deakt'] = '';
}
if (!isset($_GET['use'])) {
	$_GET['use'] = '';
}
if (!isset($_GET['cast'])) {
	$_GET['cast'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Deaktiv" => $_GET['deakt'], "Learn" => $_GET['use'], "Cast" => $_GET['cast'] ) );

//"Bname" => $arrname1, "Bpower" => $arrpower1, "Bid" => $arrid1, "Dname" => $arrname2, "Dpower" => $arrpower2, "Did" => $arrid2, "Uname" => $arrname3, "Ueffect" => $arrefect, "Uid" => $arrid3, ));
$smarty -> display ('czary.tpl');

require_once("includes/foot.php");
?>
