<?php

$title = "Zarz±dzanie miastami";
require_once("includes/head.php");
require_once( "class/metaTable.class.php" );
//qDebug( $_SESSION );
if( !getRank( 'edtown' ) )
	error("Nie masz prawa tu przebywaæ !");

function file_perms($file, $octal = false)
{
    if(!file_exists($file)) return false;

    $perms = fileperms($file);

    $cut = $octal ? 2 : 3;

    return substr(decoct($perms), $cut);
}

///function setCityData( $cityId

if( !isset( $_GET['action'] ) ) {
	$_GET['action'] = '';
}
if( !isset( $_GET['view'] ) ) {
	$_GET['view'] = '';
}

if($_GET['action']=='edit') {
	$new=array();
	$new[]=rtrim($_POST['begin'])."\r\n";
	$new[]="{*begin*}\r\n";
	$new[]="<table align=\"center\" border=\"0\" width=\"95%\">\r\n";
	$new[]="\t<tr>\r\n";
	foreach($_POST['opcje'] as $r=>$row) {
		if(!$row['title'])
			continue;
		if($r%3==0 && $r>0) {
			$new[]="\t</tr>\r\n";
			$new[]="\t<tr>\r\n";
		}
		$new[]="\t\t<td valign=\"top\">\r\n";
		$new[]="\t\t\t<table>\r\n";
		foreach($row as $c=>$cell) {
			if(!$cell['file'])
				continue;
			$new[]="\t\t\t\t<tr>\r\n";
			if(is_array($cell)) {
				if($cell['query'])
					$new[]="\t\t\t\t\t<td><a href=\"{$cell['file']}?{$cell['query']}\">{$cell['name']}</a></td>\r\n";
				else
					$new[]="\t\t\t\t\t<td><a href=\"{$cell['file']}\">{$cell['name']}</a></td>\r\n";
				}
			else{
				$new[]="\t\t\t\t\t<td class=\"thead\">$cell</td>\r\n";
				}
			$new[]="\t\t\t\t</tr>\r\n";
		}
		$new[]="\t\t\t</table>\r\n";
		$new[]="\t\t</td>\r\n";
	}
	$new[]="\t</tr>\r\n";
	$new[]="</table>\r\n";
	$new[]="{*end*}\r\n";
	$new[]=rtrim($_POST['end']);
	
	$php[]="<?php\n";
	$php[]="\n";
	$php[]="\n";
	$php[]="/*!\n";
	$php[]=" * Plik wygenerowany przez skrypt tworzenia miast\n";
	$php[]=" * (C) 2006-2007 Kara-Tur Team - Wszelkie prawa zastrzerzone\n";
	$php[]=" *\n";
	$php[]=" * @author IvaN <ivan-q@o2.pl>\n";
	$php[]=" * @version 0.2\n";
	$php[]=" * @since 10.12.2006\n";
	$php[]=" */\n";
	$php[]="\n";
	$php[]="\n";
	$php[]="\$title=\"".ucwords($_POST['cityname'])."\";\n";
	$php[]="require_once('includes/head.php');\n";
	$php[]="\n";
	$php[]="if(\$player->location != '".ucwords($_POST['cityname'])."')\n";
	$php[]="\terror('Nie znajdujesz sie w miescie !','error','mapa.php');\n";
	$php[]="\n";
	$php[]="\$smarty->display('{$_POST['base']}.tpl');\n";
	$php[]="require_once('includes/foot.php');\n";
	$php[]="?>";
	
	file_put_contents("templates/{$_POST['base']}.tpl",$new);
	//$fp=fopen("templates/{$_POST['base']}.tpl","w");
	//if(!$fp)
	//	error("Nie moge utorzyæ/otworzyæ pliku tpl");
	//foreach($new as $num=>$line)
	//	if(fwrite($fp,stripslashes($line),1024)===false)
	//		error("B³±d podczas zapisywania lini $num do pliku tpl");
	//fclose($fp);
	//@chmod("templates/{$_POST['base']}.tpl",0777);
	/*if(file_exists("templates/{$_POST['base']}.tpl"))
		unlink("templates/{$_POST['base']}.tpl");
	touch("templates/{$_POST['base']}.tpl");
	file_put_contents("templates/{$_POST['base']}.tpl",$new);*/
	
	//if(!file_exists("{$_POST['base']}.php")) {
		$fp=fopen("{$_POST['base']}.php","w");
		if(!$fp)
			error("Nie moge utorzyæ/otworzyæ pliku php");
		foreach($php as $num=>$line)
			if(fwrite($fp,$line)===false)
				error("B³±d podczas zapisywania lini $num do pliku php");
		fclose($fp);
		//@chmod("{$_POST['base']}.php",0777);
	//}
	
	echo "WYGENEROWANY KOD <br><br>Plik {$_POST['base']}.tpl : <br>";
	echo "<pre>";
	foreach($new as $num=>$row) 
		echo $num." : ".htmlentities($row);
	echo "<br><br>Plik {$_POST['base']}.php<BR><br>";
	foreach($php as $num=>$row)
		echo $num." : ".htmlentities($row);
	//highlight_file($php);
	echo "</pre>";
	
	error("Operacja zakoñczona sukcesem !",'done');
	//echo "<br><pre>";
	//print_r($_POST);
	//echo "</pre>";
}

if(empty($_GET['view'])) {

	
	
	$city=$db->Execute("SELECT m.id,m.zm_x,m.zm_y,m.name,m.file,m.country FROM mapa m WHERE m.`type`='C' ORDER BY m.name");
	$city=$city->GetArray();
	
	//$path="templates/";
	
	foreach($city as $k=>$c) {
		$metaTmp = new MetaTable( "cityData", "city_id", $c['id'], "col" );
		$data = $metaTmp->loadData();
		$city[$k]['sectors'] = count( $data );
		$amount = 0;
		foreach( $data as $item ) {
			$amount += count( $item['fields'] );
		}
		$city[$k]['amount'] = $amount;
		//qDebug( "{$c['name']} :: Count : " . count( $data ) . " + $amount" );
		//break;
		//$base=basename($c['file'],'.php');
		//if(file_exists($base.".php"))
		//	$city[$key]['php']="ok";
		//else
		//	$city[$key]['php']="brak";
		//if(file_exists($path.$base.".tpl"))
		//	$city[$key]['tpl']="ok";
		//else
		//	$city[$key]['tpl']="brak";
	}
	
	$smarty -> assign("City",$city);
}

if($_GET['view']=='edit' || $_GET['view']=='add') {
	require_once( "class/metaTable.class.php" );
	$metaCity = new MetaTable( "cityData", "city_id", $_GET['cid'], "col" );
	
	if(empty($_GET['cid']))
		error("Wybierz miasto !");
		
	//if( isset( $_GET['convert'] ) ) {
	if( false )
	{
		$city=$db->Execute("SELECT file,name FROM mapa WHERE id={$_GET['cid']}");
		//qDebug( $metaCity->loadData( NULL, 'fields' ) );
		$base=basename($city->fields['file'],'.php');
		//$smarty -> assign( "City", $city -> fields['name'] );
	
		$file=file("templates/$base.tpl");
		
		foreach($file as $key=>$line)
			$file[$key]=str_replace(array("\r","\n"),array("",""),$line);
		
		$begin=true;
		$end=false;
		$beg = '';
		$e = '';
		foreach($file as $line) {
			if($line == "{*begin*}")
				$begin=false;
			
			//echo htmlentities($line);
			if($begin) {
				$beg.=$line."\n";
			}
			if($end) {
				$e.=$line."\n";
			}
			if($line == "{*end*}")
				$end=true;
		}
		
		$smarty -> assign(array("Begin"=>stripslashes($beg),"End"=>stripslashes($e)));
		
		$kw=-1;
		$rr=array();
		//echo "<pre>";
		$a=0;
		unset( $res );
		foreach($file as $key=>$line) {
			if($line=="\t\t<td valign=\"top\">") {
				$kw++;
				$a=0;
			}
			ereg('<td class="thead">(.*)</td>',$line,$t);
			ereg("<td>(.*)</td>",$line,$res);
			//if(strcmp($line,"</table>")==0)
				//echo "koniec --- ";
			//echo $key." : ".htmlspecialchars($line)."<br>";
			if($t[0]) {
				$rr[$kw]['title']=htmlentities($t[1]);
				unset($t);
			}
			//else {
			//	$rr[$kw]['title']='none';
			//}
			if($res[0]) {
				//echo htmlentities($res[0]);
				//echo "\t\tZnaleziono :<br>";
				//echo "\t\t$kw : ".htmlspecialchars($res[1])."<br>";
				$rr[$kw]['fields'][$a]['linki']=htmlentities($res[1]);
				ereg("<a href=\"(.*)\">(.*)</a>",$res[1],$ff);
				//print_r($ff);
				$url = explode("?",$ff[1]);
				$filename=array_shift( $url );
				$rr[$kw]['fields'][$a]['filename']=$filename;
				$query=array_pop($url);
				$rr[$kw]['fields'][$a]['query']=(($query==$filename)?'':$query);
				$rr[$kw]['fields'][$a]['file']=$ff[2];
				unset($res);
				$a++;
			}
			//else {
			//	$rr[$kw][$a]['filename'] = '';
			//	$rr[$kw][$a]['file'] = '';
			//	$rr[$kw][$a]['query'] = '';
			//}
			
		}
		//echo "</pre>";
	
		for( $i = 0; $i < 12; $i ++ ) {
			//if( isset( $rr[$i]['title'] ) ) {
			//	$rr[$i]['title'] = 'nnn';
			//}
			for( $j = 0; $j < 6; $j ++ ) {
				if( empty( $rr[$i]['fields'][$j] ) ) {
					$rr[$i]['fields'][$j]['filename'] = '';
					$rr[$i]['fields'][$j]['file'] = '';
					$rr[$i]['fields'][$j]['query'] = '';
				}
			}
		}
		
		//qDebug( $file );
		
		$cityId = SqlExec( "SELECT id FROM mapa WHERE `file` = '{$city->fields['file']}'", true );
		$cityId = $cityId -> fields['id'];
		//qDebug( $cityId );
		$aff = $metaCity->deleteData();
		qDebug( "Deleted : $aff" );
		foreach( $rr as $key1 => $node ) {
			$maj = floor( $key1 / 3 );
			$min = $key1 % 3;
			if( empty( $node['title'] ) ) {
				continue;
			}
			$metaCity->saveData( $node['title'], $key1, 'title' );
			$metaCity->saveData( $maj, $key1, 'posX' );
			$metaCity->saveData( $min, $key1, 'posY' );
			//saveMetaTableData( "cityData", "city_id", $cityId, "col", $node['title'], $key1, 'title' );
			//saveMetaTableData( "cityData", "city_id", $cityId, "col", $maj, $key1, 'posX' );
			//saveMetaTableData( "cityData", "city_id", $cityId, "col", $min, $key1, 'posY' );
			foreach( $node['fields'] as $key2 => $item ) {
				if( empty( $item['file'] ) ) {
					continue;
				}
				if( stripos( $item['filename'], '.php' ) === FALSE ) {
					$type = 'module';
				}
				else {
					$type = 'file';
				}
				$metaCity->saveData( $item['file'], $key1, 'fields', $key2, 'name' );
				$metaCity->saveData( $type, $key1, 'fields', $key2, 'type' );
				$metaCity->saveData( $item['filename'], $key1, 'fields', $key2, 'file' );
				$metaCity->saveData( $item['query'], $key1, 'fields', $key2, 'query' );
				//saveMetaTableData( "cityData", 'city_id', $cityId, 'col', $item['file'], $key1, 'fields', $key2, 'name' );
				//saveMetaTableData( "cityData", 'city_id', $cityId, 'col', 'file', $key1, 'fields', $key2, 'type' );
				//saveMetaTableData( "cityData", 'city_id', $cityId, 'col', $item['filename'], $key1, 'fields', $key2, 'file' );
				//saveMetaTableData( "cityData", 'city_id', $cityId, 'col', $item['query'], $key1, 'fields', $key2, 'query' );
			}
	//		$node['pos'] = "$maj x $min";
	//		$rr[$key] = $node;
		}
	}
	
	if( !empty( $_POST ) ) {
		//qDebug( $_POST );
	//}
	//if( false )
	//{
		//qDebug( $_POST );
		//$_sqldebug = true;
		$pos =& $_POST['position'];
		//if( !$pos ) {
		//	$pos = 1;
		//}
		//$test = loadMetaTableData( "cityData", "city_id", $_GET['cid'], "col", $pos );
		$test = $metaCity->loadData( $pos );
		//qDebug( $test );
		if( !empty( $test ) ) {
			//$aff = deleteMetaTableData( "cityData", "city_id", $_GET['cid'], "col", $pos );
			$aff = $metaCity->deleteData( $pos );
			//qDebug( "Deleted : $aff" );
			//$metaCity->deleteData( $pos );
		}
		$title =& $_POST['title'];
		$posX = floor( $pos/3 );
		$posY = $pos%3;
		$metaCity->saveData( $title, $pos, 'title' );
		$metaCity->saveData( $posX, $pos, 'posX' );
		$metaCity->saveData( $posY, $pos, 'posY' );
		$index = 0;
		foreach( $_POST['fields'] as $key => $field ) {
			
			if( empty( $field['name'] ) || empty( $field['option'] ) ) {
				//qDebug( "{$field['name']} :: {$field['option']}" );
				continue;
			}
			//qDebug( $field );
			$metaCity->saveData( $field['name'], $pos, 'fields', $index, 'name' );
			$metaCity->saveData( $field['option'], $pos, 'fields', $index, 'file' );
			$metaCity->saveData( $field['query'], $pos, 'fields', $index, 'query' );
			if( stripos( $field['option'], '.php' ) === FALSE ) {
				$type = 'module';
			}
			else {
				$type = 'file';
			}
			$metaCity->saveData( $type, $pos, 'fields', $index, 'type' );

			$index++;
		}
		$_sqldebug = false;
	}
	
	
	//$tmpTest = $metaCity->loadData( '1', 'fields', '2' );
	//$metaCity->saveData( "ble", '1', 'fields', '2', 'name' );
	//qDebug( $tmpTest );
	//$data = loadMetaTableData( "cityData", "city_id", $_GET['cid'], "col" );
	$data = $metaCity->loadData();
	//qDebug( $data );
	$tmp = $data;
	for( $i = 0; $i < 12; $i++ ) {
		$posX = floor( $i / 3 );
		$posY = $i % 3;
		$tRow =& $tmp[$i];
		if( !empty( $tRow ) ) {
			$tRow['title'] = html_entity_decode( $tRow['title'] );
			
			for( $j = 0; $j < 5; $j++ ) {
				$item =& $tRow['fields'][$j];
				if( empty( $item['name'] ) ) {
					$item['name'] = '&nbsp;';
					$item['type'] = 'none';
				}
				else {
					if( $item['type'] == 'module' ) {
						//$query = array();
						//parse_str( $item['query'], $query );
						//$query['mod'] = $item['name'];
						//$item['query'] = http_build_query( $query );
						//$item['file'] = 'modules.php';
						//qDebug( $query );
					}
				}
			
			}
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
		//for( $j = 0; $j < 3; $j++ ) {
		//}
	}
	//qDebug( $tmp );
	$smarty->assign( "Data", $tmp );
			
	//echo "<br><br><pre>";
	//print_r($rr);
	//echo "</pre>";
	//$smarty -> assign("Parsed",$rr);
	
	/*$dir=opendir('./');
	while( ($file = readdir($dir)) !== FALSE )
		echo "$file<br>";
	closedir($dir);*/
	
	unset($file);
	
	$f=scandir('./');
	$f=scanphp($f);
	//qDebug( $f );
	$j=0;
	$x=0;
	foreach($f as $d) {
		$fp=fopen("./$d","r");
		for($i=0;$i<3;$i++)
			$filecontent[]=fgets($fp);
		fclose($fp);
		$ttype = NULL;
		$ddesc = NULL;
		if(ereg("//@type: (.*)",$filecontent[1],$ttype)) {
			ereg("//@desc: (.*)",$filecontent[2],$ddesc);
			$file[$d]=str_replace(array("\r","\n"),array("",""),$ddesc[1]);
			unset($ttype);
			unset($ddesc);
			$j++;
		}
		unset($filecontent);
		$x++;
	}
	asort($file);
	//array_unshift( $file, "" );
	$files['brak'] = array( "&nbsp;" );
	$files['pliki'] = $file;
	$mods = SqlExec( "SELECT name, title FROM modules WHERE `type`='page'" );
	$mods =  $mods->GetArray();
	foreach( $mods as $k => $mod ) {
		unset( $mods[$k] );
		$mods[$mod['name']] = $mod['title'];
	}
	$files['moduly'] = $mods;
	
	
	//qDebug( loadMetaTableData( "cityData", "city_id", $cityId, "col" ) );
	echo "<pre>";
	//print_r($rr);
	//qDebug( $files );
	echo "</pre>";
	
	//$smarty -> assign("Base",$base);
	$smarty->assign( "DummyArr", array( 0, 1, 2, 3, 4 ) );
	$smarty->assign( "Cid", $_GET['cid'] );
	$smarty -> assign ("Files",$files);
	
}

$smarty -> assign ("View",$_GET['view']);
$smarty -> display ('miasta.tpl');

require_once("includes/foot.php"); 
?>
