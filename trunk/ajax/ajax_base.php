<?php

class ajaxData {
	private $fields;

	function __construct() {
		$this->fields = array();
	}

	function addField( $name, $value ) {
		if( !is_array( $value ) ) {
			$this->fields[] = "$name=".htmlspecialchars( $this->normalize( $value ) );
		}
		else {
			$msg = "$name?";
			$tab = array();
			foreach( $value as $key => $val ) {
				$tab[] = "$key=".htmlspecialchars( $this->normalize( $val ) );
			}
			$msg .= implode( "&", $tab );
			$this->fields[] = $msg;
		}
	}

	function normalize( $str ) {
		//return strtr( $str, "±жкісу¶їј¦", "acelnoszzS" );
		return rawurlencode( iconv("ISO-8859-2", "UTF-8", $str ) );
	}

	function arr2string( $arr ) {
		$fields = array();
		foreach( $arr as $key => $val ) {
			if( is_array( $val ) ) {
			}
			else {
				$fields[] = "$key=$val";
			}
		}
	}

	function clear() {
		$this->fields = array();
	}

	//function __set( $name, $value

	function send() {
		echo implode( "\n", $this->fields );
	}
	
	function __destruct() {
		global $db;
		$db->Close();
	}
}

require_once( '../includes/config.php' );

if( !$db ) {
	die( "cant connect !" );
}
require_once( '../includes/globalfunctions.php' );
require_once( '../class/player.class.php' );
require_once( '../includes/sessions.php' );

$ajax = new ajaxData;

function err( $msg ) {
	$ajaxErr = new ajaxData;
	$ajaxErr -> addField( 'type', 'ERROR' );
	$ajaxErr -> addField( 'value', $msg );
	$ajaxErr -> send();
	//echo "ERR~$msg";
	die();
}

function xmlErr( $code, $text ) {
	global $dom;
	$errData = $dom->createElement( 'error', $text );
	$errData->setAttribute( 'code', $code );
	while( $dom->hasChildNodes() ) {
		$dom->removeChild( $dom->firstChild );
	}

	$dom->appendChild( $errData );
	echo $dom->saveXML();
	die();
}

function createMapDataXML( $sqlData ) {
	//$dom = new DOMDocument( "1.0", 'iso-8859-2' );
	//qDebug( $sqlData );
	global $dom;
	$mapData = $dom->createElement( 'mapData' );
	foreach( $sqlData as $k => $v ) {
		parse_str( $sqlData[$k]['img'], $sqlData[$k]['img'] );
		//qDebug( $sqlData[$k] );
		$x = $v['x'];
		$y = $v['y'];
		//$ajax->addField( "map_{$x}_{$y}_img_amount", count( $data[$k]['img'] ) );
		$cell = $dom->createElement( 'cell' );
		$mapData->appendChild( $cell );
		$cell->setAttribute( 'x', $x );
		$cell->setAttribute( 'y', $y );
		$cellImg = $dom->createElement( 'img' );
		$cell->appendChild( $cellImg );
		foreach( $sqlData[$k]['img'] as $el ) {
			$imgLevel = $dom->createElement( 'entry' );
			$imgLevel->setAttribute( 'file', $el['file'] );
			$imgLevel->setAttribute( 'level', $el['level'] );
			$imgLevel->setAttribute( 'sub', $el['sub'] );
			$imgLevel->setAttribute( 'pass', $el['passable'] );
			$cellImg->appendChild( $imgLevel );
			//$ajax->addField( "map_{$x}_{$y}_img_{$n}", $tmp );
		}
	}
	return $mapData;
}

?>