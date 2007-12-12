<?php
$title = "Spis Lowcow";
require_once("includes/head.php");
if ($player -> location != 'Athkatla' ) {
error ("Zapomnij o tym");
}

if ($player -> location == 'Athkatla') {
$prisoner = $db->Execute("select * from players where klasa='Lowca' order by level asc");
$number = $prisoner->RecordCount();
$smarty -> assign ("Number", $number);
if ($number > 0) {
$arrid = array();
$arrname = array();
$arrlevel = array();
$i = 0;
while (!$prisoner->EOF) {
$arrid[$i] = $prisoner->fields['id'];
$arrname[$i] = $prisoner->fields['user'];
$arrlevel[$i] = $prisoner->fields['level'];
$prisoner->MoveNext();
$i = $i + 1;
}
$smarty -> assign ( array("Id" => $arrid, "Name" => $arrname, "Level" => $arrlevel));
}
}

$smarty -> assign ( array("Location" => $player -> location));
$smarty -> display ('low.tpl');

require_once("includes/foot.php");
?>

