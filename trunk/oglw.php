<?php
$title = "Dodaj Ogloszenie";
require_once("includes/head.php");
if ($player -> location != "Athkatla") {
error ("Nie masz prawa przebywac tutaj.");
}

$smarty -> assign ( array("Button" => "Dodaj ogloszenie", "Link" => "oglw.php?action=add"));

// dodawanie nowej wiesci
if (isset ($_GET['action']) && $_GET['action'] == 'add') {

if (empty($_POST['addtitle']) || empty($_POST['oglw'])) {
error ("Wypelnij wszystkie pola.");
}
$_POST['oglw'] = nl2br($_POST['oglw']);
$db -> Execute("INSERT INTO ogloszenia (starter, title, ogloszenia) VALUES('(".$player->user.")','".$_POST['addtitle']."','".$_POST['oglw']."')") or error("Wystapil blad przy dodawaniu ogloszenia");
error ("Ogloszenie dodane.");
}

// modifikacja wiesci
if (isset ($_GET['modify'])) {
if (!ereg("^[1-9][0-9]*$", $_GET['modify'])) {
error ("Zapomnij o tym!");
}
$update = $db -> Execute("SELECT * FROM updates WHERE id=".$_GET['modify']);
$smarty -> assign ( array("Title1" => $update -> fields['title'], "Text" => $update -> fields['ogloszenia'], "Button" => "Modyfikuj", "Link" => "oglw.php?action=modify&updid=".$update -> fields['id']));
$update -> Close();
}

//zapisywanie modyfikacji istniejacej wiadomosci
if (isset ($_GET['action']) && $_GET['action'] == 'modify') {
if (empty($_POST['addtitle']) || empty($_POST['oglw'])) {
error ("Wypelnij wszystkie pola.");
}
if (!ereg("^[1-9][0-9]*$", $_GET['updid'])) {
error ("Zapomnij o tym!");
}
$uid = $db -> Execute("SELECT id FROM updates WHERE id=".$_GET['updid']);
if ($uid -> fields['id']) {
$_POST['oglw'] = nl2br($_POST['oglw']); 
$db -> Execute("UPDATE ogloszenia SET title='".$_POST['addtitle']."' WHERE id=".$_GET['updid']);
$db -> Execute("UPDATE ogloszenia SET ogloszenia='".$_POST['oglw']."' WHERE id=".$_GET['updid']);
error ("Ogloszenie zmodyfikowana.");
} else {
error ("Nie ma takiej wiadomosci!");
}
$uid -> Close();
}

$smarty -> display('oglw.tpl');

require_once("includes/foot.php");
?>






i oglw.tpl:
