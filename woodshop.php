<?php
//@type: F
//@desc: Sklep z drzewkami
/***************************************************************************
 *                               woodshop.php based on pshop.php
 *                            -------------------
 *   copyright            : (C) 2005 by Korson
 *   email                : den4045@o2.pl
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

$title = "Sklep z drzewkami";
require_once("includes/head.php");

if ($player -> location != 'Athkatla') {
	error ("Zapomnij o tym");
}

$price = $db -> Execute("SELECT platcost FROM market");
if (!isset ($_GET['action'])) {
    $smarty -> assign ("Price", $price -> fields['platcost']);
    $smarty -> display ('woodshop.tpl');
} else {
    $cost = ($_POST['plat'] * $price -> fields['platcost']);
    if ($cost > $player -> credits || $_POST['plat'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['plat'])) {
	error ("Nie stac cie! (<a href=woodshop.php>wroc</a>)");
    } else {
	$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
	$db -> Execute("UPDATE kopalnie SET drzewka=drzewka+".$_POST['plat']." WHERE id=".$player -> id);
	error ("Kupiles <b>".$_POST['plat']."</b> sztuk drzewek za <b>".$cost."</b> sztuk zlota.");
    }
}
$price -> Close();

require_once("includes/foot.php");
?>

