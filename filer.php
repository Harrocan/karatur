<?php

require_once( "includes/preinit.php" );


if( strpos($_SERVER['SERVER_SOFTWARE'], "Win32" ) !== FALSE ) {
	define( "SERVER_OS", "win" );
}
else {
	define( "SERVER_OS", "unix" );
}

if( !isset( $_GET['orderby'] ) ) {
	$_GET['orderby'] = 'name';
}
if( !isset( $_GET['orderdir'] ) ) {
	$_GET['orderdir'] = 'asc';
}

function fixTrailSlash( $path ) {
	if( !in_array( $path{strlen($path)-1}, array( "/", "\\" ) ) ) {
		if( SERVER_OS == 'unix' ) {
			$path .= "/";
		}
		else {
			$path .= "\\";
		}
	}
	return $path;
}

define( "KT_ROOT_DIR", fixTrailSlash( realpath( "." ) ) );

function dir_name_cmp( $a, $b ) {
	$ret = 0;
	$t = array( 'file' => 2, 'dir' => 1 );
	if( $a['filetype'] == $b['filetype'] ) {
		$ret = strcmp( $a['name'], $b['name'] );
	}
	else {
		$ret = $t[$a['filetype']] - $t[$b['filetype']];
	}
	
	if( $_GET['orderdir'] == 'desc' ) {
		$ret = -$ret;
	}
	
	return $ret;
}
function dir_ext_cmp( $a, $b ) {
	$ret = 0;
	$t = array( 'file' => 2, 'dir' => 1 );
	if( $a['filetype'] == $b['filetype'] ) {
		if( $a['filetype'] == 'dir' ) {
			$ret = strcmp( $a['name'], $b['name'] );
		}
		else {
			if( $a['ext'] == $b['ext'] ) {
				$ret = strcmp( $a['name'], $b['name'] );
			}
			else {
				$ret = strcmp( $a['ext'], $b['ext'] );
			}
		}
	}
	else {
		$ret = $t[$a['filetype']] - $t[$b['filetype']];
	}
	
	if( $_GET['orderdir'] == 'desc' ) {
		$ret = -$ret;
	}
	
	return $ret;
}

function getDirListing( $path ) {
	if( !is_dir( $path ) ) {
		trigger_error( "Podana ¶cie¿ka <b>$path</b> nie jest katalogiem !" );
	}
	$path = fixTrailSlash( $path );
	$itemArray = array();
	//$dirList = array();
	//$fileList = array();
	$h_dir = opendir( $path );
	while( ( $item = readdir( $h_dir ) ) !== FALSE ) {
		$fullPath = $path . $item;
		//echo $item . " dir:". is_dir( $fullPath )."<br/>";
		$tmp = array();
		$tmp['name'] = $item;
		$tmp['filetype'] = filetype( $fullPath );
		$tmp['writable'] = is_writable( $fullPath );
		if( $tmp['filetype'] == 'file' ) {
			$tmp['ext'] = pathinfo( $fullPath, PATHINFO_EXTENSION );
			$tmp['size'] = filesize( $fullPath );
		}
		$itemArray[] = $tmp;
		
		//switch( $tmp['filetype'] ) {
		//	case 'dir' :
		//		$dirList[] = $tmp;
		//		break;
		//	case 'file' :
		//		$tmp['ext'] = pathinfo( $fullPath, PATHINFO_EXTENSION );
		//		$fileList[] = $tmp;
		//}
	}
	
	//usort( $itemArray, "dircmp" );
	return $itemArray;
}

$sfd =& $_SESSION['KT_FilerData'];

if( isset( $_GET['getfile'] ) ) {
	$filename = $sfd['dir'] . $_GET['getfile'];
	if( is_file( realpath( $filename ) ) && stripos( realpath( $filename ), KT_ROOT_DIR) === 0 ) {
		$toAdd['file'] = $_GET['getfile'];
		$toAdd['dir'] = addslashes( $sfd['dir'] );
		$toAdd['action'] = 'get';
		$toAdd['user'] = $player->id;
		$toAdd['date'] = dbDate( time() );
		SqlExec( SqlCreate( "INSERT", "fm_history", $toAdd ) );
		$db->Close();
		//header("Content-type: " . mime_content_type( $sfd['dir'] . $_GET['getfile'] ) );
		header("Content-Disposition: attachment; filename=\"{$_GET['getfile']}\"");
		header("Content-Length: " . filesize($filename));
		readfile( $filename );
		exit;
	}
}

$title = "Manager Plików";
makeHeader();

if( !getRank( 'filer' ) ) {
	error( "Nie masz prawa tutaj przebywaæ !" );
}

if( !isset( $sfd ) ) {
	$sfd['dir'] = KT_ROOT_DIR;
	qDebug( "Setting new sess data !" );
}

if( isset( $_GET['getfile'] ) ) {
	showInfo( "Nast±pi³ b³ad podczas wysy³ania pliku !", 'error' );
}
//qDebug( $GLOBALS );
//$f = htmlentities( file_get_contents( "c:\\htdocs\\KaraTur\\test.txt" ) );
//if( $f === FALSE ) {
//	qDebug( "ooops !");
//}
//else {
//	qDebug( $f );
//	if( preg_match( "/\/\*\-\-\*([^\/]*)/", $f, $matches ) > 0 ) {
//		$sign = $matches[0] . "/";
//		qDebug( $sign );
//		$signData = parseKTSignature( $sign );
//		
//	}
//}

function validateKTFile( &$fstring, $signatureData ) {
	$sig = md5( sprintf("%u",crc32( $fstring ) ) );
	if( $sig != $signatureData['sig'] ) {
		return FALSE;
	}
	$sum = md5( $fstring );
	if( $sum != $signatureData['sum'] ) {
		return FALSE;
	}
}

function parseKTSignature( $data ) {
	$arr = explode( "\n", $data );
	$needed = array( 'ver', 'auth', 'time', 'sig', 'sum', 'sigv' );
	qDebug( $arr );
	$vals = array();
	foreach( $arr as $line ) {
		if( preg_match( "/^\*\*@(".implode("|",$needed)."): ([\w.]*)/", $line, $match ) ) {
			$vals[$match[1]] = $match[2];
			//qDebug( $match );
		}
	}
	qDebug( $vals );
	foreach( $needed as $n ) {
		if( empty( $vals[$n] ) ) {
			qDebug( "Signature incomplete ! ($n)" );
			return FALSE;
		}
	}
	
	return $vals;
	//$sig = md5( sprintf("%u",crc32( $data ) ) );
	//if( $sig != $vals['sig'] ) {
	//	qDebug( "Signature mailformed !" );
	//}
}
//function finsert( $fp, $pos, $string ) {
//	qDebug( "Adding `$string` info fp at $pos" );
//	$oldpos = ftell( $fp );
//	if( fseek( $fp, 0, SEEK_END ) ) {
//		qDebug( "kicha !" );
//	}
//	
//	$endval = ftell( $fp );
//	qDebug( "Total length : $endval" );
//	fseek( $fp, 0 );
//	qDebug( fread( $fp, $endval ) );
//	if( fseek( $fp, 0 ) !== 0 ) {
//		qDebug( "shit" );
//	}
//	$before = fread( $fp, $pos );
//	if( !$before === FALSE ) {
//		qDebug( "oops !" );
//	}
//	$after = fread( $fp, $endval );
//	qDebug( "$before . $string . $after" );
//	fseek( $fp, $oldpos, SEEK_SET );
//}
//
//$fp = fopen( "test.txt", "r" );
//while ( ! feof( $fp ) ) {
//	$pos = ftell( $fp );
//	$line = htmlentities( fgets( $fp ) );
//	if( preg_match( "/^\/\/@ver:/", $line ) ) {
//		qDebug( "Found at $pos !" );
//		finsert( $fp, $pos, "yoo bitches" );
//	}
//	else {
//		qDebug( "$pos :: $line" );
//	}
//	
//}
//fseek( $fp, 24, SEEK_SET );
//fputs( $fp, "test da bitch\n" );
//fclose( $fp );

if( isset( $_GET['del'] ) ) {
	$delFile = realpath( $sfd['dir'] . $_GET['del'] );
	if( !is_file( $delFile ) || stripos( $delFile, KT_ROOT_DIR) !== 0 ) {
		error( "Nieprawid³owy plik !" );
	}
	//$smarty->assign( "ToDel", $_GET['del'] );
	if( !is_writable( $delFile ) ) {
		error( "Nie masz uprawnieñ do usuniêcia tego pliku !" );
	}
	//qDebug( "Deleting $delFile" );
	$toAdd['file'] = $_GET['del'];
	$toAdd['dir'] = addslashes( $sfd['dir'] );
	$toAdd['action'] = 'del';
	$toAdd['user'] = $player->id;
	$toAdd['date'] = dbDate( time() );
	SqlExec( SqlCreate( "INSERT", "fm_history", $toAdd ), true );
	//SqlExec( "INSERT INTO fm_history( `")
	showInfo( "Plik <i>$delFile</i> zosta³ usuniêty", 'info' );
	unlink( $delFile );
}

if( isset( $_GET['cd'] ) ) {
	$newDir = fixTrailSlash( realpath( $sfd['dir'] . $_GET['cd'] ) );
	//qDebug( "Changing dir to : $newDir" );
	if( !is_dir( $newDir ) || stripos( $newDir, KT_ROOT_DIR) !== 0 ) {
		error( "Próba uzyskania zabronionej ¶cie¿ki !" );
	}
	$sfd['dir'] = $newDir;
}

$_page = ( isset( $_GET['action'] )?$_GET['action']:"tree");

switch( $_page ) {
	case 'tree' :
		$curDirListing =  getDirListing( $sfd['dir'] );
		switch( $_GET['orderby'] ) {
			case 'name' :
				usort( $curDirListing, "dir_name_cmp" );
				break;
			case 'ext' :
				usort( $curDirListing, "dir_ext_cmp" );
				break;
		 }
		foreach( $curDirListing as $k => $i ) {
			$changed = false;
			if( $i['filetype'] == 'file' ) {
				if( $i['size'] > 1024 ) {
		 			$i['size'] = round( $i['size'] / 1024, 2 ) . " Kb";
				}
				else {
					$i['size'] .= " b";
				}
				$changed = true;
			}
		
			if( $changed ) {
				$curDirListing[$k] = $i;
			}
		}
		$smarty->assign( array( "DirList" => $curDirListing ) );
		break;
	case 'history' :
		$hist = SqlExec( "SELECT h.*, p.user AS uname FROM fm_history h LEFT JOIN players p ON p.id=h.user ORDER BY h.date DESC" );
		$hist = $hist->GetArray();
		//qDebug( $hist );
		foreach( $hist as $k => $h ) {
			$h['dir'] = str_replace( KT_ROOT_DIR, "", $h['dir'] );
			$hist[$k] = $h;
		}
		$smarty->assign( "History", $hist );
		break;
	default :
		error( "Akcja obecnie nie obs³ugiwana !" );
}

 //qDebug( $hist );

$smarty->assign( array( "Page" => $_page,
						"SessFiler" => $sfd ) );
$smarty->display( "filer.tpl" );

require_once( "includes/foot.php" );

?>