<?php

require_once( "includes/preinit.php" );

if( !isset( $_GET['page'] ) ) {
	$_GET['page'] = 0;
}

$title = "Modyfikacje gracza";
makeHeader();

function pivotMods( $resArr ) {
	$tab = array();
	foreach( $resArr as $val ) {
		$link =& $tab[ $val['id'] ];
		$link =& $link[ $val['field'] ];
		$link['oldval'] = $val['oldval'];
		$link['newval'] = $val['newval'];
	}
	return $tab;
}

function mod_cmp( $a, $b ) {
	return - strtotime( $a['det']['date'] ) + strtotime( $b['det']['date'] );
}

$tables = array( 'players'=>'Statystyki gracza','resources'=>'Surowce','houses'=>'Statystyki domu','outposts'=>'Statystyki straznic' );
$mods = SqlExec( "SELECT * FROM modifs" );
$mods = $mods -> GetArray();
$mods = pivotMods( $mods );
foreach( $mods as $k => $v ) {
	$det['pid'] = $v['pid']['newval'];
	$det['tid'] = $v['tid']['newval'];
	$det['editreason'] = $v['editreason']['newval'];
	$det['type'] = $v['edittable']['newval'];
	$det['type'] = $tables[$det['type']];
	$det['date'] = date( "Y-m-d H:i", $v['date']['newval'] );
	$user = SqlExec( "SELECT user FROM players WHERE id={$det['pid']}" );
	$target = SqlExec( "SELECT user FROM players WHERE id={$det['tid']}" );
	$det['user'] = $user->fields['user'];
	$det['user_t'] = $target->fields['user'];
	unset( $v['pid'], $v['tid'], $v['edittable'], $v['editreason'], $v['date'] );
	$data = $v;
	$mods[$k] = array( 'data' => $data, 'det' => $det );
}
$totalmods = $mods;

$perPage = 10;
$start = $_GET['page'] * $perPage;


usort( $totalmods, 'mod_cmp' );

$mods = array_slice( $totalmods, $start, $perPage );

$total = count( $totalmods );
//qDebug( $total );
//$pages['total'] = $total;
$pages['total'] = range( 1, ceil( $total/$perPage ) );
$pages['cur'] = $_GET['page'] + 1;

$smarty->assign( "Pages", $pages );
$smarty->assign( "Mods", $mods );
$smarty->display( "modifs.tpl" );

require_once( "includes/foot.php" );

?>