<?php session_start(); ?>
<html><head><title>Map editor - by IvaN</title>
<script language="JavaScript" src="js/advajax.js"></script>
<script language="JavaScript" src="js/pathfinder.js"></script>
<script language="JavaScript" src="js/astarjs.js"></script>
</head>
<body>
<?php

//echo "<script language=\"JavaScript\" src=\"js/mapEditor.js\"></script>";
?>
<a href="javascript:setClickMode('pathfinding')">droga</a> <a href="javascript:setClickMode('pickTarget')">celowanie</a> <a href="javascript:send();">send</a>
<table><tr><td width="100px">
<?php

require_once( "maps/map.php" );

function getTiles( $map, $type ) {
	unset( $map['x'], $map['y'] );
	$return = array();
	foreach( $map as $x => $submap ) {
		foreach( $submap as $y => $tile ) {
			if( !empty( $tile['option'] ) && $tile['option'] == $type ) {
				$return[] = array( 'x' => $x, 'y' => $y );
			}
		}
	}
	return $return;
}
$sa = getTiles( $map, 'startp' );
$sf = array_rand( $sa );
$startx = $sa[$sf]['x'];
$starty = $sa[$sf]['y'];

echo "<script language=\"JavaScript\">var startx=$startx;var starty=$starty;var mapx={$map['x']}; var mapy={$map['y']};</script>";

$sizex = $map['x'];
$sizey = $map['y'];

echo "<div style='border-style:solid; width: ".(20*$sizex)."'><table border=\"0\" id='tab_map' cellpadding=0 cellspacing=0>\n";
for( $i = 0; $i < $sizex; $i++ ) {
	echo "<tr>";
	for( $j = 0; $j < $sizey; $j++ ) {
		$item = $map[$i][$j];
		if( !empty( $item['tiletype'] ) ) {
			echo "<td x='$i' y='$j' id='{$i}_{$j}' tileno='{$item['tilename']}' tiletype='{$item['tiletype']}' ";
			if( !empty( $item['option'] ) ) {
				echo "option='{$item['option']}'";
			}
			echo "style=\"width:20px; height:20px; text-align:center; background: url('images/map/{$map[$i][$j]['tilename']}.gif')\" onclick='click(this);'>";
		}
		else
			echo "<td x='$i' y='$j' id='{$i}_{$j}' style='text-align:center; width:20px; height:20px' onclick='click(this);'>";
		
		if( $i == $startx && $j == $starty ) {
			echo "<img src='images/map/spc_startp.gif' />";
		}
		if( !empty( $item['option'] ) ) {
			//echo "<img src='images/map/spc_{$item['option']}.gif' />";
		}
		else
			echo "&nbsp;";
		//echo "<td valign=\"middle\" align=\"center\" x='$i' y='$j' id='{$i}_{$j}' style='width:20px; height:20px' onclick='click(this);'>";
		//echo "&nbsp;";
		//echo "<img src='images/map/spc_map.gif' /><img src='images/map/spc_block.gif' /><img src='images/map/spc_highblock.gif' /><img src='images/map/spc_estart.gif' /><img src='images/map/spc_items.gif' /><img src='images/map/spc_exit.gif' />";
		echo "</td>";
	}
	echo "</tr>\n";
}
echo "</table></div>\n";
		echo "<div id='test'></div><br>";
		?>
				</td></tr></table>ta mapa jest jeszcze odrobine niedopracowana - kiedy wybierasz u gory 'celowanie' to kiedy definiujesz kolejne cele w ktore chcesz celowac to nie znikaja Ci wartosci z poprzedniego celowania. No ale w wersji docelowej i tek nie bedzie to wogole zaznaczane, wiec tutaj jest tylko dla takiej informacji sobie ;)<br><br>
				
				Poza tym - na trybie 'droga' - zielone pole - start, czerwone pole - koniec drogi, zolte pola - znaleziona sciezka<br>
				Na trybie 'celowanie' - cyferki jakie sie pojawiaja na polach oznaczaja % ukrycia jakie dane pole by dawalo podczas strzelania z luku. Obecnie jedynymi takimi przeszkodami sa pola brazowe ... a to oznacza ze jesli na polu brazowym pojawi sie powiedzmy 40 to to oznacza ze to pole zapewni 40% oslony