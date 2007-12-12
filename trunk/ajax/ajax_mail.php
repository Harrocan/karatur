<?php

//echo "bitch !";\
require_once( 'ajax_base.php' );

if( empty( $_POST ) ) {
	die ();
}

if( empty( $_SESSION['player'] ) ) {
	//err( "SESS_EXPIRE" );
	die();
}

$player =& $_SESSION['player'];

switch( $_POST['action'] ) {
	case 'markRead' :
		if( empty( $_POST['mid'] ) ) {
			die();
		}
		//echo "marking read msg " . $_POST['mid'];
		$test = SqlExec( "SELECT id FROM mail WHERE owner={$player->id} AND id={$_POST['mid']}" );
		if( empty( $test->fields['id'] ) ) {
			die();
		}
		SqlExec( "UPDATE mail SET new='N' WHERE id={$test->fields['id']}" );
		echo "ok";
		break;
}

?>