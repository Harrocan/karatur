<?php
//@type: F
//@desc: Og³oszenia
$title = "Ogloszenia";
require_once("includes/head.php");

//inicjalizacja zmiennej
if( !isset($_GET['view']))
	$_GET['view'] = '';
if( !isset( $_GET['action'] ) )
	$_GET['action']='';

if( $_GET['action'] == 'add' ) {
	$title = strip_tags( $_POST['title'] );
	$body = strip_tags( $_POST['body'] );
	if( empty( $title ) || empty ( $body ) ) {
		error( "Wypelnij wszstkie pola !" );
	}
	SqlExec( "INSERT INTO ogloszenia(starter,title,ogloszenia) VALUES('{$player->user}','{$title}','{$body}')" );
	error( "Wiadomosc dodana !", 'done' );
}

if ( empty($_GET['view'])) {
	$upd = $db -> SelectLimit("SELECT * FROM ogloszenia ORDER BY id DESC", 8);
	$upd = $upd -> GetArray();
	$smarty -> assign( "Upd", $upd );
// 	$arrtitle = array();
// 	$arrstarter = array();
// 	$arrnews = array();
// 	$arrmodtext = array();
// 	$i = 0; 
// 	while (!$upd -> EOF) {
// 		//if ($player -> rank == 'Admin') {
// 		//	$arrmodtext[$i] = "(<a href=oglw.php?modify=".$upd -> fields['id'].">Zmien</a>)";
// 		//} else {
// 			$arrmodtext[$i] = '';
// 		//}
// 		$arrtitle[$i] = $upd -> fields['title'];
// 		$arrstarter[$i] = $upd -> fields['starter'];
// 		$arrnews[$i] = $upd -> fields['ogloszenia'];
// 		$upd -> MoveNext();
// 		$i = $i + 1; 
// 	}
// 	$upd -> Close();
// 	$smarty -> assign ( array("Title1" => $arrtitle, "Starter" => $arrstarter, "Update" => $arrnews, "Modtext" => $arrmodtext)); 
}


//przypisanie zmiennej oraz wyswietlenie strony
$smarty -> assign ("View", $_GET['view']);
$smarty -> display ('ogloszenia.tpl');

require_once("includes/foot.php");
?>
