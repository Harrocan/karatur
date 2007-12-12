<?php
/**
 * klasa pl.
 *
*   Kombajn Do Zbierania Kur Po Wioskach ... czyli :
*   Nowa klasa Player - zajmuje sie w sumie wszystkim. Graczem, ekwipunkiem, miksturami, surowcami ...
*   Jeszcze tylko herbaty nie zaparza ... ale to juz wkrotce
*   (C) 2006-2007 Kara-Tur Team based on Vallheru Team
*
*   @author IvaN <ivan@o2.pl>
*   @version 0.3 beta
*   @since 08.01.2007
*	@package KaraTur
*/

$oldatr = array( 'strength' => 'str', 'agility' => 'dex', 'inteli' => 'int', 'cond' => 'con', 'speed' => 'spd', 'wisdom' => 'wis' );
$dbatr = array( 'str' => 'strength',
				'dex' => 'agility',
				'con' => 'wytrz',
				'spd' => 'szyb',
				'int' => 'inteli',
				'wis' => 'wisdom' );

$oldskill = array( 'attack' => 'melee', 'magic' => 'cast', 'shoot' => 'ranged', 'gotowanie' => 'cook' );
$dbskill = array( 'smith' => 'ability',
					'melee' => 'atak',
					'miss' => 'unik',
					'cast' => 'magia',
					'alchemy' => 'alchemia',
					'ranged' => 'shoot',
					'fletcher' => 'fletcher',
					'leadership' => 'leadership',
					'cook' => 'gotowanie' );

$oldmisc = array( 'max_hp' => 'hp_max', 'max_energy' => 'energy_max', 'tribe' => 'tribe_id', 'immunited' => 'immu',
					'pw' => 'faith' );
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
				'freeze' => 'freeze',
				'freeze_date' => 'freeze_date',
				'level_id' => 'level_id',
				'level_x' => 'level_x',
				'level_y' => 'level_y',
				// Pimp my shit
				'ugryziony' => 'ugryziony',
				'ilosc_ugryz' => 'ilosc_ugryz',
				'krew' => 'krew',
				'max_krew' => 'max_krew',
				'ugryz' => 'ugryz',
				'przez' => 'przez',
				'przemieniony_przez' => 'przemieniony_przez' );

$oldres = array( 'credits' => 'gold', 'platinum' => 'mithril', 'ryby' => 'fish', 'ziemniaki' => 'potato' );
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
 * Klasa obsugujaca pojedynczego gracza.
 *
 * Klasa pobierajaca wszelkie potrzebne dane o graczu
 * takie jak dane, ekwipunek, surowce i zarzadzajaca nimi.<br/>
 *
 * @package KaraTur
 * @tutorial Player.cls
 *
 *
 */
class Player {
	/**
	 * Okresla sposob wywolywania zapytan SQL.
	 *
	 * Klasa uzywa wewnetrznej funkcji do wywolywania zapytan SQL
	 * Ta flaga okresla czy dla kazdego zapytania wywolywac E_USER_NOTICE
	 * z trescia wykonywancego zapytania
	 *
	 * @var bool
	 * @deprecated na korzysc globalnej funkcji {@link SqlExec}
	 */
	public $SqlDebug;
	/**
	 *  Forma zwracanych danych.
	 *
	 * Informacje o postaci moga byc zwracane na dwa sposoby. Jako  <b>surowe</b> - czyli bez zadnych modyfikatorow z przedmiotow
	 * lub jako normalne dane z uwzglednieniem wszelkich modfikatorow. Ta flaga decyduje jak maja byc zwracane dane w przypadku
	 * uzywania funkcji __get() do szybkiego pobierania danych albo podczas pominiecia drugiego parametru przy uzywaniu specyficznych
	 * funkcji do pobierania danych ( GetAtr(), GetSkill(), GetMisc() )
	 *
	 * @var bool
	 */
	public $RawReturn;
	/**
	 *  Flaga spojnosci ekwipunku.
	 *
	 * Pomocnicza flaga ktora jest zarzadzana przez funkcje __wakeup()
	 * Jesli klasa dostala sygnal o zewnetrznej zmianie ekwipunku to ta flaga
	 * bedzie miala wartosc komunkaty ktore byly by wygenerowane przez __wakeup() ale
	 * ktore zostaly wyciszone
	 *
	 * @var string
	 */
	public $Reloaded;
	/**
	 *  Okresla czy obiekt zostal utworzony czy nie.
	 *
	 * Ciekawa sprawa - po podaniu nieprawidlowego ID obiekt nie posiadal zadnej
	 * prawidlowej wlasciwosci. Wszystko bylo jako NULL. A jednak empty() czy isset()
	 * nie umozliwialy odroznienia czy obiekt zostal utworzony. Nawet zwracanie FALSE nie
	 * pomagalo. Musialem utworzyc jakas dodatkowa flage zeby moc to sprawdzic.
	 *
	 * @var bool
	 */
	public $created;

	/**#@+
	 * @access private
	 * @var array
	 */
	private $dbatr;

	private $dbskill;

	private $dbmisc;

	private $dbres;

	private $dbmoved;

	private $oldatr;

	private $oldskill;

	private $oldmisc;

	private $oldres;

	private $oldtrash;


	private $atr;

	private $skill;

	private $misc;

	private $res;


	/**
	 * @access private
	 *
	 * @var unknown_type
	 */
	public $equip;
	/**
	 * @access private
	 *
	 * @var unknown_type
	 */
	public $backpack;

	private $potions;

	private $spells;
	/**#@-*/

	/**
	 *  Konstruktor klasy Player.

	 * Tworzy obiekt klasy Player, pobiera dane z tabel `player`,
	 * `equipment`, `herbs`, `mikstury` oraz `resources`
	 *
	 * @param int $pid ID gracza
	 * @param bool $quick Jesli zostanie ustawiona wartosc true to postac jest tworzona
	 *                bez calego wyposazenia. Uzywane w celu zmniejszenia wagi klasy
	 *                oraz liczby zapytan podczas podgladu gracza
	 */
	function __construct( $pid, $quick = FALSE ) {
		$stats = $this -> SqlExec( "SELECT p.*, r.name AS rankname, t.name AS tribe_name FROM players p JOIN ranks r ON r.id=p.rid LEFT JOIN tribes t ON t.id=p.tribe WHERE p.id=$pid" );
		//print_r( $stats );
		if( empty( $stats -> fields['id'] ) ) {
			trigger_error( "Blad podczas inicjalizacji klasy Player - nieprawidlowe ID !", E_USER_WARNING );
			//$this -> id = 0;
			$this -> created = FALSE;
			return NULL;
		}
		global $dbatr;
		global $dbskill;
		global $dbmisc;
		global $dbres;
		global $oldatr;
		global $oldskill;
		global $oldmisc;
		global $oldres;
		global $oldtrash;
		global $dbmoved;
		//if( $quick === FALSE ) {
			$this -> dbatr = $dbatr;
			$this -> dbskill = $dbskill;
			$this -> dbmisc = $dbmisc;
			$this -> dbres = $dbres;
		//}
		$this -> dbmoved = $dbmoved;
		$this -> oldatr = $oldatr;
		$this -> oldskill = $oldskill;
		$this -> oldmisc = $oldmisc;
		$this -> oldres = $oldres;
		$this -> oldtrash = $oldtrash;
		$this -> RawReturn = FALSE;
		$this -> created = TRUE;


		$stats = array_shift( $stats -> GetArray() );

		foreach( $dbatr as $key => $val ) {
			if( !isset( $stats[$val] ) ) {
				trigger_error( "Proba inicjalizacji nieistniejacej wartosci: $key => $val !", E_USER_ERROR );
			}
			$this -> atr[$key] = $stats[$val];
			unset( $stats[$val] );
		}
		foreach( $dbskill as $key => $val ) {
			if( !isset( $stats[$val] ) ) {
				trigger_error( "Proba inicjalizacji nieistniejacej wartosci: $key => $val !", E_USER_ERROR );
			}
			$this -> skill[$key] = $stats[$val];
			unset( $stats[$val] );
		}
		foreach( $dbmisc as $key => $val ) {
			if( !isset( $stats[$val] ) ) {
				//var_export( $stats );
				//trigger_error( "Proba inicjalizacji nieistniejacej wartosci: $key => $val !", E_USER_ERROR );
			}
			$this -> misc[$key] = $stats[$val];
			unset( $stats[$val] );
		}
		$this -> misc['mana_max'] = 0;
		$this -> misc['rankname'] = $stats['rankname'];
		if(!empty($stats['tribe_name']))
		{
			$this -> misc['tribe_name'] = $stats['tribe_name'];
		}
		else
		{
			$this -> misc['tribe_name']	= '';
		}
		if( !empty( $stats ) ) {
			//trigger_error( "Nieuzyte wartosci w bazie: ".implode( ", ", array_keys( $stats ) ), E_USER_NOTICE );
		}
		//$this -> spells = array();
		if( $quick === FALSE ) {
			$this -> _InitEquip();
		}
		$resources = $this -> SqlExec( "SELECT * FROM resources WHERE id={$this -> id}" );
		if( empty( $resources -> fields['id'] ) ) {
			$this -> SqlExec( "INSERT INTO resources(id) VALUES({$this->id})" );
			$resources = $this -> SqlExec( "SELECT * FROM resources WHERE id={$this -> id}" );
		}
		$resources = array_shift( $resources -> GetArray() );
		foreach( $dbres as $key => $val ) {
			if( !isset( $resources[$val] ) ) {
				trigger_error( "Proba inicjalizacji nieistniejacgo surowca: $key => $val !", E_USER_ERROR );
			}
			$this -> res[$key] = $resources[$val];
		}
		$this -> SqlExec( "DELETE FROM wakeup WHERE pid={$this -> id}" );
		$this -> SqlDebug = false;
	}

	/**
	 * Funkcja pobiera ekwipunek gracza (ten noszony i ten w plecaku) i zapisuje w tabelkach.
	 * Takze pobiera czary oraz mikstury
	 */
	private function _InitEquip() {
		$worn = $this -> SqlExec( "SELECT e.*, i.img_file FROM equipment e LEFT JOIN item_images i ON e.imagenum=i.id WHERE e.owner={$this->id} AND e.`status`='E'" );
		$worn = $worn -> GetArray();
		//print_r( $worn );
		foreach( $worn as $item ) {
			if( in_array( $item['type'], array( 'W', 'B', 'S' ) ) ) {
				$this ->equip['weapon'] = $item;
			}
			if( in_array( $item['type'], array( 'A', 'Z' ) ) ) {
				$this ->equip['armor'] = $item;
			}
			if( in_array( $item['type'], array( 'H' ) ) ) {
				$this ->equip['helm'] = $item;
			}
			if( in_array( $item['type'], array( 'D' ) ) ) {
				$this ->equip['shield'] = $item;
			}
			if( in_array( $item['type'], array( 'N' ) ) ) {
				$this ->equip['knee'] = $item;
			}
			if( in_array( $item['type'], array( 'R' ) ) ) {
				$this ->equip['arrows'] = $item;
			}
		}
		$this -> potions = array();
		$spells = $this -> SqlExec( "SELECT * FROM czary WHERE gracz={$this->id}" );
		$spells = $spells -> GetArray();
		foreach( $spells as $key => $spell ) {
			$spells[$key] = $this -> TranslateFields( $spell, 'spells' );
		}
		if( !empty( $this -> spells ) ) {
			unset( $this -> spells );
		}
		$this -> spells = array();
		foreach( $spells as $spell ) {
			if( $spell['status'] == 'E' ) {
				if( $spell['type'] == 'B' )
					$this -> equip['spellatk'] = $spell;
				if( $spell['type'] == 'O' )
					$this -> equip['spelldef'] = $spell;
			}
			else {
				$this -> spells[] = $spell;
			}
		}
		$backpack = $this -> SqlExec( "SELECT e.*, i.img_file FROM equipment e LEFT JOIN item_images i ON e.imagenum=i.id WHERE e.owner={$this->id} AND e.`status`='U'" );
		$this -> backpack = $backpack -> GetArray();
		$potions = $this -> SqlExec( "SELECT m.*, p.img_file FROM mikstury m LEFT JOIN images_potions p ON p.id=m.imagenum WHERE m.gracz={$this -> id} AND m.`status`='K'" );
		$potions = $potions -> GetArray();
		foreach( $potions as $key => $potion ) {
			$potions[$key] = $this -> TranslateFields( $potion, 'potions' );
		}
		$this -> potions = $potions;
	}

	/**
	 * Szybki dostep do danych gracza.

	 * Funkcja sprawdza poprawnosci zadanej danej i przekierowuje do
	 * odpowiedniej funkcji zwracajacej ( {@link GetAtr()}, {@link GetSkill()},
	 * {@link GetMisc()} lub {@link GetRes()} )
	 *
	 * <b>UWAGA !!</b><br/>
	 * Funkcja uzywa do zwracania wartosci aktualnie ustawionej
	 * flagi <b>RawReturn</b>
	 *
	 * @param mixed $field ¯±dana wartosc
	 *
	 */
	function __get( $field ) {
		if( in_array( $field, array_merge( array_keys( $this -> atr ), array_keys( $this -> oldatr ) ) ) ) {
			return $this -> GetAtr( $field );
		}
		if( in_array( $field, array_merge( array_keys( $this -> skill ), array_keys( $this -> oldskill ) ) ) ) {
			return $this -> GetSkill( $field );
		}
		if( in_array( $field, array_merge( array_keys( $this -> misc ), array_keys( $this -> oldmisc ) ) ) ) {
			return $this -> GetMisc( $field );
		}
		if( in_array( $field, array_merge( array_keys( $this -> res ), array_keys( $this -> oldres ) ) ) ) {
			return $this -> GetRes( $field );
		}
		if( in_array( $field, $this -> oldtrash ) ) {
			trigger_error( "Pobierasz wartosc $field oznaczona jako 'smieci' ! Zwracam 0", E_USER_WARNING );
			return 0;
		}
		if( in_array( $field, $this -> dbmoved ) ) {
			trigger_error( "Wywolanie przesunietej wartosci $field ! Sprawdz i koniecznie popraw !", E_USER_ERROR );
		}
		trigger_error( "Nie istnieje taka wartosc: $field !", E_USER_ERROR );
	}

	/**
	 *  Szybkie zapisywanie danych gracza.

	 * Funkcja zapisuje dane do bazy, ze sprawdzeniem istnienia pola
	 *
	 * <b>UWAGA !!</b><br/>
	 * Prosze zapoznac sie z mozliwym niebezpieczenstwem podczas uzywania
	 * zapisu <code>$player->dex += 10;</code> i temu podobnych
	 * {@tutorial Player.data.cls tutaj}
	 *
	 * @param string $field Nazwa pola do ustawienia
	 * @param mixed $val Wartosc pola do ustawienia
	 *
	 * @return bool TRUE, lub FALSE w przypadku niepowodzenia
	 */
	function __set( $field, $val ) {
		if( in_array( $field, array_keys( $this -> oldatr ) ) ) {
			trigger_error( "Probujesz ustawic przestarzaly atrybut ->$field ! Uzywaj ->{$this -> oldatr[$field]}", E_USER_NOTICE );
			$field = $this -> oldatr[$field];
		}
		if( in_array( $field, array_keys( $this -> oldskill ) ) ) {
			trigger_error( "Probujesz ustawic przestarzaly atrybut ->$field ! Uzywaj ->{$this -> oldskill[$field]}", E_USER_NOTICE );
			$field = $this -> oldskill[$field];
		}
		if( in_array( $field, array_keys( $this -> oldmisc ) ) ) {
			trigger_error( "Probujesz ustawic przestarzaly atrybut ->$field ! Uzywaj ->{$this -> oldmisc[$field]}", E_USER_NOTICE );
			$field = $this -> oldmisc[$field];
		}
		if( in_array( $field, array_keys( $this -> oldres ) ) ) {
			trigger_error( "Probujesz ustawic przestarzaly atrybut ->$field ! Uzywaj ->{$this -> oldmisc[$field]}", E_USER_NOTICE );
			$field = $this -> oldres[$field];
		}
		if( isset( $this -> atr[$field] ) ) {
			$this -> SqlExec( "UPDATE `players` SET `{$this -> dbatr[$field]}`='$val' WHERE id={$this -> id}" );
			$this -> atr[$field] = $val;
			return TRUE;
		}
		if( isset( $this -> skill[$field] ) ) {
			$this -> SqlExec( "UPDATE `players` SET `{$this -> dbskill[$field]}`='$val' WHERE id={$this -> id}" );
			$this -> skill[$field] = $val;
			return TRUE;
		}
		if( isset( $this -> misc[$field] ) ) {
			$this -> SqlExec( "UPDATE `players` SET `{$this -> dbmisc[$field]}`='$val' WHERE id={$this -> id}" );
			$this -> misc[$field] = $val;
			return TRUE;
		}
		if( isset( $this -> res[$field] ) ) {
			$this -> SqlExec( "UPDATE resources SET `{$this -> dbres[$field]}`='$val' WHERE id={$this -> id}" );
			$this -> res[$field] = $val;
			return TRUE;
		}
		trigger_error( "Probujesz zapisac nieistniejaca wartosc $field = $val do bazy ! ",E_USER_WARNING );
		return FALSE;
	}

	/**
	 *  Pobieranie atrybutu.
	 *
	 * Funkcja zwraca atrybut, z wzglednianiem wszelkich modyfikatorow
	 *  z przedmiotow i temu podobnych. Dozwolone wartosci to :
	 * str, dex, con, int, wis, spd
	 *
	 * @param string $field Nazwa atrybutu do zwrocenia
	 * @param bool $raw Flaga okresla czy atrybut ma byc zwracany z
	 *                  uwzglednieniem modyfikatorow czy nie
	 *                  Pominiecie spowoduje uzycie flagi <b>RawReturn</b>
	 *
	 * @return int ¯±dany atrybut
	 */
	function GetAtr( $field, $raw = NULL )
	{
		if( $raw === NULL ) {
			$raw = $this -> RawReturn;
		}
		if( isset( $this -> oldatr[$field] ) ) {
			trigger_error( "Uzywasz przestarzalej wartosci ->$field ! Uzywaj ->{$this -> oldatr[$field]}", E_USER_NOTICE );
			$field = $this -> oldatr[$field];
		}
		if( !isset( $this -> atr[$field] ) ) {
			trigger_error( "Pobierasz nieistniejacy atrybut $field !", E_USER_ERROR );
		}
		if( $raw === TRUE ) {
			return $this -> atr[$field];
		}
		$bon = 0;
		$pen = 0;
		switch( $field ) {
			case 'dex' :
				$val = $this -> atr[$field];
				if( !empty( $this ->equip['armor'] ) ) {
					if( $this -> equip['armor']['zr'] > 0 ) {
						$pen += $val * ( $this -> equip['armor']['zr'] / 100 );
					}
					elseif( $this -> equip['armor']['zr'] < 0 ) {
						$bon += $val * ( abs( $this -> equip['armor']['zr'] ) / 100 );
					}
				}
				if( !empty( $this ->equip['knee'] ) ) {
					if( $this -> equip['knee']['zr'] > 0 ) {
						$pen += $val * ( $this -> equip['knee']['zr'] / 100 );
					}
					elseif( $this -> equip['knee']['zr'] < 0 ) {
						$bon += $val * ( abs( $this -> equip['knee']['zr'] ) / 100 );
					}
				}
				if( !empty( $this ->equip['shield'] ) ) {
					if ( $this -> equip['shield']['zr'] > 0 ) {
						$pen += $val * ( $this -> equip['shield']['zr'] / 100 );
					}
					elseif ( $this -> equip['shield']['zr'] < 0 ) {
						$bon += $val * ( abs( $this -> equip['shield']['zr'] ) / 100 );
					}
				}
				return $val + $bon - $pen;
				break;
			case 'spd' :
				$val = $this -> atr[$field];
				if( !empty( $this -> equip['weapon'] ) && in_array( $this -> equip['weapon']['type'], array( 'W', 'B' ) ) ) {
					$bon += $val * ( $this -> equip['weapon']['szyb'] / 100 );
				}
				if( !empty( $this -> equip['armor'] ) &&  !empty( $this ->equip['armor'] ) && $this -> equip['armor']['szyb'] > 0 ) {
					$pen += $val * ( $this -> equip['armor']['szyb'] / 100 );
				}
				if( !empty( $this -> equip['knee'] ) &&  !empty( $this ->equip['knee'] ) && $this -> equip['knee']['szyb'] > 0 ) {
					$pen += $val * ( $this -> equip['knee']['szyb'] / 100 );
				}
				return $val + $bon - $pen;
				break;
			default :
				return $this -> atr[$field];
		}
	}

	/**
	 *  Pobieranie umiejetnosci

	 * Funkcja zwraca umiejetnosc, z wzglednianiem wszelkich modyfikatorow
	 * z przedmiotow i temu podobnych. Dozwolone wartosci :
	 * melee, ranged, cast, miss, alchemy, smith, fletcher, leadership, cook
	 *
	 * @param string $field Nazwa umiejetnosci do zwrocenia
	 * @param bool $raw Flaga okresla czy umiejetnosc ma byc zwracana z
	 *                  uwzglednieniem modyfikatorow czy nie
	 *                  Pominiecie spowoduje uzycie flag <b>RawReturn</b>
	 *
	 * @return float ¯±dana umiejetnosc
	 */
	function GetSkill( $field, $raw = NULL ) {
		if( $raw === NULL ) {
			$raw = $this -> RawReturn;
		}
		if( isset( $this -> oldskill[$field] ) ) {
			trigger_error( "Uzywasz przestarzalej wartosci ->$field ! Uzywaj ->{$this -> oldskill[$field]}", E_USER_NOTICE );
			$field = $this -> oldskill[$field];
		}
		if( !isset( $this -> skill[$field] ) ) {
			trigger_error( "Pobierasz nieistniejaca umiejetnosc $field !", E_USER_ERROR );
		}
		if( $raw === TRUE ) {
			return $this -> skill[$field];
		}
		switch( $field ) {
			default :
				return $this -> skill[$field];
		}
	}

	/**
	 *  Pobieranie pozostalych wartosci

	 * Funkcja zwraca wartosc, z wzglednianiem wszelkich modyfikatorow
	 * z przedmiotow i temu podobnych <br/>
	 * Poza standardowymi polami dostepnymi w tabeli `players` dostepne
	 * sa jeszce nastepujace pola :
	 *  + mana_max : maksymalna wartosc many
	 *
	 * @param string $field Nazwa wartosci do zwrocenia
	 * @param bool $raw Flaga okresla czy wartosc ma byc zwracana z
	 *                  uwzglednieniem modyfikatorow czy nie
	 *                  Pominiecie spowoduje uzycie flagi <b>RawReturn</b>
	 *
	 * @return mixed ¯±dana wartosc
	 */
	function GetMisc( $field, $raw = NULL ) {
		if( $raw === NULL ) {
			$raw = $this -> RawReturn;
		}
		if( isset( $this -> oldmisc[$field] ) ) {
			trigger_error( "Uzywasz przestarzalej wartosci ->$field ! Uzywaj ->{$this -> oldmisc[$field]}", E_USER_NOTICE );
			$field = $this -> oldmisc[$field];
		}
		if( !isset( $this -> misc[$field] ) ) {
			trigger_error( "Pobierasz nieistniejaca wartosc `$field` !", E_USER_ERROR );
		}
		if( $raw === TRUE ) {
			switch( $field ) {
				case 'mana_max' :
					$val = $this -> GetAtr( 'int', $raw ) + $this -> GetAtr( 'wis', $raw );
					return round( $val );
					break;
				default :
					return $this -> misc[$field];
			}
		}
		$bon = 0;
		$pen = 0;
		switch( $field ) {
			case 'mana_max' :
				$val = $this -> GetAtr( 'int', $raw ) + $this -> GetAtr( 'wis', $raw );
				if( isset( $this -> equip['armor'] ) && $this -> equip['armor']['type'] == 'Z' ) {
					$bon = $val * ( $this -> equip['armor']['power'] / 100 );
				}
				return round ($val + $bon );
			default :
				return $this -> misc[$field];
		}
	}

	/**
	 *  Pobieranie surowcow.
	 *
	 * Funkcja zwraca surowce, z wzglednianiem wszelkich modyfikatorow
	 * [jesli beda jakies istniec]
	 *
	 * @param string $field Nazwa surowca do zwrocenia
	 * @param bool $raw Flaga okresla czy wartosc ma byc zwracana z
	 *                  uwzglednieniem modyfikatorow czy nie
	 *                  Pominiecie spowoduje uzycie flagi <b>RawReturn</b>
	 *
	 * @return int ¯±dana wartosc
	 */
	function GetRes( $field ) {
		if( isset( $this -> oldres[$field] ) ) {
			trigger_error( "Uzywasz przestarzalej wartosci ->$field ! Uzywaj ->{$this -> oldres[$field]}", E_USER_NOTICE );
			$field = $this -> oldres[$field];
		}
		if( !isset( $this -> res[$field] ) ) {
			trigger_error( "Pobierasz nieistniejacy surowiec $field !", E_USER_ERROR );
		}
		switch( $field ) {
			default :
				return $this -> res[$field];
		}
	}

	/**
	 *  Pobieranie wielu wartosci jednoczesnie.
	 *
	 * Funkcja zwraca tablice zadanych danych w postaci tablicy asocjacyjnej.
	 * Przyklady dozwolonych wywo³añ :
	 * <code>
	 * $ret = $player->GetArray( "level,age,lpv,tribe,id,user" );
	 * //lub
	 * $ret = $player->GetArray( array( 'level', 'age', 'lpv', 'tribe', 'id', 'user' ) );
	 * </code>
	 * W obu przypadkach zwrócona tabela wygl±da nastêpuj±co :
	 * <code>
	 * array( 'level' => 3,
	 * 		'age' => 8,
	 * 		'lpv' => 123456789,
	 * 		'tribe' => 0,
	 * 		'id' => 267,
	 * 		'user' => 'Alucard van Hellsing' );\
	 * </code>
	 *
	 * @param string|array $fields Dane wejsciowe jakie maja zostac pobrane
	 * @param bool $raw Precyzuje czy dane maja zostac zwrocone w formie surowej czy nie
	 *
	 * @return array Tablica asocjacyna z ¿±danymi wartosciami
	 */
	function GetArray( $fields, $raw = NULL ) {
		if( $raw === NULL ) {
			$raw = $this -> RawReturn;
		}
		if( !is_array( $fields ) ) {
			$field = explode( ",", $fields );
		}
		$oldraw = $this -> RawReturn;
		$this -> RawReturn = $raw;
		foreach( $fields as $field ) {
			$return[$field] = $this -> $field;
		}
		$this -> RawReturn = $oldraw;
		return $return;
	}

	/**
	 *  Zapisywanie wielu wartosci jednoczesnie.
	 *
	 * Funkcja zapisuje grupe danych. Przykladowe poprawne wywolanie funkcji :
	 * <code>
	 * $save = array( 'user' => 'Alucard van Funny',
	 * 		'level' => '1',
	 * 		'exp' => '0' );
	 * $player->SetArray( $save );
	 * </code>
	 *
	 * @param array $fields Tablica wejsciowa danych do zapisania.
	 *
	 * @return TRUE jesli wszystkie zapisy powiodly sie lub FALSE gdy
	 *         wystapilo choc jedno niepoprawne zapisanie
	 */
	function SetArray( $fields ) {
		$status = TRUE;
		$msg = "SetArray : ";
		foreach( $fields as $key => $field ) {
			$msg .= "$key => $field, ";
			$ret = $this -> $key = $field;
			if( $ret === FALSE ) {
				$status = FALSE;
			}
		}
		$msg .= "<br>";
		return $status;
	}


	/**
	 * Dodawanie doswiadczenia ze sprawdzaniem czy postac juz awansowala.
	 *
	 * @param int $expgain ilosc doswiadczenia do dodania
	 * @param bool $quiet czy uruchomic {@link trigger_error} z poziomem
	 *                    b³edu E_USER_NOTICE i informacja o tym co dana
	 *                    postac zyskala na poziomie ?
	 */
	function AwardExp( $expgain, $quiet = FALSE ) {
		$poziom = 0;
		$ap = 0;
		$pz = 0;
		$energia = 0;
		$texp = ($this -> exp + $expgain);
		$level = $this -> level;
		$expn = expnext( $level );
		$rasa = $this -> race;
		//trigger_error( "Nagradzam doswiadczenie : \$texp: $texp && \$expn: $expn", E_USER_NOTICE );
		while ($texp >= $expn) {
			//trigger_error( "dodaje 1 poziom", E_USER_NOTICE );
			$poziom = ($poziom + 1);
			$ap = ($ap + 6);
			$krew=0;
			$texp = ($texp - $expn);
			$level = ($level + 1);
			$expn = expnext( $level );
			if ($rasa == 'Czlowiek') {
				$pz = ($pz + 5);
			}
			if ($rasa == 'Elf') {
				$pz = ($pz + 4);
			}
			if ($rasa == 'Krasnolud') {
				$pz = ($pz + 6);
			}
			if ($rasa == 'Hobbit') {
				$pz = ($pz + 3);
			}
			if ($rasa == 'Jaszczuroczlek') {
				$pz = ($pz + 5);
			}
			if ($rasa == 'Nieumarly') {
				$pz = ($pz + 4);
			}
				if ($rasa == 'Smokokrwisty') {
				$pz = ($pz + 5);
			}
			if ($rasa == 'Wampir') {
				$pz = ($pz + 4);
				$krew = 5;
			}
			if ($rasa == 'Wilkolak') {
				$pz = ($pz + 5);
			}
			if ($rasa == 'Kurtr') {
				$pz = ($pz + 2);
			}
			if ($rasa == 'Polelf') {
				$pz = ($pz + 4);
			}
			if ($rasa == 'Polork') {
				$pz = ($pz + 7);
			}
			if ($rasa == 'Drow') {
				$pz = ($pz + 5);
			}
			if ($rasa == 'Nimfa') {
				$pz = ($pz + 3);
			}
			$energia = $energia + 0.3;
			$maxenergy = $this -> energy_max + $energia;
			if ($maxenergy > 100) {
				$maxenergy = 100;
			}
		}
		//trigger_error( "Ogolem poziomo do dodania : $poziom ", E_USER_NOTICE );
		if ($poziom > 0) {
			if( $quiet === FALSE ) {
				$msg = "<b>Zdobyles poziom</b><br>";
				$msg.= $poziom." Poziom(ow)<br>";
				$msg.= $ap." AP<br>";
				$msg.= $pz." Maksymalnych Punktow Zycia<br>";
				$msg.= $energia." Maksymalnej Energii<br>";
				trigger_error( $msg, E_USER_NOTICE );
			}
				//$gained['exp'] = $texp;
				//$gained['level'] = $player -> level + $poziom;
				//$gained['ap'] = $player -> ap + $ap;
				//$gained['hp_max'] = $player -> GetMisc( 'hp_max', TRUE ) + $pz;
				//$gained['max_krew'] = $player -> max_krew + $krew;
				//if ($energia > 0) {
				//	$gained['energy_max'] = $maxenergy;
				//$player -> SetArray( $gained );
			//$db -> Execute("UPDATE players SET exp=".$texp." WHERE id=".$eid);
			//$db -> Execute("UPDATE players SET level=level+".$poziom." WHERE id=".$eid);
			//$db -> Execute("UPDATE players SET ap=ap+".$ap." WHERE id=".$eid);
			//$db -> Execute("UPDATE players SET max_hp=max_hp+".$pz." WHERE id=".$eid);
			//$db -> Execute("UPDATE players SET max_hp=max_hp+".$pz." WHERE id=".$eid);
			//$db -> Execute("UPDATE players SET max_krew=max_krew+".$krew." WHERE id=".$eid);
			//trigger_error( "Dodoaje poziomy", E_USER_NOTICE );
			$this -> exp = $texp;
			$this -> level += $poziom;
			$this -> ap += $ap;
			$this -> hp_max += $pz;
			if( $krew > 0 ) {
				$this -> max_krew += $krew;
			}
			$this -> energy_max += $energia;
			//$player -> SetArray( array( 'exp'=>$texp, 'level'=>$player
			//if ($energia > 0) {
			//	$db -> Execute("UPDATE players SET max_energy=".$maxenergy." WHERE id=".$eid);
			//	//$gained['energy_max'] = $maxenergy;
			//}

			//if ($enemyid != 0) {
			//	$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$eid.",'Podczas walki z <b>".$enemyuser." ID:".$enemyid."</b>, zdobywasz poziom.','".$newdate."')");
			//}
			//PutSignal( $eid, 'misc' );
		} else {
			//trigger_error( "Dodoaje tylko doswiadczenie", E_USER_NOTICE );
			$this -> exp = $texp;
			//$db -> Execute("UPDATE players SET exp=".$texp." WHERE id=".$eid);
			//PutSignal( $eid, 'misc' );
			//$player -> SetArray( array( 'exp' => $texp ) );;
		}
	}

	/**
	 *  Wyszukiwanie przedmiotow w plecaku.
	 *
	 * Funkcja wyszukuje przedmioty w plecaku na podstawie ¿±danych pol.
	 * Przykladowe wywolanie funkcji :
	 * <code>
	 * //Wyszuka wszystkie bronie z plecaka
	 * $ret = $player->EquipSearch( array( 'type' => 'W' ) );
	 *
	 * //Wyszuka mikstury many z plecaka
	 * $ret = $player->EquipSearch( array( 'type' => 'M' ), 'potions' );
	 * </code>
	 *
	 * <b>UWAGA !!</b><br/>
	 * Zwracana tablica posiada klucze numeryczne odpowiadajace
	 * wewnetrznej numeracji w klasie ! Klucze te nie maja zadnego zwiazku
	 * z jakimikolwiek wartosciami w bazie danych, ale sa potrzebne np. przy
	 * uzywaniu funkcji {@link SetEquip}<br/>
	 * Trzeba takze pamietac ze funkcja ta szuka tylko elementow <b>równych</b>
	 * czyli np. 'type' = 'W', a nie np. 'wt' > 10
	 *
	 * @param array $fields Tablica asocjacyjna zawierajaca pola i wartosci pol
	 * @param string $where Okresla lokalizacje do szukania. Obecnie
	 *                      dopuszcza 'backpack', 'potions' i 'spells'
	 *
	 * @return array Tablica asocjacyjna zwroconych wartosci
	 *
	 */
	function EquipSearch( $fields = NULL, $where = 'backpack' ) {
		if( $fields === NULL ) {
			return $this -> $where;
		}
		$numfields = count( $fields );
		$return = array ();
		$w =& $this->$where;
		if( !is_array( $w ) ) {
			return $return;
		}
		//if( $this->id == 1278 ) {
		//	qDebug( $w );
		//}
		foreach( $w as $key => $item ) {
			if( count( array_intersect_assoc( $item, $fields ) ) == $numfields ) {
				$return[$key] = $item;
			}
		}
		return $return;
	}

	/**
	 *  Pobieranie noszonego ekwipunku.
	 *
	 * Funkcja zwraca noszony ekwipunek. W sumie podobny efekt mozna
	 * osiagnac korzystajac z metody {@link EquipSearch} ale w ten sposob jest
	 * wygodniej i prosciej. EquipSearch lepiej nadaje sie do plecaka.<br/>
	 * Dozwolone wartosci :
	 *  + 'weapon' : bron, ³uk lub laska
	 *  + 'armor' : pancerz lub szata
	 *  + 'shield' : tarcza
	 *  + 'knee' : nagolenniki
	 *  + 'helm' : he³m
	 *  + 'arrows' : strza³y
	 *
	 * <br/>
	 * <b>UWAGA !!</b><br/>
	 * Funkcja zwroci tylko te czesci ktore masz zalozone. Jesli zazadasz
	 * 'knee' nie majac zalozonych nagolennikow - zwrocona zostanie
	 * pusta tablica.
	 *
	 * @param string|array $what Czesci jakie maja zostac zwrocone, podane w
	 * 							formie zwyklej tablicy, pojedynczej wartosci
	 * 							lub 'all' jesli wszystkie elementy maja byc
	 * 							zwrocone
	 *
	 * @return array Tablica ze znalezionymi czesciami.
	 */
	public function GetEquipped( $what = 'all' ) {
		if( $what == 'all' ) {
			$return = $this -> equip;
			return $return;
		}
		else {
			if( !is_array( $what ) ) {
				$what = array( $what );
			}
			//print_r($what);
			$return = array();
			foreach( $what as $field ) {
				if( !empty( $this->equip[$field] ) ) {
					$return[$field] = $this->equip[$field];
				}
				else {
					//trigger_error( "Nie istnieje taka czesc ekwipunku $field !", E_USER_WARNING );
					//return array();
					continue;
				}
			}
			return $return;
		}
	}

	/**
	 *  Zmienianie danych w ekwipunku.

	 * Metoda zmienia dane o dowolnym elemencie ekwipunku, wykorzytujac podany do tego parametr '$fields'. Przykladowe poprawne wywolanie tej metody :
	 * <code>
	 * //Pobieramy wszystkie strzaly
	 * $arrows = $player->EquipSearch( array( 'type' => 'R' ), 'backpack' );
	 * //szukamy kolczanu, w ktorym jest mniej niz 20 strzal
	 * $found = FALSE;
	 * foreach( $arrows as $key => $value ) {
	 *     if( $value['wt'] < 20 ) {
	 *         //Jesli znalezlismy, to przerywamy petle - nie musimy szukac dalej
	 *         $found = TRUE;
	 *         break;
	 *     }
	 * }
	 * //Jesli znalezlismy
	 * if( $found == TRUE ) {
	 *     //Dopelniamy kolczan do pelna
	 *     //Trzeba pamietac o tym ze zmienna '$key' ma wartosc z ostatniej petli foreach
	 *     //jaka wykonalismy - czyli ta na ktorej przerwalism poszukiwania
	 *     $player->SetEquip( 'backpack', $key, array( 'wt' => 20 ) );
	 * }
	 * </code>
	 * <b>UWAGA !!</b><br/>
	 * T± metod± nie moznesz zmienic pol 'id' oraz 'status'. Nalezy to
	 * rozwiazywac innymi sposobami !
	 *
	 * @param string $what Gdzie sie znajduje przedmiot ktory chcesz
	 *                     zmienic - 'equip, 'backpack' czy 'potions'
	 * @param string}int $item Ktory element zmienic. W przypadku ekwipunku
	 *                     noszonego podajesz np 'armor' a w przpadku
	 *                     przedmiotow w plecaku i mikstur podajesz polozenie
	 *                     w wewnetrznych tablicach (mozna je uzyskac
	 *                     korzystajac z np. {@link EquipSearch})
	 * @param array $fields Pola do zmiany. Musza byc zgodne z nazwami w
	 *                      kolumnami w bazie danych
	 *
	 * @return bool TRUE, lub FALSE w przypadku niepowodzenia
	 */
 	function SetEquip( $what, $item, $fields ) {
 		if( isset( $fields['id'] ) ) {
 			trigger_error( "Ta funkcja nie zezwala na zmienianie pola 'id'  !", E_USER_WARNING );
 			return FALSE;
 		}
 		$i =& $this -> $what;
 		//print_r( $i );
 		if( empty( $i[$item] ) ) {
 			trigger_error( "W ekwipunku nie ma takiego przedmiotu $what -> $item !", E_USER_WARNING );
 			return FALSE;
 		}
 		foreach( $fields as $key => $val ) {
 			if( !isset( $i[$item][$key] ) ) {
 				trigger_error( "Proba zmiany nieistniejacego pola w $what -> $item = $key !",E_USER_WARNING );
 				unset( $fields[$key] );
 				continue;
 			}
 			$i[$item][$key] = $val;
 		}
 		switch( $what ) {
 			case 'equip' :
 				$sql = $this -> SqlCreate( "UPDATE", "equipment", $this -> TranslateFields( $fields, $what ), "id={$i[$item]['id']}" );
 				break;
 			case 'backpack' :
 				$sql = $this -> SqlCreate( "UPDATE", "equipment", $this -> TranslateFields( $fields, $what ), "id={$i[$item]['id']}" );
 				break;
 			case 'potions' :
 				$sql = $this -> SqlCreate( "UPDATE", "mikstury", $this -> TranslateFields( $fields, $what ), "id={$i[$item]['id']}" );
 				break;
 			default :
 				trigger_error( "Nieprawidlowa czesc w ekwipunku: $what !", E_USER_WARNING );
 				return FALSE;
 		}
 		$this -> SqlExec( $sql );
 		return TRUE;
 	}

	/**
	 *  Zdejmowaie ekwipunku.
	 *
	 * Funkcja zdejmuje ekwipunek z gracza, uwzgledniajac alternatywna
	 * forme zdejmowania dla strzal (czyli wyszukuje ko³czan do ktorego mozna
	 * dolozyc obecnie zdejmowany. Jesli znajdzie - sumuje kolczany, jesli
	 * nie znajdzie - odklada jako osobny)
	 *
	 * @param string $what Rodzaj zdejmowanej czesci. Dostepne mozliowsci:
	 *                     + weapon, + armor, + helm, + shield, + knee, + arrows
	 *
	 * @return bool TRUE lub FALSE w przypadku niepowodzenia
	 */
	function Unequip( $what ) {
		if( !in_array( $what, array( 'weapon', 'armor', 'helm', 'shield', 'knee', 'arrows' ) ) ) {
			trigger_error( "Proba zdjecia nieprawidlowej czesci ekwipunku $what !", E_USER_WARNING );
			return FALSE;
		}
		if( empty( $this -> equip[$what] ) ) {
			trigger_error( "Czesc $what jest juz zdjeta !", E_USER_WARNING );
			return FALSE;
		}
		$item = $this -> equip[$what];
		if( $item['type'] == 'B' && !empty( $this -> equip['arrows'] ) ) {
			$this -> Unequip( 'arrows' );
		}
		$search = $this -> equip[$what];
		unset( $search['id'] );
		unset( $search['amount'] );
		unset( $search['status'] );
		unset( $search['imagenum'] );
		unset( $search['img_file'] );
		if( $what == 'arrows' ) {
			unset( $search['dur'] );
			unset( $search['durmax'] );
		}
		$try = $this-> EquipSearch( $search );
		//print_r( $try );
		if( !empty( $try ) ) {
			$key = NULL;
			if( $what == 'arrows' && $item['wt'] < 20 ) {
				foreach( $try as $k => $quiver ) {
					if( $quiver['wt'] + $item['wt'] <= 20 ) {
						$key = $k;
						break;
					}
				}
				if( $key !== NULL ) {
					$try = array_shift( $try );
					//print_r( $try );
					$sql[] = "UPDATE equipment SET wt = wt + {$item['wt']} WHERE id={$try['id']}";
					$sql[] = "DELETE FROM equipment WHERE id={$item['id']}";
					$this -> SqlExec( $sql[0] );
					$this -> SqlExec( $sql[1] );
					$this -> backpack[$key]['wt'] += $item['wt'];
					unset( $this -> equip[$what] );
				}
				else {
					$try = array_shift( $try );
					$this ->SqlExec( "UPDATE equipment SET `status`='U' WHERE id={$item['id']}" );
					unset ( $this -> equip[$what] );
					$this -> backpack[] = $item;
				}
			}
			else {
				$key = key( $try );
				$try = array_shift( $try );
 				///$try -> status = 'U';
				//print_r($try);
				$sql[] = "UPDATE equipment SET amount = amount + 1 WHERE id={$try['id']}";
				$sql[] = "DELETE FROM equipment WHERE id={$item['id']}";
				$this -> SqlExec( $sql[0] );
				$this -> SqlExec( $sql[1] );
				$this -> backpack[$key]['amount']++;

				//$this -> equip[$what] -> status ='U';
				//$this -> backpack -> ItemAdd( $this -> equip[$what]->type, $this -> equip[$what]->GetArray() );
				//$this -> equip[$what] -> Delete ();
				unset( $this -> equip[$what] );
			}
		}
		else {
			$this ->SqlExec( "UPDATE equipment SET `status`='U' WHERE id={$item['id']}" );

			$this -> backpack[] = $item;

			//$this -> equip[$what] -> status ='U';
			//$this -> backpack -> ItemAdd( $this -> equip[$what]->type, $this -> equip[$what]->GetArray() );
			unset ( $this -> equip[$what] );
		}
		if( $item['type'] == 'Z' && $this -> mana > $this -> mana_max ) {
			$this -> mana = $this -> mana_max;
		}
		return TRUE;
	}

	/**
	 *  Zakladanie ekwipunku.
	 *
	 * Funkcja zaklada ekwipunek na gracza z uwzgledniem wszystkich warunkow.
	 * W przypadku kiedy posiada sie zalozony przedmiot z danego rodzaju
	 * to zostaje on zdjety.
	 * Przykladowe wywolanie metody :
	 * <code>
	 * $sword = $player->EquipSearch( array( 'type' => 'W' ), 'backpack' );
	 * //Pobieramy pierwszy element ze zwroconej tablicy
	 * $sword = array_shift( $sword );
	 * $player->Equip( $sword['id'] );
	 * </code>
	 *
	 * @param int $iid ID zakladanego przedmiotu
	 *
	 * @return bool TRUE lub FALSE w przypadku niepowodzenia
	 *
	 * @todo Sprawdzanie warunkow przed zalozeniem
	 */
	function Equip( $iid ) {
		$item = $this -> EquipSearch( array( 'id' => $iid ) );
		if( empty( $item ) ) {
			trigger_error( "Nie posiadasz takiego przedmiotu !", E_USER_WARNING );
			return FALSE;
		}

		$key = key( $item );
		$item = array_shift( $item );

		if( $item['minlev'] > $this -> level ) {
			trigger_error( "Nie posiadasz wystarczajaco wysokiego poziomu !", E_USER_WARNING );
			return FALSE;
		}
		if( $this -> clas == 'Barbarzynca' && ( in_array( $item['type'], array( 'S', 'Z' ) ) || $item['magic'] == 'Y' ) ) {
			trigger_error( "Nie mozesz uzywac tego typu przedmiotow !" );
			return FALSE;
		}
		// TODO ! sprawdzenie warunkow

		$what = '';
		if( in_array( $item['type'], array( 'W', 'B', 'S' ) ) ) {
			$what = 'weapon';
		}
		if( in_array( $item['type'], array( 'A', 'Z' ) ) ) {
			$what = 'armor';
		}
		if( in_array( $item['type'], array( 'H' ) ) ) {
			$what = 'helm';
		}
		if( in_array( $item['type'], array( 'D' ) ) ) {
			$what = 'shield';
		}
		if( in_array( $item['type'], array( 'N' ) ) ) {
			$what = 'knee';
		}
		if( in_array( $item['type'], array( 'R' ) ) ) {
			$what = 'arrows';
		}
		if( empty( $what ) ) {
			trigger_error( "Nie mozna zalozyc tego przedmiotu !", E_USER_WARNING );
			return FALSE;
		}

		if( isset( $this -> equip[$what] ) ) {
			$this -> Unequip( $what );
		}


		if( $item['amount'] == 1 ) {
			$this ->SqlExec( "UPDATE equipment SET `status`='E' WHERE id={$item['id']}" );
			unset( $this -> backpack[$key] );
			$this -> equip[$what] = $item;
			$this -> equip[$what]['status'] = 'E';
		}
		else {
			$toadd = $item;
			unset( $toadd['id'] );
			unset( $toadd['costbase'] );
			$toadd['amount'] = 1;
			unset( $toadd['img_file'] );
			$toadd['status'] = 'E';

			$sql['insert'] = $this -> SqlCreate( "INSERT", "equipment", $toadd );
			$sql['update'] = "UPDATE equipment SET amount = amount - 1 WHERE id={$item['id']}";
			$result = $this -> SqlExec( $sql['insert'] );
			$this -> SqlExec( $sql['update'] );
			//$result = $this -> SqlExec( $sql );
			//print_r( $result );
			$this -> backpack[$key]['amount']--;
			$this -> equip[$what] = $item;
			$this -> equip[$what]['amount'] = 1;
			$this -> equip[$what]['id'] = $result;
		}
		return TRUE;
	}

	/**
	 *  Dodawanie przedmiotow do pleckaka.
	 *
	 * Dodawanie przedmiotow. Moze dodawac przedmioty, wykorzystujac dane
	 * podane przez uzytkowika, lub moze dodawac przedmioty samemu wczytujac
	 * wszystkie dane z bazy. Sprawdza czy taki przedmiot juz istnieje, jesli
	 * tak to dodaje do niego, jesli nie istnieje to tworzy osobny wpis
	 *
	 * <b>W przypadku wykorzystania danych uzytkownika</b><br/>
	 * Podana tablia musi miec nastepujace pola :
	 *  + dla przedmiotow : name, power, type, cost, minlev, zr, wt, maxwt,
	 *     szyb, magic, poison, amount, twohand, imagenum, prefix
	 *  + dla mistur : name, power, type, cost, amount, prefix
	 *  + dla czarow : name, power, type, cost, minlev
	 * Pola id, owner, status sa uzupelniane wewnetrznie. Pozostale pola
	 * beda ignorowane.
	 * <b>UWAGA !!</b><br/>
	 * Do funkcji nalezy podawac pola w formacie 'ujednoliconym'.
	 *
	 * <b>W przypadku wczytania danych z bazy</b>
	 * Jak pierwszy parametr podaje sie ID przedmiotu. Metoda sama wykonuje
	 * zapytanie do bazy '<i>$table</i>', uzywajac jako nazwy klucza
	 * '<i>$id</i>'. Dla bezpieczenstwa doda tylko pierwszy ze znalezionych
	 * przedmiotow.
	 * <b>UWAGA !!</b><br/>
	 * Trzeba pamiêtac o tym, ze uzywajac automatycznego wczytywania, trzeba
	 * kontrolowac pole 'amount' dodawanych przedmiotow w jakis sposob
	 *
	 * @param array|int $iid Tablica z danymi o przedmiocie lub ID przedmiotu
	 * @param string $type Typ dodawanego przedmiotu. Obecnie obsluguje
	 *                     'backpack', 'potions' oraz 'spells'
	 * @param string $table Nazwa tablicy z ktorej nalezy pobrac dane w
	 *                      przypadku automatycznego pobierania danych z bazy
	 * @param string $field Nazwa kolumny ktorej nalezy uzywac do
	 *                      jednoznacznej identyfikacji dodawanego przedmiotu
	 *                      (nazwa kolumny ktora jest pirmary_key)
	 *
	 * @return bool TRUE, lub FALSE w przypadku porazki
	 *
	 */
	function EquipAdd( $iid, $type = 'backpack', $table = 'items', $field = 'id' ) {

		if( is_array( $iid ) ) {
			if( $type == 'backpack' ) {
				$needed = array( 'name', 'power', 'type', 'cost', 'minlev', 'zr', 'wt', 'szyb', 'maxwt', 'magic', 'poison', 'amount', 'twohand', 'imagenum', 'prefix' );
			}
			elseif( $type == 'potions' ) {
				$needed = array( 'name', 'type', 'power', 'amount', 'prefix', 'cost', 'imagenum' );
			}
			elseif( $type == 'spells' ) {
				$needed = array( 'name', 'cost', 'minlev', 'type', 'power' );
			}
			else {
				trigger_error( "Nieoblugiwany typ przedmiotu $type !", E_USER_WARNING );
				return FALSE;
			}
			foreach( $needed as $req ) {
				if( !isset( $iid[$req] ) ) {
					trigger_error( "Nie mozna dodac przedmiotu ! Niepelna tablica wejsciowa ( $req ) !", E_USER_WARNING );
					return FALSE;
				}
				$toadd[$req] = $iid[$req];
			}
			if( $type == 'backpack' ) {
				$toadd['owner'] = $this ->id;
				$toadd['status'] = 'U';
				$tableadd = 'equipment';
			}
			elseif( $type == 'potions' ) {
				$toadd['owner'] = $this -> id;
				$toadd['status'] = 'K';
				$tableadd = 'mikstury';
			}
			elseif( $type == 'spells' ) {
				$toadd['owner'] = $this -> id;
				$toadd['status'] = 'U';
				$tableadd = 'czary';
				//$item = $this -> DetranslateFields( $toadd, 'spells' );
				//"SELECT id, gracz AS owner, nazwa AS name, cena AS cost, poziom AS level, typ AS `type`, obr AS power, status FROM czary WHERE gracz={$this->id}"
				//$search = array( 'gracz' => $toadd['owner'], 'nazwa' => $toadd['owner'], 'cena' => $toadd
			}
			if( empty( $search ) ) {
				$search = $toadd;
				unset( $search['amount'] );
			}
			$try = $this -> EquipSearch( $search, $type );
			if( $try ) {
				//print_r($try);
				$key = key( $try );
				$try = array_shift( $try );
				if( $type == 'backpack' ) {
					$this -> backpack[$key]['amount'] += $toadd['amount'];
					$this -> SqlExec( "UPDATE $tableadd SET amount=amount+{$toadd['amount']} WHERE `$field`='{$this->backpack[$key]['id']}'" );
				}
				elseif( $type == 'potions' ) {
					$this -> potions[$key]['amount'] += $toadd['amount'];
					$this -> SqlExec( "UPDATE $tableadd SET amount=amount+{$toadd['amount']} WHERE `$field`='{$this->potions[$key]['id']}'" );
				}
				elseif( $type == 'spells' ) {
					trigger_error( "Mozesz miec tylko jeden taki czar !", E_USER_WARNING );
					return FALSE;
					//$this -> potions[$key]['amount'] += $toadd['amount'];
					//$this -> SqlExec( "UPDATE $tableadd SET amount=amount+{$toadd['amount']} WHERE `$field`='{$this->potions[$key]['id']}'" );
				}

			}
			else {
				//if( empty( $item ) ) {
				$item = $toadd;
				//}
				$sql = $this -> SqlCreate( 'INSERT', $tableadd, $this -> DetranslateFields( $item, $type ) );
				$insertid = $this -> SqlExec( $sql );
				//print_r( $insertid );
				$toadd['id'] = $insertid;
				if( $type == 'backpack' || $type == 'potions' ) {
					//print_r( $iid );
					if( !empty( $iid['img_file'] ) ) {
						$toadd['img_file'] = $iid['img_file'];
					}
					else {
						if( $type == 'backpack' ) {
							$res = $this -> SqlExec( "SELECT img_file FROM item_images WHERE id={$toadd['imagenum']}" );
						}
						else {
							$res = $this -> SqlExec( "SELECT img_file FROM images_potions WHERE id={$toadd['imagenum']}" );
						}
						if( isset( $res -> fields['img_file'] ) ) {
							$toadd['img_file'] = $res -> fields['img_file'];
						}
						else {
							$toadd['img_file'] = '';
						}
					}
				}
				array_push( $this -> $type, $toadd );
			}
			//}
			return TRUE;
		}
		else {
			$item = $this -> SqlExec( "SELECT * FROM $table WHERE `$field`='$iid'" );
			if( empty( $item -> fields[$field] ) ) {
				trigger_error( "Nie istnieje przedmiot $fields=$iid w tabeli $table !", E_USER_ERROR );
				return FALSE;
			}
			$item = array_shift( $item -> GetArray() );
			//print_r( $item );
			$item = $this -> TranslateFields( $item, $type );
			return $this -> EquipAdd( $item, $type );
		}
	}

	/** Usuwnaie przedmiotow.
	 *
	 * Szybkie usuwanie przedmiotow. Wywala wskazany przedmiot.
	 *
	 * @param int $iid ID przedmiotu do usuniecia
	 * @param string $type Polozenie przedmiotu: 'backpack', 'equip' lub 'potions'
	 *
	 * @return bool TRUE, lub FALSE w przypadku niepowodzenia
	 */
	function EquipDelete( $iid, $type = 'backpack' ) {
		$try = $this -> EquipSearch( array( 'id' => $iid ), $type );
		if( !empty( $try ) ) {
			//print_r( $try );
			$key = key( $try );
			$try = $try[$key];
			if( in_array( $type, array( 'backpack', 'equip' ) ) ) {
				//$this->SqlDebug = true;
				$this -> SqlExec( "DELETE FROM equipment WHERE id={$try['id']}" );
				//$this->SqlDebug = false;
				$item =& $this -> $type;
				//print_r( $item );
				unset( $item[$key] );
				//echo "[b]\$this -> {$type}[{$key}][/b]";
			}
			elseif( $type == 'potions' ) {
				$this -> SqlExec( "DELETE FROM mikstury WHERE id={$try['id']}" );
				$item =& $this -> $type;
				unset( $item[$key] );
				//echo "\$this -> {$type}[{$key}]";
			}
			else {
				trigger_error( "Nieprawidlowy typ przedmiotu do usuniecia !", E_USER_WARING );
				return FALSE;
			}
			return TRUE;
		}
		else {
			trigger_error( "Nie mozna usunac przedmiotu $iid - nie znaleziono !", E_USER_WARNING );
			return FALSE;
		}
	}

	/** Uzywanie mikstur.
	 *
	 * Aktywuje miksture, aplikuje efekt oraz zmniejsza ilosc posiadanych
	 * mikstur
	 *
	 * @param int $iid ID mikstury ktora chcesz uzyc
	 *
	 * @return bool TRUE, lub FALSE w przypadku niepowodzenia
	 */
	function PotionDrink( $iid ) {
		$potion = $this -> EquipSearch( array( 'id' => $iid ), 'potions' );
		if( $potion ) {
			$key = key( $potion );
			$potion = array_shift( $potion );
			switch( $potion['type'] ) {
				case 'M' :
					if( $this -> mana == $this -> mana_max ) {
						trigger_error( "Nie musisz uzupelniac many !", E_USER_NOTICE );
						return FALSE;
					}
					if( $this -> mana + $potion['power'] >= $this -> mana_max ) {
						$this -> mana = $this -> mana_max;
					}
					else {
						$this -> mana += $potion['power'];
					}
					break;
				case 'Z' :
					if( $this -> hp == $this -> hp_max ) {
						trigger_error( "Nie musisz sie leczyc !", E_USER_NOTICE );
						return FALSE;
					}
					if( $this -> hp <= 0 ) {
							trigger_error( "Musisz sie wskrzesic a nie uleczyc !", E_USER_WARNING );
							return FALSE;
						}
					if( $this -> hp + $potion['power'] >= $this -> hp_max ) {
						$this -> hp = $this -> hp_max;
					}
					else {
						$this -> hp += $potion['power'];
					}
					break;
				case 'W' :
						if( $this -> hp != 0 ) {
							trigger_error( "Nie ma potrzeby wskrzeszania !", E_USER_WARNING );
							return FALSE;
						}
 						$this -> hp = 1;
 						$pd = ceil($this -> exp / 100) * 2;
 						$this -> exp -= $pd;
 						trigger_error( "Wrociles do zycia ale straciles $pd doswiadczenia", E_USER_NOTICE );
					break;
				default :
					trigger_error(" Nieprawidlowy typ mikstury - {$potion['type']} !",E_USER_WARNING );
					return FALSE;
					break;
			}
			if( $potion['amount'] <= 1 ) {
				$this -> SqlExec( "DELETE FROM mikstury WHERE id={$potion['id']}" );
				unset( $this -> potions[$key] );
				return TRUE;
			}
			else {
				$this -> SqlExec( "UPDATE mikstury SET amount = amount -1 WHERE id={$potion['id']}" );
				$this -> potions[$key]['amount']--;
				return TRUE;
			}
		}
		else {
			trigger_error( "Mikstura $iid nie znaleziona !", E_USER_WARNING );
			return FALSE;
		}
	}

	/** Aktywowanie czaru.
	 *
	 * Proste i szybkie aktywowanie czaru. Samo wykrywa czy czar powinien
	 * byc aktywowany jako bojowy albo defensywny. Sprawdza wszystkie
	 * wymagania przed aktywowaniem czaru
	 *
	 * @param int $what ID czaru ktory czar chcesz aktywowac
	 *
	 * @return bool TRUE, albo FALSE w przypadku niepowodzenia
	 */
	function SpellActivate( $sid ) {
		$spell = $this -> EquipSearch( array( 'id' => $sid ), 'spells' );
		if( empty( $spell ) ) {
			trigger_error( "Nie moge odnalezc czaru !", E_USER_WARNING );
			return FALSE;
		}
		$key = key( $spell );
		$spell = array_shift( $spell );
		if( !in_array( $this -> clas, array( 'Mag', 'Druid', 'Kaplan' ) ) ) {
			trigger_error( "Nie nalezysz do klasy ktora potrafi rzucac czary !", E_USER_WARNING );
			return FALSE;
		}
		if( $spell['minlev'] > $this -> level ) {
			trigger_error( "Masz za niski poziom zeby uzywac tego czaru !", E_USER_WARNING );
			return FALSE;
		}
		if( $spell['type'] == 'U' ) {
			trigger_error( "Nie mozna aktywowac czarow ulepszajacych !", E_USER_WARNING );
			return FALSE;
		}
		elseif( $spell['type'] == 'B' ) {
			$what = 'spellatk';
		}
		elseif( $spell['type'] == 'O' ) {
			$what = 'spelldef';
		}
		if( !empty( $this -> equip[$what] ) ) {
			$this -> SpellDeactivate( $what );
		}
		$this -> SqlExec( "UPDATE czary SET `status`='E' WHERE id={$spell['id']}" );
		$this -> equip[$what] = $spell;
		unset( $this -> spells[$key] );
		return TRUE;
	}

	/** Deaktywowanie czaru.
	 *
	 * Proste i szybkie deaktywowanie czaru.
	 *
	 * @param string $what Ktory czar chcesz deaktywowac. Dostepne opcje to :
	 * spellatk albo spelldef
	 *
	 * @return bool TRUE, albo FALSE w przypadku niepowodzenia
	 */
	function SpellDeactivate( $what ) {
		if( !in_array( $what, array( 'spellatk', 'spelldef' ) ) ) {
			trigger_error( "Nie mozna deaktywowac tego typu czaru: $what !", E_USER_WARNING );
			return FALSE;
		}
		if( empty( $this -> equip[$what] ) ) {
			trigger_error( "Ten rodzaj czaru jest juz zdeaktywowany !", E_USER_WARNING );
			return FALSE;
		}
		$this -> SqlExec( "UPDATE czary SET `status`='U' WHERE id={$this->equip[$what]['id']}" );
		$this -> spells[] = $this -> equip[$what];
		unset( $this -> equip[$what] );
		return TRUE;
	}



	/** Uruchamianie zapytan SQL.
	 *
	 * Funkcja wywoluje zapytania SQL i zwraca wyniki z bazy
	 *
	 * @deprecated na korzysc globalnej funkcji {@link SqlExec}
	 *
	 * @param string $sql polecenie SQL ktore ma zostac wykonane. Moze byc
	 *                    tablica polecen - wtedy wyniki takze sa zracane
	 *                    jako tablica, z takimi samymi kluczami jak
	 *                    tablica wejsciowa
	 *
	 * @return mixed Wynik zapytania lub tablica wynikow. W przypadku
	 *               zapytania INSERT jest zwracana tylko i wylacznie
	 *               wartosc LAST_INSERT_ID
	 */
	function SqlExec( $sql ) {
		return SqlExec( $sql, $this->SqlDebug );

//		global $db;
//		if( !is_array( $sql ) ) {
//			if( $this -> SqlDebug === TRUE ) {
//				trigger_error( "Wykonuje zapytanie: $sql", E_USER_NOTICE );
//			}
//			//echo $sql;
//			$return = $db -> Execute( $sql ) or trigger_error( "Nie moge wykonac zapytania: $sql<br>".$db -> ErrorMsg(), E_USER_ERROR );
//			if( strcasecmp( substr( $sql, 0, 6 ), 'INSERT' ) === 0 ) {
//					$return = $db -> Insert_ID();
//				}
//			return $return;
//		}
//		else {
//			foreach( $sql as $key => $query ) {
//				if( $this -> SqlDebug === TRUE ) {
//					trigger_error( "Wykonuje zapytanie: [$key] => $query", E_USER_NOTICE );
//				}
//
//				$return[$key] = $db -> Execute( $query ) or trigger_error( "Nie moge wykonac zapytania: [$key] => $query<br>".$db -> ErrorMsg(), E_USER_ERROR );
//				if( strcasecmp( substr( $query, 0, 6 ), 'INSERT' ) === 0 ) {
//					$return[$key] = $db -> Insert_ID();
//				}
////				print_r( $db );
//			}
//			return $return;
//		}
	}

	/** Generator zapytan SQL.
	 *
	 * Funkcja tworzy zapytania na podstawie danych wejsciowych.
	 * Obecnie obsluguje SELECT, INSERT, DELETE i UPDATE
	 *
	 * @deprecated na korzysc globalnej funkcji {@link SqlCreate}
	 */
	 /* @param string $type Typ zapytania ktore nalezy utworzyc
	 * @param [table] Nazwa tabeli ktorej ma tyczyc zapytanie
	 * @param [fields] Tablica danych do zmienienia. Dopuszczalne formaty zaleza od rodzaju zapytania
	 *                 W przypadku SELECT moze byc puste (rownoznaczne z '*'),
	 *                 byc stringiem lub talbica (uzywane sa tylko wartosci)
	 *                 W przypadku INSERT tablica asocjacyjna
	 *                 W przypadku UPDATE moze byc stringiem albo tablica asocjacyjna
	 *                 W przypadku DELETE zawsze jest ignorowane i jesli chce sie uzywac
	 *                 klauzy WHERE trzeba podac np. NULL
	 * @param [where] Opcjonalna tablica lub string ktory zostanie uzyty do stworzenia klauzy WHERE.
	 *                Trzeba pamietac ze jesli poda sie tablice asocjacyjna to tworzone sa jedynie
	 *                rownosci ( `$key`='$val' ). Jesli chce sie tworzyc inne warunki to nalezy zamiast
	 *                tablicy podac string z gotowa klauza WHERE (bez slowa 'WHERE'). Ignorowane jesli
	 *                gdy <b>type</b> = INSERT
	 *
	 * @return Wygenerowane zapytanie SQL
	 */
	function SqlCreate( $type, $table, $fields = NULL, $where = NULL ) {

		return SqlCreate( $type, $table, $fields, $where );

//		$type = strtoupper( $type );
//		switch( $type ) {
//			case 'SELECT' :
//				if( $fields == NULL )
//					$fields = '*';
//				if( is_array( $fields ) ) {
//					$pola = '';
//					foreach( $fields as $key => $field ) {
//						$pola[] = "`$field`";
//					}
//					$fields = implode( ", ", $pola );
//				}
//				if( is_array( $where ) ) {
//					$pola = '';
//					foreach( $where as $key => $field ) {
//						$pola[] = "`$key`='$field'";
//					}
//					$where = implode( " AND ", $pola );
//				}
//				$sql = "SELECT $fields FROM $table".(($where)?" WHERE $where":"");
//				break;
//			case 'INSERT' :
//				if( $fields === NULL )
//					trigger_error( "Skladnia INSERT wymaga podania parametru \$fields !", E_USER_ERROR );
//				if( !is_array( $fields ) )
//					trigger_error( "Uzywajac INSERT musisz podac \$fields jako tablice !", E_USER_ERROR );
//				foreach( $fields as $key => $field ) {
//					$pola[] = "`$key`";
//					$wart[] = "'$field'";
//				}
//				$pola = implode( ", ", $pola );
//				$wart = implode( ", ", $wart );
//				$sql = "INSERT INTO $table($pola) VALUES($wart)";
//				break;
//			case 'UPDATE' :
//				if( $fields === NULL )
//					trigger_error( "Skladnia UPDATE wymaga podania parametru \$fields !", E_USER_ERROR );
//				if( is_array( $fields ) ) {
//					foreach( $fields as $key => $field ) {
//						$pola[] = "`$key`='$field'";
//					}
//					$fields = implode( ", ", $pola );
//				}
//				if( is_array( $where ) ) {
//					$pola = '';
//					foreach( $where as $key => $field ) {
//						$pola[] = "`$key`='$field'";
//					}
//					$where = implode( " AND ", $pola );
//				}
//				$sql = "UPDATE $table SET $fields".(($where)?" WHERE $where":"");
//				break;
//			case 'DELETE' :
//				if( $where === NULL )
//					trigger_error( "Uzycie zapytania DELETE bez klauzy WHERE !!", E_USER_WARNING );
//				if( is_array( $where ) ) {
//					$pola = '';
//					foreach( $where as $key => $field ) {
//						$pola[] = "`$key`='$field'";
//					}
//					$where = implode( " AND ", $pola );
//				}
//				$sql = "DELETE FROM $table".(($where)?" WHERE $where":"");
//				break;
//			default :
//				trigger_error( "Nieobslugiwany typ zapytan $type !", E_USER_ERROR );
//				break;
//		}
//		return $sql;
	}

	/**
	 * Kontrolowanie wplywow zewetrznych na gracza.
	 *
	 * W wiekszosci przypadkow nie ma problemu z synchronizacja ekwipunku
	 * gracza na skutek jego akcji [zakupy w sklepie itp]. Problem pojawia sie
	 * np. w przypadku banku gdzie klasa nie zna zachowania pozostalych graczy.
	 * Nie wie czy np. akurat ktos nie przekazal zlota. Ta funkcja jest obecnym
	 * rozwiazaniem. Po kazdym odtworzeniu sesji (co sie wykonuje na poczatku
	 * kazdego wywolania strony) sprawdza czy w tabeli `wakeup` w bazie nie ma
	 * przypadkiem sygnalu przeznaczonego dla niej. Jesli taki sie znajduje to
	 * przetwarza wszystkie pozostawione sygnaly wykonujac odpowiednie akcje.
	 * Obecnie obslugiwane sygnaly jakie klasa rozroznia to :
	 *  + 'res'    : modyfikacja surowcow [ze zlotem wlacznie]. Przeladowywana
	 *               jest cala tabelka z surowcami
	 *  + 'misc'   : modyfikacja ktorejs z wartosci 'pozostalych'.
	 *               Przeladowywane sa wszystkie dane 'pozostale' - hp, exp,
	 *               level, oczy itp itd
	 *  + 'pot'    : modyfikacja mikstur. Przeladowywana jest cala tabela
	 *               z miksturami.
	 *  + 'back'   : modyfikacja zawartosci plecaka [bez rzeczy noszonych na
	 *               sobie]. Przeladowywana jest zawartosc plecaka
	 *  + 'spells' : modyfikacja mikstur. Przeladowywane sa wszystkie czary
	 *               ktore nie sa obecnie aktywowane.
	 *  + 'equip'  : modyfikacja noszonego ekwipunku. Przeladowyane sa
	 *               tylko te pozycje z bazy, ktore gracz ma zalozone
	 *  + 'skills' : modywikacja umiejetnosci. Przeladowywane sa wszystkie
	 *               umiejetnosci
	 *  + 'atr'    : modfikacja atrybutow. Przeladowywane sa wszystkie atrybuty
	 * Sygnaly wydaje sie uzywajac  funkcji {@link PutSignal()}.
	 *
	 * Prosze pamietac ze z zalozenia to klasa ma wykonywac tylko minimalna
	 * ilosc zapytan do bazy przenoszac wszelkie informacje w sesjach
	 * [ale akutalizujac baze na biezaco zeby ewentualnie nie utracic danych].
	 * Dlatego tez prosze jest to mozliwe nie naduzywac systemu sygnalow do
	 * 'pojscia na latwizne' podczas modyfikacji danych przez gracza.
	 * Moglbym np. zeby sie nie meczyc w sklepie pod koniec zakupu wyslac
	 * poprostu sygnal i ekwipunek by sie przeladowal. Ale to jest zbedne i
	 * przeczy calej idei tej klasy. Dlatego prosze systemu sygnalow uzywac
	 * tylko kiedy zachodzic bedzie ingerencja z zewnatrz.
	 *
	 * Wszystko co sie dzieje w funkcji jest wyciszane z koniecznosci
	 * wystartowania sesji. Jesli chcesz miec informacje o tym co sie dzialo
	 * podczas deserializacji - wyswietlaj publiczna zmienna 'Reloaded'
	 * ktora zawiera komunkiaty o tym co sie wydarzylo wewnatrz __wakeup()
	 */
	function __wakeup() {
		$old = $this -> SqlDebug;
		$this -> SqlDebug = FALSE;
		$ret = $this -> SqlExec( "SELECT DISTINCT `type` FROM wakeup WHERE pid={$this -> id}" );
		if( $ret -> fields['type'] ) {
			$this -> Reloaded = '';
			$ret = $ret -> GetArray();
			foreach( $ret as $signal ) {
				switch( $signal['type'] ) {
					case 'res':
						$this -> res = array();
						$resources = $this -> SqlExec( "SELECT * FROM resources WHERE id={$this -> id}" );

						$resources = array_shift( $resources -> GetArray() );
						foreach( $this -> dbres as $key => $val ) {
							$this -> res[$key] = $resources[$val];
						}
						$this -> Reloaded .= 'Uwaga ! Niespojnosc surowcow ... przeladowuje ...<br>';
						break;
					case 'skills' :
						$stats = $this -> SqlExec( $this -> SqlCreate( 'SELECT', 'players', '*', "`id`='{$this ->id}'" ) );
						//print_r( $stats );
						$stats = array_shift( $stats -> GetArray() );

						$this -> skill = array();
						foreach( $this ->dbskill as $key => $val ) {
							$this -> skill[$key] = $stats[$val];
						}
						//print_r( $this -> skill );
						$this -> Reloaded .= 'Uwaga ! Niespojnosc umiejetnosci ... przeladowuje ...<br>';
						break;
					case 'atr' :
						$stats = $this -> SqlExec( $this -> SqlCreate( 'SELECT', 'players', '*', "`id`='{$this ->id}'" ) );
						//print_r( $stats );
						$stats = array_shift( $stats -> GetArray() );

						$this -> atr = array();
						foreach( $this ->dbatr as $key => $val ) {
							$this -> atr[$key] = $stats[$val];
						}
						//print_r( $this -> skill );
						$this -> Reloaded .= 'Uwaga ! Niespojnosc umiejetnosci ... przeladowuje ...<br>';
						break;
					case 'misc' :
						$id = $this -> id;
						$this -> misc = array();
						$stats = $this -> SqlExec( "SELECT p.*, r.name AS rankname, t.name AS tribe_name FROM players p JOIN ranks r ON r.id=p.rid LEFT JOIN tribes t ON t.id=p.tribe WHERE p.id=$id" );
						$stats = array_shift( $stats -> GetArray() );
						foreach( $this ->dbmisc as $key => $val ) {
							$this -> misc[$key] = $stats[$val];
						}
						$this -> misc['mana_max'] = 0;
						$this -> misc['rankname'] = $stats['rankname'];
						$this -> misc['tribe_name'] = $stats['tribe_name'];
						$this -> Reloaded .= 'Uwaga ! Niespojnosc danych ... przeladowuje ...<br>';
						break;
					case 'pot' :
						$potions = $this -> SqlExec( "SELECT * FROM mikstury WHERE gracz={$this -> id} AND `status`='K'" );
						$this -> potions = $this -> TranslateFields( $potions -> GetArray() );
						$this -> Reloaded .= 'Uwaga ! Niespojnosc mikstur ... przeladowuje ...<br>';
						break;
					case 'back':
						$backpack = $this -> SqlExec( "SELECT e.*, i.img_file FROM equipment e LEFT JOIN item_images i ON e.imagenum=i.id WHERE e.owner={$this->id} AND e.`status`='U'" );
						$this -> backpack = $backpack -> GetArray();
						$this -> Reloaded .= 'Uwaga ! Niespojnosc plecaka ... przeladowuje ...<br>';
						break;
					case 'equip':
						$worn = $this -> SqlExec( "SELECT e.*, i.img_file FROM equipment e LEFT JOIN item_images i ON e.imagenum=i.id WHERE e.owner={$this->id} AND e.`status`='E'" );
						$worn = $worn -> GetArray();
						//print_r( $worn );
						$this -> equip = array();
						foreach( $worn as $item ) {
							if( in_array( $item['type'], array( 'W', 'B', 'S' ) ) ) {
								$this ->equip['weapon'] = $item;
							}
							if( in_array( $item['type'], array( 'A', 'Z' ) ) ) {
								$this ->equip['armor'] = $item;
							}
							if( in_array( $item['type'], array( 'H' ) ) ) {
								$this ->equip['helm'] = $item;
							}
							if( in_array( $item['type'], array( 'D' ) ) ) {
								$this ->equip['shield'] = $item;
							}
							if( in_array( $item['type'], array( 'N' ) ) ) {
								$this ->equip['knee'] = $item;
							}
							if( in_array( $item['type'], array( 'R' ) ) ) {
								$this ->equip['arrows'] = $item;
							}
						}
						$this -> Reloaded .= 'Uwaga ! Niespojnosc ekwipunku ... przeladowuje ...<br>';
						break;
					case 'spells':
						$spells = $this -> SqlExec( "SELECT id, gracz AS owner, nazwa AS name, cena AS cost, poziom AS minlev, typ AS `type`, obr AS power, status FROM czary WHERE gracz={$this->id} AND `status`='U'" );
						$this -> spells = $this -> TranslateFields( $spells -> GetArray() );
						$this -> Reloaded .= 'Uwaga ! Niespojnosc czarow ... przeladowuje ...<br>';
						break;
					default :
						trigger_error( "Nieobslugiwany sygnal {$signal['type']} !", E_USER_ERROR );
						$this -> Reloaded .= "Uwaga ! Niespojnosc danych lecz sygnal {$signal['type']} nieobslugiwany !<br>";
				}
			}
			//$this -> _InitEquip();
			$this -> SqlExec( "DELETE FROM wakeup WHERE pid={$this -> id}" );
		}
		else {
			$this -> Reloaded = NULL;
		}
		//$ret -> Close();
		$this -> SqlDebug = $old;
	}

	/** Tlumaczenie pol do formatu wewnetrznego
	 *
	 * Podczas gdy przez caly czas dzialania klasy poslugujesz sie nazwami 'unormowanymi'
	 * to klasa ta tlumaczy pola te na odpowiadajace im w bazie, kiedy np.
	 * zmieniasz typ mikstury z 'M' na 'Z', podajac jako klucz 'type', to
	 * metoda ta podmienia 'type' na 'typ' i wykonuje poprawne zapytanie do
	 * bazy
	 *
	 * @param array $fields Tablica asojacyjna w ktorej klucze zostana przetlumaczone
	 * @param string $type Na jaki typ tlumaczyc - items, potions, spells
	 *
	 * @return array Tablica ze zmienionymi kluczami
	 */
	function DetranslateFields( $fields, $type ) {
		switch ( $type ) {
			case 'items' :
			case 'backpack' :
				return $fields;
				break;
			case 'potions' :
				$translation = array( 'id' => 'id', 'owner' => 'gracz', 'prefix' => 'prefix', 'name' => 'nazwa', 'type' => 'typ', 'efekt' => 'efekt', 'status' => 'status', 'cost' => 'cena', 'power' => 'moc', 'amount' => 'amount', 'imagenum' => 'imagenum', 'img_file'=>'img_file' );
				break;
			case 'spells' :
				$translation = array( 'id' => 'id', 'name' => 'nazwa', 'owner' => 'gracz', 'cost' => 'cena', 'minlev' => 'poziom', 'type' => 'typ', 'power' => 'obr', 'status' => 'status' );
				break;
			default :
				trigger_error( "Detranslacja nazw nie obsluguje typu: $type !", E_USER_WARNING );
				return FALSE;
		}
		$return = array();
		foreach( $fields as $key => $val ) {
			if( empty( $translation[$key] ) ) {
				trigger_error( "Proba transjacji klucza $key dla ktorego nie ma tlumaczenia ! Pomijam!", E_USER_ERROR );
				continue;
			}
			$return[$translation[$key]] = $val;
		}
		return $return;
	}

	/** Unifikacja nazw pol z bazy
	 *
	 * Klasa z zalozenia ma uzywac jednolitego nazewnictwa. Podczas wczytywania
	 * danych z bazy metoda ta normuje pola do jednoltego formatu. I tak
	 * np. przy wczytywaniu mikstur zamienia nazwe kolumny 'gracz' na
	 * 'owner', 'typ' na 'power' i tak dalej. Funkcje ta wykorzystuje
	 * wewnetrznie klasa i uzytkownik raczej nie bedzie potrzebowal jej uzywac
	 *
	 * @param array $fields Tablica asojacyjna w ktorej klucze zostana przetlumaczone
	 * @param string $type Na jaki tym tlumaczyc - equip, backpack, potions, spells
	 *
	 * @return Tablica ze zmienionymi kluczami
	 */
	function TranslateFields( $fields, $type ) {
		switch ( $type ) {
			case 'backpack' :
			case 'equip' :
				return $fields;
				break;
			case 'potions' :
				$translation = array( 'id' => 'id', 'gracz' => 'owner', 'prefix' => 'prefix', 'nazwa' => 'name', 'typ' => 'type', 'efekt' => 'efekt', 'status' => 'status', 'cena' => 'cost', 'moc' => 'power', 'amount' => 'amount', 'imagenum' => 'imagenum', 'img_file'=>'img_file' );
				break;
			case 'spells' :
				$translation = array( 'id' => 'id', 'nazwa' => 'name', 'gracz' => 'owner', 'cena' => 'cost', 'poziom' => 'minlev', 'typ' => 'type', 'obr' => 'power', 'status' => 'status' );
				break;
			default :
				trigger_error( "Translacja nazw nie obsluguje typu: $type !", E_USER_WARNING );
				return FALSE;
		}
		$return = array();
		foreach( $fields as $k => $val ) {
			if( empty( $translation[$k] ) ) {
				trigger_error( "Proba transjacji klucza $k dla ktorego nie ma tlumaczenia ! Pomijam!", E_USER_ERROR );
				continue;
			}
			$return[$translation[$k]] = $val;
		}
		return $return;
	}
}

?>
