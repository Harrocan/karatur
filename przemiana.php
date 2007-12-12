<?php
//Skrypt wykonanany przez Kiddy'ego
$title = "Przemiana";
require_once("includes/head.php");
if ($player -> level < 5) {
 error ("Musisz miec 5 lvl aby przemienic sie w Wilkolaka!"); //opcja pozwalajaca przemiane od 5 lvl
}
if ($player -> klasa == Druid) {
 error ("Tylko Druid moze sie przemieniac");  //opcja pozwalajaca przemiane tylko dla druida
}
if ($player -> przemiana > 0) {
error ("Jestes juz przemieniony!"); //opcja obliczajaca czy jestes juz przemieniony
   }

$mana = 5;   //opcja zabierajaca mane
$strength = 10; //opcja dodajaca sile
$agility = 7;     //opcja dodajaca zrecznosc
$hp = 9;   //opcja dodajaca zycie
$max_hp = 9; //opcja dodajaca max_zycie
$unik = 4;   //opcja dodajaca uniki
$energia = 10;  //opcja dodajaca energie
$przemiana = 1;   //opcja dodajaca uniki

$db -> Execute("UPDATE players SET unik=mana-".$mana." WHERE id=".$player -> id);       
$db -> Execute("UPDATE players SET przemiana=przemiana+".$przemiana." WHERE id=".$player -> id);
       $db -> Execute("UPDATE players SET strength=strength+".$strength." WHERE id=".$player -> id);
       $db -> Execute("UPDATE players SET agility=agility+".$agility." WHERE id=".$player -> id);
       $db -> Execute("UPDATE players SET hp=hp+".$hp." WHERE id=".$player -> id);
       $db -> Execute("UPDATE players SET max_hp=max_hp+".$max_hp." WHERE id=".$player -> id);
       $db -> Execute("UPDATE players SET unik=unik+".$unik." WHERE id=".$player -> id);
       $db -> Execute("UPDATE players SET energy=energy-".$energia." WHERE id=".$player -> id);
error ("<br>przemieniles sie w Wilkolaka. Kliknij <a href=stats.php>tutaj</a> aby wrocic. <br><br>Skrypt wykonany przez <a href=http://www.dfstorm.xt.pl>www.dfstorm.xt.pl</a>.");

$smarty -> assign( array("Mana" =>  $player -> mana));
$smarty -> display('przemiana.tpl');
require_once("includes/foot.php");
?>
