<?php
//@type: F
//@desc: Klany - Zbrojownia
/***************************************************************************
 *                               tribeware.php
 *                            -------------------
 *   copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
 *   email                : thindil@users.sourceforge.net
 *
 ***************************************************************************/

/***************************************************************************
 *
 *       This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ***************************************************************************/

$title = "Zbrojownia klanu";
require_once("includes/head.php");

// sprawdzenie czy gracz nalezy do klanu
if (!$player -> tribe_id) {
    error ("Nie jestes w klanie.");
}

// sprawdzenie czy gracz jest w miescie
checklocation( 'tribes.php' );
//przypisanie zmiennej
$smarty -> assign("Message", '');

// ustalenie kto ma uprawnienia do dawania przedmiotow
$perm = $db -> Execute("SELECT armory FROM tribe_perm WHERE tribe=".$player -> tribe_id);
$owner = $db -> Execute("SELECT owner FROM tribes WHERE id=".$player -> tribe_id);

//spis przedmiotow w zbrojowni klanu
if (isset($_GET['step']) && $_GET['step'] == 'zobacz') {
    $arrtype = array('W', 'A', 'H', 'N', 'D', 'B', 'S', 'Z', 'R', 'G');
    $arrlist = array('id', 'name', 'power', 'wt', 'zr', 'szyb');
    if (isset($_GET['type']) && !in_array($_GET['type'], $arrtype)) {
        error ("Zapomnij o tym!");
    }
    if (isset($_GET['lista']) && !in_array($_GET['lista'], $arrlist)) {
        error ("Zapomnij o tym!");
    }
    if (!isset($_GET['type'])) {
        error("Czego dokladnie szukasz?");
    }
    if ($_GET['type'] == 'W') {
        $item = 'broni';
    }
    if ($_GET['type'] == 'A') {
        $item = 'zbroj';
    }
    if ($_GET['type'] == 'H') {
        $item = 'helmow';
    }
    if ($_GET['type'] == 'N') {
        $item = 'nagolennikow';
    }
    if ($_GET['type'] == 'D') {
        $item = 'tarcz';
    }
    if ($_GET['type'] == 'B') {
        $item = 'lukow';
    }
    if ($_GET['type'] == 'S') {
        $item = 'rozdzek';
    }
    if ($_GET['type'] == 'Z') {
        $item = 'szat';
    }
    if ($_GET['type'] == 'R') {
        $item = 'kolczanow strzal';
    }
    if ($_GET['type'] == 'G') {
        $item = 'grotow';
    }
    $amount = $db -> Execute("SELECT amount FROM tribe_zbroj WHERE klan=".$player -> tribe_id." AND type='".$_GET['type']."'");
    if (!$amount -> fields['amount']) {
        error("Nie ma ".$item." w zbrojowni klanu!");
    }
    $przed = 0;
    while (!$amount -> EOF) {
        $przed = $przed + $amount -> fields['amount'];
	$amount -> MoveNext();
    }
    $amount -> Close();
    $smarty -> assign ( array("Amount1" => $przed, "Name1" => $item));
    $arritem = $db -> Execute("SELECT * FROM tribe_zbroj WHERE klan=".$player -> tribe_id." AND type='".$_GET['type']."' ORDER BY ".$_GET['lista']." DESC");
    $arragi = array();
    $arrpower = array();
    $arrname = array();
    $arrdur = array();
    $arrmaxdur = array();
    $arrspeed = array();
    $arramount = array();
    $arraction = array();
    $i = 0;
    while (!$arritem -> EOF) {
        if ($arritem -> fields['zr'] < 1) {
	        $arragi[$i] = str_replace("-","",$arritem -> fields['zr']);
        } else {
            $arragi[$i] = "-".$arritem -> fields['zr'];
        }
        $arrpower[$i] = $arritem -> fields['power'];
        if ($arritem -> fields['poison'] > 0) {
            $arrpower[$i] = $arritem -> fields['power'] + $arritem -> fields['poison'];
        }
        $arrname[$i] = $arritem -> fields['name'];
        $arrdur[$i] = $arritem -> fields['wt'];
        $arrmaxdur[$i] = $arritem -> fields['maxwt'];
        $arrspeed[$i] = $arritem -> fields['szyb'];
        $arramount[$i] = $arritem -> fields['amount'];
	    if ($player -> id == $owner -> fields['owner'] || $player -> id == $perm -> fields['armory']) {
	       $arraction[$i] = "<td>- <a href=tribearmor.php?daj=".$arritem -> fields['id'].">Daj</a></td>";
	    } else {
            $arraction[$i] = "<td></td>";
	    }
	    $arritem -> MoveNext();
	    $i = $i + 1;
    }
    $arritem -> Close();
    $smarty -> assign ( array("Name" => $arrname, "Agility" => $arragi, "Power" => $arrpower, "Durability" => $arrdur, "Maxdurability" => $arrmaxdur, "Speed" => $arrspeed, "Amount" => $arramount, "Action" => $arraction, "Type" => $_GET['type']));
}

// dawanie graczowi przedmiotow ze zbrojowni
if (isset ($_GET['daj'])) {
    if (!isset ($_GET['step3'])) {
	    $name = $db -> Execute("SELECT * FROM tribe_zbroj WHERE id=".$_GET['daj']);
        $smarty -> assign ( array("Id" => $_GET['daj'], "Amount" => $name -> fields['amount'], "Name" => $name -> fields['name']));
	$name -> Close();
    }
    if (isset ($_GET['step3']) && $_GET['step3'] == 'add') {
        if (!ereg("^[1-9][0-9]*$", $_POST['did']) || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	        error ("Zapomnij o tym<br>");
	    }
	    $zbroj = $db -> Execute("SELECT * FROM tribe_zbroj WHERE id=".$_GET['daj']);
	    if ($zbroj -> fields['amount'] < $_POST['amount']) {
	        error ("Klan nie ma tylu przedmiotow!");
	    }
	    $dtrib = $db -> Execute("SELECT tribe FROM players WHERE id=".$_POST['did']);
	    if ($dtrib -> fields['tribe'] != $player -> tribe_id) {
	        error ("Ten gracz nie jest w twoim klanie!");
	    }
	    $dtrib -> Close();
	    $item = array_shift( $zbroj->GetArray() );
	    $total = $item['amount'];
	    $item['amount'] = $_POST['amount'];
	    $test = new Player( $_POST['did'] );
	    $test -> EquipAdd( $item );
	    PutSignal( $_POST['did'], 'back' );
        //$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$zbroj -> fields['name']."' AND owner=".$_POST['did']." AND wt=".$zbroj -> fields['wt']." AND type='".$zbroj -> fields['type']."' AND power=".$zbroj -> fields['power']." AND szyb=".$zbroj -> fields['szyb']." AND zr=".$zbroj -> fields['zr']." AND maxwt=".$zbroj -> fields['maxwt']." AND poison=".$zbroj -> fields['poison']." AND status='U'");
        //if (!$test -> fields['id']) {
        //    $db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$_POST['did'].",'".$zbroj -> fields['name']."',".$zbroj -> fields['power'].",'".$zbroj -> fields['type']."',1,".$zbroj -> fields['zr'].",".$zbroj -> fields['wt'].",".$zbroj -> fields['minlev'].",".$zbroj -> fields['maxwt'].",".$_POST['amount'].",'".$zbroj -> fields['magic']."',".$zbroj -> fields['poison'].",".$zbroj -> fields['szyb'].",'".$zbroj -> fields['twohand']."')") or error("nie moge dodac!");
        //} else {
        //    $db -> Execute("UPDATE equipment SET amount=amount+".$_POST['amount']." WHERE id=".$test -> fields['id']);
        //}
		//$test -> Close();
        if ($_POST['amount'] < $total) {
            $db -> Execute("UPDATE tribe_zbroj SET amount=amount-".$_POST['amount']." WHERE id=".$item['id']);
        } else {
            $db -> Execute("DELETE FROM tribe_zbroj WHERE id=".$item['id']);
        }
        $smarty -> assign ("Message", "Przekazales graczowi ID ".$_POST['did']." ".$_POST['amount']." sztuk(i) ".$item['prefix']." ".$item['name']);
	$db -> Execute("INSERT INTO log (owner,log, czas) VALUES(".$_POST['did'].", 'Dostales od klanu ".$_POST['amount']." sztuk(i) ".$item['prefix']." ".$item['name']."','".$newdate."')");
	//$zbroj -> Close();
    }
}

// dodawanie przedmiotow do zbrojowni klanu
if (isset ($_GET['step']) && $_GET['step'] == 'daj') {
    $arritem = $db -> Execute("SELECT * FROM equipment WHERE status='U' AND owner=".$player -> id);
    $arrname = array();
    $arrid = array();
    $arramount = array();
    $i = 0;
    while (!$arritem -> EOF) {
	    $arrname[$i] = $arritem -> fields['name'];
	    $arrid[$i] = $arritem -> fields['id'];
	    $arramount[$i] = $arritem -> fields['amount'];
	    $arritem -> MoveNext();
	    $i = $i + 1;
    }
    $arritem -> Close();
    $smarty -> assign( array("Name" => $arrname, "Itemid" => $arrid, "Amount" => $arramount));
    if (isset ($_GET['step2']) && $_GET['step2'] == 'add') {
        if (!isset($_POST['przedmiot'])) {
            error("Wybierz przedmiot!");
        }
	    if (!ereg("^[1-9][0-9]*$", $_POST['przedmiot']) || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	        error ("Zapomnij o tym!");
	    }
	    $przed = $db -> Execute("SELECT * FROM equipment WHERE id=".$_POST['przedmiot']);
	    if (!$przed -> fields['name']) {
	        error ("Zapomnij o tym!");
	    }
        if ($przed -> fields['amount'] < $_POST['amount']) {
            error ("Nie masz tyle przedmiotow tego typu!");
        }
        $test = $db -> Execute("SELECT id FROM tribe_zbroj WHERE name='".$przed -> fields['name']."' AND klan=".$player -> tribe_id." AND wt=".$przed -> fields['wt']." AND type='".$przed -> fields['type']."' AND power=".$przed -> fields['power']." AND szyb=".$przed -> fields['szyb']." AND zr=".$przed -> fields['zr']." AND maxwt=".$przed -> fields['maxwt']." AND poison=".$przed -> fields['poison']);
        if (!$test -> fields['id']) {
            $db -> Execute("INSERT INTO tribe_zbroj (klan, name, power, type, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> tribe_id.",'".$przed -> fields['name']."',".$przed -> fields['power'].",'".$przed -> fields['type']."',".$przed -> fields['zr'].",".$przed -> fields['wt'].",".$przed -> fields['minlev'].",".$przed -> fields['maxwt'].",".$_POST['amount'].",'".$przed -> fields['magic']."',".$przed -> fields['poison'].",".$przed -> fields['szyb'].",'".$przed -> fields['twohand']."')") or error("nie moge dodac!");
        } else {
            $db -> Execute("UPDATE tribe_zbroj SET amount=amount+".$_POST['amount']." WHERE id=".$test -> fields['id']);
        }
	$test -> Close();
		$item = $player -> EquipSearch( array( 'id' => $_POST['przedmiot'] ) );
		$key = key( $item );
		$item = $item[$key];
        if ($_POST['amount'] < $item['amount']) {
            //$db -> Execute("UPDATE equipment SET amount=amount-".$_POST['amount']." WHERE id=".$przed -> fields['id']);
            $player -> SetEquip( 'backpack', $key, array( 'amount' => $item['amount'] - $_POST['amount'] ) );
        } else {
            //$db -> Execute("DELETE FROM equipment WHERE id=".$przed -> fields['id']);
            $player -> EquipDelete( $_POST['przedmiot'] );
        }
        $smarty -> assign ("Message", "Dodales <b>".$_POST['amount']." sztuk(i) ".$przed -> fields['name']."</b> do zbrojowni klanu.");
	$db -> Execute("INSERT INTO log (owner,log, czas) VALUES(".$owner -> fields['owner'].", 'Gracz <a href=view.php?view=".$player -> id.">".$player -> user."</a> ID: ".$player -> id." dodal do zbrojowni klanu ".$_POST['amount']." sztuk(i) ".$przed -> fields['name']."','".$newdate."')");
	$przed -> Close();
    }
}

// inicjalizacja zmiennych
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

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign( array("Step" => $_GET['step'], "Step2" => $_GET['step2'], "Give" => $_GET['daj'], "Step3" => $_GET['step3']));
$smarty -> display ('tribearmor.tpl');

require_once("includes/foot.php");
?>

