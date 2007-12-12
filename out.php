<?php

//require_once('includes/config.php');
//require_once('includes/globalfunctions.php');
//require_once( 'class/player.class.php');
//require_once('includes/sessions.php');

require_once "includes/preinit.php";

if(empty($_SESSION['player'])) {
	$db->Close();
	die("Sesja zakonczona");
}
/*
$link[1]="http://gildwars.topka.pl/?we=karatur2";
$link[2]="http://owm.top-100.pl/?we=kt1";
$link[3]="http://rpg.najlepsze.net/?we=kt1";
$link[4]="http://rpgblog.toplista.pl/?we=kt1";
$link[5]="http://rpgtextowe.topka.pl/?we=agionn";
$link[6]="http://graonline.toplista.pl/?we=kt1";
$link[7]="http://gameshow.toplista.pl/?we=kt1";
$link[8]="http://rpg.topka.pl/?we=kt1";
$link[9]="http://bastion.toplista.info/?we=kt1";
$link[10]="http://coolrpg.topka.pl/?we=kt1";
if(!isset($_GET['id'])) 
	die("Nieprawidlowy link");
$no=$_GET['id'];
if($no<0 || $no>count($link))
	die("Nieprawidlowy link");
	
	//var_dump( $_SESSION );


$player = $_SESSION['player'];
//$id=$db->Execute("SELECT id FROM players WHERE email='{$_SESSION['email']}'");
$lista=$db->Execute("SELECT * FROM toplista WHERE id={$player->id}")or die("kicha");
if(!$lista->fields['id']) {
	$sql="INSERT INTO toplista(id,total,`{$no}v`) VALUES ({$_SESSION['player']->id},1,'Y')";
	//echo "$sql <BR>";
	$db->Execute($sql)or die("Blad ! Nie moge wykonac zapytania <b>$sql</b><br>Poinformuj architekta !");
}
else {
	if($lista->fields["{$no}v"]=='N') {
		$sql="UPDATE toplista SET `total`=`total`+1, `{$no}v`='Y' WHERE id={$_SESSION['player']->id}";
		//echo "$sql <BR>";
		$db->Execute($sql)or die("Blad ! Nie moge wykonac zapytania <b>$sql</b><br>Poinformuj architekta !");
	}
}
$db->Close();

header("Location: {$link[$no]}");
die("reDirect to {$link[$no]}");
*/

function sql2arr( $resArr ) {
	$tab = array();
	foreach( $resArr as $f ) {
		if( $f['sub'] ) {
			$tab[ $f['key'] ][ $f['sub'] ] = $f['value'];
		}
		else if( $f['key'] ) {
			$tab[ $f['key'] ] = $f['value'];
		}

	}
	return $tab;
}

if(!isset($_GET['id'])) {
	$db->Close();
	die("Nieprawidlowy link");
}

$test = SqlExec( "SELECT * FROM toplista_entries WHERE id={$_GET['id']}" );
$test = array_shift( $test -> GetArray() );
if( !$test['id'] ) {
	$db->Close();
	die( "Nie ma takiej toplisty" );
}
$player =& $_SESSION['player'];
$vote = SqlExec( "SELECT * FROM toplista WHERE pid={$player->id}" );
$vote = $vote -> GEtArray();
$vote = sql2arr( $vote );
//qDebug( print_r( $vote, true ) );
//die();

if( empty( $vote['vote'][$_GET['id']] ) ) {
	SqlExec( "INSERT INTO toplista( `pid`, `key`, `sub`, `value` ) VALUES( '{$player->id}', 'vote', '{$_GET['id']}', 'Y')" );
	if( !isset( $vote['total'] ) ) {
		SqlExec( "INSERT INTO toplista( `pid`, `key`, `value` ) VALUES( '{$player->id}', 'total', '0' )" );
	}
	else {
		SqlExec( "UPDATE toplista SET value=value+1 WHERE pid='{$player->id}' AND `key`='total'" );
	}
}

$db->Close();

header("Location: {$test['link']}");
die("reDirect to {$test['link']}");
?>