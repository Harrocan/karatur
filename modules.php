<?php

require_once( "includes/preinit.php" );

//$valid = testModule( $_GET['mod'] );
$test = SqlExec( "SELECT `title` FROM modules WHERE `name` = '{$_GET['mod']}' " );
$test = $test->GetArray();

if( !empty( $test ) ) {
	$test = array_shift( $test );
	$title = $test['title'];
}
else {
	$title = "Moduly";
}

makeHeader();

checklocation();

$smarty->force_compile = true;
runModule( $_GET['mod'] );

require_once( 'includes/foot.php' );

?>