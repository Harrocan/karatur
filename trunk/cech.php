<?php
//@type: F
//@desc: Dom cechowy
$title = "Dom Cechowy";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);
/*
if ($player -> location != 'Athkatla') {
	error ("Zapomnij o tym");

}*/

$smarty -> display ('cech.tpl');

require_once("includes/foot.php");
?>

