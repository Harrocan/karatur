<?php

if( !class_exists( "HarptosCalendar" ) ) {
	requireFile( "harptos.class.php" );
}

$dayDuration = 60*60*24;
$now = time()+$dayDuration;
$cal = new HarptosCalendar( $now );
$nowDay = $cal->getDate();

$date = $now-$dayDuration*15;

$cal->setDate($date);

//echo $cal->date( "D-M-Y-d-d" );

$dayOfWeek = $cal->getDayOfWeek();
//echo $dayOfWeek;
echo "<table class='table' style='margin:0px auto'><tr><td colspan='10' class='thead' style='text-align:center'>Kalendarz Harptosa</td></tr><tr>";
$tmp = $cal->getMonthName();
echo "<td colspan='10'>$tmp</td></tr><tr>";
if( $dayOfWeek < 10 ) {
	for( $i = 0; $i < $dayOfWeek; $i++ ) {
		echo "<td></td>";
	}
}
$WeekOffset = 0;
for( $i = 0; $i < 30; $i++ ) {
	$oldMonth = $cal->getMonth(true);
	if( $nowDay == $cal->getDate() ) {
		$style="background:green";
	}
	else {
		$style = "";
	}
	echo "<td style='font-size:0.8em;$style'>";
	echo $cal->getDayOfMonth();
	echo "</td>";
	if( $cal->getDaysInMonth() == 1 ) {
		//$WeekOffset++;
	}
	//$dayOfWeek ++;
	$date += $dayDuration;
	$cal -> setDate( $date );
	if( $cal->getDayOfWeek() + $WeekOffset == 10 ) {
		echo "</tr><tr>";
		//$dayOfWeek = 0;
	}
	if( $cal->getMonth(true) != $oldMonth ) {
		for( $j = $cal->getDayOfWeek() + $WeekOffset; $j < 10; $j++ ) {
			echo "<td></td>";
		}
		$tmp = $cal->getMonthName();
		if( $cal->getDaysInMonth() == 1 ) {
			if( $nowDay == $cal->getDate() ) {
				$style="background:green";
			}
			else {
				$style = "";
			}
			echo "</tr><tr><td colspan='10' style='text-align:center;$style'><i>$tmp</i></td>";
			$WeekOffset++;
			$date += $dayDuration;
			$cal -> setDate( $date );
		}
		$tmp = $cal->getMonthName();
		echo "</tr><tr><td colspan='10'>$tmp</td></tr><tr>";
		for( $j = 0; $j < $cal->getDayOfWeek()+$WeekOffset; $j++ ) {
			echo "<td></td>";
		}
	}
}
$dayOfWeek = $cal->getDayOfWeek();
for( $i = $dayOfWeek ; $i < 10; $i++ ) {
	//echo "<td></td>";
}
echo "</tr></table>";
//echo $dayOfWeek;
?>