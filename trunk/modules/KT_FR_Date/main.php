<?php

$monthTab = array( array( 30, 'Hammer' ),
					// Swieto
					array( 1, 'Midwinter' ),
					array( 30, 'Alturiak' ),
					array( 30, 'Ches' ),
					array( 30, 'Tarsakh' ),
					//Swieto
					array( 1, 'Greengrass' ),
					array( 30, 'Mirtul' ),
					array( 30, 'Kythorn' ),
					array( 30, 'Flamerule' ),
					//Swieto
					array( 1, 'Midsummer' ),
					array( 30, 'Eleasis' ),
					array( 30, 'Eleint' ),
					//Swieto
					array( 1, 'Highharvestide' ),
					array( 30, 'Marpenoth' ),
					array( 30, 'Uktar' ),
					//Swieto
					array( 1, 'The Feast of the Moon' ),
					array( 30, 'Nighthal' ) );
$yearTab = array( 1377 => 'Nawiedzeñ', 'Kot³a' );
$year = 1370 + date( 'y' );
$yearName = $yearTab[$year];
$days = date( 'z' );
//$month = floor( $days / 30 );
$daysPassed = 0;
$monthOffset = 0;
for( $i = 0; $i < count( $monthTab ); $i++ ) {
	//echo $daysPassed . "<br/>";
	$daysInMonth = $monthTab[$i][0];
	if( $daysPassed <= $days && $daysPassed+$daysInMonth>$days ) {
		break;
	}
	if( $daysInMonth == 1 ) {
		$monthOffset++;
	}
	$daysPassed += $daysInMonth;
}
$index = $i;
$monthName = $monthTab[$index][1];
$month = $index - $monthOffset;
$day = ( $days - $monthOffset ) % 30 + 1;
$week = floor( $day/10 ) + 1;

for( $i = 0; $i < 12; $i++ ) {
	//echo $i*30 . "<br/>";
}

$hour = date( 'H:i' );

echo <<<EOD
<div style="text-align:center">
Godzina $hour<br/>
EOD;

if( $daysInMonth > 1 ) {
echo <<<EOD
$day $monthName roku $year<br/>$days dzieñ roku $yearName
EOD;
}
else {
	echo <<<EOD
Dzis jest $monthName ... bawmy sie !!
EOD;
}

echo <<<EOD
</div>
EOD;
//echo "Y $year, T $days, M $month, W $week, D $day"

?>