<?php

$title="Administracja sklepami";
require_once('includes/head.php');

if($_SESSION['rank']['shop']!='1')
	error("Nie posiadasz uprawnieñ !");

if( !isset( $_GET['action'] ) )
	$_GET['action'] = '';

if (!empty($_POST['sid']) && empty($_GET['action'])) {
	$db->Execute("DELETE FROM shop WHERE id={$_POST['sid']}");
	$db->Execute("DELETE FROM shopware WHERE sid={$_POST['sid']}");
}
$sh=$db->Execute("SELECT * FROM shop");
$smarty->assign("Shop",$sh->GetArray());
if($_GET['action']=='add') {
	if(!empty($_POST['city'])) {
		$db->Execute("INSERT INTO shop (name, city, opis) VALUES ('{$_POST['city']}','{$_POST['file']}', '{$_POST['opis']}')");
		error($_POST['city']." dodany !",'done');
	}
	$city=$db->Execute("SELECT id,name FROM miasta");
	$smarty->assign("City",$city->GetArray());
}
if($_GET['action']=='edit') {

	if(empty($_GET['sid']))
		error("Podaj identyfikator sklepu !");
	$shop=$db->Execute("SELECT name FROM shop WHERE id=".$_GET['sid']);
	if(!$shop->fields['name'])
		error("Nie istnieje taki sklep !");
	if(!empty($_POST['weapon']) || !empty($_POST['armor'])) {
		if(!empty($_POST['weapon']))
			$id=$_POST['weapon'];
		else
			$id=$_POST['armor'];
		$item=$db->Execute("SELECT i.* FROM items i WHERE i.id=".$id);
		if(!$item->fields['id'])
			error("Niew³a¶ciwy przedmiot !");
		$i=$item->GetArray();
		$sql="SELECT id FROM shopware WHERE sid={$_GET['sid']} AND name='{$i[0]['name']}' AND power={$i[0]['power']} AND type='{$i[0]['type']}' AND cost={$i[0]['cost']} AND minlev={$i[0]['minlev']} AND zr={$i[0]['zr']} AND maxwt={$i[0]['maxwt']} AND szyb={$i[0]['szyb']} AND magic='{$i[0]['magic']}' AND imagenum={$i[0]['imagenum']}";
		$test=$db->Execute($sql)or error($sql);
		if($test->fields['id'])
			error("Taki przedmiot ju¿ jest w sklepie !");
		$i=$i[0];
		$sql="INSERT INTO shopware (sid, name, power, type, cost, minlev, zr, wt, maxwt, szyb, magic, poison, amount, twohand, imagenum) VALUES ($_GET[sid], '$i[name]', $i[power], '$i[type]', $i[cost], $i[minlev], $i[zr], $i[wt], $i[maxwt], $i[szyb], '$i[magic]', $i[poison], $i[amount], '$i[twohand]', $i[imagenum])";
		$db->Execute($sql)or error($sql);
		$types=$db->Execute("SELECT type FROM shop WHERE id={$_GET['sid']}");
		if($types->fields['type']!='')
			$typearr=explode(",",$types->fields['type']);
		else
			$typearr=array();
		//gettype($typearr);
		//print_r($typearr);
		if(array_search($i['type'],$typearr)===FALSE)
			$typearr[]=$i['type'];
		//print_r($typearr);
		$db->Execute("UPDATE shop SET type='".implode(",",$typearr)."' WHERE id={$_GET['sid']}");
	}
	if(!empty($_POST['iid'])) {
		$type=$db->Execute("SELECT type FROM shopware WHERE id={$_POST['iid']} AND sid={$_GET['sid']}");
		$db->Execute("DELETE FROM shopware WHERE id={$_POST['iid']} AND sid={$_GET['sid']}");
		$test=$db->Execute("SELECT id FROM shopware WHERE sid={$_GET['sid']} AND type='{$type->fields['type']}'");
		if(!$test->fields['id']) {
			$type=$type->fields['type'];
			$st=$db->Execute("SELECT type FROM shop WHERE id={$_GET['sid']}");
			$stnew=$st->fields['type'];
			$stnew=ereg_replace ("^".$type.",",'',$stnew);
			$stnew=ereg_replace (",".$type.",",',',$stnew);
			$stnew=ereg_replace (",".$type."$",'',$stnew);
			$stnew=ereg_replace ("^".$type."$",'',$stnew);
			$db->Execute("UPDATE shop SET type='$stnew' WHERE id={$_GET['sid']}");
		}
	}
	$ware=$db->Execute("SELECT * FROM shopware WHERE sid=".$_GET['sid']." ORDER BY type ASC, minlev ASC");
	$weap=$db->Execute("SELECT id,name,power,type  FROM items WHERE type='W' OR type='S' OR type='B' OR type='R' ORDER BY type ASC, minlev ASC");
	$arm=$db->Execute("SELECT id,name,power,type FROM items WHERE type='H' OR type='A' OR type='D' OR type='N' OR type='Z' ORDER BY type ASC, minlev ASC");
	$smarty->assign("Weap",$weap->GetArray());
	$smarty->assign("Arm",$arm->GetArray());
	$smarty->assign("Ware",$ware->GetArray());
	$smarty->assign("Sid",$_GET['sid']);
	$smarty->assign("Sname",$shop->fields['name']);
}
if($_GET['action']=='edits') {
	if(!empty($_POST['shopid'])) {
		$db->Execute("UPDATE shop SET name='{$_POST['name']}', city='{$_POST['file']}', opis='{$_POST['opis']}' WHERE id={$_POST['shopid']}");
		error("Miasto edytowane !",'done');
	}
	$shop=$db->Execute("SELECT * FROM shop WHERE id={$_POST['sid']}");
	if(!$shop->fields['name'])
		error("Taki sklep nie istnieje !");
	$s=$shop->GetArray();
	$smarty->assign("Shop",$s[0]);
	$city=$db->Execute("SELECT id,name FROM miasta");
	$smarty->assign("City",$city->GetArray());
}
$smarty->assign("Action",$_GET['action']);
$smarty->display('shopadm.tpl');

require_once('includes/foot.php');
?>