<?php 

require_once( 'class/combatFighter.class.php' );

session_start();
echo '<html><head><title>Mapa walki - by IvaN</title>
		<link rel="stylesheet" href="css/combat.css">
		<script language="JavaScript" src="js/advajax.js"></script>
		<script language="JavaScript" src="js/ajax_base.js"></script>
		<script language="JavaScript" src="js/pathfinder.js"></script>
		<script language="JavaScript" src="js/targetPicker.js"></script>
		<script language="JavaScript" src="js/combatMap.js"></script>
		</head>
		<body onload="init();" style="background-color:white;">';

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

//print_R ($_SESSION );

if( !isset( $_SESSION['combatPl'] ) ) {
	$sa = getTiles( $map, 'startp' );
	$sf = array_rand( $sa );
	$pl1 = new fighter( 0, 'player', $sa[$sf]['x'], $sa[$sf]['y'], 'pl' );
	//$sa = getTiles( $map, 'starte' );
	//$sf = array_rand( $sa );
	//$pl2 = new fighter( 1, 'enemy 1', $sa[$sf]['x'], $sa[$sf]['y'], 'en' );
	//$sa = getTiles( $map, 'starte' );
	//$sf = array_rand( $sa );
	//$pl3 = new fighter( 2, 'enemy 2', $sa[$sf]['x'], $sa[$sf]['y'], 'en' );
	
	$_SESSION['combatPl'][] = $pl1;
	//$_SESSION['combatPl'][] = $pl2;
	//$_SESSION['combatPl'][] = $pl3;
}

if( !isset( $_SESSION['mapData'] ) ) {
	$sa = getTiles( $map, 'startp' );
	$sf = array_rand( $sa );
	$mapData['start']['x'] =$sa[$sf]['x'];
	$mapData['start']['y'] =$sa[$sf]['y'];
	$_SESSION['mapData'] = $mapData;
	//echo "new data";
}
else {
	//echo "reload data";
	$mapData =& $_SESSION['mapData'];
}

$divx = ($map['x'] ) * 20;
$divy = ($map['y'] ) * 20;
echo "<div id=\"map\" style=\"width:$divx;height:$divy;border-style:solid;text-align:center\">";
echo "<table>";
for( $i = 0; $i < $map['x']; $i++ ) {
	echo "<tr>";
	for( $j = 0; $j < $map['y']; $j++ ) {
		echo "<td id=\"{$i}_{$j}\"> </td>";
	}
	echo "</tr>";
}
echo "</table";
echo "</div>";

echo '<a id="mode_path" href="javascript:setMode(\'path\');" class="combatModeOff">idz</a> <a id="mode_target" href="javascript:setMode(\'target\');" class="combatModeOff">celuj</a> ';

echo '<div id="test"></div><div id="action"></div><div id="error"></div>';

echo '</body></html>';

//$_SESSION['mapData'] = $mapData;

?>