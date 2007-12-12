<?php
/***************************************************************************
 *                               steal.php
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


//funkcja odpowiedzialna za kradziez przedmiotow ze sklepow
function steal ($itemid) {
    global $player;
    global $smarty;
    global $title;
    global $newdata;
    global $db;
    
    if (!ereg("^[1-9][0-9]*$", $itemid)) {
        error ("Zapomnij o tym!");
    }
    if ($player -> hp <= 0) {
	    error ("Nie mozesz krasc poniewaz jestes martwy");
    }
    if ($player -> crime <= 0) {
        error ("Nie mozesz probowac okradac sklepu, poniewaz niedawno probowales juz swoich sil!");
    }
    $roll = rand (1, ($player -> level * 100));
    $chance = ($player -> agility + $player -> inteli) - $roll;
    if ($chance < 1) {
        $cost = 1000 * $player -> level;
        $expgain = ceil ($player -> level / 10);
        checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
        $db -> Execute("UPDATE players SET miejsce='Lochy' WHERE id=".$player -> id);
        $db -> Execute("UPDATE players SET crime=crime-1 WHERE id=".$player-> id);
        $db -> Execute("INSERT INTO jail (prisoner, verdict, duration, cost, data) VALUES(".$player -> id.",'Proba kradziezy przedmiotu ze sklepu w Altarze',1,".$cost.",'".$newdata."')") or error ("nie moge dodac wpisu!");
        $db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$player -> id.",'Zostales wtracony do wiezienia na 1 dzien za probe kradziezy ze sklepu. Mozesz wyjsc z wiezienia za kaucja: ".$cost.".','".$newdata."')");
        error ("Kiedy probowales zabrac upatrzony przedmiot, sprzedawca zauwazyl twoje manewry. Szybko zlapal ciebie za nadgarstek i wezwal straze. Obrot spraw tak ciebie zaskoczyl iz zapomniales nawet zareagowac w jakis sposob. I tak oto znalazles sie w lochach!");
    } else {
        if ($title != 'Fleczer') {
            $arritem = $db -> Execute("SELECT * FROM equipment WHERE id=".$itemid);
        } else {
            $arritem = $db -> Execute("SELECT * FROM bows WHERE id=".$itemid);
        }	    
        $db -> Execute("UPDATE players SET crime=crime-1 WHERE id=".$player -> id);
        $expgain = ($player -> level * 10); 
        checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
        if ($arritem -> fields['type'] == 'R') {
            $test = $db -> Execute("SELECT id FROM equipment WHERE name='".$arritem -> fields['name']."' AND owner=".$player -> id." AND status='U' AND cost=1");
            if (empty ($test -> fields['id'])) {
                $db -> Execute("INSERT INTO equipment (owner, name, power, cost, wt, szyb, minlev, maxwt, type) VALUES(".$player -> id.",'".$arritem -> fields['name']."',".$arritem -> fields['power'].",1,".$arritem -> fields['maxwt'].",".$arritem -> fields['szyb'].",".$arritem -> fields['minlev'].",".$arritem -> fields['maxwt'].",'".$arritem -> fields['type']."')") or error("Nie moge dodac broni.");
            } else {
                $db -> Execute("UPDATE equipment SET wt=wt+".$arritem -> fields['maxwt']." WHERE id=".$test -> fields['id']);
                $db -> Execute("UPDATE equipment SET maxwt=maxwt+".$arritem -> fields['maxwt']." where id=".$test -> fields['id']);
            }
            $test -> Close();
        } else {
            $test = $db -> Execute("SELECT id FROM equipment WHERE name='".$arritem -> fields['name']."' AND wt=".$arritem -> fields['maxwt']." AND type='".$arritem -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$arritem -> fields['power']." AND zr=".$arritem -> fields['zr']." AND szyb=".$arritem -> fields['szyb']." AND maxwt=".$arritem -> fields['maxwt']." and cost=1");
            if (empty ($test -> fields['id'])) {
                if ($arritem -> fields['type'] == 'B') {
                    $arritem -> fields['twohand'] = 'Y';
                }
                $db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, szyb, twohand) VALUES(".$player -> id.",'".$arritem -> fields['name']."',".$arritem -> fields['power'].",'".$arritem -> fields['type']."',1,".$arritem -> fields['zr'].",".$arritem -> fields['maxwt'].",".$arritem -> fields['minlev'].",".$arritem -> fields['maxwt'].",1,".$arritem -> fields['szyb'].",'".$arritem -> fields['twohand']."')") or error("nie moge dodac!");
            } else {
                $db -> Execute("UPDATE equipment SET amount=amount+1 WHERE id=".$test -> fields['id']);
            }
            $test -> Close();
        }
        error ("Udalo ci sie dyskretnie zabrac interesujacy ciebie przedmiot ze sklepu. Wyniosles z tamtad ".$arritem -> fields['name'].". Nie niepokojony przez nikogo odszedles sobie spokojnie w swoja strone. Kolejna udana robota!");
    }
}
?>

