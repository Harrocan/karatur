<?php
/**
 * @ignore 
 */

$dbatr = array( 'str' => 'strength',
				'dex' => 'agility',
				'con' => 'wytrz',
				'spd' => 'szyb',
				'int' => 'inteli',
				'wis' => 'wisdom' );

$dbskill = array( 'smith' => 'ability',
					'melee' => 'atak',
					'miss' => 'unik',
					'cast' => 'magia',
					'alchemy' => 'alchemia',
					'ranged' => 'shoot',
					'fletcher' => 'fletcher',
					'leadership' => 'leadership',
					'cook' => 'gotowanie' );

$dbmisc = array( 'id' => 'id',
				'user' => 'user',
				'email' => 'email',
				'level' => 'level',
				'exp' => 'exp',
				'hp' => 'hp',
				'hp_max' => 'max_hp',
				'mana' => 'pm',
				'energy' => 'energy',
				'opis' => 'opis',
				'energy_max' => 'max_energy',
				'tribe_id' => 'tribe',
				'tribe_rank' => 'tribe_rank',
				'rid' => 'rid',
				'location' => 'miejsce',
				'ap' => 'ap',
				'race' => 'rasa',
				'clas' => 'klasa',
				'charakter' => 'charakter',
				'deity' => 'deity',
				'gender' => 'gender',
				'poch' => 'poch',
				'wlos' => 'wlos',
				'skora' => 'skora',
				'oczy' => 'oczy',
				'wins' => 'wins',
				'losses' => 'losses',
				'lastkilled' => 'lastkilled',
				'lastkilledby' => 'lastkilledby',
				'age' => 'age',
				'logins' => 'logins',
				'ip' => 'ip',
				'lpv' => 'lpv',
				'gg' => 'gg',
				'avatar' => 'avatar',
				'immu' => 'immu',
				'corepass' => 'corepass',
				'trains' => 'trains',
				'fight' => 'fight',
				'maps' => 'maps',
				'rest' => 'rest',
				'page' => 'page',
				'profile' => 'profile',
				'crime' => 'crime',
				'style' => 'style',
				//'graphic' => 'graphic',
				'stan' => 'stan',
				'przemiana' => 'przemiana',
				'tow' => 'tow',
				'kat' => 'kat',
				'vote' => 'vote',
				'mapx' => 'mapx',
				'mapy' => 'mapy',
				'file' => 'file',
				'newbie' => 'newbie',
				'jail' => 'jail',
				'temp' => 'temp',
				'bridge' => 'bridge',
				'faith' => 'pw',
				'kuchnia' => 'gotow',
				'burdel' => 'burdel',
				// Pimp my shit
				'ugryziony' => 'ugryziony',
				'ilosc_ugryz' => 'ilosc_ugryz',
				'krew' => 'krew',
				'max_krew' => 'max_krew',
				'ugryz' => 'ugryz',
				'przez' => 'przez',
				'przemieniony_przez' => 'przemieniony_przez' );

$dbres = array( 'gold' => 'gold',
				'bank' => 'bank',
				'mithril' => 'mithril',
				'copper' => 'copper',
				'iron' => 'iron',
				'coal' => 'coal',
				'adamantium' => 'adamantium',
				'meteor' => 'meteor',
				'crystal' => 'crystal',
				'wood' => 'wood',
				'illani' => 'illani',
				'illanias' => 'illanias',
				'nutari' => 'nutari',
				'dynallca' => 'dynallca',
				'fish' => 'fish',
				'grzyby' => 'grzyb',
				'potato' => 'potato' );

$dbmoved = array( 'credits', 'platinum', 'bank', 'ryby', 'grzyby', 'ziemniaki' );

$oldtrash = array( 'rank', 'aktorstwo', 'aktor', 'bles', 'chaos', 'soul' );


/**
 * Klasa do modyfikacji danych gracza innego niz 'biezacy'
 * 
 * @author IvaN
 * @copyright KaraTur-Team 2006-2007
 * @version 0.2
 * @package KaraTur
 *
 */
class playerManager {
	private $id;
	public $SqlDebug;
	
	private $dbatr;
	
	private $dbskill;
	
	private $dbmisc;
	
	private $dbres;
	
	function __construct( $pid ) {
		global $dbatr;
		global $dbskill;
		global $dbmisc;
		global $dbres;
		
		$this -> dbatr = $dbatr;
		$this -> dbskill = $dbskill;
		$this -> dbmisc = $dbmisc;
		$this -> dbres = $dbres;
			
		$this->id = $pid;
		$this->SqlDebug = false;
	}
	
	private function prepareGet( $field, $arrname, $tabname ) {
		$tab =& $this->$arrname;
		if( !is_array( $field ) ) {
			$field = explode( ",", $field );
		}
		$fields = array();
		foreach( $field as $val ) {
			if( !in_array( $val, array_keys( $tab ) ) ) {
				trigger_error( "Nie istnieje taka wartosc: $val !", E_USER_ERROR );
			}
			$fields[] = "`".$tab[$val]."`";
		}
		$fields = implode( ",", $fields );
		return "SELECT $fields FROM `$tabname` WHERE id={$this->id}";
	}
	
	private function prepareSet( $field, $val, $arrname, $tabname ) {
		$tab =& $this->$arrname;
		if( !is_array( $field ) ) {
			$field = explode( ",", $field );
		}
		if( !is_array( $val ) ) {
			$val = explode( ",", $val );
		}
		$fields = array();
		foreach( $field as $key => $item ) {
			if( !in_array( $item, array_keys( $tab ) ) ) {
				trigger_error( "Nie istnieje taka wartosc: $item !", E_USER_ERROR );
			}
			$fields[] = "`".$tab[$item]."`='$val[$key]'";
		}
		$fields = implode( ", ", $fields );
		return "UPDATE $tabname SET $fields WHERE id={$this->id}";
	}
	
	private function prepareAdd( $field, $val, $arrname, $tabname ) {
		$tab =& $this->$arrname;
		if( !is_array( $field ) ) {
			$field = explode( ",", $field );
		}
		if( !is_array( $val ) ) {
			$val = explode( ",", $val );
		}
		$fields = array();
		foreach( $field as $key => $item ) {
			if( !in_array( $item, array_keys( $tab ) ) ) {
				trigger_error( "Nie istnieje taka wartosc: $item !", E_USER_ERROR );
			}
			$fields[] = "`{$tab[$item]}`=`{$tab[$item]}`".( ($val[$key]>=0)?"+":"-" )."'".abs($val[$key])."'";
		}
		$fields = implode( ", ", $fields );
		return "UPDATE $tabname SET $fields WHERE id={$this->id}";
	}
	
	function getAtr( $field ) {
		$sql = $this->prepareGet( $field, 'dbatr', 'players' );
		$ret = $this->SqlExec( $sql );
		$ret = array_shift( $ret->GetArray() );
		//print_r( $ret );
		return $ret[$this->dbatr[$field]];
	}
	
	function setAtr( $field, $val ) {
		$sql = $this->prepareSet( $field, $val, 'dbatr', 'players' );
		//echo $sql;
		$this->SqlExec( $sql );
		$this->PutSignal( 'atr' );
	}
	
	function addAtr( $field, $val ) {
		$sql = $this->prepareAdd( $field, $val, 'dbatr', 'players' );
		//echo $sql;
		$this->SqlExec( $sql );
		$this->PutSignal( 'atr' );
	}
	
	function getSkill( $field ) {
		$sql = $this->prepareGet( $field, 'dbskill', 'players' );
		$ret = $this->SqlExec( $sql, TRUE );
		$ret = array_shift( $ret->GetArray() );
		//print_r( $ret );
		return $ret[$this->dbskill[$field]];
	}
	
	function setSkill( $field, $val ) {
		$sql = $this->prepareSet( $field, $val, 'dbskill', 'players' );
		//echo $sql;
		$this->SqlExec( $sql );
		$this->PutSignal( 'skill' );
	}
	
	function addSkill( $field, $val ) {
		$sql = $this->prepareAdd( $field, $val, 'dbskill', 'players' );
		//echo $sql;
		$this->SqlExec( $sql );
		$this->PutSignal( 'skill' );
	}
	
	function getMisc( $field ) {
		$sql = $this->prepareGet( $field, 'dbmisc', 'players' );
		$ret = $this->SqlExec( $sql, TRUE );
		$ret = array_shift( $ret->GetArray() );
		//print_r( $ret );
		return $ret[$this->dbmisc[$field]];
	}
	
	function setMisc( $field, $val ) {
		$sql = $this->prepareSet( $field, $val, 'dbmisc', 'players' );
		//echo $sql;
		$this->SqlExec( $sql );
		$this->PutSignal( 'misc' );
	}
	
	function addMisc( $field, $val ) {
		$sql = $this->prepareAdd( $field, $val, 'dbmisc', 'players' );
		//echo $sql;
		$this->SqlExec( $sql );
		$this->PutSignal( 'misc' );
	}
	
	function getRes( $field ) {
		$sql = $this->prepareGet( $field, 'dbres', 'resources' );
		$ret = $this->SqlExec( $sql, TRUE );
		$ret = array_shift( $ret->GetArray() );
		//print_r( $ret );
		return $ret[$this->dbres[$field]];
	}
	
	function setRes( $field, $val ) {
		$sql = $this->prepareSet( $field, $val, 'dbres', 'resources' );
		//echo $sql;
		$this->SqlExec( $sql );
		$this->PutSignal( 'res' );
	}
	
	function addRes( $field, $val ) {
		$sql = $this->prepareAdd( $field, $val, 'dbres', 'resources' );
		//echo $sql;
		$this->SqlExec( $sql );
		$this->PutSignal( 'res' );
	}
	
	function delete() {
		$this->SqlExec( "DELETE FROM akta WHERE pid={$this->id}" );
		$this->SqlExec( "DELETE FROM alchemik_plany WHERE pid={$this->id}" );
		$this->SqlExec( "DELETE FROM bank WHERE pid={$this->id}" );
		$this->SqlExec( "DELETE FROM core WHERE owner={$this->id}" );
		$this->SqlExec( "DELETE FROM core_market WHERE seller={$this->id}" );
		$this->SqlExec( "DELETE FROM czary WHERE gracz={$this->id}" );
		$this->SqlExec( "DELETE FROM equipment WHERE owner={$this->id}" );
		$this->SqlExec( "DELETE FROM farm WHERE owner={$this->id}" );
		$this->SqlExec( "DELETE FROM farms WHERE owner={$this->id}" );
		$this->SqlExec( "DELETE FROM hmarket WHERE seller={$this->id}" );
		$this->SqlExec( "DELETE FROM houses WHERE owner={$this->id}" );
		$this->SqlExec( "DELETE FROM jail WHERE prisoner={$this->id}" );
		$this->SqlExec( "DELETE FROM kowal WHERE gracz={$this->id}" );
		$this->SqlExec( "DELETE FROM kowal_plany WHERE pid={$this->id}" );
		$this->SqlExec( "DELETE FROM log WHERE owner={$this->id}" );
		$this->SqlExec( "DELETE FROM mail WHERE owner={$this->id}" );
		$this->SqlExec( "DELETE FROM mikstury WHERE gracz={$this->id}" );
		$this->SqlExec( "DELETE FROM mill_plany WHERE pid={$this->id}" );
		$this->SqlExec( "DELETE FROM mines WHERE pid={$this->id}" );
		$this->SqlExec( "DELETE FROM notatnik WHERE gracz={$this->id}" );
		$out = $this->SqlExec( "SELECT id FROM outposts WHERE owner={$this->id}" );
		$out = $out->fields['id'];
		$this->SqlExec( "DELETE FROM outposts WHERE owner={$this->id}" );
		if( $out ) {
			$this->SqlExec( "DELETE FROM outpost_monsters WHERE outpost={$out}" );
			$this->SqlExec( "DELETE FROM outpost_veterans WHERE outpost=$out" );
		}
		$this->SqlExec( "DELETE FROM players WHERE id={$this->id}" );
		$this->SqlExec( "DELETE FROM pmarket WHERE seller={$this->id}" );
		$this->SqlExec( "DELETE FROM questaction WHERE player={$this->id}" );
		$this->SqlExec( "DELETE FROM reset WHERE player={$this->id}" );
		$this->SqlExec( "DELETE FROM resources WHERE id={$this->id}" );
		$this->SqlExec( "DELETE FROM skazani WHERE id={$this->id}" );
		$this->SqlExec( "DELETE FROM sklepy WHERE owner={$this->id}" );
		$this->SqlExec( "DELETE FROM toplista WHERE pid={$this->id}" );
	}
	
	private function PutSignal( $signal ) {
		$res = $this->SqlExec( "SELECT pid FROM wakeup WHERE `pid`='{$this->id}' AND `type`='$signal'" );
		if( empty( $res->fields['pid'] ) ) 
			$this->SqlExec( "INSERT INTO wakeup(pid,`type`) VALUES({$this->id},'$signal')" );
		return TRUE;
	}
	
	function SqlExec( $sql ) {
		global $db;
		if( !is_array( $sql ) ) {
			if( $this -> SqlDebug === TRUE ) {
				trigger_error( "Wykonuje zapytanie: $sql<br>", E_USER_NOTICE );
			}
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

?>