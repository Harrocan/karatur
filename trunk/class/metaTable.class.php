<?php

/**
 * Klasa do obslugi meta-tabeli.
 * 
 * Klasa wczytuje, dodaje i usuwa dane z meta-tabel. Tabele musza miec okreslona konstrukcje zeby dzialac. Dozwolona dowolna glebokosc meta-tabel.
 * 
 * @author IvaN
 * @copyright Kara-Tur Team 2006-2007
 * @since 21-07-2007
 * @package KaraTur
 *
 */
class MetaTable {
	
	
	private $_tabName;
	private $_priName;
	private $_priVal;
	private $_colName;
	
	/**
	 * Konstruktor, tworzy obiekt zapamietujac podstawowe dane
	 *
	 * @param string $tableName Nazwa meta-tabeli w bazie
	 * @param string $primaryKeyName Nazwa pseudo-glownego klucza
	 * @param string $primaryKeyValue Wartosc pseufo-glownego klucza
	 * @param string $colName Nazwa kolumn, ktore sa kolejnymi wymiarami
	 */
	function __construct( $tableName, $primaryKeyName, $primaryKeyValue, $colName ) {
		$this->_tabName = $tableName;
		$this->_priName = $primaryKeyName;
		$this->_priVal = $primaryKeyValue;
		$this->_colName = $colName;
	}
	
	
	/**
	 * Funkcja wczytujaca fragment meta-tabeli.
	 *
	 * @param string|array $cols,... Kolejne wymiary
	 * @return array
	 */
	function loadData( $cols = NULL ) {
		
		$colName = $this->_colName;
		//$primaryKeyName = "mid";
		$numArgs = func_num_args( );
	
		//qDebug( $cols );
		$fields = array();
	
		$fields[$this->_priName] = $this->_priVal;
	
		if ( !is_array( $cols ) ) {
			//$cols = array( $cols );
			for( $i = 0; $i < $numArgs; $i++ ) {
				$arg = func_get_arg( $i );
				if( strlen( $arg ) > 0 ) {
					$ti = $i + 1;
					$fields["{$colName}{$ti}"] = func_get_arg( $i );
				}
			}
		}
		else {
			$cols = array_values( $cols );
	
			for( $i = 0; $i < count( $cols ); $i++ ) {
				$ti = $i + 1;
				$fields["{$colName}{$ti}"] = $cols[$i];
			}
		}
	
		//qDebug( $fields );
		$testSql = SqlCreate( "SELECT", $this->_tabName, "*", $fields );
		//qDebug( $testSql );
		$testSql = SqlExec( $testSql );
		$numCols = $testSql->fieldCount( );
	
		$testSql = $testSql->GetArray( );
		//qDebug( $testSql );
		$testSql = $this->_pivotTable( $testSql, $numCols - 2 );
		//qDebug( $testSql );
		$ret = $testSql;
	
		if ( !is_array( $cols ) ) {
			//$cols = array( $cols );
			//$cols = array();
			//$cols[$primaryKeyName] = $primaryKey;
			for( $i = 0; $i < $numArgs; $i++ ) {
				$ti = $i + 1;
				$arg = func_get_arg( $i );
	
				//echo "$arg | ";
				if ( isset( $ret[$arg] ) ) {
					$ret = $ret[$arg];
				}
				else {
					$ret = FALSE;
					break;
				}
			//$cols["{$colName}{$ti}"] = func_get_arg( $i );
			}
		//echo "<br/>";
		}
		else {
			//echo "arr :: ";
			for( $i = 0; $i < count( $cols ); $i++ ) {
				$arg = $cols[$i];
	
				//echo "$arg | ";
				if ( isset( $ret[$arg] ) ) {
					$ret = $ret[$arg];
				}
				else {
					$ret = FALSE;
					break;
				}
			}
		}
	
		//qDebug( $ret );
		
		return $ret;	
	}
	
	function saveData( $value, $cols = NULL ) {

		$numArgs = func_num_args( );
	
		$fields = array();
		$colName = $this->_colName;
	
		$fields[$this->_priName] = $this->_priVal;
	
		if ( !is_array( $cols ) ) {
			//$cols = array( $cols );
	
			for( $i = 1; $i < $numArgs; $i++ ) {
				$ti = $i;
				$fields["{$colName}{$ti}"] = func_get_arg( $i );
			}
		}
		else {
			$cols = array_values( $cols );
	
			for( $i = 0; $i < count( $cols ); $i++ ) {
				$ti = $i + 1;
				$fields["{$colName}{$ti}"] = $cols[$i];
			}
		}
	
		//qDebug( $fields );
		$testSql = SqlCreate( "SELECT", $this->_tabName, 'value', $fields );
		//qDebug( $testSql );
		$test = SqlExec( $testSql );
	
		//$test = $test -> GetArray();
		//qDebug( $test->fields['value'] );
		//var_dump( $test->fields );
		if ( $test->fields['value'] ) {
			$sql = SqlCreate( "UPDATE", $this->_tabName, array('value' => $value), $fields );
		}
		else {
			$fields['value'] = $value;
			$sql = SqlCreate( "INSERT", $this->_tabName, $fields );
		}
	
		//qDebug( $sql );
		SqlExec ( $sql );

		return TRUE;
	}
	
	function deleteData( $cols = NULL ) {
		$numArgs = func_num_args( );
	
		//qDebug( $cols );
		$fields = array();
		$colName = $this->_colName;
	
		$fields[$this->_priName] = $this->_priVal;
	
		if ( !is_array( $cols ) ) {
			//$cols = array( $cols );
			for( $i = 0; $i < $numArgs; $i++ ) {
				$ti = $i + 1;
				$fields["{$colName}{$ti}"] = func_get_arg( $i );
			}
		}
		else {
			$cols = array_values( $cols );
	
			for( $i = 0; $i < count( $cols ); $i++ ) {
				$ti = $i + 1;
				$fields["{$colName}{$ti}"] = $cols[$i];
			}
		}
	
		//qDebug( $fields );
		//$testSql = SqlCreate( "SELECT", $tableName, "*", $fields );
		$sql = SqlCreate( "DELETE", $this->_tabName, NULL, $fields );
		//qDebug( $sql );
		$affected = SqlExec( $sql );
		//qDebug ( $foo );
		return $affected;
	}
	
	function getPrimaryKey() {
		return $this->_priVal;
	}
	
	function setPrimaryKey( $newValue ) {
		$this->_priVal = $newValue;
	}
	
	/**
	 * Zwraca wszystkie klucze pseudo-glowne, znajdujace sie w danej meta-tabeli
	 *
	 * @return unknown
	 */
	function getAllPrimaryKeys() {
		$ret = SqlExec( "SELECT `{$this->_priName}` AS `key` FROM `{$this->_tabName}` GROUP BY `{$this->_priName}`" );
		$ret = $ret->GetArray();
		foreach( $ret as $k=>$v ) {
			$ret[$k] = $v['key'];
		}
		qDebug( $ret );
		return $ret;
	}
	
	
	/**
	 * Funkcja 'obraca' otrzymane dane, doprowadzajac je do logicznej formy, przypominajcej tabllice
	 *
	 * @access private
	 * 
	 * @param array $arr tablica wejsciowa
	 * @param int $colNum liczba kolumn
	 * @return array przetworzona tablica
	 */
	private function _pivotTable( $arr, $colNum ) {
		global $__modValid;
		$tab = array();
		$colName = $this->_colName;
		foreach( $arr as $row ) {
			$link =& $tab[$row["{$colName}1"]];
	
			for( $i = 1; $i < $colNum; $i++ ) {
				$ti = $i + 1;
	
				if ( strlen( $row["{$colName}{$ti}"] ) > 0 ) {
					//qDebug( $row["{$colName}{$ti}"] );
					if ( !is_array( $link ) && isset( $link ) ) {
						$tt = '';
						for( $j = 0; $j <= $i; $j++ ) {
							$tj = $j + 1;
							$tt[] = $row["{$colName}{$tj}"];
						}
	
						unset( $j, $tj );
						$tt = implode( " => ", $tt );
						trigger_error( "Nie moge obrocic otrzymanej tabeli !<br/>Prawdopodobny blad wywolany przez <b>$tt</b>", E_USER_WARNING );
	
						if ( isset( $__modValid ) ) {
							$__modValid = false;
						}
	
						return FALSE;
					}
					$tmp = $row["{$colName}{$ti}"];
					$link =& $link["$tmp"];
				}
			}
	
			$link = $row['value'];
		}
		//qDebug( $tab );
		return $tab;
	}
}

?>