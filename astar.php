<?php

class pathfinder {
	
	private $open;
	private $closed;
	private $map;
	private $step_line;
	private $step_diag;
	private $nodes;
	private $start;
	private $end;
	
	function __construct( $startx, $starty, $endx, $endy ) {
		$this->start['x'] = $startx;
		$this->start['y'] = $starty;
		$this->end['x'] = $endx;
		$this->end['y'] = $endy;
		$this->step_line = 1;
		$this->step_diag = 2;
		$this->nodes = 0;
	}
	
	function setMap( &$map ) {
		$this -> map = $map;
	}
	
	function getPath() {
		//$end = false;
		$this->open[$this->start['x']][$this->start['y']] = array( "x" => $this->start['x'], "y" => $this->start['y'], 'F' => 0, 'G' => 0, 'H' => 0 );
		$this->nodes++;
		$ret = $this->getLow();
		do {
			$this->around( $ret['x'], $ret['y'] );
			$ret = $this->getLow();
			if( $ret['x'] == $this->end['x'] && $ret['y'] == $this->end['y'] )
				break;
			if( $this->nodes == 0 )
				break;
		} while( true );
		
		if( $ret['x'] != $this->end['x'] && $ret['y'] != $this->end['y'] )
			return NULL;

		$path = array();
		do {
			$path[$ret['x']][$ret['y']] = true;
			//$path[] = array( 'x' => $ret['x'], 'y' => $ret['y'] );
			if( $ret['x'] == $this->start['x'] && $ret['y'] == $this->start['y'] )
				break;
			$node = $this->open[$ret['x']][$ret['y']];
			$ret['x'] = $node['px'];
			$ret['y'] = $node['py'];
		} while( true );
		return $path;
	}
	
	private function is_diagonal( $sx, $sy, $dx, $dy ) {
		if( $sx != $dx && $sy != $dy )
			return true;
		return false;
	}
	
	private function is_blocked( $sx, $sy ) {
		if( $this->map[$sx][$sy]['option'] == 'block' )
			return TRUE;
		if( $this->map[$sx][$sy]['option'] == 'highblock' )
			return TRUE;
		return FALSE;
	}
	
	private function around( $sx, $sy ) {
		for( $i1 = $sx -1; $i1 <= $sx +1; $i1 ++ ) {
			for( $j1 = $sy -1; $j1 <= $sy +1; $j1++ ) {
				if( $i1 < 0 || $i1 > $this->map['x'] )
					continue;
				if( $j1 < 0 || $j1 > $this->map['y'] )
					continue;
				$cost = 500;
				if( $this -> is_diagonal( $sx, $sy, $i1, $j1 ) ) {
					$dx = $i1 - $sx;
					$dy = $j1 - $sy;
					if( $this->is_blocked( $sx + $dx, $sy ) ||
						$this->is_blocked( $sx, $sy + $dy ) )
						//$this->map[$sx + $dx][$sy]['option'] == 'block' ||
						//$this->map[$sx][$sy + $dy]['option'] == 'block' )
						continue;
					$cost = $this->step_diag;
				}
				else {
					$cost = $this->step_line;
				}
				if( $i1 == $sx && $j1 == $sy )
					continue;
				if( isset( $this->open[$i1][$j1] ) )
					continue;
				if( $this->closed[$i1][$j1] )
					continue;
				if( $this->is_blocked( $i1, $j1 ) )
					continue;
			
			
				$g = $this->open[$sx][$sy]['G'] + $cost;
				$h = $this -> calcH( $i1, $j1, $this->end['x'], $this->end['y'] );
				$f = $g + $h;
				$this->open[$i1][$j1] = array( "x" => $i1, "y" => $j1, "px" => $sx, "py" => $sy, 'F' => $f, 'G' => $g, 'H' => $h );
				$this->nodes ++;
			//$g = calcG($i1,$j1);
			
			//$this->open[$i1][$j1]['F'] =$f;
			//$this->open[$i1][$j1]['H'] =$h;
			//$this->open[$i1][$j1]['G'] =$g;
			
			}
		}
		$this->closed[$sx][$sy] = true;
		$this->nodes --;
	}
	
	private function calcH( $sx, $sy, $ex, $ey ) {
		//if( $this->is_diagonal( $sx, $sy, $ex, $ey ) ) {
		//	$mlt = $this->step
		return ( abs( $sx - $ex ) + abs( $sy - $ey ) )*$this->step_line;
	}
	
	private function getLow() {
		$keyx = NULL;
		$keyy = NULL;
		$min = 99999999999;
		foreach( $this -> open as $key1=>$val ) {
			foreach( $val as $key2=>$val1 ) {
				if( $this -> closed[$key1][$key2] == true )
					continue;
				if( $val1['F'] < $min ) {
				//echo "F:$val1[F] ";
				$keyx = $key1;
				$keyy = $key2;
				$min = $val1['F'];
				}
			}
		//echo "<br>";
		}
	//echo "choosed lowest x: $keyx, y: $keyy (F:{$open[$keyx][$keyy]['F']}<br>";
	return( array( 'x' => $keyx, 'y' => $keyy ) );
	}
}

function getTiles( $map, $type ) {
	unset( $map['x'], $map['y'] );
	$return = array();
	foreach( $map as $x => $submap ) {
		foreach( $submap as $y => $tile ) {
			if( !empty( $tile['option'] ) && $tile['option'] == $type ) {
				$return[] = array( 'x' => $x, 'y' => $y );
			}
		}
	}
	return $return;
}


class liner {
	private $a;
	private $b;
	private $start;
	private $end;
	
	function __construct( $sx, $sy, $ex, $ey ) {
		//$sx--;
		//$sy--;
		//$ex++;
		//$ey++;
		$this->start = array( 'x' => $sx, 'y' => $sy );
		$this->end = array( 'x' => $ex, 'y' => $ey );
		if( $this->isInLine() ) {
			return;
		}
		$this->a = ( $ey - $sy ) / ( $ex - $sx );
		$this->b = $sy;
	}
	
	
	
	function setStart( $sx, $sy ) {
		$this->start = array( 'x' => $sx, 'y' => $sy );
	}
	
	function setEnd( $ex, $ey ) {
		$this->end = array( 'x' => $ex, 'y' => $ey );
	}
	
	function getLine() {
		if( $this->isInLine() ) {
			return $this->line();
		}
		$line = array();
		$dx = $this->start['x'] - $this->end['x'];
		$dy = $this->start['y'] - $this->end['y'];
		if( $dx <= $dy ) {
			if( $this->start['x'] > $this->end['x'] ) {
				//$d = '
			}
			$start = min( $this->start['x'], $this->end['x'] );
			$end = max( $this->start['x'], $this->end['x'] );
			for( $i = $start; $i <= $end; $i++ ) {
				$res = $this->knownX( $i );
				//$fract = $res - floor( $res );
				$line[ $i ][ round( $res ) ] = true;
				//echo "for x=$i, y=$res, fract=$fract<br>";
			}
		}
		else {
			$start = min( $this->start['y'], $this->end['y'] );
			$end = max( $this->start['y'], $this->end['y'] );
			for( $i = $start; $i <= $end; $i++ ) {
				$res = $this->knownY( $i );
				$line[ round( $res ) ][ $i ] = true;
				//echo "for y=$i, x=$res<br>";
			}
		}
		print_r( $line );
		return $line;
	}
	
	function getPerc() {
		if( $this->isInLine() ) {
			return $this->linePerc();
			//return;
		}
		$line = array();
		$dx = $this->start['x'] - $this->end['x'];
		$dy = $this->start['y'] - $this->end['y'];
		if( abs( $dx ) > abs( $dy ) ) {
			$start = min( $this->start['x'], $this->end['x'] );
			$end = max( $this->start['x'], $this->end['x'] );
			for( $i = $start; $i <= $end; $i++ ) {
				$res = $this->knownX( $i );
				
				$fract = $res - floor( $res );
				//echo "for x=$i, y=$res, fract=$fract<br>";
				if( $fract != 0 ) {
					if( $fract < 0.5 ) {
						$mod = 1;
					}
					else {
						$mod = -1;
					}
					$line[ $i ][ round( $res ) ] = $fract;
					$line[ $i ][ round( $res ) + $mod ] = abs( $fract -1 );
				}
				else {
					$line[ $i ][ round( $res ) ] = 1;
				}
				
			}
		}
		else {
			$start = min( $this->start['y'], $this->end['y'] );
			$end = max( $this->start['y'], $this->end['y'] );
			for( $i = $start; $i <= $end; $i++ ) {
				$res = $this->knownY( $i );
				$fract = $res - floor( $res );
				//echo "for y=$i, x=$res, fract=$fract<br>";
				if( $fract != 0 ) {
					if( $fract < 0.5 ) {
						$mod = 1;
					}
					else {
						$mod = -1;
					}
					$line[ round( $res ) ][ $i ] = $fract;
					$line[ round( $res ) + $mod ][ $i ] = abs( $fract - 1 );
				}
				else {
					$line[ round( $res ) ][ $i ] = 1;
				}
				
			}
		}
		//print_r( $line );
		return $line;
	}
	
	function calcCover( $map ) {
		$line = $this->getPerc();
		$chance = 0;
		foreach( $line as $x => $subline ) {
			foreach( $subline as $y => $val ) {
				if( $map[$x][$y]['option'] == 'highblock' ) {
					$chance += $val;
					if( $chance >= 1 ) {
						$chance = 1;
						break;
					}
				}
			}
		}
		return $chance;
	}
	
	private function isInLine() {
		if( $this->start['x'] == $this->end['x'] || $this->start['y'] == $this->end['y'] ) {
			return true;
		}
		return false;
	}
	
	private function line() {
		if( $this->start['x'] == $this->end['x'] ) {
			$start = min( $this->start['y'], $this->end['y'] );
			$end = max( $this->start['y'], $this->end['y'] );
			for( $i = $start; $i <= $end; $i++ ) {
				$line[ $this->start['x'] ][ $i ] = true;
			}
			return $line;
		}
		if( $this->start['y'] == $this->end['y'] ) {
			$start = min( $this->start['x'], $this->end['x'] );
			$end = max( $this->start['x'], $this->end['x'] );
			for( $i = $start; $i <= $end; $i++ ) {
				$line[ $i ][ $this->start['y'] ] = true;
			}
			return $line;
		}
	}
	
	private function linePerc() {
		if( $this->start['x'] == $this->end['x'] ) {
			$start = min( $this->start['y'], $this->end['y'] );
			$end = max( $this->start['y'], $this->end['y'] );
			for( $i = $start; $i <= $end; $i++ ) {
				$line[ $this->start['x'] ][ $i ] = 1;
			}
			return $line;
		}
		if( $this->start['y'] == $this->end['y'] ) {
			$start = min( $this->start['x'], $this->end['x'] );
			$end = max( $this->start['x'], $this->end['x'] );
			for( $i = $start; $i <= $end; $i++ ) {
				$line[ $i ][ $this->start['y'] ] = 1;
			}
			return $line;
		}
	}
	
	private function knownX( $x ) {
		//echo "knownX : \$val = {$this->a} * ( {$x} - {$this->start['x']} ) + {$this->start['y']};<br>";
		$val = $this->a * ( $x - $this->start['x'] ) + $this->start['y'];
		return $val;
	}
	
	private function knownY( $y ) {
		$val = $this->start['x'] + ( $y - $this->b ) / $this->a;
		return $val;
	}
}


require_once( "maps/map.php" );

$sa = getTiles( $map, 'startp' );
$sf = array_rand( $sa );
$startx = $sa[$sf]['x'];
$starty = $sa[$sf]['y'];

echo "start x:$startx, y:$starty<br>";

$ea = getTiles( $map, 'starte' );
$ef = array_rand( $ea );
$endx = $ea[$ef]['x'];
$endy = $ea[$ef]['y'];

echo "end x:$endx, y:$endy<br>";

$l = new liner( $startx, $starty, $endx, $endy );
$line = $l->getPerc();
$chance = $l->calcCover( $map )*100;


// $difx = ( $endx - $startx );
// $dify = ( $endy - $starty );
// if( abs( $difx ) < abs( $dify ) ) {
// 	$jump = $difx / $dify;
// }
// else {
// 	$jump = $dify / $difx;
// }
// 	echo "diff - x:$difx y:$dify || jump : $jump<br>";
// // 	$tmp = $startx;
// // 	$line = array();
// // 	for( $i = 1; $i <= abs( $dify ); $i++ ) {	
// // 		$fract = $tmp - floor( $tmp );
// // 		$x = $tmp;
// // 		$y = $starty + $i;
// // 		echo "at (x)$x:(y)$y :: $fract<br>";
// // 		$line[round( $x )][round( $y )] = true;
// // 		$tmp += $jump;
// // 	}
// //}
// // else {
// // 	$jump = $dify / $difx;
// // 	echo "diff - x:$difx y:$dify || jump : $jump<br>";
// // 	$tmp = $starty;
// // 	$line = array();
// // 	for( $i = 1; $i <= abs( $difx ); $i++ ) {	
// // 		$fract = $tmp - floor( $tmp );
// // 		$y = $tmp;
// // 		$x = $startx + $i;
// // 		echo "at (x)$x:(y)$y :: $fract<br>";
// // 		$line[round( $x )][round( $y )] = true;
// // 		$tmp += $jump;
// // 	}
// // }
// 
// 
// 
// $tmp = $startx;
// $line = array();
// for( $i = 1; $i <= abs( $dify ); $i++ ) {	
// 	$fract = $tmp - floor( $tmp );
// 	$x = $tmp;
// 	$y = $starty + $i;
// 	echo "at (x)$x:(y)$y :: $fract<br>";
// 	$line[round( $x )][round( $y )] = true;
// 	$tmp += $jump;
// }
// echo " tmp : $tmp ";



$pf = new pathfinder( $startx, $starty, $endx, $endy );
//$pf->setBlock( $block );
$pf->setMap( $map );
$path = $pf->getPath();

//print_r( $map );

echo "Cover : <b>$chance</b>%<br>";
if( $path == NULL )
	echo( "Sciezka nie zostala znaleziona" );

echo "<script language=\"JavaScript\" src=\"js/astar.js\"></script>";
echo "<div id='test'></div><br>";
echo "<img src='images/map/spc_startp.gif'> - start<br>";
echo "<img src='images/map/spc_starte.gif'> - koniec<br>";
echo "<img src='images/map/spc_exit.gif'> - droga<br>";
echo "<table border=0 cellspacing=0 cellpadding=0 >\n";
for( $i = 0; $i < $map['x']; $i++ ) {
	echo "<tr>";
	for( $j = 0; $j < $map['y']; $j++ ) {
		//if( $path[$i][$j] )
		//	echo "<td x='$i' y='$j' style='width:20px; height:20px;background-color:lime' onmouseover='foo(this);'>";
		//elseif( $map[$i][$j]['block'] )
		//	echo "<td style='width:20px; height:20px;background-color:red'>";
		//else
		//	echo "<td style='width:20px; height:20px'>";
		if( !empty( $map[$i][$j]['tiletype'] ) )
				echo "<td align='center' style=\"width:20px; height:20px;background: url('images/map/{$map[$i][$j]['tilename']}.gif')\">";
		else
			echo "<td style='width:20px; height:20px'>";
		
		if( !empty( $line[$i][$j] ) )
			echo "<span style='font-size:5px'>".round( $line[$i][$j], 2 )."</span>";
		elseif( $i == $startx && $j == $starty )
			echo "<img src='images/map/spc_startp.gif'>";
		elseif( $i == $endx && $j == $endy )
			echo "<img src='images/map/spc_starte.gif'>";
		elseif( $path[$i][$j] )
			echo "<img src='images/map/spc_exit.gif'>";
		else
			echo "&nbsp;";
		//if( $open[$i][$j] )
			//echo "o";//({$open[$i][$j]['F']},{$open[$i][$j]['G']},{$open[$i][$j]['H']})";
		//if( $closed[$i][$j] )
			//echo "c";
		//if( $path[$i][$j] )
			//echo "P";
		//if( $block[$i][$j] )
		//	echo "x";

			
		echo "</td>";
	}
	echo "</tr>\n";
}
echo "</table>\n"

?>