<?php
/**
 *   Funkcje pliku:
 *   Odpoczynek - odzyskiwanie punktow magii w zamian za energie
 *
 *   @name                 : rest.php                            
 *   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 03.01.2005
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

$title = "Odpoczynek"; 
require_once("includes/head.php");

//$cape = $db -> Execute("SELECT power FROM equipment WHERE owner=".$player -> id." AND type='Z' AND status='E'");
//$maxmana = ($player -> inteli + $player -> wisdom);
//$maxmana = $maxmana + (($cape -> fields['power'] / 100) * $maxmana);
//$cape -> Close();
$maxmana = $player -> mana_max;

if (!isset ($_GET['akcja'])) {
    $koszt = ceil(($maxmana - $player -> mana) / 10);
    $smarty -> assign ("Energy", $koszt);
    $smarty -> display ('rest.tpl');
}
if (isset($_GET['akcja']) && $_GET['akcja'] == 'all') {
    if (!isset($_POST['pm']))
    {
        error("Podaj ile punktow magii chcesz odzyskac");
    }
    if (!ereg("^[1-9][0-9]*$", $_POST['pm'])) {
	error ("Zapomnij o tym");
    }
    $energia = $_POST['pm'] / 10;
    $energia = round($energia,"2");
    if ($player -> energy < $energia) {
	error ("Nie masz tyle energii!");
    }
    if ($player -> mana == $maxmana) {
        error ("Nie musisz odpoczywac");
    }
    $zpm = ($_POST['pm'] + $player -> mana);
    if ($zpm > $maxmana) {
	error ("Nie mozesz odzyskac wiecej Punktow Magii niz masz maksymalnie!");
    }
    //$db -> Execute("UPDATE players SET pm=".$zpm." WHERE id=".$player -> id);
	$player -> mana= $zpm;
    //$db -> Execute("UPDATE players SET energy=energy-".$energia." WHERE id=".$player -> id);
	$player -> energy -= $energia;
    error ("Opoczales sobie przez jakis czas i odzyskales ".$_POST['pm']." punkty magii w zamian za ".$energia." energii. <a href=stats.php>Powrot do statystyk</a>");
}

require_once("includes/foot.php");
?>
