<?php

require_once( "includes/preinit.php" );

$title = "Rejestr zmian";
makeHeader();

if( !isset( $_GET['view'] ) ) {
	$_GET['view'] = '';
}

if( empty( $_GET['view'] ) ) {
	$changes = SqlExec( "SELECT c.*, p.user, m.title, m.name FROM changelog c LEFT JOIN players p ON p.id = c.owner LEFT JOIN modules m ON m.id=c.meta ORDER BY c.date DESC" );
	$changes = $changes->GetArray();
	require_once( "includes/bbcode.php" );
	foreach( $changes as $k => $c ) {
		$c['body'] = bb2html( $c['body'] );
		$type = $c['type'];
		if( $type == 'core' ) {
			$changes[$c['date']][$type][] = $c;
		}
		elseif( $type =='module' ) {
			$changes[$c['date']][$type][$c['title']][] = $c;
		}
		unset( $changes[$k] );
	}
	//qDebug( $changes );
	$smarty->assign( "Changes", $changes );
}

if( $_GET['view'] == 'add' ) {
	if( !getRank( "changelog" ) ) {
		error( "Nie mozesz dodawac wpisow do rejestru zmian !" );
	}
	if( !empty( $_POST ) ) {
		//qDebug( $_POST );
		if( !empty( $_POST['date-now'] ) ) {
			$date = date( "Y-m-d", time() );
		}
		else {
			if( empty( $_POST['date'] ) ) {
				error( "Podaj date !", 'error', "?view=add" );
			}
			$date = $_POST['date'];
			$test = strtotime( $date );
			$month = date( "m", $test );
			$day = date( "d", $test );
			$year = date( "Y", $test );
			if( !checkdate( $month, $day, $year ) ) {
				error( "Nieprawidlowa data !", 'error', "?view=add" );
			}
		}
		$toAdd['date'] = $date;
		$toAdd['owner'] = $player->id;
		$toAdd['type'] = 'core';
		$toAdd['meta'] = '0';
		foreach( $_POST['change'] as $item ) {
			$toAdd['body'] = $item;
			$sql = SqlCreate( "INSERT", "changelog", $toAdd );
			//qDebug( $sql );
			SqlExec( $sql );
		}
		$total = count( $_POST['change'] );
		error( "Dodano $total zmian do dnia $date", 'done', "?" );
	}
}

$smarty->assign( array( "View" => $_GET['view'], "Rank_changelog" => getRank( "changelog" ) ) );
$smarty->display( "changelog.tpl" );

require_once( "includes/foot.php" );

?>