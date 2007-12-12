<?php
/***************************************************************************
 *                               quest1.php
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

$test = $db -> Execute("SELECT action FROM questaction WHERE player=".$player -> id." AND quest=1");
$quest = new Quests('grid.php',1,$test -> fields['action']);

if (isset($_GET['step']) && $_GET['step'] == 'quest' && empty($test -> fields['action'])) {
	$db -> Execute("UPDATE players SET miejsce='Athkatla' WHERE id=".$player -> id);
	error("Nie jestes na przygodzie!");
}

if ((!$test -> fields['action'] || $test -> fields['action'] == 'start') && !isset($_POST['box1'])) {
    $quest -> Box('1');
}

if ((isset($_POST['box1']) && $_POST['box1'] == 3) || $test -> fields['action'] == '3') {
	$smarty -> assign("Start", "");
	$quest -> Show('3');
	$quest -> Resign();
}

if ((isset($_POST['box1']) && $_POST['box1'] == 1) || $test -> fields['action'] == '1') {
	$smarty -> assign("Start", "");	
	$quest -> Show('1');
	$quest -> Box(2);
}

if ((isset($_POST['box2']) && $_POST['box2'] == 1) || $test -> fields['action'] == '1.1') {
	$quest -> Show('1.1');
	$smarty -> assign("Box", "");
	$quest -> Finish(20);
}

if (isset($_POST['box1']) && $_POST['box1'] == 2) {
	$smarty -> assign("Start", "");	
	$quest -> Show('2');
	$smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Unik</a>)");	
}

if (isset($_POST['box2']) && $_POST['box2'] == 2) {
    $quest -> Show('1.2');
    $db -> Execute("UPDATE players SET fight=10 WHERE id=".$player -> id);
	$smarty -> assign( array("Link" => "<br /><br />(<a href=\"grid.php?step=quest\">Walcz</a>)", "Box" => ""));    
}

if ($test -> fields['action'] == '1.2') {
    $quest -> Battle('grid.php?step=quest');
   	$fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);            
	if ($fight -> fields['fight'] == 0) {
		$health = $db -> Execute("SELECT hp FROM players WHERE id=".$player -> id);
		if ($health -> fields['hp'] <= 0) {
			$quest -> Show('lostfight1');
			$quest -> Finish(30);
		} elseif ($_POST['action'] != 'escape') {
			$quest -> Show('winfight1');
			$smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Przeszukaj pomieszczenie</a>)");
		} elseif ($_POST['action'] == 'escape') {
			$quest -> Show('escape');
			$quest -> Finish(20);
		}
		$health -> Close();
	} 
	$fight -> Close();
}

if ($test -> fields['action'] == 'winfight1') {
	$chance = ($player -> inteli + rand(1,100));
	if ($chance > 200) {
		$quest -> Show('int2');
		$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'Smoczy stalowy miecz',50,'W',20000,0,300,25,300,1,'N',0,15,'N')") or error("nie moge dodac!");
	} else {
		$quest -> Show('int1');
	}
	$db -> Execute("UPDATE players SET credits=credits+100 WHERE id=".$player -> id);
	$smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Wroc</a>)");	
}

if ($test -> fields['action'] == 'int1' || $test -> fields['action'] == 'int2') {
	$quest -> Show('end1');
	$quest -> Finish(40);
}	

if ($test -> fields['action'] === '2') {
	$chance = ($player -> speed + rand(1,100));
	if ($chance < 200) {
		$quest -> Show('speed1');
		$db -> Execute("UPDATE players SET energy=energy-1 WHERE id=".$player -> id);
	} else {
		$quest -> Show('speed2');
		$quest -> Gainexp(10);
	}
	$smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)");		
}

if ($test -> fields['action'] == 'speed1' || $test -> fields['action'] == 'speed2' || $test -> fields['action'] == '2next') {
	$quest -> Show('2next');
	$quest -> Box(3);
}

if ((isset($_POST['box3']) && $_POST['box3'] == 3) || $test -> fields['action'] == '2.3') {
	$quest -> Show('2.3');
	$quest -> Finish(20);
}

if (isset($_POST['box3']) && $_POST['box3'] == 2) {
	$quest -> Show('2.2');
	$smarty -> assign( array("Answer" => "Y", "File" => "grid.php"));
}

if ($test -> fields['action'] == '2.2') {
	$chance = $quest -> Answer('2.2','','N');
	if ($chance == 1) {
		$quest -> Show('answer1');
		$quest -> Gainexp(30);
	    $smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Idz do drzwi</a>)");
    } else {
	    $quest -> Show('answer2');
        $db -> Execute("UPDATE players SET fight=18 WHERE id=".$player -> id);	    
	    $smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Walcz</a>)");
    }
}

if ($test -> fields['action'] == 'answer1') {
	$quest -> Show('door');
	$quest -> Box(4);	
}

if ($test -> fields['action'] == 'answer2') {
	$_POST['razy'] = 2;
    $quest -> Battle('grid.php?step=quest');
   	$fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);            
	if ($fight -> fields['fight'] == 0) {
		$health = $db -> Execute("SELECT hp FROM players WHERE id=".$player -> id);
		if ($health -> fields['hp'] <= 0) {
			$quest -> Show('lostfight2');
			$quest -> Finish(20);
		} elseif ($_POST['action'] != 'escape') {
			$quest -> Show('winfight2');
			$smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Idz do drzwi</a>)");
		} elseif ($_POST['action'] == 'escape') {
			$quest -> Show('escape');
			$quest -> Finish(20);
		}
		$health -> Close();
	} 
	$fight -> Close();
}

if (isset($_POST['box3']) && $_POST['box3'] == 1) {
	$quest -> Show('2.1');
	$smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Badaj drzwi</a>)");
}

if ($test -> fields['action'] == '2.1') {
	$chance = ($player -> inteli + rand(1,100));
	if ($chance > 200) {
		$quest -> Show('inteli3');
	    $smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Dalej</a>)");			
	} else {
		$quest -> Show('inteli4');
	    $_POST['razy'] = 2;
        $db -> Execute("UPDATE players SET fight=18 WHERE id=".$player -> id);	    		
	    $smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Walka</a>)");					
	}
}

if ($test -> fields['action'] == 'inteli4') {
	$_POST['razy'] = 2;	
    $quest -> Battle('grid.php?step=quest');
   	$fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);            
	if ($fight -> fields['fight'] == 0) {
		$health = $db -> Execute("SELECT hp FROM players WHERE id=".$player -> id);
		if ($health -> fields['hp'] <= 0) {
			$quest -> Show('lostfight2');
			$quest -> Finish(20);
		} elseif ($_POST['action'] != 'escape') {
			$quest -> Show('winfight2');
			$smarty -> assign("Link", "<br /><br />(<a href=\"grid.php?step=quest\">Idz do drzwi</a>)");
		} elseif ($_POST['action'] == 'escape') {
			$quest -> Show('escape');
			$quest -> Finish(20);
		}
		$health -> Close();
	} 
	$fight -> Close();
}

if ($test -> fields['action'] == 'inteli3' || $test -> fields['action'] == 'winfight2') {
	$quest -> Show('door');
	$quest -> Box(4);
}

if ((isset($_POST['box4']) && $_POST['box4'] == 2) || $test -> fields['action'] == 'door2') {
	$quest -> Show('door2');
	$quest -> Finish(30);
}

if ((isset($_POST['box4']) && $_POST['box4'] == 1) || $test -> fields['action'] == 'door1') {
	$quest -> Show('door1');
	$smarty -> assign( array("Answer" => "Y", "File" => "grid.php"));
	if (isset($_POST['box4']) && $_POST['box4'] == 1) {
	    $db -> Execute("UPDATE players SET temp=5 WHERE id=".$player -> id);
	    $_POST['box4'] = 0;
    }
}

if ($test -> fields['action'] == 'door1') {
	$chance = $quest -> Answer('door1','answer3','Y');
	$amount = $db -> Execute("SELECT temp FROM players WHERE id=".$player -> id);
	if ($chance != 1 && $amount -> fields['temp'] <= 0) {
		$smarty -> assign( array("Link" => '', "Box" => '', "Answer" => ""));
		$quest ->Show('end2');
		$quest -> Finish(40);
	}
	$amount -> Close();
	if ($chance == 1) {
		$smarty -> assign( array("Link" => '', "Box" => '', "Answer" => ""));
		$db -> Execute("UPDATE players SET temp=0 WHERE id=".$player -> id);
		$db -> Execute("UPDATE players SET maps=maps+1 WHERE id=".$player -> id);
		$quest ->Show('end3');
		$quest -> Finish(50);
	}
}

$test -> Close();

$smarty -> display('quest.tpl');
?>

