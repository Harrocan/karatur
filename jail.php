<?php
//@type: F
//@desc: Lochy
$title = "Lochy";
require_once("includes/head.php");

checklocation($_SERVER['SCRIPT_NAME']);

/*if ($player -> location != 'Athkatla' && $player -> location != 'Lochy' && $player -> location != 'Imnescar' && $player -> location != 'Swiecowa Wieza' && $player -> location != 'Proskur' && $player -> location != 'Iriaebor' && $player -> location != 'Asbravn') {
	error ("Zapomnij o tym");
}*/

if ($player -> location != 'Lochy') {
	$jail = $db -> Execute("SELECT j.*, p.user FROM jail j JOIN players p ON p.id=j.prisoner ORDER BY j.id ASC");
	$number = $jail -> RecordCount();
	$smarty -> assign ("Number", $number);
	if ($number > 0) {
		$arrid = array();
		$arrname = array();
		$arrdate = array();
		$arrverdict = array();
		$arrduration = array();
		$arrjailid = array();
		$arrcost = array();
		$i = 0;
		while (!$jail -> EOF) {
		// $pname = $db -> Execute("SELECT user FROM players WHERE id=".$jail -> fields['prisoner']);
			$arrid[$i] = $jail -> fields['prisoner'];
			$arrname[$i] = $jail -> fields['user'];
			$arrdate[$i] = $jail -> fields['data'];
			$arrverdict[$i] = $jail -> fields['verdict'];
			$arrduration[$i] = $jail -> fields['duration'];
			$arrjailid[$i] = $jail -> fields['id'];
			$arrcost[$i] = $jail -> fields['cost'];
			$jail -> MoveNext();
			$i = $i + 1;
		}
		$smarty -> assign ( array("Id" => $arrid, "Name" => $arrname, "Date" => $arrdate, "Verdict" => $arrverdict, "Duration" => $arrduration, "Jailid" => $arrjailid, "Cost" => $arrcost));
	}
	$jail -> Close();
}

if ($player -> jail == 'Y') {
	$prisoner = $db -> Execute("SELECT * FROM jail WHERE prisoner=".$player -> id);
	$smarty -> assign ( array("Date" => $prisoner -> fields['data'], "Verdict" => $prisoner -> fields['verdict'], "Duration" => $prisoner -> fields['duration'], "Cost" => $prisoner -> fields['cost']));
	$prisoner -> Close();
}

if (isset ($_GET['prisoner'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['prisoner'])) {
		error ("Zapomnij o tym!");
	}
	$prisoner = $db -> Execute("SELECT * FROM jail WHERE id=".$_GET['prisoner']);
	if (!$prisoner -> fields['id']) {
		error ("Nie ma takiego wieznia!");
	}
	if ($prisoner -> fields['cost'] > $player -> gold) {
		error ("Nie masz tylu sztuk zlota przy sobie!");
	}
	if ($player -> id == $prisoner -> fields['prisoner']) {
		error ("Nie mozesz wplacic sam za siebie kaucji!");
	}
	require_once('class/playerManager.class.php');
	$pr = new playerManager( $prisoner->fields['prisoner'] );
	$pr->setMisc( 'jail', 'N' );
	$pname = $pr->getMisc( 'user' );
	//$pname = $db -> Execute("SELECT user FROM players WHERE id=".$prisoner -> fields['prisoner']);
	//$db -> Execute("UPDATE players SET jail='N' WHERE id=".$prisoner -> fields['prisoner']);
	//PutSignal( $prisoner -> fields['prisoner'], 'misc' );
	$db -> Execute("DELETE FROM jail WHERE id=".$prisoner -> fields['id']);
	//$db -> Execute("UPDATE players SET credits=credits-".$prisoner -> fields['cost']." WHERE id=".$player -> id);
	$player -> gold -= $prisoner -> fields['cost'];
	$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$prisoner -> fields['prisoner'].",'Gracz <b>".$player -> user." ID:".$player -> id."</b> wplacil(a) za ciebie kaucje w lochach.','".$newdate."')");
	SqlExec("UPDATE akta SET freeid=".$player->id.", freename='".$player->user."', freedate='".$newdate."' WHERE cela=".$_GET['prisoner'].";");
	error ("Zaplaciles ".$prisoner -> fields['cost']." sztuk zlota kaucji za gracza ".$pname -> fields['user']." ID: ".$prisoner -> fields['prisoner']);

}

if (isset ($_GET['action']) && $_GET['action'] == 'ucieczka') {
	if ($player -> hp == 0) {
		error ("Nie mozesz uciekac poniewaz jestes martwy!.");
	}
	$test = $db -> Execute("SELECT bridge FROM players WHERE id=".$player -> id);
	if ($test -> fields['bridge'] == 'T') {
		error("Mozesz uciekac tylko raz na reset!");
	}
	$test -> Close();
	$cost = $db -> Execute("SELECT cost FROM jail WHERE prisoner=".$player -> id);
	if ($player -> gold < $cost -> fields['cost']) {
		//$db -> Execute("update players set hp='5' where id=".$player -> id);
		$player -> hp = 5;
		//$db -> Execute("update players set bridge='T' where id=".$player -> id);
		$player -> bridge = 'T';
		error ("Niestety suma, ktora chciales przekupic straznika byla zbyt niska. Straznik postanowil obic Ci za to maske. Ledwo to przezy³e¶");
	}
	
	$chance = rand(1,9);
	if ($chance > 7) {
		//$db -> Execute("update players set jail='N' where id=".$player -> id);
		$player -> jail = 'N';
		$db -> Execute("delete from jail where prisoner=".$player -> id);
		error ("Jesteœ wolny narreszcie.",'done',$player -> file);
	}
	if ($chance < 8) {
		//$db -> Execute("update players set credits=credits-".$cost -> fields['cost']." where id=".$player -> id);
		$player -> gold -= $cost -> fields['cost'];
		$db -> Execute("update players set bridge='T' where id=".$player -> id);
		error ("Niestety zostaleœ schwytany i dostales dodatkowo ".$cost -> fields['cost']." kary..");
	}

}
$smarty -> assign ("Location", $player -> jail);
$smarty -> display ('jail.tpl');

require_once("includes/foot.php");
?>
