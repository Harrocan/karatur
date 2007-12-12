<?php
//@type: F
//@desc: Ziemniaki
$title = "Farma ziemniakow";
require_once("includes/head.php");
// inicjalizacja zmiennej
$smarty -> assign("Message", '');
//
if (isset ($_GET['action']) && $_GET['action'] == 'kop') {
    if (isset($_GET['dalej'])) {
        if ($_POST['rep'] <= 0) {
            error ("Wpisz ile czasu (energii) chcesz przepracowac na farmie!");
        }
        if (!ereg("^[1-9][0-9]*$", $_POST['rep'])) {
            error ("Zapomnij o tym");
        }
        if ($player -> hp == 0) {
            error ("Nie mozesz kopac poniewaz jestes martwy!");
        }
        $ile = floor( $_POST['rep'] * ( rand( 5, 10 ) / 10 ) );
        if ($player -> energy < $_POST['rep']) {
            error ("Nie masz tyle energii!");
        }
        $smarty -> assign ("Message", "Kopales(as) przez pewien czas i wykopales(as) ".$ile." ziemniakow.");
        //$db -> Execute("UPDATE players SET energy=energy-".$razy." WHERE id=".$player -> id);
        //$db -> Execute("UPDATE players SET ziemniaki=ziemniaki+".$_POST['rep']." WHERE id=".$player -> id);
		$player -> energy -= $_POST['rep'];
		$player -> potato += $ile;
    }
}

// inicjalizacja zmiennej
if (!isset($_GET['action'])) {
    $_GET['action'] = '';
}
// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign( array("Action" => $_GET['action']));
$smarty -> display('ziemniaki.tpl');
require_once("includes/foot.php"); 
?>

