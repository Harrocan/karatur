<?php
//@type: F
//@desc: Skrytobójca
/**
*
*  Funkcje pliku: zabijanie ludzi przez automat , oczywiscie za oplaceniem pewnej sumy pieniedzy.
*  www.dfstorm.xt.pl
*  www.dfstorm.xt.pl
*/
$title = "Skrytobojca";
require_once("includes/head.php");
error("Gildia zostala nakryta i zamknieta",'error',$player->file);
if ($player -> kat > 0) {
	error ("Co za duzo to nie zdrowo, przyjdz kiedy indziej chyba nie chcesz aby nas nakryli?");
}
//zabijanie
$cost = ($player -> level * 1500);
$smarty -> assign ("Cost", $cost);
$kat = 1;
if (isset ($_GET['view']) && $_GET['view'] == 'zabijesz') {
  if (isset ($_GET['step']) && $_GET['step'] == 'zabijeszd') {
   $_POST['wyt'] = str_replace("--","", $_POST['wyt']);
   if ($_POST['aid'] != 1) {
   //$db -> Execute("UPDATE players SET kat=kat+".$kat." WHERE id=".$player -> id);
   $player -> kat += 1;
$db -> Execute("UPDATE players SET hp=0 WHERE id=".$_POST['id']);
PutSignal( $_POST['id'], 'misc' );
$db -> Execute("UPDATE players SET credits=credits-".$cost." WHERE id=".$player -> id);
 $db -> Execute("INSERT INTO log (owner,log, czas) VALUES(".$_POST['id'].",'Kiedy wchodziles w uliczke zauwazyles iz pewna osoba podaza za toba ... zdawalo ci sie iz osoba ta juz od dluzszego czasu cie sledzila... wkoncu slyszysz bieg i zauwazasz postac w czarnych szatach ktora podbiega i wbija Ci sztylet prosto w serce. Upadasz na kolana a potem na twarz, pod toba robi sie kaluza krwi.','".$newdate."')");
          error ("Niemartw sie moi ludzie zrobia swoje *diabelski usmiech* <bR><br>created by <a href=dfstorm.xt.pl>Dfstorm</a>");
  }
}
}
$smarty -> display ('kat.tpl');
require_once("includes/foot.php");
?>
