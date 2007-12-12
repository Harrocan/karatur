<?php
//@type: F
//@desc: Rynek z ziolami
/**
*   Funkcje pliku:
*   Rynek z ziolami
*
*   @name                 : hmarket.php
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

$title = "Rynek ziol";
require_once("includes/head.php");
require_once("class/playerManager.class.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta' && $player -> location != 'Imnescar' && $player -> location != 'Proskur' && $player -> location != 'Iriaebor' && $player -> location != 'Proskur') {
	error ("Zapomnij o tym");
}*/
//$gr = $db -> Execute("SELECT id, illanias, illani, nutari, dynallca FROM herbs WHERE gracz=".$player -> id);

// przypisanie zmiennej
$smarty -> assign(array("Message" => '', "Previous" => '', "Next" => ''));

if (isset ($_GET['view']) && $_GET['view'] == 'market') {
	if (empty($_POST['szukany'])) {
	$msel = $db -> Execute("SELECT id FROM hmarket");
		$_POST['szukany'] = '';
	} else {
	$_POST['szukany'] = strip_tags($_POST['szukany']);
	$_POST['szukany'] = str_replace("*","%", $_POST['szukany']);
	$msel = $db -> Execute("SELECT id FROM hmarket WHERE nazwa LIKE '".$_POST['szukany']."'");
	}
	$oferty = $msel -> RecordCount();
	$msel -> Close();
	if (!isset($_GET['limit'])) {
		$_GET['limit'] = 0;
	}
	if (!isset($_GET['lista'])) {
		$_GET['lista'] = 0;
	}
	if ($oferty == 0) {
		error("Nie ma ofert na rynku. (<a href=hmarket.php>wroc</a>)");
	}
	if ($_GET['limit'] < $oferty) {
	if (empty($_POST['szukany'])) {
		$pm = $db -> SelectLimit("SELECT * FROM hmarket ORDER BY ".$_GET['lista']." DESC", 30, $_GET['limit']);
	} else {
		$pm = $db -> SelectLimit("SELECT * FROM hmarket WHERE nazwa LIKE '".$_POST['szukany']."' ORDER BY ".$_GET['lista']." DESC", 30, $_GET['limit']);
	}
	$arrname = array();
	$arramount = array();
	$arrcost = array();
	$arrseller = array();
	$arraction = array();
	$arruser = array();
	$i = 0;
	while (!$pm -> EOF) {
		$arrname[$i] = $pm -> fields['nazwa'];
		$arramount[$i] = $pm -> fields['ilosc'];
		$arrcost[$i] = $pm -> fields['cost'];
		$arrseller[$i] = $pm -> fields['seller'];
		$seller = $db -> Execute("SELECT user FROM players WHERE id=".$pm -> fields['seller']);
		$arruser[$i] = $seller -> fields['user'];
		$seller -> Close();
		if ($player -> id == $pm -> fields['seller']) {
			$arraction[$i] = "<td>- <a href=hmarket.php?wyc=".$pm -> fields['id'].">Wycofaj</a></td></tr>";
		} else {
			$arraction[$i] = "<td>- <a href=hmarket.php?buy=".$pm -> fields['id'].">Kup</a></td></tr>";
		}
		$pm -> MoveNext();
		$i = $i + 1;
	}
	$pm -> Close();
	$smarty -> assign ( array("Name" => $arrname, "Amount" => $arramount, "Cost" => $arrcost, "Seller" => $arrseller, "Action" => $arraction, "User" => $arruser));
	if ($_GET['limit'] >= 30) {
		$lim = $_GET['limit'] - 30;
		$smarty -> assign ("Previous", "<form method=\"post\" action=\"hmarket.php?view=market&limit=".$lim."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Poprzednie\"></form> ");
	}
	$_GET['limit'] = $_GET['limit'] + 30;
	if ($oferty > 30 && $_GET['limit'] < $oferty) {
		$smarty -> assign ("Next", " <form method=\"post\" action=\"hmarket.php?view=market&limit=".$_GET['limit']."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Nastepne\"></form>");
	}
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'add') {
	if (isset ($_GET['step']) && $_GET['step'] == 'add') {
		if (!ereg("^[1-9][0-9]*$", $_POST['ilosc']) || !ereg("^[1-9][0-9]*$", $_POST['cost'])) {
		error ("Zapomnij o tym.");
	}
	if ($_POST['mineral'] == 'Illani') {
		if ($_POST['ilosc'] > $player->illani) {
			error ("Nie masz takiej ilosci ".$_POST['mineral']);
		}
	} elseif ($_POST['mineral'] == 'Illanias') {
		if ($_POST['ilosc'] > $player -> illanias) {
			error ("Nie masz takiej ilosci ".$_POST['mineral']);
		}
	} elseif ($_POST['mineral'] == 'Nutari') {
		if ($_POST['ilosc'] > $player -> nutari) {
			error ("Nie masz takiej ilosci ".$_POST['mineral']);
		}
	} elseif ($_POST['mineral'] == 'Dynallca') {
		if ($_POST['ilosc'] > $player -> dynallca ) {
			error ("Nie masz takiej ilosci ".$_POST['mineral']);
		}
	} else {
		error ("Zapomnij o tym!");
	}
	//$db -> Execute("UPDATE herbs SET ".$_POST['mineral']."=".$_POST['mineral']."-".$_POST['ilosc']." WHERE gracz=".$player -> id);
	$herb = strtolower( $_POST['mineral'] );
	$player -> $herb -= $_POST['ilosc'];
	$db -> Execute("INSERT INTO hmarket (seller, ilosc, cost, nazwa) VALUES(".$player -> id.",".$_POST['ilosc'].",".$_POST['cost'].",'".$_POST['mineral']."')") or die("Nie moge dodac.");
	$smarty -> assign("Message", "Dodales <b>".$_POST['ilosc']."</b> ".$_POST['mineral']." na rynku za <b>".$_POST['cost']."</b>  sztuk zlota. <a href=\"hmarket.php?view=add\">Odswiez</a>");
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'del') {
	$del = $db -> Execute("SELECT * FROM hmarket WHERE seller=".$player -> id);
	$del = $del -> GetArray();
	foreach( $del as $herb ) {
		$item =  strtolower( $herb['nazwa'] );
		$player -> $item += $herb['ilosc'];
	}
	SqlExec( "DELETE FROM hmarket WHERE seller={$player->id}" );
	//while (!$del -> EOF) {
		//$db -> Execute("UPDATE herbs SET ".$del -> fields['nazwa']."=".$del -> fields['nazwa']."+".$del -> fields['ilosc']." WHERE gracz=".$player -> id);
	//	$db -> Execute("DELETE FROM hmarket WHERE id=".$del -> fields['id']);
	//	$del -> MoveNext();
	//}
	//$del -> Close();
	$smarty -> assign("Message", "Usunales wszystkie swoje oferty i twoje ziola wrocily do ciebie. (<A href=hmarket.php>wroc</a>)");
}

if (isset($_GET['buy'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
	error ("Zapomnij o tym.");
	}
	$buy = $db -> Execute("SELECT h.*, p.user FROM hmarket h JOIN players p ON p.id=h.seller WHERE h.id=".$_GET['buy']) ;
	if (!$buy -> fields['id']) {
		error ("Nie ma ofert. (<a href=hmarket.php?view=market>wroc</a>)");
	}
	if ($buy -> fields['seller'] == $player -> id) {
		error ("Nie mozesz kupic swoich ziol!. (<a href=hmarket.php?view=market>wroc</a>)");
	}
	$seller = $buy -> fields['user'];
	//$seller = $db -> Execute("SELECT user FROM players WHERE id=".$buy -> fields['seller']);
	$smarty -> assign( array("Name" => $buy -> fields['nazwa'], "Amount1" => $buy -> fields['ilosc'], "Itemid" => $buy -> fields['id'], "Cost" => $buy -> fields['cost'], "Seller" => $seller -> fields['user'], "Sid" => $buy -> fields['seller']));
	$buy -> Close();
	
	if (isset($_GET['step']) && $_GET['step'] == 'buy') {
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym.");
		}
		$buy = $db -> Execute("SELECT * FROM hmarket WHERE id=".$_GET['buy']);
		$price = $_POST['amount'] * $buy -> fields['cost'];
		if ($price > $player -> credits) {
			error ("Nie stac cie. (<a href=hmarket.php?view=market>wroc</a>)");
		}
		if ($_POST['amount'] > $buy -> fields['ilosc']) {
			error("Nie ma tyle ".$buy -> fields['nazwa']." na rynku. (<a href=hmarket.php>wroc</a>)");
		}
		//$db -> Execute("UPDATE resources SET bank=bank+".$price." WHERE id=".$buy -> fields['seller']);
		//PutSignal( $buy -> fields['seller'], 'res' );
		$own = new playerManager( $buy->fields['seller'] );
		$own->addRes( 'bank', $price );
		//$db -> Execute("UPDATE players SET credits=credits-".$price." WHERE id=".$player -> id);
		$player -> gold -= $price;
		//if (!$gr -> fields['id']) {
		//	$db -> Execute("INSERT INTO herbs (gracz, ".$buy -> fields['nazwa'].") VALUES(".$player -> id.",".$_POST['amount'].")");
		//} else {
		//	$db -> Execute("UPDATE herbs SET ".$buy -> fields['nazwa']."=".$buy -> fields['nazwa']."+".$_POST['amount']." WHERE gracz=".$player -> id);
		//}
		$herb = strtolower( $buy -> fields['nazwa'] );
		$player -> $herb += $_POST['amount'];
		if ($_POST['amount'] == $buy -> fields['ilosc']) {
			$db -> Execute("DELETE FROM hmarket WHERE id=".$buy -> fields['id']);
		} else {
			$db -> Execute("UPDATE hmarket SET ilosc=ilosc-".$_POST['amount']." WHERE id=".$buy -> fields['id']);
		}
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$buy -> fields['seller'].",'<b><a href=view.php?view=".$player -> id.">".$player -> user."</a></b> zaakceptowal twoja oferte za ".$_POST['amount']." sztuk ".$buy -> fields['nazwa'].". Dostales <b>".$price."</b> sztuk zlota do banku.','".$newdate."')") or error("Nie moge dodac do dziennika.");
		$smarty -> assign("Message", "Kupiles <b>".$_POST['amount']." sztuk</b> ".$buy -> fields['nazwa']." za <b>".$price."</b> sztuk zlota.");
	}
}

if (isset($_GET['wyc'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['wyc'])) {
		error ("Zapomnij o tym.");
	}
	$dwyc = $db -> Execute("SELECT * FROM hmarket WHERE id=".$_GET['wyc']);
	if ($dwyc -> fields['seller'] != $player -> id) {
		error ("Nie mozesz wycofac cudzych ofert!");
	}
	$herb = strtolower( $dwyc -> fields['nazwa'] );
	$player -> $herb += $dwyc -> fields['ilosc'];
	//$db -> Execute("UPDATE herbs SET ".$dwyc -> fields['nazwa']."=".$dwyc -> fields['nazwa']."+".$dwyc -> fields['ilosc']." where gracz=".$dwyc -> fields['seller']);
	$db -> Execute("DELETE FROM hmarket WHERE id=".$_GET['wyc']);
	$smarty -> assign("Message", "Usunales swoja oferte i twoje ziola wrocily do ciebie. (<A href=hmarket.php>wroc</a>)");
}

//spis wszystkich ofert na rynku
if (isset($_GET['view']) && $_GET['view'] == 'all') {
	$oferts = $db -> Execute("SELECT nazwa FROM hmarket GROUP BY nazwa");
	$arrname = array();
	$arramount = array();
	$i = 0;
	while (!$oferts -> EOF) {
		$arrname[$i] = $oferts -> fields['nazwa'];
	$arramount[$i] = 0;
	$query = $db -> Execute("SELECT id FROM hmarket WHERE nazwa='".$arrname[$i]."'");
	while (!$query -> EOF) {
		$arramount[$i] = $arramount[$i] + 1;
		$query -> MoveNext();
	}
	$query -> Close();
	$oferts -> MoveNext();
	$i = $i + 1;
	}
	$oferts -> Close();
	$smarty -> assign( array("Name" => $arrname, "Amount" => $arramount, "Message" => "<br />(<a href=\"hmarket.php\">Wroc</a>)"));
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
$smarty -> assign ( array("View" => $_GET['view'], "Remowe" => $_GET['wyc'], "Buy" => $_GET['buy']));
$smarty -> display ('hmarket.tpl');

require_once("includes/foot.php");
?>

