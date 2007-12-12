<?php
//@type: F
//@desc: Alchemik - sklep
/***************************************************************************
*                               msklep.php
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

$title = "Alchemik";
require_once("includes/head.php");

// if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta' && $player -> location != 'Iriaebor') {
// 	error ("Zapomnij o tym");
// }
checklocation($_SERVER['SCRIPT_NAME']);

if ($player -> przemiana > 0) {

error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 

}

//$maxmana = ($player -> inteli + $player -> wisdom);

if (!isset($_GET['buy'])) {
	$arm = $db -> Execute("SELECT * FROM mikstury WHERE gracz=0 AND status='S' ORDER BY moc ASC");
	$arritem = array();
	$i = 0;
	while (!$arm -> EOF) {
		$cena = $arm -> fields['cena'];
		if ($arm -> fields['typ'] == 'M') {
			$arritem[$i] = "<tr><td>".$arm -> fields['nazwa']."</td><td>mana: ".$arm -> fields['moc']." pkt</td><td>".$cena."</td><td>".$arm -> fields['amount']."</td><td>- <a href=msklep.php?buy=".$arm -> fields['id'].">Kup</a></td></tr>";
		}elseif( $arm -> fields['typ'] == 'Z') {
			$arritem[$i] = "<tr><td>".$arm -> fields['nazwa']."</td><td>zycie: ".$arm -> fields['moc']." pkt</td><td>".$cena."</td><td>".$arm -> fields['amount']."</td><td>- <a href=msklep.php?buy=".$arm -> fields['id'].">Kup</a></td></tr>";
		} else {
			$arritem[$i] = "<tr><td>".$arm -> fields['nazwa']."</td><td>".$arm -> fields['efekt']."</td><td>".$cena."</td><td>".$arm -> fields['amount']."</td><td>- <a href=msklep.php?buy=".$arm -> fields['id'].">Kup</a></td></tr>";
		}
		$arm -> MoveNext();
		$i = $i + 1;
	}
	$arm -> Close();
	$smarty -> assign ("Item", $arritem);
}

if (isset($_GET['buy'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
	error ("Zapomnij o tym!");
	}
	$name = $db -> Execute("SELECT nazwa FROM mikstury WHERE id=".$_GET['buy']);
	$smarty -> assign ( array("Id" => $_GET['buy'], "Name" => $name -> fields['nazwa']));
	$name -> Close();
	if (isset ($_GET['step']) && $_GET['step'] == 'buy'){
		$arm = $db -> Execute("SELECT * FROM mikstury WHERE id=".$_GET['buy']);
		if (!ereg("^[1-9][0-9]*$", $_GET['buy']) || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym!");
		}
		if ($_POST['amount'] > $arm -> fields['amount']) {
			error ("Nie ma tylu mikstur w sklepie!");
		}
		if (!$arm -> fields['id']) {
			error ("Nie ta mikstura. Wroc do <a href=msklep.php>sklepu</a>.");
		}
		if ($arm -> fields['status'] != 'S') {
			error ("Tutaj tego nie sprzedasz. Wroc do <a href=msklep.php>sklepu</a>.");
		}
		$cena = $arm -> fields['cena'];
		$cena = ($cena * $_POST['amount']);
		if ($cena > $player -> gold) {
			error ("Nie stac cie! Wroc do <a href=msklep.php>sklepu</a>.");
		}
		$toadd = array_shift( $arm -> GetArray() );
		$toadd['amount'] = $_POST['amount'];
		$player -> EquipAdd( $player -> TranslateFields( $toadd, 'potions' ), 'potions', 'mikstury' );
		//	$test = $db -> Execute("SELECT id FROM mikstury WHERE nazwa='".$arm -> fields['nazwa']."' AND gracz=".$player -> id." AND status='K'");
		//	if (!$test -> fields['id']) {
		//		$db -> Execute("INSERT INTO mikstury (nazwa, gracz, efekt, typ, moc, status, amount) VALUES('".$arm -> fields['nazwa']."',".$player -> id.",'".$arm -> fields['efekt']."','".$arm -> fields['typ']."',".$arm -> fields['moc'].",'K',".$_POST['amount'].")") or error ("Nie moge dodac");
		//	} else {
		//		$db -> Execute("UPDATE mikstury SET amount=amount+".$_POST['amount']." WHERE id=".$test -> fields['id']);
		//	}
		//$test -> Close();
		//$db -> Execute("UPDATE players SET credits=credits-".$cena." WHERE id=".$player -> id);
		$player -> gold -= $cena;
		$db -> Execute("UPDATE mikstury SET amount=amount-".$_POST['amount']." WHERE id=".$toadd['id']);
			error ("Zaplaciles <b>".$cena."</b> sztuk zlota, i kupiles za to ".$_POST['amount']." nowa(ych) <b>mikstur(e) ".$toadd['nazwa']."</b>. <a href=msklep.php>Wroc do sklepu</a>" ,'done');
	}
}

// inicjalizacja zmiennej
if (!isset($_GET['buy'])) {
	$_GET['buy'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ("Buy", $_GET['buy']);
$smarty -> display ('msklep.tpl');

require_once("includes/foot.php"); 
?>
