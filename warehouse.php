<?php
//@type: F
//@desc: Magazyn
/**
*   File functions:
*   Warehouse - sell minerals and herbs
*
*   @name                 : warehouse.php
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : Xyron
*   @version              : 0.8 beta
*   @since                : 3.10.2005
*
*/

$title = "Magazyn";
require_once("includes/head.php");

if ($player -> przemiana > 0) {

error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 

}
// if($player->id!=267)
// 	error('chcac sprzedac swoje mineraly udajesz sie w strone magazynu krolewskiego lecz juz na parenascie mertow od budynku zauwazasz tlumy polorkow i krasnolodow noszacych rozne deski i kamienie niewiedzac o co chodzi postanawiqasz sie zapytac jednego z pracujacych co sie stalo a ten odpowiada ci "Mamy tu maly problem król nakaza³ rozbudowac Magazyn a teraz architekt Alucard nad wszystkim czuwa wiedz odejdz z tad i nie przeszkadzaj w naszej pracy"');

checklocation($_SERVER['SCRIPT_NAME']);

/**
* Main menu
*/
if (!isset($_GET['action']))
{
	$arrItems = array('copper', 'iron', 'coal', 'mithril', 'adamantium', 'meteor', 'crystal', 'lumber', 'illani', 'illanias', 'nutari', 'dynallca');
	$arrMinname = array('Miedz', 'Zelazo','Wegiel', 'Mithril', 'Adamantyt','Meteor', 'Krysztal', 'Drewno','Iliani', 'Ilianias', 'Nutari', 'Dynallca');
	$arrMineral = array('C', 'I', 'O', 'M', 'A', 'E', 'R', 'L','H', 'S', 'N', 'D');
	$arrHerbname = array();
	$arrHerb = array();
	$arrCostmin = array();
	$arrCostherb = array();
	$arrItems2 = array('copper', 'zelazo', 'wegiel', 'mithril', 'adam', 'meteo', 'krysztal', 'lumber', 'illani', 'illanias', 'nutari', 'dynallca');
	$stock=$db->Execute("SELECT * FROM warehouse_stock WHERE id=1");
	foreach($arrItems as $val)
		$arrAvail[]=(int)$stock->fields[$val];
	//print_r($arrAvail);
	for($i = 0; $i < 12; $i++)
	{
		$objValue = $db -> Execute("SELECT value FROM settings WHERE setting='sell_".$arrItems[$i]."'");
		$arrCostmin[$i] = $objValue -> fields['value'];
	}
	for($i = 0; $i < 12; $i++)
	{
		$objValue = $db -> Execute("SELECT value FROM settings WHERE setting='buy_".$arrItems[$i]."'");
		$arrSell[$i] = $objValue -> fields['value'];
	}
	$smarty -> assign(array("Minname" => $arrMinname,
		"Sellavail" => $arrAvail,
		"Costmin" => $arrCostmin,
		"Sellcost" => $arrSell,
		"Mineral" => $arrMineral,
		"Herb" => $arrHerb,
		"Asell" => 'Sprzedaj'));
}

/**
* Sell herbs and minerals
*/
if (isset($_GET['action']) && $_GET['action'] == 'sell')
{
	$arrItem = array('C', 'I', 'O', 'M', 'A', 'E', 'R', 'L', 'H', 'S', 'N', 'D');
	$resources = array('C'=>'copper', 'I'=>'iron', 'O'=>'coal', 'M'=>'mithril', 'A'=>'adamantium', 'E'=>'meteor', 'R'=>'crystal', 'L'=>'wood', 'H'=>'illani', 'S'=>'illanias', 'N'=>'nutari', 'D'=>'dynallca');
	if ( !isset( $resources[$_GET['item']] ) )
	{
		error( "Nieprawidlowy typ przedmiotu !" );
	}
	$intItem = array_search($_GET['item'], $arrItem);
	$arrItemname = array('Miedz', 'Zelazo', 'Wegiel', 'Mithril', 'Adamantium', 'Meteor', 'Krysztal', 'Drewno', 'Illani', 'Illanias', 'Nutari', 'Dynallca');
	$arrItems2 = array('copper', 'zelazo', 'wegiel', 'mithril', 'adam', 'meteo', 'krysztal', 'lumber', 'illani', 'illanias', 'nutari', 'dynallca');
	//if ($intItem == 3)
	//{
	//	$intAmount = $player -> platinum;
	//}
	//if ($intItem < 8 && $intItem != 3)
	//{
	//	$objTest = $db -> Execute("SELECT ".$arrItems2[$intItem]." FROM kopalnie WHERE gracz=".$player -> id);
	//	$intAmount = $objTest -> fields[$arrItems2[$intItem]];
	//}
	//if ($intItem > 7)
	//{
	//	$objTest = $db -> Execute("SELECT ".$arrItems2[$intItem]." FROM herbs WHERE gracz=".$player -> id);
	//	$intAmount = $objTest -> fields[$arrItems2[$intItem]];
	//}
	$smarty -> assign(array("Itemname" => $arrItemname[$intItem],
		"Item" => $_GET['item'],
		"Asell" => 'Sprzedaj',
		"Aback" => 'Wroc',
		"Tamount" => 'Ilosc',
		"Youhave" => 'Masz',
		"Iamount" => $player -> $resources[$_GET['item']]));
	if (isset($_GET['sell']) && $_GET['sell'] == 'sell')
	{
		if (!ereg("^[1-9][0-9]*$", $_POST['amount']))
		{
				error( "Podaj ile chcesz sprzedac !" );
		}
		$arrItems = array('copper', 'iron', 'coal', 'mithril', 'adamantium', 'meteor', 'crystal', 'lumber', 'illani', 'illanias', 'nutari', 'dynallca');
		if( $player -> $resources[$_GET['item']] < $_POST['amount'] ) {
			error( "Nie masz az tyle tego surowca !" );
		}
		$player -> $resources[$_GET['item']] -= $_POST['amount'];
		//if ($intItem == 3)
		//{
		//		if ($_POST['amount'] > $player -> platinum)
		//		{
		//			error(Brak.$arrItemname[$intItem]);
		//		}
		//		$db -> Execute("UPDATE players SET platinum=platinum-".$_POST['amount']." WHERE id=".$player -> id);
		//}
		//if ($intItem < 8 && $intItem != 3)
		//{
		//		if ($_POST['amount'] > $objTest -> fields[$arrItems2[$intItem]])
		//		{
		//			error(Brak. $arrItemname[$intItem]);
		//		}
		//		$db -> Execute("UPDATE kopalnie SET ".$arrItems2[$intItem]."=".$arrItems2[$intItem]."-".$_POST['amount']." WHERE gracz=".$player -> id);
		//}
		//if ($intItem > 7)
		//{
		//		if ($_POST['amount'] > $objTest -> fields[$arrItems2[$intItem]])
		//		{
		//			error(Brak. $arrItemname[$intItem]);
		//		}
		//		$db -> Execute("UPDATE herbs SET ".$arrItems2[$intItem]."=".$arrItems2[$intItem]."-".$_POST['amount']." WHERE gracz=".$player -> id);
		//}
		$sql="UPDATE `warehouse_stock` SET {$arrItems[$intItem]}={$arrItems[$intItem]}+{$_POST['amount']} WHERE id=1";
		$db->Execute($sql)or error($sql);
		$objPrice = $db -> Execute("SELECT value FROM settings WHERE setting='sell_".$arrItems[$intItem]."'");
		$intGold = ($objPrice -> fields['value'] * $_POST['amount']);
		//$db -> Execute("UPDATE players SET credits=credits+".$intGold." WHERE id=".$player -> id);
		$player -> gold += $intGold;
		error("Sprzedales ".$_POST['amount']." Ilosc ".$arrItemname[$intItem]." Za ".$intGold." Zlota ",'done');
	}
}

/**
* Buy herbs and minerals
*/
if (isset($_GET['action']) && $_GET['action'] == 'buy')
{
	$arrItem = array('C', 'I', 'O', 'M', 'A', 'E', 'R', 'L', 'H', 'S', 'N', 'D');
	$resources = array('C'=>'copper', 'I'=>'iron', 'O'=>'coal', 'M'=>'mithril', 'A'=>'adamantium', 'E'=>'meteor', 'R'=>'crystal', 'L'=>'wood', 'H'=>'illani', 'S'=>'illanias', 'N'=>'nutari', 'D'=>'dynallca');
	if ( !isset( $resources[$_GET['item']] ) )
	{
		error( "Nieprawidlowy typ przedmiotu !" );
	}
	$intItem = array_search($_GET['item'], $arrItem);
	$arrItemname = array('Miedz', 'Zelazo', 'Wegiel', 'Mithril', 'Adamantium', 'Meteor', 'Krysztal', 'Drewno', 'Illani', 'Illanias', 'Nutari', 'Dynallca');
	$arrItems2 = array('copper', 'zelazo', 'wegiel', 'mithril', 'adam', 'meteo', 'krysztal', 'lumber', 'illani', 'illanias', 'nutari', 'dynallca');
	$arrItems = array('copper', 'iron', 'coal', 'mithril', 'adamantium', 'meteor', 'crystal', 'lumber', 'illani', 'illanias', 'nutari', 'dynallca');
	$objPrice = $db -> Execute("SELECT value FROM settings WHERE setting='buy_".$arrItems[$intItem]."'");
	$smarty -> assign(array("Itemname" => $arrItemname[$intItem],
		"Item" => $_GET['item'],
		"Aback" => 'Wroc',
		"Cost"=>$objPrice->fields['value']));
	if (isset($_GET['buy']) && $_GET['buy'] == 'buy')
	{
		if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
				error("Podaj ile chcesz kupic !");
		}
		$amount=$db->Execute("SELECT {$arrItems[$intItem]} AS amount FROM warehouse_stock WHERE id=1");
		if($amount->fields['amount']-$_POST['amount']<0)
			error("W magazynie nie ma a¿ tylu surowców");
		if($player->gold-($objPrice->fields['value']*$_POST['amount'])<0)
			error("Nie masz tylu pieniêdzy");
		$arrItems = array('copper', 'iron', 'coal', 'mithril', 'adamantium', 'meteor', 'crystal', 'lumber', 'illani', 'illanias', 'nutari', 'dynallca');
		//if ($intItem == 3) {
		//	$db -> Execute("UPDATE players SET platinum=platinum+".$_POST['amount']." WHERE id=".$player -> id);
		//} elseif ($intItem < 8) {
		//	$sql="UPDATE kopalnie SET ".$arrItems2[$intItem]."=".$arrItems2[$intItem]."+".$_POST['amount']." WHERE gracz=".$player -> id;
		//	$db -> Execute($sql)or error($sql);
		//}elseif ($intItem > 7){
		//	$sql="UPDATE herbs SET ".$arrItems2[$intItem]."=".$arrItems2[$intItem]."+".$_POST['amount']." WHERE gracz=".$player -> id;
		//	$db -> Execute($sql)or error($sql);
		//}
		$player -> $resources[$_GET['item']] += $_POST['amount'];
		$sql="UPDATE `warehouse_stock` SET {$arrItems[$intItem]}={$arrItems[$intItem]}-{$_POST['amount']} WHERE id=1";
		$db->Execute($sql)or error($sql);
		$objPrice = $db -> Execute("SELECT value FROM settings WHERE setting='buy_".$arrItems[$intItem]."'");
		$intGold = ($objPrice -> fields['value'] * $_POST['amount']);
		//$db -> Execute("UPDATE players SET credits=credits-".$intGold." WHERE id=".$player -> id);
		$player -> gold -= $intGold;
		error("Kupi³e¶ ".$_POST['amount']." ".$arrItemname[$intItem]." Za ".$intGold." Zlota ",'done');
	}
}

/**
* Initialization of variables
*/
if (!isset($_GET['action']))
{
	$_GET['action'] = '';
}

/**
* Assign variables to template and display page
*/
$smarty -> assign(array("Action" => $_GET['action']));
$smarty -> display('warehouse.tpl');

require_once("includes/foot.php");
?>
