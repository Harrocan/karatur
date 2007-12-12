<?php
/***************************************************************************
 *                               reset.php
 *                            -------------------
 *   copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
 *   email                : thindil@users.sourceforge.net
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
 * '86.111.200.18'
 ***************************************************************************/ 

require_once("includes/config.php");
require_once('includes/resets.php');

if ($_SERVER['REMOTE_ADDR'] != '70.84.0.52')
{
	die("Ciekawe co chciales tutaj zrobic? ".$_SERVER['REMOTE_ADDR']." 70.84.0.52");
}

if ($_GET['step'] == 'reset') {
	echo "wykonywanie duzego resetu <br>";
    mainreset();
    $db->Close();
    exit;
}
if ($_GET['step'] == 'revive') {
	echo "wykonywanie malego resetu<br>";
    smallreset();
    $db->Close();
    exit;
}
echo "cos nie tak";
?>
