<?php


$title = "Biblioteka Meavora";
require_once("includes/head.php");


// wstaw nazwe swego miasta
if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza') {
	error ("Zapomnij o tym");
}



// wstaw zamiast 1200 swoja cene * poziom postaci
$cost = ($player -> level * 1200);
$smarty -> assign ("Cost", $cost);



if (isset ($_GET['pokoj']) && $_GET['pokoj'] == 'maly') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz') {
     if ($player -> credits < $cost) {
	    error ("Nie masz tyle pieniedzy!");
    }

		$db -> Execute("UPDATE players SET hotel=hotel+1 WHERE id=".$player -> id);
	$db -> Execute("UPDATE players SET energy=energy+0.5 WHERE id=".$player -> id);
       $db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
       $db -> Execute("UPDATE skarbiec set credits=credits+".$cost." where id=1");

        $smarty -> assign ("pokoj", "maly");

            }
}
// wstaw zamiast 1800 swoja cene * poziom postaci
$cost2 = ($player -> level * 1800);
$smarty -> assign ("Cost2", $cost2);


if (isset ($_GET['pokoj']) && $_GET['pokoj'] == 'sredni' && $player -> pokoj == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> pokoj == '') {
     if ($player -> credits < $cost2) {
	    error ("Nie masz tyle pieniedzy!");
    }

		$db -> Execute("UPDATE players SET hotel=hotel+1 WHERE id=".$player -> id);

	$db -> Execute("UPDATE players SET energy=energy+1 WHERE id=".$player -> id);
    $db -> Execute("UPDATE players SET credits=credits-".$cost2." WHERE id=".$player -> id);
    $db -> Execute("UPDATE skarbiec set credits=credits+".$cost2." where id=1");


	$smarty -> assign ("pokoj", "sredni");
    }
}
// wstaw zamiast 2500 swoja cene * poziom postaci
$cost3 = ($player -> level * 2500);
$smarty -> assign ("Cost3", $cost3);


if (isset ($_GET['pokoj']) && $_GET['pokoj'] == 'duzy' && $player -> pokoj == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> pokoj == '') {
     if ($player -> credits < $cost3) {
	    error ("Nie masz tyle pieniedzy!");
    }

		$db -> Execute("UPDATE players SET hotel=hotel+1 WHERE id=".$player -> id);

	$db -> Execute("UPDATE players SET energy=energy+1.5 WHERE id=".$player -> id);
    $db -> Execute("UPDATE players SET credits=credits-".$cost3." WHERE id=".$player -> id);
    $db -> Execute("UPDATE skarbiec set credits=credits+".$cost3." where id=1");


	$smarty -> assign ("pokoj", "duzy");
    }
}


//inicjalizacja zmiennych
if (!isset($_GET['pokoj'])) {
    $_GET['pokoj'] = '';
}
if (!isset($_GET['step'])) {
    $_GET['step'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("Pokoj" => $_GET['pokoj'], "Step" => $_GET['step'], "opis" => $player -> pokoj));
$smarty -> display ('ksiega.tpl');

require_once("includes/foot.php"); 
?>
