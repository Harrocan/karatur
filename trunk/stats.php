<?php
/**
 *   Funkcje pliku:
 *   Statystyki postaci oraz ogolne informacje o niej
 *
 *   @name                 : stats.php
 *   @copyright            : (C) 2006-2007 Kara-Tur Team based on Vallheru
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 03.01.2005
 *
 */

//
//
//       This program is free software; you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation; either version 2 of the License, or
//   (at your option) any later version.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of the GNU General Public License
//   along with this program; if not, write to the Free Software
//   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
// 



$title = "Statystyki";
require_once("includes/head.php");

// przypisanie zmiennych
$smarty -> assign(array("Avatar" => '', "Crime" => ''));

$plik = 'avatars/'.$player -> avatar;
if (is_file($plik)) {
    $smarty -> assign ("Avatar", "<center><img src=".$plik." style=\"max-width:380;max-height:300px\"></center>");
}

if ($player -> ap > 0) {
    $smarty -> assign ("Ap", $player -> ap." (<a href=ap.php>uzyj</a>)<br>");
} else {
    $smarty -> assign ("Ap", $player -> ap."<br>");
}
if ($player -> race == '') {
    $smarty -> assign ("Race", "(<a href=rasa.php>wybierz</a>)<br>");
} else {
    $smarty -> assign ("Race", $player -> race."<br>");
}
//charakter
if ($player -> charakter == '') {
    $smarty -> assign ("Charakter", "(<a href=\"stats.php?action=char\">wybierz</a>)<br>");
} else {
    $smarty -> assign ("Charakter", $player -> charakter."<br>");
}

if ($player -> clas == '') {
    $smarty -> assign ("Clas", "(<a href=klasa.php>wybierz</a>)<br>");
} else {
    $smarty -> assign ("Clas", $player -> clas."<br>");
}
if ($player -> gender == '') {
    $smarty -> assign ("Gender", "(<a href=stats.php?action=gender>wybierz</a>)<br>");
} else {
    if ($player -> gender == 'M') {
        $gender = 'Mê¿czyzna';
    } else {
        $gender = 'Kobieta';
    }
    $smarty -> assign ("Gender", $gender."<br>");
}
if ($player -> stan == '') {
    $smarty -> assign ("Stan", "(<a href=stats.php?action=stan>wybierz</a>)<br>");
} else {

  $smarty -> assign( array( "Stan" => $player -> stan."<br>"));
}
if ($player -> deity == '') {
    $smarty -> assign ("Deity", "(<a href=deity.php>wybierz</a>)<br>");
} else {
    $smarty -> assign ("Deity", $player -> deity."<br>");
}

if ($player -> race == 'Wampir') 
{
    $smarty -> assign ("Ugryz", "<b>Pozosta³e Ugryzienia:</b> ".$player->ugryz."<br />");
} 
/*
if ($player -> race == 'Wampir') 
{
    $smarty -> assign ("Krew", $player->krew."/".$player -> max_krew);
} 
*/
if ($player -> race == 'Wampir' && $player -> przemieniony_przez != '') 
{
    $smarty -> assign ("Ojciec", "Ojciec: ".przemieniony_przez."<br />");
} 
elseif ($player -> race != 'Wampir' && $player -> ugryziony >= 3)
{
 	$gr = $db -> Execute("Select user From players Where id=".$player->przez);
	$smarty -> assign ("Ojciec", "Ojciec: <a href=stats.php?przemien=".$player->przez.">Wybierz na ojca: ".$gr->fields['user']."</a><br />");
} 


if ($player -> wlos == '') {
    $smarty -> assign ("Wlos", "(<a href=stats.php?action=wlos>wybierz</a>)<br>");
} else { 
  
  $smarty -> assign( array( "Wlos" => $player -> wlos."<br>"));
}
if ($player -> skora == '') {
    $smarty -> assign ("Skora", "(<a href=stats.php?action=skora>wybierz</a>)<br>");
} else { 
  
  $smarty -> assign( array( "Skora" => $player -> skora."<br>"));
}
if ($player -> oczy == '') {
    $smarty -> assign ("Oczy", "(<a href=stats.php?action=oczy>wybierz</a>)<br>");
} else { 
  
  $smarty -> assign( array( "Oczy" => $player -> oczy."<br>"));
}
 //pocho
if ($player -> poch == '') {
    $smarty -> assign ("Poch", "(<a href=stats.php?action=poch>wybierz</a>)<br>");
} else {
    $smarty -> assign ("Poch", $player -> poch."<br>");
}
$smarty -> assign( array("Agility" => $player -> dex."<br />", 
    "Strength" => $player -> str."<br />", 
    "Int" => $player -> int."<br />", 
    "Wisdom" => $player -> wis."<br />", 
    "Speed" =>  $player -> spd."<br />", 
    "Cond" =>  $player -> con."<br />", 
    "Mana" =>  $player -> mana, 
    "Location" => $player -> location."<br />", 
    "Age" => $player -> age."<br />", 
    "Logins" => $player -> logins."<br />", 
    "Ip" => $player -> ip."<br />", 
    "Email" => $player -> email."<br />", 
    "Smith" => $player -> smith."<br />", 
    "Alchemy" => $player -> alchemy."<br />", 
    "Fletcher" => $player -> fletcher."<br />", 
    "Attack" => $player -> melee."<br />", 
    "Shoot" => $player -> ranged."<br />", 
    "Miss" => $player -> miss."<br />", 
	"Gotowanie" => $player -> cook."<br />",
    "Magic" => $player -> cast."<br />",
    "Leadership" => $player -> leadership."<br />",
    "Krew" => $player -> krew));
//$cape = $db -> Execute("SELECT power FROM equipment WHERE owner=".$player -> id." AND type='Z' AND status='E'");
//$maxmana = ($player -> inteli + $player -> wisdom);
//$maxmana = $maxmana + (($cape -> fields['power'] / 100) * $maxmana);
//$cape -> Close();
if ($player -> mana < $player -> mana_max) {
    $smarty -> assign ("Rest", "[<a href=rest.php>Odpocznij</a>]<br>");
} else {
    $smarty -> assign ("Rest", "<br>");
}
$smarty -> assign ("PW", $player -> faith."<br>");
if ($player -> clas == "Zlodziej") {
    $smarty -> assign ("Crime", "<b>Ilosc kradziezy:</b> ".$player -> crime."<br>");
}

$rt = ($player -> wins + $player -> losses);
$smarty -> assign( array("Total" => $player -> wins."/".$player -> losses."/".$rt."<br>", "Lastkilled" => $player -> lastkilled."<br>", "Lastkilledby" => $player -> lastkilledby));

//if ($player -> rank == 'Admin') {
//    $ranga = 'Wladca Kara-Tur';
//} elseif ($player -> rank == 'Staff') {
//    $ranga = 'Ksiaze Kara-Tur';
//} elseif ($player -> rank == 'Staff') {
//    $ranga = 'Ksiaze Kara-Tur';
//} elseif ($player -> rank == 'Dowstraz') {
//    $ranga = 'Dowodca Strazy Krolewskiej';
//} elseif ($player -> rank == 'Zadmin') {
//	$ranga = 'Wynalazca';
//} else {
    $ranga = $player -> rankname;
//}
$smarty -> assign ( array("Rank" => $ranga."<br>"));
if (!empty($player-> gg)) {
    $smarty -> assign ("GG", "<b>Numer GG:</b> ".$player -> gg."<br>");
} else {
    $smarty -> assign ("GG", "");
}
//$tribe = $db -> Execute("SELECT name FROM tribes WHERE id=".$player -> tribe);
if ($player -> tribe_id) {
    $smarty -> assign ( array("Tribe" => "<a href=tribes.php?view=my>".$player -> tribe_name."</a><br>", "Triberank" => "<b>Ranga w klanie:</b> ".$player -> tribe_rank."<br>"));
} else {
    $smarty -> assign ( array("Tribe" => "brak<br>", "Triberank" => ""));
}
//$tribe -> Close();


if(isset($_GET['przemien']))
{
	if ($player->ugryziony<3 || $player->race=='Wampir')
	{
		error("Jest przykazanie nie cygañ? Jest");
	}
	$gr = $db -> Execute("Select user From players Where id=".$player->przez);
	$imie=$gr->fields['user'];
	$db -> Execute("UPDATE players SET rasa='Wampir', krew=30, ugryziony=0, ilosc_ugryz=0, ugryz=5, przez='', przemieniony_przez='".$imie."' WHERE id=".$player -> id);
	
}
//wybor charakteru
if (isset ($_GET['action']) && $_GET['action'] == 'char') {
    if ($player -> charakter) {
        error ("Masz juz wybrany charakter!");
    } else {
    if (isset ($_GET['step']) && $_GET['step'] == 'char') {
	$player -> charakter = $_POST['char'];		
//        $db -> Execute("UPDATE players SET charakter='".$_POST['char']."' WHERE id=".$player -> id);
	error ("Wybrales ".$_POST['char']." charakter.",'done');
}
}
}
//opcja kolor wlosow
if (isset ($_GET['action']) && $_GET['action'] == 'wlos') {
   if ($player -> wlos) {
       error ("Masz juz Kolor wlosow!");
   }
   if (isset ($_GET['step']) && $_GET['step'] == 'wlos') {
	$player -> wlos = $_POST['wlos'];
//       $db->Execute("update players set wlos='".$_POST['wlos']."' where id=".$player -> id);
       error ("Wybrales kolor wlosow",'done');
   }
}
//opcja kolor oczu
if (isset ($_GET['action']) && $_GET['action'] == 'oczy') {
   if ($player -> oczy) {
       error ("Masz juz Kolor oczu!");
   }
   if (isset ($_GET['step']) && $_GET['step'] == 'oczy') {
	$player -> oczy = $_POST['oczy'];
//       $db->Execute("update players set oczy='".$_POST['oczy']."' where id=".$player -> id);
       error ("Wybrales Kolor Oczu.",'done');
   }
}
//opcja kolor skory
if (isset ($_GET['action']) && $_GET['action'] == 'skora') {
   if ($player -> skora) {
       error ("Masz juz Kolor skory!");
   }
   if (isset ($_GET['step']) && $_GET['step'] == 'skora') {
//       $db->Execute("update players set skora='".$_POST['skora']."' where id=".$player -> id);
	$player -> skora = $_POST['skora'];
       error ("Wybrales Kolor Skory.",'done');
   }
}

//opcja wyboru plci
if (isset ($_GET['action']) && $_GET['action'] == 'gender') {
    if ($player -> gender) {
        error ("Masz juz wybrana plec!");
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'gender') {
        if (!isset($_POST['gender']))
        {
            error("Wybierz plec!");
        }
//        $db -> Execute("UPDATE players SET gender='".$_POST['gender']."' WHERE id=".$player -> id);
	$player -> gender = $_POST['gender'];
        error ("Wybrales plec",'done');
    }
}
//opcja wyboru stanu Cywilnego
if (isset ($_GET['action']) && $_GET['action'] == 'stan') {
    if ($player -> stan) {
        error ("Masz juz wybrany Stan!");
    }
    if (isset ($_GET['step']) && $_GET['step'] == 'stan') {
//        $db->Execute("update players set stan='".$_POST['stan']."' where id=".$player -> id);
	$player -> stan = $_POST['stan'];
        error ("Wybrales Stan Cywilny.",'done');
    }
}



if ($player -> clas == 'Druid'){
       $smarty -> assign ("Przemiana", "- <a href=\"przemiana.php\">Zmiana w Wilkolaka</a><br>");
   }

if ($player -> clas == 'Druid'){
       $smarty -> assign ("Odmiana", "- <a href=\"odmiana.php\">Odmiana z Wilkolaka</a><br>");
   }

if ($player -> tow == '') {
  $smarty -> assign ("Tow", "(<a href=tow.php>wybierz</a><br>");
} else {
  $smarty -> assign ("Tow", $player -> tow."<br>");
}
//opcja wyboru pochodzenia
if (isset ($_GET['action']) && $_GET['action'] == 'poch') {
          if (isset ($_GET['step']) && $_GET['step'] == 'poch') {
        if (!isset($_POST['poch']))
        {
            error("Nie wybra³e¶ pochodzenia !");
        }
        $city= $db->Execute("SELECT `name`,`zm_x`,`zm_y` FROM mapa WHERE file='".$_POST['poch']."'");
	if( empty( $city -> fields['name'] ) ) {
		error( "Nieprawidlowe miasto !" );
	}
	$player -> poch = $city -> fields['name'];
	$player -> mapx = $city -> fields['zm_x'];
	$player -> mapy = $city -> fields['zm_y'];
	$player -> file = $_POST['poch'];
        //$db -> Execute("UPDATE players SET poch='".$city->fields['name']."',mapx=".$city->fields['zm_x'].",mapy=".$city->fields['zm_y'].",file='".$_POST['poch']."' WHERE id=".$player -> id);
        error ("Wybrales Pochodzenie. <a href=stats.php>Odswiez</a>");
    }
}
if (isset ($_GET['action']) && $_GET['action'] == 'zmienp') {
          if (isset ($_GET['step']) && $_GET['step'] == 'zmienp') {
        
        $db -> Execute("UPDATE players SET poch='".$_POST['zmienp']."' WHERE id=".$player -> id);
        error ("Zmieniles Pochodzenie. <a href=stats.php>Odswiez</a>");
    }
	}
	
//inicjalizacja zmiennej
if (!isset($_GET['action'])) {
    $_GET['action'] = '';
}

//przypisanie zmiennej oraz wyswietlenie strony
$smarty -> assign ("Action", $_GET['action']);
$smarty -> display ('stats.tpl');

require_once("includes/foot.php");
?>

