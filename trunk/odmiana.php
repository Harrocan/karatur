<?php
//Skrypt wykonanany przez Kiddy'ego
$title = "Przemiana";
require_once("includes/head.php");
if ($player -> level < 5) {
	error ("Musisz miec 5 lvl aby przemienic sie w Wilkolaka!"); //opcja pozwalajaca przemiane od 5 lvl
}
if ($player -> klasa == "Druid") {
	error ("Tylko Druid moze sie odmieniac");  //opcja pozwalajaca przemiane tylko dla druida
}
if ($player -> przemiana < 1) {
	error ("Jestes juz czlowiekiem"); //opcja obliczajaca czy jestes juz przemieniony
}

$strength = 10; //opcja dodajaca sile
$agility = 7;     //opcja dodajaca zrecznosc
$hp = 9;   //opcja dodajaca zycie
$max_hp = 9; //opcja dodajaca max_zycie
$unik = 4;   //opcja dodajaca uniki
$energia = 10;  //opcja dodajaca energie
$przemiana = 1;   //opcja dodajaca uniki

$player -> przemiana -= $przemiana;
$player -> str = $player -> GetAtr( 'str', TRUE ) - $strenght;
$player -> hp = $player -> GetMisc( 'hp', TRUE ) - $hp;
$player -> dex = $player -> GetAtr( 'dex', TRUE ) - $agility;
$player -> hp_max = $player ->GetMisc( 'hp_max', TRUE ) - $max_hp;
$player -> miss = $player -> GetSkill( 'miss', TRUE ) - $unik;
$player -> energy -= $energia;
//$db -> Execute("UPDATE players SET przemiana=przemiana-".$przemiana." WHERE id=".$player -> id);
//$db -> Execute("UPDATE players SET strength=strength-".$strength." WHERE id=".$player -> id);
//$db -> Execute("UPDATE players SET agility=agility-".$agility." WHERE id=".$player -> id);
//$db -> Execute("UPDATE players SET hp=hp-".$hp." WHERE id=".$player -> id);
//$db -> Execute("UPDATE players SET max_hp=max_hp-".$max_hp." WHERE id=".$player -> id);
//$db -> Execute("UPDATE players SET unik=unik-".$unik." WHERE id=".$player -> id);
//$db -> Execute("UPDATE players SET energy=energy+".$energia." WHERE id=".$player -> id);
error ("<br>Znow jestes czlowiekiem. Kliknij <a href=stats.php>tutaj</a> aby wrocic. <br><br>Skrypt wykonany przez <a href=http://www.dfstorm.xt.pl>www.dfstorm.xt.pl</a>");

$smarty -> display('przemiana.tpl');
require_once("includes/foot.php");
?>
