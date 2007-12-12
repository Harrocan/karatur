<?php
$title = "ogloszenia";
require_once("includes/head.php");

if (!isset ($_GET['view'])) {
$upd = $db -> SelectLimit("SELECT * FROM ogloszenia ORDER BY id DESC", 12);
if ($player -> rank == 'Admin') {
$modtext = "(<a href=sprw.php?modify=".$upd -> fields['id'].">Zmien</a>)";
} else {
$modtext = '';
}
$smarty -> assign ( array("Title1" => $upd -> fields['title'], "Starter" => $upd -> fields['starter'], "Update" => $upd -> fields['sprawy'], "Modtext" => $modtext)); 
} else {
$upd = $db -> SelectLimit("SELECT * FROM ogloszenia ORDER BY id DESC", 12);
$arrtitle = array();
$arrstarter = array();
$arrnews = array();
$arrmodtext = array();
$i = 0; 
while (!$upd -> EOF) {
if ($player -> rank == 'Admin') {
$arrmodtext[$i] = "(<a href=sprw.php?modify=".$upd -> fields['id'].">Zmien</a>)";
} else {
$arrmodtext[$i] = '';
}
$arrtitle[$i] = $upd -> fields['title'];
$arrstarter[$i] = $upd -> fields['starter'];
$arrnews[$i] = $upd -> fields['ogloszenia'];
$upd -> MoveNext();
$i = $i + 1; 
}
$upd -> Close();
$smarty -> assign ( array("Title1" => $arrtitle, "Starter" => $arrstarter, "Update" => $arrnews, "Modtext" => $arrmodtext)); 
}
//inicjalizacja zmiennej
if (!isset($_GET['view'])) {
$_GET['view'] = '';
}

//przypisanie zmiennej oraz wyswietlenie strony
$smarty -> assign ("View", $_GET['view']);
$smarty -> display ('spr.tpl');

require_once("includes/foot.php");
?>
