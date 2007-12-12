<?php
/**
 *   Funkcje pliku:
 *   Historia swiata oraz pomoc do gry
 *
 *   @name                 : help.php                            
 *   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 04.01.2005
 *
 */

//
//
//       This program is free software; you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation; either version 2 of the License, or
//   (at your option) any later version.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of the GNU General Public License
//   along with this program; if not, write to the Free Software
//   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
// 

$title = "Pomoc";
require_once("includes/head.php");

if($_GET['help']=='new') {
	if($player->newbie=='Y')
		$db->Execute("UPDATE players SET newbie='N' WHERE id=".$player->id);
}

//inicjalizacja zmiennych
if (!isset($_GET['help'])) {
    $_GET['help'] = '';
}
if (!isset($_GET['step'])) {
    $_GET['step'] = '';
}
if (!isset($_GET['step2'])) {
    $_GET['step2'] = '';
}



// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Help" => $_GET['help'], "Step" => $_GET['step'], "Step2" => $_GET['step2'], "Mail" => $adminmail));
$smarty -> display ('help.tpl');

require_once("includes/foot.php");
?>

