<?php
$title="Wêdrówka";
$js_onLoad = "init()";
require_once("./includes/head.php");



//if($player->location=="Lochy")
//	error("Nie mo¿esz podró¿owaæ poniewa¿ siedzisz w lochach !");
if($player->jail=="Y")
	error("Nie mo¿esz podró¿owaæ poniewa¿ siedzisz w lochach !");
	
if ($player -> hp <= 0) {
    //$db -> Execute("UPDATE players SET miejsce='Athkatla' WHERE id=".$player -> id);
    error ("Nie mo¿esz podró¿owaæ poniewa¿ jestes martwy.");
}

if( $player->fight ) {
	error( "Nie mozesz podrozowac poniewaz jestes w trakcie walki ! Wroc na miejsce walki !", 'error', 'town.php' );
}

if($player->mapx == 0 || $player->mapy == 0 )
	error("Nie mozesz podrozowac. Wybierz najpierw pochodzenie");

$x=$player->mapx;
$y=$player->mapy;


if(isset($_GET['d'])) {
	if($player->energy<0.4)
		error("Masz za ma³o energi ¿eby podró¿owaæ");
	if($_GET['d']=='w') {
		if($x>26) {
			$block=$db->Execute("SELECT dost FROM mapa WHERE zm_x=".($x-1)." AND zm_y=".($y));
			if($block->fields['dost']=="nie")
				error("Nie mo¿esz poruszaæ siê po polu zabronionym");
			$x--;
		}
	}
	if($_GET['d']=='e') {
		if($x<48) {
			$block=$db->Execute("SELECT dost FROM mapa WHERE zm_x=".($x+1)." AND zm_y=".($y));
			if($block->fields['dost']=="nie")
				error("Nie mo¿esz poruszaæ siê po polu zabronionym");
			$x++;
		}
	}
	if($_GET['d']=='n') {
		if($y>30) {
			$block=$db->Execute("SELECT dost FROM mapa WHERE zm_x=".($x)." AND zm_y=".($y-1));
			if($block->fields['dost']=="nie")
				error("Nie mo¿esz poruszaæ siê po polu zabronionym");
			$y--;
		}
	}
	if($_GET['d']=='s') {
		if($y<47) {
			$block=$db->Execute("SELECT dost FROM mapa WHERE zm_x=".($x)." AND zm_y=".($y+1));
			if($block->fields['dost']=="nie")
				error("Nie mo¿esz poruszaæ siê po polu zabronionym");
			$y++;
		}
	}
		//$db->Execute("UPDATE players SET energy=energy-0.4 WHERE id=".$player->id)or die("SHIT");
		$player -> energy -= 0.4;
}
$desc=SqlExec("SELECT * FROM mapa WHERE zm_x=".$x." AND zm_y=".$y);
$miejsca=$desc->fields['name'];
$location=$desc->fields['name'];
$file=$desc->fields['file'];
$opis=$desc->fields['opis'];
$geo=$desc->fields['geo'];
$flor=$desc->fields['flora'];

if($miejsca=='')
	$miejsca="pustkowia";
if($location=='')
	$location="podroz";
if($geo=='')
	$geo="brak danych";
if($opis=='')
	$opis="brak danych";
if($flor=='')
	$flor="brak danych";



//echo '<table border="1" align="center" width="98%"><tr><td align="center" height="330px" colspan="2" valign="center">';
// echo '<div id="tablemap"><table cellspacing="2" cellpadding="0" border="0"  class="table">';
// echo '<tr><td colspan="5" align="center" class="thead" id="tabMapHead">';
// if($file)
// 	echo '<a href="'.$file.'">'.$miejsca.'</a>';
// else
// 	echo $miejsca;
// echo '<br>'.$y.'x'.$x.'</td></tr>';
// echo '<tr><td></td><td></td><td align="center"><a href="javascript:move(\'up\')"><img src="mapa/arrown.gif"></a></td><td></td><td></td></tr>';
// $pref = "http://karatur.ivan.netshock.pl/";
// for($i=$y-1;$i<$y+2;$i++) {
// 	if($y==$i)
// 		echo '<tr><td><a href="javascript:move(\'left\')"><img src="mapa/arroww.gif"></a></td>';
// 	else
// 		echo '<tr><td></td>';
// 	for($j=$x-1;$j<$x+2;$j++) {
// 		$tdid = "tabtd_".( $i - $y + 2 )."_".( $j - $x + 2 );
// 		$block=$db->Execute("SELECT dost,file FROM mapa WHERE zm_x=".$j." AND zm_y=".$i);
// 		echo '<td id="'.$tdid.'" align="center" style="width: 50px; height: 50px; background-image: url(mapa-big/'.$i.'_'.$j.'.png)">';
// 		if($block->fields['dost']=='nie')
// 			echo "<img src=\"{$pref}mapa-big/no.gif\">";
// 		if($y==$i && $x==$j)
// 			echo "<img src=\"${pref}mapa/punkt.gif\">";
// 		else
// 			echo "&nbsp;";
// 		echo '</td>';
// 	}
// 	if($y==$i)
// 		echo '<td><a href="javascript:move(\'right\')"><img src="mapa/arrowe.gif"></a></td></tr>';
// 	else
// 		echo '<td></td></tr>';
// }
//echo '<tr><td></td><td></td><td align="center"><a href="javascript:move(\'down\')"><img src="mapa/arrows.gif"></a></td><td></td><td></td></tr></table></div>';
//echo '</td><td rowspan="2" valign="top" width="27%">';
$map = '<table cellspacing="0" cellpadding="0">';
for( $i = 1; $i <= 3; $i++ ) {
	$map .= '<tr>';
	for( $j = 1; $j <= 3; $j++ ) {
		$map .= "<td id=\"map_{$i}_{$j}\" class=\"mapCell\"></td>";
	}
	$map .= '<tr>';
}
$map .= '</table>';
$smarty->assign( 'MapStruct', $map );

$mapSpec = '<table cellspacing="0" cellpadding="0">';
for( $i = 1; $i <= 3; $i++ ) {
	$mapSpec .= '<tr>';
	for( $j = 1; $j <= 3; $j++ ) {
		$mapSpec .= "<td id=\"mapSpec_{$i}_{$j}\" class=\"mapCell\"></td>";
	}
	$mapSpec .= '<tr>';
}
$mapSpec .= '</table>';
$smarty->assign( 'MapSpec', $mapSpec );
//echo '</td></tr>';
	//echo '<tr><td valign="top">';
	//echo '<textarea name="foo" cols="60" rows="7" READONLY>'.$opis[$x][$y].'</textarea>';
	
	//echo '</td><td>';
	//echo '<textarea name="foo" cols="30" rows="7" READONLY>'.$desc.'</textarea>';
	//echo '</td><td></td></tr></table>';



	//$_SESSION['location']=$location;
	//$_SESSION['file']=$file;
	//$db->Execute("UPDATE players SET mapx=".$x.", mapy=".$y.", file='".$file."', miejsce='".$location."' WHERE id=".$player->id);
	//$player -> SetArray( array( 'mapx' => $x, 'mapy' => $y, 'file' => (string)$file, 'location' => $location ) );

/*if($_GET['no']=="2") {
	$db->Execute("UPDATE players SET `map-hi-x`=".$x.", `map-hi-y`=".$y." WHERE id=".$player->id);
}
if($_GET['no']=="3") {
	$db->Execute("UPDATE players SET `map-lo-x`=".$x.", `map-lo-y`=".$y." WHERE id=".$player->id);
}*/
$smarty->display( 'mapa.tpl' );
require_once("./includes/foot.php");
?>
