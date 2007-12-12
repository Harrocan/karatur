<?php

$title = "Edycja Toplist";
require_once( "includes/head.php" );

if( !isset( $_GET['step'] ) )
	$_GET['step'] = '';

if( empty( $_GET['step'] ) ) {
	$toplists = SqlExec( "SELECT * FROM toplista_entries" );
	$toplists = $toplists -> GetArray();
	$smarty->assign( "Tops", $toplists );
}

if( $_GET['step'] == 'update' ) {
	$old = SqlExec( "SELECT * FROM toplista" );
	$old = $old -> GetArray();
	//qDebug( print_r( $old, true ) );
	//error( "" );
	$updateSql[] = "CREATE TABLE IF NOT EXISTS `toplista_entries` (
			`id` int(3) NOT NULL auto_increment,
	`link` text NOT NULL,
	`entry` text NOT NULL,
	`date` int(13) NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";
	$updateSql[] = "DROP TABLE IF EXISTS `toplista`;";
	$updateSql[] = "CREATE TABLE `toplista` (
			`pid` INT( 7 ) NOT NULL ,
			`key` VARCHAR( 50 ) NOT NULL ,
			`sub` VARCHAR( 50 ) NOT NULL ,
			`value` VARCHAR( 20 ) NOT NULL
		) ENGINE = MYISAM ;";
	SqlExec( $updateSql, true );
	foreach( $old as $pid => $val ) {
		SqlExec( "INSERT INTO `toplista`( `pid`, `key`, `value` ) VALUES( '{$val['id']}', 'total', '{$val['total']}' )" );
		SqlExec( "INSERT INTO `toplista`( `pid`, `key`, `value` ) VALUES( '{$val['id']}', 'used', '{$val['used']}' )" );
	}
	error( "Aktualizacja zakonczona sukcesem !", 'done' );
}

if( $_GET['step'] == 'add' ) {
	if( !empty( $_POST ) ) {
		$entry = ( stripslashes( $_POST['entry'] ) );
		$link = $_POST['link'];
		//qDebug( print_r( $_POST, true ) );
		$date = time();
		SqlExec( "INSERT INTO toplista_entries(`link`,`entry`,`date`) VALUES('$link','$entry','$date')" );
		error( "Wpis dodany !", 'done' );
	}
}

if( $_GET['step'] == 'edit' ) {
	$top = SqlExec( "SELECT * FROM toplista_entries WHERE id={$_GET['tid']}" );
	$top = array_shift( $top->GetArray());
	if( empty( $top ) ) {
		error( "Nie ma takiej toplisty" );
	}
	if( !empty( $_POST ) ) {
		$entry = ( stripslashes( $_POST['entry'] ) );
		$link = $_POST['link'];
		SqlExec( "UPDATE toplista_entries SET `link`='$link', `entry`='$entry' WHERE id='{$top['id']}'" );
		error( "Lista aktualizowana !", 'done' );
	}
	$top = SqlExec( "SELECT * FROM toplista_entries WHERE id={$_GET['tid']}" );
	$top = array_shift( $top->GetArray());
	$smarty->assign( "Top", $top );
}

if( $_GET['step'] == 'del' ) {
	$top = SqlExec( "SELECT * FROM toplista_entries WHERE id={$_GET['tid']}" );
	$top = array_shift( $top->GetArray());
	if( empty( $top ) ) {
		error( "Nie ma takiej toplisty" );
	}
	SqlExec( "DELETE FROM toplista_entries WHERE id={$_GET['tid']}" );
	error( "Lista usunieta", 'done' );
}

$smarty->assign( array( "Step"=>$_GET['step'] ) );
$smarty->display( "toplist_edit.tpl" );

require_once( "includes/foot.php" );
?>