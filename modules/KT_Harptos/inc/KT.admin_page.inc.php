<?php

requireFile( "harptos.class.php" );

$dayDuration = 60*60*24;
$cal = new HarptosCalendar( time() - 15*$dayDuration );

$dateOptions = array();
for( $i = 0; $i < 30; $i++ ) {
	$fmt = $cal -> date( "d-M-Y" );
	$dateOptions[ $cal->getMonthName() ][$fmt] = $cal->getDayOfMonth() . " " . $cal->getMonthName() . " " . $cal->getYear();
	$cal->setDate( $cal->getDate() + $dayDuration );
}
//qDebug( $dateOptions );
$smarty->assign( "Dates", $dateOptions );
$smarty->display( "harptos_admin_page.tpl" );

?>