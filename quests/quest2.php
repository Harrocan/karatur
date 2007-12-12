<?php
/***************************************************************************
 *                               quest2.php
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

// przypisanie zmiennych do templatow
$smarty -> assign(array("Start" => '', "End" => '', "Text" => '', "Box" => '', "Link" => '', "Answer" => ''));

require_once('class/quests_class.php');

$test = $db -> Execute("SELECT action FROM questaction WHERE player=".$player -> id." AND quest=2");
$quest = new Quests('grid.php',2,$test -> fields['action']);

if (isset($_GET['step']) && $_GET['step'] == 'quest' && empty($test -> fields['action'])) {
	$db -> Execute("UPDATE players SET miejsce='Athkatla' WHERE id=".$player -> id);
	error("Nie jestes na przygodzie!");
}

if ((!$test -> fields['action'] || $test -> fields['action'] == 'start') && !isset($_POST['box1'])) {
    $quest -> Box('1');
}

if ((isset($_POST['box1']) && $_POST['box1'] == 2) || $test -> fields['action'] == '2') {
	$smarty -> assign("Start", "");
	$quest -> Show('2');
	$quest -> Resign();
}

if ((isset($_POST['box1']) && $_POST['box1'] == 1) || $test -> fields['action'] == '1') {
	$smarty -> assign("Start", "");	
	$quest -> Show('1');
	$quest -> Box(2);
}

if ((isset($_POST['box2']) && $_POST['box2'] == 4) || $test -> fields['action'] == '1.4' || (isset($_POST['box4']) && $_POST['box4'] == 3) || (isset($_POST['box6']) && $_POST['box6'] == 2)) {
	$quest -> Show('1.4');
	$smarty -> assign("Box","");
	$quest -> Finish(10);
}

if (isset($_POST['box2']) && $_POST['box2'] == 1) {
	$quest -> Show('1.1');
	$smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)", "Box" => ""));
}

if ($test -> fields['action'] === '1.1') {
	$chance = ($player -> inteli + rand(1,100));
	if ($chance < 200) {
		$quest -> Show('int2');
		$db -> Execute("UPDATE players SET hp=hp-1 WHERE id=".$player -> id);
	} else {
		$quest -> Show('int1');
		$quest -> Gainexp(10);
	}
	$smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)"));		
}

if ($test -> fields['action'] == 'int1' || $test -> fields['action'] == 'int2' || $test -> fields['action'] == '1.1next') {
	$quest -> Show('1.1next');
	$quest -> Box(3);
}

if ((isset($_POST['box3']) && $_POST['box3'] == 2) || $test -> fields['action'] == '1.1.2') {
	$quest -> Show('1.1.2');
	$quest -> Box(4);
	if (isset($_POST['box3'])) {
	    $quest -> Gainexp(10);
	}
}

if ((isset($_POST['box3']) && $_POST['box3'] == 1) || $test -> fields['action'] == '1.1.1') {
	$quest -> Show('1.1.1');
	$smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Nurkuj</a>)", "Box" => ""));
}

if ($test -> fields['action'] === '1.1.1') {
	$chance = ($player -> cond + rand(1,100));
	if ($chance > 200) {
		$quest -> Show('con1');
		$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'stalowy miecz',25,'W',20000,0,250,25,250,1,'N',0,10,'N')") or error("nie moge dodac!");
		$quest -> Gainexp(20);
	} else {
		$quest -> Show('con2');
		$quest -> Gainexp(10);
	}
	$smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)");		
}

if ($test -> fields['action'] == 'con1' || $test -> fields['action'] == 'con2' || $test -> fields['action'] == '1.1.1next') {
	$quest -> Show('1.1.1next');
	$quest -> Box(4);
}

if ((isset($_POST['box2']) && $_POST['box2'] == 2) || $test -> fields['action'] == '1.2' || (isset($_POST['box4']) && $_POST['box4'] == 1)) {
	$quest -> Show('1.2');
	$smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)", "Box" => ""));
}

if ($test -> fields['action'] === '1.2') {
	$chance = ($player -> inteli + rand(1,100));
	if ($chance > 200) {
		$quest -> Show('int3');
		$quest -> Box(5);
		$smarty -> assign("Link", "");
	} else {
		$quest -> Show('int4');
		$smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)");
	}
}

if ($test -> fields['action'] == 'int3') {
    $quest -> Show('int3');
    $quest -> Box(5);
    $smarty -> assign("Link", "");
}

if ($test -> fields['action'] == 'int4') {
	$chance = (rand(1,100));
	if ($chance < 51) {
		$quest -> Show('1.2.2');
	} else {
		$quest -> Show('1.2.1');
	}
	if ($player -> hp > 0) {
	    $smarty -> assign(array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)", "Box" => ""));
	}
}

if ((isset($_POST['box5']) && $_POST['box5'] == 1) || $test -> fields['action'] == '1.2.1') {
	$quest -> Show('1.2.1');
	$player -> hp = $player -> hp - 100;
	if ($player -> hp > 0) {
	    $smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)", "Box" => ""));
	}
}

if ((isset($_POST['box5']) && $_POST['box5'] == 2) || $test -> fields['action'] == '1.2.2') {
	$quest -> Show('1.2.2');
	if (isset($_POST['box5'])) {
	    $quest -> Gainexp(20);
	}
	$smarty -> assign(array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)", "Box" => ""));
}

if ($test -> fields['action'] == '1.2.1' && $player -> hp < 1) {
    $quest -> Show('hp2');
    $db -> Execute("UPDATE players SET hp=".$player -> hp." WHERE id=".$player -> id);
    $quest -> Finish(0);
}

if ($test -> fields['action'] == '1.2.1' && $player -> hp > 0) {
    $quest -> Show('hp1');
    $db -> Execute("UPDATE players SET hp=".$player -> hp." WHERE id=".$player -> id);
    $smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)", "Box" => ""));
}

if ($test -> fields['action'] == '1.2.2' || $test -> fields['action'] == 'hp1') {
    $quest -> Show('1.2next');
    $db -> Execute("UPDATE players SET fight=2 WHERE id=".$player -> id);
    $smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Walka</a>)", "Box" => ""));
}

if ($test -> fields['action'] == '1.2next') {
    $_POST['razy'] = 5;
    $quest -> Battle('grid.php?step=quest');
   	$fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);            
	if ($fight -> fields['fight'] == 0) {
		$health = $db -> Execute("SELECT hp FROM players WHERE id=".$player -> id);
		if ($health -> fields['hp'] <= 0) {
			$quest -> Show('lostfight1');
			$quest -> Finish(10);
		} elseif ($_POST['action'] != 'escape') {
			$quest -> Show('winfight1');
			$quest -> Box(6);
			$quest -> Gainexp(20);
			$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, minlev, amount) VALUES(".$player -> id.",'rozdzka magii',100,'S',40000,60,1)") or error("nie moge dodac!");
		} elseif ($_POST['action'] == 'escape') {
			$quest -> Show('escape');
			$quest -> Finish(10);
		}
		$health -> Close();
	} 
	$fight -> Close();
}

if ($test -> fields['action'] == 'winfight1' && !isset($_POST['box6'])) {
    $quest -> Show('winfight1');
    $quest -> Box(6);
}

if ((isset($_POST['box2']) && $_POST['box2'] == 3) || $test -> fields['action'] == '1.3' || (isset($_POST['box4']) && $_POST['box4'] == 2) || (isset($_POST['box6']) && $_POST['box6'] == 1)) {
	$quest -> Show('1.3');
	$quest -> Box(7);
}

if (isset($_POST['box7']) && $_POST['box7'] == 3) {
	$quest -> Show('1.4');
	$smarty -> assign("Box", "");
	$quest -> Finish(10);
}

if (isset($_POST['box7']) && $_POST['box7'] == 1) {
    $chance = ($player -> agility + rand(1,100));
    if ($chance < 200) {
	$quest -> Show('door1');
	$db -> Execute("UPDATE players SET temp=5 WHERE id=".$player -> id);
	$smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Sprobuj ponownie</a>)", "Box" => ""));
    } else {
	$quest -> Show('door3');
	$quest -> Gainexp(30);
	$smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Przejdz przez drzwi</a>)", "Box" => ""));
    }
}

if ($test -> fields['action'] == 'door1') {
	$amount = $db -> Execute("SELECT temp FROM players WHERE id=".$player -> id);
        $chance = ($player -> agility + rand(1,100));
	if ($chance < 200 && $amount -> fields['temp'] <= 0) {
		$quest ->Show('door2');
		$quest -> Finish(10);
	}
	$amount -> Close();
	if ($chance >= 200) {
		$db -> Execute("UPDATE players SET temp=0 WHERE id=".$player -> id);
		$quest ->Show('door3');
		$quest -> Gainexp(30);
		$smarty -> assign(array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Przejdz przez drzwi</a>)", "Box" => ""));
	}
	if ($chance < 200 && $amount -> fields['temp'] > 0) {
		$quest ->Show('door1');
		$db -> Execute("UPDATE players SET temp=temp-1 WHERE id=".$player -> id);
		$smarty -> assign(array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Sprobuj ponownie</a>)", "Box" => ""));
	}
}

if (isset($_POST['box7']) && $_POST['box7'] == 2) {
    $quest -> Show('door4');
    $quest -> Gainexp(30);
    $smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Przejdz przez drzwi</a>)", "Box" => ""));
}

if ($test -> fields['action'] == 'door3' || $test -> fields['action'] == 'door4' || $test -> fields['action'] == '1.3.1') {
   $quest -> Show('1.3.1');
   $quest -> Box(8);
}  

if ((isset($_POST['box8']) && $_POST['box8'] == 1) || $test -> fields['action'] == '1.3.1.2') {
	$quest -> Show('1.3.1.2');
	$quest -> Finish(20);
}

if (isset($_POST['box8']) && $_POST['box8'] == 2) {
	$quest -> Show('1.3.1.1');
	$smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)", "Box" => ""));
}

if ($test -> fields['action'] == '1.3.1.1') {
    $chance = (rand(1,100));
    if ($chance < 51) {
        $quest -> Show('1.3.1.1.1');
	$db -> Execute("UPDATE players SET fight=16 WHERE id=".$player -> id);
        $smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Walka</a>)");
    } else {
        $quest -> Show('1.3.1.1.2');
	$quest -> Box(9);
    }
}

if ($test -> fields['action'] == '1.3.1.1.2') {
    $quest -> Show('1.3.1.1.2');
    $quest -> Box(9);
}

if ($test -> fields['action'] == '1.3.1.1.1') {
    $quest -> Battle('grid.php?step=quest');
   	$fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);            
	if ($fight -> fields['fight'] == 0) {
		$health = $db -> Execute("SELECT hp FROM players WHERE id=".$player -> id);
		if ($health -> fields['hp'] <= 0) {
			$quest -> Show('lostfight2');
			$quest -> Finish(10);
		} elseif ($_POST['action'] != 'escape') {
			$quest -> Show('winfight2');
			$quest -> Box(9);
			$db -> Execute("UPDATE players SET temp=5 WHERE id=".$player -> id);
		} elseif ($_POST['action'] == 'escape') {
			$quest -> Show('escape');
			$quest -> Finish(10);
		}
		$health -> Close();
	} 
	$fight -> Close();
}

if (isset($_POST['box9']) && $_POST['box9'] == 1) {
    $quest -> Show('winfight2');
    $smarty -> assign( array("Answer" => "Y", "File" => "grid.php"));
}

if ($test -> fields['action'] == 'winfight2' && !isset($_POST['box9'])) {
        $smarty -> assign( array("Answer" => "Y", "File" => "grid.php"));
	$chance = $quest -> Answer('winfight2','chest1','Y');
	$amount = $db -> Execute("SELECT temp FROM players WHERE id=".$player -> id);
	if ($chance != 1 && $amount -> fields['temp'] <= 0) {
		$smarty -> assign( array("Link" => '', "Box" => '', "Answer" => ""));
		$quest ->Show('chest2');
		$quest -> Finish(30);
	}
	$amount -> Close();
	if ($chance == 1) {
		$smarty -> assign( array("Link" => '', "Box" => '', "Answer" => ""));
		$db -> Execute("UPDATE players SET temp=0 WHERE id=".$player -> id);
		$db -> Execute("UPDATE players SET maps=maps+1 WHERE id=".$player -> id);
		$quest ->Show('chest3');
		$quest -> Finish(50);
	}
}

if ((isset($_POST['box9']) && $_POST['box9'] == 1 && $test -> fields['action'] != 'winfight2') || $test -> fields['action'] == 'oldman1') {
    $smarty -> assign( array("Answer" => ""));
    $quest -> Show('oldman1');
    if ($player -> deity == 'Illuminati') {
        $db -> Execute("UPDATE players SET pw=pw+100 WHERE id=".$player -> id);
    } else {
        $db -> Execute("UPDATE players SET pw=pw+10 WHERE id=".$player -> id);
    }
    $quest -> Finish(40);
}

if ((isset($_POST['box9']) && $_POST['box9'] == 2 && $test -> fields['action'] != 'winfight2') || $test -> fields['action'] == 'oldman2') {
    $quest -> Show('oldman2');
    $quest -> Finish(30);
}

$test -> Close();

$smarty -> display('quest.tpl');
?>
