<?php

$title = "Arena walk";
require_once( 'includes/head.php');

require_once('class/fighter.class.php');
$fighter = new Fighter_player( 267 );
//$pl = new Fighter_player( 962 );
$fighter2 = new Fighter_player( 460 );

$fighter3 = new Fighter_player( 691 );

for($i=1;$i<=4;$i++) {
	$monster[] = new Fighter_monster( 4, "szczurolak $i" );
}
$monsterp[] = new Fighter_monster( 4, "szczurolak raz" );
$monsterp[] = new Fighter_monster( 4, "szczurolak dwa" );
/*$monster[] = new Fighter_monster( 4 );
$monster[] = new Fighter_monster( 4 );
$monster[] = new Fighter_monster( 4 );
$monster[] = new Fighter_monster( 4 );
$monster[] = new Fighter_monster( 4 );
$monster[] = new Fighter_monster( 4 );*/
//$mon2 = new Fighter_player( 979 );
//echo "<pre>";
require_once('class/battle.class.php');
$battle = new Battle( 'pvm' );

$battle -> FigureAdd( $fighter, 'players' );
$battle -> FigureAdd( $fighter2, 'players' );
$battle -> FigureAdd( $monsterp, 'players' );

//$battle -> FigureAdd( $pl, 'players' );
$battle -> FigureAdd( $monster, 'monster' );
$battle -> FigureAdd( $fighter3, 'monster' );
//$battle -> FigureAdd( $monster[1], 'monster' );
//$battle -> FigureAdd( $monster[2], 'monster' );
//$battle -> FigureAdd( $monster[3], 'monster' );

$battle -> Battle( 2 );

//$battle -> FigureAdd( $mon2, 'monster' );
/*if( $battle -> BattlePrepare() === FALSE ) {
	die( "Blad posczas przygotowywania walki" );
}
do{
	$battle -> RoundPrepare();
	do{
		//echo "test<br>";
		$battle -> TurnBegin();
		$battle -> TurnPrepare( );
		$battle -> TurnAttack( );
		$battle -> TurnEnd( );
	}while( $battle -> roundstatus != B_ROUND_END );
	$battle -> RoundEnd();
} while( $battle -> status != B_BATTLE_END );
//echo "Walka zakonczona !\n";
$battle -> BattleFinish();*/
//echo "</pre>";
require_once('includes/foot.php');
?>