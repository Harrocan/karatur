<?php
//@type: F
//@desc: Skarbiec
/***************************************************************************
 *                               skarbiec.php
 *                            -------------------
 *   copyright            : Thoran based on Vallhery ver. 0.6
 *   email                : defman@o2.pl
 *
 ***************************************************************************/

$title = "Skarbiec";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

 
// menu klanu gracza
if ($player -> location == 'Athkatla') {
    $skarbiec = $db -> Execute("SELECT * FROM skarbiec");
    $smarty -> assign ("Name", $skarbiec -> fields['name']);
    if (!isset ($_GET['step'])) {
	$smarty -> assign ( array("Gold" => $skarbiec -> fields['credits'], "Mithril" => $skarbiec -> fields['platinum']));
       $smarty -> assign ( array("Location" => $player -> location));
    }
}

// dotowanie skarbca
    if (isset ($_GET['step']) && $_GET['step'] == 'donate') {
	if (isset ($_GET['step2']) && $_GET['step2'] == 'donate') {
	    if ($_POST['type'] == 'credits') {
	        $dot = 'sztuk zlota';
	    }
	    if ($_POST['type'] == 'platinum') {
		$dot = 'sztuk mithrilu';
	    }

	    if ($_POST['type'] != 'credits' && $_POST['type'] != 'platinum') {
		error ("Zapomnij o tym");
	    }
	    if ($_POST['amount'] > $player -> $_POST['type'] || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	        $smarty -> assign ("Message", "Nie masz wystarczajaco duzo ".$dot.".");
	    } else {
	     $db -> Execute("UPDATE players SET ".$_POST['type']."=".$_POST['type']."-".$_POST['amount']." WHERE id=".$player -> id);
	     $db -> Execute("UPDATE skarbiec set ".$_POST['type']."=".$_POST['type']."+".$_POST['amount']."");
	     $smarty -> assign ("Message", "Dodales do skarbca <b>".$_POST['amount']." ".$dot."</b>.");
	    }
	}
    }

 
// dotacje z panstwa
if (isset($_GET['action']) && $_GET['action'] == 'loan') {
	      if ($player -> rank != "Admin") {
	      error ("Nie jestes Wladca.");
             }

   if (isset ($_GET['step2']) && $_GET['step2'] == 'daj') {

	if (!ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	error ("Zapomnij o tym");
	}
	if ($_POST['currency'] != 'credits' && $_POST['currency'] != 'platinum') {
	error ("Zapomnij o tym");
	}
	if ($_POST['currency'] == 'credits') {
	$poz = 'sztuk zlota';
	}
	if ($_POST['currency'] == 'platinum') {
	$poz = 'sztuk mithrilu';
	}
	if (!$_POST['amount'] || !$_POST['id']) {
	$smarty -> assign ("Message", "Wypelnij wszystkie pola.");
	} else {
       if ($_POST['amount'] > $skarbiec -> fields[$_POST['currency']] || !ereg("^[1-9][0-9]*$", $_POST['amount'])) {
	$smarty -> assign ("Message", "W skarbcu nie ma tyle ".$poz.".");
	} else {
	$db -> Execute("UPDATE players SET ".$_POST['currency']."=".$_POST['currency']."+".$_POST['amount']." WHERE id=".$_POST['id']);
	$db -> Execute("UPDATE skarbiec SET ".$_POST['currency']."=".$_POST['currency']."-".$_POST['amount']."");
	$smarty -> assign ("Message", "Pozyczyles ID ".$_POST['id']." ".$_POST['amount']." ".$poz.".");
	}
}
}
		        
}


           
if (!isset($_GET['step'])) {
    $_GET['step'] = '';
}
if (!isset($_GET['step2'])) {
    $_GET['step2'] = '';
}
if (!isset($_GET['step3'])) {
    $_GET['step3'] = '';
}
if (!isset($_GET['daj'])) {
    $_GET['daj'] = '';
}
if (!isset($_GET['action'])) {
    $_GET['action'] = '';
}
if (!isset($_GET['view'])) {
    $_GET['view'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony


$smarty -> assign( array("View" => $_GET['view'], "Step" => $_GET['step'], "Step2" => $_GET['step2'], "Step3" => $_GET['step3'], "Give" => $_GET['daj'], "Action" => $_GET['action']));
$smarty -> display('skarbiec.tpl');

require_once("includes/foot.php");
?>
