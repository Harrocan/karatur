<?php

$title="Stare konta";
require_once('includes/head.php');

if($_SESSION['rank']['old']!='1')
	error("Nie masz prawa tu przebywaæ");

$color[0]="00CC00";
$color[1]="CCCC00";
$color[2]="CC6600";
$color[3]="FF0000";

	/*$pl = $db -> Execute("SELECT user,email,lpv FROM players");
    $warns=0;
    $deleted=0;
    while(!$pl->EOF) {
    	$dif=floor((time()-$pl->fields['lpv'])/(60*60*24));
    	if($dif>20) {
    		$message = "Twoje konto na Kara-Tur nie by³o u¿wane ju¿ od ".$dif." dni. Za tydzieñ nast±pi kasacja tego konta je¶li nie zaczniesz siê logowaæ. Przypominamy ¿e Twój login to Twój email a postaæ nazywa³a siê ".$pl->fields['user'].".<br>Zapraszamy na Kara-Tur<br><br>Kar-Tur Team";
	    	$subject = "Informacja od Wladcow na ".$gamename;
	    	require_once('mailer/mailerconfig.php');
	    	$mail -> AddAddress($pl -> fields['email']);
	    	if (!$mail -> Send()) {
                echo "Wiadomosc do ".$pl->fields['user']." nie zostala wyslana. Blad:<br> ".$mail -> ErrorInfo."<br>";
            }
            $mail->ClearAddresses();
            $warns++;
    	}
    	$pl->MoveNext();
    }
    echo "Wys³anych ostrze¿eñ : ".$warns."<br>";*/
/*$time=time()-60*60*24*7;
echo "$time <BR>";
echo date("Y m d : H.i.s",($time));*/
/*
$items = $db->Execute("SELECT id,name FROM items");
$items = $items->GetArray();
foreach($items as $item) {
	$name=ucfirst($item['name']);
	$db->Execute("UPDATE items SET name='$name' WHERE id={$item['id']}");
}*/

$acc=$db->Execute("SELECT id,user,lpv,logins,age FROM players ORDER BY lpv DESC");
echo '<table class="table" border="0"><tr><td class="thead">Nr.</td><td class="thead">Id</td><td class="thead">Nick</td><td class="thead">ostat. widz.</td><td class="thead" align="center">dni</td><td class="thead">Logowañ</td><td class="thead">Log/dzieñ</td></tr>';
$i=1;
while(!$acc->EOF) {
	$dif=floor((time()-$acc->fields['lpv'])/(60*60*24));
	$old=$dif/5;
	if($old>3)
		$old=3;
	echo '<tr>';
	echo '<td>'.$i.'</td>';
	echo "<TD>{$acc->fields['id']}</td>";
	echo '<td><span style="color:'.$color[$old].';">'.$acc->fields['user']."</span></td>";
 	echo '<td aling="center">'.date("d-m-y",$acc->fields['lpv']).'</td>';
	/*echo '<td>'.date("m",$acc->fields['lpv']).'</td>';
	echo '<td>'.date("d",$acc->fields['lpv']).'</td>';*/
	echo '<td align="center">'.$dif.'</td>';
	echo "<TD align=\"center\">{$acc->fields['logins']}</TD>";
	echo "<TD align=\"center\">".round($acc->fields['logins']/$acc->fields['age'],2)."</TD>";
	echo '</tr>';
	$acc->MoveNext();
	$i++;
}
echo '</table>';
require_once('includes/foot.php');
?>