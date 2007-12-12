<?php
//@type: F
//@desc: Gra w karty
/**
 *   Autorem pliku jest Revolas. Strona domowa: http://team.helgrind.info
 *                                   Gra w karty
 *
 *
 */


$title = "Karty";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

if (isset ($_GET['view']) && $_GET['view'] == "gram") {
    if (isset ($_GET['step']) && $_GET['step'] == 'dalej') {
$karta = rand(1,4);
$karta2 = ($_POST['karta']);
$strata = ($_POST['karta'])/2;

if ($_POST['ile'] < 0) {
error ("Zapomnij o tym");
}


 if (!$_POST['ile']) {
            error ("Musisz co&#347; postawiæ, aby ze mn&#261; zagra&#263;!");
     }
if ($_POST['ile'] > $player -> credits) {
        error ("O co chcesz gra&#263; jeœli nawet nie masz tyle kasy ile postawi&#322;e&#347; jej!");
    }
if ( $karta != $karta2) {
        //$db -> Execute("UPDATE players SET credits=credits-".$_POST['ile']."/2 WHERE id=".$player -> id);
        $player -> gold -= floor($_POST['ile']/2);
        error ("Heheheh... Wygra&#322;em! Straci&#322;e&#347;"); echo "$karta";
    }
if ($karta == $karta2) {
        //$db -> Execute("UPDATE players SET credits=credits+".$_POST['ile']."/4*3 WHERE id=".$player -> id);
		$player -> gold += floor($_POST['ile']/4);
        error ("Farcia&#380;! Wygra&#322;e&#347;...");

    }
   }
}

//inicjalizacja zmiennych
if (!isset($_GET['view'])) {
    $_GET['view'] = '';
}
if (!isset($_GET['step'])) {
    $_GET['step'] = '';
}

//przypisanie zmiennych i wy¶wietlenie strony
$smarty -> assign (array ("View" => $_GET['view'], "Step" => $_GET['step']));
$smarty -> display('karty.tpl');

require_once("includes/foot.php");
$db -> Close();
?>
