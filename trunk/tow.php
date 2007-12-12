<?php

$title = "Wybierz swego zwierzecego towarzysza";
require_once("includes/head.php");

$old = $player -> RawReturn ;
$player -> RawReturn = true;

if (isset($_GET['tow']) && isset ($_GET['tow']) && $_GET['tow'] == 'sokol' && $player -> tow == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> tow == '') {
	//$db -> Execute("UPDATE players SET szyb=szyb+5 WHERE id=".$player -> id);
	//$db -> Execute("UPDATE players SET tow='Sokol' WHERE id=".$player -> id);
	$player -> spd += 5;
	$player -> tow = 'Sokol';
	error ("<br>Wybrales jako zwierzecego towarzysza Sokola. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['tow']) && isset ($_GET['tow']) && $_GET['tow'] == 'lasica' && $player -> tow == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> tow == '') {
// 	$db -> Execute("UPDATE players SET agility=agility+5 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET tow='Lasica' WHERE id=".$player -> id);
	$player -> dex += 5;
	$player -> tow = 'Lasica';
	error ("<br>Wybrales jako zwierzecego towarzysza Lasice. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['tow']) && isset ($_GET['tow']) && $_GET['tow'] == 'szczur' && $player -> tow == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> tow == '') {
// 	$db -> Execute("UPDATE players SET wytrz=wytrz+5 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET tow='Szczur' WHERE id=".$player -> id);
	$player -> con += 5;
	$player -> tow = 'Szczur';
	error ("<br>Wybrales jako zwierzecego towarzysza Szczura. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['tow']) && isset ($_GET['tow']) && $_GET['tow'] == 'pies' && $player -> tow == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> tow == '') {
// 	$db -> Execute("UPDATE players SET strength=strength+5 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET tow='Pies' WHERE id=".$player -> id);
	$player -> str += 5;
	$player -> tow = 'Pies';
	error ("<br>Wybrales jako zwierzecego towarzysza Psa. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['tow']) && isset ($_GET['tow']) && $_GET['tow'] == 'kot' && $player -> tow == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> tow == '') {
// 	$db -> Execute("UPDATE players SET inteli=inteli+5 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET tow='Kot' WHERE id=".$player -> id);
	$player -> int += 5;
	$player -> tow = 'Kot';
	error ("<br>Wybrales jako zwierzecego towarzysza Kota. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['tow']) && isset ($_GET['tow']) && $_GET['tow'] == 'pseldosmok' && $player -> tow == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> tow == '') {
// 	$db -> Execute("UPDATE players SET wisdom=wisdom+5 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET tow='Pseldosmok' WHERE id=".$player -> id);
	$player -> wis += 5;
	$player -> tow = 'Pseldosmok';
	error ("<br>Wybrales jako zwierzecego towarzysza Pseldosmoka. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['tow']) && isset ($_GET['tow']) && $_GET['tow'] == 'waz' && $player -> tow == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> tow == '') {
// 	$db -> Execute("UPDATE players SET strength=strength+1 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET wisdom=wisdom+1 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET inteli=inteli+1 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET szyb=szyb+1 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET wytrz=wytrz+1 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET agility=agility+1 WHERE id=".$player -> id);
// 	$db -> Execute("UPDATE players SET tow='Waz' WHERE id=".$player -> id);
	$player -> str ++;
	$player -> wis ++;
	$player -> int ++;
	$player -> spd ++;
	$player -> con ++;
	$player -> dex ++;
	$player -> tow = 'Waz';
	error ("<br>Wybrales jako zwierzecego towarzysza Weza. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

$player -> RawReturn = $old;

//inicjalizacja zmiennej
if (!isset($_GET['tow'])) {
    $_GET['tow'] = '';
}

// przypisanie zmiennej i wyswietlenie strony
$smarty -> assign("Tow", $_GET['tow']);
$smarty -> display('tow.tpl');

require_once("includes/foot.php");
?>

