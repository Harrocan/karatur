<?php
$title="Edycja mapy";
require_once('includes/head.php');


if( !getRank( 'mapedit' ) ) {
	error("Nie masz uprawnieñ !");
}

if( !isset( $_GET['step'] ) ) {
	$_GET['step'] = '';
}

$map['maxx'] = 58;
$map['maxy'] = 47;
$map['minx'] = 26;
$map['miny'] = 20;

if( empty( $_SESSION['edycja_mapy'] ) ) {
	//$mapData =& $_SESSION['edycja_mapy'];
	$mapSess['x'] = $player->mapx;
	$mapSess['y'] = $player->mapy;
	$_SESSION['edycja_mapy'] = $mapSess;
	//echo "setting new coords<br/>";
}
else {
	//	unset( $_SESSION['edycja_mapy']);
}

$mapSess =& $_SESSION['edycja_mapy'];

if( !empty( $_POST['move'] ) ) {
	//qDebug( $_POST );
	if( isset( $_POST['move']['up'] ) ) {
		$mapSess['y'] -=6;
	}
	if( isset( $_POST['move']['down'] ) ) {
		$mapSess['y'] +=6;
	}
	if( isset( $_POST['move']['left'] ) ) {
		$mapSess['x'] -=6;
	}
	if( isset( $_POST['move']['right'] ) ) {
		$mapSess['x'] +=6;
	}
}
///qDebug( $mapSess ); 
if( empty( $_GET['step'] ) ) {
	$offset = 6;
	$minX = $mapSess['x'] - $offset;
	$maxX = $mapSess['x'] + $offset;
	$minY = $mapSess['y'] - $offset;
	$maxY = $mapSess['y'] + $offset;
	//qDebug( $player->mapx);
	$data = SqlExec( "SELECT * FROM mapa WHERE zm_x >= $minX AND zm_x < $maxX AND zm_y >= $minY AND zm_y < $maxY" );
	$data = $data->GetArray();
	foreach( $data as $k => $v ) {
		//qDebug( $v );
		$data[$k] = processMapRef( $v );
	}
	
	$mapData = array();
	for( $x = $minX; $x < $maxX; $x++ ) {
		for( $y = $minY; $y < $maxY; $y++ ) {
			$mapData[$y][$x] = array( 'name' => '' );
		}
	}
	foreach( $data as $item ) {
		$mapData[$item['zm_y']][$item['zm_x']] = $item;
	}
	$smarty->assign( "MapLim", $map );
	$smarty->assign( "MapData", $mapData );
}

if( $_GET['step'] == 'edit' ) {
	if( !empty( $_POST ) ) {
		
		if( $_POST['ref_id'] ) {
			$ref = explode( "x", $_POST['ref_id'] );
			$test = SqlExec( "SELECT id FROM mapa WHERE zm_x={$ref[1]} AND zm_y={$ref[0]}" );
			if( !$test->fields['id'] ) {
				error( "Nieprawid³owo zdefiniowane pole jako '³±cze' !" );
			}
			$_POST['ref_id'] = $test->fields['id'];
		}
		qDebug( $_POST );
		//error( "" );
		$where['zm_x'] = $_POST['map_x'];
		$where['zm_y'] = $_POST['map_y'];
		$fields = array( 'name', 'file', 'country', 'opis', 'geo', 'flora', 'type', 'dost', 'ref_id' );
		foreach( $fields as $k=>$f ) {
			if( isset( $_POST[$f] ) ) {
				$fields[$f] = $_POST[$f];
			}
			unset( $fields[$k] );
		}
		if( empty( $fields['ref_id'] ) ) {
			$fields['ref_id'] = '0';
		}
		$test = SqlExec( "SELECT id FROM mapa WHERE zm_x={$where['zm_x']} AND zm_y={$where['zm_y']}" );
		if( $test->fields['id'] ) {
			$sql = SqlCreate( "UPDATE", "mapa", $fields, $where );
		}
		else {
			$fields['zm_x'] = $where['zm_x'];
			$fields['zm_y'] = $where['zm_y'];
			$sql = SqlCreate( "INSERT", "mapa", $fields );
		}
		qDebug( $sql );
		SqlExec( $sql );
		error( "Mapa zaktualizowana !", 'done' );
	}
	if( empty( $_GET['x'] ) || empty( $_GET['y'] ) ) {
		error( "Nieprawid³owe ¿±danie !" );
	}
	$el = SqlExec( "SELECT * FROM mapa WHERE zm_x={$_GET['y']} AND zm_y={$_GET['x']}" );
	if( $el->fields['id'] ) {
		$el = array_shift( $el->GetArray() );
	}
	else {
		$el = array( 'zm_x' => $_GET['y'], 'zm_y' => $_GET['x'] );
	}
	$tmp = array( 'id', 'zm_x', 'zm_y', 'name', 'file', 'country', 'opis', 'geo', 'flora', 'dost', 'type');
	foreach( $tmp as $t ) {
		if( !isset( $el[$t] ) ) {
			$el[$t] = '';
		}
	}
	if( !isset( $el['ref_id'] ) ) {
		$el['ref_id'] = '0';
	}
	else {
		$test = SqlExec( "SELECT id, zm_x, zm_y FROM mapa WHERE id={$el['ref_id']}" );
		$el['ref_x'] = $test->fields['zm_x'];
		$el['ref_y'] = $test->fields['zm_y'];
	}
	$smarty->assign( "Elem", $el );
}

$smarty->assign( array( "Step" => $_GET['step'] ) );
$smarty->display( 'edycja_mapy.tpl' );

require_once('includes/foot.php');
?>