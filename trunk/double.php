<?php

$title="Multikonta";
require_once('includes/head.php');


function cmp($val1, $val2) {
	if($val1['first']['id']==$val2['first']['id']) {
 	  if($val1['sec']['id']==$val2['sec']['id'])
		   return 0;
    else
       return ( ($val1['sec']['id'] < $val2['sec']['id'])? -1 : 1 );
 }
 return ( ($val1['first']['id'] < $val2['first']['id'])? -1 : 1 );
}

$pl = $db->Execute("SELECT * FROM players");
$pl = $pl -> GetArray();

$ip=array();
foreach($pl as $user) {
					 $ip[$user['id']]=$user['ip'];
}

$unik = array_unique($ip);

$roznica = array_diff_assoc($ip, $unik);


foreach($roznica as $key=>$search) {
								$double=array_search($search, $ip);
								//$double[$dkey]=
								$multi[]=array($key,$double);
								//echo "<tr><td>$key</td><td>$double</td></tr>";
}
$i=0;
foreach($multi as $acc){
							$first=$db->Execute("SELECT id,user,ip,lpv FROM players WHERE id=$acc[1]");
							$sec=$db->Execute("SELECT id,user,ip,lpv FROM players WHERE id=$acc[0]");
							$m[$i]['first']['id']=$first->fields['id'];
							$m[$i]['sec']['id']=$sec->fields['id'];
							$m[$i]['first']['user']=$first->fields['user'];
							$m[$i]['sec']['user']=$sec->fields['user'];
							$m[$i]['first']['lpv']=date("d-m-y",$first->fields['lpv']);
							$m[$i]['sec']['lpv']=date("d-m-y",$sec->fields['lpv']);
							$m[$i]['ip']=$first->fields['ip'];
							$i++;
							//echo "<tr><td>{$first->fields['ip']}</td>";
							//echo "<td>{$first->fields['user']} ({})</td>";
							//echo "<td>{$sec->fields['user']} ({$sec->fields['id']})</td></tr>";							
							//echo '<tr><td colspan="3"><hr></td></tr>';
}
echo "<table border=0 width=\"100%\">";
uasort($m,"cmp");
foreach($m as $acc) {
		echo "<tr>";
		echo "<td><a href=view.php?view={$acc['first']['id']}>{$acc['first']['user']} ({$acc['first']['id']})</a><br>{$acc['first']['lpv']}</td>";
		echo "<td><a href=view.php?view={$acc['sec']['id']}>{$acc['sec']['user']} ({$acc['sec']['id']})</a><br>{$acc['sec']['lpv']}</td>";	
		echo "<td>{$acc['ip']}</td>";				
		echo "</tr>";		
		echo '<tr><td colspan="3"><hr></td></tr>'; 
}
echo "</table>";
//print_r($m);
require_once("includes/foot.php");

?>
