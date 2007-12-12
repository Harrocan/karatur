<?php

$title="Administracja przedmiotami";
require_once('includes/head.php');

if($_SESSION['rank']['addeq']!='1')
	error("Nie posiadasz uprawnieñ");

if( !isset( $_GET['action'] ) )
	$_GET['action'] = '';

if(empty($_GET['action'])) {
	$items = array( 'A' => 'Pancerzy', 'B' => 'Lukow', 'D' => 'Tarcz', 'H' => 'Helmow', 'N' => 'Nagolennikow',
					'R' => 'Strzal', 'S' => 'Rozdzek', 'W' => 'Broni', 'Z' => 'Szat', 'R' => 'Strzal',
					'G' => 'Grotow' );
	$res = SqlExec( "SELECT COUNT(id) AS amount,`type` FROM items GROUP BY `type`" );
	$res = $res -> GetArray();
	$added = array();
	$total = 0;
	foreach( $res as $key => $item) {
		$added[] = array( 'type' => $item['type'], 'Name' => $items[$item['type']], 'amount' => $item['amount'] );
		$total += $item['amount'];
	}
	//print_r( $added );
	$smarty -> assign( array( 'Added'=>$added, 'Total'=>$total ) );
}
if( $_GET['action'] == 'imageadd' ) {
	if( isset( $_FILES['plik'] )  ) {
		//print_r( $_POST );
		$itemtype = $_POST['type'];
		$plik = $_FILES['plik']['tmp_name'];
		$nazwa = $_FILES['plik']['name'];
		$typ = $_FILES['plik']['type'];
		$miejsce = "images/items/$itemtype/$nazwa";
		if ($typ != 'image/pjpeg' && $typ != 'image/jpeg' && $typ != 'image/gif') {
			error ("Zly typ pliku! $typ");
		}
		if( is_file( $miejsce ) ) {
			error( "Plik o takiej nazwie juz istnieje !" );
		}
		if (is_uploaded_file($plik)) {
			if (!move_uploaded_file($plik,$miejsce)) {
				error ("Nie skopiowano pliku!");
			}
		} else {
			error ("Zapomij o tym");
		}
		$insert = SqlExec( "INSERT INTO item_images(img_file,item_type) VALUES('$nazwa','$itemtype')" );
		if( !empty( $_POST['iid'] ) ) {
			$iid = $_POST['iid'];
			SqlExec( "UPDATE items SET imagenum=$insert WHERE id=$iid" );
		}
		error( "Obrazek dodany !", 'done' );
	}
	elseif( isset( $_POST['image'] ) ) {
		//print_r($_POST);
		$file = $_POST['image'];
		$type = $_POST['type'];
		$iid = $_POST['iid'];
		$res = SqlExec( "SELECT id FROM item_images WHERE img_file='$file' AND `item_type`='$type'" );
		if( $res -> fields['id'] ) {
			SqlExec( "UPDATE items SET imagenum={$res->fields['id']} WHERE id=$iid" );
			error( "Przedmiot edytowany !",'done' );
		}
		else {
			error( "Przedmiot nie zgadza sie z typem !" );
		}
	}
	else {
		
		if( isset( $_GET['type'] ) )
			$typ = $_GET['type'];
		else
			$typ = '';
		if( isset( $_GET['iid'] ) )
			$iid = $_GET['iid'];
		else
			$iid = '';
		if( !empty( $typ ) ) {
			$path="images/items/$typ/";
			$dir = opendir($path);
			$i=0;
			$arrfile = array();
			while (($file = readdir($dir)) !== false) {
				if(filetype($path . $file)=='file') {
					$arrfile[$i]=$file;
					$i++;
				}
			}
			$options = array();
			foreach( $arrfile as $key=>$file ) {
				$options[$file] = "<img src=\"images/items/$typ/$file\">";
			}
			//print_r( $options );
			$smarty -> assign( "Options", $options );
		}
		if( !empty( $typ ) && !empty( $iid ) ) {
			$res = SqlExec( "SELECT name FROM items WHERE id=$iid AND type='$typ'" );
			if( !$res -> fields['name'] )
				error( "Nieprawidlowe wywolanie !");
			$smarty -> assign( "Itemname", $res -> fields['name'] );
		}
		$cats = array( 'W'=>'Bron', 'S'=>'Rozdzki', 'H'=>'Helm', 'A'=>'Pancerz', 'D'=>'Tarcza', 'Z'=>'Szata',
						'N'=>'Nagolenniki', 'B'=>'Luk', 'R'=>'Strzaly' );
		$smarty -> assign( array( "Cats"=>$cats, 'Typ'=>$typ, 'Iid'=>$iid ) );
	}
}
if(isset($_GET['action']) && $_GET['action']=='add') {
	if(!empty($_POST['name'])) {
		$sql="INSERT INTO items (name, power, type, cost, minlev, zr, wt, maxwt, szyb, magic, poison, amount, twohand) VALUES ('$_POST[name]' ,$_POST[power] ,'$_POST[type]' ,$_POST[cost] ,$_POST[minlev] ,$_POST[zr] ,$_POST[maxwt] ,$_POST[maxwt] ,$_POST[szyb], '$_POST[magic]',$_POST[poison] ,1 ,'$_POST[twohand]')";
		SqlExec( $sql );
		error("Przedmiot ".$_POST['name']." dodany !",'done');
	}
}
if(isset($_GET['action']) && $_GET['action']=='view') {
	if(empty($_GET['typ']))
		error("Podaj typ przedmiotu");
	$e=SqlExec("SELECT i.*, img.img_file AS imgfile FROM items i LEFT JOIN item_images img ON img.id=i.imagenum WHERE i.type='".$_GET['typ']."' ORDER BY i.power ASC");
	if(!$e->fields['id'])
		error("Nie istniej± jeszcze przedmioty tego typu w bazie !");
	$eqs=$e->GetArray();
	foreach( $eqs as $k => $item ) {
		if( is_file( "images/items/{$item['type']}/{$item['imgfile']}" ) )
			$eqs[$k]['imgfile'] = "images/items/{$item['type']}/{$item['imgfile']}";
		else
			$eqs[$k]['imgfile'] = "images/items/na.gif";
	}
	$smarty->assign("Eq",$eqs);
}
if(isset($_GET['action']) && $_GET['action']=='del'){
	if(!isset($_POST['id']))
		error("Nieprawid³owe wywo³anie !");
	$db->Execute("DELETE FROM items WHERE id=".$_POST['id'])or die("SHIT");
	error("Przedmiot usuniêty !",'done');
}
$smarty->assign("Action",$_GET['action']);
$smarty->display('items.tpl');

require_once('includes/foot.php');
?>