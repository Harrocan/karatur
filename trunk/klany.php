<?php


$title = "Kodeks Klanow na Kara-Tur";
require_once("includes/head.php");

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( "file",$player->file);
$smarty -> display ('klany.tpl');

require_once("includes/foot.php"); 
?>
