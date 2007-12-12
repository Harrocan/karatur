<?php
/**
 *
 * Copyright (C) 2007 by Kara-Tur Team
 *
 * @name    : imgpotions.php
 * @author  : IvaN <ivan-q@o2.pl>
 * @version : 0.1
 * @since   : 24-01-2007
 *
 */

$path = $_GET['path'];

if( is_file( $path ) ) {
	$przedmiot = imagecreatefromgif( $path );
}
else {
	$przedmiot = imagecreatefromgif( 'images/potions/na.gif' );
}
	$px = imagesx( $przedmiot );
	$py = imagesy( $przedmiot );
	$mod = 4;
	$imgx = $px + $mod;
	$imgy = $py + $mod;
	$img = imagecreatetruecolor( $imgx, $imgy );
	$bg = imagecolorallocate( $img, 7, 7, 7 );
	imagefill( $img, 0, 0, $bg );
	$border = imagecolorallocate( $img, 88, 88, 88 );
	imagefilledrectangle( $img, 0, 0, $mod/2, $imgy, $border );
	imagefilledrectangle( $img, 0, 0, $imgx, $mod/2, $border );
	imagefilledrectangle( $img, 0, $imgy, $imgx, $imgy - $mod/2 - 1, $border );
	imagefilledrectangle( $img, $imgx, 0, $imgx - $mod/2 - 1, $imgy, $border );
	$startx = $mod/2;
	$starty = $mod/2;
	$endx = $imgx - $mod/2;
	$endy = $imgy - $mod/2;
// }
// else {
// 	$img = imagecreatefromgif( 'images/potions/none.gif' );
// 	
// 	$imgx = imagesx( $img );
// 	$imgy = imagesy( $img );
// 	$startx = 0;
// 	$starty = 0;
// 	$endx = $imgx;
// 	$endy = $imgy;
// }

if( $przedmiot ) {
	imagecopy( $img, $przedmiot, $startx, $starty, 0, 0, $px, $py );
	imagedestroy($przedmiot);
}

$fontcolor = imagecolorallocate( $img, 255, 255, 255 );
if( !empty( $_GET['amount'] ) ) {
	$font = 1;
	$string = $_GET['amount'];
	$fonth = imagefontheight($font);
	$fontw = imagefontwidth($font);
	
	$black = imagecolorallocate( $img, 0, 0, 0 );
	imagefilledrectangle( $img, $startx+1, $endy-1, $startx+$fontw*strlen($string), $endy-$fonth, $black );
	imagestring( $img, 1, $startx+1, $endy-$fonth, $string, $fontcolor );
}
if( !empty( $_GET['power'] ) ) {
	$font = 1;
	$string = $_GET['power'];
	$fonth = imagefontheight($font);
	$fontw = imagefontwidth($font);
	$black = imagecolorallocate( $img, 0, 0, 0 );
	imagefilledrectangle( $img, $endx-2, $starty+1, $endx-$fontw*strlen($string), $starty+$fonth, $black );
	imagestring( $img, 1, $endx -$fontw*strlen($string) , $starty +1, $string, $fontcolor );
}
header("Content-type: image/png");
imagepng($img);

imagedestroy($img);


?>
