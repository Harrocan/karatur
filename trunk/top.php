<?php

$title="Podsumowanie toplist";
require_once('includes/head.php');

if($player->id != 267 && $player->id != 2)
    error("A spieprzaj dziadu");

if($_GET['co']=='reset') {
	$toplista=$db->Execute("SELECT * FROM toplista");
	$toplista=$toplista->GetArray();
	foreach($toplista as $top) {
		$i=1;
		while(isset($top["$i"])) {
			$suma[$top['id']]['num']+=$top["$i"];
			$i++;
		$suma[$top['id']]['id']=$top['id'];
		}
	}
	print_r($suma);
	foreach($suma as $sum){
		$db->Execute("UPDATE toplista SET total=total+{$sum['num']} WHERE id={$sum['id']}");
		$i=1;
		while(isset($toplista["$i"])) {
			$db->Execute("UPDATE toplista SET `$i`=0 WHERE id={$sum['id']}");
			//$play[$top['id']]['num']+=$top["$i"];
			$i++;
		}
	}
}

$toplista=$db->Execute("SELECT * FROM toplista");
$toplista=$toplista->GetArray();
$users=$db->Execute("SELECT id,user FROM players");
$users=$users->GetArray();
//print_r($users);
foreach($toplista as $top) {
	$i=1;
	//$play[$top['id']]['id']=$top['id'];
	while(isset($top["$i"])) {
		//echo "$i ($top[$i]) | ";
		$play[$top['id']]['num']+=$top["$i"];
		$i++;
	}
	$play[$top['id']]['total']=$top['total'];
	//echo "<BR>";
	foreach($users as $user)
		if($top['id']==$user['id']) {
			$play[$top['id']]['user']=$user['user'];
			break;
		}
	$play[$top['id']]['id']=$top['id'];
	
}
arsort($play);
//print_r($play);
echo "<table class=\"table\"><tr><td class=\"thead\">ID</td><td class=\"thead\">Gracz</td><td class=\"thead\">Ilosæ g³osów</td><td class=\"thead\">Ogó³em</td></tr>";
foreach($play as $pl) {
	echo "<tr><td>{$pl['id']}</td><td>{$pl['user']}</td><td>{$pl['num']}</td><td>{$pl['total']} </td></tr>";
}
echo "</table>";
require_once('includes/foot.php');
?>