<?php
/**
 * Funkcje pliku : <br/>
 *  + dodawanie modu³ów
 *  + usuwanie modu³ów
 *  + zarz¹dzanie modu³ami
 *  + dodawanie/usuwanie plików do modu³ów
 *  + dodawanie/usuwanie modu³ów do sidebarów
 *  + weryfikacjia i aktywacja modu³ów
 * 
 * @name Menad¿er modu³ów
 * @author Ivan
 * @copyright KaraTur-Team 2006-2007
 * @since 15.07.2007
 * @version 0.7
 * @package KaraTur
 */

/**
 * 
 */
require_once( "includes/preinit.php" );

if( !isset( $_GET['action'] ) ) {
  $_GET['action'] = '';
}
if( !isset( $_GET['mode'] ) ) {
	$_GET['mode'] = '';
}

$rankModAdd = getRank( "moduleadd" );
$rankModMod = getRank( "modulemanage" );


/**
 * Parsowanie kodu Ÿród³owego do tokenów.
 * 
 * Parsuje plik za pomoc¹ funkcji tokenizera. Umo¿liwia ³atwe przesuwanie siê
 * po kodzie, eliminuj¹c np. problemy prz pomijaniu elementów typu T_WHITESPACE
 * 
 * @author Ivan
 * @copyright KaraTur-Team 2006-2007
 * @since 24.07.2007
 * @version 0.4
 * @package KaraTur
 *
 */
class TokenParser {
	private $_cur,$_total,$_line;
	private $_src;
	private $_eof;
	function __construct( $source ) {
		$this->_src = token_get_all( $source );
		$this->_cur = 0;
		$this->_line = 1;
		$this->_total = count( $this->_src );
		$this->_eof = false;
	}
	
	
	/**
	 * zwraca obecny element
	 *
	 * @return TokenElement
	 */
	function getCur() {
		//return $this->_src[$this->_cur];
		return new TokenElement( $this, $this->_cur );
	}
	
	
	/**
	 * Zwraca element
	 *
	 * @param int $pos
	 * @return TokenElement
	 */
	function getElement( $pos = -1 ) {
		if ( $pos < 0 ) {
			$pos = $this->_cur;
		}
		return new TokenElement( $this, $pos );
	}
	
	function getCurIndex() {
		return $this->_cur;
	}
	
	function getNode( $pos ) {
		return $this->_src[$pos];
	}
	
	function getLine() {
		return $this->_line;
	}
	
	/**
	 * Przesuwa wewnêtrzny wskaŸnik wprzód
	 *
	 */
	function moveNext() {
		$cur = $this->getCur();
		if( $cur->isTypeOf( array( ";", "{", "}" ) ) ) {
	  	  	//$line++;
	  	  	//continue;
		}
		$toAdd = 0;
		if( $cur->isElement() ) {
			if( $cur->isTypeOf( T_OPEN_TAG ) ) {
		  		$toAdd = 1;
			}
			if( $cur->isTypeOf( array( T_COMMENT, T_WHITESPACE, T_DOC_COMMENT ) ) ) {
				$toAdd = substr_count( $cur->getValue(), "\n" );
			}
		}
		$this->_line += $toAdd;
		$this->_cur++;
		if( $this->_cur == $this->_total ) {
			$this->_eof = true;
		}
	}
	
	/**
	 * zwraca nastepny element
	 *
	 * @return TokenElement
	 */
	function getNext( $start = NULL ) {
		if( $start === NULL ) {
			$start = $this->_cur;
		}
		if( $start > $this->_total - 2 ) {
			return FALSE;
		}
		$index = $start+1;
		$next = $this->_src[$start+1];
		if( is_array( $next ) && $next[0] == T_WHITESPACE ) {
			$next = $this->_src[$start+2];
			$index++;
		}
		//return $next;
		return new TokenElement( $this, $index );
	}
	
	/**
	 * zwraca poprzedni element
	 *
	 * @return TokenElement
	 */
	function getPrev( $start = NULL ) {
		if( $start === NULL ) {
			$start = $this->_cur;
		}
		if( $start < 1 ) {
			return FALSE;
		}
		if( $start > $this->_total ) {
			return FALSE;
		}
		$prev = $this->_src[$start-1];
		$index = $start-1;
		if( is_array( $prev ) && $prev[0] == T_WHITESPACE ) {
			$prev = $this->_src[$start-2];
			$index--;
		}
		//return $prev;
		return new TokenElement( $this, $index );
	}
	
	function isEof() {
		return $this->_eof;
	}
	
}

/**
 * Pojedynczy element zwracany przez {@link TokenParser}.
 * 
 * Pozwala na ³atwie i obiektowe sprawdzanie poszczególnych flag danego elementu
 * 
 * @author Ivan
 * @copyright KaraTur-Team 2006-2007
 * @since 26.07.2007
 * @version 0.2
 * @package KaraTur
 *
 */
class TokenElement {
	private $_parser, $_index;
	
	
	/**
	 * Konstruktor
	 *
	 * @param TokenParser $parser
	 * @param int $index
	 */
	function __construct( TokenParser &$parser, $index ) {
		$this->_parser =& $parser;
		$this->_index = $index;
	}
	
	function getType(){
		$cur = $this->_parser->getNode( $this->_index );
		if( $this->isElement() ) {
			return $cur[0];
		}
		return FALSE;
	}
	
	function getTypeName() {
		$cur = $this->getType();
		if( $cur ) {
			return token_name( $cur );
		}
		return FALSE;
	}
	
	/**
	 * Zwraca wartosc elementu
	 *
	 * @return string
	 */
	function getValue() {
		$cur = $this->_parser->getNode( $this->_index );
		if( $this->isElement() ) {
			return $cur[1];
		}
		return $cur;
	}
	
	function getIndex() {
		return $this->_index;
	}
	
	function isElement() {
		$node = $this->_parser->getNode( $this->_index );
		if( is_array( $node ) ) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function isTypeOf( $type ) {
		$item = $this->_parser->getNode( $this->_index );
		if( is_array( $type ) ) {
			if( in_array( $item, $type ) ) {
				return TRUE;
			}
		}
		else {
			if( $item == $type ) {
				return TRUE;
			}
		}
		if( is_array( $type ) ) {
			if( is_array( $item ) && in_array( $item[0], $type ) ) {
				return TRUE;
			}
		}
		else {
			if( is_array( $item ) && $item[0] == $type ) {
				return TRUE;
			}
		}
		return FALSE;
	}
	
	function isFunction( ) {
		if( !$this->isElement() ) {
			return false;
		}
		if( !$this->isTypeOf( T_STRING ) ) {
			return FALSE;
		}
		$next = $this->_parser->getNext();
		$prev = $this->_parser->getPrev();
		if( !$next->isTypeOf( "(" ) ) {
			return FALSE;
		}
		if( !$prev->isElement() ) {
			return TRUE;
		}
		if( $prev->isTypeOf( T_OBJECT_OPERATOR ) ) {
			return FALSE;
		}
		return TRUE;
	}
	
	function isObjectVar( $pos = NULL ) {
		if( !$this->isElement() ) {
			return false;
		}
		if( !$this->isTypeOf( T_STRING ) ) {
			return FALSE;
		}
		$next = $this->_parser->getNext();
		$prev = $this->_parser->getPrev();
		
		if( !$prev->isElement() ) {
			return FALSE;
		}
		if( !$prev->isTypeOf( T_OBJECT_OPERATOR ) ) {
			return FALSE;
		}
		if( $next->isTypeOf( "(" ) ) {
			return FALSE;
		}
		return TRUE;
	}
	
	function isObjectMethod( $pos = NULL ) {
		if( !$this->isElement() ) {
			return false;
		}
		if( !$this->isTypeOf( T_STRING ) ) {
			return FALSE;
		}
		$next = $this->_parser->getNext();
		$prev = $this->_parser->getPrev();
		
		if( !$next->isTypeOf( "(" ) ) {
			return FALSE;
		}
		if( !$prev->isElement() ) {
			return FALSE;
		}
		if( $prev->isTypeOf( T_OBJECT_OPERATOR ) ) {
			return true;
		}
		return FALSE;
	}
	
}

/**
* @desc Przeszukuje podany katalog w poszukiwaniu plikow a danym rozszerzeniu
* @author IvaN
* 
* @param string $path Sciezka
* @param string $ext rozszerzenie
*/
function searchDir( $path, $ext ) {
	if( ! is_dir( $path ) ) {
		return FALSE;
	}
	$ret = array();
	$dir = opendir( $path );
	while( ( $file = readdir( $dir ) ) !== FALSE ) {
		if( is_file( $path . $file ) ) {
			if( $ext == "*" ) {
				$ret[] = $file;
			}
			else {
				$tmp = explode( ".", $file );
				if( $tmp[ count($tmp)-1 ] == $ext ) {
					//echo( "$file<br/>");
					$ret[] = $file;
				}
			}
		}
	}
	return $ret;
}

function isPhpFile( $filename ) {
	$source = file_get_contents( $filename );
	$tokens = token_get_all( $source );
	$hasOpenTag = false;
	$hasCloseTag = false;
	foreach( $tokens as $token ) {
		if( is_array( $token ) ) {
			if( $token[0] === T_OPEN_TAG ) {
				$hasOpenTag = true;
			}
			if( $token[0] === T_CLOSE_TAG ) {
				$hasCloseTag = true;
			}
		}
	}
	return $hasOpenTag || $hasCloseTag;
}

function validateFile( $file, $type ) {
	$ret = true;
	//debug_print_backtrace();
	switch( $type ) {
		case 'main' :
		case 'inc' :
			$mimeTypes = array( 'text/plain', 'application/octet-stream' );
			if( !in_array( $file['type'], $mimeTypes ) ) {
				$ret = false;
				break;
			}
			$fileString = file_get_contents( $file['tmp_name'] );
			
			$bannedVarRegs = array( "/\\\$\\\$\\w+/", "/\\\$__[\\w]+/" );
			$bannedTokens = array( T_REQUIRE, T_REQUIRE_ONCE, T_INCLUDE, T_INCLUDE_ONCE, T_EVAL, T_GLOBAL );
			$bannedFunctions = array( "copy", "chgrp", "chmod", "chown", "file_put_contents", "file_get_contents", "file", "fopen", "mkdir", "move_uploaded_file", "popen", "readfile", "rename", "rmdir", "symlink", "tempnam", "tmpfile", "unlink",
									"create_function", "call_user_func", "call_user_func_array",
									"imagegd2", "imagegd", "imagegif", "imagejpeg", "imagepng", "imagewbmp", "image2wbpm", "imagexbm",
									"highlight_file", "show_source",
									"passthru", "proc_open", "shell_exec", "system" );
			$smartySafeValues = array( "assign", "display", "assign_by_ref", "\$debugging", "\$force_compile" );

			$tok = new TokenParser( $fileString );
			$codeErrors = array();
			while( !$tok->isEof() ) {
				$cur = $tok->getCur();
				$line = $tok->getLine();
				$pos = $tok->getCurIndex();
				$next = $tok->getNext();
				$prev = $tok->getPrev();
				
				if( $cur->isTypeOf( $bannedTokens ) ) {
					$codeErrors[]= "Zabroniony znacznik `{$cur->getValue()}` (linia $line)";
				}
				
				if( $cur->isTypeOf( T_VARIABLE ) ) {
					if( $prev->isTypeOf( "\$")) {
						$codeErrors[]= "Zmienne zmienne (linia $line)";
					}
					if( $next->isTypeOf( "\$" ) ) {
						$codeErrors[]= "Zmienna funkcja (linia $line)";
					}
					if( preg_match( "/\\\$__[\\w]+/", $cur->getValue() ) > 0 ) {
						$codeErrors[]= "Uzycie zmiennych typu `\$__` (linia $line)";
					}
					if( $cur->getValue() == "\$smarty" && $next->isTypeOf( T_OBJECT_OPERATOR ) ) {
						$tnext = $tok->getNext( $next->getIndex() );
						if( !in_array( $tnext->getValue(), $smartySafeValues ) ) {
							$codeErrors[]= "Manipulacja opcjami smary'ego (linia $line)";
						}
					}
					if( $cur->getValue() == "\$GLOBALS" ) {
						$codeErrors[] = "Odwolanie do tablicy \$GLOBALS (linia $line)";
					}
				}
				
				if( $cur->isFunction() ) {
					if( in_array( $cur->getValue(), $bannedFunctions ) ) {
						$codeErrors[]= "Zabroniona funkcja `{$cur->getValue()}` (linia $line)";
					}
				}
				
				if( $cur->isTypeOf( "=" ) ) {
					if( $next->isTypeOf( T_VARIABLE ) && $next->getValue() == "\$smarty" ) {
						$codeErrors[]= "Manipulacja smartym (linia $line)";
					}
					if( $prev->isTypeOf( T_VARIABLE ) && $prev->getValue() == "\$smarty" ) {
						$codeErrors[]= "Manipulacja smartym (linia $line)";
					}
				}
				
				$tok->moveNext();
			}
			if( !empty( $codeErrors) ) {
				$errMsg = implode( "</li><li>", $codeErrors );
				trigger_error( "Twoj plik zawiera nastepujace zabronione fragmenty kodu : <ul><li>$errMsg</li></ul>", E_USER_WARNING );
				$ret = false;
			}
			//qDebug( $tokens );
			
			if( $ret == true ) {
				exec( "php -l {$file['tmp_name']}", $hmm, $code );
				//qDebug( print_r( $hmm, true ) );
				//qDebug( print_r( $code, true ) );
				if( $code > 1 ) {
					//$hmm = str_replace( $file['tmp_name'], $file['name'], $hmm );
					trigger_error( "Ten plik ma niepoprawna skladnie ! ($code)<br/>Komunikaty : <br/><div style='padding-left:15px'>".implode( "<br/>\n", $hmm )."</div>", E_USER_WARNING );
					$ret = false;
				}
			}
			break;
		case 'img' :
			if( isPhpFile( $file['tmp_name'] ) ) {
				trigger_error( "Ten plik jest plikiem php !", E_USER_WARNING );
				$ret = false;
			}
			break;
		case 'tpl' :
			if( isPhpFile( $file['tmp_name'] ) ) {
				trigger_error( "Ten plik jest plikiem php !", E_USER_WARNING );
				$ret = false;
			}
			break;
		case 'data' :
			if( isPhpFile( $file['tmp_name'] ) ) {
				trigger_error( "Ten plik jest plikiem php !", E_USER_WARNING );
				$ret = false;
			}
			break;
		default :
			break;
	}
	return $ret;
}

function getLastModTime( $path, $dirs = array( ".", "img", "tpl", "data", "inc" ) ) {
	$mTime = array( 'time' => 0, 'file'=>'' );
	foreach( $dirs as $subdir ) {
		$tPath = $path . "/" . $subdir . "/";
		if( is_dir( $tPath ) ) {
			$dir = opendir( $tPath );
			while( ( $file = readdir( $dir ) ) !== FALSE ) {
				if( is_file( $tPath . $file ) && !in_array( $file, array( ".", ".." ) ) ) {
					//echo "$file</br>";
					$tmp = max( $mTime['time'], filemtime( $tPath . $file ) );
					if( $tmp > $mTime['time'] ) {
						$mTime['time'] = $tmp;
						$mTime['file'] = $file;
					}
				}
			}
		}
	}
	return $mTime;
}

function moduleActiveCmp( $a, $b ) {
	if( $a['position'] > $b['position'] ) {
		return 1;
	}
	else {
		return -1;
	}
	return 0;
}

if( $_GET['action'] == 'watch' && !empty( $_GET['mode'] ) ) {
	$__runTestModule = array( 'mid' => $_GET['mid'], 'mode' => $_GET['mode'] );
}

$title = "Menadzer modulow";
makeHeader();

$smarty->force_compile = true;

if( !( $rankModAdd || $rankModMod ) ) {
		error( "Nie mozesz zarzadzac modami !" );
	}

if( $_GET['action'] == '' ) {
  $modules = SqlExec( "SELECT m.*, p.user, IF( ma.mod_id, 1, 0 ) AS active FROM modules m LEFT JOIN players p ON p.id=m.owner LEFT JOIN modulesActive ma ON ma.mod_id=m.id" );
  $modules = $modules->GetArray();
  foreach( $modules as $k => $m ) {
  	  $modules[$k]['valid'] = (int)testModule( $m['name'], true );
  }
 
	$smarty->assign( "Modules", $modules );
}

if( $_GET['action'] == 'manage' ) {
	if( !( $rankModAdd || $rankModMod ) ) {
		error( "Nie mozesz zarzadzac modami !" );
	}
  if( empty( $_GET['mid'] ) ) {
    error( "Nieprawidlowy modul !" );
  }
  $mid = $_GET['mid'];
  $module = SqlExec( "SELECT m.*, p.user, IF( ma.mod_id, 1, 0 ) AS active, ma.position, ma.where FROM modules m LEFT JOIN players p ON p.id=m.owner LEFT JOIN modulesActive ma ON ma.mod_id=m.id where m.id=$mid" );
  $module = $module->GetArray();
  if( empty( $module ) ) {
		error( "Nie ma takiego modulu !" );
	}
	//qDebug( $module );
	$module = array_shift( $module );
	if( $module['owner'] != $player->id ) {
		//error( "Nie jestes wlascicielem i nie mozesz zarzadzac tym modulem !" );
	}
	$where = '';
	switch( $module['where'] ) {
		case 'sidebar_left' :
			$where = "Lewy sidebar";
			break;
		case 'sidebar_right' :
			$where = "Prawy sidebar";
			break;
		case 'page' :
			$where = "Osobna strona";
			break;
	}
	$module['where_trans'] = $where;
	switch( $module['type'] ) {
		case 'sidebar' :
			$where = "Sidebar";
			break;
		case 'page' :
			$where = "Osobna strona";
			break;
	}
	$module['type_trans'] = $where;
	$module['date'] = date( "H:i, d-m-Y", $module['date'] );
	$modDir = "modules/{$module['name']}/";
	$modTplDir = $modDir . "tpl/";
	$modImgDir = $modDir . "img/";
	$modIncDir = $modDir . "inc/";
	$modDataDir = $modDir . "data/";
    if( file_exists( $modDir . "main.php" ) ) {
    	$f['main'] = 1;
	}
	else {
		$f['main'] = 0;
	}
	$f['tpl'] = searchDir( $modTplDir, "tpl" );
	$f['inc'] = searchDir( $modIncDir, "php" );
	$f['img'] = searchDir( $modImgDir, "*" );
	$f['data'] = searchDir( $modDataDir, "*" );
	$mTime = getLastModTime( $modDir );
	if( $mTime > 0 ) {
		$module['mtime'] = date( "H:i, d-m-Y", $mTime['time'] );
	}
	else {
		$module['mtime'] = $mTime['time'];
	}
	$module['mfile'] = $mTime['file'];
	//qDebug( $module );
	$module['files'] = $f;
	$module['resets'] = file_exists( $modIncDir."KT.reset.inc.php" );
	$smarty->assign( array( "Mod" => $module, "Mid" => $mid ) );
}

if( $_GET['action'] == 'addchange' ) {
	if( empty( $_GET['mid'] ) ) {
		error( "Nieprawidlowy modul !" );
	}
	$mid = $_GET['mid'];
	$module = SqlExec( "SELECT * FROM modules WHERE id=$mid" );
	$module = $module->GetArray();
 	if( empty( $module ) ) {
		error( "Nie ma takiego modulu !" );
	}
	$module = array_shift( $module );
	$allow = false;
	if( ( $rankModAdd && $module['owner'] == $player->id ) || $rankModMod ) {
		$allow = true;
	}
	if( !$allow ) {
		error( "Nie jestes wlascicielem i nie mozesz zarzadzac tym modulem !" );
	}
	$smarty->assign( "Mod", $module );
	
	if( !empty( $_POST ) ) {
		qDebug( $_POST );
		if( !empty( $_POST['date-now'] ) ) {
			$date = date( "Y-m-d", time() );
		}
		else {
			if( empty( $_POST['date'] ) ) {
				error( "Podaj date !", 'error', "?view=add" );
			}
			$date = $_POST['date'];
			$test = strtotime( $date );
			$month = date( "m", $test );
			$day = date( "d", $test );
			$year = date( "Y", $test );
			if( !checkdate( $month, $day, $year ) ) {
				error( "Nieprawidlowa data !", 'error', "?view=add" );
			}
		}
		$toAdd['date'] = $date;
		$toAdd['owner'] = $player->id;
		$toAdd['type'] = 'module';
		$toAdd['meta'] = $mid;
		foreach( $_POST['change'] as $item ) {
			$toAdd['body'] = $item;
			$sql = SqlCreate( "INSERT", "changelog", $toAdd );
			//qDebug( $sql );
			SqlExec( $sql, true );
		}
		$total = count( $_POST['change'] );
		error( "Dodano $total zmian do modulu <b>{$module['title']}</b> w dniu $date", 'done', "?action=manage&mid=$mid" );
	}
}

if( $_GET['action'] == 'addfile' ) {
	if( empty( $_GET['mid'] ) ) {
    error( "Nieprawidlowy modul !" );
  }
  $mid = $_GET['mid'];
  $module = SqlExec( "SELECT * FROM modules WHERE id=$mid" );
  $module = $module->GetArray();
  if( empty( $module ) ) {
		error( "Nie ma takiego modulu !" );
	}
	$module = array_shift( $module );
	$allow = false;
	if( ( $rankModAdd && $module['owner'] == $player->id ) || $rankModMod ) {
		$allow = true;
	}
	if( !$allow ) {
		error( "Nie jestes wlascicielem i nie mozesz zarzadzac tym modulem !" );
	}
	$smarty->assign( array( "Mod" => $module, "Mid" => $mid ) );
	//qDebug( print_r( $_POST, true ) );
	//qDebug( print_r( $_FILES, true ) );
	if( !empty( $_POST ) ) {
		$fileType =& $_POST['file']['type'];
		$file =& $_FILES['file'];
		if( empty( $fileType ) ) {
			error( "Nieprawidlowa akcja !", 'error', "?action=addfile&mid={$mid}" );
		}
		if( empty( $file ) ) {
			error( "Nieprawidlowa akcja !", 'error', "?action=addfile&mid={$mid}" );
		}
		if( !validateFile( $file, $fileType ) ) {
			error( "Plik jest nieprawidlowy i nie moze zostac zaladowany na server !", 'error', "?action=addfile&mid={$mid}" );
		}
		if( $fileType == 'main' ) {
			$file['name'] = 'main.php';
		}
		$modDir = "modules/{$module['name']}/";
		$modTplDir = $modDir . "tpl/";
		$modImgDir = $modDir . "img/";
		$modIncDir = $modDir . "inc/";
		$modDataDir = $modDir . "data/";
		switch( $fileType ) {
			case 'main' :
				$dest = $modDir;
				break;
			case 'tpl' :
				$dest = $modTplDir;
				break;
			case 'inc' :
				$dest = $modIncDir;
				break;
			case 'img' :
				$dest = $modImgDir;
				break;
			case 'data' :
				$dest = $modDataDir;
				break;
		}
		SqlExec( "UPDATE modules SET `checked`=0 WHERE id={$module['id']}", true );
		if( move_uploaded_file( $file['tmp_name'], $dest . $file['name']) !== true ) {
			error( "Blad podczas przenoszenia pliku !", 'error', "?action=addfile&mid={$mid}" );
		}
		error( "Plik zaladowany !", 'done', "?action=manage&mid={$mid}" );
	}
}

if( $_GET['action'] == 'add' ) {
	if( !empty( $_POST ) ) {
		//qDebug( print_r( $_POST, true ) );
		$name =& $_POST['name'];
		$author =& $_POST['author'];
		$desc =& $_POST['desc'];
		$type =& $_POST['type'];
		if( !isset( $_POST['rights'] ) ) {
			error( "Musisz wyrazic zgode na przejecie wlasnosci modulu !", 'error', "?action=add" );
		}
		if( !isset( $name ) ) {
			error( "Podaj nazwe modulu !", 'error', '?action=add' );
		}
		if( preg_match( "/^[\\w-]+\$/", $name, $arr ) == 0 ) {
			//qDebug( print_r( $arr, TRUE ) );
			error( "Nazwa zawiera nieprawidlowe znaki !", 'error', '?action=add' );
		}
		if( !isset( $desc ) ) {
			error( "Podaj opis modulu !", 'error', '?action=add' );
		}
		$modDir = "modules/$name";
		$modDataDir = "$modDir/data";
		$modImgDir = "$modDir/img";
		$modIncDir = "$modDir/inc";
		$modTplDir = "$modDir/tpl";
		$modTplCDir = "$modDir/tpl_c";
//		mkdir( $modDir );
//		mkdir( $modDataDir );
//		mkdir( $modImgDir );
//		mkdir( $modIncDir );
//		mkdir( $modTplDir );
//		mkdir( $modTplCDir );
		
		$sql = SqlCreate( 'INSERT', 'modules', array( 'name'=>$name, 'author'=>$author, 'desc'=>$desc, 'owner'=>$player->id, 'type'=>$type, 'date'=>time(), 'md5hash'=>'', 'resetHour' => '', 'resetDay' => '' ) );
		qDebug( $sql );
		//SqlExec( $sql );
		error( "Modul dodany !", 'done' );
	}
}

if( $_GET['action'] == 'watch' ) {
	if( !empty( $_GET['mode'] ) ) {
		echo "<br/><br/>Podglad modulu znajdujacego sie w sidebarze ...<br/><br/><a href='?'>Wroc</a> do strony z modulami<br/><br/>";
	}
	else {
		$modName = SqlExec( "SELECT `name` FROM modules WHERE id={$_GET['mid']}" );
		$modName = $modName -> fields['name'];
		runModule( $modName, TRUE );
		echo "<a href=\"?\">Wroc</a> do strony glownej";
	}
}

if( $_GET['action'] == 'activate' ) {
	if( !$rankModMod ) {
		error( "Nie mozesz aktywowac modulow!" );
	}
	$mid =& $_GET['mid'];
	$mod = SqlExec( "SELECT * FROM modules WHERE id='$mid'" );
	if( !$mod->fields['id'] ) {
		error( "Nie istnieje taki modul !" );
	}
	$mod = array_shift( $mod->GetArray() );
	
	if( $mod['type'] == 'page' ) {
		error( "Modul aktywowany !", 'done' );
	}
	if( $mod['type'] == 'sidebar' ) {
		if( !empty( $_POST ) ) {
			$side =& $_POST['side'];
			if( empty( $side ) ) {
				error( "Wybierz sidebar do ktorego chcesz dodac modul !", 'error', "?action=activate&mid={$mod['id']}" );
			}
			$pos = SqlExec( "SELECT position FROM modulesActive WHERE `where`='sidebar_$side'" );
			$pos = $pos -> GetArray();
			//if( empty( $pos ) ) {
			//	$pos = 1;
			//}
			//else {
			//	$pos = max( $pos );
			//}
			$pos = count( $pos ) + 1;
			SqlExec( SqlCreate( "INSERT", "modulesActive", array( 'mod_id'=>$mod['id'], 'where'=>"sidebar_$side", 'position'=>$pos) ), true );
			//qDebug( print_r( $pos, true ) );
			//echo "|" . max( $pos ) . "|";
			error( "Modul aktywowany !", 'done' );
		}
	}
	$smarty->assign( "Mod", $mod );
}

if( $_GET['action'] == 'manageActive' ) {
	if( !$rankModMod ) {
		error( "Nie mozesz zarzadzac aktywnymi modulami!" );
	}
	if( isset( $_GET['move'] ) ) {
		//$side = SqlExec( "SELECT ma.where, ma.position, m.* FROM modulesActive ma LEFT JOIN modules m ON ma.mod_id = m.id WHERE ma.where='sidebar_{$_GET['move']}'" );
		$side = SqlExec( "SELECT * FROM modulesActive ma WHERE ma.where='sidebar_{$_GET['move']}'" );
		$side = $side -> GetArray();
		switch( $_GET['dir'] ) {
			case 'up' :
				$offset = -1;
				break;
			case 'down' :
				$offset = 1;
				break;
			default :
				error( "Nieprawidlowe zadanie !", 'error', "?action=manageAcive" );
				break;
		}
		$toMove = NULL;
		foreach( $side as $m ) {
			if( $m['mod_id'] == $_GET['mid'] ) {
				$toMove = $m;
				break;
			}
		}
		$toSwap = NULL;
		foreach( $side as $m ) {
			if( $m['position'] == $toMove['position'] + $offset ) {
				$toSwap = $m;
				break;
			}
		}
		if( !empty( $toMove ) && !empty( $toSwap ) ) {
			$toMove['position'] += $offset;
			$toSwap['position'] -= $offset;
			$sql1 = "UPDATE modulesActive SET position={$toMove['position']} WHERE mod_id={$toMove['mod_id']}";
			$sql2 = "UPDATE modulesActive SET position={$toSwap['position']} WHERE mod_id={$toSwap['mod_id']}";
			SqlExec( $sql1, true );
			SqlExec( $sql2, true );
		}
		//$posToFind = 
		//qDebug( print_r( $toMove, true ) );
		//qDebug( print_r( $toSwap, true ) );
	}
	if( isset( $_GET['del'] ) ) {
		$toDel = SqlExec( "SELECT * FROM modulesActive WHERE mod_id={$_GET['del']}" );
		if( !$toDel->fields['mod_id'] ) {
			error( "Nieprawidlowe zadanie !", 'error', "?action=manageActive" );
		}
		$toDel = array_shift( $toDel->GetArray() );
		//qDebug( print_r( $toDel, true ) );
		$toMove = SqlExec( "SELECT * FROM modulesActive WHERE `where` = '{$toDel['where']}' AND position > {$toDel['position']} ORDER BY position" );
		$toMove = $toMove -> GetArray();
		//qDebug( $toMove );
		SqlExec( "DELETE FROM modulesActive WHERE mod_id = {$toDel['mod_id']}" );
		foreach( $toMove as $widget ) {
			$widget['position']--;
			SqlExec( "UPDATE modulesActive SET position={$widget['position']} WHERE mod_id={$widget['mod_id']}" );
		}
	}
	$active = SqlExec( "SELECT ma.where, ma.position, m.* FROM modulesActive ma LEFT JOIN modules m ON ma.mod_id = m.id" );
	$active = $active -> GetArray();
	$widgets = array( 'sidebar_left' => array(), 'page'=>array(), 'sidebar_right'=>array() );
	foreach( $active as $mod ) {
		$widgets[$mod['where']][] = $mod;
	}
	foreach( $widgets as $k=>$w ) {
		usort( $w, "moduleActiveCmp" );
		$widgets[$k] = $w;
	}
	//qDebug( print_r( $widgets, true ) );
	$smarty->assign( "Widgets", $widgets );
}

if( $_GET['action'] == 'validate' ) {
	if( !$rankModMod ) {
		error( "Nie mozesz weryfikowac modulow!" );
	}
	$mid =& $_GET['mid'];
	$mod = SqlExec( "SELECT * FROM modules WHERE id='$mid'" );
	if( !$mod->fields['id'] ) {
		error( "Nie istnieje taki modul !" );
	}
	$mod = array_shift( $mod->GetArray() );
	if( !testModule( $mod['name'], true ) ) {
		error( "Nie mozesz zaakceptowac modulu niekompletnego !" );
	}
	$smarty->assign( "Mod", $mod );
	if( !empty( $_POST ) ) {
		//qDebug( print_r( $_POST, true ) );
		if( !empty( $_POST['next'] ) ) {
			SqlExec( "UPDATE modules SET `checked`='1' WHERE id={$mod['id']}" );
			error( "Modul <b>{$mod['name']}</b> zweryfikowany jako poprawny", 'done' );
		}
	}
}

if( $_GET['action'] == 'delfile' ) {
	$mid =& $_GET['mid'];
	$file =& $_GET['file'];
	if( !isset( $_GET['mid'] ) || !isset( $_GET['file'] ) ) {
		error( "Nieprawidlowe ¿¹danie !" );
	}
	$mod = SqlExec( "SELECT * FROM modules WHERE id='$mid'" );
	if( !$mod->fields['id'] ) {
		error( "Nie istnieje taki modul !" );
	}
	$mod = array_shift( $mod->GetArray() );
	if( ( $rankModAdd && $player->id==$mod['owner'] ) || $rankModMod ) {
		$dir = array_shift( explode( "/", $file ) );
		$filename = "modules/{$mod['name']}/{$file}";
		$allowedPath = pathinfo( realpath( $_SERVER['SCRIPT_FILENAME'] ) );
		$allowedPath = $allowedPath['dirname']. "\\modules\\{$mod['name']}\\";
		//qDebug( $dir );
		//qDebug( realpath( $filename ) );
		if( stripos( realpath( $filename ), $allowedPath ) === FALSE ) {
			error( "Zabroniona sciezka !", 'error', "?action=manage&mid={$mod['id']}" );
		}
		if ( file_exists($filename) ) {
			//qDebug( "unlink( $filename );");
			unlink( $filename );
			error( "Plik <b>$file</b> usuniêty !", 'done', "?action=manage&mid={$mod['id']}" );
		}
		else {
			error( "Taki plik nie istnieje !", 'error', "?action=manage&mid={$mod['id']}" );
		}
	}
	else {
		error( "Nie mozesz usuwac plikow z tego modulu !" );
	}
}

if( $_GET['action'] == 'delete' ) {
	if( !$rankModMod ) {
		error( "Nie mozesz usuwaæ modulow!" );
	}
	$mid =& $_GET['mid'];
	$mod = SqlExec( "SELECT * FROM modules WHERE id='$mid'" );
	if( !$mod->fields['id'] ) {
		error( "Nie istnieje taki modul !" );
	}
	$mod = array_shift( $mod->GetArray() );

	$active = SqlExec( "SELECT position FROM modulesActive WHERE mod_id={$mod['id']}" );
	if( $active->fields['position'] ) {
		error( "Nie mozesz usunac modulu ktory jest aktywowany w sidebarze. Usun modu³ najpierw z panelu !" );
	}
	$smarty->assign( "Mod", $mod );
	if( !empty( $_POST ) ) {
		//qDebug( print_r( $_POST, true ) );
		if( !empty( $_POST['next'] ) ) {
			//SqlExec( "UPDATE modules SET `checked`='1' WHERE id={$mod['id']}" );
			$modDir = "modules/{$mod['name']}/";
			$files = scandir( $modDir );
			$toDel = array();
			foreach( $files as $file ) {
				if( in_array( $file, array( '.', '..' ) ) ) {
					continue;
				}
				if( is_dir( $modDir . $file ) ) {
					//$files[] = 
					$tmp = scandir( $modDir . $file . "/" );
					foreach( $tmp as $item ) {
						if( in_array( $item, array( '.', '..' ) ) ) {
							continue;
						}
						$toDel[] = $file . "/" . $item;
					}
				}
				else {
					$toDel[] = $file;
				}
			}
			foreach( $toDel as $file ) {
				//echo $modDir . $file."<br/>";
				unlink( $modDir . $file );
			}
			unlink( $modDir . 'img' );
			unlink( $modDir . 'inc' );
			unlink( $modDir . 'data' );
			unlink( $modDir . 'tpl' );
			unlink( $modDir . 'tpl_c' );
			unlink( $modDir );
			SqlExec( "DELETE FROM modulesData WHERE mid={$mod['id']}" );
			SqlExec( "DELETE FROM modules WHERE id={$mod['id']}" );
			error( "Modul <b>{$mod['name']}</b> zosta³ poprawnie usuniêty !", 'done' );
		}
	}
}



$smarty->assign( array( "Action" => $_GET['action'], "Rank_add" => $rankModAdd, "Rank_mod" => $rankModMod ) );
$smarty->display( "modulesManager.tpl" );

require_once( "includes/foot.php" );

?>