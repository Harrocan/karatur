<?php
//@type: F
//@desc: Sklepy mieszkañców
/**
*   Funkcje pliku:
*   Rynek z przedmiotami
*
*   @name                 : sklepy.php
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : visjusz <visjusz@o2.pl>
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

$title = "Sklepy mieszkañców";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

//if ($player -> location != 'Athkatla' && $player -> location != 'Nashkel' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Imnescar' && $player -> location != 'Iriaebor') {
//	error ("Zapomnij o tym");
//}

if ($player -> przemiana > 0) {
	error ("Musisz przemieniæ siê z Bestii w cz³owieka, by móc tutaj przebywaæ !");
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
if( !isset( $_GET['owner'] ) )
	$_GET['owner'] = '';




if (isset ($_GET['view']) && $_GET['view'] == 'market') {
	if (empty($_POST['szukany'])) {
		$msel = $db -> Execute("SELECT id FROM equipment WHERE status='Q' AND owner='".$_GET['owner']."'");
	} else {
		$_POST['szukany'] = strip_tags($_POST['szukany']);
		$msel = $db -> Execute("SELECT id FROM equipment WHERE status='Q' AND name='".$_POST['szukany']."' AND owner='".$_GET['owner']."'");
	}
	$przed = $msel -> RecordCount();
	$msel -> Close();
	if ($przed == 0) {
		error ("Nie ma jeszcze ofert w tym sklepie! <a href=sklepy.php>Wroc</a>");
	}
	
	$sklep = $db -> Execute("SELECT id,opis FROM sklepy WHERE owner=".$_GET['owner']);
	// przypisanie zmiennej
	$smarty -> assign("Opis", $sklep -> fields['opis']);


	if ($_GET['limit'] < $przed) {
		if (empty($_POST['szukany'])) {
			$pm = $db -> SelectLimit("SELECT * FROM equipment WHERE status='Q' AND owner='".$_GET['owner']."' ORDER BY ".$_GET['lista']." DESC", 30, $_GET['limit']);
		} else {
			$pm = $db -> SelectLimit("SELECT * FROM equipment WHERE status='Q' AND owner='".$_GET['owner']."' AND name='".$_POST['szukany']."' ORDER BY ".$_GET['lista']." DESC", 30, $_GET['limit']);
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
			$arrname[$i] = $pm -> fields['prefix'] ." ".$pm -> fields['name'];
			$arrpower[$i] = $pm -> fields['power'];
			$arrdur[$i] =  $pm -> fields['wt'];
			$arrmaxdur[$i] = $pm -> fields['maxwt'];
			$arrspeed[$i] = $speed;
			$arragility[$i] = $agility;
			$arrcost[$i] = $pm -> fields['cost'];
			$arrowner[$i] = $pm -> fields['owner'];
			$arramount[$i] = $pm -> fields['amount'];
			$arrlevel[$i] = $pm -> fields['minlev'];
			$seller = $db -> Execute("SELECT user FROM players WHERE id=".$pm -> fields['owner']);
			$arrseller[$i] = $seller -> fields['user'];
			$seller -> Close();
			if ($player -> id == $pm -> fields['owner']) {
				$arraction[$i][0] = "<td><a href='sklepy.php?wyc={$pm -> fields['id']}'";
				$arraction[$i][1] ="><font color='darkblue'>";
				$arraction[$i][2]= "</font></a></td>";
			} else {
				$arraction[$i][0] = "<td><a href=sklepy.php?buy={$pm -> fields['id']} ";
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
			$smarty -> assign ("Previous", "<form method=\"post\" action=\"sklepy.php?view=market&limit=".$lim."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Poprzednie\"></form> ");
		}
		$_GET['limit'] = $_GET['limit'] + 30;
		if ($przed > 30 && $_GET['limit'] < $przed) {
			$smarty -> assign ("Next", " <form method=\"post\" action=\"sklepy.php?view=market&limit=".$_GET['limit']."&lista=".$_GET['lista']."\"><input type=\"hidden\" name=\"szukany\" value=\"".$_POST['szukany']."\"><input type=\"submit\" value=\"Nastepne\"></form>");
		}
	}
}

if (isset ($_GET['view']) && $_GET['view'] == 'add') {
	$query = $db -> Execute("SELECT id FROM sklepy WHERE owner=".$player -> id);
	$test = $query -> RecordCount();
	$query -> Close();
	if ($test == 0) {
		error ("Nie posiadasz sklepu!");
	}
	
	$rzecz = $db -> Execute("SELECT id, CONCAT(prefix, ' ', name) AS name, amount FROM equipment WHERE status='U' AND owner=".$player -> id);
	$sklep = $db -> Execute("SELECT * FROM sklepy WHERE owner=".$player -> id);
	
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
	if (!$arrid[0]) {
		error("Nie masz przedmiotów na sprzeda¿!");
	}
	$smarty -> assign ( array ("Name" => $arrname, "Itemid" => $arrid, "Amount" => $arramount, "Opis" => $sklep -> fields['opis']));
	if (isset ($_GET['step']) && $_GET['step'] == 'add') {
		if (!isset($_POST['cost'])) {
			error("Podaj cenê");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['cost'])) {
			error ("Podaj cenê");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['przedmiot']) || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym");
		}
		$query = $db -> Execute("SELECT id FROM equipment WHERE owner=".$player -> id." AND status='Q'");
		$test = $query -> RecordCount();
		$query -> Close();

		$it = $player -> EquipSearch( array( 'id' => $_POST['przedmiot'] ) );
		$key = key ( $it ) ;
		$it = $it[$key];
		$item = $db -> Execute("SELECT * FROM equipment WHERE id=".$_POST['przedmiot']) or error("Blad odczytu!");
		if ($item -> fields['amount'] < $_POST['amount']) {
			error ("Nie masz tyle sztuk ".$item -> fields['name'].". <a href=\"sklepy.php\">Wroc</a>");
		}
		$amount = $item -> fields['amount'] - $_POST['amount'];
		if ($amount > 0) {
			$player -> SetEquip( 'backpack', $key, array( 'amount' => $amount ) );
			//$db -> Execute("UPDATE equipment SET amount=".$amount." where id=".$item -> fields['id']);
		} else {
			$player -> EquipDelete( $_POST['przedmiot'] );
			//$db -> Execute("DELETE FROM equipment WHERE id=".$item -> fields['id']);
		}
		$it['cost'] = $_POST['cost'];
		$it['amount'] = $_POST['amount'];
		$it['status'] = 'Q';
		unset( $it['img_file'] );
		unset( $it['id'] );
		$sql = $player->SqlCreate( 'INSERT', 'equipment', $it );
		$insert = SqlExec( $sql );
		//$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, status, szyb, twohand) VALUES(".$player -> id.",'".$item -> fields['name']."',".$item -> fields['power'].",'".$item -> fields['type']."',".$_POST['cost'].",".$item -> fields['zr'].",".$item -> fields['wt'].",".$item -> fields['minlev'].",".$item -> fields['maxwt'].",".$_POST['amount'].",'".$item -> fields['magic']."',".$item -> fields['poison'].",'Q',".$item -> fields['szyb'].",'".$item -> fields['twohand']."')") or error("nie moge dodac!");
		SqlExec( "INSERT INTO shop_user_tmp(iid, basecost) VALUES({$insert},{$item->fields['cost']})" );
		$smarty -> assign("Message", "Dodale <b>".$_POST['amount']." sztuk ".$item -> fields['name']."</b> do swojego sklepu za <b>".$_POST['cost']."</b> sztuk zlota. <a href=\"sklepy.php?view=add\">Odwiez</a>");
	}
} elseif ( !empty( $_GET['wyc'] ) ) {
	if (!ereg("^[1-9][0-9]*$", $_GET['wyc'])) {
		error ("Zapomnij o tym.");
	}
	$dwyc = SqlExec("SELECT e.*, s.basecost FROM equipment e JOIN shop_user_tmp s ON s.iid=e.id WHERE e.id=".$_GET['wyc']);
	//print_r( $dwyc );
	if ($dwyc -> fields['owner'] != $player -> id) {
		error ("Nie mozesz wycofac cudzych ofert!");
	}
	$item = $dwyc -> GetArray( );
	$item = array_shift( $item );
	$item['cost'] = $item['basecost'];
	$player->EquipAdd( $item );
	//$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$dwyc -> fields['name']."' AND wt=".$dwyc -> fields['wt']." AND type='".$dwyc -> fields['type']."' AND status='U' AND owner=".$player -> id." AND power=".$dwyc -> fields['power']." AND zr=".$dwyc -> fields['zr']." AND szyb=".$dwyc -> fields['szyb']." AND maxwt=".$dwyc -> fields['maxwt']." AND poison=".$dwyc -> fields['poison']." AND cost=1");
	//if (!$test -> fields['id']) {
	//	$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$dwyc -> fields['name']."',".$dwyc -> fields['power'].",'".$dwyc -> fields['type']."',1,".$dwyc -> fields['zr'].",".$dwyc -> fields['wt'].",".$dwyc -> fields['minlev'].",".$dwyc -> fields['maxwt'].",".$dwyc -> fields['amount'].",'".$dwyc -> fields['magic']."',".$dwyc -> fields['poison'].",".$dwyc -> fields['szyb'].",'".$dwyc -> fields['twohand']."')") or error("nie moge dodac!");
	//} else {
	//	$db -> Execute("UPDATE equipment SET amount=amount+".$dwyc -> fields['amount']." WHERE id=".$test -> fields['id']);
	//}
	//$test -> Close();
	SqlExec("DELETE FROM equipment WHERE id=".$item['id']);
	SqlExec( "DELETE FROM shop_user_tmp WHERE iid={$item['id']}" );
	error( "Usunale swoja oferte i twoj przedmiot wrocil do ciebie", 'done');
}
elseif (isset ($_GET['view']) && $_GET['view'] == 'del') {
	$db->Execute("INSERT INTO rep (kto, komu, co, ile,kiedy) VALUES ('".$player->id."', 0, 'sklep', 0, '".$newdate."')");
	$objArm = $db -> Execute("SELECT e.*, s.basecost FROM equipment e JOIN shop_user_tmp s ON s.iid=e.id WHERE e.owner=".$player -> id." AND e.status='Q'");
	$objArm = $objArm -> GetArray();
	if( empty( $objArm ) ) {
		error( "Nie masz zadnych przedmiotow w sklepie !");
	}
	$todel = array();
	foreach( $objArm as $item ) {
		$item['cost'] = $item['basecost'];
		$player -> EquipAdd( $item );
		$todel[] = $item['id'];
	}
	//while (!$objArm -> EOF) {
	//	$intTest = $db -> Execute("SELECT id FROM equipment WHERE name='".$objArm -> fields['name']."' AND wt=".$objArm -> fields['wt']." AND type='".$objArm -> fields['type']."' AND status='Q' AND owner=".$player -> id." AND power=".$objArm -> fields['power']." AND zr=".$objArm -> fields['zr']." AND szyb=".$objArm -> fields['szyb']." AND maxwt=".$objArm -> fields['maxwt']." AND poison=".$objArm -> fields['poison']." AND cost=1");
	//	if (!$intTest -> fields['id']) {
	//		$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$objArm -> fields['name']."',".$objArm -> fields['power'].",'".$objArm -> fields['type']."',1,".$objArm -> fields['zr'].",".$objArm -> fields['wt'].",".$objArm -> fields['minlev'].",".$objArm -> fields['maxwt'].",".$objArm -> fields['amount'].",'".$objArm -> fields['magic']."',".$objArm -> fields['poison'].",".$objArm -> fields['szyb'].",'".$objArm -> fields['twohand']."')") or error("nie moge dodac!");
	//	}
	//	else {
	//		$db -> Execute("UPDATE equipment SET amount=amount+".$objArm -> fields['amount']." WHERE id=".$intTest -> fields['id']);
	//	}
	//	$intTest -> Close();
	//	$objArm -> MoveNext();
	//}
	SqlExec("DELETE FROM equipment WHERE status='Q' AND owner=".$player -> id);
	SqlExec("DELETE FROM shop_user_tmp WHERE iid IN (".implode(",",$todel).")");
	$smarty -> assign("Message","Usunale wszystkie swoje oferty i twoje przedmioty wrocily do ciebie. (<A href=sklepy.php?view=market&lista=id&limit=0&owner=".$player -> id.">wroc</a>)");
} elseif ( !empty( $_GET['buy'] ) ) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
		error ("Zapomnij o tym.");
	}
	$buy = $db -> Execute("SELECT * FROM equipment WHERE id=".$_GET['buy']);
	//print_r( $buy->GetArray() );
	$buy -> fields['name'] = $buy->fields['prefix'] . $buy->fields['name'];
	if (!$buy -> fields['id']) {
		error ("Nie ma ofert. (<a href=sklepy.php>wroc</a>)");
	}

	if ($buy -> fields['zr'] <= 0) {
		$buy -> fields['zr'] = str_replace("-","",$buy -> fields['zr']);
		$agility = "+".$buy -> fields['zr'];
	}
	elseif ($buy -> fields['zr'] > 0) {
		$agility = "-".$buy -> fields['zr'];
	}
	if ($buy -> fields['szyb'] > 0) {
		$speed = "+".$buy -> fields['szyb'];
	}
	else {
		$speed = 0;
	}
	$seller = $db -> Execute("SELECT user FROM players WHERE id=".$buy -> fields['owner']);
	$smarty -> assign( array("Name" => $buy -> fields['name'], "Itemid" => $buy -> fields['id'], "Amount1" => $buy -> fields['amount'], "Cost" => $buy -> fields['cost'], "Seller" => $seller -> fields['user'], "Sid" => $buy -> fields['owner'], "Power" => $buy -> fields['power'], "Dur" => $buy -> fields['wt'], "MaxDur" => $buy -> fields['maxwt'], "Type" => $buy -> fields['type'], "Agi" => $agility, "Speed" => $speed));
	$buy -> Close();
	$seller -> Close();
	if (isset($_GET['step']) && $_GET['step'] == 'buy') {
		if (!isset($_POST['amount'])) {
			error("Podaj ile chcesz kupiæ!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
			error ("Zapomnij o tym.");
		}
		$buy = SqlExec("SELECT e.*, i.basecost FROM equipment e JOIN shop_user_tmp i ON i.iid=e.id  WHERE e.id=".$_GET['buy']);
		if ($_POST['amount'] > $buy -> fields['amount']) {
			error("Nie ma tyle ".$buy -> fields['name']." na rynku. <a href=\"sklepy.php\">Wroc</a>");
		}
		$price = $_POST['amount'] * $buy -> fields['cost'];
		if ($price > $player -> gold) {
			error ("Nie masz tyle sztuk z³ota przy sobie. (<a href=sklepy.php>wroc</a>)");
		}
		$item = $buy -> GetArray();
		$item = array_shift( $item );
		$olditem = $item;
		$item['amount'] = $_POST['amount'];
		$item['cost'] = $item['basecost'];
		$item['name'] = $item['prefix'] . $item['name'];
		//print_r( $item );
		//error( "" );
		$player -> gold -= $price;
		$player -> EquipAdd( $item );
		//$test = $db -> Execute("SELECT id FROM equipment WHERE name='".$buy -> fields['name']."' AND wt=".$buy -> fields['wt']." AND type='".$buy -> fields['type']."' AND status='Q' AND owner=".$player -> id." AND power=".$buy -> fields['power']." AND zr=".$buy -> fields['zr']." AND szyb=".$buy -> fields['szyb']." AND maxwt=".$buy -> fields['maxwt']." AND poison=".$buy -> fields['poison']." AND cost=1");
		//if (!$test -> fields['id']) {
		//	$db -> Execute("INSERT INTO equipment (owner, name, power, type, cost, zr, wt, minlev, maxwt, amount, magic, poison, szyb, twohand) VALUES(".$player -> id.",'".$buy -> fields['name']."',".$buy -> fields['power'].",'".$buy -> fields['type']."',1,".$buy -> fields['zr'].",".$buy -> fields['wt'].",".$buy -> fields['minlev'].",".$buy -> fields['maxwt'].",".$_POST['amount'].",'".$buy -> fields['magic']."',".$buy -> fields['poison'].",".$buy -> fields['szyb'].",'".$buy -> fields['twohand']."')") or error("nie moge dodac!");
		//} else {
		//	$db -> Execute("UPDATE equipment SET amount=amount+".$_POST['amount']." WHERE id=".$test -> fields['id']);
		//}
		//$test -> Close();
		if ($_POST['amount'] == $olditem['amount']) {
			SqlExec("DELETE FROM equipment WHERE id=".$olditem['id']);
			SqlExec("DELETE FROM shop_user_tmp WHERE iid={$olditem['id']}");
		} else {
			SqlExec("UPDATE equipment SET amount=amount-".$_POST['amount']." WHERE id=".$olditem['id']);
		}
		SqlExec("UPDATE resources SET bank=bank+".$price." WHERE id=".$olditem['owner']);
		PutSignal( $olditem['owner'], 'res' );
		//$db -> Execute("UPDATE players SET credits=credits-".$price." WHERE id=".$player -> id);
		
		SqlExec("INSERT INTO log (owner, log, czas) VALUES(".$db->qstr($item['owner']).",'<b><a href=view.php?view=".$player -> id.">".$player -> user."</a></b> zaakceptowal twoja oferte za <b>".$_POST['amount']." sztuki {$olditem['prefix']} ".$olditem['name']."</b>. Dostales <b>".$price."</b> sztuk zlota do banku.','".$newdate."')");
		$smarty -> assign("Message", "<br />Kupiles <b>".$_POST['amount']." sztuk przedmiotu: ".$buy -> fields['name']."</b> za <b>".$price."</b> sztuk zlota.");
		error( "Zakupiles {$_POST['amount']} sztuk <b>{$item['name']}</b> za $price", 'done' );
	}
}
elseif (isset($_GET['view']) && $_GET['view'] == 'all') {
	$oferts = $db -> Execute("SELECT name FROM equipment WHERE status='Q' AND owner='".$_GET['owner']."' GROUP BY name");
	$arrname = array();
	$arramount = array();
	$i = 0;
	while (!$oferts -> EOF) {
		$arrname[$i] = $oferts -> fields['name'];
		$arramount[$i] = 0;
		$query = $db -> Execute("SELECT id FROM equipment WHERE status='Q' AND owner='".$_GET['owner']."' AND name='".$arrname[$i]."'");
		while (!$query -> EOF) {
			$arramount[$i] = $arramount[$i] + 1;
			$query -> MoveNext();
		}
		$query -> Close();
		$oferts -> MoveNext();
		$i = $i + 1;
	}
	$oferts -> Close();
	$smarty -> assign( array("Name" => $arrname, "Amount" => $arramount, "Message" => "<br />(<a href=\"sklepy.php\">Wróæ</a>)"));
}
elseif ($_GET['view'] == 'kup') {
	if ($player -> gold < 50000 || $player -> mithril < 100){
		error("Nie masz tyle pieniêdzy lub brakuje ci mithrilu!");
	}
	$db -> Execute("INSERT INTO sklepy (id, owner, opis, ofert) VALUES('', ".$player -> id.", '".$_POST['opis']."', 5)");
	$player -> gold -= 50000;
	$player -> mithril -= 100;
	error("Gratulacje! Mo¿esz rozpocz±æ handlowanie w swoim nowym sklepie.");
}
else {
	$sklepylist = $db -> Execute("SELECT s.opis, s.owner, s.ofert, p.user FROM sklepy s JOIN players p ON s.owner=p.id ORDER BY s.owner");
	$arrsklepy = array();
	$i = 0;
	while (!$sklepylist -> EOF) {
		$arrsklepy[$i] = $sklepylist -> fields['opis'].", W³a¶ciciel: ".$sklepylist -> fields['user']." (<A href=sklepy.php?view=market&lista=id&limit=0&owner=".$sklepylist -> fields['owner'].">wejd¼</a>) <br><br>";
		$i = $i + 1;
		$sklepylist -> MoveNext();
	}
	$sklepylist -> Close();
	$query = $db -> Execute("SELECT id FROM sklepy WHERE owner=".$player -> id);
	$test = $query -> RecordCount();
	$query -> Close();
	if ($test == 0) {
		$smarty->assign("Sklep", 'N');
	}
	else{
		$smarty->assign("Sklep", 'Y');
	}
	$smarty->assign("Sklepy", $arrsklepy);
}

// przypisanie zmiennej
$smarty -> assign(array("Message" => '', "Previous" => '', "Next" => '', "Owner" => $_GET['owner']));

// przypisanie zmiennych oraz wywietlenie strony
$smarty -> assign( array("View" => $_GET['view'], "Remowe" => $_GET['wyc'], "Buy" => $_GET['buy']));
$smarty -> display ('sklepy.tpl');

require_once("includes/foot.php"); 
?>
