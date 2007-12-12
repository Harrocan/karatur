<?php
//mkdir("users/3/thumb",0755);
//rmdir("users/2/thumb3");
if(!empty($_GET['path']))
	$path=$_GET['path'];
else
	$path='images/';
$dir = opendir($path);
$i=0;
while (($file = readdir($dir)) !== false) {
	if(filetype($path . $file)=='file') {
		$arrfile[$i]=$file;
		$i++;
	}
}
foreach($arrfile as $file) 
	echo "<img src=\"$path$file\"> $file<BR><BR>";
?>