<?php

require_once( "ajax_base.php" );

if( empty( $_SESSION['player'] ) ) {
	//err( "SESS_EXPIRE" );
	echo "kupa";
	die();
}

$player =& $_SESSION['player'];

if( !checklocation( 'chat.php', true ) ) {
	die( "Brak dostepu" );
}

function convert_tags( $text, $tag, $newTag ) {
	preg_match_all( "/({$tag}[^{$tag}]*{$tag})/", $text, $m );
	if( is_array( $m ) ) {
		foreach( $m[0] as $e ) {
			$text = str_replace( $e, "<span class=\"chat-$newTag\">$e</span>", $text );
		}
	}
	return $text;
}

$room2page = array( 'chat' => "Chat", 'basement' => "Piwnica", 'offtop' => "Pokoj Nieklimatyzowany" );

$player->lpv = time();
$room = $_POST['room'];
//echo "\$room2page[ $room ] = {$room2page[$room]}";
$player->page = "{$room2page[$room]}";

switch( $_POST['type'] ) {
	case 'msg' :
		$msg = SqlExec( "SELECT 
					c.*, p_from.user AS pl_from, p_to.user AS pl_to, r.color AS r_color
				FROM 
					chat c 
				LEFT JOIN 
					players p_from ON p_from.id=c.from 
				LEFT JOIN 
					players p_to ON p_to.id=c.to 
				LEFT JOIN 
					ranks r ON r.id = p_from.rid
				WHERE
					c.room='{$room}' 
				ORDER BY id DESC 
				LIMIT 20" );
		$msg = $msg -> GetArray();
		$from = array( "[szept]", '[|]', "[/szept]", '[/|]', "[emo]", '[*]', "[/emo]", '[/*]' );
		//$to = array( "<szept>", "<szept>", "</szept>", "</szept>", "<emo>", "<emo>", "</emo>", "</emo>" );
		$to = array( "", "", "", "", "", "", "", "" );
		$spcArr = array( '-1' => 'Karczmarz',
						 '-2' => 'Barnaba',
						 '-3' => 'Karczmarka Aniela'
					   );
		foreach( $msg as $text ) {
			$t = str_replace( $from, $to, $text['msg']  );
			$t = convert_tags( $t, "\\/", "szept" );
			$t = convert_tags( $t, "\\*", "emo" );
			
			if( $text['from'] < 0 ) {
				$text['r_color'] = '#DEB887';
				$text['pl_from'] = "<i>{$spcArr[$text['from']]}</i>";
			}
			$t = rawurlencode( iconv("ISO-8859-2", "UTF-8", $t ) );
			$tt = "<div ".( ($text['to']==$player->id)?"class=\"owner\"":"" )."><span style=\"color:{$text['r_color']}\">{$text['pl_from']}</span> : {$t}</div>";
			echo "$tt";
		}
		break;
	case 'user' :
		$pl = $db -> Execute("SELECT rank, id, lpv, user, gender FROM players WHERE page='{$room2page[$room]}'AND lpv > ".(time()-180) );
		$pl = $pl -> GetArray();
		foreach( $pl as $user ) {
			echo "<div class=\"user-{$user['gender']}\" style=\"padding-left:20px\">{$user['user']}</div>";
		}
		//while (!$pl -> EOF) {
		//	echo "<div class=\"user-{$pl->fie style=\"padding-left:20px\">{$pl->fields['user']}</div>";
		//	$pl -> MoveNext();
		//}
		break;
	case 'send' :
		$owner = 0;
		$msg = ( $_POST['text'] );
		$msg = iconv("UTF-8", "ISO-8859-2", rawurldecode( $msg ) );
		$msg = strip_tags( $msg );
		$rcol=SqlExec("SELECT color FROM ranks WHERE id={$player->rid}");
		$starter="<span style=\"color:{$rcol->fields['color']}\">".$player -> user."</span>";
		$czat = $db -> Execute("SELECT gracz FROM chat_config");
		while (!$czat -> EOF) {
			if ($player -> id == $czat -> fields['gracz']) {
				echo "ban";
				die();
			}
			$czat -> MoveNext();
		}
		$czat -> Close();
		$testPos = ereg( '^([0-9]*)[ ]*\=[ ]*(.*)', $msg, $reg );
		//var_dump( $testPos );
		$to = 0;
		if( $testPos !== false ) {
			$owner = $reg[1];
			$to = $reg[1];
			$owUser = SqlExec( "SELECT user FROM players WHERE id={$owner}" );
			$msg =  "<b>{$owUser->fields['user']}>>></b> $reg[2]";
		}
		
		//SqlExec("INSERT INTO chat (user, chat, senderid,ownerid) VALUES('$starter', '$msg',{$player->id},'$owner')");
		//Moze tu bedziesz dodalem to od siebie, Ja Karczmarz linijki 87-94
		$windu = $player->id;
		if(( $player->id == '2888') &&( $msg[0] == '^')){
              $windu =-1;
		$msg[0] = ' ';
		}
		SqlExec( "INSERT INTO chat(`from`,`to`,`msg`,`room`) VALUES('{$windu}','{$to}','{$msg}','{$room}')" );
		//az dotad
		//SqlExec( "INSERT INTO chat(`from`,`to`,`msg`,`room`) VALUES('{$player->id}','{$to}','{$msg}','{$room}')" );	
		if( stripos( $msg, "karczmarzu" ) !== false ) {
			if( stripos( $msg, "wiesci" ) !== false || stripos( $msg, "wydarzylo" ) !== false || stripos( $msg, "zdarzylo" ) !== false ) {
				$query = SqlExec("SELECT id FROM events");
				$number = $query -> RecordCount();
				$query -> Close();
				if ($number > 0) {
					$roll = rand (1,$number);
					$event = SqlExec("SELECT text FROM events WHERE id=".$roll);
					$text = "No cos tam sie dzieje np. ".$event -> fields['text'];
					SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '$text', '$room')");
				} else {
					SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', 'A nic takiego sie nie wydarzylo', '$room')");
				}
			}
			if ( stripos( $msg, "kawal" ) !== false ) {
				$arrtext = array ('nie musze wystarczy ze przejrzysz sie w lustrze <emo>usmiecha sie</emo>', 'wiesz co wyjdz z karczmy i zobacz czy cie nie ma przed budynkiem');
				$roll = rand (0, count( $arrtext ) - 1 );
				SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '{$arrtext[$roll]}', '$room')");
			}	
		}
		if (stripos( $msg, "dobranoc" ) !== false) {
			$arrtext = array ('Dobranoc i slodkich snow o pieknych elfach', 'Juz wychodzisz? Szkoda, bo po 24.00 beda tance...');
			$roll = rand (0, count( $arrtext ) - 1 );
			SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '{$arrtext[$roll]}', '$room')");
		}	

		if (stripos( $msg, "dowidzenia" ) !== false) {
			$arrtext = array ('Zegnaj i do zobacenia jutro *macha na pozegnanie*', 'Szkoda, ze nareszcie poszedl *mruczy zadowolony pod nosem*', 'Dowidzenia', 'I nie wracaj!!!');
			$roll = rand (0, count( $arrtext ) - 1 );
			SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '{$arrtext[$roll]}', '$room')");
		}	
              if (stripos( $msg, "spokoj" ) !== false) {
			$arrtext = array ('Spokojny ta ja tez jestem ale do czasu!', 'Cos za spokojnie, czyzby znowu ktos puscil...truciciela he he.','Swiety spokoj, tego mi brakuje jak tu jestescie.','Taki spokojny jak bylem to juz nie bede*odburknal*' );
			$roll = rand (0, count( $arrtext ) - 1 );
			SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '{$arrtext[$roll]}', '$room')");
		}	

		if (stripos( $msg, "chcesz z kufla ?" ) !== false) {
			$arrtext = array ('Nie podskakuj kurduplu, bo bedziesz musial szukac chirurga!', 'Nie no, ja tak tylko zartowalem...',);
			$roll = rand (0, count( $arrtext ) - 1 );
			SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '{$arrtext[$roll]}', '$room')");
		}	
	
		if (stripos( $msg, "ale leje" ) !== false) {
			$arrtext = array ('Ano leje tak od tygodnia i konca nie widac...', 'Grunt to miec nadzieje, ze jutro bedzie slonce','Leje to mnie sie pot z czo³a, jak wkrotce nie znajda mi kogos do pomocy to...');
			$roll = rand (0, count( $arrtext ) - 1 );
			SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '{$arrtext[$roll]}', '$room')");
		}
		
		if (stripos( $msg, "nuda" ) !== false || stripos( $msg, "nudno" ) !== false) {
			$arrtext = array ('Jak sie nie podoba, to na arene, walczyc ze szczurami!', 'Ano nuda, bo ilez mozna siedziec w karczmie?', 'A na co Masz ochote? Co Cie rozrusza?', 'Nuda?!? Popatrz lepiej na te tanczace elfice w rogu sali!!!', 'A co ja mam powiedziec? Siedze za lada caly dzien a tu przyjdzie jeden z drugim i tylko narzekaja!', 'Wez se menaszke, walnij sie w czaszke! To Ci przejdzie!');
			$roll = rand (0, count( $arrtext ) - 1 );
			SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '{$arrtext[$roll]}', '$room')");
		}
	
		if (stripos( $msg, "muzyka" ) !== false) {
			$arrtext = array ('Co muzyka? nie pasuje? to idz do lochow i posluchaj jeku skazancow!', 'Pieknie graja prawda?', 'Dzisiaj to jeszcze nie jest szczyt ich mozliwosci hehe. Wczoraj tak dali czadu, ze klienci zdarli mi parkiet, taka byla zabawa.', 'Elfy pieknie graja, ale ja wole cos w stylu bebnow troli gorskich...', 'Muzyka lagodzi obyczaje, dlatego zatrudniam najlepszych hehe', 'Cos nie pasuje? A moze gluchy jestes? Barnaba moze Ci wyostrzyc sluch to odrazu Ci sie spodoba!');
			$roll = rand (0, count( $arrtext ) - 1 );
			SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '{$arrtext[$roll]}', '$room')");
		}
	
		if (stripos( $msg, "zimno tu" ) !== false || stripos( $msg, "tu zimno" ) !== false) {
			$arrtext = array ('Juz rozpalam w kominku *idzie po drewno by po chwili wrocic i rozpalic ogien w kominku. Po chwili przyjemne cieplo ogarnia cale pomieszczenie*', 'Moze wina lub miodu na rozgrzewke?', 'Proponuje udac sie na Arene Walk - troche ruchu i odrazu bedzie Ci cieplej.', 'Brakuje mi drewna *smutny*. Czy przyniesie ktos drewno do kominka?');
			$roll = rand (0, count( $arrtext ) - 1 );
			SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '{$arrtext[$roll]}', '$room')");
		}
		
		if(stripos( $msg, "witam" ) !== false || stripos( $msg, "witajcie" ) !== false) {
			$arrtext = array ('Witam wedrowcze, moze sie czegos napijesz, he?', 'Witam, witam i o trunek pytam *usmiecha sie* co podac?', 'Witaj, witaj *rzucil wrednie* Tylko wchodza i wychodza, a wino musze sam spijac.','Witaj i o nic nie pytaj, tu tak zawsze.','*Widzac wchodzacego mieszkanca* Uwaga ktos przyszedl, reszta wstac i sie ladnie przywitac! He, he.');
			$roll = rand (0, count( $arrtext ) - 1 );
			SqlExec("INSERT INTO chat (`from`, `to`, `msg`, `room`) VALUES('-1', '{$player->id}', '{$arrtext[$roll]}', '$room')");
		}
		break;
	case 'sendInn' :
		//print_r( $_POST );
		
		switch( $_POST['innType'] ) {
			case 'innkeeper' :
				
				$num = -1;
				break;
			case 'barnaba' :
				
				$num =-2;
				break;
			case 'aniela' :
				
				$num = -3;
				break;
			default :
				die();
		}
		$msg = ( $_POST['text'] );
		$msg = iconv("UTF-8", "ISO-8859-2", rawurldecode( $msg ) );
		$msg = strip_tags( $msg );
		//$msg = strip_tags( $_POST['text'] );
		//SqlExec("INSERT INTO chat (user, chat) VALUES('<i>$innType</i>', '$msg')");
		SqlExec( "INSERT INTO chat(`from`,`msg`,`room`) VALUES('$num','$msg','$room')" );
		break;
	case 'clear' :
		SqlExec( "DELETE FROM chat WHERE room='$room'" );
		break;
	case 'ban':
		$id = intval( $_POST['id'] );
		//echo "ban $id";
		$test = SqlExec( "SELECT user FROM players WHERE id=$id" );
		if( $test->fields['user'] ) {
			SqlExec( "INSERT INTO chat_config( `cisza`, `gracz`, `room` ) VALUES('Y', '$id', '$room' )" );
			echo $test->fields['user'];
		}
		break;
	case 'unban' :
		$id = intval( $_POST['id'] );
		$test = SqlExec( "SELECT user FROM players WHERE id=$id" );
		if( $test->fields['user'] ) {
			//SqlExec( "INSERT INTO chat_config( `cisza`, `gracz`, `room` ) VALUES('Y', '$id', '$room' )" );
			SqlExec( "DELETE FROM chat_config WHERE `gracz` = $id AND `room` = '$room'" );
			echo $test->fields['user'];
		}
		break;
	case 'amount' :
		//print_r( $_POST );
		$roomType = $_POST['room_type'];
		$pl = SqlExec("SELECT COUNT(*) AS amount FROM players WHERE page='$roomType' AND lpv > ".( time() - 180 ) );
		echo $pl->fields['amount'];
		break;
}

?>