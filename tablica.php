<?php
//@type: F
//@desc: Tablica królewska

$title = "Tablica Krolewska";
require_once("includes/head.php");


// wstaw nazwe swego miasta
if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Imnescar') {
	error ("Zapomnij o tym");
}



// przypisanie zmiennych oraz wyswietlenie strony
//$smarty -> assign ( array("Pokoj" => $_GET['pokoj'], "Step" => $_GET['step'], "opis" => $player -> pokoj));
$smarty -> display ('tablica.tpl');

require_once("includes/foot.php"); 
?>
