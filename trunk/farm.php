<?php
//@type: F
//@desc: Famy
/***************************************************************************
 *                               farm.php
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

$title = "Farma";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla') {
    error ("Zapomnij o tym");
}*/

$farm = $db -> Execute("SELECT * FROM farms WHERE owner=".$player -> id);
if (!$farm -> fields['id']) {
    $smarty -> assign ("Empty", "Y");
} else {
    $smarty -> assign("Empty", '');
}

if (isset($_GET['answer']) && $_GET['answer'] == 'yes') {
    if ($player -> platinum < 50) {
	error ("Nie masz wystarczajaco duzo sztuk mithrilu.");
    } else {
	//$db -> Execute("UPDATE players SET platinum=platinum-50 WHERE id=".$player -> id);
	$player -> mithril -= 50;
        $db -> Execute("INSERT INTO farms (owner) VALUES(".$player -> id.")") or error("Nie moge dodac farmy");
	error ("Kupiles farme! Kliknij <a href=farm.php>tutaj</a>.");
    }
}

// menu farmy
$farms = $db -> Execute("SELECT * FROM farm WHERE owner=".$player -> id);
if (isset ($_GET['view']) && $_GET['view'] == 'stats') {
    $smarty -> assign ( array("Amount" => $farm -> fields['amount'], "Used" => $farm -> fields['used']));
    if (!$farms -> fields['id']) {
        $smarty -> assign ("Herbs", "Brak<br>");
    } else {
        $arrname = array();
        $arramount = array();
        $arrage = array();
        $i = 0;
        while (!$farms -> EOF) {
            $arrname[$i] = $farms -> fields['name'];
            $arramount[$i] = $farms -> fields['amount'];
            $arrage[$i] = $farms -> fields['age'];
	    $farms -> MoveNext();
            $i = $i + 1;
        }
        $smarty -> assign ( array("Herbname" => $arrname, "Herbamout" => $arramount, "Herbage" => $arrage, "Herbs" => ''));
    }
}
$farms -> Close();

//kupowanie nowego obszaru farmy
if (isset ($_GET['view']) && $_GET['view'] == 'shop') {
    $cost = ($farm -> fields['amount'] * 10000);
    $smarty -> assign ("Cost", $cost);
    if (isset($_GET['buy']) && $_GET['buy'] == 'land') {
	if ($_GET['buy'] != 'land') {
	    error ("Zapomnij o tym");
	}
	if ($player -> credits >= $cost) {
	    $db -> Execute("UPDATE farms SET amount=amount+1 WHERE owner=".$player -> id);
	    //$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
	    $player -> gold -= $cost;
	    error ("Kupiles dodatkowy obszar dla twojej farmy. (<a href=farm.php?view=shop>Odswiez</a>)");
	} else {
	    error ("Nie stac cie na to!");
        }
    }
}

// zasiewanie farmy
if (isset ($_GET['view']) && $_GET['view'] == 'add') 
{
    //$herbs = $db -> Execute("SELECT nutari, illani, illanias, dynallca FROM herbs WHERE gracz=".$player -> id);
    $options = '';
    if ($player -> nutari) {
        $options = $options."<option value=nutari>Nutari ilosc: ".$player->nutari."</option>";
    }
    if ($player -> illani) {
        $options = $options."<option value=illani>Illani ilosc: ".$player -> illani."</option>";
    }
    if ($player -> illanias) {
        $options = $options."<option value=illanias>Illanias ilosc: ".$player -> illanias."</option>";
    }
    if ($player -> dynallca) {
        $options = $options."<option value=dynallca>Dynallca ilosc: ".$player -> dynallca."</option>";
    }
    $smarty -> assign ("Options", $options);
    if (isset ($_GET['step']) && $_GET['step'] == 'add') {
        if (!isset($_POST['herb'])) {
            error("Jakie ziola chcesz zasiac?");
        }
        if ($_POST['herb'] != 'nutari' && $_POST['herb'] != 'illani' && $_POST['herb'] != 'illanias' && $_POST['herb'] != 'dynallca') {
            error ("Zapomnij o tym!");
        }
        if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
            error ("Zapomnij o tym!");
        }
        $unused = $farm -> fields['amount'] - $farm -> fields['used'];
        if ($_POST['amount'] > $unused) {
            error ("Nie masz tyle wolnego obszaru!");
        }
        $name = $_POST['herb'];
        $herbneed = $_POST['amount'] * 10;
        
		if ($player -> $name < $herbneed) 
		{
            error ("Nie masz tyle ".$_POST['herb']);
        }
        $have = $db -> Execute("SELECT id FROM farm WHERE owner=".$player -> id." AND name='".$_POST['herb']."' AND age=0");
        if (!$have -> fields['id']) {
            $db -> Execute("INSERT INTO farm (owner, name, amount) VALUES(".$player -> id.",'".$_POST['herb']."',".$_POST['amount'].")") or error ("Nie moge dodac ziol!");
        } else {
            $db -> Execute("UPDATE farm SET amount=amount+".$_POST['amount']." WHERE id=".$have -> fields['id']);
        }
	$have -> Close();
        $db -> Execute("UPDATE farms SET used=used+".$_POST['amount']." WHERE owner=".$player -> id);
        //$db -> Execute("UPDATE herbs SET ".$_POST['herb']."=".$_POST['herb']."-".$herbneed." WHERE gracz=".$player -> id);
        $player -> $_POST['herb'] -= $herbneed;
        error ("Zasiales ".$_POST['amount']." obszar(ow) farmy ziolem ".$_POST['herb']);
    }
}

// zbieranie ziol
if (isset ($_GET['view']) && $_GET['view'] == 'take') {
    $chop = $db -> Execute("SELECT * FROM farm WHERE owner=".$player -> id." AND age>4");
    if (!$chop -> fields['id']) {
        error ("Nie masz ziol do zebrania!");
    }
    $text = '';
    while (!$chop -> EOF) {
        $amount = rand(1, $chop -> fields['amount'] * 20);
        $amount = $amount + ceil($player -> int / 10);
        if ($player -> clas == 'Druid' || $player -> clas == 'Mag') {
            $amount = $amount + ceil($player -> level / 10);
        }
        //$have = $db -> Execute("SELECT id FROM herbs WHERE gracz=".$player -> id);
        //if (!$have -> fields['id']) {
        //    $db -> Execute("INSERT INTO herbs (gracz, ".$chop -> fields['name'].") VALUES(".$player -> id.",".$amount.")");
        //} else {
        //    $db -> Execute("UPDATE herbs SET ".$chop -> fields['name']."=".$chop -> fields['name']."+".$amount." where gracz=".$player -> id);
        //}
		//$have -> Close();
        $tmp = $chop->fields['name'];
		$player -> $tmp += $amount;
        $db -> Execute("UPDATE farms SET used=used-".$chop -> fields['amount']." WHERE owner=".$player -> id);
        $db -> Execute("DELETE FROM farm WHERE id=".$chop -> fields['id']);
        $text = $text."Zebrales ".$amount." sztuk ".$chop -> fields['name']."<br>";
	$chop -> MoveNext();
    }
    $smarty -> assign ("Chop", $text);
}
$farm -> Close();

// inicjalizacja zmiennej
if (!isset($_GET['view'])) {
    $_GET['view'] = '';
}

// przypisanie zmniennej oraz wyswietlenie strony
$smarty -> assign ("View", $_GET['view']);
$smarty -> display ('farm.tpl');

require_once("includes/foot.php");

