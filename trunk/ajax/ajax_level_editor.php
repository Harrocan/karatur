<?php

require_once( 'ajax_base.php' );

if( empty( $_SESSION['player'] ) ) {
	err( "SESS_EXPIRE" );
}

$player =& $_SESSION['player'];

$tilesPath = 'images/map_tiles/';

switch( $_POST['action'] ) {
	case 'nodelist' : {
		$dir = '../' . $tilesPath;
		$fileext = array( 'gif', 'jpg', 'png' );
		$cat_dirs = array( '1', '2', '3', '4' );
		$i = 0;
		foreach( $cat_dirs as $cat ) {
			$files = scandir( $dir . '/' . $cat );
			foreach( $files as $k => $v ) {
				$subdir = $dir . '/' . $cat . '/' . $v;
				if( is_dir( $subdir ) ) {
					$sub = $v;
					$nodes = scandir( $subdir );
					foreach( $nodes as $node ) {
						$ext = array_pop( explode( ".", $node ) );
						if( !( is_dir( $dir . $v ) || $v == '.' || $v == '..' || !in_array( $ext, $fileext ) ) ) {
							//unset( $files[$k] );
							$tmp = array();
							$tmp['file'] = $node;
							$tmp['level'] = $cat;
							$tmp['sub'] = $sub;
							$tmp['passable'] = (int)( !( $cat == '2' ) );
							$ajax->addField( 'node_' . $i, $tmp );
							$i++;
						}
					}
				}
			}
		}
		//$files = array_values( $files );
		//print_r( $files );
		$ajax->addField( 'type', 'nodelist');
		$ajax->addField( 'amount', $i );

		$ajax->send();
		break;
	}
	case 'mapsave' : {
		//qDebug( $_POST );
		$mapInfo =& $_POST['mapInfo'];
		$mapData =& $_POST['map'];
		if( !isset( $mapInfo['id'] ) ) {
			//echo "creating new entry";
			$test = SqlExec( "SELECT id FROM levels WHERE `name`='{$mapInfo['name']}'" );
			if( $test->fields['id'] ) {
				$mapInfo['id'] = $test->fields['id'];
			}
			else {
				$toAdd = array( 'name' => $mapInfo['name'], 'size_x' => $mapInfo['size_x'], 'size_y' => $mapInfo['size_y'] );
				$newIdSql = SqlCreate( "INSERT", "levels", $toAdd );
				echo $newIdSql;
				$newId = SqlExec( $newIdSql );
				$mapInfo['id'] = $newId;
			}
			qDebug( $mapInfo );
			//$newId = SqlCreate
		}

		SqlExec( "DELETE FROM level_data WHERE level_id = {$mapInfo['id']}" );
		foreach( $mapData as $x => $row ) {
			foreach( $row as $y => $cell ) {
				$imgData = http_build_query( $cell['img'] );
				$toAdd['level_id'] = $mapInfo['id'];
				$toAdd['x'] = $x;
				$toAdd['y'] = $y;
				$toAdd['img'] = $imgData;
				$sql = SqlCreate( "INSERT", "level_data", $toAdd );
				//echo $sql . "\n";
				SqlExec( $sql );
				//qDebug( $cell['img'] );
			}
		}
		break;
	}
	case 'loadmap' : {
	   	header('Content-type: application/xml;charset=iso-8859-2');
		$dom = new DOMDocument( "1.0", 'iso-8859-2' );
		$xmlData = $dom->createElement( 'data' );
		$dom->appendChild( $xmlData );

		$sqlData = SqlExec( "SELECT * FROM level_data WHERE level_id={$_POST['lid']}" );
		$sqlData = $sqlData->getArray();

		$mapData = createMapDataXML( $sqlData );
		$xmlData->appendChild( $mapData );

		echo $dom->saveXML();
		break;
	}

}

?>