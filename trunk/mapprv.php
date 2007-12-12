<?php
require_once('class/player.class.php');
require_once ('includes/config.php');
require_once('includes/sessions.php');

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<link rel="stylesheet" href="css/lucass.css">
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hide;"></div>
<Script language="JavaScript" src="overlib.js"></script>
<?php
if(!isset($_SESSION['player']))
	die("Sesja zakończona !");
if(!isset($_SESSION['rank']['mapedit']))
	die("Nie masz uprawnień !");
$pos=$db->Execute("SELECT `map-hi-x`,`map-hi-y` FROM players WHERE id=".($_SESSION['player']->id)."");
$x=$pos->fields['map-hi-x'];
$y=$pos->fields['map-hi-y'];


if(isset($_GET['d'])) {
	if($_GET['d']=='w') {
		if($x>0) {
			$x-=5;
		}
	}
	if($_GET['d']=='e') {
		if($x<128) {
			$x+=5;
		}
	}
	if($_GET['d']=='n') {
		if($y>0) {
			$y-=5;
		}
	}
	if($_GET['d']=='s') {
		if($y<86) {
			$y+=5;
		}
	}
}
/*$desc=$db->Execute("SELECT * FROM mapa WHERE zm_x=".$x." AND zm_y=".$y);
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
	$flor="brak danych";*/

echo '<table border="0" align="center" width="98%"><tr><td align="center" height="330px" colspan="2" valign="center">';
echo '<table cellspacing="0" cellpadding="0" border="0"  class="table">';
echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td align="center"><a href="mapprv.php?d=n"><img src="mapa/arrown.gif" style="width: 25px; height: 25px;"></a></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';

for($i=$y-7;$i<$y+8;$i++) {
	if($y==$i)
		echo '<tr><td><a href="mapprv.php?d=w"><img src="mapa/arroww.gif" style="width: 25px; height: 25px;"></a></td>';
	else
		echo '<tr><td></td>';
	for($j=$x-7;$j<$x+8;$j++) {
		$m=$db->Execute("SELECT * FROM mapa WHERE zm_x=".$j." AND zm_y=".$i);
		echo '<td align="center">';
		if($m->fields['name']) {
			echo "<A onMouseOver=\"overlib('<table><tr><td>Lokacja</td><td>".$m->fields['name']."</td></tr><tr><td>Plik</td><td>".$m->fields['file']."</td></tr><tr><td>Opis</td><td>".substr($m->fields['opis'],0,150)."</td></tr><tr><td>Geo</td><td>".substr($m->fields['geo'],0,150)."</td></tr><tr><td>Flora</td><td>".substr($m->fields['flora'],0,150)."</td></tr><tr><td>Dostępne</td><td>".$m->fields['dost']."</td></tr></table>', CAPTION, '<center>".$m->fields['name']."(".$i."x".$j.")</center>', FGCOLOR, 'black', BGCOLOR, '#0C1115', TEXTCOLOR, '#000000', CAPTIONSIZE, 2, BORDER, 1, TEXTSIZE, 1, STATUS, 'Krol',WIDTH, 200)\" onMouseOut=\"nd();\">".'<img src="mapa-big/'.$i.'_'.$j.'.png" style="width: 25px; height: 25px; border-color: ';
			if($m->fields['dost']=='tak')
				echo '#00FF00;';
			else
				echo '#FF0000;';
			echo 'border-style:solid; border-width:2px"></a>';
		}
		else
			echo "<A onMouseOver=\"overlib('".$i."x".$j."', FGCOLOR, 'black', BGCOLOR, '#0C1115', TEXTCOLOR, '#000000', CAPTIONSIZE, 2, BORDER, 1, TEXTSIZE, 1, STATUS, 'Krol',WIDTH, 200)\" onMouseOut=\"nd();\">".'<img src="mapa-big/'.$i.'_'.$j.'.png"  style="width: 25px; height: 25px; border-color: #000000; border-style:solid; border-width:2px">';
		echo '</td>';
	}
	if($y==$i)
		echo '<td><a href="mapprv.php?d=e"><img src="mapa/arrowe.gif" style="width: 25px; height: 25px;"></a></td></tr>';
	else
		echo '<td></td></tr>';
}
echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td align="center"><a href="mapprv.php?d=s"><img src="mapa/arrows.gif" style="width: 25px; height: 25px;"></a></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>';
echo '</td><td rowspan="2" valign="top" width="27%">';
/*echo '<table border="0"><tr><td><img src="images/terrain/hills.jpg" style="float:left"> Wzgórza</td></tr>
		<tr><td><img src="images/terrain/low_mountains.jpg" style="float:left"> Niskie góry</td></tr>
		<tr><td><img src="images/terrain/high_mountain.jpg" style="float:left"> Wysokie góry</td></tr>
		<tr><td><img src="images/terrain/cliffs.jpg" style="float:left"> Klify</td></tr>
		<tr><td><img src="images/terrain/clear.jpg" style="float:left"> Pustkowia</td></tr>
		<tr><td><img src="images/terrain/grass.jpg" style="float:left"> Tereny trawiaste</td></tr>
		<tr><td><img src="images/terrain/forest.jpg" style="float:left"> Lasy</td></tr>
		<tr><td><img src="images/terrain/jungle.jpg" style="float:left"> Dżungle</td></tr>
		<tr><td><img src="images/terrain/marsh.jpg" style="float:left"> Bagna</td></tr>
		<tr><td><img src="images/terrain/swamp.jpg" style="float:left"> Mokradła</td></tr>
		<tr><td><img src="images/terrain/moor.jpg" style="float:left"> Wrzosowiska</td></tr>
		<tr><td><img src="images/terrain/badlands.jpg" style="float:left"> Bezdroża</td></tr>
		<tr><td><img src="images/terrain/volcano.jpg" style="float:left"> Wulkany</td></tr>
		<tr><td><img src="images/terrain/glacier.jpg" style="float:left"> Lodowce</td></tr>
		<tr><td><img src="images/terrain/river.jpg" style="float:left"> Rzeki</td></tr>
		<tr><td><img src="images/terrain/subterrains.jpg" style="float:left"> Podziemne rzeki</td></tr>
		<tr><td><img src="images/terrain/sandy_desert.jpg" style="float:left"> Pustynie piaszczyste</td></tr>
		<tr><td><img src="images/terrain/rocky_desert.jpg" style="float:left"> Pustynie kamieniste</td></tr></table>';*/
echo '</td></tr>';
	$message='';
	$desc='';
	echo '<tr><td valign="top">';
	//echo '<textarea name="foo" cols="60" rows="7" READONLY>'.$opis[$x][$y].'</textarea>';
	echo '</td><td>';
	//echo '<textarea name="foo" cols="30" rows="7" READONLY>'.$desc.'</textarea>';
	echo '</td><td></td></tr></table>';



	/*$_SESSION['location']=$location;
	$_SESSION['file']=$file;
	$db->Execute("UPDATE players SET mapx=".$x.", mapy=".$y.", file='".$file."', miejsce='".$location."' WHERE id=".$player->id);*/


	$db->Execute("UPDATE players SET `map-hi-x`=".$x.", `map-hi-y`=".$y." WHERE id='".$_SESSION['player']->id."'");

$db->Close();
?>
</div>
</body>
</html>