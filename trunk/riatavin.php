<?php


/*!
 * Plik wygenerowany przez skrypt tworzenia miast
 * (C) 2006-2007 Kara-Tur Team - Wszelkie prawa zastrzerzone
 *
 * @author IvaN <ivan-q@o2.pl>
 * @version 0.2
 * @since 10.12.2006
 */


$title="Riatavin";
require_once('includes/head.php');

if($player->location != 'Riatavin')
	error('Nie znajdujesz sie w miescie !','error','mapa.php');

$smarty->display('riatavin.tpl');
require_once('includes/foot.php');
?>