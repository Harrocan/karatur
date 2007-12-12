<?php

require_once( "ajax_base.php" );

if( empty( $_SESSION['player'] ) ) {
	//err( "SESS_EXPIRE" );
	echo "kupa";
	die();
}

$player =& $_SESSION['player'];
$player->lpv = time();
$room = $_POST['room'];
//echo "\$room2page[ $room ] = {$room2page[$room]}";
//$player->page = "{$room2page[$room]}";

switch( $_POST['type'] ) {
	case 'msg' :
		$msg = SqlExec( "SELECT 
					c.*, p_from.user AS pl_from, p_to.user AS pl_to, r.color AS r_color
				FROM 
					mg_chat c 
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
		$to = array( "<szept>", "<szept>", "</szept>", "</szept>", "<emo>", "<emo>", "</emo>", "</emo>" );
		
		foreach( $msg as $text ) {
			$t = str_replace( $from, $to, $text['msg']  );
			//if( $text['from'] < 0 ) {
			//	$text['r_color'] = '#DEB887';
			///	$text['pl_from'] = "<i>{$spcArr[$text['from']]}</i>";
			//}
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
		$msg = strip_tags( $_POST['text'] );
		$rcol=SqlExec("SELECT color FROM ranks WHERE id={$player->rid}");
		$starter="<span style=\"color:{$rcol->fields['color']}\">".$player -> user."</span>";
		//$czat = $db -> Execute("SELECT gracz FROM chat_config");
		//while (!$czat -> EOF) {
		//	if ($player -> id == $czat -> fields['gracz']) {
		//		echo "ban";
		//		die();
		//	}
		//	$czat -> MoveNext();
		//}
		//$czat -> Close();
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
		//$windu = $player->id;
		//if(( $player->id == '2888') &&( $msg[0] == '^')){
        //      $windu =-1;
		//$msg[0] = ' ';
		//}
		//SqlExec( "INSERT INTO chat(`from`,`to`,`msg`,`room`) VALUES('{$windu}','{$to}','{$msg}','{$room}')" );
		//az dotad
		SqlExec( "INSERT INTO mg_chat(`from`,`to`,`msg`,`room`) VALUES('{$player->id}','{$to}','{$msg}','{$room}')" );	
		
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
	case 'table':
		$timestamp = SqlExec( "SELECT date FROM mg_plot WHERE sess_id={$room} ORDER BY date DESC LIMIT 1" );
		$timestamp = $timestamp->fields['date'];
		$timestamp = strtotime( $timestamp );
		echo $timestamp;
		break;
}

?>