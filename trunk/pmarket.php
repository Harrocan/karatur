<?php
//@type: F
//@desc: Rynek z mineralami
/**
*   Funkcje pliku:
*   Rynek z mineralami
*
*   @name                 : pmarket.php
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

$title = "Rynek minera³ów";
require_once("includes/head.php");
require_once("class/playerManager.class.php");

checklocation($_SERVER['SCRIPT_NAME']);
//if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta' && $player -> location != 'Imnescar' && $player -> location != 'Iriaebor' && $player -> location != 'Proskur') {
//	error ("Zapomnij o tym");
//}

//$gr = $db -> Execute("SELECT id, copper, zelazo, wegiel, adam, meteo, krysztal, lumber FROM kopalnie WHERE gracz=".$player -> id);

$mins = array( 'mithril' => 'mithril', 'miedz' => 'copper', 'zelazo' => 'iron', 'wegiel' => 'coal', 'adamantyt' => 'adamantium', 'meteoryt' => 'meteor', 'krysztal' => 'crystal', 'drewno' => 'wood' );
$names = array( 'mithril' => 'mithrilu', 'miedz' => 'miedzi', 'zelazo' => 'zelaza', 'wegiel' => 'wegla', 'adamantyt' => 'adamantium', 'meteoryt' => 'meteorytu', 'krysztal' => 'krysztalow', 'drewno' => 'drewna' );

$popolsku =array( 'mithril' => 'mithril', 'miedz' => 'mied¼', 'zelazo' => '¿elazo', 'wegiel' => 'wêgiel', 'adamantyt' => 'adamantyt', 'meteoryt' => 'meteoryt', 'krysztal' => 'kryszta³', 'drewno' => 'drewno' );

// przypisanie zmiennej
$smarty -> assign(array("Message" => '', "Previous" => '', "Next" => ''));

if (isset ($_GET['view']) && $_GET['view'] == 'market') {
	if (empty($_POST['szukany'])) {
	$msel = $db -> Execute("SELECT id FROM pmarket");
		$_POST['szukany'] = '';
	} else {
	$_POST['szukany'] = strip_tags($_POST['szukany']);
	$_POST['szukany'] = str_replace("*","%", $_POST['szukany']);
	$msel = $db -> Execute("SELECT id FROM pmarket WHERE nazwa LIKE '".$_POST['szukany']."'");
	}
	$oferty = $msel -> RecordCount();
	$msel -> Close();
	if ($oferty == 0) {
	error ("Nie ma ofert na rynku. <a href=\"pmarket.php\">Wróæ</a>");
	}
	if (!isset($_GET['limit'])) {
		$_GET['limit'] = 0;
	}
	if (!isset($_GET['lista'])) {
		$_GET['lista'] = 'id';
	}
	if ($_GET['limit'] < $oferty) {
	if (empty($_POST['szukany'])) {
		$pm = $db -> SelectLimit("SELECT * FROM pmarket ORDER BY ".$_GET['lista']." DESC", 30, $_GET['limit']);
	} else {
		$pm = $db -> SelectLimit("SELECT * FROM pmarket WHERE nazwa LIKE '".$_POST['szukany']."' ORDER BY ".$_GET['lista']." DESC", 30, $_GET['limit']);
	}
	$arrname = array();
	$arramount = array();
	$arrcost = array();
	$arrseller = array();
	$arrlink = array();
	$arruser = array();
	$i = 0;
	while (!$pm -> EOF) {
		$arrname[$i] = $popolsku[$pm -> fields['nazwa']];
		$arramount[$i] = $pm -> fields['ilosc'];
		$arrcost[$i] = $pm -> fields['cost'];
		$arrseller[$i] = $pm -> fields['seller'];
		$seller = $db -> Execute("SELECT user FROM players WHERE id=".$pm -> fields['seller']);
		$arruser[$i] = $seller -> fields['user'];
		$seller -> Close();
		if ($player -> id == $pm -> fields['seller']) {
			$arrlink[$i] = "<td>- <a href=pmarket.php?wyc=".$pm -> fields['id'].">Wycofaj</a></td></tr>";
		} else {
			$arrlink[$i] = "<td>- <a href=pmarket.php?buy=".$pm -> fields['id'].">Kup</a></td></tr>";
		}
		$pm -> MoveNext();
		$i = $i + 1;
	}
	$pm -> Close();
	$smarty -> assign ( array("Name" => $arrname, "Amount" => $arramount, "Cost" => $arrcost, "Seller" => $arrseller, "Link" => $arrlink, "User" => $arruser));
	if ($_GET['limit'] >= 30) {
		$lim = $_GET['limit'] - 30;
		$smarty -> assign ("Previous", "<form method=\"post\" action=\"pmarket.php?view=market&limit=".$lim."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Poprzednie\"></form> ");
	}
	$_GET['limit'] = $_GET['limit'] + 30;
	if ($oferty > 30 && $_GET['limit'] < $oferty) {
		$smarty -> assign ("Next", " <form method=\"post\" action=\"pmarket.php?view=market&limit=".$_GET['limit']."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Nastêpne\"></form>");
	}
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'add') {
	if (isset ($_GET['step']) && $_GET['step'] == 'add') {
		if (!isset($_POST['mineral'])) {
			error("Zapomnij o tym!");
		}
// 	if ($_POST['mineral'] == 'mithril') {
// 		$nazwa = 'mithrilu';
// 		if ($_POST['ilosc'] > $player -> platinum) {
// 		error ("Nie masz takiej ilosci ".$nazwa);
// 		}
// 	} elseif ($_POST['mineral'] == 'miedz') {
// 		$min = 'copper';
// 		$nazwa = 'miedzi';
// 		if ($_POST['ilosc'] > $gr -> fields['copper']) {
// 		error ("Nie masz takiej ilosci ".$nazwa);
// 		}
// 	} elseif ($_POST['mineral'] == 'zelazo') {
// 		$min = 'zelazo';
// 		$nazwa = 'zelaza';
// 		if ($_POST['ilosc'] > $gr -> fields['zelazo']) {
// 		error ("Nie masz takiej ilosci ".$nazwa);
// 		}
// 	} elseif ($_POST['mineral'] == 'wegiel') {
// 		$min = 'wegiel';
// 		$nazwa = 'wegla';
// 		if ($_POST['ilosc'] > $gr -> fields['wegiel']) {
// 		error ("Nie masz takiej ilosci ".$nazwa);
// 		}
// 	} elseif ($_POST['mineral'] == 'adamantyt') {
// 		$min = 'adam';
// 		$nazwa = 'adamantium';
// 		if ($_POST['ilosc'] > $gr -> fields['adam']) {
// 		error ("Nie masz takiej ilosci ".$nazwa);
// 		}
// 	} elseif ($_POST['mineral'] == 'meteoryt') {
// 		$min = 'meteo';
// 		$nazwa = 'meteorytu';
// 		if ($_POST['ilosc'] > $gr -> fields['meteo']) {
// 		error ("Nie masz takiej ilosci ".$nazwa);
// 		}
// 	} elseif ($_POST['mineral'] == 'krysztal') {
// 		$min = 'krysztal';
// 		$nazwa = 'krysztalow';
// 		if ($_POST['ilosc'] > $gr -> fields['krysztal']) {
// 		error ("Nie masz takiej ilosci ".$nazwa);
// 		}
// 	} elseif ($_POST['mineral'] == 'drewno') {
// 		$min = 'lumber';
// 		$nazwa = 'drewna';
// 		if ($_POST['ilosc'] > $gr -> fields['lumber']) {
// 			error ("Nie masz takiej ilosci ".$nazwa);
// 		}
// 	} else {
// 		error ("Zapomnij o tym");
// 	}
	

	if( !isset( $mins[$_POST['mineral']] ) ) 
	{
		error( 'Nieprawid³owy surowiec !' );
	}
	
	$min = $mins[$_POST['mineral']];
	$nazwa = $names[$_POST['mineral']];
	if (!ereg("^[1-9][0-9]*$", $_POST['ilosc'])) {
		error ("Zapomnij o tym.");
	}
	if (!ereg("^[1-9][0-9]*$", $_POST['cost'])) {
		error ("Nie ma za darmo.");
	}
	
	if( $player -> $min < $_POST['ilosc'] ) {
		error( "Nie masz takiej ilo¶ci $nazwa" );
	}
	//if ($_POST['mineral'] == 'mithril') {
	//	$db -> Execute("UPDATE players SET platinum=platinum-".$_POST['ilosc']." WHERE id=".$player -> id);
	//} else {
	//	$db -> Execute("UPDATE kopalnie SET ".$min."=".$min."-".$_POST['ilosc']." WHERE gracz=".$player -> id);
	//}
	$player -> $min -= $_POST['ilosc'];
	$db -> Execute("INSERT INTO pmarket (seller, ilosc, cost, nazwa) VALUES(".$player -> id.",".$_POST['ilosc'].",".$_POST['cost'].",'".$_POST['mineral']."')") or error("Nie moge dodac.");
	$smarty -> assign("Message", "Dodales <b>".$_POST['ilosc']."</b> ".$nazwa." na rynku za <b>".$_POST['cost']."</b>  sztuk zlota. <a href=\"pmarket.php?view=add\">Odswiez</a>");
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'del') {
	$del = $db -> Execute("SELECT * FROM pmarket WHERE seller=".$player -> id);
	while (!$del -> EOF) {
		$min = $mins[$del -> fields['nazwa']];
		$player -> $min += $del -> fields['ilosc'];
		$del -> MoveNext();
	}
	$db -> Execute("DELETE FROM pmarket WHERE seller=".$player->id);
	
	$del -> Close();
	$smarty -> assign("Message", "Usunales wszystkie swoje oferty i twoje mineraly wrocily do ciebie. (<A href=pmarket.php>wróæ</a>)");
}

if (isset($_GET['buy'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
		error ("Zapomnij o tym.");
	}
	$buy = $db -> Execute("SELECT * FROM pmarket WHERE id=".$_GET['buy']);
	if (!$buy -> fields['id']) {
		error ("Nie ma ofert. (<a href=pmarket.php?view=market>wroc</a>)");
	}
	if ($buy -> fields['seller'] == $player -> id) {
		error ("Nie mozesz kupiæ swoich minera³ów!. (<a href=pmarket.php?view=market>wróæ</a>)");
	}
	$seller = $db -> Execute("SELECT user FROM players WHERE id=".$buy -> fields['seller']);
	$smarty -> assign( array("Name" => $buy -> fields['nazwa'], "Amount1" => $buy -> fields['ilosc'], "Itemid" => $buy -> fields['id'], "Cost" => $buy -> fields['cost'], "Seller" => $seller -> fields['user']));
	$buy -> Close();
	
	if (isset($_GET['step']) && $_GET['step'] == 'buy') {
		if (!isset($_POST['amount'])) {
			error("Podaj ile minera³ów chcesz kupiæ!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym.");
		}
		$buy = $db -> Execute("SELECT * FROM pmarket WHERE id=".$_GET['buy']);
		$price = $_POST['amount'] * $buy -> fields['cost'];
		if ($price > $player -> gold) {
			error ("Nie staæ ciê. (<a href=pmarket.php?view=market>wróæ</a>)");
		}
		if ($_POST['amount'] > $buy -> fields['ilosc']) {
			error("Nie ma tyle ".$buy -> fields['nazwa']." na rynku. (<a href=pmarket.php>wróæ</a>)");
		}
		/*
		if ($buy -> fields['nazwa'] == 'meteoryt') {
		$min = 'meteo';
		}
		if ($buy -> fields['nazwa'] == 'krysztal') {
		$min = 'krysztal';
		}
		if ($buy -> fields['nazwa'] == 'miedz') {
		$min = 'copper';
		}
		if ($buy -> fields['nazwa'] == 'zelazo') {
		$min = 'zelazo';
		}
		if ($buy -> fields['nazwa'] == 'wegiel') {
		$min = 'wegiel';
		}
		if ($buy -> fields['nazwa'] == 'adamantyt') {
		$min = 'adam';
		}
		if ($buy -> fields['nazwa'] == 'drewno') {
		$min = 'lumber';
		}
		if ($buy -> fields['nazwa'] == 'mithril') {
			$db -> Execute("UPDATE players SET platinum=platinum+".$_POST['amount']." where id=".$player -> id);
		} else {
			if (!$gr -> fields['id']) {
				$db -> Execute("INSERT INTO kopalnie (gracz, ".$min.") VALUES(".$player -> id.",".$_POST['amount'].")");
			} else {
				$db -> Execute("UPDATE kopalnie SET ".$min."=".$min."+".$_POST['amount']." WHERE gracz=".$player -> id);
			}
		}
		*/
		$profil= new playerManager( $buy->fields['seller'] );
		$min = $mins[$buy -> fields['nazwa']];
		$player -> $min += $_POST['amount'];
		
	
	//	$db -> Execute("UPDATE players SET bank=bank+'".$price."' WHERE id='".$buy -> fields['seller']."'");
		//PutSignal( $buy -> fields['seller'], 'res' );
		//$db -> Execute("UPDATE players SET credits=credits-".$price." WHERE id=".$player -> id);
		$player -> gold -= $price;
		$profil -> addRes( 'bank',$price );

		if ($_POST['amount'] == $buy -> fields['ilosc']) {
				$db -> Execute("DELETE FROM pmarket WHERE id=".$buy -> fields['id']);
		} else {
			$db -> Execute("UPDATE pmarket set ilosc=ilosc-".$_POST['amount']." WHERE id=".$buy -> fields['id']);
		}
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$buy -> fields['seller'].",'<b><a href=view.php?view=".$player -> id.">".$player -> user."</b></a> zaakceptowa³ twoja ofertê za ".$_POST['amount']." sztuk ".$buy -> fields['nazwa'].". Dosta³e¶ <b>".$price."</b> sztuk z³ota do banku.','".$newdate."')") or error("Nie mogê dodaæ do dziennika.");
		$smarty -> assign("Message", "Kupi³e¶ <b>".$_POST['amount']." sztuk </b> ".$buy -> fields['nazwa']." za <b>".$price."</b> sztuk z³ota. (<A href=pmarket.php>wróæ</a>)",'done');
	}
}

if (isset($_GET['wyc'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['wyc'])) {
	error ("Zapomnij o tym.");
	}
	$dwyc = $db -> Execute("SELECT * FROM pmarket WHERE id=".$_GET['wyc']);
	if ($dwyc -> fields['seller'] != $player -> id) {
	error ("Nie mozesz wycofac cudzej oferty!");
	}
	$min = $mins[$dwyc -> fields['nazwa']];
	/*
	if ($dwyc -> fields['nazwa'] == 'meteoryt') {
	$min = 'meteo';
	}
	if ($dwyc -> fields['nazwa'] == 'miedz') {
	$min = 'copper';
	}
	if ($dwyc -> fields['nazwa'] == 'zelazo') {
	$min = 'zelazo';
	}
	if ($dwyc -> fields['nazwa'] == 'wegiel') {
	$min = 'wegiel';
	}
	if ($dwyc -> fields['nazwa'] == 'adamantyt') {
	$min = 'adam';
	}
	if ($dwyc -> fields['nazwa'] == 'krysztal') {
	$min = 'krysztal';
	}
	if ($dwyc -> fields['nazwa'] == 'drewno') {
	$min = 'lumber';
	}
	if ($dwyc -> fields['nazwa'] == 'mithril') {
	$db -> Execute("UPDATE players SET platinum=platinum+".$dwyc -> fields['ilosc']." WHERE id=".$dwyc -> fields['seller']);
	} else {
	$db -> Execute("UPDATE kopalnie SET ".$min."=".$min."+".$dwyc -> fields['ilosc']." WHERE gracz=".$dwyc -> fields['seller']);
	}*/
	$player -> $min += $dwyc -> fields['ilosc'];
	$db -> Execute("DELETE FROM pmarket WHERE id=".$_GET['wyc']);
	$smarty -> assign("Message", "Usun±³e¶ swoj± ofertê i twoje minera³y wróci³y do ciebie. (<A href=pmarket.php>wróæ</a>)");
}

//spis wszystkich ofert na rynku
if (isset($_GET['view']) && $_GET['view'] == 'all') {
	$oferts = $db -> Execute("SELECT nazwa FROM pmarket GROUP BY nazwa");
	$arrname = array();
	$arramount = array();
	$i = 0;
	while (!$oferts -> EOF) {
	$arrname[$i] = $popolsku[$oferts -> fields['nazwa']];
	$arramount[$i] = 0;
	$query = $db -> Execute("SELECT id FROM pmarket WHERE nazwa='".$arrname[$i]."'");
	while (!$query -> EOF) {
		$arramount[$i] = $arramount[$i] + 1;
		$query -> MoveNext();
	}
	$query -> Close();
	$oferts -> MoveNext();
	$i = $i + 1;
	}
	$oferts -> Close();
	$smarty -> assign( array("Name" => $arrname, "Amount" => $arramount, "Message" => "<br />(<a href=\"pmarket.php\">wróæ</a>)"));
}


if (isset ($_GET['view']) && $_GET['view'] == 'private') {
	$msel = $db -> Execute("SELECT id FROM pmarket where seller='".$player -> id."'");
	$oferty = $msel -> RecordCount();
	$msel -> Close();
	if ($oferty == 0) {
	error ("Na rynku nie ma ¿adnych Twoich towarów wystawionych na sprzeda¿. <a href=\"pmarket.php\">Wróæ</a>");
	}
	if (!isset($_GET['limit'])) {
		$_GET['limit'] = 0;
	}
	if (!isset($_GET['lista'])) {
		$_GET['lista'] = 'id';
	}
	if ($_GET['limit'] < $oferty) {
	$pm = $db -> SelectLimit("SELECT * FROM pmarket WHERE seller=".$player -> id." ORDER BY ".$_GET['lista']." DESC", 30, $_GET['limit']);
	$arrname = array();
	$arramount = array();
	$arrcost = array();
	$arrseller = array();
	$arrlink = array();
	$arruser = array();
	$i = 0;
	while (!$pm -> EOF) {
		$arrname[$i] = $popolsku[$pm -> fields['nazwa']];
		$arramount[$i] = $pm -> fields['ilosc'];
		$arrcost[$i] = $pm -> fields['cost'];
		$arrseller[$i] = $pm -> fields['seller'];
		if ($player -> id == $pm -> fields['seller']) {
			$arrlink[$i] = "<td><a href=pmarket.php?wyc=".$pm -> fields['id'].">Wycofaj</a></td></tr>";
		}
		$pm -> MoveNext();
		$i = $i + 1;
	}
	$pm -> Close();
	$smarty -> assign ( array("Name" => $arrname, "Amount" => $arramount, "Cost" => $arrcost, "Seller" => $arrseller, "Link" => $arrlink, "User" => $arruser));
	if ($_GET['limit'] >= 30) {
		$lim = $_GET['limit'] - 30;
		$smarty -> assign ("Previous", "<form method=\"post\" action=\"pmarket.php?view=market&limit=".$lim."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Poprzednie\"></form> ");
	}
	$_GET['limit'] = $_GET['limit'] + 30;
	if ($oferty > 30 && $_GET['limit'] < $oferty) {
		$smarty -> assign ("Next", " <form method=\"post\" action=\"pmarket.php?view=market&limit=".$_GET['limit']."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Nastêpne\"></form>");
	}
	}
}





// inicjalizacja zmiennych
if (!isset($_GET['view'])) {
	$_GET['view'] = '';
}
if (!isset($_GET['wyc'])) {
	$_GET['wyc'] = '';
}
if (!isset($_GET['buy'])) {
	$_GET['buy'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign( array("View" => $_GET['view'], "Delete" => $_GET['wyc'], "Buy" => $_GET['buy']));
$smarty -> display('pmarket.tpl');

require_once("includes/foot.php");
?>

