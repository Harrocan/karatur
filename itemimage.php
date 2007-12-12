<?php
/**
 * Tworzy ladne pliczki graficzne na ktorych estetycznie widac jak bardzo zniszczony jest przedmiot
 * Wszystkie parametry przekazuje sie przez $_GET.
 * Wszelkie prawa zastrzerzone. Uzywanie, modyfikowanie bez wiedzy i zgody autora - ZABRONIONE !
 *   (C) 2006-2007 Kara-Tur Team based on Vallheru Team
 *
 * @author IvaN <ivan-q@o2.pl>
 *
 * @param [path] Sciezka do pliku (z nazwa pliku wlaczne)
 * @param [wt] Biezaca wytrzymalosc przedmiotu
 * @param [maxwt] Calkowita wytrzymalosc pliku
 * @param [type] Typ przedmiotu. W przypadku Z, S nie rysuje w tle 'uszkodzen' a tylko sam przedmiot
 *
 * @return Coz innego niz gotowy obrazek ? :P
 *
 * @todo Jak mi sie bedzie nudzic to napisze wersje ktora sama rysuje sobie marginesy
 *       Juz napisalem :P
 */

$path = $_GET['path'];
$item = array();
$item['wt'] = $_GET['wt'];
$item['maxwt'] = $_GET['maxwt'];
$item['type'] = $_GET['type'];
$item['magic'] = $_GET['magic'];
$item['poison'] = $_GET['poison'];

if( $item['wt'] < 0 )
	$item['wt'] = 0;
if( $item['wt'] >= $item['maxwt'] )
	$item['wt'] = $item['maxwt'];

if( is_file( $path ) ) {
	$przedmiot = imagecreatefromgif( $path );

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
}
else {
	$img = imagecreatefromgif( 'images/items/none.gif' );
	$imgx = imagesx( $img );
	$imgy = imagesy( $img );
	$startx = 0;
	$starty = 0;
	$endx = $imgx;
	$endy = $imgy;
}

if( !in_array( $item['type'], array( 'Z', 'S' ) ) && $item['wt'] > 0 && $item['wt'] != $item['maxwt'] ) {
	$proc = $item['wt'] / $item['maxwt'];
	$posy = $proc*$imgy;
	if( $posy > $imgy-5 )
		$posy = $imgy -5;
	if( $posy < 4 )
		$posy = 4;
	$red = imagecolorallocate( $img, 95, 7, 7 );
	imagefilledrectangle( $img, 4, $imgy-5, $imgx-5, $posy, $red );
}
if( $przedmiot ) {
	imagecopy( $img, $przedmiot, $startx, $starty, 0, 0, $px, $py );
	imagedestroy($przedmiot);
}
if( $item['magic'] == 'Y' ) {
	$magic = imagecreatefromgif( 'images/items/magic.gif' );
	imagecopy( $img, $magic, $startx, $starty, 0, 0, $px, $py );
	imagedestroy( $magic );
}
if( $item['poison'] > 0 ) {
	$poison = imagecreatefromgif( 'images/items/poison.gif' );
	imagecopy( $img, $poison, $startx, $starty, 0, 0, $px, $py );
	imagedestroy( $poison );
}
if( !empty( $_GET['amount'] ) ) {
	$font = 1;
	$string = $_GET['amount'];
	$fonth = imagefontheight($font);
	$fontw = imagefontwidth($font);
	$fontcolor = imagecolorallocate( $img, 255, 255, 255 );
	$black = imagecolorallocate( $img, 0, 0, 0 );
	imagefilledrectangle( $img, $startx+1, $endy-1, $startx+$fontw*strlen($string), $endy-$fonth, $black );
	imagestring( $img, 1, $startx+1, $endy-$fonth, $string, $fontcolor );
}
header("Content-type: image/png");
imagepng($img);

imagedestroy($img);
?>