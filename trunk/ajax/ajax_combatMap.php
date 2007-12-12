<?php

require_once( '../class/combatFighter.class.php' );
require_once( 'ajax_base.php' );

if( isset( $_GET['mode'] ) && $_GET['mode'] == 'raw' ) {
	//! Zwracanie surowych danych bez zadnych klasowych obrobek
	$action = $_GET['action'];
	switch( $action ) {
		case 'refreshMap':
			require_once( "../maps/map.php" );
			echo "MAP~";
			//print_r( $_SESSION );
			$mapData =& $_SESSION['mapData'];
			$start['x'] = $mapData['start']['x'];
			$start['y'] = $mapData['start']['y'];
			//echo "<input type=\"hidden\" name=\"startx\" id=\"startx\" value=\"{$start['x']}\" />";
			//echo "<input type=\"hidden\" name=\"starty\" id=\"starty\" value=\"{$start['y']}\" />";
			echo "<input type=\"hidden\" name=\"mapx\" id=\"mapx\" value=\"{$map['x']}\" />";
			echo "<input type=\"hidden\" name=\"mapy\" id=\"mapy\" value=\"{$map['y']}\" />";
			echo "<table border=\"0\" id='tab_map' cellpadding=0 cellspacing=0>\n";
			for( $i = 0; $i < $map['x']; $i++ ) {
				echo "\t<tr>\n";
				for( $j = 0; $j < $map['y']; $j++ ) {
					echo "\t\t";
					$item = $map[$i][$j];
					if( !empty( $item['tiletype'] ) ) {
						echo "<td x='$i' y='$j' id='{$i}_{$j}' tileno='{$item['tilename']}' tiletype='{$item['tiletype']}' ";
						if( !empty( $item['option'] ) ) {
							echo "option='{$item['option']}'";
						}
						echo "style=\"width:20px; height:20px; text-align:center; \" onclick='click(this);'>";
					}
					else
						echo "<td x='$i' y='$j' id='{$i}_{$j}' style='text-align:center; width:20px; height:20px' onclick='click(this);'>";
		
					//if( $i == $start['x'] && $j == $start['y'] ) {
					//	echo "<img src='images/map/spc_startp.gif' />";
					//}
					//if( !empty( $item['option'] ) ) {
					//echo "<img src='images/map/spc_{$item['option']}.gif' />";
					//}
					//else
						echo "&nbsp;";
					echo "</td>\n";
				}
				echo "\t</tr>\n";
			}
			echo "</table>\n";
			break;
		default :
			echo "ERR~INVAILD_GET";
			break;
	}
}
else {
	//! Zwracanie danych poprzesz frameworka
	$action = $_GET['action'];
	$f =& $_SESSION['combatPl'];
	switch( $action ) {
		case 'fighterData' :
			$ajax -> addField( 'type', 'FIGHTER_DATA' );
			$ajax -> addField( 'amount', count( $f ) );
			$i = 0;
			foreach( $f as $val ) {
				$tab = array();
				$tab['name'] = $val->name;
				$tab['x'] = $val->position['x'];
				$tab['y'] = $val->position['y'];
				$tab['id'] = $val->id;
				$tab['fType'] = $val->type;
				$ajax -> addField( "f_$i", $tab );
				$i++;
			}
			//$ajax -> addField( 'test', 'foo' );
			$ajax -> send();
			break;
		case 'move' :
			//print_r( $_POST );
			if( empty( $_POST ) ) {
				err( "INVALID_GET" );
			}
			foreach( $f as $k => $val ) {
				if( $val->id == $_POST['plid'] ) {
					$ajax -> addField( 'type', 'MOVE_OK' );
					$npos['x'] = $_POST['tox'];
					$npos['y'] = $_POST['toy'];
					$f[$k]->position['x'] = $npos['x'];
					$f[$k]->position['y'] = $npos['y'];
					$ajax -> addField( 'pid', $val->id );
					$ajax -> addField( 'npos', $npos );
					$ajax -> send();
					break;
				}
			}
			break;
		default :
			err( "INVALID_GET" );
			break;
	}
}

?>