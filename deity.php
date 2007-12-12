<?php
/***************************************************************************
 *                               deity.php
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

$title = "Wybierz wyznanie";
require_once("includes/head.php");

$smarty -> assign( "God", "" );

if (isset ($_GET['deity']) && $player -> deity == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> deity == '') {
		if( in_array( $_GET['deity'], 
						array('lathander','tempus','selune','mystra','tyr','bane','lolth','shar','maska','talos'))) {
		//$db -> Execute("UPDATE players SET deity='Lathander' WHERE id=".$player -> id);
			$player -> deity = ucfirst( $_GET['deity'] );
			$smarty -> assign ("God", ucfirst( $_GET['deity'] ) );
		}
    }
}

//inicjalizacja zmiennych
if (!isset($_GET['deity'])) {
    $_GET['deity'] = '';
}
if (!isset($_GET['step'])) {
    $_GET['step'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Deity" => $_GET['deity'], "Step" => $_GET['step'], "Pldeity" => $player -> deity));
$smarty -> display ('deity.tpl');

require_once("includes/foot.php"); 
?>
