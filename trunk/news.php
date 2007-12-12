<?php
//@type: F
//@desc: Plotki
/***************************************************************************
 *                               news.php
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

$title = "Miejskie Plotki";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

if (!isset ($_GET['view'])) {
	$news = $db-> SelectLimit("SELECT * FROM news ORDER BY id DESC",5);
	$smarty->assign("News",$news->GetArray());
    $upd = $db -> SelectLimit("SELECT * FROM news ORDER BY id DESC", 1);
    //$smarty -> assign ( array("Title1" => $upd -> fields['title'], "Starter" => $upd -> fields['starter'], "News" => $upd -> fields['news']));
} else {
    $upd = $db -> SelectLimit("SELECT * FROM news ORDER BY id DESC", 10);
    $arrtitle = array();
    $arrstarter = array();
    $arrnews = array();
    $i = 0;
    while (!$upd -> EOF) {
        $arrtitle[$i] = $upd -> fields['title'];
        $arrstarter[$i] = $upd -> fields['starter'];
        $arrnews[$i] = $upd -> fields['news'];
	$upd -> MoveNext();
        $i = $i + 1;
    }
    $upd -> Close();
    $smarty -> assign ( array("Title1" => $arrtitle, "Starter" => $arrstarter, "News" => $arrnews));
}

// inicjalizacja zmiennej
if (!isset($_GET['view'])) {
    $_GET['view'] = '';
}

// przypisanie zmiennej oraz wyswietlenie strony
$smarty -> assign ("View", $_GET['view']);
$smarty -> display ('news.tpl');

require_once("includes/foot.php");
?>
