<?php
//@type: F
//@desc: Wiesci
/**
 *   File functions:
 *   Show main news in game
 *
 *   @name                 : updates.php                            
 *   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 24.01.2005
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

$title = "Wiesci";
require_once("includes/head.php");
require_once("includes/bbcode.php");
/* if ($player -> rank == "Tester") {
$db -> Execute("UPDATE players SET age=0 where id=5");
$db -> Execute("UPDATE players SET user='Tester' where id=5");
$db -> Execute("UPDATE players SET opis='Testuje gre' where id=5");
$db -> Execute("UPDATE players SET level=1 where id=5");
$db -> Execute("UPDATE players SET exp=0 where id=5");
$db -> Execute("UPDATE players SET credits=3500 where id=5");
$db -> Execute("UPDATE players SET energy=60 where id=5");
$db -> Execute("UPDATE players SET max_energy=0 where id=5");
$db -> Execute("UPDATE players SET strength=3 where id=5");
$db -> Execute("UPDATE players SET agility=3 where id=5");
$db -> Execute("UPDATE players SET ap=35 where id=5");
$db -> Execute("UPDATE players SET platinum=75 where id=5");
$db -> Execute("UPDATE players SET hp=15 where id=5");
$db -> Execute("UPDATE players SET max_hp=15 where id=5");
$db -> Execute("UPDATE players SET bank=0 where id=5");
$db -> Execute("UPDATE players SET ability=0.01 where id=5");
$db -> Execute("UPDATE players SET tribe=0 where id=5");
$db -> Execute("UPDATE players SET profile='Prosze, nie zwracac uwagi na mnie! Jestem tu tylko tymczasowo w celu przetestowania gry. Jezeli spodoba mi sie ona, to zarejestruje sie!' where id=5");
$db -> Execute("UPDATE players SET refs=0 where id=5");
$db -> Execute("UPDATE players SET tribe=0 where id=5");
$db -> Execute("UPDATE players SET tribe=0 where id=5");
$db -> Execute("UPDATE players SET age=5");
$db -> Execute("UPDATE players SET rasa='' where id=5");
$db -> Execute("UPDATE players SET klasa='' where id=5");
$db -> Execute("UPDATE players SET ineteli=0 where id=5");
$db -> Execute("UPDATE players SET atak=0.01 where id=5");
$db -> Execute("UPDATE players SET unik=0.01 where id=5");
$db -> Execute("UPDATE players SET magia=0.01 where id=5");
$db -> Execute("UPDATE players SET szyb=3 where id=5");
$db -> Execute("UPDATE players SET wytrz=3 where id=5");
$db -> Execute("UPDATE players SET alchemia=0.01 where id=5");
$db -> Execute("UPDATE players SET shoot=0.01 where id=5");
$db -> Execute("UPDATE players SET fletcher=0.01 where id=5");
$db -> Execute("UPDATE players SET maps=0 where id=5");
$db -> Execute("UPDATE players SET gotowanie=0 where id=5");
$db -> Execute("UPDATE players SET stan='Wolny' where id=5");
}
*/

if (!isset ($_GET['view'])) {
	$upd = $db -> SelectLimit("SELECT * FROM updates ORDER BY id DESC", 3);
    $arrtitle = array();
    $arrstarter = array();
    $arrnews = array();
    $arrmodtext = array();
	$arrtimestamp = array();
	$reply=array();
	$topicid=array();
    $i = 0;    
    while (!$upd -> EOF) {
        if ($_SESSION['rank']['update'] == 1) {
            $arrmodtext[$i] = "(<a href=addupdate.php?modify=".$upd -> fields['id'].">Zmien</a>)";
        } else {
            $arrmodtext[$i] = '';
        }
        $arrtitle[$i] = $upd -> fields['title'];
        $arrstarter[$i] = $upd -> fields['starter'];
        $arrnews[$i] = bbcodetohtml( $upd -> fields['updates'] );
		$topicid[$i]=$upd->fields['topicid'];
		$reply[$i]=$db->Execute("SELECT id FROM forum_rep WHERE top_id=".$upd->fields['topicid']." AND cat_id=5;");
		$reply[$i]=$reply[$i]->RecordCount();
		if (isset($upd -> fields['time']))
		{
		    $arrtimestamp[$i] = " dnia <b>".$upd -> fields['time']."</b>";
		}
		    else
		{
		    $arrtimestamp[$i] = '';
		}
	    $upd -> MoveNext();
        $i = $i + 1;        
    }
    $upd -> Close();
   	$smarty -> assign ( array("Title1" => $arrtitle, "Starter" => $arrstarter, "Update" => $arrnews, "Modtext" => $arrmodtext, "Date" => $arrtimestamp,"Topicid"=>$topicid,"Reply"=>$reply));    
 /*$upd = $db -> SelectLimit("SELECT * FROM updates ORDER BY id DESC", 1);
    if ($player -> rank == 'Admin') {
        $modtext = "(<a href=addupdate.php?modify=".$upd -> fields['id'].">Zmien</a>)";
    } else {
        $modtext = '';
    }
	$reply=$db->Execute("SELECT * FROM replies WHERE topic_id=".$upd->fields['topicid'].";");
	$smarty -> assign ( array("Title1" => $upd -> fields['title'], "Starter" => $upd -> fields['starter'], "Update" => $upd -> fields['updates'], "Modtext" => $modtext, "Date" => " dnia ".$upd -> fields['time'],"Topicid"=>$upd->fields['topicid'],"Reply"=>$reply->RecordCount()));    */
} else {
    $upd = $db -> SelectLimit("SELECT * FROM updates ORDER BY id DESC", 10);
    $arrtitle = array();
    $arrstarter = array();
    $arrnews = array();
    $arrmodtext = array();
	$arrtimestamp = array();
    $i = 0;    
    while (!$upd -> EOF) {
        if ($_SESSION['rank']['update'] == 1) {
            $arrmodtext[$i] = "(<a href=addupdate.php?modify=".$upd -> fields['id'].">Zmien</a>)";
        } else {
            $arrmodtext[$i] = '';
        }
        $arrtitle[$i] = $upd -> fields['title'];
        $arrstarter[$i] = $upd -> fields['starter'];
        $arrnews[$i] = $upd -> fields['updates'];
		if (isset($upd -> fields['time']))
		{
		    $arrtimestamp[$i] = " dnia <b>".$upd -> fields['time']."</b>";
		}
		    else
		{
		    $arrtimestamp[$i] = '';
		}
	    $upd -> MoveNext();
        $i = $i + 1;        
    }
    $upd -> Close();
	$smarty -> assign ( array("Title1" => $arrtitle, "Starter" => $arrstarter, "Update" => $arrnews, "Modtext" => $arrmodtext, "Date" => $arrtimestamp));    
}
//inicjalizacja zmiennej
if (!isset($_GET['view'])) {
    $_GET['view'] = '';
}

//przypisanie zmiennej oraz wyswietlenie strony
$smarty -> assign ("View", $_GET['view']);
$smarty -> display ('updates.tpl');

require_once("includes/foot.php");
?>

