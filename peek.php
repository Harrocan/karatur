<?php

require_once( "includes/preinit.php" );

$rs = SqlExec( "SELECT * FROM `test`" );
$rs = $rs->getArray();

echo "<table border='1'><tr><td>gdzie</td><td>kto</td><td>o ktorej</td></tr>";
foreach( $rs as $row ) {
	echo "<tr><td>{$row['page']}</td><td>{$row['id']}</td><td>".date( "H:i:s d-m-Y", $row['time'] )."</td></tr>";
}
echo "</table>";

if( empty( $rs ) ) {
	echo "Brak wpisów ...";
}

$db->Close();

?>