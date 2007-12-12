<?php
/***************************************************************************
 *                               mines.php
 *                            -------------------
 *   copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
 *   email                : thindil@users.sourceforge.net
 *
 ***************************************************************************/

/***************************************************************************
 *
 *       This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ***************************************************************************/

$title = "Kopalnie";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Imnescar') {
	error ("Zapomnij o tym");
}*/

$kopalnie = $db -> Execute("select id, mcopper, kzel, kweg, copper, zelazo, wegiel, ops FROM kopalnie WHERE gracz=".$player -> id);
if (!$kopalnie -> fields['id']) {
    $smarty -> assign("Mines", 0);
} else {
    $smarty -> assign("Mines", 1);
}

if (isset ($_GET['kup']) && $_GET['kup'] == 'miedz') {
	error("Niestety ale kopalnia wyczerpana ... musisz szukaæ miejsc na nowe z³o¿a gdzie indziej ... tyle gór jest w okolicy");
    if ($player -> platinum < 25) {
	error ("Nie masz wystarczajaco duzo sztuk mithrilu.");
    } else {
	$db -> Execute("UPDATE players SET platinum=platinum-25 WHERE id=".$player -> id);
        if (!$kopalnie -> fields['id']) {
	    $db -> Execute("INSERT INTO kopalnie (gracz, mcopper) VALUES(".$player -> id.",1)") or error("Nie moge dodac kopalni");
	} else {
	    $db -> Execute("UPDATE kopalnie SET mcopper=1 WHERE gracz=".$player -> id);
	}
	error ("Kupiles kopalnie miedzi! Kliknij <a href=mines.php>tutaj</a>.");
    }
}

if (isset ($_GET['kup']) && $_GET['kup'] == 'zelaz') {
	error("Niestety ale kopalnia wyczerpana ... musisz szukaæ miejsc na nowe z³o¿a gdzie indziej ... tyle gór jest w okolicy");
    if ($player -> platinum < 50) {
	error ("Nie masz wystarczajaco duzo sztuk mithrilu.");
    } else {
	$db -> Execute("UPDATE players SET platinum=platinum-50 WHERE id=".$player -> id);
	if (!$kopalnie -> fields['id']) {
	    $db -> Execute("INSERT INTO kopalnie (gracz, kzel) VALUES(".$player -> id.",1)");
	} else {
	    $db -> Execute("UPDATE kopalnie SET kzel=1 WHERE gracz=".$player -> id);
	}
	error ("Kupiles kopalnie zelaza! Kliknij <a href=mines.php>tutaj</a>.");
    }
}

if (isset ($_GET['kup']) && $_GET['kup'] == 'wegie') {
	error("Niestety ale kopalnia wyczerpana ... musisz szukaæ miejsc na nowe z³o¿a gdzie indziej ... tyle gór jest w okolicy");
    if ($player -> platinum < 75) {
	error ("Nie masz wystarczajaco duzo sztuk mithrilu.");
    } else {
	$db -> Execute("UPDATE players SET platinum=platinum-75 WHERE id=".$player -> id);
	if (!$kopalnie -> fields['id']) {
	    $db -> Execute("INSERT INTO kopalnie (gracz, kweg) VALUES(".$player -> id.",1)");
	} else {
	    $db -> Execute("UPDATE kopalnie SET kweg=1 WHERE gracz=".$player -> id);
	}
	error ("Kupiles kopalnie wegla! Kliknij <a href=mines.php>tutaj</a>.");
    }
}

if (isset ($_GET['view']) && $_GET['view'] == 'stats') {
    $smarty -> assign ( array("Mcopper" => $kopalnie -> fields['mcopper'], "Miron" => $kopalnie -> fields['kzel'], "Mcoal" => $kopalnie -> fields['kweg'], "Ops" => $kopalnie -> fields['ops'], "Coal" => $kopalnie -> fields['wegiel'], "Iron" => $kopalnie -> fields['zelazo'], "Copper" => $kopalnie -> fields['copper']));
}

if (isset ($_GET['view']) && $_GET['view'] == 'shop') {
	error("Niestety ale kopalnia wyczerpana ... musisz szukaæ miejsc na nowe z³o¿a gdzie indziej ... tyle gór jest w okolicy");
    $minen = ($kopalnie -> fields['mcopper'] * 5000);
    $zelazo = ($kopalnie -> fields['kzel'] * 10000);
    $wegiel = ($kopalnie -> fields['kweg'] * 15000);
    if ($kopalnie -> fields['mcopper'] > 0) {
        $smarty -> assign ("Mcopper", "<li><a href=mines.php?view=shop&buy=mine&rodz=mcopper>1 obszar wiecej kopalni miedzi</a> (".$minen." sztuk zlota)</li>");
    } else {
        $smarty -> assign ("Mcopper", "<li><a href=mines.php?kup=miedz>Kopalna miedzi - 25 sztuk mithrilu</a></li>");
    }
    if ($kopalnie -> fields['kzel'] > 0) {
        $smarty -> assign ("Miron", "<li><a href=mines.php?view=shop&buy=mine&rodz=kzel>1 obszar wiecej kopalni zelaza</a> (".$zelazo." sztuk zlota)</li>");
    } else {
        $smarty -> assign ("Miron", "<li><a href=mines.php?kup=zelaz>Kopalna zelaza - 50 sztuk mithrilu</a></li>");
    }
    if ($kopalnie -> fields['kweg'] > 0) {
        $smarty -> assign ("Mcoal", "<li><a href=mines.php?view=shop&buy=mine&rodz=kweg>1 obszar wiecej kopalni wegla</a> (".$wegiel." sztuk zlota)</li>");
    } else {
        $smarty -> assign ("Mcoal", "<li><a href=mines.php?kup=wegie>Kopalnia wegla - 75 sztuk mithrilu</a></li>");
    }
    if (isset ($_GET['buy']) && $_GET['buy'] == 'mine') {
		if ($_GET['rodz'] != 'mcopper' && $_GET['rodz'] != 'kzel' && $_GET['rodz'] != 'kweg') {
			error ("Zapomnij o tym");
		}
		if ($_GET['rodz'] == 'mcopper') {
			$kopalnia = ($kopalnie -> fields['mcopper'] + 1);
			$cena = $minen;
			$nazwa = 'miedzi';
		}
		if ($_GET['rodz'] == 'kzel') {
			$kopalnia = ($kopalnie -> fields['kzel'] + 1);
			$cena = $zelazo;
			$nazwa = 'zelaza';
		}
		if ($_GET['rodz'] == 'kweg') {
			$kopalnia = ($kopalnie -> fields['kweg'] + 1);
			$cena = $wegiel;
			$nazwa = 'wegla';
		}
		if ($player -> credits >= $cena) {
			$smarty -> assign ("Name",  $nazwa);
			$db -> Execute("UPDATE kopalnie SET ".$_GET['rodz']."=".$kopalnia." WHERE gracz=".$player -> id);
			$db -> Execute("UPDATE players SET credits=credits-".$cena." WHERE id=".$player -> id);
		} else {
			error ("Nie stac cie na to!");
		}
    }
}

if (isset ($_GET['view']) && $_GET['view'] == 'market') {
    if (!isset ($_GET['step'])) {
        $smarty -> assign ( array("Coal" => $kopalnie -> fields['wegiel'], "Iron" => $kopalnie -> fields['zelazo'], "Copper" => $kopalnie -> fields['copper']));
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'sell') {
        if (!isset($_POST['copper'])) {
            $_POST['copper'] = 0;
        }
        if (!isset($_POST['zelazo'])) {
            $_POST['zelazo'] = 0;
        }
        if (!isset($_POST['wegiel'])) {
            $_POST['wegiel'] = 0;
        }
	if (!ereg("^[0-9]*$", $_POST['copper']) || !ereg("^[0-9]*$", $_POST['zelazo']) || !ereg("^[0-9]*$", $_POST['wegiel'])) {
	    error ("Zapomnij o tym");
	}
	if ($_POST['wegiel'] > $kopalnie -> fields['wegiel'] || $_POST['zelazo'] > $kopalnie -> fields['zelazo'] || $_POST['copper'] > $kopalnie -> fields['copper']) {
	    error ("Nie masz tyle mineralow.");
	}
	$again = ($_POST['wegiel'] * 7);
	$bgain = ($_POST['zelazo'] * 3);
	$brgain = ($_POST['copper'] * 2);
	$tgain = ($again + $bgain + $brgain);
	$db -> Execute("UPDATE kopalnie SET wegiel=wegiel-".$_POST['wegiel']." WHERE gracz=".$player -> id);
	$db -> Execute("UPDATE kopalnie SET zelazo=zelazo-".$_POST['zelazo']." WHERE gracz=".$player -> id);
	$db -> Execute("UPDATE kopalnie SET copper=copper-".$_POST['copper']." WHERE gracz=".$player -> id);
	$db -> Execute("UPDATE players SET credits=credits+".$tgain." WHERE id=".$player -> id);
        $smarty -> assign ( array("Coal" => $_POST['wegiel'], "Iron" => $_POST['zelazo'], "Copper" => $_POST['copper'], "Gcoal" => $again, "Giron" => $bgain, "Gcopper" => $brgain, "All" => $tgain));
    }
}

if (isset ($_GET['view']) && $_GET['view'] == 'mine') {
    if ($player -> hp == 0) {
	error ("Nie mozesz wydobywac mineralow poniewaz jestes martwy!");
    }
    $arroption = array();
    $i = 0;
    if($kopalnie -> fields['mcopper'] > 0) {
        $arroption[$i] = "<option value=copper>miedzi</option>";
        $i = $i + 1;
    }
    if ($kopalnie -> fields['kzel'] > 0) {
        $arroption[$i] = "<option value=zelazo>zelaza</option>";
        $i = $i + 1;
    }
    if ($kopalnie -> fields['kweg'] > 0) {
        $arroption[$i] = "<option value=wegiel>wegla</option>";
        $i = $i + 1;
    }
    $smarty -> assign ("Option", $arroption);
    
	if (isset ($_GET['step']) && $_GET['step'] == 'mine') {
			if (!isset($_POST['razy'])) {
				error("Zapomnij o tym!");
			}
		if ($kopalnie -> fields['ops'] < $_POST['razy']) {
			error ("Nie masz tyle punktow operacji!");
		}
		if (!ereg("^[1-9][0-9]*$", $_POST['razy'])) {
			error ("Zapomnij o tym");
		}
		$pr = ceil($player -> strength / 10);
		if ($player -> clas == 'Rzemieslnik') {
			$premia1 = ceil($player -> level / 10);
			$premia = ($premia1 + $pr);
		} else {
			$premia = $pr;
		}
		$mrazem = 0;
		$mgain = 0;
		if (!isset($_POST['zloze'])) {
			error("Zapomnij o tym!");
		}
		if ($_POST['zloze'] != 'copper' && $_POST['zloze'] != 'zelazo' && $_POST['zloze'] != 'wegiel') {
			error ("Zapomnij o tym");
		}
		if ($_POST['zloze'] == 'copper') {
			for ($i=1;$i<=$_POST['razy'];$i++) {
			$mgain = (($kopalnie -> fields['mcopper'] * rand (0,7) + $premia));
			$mrazem = ($mrazem + $mgain);
			$nazwa = 'miedzi';
			}
		}
		if ($_POST['zloze'] == 'zelazo') {
			for ($i=1;$i<=$_POST['razy'];$i++) {
			$mgain = (($kopalnie -> fields['kzel'] * rand(0,5) + $premia));
			$mrazem = ($mrazem + $mgain);
			$nazwa = 'zelaza';
			}
		}
		if ($_POST['zloze'] == 'wegiel') {
			for ($i=1;$i<=$_POST['razy'];$i++) {
			$mgain = (($kopalnie -> fields['kweg'] * rand(0,3) + $premia));
			$mrazem = ($mrazem + $mgain);
			$nazwa = 'wegla';
			}
		}
		$db -> Execute("UPDATE kopalnie SET ops=ops-".$_POST['razy']." WHERE gracz=".$player -> id);
		$db -> Execute("UPDATE kopalnie SET ".$_POST['zloze']."=".$_POST['zloze']."+".$mrazem." WHERE gracz=".$player -> id)or die("UPDATE kopalnie SET ".$_POST['zloze']."=".$_POST['zloze']."+".$mrazem." WHERE gracz=".$player -> id);
		$smarty -> assign ( array("Gain" => $mrazem, "Name" => $nazwa));
    }
}
if ($kopalnie -> fields['id']) {
    $kopalnie -> Close();
}

// inicjalizacja zmiennych
if (!isset($_GET['view'])) {
    $_GET['view'] = '';
}
if (!isset($_GET['kup'])) {
    $_GET['kup'] = '';
}
if (!isset($_GET['step'])) {
    $_GET['step'] = '';
}

// przypisanie zmiennych oraz wyswietlenie strony
$smarty -> assign ( array("View" => $_GET['view'], "Buy" => $_GET['kup'], "Step" => $_GET['step']));
$smarty -> display ('mines.tpl');

require_once("includes/foot.php");
?>
