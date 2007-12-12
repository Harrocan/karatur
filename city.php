<?php

require_once('includes/preinit.php');

if( strlen( $player->file ) > 0 ) {
	$city = SqlExec( "SELECT m.* FROM mapa m WHERE m.zm_x = '{$player->mapx}' AND m.zm_y='{$player->mapy}'" );
	$city = $city->GetArray();
	
	//qDebug( $city );
}

if( empty( $city ) ) {
	$city = NULL;
}
else {
	//$city = array_shift( $city );
	$city = processMapRef( $city[0] );
}

if( $city['id'] && $city['type'] == 'L' ) {
	//$try = SqlExec( "SELECT `file` FROM `miasta-spec` WHERE `mapx`='{$player->mapx}' AND `mapy`='{$player->mapy}'" );
	//$try = $try -> GetArray();
	//qDebug( $try );
	//$try = array_shift( $try );
	//header( "Location: {$try['file']} " );
	header( "Location: {$city['file']}" );
}

if( $city ) {
	$title = $city['name'];
}
else {
	$title = "Miasto";
}

if( isset( $_GET['page'] ) ) {
	$KT_CONFIG['display']['page_title'] = false;
}

makeHeader();

//qDebug( $city );
//qDebug( $_SERVER  );
$city_id = ( $city['ref_id'] > 0 )?$city['ref_id']:$city['id'];

if( !isset( $_GET['page'] ) ) {

	if( $city['id'] ) {
		if( $city['type'] ) {
			require_once( "class/metaTable.class.php" );
			$metaCity = new MetaTable( "cityData", "city_id", $city_id, "col" );
			$cityData = $metaCity->loadData();
			//qDebug( $cityData );
			$i = 0;
			for( $x = 0; $x < 12; $x++ ) {
				$posX = floor( $i / 3 );
				$posY = $i % 3;
				
				if( empty( $cityData[$x] ) ) {
					continue;
				}
				$tRow =& $cityData[$i];
				if( !empty( $tRow ) ) {
					$tRow['title'] = html_entity_decode( $tRow['title'] );
					$j=0;
					for( $y = 0; $y < 5; $y++ ) {
						if( empty( $tRow['fields'][$y] ) ) {
							continue;
						}
						$item =& $tRow['fields'][$j];
						if( empty( $item['name'] ) ) {
							//continue;
							$item['name'] = '&nbsp;';
							$item['type'] = 'none';
						}
						else {
							if( $item['type'] == 'module' ) {
								$item['valid'] = testModule( $item['file'] );
								$item['mod'] = $item['file'];
								$query = array();
								parse_str( $item['query'], $query );
								$query['mod'] = $item['mod'];
								$item['query'] = http_build_query( $query );
								$item['file'] = 'modules.php';
								//qDebug( $query );
							}
							else {
								if( file_exists( "city_pages/{$item['file']}" ) ) {
									$query = array();
									parse_str( $item['query'], $query );
									$query['page'] = basename( $item['file'], ".php" );
									$item['query'] = http_build_query( $query );
									$item['file'] = 'city.php';
								}
							}
						}
						$j++;
					
					}
					$i++;
				}
				else {
					$tRow = array( 'posX' => $posX, 'posY' => $posY, 'title' => "", 'fields' => array() );
					for( $j = 0; $j < 5; $j++ ) {
						$item =& $tRow['fields'][$j];
						if( empty( $item['name'] ) ) {
							$item['name'] = '&nbsp;';
							$item['type'] = 'none';
						}
					}
				}
				//sort( $tRow['fields'] );
				//for( $j = 0; $j < 3; $j++ ) {
				//}
			}
			//qDebug( $cityData );
			$smarty->assign( "Data", $cityData );
		}
		elseif( $city['type'] == 'L' ) {
			
		}
	}
	else {
		//trigger_error( "Tutaj nie ma zadnego miasta !", E_USER_ERROR );
		
		error( "Tutaj nie ma nic interesuj±cego !", 'error', 'mapa.php' );
	}
	
	$smarty->display('city.tpl');
}
else{
	$filename = "city_pages/{$_GET['page']}.php";
	if( file_exists( $filename ) ) {
		kt_url_rewriter_city_reset_var();
		kt_url_rewriter_city_add_var( 'page', $_GET['page'] );
		ob_start( 'kt_url_rewriter_city' );
		require_once( $filename );
		ob_end_flush();
	}
	else {
		error( "Nieprawid³owe wywo³anie !" );
	}
}

require_once('includes/foot.php');
?>
