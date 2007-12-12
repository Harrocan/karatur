<?php
/***************************************************************************
 *                               log.php
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

$title = "Dziennik";
require_once("includes/head.php");

$db -> Execute("UPDATE log SET unread='T' WHERE unread='F' AND owner=".$player -> id);
$log = $db -> Execute("SELECT id FROM log WHERE owner=".$player -> id." ORDER BY id DESC");
$num = $log -> RecordCount();
$pages=array();
$i=1;
while($num > 0) {
    $pages[]=$i;
    $i++;
    $num-=15;
}
if(!empty($_GET['page']))
    $off=($_GET['page']-1)*10;
else
		$off=0;
$log = $db -> Execute("SELECT * FROM log WHERE owner=".$player -> id." ORDER BY id DESC LIMIT $off,10");
$arrdate = array();
$arrtext = array();
$arrid1 = array(0);
$i = 0;
while (!$log -> EOF) {
    $arrdate[$i] = $log -> fields['czas'];
    $arrtext[$i] = $log -> fields['log'];
    $arrid1[$i] = $log -> fields['id'];
    $log -> MoveNext();
    $i = $i + 1;
}
$log -> Close();

if (isset ($_GET['akcja']) && $_GET['akcja'] == 'wyczysc') {
    $db -> Execute("DELETE FROM log WHERE owner=".$player -> id);
    error ("<br>Dziennik wyczyszczony. (<a href=log.php>odswiez</a>)");
}

if (isset ($_GET['send'])) {
    $sid = $db -> Execute("SELECT id, user FROM players WHERE rank='Admin' OR rank='Staff' OR rank='Sedzia'");
    $arrname = array();
    $arrid = array();
    $i = 0;
    while (!$sid -> EOF) {
        $arrname[$i] = $sid -> fields['user'];
        $arrid[$i] = $sid -> fields['id'];
	$sid -> MoveNext();
        $i = $i + 1;
    }
    $sid -> Close();
    $smarty -> assign ( array("Name" => $arrname, "StaffId" => $arrid));
    if (isset ($_GET['step']) && $_GET['step'] == 'send') {
        if (!ereg("^[1-9][0-9]*$", $_POST['staff'])) {
            error ("Zapomnij o tym!");
        }
        if (!ereg("^[1-9][0-9]*$", $_POST['lid'])) {
            error ("Zapomnij o tym!");
        }
        $arrtest = $db -> Execute("SELECT id, user, rank FROM players WHERE id=".$_POST['staff']);
        if (!$arrtest -> fields['id']) {
            error ("Nie ma takiego gracza!");
        }
        if ($arrtest -> fields['rank'] != 'Admin' && $arrtest -> fields['rank'] != 'Staff' && $arrtest -> fields['rank'] != 'Sedzia') {
            error ("Ten gracz nie jest ani wladca ani ksieciem!");
        }
        $arrmessage = $db -> Execute("SELECT * FROM log WHERE id=".$_POST['lid']);
        if (!$arrmessage -> fields['id']) {
            error ("Nie ma takiego wpisu!");
        }
        if ($arrmessage -> fields['owner'] != $player -> id) {
            error ("To nie twoj wpis!");
        }
	$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$arrtest -> fields['id'].",'Gracz <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID:".$player -> id." wyslal ci fragment swojego dziennika na poczte.','".$newdate."')") or error("nie moge dodac do dziennika!");
	$db -> Execute("INSERT INTO mail (sender,senderid,owner,subject,body) values('".$player -> user."','".$player -> id."',".$arrtest -> fields['id'].",'Fragment dziennika','".$arrmessage -> fields['czas']."<br>".$arrmessage -> fields['log']."')") or error("Nie moge wyslac dziennika.");
	error ("Wyslales(as) wpis do ".$arrtest -> fields['user']."",'done','log.php');
    }
}

//inicjalizacja zmiennej
if (!isset($_GET['send'])) {
    $_GET['send'] = '';
}
if( !isset( $_GET['page'] ) )
	$_GET['page'] = '';
//przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Pages"=>$pages,"Page"=>$_GET['page'],"Date" => $arrdate, "Text" => $arrtext, "LogId" => $arrid1, "Send" => $_GET['send']));
$smarty -> display ('log.tpl');

require_once("includes/foot.php");
?>

