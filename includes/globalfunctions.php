<?php

/**
* @desc Podstawowe, najbardziej uzyteczne funkcje
* @author IvaN <ivan-q@o2.pl>
* @copyright KaraTur-Team 2006-2007
* @package KaraTur
*/

$_sqldebug = false;

/**
* @desc Funkcja uruchamiajaca zapytania SQL. Sprawdza jednoczesnie czy zapytanie sie powiodlo, i jesli nie to uruchamiana jest funkcja trigger_error z poziomem bledu E_USER_ERROR, oraz komunikatem zwroconym przez MySQL.
* 
* @param string $sql Zapytanie do wykonania.
* @param bool $debug Czy informowac uzytkownika o wykonywanym zapytaniu ?
* 
* @return mixed Zaleznie od typu zapytania. W przypadku SELECT - wynik zapytania. W przypadku INSERT - wartosc LAST_INSERT_ID. W przypadku UPDATE i DELETE - wartosc AFFECTED_ROWS
*/
function SqlExec( $sql, $debug = NULL ) {
	global $db;
	global $_sqldebug;
	global $__safeMode, $__sandboxMode;

	if ( $debug === NULL ) {
		$debug = $_sqldebug;
	}

	$reg = "/^(\\w*)/";

	if ( !is_array( $sql ) ) {
		if ( $debug === TRUE ) {
			trigger_error( "Wykonuje zapytanie: $sql", E_USER_NOTICE );
		}

		preg_match( $reg, $sql, $match );
		$sqlType = strtoupper( $match[1] );
		
		if( $__sandboxMode == true ) {
			if( !in_array( $sqlType, array( "SELECT" ) ) ) {
				trigger_error( "W trybie piaskownicy dozwolone sa tylko zapytania typu 'SELECT'!<br/>Pomijam zapytanie <i>$sql</i>", E_USER_WARNING );
				return FALSE;
			}
		}
		$return = $db->Execute( $sql ) or trigger_error( "Nie moge wykonac zapytania: $sql<br>".$db->ErrorMsg( ), E_USER_ERROR );

		if ( in_array( $sqlType, array( "DELETE", "UPDATE" )) ) {
			$return = $db->Affected_Rows( );
		}

		if ( $sqlType == 'INSERT' ) {
			$return = $db->Insert_ID( );
		}
	}
	else {
		trigger_error( "SqlExec nie obsluguje tablic zapytan !", E_USER_ERROR );

		//foreach( $sql as $key => $query ) {
		//	if ( $debug === TRUE ) {
		//		trigger_error( "Wykonuje zapytanie: [$key] => $query", E_USER_NOTICE );
		//	}

		//	$return[$key] = $db->Execute( $query ) or trigger_error( "Nie moge wykonac zapytania: [$key] => $query<br>".$db->ErrorMsg( ), E_USER_ERROR );

		//	if ( strcasecmp( substr( $query, 0, 6 ), 'INSERT' ) === 0 ) {
		//		$return[$key] = $db->Insert_ID( );
		//	}
		//}
	//return $return;
	}

	if ( !empty( $__safeMode ) && $__safeMode === true ) {
		if( is_object( $return ) && method_exists( $return, "GetArray" ) ) {
			$return = $return->GetArray( );
		}
	}

	//unset( $db );
	//qDebug( $return );
	return $return;
}

//! Wysylanie sygnalow zmian zewnetrznych
function PutSignal( $pid, $signal ) {
	$res = SqlExec( "SELECT pid FROM wakeup WHERE `pid`='$pid' AND `type`='$signal'" );

	if ( empty( $res->fields['pid'] ) )
		SqlExec ( "INSERT INTO wakeup(pid,`type`) VALUES($pid,'$signal')" );

	return TRUE;
}

function hideObjects( &$item, $key ) {
	if( ( $className = get_class( $item ) ) !== FALSE ) {
		//$back[$k]['args'][$k1] = "Object of class <b>$className</b>";
		$item = "Object of class <b>$className</b>";
	}
}

// funkcja wylapujaca bledy
function catcherror( $errtype, $errdesc, $errfile, $errline ) {
	//global $db;
	global $smarty, $db;
	//global $player;
	
	//qDebug( error_reporting() );
	if( !error_reporting() ) {
		return;
	}

	$reparr = array( E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE, E_ERROR, E_WARNING, E_NOTICE );

	$halt = array( E_ERROR, E_WARNING, E_USER_ERROR );

	$errname = array( 'E_USER_ERROR', 'E_USER_WARNING', 'E_USER_NOTICE' );

	$pos = array_search( $errtype, $reparr );

	//debug_print_backtrace();
	//if ( strpos( $errfile, 'adodb' ) === FALSE ) {
	if( true ) {
		//if( $errtype == E_USER_NOTICE ) {
		if ( in_array( $errtype, $reparr ) ) {
			$smarty->assign( array( 'ErrDesc' => $errdesc, 'ErrFile' => $errfile, 'ErrLine' => $errline, 'ErrNo' => $errname[$pos], "Errnum" => $errtype ));

			$oldTplDir = $smarty->template_dir;
			$oldCmplDir = $smarty->compile_dir;
			$smarty->template_dir = './templates';
			$smarty->compile_dir = './templates_c';
			$smarty->display( 'errmsg.tpl' );
			$smarty->template_dir = $oldTplDir;
			$smarty->compile_dir = $oldCmplDir;
		}

		
		//var_dump( $halt );
		if ( in_array( $errtype, $halt ) ) {
			for( $i = 0; $i < count( ob_list_handlers() ); $i++ ) {
				ob_end_flush();
			}
			$back = debug_backtrace( );
			//array_walk_recursive( $back, 'hideObjects' );
			foreach( $back as $k => $b ) {
				//echo "$b[class]<br/>";
				if ( !empty( $b['class'] ) ) {
					if( in_array( $b['class'], array( "Smarty", "Smarty_Compiler" ) ) ) {
						$back[$k]['args'] = "<b>{$b['class']} internal args</b> (cleared)";
					}
					$b['object'] = "Object (cleared)";
					$back[$k]['object'] = "<b>".$b['class']." Object</b> (cleared)";
				}
				//foreach ($b['args'] as $k1 => $v) {
					//qDebug( get_class( $v ) );
					//if( ( $className = get_class( $v ) ) !== FALSE ) {
					//	$back[$k]['args'][$k1] = "Object of class <b>$className</b>";
					//}
				//}
			//qDebug( $b );

			//foreach( $b as $key => $ba ) {
			//if( $ba['function'] == 'catcherror' ) {
			//echo "unset $key<br/>";
			//unset( $back[$key] );
			//continue;
			//}
			//if( !isset( $ba['args'][4] ) ) {
			//	continue;
			//}
			//	var_dump( $ba['class'] );
			//	echo "<br/>";
			//	if( !empty( $ba['class'] ) ) {
			//		echo "$ba[class] at $key<br>";
			//unset( $back[$key]['object'] );
			//unset( $back[$key] );
			//$back[$key]['object'] = $ba['class'] . " Object (cleared)";
			//$back[$key]['object'] = " Object (cleared)";
			//		continue;
			//	}
			//	foreach( $ba['args'][4] as $key2 => $arg ) {
			//		echo get_class( $arg )."<br>";
			//		if(  stripos( get_class( $arg ), 'ADODB' ) !== FALSE ) {
			//			$back[$key]['args'][4][$key2] = "ADODB object [cleared]";
			//		}
			//	}
			//}
			}
			

			//qDebug( $back );
			//print_r( $back );
			//qDebug( $back );
			$msg = '';

			foreach( $back as $k1 => $ba ) {
				$msg .= "Poziom $k1 :\n";

				if ( !empty( $ba['object'] ) ) {
					//unset ( $ba['object'] );
				}

				$msg .= print_r( $ba, TRUE );
			/*foreach( $ba as $k2 => $b ) {
				if( !is_array( $b ) ) {
					$msg .= "\t[$k2] :: ";
					//$msg .= wordwrap($b, 40, "\n\t");
					$msg .= print_r( $b, TRUE );
					$msg .= "\n";
				}
				else {
					$msg .= "\t[$k2] =>\n";
					foreach( $b as $k3 => $a ) {
						$msg .= "\t\t[$k3] :: ";
						$msg .= wordwrap($a,40,"\n\t\t\t");
						$msg .= "\n";
					}
				}
			}*/
			}

			//echo "<pre>$msg</pre>";
			qDebug( htmlspecialchars( $msg ) );
			//echo "HATLUEJ";
			//exit;
			$report = array();

			$report['url'] = $_SERVER['REQUEST_URI'];
			$report['file'] = $errfile;
			$report['line'] = $errline;
			$report['desc'] = addslashes( $errdesc );
			$report['backtrace'] = addslashes( $msg );
			$sql = SqlCreate( "SELECT", 'bugtrack', '*', $report );
			$res = SqlExec( $sql );

			if ( $res->fields['id'] ) {
				$mod['time'] = time( );
				$mod['new'] = 'Y';
				$mod['amount'] = $res->fields['amount'] + 1;
				$sql = SqlCreate( "UPDATE", 'bugtrack', $mod, array('id' => $res->fields['id']));
				SqlExec( $sql );
			}
			else {
				$report['time'] = time( );
				$report['new'] = 'Y';
				$report['amount'] = 1;
				$sql = SqlCreate( "INSERT", 'bugtrack', $report );
				SqlExec( $sql );
			}

			echo "<div>Nastapil blad krytyczny $errtype, ladowanie strony wstrzymane. Blad zostal zgloszony na Bugtrack !</div>";
			$db->Close();
			exit( );
		}
	}
}

/**
* @desc Funkcja przerywajaca dzialanie obecnego skryptu. Wywoluje exit() na koncu funkcji
* 
* @param string $text Tresc beldu, jaka zostanie wyswietlona
* @param string $status Rodzaj bledu. Obecnie obsluguje 'error' i 'done'. W zaleznosci od tego parametru wyswietlane sa rozne ramki z komunikatem.
* @param string $url Link pod jaki ma prowadzic pole 'Wroc' w komunikacie
*/
function error( $text, $status = 'error', $url = '' ) {
	global $smarty;
	global $db;
	global $start_time;
	global $player;
	global $numquery;
	global $compress;
	global $sqltime;
	global $phptime;
	global $gamename;
	global $Overfg, $Overbg;
	
	if ( !ereg( "<a href", $text ) ) {
		if ( $url == '' )
			$text = $text." (<a href=\"".$_SERVER['PHP_SELF']."\">Wroc</a>)";
		else
			$text = $text." (<a href=\"".$url."\">Wroc</a>)";
	}

	$smarty->assign( "Status", $status );
	$smarty->assign( "Url", $url );
	$smarty->assign( array( "Message" => $text, "Gamename" => $gamename, "Meta" => '' ));

	$smarty->display( 'error2.tpl' );
	
	for( $i = 0; $i < count( ob_list_handlers() ); $i++ ) {
		ob_end_flush();
	}
	
	require_once ( "includes/foot.php" );
	exit;
}

//! Funkcja sprawdzajaca w danym miejscu jest dostep do danego pliku
function checklocation( $filename = NULL, $return = false ) {
	global $db;
	global $player;
	global $title;
	
	if( $filename !== NULL ) {
		$file = basename( $filename );
		//echo "yooooo $file<br/>";
	}
	else {
		$file = basename( $_SERVER['SCRIPT_NAME'] );
	}
	
	if( kt_city_page_get_title() ) {
		$title = kt_city_page_get_title();
	}
	
	$allow = true;
	$errMsg = '';
	$retUrl = '';
	//	if($player->location=="Lochy")
	//		error("Nie masz tutaj wstêpu poniewa¿ jeste¶ w wiêzieniu");
	if ( $player->jail == 'Y' && $file != 'jail.php' ) {
		$errMsg = "Nie masz tutaj wstêpu poniewa¿ jestes w wiêzieniu";
		$retUrl = 'city.php';
		$allow - false;
		//error( , 'error', 'city.php' );
	}
	
	if( $player->hp <= 0 ) {
		$errMsg ="Jestes martwy !";
		$retUrl = 'city.php';
		$allow - false;
	}
		
	//qDebug( $player->file );
	if( strlen( $player->file ) <= 0 ) {
		$errMsg ="Tutuaj nie ma nic interesj±cego !";
		$retUrl = 'mapa.php';
		$allow - false;
		//error( , 'error', 'mapa.php' );
	}
	

	//$test = SqlExec( "SELECT id FROM miasta WHERE `name`='{$player->file}'" );
	$test = SqlExec( "SELECT id FROM mapa WHERE `file` = '{$player->file}' AND `type`='C'");
	$test = $test->GetArray();
	//qDebug( $test );
	if( $allow ) {
		if( !empty( $test ) ) {
			$retUrl = 'city.php';
			$test = array_shift( $test );
			if( $file == 'modules.php' ) {
				$type = 'module';
				$modName = $_GET['mod'];
			}
			elseif( $file == 'city.php' && isset( $_GET['page'] ) ) {
				$type = 'page';
			}
			else {
				$type = 'file';
			}
			$test = SqlExec( "SELECT value FROM cityData WHERE city_id={$test['id']} AND ( col4='file' )" );
			$test = $test->GetArray();
			//qDebug( $test );
			$found = false;
			foreach( $test as $item ) {
				if( $type == 'module' ) {
					if( $item['value'] ==  $modName ) {
						$found = true;
						break;
					}
				}
				elseif( $type== 'page' ) {
					if( basename( $item['value'], ".php" ) == $_GET['page'] && file_exists( "city_pages/{$_GET['page']}.php" ) ) {
						$found = true;
						break;
					}
				}
				else {
					if( $item['value'] == $file ) {
						$found = true;
						break;
					}
				}
			}
			if( !$found ) {
				$allow = false;
			}
			
		}
		else {
			$retUrl = 'city.php';
			$test = SqlExec( "SELECT `file` FROM mapa WHERE `file`='{$player->file}' AND `zm_y`='{$player->mapy}' AND `zm_x`='{$player->mapx}'" );
			$test = $test->GetArray();
			//qDebug( $test );
	//		$test = SqlExec( "SELECT `file` FROM `miasta-spec` WHERE `mapx`='{$player->mapx}' AND `mapy`='{$player->mapy}'" );
	//		$test = $test->GetArray();
			if( !empty( $test ) ) {
				$test = array_shift( $test );
				if( $test['file'] != $file ) {
					$retUrl = 'mapa.php';
					$allow = false;
				}
				else {
					$allow = true;
				}
			}
			else {
				
				$allow = false;
			}
			//qDebug( $test );
			
		}
	}
	
	if( !$allow ) {
		if( !$return ) {
			if( $errMsg ) {
				error( $errMsg, 'error', $retUrl );
			}
			else {
				error( "W miejscu <b>{$player->location}</b> nie masz dostepu do <b>$title</b> !", 'error', $retUrl );
			}
		}
		else {
			return $allow;
		}
	}
	return $allow;
}

//! Funkcja obliczajaca ile doswiadczenia potrzeba na nastepny poziom
function expnext( $level ) {
	$expn = 0;

	if ( $level < 100 ) {
		$expn = ( pow( $level, 2 ) * 100 );
	}

	if ( $level > 99 && $level < 200 ) {
		$expn = ( pow( $level, 2 ) * 500 );
	}

	if ( $level > 199 && $level < 300 ) {
		$expn = ( pow( $level, 2 ) * 1000 );
	}

	if ( $level > 299 && $level < 400 ) {
		$expn = ( pow( $level, 2 ) * 2000 );
	}

	if ( $level > 399 && $level < 500 ) {
		$expn = ( pow( $level, 2 ) * 5000 );
	}

	if ( $level > 499 && $level < 600 ) {
		$expn = ( pow( $level, 2 ) * 10000 );
	}

	if ( $level > 599 && $level < 700 ) {
		$expn = ( pow( $level, 2 ) * 20000 );
	}

	if ( $level > 699 && $level < 800 ) {
		$expn = ( pow( $level, 2 ) * 50000 );
	}

	if ( $level > 799 && $level < 900 ) {
		$expn = ( pow( $level, 2 ) * 100000 );
	}

	if ( $level > 899 && $level < 1000 ) {
		$expn = ( pow( $level, 2 ) * 200000 );
	}

	return $expn;
}

function testModule( $name, $forced = FALSE ) {
	$__modData = SqlExec( "SELECT * FROM modules WHERE name='{$name}'" );

	if ( empty( $__modData->fields['id'] ) ) {
		$__modValid = false;
		$__modData = FALSE;
	}
	else {
		$__modValid = true;
		$__modData = array_shift( $__modData->getArray( ) );
	}

	if ( $__modValid ) {
		if ( $__modData['checked'] != 1 && $forced == FALSE ) {
			$__modValid = false;
		}
	}

	if ( $__modValid ) {
		$modDir = "modules/{$__modData['name']}/";

		if ( !is_file( $modDir."main.php" ) ) {
			$__modValid = false;
		}
	}

	return $__modValid;
}

function outputModule( $content ) {
	global $__modValid, $__modData, $player;

	if ( !$__modValid && $__modData['owner'] != $player->id ) {
		return "<div style='border:solid 1px;border-color:red'>modul <b>{$__modData['name']}</b> zawiera niepoprawny kod i nie moze zostac wyswietlony</div>";
	}

	if ( !$__modValid && $__modData['owner'] == $player->id ) {
		$content = "<div style='border:solid 3px;border-color:#cd0505'>modul <b>{$__modData['name']}</b> z powodu bledow podczas wykonywania wylaczony z dzialania.<br/>Prosze o jak najszybsze naprawienie bledow !<br/><hr size='4' noshade style='background-color:#cd0505'/>".$content."</div>";
	}

	return $content;
}


/**
 * Funkcja uruchamiajaca okreslony modul. Nie sprawdza czy miejsce jest poprawne, tylko tworzy zabezpieczone srodowisko i uruchamia modul.
 *
 * @param string $name nazwa kodowa modulu
 * @param bool $forced 
 */
function runModule( $name, $forced = FALSE ) {
	global $player, $smarty, $__safeMode, $__sandboxMode, $__modData, $__modValid;
	require_once ( "includes/modulefunctions.php" );
	$__modData = SqlExec( "SELECT * FROM modules WHERE name='{$name}'" );

	if ( empty( $__modData->fields['id'] ) ) {
		qDebug( "blebleble" );
		$__modValid = false;
		$__modData = FALSE;
	}
	else {
		$__modValid = true;
		$__modData = array_shift( $__modData->getArray( ) );
	}

	if ( $__modValid ) {
		if ( $__modData['checked'] != 1 && $forced == FALSE ) {
			
			$__modValid = false;
		}
	}

	if ( $__modValid ) {
		//if( false ) {
		$modDir = "modules/{$__modData['name']}/";

		//$db->password = "*hidden*";
		//$db->user = "*hidden*";
		//$db->database = "*hidden*";
		if ( !is_file( $modDir."main.php" ) ) {
			$__modValid = false;
		}
	}

	//$smarty->force_compile = true;

	if ( !$__modValid ) {
		if ( $__modData['type'] == 'sidebar' ) {
			echo "<div style='color:red;text-align:center;border-top:solid 1px;border-bottom:solid 1px; font-size:0.8em'>Modul <b style='font-size:0.9em'>{$__modData['name']}</b> niepoprawny albo niekompletny !</div>";
		}
		else {
			error ( "Module invalid or incomplete !" );
		}
	}
	else {
		//unset( $GLOBALS );
		$__safeMode = true;

		if ( $__modData['checked'] != 1 ) {
			$__sandboxMode = true;
		}

		$smarty->security = true;
		$smarty->template_dir = "$modDir/tpl";
		$smarty->compile_dir = "$modDir/tpl_c";

		if ( $__sandboxMode == true ) {
			echo "<div style='border-bottom:solid 1px;width:100%;text-align:center;background:#000024'>Test modulu</div>";
		}
		else {
			echo "<div>";
		}

		ob_start ( "outputModule" );
		require_once ( $modDir."main.php" );
		ob_end_flush( );

		if ( $__sandboxMode == true ) {
			echo "<div style='border-top:solid 1px;width:100%;background:#000024'>&nbsp;</div>";
		}
		else {
			echo "</div>";
		}

		$smarty->template_dir = './templates';
		$smarty->compile_dir = './templates_c';
		$smarty->security = false;
		$__sandboxMode = false;
		$__safeMode = false;
	//qDebug( print_r( $__data, true ) );
	}
}

function runModuleAdmin( $name, $forced = FALSE ) {
	global $player, $smarty, $__safeMode, $__sandboxMode, $__modData, $__modValid;
	require_once ( "includes/modulefunctions.php" );
	$__modData = SqlExec( "SELECT * FROM modules WHERE name='{$name}'" );

	if ( empty( $__modData->fields['id'] ) ) {
		$__modValid = false;
		$__modData = FALSE;
	}
	else {
		$__modValid = true;
		$__modData = array_shift( $__modData->getArray( ) );
	}

	if ( $__modValid ) {
		//if ( $__modData['checked'] != 1 && $forced == FALSE ) {
		//	
		//	$__modValid = false;
		//}
	}

	if ( $__modValid ) {
		$modDir = "modules/{$__modData['name']}/";
		if ( !is_file( $modDir."inc/KT.admin_page.inc.php" ) ) {
			$__modValid = false;
		}
	}

	//$smarty->force_compile = true;

	if ( !$__modValid ) {
		error ( "Admin page invalid or incomplete !" );
	}
	else {
		$__safeMode = true;

		if ( $__modData['checked'] != 1 ) {
			$__sandboxMode = true;
		}

		$smarty->security = true;
		$smarty->template_dir = "$modDir/tpl";
		$smarty->compile_dir = "$modDir/tpl_c";

		echo "<div>";
		require_once ( $modDir."inc/KT.admin_page.inc.php" );
		echo "</div>";

		$smarty->template_dir = './templates';
		$smarty->compile_dir = './templates_c';
		$smarty->security = false;
		$__sandboxMode = false;
		$__safeMode = false;
	}
}

//! Generator zapytan SQL
/**
	*  @desc Funkcja tworzy zapytania na podstawie danych wejsciowych. Obecnie obsluguje SELECT, INSERT, DELETE i UPDATE
	*
	* @param string $type Typ zapytania ktore nalezy utworzyc
	* @param string $table Nazwa tabeli ktorej ma tyczyc zapytanie
	* @param mixed $fields Tablica danych do zmienienia. Dopuszczalne formaty zaleza od rodzaju zapytania <ul>
	*                 <li>W przypadku SELECT moze byc puste (rownoznaczne z '*'),
	*                 byc stringiem lub talbica (uzywane sa tylko wartosci) </li>
	*                 <li>W przypadku INSERT tablica asocjacyjna </li>
	*                 <li>W przypadku UPDATE moze byc stringiem albo tablica asocjacyjna </li>
	*                 <li>W przypadku DELETE zawsze jest ignorowane i jesli chce sie uzywac
	*                 klauzy WHERE trzeba podac np. NULL </li></ul>
	* @param mixed $where Opcjonalna tablica lub string ktory zostanie uzyty do stworzenia klauzy WHERE.
	*                Trzeba pamietac ze jesli poda sie tablice asocjacyjna to tworzone sa jedynie
	*                rownosci ( `$key`='$val' ). Jesli chce sie tworzyc inne warunki to nalezy zamiast
	*                tablicy podac string z gotowa klauza WHERE (bez slowa 'WHERE'). Ignorowane jesli
	*                gdy @a type = INSERT
	*
	* @return string Wygenerowane zapytanie SQL
*/
function SqlCreate( $type, $table, $fields = NULL, $where = NULL ) {
	$type = strtoupper( $type );

	switch( $type ) {
		case 'SELECT':
			if ( $fields == NULL )
				$fields = '*';

			if ( is_array( $fields ) ) {
				$pola = '';

				foreach( $fields as $key => $field ) {
					$pola[] = "`$field`";
				}

				$fields = implode( ",\n\t", $pola );
			}

			if ( is_array( $where ) ) {
				$pola = '';

				foreach( $where as $key => $field ) {
					$pola[] = "`$key`='$field'";
				}

				$where = implode( "\n\tAND ", $pola );
			}

			$sql = "SELECT\n\t$fields\nFROM\n\t$table".( ( $where ) ? "\nWHERE\n\t$where" : "" );
			break;

		case 'INSERT':
			if ( $fields === NULL )
				trigger_error( "Skladnia INSERT wymaga podania parametru \$fields !", E_USER_ERROR );

			if ( !is_array( $fields ) )
				trigger_error( "Uzywajac INSERT musisz podac \$fields jako tablice !", E_USER_ERROR );

			foreach( $fields as $key => $field ) {
				$pola[] = "`$key`";
				$wart[] = "'$field'";
			}

			$pola = implode( ",\n\t", $pola );
			$wart = implode( ",\n\t", $wart );
			$sql = "INSERT INTO $table\n\t($pola)\nVALUES\n\t($wart)";
			break;

		case 'UPDATE':
			if ( $fields === NULL )
				trigger_error( "Skladnia UPDATE wymaga podania parametru \$fields !", E_USER_ERROR );

			if ( is_array( $fields ) ) {
				foreach( $fields as $key => $field ) {
					$pola[] = "`$key`='$field'";
				}

				$fields = implode( ",\n\t", $pola );
			}

			if ( is_array( $where ) ) {
				$pola = '';

				foreach( $where as $key => $field ) {
					$pola[] = "`$key`='$field'";
				}

				$where = implode( " AND ", $pola );
			}

			$sql = "UPDATE\n\t$table\nSET\n\t$fields".( ( $where ) ? "\nWHERE\n\t$where" : "" );
			break;

		case 'DELETE':
			if ( $where === NULL )
				trigger_error( "Uzycie zapytania DELETE bez klauzy WHERE !!", E_USER_WARNING );

			if ( is_array( $where ) ) {
				$pola = '';

				foreach( $where as $key => $field ) {
					$pola[] = "`$key`='$field'";
				}

				$where = implode( "\n\tAND ", $pola );
			}

			$sql = "DELETE FROM\n\t$table".( ( $where ) ? "\nWHERE\n\t$where" : "" );
			break;

		default:
			trigger_error( "Nieobslugiwany typ zapytan $type !", E_USER_ERROR );

			break;
	}

	return $sql;
}

function qDebug( $msg ) {
	global $player;

	if ( is_array( $msg ) ) {
		$msg = print_r( $msg, true );
//		ob_start();
//		var_dump( $msg );
//		$msg = ob_get_contents();
//		ob_end_clean();
	}

	//if ( $player->id == 267 ) {
		$debug = debug_backtrace();
		//print_r( $debug );
		$file = $debug[0]['file'];
		$file = str_replace( "\\", "/", $file );
		$file = str_replace( $_SERVER['DOCUMENT_ROOT'], '', $file );
		$file = str_replace( dirname( $_SERVER['PHP_SELF'] )."/", '', $file );
		$line = $debug[0]['line'];
		//echo "<pre>";
		//print_r ( debug_backtrace() );
		//echo "</pre>";
		echo "<div><pre style=\"padding:0px;margin:0px;border-style:solid;border-width:thin\"><div style=\"margin:0px;padding:0px;font-size:0.8em;text-align:center;color:gray\">$file at $line</div>$msg</pre></div>";
	//}
}

function getRank( $rankPrv ) {
	global $player;
	$ranks = array( 'update', 'news', 'edplayer', 'qmsg', 'delete', 'cash', 'ranks', 'rankprev', 'city', 'old', 'atribs', 'immu', 'clearforum', 'clearchat', 'ip', 'addeq', 'addmon', 'addkow', 'addsp', 'mail', 'block', 'jail', 'bridge', 'email', 'close', 'ban', 'priest', 'clearlog', 'clearmail', 'mapedit', 'shop', 'poll', 'akta', 'form', 'edtown', 'double', 'userdel', 'usersniff', 'tribedel', 'forum_adm', 'moduleadd', 'modulemanage', 'changelog', 'gamemaster', 'grant_citizen', 'library', 'filer' );
	if( $rankPrv == 'getall' ) {
		$ranks = SqlExec( SqlCreate( "SELECT", "ranks", $ranks, array( 'id'=>$player->rid ) ) );
		$ranks = $ranks->getArray();
		$ranks = array_shift( $ranks );
		//qDebug( $ranks );
		return $ranks;
	}
	if( !in_array( $rankPrv, $ranks ) ) {
		//error( "Nie ma takiej rangi `$rankPrv` !" );
		trigger_error( "Nie ma takie rangi `$rankPrv` !", E_USER_ERROR );
	}
	$test = SqlExec( "SELECT `$rankPrv` AS val FROM ranks WHERE id={$player->rid}" );
	$test = array_shift( $test->GetArray() );
	//qDebug( $test );
	return (bool)$test['val'];
}

function scanphp($arr) {
	foreach($arr as $val)
		if(ereg("^.*\.php",$val))
			$php[]=$val;
	return $php;
}

function resizeImage( $img, $width = 100, $height = 100 ) {

	//list($width_orig, $height_orig) = getimagesize($img);
	$width_orig = imagesx( $img );
	$height_orig = imagesy( $img );

	if ($width && ($width_orig < $height_orig)) {
		$width = ($height / $height_orig) * $width_orig;
	}
	else {
		$height = ($width / $width_orig) * $height_orig;
	}

	$image_p = imagecreatetruecolor($width, $height);
	$image = $img;
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

	//imagejpeg($image_p, null, 100);
	return $image_p;
}

function dbDate( $timestamp = -1 ) {
	if( $timestamp < 0 ) {
		$timestamp = time();
	}
	return date( 'Y-m-d H:i:s', $timestamp );
}

function getTimestampPeriod( $sec, $min = 0, $hour = 0, $day = 0, $month = 0 ) {
	$ret = $sec + 60*$min + 60*60*$hour + 60*60*24*$day;
	return $ret;
}

/**
 * Wysy³anie wiadomo¶c do pojedynczej osoby
 *
 * @param int $from ID nadawcy
 * @param int $to ID odbiorcy
 * @param string $title Tytu³ wiadomo¶ci
 * @param string $body Tre¶æ wiadomo¶ci
 * @param string $type Rodzaj wiadomo¶c
 */
function sendMsg( $from, $to, $title, $body, $type = 'msg' ) {
	SqlExec( "INSERT INTO mail( `owner`, `sender`, `type`, `topic`, `body` ) VALUES( '{$to}', '{$from}', '$type', '{$title}', '{$body}' )", true );
	if( $type == 'msg' ) {
		SqlExec( "INSERT INTO mail( `owner`, `sender`, `type`, `topic`, `body` ) VALUES( '{$to}', '{$from}', 'send', '{$title}', '{$body}' )", true );
	}
}

function showInfo( $text, $type = 'info', $around = NULL ) {
	global $smarty;
	if( !in_array( $type, array( 'info', 'warn', 'error' ) ) ) {
		trigger_error( "nieprawidlowy typ informacji : $type", E_USER_WARNING );
		return;
	}
	if( $around ) {
		$text = "<$around>$text</$around>";
	}
	$smarty->assign( array( "infoType" => $type,
					 "infoText"=>$text
						  )
				   );
	$smarty -> display( "showinfo.tpl" );
}

function kt_url_rewriter_get_tags() {
	return $GLOBALS['KT_CONFIG']['rewriter']['tags'];
}

function kt_url_rewriter_city_add_var( $var, $value ) {
	$GLOBALS['KT_CONFIG']['rewriter']['city']['vars'][$var] = $value;
}

function kt_url_rewriter_city_get_vars() {
	return $GLOBALS['KT_CONFIG']['rewriter']['city']['vars'];
}

function kt_url_rewriter_city_reset_var() {
	$GLOBALS['KT_CONFIG']['rewriter']['city']['vars'] = array();
}

function kt_url_rewriter_city( $data ) {
	$tags = kt_url_rewriter_get_tags();
	$vars = kt_url_rewriter_city_get_vars();
	if( empty( $vars ) ) {
		return $data;
	}
	foreach( $tags as $tag => $atr ) {
		$tmp = NULL;
		if( preg_match_all( "/\\<{$tag}([^>]*)\\>/i", $data, $tmp, PREG_SET_ORDER ) ) {
			foreach( $tmp as $v1 ) {
				$_changed = false;
				$old_v1 = $v1[1];
				$tmp1 = NULL;
				if( preg_match_all( "/$atr=(\"|')([^\\1]*)\\1/U", $v1[1], $tmp1, PREG_SET_ORDER ) ) {
					foreach( $tmp1 as $v2 ) {
						$old_v2 = $v2[2];
						$parts = explode( "?", $v2[2] );
						if( !is_array( $parts ) ) {
							$parts = array( $parts );
						}
						if( count( $parts ) <= 1 ) {
							$parts[] = '';
						}
						$tmp2 = array_combine( array( 'path', 'query' ) , $parts );
						if( basename( $tmp2['path'] ) == 'city.php' || empty( $tmp2['path'] ) ) {
							$query = NULL;
							parse_str( $tmp2['query'], $query );
							$diff = array_diff_key( $vars, $query );
							if( !empty( $diff ) ) {
								$query = $query + $diff;
								$new_query = http_build_query( $query );
								//$v1[1] = $tmp2['path']."?{$new_query}";
								//$v1[1] = str_replace( $tmp2['path'].($tmp2['query'])?"?{$tmp2['query']}":"", $tmp2['path'].($tmp2['query'])?"?{$new_query}":"", $v1[1] );
								$v2[2] = $tmp2['path']."?{$new_query}";
								$v1[1] = str_replace( $old_v2, $v2[2], $v1[1] );
								$_changed = true;
							}
							
						}
					}
				}
				if( $_changed ) {
					$data = str_replace( $old_v1, $v1[1], $data );
				}
			}
		}
	}
	//return $ret;
	$data = "<div class=\"page_title\">".kt_city_page_get_title()."</div>\n".$data;
	return $data;
}

function kt_city_page_set_title( $title ) {
	$GLOBALS['KT_CONFIG']['city_page']['title'] = $title;
}
function kt_city_page_get_title() {
	if( isset( $GLOBALS['KT_CONFIG']['city_page']['title'] ) ) {
		return $GLOBALS['KT_CONFIG']['city_page']['title'];
	}
	else {
		return "";
	}
}

function log_event( $message, $level = 5 ) {
	global $player;
	$toAdd = array();
	$toAdd['user'] = $player->id;
	$toAdd['date'] = dbDate();
	$toAdd['level'] = $level;
	$toAdd['text'] = $message;
	$sql = SqlCreate( "INSERT", "event_log", $toAdd );
	//qDebug( $sql );
	SqlExec( $sql );
}

function processMapRef( $inputCell ) {
	//qDebug( $inputCell );
	if( $inputCell['ref_id'] == 0 ) {
		return $inputCell;
	}
	else {
		//qDebug( $inputCell );
		$data = SqlExec( "SELECT * FROM mapa WHERE id={$inputCell['ref_id']} LIMIT 1" );
		$data = array_shift( $data -> GetArray() );
		//qDebug( $data );
		//$data['id'] = $inputCell['id'];
		//$data['zm_x'] = $inputCell['zm_x'];
		//$data['zm_y'] = $inputCell['zm_y'];
		//$data['type'] = $inputCell['type'];
		foreach( $inputCell as $k => $v ) {
			if( empty( $v ) ) {
				$inputCell[$k] = $data[$k];
			}
		}
		$inputCell['ref_x'] = $data['zm_x'];
		$inputCell['ref_y'] = $data['zm_y'];
		//$tmp = processMapRef( $data );
		//qDebug( $tmp );
		return $inputCell;
	}
}

?>