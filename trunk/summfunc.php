<?php

$title="Statystyki miast";
require_once("includes/head.php");

if(!function_exists('scandir')) {
function scandir($dir, $sortorder = 0) {
	if(is_dir($dir))        {
		$dirlist = opendir($dir);
		while( ($file = readdir($dirlist)) !== false) {
			if(!is_dir($file)) {
				$files[] = $file;
			}
		}
		($sortorder == 0) ? asort($files) : rsort($files); // arsort was replaced with rsort
		return $files;
	} else {
	return FALSE;
	break;
	}
}
}

function getPrv($arr,$city,$file) {
	foreach($arr as $row) {
		if($row['name']==$city) {
			//print_r( $row );
			//echo "$city, $file<br>";
			if( !isset( $row[$file] ) )
				return '-';
			else
				return $row[$file];
		}
	}
	return FALSE;
}
function unsetPrv(&$arr,$city,$file) {
	foreach($arr as $key=>$row) {
		if($row['name']==$city) {
			unset($arr[$key][$file]);
			return TRUE;
		}
	}
	return FALSE;
}

$f=scandir('./');
	$f=scanphp($f);

	foreach($f as $d) {
		$fp=fopen("./$d","r");
		for($i=0;$i<3;$i++)
			$filecontent[]=fgets($fp);
		fclose($fp);
		if(ereg("//@type: (.*)",$filecontent[1],$ttype)) {
			ereg("//@desc: (.*)",$filecontent[2],$ddesc);
			$file[$d]['func']=str_replace(array("\r","\n"),array("",""),$ddesc[1]);
			$file[$d]['file']=$d;
			$file[$d]['amount']=0;
			unset($ttype);
			unset($ddesc);
		}
		unset($filecontent);
	}
	asort($file);
//	echo "<pre>";
//	print_r($file);
//	echo "</pre>";

	$city=$db->Execute("SELECT file,name FROM mapa WHERE `type`='C'");
	$prvs=$db->Execute("SELECT * FROM miasta");
	$prvs=$prvs->GetArray();
	$city=$city->GetArray();
	$res = NULL;
	foreach($city as $c) {
	print_r( $c );
	$cname=$c['name'];
	$c=basename($c['file'],'.php');
	if( !is_file( "templates/$c.tpl" ) ) {
		continue;
	}
	$fil=file("templates/$c.tpl");
	foreach($fil as $key=>$line) {
			ereg("<td>(.*)</td>",$line,$res);
			if($res[0]) {
				//$rr[$kw][$a]['linki']=htmlentities($res[1]);
				$field = $res[1];
				ereg("<a href=\"(.*)\">(.*)</a>",$field,$ff);
				$path = explode("?",$ff[1]);
				$filename=array_shift($path);
				$upraw=getPrv($prvs,"$c.php",$filename);
				$file[$filename]['amount']++;
				$file[$filename]['cities'][]=array('name'=>$cname, 'prv'=>$upraw);
				unset($res);
				if($upraw=='1')
					unsetPrv($prvs,"$c.php",$filename);
			}

		}
	}
	foreach($prvs as $key=>$row) {
		foreach($row as $key2=>$cell) {
			if(empty($cell)) {
				unset($prvs[$key][$key2]);
			}
		}
	}
	echo "<pre>";
	print_r($prvs);
	//print_r($file);
	echo "</pre>";
$smarty->assign("File",array_values($file));
$smarty->display("summfunc.tpl");
require_once("includes/foot.php");
?>