<?php

require_once( "includes/preinit.php" );

$title = "Tworzenie gracza";
makeHeader();

$crt =& $_SESSION['creation'];
$cDone = FALSE;

if( strlen( $player->oczy ) ) {
	error( "Twoja postaæ ju¿ jest utworzona ! ", 'error', 'stats.php' );
}

$deityTab = array( 'lathander', 'tempus', 'selune', 'tyr', 'bane', 'loth', 'maska', 'shar', 'talos' );

$famTab = array( 'sokol' => array( 'name' => 'Sokol',
									'str' => 0,
									'dex' => 0,
									'con' => 0,
									'spd' => 5,
									'int' => 0,
									'wis' => 0 ),
				'lasica' => array( 'name' => 'Lasica',
									'str' => 0,
									'dex' => 5,
									'con' => 0,
									'spd' => 0,
									'int' => 0,
									'wis' => 0 ),
				'szczur' => array( 'name' => 'Szczur',
									'str' => 0,
									'dex' => 0,
									'con' => 5,
									'spd' => 0,
									'int' => 0,
									'wis' => 0 ),
				'pies' => array( 'name' => 'Pies',
									'str' => 5,
									'dex' => 0,
									'con' => 0,
									'spd' => 0,
									'int' => 0,
									'wis' => 0 ),
				'kot' => array( 'name' => 'Kot',
									'str' => 0,
									'dex' => 0,
									'con' => 0,
									'spd' => 0,
									'int' => 5,
									'wis' => 0 ),
				'pseudosmok' => array( 'name' => 'Pseudosmok',
									'str' => 0,
									'dex' => 0,
									'con' => 0,
									'spd' => 0,
									'int' => 0,
									'wis' => 5 ),
				'waz' => array( 'name' => 'Waz',
									'str' => 0,
									'dex' => 1,
									'con' => 1,
									'spd' => 1,
									'int' => 1,
									'wis' => 1 ) );

if( !empty( $_POST ) ) {
	//qDebug( $_POST );
	switch( $_POST['action'] ) {
		case 'welcome' :
			$crt['welcome'] = $_POST['welcome'];
			break;
		case 'race' :
			if( !isset( $_POST['race'] ) ) {
				error( "Nieprawid³owe ¿±danie" );
			}
			$test = SqlExec( "SELECT name FROM races WHERE code_name='{$_POST['race']}'" );
			if( !strlen( $test->fields['name'] ) ) {
				error( "Nieprawid³owe ¿±danie !" );
			}
			$crt['race'] = $_POST['race'];
			break;
		case 'gender' :
			if( !in_array( $_POST['gender'], array( 'male', 'female' ) ) ) {
				error( "Nieprawid³owe ¿±danie !" );
			}
			$crt['gender'] = $_POST['gender'];
			break;
		case 'class' :
			if( !isset( $_POST['class'] ) ) {
				error( "Nieprawid³owe ¿±danie" );
			}
			$test = SqlExec( "SELECT name FROM classes WHERE code_name='{$_POST['class']}'" );
			if( !strlen( $test->fields['name'] ) ) {
				error( "Nieprawid³owe ¿±danie !" );
			}
			$crt['class'] = $_POST['class'];
			break;
		case 'deity' :
			if( !in_array( $_POST['deity'], $deityTab ) ) {
				error( "Nieprawid³owe ¿±danie !" );
			}
			$crt['deity'] = $_POST['deity'];
			break;
		case 'atr' :
			$atrArr = array( 'str', 'dex', 'con', 'spd', 'int', 'wis' );
			$total = 0;
			foreach( $atrArr as $el ) {
				if( !isset( $_POST['atr'][$el] ) ) {
					error( "Nieprawid³owe ¿±danie ! " );
				}
				$total += $_POST['atr'][$el];
			}
			if( $total != $player->ap ) {
				error( "Nieprawid³owe ¿±danie !" );
			}
			$crt['atr'] = $_POST['atr'];
			$crt['atr']['left'] = 0;
			break;
		case 'familiar' :
			if( !isset( $famTab[$_POST['familiar']] ) ) {
				error( "Nieprawid³owe ¿±danie !" );
			}
			$crt['familiar'] = $_POST['familiar'];
			break;
		case 'origin' :
			$test = SqlExec( "SELECT name FROM mapa WHERE id='{$_POST['origin']}'" );
			if( !$test->fields['name'] ) {
				error( "Nierpawid³owe ¿±danie !" );
			}
			$crt['origin'] = $_POST['origin'];
			break;
		case 'misc' :
			$els = array( 'stan', 'char', 'wlos', 'oczy', 'skora' );
			foreach( $els as $el ) {
				if( empty( $_POST[$el] ) ) {
					error( "Nieprawid³owe ¿±danie !" );
				}
				$tmp[$el] = $_POST[$el];
			}
			$crt['misc'] = $tmp;
			unset( $tmp );
			break;
		case 'done' :
			$oldraw = $player -> RawReturn;
			$player -> RawReturn = TRUE;
			$rName = SqlExec( "SELECT * FROM races WHERE code_name='{$crt['race']}'" );
			$player->race = $rName->fields['name'];
			$clName = SqlExec( "SELECT * FROM classes WHERE code_name='{$crt['class']}'" );
			$player->clas = $clName->fields['name'];
			$player->gender = ( $crt['gender']=='male')?"M":"F";
			$player->tow = $famTab[$crt['familiar']]['name'];
			$orName = SqlExec( "SELECT name, `zm_x`, `zm_y`, `file` FROM mapa WHERE id={$crt['origin']}" );
			$player->poch = $orName->fields['name'];
			$player -> mapx = $orName->fields['zm_x'];
			$player -> mapy = $orName->fields['zm_y'];
			$player -> file = $orName->fields['file'];
			//$summ['misc'] = $crt['misc'];
			$player->deity = ucfirst( $crt['deity'] );
			$player->wlos = $crt['misc']['wlos'];
			$player->oczy = $crt['misc']['oczy'];
			$player->skora = $crt['misc']['skora'];
			$player->charakter = $crt['misc']['char'];
			$player->stan = $crt['misc']['stan'];
			$atrArr = array( 'str', 'dex', 'con', 'spd', 'int', 'wis' );
			foreach( $atrArr as $el ) {
				//qDebug( "{$player->$el} + {$crt['atr'][$el]} * ( {$rName->fields[$el]} + {$clName->fields[$el]} )" );
				$player->$el = $player->$el + $crt['atr'][$el] * ( $rName->fields[$el] + $clName->fields[$el] ) + $famTab[$crt['familiar']][$el];
				if( $el == 'con' ) {
					$player->hp_max += $crt['atr'][$el] * ( $rName->fields[$el] + $clName->fields[$el] ) + $famTab[$crt['familiar']][$el];
				}
			}
			$player->ap = 0;
			$player -> RawReturn = $oldraw;
			$crt = NULL;
			$cDone = true;
			break;
		default :
			error( "Nieprawid³owe ¿±danie !" );
	}
}
//qDebug( $crt );
$steps = array( 'welcome', 'gender', 'race', 'class', 'atr', 'deity', 'familiar', 'origin', 'misc', 'done' );

if( isset( $_GET['do'] ) && $_GET['do'] == 'reset' ) {
	$crt = NULL;
}

if( !isset( $crt ) ) {
	if( !$cDone ) {
		$crt = array();
		$crt['atr']['left'] = $player->ap;
	}
}

if( $cDone ) {
	$step = 'done';
}
elseif( !isset( $crt['welcome'] ) ) {
	$step = 'welcome';
}
elseif( !isset( $crt['race'] ) ) {
	$step = 'race';
}
elseif( !isset( $crt['gender'] ) ) {
	$step = 'gender';
}
elseif( !isset( $crt['class'] ) ) {
	$step = 'class';
}
elseif( $crt['atr']['left'] > 0 ) {
	$step = 'atr';
}
elseif( !isset( $crt['deity'] ) ) {
	$step = 'deity';
}
elseif( !isset( $crt['familiar'] ) ) {
	$step = 'familiar';
}
elseif( !isset( $crt['origin'] ) ) {
	$step = 'origin';
}
elseif( !isset( $crt['misc'] ) ) {
	$step = 'misc';
}
else {
	$step = 'done';
}

switch( $step ) {
	case 'race' :
		$rData = SqlExec( "SELECT * FROM races" );
		$rData = $rData->GetArray();
		//qDebug( $rData );
		$smarty->assign( "Races", $rData );
		break;
	case 'gender' :
		break;
	case 'class' :
		$cData = SqlExec( "SELECT id, code_name, name, IF( str=0, 0, str ) AS str, IF( dex=0, 0, dex ) AS dex, IF( con=0, 0, con ) AS con, IF( spd=0, 0, spd ) AS spd, IF( `int`=0, 0, `int` ) AS `int`, IF( wis=0, 0, wis ) AS wis FROM classes" );
		$cData = $cData->GetArray();
		$smarty->assign( "Classes", $cData );
		break;
	case 'alignment' : {
		break;
	}
	case 'atr' :
		$atrArr = array( 'str', 'dex', 'con', 'spd', 'int', 'wis' );
		$rData = SqlExec( "SELECT * FROM races WHERE code_name='{$crt['race']}'" );
		$rData = array_shift( $rData->GetArray() );
		$cData = SqlExec( "SELECT id, code_name, name, IF( str=0, 0, str ) AS str, IF( dex=0, 0, dex ) AS dex, IF( con=0, 0, con ) AS con, IF( spd=0, 0, spd ) AS spd, IF( `int`=0, 0, `int` ) AS `int`, IF( wis=0, 0, wis ) AS wis FROM classes WHERE code_name='{$crt['class']}'" );
		$cData = array_shift( $cData -> GetArray() );
		foreach( $atrArr as $el ) {
			$atr[$el]['base'] = sprintf("%01.3f",  $player->$el );
			$atr[$el]['race'] = $rData[$el];
			$atr[$el]['class'] = $cData[$el];
			//$atr[$el]['add'] = ( isset())
		}
		//qDebug( $atr );
		$smarty->assign( array( "AtrArr" => $atrArr, "Atr" => $atr ) );
		break;
	case 'deity' :
		$smarty->assign( "Deity", $deityTab );
		break;
	case 'familiar' :
		$smarty->assign( "Fam", $famTab );
		break;
	case 'origin' :
		$cityData = SqlExec( "SELECT id, name, opis FROM mapa WHERE `type`='C' GROUP BY name ORDER BY name ASC" );
		$cityData = $cityData->GetArray();
		//qDebug( $cityData);
		$smarty->assign( "CityData", $cityData );
		break;
	case 'done' :
		//qDebug( $crt );
		if( !$cDone ) {
			$summ = array();
			$rName = SqlExec( "SELECT * FROM races WHERE code_name='{$crt['race']}'" );
			$summ['race'] = $rName->fields['name'];
			$clName = SqlExec( "SELECT * FROM classes WHERE code_name='{$crt['class']}'" );
			$summ['class'] = $clName->fields['name'];
			$summ['gender'] = ( $crt['gender']=='male')?"Mê¿czyzna":"Kobieta";
			$summ['familiar'] = ucfirst( $crt['familiar'] );
			$orName = SqlExec( "SELECT name FROM mapa WHERE id={$crt['origin']}" );
			$summ['origin'] = $orName->fields['name'];
			$summ['misc'] = $crt['misc'];
			$summ['deity'] = ucfirst( $crt['deity'] );
			$atrArr = array( 'str', 'dex', 'con', 'spd', 'int', 'wis' );
			foreach( $atrArr as $el ) {
				//qDebug( "{$player->$el} + {$crt['atr'][$el]} * ( {$rName->fields[$el]} + {$clName->fields[$el]} )" );
				$summ['atr'][$el] = $player->$el + $crt['atr'][$el] * ( $rName->fields[$el] + $clName->fields[$el] ) + $famTab[$crt['familiar']][$el];
			}
			//qDebug( $summ );
			$smarty->assign( "Summ", $summ );
		}
		break;
}

$smarty->assign( array( "Crt" => $crt,
						"Step" => $step,
						"Created" => $cDone ) );

$smarty->display( "create.tpl" );

require_once( "includes/foot.php" );

?>