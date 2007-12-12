<?php
//@type: F
//@desc: Place

$title = "P³ace";
require_once("includes/head.php");




//inicjalizacja zmiennych
if (!isset($_GET['pokoj'])) {
    $_GET['pokoj'] = '';
}
if (!isset($_GET['step'])) {
    $_GET['step'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony

$smarty -> display ('place.tpl');

require_once("includes/foot.php"); 
?>
