<?php
function filearray($start="/") {
  $dir=opendir($start);
  while (false !== ($found=readdir($dir))) { $getit[]=$found; }
  foreach($getit as $num => $item) {
   if (is_dir($start.$item) && $item!="." && $item!=".." && $item!="mapa-big") {
   	$output["{$item}"]=filearray($start.$item."/"); 
   }
   if (is_file($start.$item)) {
   	$output[]="{$start}{$item}";
   }
  }
  closedir($dir);
  return $output;
}
function filelist($filearr) {
	foreach($filearr as $key=>$file) {
		if(is_array($file)) {
			//echo "$key/";
			filelist($file);
		}
		else
			echo "ftp://ftp.ivan.netshock.pl/public_html/karatur/$file<br>";
	}
}

$list=filearray("./");
echo "<pre>";
filelist($list);
echo "</pre>";
?>