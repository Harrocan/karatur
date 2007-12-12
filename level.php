<?php

require_once( "includes/preinit.php" );

$title = "Poziomy";
$js_onLoad = "init();";
makeHeader();

if( $player->level_id == 0 ) {
	error( "Nie jestes na ¿adnej mapie !", 'error', 'city.php' );
}

//qDebug( $_SERVER );

//$startData = array_combine( array( 'lid', 'lx', 'ly' ), array( $player->level_id, $player->level_))
//$smarty->assign( 'PlLvl', $player->level_id );

$smarty->display( 'level.tpl' );

makeFooter();

?>