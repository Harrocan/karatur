<?php
//@type: F
//@desc: Baszta najemników
$title = "Baszta Najemnikow";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

error( "Baszta zamknieta. Najemnicy sie skonczyli" );

// przypisanie zmiennej
$smarty -> assign("Avatar", '', "Cost", $cost);
$cost = ($player -> level * 10000);

//przyznawanie immunitetu bitewnego duzego
if (isset ($_GET['view']) && $_GET['view'] == "immu1") {
if (isset ($_GET['step']) && $_GET['step'] == 'yes') {
if ($player -> immunited == 'Y') {
error ("Posiadasz juz immunitet!");
}
if ($player -> credits < $cost) {
error ("Nie masz tyle pieniedzy!");
}
if ($player -> clas == '') {
error ("Musisz najpierw wybrac klase postaci");
}
$db -> Execute("UPDATE players SET immu1='Y' WHERE id=".$player -> id);
$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
}
}
//przyznawanie immunitetu bitewnego malego
if (isset ($_GET['view']) && $_GET['view'] == "immu3") {
if (isset ($_GET['step']) && $_GET['step'] == 'yes') {
if ($player -> immunited == 'Y') {
error ("Posiadasz juz immunitet!");
}
if ($player -> credits < $cost) {
error ("Nie masz tyle pieniedzy!");
}
if ($player -> clas == '') {
error ("Musisz najpierw wybrac klase postaci");
}
$db -> Execute("UPDATE players SET immu3='Y' WHERE id=".$player -> id);
$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
}
}


//inicjalizacja zmiennych
if (!isset($_GET['view'])) {
$_GET['view'] = '';
}
if (!isset($_GET['step'])) {
$_GET['step'] = '';
}
//przypisanie zmiennych i wyswietlenie strony
$smarty -> assign (array ("View" => $_GET['view'], "Step" => $_GET['step']));
$smarty -> display('baszta.tpl');
require_once("includes/foot.php");
$db -> Close();
?>

