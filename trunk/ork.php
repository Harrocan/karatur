<?php

/**
 *   Funkcje pliku:
 *   Projekt orka
 *
 *   @name                 : ork.php
 *   @copyright            : (C) 2006 Kara-Tur Team based on Vallheru ver 7.0
 *   @author               : Uriel <white.empire@interia.pl>
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

$title = "Ork";
require_once("includes/head.php");

if($player -> location != 'Athkatla') {
    error ("Nie znajdujesz sie w miescie");
}

$smarty -> display ('ork.tpl');

require_once("includes/foot.php");
?>

