<?php
/***************************************************************************
 *                               quests_class.php
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
class Quests {
	var $number;
	var $location;
	// Konstruktor klasy - start przygody i pobranie pierwszego tekstu
	function Quests($location,$number,$action) {
		global $db;
		global $smarty;
		global $player;
		if (!$action || $action == 'start') {
		    $text = $db -> Execute("SELECT text FROM quests WHERE qid=".$number." AND location='".$location."' AND name='start'");
		    $smarty -> assign("Start", $text -> fields['text']);
		    $text -> Close();
		    $db -> Execute("UPDATE players set miejsce='podroz' WHERE id=".$player -> id);
		    $test = $db -> Execute("SELECT id FROM questaction WHERE player=".$player -> id." AND quest=".$number);
		    if (empty($test -> fields['id'])) {
		        $db -> Execute("INSERT INTO questaction (player, action, quest) VALUES(".$player -> id.",'start',".$number.")");
	        }
	        $test -> Close();
	    }
	    if ($action == 'end') {
		    error("Juz byles na tej przygodzie!");
	    }		    
		$this -> number = $number;
		$this -> location = $location;
	}
	// Pole wyboru (checkbox) dla akcji podejmowanych przez gracza
	function Box($num) {
		global $db;
		global $smarty;
		$name = "box".$num;
		$box = $db -> Execute("SELECT text FROM quests WHERE qid=".$this -> number." AND location='".$this -> location."' AND name='".$name."'");
		$arrtext = array();
		$arroption = array();
		$i = 0;
		while (!$box -> EOF) {
			$arrtext[$i] = $box -> fields['text'];
			$arroption[$i] = $i + 1;
			$i = $i + 1;
			$box -> MoveNext();
		}
		$box -> Close();
		$smarty -> assign( array("Box" => $arrtext, "File" => $this -> location, "Name" => $name, "Option" => $arroption));
	}
	// Wyswietlanie tektsu w zaleznosci od wydarzenia
	function Show($num) {
		global $db;
		global $smarty;
		global $player;
	    $db -> Execute("UPDATE questaction SET action='".$num."' WHERE player=".$player -> id." AND quest=".$this -> number);
		$text = $db -> Execute("SELECT text FROM quests WHERE qid=".$this -> number." AND location='".$this -> location."' AND name='".$num."'");
		$smarty -> assign("Text", $text -> fields['text']);
		$text -> Close();
	}
	// Zakonczenie przygody
	function Finish($exp) {
		global $db;
		global $smarty;
		global $player;
		$db -> Execute("UPDATE questaction SET action='end' WHERE player=".$player -> id." AND quest=".$this -> number);
		$db -> Execute("UPDATE players SET miejsce='Athkatla' WHERE id=".$player -> id);
		$gainexp = $exp * $player -> level;
		if ($exp > 0) {
            $text = "Dostajesz ".$gainexp." Punktow Doswiadczenia";
			require_once("includes/checkexp.php");
            checkexp($player -> exp,$gainexp,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
        } else {
	        $text = '';
        }
		$smarty -> assign("End", $text.'<br /><br />(<a href="athkatla.php">Wróc do miasta</a>)');
    }
    // Walka turowa podczas przygody
    function Battle($adress) {
        global $player;
        global $smarty;
        global $enemy;
        global $arrehp;
        global $db;
        global $newdate;
        require_once('includes/turnfight.php');
        require_once('includes/funkcje.php');
        $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
	$enemy1 = $db -> Execute("SELECT * FROM monsters WHERE id=".$fight -> fields['fight']);
	$enemy = array("strength" => $enemy1 -> fields['strength'], "agility" => $enemy1 -> fields['agility'], "speed" => $enemy1 -> fields['speed'], "endurance" => $enemy1 -> fields['endurance'], "hp" => $enemy1 -> fields['hp'], "name" => $enemy1 -> fields['name'], "exp1" => $enemy1 -> fields['exp1'], "exp2" => $enemy1 -> fields['exp2'], "level" => $enemy1 -> fields['level']);
        $span = ($enemy1 -> fields['level'] / $player -> level);
        if ($span > 2) {
      	    $span = 2;
        }
        $expgain = ceil(rand($enemy1 -> fields['exp1'],$enemy1 -> fields['exp2'])  * $span);
        $goldgain = ceil(rand($enemy1 -> fields['credits1'],$enemy1 -> fields['credits2']) * $span);
	    $enemy1 -> Close();        
        $arrehp = array ();
        if (!isset ($_POST['action'])) {
            turnfight ($expgain,$goldgain,'',$adress);
        } else {
            turnfight ($expgain,$goldgain,$_POST['action'],$adress);
        }
        if ($fight -> fields['fight'] == 0) {
            $player -> energy = $player -> energy - 1;
            $db -> Execute("UPDATE players SET energy=".$player -> energy." WHERE id=".$player -> id);
       }
       $fight -> Close();
   }
   // Zdobywanie doswiadczenia podczas przygody
   function Gainexp($exp) {
		global $db;
		global $smarty;
		global $player;
		$gainexp = $exp * $player -> level;
        $text = "Dostajesz ".$gainexp." Punktow Doswiadczenia";
	    require_once("includes/checkexp.php");
        checkexp($player -> exp,$gainexp,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
		$smarty -> assign("End", "<br /><br />".$text);        
    }
    // Odpowiedzi na pytania
    function Answer($num,$answfalse,$repeat) {
	    global $db;
	    global $player;
	    global $smarty;
            if (!isset($_POST['planswer'])) {
                $_POST['planswer'] = '';
            }
	    $_POST['planswer'] = strip_tags($_POST['planswer']);
	    $ans = $db -> Execute("SELECT * FROM quests WHERE qid=".$this -> number." AND location='".$this -> location."' AND name='".$num."'");
	    if ($repeat == 'Y') {
	        $db -> Execute("UPDATE players SET temp=temp-1 WHERE id=".$player -> id);
	    }
	    if (isset($_POST['planswer']) && $_POST['planswer'] == $ans -> fields['option']) {
		return 1;
	    } elseif (isset($_POST['planswer']) && $_POST['planswer'] != $ans -> fields['option']) {
		if (!empty($answfalse)) {
		    $text = $db -> Execute("SELECT text FROM quests WHERE qid=".$this -> number." AND location='".$this -> location."' AND name='".$answfalse."'");
		    $smarty -> assign("Link", $text -> fields['text']);
		    $text -> Close();
	        }
	        return 0;				
	    }
    }
    // rezygnacja z przygody
    function Resign() {
        global $db;
	global $player;
	global $smarty;
	$db -> Execute("DELETE FROM questaction WHERE player=".$player -> id." AND quest=".$this -> number);
	$db -> Execute("UPDATE players SET miejsce='Athkatla' WHERE id=".$player -> id);
	$smarty -> assign("End", "(<a href=\"grid.php\">Labirynt</a>)");
    }
}
?>

