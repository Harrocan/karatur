<?php
//@type: F
//@desc: Wymienianie punktów z g³osowañ

/**
  *     @author: IvaN
  *     @email : ivan-q@o2.pl
  *     @copyright : rozpowszechnianie bez wiedzy i zgody autora zabronione
**/

$title="Centrum g³osowañ";
require_once("includes/head.php");

if(( $player->id != 2 ) && ($player->id !=267)) {
	// error( "Centrum Punktow zamkniete do odwolania - mamy maly problem ale niedlugo juz wszystko bedzie ok narazie zbierajcie punkty.", 'error', 'stats.php' );
}

//checklocation($_SERVER['SCRIPT_NAME']);

if( !isset( $_GET['type'] ) ) 
	$_GET['type'] = '';
if( !isset( $_GET['action'] ) ) 
	$_GET['action'] = '';

$tmp = SqlExec( "SELECT value FROM toplista WHERE pid={$player->id} AND `key`='total'" );
//$points = $db->Execute("SELECT `total`,`used` FROM toplista WHERE id={$player->id}");
$points['total'] = $tmp-> fields['value'];
$tmp = SqlExec( "SELECT value FROM toplista WHERE pid={$player->id} AND `key`='used'" );
$points['used'] = $tmp-> fields['value'];
//$points = array_pop( $points->GetArray() );
$left = $points['total']-$points['used'];
$smarty->assign(array("Total"=>$points['total'],"Used"=>$points['used'],"Left"=>$left));

if(!empty($_GET['type'])) {
	switch ($_GET['type']) {
		case 'a' : $what="AP"; break;
		case 'e' : $what="maksymalnej energii"; break;
		case 'z' : $what="z³ota"; break;
		default  : error("Nieprawid³owe wywo³anie !");
	}
	$smarty->assign("Type",$_GET['type']);
	$smarty->assign("What",$what);
}
if($_GET['action']=='go') {
	if(empty($_POST['type']) || empty($_POST['amount']))
		error("Nieprawid³owe wywo³anie !");
	if(floatval($_POST['amount']) <= 0 )
		error("Wprowad¼ poprawn± warto¶æ !");
	switch ($_POST['type']) {
		case 'a' :
			$amount = intval($_POST['amount']);
			$field="ap";
			$cost=70*$amount;
			break;
		case 'e' :
			$amount = floatval($_POST['amount']);
			$field="energy_max";
			$cost=20*$amount*100;
			break;
		case 'z' :
			$amount = intval($_POST['amount']);
			$field="bank";
			$cost=$amount/2;
			//$amount *= 2;
			break;
		default  :
			error("Nieprawid³owe wywo³anie !");
	}
	if($cost > $left) {
		error("Masz niewystarczaj±c± liczbê punktów ! Brakuje Ci jeszcze ".($cost - $left)." punktów");
	}
	$player -> $field += $amount;
	//$db->Execute("UPDATE toplista SET `used`=used + $cost WHERE id={$player->id}")or error("1");
	if( !$points['used'] ) {
		SqlExec( "INSERT INTO toplista(pid, `key`, `sub`, `value`) VALUES( {$player->id}, 'used', '', $cost )" );
	}
	else {
		SqlExec( "UPDATE toplista SET value=value+$cost WHERE pid={$player->id} AND `key`='used'" );
	}
	//$db->Execute("UPDATE players SET $field=$field + $amount WHERE id={$player->id}")or eror("2");
// 	echo "UPDATE toplista SET `used`=used + $cost WHERE id={$player->id}<br>";
// 	echo ("UPDATE players SET $field=$field + $amount WHERE id={$player->id}");
	error("Punkty dodane !",'done');
}

$smarty -> assign (array ("Type"=>$_GET['type']) );
$smarty->display("toplist.tpl");

require_once("includes/foot.php");
?>