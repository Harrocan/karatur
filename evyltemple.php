<?php
//@type: F
//@desc: Plac z³ych bogów
/***************************************************************************
 *                               temple.php
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

$title = "Swiatynia Mrocznych Bogow";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Beregost' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta' && $player -> location != 'Nashkel' && $player -> location != 'Iriaebor') {
	error ("Zapomnij o tym");
}*/

if ($player -> level < 5){
error("Stoj nie wpuscimy cie tutaj poniewa twoj poziom duchowy nie jest zbyt wysoki, wroc tu gdzy bedziesz mial wiecej doswiadczenia i wiekszy poziom a co z tym idzie twoja duchowosc takze wzrosnie do 5  poziomu, tak tez zawroc i przyjdz tu kiedy bedziesz gotow!");
}


// inicjalizacja zmiennej
$smarty -> assign("Message", '');

// inicjalizacja zmiennej
if (!isset($_GET['temp'])) {
    $_GET['temp'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign( array("Temple" => $_GET['temp'], "God" => $player -> deity));
$smarty -> display('evyltemple.tpl');

require_once("includes/foot.php"); 
?>
