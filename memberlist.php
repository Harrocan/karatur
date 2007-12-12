<?php
//@type: F
//@desc: Lista graczy
/**
 *   Funkcje pliku:
 *   Lista graczy
 *
 *   @name                 : memberlist.php                            
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

$title = "Lista mieszkancow"; 
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta' && $player -> location != 'Iriaebor') {
	error ("Zapomnij o tym");
}*/

// inicjalizacja zmiennych
$smarty -> assign(array("Previous" => '', "Next" => ''));

if (!isset($_POST['id'])) {
    $_POST['id'] = 0;
}

if (empty ($_POST['szukany']) && $_POST['id'] == 0) {
    $msel = $db -> Execute("SELECT id FROM players");
} else {
    $_POST['szukany'] = strip_tags($_POST['szukany']);
    $_POST['szukany'] = str_replace("*","%", $_POST['szukany']);
    if (!ereg("^[0-9]*$", $_POST['id'])) {
        error ("Zapomnij o tym!");
    }
    if (!empty ($_POST['szukany']) && $_POST['id'] == 0) {
        $msel = $db -> Execute("SELECT id FROM players WHERE user LIKE '".$_POST['szukany']."'");
    } elseif (!empty ($_POST['szukany']) && $_POST['id'] > 0) {
        $msel = $db -> Execute("SELECT id FROM players WHERE id=".$_POST['id']." AND user LIKE '".$_POST['szukany']."'");
    } elseif (empty ($_POST['szukany']) && $_POST['id'] > 0) {
        $msel = $db -> Execute("SELECT id FROM players WHERE id=".$_POST['id']);
    }
}

$graczy = $msel -> RecordCount();
$msel -> Close();
if ($graczy == 0 && isset($_POST['szukany'])) {
    print "Nie ma gracza o imieniu ".$_POST['szukany'];
}
if ($graczy == 0 && isset($_POST['id']) && $_POST['id'] > 0) {
    print "Nie ma gracza o id ".$_POST['id'];
}
if (!isset($_GET['limit'])) {
    $_GET['limit'] = 0;
}
if (!isset ($_GET['lista'])) {
    $_GET['lista'] = 'id';
}
if ($_GET['limit'] < $graczy) {
    if (empty ($_POST['szukany']) && $_POST['id'] == 0) {
	$mem = $db -> SelectLimit("SELECT id, user, rank, rasa, level FROM players ORDER BY ".$_GET['lista']." ASC", 30, $_GET['limit']);
    } elseif  (!empty ($_POST['szukany']) && $_POST['id'] == 0) {
	$mem = $db -> SelectLimit("SELECT id, user, rank, rasa, level FROM players WHERE user LIKE '".$_POST['szukany']."' ORDER BY ".$_GET['lista']." ASC", 30, $_GET['limit']);
    } elseif (!empty ($_POST['szukany']) && $_POST['id'] > 0) {
	$mem = $db -> SelectLimit("SELECT id, user, rank, rasa, level FROM players WHERE id=".$_POST['id']." AND user LIKE '".$_POST['szukany']."' ORDER BY ".$_GET['lista']." ASC", 30,  $_GET['limit']);
    } elseif (empty ($_POST['szukany']) && $_POST['id'] > 0) {
	$mem = $db -> SelectLimit("SELECT id, user, rank, rasa, level FROM players WHERE id=".$_POST['id']." ORDER BY ".$_GET['lista']." ASC", 30, $_GET['limit']);
    }
    $arrrank = array();
    $arrid = array();
    $arrname = array();
    $arrrace = array();
    $arrlevel = array();
    $i = 0;
    while (!$mem -> EOF) {
	if ($mem -> fields['rank'] == 'Admin') {
	    $arrrank[$i] = 'Wladca';
	} elseif ($mem -> fields['rank'] == 'Staff') {
	    $arrrank[$i] = 'Ksiaze';
	} elseif ($mem -> fields['rank'] == 'Member') {
	    $arrrank[$i] = 'Mieszkaniec';
	} else {
	    $arrrank[$i] = $mem -> fields['rank'];
	}
	$arrid[$i] = $mem -> fields['id'];
	$arrname[$i] = $mem -> fields['user'];
	$arrrace[$i] = $mem -> fields['rasa'];
	$arrlevel[$i] = $mem -> fields['level'];
	$mem -> MoveNext();
	$i = $i + 1;
    }
    $mem -> Close();
    $smarty -> assign ( array("Memid" => $arrid, "Name" => $arrname, "Race" => $arrrace, "Rank" => $arrrank, "Level" => $arrlevel));
    if ($_GET['limit'] >= 30) {
	$lim = $_GET['limit'] - 30;
	$smarty -> assign ("Previous", "<a href=memberlist.php?limit=".$lim."&lista=".$_GET['lista'].">Poprzednich 30 graczy</a> ");
    }
    $_GET['limit'] = $_GET['limit'] + 30;
    if ($graczy > 30 && $_GET['limit'] < $graczy) {
        $smarty -> assign ("Next", "<a href=memberlist.php?limit=".$_GET['limit']."&lista=".$_GET['lista'].">Nastepnych 30 graczy</a>");
    } 
}

$smarty -> display ('memberlist.tpl');

require_once("includes/foot.php");
?>
