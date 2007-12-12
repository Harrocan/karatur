<?php

$title="Podsumowanie";
require_once('includes/head.php');

$pls=$db->Execute("SELECT id,level FROM players");
$num=$pls->RecordCount();
$pls=$pls->GetArray();
$stats = array();
foreach($pls as $pl) {
	if( isset($stats[$pl['level']]) )
		$stats[$pl['level']]++;
	else
		$stats[$pl['level']] = 1;
}
ksort($stats);
echo '<table class="table"><tr><td class="thead">Poziom</td><td class="thead">Ile graczy</td><td class="thead">Procen ogó³u</td></tr>';
foreach($stats as $key=>$stat)
	echo '<tr><td align="center">'.$key.'</td><td align="center">'.$stat.'</td><td align="center">'.round((($stat/$num)*100),2)." %</td></tr>";
echo "</table><BR><BR>";
require_once('includes/foot.php');
?>