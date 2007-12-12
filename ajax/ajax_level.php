<?php

header('Content-type: application/xml;charset=iso-8859-2');

require_once( 'ajax_base.php' );

if( empty( $_SESSION['player'] ) ) {
	err( "SESS_EXPIRE" );
}

function normalizeLevelData( &$item, $key ) {
	if( in_array( $key, array( 'img' ) ) ) {
		parse_str( $item, $item );
	}
}

function isPassable( $node ) {
	foreach( $node['img'] as $v ) {
		if( $v['passable'] != '1' ) {
			return false;
		}
	}
	return true;
}

$player =& $_SESSION['player'];

$mapInfo['vx'] = 7;
$mapInfo['vy'] = 7;
$mapInfo['id'] = $player->level_id;
$mapInfo['px'] = $player->level_x;
$mapInfo['py'] = $player->level_y;

$dom = new DOMDocument( "1.0", 'iso-8859-2' );
$xmlData = $dom->createElement( 'data' );
$dom->appendChild( $xmlData );

switch( $_POST['action'] ) {
	case 'fullMap' : {
		$t['minx'] = $mapInfo['px'] - floor( $mapInfo['vx'] / 2 );
		$t['maxx'] = $mapInfo['px'] + floor( $mapInfo['vx'] / 2 );
		$t['miny'] = $mapInfo['py'] - floor( $mapInfo['vy'] / 2 );
		$t['maxy'] = $mapInfo['py'] + floor( $mapInfo['vy'] / 2 );

		$sqlData = SqlExec( "SELECT * FROM level_data WHERE level_id={$mapInfo['id']} AND x>={$t['minx']} AND x<={$t['maxx']} AND y>={$t['miny']} AND y<={$t['maxy']}" );
		$sqlData = $sqlData->getArray();

		$mapData = createMapDataXML( $sqlData );
		$xmlData->appendChild( $mapData );

		$domAction = $dom->createElement( 'action', 'fullMap' );
		$xmlData->appendChild( $domAction );

		$domMapInfo = $dom->createElement( 'mapInfo' );
		$xmlData->appendChild( $domMapInfo );

		$tmp = $dom->createElement( 'posx', $mapInfo['px'] );
		$domMapInfo->appendChild( $tmp );
		$tmp = $dom->createElement( 'posy', $mapInfo['py'] );
		$domMapInfo->appendChild( $tmp );

		echo $dom->saveXML();
		break;
	}
	case 'move' : {
		if( empty( $_POST['dir'] ) ) {
			break;
		}

		$t['minx'] = $mapInfo['px'] - floor( $mapInfo['vx'] / 2 );
		$t['maxx'] = $mapInfo['px'] + floor( $mapInfo['vx'] / 2 );
		$t['miny'] = $mapInfo['py'] - floor( $mapInfo['vy'] / 2 );
		$t['maxy'] = $mapInfo['py'] + floor( $mapInfo['vy'] / 2 );
		$test['x'] = $mapInfo['px'];
		$test['y'] = $mapInfo['py'];

		switch( $_POST['dir'] ) {
			case 'left' : {
				$t['miny'] = $t['maxy'] = $t['miny'] - 1;
				$test['y']--;
				break;
			}
			case 'right' : {
				$t['miny'] = $t['maxy'] = $t['maxy'] + 1;
				$test['y']++;
				break;
			}
			case 'up' : {
				$t['minx'] = $t['maxx'] = $t['minx'] - 1;
				$test['x']--;
				break;
			}
			case 'down' : {
				$t['minx'] = $t['maxx'] = $t['maxx'] + 1;
				$test['x']++;
				break;
			}
		}

		$sqlData = SqlExec( "SELECT * FROM level_data WHERE level_id={$mapInfo['id']} AND x>={$t['minx']} AND x<={$t['maxx']} AND y>={$t['miny']} AND y<={$t['maxy']}" );
		$sqlData = $sqlData->getArray();

		$testData = SqlExec( "SELECT * FROM level_data WHERE level_id={$mapInfo['id']} AND x={$test['x']} AND y={$test['y']}" );
		$testData = array_shift( $testData->GetArray() );

		array_walk_recursive( $testData, 'normalizeLevelData' );

		if( !isPassable( $testData ) ) {
			xmlErr( '1', 'Nie mozesz wejsc na to pole !' );
		}

		$mapData = createMapDataXML( $sqlData );
		$xmlData->appendChild( $mapData );

		$domAction = $dom->createElement( 'action', 'move' );
		$domAction->setAttribute( 'dir', $_POST['dir'] );
		$xmlData->appendChild( $domAction );

		$domMapInfo = $dom->createElement( 'mapInfo' );
		$xmlData->appendChild( $domMapInfo );

		$tmp = $dom->createElement( 'posx', $test['x'] );
		$domMapInfo->appendChild( $tmp );
		$tmp = $dom->createElement( 'posy', $test['y'] );
		$domMapInfo->appendChild( $tmp );

		$player->level_x = $test['x'];
		$player->level_y = $test['y'];

		echo $dom->saveXML();
		break;
	}
}

?>