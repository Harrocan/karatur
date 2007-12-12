<?php
//@type: F
//@desc: Domy graczy
/**
 *   Funkcje pliku:
 *   Domy graczy
 *
 *   @name                 : house.php                            
 *   @copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 29.12.2004
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

$title = "Domy graczy";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Imnescar' && $player -> location != 'Iriaebor' && $player -> location != 'Asbravn') {
	error ("Nie masz prawa przebywac tutaj.");
}*/

$house = $db -> Execute("SELECT * FROM houses WHERE owner=".$player -> id." OR locator=".$player ->id);

// przypisanie zmiennych
$smarty -> assign(array("Message" => '', "Bedroomlink" => '', "Locatorlink" => '', "Buildbed" => '', "Buildwardrobe" => '', "Upgrade" => '', "Wardrobelink" => '', "Buildhouse" => ''));

//Zakup ziemi pod dom
if (isset ($_GET['action']) && $_GET['action'] == 'land') {
    if (!$house -> fields['id']) {
        $cost = "20 sztuk mithrilu";
    } else {
        $cost1 = $house -> fields['size'] * 1000;
        $cost = $cost1." sztuk zlota";
    }
    $smarty -> assign ("Cost", $cost);
    if (isset ($_GET['step']) && $_GET['step'] == 'buy') {
        if (!$house -> fields['id']) {
            if ($player -> mithril < 20) {
                error ("Nie masz tylu sztuk mithrilu!");
            }
            $db -> Execute("INSERT INTO houses (owner) VALUES(".$player -> id.")") or error ("Nie moge dodac ziemi!");
            //$db -> Execute("UPDATE players SET platinum=platinum-20 WHERE id=".$player -> id);
            $player -> mithril -= 20;
            error ("Kupiles ziemie pod dom. Teraz mozesz udac sie do <a href=house.php?action=build>warsztatu</a> aby zaczac budowac dom.");
        } else {
            if ($player -> gold < $cost1) {
                error ("Nie masz tylu sztuk zlota przy sobie!");
            }
            $db -> Execute("UPDATE houses SET size=size+1 WHERE id=".$house -> fields['id']);
            //$db -> Execute("UPDATE players SET credits=credits-".$cost1." WHERE id=".$player -> id);
            $player -> gold -= $cost1;
            error ("Kupiles kolejny obszar ziemi pod twoj dom. <a href=house.php>Wroc</a>");
        }
    }
}

//Warsztat budowlany
if(isset ($_GET['action']) && $_GET['action'] == 'build') {
    $smarty -> assign ("Points", $house -> fields['points']);
    if ($house -> fields['points'] == 0) {
        error ("Nie masz punktow budowlanych aby wykonywac jakiekolwiek czynnosci z domem! <a href=house.php>Wroc</a>");
    }
    if ($house -> fields['build'] == 0) {
        $smarty -> assign ("Buildhouse", "<a href=house.php?action=build&step=new>Wybudowac dom</a> - 10 punktow budowlanych - 1000 sztuk zlota<br>");
    } else {
        if ($house -> fields['build'] < $house -> fields['size'] && $house -> fields['points'] > 9) {
            $cost = 1000 * $house -> fields['build'];
            $smarty -> assign ("Buildhouse", "<a href=house.php?action=build&step=add>Rozbudowac dom</a> - 10 punktow budowlanych - ".$cost." sztuk zlota<br>");
        }
        if ($house -> fields['used'] < $house -> fields['build'] && $house -> fields['points'] > 9) {
            if ($house -> fields['bedroom'] == 'N') {
                $smarty -> assign ("Buildbed", "<a href=house.php?action=build&step=bedroom>Wybudowac sypialnie</a> - 10 punktow budowlanych - 10 000 sztuk zlota<br>");
            }
            $cost = $house -> fields['wardrobe'] * 1000;
            if ($cost == 0) {
                $cost = 1000;
            }
            $smarty -> assign ("Buildwardrobe", "<a href=house.php?action=build&step=wardrobe>Dostawic szafy na przedmioty</a> - 10 punktow budowlanych - ".$cost." sztuk zlota<br>");
        }
        if ($house -> fields['points'] > 0) {
            $smarty -> assign ("Upgrade", "<a href=house.php?action=build&step=upgrade>Upiekszanie domu</a><br>");
        }
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'new') {
        if (!$house -> fields['id']) {
            error ("Nie masz ziemi aby budowac dom!");
        }
        if ($house -> fields['build'] > 0) {
            error ("Masz juz zbudowany dom!");
        }
        if ($player -> gold < 1000) {
            error ("Nie masz tyle sztuk zlota przy sobie!");
        }
        if ($house -> fields['points'] < 10) {
            error ("Nie masz tyle punktow budowlanych!");
        }
        if (isset ($_GET['step2']) && $_GET['step2'] == 'make') {
            $_POST['name'] = strip_tags($_POST['name']);
            $db -> Execute("UPDATE houses SET name='".$_POST['name']."' WHERE id=".$house -> fields['id']);
            $db -> Execute("UPDATE houses SET build=build+1 WHERE id=".$house -> fields['id']);
            //$db -> Execute("UPDATE players SET credits=credits-1000 WHERE id=".$player -> id);
            $player -> gold -= 1000;
            $db -> Execute("UPDATE houses SET points=points-10 WHERE id=".$house -> fields['id']);
            error ("Wybudowales swoj pierwszy dom! <a href=house.php>Wroc</a>");
        }
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'add') {
        if (!$house -> fields['id']) {
            error ("Nie masz ziemi aby budowac dom!");
        }
        if ($house -> fields['size'] == $house -> fields['build']) {
            error ("Nie mozesz rozbudowac domu, poniewaz nie masz wolnej ziemi!");
        }
        $cost = 1000 * $house -> fields['build'];
        if ($player -> gold < $cost) {
            error ("Nie masz tyle sztuk zlota przy sobie!");
        }
        if ($house -> fields['points'] < 10) {
            error ("Nie masz tyle punktow budowlanych!");
        }
        $house -> fields['value'] = $house -> fields['value'] - 10;
        if ($house -> fields['value'] < 1) {
            $house -> fields['value'] = 1;
        }
        $db -> Execute("UPDATE houses SET build=build+1 WHERE id=".$house -> fields['id']);
        //$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
        $player -> gold -= $cost;
        $db -> Execute("UPDATE houses SET points=points-10 WHERE id=".$house -> fields['id']);
        $db -> Execute("UPDATE houses SET value=".$house -> fields['value']." WHERE id=".$house -> fields['id']);
        error ("Rozbudowales nieco swoj dom, ale stracil on nieco na wartosci. <a href=house.php>Wroc</a>");
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'bedroom') {
        if (!$house -> fields['id']) {
            error ("Nie masz domu aby budowac sypialnie!");
        }
        if ($house -> fields['used'] == $house -> fields['build']) {
            error ("Nie mozesz dokupywac nowych rzeczy do domu, poniewaz nie masz wolnego miejsca w nim!");
        }
        if ($house -> fields['bedroom'] == 'Y') {
            error ("Nie mozesz wybudowac sypialni poniewaz masz juz jedna!");
        }
        if ($player -> gold < 10000) {
            error ("Nie masz tyle sztuk zlota przy sobie!");
        }
        if ($house -> fields['points'] < 10) {
            error ("Nie masz tyle punktow budowlanych!");
        }
        $db -> Execute("UPDATE houses SET bedroom='Y' WHERE id=".$house -> fields['id']);
        //$db -> Execute("UPDATE players SET credits=credits-10000 WHERE id=".$player -> id);
        $player -> gold -= 1000;
        $db -> Execute("UPDATE houses SET points=points-10 WHERE id=".$house -> fields['id']);
        $db -> Execute("UPDATE houses SET used=used+1 WHERE id=".$house -> fields['id']);
        error ("Wybudowales sypialnie. <a href=house.php>Wroc</a>");
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'wardrobe') {
        if (!$house -> fields['id']) {
            error ("Nie masz domu aby wstawic do niego szafy!");
        }
        if ($house -> fields['used'] == $house -> fields['build']) {
            error ("Nie mozesz dokupywac nowych rzeczy do domu, poniewaz nie masz wolnego miejsca w nim!");
        }
        $cost = $house -> fields['wardrobe'] * 1000;
        if ($cost == 0) {
            $cost = 1000;
        }
        if ($player -> credits < $cost) {
            error ("Nie masz tyle sztuk zlota przy sobie!");
        }
        if ($house -> fields['points'] < 10) {
            error ("Nie masz tyle punktow budowlanych!");
        }
        $db -> Execute("UPDATE houses SET wardrobe=wardrobe+1 WHERE id=".$house -> fields['id']);
        //$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
        $player -> gold -= $cost;
        $db -> Execute("UPDATE houses SET points=points-10 WHERE id=".$house -> fields['id']);
        $db -> Execute("UPDATE houses SET used=used+1 WHERE id=".$house -> fields['id']);
        error ("Dostawiles nieco szaf do domu. <a href=house.php>Wroc</a>");
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'upgrade') {
        if (!$house -> fields['id']) {
            error ("Nie masz domu aby go upiekszac!");
        }
        if ($house -> fields['points'] < 1) {
            error ("Nie masz tyle punktow budowlanych!");
        }
        if (isset ($_GET['step2']) && $_GET['step2'] == 'make') {
            if (!ereg("^[1-9][0-9]*$", $_POST['points'])) {
                error ("Zapomnij o tym!");
            }
            if ($_POST['points'] > $house -> fields['points']) {
                error ("Nie masz tyle punktow budowlanych!");
            }
            $cost = 1000 * $_POST['points'];
            if ($player -> gold < $cost) {
                error ("Nie masz tyle sztuk zlota przy sobie!");
            }
            //$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
            $player -> gold -= $cost;
            $db -> Execute("UPDATE houses SET points=points-".$_POST['points']." WHERE id=".$house -> fields['id']);
            $db -> Execute("UPDATE houses SET value=value+".$_POST['points']." WHERE id=".$house -> fields['id']);
            error ("Zwiekszyles wartosc swojego domu. <a href=house.php>Wroc</a>");
        }
    }
}

//lista domow graczy
if (isset ($_GET['action']) && $_GET['action'] == 'list') {
    $houses = $db -> SelectLimit("SELECT * FROM houses WHERE build>0 AND owner>0 ORDER BY build DESC", 50);
    $arrid = array();
    $arrowner = array();
    $arrname = array();
    $arrbuild = array();
    $arrtype = array();
    $arrlocator = array();
    $i = 0;
    while (!$houses -> EOF) {
        $arrid[$i] = $houses -> fields['id'];
        $arrowner[$i] = $houses -> fields['owner'];
        $arrname[$i] = $houses -> fields['name'];
        $arrbuild[$i] = $houses -> fields['build'];
	if ($houses -> fields['locator']) {
	    $arrlocator[$i] = "<a href=\"view.php?view=".$houses -> fields['locator']."\">".$houses -> fields['locator']."</a>";
	} else {
	    $arrlocator[$i] = 'brak';
	}
        $arrtype[$i] = 'Rudera';
        if ($houses -> fields['value'] > 5 && $houses -> fields['build'] > 3) {
            $arrtype[$i] = 'Wiejska chata';
        }
        if ($houses -> fields['value'] > 20 && $houses -> fields['build'] > 5) {
            $arrtype[$i] = 'Kamienica';
        }
        if ($houses -> fields['value'] > 50 && $houses -> fields['build'] > 10) {
            $arrtype[$i] = 'Rezydencja';
        }
        if ($houses -> fields['value'] > 99 && $houses -> fields['build'] > 20) {
            $arrtype[$i] = 'Palac';
        }
	$houses -> MoveNext();
        $i = $i + 1;
    }
    $houses -> Close();
    $smarty -> assign ( array("Housesname" => $arrname, "Housesid" => $arrid, "Housesowner" => $arrowner, "Housesbuild" => $arrbuild, "Housestype" => $arrtype, "Locator" => $arrlocator));
}

// lista domow na sprzedaz
if (isset ($_GET['action']) && $_GET['action'] == 'rent') {
    $houses = $db -> Execute("SELECT * FROM houses WHERE owner=0 ORDER BY build DESC");
    $arrid = array();
    $arrname = array();
    $arrbuild = array();
    $arrtype = array();
    $arrlink = array();
    $arrcost = array();
    $arrseller = array();
    $i = 0;
    while (!$houses -> EOF) {
        $arrid[$i] = $houses -> fields['id'];
        $arrname[$i] = $houses -> fields['name'];
        $arrbuild[$i] = $houses -> fields['build'];
	$arrcost[$i] = $houses -> fields['cost'];
	$arrseller[$i] = $houses -> fields['seller'];
        $arrtype[$i] = 'Rudera';
        if ($houses -> fields['value'] > 5 && $houses -> fields['build'] > 3) {
            $arrtype[$i] = 'Wiejska chata';
        }
        if ($houses -> fields['value'] > 20 && $houses -> fields['build'] > 5) {
            $arrtype[$i] = 'Kamienica';
        }
        if ($houses -> fields['value'] > 50 && $houses -> fields['build'] > 10) {
            $arrtype[$i] = 'Rezydencja';
        }
        if ($houses -> fields['value'] > 99 && $houses -> fields['build'] > 20) {
            $arrtype[$i] = 'Palac';
        }
	if ($player -> id == $houses -> fields['seller']) {
	    $arrlink[$i] = "Twoja oferta";
	} elseif ($house -> fields['id']) {
	    $arrlink[$i] = "Brak";
	} else {
	    $arrlink[$i] = "<a href=\"house.php?action=rent&buy=".$houses -> fields['id']."\">Kup</a>";
	}
	$houses -> MoveNext();
        $i = $i + 1;
    }
    $houses -> Close();
    $smarty -> assign ( array("Housesname" => $arrname, "Housesid" => $arrid, "Housesseller" => $arrseller, "Housesbuild" => $arrbuild, "Housestype" => $arrtype, "Housescost" => $arrcost, "Houseslink" => $arrlink));
    if (isset($_GET['buy'])) {
		require_once('class/playerManager.class.php');
        if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
	    error ("Zapomnij o tym!");
		}
		if ($house -> fields['id']) {
			error("Nie mozesz kupic domu, poniewaz posiadasz juz jeden!");
		}
		$buy = $db -> Execute("SELECT id, owner, cost, seller FROM houses WHERE id=".$_GET['buy']);
		if (!$buy -> fields['id']) {
			error("Nie ma takiego domu!");
		}
		if ($buy -> fields['owner']) {
			error("Ten dom nie jest na sprzedaz!");
		}
		if ($player -> gold < $buy -> fields['cost']) {
			error("Nie masz tyle sztuk zlota przy sobie!");
		}
		//$db -> Execute("UPDATE players SET credits=credits-".$buy -> fields['cost']." WHERE id=".$player -> id);
		$player -> gold -= $buy -> fields['cost'];
		//$db -> Execute("UPDATE players SET bank=bank+".$buy -> fields['cost']." WHERE id=".$buy -> fields['seller']);
		$own = new playerManager( $buy -> fields['seller'] );
		$own -> addRes( 'bank', $buy -> fields['cost'] );
		//PutSignal( $buy -> fields['seller'], 'res' );
		$db -> Execute("UPDATE houses SET cost=0 WHERE id=".$buy -> fields['id']);
		$db -> Execute("UPDATE houses SET seller=0 WHERE id=".$buy -> fields['id']);
		$db -> Execute("UPDATE houses SET owner=".$player -> id." WHERE id=".$buy -> fields['id']);
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$buy -> fields['seller'].",'<b><a href=view.php?view=".$player -> id.">".$player -> user."</a></b> zaakceptowal twoja oferte za dom. Dostales <b>".$buy -> fields['cost']."</b> sztuk zlota do banku.','".$newdate."')") or error("Nie moge dodac do dziennika.");
		$smarty -> assign("Message", "<br />Kupiles dom.");
		$buy -> Close();
    }
}

// dom gracza
if (isset ($_GET['action']) && $_GET['action'] == 'my') {
    if (!isset ($_GET['step']) && !isset ($_GET['step2'])) {
        if (!$house -> fields['id']) {
            error ("Nie masz domu!");
        }
        $homename = 'Rudera';
        if ($house -> fields['value'] > 5 && $house -> fields['build'] > 3) {
            $homename = 'Wiejska chata';
        }
        if ($house -> fields['value'] > 20 && $house -> fields['build'] > 5) {
            $homename = 'Kamienica';
        }
        if ($house -> fields['value'] > 50 && $house -> fields['build'] > 10) {
            $homename = 'Rezydencja';
        }
        if ($house -> fields['value'] > 99 && $house -> fields['build'] > 20) {
            $homename = 'Palac';
        }
        if ($house -> fields['bedroom'] == 'Y') {
            $smarty -> assign ("Bedroom", "Tak");
        } else {
            $smarty -> assign ("Bedroom", "Nie");
        }
        $unused = $house -> fields['build'] - $house -> fields['used'];
        $amount = $db -> Execute("SELECT amount FROM equipment WHERE owner=".$player -> id." AND status='H'");
        $items = 0;
        while (!$amount -> EOF) {
            $items = $items + $amount -> fields['amount'];
	    $amount -> MoveNext();
        }
	$amount -> Close();
        $smarty -> assign ( array("Name" => $house -> fields['name'], "Size" => $house -> fields['size'], "Build" => $house -> fields['build'], "Value" => $house -> fields['value'], "Housename" => $homename, "Unused" => $unused, "Wardrobe" => $house -> fields['wardrobe'], "Items" => $items));
	if ($house -> fields['locator']) {
	    $smarty -> assign("Locator", "<a href=\"view.php?view=".$house -> fields['locator']."\">".$house -> fields['locator']."</a>");
	} else {
	    $smarty -> assign("Locator", "brak");
	}
        if ($house -> fields['bedroom'] == 'Y') {
            $smarty -> assign ("Bedroomlink", "- <a href=house.php?action=my&step=bedroom>Idz do sypialni</a><br>");
        }
        if ($house -> fields['wardrobe'] > 0) {
            $smarty -> assign ("Wardrobelink", "- <a href=house.php?action=my&step=wardrobe>Szafy z przedmiotami</a><br>");
        }
	if ($house -> fields['build'] > 3 && $player -> id == $house -> fields['owner']) {
	    $smarty -> assign("Locatorlink", "- <a href=\"house.php?action=my&step=locator\">Drugi mieszkaniec domu</a><br />");
	}
	if ($player -> id == $house -> fields['owner']) {
	    $smarty -> assign("Sellhouse", "- <a href=\"house.php?action=my&step=sell\">Wystaw dom na sprzedaz</a><br />");
	} else {
            $smarty -> assign("Sellhouse", '');
        }
    }
// Wystawianie domu na sprzedaz
    if (isset($_GET['step']) && $_GET['step'] == 'sell') {
        if ($player -> id != $house -> fields['owner']) {
	    error ("Tylko wlasciciel domu moze dodawac lub usuwac wspollokatorow!");
        }
	if (isset($_GET['step2']) && $_GET['step2'] == 'sell') {
	    if (!ereg("^[1-9][0-9]*$", $_POST['cost'])) {
	        error ("Zapomnij o tym!");
	    }
	    SqlExec("UPDATE houses SET cost=".$_POST['cost']." WHERE id=".$house -> fields['id']);
	    SqlExec("UPDATE houses SET seller=".$player -> id." WHERE id=".$house -> fields['id']);
	    SqlExec("UPDATE houses SET owner=0 WHERE id=".$house -> fields['id']);
	    SqlExec("UPDATE houses SET locator=0 WHERE id=".$house -> fields['id']);
	    $smarty -> assign("Message", "Wystawiles swoj dom na sprzedaz za ".$_POST['cost']." sztuk zlota");
	}
    } 
    if (isset($_GET['step']) && $_GET['step'] == 'locator') {
        if ($player -> id != $house -> fields['owner']) {
	    error ("Tylko wlasciciel domu moze dodawac lub usuwac wspollokatorow!");
	}
        $smarty -> assign("Locid", $house -> fields['locator']);
        if (isset($_GET['step2']) && $_GET['step2'] == 'change') {
	    if (!ereg("^[1-9][0-9]*$", $_POST['lid'])) {
	        error ("Zapomnij o tym!");
	    }
	    if ($_POST['loc'] == 'add') {
	        if ($house -> fields['locator']) {
		    error ("Masz juz wspollokatora");
		}
		$test = $db -> Execute("SELECT id FROM houses WHERE owner=".$_POST['lid']);
		if ($test -> fields['id']) {
		    error ("Ten gracz nie moze byc wspollokatorem poniewaz posiada wlasny dom");
		}
		$test = $db -> Execute("SELECT id FROM houses WHERE locator=".$_POST['lid']);
		if ($test -> fields['id']) {
		    error("Ten gracz mieszka juz w innym domu");
		}
		$test = $db -> Execute("SELECT id FROM players WHERE id=".$_POST['lid']);
		if (!$test -> fields['id']) {
		    error("Nie ma takiego gracza");
		}
		$test -> Close();
		$db -> Execute("UPDATE houses SET locator=".$_POST['lid']." WHERE id=".$house -> fields['id']);
		$smarty -> assign("Message", "Dodales wspollokatora do domu");
	    }
	    if ($_POST['loc'] == 'delete') {
	        if (!$house -> fields['locator']) {
		    error ("Nie masz wspollokatora!");
		}
		if ($_POST['lid'] != $house -> fields['locator']) {
		    error ("Ten gracz nie jest twoim wspollokatorem");
		}
		$db -> Execute("UPDATE houses SET locator=0 WHERE id=".$house -> fields['id']);
		$smarty -> assign("Message", "Usunales wspollokatora z domu");
	    }
	}
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'name') {
        if ($player -> id != $house -> fields['owner']) {
	    error ("Tylko wlasciciel domu moze zmieniac jego nazwe!");
	}
        if (isset ($_GET['step2']) && $_GET['step2'] == 'change') {
            if (empty ($_POST['name'])) {
                error ("Podaj nowa nazwe domu!");
            }
            $_POST['name'] = strip_tags($_POST['name']);
            $db -> Execute("UPDATE houses SET name='".$_POST['name']."' WHERE id=".$house -> fields['id']);
            error ("Zmieniles nazwe domu na: ".$_POST['name'].".");
        }
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'bedroom') {
        if ($house -> fields['bedroom'] == 'N') {
            error ("Nie mozesz odpoczywac poniewaz nie masz sypialni!");
        }
        $smarty -> assign ("Id", $player -> id);
        if (isset ($_GET['step2']) && $_GET['step2'] == 'rest') {
            if ($player -> hp == 0) {
                error ("<br /><br />Nie mozesz odpoczywac poniewaz jestes martwy!");
            }	
	    if ($player -> id == $house -> fields['owner']) {
                if ($house -> fields['rest'] == 'Y') {
                    error ("<br /><br />Mozesz odpoczywac tylko raz na reset!");
                }
		$db -> Execute("UPDATE houses SET rest='Y' WHERE id=".$house -> fields['id']);
	    } else {
	        if ($house -> fields['locrest'] == 'Y') {
		    error ("<br /><br />Mozesz odpoczywac tylko raz na reset!");
		}
		$db -> Execute("UPDATE houses SET locrest='Y' WHERE id=".$house -> fields['id']);
	    }
            $roll = rand(1,10);
            if ($roll > 5) {
                $gainenergy =  ceil(($player -> energy_max / 100) * $house -> fields['value']);
                $gainhp = ceil(($player -> hp_max / 100) * $house -> fields['value']);
                $cape = $db -> Execute("SELECT power FROM equipment WHERE owner=".$player -> id." AND type='Z' AND status='E'");
                $maxmana = ($player -> int + $player -> wis);
                $maxmana = $maxmana + (($cape -> fields['power'] / 100) * $maxmana);
		$cape -> Close();
                $gainmana = ceil(($maxmana / 100) * $house -> fields['value']);
                $gainlife = $gainhp + $player -> hp;
                if ($gainlife > $player -> max_hp) {
                    $gainlife = $player -> max_hp;
                }
                $gainmagic = $gainmana + $player -> mana;
                if ($gainmagic > $maxmana) {
                    $gainmagic = $maxmana;
                }
                if ($gainenergy > $player -> max_energy) {
                    $gainenergy = $player -> max_energy;
                }
                //$db -> Execute("UPDATE players SET hp=".$gainlife." WHERE id=".$player -> id);
                //$db -> Execute("UPDATE players SET energy=energy+".$gainenergy." WHERE id=".$player -> id);
                //$db -> Execute("UPDATE players SET pm=".$gainmagic." WHERE id=".$player -> id);
                $player -> SetArray( array( 'hp' => $gainlife, 'energy' => $player -> energy + $gainenergy, 'mana' => $gainmagic ) );
                error ("<br><br>Odpoczywales jakis czas i odzyskales ".$gainenergy." energii, ".$gainlife." punktow zycia oraz ".$gainmagic." punktow magii");
            } else {
                error ("<br><br>Probowales nieco odpoczac ale halas z ulicy przeszkadzal ci w tym. Niestety nie udalo ci sie odpoczac");
            }
        }
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'wardrobe') {
        if ($house -> fields['wardrobe'] == 0) {
            error ("Nie mozesz skladowac przedmiotow w domu, poniewaz nie masz szaf!");
        }
        $amount = $db -> Execute("SELECT amount FROM equipment WHERE owner=".$player -> id." AND status='H'");
        $items = 0;
        while (!$amount -> EOF) {
            $items = $items + $amount -> fields['amount'];
	    $amount -> MoveNext();
        }
	$amount -> Close();
        $smarty -> assign ("Amount", $items);
        $smarty -> assign ("Wardrobe", $house -> fields['wardrobe']);
        if(isset ($_GET['step2']) && $_GET['step2'] == 'list') {
            $arritem = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND status='H'");
            $arrname = array();
            $arrpower = array();
            $arrdur = array();
            $arrmaxdur = array();
            $arragility = array();
            $arrspeed = array();
            $arramount = array();
            $arrid = array();
            $i = 0;
            while (!$arritem -> EOF) {
                $arrname[$i] = $arritem -> fields['name'];
                $arrdur[$i] = $arritem -> fields['wt'];
                $arrmaxdur[$i] = $arritem -> fields['maxwt'];
                $arrspeed[$i] = $arritem -> fields['szyb'];
                $arramount[$i] = $arritem -> fields['amount'];
                $arrid[$i] = $arritem -> fields['id'];
                $arrpower[$i] = $arritem -> fields['power'];
                if ($arritem -> fields['zr'] < 1) {
	            $arragility[$i] = str_replace("-","",$arritem -> fields['zr']);
                } else {
                    $arragility[$i] = "-".$arritem -> fields['zr'];
                }
                if ($arritem -> fields['poison'] > 0) {
                    $arrpower[$i] = $arritem -> fields['power'] + $arritem -> fields['poison'];
                }
		$arritem -> MoveNext();
                $i = $i + 1;
            }
	    $arritem -> Close();
            $smarty -> assign ( array("Itemname" => $arrname, "Itemdur" => $arrdur, "Itemmaxdur" => $arrmaxdur, "Itemspeed" => $arrspeed, "Itemamount" => $arramount, "Itemid" => $arrid, "Itempower" => $arrpower, "Itemagility" => $arragility));
        }
        if (isset ($_GET['take'])) {
            if (!isset($_GET['step3'])) {
	        $name = $db -> Execute("SELECT * FROM equipment WHERE id=".$_GET['take']);
	        $smarty -> assign ( array("Id" => $_GET['take'], "Amount" => $name -> fields['amount'], "Name" => $name -> fields['name']));
		$name -> Close();
            }
            if (isset($_GET['step3']) && $_GET['step3'] == 'add') {
                if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	            error ("Zapomnij o tym<br>");
	        }
	        $zbroj = $db -> Execute("SELECT * FROM equipment WHERE id=".$_GET['take']);
	        if ($zbroj -> fields['amount'] < $_POST['amount']) {
	            error ("Nie masz tylu przedmiotow w szafach!");
	        }
                $test = $db -> Execute("SELECT id FROM equipment WHERE name='".$zbroj -> fields['name']."' AND owner=".$player -> id." AND wt=".$zbroj -> fields['wt']." AND type='".$zbroj -> fields['type']."' AND power=".$zbroj -> fields['power']." AND szyb=".$zbroj -> fields['szyb']." AND zr=".$zbroj -> fields['zr']." AND maxwt=".$zbroj -> fields['maxwt']." AND poison=".$zbroj -> fields['poison']." AND status='U'");
                if (!$test -> fields['id']) {
                    $db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$zbroj -> fields['name']."',".$zbroj -> fields['power'].",'".$zbroj -> fields['type']."',".$zbroj -> fields['cost'].",".$zbroj -> fields['zr'].",".$zbroj -> fields['wt'].",".$zbroj -> fields['minlev'].",".$zbroj -> fields['maxwt'].",".$_POST['amount'].",'".$zbroj -> fields['magic']."',".$zbroj -> fields['poison'].",".$zbroj -> fields['szyb'].",'".$zbroj -> fields['twohand']."')") or error("nie moge dodac!");
                } else {
                    $db -> Execute("UPDATE equipment SET amount=amount+".$_POST['amount']." WHERE id=".$test -> fields['id']);
                }
		$test -> Close();
                if ($_POST['amount'] < $zbroj -> fields['amount']) {
                    $db -> Execute("UPDATE equipment SET amount=amount-".$_POST['amount']." WHERE id=".$zbroj -> fields['id']);
                } else {
                    $db -> Execute("DELETE FROM equipment WHERE id=".$zbroj -> fields['id']);
                }
                PutSignal( $player -> id, 'back' );
	        error ("Wziales z domu ".$_POST['amount']." sztuk(i) ".$zbroj -> fields['name']);
            }
        }
        if (isset ($_GET['step2']) && $_GET['step2'] == 'add') {
            $arritem = $db -> Execute("SELECT * FROM equipment WHERE status='U' AND owner=".$player -> id);
            $arrname = array();
            $arramount = array();
            $arrid = array();
            $i = 0;
            while (!$arritem -> EOF) {
                $arrname[$i] = $arritem -> fields['name'];
                $arramount[$i] = $arritem -> fields['amount'];
                $arrid[$i] = $arritem -> fields['id'];
		$arritem -> MoveNext();
                $i = $i + 1;
            }
	    $arritem -> Close();
            $smarty -> assign ( array("Itemname1" => $arrname, "Itemamount1" => $arramount, "Itemid1" => $arrid));
            if (isset ($_GET['step3']) && $_GET['step3'] == 'add') {
                if (!isset($_POST['przedmiot'])) {
                    error("Podaj ktory przedmiot chcesz wziasc!");
                }
	        if (!ereg("^[1-9][0-9]*$", $_POST['przedmiot']) || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	            error ("Zapomnij o tym!");
	        }
	        $przed = $db -> Execute("SELECT * FROM equipment WHERE id=".$_POST['przedmiot']);
	        if (!$przed -> fields['id']) {
	            error ("Zapomnij o tym!");
	        }
                if ($przed -> fields['amount'] < $_POST['amount']) {
                    error ("Nie masz tyle przedmiotow tego typu w domu!");
                }
                $amount = ($house -> fields['wardrobe'] * 100) - $items;
                if ($amount < $_POST['amount']) {
                    error ("Nie masz tyle miejsca w szafach!");
                }
                $test = $db -> Execute("SELECT id FROM equipment WHERE name='".$przed -> fields['name']."' AND owner=".$player -> id." AND wt=".$przed -> fields['wt']." AND type='".$przed -> fields['type']."' AND power=".$przed -> fields['power']." AND szyb=".$przed -> fields['szyb']." AND zr=".$przed -> fields['zr']." AND maxwt=".$przed -> fields['maxwt']." AND poison=".$przed -> fields['poison']." AND status='H'");
                if (!$test -> fields['id']) {
                    $db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand, status) VALUES(".$player -> id.",'".$przed -> fields['name']."',".$przed -> fields['power'].",'".$przed -> fields['type']."',".$przed -> fields['cost'].",".$przed -> fields['zr'].",".$przed -> fields['wt'].",".$przed -> fields['minlev'].",".$przed -> fields['maxwt'].",".$_POST['amount'].",'".$przed -> fields['magic']."',".$przed -> fields['poison'].",".$przed -> fields['szyb'].",'".$przed -> fields['twohand']."','H')") or error("nie moge dodac!");
                } else {
                    $db -> Execute("UPDATE equipment SET amount=amount+".$_POST['amount']." WHERE id=".$test -> fields['id']);
                }
		$test -> Close();
                if ($_POST['amount'] < $przed -> fields['amount']) {
                    $db -> Execute("UPDATE equipment SET amount=amount-".$_POST['amount']." WHERE id=".$przed -> fields['id']);
                } else {
                    $db -> Execute("DELETE FROM equipment WHERE id=".$przed -> fields['id']);
                }
                PutSignal( $player -> id, 'back' );
	        error ("Schowales <b>".$_POST['amount']." sztuk(i) ".$przed -> fields['name']."</b> w domu.");
            }
        }
    }
}

// inicjalizacja zmiennych
if (!isset($_GET['action'])) {
    $_GET['action'] = '';
}
if (!isset($_GET['step'])) {
    $_GET['step'] = '';
}
if (!isset($_GET['step2'])) {
    $_GET['step2'] = '';
}
if (!isset($_GET['take'])) {
    $_GET['take'] = '';
}
if (!isset($_GET['step3'])) {
    $_GET['step3'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Action" => $_GET['action'], "Houseid" => $house -> fields['id'], "Step" => $_GET['step'], "Step2" => $_GET['step2'], "Take" => $_GET['take'], "Step3" => $_GET['step3'], "Owner" => $house -> fields['owner']));
$house -> Close();
$smarty -> display ('house.tpl');

require_once("includes/foot.php");
?>

