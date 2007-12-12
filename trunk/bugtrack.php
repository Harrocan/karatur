<?

$title = "Bugtrack";
require_once('includes/head.php');

if( !empty( $_GET['action'] ) && $_GET['action'] == 'solve' ) {
	if( $player -> id != 267 ) {
		error( "Nie jestes upowazniony do rozwiazywania bugow !" );
	}
	if( empty( $_GET['id'] ) )
		error( "Podaj numer zgloszenia !" );
	$id = intval( $_GET['id'] );
	$res = SqlExec( "SELECT id,new FROM bugtrack WHERE id=$id" );
	if( $res -> fields['id'] ) {
		if( $res -> fields['new'] == 'N' )
			error( "To zgloszenie zostalo juz oznaczone jako rozwiazane !" );
		SqlExec( "UPDATE bugtrack SET `new`='N', solveid={$player->id} WHERE id=$id", $_sqldebug );
	}
	else
		error( "Nie ma takiego zgloszenia !" );
}

$bugs = SqlExec( "SELECT b.*, p.user FROM bugtrack b LEFT JOIN players p ON b.solveid=p.id WHERE b.new = 'Y' ORDER BY b.`new` ASC, b.`time` ASC" );
$bugs = $bugs -> GetArray();
foreach( $bugs as $key => $bug ) {
	$bugs[$key]['time'] = date( 'Y/m/d H:i', $bug['time'] );
	$bugs[$key]['num'] = sprintf( "%06d", $bug['id'] );
}
//print_r( $bugs );
$smarty -> assign( "Bugs", $bugs );

$smarty -> display('bugtrack.tpl');

require_once('includes/foot.php');

?>