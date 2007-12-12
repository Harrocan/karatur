<?php


function smarty_function_kt_gallery($params, &$smarty) {
	
	if( empty($params['amount'] ) || empty( $params['mode'] ) ) {
		return "missing parameters !";
	}
	
	$fp = fopen( "http://www.vilim.yoyo.pl/galeria/kt_lastup.php?amount={$params['amount']}&mode={$params['mode']}", "r" );
	
	
	if( !$fp ) {
		return "Nie mo¿na po³±czyæ siê galeri± !" ;
	}
	$line = stream_get_line( $fp, 10240, "\n" );
	
	$line = mb_convert_encoding( $line, "ISO-8859-2", "UTF-8" );
	
	//echo $line . "\n";
	
	$data = explode( "|", $line );
	foreach( $data as $k => $el ) {
		$ldata = explode( "&", $el );
		//print_r( $ldata );
		if( empty( $ldata[0] ) ) {
			continue; 
		}
		echo <<<EOL
	<center><A HREF="http://www.vilim.yoyo.pl/galeria/displayimage.php?album=lastup&amp;cat=0&amp;pos=0s"><IMG SRC="http://www.vilim.yoyo.pl/galeria/albums/{$ldata[0]}thumb_{$ldata[1]}" BORDER="0"><br/><b>{$ldata[3]}</b></A></center>
		<center><br/>(<A HREF="http://www.vilim.yoyo.pl/galeria/thumbnails.php?album={$ldata[4]}">{$ldata[2]}</a>)</center>
EOL;
	}
	
	fclose( $fp );
}

?>