<?php
//@type: F
//@desc: Magiczna wie¿a
$title = "Magiczna wieza";
require_once("includes/head.php");

//if ($player -> location != 'Athkatla' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Eshpurta' && $player -> location != 'Imnescar' && $player -> location != 'Iriaebor') {
//	error ("Zapomnij o tym");
//}
checklocation($_SERVER['SCRIPT_NAME']);

if ($player -> przemiana > 0) {

error ("Musisz powrocic z Besti w czlowieka aby tutaj przebywac!"); 

}

if (!isset($_GET['buy'])) {
	if (isset ($_GET['dalej'])) {
		if ($_GET['dalej'] != 'S' && $_GET['dalej'] != 'Z' && $_GET['dalej'] != 'C') {
			error ("Zapomnij o tym");
		}
		if ($_GET['dalej'] == 'C') {
			$czary = $db -> Execute("SELECT * FROM czary WHERE gracz=0 AND status='S' ORDER BY poziom ASC");
			$arrname = array();
			$arrefect = array();
			$arrcost = array();
			$arrlevel = array();
			$arrid = array();
			$i = 0;
			while (!$czary -> EOF) {
				$arrname[$i] = $czary -> fields['nazwa'];
				if ($czary -> fields['typ'] == 'B') {
					$arrefect[$i] = "<td>+".$czary -> fields['obr']." x Int obrazen</td>";
				}
				if ($czary -> fields['typ'] == 'O') {
					$arrefect[$i] = "<td>+".$czary -> fields['obr']." x SW obrony</td>";
				}
				if ($czary -> fields['nazwa'] == 'Ulepszenie przedmiotu') {
					$arrefect[$i] = "<td>Zwieksza sile przedmiotu</td>";
				}
				if ($czary -> fields['nazwa'] == 'Utwardzenie przedmiotu') {
					$arrefect[$i] = "<td>Zwieksza wytrzymalosc przedmiotu</td>";
				}
				if ($czary -> fields['nazwa'] == 'Umagicznienie przedmiotu') {
					$arrefect[$i] = "<td>Zwieksza premie szybkosci lub zrecznosci przedmiotu</td>";
				}
				$arrcost[$i] = $czary -> fields['cena'];
				$arrlevel[$i] = $czary -> fields['poziom'];
				$arrid[$i] = $czary -> fields['id'];
			$czary -> MoveNext();
				$i = $i + 1;
			}
		$czary -> Close();
			$smarty -> assign( array("Name" => $arrname, "Efect" => $arrefect, "Cost" => $arrcost, "Itemlevel" => $arrlevel, "Itemid" => $arrid));
		} else {
			error( "Sprzedawcy przedmiotow splajtowali ! Idz szukac gdzie indziej" );
			/*$items = $db -> Execute("SELECT * FROM mage_items WHERE type='".$_GET['dalej']."' ORDER BY cost ASC");
			$arrname = array();
			$arrpower = array();
			$arrcost = array();
			$arrlevel = array();
			$arrid = array();
			$i = 0;
			while (!$items -> EOF) {
				if ($items -> fields['type'] == 'S') {
					$arrpower[$i] = "+".$items -> fields['power']." % sily czarow";
				} else {
					$arrpower[$i] = "+".$items -> fields['power']." % many";
				}
				$arrname[$i] = $items -> fields['name'];
				$arrcost[$i] = $items -> fields['cost'];
				$arrlevel[$i] = $items -> fields['minlev'];
				$arrid[$i] = $items -> fields['id'];
			$items -> MoveNext();
				$i = $i + 1;
			}
		$items -> Close();
			$smarty -> assign( array("Name" => $arrname, "Power" => $arrpower, "Cost" => $arrcost, "Itemlevel" => $arrlevel, "Itemid" => $arrid));
			*/
		}
	}
}

if (isset($_GET['buy'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['buy'])) {
		error ("Zapomnij o tym!");
	}
	if ($_GET['type'] == 'S') {
		$czary = $db -> Execute("SELECT * FROM czary WHERE id=".$_GET['buy']);
		if( !isset( $czary -> fields['id'] ) ) {
			error( "Nie ma takiego czaru !" );
		}
		if( $player -> gold < $czary -> fields['cena'] ) {
			error( "Nie masz tyle pieniedzy !" );
		}
		$player->gold -= $czary->fields['cena'];
		$ret = $player -> EquipAdd( $czary -> fields['id'], 'spells', 'czary' );
		if( $ret ) {
			error( "Kupiles {$czary -> fields['nazwa']} czar za {$czary -> fields['cena']} sz !",'done' );
		}
		else {
			error( "Blad podczas dodawania nowego czaru !" );
		}
	/*
		$czary = $db -> Execute("SELECT * FROM czary WHERE id=".$_GET['buy']);
		$test = $db -> Execute("SELECT id FROM czary WHERE nazwa='".$czary -> fields['nazwa']."' AND gracz=".$player -> id);
		if ($test -> fields['id']) {
			error ("Masz juz taki czar!");
		}
		$test -> Close();
		if (!$czary -> fields['id']) {
			error ("Nie ten czar. Wroc do <a href=wieza.php>wiezy</a>.");
		}
		if ($czary -> fields['poziom'] > $player -> level) {
			error ("Twoj poziom jest za niski dla tej rzeczy! Wroc do <a href=wieza.php>wiezy</a>.");
		}
		if ($czary -> fields['cena'] > $player -> credits) {
			error ("Nie stac cie! Wroc do <a href=wieza.php>wiezy</a>.");
		}
		if ($player -> clas != 'Mag' && $player -> rank != 'Kaplan'&&($czary -> fields['typ'] == 'B' || $czary -> fields['typ'] == 'O') && $player -> clas != 'Kaplan' && ($czary -> fields['typ'] == 'B' || $czary -> fields['typ'] == 'O') && $player -> clas != 'Druid') {
			error ("Tylko mag moze, kaplan i druid uzywac tego typu czarow!");
		}
		$db -> Execute("INSERT INTO czary (gracz, nazwa, cena, poziom, typ, obr, status) VALUES(".$player -> id.",'".$czary -> fields['nazwa']."',".$czary -> fields['cena'].",".$czary -> fields['poziom'].",'".$czary -> fields['typ']."',".$czary -> fields['obr'].",'U')") or error("Nie moge dodac czaru.");
		$smarty -> assign ("Message", "Zaplaciles <b>".$czary -> fields['cena']."</b> sztuk zlota, i kupiles za to nowy czar <b>".$czary -> fields['nazwa']."</b>.");
		$db -> Execute("UPDATE players SET credits=credits-".$czary -> fields['cena']." WHERE id=".$player -> id);
		$czary -> Close();
	*/
	} elseif ($_GET['type'] == 'I') {
		$items = $db -> Execute("SELECT * FROM mage_items WHERE id=".$_GET['buy']);
		if (!$items -> fields['id']) {
			error ("Nie ten przedmiot. Wroc do <a href=wieza.php>wiezy</a>.");
		}
		if ($items -> fields['minlev'] > $player -> level) {
			error ("Twoj poziom jest za niski dla tej rzeczy! Wroc do <a href=wieza.php>wiezy</a>.");
		}
		if ($items -> fields['cost'] > $player -> credits) {
			error ("Nie stac cie! Wroc do <a href=wieza.php>wiezy</a>.");
		}
		if ($player -> clas != 'Mag' && $player -> clas != 'Kaplan' && $player -> clas != 'Druid') {
			error ("Tylko magowie, kaplani i druidzi moga uzywac tych przedmiotow! Wroc do <a href=wieza.php>wiezy</a>.");
		}
		$newcost = ceil($items -> fields['cost'] * 0.75);
		$db -> Execute("INSERT INTO equipment (owner, name, cost, minlev, type, power, status) VALUES(".$player -> id.",'".$items -> fields['name']."',".$newcost.",".$items -> fields['minlev'].",'".$items -> fields['type']."',".$items -> fields['power'].",'U')") or error("Nie moge dodac przedmiotu.");
		$smarty -> assign ("Message", "Zaplaciles <b>".$items -> fields['cost']."</b> sztuk zlota, i kupiles za to nowy przedmiot <b>".$items -> fields['name']."</b>.");
		$db -> Execute("UPDATE players SET credits=credits-".$items -> fields['cost']." WHERE id=".$player -> id);
	$items -> Close();
	}
}

//inicjalizacja zmiennych
if (!isset($_GET['buy'])) {
	$_GET['buy'] = '';
}
if (!isset($_GET['dalej'])) {
	$_GET['dalej'] = '';
}

//przypisanie zmiennych i wyswietlenie strony
$smarty -> assign( array("Buy" => $_GET['buy'], "Next" => $_GET['dalej']));
$smarty -> display('wieza.tpl');

require_once("includes/foot.php"); 
?>
