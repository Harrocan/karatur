<?php
/**
 *   Funkcje pliku:
 *   walka turowa graczy z potworami
 *
 *   @name                 : turnfight.php                            
 *   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 10.01.2005
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

require_once("includes/functions.php");

// funkcja odpowiedzialna za walke gracza z potworami
function turnfight($expgain,$goldgain,$action,$addres) {
    global $player;
    global $smarty;
    global $db;
    global $title;
    global $title;
    global $enemy;
    global $myczaro;
    global $myarmor;
    global $myhelm;
    global $mylegs;
    global $myshield;
    global $mystaff;
    global $mycape;
    global $zmeczenie;
    global $myweapon;
    global $mybow;
    global $myarrows;
    global $myunik;
    global $amount;
    global $arrehp;
    global $myagility;
    $myweapon = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='W' AND owner=".$player -> id);
    $myarmor = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='A' AND owner=".$player -> id);
    $myhelm = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='H' AND owner=".$player -> id);
    $mylegs = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='N' AND owner=".$player -> id);
    $myshield = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='D' AND owner=".$player -> id);
    $myczaro = $db -> Execute("SELECT * FROM czary WHERE status='E' AND gracz=".$player -> id." AND typ='O'");
    $mybow = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='B' AND owner=".$player -> id);
    $myarrows = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='R' AND owner=".$player -> id);
    $mystaff = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='S' AND status='E'");
    $mycape = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='Z' AND status='E'");
    $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
    if ($fight -> fields['fight'] == 0 && $title = 'Arena Walk') {
        error ("Nie masz z kim walczyc!<a href=battle.php?action=monster>Odejdz</a>");
    }
    $fight -> Close();
    $premia = 0;
    $zmeczenie = 0;
    if (empty ($enemy['id'])) {
        //$location = $db -> Execute("SELECT miejsce FROM players WHERE id=".$player -> id);
        $location = $player -> location;
        if ($location -> fields['miejsce'] == 'Gory') {
            $arrmonsters = array(2,3,6,7,16,17,22,23);
            $rzut2 = rand(0,7);
	        $enemy1 = $db -> Execute("SELECT * FROM monsters WHERE id=".$arrmonsters[$rzut2]);
	        $enemy = array("strength" => $enemy1 -> fields['strength'], "agility" => $enemy1 -> fields['agility'], "speed" => $enemy1 -> fields['speed'], "endurance" => $enemy1 -> fields['endurance'], "hp" => $enemy1 -> fields['hp'], "name" => $enemy1 -> fields['name'], "exp1" => $enemy1 -> fields['exp1'], "exp2" => $enemy1 -> fields['exp2'], "level" => $enemy1 -> fields['level']);
	        $enemy1 -> Close();
        }
        if ($location -> fields['miejsce'] == 'Las') {
            $arrmonsters = array(1,4,11,13,14,19,22,28);
            $rzut2 = rand(0,7);
	        $enemy1 = $db -> Execute("SELECT * FROM monsters WHERE id=".$arrmonsters[$rzut2]);
	        $enemy = array("strength" => $enemy1 -> fields['strength'], "agility" => $enemy1 -> fields['agility'], "speed" => $enemy1 -> fields['speed'], "endurance" => $enemy1 -> fields['endurance'], "hp" => $enemy1 -> fields['hp'], "name" => $enemy1 -> fields['name'], "exp1" => $enemy1 -> fields['exp1'], "exp2" => $enemy1 -> fields['exp2'], "level" => $enemy1 -> fields['level']);
	        $enemy1 -> Close();
        }
    }
    if ($title == 'Arena Walk') {
	    if ($player -> clas == 'Wojownik' && $myczaro -> fields['id']) {
	        error ("Tylko mag moze walczyc uzywajac czarow obronnych! (<a href=\"battle.php?action=monster\">Wroc</a>)");
	    }
	    if ($player -> clas == 'Rzemieslnik' && $myczaro -> fields['id']) {
	        error ("Tylko mag moze walczyc uzywajac czarow obronnych! (<a href=\"battle.php?action=monster\">Wroc</a>)");
	    }
    }
    if ($myhelm -> fields['id']) {
        $premia = ($premia + $myhelm -> fields['power']);
    }
    if ($mylegs -> fields['id']) {
        $premia = ($premia + $mylegs -> fields['power']);
    }
    if ($myshield -> fields['id']) {
        $premia = ($premia + $myshield -> fields['power']);
    }
    if ($myarmor -> fields['id']) {
	    $premia - ($premia + $myarmor -> fields['power']);
    }
    if ($player -> clas == 'Wojownik'  || $player -> clas == 'Barbarzynca' || $player -> clas == 'Mnich') {
        $enemy['damage'] = ($enemy['strength'] - ($player -> level + $player -> cond + $premia));
	} else {
	    $enemy['damage'] = ($enemy['strength'] - ($player -> cond + $premia));
	}
    if ($myczaro -> fields['id']) {
        $myczarobr = ($player -> wisdom * $myczaro -> fields['obr']) - (($myczaro -> fields['obr'] * $player -> wisdom) * ($myarmor -> fields['minlev'] / 100));
        if ($myhelm -> fields['id']) {
	        $myczarobr = ($myczarobr - (($myczaro -> fields['obr'] * $player -> wisdom) * ($myhelm -> fields['minlev'] / 100)));
	    }
	    if ($mylegs -> fields['id']) {
	        $myczarobr = ($myczarobr - (($myczaro -> fields['obr'] * $player -> wisdom) * ($mylegs -> fields['minlev'] / 100)));
	    }
	    if ($myshield -> fields['id']) {
	        $myczarobr = ($myczarobr - (($myczaro -> fields['obr'] * $player -> wisdom) * ($myshield -> fields['minlev'] / 100)));
	    }
	    if ($mystaff -> fields['id']) {
	        $myczarobr = ($myczarobr + ($myczarobr * ($mystaff -> fields['power'] / 100)));
	    }
	    if ($myczarobr < 0) {
	        $myczarobr = 0;
	    }
	    $myobrona = ($myarmor -> fields['power'] + $myczarobr + $player -> cond + $premia);
	    $enemy['damage'] = ($enemy['strength'] - $myobrona);
    }
    if (!$myarmor -> fields['id'] && !$myczaro -> fields['id']) {
        $enemy['damage'] = ($enemy['strength'] - $player -> cond);
    }
    $gmagia = 0;
    $round = 1;
    $smarty -> assign ("Message", "<ul><li><b>".$player -> user."</b> przeciwko <b>".$enemy['name']."</b><br>");
    $smarty -> display ('error1.tpl');
    $myagility = checkagility($player -> agility,$myarmor -> fields['zr'],$mylegs -> fields['zr'],$myshield -> fields['zr']);
    $myspeed = checkspeed($player -> speed,$myarmor -> fields['zr'],$mylegs -> fields['zr'],$myweapon -> fields['szyb'],$mybow -> fields['szyb']);
    $points = ceil($myspeed / $enemy['speed']);
    if ($player -> clas == 'Wojownik' || $player -> clas == 'Barbarzynca' || $player -> clas == 'Mnich') {
        $myunik = (($myagility - $enemy['agility']) + $player -> level + $player -> miss);
	$eunik = (($enemy['agility'] - $myagility) - ($player -> attack + $player -> level));
    }
    if ($player -> clas == 'Rzemieslnik' || $player -> clas == 'Zlodziej' || $player -> clas == '') {
        $myunik = ($myagility - $enemy['agility'] + $player -> miss);
	$eunik = (($enemy['agility'] - $myagility) - $player -> attack);
    }
    if ($player -> clas == 'Mag' || $player -> clas == 'Kaplan' || $player -> clas == 'Druid') {
        $myunik = ($myagility - $enemy['agility'] + $player -> miss);
	$eunik = (($enemy['agility'] - $myagility) - ($player -> magic + $player -> level));
    }
    if (!isset($eunik)) {
        $eunit = 1;
    }
    if (!isset($myunik)) {
        $myunik = 1;
    }
    if ($myunik < 1) {
        $myunik = 1;
    }
    if ($eunik < 1) {
        $eunik = 1;
    }
    if (isset ($_POST['points'])) {
        $points = $_POST['points'];
    }
    if ($points > 5) {
        $points = 5;
    }
    if (isset ($_POST['round'])) {
        $round = $_POST['round'];
    }
    if (isset ($_POST['exhaust'])) {
        $zmeczenie = $_POST['exhaust'];
    }
    if (isset ($_POST['miss'])) {
        $myunik = $_POST['miss'];
    }
    $amount = 1;
    if (isset ($_POST['razy'])) {
        $amount = $_POST['razy'];
    }
    if (isset ($_POST['0'])) {
        $arrehp = array();
        $temp = 0;
        for ($k=0;$k<$amount;$k++) {
            $arrehp[$k] = $_POST[$k];
            if ($_POST[$k] > 0) {
                $temp = $temp + 1;
            }
        }
    }
    if (empty ($action)) {
        for ($i=0;$i<$amount;$i++) {
            $arrehp[$i] = $enemy['hp'];
        }
        $temp = 1;
        for ($l=0;$l<$amount;$l++) {
            $_POST[$l] = $enemy['hp'];
        }
    }
    $attacks = ceil($enemy['speed'] / $myspeed);
    if ($attacks > 5) {
        $attacks = 5;
    }
    if (!isset($_POST['action'])) {
        $_POST['action'] = '';
    }
    if ($_POST['action'] == 'drink' && $points > 0) {
        $points = $points - 1;
        drink ($_POST['potion']);
        if ($points >= $attacks) {
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if ($_POST['action'] == 'use' && $points > 0) {
        $points = $points - 1;
        equip ($_POST['arrows']);
        $myarrows = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='R' AND owner=".$player -> id);
        if ($points >= $attacks) {
            fightmenu($points,$zmeczenie,$round,$addres);
        }
        $myarrows -> Close();
    }
    if ($_POST['action'] == 'weapons' && $points > 0) {
        $points = $points - 2;
        if (!isset($_POST['weapon']))
        {
            $_POST['weapon'] = 0;
        }
        equip ($_POST['weapon']);
        $myweapon = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='W' AND owner=".$player -> id);
        if ($points >= $attacks) {
            fightmenu($points,$zmeczenie,$round,$addres);
        }
        $myweapon -> Close();
    }
    if ($_POST['action'] == 'escape') {
        $chance = (rand(1, $player -> level * 100) + $player -> speed - $enemy['agility']);
        if ($chance > 0) {
            $expgain = rand($enemy['exp1'],$enemy['exp2']);
            $expgain = (ceil($expgain / 100));
            $smarty -> assign ("Message", "Udalo ci sie uciec przed ".$enemy['name']."! Zdobywasz za to ".$expgain." PD<br></li></ul>");
            $smarty -> display ('error1.tpl');
            checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
            //$db -> Execute("UPDATE players SET fight=0 WHERE id=".$player -> id);
            $player -> fight = 0;
            $points = $attacks * 2;
            $temp = 1;
	    if ($title == "Arena Walk") {
	        $smarty -> assign ("Message", "</ul><ul><li><b>Opcje</b><br><a href=battle.php?action=monster>Odejdz</a><br></li></ul>");
                $smarty -> display ('error1.tpl');
	    }
        } else {
            $smarty -> assign ("Message", "<br>Nie udalo ci sie uciec przed ".$enemy['name']."!");
            $smarty -> display ('error1.tpl');
            monsterattack($attacks,$enemy,$myunik,$amount);
            if ($player -> hp > 0) {
                $round = $round + 1;
                $points = ceil($myspeed / $enemy['agility']);
                fightmenu($points,$zmeczenie,$round,$addres);
            }
        }
    }
    if($_POST['action'] == 'miss') {
        $myunik = $myunik * 2;
        monsterattack($attacks,$enemy,$myunik,$amount);
        if ($player -> hp > 0) {
            $round = $round + 1;
            $points = ceil($myspeed / $enemy['agility']);
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if ($_POST['action'] == 'cast' && $points > 0) {
        $points = $points - 1;
        if (!isset($_POST['castspell']))
        {
            $_POST['castspell'] = 0;
        }
        castspell($_POST['castspell'],0,$eunik);
        $temp = 0;
        for ($k=0;$k<$amount;$k++) {
            if ($_POST[$k] > 0) {
                $temp = $temp + 1;
            }
        }
        if ($temp > 0 && $attacks <= $points) {
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if ($_POST['action'] == 'bspell' && $points > 0) {
        if (!ereg("^[1-9][0-9]*$", $_POST['power'])) {
            error ("Zapomnij o tym!");
        }
        $points = $points - 2;
        castspell($_POST['bspellboost'],$_POST['power'],$eunik);
        $temp = 0;
        for ($k=0;$k<$amount;$k++) {
            if ($_POST[$k] > 0) {
                $temp = $temp + 1;
            }
        }
        if ($temp > 0 && $attacks <= $points) {
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if ($_POST['action'] == 'dspell') {
        if (!ereg("^[1-9][0-9]*$", $_POST['power1'])) {
            error ("Zapomnij o tym!");
        }
        $enemy['damage'] = $enemy['damage'] - $_POST['power1'];
        $player -> mana = $player -> mana - $_POST['power1'];
        monsterattack($attacks,$enemy,$myunik,$amount);
        if ($player -> hp > 0) {
            $round = $round + 1;
            $points = ceil($myspeed / $enemy['agility']);
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if ($_POST['action'] == 'nattack' && $points > 0) {
        attack($eunik,0);
        $temp = 0;
        for ($k=0;$k<$amount;$k++) {
            if ($_POST[$k] > 0) {
                $temp = $temp + 1;
            }
        }
        $points = $points - 1;
        if ($temp > 0 && $attacks <= $points) {
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if ($_POST['action'] == 'dattack' && $points > 0) {
        $points = $points - 1;
        attack($eunik,3);
        $temp = 0;
        for ($k=0;$k<$amount;$k++) {
            if ($_POST[$k] > 0) {
                $temp = $temp + 1;
            }
        }
        $myunik = $myunik + ($myunik / 2);
        if ($temp > 0 && $attacks <= $points) {
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if ($_POST['action'] == 'aattack' && $points > 0) {
        $points = $points - 1;
        attack($eunik,1);
        $temp = 0;
        for ($k=0;$k<$amount;$k++) {
            if ($_POST[$k] > 0) {
                $temp = $temp + 1;
            }
        }
        $myunik = $myunik / 2;
        if ($temp > 0 && $attacks <= $points) {
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if ($_POST['action'] == 'battack' && $points > 0) {
        $points = $points - 2;
        attack($eunik,2);
        $temp = 0;
        for ($k=0;$k<$amount;$k++) {
            if ($_POST[$k] > 0) {
                $temp = $temp + 1;
            }
        }
        $myunik = 0;
        if ($temp > 0 && $attacks <= $points) {
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if($attacks > $points && $temp > 0 && $_POST['action'] != 'rest' && $_POST['action'] != 'escape') {
        monsterattack($attacks,$enemy,$myunik,$amount);
        if ($player -> hp > 0) {
            $round = $round + 1;
            $points = ceil($myspeed / $enemy['agility']);
            if ($points > 5) {
                $points = 5;
            }
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if ($_POST['action'] == 'rest') {
        monsterattack($attacks,$enemy,0,$amount);
        if ($player -> hp > 0) {
            $smarty -> assign ("Message", "<br>Udalo ci sie nieco odpoczac");
            $smarty -> display ('error1.tpl');
            $rest = ($player -> cond / 10);
            $zmeczenie = $zmeczenie - $rest;
            if ($zmeczenie < 0) {
                $zmeczenie = 0;
            }
            $round = $round + 1;
            $points = ceil($myspeed / $enemy['agility']);
            if ($points > 5) {
                $points = 5;
            }
            fightmenu($points,$zmeczenie,$round,$addres);
        }
    }
    if ($player -> hp <= 0) {
        if ($title != 'Arena Walk') {
            loststat($player -> id,$player -> strength,$player -> agility,$player -> inteli,$player -> cond,$player -> speed,$player -> wisdom,0,$enemy['name'],0);
        }
        if ($player -> hp < 0) {
            $player -> hp = 0;
        }
        $db -> Execute("INSERT INTO events (text) VALUES('Gracz ".$player -> user." zostal pokonany przez ".$enemy['name']."')");
        //$db -> Execute("UPDATE players SET fight=0 WHERE id=".$player -> id);
        $player -> fight = 0;
        //$db -> Execute("UPDATE players SET hp=".$player -> hp." WHERE id=".$player -> id);
        
        if ($title == 'Arena Walk') {
            $smarty -> assign ("Message", "</ul>Oslepiajaca gwiadza bolu eksploduje w twojej glowie. Powoli padasz na kolana przed przeciwnikiem. Ostatkiem sil widzisz w zwolnionym tempie jak jego cios spada na twe cialo. Potem nastepuje juz tylko ciemnosc...<br><ul><li><b>Opcje</b><br><a href=battle.php?action=monster>Odejdz</a><br></li></ul>");
            $smarty -> display ('error1.tpl');
        }
    }
    if (!$_POST['action'] && $attacks <= $points) {
        fightmenu($points,$zmeczenie,1,$addres);
    }
    if ($temp == 0 && $player -> fight > 0) {
        $db -> Execute("INSERT INTO events (text) VALUES('Gracz ".$player -> user." pokonal ".$enemy['name']."')");
        //$db -> Execute("UPDATE players SET credits=credits+".$goldgain." WHERE id=".$player -> id);
        $player -> gold += $goldgain;
	    $smarty -> assign ("Message", "<br><li><b>Wynik:</b> Pokonales <b>".$_POST['razy']." ".$enemy['name']."</b>.");
	    $smarty -> display ('error1.tpl');
	    $smarty -> assign ("Message", "<li><b>Nagroda</b><br> Zdobyles <b>".$expgain."</b> PD oraz <b>".$goldgain."</b> sztuk zlota");
	    $smarty -> display ('error1.tpl');
	    checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
        if ($player -> hp < 0) {
            $player -> hp = 0;
        }
        if ($title == 'Arena Walk') {
            $smarty -> assign ("Message", "</ul><ul><li><b>Opcje</b><br><a href=battle.php?action=monster>Odejdz</a><br></li></ul>");
            $smarty -> display ('error1.tpl');
        }
        //$db -> Execute("UPDATE players SET hp=".$player -> hp." WHERE id=".$player -> id);
        //$db -> Execute("UPDATE players SET fight=0 WHERE id=".$player -> id);
        $player -> fight = 0;
    }
    if ($player -> location == 'Portal') {
        $db -> Execute("UPDATE market SET monsterhp=".$arrehp[0]);
    }
    $myarmor -> Close();
    $myhelm -> Close();
    $mylegs -> Close();
    $myshield -> Close();
    $mystaff -> Close();
    $mycape -> Close();
    $myczaro -> Close();
    $myweapon -> Close();
    $mybow -> Close();
    $myarrows -> Close();
}

//funkcja odpowiedzialna za atak bronia
function attack($eunik,$bdamage) {
    global $smarty;
    global $player;
    global $db;
    global $zmeczenie;
    global $enemy;
    global $amount;
    global $arrehp;
    global $myagility;
    $number = $_POST['monster'] - 1;
    $gwtbr = 0;
    $gatak = 0;
    if (isset ($_POST['exhaust'])) {
        $zmeczenie = $_POST['exhaust'];
    }
    $myweapon = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='W' AND owner=".$player -> id);
    $mybow = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='B' AND owner=".$player -> id);
    $myarrows = $db -> Execute("SELECT * FROM equipment WHERE status='E' AND type='R' AND owner=".$player -> id);
    if (!$myweapon -> fields['id'] && !$mybow -> fields['id']) {
        error ("Nie masz broni!");
    }
    if ($myweapon -> fields['id']) {
        if ($myweapon -> fields['poison'] > 0) {
            $myweapon -> fields['power'] = $myweapon -> fields['power'] + $myweapon -> fields['poison'];
        }
        if ($player -> clas == 'Wojownik' || $player -> clas == 'Barbarzynca' || $player -> clas == 'Mnich') {
	        $stat['damage'] = (($player -> strength + $myweapon -> fields['power']) + $player -> level);
	    } else {
	        $stat['damage'] = ($player -> strength + $myweapon -> fields['power']);
	    }
	    if ($player -> attack < 1) {
	        $krytyk = 1;
	    }
	    if ($player -> attack > 5) {
	        $kr = ceil($player -> attack / 100);
	        $krytyk = (5 + $kr);
	    } else {
	        $krytyk = $player -> attack;
	    }
	    $name = $myweapon -> fields['name'];
    }
    if ($mybow -> fields['id']) {
        $bonus = $mybow -> fields['power'] + $myarrows -> fields['power'];
        $bonus2 = (($player  -> strength / 2) + ($myagility / 2));
	    if ($player -> clas == 'Wojownik'  || $player -> clas == 'Barbarzynca') {
	        $stat['damage'] = (($bonus2 + $bonus) + $player -> level);
	    } else {
	        $stat['damage'] = ($bonus2 + $bonus);
	    }
	    if ($player -> shoot < 1) {
	        $krytyk = 1;
	    }
	    if ($player -> shoot > 5) {
	        $kr = ceil($player -> shoot / 100);
	        $krytyk = (5 + $kr);
	    } else {
	        $krytyk = $player -> shoot;
	    }
        if (!$myarrows -> fields['id']) {
            $stat['damage'] = 0;
        }
        $name = $mybow -> fields['name'];
    }
    if ($bdamage == 2) {
        $stat['damage'] = $stat['damage'] * 2;
    }
    if ($bdamage == 1) {
        $stat['damage'] = $stat['damage'] + ($stat['damage'] / 2);
        $eunik = $eunik - ($eunik / 10);
    }
    if ($bdamage == 3) {
        $stat['damage'] = $stat['damage'] - ($stat['damage'] / 2);
        $eunik = $eunik + ($eunik / 10);
    }
    $rzut2 = (rand(1,($player -> level * 10)));
    $stat['damage'] = ($stat['damage'] + $rzut2);
    $stat['damage'] = ($stat['damage'] - $enemy['endurance']);
    if ($stat['damage'] < 1) {
        $stat['damage'] =0 ;
    }
    if ($myweapon -> fields['id'] && $gwtbr > $myweapon -> fields['wt']) {
        $stat['damage'] = 0;
	    $krytyk = 1;
    }
    if ($mybow -> fields['id'] && ($gwtbr > $mybow -> fields['wt'] || $gwtbr > $myarrows -> fields['wt'])) {
        $stat['damage'] = 0;
        $krytyk = 1;
    }
    if ($mybow -> fields['id'] && !$myarrows -> fields['id']) {
        $stat['damage'] = 0;
        $krytyk = 1;
    }
    $ehp = $_POST[$number];
    if ($mybow -> fields['id']) {
        $eunik = $eunik * 2;
    }
    if ($ehp > 0 && $player -> hp > 0) {
        if ($myweapon -> fields['id']) {
            $zmeczenie = $zmeczenie + $myweapon -> fields['minlev'];
        } elseif ($mybow -> fields['id']) {
            $zmeczenie = $zmeczenie + $mybow -> fields['minlev'];
        }
        $szansa = rand(1,100);
 	    if ($eunik >= $szansa && $szansa < 95) {
            $smarty -> assign ("Message", "<b>".$enemy['name']."</b> uniknal twojego ciosu!<br>");
	        $smarty -> display ('error1.tpl');
	        if ($mybow -> fields['id']) {
	            $gwtbr = ($gwtbr + 1);
	        }
	    } elseif ($zmeczenie <= $player -> cond) {
	        if ($myweapon -> fields['id'] || $mybow -> fields['id']) {
	            $ehp = ($ehp - $stat['damage']);
	            $smarty -> assign ("Message", "Atakujesz przy pomocy ".$name." <b>".$enemy['name']."</b> i zadajesz <b>".$stat['damage']."</b> obrazen! (".$ehp." zostalo)</font><br>");
	            $smarty -> display ('error1.tpl');
	            $gwtbr = ($gwtbr + 1);
	            if ($stat['damage'] > 0) {
	                $gatak = ($gatak + 1);
	            }
	        }
        }
    }
    $_POST[$number] = $ehp;
    $arrehp = array();
    for ($k=0;$k<$amount;$k++) {
        $arrehp[$k] = $_POST[$k];
    }
    if ($myweapon -> fields['id']) {
        gainability($player -> id,$player -> user,0,$gatak,0,$player -> mana,$player -> id,'weapon');
        lostitem($gwtbr,$myweapon -> fields['wt'],'Twoja bron',$player -> id,$myweapon -> fields['id'],$player -> id,'ulega');
        if ($myweapon -> fields['poison'] > 0 && $gatak > 0) {
        	$item = $player -> GetEquipped( 'weapon' );
        	unset( $item['id'] );
        	unset( $item['owner'] );
        	unset( $item ['status'] );
        	$item['poison'] = 0;
        	$item['name'] = str_replace("Zatruty ","",$myweapon -> fields['name']);
        	$player -> SetEquip( 'equip', 'weapon', $item );
	        //$db -> Execute("UPDATE equipment SET poison=0 WHERE id=".$myweapon -> fields['id']);
	        //$myweapon -> fields['name'] = str_replace("Zatruty ","",$myweapon -> fields['name']);
	        //$db -> Execute("UPDATE equipment SET name='".$myweapon -> fields['name']."' WHERE id=".$myweapon -> fields['id']);
	    }
    }
    if ($mybow -> fields['id']) {
        gainability($player -> id,$player -> user,0,$gatak,0,$player -> mana,$player -> id,'bow');
        lostitem($gwtbr,$mybow -> fields['wt'],'Twoja bron',$player -> id,$mybow -> fields['id'],$player -> id,'ulega');
	    lostitem($gwtbr,$myarrows -> fields['wt'],'Twoj kolczan',$player -> id,$myarrows -> fields['id'],$player -> id,'ulega');
    }
    $_POST['exhaust'] = $zmeczenie;
    $myweapon -> Close();
    $mybow -> Close();
    $myarrows -> Close();
}
//funckja odpowiedzialna za atak czarem
function castspell ($id,$boost,$eunik) {
    global $smarty;
    global $player;
    global $db;
    global $myarmor;
    global $myshield;
    global $mylegs;
    global $myhelm;
    global $mystaff;
    global $mycape;
    global $enemy;
    global $amount;
    global $arrehp;
    $number = $_POST['monster'] - 1;
    $gmagia = 0;
    $mczar = $db -> Execute("SELECT * FROM czary WHERE id=".$id);
    if ($mczar -> fields['id']) {
        $stat['damage'] = ($mczar -> fields['obr'] * $player -> inteli) - (($mczar -> fields['obr'] * $player -> inteli) * ($myarmor -> fields['minlev'] / 100));
	    if ($myhelm -> fields['id']) {
	        $stat['damage'] = $stat['damage'] - ($stat['damage'] * ($myhelm -> fields['minlev'] / 100));
	    }
	    if ($mylegs -> fields['id']) {
	        $stat['damage'] = $stat['damage'] - ($stat['damage'] * ($mylegs -> fields['minlev'] / 100));
	    }
	    if ($myshield -> fields['id']) {
	        $stat['damage'] = $stat['damage'] - ($stat['damage'] * ($myshield -> fields['minlev'] / 100));
	    }
	    if ($mystaff -> fields['id']) {
	        $stat['damage'] = $stat['damage'] + ($stat['damage'] * ($mystaff -> fields['power'] / 100));
	    }
	    if ($stat['damage'] < 0) {
	        $stat['damage'] = 0;
	    }
	    if ($player -> magic < 1) {
	        $krytyk = 1;
	    }
	    if ($player -> magic > 5) {
	        $kr = ceil($player -> magic / 100);
	        $krytyk = (5 + $kr);
	    } else {
	        $krytyk = $player -> magic;
	    }
	    if ($boost) {
	        if ($boost > $player -> level) {
	            error ("Nie mozesz az tak wzmocnic czaru!");
	        }
	        $stat['damage'] = $stat['damage'] + $boost;
	    }
    }
    if (!$stat['damage'])
    {
        $stat['damage'] = 0;
    }
    $rzut2 = (rand(1,($player -> level * 10)));
    $stat['damage'] = ($stat['damage'] + $rzut2);
    $stat['damage'] = ($stat['damage'] - $enemy['endurance']);
    if ($stat['damage'] < 1) {
        $stat['damage'] = 0 ;
    }
    if ($player -> mana < $mczar -> fields['poziom']) {
         $stat['damage'] = 0;
    }
    $ehp = $_POST[$number];
    if ($ehp > 0) {
        $szansa = rand(1,100);
        if ($eunik >= $szansa && $szansa < 95) {
            $smarty -> assign ("Message", "<b>".$enemy['name']."</b> uniknal twojego ciosu!<br>");
	        $smarty -> display ('error1.tpl');
	    } else {
	        if ($mczar -> fields['id'] && $player -> mana > $mczar -> fields['poziom']) {
	            $pech = floor($player -> magic - $mczar -> fields['poziom']);
		        if ($pech > 0) {
		            $pech = 0;
		        }
		        $pech = ($pech + rand(1,100));
		        if ($pech > 5) {
		            $premia = 0;
		            if ($mystaff -> fields['id']) {
		                $premia = ceil($mystaff -> fields['minlev'] / 2);
		            }
		            if ($mycape -> fields['id']) {
		                $premia = ($premia + (ceil($mycape -> fields['minlev'] / 2)));
		            }
		            $lost_mana = ($premia + $mczar -> fields['poziom'] + $boost);
		            $player -> mana = ($player -> mana - $lost_mana);
		            $ehp = ($ehp - $stat['damage']);
	                $smarty -> assign ("Message", "Atakujesz <b>".$enemy['name']."</b> przy pomocy czaru ".$mczar -> fields['nazwa']." i zadajesz <b>".$stat['damage']."</b> obrazen! (".$ehp." zostalo)</font><br>");
		            $smarty -> display ('error1.tpl');
		            if ($stat['damage'] > 0) {
		                $gmagia = ($gmagia + 1);
		            }
		        } else {
		            $pechowy = rand(1,100);
		            if ($pechowy <= 70) {
			            $smarty -> assign ("Message", "<b>".$player -> user."</b> probowal rzucic czar ".$mczar -> fields['nazwa'].", ale niestety nie udalo mu sie opanowac mocy. Traci przez to <b>".$mczar -> fields['poziom']."</b> punktow magii.<br>");
			            $smarty -> display ('error1.tpl');
			            $player -> mana = ($player -> mana - $mczar -> fields['poziom']);
		            }
		            if ($pechowy > 70 && $pechowy <= 90) {
	                    $smarty -> assign ("Message", "<b>".$player -> user." probowal rzucic czar ".$mczar -> fields['nazwa'].", ale stracil panowanie nad swoja koncentracja. Traci przez to wszystkie punkty magii.<br>");
		                $smarty -> display ('error1.tpl');
			            $player -> mana = 0;
		            }
		            if ($pechowy > 90) {
		                $smarty -> assign ("Message", "<b>".$player -> user." stracil calkowicie panowanie nad czarem ".$mczar -> fields['nazwa']."! Czar wybuchl mu prosto w twarz! Traci przez to ".$stat['damage']." punktow zycia!<br>");
		                $smarty -> display ('error1.tpl');
		                $player -> hp = ($player -> hp - $stat['damage']);
		            }
                }
            }
        }
    }
    $_POST[$number] = $ehp;
    $arrehp = array();
    for ($k=0;$k<$amount;$k++) {
        $arrehp[$k] = $_POST[$k];
    }
    gainability($player -> id,$player -> user,0,0,$gmagia,$player -> mana,$player -> id,'');
    $mczar -> Close();
}

//funkcja odpowiedzalna za ataki potwora
function monsterattack($attacks,$enemy,$myunik,$amount) {
    global $smarty;
    global $player;
    global $db;
    global $enemy;
    global $myczaro;
    global $myarmor;
    global $myhelm;
    global $mylegs;
    global $myshield;
    global $mystaff;
    global $mycape;
    global $zmeczenie;
    global $number;
    if (isset ($_POST['exhaust'])) {
        $zmeczenie = $_POST['exhaust'];
    }
    $gunik = 0;
    $gwt = array(0,0,0,0);
    $temp = 0;
    for ($k=0;$k<$amount;$k++) {
        if ($_POST[$k] > 0) {
            $temp = $temp + 1;
        }
    }
    $amount = $temp;
    $armor = checkarmor($myarmor -> fields['id'],$myhelm -> fields['id'],$mylegs -> fields['id'],$myshield -> fields['id']);
    for ($j = 1;$j <= $amount;++$j) {
        $ename = $enemy['name']." nr".$j;
        for ($i = 1;$i <= $attacks; ++$i) {
            $rzut1 = (rand(1,($enemy['level'] * 10)));
            $enemy['damage'] = ($enemy['damage'] + $rzut1);
            if ($enemy['damage'] < 1) {
                $enemy['damage'] = 1;
            }
	    if ($player -> mana < $myczaro -> fields['poziom']) {
	        $enemy['damage'] = $enemy['strength'];
	    }
            if ($zmeczenie > $player -> cond) {
	            $enemy['damage'] = $enemy['strength'];
	        }
            if ($player -> hp > 0) {
                $szansa = rand(1,100);
	            if ($myunik >= $szansa && $zmeczenie < $player -> cond && $szansa < 95) {
                    $smarty -> assign ("Message", "<br>Uniknales ciosu <b>".$ename."</b>!");
                    $smarty -> display ('error1.tpl');
		            $gunik = ($gunik + 1);
		            $zmeczenie = ($zmeczenie + $myarmor -> fields['minlev']);
	            } else {
	                $player -> hp = ($player -> hp - $enemy['damage']);
	                //$db -> Execute("UPDATE players SET hp=".$player -> hp." WHERE id=".$player -> id);
                    $smarty -> assign ("Message", "<br><b>".$ename."</b> atakuje ciebie i zadaje <b>".$enemy['damage']."</b> obrazen! (".$player -> hp." zostalo)");
	                $smarty -> display ('error1.tpl');
	                if ($myarmor -> fields['id'] || $myhelm -> fields['id'] || $mylegs -> fields['id'] || $myshield -> fields['id']) {
	                    $efekt = rand(0,$number);
	                    if ($armor[$efekt] == 'torso') {
		                    $gwt[0] = ($gwt[0] + 1);
		                }
		                if ($armor[$efekt] == 'head') {
		                    $gwt[1] = ($gwt[1] + 1);
		                }
		                if ($armor[$efekt] == 'legs') {
		                    $gwt[2] = ($gwt[2] + 1);
		                }
		                if ($armor[$efekt] == 'shield') {
		                    $gwt[3] = ($gwt[3] + 1);
		                }
	                }
	                if ($myczaro -> fields['id']) {
	                    $premia = 0;
		                if ($mystaff -> fields['id']) {
		                    $premia = ceil($mystaff -> fields['minlev'] / 2);
		                }
		                if ($mycape -> fields['id']) {
		                    $premia = ($premia + (ceil($mycape -> fields['minlev'] / 2)));
		                }
		                $lost_mana = ($premia + $myczaro -> fields['poziom']);
	                    $player -> mana = ($player -> mana - $lost_mana);
	                }
	            }
            }
	    $enemy['damage'] = $enemy['damage'] - $rzut1;
        }
    }
    if ($myarmor -> fields['id']) {
        lostitem($gwt[0],$myarmor -> fields['wt'],'Twoja zbroja',$player -> id,$myarmor -> fields['id'],$player -> id,'ulega');
    }
    if ($myhelm -> fields['id']) {
        lostitem($gwt[1],$myhelm -> fields['wt'],'Twoj helm',$player -> id,$myhelm -> fields['id'],$player -> id,'ulega');
    }
    if ($mylegs -> fields['id']) {
	    lostitem($gwt[2],$mylegs -> fields['wt'],'Twoje nagolenniki',$player -> id,$mylegs -> fields['id'],$player -> id,'ulegaja');
    }
    if ($myshield -> fields['id']) {
	    lostitem($gwt[3],$myshield -> fields['wt'],'Twoja tarcza',$player -> id,$myshield -> fields['id'],$player -> id,'ulega');
    }
    gainability($player -> id,$player -> user,$gunik,0,0,$player -> mana,$player -> id,'');
    $_POST['exhaust'] = $zmeczenie;
}

// funkcja menu walki turowej
function fightmenu ($points,$exhaust,$round,$addres) {
    global $player;
    global $smarty;
    global $db;
    global $myunik;
    global $myweapon;
    global $mybow;
    global $myarrows;
    global $amount;
    global $enemy;
    global $arrehp;
    $smarty -> assign ("Round", $round);
    $smarty -> assign ("Points", $points);
    $smarty -> assign ("Mana", $player -> mana);
    $smarty -> assign ("HP", $player -> hp);
    $smarty -> assign ("Exhaust", $exhaust);
    $smarty -> assign ("Cond", $player -> cond);
    $smarty -> assign ("Adres", $addres);
    if ($myweapon -> fields['id'] || $mybow -> fields['id']) {
        $smarty -> assign ("Dattack", "<input type=radio name=action value=dattack> Defensywny atak (-50% obrazen, -10% trafienia, +50% obrony, +10% uniku)<br><br>");
        $smarty -> assign ("Nattack", "<input type=radio name=action value=nattack checked> Normalny atak (statystyki bez zmian)<br><br>");
        $smarty -> assign ("Aattack", "<input type=radio name=action value=aattack> Agresywny atak (+50% obrazen, +10% trafienia, -50% obrony, -10% uniku)<br><br>");
    } else {
        $smarty -> assign(array("Dattack" => '', "Nattack" => '', "Aattack" => ''));
    }
    $smarty -> display ('turnfight.tpl');
    if ($amount > 0) {
        $smarty -> assign ("Message","Atakuj potwora: <select name=monster>");
        $smarty -> display ('error1.tpl');
        for ($i=0;$i<$amount;$i++) {
            $number = $i + 1;
            if ($arrehp[$i] > 0) {
                $ename = $enemy['name']." nr ".$number;
                $smarty -> assign ("Message", "<option value=".$number.">".$ename." zycia: ".$arrehp[$i]."</option>");
                $smarty -> display ('error1.tpl');
            }
        }
        $smarty -> assign ("Message", "</select><br><br>");
        $smarty -> display ('error1.tpl');
    }
    if ($player -> clas == 'Mag') {
        $smarty -> assign ("Message", "<input type=radio name=action value=cast> Atak czarem <select name=castspell>");
        $smarty -> display ('error1.tpl');
        $arrspell = $db -> Execute("SELECT * FROM czary WHERE gracz=".$player -> id." AND typ='B'");
        while (!$arrspell -> EOF) {
            $smarty -> assign ("Message", "<option value=".$arrspell -> fields['id'].">".$arrspell -> fields['nazwa']." moc: ".$arrspell -> fields['obr']."</option>");
            $smarty -> display ('error1.tpl');
            $arrspell -> MoveNext();
        }
        $smarty -> assign ("Message", "</select><br><br>");
        $smarty -> display ('error1.tpl');
        $arrspell -> Close();
    }
    $arrpotion = $db -> Execute("SELECT * FROM mikstury WHERE gracz=".$player -> id." AND status='K' AND typ!='W' AND typ!='P'");
    if (!empty($arrpotion -> fields['id'])) {
        $smarty -> assign ("Message", "<input type=radio name=action value=drink> Wypij miksture <select name=potion>");
        $smarty -> display ('error1.tpl');
        while (!$arrpotion -> EOF) {
            $smarty -> assign ("Message", "<option value=".$arrpotion -> fields['id'].">".$arrpotion -> fields['nazwa']." moc: ".$arrpotion -> fields['moc']."% ilosc: ".$arrpotion -> fields['amount']."</option>");
            $smarty -> display ('error1.tpl');
            $arrpotion -> MoveNext();
        }
        $smarty -> assign ("Message", "</select><br><br>");
        $smarty -> display ('error1.tpl');
    }
    $arrpotion -> Close();
    if ($mybow -> fields['id']) {
        $arrarrows = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='R' AND status='U'");
        $smarty -> assign ("Message", "<input type=radio name=action value=use> Zaladowanie nowego kolczanu <select name=arrows>");
        $smarty -> display ('error1.tpl');
        while (!$arrarrows -> EOF) {
            $smarty -> assign ("Message", "<option value=".$arrarrows -> fields['id'].">".$arrarrows -> fields['name']." sila: ".$arrarrows -> fields['power']." ilosc: ".$arrarrows -> fields['wt']."</option>");
            $smarty -> display ('error1.tpl');
            $arrarrows -> MoveNext();
        }
        $arrarrows -> Close();
        $smarty -> assign ("Message", "</select><br><br>");
        $smarty -> display ('error1.tpl');
    }
    if ($points > 1) {
        $arrwep = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='W' AND status='U'");
        $smarty -> assign ("Message", "<input type=radio name=action value=weapons> Zmiana broni <select name=weapon>");
        $smarty -> display ('error1.tpl');
        while (!$arrwep -> EOF) {
            $smarty -> assign ("Message", "<option value=".$arrwep -> fields['id'].">".$arrwep -> fields['name']." moc: ".$arrwep -> fields['power']."</option>");
            $smarty -> display ('error1.tpl');
            $arrwep -> MoveNext();
        }
        $arrwep -> Close();
        $arrwep1 = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND type='B' AND status='U'");
        while (!$arrwep1 -> EOF) {
            $smarty -> assign ("Message", "<option value=".$arrwep1 -> fields['id'].">".$arrwep1 -> fields['name']." moc: ".$arrwep1 -> fields['power']."</option>");
            $smarty -> display ('error1.tpl');
            $arrwep1 -> MoveNext();
        }
        $arrwep1 -> Close();
        $smarty -> assign ("Message", "</select><br><br>");
        $smarty -> display ('error1.tpl');
        if (($player -> clas == 'Wojownik' || $player -> clas == 'Barbarzynca') && $myweapon -> fields['id']) {
            $smarty -> assign ("Message", "<input type=radio name=action value=battack> Szal bojowy (+100% obrazen, brak obrony)<br><br>");
            $smarty -> display ('error1.tpl');
        }
        if ($player -> clas == 'Mag' || $player -> clas == 'Kaplan' || $player -> clas == 'Druid') {
            $arrspell = $db -> Execute("SELECT * FROM czary WHERE gracz=".$player -> id." AND typ='B'");
            $smarty -> assign ("Message", "<input type=radio name=action value=bspell> Doladowanie czaru bojowego (doladuj czar o maks ".$player -> level." sily)<select name=bspellboost>");
            $smarty -> display ('error1.tpl');
            while (!$arrspell -> EOF) {
                $smarty -> assign ("Message", "<option value=".$arrspell -> fields['id'].">".$arrspell -> fields['nazwa']." moc: ".$arrspell -> fields['obr']."</option>");
                $smarty -> display ('error1.tpl');
                $arrspell -> MoveNext();
            }
            $arrspell -> Close();
            $smarty -> assign ("Message", "</select> <input type=text name=power size=5 value=0><br><br><input type=radio name=action value=dspell> Doladowanie czaru obronnego (doladuj czar o maks ".$player -> level." sily) <input type=text name=power1 size=5 value=0><br><br>");
            $smarty -> display ('error1.tpl');
        }
        if (($player -> clas == 'Wojownik' || $player -> clas == 'Barbarzynca')  && $exhaust < $player -> cond) {
            $smarty -> assign ("Message", "<input type=radio name=action value=miss> Uniki (zadnych wiecej akcji, uniki x 2)<br><br>");
            $smarty -> display ('error1.tpl');
        }
    }
    $rest = ($player -> cond / 10);
    for ($j=0;$j<$amount;$j++) {
        $smarty -> assign ("Message", "<input type=hidden name=".$j." value=".$arrehp[$j].">");
        $smarty -> display ('error1.tpl');
    }
    $smarty -> assign ("Rest", $rest);
    $smarty -> assign ("Myunik", $myunik);
    $smarty -> assign ("Amount", $amount);
    $smarty -> display ('turnfight1.tpl');
}


?>

