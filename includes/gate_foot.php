<?php

$query = $db -> Execute("SELECT COUNT(*) AS amount FROM players");
$nump = $query->fields['amount'];
$query -> Close();

$ostatni = $db -> EXECUTE("SELECT id,user FROM players ORDER BY id DESC LIMIT 1");
$ostatni = array_shift( $ostatni->GetArray() );
$smarty -> assign("Ostatni", $ostatni);
//$ostatni -> Close();
$pl = SqlExec("SELECT COUNT(lpv) AS online FROM players WHERE lpv>".(time()-180));
$ctime = time();
$numo = $pl->fields['online'];

$smarty->assign( array( "Players" => $nump, "Online" => $numo,  ) );

$smarty->display( "gate_foot.tpl" );

$db -> Close();

echo "<a href=\"www.rbkan.pl\" style=\"color:black\">Kacelarie adwokackie</a>

?>