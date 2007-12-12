<?php
$title = "Wybierz klase";
require_once("includes/head.php");

if (isset ($_GET['klasa']) && $_GET['klasa'] == 'wojownik' && $player -> clas == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> clas == '') {
	//$db -> Execute("UPDATE players SET klasa='Wojownik' WHERE id=".$player -> id);
	$player -> clas = 'Wojownik';
	error ("<br>Wybrales kaste wojownikow.",'done','stats.php');
    }
}

if (isset ($_GET['klasa']) && $_GET['klasa'] == 'mag' && $player -> clas == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> clas == '') {
	//$db -> Execute("UPDATE players SET klasa='Mag' WHERE id=".$player -> id);
	$player -> clas = 'Mag';
	error ("<br>Wybrales kaste magow.",'done','stats.php');
    }
}

if (isset ($_GET['klasa']) && $_GET['klasa'] == 'craftsman' && $player -> clas == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> clas == '') {
	//$db -> Execute("UPDATE players SET klasa='Rzemieslnik' WHERE id=".$player -> id);
	$player -> clas = 'Rzemieslnik';
	error ("<br>Wybrales kaste rzemieslnikow.",'done','stats.php');
    }
}

if (isset ($_GET['klasa']) && $_GET['klasa'] == 'barbarzynca' && $player -> clas == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> clas == '') {
	//$db -> Execute("UPDATE players SET klasa='Barbarzynca' WHERE id=".$player -> id);
	$player -> clas = 'Barbarzynca';
	error ("<br>Wybrales droge barbarzyncy.",'done','stats.php');
    }
}

if (isset ($_GET['klasa']) && $_GET['klasa'] == 'zlodziej' && $player -> clas == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> clas == '') {
	//$db -> Execute("UPDATE players SET klasa='Zlodziej' WHERE id=".$player -> id);
	$player -> clas = 'Zlodziej';
	error ("<br>Wybrales sciezke zlodzieja.",'done','stats.php');
    }
}

if (isset ($_GET['klasa']) && $_GET['klasa'] == 'kaplan' && $player -> clas == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> clas == '') {
	//$db -> Execute("UPDATE players SET klasa='Kaplan' WHERE id=".$player -> id);
	$player -> clas = 'Kaplan';
	error ("<br>Wybrales kreta sciezke kaplana.",'done','stats.php');
    }
}

if (isset ($_GET['klasa']) && $_GET['klasa'] == 'druid' && $player -> clas == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> clas == '') {
	//$db -> Execute("UPDATE players SET klasa='Druid' WHERE id=".$player -> id);
	$player -> clas = 'Druid';
	error ("<br>Wybrales kreta sciezke druida.",'done','stats.php');
    }
}

if (isset ($_GET['klasa']) && $_GET['klasa'] == 'lowca' && $player -> clas == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> clas == '') {
	//$db -> Execute("UPDATE players SET klasa='Lowca' WHERE id=".$player -> id);
	$player -> clas = 'Lowca';
	error ("<br>Wybrales kreta sciezke lowcy.",'done','stats.php');
    }
}
// inicjalizacja zmiennej
if (!isset($_GET['klasa'])) {
    $_GET['klasa'] = '';
}

// przypisanie zmiennej oraz wyswietlenie strony
$smarty -> assign ( array("Clas" => $_GET['klasa'], "Plclass" => $player -> clas));
$smarty -> display ('klasa.tpl');

require_once("includes/foot.php");
?>
