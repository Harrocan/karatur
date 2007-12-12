<?php
/***************************************************************************
 *                               logout.php
 *                            -------------------
 *   copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
 *   email                : webmaster@uc.h4c.pl
 *
 ***************************************************************************/

/***************************************************************************
 *
 *       This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ***************************************************************************/

// require_once ('includes/config.php');
// require_once('class/player.class.php');
// require_once('includes/sessions.php'); 
// require_once('libs/Smarty.class.php');
// 
// 
// $smarty = new Smarty;
// 
// $smarty->compile_check = true;

require_once( "includes/preinit.php" );

if (!ereg("^[1-9][0-9]*$", $_GET['did'])) {
	throwError( "Zapomnij o tym" );
    $smarty -> assign ("Error", "Zapomnij o tym.");
    $smarty -> display ('error.tpl');
    exit;
}

if( !isset( $player ) ) {
	throwError( "SESS_EXP" );
}
//$player = $_SESSION['player'];
//$pass = $_SESSION['pass'];
//$stat = $db -> Execute("SELECT id, fight FROM players WHERE email='".$_SESSION['email']."' AND pass='".$pass."'");
if ($player -> id != $_GET['did']) {
	throwError( "Zapomnij o tym !" );
    $smarty -> assign ("Error", "Zapomnij o tym...");
    $smarty -> display ('error.tpl');
    exit;
}
if ($player -> fight != 0) {
    //$db -> Execute("UPDATE players SET hp=0 WHERE id=".$stat -> fields['id']);
    $player -> hp = 0;
    $player -> fight = 0;
    //$db -> Execute("UPDATE players SET fight=0 WHERE id=".$stat -> fields['id']);
}
//$stat -> Close();
if (isset($_GET['rest']) && $_GET['rest'] == 'Y') {
    $test = $db -> Execute("SELECT id FROM houses WHERE owner=".$_GET['did']);
    $test1 = $db -> Execute("SELECT id FROM houses WHERE locator=".$_GET['did']);
    if (!$test -> fields['id'] && !$test1 -> fields['id']) {
		throwError( "Nie mozesz isc spac !" );
        $smarty -> assign ("Error", "Nie mozesz isc spac.");
        $smarty -> display ('error.tpl');
        exit;
    }
    $test -> Close();
    $test1 -> Close();    
    //$db -> Execute("UPDATE players SET rest='Y' WHERE id=".$_GET['did']);
    $player -> rest = 'Y';
}
//$db -> Execute("UPDATE players SET lpv=lpv-180 WHERE id=".$_GET['did']);
$player -> lpv -= 180;
session_unset();
session_destroy();
throwError( "Wylogowales sie pomyslnie !", "Wylogowanie" );
$smarty -> assign("Gamename", $gamename);
$smarty -> display ('logout.tpl');

