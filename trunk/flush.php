<?php

require_once( "includes/preinit.php" );

$data = SqlExec( "SHOW PROCESSLIST" );
$data = $data->getArray();
//qDebug( $data );

$amount = 0;
foreach( $data as $row ) {
	if( $row['Command'] == 'Sleep' && $row['Time'] > 20 ) {
		SqlExec( "KILL {$row['Id']}" );
		$amount++;
	}
}

qDebug( "Killed $amount idle processes" );

$db->Close();

?>