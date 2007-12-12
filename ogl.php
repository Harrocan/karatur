<?php
//@type: F
//@desc: Tablica og³oszeñ

$title = "Tablica Ogloszen";
require_once("includes/head.php");


checklocation($_SERVER['SCRIPT_NAME']);

if (!isset($_GET['step'])) {
    $_GET['step'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Step" => $_GET['step']));
$smarty -> display ('ogl.tpl');

require_once("includes/foot.php"); 
?>
