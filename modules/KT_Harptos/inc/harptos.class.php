<?php

class HarptosCalendar {
	private $_t;
	private $_monthTab;
	private $_yearOffset;
	function __construct( $timestamp ) {
		$this->_t = $timestamp;
		$this->_monthTab= array( array( 30, 'M³ot' ),
					// Swieto
					array( 1, '¦ródzimie' ),
					array( 30, 'Alturiak' ),
					array( 30, 'Ches' ),
					array( 30, 'Tarsakh' ),
					//Swieto
					array( 1, 'Zielone Trawy' ),
					array( 30, 'Mirtul' ),
					array( 30, 'Kythorn' ),
					array( 30, 'Flamerule' ),
					//Swieto
					array( 1, '¦ródlecie' ),
					array( 30, 'Eleasis' ),
					array( 30, 'Eleint' ),
					//Swieto
					array( 1, 'Obfite Plony' ),
					array( 30, 'Marpenoth' ),
					array( 30, 'Uktar' ),
					//Swieto
					array( 1, '¦wiêto Ksiê¿yca' ),
					array( 30, 'Nocal' ) );
		$this->_yearOffset = 1370;
	}
	
	//function getMont
	
	function getMonthOffset() {
		$days = date( 'z', $this->_t );
		$daysPassed = 0;
		$monthOffset = 0;
		$monthTab =& $this->_monthTab;
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
		return $monthOffset;
	}
	
	function getDayOfMonth() {
		$days = date( 'z', $this->_t );
		$day = ( $days - $this->getMonthOffset() ) % 30 + 1;
		return $day;
	}
	
	function getDayOfWeek() {
		$day = $this->getDayOfMonth();
		$day = $day%10 + 1;
		return $day;
	}
	
	function getMonth( $raw = false ) {
		$days = date( 'z', $this->_t );
		$daysPassed = 0;
		$monthOffset = 0;
		$monthTab =& $this->_monthTab;
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
		if( $raw ) {
			return $i;
		}
		else {
			return $i - $monthOffset;
		}
	}
	
	function getMonthName() {
		return $this->_monthTab[$this->getMonth(true)][1];
	}
	
	function getDaysInMonth() {
		return $this->_monthTab[$this->getMonth(true)][0];
	}
	
	function getYear() {
		$year = $this->_yearOffset + date( 'y' );
		return $year;
	}
	
	function setDate( $timestamp ) {
		$this->_t = $timestamp;
	}
	
	function getDate() {
		return $this->_t;
	}
	
	function date( $format ) {
		if( strpos( $format, "d" ) !== FALSE ) {
			$format = str_replace( "d", sprintf( "%02d", $this->getDayOfMonth() ), $format );
		}
		if( strpos( $format, "D" ) !== FALSE ) {
			$format = str_replace( "D", $this->getDayOfMonth(), $format );
		}
		if( strpos( $format, "m" ) !== FALSE ) {
			$format = str_replace( "m", $this->getMonth(), $format );
		}
		if( strpos( $format, "M" ) !== FALSE ) {
			$format = str_replace( "M", $this->getMonth( true ), $format );
		}
		if( strpos( $format, "Y" ) !== FALSE ) {
			$format = str_replace( "Y", $this->getYear(), $format );
		}
		return $format;
	}
}

?>