<?php

require_once('includes/head.php');

$t = SqlExec( "SELECT t.*, p1.user AS user_from, p2.user AS user_to FROM transfer t LEFT JOIN players p1 ON p1.id=t.from LEFT JOIN players p2 ON p2.id=t.to" );
$t = $t->GetArray();
echo "<table border=1><tr></tr>";
foreach( $t as $val ) {
	echo "<tr><td>{$val['id']}</td><td>{$val['user_from']} ({$val['from']})</td><td>{$val['user_to']} ({$val['to']})</td><td>{$val['what']}</td><td>{$val['amount']}</td><td>".date( "Y-m-d H:i", $val['date'] )."</td></tr>";
}
echo "</table>";

require_once('includes/foot.php');
?>