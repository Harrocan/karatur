<?php

$title = "Panel Administracyjny"; 
require_once("includes/head.php");

if ($player -> rid=="1") {
	error ("Mieszkañcy nie maj± tutaj wstêpu",'error','stats.php');
}

if (!isset($_GET['view'])) {
	$_GET['view'] = '';
}
if (!isset($_GET['step'])) {
	$_GET['step'] = '';
}
if (!isset($_GET['mod'])) {
	$_GET['mod'] = '';
}

if( empty( $_GET['view'] ) ) {
	$mods = SqlExec( "SELECT `name`, `owner` FROM modules" );
	$mods = $mods->GetArray();
	//qDebug( $mods );
	$modAdm = array();
	foreach( $mods as $mod ) {
		$path = "modules/{$mod['name']}/inc/KT.admin_page.inc.php";
		if( file_exists( $path ) ) {
			$modAdm[] = $mod;
		}
	}
	//qDebug( $modAdm );
	$smarty->assign( "ModAdm", $modAdm );
}

//opcja banowania i odbanowania graczy przez IP, mail, nick, ID
if (isset($_GET['view']) && $_GET['view'] == 'ban') {
	if(!getRank( 'ban' ))
		error("Nie masz prawa tutaj przebywaæ !");
	// Lista graczy zablokowanych
	$arrtype = array();
	$arramount = array();
	$i = 0;
	$ban = SqlExec("SELECT type, amount FROM ban");
	while (!$ban -> EOF){
		$arrtype[$i] = $ban -> fields['type'];
	$arramount[$i] = $ban -> fields['amount'];
		$i = $i + 1;
		$ban -> MoveNext();
	}
	$ban -> Close();
	$smarty -> assign( array("Type" => $arrtype, "Amount" => $arramount));
	if (isset($_GET['step']) && $_GET['step'] == 'modify') {
		// Banowanie gracza
		if ($_POST['action'] == 'ban') {
		SqlExec("INSERT INTO ban (type, amount) VALUES('".$_POST['type']."', '".$_POST['amount']."')");
		$smarty -> assign("Message", "Zbanowales <b>".$_POST['type']."</b> ".$_POST['amount'].". (<a href=\"admin.php?view=ban\">Odswiez</a>)");
	}
	// Odbanowanie gracza
	if ($_POST['action'] == 'unban') {
		SqlExec("DELETE FROM ban WHERE type='".$_POST['type']."' AND amount='".$_POST['amount']."'");
		$smarty -> assign("Message", "Odbanowales <b>".$_POST['type']."</b> ".$_POST['amount'].". (<a href=\"admin.php?view=ban\">Odswiez</a>)");
	}
	}
}

// wysylanie maila do wszystkich graczy
if (isset ($_GET['view']) && $_GET['view'] == 'mail') {
	if(!getRank( 'email' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'send') {
		$mail1 = SqlExec("SELECT email FROM players");
		$adress = '';
		$message = $_POST['message'];
		$subject = "Informacja od Wladcow na ".$gamename;
		require_once('mailer/mailerconfig.php');
		while (!$mail1 -> EOF) {
				$mail -> AddAddress($mail1 -> fields['email']);
				if (!$mail -> Send()) {
					error("Wiadomosc nie zostala wyslana. Blad:<br> ".$mail -> ErrorInfo);
				}
				$mail1 -> MoveNext();
				$mail->ClearAddresses();
		}
		$mail1 -> Close();
		error ("Maile zostaly rozeslane!");
	}
}

// pol&plusmn;czenie graczy - sluby

if (isset ($_GET['view']) && $_GET['view'] == 'pary') {
	if(!getRank( 'priest' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'add') {
		if ($_POST['prisoner'] != $_POST['prisonerp']) {
			if( !$_POST['cost'] || !$_POST['prisoner'] || !$_POST['prisonerp'] || !$_POST['verdict'] ) {
				error( "Wype³nij wszystkie pola !", 'error', "?view=pary" );
			}
			$on = SqlExec("SELECT user FROM players WHERE id='".$_POST['prisonerp']."'");
			$ona = SqlExec("SELECT user FROM players WHERE id='".$_POST['prisoner']."'");
			SqlExec("INSERT into pary (marriage1, marriage2, `desc`, cost, data) values (".$_POST['prisoner'].",".$_POST['prisonerp'].",'".$_POST['verdict']."',".$_POST['cost'].",'".$data."')");
			SqlExec("UPDATE players SET stan=' Poslubila ".$on -> fields['user']."' where id=".$_POST['prisoner']);
			SqlExec("UPDATE players SET stan=' Poslubil ".$ona -> fields['user']."' where id=".$_POST['prisonerp']);
			SqlExec("UPDATE players SET max_energy=max_energy+2 where id=".$_POST['prisoner']);
			SqlExec("UPDATE players SET max_energy=max_energy+2 where id=".$_POST['prisonerp']);
			
			SqlExec("INSERT INTO log (owner, log, czas) values(".$_POST['prisoner'].",'Poslubiles(as) gracza o ID: ".$_POST['prisonerp'].", za ".$_POST['verdict'].". Mozesz sie z nim rozwiesc za: ".$_POST['cost'].". Polaczyl was: ".$player -> user." ID: ".$player -> id."','".$newdate."')");
			SqlExec("INSERT INTO log (owner, log, czas) VALUES(1,'".$_POST['prisoner']." - Uzyto panel Ksiedza przez: ".$player -> user." ID: ".$player -> id."','".$newdate."')");
			SqlExec("INSERT INTO log (owner, log, czas) VALUES(2,'".$_POST['prisoner']." - Uzyto panel Ksiedza przez: ".$player -> user." ID: ".$player -> id."','".$newdate."')");
			SqlExec("insert into log (owner, log, czas) values(".$_POST['prisonerp'].",'Poslubiles(as) gracza o ID:".$_POST['prisoner'].", za ".$_POST['verdict'].". Mozesz sie z nia rozwiesc za: ".$_POST['cost'].". Polaczyl was: ".$player -> user." ID: ".$player -> id."','".$newdate."')");
		
			error ("Kobieta o ID: ".$_POST['prisoner']." Poslubia Mezczyzne o ID: ".$_POST['prisonerp']." za ".$_POST['verdict'].". Moga sie rozwiesc za:".$_POST['cost']);
		}
	}
}

// dodawanie pytania do mostu smierci
if (isset ($_GET['view']) && $_GET['view'] == 'bridge') {
	if(!getRank( 'bridge' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'add') {
		SqlExec("INSERT INTO bridge (question, answer) VALUES('".$_POST['question']."','".$_POST['answer']."')") or error ("nie moge dodac pytania!");
		error ("Dodales do mostu pytanie <b>".$_POST['question']."</b> z odpowiedzia <b>".$_POST['answer']);
	}
}

// wysylanie gracza do wiezienia
if (isset ($_GET['view']) && $_GET['view'] == 'jail') {
	if(!getRank( 'jail' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'add') {
		if ($_POST['prisoner'] != 1) {
			$tmp = SqlExec("INSERT INTO jail (prisoner, verdict, duration, cost, data) VALUES(".$_POST['prisoner'].",'".$_POST['verdict']."',".$_POST['time'].",".$_POST['cost'].",'".$data."')") or error ("nie moge dodac wpisu!");
			$idcela = $db -> Insert_ID();
			SqlExec("UPDATE players SET jail='Y' WHERE id=".$_POST['prisoner']);
			SqlExec("INSERT INTO log (owner, log, czas) VALUES(".$_POST['prisoner'].",'Zostales wtracony do wiezienia na ".$_POST['time']." dni za ".$_POST['verdict'].". Mozesz wyjsc z wiezienia za kaucja: ".$_POST['cost'].". Do wiezienia wtracil Cie: ".$player -> user." ID: ".$player -> id."','".$newdate."')");
			
			$pl = SqlExec("SELECT user FROM players WHERE id=".$_POST['prisoner'].";");
			SqlExec("INSERT INTO akta ( pid, name, dur, data, reason, cela, cost ) VALUES (".$_POST['prisoner']." , '".$pl->fields['user']."', ".$_POST['time'].", '".$newdate."', '".$_POST['verdict']."', ".$idcela.",".$_POST['cost']." );");
			$skaz = SqlExec("SELECT name FROM skazani WHERE id=".$_POST['prisoner'].";");
			if($skaz -> fields['name']!='') {
				$db->Execute("UPDATE skazani SET ilosc=ilosc+1 WHERE id=".$_POST['prisoner'].";")or die("UPDATE skazani SET ilosc=ilosc+1 WHERE id=".$_POST['prisoner'].";");
				$skaz->Close();
			}
			else
				$db->Execute("INSERT INTO skazani (id, name, ilosc) VALUES (".$_POST['prisoner']." ,'".$pl->fields['user']."', 1);")or die("INSERT INTO skazani (id, name, ilosc) VALUES (".$_POST['prisoner']." ,'".$pl->fields['user']."', 1);");
			$pl->Close();
			PutSignal( $_POST['prisoner'], 'misc' );
			error ("Gracz o ID: ".$_POST['prisoner']." zostal wtracony do wiezienia na ".$_POST['time']." dni za ".$_POST['verdict'].". Moze wyjsc z wiezienia za kaucja: ".$_POST['cost'],'done');
		}
	}
}

//uwalnianie graczy z wiezienia
if (isset($_GET['view']) && $_GET['view'] == 'jailbreak') {
	if(!getRank( 'jail' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset($_GET['step']) && $_GET['step'] == 'next') {
		if (!ereg("^[1-9][0-9]*$", $_POST['jid'])) {
			error("Nieprawid³owy gracz !");
		}
		$objPrisoner = SqlExec("SELECT prisoner FROM jail WHERE prisoner=".$_POST['jid']);
		if (!$objPrisoner -> fields['prisoner']) {
			error("Nie ma takiego gracza !");
		}
		$objPrisoner -> Close();
		SqlExec( "INSERT INTO rep(kto,komu,co,ile,kiedy) VALUES({$player->id},{$_POST['jid']},'jailfree','1','{$newdate}')" );
		SqlExec("DELETE FROM jail WHERE prisoner=".$_POST['jid']);
		SqlExec("UPDATE players SET jail='N' WHERE id=".$_POST['jid']);
		PutSignal( $_POST['jid'], 'misc' );
		error("Uwolni³e¶ gracza o ID {$_POST['jid']}",'done');
	}
}

// Skasuj Uzytkownika
/*if (isset ($_GET['view']) && $_GET['view'] == 'del') {
	if(!getRank( 'delete' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'del') {
		if ($_POST['did'] != 1) {
			SqlExec("DELETE FROM players WHERE id=".$_POST['did']);
			SqlExec("DELETE FROM core WHERE owner=".$_POST['did']);
			SqlExec("DELETE FROM core_market WHERE seller=".$_POST['did']);
			SqlExec("DELETE FROM equipment WHERE owner=".$_POST['did']);
			SqlExec("DELETE FROM kowal WHERE gracz=".$_POST['did']);
			SqlExec("DELETE FROM log WHERE owner=".$_POST['did']);
			SqlExec("DELETE FROM mail WHERE owner=".$_POST['did']);
			SqlExec("DELETE FROM outposts WHERE owner=".$_POST['did']);
			SqlExec("DELETE FROM pmarket WHERE seller=".$_POST['did']);
			SqlExec("DELETE FROM hmarket WHERE seller=".$_POST['did']);
			SqlExec("DELETE FROM mikstury WHERE gracz=".$_POST['did']);
			SqlExec("DELETE FROM herbs WHERE gracz=".$_POST['did']);
			SqlExec("DELETE FROM kopalnie WHERE gracz=".$_POST['did']);
			SqlExec("DELETE FROM alchemik WHERE gracz=".$_POST['did']);
			SqlExec("DELETE FROM czary WHERE gracz=".$_POST['did']);
			SqlExec("DELETE FROM kowal_praca WHERE gracz=".$_POST['did']);
			SqlExec("DELETE FROM notatnik WHERE gracz=".$_POST['did']);
			SqlExec("DELETE FROM tribe_oczek WHERE gracz=".$_POST['did']);
			SqlExec("DELETE FROM houses WHERE owner=".$_POST['did']);
			SqlExec("DELETE FROM farms WHERE owner=".$_POST['did']);
			SqlExec("DELETE FROM farm WHERE owner=".$_POST['did']);
			SqlExec("DELETE FROM jail WHERE prisoner=".$_POST['did']);
			SqlExec("DELETE FROM mill_work WHERE gracz=".$_POST['did']);
			SqlExec("DELETE FROM mill WHERE owner=".$_POST['did']);
			$smarty -> assign ("Message", "Skasowales ID ".$_POST['did']);
		} else {
			$smarty -> assign ("Message", "Nie skasowales uzytkownika.");
		}
	}
}
*/

//zmien uzytkownikowi wyglad gry
/*if (isset ($_GET['view']) && $_GET['view'] == 'style') {
	if (isset ($_GET['step']) && $_GET['step'] == 'add') {
		if ($_POST['aid'] != 1) {
			SqlExec("UPDATE players SET style='".$_POST['style']."' WHERE id=".$_POST['aid']);
			error ("Zmieniles styl gry ID ".$_POST['aid']." na ".$_POST['style'].".");
		}
	}
}*/


//zmien uzytkownikowi rase
/*if (isset ($_GET['view']) && $_GET['view'] == 'editrasa') {
	if (isset ($_GET['step']) && $_GET['step'] == 'editrasa') {
		if ($_POST['aid'] != 1) {
			SqlExec("UPDATE players SET rasa='".$_POST['rasa']."' WHERE id=".$_POST['aid']);
			error ("Zmieniles rase ID ".$_POST['aid']." jako ".$_POST['rasa'].".");
		}
	}
}

//zmien uzytkownikowi klase
if (isset ($_GET['view']) && $_GET['view'] == 'editklasa') {
	if (isset ($_GET['step']) && $_GET['step'] == 'editklasa') {
		if ($_POST['aid'] != 1) {
			SqlExec("UPDATE players SET klasa='".$_POST['klasa']."' WHERE id=".$_POST['aid']);
			error ("Zmieniles klase ID ".$_POST['aid']." jako ".$_POST['klasa'].".");
		}
	}
}*/

// czyszczenie forum
if (isset ($_GET['view']) && $_GET['view'] == 'clearf') {
	if(!getRank( 'clearforum' ))
		error("Nie masz prawa tutaj przebywaæ !");
	SqlExec("DELETE FROM topics");
	SqlExec("DELETE FROM replies");
	error ("Wyczysciles forum.");
}

//czyszczenie karczmy
if (isset ($_GET['view']) && $_GET['view'] == 'clearc') {
	if(!getRank( 'clearchat' ))
		error("Nie masz prawa tutaj przebywaæ !");
	SqlExec("DELETE FROM chat");
	error ("Wyczysciles czat.");
}

// usuwanie wszystkich potworow
/*if (isset ($_GET['view']) && $_GET['view'] == 'clearm') {
SqlExec("DELETE FROM monsters");
error ("Usunales potwory.");
}*/

// usuwanie wiesci
/*if (isset ($_GET['view']) && $_GET['view'] == 'clearw') {
SqlExec("DELETE FROM updates");
error ("Usunales wiesci.");
}*/

// usuwanie plotek
/*if (isset ($_GET['view']) && $_GET['view'] == 'clearp') {
SqlExec("DELETE FROM news");
error ("Usunales plotki.");
}*/

// nadawanie immunitetu
if (isset ($_GET['view']) && $_GET['view'] == 'tags') {
	if(!getRank( 'immu' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == "tag") {
		SqlExec("UPDATE players SET immu='Y' WHERE id=".$_POST['tag_id']);
		PutSignal( $_POST['tag_id'], 'misc' );
		error ("Dales immunitet ID <b>".$_POST['tag_id']."</b>.");
	}
}

// Zabieranie immunitetu
if (isset ($_GET['view']) && $_GET['view'] == 'tags1') {
	if(!getRank( 'immu' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == "tag1") {
		SqlExec("UPDATE players SET immu='N' WHERE id=".$_POST['tag_id']);
		PutSignal( $_POST['tag_id'], 'misc' );
		error ("Zabrales immunitet ID <b>".$_POST['tag_id']."</b>.");
	}
}

// dotowanie gracza
if (isset ($_GET['view']) && $_GET['view'] == 'donate') {
	if(!getRank( 'cash' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'donated') {
		$_POST['amount'] = str_replace("--","", $_POST['amount']);
		if ($_POST['amount'] < 0 ) {
			error ("nie mozesz tak zrobic");
		}
		SqlExec("INSERT INTO rep (kto, komu, co, ile, kiedy) VALUES (".$player->id.", ".$_POST['id'].", 'kasa', ".$_POST['amount'].", '".$newdate."')");
		SqlExec("UPDATE resources SET gold=gold+".$_POST['amount']." WHERE id=".$_POST['id']);
		PutSignal( $_POST['id'], 'res' );
		error ("Pieniadze przekazane",'done');
	}
}

// dodawanie energii graczowi
/*if (isset ($_GET['view']) && $_GET['view'] == 'dajene') {
	if (isset ($_GET['step']) && $_GET['step'] == 'dajene') {
		$_POST['amount'] = str_replace("--","", $_POST['amount']);
		if ($_POST['amount'] < 0 ) {
			error ("nie mozesz tak zrobic");
		}
		SqlExec("INSERT INTO rep (kto, komu, co, ile, kiedy) VALUES (".$player->id.", ".$_POST['id'].", 'energia', ".$_POST['amount'].", '".$newdate."')");
		SqlExec("UPDATE players SET energy=energy+".$_POST['amount']." WHERE id=".$_POST['id']);
		error ("Energia dodana");
	}
}*/

// dotowanie bankowe gracza
if (isset ($_GET['view']) && $_GET['view'] == 'dajbank') {
	if(!getRank( 'cash' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'dajbank') {
		$_POST['amount'] = str_replace("--","", $_POST['amount']);
		if ($_POST['amount'] < 0 ) {
			error ("nie mozesz tak zrobic");
		}
		SqlExec("INSERT INTO rep (kto, komu, co, ile, kiedy) VALUES (".$player->id.", ".$_POST['id'].", 'kasa - bank', ".$_POST['amount'].", '".$newdate."')");
		SqlExec("UPDATE resources SET bank=bank+".$_POST['amount']." WHERE id=".$_POST['id']);
		PutSignal( $_POST['id'], 'res' );
		error ("Pieniadze przekazane na bank");
	}
}

// Dawanie ap graczowi
/*if (isset ($_GET['view']) && $_GET['view'] == 'dajap') {
	if (isset ($_GET['step']) && $_GET['step'] == 'dajap') {
		$_POST['amount'] = str_replace("--","", $_POST['amount']);
		if ($_POST['amount'] < 0 ) {
			error ("nie mozesz tak zrobic");
		}
		SqlExec("INSERT INTO rep (kto, komu, co, ile, kiedy) VALUES (".$player->id.", ".$_POST['id'].", 'AP', ".$_POST['amount'].", '".$newdate."')")or die("INSERT INTO rep (kto, komu, co, ile, kiedy) VALUES (".$player->id.", ".$_POST['id'].", 'AP', ".$_POST['amount'].", '".$newdate."')");
		SqlExec("UPDATE players SET ap=ap+".$_POST['amount']." WHERE id=".$_POST['id']);
		error ("AP dodane");
	}
}*/

//zabieranie zlota graczowi z banku
if (isset ($_GET['view']) && $_GET['view'] == 'delbank') {
	if(!getRank( 'cash' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'delbank') {
		$_POST['taken'] = str_replace("--","", $_POST['taken']);
		if ($_POST['taken'] < 0 ) {
			error ("nie mozesz tak zrobic");
		}
		SqlExec("UPDATE resources SET bank=bank-".$_POST['taken']." WHERE id=".$_POST['id']);
		PutSignal( $_POST['id'], 'res' );
		error ($_POST['taken']." sztuk zlota zostalo zabranych z banku ID: ".$_POST['id']);
	}
}

//zabieranie zlota graczowi
if (isset ($_GET['view']) && $_GET['view'] == 'takeaway') {
	if(!getRank( 'cash' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'takenaway') {
		$_POST['taken'] = str_replace("--","", $_POST['taken']);
		if ($_POST['taken'] < 0 ) {
			error ("nie mozesz tak zrobic");
		}
		SqlExec("UPDATE resources SET gold=gold-".$_POST['taken']." WHERE id=".$_POST['id']);
		PutSignal( $_POST['id'], 'res' );
		error ($_POST['taken']." sztuk zlota zostalo zabranych ID: ".$_POST['id']);
	}
}

//zabieranie energii graczowi
/*if (isset ($_GET['view']) && $_GET['view'] == 'delene') {
	if (isset ($_GET['step']) && $_GET['step'] == 'delene') {
		$_POST['taken'] = str_replace("--","", $_POST['taken']);
		if ($_POST['taken'] < 0 ) {
			error ("nie mozesz tak zrobic");
		}
		SqlExec("UPDATE players SET energy=energy-".$_POST['taken']." WHERE id=".$_POST['id']);
		error ($_POST['taken']." energii zostalo zabranych ID: ".$_POST['id']);
	}
}*/


//Zabieranie graczowi ap
/*if (isset ($_GET['view']) && $_GET['view'] == 'delap') {
	if (isset ($_GET['step']) && $_GET['step'] == 'delap') {
		$_POST['taken'] = str_replace("--","", $_POST['taken']);
		if ($_POST['taken'] < 0 ) {
			error ("nie mozesz tak zrobic");
		}
		SqlExec("UPDATE players SET ap=ap-".$_POST['taken']." WHERE id=".$_POST['id']);
		error ($_POST['taken']." ap zostalo zabranych ID: ".$_POST['id']);
	}
}*/

// dodawanie potworow
if (isset ($_GET['view']) && $_GET['view'] == 'monster') {
	if(!getRank( 'addmon' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'monster') {
		if (!$_POST['nazwa'] || !$_POST['poziom'] || !$_POST['pz'] || !$_POST['zr'] || !$_POST['sila'] || !$_POST['minzl'] || !$_POST['maxzl'] || !$_POST['minpd'] || !$_POST['maxpd'] || !$_POST['speed'] || !$_POST['endurance']) {
			error ("wypelnij wszystkie pola!");
		}
		SqlExec("INSERT INTO monsters (name, level, hp, agility, strength, credits1, credits2, exp1, exp2, speed, endurance) VALUES('".$_POST['nazwa']."',".$_POST['poziom'].",".$_POST['pz'].",".$_POST['zr'].",".$_POST['sila'].",".$_POST['minzl'].",".$_POST['maxzl'].",".$_POST['minpd'].",".$_POST['maxpd'].",".$_POST['speed'].",".$_POST['endurance'].")");
	}
}

// dodawanie planow u kowala
if (isset ($_GET['view']) && $_GET['view'] == 'kowal') {
	if(!getRank( 'addkow' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'kowal') {
		if (!$_POST['nazwa'] || !$_POST['cena'] || !$_POST['poziom']) {
			error ("Wypelnij wszystkie pola!");
		}
		if (!$_POST['zelazo']) {
			$_POST['zelazo'] = 0;
		}
		if (!$_POST['wegiel']) {
			$_POST['wegiel'] = 0;
		}
		if (!$_POST['bronz']) {
			$_POST['bronz'] = 0;
		}
		if (!$_POST['mithril']) {
			$_POST['mithril'] = 0;
		}
		if (!$_POST['adam']) {
			$_POST['adam'] = 0;
		}
		if (!$_POST['meteo']) {
			$_POST['meteo'] = 0;
		}
		if (!$_POST['krysztal']) {
			$_POST['krysztal'] = 0;
		}
		SqlExec("INSERT INTO kowal (nazwa, cena, zelazo, wegiel, bronz, poziom, mithril, adamant, meteor, krysztal, type) VALUES('".$_POST['nazwa']."',".$_POST['cena'].",".$_POST['zelazo'].",".$_POST['wegiel'].",".$_POST['bronz'].",".$_POST['poziom'].",".$_POST['mithril'].",".$_POST['adam'].",".$_POST['meteo'].",".$_POST['krysztal'].",'".$_POST['type']."')");
	}
}

// wysylanie wiadomosci do graczy
if (isset ($_GET['view']) && $_GET['view'] == 'poczta') {
	if(!getRank( 'mail' ))
		error("Nie masz prawa tutaj przebywaæ !");
	$r=$db->Execute("SELECT id,name FROM ranks");
	$ranks=$r->GetArray();
	$rankid=array();
	$rankname=array();
	$rankid[]="0";
	$rankname[]="Wszyscy";
	foreach($ranks as $rank) {
		$rankid[]=$rank['id'];
		$rankname[]=$rank['name'];
	}
	$smarty->assign(array("Rankid"=>$rankid,"Rankname"=>$rankname));
	if (isset ($_GET['step']) && $_GET['step'] == 'send') {
		if (empty ($_POST['body'])) {
			error ("Wypelnij pole.");
		}
		if (empty ($_POST['subject'])) {
			$_POST['subject'] = "Brak";
		}
		$_POST['subject'] = strip_tags($_POST['subject']);
		$_POST['body'] = strip_tags($_POST['body']);
		if($_POST['do']=="0")
			$odbio = SqlExec("SELECT id FROM players");
		else
			$odbio = SqlExec("SELECT id FROM players WHERE rid=".$_POST['do']);
		$gracze = 0;
		$odbio = $odbio->GetArray();
		foreach( $odbio as $odb ) {
			//SqlExec("INSERT INTO mail (sender,senderid,owner,subject,body) VALUES('".$player -> user."','".$player -> id."',".$odbio -> fields['id'].",'".$_POST['subject']."','".$_POST['body']."')") or error("Nie moge wyslac listu.");
			SqlExec( "INSERT INTO mail( `owner`, `sender`, `type`, `topic`, `body` ) VALUES( '{$odb['id']}', '{$player->id}', '{$_POST['type']}', '{$_POST['topic']}', '{$_POST['body']}' )" );
			$gracze = $gracze+1;
			//$odbio -> MoveNext();
		}
		//$odbio -> Close();
		error ("Wyslales wiadomosc do ".$gracze." graczy.");
	}
}

// blokowanie i odblokowywanie gracza w karczmie
if (isset ($_GET['view']) && $_GET['view'] == 'czat') {
	if(!getRank( 'block' ))
		error("Nie masz prawa tutaj przebywaæ !");
	$arrtemp = array();
	$i = 0;
	$czatb = SqlExec("SELECT gracz FROM chat_config");
	while (!$czatb -> EOF){
		$arrtemp[$i] = $czatb -> fields['gracz'];
		$i = $i + 1;
		$czatb -> MoveNext();
	}
	$czatb -> Close();
	$smarty -> assign ("List1", $arrtemp);
	if (isset ($_GET['step']) && $_GET['step'] == 'czat') {
		if ($_POST['czat'] == 'blok') {
			SqlExec("INSERT INTO chat_config (gracz) VALUES(".$_POST['czat_id'].")");
			error ("Zablokowales wysylanie wiadomosci na czacie przez gracza ".$_POST['czat_id']);
		}
		if ($_POST['czat'] == 'odblok') {
			SqlExec("DELETE FROM chat_config WHERE gracz=".$_POST['czat_id']);
			error ("Odblokowales wysylanie wiadomosci na czacie przez gracza ".$_POST['czat_id']);
		}
	}
}

// dodawanie nowych czarow
if (isset ($_GET['view']) && $_GET['view'] == 'czary') {
	if(!getRank( 'addsp' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'add') {
		if (empty($_POST['name']) || empty($_POST['power']) || empty($_POST['cost']) || empty($_POST['minlev'])) {
			error ("Wypelnij wszystkie pola!");
		}
		SqlExec("INSERT INTO czary (nazwa, cena, poziom, typ, obr) VALUES('".$_POST['name']."',".$_POST['cost'].",".$_POST['minlev'].",'".$_POST['type']."',".$_POST['power'].")");
		error ("Dodales czar ".$_POST['name']." jako czar ".$_POST['type']." z sila ".$_POST['power']." kosztujacy ".$_POST['cost']." dla graczy, ktorzy osiagneli poziom ".$_POST['minlev']);
	}
}

//czyszczenie dziennika
if (isset ($_GET['view']) && $_GET['view'] == 'clearcl') {
	if(!getRank( 'clearlog' ))
		error("Nie masz prawa tutaj przebywaæ !");
	$db->Execute("delete from log");
	$db->Execute("ALTER TABLE `log` pack_keys=0 checksum=0 delay_key_write=0 auto_increment=1");
	error ("Wyczy&para;cile&para; wszystkie logi.");
}

//Dodawanie sondy
if (isset($_GET['view']) && $_GET['view'] == 'poll') {
	if(!getRank( 'poll' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if(!isset($_GET['step'])) {
		$pollid = $db-> Execute("SELECT value FROM settings WHERE setting='poll_id'");
		$poll=$db->Execute("SELECT * FROM poll WHERE id=".$pollid->fields['value']."");
		$polln=$poll->fields['name'];
		$pollq=explode(",",$poll->fields['options']);
		$pollv=explode(",",$poll->fields['votes']);
		$sum=0;
		foreach($pollv as $v)
			$sum+=$v;
		$proc=array();
		$i=0;
		foreach($pollv as $v) {
			$proc[$i]=($v/$sum)*100;
			$i++;
		}
		$smarty->assign(array("PlVote"=>$player->vote,"PollName"=>$polln,"PollQuestion"=>$pollq,"PollValue"=>$pollv,"Proc"=>$proc));
	}
	if(isset($_GET['step']) && $_GET['step']=='add') {
		$arr=array();
		for($x=0;$x<$_POST['ile'];$x++)
			$arr[$x]="Odpowied ".($x+1)." : ";
		$smarty->assign(array("Ile"=>$_POST['ile'],"Opcje"=>$arr));
	}
	if(isset($_GET['step']) && $_GET['step']=='confirm') {
		$arr=array();
		$val=array();
		for($x=0;$x<$_POST['ile'];$x++) {
			$arr[$x] = $_POST['opt'.$x];
			$val[$x] = 0;
		}
		$arr=implode(",",$arr);
		$val=implode(",",$val);
		echo $_POST['nazwa']." : ".$_POST['pytanie']."<br>".$arr."<br>".$val;
		$db->Execute("INSERT INTO poll (name,options,votes) VALUES ('".$_POST['pytanie']."', '".$arr."', '".$val."');")or die("INSERT INTO poll (name,options,votes) VALUES ('".$_POST['pytanie']."', '".$arr."', '".$val."');");
		$pollid=$db->Insert_ID();
		$db->Execute("UPDATE players SET vote='N'");
		$db->Execute("UPDATE settings SET value=".$pollid." WHERE setting='poll_id'");
	}
}

//czyszczenie Poczty
if (isset ($_GET['view']) && $_GET['view'] == 'clearcm') {
	if(!getRank( 'clearmail' ))
		error("Nie masz prawa tutaj przebywaæ !");
	$db->Execute("delete from mail");
	$db->Execute("ALTER TABLE `mail` pack_keys=0 checksum=0 delay_key_write=0 auto_increment=1");
	error ("Wyczy&para;cile&para; cal&plusmn; poczte.");
}

// czasowe wylaczenie gry
if (isset ($_GET['view']) && $_GET['view'] == 'close') {
	if(!getRank( 'close' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if (isset ($_GET['step']) && $_GET['step'] == 'close') {
		if ($_POST['close'] == 'close') {
				SqlExec("UPDATE settings SET value='N' WHERE setting='open'");
			SqlExec("UPDATE settings SET value='".$_POST['reason']."' WHERE setting='close_reason'");
				error ("Zablokowales gre");
		}
		if ($_POST['close'] == 'open') {
				SqlExec("UPDATE settings SET value='Y' WHERE setting='open'");
			SqlExec("UPDATE settings SET value='' WHERE setting='close_reason'");
				error ("Odblokowales gre");
		}
	}
}

// Dodawanie szybkiej wiadomosci
if (isset ($_GET['view']) && $_GET['view'] == 'qmsg') {
	if(!getRank( 'qmsg' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if(isset ($_GET['step']) && $_GET['step'] == 'add') {
		$db->Execute("UPDATE settings SET value='".$_POST['qmsg']."' WHERE setting='qmsg'");
		error("Wiadomosc zmieniona !",'done');
	}
}

//Edycja danych graczy
if ($_GET['view'] == 'edpl') {
	if(!getRank( 'edplayer' ))
		error("Nie masz prawa tutaj przebywaæ !");
	if($_GET['step'] == 'next') {
		if(empty($_POST['pid'])) {
			error("Podaj id !");
		}
		$pl=$db->Execute("SELECT id, user, rasa, klasa, immu, miejsce, deity, gender, charakter, oczy, skora, wlos, tow, poch, opis, profile, avatar FROM players WHERE id={$_POST['pid']}");
		$pl=$pl->GetArray();
		$pl=$pl[0];
		if(empty($pl['id'])) {
			error("Nie ma takiego gracza !");
		}
		$smarty->assign("Pl",$pl);
	}
	if($_GET['step']=='mod') {
		if(empty($_POST['user']))
			error("Podaj imie gracza !");
		qDebug( print_r( $_POST, true ) );
		$sql="UPDATE players SET `user`='{$_POST['user']}', immu='{$_POST['immu']}', deity='{$_POST['deity']}', gender='{$_POST['gender']}', charakter='{$_POST['charakter']}', oczy='{$_POST['oczy']}', skora='{$_POST['skora']}', wlos='{$_POST['wlos']}', `profile`='{$_POST['profile']}' WHERE id={$_POST['pid']} LIMIT 1";
		SqlExec( $sql );
		if( isset( $_POST['delav'] ) && $_POST['delav'] == '1' ) {
			$av = SqlExec( "SELECT avatar FROM players WHERE id={$_POST['pid']}" );
			$av = $av->fields['avatar'];
			$plik = "avatars/$av";
			if (is_file($plik)) {
				unlink($plik);
				SqlExec("UPDATE players SET avatar='' WHERE id=".$player -> id) or error("nie moge skasowac");
			}
		}
		PutSignal( $_POST['pid'], 'misc' );
		error("Gracz edytowany !",'done');
	}
}

//!Usuwanie gracza;
if( $_GET['view'] == 'userdel') {
	if( !getRank( 'userdel' ) )
		error("Nie masz prawa tutaj przebywaæ !");
	if( !empty( $_POST['delid'] ) ) {
		//print_r( $_POST['delid'] );
		$test = SqlExec( "SELECT user FROM players WHERE id={$_POST['delid']}" );
		if( !$test->fields['user'] ) {
			error( "Gracz o ID {$_POST['delid']} nie istnieje !" );
		}
		SqlExec("INSERT INTO rep (kto, komu, co, ile, kiedy) VALUES ({$player->id}, {$_POST['delid']}, 'kasacja', 1, '".$newdate."')");
		require_once('class/playerManager.class.php');
		$toDel = new playerManager( $_POST['delid'] );
		$toDel->delete();
		error( "Usunales gracza {$test->fields['user']} !", 'done' );
	}
}

//!Usuwanie gracza;
if( $_GET['view'] == 'tribedel') {
	if( !getRank( 'tribedel' ) )
		error("Nie masz prawa tutaj przebywaæ !");
	if( !empty( $_GET['step'] ) ) {
		$tid = $_GET['step'];
		$test = SqlExec( "SELECT name FROM tribes WHERE id=$tid" );
		if( empty( $test->fields['name'] ) ) {
			error( "Taki klan nie istnieje" );
		}
		SqlExec( "DELETE FROM tribes WHERE id=$tid" );
		SqlExec( "DELETE FROM tribe_mag WHERE klan=$tid" );
		SqlExec( "DELETE FROM tribe_oczek WHERE klan=$tid" );
		SqlExec( "DELETE FROM tribe_perm WHERE tribe=$tid" );
		SqlExec( "DELETE FROM tribe_rank WHERE tribe_id=$tid" );
		SqlExec( "DELETE FROM tribe_topics WHERE tribe=$tid" );
		SqlExec( "DELETE FROM tribe_zbroj WHERE klan=$tid" );
		SqlExec( "UPDATE players SET tribe=0 WHERE tribe=$tid" );
		error( "Usuwanie klanu <b>{$test->fields['name']}</b> zakonczone sukcesem !", 'done' );
	}
	$tribes = SqlExec( "SELECT t.id, t.name, p.user FROM tribes t LEFT JOIN players p ON p.id=t.owner" );
	$tribes = $tribes->GetArray();
	//qDebug( print_r( $tribes, true ) );
	$smarty->assign( "Tribes", $tribes );
}

$__smartyAssign = array(
					"View" => $_GET['view'],
					"Step" => $_GET['step'],
					"Mod" => $_GET['mod'],
					"Rank" => getRank( 'getall' ),
					"PlayerId" => $player->id
					);

if( !empty( $_GET['mod'] ) ) {
	$test = SqlExec( "SELECT * FROM modules WHERE `name`='{$_GET['mod']}'" );
	if ( empty( $test->fields['id'] ) ) {
		error( "Nie ma takiego modulu !" );
	}
	$test = array_shift( $test -> GetArray() );
	if( ( getRank( 'moduleadd' ) && $player->id == $test['owner'] ) || getRank( 'modulemanage' ) ) {
		output_add_rewrite_var( "mod", $_GET['mod'] );
		runModuleAdmin( $_GET['mod'] );
		ob_flush();
		output_reset_rewrite_vars();
		echo "<div style=\"margin-top:15px\"><a href=\"?\">Wroc</a> do panelu administracyjnego</div>";
	}
	else {
		error( "Nie mozesz administrowac tym modulem !" );
	}
}
					
// inicjalizacja zmiennych

// przypisanie zmiennych oraz wyswietlenie strony

/*$smarty -> assign ("Rank_update",$_SESSION['rank_update']);
$smarty -> assign ("Rank_news",$_SESSION['rank_news']);
$smarty -> assign ("Rank_qmsg",$_SESSION['rank_qmsg']);
$smarty -> assign ("Rank_delete",$_SESSION['rank_delete']);
$smarty -> assign ("Rank_cash",$_SESSION['rank_cash']);
$smarty -> assign ("Rank_ranks",$_SESSION['rank_ranks']);
$smarty -> assign ("Rank_rankprev",$_SESSION['rank_rankprev']);
$smarty -> assign ("Rank_city",$_SESSION['rank_city']);
$smarty -> assign ("Rank_old",$_SESSION['rank_old']);
$smarty -> assign ("Rank_atribs",$_SESSION['rank_atribs']);
$smarty -> assign ("Rank_immu",$_SESSION['rank_immu']);
$smarty -> assign ("Rank_clearforum",$_SESSION['rank_clearforum']);
$smarty -> assign ("Rank_clearchat",$_SESSION['rank_clearchat']);
$smarty -> assign ("Rank_ip",$_SESSION['rank_ip']);
$smarty -> assign ("Rank_addeq",$_SESSION['rank_addeq']);
$smarty -> assign ("Rank_addmon",$_SESSION['rank_addmon']);
$smarty -> assign ("Rank_addkow",$_SESSION['rank_addkow']);
$smarty -> assign ("Rank_addsp",$_SESSION['rank_addsp']);
$smarty -> assign ("Rank_mail",$_SESSION['rank_mail']);
$smarty -> assign ("Rank_block",$_SESSION['rank_block']);
$smarty -> assign ("Rank_jail",$_SESSION['rank_jail']);
$smarty -> assign ("Rank_bridge",$_SESSION['rank_bridge']);
$smarty -> assign ("Rank_email",$_SESSION['rank_email']);
$smarty -> assign ("Rank_close",$_SESSION['rank_close']);
$smarty -> assign ("Rank_ban",$_SESSION['rank_ban']);
$smarty -> assign ("Rank_priest",$_SESSION['rank_priest']);
$smarty -> assign ("Rank_clearlog",$_SESSION['rank_clearlog']);
$smarty -> assign ("Rank_clearmail",$_SESSION['rank_clearmail']);
$smarty -> assign ("Rank_poll",$_SESSION['rank_poll']);
$smarty -> assign ("Rank_mapedit",$_SESSION['rank_mapedit']);
$smarty -> assign ("Rank_edplayer",$_SESSION['rank_edplayer']);
$smarty -> assign ("Rank_shop",$_SESSION['rank_shop']);*/
//getRank( 'getall' );
//$smarty->assign( "Rank", getRank( 'getall' ) );

$smarty -> assign( $__smartyAssign );

$smarty -> display('panel.tpl');
require_once("includes/foot.php");

?>