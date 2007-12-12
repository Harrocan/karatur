<?php

require_once( "includes/preinit.php" );

$data = SqlExec( "SELECT z.id, z.date, z.solve, p.user, h.date AS solve_date, h.type AS h_type FROM zgloszenia z CROSS JOIN players p ON z.solve_id=p.id LEFT JOIN zgl_history h ON z.id=h.zid WHERE z.type='V'" );


$data = $data->getArray();

qDebug( count( $data ) );

echo "<table border='1'>";
foreach( $data as $row ) {
	if( $row['h_type'] == 'MSG' ) {
		continue;
	}
	if( $row['solve'] == 'Y' ) {
		$row['diff'] = $row['solve_date'] - $row['date'];
	}
	else {
		$row['diff'] = 0;
	}
	
	if( $row['diff'] ) {
		$h = $row['diff']/(60*60*24);
		//$g = $row['diff']/(60*60);
		$row['diff'] = round($h,2);
	}
	else {
		$row['diff'] = '';
	}
	
	$row['date'] = date( 'Y-m-d H:i', $row['date'] );
	
	echo "<tr>";
	echo "<td>{$row['id']}</td>";
	echo "<td>{$row['user']}</td>";
	echo "<td>{$row['diff']}</td>";
	echo "<td>{$row['date']}</td>";
	

	echo "<td>{$row['solve']}</td>";
	echo "<td>{$row['h_type']}</td>";
	echo "</tr>";
}
echo "</table>";

$db->Close();

?>