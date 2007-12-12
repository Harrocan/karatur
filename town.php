<?php

require_once('includes/config.php');
require_once('includes/globalfunctions.php');
require_once('class/player.class.php');
require_once('includes/sessions.php');

$player =& $_SESSION['player'];

if( $player->file ) {
	require_once( $player->file );
}
else {
	header("Location: mapa.php");
}

?>