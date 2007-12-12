<?php
/***************************************************************************
 *                               notatnik.php
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

$title = "Notatnik";
require_once("includes/head.php");

$log = $db -> SelectLimit("SELECT * FROM notatnik WHERE gracz=".$player -> id." ORDER BY id DESC", 25);
$arrtime = array();
$arrtext = array();
$arrid = array();
$i = 0;
while (!$log -> EOF) {
    $arrtime[$i] = $log -> fields['czas'];
    $arrtext[$i] = $log -> fields['tekst'];
    $arrid[$i] = $log -> fields['id'];
    $log -> MoveNext();
    $i = $i + 1;
}
$log -> Close();
$smarty -> assign ( array("Notetime" => $arrtime, "Notetext" => $arrtext, "Noteid" => $arrid));

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'skasuj') {
    if (!ereg("^[1-9][0-9]*$", $_GET['nid'])) {
	error ("Zapomnij o tym!");
    }
    $did = $db -> Execute("SELECT * FROM notatnik WHERE id=".$_GET['nid']);
    if (!$did -> fields['id']) {
	error ("Nie ma takiego wpisu!");
    }
    if ($player -> id != $did -> fields['gracz']) {
	error ("Nie twoj wpis!");
    }
    $db -> Execute("DELETE FROM notatnik WHERE gracz=".$player -> id." AND id=".$_GET['nid']);
    error ("<br>Skasowales wpis. (<a href=notatnik.php>odswiez</a>)");
}

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'dodaj') {
    if (isset ($_GET['step']) && $_GET['step'] == 'send') {
	if (empty ($_POST['body'])) {
	    error ("Wypelnij pole.");
	}
	$_POST['body'] = strip_tags($_POST['body']);
	$db -> Execute("INSERT INTO notatnik (gracz, tekst, czas) VALUES(".$player -> id.",'".$_POST['body']."', '".$newdate."')") or error("Nie moge wstawic wpisu.");
	error ("Notatka dodana. (<a href=notatnik.php>odswiez</a>)");
    }
}
//inicjalizacja zmiennej
if (!isset($_GET['akcja'])) {
    $_GET['akcja'] = '';
}

//przypisanie zmiennej oraz wyswietlenie strony
$smarty -> assign ("Action", $_GET['akcja']);
$smarty -> display ('notatnik.tpl');

require_once("includes/foot.php");
?>

