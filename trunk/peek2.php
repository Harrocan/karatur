<?php

require_once( "includes/preinit.php" );

$rs = SqlExec( "SELECT * FROM `req_log` ORDER BY `time` DESC" );
$rs = $rs->getArray();

echo "<table border='1'><tr><td>gdzie</td><td>kto</td><td>o ktorej</td></tr>";
foreach( $rs as $row ) {
	echo "<tr><td>{$row['url']}</td><td>{$row['id']}</td><td>".date( "H:i:s d-m-Y", $row['time'] )."</td></tr>";
}
echo "</table>";

if( empty( $rs ) ) {
	echo "Brak wpisów ...";
}

$db->Close();

?>