<?php

ignore_user_abort( true );

$KT_ROOT_DIR = dirname( __FILE__ );
require_once( $KT_ROOT_DIR . '/../' . 'adodb/adodb.inc.php');

//$db = NewADOConnection('mysql');
//$db -> Connect("localhost", "root", "01am0r3", "ivan_karatur");
require("/home/WWW/ivan/KONFIGURACJA/hasla.php");
//$db -> Connect("localhost", "karatur", $haslo_do_bazy, "karatur");

$dbpass = rawurlencode( $haslo_do_bazy );
$db = @NewADOConnection( "mysql://karatur:$dbpass@localhost/karatur" );

$_DEBUG_TIME = time();
if( $db ) {
	$sql = "INSERT INTO `test`( `page`, `id`, `time` ) VALUES( '{$_SERVER['SCRIPT_NAME']}', 1, '{$_DEBUG_TIME}' )";
	$db->Execute( $sql );
	$db->user = '***';
	$db->password = '***';
}

unset( $haslo_do_bazy );



$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$gamename="Kara-Tur";
$gamemail = "ivan-q@o2.pl";
$gameadress = "http://www.karatur.unicity.pl";
$adminname = "IvaN";
$adminmail = "ivan-q@o2.pl";
//print_r(  );
?>