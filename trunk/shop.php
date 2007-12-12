<?php
//@type: F
//@desc: Sklepy
$title="Sklep";
require_once('includes/head.php');

checklocation($_SERVER['SCRIPT_NAME']);

if(empty($_GET['sid']))
	error("Podaj identyfikator sklepu !");
$shop=$db->Execute("SELECT * FROM shop WHERE id={$_GET['sid']}")or error("Podaj poprawny identyfikator sklepu");
if(!$shop->fields['name'])
	error("Niepoprawny identyfikator sklepu !",'error',$player -> file);

if( !isset( $_GET['view'] ) )
	$_GET['view'] = '';
if( !isset( $_GET['iid'] ) )
	$_GET['iid'] = '';

//! Kupowanie przedmiotów
if( !empty( $_GET['iid'] ) ) {
	$item = SqlExec( "SELECT name FROM shopware WHERE id={$_GET['iid']} AND sid={$_GET['sid']}" );
	if( empty( $item -> fields['name'] ) ) {
		error( "Tego przedmiotu tutaj nie kupisz !", 'error', "shop.php?sid={$_GET['sid']}");
	}
	$smarty -> assign( "Itemname", $item -> fields['name'] );
	if( !empty( $_POST['amount'] ) ) {
		$item=SqlExec("SELECT s.*, i.img_file FROM shopware s LEFT JOIN item_images i ON i.id=s.imagenum WHERE s.id={$_GET['iid']} AND s.sid={$_GET['sid']}");
		$i=$item->GetArray();
		if( empty( $i ) ) {
			error( "Tego przedmiou nie kupisz w tym sklepie !", 'error', "shop.php?sid={$_GET['sid']}");
		}
		$amount = intval( $_POST['amount'] );
		if( empty( $amount ) ) {
			error( "Podaj poprawna ilosc !", 'error', "shop.php?sid={$_GET['sid']}");
		}
		$i=$i[0];
		$cost = $i['cost'] * $amount;
		if($player->gold < $cost )
			error("Nie masz wystarczaj±cej ilo¶ci pieniêdzy przy sobie !", 'error', "shop.php?sid={$_GET['sid']}");
		//$db->Execute("UPDATE players SET credits=credits-{$i['cost']} WHERE id={$player->id}");
		$player -> gold -= $cost;
		$i['cost']=floor($i['cost']*.75);
		$i['amount'] = $amount;
		$player -> EquipAdd( $i );
		error("Zakupi³e¶ $amount sztuk <b>{$i['name']}</b> za kwote $cost sztuk zlota!",'done',"shop.php?sid={$_GET['sid']}");
	}
}

if( !empty( $_GET['view'] ) ) {
	$wares=$db->Execute("SELECT s.*, i.img_file FROM shopware s LEFT JOIN item_images i ON i.id = s.imagenum WHERE s.type='{$_GET['view']}' AND s.sid={$_GET['sid']} ORDER BY s.minlev ASC");
	$wares=$wares -> GetArray();
	if( empty( $wares ) ) {
		error( "W tym sklepie nie ma takich przedmiotow !", 'error', "shop.php?sid={$_GET['sid']}");
	}
	foreach( $wares as $key => $item ) {
		$path = "images/items/{$item['type']}/{$item['img_file']}";
		if( is_file($path) ) {
			$wares[$key]['imglink'] = $path;
		}
		else {
			$wares[$key]['imglink'] = 'images/items/na.gif';
		}
	}
	if( in_array( $wares[0]['type'], array( 'W', 'B', 'R' ) ) )
		$suff = 'obrazen';
	if( in_array( $wares[0]['type'], array( 'A', 'H', 'D', 'N' ) ) )
		$suff = 'obrony';
	if( in_array( $wares[0]['type'], array( 'Z' ) ) )
		$suff = '% many';
	if( in_array( $wares[0]['type'], array( 'S' ) ) )
		$suff = '% mocy czarow';
	$smarty->assign( array( "Wares"=>$wares, "Suff"=>$suff ) );
}

$st=explode(",",$shop->fields['type']);
$typearr=array();
foreach($st as $t)
	$typearr[$t]=1;
$smarty->assign("Types",$typearr);



$smarty->assign("Sopis",$shop->fields['opis']);
$smarty->assign("Sid",$_GET['sid']);
$smarty->assign("View",$_GET['view']);
$smarty->assign("Iid",$_GET['iid']);
$smarty->assign("Sname",$shop->fields['name']);
$smarty->display('shop.tpl');

require_once('includes/foot.php');
?>
