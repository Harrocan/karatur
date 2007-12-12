<?php
//@type: F
//@desc: Swiatynia Talosa
/***************************************************************************
 *                               temple.php
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

$title = "Swiatynia Wladcy Cieni";
require_once("includes/head.php");

if ($player -> location != 'Athkatla') {
	error ("Zapomnij o tym");
}

if ($player -> deity != 'Talos') {
 error ("Zapomnij o tym");
}


// inicjalizacja zmiennej
$smarty -> assign("Message", '');

// funkcja odpowiedzialna za modlitwe do danego boga
function pray($arrprayer,$amount,$pid,$deity,$arrpray) {
    global $smarty;
    global $player;
    global $db;
    $rzut1 = rand(0,$amount);
    if ($arrprayer[$rzut1] == 0) {
        if ($arrpray['hp'] < $arrpray['max_hp']) {
            $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. ".$deity." uzdrowil(a) ciebie.");
	    $db -> Execute("UPDATE players SET hp=max_hp WHERE id=".$pid);
	} else {
	    $smarty -> assign ("Message", $deity." wysluchal(a) twej modlitwy i cieszy sie z twej poboznosci, Dostajesz 5 Punktow Wiary");
	    $db -> Execute("UPDATE players SET pw=pw+5 WHERE id=".$pid);
	}
    }
    if ($arrprayer[$rzut1] == 1) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Poczules jak za sprawa ".$deity.", opuszcza ciebie nieco zmeczenia. Odzyskujesz 1 punkt energii.");
	$db -> Execute("UPDATE players SET energy=energy+1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 2) {
        $cape = $db -> Execute("SELECT power FROM equipment WHERE owner=".$pid." AND type='Z' AND status='E'");
	$maxmana = ($arrpray['inteli'] + $arrpray['wisdom']);
	$maxmana = $maxmana + (($cape -> fields['power'] / 100) * $maxmana);
	$cape -> Close();
	if ($arrpray['mana'] < $maxmana) {
	    $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Poczules jak wraca do ciebie magiczna energia. Odzyskales wszystkie Punkty Magii");
	    $db -> Execute("UPDATE players SET pm=".$maxmana." WHERE id=".$pid);
	} else {
	    $smarty -> assign ("Message", $deity." wysluchal(a) twej modlitwy i cieszy sie z twej poboznosci, Dostajesz 5 Punktow Wiary");
	    $db -> Execute("UPDATE players SET pw=pw+5 WHERE id=".$pid);
	}
    }
    if ($arrprayer[$rzut1] == 3) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Poczules nagle, ze twoja energia zyciowa wzrasta. Dostajesz 1 Punkt Zycia na stale.");
	$db -> Execute("UPDATE players SET max_hp=max_hp+1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 4) {
        $smarty -> assign ("Message", "Potezny grzmot rozlegl sie z oddali. ".$deity." rozgniewal(a) sie twoja zuchwaloscia. Nagle potezny blysk otoczyl twoja postac i padles nieprzytomny na ziemie.");
	$db -> Execute("UPDATE players SET hp=1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 5) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Poczules jak za sprawa ".$deity." twoja sila wzrasta. Dostajesz +1 do sily.");
	$db -> Execute("UPDATE players SET strength=strength+1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 6) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Poczules jak twa zrecznosc wzrasta. Dostajesz +1 do zrecznosci.");
	$db -> Execute("UPDATE players SET agility=agility+1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 7) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Poczules jak twoja madrosc wzrasta. Dostajesz +1 do inteligencji.");
	$db -> Execute("UPDATE players SET inteli=inteli+1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 8) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Poczules jak twoja sila duchowa wzrasta. Dostajesz +1 do sily woli.");
	$db -> Execute("UPDATE players SET wisdom=wisdom+1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 9) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Poczules jak twoja szybkosc wzrasta. Dostajesz +1 do szybkosci.");
	$db -> Execute("UPDATE players SET szyb=szyb+1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 10) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Poczules jak twoja wytrzymalosc wzrasta. Dostajesz +1 do wytrzymalosci.");
	$db -> Execute("UPDATE players SET wytrz=wytrz+1 WHERE id=".$pid);
	$db -> Execute("UPDATE players SET max_hp=max_hp+1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 11) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Obok ciebie pojawilo sie nagle 10 sztuk mithrilu. Szybko zabierasz ow dar.");
	$db -> Execute("UPDATE players SET platinum=platinum+10 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 12) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Obok ciebie pojawil sie mieszek a w nim 500 sztuk zlota.");
	$db -> Execute("UPDATE players SET credits=credits+500 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 13) {
        $text = "Twoja modlitwa zostala wysluchana. Nagle poczules, ze twoja wiedza na temat swiata Kara-Tur powieksza sie. Zyskujesz 10 PD.";
	require_once("includes/checkexp.php");
	checkexp($player -> exp,10,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
	$smarty -> assign ("Message", $text);
    }
    if ($arrprayer[$rzut1] == 14) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Twoja wiedza na temat walki bronia biala wzrasta");
	$db -> Execute("UPDATE players SET atak=atak+0.1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 15) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Twoja wiedza na temat walki bronia dystansowa wzrasta");
	$db -> Execute("UPDATE players SET shoot=shoot+0.1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 16) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Twoja wiedza na temat unikania ciosow wzrasta");
	$db -> Execute("UPDATE players SET unik=unik+0.1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 17) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Potrafisz teraz nieco lepiej kontrolowac swoje zaklecia");
	$db -> Execute("UPDATE players SET magia=magia+0.1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 18) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Twoja wiedza na temat wyrobow z drewna wzrasta");
	$db -> Execute("UPDATE players SET fletcher=fletcher+0.1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 19) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Twoja wiedza na temat warzenia mikstur wzrasta");
	$db -> Execute("UPDATE players SET alchemia=alchemia+0.1 WHERE id=".$pid);
    }
    if ($arrprayer[$rzut1] == 20) {
        $smarty -> assign ("Message", "Twoja modlitwa zostala wysluchana. Twoja wiedza na temat wytwarzania przedmiotow wzrasta");
	$db -> Execute("UPDATE players SET ability=ability+0.1 WHERE id=".$pid);
    }
}

if (isset ($_GET['temp']) && $_GET['temp'] == 'sluzba') {
    if (empty ($player -> deity)) {
        error ("Nie mozesz modlic sie w swiatyni poniewaz jestes ateista!");
    }
    if (isset($_GET['dalej'])) {
	if ($_POST['rep'] <= 0) {
	    error ("Wpisz ile czasu (energii) chcesz pracowac w swiatyni!");
	}
	if (!ereg("^[1-9][0-9]*$", $_POST['rep'])) {
	    error ("Zapomnij o tym");
	}
	if ($player -> hp == 0) {
	    error ("Nie mozesz pracowac dla swiatyni poniewaz jestes martwy!");
	}
	$razy = ($_POST['rep'] * 0.2);
	if ($player -> energy < $razy) {
	    error ("Nie masz tyle energii!");
	}
	$smarty -> assign ("Message", "Pracowales przez pewien czas dla swiatyni i zdobywasz ".$_POST['rep']." Punkt(ow) Wiary.");
	$db -> Execute("UPDATE players SET energy=energy-".$razy." WHERE id=".$player -> id);
	$db -> Execute("UPDATE players SET pw=pw+".$_POST['rep']." WHERE id=".$player -> id);
    }
}

if (isset ($_GET['temp']) && $_GET['temp'] == 'modlitwa') {
    if ($player -> hp == 0) {
	error ("Nie mozesz modlic sie, poniewaz jestes martwy!");
    }
    if (isset($_GET['modl'])) {
	if ($player -> pw < 1) {
 	    error ("Nie masz Punktow Wiary aby sie modlic!");
	}
	if (empty ($player -> deity)) {
	    error ("Nie mozesz sie modlic poniewaz jestes ateista!");
	}
	$pw1 = 0;
	$rzut = rand(1,100);
	$pw = $player -> pw;
	if ($pw < 21) {
		$pw1 = $pw;
	} elseif ($pw > 20 && $pw < 100) {
	    $pw1 = 20;
	} elseif ($pw >= 100) {
	    $pw1 = (20 + (ceil($pw / 100)));
	    if ($pw1 > 50) {
		    $pw1 = 50;
	    }
	}
	if ($rzut <= $pw1) {
            $arrtemp = array('race','inteli','wisdom','hp','max_hp','mana','user','level','exp');
            $arrtemple = $player -> stats($arrtemp);
	    if ($player -> deity == 'Bane') {
	        $arrtemp = array(0,1,2,3,4,5,10,13,14);
	        $amount = 9;
	    }

	    pray ($arrtemp,$amount,$player -> id,$player -> deity,$arrtemple);
	} else {
	    $smarty -> assign ("Message", "Modliles sie przez pewien czas, ale ".$player -> deity." zostal(a) gluchy(a) na twe prosby.");
	}
	$db -> Execute("UPDATE players SET pw=pw-1 WHERE id=".$player -> id);
    }
}

// inicjalizacja zmiennej
if (!isset($_GET['temp'])) {
    $_GET['temp'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign( array("Temple" => $_GET['temp'], "God" => $player -> deity));
$smarty -> display('talostemple.tpl');

require_once("includes/foot.php"); 
?>
