<?php
//@type: F
//@desc: Sklep z mithrilem
/**
*   Funkcje pliku:
*   Sklep z mithrilem - zakup mithrilu przez graczy
*
*   @name                 : pshop.php                            
*   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
*   @author               : thindil <thindil@users.sourceforge.net>
*   @version              : 0.7 beta
*   @since                : 26.01.2005
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

$title = "Sklep z mithrilem";
require_once("includes/head.php");

if ($player -> location != 'Imnescar') {
	error ("Zapomnij o tym");
}

$price = $db -> Execute("SELECT value FROM settings WHERE setting='mithcost'");
if (!isset ($_GET['action'])) {
	$smarty -> assign ("Price", $price -> fields['value']);
	$smarty -> display ('pshop.tpl');
} 
	else 
{
	$cost = ($_POST['plat'] * $price -> fields['value']);
	if ($cost > $player -> gold || $_POST['plat'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['plat'])) {
		error ("Nie stac cie! (<a href=pshop.php>wroc</a>)");
	} 
	else 
	{
		//$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET platinum=platinum+".$_POST['plat']." WHERE id=".$player -> id);
		$player -> gold -= $cost;
		$player -> mithril += $_POST['plat'];
		error ("Kupiles <b>".$_POST['plat']."</b> sztuk mithrilu za <b>".$cost."</b> sztuk zlota.",'done');
	}
}
$price -> Close();

require_once("includes/foot.php");
?>

