<?php
/*!
*   Postac gracza przygotowywana pod walke \n
*   Przygotowuje ujednolicone wywolania funkcji do klasy walki \n
*   (C) 2006-2007 Kara-Tur Team based on Vallheru Team
*
*   @name figter_player.class.php
*   @author IvaN <ivan@o2.pl>
*   @version 0.3 beta
*   @since 18.01.2007
*
*/

require_once('player.class.php');

//! Klasa obsugujaca gracza
/*!
 * Zarzadza statystykami walki gracza i zajmuje sie kalkulowaniem wszystkiego
 */

abstract class Fighter {
	abstract function CombatGetVal( $val );
	abstract function CombatEquipWt( $what, $amount );
	abstract function AwardExp( $exp );
	abstract function AwardSkill( $skills );
	abstract function GetWpnType();
	abstract function ApplyChanges();
	abstract function BattleFinish();
	public $hit;

	public $SqlDebug;
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
//				print_r( $db );
			}
			return $return;
		}
	}
}

class Fighter_player Extends Fighter {
	public $pl;
	public $equip;
	public $type;
	private $fatugie;
	private $stats;
	private $statarr;
	private $sync;
	private $apply;
	public $hit;
	function __construct( $pid ) {
		$pl = new Player( $pid );
		if( $pl -> created === FALSE ) {
			trigger_error( "Nie mozna utworzyc obiektu klasy Fighter_player !",E_USER_ERROR);
		}
		$statarr = array( 'str'=>'str','dex'=>'dex','con'=>'con','int'=>'int','spd'=>'spd','wis'=>'wis','hp'=>'hp','hp_max'=>'hp_max','mana'=>'mana','mana_max'=>'mana_max','energy'=>'energy','name'=>'user','id'=>'id','level'=>'level','gold'=>'gold');
		$this -> apply = array( 'mana'=>'mana','energy'=>'energy','gold'=>'gold','hp'=>'hp');
		$this -> statarr = $statarr;
		$this -> pl = $pl;
		$this -> stats = array();
		foreach( $statarr as $key =>$item ) {
			$this -> stats[$key] = $pl -> $item;
		}
		$this -> equip =  $pl -> GetEquipped();
		//print_r( $this -> equip );
		$this -> type = 'player';
		$this -> stats['fatigue'] = $pl -> con;
		$this -> sync = TRUE;
	}
	
	function __get( $val ) {
		return $this -> GetStat( $val );
	}

	function __set( $field, $val ) {
		if( !isset( $this -> stats[$field] ) ) {
			trigger_error( "Nieobslugwiwana wartosc __set :: $field !", E_USER_WARNING );
			return FALSE;
		}
		$this -> stats[$field] = $val;
		$this -> sync = FALSE;
	}

	function GetStat( $stat ) {
		if( !isset( $this -> stats[$stat] ) ) {
			trigger_error( "Nieobslugwiwana wartosc GetStat :: $stat !", E_USER_WARNING );
			return FALSE;
		}
		return $this -> stats[$stat];
		/*
		switch ( $stat ) {
			case 'name' :
				return $this -> pl -> user;
				break;
			case 'hp' :
				return $this -> pl -> hp;
				break;
			case 'con' :
				return $this -> pl -> con;
				break;
			case 'str' :
				return $this -> pl -> str;
				break;
			case 'spd' :
				return $this -> pl -> spd;
			case 'dex' :
				return $this -> pl -> dex;
			case 'fatigue' :
				return 1;
				break;
			default :
				
		}*/
	}
	
	function AwardExp( $exp ){
		if( $exp <= 0 )
			return TRUE;
		$this -> pl -> AwardExp( $exp, TRUE );
		PutSignal( $this -> id, 'misc' );
		return TRUE;
	}
	function AwardSkill( $skills ){
		foreach( $skills as $skill => $amount ) {
			//echo "$skill += $amount || ";
			if( $amount > 0 )
				$this -> pl -> $skill += $amount;
		}
		PutSignal( $this -> id, 'skills' );
		return TRUE;
	}

	function GetWpnType() {
		if( !empty( $this -> equip['spellatk'] ) )
			return 'spell';
		if( !empty( $this -> equip['weapon'] ) )
			return 'weapon';
		return 'none';
	}
	
	//! Modul walki - zwraca statystyki do walki
	/*!
	 * Wstepny modul do walki. Zwraca podstawowe [i wystarczajace] dane do walki. Obecnie zwraca :
	 *     'armor' - sumaryczna wartosc pancerza z uzglednieniem wszystkich modyfikatorow,
	 *               tych z czaru obronnego takze
	 *     'damage' - obrazenia jakie postac zada. Sama uwzglednia czy to czar, luk czy bron.
	 *                takze sama wprowadza zmienna losowa do obrazen. Trzeba pamietac ze
	 *                czar ma wyzszy priorytet niz bron !
	 *     'critical' - szansa na krytyk. Kalkulowana w oparciu o dzierzona bron.
	 *     'miss' - szansa na unikniecie, obliczana z uwzglednieniem premii i kar
	 *     'attack' - szansa na zadanie ciosu. Takze uwzglednia wszelkie mozliwosci, tak jak
	 *                i bron jaka sie uzywa
	 *
	 * @param [field] Wartosc jaka chce sie uzyskac. Patrz wyzej.
	 *
	 * @return Obliczona zadana wartosc
	 */
	function CombatGetVal( $field ) {
		$val = 0;
		$bon = 0;
		$pen = 0;
		switch ( $field ) {
			case 'armor' :
				$val = $this -> con;
				if( !empty( $this -> equip['armor'] ) ) {
					$val += $this -> equip['armor']['power'];
				}
				if( !empty( $this -> equip['shield'] ) ) {
					$val += $this -> equip['shield']['power'];
				}
				if( !empty( $this -> equip['knee'] ) ) {
					$val += $this -> equip['knee']['power'];
				}
				if( !empty( $this -> equip['helm'] ) ) {
					$val += $this -> equip['helm']['power'];
				}
				if( in_array( $this -> pl -> clas, array( 'Wojownik', 'Barbarzynca' ) ) ) {
					$val += $this -> pl -> level;
				}
				if( !empty( $this -> equip['spelldef'] ) ) {
					$mdef = $this -> pl -> wis * $this -> equip['spelldef']['power'];
					if( !empty( $this -> equip['armor'] ) && $this -> equip['armor']['type'] != 'Z' ) {
						$pen += $mdef * ( $this -> equip['armor']['minlev'] / 100 );
					}
					if( !empty( $this -> equip['helm'] ) ) {
						$pen += $mdef * ( $this -> equip['helm']['minlev'] / 100 );
					}
					if( !empty( $this -> equip['shield'] ) ) {
						$pen += $mdef * ( $this -> equip['shield']['minlev'] / 100 );
					}
					if( !empty( $this -> equip['knee'] ) ) {
						$pen += $mdef * ( $this -> equip['knee']['minlev'] / 100 );
					}
					if( !empty( $this -> equip['weapon'] ) && $this -> equip['weapon']['type'] == 'S' ) {
						$bon += $mdef * ( $this -> equip['weapon']['power'] / 100 );
					}
					if( $this -> mana > $this -> equip['spelldef']['power'] )
						$val = $val + $mdef + $bon - $pen;
				}
				return round( $val );
				break;
			case 'damage' :
				if( !empty( $this -> equip['spellatk'] ) ) {
					if( $this -> mana < $this -> equip['spellatk']['minlev'] ) {
						return 0;
					}
					$val = $this -> pl -> int * $this -> equip['spellatk']['power'];
					if( !empty( $this -> equip['armor'] ) ) {
						$pen += $val * ( $this -> equip['armor']['minlev'] / 100 );
					}
					if( !empty( $this -> equip['helm'] ) ) {
						$pen += $val * ( $this -> equip['helm']['minlev'] / 100 );
					}
					if( !empty( $this -> equip['shield'] ) ) {
						$pen += $val * ( $this -> equip['shield']['minlev'] / 100 );
					}
					if( !empty( $this -> equip['knee'] ) ) {
						$pen += $val * ( $this -> equip['knee']['minlev'] / 100 );
					}
					if( !empty( $this -> equip['weapon'] ) && $this -> equip['weapon']['type'] == 'S' ) {
						$bon += $val * ( $this -> equip['weapon']['power'] / 100 );
					}
					$val = $val + $bon - $pen;
					
				}
				else {
					if( empty( $this ->equip['weapon'] ) ) {
						return round( $this -> pl -> str / 2 );
					}
					$val = $this -> equip['weapon']['power'];
					if( $this -> equip['weapon']['type'] == 'W' ) {
						$val += $this -> pl -> str;
						if( $this ->equip['weapon']['poison'] > 0 )
							$val += $this -> equip['weapon']['poison'];
					}
					elseif( $this -> equip['weapon']['type'] == 'B' ) {
						if( empty( $this -> equip['arrows'] ) ) {
							return 0;
						}
						$val += ( $this -> pl -> str + $this -> pl -> dex ) / 2;
						$val += $this -> equip['arrows']['power'];
					}
					
					if( in_array( $this -> pl -> clas, array( 'Wojownik', 'Barbarzynca' ) ) ) {
						$val += $this -> pl -> level;
					}
				}
				$randbon = (rand(1,($this -> pl -> level * 10)));
				$val += $randbon;
				if( $val < 1 )
					$val = 0;
				return round( $val );
				break;
			case 'critical' :
				if( $this -> equip['weapon']['type'] == 'W' ) {
					$key = 'melee';
				}
				elseif( $this -> equip['weapon']['type'] == 'B' ) {
					$key = 'ranged';
				}
				elseif( $this -> equip['weapon']['type'] == 'S' ) {
					$key = 'cast';
				}
				$val = $this -> pl -> GetSkill( $key, FALSE );
				if( $val < 1 )
					$kr = 1;
				elseif( $val < 5 )
					$kr = $val;
				else
					$kr = ( $val / 100 ) + 5;
				return $kr;
				break;
			case 'miss' :
				$val = $this -> pl -> dex + $this -> pl -> miss;
				if( in_array( $this -> pl -> clas, array( 'Wojownik', 'Barbarzynca', 'Lowca' ) ) ) {
					$val += $this -> pl -> level;
				}
				return $val;
				break;
			case 'attack' :
				$val = $this -> pl -> dex;
				if( !empty( $this ->equip['spellatk'] ) ) {
					$val += $this -> pl -> cast;
					if( in_array( $this -> pl -> clas, array( 'Mag' ) ) )
						$val += $this -> pl -> level;
				}
				elseif( !empty ( $this -> equip['weapon'] ) ) {
					if( $this -> equip['weapon']['type'] == 'B' ) {
						$val += $this -> pl -> ranged;
					}
					elseif( $this -> equip['weapon']['type'] == 'W' ) {
						$val += $this -> pl -> melee;
						if( in_array( $this -> pl -> clas, array( 'Wojownik', 'Barbarzynca' ) ) ) {
							$val += $this -> pl -> level;
						}
					}
				}
				return $val;
				break;
			case 'exp' :
				$val = rand( 5, 10 ) * $this -> pl -> level;
				return $val;
			case 'gold' :
				$val = round( $this -> pl -> gold / 10 );
				return $val;
			default :
				trigger_error( "Nieobslugwiwana wartosc $field !", E_USER_WARNING );
				return 0;
				break;
		}
		
	}
	
	//! Zmienianie wytrzymalosci broni
	/*!
	 * 'Uszkadzanie' broni. Teoretycznie przydatne tylko w walce. Zmniejsza wytrzymalosc
	 * noszonego ekwipunku i sprawdza czy juz sie zepsul kompletnie.
	 *
	 * @param [what] okreslenie czesci ekwipunku do 'uszkodzenia'
	 * @param [amount] o ile zmiejszyc wytrzmalosc przedmiotu
	 *
	 * @return TRUE lub FALSE w przypadku niepowodzenia
	 */
	function CombatEquipWt( $what, $amount ) {
		//echo "uszkadzam $what o $amount";
		if( empty( $this -> equip[$what] ) ) {
			//trigger_error( "Ta czesc ekwipunku $what nie istnieje !", E_USER_WARNING );
			return FALSE;
		}
		if( in_array( $this -> equip[$what]['type'], array( 'Z', 'S' ) ) ) {
			return TRUE;
		}
		if( $this -> equip[$what]['type'] == 'B' ) {
			$this -> CombatEquipWt( 'arrows', $amount );
		}
		if( $this -> equip[$what]['wt'] - $amount > 0 ) {
			//$this ->SqlExec( "UPDATE equipment SET wt = wt - $amount WHERE id={$this -> equip[$what]['id']}" );
			$this -> equip[$what]['wt'] -= $amount;
		}
		else {
			//$this -> SqlExec( "DELETE FROM equipment WHERE id={$this -> equip[$what]['id']}" );
			//echo "usuwam {$this->equip[$what]['name']} :: {$this->equip[$what]['id']}!<br>";
			//print_r( $this -> pl -> GetEquipped() );
			
			$this -> pl -> EquipDelete( $this -> equip[$what]['id'], 'equip' );
			//$this -> pl -> Unequip( $what );
			//print_r( $this -> equip[$what] );
			//print_r( $this->pl->GetEquipped() );
			unset( $this -> equip[$what] );
			PutSignal( $this -> id, 'equip' );
		}
		$this -> sync = FALSE;
		return TRUE;
	}
	function ApplyChanges() {
		if( $this -> sync === TRUE ) {
			return;
		}
		//		echo "\t--Synchronizowanie {$this -> name}\n";
		$statch = false;
		foreach( $this -> stats as $key => $stat ) {
			if( isset( $this -> apply[$key] ) ) {
				//echo "\t------- porownanie zmian $key => $stat\n";
				$field = $this -> statarr[$key];
				if( $stat != $this -> pl -> $field ) {
					//echo "\t----$field rozni sie ! Przed walka: {$this -> pl -> $field} || Po walce: $stat <br>";
					$this -> pl -> $field = $stat;
					$statch = true;
				}
			}
		}
		if( $statch == true ) {
			PutSignal( $this -> id, 'misc' );
		}
		$eqch = false;
		
		if( !empty( $this -> equip ) ) {
			foreach( $this -> equip as $key => $item ) {
				$oryg = $this -> pl -> GetEquipped( $key );
				//print_r( $item );
				//print_r( $oryg[$key] );
				$diff = array_diff_assoc( $item, $oryg[$key] );
				//var_dump( $diff );
				if( !empty( $diff ) ) {
					
					$this -> pl -> SetEquip( 'equip', $key, $diff );
					$eqch = true;
				}
			}
		}
		if( $eqch == true ) {
			PutSignal( $this -> id, 'equip' );
		}
		//echo "\t--Gotowe\n";
		$this -> sync = TRUE;
	}
	
	function BattleFinish() {
		if( !empty( $this -> equip['weapon'] ) && $this->equip['weapon']['poison'] > 0 && $this -> hit == true && $this ->GetWpnType() == 'weapon' ) {
			$this -> equip['weapon']['prefix'] = str_replace( 'Zatruty ', '', $this -> equip['weapon']['prefix'] );
			$this -> equip['weapon']['poison'] = 0;
		}
	}
	
	function Restart() {
		$this -> stats['fatigue'] = $this -> pl -> con;
		return TRUE;
	}
}

class Fighter_monster Extends Fighter {
	private $equip;
	public $type;
	private $fatugie;
	private $stats;
	private $statarr;
	private $dbstats;
	public $hit;
	function __construct( $mid, $name = NULL ) {
		$mon = $this -> SqlExec( "SELECT * FROM monsters WHERE id=$mid", true );
		$statarr = array( 'str'=>'strength','dex'=>'agility','con'=>'endurance','spd'=>'speed','hp'=>'hp','name'=>'name','id'=>'id', 'level' => 'level','exp1'=>'exp1','exp2'=>'exp2','gold1'=>'credits1','gold2'=>'credits2');
		$this -> statarr = $statarr;
		
		$dbstats = array_shift( $mon -> GetArray() );
		$this -> dbstats = $dbstats;
		foreach( $statarr as $key => $item ) {
			$this -> stats[$key] = $dbstats[$item];
		}
		$this -> stats['fatigue'] = 1;
		$this -> stats['gold'] = 0;
		$this -> type = 'monster';
		if( $name ) {
			$this -> name = $name;
		}
		//print_r( $this -> stats );
	}
	
	function __get( $val ) {
		return $this -> GetStat( $val );
	}

	function __set( $field, $val ) {
		if( !isset( $this -> stats[$field] ) ) {
			trigger_error( "Nieobslugwiwana wartosc __set :: $field !", E_USER_WARNING );
			return FALSE;
		}
		if( in_array( $field, array( 'fatigue' ) ) ) {
			return TRUE;
		}
		$this -> stats[$field] = $val;
	}

	function AwardExp( $exp ){
		return TRUE;
	}
	function AwardSkill( $skills ){
		return TRUE;
	}

	function GetStat( $stat ) {
		if( !isset( $this -> stats[$stat] ) ) {
			//trigger_error( "Nieobslugwiwana wartosc GetStat :: $stat !", E_USER_WARNING );
			return FALSE;
		}
		return $this -> stats[$stat];
		/*switch ( $stat ) {
			case 'name' :
				return $this -> stats['name'];
				break;
			case 'hp' :
				return $this -> stats['hp'];
				break;
			case 'con' :
				return $this -> stats['endurance'];
				break;
			case 'str' :
				return $this -> stats['strenght'];
				break;
			case 'spd' :
				return $this -> stats['speed'];
			case 'dex' :
				return $this -> stats['agility'];
			case 'fatigue' :
				return 1;
				break;
			default :
				trigger_error( "Nieobslugwiwana wartosc GetStat :: $field !", E_USER_WARNING );
				return 0;
		}*/
	}

	function GetWpnType() {
		return 'monster';
	}
	
	//! Modul walki - zwraca statystyki do walki
	/*!
	 * Wstepny modul do walki. Zwraca podstawowe [i wystarczajace] dane do walki. Obecnie zwraca :
	 *     'armor' - sumaryczna wartosc pancerza z uzglednieniem wszystkich modyfikatorow,
	 *               tych z czaru obronnego takze
	 *     'damage' - obrazenia jakie postac zada. Sama uwzglednia czy to czar, luk czy bron.
	 *                takze sama wprowadza zmienna losowa do obrazen. Trzeba pamietac ze
	 *                czar ma wyzszy priorytet niz bron !
	 *     'critical' - szansa na krytyk. Kalkulowana w oparciu o dzierzona bron.
	 *     'miss' - szansa na unikniecie, obliczana z uwzglednieniem premii i kar
	 *     'attack' - szansa na zadanie ciosu. Takze uwzglednia wszelkie mozliwosci, tak jak
	 *                i bron jaka sie uzywa
	 *
	 * @param [field] Wartosc jaka chce sie uzyskac. Patrz wyzej.
	 *
	 * @return Obliczona zadana wartosc
	 */
	function CombatGetVal( $field ) {
		$val = 0;
		$bon = 0;
		$pen = 0;
		
		switch ( $field ) {
			case 'armor' :
				$val = $this -> con;
				return $val;
				break;
			case 'damage' :
				//print_r( $this -> stats );
				$val = $this -> str;
				$rand = rand( 1, ( $this -> level * 10 ) );
				//echo "$rand\n";
				return round( $val + $rand );
				break;
			case 'critical' :

				return $kr;
				break;
			case 'miss' :
				$val = $this -> dex;
				return $val;
				break;
			case 'attack' :
				$val = $this -> dex;
				return $val;
				break;
			case 'exp' :
				$val = rand( $this -> exp1, $this -> exp2 );
				return $val;
			case 'gold' :
				$val = rand( $this -> gold1, $this -> gold2 );
				return $val;
			default :
				trigger_error( "Nieobslugwiwana wartosc $field !", E_USER_WARNING );
				return 0;
				break;
		}
	}
	
	//! Zmienianie wytrzymalosci broni
	/*!
	 * 'Uszkadzanie' broni. Teoretycznie przydatne tylko w walce. Zmniejsza wytrzymalosc
	 * noszonego ekwipunku i sprawdza czy juz sie zepsul kompletnie.
	 *
	 * @param [what] okreslenie czesci ekwipunku do 'uszkodzenia'
	 * @param [amount] o ile zmiejszyc wytrzmalosc przedmiotu
	 *
	 * @return TRUE lub FALSE w przypadku niepowodzenia
	 */
	function CombatEquipWt( $what, $amount ) {
		return TRUE;
	}
	function ApplyChanges() {
		return TRUE;
	}
	function Restart() {
		//$this -> dbstats = $dbstats;
		$this -> hp = $this -> dbstats['hp'];
		$this -> stats['fatigue'] = 1;
	}
	function BattleFinish() {
		return TRUE;
	}
}


?>