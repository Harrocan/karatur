<?php
/***************************************************************************
 *                               addnews.php
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

$title = "Dodaj Plotke"; 
require_once("includes/head.php");
if ($_SESSION['rank']['news']!='1')
	error("Nie masz uprawnieñ aby tu przebywaæ !");

$smarty -> display('addnews.tpl');

if (isset ($_GET['action']) && $_GET['action'] == 'add') {
	if (empty ($_POST['addtitle']) || empty ($_POST['addnews'])) {
		error ("Wypelnij wszystkie pola.");
	}
	$_POST['addnews'] = nl2br($_POST['addnews']);	
	$db -> Execute("INSERT INTO news (starter, title, news) VALUES('".$player -> user." (".$player -> id.")','".$_POST['addtitle']."','".$_POST['addnews']."')") or error("Nie moge dodac plotki.");
	error ("Plotka dodana.",'done');
}

require_once("includes/foot.php");
?>

