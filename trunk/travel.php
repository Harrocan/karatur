<?php
/**
 *   Funkcje pliku:
 *   Podroze do innych czesci swiata oraz przejscie do portalu
 *
 *   @name                 : travel.php                            
 *   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 26.01.2005
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

$title="Stajnie";
require_once("includes/head.php");
require_once ("includes/funkcje.php");
require_once("includes/turnfight.php");

error("WYㄐCZONE ! PRZEBUDOWA !",'error','city.php');

if ($player -> location == 'Lochy') {
	error("Zapomnij o tym! Jestes w wieznieniu!");
}

if ($player -> przemiana > 0) {

error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 

}

// przypisanie zmiennych
$smarty -> assign(array("Portal" => '', "Maps" => ''));

// funkcja odpowiedzialna za zdarzenia podczas podrozy
function travel ($address) {
    global $player;
    global $smarty;
    global $enemy;
    global $arrehp;
    global $db;
    global $energy;
    $roll = rand (1,100);
    $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
    if ($roll < 80 && $fight -> fields['fight'] == 0) {
        $smarty -> assign ("Message", "Podroz przebiegala spokojnie, po pewnym czasie widzisz przed soba cel swej podrozy.");
        $smarty -> display ('error1.tpl');
    } else {
        $smarty -> assign ("Message", "Podrozujac do celu wraz z karawana, nagle zobaczyles jak z pobocza drogi wyskakuja na was bandyci. Po chwili rozpoczyna sie walka. Jeden z bandytow biegnie wprost na ciebie. Szybko przygotowujesz sie do walki<br>");
        $smarty -> display ('error1.tpl');
        $arrbandit = array ();
        for ($i=0;$i<8;$i++) {
            $roll2 = rand (1,500);
            $arrbandit[$i] = $roll2;
        }
        $enemy = array ('name' => 'Bandyta', 'strength' => $arrbandit[0], 'agility' => $arrbandit[1], 'hp' => $arrbandit[2], 'level' => $arrbandit[3], 'endurance' => $arrbandit[6], 'speed' => $arrbandit[7]);
        $db -> Execute("UPDATE players SET fight=99999 WHERE id=".$player -> id);
        $arrehp = array ();
        if (!isset ($_POST['action'])) {
            turnfight ($arrbandit[4],$arrbandit[5],'',$address);
        } else {
            turnfight ($arrbandit[4],$arrbandit[5],$_POST['action'],$address);
        }
        if ($energy < 0) {
            $energy = 0;
        }
        $myhp = $db -> Execute("SELECT hp, fight FROM players WHERE id=".$player -> id);
        if ($myhp -> fields['hp'] == 0 && $myhp -> fields['fight'] == 0) {
            $db -> Execute("UPDATE players SET energy=enegry-1 WHERE id=".$player -> id);
            $db -> Execute("UPDATE players SET miejsce='Altara' WHERE id=".$player -> id);
            error ("Niestety tym razem przeznaczenie okazalo sie silniejsze od ciebie. Ostatnim obrazem jaki pamietasz, to spadajaca na twoja glowe szabla bandyty. Budzisz sie w szpitalu w Altarze. Kliknij <a href=hospital.php>tutaj</a>");
        }
        if ($myhp -> fields['fight'] == 0 && $myhp -> fields['hp'] > 0) {
            $db -> Execute("UPDATE players SET energy=energy-1 WHERE id=".$player -> id);
            $smarty -> assign ("Message", "Po pokonaniu przeciwnikow karawana ponownie wyrusza w droge. Tym razem przebiega ona bez niespodzianek.");
            $smarty -> display ('error1.tpl');
        }
	$myhp -> Close();
    }
    $fight -> Close();
}

$objItem = $db -> Execute("SELECT value FROM settings WHERE setting='item'");

if (!isset ($_GET['akcja']) && $player -> location == 'Altara' && $player -> location == 'Wir') {
    if ($player -> maps >= 20  &&  !$objItem -> fields['value'] && $player -> rank != 'Bohater') {
        $smarty -> assign("Maps", 1);
    }
}

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'tak' && $player -> location == 'Altara' && !$objItem -> fields['value'] && $player -> maps >= 20 && $player -> rank != 'Bohater' && $player -> location == 'Wir' && $player -> location != 'Dornland') {
    mysql_query ("update players set miejsce='Portal' where id=".$player -> id);
    $smarty -> assign("Portal", "Y");
}

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'nie' && $player -> location == 'Altara' && !$objItem -> fields['value']  && $player -> maps >= 20 && $player -> rank != 'Bohater' && $player -> location == 'Wir' && $player -> location != 'Dornland') {
    $smarty -> assign("Portal", "N");
}

$objItem -> Close();

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'gory') {
    if ($player->location!="Cormanthor" && $player->location!="Altara" && $player->location!="Dolina" && $player->location!="Dornland")
		error("Nieprawid這we miejsce podr騜y");
	$cost=1000;
    if ($player->location=="Cormanthor") {
	    $cost=600;
    }
    if ($player->location=="Altara") {
	    $cost=200;
    }
    if ($player->location=="Dornland") {
	    $cost=300;
    }
    if ($player->location=="Dolina") {
	    $cost=200;
    }
    if($player->credits<$cost)
    	error("Za ma這 pieni璠zy");
    $db -> Execute("UPDATE players SET miejsce='Podroz' WHERE id=".$player -> id);
    travel('travel.php?akcja=gory');
    $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
    if (!$fight -> fields['fight']) {
        $db -> Execute("UPDATE players SET miejsce='Gory' WHERE id=".$player -> id);
        $db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
        error ("Dotarles do Gor Kazad-nar. Wejdz <a href=gory.php>tutaj</a> aby zobaczyc co ciebie czeka.");
    }
}

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'Wir') {
    if ($player->location!="Cormanthor" && $player->location!="Las")
		error("Nieprawid這we miejsce podr騜y");
	$cost=1000;
    if ($player->location=="Cormanthor") {
	    $cost=200;
    }
    if ($player->location=="Las") {
	    $cost=200;
    }
    if($player->credits<$cost)
    	error("Za ma這 pieni璠zy");
    $db -> Execute("UPDATE players SET miejsce='Podroz' WHERE id=".$player -> id);
    travel('travel.php?akcja=Wir');
    $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
    if (!$fight -> fields['fight']) {
        $db -> Execute("UPDATE players SET miejsce='Wir' WHERE id=".$player -> id);
        $db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
        error ("Dotarles do Wiru. Wejdz <a href=Wir.php>tutaj</a> aby zobaczyc co ciebie czeka.");
    }
}
if (isset ($_GET['akcja']) && $_GET['akcja'] == 'dornland') {
    if ($player->location!="Gory")
		error("Nieprawid這we miejsce podr騜y");
	$cost=1000;
    if ($player->location=="Gory") {
	    $cost=300;
    }
    if($player->credits<$cost)
    	error("Za ma這 pieni璠zy");
    $db -> Execute("UPDATE players SET miejsce='Podroz' WHERE id=".$player -> id);
    travel('travel.php?akcja=gory');
    $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
    if (!$fight -> fields['fight']) {
        $db -> Execute("UPDATE players SET miejsce='Dornland' WHERE id=".$player -> id);
        $db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
        error ("Dotarles do Dornland. Wejdz <a href=dornland.php>tutaj</a> aby zobaczyc co ciebie czeka.");
    }
}
if (isset ($_GET['akcja']) && $_GET['akcja'] == 'Cormanthor') {
    if ($player->location!="Altara" && $player->location!="Las" && $player->location!="Gory")
		error("Nieprawid這we miejsce podr騜y");
	$cost=1000;
    if ($player->location=="Altara") {
	    $cost=800;
    }
    if ($player->location=="Las") {
	    $cost=600;
    }
    if ($player->location=="Gory") {
	    $cost=600;
    }
    if($player->credits<$cost)
    	error("Za ma這 pieni璠zy");
    $db -> Execute("UPDATE players SET miejsce='Podroz' WHERE id=".$player -> id);
    travel('travel.php?akcja=Wir');
    $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
    if (!$fight -> fields['fight']) {
        $db -> Execute("UPDATE players SET miejsce='Cormanthor' WHERE id=".$player -> id);
        $db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
        error ("Dotarles do Cormanthoru. Wejdz <a href=Cormanthor.php>tutaj</a> aby zobaczyc co ciebie czeka.");
    }
}

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'las') {
	if ($player->location!="Cormanthor" && $player->location!="Wir" && $player->location!="Altara")
		error("Nieprawid這we miejsce podr騜y");
	$cost=1000;
    if ($player->location=="Altara") {
	    $cost=100;
    }
    if ($player->location=="Wir") {
	    $cost=200;
    }
    if ($player->location=="Cormanthor") {
	    $cost=400;
    }
    if($player->credits<$cost)
    	error("Za ma這 pieni璠zy");
    $db -> Execute("UPDATE players SET miejsce='Podroz' WHERE id=".$player -> id);
    travel('travel.php?akcja=las');
    $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
    if (!$fight -> fields['fight']) {
        $db -> Execute("UPDATE players SET miejsce='Las' WHERE id=".$player -> id);
        $db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
        error ("Dotarles do Lasu Avantiel. Wejdz <a href=las.php>tutaj</a> aby zobaczyc co ciebie czeka.");
    }
}
if (isset ($_GET['akcja']) && $_GET['akcja'] == 'Wyspa Eothar') {
	if ($player->location!="Cormanthor" && $player->location!="Wir")
		error("Nieprawid這we miejsce podr騜y");
    if ($player->location=="Cormanthor" && $player -> credits <300 ) {
	    error ("Nie masz tyle pieniedzy!");
    }
    if ($player->location=="Wir" && $player -> credits <400 ) {
	    error ("Nie masz tyle pieniedzy!");
    }
    $db -> Execute("UPDATE players SET miejsce='Podroz' WHERE id=".$player -> id);
    travel('travel.php?akcja=island');
    $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
    if (!$fight -> fields['fight']) {
        $db -> Execute("UPDATE players SET miejsce='Wyspa Eothar' WHERE id=".$player -> id);
        $db -> Execute("UPDATE players SET credits=credits-1000 WHERE id=".$player -> id);
        error ("Dotarles do Wyspa Eothar. Wejdz <a href=las.php>tutaj</a> aby zobaczyc co ciebie czeka.");
    }
}
if (isset ($_GET['akcja']) && $_GET['akcja'] == 'dolina') {
    if ($player -> credits < 1000) {
	    error ("Nie masz tyle pieniedzy!");
    }
    $db -> Execute("UPDATE players SET miejsce='Podroz' WHERE id=".$player -> id);
    travel('travel.php?akcja=las');
    $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
    if (!$fight -> fields['fight']) {
        $db -> Execute("UPDATE players SET miejsce='Dolina' WHERE id=".$player -> id);
        $db -> Execute("UPDATE players SET credits=credits-1000 WHERE id=".$player -> id);
        error ("Dotarles do Doliny Mroku. Wejdz <a href=dolina.php>tutaj</a> aby zobaczyc co ciebie czeka.");
    }
}

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'powrot') {
    if ($player->location!="Cormanthor" && $player->location!="Las" && $player->location!="Dolina" && $player->location!="Gory" && $player->location!="Podroz")
		error("Nieprawid這we miejsce podr騜y");
	$cost=1000;
    if ($player->location=="Las") {
	    $cost=100;
    }
    if ($player->location=="Dolina") {
	    $cost=100;
    }
    if ($player->location=="Gory") {
	    $cost=200;
    }
    if ($player->location=="Cormanthor") {
	    $cost=800;
    }
    if ($player->location=="Podroz") {
	    $cost=500;
    }
    if($player->credits<$cost)
    	error("Za ma這 pieni璠zy");
    $db -> Execute("UPDATE players SET miejsce='Podroz' WHERE id=".$player -> id);
    travel('travel.php?akcja=powrot');
    $fight = $db -> Execute("SELECT fight FROM players WHERE id=".$player -> id);
    if (!$fight -> fields['fight']) {
        $db -> Execute("UPDATE players SET miejsce='Altara' WHERE id=".$player -> id);
        $db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
        error ("Dotarles do Altary. Wejdz <a href=city.php>tutaj</a> aby zobaczyc co ciebie czeka.");
    }
}

// inicjalizacja zmiennej
if (!isset($_GET['akcja'])) {
    $_GET['akcja'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Action" => $_GET['akcja'], "Location" => $player -> location));
$smarty -> display('travel.tpl');

require_once("includes/foot.php"); 
?>
