<?php
/**
*   Funkcje pliku:
*   Opcje ekwipunku gracza - zakladanie oraz zdejmowanie ekwipunku, naprawa, sprzedawanie itp
*
*   @name                 : equip.php                            
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : thindil <thindil@users.sourceforge.net>
*   @version              : 0.7 beta
*   @since                : 05.01.2005
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

$title = "Ekwipunek";
require_once("includes/head.php");
require_once("includes/functions.php");


//inicjalizacja zmiennych
if ( !isset( $_GET['step'] ) )
	$_GET['step'] = '';
if( !isset( $_GET['poison'] ) )
	$_GET['poison'] = '';

// przypisanie zmiennych
$smarty -> assign(array("Arrowhead" => '', "Action" => '', "Potions" => '', "Hide" => '', "Repairequip" => 'napraw', "Arrows1" => ''));

if (isset($_GET['schowaj'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['schowaj'])) {
		$player -> Unequip( $_GET['schowaj'] );
		error ("schowano !",'done');
	}
}
if (isset($_GET['equip'])) {
	$res = $player -> Equip( $_GET['equip'] );
	if( $res )
		error( "Zalozono !",'done');
	else
		error( "Blad podczas zakladania ekwipunku", 'error' );
}
if (isset($_GET['drink'])) {
	$ret = $player -> PotionDrink( $_GET['drink'] );
	if( $ret )
		error( "Mikstura wykorzystana", 'done' );
	else
		error( "Blad podczas korzystania z mikstury" );
}

if( !empty( $_GET['poison'] ) ) {
	if( $_GET['step'] == 'poison' ) {
		if( empty( $_POST['wpn'] ) ) {
			error( "Zapomnij o tym" );
		}
		$wpn = $player -> EquipSearch( array( 'id' => $_POST['wpn'] ) );
		if( empty( $wpn ) ) {
			error( "Nie masz takiej broni !" );
		}
		$key = key( $wpn );
		$wpn = $wpn[$key];
		if( $wpn['type'] != 'W' ) {
			error( "Mozesz zatruwac tylko bronie !" );
		}
		if( strpos( $wpn['prefix'], 'Zatruty' ) !== FALSE ) {
			error( "Ten przedmiot jest juz zatruty !" );
		}
		
		$potion = $player -> EquipSearch( array( 'id' => $_GET['poison'] ), 'potions' );
		if( empty( $potion ) ) {
			error( "Nie masz takiej mikstury !" );
		}
		$keyp = key( $potion );
		$potion = $potion[$keyp];
		if( $potion['type'] != 'P' ) {
			error( "To nie jest mikstura zatruwajaca !" );
		}
		
		
		if( $potion['amount'] > 1 ) {
			$player -> SetEquip( 'potions', $keyp, array( 'amount' => $potion['amount'] - 1 ) );
		}
		else {
			$player -> EquipDelete( $_GET['poison'], 'potions' );
		}
		
		if( $wpn['amount'] > 1 ) {
			$player -> SetEquip( 'backpack', $key, array( 'amount' => $wpn['amount'] - 1 ) );
		}
		else {
			$player -> EquipDelete( $wpn['id'], 'backpack' );
		}
			$wpn['amount'] = 1;
			$wpn['poison'] = $potion['power'];
			$wpn['prefix'] = "Zatruty {$wpn['prefix']}";
			$player -> EquipAdd( $wpn );
		//}
		//else {
		//	$player -> SetEquip( 'backpack', $key, array( 'poison' => $potion['power'], 'prefix' => "Zatruty ".$wpn['prefix'] ) );
		//}
		
		error( "Zatrules {$wpn['name']}", 'done' );
	}
	$items = $player -> EquipSearch( array( 'type' => 'W' ) );
	//$items = array_values( $items );
	$smarty -> assign( "Items", $items );
}


$equipname = array( 'weapon' => 'Bron', 'arrows' => 'Kolczan', 'armor' => 'Zbroja', 'helm' => 'Helm', 'shield' => 'Tarcza', 'knee' => 'Nagolenniki' );
$equip = array();
$equip = $player -> GetEquipped( array('weapon', 'arrows', 'armor', 'helm', 'shield', 'knee' ) );
foreach( $equip as $k => $it ) {
	//echo "$k => $it : {$equipname[$k]}<br>";
	$equip[$k]['catname'] = $equipname[$k];
	if( in_array( $it['type'], array( 'W', 'B', 'R' ) ) ) {
		$equip[$k]['suff'] = 'obrazen';
		$it['suff'] = 'obrazen';
	}
	if( in_array( $it['type'], array( 'A', 'H', 'D', 'N' ) ) ) {
		$equip[$k]['suff'] = 'obrony';
		$it['suff'] = 'obrony';
	}
	if( in_array( $it['type'], array( 'Z' ) ) ) {
		$equip[$k]['suff'] = '% many';
		$it['suff'] = '% many';
	}
	if( in_array( $it['type'], array( 'S' ) ) ) {
		$equip[$k]['suff'] = '% mocy czarow';
		$it['suff'] = '% mocy czarow';
	}
	if( !empty( $it['img_file'] ) && is_file( "images/items/{$it['type']}/{$it['img_file']}" ) ) {
		$equip[$k]['imglink'] = "images/items/{$it['type']}/{$it['img_file']}";
		$it['imglink'] = "images/items/{$it['type']}/{$it['img_file']}";
	}
	else {
		$equip[$k]['imglink'] = "images/items/na.gif";
		$it['imglink'] = "images/items/na.gif";
	}
	
	$text = "<table border=0 cellpadding=0 cellspacing=0><tr><td rowspan=7><img src='itemimage.php?path={$it['imglink']}&wt={$it['wt']}&maxwt={$it['maxwt']}&type={$it['type']}&magic={$it['magic']}&poison={$it['poison']}' alt='image'></td><td><b>{$it['prefix']} {$it['name']}</b></td></tr><tr><td>Min. poziom: {$it['minlev']}</td></tr><tr><td>+".($it['power'] + $it['poison'])." {$it['suff']}</td></tr>";
	if( $it['zr'] != 0)
		$text .= "<tr><td>-{$it['zr']} %zrecznosci</td></tr>";
	if( $it['szyb'] != 0 )
		$text .= "<tr><td>+{$it['szyb']} %szybkosci</td></tr>";
	if( $it['type'] == 'R')
		$text .= "<tr><td>{$it['wt']} strzal pozostalo</td></tr>";
	elseif( in_array( $it['type'], array( 'W', 'B', 'A', 'H', 'N' ) ) )
		$text .= "<tr><td>Wytrzymalosc: {$it['wt']}/{$it['maxwt']}</td></tr>";
	$text .= "<tr><td><a href='?schowaj={$k}'>zdejmij</a></td></tr></table>";
	
	$equip[$k]['popText'] = $text;
	//$equip[$k]['desc'] = "<a href=# onmouseover=\"return overlib('yoooo',CAPTION,' ',CLOSETEXT,'zamknij',FGCOLOR,'#000000',BGCOLOR,'#0C1115',BORDER,1,STICKY,VAUTO);\" onmouseout=\"nd();\">{
	
}

//print_r( $equip );
$smarty -> assign( "Equip", $equip );

$weapons = array_values( array_merge( $player -> EquipSearch( array( 'type' => 'W' ) ), $player -> EquipSearch( array( 'type' => 'B' ) ) ) );
$backpack[] = array( 'name' => 'Bronie', 'pref' => '+', 'suff' => 'obrazen', 'fields' => $weapons );
$backpack[] = array( 'name' => 'Rozdzki', 
					'pref' => '+', 
					'suff' => '% mocy czarow', 
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'S' ) ) ) );
$backpack[] = array( 'name' => 'Zbroje', 'pref' => '+', 'suff' => 'obrony', 'fields' => array_values( $player -> EquipSearch( array( 'type' => 'A' ) ) ) );
$backpack[] = array( 'name' => 'Szaty', 
					'pref' => '+', 
					'suff' => '% many', 
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'Z' ) ) ) );
$backpack[] = array( 'name' => 'Helmy', 'pref' => '+', 'suff' => 'obrony', 'fields' => array_values( $player -> EquipSearch( array( 'type' => 'H' ) ) ) );
$backpack[] = array( 'name' => 'Tarcze', 
					'pref' => '+', 
					'suff' => 'obrony', 
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'D' ) ) ) );
$backpack[] = array( 'name' => 'Nagolenniki', 
					'pref' => '+', 
					'suff' => 'obrony', 
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'N' ) ) ) );
$backpack[] = array( 'name' => 'Strzaly', 
					'pref' => '+', 
					'suff' => 'obrazen', 
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'R' ) ) ) );
$backpack[] = array( 'name' => 'Groty', 
					'pref' => '+', 
					'suff' => 'obrazen', 
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'G' ) ) ) );

$potions[] = array( 'name' => 'Mikstury many',
					'suff' => 'pkt. many',
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'M' ), 'potions' ) ) );
$potions[] = array( 'name' => 'Mikstury zycia',
					'suff' => 'pkt. zycia',
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'Z' ), 'potions' ) ) );
$potions[] = array( 'name' => 'Mikstury wskrzeszenia',
					'suff' => 'wskrzeszenie',
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'W' ), 'potions' ) ) );
$potions[] = array( 'name' => 'Mikstury zatrucia',
					'suff' => 'ptk. obrazen',
					'fields' => array_values( $player -> EquipSearch( array( 'type' => 'P' ), 'potions' ) ) );

foreach( $backpack as $key1 => $group ) {
	foreach( $group['fields'] as $key2 => $item ) {
		if( !empty( $item['img_file'] ) && is_file( "images/items/{$item['type']}/{$item['img_file']}" ) ) {
			$backpack[$key1]['fields'][$key2]['imglink'] = "images/items/{$item['type']}/{$item['img_file']}";
		}
		else
			$backpack[$key1]['fields'][$key2]['imglink'] = "images/items/na.gif";
	}
}

foreach( $potions as $key1 => $group ) {
	foreach( $group['fields'] as $key2 => $item ) {
		if( !empty( $item['img_file'] ) && is_file( "images/potions/{$item['type']}/{$item['img_file']}" ) ) {
			$potions[$key1]['fields'][$key2]['imglink'] = "images/potions/{$item['type']}/{$item['img_file']}";
		}
		else
			$potions[$key1]['fields'][$key2]['imglink'] = "images/potions/na.gif";
	}
}

//print_r($backpack);

$smarty -> assign( "Back", $backpack );
$smarty -> assign( "Pot", $potions );

if (isset($_GET['sell'])) {
	if ( !in_array( $_GET['sell'], array( 'one', 'all' ) ) ) {
		error ("Zapomnij o tym!");
	}
	if( empty( $_GET['id'] ) )
		error( "Podaj ID przedmiotu" );
	$item = $player -> EquipSearch( array( 'id' => $_GET['id'] ) );
	if( empty( $item ) ) {
		error( "Nie ma takiego przedmiotu !" );
	}
	$key = key( $item );
	$item = array_shift( $item );
	switch( $_GET['sell'] ) {
		case 'one' :
			$goldgain = 0;
			if( $item['type'] == 'R' ) {
				$costone = round( $item['cost'] / 20 );
				$goldgain = $costone * $item['wt'];
			}
			else {
				$goldgain = $item['cost'];
			}
			if( $item['amount'] <= 1 ) {
				$player -> EquipDelete( $item['id'] );
			}
			else {
				$item['amount'] -= 1;
				$player -> SetEquip( 'backpack', $key, array( 'amount' => $item['amount'] ) );
			}
			$player -> gold += $goldgain;
			break;
		case 'all' :
			$goldgain = 0;
			if( $item['type'] == 'R' ) {
				$costone = round( $item['cost'] / 20 );
				$goldgain = ($costone * $item['wt']) * $item['amount'];
			}
			else {
				$goldgain = $item['cost'] * $item['amount'];
			}
			//if( $item['amount'] <= 1 ) {
			$player -> EquipDelete( $item['id'] );
			//}
			//else {
			//	$item['amount'] -= 1;
			//	$player -> SetEquip( 'backpack', $key, array( 'amount' => $item['amount'] ) );
			//}
			$player -> gold += $goldgain;
			break;
	}
}
	

if (isset($_GET['repair'])) {
	if( $_GET['repair'] == 'use' ) {
		$items = $player -> GetEquipped( array( 'weapon', 'armor', 'helm', 'shield', 'knee' ) );
		$cost = 0;
		foreach( $items as $key => $item ) {
			if( $item['wt'] != $item['maxwt'] && $item['type'] != 'Z' ) {
				$cost += $item['power'] * ( $item['maxwt'] - $item['wt'] );
			}
			else {
				unset( $items[$key] );
			}
		}
		if( $cost > $player -> gold ) {
			error( "Masz niewystarczajaco pieniedzy. Naprawa kosztuje $cost sztuk zlota" );
		}
		//error( "Masz niewystarczajaco pieniedzy. Naprawa kosztuje $cost sztuk zlota" );
		$player -> gold -= $cost;
		foreach( $items as $key => $item ) {
			$player -> SetEquip( 'equip', $key, array( 'wt' => $item['maxwt'] ) );
		}
		error( "Naprawiles wszystkie uzywane czesci za $cost sztuk zlota", 'done' );
	}
	else {
		$item = $player -> EquipSearch( array( 'id' => $_GET['repair'] ) );
		if( empty( $item ) )
			error( "Nie ma takiego przedmiotu" );
		$key = key( $item );
		$item = array_shift( $item );
		if( in_array( $item, array( 'R', 'S', 'Z' ) ) )
			error( "Tego typu przedmiotow nie mozna naprawiac !" );
		if( $item['wt'] ==  $item['maxwt'] )
			error( "Tego przedmiotu nie trzeba naprawiac !" );
		$cost = $item['power'] * ( $item['maxwt'] - $item['wt'] ) * $item['amount'];
		if( $player -> gold < $cost )
			error( "Nie masz wystarczajaco pieniedzy ! Koszt naprawy wynosi $cost sztuk zlota !" );
		$player -> gold -= $cost;
		$player -> SetEquip( 'backpack', $key, array( 'wt' => $item['maxwt'] ) );
		error( "Naprawiles {$item['amount']} sztuk <b>{$item['name']}</b>. Kosztowalo Cie to $cost zlota",'done' );
	}
}

//zatruwanie broni
/*
if (isset ($_GET['poison'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['poison'])) {
		error ("Zapomnij o tym!");
	}
	$poison = $db -> Execute("SELECT id, moc, amount FROM mikstury WHERE id=".$_GET['poison']." AND typ='P' AND gracz=".$player -> id);
	if (!$poison -> fields['id']) {
		error ("Nie masz takiej mikstury!");
	}
	$wep = $db -> Execute("SELECT id, name, amount FROM equipment WHERE owner=".$player -> id." AND type='W' AND status='U' AND poison=0");
	$arrname = array();
	$arrid = array();
	$arramount = array();
	$i = 0;
	while (!$wep -> EOF) {
		$arrname[$i] = $wep -> fields['name'];
		$arrid[$i] = $wep -> fields['id'];
		$arramount[$i] = $wep -> fields['amount'];
$i = $i + 1;
$wep -> MoveNext();
	}
	$wep -> Close();
	$smarty -> assign ( array("Poisonitem" => $arrname, "Poisonid" => $arrid, "Poisonamount" => $arramount));
	if (isset($_GET['step']) && $_GET['step'] == 'poison') {
		if (!ereg("^[1-9][0-9]*$", $_POST['weapon'])) {
			error ("Zapomnij o tym!");
		}
		$item = $db -> Execute("SELECT * FROM equipment WHERE id=".$_POST['weapon']);
		if (!$item -> fields['id']) {
			error ("Nie ma takiego przedmiotu!");
		}
		if ($item -> fields['type'] != 'W') {
			error ("To nie jest bron!");
		}
		if ($item -> fields['owner'] != $player -> id) {
			error ("To nie jest twoj przedmiot!");
		}
		if ($item -> fields['poison'] > 0) {
			error ("Ten przedmiot juz jest zatruty!");
		}
		if ($item -> fields['status'] != 'U') {
			error ("Nie masz tego przedmiotu w plecaku!");
		}
		$name = "Zatruty ".$item -> fields['name'];
		$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$name."' AND wt=".$item -> fields['wt']." AND type='W' AND status='U' AND owner=".$player -> id." AND power=".$item -> fields['power']." AND zr=".$item -> fields['zr']." AND szyb=".$item -> fields['szyb']." AND maxwt=".$item -> fields['maxwt']." AND poison=".$poison -> fields['moc']);
		if (!$test -> fields['id']) {
			$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb) VALUES(".$player -> id.",'".$name."',".$item -> fields['power'].",'W',".$item -> fields['cost'].",".$item -> fields['zr'].",".$item -> fields['wt'].",".$item -> fields['minlev'].",".$item -> fields['maxwt'].",1,'N',".$poison -> fields['moc'].",".$item -> fields['szyb'].")") or error("nie moge dodac!");
		} else {
			$db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
		}
$test -> Close();
$amount = $poison -> fields['amount'] - 1;
if ($amount < 1) {
	$db -> Execute("DELETE FROM mikstury WHERE id=".$poison -> fields['id']);
} else {
	$db -> Execute("UPDATE mikstury SET amount=".$amount." WHERE id=".$poison -> fields['id']);
}
$poison -> Close();
$iamount = $item -> fields['amount'] - 1;
		if ($iamount > 0) {
			$db -> Execute("UPDATE equipment SET amount=amount-1 WHERE id=".$item -> fields['id']);
		} else {
			$db -> Execute("DELETE FROM equipment WHERE id=".$item -> fields['id']);
		}
$smarty -> assign ("Item", "Zatrules ".$item -> fields['name'].". <a href=\"equip.php\">Odswiez</a>");
$item -> Close();
}
$poison -> Close();
}
*/



//przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Poison" => $_GET['poison'], "Step" => $_GET['step']));
$smarty -> display ('equip.tpl');




require_once("includes/foot.php");
?>

