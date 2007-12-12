<?php
$title = "Spis Kaplanow";
require_once("includes/head.php");
if ($player -> location != 'Athkatla' ) {
error ("Zapomnij o tym");
}

if ($player -> location == 'Athkatla') {
$prisoner = mysql_query("select * from players where klasa='Kaplan' order by level asc");
$number = mysql_num_rows($prisoner);
$smarty -> assign ("Number", $number);
if ($number > 0) {
$arrid = array();
$arrname = array();
$arrlevel = array();
$i = 0;
while ($kaplan = mysql_fetch_array($prisoner)) {
$arrid[$i] = $kaplan['id'];
$arrname[$i] = $kaplan['user'];
$arrlevel[$i] = $kaplan['level'];
$i = $i + 1;
}
$smarty -> assign ( array("Id" => $arrid, "Name" => $arrname, "Level" => $arrlevel));
}
}

$smarty -> assign ( array("Location" => $player -> location));
$smarty -> display ('kap.tpl');

require_once("includes/foot.php");
?>

