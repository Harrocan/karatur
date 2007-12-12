<?php

//if ($_SERVER['REMOTE_ADDR'] != '70.84.0.52')
	//die("Ciekawe co chciales tutaj zrobic ?");

require("/home/WWW/ivan/KONFIGURACJA/hasla.php");
echo "MySQL DUMP :: ".date("r",time())."<BR>";
echo "Wykonywanie zrzutu<br>";
$dump=shell_exec("mysqldump -u karatur -p$haslo_do_bazy karatur");
echo "Zrzut zakonczony<br>Zapisywanie do pliku<br>";
file_put_contents("karatur_dump.sql",$dump);
echo "Zrzut zapisany<br>";
echo "MySQL DUMP COMPLETE :: ".date("r",time());
?>