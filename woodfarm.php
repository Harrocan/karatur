<?php
//@type: F
//@desc: Ogród (drewno)
/***************************************************************************
 *                               woodfarm.php based on farm.php
 *                            -------------------
 *   copyright            : (C) 2005 by Korson
 *   email                : den4045@o2.pl
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

$title = "Ogrod";
require_once("includes/head.php");

if ($player -> location != 'Athkatla') {
    error ("Zapomnij o tym");
}

$farm = $db -> Execute("SELECT * FROM woodfarms WHERE owner=".$player -> id);
if (!$farm -> fields['id']) {
    $smarty -> assign ("Empty", "Y");
} else {
    $smarty -> assign("Empty", '');
}

if (isset($_GET['answer']) && $_GET['answer'] == 'yes') {
    if ($player -> platinum < 250) {
	error ("Nie masz wystarczajaco duzo sztuk mithrilu.");
    } else {
	$db -> Execute("UPDATE players SET platinum=platinum-250 WHERE id=".$player -> id);
        $db -> Execute("INSERT INTO woodfarms (owner) VALUES(".$player -> id.")") or error("Nie moge dodac farmy drewna");
	error ("Kupiles swoj pierwszy ogrod! Kliknij <a href=woodfarm.php>tutaj</a>.");
    }
}

// menu ogrodu
$farms = $db -> Execute("SELECT * FROM woodfarm WHERE owner=".$player -> id);
if (isset ($_GET['view']) && $_GET['view'] == 'stats') {
    $smarty -> assign ( array("Amount" => $farm -> fields['amount'], "Used" => $farm -> fields['used']));
    if (!$farms -> fields['id']) {
        $smarty -> assign ("Herbs", "Nie masz zasianych drzewek<br>");
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


//kupowanie nowego obszaru ogrody
if (isset ($_GET['view']) && $_GET['view'] == 'shop') {
    $cost = ($farm -> fields['amount'] * 10000);
    $smarty -> assign ("Cost", $cost);
    if (isset($_GET['buy']) && $_GET['buy'] == 'land') {
	if ($_GET['buy'] != 'land') {
	    error ("Zapomnij o tym");
	}
	if ($player -> credits >= $cost) {
	    $db -> Execute("UPDATE woodfarms SET amount=amount+1 WHERE owner=".$player -> id);
	    $db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
	    error ("Kupiles dodatkowy obszar dla swojego ogrodu. (<a href=woodfarm.php?view=shop>Odswiez</a>)");
	} else {
	    error ("Nie stac cie na to!");
        }
    }
}


// Sadzenie drzewek
if (isset ($_GET['view']) && $_GET['view'] == 'add') {
    $herbs = $db -> Execute("SELECT drzewka FROM kopalnie WHERE gracz=".$player -> id);
    $options = '';
    if ($herbs -> fields['drzewka']) {
        $options = $options."<option value=drzewka>Drzewka ilosc: ".$herbs -> fields['drzewka']."</option>";
    }

    $smarty -> assign ("Options", $options);
    if (isset ($_GET['step']) && $_GET['step'] == 'add') {
        if (!isset($_POST['herb'])) {
            error("Ile drzewek chcesz posadzic?");
        }
        if ($_POST['herb'] != 'drzewka') {
            error ("Mozesz sadzic tylko drzewka!");
        }
        if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
            error ("Zapomnij o tym!");
        }
        $unused = $farm -> fields['amount'] - $farm -> fields['used'];
        if ($_POST['amount'] > $unused) {
            error ("Nie masz miejsca na wiecej dzewek! Dokup wiecej obszarow!");
        }
        $name = $_POST['herb'];
        $herbneed = $_POST['amount'] * 10;
        if ($herbs -> fields[$name] < $herbneed) {
            error ("Nie masz tyle drzewek");
        }
        $have = $db -> Execute("SELECT id FROM woodfarm WHERE owner=".$player -> id." AND name='".$_POST['herb']."' AND age=0");
        if (!$have -> fields['id']) {
            $db -> Execute("INSERT INTO woodfarm (owner, name, amount) VALUES(".$player -> id.",'".$_POST['herb']."',".$_POST['amount'].")") or error ("Nie moge posadzic drzewek!");
        } else {
            $db -> Execute("UPDATE woodfarm SET amount=amount+".$_POST['amount']." WHERE id=".$have -> fields['id']);
        }
	$have -> Close();
        $db -> Execute("UPDATE woodfarms SET used=used+".$_POST['amount']." WHERE owner=".$player -> id);
        $db -> Execute("UPDATE kopalnie SET ".$_POST['herb']."=".$_POST['herb']."-".$herbneed." WHERE gracz=".$player -> id);
        error ("Zasadziles ".$_POST['amount']." obszar(ow) ogrodu ".$_POST['herb']);
    }
}

// zbieranie drewna

if (isset ($_GET['view']) && $_GET['view'] == 'take') {
    $chop = $db -> Execute("SELECT * FROM woodfarm WHERE owner=".$player -> id." AND age>4");
    if (!$chop -> fields['id']) {
        error ("Nie masz drzew do sciecia!");
    }
    $text = '';
    while (!$chop -> EOF) {
        $amount = rand(1, $chop -> fields['amount'] * 20);
        $amount = $amount + ceil($player -> inteli / 10);
        if ($player -> clas == 'Rzemieslnik') {
            $amount = $amount + ceil($player -> level / 10);
        }
        $bonus = (".$amount." / 0.02);
        $have = $db -> Execute("SELECT id FROM kopalnie WHERE gracz=".$player -> id);
        if (!$have -> fields['id']) {
            $db -> Execute("INSERT INTO kopalnie (gracz, ".$chop -> fields['name'].") VALUES(".$player -> id.",".$amount.")");
        } else {
            $db -> Execute("UPDATE kopalnie SET lumber=lumber+".$amount.", drzewka=drzewka+".$bonus." where gracz=".$player -> id);
        }

	$have -> Close();
        $db -> Execute("UPDATE woodfarms SET used=used-".$chop -> fields['amount']." WHERE owner=".$player -> id);
        $db -> Execute("DELETE FROM woodfarm WHERE id=".$chop -> fields['id']);
        $text = $text."Zebrales ".$amount." klod drewna, oraz ".$bonus." drzewek<br>";
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
$smarty -> display ('woodfarm.tpl');

require_once("includes/foot.php");
