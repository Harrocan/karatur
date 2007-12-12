<?php
//@type: F
//@desc: Gra w ko¶ci
/**
 *   Autorem pliku jest Revolas. Strona domowa: http://team.helgrind.info
 *                                   Gra w karty
 *
 *
 */


$title = "Ko¶ci";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

if (isset ($_GET['view']) && $_GET['view'] == "gram") {
    if (isset ($_GET['step']) && $_GET['step'] == 'dalej') {
$karta = rand(1,6);
$karta2 = ($_POST['karta']);
$strata = ($_POST['karta'])/2;

if ($_POST['ile'] < 0) {
error ("Zapomnij o tym");
}


 if (!$_POST['ile']) {
            error ("Musisz co&#347; postawiæ, aby ze mn&#261; zagra&#263;!");
     }
if ($_POST['ile'] > $player -> credits) {
        error ("Niezagrasz bo niemasz tyle pieniêdzy!");
    }
if ( $karta != $karta2) {
        //$db -> Execute("UPDATE players SET credits=credits-".$_POST['ile']."/1 WHERE id=".$player -> id);
		$player -> gold -= $_POST['ile'];
        error ("Kasjer wygra³. A ty przegra³es pieniadze!"); echo "$karta";
    }
if ($karta = $karta2) {
        //$db -> Execute("UPDATE players SET credits=credits+".$_POST['ile']."/1*2 WHERE id=".$player -> id);
		$player -> gold += $_POST['ile'];

        error ("Wygra³es...  ");

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
$smarty -> display('kosci.tpl');

require_once("includes/foot.php");
$db -> Close();
?>
