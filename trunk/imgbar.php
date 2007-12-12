<?php
/*!
 * Generowanie kolorowych paskow. Automatycznie oblicza procentowe sprawy. Jesli chodzi o kolory - uzywa
 * zdefiniowanych wewnetrznie schematow kolorystyczych
 * Wszystkie parametry przekazuje sie przez $_GET.
 * Wszelkie prawa zastrzerzone. Uzywanie, modyfikowanie bez wiedzy i zgody autora - ZABRONIONE !
 *   (C) 2006-2007 Kara-Tur Team based on Vallheru Team
 *
 * @author IvaN <ivan-q@o2.pl>
 *
 * @param [width] Zadana dlugosc paska w pikselach
 * @param [type] 'Schemat' kolorystyczny paska. Obecnie dostepne 3 : 'L', 'M', 'E'
 * @param [stat] Tekst ktory bedzie sie pojawial przed wartosciami [np. Pd, Zycie itp]
 * @param [total] Maksymalna wartosc - wtedy kiedy pasek jest pelny
 * @param [cur] Aktualna wartosc
 *
 * @return Gotowy pasek. Bo przeciez nie czolg :P
 		a ja myœla³em ze lodz podwodna ;P
 */

//$string = $_GET['text'];

$width=$_GET['width'];
$height=14;
$font = 1;
$fonth=imagefontheight($font);
$fontw=imagefontwidth($font);
$string = "{$_GET['stat']} : {$_GET['cur']}/{$_GET['total']}";

$im = imagecreatetruecolor($width,$height);

$base = imagecolorallocate($im, 222, 184, 135);
$black = imagecolorallocate($im, 0, 0, 0);
$fontcolor= imagecolorallocate($im, 255, 255, 255);
//$fontcolor= imagecolorallocate($im, 255, 255, 149);
//$fontcolor= $base;
if($_GET['type']=='L') {
	//$off = imagecolorallocate($im, 94, 21, 21);
	//$on = imagecolorallocate($im, 255, 56, 56);
	$off = imagecolorallocate($im, 61, 16, 11);
	$on = imagecolorallocate($im, 175, 45, 30);
}
elseif($_GET['type']=='M') {
	//$off = imagecolorallocate($im, 29, 30, 51);
	//$on = imagecolorallocate($im, 17, 65, 255);
	$off = imagecolorallocate($im, 19, 19, 33);
	$on = imagecolorallocate($im, 30, 60, 148);
}
elseif($_GET['type']=='E') {
	//$off = imagecolorallocate($im, 16, 67, 18);
	//$on = imagecolorallocate($im, 18, 179, 7);
	$off = imagecolorallocate($im, 13, 45, 13);
	$on = imagecolorallocate($im, 21, 140, 21);
	//
}
elseif($_GET['type']=='K') {
	//$off = imagecolorallocate($im, 16, 67, 18);
	//$on = imagecolorallocate($im, 18, 179, 7);
	$off = imagecolorallocate($im, 30, 20, 18);
	$on = imagecolorallocate($im, 100, 36, 33);
	//
}

imagefill ( $im, 0, 0, $black );
$perc=($_GET['cur']/$_GET['total']);
imagefilledrectangle ( $im, 0, 0, $width*$perc, $height, $on );
imagefilledrectangle ( $im, $width*$perc, 0, $width, $height, $off );

// imagesetthickness ( $im, 7 );
// 
// $w  = imagecolorallocate($im, 255, 255, 255);
// $red = imagecolorallocate($im, 255, 0, 0);
// $style = array($red, $red, $red, $red, $red,$red,$red, $w,$w, $w);
// imagesetstyle($im, $style);

//imagefilledrectangle ( $im, 30, 0, 50, 30, IMG_COLOR_STYLED );
imagerectangle ( $im, 0, 0, $width-1, $height-1, $base );

$fontcharwidth=strlen($string)*$fontw;
$px = (imagesx($im) - $fontcharwidth) / 2;
$py = (imagesy($im) - $fonth) / 2;


imagestring( $im, $font, 10, $py, $string, $fontcolor );
imagestring( $im, $font, (imagesx($im) - $fontw * 4) - 1, $py, round( $perc * 100 ).'%', $fontcolor );
//imagettftext ( $im, 7, 0, 1, 1, $black, 'arial', $string );

header("Content-type: image/png");
imagepng($im);
imagedestroy($im);

?> 