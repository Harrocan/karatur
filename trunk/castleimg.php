<?php

$build[2][2] = 'domek.gif';
$build[1][1] = 'domek.gif';
$build[2][1] = 'domek.gif';

$build[0][0] = 'wall.gif';
$build[0][1] = 'wall.gif';
$build[0][2] = 'wall.gif';
$build[0][3] = 'wall.gif';
$build[2][0] = 'wall.gif';
$build[4][0] = 'wall.gif';
$build[6][0] = 'wall.gif';
$build[8][0] = 'wall.gif';
$build[2][3] = 'wall.gif';
$build[4][3] = 'wall.gif';
$build[6][3] = 'wall.gif';

$imgx = 440;
$imgy = 430;
$img = imagecreatetruecolor( $imgx, $imgy );
$grid = imagecreatefromgif( 'images/castle/grid.gif' );
$gridx = imagesx( $grid );
$gridy = imagesy( $grid );
$color['white'] = imagecolorallocate( $img, 220, 220, 220 );
$color['black'] = imagecolorallocate( $img, 0,   0,   0 );

$randcol['red'] = imagecolorallocate( $img, 255, 0, 0 );
$randcol['green'] = imagecolorallocate( $img, 0, 255, 0 );
$randcol['blue'] = imagecolorallocate( $img, 0, 0, 255 );

$tilesx = floor( $imgx / $gridx ) ;
$tilesxoff = ( ( $imgx / $gridx ) - $tilesx ) * $gridx;
$tilesy = floor( $imgy / $gridy ) * 2;
$tilesyoff = ( ( $imgy / $gridy ) * 2 - $tilesy ) * ( $gridy / 2 );

imagefill( $img, 0, 0, $color['black'] );

for( $y = 0; $y < $tilesy; $y ++ ) {
	$starty = $y * ( $gridy / 2 ) + $tilesyoff;
	if( $starty + $gridy > $imgy ) {
		continue;
	}
	for( $x = 0; $x < $tilesx; $x++ ) {
		if( $y % 2 == 0 ) {
			$startx = $x * $gridx;
		}
		else {
			$startx = $x * $gridx + $gridx/2 ;
		}
		$startx += $tilesxoff/2;
		if( $startx + $gridx > $imgx ) {
			continue;
		}
		if( empty( $build[$y][$x] ) ) {
			//$key = array_rand( $randcol );
			imagecopy( $img, $grid, $startx, $starty, 0, 0, $gridx, $gridy );
			//imagefill( $img, $startx + $gridx/2, $starty + $gridy/2, $color['white'] );
			imagestring($img, 3, $startx + $gridx/2, $starty + $gridy/2, "{$y}x{$x}", $color['white']);
		}
		else {
			$bld = imagecreatefromgif( "images/castle/{$build[$y][$x]}" );
			$bldx = imagesx( $bld );
			$bldy = imagesy( $bld );
			$diff = $bldy - $gridy;
			imagecopy( $img, $bld, $startx, $starty - $diff, 0, 0, $bldx, $bldy );
			imagedestroy( $bld );
		}
	}
}

header("Content-type: image/png");

imagepng( $img );

imagedestroy( $grid );
imagedestroy( $img );

?>