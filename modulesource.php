<?php

require_once( "includes/preinit.php" );

$mid =& $_GET['mid'];
$file =& $_GET['file'];
if( empty( $mid ) || empty( $file ) ) {
	die( "Nieprawidlowe zadanie !" );
}



if( empty( $player ) ) {
	die( "Twoja sesja wygasla !" );
}



$mod = SqlExec( "SELECT name,owner FROM modules WHERE id={$mid}" );

if( empty( $mod->fields['name'] ) ) {
	die( "Nie ma takiego modulu" );
}
$mod = array_shift( $mod->GetArray() );

if( getRank('moduleadd') || getRank('modulemanage') ) {
	$dir = array_shift( explode( "/", $file ) );
	$filename = "modules/{$mod['name']}/{$file}";
	$allowedPath = pathinfo( realpath( $_SERVER['SCRIPT_FILENAME'] ) );
	$allowedPath = $allowedPath['dirname']. "\\modules\\{$mod['name']}\\";
	//qDebug( $dir );
	//qDebug( realpath( $filename ) );
	if( stripos( realpath( $filename ), $allowedPath ) === FALSE ) {
		die( "Zabroniona sciezka !" );
	}
	if( file_exists( $filename ) ) {
		?>
			<html>
				<head>
					<title>Zrodlo modulu <?php echo $mod['name']; ?>, plik <?php echo $file; ?></title>
				</head>
				<body>
					<pre>Wszelkie prawa zastrzerzone dla Kara-Tur Teamu.<br/>Zabrania sie uzywania bez wiedzy i zgody zarowno wlasciciela jak i administratora serwisu KaraTur-Team</pre>
		<?php
		highlight_file( $filename );
		?>
				</body>
			</html>
		<?php
	}
	else {
		die( "Nie ma takiego pliku !" );
	}
}
else {
	die( "Brak dostepu !" );
}

$db->Close();

?>