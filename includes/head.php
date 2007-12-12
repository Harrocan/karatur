<?php  header("Content-Type: text/html; charset=ISO-8859-2"); 
/**
 *   Funkcje pliku:
 *   Plik naglowkowy strony - inicjalizacja zmiennych, panel lewy, pobranie informacji o graczu z bazy
 *
 *   @name                 : head.php
 *   @copyright            : (C) 2004-2005 Vallheru Team based on Gamers-Fusion ver 2.5
 *   @author               : thindil <thindil@users.sourceforge.net>
 *   @version              : 0.7 beta
 *   @since                : 26.01.2005
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

//setlocale( LC_ALL, 'pl_PL' );

if( !isset( $_preInit ) ) {
	$_preInit = false;
	require_once( "preinit.php" );
}

if( !$_preInit ) {
	//qDebug( "not preinited" );
	/*$do_gzip_compress = FALSE;
	$compress = FALSE;
	$phpver = phpversion();
	$useragent = (isset($_SERVER["HTTP_USER_AGENT"]) ) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;
	$start_time = microtime();
	
	
	require_once('includes/config.php');
	require_once('includes/globalfunctions.php');
	require_once('class/player.class.php');
	require_once('includes/sessions.php');
	require_once('libs/Smarty.class.php');
	
	$smarty = new Smarty;
	$smarty-> compile_check = true;
	
	//$smarty -> debugging = true;
	
	$Overfg = '#000000';
	$Overbg = '#0C1115';
	$smarty -> assign( array( "Overfg" => $Overfg, "Overbg" => $Overbg ) );
	
	$db -> LogSQL();
	set_error_handler( 'catcherror' );

	$player =& $_SESSION['player'];*/
	
	//require_once( "preinit.php" );
	
}

if( !isset( $player ) ) {
	throwError( "SESS_EXP" );
}

$script = (basename($_SERVER['SCRIPT_NAME']));
if( ( !strlen( $player->oczy ) || !strlen( $player->deity ) ) && $script != 'create.php' ) {
	header( "Location: create.php" );
}

//$oldUrl = SqlExec( "SELECT `url`, `url_time` FROM players WHERE id={$player->id}" );
//$oldUrl = array_shift( $oldUrl->getArray() );
//if( $oldUrl['url'] == $_SERVER['REQUEST_URI'] && abs( $oldUrl['url_time'] - time() ) < 10 ) {
//	SqlExec( "INSERT INTO `req_log`( `url`, `id`, `time` ) VALUES( '{$_SERVER['REQUEST_URI']}', '{$player->id}', '".time()."' )" );
//}


$ppp = SqlExec( "SELECT * FROM `views` WHERE `file`='$script'" );
$ppp = $ppp -> GetArray();
if( count( $ppp) < 1 ) {
	SqlExec( "INSERT INTO views(`file`,times) VALUES('$script',1)" );
	$pageviews = 1;
}
else {
	SqlExec( "UPDATE views SET times = times + 1 WHERE `file`='$script'" );
	$pageviews = $ppp[0]['times'] + 1;
}
$smarty -> assign( array( "Pageviews"=>$pageviews, "SourceFilename"=>basename( $_SERVER['PHP_SELF'] ) ) );





$objOpen = SqlExec("SELECT value FROM settings WHERE setting='open'");
if ($objOpen -> fields['value'] == 'N' && $player -> id != '267') {
	//$objReason = $db -> Execute("SELECT value FROM settings WHERE setting='close_reason'");
	//$smarty -> assign (array("Error" => "Przyczyna wylaczenia gry:<br />".$objReason -> fields['value'], "Gamename" => $gamename, "Meta" => ''));
	throwError( "RESET" );
	//$objReason -> Close();
	//$smarty -> display ('error.tpl');
	//exit;
}
$objOpen -> Close();


//qDebug( $fr_date );

$time = date("H:i:s");
$data = date("y-m-d");
$hour = explode(":", $time);
$day = explode("-",$data);
$newhour = $hour[0];
if ($newhour > 23) {
    $newhour = $newhour - 24;
    $day[2] = $day[2]+1;
}
$arrtime = array($newhour, $hour[1], $hour[2]);
$arrdate = array($day[0], $day[1], $day[2]);
$newtime = implode(":",$arrtime);
$newdata = implode("-",$arrdate);
$arrtemp = array($newdata, $newtime);
$newdate = implode(" ",$arrtemp);
//$pas = $_SESSION['pass'];
//$stat = $db -> Execute("SELECT id, email, ip FROM players WHERE email='".$_SESSION['email']."' AND pass='".$pas."'");

//if (empty ($stat -> fields['id'])) {
//    $smarty -> assign (array("Error" => "Nie ma takiego gracza.", "Gamename" => $gamename, "Meta" => ''));
//    $smarty -> display ('error.tpl');
//    exit;
//}

$ctime = time();
//$db -> Execute("UPDATE players SET lpv="$ctime." WHERE id=".$stat -> fields['id']);
$ip = $_SERVER['REMOTE_ADDR'];
$title = strip_tags($title);
//$db -> Execute("UPDATE players SET ip='".$ip."' WHERE id=".$stat -> fields['id']);
	//$db -> Execute("UPDATE players SET page='".$title."', ip='".$ip."', lpv=".$ctime." WHERE id=".$stat -> fields['id']);
//$player -> SetArray( array( 'page' => $title, 'ip' => $ip, 'lpv' => $ctime ) );
$player -> page = $title;
$player -> ip =$ip;
$player -> lpv = $ctime;
//SqlExec( "UPDATE players SET `url` = '{$_SERVER['REQUEST_URI']}', `url_time`='".time()."' WHERE id={$player->id}" );

//pora
 $godzina = date("H:i:s");
if($godzina <= 4) $pora = 'Noc';
elseif($godzina <= 8) $pora = 'Poranek';
elseif($godzina <= 11) $pora = 'Przedpo³udnie';
elseif($godzina == 12) $pora = 'Po³udnie';
elseif($godzina <= 18) $pora = 'Popo³udnie';
elseif($godzina == 19) $pora = 'Wieczór';
elseif($godzina <= 21) $pora = 'Pó¼ny wieczor';
else $pora = 'Noc';
$smarty -> assign (array ("Godzina", $godzina, "Pora" => $pora));

require_once( "class/harptos.class.php" );
$hp = new HarptosCalendar( time() );

$fr_date = "obecnie jest " . strtolower( $pora ) . ", " . $hp->getDayOfMonth() . " " . $hp->getMonthName() . " roku " . $hp->getYear() . ", " . date( 'z' ) . " dzieñ roku " . $hp->getYearName();
//if ($player -> graphic != '') {
//    $smarty -> template_dir = "./templates/".$player -> graphic;
//    $smarty -> compile_dir = "./templates_c/".$player -> graphic;
//}
//else {
$smarty -> template_dir = './templates';
$smarty -> compile_dir = './templates_c';
//}


$expn = expnext( $player -> level );
//$pct = (($player -> exp / $expn) * 100);
//$pct = round($pct,"0");
$query = $db -> Execute("SELECT COUNT(*) AS amount FROM players WHERE refs=".$player -> id);
$ref = $query -> fields['amount'];
$query -> Close();

$query = $db -> Execute("SELECT COUNT(*) AS amount FROM log WHERE unread='F' AND owner=".$player -> id);
$numlog = $query -> fields['amount'];
$query -> Close();

if(!isset($_SESSION['location']))
	$_SESSION['location']=$player->location;
if(!isset($_SESSION['file']))
	$_SESSION['file'] = $player->file;

//$cape = $db -> Execute("SELECT power FROM equipment WHERE owner=".$player -> id." AND type='Z' AND status='E'");
//$maxmana = ($player -> inteli + $player -> wisdom);
//$maxmana = $maxmana + (($cape -> fields['power'] / 100) * $maxmana);
//$cape -> Close();

if( isset( $js_onLoad ) ) {
	$smarty->assign( "Js_onLoad", $js_onLoad );
};

$smarty -> assign (array ("Time" => $newtime,
"Date" => $newdate,
"Title" => $title,
"Name" =>  $player -> user,
"Id" => $player -> id,
"Level" => $player -> level,
"Exp" => $player -> exp,
"Expneed" => $expn,
//"Percent" => $pct,
"Avatar" => $player -> avatar,
"Health" => $player -> hp,
"Deity" => $player -> deity,
"Maxhealth" => $player -> hp_max,
"Mana" => $player -> mana,
"Maxmana" => $player -> mana_max,
"Energy" => $player -> energy,
"Maxenergy" => $player -> energy_max,
"Gold" => $player -> gold,
"Bank" => $player -> bank,
"Mithril" => $player -> mithril,
"Referals" => $ref,
"Numlog" => $numlog,
"Style" => $player -> style,
"Gamename" => $gamename,
"Klasa" => $player -> clas,
"Hospital" => '',
"Battle" => '',
"Tribe" => '',
"Lbank" => '',
"Special" => '',
"Tforum" => '',
"Spells" => '',
"Location" => '',
"FrDate" => $fr_date,
"Display_pagetitle" => $KT_CONFIG['display']['page_title'] ) );

if ($player -> race == 'Wampir')
{
	$smarty -> assign (array ("Krewka" => $player -> krew,
					   		  "Krewka_m" => $player -> max_krew));
}

if( $player -> clas != 'Barbarzynca' ) {
    $smarty -> assign ("Spells", "1");
}
else {
	$smarty -> assign ("Spells", "0");
}
if( $player -> tribe_id)  {
	$smarty -> assign ("Tribe", '1');
}
else {
	$smarty -> assign ("Tribe", '0');
}

if ($player -> location == 'Portal') {
    $smarty -> assign ("Location", "- <a href=\"portal.php\">Portal</a>");
}
$unread = SqlExec("SELECT COUNT(*) AS amount FROM mail WHERE owner={$player->id} AND new='Y' AND `type` IN( 'msg', 'syst', 'ann' )");
$smarty -> assign ("Unread", $unread -> fields['amount'] );
$unread -> Close();

if($_SESSION['rank']['form']=='1')  {
	$test=$db->Execute("SELECT id FROM zgloszenia WHERE solve='N'");
	$smarty->assign("Formlink",'- <a href="zgloszenia.php">Zg³oszenia</a>('.($test->RecordCount()).')<br>');
}

$res = SqlExec( "SELECT COUNT(*) AS amount FROM bugtrack WHERE `new`='Y'" );
$numbugs = $res -> fields['amount'];
$smarty -> assign( "Numbugs", $numbugs );
$res -> Close();

$pl = SqlExec("SELECT COUNT(id) AS amount FROM players WHERE page='chat' AND lpv > ".( time() - 180 ) );
//print_r( $pl );
$numoc = $pl -> fields['amount'];
$smarty -> assign ("Players", $numoc);

$warn='';
// $done = array( 'alchemik.php', 'ap.php', 'core.php', 'deity.php', 'explore.php', 'turnfight.php', 'funkcje.php', 'farm.php', 'stats.php', 'equip.php', 'zloto.php', 'czary.php', 'panel.php', 'shop.php', 'grid.php', 'hospital.php', 'hotel.php', 'house.php', 'stats.php', 'wieza.php', 'praca.php', 'warehouse.php', 'vote.php', 'msklep.php', 'updates.php', 'items.php', 'plany.php', 'kowal.php', 'lumbermill.php', 'market.php', 'pmarket.php', 'imarket.php', 'jail.php', 'hmarket.php', 'tribes.php', 'tribeware.php', 'tribearmor.php', 'school.php', 'outposts.php', 'mail.php', 'log.php', 'sklepy.php', 'mapa.php', 'urzad.php', 'ogl.php', 'ogloszenia.php', 'ziemniaki.php', 'kuchnia.php', 'ashop.php' );
// if( FALSE === array_search( $script, $done ) ) {
// 	$warn .= "UWAGA ! Ten plik <b>$script</b> nie zostal jeszcze najprawdopodobniej przystosowany do nowej klasy Player. Mozliwe ze jesli cos zrobisz/wykonasz w tym miejscu - nie zauwazysz roznicy(jakbys tego nie zrobil). Mozliwe sa takze inne nieprzewidziane zachowania gry. Odradza sie robienie czegokolwiek tutaj !<br>Jest takze mozliwe ze w tym pliku nie trzeba bylo zadnych poprawek gdyz plik ten nie ma nic wspolnego z klasa Player [tyczy sie to takich plikow jak pliki miast, log.php, mail.php]<br>";
// }
$info='';
if($player->newbie=='Y')
	$warn.='Witaj na Kara-Tur<br>Zapoznaj siê ze <a href="help.php?help=new">zmianami</a><BR>';
if($player->id=='2') {
	$info="<a href=kovu.php>Link</a> do stronki Kovu :P";
	$smarty->assign("Info",$info);
}

$tops = SqlExec( "SELECT * FROM toplista_entries" );
$tops = $tops->GetArray();
//qDebug( print_r( $tops, true ) );
$smarty->assign( "Tops", $tops );

$smarty -> assign( array( "Warn"=>$warn, 'Info'=>$info ) );

$widgets = SqlExec( "SELECT * FROM modules WHERE checked=1 AND `type`='sidebar'" );
$widgets = $widgets -> GetArray();


$smarty -> display ('header.tpl');

//$parts = explode( "?", "file.php" );
//if( !is_array( $parts ) ) {
//	$parts = array( $parts );
//}
//if( count( $parts ) <= 1 ) {
//	$parts[] = '';
//}
//$tmp2 = array_combine( array( 'path', 'query' ) , $parts );
////$tmp2 = array_combine( array( 'path', 'query' ) , explode( "?", "file.php" ) );
//var_dump( $tmp2 );
////if( !is_array( $tmp2['query'] ) ) {
////	$tmp2['query'] = array( $tmp2['query'] );
////}
//echo "-----{$tmp2['path']} :: {$tmp2['query']}<br/>\n";
//parse_str( $tmp2['query'], $query );
//qDebug( $query );
//kt_url_rewriter_city_add_var( 'page', $_GET['page'] );
//kt_url_rewriter_city_add_var( 'tmp', 1 );
//$vars = kt_url_rewriter_city_get_vars();
//$diff = array_diff_key( $vars, $query );
//if( !empty( $diff ) ) {
//	$query = $query + $diff;
//}
//qDebug( $query );

/*
if ($player -> fight != 0 && $title !="Arena Walk" && $title !="Poszukiwania" && $title!='Scieki') {
    $db -> Execute("UPDATE players SET hp=0 WHERE id=".$player -> id);
    $db -> Execute("UPDATE players SET fight=0 WHERE id=".$player -> id);
    error ("Kiedy probowales uciec przez plot areny, potwor dopadl ciebie. Poczules na karku jego oddech i to byla ostatnia rzecz jaka pamietasz");
}*/
/*
if ($player -> fight != 0 && $title !="Arena Walk" && $player -> location == 'Wir') {
    $db -> Execute("UPDATE players SET hp=0 WHERE id=".$player -> id);
    $db -> Execute("UPDATE players SET fight=0 WHERE id=".$player -> id);
    error ("Kiedy probowales uciec przez plot basenu, potwor dopadl ciebie. Poczules na karku jego oddech i to byla ostatnia rzecz jaka pamietasz");
}

if ($player -> fight != 0 && $title !="Arena Walk" && $player -> location == 'Cormanthor') {
    $db -> Execute("UPDATE players SET hp=0 WHERE id=".$player -> id);
    $db -> Execute("UPDATE players SET fight=0 WHERE id=".$player -> id);
    error ("Kiedy probowales wspiac sie na drzewo, ale potwor dopadl ciebie. Poczules na karku jego oddech i to byla ostatnia rzecz jaka pamietasz");
}
*/

?>

