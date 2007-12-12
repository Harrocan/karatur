<?php
/***************************************************************************
 *                               tforums.php
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

$title = "Forum klanu";
require_once("includes/head.php");

if ($player -> tribe == 0) {
    error ("Zapomnij o tym!");
}

// The Topic List
if (isset ($_GET['view']) && $_GET['view'] == 'topics') {
    $topic = $db -> Execute("SELECT * FROM tribe_topics WHERE tribe=".$player -> tribe." ORDER BY id ASC");
    $arrid = array();
    $arrrep = array();
    $arrtopic = array();
    $arrstarter = array();
    $i = 0;
    while (!$topic -> EOF) {
	    $arrid[$i] = $topic -> fields['id'];
	    $query = $db -> Execute("SELECT id FROM tribe_replies WHERE topic_id=".$topic -> fields['id']);
	    $arrrep[$i] = $query -> RecordCount();
	    $query -> Close();
	    $arrtopic[$i] = $topic -> fields['topic'];
	    $arrstarter[$i] = $topic -> fields['starter'];
	    $topic -> MoveNext();
	    $i = $i + 1;
    }
    $topic -> Close();
    $smarty -> assign( array("Topicid" => $arrid, "Topic" => $arrtopic, "Replies" => $arrrep, "Starter" => $arrstarter));
}

// View Topic
if (isset($_GET['topic'])) {
    if (!ereg("^[1-9][0-9]*$", $_GET['topic'])) {
	    error ("Zapomnij o tym!");
    }
    $klan = $db -> Execute("SELECT id, owner FROM tribes WHERE id=".$player -> tribe);
    $topicinfo = $db -> Execute("SELECT * FROM tribe_topics WHERE id=".$_GET['topic']." AND tribe=".$player -> tribe);
    $perm = $db -> Execute("SELECT forum FROM tribe_perm WHERE tribe=".$klan -> fields['id']);
    if (!$topicinfo -> fields['id']) {
	    error ("Nie ma tematu.");
    }
    $smarty -> assign ( array("Topic" => $topicinfo -> fields['topic'], "Starter" => $topicinfo -> fields['starter']));
    if ($player -> id == $klan -> fields['owner'] || $player -> id == $perm -> fields['forum']) {
        $smarty -> assign ("Delete", " (<a href=tforums.php?kasuj1=".$topicinfo -> fields['id'].">Skasuj</a>)");
    } else {
        $smarty -> assign("Delete", '');
    }
    $text = wordwrap($topicinfo -> fields['body'],45,"\n",1);
    $smarty -> assign ("Topictext", $text);
    $reply = $db -> Execute("SELECT * FROM tribe_replies WHERE topic_id=".$topicinfo -> fields['id']." ORDER BY id ASC");
    $arrstarter = array();
    $arraction = array();
    $arrtext = array();
    $i = 0;
    while (!$reply -> EOF) {
	$arrstarter[$i] = $reply -> fields['starter'];
	if ($player -> id == $klan -> fields['owner'] || $player -> id == $perm -> fields['forum']) {
	    $arraction[$i] = "(<a href=tforums.php?kasuj=".$reply -> fields['id'].">Skasuj</a>)";
	} else {
        $arraction[$i] = '';
    }
    $arrtext[$i] = wordwrap($reply -> fields['body'],45,"\n",1);
	$reply -> MoveNext();
        $i = $i + 1;
    }
    $reply -> Close();
    $klan -> Close();
    $smarty -> assign ( array("Id" => $topicinfo -> fields['id'], "Repstarter" => $arrstarter, "Action" => $arraction, "Reptext" => $arrtext));
    $topicinfo -> Close();
}

// Add Topic
if (isset ($_GET['action']) && $_GET['action'] == 'addtopic') {
    if (empty ($_POST['title2']) || empty ($_POST['body'])) {
	    error ("Musisz wypelnic wszystkie pola.");
    }
    $_POST['title2'] = strip_tags($_POST['title2']);
    require_once('includes/bbcode.php');
    $_POST['body'] = bbcodetohtml($_POST['body']);
    $db -> Execute("INSERT INTO tribe_topics (topic, body, starter, tribe) VALUES('".$_POST['title2']."', '".$_POST['body']."', '".$player -> user."', '".$player -> tribe."')") or error("Could not add topic.");
    error ("Temat dodany. Kliknij <a href=tforums.php?view=topics>tutaj</a> aby wrocic do listy tematow.");
}

// Add Reply
if (isset($_GET['reply'])) {
    if (!ereg("^[1-9][0-9]*$", $_GET['reply'])) {
	    error ("Zapomnij o tym!");
    }
    $test = $db -> Execute("SELECT tribe FROM tribe_topics WHERE id=".$_GET['reply']." AND tribe=".$player -> tribe);
    if (!$test -> fields['tribe']) {
	    error ("Zapomnij o tym!");
    }
    $test -> Close();
    $query = $db -> Execute("SELECT * FROM tribe_topics WHERE id=".$_GET['reply']);
    $exists = $query -> RecordCount();
    $query -> Close();
    if ($exists <= 0) {
	    error ("Nie ma tematu.");
    }
    if (empty ($_POST['rep'])) {
	    error ("Musisz wypelnic wszystkie pola.");
    }
    require_once('includes/bbcode.php');
    $_POST['rep'] = bbcodetohtml($_POST['rep']);
    $db -> Execute("INSERT INTO tribe_replies (starter, topic_id, body) VALUES('".$player -> user."', ".$_GET['reply'].", '".$_POST['rep']."')") or error("Could not add reply.");
    error ("Odpowiedz dodana. Kliknij <a href=tforums.php?topic=".$_GET['reply'].">tutaj</a>.");
}

//Kasowanie Postu
if (isset($_GET['kasuj'])) {
    if (!ereg("^[1-9][0-9]*$", $_GET['kasuj'])) {
	    error ("Zapomnij o tym!");
    }
    $test = $db -> Execute("SELECT topic_id FROM tribe_replies WHERE id=".$_GET['kasuj']);
    if ($test -> fields['topic_id']) {
	    $test2 = $db -> Execute("SELECT id FROM tribe_topics WHERE id=".$test -> fields['topic_id']." and tribe=".$player -> tribe);
	    if (!$test2 -> fields['id']) {
	        error ("Zapomnij o tym!");
	    } else {
	        $db -> Execute("DELETE FROM tribe_replies WHERE id=".$_GET['kasuj']);
	        error ("Post wykasowany <a href=tforums.php?view=topics>wroc</a>");
	    }
    }
}

// Kasowanie Tematu
if (isset($_GET['kasuj1'])) {
    if (!ereg("^[1-9][0-9]*$", $_GET['kasuj1'])) {
	    error ("Zapomnij o tym!");
    }
    $test = $db -> Execute("SELECT id FROM tribe_topics WHERE id=".$_GET['kasuj1']." AND tribe=".$player -> tribe);
    if (!$test -> fields['id']) {
	    error ("Zapomnij o tym!");
    } else {
	    $db -> Execute("DELETE FROM tribe_replies WHERE topic_id=".$_GET['kasuj1']);
	    $db -> Execute("DELETE FROM tribe_topics WHERE id=".$_GET['kasuj1']);
	    error ("Temat wykasowany <a href=tforums.php?view=topics>wroc</a>");
    }
}
// inicjalizacja zmiennych
if (!isset($_GET['view'])) {
    $_GET['view'] = '';
}
if (!isset($_GET['topic'])) {
    $_GET['topic'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign( array("View" => $_GET['view'], "Topics" => $_GET['topic']));
$smarty -> display('tforums.tpl');

require_once("includes/foot.php");
?>

