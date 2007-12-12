<?php
//@type: F
//@desc: Sklep z rybami

$title = "Sklep z Rybami";
require_once("includes/head.php");
checklocation($_SERVER['SCRIPT_NAME']);
$price = rand(100,200);
if (!isset ($_GET['action'])) {
    $smarty -> assign ("Price", $price);
    $smarty -> display ('ttshop.tpl');
} 
    else 
{
    $cost = ($_POST['ryby'] * $price);
    if ($cost > $player -> gold || $_POST['ryby'] <= 0 || !ereg("^[1-9][0-9]*$", $_POST['ryby'])) {
        error ("Nie stac cie! (<a href=ttshop.php>wroc</a>)");
    } 
        else 
    {
        //$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
        //$db -> Execute("UPDATE players SET ryby=ryby+".$_POST['ryby']." WHERE id=".$player -> id);
		$player -> gold -= $cost;
		$player -> fish += $_POST['ryby'];
        error ("Kupiles <b>".$_POST['ryby']."</b> sztuk ryb za <b>".$cost."</b> sztuk zlota.");
    }
}
require_once("includes/foot.php");
?>

