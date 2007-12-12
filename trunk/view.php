<?php
/***************************************************************************
*                               view.php
*                            -------------------
*   copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
*   email                : thindil@users.sourceforge.net
*
***************************************************************************/

/***************************************************************************
*
*       This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with this program; if not, write to the Free Software
*   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
***************************************************************************/ 

$title = "Zobacz";
//require_once($path_base.'includes/config.php');

require_once("includes/head.php");
require_once("includes/checkexp.php");
require_once('class/playerManager.class.php');
require_once('includes/bbcode_profile.php');

if (!isset($_GET['view'])) {
	error("Zapomnij o tym!");
}

if (!ereg("^[1-9][0-9]*$", $_GET['view'])) {
	error ("Zapomnij o tym!");
}
$view = new Player($_GET['view'], TRUE);
if( $view -> created == FALSE ) {
	error ("Nie ma takiego gracza.");
}

$smarty -> assign (array("User" => $view -> user, "Id" => $view -> id,"Avatar" => '', "GG" => '', "Immu" => '', "Attack" => '', "Mail" => '', "Crime" => '', "Gender" => '', "Deity" => '', "IP" => '', 'Stan' => $view -> stan,));
$plik = 'avatars/'.$view -> avatar;
if (is_file($plik)) {
	$smarty -> assign ("Avatar", $plik);
}
else
	$smarty -> assign( "Avatar", '' );
if (!empty($view -> gg)) {
	$smarty -> assign ("GG", "Numer Gadu-Gadu: <a href=gg:".$view -> gg.">".$view -> gg."</a><br>");
}

	$ranga = $view -> rankname;

if ($view -> immu == 'Y') {
	$smarty -> assign ("Immu", "Posiada immunitet<br>");
}
$smarty -> assign ( array("Page" => $view -> page,
							"Age" => $view -> age,
							"Race" => $view -> race,
							"Charakter" => $view -> charakter,
							"Stan" => $view -> stan,
							"Clas" => $view -> clas,
							"Rank" => $ranga,
							"Location" => $view -> location,
							"Level" => $view -> level,
							"Maxhp" => $view -> hp_max,
							"Wins" => $view -> wins,
							"Losses" => $view -> losses,
							"Lastkilled" => $view -> lastkilled,
							"Lastkilledby" => $view -> lastkilledby,
							"Profile" => bbcode_profile( $view -> profile ),
							"Wlos"=> $view-> wlos,
							"Skora"=> $view-> skora,
							"Oczy"=> $view -> oczy,
							"Poch"=> $view -> poch));
if ($view -> gender) {
	if ($view -> gender == 'M') {
		$gender = 'Mezczyzna';
	} else {
		$gender = 'Kobieta';
	}
	$smarty -> assign ("Gender", $gender);
}
if (!empty ($view -> deity)) {
	$smarty -> assign ("Deity", "Wyznanie: ".$view -> deity."<br>");
}
if ($view -> hp > 0) {
	$smarty -> assign ("Status", "<b>Zywy</b><br>");
} else {
	$smarty -> assign ("Status", "<b>Martwy</b><br>");
}

//$tribe = $db -> Execute("SELECT name FROM tribes WHERE id=".$view -> tribe);
if ($view -> tribe_id && $view -> tribe_name) {
	$smarty -> assign ("Clan", "<a href=tribes.php?view=view&id=".$view -> tribe_id.">".$view -> tribe_name."</a><br>Ranga w klanie: ".$view -> tribe_rank."<br>");
} else {
	$smarty -> assign ("Clan", "brak<br>");
}
//$smarty -> assign( "Clan", $view -> tribe_name );
$query = $db -> Execute("SELECT id FROM players WHERE refs=".$view -> id);
$ref = $query -> RecordCount();
$query -> Close();
$smarty -> assign ("Refs", $ref);
if ($player -> location == $view -> location && $view -> immu == 'N' && $player -> immu == 'N' && $player -> id != $view -> id) {
	$smarty -> assign ("Attack", "<li><a href=battle.php?battle=".$view -> id.">Atak</a></li>");
}
if ($player -> id != $view -> id) {
	$smarty -> assign ("Mail", "<li><a href=mail.php?view=write&to=".$view -> id.">Napisz wiadomosc</a></li>");
}
if ($player -> clas == 'Zlodziej' && $player -> crime > 0 && $player -> location == $view -> location && $player -> id != $view -> id) {
	$smarty -> assign ("Crime", "<li><a href=view.php?view=".$view -> id."&steal=".$view -> id.">Kradziez kieszonkowa</a></li>");
}

if ($player -> race == 'Wampir' && $player -> ugryz > 0 && $player -> location == $view -> location && $player -> id != $view -> id && $view -> race != 'Wampir' && $view->ilosc_ugryz<1) 
{
	$smarty -> assign ("Ugryz", "<li><a href=view.php?view=".$view -> id."&gryz=".$view -> id.">Ugryz</a></li>");
}
elseif($player -> race == 'Wampir' && $player -> ugryz > 0 && $player -> location == $view -> location && $player -> id != $view -> id && $view -> race != 'Wampir')
{
	$smarty -> assign ("Ugryz", "<li>Postaæ zosta³a juz ugryziona</li>");
}
elseif($player -> race == 'Wampir' &&  $player -> jail =='Y')
{
	$smarty -> assign ("Ugryz", "<li>Podczas pobytu w lochach nie mozesz grysc</li>");
}

if ($view -> przemieniony_przez != '' && $view -> race == 'Wampir') {
	$smarty -> assign ("Ojciec", "<b>Ojcem tego Wampira jest:</b>".$view -> przemieniony_przez);
}

//if ($player -> rank == 'Admin' || $player -> rank == 'Staff') {
//    $smarty -> assign ("IP", "IP gracza: ".$view -> ip);
//}




if (isset ($_GET['steal'])) {
	if (!ereg("^[1-9][0-9]*$", $_GET['steal'])) {
		error ("Zapomnij o tym!");
	}
	if ($_GET['steal'] != $_GET['view']) {
		error ("Zdecyduj sie kogo chcesz okrasc!");
	}
	if ($player -> crime <= 0) {
		error ("Nie mozesz probowac kradziezy kieszonkowej, poniewaz niedawno probowales juz swoich sil!");
	}
	if ($player -> location != $view -> location) {
		error ("Nie mozesz okradac gracza, ktory nie jest w tej samej lokacji co ty!");
	}
	if ($view -> hp <= 0) {
		error ("Nie mozesz okradac martwych!");
	}
	if ($player -> hp <= 0) {
		error ("Nie mozesz okradac innych poniewaz jestes martwy");
	}
	if ($player -> immu == 'Y') {
		error("Nie mozesz okradac innych graczy poniewaz posiadasz immunitet");
	}
	if ($view -> immu == 'Y') {
		error("Nie mozesz okradac gracza, ktory posiada immunited");
	}
    if ($player -> jail =='Y') {
      error ("Nie mozesz krasc poniewaz siedzisz w wiezieniu ");
    }
    if ($view -> jail == 'Y') {
      error ("Nie mozesz okradac kogos kto siedzi w wiezieniu");
    }
	$roll = rand (1, $view -> level);
	$chance = ($player -> agility + $player -> inteli) - ($view -> agility + $view -> inteli + $roll);
	$victim = new playerManager( $view->id );
	if ($chance < 1) {
		$cost = 1000 * $player -> level;
		$expgain = ceil($view -> level / 10);
		//checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
		$player -> AwardExp( $expgain );
		if ($player -> jail != 'Y') {
			//$db -> Execute("UPDATE players SET miejsce='Lochy' WHERE id=".$player -> id);
			$player -> jail == 'Y';
			//$db -> Execute("UPDATE players SET crime=crime-1 WHERE id=".$player-> id);
			$Player -> crime --;
			$insert = SqlExec("INSERT INTO jail (prisoner, verdict, duration, cost, data) VALUES(".$player -> id.",'Proba okradzenia mieszkanca KaraTur',1,".$cost.",'".$newdata."')") ;
			$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$player -> id.",'Zostales wtracony do wiezienia na 1 dzien za probe okradzenia gracza. Mozesz wyjsc z wiezienia za kaucja: ".$cost.".','".$newdate."')");
			$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$view -> id.",'Kiedy wedrowales sobie spokojnie poczules nagle ze ktos grzebie ci przy sakiewce. To <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID: ".$player -> id.". Szybko pochwyciles jego reke i przekazales straznikom.','".$newdate."')");
			
			SqlExec( "INSERT INTO akta ( pid, name, dur, data, reason, cela, cost ) VALUES ({$player->id} , '{$player->user}', 1, '{$newdate}', 'Proba okradzenia mieszkanca KaraTur', $insert, $cost );");
			$skaz = SqlExec("SELECT name FROM skazani WHERE id={$player->id};");
			if( !empty( $skaz -> fields['name'] ) ) {
				SqlExec("UPDATE skazani SET ilosc=ilosc+1 WHERE id={$player->id};");
			}
			else {
				SqlExec("INSERT INTO skazani (id, name, ilosc) VALUES ({$player->id} ,'{$player->user}', 1);");
			}
			
			error ("<br>Kiedy siegales do sakiewki mieszkanca, ten zauwazyl twoj ruch. Szybko zlapal ciebie za nadgarstek i wezwal straz. Obrot spraw tak ciebie zaskoczyl iz zapomniales nawet zareagowac w jakis sposob. I tak oto znalazles sie w lochach!");
		} else {
			$db -> Execute("insert into log (owner, log, czas) VALUES(".$view -> id.",'Kiedy siedziales sobie spokojnie w celi poczules nagle ze twoj wspolokator grzebie ci przy sakiewce. To <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID: ".$player -> id.".','".$newdate."')");
			$player -> crime --;
			error ("<br>Probowales okrasc wspolwieznia ale niestety nie udalo ci sie");
			//$db -> Execute("UPDATE players SET crime=crime-1 WHERE id=".$player-> id);	        
		}
	}
	if ($chance > 0 && $chance < 50) {
		//$db -> Execute("UPDATE players SET crime=crime-1 WHERE id=".$player -> id);
		$player -> crime --;
		if ( $view -> credits > 0) {
			$lost = ceil($view -> credits / 10);
			$expgain = $view -> level;
			//checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
			$player -> AwardExp( $expgain );
			$victim->addRes( 'gold', "-$lost" );
//			SqlExec("UPDATE resources SET gold=gold-".$lost." WHERE id=".$view -> id);
//			PutSignal( $view -> id, 'res' );
			//$db -> Execute("UPDATE players SET credits=credits+".$lost." WHERE id=".$player -> id);
			$player -> gold += $lost;
			$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$view -> id.",'Kiedy wedrowales sobie spokojnie poczules nagle ze ktos grzebie ci przy sakiewce. To <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID: ".$player -> id.". Probowales go zlapac, niestety wyrwal ci sie wraz z twoimi ".$lost." sztukami zlota.','".$newdate."')");
			error ("<br>Kiedy siegales do sakiewki mieszkanca, ten zauwazyl twoj ruch. Szybko zlapal ciebie za nadgarstek, na szczescie zdazyles sie wyswobodzic i uciec wraz z ".$lost." sztukami zlota. Niestety ow mieszkaniec zapamietal ciebie...");
		} else {
			$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$view -> id.",'Kiedy wedrowales sobie spokojnie poczules nagle ze ktos grzebie ci przy sakiewce. To <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID: ".$player -> id.". Probowales go zlapac, niestety wyrwal ci sie. Ciekawe czy mocno sie zdziwi kiedy zauwazy, ze nie miales w sakiewce ani grosza','".$newdate."')");
			error ("<br>Kiedy siegales do sakiewki mieszkanca, ten zauwazyl twoj ruch. Szybko zlapal ciebie za nadgarstek, na szczescie zdazyles sie wyswobodzic i uciec. Kiedy zajrzales do sakiewki, omal krew cie nie zalala - tyle klopotow z powodu pustej sakiewki!");
		}
	}
	if ($chance > 49) {
		//$db -> Execute("UPDATE players SET crime=crime-1 WHERE id=".$player -> id);
		$player -> crime --;
		if ( $view -> credits > 0) {
			$lost = ceil($view -> credits / 10);
			$expgain = ceil($view -> level * 10);
			$victim->addRes( 'gold', "-$lost" );
            //SqlExec("UPDATE resources SET gold=gold-".$lost." WHERE id=".$view -> id);
			//PutSignal( $view -> id, 'res' );
			//$db -> Execute("UPDATE players SET credits=credits+".$lost." WHERE id=".$player -> id);
			$player -> gold += $lost;
			//checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
			$player -> AwardExp( $expgain );
			$db -> Execute("INSERT INTO into log (owner, log, czas) VALUES(".$view -> id.",'Wedrowales sobie spokojnie, kiedy pewne niejasne przeczucie powiedzialo ci, ze cos jest nie w porzadku. Przygladajac sie uwaznie sobie, zauwazasz iz brakuje ci sakiewki wraz z ".$lost." sztukami zlota. Ktos cie okradl!','".$newdate."')");
			error ("<br>Ostroznie manipulujac przy sakiewce ofiary, udalo ci sie nieco ja odchudzic. Nieprzyuwazony przez nikogo spokojnie oddalasz sie. Dopiero po pewnym czasie dokladnie przeliczasz swoj zarobek - to ".$lost." sztuk zlota.");
		} else {
			$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$view -> id.",'Wedrowales sobie spokojnie, kiedy pewne niejasne przeczucie powiedzialo ci, ze cos jest nie w porzadku. Przygladajac sie uwaznie sobie, zauwazasz iz brakuje ci sakiewki. Ktos cie okradl! Zastanawiasz sie, na co mu byla pusta sakiewka','".$newdate."')");
			error ("<br>Ostroznie zabierajac sakiewke ofierze, odchodzisz. Jednak wydaje ci sie ona podejrzanie lekka. Kiedy przygladasz sie jej, zauwazasz ze jest pusta. To chyba nie jest twoj najlepszy dzien...");
		}
	}
}


if (isset ($_GET['gryz'])) 
{
	if (!ereg("^[1-9][0-9]*$", $_GET['gryz'])) {
		error ("Co chczesz zrobiæ??");
	}
	if ($_GET['gryz'] != $_GET['view']) {
		error ("Zdecyduj sie kogo chcesz ugryœæ!");
	}
	if ($player->race != 'Wampir') {
		error ("A ty wampir??");
	}
	if ($view->race == 'Wampir') {
		error ("Wampira nie mozna gryœæ");
	}
	if ($player->ugryz <=0)
	{
		error("czym chcesz grysc nie masz pkt gryzienia");
	}
	if ($view->ilosc_ugryz>0)
	{
		error("nie mozesz gryœæ pogryzionego?!");
	}
	if ($player -> jail =='Y') {
		error ("Nie mozesz grysc poniewaz siedzisz w wiezieniu ");
	}
	if ($view -> jail == 'Y') {
		error ("Nie mozesz ugrysc kogos kto siedzi w wiezieniu");
	}
	if ($player -> location != $view -> location) {
		error ("Nie mozesz ugrysc gracza, ktory nie jest w tej samej lokacji co ty!");
	}
	if ($player -> jail == 'Y') {
		error ("jesteœ w lochu i gryziesz szczury wiec jesteœ najedzony ");
	}
	if ($view -> hp <= 0) {
		error ("Nie mozesz gryœæ martwych!");
	}
	if ($player -> hp <= 0) {
		error ("Nie mozesz gryœæ innych poniewaz jestes martwy");
	}
	if ($player -> immu == 'Y') {
		error("Nie mozesz gryœæ innych graczy poniewaz posiadasz immunitet");
	}
	if ($view -> immu == 'Y') {
		error("Nie mozesz grysc gracza, ktory posiada immunited");
	}
	if ($view -> hp < $view -> hp_max/2) {
		error("Gracz nie jest dobrym lupem");
	}
	
	$roll = rand (1, $view -> level);
	$szansa = rand (1, 100);
	$kr= rand(-1,3);
	$str = rand(2,6);
	$str2 = rand($str,8);
	$exp = rand(0,10);
	$exp2 = rand(0,10);
	$proc=rand(1,5);
	$chance = (1/2*$player -> dex + $player -> str) - ($view -> str + $view -> spd + $roll);
	
	$cost = 1500 * $player -> level;
	
	$expgain = ceil(($view -> level+$exp)/(10+$exp2));
	$expgain2 = ceil(($view -> level+$exp)/(10+$exp2+$str));
	$expup = ceil($view -> level *10);

	$strata = ceil($view->hp/$str);
	$strata2 = ceil($view->hp/$str2);

	$krew = $view->level/2;
		if ($krew >5)
		{
			$krew = 5 +$kr;
		}
		elseif ($krew <1)
		{
			$krew =1 +$kr;
		}
		else
		{
			$krew = $player->level/2 +$kr;
		}  
		
	if ($player->hp+$strata>$player->hp_max)
	{
		$strata = $player->hp_max-$player->hp;
	}
	if ($player->hp+$strata2>$player->hp_max)
	{
		$strata2 = $player->hp_max-$player->hp;
	}
	if($view ->hp-$strata2<5)
	{
		$strata2 = $view ->hp-$strata2;
	}
	if($view ->hp-$strata2<5)
	{
		$strata = $view ->hp-$strata;
	}
	
		
	if ($player->max_krew - $krew <0)
	{
		$krew = $player->max_krew - $player->krew;
	} 
	
	$prog = 1;
	if( $view -> ilosc_ugryz == 2 ) 
	{
		$prog = 50;
	}
	if( $view -> ilosc_ugryz > 2 ) 
	{
		$prog = 100;
	}
		
if ($chance < 1 && $szansa<=100-$proc)
	{
			//$db -> Execute("UPDATE players SET jail='Y' WHERE id=".$player -> id);
			$player -> jail = 'Y';
			//$db -> Execute("UPDATE players SET ugryz=ugryz-1, krew=krew-1, miejsce='Lochy' WHERE id=".$player-> id);
			$player -> ugryz --;
			$player -> krew --;
			$insert = SqlExec("INSERT INTO jail (prisoner, verdict, duration, cost, data) VALUES(".$player -> id.",'Proba ugryzienia mieszkañca',1,".$cost.",'".$newdata."')");
			
			SqlExec( "INSERT INTO akta ( pid, name, dur, data, reason, cela, cost ) VALUES ({$player->id} , '{$player->user}', 1, '{$newdate}', 'Proba ugryzienia mieszkanca KaraTur', $insert, $cost );");
			$skaz = SqlExec("SELECT name FROM skazani WHERE id={$player->id};");
			if( !empty( $skaz -> fields['name'] ) ) {
				SqlExec("UPDATE skazani SET ilosc=ilosc+1 WHERE id={$player->id};");
			}
			else {
				SqlExec("INSERT INTO skazani (id, name, ilosc) VALUES ({$player->id} ,'{$player->user}', 1);");
			}
			
			$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$player -> id.",'Zostales wtracony do wiezienia na 1 dzien za probe ugryzienia gracza. Mozesz wyjsc z wiezienia za kaucja: ".$cost.".','".$newdate."')");
			$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$view -> id.",'Pocalunek Wampira<br><br>Kiedy spokojnie przechadza³eœ siê ulicami nagle poczu³eœ na szyji czyjœ oddech odwruci³eœ siê i to cie uratowa³o przed ugryzieniem by³ to <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID: ".$player -> id.". Szybko pochwyciles jego g³owê, postraszy³eœ œwiat³em i przekazales straznikom.','".$newdate."')");
			error ("<br>Kiedy to sobie spokojnie chcia³eœ wypiæ krew z mieszkañca ten to zauwarzy³ i trafi³eœ do lochów"); 
	}
elseif($chance < 1 && $szansa>100-$proc && $szansa<=100)
	{
		//checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
		$player -> AwardExp( $expgain );
		$player -> ugryz --;
		$player -> krew += $krew;
		$player -> hp += $strata2;
		//$db -> Execute("UPDATE players SET ugryz=ugryz-1, krew=krew+'".$krew."', hp=hp+'".$strata2."' WHERE id=".$player-> id);
		
		if ($view->przez != $player->id)
		{
			$db -> Execute("UPDATE players SET ugryziony=1, hp=hp-'".$strata."', przez='".$player->id."', ilosc_ugryz=ilosc_ugryz+1 WHERE id=".$view-> id);
			PutSignal( $view -> id, 'misc' );
		}
		else
		{
			$db -> Execute("UPDATE players SET ugryziony=ugryziony+1, hp=hp-'".$strata."', ilosc_ugryz=ilosc_ugryz+1, przez='".$player->id."' WHERE id=".$view-> id);
			PutSignal( $view -> id, 'misc' );
		}
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$player -> id.",'Mimo ¿e przeciwnik by³ du¿o mozniejszy od ciebie zorientowa³ siê ¿e chcesz go ugryœc dopiero jak mia³ wbite k³y w szyje - szybko wypi³eœ co swoje i odszed³eœ - zyskujesz ".$strata2."hp oraz ".$krew." krwi','".$newdate."')");
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$view -> id.",'Kiedy spokojnie przechadza³eœ siê ulicami nagle poczu³eœ na szyji uk³ucie i pochwili le¿a³eœ jak k³oda,By³ to wampir imieniem <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID: ".$player -> id.", pochwyci³eœ go ostatnimi si³¹mi lecz ten zdo³a³ zbiec - tracisz ".$strata." hp','".$newdate."')");
	
		if ($krew>=1) {
			error ("<br>Mimo znacznej przewagi przeciwnika uda³o ci siê go ugryœæ i wyjœæ po obfitym posi³ku choæ mog³eœ bardziej siê najeœæ - zyskujesz ".$strata2."hp oraz ".$krew." krwi");
		}
		else {
			error ("<br>Mimo ¿e ugryz³eœ i coœ zjad³eœ to by³o zama³o aby sie najeœæ nic krwi nie zyskujesz");	
		}
	}

/*2 gryz*/

if ($chance < 50 && $szansa<=100-$proc)
	{
		//checkexp($player -> exp,$expgain,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
		$player -> AwardExp( $expgain );
		//$db -> Execute("UPDATE players SET ugryz=ugryz-1, krew=krew+'".$krew."', hp=hp+'".$strata2."' WHERE id=".$player-> id);
		$player -> ugryz --;
		$player -> krew += $krew;
		$player -> hp += $strata;
		if ($view->przez != $player->id)
		{
			$db -> Execute("UPDATE players SET ugryziony=1, hp=hp-'".$strata."', przez='".$player->id."', ilosc_ugryz=ilosc_ugryz+1 WHERE id=".$view-> id);
			PutSignal( $view -> id, 'misc' );
		}
		else
		{
			$db -> Execute("UPDATE players SET ugryziony=ugryziony+1, hp=hp-'".$strata."', ilosc_ugryz=ilosc_ugryz+1 WHERE id=".$view-> id);
			PutSignal( $view -> id, 'misc' );
		}
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$player -> id.",'By³es silniejszy i mimo oporu uda³o ci siê ugryœæ gracza- zyskujesz ".$strata2."hp oraz ".$krew." krwi','".$newdate."')");
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$view -> id.",'Kiedy spokojnie przechadza³eœ siê ulicami nagle poczu³eœ na szyji uk³ucie i pochwili le¿a³eœ jak k³oda,By³ to wampir imieniem <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID: ".$player -> id.", pochwyci³eœ go ostatnimi si³¹mi lecz ten zdo³a³ zbiec - tracisz ".$strata."hp ','".$newdate."')");
	
		if ($krew>=1)
		{
		error ("<br>Mimo znacznej przewagi przeciwnika uda³o ci siê go ugryœæ i wyjœæ po obfitym posi³ku choæ mog³eœ bardziej siê najeœæ - zyskujesz ".$strata2."hp oraz ".$krew." krwi");
		}
		else
		{
		error ("<br>Mimo ¿e ugryz³eœ i coœ zjad³eœ to by³o zama³o aby sie najeœæ nic krwi nie zyskujesz");	
		}
	}
elseif ($chance < 50 && $szansa>100-$proc && $szansa<=100)
	{
		//$db -> Execute("UPDATE players SET jail='Y' WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET ugryz=ugryz-1, krew=krew-1, miejsce='Lochy' WHERE id=".$player-> id);
		$player -> jail ='Y';
		$player -> ugryz --;
		$player -> krew --;
		$insert = SqlExec("INSERT INTO jail (prisoner, verdict, duration, cost, data) VALUES(".$player -> id.",'Proba ugryzienia mieszkañca',1,".$cost.",'".$newdata."')");
		
		SqlExec( "INSERT INTO akta ( pid, name, dur, data, reason, cela, cost ) VALUES ({$player->id} , '{$player->user}', 1, '{$newdate}', 'Proba ugryzienia mieszkanca KaraTur', $insert, $cost );");
		$skaz = SqlExec("SELECT name FROM skazani WHERE id={$player->id};");
		if( !empty( $skaz -> fields['name'] ) ) {
			SqlExec("UPDATE skazani SET ilosc=ilosc+1 WHERE id={$player->id};");
		}
		else {
			SqlExec("INSERT INTO skazani (id, name, ilosc) VALUES ({$player->id} ,'{$player->user}', 1);");
		}
			
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$player -> id.",'Zostales wtracony do wiezienia na 1 dzien za probe ugryzienia gracza. Mozesz wyjsc z wiezienia za kaucja: ".$cost.".','".$newdate."')");
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$view -> id.",'Pocalunek Wampira<br><br>Kiedy spokojnie przechadza³eœ siê ulicami nagle poczu³eœ na szyji czyjœ oddech odwruci³eœ siê i to cie uratowa³o przed ugryzieniem by³ to <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID: ".$player -> id.". Szybko pochwyciles jego g³owê, postraszy³eœ œwiat³em i przekazales straznikom.','".$newdate."')");
		error ("<br>Kiedy to sobie spokojnie chcia³eœ wypiæ krew z mieszkañca ten to zauwarzy³ i trafi³eœ do lochów"); 
	}
/*3gryz*/

if ($chance >= 50 && $szansa<=100-$proc)
	{
		//checkexp($player -> exp,$expgain2,$player -> level,$player -> race,$player -> user,$player -> id,0,0,$player -> id,'',0);
		$player -> AwardExp( $expgain2 );
		//$db -> Execute("UPDATE players SET ugryz=ugryz-1, krew=krew+'".$krew."', hp=hp+'".$strata2."' WHERE id=".$player-> id);
		$player -> ugryz --;
		$player -> krew += $krew;
		$player -> hp += $strata;
		if ($view->przez != $player->id)
		{
			$db -> Execute("UPDATE players SET ugryziony=1, hp=hp-'".$strata."', przez='".$player->id."', ilosc_ugryz=ilosc_ugryz+1 WHERE id=".$view-> id);
			PutSignal( $view -> id, 'misc' );
		}
		else
		{
			$db -> Execute("UPDATE players SET ugryziony=ugryziony+1, hp=hp-'".$strata."', ilosc_ugryz=ilosc_ugryz+1 WHERE id=".$view-> id);
			PutSignal( $view -> id, 'misc' );
		}
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$player -> id.",'By³es silniejszy i mimo oporu uda³o ci siê ugryœæ gracza- zyskujesz ".$strata2."hp oraz ".$krew." krwi','".$newdate."')");
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$view -> id.",'Kiedy spokojnie przechadza³eœ siê ulicami nagle poczu³eœ na szyji uk³ucie i pochwili le¿a³eœ jak k³oda,By³ to wampir imieniem <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID: ".$player -> id.", pochwyci³eœ go ostatnimi si³¹mi lecz ten zdo³a³ zbiec - tracisz ".$strata."hp ','".$newdate."')");
	
		if ($krew>=1)
		{
		error ("<br>Mimo znacznej przewagi przeciwnika uda³o ci siê go ugryœæ i wyjœæ po obfitym posi³ku choæ mog³eœ bardziej siê najeœæ - zyskujesz ".$strata2."hp oraz ".$krew." krwi");
		}
		else
		{
		error ("<br>Mimo ¿e ugryz³eœ i coœ zjad³eœ to by³o zama³o aby sie najeœæ nic krwi nie zyskujesz");	
		}	
	}
elseif($chance >= 50 && $szansa>100-$proc && $szansa<=100)
	{
		//$db -> Execute("UPDATE players SET jail='Y' WHERE id=".$player -> id);
		//$db -> Execute("UPDATE players SET ugryz=ugryz-1, krew=krew-1, miejsce='Lochy' WHERE id=".$player-> id);
		$player -> jail = 'Y';
		$player -> ugryz --;
		$player -> krew --;
		$insert = SqlExec("INSERT INTO jail (prisoner, verdict, duration, cost, data) VALUES(".$player -> id.",'Proba ugryzienia mieszkañca',1,".$cost.",'".$newdata."')");
		
		SqlExec( "INSERT INTO akta ( pid, name, dur, data, reason, cela, cost ) VALUES ({$player->id} , '{$player->user}', 1, '{$newdate}', 'Proba ugryzienia mieszkanca KaraTur', $insert, $cost );");
		$skaz = SqlExec("SELECT name FROM skazani WHERE id={$player->id};");
		if( !empty( $skaz -> fields['name'] ) ) {
			SqlExec("UPDATE skazani SET ilosc=ilosc+1 WHERE id={$player->id};");
		}
		else {
			SqlExec("INSERT INTO skazani (id, name, ilosc) VALUES ({$player->id} ,'{$player->user}', 1);");
		}
			
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$player -> id.",'Zostales wtracony do wiezienia na 1 dzien za probe ugryzienia gracza. Mozesz wyjsc z wiezienia za kaucja: ".$cost.".','".$newdate."')");
		$db -> Execute("INSERT INTO log (owner, log, czas) VALUES(".$view -> id.",'Pocalunek Wampira<br><br>Kiedy spokojnie przechadza³eœ siê ulicami nagle poczu³eœ na szyji czyjœ oddech odwruci³eœ siê i to cie uratowa³o przed ugryzieniem by³ to <a href=view.php?view=".$player -> id.">".$player -> user."</a> o ID: ".$player -> id.". Szybko pochwyciles jego g³owê, postraszy³eœ œwiat³em i przekazales straznikom.','".$newdate."')");
		error ("<br>Kiedy to sobie spokojnie chcia³eœ wypiæ krew z mieszkañca ten to zauwarzy³ i trafi³eœ do lochów"); 
	}
}

$smarty->assign( "UserSniff", $_SESSION['rank']['usersniff'] );

$smarty -> display ('view.tpl');

require_once("includes/foot.php");
?>

