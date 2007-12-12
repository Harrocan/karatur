<?php
//@type: F
//@desc: Klany - Magazyn
/***************************************************************************
 *                               tribeware.php
 *                            -------------------
 *   copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
 *   email                : webmaster@uc.h4c.pl
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

$title = "Magazyn klanu";
require_once("includes/head.php");

// sprawdzenie czy gracz nalezy do klanu
if (!$player -> tribe_id) {
	error ("Nie jestes w klanie.");
}
// sprawdzenie czy gracz jest w mieœcie
checklocation( 'tribes.php' );

//przypisanie zmiennej
$smarty -> assign("Message",'');

// ustalenie kto ma uprawnienia do dawania mikstur
$perm = $db -> Execute("SELECT warehouse FROM tribe_perm WHERE tribe=".$player -> tribe_id);
$owner = $db -> Execute("SELECT owner FROM tribes WHERE id=".$player -> tribe_id);

// lista mikstur w magazynie klanu
if (isset ($_GET['step']) && $_GET['step'] == 'zobacz') {
    $arrlist = array('id', 'nazwa', 'efekt');
    if (isset($_GET['lista']) && !in_array($_GET['lista'], $arrlist)) {
        error ("Zapomnij o tym!");
    }
    $miks = $db -> Execute("SELECT * FROM tribe_mag WHERE klan=".$player -> tribe_id." ORDER BY ".$_GET['lista']." DESC");
    if (!$miks -> fields['id']) {
        error("Nie ma mikstur w magazynie klanu!");
    }
    $amount = $db -> Execute("SELECT amount FROM tribe_mag WHERE klan=".$player-> tribe_id);
    $przed = 0;
    while (!$amount -> EOF) {
        $przed = $przed + $amount -> fields['amount'];
	$amount -> MoveNext();
    }
    $amount -> Close();
    $arrname = array();
    $arrefect = array();
    $arramount = array();
    $arrlink = array();
    $i = 0;
    while (!$miks -> EOF) {
	    $arrname[$i] = $miks -> fields['nazwa'];
	    $arrefect[$i] = $miks -> fields['efekt'];
	    $arramount[$i] = $miks -> fields['amount'];
	    if ($player -> id == $owner -> fields['owner'] || $player -> id == $perm -> fields['warehouse']) {
	        $arrlink[$i] = "<td>- <a href=tribeware.php?daj=".$miks -> fields['id'].">Daj</a></td>";
	    } else {
	        $arrlink[$i] = "<td></td>";
	    }
	    $miks -> MoveNext();
	    $i = $i + 1;
    }
    $miks -> Close();
    $smarty -> assign ( array("Amount1" => $przed, "Name" => $arrname, "Efect" => $arrefect, "Amount" => $arramount, "Link" => $arrlink));
}

// dawanie graczom mikstur z magazynu klanu
if (isset ($_GET['daj'])) {
    if (!isset ($_GET['step3'])) {
	    $miks = $db -> Execute("SELECT * FROM tribe_mag WHERE id=".$_GET['daj']);
        $smarty -> assign ( array("Id" => $_GET['daj'], "Name" => $miks -> fields['nazwa'], "Amount" => $miks -> fields['amount']));
	$miks -> Close();
    }
    if (isset ($_GET['step3']) && $_GET['step3'] == 'add') {
        if (!ereg("^[1-9][0-9]*$", $_POST['did']) || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	        error ("Zapomnij o tym<br>");
	    }
	    $dtrib = $db -> Execute("SELECT tribe FROM players WHERE id=".$_POST['did']);
	    if ($dtrib -> fields['tribe'] != $player -> tribe_id) {
                error ("Ten gracz nie jest w twoim klanie!");
	    }
	    $dtrib -> Close();
	    $zbroj = $db -> Execute("SELECT * FROM tribe_mag WHERE id=".$_GET['daj']);
	    if ($zbroj -> fields['amount'] < $_POST['amount']) {
	        error ("Klan nie ma tylu mikstur danego typu!");
	    }
	    $item = $zbroj -> GetArray();
	    $item = array_shift( $item );
	    $item['amount'] = 1;
	    $test = new Player( $_POST['did'] );
	    $test -> EquipAdd( $item );
        //$test = $db -> Execute("SELECT id FROM mikstury WHERE nazwa='".$zbroj -> fields['nazwa']."' AND gracz=".$_POST['did']." AND status='K'");
        //if (!$test -> fields['id']) {
        //    $db -> Execute("INSERT INTO mikstury (nazwa, gracz, efekt, typ, moc, status, amount) VALUES('".$zbroj -> fields['nazwa']."',".$_POST['did'].",'".$zbroj -> fields['efekt']."','".$zbroj -> fields['typ']."',".$zbroj -> fields['moc'].",'K',".$_POST['amount'].")") or error ("Nie moge dodac");
        //} else {
        //    $db -> Execute("UPDATE mikstury SET amount=amount+".$_POST['amount']." WHERE id=".$test -> fields['id']);
        //}
		//$test -> Close();
        if ($_POST['amount'] < $zbroj -> fields['amount']) {
            $db -> Execute("UPDATE tribe_mag SET amount=amount-".$_POST['amount']." WHERE id=".$zbroj -> fields['id']);
        } else {
            $db -> Execute("DELETE FROM tribe_mag WHERE id=".$zbroj -> fields['id']);
        }
        $smarty -> assign ("Message", "Przekazales graczowi ID ".$_POST['did']." ".$_POST['amount']." sztuk(i) ".$zbroj -> fields['nazwa']);
	$db -> Execute("INSERT INTO log (owner,log, czas) VALUES(".$_POST['did'].", 'Dostales od klanu ".$_POST['amount']." sztuk ".$zbroj -> fields['nazwa']."','".$newdate."')");
	$zbroj -> Close();
    }
}

// dodawanie mikstur do magazynu klanu
if (isset ($_GET['step']) && $_GET['step'] == 'daj') {
    $miks = $db -> Execute("SELECT * FROM mikstury WHERE status='K' AND gracz=".$player -> id);
    $arrid = array();
    $arrname = array();
    $arramount = array();
    $i = 0;
    while (!$miks -> EOF) {
	    $arrid[$i] = $miks -> fields['id'];
	    $arrname[$i] = $miks -> fields['nazwa'];
	    $arramount[$i] = $miks -> fields['amount'];
	    $miks -> MoveNext();
	    $i = $i + 1;
    }
    $miks -> Close();
    $smarty -> assign( array("Itemid" => $arrid, "Name" => $arrname, "Amount" => $arramount));
    if (isset ($_GET['step2']) && $_GET['step2'] == 'add') {
        if (!ereg("^[1-9][0-9]*$", $_POST['przedmiot']) || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	        error ("Zapomnij o tym!");
	    }
	    $przed = $db -> Execute("SELECT * FROM mikstury WHERE id=".$_POST['przedmiot']." AND gracz={$player->id}");
	    if (!$przed -> fields['nazwa']) {
	        error ("Zapomnij o tym!");
	    }
	    if ($_POST['amount'] > $przed -> fields['amount']) {
	        error ("Nie masz tylu mikstur!");
	    }
        $test = $db -> Execute("SELECT id FROM tribe_mag WHERE nazwa='".$przed -> fields['nazwa']."' AND klan=".$player -> tribe_id);
        if (!$test -> fields['id']) {
            $db -> Execute("INSERT INTO tribe_mag (nazwa, klan, efekt, typ, moc, amount) VALUES('".$przed -> fields['nazwa']."',".$player -> tribe_id.",'".$przed -> fields['efekt']."','".$przed -> fields['typ']."',".$przed -> fields['moc'].",".$_POST['amount'].")") or error ("Nie moge dodac");
        } else {
            $db -> Execute("UPDATE tribe_mag SET amount=amount+".$_POST['amount']." WHERE id=".$test -> fields['id']) or error("nie moge zwiekszyc!");
        }
        $item = $player -> EquipSearch( array( 'id' => $_POST['przedmiot'] ), 'potions' );
        print_r( $item );
        $key = key( $item );
        $item = $item[$key];
        if ($_POST['amount'] < $przed -> fields['amount']) {
            //$db -> Execute("UPDATE mikstury SET amount=amount-".$_POST['amount']." WHERE id=".$przed -> fields['id']);
            $player -> SetEquip( 'potions', $key, array( 'amount' => $item['amount'] - $_POST['amount'] ) );
        } else {
            //$db -> Execute("DELETE FROM mikstury WHERE id=".$przed -> fields['id']);
            $player -> EquipDelete( $_POST['przedmiot'], 'potions' );
        }
        $smarty -> assign ("Message", "Dodales ".$_POST['amount']." sztuk(i) <b>".$przed -> fields['nazwa']."</b> do magazynu klanu.");
	$db -> Execute("INSERT INTO log (owner,log, czas) VALUES(".$owner -> fields['owner'].", 'Gracz <a href=view.php?view=".$player -> id.">".$player -> user."</a> ID: ".$player -> id." dodal do magazynu klanu ".$_POST['amount']." sztuk(i) ".$przed -> fields['nazwa']."','".$newdate."')");
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

$smarty -> assign( array("Step" =>$_GET['step'], "Step2" => $_GET['step2'], "Give" => $_GET['daj'], "Step3" => $_GET['step3']));
$smarty -> display('tribeware.tpl');

require_once("includes/foot.php");
?>

