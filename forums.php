<?php
/***************************************************************************
 *                               forums.php
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

$title = "Forum"; 
require_once("includes/head.php");

// Lista kategorii
if (isset ($_GET['view']) && $_GET['view'] == 'categories') {
    $cat = $db -> Execute("SELECT * FROM categories ORDER BY id ASC");
    $arrid = array();
    $arrname = array();
    $arrtopics = array();
    $arrdesc = array();
	$replies =array();
    $i = 0;
    while (!$cat -> EOF) {
        $query = $db -> Execute("SELECT * FROM topics WHERE cat_id=".$cat -> fields['id']);
		$topics = $query -> RecordCount();
		while(!$query->EOF) {
			$try=$db->Execute("SELECT * FROM replies WHERE topic_id=".$query->fields['id'].";");
			$replies[$i]+=$try->RecordCount();
			$try->Close();
			$query->MoveNext();
		}
		$query -> Close();
		$arrid[$i] = $cat -> fields['id'];
		$arrname[$i] = $cat -> fields['name'];
		$arrtopics[$i] = $topics;
		$arrdesc[$i] = $cat -> fields['desc'];
		$cat -> MoveNext();
		$i = $i + 1;
    }
    $cat -> Close();
    $smarty -> assign ( array("Id" => $arrid, "Name" => $arrname, "Topics1" => $arrtopics, "Description" => $arrdesc,"Replies"=>$replies));
}

// The Topic List
if (isset($_GET['topics'])) {
    $topic = $db -> Execute("SELECT * FROM topics WHERE cat_id=".$_GET['topics']." ORDER BY id ASC");
    $arrid = array();
    $arrtopic = array();
    $arrstarter = array();
    $arrreplies = array();
	$starttext = array();
    $i = 0;
    while (!$topic -> EOF) {
        $query = $db -> Execute("SELECT * FROM replies WHERE topic_id=".$topic -> fields['id']);
		$replies = $query -> RecordCount();
		$query -> Close();
		$arrid[$i] = $topic -> fields['id'];
		$arrtopic[$i] = $topic -> fields['topic'];
		$arrstarter[$i] = $topic -> fields['starter'];	//?
		$starttext[$i]=htmlspecialchars (str_replace( "&amp;#322;", "ł" , $topic->fields['body'] ) );
		$arrreplies[$i] = $replies;
		$topic -> MoveNext();
		$i = $i + 1;
    }
    $topic -> Close();
    $smarty -> assign ( array("Category" => $_GET['topics'], "Id" => $arrid, "Topic1" => $arrtopic, "Starter1" => $arrstarter, "Replies1" => $arrreplies,"Starttext"=>$starttext));
}

// View Topic
if (isset($_GET['topic'])) {
    $topicinfo = $db -> Execute("SELECT * FROM topics WHERE id=".$_GET['topic']);
    if (!$topicinfo -> fields['id']) {
	error ("Nie ten temat.");
    }
    if ($player -> rank == 'Admin' || $player -> rank == 'Staff') {
        $smarty -> assign ("Action", " (<a href=forums.php?kasuj1=".$topicinfo -> fields['id'].">Skasuj</a>)");
    } else {
        $smarty -> assign("Action", '');
    }
    $text1 = wordwrap($topicinfo -> fields['body'],45,"\n",1);
    $reply = $db -> Execute("SELECT * FROM replies WHERE topic_id=".$topicinfo -> fields['id']." ORDER BY id ASC");
    $arrstarter = array();
    $arrplayerid = array();
    $arrtext = array();
    $arraction = array();
    $i = 0;
    while (!$reply -> EOF) {
        $arrstarter[$i] = $reply -> fields['starter'];
        $arrplayerid[$i] = $reply -> fields['gracz'];
	if ($player -> rank == 'Admin' || $player -> rank == 'Staff') {
	    $arraction[$i] = "(<a href=forums.php?kasuj=".$reply -> fields['id'].">Skasuj</a>)";
	} else {
            $arraction[$i] = '';
        }
        $text = wordwrap($reply -> fields['body'],45,"\n",1);
        $arrtext[$i] = $text;
	$reply -> MoveNext();
        $i = $i + 1;
    }
    $reply -> Close();
    $smarty -> assign ( array ("Topic2" => $topicinfo -> fields['topic'], "Starter" => $topicinfo -> fields['starter'], "Playerid" => $topicinfo -> fields['gracz'], "Category" => $topicinfo -> fields['cat_id'], "Ttext" => $text1, "Rstarter" => $arrstarter, "Rplayerid" => $arrplayerid, "Rtext" => $arrtext, "Action2" => $arraction, "Id" => $topicinfo -> fields['id']));
    $topicinfo -> Close();
}

// Add Topic
if (isset ($_GET['action']) && $_GET['action'] == 'addtopic') {
    if (empty ($_POST['title2']) || empty ($_POST['body'])) {
	error ("Wypelnij wszystkie pola.");
    }
    $_POST['title2'] = strip_tags($_POST['title2']);
    require_once('includes/bbcode.php');
    $_POST['body'] = bbcodetohtml($_POST['body']);    
    $_POST['title2'] = "<b>".$newdata."</b> ".$_POST['title2'];
    $db -> Execute("INSERT INTO topics (topic, body, starter, gracz, cat_id) VALUES('".$_POST['title2']."', '".$_POST['body']."', '".$player -> user."',".$player -> id.",".$_POST['catid'].")") or die("Could not add topic.");
    error ("Temat dodany. Kliknij <a href=forums.php?topics=".$_POST['catid'].">tutaj</a> aby wrocic do listy tematow w danej kategorii.",'done');
}

// Add Reply
if (isset($_GET['reply'])) {
    $query = $db -> Execute("SELECT * FROM topics WHERE id=".$_GET['reply']);
    $exists = $query -> RecordCount();
    $query -> Close();
    if ($exists <= 0) {
	error ("Nie ten temat.");
    }
    if (empty ($_POST['rep'])) {
	error ("Musisz wypelnic wszystkie pola.");
    }
    require_once('includes/bbcode.php');
    $_POST['rep'] = bbcodetohtml($_POST['rep']);
    $_POST['rep'] = "<b>".$newdata."</b><br>".$_POST['rep'];
    $db -> Execute("INSERT INTO replies (starter, data, topic_id, body, gracz) VALUES('".$player -> user."',".time().",".$_GET['reply'].",'".$_POST['rep']."',".$player -> id.")") or die("Could not add reply.");
    error ("Odpowiedz dodana. Kliknij <a href=forums.php?topic=".$_GET['reply'].">tutaj</a>.",'done');
}

//Kasowanie Postu
if (isset($_GET['kasuj'])) {
    $tid = $db -> Execute("SELECT topic_id FROM replies WHERE id=".$_GET['kasuj']);
    $db -> Execute("DELETE FROM replies WHERE id=".$_GET['kasuj']);
    error ("Post wykasowany <a href=forums.php?topic=".$tid -> fields['topic_id'].">wroc</a>",'done');
}

// Kasowanie Tematu
if (isset($_GET['kasuj1'])) {
    $cid = $db -> Execute("SELECT cat_id FROM topics WHERE id=".$_GET['kasuj1']);
    $db -> Execute("DELETE FROM replies WHERE topic_id=".$_GET['kasuj1']);
    $db -> Execute("DELETE FROM topics WHERE id=".$_GET['kasuj1']);
    error ("Temat wykasowany <a href=forums.php?topics=".$cid -> fields['cat_id'].">wroc</a>",'done');
}

// inicjalizacja zmiennych
if (!isset($_GET['topics'])) {
    $_GET['topics'] = '';
}
if (!isset($_GET['topic'])) {
    $_GET['topic'] = '';
}
if (!isset($_GET['view'])) {
    $_GET['view'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("View" => $_GET['view'], "Topics" => $_GET['topics'], "Topic" => $_GET['topic']));
$smarty -> display ('forums.tpl');

require_once("includes/foot.php");
?>

