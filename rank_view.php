<?php

require_once( "includes/preinit.php" );

$title = "Podgl±d rang";
makeHeader();

$ranks = SqlExec( "SELECT id,name,color,image,salary,`desc` FROM ranks WHERE id > 1" );
$ranks = $ranks->GetArray();
$pls = SqlExec( "SELECT id, user, rid FROM players WHERE rid > 1" );
$pls = $pls->GetArray();

foreach( $ranks as $rk => $rv) {
	$amount = 0;
	$ranks[$rk]['users'] = array();
	foreach( $pls as $pl ) {
		if( $pl['rid'] == $rv['id'] ) {
			$ranks[$rk]['users'][] = $pl;
			$amount ++;
		}
	}
	$ranks[$rk]['amount'] = $amount;
}

//qDebug( $ranks );
$smarty->assign( "Ranks", $ranks );
$smarty->display( "rank_view.tpl" );

require_once( "includes/foot.php" );

?>