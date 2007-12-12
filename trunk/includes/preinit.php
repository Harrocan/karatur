<?php

/**
 *   Preinitalization of all connections
 *
 *   @name                 : preinit.php
 *   @copyright            : (C) 2006-2007 KaraTur
 *   @author               : IvaN <ivan-q@o2.pl>
 *   @version              : 0.3
 *   @since                : 25.06.2007
 *
 */

//header("Content-Type: text/html; charset=ISO-8859-2");

$phpver = phpversion();
$useragent = (isset($_SERVER["HTTP_USER_AGENT"]) ) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;
$start_time = microtime();


require_once('includes/config.php');
require_once('includes/globalfunctions.php');
require_once('libs/Smarty.class.php');

$KT_CONFIG = array();
$KT_CONFIG['display']['header'] = false;
$KT_CONFIG['display']['footer'] = false;

function makeHeader() {
	global $smarty, $Overfg, $Overbg, $_preInit, $player, $db, $title, $gamename, $gameadress,$js_onLoad;
	global $KT_CONFIG;
	if( $KT_CONFIG['display']['header'] ) {
		return;
	}
	require_once( 'includes/head.php' );
	$KT_CONFIG['display']['header'] = true;
}

function makeFooter() {
	global $smarty, $Overfg, $Overbg, $_preInit, $player, $db, $start_time;
	global $KT_CONFIG;
	if( $KT_CONFIG['display']['footer'] ) {
		return;
	}
	require_once( 'includes/foot.php' );
	$KT_CONFIG['display']['footer'] = true;
}

function throwError( $msgType, $msgTitle = NULL ) {
	global $smarty, $Overfg, $Overbg, $_preInit, $player, $db, $title, $gamename, $gameadress;
	//$smarty -> display('head.tpl');
	$errArray = array( "SESS_EXP" => array ( 'title' => "Sesja zakonczona", 'msg' => 'Twoja sesja wygasla ! Musisz zalogowac sie ponownie !' ),
					   "WRONG_LOGIN" => array( 'title' => "Blad przy logowaniu", 'msg' => "Nieprawidlowe dane przy logowaniu ! Sprawdz login i haslo raz jeszcze." ),
					   "RESET" => array( 'title' => 'Reset', 'msg' => "Prosze czekac, trwa wykonywanie restu." ),
					   "BANNED" => array( 'title' => "Banicja", 'msg' => "Poniewaz zostales zbanowany, nie masz dostepu do gry !" ) );
	if( !empty( $errArray[ $msgType ] ) ) {
		$errData = $errArray[$msgType];
	}
	else {
		$errData = array( 'title' => ( isset( $msgTitle )? $msgTitle: "Uwaga" ), 'msg' => $msgType );
	}
	$smarty->assign( array( "Error" => $errData,
							"Gamename" => $gamename,
							"Gameadress" => $gameadress ) );
	//qDebug( $_SERVER );
	$smarty -> display('errPage.tpl');
	if( $db ) {
		$db -> Close();
	}
	die();
}

$smarty = new Smarty;
$smarty-> compile_check = true;

//$smarty -> debugging = true;

$KT_CONFIG['config']['smarty'] =& $smarty;

$_Ol = array( 'fg' => "#000000", "bg" => "#0C1115", "text" => "#DEB887" );
$KT_CONFIG['display']['overlib'] = $_Ol;
$KT_CONFIG['display']['page_title'] = true;

$KT_CONFIG['rewriter']['tags'] = array( 'a' => 'href', 'form' => 'action' );

$Overtextcolor = $_Ol['text'];
$Overfg = $_Ol['fg'];
$Overbg = $_Ol['bg'];

$smarty -> assign( array( "Overtextcolor" => $Overtextcolor, "Overfg" => $Overfg, "Overbg" => $Overbg, "_OL" => $_Ol ) );

if( !$db ) {
	//die( "Nie mozna polaczyc sis z baza danych ! ?adowanie gry wstrzymane" );
	throwError( "Nie mozna po³±czyc siê z baz± danych !<br/>Prosimy od¶wie¿yæ stronê" );
}

require_once('class/player.class.php');
require_once('includes/sessions.php');

$db -> LogSQL();

set_error_handler( 'catcherror' );

$player =& $_SESSION['player'];

ob_start();

$_preInit = true;

if( isset( $player ) ) {
	SqlExec( "UPDATE `test` set `id`={$player->id} WHERE `page`='{$_SERVER['SCRIPT_NAME']}' AND `time`='$_DEBUG_TIME'" );
}

?>