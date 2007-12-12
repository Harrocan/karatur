<?php
//@type: F
//@desc: Gal. bohaterów
/***************************************************************************
 *                               hof.php
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

$title = "Galeria Bohaterow";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta' && $player -> location != 'Dornland' && $player -> location != 'Proskur') {
	error ("Zapomnij o tym");

}*/
$hero = $db -> Execute("SELECT * FROM halloffame");
$arrname = array();
$arroldid = array();
$arrid = array();
$arrrace = array();
$i = 0;
if (!$hero -> fields['id']) {
    $smarty -> assign("Message", "Nie ma jeszcze bohaterow na tym swiecie!<br /><br />");
} else {
    $smarty -> assign("Message", '');
}
while (!$hero -> EOF) {
    $query = $db -> Execute("SELECT id FROM players WHERE id=".$hero -> fields['newid']);
    $test = $query -> RecordCount();
    if ($test == 0) {
        $arrid[$i] = "Odszedl";
    } else {
        $arrid[$i] = $hero -> fields['newid'];
    }
    $query -> Close();
    $arrname[$i] = $hero -> fields['oldname'];
    $arroldid[$i] = $hero -> fields['heroid'];
    $arrrace[$i] = $hero -> fields['herorace'];
    $hero -> MoveNext();
    $i = $i + 1;    
}
$hero -> Close();

$smarty -> assign( array("Hero" => $arrname, "Oldid" => $arroldid, "Heroid" => $arrid, "Herorace" => $arrrace));
$smarty -> display ('hof.tpl');

require_once("includes/foot.php");
?>
