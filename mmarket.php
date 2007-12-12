<?php
//@type: F
//@desc: Rynek z miksturami
/**
 *   Funkcje pliku:
 *   Rynek z miksturami
 *
 *   @name                : mmarket.php
 *   @copyright           : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author              : thindil <thindil@users.sourceforge.net>
 *   @version             : 0.7 beta
 *   @since               : 27.12.2004
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

$title = "Rynek z miksturami";
require_once("includes/head.php");

// if ($player -> location != 'Altara' && $player -> location != 'Iriaebor' && $player -> location != 'Proskur' && $player -> location != 'Athkatla' && $player -> location != 'Eshpurta' && $player -> location != 'Proskur') {
// 	error ("Zapomnij o tym");
// }
checklocation($_SERVER['SCRIPT_NAME']);
if($player->id != 267)
	error("Zamkniête do czasu a¿ tu nie dokonam porz±dków");

// przypisanie zmiennej
$smarty -> assign(array("Message" => '', "Previous" => '', "Next" => ''));

if (isset ($_GET['view']) && $_GET['view'] == 'market') {
    if (empty($_POST['szukany'])) {
	$msel = $db -> Execute("SELECT id FROM mikstury WHERE status='R'");
        $_POST['szukany'] = '';
    } else {
	$_POST['szukany'] = strip_tags($_POST['szukany']);
	$msel = $db -> Execute("SELECT id FROM mikstury WHERE status='R' AND nazwa='".$_POST['szukany']."'");
    }
    $przed = $msel -> RecordCount();
    $msel -> Close();
    if ($przed == 0) {
	error ("Nie ma ofert na rynku! <a href=mmarket.php>Wróæ</a>");
    }
    if ($_GET['limit'] < $przed) {
	if (empty($_POST['szukany'])) {
	    $pm = $db -> SelectLimit("SELECT * FROM mikstury WHERE status='R' ORDER BY ".$_GET['lista']." DESC", 30, $_GET['limit']);
	} else {
	    $pm = $db -> SelectLimit("SELECT * FROM mikstury WHERE status='R' AND nazwa='".$_POST['szukany']."' ORDER BY ".$_GET['lista']." DESC", 30, $_GET['limit']);
	}
	$arritem = array();
	$arrlink = array();
	$i = 0;
	while (!$pm -> EOF) {
	    $seller = $db -> Execute("SELECT user FROM players WHERE id=".$pm -> fields['gracz']);
	    if ($pm -> fields['typ'] == 'M' || $pm -> fields['typ'] == 'P') {
	        $arritem[$i] = "<tr><td>".$pm -> fields['nazwa']." (moc:".$pm -> fields['moc']."%)</td><td align=center>".$pm -> fields['efekt']."</td><td align=\"center\">".$pm -> fields['amount']."</td><td align=center>".$pm -> fields['cena']."</td><td><a href=view.php?view=".$pm -> fields['gracz'].">".$seller -> fields['user']."</a></td>";
	    } else {
	        $arritem[$i] = "<tr><td>".$pm -> fields['nazwa']."</td><td align=center>".$pm -> fields['efekt']."</td><td align=\"center\">".$pm -> fields['amount']."</td><td align=center>".$pm -> fields['cena']."</td><td><a href=view.php?view=".$pm -> fields['gracz'].">".$seller -> fields['user']."</a></td>";
	    }
	    $seller -> Close();
	    if ($player -> id == $pm -> fields['gracz']) {
	        $arrlink[$i] = "<td>- <a href=mmarket.php?wyc=".$pm -> fields['id'].">Wycofaj</a></td></tr>";
	    } else {
	        $arrlink[$i] = "<td>- <a href=mmarket.php?buy=".$pm -> fields['id'].">Kup</a></td></tr>";
	    }
	    $pm -> MoveNext();
	    $i = $i + 1;
	}
	$pm -> Close();
	$smarty -> assign ( array("Item" => $arritem, "Link" => $arrlink));
	if ($_GET['limit'] >= 30) {
	    $lim = $_GET['limit'] - 30;
	    $smarty -> assign ("Previous", "<form method=\"post\" action=\"mmarket.php?view=market&limit=".$lim."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Poprzednie\"></form> ");
	}
	$_GET['limit'] = $_GET['limit'] + 30;
	if ($przed > 30 && $_GET['limit'] < $przed) {
	    $smarty -> assign ("Next", " <form method=\"post\" action=\"mmarket.php?view=market&limit=".$_GET['limit']."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Nastêpne\"></form>");
	}
    }
}

if (isset ($_GET['view']) && $_GET['view'] == 'add') {
    $rzecz = $db -> Execute("SELECT * FROM mikstury WHERE gracz=".$player -> id." AND status='K'");
    $arrname = array();
    $arrid = array();
    $arramount = array();
    $i = 0;
    while (!$rzecz -> EOF) {
        $arrname[$i] = $rzecz -> fields['nazwa'];
        $arrid[$i] = $rzecz -> fields['id'];
        $arramount[$i] = $rzecz -> fields['amount'];
	$rzecz -> MoveNext();
        $i = $i + 1;
    }
    $rzecz -> Close();
    $smarty -> assign ( array("Name" => $arrname, "Itemid" => $arrid, "Amount" => $arramount));
    if (isset ($_GET['step']) && $_GET['step'] == 'add') {
	if (!$_POST['cost'] || !ereg("^[1-9][0-9]*$", $_POST['cost'])) {
	    error ("Podaj cenê");
	}
	if (!ereg("^[1-9][0-9]*$", $_POST['przedmiot']) || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	    error ("Zapomnij o tym.");
	}
	$item = $db -> Execute("SELECT * FROM mikstury WHERE id=".$_POST['przedmiot']);
	if ($_POST['amount'] > $item -> fields['amount']) {
	    error("Nie masz takiej ilo¶ci ".$item -> fields['nazwa'].". <a href=\"mmarket.php\">Wróæ</a>");
	}
        $db -> Execute("INSERT INTO mikstury (gracz, nazwa, efekt, moc, status, cena, typ, amount) VALUES(".$player -> id.",'".$item -> fields['nazwa']."','".$item -> fields['efekt']."',".$item -> fields['moc'].",'R',".$_POST['cost'].",'".$item -> fields['typ']."', ".$_POST['amount'].")") or error("nie mogê dodaæ!");
        $amount = $item -> fields['amount'] - $_POST['amount'];
        if ($amount < 1) {
            $db -> Execute("DELETE FROM mikstury WHERE id=".$item -> fields['id']);
        } else {
            $db -> Execute("UPDATE mikstury SET amount=".$amount." WHERE id=".$item -> fields['id']);
        }
        $smarty -> assign("Message", "Doda³e¶ <b>".$_POST['amount']." sztuk ".$item -> fields['nazwa']."</b> na rynku za <b>".$_POST['cost']."</b> sztuk z³ota ka¿da. <A href=mmarket.php>wróæ</a>");
    }
}

if (isset($_GET['wyc'])) {
    if (!ereg("^[1-9][0-9]*$", $_GET['wyc'])) {
	error ("Zapomnij o tym.");
    }
    $item = $db -> Execute("SELECT * FROM mikstury WHERE id=".$_GET['wyc']);
    if ($item -> fields['gracz'] != $player -> id) {
	error ("Nie mo¿esz wycofaæ cudzej oferty!");
    }
    $test = $db -> Execute("SELECT id FROM mikstury WHERE nazwa='".$item -> fields['nazwa']."' AND gracz=".$player -> id." AND status='K'");
    if (!$test -> fields['id']) {
        $db -> Execute("INSERT INTO mikstury (gracz, nazwa, efekt, moc, status, amount, typ) VALUES(".$player -> id.",'".$item -> fields['nazwa']."','".$item -> fields['efekt']."',".$item -> fields['moc'].",'K',".$item -> fields['amount'].",'".$item -> fields['typ']."')") or error("nie mogê dodaæ!");
    } else {
        $db -> Execute("UPDATE mikstury SET amount=amount+".$item -> fields['amount']." WHERE id=".$test -> fields['id']);
    }
    $test -> Close();
    $db -> Execute("DELETE FROM mikstury WHERE id=".$item -> fields['id']);
    $smarty -> assign("Message", "Usun±³e¶ swoj± ofertê i twój eliksir wróci³ do ciebie. (<A href=mmarket.php>wróæ</a>)");
}

if (isset ($_GET['view']) && $_GET['view'] == 'del') {
    $mik = $db -> Execute("SELECT * FROM mikstury WHERE gracz=".$player -> id." AND status='R'");
    $arrname = array();
    $arrpower = array();
    $arrefect = array();
    $arrtype = array();
    $arrid = array();
    $i = 0;
    while (!$mik -> EOF) {
        $item = 0;
        foreach ($arrname as $name) {
            if ($name == $mik -> fields['nazwa']) {
                $item = 1;
            }
        }
        if ($item == 0) {
            $arrname[$i] = $mik -> fields['nazwa'];
            $arrtype[$i] = $mik -> fields['typ'];
            $arrpower[$i] = $mik -> fields['moc'];
            $arrefect[$i] = $mik -> fields['efekt'];
            $arrid[$i] = $mik -> fields['id'];
            $i = $i + 1;
        }
	$mik -> MoveNext();
    }
    $mik -> Close();
    $i = 0;
    foreach ($arrname as $name) {
        $query = $db -> Execute("SELECT id FROM mikstury WHERE nazwa='".$name."' AND gracz=".$player -> id." AND status='R'");
        $number = $query -> RecordCount();
	$query -> Close();
	$amount = 0;
	for ($j = 1; $j <= $number; $j++) {
	    $query = $db -> Execute("SELECT amount FROM mikstury WHERE nazwa='".$name."' AND gracz=".$player -> id." AND status='R'");
	    $amount = $amount + $query -> fields['amount'];
	    $query -> Close();
	}
        $test = $db -> Execute("SELECT id FROM mikstury WHERE nazwa='".$name."' AND gracz=".$player -> id." AND status='K'");
        if (!$test -> fields['id']) {
            $db -> Execute("INSERT INTO mikstury (nazwa, gracz, efekt, typ, moc, status, amount) VALUES('".$name."',".$player -> id.",'".$arrefect[$i]."','".$arrtype[$i]."',".$arrpower[$i].",'K',".$amount.")") or error("Nie mogê dodaæ");
        } else {
            $db -> Execute("UPDATE mikstury SET amount=amount+".$amount." WHERE id=".$test -> fields['id']);
        }
	$test -> Close();
        $i = $i + 1;
    }
    $db -> Execute("DELETE FROM mikstury WHERE gracz=".$player -> id." AND status='R'");
    $smarty -> assign("Message", "Usun±³e¶ wszystkie swoje oferty i twoje mikstury wróci³y do ciebie. (<A href=mmarket.php>wróæ</a>)");
}

if (isset($_GET['buy'])) {
    if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
	error ("Zapomnij o tym.");
    }
    $buy = $db -> Execute("SELECT * FROM mikstury WHERE id=".$_GET['buy']);
    if (!$buy -> fields['id']) {
	error ("Nie ma ofert. (<a href=mmarket.php>wróæ</a>)");
    }
    if ($buy -> fields['gracz'] == $player -> id) {
	error ("Nie mo¿esz kupiæ w³asnego przedmiotu! (<a href=mmarket.php>wróæ</a>)");
    }
    $seller = $db -> Execute("SELECT user FROM players WHERE id=".$buy -> fields['gracz']);
    $smarty -> assign( array("Name" => $buy -> fields['nazwa'], "Power" => $buy -> fields['moc'], "Amount1" => $buy -> fields['amount'], "Itemid" => $buy -> fields['id'], "Cost" => $buy -> fields['cena'], "Seller" => $seller -> fields['user'], "Type" => $buy -> fields['typ'], "Sid" => $buy -> fields['gracz']));
    $buy -> Close();
    $seller -> Close();
    if (isset($_GET['step']) && $_GET['step'] == 'buy') {
        if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	    error ("Zapomnij o tym.");
        }
        $buy = $db -> Execute("SELECT * FROM mikstury WHERE id=".$_GET['buy']);
	if ($_POST['amount'] > $buy -> fields['amount']) {
	    error("Nie ma tyle ".$buy -> fields['nazwa']." na rynku. (<a href=mmarket.php>wróæ</a>)");
	}
	$price = $_POST['amount'] * $buy -> fields['cena'];
        if ($price > $player -> credits) {
	    error ("Nie staæ ciê. (<a href=mmarket.php>wróæ</a>)");
        }
	$ncost = ceil($buy -> fields['cena'] * .5);
        $test = $db -> Execute("SELECT id FROM mikstury WHERE nazwa='".$buy -> fields['nazwa']."' AND gracz=".$player -> id." AND status='K'");
        if (!$test -> fields['id']) {
            $db -> Execute("INSERT INTO mikstury (nazwa, gracz, efekt, typ, moc, status, amount) VALUES('".$buy -> fields['nazwa']."',".$player -> id.",'".$buy -> fields['efekt']."','".$buy -> fields['typ']."',".$buy -> fields['moc'].",'K',".$_POST['amount'].")") or error ("Nie mogê dodaæ");
        } else {
            $db -> Execute("UPDATE mikstury SET amount=amount+".$_POST['amount']." WHERE nazwa='".$buy -> fields['nazwa']."' AND gracz=".$player -> id." AND status='K'");
        }
	$test -> Close();
	if ($_POST['amount'] == $buy -> fields['amount']) {
            $db -> Execute("DELETE FROM mikstury WHERE id=".$buy -> fields['id']);
	} else {
	    $db -> Execute("UPDATE mikstury SET amount=amount-".$_POST['amount']." WHERE id=".$buy -> fields['id']);
	}
	$db -> Execute("UPDATE players SET bank=bank+".$price." WHERE id=".$buy -> fields['gracz']);
	$db -> Execute("UPDATE players SET credits=credits-".$price." WHERE id=".$player -> id);
	$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$buy -> fields['gracz'].",'<b><a href=view.php?view=".$player -> id.">".$player -> user."</a></b> zaakceptowa³ twoj± ofertê za <b>".$_POST['amount']." sztuki ".$buy -> fields['nazwa']."</b>. Dosta³e¶ <b>".$price."</b> sztuk z³ota do banku.','".$newdate."')") or error("Nie mogê dodaæ do dziennika.");
	$smarty -> assign("Message", "Kupi³e¶ <b>".$_POST['amount']." sztuk ".$buy -> fields['nazwa']."</b> za <b>".$price."</b> sztuk z³ota.");
	$buy -> Close();
    }
}

//spis wszystkich ofert na rynku
if (isset($_GET['view']) && $_GET['view'] == 'all') {
    $oferts = $db -> Execute("SELECT nazwa FROM mikstury WHERE status='R' GROUP BY nazwa");
    $arrname = array();
    $arramount = array();
    $i = 0;
    while (!$oferts -> EOF) {
        $arrname[$i] = $oferts -> fields['nazwa'];
	$arramount[$i] = 0;
	$query = $db -> Execute("SELECT id FROM mikstury WHERE status='R' AND nazwa='".$arrname[$i]."'");
	while (!$query -> EOF) {
	    $arramount[$i] = $arramount[$i] + 1;
	    $query -> MoveNext();
	}
	$query -> Close();
	$oferts -> MoveNext();
	$i = $i + 1;
    }
    $oferts -> Close();
    $smarty -> assign( array("Name" => $arrname, "Amount" => $arramount, "Message" => "<br />(<a href=\"mmarket.php\">Wróæ</a>)"));
}

//inicjalizacja zmiennych
if (!isset($_GET['view'])) {
    $_GET['view'] = '';
}
if (!isset($_GET['wyc'])) {
    $_GET['wyc'] = '';
}
if (!isset($_GET['buy'])) {
    $_GET['buy'] = '';
}

//przypisanie zmiennych oraz wy¶wietlenie strony
$smarty -> assign( array("View" => $_GET['view'], "Delete" => $_GET['wyc'], "Buy" => $_GET['buy']));
$smarty -> display('mmarket.tpl');

require_once("includes/foot.php");
?>
