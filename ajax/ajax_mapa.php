<?php
require_once( 'ajax_base.php' );

function getVal( $tab, $x, $y, $val ) {
	//print_R ($tab );
	foreach( $tab as $item ) {
		if( $item['zm_x'] == $x && $item['zm_y'] == $y && isset( $item[$val] ) ) {
			return $item[$val];
		}
	}
	return NULL;
}

if( empty( $_SESSION['player'] ) ) {
	err( "SESS_EXPIRE" );
}

$player =& $_SESSION['player'];

//print_r( $_POST );

switch( $_POST['action'] ) {
	case 'dir' :
		if( $player->jail != 'N' ) {
			err( "IN_JAIL" );
		}
		if( $player->hp <= 0 ) {
			err( "NO_HP" );
		}
		if( $player->mapx == 0 || $player->mapy == 0 ) {
			err( "NO_COORDS" );
		}
		if( $player->energy < 0.4 ) {
			err( "NO_ENERGY" );
		}
		$dir = $_POST['value'];
		$maxx = 58;
		$maxy = 47;
		$minx = 26;
		$miny = 20;
		$modx = 0;
		$mody = 0;
		switch( $dir ) {
			case 'up' :
				$mody = -1;
				break;
			case 'down' :
				$mody = 1;
				break;
			case 'left' :
				$modx = -1;
				break;
			case 'right' :
				$modx = 1;
				break;
			case 'null' :
				break;
			default :
				err( "INVAILD_GET" );
				break;
		}
		
		$x=$player->mapx + $modx;
		$y=$player->mapy + $mody;
		if( $x > $maxx || $x < $minx || $y > $maxy || $y < $miny ) {
			err( "OUT_OF_MAP" );
		}
		$blocked = SqlExec( "SELECT zm_x, zm_y, dost,file FROM mapa WHERE zm_x>=".($x-1)." AND zm_x<=".($x+1)." AND zm_y>=".($y-1)." AND zm_y<=".($y+1) );
		$blocked = $blocked->GetArray();
		if( getVal( $blocked, $x, $y, 'dost' ) == 'nie' ) {
			err( "BLOCKED" );
		}
		$ajax->addField( 'type', 'MAP' );
		//echo "MAP~";
		$desc = SqlExec( "SELECT * FROM mapa WHERE zm_x=".$x." AND zm_y=".$y );
		$desc = array_shift( $desc -> GetArray() );
		$desc = processMapRef( $desc );
		$location = ( $desc['name'] )?$desc['name']:"pustkowia";
		$file = ($desc['file'])?$desc['file']:"";
		//echo ( $desc['name'] )?$desc['name']:"pustkowia";
		$ajax -> addField( 'name', ( $desc['name'] )?$desc['name']:"pustkowia" );
		//echo "~";
		//echo ( $desc['file'] )?$desc['file']:"none";
		$ajax -> addField( 'file', ( $desc['file'] )?$desc['file']:"none" );
		//echo "~";
		//echo "{$y}x{$x}~";
		$ajax -> addField( 'coord', "{$y}x{$x}" );
		//echo ( $desc['opis'] )?$desc['opis']:"brak danych";
		$ajax -> addField( 'desc', ( $desc['opis'] )?$desc['opis']:"brak danych" );
		//echo "~";
		//echo ( $desc['geo'] )?$desc['geo']:"brak danych";
		$ajax -> addField( 'geo', ( $desc['geo'] )?$desc['geo']:"brak danych" );
		//echo "~";
		//echo ( $desc['flora'] )?$desc['flora']:"brak danych";
		$ajax -> addField( 'nat', ( $desc['flora'] )?$desc['flora']:"brak danych" );
		//echo "~";
		//if( $desc['name'] );
		//$tab = array();
		//$map = '<table cellspacing="2" cellpadding="0" border="0"  class="table"><tr><td colspan="5" align="center" class="thead" id="tabMapHead">';
		//if($file)
		//	$map .= '<a href="'.$file.'">'.$location.'</a>';
		//else
		//	$map .= $location;
		//$map .= '<br>'.$y.'x'.$x.'</td></tr>';
		//$map .= '<tr><td></td><td></td><td align="center"><a href="javascript:move(\'up\')"><img src="mapa/arrown.gif"></a></td><td></td><td></td></tr>';
		for($i=$y-1;$i<=$y+2;$i++) {
			//if($y==$i){
			//	$map .= '<tr><td><a href="javascript:move(\'left\')"><img src="mapa/arroww.gif"></a></td>';
			//}
			//else {
			//	$map .= '<tr><td></td>';
			//}
			
			for($j=$x-1;$j<=$x+2;$j++) {
				$tdid = "tabtd_".( $i - $y + 2 )."_".( $j - $x + 2 );
				//$map .= '<td id="'.$tdid.'" align="center" style="width: 50px; height: 50px; background-image: url(mapa-big/'.$i.'_'.$j.'.png)">';
				//$block = SqlExec("SELECT dost,file FROM mapa WHERE zm_x=".$j." AND zm_y=".$i);
				$block = SqlExec("SELECT * FROM mapa WHERE zm_x=".$j." AND zm_y=".$i);
				$block = array_shift( $block->GetArray() );
				$block = processMapRef( $block );
				$tab = array();
				$tab['id'] = "tabtd_".( $i - $y + 2 )."_".( $j - $x + 2 ); // TD id
				$tab['x'] = "$i"; // X
				$tab['y'] = "$j"; // Y
				//echo '<td align="center" style="width: 50px; height: 50px; background-image: url(';
				//echo $pref.'mapa-big/'.$i.'_'.$j.'.png)">';
				if( $j < $minx OR $j > $maxx OR $i < $miny OR $i > $maxy ) {
					$tab['opt'] = "out";
				}
				else if($block['dost']=='nie') {
				//	$map .=  "<img src=\"mapa-big/no.gif\">";
					$tab['opt'] = "block";
				}
				else {
				//	$tab['opt'] = "none";
				}
				//if($y==$i && $x==$j) {
				//	$map .= "<img src=\"${pref}mapa/punkt.gif\">";
				//}
				$ajax -> addField( $tab['id'], $tab );
				//$map[ $tab['id'] ] = $tab;
				//$tab [] = $msg;
				//if($y==$i && $x==$j)
				//	echo "<img src=\"${pref}mapa/punkt.gif\">";
				//else
				//	echo "&nbsp;";
				//$map .= '</td>';
			}
			//if($y==$i)
			//	$map .= '<td><a href="mapa.php?d=e"><img src="mapa/arrowe.gif"></a></td></tr>';
			//else
			//	$map .= '<td></td></tr>';
		}
		//$map .= '<tr><td></td><td></td><td align="center"><a href="javascript:move(\'down\')"><img src="mapa/arrows.gif"></a></td><td></td><td></td></tr></table>';
		//$ajax -> addField( 'map' ,$map );
		//$ajax -> addField( 'map', $map );
		//echo implode( ']', $tab );
		//print_r( $ajax );
		$ajax->send();
		
		$_SESSION['location'] = $location;
		$_SESSION['file'] = $file;
		if( $dir != 'null' ) {
			$player -> energy -= 0.4;
		}
		$player -> SetArray( array( 'mapx' => $x, 'mapy' => $y, 'file' => $file, 'location' => $location ) );
		break;
	default :
		echo "ERR~INVAILD_GET";
		die();
}

die();

//echo $player->user;

?>