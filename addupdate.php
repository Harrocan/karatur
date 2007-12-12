<?php
/**
 *   Funkcje pliku:
 *   Dodawanie oraz modyfikacja wiesci
 *
 *   @name                 : addupdate.php                            
 *   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 24.01.2005
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

$title = "Dodaj Wiesc";
require_once("includes/head.php");
if($_SESSION['rank']['update']!='1')
	error("Nie posiadasz uprawnieñ ¿eby tutaj przebywaæ");



$smarty -> assign ( array("Button" => "Dodaj wiesc", "Link" => "addupdate.php?action=add", "Title1" => '', "Text" => ''));

// dodawanie nowej wiesci
if (isset ($_GET['action']) && $_GET['action'] == 'add') {
	if (empty($_POST['addtitle']) || empty($_POST['addupdate'])) {
		error ("Wypelnij wszystkie pola.");
	}
	$_POST['addupdate'] = nl2br($_POST['addupdate']);
	//$db -> Execute("INSERT INTO topics (topic, body, starter, gracz, cat_id) VALUES ('".$_POST['addtitle']."','".$_POST['addupdate']."','".$player->user."',".$player->id.",5);");

	$num = SqlExec( "INSERT INTO forum_top(cat_id, start_id, start_topic, start_body, start_time) VALUES(5, {$player->id}, '{$_POST['addtitle']}', '{$_POST['addupdate']}', ".time().")" );
	
	//$num = $db -> Execute("SELECT id FROM topics WHERE topic='".$_POST['addtitle']."' AND body='".$_POST['addupdate']."' AND gracz=".$player->id.";");
	SqlExec("INSERT INTO updates (starterid, starter, title, updates, time, topicid) VALUES({$player->id}, '".$player->user."','".$_POST['addtitle']."','".$_POST['addupdate']."','".$newdata."','".$num."')");
	error ("Wiesc dodana.",'done');
}

// modifikacja wiesci
if (isset ($_GET['modify'])) {
    if (!ereg("^[1-9][0-9]*$", $_GET['modify'])) {
        error ("Zapomnij o tym!");
    }
    $update = $db -> Execute("SELECT * FROM updates WHERE id=".$_GET['modify']);
	$update -> fields['updates'] = str_replace("<br />", "", $update -> fields['updates']);
    $smarty -> assign ( array("Title1" => $update -> fields['title'], "Text" => $update -> fields['updates'], "Button" => "Modyfikuj", "Link" => "addupdate.php?action=modify&updid=".$update -> fields['id']));
    $update -> Close();
}

//zapisywanie modyfikacji istniejacej wiadomosci
if (isset ($_GET['action']) && $_GET['action'] == 'modify') {
    if (empty($_POST['addtitle']) || empty($_POST['addupdate'])) {
	    error ("Wypelnij wszystkie pola.");
    }
    if (!ereg("^[1-9][0-9]*$", $_GET['updid'])) {
        error ("Zapomnij o tym!");
    }
    $uid = $db -> Execute("SELECT id, topicid FROM updates WHERE id=".$_GET['updid']);
    if ($uid -> fields['id']) {
		$_POST['addupdate'] = $_POST['addupdate']."\n \n Zmodyfikowana dnia ".$newdata." przez <b>".$player -> user."</b>";
	    $_POST['addupdate'] = nl2br($_POST['addupdate']);  
		$db -> Execute("UPDATE forum_top SET start_topic='".$_POST['addtitle']."' WHERE id=".$uid->fields['topicid']." ;");
		$db -> Execute("UPDATE forum_top SET start_body='".$_POST['addupdate']."' WHERE id=".$uid->fields['topicid']." ;");
        $db -> Execute("UPDATE updates SET title='".$_POST['addtitle']."' WHERE id=".$_GET['updid']);
        $db -> Execute("UPDATE updates SET updates='".$_POST['addupdate']."' WHERE id=".$_GET['updid']);
        error ("Wiesc zmodyfikowana.",'done');
    } else {
        error ("Nie ma takiej wiadomosci!");
    }
    $uid -> Close();
}

$smarty -> display('addupdate.tpl');

require_once("includes/foot.php");
?>

