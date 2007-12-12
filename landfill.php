<?php
//@type: F
//@desc: Oczyszczanie miasta
/***************************************************************************
 *                               landfill.php
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

$title = "Oczyszczanie miasta";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla') {
	error ("Zapomnij o tym");
}*/
if ($player -> hp == 0) {
	error ("Nie mozesz sprzatac miasta, poniewaz jestes martwy!");
}

if (!isset($_GET['action'])) {
    $_GET['action'] = '';
    $gain = ($player -> level * 25);
    $smarty -> assign ("Gold", $gain);
} else {
    if (!isset($_POST['amount'])) {
        error("Podaj ile czasu chcesz spedzic na sprzataniu miasta!");
    }
    if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
        error ("Zapomnij o tym!");
    }
    if ($player -> energy < $_POST['amount']) {
	error ("Nie masz tyle energii aby pracowac.");
    }
    $gain = (($player -> level * 25) * $_POST['amount']);
    //$db -> Execute("UPDATE players SET energy=energy-".$_POST['amount']." WHERE id=".$player -> id);
    //$db -> Execute("UPDATE players SET credits=credits+".$gain." WHERE id=".$player -> id);
	$player -> gold += $gain;
	$player -> energy -= $_POST['amount'];
    $smarty -> assign ( array("Gain" => $gain, "Amount" => $_POST['amount']));
}

$smarty -> assign ("Action", $_GET['action']);
$smarty -> display ('landfill.tpl');

require_once("includes/foot.php");
?>

