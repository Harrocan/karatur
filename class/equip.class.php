<?php
/**
*
*   (C) 2006-2007 Kara-Tur Team based on Vallheru Team
*
*   @name    equip.class.php
*   @author  IvaN <ivan@o2.pl>
*   @version 0.1
*   @since   29.01.2007
* 	@package KaraTur
* 	@subpackage Depreciated
*	@ignore 
*
*/

$_ItemsTables = array( 'W' => 'items_wpn', 'A' => 'items_arm', 'H' => 'items_arm' );


/**
* 	@package KaraTur
* 	@subpackage Depreciated
*	@ignore 
*
*/
class Item {
	private $data;
	private $req;
	private $mod;
	private $tblname;
	public $SqlDebug;
	public $created;
	public $type;

	function __construct( $type = NULL, $id = NULL ) {
		if( $id === NULL || $type === NULL) {
			$this -> created = FALSE;
			return FALSE;
		}
		$this -> SqlDebug = TRUE;
		switch( $type ) {
			case 'W' :
				$this -> tblname = 'items_wpn';
				break;
			case 'A' :
				$this -> tblname = 'items_arm';
				break;
			default :
				trigger_error( "Nieodslugiwany typ przedmiotu !", E_USER_ERROR );
				$this -> created = FALSE;
				return FALSE;
		}
		$this -> tblname = 'items_all';
		if( !is_array( $id ) ) {
			$item = $this -> SqlExec( "SELECT * FROM items_all WHERE id=$id" );
			$item = array_shift( $item -> GetArray() );
			if( empty( $item ) ) {
				trigger_error( "Proba otworzenia przedmiotu o id $id. Taki przedmiot nie istnieje !", E_USER_WARNING );
				$this -> created = FALSE;
				return FALSE;
			}
		}
		else {
			$item = $id;
		}
		$dataarr = array( 'id', 'pid', 'type', 'prefix', 'prefid', 'name', 'suffix', 'suffid', 'dur', 'durmax', 'amount', 'weight', 'status' );
		switch( $type ) {
			case 'W' :
				$dataarr[] = 'powmin';
				$dataarr[] = 'powmax';
				$dataarr[] = 'twohand';
				break;
			case 'A' :
				$dataarr[] = 'armor';
				break;
		}
		$reqarr = array( 'reqlevel', 'reqstr', 'reqdex', 'reqspd', 'reqcon', 'reqint', 'reqwis' );
		$modarr = array( 'modstr', 'moddex', 'modspd', 'modcon', 'modint', 'modwis' );

		foreach( $dataarr as $field ) {
			$this -> data[$field] = $item[$field];
		}
		foreach( $reqarr as $field ) {
			$f = str_replace( 'req', '', $field );
			$this -> req[$f] = $item[$field];
		}
		foreach( $modarr as $field ) {
			$f = str_replace( 'mod', '', $field );
			$this -> mod[$f] = $item[$field];
		}

		if( $this -> data['prefix'] ) {
			$base = $this -> data['name'];
			$app = 'y';
			$letter = substr( $base, -1, 1 );
			if( $letter == 'i' || $letter == 'y' ) {
				$app = 'e';
			}
			if( $letter == 'a' ) {
				$app = 'a';
			}
			$this -> data['prefix'] .= $app;
		}
		$this -> type = $type;
		$this -> created = TRUE;
	}

	function __get( $field ) {
		switch( $field ) {
			case 'name' :
				$base = $this -> data['name'];
				$suffix = $this -> data['suffix'];
				$prefix = $this -> data['prefix'];
				$name = '';
				if( $prefix )
					$name .= $prefix." ";
				$name .= $base;
				if( $suffix )
					$name .= " ".$suffix;
				return ucfirst( strtolower( $name ) );
			case 'id':
			case 'dur' :
			case 'durmax' :
			case 'type' :
			case 'amount' :
			case 'status' :
				return $this -> data[$field];
			case 'powmin' :
			case 'powmax' :
				if( $this -> type != 'W' ) {
					trigger_error( "Nie mozna pobrac $field - nieprawidlowy typ przedmiotu !", E_USER_ERROR );
					return FALSE;
				}
				return $this -> data[$field];
			case 'armor' :
				if( !in_array( $this -> type, array( 'A' ) ) ) {
					trigger_error( "Nie mozna pobrac $field - nieprawidlowy typ przedmiotu !", E_USER_ERROR );
					return FALSE;
				}
				return $this -> data[$field];
			default :
				trigger_error( "Proba pobrania niedozwolonego pola $field !", E_USER_ERROR );
				return FALSE;
		}
	}

	function AddPrefix( $prefid ) {
		if( $this -> data['prefid'] ) {
			trigger_error( "{$this->name} posiada juz przedrostek !", E_USER_WARNING );
			return FALSE;
		}
		$pref = $this -> SqlExec( "SELECT * FROM items_prefix WHERE id=$prefid" );
		$pref = array_shift( $pref -> GetArray() );
		if( empty( $pref ) ) {
			trigger_error( "Nie ma takiego przedrostka !", E_USER_ERROR );
			return FALSE;
		}
		$mods = $this -> SqlExec( "SELECT * FROM items_mods WHERE id IN ({$pref['mods']})" );
		$mods = $mods -> GetArray();
		//print_r( $mods );
		$this -> prefix = $pref['name'];
		$this -> prefid = $pref['id'];
		foreach( $mods as $mod ) {
			$modstr = 'mod'.$mod['modfield'];
			$this -> $modstr = $this -> mod[$mod['modfield']] + rand( $mod['modmin'], $mod['modmax'] );
		}
	}

	function AddSuffix( $suffid ) {
		if( $this -> data['suffid'] ) {
			trigger_error( "{$this->name} posiada juz przyrostek !", E_USER_WARNING );
			return FALSE;
		}
		$suff = $this -> SqlExec( "SELECT * FROM items_suffix WHERE id=$suffid" );
		$suff = array_shift( $suff -> GetArray() );
		if( empty( $suff ) ) {
			trigger_error( "Nie ma takiego przyrostka !", E_USER_ERROR );
			return FALSE;
		}
		$mods = $this -> SqlExec( "SELECT * FROM items_mods WHERE id IN ({$suff['mods']})" );
		$mods = $mods -> GetArray();
		//print_r( $mods );
		$this -> suffix = $suff['name'];
		$this -> suffid = $suff['id'];
		foreach( $mods as $mod ) {
			$modstr = 'mod'.$mod['modfield'];
			$this -> $modstr = $this -> mod[$mod['modfield']] + rand( $mod['modmin'], $mod['modmax'] );
		}
	}

	function __set( $field, $val ) {
		switch( $field ) {
			case 'modstr':
			case 'moddex':
			case 'modspd':
			case 'modcon':
			case 'modint':
			case 'modwis':
				$this -> SqlExec( "UPDATE {$this->tblname} SET $field = $val WHERE id={$this->id}" );
				$f = str_replace( 'mod', '', $field );
				$this -> mod[$f] = $val;
				break;
			case 'prefix':
				$this -> SqlExec( "UPDATE {$this->tblname} SET prefix = '$val' WHERE id={$this->id}" );
				$base = $this -> data['name'];
				$app = 'y';
				$letter = substr( $base, -1, 1 );
				if( $letter == 'i' || $letter == 'y' ) {
					$app = 'e';
				}
				if( $letter == 'a' ) {
					$app = 'a';
				}
				$this -> data['prefix'] = $val.$app;
				break;
			case 'suffix' :
				$this -> SqlExec( "UPDATE {$this->tblname} SET suffix = '$val' WHERE id={$this->id}" );
				$this -> data['suffix'] = $val;
				break;
			case 'prefid':
			case 'suffid':
			case 'status':
				$this -> SqlExec( "UPDATE {$this->tblname} SET `$field` = '$val' WHERE id={$this -> id}" );
				break;
			//array( 'id', 'pid', 'type', 'prefix', 'prefid', 'name', 'suffix', 'suffid', 'powmin', 'powmax', 'dur', 'durmax', 'amount' );
			case 'dur':
			case 'amount':
				if( $val <= 0 ) {
					SqlExec( "DELETE FROM {$this->tblname} WHERE id={$this->id}" );
					//unset( $this );
				}
				else {
					$this -> SqlExec( "UPDATE {$this->tblname} SET `$field` = '$val' WHERE id={$this->id}" );
					$this -> data[$field] = $val;
				}
				break;
			case 'durmax':
				$this -> SqlExec( "UPDATE {$this->tblname} SET `$field` = '$val' WHERE id={$this->id}" );
				$this -> data[$field] = $val;
				break;
			case 'tblname':
				return $this -> tblname;
			default :
				trigger_error( "Proba ustawienia niedozwolonego pola $field !", E_USER_ERROR );
				return FALSE;
		}
	}

	function GetReq( $field ) {
		if( !isset( $this -> req[$field] ) ) {
			trigger_error( "Wymaganie $field nie istnieje !", E_USER_ERROR );
			return FALSE;
		}
		return $this -> req[ $field ];
	}

	function GetMod( $field ) {
		if( !isset( $this -> mod[$field] ) ) {
			trigger_error( "Modyfikator $field nie istnieje !", E_USER_ERROR );
			return FALSE;
		}
		return $this -> mod[$field];
	}

	function GetArray() {
		$tmparr = $this -> data;
		foreach( $this -> req as $key => $req ) {
			$tmparr["req{$key}"] = $req;
		}
		foreach( $this -> mod as $key => $mod ) {
			$tmparr["mod{$key}"] = $mod;
		}
		return $tmparr;
	}

	function Delete () {
		SqlExec( "DELETE FROM items_all WHERE id={$this->id}");
	}

	function SqlExec( $sql ) {
		global $db;
		if( !is_array( $sql ) ) {
			if( $this -> SqlDebug === TRUE ) {
				trigger_error( "Wykonuje zapytanie: $sql", E_USER_NOTICE );
			}
			//echo $sql;
			$return = $db -> Execute( $sql ) or trigger_error( "Nie moge wykonac zapytania: $sql<br>".$db -> ErrorMsg(), E_USER_ERROR );
			if( strcasecmp( substr( $sql, 0, 6 ), 'INSERT' ) === 0 ) {
				$return = $db -> Insert_ID();
			}
			return $return;
		}
		else {
			foreach( $sql as $key => $query ) {
				if( $this -> SqlDebug === TRUE ) {
					trigger_error( "Wykonuje zapytanie: [$key] => $query", E_USER_NOTICE );
				}

				$return[$key] = $db -> Execute( $query ) or trigger_error( "Nie moge wykonac zapytania: [$key] => $query<br>".$db -> ErrorMsg(), E_USER_ERROR );
				if( strcasecmp( substr( $query, 0, 6 ), 'INSERT' ) === 0 ) {
					$return[$key] = $db -> Insert_ID();
				}
			}
			return $return;
		}
	}
}

/**
* 	@package KaraTur
* 	@subpackage Depreciated
*	@ignore 
*
*/
class Container {
	private $items;
	private $amount;
	private $pid;
	private $tables;

	function __construct( $pid ) {
		$this -> pid = $pid;
		$this -> items = array();
		$this -> amount = 0;
	}

	function ItemsLoad( $type = NULL, $status = NULL ) {
		//if( !isset( $this -> tables[$type] ) ) {
		//	trigger_error( "Nie moge wczytac typu $type ! Nieznana tablica !", E_USER_ERROR );
		//	return FALSE;
		//}
		$tblname = 'items_all';
		$sql = "SELECT * FROM $tblname WHERE pid={$this->pid}";
		if( $type != NULL ) {
			$sql .= " AND `type`='$type'";
		}
		if( $status != NULL ) {
			$sql .= " AND `status`='$status'";
		}
		$res = SqlExec( $sql );
		$res = $res -> GetArray();
		foreach( $res as $item ) {
			$this-> items[] = new Item( $item['type'], $item );
			$this -> amount ++;
		}
	}

	function ItemSearch( $searcharr ) {
		$tmparr = array();
		foreach( $this -> items as $key => $item ) {
			$tmparr[$key] = $item -> GetArray();
		}
		print_r( $tmparr );
		$return = array();
		$amount = count( $searcharr );
		foreach( $tmparr as $key => $item ) {
			if( count( array_intersect_assoc( $searcharr, $item ) ) == $amount ) {
				$return[$key] = $this -> items[$key];
			}
		}
		return $return;
	}

	function ItemAdd( $type, $item ) {
		$search = $item;
		$item['pid'] = $this -> pid;
		unset( $search['id'], $search['amount'], $search['pid'], $item['id'] );
		$res = $this ->ItemSearch( $search );
		print_r( $search );
		return;
		if( empty( $res ) ) {
			if( in_array( $type, array( 'W' ) ) ) {
				$tblname = 'items_all';
			}
			if( in_array( $type, array( 'A' ) ) ) {
				$tblname = 'items_all';
			}
			$sql = SqlCreate( "INSERT", $tblname, $item );
			echo $sql;
			$insert = SqlExec( $sql );
			$item['id'] = $insert;
			$this -> items[] = new Item( $type, $item );
		}
		else {
			$key = key( $res );
			$this -> items[$key] -> amount ++;
		}
	}

	function ItemSet( $key, $arr ) {
		if( !isset( $this -> items[$key] ) ) {
			trigger_error( "Przedmiot $key nie istnieje !", E_USER_ERROR );
			return FALSE;
		}
		foreach( $arr as $key1 => $val ) {
			$this -> items[$key] -> $key1 = $val;
			if( ( $key1 == 'amount' || $key1 == 'dur' ) && $val <= 0 ) {
				unset( $this -> items[$key] );
				break;
			}
		}
	}

	function ItemUnset( $key ) {
		if( !isset( $this -> items[$key] ) ) {
			trigger_error( "Przedmiot nr $key nie istnieje !", E_USER_ERROR );
			return FALSE;
		}
		unset( $this -> items[$key] );
	}
}

?>
