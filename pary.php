<?php
//@type: F
//@desc: Kaplica
$title = 'Kaplica';
require_once('includes/head.php');

//if($player -> location != 'Athkatla' && $player -> location != 'Iriaebor')
//{
//	error('Zapomnij o tym!');
//}
checklocation($_SERVER['SCRIPT_NAME']);

$objPriests = $db -> Execute("SELECT p.id, p.user, r.name FROM players p JOIN ranks r ON r.id=p.rid WHERE r.priest=1 ORDER BY p.id ASC");
$intKey = 0;
$strPriests = '';
while(!$objPriests -> EOF)
{
	$strPriests .= "- <a href=\"mail.php?view=write&id={$objPriests->fields['id']}\">{$objPriests->fields['name']} {$objPriests->fields['user']}</a><br />";
	$objPriests -> MoveNext();
	$intKey++;
}

if($intKey == 0)
{
	$strPriests = '<i>Brak ksiezy w kraju, aby otrzymac slub, nalezy zglosic sie do krola.</i>';
}
$smarty -> assign('Priests', $strPriests);

//if ($player -> location == 'Athkatla') {
	//$smarty -> display ('pary.tpl');
	$pary = SqlExec("SELECT p.*, p1.user AS p1, p2.user AS p2 FROM pary p  LEFT JOIN players p1 ON p1.id=p.marriage1 LEFT JOIN players p2 ON p2.id=p.marriage2 ORDER BY p.id ASC");
	$pary = $pary -> GetArray();
	foreach( $pary as $key => $para ) {
		if( $player -> id == $para['marriage1'] || $player -> id == $para['marriage2'] ) {
			$pary[$key]['break'] = 1;
		}
		else {
			$pary[$key]['break'] = 0;
		}
	}
	//print_r( $pary );
	$smarty -> assign( "Pary", $pary );
	/*$number =$pary->RecordCount();
	$smarty -> assign ("Number", $number);
	if ($number > 0) {
		$arrid = array();
		$arrname = array();
		$arrdate = array();
		$arrverdict = array();
		$arrjailid = array();
		$arrcost = array();
		$i = 0;
		while (!$pary->EOF) {
			$mname=$db->Execute("select user from players where id=".$pary['prisoner']);
			$pname = $mname->fields['user'];
			$fmane=$db->Execute("select user from players where id=".$pary['prisonerp']);
			$pnamep = $fname->fields['user'];
			$arrid[$i] = $pary->fields['prisoner'];
			$arridp[$i] = $pary->fields['prisonerp'];
			$arrname[$i] = $pname->fields['user'];
			$arrnamep[$i] = $pnamep->fields['user'];
			$arrdate[$i] = $pary->fields['data'];
			$arrverdict[$i] = $pary->fields['verdict'];
			$arrjailid[$i] = $pary->fields['id'];
			$arrcost[$i] = $pary->fields['cost'];
			$i = $i + 1;
			$pary->MoveNext();
		}
		$smarty -> assign ( array("Id" => $arrid, "Idp" => $arridp, "Name" => $arrname, "Namep" => $arrnamep, "Date" => $arrdate, "Verdict" => $arrverdict, "Jailid" => $arrjailid, "Cost" => $arrcost));
	}
	*/
//}

if (isset ($_GET['break'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['break'])) {
		error ("Zapomnij o tym!");
	}
	$prisoner = $db->Execute("select * from pary where id=".$_GET['break']);
	
	if (empty ($prisoner->fields['id'])) {
		error ("Nie ma takiej pary!");
	}
	if ($prisoner->fields['cost'] > $player -> gold) {
		error ("Nie masz tylu sztuk zlota przy sobie!");
	}
	if ($player -> id != $prisoner->fields['marriage1'] && $player -> id != $prisoner->fields['marriage2']) {
		error ("Nie mozesz zaplacic za nie swoj rozwod!");
	}
	
	/*$pname = mysql_fetch_array(mysql_query("select user from players where id=".$prisoner['prisoner']));
	$pnamep = mysql_fetch_array(mysql_query("select user from players where id=".$prisoner['prisonerp']));*/
	$db->Execute("update players set stan='Rozwiedziona(y)' where id=".$prisoner->fields['marriage1']);
	$db->Execute("update players set stan='Rozwiedziona(y)' where id=".$prisoner->fields['marriage2']);
	$db->Execute("update players set max_energy=max_energy-3 where id=".$prisoner->fields['marriage1']);
	$db->Execute("update players set max_energy=max_energy-3 where id=".$prisoner->fields['marriage2']);
	$db->Execute("delete from pary where id=".$prisoner->fields['id']);
	//$db->Execute("update players set credits=credits-".$prisoner->fields['cost']." where id=".$player -> id);
	$player -> gold -= $prisoner->fields['cost'];
	$db->Execute("insert into log (owner, log, czas) values(".$prisoner->fields['marriage1'].",'Gracz <b>".$player -> user." ID:".$player -> id."</b> zaplacil za Twoj rozwod.','".$newdate."')");
	$db->Execute("insert into log (owner, log, czas) values(".$prisoner->fields['marriage2'].",'Gracz <b>".$player -> user." ID:".$player -> id."</b> zaplacil za Twoj rozwod.','".$newdate."')");
	error ("Zaplaciles ".$prisoner->fields['cost']." sztuk zlota za rozwod pary: ID: ".$prisoner->fields['marriage1']." z ID: ".$prisoner->fields['marriage2'], 'done');

}
$smarty -> display ('pary.tpl');

require_once("includes/foot.php");
?>
