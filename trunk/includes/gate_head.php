<?php

require_once ('./includes/preinit.php');

$time = date("H:i:s");
$hour = explode(":", $time);
$newhour = $hour[0] + 0;
if ($newhour > 23) {
	$newhour = $newhour - 24;
}
$arrtime = array($newhour, $hour[1], $hour[2]);
$newtime = implode(":",$arrtime);


//pora
$godzina = date("H:i:s");
if($godzina <= 4) $pora = 'Noc';
elseif($godzina <= 8) $pora = 'Poranek';
elseif($godzina <= 11) $pora = 'Przedpoludnie';
elseif($godzina == 12) $pora = 'Poludnie';
elseif($godzina <= 18) $pora = 'Popoludnie';
elseif($godzina == 19) $pora = 'Wieczor';
elseif($godzina <= 21) $pora = 'Pozny wieczor';
else $pora = 'Noc';
$smarty -> assign (array ("Godzina", $godzina, "Pora" => $pora));

//ostatni

//while (!$pl -> EOF) {
//	$span = ($ctime - $pl -> fields['lpv']);
//	if ($span <= 180) {
//		$numo = ($numo + 1);
//	}
//	$pl -> MoveNext();
//}
//$pl -> Close();

//print_r( $_SERVER );

$adminmail1 = str_replace("@","[at]",$adminmail);

$psel = $db->Execute("SELECT user,id FROM players WHERE lpv > ".(time()-180));
$ctime = time();
$online_name = array();
$online_count = array();
$index=0;
while (!$psel->EOF) {
	//$span = ($ctime - $psel->fields['lpv']);
	//if ($span <= 120) {
		//$sql_arr[0][index]=$pl[user];
		//$sql_arr[1][index]=$pl[id];
		$online_name[$index]=$psel->fields['user'];
		$online_count[$index]=$psel->fields['id'];
		$index++;
	//}
	$psel->MoveNext();
}

$smarty->assign("on_name",$online_name);
$smarty->assign("on_id",$online_count);

$tops = $db->Execute( "SELECT * FROM toplista_entries" );
$tops = $tops->GetArray();
//qDebug( print_r( $tops, true ) );
$smarty->assign( "Tops", $tops );
$smarty -> assign(array("Gamename" => $gamename, "Meta" => ''));
$smarty->assign( array ("Time" => $newtime, "Adminname" => $adminname, "Adminmail" => $adminmail, "Adminmail1" => $adminmail1));
$smarty -> display ( 'gate_head.tpl' );

?>