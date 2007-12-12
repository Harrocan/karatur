<?php

/**
* @desc Funkcje uzywane w modulach. Ulatwiaja dostep do tabeli z danymi modulu i umozliwiaja operacje ktore zostaly
* zablokowane przez ograniczenia w dozwolonej skladni podczas pisania modow
* @author Ivan <ivan-q@o2.pl>
* @copyright KaraTur-Team 2006-2007
* @package KaraTur
* @subpackage Modules
*/

require_once( "class/metaTable.class.php" );

function getData( $key1 = NULL, $key2 = NULL, $key3 = NULL, $key4 = NULL ) {
	global $__safeMode, $__sandboxMode;
	$oldSafeMode = $__safeMode;
	$__safeMode = false;
	$oldSandMode = $__sandboxMode;
	$__sandboxMode = false;
	global $__modData;
	$modId = $__modData['id'];
	$meta = new MetaTable( "modulesData", "mid", $modId, 'key' );
	
	$maxArgs = 4;
	$args = func_num_args( );

	if ( $args > $maxArgs ) {
		error ( "Maksymalna ilosc parametrow w funkcji getData wynosi 4 !($args)" );
	}

	$params = array();

	for( $i = 0; $i < $args; $i++ ) {
		$params[] = func_get_arg( $i );
	}
	//$ret = loadMetaTableData( "modulesData", "mid", $modId, "key", $params );
	$ret = $meta->loadData( $params );
	$__safeMode = $oldSafeMode;
	$__sandboxMode = $oldSandMode;
	return $ret;
}

function setData( $value, $key1, $key2 = NULL, $key3 = NULL, $key4 = NULL ) {
	global $__safeMode, $__sandboxMode;
	$oldSafeMode = $__safeMode;
	$__safeMode = false;
	$oldSandMode = $__sandboxMode;
	$__sandboxMode = false;
	global $__modData;
	$modId = $__modData['id'];
	$meta = new MetaTable( "modulesData", "mid", $modId, 'key' );

	$maxArgs = 5;
	$args = func_num_args( );

	if ( $args > $maxArgs ) {
		error ( "Maksymalna ilosc parametrow w funkcji setData wynosi 4 !($args)" );
	}

	$params = array();

	for( $i = 1; $i < $args; $i++ ) {
		$params[] = func_get_arg( $i );
	}

	//saveMetaTableData( "modulesData", "mid", $modId, "key", $value, $params );
	$meta->saveData( $value, $params );
	$__safeMode = $oldSafeMode;
	$__sandboxMode = $oldSandMode;
}

function delData( ) {
	global $__safeMode, $__sandboxMode;
	$oldSafeMode = $__safeMode;
	$__safeMode = false;
	$oldSandMode = $__sandboxMode;
	$__sandboxMode = false;
	global $__modData;
	$modId = $__modData['id'];
	$meta = new MetaTable( "modulesData", "mid", $modId, 'key' );
	
	$maxArgs = 4;
	$args = func_num_args( );
	
	if ( $args > $maxArgs ) {
		error ( "Maksymalna ilosc parametrow w funkcji delData wynosi 4 !($args)" );
	}

	$params = array();

	for( $i = 0; $i < $args; $i++ ) {
		$params[] = func_get_arg( $i );
	}

	//deleteMetaTableData( "modulesData", "mid", $modId, "key", $params );
	$deleted = $meta->deleteData( $params );
	$__safeMode = $oldSafeMode;
	$__sandboxMode = $oldSandMode;
	return $deleted;
}

function requireFile( $filename, $force = false ) {
	global $__modData;
	require_once( "modules/{$__modData['name']}/inc/$filename" );
}
?>