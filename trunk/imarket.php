<?php
//@type: F
//@desc: Rynek z przedmiotami
/**
*   Funkcje pliku:
*   Rynek z przedmiotami
*
*   @name                 : imarket.php
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : thindil <thindil@users.sourceforge.net>
*   @version              : 0.7 beta
*   @since                : 06.01.2005
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

$title = "Rynek z przedmiotami";
require_once("includes/head.php");
require_once('class/playerManager.class.php');

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta' && $player -> location != 'Imnescar' && $player -> location != 'Proskur' && $player -> location != 'Iriaebor' && $player -> location != 'Proskur') {
	error ("Zapomnij o tym");
}*/

// przypisanie zmiennej
$smarty -> assign(array("Message" => '', "Previous" => '', "Next" => ''));

if (isset ($_GET['view']) && $_GET['view'] == 'market') {
	if (empty($_POST['szukany'])) {
		$msel = $db -> Execute("SELECT id FROM equipment WHERE status='R'");
	} else {
		$search = strip_tags($_POST['szukany']);
		$msel = $db -> Execute("SELECT id FROM equipment WHERE status='R' AND CONCAT(prefix, ' ', name)='".$search."'");
	}
	$przed = $msel -> RecordCount();
	$msel -> Close();
	if ($przed == 0) {
		error ("Nie ma ofert na rynku! <a href=imarket.php>Wroc</a>");
	}
	if ($_GET['limit'] < $przed) {
		if (empty($_POST['szukany'])) {
			$pm = $db -> SelectLimit("SELECT e.*, p.user FROM equipment e JOIN players p ON p.id=e.owner WHERE e.status='R' ORDER BY e.".$_GET['lista']." DESC", 30, $_GET['limit']);
		} else {
			$pm = $db -> SelectLimit("SELECT e.*, p.user FROM equipment e JOIN players p ON p.id=e.owner WHERE e.status='R' AND CONCAT(e.prefix, ' ', e.name)='".$search."' ORDER BY e.".$_GET['lista']." DESC", 30, $_GET['limit']);
		}
		$arrname = array();
		$arrpower = array();
		$arrdur = array();
		$arrmaxdur = array();
		$arrspeed = array();
		$arragility = array();
		$arrcost = array();
		$arrowner = array();
		$arraction[] = array();
		$arramount = array();
		$arrlevel = array();
		$arrseller = array();
		$i = 0;
		while (!$pm -> EOF) {
				if ($pm -> fields['zr'] <= 0) {
					$pm -> fields['zr'] = str_replace("-","",$pm -> fields['zr']);
					$agility = "+".$pm -> fields['zr'];
				} elseif ($pm -> fields['zr'] > 0) {
					$agility = "-".$pm -> fields['zr'];
				}
				if ($pm -> fields['szyb'] > 0) {
					$speed = "+".$pm -> fields['szyb'];
				} else {
					$speed = 0;
				}
				$arrname[$i] = $pm -> fields['prefix']." ".$pm -> fields['name'];
				$arrpower[$i] = $pm -> fields['power'];
				$arrdur[$i] =  $pm -> fields['wt'];
				$arrmaxdur[$i] = $pm -> fields['maxwt'];
				$arrspeed[$i] = $speed;
				$arragility[$i] = $agility;
				$arrcost[$i] = $pm -> fields['cost'];
				$arrowner[$i] = $pm -> fields['owner'];
				$arramount[$i] = $pm -> fields['amount'];
			$arrlevel[$i] = $pm -> fields['minlev'];
			
			//$seller = $db -> Execute("SELECT user FROM players WHERE id=".$pm -> fields['owner']);
			//$arrseller[$i] = $seller -> fields['user'];
			$arrseller[$i] = $pm -> fields['user'];
			
			//$seller -> Close();
			if ($player -> id == $pm -> fields['owner']) {
				$arraction[$i][0] = "<td><a href='imarket.php?wyc={$pm -> fields['id']}'";
				$arraction[$i][1] ="><font color='darkblue'>";
				$arraction[$i][2]= "</font></a></td>";
			} else {
				$arraction[$i][0] = "<td><a href=imarket.php?buy={$pm -> fields['id']} ";
				$arraction[$i][1] =">";
				$arraction[$i][2] = "</a></td>";
			}
			$pm -> MoveNext();
			$i = $i + 1;
		}
		$pm -> Close();
		$smarty -> assign ( array("Name" => $arrname, "Power" => $arrpower, "Cost" => $arrcost, "Owner" => $arrowner, "Action" => $arraction, "Maxdur" => $arrmaxdur, "Durability" => $arrdur, "Speed" => $arrspeed, "Agility" => $arragility, "Amount" => $arramount, "Minlev" => $arrlevel, "Seller" => $arrseller));
		if (!isset($_POST['szukany'])) {
			$_POST['szukany'] = '';
		}
		if ($_GET['limit'] >= 30) {
			$lim = $_GET['limit'] - 30;
			$smarty -> assign ("Previous", "<form method=\"post\" action=\"imarket.php?view=market&limit=".$lim."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Poprzednie\"></form> ");
		}
		$_GET['limit'] = $_GET['limit'] + 30;
		if ($przed > 30 && $_GET['limit'] < $przed) {
			$smarty -> assign ("Next", " <form method=\"post\" action=\"imarket.php?view=market&limit=".$_GET['limit']."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Nastepne\"></form>");
		}
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'add') {
	$rzecz = $db -> Execute("SELECT id, name, amount FROM equipment WHERE status='U' AND owner=".$player -> id);
	$arrname = array();
	$arrid = array(0);
	$arramount = array();
	$i = 0;
	while (!$rzecz -> EOF) {
		$arrname[$i] = $rzecz -> fields['name'];
		$arrid[$i] = $rzecz -> fields['id'];
		$arramount[$i] = $rzecz -> fields['amount'];
	$rzecz -> MoveNext();
		$i = $i + 1;
	}
	$rzecz -> Close();
	if (!$arrid[0])
	{
		error("Nie masz przedmiotow na sprzedaz!");
	}
	$smarty -> assign ( array ("Name" => $arrname, "Itemid" => $arrid, "Amount" => $arramount));
	if (isset ($_GET['step']) && $_GET['step'] == 'add') {
		if (!isset($_POST['cost']))
		{
			error("Podaj cene");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['cost'])) {
			error ("Podaj cene");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['przedmiot']) || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym");
		}
		$query = $db -> Execute("SELECT id FROM equipment WHERE owner=".$player -> id." AND status='R'");
		$test = $query -> RecordCount();
		$query -> Close();
		if ($test > 4) {
			error ("Mozesz dac na rynku maksymalnie 5 ofert!");
		}
		$item = $player -> EquipSearch( array( 'id' => $_POST['przedmiot'] ) );
		if( empty( $item ) ) {
			error( "Nie masz takiego przedmiotu !" );
		}
		$key = key( $item );
		$item = $item[$key];
		if( $item['amount'] < $_POST['amount'] ) {
			error( "Nie masz tylu przedmiotow !" );
		}
		$left = $item['amount'] - $_POST['amount'];
		if( $left > 0 ) {
			if( $player -> SetEquip( 'backpack', $key, array( 'amount' => $left ) ) === FALSE )
				error( "BLad podczas przenoszenia przedmiotu !" );
		}
		else {
			if( $player -> EquipDelete( $item['id'] ) === FALSE )
				error( "Blad podczas przenoszenia przedmiotu !" );
		}
		$toadd = $item;
		unset( $toadd['id'] );
		unset( $toadd['img_file'] );
		$toadd['amount'] = $_POST['amount'];
		$toadd['status'] = 'R';
		$toadd['cost'] = $_POST['cost'];
		$sql = $player -> SqlCreate( "INSERT", 'equipment', $toadd );
		$insert = SqlExec( $sql );
		SqlExec( "INSERT INTO imarket_tmp(iid,basecost) VALUES($insert,{$item['cost']})" );
		error( "Dodales <b>".$_POST['amount']." sztuk ".$item['name']."</b> na rynku za <b>".$_POST['cost']."</b> sztuk zlota!",'done' );
		//$item = $db -> Execute("SELECT * FROM equipment WHERE id=".$_POST['przedmiot']) or error("Blad odczytu!");
		//if ($item -> fields['amount'] < $_POST['amount']) {
		//	error ("Nie masz tyle sztuk ".$item -> fields['name'].". <a href=\"imarket.php\">Wroc</a>");
		//}
		//$amount = $item -> fields['amount'] - $_POST['amount'];
		//if ($amount > 0) {
		//	$db -> Execute("UPDATE equipment SET amount=".$amount." where id=".$item -> fields['id']);
		//} else {
		//	$db -> Execute("DELETE FROM equipment WHERE id=".$item -> fields['id']);
		//}
		//$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, status, szyb, twohand) VALUES(".$player -> id.",'".$item -> fields['name']."',".$item -> fields['power'].",'".$item -> fields['type']."',".$_POST['cost'].",".$item -> fields['zr'].",".$item -> fields['wt'].",".$item -> fields['minlev'].",".$item -> fields['maxwt'].",".$_POST['amount'].",'".$item -> fields['magic']."',".$item -> fields['poison'].",'R',".$item -> fields['szyb'].",'".$item -> fields['twohand']."')") or error("nie moge dodac!");
		//$smarty -> assign("Message", "Dodales <b>".$_POST['amount']." sztuk ".$item -> fields['name']."</b> na rynku za <b>".$_POST['cost']."</b> sztuk zlota. <a href=\"imarket.php?view=add\">Odswiez</a>");
	}
}

if (isset($_GET['wyc'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['wyc'])) {
	error ("Zapomnij o tym.");
	}
	$dwyc = SqlExec("SELECT e.*, i.basecost FROM equipment e JOIN imarket_tmp i ON i.iid=e.id WHERE e.id={$_GET['wyc']} AND e.status='R'");
	if ($dwyc -> fields['owner'] != $player -> id) {
		error ("Nie mozesz wycofac cudzych ofert!");
	}
	$item = $dwyc -> GetArray();
	$item = $item[0];
	$item['cost'] = $item['basecost'];

	if( $player -> EquipAdd( $item ) === FALSE )
		error( "Blad przy wycofywaniu przedmiotu !" );
	//print_r( $item );
	//error( "" );
	//$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$dwyc -> fields['name']."' AND wt=".$dwyc -> fields['wt']." AND type='".$dwyc -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$dwyc -> fields['power']." AND zr=".$dwyc -> fields['zr']." AND szyb=".$dwyc -> fields['szyb']." AND maxwt=".$dwyc -> fields['maxwt']." AND poison=".$dwyc -> fields['poison']." AND cost=1");
	//if (!$test -> fields['id']) {
	//	$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$dwyc -> fields['name']."',".$dwyc -> fields['power'].",'".$dwyc -> fields['type']."',1,".$dwyc -> fields['zr'].",".$dwyc -> fields['wt'].",".$dwyc -> fields['minlev'].",".$dwyc -> fields['maxwt'].",".$dwyc -> fields['amount'].",'".$dwyc -> fields['magic']."',".$dwyc -> fields['poison'].",".$dwyc -> fields['szyb'].",'".$dwyc -> fields['twohand']."')") or error("nie moge dodac!");
	//} else {
	//	$db -> Execute("UPDATE equipment SET amount=amount+".$dwyc -> fields['amount']." WHERE id=".$test -> fields['id']);
	//}
	//$test -> Close();
	SqlExec("DELETE FROM equipment WHERE id=".$item['id']);
	SqlExec("DELETE FROM imarket_tmp WHERE iid=".$item['id']);
	$smarty -> assign("Message","Usunales swoja oferte i twoj przedmiot wrocil do ciebie. (<A href=imarket.php>wroc</a>)");
}

/**
* Usuwanie wlasnych przedmiotow z rynku
*/
if (isset ($_GET['view']) && $_GET['view'] == 'del') 
{
// 	$objArm = $db -> Execute("SELECT name FROM equipment WHERE owner=".$player -> id." AND status='R' GROUP BY name, power, zr, wt, szyb, maxwt, magic, poison");
// 	while (!$objArm -> EOF)
// 	{
// 		$objItem = $db -> Execute("SELECT * FROM equipment WHERE owner=".$player -> id." AND status='R' AND name='".$objArm -> fields['name']."'");
// 		while (!$objItem -> EOF)
// 		{
// 			$intTest = $db -> Execute("SELECT id FROM equipment WHERE name='".$objItem -> fields['name']."' AND wt=".$objItem -> fields['wt']." AND type='".$objItem -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$objItem -> fields['power']." AND zr=".$objItem -> fields['zr']." AND szyb=".$objItem -> fields['szyb']." AND maxwt=".$objItem -> fields['maxwt']." AND poison=".$objItem -> fields['poison']." AND cost=1");
// 			if (!$intTest -> fields['id'])
// 			{
// 				$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$objItem -> fields['name']."',".$objItem -> fields['power'].",'".$objItem -> fields['type']."',1,".$objItem -> fields['zr'].",".$objItem -> fields['wt'].",".$objItem -> fields['minlev'].",".$objItem -> fields['maxwt'].",".$objItem -> fields['amount'].",'".$objItem -> fields['magic']."',".$objItem -> fields['poison'].",".$objItem -> fields['szyb'].",'".$objItem -> fields['twohand']."')") or error("nie moge dodac!");
// 			}
// 				else
// 			{
// 				$db -> Execute("UPDATE equipment SET amount=amount+".$objItem -> fields['amount']." WHERE id=".$intTest -> fields['id']);
// 			}
// 			$intTest -> Close();
// 			$objItem -> MoveNext();
// 		}
// 		$objArm -> MoveNext();
// 	}
	$items = SqlExec( "SELECT e.*, i.basecost FROM equipment e JOIN imarket_tmp i ON i.iid=e.id WHERE e.owner={$player -> id} AND e.status='R'" );
	$items = $items -> GetArray();
	$iids = array();
	foreach( $items as $item ) {
		$item['cost'] = $item['basecost'];
		$iids[] = $item['id'];
		if( $player -> EquipAdd( $item ) === FALSE )
			error( "Blad przy wycofywaniu przedmiotu !" );
	}
	if( empty( $iids ) ) {
		error( "Nie masz zadnych ofert do wycofywania" );
	}
	SqlExec("DELETE FROM equipment WHERE status='R' AND owner=".$player -> id);
	SqlExec( "DELETE FROM imarket_tmp WHERE iid IN (".implode(",",$iids).")" );
	$smarty -> assign("Message","Usunales wszystkie swoje oferty i twoje przedmioty wrocily do ciebie. (<A href=imarket.php>wroc</a>)");
}

if (isset($_GET['buy'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
	error ("Zapomnij o tym.");
	}
	$buy = $db -> Execute("SELECT * FROM equipment WHERE id=".$_GET['buy']);
	if (!$buy -> fields['id']) {
	error ("Nie ma ofert. (<a href=imarket.php>wroc</a>)");
	}
	if ($buy -> fields['minlev'] > $player -> level) {
	error ("Twoj poziom jest za niski dla tej rzeczy! (<a href=imarket.php>Wroc</a>)");
	}
	if ($buy -> fields['owner'] == $player -> id) {
	error ("Nie mozesz kupic wlasnego przedmiotu! (<a href=imarket.php>wroc</a>)");
	}
	if ($buy -> fields['zr'] <= 0) {
		$buy -> fields['zr'] = str_replace("-","",$buy -> fields['zr']);
		$agility = "+".$buy -> fields['zr'];
	} elseif ($buy -> fields['zr'] > 0) {
		$agility = "-".$buy -> fields['zr'];
	}
	if ($buy -> fields['szyb'] > 0) {
		$speed = "+".$buy -> fields['szyb'];
	} else {
		$speed = 0;
	}
	$name = $buy -> fields['prefix']." ".$buy -> fields['name'];
	$seller = $db -> Execute("SELECT user FROM players WHERE id=".$buy -> fields['owner']);
	$smarty -> assign( array("Name" => $name, "Itemid" => $buy -> fields['id'], "Amount1" => $buy -> fields['amount'], "Cost" => $buy -> fields['cost'], "Seller" => $seller -> fields['user'], "Sid" => $buy -> fields['owner'], "Power" => $buy -> fields['power'], "Dur" => $buy -> fields['wt'], "MaxDur" => $buy -> fields['maxwt'], "Type" => $buy -> fields['type'], "Agi" => $agility, "Speed" => $speed));
	$buy -> Close();
	$seller -> Close();
	
	if (isset($_GET['step']) && $_GET['step'] == 'buy') {
		if (!isset($_POST['amount'])) {
			error("Podaj ile chcesz kupic!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym.");
		}
		$buy = SqlExec("SELECT e.*, i.basecost FROM equipment e JOIN imarket_tmp i ON i.iid=e.id WHERE e.id=".$_GET['buy']);
		if ($_POST['amount'] > $buy -> fields['amount']) {
			error("Nie ma tyle ".$buy -> fields['name']." na rynku. <a href=\"imarket.php\">Wroc</a>");
		}
		$price = $_POST['amount'] * $buy -> fields['cost'];
		if ($price > $player -> gold) {
			error ("Nie masz tyle sztuk zlota przy sobie. (<a href=imarket.php>wroc</a>)");
		}
		$item = $buy -> GetArray();
		$oryg = $item[0];
		$item = $item[0];
		$item['cost'] = $item['basecost'];
		$item['amount'] = $_POST['amount'];
		if( $player -> EquipAdd( $item ) === FALSE )
			error( "Blad podczas dodawania ekwipunku !" );
		//$sql="SELECT id FROM equipment WHERE name='".$buy -> fields['name']."' AND wt=".$buy -> fields['wt']." AND `type`='".$buy -> fields['type']."' AND `status`='U' AND owner=".$player -> id." AND power=".$buy -> fields['power']." AND zr=".$buy -> fields['zr']." AND szyb=".$buy -> fields['szyb']." AND maxwt=".$buy -> fields['maxwt']." AND poison=".$buy -> fields['poison']." AND cost=1";
		//error($sql);
		//$test = $db -> Execute($sql);
		//if (!$test -> fields['id']) {
		//	$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$buy -> fields['name']."',".$buy -> fields['power'].",'".$buy -> fields['type']."',1,".$buy -> fields['zr'].",".$buy -> fields['wt'].",".$buy -> fields['minlev'].",".$buy -> fields['maxwt'].",".$_POST['amount'].",'".$buy -> fields['magic']."',".$buy -> fields['poison'].",".$buy -> fields['szyb'].",'".$buy -> fields['twohand']."')") or error("nie moge dodac!");
		//} else {
		//	$db -> Execute("UPDATE equipment SET amount=amount+".$_POST['amount']." WHERE id=".$test -> fields['id']);
		//}
		//$test -> Close();
		if ($_POST['amount'] == $oryg['amount']) {
				SqlExec("DELETE FROM equipment WHERE id=".$oryg['id']);
				SqlExec( "DELETE FROM imarket_tmp WHERE iid=".$oryg['id'] );
		} else {
			$db -> Execute("UPDATE equipment SET amount=amount-".$_POST['amount']." WHERE id=".$item['id']);
		}
		//SqlExec("UPDATE resources SET bank=bank+".$price." WHERE id=".$item['owner']);
		//PutSignal( $item['owner'], 'res' );
		$own = new playerManager( $item['owner'] );
		$own -> addRes( 'bank', $price );
		//$db -> Execute("UPDATE players SET credits=credits-".$price." WHERE id=".$player -> id);
		$player -> gold -= $price;
		SqlExec("INSERT INTO log (owner, log, czas) VALUES(".$item['owner'].",'<b><a href=view.php?view=".$player -> id.">".$player -> user."</a></b> zaakceptowal twoja oferte za <b>".$_POST['amount']." sztuki ".$buy -> fields['name']."</b>. Dostales <b>".$price."</b> sztuk zlota do banku.','".$newdate."')");
		$smarty -> assign("Message", "<br />Kupiles <b>".$_POST['amount']." sztuk przedmiotu: ".$buy -> fields['name']."</b> za <b>".$price."</b> sztuk zlota.");
	}
}

//spis wszystkich ofert na rynku
if (isset($_GET['view']) && $_GET['view'] == 'all') {
	$oferts = SqlExec("SELECT CONCAT(prefix, ' ', name) AS title, COUNT(id) AS amount FROM equipment WHERE status='R' GROUP BY name, prefix");
	$arrname = array();
	$arramount = array();
	$i = 0;
	//print_r( $oferts -> GetArray() );
	while (!$oferts -> EOF) {
		$arrname[$i] = $oferts -> fields['title'];
		$arramount[$i] = $oferts -> fields['amount'];
		//$query = $db -> Execute("SELECT id FROM equipment WHERE status='R' AND name='".$arrname[$i]."'");
		//while (!$query -> EOF) {
		//	$arramount[$i] = $arramount[$i] + 1;
		//	$query -> MoveNext();
		//}
		//$query -> Close();
		$oferts -> MoveNext();
		$i = $i + 1;
	}
	$oferts -> Close();
	$smarty -> assign( array("Name" => $arrname, "Amount" => $arramount, "Message" => "<br />(<a href=\"imarket.php\">Wroc</a>)"));
}

//inicjalizacja zmiennych
if (!isset($_GET['view'])) {
	$_GET['view'] = '';
}
if (!isset($_GET['wyc'])) {
	$_GET['wyc'] = '';
}
if (!isset($_GET['buy'])) {
	$_GET['buy'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign( array("View" => $_GET['view'], "Remowe" => $_GET['wyc'], "Buy" => $_GET['buy']));
$smarty -> display ('imarket.tpl');

require_once("includes/foot.php"); 
?>

