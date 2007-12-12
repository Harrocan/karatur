<?php

$title = "Szpiegowanie gracza";
require_once( "includes/head.php" );

error( "Zamkniête z powodu bugów" );

if($_SESSION['rank']['usersniff']!='1')
	error("Nie posiadasz uprawnieñ ¿eby tutaj przebywaæ");

if( !isset( $_GET['edit'] ) ) {
	$_GET['edit'] = '';
}

$sid = ( empty( $_GET['id'] ) ) ? NULL : $_GET['id'];
if( $sid === NULL ) {
	//echo "1";
}
else {
	$playerData = SqlExec( "SELECT p.*, r.name AS rank_name, t.name AS tribe_name FROM players p LEFT JOIN ranks r ON p.rid=r.id LEFT JOIN tribes t ON p.tribe=t.id WHERE p.id=$sid" );
	$playerData = array_shift( $playerData -> GetArray() );
	$sniff['player'] = $playerData;
	$resourceData = SqlExec( "SELECT * FROM resources WHERE id=$sid" );
	$resourceData = array_shift( $resourceData -> GetArray() );
	$sniff['resources'] = $resourceData;
	/*$crimeData = SqlExec( "SELECT * FROM akta WHERE pid=$sid" );
	$crimeData = $crimeData -> GetArray();
	$sniff['crimes'] = $crimeData;
	$bankData = SqlExec( "SELECT * FROM bank WHERE pid=$sid" );
	$bankData = $bankData -> GetArray();
	$sniff['bank'] = $bankData;
	$pokemonData = SqlExec( "SELECT c.* FROM core c LEFT JOIN cores c_data ON c.ref_id=c_data.id WHERE c.owner=$sid" );
	$pokemonData =  $pokemonData -> GetArray();
	$sniff['pokemon'] = $pokemonData;
	$spellData = SqlExec( "SELECT * FROM czary WHERE gracz=$sid" );
	$spellData =  $spellData -> GetArray();
	$sniff['spells'] = $spellData;
	$equipmentData = SqlExec( "SELECT * FROM equipment WHERE owner=$sid" );
	$equipmentData =  $equipmentData -> GetArray();
	$sniff['equip'] = $equipmentData;*/
	$houseData = SqlExec( "SELECT * FROM houses WHERE owner=$sid OR locator=$sid" );
	$houseData =  array_shift( $houseData -> GetArray() );
	$sniff['house'] = $houseData;
	/*$potionData = SqlExec( "SELECT * FROM mikstury WHERE gracz=$sid" );
	$potionData =  $potionData -> GetArray();
	$sniff['potions'] = $potionData;
	$mineData = SqlExec( "SELECT * FROM mines WHERE pid=$sid" );
	$mineData =  $mineData -> GetArray();
	$sniff['mines'] = $mineData;*/
	$outpostData = SqlExec( "SELECT * FROM outposts WHERE owner=$sid" );
	$outpostData =  array_shift( $outpostData -> GetArray() );
	$sniff['outpost'] = $outpostData;
	$transferData = SqlExec( "SELECT t.*, p1.user AS from_user, p2.user AS to_user FROM transfer t LEFT JOIN players p1 ON p1.id=t.from LEFT JOIN players p2 ON p2.id=t.to WHERE t.`from`=$sid OR t.`to`=$sid" );
	$transferData =  $transferData -> GetArray();
	$sniff['transfers'] = $transferData;
	
	foreach( $sniff['transfers'] as $k => $tr ) {
		$sniff['transfers'][$k]['date'] = date( "Y-m-d H:i", $tr['date'] );
	}
	
	//qDebug( print_r( $sniff, true ) );
	$smarty->assign( "Sniff", $sniff );
}

if( $_GET['edit'] ) {
	qDebug( print_r( $_POST, true ) );
	$spc = $_POST['spc'];
	unset( $_POST['spc'] );
	switch( $spc['modType'] ) {
		case 'personal' :
			$table = 'players';
			$where = "id={$_GET['edit']}";
			$action = "mod";
			break;
		case 'resource' :
			$table = 'resources';
			$where = "id={$_GET['edit']}";
			$action = "mod";
			break;
		case 'house' :
			$table = 'houses';
			$where = "owner={$_GET['edit']}";
			$action = "mod";
			break;
		case 'outpost' :
			$table = 'outposts';
			$where = "owner={$_GET['edit']}";
			$action = "mod";
			break;
		default :
			trigger_error( "Nieprawidlowa akcja !", E_USER_ERROR );
			break;
	}
	switch( $action ) {
		case 'mod' :
			qDebug( print_r( $_POST, true ) );
			$keys = array_keys( $_POST );
			$sql = SqlCreate( "SELECT", $table, $keys, $where );
			qDebug( $sql );
			$old = SqlExec( $sql );
			$old = array_shift( $old -> GetArray() );
			$diff = array_diff_assoc( $_POST, $old );
			qDebug( print_r( $diff, true ) );
			if( empty( $diff ) ) {
				error( "Nie wybrales do edycji zadnych danych !" );
			}
			$id = SqlExec( "SELECT id FROM modifs GROUP BY id ORDER BY id DESC LIMIT 1" );
			$id = $id->fields['id'] + 1;
			foreach( $diff as $key => $val ) {
				SqlExec( "INSERT INTO modifs( id, field, oldval, newval ) VALUES( '$id', '$key', '{$old[$key]}', '{$val}' )" );
			}
			SqlExec( "INSERT INTO modifs( id, field, oldval, newval ) VALUES( '$id', 'pid', '', '{$player->id}' )" );
			SqlExec( "INSERT INTO modifs( id, field, oldval, newval ) VALUES( '$id', 'tid', '', '{$_GET['edit']}' )" );
			SqlExec( "INSERT INTO modifs( id, field, oldval, newval ) VALUES( '$id', 'edittable', '', '{$table}' )" );
			SqlExec( "INSERT INTO modifs( id, field, oldval, newval ) VALUES( '$id', 'editreason', '', '{$spc['editReason']}' )" );
			SqlExec( "INSERT INTO modifs( id, field, oldval, newval ) VALUES( '$id', 'date', '', '".time()."' )" );
			$sql = SqlCreate( "UPDATE", $table, $diff, $where );
			qDebug( $sql );
			SqlExec( $sql );
			error( "Gracz edytowany !", 'done', "?id={$_GET['edit']}" );
			break;
	}
}

$smarty->assign( "Sid", $sid );

$smarty->display( "usersniff.tpl" );

require_once( "includes/foot.php" );

?>