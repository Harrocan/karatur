<?php
/***************************************************************************
 *                               armor.php
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

$title = "Platnerz"; 
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);
/*if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Imnescar' && $player -> location != 'Esphurta' && $player -> location != 'Proskur' && $player -> location != 'Iriaebor') {
	error ("Zapomnij o tym");
}*/


if ($player -> przemiana > 0) {

error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 

}



if (!isset($_GET['buy'])) {
    if (isset($_GET['dalej'])) {
	    if ($_GET['dalej'] != 'A' && $_GET['dalej'] != 'H' && $_GET['dalej'] != 'N' && $_GET['dalej'] != 'D') {
	        error ("Zapomnij o tym");
	    }
        $arrname = array();
        $arrcost = array();
        $arrlevel = array();
        $arrid = array();
        $arrdur = array();
        $arrpower = array();
        $arragility = array();
        $i = 0;
	    $arm = $db -> Execute("SELECT * FROM equipment WHERE type='".$_GET['dalej']."' AND status='S' AND owner=0 ORDER BY cost ASC");
	    while (!$arm -> EOF) {
            $arrname[$i] = $arm -> fields['name'];
            $arrcost[$i] = $arm -> fields['cost'];
            $arrlevel[$i] = $arm -> fields['minlev'];
            $arrid[$i] = $arm -> fields['id'];
            $arrdur[$i] = $arm -> fields['wt'];
            $arrpower[$i] = $arm -> fields['power'];
            $arragility[$i] = $arm -> fields['zr'];
            $i = $i + 1;
            $arm -> MoveNext();
	    }
	    $arm -> Close();
	    $smarty -> assign (array ("Name" => $arrname, "Cost" => $arrcost, "Level" => $arrlevel, "Id" => $arrid, "Durability" => $arrdur, "Power" => $arrpower, "Agility" => $arragility));
    }
}

if (isset($_GET['buy'])) {
    if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
	    error ("Zapomnij o tym");
    }
    $arm = $db -> Execute("SELECT * FROM equipment WHERE id=".$_GET['buy']);
    if ($arm -> fields['id'] == 0) {
 	    error ("Nie ta zbroja. Wroc do <a href=armor.php>sklepu</a>.");
    }
    if ($arm -> fields['status'] != 'S') {
	    error ("Tutaj tego nie sprzedasz. Wroc do <a href=armor.php>sklepu</a>.");
    }
    if ($arm -> fields['minlev'] > $player -> level) {
        error ("Twoj poziom jest za niski dla tej rzeczy! Wroc do <a href=armor.php>sklepu</a>.");
    }
    if ($arm -> fields['cost'] > $player -> credits) {
	    error ("Nie stac cie! Wroc do <a href=armor.php>sklepu</a>.");
    }
    $newcost = ceil($arm -> fields['cost'] * .75);
    $test = $db -> Execute("SELECT id FROM equipment WHERE name='".$arm -> fields['name']."' AND wt=".$arm -> fields['wt']." AND type='".$arm -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$arm -> fields['power']." AND zr=".$arm -> fields['zr']." AND szyb=".$arm -> fields['szyb']." AND maxwt=".$arm -> fields['maxwt']." AND poison=".$arm -> fields['poison']." AND cost=".$newcost);
    if ($test -> fields['id'] == 0) {
        $db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb) VALUES(".$player -> id.",'".$arm -> fields['name']."',".$arm -> fields['power'].",'".$arm -> fields['type']."',".$newcost.",".$arm -> fields['zr'].",".$arm -> fields['wt'].",".$arm -> fields['minlev'].",".$arm -> fields['maxwt'].",1,'".$arm -> fields['magic']."',".$arm -> fields['poison'].",".$arm -> fields['szyb'].")") or error("nie moge dodac!");
    } else {
        $db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
    }
    $test -> Close();
    $db -> Execute("UPDATE players SET credits=credits-".$arm -> fields['cost']." WHERE id=".$player -> id);
    $smarty -> assign (array ("Name" => $arm -> fields['name'], "Cost" => $arm -> fields['cost'], "Power" => $arm -> fields['power']));
    $arm -> Close();
}

if (isset ($_GET['steal'])) {
    require_once("includes/steal.php");
    require_once("includes/checkexp.php");
    steal($_GET['steal']);
}
if ($player -> clas != 'Zlodziej') {
    $player -> crime = 0;
}

//inicjalizacja zmiennych
if (!isset($_GET['buy'])) {
    $_GET['buy'] = '';
}
if (!isset($_GET['dalej'])) {
    $_GET['dalej'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign (array ("Buy" => $_GET['buy'], "Next" => $_GET['dalej'], "Crime" => $player -> crime));
$smarty -> display ('armor.tpl');

require_once("includes/foot.php");
?>
