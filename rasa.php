<?php
$title = "Wybierz rase";
require_once("includes/head.php");

if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'czlowiek' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Czlowiek' WHERE id=".$player -> id);
	$player -> race = 'Czlowiek';
	error ("<br>Wybrales rase ludzka. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'elf' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Elf' WHERE id=".$player -> id);
	$player -> race = 'Elf';
	error ("<br>Wybrales rase Elfow. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'elf_sloneczny' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Elf Sloneczny' WHERE id=".$player -> id);
	$player -> race = 'Elf Sloneczny';
	error ("<br>Wybrales rase Slonecznych Elfow. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['rasa']) && $_GET['rasa'] == 'krasnolud' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Krasnolud' WHERE id=".$player -> id);
	$player -> race = 'Krasnolud';
	error ("<br>Wybrales rase Krasnoludow. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['rasa']) && $_GET['rasa'] == 'hobbit' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Hobbit' WHERE id=".$player -> id);
	$player -> race = 'Hobbit';
	error ("<br>Wybrales rase Hobbitow. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['rasa']) && $_GET['rasa'] == 'reptilion' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Jaszczuroczlek' WHERE id=".$player -> id);
	$player -> race = 'Jaszczuroczlek';
	error ("<br>Wybrales rase Jaszczuroludzi. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'Drow' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Drow' WHERE id=".$player -> id);
	$player -> race = 'Drow';
	error ("<br>Wybrales rase Drowia. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}


if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'Nieumarly' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Nieumarly' WHERE id=".$player -> id);
	$player -> race = 'Nieumarly';
	error ("<br>Wybrales rase nieumarlych. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}


if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'Wampir' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Wampir' WHERE id=".$player -> id);
	$player -> race = 'Wampir';
	error ("<br>Wybrales rase Wampirza. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}


if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'Wilkolak' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Wilkolak' WHERE id=".$player -> id);
	$player -> race = 'Wilkolak';
	error ("<br>Wybrales rase Wilkolakow. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}


if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'Kurtr' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Kurtr' WHERE id=".$player -> id);
	$player -> race = 'Kurtr';
	error ("<br>Wybrales rase Kurtrow. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}


if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'Polelf' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Polelf' WHERE id=".$player -> id);
	$player -> race = 'Polelf';
	error ("<br>Wybrales rase polelfowa. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}


if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'Polork' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Polork' WHERE id=".$player -> id);
	$player -> race = 'Polork';
	error ("<br>Wybrales rase Polorkow. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}


if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'Nimfa' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Nimfa' WHERE id=".$player -> id);
	$player -> race = 'Nimfa';
	error ("<br>Wybrales rase Nimf. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}


if (isset($_GET['rasa']) && isset ($_GET['rasa']) && $_GET['rasa'] == 'Smokokrwisty' && $player -> race == '') {
    if (isset ($_GET['step']) && $_GET['step'] == 'wybierz' && $player -> race == '') {
	//$db -> Execute("UPDATE players SET rasa='Smokokrwisty' WHERE id=".$player -> id);
	$player -> race = 'Smokokrwisty';
	error ("<br>Wybrales rase smokokrwistych. Kliknij <a href=stats.php>tutaj</a> aby wrocic.");
    }
}

//inicjalizacja zmiennej
if (!isset($_GET['rasa'])) {
    $_GET['rasa'] = '';
}

// przypisanie zmiennej i wyswietlenie strony
$smarty -> assign("Race", $_GET['rasa']);
$smarty -> display('rasa.tpl');

require_once("includes/foot.php");
?>
